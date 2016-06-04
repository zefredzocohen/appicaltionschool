<?php
	$cookie = 'nei';
	$tid = 36288000;
	$file = "counter.dat";//file lưu lại số lần truy cập
	if($cookie != "ja") { 
	} 
	else { 
		if(file_exists($file)) { 
			$fil = fopen($file, "r"); 
			$count = fread($fil, 8); 
			fclose($fil); 
		} 
		else {
			$count=0; 
		}
		$count++; 
		$fil = fopen($file, "w"); 
		fwrite($fil, $count); 
		fclose($fil); 
		if($cookie == "ja") { 
		setcookie("count","yes",time()+$tid); 
} 
} 
?>