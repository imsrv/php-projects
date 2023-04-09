<!--#include virtual="/Connections/secureloginmanager.asp" -->
<% IF (Request.Form("remember") = "yes") then
          Response.Cookies("remember")("username") =  Request.Form("username")
          Response.Cookies("remember")("password") = Request.Form("password")
		  Response.Cookies("remember")("rememberme") = "yes"
          Response.Cookies("remember").Expires = date + 90
		  Else
		  Response.Cookies("remember").Expires = date -1
End If %>
<%
' *** Validate request to log in to this site.
MM_LoginAction = Request.ServerVariables("URL")
If Request.QueryString<>"" Then MM_LoginAction = MM_LoginAction + "?" + Request.QueryString
MM_valUsername=CStr(Request.Form("Username"))
If MM_valUsername <> "" Then
  MM_fldUserAuthorization="SecurityLevelID"
  MM_redirectLoginSuccess="/applications/SecureLoginManager/components/processlogin.asp"
  MM_redirectLoginFailed= "/applications/SecureLoginManager/components/processlogin.asp"
  MM_flag="ADODB.Recordset"
  set MM_rsUser = Server.CreateObject(MM_flag)
  MM_rsUser.ActiveConnection = MM_secureloginmanager_STRING
  MM_rsUser.Source = "SELECT UserName, Password1"
  If MM_fldUserAuthorization <> "" Then MM_rsUser.Source = MM_rsUser.Source & "," & MM_fldUserAuthorization
  MM_rsUser.Source = MM_rsUser.Source & " FROM tblMM_Members WHERE Activated = 'True' AND UserName='" & Replace(MM_valUsername,"'","''") &"' AND Password1='" & Replace(Request.Form("password"),"'","''") & "'"
  MM_rsUser.CursorType = 0
  MM_rsUser.CursorLocation = 2
  MM_rsUser.LockType = 3
  MM_rsUser.Open
  If Not MM_rsUser.EOF Or Not MM_rsUser.BOF Then 
    ' username and password match - this is a valid user
    Session("MM_Username") = MM_valUsername
    If (MM_fldUserAuthorization <> "") Then
      Session("MM_UserAuthorization") = CStr(MM_rsUser.Fields.Item(MM_fldUserAuthorization).Value)
    Else
      Session("MM_UserAuthorization") = ""
    End If
    if CStr(Request.QueryString("accessdenied")) <> "" And true Then
      MM_redirectLoginSuccess = Request.QueryString("accessdenied")
    End If
    MM_rsUser.Close
    Response.Redirect(MM_redirectLoginSuccess)
  End If
  MM_rsUser.Close
  Response.Redirect(MM_redirectLoginFailed)
End If
%>
<%
Dim rsPassword__MMColParam
rsPassword__MMColParam = "0"
If (Request.Form("EmailAddress")     <> "") Then 
  rsPassword__MMColParam = Request.Form("EmailAddress")    
End If
%>
<%
Dim rsPassword__MMColParam1
rsPassword__MMColParam1 = "0"
If (Session("MM_Username") <> "") Then 
  rsPassword__MMColParam1 = Session("MM_Username")
End If
%>
<%
set rsPassword = Server.CreateObject("ADODB.Recordset")
rsPassword.ActiveConnection = MM_secureloginmanager_STRING
rsPassword.Source = "SELECT *  FROM tblMM_Members  WHERE Activated = 'True' AND (EmailAddress = '" + Replace(rsPassword__MMColParam, "'", "''") + "' OR UserName = '" + Replace(rsPassword__MMColParam1, "'", "''") + "')"
rsPassword.CursorType = 0
rsPassword.CursorLocation = 2
rsPassword.LockType = 3
rsPassword.Open()
rsPassword_numRows = 0
%>
<%
Dim rsPreferences
Dim rsPreferences_numRows

Set rsPreferences = Server.CreateObject("ADODB.Recordset")
rsPreferences.ActiveConnection = MM_secureloginmanager_STRING
rsPreferences.Source = "SELECT *  FROM tblSLM_MessagingPreferences"
rsPreferences.CursorType = 0
rsPreferences.CursorLocation = 2
rsPreferences.LockType = 1
rsPreferences.Open()

rsPreferences_numRows = 0
%>
<% If Request.Form("SendPassword") = "SendPassword" Then %>
<%
' *** Redirect If Recordset Is Empty
' *** MagicBeat Server Behavior - 2014 - by Jag S. Sidhu - www.magicbeat.com
If NOT (rsPassword.EOF) Then

    'Create the mail object and send the mail
	Set objMail = Server.CreateObject("CDO.Message") 
	Set objCDOSYSCon = Server.CreateObject ("CDO.Configuration") 
	Set Flds = objCDOSYSCon.Fields
	
	'Out going SMTP server 
