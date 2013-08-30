<?php
/**
 * This file contains NativePage class
 * 
 * @version 1.0, SVN: $Id: page.class.php 27 2009-09-01 22:32:28Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Page
 */

/**
 * Page class is responsible for page display using Smarty
 * 
 * @category Framework
 * @package zFramework
 * @subpackage Page
 */
class SmartyPage extends BasePage implements PageInterface
{
	/**
	* Stores Smarty object
	* 
	* @var Smarty
	*/
	protected $smarty;
	protected $partial_caching = false;
	
	public function __construct($conf)
	{
		$this->smarty                = new Smarty();
		$this->smarty->compile_dir   = $conf['compile_dir'];
		if (!empty($conf['cache_dir'])) $this->smarty->cache_dir = $conf['cache_dir']; 
		$this->smarty->debugging     = empty($conf['debug']) ? 0 : 1;
		$this->smarty->plugins_dir[] = ROOT_PATH.'zf/third-party/smarty/zf-smarty_plugins/';
		$this->smarty->page          = $this;
		$this->smarty->form          = null;
		$this->smarty->assign('root_url', zf::$root_url);
		$this->smarty->assign('zf_root_url', zf::$zf_root_url);
		$this->smarty->assign('host', zf::gi()->host);
		if (!empty($conf['partial_caching'])) $this->partial_caching = true;
	}
	
	public function addPluginsDir($dir)
	{
		$this->smarty->plugins_dir[] = ROOT_PATH.$dir;
	}
	
	/**
	 * @return Smarty
	 */
	public function smarty()
	{
		return $this->smarty;
	}
	
	/**
	* Sets value represented by parameters passed.
	* If $param3 passed sets $this->data[$param1][$param2] = $param3
	* if $param2 passed sets $this->data[$param1] = $param2
	* 
	* @param string $param1
	* @param string $param2
	* @param string $param3
	*/
	public function set($param1, $param2 = null, $param3 = null, $param4 = null)
	{
		parent::set($param1, $param2, $param3, $param4);
		$this->smarty->assign($param1, parent::get($param1));
	}
	
	/**
	* Returns value represented by parameters passed. If $param2 is set returns $this->data[$param1][$param2] if not $this->data[$param1]
	* 
	* @param string $param1
	* @param string $param2
	*/
	public function get($param1, $param2 = null, $param3 = null)
	{
		if ($param3 !== null) return misc::get(misc::get(misc::get($this->smarty->_tpl_vars, $param1), $param2), $param3);
		if ($param2 !== null) return misc::get(misc::get($this->smarty->_tpl_vars, $param1), $param2);
		return misc::get($this->smarty->_tpl_vars, $param1);
	}
	
	/**
	* Returns $this->smarty->_tpl_vars[$name] value
	* 
	* @param string $name
	* @return mixed
	*/
	public function __get($name)
	{
		return isset($this->smarty->_tpl_vars[$name]) ? $this->smarty->_tpl_vars[$name] : null;
	}
	
	/**
	* Loads view presented by parameters passed. If $ctrlName not specified assigns it to "page"
	* 
	* @param string $view
	* @param bool $use_dir
	* @param string $ctrlName
	*/
	public function loadView($view, $use_dir = 1, $ctrlName = 'page', $cache_id = null)
	{
		$app = zf::gi()->app;		
		$this->smarty->assign('request', array_merge($app->request->vars, array('parr' => $app->request->parr), array('post' => $app->request->post)));
		if ($cache_id != null && $this->partial_caching) $this->smarty->caching = true;
		$this->smarty->display(
			$app->app_path.$app->conf['mvc']['dirs']['views'].($use_dir ? '/'.$ctrlName : '').'/'.$view.'.tpl',
			$cache_id
		);
		if ($cache_id != null && $this->partial_caching) $this->smarty->caching = false;
		debug::add_log("loaded view \"$view\"");
	}
	
	/**
	* Loads view presented by parameters relative path
	* 
	* @param string $path
	*/
	public function load_view($path)
	{
		$this->smarty->display(ROOT_PATH."$path.tpl");
	}
}
?>