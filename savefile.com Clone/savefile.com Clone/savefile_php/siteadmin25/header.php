<html>
<head>
	<title><?=$sitename?></title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script language="JavaScript">
		function popUp(URL,NAME) {
			amznwin=window.open(URL,NAME,'location=yes,scrollbars=yes,status=yes,toolbar=yes,resizable=yes,width=380,height=450,screenX=10,screenY=10,top=10,left=10');
			amznwin.focus();
		}
		function gotocluster(s){       
			var d = s.options[s.selectedIndex].value
			if(d){
				self.location.href = d
			}
			s.selectedIndex=0
		}
	</script>
</head>
<body bgcolor="#e5e5e5" link="#000000" alink="#000000" vlink="#000000">
<div align="center">
	<div id="container">
		<div id="header" style="height:70px;border:1px solid black;padding-left:10px;padding-right:10pxl">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" height="80">
			<tr>
				<td height="50" valign="middle">
					<a href="<?=$siteurl?>/index.php">
					<span style="font-size:32px;letter-spacing:10px;text-decoration:none;"><?=$sitename?> Admin</font></span></a>
				</td>
			</tr>
			</table>
		</div>
		<div id="menu" class="bar">
			<table border="0" cellpadding="0" cellspacing="0" align=left>
			<tr>
				<td class="menuitem" align="left">
					<SELECT onChange="gotocluster(this)">
						<option value="">-- Choose An Option --</option>
						<option value="index.php">home</option>
						<option value="config.php">Change Password</option>
						<option value="imgman.php">Manage Uploads</option>
						<option value="users25.php">Manage Users</option>
						<option value="mail.php">Send Broadcast Mail to Users</option>
					</select>
				</td>
				<td class="menuitem" align="right"></td>
			</tr>
			</table>
		</div>
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td valign="top" class="BodyHeader">
				<div class="destination">
					<table width="96%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="100%" colspan="2"><span class="Text1">