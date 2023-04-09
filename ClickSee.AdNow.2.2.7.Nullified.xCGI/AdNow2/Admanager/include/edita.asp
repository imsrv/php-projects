<!--#Include File="../../Data_Connection/Connection.asp"-->
<%
	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------
	
	IF instr(Request.Form,"Finish")<>EMPTY THEN
		Dim Query
		Dim dateend
		Dim tmpM
		Dim tmpD
		Dim tmpY
		
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
	
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
			
			IF lcase(Request.Form ("Status"))<>"expired" THEN
				QUERY="UPDATE ad_data SET Actualenddate = NULL "
				QUERY=QUERY&"WHERE adid="&(Request("adid"))
				adnowConn.Execute (Query)
			END IF
			
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
			
			Query="Update [ad_data] Set [adweight]=" & Request.Form ("adweight") + 0
			IF trim(Request.Form ("adwidth"))<>EMPTY THEN
			Query=Query & ", [adwidth]='" & (Request.Form ("adwidth")) & "'"
			ELSE
			Query=Query & ", [adwidth]= null"
			END IF
			IF trim(Request.Form ("adheight"))<>EMPTY THEN
			Query=Query & ", [adheight]='" & (Request.Form ("adheight")) & "'"
			ELSE
			Query=Query & ", [adheight]= null"
			END IF
			IF trim(Request.Form ("adborder"))<>EMPTY THEN
			Query=Query & ", [adborder]='" & (Request.Form ("adborder")) & "'"
			ELSE
			Query=Query & ", [adborder]= null"
			END IF
			Query=Query & ", [AdName]='" & encode(Request.Form ("AdName")) & "'"
			IF trim(Request.Form ("ImageURL"))<>EMPTY THEN
			Query=Query & ", [ImageURL]='" & encode(Request.Form ("ImageURL")) & "'"
			ELSE
			Query=Query & ", [ImageURL]= null"
			END IF
			IF trim(Request.Form ("Alt"))<>EMPTY THEN
			Query=Query & ", [Alt]='" & encode(Request.Form ("Alt")) & "'"
			ELSE
			Query=Query & ", [Alt]= null"
			END IF
			Query=Query & ", [Url]='" & encode(Request.Form ("Url")) & "'"
			Query=Query & ", [Target]='" & encode(Request.Form ("Target")) & "'"
			IF trim(Request.Form ("TextMsg"))<>EMPTY THEN
			Query=Query & ", [TextMsg]='" & encode(Request.Form ("TextMsg")) & "'"
			ELSE
			Query=Query & ", [TextMsg]= null"
			END IF
			Query=Query & ", Status='" & (Request.Form ("Status")) & "'"
			IF Trim(Request.Form ("DateEnd"))<>EMPTY THEN
			Query=Query & ", [DateEnd]='" & (DateEnd)& "'"
			ELSE
			Query=Query & ", [DateEnd]= null"
			END IF
			IF trim(Request.Form ("clickexpire"))<>EMPTY THEN
			Query=Query & ", [clickexpire]=" & Request.Form ("clickexpire") + 0
			ELSE
			Query=Query & ", [clickexpire]= 0"
			END IF
			IF trim(Request.Form ("ImpressionsPurchased"))<>EMPTY THEN
			Query=Query & ", [ImpressionsPurchased]=" & Request.Form ("ImpressionsPurchased") + 0
			ELSE
			Query=Query & ", [ImpressionsPurchased]= 0"
			END IF
            IF Trim(Request.Form ("DateStart"))<>EMPTY THEN
			Query=Query & ", [DateStart]='" & (datestart) & "'"
			ELSE
			Query=Query & ", [DateStart]= null"
			END IF

			IF trim(Request.form("adtarget"))<>EMPTY THEN
			  Query = Query & ", [adTarget]='"& encode(Request.Form("adtarget"))&"'"
			ELSE
			  Query = Query & ", [adTarget]= null"
			END IF
			
			Query=Query & " Where [adid]=" & 0+(Request ("adid"))
			adnowConn.Execute (Query)
			Session("MSG")="Update Successful"
			
			Response.Redirect "stats_detail.asp?" & Request.ServerVariables ("Query_String")
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

		Dim Query
		Dim functionConn
		Dim adsRS
		Dim Str
		
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
				Str=adsRS(fieldkey)
				IF Trim(Str)<>EMPTY THEN
				Print_ad=addVar (Str)
				ELSE
				Print_ad=""
				END IF
			END IF
		
			adsRS.Close 
			functionConn.Close 
		ELSE
			Print_ad=""
		END IF

	END FUNCTION

	'-------------------------------------------

%>