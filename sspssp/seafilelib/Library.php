<?php
namespace sspssp\seafilelib;
class Library
{
	public function __construct($seafile)
	{
		$this->sf = $seafile;
	}
	public function getDefaultLibrary()
	{
		$r =$this->sf->sendRequest("get", "/api2/default-repo/");
		$r = json_decode($r, true);
		return $r; 
	}
	public function createDefailtLibrary()
	{
		$r = $this->sf->sendRequest("post", "/api2/default-repo/");
		$r = json_decode($r, true);
		return $r;
	}
	public function listLibrarys()
	{
		$r = $this->sf->sendRequest("get", "/api2/repos/");
		$r = json_decode($r, true);
		return $r;
	}
	public function getLibraryInfo($reproId)
	{
		$r = $this->sf->sendRequest("get", "/api2/repos/".$reproId."/");
		$r = json_decode($r, true);
		return $r;
	}
	public function getLibraryOwner($reproId)
	{
		$r = $this->sf->sendRequest("get", "/api2/repos/".$reproId."/owner/");
		$r = json_decode($r, true);
		return $r;
	}
	public function getLibraryHistory($reproId)
	{
		$r = $this->sf->sendRequest("get", "/api2/repos/".$reproId."/history/");
		$r = json_decode($r, true);
		return $r;
	}
	public function createLibrary($name, $description, $pw=Null)
	{
		$r = $this->sf->sendRequest("post", "/api2/repos/", ["name"=>$name, "desc"=>$description, "passwd"=>$pw]);
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function createSubLibrary($reproId, $name, $path)
	{
		$r = $this->sf->sendRequest("get", "/api2/repos/".$reproId."/dir/sub_repo/?p=".urlencode($path)."&name=".urlencode($name));
		$r = json_decode($r, true);
		return $r;
	}
	public function deleteLibrary($reproId)
	{
		$r = $this->sf->sendRequest("delete", "/api2/repos/".$reproId."/");
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function decryptLibrary($reproId, $pw)
	{
		$r = $this->sf->sendRequest("post", "/api2/repos/".$reproId."/",["password"=>$pw]);
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function createPublicLibrary($reproId)
	{
		$r = $this->sf->sendRequest("post", "/api2/repos/".$reproId."/public/");
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function deletePublicLibrary($reproId)
	{
		$r = $this->sf->sendRequest("delete", "/api2/repos/".$reproId."/public/");
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function getLibraryDownloadInfo($reproId)
	{
		$r = $this->sf->sendRequest("get", "/api2/repos/".$reproId."/download-info/");
		$r = json_decode($r, true);
		return $r;
	}
	public function listVirtualLibrarys()
	{
		$r = $this->sf->sendRequest("get", "/api2/virtual-repos/");
		$r = json_decode($r, true);
		return $r;
	}
	public function searchLibery($search)
	{
		$r = $this->sf->sendRequest("get", "/api2/search/?q=".$search);
		$r = json_decode($r, true);
		return $r;
	}
}
?>