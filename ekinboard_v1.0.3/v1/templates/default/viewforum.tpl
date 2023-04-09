						<table width="100%" height="50">
							<tr>
								<td valign="middle">
									<a href="index.php"><{page_title}> Home</a> - <a href="index.php?cid=<{category_id}>"><{category_name}></a> - <{subforum_cat_link}> <{forum_name}>
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
							<table width=100% height=10>
								<tr>
									<td>
									</td>
								</tr>
							</table>
						<{/loop_news}>
						<{loop_sub_forums}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=4>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Sub Forums</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<div id="category_<{id}>">
											<table width="100%" cellspacing="0" cellpadding="0">
												<tr class="table_subheader">
													<td width="45">
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
							<table width=100% height=10>
								<tr>
									<td>
									</td>
								</tr>
							</table>
						<{/loop_sub_forums}>
							<table width=100% cellpadding=0 cellspacing=0 border=0>
								<tr>
									<td width="100%" valign="middle">
										<{loop_pages}>
											<table cellpadding=2 cellspacing=2 border=0>
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
																		<a href="viewforum.php?id=<{id}>&page=<{page_num}>">«</a>
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
																		<a href="viewforum.php?id=<{id}>&page=<{page_num}>"><{page_num}></a>
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
																		<a href="viewforum.php?id=<{id}>&page=<{page_num}>">»</a>
																	</td>
																</tr>
															</table>
														</td>
													<{/loop_last_page}>
												</tr>
											</table>
										<{/loop_pages}>
									</td>
									<td>
									<{loop_member_buttons}>
			 							<table width=100% cellpadding=2 cellspacing=0 border=0>
											<tr>
												<td width="94">
													<a href="newtopic.php?id=<{forum_id}>"><img src="templates/<{template}>/images/newtopic_btn.gif" border="0" alt=""></a></td>
												<td width="94">
													<a href="newpoll.php?id=<{forum_id}>"><img src="templates/<{template}>/images/newpoll_btn.gif" border="0" alt=""></a></td>
											</tr>
										</table>
									<{/loop_member_buttons}>
								</tr>
							</table>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=7>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif" border="0" name="category_<{id}>" alt="0"> <b>Forum Topics</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr class=table_subheader>
									<td width=45>
									</td>
									<td align=left class=table_subheader>
										Topic Name
									</td>
									<td width=100 align=center class=table_subheader>
										Posted By
									</td>
									<td width=50 align=center class=table_subheader>
										Viewing
									</td>
									<td width=50 align=center class=table_subheader>
										Replies
									</td>
									<td width=50 align=center class=table_subheader>
										Views
									</td>
									<td width=150 class=table_subheader>
										Last Post
									</td>
								</tr>
								<{loop_error}>
								<tr>
									<td class=contentmain align=center colspan=7>
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
								<{/loop_error}>
								<{loop_pinned}>
									<{loop_pinned_topics}>
										<tr>
											<td width=45 align=center class=forum1>
												<img src="templates/<{template}>/images/EKINboard_topic_image_1_<{locked}>_<{poll}>_<{read}>.gif" alt="">
											</td>
											<td class="row<{evenforum}>" onmouseover="this.className='topic<{evenforum}>_on';" onmouseout="this.className='row<{evenforum}>';" onclick="window.location.href='viewtopic.php?id=<{id}>'">
												<a href=viewtopic.php?id=<{id}>><{title}></a><br><{description}>
											</td>
											<td align=center class="forum3" width=100>
												<a href=profile.php?id=<{poster_id}>><{poster}></a>
											</td>
											<td align=center class="forum3" width=50>
												<{viewing_count}>
											</td>
											<td align=center class="row<{evenforum}>">
												<{replies}>
											</td>
											<td align=center class="forum3">
												<{views}>
											</td>
											<td class="forum3">
												<{recent_date}><br><b>By:</b> <a href="profile.php?id=<{recent_poster_id}>"><{recent_poster}></a>
											</td>
										</tr>
									<{/loop_pinned_topics}>
								<{/loop_pinned}>
								<{loop_topics}>
									<tr>
										<td width=45 align=center class=forum1>
											<img src="templates/<{template}>/images/EKINboard_topic_image_0_<{locked}>_<{poll}>_<{read}>.gif" alt="">
										</td>
										<td class="row<{evenforum}>" onmouseover="this.className='topic<{evenforum}>_on';" onmouseout="this.className='row<{evenforum}>';" onclick="window.location.href='viewtopic.php?id=<{id}>'">
											<a href="viewtopic.php?id=<{id}>"><{title}></a><br><{description}>
										</td>
										<td align=center class="forum3" width=100>
											<a href=profile.php?id=<{poster_id}>><{poster}></a>
										</td>
										<td align=center class="forum3" width=50>
											<{viewing_count}>
										</td>
										<td align=center class="row<{evenforum}>">
											<{replies}>
										</td>
										<td align=center class="forum3">
											<{views}>
										</td>
										<td class="forum3">
											<{recent_date}><br><b>By:</b> <{recent_poster_link}>
										</td>
									</tr>
								<{/loop_topics}>
								<{loop_notopics}>
									<tr>
										<td colspan="7" align=center height=20>
											<span class=error>There are no topics in this forum yet!</span>
										</td>
									</tr>
								<{/loop_notopics}>
								<{loop_search_topics}>
								<tr>
									<td colspan=6 class="forum_bgcolor_<{evensearch}>">
										<form action="search.php" method="get" class=form>
											<table>
												<tr>
													<td>
														<input type="hidden" value="f_<{forum_id}>" name="in" />
														<input type="text" size="25" maxlength="50" value="" name="query" />
													</td>
													<td>
														<input type="submit" size="25" maxlength="50" value="Search topics" />
													</td>
												</tr>
											</table>
										</form>
									</td>
								</tr>
								<{/loop_search_topics}>
							</table>
	<table width="100%" height="5"><tr><td align=right><a href="viewforum.php?id=<{forum_id}>&act=markread" class="link2">Mark all topics read</a></td></tr></table>
		<table width=100% cellspacing=0 cellpadding=0 class=category_table>
		<tr><td colspan=4>
		<table width=100% cellpadding=0 cellspacing=0 border=0>
		<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
<td width=100% class=table_1_header><img src="templates/<{template}>/images/arrow_up.gif"> <b>Viewing Statistics</b></td><td align=right class=table_1_header><img src="templates/<{template}>/images/EKINboard_header_right.gif"></td></tr>
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