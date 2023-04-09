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
$formrep = error_reporting(0);
unset($form);
unset($formx);
unset($formerr);

function form_fail($msg, $var, $limit = 0)
{
  global $form, $formx, $formerr;
  $formerr[$var] = 1;
  echo "<div class=error>$msg</div>\n";
  if (!$limit) $form[$var] = $formx[$var];
    else $form[$var] = substr($form[$var], 0, $limit);
}

if (!$_add)
{
  $form['id'] = addslashes($GLOBALS['_'.$_SERVER['REQUEST_METHOD']]['id']);
  $form = mysql_fetch_array(mysql_query(
    "SELECT * FROM epay_transactions WHERE id='{$form['id']}'"
  ), MYSQL_ASSOC);
  $formx = $form;
}

if ($_POST['de'])
{
  // Check User
  list($uid) = mysql_fetch_row(mysql_query("SELECT id FROM epay_users WHERE username='".addslashes($_POST['user'])."'"));
  if (!$uid)
    form_fail("There are no users with the specified username", 'user');
  
  // Check Description (comment)
  $form['comment'] = trim($_POST['comment']);
  if ($form['comment'] == '')
    form_fail("Please enter Description", 'comment');
  elseif (strlen($form['comment']) > 40)
    form_fail("Description should be no longer than 40 characters", 'comment', 40);

  // Check Withdraw amount (amount)
  $form['amount'] = trim($_POST['amount']);
  if ($form['amount'] == '')
    form_fail("Please enter Withdraw amount", 'amount');
  else
    $form['amount'] = (double)$form['amount'];
  if ($form['amount'] <= 0)
    form_fail("You have entered an incorrect value for Amount", 'amount');

  // Check Fees (fees)
  $form['fees'] = trim($_POST['fees']);
  $form['fees'] = (double)$form['fees'];
  if ($form['fees'] < 0)
    form_fail("You have entered an incorrect value for Fees", 'fees');

  // Check Order No (orderno)
  $form['orderno'] = trim($_POST['orderno']);
  if (strlen($form['orderno']) > 40)
    form_fail("Order No should be no longer than 40 characters", 'orderno', 40);

  // Check Additional info (addinfo)
  $form['addinfo'] = trim($_POST['addinfo']);

  if ($formerr) echo '<br>';
}

if ($_POST['de'] && !$formerr){
	while ($i = each($form)){
		$formx[$i[0]] = addslashes($i[1]);
	}
	if ($_add){
		transact($uid,(int)$_POST['type'],$formx['amount'],$formx['comment'],'',$formx['fees'],'',$formx['addinfo'],$formx['orderno']);  
	}
}else{
?>
<CENTER>
<TABLE class=design cellspacing=0>
<FORM method=post>

<!-- Row 1 -->
<TR><TH colspan=2 class=headline> Make New Withdrawal</TR>

<!-- Row 2 -->
<TR><TD><SPAN<?=($formerr['paidto'] ? ' class=error' : '')?>>Username:</SPAN>
<TD><INPUT type=text name=user value="<?=$form['paidto']?>"></TR>

<!-- Row 3 -->
<TR><TD>Withdrawal Type:
	<TD><SELECT name=type>
      <OPTION value=1>Other (not displayed in reports)
      <OPTION value=11>PayPal
      <OPTION value=14>Wire Transfer
      <OPTION value=15>E-Gold
	 <OPTION value=16>StormPay
      <OPTION value=17>Authorize.Net
      <OPTION value=18>NetPay
      <OPTION value=19>Kagi
      <OPTION value=12>Check</SELECT></TR>

<!-- Row 4 -->
<TR><TD><SPAN<?=($formerr['comment'] ? ' class=error' : '')?>>Description:</SPAN>
	<TD><input type=text name="comment" size=40 maxLength=40 value="<?=htmlspecialchars($form['comment'])?>"></TR>

<!-- Row 5 -->
<TR><TD><SPAN<?=($formerr['amount'] ? ' class=error' : '')?>>Withdraw amount:</SPAN>
	<TD><?=$currency?> <input type=text name="amount" value="<?=$form['amount']?>" size=5></TR>

<!-- Row 6 -->
<TR><TD><SPAN<?=($formerr['fees'] ? ' class=error' : '')?>>Fees:</SPAN><TD>
	<?=$currency?> <input type=text name="fees" value="<?=$form['fees']?>" size=5>
	<SMALL>(Included in withdrawal amount)</SMALL></TR>

<!-- Row 7 -->
<TR><TD><SPAN<?=($formerr['orderno'] ? ' class=error' : '')?>>Order No:</SPAN>
	<TD><INPUT type=text name="orderno" size=20 maxLength=40 value="<?=htmlspecialchars($form['orderno'])?>"></TR>

<!-- Row 8 -->
<TR><TD><SPAN<?=($formerr['addinfo'] ? ' class=error' : '')?>>Additional info:</SPAN>
<TD><TEXTAREA name="addinfo" cols=40 rows=3><?=htmlspecialchars($form['addinfo'])?></TEXTAREA></TR>

<!-- Row 9 -->
<TR><TH colspan=2 class=submit><INPUT type=submit class=button name=de value="Submit &gt;&gt;"></TH></TR>

<!-- Pass variables -->
<INPUT type=hidden name="id" value="<?=htmlspecialchars(stripslashes($form['id']))?>">

</FORM>
</TABLE>
</CENTER>
<?
  $formerr[''] = 1;
}
error_reporting($formrep);
?>
