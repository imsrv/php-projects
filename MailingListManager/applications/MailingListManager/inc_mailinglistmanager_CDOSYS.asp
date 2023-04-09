<!--#include virtual="/Connections/mailinglistmanager.asp" -->
<%
Dim preferences
Dim preferences_numRows
Set preferences = Server.CreateObject("ADODB.Recordset")
preferences.ActiveConnection = MM_mailinglistmanager_STRING
preferences.Source = "SELECT *  FROM tblMailingListManagerPreferences"
preferences.CursorType = 0
preferences.CursorLocation = 2
preferences.LockType = 1
preferences.Open()
preferences_numRows = 0
%>
<%
if(Request.form("subscribe") = "yes") then
%>
<%
' *** Redirect if username exists
MM_flag="MM_insert"
If (CStr(Request(MM_flag)) <> "") Then
  MM_dupKeyRedirect= Request.ServerVariables("HTTP_REFERER")
  MM_rsKeyConnection=MM_mailinglistmanager_STRING
  MM_dupKeyUsernameValue = CStr(Request.Form("EmailAddress"))
  MM_dupKeySQL="SELECT EmailAddress FROM tblMemberList WHERE EmailAddress='" & MM_dupKeyUsernameValue & "'"
  MM_adodbRecordset="ADODB.Recordset"
  set MM_rsKey=Server.CreateObject(MM_adodbRecordset)
  MM_rsKey.ActiveConnection=MM_rsKeyConnection
  MM_rsKey.Source=MM_dupKeySQL
  MM_rsKey.CursorType=0
  MM_rsKey.CursorLocation=2
  MM_rsKey.LockType=3
  MM_rsKey.Open
  If Not MM_rsKey.EOF Or Not MM_rsKey.BOF Then 
    ' the username was found - can not add the requested username
    MM_qsChar = "?"
    If (InStr(1,MM_dupKeyRedirect,"?") >= 1) Then MM_qsChar = "&"
    MM_dupKeyRedirect = MM_dupKeyRedirect & MM_qsChar & "requsername=" & MM_dupKeyUsernameValue
    Response.Redirect(MM_dupKeyRedirect)
  End If
  MM_rsKey.Close
End If
%>
<%
' *** SUBSCRIBE=YES - Edit Operations: declare variables Adding
Dim MM_editAction
Dim MM_abortEdit
Dim MM_editQuery
Dim MM_editCmd

Dim MM_editConnection
Dim MM_editTable
Dim MM_editRedirectUrl
Dim MM_editColumn
Dim MM_recordId

Dim MM_fieldsStr
Dim MM_columnsStr
Dim MM_fields
Dim MM_columns
Dim MM_typeArray
Dim MM_formVal
Dim MM_delim
Dim MM_altVal
Dim MM_emptyVal
Dim MM_i

MM_editAction = CStr(Request.ServerVariables("SCRIPT_NAME"))
If (Request.QueryString <> "") Then
  MM_editAction = MM_editAction & "?" & Request.QueryString
End If

' boolean to abort record edit
MM_abortEdit = false

' query string to execute
MM_editQuery = ""
%>
<%
' *** Insert Record: set variables

If (CStr(Request("MM_insert")) = "form1") Then

  MM_editConnection = MM_mailinglistmanager_STRING
  MM_editTable = "tblMemberList"
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "EmailAddress|value|Activated|value"
  MM_columnsStr = "EmailAddress|',none,''|Activated|',none,''"

  ' create the MM_fields and MM_columns arrays
  MM_fields = Split(MM_fieldsStr, "|")
  MM_columns = Split(MM_columnsStr, "|")
  
  ' set the form values
  For MM_i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_fields(MM_i+1) = CStr(Request.Form(MM_fields(MM_i)))
  Next

  ' append the query string to the redirect URL
  If (MM_editRedirectUrl <> "" And Request.QueryString <> "") Then
    If (InStr(1, MM_editRedirectUrl, "?", vbTextCompare) = 0 And Request.QueryString <> "") Then
      MM_editRedirectUrl = MM_editRedirectUrl & "?" & Request.QueryString
    Else
      MM_editRedirectUrl = MM_editRedirectUrl & "&" & Request.QueryString
    End If
  End If

End If
%>
<%
' *** Insert Record: construct a sql insert statement and execute it

Dim MM_tableValues
Dim MM_dbValues

