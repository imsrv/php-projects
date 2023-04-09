<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title><{page_title}> - (Powered by EKINboard)</title>
		<meta name="robots" content="index,follow">
		<link rel="stylesheet" type="text/css" href="templates/<{template}>/style.css">
		<link rel="shortcut icon" href="http://www.ekinboard.com/forums/v1/favicon.ico">
		<link rel="alternate" type="application/rss+xml" title="<{page_title}> RSS Feed - (Powered by EKINboard)" href="feed.php" />

<script language="javascript"> 
<!-- 

var state = 'none'; 

function showhide(layer_ref) { 

if (state == 'block') { 
state = 'none'; 
} 
else { 
state = 'block'; 
} 
if (document.all) { //IS IE 4 or 5 (or 6 beta) 
eval( "document.all." + layer_ref + ".style.display = state"); 
} 
if (document.layers) { //IS NETSCAPE 4 or below 
document.layers[layer_ref].display = state; 
} 
if (document.getElementById &&!document.all) { 
hza = document.getElementById(layer_ref); 
hza.style.display = state; 
} 
} 
//--> 
</script> 



	</head>
	<body class="body">
		<center>
			<table class="mainwidth" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" class="category_table">
							<tr>
								<td>
									<a href="index.php"><img src="templates/<{template}>/images/EKINboard_banner_top_left.gif" border="0" alt=""></a></td>
								<td width="100%" background="templates/<{template}>/images/EKINboard_banner_top_stretch.gif"></td>
								<td>
									<img src="templates/<{template}>/images/EKINboard_banner_top_right.gif" border="0" alt=""></td>
							</tr>
							<tr>
								<td colspan="3" align="right" class="table_menuheader">
									<a href="rules.php">Rules</a> · <a href="search.php">Search</a> · <a href="memberlist.php">Members</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<{loop_textad}>
							<table width="100%" height="10">
								<tr>
									<td>
									</td>
								</tr>
							</table>
							<center>
								<table cellpadding="0" cellspacing="2" border="0">
									<tr>
										<{loop_ad}>
											<td width="200" valign="top">
												<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" class="greentable">
													<tr>
														<td class="greentable_header">
															<a href="<{ad_text_href}>"><{ad_text}></a>
														</td>
													</tr>
													<tr>
														<td class="greentable_content" height="100%">
															<{ad_text_description}>
														</td>
													</tr>
												</table>
											</td>
										<{/loop_ad}>
									</tr>
								</table>
							</center>
						<{/loop_textad}>
						<{loop_bannerad}>
							<table width="100%" height="10">
								<tr>
									<td>
									</td>
								</tr>
							</table>
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td align="center">
										<a href="<{ad_banner_href}>"><img src="<{ad_banner_img}>" alt="" border="0">
									</td>
								</tr>
							</table>
						<{/loop_bannerad}>
						<table width="100%" height="10">
							<tr>
								<td>
								</td>
							</tr>
						</table>
						<{loop_notice}>
							<table width="100%" cellpadding="0" cellspacing="0" border="0" class="redtable">
								<tr>
									<td class="redtable_header">
										<b>Notice</b>
									</td>
								</tr>
								<tr>
									<td class="redtable_content">
										<{notice_message}>
									</td>
								</tr>
							</table>
							<table width="100%" height="10">
								<tr>
									<td>
									</td>
								</tr>
							</table>
						<{/loop_notice}>
						<{loop_guest_mini_menu}>
							<table width="100%" cellpadding="0" cellspacing="0" border="0" class="redtable">
								<tr>
									<td align="center" class="redtable_content">
										<table width=95% cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td>
													<b>Welcome Guest!</b> ( <a href="register.php" class="link2">Register</a> )
												</td><td align="right">
													<form action="login.php?d=login" method="post" name="Form" onSubmit="disableButton()" class="form">
														Login: <input class=text type=text size="10" maxlength="64" name=username> <input class=text type="password" size="10" maxlength="64" name=password> <input type="submit" value="Login!" class="button" name="submit">
													</form>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						<{/loop_guest_mini_menu}>
						<{loop_registered_mini_menu}>
							<table width="100%" cellpadding="0" cellspacing="0" border="0" class="bluetable">
								<tr>
									<td>
										<table width="100%" callpadding="0" cellspacing="0" border="0">
											<tr>
												<td>
													<b>Logged in as:</b> <a href="profile.php?id=<{user_id}>"><{user_name}></a> ( <a href="login.php?d=logout" class="link2">Logout</a> )
												</td>
												<td align="right">
													<{loop_admin_mini_menu}>
														<a href="admin/index.php" class="link3">Admin Panel</a> · 
													<{/loop_admin_mini_menu}>
														<a href="cp.php">Control Panel</a> · <a href="mailbox.php" class="link2"><{new_messages}> New Message(s)</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						<{/loop_registered_mini_menu}>
						<{loop_new_message}>
							<table width="100%" height="10">
								<tr>
									<td>
									</td>
								</tr>
							</table>
							<table width="100%" cellpadding="0" cellspacing="0" border="0" class="redtable">
								<tr>
									<td class="redtable_header">
										<b>You have <{new_message_count}> new message(s) waiting for you!</b>
									</td>
								</tr>
								<tr>
									<td class="redtable_header">
										Most recent message:
									</td>
								</tr>
								<tr>
									<td class="redtable_content">
										<b>From:</b> <a href="profile.php?id=<{new_message_from_id}>"><{new_message_from}></a> on <{new_message_date}><br>
										<b>Subject:</b> <a href="http://www.ekinboard.com/forums/v1/mailbox.php?folder=inbox&act=read&id=<{new_message_id}>"><{new_message_subject}></a><p>
										<{new_message_message}>
									</td>
								</tr>
							</table>
						<{/loop_new_message}>