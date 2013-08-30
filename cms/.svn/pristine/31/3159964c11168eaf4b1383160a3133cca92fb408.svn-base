<?php
class CMS extends zfApp
{
	public $user = array();
    /**
	* Loads configuration into $this->conf from the file name specified.
	* 
	* @param string $fileName file name with path where configuration in YAML format stored.
	* @return true
	*/
	public function loadConf()
	{
		$fileName                 = func_get_arg(0);
		$conf                     = parent::loadConf($fileName);
		$mAppConf                 = parent::loadConf('site/conf/app.conf.yml');
		$mAppConf                 = parent::loadConf('site/conf/app.conf.yml');
		if (file_exists(ROOT_PATH.'site/conf/cms/add_conf.yml') && is_file(ROOT_PATH.'site/conf/cms/add_conf.yml')) {
			$addConf              = parent::loadConf('site/conf/cms/add_conf.yml');
		}
        if (!empty($mAppConf['yandexmap'])) $conf['yandexmap'] = $mAppConf['yandexmap'];
		if (!empty($mAppConf['googlemap'])) $conf['googlemap'] = $mAppConf['googlemap'];
		$conf['mc_api_key']       = isset($mAppConf['mc_api_key']) ? $mAppConf['mc_api_key'] : null;
		$conf['run_at']           = $mAppConf['run_at'];
		$conf['modes']            = $mAppConf['modes'];
		$conf['i18n']             = isset($mAppConf['i18n']) ? $mAppConf['i18n'] : null;
		if (isset($addConf)) {
			$conf['preg_vars_keys'] = isset($addConf['preg_vars_keys']) ? $addConf['preg_vars_keys'] : null;
		}
		$conf['db_prefix']        = isset($mAppConf['db_prefix']) ? $mAppConf['db_prefix'] : '';
		$conf['settings']         = $mAppConf['settings'];
        $conf['menu']             = $mAppConf['cms_menu'];
        $conf['smenu']            = $mAppConf['cms_smenu'];
        $conf['types']            = isset($mAppConf['types']) ? $mAppConf['types'] : array();
        $conf['title']            = $mAppConf['title'];
        $conf['copyrights']       = isset($mAppConf['copyrights']) ? $mAppConf['copyrights'] : array();
        $conf['copyrights']['title'] = $conf['title'];
        $conf['authorized']       = isset($mAppConf['authorized']) ? $mAppConf['authorized'] : 'page/authorized';
        $conf['auth']             = isset($mAppConf['auth']) ? $mAppConf['auth'] : 'page/auth';
        $conf['main']             = isset($mAppConf['main']) ? $mAppConf['main'] : 'main';
        $conf['popup']            = isset($mAppConf['popup']) ? $mAppConf['popup'] : 'popup';
        $conf['disabled_modules'] = !empty($mAppConf['disabled_modules']) ? $mAppConf['disabled_modules'] : array();
        if (!empty($mAppConf['cms_default_controller'])) {
            $conf['default_controller'] = $mAppConf['cms_default_controller'];
        }
        if (!empty($mAppConf['additional_js'])) {
            $conf['additional_js'] = $mAppConf['additional_js'];
        }
		return $conf;
	}
	
	public function run()
	{
		$this->page->addPluginsDir('cms/smarty_plugins/');
		$this->page->copyrights   = $this->conf['copyrights'];
		return parent::run();
	}
    
    public function CanRun($ctrlName, $action, $data = array())
    {
        if ($this->hasModel('permissions', 'permissions')) {
            return $this->ctrl->model('permissions', 'permissions')->CanRun($ctrlName, $action, $this->user, $data);
        }
        return 1;
    }
    
    public function CantRun($ctrlName, $action)
    {
        if (misc::get($this->conf, 'access_denied_redirect', false)) {
            $user_roles = $this->page->user['roles'];
            $first_role = current($user_roles);
            header('Location: '.$this->page->root_url.$first_role['uri']);
            exit;
        }

        $this->page->access_denied = 1;
    }
	
	public function getModelConfFileName($modName, $ctrlName)
	{
        return "site/conf/$ctrlName/$modName.mod.yml";
	}
	
	public function getCtrlConfFileName($ctrlName)
	{
        return "site/conf/$ctrlName/$ctrlName.ctrl.yml";
	}
	
}
?>
