<%@ Page Language="vb" %>
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
		
	End Sub	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>    
	<asp:Literal ID="headItems" runat="server" />
	</head>
	<body topmargin="5" marginheight="0" leftmargin="0" marginwidth="0">
		<a name="top"></a>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td background="<% =siteroot %>/images/help/navbar.gif">&nbsp;</td>
				<td background="<% =siteroot %>/images/help/navbar.gif" align="right"><a href="http://www.dotnetbb.com" target="_blank"><img src="<% =siteroot %>/images/help/nav_logo.gif" alt="dotNetBB Forums" border="0"></a></td>
			</tr>
		</table>
		<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td class="msgFormHead" colspan="2">dotNetBB Customization Help</td></tr>
			<tr><td class="msgTopicHead"><a name="intro"></a><b>Introduction</b></td><td class="msgTopicHead" align="right">&nbsp;</td></tr>
			<tr><td class="msgHelpBody" colspan="2">
			<p>One of the primary requirements of any successful forum integration is the capability to obtain the look and feel of an existing
			web site.  This help manual will attempt to explain how to customize your installation of dotNetBB, in addition to what is involved in creating multiple styles for your users
			to choose between.</p>			
			<p>In addition to this manual, you are encouraged to visit the 'Theme Development' forum on the <a href="http://www.dotNetBB.com" target="_blank">dotNetBB.com</a> web site for up to date information and peer support regarding
			the creation of forum themes.</p>
			<p>&nbsp;</p>
			</td></tr>
			<tr><td class="msgTopicHead"><a name="start"></a><b>Getting Started</b></td><td class="msgTopicHead" align="right"><a href="#top">Back to Top</a></td></tr>
			<tr><td class="msgHelpBody" colspan="2">
			<a name="1.1"></a><b>Theme Folder Structure</b><br />
			<img src="<% =siteRoot %>/admin/images/cmanual/folders.gif" alt="Theme folder layout" border="0" align="right" />
			Under your forum root folder is a folder called 'styles'.  It is under this folder you will create or modify your various site themes.
			Each theme should have a unique name that the end user can easily relate with the look of the theme (e.g. 'midnight' for a darker colored theme).  The individual theme folder names
			are used in the drop down selection that the user's will choose from when deciding which theme they want to use in their profile.
			DO NOT include spaces in the folder name as some browsers (primarily anything that is not IE) have problems with file and folder
			paths that include spaces.<br /><br />
			Looking at the image of the folder layout to the right, you can see that under the theme folder there are 2 additional
			folders 'css' and 'images'.  I think you can probably guess what will exist in those folders, but for the sake of making
			this manual complete, I will explain.<br /><br />
			
			<ul><b>Theme Sub-Folders</b> (in this case 'default')
			<li>css : Contains a single file called 'style.css'.  This is the style sheet for the theme that will
			contain the color customizations required for your theme.</li>
			<li>images : Contains multiple image files.  The images contained within this folder are the unique images for
			each individual style and are modifyable or replacable to best fit you your design needs.  NOTE : All files must 
			exist with the same file name as the 'default' style or you will have missing image tags like this ... <img src="null.gif" border="1" height="10" width="10"> on your forum.</li>
			<li>Three additional files : The three 'style-...htm' files that are in the root of the theme folder are the repeating templates
			that will be used in changing the layout of the 3 levels of the forum listing.  More about this later.</li>
			</ul>			
			<p>&nbsp;</p>
			</td></tr>
			<tr><td class="msgTopicHead"><a name="create"></a><b>Creating a New Theme</b></td><td class="msgTopicHead" align="right">&nbsp;</td></tr>
			<tr><td class="msgHelpBody" colspan="2" align="center">
			Creating a new theme is easy, making it look good takes <i>time and patience</i>.
			<a name="2.1"></a>
			<p>Depending on how much customization of your forum you would like to do, here is a list of the basic items you will need :
				<ul>
					<li>A working knowledge of HTML and Cascading Style Sheets.</li>
					<li>A plain text editor. Notepad will do just fine, but do NOT use a WYSIWYG program like MS Word&trade; to create your templates (explained more later).</li>
					<li>A image tool to create your customized images.  Many of the source images for dotNetBB are included in Adobe Photoshop (.psd) format to assist you in creating your images quicker.</li>
					<li>A bit of time to kill...</li>
				</ul>
				
			<a name="2.2"></a><b>STEP 1 : Giving your theme a name</b><br />
			Simple rules to naming a theme.
			<ul>
				<li>Theme names should be short and descriptive.</li>
				<li>Your theme name should NOT include spaces.</li>
			</ul>
			Once you have decided on a name for the theme, find the "styles" folder (see the image in '<a href="#start">Getting Started</a>' for reference) and create a new folder with the name you decided on for your theme.
			<br /><br />
			<a name="2.3"></a><b>STEP 2 : Copy</b><br />
			Rather than trying to reinvent the wheel, take all the files and folders from the 'default' style folder and COPY (do NOT move!) them to your newly created folder.  This will ensure that all of the base files needed
			exist in your new theme design.
			<br /><br />
			<a name="2.4"></a><b>STEP 3 : It's all about style</b><br />
			The quickest theme modification can be done by simply modifying the 'style.css' file in the "/(theme name)/css/". 
			This file defines all of the colors, fonts, and and background images for your forum theme.  A complete reference of
			the various class tags and locations they are used can be found below in the '<a href="#3.1">Style Reference</a>'.
			<br /><br />
			<a name="2.5"></a><b>STEP 4 : Templates</b><br />
			There are 3 template files that can be modified to change the way the forum look.  All of them are based on HTML and 'should' be easy to 
			understand if you have a working knowledge of HTML tables.  Since these are templates, they are only sections of code, NOT complete
			web pages.
			<ul>
				<li>style-listForum.htm : Used with a single forum listing</li>
				<li>style-listThread.htm : Used with a single message thread</li>
				<li>style-topForum.htm : Used with the main forum listing</li>
			</ul>
			Each of the templates is a single row in the corresponding section, and is repeated automatically in the dotNetBB engine. 
			<ul><b>style-listForum.htm</b>
				<li>{ClassTag} : replaced with 'msgTopicHead' or 'msgTopic' (depending on if it is a title row or not) if you do not specify another</li>
				<li>{IsNewIcon} : replaced with the 'newtopic.gif' or 'topic.gif' depending on if the post is new</li>
				<li>{ICON} : replaced with the post icon if used by the person who started the thread</li>
				<li>{TopicTitle} : the subject of the thread</li>
				<li>{Replies} : number of replies to the thread</li>
				<li>{Views} : number of times the thread has been viewed</li>
				<li>{LastPost} : the last poster's name and the date/time it was posted</li>
				<li>{FirstPost} : who started the thread</li>
			</ul>
			<ul><b>style-listThread.htm</b>
				<li>{ClassTag} : replaced with the 'msgUser' class if you do not specify another</li>
				<li>{UserName} : the user name of the person who posted the message linked to their profile page</li>
				<li>{UserTitle} : the user's title based on what is set in the admin panel for the number of messages posted</li>
				<li>{UserAvatar} : replaced with the user's avatar if selected in their profile</li>
				<li>{UserJoin} : when the user first registered their profile</li>
				<li>{UserPosts} : the number of posts the user has done on the forum</li>
				<li>{UserLinkIcons} : replaced with the contact bar images and links</li>
				<li>{ClassTag2} : rotates replacement between the 'msgTopic1' and 'msgTopic2' styles</li>
				<li>{ThreadInfo} : the post icon if used and the date/time of the post</li>
				<li>{EditControls} : the moderator/user edit controls</li>
				<li>{MessageBody} : the message body of the post</li>
			</ul>
			<ul><b>style-topForum.htm</b>
				<li>{ClassTag} : replaced with 'msgTopicHead' or 'msgTopic' (depending on if it is a title row or not) if you do not specify another</li>
				<li>{ICON} : replaced with the 'newfolder.gif' or 'nonewfolder.gif' images depending on if there are new topics or not in the forum</li>
				<li>{ForumName} : the forum name and description</li>
				<li>{Topics} : the number of topics in the forum</li>
				<li>{Posts} : the total number of posts in the forum</li>
				<li>{LastPost} : who did the last post linked to their profile, the date/time of the post, and a link to the last post in the thread (anchored link)</li>
			</ul>
			<br /><br />
			<a name="2.6"></a><b>STEP 5 : Images</b><br />
			The last step in this process are the common images used on the forum.  Each one can be changed or kept the same, depending on your preference.
			Please refer to the '<a href="#3.3">Image Reference</a>' for a complete listing of the images that can be replaced.
			
			</p>
			<p>&nbsp;</p>
			</td></tr>
			<tr><td class="msgTopicHead"><a name="ref"></a><b>Reference</b></td><td class="msgTopicHead" align="right">&nbsp;</td></tr>
			<tr><td class="msgHelpBody" colspan="2" align="center">
			<a name="3.1"></a><b>Style Reference</b><br />
			The easiest way to change the look of your forum is by modifying the 'style.css' file.  This file is a 
			cascading style sheet that defines the colors, fonts and backgrounds used in your forum.  The table below shows
			each class name used and where they are typically found in the forum.  If at any time during your forum customization
			you are not sure of what tag is being used, simply view the page HTML source from your browser and find the section that
			is using the tag you want to modify.  NOTE : Since the same tags are used in multiple locations across the forum, be sure to 
			test your changes completely.<br />&nbsp;<div align="center">
			<table border="0" cellpadding="5" cellspacing="0" width="95%" class="tblStd">
				<tr><td class="msgSm"><b>coppaInput</b> : Used with the printable version of the COPPA form 
					<p><input type="text" class="coppaInput" value="Sample"></p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgButton</b> : Used with fixed width buttons (80px in default style)
					<p><input type="button" class="msgButton" value="Sample"></p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgButtonRoll</b> : Used with onmouseover rollover's, for buttons using the msgButton class.
					<p><input type="button" class="msgButtonRoll" value="Sample"></p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgCode</b> : Used in forum postings with the [code][/code] tags.
					<p height="25" class="msgCode">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormBody</b> : Used on forms where the font-weight should be 'normal'. 
					<p height="25" class="msgFormBody">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormDesc</b> : Used on forms where the font-weight should be 'bold'. 
					<p height="25" class="msgFormDesc">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormDescSm</b> : Used on forms in combination with the 'msgFormDesc' class where the text should be smaller (i.e. descriptions)
					<p height="25" class="msgFormDescSm">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormDrop</b> : Used for the 'Forum Quick Jump' drop down
					<p><select class="msgFormDrop"><option>Sample</option></select></p>
					<br />&nbsp;
				</td></tr>				
				<tr><td class="msgSmRow"><b>msgFormError</b> : Used on forms to highlight error messages.
					<p height="25" class="msgFormError">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormSearchError</b> : Used on the search forms to highlight error messages.
					<p height="25" class="msgFormSearchError">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormHead</b> : Used across the site, this is one of the 2 primary head styles.
					<p height="25" class="msgFormHead">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormHelp</b> : Used in the forum post form help section .
					<p height="25" class="msgFormHelp">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormInput</b> : Used on form input boxes where the width should be 100%.
					<p><input type="text" class="msgFormInput" value="Sample"></p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormSmTextBox</b> : Used on &lt;textarea&gt;&lt;/textarea&gt; input boxes that are shorter in height (150 px).
					<p><textarea class="msgFormSmTextBox">Sample</textarea></p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormStdInput</b> : Used on form input boxes where the width is defined.
					<p><input type="text" class="msgFormStdInput" value="Sample"></p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormTextBox</b> : Used on &lt;textarea&gt;&lt;/textarea&gt; input boxes with a height of 250px.
					<p><textarea class="msgFormTextBox">Sample</textarea></p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgFormTitle</b> : Used on forms where a larger font title is needed. 
					<p height="25" class="msgFormTitle">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgForumHead</b> : Used in places where a header is needed. Primary use is the forum category row.
					<p height="25" class="msgForumHead">Sample</p>
					<br />&nbsp;
				</td></tr>
				
				<tr><td class="msgSmRow"><b>msgHead</b> : Used on the forum where the 'New Topic' and 'Post Reply' buttons are shown.
					<p height="25" class="msgHead">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgHelpBody</b> : Used in the help manuals where the font-weight should be 'normal'.
					<p height="25" class="msgHelpBody">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgLg</b> : Used on the forum where a large sized font is needed.
					<p height="25" class="msgLg">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgMd</b> : Used on the forum where a medium sized font is needed.
					<p height="25" class="msgMd">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgPath</b> : Used on the forum in the upper header section where the 'Forum Quick Jump' and navigation paths are.
					<p height="25" class="msgPath">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgPmExtra</b> : Used in the private message section on the 'Mailbox Size' bar.  This is the available posts counter section.
					<p height="25" class="msgPmExtra">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgPmIn</b> : Used in the private message section on the 'Mailbox Size' bar.  This is the inbox posts counter section.
					<p height="25" class="msgPmIn">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgPmSent</b> : Used in the private message section on the 'Mailbox Size' bar.  This is the sent items posts counter section.
					<p height="25" class="msgPmSent">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgQuote</b> : Used in forum postings with the [quote][/quote] tags, this the actual font and color used.
					<p height="25" class="msgQuote">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgQuoteWrap</b> : Used in forum postings with the [quote][/quote] tags, this provides the padding from the main message itself.
					<p height="25" class="msgQuoteWrap">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgSearchHead</b> : Used on the search form with the results header section.
					<p height="25" class="msgSearchHead">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgSm</b> : Used on the forum where a small sized font is needed.
					<p height="25" class="msgSm">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgSmRow</b> : Used on the forum where a small sized font is needed with a border-top.
					<p height="25" class="msgSmRow">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgSmButton</b> : Used on the forum where a small sized font is needed on buttons.
					<p><input type="button" class="msgSmButton" value="Sample"></p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgSmButtonRoll</b> : Used in combination with the 'msgSmButton' class, this provides the changes for the onmouseover event 
					<p><input type="button" class="msgSmButtonRoll" value="Sample"></p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgThread1</b> : Used in the threaded message view, this is one of the 2 styles used in listing color rotation.  The engine automatically rotates between this and msgThread2 on every other message.
					<p height="25" class="msgThread1">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgThread2</b> : Used in the threaded message view, this is one of the 2 styles used in listing color rotation.  The engine automatically rotates between this and msgThread1 on every other message.
					<p height="25" class="msgThread2">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgThreadInfo</b> : Used in the threaded message view and when viewing private messages.  This is used to wrap the 'post icon' and timestamp on the threaded view, and on the subject and timestamp in private messages.
					<p height="25" class="msgThreadInfo">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgTitleRow</b> : Used on the forum with the main title row where the name of your forum (boardTitle in your Web.Config file) is printed.
					<p height="25" class="msgTitleRow">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgTopic</b> : Used on the main forum page, this is used in the column where the folder icon's are located.
					<p height="25" class="msgTopic">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgTopicAnnounce</b> : Used on forum view and private message inbox pages.  On the forum view, it is used to highlight the 'sticky' threads.  In the private message inbox it is used to highlight unread messages.
					<p height="25" class="msgTopicAnnounce">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgTopicHead</b> : Used across the site, this is one of the 2 primary head styles.
					<p height="25" class="msgTopicHead">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgUser</b> : Used in the threaded view, this is for the section that contains the user information (left side of the message posted).
					<p height="25" class="msgUser">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgUserBar</b> : Used on the control panel navigation bar
					<p height="25" class="msgUserBar">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgVoteHead</b> : The header/title row for poll questions and result pages.
					<p height="25" class="msgUserBar">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgVoteRow</b> : The answer/question row on poll questions and result pages.
					<p height="25" class="msgVoteRow">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>msgXsm</b> : Used on the forum where a extra small sized font is needed. 
					<p height="25" class="msgXsm">Sample</p>
					<br />&nbsp;
				</td></tr>
				<tr><td class="msgSmRow"><b>tblStd</b> : Provides the outer border for tables.
					<table border="0" cellpadding="3" cellspacing="0" width="200" class="tblStd"><tr><td class="msgSm">Sample</td></tr></table>
					<br />&nbsp;
				</td></tr>
			</table></div>
			<p>&nbsp;</p>
			</td></tr>
			<tr><td class="msgHelpBody" colspan="2" align="center">
			<a name="3.2"></a><b>Post Icon Image Reference</b><br />
			Post Icons are stored in your "/(forum root)/posticons/" folder on your site. There are 15 modifyable post icons, and one that is not.  The unchangable 
			icon is simply a transparent dot that is used to keep the formatting clean on the thread listing.  While the image height and width is not hard coded, 
			it is suggested that you keep the standard 15x15 pixel icon sizing.  Below are the modifyable images for forum posts.<br />&nbsp;
			<table border="0" cellpadding="3" cellspacing="0" width="95%" class="tblStd">
				<tr>
					<td class="msgSm" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon0.gif"><br />icon0.gif</td>
					<td class="msgSm" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon1.gif"><br />icon1.gif</td>
					<td class="msgSm" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon2.gif"><br />icon2.gif</td>
					<td class="msgSm" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon3.gif"><br />icon3.gif</td>
					<td class="msgSm" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon4.gif"><br />icon4.gif</td>
				</tr>
				<tr>
					<td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon5.gif"><br />icon5.gif</td>
					<td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon6.gif"><br />icon6.gif</td>
					<td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon7.gif"><br />icon7.gif</td>
					<td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon8.gif"><br />icon8.gif</td>
					<td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon9.gif"><br />icon9.gif</td>
				</tr>
				<tr>
					<td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon10.gif"><br />icon10.gif</td>
					<td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon11.gif"><br />icon11.gif</td>
					<td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon12.gif"><br />icon12.gif</td>
					<td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon13.gif"><br />icon13.gif</td>
					<td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/picon/icon14.gif"><br />icon14.gif</td>
				</tr>
			</table>
			<p>&nbsp;</p>
			</td></tr>			
			<tr><td class="msgHelpBody" colspan="2" align="center">
				<a name="3.3"></a><b>Image Folder Reference</b><br />
				The table below shows in alphabetical order the images that are required in all new theme creations and the location(s) they are used.
				Any additional 'theme specific' images should also be placed in this folder (e.g. background images referenced in 
				the theme's style.css.)<br />&nbsp;<div align="center">
				<table border="0" cellpadding="5" cellspacing="0" width="95%" class="tblStd">
					<tr><td class="msgSm" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/aim.gif"></td><td class="msgSm">"aim.gif" : This image is used on the profile form with the 'AOL Instant Messenger' information.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/aim_off.gif"></td><td class="msgSmRow">"aim_off.gif" : This image is used on the contact information bar as the 'unavailable' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/aim_on.gif"></td><td class="msgSmRow">"aim_on.gif" : This image is used on the contact information bar as the 'available' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/banipbtn.gif"></td><td class="msgSmRow">"banipbtn.gif" : This image is used on the Edit Controls bar to ban a user's IP address (admin function).</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/banuserbtn.gif"></td><td class="msgSmRow">"banuserbtn.gif" : This image is used on the Edit Controls bar to ban a user's account (admin function).</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/category.gif"></td><td class="msgSmRow">"category.gif" : This image is used on the main forum page in the Forum Category link.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/deletebtn.gif"></td><td class="msgSmRow">"deletebtn.gif" : This image is used on the Edit Controls bar to delete a post.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/droplevel.gif"></td><td class="msgSmRow">"droplevel.gif" : This image is used on forum path panel between forum/post icons.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/editbtn.gif"></td><td class="msgSmRow">"editbtn.gif" : This image is used on the Edit Controls bar to edit a post.</td></tr>					
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/folder.gif"></td><td class="msgSmRow">"folder.gif" : This image is used in the forum navigation path above the forum listings and pages.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/folder.gif"></td><td class="msgSmRow">"folder.gif" : This image is used as a background image with the msgFormHead, msgForumHead and msgVoteHead style classes.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/help.gif"></td><td class="msgSmRow">"help.gif" : This image is used with the mCode links on message post forms.</td></tr>					
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/home.gif"></td><td class="msgSmRow">"home.gif" : This image is used on the profile form with the 'Personal Homepage' information.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/home_off.gif"></td><td class="msgSmRow">"home_off.gif" : This image is used on the contact information bar as the 'unavailable' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/home_on.gif"></td><td class="msgSmRow">"home_on.gif" : This image is used on the contact information bar as the 'available' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/icq.gif"></td><td class="msgSmRow">"icq.gif" : This image is used on the profile form with the 'ICQ' information.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/icq_off.gif"></td><td class="msgSmRow">"icq_off.gif" : This image is used on the contact information bar as the 'unavailable' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/icq_on.gif"></td><td class="msgSmRow">"icq_on.gif" : This image is used on the contact information bar as the 'available' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/imbar.gif" width="10" height="27"></td><td class="msgSmRow">"icq_on.gif" : This image is used on the contact information bar on both ends for padding (10px wide).</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/ignorebtn.gif"></td><td class="msgSmRow">"ignorebtn.gif" : This image is used on the Edit Controls bar to ignore a user.</td></tr>					
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/lastpost.gif"></td><td class="msgSmRow">"lastpost.gif" : This image is used on the main forum page with the 'Last Post' link.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/lock.gif"></td><td class="msgSmRow">"lock.gif" : This image is used to denote a locked thread.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/lockedbtn.gif"></td><td class="msgSmRow">"lockedbtn.gif" : This image is used to denote a locked thread replacing the 'Post reply' button.</td></tr>					
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/lockthreadbtn.gif"></td><td class="msgSmRow">"lockthreadbtn.gif" : This image is used on the Edit Controls bar to lock a thread (admin function).</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/mail.gif"></td><td class="msgSmRow">"mail.gif" : This image is used on the profile form with the 'View E-Mail Address' information.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/mail_off.gif"></td><td class="msgSmRow">"mail_off.gif" : This image is used on the contact information bar as the 'unavailable' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/mail_on.gif"></td><td class="msgSmRow">"mail_on.gif" : This image is used on the contact information bar as the 'available' reference image.</td></tr>					
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/msn_off.gif"></td><td class="msgSmRow">"msn_off.gif" : This image is used on the contact information bar as the 'unavailable' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/msn_on.gif"></td><td class="msgSmRow">"msn_on.gif" : This image is used on the contact information bar as the 'available' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/msnm.gif"></td><td class="msgSmRow">"msnm.gif" : This image is used on the profile form with the 'Microsoft Messenger' information.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/newfolder.gif"></td><td class="msgSmRow">"newfolder.gif" : This image is used on the main forum page to denote new posts are within.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/newpoll.gif"></td><td class="msgSmRow">"newpoll.gif" : This image is used as a link to a new poll form.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/newpost.gif"></td><td class="msgSmRow">"newpost.gif" : This image is used as a link to a new post form.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/newtopic.gif"></td><td class="msgSmRow">"newtopic.gif" : This image is used on the forum thread page to denote new posts are within a topic.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/nonewfolder.gif"></td><td class="msgSmRow">"nonewfolder.gif" : This image is used on the main forum page to denote no new posts are within.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/pm_off.gif"></td><td class="msgSmRow">"pm_off.gif" : This image is used on the contact information bar as the 'unavailable' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/pm_on.gif"></td><td class="msgSmRow">"pm_on.gif" : This image is used on the contact information bar as the 'available' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/pollicon.gif"></td><td class="msgSmRow">"pollicon.gif" : This image is used on the forum thread page to denote a poll.</td></tr>					
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/printable.gif"></td><td class="msgSmRow">"printable.gif" : This image is used at the top of a thread linking to a printable version.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/quotebtn.gif"></td><td class="msgSmRow">"quotebtn.gif" : This image is used on the Edit Controls bar to quote a user's posting.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/reply.gif"></td><td class="msgSmRow">"reply.gif" : This image is used with the private message folder where a user can reply to a message sent to them.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/replypost.gif"></td><td class="msgSmRow">"replypost.gif" : This image is used at the top of a thread linking to reply post form.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/smdelete.gif"></td><td class="msgSmRow">"smdelete.gif" : This image is used with the private message folder where a user can delete a message.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/sticky.gif"></td><td class="msgSmRow">"sticky.gif" : This image is used on the forum listing page to denote 'sticky' threads.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/stickybtn.gif"></td><td class="msgSmRow">"stickybtn.gif" : This image is used on the Edit Controls bar to make a thread sticky.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/subjbar.gif"></td><td class="msgSmRow">"subjbar.gif" : This image is used with the msgThreadInfo class.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/subtopicbar.gif"></td><td class="msgSmRow">"subtopicbar.gif" : This image is used with the msgTopicHead and msgFormTitle classes.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/titlebar.gif"></td><td class="msgSmRow">"titlebar.gif" : This image is used with the msgTitleRow class.</td></tr>
					
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_admin.gif"></td><td class="msgSmRow">"tp_admin.gif" : This image is used to link to the administration section.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_help.gif"></td><td class="msgSmRow">"tp_help.gif" : This image is used to link to the help pages.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_home.gif"></td><td class="msgSmRow">"tp_home.gif" : This image is used to link to the top of the forum.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_login.gif"></td><td class="msgSmRow">"tp_login.gif" : This image is used to link to the forum login page (dotNetBB Authorization).</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_logoff.gif"></td><td class="msgSmRow">"tp_logoff.gif" : This image is used to link to the log off the forum (dotNetBB Authorization).</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_privmsg.gif"></td><td class="msgSmRow">"tp_privmsg.gif" : This image is used to link to the private message section.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_privmsg_new.gif"></td><td class="msgSmRow">"tp_privmsg_new.gif" : This image is used to link to the private message section and denotes new messages waiting.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_profile.gif"></td><td class="msgSmRow">"tp_profile.gif" : This image is used to link to the user's control panel.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_register.gif"></td><td class="msgSmRow">"tp_register.gif" : This image is used to link to the new registration page.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_search.gif"></td><td class="msgSmRow">"tp_search.gif" : This image is used to link to the search form.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_subscribe.gif"></td><td class="msgSmRow">"tp_subscribe.gif" : This image is used to link to the forum subscribe page.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/tp_unsub.gif"></td><td class="msgSmRow">"tp_unsub.gif" : This image is used to link to the forum unsubscribe page.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/topic.gif"></td><td class="msgSmRow">"topic.gif" : This image is used on the forum thread page to denote no new posts are within a topic.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/transdot.gif"></td><td class="msgSmRow">"transdot.gif" : This image is used across the entire forum.  It is a transparent image used frequently.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/unlockthreadbtn.gif"></td><td class="msgSmRow">"unlockthreadbtn.gif" : This image is used on the Edit Controls bar to unlock a thread (admin function).</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/unstickybtn.gif"></td><td class="msgSmRow">"unstickybtn.gif" : This image is used on the Edit Controls bar to make a thread unsticky (admin function).</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/userbarback.gif"></td><td class="msgSmRow">"userbarback.gif" : This image is used as the background for the msgUserBar class.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/votebar.gif"></td><td class="msgSmRow">"votebar.gif" : This image is used as the bar used to show poll results.</td></tr>					
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/y!.gif"></td><td class="msgSmRow">"Y!.gif" : This image is used on the profile form with the 'Yahoo Pager' information.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/y_off.gif"></td><td class="msgSmRow">"y_off.gif" : This image is used on the contact information bar as the 'unavailable' reference image.</td></tr>
					<tr><td class="msgSmRow" align="center"><img src="<% =siteRoot %>/admin/images/cmanual/timage/y_on.gif"></td><td class="msgSmRow">"y_on.gif" : This image is used on the contact information bar as the 'available' reference image.</td></tr>					
					
				</table></div>				
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
