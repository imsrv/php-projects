<?php include(DIR_LANGUAGES.$language."/".FILENAME_PERSONAL_FORM);
if ($error==1)
 {
 $personal_result['name']=bx_js_stripslashes($HTTP_POST_VARS['jname']);
 $personal_result['address']=bx_stripslashes($HTTP_POST_VARS['address']);
 $personal_result['city']=bx_js_stripslashes($HTTP_POST_VARS['city']);
 $personal_result['state']=bx_js_stripslashes($HTTP_POST_VARS['state']);
 $personal_result['province']=bx_js_stripslashes($HTTP_POST_VARS['province']);
 $personal_result['postalcode']=$HTTP_POST_VARS['postalcode'];
 $personal_result['locationid']=$HTTP_POST_VARS['location'];
 $personal_result['phone']=bx_js_stripslashes($HTTP_POST_VARS['phone']);
 $personal_result['gender']=$HTTP_POST_VARS['gender'];
 $personal_result['birthyear']=$HTTP_POST_VARS['birthyear'];
 $personal_result['email']=$HTTP_POST_VARS['email'];
 $personal_result['url']=bx_js_stripslashes($HTTP_POST_VARS['url']);
 $personal_result['password']=$HTTP_POST_VARS['password'];
 $personal_result['confpassword']=$HTTP_POST_VARS['confpassword'];
 $personal_result['hide_name']=$HTTP_POST_VARS['hide_name'];
 $personal_result['hide_address']=$HTTP_POST_VARS['hide_address'];
 $personal_result['hide_location']=$HTTP_POST_VARS['hide_location'];
 $personal_result['hide_phone']=$HTTP_POST_VARS['hide_phone'];
 $personal_result['hide_email']=$HTTP_POST_VARS['hide_email'];
 $personal_result['agree']=$HTTP_POST_VARS['agree'];
 }
