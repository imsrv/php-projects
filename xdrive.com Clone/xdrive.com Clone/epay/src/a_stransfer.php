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

$opposite = ($atype == 'wm' ? 'pr' : 'wm');
$balance = balance($user);

if ($_GET['id'])
{
  if ($atype == 'wm')
  {
    $r = mysql_fetch_object(mysql_query("SELECT * FROM epay_safetransfers WHERE id=".(int)$_GET['id']));
    if ($user == $r->paidby)
    {
      transact(2,$r->paidto,$r->amount,"Safe transfer from $data->username");
      mysql_query("DELETE FROM epay_safetransfers WHERE id=".(int)$_GET['id']);
    }
  }
  else
  {
    $r = mysql_fetch_object(mysql_query("SELECT * FROM epay_safetransfers WHERE id=".(int)$_GET['id']));
    if ($user == $r->paidto)
    {
      transact(2,$r->paidby,$r->amount,"Safe transfer return from $data->username");
      mysql_query("DELETE FROM epay_safetransfers WHERE id=".(int)$_GET['id']);
    }
  }
    
  include("src/a_escrow.php");
}
else
{
  if ($_POST['transfer'])
  {
    $posterr = 0;
    $_POST['amount'] = myround($_POST['amount']);
    
    // Check funds
    if ($balance < $_POST['amount'])
      errform('Sorry, but you do not have enough money in your account to complete this transaction.', 'amount');
      
    // Check username
    $r = mysql_fetch_row(mysql_query("SELECT id FROM epay_users WHERE (username='".addslashes($_POST['username'])."' OR email='".addslashes($_POST['username'])."')"));
    if (!$r)
      errform("There are no ".strtolower($GLOBALS[$opposite])."s with the specified username", 'username');
  }
  
  if ($_POST['transfer'] && !$posterr)
  {
    // Update database
    transact($user,2,$_POST['amount'],"Safe transfer to {$_POST['username']}");
    mysql_query("INSERT INTO epay_safetransfers(paidby,paidto,amount) VALUES($user,$r[0],{$_POST['amount']})");
    include("src/a_escrow.php");
  }
  else
  {
?>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
<tr bgcolor="#FFFFFF">
	<td width="10"></td>
	<td width="150" valign="top">
<?
	include("src/acc_menu.php");
?>
	</td>
    <td width="20"></td>
    <td width="510" valign="top">
		<table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0" class="empty">
		<tr bgcolor="#FFFFFF">
			<td colspan=2>
			<BR>
			<CENTER>
			<TABLE class=design cellspacing=0>
				<FORM method=post>
			<TR><TH colspan=2>Conduct Safe Transfer</TH></TR>
			<TR><TD>Username:</TD>
				<TD><INPUT type=text name=username size=16 maxLength=16 value="<?=$_POST['username']?>">
			<TR><TD>Amount to transfer:</TD>
				<TD><?=$currency?> <input type=text name=amount size=5 maxLength=5 value="<?=$_POST['amount']?>"></TD></TR>
			<TR><TH class=submit colspan=2><input type=submit name=transfer value='Transfer >>'></TH></TR>
			  <?=$id_post?>
			</FORM>
			</TABLE>
			</CENTER>
		</tr>
		</table>
	</td>
	<td width="10"></td>
</tr>
</table>
<?
  }
}
?>