<?php
//include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_MEMBERSHIP_FORM);
    $company_query=bx_db_query("SELECT *,".$bx_table_prefix."_companycredits.jobs as jobs,".$bx_table_prefix."_companycredits.featuredjobs as fjobs,".$bx_table_prefix."_companycredits.contacts as contacts FROM ".$bx_table_prefix."_membership,".$bx_table_prefix."_companycredits,".$bx_table_prefix."_pricing_".$bx_table_lng.",".$bx_table_prefix."_companies where ".$bx_table_prefix."_membership.compid='".$HTTP_SESSION_VARS['employerid']."' and ".$bx_table_prefix."_companies.compid='".$HTTP_SESSION_VARS['employerid']."' and ".$bx_table_prefix."_companycredits.compid='".$HTTP_SESSION_VARS['employerid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_membership.pricing_id");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    $company_result=bx_db_fetch_array($company_query);
    $numberofjobs_query=bx_db_query("select * from ".$bx_table_prefix."_companycredits where ".$bx_table_prefix."_companycredits.compid='".$HTTP_SESSION_VARS['employerid']."'");
    $numberofjobs_result=bx_db_fetch_array($numberofjobs_query);
    $result=bx_db_query("SELECT * FROM ".$bx_table_prefix."_pricing_".$bx_table_lng." where pricing_id>'0' order by pricing_id");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
?>
<?php if($error!=0)
  {
   echo bx_table_header(ERRORS_OCCURED);
    echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\"><b>";
   if($jobs_error==1)
      {
        echo JOBS_ERROR."<br>";
      }
    if(USE_FEATURED_JOBS == "yes") {
        if($fjobs_error==1)
          {
            echo FJOBS_ERROR."<br>";
          }
    }      
    if($resumes_error==1)
      {
        echo RESUMES_ERROR."<br>";
      }
     echo "</b></font>";
  }//end if error!=0
?>

<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" align="center" border="0" cellspacing="0" cellpadding="2">
	<TR bgcolor="#FFFFFF">
      <TD width="100%" align="center" class="headertdjob"><?php echo TEXT_MEMBERSHIP;?></TD>
	</TR>
   <TR><TD><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
   </TR>
  <TR bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>">
   <?php
   if ($company_result['pricing_title']!="")
   {
   ?>
     <td align="center" style="border: 1px solid #000000"><font color="#FFFFFF"><b><?php echo TEXT_COMPANY_USE." \"".$company_result['pricing_title'];?>"!</font></b></td>
   <?php
   }//end if ($company_result['pricing_title']!="")
   else {
   ?>
   <td align="center"><b><?php echo TEXT_NO_MEMBERSHIP;?></b></td>
   <?php
    }//end else if ($company_result['pricing_title']!="")
   ?>
   </tr>
   <?php
   if ($company_result['expire']!='0000-00-00' && $company_result['expire']!='') {
       echo "<tr><td align=\"center\"><b>".TEXT_AVAILABLE.": ".bx_format_date($company_result['expire'], DATE_FORMAT)."</b></td></tr>";
   }
   ?>
   <tr>
       <td>
           <table border="1" align="center" cellpadding="3" cellspacing="1">
                 <tr bgcolor="#A9A9CC">
                     <td colspan="<?php echo (USE_FEATURED_JOBS=="yes")?3:2;?>" align="center"><b><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="#FFFFFF"><?php echo TEXT_CURRENTLY;?></font></b></td>
                     <?php if(USE_FEATURED_COMPANIES == "yes") {?>
                     <td align="center" rowspan="2"><b><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="#FFFFFF"><?php echo ucfirst(TEXT_FEATURED_COMPAN);?></font></b></td>
                     <?php }?>
                 </tr>
                 <tr>
                     <td align="center">&nbsp;<?php echo TEXT_RESUMES;?>&nbsp;</td>
                     <td align="center">&nbsp;<?php echo TEXT_JOBS;?>&nbsp;</td>
                     <?php if(USE_FEATURED_JOBS == "yes") {?>
                     <td align="center">&nbsp;<?php echo TEXT_FEATURED_JOBS_MEMBERSHIP;?>&nbsp;</td>
                     <?php }?>
                 </tr>
                 <tr>
                     <td align="center"><b><?php if($numberofjobs_result['contacts']==999) {echo TEXT_UNLIMITED;} else {echo $numberofjobs_result['contacts'];}?></b></td>
                     <td align="center"><b><?php if($numberofjobs_result['jobs']==999) {echo TEXT_UNLIMITED;} else {echo $numberofjobs_result['jobs'];}?></b></td>
                     <?php if(USE_FEATURED_JOBS == "yes") {?>
                     <td align="center"><b><?php echo $numberofjobs_result['featuredjobs']." ";?></b></td>
                     <?php }?>
                     <?php if(USE_FEATURED_COMPANIES == "yes") {?>
                     <td align="center"><b><?php if($company_result['featured']=='1') {echo TEXT_YES;} else {echo TEXT_NO;}?></b></td>
                     <?php }?>
                 </tr>
            </table>
       </td>
   </tr>
   <tr>
       <td><br></td>
   </tr>
    <tr><td class="td4impmess"><?php echo TEXT_PLANNING_NOTE;?></td></tr>
    <tr><td>&nbsp;</td></tr>
   <?php
  if (USE_DISCOUNT == "yes" || ($company_result['discount']!=0)) {
   if ($company_result['discount']) {
   ?>
   <tr>
       <td class="td4impmess"><b><font color="red"><?php echo TEXT_VERY_IMPORTANT;?></font>&nbsp;<br><center><font face="<?php echo TEXT_FONT_FACE;?>" size="2" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_NOW;?> <?php echo $company_result['discount'];?>% <?php echo TEXT_FOR_EVERY;?></font></center></b></td>
   </tr>
   <tr>
       <td><br></td>
   </tr>
   <?php
   }
   elseif (DISCOUNT_PROCENT) {
   ?>
   <tr>
       <td class="td4impmess"><b><font color="red"><?php echo TEXT_VERY_IMPORTANT?></font>&nbsp;<br><center><font face="<?php echo TEXT_FONT_FACE?>" size="2" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_NOW;?> <?php echo DISCOUNT_PROCENT;?>% <?php echo TEXT_FOR_EVERY;?></font></center></b></td>
   </tr>
   <tr>
       <td><br></td>
   </tr>
   <?php }
   }//end if (USE_DISCOUNT == "yes");?>
</table>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="1" cellspacing="0" cellpadding="2">
<form action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);?>" method="post">
    <TR bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>">
      <TD width="33%" align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="#FFFFFF"><B><?php echo TEXT_MEMBERSHIP_TYPE;?></B></font>
      </TD>
      <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="#FFFFFF"><small><B><?php echo TEXT_RESUMES;?></B></small></font>
      </TD>
      <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="#FFFFFF"><small><B><?php echo TEXT_JOBS;?></B></small></font>
      </TD>
      <?php if(USE_FEATURED_JOBS == "yes") {?>
      <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="#FFFFFF"><small><B><?php echo TEXT_FEATURED_JOBS_MEMBERSHIP;?></B></small></font>
      </TD>
      <?php }?>
      <?php if(USE_FEATURED_COMPANIES == "yes") {?>
      <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="#FFFFFF"><small><B><?php echo TEXT_FEATURED_COMPAN;?></B></small></font>
      </TD>
      <?php }?>
      <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="#FFFFFF"><small><B><?php echo TEXT_PERIOD;?></B></small></font>
      </TD>
      <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="#FFFFFF"><small><B><?php echo TEXT_PRICE;?></B></small></font>
      </TD>
    </TR>
<?php

    $i=1;
    while($pricing=bx_db_fetch_array($result))
       {
        if($pricing['pricing_avjobs']=='999')
          {
            $pricing['pricing_avjobs']=TEXT_UNLIMITED;
          }
        if($pricing['pricing_avsearch']=='999')
          {
            $pricing['pricing_avsearch']=TEXT_UNLIMITED;
          }
?>
    <TR>
      <TD align="left">
        <input type="radio" class="radio" name="radio" value="<?php echo $pricing['pricing_id'];?>"<?php if($pricing['pricing_id']==$company_result['pricing_id']) {echo " checked";$curent_title=$pricing['pricing_title'];$curent_period=$pricing['pricing_period'];};?>>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><?php echo $pricing['pricing_title'];?></small></font>
      </TD>
      <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><?php echo $pricing['pricing_avsearch'];?></small></font>
      </TD>
      <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><?php echo $pricing['pricing_avjobs'];?></small></font>
      </TD>
      <?php if(USE_FEATURED_JOBS == "yes") {?>
      <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><?php echo $pricing['pricing_fjobs'];?></small></font>
      </TD>
      <?php }?>
      <?php if(USE_FEATURED_COMPANIES == "yes") {?>
      <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><?php echo $pricing['pricing_fcompany'];?></small></font>
      </TD>
      <?php }?>
      <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><?php echo $pricing['pricing_period']." ".TEXT_MONTHS;?></small></font>
      </TD>
      <TD align="center" nowrap>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><?php echo bx_format_price($pricing['pricing_price'],$pricing['pricing_currency']);?></small></font>
      </TD>
    </TR>
<?php
    $i++;
   }
?>
</table>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
 <td align="center" valign="middle"><br><input type="submit" name="upgrade" value=" <?php echo TEXT_UPGRADE;?> " onClick="return confirm('<?php echo eregi_replace('"','&#034;',eregi_replace("'","\\'",TEXT_JS_MEMEBERSHIP_UPGRADE));?>')"></td>
</tr>
<input type="hidden" name="action" value="upgrade">
<input type="hidden" name="current_pricing" value="<?php echo $company_result['pricing_id'];?>">
</form>
</TABLE>
<br>
<br>
<?php
  if (USE_DISCOUNT == "yes" || ($company_result['discount']!=0)) {
   if ($company_result['discount']) {
   ?>
   <table width="100%" cellpadding="0" cellspacing="0" border="0">
   <tr>
       <td class="td4impmess"><b><font color="red"><?php echo TEXT_VERY_IMPORTANT;?></font>&nbsp;<br><center><font face="<?php echo TEXT_FONT_FACE;?>" size="2" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_NOW;?> <?php echo $company_result['discount'];?>% <?php echo TEXT_FOR_EVERY_JOBS;?></font></center></b></td>
   </tr>
   <tr>
       <td><br></td>
   </tr>
   </table>
   <?php
   }
   elseif (DISCOUNT_PROCENT_JOBS) {
   ?>
   <table width="100%" cellpadding="0" cellspacing="0" border="0">
   <tr>
       <td class="td4impmess"><b><font color="red"><?php echo TEXT_VERY_IMPORTANT;?></font>&nbsp;<br><center><font face="<?php echo TEXT_FONT_FACE;?>" size="2" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_NOW;?> <?php echo DISCOUNT_PROCENT_JOBS;?>% <?php echo TEXT_FOR_EVERY_JOBS;?></font></center></b></td>
   </tr>
   <tr>
       <td><br></td>
   </tr>
   </table>
<?php }
   } //end if (USE_DISCOUNT);?>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="1" cellspacing="0" cellpadding="2">
   <form action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);?>" method="post" name="membership_form" onSubmit="if (check_form()) { return confirm('<?php echo eregi_replace('"','&#034;',eregi_replace("'","\\'",TEXT_JS_BUY));?>'+calc_price());} else {return false;}">
    <input type="hidden" name="action" value="buy">
    <TR bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>">
      <TD colspan="<?php echo (USE_FEATURED_JOBS=="yes")?4:3;?>" align="right" valign="middle" width="100%">
        <font face="<?php echo HEADING_FONT_FACE;?>" size="<?php echo HEADING_FONT_SIZE;?>" color="#FFFFFF"><B><SMALL><?php echo TEXT_BUY_ADDITIONAL;?></SMALL></B></FONT>
      </TD>
    </TR>
    <tr>
     <td width="10%" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_BUY;?></B></FONT></td>
     <td width="30%" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><?php echo TEXT_BUY_JOBS." ".bx_format_price(JOBS_PRICE,PRICE_CURENCY)."/".TEXT_JOBS;?></small></font></td>
     <?php if(USE_FEATURED_JOBS == "yes") {?>
     <td width="30%" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><?php echo TEXT_BUY_FEATURED_JOBS." ".bx_format_price(FEATURED_JOBS_PRICE,PRICE_CURENCY)."/".TEXT_FEATURED_JOBS_MEMBERSHIP;?></small></FONT></td>
     <?php }?>
     <td width="30%" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><?php echo TEXT_BUY_RESUMES." ".bx_format_price(RESUMES_PRICE,PRICE_CURENCY)."/".TEXT_RESUMES;?></small></FONT></td>
   </tr>
   <tr>
    <td width="10%" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_QUANTITY;?>:</B></FONT></td>
    <td width="30%" align="center"><input type="text" name="jobs" size="10"  value="<?php echo $HTTP_POST_VARS['jobs'];?>"></td>
    <?php if(USE_FEATURED_JOBS == "yes") {?>
    <td width="30%" align="center"><input type="text" name="fjobs" size="10" value="<?php echo $HTTP_POST_VARS['fjobs'];?>"></td>
    <?php }
    else {
        echo "<input type=\"hidden\" name=\"fjobs\" value=\"0\">";
    }
    ?>
    <td width="30%" align="center"><input type="text" name="resumes" size="10" value="<?php echo $HTTP_POST_VARS['resumes'];?>"></td>
   </tr>
   </table>
   <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
     <td align="center"><br><input type="submit" name="buy" value="<?php echo TEXT_BUY;?>"></td>
   </tr>
   </table>
</form>