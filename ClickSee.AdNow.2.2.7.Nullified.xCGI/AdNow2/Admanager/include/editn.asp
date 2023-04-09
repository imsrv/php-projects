<SCRIPT LANGUAGE=vbscript RUNAT=Server>

	IF trim(Request.QueryString ("customerid"))=EMPTY THEN
		Response.Redirect "adcenter.asp"
	END IF

	
	'-------------------------------------------

	FUNCTION Show_note
	
		Dim functionConn
		Dim CompaniesRS
		Dim Notes
		
		SET functionConn=Server.CreateObject ("ADODB.Connection")
		functionConn.Open DSNad,uid,pwd

		QUERY="SELECT NOTES FROM companies "
		QUERY=QUERY&"WHERE customerid=" & Request.QueryString ("customerid")
		SET companiesRS=Server.CreateObject ("ADODB.Recordset")
		companiesRS.Open QUERY,functionConn,1,3
		
		IF NOT companiesRS.EOF THEN
			Notes=decode(companiesRS(0))
			IF Trim(companiesRS(0))<>EMPTY AND trim(lcase(companiesRS(0)))<>"null" THEN
				Show_note=Notes
			END IF
		END IF
		
		companiesRS.Close
		functionConn.Close
		
	END FUNCTION

	'-------------------------------------------

	FUNCTION Print_Note
	
		Dim functionConn
		Dim CompaniesRS
		Dim Notes

		SET functionConn=Server.CreateObject ("ADODB.Connection")
		functionConn.Open DSNad,uid,pwd

		QUERY="SELECT NOTES FROM companies "
		QUERY=QUERY&"WHERE customerid=" & Request.QueryString ("customerid")
		SET companiesRS=Server.CreateObject ("ADODB.Recordset")
		companiesRS.Open QUERY,functionConn,1,3
		
		IF NOT companiesRS.EOF THEN
			Notes=decode(companiesRS(0))
			IF Trim(companiesRS(0))<>EMPTY AND trim(lcase(companiesRS(0)))<>"null" THEN
				Print_Note=Notes
			END IF
		END IF
		
		companiesRS.Close
		functionConn.Close
		
	END FUNCTION

	'-------------------------------------------

</SCRIPT>
