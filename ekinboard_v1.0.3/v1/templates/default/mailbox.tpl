						<table width=100% height=50>
							<tr>
								<td valign=middle>
									<a href="index.php"><{page_title}> Home</a> - Mailbox
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
							<table width=100%>
								<tr><td width=250 valign=top>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr class=table_1_header>
									<td colspan=4>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Navigation</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Actions
									</td>
								</tr>
								<tr>
									<td class="row1" onmouseover="this.className='forum1_on';" onmouseout="this.className='row1';" onclick="window.location.href='mailbox.php?act=compose'" align=center>
										<a href="mailbox.php?act=compose">Compose</a>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Folders
									</td>
								</tr>
								<tr>
									<td class="row1" onmouseover="this.className='forum1_on';" onmouseout="this.className='row1';" onclick="window.location.href='mailbox.php?folder=inbox'" align=center>
										<a href="mailbox.php?folder=inbox">Inbox</a>
									</td>
								</tr>
								<tr>
									<td class="row2" onmouseover="this.className='forum2_on';" onmouseout="this.className='row2';" onclick="window.location.href='mailbox.php?folder=sent'" align=center>
										<a href="mailbox.php?folder=sent">Sent</a>
									</td>
								</tr>
							</table>
								</td><td valign=top>
						<{loop_pages}>
							<table>
								<tr>
									<td class="padding">
										<table class="pagetable_1">
											<tr>
												<td>
													Pages: (<{total_pages}>)
												</td>
											</tr>
										</table>
									</td>
									<{loop_first_page}>
									<td class="padding">
											<table class="pagetable_1">
												<tr>
													<td>
														<a href="mailbox.php?folder=<{folder}>&id=<{id}>&page=<{page_num}>">«</a>
													</td>
												</tr>
											</table>
										</td>
									<{/loop_first_page}>
									<{loop_page_number}>
									<td class="padding">
											<table class="pagetable_<{current_page}>">
												<tr>
													<td>
														<a href="mailbox.php?folder=<{folder}>&id=<{id}>&page=<{page_num}>"><{page_num}></a>
													</td>
												</tr>
											</table>
										</td>
									<{/loop_page_number}>
									<{loop_last_page}>
									<td class="padding">
											<table class="pagetable_1">
												<tr>
													<td>
														<a href="mailbox.php?folder=<{folder}>&id=<{id}>&page=<{page_num}>">»</a>
													</td>
												</tr>
											</table>
										</td>
									<{/loop_last_page}>
								</tr>
							</table>
						<{/loop_pages}>
						<{loop_compose}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr class=table_1_header>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Compose Message</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Message details
									</td>
								</tr>
								<tr>
									<td align=center>
										<form action="mailbox.php?act=compose&send=true" method="post" name=Form onSubmit="disableButton()">
										<table width=100% cellpadding=0 cellspacing=0 border=0>
										<tr><td class=contentmain>
											<table cellspacing="0" class="legend_<{to_error}>" width=95%>
											<tr><td class=redtable_content>
												<span class="error"><{to_error_message}></span>
											</td></tr><tr><td>
												<table><tr><td width=100 align=right>
													To:
												</td><td width=10></td><td class=contentmain>
													<input class="text" type="text" name="message_to" size=30 value="<{submitted_to}>">
												</td></tr></table>
											</td></tr></table>
										</td></tr><tr><td class=contentmain>
											<table cellspacing="0" class="legend_<{subject_error}>" width=95%>
											<tr><td class=redtable_content>
												<span class="error"><{subject_error_message}></span>
											</td></tr><tr><td>
												<table><tr><td width=100 align=right>
													Subject:
												</td><td width=10></td><td class=contentmain>
													<input class="text" type="text" name="message_subject" size=30 value="<{submitted_subject}>">
												</td></tr></table>
											</td></tr></table>
										</td></tr></table>
										<tr class=table_subheader><td align=left class=table_subheader colspan=2>Please enter your message below</td></tr>
	<tr><td class=post_table_bottom align=center colspan=2>
										<a href=javascript:add_smilie('[b][/b]')><img src="templates/<{template}>/images/bold_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[i][/i]')><img src="templates/<{template}>/images/italics_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[u][/u]')><img src="templates/<{template}>/images/underlined_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[url=][/url]')><img src="templates/<{template}>/images/hyperlink_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[img=]')><img src="templates/<{template}>/images/image_btn.gif" border="0" alt=""></a>

	</td></tr>
	<tr><td align=center colspan=2>
