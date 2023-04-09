<!--
// This Mini Ajax is taken from http://marc.theaimsgroup.com/?l=php-general&m=112198633625636&w=2

function createRequestObject() {
    var ro;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        ro = new XMLHttpRequest();
    }
    return ro;
}

var http = createRequestObject();

function sndReq(action) {
    http.open('get', 'miyabi.php?url='+action);
    http.onreadystatechange = handleResponse;
    http.send(null);
}
function handleResponse() {
    if(http.readyState == 4){
        var response = http.responseText;
        var update = new Array();

        if(response.indexOf('|' != -1)) {
            update = response.split('|');
            document.getElementById("hasil").innerHTML = '<span id=\"output\" >Download link: <a href="'+update[0]+'">'+update[0]+'</a></span>';
            document.getElementById("itung").innerHTML = 'used for <big>'+update[1]+'</big> times..';
        }
    }
}
function loading(){
	document.getElementById("hasil").innerHTML = "<p><img src='im/o.gif' alt='loading..' /></p>";
}
function kirim(){
	var youtube_url = document.getElementById("url").value;
	loading();
	sndReq(youtube_url);
}
function display(){
	var form = 'Youtube Link: <input type="text" id="url" size="50" /> <input type="submit" value="Submit" onclick="javascript:kirim();" />';
	document.getElementById("form").innerHTML = form;
}
-->