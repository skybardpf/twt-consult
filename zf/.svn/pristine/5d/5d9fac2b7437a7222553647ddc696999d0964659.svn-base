<?php
/**
 * This file contains base class for controllers in zFramework
 * 
 * @version 1.0, SVN: $Id: controller.class.php 42 2009-09-08 15:06:04Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * Base class for all controllers used in zFramework
 * 
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
class Controller extends ConfLoader
{
	/**
	* Stores handle of method to run
	* 
	* @var handle
	*/
	protected $method;
	
	/**
	* Stores action currently running
	* 
	* @var string
	*/
	public $action;
	
	/**
	* Stores name of the controller
	* 
	* @var string
	*/
	public $ctrlName;
	
	/**
	* Array for storing models loaded
	* 
	* @var array of Models
	*/
	protected $models = array();
	
	/**
	* Array for storing forms loaded
	* 
	* @var array of form
	*/
	protected $forms = array();
	
	/**
	* Stores configuration of the controller
	* 
	* @var array
	*/
	public $conf;
	
	/**
	* Object of page class
	* 
	* @var Page
	*/
	protected $page = null;
	
	/**
	* Shows whether controller is default
	* 
	* @var boolean
	*/
	public $isDefault;
	
	/**
	* Stores zfApp object
	* 
	* @var zfApp
	*/
	public $app;
    
    protected $tmp = null;
	
	/**
	* Stores action where to redirect after modifying or adding
	* 
	* @var string
	*/
	protected $retAction = 'list';
	
	protected $file_requested = false;
	
	public $listActions = array('modify', 'delete');
	public $AlistActions = array('add');
	/**
	 * View to load
	 * 
	 * @var string
	 */
	public $view = '';
	/**
	* Constructor. Loads configuration file of controller and does some init stuff
	* 
	*/
	public function __construct($ctrlName, $app)
	{
		$this->ctrlName = $ctrlName; 
		$this->app      = $app;
		$this->page     = $this->app->page;
		if (!$ctrlName) return;
	}
	
	/**
	* Loads view
	* 
	* @param string $view View name
	* @param string $ctrlName Name of controller which view to load. If not set assigned to controller::$ctrlName
	* @return void
	*/
	public function loadView($view, $ctrlName = '', $render = false, $cache_id = null)
	{
		//кеширование JS-ников
		if (!$render and $this->app->mode == 'production' && 0) {
			include_once './zf/third-party/packer/class.JavaScriptPacker.php';
        	$js = $this->page->pageJS;
        	$alljs = array('name' => '', 'names' => array(), 'urls' => array(), 'content' => array());
        	foreach ($js as $name => $path) {
        		if ($path[0] == '/' and is_file('.'.$path)) {
        			if (in_array($name, array('wysiwyg'))) {continue;}
        			$alljs['names'][] = $name;
        			$alljs['urls'][] = $path;
        			unset($js[$name]);
        		}
        	}
        	$alljs['name'] = '/public/site/js/'.md5(implode(';', $alljs['names'])).'.js';
        	if (!is_file('.'.$alljs['name'])) {
				foreach ($alljs['urls'] as $path) {
	        		if ($path[0] == '/' and is_file('.'.$path)) {
	        			$content = file_get_contents('.'.$path);
	        			if (strpos($content, 'function(p,a,c,k,e,d)') === false) {
		        			$jsp = new JavaScriptPacker($content);
		        			$alljs['content'][] = $jsp->pack();
		        			unset($jsp);
	        			} else {
	        				$alljs['content'][] = $content;
	        			}
	        		}
	        	}
	        	if (!empty($alljs['content'])) {
	        		misc::file_safe_put('.'.$alljs['name'], implode("\n", $alljs['content']));
	        	}
        	}
        	if (!empty($alljs['content'])) {
        		$this->page->pageJS = array_merge(array(md5(implode(';', $alljs['names'])) => $alljs['name']), $js);
        	}
        }
        
        
        $this->page->loadView(
            $view,
            empty($this->app->conf['mvc']['use_subdirs']['views']) ? 0 : ($ctrlName === null ? 0 : 1),
            $ctrlName ? $ctrlName : $this->ctrlName,
            $cache_id
        ); 
	}
	
	/**
	* Renders view
	* 
	* @param string $view View name
	* @param string $ctrlName Name of controller which view to load. If not set assigned to controller::$ctrlName
	* @return string
	*/
	public function renderView($view, $ctrlName = '', $cache_id = null)
	{
		ob_start();
		$this->loadView($view, $ctrlName, true, $cache_id);
		return ob_get_clean();
	}
	
	/**
	* Initializes controller
	* 
	* @return void
	*/
	public function init()
	{
		$action = misc::get($this->app->request->parr, 0, '');
		$this->method = ($action && method_exists($this, 'action'.ucfirst($action)))
			?
			array($this, 'action'.ucfirst($action)) : array($this, 'actionDefault');
		$this->action = $action;
	}
	
	/**
	* Runs controller
	* 
	* @return void
	*/
	public function run()
	{
        $action = $this->action ? $this->action : 'default';
        if ($this->method && $this->app->CanRun($this->ctrlName, $action)) {
	        if ($this->app->logger) {
	            call_user_func(
	                $this->app->logger, $this->app, $this->ctrlName, $this->action, $this->app->conf['use_logging'], 1
	            );
	        }
			call_user_func($this->method);
		} else {
			$this->app->cantRun($this->ctrlName, $this->action);
	        if ($this->app->logger) {
	            call_user_func(
	                $this->app->logger, $this->app, $this->ctrlName, $this->action, $this->app->conf['use_logging'], 0
	            );
	        }
		}
	}
    
	/**
	* Stops controller
	* 
	* @return void
	*/
	public function stop()
	{
		
	}
	
	/**
	* Loads Model represented by $modName and $ctrlName
	* 
	* @param string $modName
	* @param string $ctrlName
	* @return void
	*/
	public function loadModel($modName, $ctrlName = '')
	{
		if (!class_exists($modName.'Model')) {
			if (!$ctrlName) $ctrlName = $this->ctrlName;
			$filename = $this->app->getModelClassFileName($modName, $ctrlName);
	
			if (!file_exists($filename)) zf::halt("No such model found \"$modName\"! at $filename");
	
			require_once $filename;
		}
		$class = ucfirst($modName).'Model'; 
		$mod   = new $class($ctrlName, $modName, $this);
		$this->models[$modName] = $mod;
	}
	
	/**
	* Loads model by path
	* 
	* @param string $modName
	* @param string $path
	* @param string $ctrlName
	*/
	public function loadModelByPath($modName, $path, $ctrlName = '')
	{
		require_once $path;
		$class                  = ucfirst($modName).'Model'; 
		$mod                    = new $class($ctrlName ? $ctrlName : $this->ctrlName, $modName, $this, null, dirname($path));
		$this->models[$modName] = $mod;
		return $mod;
	}
	
	/**
	* Determines whether specified model exists
	* 
	* @param string $modName
	* @param string $ctrlName
	* @return void
	*/
	protected function modelExists($modName, $ctrlName = '')
	{
		if (!$ctrlName) $ctrlName = $this->ctrlName;
		return file_exists($this->zf->app->app_path.$this->zf->app->conf['models_dir'].'/'.$ctrlName.'/'.$modName.'.mod.inc');
	}
	
	/**
	* Returns loaded Model object represented by $modName and $ctrlName
	* 
	* @param string $modName
	* @param string $ctrlName
	* @return Model
	*/
	public function model($modName = null, $ctrlName = '')
	{
		if (!$modName) $modName   = $this->ctrlName;
        if (!$ctrlName) $ctrlName = $this->ctrlName;
		if (isset($this->models[$modName])) return $this->models[$modName];
		
		$this->loadModel($modName, $ctrlName);
		return $this->model($modName);
	}
	
	/**
	* Loads form into controller
	* 
	* @param string $formName
	* @param array $elements
	* @param array $arr
	* @param boolean $not_add_to_page 
	*/
	protected function loadForm($formName, $elements, $arr = array(), $action = '', $method = 'post', $not_add_to_page = false, $target = null, $id = null)
	{
		if (!$arr) {
			$arr = $this->app->request->post;
		} else {
			//$arr = $this->ConvertDates($elements, $arr);
		}
		
		
		//if (!$action) $action = $this->app->request->uri;
		
		$views = misc::get($this->app->conf, 'views');

		$form = new form($arr, $elements, $action, $formName, $method, misc::get($views, 'forms'), true, $target, $id);

		$form->ctrl = $this;
		if (isset($this->forms[$formName])) {
			debug::add_log("This controller already has loaded this form \"{$formName}\"", 'warning');
		}
		$this->forms[$formName] = $form;
		if (!$not_add_to_page) {
			$this->page->addForm($formName, $form);
		}
	}
	
	protected function ConvertDates($elements, $arr)
	{
		foreach ($elements as $name => $elem) {
			if (empty($elem['type'])) continue;
			switch ($elem['type']) {
				case 'date': $arr[$name] = db::date_from_db(zf::$db, $arr[$name]); break;
				case 'datetime': $arr[$name] = db::datetime_from_db(zf::$db, $arr[$name]); break;
			}
		}
		return $arr;
	}

	/**
	* Returns form represented by $formName
	* 
	* @param string $formName
	* @return form
	*/
	protected function form($formName)
	{
		if (isset($this->forms[$formName])) return $this->forms[$formName];
		zf::halt("No such form \"{$formName}\" loaded");
	}
	
	/**
	* Default action method for controller
	* 
	* @return void
	*/
	protected function actionDefault()
	{
		zf::halt("You can't call this function \"actionDefault\" directly. You must redefine it in your controller.");
	}
	
	/**
	* Not found action method for controller
	* 
	* @return void
	*/
	protected function actionNotFound()
	{
		zf::halt("You can't call this function \"actionNotFound\" directly. You must redefine it in your controller.");
	}
	
	public function getAction()
	{
		return $this->action;
	}	
	
	protected function ListIt($model, $view, $pid_fld = '', $pid = 0, $oby = 'pos', $dir = 'asc', $action = 'list')
	{
		if ($this->zf->getVar('pos')) $this->model($model)->lift($this->zf->getVar('id'), $this->zf->getVar('pos'), $this->zf->getVar('pid'));
		
		
		$this->setCommonListActions($model);
		$this->setCommonAlistActions($pid);

		
		$this->page->set('pid_fld', $pid_fld);
		$this->page->set('list', $this->model($model)->getList('list', $pid_fld, $pid, $oby, $dir));
		$this->page->set('listFields', $this->model($model)->getFields('list'));
		$this->page->set($view, $this->renderView('list', 'common'));
	}
	
	/*
	protected function gerRetLink($retAction = 'list')
	{
		if (strpos($this->action, '_') === false) return str_replace($this->action, $retAction, $this->zf->uri);
	}
	*/
	
	public function attachForm($page, $fieldName)
	{
		$isForm = preg_match("/%\{form:([^\}]+)\}%/", $page[$fieldName], $out);
		if (!$isForm) return $page;
		$form = $this->getCtrl('forms')->getForm($out[1]);
		if (is_array($form) && !$form[1]) {
			$page[$fieldName] = $form[0];
		} else {
			$page[$fieldName] = preg_replace("/%\{form:([^\}]+)\}%/", is_array($form) ? $form[0] : $form, $page[$fieldName]);
		}
		return $page;
	}
	
	/**
	* Gets controller. Returns Controller
	* 
	* @param string $ctrlName
	* @return Controller
	*/
	public function getCtrl($ctrlName, $use_dir = 1)
	{
		$filename = $this->zf->app->app_path.$this->zf->app->conf['controllers_dir'].($use_dir ? '/'.$ctrlName : '').'/'.$ctrlName.'.ctrl.inc';

		//if ($this->conf['mode'] != 'prod' && !file_exists($filename)) return null;
		
		require_once $filename;
		$class      = ucfirst($ctrlName).'Controller';
		$ctrl = new $class($ctrlName);

		if (misc::get($this->zf->path, 0) == $ctrlName) {
			$this->ctrl->isDefault = 0;
			array_shift($this->zf->path);
		} else {
			$this->ctrl->isDefault = 1;
		}
		$ctrl->init();
		return $ctrl;
	}
	
	public function checkUnique($model, $field, $value)
	{
		return $this->model($model)->checkUnique($field, $value);
	}
	
	/**
	* Load controller. Returns true on success and false otherwise
	* 
	* @param string $ctrlName
	* @return Controller
	*/
	public function loadCtrl($ctrlName, $use_dir = null)
	{
		if ($use_dir === null) {
			$use_dir = $this->app->conf['mvc']['use_subdirs']['controllers'];
		}
		$filename = $this->app->app_path.$this->app->conf['mvc']['dirs']['controllers'].($use_dir ? '/'.$ctrlName : '').'/'.$ctrlName.'.ctrl.php';

		if ($this->app->mode != 'production' && !file_exists($filename)) return false;
		
		require_once $filename;
		$class      = ucfirst($ctrlName).'Controller';
		return new $class($ctrlName, $this->app);
	}
	
	protected function outputFile($file_name, $file_content, $content_type = 0)
	{
		$this->file_requested = true;
		if (!$content_type) {
			$user_agent = misc::get($_SERVER, 'HTTP_USER_AGENT');
			if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $user_agent)) $UserBrowser = "Opera"; 
			elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $user_agent)) $UserBrowser = "IE"; 
			else $UserBrowser = '';
			$content_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
		}
		header("Content-Length: ".strlen($file_content));
		header('Content-Type: ' . $content_type); 
		header('Content-Disposition: attachment; filename="'.$file_name.'"'); 
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header('Accept-Ranges: bytes'); 
		header("Cache-control: private"); 
		header('Pragma: private');
		
		echo $file_content; 
	}
}
?>
