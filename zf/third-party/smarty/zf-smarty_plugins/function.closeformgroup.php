<?php
function smarty_function_closeformgroup($params, &$smarty)
{
    if (!empty($params['form'])) return $smarty->page->form($params['form'])->getRetForGroup(null, 1);
    return $smarty->page->form($smarty->form)->getRetForGroup(null, 1);
}
?>
