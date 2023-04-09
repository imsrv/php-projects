<!--#Include File="../../Data_Connection/Connection.asp"-->
<SCRIPT LANGUAGE=vbscript RUNAT=Server>

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modIFed 8/3/200
	'-------------------------------------------

IF Request ("customerid")<>EMPTY THEN
	IF isnumeric(Request ("customerid")) THEN
		IF trim(Request.Form ("notes"))<>EMPTY THEN
			Note=" [notes]='" & encode (Request.Form ("notes")) & "'"
		ELSE
			Note=" [notes] = null"
		END IF

		QUERY="UPDATE companies SET " & Note
		QUERY=QUERY&" WHERE customerid=" & Request ("customerid")
	
		'Note Execute.
		adnowConn.Execute (QUERY)

		EndSession
	
		IF Request.QueryString ("BURL")<>EMPTY THEN
			Response.Redirect "../"&decode(Request.QueryString ("BURL"))
		ELSE
			Response.Redirect "../adcenter.asp"
		END IF
		
	ELSE
		EndSession
		Response.Redirect "../default.asp"
	END IF
	
ELSE
	EndSession
	Response.Redirect "../default.asp"
END IF

	'-------------------------------------------

</SCRIPT>
