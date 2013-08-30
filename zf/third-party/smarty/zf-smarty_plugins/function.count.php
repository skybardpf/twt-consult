<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty count function plugin
 *
 * Type:     function<br>
 * Name:     count<br>
 * Purpose:  подсчёт числа элементов в массиве
 * Example:  {count from=$array}
 *
 * @version 1.0
 * @param array
 * @return int
 */
function smarty_function_count($params,&$smarty)
{
    if (isset($params['from']))
    {
        if(is_array($params['from']))
        {
             return count($params['from']);
        }
        else
        {
            $smarty->_trigger_fatal_error("input must be array");
            return;
        }
    }
    else
    {
        $smarty->_trigger_fatal_error("input cannot be empty");
            return;
    }
}