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
$merchant = $_POST['merchantAccount'];
$amount = $_POST['amount'];
$itemid = $_POST['item_id'];
$returnurl = $_POST['return_url'];
$notifyurl = $_POST['notify_url'];
$cancelurl = $_POST['cancel_url'];
?>
<table width=600 cellpadding=0 cellspacing=0 border=0 align=center>
<tr>
	<td width="100%" class="ppheading">
		<font face="Arial, Helvetica, sans-serif" size="3" color="#000066"><b>Payment Details </b></font>
	</TD>
</tr>
<tr>
	<td><img src="/images/pixel.gif" width=2 height=2></td>
</tr>
<tr>
	<td height="1" bgcolor="#000000"></td>
</tr>
</table>
<table width="600" cellpadding=0 cellspacing=0 border=0 align=center>
<tr valign=top> 
	<td width=6><img src="/images/pixel.gif" width=6 height=6></td>
	<td width="100%" class="pptext" align="left">
<?
$balance = balance($user);

if ($_POST['transfer'])
{
  $posterr = 0;
  $_POST['amount'] = myround($_POST['amount']);
  
  #echo "-->".$balance."<bR>";
  
  // Check funds
  if ($balance < $_POST['amount'])
    errform('You do not have enough money in your account', 'amount');
  if ($_POST['amount'] < 0)
    errform('Please enter a valid amount', 'amount');
    
  // Check username
  $r = mysql_fetch_row(mysql_query(
    "SELECT id FROM epay_users WHERE (username='".addslashes($_POST['merchantAccount'])."' OR email='".addslashes($_POST['merchantAccount'])."')"
  ));
  if (!$r)
    errform("There are no users with the specified username", 'username');
}

if ($_POST['transfer'] && !$posterr){
	$comments = "Payment For {$_POST['item_id']}";//<br>".$_POST['memo'];
	transact($user,$r[0],$_POST['amount'],$comments);
	$action = 'account';
	$req = "";
	$qarray = array();
	while ( list($key,$value) = each($_POST) ){
		$arr[$key] = urlencode($value);
		array_push( $qarray, $key."=" . urlencode($value) );		
		if($req){
			$req .= "&";
		}else{
			$req = "?";
		}
		$req .= $key."=".urlencode($value);
	}
	$query = implode('&', $qarray);
	if( $_POST['notify_url'] ){
		$notifyurl = $_POST['notify_url'];
		$gotourl = $_POST['return_url'];
		$result = mycurl($notifyurl,$query);
	}
	if( $_POST['return_url'] ){
		$gotourl = $_POST['return_url'];
//		$gotourl .= $req;
	}
	$merch = pruserObj2($_POST['merchantAccount']);
?>
	<CENTER>
	<br><br>
	<TABLE class=design width=100% cellpadding=0 cellspacing=0 border=0>
	<form action="<?=$gotourl?>" method="post">
	<TR>
		<th>Payment Sucessful!!!</th>
	</tr>
	<tr>
		<td>
			<p>
				The	payment was successful.<br>
				Thank you for using <?=$sitename?><br>
				Please press "Continue" to return to the Merchant's web site and exit <?=$sitename?><br>
			</p>
		</td>
	</tr>
	<tr>
		<th><input type="submit" value="Continue"></th>
	</tr>
<?
		while ($a = each($_POST)){
			if (substr($a[0], 0, 1) == '_'){
				echo "<input type=hidden name=\"",htmlspecialchars($a[0]),"\" value=\"",htmlspecialchars($a[1]),"\">";
			}
		}
?>
	</form>
	</TABLE>
<?
}
else
{
$merch = pruserObj2($_POST['merchantAccount']);
?>
<CENTER>
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr>
	<td class="pptext"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?=$sitename?>
	is the authorized payment processor for <?=$merch->email?>. <br> [ <?=$merch->name?> ]</strong></font><br>
	</td>
</tr>
</table>
<br>
<TABLE class=design cellspacing=0>
	<form method=post>
	<input type="hidden" name="return_url" value="<?=$_POST['return_url'];?>">
	<input type="hidden" name="notify_url" value="<?=$_POST['notify_url'];?>">
	<input type="hidden" name="cancel_url" value="<?=$_POST['cancel_url'];;?>">
<TR>
	<TD>Pay To:</TD>
	<TD>
		<?=$_POST['merchantAccount']?>
		<INPUT type=hidden name=merchantAccount value="<?=$_POST['merchantAccount']?>">
	</TD>
</TR>
<TR>
	<TD>Payment For:</TD>
	<TD>
		<?=$_POST['item_id']?>
		<INPUT type=hidden name=item_id value="<?=$_POST['item_id']?>">
	</TD>
</TR>
<TR>
	<TD>Amount:</TD>
	<TD>
		<?=$currency?> <?=$_POST['amount']?>
		<INPUT type=hidden name=amount value="<?=$_POST['amount']?>">
	</TD>
</TR>
<TR><TD>Notes: (optional)</TD>
	<TD><textarea name="memo" cols="30" rows="6"><?=$_POST['SUGGESTED_MEMO']?></textarea></TD></TR>
<TR><TH class=submit colspan=2><input type=submit name=transfer value='Checkout >>'></TH></TR>
  <?=$id_post?>
<?
	$required = array(
		'notify_url','return_url', 'cancel_url', 'merchantAccount', 'item_id', 'amount','memo','cartImage'
	);	
	while (list($key, $val) = @each($_POST)) {
		if( !in_array($key, $required) ){
?>
			<INPUT type=hidden name="<?=$key?>" value="<?=$val?>">
<?
		}
	}
?>
</FORM>
</TABLE>
</CENTER>
 
<?
}
?>
	</td>
</tr>
</table>