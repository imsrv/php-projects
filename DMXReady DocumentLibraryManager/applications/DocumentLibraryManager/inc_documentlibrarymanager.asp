<!--#include virtual="/Connections/documentlibrarymanager.asp" -->
<%
Dim List_Library__value2
List_Library__value2 = "%"
If (Request.Form("search")     <> "") Then 
  List_Library__value2 = Request.Form("search")    
End If
%>
<%
Dim List_Library__value3
List_Library__value3 = "%"
If (Request.Form("searchcat")        <> "") Then 
  List_Library__value3 = Request.Form("searchcat")       
End If
%>
<%
set List_Library = Server.CreateObject("ADODB.Recordset")
List_Library.ActiveConnection = MM_documentlibrarymanager_STRING
List_Library.Source = "SELECT DocumentLibrary.*, DocumentLibraryCategory.CategoryName  FROM DocumentLibraryCategory INNER JOIN DocumentLibrary ON DocumentLibraryCategory.CategoryID = DocumentLibrary.CategoryID  WHERE Activated = 'True' AND CategoryName LIKE '" + Replace(List_Library__value3, "'", "''") + "' AND (ItemName LIKE '%" + Replace(List_Library__value2, "'", "''") + "%' OR ItemDesc LIKE '%" + Replace(List_Library__value2, "'", "''") + "%' OR DocumentLibraryCategory.CategoryName Like '%" + Replace(List_Library__value2, "'", "''") + "%')  ORDER BY CategoryName, ItemName, DateAdded"
List_Library.CursorType = 0
List_Library.CursorLocation = 2
List_Library.LockType = 1
List_Library.Open()
List_Library_numRows = 0
%>
<%
Dim RepeatLibrary__numRows
RepeatLibrary__numRows = 20
Dim RepeatLibrary__index
RepeatLibrary__index = 0
List_Library_numRows = List_Library_numRows + RepeatLibrary__numRows
%>
<%
'  *** Recordset Stats, Move To Record, and Go To Record: declare stats variables

Dim List_Library_total
Dim List_Library_first
Dim List_Library_last

' set the record count
List_Library_total = List_Library.RecordCount

' set the number of rows displayed on this page
If (List_Library_numRows < 0) Then
  List_Library_numRows = List_Library_total
Elseif (List_Library_numRows = 0) Then
  List_Library_numRows = 1
End If

' set the first and last displayed record
List_Library_first = 1
List_Library_last  = List_Library_first + List_Library_numRows - 1

' if we have the correct record count, check the other stats
If (List_Library_total <> -1) Then
  If (List_Library_first > List_Library_total) Then
    List_Library_first = List_Library_total
  End If
  If (List_Library_last > List_Library_total) Then
    List_Library_last = List_Library_total
  End If
  If (List_Library_numRows > List_Library_total) Then
    List_Library_numRows = List_Library_total
  End If
End If
%>
<%
' *** Recordset Stats: if we don't know the record count, manually count them

If (List_Library_total = -1) Then

  ' count the total records by iterating through the recordset
  List_Library_total=0
  While (Not List_Library.EOF)
    List_Library_total = List_Library_total + 1
    List_Library.MoveNext
  Wend

  ' reset the cursor to the beginning
  If (List_Library.CursorType > 0) Then
    List_Library.MoveFirst
  Else
    List_Library.Requery
  End If

  ' set the number of rows displayed on this page
  If (List_Library_numRows < 0 Or List_Library_numRows > List_Library_total) Then
    List_Library_numRows = List_Library_total
  End If

  ' set the first and last displayed record
  List_Library_first = 1
  List_Library_last = List_Library_first + List_Library_numRows - 1
  
  If (List_Library_first > List_Library_total) Then
    List_Library_first = List_Library_total
  End If
  If (List_Library_last > List_Library_total) Then
    List_Library_last = List_Library_total
  End If

End If
%>
<%
Dim MM_DLMparamName 
%>
<%
' *** Move To Record and Go To Record: declare variables

Dim MM_DLMrs
Dim MM_DLMrsCount
Dim MM_DLMsize
Dim MM_DLMuniqueCol
Dim MM_DLMoffset
Dim MM_DLMatTotal
Dim MM_DLMparamIsDefined

Dim MM_DLMparam
Dim MM_DLMindex

