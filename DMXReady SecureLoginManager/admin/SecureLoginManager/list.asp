<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/secureloginmanager.asp" -->
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
' *** Redirect if username exists
MM_flag="MM_insert"
If (CStr(Request(MM_flag)) <> "") Then
  MM_dupKeyRedirect="list.asp"
  MM_rsKeyConnection=MM_secureloginmanager_STRING
  MM_dupKeyUsernameValue = CStr(Request.Form("UserName"))
  MM_dupKeySQL="SELECT UserName FROM tblMM_Members WHERE UserName='" & MM_dupKeyUsernameValue & "'"
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
' *** Insert Record: set variables

If (CStr(Request("MM_insert")) = "InsertForm") Then

  MM_editConnection = MM_secureloginmanager_STRING
  MM_editTable = "tblMM_Members"
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "FirstName|value|LastName|value|EmailAddress|value|UserName|value|Password|value|SecurityLevelID|value|Activated|value"
  MM_columnsStr = "FirstName|',none,''|LastName|',none,''|EmailAddress|',none,''|UserName|',none,''|Password1|',none,''|SecurityLevelID|none,none,NULL|Activated|',none,''"

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
Dim members__MMColParam1
members__MMColParam1 = "%"
If (Request.Form("search")   <> "") Then 
  members__MMColParam1 = Request.Form("search")  
