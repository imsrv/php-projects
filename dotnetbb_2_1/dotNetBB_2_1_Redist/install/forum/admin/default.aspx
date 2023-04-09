<%@ Page Language="vb" debug="true" %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Dim allowAccess as Boolean = False

	Sub Page_Load
		Response.Expires = -1
		Dim adminItems as New bbAdmin			'-- Initializes the message board admin area
		Dim userGUID as String = ""					'-- Holds the user's GUID
		Dim hasQSValues as Boolean = False			'-- If the page has querystring values
		Dim formID as Integer = 0					'-- The admin form to load
		
		userGUID = adminItems.getUserCookie("uld")
		If userGUID = "" Then									'-- set as guest
			userGUID = adminItems.GUEST_GUID		
		Else													'-- update user cookie
			adminItems.setUserCookie("uld", userGUID)	
		End If
		
		headItems.Text = adminItems.getHeadItems()	'-- <head></head> itemsfile
		allowAccess = adminItems.checkAdminAccess(userGUID)		
		If allowAccess = False Then				'-- if not admin or moderator, redirect to forum root
			Response.Redirect(adminItems.getRoot())
		Else
			adminMenu.Text  = adminItems.printAdminMenu(userGUID)
		End If		
		hasQSValues = adminItems.initializeQSValues()		
		If Request.ServerVariables("REQUEST_METHOD").ToLower = "post" Then
			hasQSValues = adminItems.initializeFPValues()
		End If		
		cFoot.Text = adminItems.printCopyright()		
		
		formid = adminItems._formID
		If formid > 0 Then
			adminForm.Text = adminItems.loadAdminForm(userGUID)	
		Else
			adminForm.Text = adminItems.loadAdminBase()
		End If		
		
		
		
		'-- End initialize
	End Sub	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>    
<asp:Literal ID="headItems" runat="server" />
</head>
<body topmargin="2" marginheight="0" leftmargin="2" marginwidth="0">
<div align="center">
	<table border="0" cellpadding="3" cellspacing="0" width="100%" height="550" class="tblStd">
		<tr>
			<td class="lgRowHead" valign="top" height="20" colspan="2">
			<b>dotNetBB Administration Panel</b>
			</td>
		</tr>
		<tr>
			<td class="sm" valign="top" width="180" style="background-color: #D4D0C8;"><br />
				<asp:Literal ID="adminMenu" Runat="server" />
				
			</td>
			<td class="sm" valign="top" style="background-color:#FFFFFF;" width="100%">
				<asp:Literal ID="adminForm" Runat="server" />
				<asp:Literal ID="adminToDo" Runat="server" />
			</td>
		</tr>
		<tr>
			<td class="smRowHead" valign="top" colspan="2" align="center" height="20">
				<asp:Literal ID="cFoot" Runat="server" />
			</td>
		</tr>
	</table>	
</div>
<p>&nbsp;</p>	
</body>
</html>