<script language='javascript'>
<!--
	function add_smilie(code)
	{
		document.Form.message_text.value += code;
		//return true;
	}
//-->
</script>
									<script language="javascript">
									function desableButton(){
										document.Form.submit.disabled=true;
									}
									</script>
<a href=javascript:add_smilie(':)')><img alt=\"smilie for :)\" title=\":)\" src="templates/<{template}>/images/smilies/excited.gif" border=0></a>
<a href=javascript:add_smilie(':(')><img alt=\"smilie for :(\" title=\":(\" src="templates/<{template}>/images/smilies/dissapointed.gif" border=0></a>
<a href=javascript:add_smilie(':P')><img alt=\"smilie for :P\" title=\":P\" src="templates/<{template}>/images/smilies/tongue.gif" border=0></a>
<a href=javascript:add_smilie(':D')><img alt=\"smilie for :D\" title=\":D\" src="templates/<{template}>/images/smilies/grin.gif" border=0></a>
<a href=javascript:add_smilie(':O')><img alt=\"smilie for :O\" title=\":O\" src="templates/<{template}>/images/smilies/shocked.gif" border=0></a>
<a href=javascript:add_smilie(':sad:')><img alt=\"smilie for :sad:\" title=\":sad:\" src="templates/<{template}>/images/smilies/sad.gif" border=0></a>
<a href=javascript:add_smilie('-.-')><img alt=\"smilie for -.-\" title=\"-.-\" src="templates/<{template}>/images/smilies/closedeyes.gif" border=0></a>
<a href=javascript:add_smilie('o.o')><img alt=\"smilie for o.o\" title=\"o.o\" src="templates/<{template}>/images/smilies/bigeyes.gif" border=0></a>
<a href=javascript:add_smilie(':sleep:')><img alt=\"smile for :sleep:\" title=\":sleep:\" src="templates/<{template}>/images/smilies/sleeping.gif" border=0></a>
<tr><td colspan=2 valign=top class=contentmain>
										<table cellspacing="0" class="legend_<{message_error}>" width=95%>
										<tr><td class=redtable_content>
											<span class="error"><{message_error_message}></span>
										</td></tr><tr><td>
											<table><tr><td width=100 align=right>
												Message:
											</td><td width=10></td><td class=contentmain>
												<textarea class="text" name="message_text" cols="70" rows="10"><{submitted_message}></textarea>
											</td></tr></table>
		</td></tr></table>
									</td>
								</tr>
								<tr>
									<td class=table_bottom align=center>
										<input type="submit" value="Send > >" class="button" name="submit">
									</td>
								</tr>
							</table>
						<{/loop_compose}>
						<{loop_inbox}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr class=table_1_header>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Inbox</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader width=30>
									</td>
									<td class=table_subheader>
										Message Title
									</td>
									<td class=table_subheader>
										Sender
									</td>
									<td class=table_subheader>
										Date
									</td>
									<td class=table_subheader>
									</td>
								</tr>
								<form action="mailbox.php?folder=inbox&act=delete" method="POST">
									<{loop_inbox_message}>
										<tr>
											<td width=30 align=center>
												<img src="templates/<{template}>/images/mail_icon_<{message_read}>.gif">
											</td>
											<td class="row<{evenmessage}>" onmouseover="this.className='topic<{evenmessage}>_on';" onmouseout="this.className='row<{evenmessage}>';" onclick="window.location.href='mailbox.php?folder=inbox&act=read&id=<{message_id}>'">
												<a href="mailbox.php?folder=inbox&act=read&id=<{message_id}>"><{message_title}></a>
											</td>
											<td class="forum3" width=100>
												<a href="profile.php?id=<{message_sender_id}>"><{message_sender}></a>
											</td>
											<td class="forum3" width=200>
												<{message_date}>
											</td>
											<td class="forum3" width=20>
												<input type="checkbox" class="form" name="message[]" value="<{message_id}>" />
											</td>
										</tr>
									<{/loop_inbox_message}>
									<tr>
										<td colspan=5 class=post_table_bottom align="right">
											<table cellpadding="0" cellspacing="0" border=0>
												<tr>
													<td valign="top">
														<input class=form type="image" src="templates/<{template}>/images/delete_btn.gif">
													</td>
												</tr>
											</table>	
										</td>
									</tr>
								</form>
							</table>
						<{/loop_inbox}>
						<{loop_sent}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr class=table_1_header>
									<td colspan=4>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Sent Messages</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader width=30>
									</td>
									<td class=table_subheader>
										Message Title
									</td>
									<td class=table_subheader>
										To
									</td>
									<td class=table_subheader>
										Date
									</td>
								</tr>
								<form action="mailbox.php?folder=sent&act=delete" method="POST">
									<{loop_sent_message}>
										<tr>
											<td width=30 align=center>
												<img src="templates/<{template}>/images/mail_icon_<{message_read}>.gif">
											</td>
											<td class="row<{evenmessage}>" onmouseover="this.className='topic<{evenmessage}>_on';" onmouseout="this.className='row<{evenmessage}>';" onclick="window.location.href='mailbox.php?folder=sent&act=read&id=<{message_id}>'">
												<a href="mailbox.php?folder=sent&act=read&id=<{message_id}>"><{message_title}></a>
											</td>
											<td width=100 class="forum3">
												<a href="profile.php?id=<{message_reciever_id}>"><{message_reciever}></a>
											</td>
											<td width=200 class="forum3">
												<{message_date}>
											</td>
										</tr>
									<{/loop_sent_message}>
								</form>
							</table>
						<{/loop_sent}>
						<{loop_read_inbox}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr class=table_1_header>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b><{message_title}></b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader colspan=2>
										<{message_date}>
									</td>
								</tr>
								<tr>
									<td class=forum3>
										From:
									</td>
									<td class=row2 width="90%">
										<a href="profile.php?id=<{message_sender_id}>"><{message_sender}></a>
									</td>
								</tr>
								<tr>
									<td height=10 colspan=2>
									</td>
								</tr>
								<tr>
									<td colspan=2 class=contentmain>
										<{message_text}>
									</td>
								</tr>
								<tr>
									<td colspan=5 class=post_table_bottom align="right">
										<form action="mailbox.php?folder=inbox&act=delete" method="POST">
											<table cellpadding="0" cellspacing="0" border=0>
												<tr>
													<td valign=top>
														<input type="hidden" name="inbox_message_id" value="<{message_id}>">
														<input class=form type="image" src="templates/<{template}>/images/delete_btn.gif">
													</td>
													<td valign=top>
														<a href="mailbox.php?act=compose&d=reply&id=<{message_id}>"><img src="templates/<{template}>/images/msg_reply_btn.gif" border="0" alt=""></a>
													</td>
												</tr>
											</table>	
										</form>
									</td>
								</tr>
							</table>
						<{/loop_read_inbox}>
						<{loop_read_sent}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr class=table_1_header>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b><{message_title}></b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader colspan=2>
										<{message_date}>
									</td>
								</tr>
									<tr>
										<td class=forum3>
											To:
										</td>
										<td class=row2 width="90%">
											<a href="profile.php?id=<{message_reciever_id}>"><{message_reciever}></a>
										</td>
									</tr>
									<tr>
										<td height=10 colspan=2>
										</td>
									</tr>
									<tr>
										<td colspan=2 class=contentmain>
											<{message_text}>
										</td>
									</tr>
							</table>
						<{/loop_read_sent}>
						<{loop_message_sent}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr class=table_1_header>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Compose Message</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Your message has been sent!
									</td>
								</tr>
									<tr>
										<td class=contentmain align=center>
											<span class=error>Your message has been sent to <a href="profile.php?id=<{reciever_id}>"><{reciever}></a>!</span>
										</td>
									</tr>
							</table>
						<{/loop_message_sent}>
						<{loop_error}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr class=table_1_header>
									<td colspan=4>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Error</b></td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr class=table_subheader>
									<td align=left class=table_subheader>	
										Could not complete your request
									</td>
								</tr>
								<tr>
									<td class=contentmain align=center>
										<table width="95%" cellpadding="0" cellspacing="0" border="0" class="redtable">
											<tr>
												<td class="redtable_header">
													<b>Notice!</b>
												</td>
											</tr>
											<tr>
												<td class="redtable_content">
													<{error_message}>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						<{/loop_error}>
							</td></tr></table>
					<table width="100%" height="10">
							<tr>
								<td>
								</td>
							</tr>
						</table>
						<table width=100% cellspacing=0 cellpadding=0 class=category_table>
							<tr class=table_1_header>
								<td colspan=4>
									<table width=100% cellpadding=0 cellspacing=0 border=0>
										<tr>
											<td width=100% class=table_1_header>
												<img src="templates/<{template}>/images/arrow_up.gif"> <b>Board Statistics</b>
											</td>
											<td align=right class=table_1_header>
												<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr class=table_subheader>
								<td align=left class=table_subheader>
									Online Users
								</td>
							</tr>
							<tr>
								<td class=contentmain>
									<table width=100%>
										<tr>
											<td width=45>
											<img src="templates/<{template}>/images/online_icon.gif">
											</td>
											<td>
												<b><{total_active_users}></b> user(s) active in the past 15 minutes<br>
												<b><{total_active_guests}></b> guest(s), <b><{total_active_members}></b> member(s)<p>
												<{loop_user_online}>
													<a href="profile.php?id=<{online_id}>" class="link_user_<{online_posting}>"><{online_user}></a><img src="templates/<{template}>/images/EKINboard_icon_<{online_level}>.gif"><{spacer}>&nbsp;
												<{/loop_user_online}>
											</td>
										</tr>
									</table>
							</td>
							</tr>
							<tr class=table_subheader>
								<td align=left class=table_subheader>
								General Statistics
								</td>
							</tr>
							<tr>
								<td class=contentmain>
									<table width=100%>
										<tr>
											<td width=45>
												<img src="templates/<{template}>/images/stats_icon.gif">
											</td>
											<td>
												Our members have made a total of <b><{total_post_count}></b> posts<br>
												We have <b><{total_member_count}></b> registered user(s).<br>
												The newest registered user is <a href="profile.php?id=<{newest_user_id}>"><{newest_user}></a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr class=table_subheader>
								<td align=left class=table_subheader>
									Online Today - <span class=hilight><{online_today_count}></span> Users
								</td>
							</tr>
							<tr>
								<td class=contentmain>
									<table width=100%>
										<tr>
											<td width=45>
												<img src="templates/<{template}>/images/onlinetoday_icon.gif">
											</td>
											<td>
												The following members have visited today (ordered by last click):<br>
												<{loop_online_today}>
													<a href="profile.php?id=<{online_id}>" class="link_user_<{online_posting}>"><{online_user}></a><img src="templates/<{template}>/images/EKINboard_icon_<{online_level}>.gif"><{spacer}>&nbsp;
												<{/loop_online_today}>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan='10' align='right' class=small>
						<{server_load}> <{execution_time}>
					</td>
				</tr>
				<tr>
					<td colspan='10' align='center'>
						<a href='http://www.ekinboard.com' target='_blank'>EKINboard</a> v<{ekinboard_version}> © 2005 <a href='http://www.ekindesigns.com' target='_blank'>EKINdesigns</a>
					</td>
				</tr>
			</table>
		</center>
	</body>
</html>