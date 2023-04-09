<!--#Include File="../Data_Connection/Connection.asp"-->
<SCRIPT LANGUAGE=vbscript RUNAT=Server>

'Check submit.
IF Request.ServerVariables ("Content_Length")>0 THEN
	IF request("username")<>EMPTY AND request("password1")<>EMPTY THEN
		
		SET AdminRs=adnowConn.Execute ("Select * from admin")

		'First time.
		IF AdminRs.EOF AND request("password2")<>EMPTY AND request("password2")=request("password1") THEN
			SQL="insert into admin(username,password) values('" &_
						encode(request("username")) & "','" &_
						encode(request("password1")) & "')"
			adnowConn.Execute (SQL)
		ELSEIF AdminRs.EOF AND request("password2")<>EMPTY THEN
			Session("MSG")="Please enter confirm password."
'			ErrMSG
		ELSEIF AdminRs.EOF AND request("password1")<>request("password2") THEN
			Session("MSG")="Password not correct."
'			ErrMSG
		END IF
		AdminRs.close
		
		SQL="select * from admin where Username='" &_
					encode(request("username")) & "' and password='" &_
					encode(request("password1")) & "'"
		SET SearchAC=adnowConn.Execute (SQL)
		IF NOT searchAC.EOF THEN
			SearchAC.Close
			Session("username")=encode(request("username"))
			Session("password")=encode(request("password1"))
			EndSession
			Response.Redirect "adcenter.asp"
		ELSE
			Session("MSG")="<font color=""#FFFFFF"">Incorrect user name or password. Please try again.</font>"
'			ErrMSG
		END IF
		SearchAC.Close

	ELSE
		Session("MSG")="Please enter username and password."
'		ErrMSG
	END IF
'	EndSession
	Response.Redirect "default.asp"
END IF

</SCRIPT>

