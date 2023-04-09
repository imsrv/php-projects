<!--#include virtual="/Connections/registrationmanager.asp" -->
<%
' *** Edit Operations: declare variables

'Dim MM_editAction
'Dim MM_abortEdit
'Dim MM_editQuery
'Dim MM_editCmd

'Dim MM_editConnection
'Dim MM_editTable
'Dim MM_editRedirectUrl
'Dim MM_editColumn
'Dim MM_recordId

'Dim MM_fieldsStr
'Dim MM_columnsStr
'Dim MM_fields
'Dim MM_columns
'Dim MM_typeArray
'Dim MM_formVal
'Dim MM_delim
'Dim MM_altVal
'Dim MM_emptyVal
'Dim MM_i

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
  MM_dupKeyRedirect= Request.ServerVariables("HTTP_REFERER")
  MM_rsKeyConnection=MM_registrationmanager_STRING
  MM_dupKeyUsernameValue = CStr(Request.Form("Username"))
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
If (CStr(Request("MM_insert")) = "member_details") Then
  MM_editConnection = MM_registrationmanager_STRING
  MM_editTable = "tblMM_Members"
  MM_editRedirectUrl = ""
  MM_fieldsStr  = "Salutation|value|FirstName|value|LastName|value|Username|value|Password1|value|SecurityQuestion|value|SecurityResponse|value|OrgName1|value|OrgName2|value|JobTitle|value|WebsiteURL|value|Address1|value|Phone|value|Address2|value|CellPhone|value|City|value|Fax|value|PostalCode|value|EmailAddress|value|State|value|Country|value|Map|value|Profile|value|CategoryID|value|MemberLookuptxt1|value|MemberLookuptxt2|value|MemberLookuptxt3|value|MemberLookuptxt4|value|MemberLookuptxt5|value|DateAdded|value|Activated|value"
  MM_columnsStr = "Salutation|',none,''|FirstName|',none,''|LastName|',none,''|UserName|',none,''|Password1|',none,''|SecurityQuestion|',none,''|SecurityResponse|',none,''|OrgName1|',none,''|OrgName2|',none,''|JobTitle|',none,''|WebsiteURL|',none,''|Address1|',none,''|Phone|',none,''|Address2|',none,''|CellPhone|',none,''|City|',none,''|Fax|',none,''|PostalCode|',none,''|EmailAddress|',none,''|State|',none,''|Country|',none,''|Map|',none,''|Profile|',none,''|CategoryID|none,none,NULL|MemberLookuptxt1|',none,''|MemberLookuptxt2|',none,''|MemberLookuptxt3|',none,''|MemberLookuptxt4|',none,''|MemberLookuptxt5|',none,''|DateAdded|',none,NULL|Activated|',none,''"

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

'Dim MM_tableValues
'Dim MM_dbValues

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

MemberLookuptxt1_numRows = 0
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
Lookup_Country.Source = "SELECT *  FROM tblLookupCountry  ORDER BY CountryName"
Lookup_Country.CursorType = 0
Lookup_Country.CursorLocation = 2
Lookup_Country.LockType = 1
Lookup_Country.Open()

Lookup_Country_numRows = 0
%>
<% IF (Request.Form("success") = "yes") then %>
<!--#include file="components/inc_cdomailer.asp" -->
<% end if%>
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
<link href="../../styles.css" rel="stylesheet" type="text/css">
<body>

  <% IF Request.Querystring("requsername") <> "" then %>
  <strong> <font color="#FF0000" size="2">Username &quot;<%= Request.QueryString("requsername") %>&quot; already exists. <a href="javascript:history.go(-1);">Please 

  try again.</a></font></strong>
<% End if %>
  <% IF NOT Request.Querystring("requsername") <> "" then %>
  <% IF NOT (Request.Form("success") = "yes") then %>
