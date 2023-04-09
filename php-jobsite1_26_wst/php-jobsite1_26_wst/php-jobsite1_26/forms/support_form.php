<?php include(DIR_LANGUAGES.$language."/".FILENAME_SUPPORT_FORM);?>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
<TR bgcolor="<?php echo TABLE_BGCOLOR;?>">
		<TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_SUPPORT;?></TD>
</TR>
<TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
			</tr>
		</table></TD>
</TR>
</table>
<?php
if ($HTTP_SESSION_VARS['employerid']) {
	$query=bx_db_query("select company,email from ".$bx_table_prefix."_companies where compid='".$HTTP_SESSION_VARS['employerid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1)); 
	$result = bx_db_fetch_array($query);
	$name = $result['company'];
	$email = $result['email'];
	$support_need = "Employer";
}
else if ($HTTP_SESSION_VARS['userid']) {
	$query=bx_db_query("select name,email from ".$bx_table_prefix."_persons where persid='".$HTTP_SESSION_VARS['userid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1)); 
	$result = bx_db_fetch_array($query);
	$name = $result['name'];
	$email = $result['email'];
	$support_need = "Job seeker";
}
else {
	$name = $HTTP_POST_VARS['sname'];
	$email = $HTTP_POST_VARS['email'];
}
?>
<form action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_SUPPORT, "auth_sess", $bx_session);?>" method="post">
<input type="hidden" name="todo" value="support">
<input type="hidden" name="support_need" value="<?php echo $support_need;?>">
<table cellspacing="0" cellpadding="3" border="0" align="center">
<tr><td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_NAME;?>:</b></font></td><td><input type="text" size="25" name="sname" value="<?php echo $name;?>"></td></tr>
<?php
	if ($name_error=="yes") {
		echo "<tr><td colspan=\"2\" align=\"center\" class=\"error\">".NAME_ERROR."</td></tr>";
	}
?>
<tr><td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_EMAIL_ADDRESS;?>:</b></font></td><td><input type="text" size="25" name="email" value="<?php echo $email;?>"></td></tr>
<?php
	if ($email_error=="yes") {
		echo "<tr><td colspan=\"2\" align=\"center\" class=\"error\">".EMAIL_ERROR."</td></tr>";
	}
?>
<tr><td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SUBJECT;?>:</b></font></td><td><input type="text" size="35" name="subject" value="<?php echo $HTTP_POST_VARS['subject'];?>"></td></tr>
<?php
	if ($subject_error=="yes") {
		echo "<tr><td colspan=\"2\" align=\"center\" class=\"error\">".SUBJECT_ERROR."</td></tr>";
	}
?>
<tr><td align="right" valign="top"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_MESSAGE;?>:</b></font></td><td><textarea name="message" rows="4" cols="30"><?php echo $HTTP_POST_VARS['message'];?></textarea></td></tr>
<?php
	if ($message_error=="yes") {
		echo "<tr><td colspan=\"2\" align=\"center\" class=\"error\">".MESSAGE_ERROR."</td></tr>";
	}
?>
<tr><td align="center" colspan="2"><input type="submit" name="send" value="<?php echo TEXT_SEND_MESSAGE;?>" style="width: 100"></td></tr>
</table>
</form>