<?php include("include/header.php"); 

?><br />
<h1><img src="images/bullet.gif" /> Успшено!</h1><br /><br />
Вы успешно отправили письмо администрации <?PHP include ("include/site_name.txt");?>:

<div><?
$name = $_POST["name"];
$email = $_POST["email"];
$enquiry = $_POST["enquiry"];
$today = date("M d, Y");
$forminfo =
"Name: $name\n
Email: $email\n
Message: $enquiry\n
Form Submitted: $today\n\n";
include("include/connect.txt");
$result = mysql_query("SELECT e_mail,e_mail_subject FROM ds_options");   
$recipient = mysql_result($result,0,"e_mail");
$subject = mysql_result($result,0,"e_mail_subject");


$formsend = mail("$recipient", "$subject", "$forminfo", "From: $email\r\nReply-to:$email");
?>

<br /><? echo nl2br($forminfo); ?>Мы обязательно отреагируем на Ваше сообщение в ближайшие 24 часа.
</div>
<?php include("include/footer.php"); ?>