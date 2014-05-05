<?php
namespace sspssp\seafilelib;
class Messages()
{
	public function __construct($seafile)
	{
		$this->sf = $seafile;
	}
	public function listMessages($mail)
	{
		$r = $this->sf->sendRequest("get", "/api2/user/msgs/".urlencode($mail)."/");
		$r = json_decode($r, true);
		return $r;
	}
	public function replay($mail, $message)
	{
		$r = $r = $this->sf->sendRequest("post", "/api2/user/msgs/".urlencode($mail)."/", ["message"=>$message]);
		$r = json_decode($r, true);
		return $r;
	}
	public function countUnseenMessages()
	{
		$r = $this->sf->sendRequest("get", "/api2/unseen_messages/");
		$r = json_decode($r, true);
		return $r;
	}
}
?>