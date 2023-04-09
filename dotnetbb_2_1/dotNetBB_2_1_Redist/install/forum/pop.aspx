<%@ Page Language="vb"  %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Sub Page_Load
		Dim boardItems as new bbForum			'-- Initializes the message board
		Dim userGUID as String = ""				'-- Holds the user's GUID
		Dim hasQSValues as Boolean = False		'-- If the page has querystring values
		Dim wizardID as Integer = 0				'-- Holds the Popup Wizard ID	
		dim flashURL as string = ""
		Dim flashHeight as String = "200"
		Dim flashWidth as String = "200"
		dim flashVersion as String = "5"	
		Dim sendToNull as String = ""
		userGUID = boardItems.getUserCookie("uld")
		If userGUID = "" Then		
			userGUID = boardItems.GUEST_GUID
		End If	
		sendToNull = boardItems.initializeBoard(userGUID)
		headItems.Text = boardItems.getHeadItems()
		hasQSValues = boardItems.initializeQSValues()
		If hasQSValues = False Then
			hasQSValues = boardItems.initializeFPValues()
		End If
		If hasQSValues = True Then
			wPanel.Text = boardItems.loadWizard()
		End If		
		'-- End initialize
	End Sub	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>    
		<asp:Literal ID="headItems" runat="server" />
	</head>
	<body topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">
		<asp:Literal ID="wPanel" Runat="server" />
	</body>
</html>
