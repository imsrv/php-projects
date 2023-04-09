<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/registrationmanager.asp" -->
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
  MM_rsKeyConnection=MM_registrationmanager_STRING
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

  MM_editConnection = MM_registrationmanager_STRING
  MM_editTable = "tblMM_Members"
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "FirstName|value|LastName|value|EmailAddress|value|UserName|value|Password|value|CategoryID|value|Activated|value"
  MM_columnsStr = "FirstName|',none,''|LastName|',none,''|EmailAddress|',none,''|UserName|',none,''|Password1|',none,''|CategoryID|none,none,NULL|Activated|',none,''"

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
Dim List_Members__MMColParam1
List_Members__MMColParam1 = "%"
If (Request.Form("search")   <> "") Then 
  List_Members__MMColParam1 = Request.Form("search")  
End If
%>
<%
Dim List_Members__MMColParam2
List_Members__MMColParam2 = "%"
If (Request.Form("searchcat")     <> "") Then 
  List_Members__MMColParam2 = Request.Form("searchcat")    
End If
%>
<%
set List_Members = Server.CreateObject("ADODB.Recordset")
List_Members.ActiveConnection = MM_registrationmanager_STRING
List_Members.Source = "SELECT tblMM_Members.*, tblMM_MembersCategory.CategoryValue  FROM tblMM_MembersCategory RIGHT JOIN tblMM_Members ON tblMM_MembersCategory.CategoryID = tblMM_Members.CategoryID  WHERE tblMM_MembersCategory.CategoryValue Like '" + Replace(List_Members__MMColParam2, "'", "''") + "' AND (tblMM_Members.FirstName Like '%" + Replace(List_Members__MMColParam1, "'", "''") + "%' OR tblMM_Members.LastName Like '%" + Replace(List_Members__MMColParam1, "'", "''") + "%')  ORDER BY tblMM_Members.LastName"
List_Members.CursorType = 0
List_Members.CursorLocation = 2
List_Members.LockType = 3
List_Members.Open()
List_Members_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_registrationmanager_STRING
Category.Source = "SELECT tblMM_MembersCategory.*  FROM tblMM_MembersCategory"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = 25
Repeat1__index = 0
List_Members_numRows = List_Members_numRows + Repeat1__numRows
%>
<% If Not List_Members.EOF Or Not List_Members.BOF Then %>
<%
'  *** Recordset Stats, Move To Record, and Go To Record: declare stats variables

Dim List_Members_total
Dim List_Members_first
Dim List_Members_last

' set the record count
List_Members_total = List_Members.RecordCount

' set the number of rows displayed on this page
If (List_Members_numRows < 0) Then
  List_Members_numRows = List_Members_total
Elseif (List_Members_numRows = 0) Then
  List_Members_numRows = 1
End If

' set the first and last displayed record
List_Members_first = 1
List_Members_last  = List_Members_first + List_Members_numRows - 1

' if we have the correct record count, check the other stats
If (List_Members_total <> -1) Then
  If (List_Members_first > List_Members_total) Then
    List_Members_first = List_Members_total
  End If
  If (List_Members_last > List_Members_total) Then
    List_Members_last = List_Members_total
  End If
  If (List_Members_numRows > List_Members_total) Then
    List_Members_numRows = List_Members_total
  End If
End If
%>
<%
' *** Recordset Stats: if we don't know the record count, manually count them

If (List_Members_total = -1) Then

  ' count the total records by iterating through the recordset
  List_Members_total=0
  While (Not List_Members.EOF)
    List_Members_total = List_Members_total + 1
    List_Members.MoveNext
  Wend

  ' reset the cursor to the beginning
  If (List_Members.CursorType > 0) Then
    List_Members.MoveFirst
  Else
    List_Members.Requery
  End If

  ' set the number of rows displayed on this page
  If (List_Members_numRows < 0 Or List_Members_numRows > List_Members_total) Then
    List_Members_numRows = List_Members_total
  End If

  ' set the first and last displayed record
  List_Members_first = 1
  List_Members_last = List_Members_first + List_Members_numRows - 1
  
  If (List_Members_first > List_Members_total) Then
    List_Members_first = List_Members_total
  End If
  If (List_Members_last > List_Members_total) Then
    List_Members_last = List_Members_total
  End If

