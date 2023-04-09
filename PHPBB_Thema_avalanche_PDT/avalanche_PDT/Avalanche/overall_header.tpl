<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="{S_CONTENT_DIRECTION}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	{META}
	{NAV_LINKS}
	<title>{SITENAME} :: {PAGE_TITLE}</title>
	<link rel="stylesheet" href="templates/Avalanche/Avalanche.css" type="text/css" />

	<!-- BEGIN switch_enable_pm_popup -->
	<script language="Javascript" type="text/javascript">
	<!--
		if ( {PRIVATE_MESSAGE_NEW_FLAG} )
		{
			window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');
		}
	//-->
	</script>
	<!-- END switch_enable_pm_popup -->
</head>
<body>

<a name="top"></a>
<table class="bodyline" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr>
		<td class="back_1_1">&nbsp;</td>
		<td class="back_1_2">&nbsp;</td>
		<td colspan="3" class="back_1_3">&nbsp;</td>
		<td class="back_1_6">&nbsp;</td>
		<td class="back_1_7">&nbsp;</td>
	</tr>
</table>
<table class="bodyline" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr>
		<td class="back_2_1">&nbsp;</td>
		<td class="back_2_2"><div class="maintitle">{SITENAME}</div><div class="nav" style="font-size: 11px;">{SITE_DESCRIPTION}</div></td>
		<td class="back_2_4">&nbsp;</td>
		<td class="back_2_5" align="right" valign="top">
			<div>
			<form action="search.php?mode=results" method="post">
			<input class="post" type="text" name="search_keywords" size="20" onfocus="this.value=''" value="Quick Search" />
			<input class="button" name="submit" type="submit" value="Go" />
			</form>
			</div>
			<div><span class="gensmall"><a href="{U_SEARCH}">Advanced Search</a></span></div>
		</td>
		<td class="back_2_6">&nbsp;</td>
		<td class="back_2_7">&nbsp;</td>
	</tr>
</table>
<table class="bodyline" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr>
		<td class="back_3_1">&nbsp;</td>
		<td class="back_3_2" colspan="5">
		
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td class="tab_space_1"></td>
					<td class="active_button"><a href="{U_INDEX}" style="color: #f3a625;" class="tab">Home</a></td>
					<!-- BEGIN switch_user_logged_out -->
					<td class="active_button"><a href="{U_REGISTER}" class="tab">{L_REGISTER}</a></td>
					<td class="active_button"><a href="{U_FAQ}" class="tab">{L_FAQ}</a></td>
					<td class="active_button"><a href="{U_MEMBERLIST}" class="tab">{L_MEMBERLIST}</a></td>
					<td class="active_button"><a href="{U_GROUP_CP}" class="tab">{L_USERGROUPS}</a></td>
					<!-- END switch_user_logged_out -->
					<!-- BEGIN switch_user_logged_in -->
					<td class="active_button"><a href="{U_MEMBERLIST}" class="tab">{L_MEMBERLIST}</a></td>
					<td class="active_button"><a href="{U_GROUP_CP}" class="tab">{L_USERGROUPS}</a></td>
					<td class="active_button"><a href="{U_PROFILE}" class="tab">{L_PROFILE}</a></td>
					<!-- END switch_user_logged_in -->
					<td class="tab_space_2">&nbsp;</td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td class="link_back_1">&nbsp;</td>
					<td class="link_back_2"><a href="{U_PRIVATEMSGS}" class="gensmall"><b>{PRIVATE_MESSAGE_INFO}</b></a></td>
					<td class="link_back_2" align="right">
						<a href="{U_LOGIN_LOGOUT}" class="gensmall"><b>{L_LOGIN_LOGOUT}</b></a>
					</td>
					<td class="link_back_3">&nbsp;</td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td><span style="font-size: 4px;">&nbsp;</span></td>
					<td class="link_back_5"><span style="font-size: 4px;">&nbsp;</span></td>
				</tr>
			</table>
		
		</td>
		<td class="back_3_7">&nbsp;</td>
	</tr>
</table>
<table class="bodyline" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr>
		<td class="back_4_1"></td>
		<td class="back_4_2" colspan="5">
		<br />
