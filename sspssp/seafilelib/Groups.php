<?php
namespace sspssp\seafilelib;
class Groups()
{
	public function __construct($seafile)
	{
		$this->sf = $seafile;
	}
	public function listGroups($mail)
	{
		$r = $this->sf->sendRequest("get", "/api2/groups/");
		$r = json_decode($r, true);
		return $r;
	}
	public function add($name)
	{
		$r = $r = $this->sf->sendRequest("put", "/api2/groups/", ["group_name"=>$name]);
		$r = json_decode($r, true);
		return $r;
	}
	public function addMember($groupId, $username)
	{
		$r = $r = $this->sf->sendRequest("put", "/api2/groups/".(int)$groupId."/members/", ["user_name"=>$username]);
		$r = json_decode($r, true);
		return $r;
	}
	public function delMember($groupId, $username)
	{
		$r = $r = $this->sf->sendRequest("delete", "/api2/groups/".(int)$groupId."/members/", ["user_name"=>$username]);
		$r = json_decode($r, true);
		return $r;
	}
	public function getMessages($groupId)
	{
		$r = $this->sf->sendRequest("get", "/api2/group/msgs/".(int)$groupId."/");
		$r = json_decode($r, true);
		return $r;
	}
	public function getMessagesDetais($groupID, $messageID)
	{
		$r = $this->sf->sendRequest("get", "/api2/group/".(int)$groupId."/msg/".(int)$messageID."/");
		$r = json_decode($r, true);
		return $r;
	}
	public function sendGroupMessage($groupID, $message, $reproid = NULL, $path = NULL)
	{
		$a = array();
		$a["message"]=$message;
		$a["repo_id"]=$reproid;
		$a["path"]=$path;
		$r = $this->sf->sendRequest("post", "https://cloud.seafile.com/api2/group/msgs/".(int)$groupID."/", $a);
		$r = json_decode($r, true);
		return $r;
	}
	public function replayGroupMessage($groupId, $messageId, $message)
	{
		$r = $this->sf->sendRequest("post", "/api2/group/".(int)$groupId."/msg/".(int)$messageId."/", ["message"=>$message]);
		$r = json_decode($r, true)
		return $r;
	}
	public function getGroupMessagesRepies($groupid)
	{
		$r = $this->sf->sendRequest("get", "/api2/new_replies/");
		$r = json_decode($r, true);
		return $r;
	}


}
?>