<?php
class CMS_Model extends AdvancedModel
{
	/*	protected function OnBeforeCompile(&$conf)
	 {
		foreach ($conf['tables'] as $tableName => $table) {
		$conf['tables'][$tableName]['use_list'] = array();
		foreach ($table['fields'] as $fieldName => $field) {
		if (!empty($field['am']['use_list'])) {
		$conf['tables'][$tableName]['use_list'][] = $fieldName;
		}
		}
		}
		}  */
	
	public function modifyFromList($tableName, $field, $values){
		if(is_array($values) && !empty($values)) foreach($values as $id=>$val)
			$this->db->query("UPDATE ?t SET ?t=? WHERE id=?d", $tableName, $field, $val, $id);
	}
	
	public function getList($tableName, $fields, $cond = array(), $additionalSql = '', $additionalArgs = array(), $fSQL = '')
	{
		if (is_string($fields) and !empty($fields)) {
			$fields = $this->getFieldsNames($tableName, $fields);
		}
		return parent::getList($tableName, $fields, $cond, $additionalSql, $additionalArgs, $fSQL);
	}
	
	public function GetByCond($tableName, $fields = array(), $cond = array(), $force = 0)
	{
		if (is_string($fields) and !empty($fields)) {
			$fields = $this->getFieldsNames($tableName, $fields);
		}
		return parent::GetByCond($tableName, $fields, $cond, $force);
	}
	
	public function getFields($tableName, $actionOrFields, $calledFromPrepareData = 0)
	{
		return parent::getFields($tableName, $actionOrFields, 0);
		/*$ret = parent::getFields($tableName, $actionOrFields);
		 return $ret;   */
	}

	public function SendMail($to, $data, $conf_section = 'main', $template = array())
	{
        $conf = $template ? $template : $this->conf['mail'][$conf_section];
		$replace = array(
			'main' => array(
				'search'  => array(
					'[HTTP_HOST]',
					'[DATE]',
					'[REMOTE_ADDR]',
					'[REMOTE_PORT]'
				),
				'replace' => array(
					isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '',
					date($this->conf['mail']['date_format']),
					isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
					isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : ''
				)
			),
		);
		$data_search = $data_replace = array();
		foreach ($data as $key=>$value) {
			if (!is_array($value)) {
				$data_search[] = '['.$key.']';
				$data_replace[]  = $value;
			}
		}
		$replace['data'] = array('search'  => $data_search, 'replace' => $data_replace);

		$conf_search = $conf_replace = array();
		foreach ($this->conf['mail']['repl'] as $key=>$value) {
			$conf_search[] = '['.$key.']';
			$conf_replace[]  = $value;
		}
		$replace['conf'] = array('search'  => $conf_search, 'replace' => $conf_replace);
		$subject = str_replace($replace['data']['search'], $replace['data']['replace'], _($conf['subject']));
		$subject = str_replace($replace['main']['search'], $replace['main']['replace'], $subject);
		$subject = str_replace($replace['conf']['search'], $replace['conf']['replace'], $subject);

		$parts = explode("\n", $conf['message']);
		$message = '';
		foreach ($parts as $p) {
			$message .=  (empty($p) ? $p : gettext($p))."\n";
		}
		$message = str_replace($replace['data']['search'], $replace['data']['replace'], $message);
		$message = str_replace($replace['main']['search'], $replace['main']['replace'], $message);
		$message = str_replace($replace['conf']['search'], $replace['conf']['replace'], $message);

		$subject = '=?utf-8?B?'.base64_encode($subject).'?=';

		$type = 'text/plain';
		if (!empty($conf['type'])) {
			$type = $conf['type'];
		}
		$headers = array("Content-type: $type; charset=UTF-8");
		if (!empty($conf['from'])) {
			$headers[] = 'From: '.str_replace($replace['data']['search'], $replace['data']['replace'], str_replace($replace['main']['search'], $replace['main']['replace'], $conf['from']));
		}
		return mail($to, $subject, $message, implode("\r\n", $headers)."\r\n");
	}

