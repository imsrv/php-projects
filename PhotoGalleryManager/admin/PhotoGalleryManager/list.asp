<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/photogallerymanager.asp" -->
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_photogallerymanager_STRING
Category.Source = "SELECT *  FROM tblPhotoGalleryCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim photogallery_list__MMColParam1
photogallery_list__MMColParam1 = "%"
If (Request.Form("search") <> "") Then 
  photogallery_list__MMColParam1 = Request.Form("search")        
End If
%>
<%
Dim photogallery_list__MMColParam2
photogallery_list__MMColParam2 = "%"
If (Request.QueryString("ItemID")  <> "") Then 
  photogallery_list__MMColParam2 = Request.QueryString("ItemID") 
End If
%>
<%
Dim photogallery_list__MMColParam3
photogallery_list__MMColParam3 = "%"
If (Request.Form("searchcat")  <> "") Then 
  photogallery_list__MMColParam3 = Request.Form("searchcat") 
End If
%>
<%
set photogallery_list = Server.CreateObject("ADODB.Recordset")
photogallery_list.ActiveConnection = MM_photogallerymanager_STRING
photogallery_list.Source = "SELECT tblPhotoGallery.*, tblPhotoGalleryCategory.CategoryDesc, tblPhotoGalleryCategory.CategoryName  FROM tblPhotoGalleryCategory INNER JOIN tblPhotoGallery ON tblPhotoGalleryCategory.CategoryID = tblPhotoGallery.CategoryID  WHERE tblPhotoGalleryCategory.CategoryName Like '" + Replace(photogallery_list__MMColParam3, "'", "''") + "'  AND tblPhotoGallery.ItemID Like '" + Replace(photogallery_list__MMColParam2, "'", "''") + "' AND (tblPhotoGallery.ItemDesc Like '%" + Replace(photogallery_list__MMColParam1, "'", "''") + "%' OR tblPhotoGallery.ItemName Like '%" + Replace(photogallery_list__MMColParam1, "'", "''") + "%' OR tblPhotoGallery.ItemDescShort Like '%" + Replace(photogallery_list__MMColParam1, "'", "''") + "%' )  ORDER BY tblPhotoGallery.CategoryID, DateAdded"
photogallery_list.CursorType = 0
photogallery_list.CursorLocation = 2
photogallery_list.LockType = 3
photogallery_list.Open()
photogallery_list_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = -1
Repeat1__index = 0
photogallery_list_numRows = photogallery_list_numRows + Repeat1__numRows
%>
<html>
<head>
<title>Photo Gallery Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--

function openPictureWindow_Fever(imageName,imageWidth,imageHeight,alt,posLeft,posTop) {
	newWindow = window.open("","newWindow","width="+imageWidth+",height="+imageHeight+",left="+posLeft+",top="+posTop);
	newWindow.document.open();
	newWindow.document.write('<html><title>'+alt+'</title><body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" onBlur="self.close()">'); 
	newWindow.document.write('<img src='+imageName+' width='+imageWidth+' height='+imageHeight+' alt='+alt+'>'); 
	newWindow.document.write('</body></html>');
	newWindow.document.close();
	newWindow.focus();
}
//-->
</script>
<SCRIPT RUNAT=SERVER LANGUAGE=VBSCRIPT>	
function DoTrimProperly(str, nNamedFormat, properly, pointed, points)
  dim strRet
  strRet = Server.HTMLEncode(str)
  strRet = replace(strRet, vbcrlf,"")
  strRet = replace(strRet, vbtab,"")
  If (LEN(strRet) > nNamedFormat) Then
    strRet = LEFT(strRet, nNamedFormat)			
    If (properly = 1) Then					
      Dim TempArray								
      TempArray = split(strRet, " ")	
      Dim n
      strRet = ""
      for n = 0 to Ubound(TempArray) - 1
        strRet = strRet & " " & TempArray(n)
      next
    End If
    If (pointed = 1) Then
      strRet = strRet & points
    End If
  End If
  DoTrimProperly = strRet
