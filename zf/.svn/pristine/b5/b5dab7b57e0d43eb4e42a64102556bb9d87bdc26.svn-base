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
 * Page class is responsible for page display
 * 
 * @category Framework
 * @package zFramework
 * @subpackage Page
 */
class NativePage extends BasePage implements PageInterface
{
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	protected $extract_variables;
	
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	protected $extract_forms;

	
	public function __construct($conf)
	{
		$this->extract_variables = $conf['extract_variables'];
		$this->extract_forms = $conf['extract_forms'];
	}
	

	/**
	* Loads view presented by parameters passed. If $ctrlName not specified assigns it to "page"
	* 
	* @param string $view
	* @param string $ctrlName
	*/
	public function loadView($view, $use_dir = 1, $ctrlName = 'page')
	{
		$app = zf::gi()->app;
		if ($this->extract_variables) extract($this->data);
		if ($this->extract_forms) extract($this->forms);
		require $app->app_path.$app->conf['mvc']['dirs']['views'].($use_dir ? '/'.$ctrlName : '').'/'.$view.'.view.php';
	}
	
	/**
	* Loads view presented by parameters relative path
	* 
	* @param string $path
	*/
	public function load_view($path)
	{
		require "$path.view.php";
	}
}
?>