<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       										  #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Todd M. Findley                      #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?
$today = getdate(); 

function report()
{
  global $timeframe, $tr_sources;
  $qr1 = mysql_query("SELECT id FROM epay_users WHERE id>10 AND id<98");
  $total = 0;
  $i = 0;
  while ($r1 = mysql_fetch_object($qr1))
  {
    list($dsumm,$dfees) = mysql_fetch_row(mysql_query("SELECT SUM(amount),SUM(fees) FROM epay_transactions WHERE paidby=$r1->id AND $timeframe"));
    list($wsumm,$wfees) = mysql_fetch_row(mysql_query("SELECT SUM(amount),SUM(fees) FROM epay_transactions WHERE paidto=$r1->id AND $timeframe"));
    
    $t1 += $dsumm;
    $t2 += $dfees;
    $t3 -= $wsumm;
    $t4 += $wfees;
    $t5 += $dfees + $wfees;
    
    if ($dsumm || $wsumm)
    {
      echo "\n<tr>",
           "<td>",$tr_sources[$r1->id],
           "<td>",prsumm($dsumm, 1),
           "<td>",prsumm($dfees, 1),
           "<td>",prsumm(-$wsumm, 1),
           "<td>",prsumm($wfees, 1),
           "<td>",prsumm($dfees + $wfees, 1);
      $total += $dsumm - $wsumm + $dfees + $wfees;
      $i++;
    }
  }
  echo "&nbsp;<tr><td>Total:",
       "<td>",prsumm($t1, 1),
       "<td>",prsumm($t2, 1),
       "<td>",prsumm($t3, 1),
       "<td>",prsumm($t4, 1),
       "<td>",prsumm($t5, 1);
  
  if (!$i) echo "<tr><td colspan=6>&nbsp;";
}
?>
<TABLE class=design width=100% cellspacing=0>
<tr><td style="padding: 10px;">

<div style="color: red;"><b>
Today's Transaction Summary (<?=date('F d, Y')?>)
</b></div>
<TABLE class=design width=100% cellspacing=0>
<form method=get name=form1>
<tr>
  <th>&nbsp;
  <th>Deposits
  <th>Fees
  <th>Withdrawals
  <th>Fees
  <th>Total Fees
  
<?
$date1 = mktime(0,0,0,$today['mon'],$today['mday'],$today['year']);
$date2 = mktime(0,0,0,$today['mon'],$today['mday'] + 1,$today['year']);
$timeframe = "UNIX_TIMESTAMP(trdate)>=$date1 AND UNIX_TIMESTAMP(trdate)<$date2";
report();
?>

<tr>
  <th colspan=7>
    View detailed report for:
    <select name=dday>
    <? for ($i = 1; $i <= 31; $i++) echo "<option",($today['mday'] == $i ? " selected" : ""),">",sprintf("%02d",$i); ?>
    </select>
    <select name=dmonth>
    <? for ($i = 1; $i <= 12; $i++) echo "<option value=$i",($today['mon'] == $i ? " selected" : ""),">",date("F",mktime(0,0,0,$i,1,0)); ?>
    </select>
    <select name=dyear>
    <? for ($i = 2002; $i <= 2010; $i++) echo "<option",($today['year'] == $i ? " selected" : ""),">",$i; ?>
    </select>
    <input type=submit value="Payment Processors" onClick="form1.a.value='viewtr';">
    <!--    
    <select name=what>
    <option value="">View incomes and expenses
    <option value="+">View incomes
    <option value="-">View expenses
    </select>
    -->
    <input type=button value="Transactions" onClick="form1.a.value='viewtr2'; form1.submit();">
    <input type=button value="Admin Transactions" onClick="form1.a.value='viewtr3'; form1.submit();">
</th>
<input type=hidden name=a value="viewtr">
<input type=hidden name=source value="d">
<input type=hidden name=suid value="<?=$suid?>">
</form>
</table>
<br>

<div style="color: red;"><b>
Monthly Transaction Summary (<?=date('F Y')?>)
</b></div>
<TABLE class=design width=100% cellspacing=0>
<form method=get name=form2>
<tr>
  <th>&nbsp;
  <th>Deposits
  <th>Fees
  <th>Withdrawals
  <th>Fees
  <th>Total Fees

<?
$date1 = mktime(0,0,0,$today['mon'],1,$today['year']);
$date2 = mktime(0,0,0,$today['mon'] + 1,1,$today['year']);
$timeframe = "UNIX_TIMESTAMP(trdate)>=$date1 AND UNIX_TIMESTAMP(trdate)<$date2";
report();
?>

<tr>
  <th colspan=7>
    View detailed report for:
    <select name=mmonth>
    <? for ($i = 1; $i <= 12; $i++) echo "<option value=$i",($today['mon'] == $i ? " selected" : ""),">",date("F",mktime(0,0,0,$i,1,0)); ?>
    </select>
    <select name=myear>
    <? for ($i = 2002; $i <= 2010; $i++) echo "<option",($today['year'] == $i ? " selected" : ""),">",$i; ?>
    </select>
    <input type=submit value="Payment Processors" onClick="form2.a.value='viewtr';">
    <!--    
    <select name=what>
    <option value="">View incomes and expenses
    <option value="+">View incomes
    <option value="-">View expenses
    </select>
    -->
    <input type=button value="Transactions" onClick="form2.a.value='viewtr2'; form2.submit();">
    <input type=button value="Admin Transactions" onClick="form2.a.value='viewtr3'; form2.submit();">
</th>
<input type=hidden name=a value="viewtr">
<input type=hidden name=source value="m">
<input type=hidden name=suid value="<?=$suid?>">
</form>
</table>
<br>

<div style="color: red;"><b>
Year to Date (<?=date('Y')?>)
</b></div>
<TABLE class=design width=100% cellspacing=0>
<form method=get name=form3>
<tr>
  <th>&nbsp;
  <th>Deposits
  <th>Fees
  <th>Withdrawals
  <th>Fees
  <th>Total Fees

<?
$date1 = mktime(0,0,0,1,1,$today['year']);
$date2 = mktime(0,0,0,1,1,$today['year'] + 1);
$timeframe = "UNIX_TIMESTAMP(trdate)>=$date1 AND UNIX_TIMESTAMP(trdate)<$date2";
report();
?>

<tr>
  <th colspan=7>
    View detailed report for:
    <select name=yyear>
    <? for ($i = 2002; $i <= 2010; $i++) echo "<option",($today['year'] == $i ? " selected" : ""),">",$i; ?>
    </select>
    <input type=submit value="Payment Processors" onClick="form3.a.value='viewtr';">
    <!--    
    <select name=what>
    <option value="">View incomes and expenses
    <option value="+">View incomes
    <option value="-">View expenses
    </select>
    -->
    <input type=button value="Transactions" onClick="form3.a.value='viewtr2'; form3.submit();">
    <input type=button value="Admin Transactions" onClick="form3.a.value='viewtr3'; form3.submit();">
</th>
<input type=hidden name=a value="viewtr">
<input type=hidden name=source value="y">
<input type=hidden name=suid value="<?=$suid?>">
</form>
</table>
<br>


</td></tr>
</form>
</table>

