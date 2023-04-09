<%


'*****************************************************
' Request search keyword and various search options
'*****************************************************

Dim Keyword

	' This is the main search term, we filter and split this keyword in to an array
	if len(request.form("keyword")) = 0 then
		Keyword = replace(request.querystring("keyword")," ","+",1)
	else
		Keyword =  replace(request.form("keyword")," ","+",1)
	end if
	
	'Keyword = server.HTMLEncode(Keyword)
	
	' This variable is not filterd and only used for displaying search term and conditional tests
	TempKeyword = replace(Keyword,"+"," ",1)
	
	' The type of search the user selected
	if len(request.form("type")) = 0 then
		TypeOfSearch = request.querystring("type")
	else
		TypeOfSearch = request.form("type")
	end if
	
	' what category to search, users are given the option to search only current category
	if len(request.form("category")) = 0 then
		CategoryToSearch = request.querystring("category")
	else
		CategoryToSearch = request.form("category")
	end if

Sub ShowNavigation()

	With Response

		.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
		"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
		"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"
		.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
		.write "<tr>" ' if flag = true then start new row	
		.write "<td bgcolor='#EEF0F3' class='main_navigation'>"
	
		i = 0 ' reset counter for recursive sub
		
		ConstructTopNavigation ID ' call sub to construct top navigation
		.write "<font class='main_navigation'>"
		.write TopNavLinks ' write top navigation to screen 
		.write " " & NavigationSep & " "

		if request.querystring("action") = "" then 
			.write "<a href='" & Request.ServerVariables("PATH_INFO") & "?keyword=" & server.URLEncode(TempKeyword) & "&type=" & TypeOfSearch & "&category=" & CategoryToSearch
			.write "' class='main_navigation'>"
			.write " Search Results"
		elseif request.querystring("action") = "new" then 
			.write "<a href='" & Request.ServerVariables("PATH_INFO") & "?" 
			.write Request.ServerVariables("QUERY_STRING") & "' class='main_navigation'>"
			.write " Whats New!"
		elseif request.querystring("action") = "hot" then 
			.write "<a href='" & Request.ServerVariables("PATH_INFO") & "?" 
			.write Request.ServerVariables("QUERY_STRING") & "' class='main_navigation'>"
			.write " Whats Hot!"
		elseif request.querystring("action") = "fav" then 
			.write "<a href='" & Request.ServerVariables("PATH_INFO") & "?" 
			.write Request.ServerVariables("QUERY_STRING") & "' class='main_navigation'>"
			.write "  Favorites"
		end if 
	
		.write "</a>"
		.write "</font>"

		.write "</td></tr>"
		.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
		.write "</table><br>"
	
	End With

End Sub

'*****************************************************
' if no keyword was supplied then redirect back to previous page
'*****************************************************

if len(Keyword) = 0 AND request.querystring("action") = "" then 

	' Used for poll, this can be removed
	if request.querystring("poll") <> "true" then 
		if len(Request.ServerVariables("HTTP_REFERER")) > 0 then
			response.redirect(Request.ServerVariables("HTTP_REFERER")) 
		  else
			response.redirect("default.asp")
		end if
	end if

end if

'*****************************************************
' if type of search other than exact search and action is blank
' then run common keyword filter
'*****************************************************

If TypeOfSearch <> "EX" and request.querystring("action") = "" and request.querystring("filter") = "" then 
	FilterCommonKeywords 
end if

'*****************************************************
' Split keyword into array of search terms
'*****************************************************

Dim KeywordArray
SplitKeywordIntoArray

'*****************************************************
' This sub will remove common keywords using regular expressions
' If not sure how to use regular expressions please visit...
' http://www.4guysfromrolla.com/webtech/regularexpressions.shtml
'*****************************************************

Sub FilterCommonKeywords()

' to add a word to filter enter \byourword\b - separate each word with a pipe character

	  dim regEx, strTagLess, filtered		
	  filtered = Keyword
	  set regEx = New RegExp 
	  regEx.IgnoreCase = True
	  regEx.Global = True
	  regEx.Pattern = "\bhow\b|\ba\b|\bto\b|\bthe\b|\band\b|\bif\b|\busing\b|\ban\b|\bon\b|\bwith\b|\bby\b|\bcreating\b|\bfrom\b|\busing\b|\bi\b|\bdo\b|\bcreate\b|\bsoftware\b|\bwithin\b|\bcreating\b|\bsimple\b|\byour\b|\byou\b|\bsimply\b|\bwhat\b"
	  Keyword = regEx.Replace(filtered, "")
	  set regEx = nothing
	  
