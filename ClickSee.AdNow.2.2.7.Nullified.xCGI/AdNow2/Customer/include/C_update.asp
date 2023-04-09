<%@ Language=VBScript %>

<!--#Include File="Cadmin.asp"-->
<%
If Len(Request.Form ("TEXTMSG"))<=255 Then
	Query="Update Ad_Data Set ImageUrl='" & encode(Request.Form ("IMAGEURL")) & "'"
	If Request.Form ("ImageAlt")<>Empty Then
		Query=Query & " , Alt='" & encode(Request.Form ("ImageAlt")) & "'"
	Else
		Query=Query & " , Alt='" & (Request.Form ("ImageAlt")) & "'"
	End If

	If Request.Form ("URL")<>empty then
		Query=Query & " , Url='" & encode(Request.Form ("URL")) & "'"
	Else
		Query=Query & " , Url='" & (Request.Form ("URL")) & "'"
	End If

	If Request.Form ("TEXTMSG")<>empty Then
		Query=Query & " , Textmsg='" & encode(Request.Form ("TEXTMSG")) & "'"
	Else
		Query=Query & " , Textmsg='" & (Request.Form ("TEXTMSG")) & "'"
	End If

	Query=Query & " Where AdID=" & Request.QueryString ("adID")+0
	Conn.Execute (Query)
Else
	Session("MSG")="Sorry.Text msg fix maximum 255 characters."
End If
'------Close conn object----------
		Conn.close
Response.Redirect "../C_ad.asp?ID=" & Request.QueryString ("ID") & "&adID=" & Request.QueryString ("adID")
%>
