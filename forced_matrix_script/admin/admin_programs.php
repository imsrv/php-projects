<?php
/* nulled by [GTT] :) */

@session_start();
if(session_is_registered("admin"))
{
  if (isset($email) && isset($programs))
  {
     include_once("functions.php");
         include ('header.php');
     db_connect();
     $rand = substr(md5(rand(0,9999999)),0,10);
     $oldumask = umask(0);
     mkdir('../programs/'.$rand, 0777);
     umask($oldumask);
     if (file_exists('../myprog/'.$programs))
     {
        if (copy ('../myprog/'.$programs,'../programs/'.$rand.'/'.$programs))
        {
           $sql = "SELECT * FROM users_bay WHERE email='".$email."'";
           $result = mysql_query($sql);
           if (!$result)
           {
              echo '<center><font color="red">It is impossible to get info about users</font></center>';
           }
           else
           {
              $row = mysql_fetch_array($result);
              $sql = "SELECT * FROM admininfo";
              $result = mysql_query($sql);
              $config = @mysql_fetch_array($result);
              $link = $config['defurl'].'programs/'.$rand.'/'.$programs;
              $sql = "INSERT INTO temp_link (id_user, link) VALUES (".$row['id'].", '".$link."' )";
              $result = mysql_query($sql);
           }
           echo '<center><font color="red">Link is generate success:  '.$rand.'/'.$programs.'</font></center>';
        }
        else
        {
           echo '<center><font color="red">The file is not copy</font></center>';
           rmdir('../programs/'.$rand, 0777);
        }
     }
     else
     {
        echo '<center><font color="red">The file is not exists</font></center>';
     }
  }
?>
<?admin_menu();?>
   <CENTER>
   Enter a email adress for get a programs
   <FORM action="admin_programs.php" method=post>
   <input type="text" name="email" size="30"><br>
   Enter a name file of the programs<br>
   <input type="text" name="programs" size="30"><br>
   <INPUT type=submit value='Generate'>
   </form>
   </center>
<?

}

?>