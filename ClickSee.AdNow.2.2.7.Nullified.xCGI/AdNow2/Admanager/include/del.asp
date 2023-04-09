<!--#Include File="../../Data_Connection/Connection.asp"-->
<%
	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/200
	'-------------------------------------------

	SET adnowConn=Server.CreateObject ("ADODB.Connection")
	adnowConn.Open DSNad,uid,pwd

	IF Request.ServerVariables ("CONTENT_LENGTH")<>0 _
	AND Instr(Request.ServerVariables ("PATH_INFO"),"delcompany.asp")<>0 _
	AND trim(Request.QueryString ("customerid"))<>EMPTY _
	AND isnumeric(Request.QueryString ("customerid")) THEN
	
		bb
		QUERY = "Delete From ad_data "
		QUERY = QUERY & " Where customerid = " & Request.QueryString("customerid")
		adnowConn.Execute (QUERY)
		
		QUERY = "Delete From campaign "
		QUERY = QUERY & " Where customerid = "&Request.QueryString("customerid")
		adnowConn.Execute (QUERY)
		
		QUERY = "Delete From companies "
		QUERY = QUERY & " Where CustomerID = "&Request.QueryString("customerid")
		adnowConn.Execute (QUERY)

		Response.Redirect decode(Request.QueryString ("BURL"))
	
	ELSEIF Request.ServerVariables ("CONTENT_LENGTH")<>0 _
	AND Instr(Request.ServerVariables ("PATH_INFO"),"delcampaign.asp")<>0  _
	AND trim(Request.QueryString ("campaignid"))<>EMPTY _
	AND isnumeric(Request.QueryString ("campaignid")) THEN

		bb
		QUERY="DELETE FROM campaign "
		QUERY=QUERY & "WHERE campaignid=" & Request.QueryString ("campaignid")
		adnowConn.Execute (QUERY)
		
		QUERY="DELETE FROM ad_data "
		QUERY=QUERY & "WHERE campaignid=" & Request.QueryString ("campaignid")

'		QUERY=QUERY & "WHERE campaignid not in "
'		QUERY=QUERY & "(SELECT distinct(campaignid) FROM campaign)"
		adnowConn.Execute (QUERY)

		Response.Redirect decode(Request.QueryString ("BURL"))

	ELSEIF Request.ServerVariables ("CONTENT_LENGTH")<>0 _
	AND Instr(Request.ServerVariables ("PATH_INFO"),"delad.asp")<>0 _
	AND trim(Request.QueryString ("adid"))<>EMPTY _
	AND isnumeric(Request.QueryString ("adid")) THEN
	
		bb
		QUERY="DELETE FROM ad_data "
		QUERY=QUERY & "WHERE adid=" & Request.QueryString ("adid")
		adnowConn.Execute (QUERY)
		
		Response.Redirect decode(Request.QueryString ("BURL"))
	END IF
	
	'-------------------------------------------
	
	SUB bb
	
		IF Request("NO")<>EMPTY THEN
			Response.Redirect decode(Request("BURL"))
		END IF
	
	END SUB
	
	'-------------------------------------------
	
%>