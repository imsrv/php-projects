<? include ('pages-setting.php')?>
<style type="text/css">
<!--
.style1 {
	color: #333333;
	font-weight: bold;
	font-family: tahoma;
	font-size: 11px;
}
body {
	background-image: url(images/tall1.jpg);
}
-->
</style>
<div align="center">
  <table width="243" border="0" cellpadding="0" cellspacing="0">
    <!--DWLayoutTable-->
    <tr>
      <td width="243" height="17" valign="top" background="images/tall_m.gif" bgcolor="#404040"><div align="center" class="style1">Contact Us </div></td>
    </tr>
    <tr>
      <td height="150" valign="top" background="images/ban2.jpg"><?
$yname = $_POST['your_name2']; 
$yemail = $_POST['your_email2']; 
$massage = $_POST['massage'];
if (!$yname2) { 
echo "Please fill in your name field"; 
die; 
} 

if (!$yemail2) { 
echo "Please fill in you Email field"; 
die;
} 

if (!$massage) { 
echo "Please fill in the message field"; 
} 
mail($contact_email, "Contact", "$yname\n$yemail\n$massage", "From: Nomad <my@email.com>"); 

echo "SENT EMAIL SUCCESSFULLY!"; 
?>
&nbsp; </td>
    </tr>
  </table>
</div>
