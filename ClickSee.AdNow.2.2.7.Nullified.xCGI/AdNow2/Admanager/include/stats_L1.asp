  <%'--------------------------AVG Click-----------------------------
    set Conn=Server.CreateObject ("ADODB.Connection")
    Conn.Open DsNAd,uid,pwd
	
	'search target
	Query="Select * From ad_data " &_
		  "Where Status='Active' " &_
		  "and Target='" & Request.QueryString ("SelectLocation") & "' "

	Set DisTarget=Conn.Execute(Query)
	TargetCount=0
	
	
	Do While Not DisTarget.EOF
	
	'-----------------------------------
    
    query="select companyname, customerid from companies " & _
          "where customerid = " & DisTarget("CustomerID") 
		  
	set tmpRS=Conn.Execute (query)
	
	
	'------------------------------------------	 
		TargetCount=TargetCount+1
		Session("CompanyName"& TargetCount)= tmpRS("companyname")
		Session("Adname"& TargetCount) = DisTarget("adName")
		Session("AdID" & TargetCount)=DisTarget("adID")
		Session("Customer" & TargetCount)=tmpRS("CustomerID")
		
		'Find imp and click
		Query="Select Impressions,Clicks From Stats " &_
			  "Where adid=" & DisTarget("adID")
		Set Rs_Stats=Conn.Execute(Query)
			
		Session("Imp" & TargetCount)=Abandon
		Session("Click" & TargetCount)=Abandon
		Session("Imp" & TargetCount)=0
		Session("Click" & TargetCount)=0

		'Sum imp and click
		Do While Not Rs_Stats.EOF
			Session("Imp" & TargetCount)=Session("Imp" & TargetCount)+Rs_Stats("Impressions")
			Session("Click" & TargetCount)=Session("Click" & TargetCount)+Rs_Stats("Clicks")
			Rs_Stats.MoveNext
		Loop
		DisTarget.MoveNext
	Loop
	DisTarget.Close
	tmpRS.Close
	
	'Percent report
	IMPReport=0
	ClickReport=0
	PercentReport=0
	For i=1 to targetcount
		IMPReport=IMPReport+session("Imp" & i)
		ClickReport=ClickReport+Session("Click" & i)
	next
	If IMPReport<>0 Then
		PercentReport=FormatPerCent(ClickReport/IMPReport,2)
	Else
		PercentReport="0.00%"
	End If


%>
<SCRIPT LANGUAGE=Jscript RUNAT=Server>
function encode(str){
	return escape(str);
	}
function decode(str){
	return unescape(str);
	}
</SCRIPT>