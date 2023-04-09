<?php include(DIR_LANGUAGES.$language."/".FILENAME_ADMIN_FORM);?>
<script language="Javascript" src="calendar.js"></script>
<?php
 if (($HTTP_GET_VARS['action']=="upgrades") and ($HTTP_GET_VARS['compid']))
 {
  $actual_query=bx_db_query("select * from ".$bx_table_prefix."_membership,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_membership.compid='".$HTTP_GET_VARS['compid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_membership.pricing_id");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $actual_result=bx_db_fetch_array($actual_query);
  $desired_query=bx_db_query("select * from ".$bx_table_prefix."_pricing_".$bx_table_lng.",".$bx_table_prefix."_invoices where ".$bx_table_prefix."_invoices.compid='".$HTTP_GET_VARS['compid']."' and ".$bx_table_prefix."_invoices.opid = '".$HTTP_GET_VARS['opid']."' and ".$bx_table_prefix."_invoices.op_type='1' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $desired_result=bx_db_fetch_array($desired_query);
  $cc_transaction_query = bx_db_query("select * from ".$bx_table_prefix."_cctransactions where opid = '".$HTTP_GET_VARS['opid']."'");
  if(bx_db_num_rows($cc_transaction_query) > 0) {
      $cc_transaction = true;
      $cc_transaction_result = bx_db_fetch_array($cc_transaction_query);
  }
  else {
      $cc_transaction = false;
  }
    ?>
  <form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_VALIDATION;?>" method="post" name="upgrades">
   <input type="hidden" name="actual_pricing" value="<?php echo $actual_result['pricing_id'];?>">
   <input type="hidden" name="opid" value="<?php echo $HTTP_GET_VARS['opid'];?>">
   <input type="hidden" name="desired_pricing" value="<?php echo $desired_result['pricing_id'];?>">
   <table width="100%" cellspacing="0" cellpadding="2" border="0">
   <tr>
         <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Upgrade details</b></font></td>
   </tr>
   <tr>
    <td bgcolor="#000000">
      <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
      <TR><TD colspan="2"><h2><?php echo TEXT_CURRENT_MEMBERSHIP." : ".$actual_result['pricing_title'];?></h2></TD></TR>
      <TR><TD colspan="2"><h2><?php echo TEXT_DESIRED_MEMBERSHIP." : ".$desired_result['pricing_title'];?></h2></TD></TR>
      <tr>
            <td colspan="2"><a href="javascript:myopen('<?php echo HTTP_SERVER_ADMIN."view.php?action=details&opid=".$HTTP_GET_VARS['opid'];?>', 600, 500);">View Invoice details</a></td>	  
      </tr> 
      <tr>
         <td align="right" width="40%"><?php echo TEXT_DATE_ADDED;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><input type="text" name="date_added" size="10" value="<?php echo date('Y-m-d');?>">&nbsp;<a href="javascript:show_calendar('upgrades.date_added');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
         </td>
       </tr>
       <tr>
         <td align="right"><?php echo TEXT_DATE_PAYMENT;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><input type="text" name="pdate_added" size="10" value="<?php echo date('Y-m-d');?>">&nbsp;
         <a href="javascript:show_calendar('upgrades.pdate_added');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
         </td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_INFO;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo nl2br($desired_result['info']);?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_DESCRIPTION;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><textarea name="description" cols="50" rows="6"></textarea></td>
       </tr>
       <?php
   if($cc_transaction == true) {
   include(DIR_FUNCTIONS."cclib/class.rc4crypt.php");
   include(DIR_SERVER_ROOT."cc_payment_settings.php");   
   $decoder=new rc4crypt();   
   if(ENABLE_SSL == "yes" && $HTTP_SERVER_VARS['HTTPS']!='on') {
       echo "<tr><td align=\"center\" colspan=\"2\">".TEXT_EXPLAIN_SENSITIVE_DATA."<br><a href=\"".eregi_replace(HTTP_SERVER,HTTPS_SERVER, HTTP_SERVER_ADMIN."details.php?action=buyers&compid=".$HTTP_GET_VARS['compid']."&opid=".$HTTP_GET_VARS['opid'])."\">Reload in a SSL enabled Page.</a></td></tr>";
   }
   else {
       ?>
       <tr>
           <td colspan="2"><hr></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_TRANSACTION_NUMBER;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $cc_transaction_result['transid'];?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_INVOICE_NUMBER;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $cc_transaction_result['opid'];?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_CC_NAME;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_name'],"de");?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_CC_TYPE;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_type'],"de");?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_CC_NUM;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_num'],"de");?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_CC_VERIFICATION_CODE;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_cvc'],"de");?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_CC_EXPIRE;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_exp'],"de");?></td>
       </tr>
       <?php
       if(CC_AVS == "yes") {
           ?>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_STREET;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_street'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_CITY;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_city'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_STATE;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_state'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_ZIP;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_zip'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_COUNTRY;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_country'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_PHONE;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_phone'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_EMAIL;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_email'],"de");?></td>
           </tr>
           <?php
          }
       ?>
       <tr>
           <td colspan="2"><hr></td>
       </tr>
       <?php   
       }    
   }
   ?>
        <tr>
         <td align="right"><?php echo TEXT_PAYMENT_MODE;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><select name="payment_mode">
           <?php $i=1;
            while (${TEXT_PAYMENT_OPT.$i}) {
             echo '<option value="'.$i.'"';
             if ($i == $desired_result['payment_mode']) {
                 echo " selected";
             }
             echo '>'.${TEXT_PAYMENT_OPT.$i}.'</option>';
             $i++;
             }
           ?>
           </select>
         </td>
       </tr>
       <tr>
            <td align="right" valign="middle"><font face="Verdana, Arial" size="1"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_NOVALIDATION;?>?action=<?php echo $HTTP_GET_VARS['action'];?>&compid=<?php echo $HTTP_GET_VARS['compid'];?>&opid=<?php echo $HTTP_GET_VARS['opid'];?>"><?php echo bx_image(HTTP_IMAGES.$language."/decline.gif",1,"DECLINE");?></a></font></td>
            <td valign="middle"><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/validate.gif",0,"Validate");?> </td>
       </tr>
       </table>
      </td>
   </tr>
   </table>
   <input type="hidden" name="compid" value="<?php echo $HTTP_GET_VARS['compid'];?>">
   <input type="hidden" name="action" value="<?php echo $HTTP_GET_VARS['action'];?>">
   </form>
 <?php
}//end if action upgrades
if (($HTTP_GET_VARS['action']=="buyers") and ($HTTP_GET_VARS['compid']))
 {
  $actual_query=bx_db_query("select * from ".$bx_table_prefix."_membership,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_membership.compid='".$HTTP_GET_VARS['compid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_membership.pricing_id");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $actual_result=bx_db_fetch_array($actual_query);
  $actual_invoice_query=bx_db_query("select * from ".$bx_table_prefix."_invoices where ".$bx_table_prefix."_invoices.compid='".$HTTP_GET_VARS['compid']."' and ".$bx_table_prefix."_invoices.opid='".$HTTP_GET_VARS['opid']."'");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $actual_invoice_result=bx_db_fetch_array($actual_invoice_query);
  $cc_transaction_query = bx_db_query("select * from ".$bx_table_prefix."_cctransactions where opid = '".$HTTP_GET_VARS['opid']."'");
  if(bx_db_num_rows($cc_transaction_query) > 0) {
      $cc_transaction = true;
      $cc_transaction_result = bx_db_fetch_array($cc_transaction_query);
  }
  else {
      $cc_transaction = false;
  }
  ?>
  <form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_VALIDATION;?>" method="post" name="buyers">
   <input type="hidden" name="compid" value="<?php echo $HTTP_GET_VARS['compid'];?>">
   <input type="hidden" name="opid" value="<?php echo $HTTP_GET_VARS['opid'];?>">
   <input type="hidden" name="action" value="<?php echo $HTTP_GET_VARS['action'];?>">
   <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Additional job purchase details</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
     <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%"><tr><td colspan="2" align="center"><h2><?php echo TEXT_CURRENT_MEMBERSHIP." : ".$actual_result['pricing_title'];?></h2></td></tr>
  <tr>
		<td colspan="2"><a href="javascript:myopen('<?php echo HTTP_SERVER_ADMIN."view.php?action=details&opid=".$HTTP_GET_VARS['opid'];?>', 600, 500);">View Invoice details</a></td>	  
  </tr> 
  <tr>
     <td align="right" width="40%"><?php echo TEXT_DATE_ADDED;?>:&nbsp;&nbsp;&nbsp;</td>
     <td><input type="text" name="date_added" size="10" value="<?php echo date('Y-m-d');?>">&nbsp;<a href="javascript:show_calendar('buyers.date_added');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
     </td>
   </tr>
   <tr>
     <td align="right"><?php echo TEXT_DATE_PAYMENT;?>:&nbsp;&nbsp;&nbsp;</td>
     <td><input type="text" name="pdate_added" size="10" value="<?php echo date('Y-m-d');?>">&nbsp;<a href="javascript:show_calendar('buyers.pdate_added');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
     </td>
   </tr>
   <tr>
     <td align="right" valign="top"><?php echo TEXT_INFO;?>:&nbsp;&nbsp;&nbsp;</td>
     <td><?php echo nl2br($actual_invoice_result['info']);?></td>
   </tr>
   <tr>
     <td align="right" valign="top"><?php echo TEXT_DESCRIPTION;?>:&nbsp;&nbsp;&nbsp;</td>
     <td><textarea name="description" rows="6" cols="50"></textarea></td>
   </tr>
   <?php
   if($cc_transaction == true) {
   include(DIR_FUNCTIONS."cclib/class.rc4crypt.php");
   include(DIR_SERVER_ROOT."cc_payment_settings.php");   
   $decoder=new rc4crypt();   
   if(ENABLE_SSL == "yes" && $HTTP_SERVER_VARS['HTTPS']!='on') {
       echo "<tr><td align=\"center\" colspan=\"2\">".TEXT_EXPLAIN_SENSITIVE_DATA."<br><a href=\"".eregi_replace(HTTP_SERVER,HTTPS_SERVER, HTTP_SERVER_ADMIN."details.php?action=buyers&compid=".$HTTP_GET_VARS['compid']."&opid=".$HTTP_GET_VARS['opid'])."\">Reload in a SSL enabled Page.</a></td></tr>";
   }
   else {
       ?>
       <tr>
           <td colspan="2"><hr></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_TRANSACTION_NUMBER;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $cc_transaction_result['transid'];?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_INVOICE_NUMBER;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $cc_transaction_result['opid'];?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_CC_NAME;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_name'],"de");?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_CC_TYPE;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_type'],"de");?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_CC_NUM;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_num'],"de");?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_CC_VERIFICATION_CODE;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_cvc'],"de");?></td>
       </tr>
       <tr>
         <td align="right" valign="top"><?php echo TEXT_CC_EXPIRE;?>:&nbsp;&nbsp;&nbsp;</td>
         <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_exp'],"de");?></td>
       </tr>
       <?php
       if(CC_AVS == "yes") {
           ?>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_STREET;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_street'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_CITY;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_city'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_STATE;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_state'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_ZIP;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_zip'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_COUNTRY;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_country'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_PHONE;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_phone'],"de");?></td>
           </tr>
           </tr>
             <td align="right" valign="top"><?php echo TEXT_CC_EMAIL;?>:&nbsp;&nbsp;&nbsp;</td>
             <td><?php echo $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_email'],"de");?></td>
           </tr>
           <?php
          }
       ?>
       <tr>
           <td colspan="2"><hr></td>
       </tr>
       <?php   
       }    
   }
   ?>
   <tr>
     <td align="right"><?php echo TEXT_PAYMENT_MODE;?>:&nbsp;&nbsp;&nbsp;</td>
     <td><select name="payment_mode">
       <?php $i=1;
            while (${TEXT_PAYMENT_OPT.$i}) {
             echo '<option value="'.$i.'"';
             if ($i == $actual_invoice_result['payment_mode']) {
                 echo " selected";
             }
             echo '>'.${TEXT_PAYMENT_OPT.$i}.'</option>';
             $i++;
             }
           ?>
       </select>
     </td>
   </tr>
    <tr>
      <td align="right"><font face="Verdana, Arial" size="1"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_NOVALIDATION;?>?action=<?php echo $HTTP_GET_VARS['action'];?>&compid=<?php echo $HTTP_GET_VARS['compid'];?>&opid=<?php echo $HTTP_GET_VARS['opid'];?>"><?php echo bx_image(HTTP_IMAGES.$language."/decline.gif",0,"DECLINE");?></a></font></td>
      <td><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/validate.gif",0,"Validate");?> </td>
   </tr>
   </table></td></tr></table>
   </form>
