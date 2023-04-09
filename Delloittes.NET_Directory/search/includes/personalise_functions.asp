<%

If request.querystring("action") = "update" then Personalise
If request.querystring("action") = "clear" then DeleteCookie

Sub DrawPersonalisationForm()

	Dim ConnObj, SQL, Records, num

	SQL = "SELECT * FROM del_Directory_Configuration WHERE ID = "
	
		if request.cookies("personlisationID") <> "" then
			SQL = SQL & request.cookies("personlisationID")
		else
			SQL = SQL & "1"
		end if
	
 	Set ConnObj = Server.CreateObject("ADODB.Connection")
 	ConnObj.Open MyConnStr	
 	Set Records = ConnObj.Execute(SQL)
	
	if Records.EOF then	
		
	else
	
	With Response
	
	.write "<br><table width='100%' align='center' cellspacing='" & CellSpacing & "'" &_
	"cellpadding='" & Cellpadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
	"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'><tr><td>"	
	.write "<font class='general_text'>"
	.write "You can customise various features of the directory using the form below.<br><br>"
	.write "You can modify how many Latest Additions, Popular Resources and Favorites are displayed on the homepage. How many results are shown per page within the directory and search pages, and how many sub items should be displayed under main category headings.<br><br>"
	.write "<font class='general_text_red'><b>Cookies must be enabled for personalisation to work. </b></font>"

		if request.querystring("action") = "update" then
		.write "<br><br><font class='general_text_red'><b>Settings Saved. Settings will take effect on any proceeding pages.</b></font>"
		end if
	
	.write "</td></tr></table><br>"
	
	.write "<table width='100%' align='center' cellpadding='0' cellspacing='0' bgcolor='" & CellSpilt & "'>"
	.write "<tr><td>"
	.write "<form action='personalise.asp?action=update' method='POST' name='frmPersonalise'>"
	.write "<table cellspacing='1' width='100%' cellpadding='8'>"
	
	.write "<tr><td bgcolor='" & CellBGColor & "' colspan='2'><font class='page_header'>Directory Settings</b></td></tr>"
	.write "<tr>"
	.write "<td width='30%'bgcolor='" & FormBGColor & "'><font class='form_text'>Navigation Seperator:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"
	
		.write "<select name='navsep' size='1'>"
	        .write "<option selected value=':'"
		if Records("NavigationSeperator") = ":" then .write " selected"
		.write ">:</option>"
	        .write "<option value='/'"
		if Records("NavigationSeperator") = "/" then .write " selected"
		.write ">/</option>"
	        .write "<option value='\'"
		if Records("NavigationSeperator") = "\" then .write " selected"
		.write ">\</option>"
		.write "<option value='-'"
		if Records("NavigationSeperator") = "-" then .write " selected"
		.write ">-</option>"
	        .write "<option value='&gt;'"
		if Records("NavigationSeperator") = ">" then .write " selected"
		.write ">&gt;</option>"
		.write "</select>"

	.write "</td>"
	.write "</tr>"
	
	.write "<tr>"
	.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Number of sub items to show under categories:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"	
	.write "<select name='subitemstoshow' size='1'>"
		
		for num = 1 to 20 step + 1
		    .write "<option value='" & num & "'"
		if num = cint(Records("ShowSubCategoryCount")) then .write " selected"
		.write ">" & num & "</option>"
		next	
		
	.write "</select>"	
	.write "</td>"
	.write "</tr>"
	
	.write "<tr>"
	.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Directory results per page:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"	
	.write "<select name='linksperpagedir' size='1'>"	
	
		for num = 5 to 100 step + 5
		    .write "<option value='" & num & "'"
			if num = cint(Records("LinksPerPage")) then .write " selected"
			.write ">" & num & "</option>"
		next		
	
	.write "</select>"	
	.write "</td>"
	.write "</tr>"
	
	.write "<tr>"
	.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Search results per page:</font>"
	.write "</td><td bgcolor='#F9F9F9'>"	
	.write "<select name='linksperpagesearch' size='1'>"
		
		for num = 5 to 100 step + 5
		    .write "<option value='" & num & "'"
			if num = cint(Records("SearchResultsPerPage")) then .write " selected"
			.write ">" & num & "</option>"
		next		
	
	.write "</select>"	
	.write "</td>"
	.write "</tr>"

	.write "<tr><td bgcolor='" & CellBGColor & "' colspan='2'><font class='page_header'>Homepage Settings</b></td></tr>"
	
	.write "<tr>"
	.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Number of <br>""Latest Additions""<br> to show on homepage:</font>"
	.write "</td><td bgcolor='" & FormBGColor & "'>"	
	.write "<select name='newlinks' size='1'>"	
	
		for num = 5 to 50 step + 5
		    .write "<option value='" & num & "'"
			if num = cint(Records("HowManyNewLinksToShow")) then .write " selected"
			.write ">" & num & "</option>"
		next	
		
	.write "</select>"	
	.write "</td>"
	.write "</tr>"
	
	.write "<tr>"
	.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Number of <br>""Popular Resources""<br> to show on homepage:</font>"
	.write "</td><td bgcolor='" & FormBGColor & "'>"	
	.write "<select name='popularlinks' size='1'>"	
	
		for num = 1 to 20 step + 1
		    .write "<option value='" & num & "'"
			if num = cint(Records("HowManyPopularLinksToShow")) then .write " selected"
			.write ">" & num & "</option>"
		next		
	
	.write "</select>"	
	.write "</td>"
	.write "</tr>"
	
	.write "<tr>"
	.write "<td bgcolor='" & FormBGColor & "'><font class='form_text'>Number of <br>""Favorites""<br> to show on homepage:</font>"
	.write "</td><td bgcolor='" & FormBGColor & "'>"	
	.write "<select name='favoriteslinks' size='1'>"	
	
		for num = 1 to 40 step + 1
		    .write "<option value='" & num & "'"
		if num = cint(Records("HowManyFavoritesToShow")) then .write " selected"
		.write ">" & num & "</option>"
		next	
		
	.write "</select>"	
	.write "</td>"
	.write "</tr>"
	
	.write "<tr>"
	.write "<td bgcolor='#F9F9F9'>&nbsp;</td>"
	.write "<td bgcolor='#F9F9F9'>"
	.write "<input type='submit' class='form_buttons' name='submit' value='Save Changes'> "
	.write "<input type='button' class='form_buttons' onClick=""javascript:location = 'personalise.asp?action=clear';"" name='submit' value='Back to Defaults'>"
	.write "</td></tr></table>"

	.write "</td></tr></table><br>"

	End With

	end if
	
 ConnObj.Close
 Set ConnObj = Nothing
 Set Records = Nothing
 

