<!--#include file="../configuration_file.asp"-->
<% 

'*****************************************************
' Request global category ids to determine current category
'*****************************************************
	
	Dim ID, ParentID, I, NoCats, TitleText, ShowHomeLink
	Dim TempKeyword, CategoryToSearch, TypeOfSearch
	
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

Dim TopNavLinks ' variable containing top navigation

Sub ShowNavigation()

	With Response

		.write "<table width='100%' cellspacing='" & CellSpacing & "'" &_
		"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
		" bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"		
		.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
		.write "<tr>" 
		.write "<td bgcolor='" & CellBGColor & "' class='main_navigation'>"
		
		ShowHomeLink = True
	
		if id = "" and parentid = "" and Instr(lcase(request.servervariables("PATH_INFO")),"default.asp") or Instr(lcase(request.servervariables("PATH_INFO")),lcase(Path2Directory)) then
			.write "Welcome to " & DirectoryName
		else
			ConstructTopNavigation ID 
			.write TopNavLinks
		end if
	
		if Instr(1,lcase(request.servervariables("PATH_INFO")),"dir_explorer.asp") then
			.write " " & NavigationSep 
			.write " <a href='" & Request.ServerVariables("PATH_INFO") & "' class='main_navigation'>"
			.write "Directory Explorer</a>"
		elseif Instr(1,lcase(request.servervariables("PATH_INFO")),"reviews.asp") then
			.write " " & NavigationSep 
			.write " <a href='" & Request.ServerVariables("PATH_INFO") & "?" 
			.write Request.ServerVariables("QUERY_STRING") & "' class='main_navigation'>"
			.write "User Reviews</a>"
		elseif Instr(1,lcase(request.servervariables("PATH_INFO")),"favorites.asp") then
			.write " " & NavigationSep 
			.write " <a href='" & Request.ServerVariables("PATH_INFO") & "' class='main_navigation'>"
			.write "Your Favorites</a>"
		elseif Instr(1,lcase(request.servervariables("PATH_INFO")),"add.asp") then
			.write " " & NavigationSep 
			.write " <a href='" & Request.ServerVariables("PATH_INFO") & "?" 
			.write Request.ServerVariables("QUERY_STRING") & "' class='main_navigation'>"
			.write "Add Listing</a>"
		elseif Instr(1,lcase(request.servervariables("PATH_INFO")),"review.asp") then
			.write " " & NavigationSep 
			.write " <a href='" & Request.ServerVariables("PATH_INFO") & "?" 
			.write Request.ServerVariables("QUERY_STRING") & "' class='main_navigation'>"
			.write "Rate & Review</a>"
		elseif Instr(1,lcase(request.servervariables("PATH_INFO")),"newsletter.asp") then
			.write " " & NavigationSep 
			.write " <a href='" & Request.ServerVariables("PATH_INFO") & "' class='main_navigation'>"
			.write "Newsletter</a>"
		elseif Instr(1,lcase(request.servervariables("PATH_INFO")),"personalise.asp") then
			.write " " & NavigationSep 
			.write " <a href='" & Request.ServerVariables("PATH_INFO") & "' class='main_navigation'>"
			.write "Personalise This Site</a>"
		end if

		.write "</td></tr>"
		.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
		.write "</table>"
	
	End With

End Sub

'*****************************************************
' The ShowDirectory Sub contains all the code for writting
' the various categories to the screen
'*****************************************************

Sub ShowDirectory()

	Dim ConnObj, Records, SQL, Flag
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr

'*************************************************
' Display cateogry results depending on catID and parentID
'*************************************************
		
	if len(ID) = 0 AND len(ParentID) = 0 then ' Both ID and ParentID are empty so dislay top level categories
		SQL = "SELECT * FROM del_Directory_Categories WHERE ParentID = 0 ORDER BY CategoryName"
	else 
		SQL = "SELECT * FROM del_Directory_Categories WHERE ParentID = " & ID & " ORDER BY CategoryName"
	end if	

	if Debug = True then response.write SQL

	Set Records = ConnObj.Execute(SQL)	
	
	if Records.EOF then
	
		NoCats = True
		if IsCategoryAllowedListings then ' if resources are allowed within this category show then
			ShowListings ' show all listings for this category
		else
			response.write "<table width='100%'>" 
			ShowDirectoryKey ' if no listings allow just show the directory key
			response.write "</table>" 
		end if
		
	else 

 		Flag = True 
 		NoCats = False
 	
 		With Response
	
		.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
		"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
		"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>" & vbcrlf
	
 	Records.MoveFirst
  	 Do Until Records.EOF
	
		if Flag = True then .write "<tr>" ' if flag = true then start new row	
		
			.write "<td valign='top' width='50%'>"			 
			.write "<a class='category_head' href='default.asp?id=" & Records("ID")
			
				if Records("ParentID") <> 0 then 
					.write "&parentID=" & Records("ParentID") & "'>"
				else
					.write "'>"
				end if
				
			.write Records("CategoryName")
			.write "</a>"
			.write "<font class='category_count'>"
			.write " (" & Records("ListingCount") & ") "
			.write NewIcon(Records("LastUpdated")) 
			.write "</font><br>"
			
			ShowSubCategories Records("ID") ' create sub categories or listing under main category head
	
			.write "</td>"	
								
			if Flag = false then .write "</tr>"  & vbcrlf		
					
			if Flag = true then
				Flag = false
			elseif Flag = false then
				Flag = true
			end if
				
  	 Records.MoveNext
 	Loop
	
			if IsCategoryAllowedListings then ' if resources are allowed within this category show then
				ShowListings ' show all listings for this category
			  else
				ShowDirectoryKey ' if no listings allow just show the directory key
				.write "</table>" 
			end if
			
		End With

	end if
	
	ConnObj.Close 
	Set Records = Nothing
	Set ConnObj = Nothing
	

End Sub 

'*****************************************************
' The ShowResults Sub contains all the code for writting
' the various listings within a certain category
'*****************************************************

