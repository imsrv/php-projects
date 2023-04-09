<table width=100% height=50><tr><td valign=middle>
<a href="index.php"><{page_title}> Home</a> - <a href="index.php?cid=<{category_id}>"><{category_name}></a> - <a href="viewforum.php?id=<{forum_id}>"><{forum_name}></a> - <a href="viewtopic.php?id=<{topic_id}>"><{topic_name}></a> - Reply
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

<{loop_reply}>
	<table width=100% cellspacing=0 cellpadding=0 class=category_table>
	<tr class=table_1_header><td colspan=4>
	<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Reply</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
	</table></td></tr>
	<tr class=table_subheader><td align=left class=table_subheader>Please enter your reply below</td></tr>
	<tr><td class=post_table_bottom align=center>
<script type="text/javascript" src="templates/<{template}>/ekincode.js"></script>
	<form action="postreply.php?id=<{id}>&d=post" method="post" name="Form" onSubmit="desableButton()">
										<a href=javascript:add_smilie('[b][/b]')><img src="templates/<{template}>/images/bold_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[i][/i]')><img src="templates/<{template}>/images/italics_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[u][/u]')><img src="templates/<{template}>/images/underlined_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[url=][/url]')><img src="templates/<{template}>/images/hyperlink_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[img=]')><img src="templates/<{template}>/images/image_btn.gif" border="0" alt=""></a>
	</td></tr>
	<tr><td align=center>
<script language='javascript'>
<!--
	function add_smilie(code)
	{
		document.Form.message.value += code;
		//return true;
	}
//-->
</script>
									<script language="javascript">
									function desableButton(){
										document.Form.submit.disabled=true;
									}
									</script>
<a href=javascript:add_smilie(':)')><img alt=\"smilie for :)\" title=\":)\" src=templates/<{template}>/images/smilies/excited.gif border=0></a>
<a href=javascript:add_smilie(':(')><img alt=\"smilie for :(\" title=\":(\" src=templates/<{template}>/images/smilies/dissapointed.gif border=0></a>
<a href=javascript:add_smilie(':P')><img alt=\"smilie for :P\" title=\":P\" src=templates/<{template}>/images/smilies/tongue.gif border=0></a>
<a href=javascript:add_smilie(':D')><img alt=\"smilie for :D\" title=\":D\" src=templates/<{template}>/images/smilies/grin.gif border=0></a>
<a href=javascript:add_smilie(':O')><img alt=\"smilie for :O\" title=\":O\" src=templates/<{template}>/images/smilies/shocked.gif border=0></a>
<a href=javascript:add_smilie(':sad:')><img alt=\"smilie for :sad:\" title=\":sad:\" src=templates/<{template}>/images/smilies/sad.gif border=0></a>
<a href=javascript:add_smilie('-.-')><img alt=\"smilie for -.-\" title=\"-.-\" src=templates/<{template}>/images/smilies/closedeyes.gif border=0></a>
<a href=javascript:add_smilie('o.o')><img alt=\"smilie for o.o\" title=\"o.o\" src=templates/<{template}>/images/smilies/bigeyes.gif border=0></a>
<a href=javascript:add_smilie(':sleep:')><img alt=\"smile for :sleep:\" title=\":sleep:\" src=templates/<{template}>/images/smilies/sleeping.gif border=0></a>
	</td></tr>
	<tr><td class=contentmain align=center>
	<table cellspacing="0" class="legend_<{message_error}>" width=95%>
	<tr><td class=redtable_content>
		<span class="error"><{message_error_message}></span>
	</td></tr><tr><td align=center>
	<table>
	<tr><td valign=middle align=center><textarea class=text cols=100 rows=10 name=message><{submitted_message}></textarea></td></tr>
	</table>
	</td></tr></table>
	</td></tr>
	<tr><td class=table_bottom align=center><input type="submit" value="Post > >" class="button" name="submit"></td></tr>
	</table>
	<table width=100% height=10><tr><td></td></tr></table>
</form>
<{/loop_reply}>
						<{loop_replies}>
							<table width=100% height=10>
								<tr>
									<td>
									</td>
								</tr>
							</table>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=2>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Last <{post_count}> Replies</b></td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<{loop_areply}>
									<tr>
										<td colspan=2 class=table_subheader>
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td align="left">
														Posted by <a href="profile.php?id=<{poster_id}>"><{poster}></a> on <{date}>
													</td>
													<td align="right">
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td valign=top class=contentmain width=100%>
											<{message}>
										</td>
									</tr>
								<{/loop_areply}>
							</table>
	<table width=100% height=10><tr><td></td></tr></table>
						<{/loop_replies}>
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
		<tr><td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Viewing Statistics</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
		</table></td></tr>
		<tr class=table_subheader><td align=left class=table_subheader><b><{total_active_users}></b> user(s) active in this forum in the past 15 minutes</td></tr>
		<tr><td class=contentmain>
		<table width=100% ><tr><td width=45><img src="templates/<{template}>/images/online_icon.gif"></td><td>
		<b><{total_active_guests}></b> guest(s), <b><{total_active_members}></b> member(s)<p>
		<{loop_user_online}>
			<a href="profile.php?id=<{online_id}>" class="link_user_<{online_posting}>"><{online_user}></a><img src="templates/<{template}>/images/EKINboard_icon_<{online_level}>.gif"><{spacer}>&nbsp;
		<{/loop_user_online}>
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