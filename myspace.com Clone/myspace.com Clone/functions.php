<?/*
           .ÜÜÜÜÜÜÜÜÜÜÜÜ,                                  .ÜÜÜÜÜÜÜÜÜ:     ,ÜÜÜÜÜÜÜÜ:
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                             .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ             D O N          ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                           ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ          ÜÜÜÜÜÜÜ;        .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜ;
         ,ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜ        ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜ;
          ÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜ      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜÜÜ
          ÜÜÜÜÜÜÜÜ: ÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜ;      :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ   ;ÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜ     .ÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ
        :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜ,,,ÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
       ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ, ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
     .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
    ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
   ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
  ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;     ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ,  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
 ,ÜÜÜÜLiquidIceÜÜÜÜÜÜ          ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ
    .ÜÜÜÜÜÜÜÜÜÜ;                 ÜÜÜÜÜÜÜÜÜ        .ÜÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜÜÜ,

*/
$conn_id;
$sql_res;
$sql_res2;
$sql_query;

$HTTP_REFERER=$_SERVER["HTTP_REFERER"];
$REQUEST_METHOD=$_SERVER["REQUEST_METHOD"];

function sql_connect(){
global $conn_id,$sql_host,$sql_user,$sql_pass,$sql_db;
$conn_id=mysql_connect($sql_host,$sql_user,$sql_pass);
mysql_select_db($sql_db);
}

function sql_execute($sql_query,$wtr){
global $conn_id;
$sql_res=mysql_query($sql_query,$conn_id);
if($wtr=='get'){
if(mysql_num_rows($sql_res)){
return mysql_fetch_object($sql_res);
}
else {
return '';
}
}
elseif($wtr=='num'){
return mysql_num_rows($sql_res);
}
elseif($wtr=='res'){
return $sql_res;
}
}

function sql_rows($id,$table){
global $conn_id;
$query="select $id from $table";
$result=mysql_query($query,$conn_id);
$number=mysql_num_rows($result);
return $number;
}

function sql_close(){
global $conn_id;
mysql_close($conn_id);
}
function h_banners()	{
global $cookie_url,$main_url;
	
	$sql="select * from banners where b_blk='N' and b_typ='H' and b_exp='N'";
	$res=mysql_query($sql);
	$dis=array();
	$dis_id=array();
	$num=mysql_num_rows($res);
	if(mysql_num_rows($res))	{
		while($row=mysql_fetch_object($res))	{
			$tmp=explode(".",$row->b_img);
			$tmp_count=count($tmp);
			$ext=strtolower($tmp[$tmp_count-1]);
			if($ext=="swf")	{
				$img_s="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='420' height='60'>
  						<param name='movie' value='".$main_url."/".$row->b_img."'>
						<param name='quality' value='high'>
						<embed src='".$main_url."/".$row->b_img."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='420' height='60'></embed></object>";
			}	else	$img_s="<img src='".$main_url."/".$row->b_img."' border='0' width='420' height='60' alt='".stripslashes($row->b_desc)."' ismap>";
			$dis[]="<A href='".$main_url."/banners/index.php?url=".$row->b_url."&seid=".$row->b_id."&sess=set' target='_blank'>".$img_s."</a>";
			$dis_id[]=$row->b_id;
		}
		$tak=rand(0,$num);
		$sql_query="select * from banners where b_id='$dis_id[$tak]'";
		$num=sql_execute($sql_query,'num');
		if($num!=0)	{
			$bann=sql_execute($sql_query,'get');
				$d_f=date("d",$bann->b_f_day);
				$m_f=date("m",$bann->b_f_day);
				$y_f=date("Y",$bann->b_f_day);
				$d_t=date("d",$bann->b_t_day);
				$m_t=date("m",$bann->b_t_day);
				$y_t=date("Y",$bann->b_t_day);
//				$f_day=mktime(0,0,0,$m_f,$d_f,$y_f);
//				$t_day=mktime(0,0,0,$m_t,$d_t,$y_t);
				$f_day=mktime(0,0,0,$m_f,$d_f,$y_f);
				$t_day=mktime(0,0,0,$m_t,$d_t,$y_t);
				$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
				if(($bann->b_dur=="D") and ($today>$t_day))	{
					delete_banner($dis_id[$tak]);
				}
				elseif($bann->b_dur=="C" and ($bann->b_ncl<=$bann->b_clks))	{
					delete_banner($dis_id[$tak]);
				}
				elseif($bann->b_dur=="I" and ($bann->b_noi<=$bann->b_see))	{
					delete_banner($dis_id[$tak]);
				}
			echo $dis[$tak];
			for($i=0; $i<=$ip_co; $i++)	{
					mysql_query("update banners set b_see=b_see+1 where b_id='$dis_id[$tak]'");
			}
		}
	}
}
function f_banners()	{
global $cookie_url,$main_url;

	$sql="select * from banners where b_blk='N' and b_typ='F' and b_exp='N'";
	$res=mysql_query($sql);
	$dis=array();
	$dis_id=array();
	$num=mysql_num_rows($res);
	if(mysql_num_rows($res))	{
		while($row=mysql_fetch_object($res))	{
			$tmp=explode(".",$row->b_img);
			$tmp_count=count($tmp);
			$ext=strtolower($tmp[$tmp_count-1]);
			if($ext=="swf")	{
				$img_s="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='720' height='60'>
  						<param name='movie' value='".$main_url."/".$row->b_img."'>
						<param name='quality' value='high'>
						<param name='wmode' value='opaque'>
						<param name='loop' value='false'>
						<embed src='".$main_url."/".$row->b_img."' loop='false' wmode='opaque' quality='high' swLiveConnect='false' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='720' height='60'></embed></object>";
			}	else	$img_s="<img src='".$main_url."/".$row->b_img."' border='0' width='720' height='60' alt='".stripslashes($row->b_desc)."' ismap>";
			$dis[]="<A href='".$main_url."/banners/index.php?url=".$row->b_url."&seid=".$row->b_id."&sess=set' target='_blank'>".$img_s."</a>";
			$dis_id[]=$row->b_id;
		}
		$tak=rand(0,$num);
		$sql_query="select * from banners where b_id='$dis_id[$tak]'";
		$num=sql_execute($sql_query,'num');
		if($num!=0)	{
			$bann=sql_execute($sql_query,'get');
				$d_f=date("d",$bann->b_f_day);
				$m_f=date("m",$bann->b_f_day);
				$y_f=date("Y",$bann->b_f_day);
				$d_t=date("d",$bann->b_t_day);
				$m_t=date("m",$bann->b_t_day);
				$y_t=date("Y",$bann->b_t_day);
//				$f_day=mktime(0,0,0,$m_f,$d_f,$y_f);
//				$t_day=mktime(0,0,0,$m_t,$d_t,$y_t);
//				$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
				$f_day=mktime(0,0,0,$m_f,$d_f,$y_f);
				$t_day=mktime(0,0,0,$m_t,$d_t,$y_t);
				$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
				if(($bann->b_dur=="D") and ($today>$t_day))	{
					delete_banner($dis_id[$tak]);
				}
				elseif($bann->b_dur=="C" and ($bann->b_ncl<=$bann->b_clks))	{
					delete_banner($dis_id[$tak]);
				}
				elseif($bann->b_dur=="I" and ($bann->b_noi<=$bann->b_see))	{
					delete_banner($dis_id[$tak]);
				}
			echo $dis[$tak];
			for($i=0; $i<=$ip_co; $i++)	{
				mysql_query("update banners set b_see=b_see+1 where b_id='$dis_id[$tak]'");
			}
		}
	}
}

function mailing($to,$name,$from,$subj,$body) {
global $SERVER_NAME;
$subj=nl2br($subj);
$body=nl2br($body);
$recipient = $to;
$headers = "From: " . "$name" . "<" . "$from" . ">\n";
$headers .= "X-Sender: <" . "$to" . ">\n";
$headers .= "Return-Path: <" . "$to" . ">\n";
$headers .= "Error-To: <" . "$to" . ">\n";
$headers .= "Content-Type: text/html\n";
mail("$recipient","$subj","$body","$headers");
}

function form_get($value){
global $HTTP_POST_VARS,$HTTP_GET_VARS,$_SERVER;
$REQUEST_METHOD=$_SERVER["REQUEST_METHOD"];
if($REQUEST_METHOD=='POST'){
$get_value=$HTTP_POST_VARS["$value"];
}
elseif($REQUEST_METHOD=='GET'){
$get_value=$HTTP_GET_VARS["$value"];
}
return $get_value;
}

function cookie_get($name){
global $HTTP_COOKIE_VARS;
return $HTTP_COOKIE_VARS[$name];
}

//require file, depending on mode
function check($mode){
global $cookie_url,$main_url;
  if(isset($mode)){
    $document=$mode.".php";
  }
  else{
  	$document="main.php";
  }
  require("$document");
}

//require admin file, depending on mode
function ad_check($mode){
  if(isset($mode)){
    $document=$mode.".php";
  }
  else{
  	$document="main.php";
  }
  require("admin/$document");
}
//require calendar file, depending on mode
function cal_check($mode){
  if(isset($mode)){
    $document=$mode.".php";
  }
  else{
  	$document="calendar.php";
  }
  require("calendar/$document");
}

