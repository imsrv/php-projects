<SCRIPT LANGUAGE=vbscript RUNAT=Server>
  
  SUB ConvertDB(ByVal mUID,ByVal mPWD,ByVal mDataSource)
	Dim QUERY
	Dim ConvertDBRS
	Dim SQL
	Dim ObjConn
	Dim yyyy
	Dim mm
	Dim dd
	Dim ConvertDate
    
    Set ObjConn = CreateObject("ADODB.Connection")

    ObjConn.Open mDataSource,mUID,mPWD

	QUERY="SELECT * FROM ad_data "
	SET ConvertDBRS=Server.CreateObject ("ADODB.Recordset")
	ConvertDBRS.Open QUERY,ObjConn,1,3
	
	DO WHILE NOT ConvertDBRS.EOF
		Dstart=ConvertDBRS("DateStart")
		Dend=ConvertDBRS("DateEnd")
		
			IF IsDate(Dstart) THEN
				IF LEN(year(decode(Dstart)))<>4 THEN
					yyyy="20"&year(decode(Dstart))
				ELSE
					yyyy=year(decode(Dstart))
				END IF
				IF LEN(month(Dstart))<2 THEN
					mm="0"&month(Dstart)
				ELSE
					mm=month(Dstart)
				END IF
				IF LEN(day(Dstart))<2 THEN
					dd="0"&day(Dstart)
				ELSE
					dd=day(Dstart)
				END IF
	
				ConvertDate=yyyy&mm&dd
			END IF
		
		SQL="UPDATE ad_data SET dateStart='"&ConvertDate&"' "
		
		IF Trim(Dend)<>EMPTY THEN
			IF IsDate(Dend) THEN
				IF LEN(year(decode(Dend)))<>4 THEN
					yyyy="20"&year(decode(Dend))
				ELSE
					yyyy=year(decode(Dend))
				END IF
				IF LEN(month(Dend))<2 THEN
					mm="0"&month(Dend)
				ELSE
					mm=month(Dend)
				END IF
				IF LEN(day(Dend))<2 THEN
					dd="0"&day(Dend)
				ELSE
					dd=day(Dend)
				END IF
	
				ConvertDate=yyyy&mm&dd
			END IF

			SQL=SQL&", DateEnd='"&ConvertDate&"' "
		END IF
		
		SQL=SQL&"WHERE adid="&ConvertDBRS("AdId")
		

		ObjConn.Execute (SQL)

		ConvertDBRS.MoveNext
	LOOP
	ConvertDBRS.close
	ObjConn.Close
	
    Session("mUID")=mUID
    Session("mPWD")=mPWD
    Session("mDataSource")=mDataSource
End SUB  
  
  '-----------------------------
  
  SUB ConvertDB2
	Dim QUERY
	Dim ObjConn
    
    Set ObjConn = CreateObject("ADODB.Connection")

    ObjConn.Open Session("mDataSource"),Session("mUID"),Session("mPWD")

	QUERY="UPDATE ad_data SET campaignID=0 , ClickExpire=0"
	ObjConn.Execute (QUERY)
	
	ObjConn.Close
	
	Session("mDataSource")=Abandon
	Session("mUID")=Abandon
	Session("mPWD")=Abandon
  End SUB

</SCRIPT>
<SCRIPT LANGUAGE=JScript RUNAT=Server>
function encode(str) {
	return escape(str);
}

function decode(str) {
	return unescape(str);
}
</SCRIPT>
