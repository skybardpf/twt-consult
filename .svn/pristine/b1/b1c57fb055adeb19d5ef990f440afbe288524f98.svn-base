<?php
class CommonController extends Site_Common_Controller
{
    public $config = null;

    public function run()
	{
		parent::run();

		zf::addCSS('main', '/public/site/css/main.css');
		zf::addJS('common', '/public/site/js/common.js');
		zf::addCSS('jquery-ui', '/public/site/css/jquery-ui.css');
		zf::addCSS('jquery.pnotify', '/public/site/css/jquery.pnotify.css');
		zf::addJS('jquery.pnotify', '/public/site/js/jquery.pnotify.js');

        zf::addCSS('jquery-ui-1.9.1.custom', '/public/site/css/jquery-ui-1.9.1.custom.css');
        zf::addJS('jquery-ui-1.9.1.custom', '/public/site/js/jquery-ui-1.9.1.custom.js');
//        zf::addJS('jquery-ui-1.9.1.custom', 'http://code.jquery.com/ui/1.10.3/jquery-ui.js');
        zf::addJS('iflabel', '/public/site/js/iflabel.js');

        $this->page->current_url = ltrim($this->app->request->uri, '/');

        //блок контакты
        $settings = $this->model('settings', 'settings')->getValues('name', 'value', 'settings', '', '', '', '');
        $contacts['adress'] = isset($settings['adress']) ? $settings['adress'] : '';
        $contacts['phone'] = isset($settings['phone']) ? $settings['phone'] : '';
        $this->page->contacts = $contacts;
        //блок 25 кадр
        $this->page->frames_25 = $this->model('frames_25', 'frames_25')->getList(
            'frames_25',
            $this->model('frames_25', 'frames_25')->getFieldsNames('frames_25', 'site_list'),
            array(
                'where' => array('active' => 'yes'),
                'order' => array('rand')//'pos' => 'ASC')
            )
        );
        //блок баннеры
        $banners = array();
        $static_banners = $this->model('announcies', 'announcies')->getList(
            'announcies',
            $this->model('announcies', 'announcies')->getFieldsNames('announcies', 'site_list'),
            array(
                'where' => array(
                    'active' => 'yes',
                    'type' => 'banner',
                    'static' => 'yes',
                ),
                'order' => array('pos' => 'ASC'),
                'limit' => 3,
            )
        );
        if (!empty($static_banners)) {
            foreach($static_banners as $ban) {
                if (!isset($banners[$ban['position']])) {
                    $banners[$ban['position']] = $ban;
                }
            }
        }

        if (!isset($banners['top']) || !isset($banners['middle']) || !isset($banners['bottom'])) {
            $tmpbanners = $this->model('announcies', 'announcies')->getList(
                'announcies',
                $this->model('announcies', 'announcies')->getFieldsNames('announcies', 'site_list'),
                array(
                    'where' => array(
                        'static' => 'no',
                        'active' => 'yes',
                        'type' => 'banner'
                    ),
                    'order' => array('rand')//'pos' => 'ASC')
                )
            );
            if (!empty($tmpbanners)) {
                foreach($tmpbanners as $ban) {
                    $tmp = array_diff(array('top', 'moddle', 'bottom'), array_keys($banners));
                    if (!empty($tmp)) {
                        if (!isset($banners[$ban['position']])) {
                            $banners[$ban['position']] = $ban;
                        }
                    } else {
                        break;
                    }
                }
            }
        }


        $this->page->banners = $banners;
            // блок страны
        $this->page->countries = $this->model('countries', 'countries')->getList(
            'countries',
            $this->model('countries', 'countries')->getFieldsNames('countries', 'site_list'),
            array(
                'where' => array(
                    'in_list' => 'yes',
                    'active' => 'yes'
                ),
                'order' => array('rand')//array('pos' => 'ASC')
            )
        );
        // блок меню
        $this->page->main_menu = $this->model('menu', 'menu')->getList(
            'menu',
            $this->model('menu', 'menu')->getFieldsNames('menu', 'site_list'),
            array(
                'where' => array(
                    'active' => 'yes'
                ),
                'order' => array('pos' => 'ASC')
            )
        );
        // блок меню подвала
        $cacher = $this->app->getCacher('.zf_cache/footer_menu', 600);
        $footer_menu = $cacher->get('footer_menu');
        if ($footer_menu == cacher::EXPIRED || $footer_menu == cacher::NO_DATA) {
            $footer_menu = $this->getTree('footer_menu', 'footer_menu');
            $cacher->put('footer_menu', $footer_menu);
        }
        $this->page->footer_menu = $footer_menu;

        // блок сервисы
        $cacher_services = $this->app->getCacher('.zf_cache/services', 600);
        $services = $cacher_services->get('services');
        if ($services == cacher::EXPIRED || $services == cacher::NO_DATA) {
            $services = $this->getTree('services', 'services');
            $cacher_services->put('services', $services);
        }
        $this->page->services = $services;

        // форма заявки на юр. лицо
        if ($this->checkForm_url('entity_url')){
            zf::addCSS('chosen', '/public/site/css/chosen.css');
            zf::addJS('chosen.jquery', '/public/site/js/chosen.jquery.js');
            $this->formEntity_request();
        }
        // форма заявки на открытие счёта
        if ($this->checkForm_url('account_url')){
            zf::addCSS('chosen', '/public/site/css/chosen.css');
            zf::addJS('chosen.jquery', '/public/site/js/chosen.jquery.js');
            $this->formAccount_request();
        }
        // форма заявки на транспортировку
        if ($this->checkForm_url('transport_url'))
            $this->formTransport_request();
        $this->page->logged_site_user = $this->app->session->siteuser ? $this->app->session->siteuser : array();

        $this->config = $this->page->settings;
    }

