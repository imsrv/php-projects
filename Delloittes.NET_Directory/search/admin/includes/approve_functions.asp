
<% 

'*****************************************
' Subs for the approvelinks.asp page
'*****************************************

Sub ShowApproveResourceHead()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/aplinks.gif' align='absmiddle'>&nbsp;&nbsp;"
	response.write "<font class='menuLinks'>Approve Resources</font>"
	response.write "</td></tr>"
	response.write "<tr><td background='images/divide_bg.gif'></td></tr>"
	response.write "<tr><td bgcolor='#ffffff'>"
	response.write "<font class='general_small_text'>"
	response.write "Approve, move or edit link submissions before they are indexed into the database."
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"

End Sub

Sub ShowUnapprovedResources()

	Dim ConnObj, TheSet	

	SQL = "SELECT * FROM del_Directory_Sites "
	
		if DatabaseType = "Access" then
			SQL = SQL & "WHERE PublishOnWeb = False"
		else	
			SQL = SQL & "WHERE PublishOnWeb = 0"
		end if
			
	SQL = SQL & " ORDER BY Created DESC, Title" 
		
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj
	
	With Response
	
	.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	.write "<tr><td>"
	.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	.write "<tr><td bgcolor='#F9F9F9'>"
	.write "<font class='general_small_text'><b>"
	
	if TheSet.RecordCount <> 1 then
	.write TheSet.RecordCount & " links waiting approval."
	else
	.write TheSet.RecordCount & " link waiting approval."
	end if
	
	.write "</b></font>"
	.write "</td></tr></table>"
	.write "</td></tr></table><br>"
		
			if TheSet.EOF or TheSet.BOF then ' no records found 
			
			else ' we have a result 
			
			Do Until TheSet.EOF 
	
			.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'><tr><td>"
				
			.write "<table width='100%' align='center' cellspacing='0' cellpadding='6' Border='0'>"		
			.write "<tr><td valign='top' bgcolor='#F9F9F9'>"
	
				.write "<table width='100%' cellspacing='0'>"
				.write "<tr><td>"
				
				' draw resource link
				
				.write "<a class='listing_head' href='" & TheSet("URL") & "' title='" 
				.write TheSet("Title") & "' target='_blank'>"
	
					If len(TheSet("Title")) >= 40 then
						.write left(TheSet("Title"),40) & "..."
					else
						.write TheSet("Title") 
					end if
				
				.write "</a>"
				
				if TheSet("Sponsor") = true then
					.write " <img src='" & Path2Directory & "images/sponsor.gif' alt='Sponsor' align='absmiddle'> "
				else
					.write " "
				end if

				if TheSet("Favorite") = true then
					.write "<img src='" & Path2Directory & "images/fav.gif' alt='Favorite' align='absbottom'> "
				else
					.write " "
				end if

				.write NewIcon(TheSet("Created")) 
				
				.write " <font class='general_small_text'><i>("
				.write TheSet("Created")
				.write ")</i></font>"
				
				.write "</td><td align='right'>"
				
				.write "<font class='general_small_text'>"
				.write "<a href='approvelinks.asp?action=approve&siteid=" & TheSet("ID") & "'>"
				.write "Edit & Approve</a> | "
				If TheSet("CategoryID") <> 0 then
				.write "<a href='approvelinks.asp?action=justapprove&siteid=" & TheSet("ID") & "&catid="
				.write TheSet("CategoryID") & "'>"
				.write "Just Approve</a> | "
				end if
				.write "<a href='approvelinks.asp?action=delete&id=" & TheSet("ID") & "'>"
				.write "Delete Resource</a>"
				.write "</font></td></tr></table>"

			.write "</td></tr>"
	
			.write "<tr><td bgcolor='#bcbcbc'></td></tr>"	
	
			.write "<tr><td bgcolor='#ffffff'>"
	
			' draw description
	
			.write "<font class='listing_description'>"
			if TheSet("Description") <> "" then response.write TheSet("Description")  
			.write "</font>"
	
			' draw report error and bookmark links
	
			.write "<br><br>"
	
			.write "<table width='100%' cellspacing='0'>"
			.write "<tr><td>"
			.write "<font class='general_small_text'>"
	
			i = 0
			ConstructTopNavigation TheSet("CategoryID")
			.write TopNavLinks ' write top navigation to screen and chop off last seperator
			.write "</font>"	
			.write "</td>"
	
			if TheSet("DuplicateURL") = True then
			.write "<td align='right'>"
			.write "<font class='warning_text'><b>Duplicate URL <img src='" & Path2Admin & "images/dupe.gif'  align='absmiddle'></b></font>"
			.write "</td>"
			end if	
	
			.write "</td></tr></table>"
			.write "</td></tr></table>"			
			.write "</td></tr></table><br>"
	
				TheSet.MoveNext		
				Loop

		end if
	
	End With
	
	ConnObj.Close
	Set ConnObj = Nothing
	Set TheSet = Nothing

	
