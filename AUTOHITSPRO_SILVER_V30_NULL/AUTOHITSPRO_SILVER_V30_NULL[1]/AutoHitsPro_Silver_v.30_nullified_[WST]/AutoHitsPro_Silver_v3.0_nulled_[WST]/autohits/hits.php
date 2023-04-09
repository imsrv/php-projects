<?
/***************************************************************************
 *                         AutoHits  PRO                            *
 *                            -------------------
 *    Version          : 2.1                                                  *
 *   Released        : 04.22.2003                                     *
 *   copyright            : (C) 2003 SupaTools.com                           *
 *   email                : info@supatools.com                             *
 *   website              : www.supatools.com                 *
 *   custom work     :http://www.gofreelancers.com      *
 *   support             :http://support.supatools.com        *
 *                                                                         *
 *                                                                         *
 *                                                                         *
 ***************************************************************************/
require('error_inc.php');
require('config_inc.php');

$id=intval($id);       

$query = "select type,br from ".$t_user." where id=".$id;      
$result = MYSQL_QUERY($query);
$type=mysql_result($result,0,"type");
$br=mysql_result($result,0,"br");

if($type==0){
	if($br==0){
		$cr=$basic_min;
	}elseif($br==1){
		$cr=$basic_max;
	}
}elseif($type==1){
	if($br==0){
		$cr=$silver_min;
	}elseif($br==1){
		$cr=$silver_max;
	}
}elseif($type==2){
	if($br==0){
		$cr=$gold_min;
	}elseif($br==1){
		$cr=$gold_max;
	}
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="Javascript">

score=new Array();
score=0;
url=new Array();
url[1]="";
ida=new Array();
ida[1]=0;
ida[2]=0;

function maxWindow(){
if (document.all) {
intwidth=window.screen.availWidth;
intheight=window.screen.availHeight;
}else {
intwidth=800;
intheight=600;
}
window.moveTo(0,0);
window.resizeTo(intwidth,intheight);
}
function autohit(){
	parent.mainFrame.location.href="autohit.php?id=<?print $id;?>";
}
</script>
</head>
<frameset rows="70,*" frameborder="NO" border="0" framespacing="0" cols="*" > 
  <frame name="topFrame" scrolling="NO" noresize src="nav.php?id=<?print $id;?>" frameborder="NO" >
  <frame name="mainFrame" src="proc.php" scrolling="YES">
</frameset>                          
<noframes> 
<body  bgcolor="#FFFFFF" text="#000000">
</body>
</noframes> 
</html>

