<%@ Page Language="vb"  %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Dim siteRoot as String = ""
	Sub Page_Load
		Dim boardItems as new bbForum
		Dim userGUID as String = ""
		Dim sendToNull as String = ""
		siteRoot = boardItems.siteRoot
		userGUID = boardItems.getUserCookie("uld")
		If userGUID = "" Then		
			userGUID = boardItems.GUEST_GUID
		End If			
		sendToNull = boardItems.initializeBoard(userGUID)
		headItems.Text = boardItems.getHeadItems()			
	End Sub	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>    
		<asp:Literal ID="headItems" runat="server" />
	</head>
	<body topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">
		<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td class="msgFormHead" align="center">dotNetBB Forum Help</td></tr>
			<tr><td class="msgTopic"><a href="<% =siteRoot %>/" target="_top">Back to the forum</a></td></tr>
			<tr><td class="msgTopic"><a href="helpdoc.aspx" target="doc">Introduction</a></td></tr>
			<tr><td class="msgTopic">
				<a href="helpdoc.aspx#profile" target="doc">User Profiles</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#1.1" target="doc">Why register?</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#1.2" target="doc">How do I register?</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#1.3" target="doc">Change My Profile</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#1.4" target="doc">I Forgot My Login</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#1.5" target="doc">Cookie Usage</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#1.6" target="doc">Post Signature</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#1.7" target="doc">User Avatars</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#1.8" target="doc">User Titles</a><br />
				
			</td></tr>			
			<tr><td class="msgTopic">
				<a href="helpdoc.aspx#message" target="doc">Reading & Posting Messages</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#2.1" target="doc">My HTML isn't working</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#2.2" target="doc">Emoticons</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#2.3" target="doc">E-Mail Notifications</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#2.4" target="doc">Editing My Posts</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#2.5" target="doc">Moderator Edits</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#2.6" target="doc">Word Censoring</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#2.7" target="doc">Missing Forums</a><br />
			
			</td></tr>
			<tr><td class="msgTopic"><a href="mCode.aspx" target="doc">mCode Reference</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.1" target="doc">Bold</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.2" target="doc">Italic</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.3" target="doc">Underline</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.4" target="doc">Subscript</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.5" target="doc">Superscript</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.6" target="doc">Font Color</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.7" target="doc">Font Size</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.8" target="doc">Images</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.9" target="doc">Hyperlink (URL & E-mail)</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.10" target="doc">Lists</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.11" target="doc">Quote</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.12" target="doc">Code</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.13" target="doc">Flash</a><br />
				&nbsp;&nbsp; - <a href="mCode.aspx#1.14" target="doc">Emoticon</a><br />				
			</td></tr>
			<tr><td class="msgTopic">
				<a href="helpdoc.aspx#general" target="doc">General Forum Info</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#3.1" target="doc">Searching the Forum</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#3.2" target="doc">Private Messaging</a><br />
				&nbsp;&nbsp; - <a href="helpdoc.aspx#3.3" target="doc">I Want My dotNetBB</a><br />
				
				<p>&nbsp;</p>
				<p>&nbsp;</p>
			</td></tr>
		</table>
	</body>
</html>
