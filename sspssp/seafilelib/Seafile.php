<?php
namespace sspssp\seafilelib;
class Seafile
{
	private $server = NULL;
	private $user = NULL;
	private $pw = NULL;
	public function __construct()
	{
		$this->curl = new anlutro\cURL\cURL;
	}
	public function setServer($server)
	{
		$this->server = $server;
	}
	public function setUser($user, $pw)
	{
		$this->user = $user;
		$this->pw = $pw;
	}
	public function ping()
	{
		$r = $this->curl->get('http://seafile.byte.gs/api2/ping/');
		var_dump($r);
	}
}
?>