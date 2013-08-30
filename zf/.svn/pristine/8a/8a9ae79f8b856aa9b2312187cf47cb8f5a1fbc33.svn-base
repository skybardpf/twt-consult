<?php
/**
 * This file contains debug class
 * 
 * @version 1.0, SVN: $Id: debug.class.php 40 2009-09-07 14:57:04Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * Class for gathering and output debug information in zFramework
 * 
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
class debug
{
	/**
	* Used to storing debug data
	* 
	* @var array
	*/
	static protected $data = array();
	
	/**
	* Stores configuration of the debug module. Filled up by self::init() method
	* 
	* @var array
	*/
	static protected $conf = array();
	
	/**
	* Initializes debug module acourding to application settings
	*/
	static public function init()
	{
		$app = zf::gi()->app;
		$debug   = $app->conf['modes'][$app->mode]['debug'];
		switch ($debug['error_reporting']) {
			case 'E_ALL': error_reporting(E_ALL); break;
			case 'E_ALL-E_NOTICE': error_reporting(E_ALL & E_NOTICE); break;
			case 'E_ALL~E_STRICT': error_reporting(E_ALL & ~E_STRICT); break;
			case '0': error_reporting(0); break;
			default: error_reporting($debug['error_reporting']);
		}
		ini_set('display_errors', $debug['display_errors']);
		ini_set('log_errors', $debug['log_errors']);
		self::$conf = !empty($debug['disabled']) ? array() : array('store_codesniplets' => $debug['store_codesniplets']);
	}
	
	/**
	* Dumps all debug data.
	* 
	* @return void
	*/
	static public function dump_all()
	{
		if (!self::$conf) return;
		debug::dump(debug::$data);
	}
	
	/**
	* Dumps variable passed
	* 
	* @param mixed $var
	* @return void
	*/
	static public function dump($var)
	{
		echo self::getCaller(1);
		if (!self::$conf) return;
		echo '<pre>';
		print_r(misc::specialchars_deep($var));
		echo '</pre>';
	}
	
	/**
	* Returns dump of variable passed
	* 
	* @param mixed $var
	* @return string
	*/
	static public function get_dump($var)
	{
		if (!self::$conf) return;
		ob_start();
		debug::dump($var);
		return ob_get_clean();
	}
	
	/**
	* put your comment there...
	* 
	* @param mixed $getArr
	*/
	static public function getCaller($lvl = 0, $getArr = false)
	{
		if (!self::$conf) return;
		$trace = debug_backtrace();
		for ($i = 0; $i < $lvl; $i++) array_shift($trace);
		//debug::add($trace);
		//array_shift($trace);
		//$func = misc::get($trace, 'function');
		//if (strpos($func, 'require') === 0) array_shift($trace);
		//if (strpos($func, 'require') === 0) array_shift($trace);
		return $getArr ? array('file' => $trace[0]['file'], 'line' => $trace[0]['line']) : 'in file '.$trace[0]['file'].' at line '.$trace[0]['line'];
	}
	
	/**
	* Adds db log row to debug data
	* 
	* @param array $log_row
	* @return void
	*/
	static public function db_logger($log_row)
	{
		if (!self::$conf) return;
		$caller = misc::get($log_row, 'caller', array('file' => '', 'line' => ''));
		if (isset($log_row['caller'])) unset($log_row['caller']);
		$toAdd = array(
			'type'   => isset($log_row['error']) ? 'sql_error' : 'sql',
			'caller' => $caller,
			'body'   => misc::htmlspecialchars_deep($log_row)
		);
		
		debug::add_data($toAdd);
	}
	
	/**
	* Set caller and type in $row and adds it to debug::data by calling debug::add_data 
	* 
	* @param mixed $row
	* @return void
	*/
	static public function add($row, $type = 'common')
	{
		if (!self::$conf) return;
		$toAdd = array(
			'type' => $type,
			'body' => $row
		);

		$trace       = debug_backtrace();

		$toAdd['caller'] = array(
			'file' => $trace[0]['file'],
			'line' => $trace[0]['line']
		);
		
		debug::add_data($toAdd);
	}
	
	/**
	* Set caller and type in $row and adds it to debug::data by calling debug::add_data 
	* 
	* @param mixed $row
	* @return void
	*/
	static public function add_log($row, $type = 'log')
	{
		if (!self::$conf) return;
		$toAdd = array(
			'type' => $type,
			'body' => $row
		);

		$trace       = debug_backtrace();

		$toAdd['caller'] = array(
			'file' => $trace[0]['file'],
			'line' => $trace[0]['line']
		);
		
		debug::add_data($toAdd);
	}
	
	/**
	* Returns debug data
	* 
	* @return array
	*/
	static public function getData()
	{
		if (!self::$conf) return;
		return debug::$data;
	}
	
	/**
	* Returns code sniplet
	* 
	* @param array $caller Array with file and line of caller
	*/
	static private function get_code_sniplet($caller)
	{
		if (!self::$conf) return;
		if (!$caller['file']) return;
		$file    = file($caller['file']);
		$cnt     = count($file);
		$from    = $caller['line'] - 5 < 0 ? 0 : $caller['line'] - 5;
		$to      = $from + 10 > $cnt ? $cnt : $from + 10;
		$sniplet = array_slice($file, $from, $to - $from);
		
		for ($i = 0; $i < $to - $from; $i++) {
			$sniplet[$i] = ($from + $i == $caller['line'] - 1 ? '<b>#'.($from + $i + 1).'.</b> ' : '#'.($from + $i + 1).'. ').$sniplet[$i];
		}
		return htmlspecialchars(implode("\n", $sniplet));
	}
	
	/**
	* Simple adds $row to debug::data
	* 
	* @param array $row
	* @return void
	*/
	static private function add_data($row)
	{
		if (!self::$conf) return;
		$zfApp = zf::getInstance()->app;
		$row['code_sniplet'] = $zfApp->conf['modes'][$zfApp->mode]['debug']['store_codesniplets'] ?
			debug::get_code_sniplet($row['caller']) : 'no code sniplets storing set in config';

		debug::$data[] = $row;
	}
}
?>