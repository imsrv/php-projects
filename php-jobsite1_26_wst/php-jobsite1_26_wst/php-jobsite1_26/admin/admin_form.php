<?php include(DIR_LANGUAGES.$language."/".FILENAME_ADMIN_FORM);?>
<?php
if($HTTP_POST_VARS['action']) {
    $action=$HTTP_POST_VARS['action'];
}
elseif ($HTTP_GET_VARS['action']){
     $action = $HTTP_GET_VARS['action'];
}
else {
    $action = '';
}
if ($HTTP_GET_VARS['action']=="companies")
{
if ($HTTP_GET_VARS['from'])
  {
  $item_from=$HTTP_GET_VARS['from'];
  $item_to=$item_from+NR_DISPLAY;
  }
  else
  {
  $item_from=0;
  $item_to=NR_DISPLAY;
  }
  if ($HTTP_GET_VARS['pricing'])
  {
      $pricing_id=$HTTP_GET_VARS['pricing'];
      $check_first = false;
  }
  else
  {
      $pricing_id=1;
      $check_first = true;
  }
  $position = 0;
  $pricing_query=bx_db_query("select pricing_id,pricing_title from ".$bx_table_prefix."_pricing_".$bx_table_lng." where pricing_id>0");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  ?>
  <table width="100%" cellspacing="0" cellpadding="0" border="1">
  <tr>
     <?php
     $row=0;
     while ($pricing_result=bx_db_fetch_array($pricing_query))
      {
      if($check_first && $row == 0) {
          $pricing_id = $pricing_result['pricing_id'];
          $position = $row;
      }
      elseif($pricing_result['pricing_id'] == $pricing_id) {
          $position = $row;
      }
     ?>
     <td align="center" bgcolor="#008080"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?action=<?php echo $action;?>&pricing=<?php echo $pricing_result['pricing_id'];?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo $pricing_result['pricing_title'];?></font></a></td>
     <?php
      $row++;
      } //end while pricing_result
     ?>
  </tr>
  </table>
  <?php
   $try=bx_db_data_seek($pricing_query,$position);
   $title_result=bx_db_fetch_array($pricing_query);
  ?>
  <br>
    <center><font face="Verdana, Arial" color="#000000" size="+1"><?php echo TEXT_COMPANIES_WITH;?><b></font> <font face="Verdana,Arial" color="#4B9E66" size="+1"><?php echo $title_result['pricing_title'];?></center>
  <br>
    <table width="100%" cellpadding="1" cellspacing="1" border="0" class="listtable">
    <tr><td colspan="6" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <tr class="listhead">
            <td width="5%" align="center">&nbsp;<?php echo TEXT_ID;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_COMPANY_NAME;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_SIGNUP_DATE;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_PAYMENT_VALUE;?>&nbsp;</td>
            <td width="15%" align="center">&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</td>
  </tr>
  <?php
  $rows=0;
  $item=0;
  $pricing_query = bx_db_query("select pricing_id from ".$bx_table_prefix."_pricing_".$bx_table_lng." where pricing_default = '1' and pricing_id=".$pricing_id);
  if (bx_db_num_rows($pricing_query)>0) {
        $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies,".$bx_table_prefix."_pricing_".$bx_table_lng.",".$bx_table_prefix."_membership where ".$bx_table_prefix."_membership.pricing_id='".$pricing_id."' and ".$bx_table_prefix."_membership.pricing_id = ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_membership.compid group by ".$bx_table_prefix."_membership.compid");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  }
  else {
        $company_query =  bx_db_query("select *,sum(".$bx_table_prefix."_invoices.totalprice) as company_value from ".$bx_table_prefix."_companies,".$bx_table_prefix."_pricing_".$bx_table_lng.",".$bx_table_prefix."_invoices,".$bx_table_prefix."_membership where ".$bx_table_prefix."_membership.pricing_id='".$pricing_id."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_membership.pricing_id and ".$bx_table_prefix."_invoices.op_type=1 and ".$bx_table_prefix."_invoices.compid=".$bx_table_prefix."_membership.compid and ".$bx_table_prefix."_invoices.paid='Y' and ".$bx_table_prefix."_invoices.validated='Y' and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_invoices.compid group by ".$bx_table_prefix."_membership.compid");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  }
  while ($company_result=bx_db_fetch_array($company_query))
  {
  $rows++;
  $item++;
   if (($item<=$item_to) and ($item>=$item_from+1))
   {
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {echo 'bgcolor="#ffffff"';} else {echo 'bgcolor="#f4f7fd"';}?>>
      <td align="center"><?php echo $company_result['compid'];?></td>
     <td align="center"><?php echo $company_result['company'];?></td>
     <td align="center"><?php echo $company_result['signupdate'];?></td>
     <td align="center"><?php if($company_result['company_value']) {echo bx_format_price($company_result['company_value'],$company_result['currency']);} else { echo "0";}?></td>
     <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&compid=<?php echo $company_result['compid'];?>">Details</a></td>
  </tr>
   <?php
   } //end if
  } //end while $referer_result
  $item_back_from=$item_from;
  $item_from=$item_to;
  $item_to=$item_from+NR_DISPLAY;
  if (!$rows) {
      echo "<tr><td colspan=\"6\" align=\"center\" class=\"errortd\">Nothing found</td></tr>";
  }
  ?>
    </table>
  <br>
  <table width="100%"> 
  <tr>
  <?php
  if ($item_from>NR_DISPLAY)
   {
  ?>
  <td colspan="2" align="left"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?action=<?php echo $action;?>&pricing=<?php echo $HTTP_GET_VARS['pricing'];?>&from=<?php echo $item_back_from-NR_DISPLAY;?>" class="nxt"><b><?php echo PREVIOUS.' '.NR_DISPLAY;?></b></a></td>
  <?php
   }
  if ($item_from<bx_db_num_rows($company_query))
  {
   ?>
  <td colspan="5" align="right"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?action=<?php echo $action;?>&pricing=<?php echo $HTTP_GET_VARS['pricing'];?>&from=<?php echo $item_from;?>" class="nxt"><b><?php echo NEXT.' '.NR_DISPLAY;?></b></a></td>
  <?php
  }
  ?>
  </tr>
  </table>
<?php
}//end if action==companies
?>

<?php
if ($HTTP_GET_VARS['action']=="upgrades")
{
if ($HTTP_GET_VARS['from'])
  {
  $item_from=$HTTP_GET_VARS['from'];
  //$item_to=$HTTP_GET_VARS['to'];
  $item_to=$item_from+NR_DISPLAY;
  }
  else
  {
  $item_from=0;
  $item_to=NR_DISPLAY;
  }
  $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies,".$bx_table_prefix."_invoices where ".$bx_table_prefix."_invoices.op_type=1 and ".$bx_table_prefix."_invoices.validated='N' and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_invoices.compid");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $no_of_res = bx_db_num_rows($company_query);
  ?>
   <table width="100%" cellpadding="1" cellspacing="1" border="0" class="listtable">
  <tr><td colspan="7" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <TR bgcolor="#FFFFFF"><td colspan="7" align="right" class="searchhead">Search upgrades Showing <?php echo " (".$item_from." to ".$item_to." from ".$no_of_res.")";?></td></tr>
  <tr><td colspan="7" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <tr class="listhead">
            <td width="5%" align="center">&nbsp;<?php echo TEXT_ID;?>&nbsp;</td>
	        <td width="35%" align="center">&nbsp;<?php echo TEXT_COMPANY_NAME;?>&nbsp;</td>
            <td width="15%" align="center">&nbsp;<?php echo TEXT_DATE_ADDED;?>&nbsp;</td>
            <td width="15%" align="center">&nbsp;<?php echo TEXT_PAYMENT_VALUE;?>&nbsp;</td>
            <td width="15%" align="center">&nbsp;Current <?php echo TEXT_MEMBERSHIP;?>&nbsp;</td>
            <td width="15%" align="center">&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</td>
  </tr>
  <?php
  $rows=0;
  $item=0;
  while ($company_result=bx_db_fetch_array($company_query))
  {
  $rows++;
  $item++;

   if (($item<=$item_to) and ($item>=$item_from+1))
   {
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {echo 'bgcolor="#ffffff"';} else {echo 'bgcolor="#f4f7fd"';}?>>
      <td align="center"><?php echo $company_result['opid'];?></td>
      <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&compid=<?php echo $company_result['compid'];?>"><?php echo $company_result['company'];?></a></td>
      <td align="center"><?php echo $company_result['date_added'];?></td>
      <td align="center"><?php echo bx_format_price($company_result['totalprice'],$company_result['currency']);?></td>
      <td align="center"><?php 
        $membership_query = bx_db_query("SELECT * from ".$bx_table_prefix."_membership,".$bx_table_prefix."_pricing_".$bx_table_lng." where  ".$bx_table_prefix."_membership.compid='".$company_result['compid']."' and  ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_membership.pricing_id");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        if (bx_db_num_rows($membership_query)>0) {
            $membership_result = bx_db_fetch_array($membership_query);
            echo $membership_result['pricing_title'];
        }
        else {
            echo TEXT_NO_PLANNING;
        }
      ?></td>
      <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=<?php echo $action;?>&compid=<?php echo $company_result['compid'];?>&opid=<?php echo $company_result['opid'];?>">Details</a></td>
    </tr>
   <?php
   } //end if
  } //end while $referer_result
  $item_back_from=$item_from;
  $item_from=$item_to;
  $item_to=$item_from+NR_DISPLAY;
  if (!$rows) {
      echo "<tr><td colspan=\"7\" align=\"center\" class=\"errortd\">Nothing found</td></tr>";
  }
  ?>
  </table>
  <br>
  <table width="100%"> 
  <tr>
  <?php
  if ($item_from>NR_DISPLAY)
   {
  ?>
  <td colspan="2" align="left"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?action=<?php echo $action;?>&from=<?php echo $item_back_from-NR_DISPLAY;?>" class="nxt"><b><?php echo PREVIOUS.' '.NR_DISPLAY;?></b></a></td>
  <?php
   }
  if ($item_from<bx_db_num_rows($company_query))
  {
   ?>
  <td colspan="5" align="right"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?action=<?php echo $action;?>&from=<?php echo $item_from;?>" class="nxt"><b><?php echo NEXT.' '.NR_DISPLAY;?></b></a></td>
  <?php
  }
  ?>
  </tr>
  </table>
<?php
}//end if action==upgrades


if ($HTTP_GET_VARS['action']=="buyers")
{
if ($HTTP_GET_VARS['from'])
  {
  $item_from=$HTTP_GET_VARS['from'];
  //$item_to=$HTTP_GET_VARS['to'];
  $item_to=$item_from+NR_DISPLAY;
  }
  else
  {
  $item_from=0;
  $item_to=NR_DISPLAY;
  }
  $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies,".$bx_table_prefix."_invoices where ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_invoices.compid and ".$bx_table_prefix."_invoices.pricing_type='0' and ".$bx_table_prefix."_invoices.validated='N' and ".$bx_table_prefix."_invoices.paid='Y' group by ".$bx_table_prefix."_companies.compid");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $no_of_res = bx_db_num_rows($company_query);
  ?>
  <table width="100%" cellpadding="1" cellspacing="1" border="0" class="listtable">
  <tr><td colspan="10" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <TR bgcolor="#FFFFFF"><td colspan="10" align="right" class="searchhead">Search buyers Showing <?php echo " (".$item_from." to ".$item_to." from ".$no_of_res.")";?></td></tr>
  <tr><td colspan="10" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <tr class="listhead">
            <td width="5%" align="center">&nbsp;<?php echo TEXT_ID;?>&nbsp;</td>
	        <td width="13%" align="center">&nbsp;<?php echo TEXT_COMPANY_NAME;?>&nbsp;</td>
            <td width="13%" align="center">&nbsp;<?php echo TEXT_DATE_ADDED;?>&nbsp;</td>
            <td width="13%" align="center">&nbsp;<?php echo TEXT_JOBS;?>&nbsp;</td>
            <td width="13%" align="center">&nbsp;<?php echo TEXT_FEATURED_JOBS;?>&nbsp;</td>
            <td width="13%" align="center">&nbsp;<?php echo TEXT_SEARCH;?>&nbsp;</td>
            <td width="13%" align="center">&nbsp;<?php echo TEXT_JOBS_PRICE;?>&nbsp;</td>
            <td width="13%" align="center">&nbsp;<?php echo TEXT_FEATURED_JOBS_PRICE;?>&nbsp;</td>
            <td width="13%" align="center">&nbsp;<?php echo TEXT_SEARCH_PRICE;?>&nbsp;</td>
            <td width="13%" align="center">&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</td>
  </tr>
  <?php
  $rows=0;
  $item=0;
  while ($company_result=bx_db_fetch_array($company_query))
  {
  $rows++;
  $item++;
  $value=$company_result['jobs']*$company_result['jobs_price']+$company_result['fjobs']*$company_result['fjobs_price']+$company_result['search']*$company_result['search_price'];
   if (($item<=$item_to) and ($item>=$item_from+1))
   {
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {echo 'bgcolor="#ffffff"';} else {echo 'bgcolor="#f4f7fd"';}?>>
      <td align="center"><?php echo $company_result['opid'];?></td>
	  <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&compid=<?php echo $company_result['compid'];?>"><?php echo $company_result['company'];?></a></td>
      <td align="center"><?php echo $company_result['date_added'];?></td>
      <td align="center"><?php echo $company_result['jobs']."<br>".bx_format_price($company_result['1job'],$company_result['currency']).'/'."J";?></td>
      <td align="center"><?php echo $company_result['featuredjobs']."<br>".bx_format_price($company_result['1featuredjob'],$company_result['currency']).'/'."FJ";?></td>
      <td align="center"><?php echo $company_result['contacts']."<br>".bx_format_price($company_result['1contact'],$company_result['currency']).'/'."C";?></td>
      <td align="center"><?php echo bx_format_price($company_result['1job']*$company_result['jobs'],$company_result['currency']);?></td>
      <td align="center"><?php echo bx_format_price($company_result['1featuredjob']*$company_result['featuredjobs'],$company_result['currency']);?></td>
      <td align="center"><?php echo bx_format_price($company_result['1contact']*$company_result['contacts'],$company_result['currency']);?></td>
      <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=<?php echo $action;?>&compid=<?php echo $company_result['compid'];?>&opid=<?php echo $company_result['opid'];?>">Details</a></td>
    </tr>
   <?php
   } //end if
  } //end while $referer_result
  $item_back_from=$item_from;
  $item_from=$item_to;
  $item_to=$item_from+NR_DISPLAY;
  if (!$rows) {
      echo "<tr><td colspan=\"10\" align=\"center\" class=\"errortd\">Nothing found</td></tr>";
  }
  ?>
  </table>
  <br>
  <table width="100%"> 
  <tr>
  <?php
  if ($item_from>NR_DISPLAY)
   {
  ?>
  <td colspan="2" align="left"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?action=<?php echo $action;?>&from=<?php echo $item_back_from-NR_DISPLAY;?>" class="nxt"><b><?php echo PREVIOUS.' '.NR_DISPLAY;?></b></a></td>
  <?php
   }
  if ($item_from<bx_db_num_rows($company_query))
  {
   ?>
  <td colspan="8" align="right"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?action=<?php echo $action;?>&from=<?php echo $item_from;?>" class="nxt"><b><?php echo NEXT.' '.NR_DISPLAY;?></b></a></td>
  <?php
  }
  ?>
  </tr>
  </table>
<?php
}//end if ($HTTP_GET_VARS['action']=='buyers')
?>
<?php
if ($HTTP_GET_VARS['all']=="employers")
{
if ($HTTP_GET_VARS['from'])
  {
  $item_from=$HTTP_GET_VARS['from'];
  //$item_to=$HTTP_GET_VARS['to'];
  $item_to=$item_from+NR_DISPLAY;
  }
  else
  {
  $item_from=0;
  $item_to=NR_DISPLAY;
  }
  $query = "select *,UNIX_TIMESTAMP(".$bx_table_prefix."_companies.lastlogin)-UNIX_TIMESTAMP(NOW()) as mytime, DATE_FORMAT(lastlogin,'%d %M %Y') as lastlogin_formated from ".$bx_table_prefix."_companies, ".$bx_table_prefix."_companycredits where ".$bx_table_prefix."_companycredits.compid = ".$bx_table_prefix."_companies.compid";
  if (!empty($HTTP_GET_VARS['o'])) {
       $query .= " order by ".$HTTP_GET_VARS['o'];
  }
  else {
      $query .= " order by ".$bx_table_prefix."_companies.signupdate desc";
  }
  $company_query=bx_db_query($query);
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $no_of_res = bx_db_num_rows($company_query);
  ?>
    <table width="100%" cellpadding="1" cellspacing="1" border="0" class="listtable">
   <tr>
	  <?php
     if (empty($HTTP_GET_VARS['show'])) {
     ?>
     <td colspan="10" align="right"><form><font face="Verdana, Arial" color="#000000" size="1"><input type="checkbox" class="check" name="showall" onClick="go('<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=<?php echo $HTTP_GET_VARS['o'];?>&show=page');"> Show all in one page.</font></td></form>
     <?php
      }
      else {
      ?>
      <td colspan="10" align="right"><form><font face="Verdana, Arial" color="#000000" size="1"><input type="checkbox" class="check" name="showall" onClick="go('<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=<?php echo $HTTP_GET_VARS['o'];?>');" checked> Show all in one page.</font></td></form>
      <?php
      }
     ?>
   </tr>
     <tr><td colspan="10" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <TR bgcolor="#FFFFFF"><td colspan="10" align="right" class="searchhead">All companies Showing <?php echo " (".$item_from." to ".$item_to." from ".$no_of_res.")";?></td></tr>
  <tr><td colspan="10" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <tr class="listhead">
           <td width="5%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=<?php echo $bx_table_prefix."_companies";?>.compid<?php if(!empty($HTTP_GET_VARS['show'])) { echo "&show=".$HTTP_GET_VARS['show'];}?>" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by company ID'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_ID;?></b></a>&nbsp;</td>
           <td width="15%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=company<?php if(!empty($HTTP_GET_VARS['show'])) { echo "&show=".$HTTP_GET_VARS['show'];}?>" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by company name'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_COMPANY_NAME;?></b></a>&nbsp;</td>
           <td width="15%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=signupdate<?php if(!empty($HTTP_GET_VARS['show'])) { echo "&show=".$HTTP_GET_VARS['show'];}?>" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by post date'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_DATE_ADDED;?></b></a>&nbsp;</td>
           <td width="15%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=lastlogin<?php if(!empty($HTTP_GET_VARS['show'])) { echo "&show=".$HTTP_GET_VARS['show'];}?>" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by last login date'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_LAST_LOGIN;?></b></a>&nbsp;</td>
           <td width="15%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=lastip<?php if(!empty($HTTP_GET_VARS['show'])) { echo "&show=".$HTTP_GET_VARS['show'];}?>" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by last login IP address'; return true;" onmouseout="window.status=''; return true;"><b>IP</b></a>&nbsp;</td>
           <td width="15%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=jobs<?php if(!empty($HTTP_GET_VARS['show'])) { echo "&show=".$HTTP_GET_VARS['show'];}?>" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by company name'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_AVAILABLE_JOBS;?></b></a>&nbsp;</td>
           <td width="15%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=featuredjobs<?php if(!empty($HTTP_GET_VARS['show'])) { echo "&show=".$HTTP_GET_VARS['show'];}?>" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by company name'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_AVAILABLE_FJOBS;?></b></a>&nbsp;</td>
           <td width="15%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=contacts<?php if(!empty($HTTP_GET_VARS['show'])) { echo "&show=".$HTTP_GET_VARS['show'];}?>" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by company name'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_AVAILABLE_RESUMES;?></b></a>&nbsp;</td>
           <td width="15%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=email<?php if(!empty($HTTP_GET_VARS['show'])) { echo "&show=".$HTTP_GET_VARS['show'];}?>" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by company email'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_EMAIL;?></b>&nbsp;</a></td>
           <td width="15%" align="center">&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</td>
  </tr>
  <?php
  $rows=0;
  $item=0;
  while ($company_result=bx_db_fetch_array($company_query))
  {
  $rows++;
  if (empty($HTTP_GET_VARS['show']) || $item==0) {
  $item++;
  }
  if (($item<=$item_to) and ($item>=$item_from+1))
   {
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {echo 'bgcolor="#ffffff"';} else {echo 'bgcolor="#f4f7fd"';}?>>
      <td align="center" nowrap><?php echo $company_result['compid'];?></td>
	  <td align="center" nowrap><?php echo $company_result['company'];?></td>
      <td align="center"><?php echo $company_result['signupdate'];?></td>
      <td align="center" nowrap><?php
       echo $company_result['lastlogin_formated']."<br>";
       $mytime = $company_result['mytime'];  
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
       ?></td> 
      <td align="center"><?php echo $company_result['lastip'];?></td>
      <td align="center"><?php echo ($company_result['jobs']!=999)?$company_result['jobs'] : 'unlimited';?></td>
      <td align="center"><?php echo $company_result['featuredjobs'];?></td>
      <td align="center"><?php echo ($company_result['contacts']!=999)?$company_result['contacts'] : 'unlimited';?></td>
      <td align="center"><a href="mailto:<?php echo $company_result['email'];?>" style="color:#008080; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Send mail'; return true;" onmouseout="window.status=''; return true;"><?php echo $company_result['email'];?></a></td>
      <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&compid=<?php echo $company_result['compid'];?>&back_url=<?php echo urlencode(HTTP_SERVER_ADMIN.FILENAME_ADMIN."?all=".$HTTP_GET_VARS['all']."&o=".$HTTP_GET_VARS['o']."&show=".$HTTP_GET_VARS['show']."&from=".$item_from);?>">Details</a></td>
    </tr>
   <?php
   } //end if
  } //end while $referer_result
  $item_back_from=$item_from;
  $item_from=$item_to;
  $item_to=$item_from+NR_DISPLAY;
  if (!$rows) {
      echo "<tr><td colspan=\"10\" align=\"center\" class=\"errortd\">Nothing found</td></tr>";
  }
  ?>
  </table>
  <br>
  <table width="100%"> 
  <tr>
  <?php
  if (($item_from>NR_DISPLAY) && (empty($HTTP_GET_VARS['show'])))
   {
  ?>
  <td colspan="2" align="left"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=<?php echo $HTTP_GET_VARS['o'];?>&from=<?php echo $item_back_from-NR_DISPLAY;?>" class="nxt"><b><?php echo PREVIOUS.' '.NR_DISPLAY;?></b></a></td>
  <?php
   }
  if (($item_from<bx_db_num_rows($company_query)) && (empty($HTTP_GET_VARS['show'])))
  {
   ?>
  <td colspan="8" align="right"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=<?php echo $HTTP_GET_VARS['o'];?>&from=<?php echo $item_from;?>" class="nxt"><b><?php echo NEXT.' '.NR_DISPLAY;?></b></a></td>
  <?php
  }
  ?>
  </tr>
  </table>
<?php
}//end if all==employers
?>
<?php
if ($HTTP_GET_VARS['all']=="jobseekers")
{
if ($HTTP_GET_VARS['from'])
  {
  $item_from=$HTTP_GET_VARS['from'];
  //$item_to=$HTTP_GET_VARS['to'];
  $item_to=$item_from+NR_DISPLAY;
  }
  else
  {
  $item_from=0;
  $item_to=NR_DISPLAY;
  }
  $query = "select *,UNIX_TIMESTAMP(".$bx_table_prefix."_persons.lastlogin)-UNIX_TIMESTAMP(NOW()) as mytime, DATE_FORMAT(lastlogin,'%d %M %Y') as lastlogin_formated from ".$bx_table_prefix."_persons, ".$bx_table_prefix."_locations_".$bx_table_lng." where ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid = ".$bx_table_prefix."_persons.locationid";
  if (!empty($o)) {
       $query .= " order by $o";
  }
  else {
      $query .= " order by ".$bx_table_prefix."_persons.signupdate desc";
  }
  $jobseeker_query=bx_db_query($query);
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $no_of_res = bx_db_num_rows($jobseeker_query);
  ?>
   <table width="100%" cellpadding="1" cellspacing="1" border="0" class="listtable">
   <tr>
     <?php
     if (empty($HTTP_GET_VARS['show'])) {
     ?>
     <td colspan="9" align="right"><form><font face="Verdana, Arial" color="#000000" size="1"><input type="checkbox" class="check" name="showall" onClick="go('<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=<?php echo $HTTP_GET_VARS['o'];?>&show=page');">Show all in one page.</font></td></form>
     <?php
      }
      else {
      ?>
      <td colspan="9" align="right"><form><font face="Verdana, Arial" color="#000000" size="1"><input type="checkbox" class="check" name="showall" onClick="go('<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=<?php echo $HTTP_GET_VARS['o'];?>');" checked>Show all in one page.</font></td></form>
      <?php
      }
     ?>
   </tr>
  <tr><td colspan="9" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <TR bgcolor="#FFFFFF"><td colspan="9" align="right" class="searchhead">All jobseekers Showing <?php echo " (".$item_from." to ".$item_to." from ".$no_of_res.")";?></td></tr>
  <tr><td colspan="9" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <tr class="listhead">
       <td width="5%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&show=<?php echo $HTTP_GET_VARS['show'];?>&o=persid" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by jobseeker ID'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_ID;?></b></a>&nbsp;</td>
       <td width="20%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&show=<?php echo $HTTP_GET_VARS['show'];?>&o=name" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by jobseeker name'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_COMPANY_NAME;?></b></a>&nbsp;</td>
       <td width="20%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&show=<?php echo $HTTP_GET_VARS['show'];?>&o=signupdate" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by post date'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_DATE_ADDED;?></b></a>&nbsp;</td>
       <td width="15%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=lastlogin<?php if(!empty($HTTP_GET_VARS['show'])) { echo "&show=".$HTTP_GET_VARS['show'];}?>" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by last login date'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_LAST_LOGIN;?></b></a>&nbsp;</td>
       <td width="15%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=lastip<?php if(!empty($HTTP_GET_VARS['show'])) { echo "&show=".$HTTP_GET_VARS['show'];}?>" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by last login IP address'; return true;" onmouseout="window.status=''; return true;"><b>IP</b></a>&nbsp;</td>
       <?php if(ENTRY_BIRTHYEAR_LENGTH!=0){?>
       <td width="20%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&show=<?php echo $HTTP_GET_VARS['show'];?>&o=birthyear" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by jobseeker birthyear'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_BIRTH_YEAR;?></b></a>&nbsp;</td>
       <?php }?>
       <td width="20%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&show=<?php echo $HTTP_GET_VARS['show'];?>&o=location" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by jobseeker location'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_LOCATION;?></b></a>&nbsp;</td>
       <td width="20%" align="center">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&show=<?php echo $HTTP_GET_VARS['show'];?>&o=email" style="color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Order by jobseeker email'; return true;" onmouseout="window.status=''; return true;"><b><?php echo TEXT_EMAIL;?></b>&nbsp;</a></td>
       <td width="15%" align="center">&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</td>
  </tr>
  <?php
  $rows=0;
  $item=0;
  while ($jobseeker_result=bx_db_fetch_array($jobseeker_query))
  {
  $rows++;
  if (empty($HTTP_GET_VARS['show']) || $item==0) {
  $item++;
  }
  if (($item<=$item_to) and ($item>=$item_from+1))
   {
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {echo 'bgcolor="#ffffff"';} else {echo 'bgcolor="#f4f7fd"';}?>>
      <td align="center"><?php echo $jobseeker_result['persid'];?></td>
	  <td align="center"><?php echo $jobseeker_result['name'];?></td>
      <td align="center"><?php echo $jobseeker_result['signupdate'];?></td>
      <td align="center" nowrap><?php
       echo $jobseeker_result['lastlogin_formated']."<br>";
       $mytime = $jobseeker_result['mytime'];  
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
       ?></td> 
      <td align="center"><?php echo $jobseeker_result['lastip'];?></td>
      <?php if(ENTRY_BIRTHYEAR_LENGTH!=0){?>
      <td align="center"><?php echo $jobseeker_result['birthyear'];?></td>
      <?php }?>
      <td align="center"><?php echo $jobseeker_result['city'];?>, <?php echo $jobseeker_result['location'];?></td>
      <td align="center"><a href="mailto:<?php echo $jobseeker_result['email'];?>" style="color:#008080; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;" onmouseover="window.status='Send mail'; return true;" onmouseout="window.status=''; return true;"><?php echo $jobseeker_result['email'];?></a></td>
      <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&persid=<?php echo $jobseeker_result['persid'];?>&back_url=<?php echo urlencode(HTTP_SERVER_ADMIN.FILENAME_ADMIN."?all=".$HTTP_GET_VARS['all']."&o=".$HTTP_GET_VARS['o']."&show=".$HTTP_GET_VARS['show']."&from=".$item_from);?>">Details</a></td>
    </tr>
   <?php
   } //end if
  } //end while $referer_result
  $item_back_from=$item_from;
  $item_from=$item_to;
  $item_to=$item_from+NR_DISPLAY;
  if (!$rows) {
      echo "<tr><td colspan=\"9\" align=\"center\" class=\"errortd\">Nothing found</td></tr>";
  }
  ?>
  </table>
  <br>
  <table width="100%"> 
  <tr>
  <?php
  if (($item_from>NR_DISPLAY) && (empty($HTTP_GET_VARS['show'])))
   {
  ?>
  <td colspan="2" align="left"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=<?php echo $HTTP_GET_VARS['o'];?>&from=<?php echo $item_back_from-NR_DISPLAY;?>" class="nxt"><b><?php echo PREVIOUS.' '.NR_DISPLAY;?></b></a></td>
  <?php
   }
  if (($item_from<bx_db_num_rows($jobseeker_query)) && (empty($HTTP_GET_VARS['show'])))
  {
   ?>
  <td colspan="6" align="right"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=<?php echo $HTTP_GET_VARS['all'];?>&o=<?php echo $HTTP_GET_VARS['o'];?>&from=<?php echo $item_from;?>" class="nxt"><b><?php echo NEXT.' '.NR_DISPLAY;?></b></a></td>
  <?php
  }
  ?>
  </tr>
  </table>
<?php
}//end if all==jobseekers
?>