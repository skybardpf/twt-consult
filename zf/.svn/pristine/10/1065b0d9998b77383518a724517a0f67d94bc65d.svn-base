<?php
/**
 * This file contains class for dealing with sessions.
 *
 * @version 1.0, SVN: $Id: session.class.php 42 2009-09-08 15:06:04Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * Class for dealing with sessions.
 *
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
class Session extends ConfLoader
{
	/**
	* Stores instance of the Session class
	* 
	* @var Session
	*/
	protected static $instance = NULL;
	
	/**
	* Stores session data
	* 
	* @var array
	*/
	protected $data;
	
	/**
	* Stores current session id
	* 
	* @var mixed
	*/
	protected $id;
	
	/**
	* Stores caller who was started session in string format
	* 
	* @var string
	*/
	protected $starter;
	
	/**
	* Indicates whether session was started
	* 
	* @var int
	*/
	protected $started = 0;
	
	/**
	* Initializes object.
	* 
	* @param array $conf If not specified default values will be used
	* @return Session
	*/
	protected function __construct($conf = array())
	{
		$this->conf = $conf;
		if (!empty($this->conf['save_path'])) {
			session_save_path(realpath($this->conf['save_path']));
		}
		if (!empty($this->conf['autostart'])) $this->start();
	}
	
	/**
	* Saves session data
	* 
	*/
	public function save()
	{
		$_SESSION = $this->data;
	}
	
	/**
	* Destructor. Saves session data
	* 
	*/
	public function __destruct()
	{
		if ($this->started) $this->save();
	}

    public function setLifeTime($lifetime) {
        setcookie(session_name(), session_id(), time() + ($lifetime ? $lifetime : $this->conf['lifetime']), '/');
    }

	/**
	* Starts session
	* 
	*/
	public function start($lifetime = NULL)
	{
		if ($this->started) {
			debug::add_log('session already started '.$this->starter);
			return;
		}
		session_name(!empty($this->conf['name']) ? $this->conf['name'] : 'zfSessionID');
        if (!empty($_GET['session_id_from_post']) && !empty($_POST[session_name()])) {
            session_id($_POST[session_name()]);
        }
		if ($lifetime || !empty($this->conf['lifetime'])) {
			$this->set_cookie_params($lifetime ? $lifetime : $this->conf['lifetime']);
			session_start();
			if (!empty($this->conf['update_lifetime'])) {
				setcookie(session_name(), session_id(), time() + ($lifetime ? $lifetime : $this->conf['lifetime']), '/');
			}
		} else {
			session_start();	
		}
		$this->starter = debug::getCaller(1);
		$this->data = $_SESSION;
		$this->id = session_id();
		$this->started = 1;
	}
	
	public function kill()
	{
		$this->data = array();
		//setcookie(session_name(), session_id(), time() - 10, '/');
	}
	
	public function set_cookie_params($lifetime, $path='/', $domain='', $secure=NULL, $httponly=NULL)
	{
		session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
	}
	
	public function close() 
	{
		if ($this->started){
			setcookie(session_name(), NULL, 10, '/');
			session_destroy();
			$this->started = 0;
		}
	}
	/**
	* Returns request object
	* 
	* @param array $vars_keys If not specified default values will be used
	* @return Request
	*/
	public static function getInstance($conf = array())
	{
		if (!self::$instance) {
			self::$instance = new Session($conf);
		}
		return self::$instance;
	}
	
	/**
	* Returns request object
	* 
	* @param array $conf If not specified default values will be used
	* @return Session
	*/
	public static function gi($conf = array())
	{
		return self::getInstance($conf);
	}
	
	/**
	* Returns $this->data[$name] value. If session is not started starts it.
	* 
	* @param string $name Name of the variable to return
	* @return mixed
	*/
	public function __get($name)
	{
		if (!$this->started) $this->start();
		return misc::get($this->data, $name, NULL);
	}
	
	/**
	* Sets $this->data[$name] value. If session is not started starts it.
	* 
	* @param string $name Name of the variable to return
	* @return void
	*/
	public function __set($name, $value)
	{
		if (!$this->started) $this->start();
		$this->data[$name] = $value;
	}
	
	/**
	* Returns $this->data[$name] value. If session is not started starts it.
	* 
	* @param string $name Name of the variable to return
	* @return mixed
	*/
	public function get($name)
	{
		if (!$this->started) $this->start();
		return misc::get($this->data, $name, NULL);
	}
	
	/**
	* Sets $this->data[$name] value. If session is not started starts it.
	* 
	* @param string $name Name of the variable to return
	* @return void
	*/
	public function set($name, $value)
	{
		if (!$this->started) $this->start();
		$this->data[$name] = $value;
	}

	/**
	 * Unsets $this->data[$name] value(s). If session is not started starts it.
	 *
	 * @param string|array $name Name of the variable to unset
	 */
	public function remove($name) {
		if (!$this->started) $this->start();
		if (is_array($name)) {
			foreach($name as $v) {
				if (isset($this->data[$v])) unset($this->data[$v]);
			}
		} elseif (isset($this->data[$name])) {
			unset($this->data[$name]);
		}
	}
}
?>
