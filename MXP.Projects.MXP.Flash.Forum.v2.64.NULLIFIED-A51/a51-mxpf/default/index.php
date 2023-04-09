<?
/**********************************************************************
**              Copyright Info - http://www.mxprojects.com            **
**   No code or graphics can be re-sold or distributed under any     **
**   circumstances. By not complying you are breaking the copyright  **
**   of MX Projects which you agreed to upon purchase.     			 **
**                                          						 **
**   Special thanks to Steve Webster and http://www.phpforflash.com  **
**********************************************************************/
//set up direct linking from the e-mail
include('../db.php');
if (isset($f) && isset($t)){
//pull information from the cookies
$varLine = "dirLink=1&forumID=$f&threadID=$t";
}
?>
<HTML>
<HEAD>
<meta http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<TITLE><? echo $boardTitle; ?></TITLE>
<script>
function uploadAvatar() {
        var win = window.open("../upload.php", "AvatarUpload", "marginHeight=0,marginWidth=0,scrollbars=no,height=250,width=450");
        win.focus();
    }
	function uploadImage(randInt) {
        var win = window.open("../imageupload.php?randInt=" + randInt, "ImageUpload", "marginHeight=0,marginWidth=0,scrollbars=no,height=250,width=450");
        win.focus();
    }
</script>


</HEAD>
<BODY bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" scrollbars="no">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center">
        <object onmousewheel="this.SetVariable('_global.mousewheelObj.intWheelDelta',event.wheelDelta);" id="classMouseWheel" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="955" height="600" align="CENTER">
          <param name="movie" value="forum.swf?<? echo $varLine; ?>">
          <param name="quality" value="high">
          <param name="menu" value="false">
          <param name="wmode" value="Opaque">
		  <script>
		  document.write('<embed flashvars="__yamzbrowser='+window.navigator.appName+'"');
		  </script>
		  src="forum.swf?<? echo $varLine; ?>"
		  wmode="Opaque"
		  quality=high
		  pluginspage="http://www.macromedia.com/go/getflashplayer" 
		  type="application/x-shockwave-flash" 
		  width="955"
		  height="600"
		  loop=false
		  name="classMouseWheel"
		  menu=false></embed></object>
      </div>
	  </td>
</tr>
</table>
</BODY>
</HTML>