<?php
namespace sspssp\seafilelib;
class File()
{
	public function __construct($seafile)
	{
		$this->sf = $seafile;
	}
	public function downloadFile($reproId, $path)
	{
		$r =$this->sf->sendRequest("get", "/api2/repos/".$reproId."/file/?p=".urlencode($path));
		#$r = json_decode($r, true);
		return $r; 
	}
	public function getFileDetais($reproId, $path)
	{
		$r = $this->sf->sendRequest("get", "/api2/repos/".$reproId."/file/detail/?p=".urlencode($path));
		$r = json_decode($r, true);
		return $r;
	}
	public function downloadFileRevision($reproId, $path, $revision)
	{
		$r = $this->sf->sendRequest("get", "/api2/repos/".$reproId."/file/revision/?p=".urlencode($path)."&commit_id=".$revision);
		return $r;
	}
	public function createFile($reproId, $path, $operation = "create")
	{
		$r = $this->sf->sendRequest("post", "api2/repos/".$reproId."/file/?p=".urlencode($path), ["operation"=>$operation]);
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function renameFile($reproId, $path, $newName, $operation="rename")
	{
		$r = $this->sf->sendRequest("post", "/api2/repos/".$reproId."/file/?p=".urlencode($path), ["operation"=>$operation, "newname"=>$newName]);
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function moveFile($reproId, $path, $dstRepro, $dstPath, $operation="move")
	{
		$r = $this->sf->sendRequest("post", "/api2/repos/".$reproId."/file/?p=".urlencode($path), ["operation"=>$operation, "dst_repo"=>$dstRepro, "dst_dir"=>$dstPath]);
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function copyFile($reproId, $fileName, $dstRepro, $dstDir, $operation="move")
	{
		$r = $this->sf->sendRequest("post", "/api2/repos/".$reproId."/fileops/copy/", [ "dst_repo"=>$dstRepro, "dst_dir"=>$dstDir, "file_names"=>$fileName]);
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function revertFile($reproId, $path, $revision)
	{
		$r = $this->sf->sendRequest("put", "/api2/repos/".$reproId."/file/revert/", ["commit_id"=>$revision, "p"=>$path]);
		$r = json_decode($r, true);
		return $r;
	}
	public function deleleFile($reproId, $path)
	{
		$r = $this->sf->sendRequest("delete", "/api2/repos/".$reproId."/file/?p=".urlencode($path));
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function getUploadLink($reproId)
	{
		$r = $this->sf->sendRequest("get", "/api2/repos/".$reproId."/upload-link/");
		$r = json_decode($r, true);
		return $r;
	}
	public function uploadFile($uploadLink)
	{
		$request = $this->sf->curl->newRequest($uploadLink, ["filename"=>"bla.txt", "file"=>"@/home/share/bla.txt", "parent_dir"=>"/",]);
	}
}