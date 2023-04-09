<%@ LANGUAGE="VBSCRIPT"%>
<!--#include file="includes/functions.asp"-->
<%

Dim URL, ConnObj, Records, HitsThisMonth, Hits

SQL = "SELECT ID,URL, Hits, HitsTodayDate, HitsThisMonthDate, HitsThisMonth, HitsToday FROM del_Directory_Sites WHERE ID = " & request.querystring("ID")
Set ConnObj = Server.CreateObject("ADODB.Connection")
ConnObj.Open MyConnStr
Set Records = ConnObj.Execute(SQL)	

	if Records("HitsThisMonth") <> "" then
		HitsThisMonth = Records("HitsThisMonth") 
	else
		HitsThisMonth = 0
	end if
	
	if Records("Hits") <> "" then
		Hits = Records("Hits") 
	else
		Hits = 0
	end if

	If Records.EOF then

		response.redirect("default.asp")

	else

		URL = records("URL")

		if Records("HitsTodayDate") <> Day(Now()) then 
		 SQL = "UPDATE del_Directory_Sites SET HitsToday = 0, HitsTodayDate = " & Day(Now()) & " WHERE id = " & Records("ID")
		else 
		 SQL = "UPDATE del_Directory_Sites SET HitsToday = " & Records("HitsToday") + 1 & " WHERE id = " & Records("ID")
		end if

		ConnObj.Execute(SQL)
		
		if Records("HitsThisMonthDate") <> Month(Now()) then  
		 SQL = "UPDATE del_Directory_Sites SET HitsThisMonth = 0, HitsThisMonthDate = " & Month(Now()) & " WHERE id = " & Records("ID")
		else
		 SQL = "UPDATE del_Directory_Sites SET HitsThisMonth = " & HitsThisMonth + 1 & " WHERE id = " & Records("ID")		 
		end if
		
		ConnObj.Execute(SQL)
		
		if DatabaseType = "Access" then
			SQL = "UPDATE del_Directory_Sites SET LastAccessed = #" & ShortDate & "#, Hits = " & Hits + 1 & " WHERE id = " & Records("ID")
		else
			SQL = "UPDATE del_Directory_Sites SET LastAccessed = '" & ShortDateIso & "', Hits = " & Hits + 1 & " WHERE id = " & Records("ID")
		end if

		ConnObj.Execute(SQL)
		
	End If

ConnObj.Close
Set Records = Nothing
Set ConnObj = Nothing

response.redirect(URL)

%>


