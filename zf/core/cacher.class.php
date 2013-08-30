<?php

class cacher implements cacherIF {
	const EXPIRED = 'CACHER_EXPIRED';
	const NO_DATA = 'CACHER_NO_DATA';
	const ALREADY_IN_CACHE = 'CACHER_ALREADY_IN_CACHE';

	private $adapter;

	public function __construct($dir = '.zf_cache', $ttl = 60, $adapter='filecache') {
		if ($adapter instanceof cacherIF) {
			$this->adapter = $adapter;
		} else {
			$adapterName = $adapter . 'Adapter';
			$this->adapter = new $adapterName($dir, $ttl);
		}
	}

	public function put($dataKey, $data, $ttl = null) {
		return $this->adapter->put($dataKey, $data, $ttl = null);
	}

	public function setTtl($ttl = null) {
		$this->adapter->setTtl($ttl = null);
	}

	public function get($dataKey) {
		return $this->adapter->get($dataKey);
	}

	public function __call($func, $args) {
		if (method_exists($this->adapter, $func)) {
			return call_user_func_array(array($this->adapter, $func), $args);
		} else {
			debug::add_log('Метод кэш-адаптера не найден', 'CACHER ERROR');
			return false;
		}
	}

	public function flush() {
		$this->adapter->flush();
	}

}

?>