End If
%>
<%
Dim MM_paramName 
%>
<%
' *** Move To Record and Go To Record: declare variables

Dim MM_rs
Dim MM_rsCount
Dim MM_size
Dim MM_uniqueCol
Dim MM_offset
Dim MM_atTotal
Dim MM_paramIsDefined

Dim MM_param
Dim MM_index

Set MM_rs    = List_Members
MM_rsCount   = List_Members_total
MM_size      = List_Members_numRows
MM_uniqueCol = ""
MM_paramName = ""
MM_offset = 0
MM_atTotal = false
MM_paramIsDefined = false
If (MM_paramName <> "") Then
  MM_paramIsDefined = (Request.QueryString(MM_paramName) <> "")
End If
%>
<%
' *** Move To Record: handle 'index' or 'offset' parameter

if (Not MM_paramIsDefined And MM_rsCount <> 0) then

  ' use index parameter if defined, otherwise use offset parameter
  MM_param = Request.QueryString("index")
  If (MM_param = "") Then
    MM_param = Request.QueryString("offset")
  End If
  If (MM_param <> "") Then
    MM_offset = Int(MM_param)
  End If

  ' if we have a record count, check if we are past the end of the recordset
  If (MM_rsCount <> -1) Then
    If (MM_offset >= MM_rsCount Or MM_offset = -1) Then  ' past end or move last
      If ((MM_rsCount Mod MM_size) > 0) Then         ' last page not a full repeat region
        MM_offset = MM_rsCount - (MM_rsCount Mod MM_size)
      Else
        MM_offset = MM_rsCount - MM_size
      End If
    End If
  End If

  ' move the cursor to the selected record
  MM_index = 0
  While ((Not MM_rs.EOF) And (MM_index < MM_offset Or MM_offset = -1))
    MM_rs.MoveNext
    MM_index = MM_index + 1
  Wend
  If (MM_rs.EOF) Then 
    MM_offset = MM_index  ' set MM_offset to the last possible record
  End If

End If
%>
<%
' *** Move To Record: if we dont know the record count, check the display range

If (MM_rsCount = -1) Then

  ' walk to the end of the display range for this page
  MM_index = MM_offset
  While (Not MM_rs.EOF And (MM_size < 0 Or MM_index < MM_offset + MM_size))
    MM_rs.MoveNext
    MM_index = MM_index + 1
  Wend

  ' if we walked off the end of the recordset, set MM_rsCount and MM_size
  If (MM_rs.EOF) Then
    MM_rsCount = MM_index
    If (MM_size < 0 Or MM_size > MM_rsCount) Then
      MM_size = MM_rsCount
    End If
  End If

  ' if we walked off the end, set the offset based on page size
  If (MM_rs.EOF And Not MM_paramIsDefined) Then
    If (MM_offset > MM_rsCount - MM_size Or MM_offset = -1) Then
      If ((MM_rsCount Mod MM_size) > 0) Then
        MM_offset = MM_rsCount - (MM_rsCount Mod MM_size)
      Else
        MM_offset = MM_rsCount - MM_size
      End If
    End If
  End If

  ' reset the cursor to the beginning
  If (MM_rs.CursorType > 0) Then
    MM_rs.MoveFirst
  Else
    MM_rs.Requery
  End If

  ' move the cursor to the selected record
  MM_index = 0
  While (Not MM_rs.EOF And MM_index < MM_offset)
    MM_rs.MoveNext
    MM_index = MM_index + 1
  Wend
End If
%>
<%
' *** Move To Record: update recordset stats

' set the first and last displayed record
List_Members_first = MM_offset + 1
List_Members_last  = MM_offset + MM_size

If (MM_rsCount <> -1) Then
  If (List_Members_first > MM_rsCount) Then
    List_Members_first = MM_rsCount
  End If
  If (List_Members_last > MM_rsCount) Then
    List_Members_last = MM_rsCount
  End If
