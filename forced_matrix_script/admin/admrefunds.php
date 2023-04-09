<?php

/* nulled by [GTT] :) */ 

@session_start();

if(session_is_registered("admin"))

{

include("functions.php");
include ('header.php');

db_connect();

?>

<?admin_menu();?>

<CENTER>

  <h3>Search for item to be refunded</h3>

  <form method="post" action="admsearchorders.php">

    <p>Approximate date when customer initially made purchase (results for that

      week will be displayed)</p>

    <p>

      <select name="refundyear">

        <option value="">Year</option>

        <option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option>      </select>

      /

      <select name="refundmonth">

        <option value="">Month</option>

        <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>      </select>

    </p>

    <p><b>OR</b></p>

    <p>Customer's Name</p>

    <p>

      <input type="text" name="custname" size="25" maxlength="100">

    </p>

    <p><b>OR</b></p>

    <p>Receipt Number provided to customer</p>

    <p>

      <input type="text" name="refundreceiptnum" size="5" maxlength="50">

    </p>

    <p>

      <input type="submit" name="actionbtn" value="Cancel Repeated Payments">

      <input type="submit" name="actionbtn" value="Request Refund">

    </p>

    <p>Note: You can also &quot;Cancel Repeated Payments&quot; during the Cooling

      Off period</p>

  </form>

  <br>

  <form method="post" action="adminlogin.php">

  <input type="submit" name="Submit" value="Click here to return to Main Menu">

</form>

</CENTER>





<?}

else echo "You are not logged in";

?>
