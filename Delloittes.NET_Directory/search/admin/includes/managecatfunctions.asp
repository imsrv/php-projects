<% 

'*****************************************************
' Request global category ids to determine current category
'*****************************************************
	
	Dim ID, ParentID
	
	if len(request.querystring("id")) <> 0 then
		ID = request.querystring("id") 
	else
		ID = request.form("id")
	end if
	
	if len(request.querystring("parentid")) <> 0 then
		ParentID = request.querystring("parentid")
	else
		ParentID = request.form("ParentID")
	end if
	
	i = 0 ' counter for top navigation sub

'*****************************************************
' Call Recursive Sub to create top navigation
'*****************************************************

ConstructTopNavigation ID ' call sub to construct top navigation

Sub Header()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/cats.gif' align='absmiddle'>&nbsp;&nbsp;"
	response.write "<font class='menuLinks'>Manage Categories</font>"
	response.write "</td></tr>"
	response.write "<tr><td background='images/divide_bg.gif'></td></tr>"
	response.write "<tr><td bgcolor='#ffffff'>"
	response.write "<font class='general_small_text'>"
	response.write "Browse, modify, move or delete categories and resources within the directory."
	response.write "</font>"
	response.write "</td></tr>"
	response.write "</table>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub ShowInfo()
	
	With Response
	
		.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
		.write "<tr><td>"
		.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
		.write "<tr><td bgcolor='#F9F9F9'>"
		.write "<img src='images/icons/help.gif' align='right' hspace='10'><font class='general_small_text'>You can modify, move or delete categories within your directory using options to the right of each category title below. While browsing your directory you can also modify, move or delete items within the directory."
		.write "</td></tr></table>"
		.write "</td></tr></table><br>"
	
	End With
	
End Sub

'*****************************************************
' The ShowDirectory Sub contains all the code for writting
' the various categories to the screen
'*****************************************************

Sub ShowDirectory()

	Dim ConnObj, SQL, Records, Flag
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr

'*************************************************
' Display cateogry results depending on catID and parentID
'*************************************************
		
	if len(ID) = 0 AND len(ParentID) = 0 then ' Both ID and ParentID are empty so dislay top level categories
		SQL = "SELECT * FROM del_Directory_Categories WHERE ParentID = 0 ORDER BY CategoryName"
	else ' Users has selected to view a sub category
		SQL = "SELECT * FROM del_Directory_Categories WHERE ParentID = " & ID & " ORDER BY CategoryName"
	end if	

	if Debug = True then response.write SQL

	Set Records = ConnObj.Execute(SQL)	

	Response.write "<table width='91%' cellspacing='0' align='center' cellpadding='8' Border='0'>"	
	response.write "<tr><td>"
	response.write "<font class='main_navigation'>"
	response.write TopNavLinks ' write top navigation to screen 
	response.write "</font>"
	response.write "</td></tr>"	
	response.write "</table>"

	if Records.EOF or Records.BOF then
	
		if IsCategoryAllowedListings then ' if resources are allowed within this category show then
			ShowListings ' show all listings for this category
		end if
		
	else 

 	Flag = True 
 
	Response.write "<table width='91%' cellspacing='0' align='center' cellpadding='8' Border='0'>"
		
 	Records.MoveFirst
  	 Do Until Records.EOF
	
		if Flag = true then response.write "<tr>" ' if flag = true then start new row	
			response.write "<td valign='top' width='50%'>"
	
			' Draw category title, listing count and new icon
			 
		response.write "<a class='category_head' href='" & Path2Admin & "managecategories.asp?id=" & Records("ID")
				if Records("ParentID") <> 0 then 
					response.write "&parentID=" & Records("ParentID") & "'>"
				else
					response.write "'>"
				end if
				
			response.write Records("CategoryName")
			response.write "</a>"
			response.write "<font class='category_count'>"
			response.write " (" & Records("ListingCount") & ") "
			response.write NewIcon(Records("LastUpdated")) 
			
			
		response.write " <font class='general_small_text'>"
		response.write "<a href='managecategories.asp?action=modifyname&id=" & Records("ID") & "&parentid=" & Records("ParentID") & "'><img src='images/modifycatname.gif' align='absmiddle' title='Modify category name' border='0' width='15' height='14'></a> "
		response.write "<a href='managecategories.asp?action=modify&id=" & Records("ID") & "&parentid=" & Records("ParentID") & "'><img src='images/moveresource.gif' align='absmiddle' title='Modify or move this category' border='0' width='13' height='16'></a> "
		response.write "<a href='managecategories.asp?action=delete&id=" & Records("ID") & "&parentid=" & Records("ParentID") & "'><img src='images/bin.gif' align='absmiddle' title='Delete this category' border='0' width='16' height='16'></a>"
		response.write "</font>"
		
		response.write "<br>"
			
			ShowSubCategories Records("ID") ' create sub categories or listing under main category head
	
			response.write "</td>"	
								
		if Flag = false then response.write "</tr>" 		
				
		if Flag = true then
		Flag = false
		elseif Flag = false then
		Flag = true
		end if
				
  	 Records.MoveNext
 	Loop
	
		if IsCategoryAllowedListings then ' if resources are allowed within this category show then
			response.write "</table>" 
			ShowListings ' show all listings for this category
		else	
			'ShowDirectoryKey ' if no listings allow just show the directory key
			response.write "</table>" 
		end if

	end if
	
	Set Records = Nothing
	ConnObj.Close 