	public function SendEnclosingMail($to, $data, $conf_section = 'main')
	{
		require_once ROOT_PATH.'/zf/third-party/pear/Mail/Mail.php';
		require_once ROOT_PATH.'/zf/third-party/pear/Mail_Mime/mime.php';
		$mime = new Mail_mime(array('head_charset'=>'utf-8', 'text_charset'=>'utf-8', 'html_charset'=>'utf-8'));
		$replace = array(
			'main' => array(
				'search'  => array(
				'[HTTP_HOST]',
				'[DATE]',
				'[REMOTE_ADDR]',
				'[REMOTE_PORT]'
			),
			'replace' => array(
				$_SERVER['HTTP_HOST'],
				date($this->conf['mail']['date_format']),
				$_SERVER['REMOTE_ADDR'],
				$_SERVER['REMOTE_PORT']
			)
		),
		);
		$data_search = $data_replace = array();
		foreach ($data as $key=>$value) {
			$data_search[] = '['.$key.']';
			$data_replace[]  = $value;
		}
		$replace['data'] = array('search'  => $data_search, 'replace' => $data_replace);

		$conf_search = $conf_replace = array();
		foreach ($this->conf['mail']['repl'] as $key=>$value) {
			$conf_search[] = '['.$key.']';
			$conf_replace[]  = $value;
		}
		$replace['conf'] = array('search'  => $conf_search, 'replace' => $conf_replace);

		$subject = str_replace($replace['data']['search'], $replace['data']['replace'], $this->conf['mail'][$conf_section]['subject']);
		$subject = str_replace($replace['main']['search'], $replace['main']['replace'], $subject);
		$subject = str_replace($replace['conf']['search'], $replace['conf']['replace'], $subject);

		$message = str_replace($replace['data']['search'], $replace['data']['replace'], $this->conf['mail'][$conf_section]['message']);
		$message = str_replace($replace['main']['search'], $replace['main']['replace'], $message);
		$message = str_replace($replace['conf']['search'], $replace['conf']['replace'], $message);

		$subject = '=?utf-8?B?'.base64_encode($subject).'?=';
		$headers['subject'] = $subject;
		if (!empty($this->conf['mail'][$conf_section]['from'])) {
			$headers[] = 'From: '.$this->conf['mail'][$conf_section]['from'];
		}
		$mime->setHTMLBody($message); 
		if (!empty($data['file'])) {
			$file = ROOT_PATH.$data['file'];
			$mime->addAttachment($file);
		}
		$body = $mime->get();
		$hdrs = $mime->headers($headers);
		$mail =& Mail::factory('mail');
		$mail->send($to, $hdrs, $body);  
	}

	public function getAsortFields($fields)
	{
		$return = array();
		foreach ($fields as $name => $field) {
			if (empty($field['title'])) {
				continue;
			}
			switch ($field['type']) {
				case '':
					break;

				default:
					$return[$name] = array(
                        'htmltype' => 'text',
                        'title'    => $field['title'],
                        'name'     => $name
					);
			}
		}
		return $return;
	}
    public function validatorCounts($elementName, $value, $params, $data)
	{
        if ($value == $params['value_to_check']) {
            $count = $params['max'];
            foreach ($params['tables'] as $tn => $ch_val) {
                $str = ($this->ctrl->app->request->id && $tn == $params['current_table']) ? " AND id != '{$this->ctrl->app->request->id}'": '';
                $count -= $this->db->one(
                    "SELECT count(*) FROM ?t WHERE ?t = ?".$str,
                    $this->tables[$tn], $elementName, $ch_val
                );
                if ($count <= 0) return false;
            }
        }
        return true;
	}
    public function validatorSimilar_to($elementName, $value, $params, $data) {
        if (empty($params['field_name'])) {
            debug::dump("В конфиге не указано поле для сравнения");
            return false;
        }
        if (!isset($data[$params['field_name']])) {
            debug::dump("В данных формы нет значение для сравнения");
            return false;
        }
        if ($data[$elementName] == $data[$params['field_name']]) return true;
        return false;
    }