If (CStr(Request("MM_insert")) <> "") Then

  ' create the sql insert statement
  MM_tableValues = ""
  MM_dbValues = ""
  For MM_i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_formVal = MM_fields(MM_i+1)
    MM_typeArray = Split(MM_columns(MM_i+1),",")
    MM_delim = MM_typeArray(0)
    If (MM_delim = "none") Then MM_delim = ""
    MM_altVal = MM_typeArray(1)
    If (MM_altVal = "none") Then MM_altVal = ""
    MM_emptyVal = MM_typeArray(2)
    If (MM_emptyVal = "none") Then MM_emptyVal = ""
    If (MM_formVal = "") Then
      MM_formVal = MM_emptyVal
    Else
      If (MM_altVal <> "") Then
        MM_formVal = MM_altVal
      ElseIf (MM_delim = "'") Then  ' escape quotes
        MM_formVal = "'" & Replace(MM_formVal,"'","''") & "'"
      Else
        MM_formVal = MM_delim + MM_formVal + MM_delim
      End If
    End If
    If (MM_i <> LBound(MM_fields)) Then
      MM_tableValues = MM_tableValues & ","
      MM_dbValues = MM_dbValues & ","
    End If
    MM_tableValues = MM_tableValues & MM_columns(MM_i)
    MM_dbValues = MM_dbValues & MM_formVal
  Next
  MM_editQuery = "insert into " & MM_editTable & " (" & MM_tableValues & ") values (" & MM_dbValues & ")"

  If (Not MM_abortEdit) Then
    ' execute the insert
    Set MM_editCmd = Server.CreateObject("ADODB.Command")
    MM_editCmd.ActiveConnection = MM_editConnection
    MM_editCmd.CommandText = MM_editQuery
    MM_editCmd.Execute
    MM_editCmd.ActiveConnection.Close

    If (MM_editRedirectUrl <> "") Then
      Response.Redirect(MM_editRedirectUrl)
    End If
  End If

End If
%>
<%
' Declare variables for subscribe email
 Header = (preferences.Fields.Item("SubscribeMessage").Value) & vbCrLf & vbCrLf & "You Subscribed on " & Now() & vbCrLf & vbCrLf
 Footer = "Thank You for Joining the " & (preferences.Fields.Item("MailingListTitle").Value) & vbCrLf & vbCrLf & "unsubscribe link:" & vbCrLf & (preferences.Fields.Item("UnsubscribeLink").Value) & "?email=" & Request.Form("EmailAddress") & "&subscribe=no"
 ' read all the form elements and place them in the variable mail_body
    mail_Body = Header
    mail_Body = mail_Body & (preferences.Fields.Item("SubscribeConfirmationEmailMessage").Value)
    mail_Body = mail_Body & vbCrLf & vbCrLf & Footer
    'Create the mail object and send the mail
	subject = (preferences.Fields.Item("MailingListTitle").Value) & " - " & (preferences.Fields.Item("SubscribeMessage").Value)

' Send Email to Member 
Set objMailMember = Server.CreateObject("CDO.Message")
Set objCDOSYSConMember = Server.CreateObject ("CDO.Configuration") 
Set Flds = objCDOSYSConMember.Fields

