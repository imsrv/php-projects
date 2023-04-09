<?php
include(DIR_LANGUAGES.$language."/".FILENAME_EMPLOYER_FORM);
$company_query=bx_db_query("select * from ".$bx_table_prefix."_companies,".$bx_table_prefix."_companycredits where ".$bx_table_prefix."_companies.compid='".$HTTP_SESSION_VARS['employerid']."' and ".$bx_table_prefix."_companycredits.compid=".$bx_table_prefix."_companies.compid");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$company_result=bx_db_fetch_array($company_query);
$resumemail_query=bx_db_query("select * from ".$bx_table_prefix."_resumemail where compid='".$HTTP_SESSION_VARS['employerid']."'");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
if(bx_db_num_rows($resumemail_query)!=0) {
              $resumemail_exist="true";
              $resumemail_result=bx_db_fetch_array($resumemail_query);
}//end if(bx_db_num_rows($resumemail_query)!=0)
else {
              $resumemail_exist="false";
}//end else if(bx_db_num_rows($resumemail_query)!=0)
?>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR bgcolor="#FFFFFF">
      <TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_MYCOMPANY;?></TD>
    </TR>
    <TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
    </TR>
    <TR>
      <TD bgcolor="<?php echo TABLE_BGCOLOR;?>" valign="top" width="100%" colspan="2" align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><i><?php echo TEXT_YOU_CAN_MODIFY;?></i></b></FONT><br><br>
      </TD>
    </TR>
    <TR bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>">
      <TD align="center" valign="middle" width="100%" colspan="2" style="border: 1px solid #000000">
        <font face="<?php echo HEADING_FONT_FACE;?>" size="<?php echo HEADING_FONT_SIZE;?>" color="<?php echo HEADING_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY_INFORMATIONS;?></B></FONT>
      </TD>
    </TR>
    <TR>
     <TD colspan="2"><hr></TD>
    </TR>
    <TR><TD width="40%" valign="top"><TABLE width="100%" cellpadding="2" cellspacing="5" border="0"><TR>
      <TD align="center">
       <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php
       $image_location = DIR_LOGO. $company_result['logo'];
       if ((!empty($company_result['logo'])) && (file_exists($image_location))) {
                  echo "<img src=\"".HTTP_LOGO.$company_result['logo']."?ref=".time()."\" border=1 align=absmiddle>";
       }//end if (file_exists($image_location))
       else {
                 echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\"><b>".TEXT_LOGO_NOT_AVAILABLE."</b></font>";
       }//end else if (file_exists($image_location))
       ?></font>
      </TD>
      </TR>
	  <TR>
        <TD valign="top" class="compdesc"><?php echo bx_textarea($company_result['description']);?></TD>
       </TR></TABLE></TD>
	<TD valign="top"><TABLE border="0" width="100%" cellpadding="3" cellspacing="2" bgcolor="<?php echo TABLE_BGCOLOR;?>">
	<tr>
	   <td>
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
            <b><?php echo TEXT_COMPANY_NAME;?>:</b>
           </font>
       </td>
       <td>
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
            <?php echo $company_result['company'];?>
           </font>
       </td>
    </tr>
    <tr>
       <td>
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
            <b><?php echo TEXT_COMPANY_ADDRESS;?>:</b>
           </font>
       </td>
       <td>
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
            <?php if($company_result['hide_address']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {?><?php echo $company_result['address'];?> , <?php echo !empty($company_result['postalcode'])?$company_result['postalcode']:"-";?> <?php echo !empty($company_result['city'])?$company_result['city']:"-";?> , <?php echo !empty($company_result['province'])?$company_result['province']:"-";?><?php };?>
           </font>
       </td>
    </tr>
    <tr>
       <td>
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
            <b><?php echo TEXT_COMPANY_LOCATION;?>:</b>
           </font>
       </td>
       <td>
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
            <?php
            if($company_result['hide_location']=="yes") {
                echo TEXT_HIDDEN_INFORMATION;
            }
            else {
                $location_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng." where locationid='".$company_result['locationid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                $location_result=bx_db_fetch_array($location_query);
                if ($location_result['locationid']!="-")
                {
                    echo $location_result['location'];
                }
            }    
            ?>
           </font>
       </td>
    </tr>
    <tr>
       <td>
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
            <b><?php echo TEXT_COMPANY_PHONE;?>:</b>
           </font>
       </td>
       <td>
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
            <?php if($company_result['hide_phone']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $company_result['phone'];}?> , <?php if($company_result['hide_fax']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo !empty($company_result['fax'])?$company_result['fax']:"-";}?>
           </font>
       </td>
    </tr>
    <tr>
       <td>
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
            <b><?php echo TEXT_COMPANY_EMAIL;?>:</b>
           </font>
       </td>
       <td>
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
            <?php if($company_result['hide_email']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {?><A href="mailto:<?php echo $company_result['email'];?>" class="featured"><?php echo $company_result['email'];?></A><?php };?> , <?php
            if(!empty($company_result['url'])) {
                echo "<a href=\"";
                if (!strstr($company_result['url'], "http://")) {
                    echo "http://".eregi_replace("/$", "" ,$company_result['url']);
                }
                else {
                    echo $company_result['url'];
                }
                echo "\" target=\"_blank\" class=\"featured\">".$company_result['url']."</a>";
           }     
           else {
             echo "-";        
           }?>
           </font>
       </td>
    </tr>
    <TR>
      <TD align="center" colspan="2"><br>
        <form action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_COMPANY."?action=comp_form", "auth_sess", $bx_session);?>" method="post"><input type="submit" name="go" value="<?php echo TEXT_MODIFY_PROFILE;?>"></form>
      </TD>
    </TR>
  </TABLE></TD></TR>
  <tr>
   <td colspan="2"><hr></td>
  </tr>
  <tr>
   <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_RESUME_MAIL;?></b></font></td>   
 </tr>
 <tr>
   <td colspan="2"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo TEXT_RESUMEMAIL_NOTE;?></font></td>   
 </tr>
 <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_MYCOMPANY, "auth_sess", $bx_session);?>" method="post" name="myresume">
  <input type="hidden" name="action" value="resumemail"> 
  <tr>
      <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" width="100%">
	  <tr><td width="30%">&nbsp;</td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
          <?php
          $i=1;
           while (${TEXT_JOBMAIL_OPT.$i})
            {
             echo '<input type=radio class="radio" name="resumemail_type" value="'.$i.'"';
                    if ($i=='1')
                     {
                      if ($resumemail_exist=="false") {
                         echo " checked";
                       }// end if ($resumemail_exist=="false")
                     }//end if ($i==1)

                    if ($i==$resumemail_result['resumemail_type'])
                       {
                        echo " checked";
                        }
                        echo '>'.${TEXT_JOBMAIL_OPT.$i}.'<br>';
                        $i++;
                        }
                     ?>
           </font>
       </td>
       <?php if(MULTILANGUAGE_SUPPORT == "on") {?>
       <td width="30%" valign="bottom">&nbsp;</td>
       </tr>
       <tr><td colspan="3">&nbsp;</td></tr>
       <tr>
           <td valign="top" width="30%">&nbsp;<font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_RESUMEMAIL_LANGUAGE;?></font></td>
           <td valign="top"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
           <?php
              $dirs = getFolders(DIR_LANGUAGES);
              for ($i=0; $i<count($dirs); $i++) {
                   if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                          echo "<input type=\"radio\" name=\"rmail_lang\" value=\"".$dirs[$i]."\" class=\"radio\"";
                          if($resumemail_result['rmail_lang'] != "") {
                                  if($resumemail_result['rmail_lang'] == $dirs[$i]) {
                                      echo " checked";
                                  }
                          }
                          else {
                                  if($language == $dirs[$i]) {
                                      echo " checked";
                                  }
                          }        
                          echo ">".$dirs[$i]."<br>";
                   }
              }
           ?>
           </font>
           </td>
          <?php }else{?> 
            <input type="hidden" name="rmail_lang" value="<?php echo DEFAULT_LANGUAGE;?>">
          <?php }?>
           <td width="30%" valign="bottom">&nbsp;<input type="submit" name="upd" value="Update"></td>
       </tr>
       <tr><td></td></tr>
       </table>
	   </td>
     </tr>
	 </form>
	<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_MYCOMPANY, "auth_sess", $bx_session);?>" method="post" enctype="multipart/form-data" name="myCompany">
  <INPUT type="hidden" name="action" value="mycompany">
  <tr>
   <td colspan="2"><hr></td>
  </tr>
  <TR>
      <TD valign="top" width="40%">
       <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_UPLOAD_LOGO;?></b></font>
       <font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><br><?php echo TEXT_UPLOAD_LOGO_DESCRIPTION;?></font>
      </TD>
      <TD valign="top" width="70%">
       <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="file" name="company_logo" size="20"></font>
      </TD>
    </TR>
    <TR>
      <TD colspan="2" width="100%" align="center"><br><INPUT type="submit" name="save" value="<?php echo TEXT_SAVE_DESCRIPTION_UPLOAD_LOGO;?>"></TD>
    </TR>
    <TR>
     <TD colspan="2" width="100%" align="center"><br><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_CLICK_TO_SEE_DESCRIPTION_PAGE;?>:<br>
       <a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?company_id=".$HTTP_SESSION_VARS['employerid'], "auth_sess", $bx_session);?>"><?php echo HTTP_SERVER.FILENAME_VIEW;?>?company_id=<?php echo $HTTP_SESSION_VARS['employerid'];?></a></font>
     </TD>
    </TR>
    <TR><TD colspan="2"><br><hr><br></TD></TR>
    </form>
</table>