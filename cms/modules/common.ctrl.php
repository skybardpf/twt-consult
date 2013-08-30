<?php
class CommonController extends Controller
{
	protected $auth = 0;
    
    public function run()
	{
		$this->app->session->start();
		
		//авторизация
        $this->page->auth = 0;
        $this->page->appTitle = isset($this->app->conf['title']) ? $this->app->conf['title'] : 'CMS';
        $logged_in = 0;
		if ( ($uid = $this->app->session->get('uid')) > 0 ) {
			$logged_in = 1;
		}

		if (!$logged_in && (isset($_POST['login']) && isset($_POST['pass']) && $uid = $this->model('users', 'users')->AuthenticationFromForm($_POST['login'], $_POST['pass']))) {
			$logged_in = 2;
		}
		
		if ($logged_in == 1 or $logged_in == 2 ) {
			$this->page->user = $this->app->user = $this->model('users', 'users')->Get($uid, 'users', $this->model('users', 'users')->getFieldsNames('users', 'all'));
			if ($logged_in == 2 ) { 
				$url = $this->getUrl();
				$this->app->session->set('uid', $uid);
				header('Location: /admin/'. ltrim($url, '/'));
				exit;
			}
			zf::addJS('main', '/public/cms/js/main.js');
			zf::addJS('cookie', '/public/cms/js/cookie.js');
			zf::addJS('jquery.cookie', '/public/cms/js/jquery.cookie.js');
			zf::addJS('group', '/public/cms/js/group.js');
            $this->page->auth = 1;
			$this->app->session->set('uid', $uid);
            zf::addJS('menu', '/public/cms/js/menu.js');
            $this->auth = 1;
            if (!empty($this->app->conf['additional_js'])) {
                foreach ($this->app->conf['additional_js'] as $key => $path) {
                    zf::addJS($key, $path);
                }
            }            
        
            $langFile = zf::gi()->app->conf['charset'] == 'utf-8' ? 'calendar-ru.js' : 'calendar-ru-cp1251.js';
            zf::addJS('dynDateTime', '/public/zf/js/jquery.dynDateTime.js');
            zf::addJS('dynDateTime_lang', "/public/zf/js/dyndatetime/$langFile");
            
/*            if ($_POST && 0) {
                $location = $_SERVER['REQUEST_URI'];
                if ( $_SERVER['QUERY_STRING']) $location .= '?'.$_SERVER['QUERY_STRING'];
                header("Location: $location");
                exit;
            }*/
/*            $firstRole = current($this->app->user['roles']);
            if ($this->app->request->url == '/' and !empty($firstRole['uri'])) {
            	header('Location: '.zf::$root_url.$firstRole['uri']);
            }*/
		} else {
			zf::addJS('login', '/public/cms/js/login.js');
			$this->loadForm('auth', array(
				array('name' => 'login', 'htmltype' => 'text', 'title' => 'Логин'),
				array('name' => 'pass', 'htmltype' => 'pass', 'title' => 'Пароль')
			));
            !empty($_POST) ? $this->app->page->error = "Неверная пара логин/пароль." : 0;
            $this->auth = 0;
			return true;
		}
		if (isset($this->app->request->parr[0]) && $this->app->request->parr[0] == 'logout') {
			$this->app->session->uid = 0;
			header('Location: /');
		}
		try {
            if (!empty($this->app->conf['i18n']['enabled'])) $this->lang($this->app->conf['i18n']);
        } catch (Exception $e) {
            debug::add('Localisation failed: '.$e->getMessage(), 'error');
        }
		
	}
	
