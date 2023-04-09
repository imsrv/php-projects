<!--#Include File="../../Data_Connection/Connection.asp"-->
<SCRIPT LANGUAGE=vbscript RUNAT=Server>

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------
	session("CName")=Request.Form("CompanyName")
	session("url")=Request.Form("T11")
	session("address1")=Request.Form("T2")
	session("address2")=Request.Form("T3")
	session("city")=Request.Form("T4")
	session("states")=Request.Form("T5")
	session("zip")=Request.Form("T6")
	session("country")=Request.Form("T7")
	session("phone")=Request.Form("T8")
	session("fax")=Request.Form("T9")
	session("contactname")=Request.Form("T10")
	session("contactemail")=Request.Form("T12")
	session("T13")=Request.Form("T13")
	session("T14")=Request.Form("T14")


	'	Check CompanyName
	If (Request.Form("CompanyName"))=empty Then
		Session("MSG")="Please enter companyname"
		Response.Redirect "../company.asp?" & Request.ServerVariables ("Query_String")
	'	Check user name
	Elseif (Request.Form ("T13"))=empty then
		Session("MSG")="Please enter user name"
		Response.Redirect "../company.asp?" & Request.ServerVariables ("Query_String")
	'	Check password
	ElseIf (Request.Form ("T14"))=empty then
		Session("MSG")="Please enter password"
		Response.Redirect "../company.asp?" & Request.ServerVariables ("Query_String")
	End If

	
									'	Check username already
	Set Rs=adnowConn.Execute ("Select * From Companies Where CompanyUserName=('" & encode(Request.Form("T13")) & "') Order by CustomerID Desc")
	If Not Rs.EOF Then
		session("msg")="There is someone already use this name. Please select a new UserName."
		Response.Redirect "../company.asp?" & Request.ServerVariables ("Query_String")
	End If
	Rs.close
									'	Insert Company
	Query="Insert into Companies"
	Query = Query & "(CompanyName,CompanyURL,CompanyAddress1,CompanyAddress2,"
	Query = Query & "CompanyCity,CompanyState,CompanyPostalCode,CompanyCountry,"
	Query = Query & "CompanyPhoneVoice,CompanyPhoneFax,ContactName,ContactEmail,"
	Query = Query & "CompanyUserName,CompanyPassword,CustomerSince,IReport,DReport,LastSend) Values"
	Query = Query & " ('" & encode(Request.Form("CompanyName")) &"',"
	Query = Query & " '" & encode(Request.Form("T11")) & "','" & encode(Request.Form("T2")) & "',"
	Query = Query & "'" & encode(Request.Form("T3")) & "','" & encode(Request.Form("T4")) & "',"
	Query = Query & "'" & encode(Request.Form("T5")) & "','" & encode(Request.Form("T6")) & "',"
	Query = Query & "'" & encode(Request.Form("T7")) & "','" & encode(Request.Form("T8")) & "','"
	Query = Query & "" & encode(Request.Form("T9")) & "','" & encode(Request.Form("T10")) & "',"
	Query = Query & "'" & encode(Request.Form("T12")) & "','" & encode(Request.Form("T13")) & "',"
	Query = Query & "'" & encode(Request.Form("T14")) & "','" & month(Date())&"/"&day(date())&"/"&year(date()) & "'"
	Query = Query & ",NULL,NULL,NULL "
	Query = Query & ")"
	adnowConn.Execute (Query)
	
	session("CName")=abandon
	session("url")=abandon
	session("address1")=abandon
	session("address2")=abandon
	session("city")=abandon
	session("states")=abandon
	session("zip")=abandon
	session("country")=abandon
	session("phone")=abandon
	session("fax")=abandon
	session("contactname")=abandon
	session("contactemail")=abandon
	session("T13")=abandon
	session("T14")=abandon

	
									'	Go to add ad
	QUERY="SELECT customerid FROM companies "
	QUERY=QUERY&"WHERE companyusername='" & encode(Request.Form("T13")) & "'"
	SET RS=Server.CreateObject ("ADODB.Recordset")
	RS.Open QUERY,adnowConn,1,3
	IF Request("next")<>EMPTY THEN
		Response.Redirect "../campaign.asp?customerid=" & RS("customerid") & "&" & Request.ServerVariables ("Query_String")
	ELSEIF Request("BURL")<>EMPTY AND Request("finish")<>EMPTY THEN
		Response.Redirect "../"&decode(Request("BURL"))
	ELSE
		Response.Redirect "../adcenter.asp"
	END IF
	'-------------------------------------------
</SCRIPT>
