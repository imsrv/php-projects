<%@ Page Language="vb" %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Dim siteRoot as String = ""
	Sub Page_Load
		Dim boardItems as new bbForum			'-- Initializes the message board
		Dim userGUID as String = ""
		Dim sendToNull as String = ""
		userGUID = boardItems.getUserCookie("uld")
		If userGUID = "" Then		
			userGUID = boardItems.GUEST_GUID				'-- GUEST
		End If			
		sendToNull = boardItems.initializeBoard(userGUID)
		siteRoot = boardItems.siteRoot
		headItems.Text = boardItems.getHeadItems()	'-- <head></head> itemsfile		
		
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
			<tr><td align="center" class="msgFormHead" colspan="2">Administrative Help</td></tr>
			<tr><td class="msgTopicHead"><a name="intro"></a><b>Introduction</b></td><td class="msgTopicHead" align="right">&nbsp;</td></tr>
			<tr><td class="msgHelpBody" colspan="2">
			<b>Welcome!</b><br />
			<p>This forum is powered by <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a>, the next generation in forum technology using Microsoft's .NET programming framework.  Designed for ease of use and 
			high speed performance, <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a> is 'THE' forum to use for your community messaging needs.</p>
			<p>This help documentation is here to assist you in learning the administrative features of the forum, so please take a few minutes to read thru it.
			You can return to this help documentation at any time by clicking on the 'Administrative Help' link on the left navigation of the forum admin pages.</p>
			<p>Should you have any questions not answered in this manual, please visit our administrative forums online at <a href="http://www.dotNetBB.com" target="_blank">dotNetBB.com</a>.  Thank you again 
			for your support in purchasing this product.</p>
			<p>Happy Posting,<br />The <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a> development team</p>			
			</td></tr>
			<tr><td class="msgTopicHead"><a name="config"></a><b>Forum Configuration</b></td><td class="msgTopicHead" align="right"><a href="#top">Back to Top</a></td></tr>
			<tr><td class="msgHelpBody" colspan="2">
			<a name="1.1"></a><b>Web.Config Viewer</b><br />
			Due to security reasons, namely the desire to NOT enable write permissions for the ASP.NET user account, the Web.Config viewer is available.
			The primary purpose of this tool is to, at a glance, view your web.config settings related to the forum.  Any changes to your Web.Config file must
			be done manually without the use of the forum tools.  These seven &quot;key&quot; values in your Web.Config are required for the forum to function properly :<br /><br />
			Key Example : &lt;add key=&quot;boardTitle&quot; value=&quot;The dotNetBB Message Board&quot; /&gt;
			<ul>
				<li>siteURL : The base URL for your server.  DO NOT include a trailing /.</li>
				<li>rootPath : The path after the siteURL to the root of your forum.  DO NOT include a trailing /. </li>
				<li>boardTitle : This is used across the forum and for the notification e-mails.</li>
				<li>siteAdmin : The name of the forum administrator used across the forum and for the notification e-mails.</li>
				<li>siteAdminMail : The e-mail address of the forum administrator used across the forum and for the notification e-mails.</li>
				<li>smtpServer : If you are not using the local SMTP server, enter in the DNS name or IP Address of a valid SMTP server.  Leave the value as "" to use the local SMTP server.</li>
				<li>dataStr : VERY IMPORTANT!  This is the connection string for your SQL server.  Currently ONLY MS SQL Server is supported by dotNetBB. The connection string has 4 primary parts :
					<ol>
						<li>SERVER=YourServerName;</li>
						<li>DATABASE=TheForumDatabaseName;</li>
						<li>UID=TheUserName;</li>
						<li>PWD=ThePassword;</li>
					</ol>
				</li>
			</ul>
			Regarding the 'dataStr' key, if any of the four items are incorrect or missing, your forum will not load.  It is <b><u>HIGHLY</u></b> suggested that you <b><u>DO NOT USE</u></b> the 'SA' account with the
			forum.  You should create a separate user account with <b><u>ONLY</u></b> the permissions required for running the forum.  This account requires access to the SQL Server temp tables, as well as, assigning 'SELECT' permission to the SMB_Messages 
			table and 'EXECUTE' permission to all of the 'TB_...' stored procedures to run.  Additional assistance with this can be requested on the <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a> forums.
			<p>&nbsp;</p>
			</td></tr>
			<tr><td class="msgTopicHead"><a name="tools"></a><b>Forum Tools</b></td><td class="msgTopicHead" align="right"><a href="#top">Back to Top</a></td></tr>
			<tr><td class="msgHelpBody" colspan="2">
			<a name="2.1"></a><b>Forum Builder</b><br />
			You will use the Forum Builder tool to create, edit and reorganize your forum layout.  The Forum Builder is used with both category and forum modifications.			
			Forum categories allow you to group multiple forums together.  If you are running your board with multiple forums, categories make it easier
			for users to filter thru to what they are looking for easier.<br />
			<a name="2.1a"></a>
			<ul><b>Adding a Category</b>
				<li>Category Name : This is the primary name shown for the category</li>
				<li>Category Description (optional) : An optional sub-title to be used with the forum category.</li>				
			</ul>
			<a name="2.1b"></a>
			<ul><b>Deleting a Category</b>
				<li>You can only delete a category if it does not contain any forums.</li>
				<li>You will find categories that can be deleted in the Forum Categories Without Forums section.</li>			
				<li>Click on the "DELETE CATEGORY" button to remove the category permanently.</li>
				<li>You will be prompted to confirm your category deletion.</li>
			</ul>
			<a name="2.1c"></a>
			<ul><b>Re-ordering Categories</b>
				<li>You can change the category ordering by locating the <b>Move Category</b> section in the category you want to move and click on the <img src="<% =siteroot %>/admin/images/up.gif" border="0" alt="Move Up"> or <img src="<% =siteroot %>/admin/images/down.gif" border="0" alt="Move Down"> image.</li>
				<li>You can only change the order of the category if it has forums contained within.  Categories without forums are not shown on the live forum board.</li>				
			</ul>
			
			<a name="2.1d"></a>
			<ul><b>Adding a Forum</b> : Select the forum category from the available and use the included Add a Forum form included.
				<li>Forum Name : Simple.... the name of the forum</li>
				<li>Forum Description : What is the forum to be used for?  What is the purpose?</li>
				<li>Access Permission : 
					<ol>
						<li>Public : Guests can see the forum. All registered can post and view.</li>
						<li>Registered : Guests do not see the forum.  All registered can post and view.</li>
						<li>Private : Only assigned users will be able to see and post to the forum.</li>
					</ol>
				</li>
				NOTE : If you assign 'Private' access to a new forum, your account will be the only account given access by default.  You must add
				permission for additional users using the '<a href="#2.4">Private Forum Access</a>' tool.</p>
				<li>Posting Permission : Select who can post in the forum.
					<ol>
						<li>All can post & reply</li>
						<li>Moderators can post, Users can reply</li>
						<li>Moderators can post, Users cannot reply</li>
					</ol>
				</li>				
				
			</ul>
			<a name="2.1e"></a>
			<ul><b>Re-ordering a Forum</b>
				<li>You can change the order by locating the <img src="<% =siteroot %>/admin/images/up.gif" border="0" alt="Move Up"> or <img src="<% =siteroot %>/admin/images/down.gif" border="0" alt="Move Down"> images to the left of the forum name.</li>				
			</ul>
			<a name="2.1f"></a>
			<ul><b>Editing a Forum</b>
				<li>Click on the "EDIT" link to the right of the forum name.</li>
				<li>You can choose from the same options as when <a href="#2.1d">Adding a Forum</a></li>
				<li>You can move the forum to a different category by selecting from the available categories in the forum drop listing.</li>
			</ul>
			<a name="2.1g"></a>
			<ul><b>Deleting a Forum</b>
				<li>Click on the "DELETE" link to the right of the forum name.</li>
				<li>You will be prompted to confirm your forum deletion.</li>
				<li>NOTE : This will PERMANENTLY delete all posts contained within the forum being deleted!</li>				
			</ul>
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.2"></a><b>Emoticons</b><br />
			Using the emoticon tool, you can add, edit and remove emoticon replacements.  Available emoticons must be located in the '/(forum root)/emoticons/' folder on your site.
			Emoticons that are available in the folder, but not available for use will be located in the lower table (you might need to scroll down depending on the number of active emoticons).
			The default code replacement is the name of the image wrapped by colon's (e.g. :smile:).  
			<ul><b>Enabling new emoticons</b>
			<li>Locate the 'Inactive Emoticon' listing at the bottom of the page.</li>
			<li>Locate the emoticon image you want to enable and click on the 'ENABLE' link to the right of the image.</li>
			</ul><br />
			<ul><b>Editing emoticons</b>
			<li>Click on the 'EDIT' link to the right of the active emoticon.</li>
			<li>Edit the 'Code Replacement' (the text the user will type in their message to be replaced).</li>
			<li>Edit the 'Alt tag text' (the text shown when a user holds their cursor over the image).</li>
			<li>Click on the 'Update Emoticon' button.</li>
			</ul>
			<ul><b>Cloning emoticons</b> (allows for multiple text replacement codes for a single image)
			<li>Click on the 'CLONE' link to the right of the active emoticon.</li>
			<li>Edit the 'Code Replacement' (the text the user will type in their message to be replaced).</li>
			<li>Edit the 'Alt tag text' (the text shown when a user holds their cursor over the image).</li>
			<li>Click on the 'Clone Emoticon' button.</li>
			</ul>
			<ul><b>Disabling emoticons</b>
			<li>Locate the emoticon in the 'Active Emoticon' table.</li>
			<li>Click on the 'DISABLE' link to the right of the image.</li>
			</ul></p>
			
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.3"></a><b>Avatars</b><br />
			Avatars, when chosen by a user, will appear below their name on their forum postings (unless using a modified thread template).
			Avatars are must be located in the '/(forum root)/avatar/' folder on your site.  DO NOT DELETE the 'blank.gif' image in the avatar folder,
			it is used in the form as a placeholder image!
			<ul><b>Enabling Avatars</b>
			<li>Locate the avatar you want to enable in the 'Inactive Avatars' listing.</li>
			<li>Click on the avatar to enable it.</li>
			</ul>
			<ul><b>Disabling Avatars</b>
			<li>Locate the avatar you want to enable in the 'Inactive Avatars' listing.</li>
			<li>Click on the avatar to enable it.</li>
			<li>NOTE : Any users who were using the avatar that was just disabled will have their personal avatar removed.</li>
			</ul></p>
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.4"></a><b>Private Forum Access</b><br />
			Using the 'Private Forum Access' tool you can easily add or remove users to forums that are marked as 'Private'.
			<ul><b>Adding and Removing Access</b>
				<li>Select the private forum from the drop listing.</li>
				<li>If adding access, locate the user name in the 'Users WITHOUT Access' listing and click on the <input type="button" class="msgSmButton" value=">>"> button.</li>
				<li>If removing access, locate the user name in the 'Users WITH Access' listing and click on the <input type="button" class="msgSmButton" value="<<"> button.</li>
			</ul></p>
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.5"></a><b>Thread Pruning</b><br />
			'Thread Pruning' is used to clean up forum postings that did not have any follow-up reply messages posted to them.  NOTE : This
			tool <b><u>DELETE'S</u></b> the posts that are selected.  These posts can only be recovered from a previous database backup (you are backing up your 
			database right?).
			<ul><b>Thread Pruning : </b>
				<li>Select the forum or 'All Forums' from the drop listing depending on what you where you want to prune.</li>
				<li>Select the minimum age of the postings and click on the 'GO' button.</li>
				<li>You will be notified of the number of posts about to be deleted.  If you are satisfied with the pending results, click on the 'CONTINUE' button to prune the forums selected.</li>
			</ul></p>
			
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.6"></a><b>Sticky Thread</b><br />
			'Sticky Threads' are thread messages that are locked to the top of the forum, preceeding all other posts regardless of the last post date.
			<ul><b>Using the 'Sticky Thread' tool</b>
				<li>Select the forum containing the thread you want to stick or unstick.</li>
				<li>To make a thread 'sticky' select it from the upper subject drop listing and click on the 'MAKE STICKY' button.</li>
				<li>To stop a thread from being 'sticky' select it from the lower subject drop listing and click on the 'UNSTICK' button.</li>			
			</ul></p>
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.7"></a><b>Move A Thread</b><br />
			From time to time people might start a thread in the wrong forum.  Using the 'Move A Thread' tool you can set things straight.
			<ul><b>Moving a Thread : </b>
				<li>Select the forum from the drop listing containing the thread to be moved and click on the 'GO' button.</li>
				<li>Select the subject from the drop listing that you want to move.</li>
				<li>Select the destination forum from the drop listing and click on the 'GO' button.</li>
			</ul></p>
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.8"></a><b>Word Censoring</b><br />
			A necessary evil in a public forum is the capability to censor words that might be deemed offensive.  With that in mind, you can use
			the 'Word Censoring' tool to accomplish exactly that.  The word censor automatically does partial matches for the words you enter.  An example would be if you 
			put a filter on the word 'dog', it would catch the first 3 letters in the word 'dogma' in addition to every other instance of 'dog' in the posting.
			<ul><b>New word filter :</b>
				<li>Enter the word or phrase you want to filter in the box provided.</li>
				<li>Enter in the replacement text (e.g. ****) in the box provided.</li>
				<li>Select who the filter applies to :
					<ol>
						<li>Users : Applies to users, but moderators are NOT affected.</li>
						<li>Users and Moderators : Applies to ALL forum postings</li>
					</ol>					
				</li>
				<li>Click on the 'ADD NEW' button to add the filter once the previous steps are complete.</li>
			</ul>
			<ul><b>Current Filtered Word List :</b>
				<li>EDIT : Select this link to modify the word, replacement text or who it applies to.</li>
				<li>DELETE : Select this link to delete a word filter.  You will not be prompted to confirm the deletion.</li>
				<li>The remainder of the table shows the filtered word, the replacement text and who it applies to :
					<ol>
						<li>U : Applies to Users</li>
						<li>M : Applies to Moderators</li>
					</ol></li>
			</ul></p>
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.9"></a><b>Ban an IP Address</b><br />
			Banning by IP is one of three possible banning types enabled in the forum.  With the 'IP Ban' tool, you can enter a partial
			IP address using a '*' wildcard character, or a complete IP address to be matched.  NOTE : While IP banning works good with 
			people connecting with static IP addresses, if the IP you ban is part of a dynamic pool of assigned IP addresses, you might 
			ban someone other than you intended.  Any user who attemps to connect to the forum from an IP that is banned will be automatically
			redirected to the 'ip.aspx' page.  
			<ul><b>Ban an IP Address : </b>
				<li>Complete IP Address : 
					<ol>
						<li>Enter in the complete IP address to be banned in the box provided.</li>
						<li>Click on the 'BAN IP' button</li>
					</ol>
				</li>
				<li>IP Address Range :
					<ol>
						<li>Enter in the partial IP address with a '*' on the end (e.g. 127.0.0.*)</li>
						<li>Click on the 'BAN IP' button</li>
					</ol>				
				</li>				
			</ul>
			<ul><b>Removing an IP Address Ban :</b>
				<li>Select the banned IP Address or IP Address Range from the listing.</li>
				<li>Click on the 'REMOVE' button to remove the ban.</li>
			</ul></p>		
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.10"></a><b>Ban a E-Mail Address</b><br />
			Banning a e-mail address is the second of three possible banning types enabled in the forum.  Using the 'E-Mail Ban' tool
			will NOT prevent an existing user from accessing the forum (Use the '<a href="#2.13">Ban A User</a>' feature to block forum access by account).  
			What it will do is prevent a user from registering a new account with the banned e-mail address.  
			<ul><b>Ban a E-Mail Address: </b>
				<li>The entries are NOT case sensitive (e.g. info@dotnetbb.com == Info@dotNetBB.com)</li>
				<li>Enter in the complete E-Mail Address to be banned in the box provided.</li>
				<li>Click on the 'BAN E-EMAIL' button</li>
			</ul>
			<ul><b>Removing a E-Mail Address Ban :</b>
				<li>Select the banned E-Mail Address from the listing.</li>
				<li>Click on the 'REMOVE' button to remove the ban.</li>
			</ul></p>
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.13"></a><b>Ban a User</b><br />
			Banning a user is the third of the three possible banning types enabled in the forum. Banning a user is not a separate
			tool like the first two options, but is a sub-item of the '<a href="#3.3">Edit / Delete User Profiles</a>' tool.  By
			selecting the 'Lock User Account' option when viewing an individual user profile, you will enable or disable access to the forum.
			More information regarding this is can be found in the '<a href="#3.3">Edit / Delete User Profiles</a>' section of this manual.
			</p>
			
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="2.11"></a><b>Lock A Thread</b><br />
			We have all seen those forum threads that seem to go on forever at times (usually about nothing to boot) and wish we could just have the flame 
			war's stop.  Using the 'Lock Thread' tool, you can do just that.  The 'Lock Thread' tool prevents users from posting additional replies to a specific thread.
			Note : This does not stop them from starting a new thread, just prevents additional posts in the locked thread.
			<ul>
				<li>To lock a thread locate the first post in a thread and click on the 'lock topic' image <img src="<% =siteroot %>/admin/images/cmanual/timage/lockthreadbtn.gif" border="0" /> on the control toolbar.</li>
				<li>To unlock a thread locate the first post in a thread and click on the 'unlock topic' image <img src="<% =siteroot %>/admin/images/cmanual/timage/unlockthreadbtn.gif" border="0" /> on the control toolbar.</li>
			
			</ul>
			
			<p>&nbsp;</p>
		</td></tr>
