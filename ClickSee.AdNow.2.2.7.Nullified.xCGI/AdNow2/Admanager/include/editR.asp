<!--#Include File="../../Data_Connection/Connection.asp"-->
<%
	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------
	
	Dim dreport
	Dim ireport
	Dim fromname
	Dim name
	Dim cc
	Dim subject
	Dim Query
	Dim CompanyRS
	Dim CSumImp
	Dim ad_dataRS
	Dim StatsRS
	
	IF Request.ServerVariables ("CONTENT_LENGTH")<>0 THEN

		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
	
		IF ((Request.Form("DReport")<>empty) or (Request.Form("iReport")<>empty)) or ((Request.Form("fromname")<>empty) or (Request.Form("fromaddress")<>empty)) or ((Request.Form("emailreport")<>empty) or (Request.Form("Name")<>empty)) or ((Request.Form("cc")<>empty) or (Request.Form("subject")<>empty)) or (Request.Form("Body")<>empty) Then
			If ((Request.Form("DReport")) <> empty) and ((Request.form("iReport")) <> empty) then
		 		Session("MSG") = "Please enter either Report by day or Report by impressions2"
				Response.Redirect "../company.asp?"&Request.ServerVariables("Query_String")
			ElseIf (Request.form("fromaddress")) = EMPTY Then
		 		Session("MSG") = "Please enter 'From Email' information"
				Response.Redirect "../company.asp?"&Request.ServerVariables("Query_String")
			ElseIf (Request.form("emailreport")) = EMPTY Then
		 		Session("MSG") = "Please enter 'Contact Email Report' information"
				Response.Redirect "../company.asp?"&Request.ServerVariables("Query_String")
			ElseIf (Request.form("Body")) = EMPTY Then
		 		Session("MSG") = "Please enter 'Body' information"
				Response.Redirect "../company.asp?"&Request.ServerVariables("Query_String")
			End IF
		End If

		If trim(request.form("DReport")) = empty then
			dreport = "Null"
		else
			dreport = encode(request.form("DReport"))
		end if		
		
		If trim(request.form("iReport")) = empty then
			ireport = "Null"
		else
			ireport = encode(request.form("iReport"))
		end if		
		If request.form("fromname") = empty then
			fromname = "Null"
		else
			fromname = "'"&encode(request.form("fromname"))&"'"
		end if		
		If request.form("Name") = empty then
			name = "Null"
		else
			name = "'"&encode(request.form("Name"))&"'"
		end if		
		If request.form("cc") = empty then
			cc = "Null"
		else
			cc = "'"&encode(request.form("cc"))&"'"
		end if		
		If request.form("subject") = empty then
			subject = "Null"
		else
			subject = "'"&encode(request.form("subject"))&"'"
		end if		
		
		IF trim(Session("MSG"))=EMPTY THEN
			QUERY="SELECT * FROM companies "
			QUERY=QUERY&"WHERE customerid=" & Request.Form ("customerid")
			
			SET companyRS=Server.CreateObject ("ADODB.Recordset")
			CompanyRS.open QUERY,adnowConn,1,3
			
			IF NOT CompanyRS.EOF THEN
				IF CompanyRS("DReport")<>request.form("DReport") OR CompanyRS("ireport")<>request.form("iReport") THEN
					QUERY="UPDATE companies SET Lastsend = NULL "
					QUERY=QUERY&"WHERE customerid=" & Request.Form ("customerid")
					adnowConn.Execute (Query)
				ENd IF
			END IF
			CompanyRS.close
			
			Query="Update Companies Set "
			Query=Query & " fromname="&fromname
			Query=Query & ", fromaddress='"&encode(Request.form("fromaddress"))& "'"
			Query=Query & ", EmailReport='"&encode(Request.Form("emailreport"))&"'"
			Query=Query & ", name="&name
			Query=Query & ", cc="&cc
			Query=Query & ", subject="&subject
			Query=Query & ", body='"&encode(Request.Form("Body"))&"'"
			Query=Query & ", DReport="&dreport&""
			Query=Query & ", IReport="&ireport&""
			Query=Query & " Where CustomerID=" & Request.Form ("customerid")
			adnowConn.Execute (Query)
			Session("MSG")="Update Successful"
			
			'Set LastSend by IMP
			If trim(request.form("iReport")) <> empty AND trim(request.form("DReport")) = empty then
				CSumImp=ireport+0
				
				QUERY="SELECT adID FROM ad_data "
				QUERY=QUERY&"WHERE customerid="&Request.Form ("customerid")
			
				SET ad_dataRS=Server.CreateObject ("ADODB.Recordset")
				ad_dataRS.Open QUERY,adnowConn,1,3
			
				DO WHILE NOT ad_dataRS.EOF
					QUERY="SELECT SUM(Impressions) FROM [stats] "
					QUERY=QUERY&"WHERE adid="& ad_dataRS("adid")
					
					SET StatsRS=Server.CreateObject ("ADODB.Recordset")
					StatsRS.Open QUERY,adnowConn,1,3
					
					IF NOT StatsRS.EOF THEN
						DO WHILE CSumImp<(StatsRS(0)+0)
							CSumImp=CSumImp+ireport
						LOOP
					END IF
					StatsRS.Close
					ad_dataRS.MoveNext 
				LOOP
				ad_dataRS.Close
				
				QUERY="UPDATE Companies SET LastSend='"&CSumImp&"' "
				QUERY=QUERY&"WHERE CustomerID=" & Request.Form ("customerid")
				adnowConn.Execute (Query)
			END IF
			'----------------------
			
			IF Request("BURL")<>EMPTY THEN
				Response.Redirect decode(Request("BURL"))
			ELSE
				Response.Redirect "adcenter.asp"
			END IF
			
		END IF
	END IF

	'-------------------------------------------
	
	FUNCTION addVar(ByVal Str)
	
		IF lcase(str)<>"null" AND trim(str)<>"" THEN
			addVar=decode(str)
		ELSE
			addVar=""
		END IF
	
	END FUNCTION

	'-------------------------------------------
	
	FUNCTION Print_companies (ByVal fieldkey,ByVal customerid)

		IF Request.QueryString("customerid")=EMPTY THEN
			Response.Redirect "../adcenter.asp"
		END IF	
	
		IF trim(Request(fieldkey))=EMPTY THEN
			Query="SELECT * FROM companies " &_
						  "WHERE customerID=" & customerid

			IF NOT isobject(functionConn) THEN
				SET functionConn=Server.CreateObject ("ADODB.Connection")
				functionConn.Open DSNad,uid,pwd
			END IF

			SET companyRS=Server.CreateObject ("ADODB.Recordset")
			CompanyRS.Open Query,functionConn,1,3
	
			IF NOT companyRS.EOF THEN
				Print_companies=addVar (companyRS(fieldkey))
			END IF
		
			CompanyRs.Close 
			functionConn.Close 
		ELSE
			Print_companies=Request(fieldkey)
		END IF

	END FUNCTION

	'-------------------------------------------

%>