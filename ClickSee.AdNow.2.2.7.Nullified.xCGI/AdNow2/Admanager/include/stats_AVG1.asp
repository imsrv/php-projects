<% if Request.Form ("Location") = "" then
    session("errMessage") = "Please select location !"
    Response.Redirect ("StatsAVG.asp")
   end if 
   
   day_view = Request.Form ("day")
   adlocation = Request.Form ("Location")

   Set conn=server.CreateObject ("ADODB.Connection")
    Conn.Open DsNAd,uid,pwd
    
    'Find Adweight
       Query="Select Distinct adweight from ad_data " &_
			  "Where (Status='Active' or Status='Expired') " &_
			  "And Target='" & adlocation & "'"
		Set Weight=Conn.Execute(Query)
        session("Wcount") = 0
        Wcount = 0
        Do While Not Weight.EOF
           Wcount = Wcount +1
           Session("adweight" & Wcount) = Weight("adweight")

	'Find "Adid"
	
		Query="Select Distinct adid from ad_data " &_
			  "Where (Status='Active' or Status='Expired') " &_
			  "And adweight =" & Weight("adweight") & " " &_
			  "And Target='" & adlocation & "'"
			  
		Set Rep=Conn.Execute(Query)

		Session("Imp" & wcount)=Abandon
		Session("Click" & wcount)=Abandon
		Session("Imp" & wcount)=0
		Session("Click" & wcount)=0
		Session("no_ad" & wcount)=0
		
		Do While Not Rep.EOF
		    Session("no_ad" & wcount) = Session("no_ad" & wcount)+1
		    
		    'Check number of day
		    if day_view <= 0 then
			   day_view = 30     
			end if 
		    Session("dayview")= day_view
		    Temp = date() - (day_view)
		   
		    
		    'Change date format
		    Vdate = month(Temp) & "/" & day(Temp) & "/" & year(Temp)
		    
			session("Vdate")=Vdate
			'Find imp and click
			
			CQuery="Select * From Stats " &_
			       "Where adid=" & Rep("Adid")&" "&_
			       "And datelog=" &Vdate& " "
			set Dateend=Conn.Execute (CQuery)
			
			Do while Dateend.EOF 
			  Dateend.close
			  Temp = Temp+1
			  Vdate = month(Temp) & "/" & day(Temp) & "/" & year(Temp)
			  
			    CQuery="Select * From Stats " &_
			       "Where adid=" & Rep("Adid")&" "&_
			       "And datelog='" &Vdate& "' "
			    set Dateend=Conn.Execute (CQuery)
				if Temp = date() then 
                exit do
				end if
			loop
			
			if not Dateend.EOF then
			SQuery="Select sum(Impressions), sum(Clicks) From Stats" & _
			       " Where adid= " & Rep("Adid") & _
			       " And ID >= " & Dateend("ID")
            set Rs = Conn.Execute (SQuery)
            
            if not Rs.EOF then    
             	Session("Imp" & wcount)= Session("Imp" & wcount)+ rs(0)
             	Session("Click" & wcount)= Session("Click" & wcount)+rs(1)   
            end if
            Rs.Close 	  
			
	    	'Sum imp and click
			
			Today = month(date()) &"/"& day(date()) &"/"& year(date())
			for  i=1 to Session("dayview")
			 session("day" & i) = abandon
			 session("day" & i) = month(date()-i) &"/"& day(date()-i) &"/"& year(date()-i)
			next
             tmp = ""
			
			for  i=1 to Session("dayview")
			    QueryD="Select AdID ,Impressions, Clicks From Stats " &_
					   "Where Datelog = '" &session("day" & i)& "' " &_
					   "Order by AdID desc"
			    set RsD = Conn.Execute(QueryD)
				
				Do while not RsD.EOF    
				if RsD("AdID") = Rep("Adid")then
				session("adofday" & i & wcount) = session("adofday" & i & wcount)+1
				Session("d" &i& "Imp" & wcount)= Session("d" &i& "Imp" & wcount)+ RsD("Impressions")
             	Session("d" &i& "Click" & wcount)= Session("d" &i& "Click" & wcount)+RsD("Clicks")   
              	end if
				RsD.MoveNext
				Loop
                RsD.Close 	
			
			 next
		
		   end if
			Rep.MoveNext
		Loop
		Rep.Close
		
	Weight.MoveNext

    Loop
    Session("Wcount") = Wcount
    Weight.Close
	


%>