    /** function returns array with tableName keys, containing fields, containing dirs
     *
     * @param null $tableName
     * @return array
     */
    function zf_Resize_Images_Fields($tableName = null) {
        $tables = array();
            if (!$tableName) {
                foreach($this->conf['tables'] as $tName => $tConf) {
                    if (isset($tConf['dont_install']) && $tConf['dont_install']) continue;
                    $tables[$tName] = array();
                }
            } else {
                $tables[$tableName] = array();
            }
            unset($tName, $tConf);
            foreach ($tables as $tName => $tTmp) {
                if (empty($this->conf['tables'][$tName]) || empty($this->conf['tables'][$tName]['fields'])) { unset($tables[$tName]); continue; }
                foreach($this->conf['tables'][$tName]['fields'] as $fName => $fConf) {
                    if (!empty($fConf['am']) && !empty($fConf['am']['type']) && $fConf['am']['type'] == 'image') {
                        $tables[$tName][$fName] = array();
                    }
                }
                unset($fName, $fConf);
                if (!count($tables[$tName])) unset($tables[$tName]);
            }
            foreach ($tables as $tName => $tFields) {
                $tmp = $this->getFields($tName, array_keys($tFields));
                foreach($tFields as $fName => $field) {
                    $tables[$tName][$fName] = $tmp[$fName]['dirs'];
                }
            }
        return $tables;
    }

    function zf_Resize_Images_cond($tName) {
        if (!$tName || !isset($this->conf['tables'][$tName])) return array();
        return array();
    }

    public function zf_Resize_Images($tableName = null) {
        $tables = $this->zf_Resize_Images_Fields($tableName);
        $errors = array();
        if (!$tables) {
            echo 'no image_fields';
        }
        foreach ($tables as $tName => $tFields) {
            $errors[$tName] = array();
            echo "\r\n";
            echo "Table: $tName -> ";
            $data = $this->getList($tName, array_keys($tFields), $this->zf_Resize_Images_cond($tName));
            echo ($cnt = count($data))." rows\r\n";
            if ($cnt) {
                define('PRINT_CNT', 5);
                foreach($data as $row) {
                    if (!($cnt % pow(PRINT_CNT, strlen($cnt)-1))) {
                        echo ' '.$cnt.' ';
                        ob_flush();
                    }
                    elseif (!($cnt % PRINT_CNT)) {
                        echo '.';
                        ob_flush();
                    }

                    $cnt--;
                    foreach($tFields as $fName => $dirs) {
                        if (!$row[$fName]) continue;
                        $fileName = str_replace('[dir]', 'original', ROOT_PATH.$row[$fName]);
                        foreach ($dirs as $dir => $params) {
                            $dest  = str_replace('[dir]', $dir, ROOT_PATH.$row[$fName]);
                            $dname = dirname($dest);
                            if (!is_dir($dname)) {
                                misc::create_dir($dname, 0777, '');
                                echo 'Created dir '.$dname."\r\n";
                            }
                            $ret = image::img_resize($fileName, $dest, $params['w'], $params['h'],
                                0777, $params['ratio'],
                                !empty($params['cut']) ? $params['cut'] : 0,
                                !empty($params['q']) ? $params['q'] : 80,
                                !empty($params['colormode']) ? $params['colormode']: 'color'
                            );
                            if (!$ret) {
                                $errors[$tName][] = 'Failed resize '.$fileName.' to '.$dest.' Cause: '.image::$image_error;
                            }
                        }
                    }
                }
            }
        }
        echo "\r\n\r\n\r\n\r\nSTATUS:\r\n";
        foreach($errors as $tName => $tErrors) {
            echo 'Table '.$tName.' '.(!count($tErrors) ? "success.\r\n" : (count($tErrors)." ERRORS:\r\n"));
            if ($tErrors) {
                foreach($tErrors as $error) {
                    echo "\t".$error."\r\n";
                }
                echo "\r\n";
            }
        }
    }
}
?>