End If

' set the boolean used by hide region to check if we are on the last record
MM_atTotal = (MM_rsCount <> -1 And MM_offset + MM_size >= MM_rsCount)
%>
<%
' *** Go To Record and Move To Record: create strings for maintaining URL and Form parameters

Dim MM_keepNone
Dim MM_keepURL
Dim MM_keepForm
Dim MM_keepBoth

Dim MM_removeList
Dim MM_item
Dim MM_nextItem

' create the list of parameters which should not be maintained
MM_removeList = "&index="
If (MM_paramName <> "") Then
  MM_removeList = MM_removeList & "&" & MM_paramName & "="
End If

MM_keepURL=""
MM_keepForm=""
MM_keepBoth=""
MM_keepNone=""

' add the URL parameters to the MM_keepURL string
For Each MM_item In Request.QueryString
  MM_nextItem = "&" & MM_item & "="
  If (InStr(1,MM_removeList,MM_nextItem,1) = 0) Then
    MM_keepURL = MM_keepURL & MM_nextItem & Server.URLencode(Request.QueryString(MM_item))
  End If
Next

' add the Form variables to the MM_keepForm string
For Each MM_item In Request.Form
  MM_nextItem = "&" & MM_item & "="
  If (InStr(1,MM_removeList,MM_nextItem,1) = 0) Then
    MM_keepForm = MM_keepForm & MM_nextItem & Server.URLencode(Request.Form(MM_item))
  End If
Next

' create the Form + URL string and remove the intial '&' from each of the strings
MM_keepBoth = MM_keepURL & MM_keepForm
If (MM_keepBoth <> "") Then 
  MM_keepBoth = Right(MM_keepBoth, Len(MM_keepBoth) - 1)
End If
If (MM_keepURL <> "")  Then
  MM_keepURL  = Right(MM_keepURL, Len(MM_keepURL) - 1)
End If
If (MM_keepForm <> "") Then
  MM_keepForm = Right(MM_keepForm, Len(MM_keepForm) - 1)
End If

' a utility function used for adding additional parameters to these strings
Function MM_joinChar(firstItem)
  If (firstItem <> "") Then
    MM_joinChar = "&"
  Else
    MM_joinChar = ""
  End If
End Function
%>
<%
' *** Move To Record: set the strings for the first, last, next, and previous links

Dim MM_keepMove
Dim MM_moveParam
Dim MM_moveFirst
Dim MM_moveLast
Dim MM_moveNext
Dim MM_movePrev

Dim MM_urlStr
Dim MM_paramList
Dim MM_paramIndex
Dim MM_nextParam

MM_keepMove = MM_keepBoth
MM_moveParam = "index"

' if the page has a repeated region, remove 'offset' from the maintained parameters
If (MM_size > 1) Then
  MM_moveParam = "offset"
  If (MM_keepMove <> "") Then
    MM_paramList = Split(MM_keepMove, "&")
    MM_keepMove = ""
    For MM_paramIndex = 0 To UBound(MM_paramList)
      MM_nextParam = Left(MM_paramList(MM_paramIndex), InStr(MM_paramList(MM_paramIndex),"=") - 1)
      If (StrComp(MM_nextParam,MM_moveParam,1) <> 0) Then
        MM_keepMove = MM_keepMove & "&" & MM_paramList(MM_paramIndex)
      End If
    Next
    If (MM_keepMove <> "") Then
      MM_keepMove = Right(MM_keepMove, Len(MM_keepMove) - 1)
    End If
  End If
End If

' set the strings for the move to links
If (MM_keepMove <> "") Then 
  MM_keepMove = MM_keepMove & "&"
End If

MM_urlStr = Request.ServerVariables("URL") & "?" & MM_keepMove & MM_moveParam & "="

MM_moveFirst = MM_urlStr & "0"
MM_moveLast  = MM_urlStr & "-1"

