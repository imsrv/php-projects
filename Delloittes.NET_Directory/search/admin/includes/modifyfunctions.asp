
<% 

'*****************************************
' Subs for the modifyresources.asp page
'*****************************************

Sub Header()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/sites.gif' align='absmiddle'>&nbsp;&nbsp;"
	response.write "<font class='menuLinks'>Manage Resources</font>"
	response.write "</td></tr>"
	response.write "<tr><td background='images/divide_bg.gif'></td></tr>"
	response.write "<tr><td bgcolor='#ffffff'>"
	response.write "<font class='general_small_text'>"
	response.write "Administer live resources within the database. You can search for resources via any attribute. "
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"

End Sub

Sub ShowSearch()

response.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
response.write "<tr><td>"

response.write "<img src='images/icons/help.gif' align='right' hspace='10'><font class='general_small_text'>&#149;&nbsp;Use the search form below to find a specific resource(s) within the directory to modify, move or delete.<br>&#149;&nbsp;You can also <a href='managecategories.asp'><b>browse your directory</b></a> to find, modify, move or delete items within the directory.</font>"

response.write "</td></tr></table><br>"

response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
response.write "<tr>"
response.write "<form action='manageresources.asp?action=search' method='POST' name='frmSearch'>"
response.write "<td>"

	response.write "<table width='100%' bgcolor='#F9F9F9' cellpadding='7' cellspacing='0'>"
	response.write "<tr>"
	response.write "<td colspan='1' bgcolor='#ffffff' align='right'><font class='general_small_text'><b>Keywords:</b></font></td>"
	response.write "<td bgcolor='#ffffff' colspan='3'><input type='text' size='35' name='keyword' value='" & request.form("keyword") & "' class='input'> <input type='submit' class='form_buttons' name='submit' value=' Search '> </td>"
	
	response.write "</tr>"
	response.write "<tr><td colspan='4' background='images/divide_bg.gif'></td></tr>"
	response.write "<tr>"
	response.write "<td><font class='general_small_text'><b>SELECT:</b></font></td>"
	response.write "<td><font class='general_small_text'><b>WHERE:</b></font></td>"
	response.write "<td><font class='general_small_text'><b>ORDER BY:</b></font></td>"
	response.write "<td><font class='general_small_text'><b>SORT:</b></font></td>"
	response.write "</tr>"
	response.write "<tr><td colspan='4' background='images/divide_bg.gif'></td></tr>"
	response.write "<tr>"
	response.write "<td valign='top' bgcolor='#ffffff' width='25%'><input type='checkbox' checked class='input' value='ON' name='selID'><font class='general_small_text'>ID<br><input type='checkbox' checked class='input' value='ON' name='seltitle'><font class='general_small_text'>Title<br><input type='checkbox' checked class='input' value='ON' name='seldescription'><font class='general_small_text'>Description<br><input type='checkbox' checked class='input' value='ON' name='selurl'><font class='general_small_text'>URL<br><input type='checkbox' class='input' value='ON' checked name='selcontact'><font class='general_small_text'>Contact Details</td>"
	response.write "<td valign='top' width='25%' bgcolor='#ffffff'><input type='checkbox' class='input' value='ON' name='wherefavorite'><font class='general_small_text'>Favorite<br><input type='checkbox' class='input' value='ON' name='wheresponsor'><font class='general_small_text'>Sponsor</td>"
	response.write "<td valign='top' width='25%' bgcolor='#ffffff'><input type='radio' checked class='input' value='created' name='order'><font class='general_small_text'>Created Date<br><input type='radio' class='input' value='title' name='order'><font class='general_small_text'>Title<br><input type='radio' class='input' value='description' name='order'><font class='general_small_text'>Description</td>"
	response.write "<td valign='top' width='25%' bgcolor='#ffffff'><input type='radio' class='input' value='ASC' name='SORT'><font class='general_small_text'>ASC<br><input type='radio' class='input' value='DESC' name='SORT' checked><font class='general_small_text'>DESC</td>"
	response.write "</tr>"
	response.write "</table>"

response.write "</td></form></tr></table><br>"

End Sub

Sub DrawResults()

Dim Keyword, SQL, j, TheSet, ConnObj

Keyword = trim(replace(Request.Form("keyword"),"'","''",1))

SQL = "SELECT Top 50 * FROM del_Directory_Sites WHERE "	

