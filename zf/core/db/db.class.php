<?php
/**
 * This file contains class for abstract work with database
 * 
 * @version 1.0, SVN: $Id: db.class.php 27 2009-09-01 22:32:28Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com) 
 * @category Framework
 * @package zFramework
 * @subpackage DB
 */

/**
 * Class for abstract work with database
 * 
 * @category DataBase
 * @package zFramework
 * @subpackage DB
 */
class db
{
	const USE_CACHE_ALWAYS    = 1;
	const USE_CACHE_ON_DEMAND = 2;
	/**
	* Keep statistical data of db object.
	* This array has following structure and initial data:
	* <code> 
	* array(
	* 	'qcnt'  => 0, // total queries count
	* 	'tet'   => 0, // total execution time
	* 	'tpt'   => 0, // total performing time
	* 	'total' => 0 // total time
	* );
	* </code>
	* 
	* @var array
	*/
	public $db_stat;
	
	/**
	* Keep statistical data gathered by simple_logger method
	* 
	* @var array of array
	*/
	public $log_data;

	/**
	* Configuration array determining behavior of class object
	* This array has following structure and default data:
	* <code>
	* array(
	* 	'use_pconnect'      => 0, // whether to use permanent connection
	* 	'store_queries'     => 0, // whether to store unprepared queries
	* 	'store_raw_queries' => 0, // whether to store raw prepared queries
	* 	'store_results'     => 0, // whether to store queries' results
	* 	'store_caller'      => 0, // whether to store caller of the function
	* 	'store_times'       => 0, // whether to store times spent for executing and performing queries
	* 	'times_precision'   => 5, // precision of times stored (number of digits after decimal point)
	* );
	* </code>
	* @var array
	*/
	protected $conf;
	
	/**
	* Keeps statictical data for one separate query
	* <code>
	* array(
    *	'caller' => array(
    *		'file' => '[filename from where method was called]',
    *       'line' => '[line number in this file]'
    *   ),
	*	'query'     => '[unprepared query with args passed]',
    *	'raw_query' => '[prepared raw query]',
    *	'etime'     => '[time spent to execute query in seconds]',
    *	'ptime'     => '[time spent to perform query in seconds]',
    *	'result'    => '[result of query]' 
	*);
	* </code>
	* @var array
	*/
	protected $qstat;
	
	/**
	* Prefix for tables in database
	* 
	* @var string
	*/
	protected $prefix;
	
	/**
	* Contains error occured during query
	* 
	* @var string
	*/
	protected $error;
	
	/**
	* Type beeing waiting to return to user after query
	* 
	* @var string
	*/
	protected $ret_type;
	
	/**
	* Args passed to a method except query
	* 	
	* @var array
	*/
	private $args;
	
	/**
	* Query passed to class member
	* 
	* @var string
	*/
	private $query;
	
	/**
	* Last query passed
	* 
	* @var string
	*/
	private $last_query;
	
	/**
	* Start time. Using for determing times of exeqution and performing starting
	* 
	* @var float
	*/
	private $stime;
	
	/**
	* Link to a function beeing used for logging
	* 
	* @var handle to function 
	*/
	private $logger;
	
	/**
	* Link to a class beeing used for chaching
	* 
	* @var cacher
	*/
	protected $cacher      = null;
	
	protected $cache_level = null;
	
	protected $use_cache   = null;
	
	public $id;
	
	protected $dbName = '';
	
	protected $virtual_fields = array();
	
	/**
	* Initializes db object
	* 
	* @return void
	*/
	public function init()
	{
		$this->logger   = array($this, 'simple_logger');
		$this->log_data = array();
		$this->db_stat  = array(
			'qcnt'  => 0, // total queries count
			'tet'   => 0, // total execution time
			'tpt'   => 0, // total performing time
			'total' => 0, // total time
			'tconn' => 0  // time spent for connection
		);		
	}

	/**
	* Applaying configuration to db object
	* 
	* @param array $conf
	* @see db::$conf
	* @return void
	*/	
	public function apply_conf($conf)
	{
		$this->conf = array(
			'use_pconnect'      => isset($conf['use_pconnect']) ? $conf['use_pconnect'] : 0,
			'store_queries'     => isset($conf['store_queries']) ? $conf['store_queries'] : 0,
			'store_raw_queries' => isset($conf['store_raw_queries']) ? $conf['store_raw_queries'] : 0,
			'store_results'     => isset($conf['store_results']) ? $conf['store_results'] : 0,
			'store_caller'      => isset($conf['store_caller']) ? $conf['store_caller'] : 0,
			'store_times'       => isset($conf['store_times']) ? $conf['store_times'] : 0,
			'times_precision'   => isset($conf['times_precision']) ? $conf['times_precision'] : 5
		);
	}
	
