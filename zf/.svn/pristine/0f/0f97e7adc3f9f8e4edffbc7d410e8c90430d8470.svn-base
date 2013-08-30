<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_function_cur($params, &$smarty)
{
	if (is_array($params['arr'])) {
		$curr = current($params['arr']);
	} else {
		$curr = $params['arr'];
	}
	if (!empty($params['repl'])) {
		list($search, $replace) = explode("':'", $params['repl']);
		$search = trim($search, "'");
		$replace = trim($replace, "'");
		$curr = str_replace($search, $replace, $curr);
	}
	return $curr;
}

/* vim: set expandtab: */

?>
