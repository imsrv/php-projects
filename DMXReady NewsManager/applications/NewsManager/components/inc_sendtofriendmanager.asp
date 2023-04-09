<%
dim done
done = request.form("done")
if done = "" then
done = "No"
Else
if request.form("done") = "Yes" then
'sets variables
dim sendtoemail, sendtoname, sentfromname, sentfromemail, messagesubject, messagebody
sendtoemail = request.form("sendtoemail")
sendtoname = request.form("sendtoname")
sentfromname = request.form("sentfromname")
sentfromemail = request.form("sentfromemail")
messagesubject = request.form("messagesubject")
messagebody = request.form("messagebody")
url = request.form("url")

Set sendmail = Server.CreateObject("CDONTS.NewMail")
sendmail.From = sentfromemail'The mail is sent to the address declared in the form variable.
sendmail.To = sendtoemail
sendmail.Subject = sendtoname & ", " & messagesubject & " sent from " & sentfromname & ", " ' The subject is set in the form variable
'This is the content of thr message.
sendmail.Body =  messagebody & _
vbCrlf & vbCrlf & "Here is the link" & _
vbCrlf & url & vbCrlf
'this sets mail priority.... 0=low 1=normal 2=high
sendmail.Importance = 1
sendmail.MailFormat = 0
sendmail.Send 'Send the email!

End if
End if
%>
<link href="../../../styles.css" rel="stylesheet" type="text/css">
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
<% If NOT Request.QueryString("emailform") = "yes" Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> <div align="right">
      <% Dim SendToFriendManager
strapp = "/applications/SendToFriendManager/inc_sendtofriendmanager.asp"
Set SendToFriendManager = CreateObject("Scripting.FileSystemObject")
If SendToFriendManager.FileExists(Server.MapPath(strapp)) then
%>
      <%
url = "http://www." & request.servervariables("HTTP_HOST") & request.servervariables("URL") & "?" & request.servervariables("QUERY_STRING")
%>	
<a href="javascript:;"  onClick="MM_openBrWindow('../../SendToFriendManager/inc_sendtofriendmanager.asp?emailform=yes&amp;url=<%=url%>','SendToFriend','width=500,height=350')">SEND TO FRIEND</a>
<%end if%></div></td>
  </tr>
</table>
<%else%>
<p align="center"><strong><font size="5">Automatically email page to friend </font></strong></p>
<font size="3">
<% If Request.Form("done") = "Yes" Then %>
</font>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><p align="center"><font size="3">    </font></p>
      <p align="center"><font size="3"><font color="#FF0000"><strong>Message Sent Successfuly
              to </strong></font><font size="3"><font color="#FF0000"><strong><%= request.form("sendtoemail")%></strong></font></font></font></p>
      <p align="center"><font size="3"><font color="#FF0000"><strong>
        <input name="button" type=button onClick="javascript:self.close();" value="Close Window">
        </strong></font>
            
      </font>&nbsp;&nbsp;</p></td>
  </tr>
</table>
<% else%>
<form action="" method="post" name="SendToFriend" id="SendToFriend" onSubmit="YY_checkform('SendToFriend','sendtoemail','#S','2','Enter recipients email address','sendtoname','#q','0','Enter recipients name','sentfromname','#q','0','Enter senders name','sentfromemail','#S','2','Enter senders email address','messagesubject','#q','0','Enter a subject');return document.MM_returnValue">
  <div align="center"></div>
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tableborder">
    <tr>
      <td width="150" height="26"><strong>Send to email address:</strong></td>
      <td><input name="sendtoemail" type="text" id="sendtoemail"> 
      Enter recipients email address</td>
    </tr>
    <tr>
      <td width="150"><strong>Send to name:</strong></td>
      <td><input name="sendtoname" type="text" id="sendtoname"> 
      Enter recipients name</td>
    </tr>
    <tr>
      <td width="150"><strong>Sent from name:</strong></td>
      <td><input name="sentfromname" type="text" id="sentfromname">
      Enter your name</td>
    </tr>
    <tr>
      <td width="150"><strong>Sent from email address:</strong></td>
      <td><input name="sentfromemail" type="text" id="sentfromemail"> 
      Enter your email address</td>
    </tr>
    <tr>
      <td width="150"><strong>Email subject:</strong></td>
      <td><input name="messagesubject" type="text" id="messagesubject" value="Check out this web page" size="40"> 
      Enter Subject</td>
    </tr>
    <tr>
      <td width="150"><strong>Email message:</strong></td>
      <td>      <textarea name="messagebody" cols="30" rows="3" id="messagebody">
A friend has sent you this email and thought you would should check out this news item.</textarea></td>
    </tr>
    <tr>
      <td colspan="2"><strong><font color="#FF0000">PAGE: </font></strong><font color="#FF0000"><a href="<%=Request.QueryString("url")%>" target="_blank"><%=Request.QueryString("url")%></a>
        <input type="hidden" name="url" value="<%=Request.QueryString("url")%>">
      </font> </td>
    </tr>
  </table>
  <p align="center">    
    <input type="submit" name="submit" value="Send Email">
    <input type="hidden" name="done" value="Yes"> 
&nbsp;&nbsp;    
<input name="button2" type=button onClick="javascript:self.close();" value="Cancel">
  </p>
</form>
  <% End if%>
 <% End if%>