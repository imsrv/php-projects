<%@LANGUAGE="VBSCRIPT"%>
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
<!--#include virtual="/Connections/joblistingmanager.asp" -->
<%
' Set PayPal Store Manager Variables

%>
<%
Dim rsItems__value1
rsItems__value1 = "%"
If (Request.QueryString("ItemID")  <> "") Then 
  rsItems__value1 = Request.QueryString("ItemID") 
End If
%>
<%
Dim rsItems__value3
rsItems__value3 = "%"
If (Request.QueryString("CategoryID")   <> "") Then 
  rsItems__value3 = Request.QueryString("CategoryID")  
End If
%>
<%
Dim rsItems__value4
rsItems__value4 = "%"
If (Request.QueryString("ParentCategoryID")    <> "") Then 
  rsItems__value4 = Request.QueryString("ParentCategoryID")   
End If
%>
<%
Dim rsItems__value2
rsItems__value2 = "%"
If (Request.Form("search")      <> "") Then 
  rsItems__value2 = Request.Form("search")     
End If
%>
<%
Dim rsItems
Dim rsItems_numRows

Set rsItems = Server.CreateObject("ADODB.Recordset")
rsItems.ActiveConnection = MM_joblistingmanager_STRING
rsItems.Source = "SELECT tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category.*, tblItems.*  FROM (tblItems_Category RIGHT JOIN tblItems ON tblItems_Category.CategoryID = tblItems.CategoryIDkey) LEFT JOIN tblItems_Category AS tblItems_Category_1 ON tblItems_Category.ParentCategoryID = tblItems_Category_1.CategoryID  WHERE tblItems.Activated = 'True' AND tblItems.ItemID LIKE '" + Replace(rsItems__value1, "'", "''") + "' AND tblItems.CategoryIDkey LIKE '" + Replace(rsItems__value3, "'", "''") + "' AND tblItems_Category.ParentCategoryID LIKE '" + Replace(rsItems__value4, "'", "''") + "' AND (tblItems.ItemName LIKE '%" + Replace(rsItems__value2, "'", "''") + "%' OR tblItems.ItemDesc LIKE '%" + Replace(rsItems__value2, "'", "''") + "%' OR tblItems.ItemMemo LIKE '%" + Replace(rsItems__value2, "'", "''") + "%' )  ORDER BY tblItems.DateAdded, tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
rsItems.CursorType = 0
rsItems.CursorLocation = 2
rsItems.LockType = 1
rsItems.Open()

rsItems_numRows = 0
%>
<%
set rsCategory = Server.CreateObject("ADODB.Recordset")
rsCategory.ActiveConnection = MM_joblistingmanager_STRING
rsCategory.Source = "SELECT tblItems_Category_1.CategoryImageFile AS ParentCategoryImageFile, tblItems_Category_1.CategoryLabel AS ParentCategoryLabel, tblItems_Category_1.CategoryDesc AS ParentCategoryDesc, tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category.CategoryID, tblItems_Category.CategoryValue, tblItems_Category.ParentCategoryID, tblItems_Category.CategoryDesc, tblItems_Category.CategoryLabel, tblItems_Category.CategoryImageFile, Count(tblItems.ItemID) AS ItemCount  FROM (tblItems_Category LEFT JOIN tblItems_Category AS tblItems_Category_1 ON tblItems_Category.ParentCategoryID = tblItems_Category_1.CategoryID) RIGHT JOIN tblItems ON tblItems_Category.CategoryID = tblItems.CategoryIDkey  WHERE (((tblItems.Activated)='True'))  GROUP BY tblItems_Category_1.CategoryImageFile, tblItems_Category_1.CategoryLabel, tblItems_Category_1.CategoryDesc, tblItems_Category_1.CategoryValue, tblItems_Category.CategoryID, tblItems_Category.CategoryValue, tblItems_Category.ParentCategoryID, tblItems_Category.CategoryDesc, tblItems_Category.CategoryLabel, tblItems_Category.CategoryImageFile  HAVING (((tblItems_Category.ParentCategoryID)<>0))  ORDER BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
rsCategory.CursorType = 0
rsCategory.CursorLocation = 2
rsCategory.LockType = 3
rsCategory.Open()
rsCategory_numRows = 0
%>
<%
Dim rsRelatedItems__value1
rsRelatedItems__value1 = "%"
If (Request.QueryString("ItemID") <> "") Then 
  rsRelatedItems__value1 = Request.QueryString("ItemID")
