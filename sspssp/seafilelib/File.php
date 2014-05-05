<?php
namespace sspssp\seafilelib;
class File
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
	public function uploadFile($uploadLink, $filename, $parent_dir, $file)
	{
		/*$request = $this->sf->curl->newRequest("post", $uploadLink, ["filename"=>"bla.txt", "file"=>'@/home/share/bla.txt', "parent_dir"=>"/"]);
		var_dump($request);
		$r = $request->send();
		var_dump($r);*/
		$file_name_with_full_path = realpath($file);
		$post = array('filename' => $filename, 'parent_dir' => $parent_dir,'file'=>'@'.$file_name_with_full_path);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$uploadLink);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Token ".$this->sf->getLokalToken()));
		$result=curl_exec($ch);
		#$header = curl_getinfo ( $ch );
		curl_close ($ch);
		
		#var_dump($header);
		#var_dump($result);
		return $result;
	}
}