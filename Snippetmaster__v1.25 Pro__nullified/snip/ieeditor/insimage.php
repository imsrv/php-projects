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

?>
<HTML>
<HEAD>
<TITLE><?php echo $text['tooltip23']; ?></TITLE>
<STYLE TYPE="text/css">
 BODY   {margin-left:10; font-family:Verdana; font-size:10pt; background:menu}
 BUTTON {width:80px}
 TABLE  {font-family:Verdana; font-size:10pt;}
 P      {text-align:center}
 SELECT    {font-family:Verdana; font-size:10;}

</STYLE>
<SCRIPT LANGUAGE=JavaScript>
<!--
var imgCaptions = new Array();
var imgHeights = new Array();
var imgWidths = new Array();
imgCaptions[0] = "";
imgHeights[0] = "0";
imgWidths[0] = "0";

function IsDigit()
{
  return ((event.keyCode >= 48) && (event.keyCode <= 57));
}
function showPreview()
{
if (document.frmImagePick.ImgSrc.value != "") {
 document.PREVIEWPIC.src=document.frmImagePick.ImgSrc.value ;
 document.frmImagePick.ImgHeight.value = document.PREVIEWPIC.height;
 document.frmImagePick.ImgWidth.value = document.PREVIEWPIC.width;
 }
else
  document.PREVIEWPIC.src='images/imgpreview.gif';
}
// -->
</SCRIPT>
<SCRIPT LANGUAGE=JavaScript FOR=PREVIEWPIC EVENT=onreadystatechange>
<!--
if(readyState == "complete"){
	PREVIEWPIC.style.visibility = "visible";
	if(document.readyState == "complete"){
	 document.frmImagePick.ImgHeight.value = document.PREVIEWPIC.height;
	 document.frmImagePick.ImgWidth.value = document.PREVIEWPIC.width;
	}
}
//-->
</SCRIPT>
<SCRIPT LANGUAGE=JavaScript FOR=window EVENT=onload>
<!--
  for ( elem in window.dialogArguments )
  {
    switch( elem )
    {
    case "ImgSrc":
      document.frmImagePick.ImgSrc.value=window.dialogArguments["ImgSrc"];
      showPreview();
      break;
    case "AltText":
      document.frmImagePick.AltText.value = window.dialogArguments["AltText"];
      break;
      
    // ----- added ImgLink field - SCOTT  8/30/02 -------------
    case "ImgLink":
      document.frmImagePick.ImgLink.value = window.dialogArguments["ImgLink"];
      break;
    // --------------------------------------------------------
   
   // ----- added ImgLink_Tarket field - HENRI  09/07/02 -------------
    case "ImgLink_Target":
      //document.frmImagePick.ImgLink_Target.value = window.dialogArguments["ImgLink_Target"];
 		if (window.dialogArguments["LinkTarget"] == "") { // If no value is passed in, set a default.
				document.frmImagePick.ImgLink_Target.value = "";	//"_self";
			} else {
				document.frmImagePick.ImgLink_Target.value = window.dialogArguments["ImgLink_Target"];
			}
		break;
    // --------------------------------------------------------

    case "ImgBorder":
      document.frmImagePick.ImgBorder.value = window.dialogArguments["ImgBorder"];
      break;
    case "HorSpace":
      document.frmImagePick.HorSpace.value = window.dialogArguments["HorSpace"];
      break;
    case "VerSpace":
      document.frmImagePick.VerSpace.value = window.dialogArguments["VerSpace"];
      break;
    case "ImgHeight":
      document.frmImagePick.ImgHeight.value = window.dialogArguments["ImgHeight"];
      break;
    case "ImgWidth":
      document.frmImagePick.ImgWidth.value = window.dialogArguments["ImgWidth"];
      break;
    case "ImgAlign":
      for(i=1;i<(document.frmImagePick.ImgAlign.length-1);i++)
        if(document.frmImagePick.ImgAlign[i].value==window.dialogArguments["ImgAlign"])
          document.frmImagePick.ImgAlign.selectedIndex = i;
      break;
    }
  }
// -->
</SCRIPT>

<SCRIPT LANGUAGE=JavaScript FOR=Ok EVENT=onclick>
<!--
  var arr = new Array();
  if (document.PREVIEWPIC.src=='images/imgpreview.gif'){
    alert('You did not select a valid image. Page not updated.');
    arr=null;
  } else {
  arr["AltText"] = document.frmImagePick.AltText.value;
  arr["HorSpace"] = document.frmImagePick.HorSpace.value;
  arr["VerSpace"] = document.frmImagePick.VerSpace.value;
  arr["ImgSrc"] = document.frmImagePick.ImgSrc.value;
  
  // ------ added link element - SCOTT 8/30/02 -------
  arr["ImgLink"] = document.frmImagePick.ImgLink.value;
  // -------------------------------------------------

  // ------ added link target element - HENRI 09/07/02 -------
	// if no target was selected, we'll automatically assign it as "_self"
	if (document.frmImagePick.ImgLink_Target.value == "") {
		arr["ImgLink_Target"] = "_self";
	} else {
		arr["ImgLink_Target"] = document.frmImagePick.ImgLink_Target[document.frmImagePick.ImgLink_Target.selectedIndex].value;
	}
  // -------------------------------------------------

  arr["ImgBorder"] = document.frmImagePick.ImgBorder.value;
  arr["ImgHeight"] = document.frmImagePick.ImgHeight.value;
  arr["ImgWidth"] = document.frmImagePick.ImgWidth.value;
  arr["ImgAlign"] = document.frmImagePick.ImgAlign[document.frmImagePick.ImgAlign.selectedIndex].value;
  }
  window.returnValue = arr;
  window.close();
