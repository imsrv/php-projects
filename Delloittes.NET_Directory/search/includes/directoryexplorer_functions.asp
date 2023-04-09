<%

Dim ConnObj, IntLevel

Sub ShowDirectoryMap()

	intLevel = 0

	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open MyConnStr

		
		response.write "<table width='98%' cellspacing='0' align='center'>"
		response.write "<tr><td valign='top'>"
		BuildDirectoryMap (0)
		response.write "</td></tr></table><br><br>"
			
	ConnObj.Close
	
End Sub

Sub BuildDirectoryMap (ID) 

	Dim SQL, Records

	SQL = "SELECT ID, CategoryName, ParentID FROM del_Directory_Categories WHERE ParentID = 0 ORDER BY CategoryName" 
	If Debug = True then response.write SQL
	Set Records = Server.CreateObject("ADODB.Recordset")
	Records.CursorLocation = 3
	Records.Open SQL, ConnObj

		if Records.EOF then 
	
		else
			
			Records.MoveFirst
			 Do until Records.EOF
			  IntLevel = 0
			  
				response.write "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"
				response.write "<tr><td>"
				response.write "<br><img src='images/dir_map/vlineroot.gif' align='absmiddle' vspace='0' hspace='0'>"
				response.write "<img src='images/dir_map/root.gif' align='absmiddle' vspace='0' hspace='0'>"
				response.write "<img src='images/dir_map/open.gif' align='absmiddle' vspace='0' hspace='0'>"
				response.write "<font class='general_text'> "
				response.write "<b>"
				response.write "<a href='default.asp?id=" & Records("id") & "' class='category_head'><b>"
				response.write trim(Records("CategoryName")) & "</b></a>"
				response.write "</b></font>"			
				response.write "</td></tr>"
				response.write "<tr><td>"
				response.write "<img src='images/dir_map/vline.gif' align='absmiddle' vspace='0' hspace='0'>"
				response.write "</tr></td>"			
				GetAllSubCats(Records("ID"))			
				response.write "</table>"
			
				if Records.AbsolutePosition = Round(Records.RecordCount / 2,0) then 
					response.write "</td><td valign='top'>"
				end if
			
			 Records.MoveNext
			Loop
		
		end if
		
	Set Records = Nothing

		
End Sub

Sub GetAllSubCats (ID) 
	
	Dim Records
	IntLevel = IntLevel + 1
	SQL = "SELECT ID, CategoryName, ParentID, ListingCount FROM del_Directory_Categories WHERE ParentID = " & ID & " ORDER BY CategoryName"
	If Debug = True then response.write SQL

	Set Records = ConnObj.Execute(SQL) 
		
	if Records.EOF then 
		
		Exit Sub
			
	Else
				
		Records.MoveFirst
		 Do until Records.EOF
		
				response.write "<tr><td>"
				response.write "<font class='general_small_text'>"
				response.write "<img src='images/dir_map/vline.gif' align='absmiddle' vspace='0' hspace='0'>"	
		
				for i = 0 to intLevel 
		
					if i = 0 OR i = 1 then
					 response.write "<img src='images/dir_map/hline.gif' align='absmiddle' vspace='0' hspace='0'>"
					else
					 response.write "<img src='images/dir_map/hline2.gif' align='absmiddle' vspace='0' hspace='0'>"
					end if
		
				next
		
				response.write "<img src='images/dir_map/closed.gif' align='absmiddle' vspace='0' hspace='0'> "
				response.write "&nbsp;<a href='default.asp?id=" & Records("id") & "&parentID=" 
				response.write Records("parentid") & "' class='sub_categories'>"
				response.write trim(Records("CategoryName")) & "</a>"
				response.write "</font>"
		
				GetAllSubCats(Records("ID"))
		
				response.write "</td></tr>"
				
		   Records.MoveNext			
		  intLevel = intLevel - 1			
		 Loop	
		 	
	end if
		
		
End Sub
	
%>
