<?
/*
 * gCards - a web-based eCard application
 * Copyright (C) 2003 Greg Neustaetter
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
/*
****************************************************************************
showHeader  - this displays the HTML header with options to show the
style sheet and options to show the HTMLarea widget
****************************************************************************
*/
function showHeader($title = 'Graphics by Greg eCards', $relpath='', $style = 1, $htmlarea = 0, $login= 0)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title><? echo $title;?></title>
<?
	if ($style == 1)
	{
?>
	<link href="<? echo $relpath;?>css/style.css" rel="stylesheet" type="text/css">
<?
	}
	if ($htmlarea == 1)
	{
?>

	<script language="Javascript1.2"><!-- // load htmlarea
	_editor_url = "inc/htmlarea/";                     // URL to htmlarea files
	var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
	if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
	if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
	if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
	if (win_ie_ver >= 5.5) {
	 document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js"');
	 document.write(' language="Javascript1.2"></scr' + 'ipt>');  
	} else { document.write('<script>function editor_generate() { }</script>'); }
	// --></script> 	
<?
	}
?>
</head>
<body <? if ($login == 1) echo "OnLoad=\"document.loginform.username.focus();\"";?>>
<?
	global $siteName;
	global $auth_user;
	?>
<table width="100%">
	<tr>
		<td><span class="title"><? echo $siteName;?></span></td>
		<td align="right">
			<?
				if (session_is_registered("auth_user"))
					{
		?>
			User: <? echo $auth_user;?>&nbsp;&nbsp;<a href="<? echo $relpath;?>admin/admin.php">[eCards Administration Console]</a>&nbsp;&nbsp;<a href="<? echo $relpath;?>admin/changePass.php">[Change Password]</a>&nbsp;&nbsp;<a href="<? echo $relpath;?>logout.php">[logout]</a>
		<?
					}
				else
					{
		?>
			<a href="login.php">[log in]</a>							
		<?
					}
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td class="horizontalLine"><img src="<? echo $relpath;?>images/siteImages/shim.gif" border="0" height="2" width="1"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br>
	<?
}

function showLink($link, $linktext)
{
	echo "<a href=\"$link\">$linktext</a>";
}

function horizontalLine()
{
?>
<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="horizontalLine"><img src="images/siteImages/shim.gif" border="0" height="2" width="1"></td>
	</tr>
</table>
<?
}


/*
****************************************************************************
showFooter  - this displays the HTML footer tags
****************************************************************************
*/
function showFooter()
{
	global $siteName;
	global $sitePath;
?>
<br><br>
<table width="100%">
	<tr>
		<td colspan="2"><? horizontalLine();?></td>
	</tr>
	<tr>
		<td>Powered by <a href="http://www.gregphoto.net/gcards/index.php">gCards</a></td><td align="right"><? showLink("$sitePath","[$siteName Home]");?></td>
	</tr>
</table>

</body>
</html>
<?
}





?>