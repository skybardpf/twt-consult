<?php 
class memcacheAdapter implements cacherIF
{
	private $cacher;
	
	protected $ttl;
	protected $defaultTtl;
	protected $data;
	
	public function __construct($conf, $ttl = 60)
	{
		$this->cacher = new Memcache;
		$this->cacher->pconnect($conf['host'], $conf['port']);
		$this->ttl = $this->defaultTtl = $ttl;
	}

	public function flush() {
		$this->cacher->flush();
	}

	public function put($dataKey, $data, $ttl = null)
	{
		$key     = md5($dataKey);
		$ttl     = $ttl ? $ttl : $this->ttl;
                $expires = time() + $ttl;
                $data[$key] = $expires;
		$this->cacher->set($key, $data, true, $ttl);
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
		$data=$this->cacher->get($key);
		if (!$data) {
			return cacher::NO_DATA;
		}
                $time = time();
                if ($time > $data[$key]) return cacher::EXPIRED;
		return $data;
	}
	
	public function version()
	{
		return $this->cacher->getVersion();
	}
}
?>