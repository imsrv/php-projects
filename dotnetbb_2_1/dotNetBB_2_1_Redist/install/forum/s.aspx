<%@ Page Language="vb"  %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Sub Page_Load
		Dim boardItems as new bbForum			'-- Initializes the message board
		Dim userGUID as String = ""				'-- Holds the user's GUID
		Dim hasQSValues as Boolean = False		'-- If the page has querystring values
		Dim forumID as Integer = 0				'-- Holds the current forum ID
		Dim maxReturn as Integer = 25			'-- Holds maximum number of return values
		Dim maxDays as Integer = 1				'-- Holds maximum number of days back to look
		Dim searchWords as String = ""			'-- Holds the keywords to search for
		Dim searchAs as Integer = 1				'-- All or Any keywords

		userGUID = boardItems.getUserCookie("uld")
		If userGUID = "" Then									
			userGUID = boardItems.GUEST_GUID		
		End If		
		hasQSValues = boardItems.initializeQSValues()		
		boardInit.Text = boardItems.initializeBoard(userGUID)	
		headItems.Text = boardItems.getHeadItems()	
		forumTop.Text = boardItems.forumTop(userGUID, true, true)
		searchForm.Text = boardItems.forumSearchForm(userGUID)
		
		'-- End initialize
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
						<asp:Literal ID="boardInit" runat="server" />
						<asp:Literal ID="forumTop" runat="server" />
						<asp:Literal ID="searchForm" Runat="server" />
					</td>
				</tr>  	
			</table>
		</td></tr></table>
	</body>
</html>
