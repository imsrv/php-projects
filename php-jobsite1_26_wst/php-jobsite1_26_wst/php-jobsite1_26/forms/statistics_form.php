<?php
include(DIR_LANGUAGES.$language."/".FILENAME_STATISTICS_FORM);?>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
<TR bgcolor="#FFFFFF">
      <TD width="100%" align="center" class="headertdjob"><?php echo TEXT_STATISTICS;?></TD>
   </TR>
<TR><TD><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
</TR>
   <TR><TD align="right"><form name="invlist"><b><?php echo TEXT_LIST_INVOICES;?>: </b><select name="inv" size="1" onChange="document.location.href=document.invlist.inv[document.invlist.inv.selectedIndex].value;"><option value="<?php echo bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, "auth_sess", $bx_session);?>">-- <?php echo TEXT_CURRENTLY_PENDING;?> --</option><option value="<?php echo bx_make_url(HTTP_SERVER.FILENAME_STATISTICS."?action=upgrade", "auth_sess", $bx_session);?>"<?php if($action=="upgrade") { echo "selected";}?>>-- <?php echo TEXT_UPGRADE_INVOICE_LIST;?> --</option><option value="<?php echo bx_make_url(HTTP_SERVER.FILENAME_STATISTICS."?action=buy", "auth_sess", $bx_session);?>"<?php if($action=="buy") { echo "selected";}?>>-- <?php echo TEXT_JOB_PURCHASE_INVOICE_LIST;?> --</option></select></form></TD></TR>
</table><br><?php
if ($HTTP_GET_VARS['action']=="upgrade")
 {
  ?>
<table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>
  <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="2">
   <tr>
 	 <td colspan="2" width="35%" align="center" bgcolor="<?php echo LIST_HEADER_COLOR;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_UPGRADE_INOICES;?></b></FONT></td>
	 <td colspan="<?php echo (USE_DISCOUNT=="yes")?((USE_VAT=="yes")?"5":"4"):((USE_VAT=="yes")?"4":"3");?>" bgcolor="#FFFFFF">&nbsp;</td>
   </tr>
   <tr bgcolor="<?php echo LIST_HEADER_COLOR;?>">
            <td width="25%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <b>&nbsp;<?php echo TEXT_PRICING_TYPE;?>&nbsp;</b></font></td>
            <td width="15%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <b>&nbsp;<?php echo TEXT_DATE_ADDED;?>&nbsp;</b></font></td>
            <td width="15%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <b>&nbsp;<?php echo TEXT_UPGRADE_VALUE;?>&nbsp;</b></font></td>
         <?php if(USE_DISCOUNT == "yes") {?>
            <td width="15%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <b>&nbsp;<?php echo TEXT_DISCOUNT_VALUE;?>&nbsp;</b></font></td>
         <?php }?>
         <?php if(USE_VAT == "yes") {?>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_VAT_VALUE;?>&nbsp;</b></font></td>
         <?php }?>
            <td width="15%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <b>&nbsp;<?php echo TEXT_PAYMENT_VALUE;?>&nbsp;</b></font></td>
            <td width="15%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <b>&nbsp;<?php echo TEXT_VIEW;?>&nbsp;</b></font></td>
  </tr>
  <?php
  $rows=0;
  $upgrade_query=bx_db_query("select * from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.compid='".$HTTP_SESSION_VARS['employerid']."' and paid='Y' and validated='Y' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id>0 order by date_added desc, pricing_type asc");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  while ($upgrade_result=bx_db_fetch_array($upgrade_query))
   {
   $rows++;
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_FIRST.'"';
    } else {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_SECOND.'"';
    }?>>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <?php echo $upgrade_result['pricing_title'];?></font></td>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <?php echo bx_format_date($upgrade_result['date_added'], DATE_FORMAT);?></font></td>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <?php echo bx_format_price($upgrade_result['pricing_price'],$upgrade_result['currency']);?></font></td>
     <?php if(USE_DISCOUNT == "yes") {?>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <?php echo bx_format_price((($upgrade_result['pricing_price']*$upgrade_result['discount'])/100),$upgrade_result['currency'])." (".$upgrade_result['discount']." %)";?></font></td>
     <?php }?>
     <?php if(USE_VAT == "yes") {?>
     <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price(((($upgrade_result['listprice']-($upgrade_result['listprice']*$upgrade_result['discount'])/100))*$upgrade_result['vat']/100),$upgrade_result['currency'])." (".$upgrade_result['vat']." %)";?></font></td>
     <?php }?>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <?php echo bx_format_price($upgrade_result['totalprice'],$upgrade_result['currency']);?></font></td>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_INVOICES."?action=view&opid=".$upgrade_result['opid'], "auth_sess", $bx_session);?>"><?php echo bx_image(HTTP_IMAGES.$language."/view.gif",0,TEXT_VIEW);?></a></font></td>
    </tr>
   <?php
   }
   if ($rows==0) {
   ?>
        <tr bgcolor="<?php echo TABLE_BGCOLOR;?>">
            <td colspan="7" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="red"><?php echo TEXT_NOTHING_FOUND;?></font></td>
        </tr>
   <?php
   }
   ?>
   </table></td></tr></table>
   <?php
 }