End Sub

'*****************************************************
' This sub will split the keywords into an array at 
' the spaces if the user selected search ANY words
' from the search options
'*****************************************************

Sub SplitKeywordIntoArray()
		
	if TypeOfSearch = "ANY" then ' if match any keyword is selected we must split the Keywords into Array
	 KeywordArray = Split(Keyword, "+", -1, 1) ' split filtered keyword(s) into array 
	else
	 KeywordArray = Split(trim(replace(Keyword,"+"," ",1)), "vbctrl", -1, 1) ' don't split search term into array
	end if

		KeywordArray = RemDups(KeywordArray) ' return filtered keyword array and remove duplicate search terms
	
		' if the filtered keyword array if nothing then user only searched for a filtered keyword 
		' if this is the case just use original unfiltered keyword as search term
		
		if join(KeywordArray,",") = "" then KeywordArray = Split(TempKeyword, "vbctrl", -1, 1)
	
End Sub

'*****************************************************
' Clear array then remove duplicates from search string
'*****************************************************

Function RemDups(byVal anArray)

	dim d, item, thekeys

	set d = CreateObject("Scripting.Dictionary")
	d.removeall
	d.CompareMode = 0
	for each item in anArray
		if item <> "" then
		if not d.Exists(item) then d.Add item, item
		end if
	next
	thekeys = d.keys
	set d = nothing
	RemDups = thekeys
	
End Function

'*****************************************************
' The ShowResults Sub contains all the code for writting
' the various listings within a certain category
'*****************************************************

Sub SearchCategories()

Dim ConnObj, Records, SQL, j, CatCount

		SQL = "SELECT DISTINCT * FROM del_Directory_Categories " 
		
		if request.querystring("action") = "" then ' if this is a search then create SQL from array		
			SQL = SQL & "WHERE ("			
			if len(tempkeyword) > 0 then			
				for j = lbound(KeywordArray) to ubound(KeywordArray) 
				
					 SQL = SQL & "del_Directory_Categories.CategoryName LIKE '%" & CheckString(KeywordArray(j)) & "%'"
					 if j <> ubound(KeywordArray) then
					  SQL = SQL & " OR "
					 end if					
				next				
			else			
					SQL = SQL & "del_Directory_Categories.CategoryName LIKE '%%'"					
			end if
			
			SQL = SQL & ") "			
		end if
		
		if request.querystring("action") = "new" then
								
				if DatabaseType = "Access" then 
					SQL = SQL & " WHERE AllowLinks = True ORDER BY Created DESC"
				else
					SQL = SQL & " WHERE AllowLinks = 1 ORDER BY Created DESC"
				end if			
			
		elseif request.querystring("action") = "hot" then
		
				if DatabaseType = "Access" then 
					SQL = SQL & " WHERE AllowLinks = True ORDER BY ListingCount DESC"
				else
					SQL = SQL & " WHERE AllowLinks = 1 ORDER BY ListingCount DESC"
				end if	
					
		else
		
				SQL = SQL & " ORDER BY ParentID"
			
		end if
		
		If Debug = True then Response.write SQL
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr			
	Set Records = Server.CreateObject("ADODB.Recordset")	
	Records.CursorLocation = 3
	Records.PageSize = SearchResultsPerPage
	Records.Open SQL, ConnObj
		
	If Records.EOF then ' no records found 

	else ' we have a result 
		
	Response.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
	"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
	"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"
	response.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
	response.write "<tr><td bgcolor='" & CellBGColor & "'>"
	
		if request.querystring("action") = "new" then
		response.write "<font class='page_header'>New Categories</font>"
		elseif request.querystring("action") = "hot" then
		response.write "<font class='page_header'>Hot Categories</font>"
		else
				response.write "<table width='100%' cellspacing='0' cellpadding='0'>"
				response.write "<tr><td width='50%' class='page_header'>"
				response.write "Related Categories"
				response.write "</td>"
				
					if request.querystring("cats") <> "ALL" and Records.RecordCount > 5 then
						response.write "<td width='50%' align='right' class='search_results_category'>"
						response.write "<a class='main_navigation' href='search.asp?keyword=" & Server.URLEncode(tempkeyword)
						response.write "&category=" & CategoryToSearch & "&type=" & TypeOfSearch & "&cats=ALL'>"
						response.write "Show All Related Categories</a>"
						response.write "</td>"
					end if
				
				response.write "</tr></table>"
		end if
		
	response.write "</td></tr>"
	response.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
	response.write "<tr><td class='search_results_category'>"
	
	    CatCount = 0
		Records.MoveFirst
		 Do While CatCount < 5 And Not Records.EOF
		 
				i = 0
				ConstructSearchCategoryNavigation Records("ID")
				
			if Instr(1,TopNavLinks,"No Category Found",1) = False then 
				response.write TopNavLinks ' write category to screen
				response.write "<br>"
				if request.querystring("cats") <> "ALL" then CatCount = CatCount + 1
			end if
				
		
		 Records.MoveNext		
		Loop
		
	response.write "</td></tr>"
	response.write "</table>"

	
	End If
	
	ConnObj.Close
	Set Records = Nothing
	Set ConnObj = Nothing
	
