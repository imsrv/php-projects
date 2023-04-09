<%@ Page Language="vb"  %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Dim siteRoot as String = ""
	Sub Page_Load
		Dim boardItems as new bbForum
		Dim userGUID as String = ""
		Dim sendToNull as String = ""
		userGUID = boardItems.getUserCookie("uld")
		If userGUID = "" Then		
			userGUID = boardItems.GUEST_GUID
		End If			
		sendToNull = boardItems.initializeBoard(userGUID)
		siteRoot = boardItems.siteRoot
		headItems.Text = boardItems.getHeadItems()
		userTitles.Text = boardItems.listUserTitles()
	End Sub	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>    
		<asp:Literal ID="headItems" runat="server" />
	</head>
	<body topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">
		<a name="top"></a>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td background="<% =siteroot %>/images/help/navbar.gif">&nbsp;</td>
				<td background="<% =siteroot %>/images/help/navbar.gif" align="right"><a href="http://www.dotnetbb.com" target="_blank"><img src="<% =siteroot %>/images/help/nav_logo.gif" alt="dotNetBB Forums" border="0"></a></td>
			</tr>
		</table>
		<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td align="center" class="msgFormHead" colspan="2">dotNetBB Forum Help</td></tr>
			<tr><td class="msgTopicHead"><a name="intro"></a><b>Introduction</b></td><td class="msgTopicHead" align="right">&nbsp;</td></tr>
			<tr><td class="msgHelpBody" colspan="2">
			<b>Welcome!</b><br />
			<p>This forum is powered by <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a>, the next generation in forum technology using Microsoft's .NET programming framework.  Designed for ease of use and 
			high speed performance, <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a> is 'THE' forum to use for your community messaging needs.</p>
			<p>This help documentation is here to assist you in learning the features of the forum, so please take a few minutes to read thru it.
			You can return to this help documentation at any time by clicking on the 'HELP' link on the upper right corner of the forum.</p>
			<p>Happy Posting,<br />The <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a> development team</p>			
			<p>&nbsp;</p>
			</td></tr>
			<tr><td class="msgTopicHead"><a name="profile"></a><b>User Profiles</b></td><td class="msgTopicHead" align="right"><a href="#top">Back to Top</a></td></tr>
			<tr><td class="msgHelpBody" colspan="2">
			<a name="1.1"></a><b>Why Register?</b><br />
			In order to use the forum to its full extent, you must be a registered member.  Registration does not cost anything and adds the following features (if not separately disabled by an administrator) :
			<ul>
				<li>Posting forum messages.</li>
				<li>Replying to other peoples forum posts.</li>
				<li>Editing and deleting your forum posts.</li>
				<li>Subscribe to forum postings with e-mail notification.</li>
				<li>Send and receive private messages with other forum members.</li>
				<li>...and more</li>
			</ul>
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="1.2"></a><b>How do I register?</b><br />
			Simple. <a href="<% =siteRoot %>/r.aspx" target="_blank">CLICK HERE</a> and fill out the profile form.
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="1.3"></a><b>How do I change my profile?</b><br />
			When you are logged in to the forum, you can change your profile by clicking on the 'My Profile' link in the top right section of the forum.  All fields can be changed with the exception of your user name.  
			Once you pick a user name it is yours to keep and only a forum administrator can change it.  When creating or editing your profile your real name, user name, password and e-mail address are all required fields.
			All other fields are optional but you are encouraged to complete the profile form as much as possible.
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="1.4"></a><b>I forgot my login. Now what do I do?</b><br />
			Retrieving forgotten login information is as simple as knowing the e-mail address you used when creating your account.  
			Below any page requiring you to log in is a link that will help you remember your login information.  For this reason it is very
			important that you enter your correct e-mail address in your member profile and keep this up to date if your e-mail address changes in the future.
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="1.5"></a><b>What about cookies?</b><br />
			Cookies are used on this forum to track your user session.  While the cookie does not store your user name or password, it does store a unique ID that is assigned to your login. If you are using the forum on a public PC (such as in the library or at school), it is suggested that 
			you click the 'Log Out' link at the top of the forum when you session is completed.
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="1.6"></a><b>How do I use a signature with my posts?</b><br />
			Like in real life, your signature is your unique way of signing off on the words you say.  A forum posting is no different, so <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a> allows all registered
			members the option of creating a custom signature to be included in their postings.  You can edit your signature by clicking on the 'Modify Profile' link.  While HTML is not allowed, you can use <a href="mCode.aspx">mCode</a> in 
			your signature to customize the way it looks.
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="1.7"></a><b>What are Avatars and how do I get one?</b><br />
			Avatars are the small pictures that may appear under a members name when they post in a forum.  While not required (and if enabled by the forum administrator), you can customize your
			avatar from a selection of images already on the server or provide a URL to your personal avatar image by modifying your user profile.  You can modify your profile by clicking on the 
			'Modify Profile' link in the top right portion of the forum.
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="1.8"></a><b>There is a title under my name on my posts.  How did that get there?</b><br />
			The title appears for one of two reasons.  First, you can add you own custom title by going to the "Edit Options" section of your control panel. 
			Second, if you do not define a custom title, the forum administrator has the option of defining custom titles based on the number of forum posts you have created.  Here is a listing of the
			current titles offered and the number of posts required for each title.<br />&nbsp;<div align="center">
			<asp:Literal ID="userTitles" Runat="server" /></div>
			<p>&nbsp;</p>
			</td></tr>
			
			<tr><td class="msgTopicHead"><a name="message"></a><b>Reading & Posting Messages</b></td><td class="msgTopicHead" align="right"><a href="#top">Back to Top</a></td></tr>
			<tr><td class="msgHelpBody" colspan="2">
			<a name="2.1"></a><b>My HTML code isn't working in my posts. Why not?</b><br />
			Due to formatting and security issues HTML is not allowed in your forum posts.  Rather than using HTML you can use <a href="<% =siteroot %>/mCode.aspx">mCode</a>, a pseudo-HTML code replacement language, in your forum posts.
			<a href="<% =siteroot %>/mCode.aspx">mCode</a> is designed to be simple to use and semi-familiar to anyone who has used other forums on the Internet.  
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.2"></a><b>What are 'Emoticons' and how do I use them?</b><br />
			Emoticon, an acronym for emotion icon, a small icon composed of punctuation characters that indicates how an message 
			should be interpreted (that is, the writer's mood). For example, a :-) emoticon indicates that the message is meant as a 
			joke and shouldn't be taken seriously.  <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a> takes the text emoticon one step further
			by replacing common emoticon text with graphical images, while adding in additional text replacements to the common emoticons.  An example would be
			converting a :-) to <img src="<% =siteRoot %>/emoticons/smile.gif" alt=":-)">.  A short listing of the available emoticons is available when posting a new 
			message to the left of your message box.  You can view all available emoticons by clicking on the "More..." link at the bottom of the emoticon list.<br />
			<div align="center"><img src="<% =siteroot %>/images/help/emotpanel.gif" border="1" bordercolor="#000000" alt="Emoticon Panel" /></div>
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.3"></a><b>Can I be notified by e-mail of reply postings?</b><br />
			There are 2 types of message notification subscriptions that can be used with <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a>.<br />
			<p> - <b>Reply Notification :</b><br />Simply put, e-mail reply notification is an option that can be chosen when you post a message on the forum.  If selected, when anyone posts a reply
			to a message you posted, you will receive a notification by e-mail that a reply post has been made.</p>
			<p> - <b>Forum Subscription :</b><br />You have the option of subscribing to an individual forum by clicking on the <img src="<% =siteroot %>/images/help/tp_subscribe.gif" border="0" alt="subscribe"> link found at the top of the forum
			thread listing.  By clicking this link you will receive a notification by e-mail when any new or reply messages are posted to that forum regardless of you posting or not.  Warning, 
			subscribing to busy forums can lead to large quantities of notification e-mail messages.  You can unsubscribe at any time by clicking on the <img src="<% =siteroot %>/images/help/tp_unsub.gif" border="0" alt="unsubscribe"> link
			at the top any forum you are subscribed to.
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.4"></a><b>Can I edit the messages I posted?</b><br />
			Of course you can edit your posts.  We all make mistakes at times and type in the wrong thing, needing to go back later and correct what was said.  
			For that reason, you can click on the 'Edit' button that will appear on any of the messages you posted when you are logged in to the forum.
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.5"></a><b>Why did my post change and it says it was edited by a moderator?</b><br />
			From time to time the forum administrators and moderators might feel the need to edit your post.  This can be done for various reasons, most of which
			can be better explained by them.
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.6"></a><b>Why were some of the words in my post replaced?</b><br />
			The forum administrators have the option of replacing words that may be offensive or unacceptable for the forum.  If used, this administrative
			feature would replace any words in your post that are on their list of censored words.
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.7"></a><b>Where did the {insert forum name} forum go?  I know I saw it here before.</b><br />
			Some forums are restricted from viewing if you are not logged in.  For best use, ensure that you are logged in to the forum when browsing thru the posts.
			
			
			<p>&nbsp;</p>
			</td></tr>
			<tr><td class="msgTopicHead"><a name="general"></a><b>General Forum Info</b></td><td class="msgTopicHead" align="right"><a href="#top">Back to Top</a></td></tr>
			<tr><td class="msgHelpBody" colspan="2">			
			<a name="3.1"></a><b>Can I search the forums?</b><br />
			You can find the search form for the forum by clicking on the <img src="<% =siteroot %>/images/help/tp_search.gif" border="0" alt="Search The Forum"> link at the top of the forum pages.  Using keywords you can search any of the
			forums you have access to.  You have the option of filtering the results by selecting the forums to be searched, time range, and maximum number of posts returned.
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="3.2"></a><b>Private Messaging</b><br />
			If enabled on the forum, private messaging is similar to e-mail, but limited to sending and receiving messages between registered members.
			You can use <a href="mCode.aspx">mCode</a> in your private messages that are sent and received.  The administrator has the option of 
			placing a limit on the number of messages that will be stored for each user, so be sure to watch your mailbox size as you will be unable to send if
			you exceed the maximum allowable stored message count.  If you notice that your close to exceeding (or have exceeded) the maximum stored message count,
			you might want to delete some of your 'Sent Messages', as a copy of all messages you send are saved. 
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="3.3"></a><b>Where can I get more information about running a <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a></a> forum?</b><br />
			Simple, visit our site online at <a href="http://www.dotNetBB.com" target="_blank">www.dotNetBB.com</a> for more information.
			
			<p>&nbsp;</p>
			</td></tr>
		<tr><td class="msgHelpBody" colspan="2">
		<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
		
		</td></tr>
		</table>
		<table border="0" cellpadding="3" cellspacing="0" style="width:100%;height:100px;">
			<tr>
				<td class="copyRight" align="center" valign="bottom">
					Forum powered by dotNetBB v2.1<br />
					<a href="http://www.dotnetbb.com" target="_blank">dotNetBB</a>&nbsp; 
					&copy;&nbsp;2000-2002 <a href="mailto:Andrew@dotNetBB.com">Andrew Putnam</a>
				</td>
			</tr>
		</table>

	</body>
</html>