End Sub

Sub ShowSingleResource(siteID,Publish)

Dim ConnObj, Records

	if DatabaseType <> "Access" then Publish = cint(Publish)

	SQL = "SELECT * FROM del_Directory_Sites WHERE del_Directory_Sites.ID = " & siteID & " AND PublishOnWeb = " & Publish
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr 
	Set Records = ConnObj.Execute(SQL)
	
	With Response

	If Records.EOF then
		.write "<table width='90%' cellpadding='1' align='center' cellspacing='0'><tr><td>"
		.write "<font class='general_text'>"
		.write "<b>No selected Resource</b>"
		.write "</font>"
		.write "</td></tr></table><br>"
	else

		.write "<table width='90%' bgcolor='#bbbbbb' cellpadding='1' align='center' cellspacing='0'><tr><td>"
		
		.write "<table width='100%' cellspacing='0' cellpadding='7'>"
		.write "<tr><td colspan='2' bgcolor='" & CellBGColor & "'>"
		
		' draw resource link
		
		.write "<a class='listing_head' href='" & Path2Directory & "redirect.asp?id=" & Records("ID") 
		.write "' title='" 
		.write Records("Title") & "' target='_blank'>"
	
			If len(Records("Title")) >= 40 then
				.write left(Records("Title"),40) & "..."
			else
				.write Records("Title") 
			end if
		
		.write "</a>"

		if Records("Sponsor") = true then
		.write " <img src='" & Path2Directory & "images/sponsor.gif' alt='Sponsor' align='absmiddle'> "
		else
		.write " "
		end if

		if Records("Favorite") = true then
		.write "<img src='" & Path2Directory & "images/fav.gif' alt='Favorite' align='absbottom'> "
		else
		.write " "
		end if

		.write NewIcon(Records("Created")) 
		
		.write "</td></tr>"	

		.write "<tr><td bgcolor='#ffffff'>"
	
		' draw created and last visited date
		
		.write "<font class='created_date'>"
		.write "Created: " & FormatDateTime(Records("Created"),2) & ", " 
		.write "Last Visit: " & FormatDateTime(Records("LastAccessed"),2)
		.write "</font>"
		
		.write "</td>"		
		.write "<td bgcolor='#ffffff' align='right'>"
		
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
		
		.write "<font class='hits_count'>"
		.write "Hits Today: " & Records("HitsToday") & ", "
		.write "This Month: " & Records("HitsThisMonth") & ", " 
		.write "Overall: " & Records("Hits")
		.write "</font>"
		
		.write "</td>"
				
	.write "</tr>"
	
	.write "<tr><td bgcolor='#ffffff' colspan='2'>"
	
	' draw description
	
	.write "<font class='listing_description'>"
	if Records("Description") <> "" then response.write Records("Description")  
	.write "</font>"
	
	' draw report error and bookmark links
	
	.write "<br><br>"
	
	.write "<table width='100%' cellspacing='0'>"
	.write "<tr><td>"
	.write "<font class='general_small_text'>"
	
	i = 0 ' reset counter
	
	ConstructTopNavigation Records("CategoryID")
	
	.write TopNavLinks ' write top navigation to screen and chop off last seperator
	.write "</font>"	
	.write "</td>"
	
	if Records("DuplicateURL") = True then	
		.write "<td align='right'>"
		.write "<font class='warning_text'><b>Duplicate URL <img src='" & Path2Admin & "images/dupe.gif' alt='Sponsor' align='absmiddle'></b></font>"
		.write "</td>"	
	end if	
	
	.write "</td></tr></table>"
	.write "</td></tr></table>"	
	.write "</td></tr></table><br>"

	End If
	
	End With

	ConnObj.Close
	Set ConnObj = Nothing
	Set Records = Nothing

