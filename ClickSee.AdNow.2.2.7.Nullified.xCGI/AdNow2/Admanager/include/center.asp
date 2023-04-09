<!--#Include File="../../Data_Connection/Connection.asp"-->
<%

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------
	SUB bringTarget
		Dim conn
		Dim Query
		Dim Count
		Dim DisTarget
		
	    Set conn=server.CreateObject ("ADODB.Connection")
	    Conn.Open DsNAd,uid,pwd
		Query="Select Distinct Target From ad_data Where Status='Active' " 
		
		Set DisTarget=Conn.Execute(Query)
		Count=0
		Do While Not DisTarget.EOF
			Count=Count+1
			response.write "<option value="&DisTarget("Target")&">"&DisTarget("Target")
		DisTarget.MoveNext
		Loop
		DisTarget.Close
	END SUB	


	'-------------------------------------------
	'This procedure list all company in base.
	
	SUB ListComopany

		Dim Query
		Dim CompanyRS
		
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd

		Query="SELECT CustomerID,CompanyName FROM companies "
		
		SET CompanyRS=Server.CreateObject ("ADODB.Recordset")
		CompanyRS.Open Query,adnowConn,1,3
		
		DO WHILE NOT CompanyRS.EOF
			PrintLn ("<OPTION VALUE=""" & CompanyRS("CustomerID") & """>" & decode(CompanyRS("CompanyName")) & "</OPTION>")
			CompanyRS.MoveNext 
		LOOP
		CompanyRS.Close 

	END SUB

	'-------------------------------------------
	'This procedure list all ad in base.
	
	SUB ListAds

		Dim QUERY
		Dim AdsRS
		
		Query="SELECT DISTINCT(Target) FROM ad_data "
		SET AdsRS=Server.CreateObject ("ADODB.Recordset")
		AdsRS.Open Query,adnowConn,1,3
		DO WHILE NOT AdsRS.EOF
			PrintLn ("<OPTION VALUE=""" & AdsRS("Target") & """>" & decode(AdsRS("Target")) & "</OPTION>")
			AdsRS.MoveNext 
		LOOP
		AdsRS.Close 
	
	END SUB

	'-------------------------------------------
	
	FUNCTION CheckRecord

		Dim QUERY
		Dim CompanyRS
		
		Query="SELECT customerid FROM companies "
		SET CompanyRS=Server.CreateObject ("ADODB.Recordset")
		CompanyRS.Open Query,adnowConn,1,3
		
		IF CompanyRS.EOF THEN
			CheckRecord=False
		ELSE
			CheckRecord=True
		END IF
		CompanyRS.Close
		
	END FUNCTION
	
%>