<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template comments_post_form -->

<form name="comments" action="comments.php" method="post">

<script language="JavaScript">
<!--
function AutoInsert(tag) {
   document.comments.message.value =
   document.comments.message.value + tag;
}
//-->
</script>

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table border="0" cellspacing="1" cellpadding="3" width="100%">
		<tr>
			<td bgcolor="#008000" colspan="2">
			<font face="Arial" color="#ffffff" size="2">
				<b>Post New Comment</b>
			</font>
			</td>
		</tr>
		<td bgcolor="#ffffff" colspan="2">
			<font face="Arial" size="2">
				<b><u>Note:</u></b> This site does not allow anonymous comments. Registered members can login <a href="login.php">here</a> to participate.
			</font>
			</td>
		</tr>		
		<tr>
			<td nowrap bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Icon:</b>
			</font>
		</td>
			<td bgcolor="#ffffff">
			<table border="0" cellspacing="1" cellpadding="0">
				<tr>
					<td><input type="radio" name="icon" value="1" checked />
					<img src="images/icons/icon_note.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="2" />
					<img src="images/icons/icon_alert.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="3" />
					<img src="images/icons/icon_question.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="4" />
					<img src="images/icons/icon_star.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="5" />
					<img src="images/icons/icon_idea.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="6" />
					<img src="images/icons/icon_disk.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="7" />
					<img src="images/icons/icon_smile.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="8" />
					<img src="images/icons/icon_wink.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="9" />
					<img src="images/icons/icon_sad.png" />&nbsp; </td>
				</tr>
				<tr>					
					<td><input type="radio" name="icon" value="10" />
					<img src="images/icons/icon_mad.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="11" />
					<img src="images/icons/icon_happy.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="12" />
					<img src="images/icons/icon_tongue.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="13" />
					<img src="images/icons/icon_sleep.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="14" />
					<img src="images/icons/icon_cool.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="15" />
					<img src="images/icons/icon_ssad.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="16" />
					<img src="images/icons/icon_frown.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="17" />
					<img src="images/icons/icon_up.png" />&nbsp; </td>
					<td><input type="radio" name="icon" value="18" />
					<img src="images/icons/icon_down.png" />&nbsp; </td>
				</tr>
				<tr>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td nowrap valign="top" bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Quick Code:</b>
			</font>
			</td>
			<td bgcolor="#ffffff">
			<a href="javascript:AutoInsert('[b]bold text[/b]')"><img src="images/icons/button_bold.png" border="0"></a>
			<a href="javascript:AutoInsert('[i]italic text[/i]')"><img src="images/icons/button_italic.png" border="0"></a>
			<a href="javascript:AutoInsert('[u]underlined text[/b]')"><img src="images/icons/button_underline.png" border="0"></a>
			<a href="javascript:AutoInsert('[sup]sup text[/sup]')"><img src="images/icons/button_sup.png" border="0"></a>
			<a href="javascript:AutoInsert('[sub]sub text[/sub]')"><img src="images/icons/button_sub.png" border="0"></a>
			<a href="javascript:AutoInsert('[tt]tt text[/tt]')"><img src="images/icons/button_tt.png" border="0"></a>
			<a href="javascript:AutoInsert('[s]s text[/s]')"><img src="images/icons/button_s.png" border="0"></a>
			<a href="javascript:AutoInsert('[marquee]marquee text[/marquee]')"><img src="images/icons/button_marquee.png" border="0"></a>
			<a href="javascript:AutoInsert('[center]center text[/center]')"><img src="images/icons/button_center.png" border="0"></a>
			<a href="javascript:AutoInsert('[left]left text[/left]')"><img src="images/icons/button_left.png" border="0"></a>
			<a href="javascript:AutoInsert(' :) ')"><img src="images/icons/button_smilie_smile.png" border="0"></a>
			<a href="javascript:AutoInsert(' ;) ')"><img src="images/icons/button_smilie_wink.png" border="0"></a>
			<a href="javascript:AutoInsert(' :( ')"><img src="images/icons/button_smilie_sad.png" border="0"></a>
			<a href="javascript:AutoInsert(' :x ')"><img src="images/icons/button_smilie_ssad.png" border="0"></a>
			<a href="javascript:AutoInsert(' ;( ')"><img src="images/icons/button_smilie_mad.png" border="0"></a><br />
			<a href="javascript:AutoInsert('[right]right text[/right]')"><img src="images/icons/button_right.png" border="0"></a>
			<a href="javascript:AutoInsert('[font=arial]Using arial font[/font]')"><img src="images/icons/button_font.png" border="0"></a>
			<a href="javascript:AutoInsert('[size=10]Using font size 10[/size]')"><img src="images/icons/button_size.png" border="0"></a>
			<a href="javascript:AutoInsert('[color=red]Using the color red[/color]')"><img src="images/icons/button_color.png" border="0"></a>
			<a href="javascript:AutoInsert('[quote]quoted text[/quote]')"><img src="images/icons/button_quote.png" border="0"></a>
			<a href="javascript:AutoInsert('[url]http://www. .com[/url]')"><img src="images/icons/button_url.png" border="0"></a>
			<a href="javascript:AutoInsert('[url=http://www. .com]My Homepage[/url]')"><img src="images/icons/button_urllink.png" border="0"></a>
			<a href="javascript:AutoInsert('[email]myemail@provider[/email]')"><img src="images/icons/button_email.png" border="0"></a>
			<a href="javascript:AutoInsert('[email=email@provider]My Email[/email]')"><img src="images/icons/button_emaillink.png" border="0"></a>
			<a href="javascript:AutoInsert('[img]http://url_to_images/picture[/img]')"><img src="images/icons/button_images.png" border="0"></a>
			<a href="javascript:AutoInsert(' :o ')"><img src="images/icons/button_smilie_frown.png" border="0"></a>
			<a href="javascript:AutoInsert(' :p ')"><img src="images/icons/button_smilie_tongue.png" border="0"></a>
			<a href="javascript:AutoInsert(' 8) ')"><img src="images/icons/button_smilie_cool.png" border="0"></a>
			<a href="javascript:AutoInsert(' x) ')"><img src="images/icons/button_smilie_sleep.png" border="0"></a>
			<a href="javascript:AutoInsert(' :D ')"><img src="images/icons/button_smilie_happy.png" border="0"></a>						
			</td>
		</tr>
		<tr>
			<td nowrap valign="top" bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Message:</b>
			</font>
			</td>
			<td bgcolor="#ffffff">
			<textarea cols="65" name="message" rows="20" wrap="virtual">$insert[comments_quote]</textarea><br />
			<input name="signature" type="checkbox" value="1" />
			<font face="Arial" size="2">
				Include my profile signature.
			</font>
			<br />
			<input name="smilies" type="checkbox" value="1" />
			<font face="Arial" size="2">
				Disable smilies in this post.
			</font>
			<br />
			<input name="bcode" type="checkbox" value="1" />
			<font face="Arial" size="2">
				Disable block tag code.
			</font>
			<input type="hidden" name="category" value="$insert[comments_category]">
			<input type="hidden" name="story" value="$insert[comments_story]">	
			</td>
		</tr>
	</table>
	</td>
	</tr>
<br />
</table>
<center>
	<input type="submit" value="Post New Comment" />
</center>
</form>
<br />

TEMPLATE;
?>