If Keyword <> "" or request.querystring("siteID") <> "" then

	If request.form("selID") = "ON" or request.querystring("siteID") <> "" then 
	if IsNumeric(Keyword) then SQL = SQL & "del_Directory_Sites.ID = " & Keyword & " OR "
	if request.querystring("siteID") <> "" then SQL = SQL & "del_Directory_Sites.ID = " & request.querystring("siteID") & " OR "
	end if
	
	If request.form("seltitle") = "ON" then	SQL = SQL & "del_Directory_Sites.Title LIKE '%" & Keyword & "%' OR "
	If request.form("seldescription") = "ON" then SQL = SQL & "del_Directory_Sites.Description LIKE '%" & Keyword & "%' OR "
	If request.form("selurl") = "ON" then SQL = SQL & "del_Directory_Sites.URL LIKE '%" & Keyword & "%' OR "
	If request.form("selcontact") = "ON" then SQL = SQL & "del_Directory_Sites.ContactName LIKE '%" & Keyword & "%' OR del_Directory_Sites.ContactEmail LIKE '%" & Keyword & "%' OR "	

End if

If right(SQL,3) = "OR " then SQL = left(SQL,len(SQL)-3) & "AND "

If request.form("wherefavorite") = "ON" then

	if DatabaseType = "Access" then
		SQL = SQL & "Favorite = True AND "
	else
		SQL = SQL & "Favorite = 1 AND "
	end if
	
end if

If request.form("wheresponsor") = "ON" then

	if DatabaseType = "Access" then
		SQL = SQL & "(Sponsor = True) AND "
	else
		SQL = SQL & "(Sponsor = 1) AND "
	end if
		
end if

	if DatabaseType = "Access" then
		SQL = SQL & "(PublishOnWeb = True)"
	else
		SQL = SQL & "(PublishOnWeb = 1)"
	end if
	
if request.form("order") = "created" then
	SQL = SQL & " ORDER BY del_Directory_Sites.Created " 
elseif request.form("order") = "title" then
	SQL = SQL & " ORDER BY Title " 
elseif request.form("order") = "description" then
	SQL = SQL & " ORDER BY Description "
end if

if request.form("sort") = "ASC" then
	SQL = SQL & "ASC"
elseif request.form("sort") = "DESC" then
	SQL = SQL & "DESC"
