<?php
// we must never forget to start the session
session_start();

$errorMessage = '';
if (isset($_POST['txtUserId']) && isset($_POST['txtPassword'])) {
// check if the user id and password combination is correct
if (
$_POST['txtUserId'] === 'outfit' && 
$_POST['txtPassword'] === 'ca91748') {
// the user id and password match,
// set the session
$_SESSION['basic_is_logged_in'] = true;

// after login we move to the main page
header('Location: admin.php');
exit;
} else {
$errorMessage = 'Sorry, wrong user id / password';
}
}
?><!--//
*********************************************************************************   
*********************************************************************************   
**  a script that you enter your myspace url and ms user idit creates a code   **
**          so that users can place a contact box on there website             **
**      Copyright (C) 2005  <Mark Beard markbeardwebdesign@gmail.com>          **
**                                                                             **
**     This program is free software; you can redistribute it and/or modify    **  
**     it under the terms of the GNU General Public License as published by    **  
**       the Free Software Foundation; either version 2 of the License, or     **  
**                     (at your option) any later version.                     **  
**                                                                             **  
**         This program is distributed in the hope that it will be useful,     **  
**         but WITHOUT ANY WARRANTY; without even the implied warranty of      **  
**          MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      **  
**              GNU General Public License for more details.                   **  
**                                                                             **  
**        You should have received a copy of the GNU General Public License    **  
**        along with this program; if not, write to the Free Software          **  
**  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA  **   
*********************************************************************************
********************************************************************************* //--> <html>
<head>
<title>Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body> <center> Your Copy Of This Script is: <? include "version.php" ?>  The latest Version Is: <? include "http://myspaceoutfit.com/mscontact/current.php" ?>  
<?php
if ($errorMessage != '') {
?>
<p align="center"><strong><font color="#990000"><?php echo $errorMessage; ?></font></strong></p>
<?php
}
?>
<form method="post" name="frmLogin" id="frmLogin">
<table width="400" border="1" align="center" cellpadding="2" cellspacing="2">
<tr>
<td width="150">User Id</td>
<td><input name="txtUserId" type="text" id="txtUserId"></td>
</tr>
<tr>
<td width="150">Password</td>
<td><input name="txtPassword" type="password" id="txtPassword"></td>
</tr>
<tr>
<td width="150">&nbsp;</td>
<td><input type="submit" name="btnLogin" value="Login"></td>
</tr>
</table>
</form><? include "footer.php" ?>
</body>
</html>