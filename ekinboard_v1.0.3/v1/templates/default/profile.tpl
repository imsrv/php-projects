<table width=100% height=50><tr><td valign=middle>
<a href="index.php"><{page_title}> Home</a> - Member Profile
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

<{loop_main_profile}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
	<tr class=table_1_header><td colspan=4>
	<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b><{profile_username}>'s Profile</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
	</table></td></tr>
	<tr class=table_subheader><td align=left class=table_subheader>Here you can view all of <{profile_username}>'s details</td></tr>
	<tr><td class=contentmain>
	<table width=100% cellpaddin=5><tr><td width=50% valign=top>
	<form action="login.php?do=login" method="post">
	<fieldset>
	<legend><b>General Information</b></legend>
	<table width=100%>
	<tr><td valign=middle width=100><b>Rating:</b></td><td valign=middle class=contentmain><{vote_img}></td></tr>
	<tr><td valign=middle width=100><b>Total Posts:</b></td><td valign=middle class=contentmain><b><{profile_total_posts}></b> ( <{profile_post_percentage}>% of total forum posts )</td></tr>
	<tr><td valign=middle width=100><b>Last Active:</b></td><td valign=middle class=contentmain><{profile_last_login}></td></tr>
	<tr><td valign=middle width=100><b>Birthday:</b></td><td valign=middle class=contentmain><{profile_birthday}></td></tr>
	<tr><td valign=middle width=100><b>Location:</b></td><td valign=middle class=contentmain><{profile_location}></td></tr>
	<tr><td valign=middle width=100><b>Status:</b></td><td valign=middle class=contentmain><{profile_online_status}></td></tr>
	</table>
	</fieldset>
	</td><td width=50% valign=top>
	<fieldset>
	<legend><b>Contact Information</b></legend>
	<table width=100%>
	<tr><td valign=middle width=75>Website: </td><td valign=middle class=contentmain><{profile_website}></td></tr>
	<tr><td valign=middle width=75>AIM: </td><td valign=middle class=contentmain><{profile_aim}></td></tr>
	<tr><td valign=middle width=75>MSN: </td><td valign=middle class=contentmain><{profile_msn}></td></tr>
	<tr><td valign=middle width=75>YIM: </td><td valign=middle class=contentmain><{profile_yim}></td></tr>
	<tr><td valign=middle width=75>ICQ: </td><td valign=middle class=contentmain><{profile_icq}></td></tr>
	<tr><td valign=middle align=center class=contentmain colspan=2><a href="mailbox.php?act=compose&to=<{profile_username}>">Send this user a PM</a></td></tr>
	</table>
	</fieldset>
	</td></tr></table>
	</td></tr>
	</table>
	<table width=100% height=10><tr><td></td></tr></table>
</form>
<{/loop_main_profile}>
<table cellspacing="0" cellpadding="2" width="100%"><tr><td valign="top" width="125">
<{loop_avatar_profile}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
	<tr class=table_1_header><td colspan=4>
	<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Avatar</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
	</table></td></tr>
	<tr class=table_subheader><td align=left class=table_subheader><{profile_username}>'s avatar</td></tr>
	<tr><td class=contentmain align="center">
		<{profile_avatar}>
	</td></tr></table>
	<table width=100% height=10><tr><td></td></tr></table>
<{/loop_avatar_profile}>
</td><td valign="top">
<{loop_sig_profile}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
	<tr class=table_1_header><td colspan=4>
	<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Signature</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
	</table></td></tr>
	<tr class=table_subheader><td align=left class=table_subheader>What shows up at the bottom of every post by <{profile_username}></td></tr>
	<tr><td class=contentmain>
		<{profile_signature}>
	</td></tr></table>
	<table width=100% height=10><tr><td></td></tr></table>
<{/loop_sig_profile}>
</td></tr></table>
<{loop_error}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
	<tr class=table_1_header><td colspan=4>
	<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Error</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
	</table></td></tr>
	<tr class=table_subheader><td align=left class=table_subheader>Could not complete your request</td></tr>
	<tr><td class=contentmain align=center>
	<span class=error><{error_message}></span>
	</td></tr></table>
	<table width=100% height=10><tr><td></td></tr></table>
<{/loop_error}>
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