End Sub 

'*****************************************************
' The ShowResults Sub contains all the code for writting
' the various listings within a certain category
'*****************************************************

Sub ShowListings()

	Dim ConnObj, TheSet, SQL, iPageCount, iPageCurrent, iPageSize, iResultCount

	SQL = "SELECT * FROM del_Directory_Sites WHERE CategoryID = " & ID
	
		if DatabaseType = "Access" then 
			SQL = SQL & " AND PublishOnWeb = True"		
		else
			SQL = SQL & " AND PublishOnWeb = 1"
		end if
		
	SQL = SQL & " ORDER BY Created DESC, Title DESC"

	If request.queryString("page") = "" Then
		iPageCurrent = 1
	Else
		iPageCurrent = CInt(request.queryString("page"))
	End If	
	
	' We have SQL now open data

	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
			
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	
	TheSet.CursorLocation = 3
	TheSet.PageSize = LinksPerPage
	TheSet.Open SQL, ConnObj
		
	iPageCount = TheSet.PageCount
	
	Response.write "<table width='90%' cellspacing='0' align='center' cellpadding='8' Border='0'>"
		
	if TheSet.EOF or TheSet.BOF then ' no records found 
		
		response.write "<tr><td>"
		response.write "<font class='general_text'>"
		response.write "Sorry, there are currently no resources available within this category.<br><br>"
		response.write "<a href='" & Path2Directory & "add.asp?id=" & ID & "&parentID=" & ParentID & "'>"
		response.write "Be the first to add your resource to this category.</a>"
		response.write "</td>"
		response.write "</tr>"
		
		ShowDirectoryKey ' show directory key

	else ' we have a result 
	
		If 1 > iPageCurrent Then iPageCurrent = 1
		If iPageCurrent > iPageCount Then iPageCurrent = iPageCount
		TheSet.AbsolutePage = iPageCurrent
		iResultCount = (iPageSize * (iPageCurrent - 1)) + 1
	
	response.write "<tr><td valign='top' bgcolor='#bcbcbc'></td></tr>"
	response.write "<tr><td>"
	
		response.write "<font class='page_results_count'>"
		response.write "Page " & iPageCurrent & " of " & iPageCount & " - " & TheSet.RecordCount 
		response.write " results found</font>"
		
	response.write "</td></tr>"
	
	response.write "<tr><td bgcolor='#bcbcbc'></td></tr>"
	
	Do While TheSet.AbsolutePage = iPageCurrent And Not TheSet.EOF 

	response.write "<tr><td valign='top' bgcolor='#F9F9F9'>"
	
		response.write "<table width='100%'>"
		response.write "<tr><td>"
		
		' draw resource link
		
	response.write "<a class='listing_head' href='" & Path2Directory & "redirect.asp?id=" & TheSet("ID") & "' title='" 
	response.write TheSet("Title") & "' target='_blank'>"
	
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
	
	response.write "<tr><td>"
	
		response.write "<table width='100%'><tr><td>"
		
		' draw created and last visited date
		
		response.write "<font class='created_date'>"
		response.write "Created: " & FormatDateTime(TheSet("Created"),2) & ", " 
		response.write "Last Visit: " & FormatDateTime(TheSet("LastAccessed"),2)
		response.write "</font>"
		
		response.write "</td>"		
		response.write "<td align='right'>"
		
		' reset hits today date and hits this month date
		
		if TheSet("HitsTodayDate") <> Day(Now()) then 
		SQL = "UPDATE del_Directory_Sites SET HitsToday = 0, HitsTodayDate = " & Day(Now()) & " WHERE id = " & TheSet("ID")
		ConnObj.Execute(SQL)
		end if
		if TheSet("HitsThisMonthDate") <> Month(Now()) then
		SQL = "UPDATE del_Directory_Sites SET HitsThisMonth = 0, HitsThisMonthDate = " & Month(Now()) 
		SQL = SQL & " WHERE id = " & TheSet("ID")
		ConnObj.Execute(SQL)
		end if
		
		' draw hits today, hits this month and overall hits
		
		response.write "<font class='hits_count'>"
		response.write "Hits Today: " & TheSet("HitsToday") & ", "
		response.write "This Month: " & TheSet("HitsThisMonth") & ", " 
		response.write "Overall: " & TheSet("Hits")
		response.write "</font>"
		
		response.write "</td></tr></table>"
		
	response.write "</td></tr>"
	
	response.write "<tr><td>"
	
	' draw description
	
	response.write "<font class='listing_description'>"
	if TheSet("Description") <> "" then response.write TheSet("Description")  
	response.write "</font>"
	
	' draw report error and bookmark links
	
	response.write "<br><br>"
	
	response.write "<font class='short_listing_url'>"
	response.write "<a href='" & Path2Directory & "redirect.asp?id=" & TheSet("ID") & "' target='_blank'>" 
	DrawShortURL TheSet("URL")
	response.write "</a>"
	response.write "</font>"

	response.write "</td></tr>"
	
	iResultCount = iResultCount + 1			
	
		TheSet.MoveNext		
		Loop

	
	response.write "<tr>"
	response.write "<td valign='top'>"	
	
		response.write "<table width='100%' border='0' cellpadding='0' cellspacing='0'>"
		response.write "<tr><td width='20%' align='left'>"
		
		If iPageCurrent > 1 Then
		
			 response.write "<a class='paging_links' href='managecategories.asp?page=" 
			 response.write iPageCurrent - 1 
			 response.write "&id=" & ID & "&parentID=" 
			 response.write ParentID & "'>Previous Page</a>"	
			 
		end if
		
		response.write "</td>"
		response.write "<td width='60%' align='center'>"	
		
		if iPageCount <> 1 then
	
			for i = 1 to iPageCount 	
				response.write "&nbsp;&nbsp;"
				if i = iPageCurrent then
				response.write "<font class='paging_links'>" & i & "</font>"
				else
				response.write "<a class='paging_links' href='managecategories.asp?page=" & i 
				response.write "&id=" & ID 
				response.write "&parentID=" & ParentID & "'>" & i & "</a>"
				end if
				response.write " "
			next
	
		end if
		
		response.write "</td>"
		response.write "<td width='20%' align='right'>"
		
		If iPageCurrent <> iPageCount Then
	
			response.write "<a class='paging_links' href='managecategories.asp?page=" 
			response.write iPageCurrent + 1 
			response.write "&id=" & ID & "&parentID="
			response.write ParentID & "'>Next Page</A>"
		
		end if	
		
		response.write "</td></tr></table>"
	
	response.write "</td></tr>"
	
	ShowDirectoryKey ' show directory key
	
	end if
	
	response.write "</table>"
	
	Set TheSet = Nothing
	ConnObj.Close
	
