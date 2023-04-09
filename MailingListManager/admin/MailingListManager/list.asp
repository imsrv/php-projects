<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/mailinglistmanager.asp" -->
<%
' *** Redirect if username exists
MM_flag="MM_insert"
If (CStr(Request(MM_flag)) <> "") Then
  MM_dupKeyRedirect="list.asp"
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
' *** Edit Operations: declare variables

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

If (CStr(Request("MM_insert")) = "AddEmail") Then

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
set List_Members = Server.CreateObject("ADODB.Recordset")
List_Members.ActiveConnection = MM_mailinglistmanager_STRING
List_Members.Source = "SELECT *  FROM tblMemberList  ORDER BY DateAdded DESC , EmailAddress, Activated"
List_Members.CursorType = 0
List_Members.CursorLocation = 2
List_Members.LockType = 3
List_Members.Open()
List_Members_numRows = 0
%>
<%
Dim Repeat1__numRows
Repeat1__numRows = -1
Dim Repeat1__index
Repeat1__index = 0
List_Members_numRows = List_Members_numRows + Repeat1__numRows
%>
<html>
<head>
<title>List</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<SCRIPT RUNAT=SERVER LANGUAGE=VBSCRIPT>					
function DoDateTime(str, nNamedFormat, nLCID)				
	dim strRet								
	dim nOldLCID								
	strRet = str								
	If (nLCID > -1) Then							
		oldLCID = Session.LCID						
	End If									
	On Error Resume Next							
	If (nLCID > -1) Then							
		Session.LCID = nLCID						
	End If									
	If ((nLCID < 0) Or (Session.LCID = nLCID)) Then				
		strRet = FormatDateTime(str, nNamedFormat)			
	End If									
	If (nLCID > -1) Then							
		Session.LCID = oldLCID						
	End If									
	DoDateTime = strRet							
End Function									
</SCRIPT>
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
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--#include file="header.asp" -->
<!--#include file="inc_metrics.asp" -->
<form action="<%=MM_editAction%>" method="POST" name="AddEmail" id="AddEmail" onSubmit="MM_validateForm('EmailAddress','','RisEmail');return document.MM_returnValue">
<% If Not Request.QueryString("requsername") <> "" Then %>
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td width="18%" height="27">Add Email Address</td>
    <td width="82%" valign="middle">
      <input name="EmailAddress" type="text" id="EmailAddress" size="30">
      <input name="Submit2" type="submit" value="Add Email Address to List" size="10" height="10">
      <input name="result" type="hidden" id="result" value="success">
      <input name="Activated" type="hidden" id="Activated" value="True">
      <input type="hidden" name="MM_insert" value="AddEmail">
      <% If Request.Form("result") = "success" Then %>
       <font color="#FF0000" size="2"><strong> <%=(List_Members.Fields.Item("EmailAddress").Value)%>&nbsp;Successfully Added</strong></font>
      <% End If%>  
</td>
  </tr>
</table>
<%end if%>
<% If Request.QueryString("requsername") <> "" Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
			 <p>The email address: <strong><%=Request.QueryString("requsername")%></strong> is
			   already in our database.....<a href="javascript:history.go(-1);">Please
		   try again                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       </a>. </p>
			
		    </td>
          </tr>
</table> <%End If%>
</form>
<form action="update_list.asp" method="post">
<table width="100%" height="32" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr class="tableheader"> 
    <td colspan="2"> Date Added</td>
    <td width="18%">Member</td>
    <td width="22%">Update Address</td>
    <td width="10%"><div align="center">Activated</div></td>
    <td width="7%"><div align="center"></div>      
    <div align="center">Delete</div></td>
    <td width="26%"><div align="center">Metrics</div></td>
  </tr>
<% Dim iCount
  iCount = 0
%>
  <% 
While ((Repeat1__numRows <> 0) AND (NOT List_Members.EOF)) 
%>
  <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>"> 
    <td width="2%" height="13">      <strong>
    <%Response.Write(RecordCounter)
RecordCounter = RecordCounter%>.      </strong>   </td>
    <td width="15%" height="13"><%=(List_Members.Fields.Item("DateAdded").Value)%></td>
    <td width="18%" height="13"><a href="mailto:%20<%=(List_Members.Fields.Item("EmailAddress").Value)%>"><%=(List_Members.Fields.Item("EmailAddress").Value)%></a> </td>
    <td width="22%" height="13"><input name="<%= (iCount & ".EmailAddress") %>" type="text" value="<%=(List_Members.Fields.Item("EmailAddress").Value)%>" size="30">
      <input name="<%= (iCount & ".ID") %>" type="hidden" value="<%=(List_Members.Fields.Item("MemberID").Value)%>"></td>
    <td width="10%" height="13" align="center"><label>
      <input <%If (CStr((List_Members.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("CHECKED") : Response.Write("")%> type="radio" name="<%= (iCount & ".Activated") %>" value="True">
Yes</label>      <label>
      <input <%If (CStr((List_Members.Fields.Item("Activated").Value)) = CStr("False")) Then Response.Write("CHECKED") : Response.Write("")%> type="radio" name="<%= (iCount & ".Activated") %>" value="False">
No</label></td>
    <td height="13">      <div align="center">
          <label>          </label>
      </div>      <div align="center">
        <input name="<%= (iCount & ".Check") %>" type="checkbox" value="Remove">
      </div>
    </td>
    <td height="13">  Emails Sent = <strong><%=(List_Members.Fields.Item("SentMessages").Value)%></strong> 
	<% If List_Members.Fields.Item("SentMessages").Value > "0" Then %>
	| Last Sent = <strong><%= DoDateTime((List_Members.Fields.Item("LastMessageDate").Value), 1, 2057) %></strong><%end if%></td>
  </tr>
  <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  List_Members.MoveNext()
  iCount = iCount + 1
Wend
%>
</table>
<p>
  <input name="Submit" type="submit" id="Submit" value="Update">
  <input type="hidden" name="Count" value="<%= iCount - 1 %>">
</p>
</form>
</body>
</html>
<%
List_Members.Close()
%>