<?php
 }// end if action buyers
?>
<?php
 if (($HTTP_GET_VARS['action']=="details") and ($HTTP_GET_VARS['compid']))
 {
  $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies, ".$bx_table_prefix."_companycredits where ".$bx_table_prefix."_companies.compid='".$HTTP_GET_VARS['compid']."' and ".$bx_table_prefix."_companycredits.compid = ".$bx_table_prefix."_companies.compid");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $company_result=bx_db_fetch_array($company_query);
  ?>
  <form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_VALIDATION;?>" method="post" enctype="multipart/form-data" name="company">
   <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Company details</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
     <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
    <TR>
      <TD>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY_FEATURED;?></B></FONT>
      </TD>
     <TD>
        No<input type="radio" name="featured" class="radio" value="0" <?php if((!$company_result['featured']) or ($company_result['featured']=='0')) {echo "checked";}?>>
        Yes<input type="radio" name="featured" class="radio" value="1" <?php if($company_result['featured']=='1') {echo "checked";}?>>
      </TD>
    </TR>
      <TR>
      <TD valign="top" width="25%" align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php
       $image_location = DIR_LOGO. $company_result['logo'];
       if ((!empty($company_result['logo'])) && (file_exists($image_location))) {
                  echo "<img src=\"".HTTP_LOGO.$company_result['logo']."\" border=1 align=absmiddle>";
                  echo "<br>&nbsp;&nbsp;[&nbsp;<a href=\"del_logo.php?compid=".$company_result["compid"]."&logo_name=".$company_result['logo']."\">Delete Logo</a>&nbsp;]";
       }//end if (file_exists($image_location))
       else {
                 echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\"><b>".TEXT_LOGO_NOT_AVAILABLE."</b></font>";
       }//end else if (file_exists($image_location))
       ?></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=file name=company_logo></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=text name=company size=30
        value="<?php echo $company_result['company'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DESCRIPTION;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name=description rows="5" cols="30"><?php echo $company_result['description'];?></textarea>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_ADDRESS;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name=address rows="3" cols="30"><?php echo $company_result['address'];?></textarea></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=text name=city size=30
        value="<?php echo $company_result['city'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type=text name=province size=15 value="<?php echo $company_result['province'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POSTAL_CODE;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="postalcode" size=10
        value="<?php echo $company_result['postalcode'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COUNTRY;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <SELECT name="location" size=1>
         <?php
          $country_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng);
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          while ($country_result=bx_db_fetch_array($country_query))
          {
          echo '<option value="'.$country_result['locationid'].'"';
          if ($company_result['locationid']==$country_result['locationid']) {echo "selected";}
          echo '>'.$country_result['location'].'</option>';
          }
          ?>
         </SELECT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PHONE;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="tex" name="phone" size=30
        value="<?php echo $company_result['phone'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_FAX;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="fax" size=30
        value="<?php echo $company_result['fax'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMAIL;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="email" size=30
        value="<?php echo $company_result['email'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_URL;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=text name=url size=30
        value="<?php echo $company_result['url'];?>"></FONT>
      </TD>
    </TR>
    <TR><TD colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_HIDE_NOTE;?></font></TD></TR>
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
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PASSWORD;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=password name=password size=30
        value="<?php echo bx_js_stripslashes($company_result['password']);?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONFIRM_PASSWORD;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=password name=confpassword size=30
        value="<?php if($error==1) {echo bx_js_stripslashes($company_result['confpassword']);} else {echo bx_js_stripslashes($company_result['password']);}?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_LAST_LOGIN;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php
           $mytime = strtotime($company_result['lastlogin'])-time();  
           if ($mytime<0) {
               $mytime = - $mytime;
               $sign = "-";
           } 
           else {
               $sign = "+";
           }
           if ($mytime>=86400) {
               echo $sign.(floor($mytime/(3600*24)))."d ";    
           }
           else {
               echo "+0d ";
           }
           if (($mytime%(3600*24))>=3600) {
               echo $sign.floor(($mytime%(3600*24))/3600)."h ";    
               echo $sign.floor(($mytime%(3600))/60)."m "; 
           }
           else {
               echo "+0h ";
               echo $sign.floor(($mytime%(3600))/60)."m ";    
           }
           print "&nbsp;/&nbsp;";
           echo $company_result['lastlogin'];?></b></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B>IP:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo $company_result['lastip'];?></b></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_AVAILABLE_JOBS;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="jobs" size=10
        value="<?php echo $company_result['jobs'];?>"> <b>999 = <?php echo TEXT_UNLIMITED;?></b></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_AVAILABLE_FJOBS;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="featuredjobs" size=10
        value="<?php echo $company_result['featuredjobs'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_AVAILABLE_RESUMES;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="contacts" size=10
        value="<?php echo $company_result['contacts'];?>"> <b>999 = <?php echo TEXT_UNLIMITED;?></b></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DISCOUNT;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="discount" size=10
        value="<?php echo $company_result['discount'];?>"></FONT>
      </TD>
    </TR>
    <?php
    $membership_query = bx_db_query("SELECT * from ".$bx_table_prefix."_membership where compid='".$company_result['compid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    $membership_result = bx_db_fetch_array($membership_query);
    $pricing_query = bx_db_query("SELECT * from ".$bx_table_prefix."_pricing_".$bx_table_lng." where pricing_id > 0");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    ?>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CURRENT_PLANNING;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <select name="pricing_id" size="1">
            <?php
            if (!($membership_result['pricing_id']>=0)) {
                echo "<option selected>".TEXT_NO_PLANNING."</option>";
            }
            while ($pricing_result = bx_db_fetch_array($pricing_query)) {
                if ($pricing_result['pricing_id'] == $membership_result['pricing_id']) {
                    $selected = " selected";
                }
                else {
                    $selected = "";
                }
                echo "<option value=\"".$pricing_result['pricing_id']."\"".$selected.">".$pricing_result['pricing_title']."</option>\n";
            }
            ?>
        </select>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PLANNING_EXPIRE;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="expire" size=10
        value="<?php echo $company_result['expire'];?>"></FONT>&nbsp;<a href="javascript:show_calendar('company.expire');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
      </TD>
    </TR>
    <TR>
      <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="reset" name="btnReset" value="<?php echo TEXT_BUTTON_RESET;?>">
        <INPUT type="submit" name="btnSave" value="<?php echo TEXT_BUTTON_SAVE;?>"></FONT></td>
      <TD align=right width="30%"><INPUT type=submit name="btnDelete" value="<?php echo TEXT_BUTTON_DELETE;?>" onClick="return confirm('<?php echo eregi_replace("'","\'",TEXT_CONFIRM_COMPANY_DELETE);?>');">
      </TD>
    </TR>
  </TABLE>
 </td></tr></table>
  <input type="hidden" name="compid" value="<?php echo $HTTP_GET_VARS['compid'];?>">
  <input type="hidden" name="action" value="<?php echo $HTTP_GET_VARS['action'];?>">
  <input type="hidden" name="back_url" value="<?php echo urlencode($HTTP_GET_VARS['back_url']);?>">  
</form>
 <?php
 }//end if action details
?>
<?php
 if (($HTTP_GET_VARS['action']=="details") and ($HTTP_GET_VARS['persid']))
 {
  $personal_query=bx_db_query("select * from ".$bx_table_prefix."_persons where ".$bx_table_prefix."_persons.persid='".$HTTP_GET_VARS['persid']."'");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $personal_result=bx_db_fetch_array($personal_query);
  ?>
  <form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_VALIDATION;?>" method="post">
 <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Person details</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
   <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
   <?php if(ASK_GENDER_INFO=="yes"){?>
     <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_GENDER;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="radio" class="radio" name="gender" value="M" <?php if ((!$personal_result['gender']) || ($personal_result['gender']=='M')) {echo "checked";}?>><?php echo TEXT_MALE;?>
        <INPUT type="radio" class="radio" name="gender" value="F" <?php if ($personal_result['gender']=='F') {echo "checked";}?>><?php echo TEXT_FEMALE;?></FONT>
      </TD>
    </TR>
    <?php }?>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_NAME;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="name" size="30"
        value="<?php echo $personal_result['name'];?>"></FONT>
      </TD>
    </TR>
    <?php if(ENTRY_BIRTHYEAR_LENGTH!=0){?>
     <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_BIRTH_YEAR;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="birthyear" size="4" maxlength="4"
        value="<?php echo $personal_result['birthyear'];?>"></FONT>
      </TD>
    </TR>
    <?php }?>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_ADDRESS;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="address" size="30"
        value="<?php echo $personal_result['address'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="city" size="30"
        value="<?php echo $personal_result['city'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POSTAL_CODE;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="postalcode" size="10"
        value="<?php echo $personal_result['postalcode'];?>"></FONT>
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
          $country_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng);
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
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PHONE;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="phone" size="30"
        value="<?php echo $personal_result['phone'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMAIL;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="email" size="30"
        value="<?php echo $personal_result['email'];?>"></FONT>
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
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PASSWORD;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="password" name="password" size="30"
        value="<?php echo bx_js_stripslashes($personal_result['password']);?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONFIRM_PASSWORD;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="password" name="confpassword" size="30"
        value="<?php if($error==1) {echo bx_js_stripslashes($personal_result['confpassword']);} else {echo bx_js_stripslashes($personal_result['password']);}?>"></FONT>
      </TD>
    </TR>
    <TR><TD colspan="2">&nbsp;</TD></TR>
    <TR><TD colspan="2"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><?=TEXT_HIDE_NOTE?></font></TD></TR>
    <TR>
      <TD valign="top" width="25%">&nbsp;</TD>
      <TD width="75%"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><input type="checkbox" class="radio" name="hide_name" value="yes"<?if ($personal_result['hide_name'] == "yes") { echo " checked";}?>> <?=TEXT_HIDE_NAME?></font></TD>
    </TR>
    <TR><TD valign="top" width="25%">&nbsp;</TD>
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
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_LAST_LOGIN;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php
           $mytime = strtotime($personal_result['lastlogin'])-time();  
           if ($mytime<0) {
               $mytime = - $mytime;
               $sign = "-";
           } 
           else {
               $sign = "+";
           }
           if ($mytime>=86400) {
               echo $sign.(floor($mytime/(3600*24)))."d ";    
           }
           else {
               echo "+0d ";
           }
           if (($mytime%(3600*24))>=3600) {
               echo $sign.floor(($mytime%(3600*24))/3600)."h ";    
               echo $sign.floor(($mytime%(3600))/60)."m "; 
           }
           else {
               echo "+0h ";
               echo $sign.floor(($mytime%(3600))/60)."m ";    
           }
           print "&nbsp;/&nbsp;";
           echo $personal_result['lastlogin'];?></b></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B>IP:</B></FONT>
      </TD>
      <TD width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo $personal_result['lastip'];?></b></FONT>
      </TD>
    </TR>
    <TR>
      <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="reset" name="btnReset" value="<?php echo TEXT_BUTTON_RESET;?>">&nbsp;&nbsp;<INPUT type="submit" name="btnSave" value="<?php echo TEXT_BUTTON_SAVE;?>"></FONT></td>
      <TD align="right" width="75%"><INPUT type=submit name=btnDelete value="<?php echo TEXT_BUTTON_DELETE;?>" onClick="return confirm('<?php echo eregi_replace("'","\'",TEXT_CONFIRM_JOBSEEKER_DELETE);?>');">
      </TD>
    </TR>
  </TABLE>
 </td></tr></table>
  <input type="hidden" name="persid" value="<?php echo $HTTP_GET_VARS['persid'];?>">
  <input type="hidden" name="action" value="<?php echo $HTTP_GET_VARS['action'];?>">
  <input type="hidden" name="back_url" value="<?php echo urlencode($HTTP_GET_VARS['back_url']);?>">
  </form>
 <?php
 }//end if action details
