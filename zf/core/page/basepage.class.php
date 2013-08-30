<?php
/**
 * This file contains BasePage class
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
class BasePage
{
	/**
	* Stores forms of the page
	* 
	* @var array
	*/
	protected $forms = array();
	
	/**
	* Stores page data
	* 
	* @var array
	*/
	protected $data = array();
	
	/**
	* Adds form to the page
	* 
	* @param string $formName
	* @param form $form
	*/
	public function addForm($formName, form $form)
	{
		if (isset($this->forms[$formName])) {
			debug::add_log("This page already have this form \"{$formName}\"", 'warning');
		}
		$this->forms[$formName]         = $form;
		$forms_elements                 = $this->get('forms_elements');
		if (!$forms_elements) $forms_elements = array();
		$this->set('forms_elements', array_merge($forms_elements, array($formName => $form->elArr)));
	}
	
	/**
	* Returns form object represented by $formName
	* 
	* @param string $formName
	* @return form
	*/
	public function form($formName)
	{
		if (!isset($this->forms[$formName])) {
			zf::halt("No such form has been loaded \"$formName\"");
			return null;
		}
		return $this->forms[$formName];
	}
	
	/**
	* Loads debug_body view
	* 
	* @param string $path
	*/
	public function load_debug_body($path)
	{
		$this->set('zfDebugData', debug::getData());
		$this->load_view($path);
	}
	
	/**
	* Calls method set of child class
	* 
	* @param string $name
	* @param mixed $value
	*/
	public function __set($name, $value)
	{
		return $this->set($name, $value);
	}
	
	/**
	* Sets value represented by parameters passed.
	* If $param4 passed sets $this->data[$param1][$param2][$param3] = $param4
	* if $param3 passed sets $this->data[$param1][$param2] = $param3
	* else $param2 passed sets $this->data[$param1] = $param2
	* 
	* @param string $param1
	* @param string $param2
	* @param string $param3
	* @param string $param3
	*/
	public function set($param1, $param2 = null, $param3 = null, $param4 = null)
	{
		if ($param4 !== null) $this->data[$param1][$param2][$param3] = $param3;
		elseif ($param3 !== null) $this->data[$param1][$param2] = $param3;
		else $this->data[$param1] = $param2;
	}
	
	/**
	* Returns value represented by parameters passed.
	* If $param3 passed returns $this->data[$param1][$param2][$param3]
	* if $param2 passed returns $this->data[$param1][$param2]
	* else returns $this->data[$param1]
	* 
	* @param string $param1
	* @param string $param2
	* @param string $param3
	*/
	public function get($param1, $param2 = null, $param3 = null)
	{
		if ($param3 !== null) return misc::get(misc::get(misc::get($this->data, $param1), $param2), $param3);
		if ($param2 !== null) return misc::get(misc::get($this->data, $param1), $param2);
		return misc::get($this->data, $param1);
	}
}
?>