Welcome to the Open Tournament System
<br>
<span class="requiredtxt">
 This site is still in beta, if you find any errors please report them to bug listing <a href="http://sourceforge.net/projects/tourny/">Here</a>
</span>
<br><br>
<table class="instructions" width="500">
 <tr>
  <th width="10">
  </th>
  <th width="490">
  </th>
 </tr>
 <tr>
  <td colspan="2">
   Now that you have successfully copied the site to your server. You must make sure that you have completed the following Steps:
  </td>
 </tr>
 <tr>
  <td valign="top">
   1.
  </td>
  <td>
   Install the phpBB forum.
   <br>
   <span class="requiredtxt">
    You must go through and setup phpbb first. You must make a forum for announcements/news. This is required for the news script to work. It is highly suggested to make this the first forum.
   </span>
  </td>
 </tr>
 <tr>
  <td valign="top">
   2.
  </td>
  <td>
   Create Your Database.
   <br>
   <span class="requiredtxt">
    Make sure you have made a Database and a User with full rights to that database.
   </span>
  </td>
 </tr>
 <tr>
  <td valign="top">
   3.
  </td>
  <td>
   Load Default Database.
   <br>
   <span class="requiredtxt">
    You must load the sql dump into the database. This is done through a 3rd party program. The required sql dump is 'table dump.sql' in the root folder.
   </span>
  </td>
 </tr>
 <tr>
  <td valign="top">
   4.
  </td>
  <td>
   Setup .htaccess for Apache Users
   <br>
   <span class="requiredtxt">
    This site is made to be secure as reasonably possible. A preconfigured '.htaccess' file has been included named 'htaccess.txt'. Simply rename 'htaccess.txt file to '.htaccess' to install it. This file is not required but highly suggested as it prevents access to the site's files and configures php properly for the site.
   </span>
  </td>
 </tr>
 <tr>
  <td valign="top">
   4.
  </td>
  <td>
   Setup for ISS Users
   <br>
   <span class="requiredtxt">
    You will need to add a security override for '.inc.php', '.tpl' files dont load. This site was developed on Apache, so ISS has not been tested but should work.
   </span>
  </td>
 </tr>
 <tr>
  <td valign="top">
   5.
  </td>
  <td>
   Chmod for Linux/Unix Systems
   <br>
   <span class="requiredtxt">
    Chmod the following Directories and Files:
    <br>
    Make sure to chmod all subdirectories of specified directories.
   </span>
   <table class="inst_chmod" width="70%">
    <tr>
     <th width="90%">
     </th>
     <th width="10%">
     </th>
    </tr>
    <tr>
     <td>
      /pages/cache/
     </td>
     <td>
      777
     </td>
    <tr>
   </table>
  </td>
 </tr>
</table>
<br><br>
<form method=POST>
 <input type="submit" name="{FIELD_SUBMIT}" value="I Have Completed All Requried Steps">
</form> 