Set MM_DLMrs    = List_Library
MM_DLMrsCount   = List_Library_total
MM_DLMsize      = List_Library_numRows
MM_DLMuniqueCol = ""
MM_DLMparamName = ""
MM_DLMoffset = 0
MM_DLMatTotal = false
MM_DLMparamIsDefined = false
If (MM_DLMparamName <> "") Then
  MM_DLMparamIsDefined = (Request.QueryString(MM_DLMparamName) <> "")
End If
%>
<%
' *** Move To Record: handle 'index' or 'offset' parameter

if (Not MM_DLMparamIsDefined And MM_DLMrsCount <> 0) then

  ' use index parameter if defined, otherwise use offset parameter
  MM_DLMparam = Request.QueryString("index")
  If (MM_DLMparam = "") Then
    MM_DLMparam = Request.QueryString("offset")
  End If
  If (MM_DLMparam <> "") Then
    MM_DLMoffset = Int(MM_DLMparam)
  End If

  ' if we have a record count, check if we are past the end of the recordset
  If (MM_DLMrsCount <> -1) Then
    If (MM_DLMoffset >= MM_DLMrsCount Or MM_DLMoffset = -1) Then  ' past end or move last
      If ((MM_DLMrsCount Mod MM_DLMsize) > 0) Then         ' last page not a full repeat region
        MM_DLMoffset = MM_DLMrsCount - (MM_DLMrsCount Mod MM_DLMsize)
      Else
        MM_DLMoffset = MM_DLMrsCount - MM_DLMsize
      End If
    End If
  End If

  ' move the cursor to the selected record
  MM_DLMindex = 0
  While ((Not MM_DLMrs.EOF) And (MM_DLMindex < MM_DLMoffset Or MM_DLMoffset = -1))
    MM_DLMrs.MoveNext
    MM_DLMindex = MM_DLMindex + 1
  Wend
  If (MM_DLMrs.EOF) Then 
    MM_DLMoffset = MM_DLMindex  ' set MM_DLMoffset to the last possible record
  End If

End If
%>
<%
' *** Move To Record: if we dont know the record count, check the display range

If (MM_DLMrsCount = -1) Then

  ' walk to the end of the display range for this page
  MM_DLMindex = MM_DLMoffset
  While (Not MM_DLMrs.EOF And (MM_DLMsize < 0 Or MM_DLMindex < MM_DLMoffset + MM_DLMsize))
    MM_DLMrs.MoveNext
    MM_DLMindex = MM_DLMindex + 1
  Wend

  ' if we walked off the end of the recordset, set MM_DLMrsCount and MM_DLMsize
  If (MM_DLMrs.EOF) Then
    MM_DLMrsCount = MM_DLMindex
    If (MM_DLMsize < 0 Or MM_DLMsize > MM_DLMrsCount) Then
      MM_DLMsize = MM_DLMrsCount
    End If
  End If

  ' if we walked off the end, set the offset based on page size
  If (MM_DLMrs.EOF And Not MM_DLMparamIsDefined) Then
    If (MM_DLMoffset > MM_DLMrsCount - MM_DLMsize Or MM_DLMoffset = -1) Then
      If ((MM_DLMrsCount Mod MM_DLMsize) > 0) Then
        MM_DLMoffset = MM_DLMrsCount - (MM_DLMrsCount Mod MM_DLMsize)
      Else
        MM_DLMoffset = MM_DLMrsCount - MM_DLMsize
      End If
    End If
  End If

  ' reset the cursor to the beginning
  If (MM_DLMrs.CursorType > 0) Then
    MM_DLMrs.MoveFirst
  Else
    MM_DLMrs.Requery
  End If

  ' move the cursor to the selected record
  MM_DLMindex = 0
  While (Not MM_DLMrs.EOF And MM_DLMindex < MM_DLMoffset)
    MM_DLMrs.MoveNext
    MM_DLMindex = MM_DLMindex + 1
  Wend
End If
%>
<%
' *** Move To Record: update recordset stats

' set the first and last displayed record
List_Library_first = MM_DLMoffset + 1
List_Library_last  = MM_DLMoffset + MM_DLMsize

If (MM_DLMrsCount <> -1) Then
  If (List_Library_first > MM_DLMrsCount) Then
    List_Library_first = MM_DLMrsCount
  End If
  If (List_Library_last > MM_DLMrsCount) Then
    List_Library_last = MM_DLMrsCount
  End If
End If

' set the boolean used by hide region to check if we are on the last record
MM_DLMatTotal = (MM_DLMrsCount <> -1 And MM_DLMoffset + MM_DLMsize >= MM_DLMrsCount)
%>
<%
' *** Go To Record and Move To Record: create strings for maintaining URL and Form parameters

