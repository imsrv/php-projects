<form method="<? echo $method ?>" action="<? echo $SCRIPT_NAME ?>">
<? 
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
$query = "Select * from payment where user_id='$PHP_AUTH_USER'";
$select = mysql($database,$query);
print(mysql_error());
if(mysql_numrows($select) > 0){
$card_name=mysql_result($select,0,"card_name");
$card_number=mysql_result($select,0,"card_number");
$exp_month=mysql_result($select,0,"exp_month");
$exp_year=mysql_result($select,0,"exp_year");
$pay_method=mysql_result($select,0,"pay_method");
}

include("topnavbar.php3");?>
  <script language="php">EchoFormVars();</script>
<center>
  <table width="95%" bgcolor="#FFFFFF" cellspacing="0" border="0">
    <tr>
	<? if ($update == "False"){ ?>
    <tr>
      <td colspan="2"><p><big>There was a problem with the form... </big><br>
	  <? print($message);?></td>
    </tr>
	<? } ?>

      <td align="left">
	<br>
	<p>Please select your payment method. If you will be faxing in this order, please select Fax/Mail. If you wish 
	to use a credit card, select a credit card type from the drop down list and fill out your credit card information.
	<ul>
	<p>Payment Method 
      <select name="pay_method" size="1">
        <option <? if($pay_method == "Fax/Mail"){print("Selected");}?>>Fax/Mail</option>
        <option <? if($pay_method == "VISA"){print("Selected");}?>>VISA</option>
        <option <? if($pay_method == "Mastercard"){print("Selected");}?>>Mastercard</option>
 <option <? if($pay_method == "Discover"){print("Selected");}?>>Discover</option>
      </select>
	</p>
	<p>If you selected Credit Card type, please fill out the following:</p>
	<p>Name on Card <input type="text" size="36" name="card_name" value="<? echo $card_name ?>"><br>
	<p>Credit Card Number <input name="card_number" size="36" value="<? print($card_number) ?>"> </p>
	<p>Expiration Date: Month 
	<select name="exp_month" size="1">
        <option <? if($exp_month == 1){print("Selected");}?>>1</option>
        <option <? if($exp_month == 2){print("Selected");}?>>2</option>
        <option <? if($exp_month == 3){print("Selected");}?>>3</option>
        <option <? if($exp_month == 4){print("Selected");}?>>4</option>
        <option <? if($exp_month == 5){print("Selected");}?>>5</option>
        <option <? if($exp_month == 6){print("Selected");}?>>6</option>
        <option <? if($exp_month == 7){print("Selected");}?>>7</option>
        <option <? if($exp_month == 8){print("Selected");}?>>8</option>
        <option <? if($exp_month == 9){print("Selected");}?>>9</option>
        <option <? if($exp_month == 10){print("Selected");}?>>10</option>
        <option <? if($exp_month == 11){print("Selected");}?>>11</option>
        <option <? if($exp_month == 12){print("Selected");}?>>12</option>
      </select> Year 
	<select name="exp_year" size="1">
        <option <? if($exp_year == 1998){print("Selected");}?>>1998</option>
        <option <? if($exp_year == 1999){print("Selected");}?>>1999</option>
        <option <? if($exp_year == 2000){print("Selected");}?>>2000</option>
        <option <? if($exp_year == 2001){print("Selected");}?>>2001</option>
        <option <? if($exp_year == 2002){print("Selected");}?>>2002</option>
        <option <? if($exp_year == 2003){print("Selected");}?>>2003</option>
        <option <? if($exp_year == 2004){print("Selected");}?>>2004</option>
        <option <? if($exp_year == 2005){print("Selected");}?>>2005</option>
        <option <? if($exp_year == 2006){print("Selected");}?>>2006</option>
        <option <? if($exp_year == 2007){print("Selected");}?>>2007</option>
        <option <? if($exp_year == 2008){print("Selected");}?>>2008</option>
        <option <? if($exp_year == 2009){print("Selected");}?>>2009</option>
        <option <? if($exp_year == 2010){print("Selected");}?>>2010</option>
      </select> </p>
	</ul>
	<center><p align="center">
	<? if(isset($prev_action)){ ?>
	<input type="hidden" name="prev_action" value="<? print($prev_action) ?>">
	<? } ?>
	<input type="hidden" name="action" value="Update Payment Info">
	<input type="submit" value="Continue"></p></center>
	</td>
    </tr>
  </table>
</center>
</form>
