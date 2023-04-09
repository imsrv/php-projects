<?php
require("./PicSql.inc.php");
$db = new PicSQL($DBName); 
$result = $db->getpicbyid($picid);
$catalogid = $result[0]["catalogid"];
$title = $result[0]["title"];
$picture = $result[0]["picture"];
$picturepath = "./photo/";
$adddate = $result[0]["adddate"];
$result = $db->getpicbycatidonpicphp($catalogid);
?>
<HTML>
<HEAD>
<TITLE><?php  print "$title"; ?></TITLE>
<META http-equiv=Content-Type content="text/html; charset=<?php print "$front_charset"; ?>">
<META http-equiv=imagetoolbar content=no>
<SCRIPT language=JavaScript>
<!--
var width0;
var height0;
function initsize() {
width0=sample.offsetWidth;
height0=sample.offsetHeight;
recalcposition();
sample.style.visibility='visible';
tool.style.visibility='visible';
}
function recalcposition()
{
	if ((document.body.offsetWidth-sample.offsetWidth)/2<0) {imglayer.style.left=0;}
	else {imglayer.style.left=(document.body.offsetWidth-sample.offsetWidth)/2;}
	if ((document.body.offsetHeight-sample.offsetHeight)/2<0) {imglayer.style.top=0;}
	else {imglayer.style.top=(document.body.offsetHeight-sample.offsetHeight)/2;}
	window.scrollTo(0,0);
}

var curzoom=1;
function down() {
if (event.button==1 && zoomvalue!=1) {
	curzoom*=zoomvalue;
	sample.width=width0*curzoom;
	recalcposition();
	}
}

function showtool() {
tool.style.visibility='visible';
if (document.body.scrollLeft+event.clientX+tool.offsetWidth<document.body.offsetWidth)
	tool.style.left=document.body.scrollLeft+event.clientX;
else
	tool.style.left=document.body.scrollLeft+event.clientX-tool.offsetWidth;
if (document.body.scrollTop+event.clientY+tool.offsetHeight<document.body.offsetHeight)
	tool.style.top=document.body.scrollTop+event.clientY;
else 
	tool.style.top=document.body.scrollTop+event.clientY-tool.offsetHeight;
}

var toolid=new Array;
toolid[0]='fitmode';
toolid[1]='filtermode';
toolid[2]='url';
toolid[3]='extend';
toolid[4]='home';
toolid[5]='previous';
toolid[6]='next';
toolid[7]='end';
toolid[8]='alpha1';
toolid[9]='alpha2';
toolid[10]='alpha3';
toolid[11]='blur1';
toolid[12]='blur2';
toolid[13]='light1';
toolid[14]='light2';
toolid[15]='light3';
toolid[16]='light4';
toolid[17]='wave1';
toolid[18]='wave2';
toolid[19]='wave3';
toolid[20]='favourl';
toolid[21]='importicon';

function hidetool() {
	for (i=0;i<toolid.length;i++) {
	if (event.srcElement.id==toolid[i]) return false;
	}
	tool.style.visibility='hidden';
	tool.style.left=0;
	tool.style.top=0;
}

var zoomvalue=2;
function zoomin() {
sample.style.cursor='url("images/zoom-in.cur")';
zoomvalue=2;
}

function zoomout() {
sample.style.cursor='url("images/zoom-out.cur")';
zoomvalue=1/2;
}

function move() {
sample.style.cursor='url("images/move-up.cur")';
zoomvalue=1;
}

var scrollcount=0;
var dragx;
var dragy;

var scrollarrowtop;

function initdrag() {
scrollcount=1;
dragx=document.body.scrollLeft+event.clientX;
dragy=document.body.scrollTop+event.clientY;
}

function startdrag() {
if (scrollcount==1 && zoomvalue==1) {
window.scrollBy(dragx-(document.body.scrollLeft+event.clientX),dragy-(document.body.scrollTop+event.clientY));
dragx=document.body.scrollLeft+event.clientX;
dragy=document.body.scrollTop+event.clientY;
}
}

function enddrag() {
scrollcount=0;
}

