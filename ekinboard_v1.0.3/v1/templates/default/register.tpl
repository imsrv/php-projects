<table width=100% height=50><tr><td valign=middle>
<a href="index.php"><{page_title}> Home</a> - Registration
</td></tr></table>

						<{loop_news}>
							<table width="100%" cellpadding="0" cellspacing="0" border="0" class="bluetable">
								<tr>
									<td>
										<b>Latest news:</b> <i><a href="viewtopic.php?id=<{news_id}>" class="link2"><{news_title}></a></i>
									</td>
								</tr>
							</table>
							<table width="100%" height="10">
								<tr>
									<td>
									</td>
								</tr>
							</table>
						<{/loop_news}>
<{loop_terms}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
	<tr class=table_1_header><td colspan=4>
	<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Registration Terms & Rules</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
	</table></td></tr>
	<tr class=table_subheader><td align=left class=table_subheader>In order to proceed, you must agree to the following:</td></tr>
	<tr><td class=contentmain>
									<script language="javascript">
									function desableButton(){
										document.Form.submit.disabled=true;
									}
									</script>
	<form action="register.php" method="get" name="Form" onSubmit="desableButton()">
<table width=100%><tr><td colspan=2>
<b>Forum Terms & Rules</b>
<p>
<{registration_terms}>
</td></tr><tr><td>
	<input type="checkbox" id="agree_cbox" name="accept" value="1" class="none" /></td><td width=100%><label for="agree_cbox"><b>I have read, understood and agree to these rules and conditions</b></label>
</td></tr><tr><td colspan=2>
</td></tr></table>
	</td></tr>
	<tr><td class=table_bottom align=center><input type="submit" value="Continue > >" class="button" name="submit"></td></tr>
	</table>
	<table width=100% height=10><tr><td></td></tr></table>
	</form>
<{/loop_terms}>
<{loop_register}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
	<tr class=table_1_header><td colspan=4>
	<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Registration Form</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
	</table></td></tr>
	<tr class=table_subheader><td align=left class=table_subheader>Please ensure that you complete all the fields fully, taking particular care over the password fields.</td></tr>
	<tr><td class=contentmain align=center>
	<table width=95%><tr><td width=50%>
									<script language="javascript">
									function desableButton(){
										document.Form.submit.disabled=true;
									}
									</script>
	<form action="register.php" method="get" name="Form" onSubmit="desableButton()">
	<fieldset class="row3">
	<legend><b>Username:</b></legend>
	<table cellspacing="0" class="legend_<{username_error}>" cellpadding="4" width=100%>
	<tr><td>
	<span class="error"><{username_error_message}></span>
	</td></tr>
	<tr><td>Enter your Username &nbsp;<span>(<a href="#" style="cursor: help; color: #555;" title="Usernames must be between 3 and 32 characters long">?</a>)</span></td>
	</tr><tr>
	<td><input type="text" size="50" maxlength="64" value="<{submitted_username}>" name="username" /></td>
	</tr></table>
	</fieldset><br>
					
	<fieldset class="row3">
	<legend><b>Password:</b></legend>
	<table cellspacing="0" class="legend_<{password_error}>" cellpadding="4" width=100%>
	<tr><td colspan=2>
	<span class="error"><{password_error_message}></span>
	</td></tr>
	<tr><td width="1%" nowrap="nowrap">Enter your password &nbsp;<span>(<a href="#" style="cursor: help; color: #555;" title="Passwords must be between 3 and 32 characters long">?</a>)</span></td>
	<td width="100%">Confirm Password &nbsp;<span>(<a href="#" style="cursor: help; color: #555;" title="Please re-enter your password: It must match exactly">?</a>)</span></td>
	</tr><tr>
	<td><input type="password" size="25" maxlength="32" value="<{submitted_password}>" name="password" /></td>
	<td><input type="password" size="25" maxlength="32" value="<{submitted_password_confirm}>"  name="confirm" /></td>
	</tr></table>
	</fieldset><br>

	<fieldset class="row3">
	<legend><b>Email Address:</b></legend>
	<table cellspacing="0" class="legend_<{email_error}>" cellpadding="4" width=100%>
	<tr><td colspan=2>
	<span class="error"><{email_error_message}></span>
	</td></tr>
	<tr><td width="1%" nowrap="nowrap">Enter your Email Address &nbsp;<span>(<a href="#" style="cursor: help; color: #555;" title="Make sure you enter a valid email address">?</a>)</span></td>
	<td width="100%">Confirm Email Address &nbsp;<span>(<a href="#" style="cursor: help; color: #555;" title="Please re-enter your email address: It must match exactly">?</a>)</span></td>
	</tr><tr>
	<td><input type="text" size="25" maxlength="50" value="<{submitted_email}>"  name="email" /></td>
	<td><input type="text" size="25" maxlength="50"  value="<{submitted_email_confirm}>" name="email_confirm" /></td>
	</tr></table>
	</fieldset>

