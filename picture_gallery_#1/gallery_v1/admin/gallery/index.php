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
?>
<script language="JavaScript">
	function openWin(url) {
		window.open(url, 'url', "toolbar=0,location=0,directories=0,status=0,menubar=no,scrollbars=no,resizable=no,width=380,height=200");
	}
	function goModify(id)
	{
		document.location.href="modifypicture.php?id=" + id;
	}
	function goDelete(id)
	{
		if (confirm("Are you sure you want to delete this picture?"))
		{
			document.location.href="updatepicture.php?op=3&id=" + id;
		}
	}
</script>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="text">
<tr>
   <td>  
	 <p align="center" class="textblack12b">Pictures</p>
   </td>
</tr>
<tr><td><img src="images/pixel.gif" width="1" height="5" border="0"></td></tr>
<?
	if (isset($info_err))
	{
		echo '<tr><td><img src="images/pixel.gif" width="1" height="2" border="0"></td></tr>
			<tr><td class="error" align="center"><b>'.$info_err.'</b></td></tr>
			<tr><td><img src="images/pixel.gif" width="1" height="2" border="0"></td></tr>';
		session_unregister("info_err");
	}
?>
<tr><td></td></tr>
<tr>
	<td valign="top">
<?
	//content here
	$content ='
	<table cellspacing="1" cellpadding="0" align="center" border="0" width="750">
    <tr bgcolor="#51BD39">
    	<td class="textblack11b" align="center" width="20" style="border:1px solid #51BD39" background="'.$urlpage.'images/interface/bk.gif">Id</td>
		<td class="textblack11b" align="left" width="200" style="border:1px solid #51BD39" background="'.$urlpage.'images/interface/bk.gif">&nbsp;Name</td>
		<td class="textblack11b" align="left" width="200" style="border:1px solid #51BD39" background="'.$urlpage.'images/interface/bk.gif">&nbsp;Description</td>
		<td class="textblack11b" align="left" width="200" style="border:1px solid #51BD39" background="'.$urlpage.'images/interface/bk.gif">&nbsp;Date</td>
		<td class="white11b" align="center" style="border:1px solid #51BD39">Actions</td>
    </tr>
	';
	$order = 0;
	$lines = file('../files/gallery.php');
	
	array_splice($lines,0,1);
	array_splice($lines,count($lines)-1);
	
	foreach ($lines as $line_num => $line) {
		if ($line_num == 0) {
			$fparser = array();
			$fparser = split("~",$line);
			$mainColor = $fparser[0];
			$secondColor = $fparser[1];
			$thirdColor = $fparser[2];
			$fourthColor = $fparser[3];
			$lbl_GalleryMessage = $fparser[4];
			$lbl_GalleryText = $fparser[5];
			$lbl_txNext = $fparser[6];
			$lbl_txPrevious = $fparser[7];
			$lbl_txDescr = $fparser[8];
			$lbl_txPicture = $fparser[9];
		}
		if ($line_num>0) {
			$mcolor = ($color%2==0)?'#f0f0f0':'#ffffff';$color++;
			$parser = array();
		    $parser = split("~",$line);
		    $id = $parser[0];
		    $fname = $parser[1];
		    $description = $parser[2];
			$filele = "../../images/img".($id).".jpg";
			$date = is_file($filele)?date("d-m-Y",filemtime ($filele)):"-";
			$order++;
			$content .= '
			<tr>
	    		<td class="textblack11" align="center" style="border:1px solid #C0C0C0">'.$order.'</td>
				<td class="textblack11" align="left" style="border:1px solid #C0C0C0">&nbsp;'.(($fname!="")?$fname:"-").' '.(($lname!="")?$lname:"").'</td>
				<td class="textblack11" align="left" style="border:1px solid #C0C0C0">&nbsp;'.(($description!="")?substr($description,0,20):"-").'...</td>
				<td class="textblack11" align="left" style="border:1px solid #C0C0C0">&nbsp;'.(($date!="")?$date:"-").'</td>
				<td align="center"><input type="button" class="textBox" value="Modify" onclick="javascript:goModify(\''.$id.'\')" style="cursor: hand">&nbsp;<input type="button" value="Delete" class="textBox" onclick="javascript:goDelete(\''.$id.'\')" style="cursor: hand"></td>
		    </tr>';
			} elseif ($line_num<0) {
			$content .= '<tr><td colspan="5"><img scr="images/pixel.gif" width="1" height="5" border="0"></td></tr>
						<tr><td class="error" colspan="7" align="center">There are no picture</td></tr>
						<tr><td colspan="5"><img scr="images/pixel.gif" width="1" height="5" border="0"></td></tr>';
		    }
	}
    $content .= '</table>';
	echo $content;
?>		
	</td>