Sub ShowListings()

	Dim ConnObj, iPageCount, iPageCurrent, iPageSize, iResultCount, TheSet, Reviews, ReviewCount, GetOverallRating

	SQL = "SELECT * FROM del_Directory_Sites WHERE CategoryID = " & ID 
	
	if DatabaseType = "Access" then
	SQL = SQL & " AND PublishOnWeb = True"
	else
	SQL = SQL & " AND PublishOnWeb = 1"
	end if	
	
	' Set field to sort
	if request.querystring("order") = "" then
	SQL = SQL & " ORDER BY Sponsor ASC, Created DESC, Title" 
	elseif request.querystring("order") = "TIT" then
	SQL = SQL & " ORDER BY Title"
	elseif request.querystring("order") = "DES" then
	SQL = SQL & " ORDER BY Description"
	elseif request.querystring("order") = "CRE" then
	SQL = SQL & " ORDER BY del_Directory_Sites.Created"
	elseif request.querystring("order") = "LAC" then
	SQL = SQL & " ORDER BY del_Directory_Sites.LastAccessed"
	elseif request.querystring("order") = "HITDAY" then
	SQL = SQL & " ORDER BY HitsToday"
	elseif request.querystring("order") = "HITMON" then
	SQL = SQL & " ORDER BY HitsThisMonth"
	elseif request.querystring("order") = "HIT" then
	SQL = SQL & " ORDER BY Hits"
	end if	
	
	' Set Sort Order
	if request.querystring("sortorder") = "ASC" then
	SQL = SQL & " ASC"
	elseif request.querystring("sortorder") = "DESC" then
	SQL = SQL & " DESC"
	end if

	if Debug = True then response.write SQL

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
	
	Response.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
	"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
	"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"
		
	if TheSet.EOF or TheSet.BOF then ' no records found 
		
		response.write "<tr><td>"
		response.write "<font class='general_text'>"
		response.write "Sorry, there are currently no resources available within this category.<br><br>"
		response.write "<a class='general_text' href='" & Path2Directory & "add.asp?id=" & ID & "&parentID=" & ParentID & "'>"
		response.write "Be the first to add your resource to this category.</a>"
		response.write "</td>"
		response.write "</tr>"
		
		ShowDirectoryKey ' show directory key

	else ' we have a result 
	
		If 1 > iPageCurrent Then iPageCurrent = 1
		If iPageCurrent > iPageCount Then iPageCurrent = iPageCount
		TheSet.AbsolutePage = iPageCurrent
		iResultCount = (iPageSize * (iPageCurrent - 1)) + 1
	
	if NoCats = False then response.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
	
	response.write "<tr><td>"
	
	' draw how many pages where found and sort combo boxes
		
		response.write "<table cellspacing='0' cellpadding='0' width='100%'>"
		response.write "<tr><form><td>"
		response.write "<font class='page_results_count'>"
		response.write "Page " & iPageCurrent & " of " & iPageCount & " - " & TheSet.RecordCount 
		response.write " results found</font>"
		response.write "</td><td align='right'>"
	
		response.write "<select name='order' onchange=""javascript:if (this.value != '') {self.location = '" 
		response.write "default.asp?page=" &_
		iPageCurrent & "&order=' + this.value + '&sortorder=' + sort.value + '&id=" & ID & "&parentID=" 
		response.write ParentID & "';}"">"
			
		response.write "<option value=''" 
		if request.querystring("order") = "" then response.write "selected" 
		response.write ">Sort...</option>"
		response.write "<option value='TIT'"
		if request.querystring("order") = "TIT" then response.write "selected" 
		response.write ">Sort : Title</option>"
		response.write "<option value='DES'"
		if request.querystring("order") = "DES" then response.write "selected" 
		response.write ">Sort : Description</option>"
		response.write "<option value='CRE'"
		if request.querystring("order") = "CRE" then response.write "selected" 
		response.write ">Sort : Created Date</option>"
		response.write "<option value='LAC'" 
		if request.querystring("order") = "LAC" then response.write "selected" 
		response.write ">Sort : Last Visit</option>"
		response.write "<option value='HITDAY'"
		if request.querystring("order") = "HITDAY" then response.write "selected" 
		response.write ">Sort : Hits Today</option>"
		response.write "<option value='HITMON'"
		if request.querystring("order") = "HITMON" then response.write "selected"
		response.write ">Sort : Hits This Month</option>"
		response.write "<option value='HIT'"
		if request.querystring("order") = "HIT" then response.write "selected" 
		response.write ">Sort : Overall Hits</option>"
		response.write "</select>"
		
		response.write "<select name='sort' onchange=""javascript:self.location = '" 
		response.write "default.asp?page=" &_
		iPageCurrent & "&order=' + order.value + '&sortorder=' + this.value + '&id=" 
		response.write ID & "&parentID=" & ParentID & "';"">"		
		response.write "<option value='ASC'"
		if request.querystring("sortorder") = "ASC" then response.write "selected" 
		response.write ">Ascending Order</option>"
		response.write "<option value='DESC'"
		if request.querystring("sortorder") = "DESC" then response.write "selected" 
		response.write ">Descending Order</option>"
		response.write "</select>"
		response.write "</td></form></tr></table>"
		
	response.write "</td></tr>"
	
	Do While TheSet.AbsolutePage = iPageCurrent And Not TheSet.EOF 

	response.write "<tr><td valign='top' bgcolor='" & CellBGColor & "'>"
	
	response.write "<table width='100%' cellpadding='0' cellspacing='0'>"
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
		response.write " <img src='" & Path2Directory & "images/fav.gif' alt='Favorite' align='absbottom'> "
		else
		response.write " "
		end if

		response.write NewIcon(TheSet("Created")) 
		
		response.write "</td><td class='listing_head' align='right'>"
		
			response.write "<img src='" & Path2Directory & "images/rating.gif'>&nbsp;&nbsp;"
	
			SQL = "SELECT * FROM del_Directory_Reviews WHERE SiteID = " & TheSet("ID") & " AND "
			
				if DatabaseType = "Access" then 
					SQL = SQL & "PublishOnWeb = True"
				else
					SQL = SQL & "PublishOnWeb = 1"
				end if
				
			if Debug = True then response.write NewSQL
			
			Set Reviews = Server.CreateObject("ADODB.Recordset")
			Reviews.CursorLocation = 3 
			Reviews.Open SQL, ConnObj
			ReviewCount = Reviews.RecordCount
					
			if Reviews.EOF OR Reviews.BOF then
			
				response.write "<img src='" & Path2Directory & "images/staroff.gif'>&nbsp;"
				response.write "<img src='" & Path2Directory & "images/staroff.gif'>&nbsp;"
				response.write "<img src='" & Path2Directory & "images/staroff.gif'>&nbsp;"
				response.write "<img src='" & Path2Directory & "images/staroff.gif'>&nbsp;"
				response.write "<img src='" & Path2Directory & "images/staroff.gif'>&nbsp;"
			
			else
			
				Reviews.MoveFirst
				 Do While Not Reviews.EOF
				 
				 	GetOverallRating = GetOverallRating & Reviews("Rated") & ","
				 
				 Reviews.MoveNext		
				 Loop

				response.write DisplayRating(GetOverallRating)								
				GetOverallRating = "" ' reset overall rating
			
			end if
			
			Reviews.Close
			Set Reviews = Nothing

		response.write "</td></tr></table>"

	response.write "</td></tr>"
	
	response.write "<tr><td>"
	
		response.write "<table width='100%' cellpadding='0' cellspacing='0'><tr><td>"
		
		' draw created and last visited date
		
		response.write "<font class='created_date'>"
		response.write "Created: " & FormatDateTime(TheSet("Created"),2) & ", " 
		response.write "Last Visit: " & FormatDateTime(TheSet("LastAccessed"),2)
		response.write "</font>"
		
		response.write "</td>"		
		response.write "<td>"
		
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
		response.write "Month: " & TheSet("HitsThisMonth") & ", " 
		response.write "Overall: " & TheSet("Hits")
		response.write "</font>"
		
		response.write "</td>"

		response.write "<td class='rate_review' align='right' valign='middle'>"
		response.write "<a class='rate_review' href='" & Path2Directory & "review.asp?siteID="
		response.write TheSet("ID") & "&id=" 
		response.write ID & "&parentID=" & ParentID & "'>Rate & Review</a>"
		response.write " <font class='rate_review'>|</font> " 
		if ReviewCount = 0 then
			response.write "<font class='rate_review'>"
			response.write ReviewCount & " Reviews" 
			response.write "</font>"
		elseif ReviewCount = 1 then
			response.write "<a class='rate_review' href='" & Path2Directory & "reviews.asp?siteID=" 
			response.write TheSet("ID") & "&id=" & ID 
			response.write "&parentID=" & ParentID & "'>" & ReviewCount & " Review</a>" 
		else
			response.write "<a class='rate_review' href='" & Path2Directory & "reviews.asp?siteID=" 
			response.write TheSet("ID") & "&id=" & ID 
			response.write "&parentID=" & ParentID & "'>" & ReviewCount & " Reviews</a>"
		end if 

		response.write "</td></tr></table>"
		
	response.write "</td></tr>"
	
	response.write "<tr><td>"
	
	' draw description
	
	response.write "<font class='listing_description'>"
	if TheSet("Description") <> "" then response.write TheSet("Description")  
	response.write "</font>"
	
	' draw report error and bookmark links
	
	response.write "<br><br>"
	
	response.write "<table width='100%' cellspacing='0'><tr><td>"
	response.write "<font class='short_listing_url'>"
	response.write "<a href='" & Path2Directory & "redirect.asp?id=" & TheSet("ID") & "' class='short_listing_url' target='_blank'>" 
	DrawShortURL TheSet("URL")
	response.write "</a>"
	response.write "</font>"
	response.write "</td>"
	
	response.write "<td class='bookmark_resource' align='right'>"
		
	if request.querystring("ex") <> "true" then ' if not content feed then display...
		response.write "<a class='bookmark_resource' href='" & Path2Directory & "search.asp?keyword=" 
		response.write server.URLEncode(TheSet("Title")) & "&type=ANY'>"
		response.write "Related Resources</a>"
		response.write " <font class='bookmark_resource'>|</font> "	
		response.write "<a class='bookmark_resource' href=""javascript:WindowOpen('" & Path2Directory & "bookmark.asp?id=" 
		response.write TheSet("ID") & "&popup=true','750','275',0)"""
		response.write "title='opens in new window...'>Add to Favorites</a>"
		response.write " | "
		response.write "<a class='report_error' href=""javascript:WindowOpen('" & Path2Directory & "error.asp?siteID="
		response.write TheSet("ID") & "&popup=true','750','450',1)"" title='opens in new window...'>Report Error</a>"
	end if
	
	response.write "</td></tr></table>"


	response.write "</td></tr>"
	
	iResultCount = iResultCount + 1			
	
		TheSet.MoveNext		
		Loop

	
	response.write "<tr>"
	response.write "<td valign='top'>"	
	
		response.write "<table width='100%' border='0' cellpadding='0' cellspacing='0'>"
		response.write "<tr><td width='20%' class='paging_links' align='left'>"
		
		If iPageCurrent > 1 Then
		
			 response.write "&#171;&nbsp;<a class='paging_links' href='default.asp?page=" 
			 response.write iPageCurrent - 1 
			 response.write "&order=" & request.querystring("order")
			 response.write "&sortorder=" & request.querystring("sortorder") & "&id=" & ID & "&parentID=" 
			 response.write ParentID & "'>Previous Page</a>"	
			 
		end if
		
		response.write "</td>"
		response.write "<td width='60%' class='paging_links' align='center'>"	
				
			dim intStart, intEnd
			
			if iPageCount <> 1 then
			
			if iPageCurrent <= intPGCount Then
    			intStart = 1
    		Else
    			If (iPageCurrent Mod intPGCount) = 0 Then
    				intStart = iPageCurrent - intPGCountMinus 
    			Else
    				intStart = iPageCurrent - (iPageCurrent Mod intPGCount) + 1
    			End if
    		End if
			
			intEnd = intStart + intPGCountMinus 
			
    		if intEnd > iPageCount  Then intEnd = iPageCount 

				for i = intStart to intEnd
				
					if i = intStart and i <> 1 then response.write "...&nbsp;&nbsp"
		
						if i = iPageCurrent then
							response.write "<font class='paging_links'>[ " & i & " ]</font>"
						else
							response.write "<a class='paging_links' href='default.asp?page=" & i 
							response.write "&order=" & request.querystring("order") 
							response.write "&sortorder=" & request.querystring("sortorder") & "&id=" & ID 
							response.write "&parentID=" & ParentID & "'>" & i & "</a>"
						end if
	    	
					if i <> intEnd then 
						response.write "&nbsp;&nbsp;"
					else
					
						if i <> iPageCount then response.write "&nbsp;..."
							
					end if
					
				next
		
			end if
		
		response.write "</td>"
		response.write "<td width='20%' class='paging_links' align='right'>"
		
		If iPageCurrent <> iPageCount Then
	
			response.write "<a class='paging_links' href='default.asp?page=" 
			response.write iPageCurrent + 1 
			response.write "&order=" & request.querystring("order")
			response.write "&sortorder=" & request.querystring("sortorder") & "&id=" & ID & "&parentID="
			response.write ParentID & "'>Next Page</a>&nbsp;&#187;"
		
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
	
	With Response
		.write "<tr><td colspan='2' align='center'>"
		.write "<font class='directory_key'>"
		.write "<img src='" & Path2Directory & "images/new1.gif' border='0' width='25' height='16' align='absbottom'> within last 4 days, "
		.write "<img src='" & Path2Directory & "images/new2.gif' border='0' width='25' height='16' align='absbottom'> within last 8 days, "
		.write "<img src='" & Path2Directory & "images/new3.gif' border='0' width='25' height='16' align='absbottom'> within last 12 days.<br>"
		.write "<img src='" & Path2Directory & "images/sponsor.gif' border='0' width='16' height='16' align='absbottom'> = " & DirectoryName & " Sponsor, "
		.write "<img src='" & Path2Directory & "images/fav.gif' border='0' width='16' height='14' align='absbottom'> = " & DirectoryName & " Favorite."
		.write "</font><br><br>"
		.write "</td></tr>"
	End With

