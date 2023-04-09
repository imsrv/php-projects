<?php  
/*+---------------------------------------------------------------------------+
*|	SnippetMaster 
*|	by Electric Toad Internet Solutions, Inc.
*|	Copyright (c) 2002 Electric Toad Internet Solutions, Inc.
*|	All rights reserved.
*|	http://www.snippetmaster.com
*|
*|+----------------------------------------------------------------------------+
*|  Evaluation copy may be used without charge on an evaluation basis for 30 
*|  days from the day that you install SnippetMaster.  You must pay the license 
*|  fee and register your copy to continue to use SnippetMaster after the 
*|  thirty (30) days.
*|
*|  Please read the SnippetMaster License Agreement (LICENSE.TXT) before 
*|  installing or using this product. By installing or using SnippetMaster you 
*|  agree to the SnippetMaster License Agreement.
*|
*|  This program is NOT freeware and may NOT be redistributed in ANY form
*|  without the express permission of the author. It may be modified for YOUR
*|  OWN USE ONLY so long as the original copyright is maintained. 
*|
*|  All copyright notices relating to SnippetMaster and Electric Toad Internet 
*|  Solutions, including the "powered by" wording must remain intact on the 
*|  scripts and in the HTML produced by the scripts.  These copyright notices 
*|  MUST remain visible when the pages are viewed on the Internet.
*|+----------------------------------------------------------------------------+
*|
*|  For questions, help, comments, discussion, etc., please join the
*|  SnippetMaster support forums:
*|
*|       http://www.snippetmaster.com/forums/
*|
*|  You may contact the author of SnippetMaster by e-mail at:
*|	
*|       info@snippetmaster.com
*|
*|  The latest version of SnippetMaster can be obtained from:
*|
*|       http://www.snippetmaster.com/
*|
*|	
*| Are you interested in helping out with the development of SnippetMaster?
*| I am looking for php coders with expertise in javascript and DHTML/MSHTML.
*| Send me an email if you'd like to contribute!
*|
*|
*|+--------------------------------------------------------------------------+

#+-----------------------------------------------------------------------------+
#| 		DO NOT MODIFY BELOW THIS LINE!
#+-----------------------------------------------------------------------------*/
include("../includes/config.inc.php");
include("../includes/ieeditor.inc.php"); 

// Set language to value passed in and then get translation file.
if (!isset($language)) { $language = $DEFAULT_LANGUAGE; }
if (!@include("$PATH/languages/" . $language . ".php")) { 
	$snippetmaster->returnError("Sorry, but the language you specified (<b>$language</b>) does not 		exist or the language file is invalid.<br><br>The script has been halted until this problem is fixed.  Please provide a language file called <b>$language.php</b>.  (There must be NO php syntax errors in this file.)");
}


function rendersize($size) {

	$type = 'bytes';

	if ($size > '1023') {
		$size = $size/1024;
		$type = 'KB';
	}
	if ($size > '1023') {
		$size = $size/1024;
		$type = 'MB';
	}
	if ($size > '1023') {
		$size = $size/1024;
		$type = 'GB';
	}
	if ($size > '1023') {
		$size = $size/1024;
		$type = 'TB';
	}
	// Fix decimals and stuff
	if ($size < '10') { $size = intval($size*100)/100; }
	else if ($size < '100') { $size = intval($size*10)/10; }
	else { $size = intval($size); }

	return "$size $type";
}

$max_size = rendersize($UPLOAD_FILE_MAX_SIZE);


