// JavaScript Document

function popupgalimage(imgsrc, popwidth, popheight){

function triangulate(){
leftpos = (screen.width) ? (screen.width-popwidth)/2 : 0;
toppos = (screen.height) ? (screen.height-popheight)/2 : 0;
}

triangulate()
var windowdesc='width='+popwidth+',height='+popheight+',resizable=no,left='+leftpos+',top='+toppos
var picsrc='popwin.php?file='+imgsrc
if (typeof popupgalwin=="undefined" || popupgalwin.closed)
popupgalwin=window.open(picsrc,"popupgalwin",windowdesc)
else{
popupgalwin.close()
popupgalwin=window.open(picsrc,"popupgalwin",windowdesc)
}
}