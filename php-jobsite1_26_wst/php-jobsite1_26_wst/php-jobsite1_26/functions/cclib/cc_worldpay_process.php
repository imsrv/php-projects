<?php include(DIR_SERVER_ROOT."header.php");?>
<?php include(DIR_LANGUAGES.$language."/".FILENAME_CC_BILLING_FORM);?>
<?php include(DIR_LANGUAGES.$language."/".FILENAME_PAYMENT_FORM);?>
<?php include(DIR_LANGUAGES.$language."/".FILENAME_INVOICES_FORM);?>
<?php
if ($HTTP_POST_VARS['todo'] == "proceed") {
    $curr_opid = $HTTP_POST_VARS['opid'];
    bx_session_unregister("curr_opid");
    bx_session_register("curr_opid");
    $curr_pmode = $HTTP_POST_VARS['payment_mode'];
    bx_session_unregister("curr_pmode");
    bx_session_register("curr_pmode");
    $company_query=bx_db_query("SELECT company, email, address, url FROM ".$bx_table_prefix."_companies where compid='".$invoice_result['compid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    $company_result=bx_db_fetch_array($company_query);
    if(CC_NOTIFY_ADMIN == "yes") {
        $themessage.="           Operation details (No: ".$invoice_result['opid'].")\n";
        $themessage.="-----------------------Begin Company information(Sender)---------\n";
        $themessage.="Company name: ".$company_result['company']."\n";
        $themessage.="Company email: ".$company_result['email']."\n";
        $themessage.="Address: ".$company_result['address']."\n";
        if ($company_result['url']) {
             $themessage.="Website: ".$company_result['url']."\n";
        }
        $themessage.="Company details: ".HTTP_SERVER.FILENAME_VIEW."?company_id=".$invoice_result['compid']."\n";
        $themessage.="-----------------------End Company information---------\n\n";
        $themessage.="-----------------------Begin Payment information---------\n";
        $themessage.="Total payment value: ".bx_format_price($invoice_result['totalprice'],$invoice_result['icurrency'])."\n";
        $themessage.="Payment date: ".bx_format_date(date('Y-m-d'), DATE_FORMAT)."\n";
        $themessage.="-----------------------Begin Payment modalities---------\n";
        $themessage.="Customer selected payment modality: \n";
        $themessage.="          ".${TEXT_PAYMENT_OPT.$HTTP_POST_VARS['payment_mode']}."\n";
        $themessage.="-----------------------End Payment modalities---------\n\n";
        $themessage.=(($invoice_result['pricing_type']==0)?"Payment description: ":"Upgrade to: ").$invoice_result['pricing_title']."\n";
        $themessage.="Details: ".HTTP_SERVER_ADMIN."admin.php?action=".(($invoce_result['pricing_type']=='0')?"buyers":"upgrades")."\n";
        $themessage.="-----------------------End Payment information---------\n";
        bx_mail(SITE_NAME,SITE_MAIL,SITE_NAME."<".SITE_MAIL.">","Employer upgrade/purchase operation: ".$invoice_result['opid'],$themessage,"no");
    }
    bx_db_query("UPDATE ".$bx_table_prefix."_invoices set date_added='".date('Y-m-d')."', payment_date='".date('Y-m-d')."', paid='Y', updated='N', validated='N', payment_mode='".$HTTP_POST_VARS['payment_mode']."',info='".(($invoice_result['pricing_type']==0)?"Payment description: ":"Upgrade to: ").$invoice_result['pricing_title']."' where ".$bx_table_prefix."_invoices.opid='".$HTTP_POST_VARS['opid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    ?>
    <form method="post" action="<?php echo WORLDPAY_URL;?>" name="frmcheckout">
        <input type="hidden" name="instId" value="<?php echo WORLDPAY_ID;?>">
        <input type="hidden" name="cartId" value="<?php echo WORLDPAY_CARTID;?>">
        <input type="hidden" name="currency" value="<?php echo WORLDPAY_CURRENCY;?>">
        <input type="hidden" name="amount" value="<?php echo $invoice_result['totalprice'];?>">
        <input type="hidden" name="desc" value="<?php echo "Upgrade to ".$invoice_result[pricing_title]." for Company ".trim($company_result['company']);?>">
        <input type="hidden" name="MC_callback" value="<?php echo WORLDPAY_RETURN;?>">
        <input type="hidden" name="testMode" value="<?php echo (WORLDPAY_TEST == "yes")?"100":"0";?>">
        <input type="hidden" name="auth_sess" value="<?php echo bx_session_id();?>">
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
              <TD><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B> <?php if($invoice_result['pricing_type']==0) {echo $invoice_result['pricing_title'];} else {echo TEXT_UPGRADE." ".$invoice_result['pricing_title'];}?></B></FONT>
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
                if(USE_DISCOUNT=="yes" || ($invoice_result['discount']!=0)){?>
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