?>
<?php
 if (($HTTP_GET_VARS['action']=="details") and ($HTTP_GET_VARS['jobid']))
 {
  $job_query=bx_db_query("select * from ".$bx_table_prefix."_jobs where ".$bx_table_prefix."_jobs.jobid='".$HTTP_GET_VARS['jobid']."'");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $job_result=bx_db_fetch_array($job_query);
  ?>
  <form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_VALIDATION;?>" method="post" name="job">
     <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Job details</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
     <TABLE border="0" cellpadding="2" cellspacing="0" bgcolor="#00CCFF" width="100%">
    <?php if(USE_FEATURED_JOBS == "yes") {?> 
    <TR>
      <TD>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_FEATURED;?></B></FONT>
      </TD>
      <TD colspan="4">
        No<input type="radio" class="radio" name="featuredjob" value="N" <?php if((!$job_result['featuredjob']) or ($job_result['featuredjob']=='N')) {echo "checked";}?>>
        Yes<input type="radio" class="radio" name="featuredjob" value="Y" <?php if($job_result['featuredjob']=='Y') {echo "checked";}?>>
      </TD>
    </TR>
   <?php
   }
   else {
       ?>
       <input type="hidden" name="featuredjob" value="N">
       <?php
   }
   if (POSTING_LANGUAGE == "on") {
   ?>
    <TR>
      <TD valign="top" width=24%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POSTING_LANGUAGE;?>:</B></FONT>
      </TD>
      <TD colspan=4 width=76%>
        <SELECT name="languageid" size=1>
       <?php
          $i=1;
           while (${TEXT_LANGUAGE_KNOWN_OPT.$i})
            {
             echo '<option value="'.$i.'"';
                    if ($i==$job_result['postlanguage'])
                       {
                        echo "selected";
                        }
                        echo '>'.${TEXT_LANGUAGE_KNOWN_OPT.$i}.'</option>';
                        $i++;
                        }
       ?>
        </SELECT>
      </TD>
    </TR>
    <?php
    }
    ?>
    <TR>
      <TD  width=24%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_TITLE;?>:</B></FONT>
      </TD>
      <TD colspan=4 width=76%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="jobtitle" value="<?php echo $job_result['jobtitle'];?>" size="30">
        </FONT>
      </TD>
    </TR>
   <TR>
      <TD width=24%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_CATEGORY;?>:</B></FONT>
      </TD>
      <TD colspan=4 width=76%>
        <SELECT name="jobcategoryid" size=1>
        <?php
        $title_query=bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($title_result=bx_db_fetch_array($title_query))
        {
        echo '<option value="'.$title_result['jobcategoryid'].'"';
        if ($job_result['jobcategoryid']==$title_result['jobcategoryid']) {echo "selected";}
        echo '>'.$title_result['jobcategory'].'</option>';
        }
        ?>
        </SELECT>
    </TR>
    <TR>
      <TD  width="24%" valign="top">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_DESCRIPTION;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="76%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <TEXTAREA name="description" rows="3" cols="40"><?php echo $job_result['description'];?></TEXTAREA></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SKILL;?>:</B></FONT>
      </TD>
      <TD colspan="2" width="40%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name="skills" rows="3" cols="30"><?php echo $job_result['skills'];?></textarea>
        </FONT>
      </TD>
      <TD colspan="2" width="36%" valign="top">
            <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SKILL_EXAMPLE;?></FONT>
      </TD>
    </TR>
    <?php
    if (REQUIRED_LANGUAGE == "on") {
    ?>
    <TR>
      <TD colspan=5 width=100%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_LANGUAGE_REQUIREMENTS;?>:</B></FONT>
      </TD>
    </TR>
    <?php
    $i=1;
    while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
       echo "<TR><TD width=\"30%\"><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><B>".${TEXT_LANGUAGE_KNOWN_OPT.$i}.":</B></FONT></TD><TD width=\"70%\" nowrap colspan=\"4\">&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],(substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."1")))
       {
       echo " checked ";
       }
         echo " value=1>".TEXT_VERY_GOOD."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio  class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."2"))
       {
        echo " checked ";
       }
       echo   " value=2>".TEXT_GOOD."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."3"))
       {
       echo " checked ";
       }
       echo "  value=3>".TEXT_POOR."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."4"))
       {
       echo " checked ";
       }
       echo " value=4>".TEXT_NONE."</FONT></TD></TR>";
       $i++;
       }
    }
    ?>
    <TR>
      <TD  width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMPLOYMENT_TYPE;?>:</B></FONT>
      </TD>
     <TD colspan="4">
        <SELECT name="jobtypeids[]" multiple size="3">
        <?php
          $jobtype_query=bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng);
          while ($jobtype_result=bx_db_fetch_array($jobtype_query))
          {
          echo '<option value="'.$jobtype_result['jobtypeid'].'"';
          if (strstr($job_result['jobtypeids'],$jobtype_result['jobtypeid'])) {echo "selected";}
          echo '>'.$jobtype_result['jobtype'].'</option>';
          }
          ?>
        </SELECT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SALARY_RANGE;?>:</B></FONT>
      </TD>
      <TD valign=top width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=text name=salary size=7 value="<?php echo $job_result['salary'];?>">&nbsp;<B><?php echo PRICE_CURENCY;?></B></FONT>
      </TD>
      <TD colspan=3 valign=top width="60%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_INDICATE_SALARY;?></FONT>
      </TD>
    </TR>
     <TR>
      <TD valign=top width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EXPERIENCE;?>:</B></FONT>
      </TD>
      <TD valign=top width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=text name=experience size=7 value="<?php echo $job_result['experience'];?>"></FONT>
      </TD>
      <TD colspan=3 valign=top width="60%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_REQUIRED_EXPERIENCE;?></FONT>
      </TD>
    </TR>
    <TR>
      <TD  width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DEGREE_PREFERED;?>:</B></FONT>
      </TD>
     <TD width="25%">
        <SELECT name=degreeid size=1>
        <?php
          $i=1;
          while (${TEXT_DEGREE_OPT.$i}) {
                 echo '<option value="'.$i.'"';
                 if ($i == $job_result['degreeid']) {
                     echo " selected";
                 }
                 echo '>'.${TEXT_DEGREE_OPT.$i}.'</option>';
                 $i++;
          }
          ?>
        </SELECT>
      </TD>
      <TD colspan="3" valign=top width="50%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PREFERED_DEGREE;?></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COUNTRY;?>:</B></FONT>
      </TD>
      <TD width="75%" colspan="4">
        <SELECT name=location size=1>
        <?php
          $location_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng);
          while ($location_result=bx_db_fetch_array($location_query))
          {
          echo '<option value="'.$location_result['locationid'].'"';
          if ($job_result['locationid']==$location_result['locationid']) {echo "selected";}
          echo '>'.$location_result['location'].'</option>';
          }
          ?>
        </SELECT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
      </TD>
      <TD width="75%" colspan="4">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type=text name=province size=15 value="<?php echo $job_result['province'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD width="75%" colspan="4">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="city" size=30 value="<?php echo $job_result['city'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="55%" colspan="2">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_HIDE_COMPANY;?>:</B><br><?php echo TEXT_HIDE_COMPANY_NOTE;?></FONT>
      </TD>
      <TD colspan="3" width="45%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_compname" value="yes"<?php if($job_result['hide_compname'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
   </TR>
   <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_NAME;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="contact_name" size=30 value="<?php echo $job_result['contact_name'];?>"></FONT>
      </TD>
      <TD colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_contactname" value="yes"<?php if($job_result['hide_contactname'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_EMAIL;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="contact_email" size=30 value="<?php echo $job_result['contact_email'];?>"></FONT>
      </TD>
      <TD colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_contactemail" value="yes"<?php if($job_result['hide_contactemail'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_PHONE;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="contact_phone" size=15 value="<?php echo $job_result['contact_phone'];?>"></FONT>
      </TD>
      <TD colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_contactphone" value="yes"<?php if($job_result['hide_contactphone'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_FAX;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="contact_fax" size=15 value="<?php echo $job_result['contact_fax'];?>"></FONT>
      </TD>
      <TD colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_contactfax" value="yes"<?php if($job_result['hide_contactfax'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
    </TR>
    <?php if($job_result['compid']==0){?>
    <tr>
        <TD valign="top" width="25%">
        <font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><B>Job Link:</B></FONT>
      </TD>
      <TD width="75%" colspan="3">
        <font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>">
        <INPUT type="text" name="job_link" size=60 value="<?php echo $job_result['job_link'];?>"><?php if($job_result['job_link']!=""){ echo "&nbsp;<a href=\"".$job_result['job_link']."\" target=\"_blank\">View Link</a>";}?></FONT>
      </TD>
    </tr>
    <?php }?>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POST_DATE;?>:</B></FONT>
      </TD>
      <TD width="75%" colspan="4">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type=text name="jobdate" size="10" value="<?php echo $job_result['jobdate'];?>"></FONT>&nbsp;<a href="javascript:show_calendar('job.jobdate');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
      </TD>
    </TR>
    <TR>
      <TD valign=top width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_EXPIRE;?>:</B></FONT>
      </TD>
      <TD width="75%" colspan="4">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type=text name="jobexpire" size="10" value="<?php echo $job_result['jobexpire'];?>"></FONT>&nbsp;<a href="javascript:show_calendar('job.jobexpire');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
      </TD>
    </TR>
    <TR>
     <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="button" name="btnCancel" onclick="self.history.back()" value="<?php echo TEXT_BUTTON_CANCEL;?>">&nbsp;&nbsp;<INPUT type="submit" name="btnSave" value=" <?php echo TEXT_BUTTON_SAVE;?> "></FONT></td>
     <TD colspan="4" align="right" width="75%"><INPUT type="submit" name="btnDelete" value="<?php echo TEXT_BUTTON_DELETE;?>" onClick="return confirm('<?php echo eregi_replace("'","\'",TEXT_CONFIRM_JOB_DELETE);?>');"></TD>
    </TR>
  </TABLE>
</td></tr></table>
  <input type="hidden" name="jobid" value="<?php echo $HTTP_GET_VARS['jobid'];?>">
  <input type="hidden" name="action" value="<?php echo $HTTP_GET_VARS['action'];?>">
  <input type="hidden" name="back_url" value="<?php echo urlencode($HTTP_GET_VARS['back_url']);?>">
  </form>
 <?php
 }//end if action details
if (($HTTP_GET_VARS['action']=="details") and ($HTTP_GET_VARS['opid']))
 {
  $invoice_query=bx_db_query("select *,".$bx_table_prefix."_invoices.currency as icurrency from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.opid='".$HTTP_GET_VARS['opid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $invoice_result=bx_db_fetch_array($invoice_query);
  if ($HTTP_GET_VARS['printit']=="yes") {
    ?>
       <table bgcolor="#FFFFFF" width="100%" border="0" cellspacing="0" cellpadding="0">
       <TR><TD colspan="2"><hr></TD></TR>
       <TR bgcolor="#FFFFFF">
          <TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_INVOICE_DETAILS.$invoice_result['opid'].")";?></TD>
       </TR>
       <TR><TD colspan="2"><hr></TD></TR>
       </table>
       <table bgcolor="#FFFFFF" width="100%" border="0" cellspacing="0" cellpadding="2">
        <TR>
      <TD valign="top">
        <table bgcolor="#FFFFFF" width="100%" border="0" cellspacing="3" cellpadding="1">
        <TR>
           <td align="center" width="50%" valign="top">
                  <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td><B><?php echo TEXT_COMPANY_INFORMATION;?>:</B></td>
                  </tr>
                  <tr>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td><?php echo nl2br(COMPANY_INFORMATION);?></td>
                  </tr>
                  </table>
           </TD>
          <?php 
          $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies,".$bx_table_prefix."_locations_".$bx_table_lng." where compid='".$invoice_result['compid']."' and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_companies.locationid");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $company_result=bx_db_fetch_array($company_query);
          ?>
          <td align="center" width="50%" valign="top">
                  <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td><B><?php echo TEXT_BILLED_TO;?>:</B></td>
                  </tr>
                  <tr>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td><?php echo $company_result['company'];?><br><?php echo $company_result['address'];?><br><?php echo !empty($company_result['city'])?$company_result['city']:"-";?> , <?php echo !empty($company_result['province'])?$company_result['province']:"-";?><br><?php echo !empty($company_result['postalcode'])?$company_result['postalcode']:"-";?>, <?php echo $company_result['location'];?></td>
                  </tr>
                  </table>
           </TD>
          </TR>
        </TABLE>
       </TD>
       </TR>  
       <TR>
          <TD valign="top" align="center"><br>
            <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
               <TR>
                  <td align="center" colspan="2"><B><?php echo TEXT_INVOICE_INFORMATION;?>:</B></TD>
              </TR>
              <tr><td colspan="2">&nbsp;</tr>
              <TR>
               <td align="right"><?php echo TEXT_INVOICE_NUMBER;?>:</td><td><?php echo $invoice_result['opid'];?></TD>
              </TR>
              <TR>
               <td align="right"><?php echo TEXT_DATE_ADDED;?>:</td><td><?php echo $invoice_result['date_added'];?></TD>
              </TR>
              <TR>
              <TR>
               <td align="right"><?php echo TEXT_OPERATION_DESCRIPTION;?>:</td><td><B><?php if($invoice_result['pricing_type']==0) {echo $invoice_result['pricing_title'];} else {echo TEXT_UPGRADE." ".$invoice_result['pricing_title'];};?></b></TD>
              </TR>
              <TR>
               <td align="right"><?php echo TEXT_LIST_PRICE;?>:</td><td><?php echo bx_format_price($invoice_result['listprice'],$invoice_result['icurrency']);?></TD>
              </TR>
            <?php if(USE_DISCOUNT == "yes" || ($invoice_result['discount']!=0)) {?>
              <TR>
               <td align="right"><?php echo TEXT_DISCOUNT;?>:</td><td><?php echo bx_format_price((($invoice_result['listprice']*$invoice_result['discount'])/100),$invoice_result['icurrency'])." (".$invoice_result['discount']." %)";?></TD>
              </TR>
             <?php }?>
             <?php if(USE_VAT == "yes") {
                 if (USE_DISCOUNT == "yes" || ($invoice_result['discount']!=0)) {?>
                  <TR>
                   <td align="right"><?php echo TEXT_DISCOUNTED_PRICE;?>:</td><td><?php echo bx_format_price($invoice_result['listprice']-(($invoice_result['listprice']*$invoice_result['discount'])/100),$invoice_result['icurrency']);?></TD>
                  </TR>
                 <?php }?>
             <TR>
               <td align="right"><?php echo TEXT_VAT_PROCENT;?>:</td><td><?php echo bx_format_price(((($invoice_result['listprice']-($invoice_result['listprice']*$invoice_result['discount'])/100))*$invoice_result['vat']/100),$invoice_result['currency'])." (".$invoice_result['vat']." %)";?></TD>
             </TR> 
              <?php }?>
              <TR>
               <td align="right"><?php echo TEXT_TOTAL_PRICE;?>:</td><td><?php echo bx_format_price($invoice_result['totalprice'],$invoice_result['icurrency']);?></TD>
              </TR>
              <tr>
                  <td align="left" colspan="2">
                         <table width="100%" align="left" border="0" cellspacing="0" cellpadding="0">
                         <TR>
                               <td align="left"><br><B><?php echo TEXT_PAYMENT_INFORMATION;?>:</B></TD>
                         </TR>
                         <TR>
                               <td><br><?php echo nl2br(PAYMENT_INFORMATION);?></TD>
                              </TR>
                          <TR>
                          </table>
                  </td>
              </tr>
              <?php
               if ($invoice_result['paid']=="Y" && $invoice_result['validated']=="Y") {
                 ?>
                  <TR>
                   <TD colspan="2"><br><b><?php echo TEXT_INVOICE_PAID;?></b></TD>
                  </TR>
                  <TR>
                    <td colspan="2"><?php echo TEXT_PAYMENT_METHOD;?>: <B><?php echo ${TEXT_PAYMENT_OPT.$invoice_result['payment_mode']};?></b></TD>
                  </TR>
                  <?php
                    if($invoice_result['payment_mode'] == 1) {
                      $trans_query = bx_db_query("SELECT * from ".$bx_table_prefix."_cctransactions where opid = '".$invoice_result['opid']."'");
                      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                      if(bx_db_num_rows($trans_query)>0) {
                          $trans_result = bx_db_fetch_array($trans_query);
                              ?>
                                  <TR>
                                       <td colspan="2"><?php echo TEXT_TRANSACTION_NUMBER;?>: <B><?php echo $trans_result['transid'];?></B></TD>
                                  </TR>
                              <?php
                          }
                      }
                  ?>
                  <TR>
                    <td colspan="2"><?php echo TEXT_PAYMENT_DATE;?>: <B><?php echo bx_format_date($invoice_result['payment_date'], DATE_FORMAT);?></B></TD>
                  </TR>
                  <TR>
                    <td colspan="2"><?php echo TEXT_PAYMENT_DESCRIPTION;?>: <B><?php echo $invoice_result['description'];?></B></TD>
                  </TR>
                 <?php
                }//end if ($invoice_result['paid']=="Y" && $invoice_result['validated']=="Y")
              ?>
            </TABLE>
          </TD>
     </TR>
     </table>
    <?php    
    }
    else {
    ?>
    <form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_VALIDATION;?>" method="post">
       <table width="100%" cellspacing="0" cellpadding="2" border="0">
     <tr>
         <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Invoice details</b></font></td>
     </tr>
     <tr>
     <td bgcolor="#000000">
   <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
    <tr><td colspan="2" align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_PRINTER_FRIENDLY;?></b>&nbsp;&nbsp;</font><a href="javascript: ;" onmouseOver="window.status='<?php echo TEXT_PRINTER_FRIENDLY;?>'; return true;" onmouseOut="window.status=''; return true;" onClick="newwind = window.open('<?php echo HTTP_SERVER;?>print_version.php?url='+escape('<?php echo HTTP_SERVER_ADMIN."details.php";?>?action=<?php echo $HTTP_GET_VARS['action'];?>&opid=<?php echo $HTTP_GET_VARS['opid'];?>&printit=yes'),'_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=500,height=520,screenX=50,screenY=100');"><?php echo bx_image(HTTP_IMAGES.$language."/printit.gif",0,"");?></a></td></tr>
    <TR>
      <TD valign="top" colspan="2" bgcolor="#008080">
        <TABLE border="0" cellpadding="0" cellspacing="0" bgcolor="#008080" width="100%">
          <TR>
           <td align="center" width="50%" valign="top" bgcolor="#008080">
                  <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY_INFORMATION;?>:</B></FONT></td>
                  </tr>
                  <tr>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo nl2br(COMPANY_INFORMATION);?></FONT></td>
                  </tr>
                  </table>
           </TD>
          <?php 
          $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies,".$bx_table_prefix."_locations_".$bx_table_lng." where compid='".$invoice_result['compid']."' and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_companies.locationid");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $company_result=bx_db_fetch_array($company_query);
          ?>
          <td align="center" width="50%" valign="top" bgcolor="#008080">
                  <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_BILLED_TO;?>:</B></FONT></td>
                  </tr>
                  <tr>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo $company_result['company'];?><br><?php echo $company_result['address'];?><br><?php echo !empty($company_result['city'])?$company_result['city']:"-";?> , <?php echo !empty($company_result['province'])?$company_result['province']:"-";?><br><?php echo !empty($company_result['postalcode'])?$company_result['postalcode']:"-";?>, <?php echo $company_result['location'];?></FONT></td>
                  </tr>
                  </table>
           </TD>
          </TR>
        </TABLE>
      </TD>
      </TR>
      <TR>
      <TD valign="top" colspan="2" bgcolor="#008080" align="center"><TABLE border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#008080" width="100%">
           <TR>
              <td align="center" colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_INVOICE_INFORMATION;?>:</B></FONT></TD>
          </TR>
          <tr><td colspan="2">&nbsp;</tr>
          <TR>
           <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_INVOICE_NUMBER;?>:</font></td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo $invoice_result['opid'];?></FONT></TD>
          </TR>
          <TR>
           <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_OPERATION_DESCRIPTION;?>:</FONT></td><td><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><?php if($invoice_result['pricing_type']==0) {echo $invoice_result['pricing_title'];} else {echo TEXT_UPGRADE." ".$invoice_result['pricing_title'];}?></b></font></TD>
          </TR>
          <?php if($invoice_result['pricing_type']==0) {
                ?>
          <TR>
           <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_JOB_PURCHASE;?>:</td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo $invoice_result['jobs']." ".TEXT_JOB." (".bx_format_price($invoice_result['1job'],$invoice_result['icurrency'])."/".TEXT_JOB.")";?></font></TD>
          </TR>
          <?php if(USE_FEATURED_JOBS == "yes") {?>
          <TR>
           <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_FJOB_PURCHASE;?>:</td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo $invoice_result['featuredjobs']." ".TEXT_FEATURED_JOB." (".bx_format_price($invoice_result['1featuredjob'],$invoice_result['icurrency'])."/".TEXT_FEATURED_JOB.")";?></font></TD>
          </TR>
          <?php }?>
          <TR>
           <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SEARCH_PURCHASE;?>:</td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo $invoice_result['contacts']." ".TEXT_RESUME." (".bx_format_price($invoice_result['1contact'],$invoice_result['icurrency'])."/".TEXT_RESUME.")";?></font></TD>
          </TR>
           <?php
          }
          ?>
          <TR>
           <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_LIST_PRICE;?>:</font></td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoice_result['listprice'],$invoice_result['icurrency']);?></FONT></TD>
          </TR>
          <?php if(USE_DISCOUNT == "yes" || ($invoice_result['discount']!=0)) {?>
          <TR>
           <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_DISCOUNT;?>:</font></td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo bx_format_price((($invoice_result['listprice']*$invoice_result['discount'])/100),$invoice_result['icurrency'])." (".$invoice_result['discount']." %)";?></FONT></TD>
          </TR>
          <?php }?>
          <?php if(USE_VAT == "yes") {
              if (USE_DISCOUNT == "yes" || ($invoice_result['discount']!=0)) {?>
          <TR>
           <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_DISCOUNTED_PRICE;?>:</font></td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoice_result['listprice']-(($invoice_result['listprice']*$invoice_result['discount'])/100),$invoice_result['icurrency']);?></FONT></TD>
          </TR>
          <?php }?>
          <TR>
           <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_VAT_PROCENT;?>:</font></td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo bx_format_price(((($invoice_result['listprice']-($invoice_result['listprice']*$invoice_result['discount'])/100))*$invoice_result['vat']/100),$invoice_result['currency'])." (".$invoice_result['vat']." %)";?></FONT></TD>
          </TR>
          <?php }?>
          <TR>
           <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_TOTAL_PRICE;?>:</font></td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoice_result['totalprice'],$invoice_result['icurrency']);?></FONT></TD>
          </TR>
          <tr>
              <td align="left" colspan="2">
                     <table width="100%" align="left" border="0" cellspacing="0" cellpadding="0">
                     <TR>
                           <td align="left"><br><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PAYMENT_INFORMATION;?>:</B></FONT></TD>
                     </TR>
                     <TR>
                           <td><br><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo nl2br(PAYMENT_INFORMATION);?></FONT></TD>
                          </TR>
                      <TR>
                      </table>
              </td>
          </tr>
          <?php
           if ($invoice_result['paid']=="Y" && $invoice_result['validated']=="Y") {
          ?>
              <TR>
               <TD colspan="2"><br><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><b><?php echo TEXT_INVOICE_PAID;?></b></TD>
              </TR>
              <TR>
                <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PAYMENT_METHOD;?>: </FONT><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><?php echo ${TEXT_PAYMENT_OPT.$invoice_result['payment_mode']};?></b></FONT></TD>
              </TR>
              <?php
               if($invoice_result['payment_mode'] == 1) {
                      $trans_query = bx_db_query("SELECT * from ".$bx_table_prefix."_cctransactions where opid = '".$invoice_result['opid']."'");
                      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     if(bx_db_num_rows($trans_query)>0) {
                          $trans_result = bx_db_fetch_array($trans_query);
                          ?>
                              <TR>
                                   <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_TRANSACTION_NUMBER;?>: </FONT><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><?php echo $trans_result['transid'];?></B></font></TD>
                              </TR>
                          <?php
                      }
               }
            ?>
            <TR>
                <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PAYMENT_DATE;?>: </FONT><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><?php echo $invoice_result['payment_date'];?></B></FONT></TD>
             </TR>
             <TR>
                <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PAYMENT_DESCRIPTION;?>: </FONT><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><?php echo $invoice_result['description'];?></B></FONT></TD>
              </TR>
             <?php
            }//end if ($invoice_result['paid']=="Y")
        else {
         ?>
             <TR>
                  <TD colspan="2"><br><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><b><?php echo TEXT_INVOICE_NOTPAID;?></b></TD>
                </TR>
              <?php
          }
          ?>
        </TABLE>
      </TD>
    </TR>
    <TR>
     <td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="button" name="btnCancel" onclick="self.history.back()" value="<?php echo TEXT_BUTTON_CANCEL;?>"></td>
     <TD align="right" width="75%"><INPUT type="submit" name="btnDelete" value="<?php echo TEXT_BUTTON_DELETE;?>" onClick="return confirm('<?php echo eregi_replace("'","\'",TEXT_CONFIRM_INVOICE_DELETE);?>');"></TD>
    </TR>
        <input type="hidden" name="opid" value="<?php echo $HTTP_GET_VARS['opid'];?>">
        <input type="hidden" name="action" value="<?php echo $HTTP_GET_VARS['action'];?>">
        <input type="hidden" name="back_url" value="<?php echo urlencode($HTTP_GET_VARS['back_url']);?>">
 </TABLE>
</td></tr></table>
</form>
<?php
    }
}//end if (($HTTP_GET_VARS['action']=="details") and ($HTTP_GET_VARS['opid']))
?>
<?php
if (($HTTP_GET_VARS['action']=="details") and ($HTTP_GET_VARS['resumeid']))
 {
  $resume_query=bx_db_query("select * from ".$bx_table_prefix."_resumes where resumeid='".$HTTP_GET_VARS['resumeid']."'");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $resume_result=bx_db_fetch_array($resume_query);
  ?>
  <form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_VALIDATION;?>" enctype="multipart/form-data" method="post" name="resume">
   <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Resume details</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
 <TABLE border="0" cellpadding="2" cellspacing="0" bgcolor="#00CCFF" width="100%">
 <?php
  if (POSTING_LANGUAGE == "on") {
 ?>
 <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_RESUME_LANGUAGE;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="76%">
        <SELECT name="languageid" size="1">
       <?php
          $i=1;
           while (${TEXT_LANGUAGE_KNOWN_OPT.$i})
            {
             echo '<option value="'.$i.'"';
                    if ($i==$resume_result['postlanguage'])
                       {
                        echo "selected";
                        }
                        echo '>'.${TEXT_LANGUAGE_KNOWN_OPT.$i}.'</option>';
                        $i++;
                        }
                     ?>
              </SELECT>
      </TD>
    </TR>
  <?php
   }
   if(HIDE_RESUME == "yes") {?>
  <TR>
      <TD colspan="5" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="checkbox" name="confidential" class="radio" value="1"<?php if($resume_result['confidential']=="1"){echo " checked";}?>><B><?php echo TEXT_RESUME_NOT_SEARCH;?></B>
        </FONT>
      </TD>
   </TR>
   <?php }?>
   <TR>
      <TD valign="top" width="24%">
        <?php if($summary_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_SUMMARY;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="76%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="summary" size="30"  value="<?php echo $resume_result['summary'];?>">
        </FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_CATEGORY;?>:</B></FONT><br><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_CTRL_CLICK;?></FONT>
      </TD>
      <TD colspan="4" width="76%">
        <SELECT multiple name="jobcategoryids[]" size="5">
       <?php
        $title_query=bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($title_result=bx_db_fetch_array($title_query))
        {
        echo '<option value="'.$title_result['jobcategoryid'].'"';
        if (strstr($resume_result['jobcategoryids'],"-".$title_result['jobcategoryid']."-")) {echo "selected";}
        echo '>'.$title_result['jobcategory'].'</option>';
        }
        ?>
        </SELECT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_YOUR_RESUME;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="76%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <TEXTAREA name="resume" rows="6" cols="50"><?php echo $resume_result['resume'];?></TEXTAREA>
        </FONT>
      </TD>
    </TR>
    <TR>
      <TD colspan="5" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_UPLOAD_RESUME;?>:</B></FONT>
        </TD>
    </TR>
    <TR>
       <TD valign="top" width="24%">
           <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_UPLOAD_RESUME_NOTE;?></FONT>
       </TD>
       <TD valign="top" width="76%" colspan="4">
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="file" name="resume_cv" size="20">
           <?php if($resume_result['resume_cv']){ ?>
               &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript: ;" onClick=" window.open('<?php echo HTTP_RESUME.$resume_result['resume_cv'];?>','_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=500,height=520,screenX=50,screenY=50;left=50;top=50;');"><?php echo TEXT_VIEW_FILE;?></a> 
           <?php }?>
       </font>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SKILL;?>:</B></FONT><br><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SKILL_USED;?></FONT>
      </TD>
      <TD colspan="2" width="40%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name="skills" rows="3" cols="30"><?php echo $resume_result['skills'];?></textarea>
        </FONT>
      </TD>
      <TD colspan="2" width="36%" valign="top">
            <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SKILL_EXAMPLE;?></FONT>
      </TD>
    </TR>
    <?php
    if (REQUIRED_LANGUAGE == "on") {
    ?>
    <TR>
      <TD colspan="5" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_KNOWN_LANGUAGES;?>:</B></FONT>
        </TD>
    </TR>
    <?php
    $i=1;
    while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
         echo "<TR><TD width=\"24%\"><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><B>".${TEXT_LANGUAGE_KNOWN_OPT.$i}.":</B></FONT></TD><TD width=\"76%\" colspan=\"4\" nowrap>&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
         if (strstr($resume_result['languageids'],(substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."1")))
         {
         echo " checked ";
         }
         echo "value=1>".TEXT_VERY_GOOD."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
         if (strstr($resume_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."2"))
         {
          echo " checked ";
         }
         echo   " value=2>".TEXT_GOOD."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
         if (strstr($resume_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."3"))
         {
          echo " checked ";
         }
         echo "  value=3>".TEXT_POOR."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
         if (strstr($resume_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."4"))
         {
         echo " checked ";
         }
         echo " value=4>".TEXT_NONE."</FONT></TD></TR>";
         $i++;
         }
    }
    ?>
     <TR>
      <TD colspan="5" width="100%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_WORK_EXPERIENCE;?>:</B></FONT>
        </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">&nbsp;</FONT>
      </TD>
      <TD colspan="4" width="76%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <TEXTAREA name="workexperience" rows="5" cols="40"><?php echo $resume_result['workexperience'];?></TEXTAREA>
        </FONT>
      </TD>
    </TR>
       <TR>
      <TD colspan="5" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EDUCATION;?>:</B></FONT>
        </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">&nbsp;</FONT>
      </TD>
      <TD colspan="4" width="76%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <TEXTAREA name="education" rows="5" cols="40"><?php echo $resume_result['education'];?></TEXTAREA>
        </FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <?php if($emplyment_type_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_EMPLOYMENT_TYPE;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="100%">
          <SELECT name="jobtypeids[]" multiple size="3">
        <?php
          $jobtype_query=bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng);
          while ($jobtype_result=bx_db_fetch_array($jobtype_query))
          {
          echo '<option value="'.$jobtype_result['jobtypeid'].'"';
          if (strstr($resume_result['jobtypeids'],$jobtype_result['jobtypeid'])) {echo "selected";}
          echo '>'.$jobtype_result['jobtype'].'</option>';
          }
          ?>
        </SELECT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SALARY;?>:</B></FONT>
      </TD>
      <TD valign="top" width="19%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="salary" size="7" value="<?php echo $resume_result['salary'];?>">&nbsp;<B><?php echo PRICE_CURENCY;?></B></FONT>
      </TD>
      <TD colspan="3" valign="top" width="38%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_INDICATE_YEARLY_SALARY;?></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EXPERIENCE;?>:</B></FONT>
      </TD>
      <TD valign="top" width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="experience" size="7"  value="<?php echo $resume_result['experience'];?>"></FONT>
      </TD>
      <TD colspan="3" valign="top" width="60%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_REQUIRED_EXPERIENCE;?></FONT>
      </TD>
    </TR>
     <TR>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DEGREE_PREFERED;?>:</B></FONT>
      </TD>
     <TD width="25%">
        <SELECT name="degreeid" size="1">
        <?php
          $i=1;
          while (${TEXT_DEGREE_OPT.$i}) {
                 echo '<option value="'.$i.'"';
                 if ($i == $resume_result['degreeid']) {
                     echo " selected";
                 }
                 echo '>'.${TEXT_DEGREE_OPT.$i}.'</option>';
                 $i++;
          }   
          ?>
        </SELECT>
      </TD>
      <TD colspan="3" valign="top" width="50%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">&nbsp;</FONT>
      </TD>
    </TR>
    <TR>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_LOCATION;?>:</B></FONT><br><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_CTRL_CLICK;?></FONT>
      </TD>
     <TD width="25%">
     <SELECT name="locationids[]" multiple size="3">
        <?php
          $location_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng);
          while ($location_result=bx_db_fetch_array($location_query))
          {
          echo '<option value="'.$location_result['locationid'].'"';
          if (strstr($resume_result['locationids'],"-".$location_result['locationid']."-")) {echo "selected";}
          echo '>'.$location_result['location'].'</option>';
          }
          ?>
        </SELECT>
      </TD>
      <TD colspan="3" valign="top" width="50%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PREFERED_LOCATION;?></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="resume_province" size="30"
        value="<?php echo $resume_result['resume_province'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="resume_city" size="30"
        value="<?php echo $resume_result['resume_city'];?>"></FONT>
      </TD>
    </TR>
    <?php if(RESUME_EXPIRE == "yes") {?>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POST_DATE;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="resumedate" size="10"
        value="<?php echo $resume_result['resumedate'];?>"></FONT>&nbsp;<a href="javascript:show_calendar('resume.resumedate');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_RESUME_EXPIRE;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="resumeexpire" size="10"
        value="<?php echo $resume_result['resumeexpire'];?>"></FONT>&nbsp;<a href="javascript:show_calendar('resume.resumeexpire');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
      </TD>
    </TR>
    <?php }
    else {
        ?>
        <input type="hidden" name="resumedate" value="<?php echo $resume_result['resumedate'];?>">
        <input type="hidden" name="resumeexpire" value="<?php echo $resume_result['resumeexpire'];?>">        
        <?php
    }?>
    <TR>
     <td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="button" name="btnCancel" onclick="self.history.back()" value="<?php echo TEXT_BUTTON_CANCEL;?>">&nbsp;&nbsp;<INPUT type=submit name=btnSave value=" <?php echo TEXT_BUTTON_SAVE;?> "></FONT></td>
     <TD colspan=4 align="right" width="75%"><INPUT type="submit" name="btnDelete" value="<?php echo TEXT_BUTTON_DELETE;?>" onClick="return confirm('<?php echo eregi_replace("'","\'",TEXT_CONFIRM_RESUME_DELETE);?>');"></TD>
    </TR>
  </TABLE>
