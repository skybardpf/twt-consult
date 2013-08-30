<?php
/**
 * Smarty ppgalleries modifier
 *
 * Type:     modifier<br>
 * Name:     ppgalleries<br>
 * Purpose:  replace [gallery=id] code with gallery in PP
 * @author   Zavter + Forgon
 * @param string
 * @return string
 */
function smarty_modifier_activate_links($string)
{
    $string = preg_replace("/([^\w\/])((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1http://$2", $string);
    $string = preg_replace("/([^\w\"'])((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1<a href=\"$2\" >$2</a>", $string);
    $string = preg_replace("/([^\w])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $string);

    return($string);
}
?>
