<?php 

	function active($url, $res, $group = null)
	{
		$url = $group ? request()->is($url) || request()->is($url.'/*') : request()->is($url);
		return $url ? $res : '';
	}

	function localDate($date)
	{
		return date('d M Y', strtotime($date));
	}

	function img($name)
	{
		return asset('storage/images/'.$name);
	}

	function site($key)
	{
		return Cache::get('site')->$key;
	}

 ?>