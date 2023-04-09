<%@ Page Language="vb" debug="true" %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Dim boardItems as new bbForum			'-- Initializes the message board
	Dim userGUID as String = ""				'-- Holds the user's GUID
	Dim hasQSValues as Boolean = False		'-- If the page has Form values
	Dim RetStr as String = ""
	Dim forumID as Integer = 0
	Dim loadForm as String = "x"
	
	Sub Page_Load
		userGUID = boardItems.getUserCookie("uld")
		If userGUID = "" Then		
			userGUID = boardItems.GUEST_GUID		
		Else
			boardItems.setUserCookie("uld", userGUID)
		End If				
		hasQSValues = boardItems.initializeFPValues()
		boardInit.Text = boardItems.initializeBoard(userGUID)		
		headItems.Text = boardItems.getHeadItems()	
		forumID = boardItems._forumID()
		loadForm = boardItems._loadForm()	
		
		If hasQSValues = False Then		'-- not a form post, load top of forum listing
			forumList.text = boardItems.forumTopLevel(userGUID)
			forumTop.Text = boardItems.forumTop(userGUID, false)
		Else
			If forumID > 0 and loadForm <> "" Then	
				forumTop.Text = boardItems.forumTop(userGUID, true)
				RetStr = boardItems.forumPostForm(userGUID)
				If Microsoft.VisualBasic.Left(RetStr, 1) = "/" Then
					Response.Redirect(RetStr)
					'forumList.Text = RetStr
				Else
					forumList.Text = RetStr
				End If
					
			End If
		End If 
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
						<asp:Literal id="boardInit" runat="server" />
						<asp:Literal id="forumTop" runat="server" />
						<asp:Literal id="forumList" runat="server" />
					</td>
				</tr>  	
			</table>
		</td></tr></table>
	</body>
</html>
