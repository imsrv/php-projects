<!--#include file="../configuration_file.asp"-->
<!--#include file="includes/securityfunctions.asp"-->
<!--#include file="includes/globalfunctions.asp"-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>deloittes.NET Directory Administration</title>
	<link href="includes/style.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#ffffff" topmargin="0" leftmargin="0">

<% ShowHeader() %>

<table width="100%" height="100%" cellspacing="0" cellpadding="0">
<tr>
<td width="18%" bgcolor="#F6F6F6" valign="top"><!--#include file="includes/navigation.asp"--></td>
<td width="1" bgcolor="#bbbbbb"><img src="" width="1"></td>
<td width="82%" valign="top"><br>

<% 			
			
			response.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
			response.write "<tr><td bgcolor='#ffffff'>"
			response.write "<font class='page_header'>deloittes.NET Directory Version " & ver & "</font><br><br>"
			response.write "<font class='general_small_text'>"
			response.write "Welcome to your Directory Administration Centre. From here you can manage various global configuration settings to customise the behaviour and appearance of your directory. You can modify or organise links, categories and reviews and approve items before they are made available to your visitors. You can also manage your newsletter mailing list, create or modify newsletter templates and send your newsletters to the mailing list.<br><br>Please take a moment to become familiar with the various features available on the left hand side. A brief description of each feature is listed below."
			response.write "</font>"
			response.write "</td></tr></table><br>"
		
			
			response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
			response.write "<tr><td>"
			Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
			response.write "<tr><td class='menuHead' bgcolor='#E8E8E8'>Approve Items</td></tr>"
			response.write "<tr><td bgcolor='#F9F9F9'>"
			response.write "<img src='images/icons/aplinks.gif' align='absmiddle'>&nbsp;&nbsp;"
			response.write "<font class='menuLinks'>Approve Resources</font>"
			response.write "</td></tr>"
			response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
			response.write "<tr><td bgcolor='#ffffff'>"
			response.write "<font class='general_small_text'>"
			response.write "Approve, move or edit link submissions before they are indexed into the database."
			response.write "</font>"
			response.write "</td></tr>"
			
			if session("admin") = True then 
			
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"	
				response.write "<tr><td bgcolor='#F9F9F9'>"
				response.write "<img src='images/icons/apreview.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>Approve Reviews</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "Approve or edit reviews before they become public to ensure they are suitible for the directory."
				response.write "</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"	
				response.write "<tr><td class='menuHead' bgcolor='#E8E8E8'>Directory Management</td></tr>"	
				response.write "<tr><td bgcolor='#F9F9F9'>"
		
				response.write "<img src='images/icons/new.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>New Category</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "A quick and simple way to add new categories to the directory."
				response.write "</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"				
				response.write "<tr><td bgcolor='#F9F9F9'>"
				response.write "<img src='images/icons/cats.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>Manage Directory</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "Browse your directory, modify, move or delete categories and resources within the directory."
				response.write "</font>"
				response.write "</td></tr>"	
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"		
				response.write "<tr><td bgcolor='#F9F9F9'>"
				response.write "<img src='images/icons/sites.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>Manage Resources</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "Modify, move or delete links within the directory. You can search for resources via any attribute."
				response.write "</font>"
				response.write "</td></tr>"
						 
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"	
				response.write "<tr><td bgcolor='#F9F9F9'>"
				response.write "<img src='images/icons/prop.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>Directory Settings</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "Control global behaviours and settings for the directory."
				response.write "</font>"
				response.write "</td></tr>"
			
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"	
				response.write "<tr><td bgcolor='#F9F9F9'>"
				response.write "<img src='images/icons/errors.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>Check Errors</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "Keep the directory tidy by checking for error submissions."
				response.write "</font>"
				response.write "</td></tr>"
			
			end if
			
			response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"	
			response.write "<tr><td bgcolor='#F9F9F9'>"
			response.write "<img src='images/icons/goto.gif' align='absmiddle'>&nbsp;&nbsp;"
			response.write "<font class='menuLinks'>Goto Directory</font>"
			response.write "</td></tr>"
			response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
			response.write "<tr><td bgcolor='#ffffff'>"
			response.write "<font class='general_small_text'>"
			response.write "Easy access to your directory."
			response.write "</font>"
			response.write "</td></tr>"
			
			if session("admin") = True then 
			
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td class='menuHead' bgcolor='#E8E8E8'>Newsletter Management</td></tr>"			

				response.write "<tr><td bgcolor='#F9F9F9'>"
				response.write "<img src='images/icons/newtemplate.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>New Mail Template</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "Create multiple newsletter templates."
				response.write "</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"	
				response.write "<tr><td bgcolor='#F9F9F9'>"
				response.write "<img src='images/icons/newsletterformat.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>Mail Templates</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "Edit or remove newsletter templates."
				response.write "</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"	
								response.write "<tr><td bgcolor='#F9F9F9'>"
				response.write "<img src='images/icons/managelist.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>Your Mailing List</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "View & manage subscribers to your newsletter."
				response.write "</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"	
				response.write "<tr><td bgcolor='#F9F9F9'>"
				response.write "<img src='images/icons/sendnewsletter.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>Send Newsletter</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "Send your latest additions newsletter to the mailing list."
				response.write "</font>"
				response.write "</td></tr>"
			
			end if
			
			response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
			response.write "<tr><td class='menuHead' bgcolor='#E8E8E8'>Your Profile</td></tr>"			
			response.write "<tr><td bgcolor='#F9F9F9'>"
			response.write "<img src='images/icons/editprofile.gif' align='absmiddle'>&nbsp;&nbsp;"
			response.write "<font class='menuLinks'>Edit Your Profile</font>"
			response.write "</td></tr>"
			response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
			response.write "<tr><td bgcolor='#ffffff'>"
			response.write "<font class='general_small_text'>"
			response.write "Edit your details including your username and password."
			response.write "</font>"
			response.write "</td></tr>"
			response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"	
			response.write "<tr><td bgcolor='#F9F9F9'>"
			response.write "<img src='images/icons/logout.gif' align='absmiddle'>&nbsp;&nbsp;"
			response.write "<font class='menuLinks'>Logout</font>"
			response.write "</td></tr>"
			response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
			response.write "<tr><td bgcolor='#ffffff'>"
			response.write "<font class='general_small_text'>"
			response.write "Logout of the deloittes.NET Administration system."
			response.write "</font>"
			response.write "</td></tr>"
			
			if session("admin") = True then 
			
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td class='menuHead' bgcolor='#E8E8E8'>Directory Editors</td></tr>"	
				response.write "<tr><td bgcolor='#F9F9F9'>"
				response.write "<img src='images/icons/adduser.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>Add Editors</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "Add content editors to manage the directory."
				response.write "</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"	
				response.write "<tr><td bgcolor='#F9F9F9'>"
				response.write "<img src='images/icons/deluser.gif' align='absmiddle'>&nbsp;&nbsp;"
				response.write "<font class='menuLinks'>Manage Editors</font>"
				response.write "</td></tr>"
				response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
				response.write "<tr><td bgcolor='#ffffff'>"
				response.write "<font class='general_small_text'>"
				response.write "Modify or delete directory editors."
				response.write "</font>"
				response.write "</td></tr>"
			
			End If
			
			response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
			response.write "<tr><td class='menuHead' bgcolor='#E8E8E8'>Support & Upgrades</td></tr>"	
			response.write "<tr><td bgcolor='#F9F9F9'>"
			response.write "<img src='images/icons/help.gif' align='absmiddle'>&nbsp;&nbsp;"
			response.write "<font class='menuLinks'>Online Manual</font>"
			response.write "</td></tr>"
			response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
			response.write "<tr><td bgcolor='#ffffff'>"
			response.write "<font class='general_small_text'>"
			response.write "Access to the Online documentation."
			response.write "</font>"
			response.write "</td></tr>"
			
			response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"		
			response.write "<tr><td bgcolor='#F9F9F9'>"
			response.write "<img src='images/icons/contact.gif' align='absmiddle'>&nbsp;&nbsp;"
			response.write "<font class='menuLinks'>Support Forums</font>"
			response.write "</td></tr>"
			response.write "<tr><td bgcolor='#bbbbbb'></td></tr>"
			response.write "<tr><td bgcolor='#ffffff'>"
			response.write "<font class='general_small_text'>"
			response.write "Post a question to our free technical support support forums."
			response.write "</font>"
			response.write "</td></tr>"
			
			
			response.write "</table>"
		response.write "</td></tr></table><br>"
		
		ShowFooter() %>

</td>

</tr>
</table>


</body>
</html>

