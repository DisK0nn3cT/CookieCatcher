<?php

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,'http://dark.net/CookieCatcher/');
curl_setopt($ch,CURLOPT_VERBOSE,1);
curl_setopt($ch,CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
$result = curl_exec($ch);
//$result = preg_replace('/src="(?!http)/i','src="'.'http://google.com',$result);
//curl_close($ch);

print_r($result);
die('<------- test');
?>