'Out going SMTP server 
objCDOSYSConMember.Fields("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2
objCDOSYSConMember.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "mail.yourdomain.com"
objCDOSYSConMember.Fields("http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout") = 60 
objCDOSYSConMember.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25 
objCDOSYSConMember.Fields.Update 

set objMailMember.Configuration = objCDOSYSConMember
	
	
	objMailMember.From = (preferences.Fields.Item("FromEmailAddress").Value)
	objMailMember.To = Request.Form("EmailAddress")
	objMailMember.CC = ""
	objMailMember.BCC = ""
	objMailMember.Subject = subject
	objMailMember.TextBody = mail_Body 
	objMailMember.Send()
Set objMailMember = Nothing
'' Send Email to Admin

Set objMailAdmin = Server.CreateObject("CDO.Message")
Set objCDOSYSConAdmin = Server.CreateObject ("CDO.Configuration") 
Set Flds = objCDOSYSConAdmin.Fields

'Out going SMTP server 
objCDOSYSConAdmin.Fields("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2
objCDOSYSConAdmin.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "mail.yourdomain.com"
objCDOSYSConAdmin.Fields("http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout") = 60 
objCDOSYSConAdmin.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25 
objCDOSYSConAdmin.Fields.Update 

set objMailAdmin.Configuration = objCDOSYSConAdmin


	objMailAdmin.From = Request.Form("EmailAddress")
	objMailAdmin.To = (preferences.Fields.Item("FromEmailAddress").Value)
	objMailAdmin.CC = ""
	objMailAdmin.BCC = ""
	objMailAdmin.Subject = Request.Form("EmailAddress") & " - has SUBSCRIBED to mailing list - " & (preferences.Fields.Item("MailingListTitle").Value)
	objMailAdmin.TextBody = Request.Form("EmailAddress") & " - has subscribed to mailing list - " & (preferences.Fields.Item("MailingListTitle").Value)
	objMailAdmin.Send()
Set objMailAdmin = Nothing
%>
<% End If%>
<%
if(Request.form("subscribe") = "no") then
%>
<%
' *** Redirect if username exists
MM_flag="MM_insert"
If (CStr(Request(MM_flag)) <> "") Then
  MM_dupKeyRedirect= Request.ServerVariables("HTTP_REFERER")
  MM_rsKeyConnection=MM_mailinglistmanager_STRING
  MM_dupKeyUsernameValue = CStr(Request.Form("EmailAddress"))
  MM_dupKeySQL="SELECT EmailAddress FROM tblMemberList WHERE EmailAddress='" & MM_dupKeyUsernameValue & "'"
  MM_adodbRecordset="ADODB.Recordset"
  set MM_rsKey=Server.CreateObject(MM_adodbRecordset)
  MM_rsKey.ActiveConnection=MM_rsKeyConnection
  MM_rsKey.Source=MM_dupKeySQL
  MM_rsKey.CursorType=0
  MM_rsKey.CursorLocation=2
  MM_rsKey.LockType=3
  MM_rsKey.Open
  If MM_rsKey.EOF Or MM_rsKey.BOF Then 
    ' the username was found - can not add the requested username
    MM_qsChar = "?"
    If (InStr(1,MM_dupKeyRedirect,"?") >= 1) Then MM_qsChar = "&"
    MM_dupKeyRedirect = MM_dupKeyRedirect & MM_qsChar & "requsername1=" & MM_dupKeyUsernameValue
    Response.Redirect(MM_dupKeyRedirect)
  End If
  MM_rsKey.Close
End If
%>
<%
if(request.form("EmailAddress") <> "") then removeemail__value1 = request.form("EmailAddress")
%>
<%
set removeemail = Server.CreateObject("ADODB.Command")
removeemail.ActiveConnection = MM_mailinglistmanager_STRING
removeemail.CommandText = "DELETE FROM tblMemberList  WHERE EmailAddress =  '" + Replace(removeemail__value1, "'", "''") + " '"
removeemail.CommandType = 1
removeemail.CommandTimeout = 0
removeemail.Prepared = true
removeemail.Execute()
%>
<%
' Declare variables for Unsubscribe email
 Header = (preferences.Fields.Item("UnsubscribeMessage").Value) & vbCrLf & vbCrLf & "You unsubscribed from the " & (preferences.Fields.Item("MailingListTitle").Value) & " on " & Now() & vbCrLf & vbCrLf
 Footer = "http://www." & Request.ServerVariables("SERVER_NAME")
 ' read all the form elements and place them in the variable mail_body
    Dim mail_Body
    mail_Body = Header
    mail_Body = mail_Body & (preferences.Fields.Item("UnsubscribeConfirmationEmailMessage").Value)
    mail_Body = mail_Body & vbCrLf & vbCrLf & Footer 
    'Create the mail object and send the mail
	subject = (preferences.Fields.Item("UnsubscribeMessage").Value)
%>
<%
' Send Email to Member 

Set objMailMember = Server.CreateObject("CDO.Message")
Set objCDOSYSConMember = Server.CreateObject ("CDO.Configuration") 
Set Flds = objCDOSYSConMember.Fields

'Out going SMTP server 
objCDOSYSConMember.Fields("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2
objCDOSYSConMember.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "mail.yourdomain.com"
objCDOSYSConMember.Fields("http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout") = 60 
objCDOSYSConMember.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25 
objCDOSYSConMember.Fields.Update 

set objMailMember.Configuration = objCDOSYSConMember

	objMailMember.From = (preferences.Fields.Item("FromEmailAddress").Value)
	objMailMember.To = Request.Form("EmailAddress")
	objMailMember.CC = ""
	objMailMember.BCC = ""
	objMailMember.Subject = subject
	objMailMember.TextBody = mail_Body 
	objMailMember.Send()
Set objMailMember = Nothing
'' Send Email to Admin

Set objMailAdmin = Server.CreateObject("CDO.Message")
Set objCDOSYSConAdmin = Server.CreateObject ("CDO.Configuration") 
Set Flds = objCDOSYSConAdmin.Fields

'Out going SMTP server 
objCDOSYSConAdmin.Fields("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2 
objCDOSYSConAdmin.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "mail.yourdomain.com"
objCDOSYSConAdmin.Fields("http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout") = 60 
objCDOSYSConAdmin.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25 
objCDOSYSConAdmin.Fields.Update 

set objMailAdmin.Configuration = objCDOSYSConAdmin

	objMailAdmin.From = Request.Form("EmailAddress")
	objMailAdmin.To = (preferences.Fields.Item("FromEmailAddress").Value)
	objMailAdmin.CC = ""
	objMailAdmin.BCC = ""
	objMailAdmin.Subject = Request.Form("EmailAddress") & " - has UNSUBSCRIBED from mailing list - " & (preferences.Fields.Item("MailingListTitle").Value)
	objMailAdmin.TextBody = Request.Form("EmailAddress") & " - has UNSUBSCRIBED from mailing list - " & (preferences.Fields.Item("MailingListTitle").Value)
	objMailAdmin.Send()
Set objMailAdmin = Nothing
%>
<% End If%>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<% If Not Request.QueryString("requsername") <> "" Then %>
<% If Not Request.QueryString("requsername1") <> "" Then %>
<% If Request.Form("subscribe") <> "no" Then %>
<% If Request.Form("subscribe") <> "yes" Then %>
<link href="../../styles.css" rel="stylesheet" type="text/css">

<form action="<%=MM_editAction%>" method="POST" name="form1" onSubmit="MM_validateForm('EmailAddress','','RisEmail');return document.MM_returnValue">

        <table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td><strong>Join the <%=(preferences.Fields.Item("MailingListTitle").Value)%> Mailing List</strong></td>
          </tr>
          <tr>
            <td>Your  email address: 
              <input name="EmailAddress" type="text" id="EmailAddress" value=	"<%=Request.QueryString("email")%>" size="20" maxlength="40"> 
            </td>
          </tr>
          <tr>
            <td><input <%If (CStr(Request.QueryString("subscribe")) = CStr("yes")) Then Response.Write("CHECKED") : Response.Write("")%> type="radio" name="subscribe" value="yes" checked>
Yes
  <input <%If (CStr(Request.QueryString("subscribe")) = CStr("no")) Then Response.Write("CHECKED") : Response.Write("")%> type="radio" name="subscribe" value="no" >
No 
 <% If Request.QueryString("subscribe") = "no" Then %>
<input type="submit" name="Submit" value="UnSubscribe">
<%else%>
<input type="submit" name="Submit" value="Subscribe">
<%end if%>
<input name="DeActivated" type="hidden" id="DeActivated2" value="False">
<input name="Activated" type="hidden" id="Activated2" value="True"></td>
          </tr>
          <tr>
          </tr>
  </table>       

                <input type="hidden" name="MM_insert" value="form1">
</form>
<%End If%>
<%End If%>
<%End If%>
<%End If%>
         <% If Request.Form("subscribe") = "yes" Then %>
		 <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
		 
            <td><p>Thank you for Joining</p>
              
              <strong><%=Request.Form("EmailAddress")%></strong>&nbsp;has been added to <%=(preferences.Fields.Item("MailingListTitle").Value)%>'s Mailing List</td>
          </tr>
        </table><% End If%>
<% If Request.QueryString("requsername") <> "" Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
			 <p>The email address: <strong><%=Request.QueryString("requsername")%></strong> is
			   already in our database.....<a href="javascript:history.go(-1);">Please
		   try again</a>. </p>
			
		    </td>
          </tr>
</table> <%End If%>
<% If Request.QueryString("requsername1") <> "" Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
			 <p>The email address is not in our database. <strong><%=Request.QueryString("requsername")%></strong><a href="javascript:history.go(-1);">Please
		   try again</a>. </p>
			
		    </td>
          </tr>
</table> <%End If%>
<% If Request.Form("subscribe") = "no" Then %>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>              <br>
Your email <strong><%=Request.Form("EmailAddress")%></strong>&nbsp;address been
removed from the 
<%=(preferences.Fields.Item("MailingListTitle").Value)%>.<br>
<br>
Sorry for any inconvenience.
<br></td></tr>
        </table>
		<%End If%>
        <%
preferences.Close()
Set preferences = Nothing
%>
