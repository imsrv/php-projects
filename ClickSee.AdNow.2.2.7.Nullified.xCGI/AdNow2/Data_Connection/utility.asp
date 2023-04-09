<%

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------
	'This procedure prints some HTML with trailing cr/lf
	
	SUB PrintLn(ByVal StrPrint)
		
		IF trim(StrPrint)<>EMPTY THEN
		Response.Write (StrPrint & VbCrlf)
		ELSE
		Response.Write ("&nbsp;" & VbCrlf)
		END IF
			
	END SUB

	'-------------------------------------------

	FUNCTION VarBACK
		
		VarBACK="BURL=stats.asp" & encode ("?companycode=" & Request("CompanyCode"))
		VarBACK=VarBACK & encode("&location=" & Request("Location"))
		VarBACK=VarBACK & encode("&status=" & Request("Status"))
		VarBACK=VarBACK & encode("&ViewEx1=" & Request("ViewEx1"))
		VarBACK=VarBACK & encode("&monthexpire=" & Request("monthexpire"))
		VarBACK=VarBACK & encode("&ViewEx2=" & Request("ViewEx1"))
		VarBACK=VarBACK & encode("&imp_left=" & Request("imp_left"))
		VarBACK=VarBACK & encode("&ViewEx3=" & Request("ViewEx1"))
		VarBACK=VarBACK & encode("&day_left=" & Request("day_left"))
		VarBACK=VarBACK & encode("&ViewEx4=" & Request("ViewEx1"))
		VarBACK=VarBACK & encode("&click_left=" & Request("click_left"))
	
	END FUNCTION

	'-------------------------------------------
	
	SUB Triggers
	
		Dim QUERY
		Dim adnowConn
		
		SET adnowConn=Server.CreateObject ("ADODB.Connection")
		adnowConn.Open DSNad,UID,PWD

		QUERY="DELETE FROM campaign "
		QUERY=QUERY & "WHERE campaignid not in "
		QUERY=QUERY & "(SELECT distinct(campaignid) FROM ad_data)"
		adnowConn.Execute (QUERY)

		QUERY="DELETE FROM campaign "
		QUERY=QUERY & "WHERE customerid not in "
		QUERY=QUERY & "(SELECT distinct(customerid) FROM companies)"
		adnowConn.Execute (QUERY)

		QUERY="DELETE FROM [stats] "
		QUERY=QUERY & "WHERE adid not in "
		QUERY=QUERY & "(SELECT distinct(adid) FROM ad_data) "
		adnowConn.Execute (QUERY)
		
		adnowConn.Close

	END SUB

	'-------------------------------------------

	FUNCTION Print_Date (ByVal Str)
	
		IF LEN(Str)=8 THEN
			Print_Date=Mid(Str,5,2)&"/"&Mid(Str,7,2)&"/"&Mid(Str,1,4)
		ELSE
			Print_Date=""
		END IF
	
	END FUNCTION

	'-------------------------------------------

	FUNCTION C_F_date (byval str)
		Dim yyyy
		Dim mm
		Dim dd
		
		IF IsDate(str) THEN
			IF LEN(year(str))<4 THEN
				yyyy="20"&year(str)
			ELSE
				yyyy=year(str)
			END IF
			IF LEN(month(str))<2 THEN
				mm="0"&month(str)
			ELSE
				mm=month(str)
			END IF
			IF LEN(day(str))<2 THEN
				dd="0"&day(str)
			ELSE
				dd=day(str)
			END IF
	
			C_F_date=mm&"/"&dd&"/"&yyyy
		END IF
	END FUNCTION
%>