End Sub

Sub ConstructTopNavigation (theID) 

			Dim ConnObj, CategoryTitle
			
			Set ConnObj = Server.CreateObject("ADODB.Connection")
			ConnObj.Open MyConnStr
			SQL = "SELECT ID, CategoryName, ParentID FROM del_Directory_Categories WHERE ID = " & theID 
			Set CategoryTitle = ConnObj.Execute(SQL) 
				
			If CategoryTitle.EOF then	
			
				TopNavLinks = "<b>No Category Found</b>"
				
			else	
			
			if i = 0 then
			TopNavLinks = "<a href='" & Path2Admin & "managecategories.asp'>Home</a> " & NavigationSep & " "
			end if
				
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
		
		Set CategoryTitle = Nothing
		ConnObj.Close
			

End Sub

Sub ConstructCategories (theID) 

		Dim ConnObj, CategoryTitle
		
			Set ConnObj = Server.CreateObject("ADODB.Connection")
			ConnObj.Open MyConnStr
			SQL = "SELECT ID, CategoryName, ParentID FROM del_Directory_Categories WHERE ID = " & theID 
			Set CategoryTitle = ConnObj.Execute(SQL) 
				
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
		
		ConnObj.Close
		Set CategoryTitle = Nothing
		Set ConnObj = Nothing

End Sub

