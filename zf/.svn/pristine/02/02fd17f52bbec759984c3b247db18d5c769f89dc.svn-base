<?php
function smarty_function_li($params, &$smarty)
{
    $simple = !empty($params['simple']) ? 1 : 0;
    $force_skeep = !empty($params['fs']) ? 1 : 0;
    if (!empty($params['form'])) return $smarty->page->form($params['form'])->getInput($params['name'], array(), $forse_skeep, $simple);
    return $smarty->page->form($smarty->form)->getLabelAndInput($params['name'], array(), $force_skeep, $simple);
}
?>