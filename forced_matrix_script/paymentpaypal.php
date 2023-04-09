<?
/* nulled by [GTT] :) */    

include("functions.php");
include("header.php");
db_connect();

$timet=time();
$affid=$refid;
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($HTTP_POST_VARS as $key => $value) {
  $value = urlencode(stripslashes($value));
  $req .= "&$key=$value";
}

$testmode=db_result_to_array("select testmode from admininfo");
$testmode=$testmode[0][0];

if ($testmode)
{
// post back to EliteWeaver system to validate
$header="";
$header .= "POST /testing/ipntest.php HTTP/1.1\r\n";
$header .= "Host: www.eliteweaver.co.uk\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= 'Content-Length: ' . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.eliteweaver.co.uk', 80, $errno, $errstr, 30);
}
else
{
// post back to PayPal system to validate
$header="";
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
//$header .= "Host: www.paypal.com\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= 'Content-Length: ' . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
}

// assign posted variables to local variables
// note: additional IPN variables also available -- see IPN documentation

$item_number = $HTTP_POST_VARS['item_number'];
$payment_status = $HTTP_POST_VARS['payment_status'];
$payment_gross = $HTTP_POST_VARS['payment_gross'];
$txn_id = $HTTP_POST_VARS['txn_id'];
$first_name = $HTTP_POST_VARS['first_name'];
$last_name = $HTTP_POST_VARS['last_name'];
$payer_id = $HTTP_POST_VARS['payer_id'];



$subscr_date = $_POST['subscr_date'];
@$subscr_id = $_POST['subscr_id'];
$txn_type = $_POST['txn_type'];

$temparray = split("a", $item_number);

if (@!$itemid) $itemid=$temparray[0];
if (@!$affid) $affid=$temparray[1];



if (!$fp) {
  // ERROR
  echo "$errstr ($errno)";
} else {
 fputs ($fp, $header . $req);
/**/   while (!feof($fp)) {
    $res = fgets ($fp, 1024);
    if (strcmp ($res, "VERIFIED") == 0)
        {/**/
       if ($txn_type=="subscr_signup")
           {
               $orderinfo=db_result_to_array("select cancelrecurl, subscrdate, subscrid, ptsmade from orders where subscrid='$subscr_id'");
           if (@!$orderinfo)
                   $r = mysql_query("insert into orders (txn_id, date, goodid, affid, customername, subscrdate, subscrid) values ('$txn_id', '".time()."', '$itemid', '$affid', '$first_name $last_name', '$subscr_date', '$subscr_id')") or die (mysql_error());
           }
           else if ($txn_type=="subscr_payment")
       {        sleep(5);
          $orderinfo=db_result_to_array("select cancelrecurl, subscrdate, subscrid, ptsmade from orders where subscrid='$subscr_id'");
          if ($orderinfo[0][0]==0 &&($orderinfo[0][1]&&$orderinfo[0][2]))
              mysql_query("update orders set txn_id='$txn_id', date='".time()."', ptsmade='".($orderinfo[0][3]+1)."' where subscrid='$subscr_id'");
                    //mysql_query("insert into orders (txn_id, date, goodid, affid, customername, subscrdate, subscrid) values ('$txn_id', '".time()."', '$itemid', '$affid', '$first_name $last_name', '$subscr_date', '$subscr_id')");
           }
       else  if ($payment_status=="Completed"  && $txn_type=="web_accept")
           {
          //echo "<br>payment completed now working with database<br>";
          $existtxn=db_result_to_array("select txn_id, date from orders where txn_id='$txn_id'");
                  if (!$existtxn[0][0])
                  {
                     //echo "<br>the transaction is a new one - successgull payment!<br>";
                     $tempprice=db_result_to_array("select price, programid, subscrid from aff_payments where id='$itemid'");
                     if ($tempprice[0][0])//single item
                      $price[0][0]=$tempprice[0][0];
                     else if ($tempprice[0][1])//program
                      $price=db_result_to_array("select programs.price from aff_payments, programs where aff_payments.id='$itemid' and programs.id=aff_payments.programid");
                     if ($price[0][0]<=$payment_gross)
                     {
                             //echo "<br>paid price is ok!<br>";
                         @session_register("paidprogramid");
                         $paidprogramid=$tempprice[0][1];
                         //echo "<br>single item!<br>";
                         $query="insert into orders (txn_id, date, goodid, affid, customername, payerid) values ('$txn_id', '".time()."', '$itemid', '$affid', '$first_name $last_name', '$payer_id')";
                         mysql_query($query);
                         echo "Your order has been successfuly recordered. ";
                                 if ($tempprice[0][1])//program
                          echo "<br>Thank you!<br>Click <a href=getfile.php>here</a> to proceed";
                      }
                      else echo "You have paid less amount that needed. If you have any queations, contact us!";
              }
              else echo "<br>strange ".$existtxn[0][0]." at time ".$existtxn[0][1]."<br>";
           }
           else echo "Normal transaction has payment_status like 'Completed', currently it is $payment_status";
/**/}
      else if (strcmp ($res, "INVALID") == 0) {
      // log for manual investigation
          echo "Nothing has happend!";
      }
  }/**/
  fclose ($fp);
}

include("footer.php");
?>