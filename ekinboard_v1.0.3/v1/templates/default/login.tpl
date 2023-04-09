<table width=100% height=50>
	<tr>
		<td valign=middle>
			<a href="index.php"><{page_title}> Home</a> - Login
		</td>
	</tr>
</table>
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
<{loop_login}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
		<tr>
			<td colspan=4>
				<table width=100% cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td width=45>
							<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
						<td width=100% class=table_1_header>
							<img src="templates/<{template}>/images/arrow_up.gif"> <b>Login</b>
						</td>
						<td align=right class=table_1_header>
							<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class=table_subheader>
			<td align=left class=table_subheader>
				Please enter your details below to log in
			</td>
		</tr>
		<tr>
			<td class=loginmain align=center>
				<table width=100% height=10>
					<tr>
						<td>
						</td>
					</tr>
				</table>
				<table width="95%" cellpadding="0" cellspacing="0" border="0" class="redtable">
					<tr>
						<td class="redtable_header">
							<b>Attention!</b>
						</td>
					</tr>
					<tr>
						<td class="redtable_content">
							You must already have registered for an account before you can log in.<br>
							If you do not have an account, you may register by clicking the 'register' link near the top of the screen<br><br>

							Forgot your password? <a href=login.php?d=forgot>Click Here</a>
						</td>
					</tr>
				</table>
									<script language="javascript">
									function desableButton(){
										document.Form.submit.disabled=true;
									}
									</script>
				<table width=95% cellpaddin=5>
					<tr>
						<td width=60%>
							<form action="login.php?d=login" method="post" name="Form" onSubmit="disableButton()">
								<fieldset>
								<legend><b>Log In</b></legend>
								<table cellspacing="0" class="legend_<{username_error}>" width=100%>
									<tr>
										<td class=redtable_content>
											<span class="error"><{username_error_message}></span>
										</td>
									</tr>
									<tr>
										<td valign=middle width=50% class=redtable_content>
											Enter your user name: </td>
										<td valign=middle width=50% class=redtable_content>
											<input class=text type=text size="25" maxlength="64" name=username value="<{submitted_user}>">
										</td>
									</tr>
								</table>
								<table width=100% height=10>
									<tr>
										<td>
										</td>
									</tr>
								</table>
								<table cellspacing="0" class="legend_<{password_error}>" width=100%>
									<tr>
										<td class=redtable_content>
											<span class="error"><{password_error_message}></span>
										</td>
									</tr>
									<tr>
										<td valign=middle width=50% class=redtable_content>
											Enter your password: </td>
										<td valign=middle width=50% class=redtable_content>
											<input class=text type="password" size="25" maxlength="64" name=password>
										</td>
									</tr>
								</table>
								</fieldset>
							</td>
							<td width=40% valign=top>
								<fieldset>
								<legend><b>Options</b></legend>
								<table width=100%>
									<tr>
										<td valign=middle width=10%>
											<input type="checkbox" name="cookie" value="1" checked="checked" />
										</td>
										<td valign=middle width=90%>
											<b>Remember me?</b><br />This is not recommended for shared computers
										</td>
									</tr>
								</table>
								</fieldset>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class=table_bottom align=center>
					<input type="hidden" name="from_url" value="<{from_url}>">
					<input type="submit" value="Log me in!" class="button" name="submit">
				</td>
			</tr>
		</table>
		<table width=100% height=10>
			<tr>
				<td>
				</td>
			</tr>
		</table>
		</form>
	<{/loop_login}>
<{loop_forgot}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
		<tr>
			<td colspan=4>
				<table width=100% cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td width=45>
							<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
						<td width=100% class=table_1_header>
							<img src="templates/<{template}>/images/arrow_up.gif"> <b>Forgot Password</b>
						</td>
						<td align=right class=table_1_header>
							<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class=table_subheader>
			<td align=left class=table_subheader>
				Please enter your details below to recieve your password
			</td>
		</tr>
		<tr>
			<td class=loginmain align=center>
				<table width=100% height=10>
					<tr>
						<td>
						</td>
					</tr>
				</table>
									<script language="javascript">
									function desableButton(){
										document.Form.submit.disabled=true;
									}
									</script>
				<table width=95% cellpaddin=5>
					<tr>
						<td align="center">
							<form action="login.php?d=forgot" method="post" name="Form" onSubmit="disableButton()">
								<fieldset>
								<legend class="contentmain"><b>Forgot</b></legend>
								<table cellspacing="0" class="legend_<{username_error}>" width=90%>
									<tr>
										<td class=redtable_content>
											<span class="error"><{username_error_message}></span>
										</td>
									</tr>
									<tr>
										<td valign=middle class=redtable_content>
											Enter your username: </td>
										<td valign=middle class=redtable_content>
											<input class=text type="text" size="25" maxlength="64" name=username>
										</td>
									</tr>
								</table>
								</fieldset>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class=table_bottom align=center>
					<input type="hidden" name="from_url" value="<{from_url}>">
					<input type="submit" value="Send > >" class="button" name="submit">
				</td>
			</tr>
		</table>
		<table width=100% height=10>
			<tr>
				<td>
				</td>
			</tr>
		</table>
		</form>
	<{/loop_forgot}>
	<{loop_forgot_sent}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
		<tr>
			<td colspan=4>
				<table width=100% cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td width=45>
							<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
						<td width=100% class=table_1_header>
							<img src="templates/<{template}>/images/arrow_up.gif"> <b>Forgot Password</b>
						</td>
						<td align=right class=table_1_header>
							<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class=table_subheader>
			<td align=left class=table_subheader>
				Password Sent
			</td>
		</tr>
		<tr><td class="contentmain">
		Your password has been sent to your email address.
	</td></tr></table>
	<table width=100% height=10><tr><td></td></tr></table>
<{/loop_forgot_sent}>
	<{loop_forgot_sent2}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
		<tr>
			<td colspan=4>
				<table width=100% cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td width=45>
							<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
						<td width=100% class=table_1_header>
							<img src="templates/<{template}>/images/arrow_up.gif"> <b>Forgot Password</b>
						</td>
						<td align=right class=table_1_header>
							<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class=table_subheader>
			<td align=left class=table_subheader>
				Email Sent
			</td>
		</tr>
		<tr><td class="contentmain">
		An Email has been sent to your email address.
	</td></tr></table>
	<table width=100% height=10><tr><td></td></tr></table>
<{/loop_forgot_sent2}>
	<{loop_logged_in}>
		<table width=100% cellspacing=0 cellpadding=0 class=category_table>
			<tr class=table_1_header>
				<td colspan=4>
	<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td width=100% class=table_1_header><b>Login</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
	</table></td></tr><tr><td>
	<center><table width=100% height=10><tr><td></td></tr></table>
	<table width="95%" cellpadding="0" cellspacing="0" border="0" class="redtable"><tr><td class="redtable_header">
	<b>Notice!</b></td></tr><tr><td class="redtable_content">
	You are already logged in!
	</td></tr></table>
	<table width=100% height=10><tr><td></td></tr></table>
	</td></tr></table>
	<table width=100% height=10><tr><td></td></tr></table>
<{/loop_logged_in}>
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
			<a href="profile.php?id=<{online_id}>" class="link_user_<{online_posting}>"><{online_user}></a><img src="templates/<{template}>/images/EKINboard_icon_<{online_level}>.gif"><{spacer}>&nbsp;
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