</td></tr></table>
  <input type="hidden" name="resumeid" value="<?php echo $HTTP_GET_VARS['resumeid'];?>">
  <input type="hidden" name="action" value="<?php echo $HTTP_GET_VARS['action'];?>">
  <input type="hidden" name="back_url" value="<?php echo urlencode($HTTP_GET_VARS['back_url']);?>">
  </form>
 <?php
}//end if action details
if (($HTTP_GET_VARS['company']=="add")){
include(DIR_LANGUAGES.$language."/".FILENAME_COMPANY);
?>
<script language="Javascript">
<!--

function isSTR(val){
        var str = val;
        // Return false if characters are not a-z, A-Z, or a space.
        for (var i = 0; i < str.length; i++){
                var ch = str.substring(i, i + 1);
                if (((ch < "a" || "z" < ch) && (ch < "A" || "Z" < ch)) && ch != ' '){
                       return 1;
                }
        }
        return 0;
}
function isEmail(val)
   {
   // Return false if e-mail field does not contain a '@' and '.' .
   if (val.indexOf ('@',0) == -1 ||
       val.indexOf ('.',0) == -1)
      {
      return 1;
      }
   else
      {
      return 0;
      }
   }

function isNum(str)
   {
   // Return false if characters are not '0-9' or '.' .
   for (var i = 0; i < str.length; i++)
      {
      var ch = str.substring(i, i + 1);
      if ((ch < "0" || "9" < ch) && ch != '.' && ch != '-')
         {
         return 1;
         }
      }
   return 0;
  }

function isPhone(str)
   {
   // Return false if characters are not '0-9' or '.' .
   for (var i = 0; i < str.length; i++)
      {
      var ch = str.substring(i, i + 1);
      if ((ch < "0" || "9" < ch) && ch != ' ' && ch != '+' && ch != '-' && ch !=')' && ch !='(')
         {
         return 1;
         }
      }
   return 0;
  }

function check_form() {
  var error = 0;
  var error_message = "<?php echo eregi_replace("\"","\\\"",JS_ERROR);?>";

 var company = document.frm.company.value;
 var password = document.frm.password.value;
 var confpassword = document.frm.confpassword.value;
 var address = document.frm.address.value;
 var phone = document.frm.phone.value;
 var email = document.frm.email.value;
 var postalcode = document.frm.postalcode.value;
 var city = document.frm.city.value;

   //Validation for COMPANY
   if (company == "" || company.length < <?php echo ENTRY_COMPANY_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",COMPANY_ERROR);?>\n";
    error = 1;
    }
   //Validation for PASSWORD
   if (password == "" || password.length < <?php echo ENTRY_PASSWORD_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",PASSWORD_ERROR);?>\n";
    error = 1;
    }
    //Validation for RETYPE_PASSWORD
   if (confpassword == "" || confpassword.length < <?php echo ENTRY_PASSWORD_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",CONFPASSWORD_ERROR);?>\n";
    error = 1;
    }
   if (document.frm.password.value!=document.frm.confpassword.value)
     {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",CONFPASSWORD_ERROR);?>\n";
    error = 1;
    }
      //Validation for EMAIL
  if (email == "" || email.length < <?php echo ENTRY_EMAIL_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",EMAIL_ERROR);?>\n";
    error = 1;
    }
    ret=isEmail(document.frm.email.value);
   if (ret==1)
    {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",EMAIL_ERROR);?>\n";
    error = 1;
    }
    //Validation for ADDRESS
   if (address == "" || address.length < <?php echo ENTRY_ADDRESS_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",ADDRESS_ERROR);?>\n";
    error = 1;
    }
    //Validation for   TELEPHONE
   if (phone == "" || phone.length < <?php echo ENTRY_PHONE_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",PHONE_ERROR);?>\n";
    error = 1;
    }

   ret=isPhone(document.frm.phone.value);
   if (ret==1)
    {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",PHONE_ERROR);?>\n";
    error = 1;
    }

    //Validation for POSTALCODE
     if (postalcode == "" || postalcode.length < <?php echo ENTRY_POSTALCODE_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",POSTALCODE_ERROR);?>\n";
    error = 1;
    }

    //Validation for CITY
    if (city == "" || city.length < <?php echo ENTRY_CITY_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",CITY_ERROR);?>\n";
    error = 1;
    }
    
  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}

