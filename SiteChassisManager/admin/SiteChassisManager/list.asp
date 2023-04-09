<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/sitechassismanager.asp" -->
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

If (CStr(Request("MM_insert")) = "mid") Then

  MM_editConnection = MM_sitechassismanager_STRING
  MM_editTable = "tblSitePlanNavMenu"
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "Menu5|value|Activated|value"
  MM_columnsStr = "Menu|',none,''|Activated|',none,''"

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
' *** Insert Record: set variables

If (CStr(Request("MM_insert")) = "mid2") Then

  MM_editConnection = MM_sitechassismanager_STRING
  MM_editTable = "tblSitePlanNavMenu2"
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "mid|value|Menu2|value|Activated2|value"
  MM_columnsStr = "midkey|none,none,NULL|Menu2|',none,''|Activated2|',none,''"

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
' *** Insert Record: set variables

If (CStr(Request("MM_insert")) = "mid3") Then

  MM_editConnection = MM_sitechassismanager_STRING
  MM_editTable = "tblSitePlanNavMenu3"
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "mid2|value|Menu3|value|Activated3|value"
  MM_columnsStr = "mid2key|none,none,NULL|Menu3|',none,''|Activated3|',none,''"

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
' *** Update Record: set variables

If (CStr(Request("MM_update")) = "menuItem3" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_sitechassismanager_STRING
  MM_editTable = "tblSitePlanNavMenu3"
  MM_editColumn = "mid3"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "ItemMenu3|value|SortOrder3|value"
  MM_columnsStr = "Menu3|',none,''|SortOrder3|none,none,NULL"

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
' *** Update Record: set variables

If (CStr(Request("MM_update")) = "menuItem2" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_sitechassismanager_STRING
  MM_editTable = "tblSitePlanNavMenu2"
  MM_editColumn = "mid2"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "ItemMenu2|value|SortOrder2|value|Activated2|value"
  MM_columnsStr = "Menu2|',none,''|SortOrder2|none,none,NULL,''|Activated2|',none,''"

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
' *** Update Record: set variables

If (CStr(Request("MM_update")) = "menuItem" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_sitechassismanager_STRING
  MM_editTable = "tblSitePlanNavMenu"
  MM_editColumn = "mid"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "ItemMenu|value|SortOrder|value|Activated|value"
  MM_columnsStr = "Menu|',none,''|SortOrder|none,none,NULL,''|Activated|',none,''"

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
' *** Update Record: construct a sql update statement and execute it

If (CStr(Request("MM_update")) <> "" And CStr(Request("MM_recordId")) <> "") Then

  ' create the sql update statement
  MM_editQuery = "update " & MM_editTable & " set "
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
      MM_editQuery = MM_editQuery & ","
    End If
    MM_editQuery = MM_editQuery & MM_columns(MM_i) & " = " & MM_formVal
  Next
  MM_editQuery = MM_editQuery & " where " & MM_editColumn & " = " & MM_recordId

  If (Not MM_abortEdit) Then
    ' execute the update
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
set navigation = Server.CreateObject("ADODB.Recordset")
navigation.ActiveConnection = MM_sitechassismanager_STRING
navigation.Source = "SELECT tblSitePlanNavMenu.*, tblSitePlanNavMenu2.*, tblSitePlanNavMenu3.*  FROM (tblSitePlanNavMenu LEFT JOIN tblSitePlanNavMenu2 ON tblSitePlanNavMenu.mid = tblSitePlanNavMenu2.midkey) LEFT JOIN tblSitePlanNavMenu3 ON tblSitePlanNavMenu2.mid2 = tblSitePlanNavMenu3.mid2key  ORDER BY SortOrder, SortOrder2, SortOrder3"
navigation.CursorType = 0
navigation.CursorLocation = 2
navigation.LockType = 3
navigation.Open()
navigation_numRows = 0
%>
<%
set menulist = Server.CreateObject("ADODB.Recordset")
menulist.ActiveConnection = MM_sitechassismanager_STRING
menulist.Source = "SELECT *  FROM tblSitePlanNavMenu"
menulist.CursorType = 0
menulist.CursorLocation = 2
menulist.LockType = 3
menulist.Open()
menulist_numRows = 0
%>
<%
Dim menulist2__value1
menulist2__value1 = "%"
If (request.querystring("mid")  <> "") Then 
  menulist2__value1 = request.querystring("mid") 
End If
%>
<%
set menulist2 = Server.CreateObject("ADODB.Recordset")
menulist2.ActiveConnection = MM_sitechassismanager_STRING
menulist2.Source = "SELECT *  FROM tblSitePlanNavMenu2  WHERE midkey LIKE '" + Replace(menulist2__value1, "'", "''") + "'"
menulist2.CursorType = 0
menulist2.CursorLocation = 2
menulist2.LockType = 3
menulist2.Open()
menulist2_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = -1
Repeat1__index = 0
navigation_numRows = navigation_numRows + Repeat1__numRows
%>

<%
' UltraDeviant - Row Number written by Owen Palmer (http://ultradeviant.co.uk)
Dim OP_RowNum
If MM_offset <> "" Then
	OP_RowNum = MM_offset + 1
Else
	OP_RowNum = 1
End If
%>
<html>
<head>
<title>Site Chasis Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
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
<!--#include file="header.asp" -->
<table width="100%" height="122" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableborder">
      <tr>
        <td>To create a 1st
            Level Menu Item, Type in the  Name of the Menu and press the create
          button.</td>
      </tr>
      <tr>
        <td><form action="<%=MM_editAction%>" method="POST" name="mid" id="mid" onSubmit="YY_checkform('mid','Menu5','#q','0','Please Enter a Name');return document.MM_returnValue">Create 1st Level Menu Item: 
          <input name="Menu5" type="text" id="Menu" size="32">
          <input type="submit" value="Create" name="submit">
          <input type="hidden" name="MM_insert" value="mid">
          <input name="Activated" type="hidden" id="Activated" value="True">
        </form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableborder">
      <tr>
        <td>To create a 2nd Level 
            Menu Item: Select the 1st Level Menu, enter the name of
          the 2nd Level Menu you wish to create and press the create button.		  </td>
      </tr>
      <tr>
        <td>
		<form action="<%=MM_editAction%>" method="POST" name="mid2" id="mid2" onSubmit="YY_checkform('mid2','SubMenu2','#q','0','Please enter a name');return document.MM_returnValue">Create 2nd Level Menu Item: 
          <select name="mid" id="select">
          <%
While (NOT menulist.EOF)
%>
          <option value="<%=(menulist.Fields.Item("mid").Value)%>" <%If (Not isNull(request.querystring("mid"))) Then If (CStr(menulist.Fields.Item("mid").Value) = CStr(request.querystring("mid"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(menulist.Fields.Item("Menu").Value)%></option>
          <%
  menulist.MoveNext()
Wend
If (menulist.CursorType > 0) Then
  menulist.MoveFirst
Else
  menulist.Requery
End If
%>
          </select>
          <input name="Menu2" type="text" id="SubMenu2" size="32">
          <input type="submit" value="Create" name="submit2">
          <input type="hidden" name="MM_insert" value="mid2">
          <input name="Activated2" type="hidden" id="Activated2" value="True">
        </form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
    <% If Not menulist2.EOF Or Not menulist2.BOF Then %>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableborder">
        <tr>
          <td>To create a 3rd Level Menu Item: Select the 1st Level Menu, Select
            the 2nd Level Menu, enter the name of the 3nd Level Menu you wish
            to create and press the
            create
          button. </td>
        </tr>
        <tr>
          <td><form action="<%=MM_editAction%>" method="POST" name="mid3" id="mid3" onSubmit="YY_checkform('mid3','Menu3','#q','0','Please enter a name');return document.MM_returnValue">
  Create 3rd Level Menu Item :
      <select name="menu" onChange="MM_jumpMenu('parent',this,0)">
        <%
While (NOT menulist.EOF)
%>
        <option value="?mid=<%=(menulist.Fields.Item("mid").Value)%>" <%If (Not isNull(request.querystring("mid"))) Then If (CStr(menulist.Fields.Item("mid").Value) = CStr(request.querystring("mid"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(menulist.Fields.Item("Menu").Value)%></option>
        <%
  menulist.MoveNext()
Wend
If (menulist.CursorType > 0) Then
  menulist.MoveFirst
Else
  menulist.Requery
End If
%>
      </select>
  <select name="mid2" id="mid2">
    <%
While (NOT menulist2.EOF)
%>
    <option value="<%=(menulist2.Fields.Item("mid2").Value)%>" <%If (Not isNull(request.querystring("mid2"))) Then If (CStr(menulist2.Fields.Item("mid2").Value) = CStr(request.querystring("mid2"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(menulist2.Fields.Item("Menu2").Value)%></option>
    <%
  menulist2.MoveNext()
Wend
If (menulist2.CursorType > 0) Then
  menulist2.MoveFirst
Else
  menulist2.Requery
End If
%>
            </select>          
  <input name="Menu3" type="text" id="Menu3" size="32">
            <input name="submit3" type="submit" id="submit3" value="Create">
            <input type="hidden" name="MM_insert" value="mid3">
            <input name="Activated3" type="hidden" id="Activated3" value="True">
          </form>          </td>
        </tr>
    </table>
    <% End If ' end Not menulist2.EOF Or NOT menulist2.BOF %>
</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableborder">
  <tr valign>
    <td valign="top">
      <% 
While ((Repeat1__numRows <> 0) AND (NOT navigation.EOF)) 
%>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr valign>
          <td valign="top">
            <% TFM_nest = navigation.Fields.Item("Menu").Value
If lastTFM_nest <> TFM_nest Then 
	lastTFM_nest = TFM_nest %>
            <table width="100%" border="0" cellpadding="2" cellspacing="0">
              <tr bgcolor="#CCCCCC">
                <td width="31%" height="40">                  <form ACTION="<%=MM_editAction%>" METHOD="POST" name="menuItem" id="menuItem">
                    <input type="submit" name="Submit" value="update">
                    <input name="ItemMenu" type="text" id="Menu" value="<%=(navigation.Fields.Item("Menu").Value)%>">
                    Order: <input name="SortOrder" type="text" id="SortOrder" value="<%=(navigation.Fields.Item("SortOrder").Value)%>" size="3">
                    <input type="hidden" name="MM_update" value="menuItem">
                    <input type="hidden" name="MM_recordId" value="<%= navigation.Fields.Item("mid").Value %>">
                    <input <%If (CStr((navigation.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> name="Activated" type="checkbox" id="Activated" value="True">
                </form></td>
                <td width="69%"><a href="html_editor_menu.asp?mid=<%=(navigation.Fields.Item("mid").Value)%>">WYSIWYG
                    Page Editor</a> | <a href="update_menu.asp?mid=<%=(navigation.Fields.Item("mid").Value)%>">Edit
                    Menu Item Details</a> | <a href="delete_menu.asp?mid=<%=(navigation.Fields.Item("mid").Value)%>">Delete
                    Menu Item</a> | 
					
					<a href="../../content.asp?mid=<%=(navigation.Fields.Item("mid").Value)%><% if navigation.Fields.Item("IncludeFileID").Value <> "" then %>&incid=<%=(navigation.Fields.Item("IncludeFileID").Value)%><% end if %><% if navigation.Fields.Item("Variables").Value <> "" then %>&<%=(navigation.Fields.Item("Variables").Value)%><% end if %>" target="_blank">Preview</a>			   
                    <% if navigation.Fields.Item("ImageFileA").Value <> "" then %>
                    <img src="../../applications/SiteChassisManager/images/<%=(navigation.Fields.Item("ImageFileA").Value)%>" width="50">
                    <% end if %>
                    <% if navigation.Fields.Item("ImageFileB").Value <> "" then %>
                    <img src="../../applications/SiteChassisManager/images/<%=(navigation.Fields.Item("ImageFileB").Value)%>" width="50">
                  <% end if %>
</td>
              </tr>
            </table>
<%End If 'End Basic-UltraDev Simulated Nested Repeat %>
            <% TFM_nest2 = navigation.Fields.Item("Menu2").Value
If lastTFM_nest2 <> TFM_nest2 Then 
	lastTFM_nest2 = TFM_nest2 %>
            <table width="100%" height="0" border="0" cellpadding="0" cellspacing="0" class="row1">
              <tr>
                <% if navigation.Fields.Item("Menu2").Value <> "" then %>
                <td width="31%" height="40">
                  <div align="left"><form action="<%=MM_editAction2%>" method="POST" name="menuItem2" id="menuItem2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" name="Submit2" value="update">
                    <input name="ItemMenu2" type="text" id="ItemMenu2" value="<%=(navigation.Fields.Item("Menu2").Value)%>">
Order: 
<input name="SortOrder2" type="text" id="SortOrder2" value="<%=(navigation.Fields.Item("SortOrder2").Value)%>" size="3">
<input type="hidden" name="MM_update" value="menuItem2">
<input name="MM_recordId" type="hidden" id="MM_recordId" value="<%= navigation.Fields.Item("mid2").Value %>">
<input <%If (CStr((navigation.Fields.Item("Activated2").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> name="Activated2" type="checkbox" id="Activated2" value="True">
                  </form>
                  </div>
                </td>
                <td width="69%"><a href="html_editor_menu2.asp?mid2=<%=(navigation.Fields.Item("mid2").Value)%>">                  WYSIWYG Editor</a> | <a href="update_menu2.asp?mid2=<%=(navigation.Fields.Item("mid2").Value)%>">Edit
                    Menu Item Details</a> | <a href="delete_menu2.asp?mid2=<%=(navigation.Fields.Item("mid2").Value)%>">Delete
                    Menu Item</a> | 						
					<a href="../../content.asp?mid=<%=(navigation.Fields.Item("mid").Value)%>&mid2=<%=(navigation.Fields.Item("mid2").Value)%><% if navigation.Fields.Item("IncludeFileID2").Value <> "" then %>&incid=<%=(navigation.Fields.Item("IncludeFileID2").Value)%><% end if %><% if navigation.Fields.Item("Variables2").Value <> "" then %>&<%=(navigation.Fields.Item("Variables2").Value)%><% end if %>" target="_blank">Preview</a>
                    <% if navigation.Fields.Item("ImageFileA2").Value <> "" then %>
                    <img src="../../applications/SiteChassisManager/images/<%=(navigation.Fields.Item("ImageFileA2").Value)%>" width="50">
                    <% end if %>
                    <% if navigation.Fields.Item("ImageFileB2").Value <> "" then %>
                    <img src="../../applications/SiteChassisManager/images/<%=(navigation.Fields.Item("ImageFileB2").Value)%>" width="50">
                    <% end if %>
                </td>
                <% end if ' image check %>
              </tr>
            </table>
<%End If 'End Basic-UltraDev Simulated Nested Repeat %>
            <table width="100%" height="0" border="0" cellpadding="0" cellspacing="0" class="row2">
              <tr>
                <% if navigation.Fields.Item("Menu3").Value <> "" then %>
                <td width="31%" height="20">
                  <div align="left"><form action="<%=MM_editAction%>" method="POST" name="menuItem3" id="menuItem3">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" name="Submit" value="update">
                    <input name="ItemMenu3" type="text" id="ItemMenu3" value="<%=(navigation.Fields.Item("Menu3").Value)%>">
Order: 
<input name="SortOrder3" type="text" id="SortOrder3" value="<%=(navigation.Fields.Item("SortOrder3").Value)%>" size="3">
<input type="hidden" name="MM_update" value="menuItem3">
<input name="MM_recordId" type="hidden" id="MM_recordId" value="<%= navigation.Fields.Item("mid3").Value %>">
                  </form>
                  </div>
                  <div align="left"></div>
                  <div align="right"> </div>
                </td>
                <td width="69%"><a href="html_editor_menu3.asp?mid3=<%=(navigation.Fields.Item("mid3").Value)%>">                  WYSIWYG Editor</a> | <a href="update_menu3.asp?mid3=<%=(navigation.Fields.Item("mid3").Value)%>">Edit
                    Menu Item Details</a> | <a href="delete_menu3.asp?mid3=<%=(navigation.Fields.Item("mid3").Value)%>">Delete
                    Menu Item</a> | <a href="../../content.asp?mid=<%=(navigation.Fields.Item("mid").Value)%>&mid2=<%=(navigation.Fields.Item("mid2").Value)%>&mid3=<%=(navigation.Fields.Item("mid3").Value)%><% if navigation.Fields.Item("IncludeFileID3").Value <> "" then %>&incid=<%=(navigation.Fields.Item("IncludeFileID3").Value)%><% end if %><% if navigation.Fields.Item("Variables3").Value <> "" then %>&<%=(navigation.Fields.Item("Variables3").Value)%><% end if %>" target="_blank">Preview</a>
                    <% if navigation.Fields.Item("ImageFileA3").Value <> "" then %>
                    <img src="../../applications/SiteChassisManager/images/<%=(navigation.Fields.Item("ImageFileA3").Value)%>" width="50">
                    <% end if %>
                    <% if navigation.Fields.Item("ImageFileB3").Value <> "" then %>
                    <img src="../../applications/SiteChassisManager/images/<%=(navigation.Fields.Item("ImageFileB3").Value)%>" width="50">
					<% end if %>
                </td>
                <% end if ' image check %>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  navigation.MoveNext()
Wend
%>
    </td>
  </tr>
</table>
<h5>&nbsp;</h5>
<h3>&nbsp;</h3>

<p>&nbsp;</p>
</body>
</html>
<%
navigation.Close()
Set navigation = Nothing
%>
<%
menulist.Close()
%>
<%
menulist2.Close()
%>
