<?php 

/* 
 * Smarty plugin 
 * ------------------------------------------------------------- 
 * Type:     function 
 * Name:     md5hash 
 * Purpose:  return the md5() hash of a string 
 * ------------------------------------------------------------- 
 */ 
function smarty_function_md5hash($params, &$smarty) 
{ 
    if (!in_array('value', array_keys($params))) { 
        $smarty->trigger_error("md5hash: missing 'value' parameter"); 
        return; 
    } 

    $hash = md5($params['value']); 
    return $hash; 
} 

?>