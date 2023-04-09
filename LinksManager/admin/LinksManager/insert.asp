<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/linksmanager.asp" -->
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
If (CStr(Request("MM_insert")) <> "") Then
  MM_editConnection = MM_linksmanager_STRING
  MM_editTable = "Links"
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "LinkName|value|LinkUrl|value|CategoryID|value|LinkDesc|value|Activated|value"
  MM_columnsStr = "ItemName|',none,''|ItemUrl|',none,''|CategoryID|none,none,NULL|ItemDesc|',none,''|Activated|',none,''"
  ' create the MM_fields and MM_columns arrays
  MM_fields = Split(MM_fieldsStr, "|")
  MM_columns = Split(MM_columnsStr, "|")
  ' set the form values
  For i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_fields(i+1) = CStr(Request.Form(MM_fields(i)))
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
set list = Server.CreateObject("ADODB.Recordset")
list.ActiveConnection = MM_linksmanager_STRING
list.Source = "SELECT *  FROM Links"
list.CursorType = 0
list.CursorLocation = 2
list.LockType = 3
list.Open()
list_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_linksmanager_STRING
Category.Source = "SELECT *  FROM LinksCategory ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<html>
<head>
<title>Insert</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
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
      } else if (test!='R') {
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (val<min || max<val) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>
<!--#include file="header.asp" -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"> 
      <form method="POST" action="<%=MM_editAction%>" name="form1" onSubmit="MM_validateForm('DateAdded','','R','LinkUrl','','R','LinkName','','R','LinkDesc','','R');return document.MM_returnValue">
        <table width="100%" align="center" class="tableborder">
          <tr class="tableheader"> 
            <td colspan="2" align="right" valign="top" nowrap class="tableheader"><a href="javascript:;"> 
               </a>Insert New Link</td>
          </tr>
          <tr> 
            <td width="11%" height="21" align="right" nowrap class="tableheader">Link 
              Name:</td>
            <td width="89%" valign="baseline"> 
              <input name="LinkName" type="text" size="60"> <img src="questionmark.gif" alt="Enter a short name to identify the link i.e &quot;City Hall&quot;" width="15" height="15">            
			  </td>
          </tr>
          <tr>
            <td align="right" valign="top" nowrap class="tableheader">Link Url:</td>
            <td valign="baseline">             
			<input name="LinkUrl" type="text" value="http://" size="60">
            <img src="questionmark.gif" alt="Enter the actual URL link i.e. http://www.cityhall.com" width="15" height="15"></td>
          </tr>
          <tr> 
            <td height="2" align="right" valign="baseline" nowrap class="tableheader">Category:</td>
            <td height="2" valign="baseline"> 
              <select name="CategoryID">
                <%
While (NOT Category.EOF)
%>
                <option value="<%=(Category.Fields.Item("CategoryID").Value)%>"><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
              <img src="questionmark.gif" alt="(select a category that best desribes the link i.e. &quot;Government Offices&quot; )" width="15" height="15">
              | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=400,height=300')">add/edit
      category</a></td>
          </tr>
          <tr> 
            <td align="right" valign="top" nowrap class="tableheader">Link Description:</td>
            <td valign="top"> 
              <textarea name="LinkDesc" cols="60" rows="3"></textarea>
              <img src="questionmark.gif" alt="Enter a description of this link i.e. &quot;This is a link to the official website of City Hall" width="15" height="15">
            </td>
          </tr>
          <tr> 
            <td height="18" align="right" valign="top" nowrap class="tableheader">Activated:</td>
            <td valign="baseline" height="18"><input type="checkbox" name="Activated" value="True" size="32" checked>
              <img src="questionmark.gif" alt="(Check if you want this link to be visible to the public)(Ucheck if you wish to hide)" width="15" height="15"></td>
          </tr>
          <tr> 
            <td height="2" align="right" valign="baseline" nowrap class="tableheader">&nbsp;</td>
            <td height="2" valign="baseline"> 
              <input type="submit" value="Publish to Links Listing Page">
            </td>
         </tr>
        </table>     
<input type="hidden" name="MM_insert" value="form1">
      </form>
    </td>
  </tr>
</table>
</body>
</html>
<%
list.Close()
%>
<%
Category.Close()
%>



