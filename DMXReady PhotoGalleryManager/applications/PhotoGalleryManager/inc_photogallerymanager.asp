<!--#include virtual="/Connections/photogallerymanager.asp" -->
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_photogallerymanager_STRING
Category.Source = "SELECT tblPhotoGalleryCategory.CategoryName, Count(tblPhotoGallery.ItemID) AS CountOfItemID, tblPhotoGalleryCategory.CategoryID  FROM tblPhotoGallery INNER JOIN tblPhotoGalleryCategory ON tblPhotoGallery.CategoryID = tblPhotoGalleryCategory.CategoryID    WHERE tblPhotoGallery.Activated = 'True'  GROUP BY tblPhotoGalleryCategory.CategoryName, tblPhotoGalleryCategory.CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim photogallery_list__MMColParam1
photogallery_list__MMColParam1 = "%"
If (Request.Form("search")  <> "") Then 
  photogallery_list__MMColParam1 = Request.Form("search") 
End If
%>
<%
Dim photogallery_list__MMColParam2
photogallery_list__MMColParam2 = "%"
If (Request.QueryString("cid")   <> "") Then 
  photogallery_list__MMColParam2 = Request.QueryString("cid")  
End If
%>
<%
set photogallery_list = Server.CreateObject("ADODB.Recordset")
photogallery_list.ActiveConnection = MM_photogallerymanager_STRING
photogallery_list.Source = "SELECT tblPhotoGallery.*, tblPhotoGalleryCategory.CategoryName  FROM tblPhotoGallery INNER JOIN tblPhotoGalleryCategory ON tblPhotoGallery.CategoryID = tblPhotoGalleryCategory.CategoryID  WHERE tblPhotoGallery.Activated = 'True' AND tblPhotoGalleryCategory.CategoryID Like '" + Replace(photogallery_list__MMColParam2, "'", "''") + "'  AND (tblPhotoGallery.ItemDesc Like '%" + Replace(photogallery_list__MMColParam1, "'", "''") + "%' OR tblPhotoGallery.ItemName Like '%" + Replace(photogallery_list__MMColParam1, "'", "''") + "%')  ORDER BY tblPhotoGalleryCategory.CategoryID"
photogallery_list.CursorType = 0
photogallery_list.CursorLocation = 2
photogallery_list.LockType = 3
photogallery_list.Open()
photogallery_list_numRows = 0
%>
<%
Dim photogallery_detail__MMColParam2
photogallery_detail__MMColParam2 = "%"
If (Request.QueryString("ItemID")   <> "") Then 
  photogallery_detail__MMColParam2 = Request.QueryString("ItemID")  
End If
%>
<%
Dim photogallery_detail__MMColParam3
photogallery_detail__MMColParam3 = "%"
If (Request.QueryString("cid")    <> "") Then 
  photogallery_detail__MMColParam3 = Request.QueryString("cid")   
End If
%>
<%
set photogallery_detail = Server.CreateObject("ADODB.Recordset")
photogallery_detail.ActiveConnection = MM_photogallerymanager_STRING
photogallery_detail.Source = "SELECT tblPhotoGallery.*, tblPhotoGalleryCategory.CategoryName  FROM tblPhotoGallery INNER JOIN tblPhotoGalleryCategory ON tblPhotoGallery.CategoryID = tblPhotoGalleryCategory.CategoryID  WHERE tblPhotoGallery.Activated = 'True' AND tblPhotoGallery.ItemID Like '" + Replace(photogallery_detail__MMColParam2, "'", "''") + "' AND tblPhotoGallery.CategoryID Like '" + Replace(photogallery_detail__MMColParam3, "'", "''") + "'  ORDER BY tblPhotoGalleryCategory.CategoryID"
photogallery_detail.CursorType = 0
photogallery_detail.CursorLocation = 2
photogallery_detail.LockType = 3
photogallery_detail.Open()
photogallery_detail_numRows = 0
%>
<%
Dim HLooper1__numRows
HLooper1__numRows = -2
Dim HLooper1__index
HLooper1__index = 0
photogallery_list_numRows = photogallery_list_numRows + HLooper1__numRows
%>
<html>
<head>
<title>Photo Gallery Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body>
<table width="100%" height="113" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr>
    <td width="250" height="113" valign="top" bgcolor="#CCCCCC">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" height="24">
        <tr>
          <td>
		<form action="" method="post" name="form2" id="form2">  
		  Search by Category 
		    <select name="Category" id="Category" onChange="MM_jumpMenu('parent',this,0)">
		    <option selected value="<%=Request.ServerVariables("URL")%>?cid=%<%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("vid")<> "" Then %>&vid=<%=request.querystring("vid")%><%end if%>" <%If (Not isNull(Request.QueryString("cid"))) Then If (Request.ServerVariables("URL") = CStr(Request.QueryString("cid"))) Then Response.Write("SELECTED") : Response.Write("")%>>Show All</option>
		    <%
While (NOT Category.EOF)
%>
		    <option value="<%=Request.ServerVariables("URL")%>?cid=<%=(Category.Fields.Item("CategoryID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("vid")<> "" Then %>&vid=<%=request.querystring("vid")%><%end if%>" <%If (Not isNull(Request.QueryString("cid"))) Then If (CStr(Category.Fields.Item("CategoryID").Value) = CStr(Request.QueryString("cid"))) Then Response.Write("SELECTED") : Response.Write("")%> ><%=(Category.Fields.Item("CategoryName").Value)%>&nbsp;|&nbsp;<%=(Category.Fields.Item("CountOfItemID").Value)%>&nbsp;images</option>
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
        </form>
          </td>
        </tr>
      </table>
      <p>