var scrollcount2=0;
var handledx;
var width0;
function initdrag2() {
scrollcount2=1;
handledx=document.body.scrollLeft+event.clientX-tool.offsetLeft-zoomhandle.offsetLeft;
	sample.width=width0;
	recalcposition();
	curzoom=1;
}
function startdrag2() {
if (scrollcount2==1) {
	if ((document.body.scrollLeft+event.clientX-handledx)>(73+tool.offsetLeft) && (document.body.scrollLeft+event.clientX-handledx)<(175+tool.offsetLeft)) {zoomhandle.style.left=document.body.scrollLeft+event.clientX-handledx-tool.offsetLeft;}
	if ((document.body.scrollLeft+event.clientX-handledx)<(74+tool.offsetLeft)) {zoomhandle.style.left=74+tool.offsetLeft-tool.offsetLeft;}
	if ((document.body.scrollLeft+event.clientX-handledx)>(174+tool.offsetLeft)) {zoomhandle.style.left=174+tool.offsetLeft-tool.offsetLeft;}
//recalc curzoom
if (zoomhandle.offsetLeft-124>-1) {
	curzoom=Math.floor(((zoomhandle.offsetLeft-124)/10+1)*100)/100;
	sample.width=width0*curzoom;
	recalcposition();
	showzoomvalue.innerHTML=Math.floor(((zoomhandle.offsetLeft-124)/10+1)*100)+'%';
	}
else {
	curzoom=Math.floor(((zoomhandle.offsetLeft-124)*9/500+1)*100)/100;
	sample.width=width0*curzoom;
	recalcposition();
	showzoomvalue.innerHTML=Math.floor(((zoomhandle.offsetLeft-124)*9/500+1)*100)+'%';
	}
}
}
function enddrag2() {
scrollcount2=0;
}

function autofit(selObj) {
fitcount=selObj.options[selObj.selectedIndex].value;
if (fitcount=="1") {
	curzoom2=document.body.offsetWidth/width0;
	curzoom=document.body.offsetHeight/height0;
	if (curzoom2<curzoom) curzoom=curzoom2;
	sample.width=width0*curzoom;
}

if (fitcount=="2") {sample.width=width0;curzoom=1;}

if (fitcount=="3") {
	curzoom=document.body.offsetWidth/width0;
	sample.width=width0*curzoom;}

if (fitcount=="4") {
	curzoom=document.body.offsetHeight/height0;
	sample.width=width0*curzoom;}

if (fitcount=="0") return false;

	recalcposition();
	selObj.selectedIndex=0;
	tool.style.visibility='hidden';tool.style.left=0;tool.style.top=0;
}

function changeimg(selObj) {
if (event.keyCode==13) {
	imgid=imglist.length;
		for (i=0;i<imglist.length;i++) {
		if (selObj.value==imglist[i]) return false;
		}
		imglist[imgid]=selObj.value;
	showimg();
	tool.style.visibility='hidden';
	}
}

function showimg() {
if (imgid>-1 && imgid<imglist.length && sample.src!=imglist[imgid]) {
	sample.outerHTML='<img src="'+imglist[imgid]+'" id=sample onmousedown="down();initdrag()" style="cursor:url(images/zoom-in.cur);visibility:hidden" onmousemove="startdrag()" onmouseup="enddrag()" onreadystatechange="initsize()">';
	showzoomvalue.innerHTML='100%';
	zoomhandle.style.left=124;
	curzoom=1;
	filterparam.innerHTML='&nbsp;';
	}
if (imgid<0) {imgid=0;return false;}
if (imgid>imglist.length-1) {imgid=imglist.length-1;return false;}
}

function extendit() {
if (extendparam.style.display=='none') {extend.style.filter='flipv()';extendparam.style.display='block';}
else {extend.style.filter='';extendparam.style.display='none';}
}

function extendit2() {
if (slide.style.display=='none') {extend2.style.filter='flipv()';slide.style.display='block';}
else {extend2.style.filter='';slide.style.display='none';}
}

var imglist=new Array;
<?php
if (!empty($result)){
	for ($i=0;$i<count($result);$i++){
	$temppicture = $result[$i]["picture"];
?>
imglist[<?php print "$i"; ?>]="<?php print "$picturepath$temppicture"; ?>";
<?php
		if ($temppicture==$picture){
			$imgid = $i;
		}
	}
}
?>
var imgid=<?php print "$imgid"; ?>;