End Sub

'*****************************************************
' The ChopString function is used to truncate any 
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

	Dim ConnObj, SubCategories, TheRecordCount, adOpenDynamic, recordcount

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
		SQL = SQL & "PublishOnWeb = TRUE ORDER BY Title"
	  else
		SQL = SQL & "PublishOnWeb = 1 ORDER BY Title"
	  end if
	  
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
			
			if SubCategories.EOF then	
			else
						
				response.write "<font class='sub_categories'>"
	
				recordcount = 0
					
				SubCategories.MoveFirst
				
				Do While NOT SubCategories.EOF	
				
				recordcount = recordcount + 1
				
					response.write "<a class='sub_categories' href='default.asp?id=" 
					response.write SubCategories("ID")
					response.write "&parentID=" 
					response.write SubCategories("ParentID") & "' title='" & SubCategories("CategoryName")
					response.write "' class='sub_categories'>" 
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
			
		response.write "<a class='sub_categories' href='default.asp?id=" 
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
		response.write "' target='_blank' title='" & SubCategories("Title") & "' class='sub_categories'>" 
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

'*************************************************
' Return the mean number of all the reviews and round off
'*************************************************

Function DisplayRating (DelimitedRatings)

'on error resume next

	dim Total, Average, ReviewCount

			DelimitedRatings = left(DelimitedRatings,len(DelimitedRatings) - 1) ' remove last comma
			DelimitedRatings = split(DelimitedRatings,",") ' split into 1d array
			
			for i = lbound(DelimitedRatings) to ubound(DelimitedRatings)
				Total = Total + cint(DelimitedRatings(i)) ' calculate total
			next
			
			ReviewCount = ubound(DelimitedRatings) + 1
			
			if ubound(DelimitedRatings) > 0 then 
				Average = cint(Total / ReviewCount) ' divide total by count of reviews
			else
				Average = Total
			end if
	
			DisplayRating = DisplayStars(round(Average)) ' round number and call sub to draw stars
			
