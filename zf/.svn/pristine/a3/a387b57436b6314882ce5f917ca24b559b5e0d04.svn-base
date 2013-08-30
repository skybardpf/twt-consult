<?php
function smarty_block_call($params, $content, &$smarty)
{
    $name = $params['name'];
    $item = $params['item'];
    $key  = $params['key'];
    //$func = array(zf::gi()->app->ctrl, $name);
    $ctrl = zf::gi()->app->ctrl;                        
    if (method_exists($ctrl, $name)) {
        return call_user_func(array($ctrl, $name), $item, $key, $content);
    } else {
        return $content;
    }
}
?>