End If
%>
<%
set members = Server.CreateObject("ADODB.Recordset")
members.ActiveConnection = MM_secureloginmanager_STRING
members.Source = "SELECT tblMM_Members.*, tblSLM_Security.SecurityLevelName  FROM tblMM_Members LEFT JOIN tblSLM_Security ON tblMM_Members.SecurityLevelID = tblSLM_Security.SecurityLevelID  WHERE tblSLM_Security.SecurityLevelName Like '" + Replace(members__MMColParam1, "'", "''") + "'  OR tblMM_Members.FirstName Like '%" + Replace(members__MMColParam1, "'", "''") + "%'  OR tblMM_Members.LastName Like '%" + Replace(members__MMColParam1, "'", "''") + "%'  ORDER BY tblMM_Members.SecurityLevelID,  tblMM_Members.DateAdded"
members.CursorType = 0
members.CursorLocation = 2
members.LockType = 3
members.Open()
members_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_secureloginmanager_STRING
Category.Source = "SELECT tblSLM_Security.*  FROM tblSLM_Security  ORDER BY tblSLM_Security.SecurityLevelID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = -1
Repeat1__index = 0
members_numRows = members_numRows + Repeat1__numRows
%>
<html>
<head>
<title>Secure Login Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
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
</head>
<body>
<!--#include file="header.asp" -->
<table width="100%" height="23" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr> 
    <td height="21" width="50%"> 
      <form name="form1" method="post" action="">
        <div align="center">Search by Department
          <select name="Search" id="Search">
          <option value="%" <%If (Not isNull(Request.Form("search"))) Then If ("%" = CStr(Request.Form("search"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show
          All</option>
          <%
While (NOT Category.EOF)
%>
          <option value="<%=(Category.Fields.Item("SecurityLevelName").Value)%>" <%If (Not isNull(Request.Form("search"))) Then If (CStr(Category.Fields.Item("SecurityLevelName").Value) = CStr(Request.Form("search"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("SecurityLevelName").Value)%></option>
          <%
  Category.MoveNext()
Wend
If (Category.CursorType > 0) Then
  Category.MoveFirst
Else
  Category.Requery
End If
%>
          </select>
          <input type="submit" value="Go" name="submit2">
        </div>
      </form>
    </td>
    <td height="21" width="50%"> 
      <form name="form" method="post" action="">
        <div align="center">Search by Name
          <input type="text" name="Search">
          <input type="submit" value="Go" name="submit">
        </div>
      </form>
    </td>
  </tr>
</table>
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="InsertForm" id="InsertForm" onSubmit="MM_validateForm('FirstName','','R','EmailAddress','','RisEmail','UserName','','R','Password','','R','FirstName&quot;) %&gt;','','iCount &amp; &quot;.FirstName&quot;','LastName&quot;) %&gt;','','iCount &amp; &quot;.LastName&quot;','EmailAddress&quot;) %&gt;','','iCount &amp; &quot;.EmailAddress&quot;','UserName&quot;) %&gt;','','iCount &amp; &quot;.UserName&quot;','Password1&quot;) %&gt;','','iCount &amp; &quot;.Password1&quot;');return document.MM_returnValue">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr class="tableheader">
    <td width="0" height="16">Member Name</td>
    <td width="0">Email Address</td>
    <td width="0">Username</td>
    <td width="0">Password</td>
    <td width="0">Security Level</td>
    <td width="0">    </td>
  </tr>
    <tr>
    <td width="0" height="13">
      <input name="FirstName" type="text" size="10">
      <input name="LastName" type="text" id="LastName" size="15">
    </td>
    <td width="0" height="13"><input name="EmailAddress" type="text" id="EmailAddress" size="20">
    </td>
    <td width="0" height="13"><input name="UserName" type="text" id="UserName" size="20">
    </td>
    <td width="0" height="13"><input name="Password" type="text" id="Password" size="20">
    </td>
    <td width="0" height="13"><select name="SecurityLevelID" id="SecurityLevelID">
      <%
While (NOT Category.EOF)
%>
      <option value="<%=(Category.Fields.Item("SecurityLevelID").Value)%>"><%=(Category.Fields.Item("SecurityLevelID").Value)%>&nbsp;|&nbsp;<%=(Category.Fields.Item("SecurityLevelName").Value)%></option>
      <%
  Category.MoveNext()
Wend
If (Category.CursorType > 0) Then
  Category.MoveFirst
Else
  Category.Requery
End If
%>
        </select>
      <input name="Activated" type="hidden" id="Activated" value="True">
    </td>
    <td width="0" height="13"><div align="center"><input name="Insert" type="submit" id="Insert" value="Insert New">
</div>
    </td>
  </tr>
</table>
<% If Request.QueryString("requsername") <> "" Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
			 <p>The Username: <strong><%=Request.QueryString("requsername")%></strong> is
			   already in our database.....<a href="javascript:history.go(-1);">Please
		   try again                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       </a>. </p>
			
		    </td>
          </tr>
</table> <%End If%>
<input type="hidden" name="MM_insert" value="InsertForm">
</form>
<% If Not members.EOF Or Not members.BOF Then %>
<form action="update_list.asp" method="post">
  <table width="100%" height="32" border="0" cellpadding="0" cellspacing="0" class="tableborder">
    <tr class="tableheader">
      <td width="1%">&nbsp; </td>
      <td width="0">Member Name</td>
      <td width="0">Email Address</td>
      <td width="0">Username</td>
      <td width="0">Password</td>
      <td width="0">Security Level</td>
      <td width="0"><div align="center">Login Count</div></td>
      <td width="0"><div align="center">Last Date</div></td>
      <td width="0"><div align="center">Activated</div>
      </td>
      <td width="0"><div align="center"></div>
          <div align="center">Delete</div>
      </td>
      <td width="0"><div align="center"></div>
      </td>
    </tr>
    <% Dim iCount
  iCount = 0
%>
    <% 
While ((Repeat1__numRows <> 0) AND (NOT members.EOF)) 
%>
    <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>">
      <td width="0" height="13"> <strong>
        <%Response.Write(RecordCounter)
RecordCounter = RecordCounter%>
        . </strong> <div align="center"></div>
      </td>
      <td width="0" height="13">
        <input name="<%= (iCount & ".FirstName") %>" type="text" value="<%=(members.Fields.Item("FirstName").Value)%>" size="8">
		<input name="<%= (iCount & ".LastName") %>" type="text" value="<%=(members.Fields.Item("LastName").Value)%>" size="10">
      </td>
      <td width="0" height="13"><input name="<%= (iCount & ".EmailAddress") %>" type="text" value="<%=(members.Fields.Item("EmailAddress").Value)%>" size="15">
      </td>
      <td width="0" height="13"><input name="<%= (iCount & ".UserName") %>" type="text" value="<%=(members.Fields.Item("UserName").Value)%>" size="15"></td>
      <td width="0" height="13"><input name="<%= (iCount & ".Password1") %>" type="text" value="<%=(members.Fields.Item("Password1").Value)%>" size="15"></td>
      <td width="0" height="13"><input name="<%= (iCount & ".MemberID") %>" type="hidden" value="<%=(members.Fields.Item("MemberID").Value)%>">
          <select name="<%= (iCount & ".SecurityLevelID") %>" id="<%= (iCount & ".SecurityLevelID") %>">
            <%
While (NOT Category.EOF)
%>
            <option value="<%=(Category.Fields.Item("SecurityLevelID").Value)%>" <%If (Not isNull((members.Fields.Item("SecurityLevelID").Value))) Then If (CStr(Category.Fields.Item("SecurityLevelID").Value) = CStr((members.Fields.Item("SecurityLevelID").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("SecurityLevelID").Value)%>&nbsp;|&nbsp;<%=(Category.Fields.Item("SecurityLevelName").Value)%></option>
            <%
  Category.MoveNext()
Wend
If (Category.CursorType > 0) Then
  Category.MoveFirst
Else
  Category.Requery
End If
%>
          </select>
      </td>
      <td width="0" height="13"><div align="center"><%=(members.Fields.Item("LoginCount").Value)%></div></td>
      <td width="0" height="13"><div align="center"><%=(members.Fields.Item("LastDateAccessed").Value)%></div></td>
      <td width="0" height="13" align="center">
        <input <%If (CStr((members.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> type="checkbox" name="<%= (iCount & ".Activated") %>" value="True">
      </td>
      <td width="0" height="13">
        <div align="center">
          <label> </label>
        </div>
        <div align="center">
          <input name="<%= (iCount & ".Check") %>" type="checkbox" value="Remove">
        </div>
      </td>
      <td width="0" height="13"><div align="center">
        <input name="Submit2" type="submit" id="Submit2" value="Update">
</div>
      </td>
    </tr>
    <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  members.MoveNext()
  iCount = iCount + 1
Wend
%>
  </table>
  <p>
    <input name="Submit" type="submit" id="Submit" value="Update">
    <input type="hidden" name="Count" value="<%= iCount - 1 %>">
  </p>
</form>
<% End If ' end Not members.EOF Or NOT members.BOF %>
<% If members.EOF And members.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">No Records Found.....Please Try Again</div>
    </td>
  </tr>
</table>
<% End If ' end members.EOF And members.BOF %>

</body>
</html>
<%
members.Close()
%>
  <%
Category.Close()
%>