	public function get_conf()
	{
		return $this->conf;
	}
		
	/**
	* Simple default logger just putting qstat
	*  
	* @param array $qstat
	* @see db::$qstat
	* @return void
	*/
	protected function simple_logger($qstat)
	{		
		$this->log_data[] = $qstat;
	}
	
	/**
	* Parsing dsn passed
	* 
	* @param string $dsn
	* @return array
	*/
    static private function parse_dsn($dsn)
    {
        return parse_url($dsn);
    }
    
    /**
    * Connect to database
    * 	
    * @param dsn $dsn DSN string
    * @param array $conf Conf array
    * @param string $dbcset Database connection character set
    * @see db::$conf
    * @return db
    */
    static public function connect($dsn, $dbcset, $conf = array(), $id = 0, $sql_mode = null)
    {
        $parsed = db::parse_dsn($dsn);
        $engine = isset($parsed['scheme']) ? $parsed['scheme'] : '';
        $host   = isset($parsed['host']) ? $parsed['host'] : '';
        $port   = isset($parsed['port']) ? $parsed['port'] : '';
        $user   = isset($parsed['user']) ? $parsed['user'] : '';
        $pass   = isset($parsed['pass']) ? $parsed['pass'] : '';
        $dbase  = trim(isset($parsed['path']) ? $parsed['path'] : '', '/');
        require_once ROOT_PATH.'zf/core/db/db_engines/'.$engine.'.class.php';
        $db = new $engine($host, $port, $user, $pass, $dbase, $dbcset, $sql_mode);
        $db->apply_conf($conf);
        $db->id = $id;
        return $db;
    }
    
    /**
    * Setting prefix to database tables
    *     
    * @param string $prefix
    * @return void
    */
    public function setPrefix($prefix)
    {
		$this->prefix = $prefix;
    }

    /**
     * Setting prefix to database tables
     *
     * @param string $prefix
     * @return void
     */
    public function getPrefix()
    {
    	return $this->prefix;
    }
    
    
    /**
    * Set log handler
    *    
    * @param handle $logger Handle to a function beeing used for handling db logs
    * @return void
    */
    public function setLogger($logger)
    {
		$this->logger = $logger;
    }
    
    /**
    * Set cacher
    *    
    * @param handle $cacher Handle to a object beeing used for caching
    * @return void
    */
    public function setCacher($cacher, $cache_level = DB::USE_CACHE_ALWAYS)
    {
		$this->cacher      = $cacher;
		$this->cache_level = $cache_level;
		if ($this->cache_level == DB::USE_CACHE_ALWAYS) {
			$this->use_cache = 1;
		} else {
			$this->use_cache = 0;
		}
    }
    
    public function use_cache($ttl = null)
    {
		$this->use_cache = 1;
		if ($ttl) $this->cacher->setTtl($ttl);
    }
    
    public function set_ret_type($ret_type = '')
    {
    	$this->ret_type = $ret_type;
    	$this->qstat['qtype'] = $ret_type;
    }
    
