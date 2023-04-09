<? include('admin/prices1.inc.php'); ?>

 <? 

 function makeurl($pay_email,$item_name,$item_number,$item_price,$success_url,$cancel_url){
 $item_url = "https://www.paypal.com/subscriptions/business=PAY_EMAIL&item_name=ITEM_NAME&item_number=ITEM_NUM&no_shipping=1&return=SUCCESS_URL&cancel_return=CANCEL_URL&no_note=1&currency_code=USD&a3=ITEM_PRICE&p3=1&t3=M&src=1&sra=1"; 
	
	//Format the data as required
	$item_price = number_format($item_price,2,'.','');
	$pay_email = str_replace("@","%40",$pay_email);
	$success_url = str_replace(":","%3A",$success_url);
	$cancel_url = str_replace(":","%3A",$cancel_url);
	//Enter Data
	$item_url = str_replace("PAY_EMAIL",$pay_email,$item_url);
	$item_url = str_replace("ITEM_NAME",$item_name,$item_url);
	$item_url = str_replace("ITEM_NUM",$item_number,$item_url);	
	$item_url = str_replace("ITEM_PRICE",$item_price,$item_url);
	$item_url = str_replace("SUCCESS_URL",$success_url,$item_url);
	$item_url = str_replace("CANCEL_URL",$cancel_url,$item_url);	
	//return vale
 	return $item_url;
 }
 ?>
<table width="400" border="0" cellspacing="2" cellpadding="0" align="left">
  <tr bgcolor="#006699"> 
    <td width="25%"> <div align="center"><b><font color=FFFFFF>Type</font></b></div></td>
    <td width="25%"> <div align="center"><b><font color=FFFFFF>Price</font></b></div></td>
    <td width="25%"> <div align="center"><b></b></div></td>
  </tr>
  <tr bgcolor="EEEEEE"> 
    <td width="25%"> <div align="right">Silver</div></td>
    <td width="25%"> <div align="right">$ <? print number_format($p1,2,'.',''); ?></div></td>
    <td width="25%"> <div align="center"> <a href='<? print makeurl(urlencode($email_pay),"Silver",1,$p1,"$path/cancel.php","$path/thanks.php"); ?>'><font color=blue>Purchase</font></a> </div></td>
  </tr>
  <tr bgcolor="EEEEEE"> 
    <td width="25%"> <div align="right">Gold</div></td>
    <td width="25%"> <div align="right">$ <? print number_format($p2,2,'.',''); ?></div></td>
    <td width="25%"> <div align="center"> <a href='<? print makeurl(urlencode($email_pay),"Gold",2,$p2,$path . "/cancel.php",$path . "/thanks.php"); ?>'><font color=blue>Purchase</font></a> </div></td>
  </tr>

</table>

