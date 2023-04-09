						<table width="100%" height="50">
							<tr>
								<td valign="middle">
									<a href="index.php"><{page_title}> Home</a> - Search
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
						<table width=100% cellspacing=0 cellpadding=0 class=category_table>
							<tr class=table_1_header>
								<td colspan=4>
									<table width=100% cellpadding=0 cellspacing=0 border=0>
										<tr>
											<td width=100% class=table_1_header>
												<img src="templates/<{template}>/images/arrow_up.gif" border="0" name="category_<{id}>" alt="0"> <b>Search</b></td>
											<td align=right class=table_1_header>
												<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td class=table_subheader>
									Enter your search criteria
								</td>
							</tr>
							<tr>
								<td colspan=4 align=center>
									<script language="javascript">
									function desableButton(){
										document.Form.submit.disabled=true;
									}
									</script>
										<form action="search.php" method="get" class=form name="Form" onSubmit="desableButton()">
											<table>
												<tr>
													<td>
														Keyword:
													</td>
													<td>
														<input type="text" size="25" maxlength="50" value="<{search_query}>"  name="query" />
													</td>
												</tr>
												<tr>
													<td>
														Search in forum:
													</td>
													<td>
														<select name="in">
															<option value="all">All Forums

															<{loop_dropdown}>
																<{dropdown_list}>
															<{/loop_dropdown}>
				
														</select>
													</td>
												</tr>
											</table>
									</td>
								</tr>
								<tr>
									<td class=table_bottom colspan=4 align=center>
										<input type="submit" size="25" maxlength="50" value="Search topics" name="submit" />
									</td>
								</tr>
							</table>
						</form>
						<{loop_result_stats}>
							<table width=100% height=10>
								<tr>
									<td>
									</td>
								</tr>
							</table>
							<span class="hilight"><{total_results}></span> Results Returned ( <{topic_results}> Topics, <{reply_results}> Replies )
						<{/loop_result_stats}>
						<{loop_pages}>
							<table width=100% height=10>
								<tr>
									<td>
									</td>
								</tr>
							</table>
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
														<a href="search.php?query=<{search_query}>&page=<{page_num}>">«</a>
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
														<a href="search.php?query=<{search_query}>&page=<{page_num}>"><{page_num}></a>
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
														<a href="search.php?query=<{search_query}>&page=<{page_num}>">»</a>
													</td>
												</tr>
											</table>
										</td>
									<{/loop_last_page}>
								</tr>
							</table>
						<{/loop_pages}>
						<{loop_result}>
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
													<img src="templates/<{template}>/images/arrow_up.gif"> <b><a href="viewtopic.php?id=<{topic_id}>" class="topic_link"><{title}></a></b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan=2 class=table_subheader>
										<{date}>
									</td>
								</tr>
								<tr>
									<td height=100% valign=top class=mini_profile_table>
										<table width=200>
											<tr>
												<td>
													<a href="profile.php?id=<{poster_id}>"><{poster}></a><br>
													<{member_title}><p>
													Group: <{level}><br>
													Posts: <{posts}><br>
													Joined: <{member_joined}><br>
													Member No.: <{member_number}>
												</td>
											</tr>
										</table>
									</td>
									<td valign=top class=contentmain width=100%>
										<div style='height:200px;overflow:auto'>
										<{message}>
										</div>
									</td>
								</tr>
							</table>
						<{/loop_result}>
						<{loop_pages}>
							<table width=100% height=10>
								<tr>
									<td>
									</td>
								</tr>
							</table>
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
														<a href="search.php?query=<{search_query}>&page=<{page_num}>">«</a>
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
														<a href="search.php?query=<{search_query}>&page=<{page_num}>"><{page_num}></a>
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
														<a href="search.php?query=<{search_query}>&page=<{page_num}>">»</a>
													</td>
												</tr>
											</table>
										</td>
									<{/loop_last_page}>
								</tr>
							</table>
						<{/loop_pages}>
	<table width="100%" height="10"><tr><td></td></tr></table>
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
