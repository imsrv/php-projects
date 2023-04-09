<?php
/* nulled by [GTT] :) */ 

@session_start();

if(session_is_registered("admin"))

{

include("functions.php");
include ('header.php');

db_connect();

if (@$canselrectxn) mysql_query("update orders set cancelrecurl='1' where txn_id='$canselrectxn'");

if (@$refundtxn)

 {

   $order=db_result_to_array("select goodid, affid, ptsmade from orders where txn_id='$refundtxn'");

   $good=db_result_to_array("select directaf, af1, af2, af3, af4, af5, af6, af7 from goods where pid='".$order[0][0]."'");

   if (@$recurring)  $factor=$order[0][2]; else $factor=1;

         $user=db_result_to_array("select saleqt, saleam from users where id='".$order[0][1]."'");

     $user[0][0]-=$factor;

         $user[0][1]-=$good[0][0]*$factor;

         mysql_query("update users set saleqt='".$user[0][0]."', saleam='".$user[0][1]."' where id='".$order[0][1]."'");

         $id=$order[0][1];

         for ($k=0; $k<7; $k++)

         {

          $referer=db_result_to_array("select referer from users where id='$id'");

          if ($referer[0][0])

           {

            $amtqnt=db_result_to_array("select lev".($k+1)."saleqt, lev".($k+1)."saleam from users where id='".$referer[0][0]."'");

                $amtqnt[0][0]-=$factor;

                $amtqnt[0][1]-=$good[0][$k+1]*$factor;

            mysql_query("update users set lev".($k+1)."saleqt='".$amtqnt[0][0]."', lev".($k+1)."saleam='".$amtqnt[0][1]."' where id='".$referer[0][0]."'");

                $id=$referer[0][0];

           }

          else $k=10;

         }

         mysql_query("delete from orders where txn_id='$refundtxn'");

 }

?>

<?admin_menu();?>



<center>

<?if ($actionbtn=="Cancel Repeated Payments") {

$orders=db_result_to_array("select txn_id, date, ptsmade, subscrdate, subscrid, customername, goodid, affid from orders where cancelrecurl='0' and subscrdate !=''");

echo "<form action=admsearchorders.php><table width=100%><tr><td>Last txn id</td><td>Last payment date</td><td>Payments made</td><td>Subscribtion date</td><td>Subscriber id</td><td>Buyer</td><td>Item number</td><td>Referer id</td><td>Select</td></tr>";

for ($i=0; $i<count($orders); $i++)

  {?>

<tr><td><?echo $orders[$i][0];?></td><td><?echo date('Y-m-d', $orders[$i][1]);?></td><td><?echo $orders[$i][2];?></td><td><?echo date('Y-m-d', $orders[$i][3]);?></td><td><?echo $orders[$i][4];?></td><td><?echo $orders[$i][5];?></td><td><?echo $orders[$i][6];?></td><td><?echo $orders[$i][7];?></td><td><input name=canselrectxn value="<?echo $orders[$i][0];?>" type=radio></td></tr>

<?}?>

</table><P><input type="submit" value="Cancel this Repeated Payment"></P><P>** Please note that this will permanently cancel any further repeated payments to

the affiliate (cannot be undone).</P>

<input type=hidden name=actionbtn value="Cancel Repeated Payments">

</form>

<?}?>



<?if ($actionbtn=="Request Refund") {

$orders=db_result_to_array("select txn_id, date, payerid, customername, goodid, affid from orders where subscrdate =''");

echo "<h3>Non-recurring payments</h3><form action=admsearchorders.php><table width=100%><tr><td>Txn id</td><td>Payment date</td><td>Buyer id</td><td>Buyer</td><td>Item number</td><td>Referer id</td><td>Select</td></tr>";

for ($i=0; $i<count($orders); $i++)

  {?>

<tr><td><?echo $orders[$i][0];?></td><td><?echo date('Y-m-d', $orders[$i][1]);?></td><td><?echo $orders[$i][2];?></td><td><?echo $orders[$i][3];?></td><td><?echo $orders[$i][4];?></td><td><?echo $orders[$i][5];?></td><td><input name=refundtxn value="<?echo $orders[$i][0];?>" type=radio></td></tr>

<?}?>

</table><P><input type="submit" value="Refund this order"></P>

<input type=hidden name=actionbtn value="Request Refund">

</form>

<?

$orders=db_result_to_array("select txn_id, date, ptsmade, subscrdate, subscrid, customername, goodid, affid from orders where cancelrecurl='0' and subscrdate !=''");

echo "<br><h3>Recurring payments</h3><form action=admsearchorders.php><table width=100%><tr><td>Last txn id</td><td>Last payment date</td><td>Payments made</td><td>Subscribtion date</td><td>Subscriber id</td><td>Buyer</td><td>Item number</td><td>Referer id</td><td>Select</td></tr>";

for ($i=0; $i<count($orders); $i++)

  {?>

<tr><td><?echo $orders[$i][0];?></td><td><?echo date('Y-m-d', $orders[$i][1]);?></td><td><?echo $orders[$i][2];?></td><td><?echo date('Y-m-d', $orders[$i][3]);?></td><td><?echo $orders[$i][4];?></td><td><?echo $orders[$i][5];?></td><td><?echo $orders[$i][6];?></td><td><?echo $orders[$i][7];?></td><td><input name=refundtxn value="<?echo $orders[$i][0];?>" type=radio></td></tr>

<?}?>

</table><P><input type="submit" value="Refund this Repeated Payment"></P><P>** Please note that refunds here will only deduct amounts from affiliates.

      It will not refund the customer. To refund the customer, you must contact

      your credit card merchant.<br>

      A refund implies a customer has left and will not be returning. In the case

      of subscriptions, it is recommended you give the customer credit for the next

subscription period instead of refunding the customer (if they intend to stay for another period).</P>

<input type=hidden name=actionbtn value="Request Refund">

<input type=hidden name=recurring value=1>

</form>

<?}?>

<br>

  <form method="post" action="adminlogin.php">

  <input type="submit" name="Submit" value="Click here to return to Main Menu">

</form>

</center>

<?}

else echo "You are not logged in";

?>
