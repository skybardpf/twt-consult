<?php
/**
 * This file contains PageInterface interface
 * 
 * @version 1.0, SVN: $Id: page.class.php 27 2009-09-01 22:32:28Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Page
 */

/**
 * Page interface for derived from BasePage class which is responsible for page display
 * 
 * @category Framework
 * @package zFramework
 * @subpackage Page
 */
interface PageInterface
{
	public function loadView($view, $use_dir = 1, $ctrlName = 'page');
	public function load_view($path);
}
?>
