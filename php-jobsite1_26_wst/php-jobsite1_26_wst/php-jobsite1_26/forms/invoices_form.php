<?php
include(DIR_LANGUAGES.$language."/".FILENAME_INVOICES_FORM);
if ($HTTP_GET_VARS['printit']=="yes") {
?>
   <table bgcolor="#FFFFFF" width="100%" border="0" cellspacing="0" cellpadding="0">
   <TR><TD colspan="2"><hr></TD></TR>
   <TR bgcolor="#FFFFFF">
      <TD colspan="2" width="100%" align="center" class="headertdjob"><b><?php echo TEXT_INVOICE_DETAILS." ".$invoice_result['opid'].")";?></b></TD>
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
        <table bgcolor="#FFFFFF" width="100%" border="0" cellspacing="0" cellpadding="2">
           <TR>
              <td align="center" colspan="2"><B><?php echo TEXT_INVOICE_INFORMATION;?>:</B></TD>
          </TR>
          <tr><td colspan="2">&nbsp;</tr>
          <TR>
           <td align="right"><?php echo TEXT_INVOICE_NUMBER;?>:</td><td><?php echo $invoice_result['opid'];?></TD>
          </TR>
          <TR>
           <td align="right"><?php echo TEXT_OPERATION_DESCRIPTION;?>:</td><td><B><?php if($invoice_result['pricing_type']==0) {echo $invoice_result['pricing_title'];} else {echo TEXT_UPGRADE." ".$invoice_result['pricing_title'];}?></b></TD>
          </TR>
          <?php if($invoice_result['pricing_type']==0) {
                ?>
                <TR>
                        <td align="right"><?php echo TEXT_JOB_PURCHASE;?>:</td><td><?php echo $invoice_result['jobs']." ".TEXT_JOB." (".bx_format_price($invoice_result['1job'],$invoice_result['icurrency'])."/".TEXT_JOB.")";?></TD>
                </TR>
                <?php if(USE_FEATURED_JOBS == "yes") {?>
                <TR>
                        <td align="right"><?php echo TEXT_FJOB_PURCHASE;?>:</td><td><?php echo $invoice_result['featuredjobs']." ".TEXT_FEATURED_JOB." (".bx_format_price($invoice_result['1featuredjob'],$invoice_result['icurrency'])."/".TEXT_FEATURED_JOB.")";?></TD>
                </TR>
                <?php }?>
                <TR>
                        <td align="right"><?php echo TEXT_SEARCH_PURCHASE;?>:</td><td><?php echo $invoice_result['contacts']." ".TEXT_RESUME." (".bx_format_price($invoice_result['1contact'],$invoice_result['icurrency'])."/".TEXT_RESUME.")";?></TD>
                </TR>
           <?php
          }
          ?>
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
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
   <TR bgcolor="#FFFFFF">
      <TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_INVOICE_DETAILS." ".$invoice_result['opid'].")";?></TD>
   </TR>
   <TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
    </TR>
</table>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr><td colspan="2" align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PRINTER_FRIENDLY;?>&nbsp;&nbsp;</font><a href="javascript: ;" onmouseOver="window.status='<?php echo TEXT_PRINTER_FRIENDLY;?>'; return true;" onmouseOut="window.status=''; return true;" onClick="newwind = window.open('<?php echo bx_make_url(HTTP_SERVER."print_version.php", "auth_sess", $bx_session);?>&url='+escape('<?php echo HTTP_SERVER.FILENAME_INVOICES."?action=view&opid=".$HTTP_GET_VARS['opid']."&printit=yes";?>'),'_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=500,height=520,screenX=50,screenY=100');"><?php echo bx_image(HTTP_IMAGES.$language."/printit.gif",0,"");?></a></td></tr>
    <TR>
      <TD valign="top">
        <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0">
        <TR>
           <td align="center" width="50%" valign="top">
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
          <td align="center" width="50%" valign="top">
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
      <TD valign="top" align="center"><br>
        <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
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
               <TD colspan="2"><br><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_INVOICE_PAID;?></b></TD>
              </TR>
              <TR>
                <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PAYMENT_METHOD;?>: </FONT><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><?php echo ${TEXT_PAYMENT_OPT.$invoice_result['payment_mode']};?></b></FONT></TD>
              </TR>
              <TR>
                <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PAYMENT_DATE;?>: </FONT><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><?php echo bx_format_date($invoice_result['payment_date'], DATE_FORMAT);?></B></FONT></TD>
              </TR>
              <TR>
                <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PAYMENT_DESCRIPTION;?>: </FONT><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="<?php echo REQUIRED_TEXT_FONT_SIZE;?>" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><B><?php echo $invoice_result['description'];?></B></FONT></TD>
              </TR>
             <?php
            }//end if ($invoice_result['paid']=="Y" && $invoice_result['validated']=="Y")
          ?>
        </TABLE>
      </TD>
 </TR>
 <?php
 if ($HTTP_GET_VARS['action']=='cancel')
  {
 ?>
    <TR bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>">
      <TD colspan="2" align="right" valign="middle" width="100%" style="border: 1px solid #000000">
        <font face="<?php echo HEADING_FONT_FACE;?>" size="<?php echo HEADING_FONT_SIZE;?>" color="<?php echo HEADING_FONT_COLOR;?>"><B><?php echo TEXT_CANCEL_PAYMENT.$invoice_result['opid'].")";?></B></FONT>
      </TD>
   </TR>
   <tr><td colspan="2">&nbsp;</td></tr>
    <TR>
       <td colspan="2" align="left" valign="middle" width="100%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SURE_CANCEL_PAYMENT;?></B></FONT></TD>
    </TR>
   <tr><td colspan="2">&nbsp;</td></tr>
   <TR>
     <TD colspan="2" align="center" valign="middle" width="100%"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_INVOICES."?action=del&del=y&opid=".$invoice_result['opid'], "auth_sess", $bx_session);?>"><?php echo bx_image(HTTP_IMAGES.$language."/yes.gif",0,TEXT_YES);?></a>&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_INVOICES."?action=del&del=n&opid=".$invoice_result['opid'], "auth_sess", $bx_session);?>"><?php echo bx_image(HTTP_IMAGES.$language."/no.gif",0,TEXT_NO);?></a></font></TD>
    </TR>
  <?php
  }//end if ($HTTP_GET_VARS['action']=='cancel')
  ?>
 <?php
 if ($HTTP_GET_VARS['action']=='pay')
 { 
    $onebutton = false;
    include(DIR_SERVER_ROOT."cc_payment_settings.php");
    $i = 1;
    $max = 2;
    if(CC_PAYMENT == "off" && INVOICE_PAYMENT == "on") {
      $i = 2;
      $onebutton = true;
    }
    else if(INVOICE_PAYMENT == "off" && CC_PAYMENT == "on") {
      $max = 1;
      $onebutton = true;
    }
    else {
        
    }
    if(!$onebutton) {
 ?>
    <TR bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>">
      <TD colspan="2" align="right" valign="middle" width="100%" style="border: 1px solid #000000">
        <font face="<?php echo HEADING_FONT_FACE;?>" size="<?php echo HEADING_FONT_SIZE;?>" color="<?php echo HEADING_FONT_COLOR;?>"><B><?php echo TEXT_PAYMENT_SECTION.$invoice_result['opid'].")";?></B></FONT>
      </TD>
   </TR>
    <TR>
       <td colspan="2" align="left" valign="middle" width="100%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SELECT_PAYMENT_MODE;?>:</B></FONT></TD>
    </TR>
    <?php
    }
    ?>
    <form action="<?php echo bx_make_url(((ENABLE_SSL == "yes") ? HTTPS_SERVER : HTTP_SERVER).FILENAME_PAYMENT, "auth_sess", $bx_session);?>" method="post">
    <TR>
      <TD colspan="2" valign="middle" width="100%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
     <INPUT type="hidden" name="opid" value="<?php echo $HTTP_GET_VARS['opid'];?>">
     <INPUT type="hidden" name="compid" value="<?php echo $HTTP_SESSION_VARS['employerid'];?>">     
     <?php
           while (${TEXT_PAYMENT_OPT.$i} && $i<=$max)
            {
                 if($onebutton) {
                       echo '<input type="hidden" name="payment_mode" value="'.$i.'"';
                 }
                 else {
                       echo '<br><input type="radio" class="radio" name="payment_mode" value="'.$i.'"';
                 }
                 if ($i==1) {
                    echo " checked";
                 }
                 if(!$onebutton) {
                      echo '>'.${TEXT_PAYMENT_OPT.$i}."";
                 }
                 $i++;
           }
     ?>
     </font></TD>
    </TR>
    <TR>
     <TD colspan="2" align="center" valign="middle" width="100%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
     <?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/pay.gif",0,TEXT_PAY);?></font>
     </TD>
    </TR>
  </form>
  <?php
  }//end if ($HTTP_GET_VARS['action']=='pay')
  ?>
</TABLE>
<?php
}      
?>