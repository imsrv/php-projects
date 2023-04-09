<body link="#0000CC"><table width="795" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
          <td width="794"><p align="center"><img src="images/yourlogo.jpg" width="493" height="125"></p>
    </td>
          <td width="1" valign="top">&nbsp;</td>
  </tr>
        <tr> 
          <td height="20" colspan="2"><div align="center">
            <?php 
			if(!isset($_SESSION["auid"]) || $_SESSION["auid"]<=0)
			{
	?>
            <a href="../index.php" class="nav">Site Home</a> - <a href="forgotpwd.php" class="nav">Forgot
            Password</a> - <a href="index.php" class="nav">Login</a> 
            <?php
			}else{
		?>
            <a href="lastlogins.php" class="nav">Last Logins</a> - <a href="profile.php" class="nav">Profile</a> - <a href="configure.php" class="nav">Configurations</a> - <a href="viewfiles.php" class="nav">View
            Files</a> - <a href="logout.php" class="nav">Logout</a> 
            <?php
	  	}
		?>
          </div></td>
        </tr>
      </table>
