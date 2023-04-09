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
' *** Update Record: set variables

If (CStr(Request("MM_update")) = "member_details" And CStr(Request("MM_recordId")) <> "") Then

  MM_editConnection = MM_registrationmanager_STRING
  MM_editTable = "tblMM_Members"
  MM_editColumn = "MemberID"
  MM_recordId = "" + Request.Form("MM_recordId") + ""
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "Activated|value|Salutation|value|FirstName|value|LastName|value|OrgName1|value|OrgName2|value|JobTitle|value|WebsiteURL|value|Address1|value|Phone|value|Address2|value|CellPhone|value|City|value|Fax|value|PostalCode|value|EmailAddress|value|State|value|Country|value|Map|value|Username|value|Password1|value|SecurityLevelID|value|Profile|value|ImageFile|value|CategoryID|value|MemberLookuptxt1|value|MemberLookuptxt2|value|MemberLookuptxt3|value|MemberLookuptxt4|value|MemberLookuptxt5|value"
  MM_columnsStr = "Activated|',none,''|Salutation|',none,''|FirstName|',none,''|LastName|',none,''|OrgName1|',none,''|OrgName2|',none,''|JobTitle|',none,''|WebsiteURL|',none,''|Address1|',none,''|Phone|',none,''|Address2|',none,''|CellPhone|',none,''|City|',none,''|Fax|',none,''|PostalCode|',none,''|EmailAddress|',none,''|State|',none,''|Country|',none,''|Map|',none,''|UserName|',none,''|Password1|',none,''|SecurityLevelID|none,none,NULL|Profile|',none,''|ImageFile|',none,''|CategoryID|none,none,NULL|MemberLookuptxt1|',none,''|MemberLookuptxt2|',none,''|MemberLookuptxt3|',none,''|MemberLookuptxt4|',none,''|MemberLookuptxt5|',none,''"

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
Dim member_details__value1
member_details__value1 = "0"
If (request.querystring("MemberID") <> "") Then 
  member_details__value1 = request.querystring("MemberID")
End If
%>
<%
set member_details = Server.CreateObject("ADODB.Recordset")
member_details.ActiveConnection = MM_registrationmanager_STRING
member_details.Source = "SELECT *  FROM tblMM_Members  WHERE MemberID = " + Replace(member_details__value1, "'", "''") + ""
member_details.CursorType = 0
member_details.CursorLocation = 2
member_details.LockType = 3
member_details.Open()
member_details_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_registrationmanager_STRING
Category.Source = "SELECT *  FROM tblMM_MembersCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim MemberLookuptxt1
Dim MemberLookuptxt1_numRows

Set MemberLookuptxt1 = Server.CreateObject("ADODB.Recordset")
MemberLookuptxt1.ActiveConnection = MM_registrationmanager_STRING
MemberLookuptxt1.Source = "SELECT *  FROM tblMM_MemberLookuptxt1"
MemberLookuptxt1.CursorType = 0
MemberLookuptxt1.CursorLocation = 2
MemberLookuptxt1.LockType = 1
MemberLookuptxt1.Open()

MemberLookuptxt_numRows = 0
%>
<%
Dim MemberLookuptxt2
Dim MemberLookuptxt2_numRows

Set MemberLookuptxt2 = Server.CreateObject("ADODB.Recordset")
MemberLookuptxt2.ActiveConnection = MM_registrationmanager_STRING
MemberLookuptxt2.Source = "SELECT *  FROM tblMM_MemberLookuptxt2"
MemberLookuptxt2.CursorType = 0
MemberLookuptxt2.CursorLocation = 2
MemberLookuptxt2.LockType = 1
MemberLookuptxt2.Open()

MemberLookuptxt2_numRows = 0
%>
<%
Dim MemberLookuptxt3
Dim MemberLookuptxt3_numRows

Set MemberLookuptxt3 = Server.CreateObject("ADODB.Recordset")
MemberLookuptxt3.ActiveConnection = MM_registrationmanager_STRING
MemberLookuptxt3.Source = "SELECT *  FROM tblMM_MemberLookuptxt3"
MemberLookuptxt3.CursorType = 0
MemberLookuptxt3.CursorLocation = 2
MemberLookuptxt3.LockType = 1
MemberLookuptxt3.Open()

MemberLookuptxt3_numRows = 0
%>
<%
Dim MemberLookuptxt4
Dim MemberLookuptxt4_numRows

