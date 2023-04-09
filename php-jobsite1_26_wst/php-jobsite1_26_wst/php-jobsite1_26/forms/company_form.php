<?php include(DIR_LANGUAGES.$language."/".FILENAME_COMPANY_FORM);
$newcompany=false;
if ($error==1)
 {
 $company_result['company']=bx_js_stripslashes($HTTP_POST_VARS['company']);
 $company_result['description']=bx_stripslashes($HTTP_POST_VARS['description']);
 $company_result['address']=bx_stripslashes($HTTP_POST_VARS['address']);
 $company_result['city']=bx_js_stripslashes($HTTP_POST_VARS['city']);
 $company_result['province']=bx_js_stripslashes($HTTP_POST_VARS['province']);
 $company_result['postalcode']=bx_js_stripslashes($HTTP_POST_VARS['postalcode']);
 $company_result['locationid']=$HTTP_POST_VARS['location'];
 $company_result['phone']=bx_js_stripslashes($HTTP_POST_VARS['phone']);
 $company_result['fax']=bx_js_stripslashes($HTTP_POST_VARS['fax']);
 $company_result['email']=bx_js_stripslashes($HTTP_POST_VARS['email']);
 $company_result['url']=bx_js_stripslashes($HTTP_POST_VARS['url']);
 $company_result['password']=bx_js_stripslashes($HTTP_POST_VARS['password']);
 $company_result['featured']=$HTTP_POST_VARS['featured'];
 $company_result['confpassword']=bx_js_stripslashes($HTTP_POST_VARS['confpassword']);
 $company_result['hide_address']=$HTTP_POST_VARS['hide_address'];
 $company_result['hide_location']=$HTTP_POST_VARS['hide_location'];
 $company_result['hide_phone']=$HTTP_POST_VARS['hide_phone'];
 $company_result['hide_fax']=$HTTP_POST_VARS['hide_fax'];
 $company_result['hide_email']=$HTTP_POST_VARS['hide_email'];
 $company_result['agree']=$HTTP_POST_VARS['agree'];
 }
