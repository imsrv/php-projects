<!--#include File="../Data_Connection/DSN_Connection.asp"-->

<%
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modify 10/17/2000


	'-------------------MAIN-------------------

	check_Expire_by_date
	Session("adOrder")=Abandon
	Check_mailserver_By_Date

	'-------------------END MAIN---------------
	
	'CHECK DATE EXPIRE			
	SUB check_Expire_by_date

		Dim QUERY
		Dim adnowConn
	
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
	
		QUERY="UPDATE ad_data SET status='Expired' "
		QUERY=QUERY&", Actualenddate = '"&(decode(year(date()))*10000)+(month(date())*100)+(day(date()))&"' "
		QUERY=QUERY&"WHERE dateend<>'' "
		QUERY=QUERY&"AND dateend is not null "
		QUERY=QUERY&"AND (status='Active' "
		QUERY=QUERY&"OR status='Hold%20to%20launch') "
		QUERY=QUERY&"AND (dateend+0)<="
		QUERY=QUERY&"("&(decode(year(date()))*10000)+(month(date())*100)+(day(date()))&") "

		adnowConn.Execute (Query)

		adnowConn.Close

	END SUB

	'------------------------------------------

	'CHECK FOR HOLD-TO-LAUNCH ADS
	SUB checkHold(ByVal Tarket)

		Dim adnowConn
		Dim QUERY
		
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
		  
		QUERY="UPDATE ad_data SET status='Active' "
		QUERY=QUERY&", Actualenddate=NULL "
		QUERY=QUERY&"WHERE status='Hold%20to%20launch' "
		QUERY=QUERY&"AND target='"&tarket&"' "
		QUERY=QUERY&"AND (DateStart+0)<="
		QUERY=QUERY&"("&(decode(year(date()))*10000)+(month(date())*100)+(day(date()))&") "
		  
		adnowConn.Execute(QUERY)

		adnowConn.close

	END SUB

	'--------------------------------------
	
	'ADD STATS TO THE DATABASE
	SUB AddStats(ByVal adid)


		Dim adnowConn
		Dim QUERY
		Dim ad_dataRS
		
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
		
		'CHECK STATS
		QUERY="SELECT * FROM [stats] "
		QUERY=QUERY&"WHERE adid="&adid+0&" "
		QUERY=QUERY&"AND datelog='"&month(date())&"/"&day(date())&"/"&year(date())&"' "
		
		SET CheckData=Server.CreateObject ("ADODB.Recordset")
		CheckData.Open QUERY,adnowConn,1,3
		
		'UPDATE IMPRESSIONS
		IF NOT CheckData.EOF THEN
			QUERY="UPDATE [stats] SET Impressions=Impressions+1 "
			QUERY=QUERY&"WHERE adid="&adid+0&" "
			QUERY=QUERY&"AND datelog='"&month(date())&"/"&day(date())&"/"&year(date())&"' "
		ELSE
			QUERY="INSERT INTO [stats](AdID,Datelog,Impressions,clicks) VALUES"
			QUERY=QUERY&"("&adid+0&","
			QUERY=QUERY&"'"&month(date())&"/"&day(date())&"/"&year(date())&"',"
			QUERY=QUERY&"1,0)"
		END IF

	IF uselist THEN
		IF usecheck THEN			
		adnowConn.Execute (QUERY)
		END IF
	ELSE
		adnowConn.Execute (QUERY)
	END IF

		'IMPRESSIONS FOR ADS THAT EXPIRED BY IMPRESSION PURCHASED
		QUERY="UPDATE ad_data SET Status=" & "'Expired'"
		QUERY=QUERY&", Actualenddate = '"&(decode(year(date()))*10000)+(month(date())*100)+(day(date()))&"' "
		QUERY=QUERY&"WHERE ImpressionsPurchased<="
		QUERY=QUERY&"(SELECT SUM(impressions) FROM [STATS] "
		QUERY=QUERY&"WHERE adid="&adid+0&") "
		QUERY=QUERY&"AND status='Active' "
		QUERY=QUERY&"AND ImpressionsPurchased is not null "
		QUERY=QUERY&"AND ImpressionsPurchased>0 "
		QUERY=QUERY&"AND adid="&adid+0&" "
		adnowConn.Execute (Query)
		
		QUERY="SELECT adid,customerid FROM ad_data "
		QUERY=QUERY&"WHERE adid="&adid
		
		SET ad_dataRS=Server.CreateObject ("ADODB.Recordset")
		ad_dataRS.open QUERY,adnowConn,1,3
		
		IF NOT ad_dataRS.EOF THEN
			'Check_mailserver_By_IMP ad_dataRS("customerid"),ad_dataRS("adid")
		END IF
		

		Application.Lock 
		Application(adid)=Application(adid)+1
		Application.UnLock 
		
		ad_dataRS.close
		adnowConn.Close
	
	END SUB
	
	'--------------------------------------
	
	'FIND RANDOM VALUE TO RANDOMLY SELECT THE AD
	FUNCTION RandomValue(ByVal Target)

		Dim adnowConn
		Dim QUERY
		Dim QUERY2
		Dim Rs
		Dim Value1
		Dim Value2
		Dim ID1
		Dim ID2
		Dim Comma
		
		Value1=0
		Value2=0
		ID1=0
		ID2=0
		
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd

		Set Rs=Server.CreateObject ("ADODB.RecordSet")
		Rs.CursorType = adOpendynamic
		  
		QUERY="SELECT a.* FROM ad_data a "
		QUERY=QUERY & "WHERE a.Target='" & Target & "' "
		QUERY=QUERY & "AND ( a.Status='Active' "
		
		'HOLD-TO-LAUNCH
		QUERY=QUERY & "OR (a.Status='Hold%20to%20launch' AND (DateStart+0)<="
		QUERY=QUERY & "("&(decode(year(date()))*10000)+(month(date())*100)+(day(date()))&") "
		QUERY=QUERY & ")  ) "
		
		IF Session("adOrder")<>EMPTY AND Session("Orderads") THEN
		QUERY2="AND a.adid NOT IN ("&Session("adOrder")&") "
		END IF		
		QUERY=QUERY & "AND ( (a.ImpressionsPurchased > "
		QUERY=QUERY & "(SELECT SUM(Impressions) FROM [STATS] "
		QUERY=QUERY & "WHERE adid=a.adid) ) "
		QUERY=QUERY & "OR (a.dateend<>'' "
		QUERY=QUERY & "AND a.dateend is not null "
		QUERY=QUERY & "AND (a.dateend+0)>"
		QUERY=QUERY & "("&(decode(year(date()))*10000)+(month(date())*100)+(day(date()))&") "
		QUERY=QUERY & " ) "
		QUERY=QUERY & "OR (a.clickExpire > (SELECT SUM(clicks) FROM [STATS] WHERE adid=a.adid) "
		QUERY=QUERY & "OR a.adid not in (SELECT distinct(adid) FROM [STATS]) ) ) "

		Rs.Open QUERY&QUERY2,adnowConn,1,3

		IF Rs.EOF THEN
			Rs.Close 
			Rs.Open QUERY,adnowConn,1,3
		END IF

		' CHECK WEIGHT
		IF NOT Rs.EOF THEN
			Do While Not Rs.EOF 
				IF (Application(RS("ADID"))<RS("adweight")) OR (RS("adweight")=0) OR Application(RS("ADID"))=EMPTY THEN
					Randomize
					Value2=Clng(Rnd*(Rnd*10000000))
					ID2=RS("ADID")
				
					IF Value2>Value1 THEN
						Value1=Value2
						ID1=ID2
					END IF
				END IF
				RS.MoveNext
			Loop
		END IF
		RS.Close 
		adnowConn.close
		
		IF Session("adOrder")<>EMPTY THEN
			Comma=","
		ELSE
			Comma=""
		END IF
		
		IF ID1<>EMPTY AND ID1>0 THEN
			RandomValue=ID1
			IF Session("Orderads") THEN
				Session("adOrder")=Session("adOrder")&Comma&ID1
			ENd IF
		ELSE
			RandomValue=ID2
			IF Session("Orderads") THEN
				Session("adOrder")=Session("adOrder")&Comma&ID2
			END IF
		END IF
		
	End FUNCTION

	'--------------------------------------

	'SET TEMP WEIGHT SUB
	SUB settempweight(byval target)
		
		DIM adnowConn
		Dim QUERY
		Dim CheckWeight
		Dim Countweight
		
		ClearCount=0
		AppClearCount=0
		
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
		
			
		QUERY="SELECT adid,adweight FROM Ad_data "
		QUERY=QUERY&"WHERE Target='" & Target & "' "
		QUERY=QUERY&"AND Status='Active'"

		SET CheckWeight=server.CreateObject ("ADODB.Recordset")
		CheckWeight.Open QUERY,adnowConn,1,3

		DO WHILE NOT CheckWeight.EOF
			ClearCount=ClearCount+1
			IF Application(CheckWeight("adid"))>=CheckWeight("adweight") THEN
				AppClearCount=AppClearCount+1
			END IF
			CheckWeight.moveNext
		LOOP
	
		IF ClearCount=AppClearCount AND ClearCount<>0 AND AppClearCount<>0 THEN
			CheckWeight.MoveFirst 
			DO WHILE NOT CheckWeight.EOF
				ClearApplication CheckWeight("adid")
				CheckWeight.moveNext
			LOOP
		END IF
		adnowConn.Close
	END SUB

	'-------------------------------------------
	'Clear Temp Weight
	SUB ClearApplication (ByVal str)
		Application(str)=0
	END SUB

	' --------------------------------------
	
	'CALLING FOR ADS
	SUB adnow(ByVal Target)
		IF Target<>EMPTY THEN
			Target = encode(Target)
		END IF
		Showads RandomValue(Target),Target
	END SUB

	' --------------------------------------
		
	'CALLING FOR ADS (ANTY SAME ADS)
	SUB adnowv2(ByVal Target)

		Session("Orderads")=TRUE
		IF Target<>EMPTY THEN
			Target = encode(Target)
		END IF
		Showads RandomValue(Target),Target
		Session("Orderads")=Abandon
		
	END SUB
		
	'-------------------------------------------

	SUB Showads(ByVal adid, ByVal Target)

		DIM adnowConn
		Dim QUERY
		Dim Ans
		Dim goHere
		Dim ranNumber
		Dim Img
		Dim Textmsg
		Dim ying
		
		' CHECK FOR HOLD-TO-LAUNCH ADS
		IF Target<>EMPTY THEN
			Target = encode(Target)
		END IF

		checkHold(Target)

		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
		
		QUERY="Select * From Ad_data Where AdID=" & adid
		Set Ans=adnowConn.Execute (QUERY)

		If Not Ans.EOF Then
		
		  Textmsg=(Ans("Textmsg"))
		  
		  If Trim(Ans("adTarget")) = empty then
		    goHere = "_self"
		  Else
		    goHere = decode(Ans("adTarget"))
		  End If
		  
		  IF trim(goHere)="null" THEN
			goHere="_self"
		  END IF

			' DISPLAY ADS' IMAGE		  
			If trim(Ans("ImageURL"))<>Empty Then
				Randomize
				ranNumber = Clng (Rnd * (Rnd*10000000))

				Response.Write "<A HREF="""&redirectLocation&"CSANV2_redirect.asp?D=" & month(Date())&"/"&day(date())&"/"&year(date()) &"&File=" & Ans("AdID") & "&round="&ranNumber&""" target="""&goHere&""">"
				Img="<IMG SRC=""" & decode(Ans("ImageURL")) &""""
				
				If trim(Ans("adwidth"))<>Empty Then
					Img=Img & " width=""" & decode(Ans("adwidth")) & """"							
				end If
				
				If trim(Ans("adheight"))<>Empty Then
					Img=Img & " height=""" & decode(Ans("adheight")) & """"
				end If
				
				If trim(Ans("adborder"))<>empty then
					Img=Img & " border=""" & decode(Ans("adborder")) & """"
				end If
				
				Img=Img & " Alt="""
				
				If trim(Ans("Alt"))<>Empty Then
					Img=Img & decode(Ans("Alt")) & """></A>"
				Else
					Img=Img & """></A>"
				End If						

				Response.Write Img
			End If

			IF Img<>EMPTY AND Textmsg<>EMPTY THEN
				Response.Write "<Br>"
			END IF

			' DISPLAY ADS' TEXT			
			If trim(Textmsg)<>Empty Then
				Randomize
				ranNumber = Clng (Rnd * (Rnd*10000000))
				
				QUERY = "SELECT * FROM stats "
				QUERY=QUERY&"WHERE AdID = "&Ans("AdID")&" "
				QUERY=QUERY&"AND Datelog = '" & month(Date())&"/"&day(date())&"/"&year(date()) &"' "
				
				set ying = adnowConn.execute (QUERY)
				Response.Write "<font size=""1""><A HREF='"&redirectLocation&"CSANV2_redirect.asp?D=" & month(Date())&"/"&day(date())&"/"&year(date()) &"&File=" & Ans("AdID") & "&round="&ranNumber&"' target='"&goHere&"'><span style=""font-family: Verdana, Arial;"">" & decode(Textmsg)& "</span></A></font>"
			End If

			' ADD STATS FOR THE ADS
			AddStats(Ans("AdID"))
		End If
		
		settempweight(Target)

		adnowConn.close
		
	END SUB
		
	'-------------------------------------------
	'Fix bug Version 2.2.4
	
	SUB FixBUG_Email_224
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
		
		QUERY="SELECT CustomerID,LastSend FROM Companies "
		QUERY=QUERY&"WHERE LastSend LIKE '%/%' "
		SET CompaniesRS=Server.CreateObject ("ADODB.Recordset")
		CompaniesRS.Open QUERY,adnowConn,1,3
		
		DO WHILE NOT CompaniesRS.EOF
			LS=CompaniesRS("LastSend")
			monthLS=Mid(LS,1,instr(LS,"/")-1)
			IF Len(monthLS)<2 THEN
				monthLS="0"&monthLS
			END IF
			LS=Mid(LS,instr(LS,"/")+1,Len(LS)-instr(LS,"/"))
			dayLS=Mid(LS,1,instr(LS,"/")-1)
			IF Len(dayLS)<2 THEN
				dayLS="0"&dayLS
			END IF
			YearLS=Mid(LS,instr(LS,"/")+1,Len(LS))
			
			QUERY="UPDATE Companies SET LastSend='"&YearLS&monthLS&dayLS&"' "
			QUERY=QUERY&"WHERE CustomerID="& CompaniesRS("CustomerID")
			adnowConn.Execute(QUERY)
			CompaniesRS.MoveNext
		LOOP
		CompaniesRS.CLOSE
		
		QUERY="SELECT CustomerID,LastSend FROM Companies "
		QUERY=QUERY&"WHERE LastSend <>'' AND LastSend is NOT NULL "
		QUERY=QUERY&"AND DReport is not null "
		SET CompaniesRS=Server.CreateObject ("ADODB.Recordset")
		CompaniesRS.Open QUERY,adnowConn,1,3
		
		DO WHILE NOT CompaniesRS.EOF 
			LS=CompaniesRS("LastSend")
			IF Len(LS)<8 THEN
				LYear=year(date())
				LMonth=Month(Date())
				IF Len(Lmonth)<2 THEN
					LMonth="0"&Lmonth
				END IF
				LDay=Day(Date())
				IF Len(Lday)<2 THEN
					Lday="0"&Lday
				END IF
				DateLastSend=LYear&LMonth&LDay
				QUERY="UPDATE Companies SET LastSend='"&DateLastSend&"' "
				QUERY=QUERY&"WHERE DReport is not null "
				QUERY=QUERY&"AND CustomerID="&CompaniesRS("Customerid")
			
				adnowConn.Execute (QUERY)
			END IF
			CompaniesRS.MoveNext
		LOOP
		CompaniesRS.Close
	END SUB
		
	'-------------------------------------------
	
	SUB Check_mailserver_By_Date

		Dim QUERY
		Dim adnowConn
		Dim CompanyRS
		Dim DateLastSend

		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
		
		FixBUG_Email_224
		
		QUERY="SELECT Customerid,DReport FROM Companies "
		QUERY=QUERY&"WHERE DReport is NOT NULL "
		QUERY=QUERY&"AND (LastSend='' "
		QUERY=QUERY&"OR LastSend IS NULL) "
		
		SET CompanyRS=Server.CreateObject ("ADODB.Recordset")
		CompanyRS.Open QUERY,adnowConn,1,3
		
		DO WHILE NOT companyRS.EOF
			DateLastSend=Date()+(CompanyRS("DReport")+0)
			
			LYear=year(DateLastSend)
			LMonth=Month(DateLastSend)
			IF Len(Lmonth)<2 THEN
				LMonth="0"&Lmonth
			END IF
			LDay=Day(DateLastSend)
			IF Len(Lday)<2 THEN
				Lday="0"&Lday
			END IF
			
			DateLastSend=LYear&LMonth&LDay
			QUERY="UPDATE Companies SET LastSend='"&DateLastSend&"' "
			QUERY=QUERY&"WHERE DReport is not null "
			QUERY=QUERY&"AND CustomerID="&CompanyRS("Customerid")
			
			adnowConn.Execute (QUERY)
			CompanyRS.MoveNext			
		Loop
		
		CompanyRS.Close 
		
		QUERY="SELECT CustomerID,DReport FROM Companies "
		QUERY=QUERY&"WHERE ( LastSend*1 )<="
		QUERY=QUERY&"("&(year(date())*10000)+(month(date())*100)+(day(date()))&") "
		QUERY=QUERY&"AND DReport is NOT NULL "
		
		SET CompanyRS=Server.CreateObject ("ADODB.Recordset")
		CompanyRS.Open QUERY,adnowConn,1,3
		
		DO WHILE NOT companyRS.EOF
			IF Check_ad_data_Empty (companyRS("customerid")) THEN
			SendingMail (companyRS("customerid"))
			
				IF Session("Msg")=EMPTY THEN
					DateLastSend=Date()+(CompanyRS("DReport")+0)

					LYear=year(DateLastSend)
					LMonth=Month(DateLastSend)
					IF Len(Lmonth)<2 THEN
						LMonth="0"&Lmonth
					END IF
					LDay=Day(DateLastSend)
					IF Len(Lday)<2 THEN
						Lday="0"&Lday
					END IF
					
					DateLastSend=LYear&LMonth&LDay
					QUERY="UPDATE Companies SET LastSend='"&DateLastSend&"' "
					QUERY=QUERY&"WHERE DReport is not null "
					QUERY=QUERY&"AND CustomerID="&CompanyRS("Customerid")
			
					adnowConn.Execute (QUERY)
				END IF
			Session("Msg")=Abandon
			END IF
			
			CompanyRS.MoveNext
		Loop
		
	END SUB

	'-------------------------------------------
	
	FUNCTION Check_ad_data_Empty (ByVal customerid)
		Dim QUERY
		Dim adnowConn
		Dim Check_ad_data_EmptyRS
		
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd

		QUERY="SELECT * FROM ad_data "
		QUERY=QUERY&"WHERE customerid="&customerid&" "
		QUERY=QUERY&"AND STATUS='Active' "
		SET Check_ad_data_EmptyRS=Server.CreateObject ("ADODB.Recordset")
		Check_ad_data_EmptyRS.Open QUERY,adnowConn,1,3
		
		IF Check_ad_data_EmptyRS.EOF THEN
			Check_ad_data_Empty=False
		ELSE
			Check_ad_data_Empty=True
		END IF
		
		Check_ad_data_EmptyRS.Close
		adnowConn.close
	END FUNCTION
	
	'-------------------------------------------
	
	SUB Check_mailserver_By_IMP (ByVal customerid, ByVal adid)
	
		Dim adnowConn
		Dim QUERY
		Dim CompanyRS
		
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,uid,pwd
		
		QUERY="SELECT * FROM companies "
		QUERY=QUERY&"WHERE IReport IS NOT NULL "
		QUERY=QUERY&"AND (LastSend='' "
		QUERY=QUERY&"OR LastSend IS NULL) "
		QUERY=QUERY&"AND customerID="&customerid
		
		SET CompanyRS=Server.CreateObject ("ADODB.Recordset")
		CompanyRS.Open QUERY,adnowConn,1,3

		DO WHILE NOT companyRS.EOF
			QUERY="UPDATE Companies SET LastSend=IReport "
			QUERY=QUERY&"WHERE IReport is not null "
			QUERY=QUERY&"AND CustomerID="&CompanyRS("Customerid")
			
			CompanyRS.MoveNext
			
			adnowConn.Execute (QUERY)
		Loop
		
		CompanyRS.Close 
		
		QUERY="SELECT CustomerID,LastSend,IReport FROM Companies "
		QUERY=QUERY&"WHERE (LastSend+0)<="
		QUERY=QUERY&"(SELECT SUM(impressions) FROM [STATS] "
		QUERY=QUERY&"WHERE adid="&adid&") "
		QUERY=QUERY&"AND IReport IS NOT NULL "
		QUERY=QUERY&"AND customerID="&customerid
		
		SET CompanyRS=Server.CreateObject ("ADODB.Recordset")
		CompanyRS.Open QUERY,adnowConn,1,3
		
		DO WHILE NOT companyRS.EOF
			IF Check_ad_data_Empty (companyRS("customerid")) THEN
			SendingMail (companyRS("customerid"))

				IF Session("Msg")=EMPTY THEN
					QUERY="UPDATE Companies SET LastSend='"&(CompanyRS("LastSend")+CompanyRS("IReport"))+0&"' "
					QUERY=QUERY&"WHERE IReport is not null "
					QUERY=QUERY&"AND CustomerID="&CompanyRS("Customerid")
			
					adnowConn.Execute (QUERY)
				END IF
			
			Session("Msg")=Abandon
			END IF
			companyRS.MoveNext
		Loop

	ENd SUB
	
	'-------------------------------------------
	
	SUB SendingMail(ByVal customerid)
		

		Dim QUERY
		Dim adnowConn
		Dim CompanyRS

		On Error Resume Next
			
			SET Send_Mail=Server.CreateObject ("SMTPsvg.Mailer")
			
			QUERY="SELECT * FROM Companies "
			QUERY=QUERY&"WHERE customerid="&customerid
			
			SET adnowConn=Server.CreateObject ("ADODB.Connection")
			adnowConn.Open DSNad,uid,pwd
			
			SET CompanyRS=server.CreateObject ("ADODB.Recordset")
			CompanyRS.open QUERY,adnowConn,1,3
			
			IF NOT CompanyRS.EOF THEN
				IF Trim(CompanyRS("body"))<>EMPTY THEN
				Body=Replace(CompanyRS("body"),"%3C--Advertiser_Name--%3E",CompanyRS("companyname"))
				Body=Replace(Body,"%0D%0A",VbCrlf)
				Body=Replace(Body,"%20"," ")
				Body=Replace(Body,"%3C--Call_Report--%3E",StatsFunction (customerid))
				END IF
				Body=decode(Body)
			
				'Check ASPQmail Component
				IF Err.number = 0 THEN
					Send_Mail.RemoteHost = Remote_Mail_Host
					Send_Mail.FromName    = decode(CompanyRS("FromName"))
					Send_Mail.FromAddress = decode(CompanyRS("FromAddress"))
					Send_Mail.AddRecipient decode(CompanyRS("name")), CompanyRS("EmailReport")
					
					IF CompanyRS("CC")<>EMPTY THEN
						Send_Mail.AddCC "",decode(CompanyRS("CC"))
					ENd IF
					
					Send_Mail.Subject     = decode(CompanyRS("Subject"))
					Send_Mail.BodyText    = decode(Body)

					IF NOT Send_Mail.SendMail THEN
					  Session("Msg")="Mailing Failed... Error is: <br>" &_
									  Send_Mail.Response
					END IF

					Send_Mail.ClearRecipients 
					Send_Mail.ClearCCs 
					Send_Mail.ClearBodyText 
				END IF
			END IF
			
		On Error Goto 0
	END SUB
	
	'-------------------------------------------

	'Stats Resport
	FUNCTION StatsFunction (ByVal Customerid)
	
		Dim FunctionConn
		Dim QUERY
		Dim ad_dataRS
		Dim CampaignRS
		Dim Call_Report
		Dim CheckCampaign
		Dim adName
		Dim CampaignName
		Dim SumImp
		Dim SumClick
		Dim Clickthru
		
		SET FunctionConn=Server.CreateObject ("ADODB.Connection")
		FunctionConn.Open DSNad,uid,pwd
		
		QUERY="SELECT * FROM ad_data "
		QUERY=QUERY&"WHERE customerid="&customerid&" "
		QUERY=QUERY&"ORDER BY CampaignID desc,adid desc "
		
		SET ad_dataRS=Server.CreateObject ("ADODB.Recordset")
		ad_dataRS.Open QUERY,FunctionConn,1,3
		
		'Date Report
		Call_Report="Date: "&month(Date())&"/"&day(Date())&"/"&year(Date())& VbCrlf
		
		DO WHILE NOT ad_dataRS.EOF
			
			'Check CampaignID
			IF ad_dataRS("CampaignID")<>EMPTY AND ad_dataRS("CampaignID")>0 AND ad_dataRS("CampaignID")<>CheckCampaign THEN
				CheckCampaign=ad_dataRS("CampaignID")
				
				QUERY="SELECT campaignName FROM campaign "
				QUERY=QUERY&"WHERE campaignID="&ad_dataRS("CampaignID")
				
				SET CampaignRS=Server.CreateObject ("ADODB.Recordset")
				CampaignRS.Open QUERY,FunctionConn,1,3
				
				'Print Campaign Name
				IF NOT CampaignRS.EOF THEN
					Call_Report=Call_Report&VbCrlf&"Campaign: ["&decode(CampaignRS("CampaignName"))&"]"&VbCrlf&VbCrlf
					Call_Report=Call_Report&"Ad Name             Impressions    Clicks       CTR"&VbCrlf
					Call_Report=Call_Report&"------------------ ------------ --------- ---------"&VbCrlf
				END IF
				CampaignRS.Close
			
			'Print Camapign N/A
			ELSEIF ad_dataRS("CampaignID")=EMPTY AND ad_dataRS("CampaignID")=0 THEN
				Call_Report=Call_Report&VbCrlf&"Campaign: [N/A]"&VbCrlf&VbCrlf
					Call_Report=Call_Report&"Ad Name             Impressions    Clicks       CTR"&VbCrlf
					Call_Report=Call_Report&"------------------ ------------ --------- ---------"&VbCrlf
			END IF
			
			IF Len(Trim(ad_dataRS("adName")))>18 THEN
				SumImp=ReportSumImpressions (ad_dataRS("adid"))+0
				SumClick=ReportSumClicks (ad_dataRS("adid"))+0
				IF SumImp<>EMPTY AND SumImp>0 THEN
					Clickthru=FormatPercent(SumClick/SumImp,2)
				ELSE
					ClickThru=0
				END IF
				
				Call_Report=Call_Report&Mid(decode(Trim(ad_dataRS("adName"))),1,18)
				Call_Report=Call_Report&space(1)
				Call_Report=Call_Report&ReportImpressions(Len(SumImp))
				Call_Report=Call_Report&SumImp
				Call_Report=Call_Report&space(1)
				Call_Report=Call_Report&ReportClicks(Len(SumClick))
				Call_Report=Call_Report&SumClick
				Call_Report=Call_Report&space(1)
				Call_Report=Call_Report&ReportCTR(Len(Clickthru))
				Call_Report=Call_Report&Clickthru
				Call_Report=Call_Report&VbCrlf
				Call_Report=Call_Report&Mid(decode(Trim(ad_dataRS("adName"))),19,Len(Trim(ad_dataRS("adName")))-19)
				Call_Report=Call_Report&VbCrlf

			ELSE
				SumImp=ReportSumImpressions (ad_dataRS("adid"))+0
				SumClick=ReportSumClicks (ad_dataRS("adid"))+0
				IF SumImp<>EMPTY AND SumImp>0 THEN
					Clickthru=FormatPercent(SumClick/SumImp,2)
				ELSE
					ClickThru=0
				END IF
				
				Call_Report=Call_Report&decode(Trim(ad_dataRS("adName")))
				Call_Report=Call_Report&ReportadName(Len(decode(Trim(ad_dataRS("adName")))))
				Call_Report=Call_Report&space(1)
				Call_Report=Call_Report&ReportImpressions(Len(SumImp))
				Call_Report=Call_Report&SumImp
				Call_Report=Call_Report&space(1)
				Call_Report=Call_Report&ReportClicks(Len(SumClick))
				Call_Report=Call_Report&SumClick
				Call_Report=Call_Report&space(1)
				Call_Report=Call_Report&ReportCTR(Len(Clickthru))
				Call_Report=Call_Report&Clickthru
				Call_Report=Call_Report&VbCrlf
			END IF
						
			ad_dataRS.MoveNext
		LOOP
		ad_dataRS.Close	
		FunctionConn.Close
		
		StatsFunction=Call_Report
		
	END FUNCTION

	'-------------------------------------------
	
	FUNCTION ReportSumImpressions (ByVal adid)
	
		Dim QUERY
		Dim IMPConn
		Dim ImpRS
		
		QUERY="SELECT SUM(impressions) FROM [Stats] "
		QUERY=QUERY&"WHERE adid="&adid+0
		
		SET IMPConn=Server.CreateObject ("ADODB.Connection")
		IMPConn.Open DSNad,uid,pwd
		
		SET ImpRS=Server.CreateObject ("ADODB.Recordset")
		ImpRS.Open QUERY,IMPConn,1,3
		
		IF NOT ImpRS.EOF THEN
			ReportSumImpressions=ImpRS(0)
		ELSE
			ReportSumImpressions=0
		END IF
		
		ImpRS.Close
		IMPConn.Close

	END FUNCTION
	
	'-------------------------------------------
	
	FUNCTION ReportSumClicks (ByVal adid)
	
		Dim QUERY
		Dim ClicksConn
		Dim ClicksRS
		
		QUERY="SELECT SUM(Clicks) FROM [Stats] "
		QUERY=QUERY&"WHERE adid="&adid+0
		
		SET ClicksConn=Server.CreateObject ("ADODB.Connection")
		ClicksConn.Open DSNad,uid,pwd
		
		SET ClicksRS=Server.CreateObject ("ADODB.Recordset")
		ClicksRS.Open QUERY,ClicksConn,1,3

		IF NOT ClicksRS.EOF THEN
			ReportSumClicks=ClicksRS(0)
		ELSE
			ReportSumClicks=0
		END IF
		
		ClicksRS.Close
		ClicksConn.Close
		
	END FUNCTION

	'-------------------------------------------
	
	FUNCTION ReportadName (ByVal LenValue)
	
		Dim ReportOut
		Dim I
		
		LenValue=18-(LenValue+0)
		
		IF LenValue<>EMPTY THEN
			FOR I=1 TO LenValue
				ReportOut=ReportOut&space(1)
			NEXT
		END IF
		ReportadName=ReportOut
		
	END FUNCTION
	
	'-------------------------------------------

	FUNCTION ReportImpressions (ByVal LenValue)

		Dim ReportOut
		Dim I
		
		LenValue=12-(LenValue+0)
		
		IF LenValue<>EMPTY THEN
			FOR I=1 TO LenValue
				ReportOut=ReportOut&space(1)
			NEXT
		END IF
		ReportImpressions=ReportOut

	END FUNCTION

	'-------------------------------------------

	FUNCTION ReportClicks (ByVal LenValue)

		Dim ReportOut
		Dim I
		
		LenValue=9-(LenValue+0)
		
		IF LenValue<>EMPTY THEN
			FOR I=1 TO LenValue
				ReportOut=ReportOut&space(1)
			NEXT
		END IF
		ReportClicks=ReportOut

	END FUNCTION

	'-------------------------------------------

	FUNCTION ReportCTR (ByVal LenValue)

		Dim ReportOut
		Dim I
		
		LenValue=9-(LenValue+0)
		
		IF LenValue<>EMPTY THEN
			FOR I=1 TO LenValue
				ReportOut=ReportOut&space(1)
			NEXT
		END IF
		ReportCTR=ReportOut

	END FUNCTION

	'-------------------------------------------

%>
<SCRIPT LANGUAGE=JScript RUNAT=Server>
function encode(str) {
	return escape(str);
}

function decode(str) {
	return unescape(str);
}
</SCRIPT>