<form ACTION="<%=MM_editAction%>" METHOD="POST" name="member_details" id="member_details" onSubmit="YY_checkform('member_details','FirstName','#q','0','Please provide \'First Name\'.','LastName','#q','0','Please provide \'Last Name\'.','Username','#q','0','Please provide \'Username\'.','Password1','#q','0','Please provide \'Password\'.','SecurityQuestion','#q','1','Please provide \'Security Question\'.','SecurityResponse','#q','0','Please select \'Security Response\'.','Address1','#q','0','Please provide \'Address\'.','City','#q','0','Please provide \'City\'.','PostalCode','#q','0','Please provide \'Postal Code\'.','EmailAddress','#S','2','Please provide valid \'EmailAddress\'.','State','#q','1','Please select \'Province/State\'.','Country','#q','1','Please select \'Country\'.','CategoryID','#q','1','Please select \'<%=(Category.Fields.Item("CategoryLabel").Value)%>\'.');return document.MM_returnValue">
  <table width="100%" height="392" align="center" cellpadding="0" cellspacing="0" class="tableborder">
    <tr>
      <td height="390" align="right" valign="top">
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="6">Contact Details</td>
          </tr>
          <tr class="row2">
            <td width="8%">Salutation:</td>
            <td width="9%"><select name="Salutation" id="Salutation">
              <option value="NA" selected>None</option>
              <option value="Mr.">Mr.
              <option value="Mrs.">Mrs.
              <option value="Miss">Miss
              <option value="Dr.">Dr.
              <option value="Fr.">Fr.
              <option value="Sr.">Sr.
            </select></td>
            <td width="10%"><div align="right"><strong><font color="#FF0000">*</font></strong>First
            Name:</div></td>
            <td width="14%">            <input name="FirstName" type="text" id="FirstName" size="25">
            </td>
            <td width="9%"><div align="right"><strong><font color="#FF0000">*</font></strong>Last
            Name:</div></td>
            <td width="50%"><input name="LastName" type="text" id="LastName" size="35"></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="2">Security/Login Details</td>
          </tr>
          <tr class="row2">
            <td width="14%"><strong><font color="#FF0000">*</font></strong>Username:</td>
            <td width="86%"><input name="Username" type="text" id="Username" >
Use your email address or another name you will remember as your User ID, minimum
  6 characters            </td>
          </tr>
          <tr class="row2">
            <td><strong><font color="#FF0000">*</font></strong>Password:</td>
            <td><input name="Password1" type="text" id="Password1" >
Minimum 6 characters, Maximum 20 characters            </td>
          </tr>
          <tr class="row2">
            <td><strong></strong><strong><font color="#FF0000">*</font></strong>Security Question:</td>
            <td>			<Select name="SecurityQuestion" class="enroll">
							<option value="NA" selected>...Select Security Question</option>
				<option>What's my mother's maiden name</option>
				<option>What's my favorite colour</option>
				<option>What's my favorite food</option>
				<option>What's the name of my pet</option>
				<option>What's my nickname</option>

			</select>
              Question that we can ask you to answer before resending your password.
            Pick one.            </td>
          </tr>
          <tr class="row2">
            <td><strong></strong><strong><font color="#FF0000">*</font></strong>Security Response:</td>
            <td><input name="SecurityResponse" type="text" id="SecurityResponse" >              The answer to the security question            </td>
          </tr>
        </table>        
        <br>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="4">Company Details/Organization Affiliation</td>
          </tr>
          <tr class="row2">
            <td width="19%">Company/Institution Name: </td>
            <td width="28%"><input name="OrgName1" type="text" id="OrgName1">
            </td>
            <td width="16%">Division:</td>
            <td width="37%"><input name="OrgName2" type="text" id="OrgName2">
            </td>
          </tr>
          <tr class="row2">
            <td>Job Title:</td>
            <td><input name="JobTitle" type="text" id="JobTitle">
            </td>
            <td>Web Site URL:</td>
            <td>http://
                <input name="WebsiteURL" type="text" id="WebsiteURL">
            </td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="4"> Address Details</td>
          </tr>
          <tr class="row2">
            <td width="21%"><strong><font color="#FF0000">*</font></strong>Address 1: </td>
            <td width="17%"><input name="Address1" type="text" id="Address1">
            </td>
            <td width="31%">Phone:</td>
            <td width="31%"><input name="Phone" type="text" id="Phone" >
            </td>
          </tr>
          <tr class="row2">
            <td>Address 2:</td>
            <td><input name="Address2" type="text" id="Address2" >
            </td>
            <td>Cell:</td>
            <td><input name="CellPhone" type="text" id="CellPhone" >
            </td>
          </tr>
          <tr class="row2">
            <td><strong><font color="#FF0000">*</font></strong>City:</td>
            <td><input name="City" type="text" id="City">
            </td>
            <td>Fax:</td>
            <td><input name="Fax" type="text" id="Fax" >
            </td>
          </tr>
          <tr class="row2">
            <td><strong><font color="#FF0000">*</font></strong>Postal Code:</td>
            <td><input name="PostalCode" type="text" id="PostalCode">
            </td>
            <td><strong><font color="#FF0000">*</font></strong>Email</td>
            <td><input name="EmailAddress" type="text" id="EmailAddress" ></td>
          </tr>
          <tr class="row2">
            <td><strong><font color="#FF0000">*</font></strong>Province/State:</td>
            <td><select name="State" id="State">
			<option selected value="NA">...Select State/Prov</option>
                <%
