<%

if request.querystring("objectid") = "" then
ObjectID = 7
else
ObjectID = request.querystring("objectid")
end if

Sub ShowNavigation()

ShowTabs()

Response.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
	"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
	"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"
	
	response.write "<tr>" ' if flag = true then start new row	
	response.write "<td bgcolor='#EEF0F3' class='main_navigation'>"
	
	i = 0
	ConstructTopNavigation ID ' call sub to construct top navigation
	response.write "<font class='main_navigation'>"
	response.write TopNavLinks ' write top navigation to screen 
	response.write " " & NavigationSep & " "
	response.write "<a href='" & Request.ServerVariables("PATH_INFO") & "' class='main_navigation'>ASP Objects Ref</a>"
	
	if request.querystring("objectid") <> "" then
	response.write " " & NavigationSep & " "
	response.write "<a href='" & Request.ServerVariables("PATH_INFO") & "?objectid=" 
	response.write request.querystring("objectid") & "' class='main_navigation'>"
	response.write ReturnObjectName
	response.write "</a>"
	end if
	
	if request.querystring("tagid") <> "" then
	response.write " " & NavigationSep & " "
	response.write "<a href='" & Request.ServerVariables("PATH_INFO") & "?" 
	response.write Request.ServerVariables("QUERY_STRING") & "' class='main_navigation'>"
	response.write ReturnTagName
	response.write "</a>"
	end if
	
	response.write "</font>"

	response.write "</td></tr>"
	response.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
	response.write "</table>"

End Sub

Sub ShowObjects()
	
	SQL = "SELECT * FROM tblClassicASPObjects WHERE ID = " & ObjectID 
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open TagReferenceConnStr
	Set Records = ConnObj.Execute(SQL)
		
		If Records.EOF then ' no records found 
	
		else ' we have a result 
		
				With Response
			
					.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
					"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
					"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"
					.write "<tr><td class='tagDescription'>"
					'.write "<b>" & Records("ObjectName") & "</b><p>"				
					.write Records("Description")					
					.write "</td></tr>"
					.write "</table>"
				
				end with
		
		End If
	
End Sub
Sub ShowTags()
	
	SQL = "SELECT * FROM tblClassicASPTags WHERE ID = " & request.querystring("tagid")
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open TagReferenceConnStr
	Set Records = ConnObj.Execute(SQL)
		
		If Records.EOF then ' no records found 
	
		else ' we have a result 
		
				With Response
			
					.write "<table width='" & TableWidth & "' cellspacing='" & CellSpacing & "'" &_
					"cellpadding='" & CellPadding & "' Border='" & BorderWidth & "' bordercolor='" & BorderColor & "'" &_
					"bordercolordark='" & BorderColorDark & "' bordercolorlight='" & BorderColorLight & "'>"
					.write "<tr><td class='tagDescription'>"	
							
					.write Records("TagDescription")	
									
					.write "</td></tr>"
					.write "</table>"
				
				end with
		
		End If
	
End Sub


Function ReturnObjectName()
	
	SQL = "SELECT ObjectName FROM tblClassicASPObjects WHERE ID = " & ObjectID 
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open TagReferenceConnStr
	Set Records = ConnObj.Execute(SQL)
		
		If Records.EOF then ' no records found 
		
					ReturnObjectName = "Object Not Found"
	
		else ' we have a result 
					
					ReturnObjectName = Records("ObjectName") 
		
		End If
		
		ConnObj.Close
		Set ConnObj = Nothing
		Set Records = Nothing
	
End Function

Function ReturnTagName()
	
	SQL = "SELECT TagName FROM tblClassicASPTags WHERE ID = " & request.querystring("tagid")
	Set ConnObj = Server.CreateObject("ADODB.Connection")
	ConnObj.Open TagReferenceConnStr
	Set Records = ConnObj.Execute(SQL)
		
		If Records.EOF then ' no records found 
		
					ReturnTagName = "Object Not Found"
	
		else ' we have a result 
					
					ReturnTagName = Records("TagName") 
		
		End If
		
		ConnObj.Close
		Set ConnObj = Nothing
		Set Records = Nothing
	
End Function

%>