<?php
include ("config.php");

?>
<HTML>
<HEAD>
<link REL='StyleSheet' TYPE='text/css' HREF='style.css'>
</HEAD>
<BODY  onLoad='top.load_main=1'>
<BR>
<?php
		if( $use_banners )
		{
			?>
			<IFRAME FRAMEBORDER=0 SCROLLING="NO" WIDTH=100% HEIGHT=60 SRC="banner_script.php">
			</IFRAME>
			<BR/>
			<HR color="#ACA899" SIZE=1/>
			<?php
		}
		?>
<?php
echo "<center>";
echo $title_chat;
echo "</center>";

if( !$use_banners )
{
$fr1="position:absolute;width:511px;height:512px;top:40px;left:0px;border-style:solid;border-width:1px;border-color:#ACA899;background-Color:#FFFFFF";
$fr2="position:absolute;width:509px;height:510px;top:0px;left:0px;background-Color:#FBF9F9;clip:rect(0 509 510 0)";
$fr3="position:absolute;width:509px;height:510px;top:555px;left:0px";
}
else
{
$fr1="position:absolute;width:511px;height:432px;top:110px;left:0px;border-style:solid;border-width:1px;border-color:#ACA899;background-Color:#FFFFFF";
$fr2="position:absolute;width:509px;height:430px;top:0px;left:0px;background-Color:#FBF9F9;clip:rect(0 509 430 0)";
$fr3="position:absolute;width:509px;height:510px;top:555px;left:0px";
}
?>
<DIV style="<?php print($fr1); ?>">
   <DIV style="<?php print($fr2); ?>">
      <DIV id="layermsg" style="position:absolute;top:0px;left:0px;" >
         <?php print $connecting_message; ?>
      </DIV>
   </DIV>
</DIV>
<DIV id="layerform" style="<?php print($fr3); ?>">
<SCRIPT language=javascript>
function ChangeStyle(f) {
   f.msg.style.color=f.color.options[f.color.selectedIndex].value;
   f.msg.focus();
}
function AddText(text) {
   f=document.forms[0];
   f.msg.value=f.msg.value+text;
   f.msg.focus();
}
</SCRIPT>
<FORM name=post onSubmit="top.SendMsg(this); return false;">
    <?php print $text_your_msg; ?>&nbsp; &nbsp; <INPUT type=text name=msg size=40 maxlength=<? print $chat_msg_max_size; ?> style="width:358 px;background-Color:#EBE7E7">
   <?php

       print ("<br>$pick_a_color_message");
       print("  <SELECT name=color style='background-Color:#FBF9F9;color:".$option["chat_color1"]."' onChange='ChangeStyle(this.form)'>");

      for ($i=1;$i<=$option["chat_colors"];$i++) {
         print("<OPTION style='color:".$option["chat_color".$i]."' value='".$option["chat_color".$i]."'>".$option["chat_color".$i]."</OPTION>");
      }
      print("  </SELECT> ");
      for ($i=1;$i<=$option["chat_smilies"];$i++) {
         print("<A href='javascript:AddText(\" ".$option["chat_smiley".$i]." \")'>".$option["chat_smiley_gif".$i]."</A> &nbsp;");
      }
      echo " <br><br>$gestures_message    &nbsp;";
      for ($i=1;$i<=$option["chat_gesture"];$i++) {
         print("<A href='javascript:AddText(\" ".$option["chat_gesture".$i]." \")'>".$option["chat_gesture".$i]."</A> &nbsp;");
      }

   ?>
</FORM>
</DIV>
</BODY></HTML>