    /**
    * Performs executes query and return its result
    * Return null on fail if error during query occured
    * 
    * @return mixed
    */
    public function query()
    {
        $this->error    = false;
        if ($this->conf['store_caller']) $this->qstat['caller'] = $this->get_caller();
        $this->ret      = array();
        $this->args     = $this->args ? $this->args : func_get_args();

        $this->query    = $this->query ? $this->query : array_shift($this->args);
        if (is_array($this->args) && count($this->args) == 1 && is_array($this->args[0])) {
        	$this->args = $this->args[0];
		}
        if ($this->conf['store_queries']) $this->qstat['query'] = $this->query.', '.$this->arr2str($this->args);
        if ($this->conf['store_times']) $stime = $this->time();
        $this->prepare_query();
        $this->replace_placeholders();
		if ($this->conf['store_raw_queries']) $this->qstat['raw_query'] = $this->raw_query;
        if ($this->qtype == 'select' && $this->cacher && $this->use_cache) {
			$cache = $this->cacher->get($this->raw_query);
			if ($cache === cacher::EXPIRED || $cache === cacher::NO_DATA) $cache = null;
        } else {
			$cache = null;
        }
        
        
        if (!$cache && !$this->execute()) {
        	$this->qstat['error'] = $this->error;
        	$this->ret            = null;
        	if ($this->logger && $this->conf['store_queries']) call_user_func($this->logger, $this->qstat);
        	$this->qstat          = array();
	        $this->args           = array();
	        $this->last_query     = $this->query;
	        $this->query          = '';
	        $this->ret_type       = '';
	        $this->virtual_fields = array();
			return null;
        }
        
        if ($this->conf['store_times']) {
        	$t                    = $this->time();
        	$this->qstat['etime'] = round($t - $stime, $this->conf['times_precision']);
        	$stime                = $t;
		}
		
        if ($cache) {
			$this->ret            = $cache;
			$this->qstat['cache'] = 'Taken from cache';
        } else {
        	$this->perform_query();
		}
        
        if ($this->conf['store_times']) {
        	$this->qstat['ptime'] = round($this->time() - $stime, $this->conf['times_precision']);
		}
		        
        $this->args       = array();
        $this->last_query = $this->query;
        $this->query      = '';
        $this->ret_type   = '';
        $ret              = $this->ret;
        $this->ret        = null;
        if ($this->conf['store_results']) $this->qstat['result'] = $ret;
        if ($this->qstat && $this->logger && $this->conf['store_queries']) call_user_func($this->logger, $this->qstat);

        $this->db_stat['qcnt']++;
        if ($this->conf['store_times']) {
			$this->db_stat['tet']   += $this->qstat['etime'];
			$this->db_stat['tpt']   += $this->qstat['ptime'];
			$this->db_stat['total'] += $this->qstat['etime'] + $this->qstat['ptime'];
        }
        $this->qstat    = array();
        if ($this->cacher && !$cache && $this->qtype == 'select' && $this->use_cache) {
			$this->cacher->put($this->raw_query, $ret);
        }
        if ($this->cache_level == DB::USE_CACHE_ON_DEMAND) {
			$this->use_cache = 0;
			$this->cacher->setTtl();
        }
        $this->virtual_fields = array();
        return $ret;
    }
    
    /**
    * Prepares query
    * 
    * @return void
    */
    private function prepare_query()
    {
        if ($this->query == $this->last_query) return;
        $this->last_query = $this->query;
        $this->prepared   = preg_split("/(\?=>\?|\?lt|\?li|\?l|\?a|\?d|\?f|\?t|\n\r|\?i|\?)/", trim($this->query), -1 , PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE);
//      $this->qtype      = strtolower(substr($this->prepared[0][0], 0, strpos($this->prepared[0][0], ' ')));
        $this->qtype      = strtolower(preg_replace("/^\s*(\S+).*$/s", "\\1", str_replace('(', '', $this->query)));
    }
    
    public function add_prefix($var)
    {
		return str_replace('?_', $this->prefix, $var);
    }
    
    /**
    * Replaces placeholders in query
    * 
    * @return void
    */
    private function replace_placeholders()
    {
        $sql = '';
        $i   = 0;
        foreach ($this->prepared as $val) {
            switch ($val[0]) {
                case  '?': $val = $this->escape($this->args[$i++]); break;
                case '?d': $val = $this->escape($this->args[$i++], 'd'); break;
                case '?f': $val = $this->escape($this->args[$i++], 'f'); break;
                case '?t': $val =  $this->escape(str_replace('?_', $this->prefix, $this->args[$i++]), 't'); break;
                case '?i': $val = $this->escape($this->args[$i++], 'i'); break;
                case '?a':
                    $arr = $this->args[$i++];
                    $val = array();
                    foreach ($arr as $k => $v) {
                        $val[] = $this->escape($k, 't').' = '.$this->escape($v, $v === null ? 'i' : '');
                    }
                    $val = implode(', ', $val);
                break;
                case '?lt':
                    $arr = $this->args[$i++];
                    $val = array();
                    foreach ($arr as $k => $v) {
                        $val[] = $this->escape($v, 't');
                    }
                    $val = implode(', ', $val);
                break;

                case '?l':
                    $arr = $this->args[$i++];
                    $val = array();
                    foreach ($arr as $k => $v) {
                        $val[] = $this->escape($v);
                    }
                    $val = implode(', ', $val);
                break;

                case '?li':
                    $arr = $this->args[$i++];
                    $val = array();
                    foreach ($arr as $k => $v) {
                        $val[] = $v;
                    }
                    $val = implode(', ', $val);
                break;

                default: $val = $val[0];
            }
            $sql .= $val;            
        }
        $this->raw_query = $sql;
        
    }
    
