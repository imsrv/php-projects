<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
{META_TAG}
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<!-- .premodded Changement - Use from version .premodded 1.0.7 external CSS instead of internal CSS 19 November 2005 18:06 -->
<link rel="stylesheet" href="templates/subSilver/{T_HEAD_STYLESHEET}" type="text/css">
<!-- Start Syntax Highlighting mod -->
<link rel="stylesheet" href="templates/subSilver/geshi.css" type="text/css">
<!-- End Syntax Highlighting mod -->
<!-- BEGIN switch_enable_pm_popup -->
<script language="Javascript" type="text/javascript">
<!--
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;
	}
//-->
</script>
<!-- END switch_enable_pm_popup -->
</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<a name="top"></a>

<table width="100%" cellspacing="0" cellpadding="10" border="0" align="center"> 
	<tr> 
		<td class="bodyline"><table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr> 
				<td><a href="{U_INDEX}"><img src="templates/subSilver/images/logo_phpBB.gif" border="0" alt="{L_INDEX}" vspace="1" /></a></td>
				<td align="center" width="100%" valign="middle"><span class="maintitle">{SITENAME}</span><br /><span class="gen">{SITE_DESCRIPTION}<br />&nbsp; </span> 
				<table cellspacing="0" cellpadding="2" border="0">
					<tr> 
						<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_FAQ}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_faq.gif" width="12" height="13" border="0" alt="{L_FAQ}" hspace="3" />{L_FAQ}</a>&nbsp; &nbsp;<a href="{U_SEARCH}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_search.gif" width="12" height="13" border="0" alt="{L_SEARCH}" hspace="3" />{L_SEARCH}</a>&nbsp; &nbsp;<a href="{U_MEMBERLIST}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_members.gif" width="12" height="13" border="0" alt="{L_MEMBERLIST}" hspace="3" />{L_MEMBERLIST}</a>&nbsp; &nbsp;<a href="{U_GROUP_CP}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_groups.gif" width="12" height="13" border="0" alt="{L_USERGROUPS}" hspace="3" />{L_USERGROUPS}</a>&nbsp;&nbsp;<a href="{U_STAFF}" class="mainmenu"><img src="templates/subSilver/images/staff.gif" width="12" height="13" border="0" alt="{L_STAFF}" hspace="3" />{L_STAFF}</a>&nbsp; 
						<!-- BEGIN switch_user_logged_out -->
						&nbsp;<a href="{U_REGISTER}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_register.gif" width="12" height="13" border="0" alt="{L_REGISTER}" hspace="3" />{L_REGISTER}</a>&nbsp;
						<!-- END switch_user_logged_out -->
                                    <!-- BEGIN switch_user_logged_in -->
                                    &nbsp;<a href="{U_ONLINE_STATUS}" class="mainmenu"><img src="{ONLINE_IMG}" width="12" height="13" border="0" alt="{L_VIEWONLINE}" hspace="3" />{L_VIEWONLINE}</a></span>&nbsp;
                                    <!-- END switch_user_logged_in -->
						</span></td>
					</tr>
					<tr>
						<td height="25" align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;&nbsp;<a href="{U_REFERAF}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_refer.gif" border="0" alt="{L_REFERAF}" hspace="3" />{L_REFERAF}</a></span><span class="mainmenu">&nbsp;&nbsp;<a href="{U_PROFILE}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="{L_PROFILE}" hspace="3" />{L_PROFILE}</a>&nbsp; &nbsp;<a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_message.gif" width="12" height="13" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" />{PRIVATE_MESSAGE_INFO}</a>&nbsp; &nbsp;<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_login.gif" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" />{L_LOGIN_LOGOUT}</a>&nbsp;</span></td>
					</tr>
				</table></td>
			</tr>
		</table>

		<br />
<!-- BEGIN switch_admin_disable_board -->
    <table width="100%" cellspacing="0" cellpadding="10" border="0" align="center"> 
	<tr> 
	<td class="forumline" align="center"><span class="gen"><b>{L_BOARD_DISABLE}</b></span></td>
    </tr>
   </table>
<!-- END switch_admin_disable_board -->