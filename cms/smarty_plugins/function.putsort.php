<?php
function smarty_function_putsort($params, &$smarty)
{
    $field  = $params['field'];
    $app    = zf::gi()->app;
    $sField = $app->request->sort;
    $dir    = $app->request->dir ? $app->request->dir : 0;
    
    if ($field != $sField) {
        $smarty->page->up   = 0;
        $smarty->page->down = 0;
    } else {
        $smarty->page->up   = $dir;
        $smarty->page->down = 1 - $dir;
    }
    
    $smarty->page->field = $field;
    return $app->ctrl->renderView(!empty($params['view']) ? $params['view'] : 'list_sort', 'actions');
}
?>