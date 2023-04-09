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
          <td><table width="100%" border="1" cellpadding="0" cellspacing="3" bordercolor="#0000FF" >
              <tr> 
                <td width="25%"><div align="center"><a href="addref.php" ><strong>Add 
                  Referral</strong></a></div></td>
                <td width="25%"><div align="center"><a href="editref.php" ><strong>Edit 
                  Referral</strong></a></div></td>
                <td width="25%"><div align="center"><a href="viewref.php" ><strong> 
                  Referral Stat</strong></a></div></td>
                <td width="25%"><div align="center"><a href="removeref.php" ><strong>Remove 
                  Referral</strong></a></div></td>
              </tr>
            </table>
            <p align="justify"><strong>The 
              Referral manager allows you to give clients a unique link for them 
              to give out to their customers. Cookies from those links will be 
              stored for 30 days. If a someone with that link registers or buys 
              anything from that site, it will be recorded and added to their 
              credit. All you have to do is to add a referral and give it to anyone 
              to use. <font color="#FF0000">TO USE THIS  THE FAD SITE MANAGER 
              MUST SHARE THE SAME DATABASE AS THE 
              REGISTRATION SYSTEM</font>. </strong></p>
            <p align="center"><strong>The link you will give to users will be: <font color="#FF0000">&lt;?php</font> <font color="#009900">include</font>(&quot;ctchrefscr.php?sessionid=<font color="#FF00FF">XXX</font>&quot;);<font color="#FF0000">?&gt;</font></strong></p>
            <p align="left"><strong>Where <font color="#FF00FF">XXX</font> is the referral ID,</strong></p>
            <p align="left"><strong>You will also need to put this piece of code at the place where the registration or payment process is completed:</strong></p>            <font face="Georgia, Times New Roman, Times, serif"><strong></strong></font>
              <table width="100%" border="0" cellspacing="3" cellpadding="3">
                <tr> 
                  <td><div align="center">
                    <textarea class="textarea" name="textarea" id="textarea" style="width:100%;height:100px;" title="Click On 'Copy Code' To Copy This Code To The Clipboard">
//Fetch is there is a cookie installed on the clients computer
$id = $_COOKIE['ref_id'];
//Give credit only if cookie was found
if($id != NULL){
	$find_refeal = @mysql_query("SELECT * FROM `referrals` WHERE `id`='$id'");
	//If id is not found, then it was removed, do nothing, else give credit
	if(@mysql_num_rows($find_refeal) > 0){
		 //Get current credits
		 $get_info_info = @mysql_fetch_array($find_refeal);
		 $currentcredit = $get_info_info[4];
		 $currentcredit++;
		 $update_credits = @mysql_query("UPDATE `referrals` SET `credits`='$currentcredit' WHERE `id`='$id'");
	}
}</textarea></div>                    <div align="center"><font face="Georgia, Times New Roman, Times, serif"><strong><font face="Georgia, Times New Roman, Times, serif"><strong><font color="#FF00FF"> 
                    </font></strong></font></strong></font></div></td>
                </tr>
              </table>
              <font face="Georgia, Times New Roman, Times, serif"><strong> 
              <font color="#FF00FF"> </font><font face="Georgia, Times New Roman, Times, serif"><strong><font color="#FF00FF"> 
              </font></strong></font></strong></font> 
          
            <p align="justify">&nbsp;</p></td>
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