if ($HTTP_GET_VARS['action']=="buy")
 {
  ?>
  <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>
  <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="2">
   <tr>
        <td colspan="2" width="35%" align="center" bgcolor="<?php echo LIST_HEADER_COLOR;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_ADDITIONAL_JOB_INVOICES;?></b></FONT></td>
        <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
   </tr>
   <tr bgcolor="<?php echo LIST_HEADER_COLOR;?>">
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <b>&nbsp;<?php echo TEXT_DATE_ADD;?>&nbsp;</b></font></td>
            <td width="25%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <b>&nbsp;<?php echo ucfirst(TEXT_JOBS);?>&nbsp;</b></font></td>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <b>&nbsp;<?php echo ucfirst(TEXT_FEATURED_JOBS);?>&nbsp;</b></font></td>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <b>&nbsp;<?php echo ucfirst(TEXT_RESUMES);?>&nbsp;</b></font></td>
            <td width="15%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <b>&nbsp;<?php echo TEXT_VIEW;?>&nbsp;</b></font></td>
  </tr>
  <?php
  $rows = 0;
  $buy_query=bx_db_query("select * from ".$bx_table_prefix."_invoices where compid='".$HTTP_SESSION_VARS['employerid']."' and op_type='0' and paid='Y' and validated='Y' order by date_added desc");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  while ($buy_result=bx_db_fetch_array($buy_query))
   {
   $rows++;
    if($buy_result['date_added']=='0000-00-00')
       {
         $buy_result['date_added']="<font face=".ERROR_TEXT_FONT_FACE." size=".ERROR_TEXT_FONT_SIZE." color=".ERROR_TEXT_FONT_COLOR.">not validated<font>";
       }
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_FIRST.'"';
    } else {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_SECOND.'"';
    }?>>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <?php echo bx_format_date($buy_result['date_added'], DATE_FORMAT);?></font></td>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <?php echo $buy_result['jobs'].' '.TEXT_JOB." (".bx_format_price($buy_result['1job'],$buy_result['currency'])."/".TEXT_JOB.")";?></font></td>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <?php echo $buy_result['featuredjobs'].' '.TEXT_FEATURED_JOB." (".bx_format_price($buy_result['1featuredjob'],$buy_result['currency'])."/".TEXT_FEATURED_JOB.")";?></font></td>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"> <?php echo $buy_result['contacts'].' '.TEXT_RESUME." (".bx_format_price($buy_result['1contact'],$buy_result['currency'])."/".TEXT_RESUME.")";?></font></td>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_INVOICES."?action=view&opid=".$buy_result['opid'], "auth_sess", $bx_session);?>"><?php echo bx_image(HTTP_IMAGES.$language."/view.gif",0,TEXT_VIEW);?></a></font></td>
    </tr>
   <?php
   }
   if ($rows==0) {
   ?>
        <tr bgcolor="<?php echo TABLE_BGCOLOR;?>">
            <td colspan="7" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="red"><?php echo TEXT_NOTHING_FOUND;?></font></td>
        </tr>
   <?php
   }
   ?>
   </table></td></tr></table>
   <?php
 }
?>
<BR>
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="right"><a href="javascript:self.history.back();" onmouseover="window.status='<?php echo TEXT_BACK;?>'; return true;" onmouseout="window.status = ''; return true;"><?php echo TEXT_BACK;?></a>
        </td>
    </tr>
</table>