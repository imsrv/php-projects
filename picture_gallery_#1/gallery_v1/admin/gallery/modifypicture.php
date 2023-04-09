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
$lines = file('../files/gallery.php');

array_splice($lines,0,1);
array_splice($lines,count($lines)-1);

foreach ($lines as $line_num => $line) {
	if ($line_num>0) {
		$parser = array();
	    $parser = split("~",$line);
	    $idgallery = $parser[0];
		if ($idgallery == $id) {
		    $name = $parser[1];
		    $descr = ereg_replace("(\r\n|\n|\r)", "", $parser[2]);
		}
	}
}
?>
<script language="JavaScript">
	function validate(frm)
	{
		if (frm.fname.value=="")
		{
			alert("Please enter first name");
			return false;		
		}
		return true;
	}
</script>
<table border="0" width="100%" class="text">
<tr>
   <td class="title" align="justify" style="padding-left:216px">Edit picture<img src="../images/pixel.gif" width="198" height="0" border="0"><a href="index.php" class="textblack11b"><< <u>Back</u></a>&nbsp;</td>
</tr>
<tr><td><img scr="images/pixel.gif" width="1" height="5" border="0"></td></tr>
<tr>
	<td>
<?
	//content here
	$content = '
		<form action="updatepicture.php" name="upload" method="post" enctype="multipart/form-data" onsubmit="return validate(this)">
		<script language="JavaScript" type="text/javascript">
        	frm = document.upload;
        </script>
		<input type="hidden" name="op" value="2">
		<input type="hidden" name="id" value="'.$id.'">
		<table cellspacing="4" cellpadding="2" align="center" border="0" width="350">
		 <tr>
			<td class="textblack11"><strong>Name</strong></td>
			<td>&nbsp;<input type="text" name="name" class="textBox" size="40" value="'.$name.'"></td>
		</tr>
		<tr>
			<td class="textblack11" valign="top"><strong>Description</strong></td>
			<td>&nbsp;<textarea name="descr" class="textBox" cols="41" rows="10">'.$descr.'</textarea></td>
		</tr>
		'.(is_file("../../images/img".($id).".jpg")?'<tr><td class="textblack11" colspan="2" align="center"><img src="../../images/img'.($id).'.jpg" border="0" width="100" height="110" align="middle"></td></tr>':'').'
		<tr>
			<td class="textblack11"><strong>Upload jpg</strong>: </td>
			<td class="textblack11">&nbsp;&nbsp;<input type="file" name="imageName" class="textBox" size="26"></td>
		</tr>
		<tr><td colspan="2"><img src="images/pixel.gif" width="1" height="10" border="0"></td></tr>
        </table>
	';
	echo $content;
?>		
	</td>
</tr>
<tr><td><img src="images/pixel.gif" width="1" height="10" border="0"></td></tr>
<tr><td align="center"><input type="submit" value="     Modify     " class="textBox" style="cursor: hand"></form></td></tr>
</table>
<?
include ("../include/bottom.php");
?>
