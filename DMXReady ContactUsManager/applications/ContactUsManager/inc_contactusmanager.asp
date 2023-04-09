<!--#include virtual="/Connections/contactusmanager.asp" -->
<%
Dim contactus__value1
contactus__value1 = "%"
If (Request.Form("ContactID") <> "") Then 
  contactus__value1 = Request.Form("ContactID")
End If
%>
<%
set contactus = Server.CreateObject("ADODB.Recordset")
contactus.ActiveConnection = MM_contactusmanager_STRING
contactus.Source = "SELECT tblContactUs.*, tblContactUsCategory.CategoryName  FROM tblContactUs INNER JOIN tblContactUsCategory ON tblContactUs.CategoryID = tblContactUsCategory.CategoryID  WHERE tblContactUs.Activated = 'True' AND ContactID LIKE '" + Replace(contactus__value1, "'", "''") + "'"
contactus.CursorType = 0
contactus.CursorLocation = 2
contactus.LockType = 3
contactus.Open()
contactus_numRows = 0
%>
<%
if request.form("done") = "Yes" then
' CDO Form Mailer Created by Robert Paddock (Robp) 26/01/2001 ver 1.0
' Sorting functionality added by Simon Collyer 08/05/2001 ver 1.1
 'The header/footer for the email
 Header = (contactus.Fields.Item("MessageHeaderAdmin").Value)
 Footer = (contactus.Fields.Item("MessageFooterAdmin").Value)
 ' read all the form elements and place them in the variable mailBody
    Dim mailBody
    mailBody = Header & vbCrLf & vbCrLf
    mailBody = mailBody & "Question submitted at " & Now() & vbCrLf & vbCrLf
    If Request.Form("SortOrder") <> "" Then 'Need to sort output
	Dim arrSortOrder
	arrSortOrder = Split(Request.Form("SortOrder"),"|")
	  For each FormElement in arrSortOrder
	  mailBody = mailBody & FormElement & ": " & Request.Form(FormElement) & vbCrLf 
	  Next
    Else 'No sorting required
	Dim form_element 
	  For Each FormElement in Request.Form
  	  mailBody = mailBody & FormElement & ": " & Request.Form(FormElement) & vbCrLf 
	  Next
    End If
    mailBody = mailBody & vbCrLf & Footer
    'Create the mail object and send the mail
	Set objMailAdmin = Server.CreateObject("CDONTS.NewMail")
	objMailAdmin.From = Request.Form("Email")
	objMailAdmin.To = (contactus.Fields.Item("EmailAddress").Value)
	objMailAdmin.CC = ""
	objMailAdmin.BCC = ""
	objMailAdmin.Subject = (contactus.Fields.Item("MessageSubjectAdmin").Value)
	objMailAdmin.Body = "Message Sent To: " & contactus.Fields.Item("FirstName").Value  & " " & contactus.Fields.Item("LastName").Value & vbCrLf _
	& vbCrLf _
	& mailBody 
	objMailAdmin.Send()
Set objMailAdmin = Nothing
    'Create the mail object and send Confirmation Email
	Set objMailClient = Server.CreateObject("CDONTS.NewMail")
	objMailClient.From = (contactus.Fields.Item("EmailAddress").Value)
	objMailClient.To = Request.Form("Email")
	objMailClient.CC = ""
	objMailClient.BCC = ""
	objMailClient.Subject = (contactus.Fields.Item("MessageSubjectVisitor").Value)
	objMailClient.Body = "Thank you " & Request.Form("Name") & ", " & vbCrLf _
	& vbCrLf _
	& contactus.Fields.Item("MessageBodyVisitor").Value & vbCrLf _
    & vbCrLf _
    & vbCrLf _
	& contactus.Fields.Item("FirstName").Value  & " " & contactus.Fields.Item("LastName").Value & vbCrLf _
	& contactus.Fields.Item("MessageFooterVisitorLine1").Value & vbCrLf _
	& contactus.Fields.Item("MessageFooterVisitorLine2").Value & vbCrLf _
	& contactus.Fields.Item("MessageFooterVisitorLine3").Value & vbCrLf
	objMailClient.Send()
Set objMailClient = Nothing

    'Send them to the page specified if requested
Dim rp_redirect
      If Request.QueryString <> "" Then
      rp_redirect = Request.ServerVariables("HTTP_REFERER") & "&Name=" & Request.Form("Name") & "&valid=Success"
    Else
      rp_redirect = Request.ServerVariables("HTTP_REFERER") & "?Name=" & Request.Form("Name") & "&valid=Success"
    End If
	Response.Redirect rp_redirect