function addfilter(selObj) {
if (selObj.options[selObj.selectedIndex].value=='alpha(') {
		filterparam.innerHTML='Opacity <input id=alpha1 type=text value=80 size=3 onkeypress="filter_alpha()" onmouseover="this.focus();this.select()"> - <input id=alpha2 type=text value=0 size=3 onkeypress="filter_alpha()" onmouseover="this.focus();this.select()"> Style <input id=alpha3 type=text value=2 size=1 onkeypress="filter_alpha()" onmouseover="this.focus();this.select()">';
		sample.style.filter='alpha('+'opacity='+alpha1.value+',finishopacity='+alpha2.value+',style='+alpha3.value+')';
		}
if (selObj.options[selObj.selectedIndex].value=='blur(') {
		filterparam.innerHTML='Direction <input id=blur1 type=text value=45 size=3 onkeypress="filter_blur()" onmouseover="this.focus();this.select()"> Strength <input id=blur2 type=text value=5 size=3 onkeypress="filter_blur()" onmouseover="this.focus();this.select()">';
		sample.style.filter='blur('+'add=0,direction='+blur1.value+',strength='+blur2.value+')';
		}
if (selObj.options[selObj.selectedIndex].value=='light(') {
		filterparam.innerHTML='RGB <input id=light1 type=text value=255 size=2 onkeypress="filter_light()" onmouseover="this.focus();this.select()"> <input id=light2 type=text value=0 size=2 onkeypress="filter_light()" onmouseover="this.focus();this.select()"> <input id=light3 type=text value=0 size=2 onkeypress="filter_light()" onmouseover="this.focus();this.select()"> Strength <input id=light4 type=text value=20 size=3 onkeypress="filter_light()" onmouseover="this.focus();this.select()">';
		sample.style.filter='light()';
		sample.filters[0].addCone(0,0,1,sample.offsetWidth,sample.offsetHeight,light1.value,light2.value,light3.value,light4.value,90);
		}
if (selObj.options[selObj.selectedIndex].value=='wave(') {
		filterparam.innerHTML='Phase <input id=wave1 type=text value=4 size=2 onkeypress="filter_wave()" onmouseover="this.focus();this.select()"> Freq <input id=wave2 type=text value=5 size=2 onkeypress="filter_wave()" onmouseover="this.focus();this.select()"> Strength <input id=wave3 type=text value=2 size=3 onkeypress="filter_wave()" onmouseover="this.focus();this.select()">';
		sample.style.filter='wave(Add=0, Phase='+wave1.value+',Freq='+wave2.value+',LightStrength="5",Strength='+wave3.value+')';
		}
if (selObj.options[selObj.selectedIndex].value=='fliph(' || selObj.options[selObj.selectedIndex].value=='flipv(' || selObj.options[selObj.selectedIndex].value=='invert(' || selObj.options[selObj.selectedIndex].value=='gray(' || selObj.options[selObj.selectedIndex].value=='xray(') {
		filterparam.innerHTML='&nbsp;';
		sample.style.filter=selObj.options[selObj.selectedIndex].value+')';
		}
if (selObj.options[selObj.selectedIndex].value=='none') {
	sample.style.filter='';
	filterparam.innerHTML='&nbsp;';}
selObj.selectedIndex=0;
}

function filter_alpha() {
if (event.keyCode==13) {
	sample.style.filter='alpha('+'opacity='+alpha1.value+',finishopacity='+alpha2.value+',style='+alpha3.value+')';
	}
}

function filter_blur() {
if (event.keyCode==13) {
	sample.style.filter='blur('+'add=0,direction='+blur1.value+',strength='+blur2.value+')';
	}
}

function filter_light() {
if (event.keyCode==13) {
	sample.filters[0].clear();
	sample.filters[0].addCone(0,0,1,sample.offsetWidth,sample.offsetHeight,light1.value,light2.value,light3.value,light4.value,90);
	}
}

function filter_wave() {
if (event.keyCode==13) {
	sample.style.filter='wave(Add=0, Phase='+wave1.value+',Freq='+wave2.value+',LightStrength="5",Strength='+wave3.value+')';
	}
}

