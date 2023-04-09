 
  <%
    Set conn=server.CreateObject ("ADODB.Connection")
    Conn.Open DsNAd,uid,pwd
	Query="Select Distinct Target From ad_data Where Status='Active' " 
	
	Set DisTarget=Conn.Execute(Query)
	TargetCount=0
	
	Session("LNo")=abandon
	Session("LNo")=0
	
	Do While Not DisTarget.EOF
		TargetCount=TargetCount+1
		Session("Location_DB" & TargetCount)=DisTarget("Target")
		DisTarget.MoveNext
	Loop
	Session("LNo")=TargetCount
	DisTarget.Close

%>
