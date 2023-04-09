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

//Include header
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
          <td><?php if($is_logged == false){?>
      <p>&nbsp;</p>
	  <p>&nbsp;</p>
      <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" name="login" id="login">
        <table width="450" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
          <tr bgcolor="#99CC99"> 
            <td colspan="2"><div align="center"><strong><font color="#000000">Please 
                Log-In Admin Area</font></strong></div></td>
          </tr>
          <tr> 
            <td width="50%"><font color="#000000"><strong>Username:</strong></font></td>
            <td><font face="Verdana, Arial, Helvetica, sans-serif">&nbsp;
              <input name="userloginid" type="text" title="Please Enter Your Username Here" value="<?php echo $_POST['userloginid'];?>" >
              </font></td>
          </tr>
          <tr> 
            <td><font color="#000000"><strong>Password:</strong></font></td>
            <td><font face="Verdana, Arial, Helvetica, sans-serif">&nbsp;
			
              <input type="password" name="userloginpassword" title="Please Enter Your Password Here" >
			 
              </font></td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center">
                <input type="submit" name="Submit" title="Click Here To Log-In FAD System" value="Log-In" >
			<input type="hidden" name="submitid" value="1">
              </div></td>
          </tr>
        </table>
      </form>
		<?php  } else { ?>
		 <p>&nbsp;</p>
		  <font face="Verdana, Arial, Helvetica, sans-serif"><strong>Welcome To 
        FAD Site Manager, Here you will be able to completely control your whole 
        site. This new program will enable you to do the following:</strong></font></font>
      <p align="justify"><font color="#0000FF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Banner 
        Manager:</strong></font>
      <div align="justify"> 
        <ul>
          <li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Add/Remove/Edit/View 
            Banners.</strong></font></li>
          <li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Ability 
            To Group Banners into separate groups, e.g. size 50x50 and 450x35.</strong></font></li>
          <li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Complete 
            Banner Stats (improved).</strong></font></li>
        </ul>
      </div>
      <p align="justify"><font color="#0000FF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Counter 
        Manager:</strong></font></p>
      <div align="justify"> 
        <ul>
          <li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Add/Remove/Edit/View 
            Counters.</strong></font></li>
          <li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Text 
            or Image Based Counters.</strong></font></li>
          <li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Counters 
            can count uniquely or reversibly.</strong></font></li>
			<li ><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Get Complete Visitor\'s Information Including:</strong></font></li>
			
			<li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong> The Type Of System They Use.</strong></font></li>
			<li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>The Type Of Explorer They Use.</strong></font></li>
			<li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Track Which Countries They Are From.</strong></font></li>
        </ul>
      </div>
      <p align="justify"><font color="#0000FF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Complete 
        Referal System:</strong></font></p>
      <div align="justify"> 
        <ul>
          <li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Add/Remove/View 
            Referal accounts.</strong></font></li>
          <li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>Each 
            Account is seprately managed.</strong></font></li>
        </ul>
      </div>
      <p align="justify"><font color="#0000FF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Security 
        Manager:</strong></font></p>
      <div align="justify"> 
        <ul>
          <li><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><strong>The 
            Ability to Generate Log-In Pages On The Spot.</strong></font></li>
        </ul>
      </div>
		 <?php }?></td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<?php
include_once('inc/footer.php');?>