	public function lang($conf)
	{
		$lang = null;
		$all_langs = $this->model($conf['model'], $conf['model'])->getLanguages();
		switch ($conf['method']) {
			case 'var_key':
                $lang = $this->model($conf['model'], $conf['model'])->getLanguageLocale(
                    array('where' => array('lang' => $this->app->request->$conf['key']))
                );
            break;
            case 'cookie':
				if (!empty($_COOKIE[$conf['cookie']]) and array_key_exists($_COOKIE[$conf['cookie']], $all_langs)) {
					$lang = $_COOKIE[$conf['cookie']];
				}
			break;
			case 'domain':
				$tmp_lang = $this->model($conf['model'])->GetByCond($conf['table'], array($conf['fields']['locale']), array('where' => array($conf['fields']['domain'] => $_SERVER['HTTP_HOST'])));
				if (!empty($tmp_lang[$conf['fields']['locale']])) {
					$lang = $tmp_lang[$conf['fields']['locale']];
				}
			break;
		}
        if(!$lang){
            $lang = isset($conf["default"])?$this->model($conf['model'], $conf['model'])->getLanguageLocale(
                array('where' => array('lang' => $conf["default"]))
            ):null;
        }
		$lang = $lang ? $all_langs[$lang] : $all_langs['en_US.UTF-8'];
		if ($this->app->conf['i18n']['method'] != 'domain') {
            $this->page->root_url .= $lang['lang'].'/';
            zf::$root_url .= $lang['lang'].'/';
        }
		define('USE_LOCALIZATION', true);
		putenv('LC_ALL='.$lang['locale']);
		putenv('LC_NUMERIC=en_US.UTF-8');
		$res = setlocale(LC_ALL, $lang['locale']);
		setlocale(LC_NUMERIC, 'en_US.UTF-8');
		debug::add(($res === false) ? "Не могу установить локаль: {$lang['locale']}" : "Локаль установленна: $res", 'lang');
		lang::setLang($lang['lang']);
		$this->model('languages')->setPrefix($lang['lang']."_");
		
		$domain = $conf['po_domain'];
		
		if (empty($conf['domain_file_in_db'])) {
            $base_file_name = "locale/{$lang['locale']}/LC_MESSAGES/{$domain}.po";
        } else {
            if (!$lang[$conf['domain_file_in_db']]) throw new Exception('В базе данных не задан файл локализации '.$lang['lang']);
            $base_file_name =  ROOT_PATH.$lang[$conf['domain_file_in_db']];
        }
        if (file_exists($base_file_name)) {
            $mtime  = filemtime($base_file_name);
        } else {
            $mtime = '';
        }
        if (!file_exists("locale/{$lang['locale']}/LC_MESSAGES/{$domain}_$mtime.po") or !file_exists("locale/{$lang['locale']}/LC_MESSAGES/{$domain}.mo")) {
            if (file_exists($base_file_name) && !is_dir($base_file_name)) {
                array_map("unlink", glob("locale/{$lang['locale']}/LC_MESSAGES/{$domain}_*.po"));
                copy($base_file_name, "locale/{$lang['locale']}/LC_MESSAGES/{$domain}_$mtime.po");
                $out = array();
                $ret = 0;
                $r = system(misc::getRealCmdPath('msgfmt')." $base_file_name -o locale/{$lang['locale']}/LC_MESSAGES/{$domain}.mo", $ret);
                if ($r === false) throw new Exception("Не могу найти msgfmt");
                if ($ret) throw new Exception("Не могу создать файл locale/{$lang['locale']}/LC_MESSAGES/{$domain}.mo из {$domain}.po");
            } else {
                throw new Exception("Не могу найти файл $base_file_name");
            }
        }

        $mtime  = filemtime("locale/{$lang['locale']}/LC_MESSAGES/{$domain}.mo");
        if (!file_exists("locale/{$lang['locale']}/LC_MESSAGES/{$domain}_$mtime.mo")) {
            array_map("unlink", glob("locale/{$lang['locale']}/LC_MESSAGES/{$domain}_*.mo"));
            copy("locale/{$lang['locale']}/LC_MESSAGES/$domain.mo", "locale/{$lang['locale']}/LC_MESSAGES/{$domain}_$mtime.mo");
            $domain = "{$domain}_$mtime";
        }

        $res = bind_textdomain_codeset($domain, 'UTF-8');
        $res = bindtextdomain($domain, ROOT_PATH."locale");
        $res = textdomain($domain);
	}
    
	public function stop()
	{
		if ($this->auth) {
            $this->page->main_menu    = $this->app->conf['menu'];
            $this->page->main_smenu   = $this->app->conf['smenu'];
            if ($this->page->panel) {
                zf::addJS('panel', '/public/cms/js/panel.js');
            }
            if (!$this->page->pageTitleLast) {
                $this->page->pageTitleLast = misc::getNe($this->page->data, array('name', 'title', 'login'), '');
            }
            $this->page->main_content = $this->renderView($this->app->conf['authorized'], null);
        } else {
            $this->page->main_content = $this->renderView($this->app->conf['auth'], null);
        }
        if ($this->app->request->main_view && $this->page->auth) {
            $this->loadView(str_replace('-', '/', $this->app->request->main_view), null);
        } elseif ($this->app->request->popup) {
            zf::addJS('close_btn', '/public/cms/js/close_btn.js');
            $this->loadView($this->app->conf['popup'], null);
        } elseif (!$this->app->request->ajax) {
        	$this->loadView($this->app->conf['main'], null);
        }
	}
	
	protected function getUrl()
	{	
		$url = '';
		$roles = $this->app->user['roles'];
		foreach ($roles as $role) {
			if($role['url'] != '' or $role['uri'] != '') {
				$url = ($role['url'] != ''? $role['url']  : $role['uri'] );
				break;
			}
		}
		return $url;
	}

    public function actionDefault()
    {
        $is_main = 1;
        $this->page->is_main = $is_main;
        parent::actionDefault();
    }
}
?>