//printing java code for listing categories
function listing_cats_java($mod){
$sql_query="select * from categories";
$res=sql_execute($sql_query,'res');
while($cat=mysql_fetch_object($res)){
if($mod==1){
echo ";
 listCategory.setDefaultOption('$cat->cat_id','$cat->cat_id');
 listCategory.addOptions('$cat->cat_id','Select Subcategory','$cat->cat_id'";
}
elseif($mod==2){
$nex=$cat->cat_id+1;
echo "
listmessage_categoryId.setDefaultOption('$cat->cat_id','$nex');
listmessage_categoryId.addOptions('$cat->cat_id'";
}
   $sql_query="select * from sub_categories where cat_id='$cat->cat_id'";
   $res2=sql_execute($sql_query,'res');
   while($sub=mysql_fetch_object($res2)){
      echo ",'$sub->name','$sub->sub_cat_id'";
   }//while
   echo ");";
}//while

}//function

// Returnds the curent page number on a multipage display
function getpage(){
  	if(!isset($_GET['page'])) $page=1;
  	else $page=$_GET['page'];
    return $page;
}
function getpages(){
  	if(!isset($_GET['page'])) $page=1;
  	else $page=$_GET['page'];
    return $page;
}

//Displays the page numbers
function show_page_nos($sql,$url,$lines,$page){
    $tmp	=explode("LIMIT",$sql);
    if(count($tmp)<1) $tmp	=explode("limit",$sql);
  	$pgsql	=$tmp[0];
    include 'show_pagenos.php';
}
//Formats The Date
function format_date($date,$time=0){
    $tmp	=explode(" ",$date);
	$date2	=explode("-",$tmp[0]);
	$date	=$date2[1]."-".$date2[2]."-".$date2[0];
	if($time) return $date." ".$tmp[1];
	else return $date;
}

//just printing listing cats list
function listing_cats($sel){
$sql_query="select * from categories";
$res=sql_execute($sql_query,'res');
while($cat=mysql_fetch_object($res)){
    if($cat->cat_id=="$sel"){
    echo "<option selected value='$cat->cat_id'>$cat->name";
    }
    else{
    echo "<option value='$cat->cat_id'>$cat->name";
    }

}//while
}//function
//just printing events cats list
function events_cats($sel){
$sql_query="select * from event_cat";
$res=sql_execute($sql_query,'res');
while($cat=mysql_fetch_object($res)){
    if($cat->cat_id=="$sel"){
    echo "<option selected value='$cat->event_id'>".stripslashes($cat->event_nam)."</option>";
    }
    else{
    echo "<option value='$cat->event_id'>".stripslashes($cat->event_nam)."</option>";
    }

}//while
}//function

//admin header
function show_ad_header($adsess){
$mode=form_get("mode");
$act=form_get("act");
?>
<html>
<head>
<title>Site Administration</title>
<link href="styles/style.css" type="text/css" rel="stylesheet">
<? if(($mode='listings_manager')&&($act=='edit')) {?>
<script language="Javascript" src="DynamicOptionList.js"></script>
<SCRIPT LANGUAGE="JavaScript">

var listCategory = new DynamicOptionList("Category","RootCategory");

<?
listing_cats_java(1);
?>

	listCategory.addOptions('','Select Subcategory','');
 listCategory.setDefaultOption('','');

function init() {
	var theform = document.forms["searchListing"];
	listCategory.init(theform);
	}
</SCRIPT>

<body marginwidth="5" bgcolor="#ffffff" leftmargin ="5" topmargin="5" marginheight="5" onLoad="listCategory.init(document.forms['searchListing']);">
<? } ?>
</head>
<body topmargin=2 leftmargin=2>
<table width="740">
<tr><td width=100%>
<? require('templates/ad_header.php'); ?>
</td>
<tr><td width=100%>
<?
}//function


//showing header
function show_header(){
?>
<html>
<head>
<title>Demo Site</title>
<link href="styles/style.css" type="text/css" rel="stylesheet">
<?
$mode=form_get("mode");
$act=form_get("act");
if($mode=="user"){
   ?>
      <script language="JavaScript">
      <!--

         function formsubmit(type){
            document.profile.redir.value=type;
            document.profile.submit();
         }

      -->
      </script>
   <?
}
elseif(($mode=='listing')&&($act=='create')){
?>
<script language="Javascript" src="DynamicOptionList.js"></script>
<SCRIPT LANGUAGE="JavaScript">

var listmessage_categoryId = new DynamicOptionList("message_categoryId","message_rootCategoryId");

<? listing_cats_java(2); ?>
																																					listmessage_categoryId.addOptions('8000','computer','8001','creative','8002','erotic','8003','event','8004','household','8005','garden / labor / haul','8006','lessons','8007','looking for','8008','skilled trade','8009','sm biz ads','8010','therapeutic','8011');


function init() {
	var theform = document.forms["manageListing"];
	listmessage_categoryId.init(theform);
	}
</SCRIPT>
<body marginwidth="5" bgcolor="#ffffff" leftmargin ="5" topmargin="5" marginheight="5" onLoad="listmessage_categoryId.init(document.forms['manageListing']);">
<?
}
elseif((($mode=='listing')&&($act!='create')&&($act!='show')&&($act!='feedback'))||(($mode=='search')&&($act=='listing'))){
?>
<script language="Javascript" src="DynamicOptionList.js"></script>
<SCRIPT LANGUAGE="JavaScript">

var listCategory = new DynamicOptionList("Category","RootCategory");

<?
 listing_cats_java(1);
?>


	listCategory.addOptions('','Select Subcategory','');
 listCategory.setDefaultOption('','');

function init() {
	var theform = document.forms["searchListing"];
	listCategory.init(theform);
	}
</SCRIPT>

<body marginwidth="5" bgcolor="#ffffff" leftmargin ="5" topmargin="5" marginheight="5" onLoad="listCategory.init(document.forms['searchListing']);">
<?
}//elseif
?>
</head>
<body topmargin=2 leftmargin=2>
<table width="740">
<tr><td width=100%>
<? require('templates/header.php'); ?>
</td>
<tr><td width=100%>
<?
}

//showing footer
function show_footer(){
?>
</td>
<tr><td width=100%>
<? require("templates/footer.php"); ?>
</td></body></html>
<?
sql_close();
}


//redirect
function show_screen($loc){
Header("Location: $loc");
exit;
}

//error reports
function error_screen($errid){
$sql_query="select * from errors where err_id='$errid'";
$err=sql_execute($sql_query,'get');
$error_line=$err->error;
$detailes_line=$err->detailes;
show_header();
require('error.php');
show_footer();
exit();
}

//complete pages
function complete_screen($comid){
$sql_query="select * from complete where cmp_id='$comid'";
$cmp=sql_execute($sql_query,'get');
$header_line=$cmp->complete;
$detailes_line=$cmp->detailes;
show_header();
require('complete.php');
show_footer();
exit();
}

//checkin user login info
function login_test($mem_id,$mem_pass){
$sql_query="select password,ban from members where mem_id='$mem_id'";
$num=sql_execute($sql_query,'num');
$mem=sql_execute($sql_query,'get');
//if password incorrect
if(($num==0)||($mem_pass!=$mem->password)){
error_screen(0);
}
//if user banned
elseif($mem->ban=='y'){
error_screen(12);
}
//updating db (setting user in online mode)
$now=time();
$was=$now-60*20;
$sql_query="update members set current='$now' where mem_id='$mem_id'";
sql_execute($sql_query,'');
$sql_query="update members set online='off' where current < $was";
sql_execute($sql_query,'');
}

//checkin admin session key
function admin_test($session){
$time=time();
$interval=$time-3600*24;
$sql_query="delete from admin where started < $interval";
sql_execute($sql_query,'');
$sql_query="select * from admin where sess_id='$session'";
$num=sql_execute($sql_query,'num');
if($num==0){
error_screen(24);
}
}

//sending messages, depending on message id
function messages($to,$mid,$data){
global $system_mail,$site_name;
if($mid==7){
$subject=$data[0];
$body=$data[1];
$name=$data[2];
$from_mail=$data[3];
}//if
else{
$sql_query="select * from messages where mes_id='$mid'";
$mes=sql_execute($sql_query,'get');
$subject=$mes->subject;
$body=$mes->body;

//replacing templates
$body=ereg_replace("\|email\|","$data[0]",$body);
$body=ereg_replace("\|password\|","$data[1]",$body);
$body=ereg_replace("\|link\|","$data",$body);
$body=ereg_replace("\|subject\|","$data[0]",$body);
$body=ereg_replace("\|message\|","$data[1]",$body);
$body=ereg_replace("\|user\|","$data[0]",$body);

$subject=ereg_replace("\|email\|","$data[0]",$subject);
$subject=ereg_replace("\|password\|","$data[1]",$subject);
$subject=ereg_replace("\|link\|","$data",$subject);
$subject=ereg_replace("\|subject\|","$data[0]",$subject);
$subject=ereg_replace("\|message\|","$data[1]",$subject);
$subject=ereg_replace("\|user\|","$data[0]",$subject);

$name=$site_name;
$from_mail=$system_mail;
}//else

$subject=stripslashes($subject);
$body=stripslashes($body);

$sql_query="select notifications from members where email='$to'";
$num=sql_execute($sql_query,'num');
if($num>0){
  $mem=sql_execute($sql_query,'get');
  if($mem->notifications=='1'){
    $stat=1;
  }
  else {
    $stat=0;
  }
}
else {
  $stat=1;
}

if(($stat==1)||($mid<4)){
mailing($to,$name,$from_mail,$subject,$body);
}
}

//deleting empty values of array
function if_empty($data){
$flag=0;
if($data==''){
  return '';
}//if
else{
$result=array();
foreach($data as $val){
  if($val!=''){
    $flag=1;
    array_push($result,$val);
  }//if
}//foreach
if($flag==0){
  return '';
}//elseif
else {
  return $result;
}//else
}//else
}//function

//showing country drop-down list
function country_drop(){
?>
          <OPTION VALUE="United States">United States</OPTION>
		  <OPTION VALUE="Afghanistan">Afghanistan</OPTION>
		  <OPTION VALUE="Albania">Albania</OPTION>
		  <OPTION VALUE="Algeria">Algeria</OPTION>
          <OPTION VALUE="American Samoa">American Samoa</OPTION>
          <OPTION VALUE="Andorra">Andorra</OPTION>
          <OPTION VALUE="Angola">Angola</OPTION>
          <OPTION VALUE="Anguilla">Anguilla</OPTION>
          <OPTION VALUE="Antartica">Antartica</OPTION>
          <OPTION VALUE="Antigua and Barbuda">Antigua and Barbuda</OPTION>
          <OPTION VALUE="Argentina">Argentina</OPTION>
          <OPTION VALUE="Armenia">Armenia</OPTION>
          <OPTION VALUE="Aruba">Aruba</OPTION>
          <OPTION VALUE="Ascension Island">Ascension Island</OPTION>
          <OPTION VALUE="Australia">Australia</OPTION>
          <OPTION VALUE="Austria">Austria</OPTION>
          <OPTION VALUE="Azerbaijan">Azerbaijan</OPTION>
          <OPTION VALUE="Bahamas">Bahamas</OPTION>
          <OPTION VALUE="Bahrain">Bahrain</OPTION>
          <OPTION VALUE="Bangladesh">Bangladesh</OPTION>
          <OPTION VALUE="Barbados">Barbados</OPTION>
          <OPTION VALUE="Belarus">Belarus</OPTION>
          <OPTION VALUE="Belgium">Belgium</OPTION>
          <OPTION VALUE="Belize">Belize</OPTION>
          <OPTION VALUE="Benin">Benin</OPTION>
          <OPTION VALUE="Bermuda">Bermuda</OPTION>
          <OPTION VALUE="Bhutan">Bhutan</OPTION>
          <OPTION VALUE="Bolivia">Bolivia</OPTION>
          <OPTION VALUE="Botswana">Botswana</OPTION>
          <OPTION VALUE="Bouvet Island">Bouvet Island</OPTION>
          <OPTION VALUE="Brazil">Brazil</OPTION>
          <OPTION VALUE="Brunei Darussalam">Brunei Darussalam</OPTION>
          <OPTION VALUE="Bulgaria">Bulgaria</OPTION>
          <OPTION VALUE="Burkina Faso">Burkina Faso</OPTION>
          <OPTION VALUE="Burundi">Burundi</OPTION>
          <OPTION VALUE="Cambodia">Cambodia</OPTION>
          <OPTION VALUE="Cameroon">Cameroon</OPTION>
          <OPTION VALUE="Canada">Canada</OPTION>
          <OPTION VALUE="Cape Verde Islands">Cape Verde Islands</OPTION>
          <OPTION VALUE="Cayman Islands">Cayman Islands</OPTION>
          <OPTION VALUE="Chad">Chad</OPTION>
          <OPTION VALUE="Chile">Chile</OPTION>
          <OPTION VALUE="China">China</OPTION>
          <OPTION VALUE="Christmas Island">Christmas Island</OPTION>
          <OPTION VALUE="Colombia">Colombia</OPTION>
          <OPTION VALUE="Comoros">Comoros</OPTION>
          <OPTION VALUE="Congo, Republic of">Congo, Republic of</OPTION>
          <OPTION VALUE="Cook Islands">Cook Islands</OPTION>
          <OPTION VALUE="Costa Rica">Costa Rica</OPTION>
          <OPTION VALUE="Cote d Ivoire">Cote d'Ivoire</OPTION>
          <OPTION VALUE="Croatia/Hrvatska">Croatia/Hrvatska</OPTION>
          <OPTION VALUE="Cyprus">Cyprus</OPTION>
          <OPTION VALUE="Czech Republic">Czech Republic</OPTION>
          <OPTION VALUE="Denmark">Denmark</OPTION>
          <OPTION VALUE="Djibouti">Djibouti</OPTION>
          <OPTION VALUE="Dominica">Dominica</OPTION>
          <OPTION VALUE="Dominican Republic">Dominican Republic</OPTION>
          <OPTION VALUE="East Timor">East Timor</OPTION>
          <OPTION VALUE="Ecuador">Ecuador</OPTION>
          <OPTION VALUE="Egypt">Egypt</OPTION>
          <OPTION VALUE="El Salvador">El Salvador</OPTION>
          <OPTION VALUE="Equatorial Guinea">Equatorial Guinea</OPTION>
          <OPTION VALUE="Eritrea">Eritrea</OPTION>
          <OPTION VALUE="Estonia">Estonia</OPTION>
          <OPTION VALUE="Ethiopia">Ethiopia</OPTION>
          <OPTION VALUE="Falkland Islands">Falkland Islands</OPTION>
          <OPTION VALUE="Faroe Islands">Faroe Islands</OPTION>
          <OPTION VALUE="Fiji">Fiji</OPTION>
          <OPTION VALUE="Finland">Finland</OPTION>
          <OPTION VALUE="France">France</OPTION>
          <OPTION VALUE="French Guiana">French Guiana</OPTION>
          <OPTION VALUE="French Polynesia">French Polynesia</OPTION>
          <OPTION VALUE="Gabon">Gabon</OPTION>
          <OPTION VALUE="Gambia">Gambia</OPTION>
          <OPTION VALUE="Georgia">Georgia</OPTION>
          <OPTION VALUE="Germany">Germany</OPTION>
          <OPTION VALUE="Ghana">Ghana</OPTION>
          <OPTION VALUE="Gibraltar">Gibraltar</OPTION>
          <OPTION VALUE="Greece">Greece</OPTION>
          <OPTION VALUE="Greenland">Greenland</OPTION>
          <OPTION VALUE="Grenada">Grenada</OPTION>
          <OPTION VALUE="Guadeloupe">Guadeloupe</OPTION>
          <OPTION VALUE="Guam">Guam</OPTION>
          <OPTION VALUE="Guatemala">Guatemala</OPTION>
          <OPTION VALUE="Guernsey">Guernsey</OPTION>
          <OPTION VALUE="Guinea">Guinea</OPTION>
          <OPTION VALUE="Guinea-Bissau">Guinea-Bissau</OPTION>
          <OPTION VALUE="Guyana">Guyana</OPTION>
          <OPTION VALUE="Haiti">Haiti</OPTION>
          <OPTION VALUE="Honduras">Honduras</OPTION>
          <OPTION VALUE="Hong Kong">Hong Kong</OPTION>
          <OPTION VALUE="Hungary">Hungary</OPTION>
          <OPTION VALUE="Iceland">Iceland</OPTION>
          <OPTION VALUE="India">India</OPTION>
          <OPTION VALUE="Indonesia">Indonesia</OPTION>
          <OPTION VALUE="Iran">Iran</OPTION>
          <OPTION VALUE="Ireland">Ireland</OPTION>
          <OPTION VALUE="Isle of Man">Isle of Man</OPTION>
          <OPTION VALUE="Israel">Israel</OPTION>
          <OPTION VALUE="Italy">Italy</OPTION>
          <OPTION VALUE="Jamaica">Jamaica</OPTION>
          <OPTION VALUE="Japan">Japan</OPTION>
          <OPTION VALUE="Jersey">Jersey</OPTION>
          <OPTION VALUE="Jordan">Jordan</OPTION>
          <OPTION VALUE="Kazakhstan">Kazakhstan</OPTION>
          <OPTION VALUE="Kenya">Kenya</OPTION>
          <OPTION VALUE="Kiribati">Kiribati</OPTION>
          <OPTION VALUE="Korea, Republic of">Korea, Republic of</OPTION>
          <OPTION VALUE="Kuwait">Kuwait</OPTION>
          <OPTION VALUE="Kyrgyzstan">Kyrgyzstan</OPTION>
          <OPTION VALUE="Laos">Laos</OPTION>
          <OPTION VALUE="Latvia">Latvia</OPTION>
          <OPTION VALUE="Lebanon">Lebanon</OPTION>
          <OPTION VALUE="Lesotho">Lesotho</OPTION>
          <OPTION VALUE="Liberia">Liberia</OPTION>
          <OPTION VALUE="Libya">Libya</OPTION>
          <OPTION VALUE="Liechtenstein">Liechtenstein</OPTION>
          <OPTION VALUE="Lithuania">Lithuania</OPTION>
          <OPTION VALUE="Luxembourg">Luxembourg</OPTION>
          <OPTION VALUE="Macau">Macau</OPTION>
          <OPTION VALUE="Macedonia">Macedonia</OPTION>
          <OPTION VALUE="Madagascar">Madagascar</OPTION>
          <OPTION VALUE="Malawi">Malawi</OPTION>
          <OPTION VALUE="Malaysia">Malaysia</OPTION>
          <OPTION VALUE="Maldives">Maldives</OPTION>
          <OPTION VALUE="Mali">Mali</OPTION>
          <OPTION VALUE="Malta">Malta</OPTION>
          <OPTION VALUE="Marshall Islands">Marshall Islands</OPTION>
          <OPTION VALUE="Martinique">Martinique</OPTION>
          <OPTION VALUE="Mauritania">Mauritania</OPTION>
          <OPTION VALUE="Mauritius">Mauritius</OPTION>
          <OPTION VALUE="Mayotte Island">Mayotte Island</OPTION>
          <OPTION VALUE="Mexico">Mexico</OPTION>
          <OPTION VALUE="Micronesia">Micronesia</OPTION>
          <OPTION VALUE="Moldova">Moldova</OPTION>
          <OPTION VALUE="Monaco">Monaco</OPTION>
          <OPTION VALUE="Mongolia">Mongolia</OPTION>
          <OPTION VALUE="Montserrat">Montserrat</OPTION>
          <OPTION VALUE="Morocco">Morocco</OPTION>
          <OPTION VALUE="Mozambique">Mozambique</OPTION>
          <OPTION VALUE="Myanmar">Myanmar</OPTION>
          <OPTION VALUE="Namibia">Namibia</OPTION>
          <OPTION VALUE="Nauru">Nauru</OPTION>
          <OPTION VALUE="Nepal">Nepal</OPTION>
          <OPTION VALUE="Netherlands">Netherlands</OPTION>
          <OPTION VALUE="Netherlands Antilles">Netherlands Antilles</OPTION>
          <OPTION VALUE="New Caledonia">New Caledonia</OPTION>
          <OPTION VALUE="New Zealand">New Zealand</OPTION>
          <OPTION VALUE="Nicaragua">Nicaragua</OPTION>
          <OPTION VALUE="Niger">Niger</OPTION>
          <OPTION VALUE="Nigeria">Nigeria</OPTION>
          <OPTION VALUE="Niue">Niue</OPTION>
          <OPTION VALUE="Norfolk Island">Norfolk Island</OPTION>
          <OPTION VALUE="Norway">Norway</OPTION>
          <OPTION VALUE="Oman">Oman</OPTION>
          <OPTION VALUE="Pakistan">Pakistan</OPTION>
          <OPTION VALUE="Palau">Palau</OPTION>
          <OPTION VALUE="Panama">Panama</OPTION>
          <OPTION VALUE="Papua New Guinea">Papua New Guinea</OPTION>
          <OPTION VALUE="Paraguay">Paraguay</OPTION>
          <OPTION VALUE="Peru">Peru</OPTION>
          <OPTION VALUE="Philippines">Philippines</OPTION>
          <OPTION VALUE="Pitcairn Island">Pitcairn Island</OPTION>
          <OPTION VALUE="Poland">Poland</OPTION>
          <OPTION VALUE="Portugal">Portugal</OPTION>
          <OPTION VALUE="Puerto Rico">Puerto Rico</OPTION>
          <OPTION VALUE="Qatar">Qatar</OPTION>
          <OPTION VALUE="Reunion Island">Reunion Island</OPTION>
          <OPTION VALUE="Romania">Romania</OPTION>
          <OPTION VALUE="Russian Federation">Russian Federation</OPTION>
          <OPTION VALUE="Rwanda">Rwanda</OPTION>
          <OPTION VALUE="Saint Helena">Saint Helena</OPTION>
          <OPTION VALUE="Saint Lucia">Saint Lucia</OPTION>
          <OPTION VALUE="San Marino">San Marino</OPTION>
          <OPTION VALUE="Saudi Arabia">Saudi Arabia</OPTION>
          <OPTION VALUE="Senegal">Senegal</OPTION>
          <OPTION VALUE="Seychelles">Seychelles</OPTION>
          <OPTION VALUE="Sierra Leone">Sierra Leone</OPTION>
          <OPTION VALUE="Singapore">Singapore</OPTION>
          <OPTION VALUE="Slovak Republic">Slovak Republic</OPTION>
          <OPTION VALUE="Slovenia">Slovenia</OPTION>
          <OPTION VALUE="Solomon Islands">Solomon Islands</OPTION>
          <OPTION VALUE="Somalia">Somalia</OPTION>
          <OPTION VALUE="South Africa">South Africa</OPTION>
          <OPTION VALUE="South Georgia">South Georgia</OPTION>
          <OPTION VALUE="Spain">Spain</OPTION>
          <OPTION VALUE="Sri Lanka">Sri Lanka</OPTION>
          <OPTION VALUE="Suriname">Suriname</OPTION>
          <OPTION VALUE="Svalbard">Svalbard</OPTION>
          <OPTION VALUE="Swaziland">Swaziland</OPTION>
          <OPTION VALUE="Sweden">Sweden</OPTION>
          <OPTION VALUE="Switzerland">Switzerland</OPTION>
          <OPTION VALUE="Syria">Syria</OPTION>
          <OPTION VALUE="Taiwan">Taiwan</OPTION>
          <OPTION VALUE="Tajikistan">Tajikistan</OPTION>
          <OPTION VALUE="Tanzania">Tanzania</OPTION>
          <OPTION VALUE="Thailand">Thailand</OPTION>
          <OPTION VALUE="Togo">Togo</OPTION>
          <OPTION VALUE="Tokelau">Tokelau</OPTION>
          <OPTION VALUE="Tonga Islands">Tonga Islands</OPTION>
          <OPTION VALUE="Tunisia">Tunisia</OPTION>
          <OPTION VALUE="Turkey">Turkey</OPTION>
          <OPTION VALUE="Turkmenistan">Turkmenistan</OPTION>
          <OPTION VALUE="Tuvalu">Tuvalu</OPTION>
          <OPTION VALUE="Uganda">Uganda</OPTION>
          <OPTION VALUE="Ukraine">Ukraine</OPTION>
          <OPTION VALUE="United Kingdom">United Kingdom</OPTION>
          <OPTION VALUE="Uruguay">Uruguay</OPTION>
          <OPTION VALUE="Uzbekistan">Uzbekistan</OPTION>
          <OPTION VALUE="Vanuatu">Vanuatu</OPTION>
          <OPTION VALUE="Vatican City">Vatican City</OPTION>
          <OPTION VALUE="Venezuela">Venezuela</OPTION>
          <OPTION VALUE="Vietnam">Vietnam</OPTION>
          <OPTION VALUE="Western Sahara">Western Sahara</OPTION>
          <OPTION VALUE="Western Samoa">Western Samoa</OPTION>
          <OPTION VALUE="Yemen">Yemen</OPTION>
          <OPTION VALUE="Yugoslavia">Yugoslavia</OPTION>
          <OPTION VALUE="Zambia">Zambia</OPTION>
          <OPTION VALUE="Zimbabwe">Zimbabwe</OPTION>
<?
}

//days drop-down list
function day_drop($sel){
 for($i=1;$i<=31;$i++){
  if($i==$sel){
  echo "<option selected value='$i'>$i\n";
  }
  else {
  echo "<option value='$i'>$i\n";
  }
 }
}

//months drop-down list
function month_drop($sel){
 $month=array(1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"May",6=>"Jun",
 7=>"Jul",8=>"Aug",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dec");
 for($i=1;$i<=12;$i++){
  if($i==$sel){
  echo "<option selected value='$i'>$month[$i]\n";
  }
  else {
  echo "<option value='$i'>$month[$i]\n";
  }
 }
}

//years drop-down list
function year_drop($sel){
if($sel=='now'){
   $year=2010;
   $start=date("Y");
   for($i=$start;$i<=$year;$i++){
     echo "<option value='$i'>$i\n";
   }//for
}//if
else{
 	$year=date("Y");
	 for($i=$year-50;$i<=$year;$i++){
	 if($i==$sel){
	  echo "<option selected value='$i'>$i\n";
	 }
	 else {
	  echo "<option value='$i'>$i\n";
	 }
	 }
}//else
}

//showing if user is online,offline or anonymous
function show_online($m_id){
$sql_query="select fname,lname,online from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
if($mem->online=='on'){
echo "<img src='images/icon_online.gif' alt='this user is online now'>";
echo "&nbsp&nbsp<span class='namelink-online'><a href='index.php?mode=people_card&p_id=$m_id'>$mem->fname</a></span>";
}
else{
echo "<img src='images/icon_offline.gif' alt='this user is offline now'>";
echo "&nbsp&nbsp<span class='namelink-offline'><a href='index.php?mode=people_card&p_id=$m_id'>$mem->fname</a></span>";
}
}

//showing user's name
function show_memnam($m_id){
$sql_query="select fname,lname from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
echo "<span class='namelink-online'><a href='index.php?mode=people_card&p_id=$m_id'>$mem->fname</a></span>";
}

//showing user main photo
function show_photo($m_id){
if($m_id=='anonim'){
echo "<img src='images/unknownUser_th.jpg' border=0>";
}//if
else {
$sql_query="select photo_thumb from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
if($mem->photo_thumb=='no'){
 $mem->photo_thumb="images/unknownUser_th.jpg";
}
echo "<a href='index.php?mode=people_card&p_id=$m_id'><img src='$mem->photo_thumb' border=0></a>";
}
}

//calculating number of new messages in inbox
function mes_num($m_id){
$sql_query="select mes_id from messages_system where mem_id='$m_id'
and folder='inbox' and type='message' and new='new'";
$num=sql_execute($sql_query,'num');
return $num;
}

//calculating number or creating array of user's friends, depending on degree
function count_network($m_id,$deg,$mod){
	//degree 1
    if($deg==1){

     		$sql_query="select frd_id from network where mem_id='$m_id'";
            $num=sql_execute($sql_query,'num');
            if($num==0){
             	$friend='';
            }//if
            else {
             	$res=sql_execute($sql_query,'res');
                $friend=array();
                while($fr=mysql_fetch_object($res)){
                   array_push($friend,$fr->frd_id);
                }//while
            $friend=del_dup($friend);
            }//else

    }//deg1


    //degree 2
    elseif($deg==2){

            $fr=array();
            $fr=count_network($m_id,"1","ar");
            if($fr==''){
                $friend='';
                $num=0;
            }//if
            else {
                $friend=array();
                foreach($fr as $fid){
                	$sql_query="select frd_id from network where mem_id='$fid' and frd_id!='$m_id'";
                    $res=sql_execute($sql_query,'res');
                    while($fri=mysql_fetch_object($res)){
                       array_push($friend,$fri->frd_id);
                    }//while
                }//foreach
                $friend=del_dup($friend);
                $friend=array_diff($friend,$fr);
                $num=count($friend);
            }//else

    }//deg2

    //degree 3
    elseif($deg==3){

            $fr=array();
            $fr1=count_network($m_id,"1","ar");
            $fr=count_network($m_id,"2","ar");
            if($fr==''){
                $friend='';
                $num=0;
            }//if
            else {
                $friend=array();
                foreach($fr as $fid){
                	$sql_query="select frd_id from network where mem_id='$fid' and frd_id!='$m_id'";
                    $res=sql_execute($sql_query,'res');
                    while($fri=mysql_fetch_object($res)){
                       array_push($friend,$fri->frd_id);
                    }//while
                }//foreach
                $friend=del_dup($friend);
                $friend=array_diff($friend,$fr);
                $friend=array_diff($friend,$fr1);
                $num=count($friend);
            }//else

    }//deg3


    //degree 4
	elseif($deg==4){

            $fr=array();
            $fr1=count_network($m_id,"1","ar");
            $fr2=count_network($m_id,"2","ar");
            $fr=count_network($m_id,"3","ar");
            if($fr==''){
                $friend='';
                $num=0;
            }//if
            else {
                $friend=array();
                foreach($fr as $fid){
                	$sql_query="select frd_id from network where mem_id='$fid' and frd_id!='$m_id'";
                    $res=sql_execute($sql_query,'res');
                    while($fri=mysql_fetch_object($res)){
                       array_push($friend,$fri->frd_id);
                    }//while
                }//foreach
                $friend=del_dup($friend);
                $friend=array_diff($friend,$fr);
                $friend=array_diff($friend,$fr1);
                $friend=array_diff($friend,$fr2);
                $num=count($friend);
            }//else

    }//deg4

    //degree all
    elseif($deg=='all'){

      $num=count_network($m_id,"1","num")+count_network($m_id,"2","num")+
      count_network($m_id,"3","num")+count_network($m_id,"4","num");
      $friend=array_merge(count_network($m_id,"1","ar"),count_network($m_id,"2","ar"),
      count_network($m_id,"3","ar"),count_network($m_id,"4","ar"));

    }//degall


           ////////////////////////////////////
					//format output
        			if ($mod=='num'){
        			 return $num;
        			}
        			elseif ($mod=='ar'){
        			 return $friend;
        			}
           ////////////////////////////////////

}

//deleting duplicates from array
function del_dup($data){
$result=array();
$result=array_unique($data);
return $result;
}

//showing random tip
function show_tip(){
$num=sql_rows("tip_id","tips");
$tid=rand(0,$num);
$sql_query="select * from tips where tip_id='$tid'";
$tip=sql_execute($sql_query,'get');
echo "<span class='bold'>$tip->tip_header</span></br>
$tip->tip";
}

//creating array of lister friends
function lister_degree($mem_id,$deg){
$result=array();
for($i=$deg;$i>=1;$i--){
   $network=count_network($mem_id,"$i","ar");
   $result=array_merge($result,$network);
}
$result=if_empty($result);
if($result==''){
  $result[]='';
}
return $result;
}//function

//showing listings, depending on mode
function show_listings($mode,$m_id,$page){
$now=time();
$sql_query="delete from listings where added+live<$now";
sql_execute($sql_query,'');
if($mode!='tribe'){
//setting ignore list
$sql_query="select ignore_list from members where mem_id='$m_id'";
$mem1=sql_execute($sql_query,'get');
$ignore=split("\|",$mem1->ignore_list);
$ignore=if_empty($ignore);
//setting filter
$sql_query="select filter,zip from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
$items=split("\|",$mem->filter);
$distance=$items[0];
$zip=$items[1];
if($zip==''){
 $zip=$mem->zip;
}
$degree=$items[2];
//applying distance filter
$zone=array();
if($distance=='any'){
$zonear='no result';
}else{
$zonear=inradius($zip,$distance);
}
if(($zonear=='not found')||($zonear=='no result')){
 $sql_query="select lst_id from listings";
 $res=sql_execute($sql_query,'res');
 while($z=mysql_fetch_object($res)){
  array_push($zone,$z->lst_id);
 }
}
else {
 $sql_query="select lst_id from listings where ";
 foreach($zonear as $zp){
 	$sql_query.="zip='$zp' or ";
 }
 $sql_query=rtrim($sql_query,' or ');
 $res=sql_execute($sql_query,'res');
 while($z=mysql_fetch_object($res)){
    array_push($zone,$z->lst_id);
 }
}
//applying degree filter
$friends=array();
$filter=array();
if($degree=='any'){
 $sql_query="select mem_id from members";
 $res=sql_execute($sql_query,'res');
 while($fr=mysql_fetch_object($res)){
  	array_push($friends,$fr->mem_id);
 }
}
else {
for($i=$degree;$i>=1;$i--){
$friends=array_merge($friends,count_network($m_id,$i,"ar"));
}//for
}//else
$filter=$friends;
}//if

$zone=if_empty($zone);
$filter=if_empty($filter);

//recent listings

			if($mode=='recent'){
                if(($filter!='')&&($zone!=''))
                {
            	$sql_query="select * from listings where (";
                if($filter!=''){
                foreach($filter as $id){
                   $sql_query.="mem_id='$id' or ";
                }//foreach
                $sql_query=rtrim($sql_query,' or ');
                }//if
                if($zone!=''){
                $sql_query.=") and (";
                foreach($zone as $zon){
                   $sql_query.="lst_id='$zon' or ";
                }//foreach
                $sql_query=rtrim($sql_query,' or ');
                $sql_query.=")";
                }//if
                if($ignore!=''){
                //deleting from sql-query ignored users
                   foreach($ignore as $ign){
                       $sql_query.=" and mem_id!='$ign'";
                   }//foreach
                }//if
                if($degree!='any'){
                   $sql_query.=" and anonim!='y'";
                }//if
                $sql_query.=" and stat='a' order by added desc";
                $res=sql_execute($sql_query,'res');
                if(mysql_num_rows($res)){
                $i=0;
                while($lst=mysql_fetch_object($res)){
                     if($lst->show_deg!='trb'){
                     if(($lst->show_deg!='any')&&($lst->mem_id!=$m_id)){
                     $lister_friends=lister_degree($lst->mem_id,$lst->show_deg);
                     }
                     else{
                     $lister_friends[]=$m_id;
                     }
                     //checkin if user is a friend of lister
                     if((in_array($m_id,$lister_friends))||($lst->anonim=='y')){
                     $date=date("m/d/Y",$lst->added);
                     $sql_query="select name from categories where cat_id='$lst->cat_id'";
                     $cat=sql_execute($sql_query,'get');
                     $sql_query="select name from sub_categories where sub_cat_id='$lst->sub_cat_id'";
                     $sub=sql_execute($sql_query,'get');
                     echo "<table>";
                     echo "<tr><td>
                     <table class='table-photo'>
                     <tr><td align=center width=70 height=75>";
                     if(($lst->privacy=='y')||($lst->anonim=='y')){
                        echo "<img src='images/unknownUser_th.jpg' border=0>";
                     }//if
                     else {
                        show_photo($lst->mem_id);
                     }//else
                     echo "</td>
                     <tr><td align=center>";
                     if($lst->anonim!='y'){
                     show_online($lst->mem_id);
                     }
                     else{
                     echo "<small><small>anonymous</small></small>";
                     }
                     echo "</td>
                     </table>
                     </td>";
                     echo "<td>
                     <table width=100% class='body'>
                     <tr><td class='form-comment'><a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id'>
                     <img src='images/icon_listing.gif' border=0>
                     $lst->title</a></td>
                     <tr><td>$date - $cat->name - $sub->name</td>
                     <tr><td>$lst->descr_part <span class='action'><a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id'>more</a></span></td>
                     <tr><td>";
                     if($lst->anonim!='y'){
                     connections($m_id,$lst->mem_id);
                     }
                     echo "</td>
                     </table>
                     </td>";
                     echo "</table>";
                     if($i==5){
                       break;
                     }
                     $i++;
                     }//if
                }//while
                }//if
                }//else
                }//if
            }//if
            //profile section listings from user and friends
            elseif($mode=='inprofile'){
            $friends=array();
            $friends=count_network($m_id,"1","ar");
            $sql_query="select * from listings where (mem_id='$m_id'";
            if($friends!=''){
            foreach($friends as $fr){
                $sql_query.=" or mem_id='$fr'";
            }//foreach
            }//if
            $sql_query.=") and stat='a' order by added";
            $num=sql_execute($sql_query,'num');
            if($num==0){
             echo "<p align=center>No listings available</p>&nbsp";
            }//if
            else {
            $res=sql_execute($sql_query,'res');
            while($lst=mysql_fetch_object($res)){
             	$date=date("m/d",$lst->added);
                echo "$date  <img src='images/icon_listing.gif'>
                <a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id'>$lst->title</a>";
                $c_name=get_cat_name($lst->cat_id);
                echo " (<a href='index.php?mode=listing&act=show_cat&cat_id=$lst->cat_id'>$c_name</a>) - ";
                show_online($lst->mem_id);
                echo "</br>";
            }//while
            }//else
            }//elseif
            //showing user's listings
            elseif($mode=='my'){
            $sql_query="select * from listings where mem_id='$m_id' and stat='a'";
            $sql_query.=" order by added";
            $num=sql_execute($sql_query,'num');
            if($num==0){
             echo "No listings available";
            }//if
            else {
            $res=sql_execute($sql_query,'res');
            while($lst=mysql_fetch_object($res)){
             	$date=date("m/d",$lst->added);
                echo "$date  <img src='images/icon_listing.gif'>
                <a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id'>$lst->title</a>";
                $c_name=get_cat_name($lst->cat_id);
                echo " (<a href='index.php?mode=listing&act=show_cat&cat_id=$lst->cat_id'>
                $c_name</a>) - ";show_online($lst->mem_id);
                echo "</br>";
            }//while
            }//else
            }//elseif
            //showing one category listings
            elseif($mode=='cat'){
            $cid=form_get('cat_id');
            $start=($page-1)*20;
            $sql_query="select * from listings where cat_id='$cid' and stat='a'";
            $sql_query.=" order by added limit $start,20";
            $num=sql_execute($sql_query,'num');
            if($num==0){
             echo "No listings available";
            }//if
            else {
            $res=sql_execute($sql_query,'res');
            while($lst=mysql_fetch_object($res)){
                if($lst->show_deg!='trb'){
                if(($lst->show_deg!='any')&&($lst->mem_id!=$m_id)){
                $lister_friends=lister_degree($lst->mem_id,$lst->show_deg);
                }
                else{
                $lister_friends[]=$m_id;
                }
                if((in_array($m_id,$lister_friends))||($lst->anonim=='y')){
             	$date=date("m/d",$lst->added);
                echo "$date  <img src='images/icon_listing.gif'>
                <a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id'>$lst->title</a>&nbsp";
                if($lst->anonim!='y'){
                show_online($lst->mem_id);echo " - ";
                }
                else{
                echo "anonymous";
                }
                echo find_relations($m_id,$lst->mem_id);
                echo "</br>";
                }//if
                }//if
            }//while
            }//else
            }//elseif
            //showing one sub-category listings
            elseif($mode=='sub_cat'){
            $sid=form_get('sub_cat_id');
            $start=($page-1)*20;
            $sql_query="select * from listings where sub_cat_id='$sid' and stat='a'";
            $sql_query.=" order by added limit $start,20";
            $num=sql_execute($sql_query,'num');
            if($num==0){
             echo "No listings available";
            }//if
            else {
            $res=sql_execute($sql_query,'res');
            while($lst=mysql_fetch_object($res)){
                if($lst->show_deg!='trb'){
                if(($lst->show_deg!='any')&&($lst->mem_id!=$m_id)){
                $lister_friends=lister_degree($lst->mem_id,$lst->show_deg);
                 }
                 else{
                 $lister_friends[]=$m_id;
                 }
                if((in_array($m_id,$lister_friends))||($lst->anonim=='y')){
             	$date=date("m/d",$lst->added);
                echo "$date  <img src='images/icon_listing.gif'>
                <a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id'>$lst->title</a>&nbsp";
                if($lst->anonim!='y'){
                show_online($lst->mem_id);
                }
                else{
                echo "anonymous";
                }
                echo " - ";echo find_relations($m_id,$lst->mem_id);
                echo "</br>";
                }//if
                }//if
            }//while
            }//else
            }//elseif
            //showing tribe listings
            elseif($mode=='tribe'){
            $sql_query="select * from listings where trb_id='$m_id' and stat='a'";
            $sql_query.=" order by added";
            $num=sql_execute($sql_query,'num');
            if($num==0){
             echo "No listings available";
            }//if
            else {
            $res=sql_execute($sql_query,'res');
            while($lst=mysql_fetch_object($res)){
             	$date=date("m/d",$lst->added);
                echo "$date  <img src='images/icon_listing.gif'>
                <a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id'>$lst->title</a>";
                $c_name=trim(get_cat_name($lst->cat_id));
                echo " (<a href='index.php?mode=listing&act=show_cat&cat_id=$lst->cat_id'>$c_name</a>) - ";
                show_online($lst->mem_id);
                echo "</br>";
            }//while
            }//else
            }//elseif

}//function

//searching degree between 2 users
function find_relations($mem_id,$frd_id){
if($frd_id=='0'){
   return '';
}
if($mem_id==$frd_id){
   return 'You';
}//if
else {
  $fr1=count_network($mem_id,"1","ar");
  if(is_array($fr1)&&in_array($frd_id,$fr1)){
    return "1&deg";
  }//if
  else {
  	   $fr2=count_network($mem_id,"2","ar");
       if(is_array($fr2)&&in_array($frd_id,$fr2)){
           return "2&deg";
       }//if
       else {
            $fr3=count_network($mem_id,"3","ar");
            if(is_array($fr3)&&in_array($frd_id,$fr3)){
                 return "3&deg";
            }//if
            else {
                 $fr4=count_network($mem_id,"4","ar");
                 if(is_array($fr4)&&in_array($frd_id,$fr4)){
                       return "4&deg";
                 }//if
                 else{
                       return "(unrelated)";
                 }//else
            }//else
       }//else
  }//else
}//else

}//function

//building a connection chain between 2 user's
function connections($mem_id,$frd_id){
//anonymous
if($frd_id=='0'){
echo '';
}
//1 user and 2 are the same
elseif($mem_id==$frd_id){
  echo "You";
}//if
else {
$friend=array();
$friend=count_network($mem_id,"1","ar");

//1 degree
if (is_array($friend)&&in_array($frd_id,$friend)){
    echo show_online($frd_id)."<img src='images/icon_arrow_blue.gif' border=0>You";
}//if
//2 degree
else {

     $friend=count_network($mem_id,"2","ar");
     if(is_array($friend)&&in_array($frd_id,$friend)){

             $deg2=count_network($frd_id,"1","ar");
             $my=count_network($mem_id,"1","ar");

             if(count($my)<count($deg2)){
             $result=array_intersect($my,$deg2);
             }
             else{
             $result=array_intersect($deg2,$my);
             }

             show_online($frd_id);echo "<img src='images/icon_arrow_blue.gif' border=0>";
             show_online($result[0]);echo "<img src='images/icon_arrow_blue.gif' border=0>You";

     }//if
     //3 degree
     else{

             $friend=count_network($mem_id,"3","ar");
             if(is_array($friend)&&in_array($frd_id,$friend)){

                    $deg1=count_network($frd_id,"1","ar");
                    $my2=count_network($mem_id,"2","ar");
                    if(count($my2)<count($deg1)){
             		$result=array_intersect($my2,$deg1);
		            }
        		    else{
		            $result=array_intersect($deg1,$my2);
        		    }

                    $deg2=count_network($frd_id,"2","ar");
                    $my=count_network($mem_id,"1","ar");
                    if(count($my)<count($deg2)){
      	            $result2=array_intersect($my,$deg2);
	                }
	                else{
	                $result2=array_intersect($deg2,$my);
	                }

                    foreach($result2 as $one){
                       if($one!=''){
                          $last=$one;
                          break;
                       }//if
                    }//foreach

                    show_online($frd_id);echo "<img src='images/icon_arrow_blue.gif' border=0>";
                    show_online($result[0]);echo "<img src='images/icon_arrow_blue.gif' border=0>";
                    show_online($last);echo "<img src='images/icon_arrow_blue.gif' border=0>You";


             }//if
             //4 degree
             else{

                    $friend=count_network($mem_id,"4","ar");
                    if(is_array($friend)&&in_array($frd_id,$friend)){

                               $deg1=count_network($frd_id,"1","ar");
                               $my3=count_network($mem_id,"3","ar");
                               if(count($my3)<count($deg1)){
             	               $result=array_intersect($my3,$deg1);
	                           }
	                           else{
	                           $result=array_intersect($deg1,$my3);
	                           }

                               $deg2=count_network($frd_id,"2","ar");
                               $my2=count_network($mem_id,"2","ar");
                               if(count($my2)<count($deg2)){
             	               $result1=array_intersect($my2,$deg2);
	                           }
	                           else{
	                           $result1=array_intersect($deg2,$my2);
	                           }

                               $deg3=count_network($frd_id,"3","ar");
                               $my1=count_network($mem_id,"1","ar");

                               if(count($my1)<count($deg3)){
             	               $result2=array_intersect($my1,$deg3);
	                           }
	                           else{
	                           $result2=array_intersect($deg3,$my1);
	                           }

                               foreach($result2 as $one){
                                   if($one!=''){
                                     $last=$one;
                                     break;
                                   }//if
                               }//foreach


                               show_online($frd_id);echo "<img src='images/icon_arrow_blue.gif' border=0>";
                               show_online($result[0]);echo "<img src='images/icon_arrow_blue.gif' border=0>";
                               show_online($result1[0]);echo "<img src='images/icon_arrow_blue.gif' border=0>";
                               show_online($last);echo "<img src='images/icon_arrow_blue.gif' border=0>You";

                    }//if
                    //no connection
                    else{

                               echo "No connections between You and ";show_online($frd_id);

                    }//else
             }//else
     }//else
}//else
}//else
}//function

//searching zip codes within specified radius
function inradius($zip,$radius)
    {
        $sql_query="SELECT * FROM zipData WHERE zipcode='$zip'";
        $num=sql_execute($sql_query,'num');
        if($num==0){
          return "not found";
        }//if
        else {
        	$zp=sql_execute($sql_query,'get');
            $lat=$zp->lat;
            $lon=$zp->lon;
            $sql_query="SELECT zipcode FROM zipData WHERE (POW((69.1*(lon-\"$lon\")*cos($lat/57.3)),\"2\")+POW((69.1*(lat-\"$lat\")),\"2\"))<($radius*$radius) ";
            $num2=sql_execute($sql_query,'num');
            if($num2>0){
                    $res=sql_execute($sql_query,'res');
                    $i=0;
                    while($found=mysql_fetch_object($res)) {
                    $zipArray[$i]=$found->zipcode;
                    $i++;
                	}//while
            }//if
            else {
              return "no result";
            }//else
        }//else
     return $zipArray;
    } // end func

//showing one user friends
function show_friends($m_id,$limit,$inline,$page){

    $friends=count_network($m_id,"1","ar");
    if($friends!=''){
    $start=($page-1)*$limit;
    $end=$start+$limit;
    if($end>count($friends)){
      $end=count($friends);
    }
    for($i=$start;$i<$end;$i++){
        $frd=$friends[$i];
        if(($i==0)||($i%$inline==0))
        {
           echo "<tr>";
        }//if
	    echo "<td width=65 height=75><table class='table-photo'>";
	    echo "<tr><td align=center width=65>";
	    show_photo($frd);
        echo "</td>
        <tr><td align=center>";
        show_online($frd);
        echo "</td></table></td>";
    }//foreach
    }//if
    else {
       echo "<p align=center>No friends.</p>";
    }//else

}//function

//showing pages line (if the output is too big, for ex. search results are split into several pages)
function pages_line($id,$type,$page,$limit){
   //spliting friends list
   if($type=='friends'){
      $friends=count_network($id,"1","num");
      if($friends!='0'){
      if($friends%$limit==0){
        $pages=$friends/$limit;
      }//if
      else {
        $pages=(int)($friends/$limit)+1;
      }//else

      $first="<a href='index.php?mode=people_card&act=friends&p_id=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if

   }//if
   if($type=='friends2'){
      $friends=count_network($id,"2","num");
      if($friends!='0'){
      if($friends%$limit==0){
        $pages=$friends/$limit;
      }//if
      else {
        $pages=(int)($friends/$limit)+1;
      }//else

      $first="<a href='index.php?mode=user&act=friends_view&pro=2&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if
   if($type=='friends3'){
      $friends=count_network($id,"3","num");
      if($friends!='0'){
      if($friends%$limit==0){
        $pages=$friends/$limit;
      }//if
      else {
        $pages=(int)($friends/$limit)+1;
      }//else

      $first="<a href='index.php?mode=user&act=friends_view&pro=3&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if
   if($type=='friends4'){
      $friends=count_network($id,"4","num");
      if($friends!='0'){
      if($friends%$limit==0){
        $pages=$friends/$limit;
      }//if
      else {
        $pages=(int)($friends/$limit)+1;
      }//else

      $first="<a href='index.php?mode=user&act=friends_view&pro=4&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if
   if($type=='friendsall'){
      $friends=count_network($id,"all","num");
      if($friends!='0'){
      if($friends%$limit==0){
        $pages=$friends/$limit;
      }//if
      else {
        $pages=(int)($friends/$limit)+1;
      }//else

      $first="<a href='index.php?mode=user&act=friends_view&pro=all&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

      //spliting members list
      elseif($type=='members'){
      $membs=tribe_members($id);
      $members=count($membs);
      if($members!='0'){
      if($members%$limit==0){
        $pages=$members/$limit;
      }//if
      else {
        $pages=(int)($members/$limit)+1;
      }//else

      $first="<a href='index.php?mode=tribe&act=view_mems&trb_id=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

   //spliting category listings list
   elseif($type=='cat'){
      $sql_query="select * from listings where cat_id='$id' and stat='a'";
      $listings=sql_execute($sql_query,'num');
      if($listings!='0'){
      if($listings%$limit==0){
        $pages=$listings/$limit;
      }//if
      else {
        $pages=(int)($listings/$limit)+1;
      }//else

      $first="<a href='index.php?mode=listing&act=show_cat&cat_id=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

   //spliting sub-category listings list
   elseif($type=='sub_cat'){
      $sql_query="select * from listings where sub_cat_id='$id' and stat='a'";
      $listings=sql_execute($sql_query,'num');
      if($listings!='0'){
      if($listings%$limit==0){
        $pages=$listings/$limit;
      }//if
      else {
        $pages=(int)($listings/$limit)+1;
      }//else

      $first="<a href='index.php?mode=listing&act=show_sub_cat&sub_cat_id=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

   //spliting user's photos list
   elseif($type=='photo_album'){

      $sql_query="select photo from photo where mem_id='$id'";
      $pho=sql_execute($sql_query,'get');
      $phot=split("\|",$pho->photo);
      $phot=if_empty($phot);

      $photos=count($phot);
      if($photos!='0'){
      if($photos%$limit==0){
        $pages=$photos/$limit;
      }//if
      else {
        $pages=(int)($photos/$limit)+1;
      }//else

      $first="<a href='index.php?mode=photo_album&p_id=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

   //spliting tribe photo list
   elseif($type=='tribe_photo_album'){
      $sql_query="select photo from tribe_photo where trb_id='$id'";
      $pho=sql_execute($sql_query,'get');
      $phot=split("\|",$pho->photo);
      $phot=if_empty($phot);

      $photos=count($phot);
      if($photos!='0'){
      if($photos%$limit==0){
        $pages=$photos/$limit;
      }//if
      else {
        $pages=(int)($photos/$limit)+1;
      }//else

      $first="<a href='index.php?mode=photo_album&act=tribe&trb_id=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
      }//if

      //spliting basic search results
      elseif($type=='basic'){

      $first="<a href='index.php?mode=search&act=user&type=basic";

    $form_data=array('degrees','distance','zip','fname','lname','email');
    while (list($key,$val)=each($form_data)){
    ${$val}=form_get("$val");
    $first.="&".$val."=".urlencode(${$val});
    }//while

    $first.="&page=";

      $search=$id;
      if($search%$limit==0){
        $pages=$search/$limit;
      }//if
      else {
        $pages=(int)($search/$limit)+1;
      }//else

      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";

   }//if

         //spliting advanced search results
         elseif($type=='advanced'){

      $first="<a href='index.php?mode=search&act=user&type=advanced";

    $form_data=array('degrees','gender','distance','zip','fname','lname','email',
    'interests','here_for','schools','occupation','company','position',
    'only_wp','sort','show','age_from','age_to');

    while (list($key,$val)=each($form_data)){
    ${$val}=form_get("$val");
    $first.="&".$val."=".urlencode(${$val});
    }//while

    $first.="&page=";

      $search=$id;
      if($search%$limit==0){
        $pages=$search/$limit;
      }//if
      else {
        $pages=(int)($search/$limit)+1;
      }//else

      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";

   }//if

   //spliting simple search results
   elseif($type=='simple'){

          $ar=array(
	"interests"    ,
	"hometown"     ,
	"schools"      ,
	"languages"    ,
	"books"        ,
	"music"        ,
	"movies"       ,
	"travel"       ,
	"clubs"        ,
	"position"     ,
	"company"      ,
	"occupation"   ,
	"specialities"
	);

    $first="<a href='index.php?mode=search&act=simple";

    foreach($ar as $val){
      ${$val}=form_get("$val");
      ${$val}=urlencode(${$val});
      $first.="&".$val."=".${$val};
    }


   $first.="&page=";

      $search=$id;
      if($search%$limit==0){
        $pages=$search/$limit;
      }//if
      else {
        $pages=(int)($search/$limit)+1;
      }//else

      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";

   }//if

   //spliting listings search result
   elseif($type=='search_lst'){

      $first="<a href='index.php?mode=search&act=listing";

      $form_data=array('keywords','RootCategory','Category','degree','distance','zip');
      while (list($key,$val)=each($form_data)){
      ${$val}=form_get("$val");
      $first.="&".$val."=".urlencode(${$val});
      }//while

   $first.="&page=";

      $search=$id;
      if($search%$limit==0){
        $pages=$search/$limit;
      }//if
      else {
        $pages=(int)($search/$limit)+1;
      }//else

      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";

   }//if

   //spliting tribes search result
   elseif($type=='search_trb'){

      $first="<a href='index.php?mode=search&act=tribe";

      $keywords=form_get("keywords");
      $first.="&keywords=".urlencode($keywords);

   $first.="&page=";

      $search=$id;
      if($search%$limit==0){
        $pages=$search/$limit;
      }//if
      else {
        $pages=(int)($search/$limit)+1;
      }//else

      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";

   }//if

      //spliting users admin view list
   if($type=='ad_users'){
   $sql_query="select mem_id from members";
   $num=sql_execute($sql_query,'num');
      $users=$num;
      if($users!='0'){
      if($users%$limit==0){
        $pages=$users/$limit;
      }//if
      else {
        $pages=(int)($users/$limit)+1;
      }//else

      $first="<a href='admin.php?mode=users_manager&adsess=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if
      //spliting users admin view list
   if($type=='banner_list'){
   $sql_query="select b_id from banners";
   $num=sql_execute($sql_query,'num');
      $users=$num;
      if($users!='0'){
      if($users%$limit==0){
        $pages=$users/$limit;
      }//if
      else {
        $pages=(int)($users/$limit)+1;
      }//else

      $first="<a href='admin.php?mode=banner_manager&adsess=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

         //spliting listings admin view list
   if($type=='ad_listings'){
   $sql_query="select lst_id from listings";
   $num=sql_execute($sql_query,'num');
      $listings=$num;
      if($listings!='0'){
      if($listings%$limit==0){
        $pages=$listings/$limit;
      }//if
      else {
        $pages=(int)($listings/$limit)+1;
      }//else

      $first="<a href='admin.php?mode=listings_manager&adsess=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

}//function

//delete item from array
function array_unset($ar,$el){
 for($i=0;$i<count($ar);$i++){
  if($ar[$i]==$el){
    unset($ar[$i]);
  }
 }
return $ar;
}

//returns category name by category id
function get_cat_name($cat_id){
 $sql_query="select name from categories where cat_id='$cat_id'";
 $cat=sql_execute($sql_query,'get');
 return $cat->name;
}

//showing when user's profile was last updated
function show_profile_updated($p_id){
 $sql_query="select updated from profiles where mem_id='$p_id'";
 $prof=sql_execute($sql_query,'get');
 $updated=date("m/d/Y",$prof->updated);
 return $updated;
}

//showing profile photo
function show_profile_photo($mem_id){
 $sql_query="select photo_b_thumb from members where mem_id='$mem_id'";
 $mem=sql_execute($sql_query,'get');
 if($mem->photo_b_thumb=='no'){
 $mem->photo_b_thumb="images/unknownUser.jpg";
 }
 echo "<a href='index.php?mode=photo_album&p_id=$mem_id'><img src='$mem->photo_b_thumb' border=0></a>";
}

//showing tribe main photo
function show_tribe_photo($trb_id){
 $sql_query="select photo_b_thumb from tribes where trb_id='$trb_id'";
 $trb=sql_execute($sql_query,'get');
 if($trb->photo_b_thumb=='no'){
 $trb->photo_b_thumb="images/unknownUser.jpg";
 }
 echo "<a href='index.php?mode=photo_album&act=tribe&trb_id=$trb_id'><img src='$trb->photo_b_thumb' border=0></a>";
}

//showing tribe main photo (small)
function show_tribe_s_photo($trb_id){
 $sql_query="select photo_thumb from tribes where trb_id='$trb_id'";
 $trb=sql_execute($sql_query,'get');
 if($trb->photo_thumb=='no'){
 $trb->photo_thumb="images/unknownUser_th.jpg";
 }
 echo "<a href='index.php?mode=tribe&act=show&trb_id=$trb_id'><img src='$trb->photo_thumb' border=0></a>";
}

//showing the link to tribe photo album
function tribe_photo_link($trb_id){
 $sql_query="select photo,updated from tribe_photo where trb_id='$trb_id'";
 $ph=sql_execute($sql_query,'get');
 $items=split("\|",$ph->photo);
 $items=if_empty($items);
 $items=array_unset($items,'no');
 if($items==''){
   $num=0;
 }
 else {
 $num=count($items);
 }
 if($num!=0){
 echo "<a href='index.php?mode=photo_album&act=tribe&trb_id=$trb_id'>$num photos in album</a>";
 }
 else {
 echo "0 photos in album";
 }
}

//showing link to viewing tribe's members
function tribe_members_link($trb_id){
$sql_query="select members from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');
$members=split("\|",$trb->members);
$members=if_empty($members);
$num=count($members);

if($num!=0){echo "<a href='index.php?mode=tribe&act=view_mems&trb_id=$trb_id'>$num Members</a>";}

}//function

//showing number of new discussion board posts since last user's visit
function tribe_new_posts($mem_id,$trb_id){
$visit=cookie_get("$trb_id");
if($visit==''){
  $visit=0;
}

$sql_query="select top_id from board where trb_id='$trb_id' and added>$visit";
$num=sql_execute($sql_query,'num');

if($num==0){
  return "no new posts";
}//if
else {
  return "$num new posts <span class='action'><a href='index.php?mode=tribe&act=show&trb_id=$trb_id'>read</a></span>";
}//else
}//function

//returns tribe's members array
function tribe_members($trb_id){
$sql_query="select members from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');
$members=split("\|",$trb->members);
$members=if_empty($members);

return $members;
}//function

//shows tribe members
function show_members($trb_id,$limit,$inline,$page){
$members=tribe_members($trb_id);

    if($members!=''){
    $start=($page-1)*$limit;
    $end=$start+$limit;
    if($end>count($members)){
      $end=count($members);
    }
    for($i=$start;$i<$end;$i++){
        $frd=$members[$i];
        if(($i==0)||($i%$inline==0))
        {
           echo "<tr>";
        }//if
	    echo "<td width=65 height=75><table class='table-photo'>";
	    echo "<tr><td align=center width=65>";
	    show_photo($frd);
        echo "</td>
        <tr><td align=center>";
        show_online($frd);
        echo "</td></table></td>";
    }//foreach
    }//if
    else {
       echo "<p align=center>No members.</p>";
    }//else

}//function

//showing topics of tribe discussion board
function show_board($trb_id){
$sql_query="select * from board where trb_id='$trb_id'";
$res=sql_execute($sql_query,'res');
echo "<tr><td>Topic</td><td>Author</td><td>Replies</td><td>Last Post</td>";
while($brd=mysql_fetch_object($res)){

$sql_query="select rep_id,added from replies where top_id='$brd->top_id' order by added desc";
$num=sql_execute($sql_query,'num');
$res2=sql_execute($sql_query,'res');
$one=mysql_fetch_object($res2);
if($one->added==''){
  $one->added=$brd->added;
}
$last_post=date("m/d/Y",$one->added);

   echo "<tr><td><a href='index.php?mode=tribe&act=board&pro=view&top_id=$brd->top_id&trb_id=$trb_id'>$brd->topic</a></td>
   <td><a href='index.php?mode=people_card&p_id=$brd->mem_id'>";
   echo name_header($brd->mem_id,'');
   echo "</a></td><td>$num</td><td>$last_post</td>";

}//while


}//function

//showing tribe events list
function show_events($trb_id){
$sql_query="select * from events where trb_id='$trb_id'";
$res=sql_execute($sql_query,'res');

while($evn=mysql_fetch_object($res)){
  $date=date("m/d/Y",$evn->start_date);
  echo "<a href='index.php?mode=tribe&act=event&pro=view&evn_id=$evn->evn_id&trb_id=$trb_id'>$evn->title</a> $date";
  $start_time=date("h:i A",$evn->start_time);
                    if($evn->start_time!='0'){
                       echo " @ $start_time ";
                    }
                    echo "</br>";
}//while

}//function

//user friends drop-down list
function drop_mem_tribes($mem_id,$sel){
$sql_query="select tribes from members where mem_id='$mem_id'";
$mem=sql_execute($sql_query,'get');
$tribes=split("\|",$mem->tribes);
$tribes=if_empty($tribes);

if($tribes!=''){
  foreach($tribes as $trb){

      $sql_query="select name from tribes where trb_id='$trb'";
      $name=sql_execute($sql_query,'get');
      if($trb==$sel){
      echo "<option selected value='$trb'>$name->name\n";
      }
      else {
      echo "<option value='$trb'>$name->name\n";
      }

  }//foreach
}//if

}//function

//returns tribe type
function tribe_type($trb_id,$mode){
$sql_query="select type from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');
if($trb->type=='pub'){
  $text="Public";
}
elseif($trb->type=='mod'){
  $text="Moderated Membership";
}
elseif($trb->type=='priv'){
  $text="Private";
}
if($mode=='output'){
  return $text;
}
elseif($mode=='get'){
  return $trb->type;
}
}//function

//showing join tribe link, if user is not a member
function join_tribe_link($mem_id,$trb_id){

$sql_query="select members from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');

$members=split("\|",$trb->members);
$members=if_empty($members);
$link="<span class='action'><a href='index.php?mode=tribe&act=join&trb_id=$trb_id'>join</a></span>";
if($members==''){
  echo $link;
}//if
else {
$flag=0;
  foreach($members as $mem){

      if($mem==$mem_id){
         $flag=1;
         break;
      }//if

  }//foreach
if($flag==0){
   echo $link;
}//if
}//else

}//function

//checking if user has an access to the tribe (member)
function tribe_access_test($mem_id,$trb_id){
  $sql_query="select stat from tribes where trb_id='$trb_id'";
  $trb=sql_execute($sql_query,'get');
  if($trb->stat=='s'){
     error_screen(29);
  }//if
  $members=tribe_members($trb_id);
  $type=tribe_type($trb_id,'get');
  $act=form_get("act");
  if($type=='priv'){
  if(!in_array($mem_id,$members)){
    error_screen(11);
  }//if
  }
  if($act!='show'){
  if(!in_array($mem_id,$members)){
    error_screen(11);
  }//if
  }//if

}//function

//returns tribe category link
function tribe_category($trb_id){
$sql_query="select t_cat_id from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');

$sql_query="select name from t_categories where t_cat_id='$trb->t_cat_id'";
$cat=sql_execute($sql_query,'get');

return "<a href='index.php?mode=tribe&act=cat&t_cat_id=$trb->t_cat_id'>$cat->name</a>";
}//function

//showing profile photo album link
function photo_album_link($mem_id){
 $sql_query="select photo,updated from photo where mem_id='$mem_id'";
 $ph=sql_execute($sql_query,'get');
 $items=split("\|",$ph->photo);
 $items=if_empty($items);
 $items=array_unset($items,"no");
 if($items==''){
   $num=0;
 }
 else {
 $num=count($items);
 }
 if($num!=0){
 echo "<a href='index.php?mode=photo_album&p_id=$mem_id'>$num photos in album</a>";
 }
 else {
 echo "0 photos in album";
 }
}

//showing member since value
function member_since($p_id){
 $sql_query="select joined from members where mem_id='$p_id'";
 $mem=sql_execute($sql_query,'get');
 $since=date("m/d/Y",$mem->joined);
 return $since;
}

//showing first name of user to another users if they are not realted
//and first with second name if they are friends
function name_header($p_id,$mem_id){
 $sql_query="select fname,lname from members where mem_id='$p_id'";
 $p=sql_execute($sql_query,'get');
 $sql_query="select frd_id from network where mem_id='$p_id' and frd_id='$mem_id'";
 $num=sql_execute($sql_query,'num');
 if(($num==0)&&($mem_id!='ad')){
  return "$p->fname";
 }
 else {
  return "$p->fname $p->lname";
 }
}

//showing different pages of profile
function show_profile($mem_id,$type){
    $sql_query="select * from profiles where mem_id='$mem_id'";
    $pro=sql_execute($sql_query,'get');
    $sql_query="select * from members where mem_id='$mem_id'";
    $mem=sql_execute($sql_query,'get');
    $sql_query="select trb_id from tribes where mem_id='$mem_id'";
    $num=sql_execute($sql_query,'num');
    $tribes=array();
    if($num==0){
       $tribes="";
    }
    else {
       $res=sql_execute($sql_query,'res');
       while($trb=mysql_fetch_object($res)){
          array_push($tribes,$trb->trb_id);
       }
    }

                    			//basic profile
                if($type=="basic"){
                      $here_for=$pro->here_for;
                      if($here_for!=''){
                        $here_for="<a href='index.php?mode=search&act=simple&interests=".$here_for."'>".$here_for."</a>";
                      }
                      if($mem->showgender=="0"){
                        $gender="";
                      }
                      elseif($mem->gender=="m"){
                        $gender="Male";
                      }
                      elseif($mem->gender=="f"){
                        $gender="Female";
                      }
                      else{
                        $gender="";
                      }
                      if($mem->showloc=="0"){
                        $location="";
                      }
                      else {

                        if($mem->country!='United States'){
                        $location=$mem->country;
                        }
                        else {
                           $sql_query="select city,state from zipData where zipcode='$mem->zip'";
                           $num=sql_execute($sql_query,'num');
                           if($num==0){
                                $location=$mem->country;
                           }
                           else {
                           $loc=sql_execute($sql_query,'get');
                              $city=strtolower($loc->city);
                              $city=ucfirst($city);
                              $location=$city.", ".$loc->state;
                           }

                        }

                      }
                      $interests=$pro->interests;
                      if($interests!=''){
                        $split=split(",",$interests);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&interests=".$word."'>".$word."</a>,";
                        }
                        $interests=rtrim($interest,',');
                      }
                      $hometown=$pro->hometown;
                      if($hometown!=''){
                        $hometown="<a href='index.php?mode=search&act=simple&hometown=".$hometown."'>".$hometown."</a>";
                      }
                      $schools=$pro->schools;
                      if($schools!=''){
                        $split=split(",",$schools);
                        $school='';
                        foreach($split as $word){
                        $school.="<a href='index.php?mode=search&act=simple&schools=".$word."'>".$word."</a>,";
                        }
                        $schools=rtrim($school,',');
                      }
                      if($mem->showage=="0"){
                        $age='';
                      }
                      else {
                         $now=time();
                         $was=$mem->birthday;
                         $dif=$now-$was;
                         $age=date("Y",$dif)-1970;
                      }
                      $description=array("Here For"=>$here_for,"Gender"=>$gender,"Age"=>$age,"Location"=>$location,"Interests"=>$interests,"Hometown"=>$hometown,"Schools"=>$schools);
                      while(list($key,$val)=each($description)){

                           if($val!=''){

                                 echo "<tr><td>$key</td><td>$val</td>";

                           }//if

                      }//while
                      if($groups!=''){
                        echo "<tr><td>Network Groups</td><td>";
                        $i=0;
                        foreach($groups as $group){
                           $sql_query="select name from groups where trb_id='$group'";
                           $trb=sql_execute($sql_query,'get');
                           echo "<a href='index.php?mode=group&act=show&trb_id=$group'>$trb->name</a>";
                           $i++;
                           if($i!=count($groups)){
                             echo ", ";
                           }
                           }
                      }

                }//basic

                //personal
                elseif($type=="personal"){
                    $languages=$pro->$pro->languages;
                    if($languages!=''){
                        $split=split(",",$ineterests);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&languages=".$word."'>".$word."</a>,";
                        }
                        $languages=rtrim($ineterest,',');
                      }
					$website=$pro->website;
                    if($website!=''){
                      $website="<a href='".$website."'>".$website."</a>";
                    }
					$books=$pro->books;
                    if($books!=''){
                        $split=split(",",$books);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&books=".$word."'>".$word."</a>,";
                        }
                        $books=rtrim($ineterest,',');
                      }
					$music=$pro->music;
                    if($music!=''){
                        $split=split(",",$music);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&music=".$word."'>".$word."</a>,";
                        }
                        $music=rtrim($interest,',');
                      }
					$movies=$pro->movies;
                    if($movies!=''){
                        $split=split(",",$movies);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&movies=".$word."'>".$word."</a>,";
                        }
                        $movies=rtrim($interest,',');
                      }
					$travel=$pro->travel;
                    if($travel!=''){
                        $split=split(",",$travel);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&travel=".$word."'>".$word."</a>,";
                        }
                        $travel=rtrim($interest,',');
                      }
					$clubs=$pro->clubs;
                    if($clubs!=''){
                        $split=split(",",$clubs);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&clubs=".$word."'>".$word."</a>,";
                        }
                        $clubs=rtrim($interest,',');
                      }
					$about=$pro->about;
					$meet_people=$pro->meet_people;
                    if($meet_people!=''){
                        $split=split(",",$meet_people);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&interests=".$word."'>".$word."</a>,";
                        }
                        $meet_people=rtrim($interest,',');
                      }
                    $description=array(
                      	"Languages"=>$languages,
					  	"Personal Website"=>$website,
					  	"Favorite books"=>$books,
						"Favorite music"=>$music,
						"Favorite movies/tv"=>$movies,
						"I've traveled to"=>$travel,
						"Clubs"=>$clubs,
                        "About me"=>$about,
						"I want to meet people for"=>$meet_people
                    );
                   while(list($key,$val)=each($description)){

                           if($val!=''){

                                 echo "<tr><td>$key</td><td>$val</td>";

                           }//if

                   }//while

                }//personal


                //professional
                elseif($type=="professional"){
                    $position=$pro->position;
                    if($position!=''){
                          $position="<a href='index.php?mode=search&act=simple&position=".$position."'>".$position."</a>";
                    }
					$company=$pro->company;
                    if($company!=''){
                          $company="<a href='index.php?mode=search&act=simple&company=".$company."'>".$company."</a>";
                    }
					$occupation=$pro->occupation;
                    if($occupation!=''){
                          $occupation="<a href='index.php?mode=search&act=simple&occupation=".$occupation."'>".$occupation."</a>";
                    }
                    if($pro->industry!=''){
                    $sql_query="select name from industries where ind_id='$pro->industry'";
                    $ind=sql_execute($sql_query,'get');
					$industry=$ind->name;
                    }
                    else {
                      $industry='';
                    }

					$specialities=$pro->specialities;
                    if($specialities!=''){
                        $split=split(",",$specialities);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&specialities=".$word."'>".$word."</a>,";
                        }
                        $specialities=rtrim($interest,',');
                    }
					$overview=$pro->overview;
					$skills=$pro->skills;
                    if($skills!=''){
                        $split=split(",",$skills);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&skills=".$word."'>".$word."</a>,";
                        }
                        $skills=rtrim($interest,',');
                      }
					$p_positions=$pro->p_positions;
                    if($p_positions!=''){
                        $split=split(",",$p_positions);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&interests=".$word."'>".$word."</a>,";
                        }
                        $p_positions=rtrim($interest,',');
                      }
					$p_companies=$pro->p_companies;
                    if($p_companies!=''){
                        $split=split(",",$p_companies);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&interests=".$word."'>".$word."</a>,";
                        }
                        $p_companies=rtrim($interest,',');
                      }
					$assotiations=$pro->assotiations;
                    if($associations!=''){
                        $split=split(",",$assotiations);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&interests=".$word."'>".$word."</a>,";
                        }
                        $assotiations=rtrim($interest,',');
                      }

                      $description=array (
                         "Position/Title"=>$position,
					     "Company"=>$company,
					     "Occupation"=>$occupation,
					     "Industry"=>$industry,
					     "Specialties"=>$specialities,
						 "Overview"=>$overview,
					     "Skills"=>$skills,
					     "Past Positions"=>$p_positions,
					     "Past Companies"=>$p_companies,
					     "Associations"=>$assotiations
                      );

                  while(list($key,$val)=each($description)){

                           if($val!=''){

                                 echo "<tr><td>$key</td><td>$val</td>";

                           }//if

                   }//while

                }//professional
}//function

//shows testimonials on user
function show_testimonials($p_id,$m_id){
 $sql_query="select * from testimonials where mem_id='$p_id' and stat='a'";
 $num=sql_execute($sql_query,'num');
 if($num==0){
   echo "<p align=center>";echo name_header($p_id,$m_id);echo " has no testimonials.</p>";
 }
 else {
 $res=sql_execute($sql_query,'res');
 while($tst=mysql_fetch_object($res)){

    echo "<table class='body' vasilek><tr><td class=lined>";show_photo($tst->from_id);echo "</br>";
    show_online($tst->from_id);echo "</td>";
    $date=date("F d, Y",$tst->added);
    echo "<td valign=top>$date</br>$tst->testimonial</td></table>";
 }//while
 }//else
}

//when showing form with radio or checkbox elements, functions chacks if it must be checked
function checked($val,$ch){
  if($val==$ch){
   echo " checked ";
  }
}

//showing user photo album
function photo_album($mem_id,$page,$mod){
    $page=$page-1;
    $sql_query="select photo_b_thumb,capture from photo where mem_id='$mem_id'";
    $pho=sql_execute($sql_query,'get');
    $sql_query="select photo_b_thumb from members where mem_id='$mem_id'";
    $main=sql_execute($sql_query,'get');
    $photos=split("\|",$pho->photo_b_thumb);
    $photos=if_empty($photos);
    $captures=split("\|",$pho->capture);
    $captures=if_empty($captures);
    $start=$page*6;
    $end=$start+10;
    if($end>count($photos)){
       $end=count($photos);
    }//if
    if($photos!=''){
    for($i=$start;$i<$end;$i++){
		if($main->photo_b_thumb==$photos[$i])	$main_set="Main Photo";
        echo "<td><table class=lined>
        <tr><td align='center' class='body'>$main_set<br><a href='index.php?mode=photo_album&act=view&pho_id=$i&p_id=$mem_id'><img src='$photos[$i]' border=0></a></td>
        <tr><td align='center' class='body'>$captures[$i]</td>";
        if($mod=='edi'){
          echo "<tr><td align='center' class='body'><a href='index.php?mode=user&act=del&type=photos&pro=edit&pho_id=$i'>Delete</a></td>";
        }
        echo "</table></td>";
		$main_set="";

    }//for
    }//if
    else {
      echo "No photos available";
    }

}//function
//showing user photo album
function photo_album_count($mem_id,$page,$mod){
    $page=$page-1;
	$cou=0;
    $sql_query="select photo_b_thumb,capture from photo where mem_id='$mem_id'";
    $pho=sql_execute($sql_query,'get');
    $sql_query="select photo_b_thumb from members where mem_id='$mem_id'";
    $main=sql_execute($sql_query,'get');
    $photos=split("\|",$pho->photo_b_thumb);
    $photos=if_empty($photos);
    $captures=split("\|",$pho->capture);
    $captures=if_empty($captures);
    $start=$page*6;
    $end=$start+10;
    if($end>count($photos)){
       $end=count($photos);
    }//if
    if($photos!=''){
    for($i=$start;$i<$end;$i++){
		$cou++;
    }//for
    }//if
	return $cou;
}//function
//Deleteing user photo album
function del_album($mem_id,$page,$mod,$cid){
	global $base_path,$main_url;
    $sql_query="select photo,photo_b_thumb,photo_thumb,capture from photo where mem_id='$mem_id'";
    $pho=sql_execute($sql_query,'get');
    $sql_query="select photo_b_thumb from members where mem_id='$mem_id'";
    $main=sql_execute($sql_query,'get');
    $photo_b_thumb=split("\|",$pho->photo_b_thumb);
	$photo=split("\|",$pho->photo);
	$photo_thumb=split("\|",$pho->photo_thumb);
	$pho_cou=count($photo);
    $photo_b_thumb=if_empty($photo_b_thumb);
	$photo=if_empty($photo);
	$photo_thumb=if_empty($photo_thumb);
    $capture=split("\|",$pho->capture);
    $capture=if_empty($capture);
    if($pho_cou!=0){
		sql_execute($sql_query,'');
	    for($i=0;$i<$pho_cou;$i++){
		if($i!=$cid) {
			$photo_up.="|".$photo[$i];
			$photo_b_thumb_up.="|".$photo_b_thumb[$i];
			$photo_thumb_up.="|".$photo_thumb[$i];
			$capture_up.="|".$capture[$i];
		}	else	{
			if(file_exists("$base_path/$photos[$i]")){
				@unlink("$base_path/$photos[$i]");
			}
		}
		if($i!=$cid) {
		   if($main->photo_b_thumb==$photos[$i])	{
			   $sql_query="update members set photo='',photo_thumb='',photo_b_thumb='' where mem_id='$m_id'";
			   sql_execute($sql_query,'');
			}
		}
    }//for
	$sql_query="update photo set photo='".$photo_up."',photo_b_thumb='".$photo_b_thumb_up."',
	photo_thumb='".$photo_thumb_up."',capture='".$capture_up."' where mem_id='$mem_id'";
//	echo $sql_query;
	sql_execute($sql_query,'');
    }//if
}//function
//showing tribe photo album
function tribe_photo_album($trb_id,$page){
    $page=$page-1;
    $sql_query="select photo_b_thumb,capture from tribe_photo where trb_id='$trb_id'";
    $pho=sql_execute($sql_query,'get');
    $sql_query="select photo_b_thumb from tribes where trb_id='$trb_id'";
    $main=sql_execute($sql_query,'get');
    $photos=split("\|",$pho->photo_b_thumb);
    $photos=if_empty($photos);
    $photos=array_unset($photos,"no");
    $captures=split("\|",$pho->capture);
    $captures=if_empty($captures);
    $start=$page*6;
    $end=$start+10;
    if($end>count($photos)){
       $end=count($photos);
    }//if
    if($photos!=''){
    for($i=$start;$i<$end;$i++){
        echo "<td><table class=lined>
        <tr><td><a href='index.php?mode=photo_album&act=trb_view&pho_id=$i&trb_id=$trb_id'><img src='$photos[$i]' border=0></a></td>
        <tr><td align=center>$captures[$i]</td>
        </table></td>";
    }//for
    }//if
    else {
      echo "No photos available.";
    }

}//function

//drop-down list of user friends
function drop_friends($mem_id){
   $fr=count_network($mem_id,"1","ar");
   echo "<option value=''>-- Select a friend --";
   if($fr!=''){
   foreach($fr as $frd){
      $sql_query="select fname from members where mem_id='$frd'";
      $f=sql_execute($sql_query,'get');
      echo "<option value='$frd'>$f->fname";
   }//foreach
   }//if

}//function

//drop-down list of tribe categories
function drop_t_cats($sel){
$sql_query="select name,t_cat_id from t_categories";
$res=sql_execute($sql_query,'res');
while($cat=mysql_fetch_object($res)){
   if($cat->t_cat_id=="$sel"){
   echo "<option selected value='$cat->t_cat_id'>$cat->name";
   }//if
   else {
   echo "<option value='$cat->t_cat_id'>$cat->name";
   }//else
}//while
}//function

//drop-down list of industries
function industry_drop($sel){
$sql_query="select * from industries";
$res=sql_execute($sql_query,'res');
while($ind=mysql_fetch_object($res)){
   echo "<option";
   if($ind->ind_id=="$sel"){
     echo " selected";
   }
   echo " value='$ind->ind_id'>";
   if(!ereg("_",$ind->name)){ echo "&nbsp;&nbsp;"; }
   echo "$ind->name</option>";
}//while


}//function

function show_friends_deg($m_id,$limit,$inline,$page,$deg){

    $friends=count_network($m_id,"$deg","ar");
    $friends=if_empty($friends);
    if($friends!=''){
    $start=($page-1)*$limit;
    $end=$start+$limit;
    if($end>count($friends)){
      $end=count($friends);
    }
    for($i=$start;$i<$end;$i++){
        $frd=$friends[$i];
        if(($i==0)||($i%$inline==0))
        {
           echo "<tr>";
        }//if
	    echo "<td width=65 height=75><table class='table-photo'>";
	    echo "<tr><td align=center width=65>";
	    show_photo($frd);
        echo "</td>
        <tr><td align=center>";
        show_online($frd);
        echo "</td></table></td>";
    }//foreach
    }//if
    else {
       echo "<p align=center>No friends.</p>";
    }//else

}//function
function delete_banner($id) {
	$sql_query="update banners set b_exp='Y' where b_id='$id'";
	sql_execute($sql_query,'');
}//function

function maketime ($hour,$minute,$second,$month,$date,$year){

       // This function can undo the Win32 error to calculate datas before 1-1-1970 (by TOTH = igtoth@netsite.com.br)
       // For centuries, the Egyptians used a (12 * 30 + 5)-day calendar
       // The Greek began using leap-years in around 400 BC
       // Ceasar adjusted the Roman calendar to start with Januari rather than March
       // All knowledge was passed on by the Arabians, who showed an error in leaping
       // In 1232 Sacrobosco (Eng.) calculated the error at 1 day per 288 years
       //    In 1582, Pope Gregory XIII removed 10 days (Oct 15-24) to partially undo the
       // error, and he instituted the 400-year-exception in the 100-year-exception, 
       // (notice 400 rather than 288 years) to undo the rest of the error
       // From about 2044, spring will again coincide with the tropic of Cancer
       // Around 4100, the calendar will need some adjusting again
   
       if ($hour === false)  $hour  = Date ("G");
       if ($minute === false) $minute = Date ("i");
       if ($second === false) $second = Date ("s");
       if ($month === false)  $month  = Date ("n");
       if ($date === false)  $date  = Date ("j");
       if ($year === false)  $year  = Date ("Y");
   
       if ($year >= 1970) return mktime ($hour, $minute, $second, $month, $date, $year);
   
       //    date before 1-1-1970 (Win32 Fix)
       $m_days = Array (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
       if ($year % 4 == 0 && ($year % 100 > 0 || $year % 400 == 0))
       {
           $m_days[1] = 29; // non leap-years can be: 1700, 1800, 1900, 2100, etc.
       }
   
       //    go backward (-), based on $year
       $d_year = 1970 - $year;
       $days = 0 - $d_year * 365;
       $days -= floor ($d_year / 4);          // compensate for leap-years
       $days += floor (($d_year - 70) / 100);  // compensate for non-leap-years
       $days -= floor (($d_year - 370) / 400); // compensate again for giant leap-years
           
       //    go forward (+), based on $month and $date
       for ($i = 1; $i < $month; $i++)
       {
           $days += $m_days [$i - 1];
       }
       $days += $date - 1;
   
       //    go forward (+) based on $hour, $minute and $second
       $stamp = $days * 86400;
       $stamp += $hour * 3600;
       $stamp += $minute * 60;
       $stamp += $second;
   
       return $stamp;
}
?>