End If 
%>
<html>
<head>
<title>Contact Us Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../styles.css" rel="stylesheet" type="text/css">
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
<body>
<% IF (Request.Querystring("valid") = "Success") then %>
<table width="100%" border="0" cellpadding="10" cellspacing="10" class="tableborder">
  <tr> 
    <td valign="top"> 
      <blockquote>
        <p><span class="head1"><font size="4">Thank you</font> for your comments <%= Request.QueryString("Name") %>. </span>Your feedback is greatly appreciated.</p>
        <p><a href="javascript:history.go(-1);">Go
        back</a></p>
      </blockquote>      <p>&nbsp;</p>      
      <h3>&nbsp;</h3>
    </td>
  </tr>
</table>
<% End If %>
<% If Not (Request.Querystring("valid") = "Success") then %>
<!--#include file="extras/inc_contactlist.asp" -->

<br>
<table width="100%" border="0" cellspacing="0" class="tableborder">
  <tr> 
    <td valign="top"> 
      <form action="" method=post name="contactus" onSubmit="YY_checkform('contactus','Name','#q','0','Field \'Name\' is not valid.','Email','#S','2','Field \'Email\' is not valid.','Comments','5','1','Field \'Comments\' is not valid.');return document.MM_returnValue">
        <table width="100%" height="321" border="0" align="center" cellpadding="5" cellspacing="0" class="row2">
          <tr> 
            <td colspan="3" class="tableside"><strong>For
                your convenience you can send a message directly to a contact
            using the form below</strong></td>
          </tr>
          <tr> 
            <td width="25%" height="28" class="tableside"> Send Message
              To:</td>
            <td height="28" colspan="2" width="75%" class="tablebody"> <font color="#FFFFFF"><b> 
              <select name="ContactID" id="ContactID">
              <%
While (NOT contactus.EOF)
%>
              <option value="<%=(contactus.Fields.Item("ContactID").Value)%>"><%=(contactus.Fields.Item("CategoryName").Value)%> | <%=(contactus.Fields.Item("FirstName").Value)%>&nbsp;<%=(contactus.Fields.Item("LastName").Value)%></option>
                <%
  contactus.MoveNext()
Wend
If (contactus.CursorType > 0) Then
  contactus.MoveFirst
Else
  contactus.Requery
End If
%>
              </select>
            </b></font></td>
          </tr>
          <tr> 
            <td width="25%" height="28" class="tableside"> Your Organization Name:</td>
            <td height="28" colspan="2" width="75%" class="tablebody"> <font color="#FFFFFF"><b> 
              <input name="Company" type="text" size=30 maxlength=40>
              </b></font></td>
          </tr>
          <tr> 
            <td width="25%" height="28" class="tableside"> <font class="bodytext2">Your 
              Full Name:</font><b><font class="bodytext2"> </font></b></td>
            <td height="28" colspan="2" width="75%" class="tablebody"> <font color="#FFFFFF"><b> 
              <input name="Name" type="text" size=30 maxlength=40>
              </b></font></td>
          </tr>
          <tr> 
            <td width="25%" class="tableside"> Your Telephone Number:</td>
            <td colspan="2" width="75%" class="tablebody"> <font color="#FFFFFF"><b> 
              <input name="Telephone" type="text" size=30 maxlength=40>
              </b></font></td>
          </tr>
          <tr> 
            <td width="25%" height="2" class="tableside"> Your Email Address:</td>
            <td colspan="2" height="2" width="75%" class="tablebody"> <font color="#FFFFFF"><b> 
              <input name="Email" type="text" size=30 maxlength=80>
            </b></font></td>
          </tr>
          <tr> 
            <td width="25%" class="tableside"><b><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="submit" name="Submit" value="Send Message" class="cCool">
              <input name="done" type="hidden" id="done" value="Yes">
</font></b></td>
            <td colspan="2" width="75%" class="tablebody"><b><font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="Comments" cols="40" rows="5" class="cCool">  Type your Questions or Comments HERE</textarea>
              </font><font color="#FFFFFF"></font></b></td>
          </tr>
          <tr valign="middle"> 
            <td colspan="3" class="tableside" height="2">&nbsp;</td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
</body>
</html>
<% End If %>
<%
contactus.Close()
%>

