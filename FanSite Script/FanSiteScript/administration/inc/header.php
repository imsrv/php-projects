<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251" /><title>
<?PHP 
include ("../include/connect.txt");

$result = mysql_query("SELECT site_name FROM ds_options WHERE id = '0'");  
while ($myrow = mysql_fetch_row($result)) 

printf("%s",mysql_result($result,0,"site_name"));  


include ("../include/close.txt");

?> - Контрольная панель администратора</title>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="../images/admin/favicon.ico" />
<script type="text/javascript">
<!--
function switchMenu(obj) {
	var el = document.getElementById(obj);
	if ( el.style.display != "none" ) {
		el.style.display = 'none';
	}
	else {
		el.style.display = '';
	}
}

//-->
</script>

<script type="text/javascript">

/***********************************************
* Show Hint script- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/
		
var horizontal_offset="9px" //horizontal offset of hint box from anchor link

/////No further editting needed

var vertical_offset="0" //horizontal offset of hint box from anchor link. No need to change.
var ie=document.all
var ns6=document.getElementById&&!document.all

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1
if (whichedge=="rightedge"){
var windowedge=ie && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-30 : window.pageXOffset+window.innerWidth-40
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure+obj.offsetWidth+parseInt(horizontal_offset)
}
else{
var windowedge=ie && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure-obj.offsetHeight
}
return edgeoffset
}

function showhint(menucontents, obj, e, tipwidth){
if ((ie||ns6) && document.getElementById("hintbox")){
dropmenuobj=document.getElementById("hintbox")
dropmenuobj.innerHTML=menucontents
dropmenuobj.style.left=dropmenuobj.style.top=-500
if (tipwidth!=""){
dropmenuobj.widthobj=dropmenuobj.style
dropmenuobj.widthobj.width=tipwidth
}
dropmenuobj.x=getposOffset(obj, "left")
dropmenuobj.y=getposOffset(obj, "top")
dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+obj.offsetWidth+"px"
dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+"px"
dropmenuobj.style.visibility="visible"
obj.onmouseout=hidetip
}
}

function hidetip(e){
dropmenuobj.style.visibility="hidden"
dropmenuobj.style.left="-500px"
}

function createhintbox(){
var divblock=document.createElement("div")
divblock.setAttribute("id", "hintbox")
document.body.appendChild(divblock)
}

if (window.addEventListener)
window.addEventListener("load", createhintbox, false)
else if (window.attachEvent)
window.attachEvent("onload", createhintbox)
else if (document.getElementById)
window.onload=createhintbox

</script>

</head><body>

<div id="frame">
    <div style="position:absolute; margin-top:28px; margin-left:12px; color:#FFFFFF; text-transform:uppercase; ">Добро пожаловать на<br /><span style="color:#FED200; font-weight:bold; font-size:17px;"><?PHP 
include ("../include/connect.txt");

$result = mysql_query("SELECT site_name FROM ds_options WHERE id = '0'");  
while ($myrow = mysql_fetch_row($result)) 

printf("%s",mysql_result($result,0,"site_name"));  


include ("../include/close.txt");

?></span><br />Панель Администратора</div>
	<div id="contentheader"><img src="../images/admin/header.jpg" width="750" height="104" /></div>
	<div id="contentleft">
	<br />		
<div id="navcontainer">
<ul id="navlist">
<li><a href="index.php">Главная</a></li>
<li><a href="add.php?add=movie">Фильмы</a></li>
<li><a href="add.php?add=article">Статьи</a></li>
<li><a href="add.php?add=award">Награды</a></li>
<li><a href="add.php?add=link">Ссылки</a></li>
<li><a href="edit_data.php">Редактирование</a></li>
<li><a href="delete_data.php">Удаление</a></li>
<li><a href="options.php">Настройки</a></li>
<li><a href="help.php">Примеры кода</a></li>
</ul>
</div>

<div id="sidetxt"><div class="boxbgr"></div>
<div class="boxbg">

<strong>Фильмов:</strong> <?PHP 
include ("../include/connect.txt");
$result = mysql_query("SELECT id FROM ds_movies");
$count = mysql_num_rows($result);
printf("%s",$count);

include ("../include/close.txt");

?><br />
<strong>Статей:</strong> <?PHP 
include ("../include/connect.txt");
$result = mysql_query("SELECT id FROM ds_articles");
$count = mysql_num_rows($result);
printf("%s",$count);

include ("../include/close.txt");

?><br /><br />

<a href="logout.php"><img src="../images/admin/logout.gif" border="0" /></a>
</div></div>

</div>
    <div id="contentcenter">
	
