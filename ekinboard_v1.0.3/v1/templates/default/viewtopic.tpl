						<table width=100% height=50>
							<tr>
								<td valign=middle>
									<a href="index.php"><{site_title}> Home</a> - <a href="index.php?cid=<{cat_id}>"><{cat_name}></a> - <a href="viewforum.php?id=<{forum_id}>"><{forum_name}></a> - <{topic_title}>
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
						<{/loop_news}>
						<table width=100% height=10>
							<tr>
								<td>
								</td>
							</tr>
						</table>
						<{loop_member_buttons}>
							<table width=100% cellpadding=2 cellspacing=0 border=0>
								<tr>
									<td width="100%" valign="middle">
									</td>
									<{loop_locked}>
										<td width="94">
											<img src="templates/<{template}>/images/locked_btn.gif" border="0" alt=""></td>
									<{/loop_locked}>
									<{loop_post_reply}>
										<td width="94">
											<a href="postreply.php?id=<{topic_id}>"><img src="templates/<{template}>/images/postreply_btn.gif" border="0" alt=""></a></td>
									<{/loop_post_reply}>
									<{loop_new_topic}>
										<td width="94">
											<a href="newtopic.php?id=<{forum_id}>"><img src="templates/<{template}>/images/newtopic_btn.gif" border="0" alt=""></a></td>
									<{/loop_new_topic}>
									<{loop_new_poll}>
										<td width="94">
											<a href="newpoll.php?id=<{forum_id}>"><img src="templates/<{template}>/images/newpoll_btn.gif" border="0" alt=""></a></td>
									<{/loop_new_poll}>
								</tr>
							</table>
						<{/loop_member_buttons}>
						<{loop_topic}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=2>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b><{title}></b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<{loop_poll}>
									<tr>
										<td colspan=2 class=table_subheader>
											Poll
										</td>
									</tr>
									<tr>
										<{loop_poll_vote}>
											<td colspan=2 valign=top align=center class=contentmain>
												<form method="post" action="viewtopic.php?id=<{topic_id}>">
													<table cellpadding=0 cellspacing=0 border=0 width=100%>
														<tr>
															<td colspan=2 valign=top>
																<b><{poll_question}></b> ( <a href="viewtopic.php?id=<{topic_id}>&poll=results" class=link2>View Results</a> )
															</td>
														</tr>
														<tr>
															<td valign=top>
																<table width=100%>
																	<{loop_poll_vote_choice}>
																		<tr>
																			<td valign=top width=10>
																				<input type="radio" name="poll_vote" value="<{poll_choice_value}>" id="<{poll_choice_value}>">
																			</td>
																			<td class="row<{evenchoice}>" onmouseover="this.className='forum<{evenchoice}>_on';" onmouseout="this.className='row<{evenchoice}>';">
																				<label for="<{poll_choice_value}>"><{poll_choice}></label>
																			</td>
																		</tr>
																	<{/loop_poll_vote_choice}>
																</table>
															</td>
														</tr>
														<tr>
															<td class=table_bottom align=center colspan=2>
																<input type="submit" value="Vote > >" class="button">
															</td>
														</tr>
													</table>
												</form>
											</td>
										<{/loop_poll_vote}>
										<{loop_poll_results}>
											<td colspan=2 valign=top align=center>
												<table cellpadding=0 cellspacing=0 border=0 width=100%>
													<tr>
														<td valign=top align=center class=contentmain>
															<table cellpadding=0 cellspacing=0 border=0>
																<tr>
																	<td colspan=4 valign=top>
																		<b><{poll_question}></b>
																	</td>
																</tr>
																<{loop_poll_results_choice}>
																	<tr>
																		<td valign=top class="row<{evenchoice}>">
																			<{poll_choice}>
																		</td>
																		<td class="row<{evenchoice}>" valign=top>
																			<b>[<{poll_choice_votes}>]</b>
																		</td>
																		<td width=203 class="row<{evenchoice}>" valign=top>
																			<img src="templates/<{template}>/images/bar_left.gif" border="0" alt=""><img src="templates/<{template}>/images/bar_stretch.gif" border="0" alt="" width="<{poll_bar_width}>" height="18"><img src="templates/<{template}>/images/bar_right.gif" border="0" alt="">
																		</td>
																		<td class="row<{evenchoice}>" valign=top>
																			 ( <{poll_choice_percent}>% )
																		</td>
																	</tr>
																<{/loop_poll_results_choice}>
																<tr>
																	<td colspan=4 align=center>
																		<{poll_notice}>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										<{/loop_poll_results}>
									</tr>
								<{/loop_poll}>
								<tr>
									<td colspan=2 class=table_subheader>
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td align="left">
														<{date}>
													</td>
													<td align="right">
														<a href="print.php?id=<{topic_id}>" class="link2"><span class=small>Print Topic</span></a>
													</td>
												</tr>
											</table>
									</td>
								</tr>
								<tr>
									<td height=100% valign=top class=mini_profile_table>
										<table width=200>
											<tr>
												<td>
													<a href="profile.php?id=<{poster_id}>"><{poster}></a>
													<{member_title}>
													<{user_voting}>
													<p><{poster_avatar}>
													Group: <{level}><br>
													Posts: <{posts}><br>
													Joined: <{member_joined}><br>
													Member No.: <{member_number}>
												</td>
											</tr>
										</table>
									</td>
									<td valign=top class=contentmain width=100%>
										<{message}>
										<{loop_topic_attch}>
										<table height=10>
											<tr>
												<td></td>
											</tr>
										</table>
										<table width="50%" class="greytable">
											<tr>
												<td class="greytable_header" colspan="2">
														Attachment
												</td>
											</tr>
											<tr>
												<td class="greytable_content" valign="middle">
														<img src="templates/<{template}>/images/file_type_<{attch_type}>.gif" border="0">
												</td>
												<td class="greytable_content" valign="middle" width=100%>
														<a href="uploaded/attachments/<{attch_name}>" class="link2"><{attch_name}></a> ( <{attch_size}>kb )
												</td>
											</tr>
										</table>
										<{/loop_topic_attch}>
										<{loop_topic_sig}>
											<p>----<br><{sig}>
										<{/loop_topic_sig}>
									</td>
								</tr>
								<tr colspan=2>
									<td colspan=2 class=post_table_bottom align="right">
											<table cellspacing=0 cellpadding=0>
												<tr>
													<{loop_stick_topic}>
														<td valign=top>
															<a href="viewtopic.php?id=<{id}>&stick=<{sticky}>"><img src="templates/<{template}>/images/stick_btn_<{sticky}>.gif" alt="" border="0"></a>
														</td>
													<{/loop_stick_topic}>
													<{loop_lock_topic}>
														<td valign=top>
															<a href="viewtopic.php?id=<{id}>&lock=<{locked}>"><img src="templates/<{template}>/images/lock_btn_<{locked}>.gif" alt="" border="0">
														</td>
													<{/loop_lock_topic}>
													<{loop_move_topic}>
														<td valign=top>
															<a href="viewtopic.php?act=move&id=<{id}>"><img src="templates/<{template}>/images/move_btn.gif" alt="" border="0"></a>
														</td>
													<{/loop_move_topic}>
													<{loop_delete_topic}>
														<td valign=top>
															<a href="viewtopic.php?delete=topic&id=<{id}>"><img src="templates/<{template}>/images/delete_btn.gif" alt="" border="0"></a>
														</td>
													<{/loop_delete_topic}>
													<{loop_edit_topic}>
														<td valign=top>
															<a href="edit.php?act=et&id=<{id}>"><img src="templates/<{template}>/images/edit_btn.gif" alt="" border="0"></a>
														</td>
													<{/loop_edit_topic}>
													<{loop_quote_topic}>
														<td valign=top>
															<a href="postreply.php?id=<{topic_id}>&qt=<{id}>"><img src="templates/<{template}>/images/quote_btn.gif" alt="" border="0"></a>
														</td>
													<{/loop_quote_topic}>
												</tr>
											</table>
									</td>
								</tr>
							</table>
						<{/loop_topic}>
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
														<a href="viewtopic.php?id=<{id}>&page=<{page_num}>">«</a>
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
														<a href="viewtopic.php?id=<{id}>&page=<{page_num}>"><{page_num}></a>
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
														<a href="viewtopic.php?id=<{id}>&page=<{page_num}>">»</a>
													</td>
												</tr>
											</table>
										</td>
									<{/loop_last_page}>
								</tr>
							</table>
						<{/loop_pages}>
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
													<b>Replies</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<{loop_reply}>
									<tr>
										<td colspan=2 class=table_subheader>
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td align="left">
														<{date}><a name="<{id}>"></a>
													</td>
													<td align="right">
														<a href="viewtopic.php?id=<{topic_id}>&page=<{post_page}>#<{id}>" class="link2"><span class=small>#<{post_num}></span></a>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td height=100% valign=top class="mini_profile_table">
											<table width=200>
												<tr>
													<td>
														<a href="profile.php?id=<{poster_id}>"><{poster}></a>
														<{member_title}>
														<{user_voting}>
														<p><{poster_avatar}>
														Group: <{level}><br>
														Posts: <{posts}><br>
														Joined: <{member_joined}>
													</td>
												</tr>
											</table>
										</td>
										<td valign=top class=contentmain width=100%>
											<{message}>
											<{loop_reply_sig}>
												<p><br><p>----<br><{sig}>
											<{/loop_reply_sig}>
										</td>
									</tr>
									<tr>
										<td colspan=2 class=post_table_bottom align="right">
												<table cellspacing=0 cellpadding=0 border=0>
													<tr>
														<{loop_delete_reply}>
															<td valign=top>
																<a href="viewtopic.php?delete=reply&id=<{id}>"><img src="templates/<{template}>/images/delete_btn.gif" alt="" border="0"></a>
															</td>
														<{/loop_delete_reply}>
														<{loop_edit_reply}>
															<td valign=top>
																<a href="edit.php?act=er&id=<{id}>"><img src="templates/<{template}>/images/edit_btn.gif" alt="" border="0"></a>
															</td>
														<{/loop_edit_reply}>
														<{loop_quote_reply}>
														<td valign=top>
															<a href="postreply.php?id=<{topic_id}>&qr=<{id}>"><img src="templates/<{template}>/images/quote_btn.gif" alt="" border="0"></a>
														</td>
														<{/loop_quote_reply}>
													</tr>
												</table>
										</td>
									</tr>
								<{/loop_reply}>
							</table>
						<{/loop_replies}>
						<{loop_member_buttons}>
							<table width=100% cellpadding=0 cellspacing=0 border=0>
								<tr>
									<td width="100%" valign="middle">
									</td>
									<{loop_locked}>
										<td width="94">
											<img src="templates/<{template}>/images/locked_btn.gif" border="0" alt=""></td>
									<{/loop_locked}>
									<{loop_post_reply}>
										<td width="94">
											<a href="postreply.php?id=<{topic_id}>"><img src="templates/<{template}>/images/postreply_btn.gif" border="0" alt=""></a></td>
									<{/loop_post_reply}>
									<{loop_new_topic}>
										<td width="94">
											<a href="newtopic.php?id=<{forum_id}>"><img src="templates/<{template}>/images/newtopic_btn.gif" border="0" alt=""></a></td>
									<{/loop_new_topic}>
									<{loop_new_poll}>
										<td width="94">
											<a href="newpoll.php?id=<{forum_id}>"><img src="templates/<{template}>/images/newpoll_btn.gif" border="0" alt=""></a></td>
									<{/loop_new_poll}>
								</tr>
							</table>
						<{/loop_member_buttons}>
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
														<a href="viewtopic.php?id=<{id}>&page=<{page_num}>">«</a>
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
														<a href="viewtopic.php?id=<{id}>&page=<{page_num}>"><{page_num}></a>
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
														<a href="viewtopic.php?id=<{id}>&page=<{page_num}>">»</a>
													</td>
												</tr>
											</table>
										</td>
									<{/loop_last_page}>
								</tr>
							</table>
						<{/loop_pages}>
						<{loop_move}>
							<table width="100%" height="10">
								<tr>
									<td>
									</td>
								</tr>
							</table>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=4>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Move topic</b></td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr class=table_subheader>
									<td align=left class=table_subheader>	
										Where would you like to move this topic to?
									</td>
								</tr>
								<tr>
									<td class=contentmain align=center>
										<table cellspacing="0" cellpadding="0" align="center">
											<tr>
												<td>
													<form action="viewtopic.php?id=<{topic_id}>&act=move" method="POST">
													<b>Select Forum: </b>
														<select name="fid" size="1">
														<option value="">Choose Forum..</option>
				
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
									<td class=table_bottom align="center">
										<input type="submit" name="move" value="Move > >">
									</td>
								</tr>
							</table>
							</form>
						<{/loop_move}>
						<{loop_delete}>
							<table width="100%" height="10">
								<tr>
									<td>
									</td>
								</tr>
							</table>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=4>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Delete</b></td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr class=table_subheader>
									<td align=left class=table_subheader>	
										Are you sure you would like to delete this <{delete_type}>?
									</td>
								</tr>
								<tr>
									<td class=contentmain align=center>
										<table cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td class="redtable" align=center width=100>
													<a href="viewtopic.php?delete=<{delete_type}>&id=<{id}>&sure=yes" class=link2>Yes</a>
												</td>
												<td width=20></td>
												<td class="bluetable" align=center width=100>
													<a href="javascript:history.go(-1)" class=link2>No</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						<{/loop_delete}>
						<{loop_error}>
							<table width="100%" height="10">
								<tr>
									<td>
									</td>
								</tr>
							</table>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=4>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
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
						<table width="100%" height="10">
							<tr>
								<td>
								</td>
							</tr>
						</table>
						<table width=100% cellspacing=0 cellpadding=0 class=category_table>
						<tr>
							<td colspan=4>
								<table width=100% cellpadding=0 cellspacing=0 border=0>
									<tr>
										<td width=45>
											<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
										<td width=100% class=table_1_header>
											<img src="templates/<{template}>/images/arrow_up.gif"> <b>Viewing Statistics</b>
										</td>
										<td align=right class=table_1_header>
											<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr class=table_subheader>
							<td align=left class=table_subheader>
								<b><{total_active_users}></b> user(s) active in this topic in the past 15 minutes
							</td>
						</tr>
						<tr>
							<td class=contentmain>
								<table width=100%>
									<tr>
										<td width=45>
											<img src="templates/<{template}>/images/online_icon.gif"></td>
										<td>
											<b><{total_active_guests}></b> guest(s), <b><{total_active_members}></b> member(s)<p>
											<{loop_user_online}>
												<a href="profile.php?id=<{online_id}>" class="link_user_<{online_posting}>"><{online_user}></a><img src="templates/<{template}>/images/EKINboard_icon_<{online_level}>.gif"><{spacer}>&nbsp;
											<{/loop_user_online}>
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
	</body>
</html>