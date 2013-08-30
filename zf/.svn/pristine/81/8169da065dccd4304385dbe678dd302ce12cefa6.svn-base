<?php
/***
* Форматирует строку как цену.
* $with_decimals = 0 Строго без копеек
*                  1 Если цена "ровно" - без копеек (100 и 100.15)
*                  2 Строго с копейками (100.00)
* 
* @param mixed $string
* @param mixed $delim1000
* @param mixed $delimiter
* @param mixed $with_decimals
*/
function smarty_modifier_price($string, $delim1000 = ' ', $delimiter = ',', $with_decimals = 1)
{
    switch ($with_decimals){
        case 0:
            $ret = number_format($string, 0, '', $delim1000);
            break;
        case 1:
            if ($string - floor($string)) {
                $ret = number_format($string, 2, $delimiter, $delim1000);
            } else {
                $ret = number_format($string, 0, '', $delim1000);
            }
            break;
        case 2:
            $ret = number_format($string, 2, $delimiter, $delim1000);
            break;
    }
    return preg_replace(
        "/([^$delimiter]+)($delimiter)?([^$delimiter]*)/i",
        '<span class="integer">\1</span>\2<span class="decimal">\3</span>',
        $ret
    );
}
?>