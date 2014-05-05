<?php
namespace sspssp\seafilelib;
class Shared()
{
	public function __construct($seafile)
	{
		$this->sf = $seafile;
	}
	public function listLinks()
	{
		$r = $this->sf->sendRequest("get", "/api2/shared-links/");
		$r = json_decode($r, true);
		return $r;
	}
	public function createFileLink($reproId, $path)
	{
		$r = $this->sf->sendRequest("put", "/api2/repos/".$reproId."/file/shared-link/", ["p"=>$path]);
		if($r!==false)
		{
			return true;
		}
		return false;
	}
	public function delFileLink($linkToken)
	{
		$r = $this->sf->sendRequest("delete", "/api2/shared-links/?t=".$linkToken);
		if($r!==false)
		{
			return true;
		}
		return false;
	}
	public function listSharredLibraries()
	{
		$r = $this->sf->sendRequest("get", "/api2/shared-repos/");
		$r = json_decode($r, true);
		return $r;
	}
	public function listBeSharredLibraries()
	{
		$r = $this->sf->sendRequest("get", "/api2/beshared-repos/");
		$r = json_decode($r, true);
		return $r;
	}
	public function shareLibrary($reproId, $share_type, $user, $groupId, $permission)
	{
		$r = $this->sf->sendRequest("put", "/api2/shared-repos/".$reproId."/?share_type=".$share_type."&user=".$user."group_id=".$groupId."&permission=".$permission);
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function unShareLibrary($reproId, $share_type, $user, $groupId)
	{
		$r = $this->sf->sendRequest("delete", "/api2/shared-repos/".$reproId."/?share_type=".$share_type."&user=".$user."group_id=".$groupId);
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function listSharedFiles()
	{
		$r = $this->sf->sendRequest("get", "/api2/shared-files/");
		$r = json_decode($r, true);
		return $r;
	}
	public function downloadSharedFile($fileShareToken)
	{
		$r = $this->sf->sendRequest("get", "/api2/f/".$fileShareToken."/");
		return $r;
	}
	public function getSharedFileDetais($fileShareToken)
	{
		$r = $this->sf->sendRequest("get", "/api2/f/".$fileShareToken."/detail/");
		$r = json_decode($r, true);
		return $r;
	}
	public function delSharedFile($fileShareToken)
	{
		$r = $this->sf->sendRequest("delete", "/api2/shared-files/?t=".$fileShareToken, [], true);
		if($r->statusCode!=200)
		{
			return false;
		}
		return true;
	}
	public function downloadPrivateSharedFile($fileShareToken)
	{
		$r = $this->sf->sendRequest("get", "/api2/s/f/".$fileShareToken."/");
		return $r;
	}
	public function getPrivateShareFileDetais($fileShareToken)
	{
		$r = $this->sf->sendRequest("get", "/api2/s/f/".$fileShareToken."/detail/");
		$r = json_decode($r, true);
		return $r;
	}
}