//-->
</script>
<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_VALIDATION;?>" method="post" enctype="multipart/form-data" name="frm" onSubmit="return check_form();">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>New Company Details</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
     <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
    <?php if(USE_FEATURED_COMPANIES == "yes") {?> 
    <TR>
      <TD>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY_FEATURED;?></B></FONT>
      </TD>
     <TD>
        No<input type="radio" name="featured" class="radio" value="0" <?php if((!$company_result['featured']) or ($company_result['featured']=='0')) {echo "checked";}?>>
        Yes<input type="radio" name="featured" class="radio" value="1" <?php if($company_result['featured']=='1') {echo "checked";}?>>
      </TD>
    </TR>
    <?php }?>
    <TR>
      <TD valign="top" width="25%" align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php
       $image_location = DIR_LOGO. $company_result['logo'];
       if ((!empty($company_result['logo'])) && (file_exists($image_location))) {
                  echo "<img src=\"".HTTP_LOGO.$company_result['logo']."\" border=1 align=absmiddle>";
                  echo "<br>&nbsp;&nbsp;[&nbsp;<a href=\"del_logo.php?compid=".$company_result["compid"]."&logo_name=".$company_result['logo']."\">Delete Logo</a>&nbsp;]";
       }//end if (file_exists($image_location))
       else {
                 echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\"><b>".TEXT_LOGO_NOT_AVAILABLE."</b></font>";
       }//end else if (file_exists($image_location))
       ?></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="file" name="company_logo"></FONT>
      </TD>
    </TR>
   <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name=company size=30
        value="<?php echo $company_result['company'];?>"></FONT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DESCRIPTION;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name=description rows="5" cols="30"><?php echo $company_result['description'];?></textarea>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_ADDRESS;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name=address rows="3" cols="30"><?php echo $company_result['address'];?></textarea></FONT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=text name=city size=30
        value="<?php echo $company_result['city'];?>"></FONT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type=text name=province size=15 value="<?php echo $company_result['province'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POSTAL_CODE;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="postalcode" size=10
        value="<?php echo $company_result['postalcode'];?>"></FONT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COUNTRY;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <SELECT name="location" size=1>
         <?php
          $country_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng);
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          while ($country_result=bx_db_fetch_array($country_query))
          {
          echo '<option value="'.$country_result['locationid'].'"';
          if ($company_result['locationid']==$country_result['locationid']) {echo "selected";}
          echo '>'.$country_result['location'].'</option>';
          }
          ?>
         </SELECT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PHONE;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="tex" name="phone" size=30
        value="<?php echo $company_result['phone'];?>"></FONT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_FAX;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="fax" size=30
        value="<?php echo $company_result['fax'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMAIL;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="email" size=30
        value="<?php echo $company_result['email'];?>"></FONT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_URL;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=text name=url size=30
        value="<?php echo $company_result['url'];?>"></FONT>
      </TD>
    </TR>
    <TR><TD colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_HIDE_NOTE;?></font></TD></TR>
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
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PASSWORD;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=password name=password size=30
        value="<?php echo bx_js_stripslashes($company_result['password']);?>"></FONT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONFIRM_PASSWORD;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=password name=confpassword size=30
        value="<?php if($error==1) {echo bx_js_stripslashes($company_result['confpassword']);} else {echo bx_js_stripslashes($company_result['password']);}?>"></FONT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_AVAILABLE_JOBS;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="jobs" size=10
        value="0"> <b>999 = <?php echo TEXT_UNLIMITED;?></b></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_AVAILABLE_FJOBS;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="featuredjobs" size=10
        value="0"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_AVAILABLE_RESUMES;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="contacts" size=10
        value="0"> <b>999 = <?php echo TEXT_UNLIMITED;?></b></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DISCOUNT;?>:</B></FONT>
      </TD>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="discount" size=10
        value="0.00"></FONT>
      </TD>
    </TR>
    <?php
    $membership_query = bx_db_query("SELECT * from ".$bx_table_prefix."_membership where compid='".$company_result['compid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    $membership_result = bx_db_fetch_array($membership_query);
    $pricing_query = bx_db_query("SELECT * from ".$bx_table_prefix."_pricing_".$bx_table_lng." where pricing_id > 0");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    ?>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CURRENT_PLANNING;?>:</B></FONT>
      </TD>
      <TD width="75%">
        <select name="pricing_id" size="1">
            <?php
            if (!($membership_result['pricing_id']>=0)) {
                echo "<option selected>".TEXT_NO_PLANNING."</option>";
            }
            $i=0;
            while ($pricing_result = bx_db_fetch_array($pricing_query)) {
                if ($pricing_result['pricing_id'] == $membership_result['pricing_id']) {
                    $selected = " selected";
                    $expire = $pricing_result['pricing_period'];
                }
                else {
                    $selected = "";
                }
                if ($i==0) {
                    $expire = $pricing_result['pricing_period'];
                }
                echo "<option value=\"".$pricing_result['pricing_id']."\"".$selected.">".$pricing_result['pricing_title']."</option>\n";
                $i++;
            }
            ?>
        </select>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width=25%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PLANNING_EXPIRE;?>:</B></FONT>
      </TD>
      <?php
      $company_result['expire'] = date('Y-m-d',mktime (0,0,0,date('m')+$expire,date('d'),date('Y')));
      ?>
      <TD width=75%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="expire" size=10
        value="<?php echo $company_result['expire'];?>"></FONT>&nbsp;<a href="javascript:show_calendar('frm.expire');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
      </TD>
    </TR>
    <TR>
      <td align="center" colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="reset" name="btnReset" value="<?php echo TEXT_BUTTON_RESET;?>">&nbsp;&nbsp;&nbsp;
        <INPUT type="submit" name="btnSave" value="<?php echo TEXT_BUTTON_SAVE;?>"></FONT></td>
    </TR>
  </TABLE>
 </td></tr></table>
  <input type="hidden" name="action" value="add_comp"> 
  </form>
<?php
}
if ($HTTP_GET_VARS['job']=="add") {
include(DIR_LANGUAGES.$language."/".FILENAME_EMPLOYER);
?>
<script language="Javascript">
<!--
function isSTR(val){
        var str = val;
        // Return false if characters are not a-z, A-Z, or a space.
        for (var i = 0; i < str.length; i++){
                var ch = str.substring(i, i + 1);
                if (((ch < "a" || "z" < ch) && (ch < "A" || "Z" < ch)) && ch != ' '){
                return 1;
                }
        }
        return 0;
}
function isEmail(val)
{
        // Return false if e-mail field does not contain a '@' and '.' .
        if (val.indexOf ('@',0) == -1 || val.indexOf ('.',0) == -1)
        {
                return 1;
        }
        else
        {
                return 0;
        }
}

function isNum(str)
{
        // Return false if characters are not '0-9'
        for (var i = 0; i < str.length; i++)
        {
                var ch = str.substring(i, i + 1);
                if ((ch < "0" || "9" < ch) && ch !='.')
                {
                          return 1;
                }
        }
        return 0;
}

function check_form() {
        var error = 0;
        var error_message = "<?php echo eregi_replace("\"","\\\"",JS_ERROR);?>";
        
        var compid = document.frmJob.compid.value;
        var contact_email = document.frmJob.contact_email.value;
        var job_link = document.frmJob.job_link.value;
        var description = document.frmJob.description.value;
        var jobtitle = document.frmJob.jobtitle.value;
        var salary =  document.frmJob.salary.value;
        var jobtype =  document.frmJob["jobtypeids[]"];
        
        
        //Validation for company/ contact_email/ job link
        if (compid == "" && job_link=="" && (contact_email=="" || isEmail(document.frmJob.contact_email.value)==1)) {
                error_message = error_message + "*Please select an employer from the list or enter the Contact email or link to this job.\n";
                error = 1;
        }
        
        //Validation for TITLE
        if (jobtitle == "" ) {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",JOBTITLE_ERROR);?>\n";
                error = 1;
        }

        //Validation for DESCRIPTION
        if (description == "" || description.length < <?php echo ENTRY_DESCRIPTION_MIN_LENGTH;?>) {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",DESCRIPTION_ERROR);?>\n";
                error = 1;
        }

        //Validation for salary range
        ret=isNum(document.frmJob.salary.value);
        if (ret==1)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",SALARY_ERROR);?>\n";
                error = 1;
        }
        
        var j_sel = 0;
        //Validation for jotypes
        for (i=0; i<jobtype.length; i++) {
            if(jobtype[i].selected) {
                j_sel = 1;
            }
        }
        
        if (j_sel==0)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",EMPLOYMENT_ERROR);?>\n";
                error = 1;
        }
        
        if (error == 1) {
                alert(error_message);
                return false;
        } else {
                return true;
        }
}
//-->
</script>
<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_VALIDATION;?>" method="post" name="frmJob" onSubmit="return check_form();">
     <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>New Job Details</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
     <TABLE border="0" cellpadding="2" cellspacing="0" bgcolor="#00CCFF" width="100%">
     <tr>
     <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B>Employer/Company:</B></FONT>
      </TD>
      <TD colspan="4">
           <SELECT name="compid" size="1">
           <option value="">Select Employer</option>
        <?php
        $employer_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_companies");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($employer_result=bx_db_fetch_array($employer_query))
        {
        echo '<option value="'.$employer_result['compid'].'">'.$employer_result['company'].'</option>';
        }
        ?>
        </SELECT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <?php if(USE_FEATURED_JOBS == "yes") {?> 
    <TR>
      <TD>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_FEATURED;?></B></FONT>
      </TD>
      <TD colspan="4">
        No<input type="radio" class="radio" name="featuredjob" value="N" <?php if((!$job_result['featuredjob']) or ($job_result['featuredjob']=='N')) {echo "checked";}?>>
        Yes<input type="radio" class="radio" name="featuredjob" value="Y" <?php if($job_result['featuredjob']=='Y') {echo "checked";}?>>
      </TD>
    </TR>
   <?php
   }
   else {
       ?>
       <input type="hidden" name="featuredjob" value="N">
       <?php
   }
   if (POSTING_LANGUAGE == "on") {
   ?>
    <TR>
      <TD valign="top" width=24%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POSTING_LANGUAGE;?>:</B></FONT>
      </TD>
      <TD colspan=4 width=76%>
        <SELECT name="languageid" size=1>
       <?php
          $i=1;
           while (${TEXT_LANGUAGE_KNOWN_OPT.$i})
            {
             echo '<option value="'.$i.'"';
                    if ($i==$job_result['postlanguage'])
                       {
                        echo "selected";
                        }
                        echo '>'.${TEXT_LANGUAGE_KNOWN_OPT.$i}.'</option>';
                        $i++;
                        }
       ?>
        </SELECT>
      </TD>
    </TR>
    <?php
    }
    ?>
    <TR>
      <TD  width=24%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_TITLE;?>:</B></FONT>
      </TD>
      <TD colspan=4 width=76%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="jobtitle" value="<?php echo $job_result['jobtitle'];?>" size="30">
        </FONT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
   <TR>
      <TD width=24%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_CATEGORY;?>:</B></FONT>
      </TD>
      <TD colspan=4 width=76%>
        <SELECT name="jobcategoryid" size=1>
        <?php
        $title_query=bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($title_result=bx_db_fetch_array($title_query))
        {
        echo '<option value="'.$title_result['jobcategoryid'].'"';
        if ($job_result['jobcategoryid']==$title_result['jobcategoryid']) {echo "selected";}
        echo '>'.$title_result['jobcategory'].'</option>';
        }
        ?>
        </SELECT>
    </TR>
    <TR>
      <TD  width="24%" valign="top">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_DESCRIPTION;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="76%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <TEXTAREA name="description" rows="3" cols="40"><?php echo $job_result['description'];?></TEXTAREA></FONT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SKILL;?>:</B></FONT>
      </TD>
      <TD colspan="2" width="40%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name="skills" rows="3" cols="30"><?php echo $job_result['skills'];?></textarea>
        </FONT>
      </TD>
      <TD colspan="2" width="36%" valign="top">
            <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SKILL_EXAMPLE;?></FONT>
      </TD>
    </TR>
    <?php
    if (REQUIRED_LANGUAGE == "on") {
    ?>
    <TR>
      <TD colspan=5 width=100%>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_LANGUAGE_REQUIREMENTS;?>:</B></FONT>
      </TD>
    </TR>
    <?php
    $i=1;
    while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
       echo "<TR><TD width=\"30%\"><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><B>".${TEXT_LANGUAGE_KNOWN_OPT.$i}.":</B></FONT></TD><TD width=\"70%\" nowrap colspan=\"4\">&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],(substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."1")))
       {
       echo " checked ";
       }
         echo " value=1>".TEXT_VERY_GOOD."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio  class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."2"))
       {
        echo " checked ";
       }
       echo   " value=2>".TEXT_GOOD."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."3"))
       {
       echo " checked ";
       }
       echo "  value=3>".TEXT_POOR."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."4"))
       {
       echo " checked ";
       }
       echo " value=4>".TEXT_NONE."</FONT></TD></TR>";
       $i++;
       }
    }
    ?>
    <TR>
      <TD  width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMPLOYMENT_TYPE;?>:</B></FONT>
      </TD>
     <TD colspan="4">
        <SELECT name="jobtypeids[]" multiple size="3">
        <?php
          $jobtype_query=bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng);
          while ($jobtype_result=bx_db_fetch_array($jobtype_query))
          {
          echo '<option value="'.$jobtype_result['jobtypeid'].'"';
          if (strstr($job_result['jobtypeids'],$jobtype_result['jobtypeid'])) {echo "selected";}
          echo '>'.$jobtype_result['jobtype'].'</option>';
          }
          ?>
        </SELECT>&nbsp;<?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign=top width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SALARY_RANGE;?>:</B></FONT>
      </TD>
      <TD valign=top width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=text name=salary size=7 value="<?php echo $job_result['salary'];?>">&nbsp;<B><?php echo PRICE_CURENCY;?></B></FONT>
      </TD>
      <TD colspan=3 valign=top width="60%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_INDICATE_SALARY;?></FONT>
      </TD>
    </TR>
     <TR>
      <TD valign=top width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EXPERIENCE;?>:</B></FONT>
      </TD>
      <TD valign=top width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type=text name=experience size=7 value="<?php echo $job_result['experience'];?>"></FONT>
      </TD>
      <TD colspan=3 valign=top width="60%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_REQUIRED_EXPERIENCE;?></FONT>
      </TD>
    </TR>
    <TR>
      <TD  width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DEGREE_PREFERED;?>:</B></FONT>
      </TD>
     <TD width="25%">
        <SELECT name=degreeid size=1>
        <?php
          $i=1;
          while (${TEXT_DEGREE_OPT.$i}) {
                 echo '<option value="'.$i.'"';
                 if ($i == $job_result['degreeid']) {
                     echo " selected";
                 }
                 echo '>'.${TEXT_DEGREE_OPT.$i}.'</option>';
                 $i++;
          }
          ?>
        </SELECT>
      </TD>
      <TD colspan="3" valign=top width="50%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PREFERED_DEGREE;?></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COUNTRY;?>:</B></FONT>
      </TD>
      <TD width="75%" colspan="4">
        <SELECT name=location size=1>
        <?php
          $location_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng);
          while ($location_result=bx_db_fetch_array($location_query))
          {
          echo '<option value="'.$location_result['locationid'].'"';
          if ($job_result['locationid']==$location_result['locationid']) {echo "selected";}
          echo '>'.$location_result['location'].'</option>';
          }
          ?>
        </SELECT>
      </TD>
    </TR>
    <TR>
      <TD valign=top width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
      </TD>
      <TD width="75%" colspan="4">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type=text name=province size=15 value="<?php echo $job_result['province'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD width="75%" colspan="4">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="city" size=30 value="<?php echo $job_result['city'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="55%" colspan="2">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_HIDE_COMPANY;?>:</B><br><?php echo TEXT_HIDE_COMPANY_NOTE;?></FONT>
      </TD>
      <TD colspan="3" width="45%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_compname" value="yes"<?php if($job_result['hide_compname'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
   </TR>
   <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_NAME;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="contact_name" size=30 value="<?php echo $job_result['contact_name'];?>"></FONT>
      </TD>
      <TD colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" name="hide_contactname" class="radio" value="yes"<?php if($job_result['hide_contactname'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_EMAIL;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="contact_email" size=30 value="<?php echo $job_result['contact_email'];?>"></FONT>
      </TD>
      <TD colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" name="hide_contactemail" class="radio" value="yes"<?php if($job_result['hide_contactemail'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_PHONE;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="contact_phone" size=15 value="<?php echo $job_result['contact_phone'];?>"></FONT>
      </TD>
      <TD colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" name="hide_contactphone" class="radio" value="yes"<?php if($job_result['hide_contactphone'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_FAX;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="contact_fax" size=15 value="<?php echo $job_result['contact_fax'];?>"></FONT>
      </TD>
      <TD colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_contactfax" value="yes"<?php if($job_result['hide_contactfax'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
    </TR>
     <TR>
      <TD valign="top" width="25%">
        <font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><B>Job Link:</B></FONT>
      </TD>
      <TD width="75%" colspan="3">
        <font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>">
        <INPUT type="text" name="job_link" size="60" value="<?php echo $job_result['job_link'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POST_DATE;?>:</B></FONT>
      </TD>
      <?php
      $job_result['jobdate'] = date('Y-m-d');
      ?>
      <TD width="75%" colspan="4">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type=text name="jobdate" size="10" value="<?php echo date('Y-m-d');?>"></FONT>&nbsp;
        <a href="javascript:show_calendar('frmJob.jobdate');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
      </TD>
    </TR>
    <TR>
      <TD valign=top width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_EXPIRE;?>:</B></FONT>
      </TD>
      <?php
      $job_result['jobexpire'] = date("Y-m-d",mktime(0,0,0,date("m")+JOB_EXPIRE_MONTH,  date("d")+JOB_EXPIRE_DAY,  date("Y")+JOB_EXPIRE_YEAR));
      ?>
      <TD width="75%" colspan="4">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type=text name="jobexpire" size="10" value="<?php echo $job_result['jobexpire'];?>"></FONT>&nbsp;
        <a href="javascript:show_calendar('frmJob.jobexpire');" onmouseOver="window.status='Calendar'; return true;" onmouseOut="window.status=''; return true;" ><img src="images/calendar.gif" align="absmiddle" border="0" alt=""></a>
      </TD>
    </TR>
    <TR>
     <td align="center" colspan="5"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="button" name="btnCancel" onclick="self.history.back()" value="<?php echo TEXT_BUTTON_CANCEL;?>">&nbsp;&nbsp;<INPUT type="submit" name="btnSave" value=" <?php echo TEXT_BUTTON_SAVE;?> "></FONT></td>
    </TR>
  </TABLE>
</td></tr></table>
  <input type="hidden" name="action" value="add_job">
  </form>
<?php }?>