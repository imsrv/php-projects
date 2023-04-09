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
	$flag=true;
	if($REQUEST_METHOD=="POST"){
		if(isset($sub)){
			$query = "select * from ".$t_tmp_mail." where idu=".$id." and cod=".$cod;      
			$result = MYSQL_QUERY($query);
			if(@mysql_num_rows($result)==0){
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
	var userEmail		= document.NewUser.email.value;
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
	return true;
}
</SCRIPT>
<FORM name=NewUser action="" method=post>
<table width="500" border="0" cellspacing="2" cellpadding="0" align="center">
  <tr> 
     <td  align="left"><b><font color=red>Code is wrong please try again</font>
<br>Edit E-mail address:</b></td>
  </tr>
  <tr> 
     <td align="left" > 
       <input type="text" name="email" size="30" value="">
    </td>
  </tr>
  <tr> 
     <td align="justify">
When you apply for e-mail change, we will send you a Change code to enable your new e-mail address.

<br>PLEASE NOTE THAT your e-mail address will NOT be changed until you have entered the change code.<br> 
<br><INPUT onclick="return EvaluateField();" type=submit name="edit" value="Submit"> 
    </td>
  </tr>
  <tr> 
     <td width="400" align="left"> </td>
     <td align="right" width="450"><a href="javascript:history.back();"><font color=blue>[back]</font></a></td>
  </tr>
</table>
</form>
<?
				$query = "delete from ".$t_tmp_mail."  where idu=".$id;      
				$result = MYSQL_QUERY($query);
				require('footer_inc.php');
				exit;
			}
			$em=mysql_result($result,0,"email");
			@mysql_free_result($result);
			
			$query = "update ".$t_user." set email=\"".$em."\" where id=".$id;      
			$result = MYSQL_QUERY($query);
			$query = "delete from ".$t_tmp_mail."  where idu=".$id;      
			$result = MYSQL_QUERY($query);
			$login=$em;
			header("Location: user_menu.php?PHPSESSID=".$PHPSESSID);
		}

		if(isset($edit)){
			if($email==""){
				$er[]=$err[3]."'email'";
				$flag=false;
			}
			$query = "select * from ".$t_user." where email=\"".$email."\"";      
			$result = MYSQL_QUERY($query);
			if(mysql_num_rows($result)!=0){
				$er[]=$err[7];
				$flag=false;
			}
			@mysql_free_result($result);
			if($flag==true){
				mt_srand((double)microtime()*1000000);
				$cod=mt_rand(0,10000);
				$query = "insert into ".$t_tmp_mail." set email=\"".$email."\" , idu=".$id.", cod=".$cod;      
				$result = MYSQL_QUERY($query);
				@mail($email,$subject[6],$body[3].$cod,"From: $support_email");
				require('header_inc.php');
?>
<FORM name=NewUser action="" method=post>
<table width="500" border="0" cellspacing="2" cellpadding="0" align="center">
  <tr> 
     <td width="200" align="left"><b>Enter code:</b></td>
     <td align="left" width="450"> </td>
  </tr>
  <tr> 
     <td width="200" align="right">Code:</td>
     <td align="left" width="450"> 
       <input type="text" name="cod" size="30">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left"> </td>
     <td align="left" width="450">
The Change code will be send to <?print $email;?>      
<br>The code MUST be entered before the email address will be changed in the database!<br>
<br><INPUT type=submit name="sub" value="Submit"> 
    </td>
  </tr>
</table>
</form>
<?
				require('footer_inc.php');
				exit;
			}
		}
	}
	$query = "select * from ".$t_tmp_mail." where idu=\"".$id."\"";      
	$result = MYSQL_QUERY($query);
	if(mysql_num_rows($result)!=0){
		$em=mysql_result($result,0,"email");
		require('header_inc.php');
		?>
<FORM name=NewUser action="" method=post>
<table width="500" border="0" cellspacing="2" cellpadding="0" align="center">
  <tr> 
     <td width="200" align="left"><b>Enter code:</b></td>
     <td align="left" width="450"> </td>
  </tr>
  <tr> 
     <td width="200" align="right">Code:</td>
     <td align="left" width="450"> 
       <input type="text" name="code" size="30">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left"> </td>
     <td align="left" width="450">
The Change code will be send to <?print $em;?>
<br>The code MUST be entered before the email address will be changed in the database!<br>
<INPUT type=submit name="sub" value="Submit"> 
    </td>
  </tr>
</table>
</form>
<?
		require('footer_inc.php');
		exit;
	}
	@mysql_free_result($result);


	$query = "select * from ".$t_user." where id=".$id." ";      
	$result = MYSQL_QUERY($query);
	$email=mysql_result($result,0,"email");
	@mysql_free_result($result);
	require('header_inc.php');
	require('menu.php');
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
	var userEmail		= document.NewUser.email.value;
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
	return true;
}
</SCRIPT>
<FORM name=NewUser action="" method=post>
<table width="500" border="0" cellspacing="5" cellpadding="5" align="center">
  <tr> 
     <td width="200" align="left"><b>
<?
	if($flag==false){
		$str=join("<br>",$er);
		print "<font color=red>".$str."</font><br>";
	}
?>
Edit E-mail address:</b></td>
  </tr>
  <tr> 
     <td width="200" align="left">
       <input type="text" name="email" size="30" value="<?print $email;?>">
    </td>
  </tr>
  <tr> 
     <td align="justify" width="450">
When you apply for e-mail change, we will send you a Change code to enable your new e-mail address.

<br>PLEASE NOTE THAT your e-mail address will NOT be changed until you have entered the change code.<br><br> 
<INPUT onclick="return EvaluateField();" type=submit name="edit" value="Submit"> 
    </td>
  </tr>
  <tr> 
     <td align="right" width="450"><a href="javascript:history.back();"><font color=blue>[back]</font></a></td>
  </tr>
</table>
</form>
<?
}else{
	header("Location: login.php");
}
require('footer_inc.php');
?>
