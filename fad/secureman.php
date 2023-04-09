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
          <td>
		<p align="justify"><strong><font color="#000000">FAD&reg; Securit Manager allows you to automatically generate secure log-in 
              and log-off pages, read from database or only one access user. Also 
              includes the protection for any page you want to protect, just answer 
              these simple questions and click on generate page:</font></strong></p>
			  
            <form name="genpass" id="genpass" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" style="display:inline;">
              <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
                <tr> 
                  <td width="100%" bgcolor="#99CC99"><div align="center"><font color="#000000"><strong>Password 
                      Generator: </strong></font></div></td>
                </tr>
                <tr> 
                  <td height="12" bgcolor="#99CC99"><strong><font color="#000000">Please 
                    Enter The Destination Page (after user logs in):</font></strong></td>
                </tr>
                <tr> 
                  <td><div align="center"><strong> 
				  <input name="dest" type="hidden" id="dest4" value="<?php echo $_POST['dest'];?>">
				  <?php if($_POST['dest'] == NULL){$_POST['dest'] = 'mainpage.php';}?>
                      <input name="dest" title="Enter Destination URL" type="text"  id="dest" value="<?php echo $_POST['dest'];?>" size="50" <?=$disabled;?>>
</strong></div></td>
                </tr>
                <tr> 
                  <td bgcolor="#99CC99"><strong><font color="#000000">Please 
                    Enter Session Length:</font></strong></td>
                </tr>
                <tr> 
                  <td><div align="center"><strong><font color="#000000"> 
				  </font>
                        <input name="time" type="hidden" id="time3" value="<?php echo $_POST['time'];?>">
                        <input name="timeis2" type="hidden" id="timeis2" value="<?php echo $_POST['timeis'];?>">
                        <font color="#000000">
                      <?php if($_POST['time'] == NULL){$_POST['time'] = '1';}?>
                      <input name="time"  type="text" title="Enter Amount Of Time To Store User In System"  id="time" value="<?php echo $_POST['time'];?>" size="6" maxlength="4" <?=$disabled;?>>
                      <select name="timeis" title="Choose Time Type" id="timeis" <?=$disabled;?>>
					    <?php if($_POST['timeis'] == 'seconds'){$sel='selected';}else{$sel=NULL;}?>
                        <option value="seconds" <?=$sel;?>>Seconds</option>
                        <?php if($_POST['timeis'] == 'minutes'){$sel='selected';}else{$sel=NULL;}?>
					    <option value="minutes" <?=$sel;?>>Minutes</option>
                        <?php if($_POST['timeis'] == 'hours' || $_POST['timeis'] == NULL){$sel='selected';}else{$sel=NULL;}?>
					    <option value="hours" <?=$sel;?>>Hours</option>
                        <?php if($_POST['timeis'] == 'Days'){$sel='selected';}else{$sel=NULL;}?>
					    <option value="Days" <?=$sel;?>>Days</option>
                        <?php if($_POST['timeis'] == 'weeks'){$sel='selected';}else{$sel=NULL;}?>
					    <option value="weeks" <?=$sel;?>>Weeks</option>
                        <?php if($_POST['timeis'] == 'months'){$sel='selected';}else{$sel=NULL;}?>
					    <option value="months" <?=$sel;?>>Months</option>
                        <?php if($_POST['timeis'] == 'years'){$sel='selected';}else{$sel=NULL;}?>
					    <option value="years" <?=$sel;?>>Years</option>
                      </select>
                      <em> (months are counted 31 days)</em></font>
                        
                  </strong></div></td>
                </tr>
                <tr> 
                  <td bgcolor="#99CC99"><strong><font color="#000000">Please 
                    Enter Log-In Style:</font></strong></td>
                </tr>
                <tr> 
                  <td><div align="center"><strong><strong><font color="#000000"> 
				  </font><strong>
				  <input name="logstyle" type="hidden" id="logstyle3" value="<?php echo $_POST['logstyle'];?>">
				  </strong><font color="#000000">
                      <?php if($_POST['logstyle'] == 'sessions'){$sel='checked';}else{$sel=NULL;}?>
                      <input name="logstyle" id="logstyle"  title="Choose This Option To Store user In Sessions" type="radio" value="sessions" <?=$sel;?> <?=$disabled;?>>
                      Sessions <strong> 
					   <?php if($_POST['logstyle'] == 'cookies'){$sel='checked';}else{$sel=NULL;}?>
                      <input name="logstyle"  id="logstyle" title="Choose This Option To Store user In Cookies" type="radio" value="cookies" <?=$sel;?> <?=$disabled;?>>
                      </strong>Cookies<strong><strong> 
					   <?php if($_POST['logstyle'] == 'both' || $_POST['logstyle'] == NULL){$sel='checked';}else{$sel=NULL;}?>
                      <input name="logstyle" id="logstyle"  title="Choose This Option To Store user In Both Sessions and Cookies(more Secure)" type="radio" value="both" <?=$sel;?> <?=$disabled;?>>
                      </strong></strong>Both</font>
                          
                  </strong></strong></div></td>
                </tr>
                <tr> 
                  <td bgcolor="#99CC99"><div align="justify"><strong><font color="#000000">Enable 
                      Past Tracking: (if user enters a page, lets say remove.html, 
                      and then redirected to the log-in. After log-in do you want 
                      him to return to remove.html or straight to Destination 
                      Page?)</font></strong></div></td>
                </tr>
                <tr> 
                  <td><div align="center"><strong><strong><font color="#000000"> 
				   </font><strong><strong>
				   <input name="pastrack" type="hidden" id="pastrack12" value="<?php echo $_POST['pastrack'];?>">
				   </strong></strong><font color="#000000">
                      <?php if($_POST['pastrack'] == 'yes' || $_POST['pastrack'] == NULL){$sel='checked';}else{$sel=NULL;}?>
                      <input name="pastrack" title="Choose This Option To Enable Past-Tracking"  type="radio" value="yes" <?=$sel;?> <?=$disabled;?>>
