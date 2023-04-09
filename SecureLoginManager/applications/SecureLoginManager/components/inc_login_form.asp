<%
' *** Logout the current user.
MM_Logout = CStr(Request.ServerVariables("URL")) & "?MM_Logoutnow=1"
If (CStr(Request("MM_Logoutnow")) = "1") Then
  Session.Contents.Remove("MM_Username")
  Session.Contents.Remove("MM_UserAuthorization")
  MM_logoutRedirectPage = "../extras/index.asp"
  ' redirect with URL parameters (remove the "MM_Logoutnow" query param).
  if (MM_logoutRedirectPage = "../extras/%22)%20Then%20MM_logoutRedirectPage%20=%20CStr(Request.ServerVariables(%22URL"))
  If (InStr(1, UC_redirectPage, "?", vbTextCompare) = 0 And Request.QueryString <> "") Then
    MM_newQS = "?"
    For Each Item In Request.QueryString
      If (Item <> "MM_Logoutnow") Then
        If (Len(MM_newQS) > 1) Then MM_newQS = MM_newQS & "&"
        MM_newQS = MM_newQS & Item & "=" & Server.URLencode(Request.QueryString(Item))
      End If
    Next
    if (Len(MM_newQS) > 1) Then MM_logoutRedirectPage = MM_logoutRedirectPage & MM_newQS
  End If
  Response.Redirect(MM_logoutRedirectPage)
End If
%>
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
  MM_redirectLoginSuccess="/NEW/applications/SecureLoginManager/components/processlogin.asp"
  MM_redirectLoginFailed= "/NEW/applications/SecureLoginManager/components/processlogin.asp"
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
//-->
</script>
<% if Session("MM_Username") <> "" then %>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%">      
      <div align="left">You are currently Logged in</div>      </td>
    <td><div align="right"><a href="<%= MM_Logout %>">Log Out</a></div></td>
  </tr>
</table>
<%else%>
<div align="center"></div>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr> 
    <td valign="top">
      <form name="login" method="POST" action="<%=MM_LoginAction%>" onSubmit="YY_checkform('login','password','#q','0','Please provide password');return document.MM_returnValue" >
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
              <input type="submit" name="Submit" value="Login">
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;            </td>
          </tr>
        </table>
      </form>
<% end if%>
<% end if%>
<% end if%>
  <% IF (Request.Querystring("valid") = "false") then %>
        <font color="#FF0000"><b>Invalid Username
        or Password - please <a href="javascript:history.go(-1)">try again</a></b></font> <% End If %>
    </td>
  </tr>
</table>
<% End If %>
