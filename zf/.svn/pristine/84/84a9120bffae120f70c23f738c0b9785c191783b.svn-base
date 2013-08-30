<?php
function smarty_function_redirect($params, &$smarty)
{
    $search = $replace = array();
	foreach ($params as $key => $val) {
    	if($key == 'url') continue;
    	$search[]  = "[$key]";
    	$replace[] = $val;
    }
    $params['url'] = str_replace($search, $replace, $params['url']);
    
	if (empty(zf::gi()->app->conf['modes'][zf::gi()->app->mode]['autoredirect'])) {
        return lang::p('go')." &mdash; <a href=\"{$params['url']}\">{$params['url']}</a>";
    } else {
        $delay = zf::gi()->app->conf['modes'][zf::gi()->app->mode]['autoredirect'];//empty($params['delay']) ? 2 : $params['delay'];
        return "<meta http-equiv=\"Refresh\" content=\"$delay; url='{$params['url']}'\" />";
    }
}
?>