End Sub

'*****************************************************
' Show the directory key 
'*****************************************************

Sub ShowDirectoryKey ()

response.write "<tr><td colspan='2' align='center'>"
response.write "<font class='directory_key'>"
response.write "<img src='" & Path2Directory & "images/new1.gif' border='0' align='absbottom'> within last 4 days, "
response.write "<img src='" & Path2Directory & "images/new2.gif' border='0' align='absbottom'> within last 8 days, "
response.write "<img src='" & Path2Directory & "images/new3.gif' border='0' align='absbottom'> within last 12 days.<br>"
response.write "<img src='" & Path2Directory & "images/sponsor.gif' border='0' align='absbottom'> = " & DirectoryName & " Sponsor, "
response.write "<img src='" & Path2Directory & "images/fav.gif' border='0' align='absbottom'> = " & DirectoryName & " Favorite."
response.write "</font>"
response.write "</td></tr>"
	
End Sub

Sub ShowSingleCategory(id)

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='general_small_text'><b>"
	i = 0
	ConstructTopNavigation id
	response.write TopNavLinks 
	response.write "</b></font></td></tr></table>"
	response.write "</td></tr></table><br>"
	
End Sub
'*****************************************************
' The ChopString Function is used to truncate any 
' long sub categories or listing headers
'*****************************************************

