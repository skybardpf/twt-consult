<?php
function smarty_block_hasRole($params, $content, &$smarty)
{
    $roleName   = $params['role'];
    if ($content && $ret = zf::gi()->app->hasRole($roleName)) {
		return $content;
    }
    else {
    	return '';
    }
}
?>