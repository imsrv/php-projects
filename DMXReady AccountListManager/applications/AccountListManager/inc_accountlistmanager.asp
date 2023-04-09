<!--#include virtual="/Connections/accountlistmanager.asp" -->
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_accountlistmanager_STRING
Category.Source = "SELECT tblAM_AccountsCategory.CategoryValue, tblAM_AccountsCategory.CategoryLabel  FROM tblAM_Accounts LEFT JOIN tblAM_AccountsCategory ON tblAM_Accounts.AccountCategoryID = tblAM_AccountsCategory.CategoryID  GROUP BY tblAM_AccountsCategory.CategoryValue,tblAM_AccountsCategory.CategoryLabel HAVING (((tblAM_AccountsCategory.CategoryValue) Is Not Null))"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim List_Accounts__value1
List_Accounts__value1 = "%"
If (Request.QueryString("AccountID") <> "") Then 
  List_Accounts__value1 = Request.QueryString("AccountID")
End If
%>
<%
Dim List_Accounts__value2
List_Accounts__value2 = "%"
If (Request.Form("searchcat") <> "") Then 
  List_Accounts__value2 = Request.Form("searchcat")
End If
%>
<%
Dim List_Accounts__value3
List_Accounts__value3 = "%"
If (Request.Form("search") <> "") Then 
  List_Accounts__value3 = Request.Form("search")
End If
%>
<%
Dim List_Accounts__MMColParam2
List_Accounts__MMColParam2 = "%"
If (Request.QueryString("search")   <> "") Then 
  List_Accounts__MMColParam2 = Request.QueryString("search")  
End If
%>
<%
Dim List_Accounts
Dim List_Accounts_numRows

Set List_Accounts = Server.CreateObject("ADODB.Recordset")
List_Accounts.ActiveConnection = MM_accountlistmanager_STRING
List_Accounts.Source = "SELECT tblAM_Accounts.*, tblAM_AccountsCategory.CategoryValue, tblAM_AccountsCategory.ParentCategoryID, tblAM_AccountsCategory.CategoryDesc, tblAM_AccountsCategory.CategoryLabel  FROM tblAM_Accounts LEFT JOIN tblAM_AccountsCategory ON tblAM_Accounts.AccountCategoryID = tblAM_AccountsCategory.CategoryID  WHERE tblAM_Accounts.AccountActivated = 'True' AND tblAM_Accounts.AccountID LIKE '" + Replace(List_Accounts__value1, "'", "''") + "' AND tblAM_AccountsCategory.CategoryValue LIKE '" + Replace(List_Accounts__value2, "'", "''") + "' AND (tblAM_Accounts.AccountName1 LIKE '%" + Replace(List_Accounts__value3, "'", "''") + "%' OR tblAM_Accounts.AccountName2 LIKE '%" + Replace(List_Accounts__value3, "'", "''") + "%') AND (tblAM_Accounts.AccountLookuptxt1 Like '%" + Replace(List_Accounts__MMColParam2, "'", "''") + "%' OR  tblAM_Accounts.AccountLookuptxt2 Like '%" + Replace(List_Accounts__MMColParam2, "'", "''") + "%' OR  tblAM_Accounts.AccountLookuptxt3 Like '%" + Replace(List_Accounts__MMColParam2, "'", "''") + "%' OR  tblAM_Accounts.AccountLookuptxt4 Like '%" + Replace(List_Accounts__MMColParam2, "'", "''") + "%' OR  tblAM_Accounts.AccountLookuptxt5 Like '%" + Replace(List_Accounts__MMColParam2, "'", "''") + "%' )  ORDER BY tblAM_Accounts.AccountCategoryID, AccountName1"
List_Accounts.CursorType = 0
List_Accounts.CursorLocation = 2
List_Accounts.LockType = 1
List_Accounts.Open()

List_Accounts_numRows = 0
%>
<%
Dim RepeatAccountList__numRows
Dim RepeatAccountList__index