Function ChopString(strDesc)

if len(strDesc) > 20 then ' if string is above 20 characters long loop though and look for space

	for i = len(strDesc) to 1 step - 1 ' loop through string backwards
	
		if mid(strDesc,i,1) = " " and i <= 20 then ' search for a space to chop string at
		
				if mid(strDesc,i - 1,1) = "&" then ' check for & or - and remove
					ChopString = left(strDesc,i - 3)
					exit for
				end if
				
				if mid(strDesc,i - 1,1) = "-" then
					ChopString = left(strDesc,i - 3)
					exit for
				end if
			
			ChopString = left(strDesc,i - 1)
			exit for
		
		else
		
			ChopString = strDesc ' no space in string before 20 characters so just output the full string
			
		end if
	next	
else
	ChopString = strDesc
end if	

End Function

'*****************************************************
' Determine when resource was added and display new icon
'*****************************************************

Function NewIcon(Updated)

	Dim DaysOld

	if Updated <> "" then
	
		DaysOld = DateDiff("d", formatdatetime(now(),2), formatdatetime(Updated,2))
		DaysOld = trim(replace(DaysOld,"-","",1))
	
		if DaysOld >= 0 and DaysOld <= 4 then
		NewIcon = "<img src='" & Path2Directory & "images/new1.gif' align='absbottom'>" 
		elseif DaysOld > 4 AND DaysOld <= 8 then
		NewIcon = "<img src='" & Path2Directory & "images/new2.gif' align='absbottom'>" 
		elseif DaysOld > 8 AND DaysOld <= 12 then
		NewIcon = "<img src='" & Path2Directory & "images/new3.gif' align='absbottom'>" 
		end if
		
	end if

End Function

'*****************************************************
' This sub renders the various categories or listings
' related to this category.
'*****************************************************

Sub ShowSubCategories(CurrentID)

	Dim ConnObj, SQL, SubCategories, TheRecordCount, adOpenDynamic, recordcount

	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	
	if len(ID) = 0 then ' if we are on homepage display sub categories
	
	  SQL = "SELECT DISTINCT TOP " & ShowSubCatAmount & " ID, "
	  SQL = SQL & "CategoryName, ParentID FROM del_Directory_Categories WHERE ParentID = " & CurrentID
	  SQL = SQL & " ORDER BY CategoryName"	  
	  
	elseif len(ID) <> 0 then ' else we are within a category so display items within category
	
	  SQL = "SELECT DISTINCT TOP " & ShowSubCatAmount & " Title, ID, HitsTodayDate FROM del_Directory_Sites "
	  SQL = SQL & "WHERE CategoryID = " & CurrentID & " AND "
	  
		if DatabaseType = "Access" then
			SQL = SQL & "PublishOnWeb = TRUE"
		else
			SQL = SQL & "PublishOnWeb = 1"
		end if
	  
	  SQL = SQL & " ORDER BY Title"
	  
	end if
	
	if Debug = True then response.write SQL

	Set SubCategories = Server.CreateObject("ADODB.Recordset")
	SubCategories.CursorLocation = 3
	SubCategories.Open SQL, ConnObj, adOpenDynamic
	TheRecordCount = SubCategories.RecordCount

	if SubCategories.EOF then 
	
			SQL = "SELECT DISTINCT TOP " & ShowSubCatAmount & " ID, "
			SQL = SQL & "CategoryName, ParentID FROM del_Directory_Categories WHERE ParentID = " & CurrentID
			SQL = SQL & " ORDER BY CategoryName"
		
			if Debug = True then response.write SQL
		
			Set SubCategories = Server.CreateObject("ADODB.Recordset")
			SubCategories.CursorLocation = 3
			SubCategories.Open SQL, ConnObj, adOpenDynamic
			TheRecordCount = SubCategories.RecordCount
			
			if SubCategories.EOF or SubCategories.BOF then 
			
				response.write ""
			
			else
						
				response.write "<font class='sub_categories'>"
	
				recordcount = 0
					
				SubCategories.MoveFirst
				 Do While NOT SubCategories.EOF	
				
				recordcount = recordcount + 1	

				response.write "<a class='sub_categories' href='" & Path2Admin & "managecategories.asp?id=" 
				response.write SubCategories("ID")
				response.write "&parentID=" 
				response.write SubCategories("ParentID") & "' title='" & SubCategories("CategoryName")
				response.write "'>" 
				response.write ChopString(trim(SubCategories("CategoryName"))) 
				
										
					if recordcount = ShowSubCatAmount then
					
						response.write "...</a>"
						
					else
					
						if recordcount = TheRecordCount then
							response.write "...</a>"
						else
							response.write "</a>, "
						end if
					
					end if
				
				SubCategories.MoveNext
				Loop
				
			end if
			
			'Set TheRecordCount = Nothing
			'SubCategories.Close
			
	
	else