MM_moveNext  = MM_urlStr & CStr(MM_offset + MM_size)
If (MM_offset - MM_size < 0) Then
  MM_movePrev = MM_urlStr & "0"
Else
  MM_movePrev = MM_urlStr & CStr(MM_offset - MM_size)
End If
%>
<% End If ' end Not List_Members.EOF Or NOT List_Members.BOF %>
<html>
<head>
<title>Member List Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function YY_checkform() { //v4.66
//copyright (c)1998,2002 Yaromat.com
  var args = YY_checkform.arguments; var myDot=true; var myV=''; var myErr='';var addErr=false;var myReq;
  for (var i=1; i<args.length;i=i+4){
    if (args[i+1].charAt(0)=='#'){myReq=true; args[i+1]=args[i+1].substring(1);}else{myReq=false}
    var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig,""));
    myV=myObj.value;
    if (myObj.type=='text'||myObj.type=='password'||myObj.type=='hidden'){
      if (myReq&&myObj.value.length==0){addErr=true}
      if ((myV.length>0)&&(args[i+2]==1)){ //fromto
        var myMa=args[i+1].split('_');if(isNaN(myV)||myV<myMa[0]/1||myV > myMa[1]/1){addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==2)){
          var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$");if(!rx.test(myV))addErr=true;
      } else if ((myV.length>0)&&(args[i+2]==3)){ // date
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);
        if(myAt){
          var myD=(myAt[myMa[1]])?myAt[myMa[1]]:1; var myM=myAt[myMa[2]]-1; var myY=myAt[myMa[3]];
          var myDate=new Date(myY,myM,myD);
          if(myDate.getFullYear()!=myY||myDate.getDate()!=myD||myDate.getMonth()!=myM){addErr=true};
        }else{addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==4)){ // time
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);if(!myAt){addErr=true}
      } else if (myV.length>0&&args[i+2]==5){ // check this 2
            var myObj1 = MM_findObj(args[i+1].replace(/\[\d+\]/ig,""));
            if(myObj1.length)myObj1=myObj1[args[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!myObj1.checked){addErr=true}
      } else if (myV.length>0&&args[i+2]==6){ // the same
            var myObj1 = MM_findObj(args[i+1]);
            if(myV!=myObj1.value){addErr=true}
      }
    } else
    if (!myObj.type&&myObj.length>0&&myObj[0].type=='radio'){
          var myTest = args[i].match(/(.*)\[(\d+)\].*/i);
          var myObj1=(myObj.length>1)?myObj[myTest[2]]:myObj;
      if (args[i+2]==1&&myObj1&&myObj1.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
      if (args[i+2]==2){
        var myDot=false;
        for(var j=0;j<myObj.length;j++){myDot=myDot||myObj[j].checked}
        if(!myDot){myErr+='* ' +args[i+3]+'\n'}
      }
    } else if (myObj.type=='checkbox'){
      if(args[i+2]==1&&myObj.checked==false){addErr=true}
      if(args[i+2]==2&&myObj.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
    } else if (myObj.type=='select-one'||myObj.type=='select-multiple'){
      if(args[i+2]==1&&myObj.selectedIndex/1==0){addErr=true}
    }else if (myObj.type=='textarea'){
      if(myV.length<args[i+1]){addErr=true}
    }
    if (addErr){myErr+='* '+args[i+3]+'\n'; addErr=false}
  }
  if (myErr!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+myErr)}
  document.MM_returnValue = (myErr=='');
}
//-->
</script>
</head>
<body>
<!--#include file="header.asp" -->
      <form name="form1" method="post" action="">
	  <table width="100%" height="23" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr> 
    <td height="21" width="50%"> 

        <div align="center">Search by <%=(Category.Fields.Item("CategoryLabel").Value)%>
          <select name="searchcat" id="searchcat">
          <option value="%" <%If (Not isNull(Request.Form("searchcat"))) Then If ("%" = CStr(Request.Form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show
          All</option>
          <%
While (NOT Category.EOF)
%>
          <option value="<%=(Category.Fields.Item("CategoryValue").Value)%>" <%If (Not isNull(Request.Form("searchcat"))) Then If (CStr(Category.Fields.Item("CategoryValue").Value) = CStr(Request.Form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryValue").Value)%></option>
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
    </td>
    <td height="21" width="50%"> 
        <div align="center">Search by Name
          <input name="search" type="text" id="search">
          <input type="submit" value="Go" name="submit">
        </div>

    </td>
  </tr>
</table>
 </form>
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="InsertForm" id="InsertForm" onSubmit="YY_checkform('InsertForm','FirstName','#q','0','Please provide valid \'First Name\'','LastName','#q','0','Please provide valid \'Last Name\'','EmailAddress','S','2','Please provide valid \'Email Address\'','UserName','#q','0','Please provide valid \'User Name\'','Password','#q','0','Please provide valid \'Password\'','CategoryID','#q','1','Please provide valid \'Category\'');return document.MM_returnValue">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr>
    <td width="0" height="16" class="tableheader">First Name</td>
    <td width="0" class="tableheader">Last Name</td>
    <td width="0" class="tableheader">Email Address</td>
    <td width="0" class="tableheader">Username</td>
    <td width="0" class="tableheader">Password</td>
    <td width="0" class="tableheader"><%=(Category.Fields.Item("CategoryLabel").Value)%> <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=600,height=400')">[edit]</a> </td>
    <td width="0" class="tableheader">    </td>
  </tr>
    <tr>
    <td width="0" height="22">
      <input name="FirstName" type="text" size="10">
    </td>
    <td width="0" height="22"><input name="LastName" type="text" id="LastName" size="15"></td>
    <td width="0" height="22"><input name="EmailAddress" type="text" id="EmailAddress" size="20">
    </td>
    <td width="0" height="22"><input name="UserName" type="text" id="UserName" size="20">
    </td>
    <td width="0" height="22"><input name="Password" type="text" id="Password" size="20">
    </td>
    <td width="0" height="22"><select name="CategoryID" id="CategoryID">
      <option value="">...Select Category</option>
      <%
While (NOT Category.EOF)
%>
      <option value="<%=(Category.Fields.Item("CategoryID").Value)%>"><%=(Category.Fields.Item("CategoryValue").Value)%></option>
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
</td><td width="0" height="22"><div align="center"><input name="Insert" type="submit" id="Insert" value="Insert New">
        <input name="Activated" type="hidden" id="Activated" value="True">
    </div>
    </td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="InsertForm">
</form>
<% If Request.QueryString("requsername") <> "" Then %>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF0000">
          <tr>
            <td>
			 <p><font size="2">The Username: <strong><%=Request.QueryString("requsername")%></strong> is
			   already in our database.....<a href="javascript:history.go(-1);">Please
		   try again                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       </a>. </font></p>
			
		    </td>
          </tr>
</table> <%End If%>

<form action="update_list.asp" method="post">
  <table width="100%" height="32" border="0" cellpadding="0" cellspacing="0" class="tableborder">
    <tr class="tableheader">
      <td width="0">&nbsp; </td>
      <td width="0">First Name</td>
      <td width="0">Last Name</td>
      <td width="0">Member ID</td>
      <td width="0">Email Address</td>
      <td width="0"> Category</td>
      <td width="0">Member Status</td>
      <td width="0"><div align="center">Activated</div>
      </td>
      <td width="0"><div align="center"></div>
          <div align="center">Delete</div>
      </td>
      <td width="0">
      </td>
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
      <td width="0" height="13"> <strong>
        <%Response.Write(iCount + 1 + MM_offset)%>
    . </strong>
          <div align="center"></div>
      </td>
      <td width="0" height="13">
        <input name="<%= (iCount & ".FirstName") %>" type="text" value="<%=(List_Members.Fields.Item("FirstName").Value)%>" size="15">
      </td>
      <td width="0" height="13"><input name="<%= (iCount & ".LastName") %>" type="text" value="<%=(List_Members.Fields.Item("LastName").Value)%>" size="20"></td>
      <td width="0" height="13"><%=(List_Members.Fields.Item("MemberID").Value)%> </td>
      <td width="0" height="13"><input name="<%= (iCount & ".EmailAddress") %>" type="text" value="<%=(List_Members.Fields.Item("EmailAddress").Value)%>" size="25">
      </td>
      <td width="0" height="13"><input name="<%= (iCount & ".MemberID") %>" type="hidden" value="<%=(List_Members.Fields.Item("MemberID").Value)%>">
          <select name="<%= (iCount & ".CategoryID") %>" id="<%= (iCount & ".CategoryID") %>">
            <%
While (NOT Category.EOF)
%>
            <option value="<%=(Category.Fields.Item("CategoryID").Value)%>" <%If (Not isNull((List_Members.Fields.Item("CategoryID").Value))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr((List_Members.Fields.Item("CategoryID").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryValue").Value)%></option>
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
    | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=600,height=400')">[edit]</a></td>
      <td width="0" height="13"><div align="center">
	  <select name="<%= (iCount & ".MemberStatus") %>" id="<%= (iCount & ".MemberStatus") %>">
        <option value="True" <%If (Not isNull((List_Members.Fields.Item("MemberStatus").Value))) Then If ("True" = CStr((List_Members.Fields.Item("MemberStatus").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Yes</option>
        <option value="False" <%If (Not isNull((List_Members.Fields.Item("MemberStatus").Value))) Then If ("False" = CStr((List_Members.Fields.Item("MemberStatus").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>No</option>
        </select>
      </div></td>
      <td width="0" height="13" align="center">
        <input <%If (CStr((List_Members.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> type="checkbox" name="<%= (iCount & ".Activated") %>" value="True">
      </td>
      <td width="0" height="13">
        <div align="center">
          <label> </label>
        </div>
        <div align="center">
          <input name="<%= (iCount & ".Check") %>" type="checkbox" value="Remove">
        </div>
      </td>
      <td width="0" height="13"><div align="center"><a href="update.asp?MemberID=<%=(List_Members.Fields.Item("MemberID").Value)%>"> Edit
            Member Details</a></div>
      </td>
    </tr>
<% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  List_Members.MoveNext()
  iCount = iCount + 1
Wend
%>
  </table>
  
  <% If Not List_Members.EOF Or Not List_Members.BOF Then %>
  <p align="center">
    <input name="Submit" type="submit" id="Submit" value="Update">
    <input type="hidden" name="Count" value="<%= iCount - 1 %>">
  </p>
  <p align="center">&nbsp; </p>
  <table border="0" width="40%" align="center">
    <tr>
      <td width="23%" align="center">
        <% If MM_offset <> 0 Then %>
        <a href="<%=MM_moveFirst%>">First</a>
        <% End If ' end MM_offset <> 0 %>
      </td>
      <td width="31%" align="center">
        <% If MM_offset <> 0 Then %>
        <a href="<%=MM_movePrev%>">Previous</a>
        <% End If ' end MM_offset <> 0 %>
      </td>
      <td width="23%" align="center">
        <% If Not MM_atTotal Then %>
        <a href="<%=MM_moveNext%>">Next</a>
        <% End If ' end Not MM_atTotal %>
      </td>
      <td width="23%" align="center">
        <% If Not MM_atTotal Then %>
        <a href="<%=MM_moveLast%>">Last</a>
        <% End If ' end Not MM_atTotal %>
      </td>
    </tr>
    <tr>
      <td colspan="4" align="center">&nbsp; Records <strong><%=(List_Members_first)%></strong> to <strong><%=(List_Members_last)%></strong> of <strong><%=(List_Members_total)%></strong> </td>
    </tr>
  </table>
  <% End If ' end Not List_Members.EOF Or NOT List_Members.BOF %>
</form>


<% If List_Members.EOF And List_Members.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">No Records Found.....Please Try Again</div>
    </td>
  </tr>
</table>
<% End If ' end List_Members.EOF And List_Members.BOF %>
</body>
</html>
<%
List_Members.Close()
%>
  <%
Category.Close()
%>

