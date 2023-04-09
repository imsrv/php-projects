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

$ref=intval($ref);

if($REQUEST_METHOD=="POST"){
	if(isset($add)){
?>
<HTML><HEAD><TITLE></TITLE></HEAD><FRAMESET Rows='30,*' BORDER='0'><FRAME MARGINHEIGHT='0' MARGINWIDTH='0' SRC='addframe.php?name=<?print $name;?>&email=<?print $email;?>&share=<?print $share;?>&site=<?print $site;?>&language=<?print $language;?>&ref=<?print $ref;?>&sel[1]=<?print $sel[1];?>&sel[2]=<?print $sel[2];?>&sel[3]=<?print $sel[3];?>&sel1[1]=<?print $sel1[1];?>&sel1[2]=<?print $sel1[2];?>&sel1[3]=<?print $sel1[3];?>&pass=<?print $pass;?>&url=<?print $url;?>' SCROLLING='No' NORESIZE NAME='top' BORDER='0'><FRAME MARGINHEIGHT='0' MARGINWIDTH='0' SRC='<?print $url;?>' SCROLLING='AUTO' NORESIZE NAME='main' BORDER='0'></FRAMESET><noframes></noframes></HTML>
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
function isEmail(str) {
  var supported = 0;
  if (window.RegExp) {
    var tempStr = "a";
    var tempReg = new RegExp(tempStr);
    if (tempReg.test(tempStr)) supported = 1;
  }
  if (!supported) 
    return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
  var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
  var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$");
  return (!r1.test(str) && r2.test(str));
}


function EvaluateField()
{
	var userName		= document.NewUser.name.value;
	var userEmail		= document.NewUser.email.value;
	var userEmail2		= document.NewUser.email1.value;
	var SiteName		= document.NewUser.site.value;
	var SiteURL		= document.NewUser.url.value;
	var SiteLanguage	= document.NewUser.language.selectedIndex;

	if(SiteLanguage==0 ){
		alert('You need to set your primary site language.');
		document.NewUser.language.focus();
		return false;
	}

	if(userName == "")
	{
		alert("The field \"Your name\" must be filled.");
		document.NewUser.name.focus();
		return false;
	}


	if(userEmail == "")
	{
		alert("The field \"Your E-mail address\" must be filled.");
		document.NewUser.email.focus();
		return false;
	}
	else
	{
		if(isEmail(userEmail) == false)
		{
			alert(userEmail + " can not be used as an email address.");
			document.NewUser.email.focus();
			return false;
		}
	}

	if(userEmail != userEmail2)
	{
		alert("The fields \"Your E-mail address\" and \"Confirm your E-mail address\" must be identically.");
		document.NewUser.email.focus();
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
<!-- Begin of table-->
        <table border="0" cellpadding="5" cellspacing="5" width="100%">
          <tr>
                
            <td>
<p> 
Please fill out the fields, read our terms and conditions and accept the terms and conditions. 
</p>
<FORM name=NewUser action="" method=post>
<table width="" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
     <td width="400" align="left">Your Name:</td>
     <td align="left" width="450"> 
       <input type="text" name="name" size="30">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Your E-mail address:</td>
     <td align="left" width="450"> 
       <input type="text" name="email" size="30">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Confirm your E-mail address:</td>
     <td align="left" width="450"> 
       <input type="text" name="email1" size="30">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Share email:</td>
     <td align="left" width="450"> 
	<SELECT name="share"><OPTION value=0 selected>No, Keep my 
              email private</OPTION><OPTION value=1>Yes, share it to my up and 
              down line</OPTION></SELECT>
    </td>
  </tr>
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
      <td width="200" align="left" class="text" valign="top">Your website Category:</td>
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
      <td width="200" align="left" class="text" valign="top">User Category:</td>
      <td align="left" class="text" width="450"> 
  <select name="sel1[1]">
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
  <select name="sel1[2]">
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
  <select name="sel1[3]">
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
     <td align="left" width="450" colspan=2> 
<br>
<!--begin Terms-->
<b>Terms and Conditions </b>
<br>- Your site(s) does not contain any message boxes
<br>- Your site(s) does not contain inappropriate contents
<br>- Your site(s) does not break out of frames
<br>- Your site(s) does not use site rotation
<br>- Your site(s) does not use URL or domain forwarding
<br>- Your account will be deleted if not used for 90 days
<br>- Your account will be deleted if we can not send youemails
<br>- Your account can be disable if it causes system any problems
<br>- You are not allowed to have more than one (1) account <br>- Your site(s) does not contain any popup windows
<!--end Terms-->
    </td>
  </tr>
  <tr> 
     <td align="center" width="450" colspan=2> 
<br>
<INPUT onclick="return EvaluateField();" type=submit name="add" value="Accept Terms and Conditions"> 
    </td>
  </tr>
</table>
<!-- End of table-->
</form>
</td></tr></table>
<?
require('footer_inc.php');
?>