objCDOSYSCon.Fields("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2 
objCDOSYSCon.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "mail.yoursmtpserver.com"
objCDOSYSCon.Fields("http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout") = 60 
objCDOSYSCon.Fields("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25 
objCDOSYSCon.Fields.Update 
set objMail.Configuration = objCDOSYSCon 

	objMail.From = rsPreferences.fields("AdminEmailAddress").value
	objMail.To = rsPassword.fields("EmailAddress").value
	objMail.CC = ""
	objMail.BCC = ""
	objMail.Subject = rsPreferences.fields("MessageSubjectVisitor").value
	objMail.TextBody = 	"Dear " & rsPassword.fields("FirstName") & "," & vbCrLf _
	& vbCrLf _
	& rsPreferences.fields("MessageBodyVisitor").value & vbCrLf _
	& vbCrLf _ 
	& "Email Address:  " & rsPassword.fields("EmailAddress")& vbCrLf _ 
	& "User Name:  " & rsPassword.fields("Username") & vbCrLf _
	& "Password:  " & rsPassword.fields("Password1") & vbCrLf _ 
	& vbCrLf _
	& "Login @ " & Request.ServerVariables("HTTP_REFERER")&  vbCrLf _
	& vbCrLf _
	& vbCrLf _
	& rsPreferences.Fields.Item("MessageFooterVisitorLine1").Value & vbCrLf _
	& rsPreferences.Fields.Item("MessageFooterVisitorLine2").Value & vbCrLf _ 
	& rsPreferences.Fields.Item("MessageFooterVisitorLine3").Value & vbCrLf 
	objMail.Send()
Set objMail = Nothing
    'Send them to the page specified if requested
Dim rp_redirectpw
      If Request.QueryString <> "" Then
      rp_redirectpw = Request.ServerVariables("HTTP_REFERER") & "&sent=true"
    Else
      rp_redirectpw = Request.ServerVariables("HTTP_REFERER") & "?sent=true"
    End If
	Response.Redirect rp_redirectpw
	
Else
    'Send them to the page specified if requested
Dim rp_redirectpwn
      If Request.QueryString <> "" Then
      rp_redirectpwn = Request.ServerVariables("HTTP_REFERER") & "&sent=false"
    Else
      rp_redirectpwn = Request.ServerVariables("HTTP_REFERER") & "?sent=false"
    End If
	Response.Redirect rp_redirectpwn
	
End If 
%>
<% end if%>
<head>
<SCRIPT language=JavaScript>
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
// -->
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
<link href="../../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<% if Session("MM_Username") <> "" AND  Request.Querystring("accessdenied") = "" then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><!--#include file="components/inc_personalization.asp" --></td>
  </tr>
</table>
<%else%>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr> 
    <td>      <p><font color="#FF0000"><b>
        <% IF (Request.Querystring("accessdenied") <> "") then %>
      You are not authorized to access this area
      <% End If %>
      </b></font></p>
      <form name="login" method="POST" action="<%=MM_LoginAction%>" onSubmit="YY_checkform('login','Username','#q','0','Please provide Username','password','#q','0','Please provide Password');return document.MM_returnValue" >
        <% IF (Request.Querystring("valid") <> "false") then %>
		<% IF NOT (Request.Querystring("problem") = "yes") then %>
		<% IF NOT Request.Querystring("sent") <> "" then %>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" height="136">
          <tr> 
            <td width="22%"> 
              <p><b>Login</b></p>
            </td>
            <td width="78%">&nbsp;</td>
          </tr>
          <tr> 
            <td> 
              <p>Username:</p>
            </td>
            <td> 
              <input name="Username" type="text" id="Username" value="<%=Request.Cookies("remember")("username")%>">
            </td>
          </tr>
          <tr> 
            <td> 
              <p>Password:</p>
            </td>
            <td> 
              <input name="password" type="password" value="<%=Request.Cookies("remember")("password")%>">
            </td>
          </tr>
          <tr> 
            <td> 
              <p>Remember Me?</p>
            </td>
            <td> 
              <input type="checkbox" name="remember" value="yes" 
<% IF (Request.Cookies("remember")("rememberme")="yes") then %> checked <%end if%> >
            *Session Cookies must be enabled            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> 
              <input type="submit" name="Submit" value="Login">
            </td>
          </tr>
        </table>
        <ul>
          <li><a href="extras/sample_protected_page_level1.asp">Click to Enter</a>  Authorized Area (Must have
            security Level 1)</li>
          <li><a href="extras/sample_protected_page_level2.asp">Click to Enter</a> Authorized Area
          (Must have security Level 1 or 2)</li>
          <li><a href="extras/sample_protected_page_level3.asp">Click to Enter</a>  Authorized Area
          (Must have security Level 1, 2 or 3)</li>
        </ul>
        <p>Visit the Secure Login Manager <a href="../../admin/SecureLoginManager/admin.asp">admin
          area</a> to obtain a Username/Password</p>
      </form>
<% end if%>
<% end if%>
<% end if%>
  <% IF (Request.Querystring("valid") = "false") then %>
        <font color="#FF0000"><b>You entered either an incorrect Username
        or Password - please <a href="javascript:history.go(-1)">try again</a></b></font> or <a href="<%=request.servervariables("URL")%>?problem=yes
<%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%>
<%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%>
<%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%>
<%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>
<%If Request.QueryString ("vid")<> "" Then %>&vid=<%=request.querystring("vid")%><%end if%>">Click
        here for help</a> 
        <% End If %>
<% IF (Request.Querystring("problem") = "yes") then %>
      <p>If you are having problems signing in, ask yourself the following questions: 
      </p>
      <p><b>Are you having difficulty accessing your account because of a problem 
        with your password? </b></p>
      <ol>
        <li>Your password and/or login cannot contain any spaces. </li>
        <li>Your password must be at least six (6) characters long. For increased 
          security, we recommend creating a password containing both numbers and 
          letters. </li>
        <li>Your password is case sensitive, so remember which letters you capitalized. 
          <br>
          Are you using a browser that doesn't support cookies, or do you have 
          cookies disabled? </li>
        <li>Your account has been de-activated.</li>
      </ol>
      <p><b>Your browser must support cookies, and the option must be enabled 
        to sign in. </b></p>
      <p><b>To enable cookies </b></p>
      <p>Internet Explorer 5 </p>
      <ol>
        <li>Click <b>Tools</b>, and then click <b>Internet Options</b>.</li>
        <li>Click the Security tab. </li>
        <li>Click the <b>Internet</b> zone. </li>
        <li>Select a security level other than High. <br>
          -or- <br>
          Click <b>Custom Level</b>, scroll to the Cookies section, and then click 
          <b>Enable</b> for both cookie options. <br>
        </li>
      </ol>
      <p>Internet Explorer 4.x </p>
      <ol>
        <li>Click <b>View</b>, and then click <b>Internet Options</b>.</li>
        <li>Click the <b>Advanced</b> tab. </li>
        <li>Scroll to the Security section. </li>
        <li>Under Cookies, click <b>Always accept cookies</b>. </li>
      </ol>
      <p>Other browsers </p>
      <p>To see if your browser supports cookies, and for detailed instructions 
        about how to enable this feature, see the online Help for your browser.<br>
        If you see a message to notify you that a Web site is trying to send you 
        a cookie when you try to sign in, you should choose to continue or you 
        will not be able to sign in. </p>
      <p>If your browser does not support cookies, you can upgrade to a newer 
        browser, such as <a href="http://www.microsoft.com/ie/download" target="_blank">Internet 
        Explorer 5</a>. </p>
      <p align="center"><font color="#FF0000"><b><a href="javascript:history.go(-2)">try again</a></b></font> </p>
<% End If %>
<% IF NOT Request.Querystring("sent") <> "" then %>
<% IF (Request.Querystring("valid") <> "false") then %>
<% IF (Request.Querystring("problem") <> "yes") then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
<form action="" method="post" name="email" onSubmit="MM_validateForm('EmailAddress','','RisEmail');return document.MM_returnValue" >
  <p>Forgot your password ? Enter your email address 
    <input name="EmailAddress" type="text" id="EmailAddress" size="30" >
    <input name="Submit2" type="submit" value="Send Password">
    <input name="SendPassword" type="hidden" id="SendPassword" value="SendPassword">
  </p>
</form></td>
  </tr>
</table>
<%end if%>
<%end if%>
<%end if%>
        <% IF (Request.Querystring("sent") = "false") then %>
      <h2><font color="#FF0000">OOPS</font></h2>
      <p>Sorry but the email address  you entered         was either spelled
        incorrectly or has never been registered. <br>
        Email not in database please <font color="#FF0000"><b><a href="javascript:history.go(-1)">try
        again</a></b></font> or contact system administrator. 
        <% End If %>
      </p>
      <% IF Request.Querystring("sent") then %>
      <h1>Success!</h1>
      <p>Thank you , your password has been sent....<font color="#FF0000"><b><a href="javascript:history.go(-1)">Login</a></b></font></p>
      <% End If %>
    </td>
  </tr>
</table>
<% End If %>
</body>
  <%
rsPassword.Close()
%>
  <%
rsPreferences.Close()
Set rsPreferences = Nothing
%>
