<!--#Include File="../../Data_Connection/Connection.asp"-->
<SCRIPT LANGUAGE=vbscript RUNAT=Server>

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/200
	'-------------------------------------------
	
	'IF Request.ServerVariables ("CONTENT_LENGTH")<>0 THEN
	IF instr(Request.Form,"Finish")<>EMPTY THEN

	campaignid = request("campaignid")
	sql = "select CustomerID from Campaign where CampaignID = "&campaignid&""
	set foundad = adnowConn.execute(sql)
	  customerid = foundad("CustomerID")
	foundad.close

	IF request.form("campaignname") = EMPTY THEN
		Session("MSG")="Please enter Campaign Name."
	END IF
	  
		IF trim(Session("MSG"))=EMPTY THEN
' INSERT CAMPAIGN
		  query = "insert into Campaign("
		  query = query & "CampaignName,CampaignDescription,CustomerID)"
		  query = query & " Values ('"&encode(request("campaignname"))&"','"&encode(request("campaigndescription"))&"',"&customerid&")"
		  adnowConn.execute (query)
		  sql = "select CampaignID from Campaign order by CampaignID desc"
		  set foundit = adnowConn.execute(sql)
		  campaignidnew = foundit("CampaignID")
		  foundit.close
' END INSERT CAMPAIGN
		  totalrecord = request("count")
		  for i = 1 to totalrecord
			if request("adid"&i) <> empty then
			  thisad = request("adid"&i)
			  query = "select * from ad_data where AdID = "&thisad&""
			  set foundad = adnowConn.execute (query)
				atext = foundad("TextMsg")
				adname = foundad("AdName")
				status = "Hold"
				imageurl = foundad("ImageURL")
				url = foundad("Url")
				alt = foundad("ALT")
				aweight = foundad("adweight")
				awidth = foundad("adwidth")
				aheight = foundad("adheight")
				aborder = foundad("adborder")
				astart = foundad("DateStart")
				target = foundad("Target")				
				customerid = foundad("CustomerID")
				thistarget = "'"&foundad("adTarget")&"'"
				
				IF thistarget="''" THEN
				thistarget = "NULL"
				END IF
				
				aend = foundad("DateEnd")
				aImp = foundad("ImpressionsPurchased")
				IF foundad("ClickExpire")=EMPTY THEN
					aclick = "NULL" 
				ELSE
					aclick = foundad("ClickExpire")
				END IF
				
				
			  foundad.close
			  query = "insert into ad_data"
			  query = query & "(CampaignID,CustomerID,AdName,Status,ImageURL,Url"
			  query = query & ",ALT,adweight,adwidth,adheight,adborder,DateStart,Target,TextMsg,adTarget"
			  query = query & ",DateEnd,ImpressionsPurchased,ClickExpire)"
			  query = query & " Values ("&campaignidnew&", "&customerid&", '"&adname&"',"
			  query = query & " 'Hold', '"&imageurl&"', '"&url&"', '"&alt&"', "&aweight&","
			  query = query & " '"&awidth&"', '"&aheight&"', '"&aborder&"', '"&astart&"', "
			  query = query & " '"&target&"', '"&atext&"',"&thistarget&","
			  query = query &" '"&aend&"', "&aImp&", "&aclick&")"
			  
			  adnowConn.execute (query)
			end if
		  next

		IF Request.QueryString ("BURL")<>EMPTY THEN
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
	
	FUNCTION Print_campaign (ByVal fieldkey,ByVal campaignid)

		IF Request.QueryString("campaignid")=EMPTY THEN
			Response.Redirect "../adcenter.asp"
		END IF	
	
		IF trim(Request(fieldkey))=EMPTY THEN
			Query="SELECT * FROM campaign " &_
						  "WHERE campaignid=" & campaignid

			IF NOT isobject(functionConn) THEN
				SET functionConn=Server.CreateObject ("ADODB.Connection")
				functionConn.Open DSNad,uid,pwd
			END IF

			SET campaignRS=Server.CreateObject ("ADODB.Recordset")
			campaignRS.Open Query,functionConn,1,3
	
			IF NOT campaignRS.EOF THEN
				Print_campaign=addVar (campaignRS(fieldkey))
			END IF
		
			campaignRs.Close 
			functionConn.Close 
		ELSE
			Print_campaign=Request(fieldkey)
		END IF

	END FUNCTION

	'-------------------------------------------

	sub findCampaign
		camID = request("campaignid")
		query = "select AdID, AdName from ad_data where CampaignID = "&camID&""
		set conn = server.createobject("adodb.connection")
		conn.open DSNad,uid,pwd
		set camNow = Conn.execute (query)
		count = 1
		do while not camNow.eof
		  response.write "<tr><td width=""10%""><input type=""checkbox"" name=""adid"&count&""" value="&camNow("AdID")&" checked></td><td align=""left"" width=""80%""><b><font size=""-1"" COLOR=""#FFFFFF""><span style=""font-family: Arial;"">"&decode(camNow("AdName"))&"</span></font></b></td></tr>"
		  count = count + 1
		camNow.movenext
		loop
		  response.write "<input type=""Hidden"" value="&(count - 1)&" name=""count"">"
		camNow.close
		conn.close

	end sub
 	
</SCRIPT>
