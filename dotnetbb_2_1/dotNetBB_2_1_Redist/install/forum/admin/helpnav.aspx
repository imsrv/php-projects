<%@ Page Language="vb" %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Dim siteRoot as String = ""
	Sub Page_Load
		Dim boardItems as new bbForum			'-- Initializes the message board
		Dim userGUID as String = ""
		Dim sendToNull as String = ""
		siteRoot = boardItems.siteRoot
		userGUID = boardItems.getUserCookie("uld")
		If userGUID = "" Then		
			userGUID = boardItems.GUEST_GUID				'-- GUEST
		End If			
		sendToNull = boardItems.initializeBoard(userGUID)
		headItems.Text = boardItems.getHeadItems()	'-- <head></head> itemsfile		
	End Sub	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>    
		<asp:Literal ID="headItems" runat="server" />
	</head>
	<body topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">
		<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td class="msgFormHead" align="center">dotNetBB Admin Manual</td></tr>
			
			<tr><td class="msgTopic"><a href="<% =siteRoot %>/" target="_top">Back to the forum</a></td></tr>
			<tr><td class="msgTopic"><a href="<% =siteRoot %>/admin/" target="_top">Back to forum administration</a></td></tr>
			<tr><td class="msgTopicHead"><b>Administrative Help</b></td></tr>
			<tr><td class="msgTopic"><a href="<% =siteRoot %>/admin/helpdoc.aspx" target="doc">Introduction</a></td></tr>
			<tr><td class="msgTopic">
				<a href="<% =siteRoot %>/admin/helpdoc.aspx#config" target="doc">Forum Configuration</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#1.1" target="doc">Web.Config Viewer</a><br />
				&nbsp;
			</td></tr>
			<tr><td class="msgTopic">
				<a href="<% =siteRoot %>/admin/helpdoc.aspx#tools" target="doc">Forum Tools</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.1" target="doc">Forum Builder</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.1a" target="doc">Adding a Category</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.1b" target="doc">Deleting a Category</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.1c" target="doc">Re-ordering Categories</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.1d" target="doc">Adding a Forum</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.1e" target="doc">Re-ordering a Forum</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.1f" target="doc">Editing a Forum</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.1g" target="doc">Deleting a Forum</a><br />
				
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.2" target="doc">Emoticons</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.3" target="doc">Avatars</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.4" target="doc">Private Forum Access</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.5" target="doc">Thread Pruning</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.6" target="doc">Sticky Thread</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.7" target="doc">Move A Thread</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.8" target="doc">Word Censoring</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.9" target="doc">IP Ban</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.10" target="doc">E-Mail Ban</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#2.11" target="doc">Lock/Unlock Threads</a><br />							
				&nbsp;
			</td></tr>
			<tr><td class="msgTopic">
				<a href="<% =siteRoot %>/admin/helpdoc.aspx#utools" target="doc">User Tools</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.1" target="doc">End User Experience</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.1a" target="doc">Site General</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.1b" target="doc">Posting</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.1c" target="doc">User Profiles</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.1d" target="doc">Private Messaging</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.1e" target="doc">Cookies</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.2" target="doc">Custom Titles</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.3" target="doc">Edit / Delete User Profiles</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.3a" target="doc">Filtering Users</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.3b" target="doc">Removing Users</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.3c" target="doc">Editing Users</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.3d" target="doc">Lock Access</a><br />
				&nbsp;&nbsp; &nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.3e" target="doc">Lock Private Messaging</a><br />				
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.4" target="doc">Add/Edit Moderators</a><br />	
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.5" target="doc">Admin Menu Access</a><br />				
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.6" target="doc">Administrative Mailer</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.7" target="doc">Who Voted</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/helpdoc.aspx#3.8" target="doc">Pending Accounts</a><br />				
				&nbsp;
			</td></tr>
			<tr><td class="msgTopicHead"><b>dotNetBB Customization</b></td></tr>
			<tr><td class="msgTopic">
				<a href="<% =siteRoot %>/admin/custom.aspx" target="doc">Introduction</a><br />
			</td></tr>
			<tr><td class="msgTopic">
				<a href="<% =siteRoot %>/admin/custom.aspx#start" target="doc">Getting Started</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/custom.aspx#1.1" target="doc">Folder Structure</a><br />
			</td></tr>
			<tr><td class="msgTopic">
				<a href="<% =siteRoot %>/admin/custom.aspx#create" target="doc">Create a Theme</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/custom.aspx#2.1" target="doc">Requirements</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/custom.aspx#2.2" target="doc">Step 1</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/custom.aspx#2.3" target="doc">Step 2</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/custom.aspx#2.4" target="doc">Step 3</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/custom.aspx#2.5" target="doc">Step 4</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/custom.aspx#2.6" target="doc">Step 5</a><br />
				
			</td></tr>
			<tr><td class="msgTopic">
				<a href="<% =siteRoot %>/admin/custom.aspx#ref" target="doc">Reference</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/custom.aspx#3.1" target="doc">Style Reference</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/custom.aspx#3.2" target="doc">Post Icon Reference</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/admin/custom.aspx#3.3" target="doc">Image Reference</a><br />
				
			</td></tr>
			<tr><td class="msgTopicHead"><b>User Help</b></td></tr>
			<tr><td class="msgTopic"><a href="<% =siteRoot %>/helpdoc.aspx" target="doc">Introduction</a></td></tr>
			<tr><td class="msgTopic">
				<a href="<% =siteRoot %>/helpdoc.aspx#profile" target="doc">User Profiles</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#1.1" target="doc">Why register?</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#1.2" target="doc">How do I register?</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#1.3" target="doc">Change My Profile</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#1.4" target="doc">I Forgot My Login</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#1.5" target="doc">Cookie Usage</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#1.6" target="doc">Post Signature</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#1.7" target="doc">User Avatars</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#1.8" target="doc">User Titles</a><br />
				&nbsp;
			</td></tr>			
			<tr><td class="msgTopic">
				<a href="<% =siteRoot %>/helpdoc.aspx#message" target="doc">Reading & Posting Messages</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#2.1" target="doc">My HTML isn't working</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#2.2" target="doc">Emoticons</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#2.3" target="doc">E-Mail Notifications</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#2.4" target="doc">Editing My Posts</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#2.5" target="doc">Moderator Edits</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#2.6" target="doc">Word Censoring</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#2.7" target="doc">Missing Forums</a><br />
			&nbsp;
			</td></tr>
			<tr><td class="msgTopic"><a href="<% =siteRoot %>/mCode.aspx" target="doc">mCode Reference</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.1" target="doc">Bold</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.2" target="doc">Italic</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.3" target="doc">Underline</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.4" target="doc">Subscript</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.5" target="doc">Superscript</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.6" target="doc">Font Color</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.7" target="doc">Font Size</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.8" target="doc">Images</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.9" target="doc">Hyperlink (URL & E-mail)</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.10" target="doc">Lists</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.11" target="doc">Quote</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.12" target="doc">Code</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.13" target="doc">Flash</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/mCode.aspx#1.14" target="doc">Emoticon</a><br />
				&nbsp;			
			</td></tr>
			<tr><td class="msgTopic">
				<a href="<% =siteRoot %>/helpdoc.aspx#general" target="doc">General Forum Info</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#3.1" target="doc">Searching the Forum</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#3.2" target="doc">Private Messaging</a><br />
				&nbsp;&nbsp; - <a href="<% =siteRoot %>/helpdoc.aspx#3.3" target="doc">I Want My dotNetBB</a><br />
				
				<p>&nbsp;</p>
				<p>&nbsp;</p>
			</td></tr>
		</table>
	</body>
</html>
