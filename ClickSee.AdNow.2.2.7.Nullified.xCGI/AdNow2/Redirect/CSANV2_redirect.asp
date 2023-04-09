<!--#include File="../Data_Connection/DSN_Connection.asp"-->
<SCRIPT LANGUAGE=vbscript RUNAT=Server>
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modify 10/17/200

If Request.QueryString ("File")<>Empty And Request.QueryString ("D")<>Empty Then
thisad = request.querystring("File")+0
SET adnowConn=Server.CreateObject ("ADODB.Connection")
adnowConn.Open DSNad,uid,pwd
					
	Query="Select * From Stats " &_
		  "Where AdID=" & Request.QueryString ("File")+0 &_
		  " And Datelog='" & Request.QueryString ("D") & "'"		
		  Set RS=adnowConn.Execute (Query)
		  
	If Not RS.EOF Then
	IF HostName <> "" THEN
	  IF instr(Request.ServerVariables ("HTTP_REFERER"),HostName)<> 0 THEN
' UPDATE CLICKS
		Query="Update Stats Set Clicks=" & RS("Clicks")+1 &_
			  " Where ID=" & RS("ID")+0
		adnowConn.Execute (Query)
	  END IF
	ELSE
		Query="Update Stats Set Clicks=" & RS("Clicks")+1 &_
			  " Where ID=" & RS("ID")+0
		adnowConn.Execute (Query)
	END IF	
' FIND ADS THAT EXPIRE BY CLICKS	
		SQL = "Select * from ad_data where AdID = "&thisad&""
		set findad = adnowConn.execute(SQL)
			adID = findad("AdID")
			buyclick = findad("ClickExpire")
				IF buyclick <> "0" THEN
					Query = "Select * from stats where AdID="&adID&" and Datelog='"&month(Date())&"/"&day(date())&"/"&year(date())&"'"
					set cClick = adnowConn.Execute(Query)
					currentclick = cClick("Clicks")
						IF buyclick = currentclick THEN
						  	sql = "Update ad_data set Status = 'Expired'"
							sql = sql & ", Actualenddate = '"&(decode(year(date()))*10000)+(month(date())*100)+(day(date()))&"'"
							sql = sql & " Where AdID = "&adID&""
						  	adnowConn.execute(sql)
						END IF
					cClick.close
				END IF
		findad.close
' END FIND AD		
	  End If
		SQL="Select Url From Ad_data Where AdID=" & Request.QueryString ("File")+0
		Set linkGO=adnowConn.Execute (SQL)
		Response.Redirect(decode(linkGO("url")))
	
End If
	
	
</SCRIPT>
<SCRIPT LANGUAGE=JScript RUNAT=Server>
function encode(str) {
	return escape(str);
}

function decode(str) {
	return unescape(str);
}
</SCRIPT>