if ($action == "do_upload") { ?>
	
<HTML><HEAD><TITLE><?php echo $text['tooltip39']; ?></TITLE></HEAD>
<STYLE TYPE="text/css">
	BODY   {margin-left:10; margin-right:10; margin-top:10; font-family:Verdana; font-size:12; background:menu; }
	BUTTON {width:75px}
	SPAN.help    {font-family:Verdana; font-size:10;}
	table {  border: #000000; border-style: solid; border-top-width: 1px; border-right-width: 1px;                border-bottom-width: 1px; border-left-width: 1px }
	td { font-family:Verdana; font-size:12 }
</STYLE>

<SCRIPT LANGUAGE=JavaScript>
<!--
		//PleaseWaitWindow.close();
// --> 
</SCRIPT>

<BODY BGCOLOR="#ffffff" TEXT="#000000">

<table border="0" cellpadding="5" cellspacing="0" align="center">
	<tr>
		<td bgcolor="#FFFFFF">

<?php
	echo $text['upload_attempt'] ." <b>$file1_name</b><p>";
	$target_name = $UPLOAD_INFO[$upload_info_number][NAME];
	$target_folder = $UPLOAD_INFO[$upload_info_number][PATH];
	$allow_overwrite = $UPLOAD_INFO[$upload_info_number][OVERWRITE];
	$size = rendersize($file1_size);

	if (!is_writeable($target_folder)) {
		echo "<font color=\"red\"><b>".$text['upload_error']."</b> - ".$text['upload_error1']."</font><p><span class=\"help\">".$text['upload_error2']."</span><br>";
		$error = true;
	}
		
	elseif (file_exists("$target_folder/$file1_name")) {
		if ($allow_overwrite == 0) {	
			echo"<font color=\"red\"><b>".$text['upload_error']."</b> - ".$text['upload_error1']."</font><p><span class=\"help\">".$text['upload_error3']."</span><br>";
			$error = true;
		} else {
			echo "<span class=\"help\">".$text['upload_error4']."</span><br>";
		}
	}
		
	elseif (($UPLOAD_FILE_SIZE_LIMIT == 1) && ($file1_size > $UPLOAD_FILE_MAX_SIZE)) {
		echo "<font color=\"red\"><b>".$text['upload_error']."</b> - ".$text['upload_error1']."</font><p><span class=\"help\">".$text['upload_error5']."<br>".$text['upload_file_size'].": ".$size."<br>".$text['upload_file_size_max'].": ".$max_size."</span><br>";
		$error = true;
	}

	if ($error == false) {
		if (!@move_uploaded_file($file1, "$target_folder/$file1_name")) {
			echo "<font color=\"red\"><b>".$text['upload_error']."</b> - ".$text['upload_error1']."</font><p><span class=\"help\">".$text['upload_error6']."</span><br>";
		} else {
			echo "<font color=\"green\"><b>".$text['upload_success']."</b> - ".$text['upload_success_msg']."</font><p><span class=\"help\">".$text['upload_file_size'].": ".$size."<br>".$text['upload_to'].": ".$target_name."</span><br>";
		}
	}
?> 
		</td>
	</tr>
</table>
<br>
<center>
	<BUTTON ID=Back onClick="history.back();"><?php echo $text['back_button']; ?></BUTTON>
	<BUTTON onClick="window.close();"><?php echo $text['close_button']; ?></BUTTON>
</center>

</BODY></HTML>

<?php

}

else {

?>

<HTML>
<HEAD>
<TITLE><?php echo $text['tooltip39']; ?></TITLE>
<STYLE TYPE="text/css">
	BODY   {margin-left:10; margin-right:10; margin-top:5; font-family:Verdana; font-size:12; background:menu; }
	BUTTON {width:75px}
	TABLE  {font-family:Verdana; font-size:12}
	P      {text-align:center}
	SPAN.help    {font-family:Verdana; font-size:9;}
	SELECT    {font-family:Verdana; font-size:10;}
</STYLE>

<SCRIPT LANGUAGE=JavaScript>
<!--
function submitForm(form) {

<?php 
	echo 'var valid_extensions = new Array();';

	if ($LIMIT_UPLOAD_FILE_TYPES == 1) {
		echo 'valid_extensions["extension_check"] = "yes";';
		$i = 1;
		foreach($VALID_UPLOAD_FILE_TYPES as $filetype) {
			echo 'valid_extensions["'.$i.'"] = "'.$filetype.'";';
			$i++;
		}
	}
	else { echo 'valid_extensions["extension_check"] = "no";'; }
?>

	//Error checking.
	
	var error_found = false;

	if (form.upload_info_number.value == "") {
		alert("<?php echo $text['upload_error8']; ?>  <?php echo $text['upload_error7']; ?>");
		error_found = true;
		//focus = document.frmUpload.upload_info_number;
	} 

	else if (form.file1.value == "") {
		alert("<?php echo $text['upload_error9']; ?>  <?php echo $text['upload_error7']; ?>"); 
		error_found = true;
	}

	else if (valid_extensions["extension_check"] == "yes") {
		var extension = form.file1.value.split(".").pop();	// Get extension of the file.
		var extension_ok = false;	// Initialize variable.

		for (var i = 1; i < valid_extensions.length; i++){	// For each acceptable extension in the array.
			if ( extension == valid_extensions[i] ) {	// Was an accepted ext found?
				extension_ok = true;
			}
		}		

		if (extension_ok == false) {
			alert("<?php echo $text['upload_error10']; ?>: " + extension);
			error_found = true;
		}
	}	

	if ( error_found == false ) {

		form.submit.value = "<?php echo $text['upload_wait']; ?>";
		return true;
	} 
	else { 

		return false; 
	}
}

// --> 
</SCRIPT>
</HEAD>
<BODY>
<FORM NAME="frmUpload" method="post" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data" onSubmit="return submitForm(this);">

<table cellspacing=10>
	<tr>
		<td valign="middle" align="left"><b><?php echo $text['upload_dest']; ?>: </b><br><span class="help"><?php echo $text['upload_dest_help']; ?></span><br>
			<select name=upload_info_number>
			<option value=""></option>
<?php 
$i = 1;
foreach($UPLOAD_INFO as $number) {
	echo '<option value="'.$i.'">'.$number[NAME].'</option>';
	$i++;
}
?>
			</select>
		</td>
	</tr>
</table>
<TABLE CELLSPACING=10>
	<TR>
		<TD VALIGN="top" align="left"><b><?php echo $text['upload_file']; ?>: </b><span class="help"><?php echo $text['upload_file_help']; ?> <?php if ($UPLOAD_FILE_SIZE_LIMIT == 1) { echo $text['upload_file_size_max'].": ".$max_size; } ?> </span><br>
			<input type="file" name="file1" size="30"><br>
		</TD>
	</TR>
	<TR>
		<TD VALIGN="top" align="center">
			<input type="submit" name="submit" value="<?php echo $text['submit_button']; ?>">
			<BUTTON onClick="window.close();"><?php echo $text['cancel_button']; ?></BUTTON>
			<input type="hidden" name="action" value="do_upload">
		</TD>
	</TR>
</TABLE>
</FORM>
</BODY>
</HTML>

<?php 
}
?>
	
