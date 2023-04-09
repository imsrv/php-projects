<!--#Include File="../../Data_Connection/Connection.asp"-->
<SCRIPT LANGUAGE=vbscript RUNAT=Server>

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/200
	'-------------------------------------------

	IF Request.Form ("customerid")=EMPTY THEN
		Response.Redirect "../adcenter.asp"
	END IF

	session("campaignname")=Request.Form("campaignname")
	session("cdescription")=Request.Form("campaigndescription")

	
	'	Check CampaignName
	If (Request.Form("campaignname"))=empty Then
		Session("MSG")="Please enter Campaign Name"
		Response.Redirect "../campaign.asp?" & Request.ServerVariables ("Query_String")
	End If

	'	Check campaign already
	QUERY="SELECT * FROM campaign "
	QUERY=QUERY&"WHERE campaignname='" & encode(Request.Form ("campaignname")) & "' "
	QUERY=QUERY&"AND customerid=" & Request.Form ("customerid")
	
	SET RS=Server.CreateObject ("ADODB.Recordset")
	RS.Open QUERY,adnowConn,1,3

	If Not Rs.EOF Then
		Session("msg")="There is someone already use this name. Please select a new Campaign Name."
		Session("customerid")=Request.Form ("customerid")
		RS.Close 
		Response.Redirect "../campaign.asp?" & Request.ServerVariables ("Query_String")
	End If 
	Rs.close
	
	'	Insert Campaign
	QUERY="INSERT INTO campaign(campaignname,campaigndescription,customerid) "
	QUERY=QUERY&"VALUES "
	QUERY=QUERY&"('" & encode(Request.Form ("campaignname")) & "',"
	QUERY=QUERY&"'" & encode(Request.Form ("campaigndescription")) & "',"
	QUERY=QUERY&Request.Form ("customerid") &")"
	adnowConn.Execute (Query)

	session("campaignname")=abandon
	session("cdescription")=abandon
	
	'	Go to add ad
	QUERY="SELECT campaignID, customerID FROM campaign "
	QUERY=QUERY&"WHERE campaignname='" & encode(Request.Form ("campaignname")) & "' "
	QUERY=QUERY&"AND customerid=" & Request.Form ("customerid")
	
	SET RS=Server.CreateObject ("ADODB.Recordset")
	RS.Open QUERY,adnowConn,1,3

	IF Request.QueryString ("BURL")<>EMPTY THEN
		BURL=encode(Request.QueryString ("BURL"))
	ELSE
		BURL=""
	END IF
	
	IF Request("next")<>EMPTY THEN
		Response.Redirect "../ads.asp?campaignid=" & Rs("campaignid") & "&BURL=" & BURL &"&customerid="&Rs("customerid")
	ELSEIF Request("BURL")<>EMPTY AND Request("Finish")<>EMPTY THEN
		Response.Redirect "../"&decode(Request("BURL"))
	ELSE
		Response.Redirect "../adcenter.asp"
	END IF
	
	'-------------------------------------------

</SCRIPT>
