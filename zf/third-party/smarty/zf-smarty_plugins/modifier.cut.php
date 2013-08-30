<?php
function smarty_modifier_cut($string, $length, $bound_symbols = ' ', $etc = '...', $go_forward = true)
{
    $strlen = strlen($string);
    if ($length >= $strlen) {
        return $string;
    }
    for ($i = $length; $go_forward ? $i < $strlen : $i > 0; $go_forward ? $i++ : $i--) {
        if (strpos($bound_symbols, $string[$i]) !== false) {
            return substr($string, 0, $i) . $etc;
        }
    }
    return $string;
}
?>
