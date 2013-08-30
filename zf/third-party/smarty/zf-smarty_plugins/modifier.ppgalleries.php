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
function smarty_modifier_ppgalleries($string)
{
    return zf::gi()->app->commonCtrl->replace_galleries($string);
}
?>
