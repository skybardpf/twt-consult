<?php
function smarty_function_label($params, &$smarty)
{
	$attrs = array();
	foreach ($params as $key => $val) {
		if (in_array($key, array('simple', 'fs', 'num', 'form', 'name'))) continue;		 
		$attrs[$key] = $val;
	}
	if (!empty($params['form'])) return $smarty->page->form($params['form'])->getLabel($params['name'], $attrs);
	$force_skeep = !empty($params['fs']) ? 1 : 0;
	return $smarty->page->form($smarty->form)->getLabel($params['name'], $attrs, null, $force_skeep);
}
?>
