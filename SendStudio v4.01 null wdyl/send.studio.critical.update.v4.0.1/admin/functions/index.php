<?

	if($Page == "Error")
	{
		$OUTPUT .= MakeErrorBox("Access Denied", "<br>You do not have access to the task that you have just selected.");
	}

	if(!$Page)
	{
		if($CURRENTADMIN["Root"] == 1 && $CURRENTADMIN["Manager"] == 1)
		{
			$canCreateList = true;
		}
		else
		{
			$lists = @mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists INNER JOIN " . $TABLEPREFIX . "allow_lists ON " . $TABLEPREFIX . "lists.ListID = " . $TABLEPREFIX . "allow_lists.ListID WHERE " . $TABLEPREFIX . "allow_lists.AdminID = " . $CURRENTADMIN["AdminID"] . " ORDER BY " . $TABLEPREFIX . "lists.ListName DESC");

			$maxLists = $CURRENTADMIN["MaxLists"];
			$numLists = @mysql_num_rows($lists);
			$numListsLeft = (int)$maxLists - (int)$numLists;

			if($numListsLeft > 0 || $maxLists == 0)
				$canCreateList = true;
			else
				$canCreateList = false;
		}
		
		$OUTPUT .= '

			<table width="96%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lc.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/tbg.gif"><font size=1>&nbsp;</td></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rc.gif" width="11" height="20"></td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lc.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/tbg.gif"><font size=1>&nbsp;</font></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rc.gif" width="11" height="20"></td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lc.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/tbg.gif"><font size=1>&nbsp;</font></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rc.gif" width="11" height="20"></td>
				</tr>
				<tr>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/lm.gif">&nbsp;</td>
					<td width="33%" height="20" bgcolor="#F7F7F7" valign="top">
						<img src="' . $ROOTURL . 'admin/images/m_news.gif" width="35" height="27" hspace="10" align="left">
						<span class="heading2">Manage Newsletters</span>
						<ul style="margin-left:80">
							<li>';
			
								if(AllowSection(11))
									$OUTPUT .= '<a href="' . MakeAdminLink("compose") . '">View newsletters</a>';
								else
									$OUTPUT .= '<span class="disabled">View newsletters</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(11))
									$OUTPUT .= '<a href="' . MakeAdminLink("compose?Action=Add") . '">Create a new newsletter</a>';
								else
									$OUTPUT .= '<span class="disabled">Create a new newsletter</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(12))
									$OUTPUT .= '<a href="' . MakeAdminLink("send") . '">Send newsletter</a>';
								else
									$OUTPUT .= '<span class="disabled">Send newsletter</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(8))
									$OUTPUT .= '<a href="' . MakeAdminLink("customfields") . '">Custom subscriber fields</a>';
								else
									$OUTPUT .= '<span class="disabled">Custom subscriber fields</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(15))
									$OUTPUT .= '<a href="' . MakeAdminLink("images") . '">Image manager</a>';
								else
									$OUTPUT .= '<span class="disabled">Image manager</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(9))
									$OUTPUT .= '<a href="' . MakeAdminLink("links") . '">Link manager</a>';
								else
									$OUTPUT .= '<span class="disabled">Link manager</span>';
								
								$OUTPUT .= '
							</li>
						</ul>
					</td>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/rm.gif">&nbsp;</td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/lm.gif">&nbsp;</td>
					<td width="33%" height="20" bgcolor="#F7F7F7" valign="top">
						<img src="' . $ROOTURL . 'admin/images/m_subs.gif" width="35" height="41" hspace="10" align="left">
						<span class="heading2">Manage Subscribers</span>
						<ul style="margin-left:80">
							<li>';
			
								if(AllowSection(1))
									$OUTPUT .= '<a href="' . MakeAdminLink("members") . '">View subscribers</a>';
								else
									$OUTPUT .= '<span class="disabled">View subscribers</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(6))
									$OUTPUT .= '<a href="' . MakeAdminLink("banned") . '">View banned subscribers</a>';
								else
									$OUTPUT .= '<span class="disabled">View banned subscribers</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(4))
									$OUTPUT .= '<a href="' . MakeAdminLink("import") . '">Import subscribers</a>';
								else
									$OUTPUT .= '<span class="disabled">Import subscribers</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(16))
									$OUTPUT .= '<a href="' . MakeAdminLink("addsub") . '">Add subscribers via form</a>';
								else
									$OUTPUT .= '<span class="disabled">Add subscribers via form</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(5))
									$OUTPUT .= '<a href="' . MakeAdminLink("export") . '">Export subscribers</a>';
								else
									$OUTPUT .= '<span class="disabled">Export subscribers</span>';
								
								$OUTPUT .= '
							</li>
						</ul>
					</td>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/rm.gif">&nbsp;</td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/lm.gif">&nbsp;</td>
					<td width="33%" height="20" bgcolor="#F7F7F7" valign="top">
						<img src="' . $ROOTURL . 'admin/images/m_stats.gif" width="35" height="38" hspace="10" align="left">
						<span class="heading2">Quick Stats</span>
						<ul style="margin-left:80">';

							$yesterday = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
							$lastWeek = mktime(0, 0, 0, date("m"), date("d")-7, date("Y"));
							$lastMonth = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));
							$lastYear = mktime(0, 0, 0, date("m"), date("d"), date("Y")-1);

							if($CURRENTADMIN["Manager"] == 1)
							{
								$totalSubs = @mysql_result(@mysql_query("select count(*) from " . $TABLEPREFIX . "members"), 0, 0);
								$Lists = "";
								$totalLists = @mysql_result(@mysql_query("select count(*) from " . $TABLEPREFIX . "lists"), 0, 0);

								$newToday = mysql_result(mysql_query("select count(*) from " . $TABLEPREFIX . "members where SubscribeDate >= '$yesterday'"), 0, 0);
								$newWeek = mysql_result(mysql_query("select count(*) from " . $TABLEPREFIX . "members where SubscribeDate >= '$lastWeek'"), 0, 0);
								$newMonth = mysql_result(mysql_query("select count(*) from " . $TABLEPREFIX . "members where SubscribeDate >= '$lastMonth'"), 0, 0);
								$newYear = mysql_result(mysql_query("select count(*) from " . $TABLEPREFIX . "members where SubscribeDate >= '$lastYear'"), 0, 0);
							}
							else
							{
								$Lists = "";
								$totalLists = 0;
								$lResult = @mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists");

								while($lRow = mysql_fetch_array($lResut))
								{
									if(AllowList($lRow["ListID"]))
									{
										$Lists .= $lRow["ListID"] . ",";
										$totalLists++;
									}
								}

								if($totalLists > 0)
									$Lists = "where ListID in (" . $Lists . ")";
								else
									$Lists = "";

								$Lists = eregi_replace(",$", "", $Lists);
								$totalSubs = @mysql_result(@mysql_query("select count(*) from " . $TABLEPREFIX . "members $Lists"), 0, 0);

								if($Lists == "")
								{
									$newToday = $newWeek = $newMonth = $newYear = 0;
								}
								else
								{
									$newToday = mysql_result(mysql_query("select count(*) from " . $TABLEPREFIX . "members $Lists and SubscribeDate >= '$yesterday'"), 0, 0);
									$newWeek = mysql_result(mysql_query("select count(*) from " . $TABLEPREFIX . "members $Lists and SubscribeDate >= '$lastWeek'"), 0, 0);
									$newMonth = mysql_result(mysql_query("select count(*) from " . $TABLEPREFIX . "members $Lists and SubscribeDate >= '$lastMonth'"), 0, 0);
									$newYear = mysql_result(mysql_query("select count(*) from " . $TABLEPREFIX . "members $Lists and SubscribeDate >= '$lastYear'"), 0, 0);
								}
							}
					
						$OUTPUT .= '

							<li>Total subscribers: ' . $totalSubs . '</li>
							<li>Total mailing lists: ' . $totalLists . '</li>
							<li>New subscribers today: ' . $newToday . '</li>
							<li>New subscribers this week: ' . $newWeek . '</li>
							<li>New subscribers this month: ' . $newMonth . '</li>
							<li>New subscribers this year: ' . $newYear . '</li>
						</ul>
			</td>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/rm.gif">&nbsp;</td>
				</tr>
				<tr>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lb.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/bbg.gif"><font size=1>&nbsp;</td></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rb.gif" width="11" height="20"></td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lb.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/bbg.gif"><font size=1>&nbsp;</font></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rb.gif" width="11" height="20"></td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lb.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/bbg.gif"><font size=1>&nbsp;</font></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rb.gif" width="11" height="20"></td>
				</tr>
				<tr>
					<td colspan="11">&nbsp;</td>
				</tr>
				<tr>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lc.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/tbg.gif"><font size=1>&nbsp;</td></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rc.gif" width="11" height="20"></td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lc.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/tbg.gif"><font size=1>&nbsp;</font></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rc.gif" width="11" height="20"></td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lc.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/tbg.gif"><font size=1>&nbsp;</td></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rc.gif" width="11" height="20"></td>
				</tr>
				<tr>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/lm.gif">&nbsp;</td>
					<td width="33%" height="20" bgcolor="#F7F7F7" valign="top">
						<img src="' . $ROOTURL . 'admin/images/m_temp.gif" width="35" height="28" hspace="10" align="left">
						<span class="heading2">Manage Templates</span>
						<ul style="margin-left:80">
							<li>';
			
								if(AllowSection(10))
									$OUTPUT .= '<a href="' . MakeAdminLink("templates") . '">View templates</a>';
								else
									$OUTPUT .= '<span class="disabled">View templates</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(10))
									$OUTPUT .= '<a href="' . MakeAdminLink("templates?Action=Add") . '">Create a new template</a>';
								else
									$OUTPUT .= '<span class="disabled">Create a new template</span>';
								
								$OUTPUT .= '
							</li>
						</ul>
					</td>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/rm.gif">&nbsp;</td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/lm.gif">&nbsp;</td>
					<td width="33%" height="20" bgcolor="#F7F7F7" valign="top">
						<img src="' . $ROOTURL . 'admin/images/m_auto.gif" width="35" height="35" hspace="10" align="left">
						<span class="heading2">Manage Autoresponders</span>
						<ul style="margin-left:80">
							<li>';
			
								if(AllowSection(13))
									$OUTPUT .= '<a href="' . MakeAdminLink("autoresponders") . '">Manage autoresponders</a>';
								else
									$OUTPUT .= '<span class="disabled">Manage autoresponders</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(13))
									$OUTPUT .= '<a href="' . MakeAdminLink("autoresponders") . '">Create a new autoresponder</a>';
								else
									$OUTPUT .= '<span class="disabled">Create a new autoresponder</span>';
								
								$OUTPUT .= '
							</li>
						</ul>
					</td>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/rm.gif">&nbsp;</td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/lm.gif">&nbsp;</td>
					<td width="33%" height="20" bgcolor="#F7F7F7" valign="top">
						<img src="' . $ROOTURL . 'admin/images/m_list.gif" width="35" height="28" hspace="10" align="left">
						<span class="heading2">Manage Lists</span>
						<ul style="margin-left:80">
							<li>';
			
								if(AllowSection(2))
									$OUTPUT .= '<a href="' . MakeAdminLink("lists") . '">View mailing lists</a>';
								else
									$OUTPUT .= '<span class="disabled">View mailing lists</span>';
								
								$OUTPUT .= '
							</li>
							<li>';
			
								if(AllowSection(2) && $canCreateList)
									$OUTPUT .= '<a href="' . MakeAdminLink("lists?Action=Add") . '">Create a new mailing list</a>';
								else
									$OUTPUT .= '<span class="disabled">Create a new mailing list</span>';
								
								$OUTPUT .= '
							</li>
						</ul>
					</td>
					<td width="11" height="20" background="' . $ROOTURL . 'admin/images/rm.gif">&nbsp;</td>
				</tr>
				<tr>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lb.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/bbg.gif"><font size=1>&nbsp;</td></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rb.gif" width="11" height="20"></td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lb.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/bbg.gif"><font size=1>&nbsp;</font></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rb.gif" width="11" height="20"></td>
					<td width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/lb.gif" width="11" height="20"></td>
					<td width="33%" height="20" background="' . $ROOTURL . 'admin/images/bbg.gif"><font size=1>&nbsp;</td></td>
					<td width="11" height="20"><img src="' . $ROOTURL . 'admin/images/rb.gif" width="11" height="20"></td>
				</tr>
			</table>
			<div align="right" style="width:98%">
				<br><a href="javascript:launchQS()" class="pop">Launch Quick Start Popup »</a>
			</div>
		';

		$OUTPUT .= '

				<script>

					function launchQS()
					{
						window.open("' . $ROOTURL . 'admin/functions/quickstart.php?TP=' . $TABLEPREFIX . '&AdminID=' . $CURRENTADMIN["AdminID"] . '&SID=' . $CURRENTADMIN["LoginString"] . '", "", "left=" + (screen.availWidth) / 2 - 225 + ", top="+ (screen.availHeight) / 2 - 125 +", width=450, height=250, toolbar=0, statusbar=0, scrollbars=0");
					}

				</script>
			';

		if(@mysql_result(@mysql_query("select KillQuickStart from " . $TABLEPREFIX . "admins where AdminID=" . $CURRENTADMIN["AdminID"]), 0, 0) != 1)
		{
			$OUTPUT .= '<script>launchQS();</script>';
		}
	}

?>