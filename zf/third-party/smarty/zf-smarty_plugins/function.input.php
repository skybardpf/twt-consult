<?php
function smarty_function_input($params, &$smarty)
{
    $attrs = array();
    foreach ($params as $key => $val) {
    	if (in_array($key, array('simple', 'fs', 'num', 'form', 'name'))) continue;
    	
    	$attrs[$key] = $val;
    }
	
	$simple      = !empty($params['simple']) ? 1 : 0;
    $force_skeep = !empty($params['fs']) ? 1 : 0;
    $num         = isset($params['num']) ? $params['num'] : null;
    if (!empty($params['form'])) return $smarty->page->form($params['form'])->getInput($params['name'], $attrs, $force_skeep, $simple, $num);
    return $smarty->page->form($smarty->form)->getInput($params['name'], $attrs, $force_skeep, $simple, $num);
}
?>