function exportit() {
var newwin=window.open('','YourFavo','width=300,height=100,left=0,top=0');
var favorite='<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style>span {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 10px}</style><OBJECT classid=CLSID:8856F961-340A-11D0-A96B-00C04FD705A2 height=0 id=WebBrowser width=0></OBJECT><body>';
		for (i=0;i<imglist.length;i++) {
		favorite+='<span id=imglist'+i+'>'+imglist[i]+'</span><br>';
		}
favorite+='</body>';
newwin.document.write(favorite);
newwin.document.all.WebBrowser.ExecWB(4,1);
newwin.window.close();
}

function importit() {
filterparam.innerHTML='&nbsp;Favo. URL&nbsp;&nbsp;<input id=favourl type=text size=24 onkeypress="readfavo()" onmouseover="this.focus();this.select()">';
}

function readfavo() {
if (event.keyCode==13) {
var newwin=window.open(favourl.value,'YourFavo','width=300,height=100,left=0,top=0');
		for (i=0;i<newwin.document.all.tags("span").length;i++) {
		imglist[i]=newwin.document.all.tags("span")[i].innerHTML;
		}
newwin.window.close();
imgid=<?php print "$imgid"; ?>;
tool.style.visibility='hidden';tool.style.left=0;tool.style.top=0;
}
}
// -->
</SCRIPT>

<STYLE>.button {
	BORDER-RIGHT: menu 1px solid; BORDER-TOP: menu 1px solid; BEHAVIOR: url(images/button.htc); BORDER-LEFT: menu 1px solid; BORDER-BOTTOM: menu 1px solid
}
INPUT {
	FONT-SIZE: 10px; FONT-FAMILY: "Verdana", "Arial", "Helvetica", "sans-serif"
}
SELECT {
	FONT-SIZE: 10px; FONT-FAMILY: "Verdana", "Arial", "Helvetica", "sans-serif"
}
TD {
	FONT-SIZE: 10px; FONT-FAMILY: "Verdana", "Arial", "Helvetica", "sans-serif"
}
</STYLE>

<OBJECT id=WebBrowser height=0 width=0 
classid=CLSID:8856F961-340A-11D0-A96B-00C04FD705A2></OBJECT>
<META content="MSHTML 6.00.2722.900" name=GENERATOR></HEAD>
<BODY oncontextmenu="showtool();return false;" ondragstart="return false;" 
onresize=recalcposition() onclick=hidetool() text=#000000 bgColor=#ffffff 
leftMargin=0 background="images/bk-pattern.gif" topMargin=0 
scroll=no>
<DIV id=imglayer 
style="Z-INDEX: -1; LEFT: 0px; WIDTH: 1px; POSITION: absolute; TOP: 0px; HEIGHT: 1px">
<IMG 
onmouseup=enddrag() onmousemove=startdrag() onmousedown=down();initdrag() 
id=sample onreadystatechange=initsize();imglist[<?php print "$imgid"; ?>]=this.src; 
style="VISIBILITY: hidden; CURSOR: url('images/zoom-in.cur')" 
src="<?php print "$picturepath$picture"; ?>"><br>
</DIV>
<DIV id=tool 
style="Z-INDEX: 2; LEFT: 0px; VISIBILITY: hidden; WIDTH: 353px; POSITION: absolute; TOP: 0px; HEIGHT: 10px">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD 
    style="BORDER-RIGHT: #ffffff 2px outset; BORDER-TOP: #ffffff 2px outset; BORDER-LEFT: #ffffff 2px outset; BORDER-BOTTOM: #ffffff 2px outset; BACKGROUND-COLOR: menu" 
    vAlign=top>
      <TABLE cellSpacing=3 cellPadding=0 width="100%" border=0>
        <TBODY>
        <TR>
          <TD align=middle width=20><IMG class=button onclick=zoomin() 
            height=16 src="images/zoom-in.gif" width=16></TD>
          <TD align=middle width=20><IMG class=button onclick=zoomout() 
            height=16 src="images/zoom-out.gif" width=16></TD>
          <TD align=middle width=20><IMG class=button onclick=move() height=16 
            src="images/move-up.gif" width=16></TD>
          <TD width=110 background="images/bk-guide.gif">
            <DIV id=zoomhandle 
            style="Z-INDEX: 3; LEFT: 124px; WIDTH: 10px; POSITION: absolute; TOP: 4px; HEIGHT: 16px"><IMG 
            onmouseup=enddrag2() onmousemove=startdrag2() 
            onmousedown=initdrag2() 
            style="BORDER-RIGHT: #ffffff 2px outset; BORDER-TOP: #ffffff 2px outset; BORDER-LEFT: #ffffff 2px outset; BORDER-BOTTOM: #ffffff 2px outset; BACKGROUND-COLOR: menu" 
            height=14 src="images/spacer.gif" width=6></DIV></TD>
          <TD id=showzoomvalue width=35>100%</TD>
          <TD width=95><SELECT id=fitmode onchange=autofit(this)> <OPTION 
              value=0 selected>Fit Mode</OPTION> <OPTION value=1>Fit on 
              Screen</OPTION> <OPTION value=2>Actual Size</OPTION> <OPTION 
              value=3>Fit in Width</OPTION> <OPTION value=4>Fit in 
              Height</OPTION></SELECT> </TD>
          <TD align=middle width=20><IMG class=button onclick=window.print() 
            height=16 src="images/print.gif" 