RepeatAccountList__numRows = -1
RepeatAccountList__index = 0
List_Accounts_numRows = List_Accounts_numRows + RepeatAccountList__numRows
%>
<% Dim TFM_nestcataccountlist, lastTFM_nestcataccountlist%>
<link href="../../styles.css" rel="stylesheet" type="text/css">
      <form name="form1" method="post" action="<%=Request.ServerVariables("URL")%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("vid")<> "" Then %>&vid=<%=request.querystring("vid")%><%end if%>">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableborder" height="23">
  <tr> 
    <td height="21">        <div align="left">Search by <%=(Category.Fields.Item("CategoryLabel").Value)%>
          <select name="searchcat" id="searchcat">
            <option value="%" <%If (Not isNull(Request.Form("searchcat"))) Then If ("%" = CStr(Request.Form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show All</option>
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
    <td height="21"> 
        <div align="center">Search by Keyword 
          <input name="search" type="text" id="search">
          <input type="submit" value="Go" name="submit">
        </div>

    </td>
  </tr>
</table>
      </form>
<% 
While ((RepeatAccountList__numRows <> 0) AND (NOT List_Accounts.EOF)) 
%>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" valign="middle">
      <% TFM_nestcataccountlist = List_Accounts.Fields.Item("CategoryValue").Value
If lastTFM_nestcataccountlist <> TFM_nestcataccountlist Then 
	lastTFM_nestcataccountlist = TFM_nestcataccountlist %>
      <br>
      <strong><%=(List_Accounts.Fields.Item("CategoryValue").Value)%></strong>
      <%End If 'End Basic-UltraDev Simulated Nested Repeat %>
      <% If Request.QueryString("AccountID") <> "" Then %>
      | <a href="<%=request.servervariables("URL")%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("vid")<> "" Then %>&vid=<%=request.querystring("vid")%><%end if%>">Show
          All</a>
      <%end if%>
    </td>
  </tr>
  <tr>
    <td width="1%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td width="99%" height="15"><li><a href="<%=request.servervariables("URL")%>?AccountID=<%=(List_Accounts.Fields.Item("AccountID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("vid")<> "" Then %>&vid=<%=request.querystring("vid")%><%end if%>"><%=(List_Accounts.Fields.Item("AccountName1").Value)%></a> </li>
    </td>
  </tr>
</table>
<% If Request.QueryString("AccountID") <> "" Then %>
<br>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <% if List_Accounts.Fields.Item("AccountImageFile").Value <> "" then %>
    <td width="15%" rowspan="8" valign="top">      <% if List_Accounts.Fields.Item("AccountImageFile").Value <> "" then %>
        <img src="/applications/AccountListManager/images/<%=(List_Accounts.Fields.Item("AccountImageFile").Value)%>" hspace="20">
        <% end if%>
</td><% end if%>
    <td colspan="2">
      <% If List_Accounts.Fields.Item("AccountName1").Value <> "" Then %>
      <strong><%=(List_Accounts.Fields.Item("AccountName1").Value)%></strong><br>
      <%end if%>
      <% If List_Accounts.Fields.Item("AccountName2").Value <> "" Then %>
      <%=(List_Accounts.Fields.Item("AccountName2").Value)%><br>
      <%end if%>
      <% If List_Accounts.Fields.Item("AccountAddress1").Value <> "" Then %>
      <%=(List_Accounts.Fields.Item("AccountAddress1").Value)%>
      <%end if%>
      <% If List_Accounts.Fields.Item("AccountAddress2").Value <> "" Then %>
&nbsp; <%=(List_Accounts.Fields.Item("AccountAddress2").Value)%><br>
<%else%>
<br>
<%end if%>
<% If List_Accounts.Fields.Item("AccountCity").Value <> "" Then %>
<%=(List_Accounts.Fields.Item("AccountCity").Value)%>
<%end if%>
<% If List_Accounts.Fields.Item("AccountState").Value <> "" Then %>
&nbsp; <%=(List_Accounts.Fields.Item("AccountState").Value)%><br>
<%end if%>
<% If List_Accounts.Fields.Item("AccountPostalCode").Value <> "" Then %>
<%=(List_Accounts.Fields.Item("AccountPostalCode").Value)%>
<%end if%>
<% If List_Accounts.Fields.Item("AccountCountry").Value <> "" Then %>
&nbsp; <%=(List_Accounts.Fields.Item("AccountCountry").Value)%><br>
<%end if%>
    </td>
  </tr>
    <% If List_Accounts.Fields.Item("AccountPhone").Value <> "" Then %>
  <tr>
    <td width="15%">Phone:</td>
    <td width="85%"><%=(List_Accounts.Fields.Item("AccountPhone").Value)%></td>
  </tr>
  <%end if%>
  <% If List_Accounts.Fields.Item("AccountCellPhone").Value <> "" Then %>
  <tr>
    <td>Phone2:</td>
    <td><%=(List_Accounts.Fields.Item("AccountCellPhone").Value)%> </td>
  </tr>
  <%end if%>
  <% If List_Accounts.Fields.Item("AccountFax").Value <> "" Then %>
  <tr>
    <td>Fax:</td>
    <td><%=(List_Accounts.Fields.Item("AccountFax").Value)%> </td>
  </tr>
  <%end if%>
  <% If List_Accounts.Fields.Item("AccountEmailAddress").Value <> "" Then %>
  <tr>
    <td>General Email Address:</td>
    <td><a href="mailto:%20<%=(List_Accounts.Fields.Item("AccountEmailAddress").Value)%>"><%=(List_Accounts.Fields.Item("AccountEmailAddress").Value)%></a></td>
  </tr>
  <%end if%>
  <% If List_Accounts.Fields.Item("AccountWebsiteURL").Value <> "" Then %>
  <tr>
    <td>Website URL:</td>
    <td><a href="http://<%=(List_Accounts.Fields.Item("AccountWebsiteURL").Value)%>" target="_blank"><%=(List_Accounts.Fields.Item("AccountWebsiteURL").Value)%></a></td>
  </tr>
  <%end if%>
  <% If List_Accounts.Fields.Item("AccountMap").Value <> "" Then %>
  <tr>
    <td>Map</td>
    <td><a href="<%=(List_Accounts.Fields.Item("AccountMap").Value)%>" target="_blank">View Map</a></td>
  </tr>
  <%end if%>
  <% If List_Accounts.Fields.Item("AccountProfile").Value <> "" Then %>
  <tr>
    <td>Profile:</td>
    <td><%=(List_Accounts.Fields.Item("AccountProfile").Value)%></td>
  </tr>
  <%end if%>
  <% If List_Accounts.Fields.Item("AccountImageFile").Value <> "" Then %>
  <%end if%>
</table>
<a href="javascript:history.go(-1);">Go Back</a>
<%end if%>
<% 
  RepeatAccountList__index=RepeatAccountList__index+1
  RepeatAccountList__numRows=RepeatAccountList__numRows-1
  List_Accounts.MoveNext()
Wend
%>

<div align="center">
<% If List_Accounts.EOF And List_Accounts.BOF Then %>
<p>Sorry....No Records Found
  </p>
  <% End If ' end List_Accounts.EOF And List_Accounts.BOF %>
</div>
<hr size="1" noshade>
<%
List_Accounts.Close()
Set List_Accounts = Nothing
%>
<%
Category.Close()
Set Category = Nothing
%>
