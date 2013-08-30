<?php
function smarty_block_check_cond($params, $content, &$smarty)
{
	if ($content) {
        $item   = $params['item'];
        $action = $params['action'];
		if (!empty($action['cond'])) {
            if (!empty($action['cond']['eq']) && $item[$action['cond']['field']] != $action['cond']['eq']) {
                return '';
            }
            elseif(!empty($action['cond']['neq']) && $item[$action['cond']['field']] == $action['cond']['neq']) {
                return '';
            }
        }
	}
    return $content;
}
?>
