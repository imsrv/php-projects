<?
/* nulled by [GTT] :) */    

include("functions.php");
include ('header.php');
db_connect();
@session_start();
if(session_is_registered("admin")&&$affid)
{
 $balance=calc_balance($affid);
 $totalpaidamt=db_result_to_array("select totalpaidamt from users where id='$affid'");
 $totalpaidamt[0][0]+=$balance;

 if (@$payment&&$affid) {mysql_query("update users set saleam='0', lev1saleam='0', lev2saleam='0', lev3saleam='0', lev4saleam='0', lev5saleam='0', lev6saleam='0', lev7saleam='0', saleqt='0', lev1saleqt='0', lev2saleqt='0', lev3saleqt='0', lev4saleqt='0', lev5saleqt='0', lev6saleqt='0', lev7saleqt='0', totalpaidamt='".$totalpaidamt[0][0]."',  lastpaidamt='".$balance."', lastpaidtime='".time()."' where id='$affid'"); echo "The balance has been deleted";}
 if (@$delete&&$affid) {mysql_query("delete from users where id='$affid'"); $deleted=1;}
 $balance=calc_balance($affid);
 if (!@$deleted)
 {
 $aff=mysql_query("select * from users where id='$affid'");
 $aff=mysql_fetch_array($aff);

 $affs[0]=db_result_to_array("select id from users where referer='$affid'");
 for ($k=0; $k<6; $k++)
 {
  @$c=count($affs[$k]);
  $afflevel[$k]=$c;
  for ($i=0; $i<$c; $i++)
  {
   if (@$affs[$k+1])$t=count($affs[$k+1]); else $t=0;
   $affss=db_result_to_array("select id from users where referer='".$affs[$k][$i][0]."'");
   for ($j=0; $j<count($affss); $j++, $t++)
    $affs[$k+1][$t][0]=$affss[$j][0];
  }
 }
 @$c=count($affs[$k]);
 $afflevel[$k]=$c;


?>
<?admin_menu();?>
<CENTER> <h3>Affiliate Details</h3><table width="450" border="0"> <tr> <td width="150">Affiliate
ID:</td><td width="290"><?echo $aff['id'];?></td></tr> <tr> <td width="150">First
Name:</td><td width="290"><?echo $aff['frstname'];?></td></tr> <tr> <td width="150">Last
Name:</td><td width="290"><?echo $aff['lstname'];?></td></tr> <tr> <td width="150">Company:</td><td width="290"><?if (!$aff['compname']) echo "N/A"; else echo $aff['compname'];?></td></tr>
<tr> <td width="150">Address:</td><td width="290"><?echo $aff['address'];?></td></tr> <tr>
<td width="150">City:</td><td width="290"><?echo $aff['city'];?></td></tr> <tr> <td width="150">State:</td><td width="290"><?if (!$aff['state']) echo "N/A"; else echo $aff['state'];?></td></tr>
<tr> <td width="150">Zip:</td><td width="290"><?echo $aff['zip'];?></td></tr> <tr> <td width="150">Country:</td><td width="290"><?echo $aff['country'];?></td></tr><TR>
<TD WIDTH="150">Social Security #:</TD><TD WIDTH="290"><?if (!$aff['socsec']) echo "N/A"; else echo $aff['socsec'];?></TD></TR>
<tr> <td width="150">Phone:</td><td width="290"><?if (!$aff['phone']) echo "N/A"; else echo $aff['phone'];?></td></tr> <tr>
<td width="150">&nbsp;</td><td width="290">&nbsp;</td></tr> <tr> <td width="150">Email:</td><td width="290">HIDDEN</td></tr>
<tr> <td width="150">Website:</td><td width="290"><?if (!$aff['website']) echo "N/A"; else echo "<a href=\"$aff[website]\">http://$aff[website]</a>";?></td></tr>
<tr> <td colspan="2"> <hr> </td></tr> <tr> <td colspan="2"><b>Stats Last Reset:
<?if ($aff['lastresettime']) echo date('Y-m-d', $aff['lastresettime']); else echo "NEVER";?></b></td></tr> <tr> <td width="150">&nbsp;</td><td width="290">&nbsp;</td></tr>
<tr> <td width="150">Total Banner Clicks</td><td width="290"><b><?echo $aff['banclicks'];?></b></td></tr>
<tr> <td width="150">Total Text Clicks:</td><td width="290"><b><?echo $aff['textclicks'];?></b></td></tr>
<tr> <td width="150">&nbsp;</td><td width="290">&nbsp;</td></tr> <tr> <td width="180">Total
Direct Sales:<br>

        </td><td width="290"><b><?echo $aff['saleqt'];?>| $<?echo $aff['saleam'];?></b><br><font size="1">(Number of sales| Amount Earned)</font></td></tr> <tr><td width="180">Level 1 Sales:<br>
        <font size=1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(contains <?echo $afflevel[0]?> affiliates)</td><td width="290"><?echo $aff['lev1saleqt'];?> | $<?echo $aff['lev1saleam'];?></td></tr><tr><td width="180">Level 2 Sales:<br>
        <font size=1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(contains <?echo $afflevel[1]?> affiliates)</td><td width="290"><?echo $aff['lev2saleqt'];?> | $<?echo $aff['lev2saleam'];?></td></tr><tr><td width="180">Level 3 Sales:<br>
        <font size=1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(contains <?echo $afflevel[2]?> affiliates)</td><td width="290"><?echo $aff['lev3saleqt'];?> | $<?echo $aff['lev3saleam'];?></td></tr><tr><td width="180">Level 4 Sales:<br>
        <font size=1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(contains <?echo $afflevel[3]?> affiliates)</td><td width="290"><?echo $aff['lev4saleqt'];?> | $<?echo $aff['lev4saleam'];?></td></tr><tr><td width="180">Level 5 Sales:<br>
        <font size=1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(contains <?echo $afflevel[4]?> affiliates)</td><td width="290"><?echo $aff['lev5saleqt'];?> | $<?echo $aff['lev5saleam'];?></td></tr><tr><td width="180">Level 6 Sales:<br>
        <font size=1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(contains <?echo $afflevel[5]?> affiliates)</td><td width="290"><?echo $aff['lev6saleqt'];?> | $<?echo $aff['lev6saleam'];?></td></tr><tr><td width="180">Level 7 Sales:<br>
        <font size=1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(contains <?echo $afflevel[6]?> affiliates)</td><td width="290"><?echo $aff['lev7saleqt'];?> | $<?echo $aff['lev7saleam'];?></td></tr> <tr> <td colspan="2">&nbsp;</td></tr> <tr> <td width="150" valign="top">Total
Balance Available:</td><td width="290"> <form method="post" action="admaffedit.php">
<input type="hidden" name="payment" value="1">
<input type="hidden" name="affid" value="<?echo $aff['id'];?>">
<font size="3">$<?echo $balance;?></font><BR>
<font size="1">Only press this button after you have actually sent the payment</font>
<input type="submit" value="Send Payment" <?$minbal=db_result_to_array("select minbal from admininfo"); if ($minbal[0][0]>$balance) echo "disabled";?>>
</form></td></tr> <tr> <td width="150">Total Amount Paid:</td><td width="290">$<?echo $aff['totalpaidamt'];?></td></tr>
<tr> <td width="150">&nbsp;</td><td width="290">&nbsp;</td></tr> </table>
<br> <form method="post" action="admaffedit.php">
<input type="hidden" name="affid" value="<?echo $aff['id'];?>"><input type="hidden" name="delete" value="1"> <input type="submit" value="Remove this affiliate (cannot be undone)" >
</center>
<?} else echo "The affiliate was successfuly deleted";?>
<center>
</form><br> <form method="post" action="admafflist.php"> <input type="submit" value="Click here to return to Affiliate List">
</form><br> <form method="post" action="adminlogin.php"> <input type="submit" name="Submit" value="Click here to return to Main Menu">
</form>
</CENTER>

<?

}
else
echo "Access denied";
?>