</td><td width=50% valign=top>
<b>Optional Information</b><p>
	<fieldset class="row3">
	<legend>Contact</legend>
	<table cellspacing="0">
	<tr><td>
	Now and again, the administrators and other members might wish to contact you via email through this board.
	</tr><tr><td>

	</td></tr></table>
	</fieldset><br>
</td></tr></table>
	</td></tr>
	<tr>
	<input type="hidden" value="1" name="accept" />
	<td class=table_bottom align=center><input type="submit" value="Submit > >" class="button" name="submit"></td></tr>
	</table>
	<table width=100% height=10><tr><td></td></tr></table>
</form>
<{/loop_register}>
<{loop_registered}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
	<tr class=table_1_header><td colspan=4>
	<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Thank You!</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
	</table></td></tr>
	<tr class=table_subheader><td align=left class=table_subheader><{registered_notice}></td></tr>
	<tr><td class="contentmain">
	<{registered_notice_message}>
	<table width=100% height=10><tr><td></td></tr></table>
	</td></tr>
	</table>
	<table width=100% height=10><tr><td></td></tr></table>
<{/loop_registered}>
<{loop_activate}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
	<tr class=table_1_header><td colspan=4>
	<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Activation</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
	</table></td></tr>
	<tr class=table_subheader><td align=left class=table_subheader>Activating your account</td></tr>
	<tr><td class="contentmain" align="center">
	<table width="100%" cellpadding="0" class="legend_<{activation_notice}>"><tr><td>
	<{activation_notice_message}></td></tr></table>
	</td></tr>
	</table>
	<table width=100% height=10><tr><td></td></tr></table>
<{/loop_activate}>
<{loop_already_member}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
	<tr class=table_1_header><td colspan=4>
	<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Error</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
	</table></td></tr><tr class=table_subheader><td align=left class=table_subheader>Could not complete your request</td></tr><tr><td class=contentmain align=center>
	<table width="95%" cellpadding="0" cellspacing="0" border="0" class="redtable"><tr><td class="redtable_header">
	<b>Notice!</b></td></tr><tr><td class="redtable_content">
	You are already logged in!
	</td></tr></table>
	</td></tr></table>
	<table width=100% height=10><tr><td></td></tr></table>
<{/loop_already_member}>
		<table width=100% cellspacing=0 cellpadding=0 class=category_table>
		<tr class=table_1_header><td colspan=4>
		<table width=100% cellpadding=0 cellspacing=0 border=0>
		<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Board Statistics</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
		</table></td></tr>
		<tr class=table_subheader><td align=left class=table_subheader>Online Users</td></tr>
		<tr><td class=contentmain>
		<table width=100% ><tr><td width=45><img src="templates/<{template}>/images/online_icon.gif"></td><td>
		<b><{total_active_users}></b> user(s) active in the past 15 minutes<br>
		<b><{total_active_guests}></b> guest(s), <b><{total_active_members}></b> member(s)<p>
		<{loop_user_online}>
			<a href="profile.php?id=<{online_id}>"><{online_user}></a><img src="templates/<{template}>/images/EKINboard_icon_<{online_level}>.gif"><{spacer}>&nbsp;
		<{/loop_user_online}>
		</td></tr></table>
		</td></tr>
		<tr class=table_subheader><td align=left class=table_subheader>General Statistics</td></tr>
		<tr><td class=contentmain>
		<table width=100% ><tr><td width=45><img src="templates/<{template}>/images/stats_icon.gif"></td><td>
		Our members have made a total of <b><{total_post_count}></b> posts<br>
		We have <b><{total_member_count}></b> registered user(s).<br>
		The newest registered user is <a href="profile.php?id=<{newest_user_id}>"><{newest_user}></a>
		</td></tr></table>
		</td></tr>
		<tr class=table_subheader><td align=left class=table_subheader>Online Today - <span class=hilight><{online_today_count}></span> Users</td></tr>
		<tr><td class=contentmain>
		<table width=100% ><tr><td width=45><img src="templates/<{template}>/images/onlinetoday_icon.gif"></td><td>
		The following members have visited today (ordered by last click):<br>
		<{loop_online_today}>
			<a href="profile.php?id=<{online_id}>" class="link_user_<{online_posting}>"><{online_user}></a><img src="templates/<{template}>/images/EKINboard_icon_<{online_level}>.gif"><{spacer}>&nbsp;
		<{/loop_online_today}>
		</td></tr></table>
		</td></tr>
		</table>
		</td></tr>
<tr><td colspan='10' align='right' class=small><{server_load}> <{execution_time}></td></tr>
<tr><td colspan='10' align='center'><a href='http://www.ekinboard.com' target='_blank'>EKINboard</a> v<{ekinboard_version}> © 2005 <a href='http://www.ekindesigns.com' target='_blank'>EKINdesigns</a></td></tr>
</table>
</center>
</body>
</html>