response.write "<font class='sub_categories'>"

recordcount = 0
	
SubCategories.MoveFirst
 Do While NOT SubCategories.EOF	

recordcount = recordcount + 1	

	 if len(ID) = 0 then
			
		response.write "<a class='sub_categories' href='" & Path2Admin & "managecategories.asp?id=" 
		response.write SubCategories("ID") & "&parentID=" 
		response.write SubCategories("ParentID") & "' title='" & SubCategories("CategoryName") & "'>" 
		response.write ChopString(trim(SubCategories("CategoryName"))) 

	 elseif len(ID) <> 0 then
	
			if SubCategories("HitsTodayDate") <> Day(Now()) then 
			 SQL = "UPDATE del_Directory_Sites SET HitsToday = 0, HitsTodayDate = " & Day(Now()) 
			 SQL = SQL & " WHERE id = " & SubCategories("ID")
			 ConnObj.Execute(SQL) ' if we are displaying listing an not categories reset todays date
			end if
				
		response.write "<a href='" & Path2Directory & "redirect.asp?id=" & SubCategories("ID") 
		response.write "' target='_blank' title='" & SubCategories("Title") & "'>" 
		response.write ChopString(trim(SubCategories("Title")))
			
	end if
						
	if recordcount = ShowSubCatAmount then	
		response.write "...</a>"		
	else	
		if recordcount = TheRecordCount then
			response.write "...</a>"
		else
			response.write "</a>, "
		end if	
	end if

SubCategories.MoveNext
Loop
	
end if 

Set TheRecordCount = Nothing
SubCategories.Close

End Sub

'*****************************************************
' This sub creates the main top navigation and assign it all
' to the TopNavLinks variable for manipulation later
'*****************************************************

Sub ConstructTopNavigation (theID)

	Dim NewConnObj, SQL, CategoryTitle 

	if theID <> "" and theID <> "0" then
	
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
		
		TopNavLinks = "<a href='" & Path2Admin & "managecategories.asp'>Home</a>  "
	
	end if 
	
End Sub

'*************************************************
' This sub draws the domain name based on the full
' URL
'*************************************************

Sub DrawShortURL(strURL)
	
	Dim TheURL
	
	for i = 1 to len(strURL) step + 1
	
		if mid(strURL,i,1) = "/" and i > 7 then
		TheURL = left(strURL, i)
		exit for
		else
		TheURL = strURL
		end if
	next
	
	If right(TheURL,1) <> "/" then TheURL = TheURL & "/"
	
	response.write TheURL

End Sub

'*****************************************************
' This function returns true if listings are allowed within
' a category else it returns false
'*****************************************************

Function IsCategoryAllowedListings()

	Dim ConnObj, SQL, CheckAllowLinks

	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	
	if ID <> "" then	
		
		SQL = "SELECT AllowLinks FROM del_Directory_Categories WHERE ID = " & ID & " ORDER BY CategoryName"
		Set CheckAllowLinks = ConnObj.Execute(SQL)	
		
		if CheckAllowLinks.EOF or CheckAllowLinks.BOF then
		IsCategoryAllowedListings = False
		else
		IsCategoryAllowedListings = CheckAllowLinks("AllowLinks") 
		end if
		
	else	
		IsCategoryAllowedListings = False
	end if
	
	Set CheckAllowLinks = Nothing
	ConnObj.close
	
