<?php
class UsersModel extends CMS_Model
{
    protected $ctrls           = array();
    static protected $log_data = array();
    static protected $instance = null;
    
    protected $valuesConf = array(
        'roles' => array(
            'modName'    => 'users',
            'ctrlName'   => 'users',
            'keyField'   => 'id',
            'titleField' => 'title',
            'tableName'  => 'user_roles',
            'cond'       => array('order' => array('pos' => 'asc'))
        ),
        'ad' => array(
            'keyField'   => 'id',
            'titleField' => 'title',
            'tableName'  => 'map_geo',
            'cond'       => array('where' => array('category' => 'district'))
        ),
    	'dealers' => array(
    		'keyField'   => 'id',
    		'titleField' => 'title',
    		'tableName'  => 'dealers',
    		'cond'       => array()
    	)
    );
    
    protected function OnBeforeCompile(&$conf)
    {
        if (isset($this->ctrl->app->conf['use_logging']) && $this->ctrl->app->conf['use_logging'] && $this->ctrl->app->conf['use_logging']['logger'][0] == 'UsersModel') {
            $conf = array_merge_recursive($conf, $this->loadConf(
                str_replace('users.', 'log.', $this->ctrl->app->getModelConfFileName($this->ctrlName, $this->modName)), 1
            ));
        }
        return parent::OnBeforeCompile($conf);
    }
    
	/**
	 * проверка принадлежности субъекту доступа, предъявленного
	 * им идентификатора; подтверждение подлинности.
	 * @param string $login
	 * @param string $password
	 * @return boolean
	 */
	public function AuthenticationFromForm($login, $password) 
	{
		return $this->db->one("SELECT id FROM ?t WHERE login=? AND pass=? AND blocked='no'", $this->tables['users'], $login, md5($password));
	}
	
	public function prepareData($tableName, $data)
	{
		if ($tableName == 'user_roles') {
			$data['uri'] = trim($data['uri'], '/') . '/';
		}
		return parent::prepareData($tableName, $data);
	}
    
    
    
    public function Delete($tableName, $cond)
    {
        if ($tableName == 'user_roles') {
            $this->db->query('DELETE FROM ?t WHERE role_id = ?d', $this->tables['users2roles'], $cond['id']);
        }
        return parent::Delete($tableName, $cond);
    }
    
    static public function add_log($app, $ctrlName, $actionName, $conf, $result, $return = 0)
    {
        if (!empty($conf['log_only_actions']) && $result) {
			if (!preg_match("/(".implode('|', $conf['log_only_actions']).")/", $actionName)) return;
        }
        $log = $app->add_log($app, $ctrlName, $actionName, $conf, $result, 1);
        $dontLog = 1;
        if (isset($conf['log_only_when']) && $result) {
			for ($i = 0; $i < strlen($conf['log_only_when'][1]); $i++) {
				switch ($conf['log_only_when'][1][$i]) {
					case 'g': $dType = 'get'; break;
					case 'p': $dType = 'post'; break;
					case 's': $dType = 'session'; break;
				}
				if ($conf['log_only_when'][0] == 'not_empty') {
					if (empty($log[$dType])) {
						if (strtolower(misc::get($conf['log_only_when'], 2, 'and')) == 'and') {
							return;
						}
					} else {
						$dontLog = 0;
					}
				} else { //TODO реализовать поддержку других проверок, помимо, not_empty
					
				}
			}
			if ($dontLog) return;
        }
        unset($log['date']);
        $log['ctrlName']   = $ctrlName;
        $log['actionName'] = $actionName;
        if (!empty($app->user['id'])) $log['user_id'] = $app->user['id'];
        $log['result'] = $log['result'] ? 'success' : 'failure';
        self::$log_data = $log;
    }
    
    static public function update_log($app, $log)
    {
        if (self::$log_data) {
        	self::$log_data = array_merge(self::$log_data, $log);
		}
    }
    
    static public function delete_log($app)
    {
        if (self::$log_data) {
        	self::$log_data = array();
		}
    }
    
    public function humanazeOutput($item, $key, $content)
    {
        if (!$this->ctrls) $this->ctrls = CMS_Controller::getAvailableCtrls();
        if ($this->ctrl->action != 'list_logs') return $content;
        
        if ($this->ctrl->app->conf['use_logging'] && $this->ctrl->app->conf['use_logging']['logger'][0] == 'UsersModel') {
            switch ($key) {
				case 'ctrlName': return $this->ctrls[$item['ctrlName']]['title'];
				case 'actionName':
					if (!$item['actionName']) $item['actionName'] = 'access';
					$ret = $this->ctrls[$item['ctrlName']]['actions'][$item['actionName']][1];
					if ($item['object_id']) {
						$id     = $item['object_id'];
						$action = str_replace('add_', 'show_', $item['actionName']);
					} else {
                                            
						$id     = misc::get(misc::get($this->ctrl->app->request->parse_path($item['url']), 2), 'id');
						$action = str_replace('modify_', 'show_', $item['actionName']);
					}
					
					if ($id) {
						if (!array_key_exists($action, $this->ctrls[$item['ctrlName']]['actions'])) {
							$action = str_replace('show_', 'list_', $action);
							$add2link = "#row_$id";
						} else {
							$add2link = "";
						}
						
						if (array_key_exists($action.'s', $this->ctrls[$item['ctrlName']]['actions'])) {
							$link   = zf::$root_url."{$item['ctrlName']}/{$action}s/id/$id/$add2link";
						} else {
							$link = '';
						}
						
						$ret  .= $link ? " <a href=\"$link\">(#$id)</a>" : " (#$id)";
					}
				return $ret;
            }
        }
        return $content;
    }
    
    
    public function __destruct()
    {
		if (self::$log_data) {
			zfApp::$db_static->query(
	            'INSERT INTO ?t (?lt) VALUES (?l)', '?_actions_log',
	            array_keys(self::$log_data),
	            array_values(self::$log_data)
	        );
		}
    }
}

?>