End If
%>
<%
Dim rsRelatedItems__value3
rsRelatedItems__value3 = "999"
If (Request.QueryString("CategoryID")   <> "") Then 
  rsRelatedItems__value3 = Request.QueryString("CategoryID")  
End If
%>
<%
Dim rsRelatedItems
Dim rsRelatedItems_numRows

Set rsRelatedItems = Server.CreateObject("ADODB.Recordset")
rsRelatedItems.ActiveConnection = MM_joblistingmanager_STRING
rsRelatedItems.Source = "SELECT tblItems_Category_1.CategoryValue AS ParentCategoryValue, tblItems_Category.*, tblItems.*  FROM (tblItems_Category RIGHT JOIN tblItems ON tblItems_Category.CategoryID = tblItems.CategoryIDkey) LEFT JOIN tblItems_Category AS tblItems_Category_1 ON tblItems_Category.ParentCategoryID = tblItems_Category_1.CategoryID  WHERE tblItems.Activated = 'True' AND tblItems.ItemID NOT LIKE '" + Replace(rsRelatedItems__value1, "'", "''") + "' AND tblItems.CategoryIDkey LIKE '" + Replace(rsRelatedItems__value3, "'", "''") + "'  ORDER BY tblItems_Category_1.CategoryValue, tblItems_Category.CategoryValue"
rsRelatedItems.CursorType = 0
rsRelatedItems.CursorLocation = 2
rsRelatedItems.LockType = 1
rsRelatedItems.Open()

rsRelatedItems_numRows = 0
%>
<%
Dim RepeatrsCategoryList__numRows
Dim RepeatrsCategoryList__index

RepeatrsCategoryList__numRows = -1
RepeatrsCategoryList__index = 0
rsCategory_numRows = rsCategory_numRows + RepeatrsCategoryList__numRows
%>
<%
Dim Repeat_rsItems__numRows
Dim Repeat_rsItems__index