End Function

Sub UpdateComplete()

	With Response
		.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
		.write "<tr><td>"
		.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
		.write "<tr><td bgcolor='#F9F9F9'>"
		.write "<font class='warning_text'><b>Category Updated.</b></b></font>"
		.write "</td></tr></table>"
		.write "</td></tr></table><br>"
	End With
	
End Sub

Sub UpdateCatInfo(ID)
	
	Dim allowlinks, ConnObj, SQL
	
	If request.form("allowlinks") = "ON" then
	
		if DatabaseType = "Access" then 
			allowlinks = True
		else
			allowlinks = 1
		end if
		
	else
		
		if DatabaseType = "Access" then 
			allowlinks = false
		else
			allowlinks = 0
		end if
		
	end if

	SQL = "UPDATE del_Directory_Categories SET CategoryName = '" & CheckString(request.form("cattitle")) & "', "
	SQL = SQL & "AllowLinks = " & allowlinks & " WHERE ID = " & ID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)	
	ConnObj.Close

End Sub

Sub ShowModifyCategoryForm()

	Dim ConnObj, SQL, CategoryInfo, CategoryRecords

	SQL = "SELECT * FROM del_Directory_Categories WHERE ID = " & request.querystring("id")
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set CategoryInfo = ConnObj.Execute(SQL) 

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/help.gif' align='right' hspace='10'><font class='general_small_text'>Use the form below to modify this category within the directory. You can change the location of this category within the directory by selecting a different parent category below. When you move a category all associated category count information will be updated.</b></font>"
	response.write "</td></tr></table>"
	response.write "</td></tr></table><br>"

	With Response
	
	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form onSubmit='return checkForm(this)' action='managecategories.asp?action=updatecategory' method='POST' name='frmNewCategory'>"
	.write "<input type='hidden' value='" & request.querystring("id") & "' class='input' name='currentcategory' size='62'>"
	.write "<input type='hidden' value='" & request.querystring("parentid") & "' class='input' name='parentid' size='62'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Category Title:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & CategoryInfo("CategoryName") & "' class='input' name='cattitle' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Allow Links:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' name='allowlinks'" 
	if CategoryInfo("AllowLinks") = True or CategoryInfo("AllowLinks") = 1 then response.write " checked"
	.write "><font class='general_small_text'><i>"
	.write "(Tick to allow resource submissions within this category)</i></font></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9' valign='top'><font class='form_text'>Current Parent<br>Category:</font></td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<select name='category' class='display_cats' size='20'>"
			
			SQL = "SELECT ID FROM del_Directory_Categories ORDER BY ParentID, CategoryName"
			Set CategoryRecords = Server.CreateObject("ADODB.Recordset")
			CategoryRecords.CursorLocation = 3
			CategoryRecords.Open SQL, ConnObj
			
			if CategoryRecords.EOF then
				.write "<option value=''>No Categories Found</option>"
			else
			
				.write "<option value='0'"
				if request.querystring("parentID") = "0" then .write "selected"
				.write ">Root Category</option>"
				
			CategoryRecords.MoveFirst
			Do Until CategoryRecords.EOF
				
				if CategoryRecords("ID") <> cint(request.querystring("id")) then
				
					.write "<option value='" & CategoryRecords("ID") & "'"
					if CategoryRecords("ID") = cint(request.querystring("parentid")) then .write " selected"
					.write ">"
				
					i = 0
					ConstructCategories CategoryRecords("ID")
					.write TopNavLinks 
					.write "</option>"
					
				end if
			
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

	ConnObj.Close
	Set ConnObj = Nothing
	Set CategoryInfo = Nothing

End Sub

Sub ShowModifyCategoryNameForm()

Dim ConnObj, SQL, CategoryInfo

