<?php
function smarty_function_form($params, &$smarty)
{
    $smarty->form = $params['name'];
    return (isset($params['only_load']) && $params['only_load']) ? '' : $smarty->page->form($smarty->form)->getHeader();
}
?>
