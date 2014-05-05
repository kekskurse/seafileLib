<?php
namespace sspssp\seafilelib;
class Seafile
{
	private $server = NULL;
	private $user = NULL;
	private $pw = NULL;
	public function __construct()
	{
		$this->curl = new \anlutro\cURL\cURL;
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
	public function getAuthToken()
	{
		if($this->user==Null OR $this->pw ==NULL)
		{
			trigger_error("Username or Password is NULL");
		}
		$r = $this->curl->post($this->server.'/api2/auth-token/', ["username"=>$this->user, "password"=>$this->pw]);
		if($r->statusCode!=200)
		{
			trigger_error("Faild get AuthToken");
		}
		$detais = json_decode($r->body, true);
		$this->token = $detais["token"];
		return $this->token;
		#var_dump($r->body);
	}
	public function setAuthToken($token)
	{
		$this->token = $token;
	}
	public function getLokalToken()
	{
		return $this->token;
	}
	public function ping()
	{
		$r = $this->curl->get($this->server.'/api2/ping/');
		if($r->statusCode!=200)
		{
			return false;
		}
		if($r->body=='"pong"')
		{
			return true;
		}
		return false;
	}
	public function authPing()
	{
		if(!isset($this->token))
		{
			return false;
		}
		$r = $this->curl->newRequest('get', $this->server.'/api2/auth/ping/', [])
		->setHeader('Authorization', 'Token '.$this->token)
		->send();
		if($r->statusCode!=200)
		{
			return false;
		}
		if($r->body=='"pong"')
		{
			return true;
		}
		return false;
	}
	public function sendRequest($typ, $url, $param = [], $returnObject = false)
	{
		$request = $this->curl->newRequest($typ, $this->server.$url, $param);
		if(isset($this->token)&&!empty($this->token)&&$this->token!==false)
		{
			$request->setHeader('Authorization', 'Token '.$this->token);
		}
		$r = $request->send();
		#var_dump($r);
		if(!($r->statusCode==200||$r->statusCode==201||$r->statusCode==301))
		{
			return false;
		}
		if($returnObject)
		{
			return $r;
		}
		return $r->body;
	}
}
?>