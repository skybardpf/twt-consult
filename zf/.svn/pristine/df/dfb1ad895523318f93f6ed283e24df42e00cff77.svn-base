<?php
/**
 * This file contains zfApp class
 * 
 * @version 1.0, SVN: $Id: zfapp.class.php 42 2009-09-08 15:06:04Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com) 
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * Base class for all zFramework applications
 * 
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
class zfApp extends ConfLoader
{
	/**
	* Stores of object of page class
	* 
	* @var page
	*/
	public $page = null;
	
	/**
	* Stores main configuration of the application
	* 
	* @var array
	*/
	public $conf;

	/**
	* Name of the application
	* 
	* @var string
	*/
	public $appName;
	
	/**
	* Stores zf object
	* 
	* @var zf
	*/
	public $zf;
	
	/**
	* Stores different application data
	* 
	* @var array
	*/
	public $data;
		
	/**
	* Path to the application files
	* 
	* @var string
	*/
	public $app_path;
	
	/**
	* Stores db object
	* 
	* @var db
	*/
	private $db;
    
    static public $db_static;
	
	/**
	* Stores controller object
	* 
	* @var Controller
	*/
	public $ctrl;
	
	/**
	* Stores common controller object
	* 
	* @var Controller
	*/
	public $commonCtrl;
	
	/**
	* Started time
	* 
	* @var float
	*/
	private $stime;
	
	/**
	* Specifies where application is running at. By default can be local or remote
	* 
	* @var string
	*/
	public $run_at;
	
	/**
	* Mode in which application is running. By default can be development, debug or production
	* 
	* @var string
	*/
	public $mode;
	
	/**
	* Stores instance of Request class
	* 
	* @var Request
	*/
	public $request;
	
	/**
	* Stores instance of Session class
	* 
	* @var Session
	*/
	public $session;
	
	public $contentType = 'text/html';
    
    public $logger      = null;
    public $log_updater = null;
    public $log_deleter = null;
    // Высоконагруженные проекты не должны без спроса обновлять структуру базы
    // для обновления используется GET запрос с параметром recompile_files=1
    public $highload    = false;
	
	/**
	* Constructor
	* 
	*/
	public function __construct($appName, $appPath, $zf, $dont_init = 0)
	{
		$this->stime    = misc::time();
		$this->zf       = $zf;
		$this->appName  = $appName;
		$this->app_path = $appPath;
		$this->conf     = $this->loadConf($appPath.'conf/app.conf.yml');

		if (!empty($_SERVER['console'])) {
			$this->conf['mode'] = 'console';
		}
        if (!empty($this->conf['use_logging'])) {
            $this->logger = !empty($this->conf['use_logging']['logger'])
                ? array($this->conf['use_logging']['logger'][0], $this->conf['use_logging']['logger'][1])
                : array('zfApp', 'add_log');
            if (isset($this->conf['use_logging']['logger'][2])) {
                $this->log_updater = array($this->conf['use_logging']['logger'][0], $this->conf['use_logging']['logger'][2]);
            }
            
            if (isset($this->conf['use_logging']['logger'][3])) {
                $this->log_deleter = array($this->conf['use_logging']['logger'][0], $this->conf['use_logging']['logger'][3]);
            }
        }
		$this->run_at   = $this->getRunAt();
		$this->mode     = $this->getMode();
        if (!empty($this->conf['run_at'][$this->run_at]['highload'])) {
            $this->highload = true;
        }
		
		if (!empty($this->conf['load_named_conf'])) {
			$this->conf = array_merge($this->conf, $this->loadConf("{$appPath}conf/$appName.conf.yml"));
		}
//        debug::dump($this->conf);
		if (!$dont_init) $this->zf->init($this);
	}
    
    /**
    * Write log of performed actions to file
    * 
    * @param zfApp $app
    * @param Controller $ctrlName
    * @param string $action
    * @param integer $result
    * @param array $conf
    * @param integer $return
    */
    static public function add_log($app, $ctrlName, $action, $conf, $result, $return = 0)
    {
        if ($return) $log = array();
        $string    = date('d.m.Y H:i:s');
        if ($return) $log['date'] = $string;
        $store     = !empty($conf['store']) ? $conf['store'] : array();
        $gzipLevel = !empty($conf['gzip_level']) ? $conf['gzip_level'] : 0;
        if ($store) {
            if ($ct = misc::get($store, 'ip')) {
                $ip      = ($gzipLevel && $ct == 'gzipped' ? gzcompress($app->zf->remote_ip, $gzipLevel) : $app->zf->remote_ip);
                if ($return) {
                    $log['ip'] = $ip;
                } else {
                    $string .= "[$ip]";
                }
            }
            
            if ($ct = misc::get($store, 'url')) {
                $url     = ($gzipLevel && $ct == 'gzipped' ? gzcompress($app->request->uri, $gzipLevel) : $app->request->uri);
                if ($return) {
                    $log['url'] = $url;
                } else {
                    $string .= " {$_SERVER['REQUEST_METHOD']}: $url";
                }
            }
            
            if (($ct = misc::get($store, 'get')) && $_GET) {
                $get     = ($gzipLevel && $ct == 'gzipped' ? gzcompress(serialize($_GET), $gzipLevel) : serialize($_GET));
                if ($return) {
                    $log['get'] = $get;
                } else {
                    $string .= ' GetData: '.$get;    
                }
            }
            
            if (($ct = misc::get($store, 'post')) && $_POST) {
                $post    = ($gzipLevel && $ct == 'gzipped' ? gzcompress(serialize($_POST), $gzipLevel) : serialize($_POST));
                if ($return) {
                    $log['post'] = $post;
                } else {
                    $string .= ' PostData: '.$post;
                }
            }
            
            if (($ct = misc::get($store, 'session')) && $_SESSION) {
                $session = ($gzipLevel && $ct == 'gzipped' ? gzcompress(serialize($_SESSION), $gzipLevel) : serialize($_SESSION));
                if ($return) {
                    $log['session'] = $session;
                } else {
                    $string .= ' SessionData: '.$session;
                }
            }
        }
        if ($return) {
            $log['result'] = $result;
        } else {
            $string .= $result ? " success ($result)" : " failure ($result)";
        }
        if ($return) return $log;
        $file = !empty($conf['file']) ? $conf['file'] : 'actions.log';
        if (file_exists($file)) {
            $string = "\r\n".$string;
        }
        $fp = fopen($file, 'a');
        fwrite($fp, $string);
        fclose($fp);
    }
	/**
	* Returns where application is running.
	* 
	* @return string If server ip equals 127.0.0.1 returns local and remote otherwise.
	*/
	protected function getRunAt()
	{
		foreach ($this->conf['run_at'] as $run_at => $cond) {
			if (empty($cond['cond'])) return $run_at;
			foreach ($cond['cond'] as $key => $value) {
				switch ($key) {
					case 'ip':
						if (is_array($value)) {
							if(in_array($this->zf->ip, $value)) return $run_at;
						} else {
							if ($this->zf->ip == $value) return $run_at;
						}
					break;
					case 'host':
						if (is_array($value)) {
							if(in_array($this->zf->host, $value)) return $run_at;
						} else {
							if ($this->zf->host == $value) return $run_at;
						}
					break;
				}
			}
		}
		return 'default';
	}

	/**
	* Returns mode in which application is running.
	* 
	* @return string If server ip equals 127.0.0.1 returns local and remote otherwise.
	*/
	protected function getMode()
	{
		if (!empty($this->conf['mode'])) return $this->conf['mode'];
		foreach ($this->conf['modes'] as $modeName => $mode) {
            if (empty($mode['cond'])) continue;
            foreach ($mode['cond'] as $run_at => $cond) {
				if ($run_at != $this->run_at) continue;
				if (!is_array($cond) && $cond == '*') return $modeName;
				foreach ($cond as $key => $value) {
					switch ($key) {
						case 'ip':
							if (is_array($value)) {
								if(in_array($this->zf->ip, $value)) return $modeName;
							} else {
								if ($this->zf->ip == $value) return $modeName;
							}
						break;
						
						case 'host':
							if (is_array($value)) {
								if(in_array($this->zf->host, $value)) return $modeName;
							} else {
								if ($this->zf->host == $value) return $modeName;
							}
						break;
						
						case 'remote_ip':
							if (is_array($value)) {
								if(in_array($this->zf->remote_ip, $value)) return $modeName;
							} else {
								if ($this->zf->remote_ip == $value) return $modeName;
							}
						break;
					}
				}
				if (!empty($this->conf['run_at'][$run_at]['mode'])) {
					return $this->conf['run_at'][$run_at]['mode'];
				}
			}
		}
		return !empty($this->conf['default_mode']) ? $this->conf['default_mode'] : 'default';
	}

	/**
	* Load controller. Returns true on success and false otherwise
	* 
	* @param string $ctrlName
	* @return Controller
	*/
	final public function loadCtrl($ctrlName, $use_dir = 1)
	{
		$oCtrlName = $ctrlName;
        if (strpos($ctrlName, '-') !== false) {
            $ctrlName = str_replace('-', '_', $ctrlName);
        }
        $filename = $this->app_path.$this->conf['mvc']['dirs']['controllers']
			.($use_dir ? '/'.$ctrlName : '')
			.'/'.$ctrlName.'.ctrl.php';
		
		if (!file_exists($filename)) {
			$ctrlName = $this->conf['default_controller'];
			$filename = $this->app_path.$this->conf['mvc']['dirs']['controllers']
			.($use_dir ? '/'.$ctrlName : '')
			.'/'.$ctrlName.'.ctrl.php';
            $oCtrlName = null;
		}
		require_once $filename;
		$class      = ucfirst($ctrlName).'Controller';
		$ctrl = new $class($ctrlName, $this);
		if ($oCtrlName && misc::get($this->request->parr, 0) == $oCtrlName) {
			$ctrl->isDefault = 0;
			array_shift($this->request->parr);
			$this->request->url = implode('/', $this->request->parr);
		} else {
			$ctrl->isDefault = 1;
		}
		$ctrl->init();
		return $ctrl;
	}
	
	/**
	* Loafs common controller which if exists runs before any other controller and stops after it.
	* 
	* @return void
	*/
	final public function loadCommonCtrl()
	{
		require_once $this->app_path.$this->conf['mvc']['dirs']['controllers'].'/common.ctrl.php';
		$this->commonCtrl = new CommonController('common', $this);
	}
	
	/**
	* Runs zFramework application
	* 
	* @return void
	*/
	public function run()
	{
		debug::add_log("Run at: {$this->run_at}");
		debug::add_log("Mode: {$this->mode}");
		if (!empty($this->conf['title'])) {
			$this->page->appTitle = $this->conf['title'];
		}

		if (!empty($this->conf['charset'])) {
			mb_internal_encoding($this->conf['charset']);
		}
		if ($this->hasModel('settings', 'settings')) {
			$this->page->hasSettings = 1;
		}
/*		if (file_exists("{$this->app_path}requirer.php")) {
			$path = rtrim($this->app_path, '/');
			if (!file_exists(".zf_compiled/{$path}_requirer.php")) {
				require_once "{$this->app_path}/requirer.php";
				if ($this->mode !== 'development') zf::compileRequirer("{$this->app_path}requirer.php");
			} else {
				require_once ".zf_compiled/{$path}_requirer.php";
			}
		}*/
        
        require_once "{$this->app_path}/requirer.php";
        
        $this->after_requirer();
		ob_start();
		if ($this->conf['has_common_controller']) $this->loadCommonCtrl();
		$this->ctrl = $this->zf->initCtrl();

		$this->page->ctrlName = $this->ctrl->ctrlName;
		if ($this->commonCtrl) $ret_com = $this->commonCtrl->run();
		if (empty($ret_com)) {
			$this->ctrl->run();
			$this->ctrl->stop();
		}
		if ($this->commonCtrl) $this->commonCtrl->stop();
	}
	
	/**
	* Determines whether controller represented by $ctrlName can run action represented by $action
	* 
	* @param mixed $ctrlName
	* @param mixed $action
	* @return integer
	*/
	public function CanRun($ctrlName, $action, $data = array())
	{
		return 1;
	}
	
	public function cantRun($ctrlName, $action)
	{
		die("You can not run controller \"{$ctrlName}\" with action \"$action\"!");
	}

    protected function after_requirer()
    {
        
    }

	/**
	* A function for some debug stuff
	* 
	*/
	public function stop()
	{
        $eTime = misc::time() - $this->stime;
        debug::add_log("Time of execution - $eTime sec");	
		$content = ob_get_clean();
        if (empty($_SERVER['console'])) {
		    if ($this->contentType) header("Content-Type: {$this->contentType}; charset={$this->conf['charset']}", true);
		    header("X-Powered-By: zFramework", false);
        }
		if (empty($this->conf['modes'][$this->mode]['debug']['disabled']) && strpos($content, '<!--zf::debug:body-->') && empty($_SERVER['console'])) {
			ob_start();
			$this->page->load_debug_body('zf/views/debug_body');
			$debug_body = ob_get_clean();
			
			ob_start();
			$this->page->load_view('zf/views/debug_head');
			$debug_head = ob_get_clean();
			
			$content = str_replace(array('<!--zf::debug:head-->', '<!--zf::debug:body-->'), array($debug_head, $debug_body), $content);
		} else {
            if ($this->contentType == 'text/html') {
                $dbStat   = zf::$db->getStat();
                $content .= "\r\n\r\n<!-- execution time: $eTime -->\r\n";
                $content .= "\r\n<!-- db connection time: " . misc::get($dbStat, 'tconn') . " -->";
                $content .= "\r\n<!-- db execution time: " . misc::get($dbStat, 'tet') . " -->";
                $content .= "\r\n<!-- db performing time: " . misc::get($dbStat, 'tpt') . " -->";
            }
		}
        zf::$db->close();
        echo $content;
        return;
        $length = 1024;
        while ($content) {
            $out = substr($content, 0, $length);
            $content = substr($content, $length);
            echo $out;
        }
/*        if ($this->contentType == 'text/html') {
            echo '<!--/*';
        }*/
	}
	
	public function getModelConfFileName($modName, $ctrlName)
	{
		return $this->app_path.$this->conf['mvc']['dirs']['models'].(!empty($this->conf['mvc']['use_subdirs']['models']) ? '/'.$ctrlName : '')."/$modName.conf.yml";
	}
	
	public function hasModel($modName, $ctrlName = '')
	{
		return file_exists($this->getModelClassFileName($modName, $ctrlName));
	}
	
	public function getModelClassFileName($modName, $ctrlName)
	{
		return $this->app_path.$this->conf['mvc']['dirs']['models'].(empty($this->conf['mvc']['use_subdirs']['models']) ? '' : '/'.$ctrlName).'/'.$modName.'.mod.php';
	}
	
	/**
	* Destructor
	* 
	*/
	public function __destruct()
	{
//		debug::dump(zf::$db->db_stat);
//		echo '<h1 style="color: #990000;">'.(misc::time() - $this->stime).'</h1>';
//		debug::dump_all();
	}
        
    public function getCacher($conf_param = '.zf_cache', $ttl = 60, $adapter='filecache')
    {
        if (is_string($adapter)) {
            switch ($adapter) {
                case 'memcache':
                    $conf_param = $this->conf['run_at'][$this->run_at]['cacher'];
                    return new cacher($conf_param, $ttl, 'memcache');
                case 'filecache':
                    return new cacher($conf_param, $ttl, 'filecache');
            }
        }
    }
    
    public function beforeRequestInit()
    {
        
    }
}
?>
