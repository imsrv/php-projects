<%@ Page Language="vb" %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Sub Page_Load
		Dim boardItems as new bbForum			'-- Initializes the message board
		Dim userGUID as String = ""				'-- Holds the user's GUID
		Dim hasQSValues as Boolean = False		'-- If the page has querystring values
		hasQSValues = boardItems.initializeQSValues()
		If hasQSValues = False Then
			hasQSValues = boardItems.initializeFPValues()
		End If
		
		userGUID = boardItems.getUserCookie("uld")
		If userGUID = "" Then									
			userGUID = boardItems.GUEST_GUID		
		Else
			boardItems.setUserCookie("uld", userGUID)	
		End If
		
		boardInit.Text = boardItems.initializeBoard(userGUID)
		headItems.Text = boardItems.getHeadItems()	
		ipInfo.Text = boardItems.forumIPLockInfo()
	End Sub	
	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>    
	<asp:Literal ID="headItems" runat="server" />	
</head>
<body topmargin="2" marginheight="0" leftmargin="2" marginwidth="0">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td background="/forum/images/navbar.gif" align="center">&nbsp;</td>
			<td background="/forum/images/navbar.gif" width="100%" align="right"><a href="http://www.dotNetBB.com" target="_blank"><img src="/forum/images/nav_logo.gif" alt="dotNetBB Forums" border="0"></a></td>
		</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="tblStd" width="100%">
		<tr><td class="msgSm">
			<asp:Literal id="boardInit" runat="server" />
			<hr size="1" noshade />
			<br /><br /><div align="center">
			<b>An error has occured.</b><br />
			This typicaly happens when a message has been deleted and you are attempting to access the old link.<br /><br />
			If you continue to receive this error, please contact the forum administrator.
			</div>
			<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
			<div align="center"><asp:Label ID="ipInfo" Runat="server" /></div>
		</td></tr>  	
	</table>
	&nbsp;
</body>
</html>
