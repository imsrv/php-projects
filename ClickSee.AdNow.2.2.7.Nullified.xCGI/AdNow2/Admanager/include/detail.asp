<!--#Include File="../../Data_Connection/Connection.asp"-->
<!--#Include File="detail2.asp"-->
<SCRIPT LANGUAGE=vbscript RUNAT=Server>

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------

		Dim CompanyName
		Dim CompanyID
		Dim adname
		Dim adid
		Dim dstatus
		Dim target
		Dim adweight
		Dim Datestart
		Dim dateend
		Dim clickex
		Dim imp_purchased
		Dim impression
		Dim clicks
		Dim clickthru
		Dim CampaignName
		Dim Campaignid
		Dim QUERY
		Dim SQL
		Dim HPF
		Dim CPF
		Dim Checkcampaign
		Dim CheckOption
		Dim ColorSet
		Dim checkwoc
		Dim CPO
		Dim Hend
		Dim Dend
		Dim Ans1
		Dim Ans2
		Dim AnsMid

		Dim SUBConn


	SUB detail

		'Run Triggers
		Triggers

		IF Request ("ViewEx1")=EMPTY AND  Request ("ViewEx2")=EMPTY AND Request ("ViewEx3")=EMPTY AND Request ("ViewEx4")=EMPTY THEN
			Check_condition Request("CompanyCode"), Request("location"), Request("Status")
		ELSEIF Request ("ViewEx1")<>EMPTY OR  Request ("ViewEx2")<>EMPTY OR Request ("ViewEx3")<>EMPTY OR Request ("ViewEx4")<>EMPTY THEN
			Checkcondition Request("CompanyCode"), Request("location"), Request("Status")
		END IF
		EndSession

	END SUB
	
	'-------------------------------------------
	
	SUB Check_condition (ByVal CompanyCode, ByVal Location, ByVal Status)
	
		'Open Connection Object
		SET SUBConn=Server.CreateObject ("ADODB.Connection")
		SUBConn.Open DSNad,uid,pwd

		QUERY="SELECT customerid,companyname FROM companies "
		
		'Check condition
		IF trim(CompanyCode)<>EMPTY THEN
			QUERY=QUERY&"WHERE customerid="&companycode&" " 
		END IF

		QUERY=QUERY&"ORDER BY companyname "
		
		'Open DB companies Table
		SET companyRS=Server.CreateObject ("ADODB.Recordset")
		companyRS.Open QUERY,SUBConn,1,3
		
		'Loop for company
		CPO = FALSE
		
		DO WHILE NOT companyRS.EOF
			
			'Check option default
			CheckOption=FALSE
			
			'Set color in campaign
			ColorSet=FALSE

			'Var CompanyName and CompanyID
			companyname		=	Vfield (companyRS("CompanyName"))
			companyID		=	Vfield (companyRS("customerID"))
			
			QUERY="SELECT * FROM ad_data "
			QUERY=QUERY&"WHERE customerid="&companyID&" "
			
			'Check Location
			IF trim(location)<>EMPTY THEN
				QUERY=QUERY&"AND target='"&location&"' "
				CheckOption=TRUE
			END IF

			'Check Status
			IF trim(status)<>EMPTY THEN
				QUERY=QUERY&"AND status='"&status&"' "
				CheckOption=TRUE
			END IF
			
			QUERY=QUERY&"ORDER BY campaignid desc, adid desc "
			
			'Open DB ad_data by location, status
			SET ad_dataRS=Server.CreateObject ("ADODB.Recordset")
			ad_dataRS.Open QUERY,SUBConn,1,3
			
		IF NOT ad_dataRS.EOF OR NOT CheckOption THEN
			'Check Print company
			IF (trim(location)=EMPTY AND trim(status)=EMPTY ) THEN
				'Print Company
				HPrintForm companyname,companyid
			ELSEIF checkoption AND NOT ad_dataRS.EOF THEN
				'Print Company
				HPrintForm companyname,companyid
			END IF
			
			'Loop for ad_data
			DO WHILE NOT ad_dataRS.EOF
				
				'Check Campaign
				IF ad_dataRS("campaignid")<>EMPTY AND ad_dataRS("campaignid")>0 AND checkcampaign<>ad_dataRS("campaignid") THEN
					QUERY="SELECT * FROM campaign "
					QUERY=QUERY&"WHERE campaignid="&ad_dataRS("campaignid")
					QUERY=QUERY&"AND customerid="&companyid
					
					'Open DB campaign
					SET campaignRS=Server.CreateObject ("ADODB.Recordset")
					CampaignRS.Open QUERY,SUBConn,1,3
					
					'Check record Campaign DB
					IF NOT campaignRS.EOF THEN
					
						'Var CampaignName and CampaignID
						campaignname=	Vfield (CampaignRS("campaignname"))
						campaignid	=	Vfield (CampaignRS("campaignid"))

							IF CPO THEN
								LPrintForm
								CPO=FALSE
							END IF

						'Print Campaign
						CPrintForm campaignname,campaignid,companyID
						CPO=True
						ColorSet=TRUE
						checkwoc=FALSE
					END IF
					
					'Var CheckCampaign
					checkcampaign=ad_dataRS("campaignid")
					
					'Close Campaign DB
					campaignRS.Close
				
				'Check record with out campaign.
				ELSEIF ad_dataRS("campaignid")=EMPTY OR ad_dataRS("campaignid")=0 THEN
					ColorSet=FALSE
					IF NOT checkWOC THEN
							IF CPO THEN
								LPrintForm
								CPO=FALSE
							END IF
						WOPrintForm
						CPO=True
						checkwoc=TRUE
					END IF
				END IF
			
				'Var ad_data DB group
				adname			=	Vfield (ad_dataRS("adName"))
				adid			=	Vfield (ad_dataRS("adid"))
				dstatus			=	Vfield (ad_dataRS("status"))
				target			=	Vfield (ad_dataRS("target"))
				adweight		=	Vfield (ad_dataRS("adweight"))
				datestart		=	(ad_dataRS("datestart"))
				enddate		    =   (ad_dataRS("Actualenddate"))
				dateend			=	(ad_dataRS("dateend"))
				clickex			=	(ad_dataRS("clickexpire"))
				imp_purchased	=	(ad_dataRS("impressionspurchased"))
				impression		=	Sumimp (adid)
				clicks			=	Sumclick (adid)
				IF impression<>0 AND Clicks<>0 THEN
				clickthru		=	FormatPercent(Clicks/impression,2)
				ELSE
				clickthru		=	0
				END IF
				
				IF dateend <> Empty  THEN
				  Hend = "Exp By Date"
				  Dend = Print_Date (dateend)
				
				ELSEIF  clickex <> EMPTY AND clickex+0>0 THEN
				  Hend = "Exp By Click"
				  Dend = clickex
				
				ELSEIF imp_purchased <> EMPTY AND imp_purchased+0>0 THEN
				  Hend = "Exp By Imp"
				  Dend = imp_purchased
				
				ELSEIF dstatus = "Hold" AND dateend = EMPTY AND clickex+0 = 0 AND imp_purchased+0 = 0 THEN
				  Hend = "N/A"
				  Dend = "N/A"
				
				END IF
				
				'Print ads
				MPrintForm adname,adid,dstatus,target,adweight,datestart,enddate,Hend,Dend,impression,clicks,clickthru,ColorSet

				ad_dataRS.MoveNext

			LOOP
			LCPrintForm
			'Close Ad_data DB
			ad_dataRS.Close 
			
			'Print note
			LPrintForm
	
			checkwoc=FALSE
		END IF
			companyRS.MoveNext
		LOOP
		
		'Close Companies DB
		companyRS.Close 
		
		'Close Connection Object
		SUBConn.Close
		
	END SUB
	
	'-------------------------------------------

	'View ads thst are about to expire.

	SUB Checkcondition(ByVal CompanyCode, ByVal Location, ByVal Status)

		SET SUBConn=Server.CreateObject ("ADODB.Connection")
		SUBConn.Open DSNad,uid,pwd
		
		QUERY="SELECT c.companyname,c.customerid,a.* FROM ad_data a, Companies c "
		QUERY=QUERY&"WHERE a.customerid=c.customerid "
		
		'View expire by month
		IF Request ("ViewEx1")<>EMPTY THEN
		
			'Check month
			IF month(date())=1 AND Request("monthexpire")="-1" THEN
				Ans2=decode(Year(Date()))-1
				Ans1=Ans2&"1201"
				Ans2=Ans2&"1231"
			ELSEIF month(date())=12 AND Request("monthexpire")="+1" THEN
				Ans2=decode(Year(Date()))+1
				Ans1=Ans2&"0101"
				Ans2=Ans2&"0131"
			ELSE
				AnsMid=(month(date()) + Request("monthexpire")) + 0
				IF LEN(AnsMid)<2 THEN
					AnsMid="0"&AnsMid
				END IF
				Ans2=decode(Year(Date()))
				Ans1=Ans2&AnsMid&"01"
				Ans2=Ans2&AnsMid&"31"
			END IF
			
			SQL="AND ( (a.dateend+0) BETWEEN "&Ans1+0&" AND "&Ans2+0&") "
		
		'View expire by impressions.
		ELSEIF Request ("ViewEx2")<>EMPTY OR Request("imp_left")<>EMPTY THEN

			IF Request ("imp_left")=EMPTY THEN
				Response.Redirect "adcenter.asp"
			ELSEIF NOT Isnumeric(Request("imp_left")) THEN
				Response.Redirect "adcenter.asp"
			END IF

			SQL=SQL&"AND ((a.impressionspurchased-(SELECT sum(impressions) FROM [stats] where adid=a.adid))<="&(Request("imp_left")+0)&" "
			SQL=SQL&"OR (a.impressionspurchased<="&Request("imp_left")+0&")) "
			SQL=SQL&"AND a.impressionspurchased<>0 "
			SQL=SQL&"AND a.impressionspurchased is not null "
			SQL=SQL&"AND a.status<>'Expired' "

		'View expire by days.
		ELSEIF Request ("ViewEx3")<>EMPTY OR Request ("day_left")<>EMPTY THEN

			IF Request ("day_left")=EMPTY THEN
				Response.Redirect "adcenter.asp"
			ELSEIF NOT isnumeric(Request ("day_left")) THEN
				Response.Redirect "adcenter.asp"
			END IF
			
			AnsMid=month(Date())
			IF LEN(AnsMid)<2 THEN
				AnsMid="0"&AnsMid
			END IF
			Ans1=decode(Year(Date()))&AnsMid
			AnsMid=Day(Date())
			IF LEN(AnsMid)<2 THEN
				AnsMid="0"&AnsMid
			END IF
			Ans1=Ans1&AnsMid
			
			AnsMid=Month(Date()+(Request ("Day_Left")+0))
			IF LEN(AnsMid)<2 THEN
				AnsMid="0"&AnsMid
			END IF
			Ans2=decode(Year(Date()))&AnsMid
			AnsMid=Day(Date()+(Request ("Day_Left")+0))
			IF LEN(AnsMid)<2 THEN
				AnsMid="0"&AnsMid
			END IF
			Ans2=Ans2&AnsMid
						
			SQL="AND ( (a.dateend+0) BETWEEN "&Ans1+0&" AND "&Ans2+0&") "

		'View expire by clickthru.
		ELSEIF Request ("ViewEx4")<>EMPTY OR  Request("click_left")<>EMPTY THEN

			IF Request ("click_left")=EMPTY THEN
				Response.Redirect "adcenter.asp"
			ELSEIF NOT Isnumeric(Request("click_left")) THEN
				Response.Redirect "adcenter.asp"
			END IF

			SQL="AND a.clickexpire >0 "
			SQL=SQL&"AND (a.clickexpire-(SELECT sum(clicks) FROM [stats] where adid=a.adid))<="&(Request("click_left"))&" "
			SQL=SQL&"AND a.status<>'Expired' "

		END IF
	
		QUERY=QUERY & SQL & "ORDER BY c.companyname,a.campaignid desc,a.adid desc"

		SET companies_ad_data_RS=Server.CreateObject ("ADODB.Recordset")
		companies_ad_data_RS.Open QUERY,SUBConn,1,3

		HPF=False
		CPF=False
		DO WHILE NOT companies_ad_data_RS.EOF
		
			ColorSet=FALSE

			'Add parametor
			companyname		=	Vfield (companies_ad_data_RS("CompanyName"))
			companyID		=	Vfield (companies_ad_data_RS("customerID"))
			adname			=	Vfield (companies_ad_data_RS("adName"))
			adid			=	Vfield (companies_ad_data_RS("adid"))
			dstatus			=	Vfield (companies_ad_data_RS("status"))
			target			=	Vfield (companies_ad_data_RS("target"))
			adweight		=	Vfield (companies_ad_data_RS("adweight"))
			datestart		=	(companies_ad_data_RS("datestart"))
			dateend			=	(companies_ad_data_RS("dateend"))
			clickex			=	(companies_ad_data_RS("clickexpire"))
			imp_purchased	=	(companies_ad_data_RS("impressionspurchased"))
			impression		=	Sumimp (adid)
			clicks			=	Sumclick (adid)
			
			IF impression<>0 AND Clicks<>0 THEN
			clickthru		=	FormatPercent(Clicks/impression,2)
			ELSE
			clickthru		=	0
			END IF

			IF dateend <> Empty  THEN
			  Hend = "Exp by Date"
			  Dend = Print_Date (dateend)
			
			ELSEIF  clickex <> EMPTY AND clickex+0>0 THEN
			  Hend = "Exp by Click"
			  Dend = clickex
			
			ELSEIF imp_purchased <> EMPTY AND imp_purchased+0>0 THEN
			  Hend = "Exp by Imp"
			  Dend = imp_purchased
			END IF
			
			IF checkcompanyid<>companyid THEN
				IF HPF THEN
					'companies_ad_data_RS.MovePrevious 
					LPrintForm
					'companies_ad_data_RS.MoveNext 
				END IF
				checkcompanyid=companyid
				HPrintForm companyname,companyid
				HPF=True
			END IF
			
			IF companies_ad_data_RS("campaignid")>0 OR companies_ad_data_RS("campaignid")<>EMPTY THEN
				
				campaignid		=	Vfield (companies_ad_data_RS("campaignid"))
				
				QUERY="SELECT * FROM campaign "
				QUERY=QUERY&"WHERE campaignid="&campaignid
				
				SET campaignRS=Server.CreateObject ("ADODB.Recordset")
				CampaignRS.Open QUERY,SUBConn,1,3
				
				campaignname	=	Vfield (CampaignRS("campaignname"))
				
				IF checkcampaignid<>campaignid THEN
					IF CPF THEN
						LPrintForm
					END IF
					checkcampaignid=campaignid
					CPrintForm campaignname,campaignid,companyID
					ColorSet=TRUE
					checkwoc=FALSE
					CPF=TRUE
				END IF
			ELSE
				ColorSet=FALSE
				IF NOT checkWOC THEN
					WOPrintForm
					checkwoc=TRUE
				END IF
			END IF


			
			MPrintForm adname,adid,dstatus,target,adweight,datestart,enddate,Hend,Dend,impression,clicks,clickthru,ColorSet
			
			companies_ad_data_RS.MoveNext
		LOOP
		
		IF HPF THEN
			companies_ad_data_RS.MovePrevious 
			LPrintForm
		END IF
		
		companies_ad_data_RS.Close
		SUBConn.Close 
		
	END SUB
	
	'-------------------------------------------
	
</SCRIPT>
