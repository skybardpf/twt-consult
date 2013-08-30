<?php
class SiteusersModel extends CMS_Model
{
    protected $valuesConf = array(
        'user_id' => array(
            'keyField'   => 'id',
            'titleField' => 'name',
            'tableName'  => 'siteusers',
            'cond'       => array('order' => array('name' => 'asc'))
        )
    );

    public function validatorInnInt($field, $value, $param) {
        $ret = true;
        preg_match('|\d+|', $value, $inn);
        if (!empty($inn)) {
            if (strlen($inn[0]) < 10 || strlen($inn[0]) > 12) {
                $ret = false;
            }
        }
        return $ret;
    }

    public function validatorKppInt($field, $value, $param) {
        $ret = true;
        preg_match('|\d+|', $value, $kpp);
        if (!empty($kpp)) {
            if (strlen($kpp[0]) != 9) {
                $ret = false;
            }
        }
        return $ret;
    }

    public function json_encode_cyr($data) {
        $arr_replace_utf = array('\u0410', '\u0430','\u0411','\u0431','\u0412','\u0432',
            '\u0413','\u0433','\u0414','\u0434','\u0415','\u0435','\u0401','\u0451','\u0416',
            '\u0436','\u0417','\u0437','\u0418','\u0438','\u0419','\u0439','\u041a','\u043a',
            '\u041b','\u043b','\u041c','\u043c','\u041d','\u043d','\u041e','\u043e','\u041f',
            '\u043f','\u0420','\u0440','\u0421','\u0441','\u0422','\u0442','\u0423','\u0443',
            '\u0424','\u0444','\u0425','\u0445','\u0426','\u0446','\u0427','\u0447','\u0428',
            '\u0448','\u0429','\u0449','\u042a','\u044a','\u042b','\u044b','\u042c','\u044c',
            '\u042d','\u044d','\u042e','\u044e','\u042f','\u044f');
        $arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
            'Ё', 'ё', 'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о',
            'П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш',
            'Щ','щ','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я');
        $str = json_encode($data);
        $str2 = str_replace($arr_replace_utf,$arr_replace_cyr,$str);
        return $str2;
    }

    public function add_log($data, $func_name) {
        if (preg_match("/(^local\.)|(^www\.local\.)/", $_SERVER['HTTP_HOST'])) {
            $file_name = '../logs/soap_log.log';
        } elseif (preg_match("/(\.artektiv\.)/", $_SERVER['HTTP_HOST'])) {
            $file_name = 'logs/soap_log.log';
        } else {
            $file_name = 'logs/soap_log.log';
        }

        $log_string = date('d-m-Y H:i:s')." $func_name: ".$this->json_encode_cyr($data)."\n";
        $max_file_size = 51200;
        $offset = 0;
        if (file_exists($file_name)) {
            $offset = (filesize($file_name) > $max_file_size) ? strlen($log_string) : 0;
            $res = file_put_contents($file_name, file_get_contents($file_name, NULL, NULL, $offset).$log_string);
        } else {
            $res = file_put_contents($file_name, $log_string);
        }
    }

    public function soap($func_name, $data, $erp = false, $config) {
        // Замена пробелов на нижнее подчеркивание
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                foreach($val as $k => $v) {
                    $data[$key][$k] = str_replace(' ', '_', $v);
                }
            } else {
                $data[$key] = str_replace(' ', '_', $val);
            }
        }
        //debug::dump($data);
        //debug::dump(json_encode($data));
        $this->add_log($data, $func_name);

        if ($erp) {
            $server = (!empty($config['erp_server'])) ? $config['erp_server'] : 'http://144.76.90.162/twt_erp/ws/erp?wsdl';
            $login = (!empty($config['erp_login'])) ? $config['erp_login'] : 'Site';
            $pass = (!empty($config['erp_pass'])) ? $config['erp_pass'] : 'Site';
        } else {
            $server = (!empty($config['calc_server'])) ? $config['calc_server'] : 'http://144.76.90.162/TWTsite/ws/CalcIns?wsdl'; //'http://144.76.90.162/testmakarov/ws/CalcIns?wsdl'
            $login = (!empty($config['calc_login'])) ? $config['calc_login'] : 'Site';
            $pass = (!empty($config['calc_pass'])) ? $config['calc_pass'] : 'Site';
        }
        try {
            ini_set('soap.wsdl_cache_enabled', false);

            $client = new SoapClient($server, array('login' => $login, 'password' => $pass, 'trace' => true, 'exceptions' => 1, 'encoding' => 'UTF-8'));
            //$soap_result = $client->__soapCall('CreatePreorderCompany', (array)json_decode($str, true));
//            debug::dump($server);
            $soap_result = $client->$func_name($data);

        } catch (Exception $e) {
            $soap_result = null;
            debug::add_log("<b>{$e->getMessage()}</b>");
            //print_r($e->getMessage());
        }
        if (!empty($soap_result->return)) {
            debug::add_log("<b>soap_result1: " . (json_encode($data)) . "</b>");
            debug::add_log("<b>soap_result1: {$soap_result->return}</b>");
        }

        return $soap_result;
    }

    /**
     * Список Единиц измерения мест
     *
     * @return array|bool|mixed
     */
    public function getSeatMeasures($config) {
        $cacher = $this->ctrl->app->getCacher('.zf_cache/Calc_seat_measures', 3000);
        $soap = $cacher->get('Calc_seat_measures');
        if ($soap == cacher::EXPIRED || $soap == cacher::NO_DATA) {
            $soap = null;
            debug::add('Последний журнал для кеша. ($soap)', 'cache');
            $tmp = $this->soap('GetMeasureOfSeat', array(), false, $config);
            $tmp = $this->model('calculator_req')->parseReturn($tmp);
            if ($tmp) {
                foreach ($tmp as $elem) {
                    $soap[key($elem)] = current($elem);
                }
            }
            asort($soap);
            $cacher->put('Calc_seat_measures', $soap, 3000);
        } else {
            debug::add('Последний журнал для шапки из кеша. ($soap)', 'cache');
        }

        return $soap;
    }

    /**
     * Список доступных значений Стран
     * id => name
     *
     * @return array
     */
    public function getCountries($config) {
        $request = array('filters' => array(), 'sort' => array(0 => array()));

        $ret = $this->soap('listCountries', $request, 1, $config);
        $ret = $this->model('calculator_req')->parseReturn($ret);
        $soap = null;
        if (!empty($ret)) {
            foreach($ret as $r) {
                $soap[$r->name] = $r;
            }
        }
        ksort($soap);
        return $soap;
    }

    /**
     * Список Городов страны
     *
     * @param $country_id
     *
     * @return mixed
     */
    public function getCitiesList($country_id, $config) {
        $cacher = $this->ctrl->app->getCacher('.zf_cache/Calc_cities', 3000);
        $soap = $cacher->get('Calc_cities_'.$country_id);
        if ($soap == cacher::EXPIRED || $soap == cacher::NO_DATA) {
            $soap = null;
            debug::add('Последний журнал для кеша. ($soap)', 'cache');
            $tmp = $this->soap('getCities', array('id' => $country_id), false, $config);
            $tmp = $this->model('calculator_req')->parseReturn($tmp);
            if ($tmp) {
                foreach ($tmp as $elem) {
                    $soap[key($elem)] = current($elem);
                }
            }
            if (is_array($soap)) {
                asort($soap);
            }

            $cacher->put('Calc_cities_'.$country_id, $soap, 3000);
        } else {
            debug::add('Последний журнал для шапки из кеша. ($soap)', 'cache');
        }
        return $soap;
    }

}
?>