End Function
</SCRIPT>
</head>
<Body>
<!--#include file="header.asp" -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="24" class="tableborder">
  <tr>
    <td height="24" width="60%" valign="baseline">
      <form action="" method="post" name="form2" id="form2">
        <div align="center">Search by Category
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
            <input name="submit2" type="submit" value="Go">
        </div>
      </form>
    </td>
    <td height="24" width="40%" valign="baseline">
      <form name="form" method="post" action="">
        <div align="center">Search by Keyword
            <input name="search" type="text" id="search">
            <input type="submit" value="Go" name="submit">
        </div>
      </form>
    </td>
  </tr>
</table>
<table width="100%" height="32" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr class="tableheader"> 
  <td colspan="2">Category</td>
    <td>Name</td>
    <td>Description</td>
    <td>Image </td>
    <td>Activated</td>
    <td> <div align="center"><a href="insert.asp">Insert New Item</a></div></td>
  </tr>
  <% 
While ((Repeat1__numRows <> 0) AND (NOT photogallery_list.EOF)) 
%>
  <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row1"
Else
Response.Write "row2"
End If
%>">
    <td width="2%" height="13">      <strong>
    <%Response.Write(RecordCounter)
RecordCounter = RecordCounter%>.      </strong>   </td>
    <td height="13"><%=(photogallery_list.Fields.Item("CategoryName").Value)%></td>
    <td height="13"><%=(photogallery_list.Fields.Item("ItemName").Value)%> </td>
    <td width="20%"><% =(DoTrimProperly((photogallery_list.Fields.Item("ItemDesc").Value), 50, 1, 1, "...")) %></td>
    <td height="13">	                
	              <% if photogallery_list.Fields.Item("ImageThumbFileA").Value <> "" then %>
                <a href="javascript:;"><img src="../../applications/PhotoGalleryManager/images/<%=(photogallery_list.Fields.Item("ImageFileA").Value)%>" width="50" border="0" onClick="openPictureWindow_Fever('../../applications/PhotoGalleryManager/images/<%=(photogallery_list.Fields.Item("ImageThumbFileA").Value)%>','400','400','<%=(photogallery_list.Fields.Item("ItemName").Value)%>','','')"></a>
                <% end if ' image check %>  						  
                <% if photogallery_list.Fields.Item("ImageThumbFileB").Value <> "" then %>
                <a href="javascript:;"><img src="../../applications/PhotoGalleryManager/images/<%=(photogallery_list.Fields.Item("ImageThumbFileB").Value)%>" width="50" border="0" onClick="openPictureWindow_Fever('../../applications/PhotoGalleryManager/images/<%=(photogallery_list.Fields.Item("ImageFileB").Value)%>','400','400','<%=(photogallery_list.Fields.Item("ItemName").Value)%>',')','')"></a>
                <% end if ' image check %>
</td>
    <td>      <% If photogallery_list.Fields.Item("Activated").Value = "True" Then %>
      Yes 
      <%else%> 
      No 
      <%end if%>
</td>
    <td height="13">
      <div align="center"><a href="update.asp?ItemID=<%=(photogallery_list.Fields.Item("ItemID").Value)%>">Edit</a> | <a href="delete.asp?ItemID=<%=(photogallery_list.Fields.Item("ItemID").Value)%>">Delete</a></div>
    </td>
  </tr>
  <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  photogallery_list.MoveNext()
Wend
%>

</table>
<br>
<% If photogallery_list.EOF And photogallery_list.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">No Records Found...Please Try Again</div></td>
  </tr>
</table>
<% End If ' end photogallery_list.EOF And photogallery_list.BOF %>

</body>
</html>
<%
Category.Close()
%>
<%
photogallery_list.Close()
Set photogallery_list = Nothing
%>
