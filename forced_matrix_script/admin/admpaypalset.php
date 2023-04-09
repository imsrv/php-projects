<?php
/*
Logicodes.com (c) 2003 http://www.logicodes.com

License for one domain only, you may purchase re-sell rights
by contacting us at www.logicodes.com

CopyRight 2003 under Commonwealth Act 1967 violations will
result in $10,000 fine and.or 2 years imprisonment.

Enjoy our script, created by: Logicodes.com 
 */
 
@session_start();

if(session_is_registered("admin"))

{include("functions.php");
include ('header.php');

db_connect();

if (@$removeid) mysql_query("update goods set paypalurl='' where pid='$removeid'");

if (@$new&&$itemid&&$payurl) mysql_query ("update goods set paypalurl='$payurl' where pid='$itemid'");

$result=db_result_to_array("select pid, name, paypalurl from goods where paypalurl like '%http%'");

$resall=db_result_to_array("select pid, name, price from goods order by pid");



$defaff=db_result_to_array("select defurl, affdir from admininfo");

$defurl=$defaff[0][0];

$affdir=$defaff[0][1];



?>

<?admin_menu();?>

<CENTER><h3>Existing Paypal IPNs setup per item</h3><table width="700" border="0">    

<?for ($i=0; $i<count($result); $i++)

{

?>

  <tr>

    <td width="99"><b>ItemID</b>: <?echo $result[$i][0];?></td>

    <td width="591"><b>Item Name</b>: <?echo $result[$i][1];?></td>

  </tr>

  <tr>

    <td width="99"><a href="admpaypalset.php?removeid=<?echo $result[$i][0];?>">Remove</a></td>

    <td width="591"><b>Paypal Payment URL</b>:<br><?echo $result[$i][2];?>

    </td>

  </tr>

  <tr>

  <td colspan=2><hr width=250 size=1>

  </td>

  </tr>

<?}?>

</table><P>For use, you must redirect the customer to <b>http://<?echo $defurl.$affdir;?>payment/paymentpaypal.php?itemid=xxxx</b></P>

<form method="post" action="admpaypalset.php">

<input type="Hidden" name="new" value=1>

  <table width="662" border="0">

    <tr>

      <td colspan="2" align="center">

        <h2>Setup another Paypal IPN item</h2>

      </td>

    </tr>

    <tr>

      <td width="133"><b>Item:</b></td>

      <td width="519">

        <select name="itemid">

          <option selected>Please select an item</option>

		  <?for ($i=0; $i<count($resall); $i++) {?>

          <option value="<?echo $resall[$i][0];?>"><?echo $resall[$i][0];?> : <?echo $resall[$i][1];?> : $<?echo $resall[$i][2];?></option>

		  <?}?>

		  </select></td>

    </tr>

    <tr>

      <td width="133"><b>Paypal given payment URL:</b></td>

      <td width="519">

        <input type="text" name="payurl" size="50" maxlength="250" value="http://">

      </td>

    </tr>

    <tr>

      <td width="133">&nbsp;</td>

      <td width="519">&nbsp;</td>

    </tr>

    <tr>

      <td width="133" valign="top"><b>Paypal Completion URL:<br>

        <font size="1">(This URL should be<br>

        set in paypal)</font></b></td>

      <td width="519">

        <p>The completion URL should be:<br>

          <i>http://<?echo $defurl.$affdir;?>payment/paymentpaypal.php?itemid=xxxx</i><br>

      </td>

    </tr>

    <tr>

      <td colspan=2><br>

        Note: If you will try to set up an existing item, it will be re-writed.</td>

    </tr>

    <tr align="center">

      <td colspan="2"><br>

        <input type="submit" value="Setup IPN for this item" name="SetupPaypal">

        <input type="reset" value="Clear Form">

      </td>

    </tr>

  </table>

  </form>

  <br>

  <form method="post" action="adminlogin.php">

  <input type="submit" name="Submit" value="Click here to return to Main Menu">

</form>

</CENTER>



</TABLE>



<?}

else echo "You are not logged in!";

?>