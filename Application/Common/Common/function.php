<?php

	//大图片变成小图片功能
	function getSm($filename)
	{
		 	$arr = explode('/',$filename);
		 	$arr[3] = 'em_'.$arr[3];
		 	return implode('/',$arr);
		 
	}


?>