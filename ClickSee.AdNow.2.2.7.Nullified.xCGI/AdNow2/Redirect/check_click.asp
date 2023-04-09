<%
IF Time_check<>EMPTY OR Count_check<>EMPTY THEN
	dim usecheck
	dim uselist
	uselist = true
	usecheck = false

	hourNow = Hour(now)
	minNow = Minute(now)
	userIP = Request.ServerVariables("REMOTE_ADDR")
	userPage = Request.ServerVariables("SCRIPT_NAME")
	userTime = hourNow&minNow
	session("currentPage") = userPage
	session("currentTime") = userTime

	If session("oldPage") = empty Then
	  session("oldPage") = userPage
	  session("oldTime") = userTime
	  session("oldCount") = 1

	ElseIf session("oldPage") = session("currentPage") Then

		newTime = (session("oldTime") + 0) + Time_check
		currentTime = (session("currentTime") + 0)
		oldTime = (session("oldTime") + 0)

		IF (oldTime =< currentTime) and (currentTime < newTime )Then
		
		    If (session("oldCount")+0) =< (Count_check+0) Then
		      session("oldCount") = (session("oldCount") + 0) + 1
			  usecheck = true
			else
			  usecheck = false  
		    End If
		Else
		  session("oldCount") = abandon
		  session("oldTime") = (session("currentTime")+0)
		  session("oldCount") = (session("oldCount")+0) + 1
		  usecheck = false
		End If

	ElseIf session("oldPage") <> session("currentPage") Then
		usecheck = true
	  session("currentPage") = abandon
	  session("currentCount") = abandon
	  session("currentTime") = abandon
	  session("oldPage") = abandon
	  session("oldTime") = abandon
	  session("oldCount") = abandon
	End If
END IF
 %>