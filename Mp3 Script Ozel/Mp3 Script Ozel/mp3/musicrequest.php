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
      <td width="243" height="17" valign="top" background="images/tall_m.gif" bgcolor="#404040"><div align="center" class="style1">Music Request </div></td>
    </tr>
    <tr>
      <td height="150" valign="top" background="images/ban2.jpg"><?
$yname = $_POST['your_name']; 
$yemail = $_POST['your_email']; 
$type = $_POST['type'];
$artist = $_POST['artist'];
$album = $_POST['album_name']; 

if (!$yname) { 
echo "Please fill in your name field"; 
die; 
} 

if (!$yemail) { 
echo "Please fill in you Email field"; 
die;
} 

if (!$type) { 
echo "Please fill in the message field"; 
} 

if (!$artist) { 
echo "Please fill in the artist field"; 
} 

if (!$album) { 
echo "Please fill in the album field"; 
} 

mail($req_email, "Album/Song/Video Request", "$yname\n$yemail\n$type\n$artist\n$album", "From: Nomad <my@email.com>"); 

echo "SENT EMAIL SUCCESSFULLY!"; //now lets tell the user "your email was sent!"

?>
&nbsp; </td>
    </tr>
  </table>
</div>
