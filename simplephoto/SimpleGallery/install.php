<?
#########################################################
# Simple Gallery                                        #
#########################################################
#                                                       #
# Created by: Doni Ronquillo                            #
#                                                       #
# This script and all included functions, images,       #
# and documentation are copyright 2003                  #
# free-php.net (http://free-php.net) unless             #
# otherwise stated in the module.                       #
#                                                       #
# Any copying, distribution, modification with          #
# intent to distribute as new code will result          #
# in immediate loss of your rights to use this          #
# program as well as possible legal action.             #
#                                                       #
#########################################################

   include("inc/config.php");
   include("inc/header.php");

   $action = $_REQUEST['action'];

   if ($action == "install") {

	  $errmsg  = "<font color='red'><b>Errors Encountered... Please fix and rerun install.php</b><br><br>";
      $showerr = "";

		$sql     = "DROP TABLE IF EXISTS `freephp_gallery`";
		$res     = mysql_query($sql);
		$errmsg .= mysql_error();

      if (mysql_error()) { $showerr = "yes"; }

		$sql     = "DROP TABLE IF EXISTS `freephp_gallery_admin`";
		$res     = mysql_query($sql);
		$errmsg .= mysql_error();

      if (mysql_error()) { $showerr = "yes"; }

		$sql     = "DROP TABLE IF EXISTS `freephp_gallery_category`";
		$res     = mysql_query($sql);
		$errmsg .= mysql_error();

      if (mysql_error()) { $showerr = "yes"; }

		$sql     = "CREATE TABLE `freephp_gallery` (`id` bigint(99) NOT NULL auto_increment,`title` varchar(255) NOT NULL default '',`description` longtext NOT NULL,`keywords` longtext NOT NULL,`category` varchar(255) NOT NULL default '0',`downloads` varchar(255) NOT NULL default '0', PRIMARY KEY  (`id`)) TYPE=MyISAM";
		$res     = mysql_query($sql);
		$errmsg .= "<br>" . mysql_error();

      if (mysql_error()) { $showerr = "yes"; }

		$sql     = "CREATE TABLE `freephp_gallery_admin` (`username` varchar(255) NOT NULL default '',`password` varchar(255) NOT NULL default '') TYPE=MyISAM";
		$res     = mysql_query($sql);
		$errmsg .= "<br>" . mysql_error();

      if (mysql_error()) { $showerr = "yes"; }

		$sql     = "CREATE TABLE `freephp_gallery_category` (`id` bigint(99) NOT NULL auto_increment,`parent` varchar(255) NOT NULL default '0',`title` varchar(255) NOT NULL default '',`description` longtext NOT NULL, PRIMARY KEY  (`id`)) TYPE=MyISAM";
		$res     = mysql_query($sql);
		$errmsg .= "<br>" . mysql_error();

		$sql     = "INSERT INTO freephp_gallery_admin (username, password) VALUES ('$username','$password')";
		$res     = mysql_query($sql);
		$errmsg .= "<br>" . mysql_error();

      if (mysql_error()) { $showerr = "yes"; }

        Exec ("rm -rf $base_dir/images");

		mkdir ("$base_dir/images", 0777);
		mkdir ("$base_dir/images/fullsize", 0777);
		mkdir ("$base_dir/images/preview", 0777);
		mkdir ("$base_dir/images/thumbs", 0777);
		chmod ("$base_dir/images", 0777);
		chmod ("$base_dir/images/fullsize", 0777);
		chmod ("$base_dir/images/preview", 0777);
        chmod ("$base_dir/images/thumbs", 0777);

      Exec ("cp $base_dir/folder.gif $base_dir/images/folder.gif");
      Exec ("rm $base_dir/folder.gif");

		$errmsg  .= "</font>";

      if ($showerr == "yes") {
         echo $errmsg;

			$sql     = "DROP TABLE IF EXISTS `freephp_gallery`";
			$res     = mysql_query($sql);

			$sql     = "DROP TABLE IF EXISTS `freephp_gallery_admin`";
			$res     = mysql_query($sql);

			$sql     = "DROP TABLE IF EXISTS `freephp_gallery_category`";
			$res     = mysql_query($sql);

      } else {

         echo "Your MySQL Tables have been created successfully and your Admin password has been set!<br><a href='login.php'><b>Login Here</b></a>";

      }

   } else {

      ?>
      <center>
      <br>
      Simple Gallery Installation<br>This will install the tables and folders needed to run Simple Gallery and set your Admin Password<br><br>
      <b>Please Remove This Script (install.php) When Finished!</b><br>If this script (install.php) is run again it will remove your old tables (including all data).<br><br>
      <form name="install" action="install.php" method="post">
      <input type="hidden" name="action" value="install">
      Admin Username: <input type="text" name="username" value=""><br>
      Admin Password: <input type="password" name="password" value=""><br>
      <input type="submit" name="submit" value="Create MySQL Tables Now">
      </form>
      </center>
      <?
   }

 	include("inc/footer.php");

?>