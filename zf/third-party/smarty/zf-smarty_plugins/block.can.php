<?php
function smarty_block_can($params, $content, &$smarty)
{
    if (!empty($params['url'])) {
    	$url = trim($params['url'], '/');
		if (strpos($url, '/') !== false) {
			list($ctrl, $action) = explode('/', $url);
		} else {
			$ctrl   = $url;
			$action = 'access';
		}
	} else {
		$ctrl   = $params['ctrl'];
		if (strpos($ctrl, '/') !== false) {
			$ctrl = misc::get(explode('/', trim($ctrl)), 0);
		}
    	$action = $params['action'];
	}
    $data   = array();
    unset($params['ctrl'], $params['action']);
    if (isset($params['data'])) {
        $data = $params['data'];
    } else {
        foreach ($params as $key => $value) {
            $data[$key] = $value;
        }
    }
    if ($content && $ret = zf::gi()->app->CanRun($ctrl, $action, $data)) {
		return is_string($ret) ? str_replace($params['action'], $ret, $content) : $content;
    }
}
?>