?>
 <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_COMPANY, "auth_sess", $bx_session);?>" method="post" name="frm" onSubmit="return check_form();">
  <INPUT type="hidden" name="action" value="comp_update">
  <INPUT type="hidden" name="validation" value="true">
  <?php
  if ($btnNewCompany || $HTTP_POST_VARS['new_company'] || $HTTP_GET_VARS['action']=="new")
     {
     $newcompany=true;
     echo "<input type=\"hidden\" name=\"new_company\" value=\"true\">";
     }
  ?>
  <?php
  if ($error==0)
  {
  ?>
    <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR bgcolor="#FFFFFF">
      <TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_COMPANY_INFORMATION;?></TD>
   </TR>
   <TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
   </TR>
   <TR>
      <TD colspan="2" valign="top" width="100%" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><i><?php echo TEXT_ABOUT;?></i></b></FONT></TD>
    </TR>
    <TR>
      <TD colspan="2" bgcolor="<?php echo TABLE_BGCOLOR;?>" valign="top" width="100%" align="right"><?php echo REQUIRED_STAR;?><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"> - <?php echo TEXT_REQUIRED_FIELD;?>.</font></TD>
    </TR>
   <?php
    if ($HTTP_SESSION_VARS['employerid']) {
    ?>
      <tr><td colspan="2">&nbsp;</td></tr>
    <?php
    }
    } //end if error==0
    else
    {
        echo bx_table_header(ERRORS_OCCURED);
        echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";
        if ($company_error=="1") echo COMPANY_ERROR."<br>";
        if ($address_error=="1") echo ADDRESS_ERROR."<br>";
        if ($city_error=="1") echo CITY_ERROR."<br>";
        if ($postalcode_error=="1") echo POSTALCODE_ERROR."<br>";
        if ($phone_error=="1") echo PHONE_ERROR."<br>";
        if ($email_error=="1") echo EMAIL_ERROR."<br>";
        if ($allready_email_error=="1") echo ALLREADY_EMAIL_ERROR."<br>";
        if ($password_error=="1") echo PASSWORD_ERROR."<br>";
        if ($confpassword_error=="1") echo CONFPASSWORD_ERROR."<br>";
        if ($terms_error=="1") echo TERMS_ERROR."<br>";
            echo "</font>";
     ?>
     <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="4">

     <?php
     }
     ?>
   <?php if(!$newcompany) {?>
    <TR>
      <TD>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY_FEATURED;?></B></FONT>
      </TD>
     <TD>
       <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B> <?php if((!$company_result['featured']) or ($company_result['featured']=='0')) {echo "No";}?>
      <?php if($company_result['featured']=='1') {echo "Yes";}?></B></font>
      </TD>
    </TR>
 <?php
 }//end if (!$newcompany)
 ?>
    <tr>
         <TD colspan="2" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_COMPANY_INFORMATION;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_EMPLOYER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
           </TR>
          </TABLE>
         </TD>
    </tr>
    <TR><TD colspan="2">&nbsp;</TD></TR>
    <TR>
      <TD valign="top" width="25%">
        <?php if($company_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_COMPANY;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="company" size="30"
        value="<?php echo $company_result['company'];?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
	<TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY_DESCRIPTION;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name="description" rows="4" cols="30"><?php echo $company_result['description'];?></textarea></FONT></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <?php if($address_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_ADDRESS;?>:</B></FONT>
      </TD>
      <TD width="75%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name="address" rows="3" cols="30"><?php echo $company_result['address'];?></textarea></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
	<TR>
      <TD valign="top" width="25%">
        <?php if($city_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="city" size="30"
        value="<?php echo $company_result['city'];?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="province" size="15"  value="<?php echo $company_result['province'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <?php if($postalcode_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_POSTAL_CODE;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="postalcode" size="10"
        value="<?php echo $company_result['postalcode'];?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COUNTRY;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <SELECT name="location" size="1">
         <?php
          $country_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng."");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          while ($country_result=bx_db_fetch_array($country_query))
          {
          echo '<option value="'.$country_result['locationid'].'"';
          if ($company_result['locationid']==$country_result['locationid']) {echo " selected";}
          echo '>'.$country_result['location'].'</option>';
          }
          ?>
         </SELECT>
      </TD>
    </TR>
    <TR><TD colspan="2">&nbsp;</TD></TR>
    <tr>
         <TD colspan="2" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_CONTACT_INFORMATION;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_EMPLOYER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
           </TR>
          </TABLE>
         </TD>
    </tr>
    <TR><TD colspan="2">&nbsp;</TD></TR>
    <TR>
      <TD valign="top" width="25%">
        <?php if($phone_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_PHONE;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="phone" size="10"
        value="<?php echo $company_result['phone'];?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_FAX;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="fax" size="10"
        value="<?php echo $company_result['fax'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <?php if($email_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_EMAIL;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="email" size="30"
        value="<?php echo $company_result['email'];?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_URL;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="url" size=30
        value="<?php echo $company_result['url'];?>"></FONT>
      </TD>
    </TR>
    <TR><TD colspan="2">&nbsp;</TD></TR>
    <TR><TD colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_HIDE_NOTE;?></font></TD></TR>
    <TR><TD colspan="2">&nbsp;</TD></TR>
    <TR>
      <TD valign="top" width="25%">&nbsp;</TD>
      <TD width="75%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_address" value="yes"<?php if($company_result['hide_address'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_ADDRESS;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">&nbsp;</TD>
      <TD width="75%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_location" value="yes"<?php if($company_result['hide_location'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_LOCATION;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">&nbsp;</TD>
      <TD width="75%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_phone" value="yes"<?php if($company_result['hide_phone'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_PHONE;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">&nbsp;</TD>
      <TD width="75%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_fax" value="yes"<?php if($company_result['hide_fax'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_FAX;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">&nbsp;</TD>
      <TD width="75%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_email" value="yes"<?php if($company_result['hide_email'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_EMAIL;?></font></TD>
    </TR>
    <TR><TD colspan="2">&nbsp;</TD></TR>
    <tr>
         <TD colspan="2" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_LOGIN_INFORMATION;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_EMPLOYER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
           </TR>
          </TABLE>
         </TD>
    </tr>
    <TR><TD colspan="2">&nbsp;</TD></TR>
 </table>
 <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="4">
    <TR>
      <TD valign="top" width="35%">
        <?php if($password_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_PASSWORD;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="password" name="password" size="10"
        value="<?php echo bx_js_stripslashes($company_result['password']);?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="35%">
        <?php if($confpassword_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_CONFIRM_PASSWORD;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="password" name="confpassword" size="10"
        value="<?php if($error==1) {echo bx_js_stripslashes($company_result['confpassword']);} else {echo bx_js_stripslashes($company_result['password']);}?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <?php if(!$HTTP_SESSION_VARS['employerid']){?>
     <TR>
      <TD colspan="2" align="left" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="agree" value="Y"<?php if($HTTP_POST_VARS['agree']=="Y"){ echo " checked";}?>>&nbsp;&nbsp;<?php echo TEXT_TERMS;?></FONT>
      </TD>
    </TR>
    <?php }else{?>
         <input type="hidden" name="agree" value="yes">
    <?php }?>
    <TR>
      <TD colspan="2" align="right" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="reset" name="btnReset" value="<?php echo TEXT_BUTTON_RESET;?>">
          <INPUT type="submit" name="btnSave" value="<?php echo TEXT_BUTTON_SAVE;?>"></FONT>
      </TD>
    </TR>
  </TABLE>
</FORM>