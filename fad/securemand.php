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

//Check if form was included
if($_POST['issubmitted'] == NULL){
	header("Location: secureman.php");
	exit();
}

//Include header (which inturn include, page titles ands connect file)
require_once ("inc/header.php"); 

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="25%" valign="top">
      <?php // Get the side menu
	  require_once('inc/side.php');?>
    </td>
    <td width="90%" valign="top"> 
      <table width="100%" border="0" cellspacing="5" cellpadding="5">
        <tr> 
          <td>
<table width="100%" border="1" cellpadding="5" cellspacing="1" bordercolor="#00CCFF">
              <tr> 
                <td width="100%" bgcolor="#99CC99"><div align="center"><strong>Generator 
                Results: </strong></div></td>
              </tr>
              <tr> 
                <td height="12" bgcolor="#99CCCC"><div align="justify"><strong>This is the login file (login.php), you would need to use it to access secured pages/directories.</strong></div></td>
              </tr>
              <tr> 
                <td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-serif"> 
                    <textarea name="login" rows="10" id="login" style="width:100%;" title="Make A New File, Called login.php (name does not matter), and place this code in it and save it."><?php echo $logontext;?></textarea>
                    </font></strong></div></td>
              </tr>
              <tr> 
                <td bgcolor="#99CCCC"><div align="justify"><strong>This is the logoff file (login.php), you would need to use this to securely log off. </strong></div></td>
              </tr>
              <tr> 
                <td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-serif"> 
                    <textarea name="logoff" rows="10" id="logoff" style="width:100%;" title="Make A New File Called logoff.php (name does not matter), and place this code in it and save it"><?php echo $logofftext;?></textarea>
                    </font></strong></div></td>
              </tr>
              <tr> 
                <td bgcolor="#99CCCC"><div align="justify"><strong>You would protected file by placing this text at topmost of the file - Directories would be secured by placing an index.php file which has only this text):</strong></div></td>
              </tr>
              <tr> 
                <td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-serif"> 
                    <textarea name="protect" rows="10" id="protect"  style="width:100%;" title="Now to Protect any Pages with this log-in information Place This Code The First thing at the top."><?php echo $protecttext;?></textarea>
                    </font></strong></div></td>
              </tr>
              <tr> 
                <td bgcolor="#99CCCC"><div align="center"><strong>If you change any filenames (login.php,logoff.php) insure that the code reflects the changed filenames. </strong></div></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      
    </td>
  </tr>
  <tr align="center"> 
    <td height="28" colspan="2">
      
    </td>
  </tr>
</table>
<?php // get the footer
	  require_once('inc/footer.php');?>