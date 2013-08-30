<?php
function smarty_function_item($params, &$smarty)
{
    $data  = $params['from'];
    $field = $params['field'];
    $index = misc::get($params, 'index', 0);
    $repl  = !empty($params['replace']) ? explode(':', $params['replace']) : array();
    
    $i = 0;
    foreach ($data as $item) {
		if ($i++ == $index) return $repl ? str_replace($repl[0], $repl[1], $item[$field]) : $item[$field];
    }
    return '';
}
?>