While (NOT Lookup_State.EOF)
%>
                <option value="<%=(Lookup_State.Fields.Item("StateName").Value)%>">
  <%=(Lookup_State.Fields.Item("StateName").Value)%>
  </option>
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
  <td><strong><font color="#FF0000">*</font></strong>Country:</td>
  <td><select name="Country" id="Country">
      <option selected value="NA">...Select Country</option>
      <option value="United States">United States</option>
      <option value="Canada">Canada</option>
      <option value="United Kingdom">United Kingdom</option>
      <%
While (NOT Lookup_Country.EOF)
%>
      <option value="<%=(Lookup_Country.Fields.Item("CountryName").Value)%>"><%=(Lookup_Country.Fields.Item("CountryName").Value)%></option>
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
    <td colspan="3"><input name="Map" type="text" id="Map" size="60">
    | <a href="http://ca.maps.yahoo.com" target="_blank">Get URL from Yahoo Maps</a></td>
  </tr>
  </table>
  <div align="left"><br>
      <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
        <tr>
          <td colspan="2" class="tableheader">Personal Details</td>
        </tr>
        <tr class="row2">
          <td width="24%">Profile/Bio:</td>
          <td width="76%"><textarea name="Profile" cols="40" rows="6" id="Profile"></textarea>
          </td>
        </tr>
      </table>
      <br>
      <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
        <tr class="tableheader">
          <td colspan="2">Additional Details</td>
        </tr>
        <tr class="row2">
          <td width="25%"><strong><font color="#FF0000">*</font></strong><%=(Category.Fields.Item("CategoryLabel").Value)%>:</td>
          <td width="75%"><select name="CategoryID" id="CategoryID">
              <option selected value="0">...Select <%=(Category.Fields.Item("CategoryLabel").Value)%></option>
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
          </td>
        </tr>
        <% If Not MemberLookuptxt1.EOF Or Not MemberLookuptxt1.BOF Then %>
        <tr class="row2">
          <td><%=(MemberLookuptxt1.Fields.Item("MemberLookuptxt1ItemName").Value)%>:</td>
          <td><select name="MemberLookuptxt1" id="MemberLookuptxt1">
              <option selected value="">...Select <%=(MemberLookuptxt1.Fields.Item("MemberLookuptxt1ItemName").Value)%></option>
              <%
While (NOT MemberLookuptxt1.EOF)
%>
              <option value="<%=(MemberLookuptxt1.Fields.Item("MemberLookuptxt1ItemValue").Value)%>"><%=(MemberLookuptxt1.Fields.Item("MemberLookuptxt1ItemValue").Value)%></option>
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
              <%=(MemberLookuptxt1.Fields.Item("MemberLookuptxt1ItemDesc").Value)%> </td>
        </tr>
        <% End If ' end Not MemberLookuptxt1.EOF Or NOT MemberLookuptxt1.BOF %>
        <% If Not MemberLookuptxt2.EOF Or Not MemberLookuptxt2.BOF Then %>
        <tr class="row2">
          <td><%=(MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemName").Value)%>:</td>
          <td><select name="MemberLookuptxt2" id="MemberLookuptxt2">
              <option selected value="">...Select <%=(MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemName").Value)%></option>
              <%
While (NOT MemberLookuptxt2.EOF)
%>
              <option value="<%=(MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemValue").Value)%>"><%=(MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemValue").Value)%></option>
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
              <%=(MemberLookuptxt2.Fields.Item("MemberLookuptxt2ItemDesc").Value)%> </td>
        </tr>
        <% End If ' end Not MemberLookuptxt2.EOF Or NOT MemberLookuptxt2.BOF %>
        <% If Not MemberLookuptxt3.EOF Or Not MemberLookuptxt3.BOF Then %>
        <tr class="row2">
          <td><%=(MemberLookuptxt3.Fields.Item("MemberLookuptxt3ItemName").Value)%>:</td>
          <td><select name="MemberLookuptxt3" id="MemberLookuptxt3">
              <option selected value="">...Select <%=(MemberLookuptxt3.Fields.Item("MemberLookuptxt3ItemName").Value)%></option>
              <%
