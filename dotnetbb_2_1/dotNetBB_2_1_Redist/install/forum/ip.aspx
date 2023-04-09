<%@ Page Language="vb"  %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Dim baseURL as String = ""
	Sub Page_Load
		Dim boardItems as new bbForum			'-- Initializes the message board
		Dim userGUID as String = ""
		Dim sendToNull as String = ""
		userGUID = boardItems.getUserCookie("uld")
		If userGUID = "" Then		
			userGUID = boardItems.GUEST_GUID				
		End If			
		sendToNull = boardItems.initializeBoard(userGUID)		
		headItems.Text = boardItems.getHeadItems()	
		ipInfo.Text = boardItems.forumIPLockInfo()
	End Sub	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>    
		<asp:Literal ID="headItems" runat="server" />	
	</head>
	<body topmargin="4" marginheight="4" leftmargin="4" marginwidth="4">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="outerTable"><tr><td>
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td background="/forum/images/navbar.gif" align="center">&nbsp;</td>
					<td background="/forum/images/navbar.gif" width="100%" align="right"><a href="http://www.dotNetBB.com" target="_blank"><img src="/forum/images/nav_logo.gif" alt="dotNetBB Forums" border="0"></a></td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" class="tblStd" width="100%">
				<tr>
					<td class="msgSm">
						<div align="center"><br /><br />Your IP Address is banned from accessing this forum.<br /><br /><asp:Label ID="ipInfo" Runat="server" /></div>
					</td>
				</tr>  	
			</table>
		</td></tr></table>
	</body>
</html>
