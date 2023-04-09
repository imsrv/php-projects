<%@ Page Language="vb" %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Sub Page_Load
		Dim boardItems as new bbForum			'-- Initializes the message board
		headItems.Text = boardItems.getHeadItems()	'-- <head></head> itemsfile
	End Sub	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>    
		<asp:Literal ID="headItems" runat="server" />
	</head>
<frameset cols="200,*" frameborder="1">
	<frame name="nav" src="helpnav.aspx" />
	<frame name="doc" src="helpdoc.aspx" />
</frameset>
</html>
