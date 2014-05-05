<?php
namespace sspssp\seafilelib;
class StarredFiles
{
	public function __construct($seafile)
	{
		$this->sf = $seafile;
	}
	public function listStarredFiles()
	{
		$r = $this->sf->sendRequest("get", "/api2/starredfiles/");
		$r = json_decode($r, true);
		return $r;
	}
	public function starAFile($reproId, $file)
	{
		$r = $this->sf->sendRequest("post", "/api2/starredfiles/", ["repo_id"=>$reproId, "p"=>$file]);
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	public function unstarAFile($reproId, $file)
	{
		$r = $this->sf->sendRequest("delete", "/api2/starredfiles/", ["repo_id"=>$reproId, "p"=>$file]);
		if($r=='"success"')
		{
			return true;
		}
		return false;
	}
	
}
?>