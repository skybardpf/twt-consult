<?php
/**
 * This file contains cacher class
 * 
 * @version 1.0, SVN: $Id: debug.class.php 40 2009-09-07 14:57:04Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * Class for caching
 * 
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
 
class filecacheAdapter
{
	
	protected $ttl;
	protected $defaultTtl;
	protected $dir;
	protected $data;
	
		
	public function __construct($dir, $ttl = 60)
	{
		$this->dir = rtrim($dir, '/').'/';
        if (!is_dir($this->dir)) {
            @mkdir($this->dir, 0777, true);
        }
		$this->ttl = $this->defaultTtl = $ttl;
	}

	public function flush() {
		misc::empty_dir(ROOT_PATH.$this->dir);
	}

	public function put($dataKey, $data, $ttl = null)
	{
		$key     = md5($dataKey);
		$ret     = isset($this->data[$key]) ? cacher::ALREADY_IN_CACHE : NULL;
		$ttl     = $ttl ? $ttl : $this->ttl;
		$expires = time() + $ttl;
        
		misc::file_safe_put("{$this->dir}$key.cache", serialize(array('expires' => $expires, 'datakey' => $dataKey, 'data' => $data)), "{$this->dir}$key.cache");
		$this->data[$key] = $expires;
		return $ret;
	}
	
	public function setTtl($ttl = null)
	{
		if ($ttl) {
			$this->ttl - $ttl;
		} else {
			$this->ttl = $this->defaultTtl;
		}
	}
	
	public function get($dataKey)
	{
		$key = md5($dataKey);
		if (!file_exists($this->dir.$key.'.cache')) {
			return cacher::NO_DATA;
		}

		$time = time();
		$result = file_get_contents($this->dir.$key.'.cache');
        if (!$result) {
            usleep(100);
            $result = file_get_contents($this->dir.$key.'.cache');
        }
        if ($result != false) {
            $result = unserialize($result);
            if ($result !== false) {
                if ($time > $result['expires']) {
                    return cacher::EXPIRED;
                }
                $data    = $result['data'];
            } else {
                return cacher::NO_DATA;
            }
        } else {
            return cacher::NO_DATA;
        }
		return $data;
	}
}
?>