end if


	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj
	
	Response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='7' cellspacing='0'>"
		
	if TheSet.EOF or TheSet.BOF then ' no records found 
		
		response.write "<tr><td valign='top' bgcolor='#bcbcbc'></td></tr>"
		response.write "<tr><td bgcolor='#F9F9F9'>"
		response.write "<font class='general_text'>"
		response.write "Sorry no resources found."
		response.write "</font>"
		response.write "</td></tr>"
		response.write "<tr><td bgcolor='#ffffff'>"
		response.write "<font class='general_text'>"
		response.write "<a href='manageresources.asp'><b>Try Again</b></a>"
		response.write "</font>"
		response.write "</td>"
		response.write "</tr>"

	else ' we have a result 
	
	if Keyword <> "" then
	
		response.write "<tr><td valign='top' bgcolor='#bcbcbc'></td></tr>"
		response.write "<tr><td bgcolor='#F9F9F9'>"
		response.write "<font class='general_page_header'>" 
		response.write "Search results for " & Keyword
		response.write "</font>"
		response.write "</td></tr>"	
		
	end if	
	
		response.write "<tr><td valign='top' bgcolor='#bcbcbc'></td></tr>"
		response.write "<tr><td bgcolor='#ffffff'>"
		
		' draw how many pages where found and sort combo boxes
		
			response.write "<font class='page_results_count'>"
			response.write TheSet.RecordCount & " results found"
			response.write "</font>"
			
		response.write "</td></tr>"
		
	
	
	response.write "<tr><td colspan='2' bgcolor='#bcbcbc'></td></tr>"
	
	Do While Not TheSet.EOF 

	response.write "<tr><td valign='top' colspan='2' bgcolor='#F9F9F9'>"
	
		response.write "<table width='100%'>"
		response.write "<tr><td>"
		
		' draw resource link
		
		response.write "<a class='listing_head' href='" & Path2Directory & "redirect.asp?id=" 
		response.write TheSet("ID") & "' title='" & TheSet("Title") & "' target='_blank'>"
	
			If len(TheSet("Title")) >= 40 then
				response.write left(TheSet("Title"),40) & "..."
			else
				response.write TheSet("Title") 
			end if
		
		response.write "</a>"

		if TheSet("Sponsor") = true then
		response.write " <img src='" & Path2Directory & "images/sponsor.gif' alt='Sponsor' align='absmiddle'> "
		else
		response.write " "
		end if

		if TheSet("Favorite") = true then
		response.write "<img src='" & Path2Directory & "images/fav.gif' alt='Favorite' align='absbottom'> "
		else
		response.write " "
		end if

		response.write NewIcon(TheSet("Created")) 
		
		response.write "</td><td align='right'>"
		
			' get overall rating
	
		response.write "<font class='general_small_text'>"
		response.write "<img src='images/modify.gif' align='absmiddle' border='0'> <a href='manageresources.asp?action=modify&siteid=" & TheSet("ID") & "'>"
		response.write "Modify</a> "
		response.write "<img src='images/moveresource.gif' align='absmiddle' border='0'> <a href='manageresources.asp?action=moveresource&siteid=" & TheSet("ID") & "&currentcatid=" & TheSet("CategoryID") & "'>"
		response.write "Move Resource</a> "
		response.write "<img src='images/bin.gif' align='absmiddle' border='0'> <a href='manageresources.asp?action=delete&siteid=" & TheSet("ID") & "&catid=" & TheSet("CategoryID") & "'>"
		response.write "Delete Resource</a>"
		response.write "</font>"

		response.write "</td></tr></table>"

	response.write "</td></tr>"
	
	response.write "<tr><td bgcolor='#ffffff'>"
	
		response.write "<table width='100%'><tr><td>"
		
		' draw created and last visited date
		
		response.write "<font class='created_date'>"
		response.write "Created: " & FormatDateTime(TheSet("Created"),2) & ", " 
		response.write "Last Visit: " & FormatDateTime(TheSet("LastAccessed"),2)
		response.write "</font>"
		
		response.write "</td>"		
		response.write "<td align='right'>"

		' draw hits today, hits this month and overall hits
		
		response.write "<font class='hits_count'>"
		response.write "Hits Today: " & TheSet("HitsToday") & ", "
		response.write "This Month: " & TheSet("HitsThisMonth") & ", " 
		response.write "Overall: " & TheSet("Hits")
		response.write "</font>"
		
		response.write "</td></tr></table>"
		
	response.write "</td></tr>"
	
	response.write "<tr><td  bgcolor='#ffffff'>"
	
	' draw description
	
	response.write "<font class='listing_description'>"
	if TheSet("Description") <> "" then response.write TheSet("Description")  
	response.write "</font>"
	
	' draw report error and bookmark links
	
	response.write "<br><br>"
	
	response.write "<font class='search_results_category'>"
	i = 0
	ConstructTopNavigation TheSet("CategoryID")
	response.write TopNavLinks 
	response.write "</font>"
	

	response.write "</td></tr>"
	
		TheSet.MoveNext		
		Loop

	
	end if
	
	response.write "</table>"
	
	Set TheSet = Nothing
	ConnObj.Close


End Sub

Sub ShowMoveForm(siteid,currentcatid)

Dim ConnObj, SQL, CategoryInfo, CategoryRecords