End Sub

Sub SearchSites()

Dim SQL, j, TheSet, ConnObj, iPageCurrent, iPageCount, iPageSize, iResultCount
Dim Title, Reviews, ReviewCount, GetOverallRating

if request.querystring("action") <> "fav" and request.queryString("page") = "" or request.queryString("page") = "1" then 
	SearchCategories ' search for matching categories
end if

	if request.querystring("action") = "new" then ' if user clicked whats new
	
		SQL = "SELECT DISTINCT TOP 100 * FROM del_Directory_Sites WHERE"
		
				if DatabaseType = "Access" then 
					SQL = SQL & " del_Directory_Sites.PublishOnWeb = True ORDER BY del_Directory_Sites.Created DESC"
				else
					SQL = SQL & " del_Directory_Sites.PublishOnWeb = 1 ORDER BY del_Directory_Sites.Created DESC"
				end if			
		
	elseif request.querystring("action") = "hot" then ' if user clicked whats hot
	
		SQL = "SELECT DISTINCT TOP 100 * FROM del_Directory_Sites WHERE"
		
				if DatabaseType = "Access" then 
					SQL = SQL & " del_Directory_Sites.PublishOnWeb = True ORDER BY HitsToday DESC, HitsThisMonth DESC, Hits DESC"
				else
					SQL = SQL & " del_Directory_Sites.PublishOnWeb = 1 ORDER BY HitsToday DESC, HitsThisMonth DESC, Hits DESC"
				end if	 		
	
	elseif request.querystring("action") = "fav" then ' if user clicked whats hot
	
		SQL = "SELECT DISTINCT TOP 100 * FROM del_Directory_Sites WHERE"
		
				if DatabaseType = "Access" then 
					SQL = SQL & " del_Directory_Sites.PublishOnWeb = True AND Favorite = True ORDER BY del_Directory_Sites.Created DESC"
				else
					SQL = SQL & " del_Directory_Sites.PublishOnWeb = 1 AND Favorite = 1 ORDER BY del_Directory_Sites.Created DESC"
				end if		

	elseif request.querystring("action") = "" then ' if user performed a search
		
		SQL = "SELECT DISTINCT TOP 300  * FROM del_Directory_Sites "
		
			SQL = SQL & "WHERE ("	
			
			if left(lcase(KeywordArray(j)),5) = "link:" then
				if Instr(1,lcase(KeywordArray(j)),"http://") then
					SQL = SQL & "del_Directory_Sites.URL LIKE '%" & right(lcase(KeywordArray(j)),len(KeywordArray(j)) - 5) & "%'"
				else
					SQL = SQL & "del_Directory_Sites.URL LIKE '%http://" & right(lcase(KeywordArray(j)),len(KeywordArray(j)) - 5) & "%'"
				end if
			else
			
					if len(tempkeyword) > 0 then					
						for j = lbound(KeywordArray) to ubound(KeywordArray) 				
								if request.form("type") = "EX" then
								 SQL = SQL & "del_Directory_Sites.Title = '" & CheckString(KeywordArray(j)) & "'"
								else
								 SQL = SQL & "del_Directory_Sites.Title LIKE '%" & CheckString(KeywordArray(j)) & "%'"
								end if					
								if j <> ubound(KeywordArray) then
								 SQL = SQL & " AND "
								end if					
						next			
					else			
								SQL = SQL & "del_Directory_Sites.Title LIKE '%%'"						
					end if
					
					SQL = SQL & " OR "						
					if len(tempkeyword) > 0 then			
							for j = lbound(KeywordArray) to ubound(KeywordArray) 						
									if request.form("type") = "EX" then
									 SQL = SQL & "del_Directory_Sites.Description = '" & CheckString(KeywordArray(j)) & "'"
									else
									 SQL = SQL & "del_Directory_Sites.Description LIKE '%" & CheckString(KeywordArray(j)) & "%'"
									end if						
									if j <> ubound(KeywordArray) then
									 SQL = SQL & " AND "
									end if								
							next					
					else			
								SQL = SQL & "del_Directory_Sites.Title LIKE '%%'"						
					end if
					
				end if
			
			SQL = SQL & ")"

			if CategoryToSearch <> "ALL" AND CategoryToSearch <> "" then
				SQL = SQL & " AND (del_Directory_Sites.CategoryID = " & CategoryToSearch & ")"
			end if
			
			if DatabaseType = "Access" then 
				SQL = SQL & " AND (del_Directory_Sites.PublishOnWeb = True)"
			else
				SQL = SQL & " AND (del_Directory_Sites.PublishOnWeb = 1)"
			end if				
	
		' Set field to sort
		
		if request.querystring("order") = "" then
			SQL = SQL & " ORDER BY Sponsor ASC, del_Directory_Sites.Created DESC, Title" 
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
		
	End If

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
		.write "<font class='page_header'>"
		.write "Sorry no resources found."
		.write "</font>"
		.write "</td></tr>"
		.write "<tr><td valign='top' bgcolor='" & CellSpilt & "'></td></tr>"
		.write "<tr><td valign='top'>"
		.write "<font class='general_text'>No results where found that match the search criteria you specified. "
		
		if request.querystring("filter") = "" then
			.write "By default common keywords are filtered from your search to provide more accurate results. You can search our directory using an unfiltered version of your search term by <a href='search.asp?keyword=" & server.URLEncode(TempKeyword) & "&type=" & TypeOfSearch & "&category=" & CategoryToSearch & "&filter=off' class='general_text'>clicking here...</a>"
		end if
		
		.write "<br><br>Try other search critria...<br><br>"
		.write "<font class='general_text'>&#149;&nbsp;</font><a href='search.asp?keyword=" & server.URLEncode(TempKeyword) & "&type=ALL' class='general_text'>Search WHERE ALL words LIKE '" & server.HTMLEncode(TempKeyword) & "'</a><br>"
		.write "<font class='general_text'>&#149;&nbsp;</font><a href='search.asp?keyword=" & server.URLEncode(TempKeyword) & "&type=ANY' class='general_text'>Search for ANY word within '" & server.HTMLEncode(TempKeyword) & "'</a><br>"
		.write "<font class='general_text'>&#149;&nbsp;</font><a href='search.asp?keyword=" & server.URLEncode(TempKeyword) & "&type=EX' class='general_text'>Search WHERE Exact Phase '" & server.HTMLEncode(TempKeyword) & "'</a><br><br>"
		.write "Or...<br><br>"
		.write "<font class='general_text'>&#149;&nbsp;</font> <a class='general_text' href='dir_explorer.asp'>Browse our full directory...</a><br>"
		.write "<font class='general_text'>&#149;&nbsp;</font> <a class='general_text' href='default.asp'>Return Home...</a><br>"
		.write "</td></tr>"
		
	else ' we have a result 
	
		If 1 > iPageCurrent Then iPageCurrent = 1
		If iPageCurrent > iPageCount Then iPageCurrent = iPageCount
		TheSet.AbsolutePage = iPageCurrent
		iResultCount = (iPageSize * (iPageCurrent - 1)) + 1
		
	.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
	.write "<tr><td bgcolor='" & CellBGColor & "'>"
	
		if request.querystring("action") = "new" then
			.write "<font class='page_header'>New Resources</font>"
		elseif request.querystring("action") = "hot" then
			.write "<font class='page_header'>Popular Resources</font>"
		elseif request.querystring("action") = "fav" then
			.write "<font class='page_header'>Favorites</font>"
		else
			.write "<font class='page_header'>Search results for " & server.HTMLEncode(TempKeyword) & "</font>"
		end if
		
	.write "</td></tr>"	
	.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
	.write "<tr><td>"
	
	' render how many pages where found and display sort combo boxes
	
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
		
			.write "<select name='order' onchange=""javascript:if (this.value != '') {self.location = '" & Path2Directory 
			.write "search.asp?page=" 
			.write iPageCurrent & "&order=' + this.value + '&sortorder=' + sort.value + '&keyword=" 
			.write replace(TempKeyword,"'","\'") & "&type=" & TypeOfSearch 
			.write "&category=" & CategoryToSearch & "';}"">"	
				
			.write "<option value=''" 
			if request.querystring("order") = "" then response.write "selected" 
				.write ">Sort...</option>"
				.write "<option value='TIT'"
			if request.querystring("order") = "TIT" then response.write "selected" 
				.write ">Sort : Title</option>"
				.write "<option value='DES'"
			if request.querystring("order") = "DES" then response.write "selected" 
				.write ">Sort : Description</option>"
				.write "<option value='CRE'"
			if request.querystring("order") = "CRE" then response.write "selected" 
				.write ">Sort : Created Date</option>"
				.write "<option value='LAC'" 
			if request.querystring("order") = "LAC" then response.write "selected" 
				.write ">Sort : Last Visit</option>"
				.write "<option value='HITDAY'"
			if request.querystring("order") = "HITDAY" then response.write "selected" 
				.write ">Sort : Hits Today</option>"
				.write "<option value='HITMON'"
			if request.querystring("order") = "HITMON" then response.write "selected"
				.write ">Sort : Hits This Month</option>"
				.write "<option value='HIT'"
			if request.querystring("order") = "HIT" then response.write "selected" 
			.write ">Sort : Overall Hits</option>"
			.write "</select>"
			
			.write "<select name='sort' onchange=""javascript:self.location = '" & Path2Directory 
			.write "search.asp?page=" &_
			iPageCurrent & "&order=' + order.value + '&sortorder=' + this.value + '&keyword=" 
			.write replace(TempKeyword,"'","\'") & "&type=" & TypeOfSearch 
			.write "&category=" & CategoryToSearch & "';"">"		
			.write "<option value='ASC'"
			if request.querystring("sortorder") = "ASC" then response.write "selected" 
			.write ">Ascending Order</option>"
			.write "<option value='DESC'"
			if request.querystring("sortorder") = "DESC" then response.write "selected" 
			.write ">Descending Order</option>"
			.write "</select></td>"		
		end if
		
		.write "</form></tr></table>"
		
	.write "</td></tr>"
	
	Do While TheSet.AbsolutePage = iPageCurrent And Not TheSet.EOF 

	.write "<tr><td valign='top' colspan='2' bgcolor='" & CellBGColor & "'>"
	
		.write "<table width='100%' cellspacing='0' cellpadding='0'>"
		.write "<tr><td>"
		
		' draw resource link
		
		.write "<a class='listing_head' href='" & Path2Directory & "redirect.asp?id=" 
		.write TheSet("ID") & "' title='" & TheSet("Title") & "' target='_blank'>"
	
			If len(TheSet("Title")) >= 40 then
				Title = left(TheSet("Title"),40) & "..."
			else
				Title = TheSet("Title") 
			end if
		
		.write Highlight(Title)
		
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
	
			SQL = "SELECT * FROM del_Directory_Reviews WHERE SiteID = " & TheSet("ID") 
			
				if DatabaseType = "Access" then 
					SQL = SQL & " AND PublishOnWeb = True"
				else
					SQL = SQL & " AND PublishOnWeb = 1"
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
	
		.write "<table width='100%' cellpadding='0' cellspacing='0'><tr><td>"
		
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
		.write "Month: " & TheSet("HitsThisMonth") & ", " 
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
	if TheSet("Description") <> "" then .write Highlight(TheSet("Description")) 	
	.write "<br><br></font>"
	
	' draw report error and bookmark links
	
	.write "<table width='100%' cellspacing='0' cellpadding='0'><tr><td>"
	
	i = 0 ' reset counter
	ConstructSearchCategoryNavigation TheSet("CategoryID")
	.write TopNavLinks ' write top navigation to screen

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
	.write TheSet("ID") & "&popup=true','750','450',1)"" title='opens in new window...'>Report Error</a>"
	.write "</td></tr></table>"

	.write "</td></tr>"
	
	iResultCount = iResultCount + 1			
	
		TheSet.MoveNext		
		Loop

	
	.write "<tr>"
	.write "<td valign='top' colspan='2'>"	
	
		.write "<table width='100%' border='0' cellpadding='0' cellspacing='0'>"
		.write "<tr><td width='20%' align='left' class='paging_links'>"
		
		If iPageCurrent > 1 Then
		
			 .write "&#171;&nbsp;<a class='paging_links' href='" & Path2Directory & "search.asp?page=" 
			 .write iPageCurrent - 1 
			 .write "&order=" & request.querystring("order")
			 .write "&sortorder=" & request.querystring("sortorder") & "&id=" & ID & "&parentID=" 
			 .write ParentID & "&keyword=" & server.URLEncode(TempKeyword)
			 .write "&type=" & TypeOfSearch & "&category=" & CategoryToSearch
			 .write "&action=" & request.querystring("action") & "'>Previous Page</a>"	
			 
		end if
		
		.write "</td>"
		.write "<td class='paging_links' width='60%' align='center'>"	
		
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
				
					if i = intStart and i <> 1 then .write "...&nbsp;&nbsp;"
		
						if i = iPageCurrent then
							.write "<font class='paging_links'>[ " & i & " ]</font>"
						else
							.write "<a class='paging_links' href='" & Path2Directory & "search.asp?page=" & i 
							.write "&order=" & request.querystring("order") 
							.write "&sortorder=" & request.querystring("sortorder") & "&id=" & ID 
							.write "&parentID=" & ParentID & "&keyword=" & server.URLEncode(TempKeyword)
							.write "&type=" & TypeOfSearch & "&category=" & CategoryToSearch
							.write "&action=" & request.querystring("action") & "'>" & i & "</a>"
						end if
	    	
					if i <> intEnd then 
						response.write "&nbsp;&nbsp;"
					else
					
						if i <> iPageCount then response.write "&nbsp;..."
							
					end if
					
				next
		
			end if
			
		.write "</td>"
		.write "<td width='20%' class='paging_links' align='right'>"
		
		If iPageCurrent <> iPageCount Then
	
			.write "<a class='paging_links' href='" & Path2Directory & "search.asp?page="
			.write iPageCurrent + 1 
			.write "&order=" & request.querystring("order")
			.write "&sortorder=" & request.querystring("sortorder") & "&id=" & ID & "&parentID="
			.write ParentID & "&keyword=" & server.URLEncode(TempKeyword)
			.write "&type=" & TypeOfSearch & "&category=" & CategoryToSearch
			.write "&action=" & request.querystring("action") & "'>Next Page</A>&nbsp;&#187;"
		
		end if	
		
		.write "</td></tr></table>"
	
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
' Generate the category navigation links
'*****************************************************