Repeat_rsItems__numRows = -1
Repeat_rsItems__index = 0
rsItems_numRows = rsItems_numRows + Repeat_rsItems__numRows
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = -1
Repeat1__index = 0
rsRelatedItems_numRows = rsRelatedItems_numRows + Repeat1__numRows
%>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<link href="../../styles.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style3 {color: #FFFFFF}
.style4 {color: #000000}
-->
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">	<form name="searchForm" method="post" action="<%=request.servervariables("URL")%><%If Request.QueryString ("mid")<> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>">
    <% If Not rsCategory.EOF Or Not rsCategory.BOF Then %>
    <table width="100%" cellpadding="5" cellspacing="0" class="tableborder2">
      <tr>
        <td valign="top" bgcolor="#666666"><span class="style3">Search Jobs by
            keyword</span><br>
            <input name="search" type="text" id="search" size="18">
            <input type="submit" value="Go" name="submit3" height="1">
            </td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#EAEAEA">
          <% 
While ((RepeatrsCategoryList__numRows <> 0) AND (NOT rsCategory.EOF)) 
%>
          <% nested_categoryvalue = rsCategory.Fields.Item("ParentCategoryValue").Value
If lastnested_categoryvalue <> nested_categoryvalue Then 
	lastnested_categoryvalue = nested_categoryvalue %>
          <br>
           <a href="<%=request.servervariables("URL")%>?ParentCategoryID=<%=(rsCategory.Fields.Item("ParentCategoryID").Value)%><%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsCategory.Fields.Item("ParentCategoryValue").Value)%></a> <br>
          <%End If 'End Basic-UltraDev Simulated Nested Repeat %>
&nbsp;&raquo;&nbsp; <a href="<%=request.servervariables("URL")%>?CategoryID=<%=(rsCategory.Fields.Item("CategoryID").Value)%><%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsCategory.Fields.Item("CategoryValue").Value)%></a> (<%=(rsCategory.Fields.Item("ItemCount").Value)%>)<br>
      <%
itemtotal = itemtotal + (rsCategory.Fields.Item("ItemCount").Value)
%>
      <% 
  RepeatrsCategoryList__index=RepeatrsCategoryList__index+1
  RepeatrsCategoryList__numRows=RepeatrsCategoryList__numRows-1
  rsCategory.MoveNext()
Wend
%>
          <div align="right"><a href="<%=request.servervariables("URL")%><%If Request.QueryString ("mid")<> "" Then %>?mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>?show=all"><br>
        Show All</a> (<%=ItemTotal%>) </div>
        </td>
      </tr>
    </table>
    <% End If ' end Not rsCategory.EOF Or NOT rsCategory.BOF %>
    </form>  
</td>
<% If Request.QueryString <> "" OR Request.Form <> "" Then ' Remove if you want to display all records as default %>
    <td width="85%" valign="top">
      <% 
While ((Repeat_rsItems__numRows <> 0) AND (NOT rsItems.EOF)) 
%>
      <% If Not rsItems.EOF Or Not rsItems.BOF Then %>
      <table width="98%" border="0" align="center" cellpadding="3" cellspacing="0" class="tableborder2">
        <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row2"
Else
Response.Write "row1"
End If
%>">
          <td align="left" valign="top">          <p><font size="2"> 
		  
		  <a href="<%=request.servervariables("URL")%>?ParentCategoryID=<%=(rsItems.Fields.Item("ParentCategoryID").Value)%><%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsItems.Fields.Item("ParentCategoryValue").Value)%></a> &raquo; <a href="<%=request.servervariables("URL")%>?CategoryID=<%=(rsItems.Fields.Item("CategoryID").Value)%><%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsItems.Fields.Item("CategoryValue").Value)%></a>
 <br>
              <br>		  
              <b><%=(rsItems.Fields.Item("ItemName").Value)%></b></font><br>
               <em>Posted on <%= DoDateTime((rsItems.Fields.Item("DateAdded").Value), 1, 1033) %></em><br>
              <br>
              <%=(rsItems.Fields.Item("ItemDesc").Value)%>          
            <p align="right">              
              <%If Request.QueryString ("ItemID") <> "" Then %>
             <font size="2">[</font> <a href="javascript:history.go(-1);">Go
              Back</a>
               ] 
              <% else%>
              <font size="2">[ </font> <a href="<%=request.servervariables("URL")%>?ItemID=<%=(rsItems.Fields.Item("ItemID").Value)%>&CategoryID=<%=(rsItems.Fields.Item("CategoryID").Value)%><%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>">Click
              to view Job Details </a>
               ] 
               <%end if%>      
          </td>
        </tr>
        <tr>
          <td valign="top"><% If Request.QueryString("ItemID") <> "" AND rsItems.Fields.Item("ItemMemo").Value <> "" Then %>
            <table width="100%" border="0" cellpadding="3" cellspacing="0" class="activeborder">
              <tr>
                <td bgcolor="#666666"><font color="#FFFFFF"><strong>Job
                      Details</strong>:</font></td>
              </tr>
              <tr>
                <td><%=(rsItems.Fields.Item("ItemMemo").Value)%> </td>
              </tr>
            </table>     
              <%End If %>
			  <% If Request.QueryString("ItemID") <> "" Then %>
            <table width="100%" border="0" cellpadding="3" cellspacing="0" class="activeborder">
              <tr>
                <td colspan="3" bgcolor="#666666"><strong><font color="#FFFFFF">How to
                    Apply :</font></strong></td>
              </tr>
              <tr>
                <td width="0"><%=(rsItems.Fields.Item("SendToInstructions").Value)%> </td>
		<% If rsItems.Fields.Item("SendToEmailAddress").Value <> "" Then %>		
                <td width="100"><div align="center">&raquo; <a href="mailto:<%=(rsItems.Fields.Item("SendToEmailAddress").Value)%>?subject=APPLICATION [JobID <%=(rsItems.Fields.Item("ItemID").Value)%>:<%=(rsItems.Fields.Item("ItemName").Value)%>]">Apply
                    Now </a></div></td>
					<% end if%>
                <td width="100">            <p align="center"> &raquo;   
              <%