SQL = "SELECT * FROM del_Directory_Categories WHERE ID = " & currentcatid
Set ConnObj = Server.CreateObject("ADODB.Connection")
ConnObj.Open MyConnStr	
Set CategoryInfo = ConnObj.Execute(SQL) 

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='general_small_text'>Use the form below to move the above resource to a new category within the directory. When you move a resource all associated category count information will be updated.</b></font>"
	response.write "</td></tr></table>"
	response.write "</td></tr></table><br>"

	With Response
	
	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form action='manageresources.asp?action=moveresourceupdate&siteid=" & siteid
	.write "' method='POST' name='frmNewCategory'>"
	.write "<input type='hidden' value='" & currentcatid & "' class='input' name='currentcategory' size='62'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9' valign='top'><font class='form_text'>Category:</font></td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<select name='category' class='display_cats' size='20'>"
			
			if DatabaseType = "Access" then
				SQL = "SELECT ID FROM del_Directory_Categories Where AllowLinks = True ORDER BY ParentID, CategoryName"
			else
				SQL = "SELECT ID FROM del_Directory_Categories Where AllowLinks = 1 ORDER BY ParentID, CategoryName"
			end if
			
			Set CategoryRecords = Server.CreateObject("ADODB.Recordset")
			CategoryRecords.CursorLocation = 3
			CategoryRecords.Open SQL, ConnObj
			
			if CategoryRecords.EOF then
				.write "<option value=''>No Categories Found</option>"
			else
			
				.write "<option value='0'"
				if currentcatid = "0" then .write "selected"
				.write ">Root Category</option>"
				
			CategoryRecords.MoveFirst
			Do Until CategoryRecords.EOF
				
				.write "<option value='" & CategoryRecords("ID") & "'"
				if CategoryRecords("ID") = cint(currentcatid) then .write " selected"
				.write ">"
				
				i = 0
				ConstructCategories CategoryRecords("ID")
				.write TopNavLinks 
				.write "</option>"
			
			CategoryRecords.MoveNext
			Loop
			 
			end if
			
			Set CategoryRecords = Nothing
			
			
	.write "</select> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Save Changes'> "
	.write "<input type='reset' class='form_buttons' onclick=""javascript:history.back(1)"" name='reset' value='Cancel'>"
	.write "</td></tr></table>"

	.write "</td></tr></table><br>"

	End With

Set CategoryInfo = Nothing
ConnObj.Close

End Sub

Sub MoveComplete()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='general_small_text'>This resource has been moved and all category counts have been updated.<br><br><a href='manageresources.asp'><b>Search Again</b></a><br><br><a href='javascript:history.go(-3)'><b>Back to category / search results...</b></a></font>"
	response.write "</td></tr></table>"
	response.write "</td></tr></table><br>"

End Sub

Sub UpdateSiteCategory(siteID)
	
	Dim ConnObj, SQL
	
	SQL = "UPDATE del_Directory_Sites SET CategoryID = " & request.form("category") & " WHERE ID = " & siteID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)	
	ConnObj.Close

End Sub

Sub AddCategoryCounts (CatID)
	
	Dim ConnObj, SQL, TempRecords, NewListingCount
	
	SQL = "SELECT ParentID, ListingCount FROM del_Directory_Categories WHERE ID = " & CatID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TempRecords = ConnObj.Execute(SQL)
	
	If TempRecords.EOF Then
	
	Else
			
		NewListingCount = TempRecords("ListingCount") + 1

		SQL = "UPDATE del_Directory_Categories SET ListingCount = " & NewListingCount & " WHERE ID = " & CatID
		ConnObj.Execute(SQL)	
		
		if TempRecords("ParentID") <> 0 then
		AddCategoryCounts (TempRecords("ParentID"))
		end if
	
	End IF
	
	Set TempRecords = Nothing
	ConnObj.Close
	
End Sub

Sub SubtractCategoryCounts (CatID)

	Dim ConnObj, SQL, TempRecords, NewListingCount
	
	SQL = "SELECT ParentID, ListingCount FROM del_Directory_Categories WHERE ID = " & CatID
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TempRecords = ConnObj.Execute(SQL)
	
	If TempRecords.EOF Then
	
	Else
	
		if CatID <> request.form("currentcategory") then
			NewListingCount = TempRecords("ListingCount") - 1
		else
			NewListingCount = TempRecords("ListingCount")
		end if
		
		SQL = "UPDATE del_Directory_Categories SET ListingCount = " & NewListingCount & " WHERE ID = " & CatID
		ConnObj.Execute(SQL)			
	
		if TempRecords("ParentID") <> 0 then
		SubtractCategoryCounts (TempRecords("ParentID"))
		end if
	
	End IF
	
	Set TempRecords = Nothing
	ConnObj.Close
	
End Sub