width=16></TD></TR></TBODY>
        <TBODY>
        <TR>
          <TD colSpan=6>
            <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
              <TBODY>
              <TR>
                <TD width=23><IMG class=button id=home 
                  onclick=imgid=0;showimg() height=16 alt=Home hspace=1 
                  src="images/arrow3b.gif" width=16></TD>
                <TD width=23><IMG class=button id=previous 
                  onclick=imgid-=1;showimg() height=16 alt=Previous hspace=1 
                  src="images/arrow2b.gif" width=16></TD>
                <TD width=23><IMG class=button id=next 
                  onclick=imgid+=1;showimg() height=16 alt=Next hspace=1 
                  src="images/arrow2.gif" width=16></TD>
                <TD width=23><IMG class=button id=end 
                  onclick=imgid=imglist.length-1;showimg() height=16 alt=End 
                  hspace=1 src="images/arrow3.gif" width=16></TD>
                <TD align=right>&nbsp;URL&nbsp;&nbsp;<INPUT 
                  onkeypress=changeimg(this) id=url 
                  onmouseover=this.focus();this.select() style="WIDTH: 188px" 
                  value=http://> </TD></TR></TBODY></TABLE></TD>
          <TD vAlign=bottom align=middle><IMG id=extend onclick=extendit() 
            height=10 src="images/arrow.gif" 
      width=9></TD></TR></TBODY></TABLE>
      <TABLE id=extendparam style="DISPLAY: none" cellSpacing=3 cellPadding=0 
      width="100%" border=0>
        <TBODY>
        <TR>
          <TD width=60 height=20><SELECT id=filtermode 
            onchange=addfilter(this)> <OPTION value="" 
              selected>Effect</OPTION> <OPTION value=none>None</OPTION> <OPTION 
              value=alpha(>Alpha</OPTION> <OPTION value=fliph(>Flip-H</OPTION> 
              <OPTION value=flipv(>Flip-V</OPTION> <OPTION 
              value=invert(>Invert</OPTION> <OPTION value=gray(>Gray</OPTION> 
              <OPTION value=xray(>Xray</OPTION> <OPTION 
              value=blur(>Blur</OPTION> <OPTION value=light(>Light</OPTION> 
              <OPTION value=wave(>Wave</OPTION></SELECT></TD>
          <TD id=filterparam align=left>&nbsp;</TD>
          <TD align=middle width=20><IMG class=button id=importicon 
            onclick=importit() height=16 
            alt="Please input the URL of your favorite list file that you have ever Exported" 
            src="images/import.gif" width=16></TD>
          <TD align=middle width=20><IMG class=button onclick=exportit() 
            height=16 alt="Please choose the Type of Saving:Only HTML" 
            src="images/export.gif" width=16></TD>
          <TD align=middle width=20><IMG class=button 
            onclick=document.all.WebBrowser.ExecWB(4,1) height=16 
            src="images/save.gif" 
  width=16></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></DIV></BODY></HTML>
