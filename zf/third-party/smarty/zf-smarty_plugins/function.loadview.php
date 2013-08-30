<?php
function smarty_function_loadview($params, &$smarty)
{
    $narr = explode('/', $params['name'], 2);
    unset($params['name']);
    foreach ($params as $key => $val) {
    	$smarty->assign($key, $val);
    }
    if (count($narr) == 1) return $smarty->page->loadView($narr[0], 0);
    if (count($narr) == 2) return $smarty->page->loadView($narr[1], 1, $narr[0]);
}
?>