End Function

Function DisplayStars (TotalRating)

	if TotalRating = 1 then ' half a star
	DisplayStars = "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif TotalRating = 2 then ' 1 star
	DisplayStars = "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif TotalRating = 3 then ' 1 and a half stars
	DisplayStars = "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif TotalRating = 4 then ' 1 and a half stars
	DisplayStars = "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staroff.gif' align='absmiddle'>"
	elseif TotalRating = 5 then ' 1 and a half stars
	DisplayStars = "<img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'> <img src='" & Path2Directory & "images/staron.gif' align='absmiddle'>"
	end if
	
End Function

'*****************************************************
' This sub creates the main top navigation and assign it all
' to the TopNavLinks variable for manipulation later
'*****************************************************

Sub ConstructTopNavigation (theID) 

	Dim ConnObj, SQL, CategoryTitleRecords

	if theID <> "" then
	
		if i = 0  then
		
			if ShowHomeLink = False then
				TopNavLinks = ""
			else
				TopNavLinks = "<a class='main_navigation' href='default.asp'>Home</a> " & NavigationSep & " "
			end if
			
		else
		
			if ShowHomeLink = False then TopNavLinks = ""
			
		end if
				
			Set ConnObj = Server.CreateObject("ADODB.Connection")
			ConnObj.Open MyConnStr
			SQL = "SELECT ID, CategoryName, ParentID FROM del_Directory_Categories WHERE ID = " & theID 
			if Debug = True then response.write SQL
			Set CategoryTitleRecords = ConnObj.Execute(SQL) 
				
			If CategoryTitleRecords.EOF then
			
				TopNavLinks = "<b>No Category Found</b>"
			
			else		
					
				i = i + 1
				
				if CategoryTitleRecords("ParentID") <> 0 then ConstructTopNavigation CategoryTitleRecords("ParentID")
							
				if CategoryTitleRecords("ParentID") <> 0 then TopNavLinks = TopNavLinks & " " &  NavigationSep & " "
						
				TopNavLinks = TopNavLinks & "<a class='main_navigation' href='default.asp?id=" & CategoryTitleRecords("ID")
			
				if CategoryTitleRecords("ParentID") <> 0 then 
					TopNavLinks = TopNavLinks & "&parentID=" & CategoryTitleRecords("ParentID") & "'>"
				else
					TopNavLinks = TopNavLinks & "'>"
				end if		
			
				TopNavLinks = TopNavLinks & CategoryTitleRecords("CategoryName") & "</a>"				

			end if
			
			ConnObj.Close
			Set ConnObj = Nothing
			Set CategoryTitleRecords = Nothing
			
	else
		
				TopNavLinks = "<a class='main_navigation' href='" & Path2Directory & "default.asp'>Home</a> "
	
	end if 
	
End Sub

'*****************************************************
' This will draw 1 listing to the screen based on the ID
' Used for review pages, bookmark and report error pages
'*****************************************************

Sub DrawSelectedResource(ResourceID)

