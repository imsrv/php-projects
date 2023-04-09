<?php include(DIR_SERVER_ROOT."header.php");?>
<?php include(DIR_LANGUAGES.$language."/".FILENAME_CC_BILLING_FORM);?>
<?php include(DIR_LANGUAGES.$language."/".FILENAME_PAYMENT_FORM);?>
<?php include(DIR_LANGUAGES.$language."/".FILENAME_INVOICES_FORM);?>
<?php
if($HTTP_GET_VARS['todo'] == "ret") {
    if ($HTTP_POST_VARS['x_2checked']=="Y") {
          $transid_query=bx_db_query("select * from ".$bx_table_prefix."_cctransactions where transid='".$HTTP_POST_VARS['x_trans_id']."'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          if (bx_db_num_rows($transid_query)!=0) {
                    $error_message=TEXT_ALREADY_PAYD_TRANSACTION;
                    $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
                    include(DIR_FORMS.FILENAME_ERROR_FORM);
          } //end if (bx_db_num_rows($transid_query)!=0)
          else
          {
               bx_db_query("UPDATE ".$bx_table_prefix."_invoices set date_added='".date('Y-m-d')."', payment_date='".date('Y-m-d')."', paid='Y',validated='Y', payment_mode='".$HTTP_SESSION_VARS['curr_pmode']."' where ".$bx_table_prefix."_invoices.opid='".$HTTP_POST_VARS['opid']."'");
               SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
               if (CHECKOUT_COM_DEMO=="yes" && $HTTP_POST_VARS['x_trans_id']==0)
               {
               		$HTTP_POST_VARS['x_trans_id'] = time();
               }
               bx_db_insert($bx_table_prefix."_cctransactions","transid,opid,cc_name,cc_type,cc_num,cc_exp,cc_street,cc_city,cc_state,cc_zip,cc_country,cc_phone,cc_email","'".$HTTP_POST_VARS['x_trans_id']."','".$HTTP_POST_VARS['opid']."','','','','','','','','','','',''");
               bx_session_unregister('curr_opid');
               bx_session_unregister('curr_pmode');
               if(CC_NOTIFY_BUYER == "yes") {
                   $mailfile = $language."/mail/cc_2checkoutprocess.txt";
                   include(DIR_LANGUAGES.$mailfile.".cfg.php");
                   $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                   $invoice_result['listprice'] = bx_format_price($invoice_result['listprice'],$invoice_result['icurrency']);
                   $invoice_result['inv_discount'] = $invoice_result['invoice_discount'];
                   $invoice_result['inv_vat'] = $invoice_result['vat'];
                   $invoice_result['invoice_discount'] = bx_format_price((($invoice_result['listprice']*$invoice_result['inv_discount'])/100),$invoice_result['icurrency'])." (".$invoice_result['inv_discount']." %)";
                   $invoice_result['vat'] = bx_format_price(((($invoice_result['listprice']-($invoice_result['listprice']*$invoice_result['inv_discount'])/100))*$invoice_result['inv_vat']/100),$invoice_result['currency'])." (".$invoice_result['inv_vat']." %)";
                   $invoice_result['totalprice'] = bx_format_price($invoice_result['totalprice'],$invoice_result['icurrency']);
                   $invoice_result['invoice_paymentdate'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                   $invoice_result['auth_address'] = $HTTP_POST_VARS['x_address'];
                   $invoice_result['auth_city'] = $HTTP_POST_VARS['x_city'];
                   $invoice_result['auth_state'] = $HTTP_POST_VARS['x_state'];
                   $invoice_result['auth_zip'] = $HTTP_POST_VARS['x_zip'];
                   $invoice_result['auth_country'] = $HTTP_POST_VARS['x_country'];
                   $invoice_result['auth_phone'] = $HTTP_POST_VARS['x_phone'];
                   $invoice_result['auth_email'] = $HTTP_POST_VARS['x_email'];
                   $invoice_result['order_number'] = $HTTP_POST_VARS['x_trans_id'];
                   $invoice_result['order_status'] = $HTTP_POST_VARS['x_response_reason_text'];
                   $invoice_result['ip_address'] = $HTTP_SERVER_VARS['REMOTE_ADDR'];
                   reset($fields);
                   while (list($h, $v) = each($fields)) {
                              $mail_message = eregi_replace($v[0],$invoice_result[$h],$mail_message);
                              $file_mail_subject = eregi_replace($v[0],$invoice_result[$h],$file_mail_subject);
                   }
                   if ($add_mail_signature == "on") {
                              $mail_message .= "\n".SITE_SIGNATURE;
                   }
                   bx_mail(SITE_NAME,SITE_MAIL,$invoice_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail); 
               }    
               if(CC_NOTIFY_ADMIN == "yes") {
                    $themessage.="          Invoice details (No: ".$invoice_result['opid'].")\n";
                    $themessage.="-----------------------Begin Company information(Sender)---------\n";
                    $themessage.="Company name: ".$invoice_result['company']."\n";
                    $themessage.="Company email: ".$invoice_result['email']."\n";
                    $themessage.="Address: ".$invoice_result['address']."\n";
                    if ($invoice_result['url']) {
                            $themessage.="Website: ".$invoice_result['url']."\n";
                    }
                    $themessage.="Company details: ".HTTP_SERVER.FILENAME_VIEW."?company_id=".$invoice_result['compid']."\n";
                    $themessage.="-----------------------End Company information---------\n\n";
                    $themessage.="-----------------------Begin Payment information---------\n";
                    $themessage.="List Price: ".bx_format_price($invoice_result['listprice'],$invoice_result['icurrency'])."\n";
                    if(USE_DISCOUNT == "yes" || ($invoice_result['inv_discount']!=0)) {
                            $themessage.="Discount: ".bx_format_price((($invoice_result['listprice']*$invoice_result['inv_discount'])/100),$invoice_result['icurrency'])." (".$invoice_result['inv_discount']." %)"."\n";
                    }
                    if(USE_VAT == "yes") {
                            if(USE_DISCOUNT == "yes" || ($invoice_result['inv_discount']!=0)) {
                                    $themessage.="Price with discount: ".bx_format_price($invoice_result['listprice']-(($invoice_result['listprice']*$invoice_result['inv_discount'])/100),$invoice_result['icurrency'])."\n";
                            }
                            $themessage.="VAT: ".bx_format_price(((($invoice_result['listprice']-($invoice_result['listprice']*$invoice_result['inv_discount'])/100))*$invoice_result['inv_vat']/100),$invoice_result['currency'])." (".$invoice_result['inv_vat']." %)"."\n";
                    }
                    $themessage.="Total Price: ".bx_format_price($invoice_result['totalprice'],$invoice_result['icurrency'])."\n";
                    $themessage.="Payment date: ".bx_format_date(date('Y-m-d'), DATE_FORMAT)."\n";
                    $themessage.="2checkout Order Number: ".$HTTP_POST_VARS['x_trans_id']."\n";
                    $themessage.="2checkout Order Status: ".$HTTP_POST_VARS['x_response_reason_text']."\n";
                    $themessage.="-----------------------Begin Payment modalities---------\n";
                    $themessage.="Customer selected payment modality: \n";
                    $themessage.="          ".${TEXT_PAYMENT_OPT.$HTTP_POST_VARS['payment_mode']}."\n";
                    $themessage.="-----------------------End Payment modalities---------\n\n";
                    $themessage.=(($invoice_result['pricing_type']==0)?"Payment description: ":"Upgrade to: ").$invoice_result['pricing_title']."\n";
                    $themessage.="Details: ".HTTP_SERVER_ADMIN."admin.php?action=".(($invoce_result['pricing_type']=='0')?"buyers":"upgrades")."\n";
                    $themessage.="-----------------------End Payment information---------\n";
                    $themessage.=SITE_SIGNATURE."\n";
                    bx_mail(SITE_NAME,SITE_MAIL,SITE_NAME."<".SITE_MAIL.">",TEXT_INVOICE_NUMBER.": ".$invoice_result['opid'],$themessage,"no");
               } 
               $success_message=TEXT_CC_PAYMENT_SUCCESS;
               $back_url=bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, "auth_sess", $bx_session);
               include(DIR_FORMS.FILENAME_MESSAGE_FORM);
               //include(DIR_FORMS.FILENAME_PROCESSING_FORM);
         }//end else if (bx_db_num_rows($transid_query)!=0)
    }//end if ($HTTP_POST_VARS['x_response_code']=="1")
    else if (($HTTP_POST_VARS['x_2checked']=="N")) {
            $error_message=TEXT_INVALID_CC_PAYMENT;
            $text_reason = $HTTP_POST_VARS['x_response_reason_text'];
            $back_url=bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, "auth_sess", $bx_session);
            include(DIR_FORMS.FILENAME_ERROR_FORM);
    }
}
elseif ($HTTP_POST_VARS['todo'] == "proceed") {
    $curr_opid = $HTTP_POST_VARS['opid'];
    bx_session_unregister("curr_opid");
    bx_session_register("curr_opid");
    $curr_pmode = $HTTP_POST_VARS['payment_mode'];
    bx_session_unregister("curr_pmode");
    bx_session_register("curr_pmode");
    ?>
    <form method="post" action="<?php echo CHECKOUT_COM_URL;?>" name="frmcheckout">
        <input type="hidden" name="demo" value="<?php echo (CHECKOUT_COM_DEMO=="yes")?"Y":"";?>">
        <input type="hidden" name="x_Method" value="CC">
        <input type="hidden" name="x_Receipt_Link_Method" value="POST">
        <input type="hidden" name="x_Receipt_Link_URL" value="<?php echo bx_make_url(((ENABLE_SSL == "yes") ? HTTPS_SERVER : HTTP_SERVER).FILENAME_PROCESSING."?todo=ret", "auth_sess", $bx_session);?>">
        <input type="hidden" name="x_Login" value="<?php echo CHECKOUT_COM_ACCOUNT;?>">
        <input type="hidden" name="x_Amount" value="<?php echo $invoice_result['totalprice'];?>">
        <input type="hidden" name="auth_sess" value="<?php echo bx_session_id();?>">
        <input type="hidden" name="payment_mode" value="<?php echo $HTTP_POST_VARS['payment_mode'];?>">
        <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="2">
           <TR bgcolor="#FFFFFF">
                    <TD width="100%" align="center" class="headertdjob"><?php echo TEXT_PROCESS_PAYMENT;?></TD>
           </TR>
           <TR><TD><table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                        </tr>
               </table></TD>
            </TR>
            <TR>
                    <TD style="padding-left: 20px;" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
                    <div><span id="pr1"><b><font color="#FF0000"><?php echo TEXT_PROCESSING;?></font></b></span>
<span id="pr2"  STYLE="POSITION: relative;  VISIBILITY: visible; TOP: 0px;  Z-INDEX: 15; LEFT: 0px"><b>..</b>.</span>
</div>
<script language="Javascript">
<!--
var text_status = 0;
var delay=250;
var redirect_delay=3000;
function refresh_text(pobject) {
    if (document.getElementById && document.getElementById(pobject)) {
          if(text_status == 1) {
              document.getElementById(pobject).style.visibility='visible';
              text_status = 0;
          }
          else {
              document.getElementById(pobject).style.visibility='hidden';
              text_status = 1;
          }
    }
    else if (document.layers) {
          if(text_status == 1) {
		    document.layers[pobject].visibility = 'visible';
               text_status = 0;
          }
          else {
              document.layers[pobject].visibility = 'hide';
              text_status = 1;
          }
	}
	else if (document.all && eval(document.all.pobject)) {
          if(text_status == 1) {
		    document.all[pobject].style.visibility = 'visible';
               text_status = 0;
          }
          else {
              document.all[pobject].style.visibility = 'hidden';
              text_status = 1;
          }
    }
    setTimeout("refresh_text(\'pr2\')", delay)
}
function make_redirection() {
    document.frmcheckout.submit();
}
refresh_text('pr2');
setTimeout("make_redirection()", redirect_delay);
//-->
     </script></FONT></TD>
            </TR>
            <TR>
                    <TD style="padding: 20px;"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_WAIT_NOTIFICATION;?></FONT></TD>
            </TR>
            <TR>
                    <TD style="padding-left: 20px;"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">&nbsp;</FONT></TD>
            </TR>
            <TR>
                    <TD style="padding-left: 20px;" align="center"><input type="submit" name="go" value="<?php echo TEXT_GO_THERE;?>"></TD>
            </TR>
        </TABLE>
      </form>  
<?php }
else {
	//include(DIR_FORMS.FILENAME_CC_BILLING_FORM);
    ?>
    <form method="post" action="<?php echo bx_make_url(((ENABLE_SSL == "yes") ? HTTPS_SERVER : HTTP_SERVER).FILENAME_PROCESSING, "auth_sess", $bx_session);?>">
        <input type="hidden" name="opid" value="<?php echo $HTTP_POST_VARS['opid'];?>">
        <input type="hidden" name="compid" value="<?php if($HTTP_SESSION_VARS['employerid']) {echo $HTTP_SESSION_VARS['employerid'];} else if ($HTTP_POST_VARS['compid']) {echo $HTTP_POST_VARS['compid'];}?>">
        <input type="hidden" name="todo" value="proceed">
        <input type="hidden" name="payment_mode" value="<?php echo $HTTP_POST_VARS['payment_mode'];?>">
        <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="2">
           <TR bgcolor="#FFFFFF">
                    <TD width="100%" align="center" class="headertdjob"><?php echo TEXT_BILLING_INFORMATION;?></TD>
           </TR>
           <TR><TD><table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                        </tr>
               </table></TD>
            </TR>
            <TR>
                    <TD style="padding-left: 20px;" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_BILLING_APROVE;?></FONT></TD>
            </TR>
            <TR>
                    <TD style="padding-left: 20px;"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">&nbsp;</FONT></TD>
            </TR>
        </TABLE>
        <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="70%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td>
          <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="3">
          <TR bgcolor="#FFFFFF"><TD colspan="2" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo SITE_TITLE;?></B></TD></TR> 
          <TR bgcolor="#FFFFFF"><TD colspan="2" align="center">&nbsp;</TD></TR> 
          <TR bgcolor="#FFFFFF"><TD colspan="2" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY_INFORMATION;?></B></TD></TR> 
           <TR bgcolor="#FFFFFF">
              <TD valign="top" colspan="2" align="center"><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><?php echo nl2br(COMPANY_INFORMATION);?></B></FONT>
              </TD>
           </TR>
           <TR bgcolor="#FFFFFF"><TD colspan="2" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMPLOYER_INFORMATION;?></B></TD></TR> 
           <?php
           $company_query = bx_db_query("SELECT * from ".$bx_table_prefix."_companies where compid = '".$invoice_result['compid']."'");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           $company_result = bx_db_fetch_array($company_query);
           ?>
          <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo $company_result['company'];?></B></FONT>
              </TD>
           </TR>
           <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_ADDRESS;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><?php echo $company_result['address'];?></B></FONT>
              </TD>
           </TR>
           <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CC_CITY;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo $company_result['city'];?></B></FONT>
              </TD>
           </TR>
           <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CC_STATE;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo $company_result['province'];?></B></FONT>
              </TD>
           </TR>
           <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CC_ZIP;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo $company_result['postalcode'];?></B></FONT>
              </TD>
           </TR>
           <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CC_COUNTRY;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo $company_result['location'];?></B></FONT>
              </TD>
           </TR>
           <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CC_PHONE;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo $company_result['phone'];?></B></FONT>
              </TD>
           </TR>
           <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CC_EMAIL;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo $company_result['email'];?></B></FONT>
              </TD>
           </TR>
           <TR bgcolor="#FFFFFF"><TD colspan="2">&nbsp;</TD></TR> 
           <TR bgcolor="#FFFFFF">
              <TD align="right" valign="top">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_IP_ADDRESS;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><?php echo $HTTP_SERVER_VARS['REMOTE_ADDR'];?></B></FONT>
              </TD>
           </TR>
           <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PAYMENT_DESCRIPTION;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php if($invoice_result['pricing_type']==0) {echo $invoice_result['pricing_title'];} else {echo TEXT_UPGRADE." ".$invoice_result['pricing_title'];};?></B></FONT>
              </TD>
            </TR>
            <?php
            if ($invoice_result['pricing_type']==0)
             {
                ?>
            <TR bgcolor="#FFFFFF"><TD colspan="2">&nbsp;</TD></TR> 
            <TR bgcolor="#FFFFFF">
              <TD align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_NUMBER_OF_JOBS;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo $invoice_result['jobs'];?></B></FONT>
              </TD>
            </TR>
            <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PRICE_OF_JOBS;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo bx_format_price($invoice_result['1job'],$invoice_result['icurrency']);?></B></FONT>
              </TD>
            </TR>
            <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_TOTAL_OF_JOBS;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo bx_format_price(($invoice_result['jobs']*$invoice_result['1job']),$invoice_result['icurrency']);?></B></FONT>
              </TD>
            </TR>
            <?php if(USE_FEATURED_JOBS == "yes") {?>
            <TR bgcolor="#FFFFFF"><TD colspan="2">&nbsp;</TD></TR> 
            <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_NUMBER_OF_FJOBS;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo $invoice_result['featuredjobs'];?></B></FONT>
              </TD>
            </TR>
            <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PRICE_OF_FJOBS;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo bx_format_price($invoice_result['1featuredjob'],$invoice_result['icurrency']);?></B></FONT>
              </TD>
            </TR>
            <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_TOTAL_OF_FJOBS;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo bx_format_price(($invoice_result['featuredjobs']*$invoice_result['1featuredjob']),$invoice_result['icurrency']);?></B></FONT>
              </TD>
            </TR>
            <?php }?>
            <TR bgcolor="#FFFFFF"><TD colspan="2">&nbsp;</TD></TR> 
            <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_NUMBER_OF_CONTACTS;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo $invoice_result['contacts'];?></B></FONT>
              </TD>
            </TR>
            <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PRICE_OF_CONTACTS;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo bx_format_price($invoice_result['1contact'],$invoice_result['icurrency']);?></B></FONT>
              </TD>
            </TR>
            <TR bgcolor="#FFFFFF">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_TOTAL_OF_CONTACTS;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo bx_format_price(($invoice_result['contacts']*$invoice_result['1contact']),$invoice_result['icurrency']);?></B></FONT>
              </TD>
            </TR>
             <?php
             }//end if ($invoice_result['pricing_type']==0)
            ?>
            <TR bgcolor="#FFFFFF"><TD colspan="2">&nbsp;</TD></TR> 
            <TR bgcolor="#FFEEEE">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PAYMENT_DATE;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo bx_format_date(date('Y-m-d'), DATE_FORMAT);?></B></FONT>
              </TD>
            </TR>
            <TR bgcolor="#FFEEEE">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PAYMENT_LIST_PRICE;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo bx_format_price($invoice_result['listprice'],$invoice_result['icurrency']);?></B></FONT>
              </TD>
            </TR>
            <?php if(USE_DISCOUNT == "yes" || ($invoice_result['discount']!=0)) {?>
            <TR bgcolor="#FFEEEE">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PAYMENT_DISCOUNT_PRICE;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo bx_format_price((($invoice_result['listprice']*$invoice_result['discount'])/100),$invoice_result['icurrency'])." (".$invoice_result['discount']." %)";?></B></FONT>
              </TD>
            </TR>
            <?php }?>
            <?php if(USE_VAT == "yes") {
                   if(USE_DISCOUNT == "yes" || ($invoice_result['discount']!=0)) {?>
                    <TR bgcolor="#FFEEEE">
                      <TD align="right">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DISCOUNTED_PRICE;?>:</B></font>
                      </TD>
                      <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo bx_format_price($invoice_result['listprice']-(($invoice_result['listprice']*$invoice_result['discount'])/100),$invoice_result['icurrency']);?></B></FONT>
                      </TD>
                    </TR>
                    <?php }?>
            <TR bgcolor="#FFEEEE">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PAYMENT_VAT;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php echo bx_format_price(((($invoice_result['listprice']-($invoice_result['listprice']*$invoice_result['discount'])/100))*$invoice_result['vat']/100),$invoice_result['currency'])." (".$invoice_result['vat']." %)";?></B></FONT>
              </TD>
            </TR>
            <?php }?>
            <TR  bgcolor="#FF0000">
              <TD align="right">
                <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PAYMENT_TOTAL_PRICE;?>:</B></font>
              </TD>
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="#000000"><B> <?php echo bx_format_price($invoice_result['totalprice'],$invoice_result['icurrency']);?></B></FONT>
              </TD>
            </TR>
          </TABLE>
          </TD>
          </tr>
          </table>
          <br>
          <table width="60%" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0">
              <TR bgcolor="#FFFFFF">
                    <TD align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="submit" name="proceed" value="<?php echo TEXT_PROCEED;?>"></FONT></TD>
             </TR>
          </table>
        </FORM>
    <?php
}
?>
<?php include(DIR_SERVER_ROOT."footer.php");?>