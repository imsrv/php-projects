<?php
include(DIR_LANGUAGES.$language."/".FILENAME_MYINVOICES_FORM);
?>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
   <TR bgcolor="#FFFFFF">
      <TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_MY_INVOICES;?></TD>
   </TR>
   <TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
   </TR>
   <TR>
   <TD width="50%"><ul>
    <li><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_STATISTICS."?action=upgrade", "auth_sess", $bx_session);?>">Statistics for upgrade</a></li>
    <li><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_STATISTICS."?action=buy", "auth_sess", $bx_session);?>">Statistics for job purchase</a></li></ul>
   </TD>
   <TD align="right" width="50%"><form name="invlist"><b>List invoices by: </b><select name="inv" size="1" onChange="document.location.href=document.invlist.inv[document.invlist.inv.selectedIndex].value;"><option value="<?php echo bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, "auth_sess", $bx_session);?>" selected>-- Currently pending invoices --</option><option value="<?php echo bx_make_url(HTTP_SERVER.FILENAME_STATISTICS."?action=upgrade", "auth_sess", $bx_session);?>">-- Upgrade invoice list --</option><option value="<?php echo bx_make_url(HTTP_SERVER.FILENAME_STATISTICS."?action=buy", "auth_sess", $bx_session);?>">-- Job purchase invoice list --</option></select></form></TD></TR>
