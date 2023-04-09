						<table width=100% height=50>
							<tr>
								<td valign=middle>
									<a href="index.php"><{page_title}> Home</a> - Member List
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
														<a href="memberlist.php?page=<{page_num}>">«</a>
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
														<a href="memberlist.php?page=<{page_num}>"><{page_num}></a>
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
														<a href="memberlist.php?page=<{page_num}>">»</a>
													</td>
												</tr>
											</table>
										</td>
									<{/loop_last_page}>
								</tr>
							</table>
						<{/loop_pages}>
						<{loop_letters}>
							<table>
								<tr>
									<{loop_letter}>
										<td class="padding">
											<table class="pagetable_<{current_letter}>">
												<tr>
													<td>
														<a href="memberlist.php?s=<{letter}>"><{letter}></a>
													</td>
												</tr>
											</table>
										</td>
									<{/loop_letter}>
									<td class="padding">
										<table>
											<tr>
												<td>
													( <a href="memberlist.php">View All</a> )
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						<{/loop_letters}>
						<{loop_member_list}>
							<table width=100% height=10>
								<tr>
									<td>
									</td>
								</tr>
							</table>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr class=table_1_header>
									<td colspan=6>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Members</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr class=table_subheader>
									<td align=left class=table_subheader>
										<a href="memberlist.php?sort=username" class=link2>Username</a>
									</td>
									<td width=100 align=center class=table_subheader>
										Rating
									</td>
									<td width=100 align=center class=table_subheader>
										Level
									</td>
									<td width=150 align=center class=table_subheader>
										<a href="memberlist.php?sort=group" class=link2>Group</a>
									</td>
									<td width=150 align=center class=table_subheader>
										<a href="memberlist.php?sort=joined" class=link2>Joined</a>
									</td>
									<td width=50 align=center class=table_subheader>
										Posts
									</td>
								</tr>
								<{loop_members}>
									<tr>
										<td class="row<{even_member}>"  onmouseover="this.className='member<{even_member}>_on';" onmouseout="this.className='row<{even_member}>';" onclick="window.location.href='profile.php?id=<{member_id}>'">
											<a href="profile.php?id=<{member_id}>"><{member_name}></a>
										</td>
										<td align=center class="row<{even_member}>">
											<{vote_img}>
										</td>
										<td align=center class="row<{even_member}>">
											<img src="templates/<{template}>/images/level_<{member_level}>.gif">
										</td>
										<td align=center class="row<{even_member}>">
											<{member_group}>
										</td>
										<td align=center class="row<{even_member}>">
											<{member_joined}>
										</td>
										<td align=center class="row<{even_member}>">
											<{member_posts}>
										</td>
									</tr>
								<{/loop_members}>
							</table>
						<{/loop_member_list}>
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