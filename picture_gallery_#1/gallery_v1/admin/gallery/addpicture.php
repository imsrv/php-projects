<?
if (!ini_get('register_globals')) 
   {
       $types_to_register = array('GET','POST','COOKIE','SESSION','SERVER');
       foreach ($types_to_register as $type)
       {
           if (@count(${'HTTP_' . $type . '_VARS'}) > 0)
           {
               extract(${'HTTP_' . $type . '_VARS'}, EXTR_OVERWRITE);
           }
       }
   }

session_start();
if(!session_is_registered("auth"))
	header ("Location: ../index.php");
$urlpage = "../";
$lang = 'none';
include($urlpage."config.php");
include ($urlpage."include/header.php");

$lines = file("../files/gallery.php");

array_splice($lines,0,1);
array_splice($lines,count($lines)-1);

if (count($lines)>1) {
	$line = $lines[count($lines)-1];
	$parser = split("~",$line);
	$lid = $parser[0];
}else{
	$lid = 1;
}
?>
<script language="JavaScript">
	function validate(frm)
	{
		if (frm.fname.value=="")
		{
			alert("Please enter name");
			return false;		
		}
		return true;
	}
</script>
<table border="0" width="750" class="text">
<tr>
   <td class="title" align="justify" style="padding-left:204px">Add picture<img src="../images/pixel.gif" width="175" height="0" border="0"><a href="index.php" class="textblack11b"><< <u>Back</u></a>&nbsp;</td>
</tr>
<tr><td><img scr="images/pixel.gif" width="1" height="5" border="0"></td></tr>
<tr>
	<td>
<?
	//content here
	$content = '
		<form action="updatepicture.php" name="upload" method="post" enctype="multipart/form-data" onsubmit="return validate(this)">
		<input type="Hidden" name="lid" value="'.$lid.'">
		<input type="hidden" name="op" value="1">
		<table cellspacing="4" cellpadding="0" align="center" border="0" width="350">
		<tr>
			<td class="textblack11"><strong>Name</strong></td>
			<td>&nbsp;<input type="text" name="name" class="textBox" size="40"></td>
		</tr>
		<tr>
			<td class="textblack11"><strong>Upload jpg</strong>:</td>
			<td>&nbsp;<input type="file" name="image" class="textBox" size="26"></td>
		</tr>
		<tr>
			<td class="textblack11" valign="top"><strong>Description</strong></td>
			<td>&nbsp;<textarea name="descr" class="textBox" cols="41" rows="10"></textarea></td>
		</tr>
		<tr><td colspan="2"><img src="images/pixel.gif" width="1" height="10" border="0"></td></tr>
        </table>
	';
	echo $content;
?>		
	</td>
</tr>
<tr><td><img src="images/pixel.gif" width="1" height="10" border="0"></td></tr>
<tr><td align="center"><input type="submit" value="     Add picture     " class="textBox" style="cursor: hand"></form></td></tr>
</table>
<?
include ("../include/bottom.php");
?>