Sub DrawEditForm(siteID)
	
	Dim ConnObj, SQL, TheSet 
	
	SQL = "SELECT * FROM del_Directory_Sites WHERE ID = " & siteID  
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj
	
	if TheSet.EOF then
	
	else
	
	With Response
	
	.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	.write "<tr><td>"
	.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	.write "<tr><td bgcolor='#F9F9F9'>"
	.write "<font class='general_small_text'>Use the form below to modify this resource. </b></font>"
	.write "</td></tr></table>"
	.write "</td></tr></table><br>"

	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form onSubmit='return checkForm(this)' action='manageresources.asp?action=updateresource' method='POST' name='frmResourceEdit'>"
	.write "<input type='hidden' name='SiteID' value='" & SiteID & "'>"
	.write "<input type='hidden' name='category' value='" & TheSet("CategoryID") & "'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Title:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value=""" & TheSet("Title") & """ class='input' name='title' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td valign='top' bgcolor='#F9F9F9'><font class='form_text'>Description:</font></td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<textarea name='description' wrap='physical'"
	.write "onKeyDown='textCounter(this.form.description,this.form.remLen,250);' "
	.write "onKeyUp='textCounter(this.form.description,this.form.remLen,250);' rows='12' cols='55'>"
	.write TheSet("Description")
	.write "</textarea> *</font><br>"
	.write "<input type='text' class='input' readonly value='250' name='remLen' size='3'> "
	.write "<font class='form_text'> Characters left. 250 Max Characters.</font>"
	.write "</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>URL:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & TheSet("URL") & "' class='input' name='url' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Mark As Favorite:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' "
	if TheSet("Favorite") = True then .write "Checked "
	.write " name='favorite'></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Mark As Sponsor:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' "
	if TheSet("sponsor") = True then .write "Checked "
	.write " name='sponsor'></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Full Name:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & TheSet("ContactName") & "' class='input' name='fullname' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Email Address:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & TheSet("ContactEmail") & "' class='input' name='emailaddress' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Save Changes'> "
	.write "<input type='reset' class='form_buttons' onclick=""javascript:history.back(1)"" name='reset' value='Cancel'>"
	.write "</td></tr></table>"

	.write "</td></tr></table><br>"

	End With

	end if
	
	ConnObj.Close
	Set ConnObj = Nothing
	Set TheSet = Nothing
	

End Sub

Sub ShowSingleResource(siteID)

Dim ConnObj, SQL, Records

SQL = "SELECT * FROM del_Directory_Sites WHERE del_Directory_Sites.ID = " & siteID 
Set ConnObj = Server.CreateObject("ADODB.Connection")
ConnObj.Open MyConnStr 
Set Records = ConnObj.Execute(SQL)

	If Records.EOF then
		
		response.write "<font class='general_text'>"
		response.write "No selected Resource"
		response.write "</font>"
		
	else

		response.write "<table width='90%' bgcolor='#bbbbbb' cellpadding='1' align='center' cellspacing='0'><tr><td>"
		
		Response.write "<table width='100%' cellspacing='0' cellpadding='8' Border='0'>"
		response.write "<tr><td colspan='2' bgcolor='#F9F9F9'>"
		
		' draw resource link
		
		response.write "<a class='listing_head' href='" & Path2Directory & "redirect.asp?id=" & Records("ID") 
		response.write "' title='" 
		response.write Records("Title") & "' target='_blank'>"
	
			If len(Records("Title")) >= 40 then
				response.write left(Records("Title"),40) & "..."
			else
				response.write Records("Title") 
			end if
		
		response.write "</a>"

		if Records("Sponsor") = true then
		response.write " <img src='" & Path2Directory & "images/sponsor.gif' alt='Sponsor' align='absmiddle'> "
		else
		response.write " "
		end if

		if Records("Favorite") = true then
		response.write "<img src='" & Path2Directory & "images/fav.gif' alt='Favorite' align='absbottom'> "
		else
		response.write " "
		end if

		response.write NewIcon(Records("Created")) 
		
		response.write "</td></tr>"	

	response.write "<tr><td bgcolor='#ffffff'>"
	
		' draw created and last visited date
		
		response.write "<font class='created_date'>"
		response.write "Created: " & FormatDateTime(Records("Created"),2) & ", " 
		response.write "Last Visit: " & FormatDateTime(Records("LastAccessed"),2)
		response.write "</font>"
		
		response.write "</td>"		
		response.write "<td bgcolor='#ffffff' align='right'>"
		
		' reset hits today date and hits this month date
		
		if Records("HitsTodayDate") <> Day(Now()) then 
		SQL = "UPDATE del_Directory_Sites SET HitsToday = 0, HitsTodayDate = " & Day(Now()) & " WHERE id = " & Records("ID")
		ConnObj.Execute(SQL)
		end if
		if Records("HitsThisMonthDate") <> Month(Now()) then
		SQL = "UPDATE del_Directory_Sites SET HitsThisMonth = 0, HitsThisMonthDate = " & Month(Now()) 
		SQL = SQL & " WHERE id = " & Records("ID")
		ConnObj.Execute(SQL)
		end if
		
		' draw hits today, hits this month and overall hits
		
		response.write "<font class='hits_count'>"
		response.write "Hits Today: " & Records("HitsToday") & ", "
		response.write "This Month: " & Records("HitsThisMonth") & ", " 
		response.write "Overall: " & Records("Hits")
		response.write "</font>"
		
		response.write "</td>"
				
	response.write "</tr>"
	
	response.write "<tr><td bgcolor='#ffffff' colspan='2'>"
	
	' draw description
	
	response.write "<font class='listing_description'>"
	if Records("Description") <> "" then response.write Records("Description")  
	response.write "</font>"
	
	' draw report error and bookmark links
	
	response.write "<br><br>"
	response.write "<table width='100%' cellspacing='0'><tr><td>"
	response.write "<font class='short_listing_url'>"
	i = 0
	ConstructTopNavigation Records("CategoryID")
	response.write TopNavLinks ' write top navigation to screen and chop off last seperator
	response.write "</a>"
	response.write "</font>"
	response.write "</td>"
	
	response.write "</tr></table>"


	response.write "</td></tr></table>"
	
	response.write "</td></tr></table><br>"
	

End If

Set Records = Nothing
ConnObj.Close

End Sub

Sub DoUpdate (theID) 
		
		Dim ConnObj, SQL
		Dim Favorite, Sponsor
		
		if request.form("favorite") = "ON" then
		
			if DatabaseType = "Access" then
				Favorite = True
			else
				Favorite = 1
			end if
			
		else
		
			If DatabaseType = "Access" then
				Favorite = False
			else
				Favorite = 0
			end if
			
		end if
		
		if request.form("sponsor") = "ON" then
		
			If DatabaseType = "Access" then
				Sponsor = True
			else
				Sponsor = 1
			end if
			
		else
		
			If DatabaseType = "Access" then
				Sponsor = False
			else
				Sponsor = 0
			end if
			
		end if
	
		SQL = "UPDATE del_Directory_Sites SET Title = '" & CheckString(request.form("title")) & "', "
		SQL = SQL & "Description = '" & CheckString(request.form("Description")) & "', "
		SQL = SQL & "URL = '" & CheckString(request.form("url")) & "', "
		SQL = SQL & "ContactName = '" & CheckString(request.form("fullname")) & "', "
		SQL = SQL & "ContactEmail = '" & CheckString(request.form("emailaddress")) & "', "
		SQL = SQL & "Favorite = " & Favorite & ", "
		SQL = SQL & "Sponsor = " & Sponsor
		SQL = SQL & " WHERE id = " & theID
		
		'response.write SQL
		
		Set ConnObj = Server.CreateObject("ADODB.Connection")
		ConnObj.Open MyConnStr
		ConnObj.Execute(SQL) 	
		ConnObj.Close
				
		response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
		response.write "<tr><td>"
		Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
		response.write "<tr><td bgcolor='#F9F9F9'>"
		response.write "<font class='general_small_text'>This resource has been updated within the directory.<br><br><b><a href='javascript:history.go(-2)'>Back to search / category results</a> | <a href='manageresources.asp?action=modify&siteid=" & theID & "'>Modify Again</a> | <a href='manageresources.asp'>Search</a></a></b></font>"
		response.write "</td></tr></table>"
		response.write "</td></tr></table><br>"
			

End Sub

Sub ShowDelete()

	response.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td align='center'>"
	response.write "<font class='warning_text'><b><img src='images/warning.gif' align='absmiddle'> WARNING:</font></b><br><br><font class='general_small_text'>You are about to delete the above item from the database.<br><br>Are you sure you want to delete this resource?<br><br><a href='manageresources.asp?action=dodelete&ID=" & request.querystring("siteID") & "&catid=" & request.querystring("catid") & "'><b>YES</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='javascript:history.back(1)'><b>NO</b></a></font>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub DeleteResource(siteID)

	Dim ConnObj, SQL

	SQL = "DELETE FROM del_Directory_Sites WHERE ID = " & SiteID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)
	ConnObj.Close
	
	UpdateCategoryCounts request.querystring("catid")
	
	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='general_small_text'>This resource has been removed from the directory and all related category counts have been updated.<br><br><a href='manageresources.asp'><b>Search Again</b></a></a></b></font>"
	response.write "</td></tr></table>"
	response.write "</td></tr></table><br>"

End Sub

Sub UpdateCategoryCounts (CatID)

	Dim ConnObj, SQL, TempRecords, NewListingCount
	
	SQL = "SELECT ParentID, ListingCount FROM del_Directory_Categories WHERE ID = " & CatID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TempRecords = ConnObj.Execute(SQL)
	
	If TempRecords.EOF Then
	
	Else
	
	
		NewListingCount = TempRecords("ListingCount") - 1 
		
		SQL = "UPDATE del_Directory_Categories SET ListingCount = " & NewListingCount & " WHERE ID = " & CatID
		ConnObj.Execute(SQL)	
	
		if TempRecords("ParentID") <> 0 then
		UpdateCategoryCounts (TempRecords("ParentID"))
		end if
	
	End IF
	
	Set TempRecords = Nothing
	ConnObj.Close
	
End Sub

'*****************************************************
' This sub creates the main top navigation and assign it all
' to the TopNavLinks variable for manipulation later
'*****************************************************

Sub ConstructTopNavigation (theID) 

	Dim NewConnObj, SQL, CategoryTitle 

	if theID <> "" then
	
		if i = 0 then
			TopNavLinks = "<a href='" & Path2Admin & "managecategories.asp'>Home</a> " & NavigationSep & " "
		end if
		
		
			Set NewConnObj = Server.CreateObject("ADODB.Connection")
			NewConnObj.Open MyConnStr
			SQL = "SELECT ID, CategoryName, ParentID FROM del_Directory_Categories WHERE ID = " & theID 
			Set CategoryTitle = NewConnObj.Execute(SQL) 
				
			If CategoryTitle.EOF then
			
				TopNavLinks = "<b>No Category Found</b>"
			
			else				
				i = i + 1
			
				if CategoryTitle("ParentID") <> 0 then
					ConstructTopNavigation CategoryTitle("ParentID")
				end if
				
				if CategoryTitle("ParentID") <> 0 then 
				TopNavLinks = TopNavLinks & " " &  NavigationSep & " "
				end if
						
					TopNavLinks = TopNavLinks & "<a href='" & Path2Admin & "managecategories.asp?id=" & CategoryTitle("ID")
			
				if CategoryTitle("ParentID") <> 0 then 
					TopNavLinks = TopNavLinks & "&parentID=" & CategoryTitle("ParentID") & "'>"
				else
					TopNavLinks = TopNavLinks & "'>"
				end if		
			
				TopNavLinks = TopNavLinks & CategoryTitle("CategoryName") & "</a>"				

			
			end if
			
		NewConnObj.Close
			
	else
		
		if len(Keyword) = 0 then ' if its not a search display home link
				TopNavLinks = "<a href='" & Path2Admin & "managecategories.asp'>Home</a>  "
		end if
	
	end if 
	
End Sub

Sub ConstructCategories (theID) 
		
		Dim NewConnObj, CategoryTitle
		
			Set NewConnObj = Server.CreateObject("ADODB.Connection")
			NewConnObj.Open MyConnStr
			SQL = "SELECT ID, CategoryName, ParentID FROM del_Directory_Categories WHERE ID = " & theID 
			Set CategoryTitle = NewConnObj.Execute(SQL) 
				
			If CategoryTitle.EOF then	
			
				TopNavLinks = "No Category Found"
				
			else	
			
			if i = 0 then
			TopNavLinks = "Home " & NavigationSep & " "
			end if
				
				i = i + 1
			
				if CategoryTitle("ParentID") <> 0 then
					ConstructCategories CategoryTitle("ParentID")
				end if
				
				if CategoryTitle("ParentID") <> 0 then 
				TopNavLinks = TopNavLinks & " " &  NavigationSep & " "
				end if

				TopNavLinks = TopNavLinks & CategoryTitle("CategoryName")

			end if
		
		
		NewConnObj.Close
		Set CategoryTitle = Nothing
		Set NewConnObj = Nothing

End Sub
%>