// -->
</SCRIPT>

</HEAD>

<BODY>
<FORM NAME="frmImagePick" method="post" action="">
<TABLE CELLSPACING=2 border="0">
<TR>
<TD VALIGN="top" align="left" nowrap><b><?php echo $text['image_browse']; ?>: </b><br>
<iframe name="IMGPICK" src="browseimage.php?language=<?php echo $language; ?>&dir=<?php echo urlencode($BASEURL);?>" style="border: solid black 1px; width: 220px; height:240px; z-index:1"></iframe>
</TD>
<TD VALIGN="top" align="center" nowrap>
<p>
<br>
<span style="background-color:gray;overflow:auto;width:200px;height:200px;border-width:1px;
border-style:solid;border-color:threeddarkshadow white white threeddarkshadow;">
<IMG ID="PREVIEWPIC" NAME="PREVIEWPIC" bgcolor="#ffffff" src="images/imgpreview.gif" alt="<?php echo $text['image_preview']; ?>" align="absmiddle" valign="middle"></span>
</p>
<p>
<BUTTON ID=Ok><?php echo $text['submit_button']; ?></BUTTON>
&nbsp;
<BUTTON ONCLICK="window.close();"><?php echo $text['cancel_button']; ?></BUTTON>
</p>
</TD></TR>
<TR>
<TD VALIGN="top" align="left" colspan="2" nowrap><b><?php echo $text['image_source']; ?>:</b><br>
<INPUT TYPE=TEXT SIZE=40 NAME=ImgSrc style="width : 300px;" value=""  onChange="showPreview()">
<br>

<?php echo $text['image_alt_text']; ?>:<br>
<INPUT TYPE=TEXT SIZE=40 NAME=AltText style="width : 300px;">
<br>

<!-----  Image Link input field added SCOTT  8/30/02  -------->
<?php echo $text['image_link_url']; ?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br><INPUT TYPE=TEXT SIZE=25 NAME=ImgLink style="width : 250px;" value="">
<!---------------------------------------------------------->
<!-----  Image Link Target selection field added HENRI 09/07/02  -------->
<br><?php echo $text['image_target']; ?>:<br>
<SELECT NAME="ImgLink_Target">
<option value="_self"><?php echo $text['target_self']; ?> (_self)</option>
<option value="_top"><?php echo $text['target_top']; ?> (_top)</option>
<option value="_blank"><?php echo $text['target_blank']; ?> (_blank)</option>
</SELECT>
<!---------------------------------------------------------->

</TD>
</TR>
<TR>
<TD VALIGN="top" align="left" colspan="2">
<table border=0 cellpadding=2 cellspacing=2>
<tr>
<td nowrap>
<fieldset style="padding : 2px;"><legend> <?php echo $text['image_layout']; ?> </legend>
<table border=0 cellpadding=2 cellspacing=2>
<tr>
<td><?php echo $text['img_alignment']; ?>:</td>
<td><select NAME=ImgAlign style="width : 80px;">
<option value=""></option>
<option value="left"><?php echo $text['alignment_option_left']; ?></option>
<option value="right"><?php echo $text['alignment_option_right']; ?></option>
<option value="top"><?php echo $text['alignment_option_top']; ?></option>
<option value="middle"><?php echo $text['alignment_option_middle']; ?></option>
<option value="bottom"><?php echo $text['alignment_option_bottom']; ?></option>
</select>
</td>
</tr>
<tr>
<td nowrap><?php echo $text['image_border']; ?>:</td>
<td><INPUT TYPE=TEXT SIZE=2 value="0" NAME=ImgBorder  ONKEYPRESS="event.returnValue=IsDigit();" style="width : 80px;"></td>
</tr>
</table>
</fieldset>
</td>
<td nowrap>
<fieldset style="padding : 5px;"><legend> <?php echo $text['image_spacing']; ?> </legend>
<table border=0 cellpadding=2 cellspacing=1>
<tr>
<td><?php echo $text['image_horizontal']; ?>:</td>
<td><INPUT TYPE=TEXT SIZE=2 value="0" NAME=HorSpace  ONKEYPRESS="event.returnValue=IsDigit();" style="width : 80px;"> </td>
</tr>
<tr>
<td><?php echo $text['image_vertical']; ?>:</td>
<td><INPUT TYPE=TEXT SIZE=2 value="0" NAME=VerSpace  ONKEYPRESS="event.returnValue=IsDigit();" style="width : 80px;"></td>
</tr>
</table>
</fieldset>
</td>
</tr>
</table>
</TD>
 </TR>
</TABLE>
<INPUT TYPE=HIDDEN SIZE=5 value="0" NAME=ImgHeight>
<INPUT TYPE=HIDDEN SIZE=5 value="0" NAME=ImgWidth>
</FORM>
</BODY>
</HTML>