    /**
    * Executes query and returns one record in assoc array format
    * 
    * @return array
    */
    public function assoc()
    {       
        $this->ret_type = $this->qstat['qtype'] = 'ASSOC';
        $this->args     = $this->args ? $this->args : func_get_args();
        $this->query    = $this->query ? $this->query : array_shift($this->args);
        return $this->query();
            
    }
    
    /**
    * Executes query and returns array of following format
    * <code>
    *   array(
    *       'key_1' => 'value_1',
    *       'key_2' => 'value_2',
    *       .
    *       .
    *       .
    *       'key_n' => 'value_n',
    *   )
    * <code>
    * 
    * where key_i - value of the first field in selection and value_i - value of the second key in selection
    * @return array
    */
    public function karr()
    {
        $this->ret_type = $this->qstat['qtype'] = 'KARR';
        $this->args     = $this->args ? $this->args : func_get_args();
        $this->query    = $this->query ? $this->query : array_shift($this->args);
        return $this->query();
            
    }
    
    /**
    * Executes query and returns array of following format
    * <code>
    *   array(
    *       'key_1' => Array_1,
    *       'key_2' => Array_2,
    *       .
    *       .
    *       .
    *       'key_n' => Array_n,
    *   )
    * <code>
    * 
    * where key_i - value of the first field in selection and Array_i - full row array without first field
    * @return array
    */
    public function fullKarr()
    {
        $this->ret_type = $this->qstat['qtype'] = 'FULL_KARR';
        $this->args     = $this->args ? $this->args : func_get_args();
        $this->query    = $this->query ? $this->query : array_shift($this->args);
        return $this->query();
            
    }
    /**
    * Executes query and returns array of following format
    * <code>
    *   array(
    *       'key_1' => Array_1,
    *       'key_2' => Array_2,
    *       .
    *       .
    *       .
    *       'key_n' => Array_n,
    *   )
    * <code>
    * 
    * where key_i - value of the first field in selection and Array_i - full row array without first field
    * @return array
    */
    public function fullKarrQuery()
    {
        $this->ret_type = $this->qstat['qtype'] = 'FULL_KARR_QUERY';
        $this->args     = $this->args ? $this->args : func_get_args();
        $this->query    = $this->query ? $this->query : array_shift($this->args);
        return $this->query();
            
    }
    
    public function groupKarr()
    {
    	$this->ret_type = $this->qstat['qtype'] = 'GROUP_KARR';
        $this->args     = $this->args ? $this->args : func_get_args();
        $this->query    = $this->query ? $this->query : array_shift($this->args);
        return $this->query();
    }
    
    /**
    * Executes query and returns one record in array format
    * 
    * @return array
    */
    public function arr()
    {
        $this->ret_type = $this->qstat['qtype'] = 'ARRAY';
        $this->args     = $this->args ? $this->args : func_get_args();
        $this->query    = $this->query ? $this->query : array_shift($this->args);
        return $this->query();
            
    }
    
    /**
	* Executes query and returns results in different formats
    *
    * @return mixed 
    */
    public function smart_query()
    {
        $this->ret_type = $this->qstat['qtype'] = 'SMART';
        $this->args     = $this->args ? $this->args : func_get_args();
        $this->mod      = array_shift($this->args);
        $this->query    = $this->query ? $this->query : array_shift($this->args);
        return $this->query();
    }
    
    /**
	* Executes query and returns one value from all records in array
	* 
    * @return array
    */
    public function col()
    {
        $this->ret_type = $this->qstat['qtype'] = 'COL';
        $this->args     = $this->args ? $this->args : func_get_args();
        $this->query    = $this->query ? $this->query : array_shift($this->args);
        return $this->query();
    }
    