SQL = "SELECT * FROM del_Directory_Categories WHERE ID = " & request.querystring("id")
Set ConnObj = Server.CreateObject("ADODB.Connection")
ConnObj.Open MyConnStr	
Set CategoryInfo = ConnObj.Execute(SQL) 

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<img src='images/icons/help.gif' align='right' hspace='10'><font class='general_small_text'>Use the form below to modify the category name.</b></font>"
	response.write "</td></tr></table>"
	response.write "</td></tr></table><br>"

	With Response
	
	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form onSubmit='return checkForm(this)' action='managecategories.asp?action=updatecategoryname' method='POST' name='frmNewCategory'>"
	.write "<input type='hidden' value='" & request.querystring("id") & "' class='input' name='currentcategory' size='62'>"
	.write "<input type='hidden' value='" & request.querystring("parentid") & "' class='input' name='parentid' size='62'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Category Title:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='" & CategoryInfo("CategoryName") & "' class='input' name='cattitle' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Allow Links:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' name='allowlinks'" 
	if CategoryInfo("AllowLinks") = True or CategoryInfo("AllowLinks") = 1 then response.write " checked"
	.write "><font class='general_small_text'><i>"
	.write "(Tick to allow resource submissions within this category)</i></font></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Save Changes'> "
	.write "<input type='reset' class='form_buttons' onclick=""javascript:history.back(1)"" name='reset' value='Cancel'>"
	.write "</td></tr></table>"

	.write "</td></tr></table><br>"

	End With

ConnObj.Close
Set ConnObj = Nothing
Set CategoryInfo = Nothing

End Sub

Sub UpdateCatIDs(CatID)
	
	Dim ConnObj, SQL
	SQL = "UPDATE del_Directory_Categories SET ParentID = " & request.form("category") & " WHERE ID = " & CatID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)	
	ConnObj.Close

End Sub

Function ReturnNumberOfSitesForCategory(thecat)
	
	Dim ConnObj, SQL, TempRecords
	SQL = "SELECT ListingCount FROM del_Directory_Categories WHERE ID = " & thecat

	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TempRecords = ConnObj.Execute(SQL)

		if TempRecords.EOF Then
			ReturnNumberOfSitesForCategory = 0
		else
			ReturnNumberOfSitesForCategory = TempRecords("ListingCount")
		end if
	
	Set TempRecords = Nothing
	ConnObj.Close
	
End Function

Sub AddCategoryCounts (CatID)
	
	Dim ConnObj, SQL, TempRecords, NewListingCount
	
	SQL = "SELECT ParentID, ListingCount FROM del_Directory_Categories WHERE ID = " & CatID
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TempRecords = ConnObj.Execute(SQL)
	
	If TempRecords.EOF Then
	
	Else
			
		NewListingCount = TempRecords("ListingCount") + HowManyListings

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
			NewListingCount = TempRecords("ListingCount") - HowManyListings
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

Sub ConstructCategories (theID) 

			Dim NewConnObj, SQL, CategoryTitle
			
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

Sub ShowDelete()

	response.write "<table width='90%' align='center' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td align='center'>"
	response.write "<font class='warning_text'><b><img src='images/warning.gif' align='absmiddle'> WARNING:</font></b><br><br><font class='general_small_text'>You are about to delete the above category from the database.<br><br><b>Deleting this category will also delete ALL resources within the root of this category.</b><br><br>This will not delete sub categories of this category so please be sure to remove any sub categories first.<br><br>Are you sure you want to delete this category?<br><br><a href='managecategories.asp?action=dodelete&id=" & request.querystring("ID") & "&parentid=" & request.querystring("parentid") & "'><b>YES</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='javascript:history.back(1)'><b>NO</b></a></font>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub DeleteComplete()

	response.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	response.write "<tr><td>"
	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td bgcolor='#F9F9F9'>"
	response.write "<font class='warning_text'><b>Category Successfully Deleted.</b></b></font>"
	response.write "</td></tr></table>"
	response.write "</td></tr></table><br>"
	
End Sub

Sub DeleteCategory(catID)
	
	Dim ConnObj, SQL
		
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	
		SQL = "DELETE FROM del_Directory_Categories WHERE ID = " & catID ' delete category
		ConnObj.Execute(SQL)

		SQL = "DELETE FROM del_Directory_Sites WHERE CategoryID = " & catID ' delete related resources
		ConnObj.Execute(SQL)
	
	ConnObj.Close
	
End Sub

Sub ShowKey()
	

	Response.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	response.write "<tr><td class='general_small_text'>"
	response.Write "<center><img src='images/modifycatname.gif' align='absmiddle'> = Modify item, <img src='images/moveresource.gif' align='absmiddle'> = Modify or move item within the directory<br><img src='images/bin.gif' align='absmiddle'> = Delete item from the directory</center>"
	response.write "</td></tr></table>"
	
	
	
End Sub 
%>
