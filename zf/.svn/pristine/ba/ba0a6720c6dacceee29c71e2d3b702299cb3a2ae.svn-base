<?php

function smarty_modifier_readmore($string, $shrink_back = false)
{
    $pos = strpos($string, '[readmore]');
    if ($pos !== false) {
        $string = str_replace('[readmore]', '<div><span class="readmore">'.gettext('Read more').'</span><div style="display: none;">', $string).
            ($shrink_back ? '<span class="shrinkback">'.gettext('Minimize').'</span>' : '').'</div></div>';
    }
    return $string;
}

/* vim: set expandtab: */

?>
