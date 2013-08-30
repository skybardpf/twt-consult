<?php
/**
 * This file contains lang class
 * 
 * @version 1.0, SVN: $Id: lang.class.php 27 2009-09-01 22:32:28Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * Class contains static lang methods
 * 
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
class lang
{
	protected static $lng = null;
	protected static $phrases_map = array(
		'rus' => array(
			'yes'                   => 'да',
			'no'                    => 'нет',
			'mail_incorrect'        => 'Неверный формат адреса электронной почты!',
			're_mail_not_match'     => 'Поля E-mail и подтверждение E-mail не совпадают!',
			'captcha_error'         => 'Неверно введены символы, которые были изображены на картинке!',
			'go'                    => 'перейти',
			'move_up'               => 'переместить выше',
			'move_down'             => 'переместить ниже',
			'no_objects'            => 'объектов не найдено',
			'delete_object?'        => 'Вы уверены, что хотите удалить этот объект?',
			'delete_object_success' => 'Объект успешно удален.',
			'delete_object_fail'    => 'Объект удалить не удалось.',
			'delete_file?'          => 'Вы уверены, что хотите удалить файл?',
			'delete_file_success'   => 'Файл успешно удален.',
			'delete_file_fail'      => 'Файл удалить не удалось.',
			'file_not_allowed_ext'  => 'Загружать файлы с расширением [ext] не разрешено!',
			'file_upload_failure'   => 'Не удалось загрузить файл в [filename]!',
			'mustbe_filled'         => 'Поле "{title}" должно быть заполнено!',
			'form_upload_images'    => 'закачать изображения',
            'check_all'             => 'выделить все',
            'open'                  => 'открыть',
            'pos_changed'           => 'Позиция элемента успешно изменена.',
            'undeletable'           => 'Это системный объект, его удалить нельзя.',
            'not_a_unique'          => 'Такое значение поля "{title}" уже есть в базе!',
            'not_a_number'          => 'Значение в поле "{title}" должно быть числовым!',
            'map_open'				=> 'Открыть карту',
			'map_close'				=> 'Закрыть карту',
            'not_date_future'       => 'Необходимо указывать дату, начиная со дня, следующего за текущим!',
            'not_packing_size'      => 'Надо вводить размеры упаковки в виде - [число] х [число] х [число] !',
            'not_a_unique_mail'     => 'Такой адрес уже зарегистрирован!',
            'not_a_positive_number' => 'Значение в поле "{title}" должно быть положительным!',
            'password_incorrect'    => 'Введен неправильный пароль. Вы можете использовать любые буквы, цифры и спец. символы(@!#-+=). Длина пароля от 6 до 32 символов.',
			'start_end_date_incorrect' => 'Даты начала и окончания указаны неверно.',
            'is_opened'             => 'Этот объект уже редактируется другим пользователем.'
		),
		'eng' => array(
			'yes'                   => 'yes',
			'no'                    => 'no',
			'mail_incorrect'        => 'Incorrect E-mail format!',
			're_mail_not_match'     => 'Field E-mail and E-mail confirm dont match!',
			'captcha_error'         => 'Incorrect captcha symbols entered!',
			'go'                    => 'go',
			'move_up'               => 'move up',
			'move_down'             => 'move down',
			'no_objects'            => 'no objects found',
			'delete_object?'        => 'Are you shure you want to delete this object?',
			'delete_object_success' => 'Object successfully deleted.',
			'delete_object_fail'    => 'Object deletion failed.',
			'delete_file?'          => 'Are you shure you want to delete this file?',
			'delete_file_success'   => 'File successfully deleted.',
			'delete_file_fail'      => 'File deletion failed.',
			'file_not_allowed_ext'  => 'Uploading of files with extension "[ext]" are not permitted!',
			'file_upload_failure'   => 'Uploading file to "[filename]" failed!',
			'mustbe_filled'         => 'Field "{title}" must be filled!',
			'form_upload_images'    => 'upload images',
            'check_all'             => 'select all',
            'open'                  => 'open',
            'pos_changed'           => 'Position of the element successfully changed.',
            'undeletable'           => 'This is system object. You can\'t delete it.',
            'not_a_unique'          => 'Such data of field "{title}" already exists in DB!',
            'not_a_number'          => 'Value of field "{title}" must be numeric!',
            'map_open'				=> 'Open map',
			'map_close'				=> 'Close map',
            'not_date_future'       => 'You must specify date from day after current!',
            'not_packing_size'      => '',
            'not_a_unique_mail'     => 'Such E-mail already registerred!',
            'not_a_positive_number' => 'Value of field "{title}" must be positive!',
            'password_incorrect'    => 'Incorrect password specified. You can use any of letters, numbers and special symbols (@!#-+=). Length must be from 6 up to 32 symbols.',
			'start_end_date_incorrect' => 'Start and end dates are incorrect.',
            'is_opened'             => 'This object is opened by other user.'
        )
	);
    
    static function has($key)
    {
        if (!lang::$lng) {
            lang::$lng = misc::get(zf::gi()->app->conf, 'language', null);
            if (!lang::$lng) lang::$lng = misc::get(array_keys(lang::$phrases_map), 0);
        }
        return isset(self::$phrases_map[self::$lng][$key]);  
    }
	
	public static function p($key, $patt = '', $repl = '')
	{
		if (!lang::$lng) {
			lang::$lng = misc::get(zf::gi()->app->conf, 'language', null);
			if (!lang::$lng) lang::$lng = misc::get(array_keys(lang::$phrases_map), 0);
		}
		if (lang::$lng == 'rus' && ($to_charset = zf::gi()->app->conf['charset']) != 'utf-8') {
			$pm = iconv('utf-8', $to_charset, lang::$phrases_map[lang::$lng][$key]);
		} else {
			$pm = lang::$phrases_map[lang::$lng][$key];
		}
		if ($patt && $repl) {
			$ret = str_replace($patt, $repl, $pm);
			
		} else {
			$ret = $pm;
		}
		return $ret;
	}
    
    public static function setLang($lang)
    {
        self::$lng = $lang == 'ru' ? 'rus' : $lang;
        if (empty(self::$phrases_map[self::$lng])) {
        	self::$phrases_map[self::$lng] = self::$phrases_map['eng'];
        }
    }
    
	public static function transliterate($st) {
		$st = iconv('utf-8', 'cp1251', $st);
		$st = strtr($st, 
			iconv('utf-8', 'cp1251', "абвгдежзийклмнопрстуфыэАБВГДЕЖЗИЙКЛМНОПРСТУФЫЭ "),
			"abvgdegziyklmnoprstufieABVGDEGZIYKLMNOPRSTUFIE_"
		);
		$hs = array(
			'ё'=>"yo",  'х'=>"h", 'ц'=>"ts", 'ч'=>"ch", 'ш'=>"sh",  
			'щ'=>"sch", 'ъ'=>'--', 'ь'=>"-",  'ю'=>"yu", 'я'=>"ya",
			'Ё'=>"Yo",  'Х'=>"H", 'Ц'=>"Ts", 'Ч'=>"Ch", 'Ш'=>"Sh",
			'Щ'=>"Sch", 'Ъ'=>'--', 'Ь'=>"-",  'Ю'=>"Yu", 'Я'=>"Ya",
		);
		$hs_cp = array();
		foreach ($hs as $k=>$h) {
			$hs_cp[iconv('utf-8', 'cp1251', $k)] = iconv('utf-8', 'cp1251', $h);
		}
		
		$st = strtr($st, $hs_cp);
		
		return iconv('cp1251', 'ISO-8859-1', $st);
}
}
?>