While (NOT MemberLookuptxt3.EOF)
%>
              <option value="<%=(MemberLookuptxt3.Fields.Item("MemberLookuptxt3ItemValue").Value)%>"><%=(MemberLookuptxt3.Fields.Item("MemberLookuptxt3ItemValue").Value)%></option>
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
              <%=(MemberLookuptxt3.Fields.Item("MemberLookuptxt3ItemDesc").Value)%> </td>
        </tr>
        <% End If ' end Not MemberLookuptxt3.EOF Or NOT MemberLookuptxt3.BOF %>
        <% If Not MemberLookuptxt4.EOF Or Not MemberLookuptxt4.BOF Then %>
        <tr class="row2">
          <td><%=(MemberLookuptxt4.Fields.Item("MemberLookuptxt4ItemName").Value)%>:</td>
          <td><select name="MemberLookuptxt4" id="MemberLookuptxt4">
              <option selected value="">...Select <%=(MemberLookuptxt4.Fields.Item("MemberLookuptxt4ItemName").Value)%></option>
              <%
While (NOT MemberLookuptxt4.EOF)
%>
              <option value="<%=(MemberLookuptxt4.Fields.Item("MemberLookuptxt4ItemValue").Value)%>"><%=(MemberLookuptxt4.Fields.Item("MemberLookuptxt4ItemValue").Value)%></option>
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
              <%=(MemberLookuptxt4.Fields.Item("MemberLookuptxt4ItemDesc").Value)%> </td>
        </tr>
        <% End If ' end Not MemberLookuptxt4.EOF Or NOT MemberLookuptxt4.BOF %>
        <% If Not MemberLookuptxt5.EOF Or Not MemberLookuptxt5.BOF Then %>
        <tr class="row2">
          <td><%=(MemberLookuptxt5.Fields.Item("MemberLookuptxt5ItemName").Value)%>:</td>
          <td><select name="MemberLookuptxt5" id="MemberLookuptxt5">
              <option selected value="">...Select <%=(MemberLookuptxt5.Fields.Item("MemberLookuptxt5ItemName").Value)%></option>
              <%
While (NOT MemberLookuptxt5.EOF)
%>
              <option value="<%=(MemberLookuptxt5.Fields.Item("MemberLookuptxt5ItemValue").Value)%>"><%=(MemberLookuptxt5.Fields.Item("MemberLookuptxt5ItemValue").Value)%></option>
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
              <%=(MemberLookuptxt5.Fields.Item("MemberLookuptxt5ItemDesc").Value)%> </td>
        </tr>
        <% End If ' end Not MemberLookuptxt5.EOF Or NOT MemberLookuptxt5.BOF %>
      </table>
      <p><strong><font color="#FF0000">*</font>Required Fields </strong></p>
      <input name="success" type="hidden" id="success" value="yes">
      <input name="DateAdded" type="hidden" id="DateAdded" value="<%= DoDateTime(Date(), 2, 7177) %>">
      <input name="Activated" type="hidden" id="Activated" value="False">
      <input name="submit" type="submit" value="Register">
  </div>
  </td>
  </tr>
  </table>
  <input type="hidden" name="MM_insert" value="member_details">
</form>
<% End if %>
<% End if %>
<% IF (Request.Form("success") = "yes") then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong>     
Congratulations <%=Request.Form("FirstName")%>, Your registration was successfully submitted.</strong></td>
  </tr>
</table>
<%end if%>
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