 
  <%
IF Request.Form("selectlocation") = "all" THEN
  
    Set conn=server.CreateObject ("ADODB.Connection")
    Conn.Open DsNAd,uid,pwd
	Query="Select Distinct Target From ad_data Where Status='Active' " 
	
	Set DisTarget=Conn.Execute(Query)
	TargetCount=0
	
	Do While Not DisTarget.EOF
		TargetCount=TargetCount+1
		Session("Location_DB" & TargetCount)=DisTarget("Target")
		DisTarget.MoveNext
	Loop
	DisTarget.Close

	'Find "Adid"
	For TC=1 To TargetCount
		Query="Select Distinct adid from ad_data " &_
			  "Where Status='Active' " &_
			  "And Target='" & Session("Location_DB" & TC) & "'"
		Set Rep=Conn.Execute(Query)
		
		Session("Imp" & TC)=Abandon
		Session("Click" & TC)=Abandon
		Session("Imp" & TC)=0
		Session("Click" & TC)=0
		Session("no_ad"& TC)=0
		
		Do While Not Rep.EOF
		    Session("no_ad"& TC) = Session("no_ad"& TC)+1
			'Find imp and click
			Query="Select Impressions,Clicks From Stats " &_
				  "Where adid=" & Rep("Adid")
			Set Rs_Stats=Conn.Execute(Query)

			'Sum imp and click
			Do While Not Rs_Stats.EOF
				Session("Imp" & TC)=Session("Imp" & TC)+Rs_Stats("Impressions")
				Session("Click" & TC)=Session("Click" & TC)+Rs_Stats("Clicks")
				Rs_Stats.MoveNext
			Loop

			Rs_Stats.Close		
			Rep.MoveNext
		Loop
		Rep.Close
	Next
ELSE
  Response.Redirect "StatsLocation1.asp?SelectLocation="&Request.form("selectlocation")

END IF
'----------------------------------

Function NumberOfads(ByVal Target)
	Query="SELECT COUNT(*) FROM Ad_Data " &_
				  "WHERE Target = '" & Target & "' AND Status='Active' "
	Set NumberOfadsRs=Conn.Execute(Query)
	NumberOfads=NumberOfadsRs(0)
	NumberOfadsRs.close
End Function
%>
<SCRIPT LANGUAGE=Jscript RUNAT=Server>
function encode(str){
	return escape(str);
	}
function decode(str){
	return unescape(str);
	}
</SCRIPT>