</tr>
<tr><td><img src="images/pixel.gif" width="1" height="10" border="0"></td></tr>
<tr><td align="right" style="padding-right:16px"><input type="button" class="textBox2" value=" Add new " onClick="javascript:window.open('addpicture.php','_self')" style="cursor: hand;width:94px"></td></tr>
<tr><td><img src="images/pixel.gif" width="1" height="10" border="0"></td></tr>
<tr>
	<td valign="top" style="padding-left:15px">
		<form name="formcolors" action="updatepicture.php" method="post">
	<input type="hidden" name="op" value="4">

	<table cellpadding="2" cellspacing="2" border="0" align="center">
	<tr>
		<td class="textblack11b">Headers Color:<img src="../images/pixel.gif" width="70" height="1" border="0" align="middle"><a href="javascript: openWin('colorselect.php?lb=mainColor');" class="textblack11b"><img src="../images/pixel.gif" width="18" height="18" border="0" align="middle" style="border:1px;border-style: solid;border-color:#000000;background-color: #<?=$mainColor?>" name="mainColorImg"></a></td>
		<td width="25"><input type="Text" name="mainColor" value="<?=$mainColor?>" class="textBox" size="25"></td>
		<td width="15" height="15"></td>
		<td class="textblack11b" style="padding-left:5px">Label text Pictures:</td>
		<td width="25"><input type="Text" name="lbl_txPicture" value="<?=$lbl_txPicture?>" class="textBox" size="25"></td>
	</tr>
	<tr>
		<td class="textblack11b">Titles Color:<img src="../images/pixel.gif" width="85" height="1" border="0" align="middle"><a href="javascript: openWin('colorselect.php?lb=secondColor');" class="textblack11b"><img src="../images/pixel.gif" width="18" height="18" border="0" align="middle" style="border:1px;border-style: solid;border-color:#000000;background-color: #<?=$secondColor?>" name="secondColorImg"></a></td>
		<td width="25"><input type="Text" name="secondColor" value="<?=$secondColor?>" class="textBox" size="25"></td>
		<td width="15" height="15"></td>
		<td class="textblack11b" style="padding-left:5px">Label text Previous:</td>
		<td><input type="Text" name="lbl_txPrevious" value="<?=$lbl_txPrevious?>" class="textBox" size="25"></td>
	</tr>
	<tr>
		<td class="textblack11b">Text Color:<img src="../images/pixel.gif" width="92" height="1" border="0" align="middle"><a href="javascript: openWin('colorselect.php?lb=thirdColor');" class="textblack11b"><img src="../images/pixel.gif" width="18" height="18" border="0" align="middle" style="border:1px;border-style: solid;border-color:#000000;background-color: #<?=$thirdColor?>" name="thirdColorImg"></a></td>
		<td><input type="Text" name="thirdColor" value="<?=$thirdColor?>" class="textBox" size="25"></td>
		<td width="15" height="15"></td>
		<td class="textblack11b" style="padding-left:5px">Label text Next:</td>
		<td><input type="Text" name="lbl_txNext" value="<?=$lbl_txNext?>" class="textBox" size="25"></td>
	</tr>
	<tr>
		<td class="textblack11b">Select Color:<img src="../images/pixel.gif" width="82" height="1" border="0" align="middle"><a href="javascript: openWin('colorselect.php?lb=fourthColor');" class="textblack11b"><img src="../images/pixel.gif" width="18" height="18" border="0" align="middle" style="border:1px;border-style: solid;border-color:#000000;background-color: #<?=$fourthColor?>" name="fourthColorImg"></a></td>
		<td><input type="Text" name="fourthColor" value="<?=$fourthColor?>" class="textBox" size="25"></td>
		<td width="15" height="15"></td>
		<td class="textblack11b" style="padding-left:5px">No description:</td>
		<td><input type="Text" name="lbl_txDescr" value="<?=$lbl_txDescr?>" class="textBox" size="25"></td>
	</tr>
	<tr>
		<td class="textblack11b" style="padding-left:5px">Welcome message:</td>
		<td><input type="Text" name="lbl_GalleryMessage" value="<?=$lbl_GalleryMessage?>" class="textBox" size="25"></td>
		<td width="15" height="15"></td>
		<td class="textblack11b" style="padding-left:5px">Gallery title:</td>
		<td><input type="Text" name="lbl_GalleryText" value="<?=$lbl_GalleryText?>" class="textBox" size="25"></td>
	</tr>
	<tr><td colspan="5"><img src="images/pixel.gif" width="1" height="10" border="0"></td></tr>
	<tr>
		<td colspan="5" align="center"><input type="submit" class="textBox2" value=" Modify " style="cursor: hand"></td>
	</tr>
	</table>
	</form>
	</td>
</tr>
<tr><td><img src="images/pixel.gif" width="1" height="10" border="0"></td></tr>
</table>
<?
include ("../include/bottom.php");
?>