Set MemberLookuptxt4 = Server.CreateObject("ADODB.Recordset")
MemberLookuptxt4.ActiveConnection = MM_registrationmanager_STRING
MemberLookuptxt4.Source = "SELECT *  FROM tblMM_MemberLookuptxt4"
MemberLookuptxt4.CursorType = 0
MemberLookuptxt4.CursorLocation = 2
MemberLookuptxt4.LockType = 1
MemberLookuptxt4.Open()

MemberLookuptxt4_numRows = 0
%>
<%
Dim MemberLookuptxt5
Dim MemberLookuptxt5_numRows

Set MemberLookuptxt5 = Server.CreateObject("ADODB.Recordset")
MemberLookuptxt5.ActiveConnection = MM_registrationmanager_STRING
MemberLookuptxt5.Source = "SELECT *  FROM tblMM_MemberLookuptxt5"
MemberLookuptxt5.CursorType = 0
MemberLookuptxt5.CursorLocation = 2
MemberLookuptxt5.LockType = 1
MemberLookuptxt5.Open()

MemberLookuptxt5_numRows = 0
%>
<%
Dim Lookup_State
Dim Lookup_State_numRows

Set Lookup_State = Server.CreateObject("ADODB.Recordset")
Lookup_State.ActiveConnection = MM_registrationmanager_STRING
Lookup_State.Source = "SELECT *  FROM tblLookupState"
Lookup_State.CursorType = 0
Lookup_State.CursorLocation = 2
Lookup_State.LockType = 1
Lookup_State.Open()

Lookup_State_numRows = 0
%>
<%
Dim Lookup_Country
Dim Lookup_Country_numRows

Set Lookup_Country = Server.CreateObject("ADODB.Recordset")
Lookup_Country.ActiveConnection = MM_registrationmanager_STRING
Lookup_Country.Source = "SELECT *  FROM tblLookupCountry"
Lookup_Country.CursorType = 0
Lookup_Country.CursorLocation = 2
Lookup_Country.LockType = 1
Lookup_Country.Open()

Lookup_Country_numRows = 0
%>
<%
Dim security_level
Dim security_level_numRows

Set security_level = Server.CreateObject("ADODB.Recordset")
security_level.ActiveConnection = MM_registrationmanager_STRING
security_level.Source = "SELECT *  FROM tblSLM_Security"
security_level.CursorType = 0
security_level.CursorLocation = 2
security_level.LockType = 1
security_level.Open()

