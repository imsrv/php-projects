click_url=escape(click_url);
var swf_url=swf_path+'?clickTag='+click_url;
var loaded=false;
var plugin=(navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]) ? navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin : 0;
if(plugin){
plugin=parseInt(plugin.description.substring(plugin.description.indexOf(".")-1)) >= 5;
}
else if (navigator.userAgent && navigator.userAgent.indexOf("MSIE")>=0 && (navigator.userAgent.indexOf("Windows 95")>=0 || navigator.userAgent.indexOf("Windows 98")>=0 || navigator.userAgent.indexOf("Windows NT")>=0)) {
document.write('<SCR' + 'IPT LANGUAGE=VBScript\> \n');
document.write('on error resume next \n');
document.write('plugin=( IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.5")))\n');
document.write('</SCRIPT\> \n');
}
if(plugin){
document.write('<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"');
document.write('  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" ');
document.write(' ID=movie WIDTH='+width+' HEIGHT='+height+'>');
document.write(' <PARAM NAME=movie VALUE="'+swf_url+'"> <PARAM NAME=play VALUE=true> <PARAM NAME=loop VALUE=true> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE='+bcolor+'>  ');
document.write(' <EMBED name=movie src="'+swf_url+'" play=true loop=true quality=high bgcolor='+bcolor+'  ');
document.write(' swLiveConnect=TRUE WIDTH='+width+' HEIGHT='+height+'');
document.write(' TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">');
document.write(' </EMBED>');
document.write(' </OBJECT>');
}else{
document.write('<a target=_blank href="'+click_url2+'"><IMG SRC="'+img_path+'" WIDTH='+width+' HEIGHT='+height+'  BORDER=0></a>');
}




