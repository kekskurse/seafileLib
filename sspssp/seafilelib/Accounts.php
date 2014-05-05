<?php
namespace sspssp\seafilelib;
class Accounts
{
	public function __construct($seafile)
	{
		$this->sf = $seafile;
	}
	public function listAccounts()
	{
		$r = $this->sf->sendRequest("get", "/api2/accounts/");
		$r = json_decode($r, true);
		return $r;
	}
	public function accountInfo()
	{
		$r = $this->sf->sendRequest("get", "/api2/account/info/");
		#var_dump($r);
		$r = json_decode($r, true);
		return $r;
	}
	public function create($mail, $pw, $stuff = false, $aktiv = true)
	{
		$r = $this->sf->sendRequest("put", "/api2/accounts/".urlencode($mail)."/", ["password"=>$pw, "is_staff"=>$stuff, "is_active"=>$aktiv]);
		$r = json_decode($r, true);
		return $r;
	}
	public function update($mail, $pw, $stuff = false, $aktiv = true)
	{
		$r = $this->sf->sendRequest("put", "/api2/accounts/".urlencode($mail)."/", ["password"=>$pw, "is_staff"=>$stuff, "is_active"=>$aktiv]);
		$r = json_decode($r, true);
		return $r;
	}
	public function delete($mail)
	{
		$r = $this->sf->sendRequest("DELETE", "api2/accounts/".urlencode($mail)."/");
		$r = json_decode($r, true);
		return $r;
	}
}