pre_url = "http://" & request.servervariables("HTTP_HOST") & request.servervariables("URL") & "?" & request.servervariables("QUERY_STRING")
url = Server.URLencode(pre_url)
%>
              <a href="javascript:;"  onClick="MM_openBrWindow('/applications/JobListingManager/components/inc_sendtofriendmanager.asp?emailform=yes&url=<%=url%>','SendToFriend','width=500,height=350')">Send
              To Friend</a>   </td>
              </tr>
            </table>         
			<%end if%>   
</td>
        </tr>
      </table>
      <% End If ' end Not rsItems.EOF Or NOT rsItems.BOF %>
      <% 	  dim CategoryID
CategoryID = (rsItems.Fields.Item("CategoryID").Value) 
%>
	  
	    <br>
			 <% 
  Repeat_rsItems__index=Repeat_rsItems__index+1
  Repeat_rsItems__numRows=Repeat_rsItems__numRows-1
  rsItems.MoveNext()
Wend
%>
             <% If Not rsRelatedItems.EOF Or Not rsRelatedItems.BOF Then %>
             <table width="98%" border="0" align="center" cellpadding="0" class="tableborder2">
          <tr bgcolor="#FFFFCC">
            <td bgcolor="#CCCCCC"><em><strong><span class="style4">Related jobs<font size="2">:</font><font size="2"></font><font size="2"></font></span></strong></em></td>
          </tr>
          <% 
While ((Repeat1__numRows <> 0) AND (NOT rsRelatedItems.EOF)) 
%>
          <tr class="<% 
RecordCounter = RecordCounter + 1
If RecordCounter Mod 2 = 1 Then
Response.Write "row2"
Else
Response.Write "row1"
End If
%>">
            <td valign="top">             

<a href="<%=request.servervariables("URL")%>?ItemID=<%=(rsRelatedItems.Fields.Item("ItemID").Value)%>&CategoryID=<%=(rsRelatedItems.Fields.Item("CategoryID").Value)%><%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"><%=(rsRelatedItems.Fields.Item("ItemName").Value)%></a>  - <a href="<%=request.servervariables("URL")%>?ItemID=<%=(rsRelatedItems.Fields.Item("ItemID").Value)%>&CategoryID=<%=(rsRelatedItems.Fields.Item("CategoryID").Value)%><%If Request.QueryString ("mid")<> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%><%If Request.QueryString ("Variables")<> "" Then %>&<%=request.querystring("Variables")%><%end if%>"></a><%=(rsRelatedItems.Fields.Item("ItemDesc").Value)%>
</td>
          </tr>
          <% 
  Repeat1__index=Repeat1__index+1
  Repeat1__numRows=Repeat1__numRows-1
  rsRelatedItems.MoveNext()
Wend
%>
             </table>
             <% End If ' end Not rsRelatedItems.EOF Or NOT rsRelatedItems.BOF %>
<br>
	<% If rsItems.EOF And rsItems.BOF AND request.Form("search") <> "" Then %>
<br>
<br>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center"><font size="2">No items found containing keyword <font color="#FF0000">&quot;<strong><%= Request.Form("search") %></strong>&quot;</font> .....Please <a href="javascript:history.go(-1);">Try
        Again</a></font></div>
    </td>
  </tr>
</table>
<% End If ' end rsItems.EOF And rsItems.BOF %>
</td>
<% End If %>
  </tr>
</table>
<%
rsItems.Close()
Set rsItems = Nothing
%>
<%
rsCategory.Close()
Set rsCategory = Nothing
%>
<%
rsRelatedItems.Close()
Set rsRelatedItems = Nothing
%>
