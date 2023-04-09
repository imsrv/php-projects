<%@ Page Language="vb" debug="true"%>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
' Printer Friendly version page.  Do not add additional html to this page 
' unless it is expected in the printer friendly version.
	Sub Page_Load
		Dim boardItems as new bbForum			'-- Initializes the message board
		Dim userGUID as String = ""				'-- Holds the user's GUID
		Dim hasQSValues as Boolean = False		'-- If the page has querystring values
		Dim forumID as Integer = 0				'-- Holds the current forum ID
		Dim messageID as Integer = 0			'-- Holds the current message thread ID
		Dim currentPage as Integer = 1			'-- Holds the current page number
		Dim perPage as Integer = 50				'-- Holds the max items per page to be viewed
		dim loadForm as String = "x"			'-- Holds the form id to be loaded
		
		
		'-- initialize userGUID and queryString values
		hasQSValues = boardItems.initializeQSValues()
		If hasQSValues = False Then
			hasQSValues = boardItems.initializeFPValues()
		End If
		
		forumid = boardItems._forumID			
		messageID = boardItems._messageID
		loadForm = boardItems._loadForm
		userGUID = boardItems.getUserCookie("uld")
		If userGUID = "" Then									
			userGUID = boardItems.GUEST_GUID		
		Else													
			boardItems.setUserCookie("uld", userGUID)	
		End If
		
		boardInit.Text = boardItems.initializeBoard(userGUID)	
		headItems.Text = boardItems.getHeadItems()	
		forumList.Text = boardItems.initializeForumList(userGUID, hasQSValues)
		forumTop.Text = boardItems.initializeForumTop(userGUID, hasQSValues)
		
		'-- End initialize		
	End Sub	
	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>    
    <asp:Literal ID="headItems" runat="server" />	
  </head>
  <body topmargin="2" marginheight="0" leftmargin="2" marginwidth="0">
  <table border="0" cellpadding="0" cellspacing="0" class="tblStd" width="100%">
	<tr><td class="msgSm">
		<asp:Literal id="boardInit" runat="server" />
		<asp:Literal id="forumTop" runat="server" />
		<asp:Literal id="forumList" runat="server" />
	</td></tr>  	
</table>
</div>
&nbsp;
</body>
</html>