</table><br>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>
  <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="2">
    <tr>
     <td colspan="2" width="35%" align="center" bgcolor="<?php echo LIST_HEADER_COLOR;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_WAITING_PAYMENT;?></b></FONT></td>
     <td colspan="<?php echo (USE_DISCOUNT=="yes")?((USE_VAT=="yes")?"4":"3"):((USE_VAT=="yes")?"3":"2");?>" width="65%" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
  <?php
  $invoices_query=bx_db_query("select * from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.compid='".$HTTP_SESSION_VARS['employerid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_invoices.paid='N' and ".$bx_table_prefix."_invoices.updated='N' and ".$bx_table_prefix."_invoices.validated='N'");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $rows=0;
  if (bx_db_num_rows($invoices_query)>0) {
  ?>
        <tr bgcolor="<?php echo LIST_HEADER_COLOR;?>">
            <td width="25%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_PRICING_TYPE;?>&nbsp;</b></font></td>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_UPGRADE_VALUE;?>&nbsp;</b></font></td>
    <?php if(USE_DISCOUNT == "yes") {?>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_DISCOUNT_VALUE;?>&nbsp;</b></font></td>
    <?php }?>
    <?php if(USE_VAT == "yes") {?>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_VAT_VALUE;?>&nbsp;</b></font></td>
    <?php }?>
             <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_PAYMENT_VALUE;?>&nbsp;</b></font></td>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</b></font></td>
   </tr>
    <?php
  }
  while ($invoices_result=bx_db_fetch_array($invoices_query))
   {
   $rows++;
   ?>
  <tr <?php if(floor($rows/2) == ($rows/2)) {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_FIRST.'"';
    } else {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_SECOND.'"';
    }?>>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo $invoices_result['pricing_title'];?></font></td>
    <?php
     if ($invoices_result['op_type']==0) {
    ?>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoices_result['listprice'],$invoices_result['currency']);?></font></td>
    <?php
        }//end if ($invoices_result['op_type']==0)
        else {
    ?>
     <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoices_result['pricing_price'],$invoices_result['currency']);?></font></td>
    <?php
        }//end else if ($invoices_result['op_type']==0)
    if (USE_DISCOUNT == "yes") {
     if ($invoices_result['op_type']==0) {
    ?>
    <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price((($invoices_result['listprice']*$invoices_result['discount'])/100),$invoices_result['currency'])." (".$invoices_result['discount']."%)";?></font></td>  <?php
        }//end if ($invoices_result['op_type']==0)
        else {
        ?>
        <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price((($invoices_result['pricing_price']*$invoices_result['discount'])/100),$invoices_result['currency'])." (".$invoices_result['discount']."%)";?></font></td>
        <?php
      }//end else if ($invoices_result['op_type']==0)*/
    }//end if (USE_DISCOUNT == "yes"
    if (USE_VAT == "yes") {
    ?>
    <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price(((($invoices_result['listprice']-($invoices_result['listprice']*$invoices_result['discount'])/100))*$invoices_result['vat']/100),$invoices_result['currency'])." (".$invoices_result['vat']."%)";?></font></td>
    <?php
     }//end if (USE_VAT == "yes"
    ?>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoices_result['totalprice'],$invoices_result['currency']);?></font></td>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_INVOICES."?action=pay&opid=".$invoices_result['opid'], "auth_sess", $bx_session);?>"><?php echo bx_image(HTTP_IMAGES.$language."/pay.gif",0,TEXT_PAY);?></a>&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_INVOICES."?action=cancel&opid=".$invoices_result['opid'], "auth_sess", $bx_session);?>"><?php echo bx_image(HTTP_IMAGES.$language."/cancel.gif",0,TEXT_CANCEL);?></a></font></td>
    </tr>
   <?php
   }
   if ($rows==0) {
   ?>
        <tr bgcolor="#FFFFFF">
            <td colspan="6" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="red"><?php echo TEXT_NOTHING_FOUND;?></font></td>
        </tr>
   <?php
   }
   ?>
   </td></tr></table></td></tr></table><br>
   <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>
  <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="2">
    <tr>
     <td colspan="2" width="35%" align="center" bgcolor="<?php echo LIST_HEADER_COLOR;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_WAITING_UPDATE;?></b></FONT></td>
     <td colspan="<?php echo (USE_DISCOUNT=="yes")?((USE_VAT=="yes")?"4":"3"):((USE_VAT=="yes")?"3":"2");?>" bgcolor="#FFFFFF" width="65%">&nbsp;</td>
  </tr>
  <?php
  $invoices_query=bx_db_query("select * from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.compid='".$HTTP_SESSION_VARS['employerid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_invoices.paid='Y' and ".$bx_table_prefix."_invoices.updated='N' and ".$bx_table_prefix."_invoices.validated='Y'");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $rows=0;
  if (bx_db_num_rows($invoices_query)>0) {
  ?>
        <tr bgcolor="<?php echo LIST_HEADER_COLOR;?>">
            <td width="25%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_PRICING_TYPE;?>&nbsp;</b></font></td>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_UPGRADE_VALUE;?>&nbsp;</b></font></td>
         <?php if(USE_DISCOUNT == "yes") {?>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_DISCOUNT_VALUE;?>&nbsp;</b></font></td>
         <?php }?>
         <?php if(USE_VAT == "yes") {?>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_VAT_VALUE;?>&nbsp;</b></font></td>
         <?php }?>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_PAYMENT_VALUE;?>&nbsp;</b></font></td>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</b></font></td>
        </tr>
  <?php
  }
  while ($invoices_result=bx_db_fetch_array($invoices_query))
   {
   $rows++;
   ?>
<tr <?php if(floor($rows/2) == ($rows/2)) {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_FIRST.'"';
    } else {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_SECOND.'"';
    }?>>
          <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo $invoices_result['pricing_title'];?></font></td>
      <?php
     if ($invoices_result['op_type']==0) {
    ?>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoices_result['listprice'],$invoices_result['currency']);?></font></td>
    <?php
        }//end if ($invoices_result['op_type']==0)
        else {
    ?>
     <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoices_result['pricing_price'],$invoices_result['currency']);?></font></td>
    <?php
        }//end else if ($invoices_result['op_type']==0)
   if (USE_DISCOUNT == "yes") {
     if ($invoices_result['op_type']==0) {
    ?>
    <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price((($invoices_result['listprice']*$invoices_result['discount'])/100),$invoices_result['currency'])." (".$invoices_result['discount']."%)";?></font></td>  <?php
        }//end if ($invoices_result['op_type']==0)
        else {
    ?>
    <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price((($invoices_result['pricing_price']*$invoices_result['discount'])/100),$invoices_result['currency'])." (".$invoices_result['discount']."%)";?></font></td>
    <?php
        }//end else if ($invoices_result['op_type']==0)
    }//end if (USE_DISCOUNT == "yes")
    if (USE_VAT == "yes") {
    ?>
    <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price(((($invoices_result['listprice']-($invoices_result['listprice']*$invoices_result['discount'])/100))*$invoices_result['vat']/100),$invoices_result['currency'])." (".$invoices_result['vat']."%)";?></font></td>
    <?php
     }//end if (USE_VAT == "yes"
    ?>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoices_result['totalprice'],$invoices_result['currency']);?></font></td>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_INVOICES."?action=update&opid=".$invoices_result['opid'], "auth_sess", $bx_session);?>"><?php echo bx_image(HTTP_IMAGES.$language."/update.gif",0,TEXT_UPDATE);?></a>&nbsp;<a href="javascript: ;" onmouseOver="window.status='<?php echo TEXT_PRINTER_FRIENDLY;?>'; return true;" onmouseOut="window.status=''; return true;" onClick="newwind = window.open('<?php echo bx_make_url(HTTP_SERVER."print_version.php", "auth_sess", $bx_session);?>&url='+escape('<?php echo HTTP_SERVER.FILENAME_INVOICES."?action=view&opid=".$invoices_result['opid']."&printit=yes";?>'),'_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=500,height=520,screenX=50,screenY=100');"><?php echo bx_image(HTTP_IMAGES.$language."/printit.gif",0,"");?></a></font></td>
    </tr>
   <?php
   }
   if ($rows==0) {
   ?>
        <tr bgcolor="#FFFFFF">
            <td colspan="6" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="#FF0000"><?php echo TEXT_NOTHING_FOUND;?></font></td>
        </tr>
   <?php
   }
   ?>
  </td></tr></table></td></tr></table><br>
   <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>
  <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="2">
  <tr>
     <td colspan="2" width="35%" align="center" bgcolor="<?php echo LIST_HEADER_COLOR;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_WAITING_VALIDATION;?></b></FONT></td>
     <td colspan="<?php echo (USE_DISCOUNT=="yes")?((USE_VAT=="yes")?"4":"3"):((USE_VAT=="yes")?"3":"2");?>" bgcolor="#FFFFFF" width="65%">&nbsp;</td>
  </tr>
  <?php
  $invoices_query=bx_db_query("select * from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.compid='".$HTTP_SESSION_VARS['employerid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_invoices.paid='Y' and ".$bx_table_prefix."_invoices.updated='N' and ".$bx_table_prefix."_invoices.validated='N'");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $rows=0;
  if (bx_db_num_rows($invoices_query)>0) {
  ?>
    <tr bgcolor="<?php echo LIST_HEADER_COLOR;?>">
            <td width="25%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_PRICING_TYPE;?>&nbsp;</b></font></td>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_UPGRADE_VALUE;?>&nbsp;</b></font></td>
         <?php if(USE_DISCOUNT == "yes") {?>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_DISCOUNT_VALUE;?>&nbsp;</b></font></td>
         <?php }?>
         <?php if(USE_VAT == "yes") {?>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_VAT_VALUE;?>&nbsp;</b></font></td>
         <?php }?>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_PAYMENT_VALUE;?>&nbsp;</b></font></td>
            <td width="20%" align="center"><font face="Verdana" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b>&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</b></font></td>
   </tr>
  <?php
  }
  while ($invoices_result=bx_db_fetch_array($invoices_query))
   {
   $rows++;
   ?>
   <tr <?php if(floor($rows/2) == ($rows/2)) {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_FIRST.'"';
    } else {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_SECOND.'"';
    }?>>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo $invoices_result['pricing_title'];?></font></td>
        <?php
     if ($invoices_result['op_type']==0) {
    ?>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoices_result['listprice'],$invoices_result['currency']);?></font></td>
    <?php
        }//end if ($invoices_result['op_type']==0)
        else {
    ?>
     <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoices_result['pricing_price'],$invoices_result['currency']);?></font></td>
    <?php
        }//end else if ($invoices_result['op_type']==0)
    if (USE_DISCOUNT == "yes") {
     if ($invoices_result['op_type']==0) {
    ?>
    <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price((($invoices_result['listprice']*$invoices_result['discount'])/100),$invoices_result['currency'])." (".$invoices_result['discount']."%)";?></font></td>  <?php
        }//end if ($invoices_result['op_type']==0)
        else {
    ?>
    <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price((($invoices_result['pricing_price']*$invoices_result['discount'])/100),$invoices_result['currency'])." (".$invoices_result['discount']."%)";?></font></td>
    <?php
        }//end else if ($invoices_result['op_type']==0)
      }//end if (USE_DISCOUNT == "yes")
      if (USE_VAT == "yes") {
    ?>
    <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price(((($invoices_result['listprice']-($invoices_result['listprice']*$invoices_result['discount'])/100))*$invoices_result['vat']/100),$invoices_result['currency'])." (".$invoices_result['vat']."%)";?></font></td>
    <?php
     }//end if (USE_VAT == "yes"
    ?>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_price($invoices_result['totalprice'],$invoices_result['currency']);?></font></td>
      <td align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_INVOICES."?action=view&opid=".$invoices_result['opid'], "auth_sess", $bx_session);?>"><?php echo bx_image(HTTP_IMAGES.$language."/view.gif",0,TEXT_VIEW);?></a>&nbsp;<a href="javascript: ;" onmouseOver="window.status='<?php echo TEXT_PRINTER_FRIENDLY;?>'; return true;" onmouseOut="window.status=''; return true;" onClick="newwind = window.open('<?php echo bx_make_url(HTTP_SERVER."print_version.php", "auth_sess", $bx_session);?>&url='+escape('<?php echo HTTP_SERVER.FILENAME_INVOICES."?action=view&opid=".$invoices_result['opid']."&printit=yes";?>'),'_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=500,height=520,screenX=50,screenY=100');"><?php echo bx_image(HTTP_IMAGES.$language."/printit.gif",0,"");?></a></font></td>
    </tr>
    <?php
   }
 if ($rows==0) {
   ?>
        <tr bgcolor="#FFFFFF">
            <td colspan="6" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="#FF0000"><?php echo TEXT_NOTHING_FOUND;?></font></td>
        </tr>
   <?php
   }
   ?>
</table></td></tr></table>