<table width="100%">
  <%
startrw = 0
endrw = HLooper1__index
numberColumns = 2
numrows = -1
while((numrows <> 0) AND (Not photogallery_list.EOF))
	startrw = endrw + 1
	endrw = endrw + numberColumns
 %>
  <tr align="center" valign="top">
    <%
While ((startrw <= endrw) AND (Not photogallery_list.EOF))
%>
    <td>      <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <% if photogallery_list.Fields.Item("ImageThumbFileA").Value <> "" then %>
                  <td valign="top">                     <% if photogallery_list.Fields.Item("ImageThumbFileA").Value <> "" then %>                      <%=(photogallery_list.Fields.Item("ItemName").Value)%><br>
                    <a href="<%=request.servervariables("URL")%>?ItemID=<%=(photogallery_list.Fields.Item("ItemID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("vid")<> "" Then %>&vid=<%=request.querystring("vid")%><%end if%><%If Request.QueryString ("cid")<> "" Then %>&cid=<%=request.querystring("cid")%><%end if%>"><img src="/applications/PhotoGalleryManager/images/<%=(photogallery_list.Fields.Item("ImageThumbFileA").Value)%>" alt="Click to Zoom" width="75" border="0"></a>                                          <% end if ' image check %>
                  </td>
                  <%end if%>
                  <% if photogallery_list.Fields.Item("ImageThumbFileB").Value <> "" then %>
                  <td valign="top">
                    <% if photogallery_list.Fields.Item("ImageThumbFileB").Value <> "" then %>                    <%=(photogallery_list.Fields.Item("ItemName").Value)%><br>
                    <a href="<%=request.servervariables("URL")%>?ItemID=<%=(photogallery_list.Fields.Item("ItemID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("vid")<> "" Then %>&vid=<%=request.querystring("vid")%><%end if%><%If Request.QueryString ("cid")<> "" Then %>&cid=<%=request.querystring("cid")%><%end if%>"><img src="/applications/PhotoGalleryManager/images/<%=(photogallery_list.Fields.Item("ImageThumbFileB").Value)%>" alt="Click to Zoom" width="75" border="0"></a>                    <% end if ' image check %>
                  </td>
                  <%end if%>
                </tr>
      </table>
    </td>
    <%
	startrw = startrw + 1
	photogallery_list.MoveNext()
	Wend
	%>
  </tr>
  <%
 numrows=numrows-1
 Wend
 %>
</table>
</p><% If photogallery_list.EOF And photogallery_list.BOF Then %>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">No Records Found.....Please Try Again</div>
    </td>
  </tr>
</table>
<% End If ' end photogallery_list.EOF And photogallery_list.BOF %></td>
    <td valign="top"><% If Not photogallery_detail.EOF Or Not photogallery_detail.BOF Then %>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <% if photogallery_detail.Fields.Item("ItemName").Value <> "" then %>
            <tr>
              <td width="8%">Name:</td>
              <td width="92%"><p><%=(photogallery_detail.Fields.Item("ItemName").Value)%></p>
              </td>
            </tr>
			<%end if%>
			<% if photogallery_detail.Fields.Item("DateAdded").Value <> "" then %>
            <tr>
              <td>Date:</td>
              <td><%=(photogallery_detail.Fields.Item("DateAdded").Value)%></td>
            </tr>
			<%end if%>
			<% if photogallery_detail.Fields.Item("ItemDesc").Value <> "" then %>
            <tr>
              <td valign="top">Description:</td>
              <td><%=Replace(photogallery_detail.Fields.Item("ItemDesc"),Chr(13),"<BR>")%></td>
            </tr>
			<%end if%>
          </table></td>
        </tr>
        <tr>
          <% if photogallery_detail.Fields.Item("ImageFileA").Value <> "" then %>
          <td valign="top">
              <div align="center">
                  <% if photogallery_detail.Fields.Item("ImageFileA").Value <> "" then %>
                <img src="/applications/PhotoGalleryManager/images/<%=(photogallery_detail.Fields.Item("ImageFileA").Value)%>" border="0">                
                <% end if ' image check %>
            </div></td>
          <%end if%>
          <% if photogallery_detail.Fields.Item("ImageFileB").Value <> "" then %>
          <td valign="top">
              <div align="center">
                  <% if photogallery_detail.Fields.Item("ImageFileB").Value <> "" then %>
                <img src="/applications/PhotoGalleryManager/images/<%=(photogallery_detail.Fields.Item("ImageFileB").Value)%>" border="0">                
                <% end if ' image check %>
            </div></td><%end if%>
  </tr>
</table>
<% End If ' end Not photogallery_detail.EOF Or NOT photogallery_detail.BOF %>
    </td>
  </tr>
</table>
</body>
</html>
<%
Category.Close()
Set Category = Nothing
%>
<%
photogallery_list.Close()
Set photogallery_list = Nothing
%>
<%
photogallery_detail.Close()
Set photogallery_detail = Nothing
%>
