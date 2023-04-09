<%

Dim FavSites, Favorites, GetOverallRating

if request.querystring("action") = "clear" then
	Response.Cookies("Favorites") = ""
	Response.Cookies("Favorites").Expires = now + 365
end if

FavSites = Request.Cookies("Favorites")

	if FavSites = "" then
		Favorites = False
	else
		FavSites = Split(FavSites, ",", -1, 1)
		Favorites = True 
	end if


Sub ShowFavorites()

Dim SQL, j, TheSet, ConnObj, iPageCurrent, iPageCount, iPageSize, iResultCount, Reviews, ReviewCount

	SQL = "SELECT * FROM del_Directory_Sites WHERE "	
			
	for j = 0 to ubound(FavSites) - 1 step + 1

		SQL = SQL & "ID = " & FavSites(j) 
			
		if j <> ubound(FavSites) - 1 then
			SQL = SQL & " OR "
		end if
		
	next

	if DatabaseType = "Access" then
		SQL = SQL & " AND del_Directory_Sites.PublishOnWeb = True"
	else
		SQL = SQL & " AND del_Directory_Sites.PublishOnWeb = 1"
	end if
	
		' Set field to sort
		if request.querystring("order") = "" then
		SQL = SQL & " ORDER BY del_Directory_Sites.Created DESC, Title" 
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
		
		' Set Sort Order from combo boxes
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
	TheSet.PageSize = SearchResultsPerPage
	TheSet.Open SQL, ConnObj
		
	iPageCount = TheSet.PageCount
	
	With Response
	
	.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
	"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
	"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"
		
	if TheSet.EOF or TheSet.BOF then ' no records found 
		
		.write "<tr><td valign='top' bgcolor='" & CellSpilt & "'></td></tr>"
		.write "<tr><td bgcolor='" & CellBGColor & "'>"
		.write "<font class='general_text'>"
		.write "Sorry no favorites found."
		.write "</font>"
		.write "</td></tr>"
		.write "<tr><td>"
		.write "<font class='general_text'>"
		.write "<a href='default.asp'><b>Return Home</b></a>"
		.write "</font>"
		.write "</td>"
		.write "</tr>"

	else ' we have a result 
	
		If 1 > iPageCurrent Then iPageCurrent = 1
		If iPageCurrent > iPageCount Then iPageCurrent = iPageCount
		TheSet.AbsolutePage = iPageCurrent
		iResultCount = (iPageSize * (iPageCurrent - 1)) + 1
	

	.write "<tr><td>"
	
	' draw how many pages where found and sort combo boxes
	
		.write "<form>" ' netscape will not display form elements unless they are within a form tag
		
		.write "<table cellspacing='0' cellpadding='0' width='100%'>"
		.write "<tr><td>"
		.write "<font class='page_results_count'>"
		.write TheSet.RecordCount & " results found - Page " & iPageCurrent 
		.write " of " & iPageCount
		.write "</font>"
		.write "</td>"
		
		if request.querystring("action") = "" then
		
			.write "<td align='right'>"		
			.write "<select name='order' onchange=""javascript:self.location = '" & Path2Directory 
			.write "favorites.asp?page=" 
			.write iPageCurrent & "&order=' + this.value + '&sortorder=' + sort.value ;"">"					
			.write "<option value=''" 
			if request.querystring("order") = "" then .write "selected" 
			.write ">Sort...</option>"
			.write "<option value='TIT'"
			if request.querystring("order") = "TIT" then .write "selected" 
			.write ">Sort : Title</option>"
			.write "<option value='DES'"
			if request.querystring("order") = "DES" then .write "selected" 
			.write ">Sort : Description</option>"
			.write "<option value='CRE'"
			if request.querystring("order") = "CRE" then .write "selected" 
			.write ">Sort : Created Date</option>"
			.write "<option value='LAC'" 
			if request.querystring("order") = "LAC" then .write "selected" 
			.write ">Sort : Last Visit</option>"
			.write "<option value='HITDAY'"
			if request.querystring("order") = "HITDAY" then .write "selected" 
			.write ">Sort : Hits Today</option>"
			.write "<option value='HITMON'"
			if request.querystring("order") = "HITMON" then .write "selected"
			.write ">Sort : Hits This Month</option>"
			.write "<option value='HIT'"
			if request.querystring("order") = "HIT" then .write "selected" 
			.write ">Sort : Overall Hits</option>"
			.write "</select>"
			
			.write "<select name='sort' onchange=""javascript:self.location = '" & Path2Directory 
			.write "favorites.asp?page=" &_
			iPageCurrent & "&order=' + order.value + '&sortorder=' + this.value ;"">"		
			.write "<option value='ASC'"
			if request.querystring("sortorder") = "ASC" then .write "selected" 
			.write ">Ascending Order</option>"
			.write "<option value='DESC'"
			if request.querystring("sortorder") = "DESC" then .write "selected" 
			.write ">Descending Order</option>"
			.write "</select></td>"
		
		end if
		
		.write "</form></tr></table>"
		
	.write "</td></tr>"	
	.write "<tr><td colspan='2' bgcolor='" & CellSpilt & "'></td></tr>"
	
	Do While TheSet.AbsolutePage = iPageCurrent And Not TheSet.EOF 

	.write "<tr><td valign='top' colspan='2' bgcolor='" & CellBGColor & "'>"
	
		.write "<table width='100%' cellspacing='0' cellpadding='0'>"
		.write "<tr><td class='listing_head'>"
		
		' draw resource link
		
		.write "<a class='listing_head' href='" & Path2Directory & "redirect.asp?id=" 
		.write TheSet("ID") & "' title='" & TheSet("Title") & "' target='_blank'>"
	
			If len(TheSet("Title")) >= 40 then
				.write left(TheSet("Title"),40) & "..."
			else
				.write TheSet("Title") 
			end if
		
		.write "</a>"

		if TheSet("Sponsor") = true then
		.write "&nbsp;<img src='" & Path2Directory & "images/sponsor.gif' alt='Sponsor' align='absmiddle'>&nbsp;"
		else
		.write "&nbsp;"
		end if

		if TheSet("Favorite") = true then
		.write "<img src='" & Path2Directory & "images/fav.gif' alt='Favorite' align='absbottom'>&nbsp;"
		else
		.write "&nbsp;"
		end if

		.write NewIcon(TheSet("Created")) 
		.write "</td><td align='right'>"
		
			' get overall rating
	
			.write "<img src='" & Path2Directory & "images/rating.gif'>&nbsp;&nbsp;"
	
			SQL = "SELECT * FROM del_Directory_Reviews WHERE SiteID = " & TheSet("ID") & " AND "
			
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

				.write DisplayRating(GetOverallRating)								
				GetOverallRating = "" ' reset overall rating
			
			end if

		.write "</td></tr></table>"

	.write "</td></tr>"	
	.write "<tr><td>"
	
		.write "<table width='100%' cellspacing='0' cellpadding='0'><tr><td>"
		
		' draw created and last visited date
		
		.write "<font class='created_date'>"
		.write "Created: " & FormatDateTime(TheSet("Created"),2) & ", " 
		.write "Last Visit: " & FormatDateTime(TheSet("LastAccessed"),2)
		.write "</font>"
		
		.write "</td>"		
		.write "<td>"
		
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
		
		.write "<font class='hits_count'>"
		.write "Hits Today: " & TheSet("HitsToday") & ", "
		.write "This Month: " & TheSet("HitsThisMonth") & ", " 
		.write "Overall: " & TheSet("Hits")
		.write "</font>"
		
		.write "</td>"

		.write "<td align='right' class='rate_review' valign='middle'>"
		.write "<a class='rate_review' href='" & Path2Directory & "review.asp?siteID=" & TheSet("ID") 
		.write "'>"
		.write "Rate & Review</a> "
		.write "<font class='rate_review'>|</font> " 
		
		if ReviewCount = 0 then
			.write "<font class='rate_review'>"
			.write ReviewCount & " Reviews" 
			.write "</font>"
		elseif ReviewCount = 1 then
			.write "<a class='rate_review' href='" & Path2Directory & "reviews.asp?siteID=" 
			.write TheSet("ID") & "'>"
			.write ReviewCount & " Review</a>" 
		else
			.write "<a class='rate_review' href='" & Path2Directory & "reviews.asp?siteID=" 
			.write TheSet("ID") & "'>"
			.write ReviewCount & " Reviews</a>"
		end if 

		.write "</td></tr></table>"
		
	.write "</td></tr>"
	
	.write "<tr><td colspan='2'>"
	
	' draw description
	
	.write "<font class='listing_description'>"
	if TheSet("Description") <> "" then response.write TheSet("Description")  
	.write "</font>"
	
	' draw report error and bookmark links
	
	.write "<br><br>"
	
	.write "<table width='100%' cellspacing='0'><tr><td>"
	.write "<font class='search_results_category'>"
	
	i = 0
	ShowHomeLink = False
	ConstructCategoryNavigation TheSet("CategoryID")
	.write TopNavLinks ' write top navigation to screen and chop off last seperator
	
	.write "</font>"
	.write "</td><td align='right'>"
	.write "<a class='bookmark_resource' href='search.asp?keyword=" 
	.write server.URLEncode(TheSet("Title")) & "&type=ANY'>"
	.write "Related Resources</a>"
	.write " <font class='bookmark_resource'>|</font> "	
	.write "<a class='bookmark_resource' href=""javascript:WindowOpen('" & Path2Directory & "bookmark.asp?id=" 
	.write TheSet("ID") & "&popup=true','750','275',0)"""
	.write "title='opens in new window...'>Add to Favorites</a>"
	.write " <font class='bookmark_resource'>|</font> "
	.write "<a class='report_error' href=""javascript:WindowOpen('" & Path2Directory & "error.asp?siteID=" 
	.write TheSet("ID") & "&popup=true','750','450',1)"">Report Error</a>"
	.write "</td></tr></table>"

	.write "</td></tr>"
	
	iResultCount = iResultCount + 1			
	
		TheSet.MoveNext		
		Loop

	.write "<tr>"
	.write "<td valign='top' colspan='2'>"	
	
		response.write "<table width='100%' border='0' cellpadding='0' cellspacing='0'>"
		response.write "<tr><td width='20%' align='left'>"
		
		If iPageCurrent > 1 Then
		
			 .write "&#171;&nbsp;<a class='paging_links' href='" & Path2Directory & "favorites.asp?page=" 
			 .write iPageCurrent - 1 
			 .write "&order=" & request.querystring("order")
			 .write "&sortorder=" & request.querystring("sortorder") & "'>Previous Page</a>"	
			 
		end if
		
		.write "</td>"
		.write "<td width='60%' align='center'>"	
		
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
						
							.write "<a class='paging_links' href='" & Path2Directory & "favorites.asp?page=" & i 
							.write "&order=" & request.querystring("order") 
							.write "&sortorder=" & request.querystring("sortorder") & "'>" & i & "</a>"
						end if
	    	
					if i <> intEnd then 
						response.write "&nbsp;&nbsp;"
					else					
						if i <> iPageCount then response.write "&nbsp;..."	
					end if
					
				next
		
			end if
		.write "</td>"
		.write "<td width='20%' align='right'>"
		
		If iPageCurrent <> iPageCount Then
	
			.write "<a class='paging_links' href='" & Path2Directory & "favorites.asp?page="
			.write iPageCurrent + 1 
			.write "&order=" & request.querystring("order")
			.write "&sortorder=" & request.querystring("sortorder") & "'>Next Page</A>&nbsp;&#187;"
		
		end if	
		
		response.write "</td></tr></table>"
	
	.write "</td></tr>"
	
	.write "<tr><td align='center'>"
	.write "<a class='paging_links' href='favorites.asp?action=clear'>Clear Your Favorites</a>"
	.write "</td></tr>"
	
	ShowDirectoryKey 
	
	end if
	
	.write "</table>"
	
	End With
	
	ConnObj.Close
	Set Reviews = Nothing
	Set TheSet = Nothing
	
	
