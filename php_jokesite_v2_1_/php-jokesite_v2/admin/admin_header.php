<?
//echo (ini_get("register_globals") == "1" ? "register_globals=On => OK " : "register_globals=OFF swirch to ON ");
//echo "<br>".(ini_get("file_uploads") == "1" ? "file_uploads=On => OK " : "file_uploads=OFF swirch to ON ");
?>
<?include(DIR_SERVER_ADMIN."admin_auth.php");?><html>
<head>
	<title><?echo $site_title;?></title>
<style type="text/css">
<!--
	body	{font-family: helvetica, arial, geneva, sans-serif; font-size: x-small}
	th		{font-family: helvetica, arial, geneva, sans-serif; font-size: x-small; font-weight: bold; background-color: #D3DCE3}
	td		{font-family: helvetica, arial, geneva, sans-serif; font-size: 13px}
	form	{font-family: helvetica, arial, geneva, sans-serif; font-size: x-small, margin-top: 0px; margin-bottom: 0px; }
	A:link	{font-family: helvetica, arial, geneva, sans-serif; font-size: 13px; text-decoration: none; color: #0000ff}
	A:active{font-family: helvetica, arial, geneva, sans-serif; font-size: 13px; text-decoration: none; color: #0000ff}
	A:visited{font-family: helvetica, arial, geneva, sans-serif; font-size: 13px; text-decoration: none; color: #0000ff}
	A:hover	{font-family: helvetica, arial, geneva, sans-serif; font-size: 13px; text-decoration: underline; color: #FF0000}
	.button	{BACKGROUND-COLOR: #e3daf0;	COLOR: #993366;	CURSOR: hand;	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;	FONT-SIZE: 8pt;	FONT-WEIGHT: bold;	border: 1 solid #000000}
	submit	{BACKGROUND-COLOR: #e3daf0;	COLOR: #993366;	CURSOR: hand;	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;	FONT-SIZE: 8pt;	FONT-WEIGHT: bold;	border: 1 solid #000000}
	input	{BACKGROUND-COLOR: #FFFFFE;	COLOR: #993366;		FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;	FONT-SIZE: 8pt;	FONT-WEIGHT: bold;	border: 1 solid #000000}
	textarea	{BACKGROUND-COLOR: #FFFFFE;	COLOR: #993366;		FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;	FONT-SIZE: 8pt;	FONT-WEIGHT: bold;	border: 1 solid #000000}
	select	{BACKGROUND-COLOR: #FFFFFE;	COLOR: #993366;		FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;	FONT-SIZE: 8pt;	FONT-WEIGHT: bold;	border: 1 solid #000000}
	.radio {
	 font-family: Verdana; font-size: 9pt; 
	 background: transparent; 
	 font-weight: Bold; border: 0 solid #000000 
	}
	//-->
</style>
<?
if (eregi("add_banner.php",basename($REQUEST_URI))) {
	include(DIR_SERVER_ROOT."banner_add_banner_header.php");
	$addbanner = true;
}
else {
?>
<?
    echo "<script language=\"Javascript\" src=\"../js/admin_subcat.js\"></script>";
?>
</head>
<body bgcolor="<?=ADMIN_SITE_BGCOLOR?>"  marginwidth="0" marginheight="0" topmargin="0"
bottommargin="0" leftmargin="0" rightmargin="0">
<?
}	
?>

<?include(DIR_LANGUAGES.$language.'/admin_form.php');?>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?=HTML_WIDTH?>">
<tr valign="top">
	<td>
		
		<table align="center" border="0" cellspacing="1" cellpadding="1" width="750">
<?
if (!eregi("add_banner.php",basename($REQUEST_URI))) {
?>
		<tr>
			<td>
				<br>
			</td>
		</tr>

		<tr>
			<td align="center">
				<font face="helvetica, verdana, arial"><b> <?=$site_name?> Admin Area </b></font><br><br>
			</td>
		</tr>
<?
}
?>
		<tr valign="top">
			<td bgcolor="#000000">
				<table align="center" border="0" cellspacing="0" cellpadding="2" bgcolor="#ffffff" width="100%">
				<tr valign="top">
					<td width="180" bgcolor="#ffffef">
						<table align="center" border="0" cellspacing="0" cellpadding="0" width="97%">
						<tr>
							<td nowrap>

<li><a href="<?=HTTP_SERVER?>">Home</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN?>">Admin Home</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_logout.php"?>">Logout</a><br>
<hr size="1" color="#CC66FF">
<table align="center" border="0" cellspacing="0" cellpadding="1" width="98%">
<tr><td bgcolor="red"><table align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFF99" width="100%">
<tr><td align="center"><b>Script Management</b></td></tr></table></td></tr></table>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_password.php"?>">Admin Password</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_add_banner.php"?>">Banner Manager</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_site_settings.php"?>">Script Settings</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_layout.php"?>">Layout Settings</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_manage_images.php?mix=1&http_image=".urlencode(DIR_IMAGES)."&dir_image=".urlencode(DIRS_IMAGES)?>">Manage Site Images</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_daily_joke_picture.php"?>">Content Channel</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_crontab_settings.php"?>">Crontab settings</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_bulk_email.php"?>">Bulk Email</a><br>


<hr size="1" color="#CC66FF">
<table align="center" border="0" cellspacing="0" cellpadding="1" width="98%">
<tr><td bgcolor="red"><table align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFF99" width="100%">
<tr><td align="center"><b>Jokes</b></td></tr></table></td></tr></table>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_validate_jokes.php"?>">Validate New Jokes</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_add_joke.php"?>">Add New Jokes</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_edit_delete_jokes.php"?>">Edit/Delete Jokes</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_jokes_category.php"?>">Joke Categories</a><br>								
<li><a href="<?=HTTP_SERVER_ADMIN."admin_censors_category.php"?>">Censor Categories</a><br>

<hr size="1" color="#CC66FF">
<table align="center" border="0" cellspacing="0" cellpadding="1" width="98%">
<tr><td bgcolor="red"><table align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFF99" width="100%">
<tr><td align="center"><b>Pictures</b></td></tr></table></td></tr></table>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_validate_pictures.php"?>">Validate New Pictures</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_add_pictures.php"?>">Add New Pictures</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_edit_delete_pictures.php"?>">Edit/Delete Pictures</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_pictures_category.php"?>">Picture Categories</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_firstpage_images.php"?>">First Page Pictures</a><br>

<hr size="1" color="#CC66FF">
<table align="center" border="0" cellspacing="0" cellpadding="1" width="98%">
<tr><td bgcolor="red"><table align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFF99" width="100%">
<tr><td align="center"><b>Newsletters</b></td></tr></table></td></tr></table>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_newsletters_category.php"?>">Newsletter Categories</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_random_newsletter_jokes.php"?>">Edit Daily Joke Newsletter</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_newsletter_subscribers.php"?>">Newsletter Subscribers</a><br>

<hr size="1" color="#CC66FF">
<table align="center" border="0" cellspacing="0" cellpadding="1" width="98%">
<tr><td bgcolor="red"><table align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFF99" width="100%">
<tr><td align="center"><b>Multilanguage Support</b></td></tr></table></td></tr></table>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_language_add_lng.php"?>">Add language</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_language_del_lng.php"?>">Delete language</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>">Edit language</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_edit_mail_include.php"?>">Edit HTML files</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_edit_mail.php"?>">Edit Email Messages</a><br>

<hr size="1" color="#CC66FF">
<table align="center" border="0" cellspacing="0" cellpadding="1" width="98%">
<tr><td bgcolor="red"><table align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFF99" width="100%">
<tr><td align="center"><b>Database Management</b></td></tr></table></td></tr></table>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_backup_db.php"?>">Backup Database</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_restore_db.php"?>">Restore Database</a><br>
<li><a href="<?=HTTP_SERVER_ADMIN."admin_mysql_update.php"?>">Update Database</a><br>
<hr size="1" color="#CC66FF">
							</td>
						</tr>
						</table>
					</td>
					<td width="1" bgcolor="#CCCCCC"><img src="<?=DIR_IMAGES?>0.gif" border="0" alt="" width="1" height="1"></td>
					<td>
