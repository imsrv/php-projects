<%@ Page Language="vb"  %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Dim baseURL as String = ""
	Sub Page_Load
		Dim boardItems as new bbForum			'-- Initializes the message board
		Dim userGUID as String = ""				'-- Holds the user's GUID
		Dim hasQSValues as Boolean = False		'-- If the page has querystring values
		Dim forumID as Integer = 0				'-- Holds the current forum ID
		Dim messageID as Integer = 0			'-- Holds the current message thread ID
		Dim currentPage as Integer = 1			'-- Holds the current page number
		Dim perPage as Integer = 50				'-- Holds the max items per page to be viewed
		Dim sendToNull as String = ""
		userGUID = boardItems.GUEST_GUID		
		boardItems.setUserCookie("uld", userguid)
		sendToNull = boardItems.initializeBoard(userGUID)
		headItems.Text = boardItems.getHeadItems()	
		pc.Text = boardItems.doCopy()		
		baseURL = boardItems.RedirBounce()
			
		'-- End initialize
	End Sub	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>    
		<asp:Literal ID="headItems" runat="server" />	
		<script language="javascript">
			function goHome() {
				window.location.href='<% =baseURL %>';
			}
			
		</script>
	</head>
	<body topmargin="4" marginheight="4" leftmargin="4" marginwidth="4" onload="setTimeout('goHome()', 1500);">
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
						<div align="center"><b>
							<br /><br />Your account has been logged out.</b>
							<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
							<asp:literal ID="pc" Runat="server" />
						</div>
					</td>
				</tr>  	
			</table>
		</td></tr></table>
	</body>
</html>