security_level_numRows = 0
%>
<html>
<head>
<title>Registration Manager</title>
<meta http-equiv="Content-Type" content="text/hMMl; charset=iso-8859-1">
<link href="../../styles.css" rel="stylesheet" type="text/css">
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
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="member_details" id="member_details"  onSubmit="YY_checkform('member_details','FirstName','#q','0','Field \'FirstName\' is not valid.','LastName','#q','0','Field \'LastName\' is not valid.','EmailAddress','S','2','Field \'EmailAddress\' is not valid.','Username','#q','0','Field \'Username\' is not valid.','Password1','#q','0','Field \'Password1\' is not valid.');return document.MM_returnValue">
  <table width="100%" height="392" align="center" cellpadding="0" cellspacing="0" class="tableborder">
    <tr>
      <td width="49%" height="390" align="right" valign="top">
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="3">Member Details:</td>
            <td><div align="right">Activated: 
                <input <%If (CStr((member_details.Fields.Item("Activated").Value)) = CStr("True")) Then Response.Write("checked") : Response.Write("")%> name="Activated" type="checkbox" id="Activated" value="True">
            </div></td>
          </tr>
          <tr class="row2">
            <td width="14%"><strong><font color="#FF0000">*</font></strong>First Name</td>
            <td width="42%"><select name="Salutation" id="Salutation">
            <option value="" selected <%If (Not isNull((member_details.Fields.Item("Salutation").Value))) Then If ("" = CStr((member_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>blank</option>
            <option value="Mr."  <%If (Not isNull((member_details.Fields.Item("Salutation").Value))) Then If ("Mr." = CStr((member_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Mr.
              <option value="Mrs." <%If (Not isNull((member_details.Fields.Item("Salutation").Value))) Then If ("Mrs." = CStr((member_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Mrs.
              <option value="Miss" <%If (Not isNull((member_details.Fields.Item("Salutation").Value))) Then If ("Miss" = CStr((member_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Miss
              <option value="Dr." <%If (Not isNull((member_details.Fields.Item("Salutation").Value))) Then If ("Dr." = CStr((member_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Dr.
              <option value="Fr." <%If (Not isNull((member_details.Fields.Item("Salutation").Value))) Then If ("Fr." = CStr((member_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Fr.
              <option value="Sr." <%If (Not isNull((member_details.Fields.Item("Salutation").Value))) Then If ("Sr." = CStr((member_details.Fields.Item("Salutation").Value))) Then Response.Write("SELECTED") : Response.Write("")%>>Sr.
            </select>
            <input name="FirstName" type="text" id="FirstName" value="<%=(member_details.Fields.Item("FirstName").Value)%>" size="15">
            </td>
            <td width="13%"><strong><font color="#FF0000">*</font></strong>Last
            Name</td>
            <td width="31%"><input name="LastName" type="text" id="LastName" value="<%=(member_details.Fields.Item("LastName").Value)%>"></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="4">Company Details:</td>
          </tr>
          <tr class="row2">
            <td width="19%">Company Name:</td>
            <td width="28%"><input name="OrgName1" type="text" id="OrgName1" value="<%=(member_details.Fields.Item("OrgName1").Value)%>">
            </td>
            <td width="11%">Division:</td>
            <td width="42%"><input name="OrgName2" type="text" id="OrgName2" value="<%=(member_details.Fields.Item("OrgName2").Value)%>">
            </td>
          </tr>
          <tr class="row2">
            <td>Job Title:</td>
            <td><input name="JobTitle" type="text" id="JobTitle" value="<%=(member_details.Fields.Item("JobTitle").Value)%>">
            </td>
            <td>Web Site:</td>
            <td >http://
                <input name="WebsiteURL" type="text" id="WebsiteURL" value="<%=(member_details.Fields.Item("WebsiteURL").Value)%>">
            </td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="4"> Address Details:</td>
          </tr>
          <tr class="row2">
            <td width="21%">Address 1: </td>
            <td width="32%"><input name="Address1" type="text" id="Address1" value="<%=(member_details.Fields.Item("Address1").Value)%>">
            </td>
            <td width="16%">Phone:</td>
            <td width="31%"><input name="Phone" type="text" id="Phone" value="<%=(member_details.Fields.Item("Phone").Value)%>" >
            </td>
          </tr>
          <tr class="row2">
            <td>Address 2:</td>
            <td><input name="Address2" type="text" id="Address2" value="<%=(member_details.Fields.Item("Address2").Value)%>" >
            </td>
            <td>Cell:</td>
            <td><input name="CellPhone" type="text" id="CellPhone" value="<%=(member_details.Fields.Item("CellPhone").Value)%>" >
            </td>
          </tr>
          <tr class="row2">
            <td>City:</td>
            <td><input name="City" type="text" id="City" value="<%=(member_details.Fields.Item("City").Value)%>">
            </td>
            <td>Fax:</td>
            <td><input name="Fax" type="text" id="Fax" value="<%=(member_details.Fields.Item("Fax").Value)%>" >
            </td>
          </tr>
          <tr class="row2">
            <td>Postal Code:</td>
            <td><input name="PostalCode" type="text" id="PostalCode" value="<%=(member_details.Fields.Item("PostalCode").Value)%>">
            </td>
            <td><strong><font color="#FF0000">*</font></strong>Email</td>
            <td><input name="EmailAddress" type="text" id="EmailAddress" value="<%=(member_details.Fields.Item("EmailAddress").Value)%>" ></td>
          </tr>
          <tr class="row2">
            <td>Province/State:</td>
            <td><select name="State" id="State">
              <%
While (NOT Lookup_State.EOF)
%>
              <option value="<%=(Lookup_State.Fields.Item("StateName").Value)%>" <%If (Not isNull((member_details.Fields.Item("State").Value))) Then If (CStr(Lookup_State.Fields.Item("StateName").Value) = CStr((member_details.Fields.Item("State").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Lookup_State.Fields.Item("StateName").Value)%></option>
              <%
  Lookup_State.MoveNext()
Wend
If (Lookup_State.CursorType > 0) Then
  Lookup_State.MoveFirst
Else
  Lookup_State.Requery
End If
%>
              </select>
            </td>
            <td>Country:</td>
            <td><select name="Country" id="Country">
              <%
While (NOT Lookup_Country.EOF)
%>
              <option value="<%=(Lookup_Country.Fields.Item("CountryName").Value)%>" <%If (Not isNull((member_details.Fields.Item("Country").Value))) Then If (CStr(Lookup_Country.Fields.Item("CountryName").Value) = CStr((member_details.Fields.Item("Country").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Lookup_Country.Fields.Item("CountryName").Value)%></option>
              <%
  Lookup_Country.MoveNext()
Wend
If (Lookup_Country.CursorType > 0) Then
  Lookup_Country.MoveFirst
Else
  Lookup_Country.Requery
End If
%>
              </select>
            </td>
          </tr>
          <tr class="row2">
            <td height="25">Map:</td>
            <td colspan="3"><input name="Map" type="text" id="Map" value="<%=(member_details.Fields.Item("Map").Value)%>" size="30">
      | <a href="http://ca.maps.yahoo.com" target="_blank">Get URL from Yahoo
      Maps</a></td>
          </tr>
        </table>
        <div align="left"><br>
          <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
            <tr class="tableheader">
              <td colspan="4">Security/Login Details:              </td>
            </tr>
            <tr class="row2">
              <td width="18%"><strong><font color="#FF0000">*</font></strong>Username</td>
              <td width="12%">&nbsp;</td>
              <td width="32%"><input name="Username" type="text" id="Username" value="<%=(member_details.Fields.Item("UserName").Value)%>" ></td>
              <td width="38%">&nbsp;</td>
            </tr>
            <tr class="row2">
              <td>Password</td>
              <td>&nbsp;</td>
              <td><input name="Password1" type="text" id="Password1" value="<%=(member_details.Fields.Item("Password1").Value)%>" ></td>
              <td>&nbsp;</td>
            </tr>
            <tr class="row2">
              <td colspan="2"><strong><font color="#FF0000">Security Access Level</font></strong>              </td>
              <td><strong>
                <select name="SecurityLevelID" id="SecurityLevelID">
                  <%
While (NOT security_level.EOF)
%>
                  <option value="<%=(security_level.Fields.Item("SecurityLevelID").Value)%>" <%If (Not isNull((member_details.Fields.Item("SecurityLevelID").Value))) Then If (CStr(security_level.Fields.Item("SecurityLevelID").Value) = CStr((member_details.Fields.Item("SecurityLevelID").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(security_level.Fields.Item("SecurityLevelID").Value)%>&nbsp;|&nbsp<%=(security_level.Fields.Item("SecurityLevelName").Value)%></option>
                  <%
  security_level.MoveNext()
Wend
If (security_level.CursorType > 0) Then
  security_level.MoveFirst
Else
  security_level.Requery
End If
%>
                </select>
              </strong></td>
              <td>&nbsp;              </td>
            </tr>
          </table>
          <p>&nbsp;              </p>
          <p><strong><font color="#FF0000">*</font>Required
    Fields  </strong></p>
        </div></td>
      <td width="2%" rowspan="2" align="right" valign="top" >&nbsp;</td>
      <td width="49%" align="right" valign="top" >            <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
        <tr class="tableheader">
          <td colspan="2">Member Statistics:</td>
        </tr>
        <tr class="row2">
          <td width="22%">Member Since: </td>
          <td width="78%"><%=(member_details.Fields.Item("DateAdded").Value)%></td>
        </tr>
        <tr class="row2">
          <td height="20">Last Login Date:</td>
          <td><%=(member_details.Fields.Item("LastDateAccessed").Value)%></td>
        </tr>
        <tr class="row2">
          <td>Login Count:</td>
          <td><%=(member_details.Fields.Item("LoginCount").Value)%></td>
        </tr>
      </table>        <br>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
        <tr>
          <td colspan="2" class="tableheader">Personal Details:</td>
        </tr>
        <tr class="row2">
          <td width="16%">Profile/Bio:</td>
          <td width="84%"><textarea name="Profile" cols="40" rows="6" id="Profile"><%=(member_details.Fields.Item("Profile").Value)%></textarea>
          </td>
        </tr>
        <tr class="row2">
          <td height="47">Photo:</td>
          <td><%		  						  
Dim objimagemember
strImage = "../../applications/RegistrationManager/images/" & member_details.Fields.Item("ImageFile").Value
Set objimagemember = CreateObject("Scripting.FileSystemObject")
If objimagemember.FileExists(Server.MapPath(strImage)) then
%>
            <% if member_details.Fields.Item("ImageFile").Value <> "" then %>              <img src="../../applications/RegistrationManager/images/<%=(member_details.Fields.Item("ImageFile").Value)%>" alt="Click to Zoom" width="150"> |
              <input name="ImageFile" type="text" id="ImageFile" value="<%=(member_details.Fields.Item("ImageFile").Value)%>">
              <% end if%>
              <% end if%>
      | <a href="javascript:;" onClick="MM_openBrWindow('upload_image.asp?MemberID=<%=(member_details.Fields.Item("MemberID").Value)%>','Image','scrollbars=yes,width=300,height=150')">ADD
      New Picture</a> </td>
        </tr>
      </table>        <br>
            <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
              <tr class="tableheader">
                <td colspan="2">Additional Details</td>
              </tr>
              <tr class="row2">
                <td width="25%"><%=(Category.Fields.Item("CategoryLabel").Value)%></td>
                <td width="75%"><select name="CategoryID" id="CategoryID">
                    <%
While (NOT Category.EOF)
%>
                    <option value="<%=(Category.Fields.Item("CategoryID").Value)%>" <%If (Not isNull((member_details.Fields.Item("CategoryID").Value))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr((member_details.Fields.Item("CategoryID").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryValue").Value)%></option>
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
      | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      Category</a> </td>
              </tr>
              <tr class="row2">
                <td>
                  <% If Not MemberLookuptxt1.EOF Or Not MemberLookuptxt1.BOF Then %>
                  <%=(MemberLookuptxt1.Fields.Item("MemberLookuptxt1ItemName").Value)%>
                  <% End If ' end Not MemberLookuptxt1.EOF Or NOT MemberLookuptxt1.BOF %>
                </td>
                <td><select name="MemberLookuptxt1" id="MemberLookuptxt1">
                    <%
While (NOT MemberLookuptxt1.EOF)
%>
                    <option value="<%=(MemberLookuptxt1.Fields.Item("MemberLookuptxt1ItemValue").Value)%>" <%If (Not isNull((member_details.Fields.Item("MemberLookuptxt1").Value))) Then If (CStr(MemberLookuptxt1.Fields.Item("MemberLookuptxt1ItemValue").Value) = CStr((member_details.Fields.Item("MemberLookuptxt1").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(MemberLookuptxt1.Fields.Item("MemberLookuptxt1ItemValue").Value)%></option>
                    <%
  MemberLookuptxt1.MoveNext()
Wend
If (MemberLookuptxt1.CursorType > 0) Then
  MemberLookuptxt1.MoveFirst
Else
  MemberLookuptxt1.Requery
End If
%>
                  </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt1.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
              </tr>
              <tr class="row2">
                <td>
                  <% If Not MemberLookuptxt2.EOF Or Not MemberLookuptxt2.BOF Then %>
                  <%=(MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemName").Value)%>
                  <% End If ' end Not MemberLookuptxt2.EOF Or NOT MemberLookuptxt2.BOF %>
                </td>
                <td><select name="MemberLookuptxt2" id="MemberLookuptxt2">
                    <%
While (NOT MemberLookuptxt2.EOF)
%>
                    <option value="<%=(MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemValue").Value)%>" <%If (Not isNull((member_details.Fields.Item("MemberLookuptxt2").Value))) Then If (CStr(MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemValue").Value) = CStr((member_details.Fields.Item("MemberLookuptxt2").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemValue").Value)%></option>
                    <%
  MemberLookuptxt2.MoveNext()
Wend
If (MemberLookuptxt2.CursorType > 0) Then
  MemberLookuptxt2.MoveFirst
Else
  MemberLookuptxt2.Requery
End If
%>
                  </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt2.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
              </tr>
              <tr class="row2">
                <td>
                  <% If Not MemberLookuptxt3.EOF Or Not MemberLookuptxt3.BOF Then %>
                  <%=(MemberLookuptxt3.Fields.Item("MemberLookuptxt3ItemName").Value)%>
                  <% End If ' end Not MemberLookuptxt3.EOF Or NOT MemberLookuptxt3.BOF %>
                </td>
                <td><select name="MemberLookuptxt3" id="MemberLookuptxt3">
                    <%
While (NOT MemberLookuptxt3.EOF)
%>
                    <option value="<%=(MemberLookuptxt3.Fields.Item("MemberLookuptxt3ItemValue").Value)%>" <%If (Not isNull((member_details.Fields.Item("MemberLookuptxt3").Value))) Then If (CStr(MemberLookuptxt3.Fields.Item("MemberLookuptxt3ItemValue").Value) = CStr((member_details.Fields.Item("MemberLookuptxt3").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(MemberLookuptxt3.Fields.Item("MemberLookuptxt3ItemValue").Value)%></option>
                    <%
  MemberLookuptxt3.MoveNext()
Wend
If (MemberLookuptxt3.CursorType > 0) Then
  MemberLookuptxt3.MoveFirst
Else
  MemberLookuptxt3.Requery
End If
%>
                  </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt3.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
              </tr>
              <tr class="row2">
                <td>
                  <% If Not MemberLookuptxt4.EOF Or Not MemberLookuptxt4.BOF Then %>
                  <%=(MemberLookuptxt4.Fields.Item("MemberLookuptxt4ItemName").Value)%>
                  <% End If ' end Not MemberLookuptxt4.EOF Or NOT MemberLookuptxt4.BOF %>
                </td>
                <td><select name="MemberLookuptxt4" id="MemberLookuptxt4">
                    <%
While (NOT MemberLookuptxt4.EOF)
%>
                    <option value="<%=(MemberLookuptxt4.Fields.Item("MemberLookuptxt4ItemValue").Value)%>" <%If (Not isNull((member_details.Fields.Item("MemberLookuptxt4").Value))) Then If (CStr(MemberLookuptxt4.Fields.Item("MemberLookuptxt4ItemValue").Value) = CStr((member_details.Fields.Item("MemberLookuptxt4").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(MemberLookuptxt4.Fields.Item("MemberLookuptxt4ItemValue").Value)%></option>
                    <%
  MemberLookuptxt4.MoveNext()
Wend
If (MemberLookuptxt4.CursorType > 0) Then
  MemberLookuptxt4.MoveFirst
Else
  MemberLookuptxt4.Requery
End If
%>
                  </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt4.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
              </tr>
              <tr class="row2">
                <td>
                  <% If Not MemberLookuptxt5.EOF Or Not MemberLookuptxt5.BOF Then %>
                  <%=(MemberLookuptxt5.Fields.Item("MemberLookuptxt5ItemName").Value)%>
                  <% End If ' end Not MemberLookuptxt5.EOF Or NOT MemberLookuptxt5.BOF %>
                </td>
                <td><select name="MemberLookuptxt5" id="MemberLookuptxt5">
                    <%
While (NOT MemberLookuptxt5.EOF)
%>
                    <option value="<%=(MemberLookuptxt5.Fields.Item("MemberLookuptxt5ItemValue").Value)%>" <%If (Not isNull((member_details.Fields.Item("MemberLookuptxt5").Value))) Then If (CStr(MemberLookuptxt5.Fields.Item("MemberLookuptxt5ItemValue").Value) = CStr((member_details.Fields.Item("MemberLookuptxt5").Value))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(MemberLookuptxt5.Fields.Item("MemberLookuptxt5ItemValue").Value)%></option>
                    <%
  MemberLookuptxt5.MoveNext()
Wend
If (MemberLookuptxt5.CursorType > 0) Then
  MemberLookuptxt5.MoveFirst
Else
  MemberLookuptxt5.Requery
End If
%>
                  </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt5.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
              </tr>
            </table>
            <p>&nbsp; </p>
            <p>
              <input name="submit" type="submit" value="Update Record">
            </p>
      </td></tr>
  </table>

    <input type="hidden" name="MM_update" value="member_details">
  <input type="hidden" name="MM_recordId" value="<%= member_details.Fields.Item("MemberID").Value %>">
</form>
<%
member_details.Close()
Set member_details = Nothing
%>
<%
MemberLookuptxt1.Close()
Set MemberLookuptxt1 = Nothing
%>
<%
MemberLookuptxt2.Close()
Set MemberLookuptxt2 = Nothing
%>
<%
MemberLookuptxt3.Close()
Set MemberLookuptxt3 = Nothing
%>
<%
MemberLookuptxt4.Close()
Set MemberLookuptxt4 = Nothing
%>
<%
MemberLookuptxt5.Close()
Set MemberLookuptxt5 = Nothing
%>
<%
Lookup_State.Close()
Set Lookup_State = Nothing
%>
<%
Lookup_Country.Close()
Set Lookup_Country = Nothing
%>
<%
Category.Close()
Set Category = Nothing
%>
<%
security_level.Close()
Set security_level = Nothing
%>
