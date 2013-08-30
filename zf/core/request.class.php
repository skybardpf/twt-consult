<?php
/**
 * This file contains class for operationing with browsers' request.
 *
 * @version 1.0, SVN: $Id: request.class.php 42 2009-09-08 15:06:04Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * Class for operationing with browsers' request.
 *
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
class Request
{
	/**
	* Stores instance of the Request class
	* 
	* @var Request
	*/
	protected static $instance = null;
	
	/**
	* Stores keys which are beeing treated as passed variables during URI parsing.
	* For example if id will be found in this array passing URI like .../id/23/... will set $this-vars['id'] = 23
	* 
	* @var array
	*/
	protected $vars_keys      = array();
	protected $preg_vars_keys = array();

	/**
	* Stores variables passed in URI.
	* @see $this->vars_keys description
	* 
	* @var array
	*/
	public $vars         = array();
	
	/**
	* Stores $_POST data
	* 
	* @var array
	*/
	public $post         = array();
	
	/**
	* Stores $_COOKIE data
	* 
	* @var array
	*/
	public $cookie       = array();
	
	/**
	* Stores $_FILES data
	* 
	* @var array
	*/
	public $raw_files    = array();
	
	/**
	* Stores performed $_FILES data
	* 
	* @var array
	*/
	public $files        = array();
	
	/**
	* Stores QUERY STRING data
	* 
	* @var string
	*/
	public $query        = '';
	
	/**
	* Stores REQUEST URI data
	* 
	* @var string
	*/
	public $uri          = '';
	
	/**
	* Stores path array data. For example uri like /company/about/ will be parsed into
	* <code>
	* $this->parr = array(
	*   0 => 'company',
	*   1 => 'about'
	* );
	* </code>
	* 
	* @var array
	*/
	public $parr         = array();
	
	
	
	/**
	* Stores only url without variables passed etc.
	* 
	* @var string
	*/
	public $url = '/';
	
	
	/**
	* Initializes object.
	* 
	* @param array $vars_keys If not specified default values will be used
	* @return Request
	*/
	protected function __construct($vars_keys = array(), $preg_vars_keys = array())
	{
		$this->vars_keys = $vars_keys ? $vars_keys : array('id', 'pid', 'item', 'page', 'captcha', 'ajax');
        $this->preg_vars_keys = $preg_vars_keys;
		$this->init();
	}
	
	/**
	* Returns request object
	* 
	* @param array $vars_keys If not specified default values will be used
	* @return Request
	*/
	public static function getInstance($vars_keys = array(), $preg_vars_keys = array())
	{
		if (!self::$instance) {
			self::$instance = new Request($vars_keys, $preg_vars_keys);
		}
		return self::$instance;
	}
	
	/**
	* Returns request object
	* 
	* @param array $vars_keys If not specified default values will be used
	* @return Request
	*/
	public static function gi($vars_keys = array(), $preg_vars_keys = array())
	{
		return self::getInstance($vars_keys, $preg_vars_keys);
	}
    
    public function parse_path($url)
    {
        $parts = parse_url($url);
        $query = urldecode(misc::get($parts, 'query'));
        $uri   = isset($parts['path']) ? urldecode($parts['path']) : '';
        $parr  = array();
        $post  = array();
        $vars  = array();

        if ($this->preg_vars_keys) {
           
            foreach ($this->preg_vars_keys as $var_name => $preg) {
                $matches = array();
  
    
                preg_match($preg['exp'], $uri, $matches);
                if (isset($preg['replace'])) {
                 
                    $uri = preg_replace(
                        isset($preg['replace_exp']) ? $preg['replace_exp'] : $preg['exp'],
                        $preg['replace'],
                        $uri
                    );
                }
                if ($matches) {
                    if (isset($preg['match_key'])) {
                        $key = $preg['match_key'];
                    } else {
                        $key = 1;
                    }
                    if (isset($matches[$key])) {
                        $vars[$var_name] = $matches[$key];
                    }
                }
            }
        }

        if (!$uri || $uri == '/') {
            $post = $_POST;
            $raw_files = $files = $_FILES;
            return array($uri, $parr, $vars, $query, $post);
        }

        $uri_arr  = explode('/', trim($uri, '/'));

        
        $mode     = 'p';     // 'p' - parsing path, 'v' - parsing vars, '!' - parsing post

        if (!empty($uri_arr) && $uri_arr[0] == trim(zf::$zf_root_url, '/')) {
            array_shift($uri_arr);    
        }
        $post_str = '';
        for ($i = 0; $i < count($uri_arr); $i++) {
            if ($uri_arr[$i] == '!' ) {
                if ($mode == '!') $mode = ''; else $mode = '!';
                continue;
            } elseif (in_array($uri_arr[$i], $this->vars_keys) && $mode != '!') {
                $mode = 'v';
            }
            switch ($mode) {
                case 'p': $parr[]             = $uri_arr[$i]; break;
                case 'v': $vars[$uri_arr[$i]] = misc::get($uri_arr, ++$i); break;
                case '!': 
                	$post_str .= $uri_arr[$i].'='.misc::get($uri_arr, ++$i).'&';
                break;
            }
        }
        if (!empty($post_str)) {
        	parse_str($post_str, $post);
        }
        if (!$post) $post   = misc::stripslashes_deep($_POST);
        return array($uri, $parr, $vars, $query, $post);
    }
	
	/**
	* Parses path by calling parse_path method. Sets $this->parr, $this->post, $this->vars, $this->raw_files and $this->files
	* 
	*/
	protected function init()
	{
        //if (!$this->files) $this->files = $_FILES;
        $this->raw_files = $this->files = $_FILES;
        list(
            $this->uri,
            $this->parr,
            $this->vars,
            $this->query,
            $this->post
        ) = $this->parse_path('http'.(!empty($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].'/'.ltrim($_SERVER['REQUEST_URI'],'/'));
		
		

	}
	
	/**
	* Returns $this->vars[$name] value
	* 
	* @param string $name Name of the variable to return
	* @return mixed
	*/
	public function __get($name)
	{
		return misc::get($this->vars, $name, null);
	}
	
	/**
	* Sets $this->vars[$name] = $value
	* 
	* @param string $name Name of the variable to set
	* @param mixed $value Value of the variable
	*/
	public function __set($name, $value)
	{
		$this->vars[$name] = $value;
	}
}
?>
