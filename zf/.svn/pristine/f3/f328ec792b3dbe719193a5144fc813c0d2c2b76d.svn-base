<?php 

/* 
 * Smarty plugin 
 * ------------------------------------------------------------- 
 * Type:     function 
 * Name:     md5hash 
 * Purpose:  return the md5() hash of a string 
 * ------------------------------------------------------------- 
 */ 
function smarty_function_sha1($params, &$smarty) 
{ 
    if (!in_array('value', array_keys($params))) { 
        $smarty->trigger_error("sha1: missing 'value' parameter"); 
        return; 
    } 

    $hash = sha1($params['value']); 
    return $hash; 
} 

?>