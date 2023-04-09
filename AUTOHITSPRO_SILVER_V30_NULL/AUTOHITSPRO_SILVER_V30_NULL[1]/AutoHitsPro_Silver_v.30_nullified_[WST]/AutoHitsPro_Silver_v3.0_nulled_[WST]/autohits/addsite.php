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
unset($login,$pwrd,$id);
session_start();
session_register("login","pwrd","id");

if($logout==1){
	session_destroy();
	header("Location: ".$PHP_SELF);
}

require('error_inc.php');
require('config_inc.php');

function auth($log,$pass){
	global $t_user;
	$query = "select id from ".$t_user." where email=\"".$log."\" and pass=\"".$pass."\" ";      
	$result = MYSQL_QUERY($query);
	if(mysql_num_rows($result)>0){
		$id=mysql_result($result,0,"id");
		@mysql_free_result($result);  
		return $id;
	}else{
		@mysql_free_result($result); 
		return 0;
	}
}

if(auth($login,$pwrd)!=0){

if($REQUEST_METHOD=="POST"){
	if(isset($add)){
?>
<HTML><HEAD><TITLE></TITLE></HEAD><FRAMESET Rows='30,*' BORDER='0'><FRAME MARGINHEIGHT='0' MARGINWIDTH='0' SRC='addsiteframe.php?site=<?print $site;?>&language=<?print $language;?>&sel[1]=<?print $sel[1];?>&sel[2]=<?print $sel[2];?>&sel[3]=<?print $sel[3];?>&url=<?print $url;?>' SCROLLING='No' NORESIZE NAME='top' BORDER='0'><FRAME MARGINHEIGHT='0' MARGINWIDTH='0' SRC='<?print $url;?>' SCROLLING='AUTO' NORESIZE NAME='main' BORDER='0'></FRAMESET></HTML>
<?      
	exit;
	}
}
$query = "select * from ".$t_language." order by language";      
$result = MYSQL_QUERY($query);
$query1 = "select * from ".$t_cat." order by id";      
$result1 = MYSQL_QUERY($query1);

require('header_inc.php');
?>
<SCRIPT language=javascript1.2 type=text/javascript>
function EvaluateField()
{
	var SiteName		= document.NewUser.site.value;
	var SiteURL		= document.NewUser.url.value;
	var SiteLanguage	= document.NewUser.language.selectedIndex;

	if(SiteLanguage==0 ){
		alert('You need to set your primary site language.');
		document.NewUser.language.focus();
		return false;
	}

	if(SiteName == "")
	{
		alert("The field \"Your site name\" must be filled.");
		document.NewUser.site.focus();
		return false;
	}

	if(SiteURL == "")
	{
		alert("The field \"Your site URL\" must be filled.");
		document.NewUser.url.focus();
		return false;
	}

	if(SiteURL == "http://")
	{
		alert("The field \"Your site URL\" must be filled.");
		document.NewUser.url.focus();
		return false;
	}


	alert('We will now open your site to check that your URL is correct. Please follow the information on top of the next screen.')

	return true;

}
</SCRIPT>
<?
require('menu.php');
?>
<FORM name=NewUser action="" method=post>
<table width="100%" border="0" cellspacing="5" cellpadding="5" align="center">
  <tr> 
     <td align="justify">
Please fill out the fields, read our terms and conditions and accept the terms and conditions. 
    </td>
  </tr>
</table>
<table width="500" border="0" cellspacing="2" cellpadding="0" align="center">
  <tr> 
     <td width="200" align="left">Your site name:</td>
     <td align="left" width="450"> 
       <input type="text" name="site" size="30">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Your site URL:</td>
     <td align="left" width="450"> 
       <input type="text" name="url" value="http://" size="30">
    </td>
  </tr>
    <tr> 
      <td width="200" align="right" class="text" valign="top">Your website Category:</td>
      <td align="left" class="text" width="450"> 
<?
$i=0;
while($row = mysql_fetch_array($result1)){
	$ch["id"][$i]=$row["id"];
	$ch["title"][$i]=$row["title"];
	$i++;
}?>
  <select name="sel[1]">
<?
$siz=$i;
for($i=0;$i<$siz;$i++){
?>
    <option value="<?
	print $ch["id"][$i];
?>
">
<?
	print $ch["title"][$i];
?>
</option>
<?
}
?>
  </select>
  <select name="sel[2]">
<?
for($i=0;$i<$siz;$i++){
?>
    <option value="<?
	print $ch["id"][$i];
?>
">
<?
	print $ch["title"][$i];
?>
</option>
<?
}
?>
  </select>
  <select name="sel[3]">
<?
for($i=0;$i<$siz;$i++){
?>
    <option value="<?
	print $ch["id"][$i];
?>
">
<?
	print $ch["title"][$i];
?>
</option>
<?
}
?>
  </select>
      </td>
    </tr>
  <tr> 
     <td width="200" align="left">Your site language:</td>
     <td align="left" width="450"> 
	<SELECT name=language><OPTION value=0 selected>Please 
              select</OPTION>
<?
while($row = mysql_fetch_array($result)){
?>
<OPTION value="<?print $row["id"];?>"><?print $row["language"];?></OPTION>
<?
}
@mysql_free_result($result);
?>
</SELECT>
    </td>
  </tr>
  <tr> 
     <td width="200" align="left"> </td>
     <td align="left" width="450"> 
<INPUT onclick="return EvaluateField();" type=submit name="add" value="Submit"> 
    </td>
  </tr>
</table>
</form>
<?
}else{
	header("Location: login.php");
}
require('footer_inc.php');
?>