Dim ConnObj, SQL, Records, tblWidth, Reviews, ReviewCount, GetOverallRating

	SQL = "SELECT * FROM del_Directory_Sites WHERE del_Directory_Sites.ID = " & ResourceID & " AND "
	
		If DatabaseType = "Access" then
			SQL = SQL & "PublishOnWeb = True"
		else
			SQL = SQL & "PublishOnWeb = 1"
		end if 
	
	
	if Debug = True then response.write SQL

	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr 
	Set Records = ConnObj.Execute(SQL)
	
	With Response

	If Records.EOF then
		
		.write "<font class='general_text'>"
		.write "No selected Resource"
		.write "</font>"
		
	else

		if Instr(1,lcase(request.servervariables("PATH_INFO")),"bookmark.asp") then
			tblWidth = "100%" 
		elseif Instr(1,lcase(request.servervariables("PATH_INFO")),"error.asp") then
			tblWidth = "100%"
		else
			tblWidth = "97%"
		end if	
		
		.write "<table width='" & tblWidth & "' align='center' bgcolor='" & CellSpilt & "' cellpadding='1' cellspacing='0'><tr><td>"
		
		.write "<table width='100%' cellspacing='" & CellSpacing & "'" &_
		"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
		"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"
		.write "<tr><td bgcolor='" & CellBGColor & "'>"
		
		' draw resource link
		
		.write "<table width='100%' cellpadding='0' cellspacing='0'><tr><td>"
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
				.write " <img src='" & Path2Directory & "images/sponsor.gif' width='16' height='16' alt='Sponsor' align='absmiddle'> "
			else
				.write " "
			end if

			if Records("Favorite") = true then
				.write "<img src='" & Path2Directory & "images/fav.gif' width='16' height='14' alt='Favorite' align='absbottom'> "
			else
				.write " "
			end if

		.write NewIcon(Records("Created")) 
		
		.write "</td><td bgcolor='" & CellBGColor & "' align='right'>"
		
			' get overall rating
	
			.write "<img src='" & Path2Directory & "images/rating.gif'>&nbsp;&nbsp;"
	
			SQL = "SELECT * FROM del_Directory_Reviews WHERE SiteID = " & Records("ID") & " AND "
			
			If DatabaseType = "Access" then
				SQL = SQL & "PublishOnWeb = True"
			else
				SQL = SQL & "PublishOnWeb = 1"
			end if 
	
			Set Reviews = Server.CreateObject("ADODB.Recordset")
			Reviews.CursorLocation = 3 
			Reviews.Open SQL, ConnObj
			ReviewCount = Reviews.RecordCount
					
			if Reviews.EOF OR Reviews.BOF then
			
				.write "<img src='" & Path2Directory & "images/staroff.gif'> "
				.write "<img src='" & Path2Directory & "images/staroff.gif'> "
				.write "<img src='" & Path2Directory & "images/staroff.gif'> "
				.write "<img src='" & Path2Directory & "images/staroff.gif'> "
				.write "<img src='" & Path2Directory & "images/staroff.gif'> "
				
			else
			
				Reviews.MoveFirst
				 Do While Not Reviews.EOF
				 
				 	GetOverallRating = GetOverallRating & Reviews("Rated") & ","
				 
				 Reviews.MoveNext		
				 Loop

				response.write DisplayRating(GetOverallRating)								
				GetOverallRating = "" ' reset overall rating
			
			end if
			
		Set Reviews = Nothing
		
		.write "</td></tr></table>"

	.write "</td></tr>"	

	.write "<tr><td bgcolor='#ffffff'>"
	
		' draw created and last visited date
		
		.write "<table width='100%' cellpadding='0' cellspacing='0'><tr><td>"
		
			.write "<font class='created_date'>"
			.write "Created: " & FormatDateTime(Records("Created"),2) & ", " 
			.write "Last Visit: " & FormatDateTime(Records("LastAccessed"),2)
			.write "</font>"
		
		.write "</td>"		
		.write "<td "
		
		if request.querystring("popup") = "true" then response.write "align='right' "
		response.write "bgcolor='#ffffff'>"
		
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
			.write "Month: " & Records("HitsThisMonth") & ", " 
			.write "Overall: " & Records("Hits")
			.write "</font>"
			
		.write "</td>"
		
	if request.querystring("popup") <> "true" then
		
		.write "<td class='rate_review' bgcolor='#ffffff' align='right'>"
		.write "<a class='rate_review' href='" & Path2Directory & "review.asp?siteID=" & Records("ID") 
		.write "&id="
		.write ID & "&parentid=" & parentID & "'>"
		.write "Rate & Review</a> "
		.write "<font class='rate_review'>|</font> " 
		
			if ReviewCount = 0 then
				.write "<font class='rate_review'>"
				.write ReviewCount & " Reviews" 
				.write "</font>"
			elseif ReviewCount = 1 then
				.write "<a class='rate_review' href='" & Path2Directory & "reviews.asp?siteID="
				.write Records("ID") & "&id="
				.write ID & "&parentid=" & parentID & "'>"
				.write ReviewCount & " Review</a>" 
			else
				.write "<a class='rate_review' href='" & Path2Directory & "reviews.asp?siteID=" 
				.write Records("ID") & "&id="
				.write ID & "&parentid=" & parentID & "'>"
				.write ReviewCount & " Reviews</a>"
			end if 
		
		.write "</td>"
		
	else
	
		.write "<td bgcolor='#ffffff'>&nbsp;</td>"

	End If
	
		.write "</tr></table>"
				
	.write "</tr>"
	
	.write "<tr><td bgcolor='#ffffff'>"
	
	' draw description
	
	.write "<font class='listing_description'>"
		if Records("Description") <> "" then .write Records("Description")  
	.write "</font>"
	
	' draw report error and bookmark links
	
	.write "<br><br>"
	.write "<table width='100%' cellspacing='0'><tr><td>"
	.write "<font class='short_listing_url'>"
	.write "<a href='" & Path2Directory & "redirect.asp?id=" & Records("ID") & "' target='_blank' class='short_listing_url'>" 
	DrawShortURL Records("URL")
	.write "</a>"
	.write "</font>"
	.write "</td>"
	
	if request.querystring("popup") <> "true" then
	
		.write "<td align='right'>"
		.write "<a class='bookmark_resource' href='search.asp?keyword=" 
		.write server.URLEncode(Records("Title")) & "&type=ANY'>"
		.write "Related Resources</a>"
		.write " <font class='bookmark_resource'>|</font> "	
		.write "<a class='bookmark_resource' href=""javascript:WindowOpen('" & Path2Directory & "bookmark.asp?id=" 
		.write Records("ID") & "&popup=true','750','275',0)"""
		.write "title='opens in new window...'>Add to Favorites</a>"
		.write " <font class='bookmark_resource'>|</font> "
		.write "<a class='report_error' href=""javascript:WindowOpen('" & Path2Directory & "error.asp?siteID="
		.write Records("ID") & "&popup=true','750','450',1)"" title='opens in new window...'>Report Error</a>"
		.write "</td>"
		
	end if
	
	.write "</tr></table>"

	.write "</td></tr></table>"	
	.write "</td></tr></table>"