    public function checkForm_url($form_url_name) {
        $settings = $this->model('settings', 'settings')->getValues('name', 'value', 'settings', '', '', '', '');
        $form_url = array();
        if(isset($settings[$form_url_name]))
            $form_url = explode(",",$settings[$form_url_name]);
        $uri = $this->app->request->uri;
        $in_array = 0;
        if ($form_url) {
            foreach ($form_url as $val) {
                if (trim($val, ' \n') == $uri) {
                    $in_array = 1;
                }
            }
        }
        return $in_array;
    }

    public function soap($func_name, $data) {
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
        $this->model('siteusers')->add_log($data, $func_name);


        $server = (!empty($this->config['server'])) ? $this->config['server'] : 'http://144.76.90.162/TWTsite/ws/Orders?wsdl';
        $login = (!empty($this->config['login'])) ? $this->config['login'] : 'Site';
        $pass = (!empty($this->config['pass'])) ? $this->config['pass'] : 'Site';

        try {
            $client = new SoapClient($server, array('login' => $login, 'password' => $pass, 'trace' => true, 'exceptions' => 1, 'encoding' => 'UTF-8'));
            //$soap_result = $client->__soapCall('CreatePreorderCompany', (array)json_decode($str, true));
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

    public function formEntity_request() {
        zf::addJS('req_forms', '/public/site/js/req_forms.js');
        $user = $this->app->session->siteuser;
        $entity_req_model = $this->model('entity_req', 'entity_req');
        //debug::add_log('/****************************** country_source, country_receiver ********************************/');
        $entity_req_model->initValues(array('country_source', 'country_receiver'));
        $entity_req_model->initValues(array('jur_country_id', 'kind_activities', 'currency_id'), array('jur_country_id' => array('cond' => array('where' => array('in_list'=>'yes', 'active' => 'yes'), 'order' => array('title' => 'ASC')))));
        $data = ($_POST && isset($_POST['entity_form'])) ? $_POST : array('fake'=>0);
        $data = $this->dataMerge($data, $user);
        $elements = $entity_req_model->getFields('entity_req', 'site_form');
        $req = !isset($_POST['step']) || $_POST['step'] == 1 ? 1 : 0;
        $elements['captcha'] = array(
            'name' => 'captcha',
            'title' => 'Введите символы с картинки',
            'type' => 'captcha',
            'req' => $req
        );
        $this->loadForm('entity_req', $elements, $data, '#entity_anchor');
        $errors = array();
        $kind_activities_error = false;
        if ($_POST && !($this->form('entity_req')->elArr['kind_activities']['value']) && !($this->form('entity_req')->elArr['own_kind_activities']['value'])) {
            $kind_activities_error = true;
            $errors['kind_activities'] = 'Хотя бы одно из полей "Род деятельности" или "Свой род деятельности" должно быть заполнено!';
        }

        if (!isset($_POST['step']))
            $this->page->step = 1;
        else {
            if ($this->form('entity_req')->validate($entity_req_model))
                $this->page->step = $_POST['step']+1;
            else
                $this->page->step = $_POST['step'];
        }

        if ($_POST && isset($_POST['entity_form']) && $this->form('entity_req')->validate($this->model('entity_req', 'entity_req')) && !$kind_activities_error && $_POST['step'] == 2) {
            $data = $this->form('entity_req')->getData();//debug::dump($data);
            $data['created'] = date('Y-m-d');
            unset($data['captcha']);
            $jur_country_code = isset($data['jur_country_id']) ? $data['jur_country_id'] : array();
            $country_source_codes = isset($data['country_source']) ? $data['country_source'] : array();
            $country_receiver_codes = isset($data['country_receiver']) ? $data['country_receiver'] : array();
            $kind_activities_titles = isset($data['kind_activities']) ? $data['kind_activities'] : array();
            $jur_country_id = array();
            $country_source_ids = array();
            $country_receiver_ids = array();
            $kind_activities_ids = array();
            $where_cond = array(
                'created' => $data['created'],
                'contact' => $data['contact'],
                //'phone' => $data['phone'],
                'mail' => $data['mail'],
                'company_name' => $data['company_name'],
                'turnover' => $data['turnover'],
                'currency_id' => $data['currency_id']
            );
            if($kind_activities_titles) {
                $kind_activities_ids = $entity_req_model->getValues('id', 'id', 'kind_activities', array('where' => array('title' => array('IN', $kind_activities_titles,'(?l)'))));
                $where_cond['kind_activities.id'] = array('IN', $kind_activities_ids,'(?li)');
            }
            if(isset($data['own_kind_activities']) && $data['own_kind_activities']) {
                $where_cond['own_kind_activities'] = $data['own_kind_activities'];
            }
            if($jur_country_code) {
                $jur_country_id = $entity_req_model->getValues('id', 'id', 'countries', array('where' => array('code' => $jur_country_code, 'in_list' => 'yes', 'active' => 'yes')));
                $jur_country_id = current($jur_country_id);
                $where_cond['jur_country_id'] = $jur_country_id;
            }
            if($country_source_codes) {
                $country_source_ids = $entity_req_model->getValues('id', 'id', 'countries', array('where' => array('code' => array('IN', $country_source_codes,'(?li)'))));
                $where_cond['country_source.id'] = array('IN', $country_source_ids,'(?li)');
            }
            if($country_receiver_codes) {
                $country_receiver_ids = $entity_req_model->getValues('id', 'id', 'countries', array('where' => array('code' => array('IN', $country_receiver_codes,'(?li)'))));
                $where_cond['country_receiver.id'] = array('IN', $country_receiver_ids,'(?li)');
            }
            /*$entity_req = $entity_req_model->GetByCond(
                'entity_req',
                array_merge($entity_req_model->getFieldsNames('entity_req', 'site_form'), array('jurisdiction')),
                array('where' => $where_cond),
                1
            );*/
            /*            //-----------------------------------------------------
                        $currency = $entity_req_model->getValues('id', 'title', 'currencies', array('id' => $data['currency_id']));
                        $KindOfAct = $data['own_kind_activities'] ? array_merge($kind_activities_titles, array($data['own_kind_activities'])) : $kind_activities_titles;
                        $data_1c = array(
                            'ContName'      => $data['contact'],        //– Контактное лицо
                            'ContPhone'     => $data['phone'],          //– Контактный телефон
                            'ContEmail'     => $data['mail'],           //– Контактная почта
                            'Jur'           => $jur_country_code,       //- Юрисдикция
                            'DesTitle'      => $data['company_name'],   //– Желательное наименование
                            'ExpectTurn'    => $data['turnover'],       //– Ожидаемый оборот
                            'Cur'           => $currency[$data['currency_id']],    //– Валюта
                            'KindOfAct'     => $KindOfAct,              //– Род деятельности. Массив элементов – наименований родов деятельности*
                            'Sources'       => $country_source_codes,   //– Страны-источники. Массив элементов – кодов стран**
                            'Recievers'     => $country_receiver_codes  //– Страны-приемники. Массив элементов – кодов стран**'
                        );
                        $ret = $this->soap('CreatePreorderCompany', $data_1c);*/
            //--------------------------------------------------------
            // проверка против дублирования заявок в БД
//            if (!$entity_req) {
            $currency = $entity_req_model->getValues('id', 'title', 'currencies', array('id' => $data['currency_id']));
            $curr = isset($currency[$data['currency_id']]) ? $currency[$data['currency_id']] : '';
            $kind_activities_titles = is_array($kind_activities_titles) ? $kind_activities_titles : array($kind_activities_titles);
            $KindOfAct = $data['own_kind_activities'] ? array_merge($kind_activities_titles, array($data['own_kind_activities'])) : $kind_activities_titles;
            $data_1c = array(
                'ContName'      => $data['contact'],        //– Контактное лицо
                'ContPhone'     => '', //$data['phone'],          //– Контактный телефон
                'ContEmail'     => $data['mail'],           //– Контактная почта
                'Jur'           => $jur_country_code,       //- Юрисдикция
                'DesTitle'      => $data['company_name'],   //– Желательное наименование
                'ExpectTurn'    => $data['turnover'],       //– Ожидаемый оборот
                'Cur'           => $curr,                   //– Валюта
                'KindOfAct'     => $KindOfAct,              //– Род деятельности. Массив элементов – наименований родов деятельности*
                'Sources'       => $country_source_codes,   //– Страны-источники. Массив элементов – кодов стран**
                'Recievers'     => $country_receiver_codes  //– Страны-приемники. Массив элементов – кодов стран**'
            );
            if(empty($data_1c['Sources'])){
                unset($data_1c['Sources']);
            }
            if(empty($data_1c['Recievers'])){
                unset($data_1c['Recievers']);
            }
            $ret = $this->soap('CreatePreorderCompany', $data_1c);
            if (!empty($ret->return) && strlen($ret->return) == 9) {
                $data['req_num'] = $this->page->order1C_id = $ret->return;
                $data['req_status'] = 'yes';
            }

            if (!empty($ret->return)) {
                preg_match_all('~(error)|(0\s)~', $ret->return, $match);
                if (!empty($match[0])){
                    $this->page->error_urid = true;
                }
            } else {
                $this->page->error_urid = true;
            }

            //if (!$this->page->error_urid) {
            /*debug::dump((int)$ret->return);
            debug::dump();*/
            // подмена кодов и значений id

            $data['jur_country_id'] = $jur_country_id;
            $data['kind_activities'] = $kind_activities_ids;
            $data['country_source'] = $country_source_ids;
            $data['country_receiver'] = $country_receiver_ids;
            if (!empty($user)) {
                $data['user_id'] = $user['id'];
            }
            $entity_req_id = $entity_req_model->Save('entity_req', $data);                ///////
            //получение всех полей заявки для письма
            $entity = $entity_req_model->GetByCond(
                'entity_req',
                $entity_req_model->getFieldsNames('entity_req', 'site_mail'),
                array('where' => array('entity_req.id' => $entity_req_id)),
                1
            );
            $kind_activities = '';
            if($entity['kind_activities']) {
                foreach ($entity['kind_activities'] as $so) {
                    $kind_activities .= $so['title'].', ';
                }
                $kind_activities = rtrim($kind_activities, ' ,');
            }
            $country_source = '';
            if($entity['country_source']) {
                foreach ($entity['country_source'] as $so) {
                    $country_source .= $so['title'].', ';
                }
                $country_source = rtrim($country_source, ' ,');
            }
            $country_receiver = '';
            if($entity['country_receiver']) {
                foreach ($entity['country_receiver'] as $so) {
                    $country_receiver .= $so['title'].', ';
                }
                $country_receiver = rtrim($country_receiver, ' ,');
            }
            // отправить письмо
            $settings = $this->page->settings;
            $template['from'] = $settings['from_entity'];
            $template['subject'] = $settings['subject_entity'];
            $template['type'] = $settings['type_entity'];
            $template['message'] = $settings['message_entity'];
            $data_to_send = array(
                'site_name' => $_SERVER['HTTP_HOST'],
                'host' => $_SERVER['HTTP_HOST'],
                'req_id' => isset($data['req_num']) ? $data['req_num'] : '',
                'created' => date('d-m-Y', strtotime($data['created'])),
                'contact' => $data['contact'],
                //'phone' => $data['phone'],
                'mail' => $data['mail'],
                'jurisdiction' => $entity['jurisdiction'],
                'company_name' => $data['company_name'],
                'kind_activities' => $kind_activities,
                'own_kind_activities' => isset($data['own_kind_activities']) ? $data['own_kind_activities'] : '',
                'turnover' => $data['turnover'],
                'currency' =>  $entity['currency'],
                'country_source' => $country_source,
                'country_receiver' => $country_receiver,
            );

            if (!$this->page->error_urid) {
                $this->page->success_entity = true;
                // Письмо на почту заказчика
                if(isset($data['mail']) && $data['mail']) {
                    $entity_req_model->SendMail($data['mail'], $data_to_send, 'message_entity', $template);                ///////
                }
            }
            //}

            $admin_mail = $this->page->settings['email_to_ent'];

            if(!empty($admin_mail)) {
                if (empty($data_to_send)) {
//                        $source = $this->model('countries')->getList('countries', array(), array('code' => array('IN', $data[''])))
                    $jur_country_id = $entity_req_model->getValues('title', 'title', 'countries', array('where' => array('code' => $jur_country_code, 'in_list' => 'yes', 'active' => 'yes')));
                    //debug::dump($jur_country_id);
                    $jur_country_id = current($jur_country_id);
                    /*debug::dump($data);
                    debug::dump($_POST);*/
                    $kind_activities = '';
                    if(!empty($_POST['kind_activities'])) {
                        foreach ($_POST['kind_activities'] as $so) {
                            $kind_activities .= $so.', ';
                        }
                        $kind_activities = rtrim($kind_activities, ' ,');
                    }

                    $country_source = '';
                    if(!empty($_POST['country_source'])) {
                        $data['country_source'] = $entity_req_model->getValues('title', 'title', 'countries', array('where' => array('code' => array('IN', $_POST['country_source'], '(?l)'), 'active' => 'yes')));
                        foreach ($data['country_source'] as $so) {
                            $country_source .= $so.', ';
                        }
                        $country_source = rtrim($country_source, ' ,');
                    }
                    $country_receiver = '';

                    if(!empty($_POST['country_receiver'])) {
                        $data['country_receiver'] = $entity_req_model->getValues('title', 'title', 'countries', array('where' => array('code' => array('IN', $_POST['country_receiver'], '(?l)'), 'active' => 'yes')));
                        foreach ($data['country_receiver'] as $so) {
                            $country_receiver .= $so.', ';
                        }
                        $country_receiver = rtrim($country_receiver, ' ,');
                    }
                    $data_to_send = array(
                        'NO_REST' => 'Заявка пользователя не была добавлена',
                        'site_name' => $_SERVER['HTTP_HOST'],
                        'host' => $_SERVER['HTTP_HOST'],
                        'req_id' => isset($data['req_num']) ? $data['req_num'] : '',
                        'created' => date('d-m-Y', strtotime($data['created'])),
                        'contact' => $data['contact'],
                        //'phone' => $data['phone'],
                        'mail' => $data['mail'],
                        'jurisdiction' => $jur_country_id,
                        'company_name' => $data['company_name'],
                        'kind_activities' => $kind_activities,
                        'own_kind_activities' => isset($data['own_kind_activities']) ? $data['own_kind_activities'] : '',
                        'turnover' => $data['turnover'],
                        'currency' =>  $curr,
                        'country_source' => $country_source,
                        'country_receiver' => $country_receiver,
                    );
                } else {
                    $data_to_send['NO_REST'] = '';
                }
                $data_to_send['json'] = json_encode($data_1c);
                $entity_req_model->SendMail($admin_mail, $data_to_send, 'message_admin');
            }
            /*} else {
                $this->page->success_entity = false;
                $this->page->repeated_entity = true;
            }*/
        } else {
            $errors = $errors + $this->form('entity_req')->getErrors();
            $this->page->errors_entity = $errors;
        }
    }

    public function formAccount_request() {
        zf::addJS('req_forms', '/public/site/js/req_forms.js');
        $user = $this->app->session->siteuser;
        $account_req_model = $this->model('account_req', 'account_req');
        $account_req_model->initValues(array('bank_id', 'sources', 'country_source', 'country_receiver'));
        $data = ($_POST && isset($_POST['account_form'])) ? $_POST : array('fake'=>0);
        $data = $this->dataMerge($data, $user);
        $elements = $account_req_model->getFields('account_req', 'site_form');

        $req = !isset($_POST['step']) || $_POST['step'] == 1 ? 1 : 0;
        $elements['captcha'] = array(
            'name' => 'captcha',
            'title' => 'Введите символы с картинки',
            'type' => 'captcha',
            'req' => $req
        );
        if (!empty($_POST) && isset($_POST['account_form'])) {
            if(isset($_POST['bank_id']) && $_POST['bank_id']) {
                if(is_array($_POST['bank_id'])) {
                    foreach($_POST['bank_id'] as $k => $v) {
                        $elements['bank_id']['value'] = $v;
                        $elements["bank_id[{$k}]"] = $elements['bank_id'];
                        //$elements["bank_id[{$k}]"]['value'] = $v;
                        $elements["currency_id[{$k}]"] = $elements['currency_id'];
                        $val = $this->model('banks', 'banks')->initCurrencyValues($v);
                        $elements["currency_id[{$k}]"]['values'] = $val['currencies'];
                        $elements["currency_id"]['values'] = $val['currencies'];

                        $elements['bank'][$k] = $elements['bank_id'];
                        $elements["currency"][$k]['values'] = $val['currencies'];
                    }
                } else {
                    $val = $this->model('banks', 'banks')->initCurrencyValues($_POST['bank_id']);
                    $elements["currency_id"]['values'] = $val['currencies'];
                }
            }
            if(isset($_POST['currency_id'])) {
                if(is_array($_POST['currency_id'])) {
                    foreach($_POST['currency_id'] as $k => $v){
                        $elements["currency_id"]['value'] = $v;
                        $elements["currency_id[{$k}]"]['value'] = $v;

                        $elements["currency"][$k]['value'] = $v;
                    }
                } else {
                    $elements["currency_id"]['value'] = $_POST['currency_id'];
                }
            }
        }
        $this->loadForm('account_req', $elements, $data, '#account_anchor');
        $errors = array();
        $sources_error = false;
        if ($_POST && !($this->form('account_req')->elArr['sources']['value']) && !($this->form('account_req')->elArr['own_sources']['value'])) {
            $sources_error = true;
            $errors['sources'] = 'Хотя бы одно из полей "Источники происхождения ДС" или "Свои источники происхождения ДС" должно быть заполнено!';
        }

        if (!isset($_POST['step']))
            $this->page->step = 1;
        else {
            if ($this->form('account_req')->validate($account_req_model))
                $this->page->step = $_POST['step']+1;
            else
                $this->page->step = $_POST['step'];
        }

        if ($_POST && isset($_POST['account_form']) && $this->form('account_req')->validate($this->model('account_req', 'account_req')) && !$sources_error && $_POST['step'] == 2) {
            $data = $this->form('account_req')->getData();
            $data['created'] = date('Y-m-d');
            unset($data['captcha']);
            $banks_codes = array();
            //$currencies_codes = array();
            //$banks_titles = array();
            $currencies_titles = array();
            $country_source_codes = isset($data['country_source']) ? $data['country_source'] : array();
            $country_receiver_codes = isset($data['country_receiver']) ? $data['country_receiver'] : array();
            $sources_titles = isset($data['sources']) ? $data['sources'] : array();
            $banks_ids = is_array($data['bank_id']) ? $data['bank_id'] : array('0' => $data['bank_id']);
            $currencies_ids = is_array($data['currency_id']) ? $data['currency_id'] : array('0' => $data['currency_id']);
            $country_source_ids = array();
            $country_receiver_ids = array();
            $sources_ids = array();
            $where_cond = array(
                'created' => $data['created'],
                'contact' => $data['contact'],
                // 'phone' => $data['phone'],
                'mail' => $data['mail'],
                'turnover' => $data['turnover'],
            );
            if($banks_ids) {
                debug::add_log("<b>Значения банков</b>", 'Банки');
                $banks_tmp = $account_req_model->getValues('id', 'code', 'banks', array('where' => array('id' => array('IN', $banks_ids,'(?li)'))));
                foreach ($banks_ids as $key => $b_id)
                    $banks_codes[$key] = $banks_tmp[$b_id];
            }
            /*if($currencies_ids) {
                $currencies_tmp = $account_req_model->getValues('id', 'code', 'currencies', array('where' => array('id' => array('IN', $currencies_ids,'(?li)'))));
                foreach ($currencies_ids as $key => $c_id)
                    $currencies_codes[$key] = $currencies_tmp[$c_id];
            }
            if($banks_ids) {
                $banks_tmp = $account_req_model->getValues('id', 'title', 'banks', array('where' => array('id' => array('IN', $banks_ids,'(?li)'))));
                foreach ($banks_ids as $key => $b_id)
                    $banks_titles[$key] = $banks_tmp[$b_id];
            }*/
            if($currencies_ids) {
                debug::add_log("<b>Значения валют</b>", 'Валюта');
                $currencies_tmp = $account_req_model->getValues('id', 'title', 'currencies', array('where' => array('id' => array('IN', $currencies_ids,'(?li)'))));
                foreach ($currencies_ids as $key => $c_id)
                    $currencies_titles[$key] = $currencies_tmp[$c_id];
            }
            if($sources_titles) {
                $sources_ids = $account_req_model->getValues('id', 'id', 'sources', array('where' => array('title' => array('IN', $sources_titles,'(?l)'))));
                $where_cond['sources.id'] = array('IN', $sources_ids,'(?li)');
            }
            if(isset($data['own_sources']) && $data['own_sources']) {
                $where_cond['own_sources'] = (isset($data['own_sources']) && $data['own_sources']) ? $data['own_sources'] : '';
            }
            if($country_source_codes) {
                $country_source_ids = $account_req_model->getValues('id', 'id', 'countries', array('where' => array('code' => array('IN', $country_source_codes,'(?li)'))));
                $where_cond['country_source.id'] = array('IN', $country_source_ids,'(?li)');
            }
            if($country_receiver_codes) {
                $country_receiver_ids = $account_req_model->getValues('id', 'id', 'countries', array('where' => array('code' => array('IN', $country_receiver_codes,'(?li)'))));
                $where_cond['country_receiver.id'] = array('IN', $country_receiver_ids,'(?li)');
            }
            /*$account_req = $account_req_model->GetByCond(
                'account_req',
                $account_req_model->getFieldsNames('account_req', 'site_form_check'),
                array('where' => $where_cond),
                1
            );*/
            //--------------------------------------------------------------
/*            // подготовка данных для 1С
            $sources = $data['own_sources'] ? array_merge($sources_titles, array($data['own_sources'])) : $sources_titles;
            $data_1c = array(
                'ContName'          => $data['contact'],        //– Контактное лицо
                'ContPhone'         => $data['phone'],          //– Контактный телефон
                'ContEmail'         => $data['mail'],           //– Контактная почта
                'Bank'              => $banks_codes,            //$banks_titles,  //- SWIFT-код банка. Массив элементов – кодов банков
                'Cur'               => $currencies_titles,      //$currencies_codes, //– Валюта счета. Массив элементов – кодов валют
                'ExpectTurn'        => $data['turnover'],       //– Ожидаемый оборот
                'Sources'           => $data['country_source'], //– Страны-источники. Массив элементов – кодов стран**
                'Recievers'         => $data['country_receiver'],//– Страны-приемники. Массив элементов – кодов стран**'
                'SourcesOfMoney'    => $sources                 //– Источники происхождения ДС.
            );
            $ret = $this->soap('CreatePreorderAccount', $data_1c);*/
            //--------------------------------------------------------------
            // проверка против дублирования заявок в БД
            //if (!$account_req) {
                // подготовка данных для 1С
                $sources_titles = is_array($sources_titles) ? $sources_titles : array($sources_titles);
                $sources = $data['own_sources'] ? array_merge($sources_titles, array($data['own_sources'])) : $sources_titles;
                $data_1c = array(
                    'ContName'          => $data['contact'],        //– Контактное лицо
                    'ContPhone'         => '',//$data['phone'],          //– Контактный телефон
                    'ContEmail'         => $data['mail'],           //– Контактная почта
                    'Bank'              => $banks_codes,            //$banks_titles,  //- SWIFT-код банка. Массив элементов – кодов банков
                    'Cur'               => $currencies_titles,      //$currencies_codes, //– Валюта счета. Массив элементов – кодов валют
                    'ExpectTurn'        => $data['turnover'],       //– Ожидаемый оборот
                    'Sources'           => $data['country_source'], //– Страны-источники. Массив элементов – кодов стран**
                    'Recievers'         => $data['country_receiver'],//– Страны-приемники. Массив элементов – кодов стран**'
                    'SourcesOfMoney'    => $sources                 //– Источники происхождения ДС.
                );
            if(empty($data_1c['Sources'])){
                unset($data_1c['Sources']);
            }
            if(empty($data_1c['Recievers'])){
                unset($data_1c['Recievers']);
            }
                $ret = $this->soap('CreatePreorderAccount', $data_1c);

                if (!empty($ret->return) && strlen($ret->return) == 9) {
                    $data['req_num'] = $this->page->order1C_id = $ret->return;
                    $data['req_status'] = 'yes';
                }

                if (!empty($ret->return)) {
                    preg_match_all('~(error)|(0\s)~', $ret->return, $match);
                    if (!empty($match[0])){
                        $this->page->error_accaunt = true;
                    }
                } else {
                    $this->page->error_accaunt = true;
                }

                //if (!$this->page->error_accaunt) {
                    foreach($data as $key=>$val) {
                        if(strpos($key, 'bank_id') === 0 || strpos($key, 'currency_id') === 0) {
                            unset($data[$key]);
                        }
                    }
                    // подмена кодов и значений id
                    $data['country_source'] = $country_source_ids;
                    $data['country_receiver'] = $country_receiver_ids;
                    $data['sources'] = $sources_ids;
                    if (!empty($user)) {
                        $data['user_id'] = $user['id'];
                    }
                    $account_req_id = $account_req_model->Save('account_req', $data);
                    if (is_array($banks_ids)) {
                        foreach($banks_ids as $k => $v) {
                            if($v)
                                $account_req_model->Save('accounts', array('account_req_id' => $account_req_id, 'bank_id' => $v, 'currency_id' => $currencies_ids[$k]));
                        }
                    } elseif(!empty($banks_ids)) {
                        $account_req_model->Save('accounts', array('account_req_id' => $account_req_id, 'bank_id' => $banks_ids, 'currency_id' => $currencies_ids));
                        $banks_ids = array('0' => $banks_ids);
                        $currencies_ids = array('0' => $currencies_ids);
                    }
                    //получение всех полей заявки для письма
                    $account_r = $account_req_model->GetByCond(
                        'account_req',
                        $account_req_model->getFieldsNames('account_req', 'site_mail'),
                        array('where' => array('account_req.id' => $account_req_id)),
                        1
                    );
                    $banks_tmp = $account_req_model->getValues('id', 'title', 'banks', array('where' => array('banks.id' => array('IN', $banks_ids, '(?li)'))));
                    $currencies_tmp = $account_req_model->getValues('id', 'title', 'currencies', array('where' => array('currencies.id' => array('IN', $currencies_ids, '(?li)'))));
                    $banks2mail = '';
                    foreach ($banks_ids as $key => $b_id) {
                        $currency_id = $currencies_ids[$key];
                        $banks2mail .= '<br>'.'Банк: '.$banks_tmp[$b_id].' Валюта: '.$currencies_tmp[$currency_id];
                    }
                    $country_source = '';
                    if($account_r['country_source']) {
                        foreach ($account_r['country_source'] as $so) {
                            $country_source .= $so['title'].', ';
                        }
                        $country_source = rtrim($country_source, ' ,');
                    }
                    $country_receiver = '';
                    if($account_r['country_receiver']) {
                        foreach ($account_r['country_receiver'] as $so) {
                            $country_receiver .= $so['title'].', ';
                        }
                        $country_receiver = rtrim($country_receiver, ' ,');
                    }
                    $sources = '';
                    if($account_r['sources']) {
                        foreach ($account_r['sources'] as $so) {
                            $sources .= $so['title'].', ';
                        }
                        $sources = rtrim($sources, ' ,');
                    }

                    // отправить письмо
                    $settings = $this->page->settings;
                    $template['from'] = $settings['from_account'];
                    $template['subject'] = $settings['subject_account'];
                    $template['type'] = $settings['type_account'];
                    $template['message'] = $settings['message_account'];
                    $admin_mail = $this->page->settings['email_to_acc'];
                    $data_to_send = array(
                        'site_name' => $_SERVER['HTTP_HOST'],
                        'host' => $_SERVER['HTTP_HOST'],
                        'req_id' => isset($data['req_num']) ? $data['req_num'] : '',
                        'created' => date('d-m-Y', strtotime($data['created'])),
                        'contact' => $data['contact'],
                        //'phone' => $data['phone'],
                        'mail' => $data['mail'],
                        'accounts' => $banks2mail,
                        'turnover' => $data['turnover'],
                        'country_source' => $country_source,
                        'country_receiver' => $country_receiver,
                        'sources' => $sources,
                        'own_sources' => isset($data['own_sources']) ? $data['own_sources'] : '',
                    );

                    /*if(!empty($admin_mail)) {
                        $data_to_send['json'] = json_encode($data_1c);
                        $account_req_model->SendMail($admin_mail, $data_to_send, 'message_admin');
                    }*/
                    if (!$this->page->error_accaunt) {
                        $this->page->success_account = true;
                        // Письмо на почту заказчика
                        if(isset($data['mail']) && $data['mail']) {
                            $account_req_model->SendMail($data['mail'], $data_to_send, 'message_account', $template);
                        }
                    }
                //}
                $admin_mail = $this->page->settings['email_to_acc'];

                if(!empty($admin_mail)) {
                    if (empty($data_to_send)) {
                        /*debug::dump($data);
                        debug::dump($_POST);*/

                        $sources = '';
                        if(!empty($_POST['sources'])) {
                            foreach ($_POST['sources'] as $so) {
                                $sources .= $so.', ';
                            }
                            $sources = rtrim($sources, ' ,');
                        }

                        $banks2mail = '';
                        foreach ($banks_ids as $key => $b_id) {
                            $currency_id = $currencies_ids[$key];
                            $banks2mail .= '<br>'.'Банк: '.$banks_tmp[$b_id].' Валюта: '.$currencies_tmp[$currency_id];
                        }

                        $country_source = '';
                        if(!empty($_POST['country_source'])) {
                            $data['country_source'] = $account_req_model->getValues('title', 'title', 'countries', array('where' => array('code' => array('IN', $_POST['country_source'], '(?l)'), 'active' => 'yes')));
                            foreach ($data['country_source'] as $so) {
                                $country_source .= $so.', ';
                            }
                            $country_source = rtrim($country_source, ' ,');
                        }
                        $country_receiver = '';

                        if(!empty($_POST['country_receiver'])) {
                            $data['country_receiver'] = $account_req_model->getValues('title', 'title', 'countries', array('where' => array('code' => array('IN', $_POST['country_receiver'], '(?l)'), 'active' => 'yes')));
                            foreach ($data['country_receiver'] as $so) {
                                $country_receiver .= $so.', ';
                            }
                            $country_receiver = rtrim($country_receiver, ' ,');
                        }
                        $data_to_send = array(
                            'NO_REST' => 'Заявка пользователя не была добавлена',
                            'site_name' => $_SERVER['HTTP_HOST'],
                            'host' => $_SERVER['HTTP_HOST'],
                            'req_id' => isset($data['req_num']) ? $data['req_num'] : '',
                            'created' => date('d-m-Y', strtotime($data['created'])),
                            'contact' => $data['contact'],
                            //'phone' => $data['phone'],
                            'mail' => $data['mail'],
                            'accounts' => $banks2mail,
                            'turnover' => $data['turnover'],
                            'country_source' => $country_source,
                            'country_receiver' => $country_receiver,
                            'sources' => $sources,
                            'own_sources' => isset($data['own_sources']) ? $data['own_sources'] : '',
                        );
                    } else {
                        $data_to_send['NO_REST'] = '';
                    }
                    $data_to_send['json'] = json_encode($data_1c);
                    $account_req_model->SendMail($admin_mail, $data_to_send, 'message_admin');
                }
            /*} else {
                $this->page->success_account = false;
                $this->page->repeated_account = true;
            }*/
        } else {
            $errors = $errors + $this->form('account_req')->getErrors();
            $this->page->errors_account = $errors;
        }
    }

    public function formTransport_request() {
        zf::addJS('req_forms', '/public/site/js/req_forms.js');
        $user = $this->app->session->siteuser;
        $this->model('transport_req')->initValues(
            array('loading_country', 'delivery_country', 'currency', 'services'),
            array(
                'services' => array('keyField' => 'title'),
                'currency' => array('keyField' => 'title')
            )
        );
        $transport_req_model = $this->model('transport_req', 'transport_req');
        $data = ($_POST && isset($_POST['transport_form'])) ? $_POST : array('fake'=>0);
        $data = $this->dataMerge($data, $user);

        $elements = $transport_req_model->getFields('transport_req', 'site_form');

        $req = !isset($_POST['step']) || $_POST['step'] == 1 ? 1 : 0;
        $elements['captcha'] = array(
            'name' => 'captcha',
            'title' => 'Введите символы с картинки',
            'type' => 'captcha',
            'req' => $req,
        );
        $this->loadForm('transport_req', $elements, $data, '#transport_anchor');

        if (!isset($_POST['step']))
            $this->page->step = 1;
        else {
            if ($this->form('transport_req')->validate($transport_req_model))
                $this->page->step = $_POST['step']+1;
            else
                $this->page->step = $_POST['step'];
        }

        if ($_POST && isset($_POST['transport_form']) && $this->form('transport_req')->validate($transport_req_model) && $_POST['step'] == 2)
        {
            $data = $this->form('transport_req')->getData();
            $data['created'] = date('Y-m-d');
            unset($data['captcha']);
            $currency = $transport_req_model->GetByCond('currencies', array('id', 'title'), array('title' => $data['currency']), 1);
            $where_cond = array(
                'contact' => $data['contact'],
                //'phone' => $data['phone'],
                'mail' => $data['mail'],
                'cargo_name' => $data['cargo_name'],
                'cost' => $data['cost'],
                'currency' => $currency['id']
            );
            /*$transport_req = $transport_req_model->GetByCond(
                'transport_req',
                $transport_req_model->getFieldsNames('transport_req', 'site_form_check'),
                array('where' => $where_cond),
                1
            );*/
            // проверка против дублирования заявок в БД
            //if (!$transport_req) {
                $data_1c = array(
                    'ContName'      => $data['contact'],        //– Контактное лицо
                    'ContPhone'     => '', //$data['phone'],          //– Контактный телефон
                    'ContEmail'     => $data['mail'],           //– Контактная почта
                    'Cur'           => $data['currency'],       //- Валюта
                    'Cost'          => $data['cost'],           //- Стоимость груза
                    'Goods'      => $data['cargo_name'],     //- Наименование груза
                    'Needs'         => $data['services'], //- Дополнительная информация о погрузке, пожелания
                );
                if(empty($data_1c['Needs'])){
                    unset($data_1c['Needs']);
                }
                $ret = $this->soap('CreatePreorderCustom', $data_1c);
                /*debug::dump($ret);
                debug::dump(json_encode($data_1c));
                debug::dump(($data_1c));
                exit;*/
                if (!empty($ret->return) && strlen($ret->return) == 9) {
                    $data['req_num'] = $this->page->order1C_id = $ret->return;
                    $data['req_status'] = 'yes';
                }

                if (!empty($ret->return)) {
                    preg_match_all('~(error)~', $ret->return, $match);
                    if (!empty($match[0])){
                        $this->page->error_transport = true;
                    }
                } else {
                    $this->page->error_transport = true;
                }

//                if (!$this->page->error_transport) {
                    /*debug::dump($ret);
                debug::dump(preg_match_all('~(error)~', $ret->return, $math));
                debug::dump($math);
                debug::dump(($ret->return));
                exit;*/
                    $data['currency'] = $currency['id'];

                    //$services = $transport_req_model->getList('additional', array('id'), array('where' => array('title' => array('IN', $data['services'], '(?li)'))));
                    if (!empty($data['services'])) {
                        $services = $data['services'];

                        $data['services'] = $transport_req_model->getValues('id', 'id', 'additional', array('where' => array('title' => array('IN', $data['services'], '(?l)'))));
                    } else {
                        $services = null;
                    }


                    if (!empty($user)) {
                        $data['user_id'] = $user['id'];
                    }
                    $transport_req_id = $transport_req_model->Save('transport_req', $data);

                    //получение всех полей заявки для письма
                    $transport = $transport_req_model->GetByCond(
                        'transport_req',
                        $transport_req_model->getFieldsNames('transport_req', 'site_mail'),
                        array('where' => array('transport_req.id' => $transport_req_id)),
                        1
                    );
                    // отправить письмо
                    $settings = $this->page->settings;
                    $template['from'] = $settings['from_transport'];
                    $template['subject'] = $settings['subject_transport'];
                    $template['type'] = $settings['type_transport'];
                    $template['message'] = $settings['message_transport'];
                    $admin_mail = $this->page->settings['email_to_transp'];
                    $data_to_send = array(
                        'site_name' => $_SERVER['HTTP_HOST'],
                        'host' => $_SERVER['HTTP_HOST'],
                        'transp_id' => isset($data['req_num']) ? $data['req_num'] : '',
                        'created' => date('d-m-Y', strtotime($data['created'])),
                        'contact' => $data['contact'],
                        //'phone' => $data['phone'],
                        'mail' => $data['mail'],
                        'cargo_name' => $data['cargo_name'],
                        'cost' => $data['cost'],
                        'currency' => $currency['title'],
                        'services' => !empty($services) ? implode(', ', $services) : '',
                    );

                    /*if(!empty($admin_mail)) {
                        $data_to_send['json'] = json_encode($data_1c);
                        $transport_req_model->SendMail($admin_mail, $data_to_send, 'message_admin');
                    }*/
                    if (!$this->page->error_transport) {
                        $this->page->success_transport = true;
                        // Письмо на почту заказчика
                        if(isset($data['mail']) && $data['mail']) {
                            $transport_req_model->SendMail($data['mail'], $data_to_send, 'message_transport', $template);
                        }
                    }
//                }
                $admin_mail = $this->page->settings['email_to_transp'];

                if(!empty($admin_mail)) {
                    if (empty($data_to_send)) {
                        /*debug::dump($data);
                        debug::dump($_POST);*/
                        $services = (!empty($_POST['services']) ? $_POST['services'] : '');

                        $data_to_send = array(
                            'NO_REST' => 'Заявка пользователя не была добавлена',
                            'site_name' => $_SERVER['HTTP_HOST'],
                            'host' => $_SERVER['HTTP_HOST'],
                            'transp_id' => isset($data['req_num']) ? $data['req_num'] : '',
                            'created' => date('d-m-Y', strtotime($data['created'])),
                            'contact' => $data['contact'],
                            //'phone' => $data['phone'],
                            'mail' => $data['mail'],
                            'cargo_name' => $data['cargo_name'],
                            'cost' => $data['cost'],
                            'currency' => $currency['title'],
                            'services' => !empty($services) ? implode(', ', $services) : '',
                        );
                    } else {
                        $data_to_send['NO_REST'] = '';
                    }
                    $data_to_send['json'] = json_encode($data_1c);
                    $transport_req_model->SendMail($admin_mail, $data_to_send, 'message_admin');
                }
            /*} else {
                $this->page->success_transport = false;
                $this->page->repeated_transport = true;
            }*/
        } else {
            $this->page->errors_transport = $this->form('transport_req')->getErrors();
        }
    }

    public function dataMerge($data, $user) {
        if (!empty($user)) {
            if (empty($data['contact']))
                $data['contact'] = $user['name'];
            if (empty($data['mail']))
                $data['mail'] = $user['email'];
        }
        return $data;
    }

    public function getTree($model_name, $table_name, $field_pid = 'pid', $field_pos = 'pos', $field_active = 'active') {
        // блок меню
        $model = $this->model($model_name, $model_name);
        $first_level = $model->getList(
            $table_name,
            $model->getFieldsNames($table_name, 'site_list'),
            array(
                'where' => array(
                    $table_name.'.'.$field_pid => 0,
                    $table_name.'.'.$field_active => 'yes'
                ),
                'order' => array($table_name.'.'.$field_pos => 'ASC')
            )
        );
        $tmp = $this->getAllIndex($first_level);
        if ($first_level) {
            foreach ($first_level as $f) {
                $this->get_branch($f['id'], $tmp, $model_name, $table_name, $field_pid, $field_pos, $field_active);
            }
        }
        return $tmp;
    }

    public function getAllIndex($sth, $key = 'id') {
        $result = false;
        if(is_array($sth)) {
            foreach ($sth as $row) {
                $row['url'] = trim($row['url']);
                $result[$row[$key]] = $row;
            }
        }
        return is_array($result) ? $result : FALSE;
    }

    public function get_branch($pid, &$tmp, $model_name, $table_name, $field_pid = 'pid', $field_pos = 'pos', $field_active = 'active') {
        $model = $this->model($model_name, $model_name);
        $branch = $model->getList(
            $table_name,
            $model->getFieldsNames($table_name, 'site_list'),
            array(
                'where' => array(
                    $table_name.'.'.$field_pid => $pid,
                    $table_name.'.'.$field_active => 'yes'
                ),
                'order' => array($table_name.'.'.$field_pos => 'ASC')
            )
        );
        if ($branch) {
            foreach ( $branch as $row ) {
                if ($row['pid'] == 0) {
                    $row['url'] = trim($row['url']);
                    $tmp[$row['id']] = $row;
                    $this->get_branch( $row['id'], $tmp, $model_name, $table_name, $field_pid, $field_pos, $field_active);
                } else {
                    $tmp[$pid]['children'][$row['id']] = $row;
                    $this->get_branch( $row['id'], $tmp[$pid]['children'], $model_name, $table_name, $field_pid, $field_pos, $field_active);
                }
            }
        }
    }
}
?>
