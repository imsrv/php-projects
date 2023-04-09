<?
/***************************************************************************
 *                         AutoHits  PRO
 *                      -------------------
 *   Version          	 : 1.0
 *   Released        	 : 02.20.2003
 *   copyright           : (C) 2003 SupaTools.com
 *   email               : info@supatools.com
 *   website             : www.supatools.com
 *   custom work	 : http://www.gofreelancers.com
 *   support             : http://support.supatools.com
 *
 ***************************************************************************/
require('error_inc.php');
require('config_inc.php');
require('admin/timer.inc.php');
//require('admin/surf_module.inc.php');
$id=intval($id);
	$query = "select br, name, id from ".$t_user." where id=".$id;      
	$result = MYSQL_QUERY($query);
	$br=mysql_result($result,0,"br");
	$user_id=mysql_result($result,0,"id");
	$user_name=mysql_result($result,0,"name");
?>
<html>
<head>
<title>Navigation system</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
..tab_brd {  border: 0px #000000 solid}
..timer {  background-color: #006699; font-weight: normal; color: #FFFFFF; border: 0px none; font-size: 12px; font-family: "Verdana"}
-->
</style>
<script language="JavaScript">
    maximize=<?print $br;?>;	//maximize after loading;
    Top=<?print $br;?>;		//always on top vaiable;
<?	if(is_numeric($delay_t)){?>
    delay=<?=$delay_t?>;			//time variable sec;
<?}else{?>
		delay=3;			//time variable sec;
<?}?>
    begin="no";
    t2=delay;
    Stop="no";
    autoplay=<?=$autoplay_t;?>;
//function start() {
//  begin="yes";
//  if (Stop=="yes") {
//    Stop="no";
//    play();
//    // timer();
//  }
//}
function initialize() {
//		alert("initialize()");
    parent.autohit();
//    alert("initialize2");
    Stop="no";       
//    alert("initialize3");
    begin="no";     
//    alert("initialize4");
    t2=delay;
//    alert("initialize5");
//    timer();         
//    alert("initialize6");
    if(delay>=10) { document.form1.timer.value=""+delay; }
    else { document.form1.timer.value="0"+delay; }       
		
//    alert("initialize7");
    document.form1.score.value=0;
//    alert("initialize8");
//    document.form1.timeout.value = delay;
//    alert("initialize9");
}
function play() {
//	alert("play");
	Stop="no";
  if (t2==0) { initialize(); }
//	t2=t2+1;
//  timer();
/*  if (Stop=="no"){
    if(Top==1) this.focus();
    if(maximize==0) parent.maxWindow();
    newSite();
//	score=parseInt((score+koef[1])*10);
//	score=(score)/10;
//	document.form1.score.value=parent.score;
    t2=delay;
    timer();
  }
*/
}
function timer() {
  if (Stop=="no"){
    if (t2>=10) document.form1.timer.value="";
    else {
//	    this.focus();
      document.form1.timer.value="0";
    }
	  document.form1.timer.value+=""+t2;
	  if(t2>0) {
	    t2--;
	  }
	  else {
    	if (autoplay==0) pause();
      else initialize();
    }
  }
  setTimeout('timer()',1000);
}
function SetDelay(){
	delay = document.form1.timeout.value;
  if (Stop=="yes"){
   if (delay>=10) document.form1.timer.value="";
   else {
     document.form1.timer.value="0";
   }
   document.form1.timer.value+=""+delay;
  }
}
function pause() {
	Stop="yes";
/*  if(begin=="yes") {
	  if (Stop=="no") Stop="yes";
    else {
	    Stop="no";
	    timer();
	  }
  }
*/
}
function newSite() {
parent.mainFrame.location.href="autohit.php?id=<?print $id?>&id1="+parent.ida[1]+"&id2="+parent.ida[2];
}
function createWnd(){
	newwnd=window.open(parent.url[1],"hehe","toolbar,scrollbars=1,statusbar,titlebar,menubar,height=300,width=500");
}
function abuse() {
	newwnd=window.open("abuse.php?id="+parent.ida[1]+"&url="+parent.url[1]+"&idu=<?print $id?>", "haha","toolbar,resizable,scrollbars=1,statusbar,titlebar,menubar,height=600,width=800");
}
function init1() {
	initialize();
  alert("init1: initdone");
  play();
  alert("init1: playdone");
}
</script>
</head>
<body bgcolor="#006699" text="#FFFFFF" leftmargin="0" topmargin="3" onLoad="initialize(); timer();" >
<div align=left><table width="700" border="0" cellspacing="0" cellpadding="0"  class="tab_brd" align=left><tr>
  <td width="60"><img src="images/spacer.gif" width="5" height="60"></td>
  <td width="70"> <table width="70" border="0" cellspacing="0" cellpadding="0"  height="36" class="tab_brd" align="left">
      <tr> 
        <td align="center" ><a href="javascript:play();"><img src="images/play.gif" border="0" alt="Play"></a></td>
        <td align="center" ><a href="javascript:pause();"><img src="images/pause.gif" border="0" alt="Pause"></a></td>
        <td align="center" ><a href="javascript: createWnd();"><img src="images/open.gif" border="0" alt="Open  curent site in the new window"></a></td>
        <td align="center" ><a href="user_menu.php?PHPSESSID=<?print $PHPSESSID;?>" target=_top><img src="images/menu.gif" border="0" alt="User menu"></a></td>
      </tr>
      <tr> 
        <td align="center" colspan="4" ><a href="javascript: abuse();"><img src="images/abuse.gif" border="0"></a></td>
      </tr>
    </table></td>
  <td width=350> <form name="form1" method="post" action="">
      <table border="0" cellspacing="0" cellpadding="2" align="left"  class="tab_brd">
        <tr> 
          <td valign="middle"><font face="Arial, Helvetica, sans-serif" size="2"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
            &nbsp;Next Site in:
          <input type="text" name="timer" size="3" class="timer" > sec.</b></font></td>
        </tr></tr>
        <tr> 
          <td valign="middle"><font face="Arial, Helvetica, sans-serif" size="2"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
            &nbsp;Credits This Session:</font></b>
         <input type="text" name="score" size="6" class="timer" > </font></td>
    
        </tr>
      </table>
    </form></td>
  <td width=300 valign=top> 
    <!-- this is he user info section -->
    <font color=white size=1 face=tahoma><b>USER ID#</b> <? print $user_id; ?> &nbsp; 
    &nbsp; (<? print $user_name; ?>)</font> 
    <!-- user info section ends here end -->
  </td>
  </tr>
</table>
</html>