?>
<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_PERSONAL, "auth_sess", $bx_session);?>" method="post" name="frmPerson" onSubmit="return check_form();">
  <INPUT type="hidden" name="action" value="pers_update">
  <INPUT type="hidden" name="validation" value="true">
  <?php
  if ($HTTP_POST_VARS['new_account'] || $HTTP_GET_VARS['action']=="new") {
         echo "<input type=\"hidden\" name=\"new_account\" value=\"true\">";
  }
  if ($error==0)
  {
  ?>
    <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
   <TR bgcolor="#FFFFFF">
      <TD colspan="5" width="100%" align="center" class="headertdjob"><?php echo TEXT_PERSONAL_INFORMATION;?></TD>
   </TR>
   <TR><TD colspan="5"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
   </TR>
   <TR>
      <TD colspan="2" bgcolor="<?php echo TABLE_BGCOLOR;?>" valign="top" width="100%" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><i><?php echo TEXT_ABOUT;?></i></b></font></TD>
    </TR>
    <TR>
      <TD colspan="2" bgcolor="<?php echo TABLE_BGCOLOR;?>" valign="top" width="100%" align="right"> <?php echo REQUIRED_STAR;?><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"> - <?php echo TEXT_REQUIRED_FIELD;?>.</font></TD>
    </TR>
   <?php
    } //end if error==0
    else
    {
        echo bx_table_header(ERRORS_OCCURED);
        echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";
        if ($name_error=="1") echo NAME_ERROR."<br>";
        if ($birthyear_error=="1" && ENTRY_BIRTHYEAR_LENGTH!=0) echo BIRTH_YEAR_ERROR."<br>";
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
      <TR><TD colspan="2">&nbsp;</TD></TR>
    <tr>
         <TD colspan="2" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_PERSONAL_INFORMATION;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_JOBSEEKER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
           </TR>
          </TABLE>
         </TD>
    </tr>
    <TR><TD colspan="2">&nbsp;</TD></TR>
    <?php if(ASK_GENDER_INFO=="yes"){?>
     <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_GENDER;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="radio" name="gender" class="radio" value="M" <?php if ((!$personal_result['gender']) || ($personal_result['gender']=='M')) {echo "checked";}?>><?php echo TEXT_MALE;?>
        <INPUT type="radio" name="gender" class="radio" value="F" <?php if ($personal_result['gender']=='F') {echo "checked";}?>><?php echo TEXT_FEMALE;?></FONT>
      </TD>
    </TR>
    <?php }?>
    <TR>
      <TD valign="top" width="25%">
        <?php if($name_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_NAME;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="jname" size="30"
        value="<?php echo $personal_result['name'];?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <?php if(ENTRY_BIRTHYEAR_LENGTH!=0){?>
     <TR>
      <TD valign="top" width="25%">
        <?php if($birthyear_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_BIRTH_YEAR;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="birthyear" size="4" maxlength="4"
        value="<?php echo $personal_result['birthyear'];?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <?php }?>
    <TR>
      <TD valign="top" width="25%">
        <?php if($address_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_ADDRESS;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name="address" rows="3" cols="30"><?php echo $personal_result['address'];?></textarea></FONT> <?php echo REQUIRED_STAR;?>
     </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <?php if($city_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="city" size="30"
        value="<?php echo $personal_result['city'];?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <?php if($postalcode_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_POSTAL_CODE;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="postalcode" size="10"
        value="<?php echo $personal_result['postalcode'];?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
   <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="province" size="10"
        value="<?php echo $personal_result['province'];?>"></FONT>
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
          if ($personal_result['locationid']==$country_result['locationid']) {echo "selected";}
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
           <td bgcolor="<?php echo TABLE_JOBSEEKER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
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
        value="<?php echo $personal_result['phone'];?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <?php if($email_error=="1" || $allready_email_error == "1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_EMAIL;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="email" size="30"
        value="<?php echo $personal_result['email'];?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_URL;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="url" size="30"
        value="<?php echo $personal_result['url'];?>"></FONT>
      </TD>
    </TR>
    <TR><TD colspan="2">&nbsp;</TD></TR>
    <TR><TD colspan="2"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><?=TEXT_HIDE_NOTE?></font></TD></TR>
    <TR><TD colspan="2">&nbsp;</TD></TR>
    <TR>
      <TD valign="top" width="25%">&nbsp;</TD>
      <TD width="75%"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><input type="checkbox" class="radio" name="hide_name" value="yes"<?if ($personal_result['hide_name'] == "yes") { echo " checked";}?>> <?=TEXT_HIDE_NAME?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">&nbsp;</TD>
      <TD width="75%"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><input type="checkbox" class="radio" name="hide_address" value="yes"<?if ($personal_result['hide_address'] == "yes") { echo " checked";}?>> <?=TEXT_HIDE_ADDRESS?></font></TD>
    </TR>
     <TR>
      <TD valign="top" width="25%">&nbsp;</TD>
      <TD width="75%"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><input type="checkbox" class="radio" name="hide_location" value="yes"<?if ($personal_result['hide_location'] == "yes") { echo " checked";}?>> <?=TEXT_HIDE_LOCATION?></font></TD>
    </TR>
     <TR>
      <TD valign="top" width="25%">&nbsp;</TD>
      <TD width="75%"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><input type="checkbox" class="radio" name="hide_phone" value="yes"<?if ($personal_result['hide_phone'] == "yes") { echo " checked";}?>> <?=TEXT_HIDE_PHONE?></font></TD>
    </TR>
     <TR>
      <TD valign="top" width="25%">&nbsp;</TD>
      <TD width="75%"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><input type="checkbox" class="radio" name="hide_email" value="yes"<?if ($personal_result['hide_email'] == "yes") { echo " checked";}?>> <?=TEXT_HIDE_EMAIL?></font></TD>
    </TR>
    <TR><TD colspan="2">&nbsp;</TD></TR>
    <tr>
         <TD colspan="2" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_LOGIN_INFORMATION;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_JOBSEEKER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
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
        value="<?php echo bx_js_stripslashes($personal_result['password']);?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="35%">
        <?php if($confpassword_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_CONFIRM_PASSWORD;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="password" name="confpassword" size="10"
        value="<?php if($error==1) {echo bx_js_stripslashes($personal_result['confpassword']);} else {echo bx_js_stripslashes($personal_result['password']);}?>"></FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <?php if(!$HTTP_SESSION_VARS['userid']){?>
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