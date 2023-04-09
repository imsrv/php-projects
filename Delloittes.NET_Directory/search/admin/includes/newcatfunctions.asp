<%

sub Header()

	With Response
		.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
		.write "<tr><td>"
		.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
		.write "<tr><td bgcolor='#F9F9F9'>"
		.write "<img src='images/icons/new.gif' align='absmiddle'>&nbsp;&nbsp;"
		.write "<font class='menuLinks'>Create Category</font>"
		.write "</td></tr>"
		.write "<tr><td background='images/divide_bg.gif'></td></tr>"
		.write "<tr><td bgcolor='#ffffff'>"
		.write "<font class='general_small_text'>"
		.write "A quick and simple way to add new categories to the directory."
		.write "</font>"
		.write "</td></tr>"
		.write "</table>"
		.write "</td></tr></table><br>"
	End With

End Sub

Sub ShowNewCategoryForm()

	Dim ConnObj, SQL, CategoryRecords
	
	With Response
	
	.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
	.write "<tr><td>"
	.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
	.write "<tr><td bgcolor='#F9F9F9'>"
	.write "<img src='images/icons/help.gif' align='right' hspace='10'><font class='general_small_text'>Use the form below to add a new category to the directory. </b></font>"
	.write "</td></tr></table>"
	.write "</td></tr></table><br>"

	.write "<table width='90%' cellpadding='0' cellspacing='0' align='center' bgcolor='#bbbbbb'>"
	.write "<tr><td>"
	.write "<form onSubmit='return checkForm(this)' action='newcategory.asp?action=addcategory' method='POST' name='frmNewCategory'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Category Title:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='text' value='' class='input' name='cattitle' size='62'> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'><font class='form_text'>Allow Links:</font>"
	.write "</td><td bgcolor='#F9F9F9'><input type='checkbox' class='input' value='ON' name='allowlinks'><font class='general_small_text'><i>(Tick to allow resource submissions within this category)</i></font></td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9' valign='top'><font class='form_text'>Parent Category:</font></td>"
	.write "<td bgcolor='#F9F9F9'><select name='category' class='display_cats' size='20'>"
			
			Set ConnObj = Server.CreateObject("ADODB.Connection")
			ConnObj.Open MyConnStr	
			SQL = "SELECT ID FROM del_Directory_Categories ORDER BY ParentID, CategoryName"
			Set CategoryRecords = Server.CreateObject("ADODB.Recordset")
			CategoryRecords.CursorLocation = 3
			CategoryRecords.Open SQL, ConnObj
			
			if CategoryRecords.EOF then
			.write "<option value='0'>Root Category</option>"
			else
			
				.write "<option value='0' selected>Root Category</option>"
				
			CategoryRecords.MoveFirst
			Do Until CategoryRecords.EOF
			
				.write "<option value='" & CategoryRecords("ID") & "'>"
				
				i = 0
				ConstructCategories CategoryRecords("ID")
				.write TopNavLinks 
				.write "</option>"
			
			CategoryRecords.MoveNext
			Loop
			 
			end if
			
			Set CategoryRecords = Nothing
			ConnObj.Close
			
	.write "</select> *</td>"
	.write "</tr>"
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Add New Category'> "
	.write "<input type='reset' class='form_buttons' onclick=""javascript:history.back(1)"" name='reset' value='Cancel'>"
	.write "</td></tr></table>"

	.write "</td></tr></table><br>"

	End With

End Sub

Sub AddCategory()
	
	Dim allowlinks, ConnObj, SQL, NewCatID, Records
	
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
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr
	
		SQL = "SELECT Top 1 * FROM del_Directory_Categories ORDER BY ID DESC"
		Set Records = ConnObj.Execute(SQL)
		
		If Records.EOF Then	
			NewCatID = 1 	
		Else	
			NewCatID = Records("ID") + 1	
		End If
		
	Set Records = Nothing 
	
	SQL = "INSERT INTO del_Directory_Categories (ID, CategoryName, ListingCount, "
	SQL = SQL & "ParentID, AllowLinks, Created) VALUES "
	SQL = SQL & "(" & NewCatID & ",'" & CheckString(Request.Form("cattitle")) & "',0," & request.form("category") & ", "
	
	if DatabaseType = "Access" then
		SQL = SQL & allowlinks & ",#" & ShortDate & "#)"
	else
		SQL = SQL & allowlinks & ",'" & ShortDateIso & "')"
	end if
	
	ConnObj.Execute(SQL)
	ConnObj.Close
	
	Set ConnObj = Nothing
	
	With Response
	
		.write "<table width='90%' align='center' bgcolor='#bbbbbb' cellpadding='1' cellspacing='0'>"
		.write "<tr><td>"
		.write "<table width='100%' align='center' cellspacing='0' cellpadding='7' Border='0'>"	
		.write "<tr><td bgcolor='#F9F9F9'>"
		.write "<font class='general_small_text'>Your category """ & CheckString(Request.Form("cattitle")) & """ has been added to the directory.</font>"

		.write "</td></tr>"
		.write "<tr><td bgcolor='#bcbcbc'></td></tr>"
		.write "<tr><td bgcolor='#ffffff'><font class='general_small_text'>"
		.write "You can find your new category here...<br><br>"
		.write "<font class='search_results_category'>"
	
		i = 0
		ConstructTopNavigation request.form("category")
		.write TopNavLinks 
	
		.write "<br><br>"
		.write "<b><a href='newcategory.asp'>Create Another Category</a></b></font>"
		.write "</td></tr></table>"
		.write "</td></tr></table><br>"
	
	End With

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

Sub ConstructTopNavigation (theID) 

	Dim ConnObj, CategoryTitle

	if theID <> "" and theID <> "0" then
	
		if i = 0 then
			TopNavLinks = "<a href='" & Path2Admin & "managecategories.asp'>Home</a> " & NavigationSep & " "
		end if
		
		
			Set ConnObj = Server.CreateObject("ADODB.Connection")
			ConnObj.Open MyConnStr
			SQL = "SELECT ID, CategoryName, ParentID FROM del_Directory_Categories WHERE ID = " & theID 
			Set CategoryTitle = ConnObj.Execute(SQL) 
				
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
			
		ConnObj.Close
			
	else
		
				TopNavLinks = "<a href='" & Path2Admin & "managecategories.asp'>Home</a>  "
	
	end if 
	
End Sub

%>