Sub DrawEditForm(siteID)

	Dim ConnObj, TheSet, CategoryRecords
	
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
	.write "<font class='general_small_text'>Before this resource is added to the directory you have a chance to screen its content to ensure it is suitible for your visitors. Use the form below to edit the resource before it is indexed within the directory. Once you are happy with this resource click the ""Save Changes & Add To Directory"" button at the bottom of this form. The resource will then be added to the directory and all category count information will be updated.</b></font>"
	.write "</td></tr></table>"
	.write "</td></tr></table><br>"
	
	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form onSubmit='return checkForm(this)' action='approvelinks.asp?action=add2directory' method='POST' name='frmResourceEdit'>"
	.write "<input type='hidden' name='SiteID' value='" & SiteID & "'>"
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
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' name='favorite'></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Mark As Sponsor:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' name='sponsor'></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9' valign='top'><font class='form_text'>Select category for this item:</font></td>"
	.write "<td bgcolor='#F9F9F9'><select name='category' class='display_cats' size='20'>"
	
	
			If DatabaseType = "Access" then 
				SQL = "SELECT ID FROM del_Directory_Categories WHERE AllowLinks = True ORDER BY ParentID, CategoryName"
			else
				SQL = "SELECT ID FROM del_Directory_Categories WHERE AllowLinks = 1 ORDER BY ParentID, CategoryName"
			end if
			
			Set CategoryRecords = Server.CreateObject("ADODB.Recordset")
			CategoryRecords.CursorLocation = 3
			CategoryRecords.Open SQL, ConnObj
			
			if CategoryRecords.EOF then
			.write "<option value=''>No Categories Found</option>"
			else
			
			CategoryRecords.MoveFirst
			Do Until CategoryRecords.EOF
			
				.write "<option value='" & CategoryRecords("ID") & "'"
				if TheSet("CategoryID") = CategoryRecords("ID") then
				.write " selected"
				end if
				.write ">"
				
				i = 0
				ConstructCategories CategoryRecords("ID")
				.write TopNavLinks 
				.write "</option>"
			
			CategoryRecords.MoveNext
			Loop
			 
			end if
			
			Set CategoryRecords = Nothing
			Set TheSet = Nothing
			ConnObj.Close
	
	.write "</select> *</td>"
	.write "</tr><tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Save Changes & Add To Directory'> "
	.write "<input type='reset' class='form_buttons' onclick='javascript:location = """ & Request.ServerVariables("HTTP_REFERER") & """;' name='reset' value='Cancel'>"
	.write "</td></tr></table>"

	.write "</td></tr></table><br>"

	End With

	end if
	
	

End Sub

Function CheckString(strInput)
	
	Dim strTemp
	strTemp = Replace(strInput, "'", "''")
	strTemp = Replace(strTemp, vbcrlf, "")
	CheckString = strTemp
	
End Function

Sub DoUpdate (theID) 
		
		Dim ConnObj, Favorite, Sponsor
		
		if request.form("favorite") = "ON" then
			
			If DatabaseType = "Access" then
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
		SQL = SQL & "CategoryID = " & request.form("category") & ", "
		
			If DatabaseType = "Access" then 
				SQL = SQL & "Created = #" & shortdate & "#, "
			else
				SQL = SQL & "Created = '" & ShortDateIso & "', "
			end if
			
		SQL = SQL & "Favorite = " & Favorite & ", "
		
			If DatabaseType = "Access" then 
				SQL = SQL & "PublishOnWeb = True, "
			else
				SQL = SQL & "PublishOnWeb = 1, Hits = 0, HitsToday = 0, HitsThisMonth = 0, "
			end if
			
		SQL = SQL & "Sponsor = " & Sponsor
		SQL = SQL & " WHERE id = " & theID
		
		Set ConnObj = Server.CreateObject("ADODB.Connection")
		ConnObj.Open MyConnStr
		ConnObj.Execute(SQL) 	
		ConnObj.Close
		Set ConnObj = Nothing
						
		UpdateCategoryCounts request.form("category") ' update all category counts		
		
	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='general_small_text'>This resource has been added to the directory and is now live to your visitors. If you wish to make changes to this resource again please use the edit form. Do not click back and make changes or refresh this page as this will increment the category counts again giving an inaccurate count of resources within associated categories.<br><br><b><a href='approvelinks.asp'>Approve More Links...</a></b></font>"
	response.write "</td></tr></table>"
	response.write "</td></tr></table><br>"
			

End Sub

Sub UpdateCategoryCounts (CatID)
	
	Dim ConnObj, SQL, Records, NewListingCount
	
	SQL = "SELECT ParentID, ListingCount FROM del_Directory_Categories WHERE ID = " & CatID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set Records = ConnObj.Execute(SQL)
	
	If Records.EOF Then
	
		Response.write "No Category Specified"
	
	Else
		
		NewListingCount = Records("ListingCount") + 1 
		
		If DatabaseType = "Access" then 
			SQL = "UPDATE del_Directory_Categories SET ListingCount = " & NewListingCount & ", "
			SQL = SQL & "LastUpdated = #" & ShortDate & "# WHERE ID = " & CatID
		else
			SQL = "UPDATE del_Directory_Categories SET ListingCount = " & NewListingCount & ", "
			SQL = SQL & "LastUpdated = '" & ShortDateIso & "' WHERE ID = " & CatID
		end if
		
		ConnObj.Execute(SQL)	
	
		if Records("ParentID") <> 0 then
			UpdateCategoryCounts (Records("ParentID"))
		end if
	
	End IF
	
	ConnObj.Close
	Set ConnObj = Nothing
	Set Records = Nothing
	
	
End Sub

Sub ShowDelete()

	response.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td align='center'>"
	response.write "<font class='warning_text'><b><img src='images/warning.gif' align='absmiddle'> WARNING:</font></b><br><br><font class='general_small_text'>You are about to delete the above resource from the database.<br><br>Are you sure you want to delete this resource?<br><br><a href='approvelinks.asp?action=dodelete&ID=" & request.querystring("ID") & "'><b>YES</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='" & Request.ServerVariables("HTTP_REFERER") & "'><b>NO</b></a></font>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub DeleteResource(siteID)

	Dim SQL, ConnObj
	SQL = "DELETE FROM del_Directory_Sites WHERE ID = " & SiteID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)
	ConnObj.Close
	Set ConnObj = Nothing	
	response.write "<script>location = 'approvelinks.asp';</script>"

End Sub

Sub JustApprove(siteID)
	
	Dim SQL, ConnObj
	
		If DatabaseType = "Access" then
			SQL = "UPDATE del_Directory_Sites SET PublishOnWeb = True WHERE ID = " & SiteID
		Else
			SQL = "UPDATE del_Directory_Sites SET PublishOnWeb = 1, Hits = 0, HitsToday = 0, HitsThisMonth = 0 WHERE ID = " & SiteID
		End If
			
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)
	ConnObj.Close
	Set ConnObj = Nothing	
	
	UpdateCategoryCounts request.querystring("catid") ' update all category counts	
	
	response.write "<script>location = 'approvelinks.asp';</script>"

End Sub

'*****************************************
' Subs for the approvereviews.asp page
'*****************************************

Sub ShowReviewHead()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/apreview.gif' align='absmiddle'>&nbsp;&nbsp;"
	response.write "<font class='menuLinks'>Approve Reviews</font>"
	response.write "</td></tr>"
	response.write "<tr><td background='images/divide_bg.gif'></td></tr>"
	response.write "<tr><td bgcolor='#ffffff'>"
	response.write "<font class='general_small_text'>"
	response.write "Approve or edit reviews before they become public to ensure they are suitible for the directory."
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"

End Sub

Sub ShowUnapprovedReviews()
	
	Dim SQL, ConnObj, TheSet, RecordCount
		
	SQL = "SELECT * FROM del_Directory_Reviews "
	
	if DatabaseType = "Access" then
		SQL = SQL & "WHERE PublishOnWeb = False"
	else	
		SQL = SQL & "WHERE PublishOnWeb = 0"
	end if
			
	SQL = SQL & " ORDER BY Created ASC" 
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj
	
	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='general_small_text'><b>"
	
	if TheSet.RecordCount <> 1 then
		response.write TheSet.RecordCount & " reviews waiting approval."
	else
		response.write TheSet.RecordCount & " reviews waiting approval."
	end if
	
	response.write "</b></font>"
	response.write "</td></tr></table>"
	response.write "</td></tr></table><br>"

		
	if TheSet.EOF or TheSet.BOF then ' no records found 

	else ' we have a result 

	Do Until TheSet.EOF 
	
		ShowSingleResource TheSet("SiteID"),True
		 
		With Response
			
			.write "<table width='90%' align='center' cellpadding='0' cellspacing='1'  bgcolor='#bbbbbb'>"
			.write "<tr><td>"
			
					.write "<table cellspacing='0' width='100%' cellpadding='7'>"
					.write "<tr><td bgcolor='#F9F9F9'>"
					.write "<font class='general_text'><b>"
					.write TheSet("Title") 
					.write "</b></font>"
					.write "</td><td bgcolor='#F9F9F9' align='right'>"
					.write "<img src='" & Path2Directory & "images/rating.gif'>&nbsp;&nbsp;" 
					 DrawReviewerRating TheSet("Rated")
					.write "</td>"
					.write "<td align='right' bgcolor='#F9F9F9'>"
					.write "<font class='general_small_text'>"
					.write "<a href='approvereviews.asp?action=approve&reviewid=" & TheSet("ID") & "'>"
					.write "Edit & Approve</a> | "
					.write "<a href='approvereviews.asp?action=justapprove&reviewid=" & TheSet("ID") & "'>"
					.write "Just Approve</a> | "
					.write "<a href='approvereviews.asp?action=delete&id=" & TheSet("ID") & "'>"
					.write "Delete Review</a>"
					.write "</font></td></tr>"		
					.write "<tr><td colspan='3' bgcolor='#F9F9F9'></td></tr>"			
					.write "<tr><td colspan='2' bgcolor='#ffffff'>"
					.write "<font class='general_small_text'>"
					.write "Written by " & TheSet("FullName") 
					
						 if TheSet("EmailAddress") <> "" then
						 
								if Instr(1,TheSet("EmailAddress"),"@",1) then
						.write " - <i>[ <a href='mailto:" & TheSet("EmailAddress") & "' class='general_small_text'>" 
								else
						.write " - <i>[ <a href='" & TheSet("EmailAddress") & "' class='general_small_text'>" 	
								end if
							
						.write TheSet("EmailAddress") & "</a> ]</i>"
						
						 end if 
					.write "</font>"
					.write "</td><td bgcolor='#ffffff' align='right'>"
					.write "<font class='general_small_text'>"
					.write "Added: " & FormatDateTime(TheSet("Created"),2) 
					.write "</font>"
					.write "<tr><td colspan='3' bgcolor='#ffffff'>"
					.write "<font class='general_text'>"
					.write TheSet("Comments")
					.write "</font>"
					.write "</td></tr></table>"
					
			.write "</td></tr></table><br>"
			
		End With
	
		TheSet.MoveNext		
		Loop
	
	end if
	
	ConnObj.Close
	Set ConnObj = Nothing
	Set TheSet = Nothing

End Sub

Sub ShowSingleReview(reviewID)

	Dim ConnObj, TheSet, SQL

	SQL = "SELECT * FROM del_Directory_Reviews WHERE ID = " & reviewID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj

	if TheSet.EOF or TheSet.BOF then ' no records found 
		
		Response.write "<table width='90%' align='center' cellspacing='0' cellpadding='0' Border='0'>"		
		response.write "<tr><td>"
		response.write "<font class='general_text'>"
		response.write "No resources found.</font>"
		response.write "</td>"
		response.write "</tr></table>"

	else ' we have a result 

	
	Do Until TheSet.EOF 
	
		With Response
			
			.write "<table width='90%' align='center' cellpadding='0' cellspacing='1'  bgcolor='#bbbbbb'>"
			.write "<tr><td>"
			
					.write "<table cellspacing='0' width='100%' cellpadding='7'>"
					.write "<tr><td bgcolor='#F9F9F9'>"

					.write "<font class='general_text'><b>"
					.write TheSet("Title") 
					.write "</b></font>"
					.write "</td><td bgcolor='#F9F9F9' align='right'>"
					.write "<img src='" & Path2Directory & "images/rating.gif'>&nbsp;&nbsp;" 
					 DrawReviewerRating TheSet("Rated")
					.write "</td></tr>"		
					.write "<tr><td colspan='2' bgcolor='#F9F9F9'></td></tr>"			
					.write "<tr><td bgcolor='#ffffff'>"
					.write "<font class='general_small_text'>"
					.write "Written by " & TheSet("FullName") 
						 if TheSet("EmailAddress") <> "" then
						 
								if Instr(1,TheSet("EmailAddress"),"@",1) then
						.write " - <i>[ <a href='mailto:" & TheSet("EmailAddress") & "' class='general_small_text'>" 
								else
						.write " - <i>[ <a href='" & TheSet("EmailAddress") & "' class='general_small_text'>" 	
								end if
								
						.write TheSet("EmailAddress") & "</a> ]</i>"
						 end if 
					.write "</font>"
					.write "</td><td bgcolor='#ffffff' align='right'>"
					.write "<font class='general_small_text'>"
					.write "Created: " & FormatDateTime(TheSet("Created"),2) 
					.write "</font>"
					.write "<tr><td colspan='2' bgcolor='#ffffff'>"
					.write "<font class='general_text'>"
					.write TheSet("Comments")
					.write "</font>"
					.write "</td></tr></table>"
					
			.write "</td></tr></table><br>"
			
		End With
	
		TheSet.MoveNext		
		Loop
	
	end if
	
	ConnObj.Close
	Set ConnObj = Nothing
	Set TheSet = Nothing
	
End Sub

Sub DrawReviewForm(reviewID)

	Dim ConnObj, TheSet, SQL

	SQL = "SELECT * FROM del_Directory_Reviews WHERE ID = " & reviewID  
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
	.write "<font class='general_small_text'>Before this review is added to the directory you have a chance to screen its content to ensure it is suitible for your visitors. Use the form below to edit the review before it is indexed within the directory. Once you are happy with this review click the ""Save Changes & Add To Directory"" button at the bottom of this form. The review will then be added to the directory.</b></font>"
	.write "</td></tr></table>"
	.write "</td></tr></table><br>"

	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form onSubmit='return checkForm(this)' action='approvereviews.asp?action=add2directory' method='POST' name='frmResourceEdit'>"
	.write "<input type='hidden' name='reviewID' value='" & reviewID & "'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Review Title:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value=""" & TheSet("Title") & """ class='input' name='title' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Full Name:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value=""" & TheSet("FullName") & """ class='input' name='fullname' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Email:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value=""" & TheSet("EmailAddress") & """ class='input' name='emailaddress' size='62'></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td valign='top' bgcolor='#F9F9F9'><font class='form_text'>Review Comments:</font></td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<textarea name='comments' wrap='physical'"
	.write "onKeyDown='textCounter(this.form.comments,this.form.remLen,250);' "
	.write "onKeyUp='textCounter(this.form.comments,this.form.remLen,250);' rows='12' cols='55'>"
	.write TheSet("Comments")
	.write "</textarea> *</font><br>"
	.write "<input type='text' class='input' readonly value='250' name='remLen' size='3'> "
	.write "<font class='form_text'> Characters left. 250 Max Characters.</font>"
	.write "</td>"
	.write "</tr>"
	.write "<tr><td valign='top' bgcolor='#F9F9F9'><font class='form_text'>Rating:</font></td>"
	.write "<td bgcolor='#F9F9F9'><select name='Rating'>"
	.write "<option value='5'"
	if TheSet("Rated") = 5 then response.write " selected"
	.write ">5 Stars - Best Rating</option>"
	.write "<option value='4'"
	if TheSet("Rated") = 4 then response.write " selected"
	.write ">4 Stars </option>"
	.write "<option value='3'"
	if TheSet("Rated") = 3 then response.write " selected"
	.write ">3 Stars</option>"
	.write "<option value='2'"
	if TheSet("Rated") = 2 then response.write " selected"
	.write ">2 Stars</option>"
	.write "<option value='1'"
	if TheSet("Rated") = 1 then response.write " selected"
	.write ">1 Star - Worst Rating</option>"
	.write "</select> *</td>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Save Review & Add To Directory'> "
	.write "<input type='reset' class='form_buttons' onclick='javascript:location = """ & Request.ServerVariables("HTTP_REFERER") & """;' name='reset' value='Cancel'>"
	.write "</td></tr></table>"
	.write "</td></tr></table><br>"

	End With

	end if
	
	ConnObj.Close
	Set ConnObj = Nothing
	Set TheSet = Nothing

End Sub

Sub DoReviewUpdate(reviewID) 

	Dim ConnObj, SQL

		SQL = "UPDATE del_Directory_Reviews SET Title = '" & CheckString(request.form("title")) & "', "
		SQL = SQL & "FullName = '" & CheckString(request.form("fullname")) & "', "
		SQL = SQL & "EmailAddress = '" & CheckString(request.form("emailaddress")) & "', "
		SQL = SQL & "Comments = '" & CheckString(request.form("comments")) & "', "
		SQL = SQL & "Rated = '" & CheckString(request.form("rating")) & "', "
		
			if DatabaseType = "Access" then
				SQL = SQL & "Created = #" & shortdate & "#, "
				SQL = SQL & "PublishOnWeb = True"
			else
				SQL = SQL & "Created = '" & ShortDateIso & "', "
				SQL = SQL & "PublishOnWeb = 1"
			end if
		
		SQL = SQL & " WHERE id = " & reviewID
		
		Set ConnObj = Server.CreateObject("ADODB.Connection")
		ConnObj.Open MyConnStr
		ConnObj.Execute(SQL) 	
		ConnObj.Close
		Set ConnObj = Nothing
		
	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='general_small_text'>This review has been added to the directory and is now live to your visitors. <br><br><b><a href='approvereviews.asp'>Approve More Reviews...</a></b></font>"
	response.write "</td></tr></table>"
	response.write "</td></tr></table><br>"
			

End Sub

Sub ShowReviewDelete()

	response.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td align='center'>"
	response.write "<font class='warning_text'><b><img src='images/warning.gif' align='absmiddle'> WARNING:</font></b><br><br><font class='general_small_text'>You are about to delete the above review from the database.<br><br>Are you sure you want to delete this review?<br><br><a href='approvereviews.asp?action=dodelete&ID=" & request.querystring("ID") & "'><b>YES</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='" & Request.ServerVariables("HTTP_REFERER") & "'><b>NO</b></a></font>"
	response.write "</td></tr></table><br>"
	
End Sub


Sub DeleteReview(reviewID)
	
	Dim ConnObj, SQL
	
	SQL = "DELETE FROM del_Directory_Reviews WHERE ID = " & reviewID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)
	ConnObj.Close
	Set ConnObj = Nothing
	
	response.write "<script>self.location = 'approvereviews.asp';</script>"

End Sub

Sub JustApproveReview(reviewID)

	Dim ConnObj, SQL

	if DatabaseType = "Access" then
		SQL = "UPDATE del_Directory_Reviews SET PublishOnWeb = True WHERE ID = " & reviewID
	else
		SQL = "UPDATE del_Directory_Reviews SET PublishOnWeb = 1 WHERE ID = " & reviewID
	end if
		
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)
	ConnObj.Close
	Set ConnObj = Nothing
	
	response.write "<script>location = 'approvereviews.asp';</script>"

End Sub

Sub DrawReviewerRating(Rated)

	if Rated = 1 then	
	response.write "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif Rated = 2 then
	response.write "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif Rated = 3 then
	response.write "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif Rated = 4 then
	response.write "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif Rated = 5 then
	response.write "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'>"
	else
	response.write "<img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"	
	end if 

End Sub

%>