End Sub

'*****************************************************
' This sub creates the category navigation just below each search result
'*****************************************************

Sub ConstructCategoryNavigation (theID) 

	Dim ConnObj, SQL, CategoryTitleRecords

	if theID <> "" then
	
		if i = 0  then TopNavLinks = ""
			
			Set ConnObj = Server.CreateObject("ADODB.Connection")
			ConnObj.Open MyConnStr
			SQL = "SELECT ID, CategoryName, ParentID FROM del_Directory_Categories WHERE ID = " & theID 
			if Debug = True then response.write SQL
			Set CategoryTitleRecords = ConnObj.Execute(SQL) 
				
			If CategoryTitleRecords.EOF then
			
				TopNavLinks = "<b>No Category Found</b>"
			
			else		
					
				i = i + 1
				
				if CategoryTitleRecords("ParentID") <> 0 then ConstructCategoryNavigation CategoryTitleRecords("ParentID")
				if CategoryTitleRecords("ParentID") <> 0 then TopNavLinks = TopNavLinks & " " &  NavigationSep & " "
						
				TopNavLinks = TopNavLinks & "<a class='search_results_category' href='default.asp?id=" & CategoryTitleRecords("ID")
			
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
		
			TopNavLinks = "<a class='search_results_category' href='" & Path2Directory & "default.asp'>Home</a> "
	
	end if 
	
End Sub


Sub ShowNoFavorites()

	With Response
	
		.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
		"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
		"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"
		.write "<tr><td class='general_text'>"
	
		.write "The 'Your Favorites' feature allows you to easily bookmark specific resources within the directory for easy access later. <br><br></font>"
		.write "<font class='general_text_red'>You currently have no listings bookmarked.</font>"
		.write "<font class='general_text'><br><br> To add a listing to Your Favorites click the 'Add to Favorites' link below each resource listing within the directory.</font>"
		.write "<br><br><font class='general_text_red'><b>The 'Your Favorites' feature requires cookies to work.</b>"
	
		.write "</td></td></table>"
	
	End With

End Sub

%>