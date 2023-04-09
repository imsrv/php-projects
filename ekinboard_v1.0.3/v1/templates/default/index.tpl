						<table width="100%" height="50">
							<tr>
								<td valign="middle">
									<a href="index.php"><{page_title}> Home</a>
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
						<{loop_category}>
							<table width="100%" cellspacing="0" cellpadding="0" class="category_table">
								<tr>
									<td colspan="4">
										<table width="100%" cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td width="45">
													<img src="templates/<{template}>/images/EKINboard_header_left.gif" alt=""></td>
												<td width="100%" class="table_1_header">
													<a href="javascript:showhide('category_<{id}>');"><img src="templates/<{template}>/images/arrow_up.gif" border="0" alt="Hide Category" title="Hide Category"></a> <b><{name}></b>
												</td>
												<td align="right" class="table_1_header">
													<img src="templates/<{template}>/images/EKINboard_header_right.gif" alt=""></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<div id="category_<{id}>">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tr class="table_subheader">
													<td width="30">
													</td>
													<td align="left" class="table_subheader">
														Forum Name
													</td>
													<td width="50" align="center" class="table_subheader">
														Viewing
													</td>
													<td width="50" align="center" class="table_subheader">
														Topics
													</td>
													<td width="50" align="center" class="table_subheader">
														Replies
													</td>
													<td width="150" align="left" class="table_subheader">
														Last Post
													</td>
												</tr>
												<{loop_forums}>
													<tr>
														<td width="45" align="center" class="padding">
															<img src="templates/<{template}>/images/forum_image_<{read}>_1.gif" alt="0"></td>
														<td align="left" class="row<{evenforum}>"  onmouseover="this.className='forum<{evenforum}>_on';" onmouseout="this.className='row<{evenforum}>';" onclick="window.location.href='viewforum.php?id=<{id}>'">
															<a href="viewforum.php?id=<{id}>"><{name}></a><br><{description}>
															<{loop_forum_subforum_list}>
															<br>
															<b>Subforums</b>:
																	<{loop_subforum_list}>
																		<a href="viewforum.php?id=<{id}>" class="link2"><{name}></a>
																	<{/loop_subforum_list}>
															<{/loop_forum_subforum_list}>
															<{loop_forum_moderators}>
															<br>
															<i>Moderators: 
																	<{loop_mod_list}>
																		<a href="profile.php?id=<{moderator_id}>" class="link2"><{moderator_name}></a>
																	<{/loop_mod_list}>
															</i>
															<{/loop_forum_moderators}>
														</td>
														<td width="50" align="center" class="forum3">
															<{viewing_count}>
														</td>
														<td width="50" align="center" class="forum3">
															<{topic_count}>
														</td>
														<td width="50" align="center" class="row<{evenforum}>">
															<{replies_count}>
														</td>
														<td width="150" align="left" class="forum3">
															<{recent_date}><br><b>In:</b> <a href="viewtopic.php?id=<{recent_topic_id}>" title="<{recent_topic_over}>" alt="<{recent_topic_over}>"><{recent_topic}></a><br><b>By:</b> <a href="profile.php?id=<{recent_poster_id}>"><{recent_poster}></a>
														</td>
													</tr>
												<{/loop_forums}>
											</table>
										</div>
									</td>
								</tr>
							</table>
							<table width="100%" height="10">
								<tr>
									<td>
									</td>
								</tr>
							</table>
						<{/loop_category}>
						<table width="100%" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="right">
									<form name="forumchange">
									<b>Select Forum: </b>
										<select name="id" size="1" onChange="javascript:forumchanger()">
										<option value="">Choose Forum..

											<{loop_dropdown}>
												<{dropdown_list}>
											<{/loop_dropdown}>

										</select>
									</form>
								</td>
							</tr>
						</table>

						<table width="100%" cellspacing="0" cellpadding="0" class="category_table">
							<tr>
								<td colspan="4">
									<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td width="45">
												<img src="templates/<{template}>/images/EKINboard_header_left.gif" alt="0"></td>
											<td width="100%" class="table_1_header">
												<img src="templates/<{template}>/images/arrow_up.gif" alt="0"> <b>Board Statistics</b>
											</td>
											<td align="right" class="table_1_header">
												<img src="templates/<{template}>/images/EKINboard_header_right.gif" alt="0"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr class="table_subheader">
								<td align="left" class="table_subheader">
									Online Users
								</td>
							</tr>
							<tr>
								<td class="contentmain">
									<table width="100%">
										<tr>
											<td width="45">
												<img src="templates/<{template}>/images/online_icon.gif" alt="0">
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
							<tr class="table_subheader">
								<td align="left" class="table_subheader">
									General Statistics
								</td>
							</tr>
							<tr>
								<td class="contentmain">
									<table width="100%">
										<tr>
											<td width="45">
												<img src="templates/<{template}>/images/stats_icon.gif" alt="0">
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
							<tr class="table_subheader">
								<td align="left" class="table_subheader">
									Online Today - <span class="hilight"><{online_today_count}></span> Users
								</td>
							</tr>
							<tr>
								<td class="contentmain">
									<table width="100%">
										<tr>
											<td width="45">
												<img src="templates/<{template}>/images/onlinetoday_icon.gif" alt="0">
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
					<td colspan="10" align="right" class="small">
						<{server_load}> <{execution_time}>
					</td>
				</tr>
				<tr>
					<td colspan="10" align="center">
						<a href="http://www.ekinboard.com" target="_blank">EKINboard</a> v<{ekinboard_version}> © 2005 <a href="http://www.ekindesigns.com" target="_blank">EKINdesigns</a>
					</td>
				</tr>
			</table>
		</center>
	</body>
</html>