&nbsp; Yes
<?php if($pastrack['logstyle'] == 'no'){$sel='checked';}else{$sel=NULL;}?>
<input type="radio" title="Choose This Option To Disable Past-Tracking"  name="pastrack" value="no" <?=$sel;?> <?=$disabled;?>>
&nbsp; No</font><strong>

</strong></strong></strong></div></td>
                </tr>
                <tr> 
                  <td height="31" bgcolor="#99CC99"><strong><font color="#000000">User-Login 
                    Information: </font></strong></td>
                </tr>
                <tr> 
                  <td><table width="100%" border="1" cellpadding="5" cellspacing="5">
                      <tr> 
                        <td width="25%"><font color="#000000"><strong>Username:<strong><strong>
                          <input name="username" type="hidden" id="username" value="<?php echo $_POST['username'];?>">
                        </strong></strong></strong></font></td>
                        <td width="25%"><div align="center"><strong> 
                            <input name="username" type="text"  id="username" title="Enter Username Here - USE THIS FOR ONLY ONE PERSON ACCESS SYSTEM ONLY" value="<?php echo $_POST['username'];?>" size="25" <?=$disabled;?>>
                            </strong></div></td>
                        <td width="25%"> <font color="#000000"><strong>Password: <strong><strong>
                          <input name="password" type="hidden" id="password" value="<?php echo $_POST['password'];?>">
                        </strong></strong>                          </strong></font></td>
                        <td width="25%"><div align="center"><strong> 
                            <input name="password" type="text"  id="password" title="Enter Password Here - USE THIS FOR ONLY ONE PERSON ACCESS SYSTEM ONLY" value="<?php echo $_POST['password'];?>" size="25" <?=$disabled;?>>
                            </strong></div></td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td bgcolor="#99CC99"><div align="left"><font color="#000000"><strong>Do 
                      You Want To Use Database To Dynamically Get Id and Password 
                      Entered:</strong></font></div></td>
                </tr>
                <tr> 
                  <td><font color="#000000"><strong>Password 
                    Field Format Type: <strong> 
					<strong>
					<input name="passis" type="hidden" id="passis" value="<?php echo $_POST['passis'];?>">
					</strong>
					<?php if($pastrack['passis'] == 'text' || $_POST['passis'] == NULL){$sel='checked';}else{$sel=NULL;}?>
                    <input name="passis" title="Choose This Option If Reading User List Password From A Text Field In The Database"  type="radio" value="text" <?=$sel;?> <?=$disabled;?>>
                    </strong>Text 
                    <strong> 
					<?php if($pastrack['passis'] == 'pass'){$sel='checked';}else{$sel=NULL;}?>
                    <input name="passis" title="Choose This Option If Reading User List Password From A Password Field In The Database"  type="radio" value="pass" <?=$sel;?> <?=$disabled;?>>
                    </strong>Password<strong><strong>
                    
                    </strong></strong></strong></font></td>
                </tr>
                <tr> 
                  <td> <table width="100%" border="1" cellpadding="5" cellspacing="5">
                      <tr> 
                        <td width="25%"><font color="#000000"><strong>Host 
                          Name: <strong><strong>
                          <input name="hostname" type="hidden" id="hostname" value="<?php echo $_POST['hostname'];?>">
                          </strong></strong></strong></font></td>
                        <td width="25%"><div align="center"><strong> 
                            <input name="hostname" type="text"  id="hostname" title="Enter Hostname Here - USE THIS FOR MULTI-ACCESS PERSON ACCESS SYSTEM ONLY-Using Database" value="<?php echo $_POST['hostname'];?>" size="25" <?=$disabled;?>>
                            </strong></div></td>
                        <td width="25%"><strong><font color="#000000">Table 
                          Name:</font><strong><strong>
                          <input name="tablenames" type="hidden" id="tablenames" value="<?php echo $_POST['tablenames'];?>">
                          </strong></strong></strong></td>
                        <td width="25%"><div align="center"><strong> 
                            <input name="tablenames" type="text"  id="tablenames" title="Enter Tablename Here - USE THIS FOR MULTI-ACCESS PERSON ACCESS SYSTEM ONLY-Using Database" value="<?php echo $_POST['tablenames'];?>" size="25" <?=$disabled;?>>
                            </strong></div></td>
                      </tr>
                      <tr> 
                        <td><font color="#000000"><strong>Database 
                          Name: <strong><strong>
                          <input name="dataname" type="hidden" id="dataname" value="<?php echo $_POST['dataname'];?>">
                          </strong></strong></strong></font></td>
                        <td width="25%"><div align="center"><strong> 
                            <input name="dataname" type="text"  id="dataname" title="Enter Database Name Here - USE THIS FOR MULTI-ACCESS PERSON ACCESS SYSTEM ONLY-Using Database" value="<?php echo $_POST['dataname'];?>" size="25" <?=$disabled;?>>
                            </strong></div></td>
                        <td width="25%"><font color="#000000"><strong>Userid 
                          Field: <strong><strong>
                          <input name="field1" type="hidden" id="field1" value="<?php echo $_POST['field1'];?>">
                          </strong></strong></strong></font></td>
                        <td width="25%"><div align="center"><strong> 
                            <input name="field1" type="text"  id="field1" title="Enter User Id Field Name Here - USE THIS FOR MULTI-ACCESS PERSON ACCESS SYSTEM ONLY-Using Database" value="<?php echo $_POST['field1'];?>" size="25" <?=$disabled;?>>
                            </strong></div></td>
                      </tr>
                      <tr> 
                        <td><font color="#000000"><strong>Username:<strong><strong>
                          <input name="dusername" type="hidden" id="dusername" value="<?php echo $_POST['dusername'];?>">
                        </strong></strong></strong></font></td>
                        <td width="25%"><div align="center"><strong> 
                            <input name="dusername" type="text"  id="dusername" title="Enter Database Username Name Here - USE THIS FOR MULTI-ACCESS PERSON ACCESS SYSTEM ONLY-Using Database" value="<?php echo $_POST['dusername'];?>" size="25" <?=$disabled;?>>
                            </strong></div></td>
                        <td width="25%"><font color="#000000"><strong>Password 
                          Field: <strong><strong>
                          <input name="field2" type="hidden" id="field2" value="<?php echo $_POST['field2'];?>">
                          </strong></strong></strong></font></td>
                        <td width="25%"><div align="center"><strong> 
                            <input name="field2" type="text"  id="field2" title="Enter Database Password Field Name Here - USE THIS FOR MULTI-ACCESS PERSON ACCESS SYSTEM ONLY-Using Database" value="<?php echo $_POST['field2'];?>" size="25" <?=$disabled;?>>
                            </strong></div></td>
                      </tr>
                      <tr> 
                        <td><font color="#000000"><strong>Password:<strong><strong>
                          <input name="dpassword" type="hidden" id="dpassword" value="<?php echo $_POST['dpassword'];?>">
                        </strong></strong></strong></font></td>
                        <td width="25%"><div align="center"><strong> 
                            <input name="dpassword" type="text"  id="dpassword" title="Enter Database Password Here - USE THIS FOR MULTI-ACCESS PERSON ACCESS SYSTEM ONLY-Using Database" value="<?php echo $_POST['dpassword'];?>" size="25" <?=$disabled;?>>
                            </strong></div></td>
                        <td width="25%">&nbsp;</td>
                        <td width="25%">&nbsp;</td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><div align="center">
                      <input name="issubmitted" type="hidden" value="yesis">
					  <?php if($_POST['submitid'] == 18){ $sel='18';}else{$sel='17';}?>
                      <input name="submitid" type="hidden" value="<?=$sel;?>">
                      <input type="Submit" title="Generate Script Now!" name="Submit" value="Create Script" >
                    </div></td>
                </tr>
              </table>
  </form>
  
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