Dim MM_DLMkeepNone
Dim MM_DLMkeepURL
Dim MM_DLMkeepForm
Dim MM_DLMkeepBoth

Dim MM_DLMremoveList
Dim MM_DLMitem
Dim MM_DLMnextItem

' create the list of parameters which should not be maintained
MM_DLMremoveList = "&index="
If (MM_DLMparamName <> "") Then
  MM_DLMremoveList = MM_DLMremoveList & "&" & MM_DLMparamName & "="
End If

MM_DLMkeepURL=""
MM_DLMkeepForm=""
MM_DLMkeepBoth=""
MM_DLMkeepNone=""

' add the URL parameters to the MM_DLMkeepURL string
For Each MM_DLMitem In Request.QueryString
  MM_DLMnextItem = "&" & MM_DLMitem & "="
  If (InStr(1,MM_DLMremoveList,MM_DLMnextItem,1) = 0) Then
    MM_DLMkeepURL = MM_DLMkeepURL & MM_DLMnextItem & Server.URLencode(Request.QueryString(MM_DLMitem))
  End If
Next

' add the Form variables to the MM_DLMkeepForm string
For Each MM_DLMitem In Request.Form
  MM_DLMnextItem = "&" & MM_DLMitem & "="
  If (InStr(1,MM_DLMremoveList,MM_DLMnextItem,1) = 0) Then
    MM_DLMkeepForm = MM_DLMkeepForm & MM_DLMnextItem & Server.URLencode(Request.Form(MM_DLMitem))
  End If
Next

' create the Form + URL string and remove the intial '&' from each of the strings
MM_DLMkeepBoth = MM_DLMkeepURL & MM_DLMkeepForm
If (MM_DLMkeepBoth <> "") Then 
  MM_DLMkeepBoth = Right(MM_DLMkeepBoth, Len(MM_DLMkeepBoth) - 1)
End If
If (MM_DLMkeepURL <> "")  Then
  MM_DLMkeepURL  = Right(MM_DLMkeepURL, Len(MM_DLMkeepURL) - 1)
End If
If (MM_DLMkeepForm <> "") Then
  MM_DLMkeepForm = Right(MM_DLMkeepForm, Len(MM_DLMkeepForm) - 1)
End If

' a utility function used for adding additional parameters to these strings
Function MM_DLMjoinChar(firstItem)
  If (firstItem <> "") Then
    MM_DLMjoinChar = "&"
  Else
    MM_DLMjoinChar = ""
  End If
End Function
%>
<%
' *** Move To Record: set the strings for the first, last, next, and previous links

Dim MM_DLMkeepMove
Dim MM_DLMmoveParam
Dim MM_DLMmoveFirst
Dim MM_DLMmoveLast
Dim MM_DLMmoveNext
Dim MM_DLMmovePrev

Dim MM_DLMurlStr
Dim MM_DLMparamList
Dim MM_DLMparamIndex
Dim MM_DLMnextParam

MM_DLMkeepMove = MM_DLMkeepBoth
MM_DLMmoveParam = "index"

' if the page has a repeated region, remove 'offset' from the maintained parameters
If (MM_DLMsize > 1) Then
  MM_DLMmoveParam = "offset"
  If (MM_DLMkeepMove <> "") Then
    MM_DLMparamList = Split(MM_DLMkeepMove, "&")
    MM_DLMkeepMove = ""
    For MM_DLMparamIndex = 0 To UBound(MM_DLMparamList)
      MM_DLMnextParam = Left(MM_DLMparamList(MM_DLMparamIndex), InStr(MM_DLMparamList(MM_DLMparamIndex),"=") - 1)
      If (StrComp(MM_DLMnextParam,MM_DLMmoveParam,1) <> 0) Then
        MM_DLMkeepMove = MM_DLMkeepMove & "&" & MM_DLMparamList(MM_DLMparamIndex)
      End If
    Next
    If (MM_DLMkeepMove <> "") Then
      MM_DLMkeepMove = Right(MM_DLMkeepMove, Len(MM_DLMkeepMove) - 1)
    End If
  End If
End If

' set the strings for the move to links
If (MM_DLMkeepMove <> "") Then 
  MM_DLMkeepMove = MM_DLMkeepMove & "&"
End If

MM_DLMurlStr = Request.ServerVariables("URL") & "?" & MM_DLMkeepMove & MM_DLMmoveParam & "="

