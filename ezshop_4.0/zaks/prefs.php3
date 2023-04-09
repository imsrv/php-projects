<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
$database = "ezshop";
$table = "zaks";
$hostname = "www.host.com";
$user = "dbusername";
$pass = "dbpassword";
$realm = "Zaks Wine Catalog";
mysql_pconnect($hostname,$user,$pass);
$merchant_id = 1; // Set this to ID of Merchant

$method = "POST";
// extract merchant info:
$query = "Select * from merchant where merchant_id = $merchant_id";
$select = mysql($database,$query);

$merchant_name = mysql_result($select,0,"company");
$merchant_address = nl2br(mysql_result($select,0,"address"));
$merchant_postal_code = mysql_result($select,0,"postal_code");
$merchant_city = mysql_result($select,0,"city");
$merchant_province = mysql_result($select,0,"province");
$merchant_country = mysql_result($select,0,"country");
$merchant_phone = mysql_result($select,0,"sales_phone");
$merchant_fax = mysql_result($select,0,"sales_fax");
$merchant_email = mysql_result($select,0,"sales_email");

// Scema translation: Get labels for fields from user database
$item_label = "record_id";
$description_label = "winery~varietal~appellation";
$price_lable = "price";
$secure_url="http://steve.eyekon.com";
$unsecure_url="http://steve.eyekon.com";
$visa_fee = 3; // set to rate in percent for each credit card
$mc_fee = 3;
$amex_fee = 3;
$tbl_bgcolor = "#B49AA3";
$hdr_bgcolor = "#B49AA3";
$bdy_bgcolor = "#E3D3C9";
$ftr_bgcolor = "#B49AA3";
$hdr2_bgcolor = "#E6C47D";
$bdy2_bgcolor = "#E7DABE";
$font = "<font face='Verdana,Ariel'>";
?>
