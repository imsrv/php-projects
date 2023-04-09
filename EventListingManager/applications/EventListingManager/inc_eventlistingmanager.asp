<!--#include virtual="/Connections/eventlistingmanager.asp" -->
<%
Dim eventlist__MMColParam1
eventlist__MMColParam1 = "%"
If (Request.Form("search") <> "") Then 
  eventlist__MMColParam1 = Request.Form("search")        
End If
%>
<%
Dim eventlist__MMColParam2
eventlist__MMColParam2 = "%"
If (Request.QueryString("ItemID")  <> "") Then 
  eventlist__MMColParam2 = Request.QueryString("ItemID") 
End If
%>
<%
Dim eventlist__MMColParam3
eventlist__MMColParam3 = "%"
If (Request.Form("searchcat")  <> "") Then 
  eventlist__MMColParam3 = Request.Form("searchcat") 
End If
%>
<%
set eventlist = Server.CreateObject("ADODB.Recordset")
eventlist.ActiveConnection = MM_eventlistingmanager_STRING
eventlist.Source = "SELECT tblEventListings.*, tblEventCategory.CategoryDesc, tblEventCategory.CategoryName  FROM tblEventCategory INNER JOIN tblEventListings ON tblEventCategory.CategoryID = tblEventListings.CategoryID  WHERE Activated = 'True' AND tblEventCategory.CategoryName Like '" + Replace(eventlist__MMColParam3, "'", "''") + "'  AND tblEventListings.ItemID Like '" + Replace(eventlist__MMColParam2, "'", "''") + "' AND (tblEventListings.ItemDesc Like '%" + Replace(eventlist__MMColParam1, "'", "''") + "%' OR tblEventListings.ItemName Like '%" + Replace(eventlist__MMColParam1, "'", "''") + "%' OR tblEventListings.EventLocation Like '%" + Replace(eventlist__MMColParam1, "'", "''") + "%' )   ORDER BY EventStartDate"
eventlist.CursorType = 0
eventlist.CursorLocation = 2
eventlist.LockType = 3
eventlist.Open()
eventlist_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_eventlistingmanager_STRING
Category.Source = "SELECT tblEventCategory.CategoryID, tblEventCategory.CategoryName  FROM tblEventListings INNER JOIN tblEventCategory ON tblEventListings.CategoryID = tblEventCategory.CategoryID  GROUP BY tblEventCategory.CategoryID, tblEventCategory.CategoryName"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim Repeat_eventlist__numRows
Dim Repeat_eventlist__index

Repeat_eventlist__numRows = -1
Repeat_eventlist__index = 0
eventlist_numRows = eventlist_numRows + Repeat_eventlist__numRows
%>
<%
dim done
done = request.form("done")
if done = "" then
done = "No"
Else
if request.form("done") = "Yes" then

'sets variables
dim email, sendmail
email = request.form("email")

Set sendmail = Server.CreateObject("CDONTS.NewMail")
'put the webmaster address here
sendmail.From = "info@" & Request.ServerVariables("SERVER_NAME")
'The mail is sent to the address entered in the previous page.
sendmail.To = email
'Enter the subject of your mail here
sendmail.Subject = "Check out this website"
'send a specific page or send a site url
dim url
url = Request.ServerVariables("HTTP_REFERER")
'url = ""

'This is the content of thr message.
sendmail.Body = "Site recommendation from a friend!" & _
vbCrlf & vbCrlf & "A friend has sent you this email and thought you would should check out this event." & _
vbCrlf & url & vbCrlf

'this sets mail priority.... 0=low 1=normal 2=high
sendmail.Importance = 1
sendmail.MailFormat = 0
sendmail.Send 'Send the email!

