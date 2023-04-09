<!--#Include File="../../Data_Connection/Connection.asp"-->
<SCRIPT LANGUAGE=vbscript RUNAT=Server>

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------
	
	IF instr(Request.Form,"Finish")<>EMPTY THEN

	adid = request("adid")
	sql = "select CampaignID, CustomerID from ad_data where AdID = "&adid&""
	set foundad = adnowConn.execute(sql)
	campaignid = foundad("CampaignID")
	customerid = foundad("CustomerID")
	foundad.close

	
		'	Check Ad Name
		IF trim(Request.Form ("adname"))=EMPTY THEN
			Session("MSG")="Please enter Ad Name."
		'	Check Link to URL
		ELSEIF trim(Request.Form("URL"))=EMPTY THEN
			Session("MSG")="Please enter link to URL."
		'	Check status
		ELSEIF trim(Request.Form ("status"))=EMPTY THEN
			Session("MSG")="Please select status."
		'	Check Location
		ELSEIF trim(Request.Form ("target"))=EMPTY THEN
			Session("MSG")="Please enter location."

		'	Check Date Start
		ELSEIF trim(Request.Form ("DateStart"))=EMPTY THEN
			Session("MSG")="Please enter Date Start."

		ELSEIF NOT isDate(Request.Form ("DateStart")) THEN
			Session("MSG")="Please enter type date in ""Date Start""."
		'	Check "Date End" and "Click Expire" and "Impressions"

		ELSEIF trim(request("dateend"))=EMPTY And trim(request("impressionsPurchased"))=EMPTY And trim(request("clickexpire"))=EMPTY THEN
			Session("MSG")="Please enter ""Date End"" or ""Click Expire"" or ""Imp Purchased""."
		'	Check "Date End" and "Click Expire" and "Impressions"

		ELSEIF trim(request("dateend"))<>EMPTY And trim(request("impressionsPurchased"))<>EMPTY And trim(request("clickexpire"))<>EMPTY THEN
			Session("MSG")="Please ether ""Date End"" or ""Click Expire"" or ""Imp Purchased""."
		'	Check type date for "Date End"

		ELSEIF Not Isdate(request("dateend")) and request("impressionsPurchased")=EMPTY and request("clickexpire")=EMPTY THEN
			Session("MSG")="Please enter date in ""Date End"" box"
		'	Check type numeric for "Click Expire"

		ELSEIF Not Isnumeric(request("clickexpire")) and request("dateend")=EMPTY and request("impressionsPurchased")=EMPTY THEN
			Session("MSG")="Please enter numeric in ""Click Expire"" box"
		'	Check type numeric for "Impressions"

		ELSEIF Not Isnumeric(request("impressionsPurchased")) and request("dateend")=EMPTY and request("clickexpire")=EMPTY THEN
			Session("MSG")="Please enter numeric in ""Impressions"" box"
		END IF	
		
		IF trim(Session("MSG"))=EMPTY THEN

			IF trim(Request.Form ("impressionsPurchased"))=EMPTY THEN
				impression=0
			ELSE
				impression=Request.Form ("impressionsPurchased")
			END IF
	
			IF trim(Request("clickexpire"))=EMPTY THEN
				ClickExpire=0
			ELSE
				ClickExpire=Request("clickexpire")
			END IF

		
		QUERY="insert into ad_data("
		QUERY=QUERY&"campaignid,customerid,adweight,"
		QUERY=QUERY&"adwidth,adheight,adborder,"
		QUERY=QUERY&"AdName,ImageURL,Alt,"
		QUERY=QUERY&"Url,Target,TextMsg,"
		QUERY=QUERY&"Status,DateEnd,"
		QUERY=QUERY&"clickexpire,"
		QUERY=QUERY&"ImpressionsPurchased,DateStart,adTarget)"
		QUERY=QUERY&" Values (" & campaignid+0 & ","& customerid+0 &",'"
	'	Check adweight
		IF trim(Request.Form ("adWeight"))<>EMPTY THEN
			QUERY=QUERY&encode(Request.Form ("adWeight")) & "','"
		ELSE
			QUERY=QUERY&(Request.Form ("adWeight")) & "','"
		END IF
	
	'	Check adwidth
		IF trim(Request.Form ("adwidth"))<>EMPTY THEN
			QUERY=QUERY&encode(Request.Form ("adwidth")) & "','"
		ELSE
			QUERY=QUERY&(Request.Form ("adwidth")) & "','"
		END IF
	
	'	Check adheight
		IF trim(Request.Form ("adheight"))<>EMPTY THEN
			QUERY=QUERY&encode(Request.Form ("adheight")) & "','"
		ELSE
			QUERY=QUERY&(Request.Form ("adheight")) & "','"
		END IF
	
	'	Check adborder
		IF trim(Request.Form ("adborder"))<>EMPTY THEN
			QUERY=QUERY&encode(Request.Form ("adborder")) & "','"
		ELSE
			QUERY=QUERY&(Request.Form ("adborder")) & "','"
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
		IF trim(Request.Form ("ALT"))<>EMPTY THEN
			QUERY=QUERY&encode(Request.Form ("ALT")) & "','"
		ELSE
			QUERY=QUERY&(Request.Form ("ALT")) & "','"
		END IF
		
	'	Check Url
		IF trim(Request.Form ("URL"))<>EMPTY THEN
			QUERY=QUERY&encode(Request.Form ("URL")) & "','"
		ELSE
			QUERY=QUERY&(Request.Form ("URL")) & "','"
		END IF
	
	'	Check Target
		IF trim(Request.Form ("target"))<>EMPTY THEN
			QUERY=QUERY&encode(Request.Form ("target")) & "','"
		ELSE
			QUERY=QUERY&(Request.Form ("target")) & "','"
		END IF
		
	'	Check TextMsg
		IF trim(Request.Form ("textmsg"))<>EMPTY THEN
			QUERY=QUERY&encode(Request.Form ("textmsg")) & "','"
		ELSE
			QUERY=QUERY&(Request.Form ("textmsg")) & "','"
		END IF
		
	'	Check Status
		IF trim(Request.Form ("status"))<>EMPTY THEN
			QUERY=QUERY&encode(Request.Form ("status")) & "',"
		ELSE
			QUERY=QUERY&(Request.Form ("status")) & "',"
		END IF
	
	'	Check DateEnd
		IF trim(Request.Form ("dateend"))<>EMPTY THEN
			QUERY=QUERY&"'"&ConvDate(Request.Form ("dateend")) & "','"
		ELSE
			QUERY=QUERY&" NULL ,'"
		END IF
	
		QUERY=QUERY&ClickExpire& "','"
		QUERY=QUERY&impression & "','"
	
	'	Check DateStart
		IF trim(Request.Form ("datestart"))<>EMPTY THEN
			QUERY=QUERY&ConvDate(Request.Form ("datestart"))+0&"'"
		ELSE
			QUERY=QUERY&decode(Year(Date()))&Month(Date())&Day(Date())+0&"'"
		END IF

		IF trim(Request.Form("adtarget"))<> EMPTY THEN
			QUERY = QUERY & ",'"&encode(Request.Form("adtarget")) & "')"
		ELSE
			QUERY=QUERY&",Null)"
		END IF

			adnowConn.Execute (Query)
			Session("MSG")="Clone Successful"
		IF trim(Request.QueryString ("BURL"))<>EMPTY THEN
			Response.Redirect "../"&decode(Request.QueryString ("BURL"))
		ELSE
			Response.Redirect "../adcenter.asp"
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
	
	FUNCTION Print_ad (ByVal fieldkey,ByVal adid)

		Dim str
		Dim Query
		Dim adsRS

		IF Request.QueryString("adid")=EMPTY THEN
			Response.Redirect "../adcenter.asp"
		END IF	
	
		IF trim(Request.Form (fieldkey))=EMPTY THEN
			Query="SELECT * FROM ad_data " &_
						  "WHERE adid=" & adid

			IF NOT isobject(functionConn) THEN
				SET functionConn=Server.CreateObject ("ADODB.Connection")
				functionConn.Open DSNad,uid,pwd
			END IF

			SET adsRS=Server.CreateObject ("ADODB.Recordset")
			adsRS.Open Query,functionConn,1,3
	
			IF NOT adsRS.EOF THEN
				str=adsRS(fieldkey)
				Print_ad=addVar (str)
			END IF
		
			adsRS.Close 
			functionConn.Close 
		ELSE
			Print_ad=Request.Form (fieldkey)
		END IF

	END FUNCTION

	'-------------------------------------------
	
	FUNCTION ConvDate (ByVal Str)
		IF LEN(Str)=10 THEN
			ConvDate=Mid(Str,7,4)&Mid(Str,1,2)&Mid(Str,4,2)
		ELSE
			ConvDate=decode(Year(Date()))&Month(Date())&Day(Date())
		END IF
	END FUNCTION
	
	'-------------------------------------------

</SCRIPT>