<!-- USER TOOLS HELP //-->				
		<tr><td class="msgTopicHead"><a name="utools"></a><b>User Tools</b></td><td class="msgTopicHead" align="right"><a href="#top">Back to Top</a></td></tr>
		<tr><td class="msgHelpBody" colspan="2">
			<a name="3.1"></a><b>End User Experience</b><br />
			The 'End User Experience' tool will allow you to enable or disable primary features and setings for the forum.  Below is a listing of each
			item in the form.<br /><br /><a name="3.1a"></a>
			<ul><b>Site General</b>
			<li>Forum Authentication : This will choose what method of authentication is used with the forum.
				<ol>
					<li>dotNetBB Authentication : This uses the integrated authentication and login built into dotNetBB.</li>
					<li>NT Authentication : Selecting this option all user login is done using the integrated NT Authetication
					built into IIS.  For this to work properly, you must remove anonymous authentication from your forum folder using
					the IIS Management tools.  Users will still need to register accounts using the standard dotNetBB account registration
					tools, using their NT user account as their user name for the forum.  When using NT Authentication, passwords are not 
					stored in the database.</li>
				</ol>
			</li>
			<li>Show thread/post totals : This will show or hide the total number of posts and threads found on the main forum pages in the 'Forum Information' section.</li>
			<li>Show newest member : This will show or hide the newest member found on the main forum pages in the 'Forum Information' section.</li>
			<li>Show Who's Online : This will show or hide the list of active visitors found on the main forum pages in the 'Forum Information' section </li>
			<li>Allow users to subscribe to forums : This setting will allow or deny users the capability to subscribe to forums, receiving e-mail notifications of all new and reply postings in the subscribed forum.  NOTE : This is separate from the e-mail reply notification setting below.</li>
			<li>Default Site Theme : Allows you to define the default them for new members and guests.  For more information about site themes, please see THIS SECTION.</li>
			<li>COPPA Fax Number : The fax number to be shown on the COPPA forms that the parent or guardian will use to send you the registration forms.</li>
			<li>COPPA Mail Address : The physical mail address (NOT e-mail) where the parent or guardian can send the COPPA registration form.</li>
			</ul><br />
			<ul><b>Posting</b><a name="3.1b"></a>
			<li>Allow mCode in posts : This will enable or disable the use of <a href="<% =siteRoot %>/mCode.aspx">mCode</a> in forum posts</li>
			<li>Allow topic icons : This will enable or disable the use of topic icons with forum posts.</li>
			<li>Allow emoticons : This will enable or disable the use of emoticons in forum posts.</li>
			<li>Allow e-mail reply notifications : This will enable or disable the user's capability to request e-mail notifications of reply posts to a thread they started or replied to.</li>
			<li>Show end-user edited timestamp : This will enable or disable the addition of '<i>Last Edited...</i>' message when a user edits their own post.</li>
			<li>Show moderator edited timestamp : This will enable or disable the addition of '<i>Edited by Moderator...</i>' message when a moderator edits a user's post.</li>
			<li>Anti-Spam Timer : The minimum amount of time in seconds before a user can post additional messages.  This affects BOTH forum posts and private messages.</li>
			</ul><br />
			<ul><b>User Profiles</b><a name="3.1c"></a>
			<li>E-Mail verification for new accounts : This will enable or disable e-mail address verification for new accounts before the user is allowed to log into the forum the first time.</li>
			<li>View user profiles as guest : This will enable or disable the capability to view user profiles or links on the contact bar when visiting the forum as a guest.</li>
			<li>Allow Avatars : This will enable or disable the capability for users to add the use of an avatar in their profile.  This setting applies to both local and remote avatars.</li>
			<li>Allow Remote Avatars : This will enable or disable the capability for users to use remotely hosted avatar's in their profile.</li>
			<li>Remote avatar size (h,w) : This defines the shown height (h) and width (w) of the avatars for users who are using remote avatar's.  If both height and width are not entered as shown, 75x75 will be the default avatar size.</li>
			<li>Allow AIM : This will enable or disable the use of AOL Instant Messenger links in the user profile and on the contact bar.</li>
			<li>Allow Y! : This will enable or disable the use of Yahoo Pager (Y!) links in the user profile and on the contact bar.</li>
			<li>Allow MSN : This will enable or disable the use of Microsoft Messenger links in the user profile and on the contact bar.</li>
			<li>Allow ICQ : This will enable or disable the use of ICQ links in the user profile and on the contact bar.</li>
			<li>Allow E-Mail : This will enable or disable the use of e-mail links in the user profile and on the contact bar.</li>
			<li>Allow Homepage : This will enable or disable the use of personal URL links in the user profile and on the contact bar.</li>
			<li>Allow Signature : This will enable or disable the use of personal signatures in forum posts.</li>
			<li>Allow mCode in Signature : This will enable or disable the use of <a href="<% =siteRoot %>/mCode.aspx">mCode</a> in personal signatures.</li>			
			</ul><br />
			<ul><b>Private Messaging</b><a name="3.1d"></a>
			<li>Allow Private Messaging : This will enable or disable the use of private messaging on the forum.  This is a global setting for the forum, individual 
			users can be blocked by locking the private messaging using the 'Edit / Delete User Profile' tool.  </li>
			<li>Maximum saved messages per user : This defines the maximum number of messages that a user can keep in their personal message inbox and sent items folders.  If not defined, the default is 0.</li>
			</ul><br />
			<ul><b>Cookies</b><a name="3.1e"></a>
			<li>Cookie expiration (in days) : This defines the number of days before the user cookie expires.  If not defined, the user's browser maximum will be used. This only applies when using dotNetBB Authentication.</li>
			</ul>
			
			
			
			
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="3.2"></a><b>Add / Remove Custom Titles</b><br />
			Custom titles will appear below the user's name in forum posts (unless using a modified thread template).  The titles are based on the number of 
			posts that a user has created.  Forum moderators do not use custom titles, but instead are replaced with 'Forum Moderator' as their user title.
			Since the titles are based on the number of posts, you cannot create titles that would contain overlaping count values.  If all titles are removed, a default 
			title of 'Registered Member' with a range of 1 - 999,999 posts will be created automatically.
			<ul><b>Adding a custom title</b>
				<li>Enter the minium number of posts required for the title.</li>
				<li>Enter the maximum number of posts allowed for the title.</li>
				<li>Enter the title text (50 characters maximum).</li>
				<li>Click on the 'Add Me' button.</li>
			</ul><br />			
			<ul><b>Modifying a custom title</b>
				<li>Locate the title you want to modify and click on the 'MODIFY' link to the right of the title.</li>
				<li>Modify the minium number of posts required for the title.</li>
				<li>Modify the maximum number of posts allowed for the title.</li>
				<li>Modify the title text (50 characters maximum).</li>
				<li>Click on the 'UPDATE' button.</li>
			</ul><br />			
			<ul><b>Deleting a custom title</b>
				<li>Locate the title you want to remove and click on the 'DELETE' link to the right of the title.</li>
				<li>NOTE : You will NOT be prompted to confirm before the title is deleted.</li>
			</ul></p>
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="3.3"></a><b>Edit / Delete User Profiles</b><br />
			The 'Edit / Delete User Profiles' tool offers a simple way to modify user profiles from an administrative point of view.  Besides
			being able to modify the user's public profile, this tool can also be used to override user settings such as e-mail validation, account access and more.
			
			<ul><a name="3.3a"></a><b>Filtering Users</b> - You are given the following options for filtering thru the registered forum members :
			<li>First letter in the user name is a Special Character Or Numeric</li>
			<li>First letter in the user name is an Alphabetic Letter</li>
			<li>List All Users (non-moderator and non-admin)</li>
			<li>List All Moderators (<a href="#3.4">more info</a>)</li>
			<li>List All Administrators (<a href="#3.5">more info</a>)</li>			
			</ul>
			<ul><a name="3.3b"></a><b>Removing Users</b>
			<li>Locate the user using the filtering as explained <a href="#3.3a">above</a>.</li>
			<li>Click on the 'DELETE' link to the right of the user's name.</li>
			<li>You will be prompted only once to confirm the deletion of the user.</li>
			<li>NOTE : This will delete ALL posts made by the user in addition to their account.</li></ul>
			<ul><a name="3.3c"></a><b>Editing Users</b>
			<li>Locate the user using the filtering as explained <a href="#3.3a">above</a>.</li>
			<li>Click on the 'Edit' link to the right of the user's name.</li>
			<li>You can edit all fields including the 'User Name' field (not editable by the end-user).</li>
			<li>Click on the 'SUBMIT' button once editing is complete.</li>
			<li>NOTE : All required fields are still required!</li></ul>
			<ul><a name="3.3d"></a><b>Locking User Access</b> - Preventing users from logging in with their account.
			<li>Locate the user using the filtering as explained <a href="#3.3a">above</a>.</li>
			<li>Click on the 'Edit' link to the right of the user's name.</li>
			<li>The first option in the profile is a radio selection of 'Locked' or 'Not Locked'.  Choose your preference.</li></ul>
			<ul><a name="3.3e"></a><b>Locking Private Messaging</b> - Preventing users from using private messaging.
			<li>Locate the user using the filtering as explained <a href="#3.3a">above</a>.</li>
			<li>Click on the 'Edit' link to the right of the user's name.</li>
			<li>In the last section of the profile form is a radio selection for 'Administrative PM Lockout'.  Choose your preference.</li></ul>
			</p>
			
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="3.4"></a><b>Add / Edit Moderators</b><br />
			Using the 'Add / Edit Moderators' tool you can enable or disable moderator access for registered members.
			Adding a user to the moderator listing <b>DOES NOT</b> grant access to the administrative menu controls, that must be done using the
			'<a href=#3.5>Add / Edit Admin Menu Access</a>' tool.  What the moderators will be able to do is edit or delete user posts or
			threads in the forums they are granted access to.  If you want to grant permission to lock, unlock or create sticky threads, then you 
			must <b>ALSO</b> use the '<a href=#3.5>Add / Edit Admin Menu Access</a>' tool to grant those permissions.
			<ul><b>Adding a New Moderator</b>
				<li>Select the 'Add / Edit Moderators' link on the administration menu.</li>
				<li>Select the user name of the person who you want to grant moderator access from the drop listing.</li>
				<li>To APPROVE moderation permission select the name of the forum on the 'Not Moderating' listing and click on the <input type="button" value=">>" class="msgSmButton" /></li>
				<li>To REMOVE moderation permission select the name of the forum on the 'Moderating' listing and click on the <input type="button" value="<<" class="msgSmButton" /></li>
			</ul><br />
			<ul><b>Editing an existing Moderator</b>
				<li>Select the 'Add / Edit Moderators' link on the administration menu.</li>
				<li>Select the user name of the person who you want to grant moderator access from the 'Current Moderators' listing.</li>
				<li>To APPROVE moderation permission select the name of the forum on the 'Not Moderating' listing and click on the <input type="button" value=">>" class="msgSmButton" /></li>
				<li>To REMOVE moderation permission select the name of the forum on the 'Moderating' listing and click on the <input type="button" value="<<" class="msgSmButton" /></li>
			</ul></p>
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="3.5"></a><b>Add / Edit Admin Menu Access</b><br />
			The 'Add / Edit Admin Menu Access' tool allows forum administrators the ability to grant a tool-by-tool set of permissions
			to registered members.  While you might want to grant near full control of your forum's administration to selected users, 
			the '<a href="#1.1">Web.Config Viewer</a>' tool should <b><u>ONLY</u></b> be given to the most trusted users considering the 
			information contained within.  While they would not be able to edit the settings with the '<a href="#1.1">Web.Config Viewer</a>',
			creative users might use the information to obtain access with other software packages. NOTE : Giving a user administrative access with 
			this tool <b>DOES NOT</b> grant forum moderator control.  To give a user moderator permission use the '<a href="#3.4">Add / Edit Moderators</a>' tool. <br />
			<ul><b>Adding a New Administrators</b>
				<li>Select the 'Add / Edit Admin Menu Access' link on the administration menu.</li>
				<li>Select the user name of the person who you want to grant administrator access from the drop listing.</li>
				<li>To APPROVE administrator permission select the name of the menu item on the 'Unavailable Menu Items' listing and click on the <input type="button" value=">>" class="msgSmButton" /></li>
				<li>To REMOVE administrator permission select the name of the menu item on the 'Available Menu Items' listing and click on the <input type="button" value="<<" class="msgSmButton" /></li>
			</ul><br />
			<ul><b>Editing an existing Administrator</b>
				<li>Select the 'Add / Edit Admin Menu Access' link on the administration menu.</li>
				<li>Select the user name of the person who you want to grant moderator access from the 'Current Menu Access' listing.</li>
				<li>To APPROVE administrator permission select the name of the menu item on the 'Unavailable Menu Items' listing and click on the <input type="button" value=">>" class="msgSmButton" /></li>
				<li>To REMOVE administrator permission select the name of the menu item on the 'Available Menu Items' listing and click on the <input type="button" value="<<" class="msgSmButton" /></li>
			</ul></p>
			
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="3.6"></a><b>Administrative Mailer</b><br />
			The 'Administrative Mailer' tool will allow you to send e-mail messages to selected user groups from your forum members.
			When sending a message you can select from :<ul>
			<li>All Members : This will send to ever member of the forum with a valid e-mail address.</li>
			<li>Users Only : This will send to all members of the forum that are not moderators or administrators.</li>
			<li>Moderators Only : This will send to all members of the forum that are moderators.</li>
			<li>Administrators Only : This will send to all members of the forum that have administrator access.</li>
			</ul>
			Once you select the group to send to, enter in the e-mail subject and message body.  The message body is sent
			in HTML format, so you must use standard HTML formatting within the body of your message.
			</p>
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="3.7"></a><b>Who Voted</b><br />
			The 'Who Voted' tool will allow you to view the results of all polls that are running on the forum, and who has voted in 
			the poll.  To view an individual poll results and who voted, click on the 'Poll Subject'.
			</p>
			<p><hr size="1" align="center" width="75%" noshade /></p><a name="3.8"></a><b>Pending Accounts</b><br />
			The 'Pending Accounts' tool you can view any accounts that are waiting for e-mail verification.  This allows you to easily resend notification, 
			approve an account, or delete an account.  Click on the selected action to resend, approve or delete the account.  <br />
			NOTE : You will not be prompted	to confirm deletion of accounts prior to being deleted.
			</p>
			
			<p>&nbsp;</p>			
			<p>&nbsp;</p>			
			<p>&nbsp;</p>			
			<p>&nbsp;</p>			
			<p>&nbsp;</p>			
			<p>&nbsp;</p>			
			<p>&nbsp;</p>			
			<p>&nbsp;</p>			
		</td></tr>
		
		<tr><td class="msgHelpBody" colspan="2">		
		<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
		
		</td></tr>
		</table>
		<table border="0" cellpadding="3" cellspacing="0" style="width:100%;height:100px;">
			<tr>
				<td class="msgSm" align="center" valign="bottom">
					<a href="http://www.dotNetBB.com" target="_blank"><img src="<% =siteRoot %>/images/dotnetbbsmlogo.gif" border="0" alt="dotNetBB Forums"></a><br />
					Forum powered by dotNetBB v2.0<br />
					<a href="http://www.dotnetbb.com" target="_blank">dotNetBB</a>&nbsp; 
					&copy;&nbsp;Andrew Putnam 2000-2002, <a href="mailto:Andrew@dotNetBB.com">Andrew@dotNetBB.com</a>
				</td>
			</tr>
		</table>

	</body>
</html>
