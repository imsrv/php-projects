<!--#Include File="../../Data_Connection/Connection.asp"-->
<%
	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------
	
	IF trim(Request("campaignid"))=EMPTY THEN
	
		EndSession
		Response.Redirect "adcenter.asp"
	
	END IF	
	
	IF Request.ServerVariables ("CONTENT_LENGTH")<>0 THEN
		Dim campaigndescription
		Dim Query
		
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd

		IF trim(Request.Form ("campaignname"))=EMPTY THEN
			Session("MSG")="Please enter Campaign Name."
		END IF
		
		IF trim(Request.Form ("campaigndescription"))<>EMPTY THEN
			campaigndescription="='" & encode(Request.Form ("campaigndescription")) & "'"
		ELSE
			campaigndescription=" = null"
		END IF
		
		
		IF trim(Session("MSG"))=EMPTY THEN
			QUERY="UPDATE campaign SET campaignname='" & encode(Request.Form ("campaignname")) &"'"
			QUERY=QUERY & ", campaigndescription" & campaigndescription
			QUERY=QUERY & " WHERE campaignid=" & Request ("campaignid")
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
	
	FUNCTION Print_campaign (ByVal fieldkey,ByVal campaignid)
		Dim Query
		Dim functionConn
		Dim campaignRS
		
		IF Request.QueryString("campaignid")=EMPTY THEN
			Response.Redirect "../adcenter.asp"
		END IF	
	
		IF trim(Request(fieldkey))=EMPTY THEN
			Query="SELECT * FROM campaign " &_
						  "WHERE campaignid=" & campaignid

			IF NOT isobject(functionConn) THEN
				SET functionConn=Server.CreateObject ("ADODB.Connection")
				functionConn.Open DSNad,uid,pwd
			END IF

			SET campaignRS=Server.CreateObject ("ADODB.Recordset")
			campaignRS.Open Query,functionConn,1,3
	
			IF NOT campaignRS.EOF THEN
				Print_campaign=addVar (campaignRS(fieldkey))
			END IF
		
			campaignRs.Close 
			functionConn.Close 
		ELSE
			Print_campaign=Request(fieldkey)
		END IF

	END FUNCTION

	'-------------------------------------------

%>