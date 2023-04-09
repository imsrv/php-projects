<?
//is a user logged on?
  if (isset($_SESSION['valid_user']))
  {
	echo '<table align="center"><tr><td><div>You are logged in as: <br /><b>'.$_SESSION['valid_user'].'</b><br />';
	echo 'of<br /><b>'.$_SESSION['groupname'].'</b></div></td></tr></table>';
    echo '<table align="center">';
	echo '<tr><td><a href="index.php?log=change">Change password</a></td></tr>';
	echo '<tr><td><a href="index.php?log=logout">Log out</a></td></tr>';
	  echo '</table>';
  }
  else
  {
	if (isset($_POST['userid']))
    {
		$lookup = "SELECT e_users.passwd,e_users.username,e_users.groupname FROM e_users WHERE username='$_POST[userid]'";
		$looked = mysql_query($lookup, $db_conn) or die("Query $looked Failed".mysql_error());
		$rowlooked = mysql_fetch_assoc($looked);
		if (mysql_num_rows($looked)==0)
		{
			echo '<div class="log">The user '.$_POST['userid'].' does not exist in the database.</div>';
		}
		elseif (mysql_num_rows($looked) >0 && ($rowlooked['passwd'] != $_POST['password']))
		{
      // if they've tried and failed to log in
      echo '<div>Your password is incorrect.</div>';
	echo '<br /><br /><a href="index.php?log=forgot&&user='.$_POST['userid'].'" /><div class="log">Forgotten your<br />password?</div></a>';
		}
		
    }
	
	
    else 
    {
      // they have not tried to log in yet or have logged out
      echo "<div>You are not logged in.</div>";
    }

    // provide form to log in 
    echo '<div><form method="post" action="index.php">';
    echo '<table>';
    echo '<tr><td>Userid:</td></tr>';
    echo '<tr><td><input type="text" name="userid" style="font-size:10px;border:solid 1px;"></td></tr>';
    echo '<tr><td>Password:</td></tr>';
    echo '<tr><td><input type="password" name="password" style="font-size:10px;border:solid 1px;"></td></tr>';
    echo '<tr><td colspan=2 align=center>';
    echo '<input type=image src="images/login.gif" name="logbut" value="Log in"></td></tr>';
    echo '</table></form>';
	echo '<a href="index.php?page=reg" />Register</a>';
	}
  
?>