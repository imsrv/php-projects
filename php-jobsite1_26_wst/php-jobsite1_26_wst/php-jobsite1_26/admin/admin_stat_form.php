<?php
if($HTTP_GET_VARS['m']) {
    $m=$HTTP_GET_VARS['m'];
}
else {
    $m=date('m');
}
$mn = $m+1;
$mp = $m-1;
if($HTTP_GET_VARS['y']) {
    $y=$HTTP_GET_VARS['y'];
}
else {
    $y=date('Y');
}
$yn=$y;
$yp=$y;
if($mn==13) {
    $mn =1;
    $yn = $y+1;
}
if($mp==0) {
    $mp = 12;
    $yp = $y-1;
}
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Site Statistics</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
<TABLE border="0" cellpadding="2" cellspacing="0" bgcolor="#00CCFF" width="100%">
<tr>
    <td colspan="3">&nbsp;</td>
</tr>
<tr>
        <td valign="top" width="100%" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Site Statistics</b></font></td>
</tr>        
<tr>
        <td valign="top" width="20%" nowrap style="padding-left:10px;"><a href="<?php echo HTTP_SERVER_ADMIN."admin_stat.php?m=".$mp."&y=".$yp;?>"><font style="font-size: 11px;">&#171;&nbsp;<?php echo date('F, Y', mktime(0,0,0,$mp,1,$yp));?></font></a></td><td width="60%" align="center"><b><u><?php echo date('F, Y', mktime(0,0,0,$m,1,$y));?></u></b></td><td valign="top" width="20%" align="right" style="padding-right:10px;"><a href="<?php echo HTTP_SERVER_ADMIN."admin_stat.php?m=".$mn."&y=".$yn;?>"><font style="font-size: 11px;"><?php echo date('F, Y', mktime(0,0,0,$mn,1,$yn));?> &#187;</font></a></td>
</tr>        
<tr>
        <td valign="top" width="100%" colspan="3">&nbsp;</td>
</tr>        
<?php
$total_month = 0;
$total = 0;
?>
<tr><td width="100%" colspan="3" style="padding-left: 30px; padding-right: 30px;"><table cellspacing="0" cellpadding="1" width="100%" border="0" align="center">
<?php
$person_query=bx_db_query("select count(persid) from ".$bx_table_prefix."_persons where MONTH(signupdate) = ".$m." and YEAR(signupdate) = ".$y."");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$person_result = bx_db_fetch_array($person_query);
$resume_query=bx_db_query("select count(".$bx_table_prefix."_persons.persid) from ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where ".$bx_table_prefix."_resumes.persid=".$bx_table_prefix."_persons.persid and MONTH(resumedate) = ".$m." and YEAR(resumedate) = ".$y."");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$resume_result = bx_db_fetch_array($resume_query);
$company_query=bx_db_query("select count(compid) from ".$bx_table_prefix."_companies where MONTH(signupdate) = ".$m." and YEAR(signupdate) = ".$y."");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$company_result = bx_db_fetch_array($company_query);
$job_query=bx_db_query("select count(".$bx_table_prefix."_companies.compid) from ".$bx_table_prefix."_companies,".$bx_table_prefix."_jobs where ".$bx_table_prefix."_jobs.compid=".$bx_table_prefix."_companies.compid and MONTH(jobdate) = ".$m." and YEAR(jobdate) = ".$y."");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$job_result = bx_db_fetch_array($job_query);
$invoice_query=bx_db_query("select SUM(".$bx_table_prefix."_invoices.totalprice) from ".$bx_table_prefix."_invoices, ".$bx_table_prefix."_companies where  MONTH(".$bx_table_prefix."_invoices.payment_date) = ".$m." and YEAR(".$bx_table_prefix."_invoices.payment_date) = ".$y." and ".$bx_table_prefix."_invoices.compid = ".$bx_table_prefix."_companies.compid and ".$bx_table_prefix."_invoices.paid='Y' and ".$bx_table_prefix."_invoices.validated='Y' and ".$bx_table_prefix."_invoices.updated='Y'");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$invoice_result = bx_db_fetch_array($invoice_query);
$total_month += $invoice_result[0];
$invoice_tot_query=bx_db_query("select SUM(".$bx_table_prefix."_invoices.totalprice) from ".$bx_table_prefix."_invoices, ".$bx_table_prefix."_companies where ".$bx_table_prefix."_invoices.compid = ".$bx_table_prefix."_companies.compid and ".$bx_table_prefix."_invoices.paid='Y' and ".$bx_table_prefix."_invoices.validated='Y' and ".$bx_table_prefix."_invoices.updated='Y'");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$invoice_tot_result = bx_db_fetch_array($invoice_tot_query);
$total += $invoice_tot_result[0];
?>
<tr>
  <td width="80%"><font style="font-size: 12px;">Registered Jobseekers:</font></td><td width="20%"><b><?php echo $person_result[0];?></b></td>
</tr> 
<tr>
  <td width="80%"><font style="font-size: 12px;">Resumes Posted:</font></td><td width="20%"><b><?php echo $resume_result[0];?></b></td>
</tr> 
<tr>
  <td width="80%"><font style="font-size: 12px;">Registered Employers: </font></td><td width="20%"><b><?php echo $company_result[0];?></b></td>
</tr> 
<tr>
  <td width="80%"><font style="font-size: 12px;">Jobs Posted:</font></td><td width="20%"><b><?php echo $job_result[0];?></b></td>
</tr> 
<tr>
  <td width="80%"><font style="font-size: 12px;">Employers Total Payment: </font></td><td width="20%"><b><?php echo bx_format_price(($invoice_result[0])?$invoice_result[0]:"0", PRICE_CURENCY);?></b></td>
</tr> 
<tr>
  <td width="100%" colspan="2">&nbsp;</td>
</tr> 
<tr>
  <td width="100%" colspan="2"><hr></td>
</tr> 
<tr>
  <td width="80%" align="right" style="padding-right: 10px;"><b>Total this month:</b></td><td><b><?php echo bx_format_price($total_month, PRICE_CURENCY);?></b></td>
</tr> 
<tr>
  <td width="80%" align="right" style="padding-right: 10px;"><b>Total per site:</b></td><td><b><?php echo bx_format_price($tota, PRICE_CURENCY);?></b></td>
</tr> 
</table>
</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr>
        <td valign="top" width="20%" nowrap style="padding-left:10px;"><a href="<?php echo HTTP_SERVER_ADMIN."admin_stat.php?m=".$mp."&y=".$yp;?>"><font style="font-size: 11px;">&#171;&nbsp;<?php echo date('F, Y', mktime(0,0,0,$mp,1,$yp));?></font></a></td><td width="60%" align="center">&nbsp;</td><td valign="top" width="20%" nowrap align="right" style="padding-right:10px;"><a href="<?php echo HTTP_SERVER_ADMIN."admin_stat.php?m=".$mn."&y=".$yn;?>"><font style="font-size: 11px;"><?php echo date('F, Y', mktime(0,0,0,$mn,1,$yn));?>&nbsp;&#187;</font></a></td>
</tr>        
</table>
</td></tr>
</table>