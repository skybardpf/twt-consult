<?php
/***
* Превращает дату формата <год><разделитель><месяц><разделитель><день><разделитель> в возраст.
* $useStringPresenter = true будет "16 лет", "24 года" ...
*                     = false будет "16", "24" ...
* 
* @param string $date
* @param boolean $useStringPresenter
*/
function smarty_modifier_age($date, $useStringPresenter=true)
{
    return misc::convertToAge($date, $useStringPresenter);
}
