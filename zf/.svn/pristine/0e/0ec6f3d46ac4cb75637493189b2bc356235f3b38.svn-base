<?php
/**
 * This file contains misc class
 * 
 * @version 1.0, SVN: $Id: misc.class.php 27 2009-09-01 22:32:28Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * Class contains set of miscellaneous static functions
 * 
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
class misc
{
	/**
	* Returns value in array $arr represented by key $key if this key exists or $default otherwise
	* 
	* @param array $arr
	* @param mixed $key
	* @param mixed $default
	* @return mixed
	*/
	static public function get($arr, $key, $default = null)
	{
		return isset($arr[$key]) ? $arr[$key] : $default; 
	}
    
    static public function getNe($arr, $key, $default = null)
    {
        if (!is_array($key)) return !empty($arr[$key]) ? $arr[$key] : $default; 
        foreach ($key as $k) {
            $val = self::getNE($arr, $k, null);
            if ($val) return $val;
        }
        return $default;
    }
	
	static function un_set($arr, $key)
	{
		unset($arr[$key]);
		return $arr;
	}

	static function remove($arr, $val)
	{
		$index = array_search($val, $arr);
		if ($index) unset($arr[$index]);
		return $arr;
	}
	
	/**
	* Returns time in seconds
	* 
	* @return float
	*/
	static public function time()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	
	static public function check_link($link)
	{
		$parts = parse_url($link);
		if (!isset($parts['scheme'])) return 'http://'.$link;
		return $link;
	}
	
	/**
	* Apply htmlspecialchars function recurcively to all elements of array passed
	* 
	* @param mixed $value
	* @return mixed
	*/
	static public function specialchars_deep($value)
	{
	   if (is_object($value)) return $value;
	   	$value = is_array($value) ?
				   array_map(array('misc', 'specialchars_deep'), $value) :
				   htmlspecialchars($value);
	   return $value;
	}
	
	/**
	* Returns cutted string
	* 
	* @param string $str
	* @param integer $max
	*/
	static public function cut($str, $max = 20, $max_max = 0)
	{
		if (str::utf8_strlen($str) <= $max) return $str;
		$index = 0;
		for ($i = 0; $i < str::utf8_strlen($str); $i++) {
			if (str::utf8_substr($str, $i, 1) == ' ' && $i >= $max) break;
		}
		return ($max_max ? str::utf8_substr($str, 0, $max_max) : str::utf8_substr($str, 0, $i)).'...';
	}
    
    static public function array_extract_field($arr, $field, $setKey = 0)
    {
        $ret = array();
        foreach ($arr as $arrKey => $arrElem) {
            if ($setKey) {
            	$ret[$arrKey] = $arrElem[$field];
			} else {
				$ret[] = $arrElem[$field];
			}
        }
        return $ret;
    }
	
	static public function stripslashes_deep($value)
	{
	   $value = is_array($value) ?
				   array_map(array('misc', 'stripslashes_deep'), $value) :
				   stripslashes($value);
	   return $value;
	}
	
	static public function htmlspecialchars_deep($value)
	{
		$value = is_array($value) ?
			array_map(array('misc', 'htmlspecialchars_deep'), $value) :
			htmlspecialchars($value);
		return $value;
	}
	
	static public function htmlspecialchars_decode_deep($value)
	{
	   $value = is_array($value) ?
				   array_map(array('misc', 'htmlspecialchars_decode_deep'), $value) :
				   htmlspecialchars_decode($value);
	   return $value;
	}
	
	static public function create_dir($dir, $chmod, $cur_dir = '.')
	{
		if (is_dir($dir)) return;
		$darr    = explode('/', $dir);
		
		$cur_dir = $cur_dir ? rtrim($cur_dir, '/').'/' : '';
		
		foreach ($darr as $dr) {
			if (!is_dir($cur_dir.$dr)) {
				mkdir($cur_dir.$dr);
				chmod($cur_dir.$dr, $chmod);
			}
			$cur_dir = $cur_dir.$dr.'/';
		}
	}
	
	static public function remove_dir($dir)
	{ 
		$dir = rtrim($dir, '\/');
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") {
						self::remove_dir($dir."/".$object);
					}
					else {
						unlink($dir."/".$object);
					}
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}
	
	static public function empty_dir($dir)
	{
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != ".." && $object != "Thumbs.db") {
					if (filetype($dir."/".$object) == "dir") {
						self::remove_dir($dir."/".$object);
					}
					else {
						unlink($dir."/".$object);
					}
				}
			}
		}
	}
    /**
    * Сравнивает телефоны между собой.
    * В случае, если хотя бы один из телефонов меньше минимальной длины, возвращет 0.
    * 
    * @param string $phone1 Первый телефон для сравнения
    * @param string $phone2 Второй телефон для сравнения
    * @param array $isNormalized См. код.
    * @param array $length  Допустимая длина телефона - массив вида ([минимальная длина], [максимальная длина])
    * @return 1 если телефоны совпадают и 0 если не совпадают
    */
    static public function comparePhone($phone1, $phone2, $isNormalized = array(), $length = array(5))
    {
        if (empty($isNormalized[0])) $phone1 = self::normalizePhone($phone1);
        if (empty($isNormalized[1])) $phone2 = self::normalizePhone($phone2);
        if (strlen($phone1) < $length[0] || strlen($phone2) < $length[0]) return 0;
        if (strlen($phone1) > strlen($phone2)) {
            return strpos($phone2, $phone1) !== false ? 1 : 0;
        } else {
            return strpos($phone1, $phone2) !== false ? 1 : 0;
        }
    }
    
    /**
    * Нормализует телефон. Т.е. оставляет только цифры, вырезая нечисловые символы.
    * 
    * @param string $phone
    */
    static public function normalizePhone($phone)
    {
        $ret = array();
        for ($i = 0; $i < strlen($phone); $i++) {
            if (!is_numeric($phone[$i])) continue;
            $ret[] = $phone[$i];
        }
        return implode('', $ret);
    }
    /**
     * Рекурсивно меняет одно значение ключа на другое
     * @param array $array
     * @param string $needed
     * @param string $replace
     */
	static public function changeArrayKeys(array $array, $needed, $replace)
	{
		$tmp_arr = array();
		foreach ($array as $key=>$val) {
			if ($key === $needed) {
				if (is_array($val)) $tmp_arr[$replace] = self::changeArrayKeys($val, $needed, $replace);
				else $tmp_arr[$replace] = $val;
			}
			else {
				if (is_array($val)) $tmp_arr[$key] = self::changeArrayKeys($val, $needed, $replace);
				else $tmp_arr[$key] = $val;
			}
		}
		return $tmp_arr;
	}
	/**
	 * Рекурсивно меняем одно значение массива на другое
	 * @param array $array
	 * @param string $needed
	 * @param string $replace
	 */
	static public function changeArrayVals(array &$array, $needed, $replace)
	{
		foreach ($array as $key=>&$val) {
			if ($val === $needed) $val = $replace;
			elseif (is_array($val)) self::changeArrayVals($val, $needed, $replace);
		}
		return $array;
	}
	/**
	* Inherits array
	* 
	* @param array $childArr
	* @param array $baseArr
	*/
	static public function inheritArray(&$childArr, $baseArr)
	{
		$childArr = array_merge_recursive($baseArr, $childArr);
	}

    static public function inheritArrayAdvanced($base, $child)
    {
        foreach ($child as $key => $value) {
            if (is_array($value)) {
                if (array_key_exists($key, $base)) {
                    $base[$key] = misc::inheritArrayAdvanced($base[$key], $value);
                } else {
                    $base[$key] = $value;
                }
            } else {
                $base[$key] = $value;
            }
        }
        return $base;
    }
    
    static public function arrayInsertAfter($array, $elementToInsert, $elementAfterInsertTo)
    {
        $index             = array_search($elementAfterInsertTo, $array);
        if ($index === false) {
            return $array;
        }
        return array_merge(
            array_slice($array, 0, $index + 1),
            array($elementToInsert),
            array_slice($array, $index + 1)
        );
    }
    /**
     * Функция запускает программы в фоновом режиме
     * @param string $path
     */
    static public function execInBg($path)
	{
		if (substr(php_uname(), 0, 7) == "Windows"){
			$WshShell = new COM("WScript.Shell"); 
			$oExec = $WshShell->Run($path, 7, false);
			unset($WshShell,$oExec); 
		} else {
			exec($path." > ".ROOT_PATH."/.zf_tmp/".date('Y-m-d_H-i-s_').md5($path).".log &");
		}
	}
    
    /**
     * Записывает файл, не давая другим процессам получить к нему доступ до окончания записи
     *
     * @param string $fileName Имя файла
     * @param string $content  Содержимое файла
     *
     * @return string, Если файл успешно записан, то true,
     *                 если записать файл не удалось, то false,
     *                 если такой файл уже записывается, то null
     */
    static public function file_safe_put($fileName, $content, $fileToUnlink = '')
    {
        $tmpFileName = $fileName . '.tmp';
        if (file_exists($tmpFileName)) return null;
        if (($fp = @fopen($tmpFileName, 'x')) === false) return null;
        if ($fileToUnlink && file_exists($fileToUnlink)) unlink($fileToUnlink);
        $result = fwrite($fp, $content);
        fclose($fp);
        return rename($tmpFileName, $fileName);
    }
	
	static public function convertSplitDate2dbDate($day, $month, $year)
	{
		$date = $year.'-'.$month.'-'.$day;
		return $date;
	}
	
	static public function convertToAge($date, $useStringPresenter=true) {		
		$bYear = intval(substr($date, 0, 4));
	 	$bMonth = intval(substr($date, 5, 2));
	 	$bDay = intval(substr($date, 8, 2));
		
		$cMonth = date('n');
    	$cDay = date('j');
    	$cYear = date('Y');
 
    	if(($cMonth >= $bMonth && $cDay >= $bDay) || ($cMonth > $bMonth)) {
        	$Age = $cYear - $bYear;
    	} else {
        	$Age = $cYear - $bYear - 1;
    	}
		
    	if ($useStringPresenter) {
			if(($Age>=5) && ($Age<=14)) $str = "лет";
			   else {
			   $num = $Age - (floor($Age/10)*10);
			   
			   if($num == 1) { $str = "год"; }
			   elseif($num == 0) { $str = "лет"; }
			   elseif(($num>=2) && ($num<=4)) { $str = "года"; } 
			   elseif(($num>=5) && ($num<=9)) { $str = "лет"; }
			   }
			 return $Age . " " . $str ; 
    	} else return $Age;
	}

    static public function int2ip($i) {
        $d[0]=(int)($i / 16777216);
        $d[1]=(int)(($i - $d[0]*16777216) / 65536);
        $d[2]=(int)(($i - $d[0]*16777216 - $d[1]*65536) / 256);
        $d[3]=$i - $d[0]*16777216 - $d[1]*65536 - $d[2]*256;
        return implode(".", $d);
    }

    static public function ip2int($ip) {
        $a = explode(".", $ip);
        return $a[0]*16777216 + $a[1]*65536 + $a[2]*256 + $a[3];
    }
    
    static public function getRealCmdPath($cmd)
    {
    	$paths = explode(PATH_SEPARATOR, $_SERVER['PATH']);
    	for ($i = 0; $i < count($paths); $i++) {
    		$real_path = rtrim($paths[$i],'\/').'/'.$cmd;
    		if (substr(php_uname(), 0, 7) == "Windows") {
    			if (!in_array(pathinfo($cmd, PATHINFO_EXTENSION), array('bat', 'exe', 'com', 'cmd'))) {
    				if (file_exists($real_path.'.bat')) return '"'.$real_path.'.bat"';
    				if (file_exists($real_path.'.exe')) return '"'.$real_path.'.exe"';
    				if (file_exists($real_path.'.com')) return '"'.$real_path.'.com"';
    				if (file_exists($real_path.'.cmd')) return '"'.$real_path.'.cmd"';
    			}
    		}
   			if (file_exists($real_path)) return $real_path;
    	}
    }
}
	
?>