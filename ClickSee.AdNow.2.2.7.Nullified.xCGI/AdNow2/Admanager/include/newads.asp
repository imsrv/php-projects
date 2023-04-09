<!--#Include File="../../Data_Connection/Connection.asp"-->
<SCRIPT LANGUAGE=vbscript RUNAT=Server>

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modIFed 8/3/200
	'-------------------------------------------
IF Request("customerid") <> EMPTY THEN
	'Set session.
	Session("adname")=request("adname")
	Session("imageurl")=request("imageurl")
	Session("url")=request("url")
	Session("location")=request("location")
	Session("textmessage")=request("textmessage")
	Session("status")=request("status")
	Session("Datestart")=request("DateStart")
	Session("dateend")=request("dateend")
	'change format date
	dateend=request.form("dateend")
	tmpM= Mid(dateend,1,2)
	tmpD= Mid(dateend,4,2)
	tmpY= Mid(dateend,7,4)
	dateend=tmpY&tmpM&tmpD
	
	datestart=Request.Form ("DateStart")
	tmpM= Mid(datestart,1,2)
	tmpD= Mid(datestart,4,2)
	tmpY= Mid(datestart,7,4)
	datestart=tmpY&tmpM&tmpD

	Session("clickex")=Request("clickex")
	Session("imp")=request("imp")
	Session("Weight")=request("Weight")
	Session("IMAGEwidth")=request("IMAGEwidth")
	Session("IMAGEheight")=request("IMAGEheight")
	Session("IMAGEborder")=request("IMAGEborder")
	Session("ImageALT")=request("ImageALT")
	Session("adtarget") = request("adtarget")
	
	'	Check Ad Name
	IF trim(Request.Form ("adname"))=EMPTY THEN
	
		Session("MSG")="Please enter Ad Name."
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")
		
	'	Check Link to URL
	ELSEIF trim(Request.Form("url"))=EMPTY THEN
	
		Session("MSG")="Please enter link to URL."
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")
		
	'	Check status
	ELSEIF trim(Request.Form ("status"))=EMPTY THEN
	
		Session("MSG")="Please select status."
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")
		
	'	Check Location
	ELSEIF trim(Request.Form ("location"))=EMPTY THEN
	
		Session("MSG")="Please enter location."
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")
		
	'	Check Date Start
	ELSEIF trim(Request.Form ("DateStart"))=EMPTY THEN
	
		Session("MSG")="Please enter Date Start."
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")

	'	Check Type Date Start
	ELSEIF NOT isDate(Request.Form ("DateStart")) THEN

		Session("MSG")="Please enter type date in ""Date Start""."
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")

	'	Check "Date End" and "Click Expire" and "Impressions"
	ELSEIF trim(request("dateend"))=EMPTY And trim(request("imp"))=EMPTY And trim(request("clickex"))=EMPTY THEN
	
		Session("MSG")="Please enter ""Date End"" or ""Click Expire"" or ""Imp Purchased""."
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")
		
	'	Check "Date End" and "Click Expire" and "Impressions"
	ELSEIF trim(request("dateend"))<>EMPTY And trim(request("imp"))<>EMPTY And trim(request("clickex"))<>EMPTY THEN
	
		Session("MSG")="Please ether ""Date End"" or ""Click Expire"" or ""Imp Purchased""."
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")
		
	'	Check type date for "Date End"
	ELSEIF Not Isdate(request("dateend")) and request("imp")=EMPTY and request("clickex")=EMPTY THEN
	
		Session("MSG")="Please enter date in ""Date End"" box"
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")
		
	'	Check valid date for "Date End"
	ELSEIF Len(request("dateend")) <> 10 and request("imp")=EMPTY and request("clickex")=EMPTY THEN
	
		Session("MSG")="Please enter date in ""Date End"" box"
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")
	
	'	Check type numeric for "Click Expire"
	ELSEIF Not Isnumeric(request("clickex")) and request("dateend")=EMPTY and request("imp")=EMPTY THEN
	
		Session("MSG")="Please enter numeric in ""Click Expire"" box"
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")
		
	'	Check type numeric for "Impressions"
	ELSEIF Not Isnumeric(request("imp")) and request("dateend")=EMPTY and request("clickex")=EMPTY THEN
	
		Session("MSG")="Please enter numeric in ""Impressions"" box"
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")
		
	END IF	
	
	
	IF trim(Request.Form ("imp"))=EMPTY THEN
		impression=0
	ELSE
		impression=Request.Form ("imp")
	END IF
	
	IF trim(Request("ClickEx"))=EMPTY THEN
		ClickExpire=0
	ELSE
		ClickExpire=Request("clickex")
	END IF
	
	QUERY="insert into ad_data("
	QUERY=QUERY&"campaignid,customerid,adweight,"
	QUERY=QUERY&"adwidth,adheight,adborder,"
	QUERY=QUERY&"AdName,ImageURL,Alt,"
	QUERY=QUERY&"Url,Target,TextMsg,"
	QUERY=QUERY&"Status,DateEnd,"
	QUERY=QUERY&"clickexpire,"
	QUERY=QUERY&"ImpressionsPurchased,DateStart,adTarget)"
	QUERY=QUERY&" Values (" & Request ("campaignid")+0 & ","& Request("customerid")+0 &",'"

	'	Check adweight
	IF trim(Request.Form ("Weight"))<>EMPTY THEN
		QUERY=QUERY&encode(Request.Form ("Weight")) & "','"
	ELSE
		QUERY=QUERY&(Request.Form ("Weight")) & "','"
	END IF
	
	'	Check adwidth
	IF trim(Request.Form ("IMAGEwidth"))<>EMPTY THEN
		QUERY=QUERY&encode(Request.Form ("IMAGEwidth")) & "','"
	ELSE
		QUERY=QUERY&(Request.Form ("IMAGEwidth")) & "','"
	END IF
	
	'	Check adheight
	IF trim(Request.Form ("IMAGEheight"))<>EMPTY THEN
		QUERY=QUERY&encode(Request.Form ("IMAGEheight")) & "','"
	ELSE
		QUERY=QUERY&(Request.Form ("IMAGEheight")) & "','"
	END IF
	
	'	Check adborder
	IF trim(Request.Form ("IMAGEborder"))<>EMPTY THEN
		QUERY=QUERY&encode(Request.Form ("IMAGEborder")) & "','"
	ELSE
		QUERY=QUERY&(Request.Form ("IMAGEborder")) & "','"
	END IF
	
	'	Check AdName
	IF trim(Request.Form ("adname"))<>EMPTY THEN
		QUERY=QUERY&encode(Request.Form ("adname")) & "','"
	ELSE
		QUERY=QUERY&(Request.Form ("adname")) & "','"
	END IF
	
	'	Check ImageURL
	IF trim(Request.Form ("imageurl"))<>EMPTY THEN
		QUERY=QUERY&encode(Request.Form ("imageurl")) & "','"
	ELSE
		QUERY=QUERY&(Request.Form ("imageurl")) & "','"
	END IF
	
	'	Check Alt
	IF trim(Request.Form ("ImageALT"))<>EMPTY THEN
		QUERY=QUERY&encode(Request.Form ("ImageALT")) & "','"
	ELSE
		QUERY=QUERY&(Request.Form ("ImageALT")) & "','"
	END IF
	
	'	Check Url
	IF trim(Request.Form ("url"))<>EMPTY THEN
		QUERY=QUERY&encode(Request.Form ("url")) & "','"
	ELSE
		QUERY=QUERY&(Request.Form ("url")) & "','"
	END IF
	
	'	Check Target
	IF trim(Request.Form ("location"))<>EMPTY THEN
		QUERY=QUERY&encode(Request.Form ("location")) & "','"
	ELSE
		QUERY=QUERY&(Request.Form ("location")) & "','"
	END IF
	
	'	Check TextMsg
	IF trim(Request.Form ("textmessage"))<>EMPTY THEN
		QUERY=QUERY&encode(Request.Form ("textmessage")) & "','"
	ELSE
		QUERY=QUERY&(Request.Form ("textmessage")) & "','"
	END IF
	
	'	Check Status
	IF trim(Request.Form ("status"))<>EMPTY THEN
		QUERY=QUERY&(Request.Form ("status")) & "',"
	ELSE
		QUERY=QUERY&(Request.Form ("status")) & "',"
	END IF
	
	'	Check DateEnd
	IF trim(Request.Form ("dateend"))<>EMPTY THEN
		QUERY=QUERY&"'"&trim(dateend) & "','"
	ELSE
		QUERY=QUERY&"Null,'"
	END IF
	
	QUERY=QUERY&clickexpire& "','"
	QUERY=QUERY&impression & "','"
	
	'	Check DateStart
	IF trim(datestart)<>EMPTY THEN
		QUERY=QUERY&trim(datestart) & "',"
	ELSE
		QUERY=QUERY&year(date()) & month(date()) & day(date()) & "',"
		
	END IF
	
	IF trim(Request.Form("adtarget"))<> EMPTY THEN
		QUERY = QUERY & "'"&encode(Request.Form("adtarget")) & "')"
	ELSE
		QUERY=QUERY&" Null)"
	END IF
	
	'Insert in DB.
	IF NOT isobject(adnowConn) THEN
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
	END IF
	adnowConn.Execute (QUERY)

	'Clear session.
	Session("adname")=abandon
	Session("imageurl")=abandon
	Session("url")=abandon
	Session("location")=abandon
	Session("textmessage")=abandon
	Session("status")=abandon
	Session("Date_start")=abandon
	Session("dateend")=abandon
	Session("imp")=abandon
	Session("Weight")=abandon
	Session("IMAGEwidth")=abandon
	Session("IMAGEheight")=abandon
	Session("IMAGEborder")=abandon
	Session("ImageALT")=abandon
	Session("adtarget") = abandon

	IF Request.Form ("Continute")<>EMPTY THEN
		Response.Redirect "../ads.asp?" & Request.ServerVariables ("QUERY_STRING")

	ELSEIF Request.Form ("Finish")<>EMPTY THEN
		IF Request.QueryString ("BURL")<>EMPTY THEN
			EndSession
			Response.Redirect "../"&decode(Request.QueryString ("BURL"))
		ELSE
			EndSession
			Response.Redirect "../adcenter.asp"
		END IF
	ELSE
		EndSession
		Response.Redirect "../adcenter.asp"
END IF

ELSE
	EndSession
	Response.Redirect "../default.asp"
END IF

	'-------------------------------------------

</SCRIPT>