Sub ConstructSearchCategoryNavigation (theID) 

	Dim ConnObj, SQL, CategoryTitleRecords

	if theID <> "" then
	
		if i = 0 then TopNavLinks = ""
				
			Set ConnObj = Server.CreateObject("ADODB.Connection")
			ConnObj.Open MyConnStr
			SQL = "SELECT ID, CategoryName, ParentID FROM del_Directory_Categories WHERE ID = " & theID 
			if Debug = True then response.write SQL
			Set CategoryTitleRecords = ConnObj.Execute(SQL) 
				
			If CategoryTitleRecords.EOF then
			
				TopNavLinks = "<b>No Category Found</b>"
			
			else		
					
				i = i + 1
				
				if CategoryTitleRecords("ParentID") <> 0 then ConstructSearchCategoryNavigation CategoryTitleRecords("ParentID")
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


Function Highlight(txt)

	Dim strBefore, strAfter, nPos, nLen, ArrayCount
	
	strBefore = "<b><font style='background-color:#F9FF4C;'>"
	strAfter = "</font></b>"
	
	if request.querystring("action") = "" then 
	
		For ArrayCount = lbound(KeywordArray) to Ubound(KeywordArray)
		
			nPos = InStr(1, txt, KeywordArray(ArrayCount), 1)
			nLen = Len(KeywordArray(ArrayCount)) 
			
			if nPos > 0 then txt = Left(txt, nPos - 1) & strBefore & Mid(txt, nPos, nLen) & strAfter & Mid(txt, nPos + nLen)
			
		Next
	
	end if
	
	Highlight = txt

End Function





%>