    /**
    * Executes query and returns one scalar value
    * 
    * @return scalar
    */
    public function one()
    {
        $this->ret_type = $this->qstat['qtype'] = 'ONE';
        $this->args     = $this->args ? $this->args : func_get_args();
        $this->query    = $this->query ? $this->query : array_shift($this->args);
        return $this->query();
            
    }
    
    public function getVirtual()
    {
        $this->args            = $this->args ? $this->args : func_get_args();
        $mode                  = array_shift($this->args);
        $this->ret_type        = $this->qstat['qtype'] = 'VIRTUAL_'.strtoupper($mode);
        $this->query           = $this->query ? $this->query : array_shift($this->args);
        $ret                   = $this->query();
        return $ret;
    }
    
	public function getVirtualPage(&$total, $from, $num)
    {
    	$this->args            = $this->args ? $this->args : func_get_args();
    	array_shift($this->args);
        $this->from     = intval(array_shift($this->args));
        $this->num      = intval(array_shift($this->args));
        $this->ret_type        = $this->qstat['qtype'] = 'VIRTUAL_PAGE';
        $this->query           = $this->query ? $this->query : array_shift($this->args);
        $ret                   = $this->query();
        $total                 = $this->total;
        return $ret;
    }
    
    /**
    * Executes query and returns one page
    * 
    * @param integer $total Total records found
    * @param integer $from
    * @param mixed $num
    */
    public function page(&$total, $from, $num)
    {
        $this->ret_type = $this->qstat['qtype'] = 'PAGE';
        $this->args     = $this->args ? $this->args : func_get_args();
        array_shift($this->args);
        $this->from     = intval(array_shift($this->args));
        $this->num      = intval(array_shift($this->args));
        $this->query    = $this->query ? $this->query : array_shift($this->args);
        $ret            = $this->query();
        $total          = $this->total;
        return $ret;
    }
    
    /**
    * Returns time in seconds
    * 
    * @return float
    */
    protected function time()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
    
    /**
    * Returns caller
    * 
    * @return array 'file' => [file], 'line' => [line]
    */
    private function get_caller()
    {
		$trace = debug_backtrace();
        array_shift($trace);
        if ($this->ret_type) {
            array_shift($trace);
        }
        $trace  = array_shift($trace);
        return array('file' => $trace['file'], 'line' => $trace['line']);
    }
    
    /**
    * Return last error occured
    * 
    * @return string    
    */
    public function last_error()
    {
		return $this->error;		
    }
    
    /**
    * Converts array including subarrays into string
    * 
    * @param mixed $arr
    * @return string
    */
    static public function arr2str($arr)
    {
		if(!is_array($arr)) return $arr;
		$ret = array();
		foreach ($arr as $val) {
			$ret[] = is_array($val) ? 'Array('.implode(', ', $val).')' : $val;
		}
		return implode(', ', $ret);
    }
    
    /**
    * Convertes date from db to system format
    * 
    * @param db $db
    * @param string $date
    */
    static public function date_from_db($db, $date)
    {
        return $db->convert('date', 'from', $date);
    }
    
    /**
    * Convertes datetime from db to system format
    * 
    * @param db $db
    * @param mixed $date
    */
    static public function datetime_from_db($db, $date)
    {
        return $db->convert('datetime', 'from', $date);
    }
    
    /**
    * Convertes date from system format to db representative
    * 
    * @param db $db
    * @param mixed $date
    */
    static public function date_to_db($db, $date)
    {
        return $date === NULL ? 'null' : $db->convert('date', 'to', $date);
    }
    
    /**
    * Convertes datetime from system format to db representative
    * 
    * @param db $db
    * @param mixed $date
    */
    static public function datetime_to_db($db, $date)
    {
        return $date === NULL ? 'null' : $db->convert('datetime', 'to', $date);
    }
    
    public function getTableParams($params)
    {
        die ("Must be implemented in derived class!");
    }
    
    /**
    * Returns table structure
    * 
    * @param string $tableName
    * @return array
    */
    public function getTableStructure($tableName)
    {
		return $this->fullKarr($this->getDescSQL(), $tableName, 0);
    }
    
    public function tableExists($tableName)
    {
		return $this->one('show tables from ?t like ?', $this->dbName, $this->add_prefix($tableName));
    }
    
    public function getStat()
    {
        return $this->db_stat;
    }
}
?>