End Sub

Sub Personalise()

	Dim ConnObj, SQL, Records

	if request.cookies("personlisationID") <> "" then
	
		SQL = "UPDATE del_Directory_Configuration SET "
		SQL = SQL & "NavigationSeperator = '" & request.form("navsep") & "', "
		SQL = SQL & "ShowSubCategoryCount = " & request.form("subitemstoshow") & ", "
		SQL = SQL & "HowManyNewLinksToShow = " & request.form("newlinks") & ", "
		SQL = SQL & "HowManyPopularLinksToShow = " & request.form("popularlinks") & ", "
		SQL = SQL & "HowManyFavoritesToShow = " & request.form("favoriteslinks") & ", "
		SQL = SQL & "LinksPerPage = " & request.form("linksperpagedir") & ", "
		SQL = SQL & "SearchResultsPerPage = " & request.form("linksperpagesearch")
		SQL = SQL & " WHERE ID = " & cint(request.cookies("personlisationID")) 
	
	else
	
		SQL = "INSERT INTO del_Directory_Configuration (NavigationSeperator,ShowSubCategoryCount,HowManyNewLinksToShow,"
		SQL = SQL & "HowManyPopularLinksToShow, HowManyFavoritesToShow, LinksPerPage, SearchResultsPerPage) VALUES ("
		SQL = SQL & "'" & request.form("navsep") & "', "
		SQL = SQL & request.form("subitemstoshow") & ", "
		SQL = SQL & request.form("newlinks") & ", "
		SQL = SQL & request.form("popularlinks") & ", "
		SQL = SQL & request.form("favoriteslinks") & ", "
		SQL = SQL & request.form("linksperpagedir") & ", "
		SQL = SQL & request.form("linksperpagesearch") & ")"
	
	end if
	
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr	
	ConnObj.Execute(SQL)
	
		if request.cookies("personlisationID") = "" then
	
			SQL = "SELECT DISTINCT TOP 1 ID FROM del_Directory_Configuration ORDER BY ID DESC"
			Set Records = ConnObj.Execute(SQL)
				Records.MoveFirst ' move to last record
				response.cookies("personlisationID") = Records("ID")
				response.cookies("personlisationID").Expires = now() + 999
			Set Records = Nothing
			
		end if
		
	ConnObj.Close
	Set ConnObj = Nothing

End Sub

Sub DeleteCookie()

	response.cookies("personlisationID") = ""
	response.cookies("personlisationID").Expires = now() + 999

End Sub


%>