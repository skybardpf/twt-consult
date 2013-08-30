<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty russian_date_format modifier plugin
 * format:
 * %sec - секунды - 20, 57
 * %min - минуты - 5, 48
 * %hou - часы - 11, 22
 * %mda - день - 7,30
 * %wda - номер дня недели - 1, 6
 * %mon - номер месяца - 1, 12
 * %yea - год - 2011
 * %wee - день недели - Среда либо Субботы (если 4 параметр true)
 * %mna - месяц - Январь либо Февраля (если 3 параметр true)
 * @author   Alexey Shatunov
 * 11.08.2011
 * @param timestamp
 * @param string
 * @param boolean
 * @param boolean
 * @return string|void
 */
function smarty_modifier_russian_date_format($string, $format = '%mda %mon %yea', $usemsuffix=true, $usewsuffix=false)
{
    if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}?/', $string)) {
        $parts = explode(' ', $string);
        $dparts = explode('-', $parts[0]);
        $tparts = explode(':', $parts[1]);
        $string = mktime($tparts[0], $tparts[1], $tparts[2], $dparts[1], $dparts[2], $dparts[0]);
    }elseif (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}?/', $string)) {
		$dparts = explode('-', $string);
		$string = mktime(0, 0, 0, $dparts[1], $dparts[2], $dparts[0]);
	}
	$date = getdate($string);
	unset($date[0]);
	$tempformat = preg_replace('/[^(%sec)(%min)(%hou)(%mda)(%wda)(%mon)(%yea)(%yda)(%wee)(%mna)]/', '', $format);
	while ($pos = strpos($tempformat, '%') !== false) {
		$literals[] = substr($tempformat, $pos, 3);
		$tempformat = substr($tempformat, $pos+3);
	}
	if (in_array('wee', $literals)) {
		if (!$usewsuffix) {
			$replace = array('Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье');
		} else {
			$replace = array('Понедельника', 'Вторника', 'Среды', 'Четверга', 'Пятницы', 'Субботы', 'Воскресенья');
		}
		$search = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
		$date['weekday'] = str_replace($search, $replace, $date['weekday']);
	}
	if (in_array('mna', $literals)) {
		if ($usemsuffix) {
			$month = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
		} else {
			$month = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');			
		}
		$date['month'] = $month[$date['mon']-1];
	}
	$search = array('%sec','%min','%hou','%mda','%wda','%mon','%yea','%yda','%wee','%mna');
	$replace = array($date['secons']<10?'0'.$date['secons']:$date['secons'],
        $date['minutes']<10?'0'.$date['minutes']:$date['minutes'],
        $date['hours']<10?'0'.$date['hours']:$date['hours'],$date['mday'],$date['wday'],$date['mon'],$date['year'],$date['yday'],$date['weekday'],$date['month']);
	$out = str_replace($search, $replace, $format);
	return $out;
}

