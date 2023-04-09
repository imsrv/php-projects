<?php

	@ob_start();

	include("../../includes/config.inc.php");
	include("../includes/templates.php");
	include("../includes/basic.inc.php");

	$SID = @$_GET["SID"];
	$TP = @$_GET["TP"];
	$AdminID = @$_GET["AdminID"];

	if(@$_GET["killQuickStart"] == 1)
	{
		@mysql_query("update " . $TP . "admins set KillQuickStart=1 where AdminID=" . $AdminID);
		?>
			<script>window.close();</script>
		<?php
		@ob_end_flush();
	}
	else
	{
	?>
		<html>
		<head>
		<title> Quick Start Guide </title>
		<?php OutputStyleSheet(); ?>
		</head>
		<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0">
			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="60" class="menutop">
						<img src="<?php echo $ROOTURL; ?>admin/images/logo.gif" width=294 height=59 border=0>
						<div style="position:absolute; left:405; top:1">
							<a href="javascript:window.close()" class="topLink">[x] Close</a>
						</div>
					</td>
				</tr>
				<tr>
					<td height="160" background="<?php echo $ROOTURL; ?>admin/images/midbg.gif">
						<p style="margin-left:30">
							<span class="heading1"><br><i>5 Quick Steps to Send Your First Newsletter...</i></span>
							<br><br>
							<ol style="margin-left:70">
								<li><a href="javascript:void(0)" onClick="window.opener.document.location.href='<?echo MakeAdminLink("lists", $SID);?>'; window.opener.focus();">Create a mailing list</a></li>
								<li><a href="javascript:void(0)" onClick="window.opener.document.location.href='<?echo MakeAdminLink("import", $SID);?>'; window.opener.focus();">Import subscribers</a></li>
								<li><a href="javascript:void(0)" onClick="window.opener.document.location.href='<?echo MakeAdminLink("compose?Action=Add", $SID);?>'; window.opener.focus();">Create a newsletter</a></li>
								<li><a href="javascript:void(0)" onClick="window.opener.document.location.href='<?echo MakeAdminLink("forms", $SID);?>'; window.opener.focus();">Create a subscription form</a></li>
								<li><a href="javascript:void(0)" onClick="window.opener.document.location.href='<?echo MakeAdminLink("send", $SID);?>'; window.opener.focus();">Send your newsletter</a></li>
							</ol>
						</p>
					</td>
				</tr>
				<tr>
					<td height="30" background="<?php echo $ROOTURL; ?>/admin/images/quickbg.gif" align="right">
						<a href="<?php echo @$_SERVER["PHP_SELF"]; ?>?killQuickStart=1&TP=<?php echo @$_GET["TP"]; ?>&AdminID=<?php echo @$_GET["AdminID"]; ?>" class="topLink">Don't show me this window anymore »</a>&nbsp;&nbsp;
					</td>
				</tr>
			</table>
		</body>
		</html>
	<?php
	}
?>