End If

	End With

ConnObj.Close
Set ConnObj = Nothing
Set Records = Nothing


End Sub

'*****************************************************
' This function returns true if listings are allowed within
' a category else it returns false
'*****************************************************

Function IsCategoryAllowedListings()

	Dim ConnObj, CheckAllowLinks

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

'*****************************************************
' This sub draws the search form to the screen
'*****************************************************

Sub ShowSearchOptions()

	With Response
	
		.write "<table width='100%' cellspacing='" & CellSpacing & "' " &_
		"cellpadding='" & CellPadding & "'>"
		.write "<form name='frmSearch' onSubmit='return checkSearch(this)' action='" & Path2Directory & "search.asp' method='post'>"
		.write "<tr><td class='general_page_header' align='right'>"
    
		.write "<i>Search :</i> <input type='text' value=""" 
		
		if TempKeyword = "" then
		.write "Search Directory"
		else
		.write TempKeyword
		end if
		
		.write """ size='28' name='keyword' class='search_input'> "
	
	
		.write "<select class='search_combo' name='category'>"
		.write "<option value='ALL'"	
		if CategoryToSearch = "ALL" then .write " selected"
		.write ">All Categories</option>"

				if IsCategoryAllowedListings then
					.write "<option value='" & id & "'>This Category</option>"
				end if
				
		.write "</select> "
	
		.write "<select class='search_combo' name='type'>"
		.write "<option value='ALL'"
		If TypeOfSearch = "ALL" then .write " selected"
		.write ">All Words</option>"
		.write "<option value='ANY'"
		If TypeOfSearch = "ANY" or TypeOfSearch = "" then .write " selected"
		.write ">Any Words</option>"
		.write "<option value='EX'"
		If TypeOfSearch = "EX" then .write " selected"
		.write ">Exact Match</option>"
		.write "</select>"
		.write " <input type='image' border='0' src='images/go.gif' width='26' height='20' align='absmiddle'>"
			 
		.write "</td></tr>"
		.write "</form>"
		.write "</table>"
		
	End With
	
End Sub

'*************************************************
' Make strings SQL friendly
'*************************************************

Function CheckString(strInput)
	
	Dim strTemp
	strTemp = Replace(strInput, "'", "''")
	strTemp = Replace(strTemp, vbcrlf, "")
	CheckString = strTemp
	
End Function

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

'*************************************************
' This sub draws the last 10 listing additions to the directory
'*************************************************

Sub ShowLatestAdditions()

	Dim ConnObj, SQL, Records, ResourceCount

	SQL = "SELECT ID, Title, CategoryID, Description, Sponsor, Favorite, Created "
	SQL = SQL & " FROM del_Directory_Sites WHERE "
	
	if DatabaseType = "Access" then
		SQL = SQL & "del_Directory_Sites.PublishOnWeb = True"
	else
		SQL = SQL & "del_Directory_Sites.PublishOnWeb = 1"
	end if
	
	SQL = SQL & " ORDER BY del_Directory_Sites.Created DESC"

	If Debug = True then response.write SQL

	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	Set Records = ConnObj.Execute(SQL)
	
	With Response
	
		.write "<table width='100%' cellspacing='" & CellSpacing & "'" &_
		"cellpadding='" & CellPadding & "'>"		
		.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
		.write "<tr>" 
		.write "<td bgcolor='" & CellBGColor & "' class='main_navigation'>"
		.Write "Latest Additions"
		.Write "</td></tr>"
		.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
		.Write "</table><br>"
		
	Response.write "<table width='100%' cellspacing='0' cellpadding='0' Border='0'>"	

	If Records.EOF or Records.BOF then
		.write "<tr><td bgcolor='#ffffff'>"	
		.write "<font class='general_text'>"
		.write "No resources found"
		.write "</font>"
		.write "</td></td>"
	else
	
		Records.MoveFirst
		 ResourceCount = 1
		  Do While ResourceCount < HowManyNewLinksToShow And Not Records.EOF 
		  
			.write "<tr><td bgcolor='#ffffff' class='frontpage_links'>"
			.write "&#149;&nbsp;<a class='frontpage_links' href='" & Path2Directory & "redirect.asp?id=" 
			.write Records("ID") & "' title='" 
			.write Records("Title") & "' target='_blank'>"
		
				If len(Records("Title")) >= 60 then
					.write left(Records("Title"),60) & "..."
				else
					.write Records("Title") 
				end if
			
			.write "</a> "
			
			GenerateCategoryURL Records("CategoryID")
	
		if Records("Sponsor") = true then
			.write "<img src='" & Path2Directory & "images/sponsor.gif' alt='Sponsor' width='16' height='16' align='absmiddle'> "
		else
			.write " "
		end if

		if Records("Favorite") = true then
			.write "<img src='" & Path2Directory & "images/fav.gif' alt='Favorite' width='16' height='14' align='absbottom'> "
		else
			.write " "
		end if
			
			.write "<i>"

			if formatdatetime(Records("Created"),2) = shortdate then			
				.write "<font class='general_small_text_red'>(TODAY)"
			else 			
				.write "<font class='general_small_text'>(" & Day(Records("Created")) & "/" & Month(Records("Created")) & ")"
			end if
			
			.write "</i>"
			.write "</font><br>"
			
			.write "<font class='listing_description'>"
			.write Records("Description") & "<br>"
			
			if ResourceCount <> HowManyNewLinksToShow -1 then .write "<br>" 
			
			.write "</font>"
			
			.write "</td></tr>"
			
		  ResourceCount = ResourceCount + 1
		 Records.MoveNext
		Loop

	End If
	
	.write "</table>"
	
	End With

	ConnObj.Close
	Set ConnObj = Nothing
	Set Records = Nothing


End Sub

Sub ShowFavorites()

	Dim ConnObj, SQL, Records, ResourceCount

	SQL = "SELECT ID, Title, CategoryID, Sponsor, Favorite, Created "
	SQL = SQL & " FROM del_Directory_Sites WHERE "
	
	if DatabaseType = "Access" then
		SQL = SQL & "del_Directory_Sites.PublishOnWeb = True AND Favorite = True"
	else
		SQL = SQL & "del_Directory_Sites.PublishOnWeb = 1 AND Favorite = 1"
	end if
	
	SQL = SQL & " ORDER BY del_Directory_Sites.Created DESC"

	If Debug = True then response.write SQL

	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	Set Records = ConnObj.Execute(SQL)
	
	With Response
	
	.write "<table width='100%' cellpadding='0' bgcolor='#ffffff' cellspacing='0'><tr><td>"
	
		If Records.EOF or Records.BOF then		
			.write "<font class='general_text'>"
			.write "No favorite resources found."
			.write "</font>"
		else
	
		Records.MoveFirst
		 ResourceCount = 1
		 
		  Do While ResourceCount < NoOfFavoritesToShow And Not Records.EOF 
		  
			.write "<font class='general_text'>&#149;&nbsp;&nbsp;</font>"
			.write "<a class='frontpage_links' href='" & Path2Directory & "redirect.asp?id=" 
			.write Records("ID") & "' title='" 
			.write Records("Title") & "' target='_blank'>"
		
				If len(Records("Title")) >= 24 then
					.write left(Records("Title"),24) & "..."
				else
					.write Records("Title") 
				end if
			
			.write "</a> "
			
			GenerateCategoryURL Records("CategoryID")
	
			if Records("Sponsor") = true then
				.write " <img src='" & Path2Directory & "images/sponsor.gif' width='16' height='16' alt='Sponsor' align='absmiddle'> "
			else
				.write " "
			end if

			if Records("Favorite") = true then
				.write "<img src='" & Path2Directory & "images/fav.gif' width='16' height='14' alt='Favorite' align='absbottom'> "
			else
				.write " "
			end if
			
			.write "<font class='general_small_text'><i>"
			.write "(" & Day(Records("Created")) & "/" & Month(Records("Created")) & ")"
			.write "</i></font>"
			.write "<br>"
		
		  ResourceCount = ResourceCount + 1
		 Records.MoveNext
		 
		Loop
	
	End If
	
	.write "</td></tr></table>"
	
	End With
	
ConnObj.Close
Set Records = Nothing
Set ConnObj = Nothing


End Sub

Sub ShowWhatsHot()

Dim ConnObj, SQL, Records, ResourceCount

	SQL = "SELECT ID, Title, CategoryID, Description, Sponsor, Favorite, Created "
	SQL = SQL & "FROM del_Directory_Sites WHERE "
	
	if DatabaseType = "Access" then
		SQL = SQL & "del_Directory_Sites.PublishOnWeb = True"
	else
		SQL = SQL & "del_Directory_Sites.PublishOnWeb = 1"
	end if
	
	SQL = SQL & " ORDER BY HitsToday DESC"
	
	If Debug = True then response.write SQL
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set Records = ConnObj.Execute(SQL)
	
	With Response

	.write "<table width='100%' cellspacing='0' cellpadding='0'>"
	.write "<tr><td bgcolor='#ffffff'>"		
	.write "<font class='general_text'><b>Today...</b></font><br><br>"

	If Records.EOF or Records.BOF then
		.write "<font class='general_text'>"
		.write "No resources found<br>"
		.write "</font>"
	else
	
		Records.MoveFirst
		 ResourceCount = 1
		 
		  Do While ResourceCount < HowManyPopularLinksToShow And Not Records.EOF
				 
			.write "<font class='general_text'>" & ResourceCount & ". </font>"
			.write "<a class='frontpage_links' href='" & Path2Directory & "redirect.asp?id=" 
			.write Records("ID") & "' title='" 
			.write Records("Title") & "' target='_blank'>"
		
				If len(Records("Title")) >= 26 then
					.write left(Records("Title"),26) & "..."
				else
					.write Records("Title") 
				end if
			
			.write "</a> "
			
			GenerateCategoryURL Records("CategoryID")
	
		if Records("Sponsor") = true then
			.write " <img src='" & Path2Directory & "images/sponsor.gif' alt='Sponsor' width='16' height='16' align='absmiddle'> "
		else
			.write " "
		end if

		if Records("Favorite") = true then
			.write "<img src='" & Path2Directory & "images/fav.gif' alt='Favorite' width='16' height='14' align='absbottom'> "
		else
			.write " "
		end if
	
			.write NewIcon(Records("Created")) & "<br>" 
					
		  ResourceCount = ResourceCount + 1
		 Records.MoveNext
		 
		Loop
	
	End If
	
	SQL = "SELECT ID, Title, CategoryID, Description, Sponsor, Favorite, Created "
	SQL = SQL & "FROM del_Directory_Sites WHERE "

	if DatabaseType = "Access" then
		SQL = SQL & "del_Directory_Sites.PublishOnWeb = True"
	else
		SQL = SQL & "del_Directory_Sites.PublishOnWeb = 1"
	end if
	
	SQL = SQL & " ORDER BY HitsThisMonth DESC"
	
	If Debug = True then response.write SQL
	
	Set Records = ConnObj.Execute(SQL)

	.write "<br><font class='general_text'><b>This month...</b></font><br><br>"
	
	If Records.EOF or Records.BOF then
		.write "<font class='general_text'>"
		.write "No resources found"
		.write "</font>"
	else
	
		Records.MoveFirst
		 ResourceCount = 1
		  Do While ResourceCount < HowManyPopularLinksToShow And Not Records.EOF 
		
			.write "<font class='general_text'>" & ResourceCount & ". </font>"	 
			.write "<a class='frontpage_links' href='" & Path2Directory & "redirect.asp?id=" 
			.write Records("ID") & "' title='" 
			.write Records("Title") & "' target='_blank'>"
		
				If len(Records("Title")) >= 26 then
					.write left(Records("Title"),26) & "..."
				else
					.write Records("Title") 
				end if
			
			.write "</a> "
			
			GenerateCategoryURL Records("CategoryID")
	
		if Records("Sponsor") = true then
			.write " <img src='" & Path2Directory & "images/sponsor.gif' alt='Sponsor' width='16' height='16' align='absmiddle'> "
		else
			.write " "
		end if

		if Records("Favorite") = true then
			.write "<img src='" & Path2Directory & "images/fav.gif' alt='Favorite' width='16' height='14' align='absbottom'> "
		else
			.write " "
		end if
	
			.write NewIcon(Records("Created")) 
			.write "<br>"
			
		  ResourceCount = ResourceCount + 1
		 Records.MoveNext
		Loop
	
	End If
	
	.write "</td></tr></table>"
	
	End With 
	
	ConnObj.Close
	Set ConnObj = Nothing
	Set Records = Nothing
	

End Sub

Sub GenerateCategoryURL (CategoryID) 

	Dim ConnObj, SQL, Records

if CategoryID <> "" then
	
		Set ConnObj = Server.CreateObject("ADODB.Connection")
		ConnObj.Open MyConnStr
		SQL = "SELECT ID, ParentID FROM del_Directory_Categories WHERE ID = " & categoryID 
		Set Records = ConnObj.Execute(SQL) 
		
		If Records.EOF then
		
		else
		
		response.write " <a href='" & Path2Directory & "default.asp?id=" & Records("ID") 		
		
			if Records("ParentID") <> 0 then 
				response.write "&parentID=" & Records("ParentID") & "' target='_parent'>"
			else
				response.write "'>"
			end if
								
		response.write "<img src='images/cat.gif' align='absbottom' alt='goto category...' width='15' height='13' border='0'></a> "			
		
		end if
		
	Set Records = Nothing
	ConnObj.Close

end if 
		
End Sub 

Function GenerateDirectoryTitle(titleID)

	Dim ConnObj, CategoryTitle

	if titleID <> "" then
	
			Set ConnObj = Server.CreateObject("ADODB.Connection")
			ConnObj.Open MyConnStr
			SQL = "SELECT CategoryName, ParentID FROM del_Directory_Categories WHERE ID = " & titleID 
			if Debug = True then response.write SQL
			Set CategoryTitle = ConnObj.Execute(SQL) 
				
				If CategoryTitle.EOF then
			
					GenerateDirectoryTitle = ""
			
				else			

					if CategoryTitle("ParentID") <> 0 then
						GenerateDirectoryTitle CategoryTitle("ParentID")
					end if
					
					if CategoryTitle("ParentID") <> 0 then 
						TitleText = TitleText & " " & NavigationSep & " "
					end if
							
					TitleText = TitleText & CategoryTitle("CategoryName") 		

					GenerateDirectoryTitle = NavigationSep & " " & TitleText & " "
					
				end if
			
			ConnObj.Close
			Set CategoryTitle = Nothing
			
	else
		
		GenerateDirectoryTitle = " "
		
	end if 

End Function

Sub ShowFeatures()

	With Response
	
			.write "<a class='main_navigation' href='default.asp'>Home</a> | "
			.write "<a class='main_navigation' href='search.asp?action=new'>Whats New!</a> | "
			.write "<a href='search.asp?action=hot' class='main_navigation'>Whats Hot!</a> | "
			.write "<a href='dir_explorer.asp' class='main_navigation'>Directory Explorer</a> | "
			.write "<a href='personalise.asp' class='main_navigation'>Personalise</a> | "
			.write "<a href='favorites.asp' class='main_navigation'>Your Favorites</a> | "
			.write "<a href='newsletter.asp' class='main_navigation'>Newsletter</a> | "
			.write "<a href='add.asp?id=" & id & "&parentid=" & parentid & "' class='main_navigation'>Add Listing</a>"

	End With

End Sub

Sub ShowDirectoryStatisics()

	With Response
		.write "<table width='100%' cellpadding='0' cellspacing='0'><tr><td class='statistics_text'>"
		.Write ReturnTotalOfLinks() & " links in " & ReturnTotalOfCategories() & " categories - "
		.write "Link to Category ratio: " & LinkToCategoryRatio() 
		.write "</td><td align='right'>"
		.write "<img src='" & Path2Directory & "images/poweredby.gif' width='100' height='30' border='0'>"
		.write "</td></tr></table>"
	End With
		
End Sub

Function LinkToCategoryRatio()

	if ReturnTotalOfLinks = 0 then
		LinkToCategoryRatio = "0:1"
	else
		if ReturnTotalOfLinks < ReturnTotalOfCategories then
		LinkToCategoryRatio = "1:1"
		else
		LinkToCategoryRatio = FormatNumber(ReturnTotalOfLinks / ReturnTotalOfCategories,0,0) & ":1"
		end if
	end if
			
End Function

Function ReturnTotalOfLinks()
	
	Dim ConnObj, TheSet, NumOfSites

	If DatabaseType = "Access" then
		SQL = "SELECT id FROM del_Directory_Sites WHERE PublishOnWeb = True"
	else
		SQL = "SELECT id FROM del_Directory_Sites WHERE PublishOnWeb = 1"
	end if
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj
	
	if TheSet.EOF Then
		NumOfSites = 0
	else
		NumOfSites = TheSet.RecordCount
	end if
	
	ConnObj.Close
	Set TheSet = Nothing
	Set ConnObj = Nothing
	
	ReturnTotalOfLinks = NumOfSites
	
End Function

Function ReturnTotalOfCategories()

	Dim ConnObj, TheSet, NumberOfCategories
	
	SQL = "SELECT id FROM del_Directory_Categories"
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	Set TheSet = Server.CreateObject("ADODB.Recordset")
	TheSet.CursorLocation = 3
	TheSet.Open SQL, ConnObj
	
	if TheSet.EOF Then
		NumberOfCategories = 0
	else
		NumberOfCategories = TheSet.RecordCount
	end if
	
	ConnObj.Close
	Set TheSet = Nothing
	Set ConnObj = Nothing
	
	ReturnTotalOfCategories = NumberOfCategories
	
End Function

Sub ShowNewsletterBox()

	Response.Write "<table width='100%' cellpadding='0' cellspacing='0' bgcolor='#bbbbbb'>"
	Response.Write "<tr><td>"
	Response.Write "<table width='100%' cellpadding='7' cellspacing='1'><tr>"
	Response.Write "<form action='newsletter.asp?action=add' method='post' onSubmit='return checkGlobalEmail(this)' name='frmSideNewsletter'>"
	Response.Write "<td bgcolor='#fdfdfd'>"
	Response.Write "<font class='sidenewsletter'>Receive all the latest quality content direct to your inbox. Sign-up to our newsletter.<br><br>"
	Response.Write "<input type='text' name='email' size='13' style='width:100%;' class='search_input' onclick='this.select()' value='Email@Address'><br><br>"
	Response.Write "<input class='form_buttons' type='submit' value=' Sign-Up '>"
	Response.Write "</td></tr></form></table>"
	Response.Write "</td></tr></table>"

End Sub

Sub ShowAdminLink()

	response.write "<a class='general_text' href='" & Path2Admin & "'><b>Goto Admin Pages...</b></a><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>"
	
End Sub


%>
