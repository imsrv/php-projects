<?php
include ('admin_design.php');
include ('../application_config_file.php');
include ('admin_auth.php');
include("header.php");
$invoice_query = bx_db_query("SELECT *,".$bx_table_prefix."_invoices.currency as icurrency, ".$bx_table_prefix."_invoices.discount as invoice_discount from ".$bx_table_prefix."_companies, ".$bx_table_prefix."_invoices where ".$bx_table_prefix."_invoices.opid = '".$HTTP_POST_VARS['opid']."' and  ".$bx_table_prefix."_companies.compid = ".$bx_table_prefix."_invoices.compid");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$invoice_result = bx_db_fetch_array($invoice_query);
if ($HTTP_POST_VARS['action'] == "upgrades") {
    $mailfile = $language."/mail/upgrade_admindeclined.txt";
}
else {
    $mailfile = $language."/mail/buyer_admindeclined.txt";
}
include(DIR_LANGUAGES.$mailfile.".cfg.php");
$mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
$invoice_result['listprice'] = bx_format_price($invoice_result['listprice'],$invoice_result['icurrency']);
$invoice_result['invoice_discount'] = bx_format_price((($invoice_result['listprice']*$invoice_result['invoice_discount'])/100),$invoice_result['icurrency']);
$invoice_result['totalprice'] = bx_format_price($invoice_result['totalprice'],$invoice_result['icurrency']);
$invoice_result['invoice_paymentdate'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
if ($html_mail == "no") {
     $invoice_result['payment_information'] = eregi_replace("<br>","\n",eregi_replace("&nbsp;"," ",eregi_replace("<ul>|<li>|</ul>|</li>|<p>|</p>","",PAYMENT_INFORMATION)));
     $invoice_result['company_information'] = eregi_replace("<br>","\n",eregi_replace("&nbsp;"," ",eregi_replace("<ul>|<li>|</ul>|</li>|<p>|</p>","",COMPANY_INFORMATION)));
}
else {
     $invoice_result['payment_information'] = PAYMENT_INFORMATION;
     $invoice_result['company_information'] = COMPANY_INFORMATION;
}
$invoice_result['description'] = $HTTP_POST_VARS['description'];
reset($fields);
while (list($h, $v) = each($fields)) {
        $mail_message = eregi_replace($v[0],$invoice_result[$h],$mail_message);
        $file_mail_subject = eregi_replace($v[0],$invoice_result[$h],$file_mail_subject);
}
if ($add_mail_signature == "on") {
        $mail_message .= "\n".SITE_SIGNATURE;
}
bx_mail(SITE_NAME,SITE_MAIL,$invoice_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
bx_db_query("DELETE FROM ".$bx_table_prefix."_invoices where opid='".$HTTP_POST_VARS['opid']."'");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$success_message = "Decline message was sent to ".$invoice_result['email'].". <br>Invoice was deleted.";
include("success_form.php");
include("footer.php");
?>