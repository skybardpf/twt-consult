<?php
/**
 * This file contains main zFramework class
 *
 * @version 1.0, SVN: $Id: zf.class.php 42 2009-09-08 15:06:04Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * Main zFramework class
 *
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
class zf extends ConfLoader
{
	public $var_keys = array('id', 'pid', 'item', 'page', 'pos', 'application', 'iid', 'captcha', 'ajax');
	static protected $instance = null;
	static public $request  = null;
	static public $session  = null;
	static public $db;
	static public $types    = array();
	static public $root_url = '/';
	static public $zf_root_url = '/';
	public $path;
	public $vars;
	public $files;
	public $post;
	public $uri;
	public $query;
	/**
	 * @var zfApp
	 */
	public $app = null;
	public $conf = array();
	public $user = array();
	public $cookie  = array();
	public $host = '';
	public $ip   = '';
	public $remote_ip = '';

    static protected $zf_rev = 0;


	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		$this->conf      = $this->loadConf(ROOT_PATH.'zf_conf/apps.conf.yml');
		zf::$zf_root_url = !empty($this->conf['zf_root_url']) ? $this->conf['zf_root_url'] : '/';

		if (empty($_SERVER['HTTP_HOST']) && isset($_SERVER['argc']) and $_SERVER['argc'] > 0) {
			$_SERVER['HTTP_HOST']   = 'localhost';
			$_SERVER['SERVER_ADDR'] = '127.0.0.1';
			$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
			$_SERVER['REQUEST_URI'] = '/';
			$_SERVER['console']     = true;

			for ($i = 1; $i < $_SERVER['argc']; $i++) {
				switch ($_SERVER['argv'][$i]) {
					case '--help':
						echo iconv('utf-8', (substr(php_uname(), 0, 7) == "Windows") ? 'cp866' : 'koi8-r', <<<HELPDELEMITERASDASD
╔═══════════════════════════════════════════════════╗
║Опции фреймворка:                                  ║
╟──────┬──────────┬──────────────┬──────────────────╢
║ Ключ │ Синонимы │ По-умолчанию │ Описание         ║
╟──────┼──────────┼──────────────┼──────────────────╢
║-host │ -h       │  localhost   │ Имя хоста        ║
╟──────┼──────────┼──────────────┼──────────────────╢
║-ip   │          │  127.0.0.1   │ IP-адрес сервера ║
╚══════╧══════════╧══════════════╧══════════════════╝\n
HELPDELEMITERASDASD
						);
						exit;
						break;
					case '-h':
					case '-host':
						$_SERVER['HTTP_HOST'] = $_SERVER['argv'][++$i];
						break;
					case '-ip':
						$_SERVER['SERVER_ADDR'] = $_SERVER['argv'][++$i];
						break;
							
					default:
						$_SERVER['REQUEST_URI'] = $_SERVER['argv'][$i];
						break;
				}
			}
		}
		$this->host      = $_SERVER['HTTP_HOST'];
		$this->ip        = $_SERVER['SERVER_ADDR'];
		$this->remote_ip = misc::get($_SERVER, 'HTTP_X_FORWARDED_FOR', misc::get($_SERVER, 'REMOTE_ADDR', null));
	}

	/**
	 * Returns zf object
	 *
	 * @return zf
	 */
	public static function getInstance()
	{
		if (!self::$instance) {
			self::$instance = new zf();
		}
		return self::$instance;
	}

	/**
	 * Returns zf object. Shorter version of zf::getInstance
	 *
	 * @return zf
	 */
	public static function gi()
	{
		return self::getInstance();
	}

	/**
	 * Halts application
	 *
	 * @param string $msg Message to display
	 * @return void
	 */
	public static function halt($msg)
	{
		die ('<h1>'.$msg.' '.debug::getCaller(1).'</h1>');
	}

	/**
	 * Initializes controller
	 *
	 * @return Controller
	 */
	public function initCtrl($load_default = false)
	{
		$ctrlName = '';
		if (!self::$request->parr || $load_default) {
			$ctrlName = $this->app->conf['default_controller'];
			if (!$ctrlName) self::halt('No default controller set in config. Please set it!');
		} else {
			$ctrlName = self::$request->parr[0];
		}

		if (!($ctrl = $this->app->loadCtrl($ctrlName, empty($this->app->conf['mvc']['use_subdirs']['controllers']) ? 0 : 1))) {
			if (!$load_default) $ctrl = $this->initCtrl(true); else zf::halt("No such default controller - \"$ctrlName\" found!");
		} elseif (!$load_default) {
				
			//array_shift($this->path);
		}
		return $ctrl;
	}

	/**
	 * Initializes zf object
	 *
	 * @param zfApp $app
	 */
	public function init(zfApp $app)
	{
        if (file_exists('rev.num') && is_file('rev.num')) {
            self::$zf_rev = intval(file_get_contents('rev.num'));
        }
		if (!$this->app) {
			$this->app     = $app;
			$this->app->zf = $this;
		}
		zf::$db          = $this->init_db();
		debug::init();
		$this->loadTypes();
        
        $app->beforeRequestInit();
     
		$app->request    = self::$request  = Request::getInstance(misc::get($app->conf, 'vars_keys'), misc::get($app->conf, 'preg_vars_keys', array()));
		$app->session    = self::$session  = Session::getInstance(misc::get($app->conf, 'session'));


		if (misc::get($app->request->parr, 0) == 'captcha') {
			$this->getKcaptcha();
			exit;
		}
		//if (misc::get($app->request->parr, 0) == 'ajax') // todo

		if (!empty($this->app->conf['use_smarty'])) {
			$this->app->page = new SmartyPage(
			array_merge($this->app->conf['smarty'], $this->app->conf['modes'][$this->app->mode]['smarty'])
			);
		} else {
			$this->app->page = new NativePage($this->app->conf['page']);
		}
		$this->app->page->root_url    = self::$root_url;
		$this->app->page->zf_root_url = zf::$zf_root_url;
		$_ENV['TMPDIR'] = '.zf_tmp';
		if (isset($this->app->conf['jquery_version'])) 
		zf::addJS('jquery', '/public/zf/js/jquery'.$this->app->conf['jquery_version'].'.js');
		else
		zf::addJS('jquery', '/public/zf/js/jquery.js');
	}

	function getKcaptcha()
	{
		require_once ROOT_PATH.'zf/third-party/kcaptcha/kcaptcha.class.php';
        $captcha = new KCAPTCHA($this->app->conf['kcaptcha']);
		$this->app->session->start();
		$this->app->session->zf_kcaptcha_key = $captcha->getKeyString();
	}

	/**
	 * Loads types into framework
	 *
	 */
	protected function loadTypes()
	{
		self::$types = $this->loadConf(ROOT_PATH.'zf/conf/types.conf.yml');
		if (!empty($this->app->conf['types'])) {
			self::$types['types'] = misc::inheritArrayAdvanced(self::$types['types'], $this->app->conf['types']);
		}
	}

	/**
	 * Choses zf application
	 *
	 * @return void
	 */
	public function chose_app()
	{
		$app_path = '';
		$app_name = '';
        $uri_raw = $_SERVER['REQUEST_URI'];
        $uri_get = '';
        if (($pos = strpos($uri_raw, '?')) !== false) {
            $uri_raw = substr($uri_raw, 0, $pos);
            $uri_get = substr($_SERVER['REQUEST_URI'], $pos);
        }

		if (!empty(zf::$zf_root_url) and self::$zf_root_url != '/') {
			$uri_raw = str_replace(zf::$zf_root_url, '', $uri_raw);
			$uriArr   = explode('/', trim($uri_raw, '/'));
		} else {
			$uriArr   = explode('/', trim($uri_raw, '/'));
		}
		$uri      = '/'.array_shift($uriArr).'/';
        $uriArr = array_reverse($uriArr, false);
        array_push($uriArr, trim($uri,'/'));
        $uriArr = array_reverse($uriArr, false);
		if (!empty($this->conf['uri_mapping']) && is_array($this->conf['uri_mapping'])) {
			foreach ($this->conf['uri_mapping'] as $key => $val) {
				if (
				(is_array($val['uri']) && ($uri_key = array_search($uri, $val['uri'])) !== false)
				||
				(!is_array($val['uri']) && strpos($uri, $val['uri']) === 0)) {
					if ($val['bind2hosts'] != 'any') {
						if (!in_array($_SERVER['HTTP_HOST'], $val['bind2hosts'])) continue;
					}
					if ($uri_key !== false) {
						$val['uri'] = $val['uri'][$uri_key];
					}
					//$val['uri'] = rtrim($val['uri'], '/');
					$app_path = trim($this->conf['apps'][$key], '/').'/';
					$app_name = $key;
					self::$root_url = $val['uri'];
                    if (count($uriArr) == 1) {
                        $_SERVER['REQUEST_URI'] = '/'.array_shift($uriArr).'/'.($uri_get ? $uri_get : '');
                    }

					$_SERVER['REQUEST_URI'] = str_replace($val['uri'], '', $_SERVER['REQUEST_URI']);
					return array($app_name, $app_path);
				}
			}
		}

		if (!empty($this->conf['host_mapping']) && is_array($this->conf['host_mapping'])) {
			foreach ($this->conf['host_mapping'] as $key => $hosts) {
				foreach ($hosts as $val) {
					if ($_SERVER['HTTP_HOST'] == $val) {
						$app_path = trim($this->conf['apps'][$key], '/').'/';
						$app_name = $key;
						return array($app_name, $app_path);
					}
				}
			}
		}

		if (empty($this->conf['default_app'])) die ("zFramework: Can't chose application to run. Try to set default_app in zf/conf/apps.conf.yml");
		$app_path = trim($this->conf['apps'][$this->conf['default_app']], '/').'/';
		$app_name = $this->conf['default_app'];
		return array($app_name, $app_path);
	}

	/**
	 * Initializes db object
	 *
	 * @param array $conf
	 * @return db
	 */
	public function init_db($conf = array())
	{
		if (!$conf) {
			$conf              = $this->app->conf['run_at'][$this->app->run_at];
			$conf['db_debug']  = $this->app->conf['modes'][$this->app->mode]['db_debug'];
			$conf['db_prefix'] = (isset($this->app->conf['db_prefix'])) ? $this->app->conf['db_prefix'] : '';
		}
		$db = db::connect($conf['db_engine'].'://'.$conf['db_user'].
			':'.$conf['db_pass'].'@'.$conf['db_host'].
			'/'.$conf['db_name'],
		$conf['db_charset'], array(), 0, isset($conf['db_sql_mode']) ? $conf['db_sql_mode'] : null);

		$db->apply_conf($conf['db_debug']);
		$db->setPrefix($conf['db_prefix']);
		$db->setLogger(array('debug', 'db_logger'));

		if (!empty($conf['db_use_cacher'])) {
			$db->setCacher(new cacher('.zf_cache', $conf['db_use_cacher']));
		}
		zfApp::$db_static = $db;
		return $db;
	}

	/**
	 * Returns object of zfApplication
	 *
	 * @param string $app Application name
	 * @return zfApp
	 */
	static public function run_app($app = '')
	{
		self::prepare();
		$zf = zf::gi();
		if (!$app) {
			list($app_name, $app_path) = $zf->chose_app();
		} else {
			$app_path = $zf->conf['apps'][$app].'/';
			$app_name = $app;
		}
		$app_path = ROOT_PATH.$app_path;

		if (file_exists($app_path.$app_name.'.class.php')) {
			require_once $app_path.$app_name.'.class.php';
			$zf->app = new $app_name($app_name, $app_path, $zf);
		} else {
			$zf->app = new zfApp($app_name, $app_path, $zf);
		}

		$zf->app->run();
		//if ($zf->app->mode != 'development') self::compileRequirer();
		$zf->app->stop();
	}

	/**
	 * Runs application
	 *
	 * @param string $app Application name
	 */
	/*	static public function run_app($app = '')
	 {
		$zf = zf::gi();

		$app = zf::get_app($app);
		$app->run();
		$app->stop();
		}*/

	/**
	 * Compiles zf/requirer.php
	 *
	 */
	static public function compileRequirer($requirer = 'zf/requirer.php')
	{
		$requirer = str_replace(ROOT_PATH, '', $requirer);
		preg_match_all("#require_once\s\(?['\"](.*)['\"]\)?#", file_get_contents(ROOT_PATH.$requirer), $out);
		$compiled = '';
		foreach ($out[1] as $file) {
			if (file_exists($file)) {
				$compiled .= file_get_contents($file);
			}
		}
		if (is_file(ROOT_PATH.'.zf_compiled/'.str_replace('/', '_', $requirer))) {
			unlink(ROOT_PATH.'.zf_compiled/'.str_replace('/', '_', $requirer));
		}
		misc::file_safe_put(ROOT_PATH.'.zf_compiled/'.str_replace('/', '_', $requirer), $compiled);
		chmod(ROOT_PATH.'.zf_compiled/'.str_replace('/', '_', $requirer), 0777);
	}

	/**
	 * Prepare zFramework for work
	 *
	 */
	static public function prepare()
	{
		$dirs    = array('.zf_compiled', '.zf_tmp', '.zf_cache');
		$no_dirs = array();
		foreach ($dirs as $dir) {
			if (!is_dir($dir)) $no_dirs[] = $dir;
		}
		if (!$no_dirs) return;

		$cant_create = array();
		foreach ($no_dirs as $dir) {
			if (!mkdir($dir)) $cant_create[] = $dir; else chmod($dir, 0777);
		}
		if ($cant_create) {
			$cant_create = implode(', ', $cant_create);
			die("Can't create dirs: $cant_create!\r\nPlease set proper rights on parent directory or create them by yourself and set 0777 rights.");
		}
	}

	static public function addJS($key, $url, $pack = false, $dont_modify=false)
	{
		$simbol = (strpos($url, '?') === false) ? '?': '&';
        if ($pack) {
			$script = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$url);
			$packer = new JavaScriptPacker($script, 'Normal', true, false);
			$packed = $packer->pack();
			$out = str_replace('.js', '.packed.js', $url);
			$out = ROOT_PATH.$out;
			if (!file_exists($out)) {
				$file = fopen($out, 'w');
				fwrite($file, $packed);
				fclose($file);
			}
			$out = str_replace(ROOT_PATH, '', $out);
            if (!$dont_modify) {
                $out .= $simbol.self::$zf_rev;
            }
			self::gi()->app->page->set('pageJS', $key, $out);
		} else {
			self::gi()->app->page->set('pageJS', $key, $url.($dont_modify ? '' : $simbol.self::$zf_rev));
		}
	}
	static public function addCSS($key, $url)
	{
		self::gi()->app->page->set('pageCSS', $key, $url);
	}

	static public function redirect($url)
	{
		if (!empty(zf::gi()->app->conf['modes'][zf::gi()->app->mode]['autoredirect'])) {
			header("Location: $url");
			exit;
		} else {
			echo "<a href=\"$url\">$url</a>";
		}
	}

	/**
	 * Returns Excel Object
	 * @return Excel
	 */
	static public function getExcelTool()
	{
		require_once ROOT_PATH.'zf/tools/excel/excel.class.php';
		return new Excel();
	}
}
?>