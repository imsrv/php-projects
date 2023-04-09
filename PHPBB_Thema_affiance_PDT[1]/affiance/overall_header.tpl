<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<link rel="stylesheet" href="templates/affiance/{T_HEAD_STYLESHEET}" type="text/css">
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

<table width="90%" cellspacing="0" cellpadding="3" border="0" align="center"> 
	<tr> 
		<td class="bodyline">
			<table width="100%" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td colspan="12" align="center" width="100%" valign="middle"><span class="maintitle">{SITENAME}</span><br /><span class="gen">{SITE_DESCRIPTION}<br />&nbsp;</span></td>
				</tr>
				<tr>
					<td class="tabs">&nbsp;<a class="tab" href="{U_FAQ}">{L_FAQ}</a></td>
					<td class="tabs">&nbsp;<a class="tab" href="{U_SEARCH}">{L_SEARCH}</a></td>
					<td class="tabs">&nbsp;<a class="tab" href="{U_GROUP_CP}">{L_USERGROUPS}</a></td>
					<td class="tabs">&nbsp;<a class="tab" href="{U_MEMBERLIST}">{L_MEMBERLIST}</a></td>
					<td class="tabs">&nbsp;<a class="tab" href="{U_PROFILE}">{L_PROFILE}</a></td>
					<td class="tabs">&nbsp;<a class="tab" href="{U_PRIVATEMSGS}">{PRIVATE_MESSAGE_INFO}</td>
					<!-- BEGIN switch_user_logged_out -->
					<td class="tabs">&nbsp;<a class="tab" href="{U_REGISTER}">{L_REGISTER}</a></td>
					<!-- END switch_user_logged_out -->
					<td class="tabRight">&nbsp;<a class="tab" href="{U_LOGIN_LOGOUT}">{L_LOGIN_LOGOUT}</a></td>
				</tr>
					</td>
				</tr>
			</table>