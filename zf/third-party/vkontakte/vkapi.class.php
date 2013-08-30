<?php

/**
 * VKAPI class for vk.com social network
 *
 * @package server API methods
 * @link http://vk.com/developers.php
 * @autor Oleg Illarionov
 * @version 1.0
 */
 
class vkapi {
	private $api_secret;
	public $app_id;
	public $api_url;
	public $oAuth_url;
	private $access_token;
	public $user_id;
	private $expire;
	
	public function vkapi($app_id, $api_secret, $api_url = 'api.vk.com/api.php', $oAuth_url = 'https://api.vkontakte.ru/method/') {
		$this->app_id = $app_id;
		$this->api_secret = $api_secret;
		$this->oAuth_url = $oAuth_url;
		if (!strstr($api_url, 'http://')) $api_url = 'http://'.$api_url;
		$this->api_url = $api_url;
	}

	/**
	 * @param string $access_token
	 */
	public function validate($cookie)
	{
		parse_str($cookie, $cookie);
		$secret = '';
		foreach (array('expire', 'mid', 'secret', 'sid') as $k) {
			$secret .= $k.'='.$cookie[$k];
		}
		if (md5($secret.$this->api_secret) == $cookie['sig']) {
			$this->access_token = $cookie['sid'];
			$this->user_id = $cookie['mid'];
			$this->expire = $cookie['expire'];
		}
	}
	
	public function api($method,$params=false) {
		if (!$params) $params = array(); 
		$params['api_id'] = $this->app_id;
		$params['v'] = '3.0';
		$params['method'] = $method;
		$params['timestamp'] = time();
		$params['format'] = 'json';
		$params['random'] = rand(0,10000);
		ksort($params);
		$sig = '';
		foreach($params as $k=>$v) {
			$sig .= $k.'='.$v;
		}
		$sig .= $this->api_secret;
		$params['sig'] = md5($sig);
		$query = $this->api_url.'?'.$this->params($params);
		$res = file_get_contents($query);
		return json_decode($res, true);
	}
	
	public function oAuth($method, $params = array())
	{
		$params['access_token'] = $this->access_token;
		return json_decode(file_get_contents(
			$this->oAuth_url.$method.'?'.http_build_query($params)
		), true);
	}
	
	private function params($params) {
		$pice = array();
		foreach($params as $k=>$v) {
			$pice[] = $k.'='.urlencode($v);
		}
		return implode('&',$pice);
	}
}
?>
