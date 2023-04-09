						<table width=100% height=50>
							<tr>
								<td valign=middle>
									<a href="index.php"><{page_title}> Home</a> - User Control Panel
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
								<tr><td width=200 valign=top>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=4>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
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
									<td class="row1" onmouseover="this.className='forum1_on';" onmouseout="this.className='row1';" onclick="window.location.href='cp.php'" align=center>
										<a href="cp.php">cPanel Home</a>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Profile Options
									</td>
								</tr>
								<tr>
									<td class="row1" onmouseover="this.className='forum1_on';" onmouseout="this.className='row1';" onclick="window.location.href='cp.php?act=editpro'" align=center>
										<a href="cp.php?act=editpro">Edit Public Profile</a>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Personal Options
									</td>
								</tr>
								<tr>
									<td class="row1" onmouseover="this.className='forum1_on';" onmouseout="this.className='row1';" onclick="window.location.href='cp.php?act=changepass'" align=center>
										<a href="cp.php?act=changepass">Change Password</a>
									</td>
								</tr>
								<tr>
									<td class="row2" onmouseover="this.className='forum2_on';" onmouseout="this.className='row2';" onclick="window.location.href='cp.php?act=changeemail'" align=center>
										<a href="cp.php?act=changeemail">Change E-Mail</a>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Board Settings
									</td>
								</tr>
								<tr>
									<td class="row1" onmouseover="this.className='forum1_on';" onmouseout="this.className='row1';" onclick="window.location.href='cp.php?act=editsig'" align=center>
										<a href="cp.php?act=editsig">Edit Signature</a>
									</td>
								</tr>
								<tr>
									<td class="row2" onmouseover="this.className='forum1_on';" onmouseout="this.className='row2';" onclick="window.location.href='cp.php?act=editavatar'" align=center>
										<a href="cp.php?act=editavatar">Edit Avatar</a>
									</td>
								</tr>
							</table>
								</td><td valign=top>
						<{loop_home}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>cPanel Home</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										User Control Panel
									</td>
								</tr>
								<tr>
									<td class=contentmain>
										Welcome to your control panel!<p>Here you can edit all of your settings, including everything from your public profile, to your email address. Use the menu titled 'Navigation' on your left, to browse around, and change your settings.
									</td>
								</tr>

							</table>
						<{/loop_home}>
						<{loop_edit_pro}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Edit Public Profile</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Edit your profile below
									</td>
								</tr>
								<tr>
									<td class=contentmain align=center>
										<form action=cp.php?act=editpro&step=2 method=POST>
											<table cellpadding=1 cellspacing=0 width="100%">
												<tr>
													<td colspan="2" class="row2" align="center">
														<table cellspacing="0" cellpadding=0 class="legend_1">
															<tr>
																<td class=redtable_content colspan=2>
																	<span class="error">This feature is not fully functional</span>
																</td>
															</tr>
															<tr>
																<td class=redtable_content width="150">
																	Display Name: 
																</td>
																<td valign=middle class=redtable_content>
																	<input class=text type=text size="25" maxlength="64" name=display_name value="<{display_name}>">
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td height="10"></td>
												</tr>

												<tr>
													<td class="row1" valign=middle>
														Website URL: 
													</td>
													<td>
														<input type=text class=textbox name=website size=30 maxlength=45 value="<{website}>">
													</td>
												</tr>
												<tr>
													<td class="row1" valign=middle>
														AIM Screen Name: 
													</td>
													<td>
														<input type=text class=textbox name=aimsn size=30 maxlength=45 value="<{aim_sn}>">
													</td>
												</tr>
												<tr>
													<td class="row1" valign=middle>
														MSN Messenger SN: 
													</td>
													<td>
														<input type=text class=textbox name=msnsn size=30 maxlength=45 value="<{msn_sn}>">
													</td>
												</tr>
												<tr>
													<td class="row1" valign=middle>
														Yahoo Messenger SN: 
													</td>
													<td>
														<input type=text class=textbox name=yahoosn size=30 maxlength=45 value="<{yim_sn}>">
													</td>
												</tr>
												<tr>
													<td class="row1" valign=middle>
														ICQ Number: 
													</td>
													<td>
														<input type=text class=textbox name=icq size=30 maxlength=45 value="<{icq_sn}>">
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td colspan=5 class=table_bottom align="center">
											<input type=submit value="Update > >">
										</td>
									</tr>
								</table>
							</form>
						<{/loop_edit_pro}>
						<{loop_change_pass}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Change Password</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Change current password
									</td>
								</tr>
								<tr>
									<td class=contentmain align=center>
										<span class="error">Warning: After your password has been changed you will be logged out, and will need to log back in again.</span>
									</td>
								</tr>
								<tr>
									<td class=contentmain align=center>
										<form action=cp.php?act=changepass&step=2 method=POST>
														<table cellspacing="0" class="legend_<{old_pass_error}>" width=100%>
															<tr>
																<td colspan=2 class=redtable_content>
																	<span class="error"><{old_pass_error_message}></span>
																</td>
															</tr>
															<tr>
																<td valign=middle width=50% class=contentmain>
																	Old Password: 
																</td>
																<td valign=middle width=50%>
																	<input type=password class=textbox name=old_pass size=30 value="<{submitted_old_pass}>">
																</td>
															</tr>
														</table>
														<table width=100% height=2>
															<tr>
																<td>
																</td>
															</tr>
														</table>
														<table cellspacing="0" class="legend_<{new_pass_error}>" width=100%>
															<tr>
																<td colspan=2 class=redtable_content>
																	<span class="error"><{new_pass_error_message}></span>
																</td>
															</tr>
															<tr>
																<td valign=middle width=50% class=contentmain>
																	New Password: 
																</td>
																<td valign=middle width=50%>
																	<input type=password class=textbox name=new_pass size=30 maxlength=55 value="<{submitted_new_pass}>">
																</td>
															</tr>
														</table>
														<table width=100% height=2>
															<tr>
																<td>
																</td>
															</tr>
														</table>
														<table cellspacing="0" class="legend_<{confirm_error}>" width=100%>
															<tr>
																<td colspan=2 class=redtable_content>
																	<span class="error"><{confirm_error_message}></span>
																</td>
															</tr>
															<tr>
																<td valign=middle width=50% class=contentmain>
																	Confirm New Password: 
																</td>
																<td valign=middle width=50%>
																	<input type=password class=textbox name=confirm size=30 maxlength=55 value="<{submitted_confirm}>">
																</td>
															</tr>
														</table>
										</td>
									</tr>
									<tr>
										<td colspan=5 class=table_bottom align="center">
											<input type=submit value="Change">
										</td>
									</tr>
								</table>
							</form>
						<{/loop_change_pass}>
						<{loop_pass_changed}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Change Password</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Change your password
									</td>
								</tr>
								<tr>
									<td class=contentmain align=center>
									<span class="error">Your password has been changed!</span>
									</td>
								</tr>
							</table>
						<{/loop_pass_changed}>
						<{loop_change_email}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Change E-Mail Address</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Change your e-mail address
									</td>
								</tr>
								<tr>
									<td class=contentmain align=center>
										<span class="error">NOTE: You will need to re-activate the new e-mail address.</span><p>
										<form action=cp.php?act=changeemail&step=2 method=POST>
											<table width=80%><tr><td>
														<table cellspacing="0" class="legend_<{password_error}>" width=100%>
															<tr>
																<td colspan=2 class=redtable_content>
																	<span class="error"><{password_error_message}></span>
																</td>
															</tr>
															<tr>
																<td valign=middle width=50% class=contentmain>
																	Your Password: 
																</td>
																<td valign=middle width=50%>
																	<input type=password class=textbox name=password size=30 value="<{submitted_password}>">
																</td>
															</tr>
														</table>
														<table width=100% height=2>
															<tr>
																<td>
																</td>
															</tr>
														</table>
														<table cellspacing="0" class="legend_<{old_email_error}>" width=100%>
															<tr>
																<td colspan=2 class=redtable_content>
																	<span class="error"><{old_email_error_message}></span>
																</td>
															</tr>
															<tr>
																<td valign=middle width=50% class=contentmain>
																	Old E-mail Address: 
																</td>
																<td valign=middle width=50%>
																	<input type=text class=textbox name=old_email size=30 maxlength=55 value="<{submitted_old_email}>">
																</td>
															</tr>
														</table>
														<table width=100% height=2>
															<tr>
																<td>
																</td>
															</tr>
														</table>
														<table cellspacing="0" class="legend_<{new_email_error}>" width=100%>
															<tr>
																<td colspan=2 class=redtable_content>
																	<span class="error"><{new_email_error_message}></span>
																</td>
															</tr>
															<tr>
																<td valign=middle width=50% class=contentmain>
																	New E-mail Address: 
																</td>
																<td valign=middle width=50%>
																	<input type=text class=textbox name=new_email size=30 maxlength=55 value="<{submitted_new_email}>">
																</td>
															</tr>
														</table>
														<table width=100% height=2>
															<tr>
																<td>
																</td>
															</tr>
														</table>
														<table cellspacing="0" class="legend_<{email_confirm_error}>" width=100%>
															<tr>
																<td colspan=2 class=redtable_content>
																	<span class="error"><{email_confirm_error_message}></span>
																</td>
															</tr>
															<tr>
																<td valign=middle width=50% class=contentmain>
																	Confirm New Email Address: 
																</td>
																<td valign=middle width=50%>
																	<input type=text class=textbox name=confirm_email size=30 maxlength=55 value="<{submitted_email_confirm}>">
																</td>
															</tr>
														</table>
											</table>
										</td>
									</tr>
									<tr>
										<td colspan=5 class=table_bottom align="center">
											<input type=submit value="Change">
										</td>
									</tr>
								</table>
							</form>
						<{/loop_change_email}>
						<{loop_email_notice}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Change Password</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Change your e-mail address
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
												<td class="redtable_content" align=center>
													<{notice_message}>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						<{/loop_email_notice}>
						<{loop_edit_sig}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Edit Signature</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Current Signature
									</td>
								</tr>
								<tr>
									<td class=contentmain>
										<{current_sig}>
									</td>
								</tr>
								<tr>
									<td class=table_subheader>
										Edit
									</td>
								</tr>
								<tr>
									<td class=post_table_bottom align=center>
										<a href=javascript:add_smilie('[b][/b]')><img src="templates/<{template}>/images/bold_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[i][/i]')><img src="templates/<{template}>/images/italics_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[u][/u]')><img src="templates/<{template}>/images/underlined_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[url=][/url]')><img src="templates/<{template}>/images/hyperlink_btn.gif" border="0" alt=""></a>
										<a href=javascript:add_smilie('[img=]')><img src="templates/<{template}>/images/image_btn.gif" border="0" alt=""></a>
									</td>
								</tr>
								<tr>
									<td class=contentmain align=center>
										<script language='javascript'>
											<!--
											function add_smilie(code)
											{
												document.form.signature.value += code;
												//return true;	
											}
											//-->
										</script>
										<a href=javascript:add_smilie(':)')><img alt="smilie for :)" title=":)" src=templates/<{template}>/images/smilies/excited.gif border=0></a>
										<a href=javascript:add_smilie(':(')><img alt="smilie for :(" title=":(" src=templates/<{template}>/images/smilies/dissapointed.gif border=0></a>
										<a href=javascript:add_smilie(':P')><img alt="smilie for :P" title=":P" src=templates/<{template}>/images/smilies/tongue.gif border=0></a>
										<a href=javascript:add_smilie(':D')><img alt="smilie for :D" title=":D" src=templates/<{template}>/images/smilies/grin.gif border=0></a>
										<a href=javascript:add_smilie(':O')><img alt="smilie for :O" title=":O" src=templates/<{template}>/images/smilies/shocked.gif border=0></a>
										<a href=javascript:add_smilie(':sad:')><img alt="smilie for :sad:" title=":sad:" src=templates/<{template}>/images/smilies/sad.gif border=0></a>
										<a href=javascript:add_smilie('-.-')><img alt="smilie for -.-" title="-.-" src=templates/<{template}>/images/smilies/closedeyes.gif border=0></a>
										<a href=javascript:add_smilie('o.o')><img alt="smilie for o.o" title="o.o" src=templates/<{template}>/images/smilies/bigeyes.gif border=0></a>
										<a href=javascript:add_smilie(':sleep:')><img alt="smile for :sleep:" title=":sleep:" src=templates/<{template}>/images/smilies/sleeping.gif border=0></a>
									</td>
								</tr>
								<tr>
									<td class=contentmain align=center>
										<form name=form action=cp.php?act=editsig&step=2 method=post>
											<textarea class="text" name="signature" cols="70" rows="10"><{current_sig_code}></textarea>
									</td>
								</tr>
									</td>
								</tr>
								<tr>
									<td class=table_bottom align=center>
										<input type="submit" value="Update > >" class="button">
									</td>
								</tr>
							</table>
						<{/loop_edit_sig}>
						<{loop_edit_avatar}>
							<table width=100% cellspacing=0 cellpadding=0 class=category_table>
								<tr>
									<td colspan=5>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=45>
													<img src="templates/<{template}>/images/EKINboard_header_left.gif"></td>
												<td width=100% class=table_1_header>
													<img src="templates/<{template}>/images/arrow_up.gif"> <b>Edit Avatar</b>
												</td>
												<td align=right class=table_1_header>
													<img src="templates/<{template}>/images/EKINboard_header_right.gif"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=table_subheader colspan="2">
										Current Avatar
									</td>
								</tr>
								<tr>
									<td class=contentmain align="center" colspan="2">
										<{current_ava}>
									</td>
								</tr>
								<tr>
									<td class=table_subheader colspan="2">
										Edit
									</td>
								</tr>
								<tr>
									<td class=row1>
										<b>Link:</b>
									</td>
									<td class=row1 align=center>
										<form name=form action=cp.php?act=editavatar&step=2 method=post  enctype="multipart/form-data">
											<input class="text" type="text" name="avatar_link" value="<{current_ava_address}>" size="50">
									</td>
								</tr>
								<{loop_upload_avatar}>
								<tr>
								<td class=row1>
									<b>Upload Avatar:</b>
								</td>
								<td class=row1 align=center>
										<input class="text" name="upload_avatars" type="file" size="38">
								</td>
								</tr>
								<{/loop_upload_avatar}>							
								<tr>
									<td class=row2>
										<b>Avatar Title:</b>
									</td>
									<td class=row2 align=center>
											<input class="text" type="text" name="avatar_alt" value="<{current_ava_alt}>" size="50">
									</td>
								</tr>
									</td>
								</tr>
								<tr>
									<td class=table_bottom align=center colspan="2">
										<input type="submit" value="Update > >" class="button">
									</td>
								</tr>
							</table>
						<{/loop_edit_avatar}>
						<{loop_error}>
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
					</td>
				</tr>
			</table>
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