MM_DLMmoveFirst = MM_DLMurlStr & "0"
MM_DLMmoveLast  = MM_DLMurlStr & "-1"
MM_DLMmoveNext  = MM_DLMurlStr & CStr(MM_DLMoffset + MM_DLMsize)
If (MM_DLMoffset - MM_DLMsize < 0) Then
  MM_DLMmovePrev = MM_DLMurlStr & "0"
Else
  MM_DLMmovePrev = MM_DLMurlStr & CStr(MM_DLMoffset - MM_DLMsize)
End If
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_documentlibrarymanager_STRING
Category.Source = "SELECT DocumentLibraryCategory.CategoryName  FROM DocumentLibraryCategory INNER JOIN DocumentLibrary ON DocumentLibraryCategory.CategoryID = DocumentLibrary.CategoryID  GROUP BY DocumentLibraryCategory.CategoryName  ORDER BY CategoryName"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<html>
<head>
<title>Document Library Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableborder" height="42">
  <tr> 
    <td height="17" width="50%" valign="baseline">
	<form action="<%=Request.ServerVariables("URL")%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>" method="post" name="form2" id="form2">  
			  <div align="center">
                <% If Not Category.EOF Or Not Category.BOF Then %>
Search by Category
<select name="searchcat" id="searchcat" >
  <option selected value="%" <%If (Not isNull(Request.Form("searchcat"))) Then If ("%" = CStr(Request.Form("searchcat"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show
  All</option>
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
<input name="submit2" type="submit" value="Search">
<% End If ' end Not Category.EOF Or NOT Category.BOF %>
			  </div>
	</form>
	</td>
    <td height="17" width="50%" valign="baseline"> 
      <form name="form" method="post" action="<%=Request.ServerVariables("URL")%><%If Request.QueryString("mid") <> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>">
        <div align="center">Search by Keyword 
          <input name="search" type="text" id="search">
          <input type="submit" value="Search" name="submit">
        </div>
      </form>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr class="tableheader"> 
    <td width="12%">Category</td>
    <td width="38%">Document  Name</td>
    <td width="40%">Description</td>
    <td width="10%">Link</td>
  </tr>
  <% 
While ((RepeatLibrary__numRows <> 0) AND (NOT List_Library.EOF)) 
%><tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>"> <td width="12%" height="24"> 
      <p><%=(List_Library.Fields.Item("CategoryName").Value)%><br>
      </p>
    </td>
    <td width="38%" height="24"> 
      <p><%=(List_Library.Fields.Item("ItemName").Value)%><br>
      </p>
    </td>
    <td width="40%" height="24"> 
      <p><%=(List_Library.Fields.Item("ItemDesc").Value)%><br>
      </p>
    </td>
    <td width="10%" height="24"> 
      <p><a href="../../applications/DocumentLibraryManager/upload/<%=(List_Library.Fields.Item("ItemLink").Value)%>" target="_blank">View/Download</a><br>
      </p>
    </td>
  <% 
  RepeatLibrary__index=RepeatLibrary__index+1
  RepeatLibrary__numRows=RepeatLibrary__numRows-1
  List_Library.MoveNext()
Wend
%>
  </tr>
</table>

<hr size="1" noshade>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center">
      <% If MM_DLMoffset <> 0 Then %>
      <a href="<%=MM_DLMmoveFirst%>">First</a>
      <% End If ' end MM_DLMoffset <> 0 %>
    </td>
    <td width="31%" align="center">
      <% If MM_DLMoffset <> 0 Then %>
      <a href="<%=MM_DLMmovePrev%>">Previous</a>
      <% End If ' end MM_DLMoffset <> 0 %>
    </td>
    <td width="23%" align="center">
      <% If Not MM_DLMatTotal Then %>
      <a href="<%=MM_DLMmoveNext%>">Next</a>
      <% End If ' end Not MM_DLMatTotal %>
    </td>
    <td width="23%" align="center">
      <% If Not MM_DLMatTotal Then %>
      <a href="<%=MM_DLMmoveLast%>">Last</a>
      <% End If ' end Not MM_DLMatTotal %>
    </td>
  </tr>
</table>
<div align="center"><br>
  <% If MM_DLMoffset <> 0 Then %>
  Records <%=(List_Library_first)%> to <%=(List_Library_last)%> of <%=(List_Library_total)%> <%end if%><br>
  <% If List_Library.EOF And List_Library.BOF Then %>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div align="center">Sorry no records found......try again</div>
      </td>
    </tr>
  </table>
  <% End If ' end List_Library.EOF And List_Library.BOF %>
</div>
<%
List_Library.Close()
%>
<%
Category.Close()
%>

