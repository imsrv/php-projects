<% if Instr(1,lcase(Request.ServerVariables("SCRIPT_NAME")),"login.asp") = 0 then %>

	<table border="0" width="100%" cellspacing="0" cellpadding="6">
	
	<tr><td class="menuHead" bgcolor="#E8E8E8">Approve Items</td></tr>

	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/aplinks.gif" align="absmiddle">&nbsp;&nbsp;<a href="approvelinks.asp" class="menuLinks">Approve Resources</a></td></tr>

	<% if Session("Admin") = True then %>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/apreview.gif" align="absmiddle">&nbsp;&nbsp;<a href="approvereviews.asp" class="menuLinks">Approve Reviews</a></td></tr>
	<tr><td class="menuHead" bgcolor="#E8E8E8">Directory Management</td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/new.gif" align="absmiddle">&nbsp;&nbsp;<a href="newcategory.asp" class="menuLinks">New Category</a></td></tr>		
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/cats.gif" align="absmiddle">&nbsp;&nbsp;<a href="managecategories.asp" class="menuLinks">Manage Directory</a></td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/sites.gif" align="absmiddle">&nbsp;&nbsp;<a href="manageresources.asp" class="menuLinks">Manage Resources</a></td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/prop.gif" align="absmiddle">&nbsp;&nbsp;<a href="settings.asp" class="menuLinks">Directory Settings</a></td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/errors.gif" align="absmiddle">&nbsp;&nbsp;<a href="checkerrors.asp" class="menuLinks">Check Errors</a></td></tr>
	<% End If %>

	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/goto.gif" align="absmiddle">&nbsp;&nbsp;<a href="<% = Path2Directory %>" class="menuLinks" target="_blank">Goto Directory</a></td></tr>

	<% if Session("Admin") = True then %>
	<tr><td class="menuHead" bgcolor="#E8E8E8">Newsletter Management</td></tr>

	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/newtemplate.gif" align="absmiddle">&nbsp;&nbsp;<a href="createtemplate.asp" class="menuLinks">New Template</a></td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/newsletterformat.gif" align="absmiddle">&nbsp;&nbsp;<a href="managetemplate.asp" class="menuLinks">Templates</a></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/managelist.gif" align="absmiddle">&nbsp;&nbsp;<a href="managemaillist.asp" class="menuLinks">The Mailing List</a></td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/sendnewsletter.gif" align="absmiddle">&nbsp;&nbsp;<a href="sendnewsletter.asp" class="menuLinks">Send Newsletter</a></td></tr>
	<% end if %>
			

	<tr><td class="menuHead" bgcolor="#E8E8E8">Your Profile</td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/editprofile.gif" align="absmiddle">&nbsp;&nbsp;<a href="editprofile.asp?id=<% = Session("UserID") %>" class="menuLinks">Edit Your Profile</a></td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/logout.gif" align="absmiddle">&nbsp;&nbsp;<a href="logout.asp" class="menuLinks">Logout</a></td></tr>

	<% if Session("Admin") = True then %>
	<tr><td class="menuHead" bgcolor="#E8E8E8">Directory Editors</td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/adduser.gif" align="absmiddle">&nbsp;&nbsp;<a href="addeditor.asp" class="menuLinks">Add Editors</a></td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/deluser.gif" align="absmiddle">&nbsp;&nbsp;<a href="manageeditors.asp" class="menuLinks">Manage Editors</a></td></tr>
	<% End If %>
	
	<tr><td class="menuHead" bgcolor="#E8E8E8">Quick Statistics</td></tr>
	
	<% if DatabaseType = "Access" then %>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Root Categories: <% = ReturnNumberOfCategories (False) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Link Categories: <% = ReturnNumberOfCategories (True) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Approved Links: <% = ReturnNumberOfSites (True) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Approved Reviews: <% = ReturnNumberOfReviews (True) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Links to Approve: <% = ReturnNumberOfSites (False) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Reviews to Approve: <% = ReturnNumberOfReviews (False) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Reported Errors: <% = ReturnNumberOfErrors %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Newsletter Subscribers: <% = ReturnNumberForMailingList %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Total No Links: <% =  ReturnNumberOfSites (True) + ReturnNumberOfSites (False) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Total No Categories: <% = ReturnNumberOfCategories (True) + ReturnNumberOfCategories (False) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Link To Category Ratio: <% = LinkToCategoryRatio %></font></td></tr>
	<% else %>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Root Categories: <% = ReturnNumberOfCategories (0) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Link Categories: <% = ReturnNumberOfCategories (1) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Approved Links: <% = ReturnNumberOfSites (1) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Approved Reviews: <% = ReturnNumberOfReviews (1) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Links to Approve: <% = ReturnNumberOfSites (0) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Reviews to Approve: <% = ReturnNumberOfReviews (0) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Reported Errors: <% = ReturnNumberOfErrors %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Newsletter Subscribers: <% = ReturnNumberForMailingList %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Total No Links: <% =  ReturnNumberOfSites (1) + ReturnNumberOfSites (0) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Total No Categories: <% = ReturnNumberOfCategories (1) + ReturnNumberOfCategories (0) %></font></td></tr>
		<tr><td class="menuOption" bgcolor="#F9F9F9"><font class="general_small_text">Link To Category Ratio: <% = LinkToCategoryRatio %></font></td></tr>
	<% end if %>
	
	
	<tr><td class="menuHead" bgcolor="#E8E8E8">Support &amp; Upgrade</td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/help.gif" align="absmiddle">&nbsp;&nbsp;<a href="../../docs/" class="menuLinks" target="_blank">Online Manual</a></td></tr>
	<tr><td class="menuOption" bgcolor="#F9F9F9"><img src="images/icons/goto.gif" align="absmiddle">&nbsp;&nbsp;<a href="default.asp" class="menuLinks">Admin Home</a></td></tr>
	<tr><td><br><br></td></tr>

	</table>

<% end if %>