End if
End if
%>
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
<html>
<head>
<title>Event Listing Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function printPage() { print(document); }

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
<link href="../../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<% If Not Request.QueryString("ItemID")<> "" Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="24" class="tableborder">
  <tr> 
    <td height="24" width="50%" valign="baseline">
		<form action="<%=Request.ServerVariables("URL")%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>" method="post" name="form2" id="form2">  
		  <div align="center">Search by Category <select name="searchcat" id="searchcat" >
		    <option selected value="%" <%If (Not isNull(Request.Form("searchcat"))) Then If ("%" = CStr(Request.Form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show All</option>
		    <%
While (NOT Category.EOF)
%>
		    <option value="<%=(Category.Fields.Item("CategoryName").Value)%>" <%If (Not isNull(Request.Form("searchcat"))) Then If (CStr(Category.Fields.Item("CategoryName").Value) = CStr(Request.Form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%></option>
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
                <input name="submit2" type="submit" value="Go">
          </div>
	  </form>
    </td>
    <td height="24" width="50%" valign="baseline"> 
      <form name="form" method="post" action="<%=Request.ServerVariables("URL")%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>">
        <div align="center">Search by Keyword 
          <input name="search" type="text" id="search">
          <input type="submit" value="Go" name="submit">
        </div>
      </form>
    </td>
  </tr>
</table>
<br>
<% end if %>
<% If eventlist.EOF And eventlist.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">No Records Found.....Please Try Again</div>
    </td>
  </tr>
</table>
<% End If ' end eventlist.EOF And eventlist.BOF %>
<% If Not eventlist.EOF Or Not eventlist.BOF Then %>
<% 
While ((Repeat_eventlist__numRows <> 0) AND (NOT eventlist.EOF)) 
%>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <tr valign="top" class="tableheader">
    <td colspan="3">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="54%"><strong><a name="ID<%=(eventlist.Fields.Item("ItemID").Value)%>"></a>&nbsp;<font color="#CC0000"><%=(eventlist.Fields.Item("CategoryName").Value)%></font></strong><font color="#CC0000">&nbsp; </font></td>
        <td width="46%"><div align="right"><a href="javascript:history.go(-1);">
            <% If Request.QueryString("ItemID")<> "" Then %>
  Go back</a>&nbsp;&nbsp;|&nbsp;&nbsp;
  <input name="button2" type=button onClick="javascript:printPage();" value="Print">
&nbsp;&nbsp;
  <%end if%>
        </div></td>
      </tr>
    </table>
	  <div align="right">
      <a href="javascript:history.go(-1);">		</a></div>
    </td>
  </tr>
  <tr>
    <td width="100" height="34" valign="top" class="tableheader">
      <div align="right">Event ID# <%=(eventlist.Fields.Item("ItemID").Value)%>: </div>
    </td>
    <td width="702" valign="top"><strong><%=(eventlist.Fields.Item("ItemName").Value)%></strong>&nbsp;&nbsp;
            <% If Not Request.QueryString("ItemID")<> "" Then %>
            <a href="<%=request.servervariables("URL")%>?ItemID=<%=(eventlist.Fields.Item("ItemID").Value)%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>">Show
            Details</a>
            <%else%>
      <a href="<%=request.servervariables("URL")%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>">Show
      all Events</a>
            <%end if%>
    </td>
    <td width="160" rowspan="17" valign="top"><div align="right">
        <!-- Check to see if File is on server -->
        <div align="right">
                   <% If eventlist.Fields.Item("ImageFileA").Value <> "" Then %>
          <% If Request.QueryString("ItemID")<> "" Then %>
          <img src="images/<%=(eventlist.Fields.Item("ImageFileA").Value)%>" width="100">
          <%else%>
          <img src="images/<%=(eventlist.Fields.Item("ImageFileA").Value)%>" width="50">
          <%End If%>
          <%End If%>
          <br><br>
          <% If eventlist.Fields.Item("ImageFileB").Value <> "" Then %>
          <% If Request.QueryString("ItemID")<> "" Then %>
          <img src="images/<%=(eventlist.Fields.Item("ImageFileB").Value)%>" width="100">
          <%else%>
          <img src="images/<%=(eventlist.Fields.Item("ImageFileB").Value)%>" width="50">
          <%End If%>
          <%End If%>
        </div>
        </div>
    </td>
  </tr>
  <% If eventlist.Fields.Item("ItemDescShort").Value <> "" Then %>
  <tr>
    <td height="20" valign="top" class="tableheader"><div align="right">Description:</div>
    </td>
    <td valign="top"><%=Replace(eventlist.Fields.Item("ItemDescShort").Value,Chr(13),"<BR>")%> </td>
  </tr>
  <%end if%>
  <% If eventlist.Fields.Item("EventLocation").Value <> "" Then %>
  <tr>
    <td valign="top" class="tableheader"><div align="right">Location:</div>
    </td>
    <td valign="top"><%=Replace(eventlist.Fields.Item("EventLocation").Value,Chr(13),"<BR>")%></td>
  </tr>
  <%end if%>
  <% If eventlist.Fields.Item("ItemPrice").Value <> "" Then %>
  <tr>
    <td height="20" valign="top" class="tableheader"><div align="right">Price:</div>
    </td>
    <td valign="top"><%= FormatCurrency((eventlist.Fields.Item("ItemPrice").Value), -1, -2, -2, -2) %> / <%=(eventlist.Fields.Item("UnitOfMeasure").Value)%></td>
  </tr>
  <%End If%>
  <% If eventlist.Fields.Item("EventStartDate").Value <> "" Then %>
  <tr>
    <td valign="top" class="tableheader"><div align="right">Date: </div></td>
	<td valign="top" ><%= DoDateTime((eventlist.Fields.Item("EventStartDate").Value), 1, 4105) %>
      <% If eventlist.Fields.Item("EventEndDate").Value <> "" Then %>
- <%= DoDateTime((eventlist.Fields.Item("EventEndDate").Value), 1, 4105) %>
<%End If%>
</td>
  </tr>
  <%end if%>
<% If Request.QueryString("ItemID")<> "" Then %>  
<% If eventlist.Fields.Item("ItemDesc").Value <> "" Then %>
  <tr>
    <td width="100" valign="top" class="tableheader"><div align="right">Full
          Description:</div>
    </td>
    <td valign="top"><%=Replace(eventlist.Fields.Item("ItemDesc").Value,Chr(13),"<BR>")%></td>
  </tr>
  <%End If%>
  <% If eventlist.Fields.Item("EventLocation").Value <> "" Then %>
  <tr>
    <td width="100" valign="top" class="tableheader"><div align="right">Location:</div>
    </td>
    <td valign="top"><%=Replace(eventlist.Fields.Item("EventLocation").Value,Chr(13),"<BR>")%></td>
  </tr>
  <%End If%>
  <% If eventlist.Fields.Item("LocationMap").Value <> "" Then %>
  <tr>
    <td width="100" valign="top" class="tableheader"><div align="right">Link
          to Map:</div>
    </td>
    <td valign="top"><a href="<%= eventlist.Fields.Item("LocationMap").Value%>" target="_blank">SEE
        MAP</a></td>
  </tr>
  <%End If%>
  <% If eventlist.Fields.Item("EventStartTime").Value <> "" Then %>
  <tr>
    <td width="100" valign="top" class="tableheader"><div align="right">Time:</div>
    </td>
    <td valign="top"><%=(eventlist.Fields.Item("EventStartTime").Value)%>
        <% If eventlist.Fields.Item("EventEndTime").Value <> "" Then %>
      - <%=(eventlist.Fields.Item("EventEndTime").Value)%>
      <%End If%>
    </td>
  </tr>
  <%End If%>
  <% If eventlist.Fields.Item("EventPresenter").Value <> "" Then %>
  <tr>
    <td width="100" valign="top" class="tableheader"><div align="right">Presenter: </div>
    </td>
    <td valign="top"><%=(eventlist.Fields.Item("EventPresenter").Value)%></td>
  </tr>
  <% End If%>
  <% If eventlist.Fields.Item("ItemPrice").Value <> "" Then %>
  <tr>
    <td width="100" valign="top" class="tableheader"><div align="right">Price: </div>
    </td>
    <td valign="top"><%= FormatCurrency((eventlist.Fields.Item("ItemPrice").Value), -1, -2, -2, -2) %> / <%=(eventlist.Fields.Item("UnitOfMeasure").Value)%></td>
  </tr>
  <%End If%>
  <% If eventlist.Fields.Item("Feature1").Value <> "" Then %>
  <tr>
    <td width="100" valign="top" class="tableheader"><div align="right">Feature
          1: </div>
    </td>
    <td valign="top"><%=Replace(eventlist.Fields.Item("Feature1").Value,Chr(13),"<BR>")%></td>
  </tr>
  <% End If%>
  <% If eventlist.Fields.Item("Feature2").Value <> "" Then %>
  <tr>
    <td width="100" valign="top" class="tableheader"><div align="right">Feature
          2: </div>
    </td>
    <td valign="top"><%=Replace(eventlist.Fields.Item("Feature2").Value,Chr(13),"<BR>")%></td>
  </tr>
  <% End If%>
  <% If eventlist.Fields.Item("Feature3").Value <> "" Then %>
  <tr>
    <td width="100" valign="top" class="tableheader"><div align="right">Feature
          3: </div>
    </td>
    <td valign="top"><%=Replace(eventlist.Fields.Item("Feature3").Value,Chr(13),"<BR>")%></td>
  </tr>
  <% End If%>
  <% If eventlist.Fields.Item("Feature4").Value <> "" Then %>
  <tr>
    <td width="100" valign="top" class="tableheader"><div align="right">Feature
          4: </div>
    </td>
    <td valign="top"><%=Replace(eventlist.Fields.Item("Feature4").Value,Chr(13),"<BR>")%></td>
  </tr>
  <% End If%>
  <% If eventlist.Fields.Item("Feature5").Value <> "" Then %>
  <tr>
    <td width="100" height="9" valign="top" class="tableheader"><div align="right">Feature
          5: </div>
    </td>
    <td valign="top"><%=Replace(eventlist.Fields.Item("Feature5").Value,Chr(13),"<BR>")%></td>
  </tr>
      <% End If%>
 <tr valign="middle">
    <td height="27" colspan="3" class="tableheader">
            <form action="" method="post" onSubmit="MM_validateForm('email','','RisEmail');return document.MM_returnValue">
              <div align="right">
                <% If Request.Form("done") = "Yes" Then %>
                <font color="#FF0000"><strong>Message Sent Successfuly to <%= request.form("email")%></strong></font>
                <% End if%>
      &nbsp;&nbsp; 
                Tell a Friend about this Event &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="email" type="text" value="Enter Email Address" size="20" maxlength="50">
                <input type="submit" name="submit3" value="Send Email">
                <input type="hidden" name="done" value="Yes">
              </div>
            </form>
    </td>
  </tr>
  <%end if%>
</table>
<br>
<% 
  Repeat_eventlist__index=Repeat_eventlist__index+1
  Repeat_eventlist__numRows=Repeat_eventlist__numRows-1
  eventlist.MoveNext()
Wend
%>
<% End If ' end Not eventlist.EOF Or NOT eventlist.BOF %>
</body>
</html>
<%
eventlist.Close()
Set eventlist = Nothing
%>
<%
Category.Close()
Set Category = Nothing
%>
