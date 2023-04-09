<!--#Include File="../../Data_Connection/Connection.asp"-->
<%
	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------
	
	IF Request.ServerVariables ("CONTENT_LENGTH")<>0 THEN
		Dim Query

		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
	
		IF trim(Request.Form ("companyname"))=EMPTY THEN
			Session("MSG")="Please enter Company Name."
		ELSEIF trim(Request.Form ("companyusername"))=EMPTY THEN
			Session("MSG")="Please enter User Name."
		ELSEIF trim(Request.Form ("companypassword"))=EMPTY THEN
			Session("MSG")="Please enter Password."
		End If
		
		IF trim(Session("MSG"))=EMPTY THEN
			Query="Update Companies Set CompanyName='" & encode(Request.Form ("companyname")) & "'"
			Query=Query & ", CompanyURL='" & encode(Request.Form ("companyURL")) & "'"
			Query=Query & ", CompanyAddress1='" & encode(Request.Form ("companyaddress1")) & "'"
			Query=Query & ", CompanyAddress2='" & encode(Request.Form ("companyaddress2")) & "'"
			Query=Query & ", CompanyCity='" & encode(Request.Form ("companycity")) & "'"
			Query=Query & ", CompanyState='" & encode(Request.Form ("companystate")) & "'"
			Query=Query & ", CompanyPostalCode='" & encode(Request.Form ("companypostalcode")) & "'"
			Query=Query & ", ContactName='" & encode(Request.Form ("contactname")) & "'"
			Query=Query & ", CompanyCountry='" & encode(Request.Form ("companycountry")) & "'"
			Query=Query & ", ContactEmail='" & encode(Request.Form ("contactemail")) & "'"
			Query=Query & ", CompanyPhoneVoice='" & encode(Request.Form ("companyphonevoice")) & "'"
			Query=Query & ", CompanyPhoneFax='" & encode(Request.Form ("companyphonefax")) & "'"
			Query=Query & ", CompanyUserName='" & encode(Request.Form ("companyusername")) & "'"
			Query=Query & ", CompanyPassword='" & encode(Request.Form ("companypassword")) & "'"
			Query=Query & " Where CustomerID=" & Request.Form ("customerid")
			adnowConn.Execute (Query)
			Session("MSG")="Update Successful"
			IF trim(Request.Querystring("BURL"))<>EMPTY THEN
			  Response.Redirect decode(Request.QueryString ("BURL"))
			ELSE
			  Response.Redirect "stats.asp?" & Request.ServerVariables ("Query_String")
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
		Dim Query
		Dim functionConn
		Dim CompanyRS
		
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