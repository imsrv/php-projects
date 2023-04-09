<?
	include("include/common.php");

	if( $_POST['username'] && $_POST['password'] ){
		$failed = 1;
		$username = $_POST['username'];
		$password = $_POST['password'];
		$query = "SELECT * FROM users25 WHERE username='$username' AND password='$password'";
#		echo $query;
		$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
		if ( ($result) && (mysql_num_rows($result) > 0) ){
			$row = mysql_fetch_object($result);
			$adlogin = $row->username;
			$myname = $row->username;
			$adpassword = $row->password;
			$myuid = $row->uid;
#			echo $adlogin." ----".$adpassword."<br>";
			if ( ($username != $adlogin) || ($password != $adpassword) ){
				$failed = 1;
			}else{
				$failed = 0;
				$loggedin = 1;
				session_register("loggedin");
				session_register("myuid");
				session_register("myname");
			}
		}else{
			$failed = 1;
		}
	}
	if($loggedin){
		ob_start();
		header("Location: account.php");
	}
	include("include/header.php");
?>
<p><font face=arial size=3> 
<form action="login.php" method="POST">
  <br>
  <font face="arial" size="2"><br>
  <br>
  </font> 
  <table width="400" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><font face=arial size=3> 
        <input type="hidden" name="action" value="login">
        <font face="arial" size="2"><b>Username</b></font></font></td>
      <td><font face=arial size=3><font face="arial" size="2">
        <input type=text name=username size=30 tabindex="1" maxlength="12">
        </font></font></td>
    </tr>
    <tr>
      <td><font face=arial size=3><font face="arial" size="2"><b>Password</b></font></font></td>
      <td><font face=arial size=3><font face="arial" size="2">
        <input type=password name=password size=30 tabindex="2" maxlength="12">
        </font></font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><font face=arial size=3><font face="arial" size="2">
        <input type="submit" name="Input" value="Login" tabindex="4" style="background-color:#e5e5e5; color:#000000; font-family:Verdana,Arial; font-weight: bold; font-size: 11px; border-left: 1 solid #a0a0a0; border-top: 1 solid #a0a0a0; border-right: 1 solid #000000; border-bottom: 1 solid #000000; padding: 2 2 2 2; outline: #a0a0a0 solid 2px;">
        </font></font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><font face=arial size=3>
        <table border="0" cellpadding="0" cellspacing="0" width="178">
          <tr height="19"> 
            <td height="19" valign="top"> <font face="arial" size="2"><b><a href="mailto:<?=$admin25email?>?subject=<?=$sitename?>/Password"><b>Forgot 
              Your Password?</b></a></b></font> </td>
          </tr>
          </tr>
        </table>
        </font></td>
    </tr>
  </table>
</form>
</font></p>
<?
	include("include/footer.php");
?>