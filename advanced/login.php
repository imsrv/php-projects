<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
session_start();

//site_defines
$SECURED_PAGE = 'index.php';
$ADMIN_USERNAME = 'aziz';
$ADMIN_PASSWORD = '2598';

// If the form was submited check if the username and password match
if($_POST['submitid'] == 1){
	//Call the database file	

	if($_POST['username'] == $ADMIN_USERNAME && $_POST['password'] == $ADMIN_PASSWORD){
		//Make sessions
		$_SESSION['adminin'] = 'yes';
		
		// Redirect to the page
		header("Location: $SECURED_PAGE");
		exit();
	} else {
		$message = 'Invalid username and/or password!';
	}
}
include_once("header.php");
?>
<!--
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
-->
<form action="<? echo $_SERVER['PHP_SELF'];?>" method="post" name="adminlogin" id="adminlogin" style="display:inline;">
  <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
    <tr bgcolor="#99CC99"> 
      <td colspan="2"><div align="center"><strong>Please log in:</strong></div></td>
    </tr>
    <tr> 
      <td width="47%"><strong>Username:</strong></td>
      <td width="53%"><input name="username" type="text" id="username" value="<?php echo $_POST['username'];?>"></td>
    </tr>
    <tr> 
      <td><strong>Password:</strong></td>
      <td><input name="password" type="password" id="password"></td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center"><font face="Georgia, Times New Roman, Times, serif"><strong>
          <input name="Submit" type="submit" id="Submit" value="Click Here To Sign-In">
          <input name="submitid" type="hidden" id="submitid" value="1">
</strong></font> </div></td>
    </tr>
  </table>
</form>
<?php include_once("footer.php"); ?>