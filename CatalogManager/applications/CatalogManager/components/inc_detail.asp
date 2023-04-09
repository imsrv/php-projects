<!--#include virtual="/Connections/catalogmanager.asp" -->
<%
Dim item_detail__value1
item_detail__value1 = "0"
If (Request.QueryString("ItemID")  <> "") Then 
  item_detail__value1 = Request.QueryString("ItemID") 
End If
%>
<%
Dim item_detail
Dim item_detail_numRows

Set item_detail = Server.CreateObject("ADODB.Recordset")
item_detail.ActiveConnection = MM_catalogmanager_STRING
item_detail.Source = "SELECT tblCatalog.*, tblCatalogSubCategory.*, tblCatalogCategory.*, tblGPC.*, tblCatalogDetails.*, tblManufacturers.*  FROM ((((tblCatalogCategory RIGHT JOIN tblCatalogSubCategory ON tblCatalogCategory.CategoryID = tblCatalogSubCategory.CategoryIDkey) RIGHT JOIN tblCatalog ON tblCatalogSubCategory.SubCategoryID = tblCatalog.SubCategoryIDKey) LEFT JOIN tblGPC ON tblCatalogCategory.GPCIDkey = tblGPC.GPCID) LEFT JOIN tblCatalogDetails ON tblCatalog.ItemID = tblCatalogDetails.ItemIDKey) LEFT JOIN tblManufacturers ON tblCatalog.ManufacturerIDkey = tblManufacturers.ManufacturerID  WHERE ItemID = " + Replace(item_detail__value1, "'", "''") + ""
item_detail.CursorType = 0
item_detail.CursorLocation = 2
item_detail.LockType = 1
item_detail.Open()

item_detail_numRows = 0
%>
<%
Dim item_list_suggestions__value2
item_list_suggestions__value2 = "%"
If (Request.QueryString("cid")      <> "") Then 
  item_list_suggestions__value2 = Request.QueryString("cid")     
End If
%>
<%
Dim item_list_suggestions__value4
item_list_suggestions__value4 = "%"
If (Request.QueryString("scid")      <> "") Then 
  item_list_suggestions__value4 = Request.QueryString("scid")     
End If
%>
<%
Dim item_list_suggestions__value5
item_list_suggestions__value5 = "%"
If (Request.QueryString("gpcid")      <> "") Then 
  item_list_suggestions__value5 = Request.QueryString("gpcid")     
End If
%>
<%
Dim item_list_suggestions__value7
item_list_suggestions__value7 = "0"
If (Request.QueryString("ItemID")        <> "") Then 
  item_list_suggestions__value7 = Request.QueryString("ItemID")       
End If
%>
<%
Dim item_list_suggestions__value6
item_list_suggestions__value6 = "%"
If (Request.QueryString("manid")         <> "") Then 
  item_list_suggestions__value6 = Request.QueryString("manid")        
End If
%>
<%
Dim item_list_suggestions
Dim item_list_suggestions_numRows

Set item_list_suggestions = Server.CreateObject("ADODB.Recordset")
item_list_suggestions.ActiveConnection = MM_catalogmanager_STRING
item_list_suggestions.Source = "SELECT tblCatalog.*, tblCatalogSubCategory.*, tblCatalogCategory.*, tblGPC.*, tblCatalogDetails.*, tblManufacturers.*  FROM ((((tblCatalogCategory RIGHT JOIN tblCatalogSubCategory ON tblCatalogCategory.CategoryID = tblCatalogSubCategory.CategoryIDkey) RIGHT JOIN tblCatalog ON tblCatalogSubCategory.SubCategoryID = tblCatalog.SubCategoryIDKey) LEFT JOIN tblGPC ON tblCatalogCategory.GPCIDkey = tblGPC.GPCID) LEFT JOIN tblCatalogDetails ON tblCatalog.ItemID = tblCatalogDetails.ItemIDKey) LEFT JOIN tblManufacturers ON tblCatalog.ManufacturerIDkey = tblManufacturers.ManufacturerID  WHERE Activated = 'True' AND CategoryID LIKE '" + Replace(item_list_suggestions__value2, "'", "''") + "' AND SubCategoryID LIKE '" + Replace(item_list_suggestions__value4, "'", "''") + "' AND GPCID LIKE '" + Replace(item_list_suggestions__value5, "'", "''") + "' AND ManufacturerID LIKE '" + Replace(item_list_suggestions__value6, "'", "''") + "' AND ItemID NOT LIKE '" + Replace(item_list_suggestions__value7, "'", "''") + "'"
item_list_suggestions.CursorType = 0
item_list_suggestions.CursorLocation = 2
item_list_suggestions.LockType = 1
item_list_suggestions.Open()

item_list_suggestions_numRows = 0
%>
<%
Dim RepeatSuggestions__numRows
Dim RepeatSuggestions__index

RepeatSuggestions__numRows = -1
RepeatSuggestions__index = 0
item_list_suggestions_numRows = item_list_suggestions_numRows + RepeatSuggestions__numRows
%>
<% If Not item_detail.EOF Or Not item_detail.BOF Then %>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder">
          <tr class="row1">
            <td height="161" rowspan="2" valign="top">            
		    <% if item_detail.Fields.Item("Manufacturer").Value <> "" then %>		  <div align="center"><strong><%=(item_detail.Fields.Item("Manufacturer").Value)%></strong><br>
		    <%end if%>
                <% if item_detail.Fields.Item("ManufacturerImageFile").Value <> "" then %>
                <img src="/applications/CatalogManager/images/<%=(item_detail.Fields.Item("ManufacturerImageFile").Value)%>" alt="Click to Zoom" border="0">
                <% end if%>
                <br>
                <br>
                <% if item_detail.Fields.Item("ImageFile").Value <> "" then %>
                     <a href="javascript:;"><img src="/applications/CatalogManager/images/<%=(item_detail.Fields.Item("ImageFile").Value)%>" alt="Click to Zoom" width="150" border="0" onClick="openPictureWindow_Fever('/applications/CatalogManager/images/<%=(item_detail.Fields.Item("ImageFile").Value)%>','400','400','<%=(item_detail.Fields.Item("ImageFile").Value)%>','','')"></a>
			      <% end if%>
                  <br>
                  <br>
                  <% if item_detail.Fields.Item("ImageFile2").Value <> "" then %>
                                     <a href="javascript:;"><img src="/applications/CatalogManager/images/<%=(item_detail.Fields.Item("ImageFile2").Value)%>" alt="Click to Zoom" width="150" border="0" onClick="openPictureWindow_Fever('/applications/CatalogManager/images/<%=(item_detail.Fields.Item("ImageFile2").Value)%>','400','400','<%=(item_detail.Fields.Item("ImageFile2").Value)%>','','')"></a>
                  <% end if%>
    </div>
            </td>
            <td height="111" valign="top">
              <p> <font size="2"><strong><%=(item_detail.Fields.Item("ItemName").Value)%></strong></font><br>
                  <%=(item_detail.Fields.Item("ItemDesc").Value)%></p>			
              <p><b><font size="3" color="#FF0000">			
                        <% If item_detail.Fields.Item("ItemPrice").Value <> "" Then %>
                  <%= FormatCurrency((item_detail.Fields.Item("ItemPrice").Value), -1, -2, -2, -2) %>
  /                
  </font></b><font size="2" color="#FF0000"><%=(item_detail.Fields.Item("UnitOfMeasure").Value)%></font><font size="3" color="#FF0000"><b>
  <% end if%>
                </b></font></p> 
			      <p>
			        <% If item_detail.Fields.Item("OrderLink").Value <> "" Then %>
Order Now
<% end if%>
<br>
<% If item_detail.Fields.Item("DownloadFile").Value <> "" Then %>
<a href="<%If instr(item_detail.Fields.Item("DownloadFile").Value,"http") Then %><%=(item_detail.Fields.Item("DownloadFile").Value)%><%else%>/applications/CatalogManager/download/<%=(item_detail.Fields.Item("DownloadFile").Value)%><%end if%>">Download
File </a>
<% end if%>
<% If item_detail.Fields.Item("DownloadFile2").Value <> "" Then %>
&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<%If instr(item_detail.Fields.Item("DownloadFile2").Value,"http") Then %><%=(item_detail.Fields.Item("DownloadFile2").Value)%><%else%>/applications/CatalogManager/download/<%=(item_detail.Fields.Item("DownloadFile2").Value)%><%end if%>">Download
File2</a>
<% end if%>
<p><a href="javascript:history.go(-1);">Go back</a></p></td>
  <td width="100" valign="top">
            <% If item_detail.Fields.Item("Feature1").Value <> "" Then %>        
		      <strong>Features</strong><br>	
                <li><%=(item_detail.Fields.Item("Feature1").Value)%></li>
		    <%End If%>
		    <% If item_detail.Fields.Item("Feature2").Value <> "" Then %>
                <li><%=(item_detail.Fields.Item("Feature2").Value)%></li>
		    <%End If%>
		    <% If item_detail.Fields.Item("Feature3").Value <> "" Then %>
                <li><%=(item_detail.Fields.Item("Feature3").Value)%></li>
		    <%End If%>
		    <% If item_detail.Fields.Item("Feature4").Value <> "" Then %>

                <li><%=(item_detail.Fields.Item("Feature4").Value)%></li>
		    <%End If%>
			      <% If item_detail.Fields.Item("Feature5").Value <> "" Then %>
                <li><%=(item_detail.Fields.Item("Feature5").Value)%></li><br><%End If%>
                <% If Not item_list_suggestions.EOF Or Not item_list_suggestions.BOF Then %>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableborder">
                    <tr>
                      <td><strong>Also Available</strong></td>
                    </tr>
                    <tr>
                      <td valign="top">
                        <% 
While ((RepeatSuggestions__numRows <> 0) AND (NOT item_list_suggestions.EOF)) 
%>
                        <a href="<%=request.servervariables("URL")%>?gpcid=<%=(item_list_suggestions.Fields.Item("GPCID").Value)%>&cid=<%=(item_list_suggestions.Fields.Item("CategoryID").Value)%>&scid=<%=(item_list_suggestions.Fields.Item("SubCategoryID").Value)%>&ItemID=<%=(item_list_suggestions.Fields.Item("ItemID").Value)%><%If Request.QueryString("mid") <> "" Then %>&mid=<%=request.querystring("mid")%><%end if%><%If Request.QueryString ("mid2")<> "" Then %>&mid2=<%=request.querystring("mid2")%><%end if%><%If Request.QueryString ("mid3")<> "" Then %>&mid3=<%=request.querystring("mid3")%><%end if%><%If Request.QueryString ("incid")<> "" Then %>&incid=<%=request.querystring("incid")%><%end if%>"><%=(item_list_suggestions.Fields.Item("ItemName").Value)%> </a><br>
                              <% 
  RepeatSuggestions__index=RepeatSuggestions__index+1
  RepeatSuggestions__numRows=RepeatSuggestions__numRows-1
  item_list_suggestions.MoveNext()
Wend
%>
                        <br>
                      </td>
                    </tr>
                </table>
                <% End If ' end Not item_list_suggestions.EOF Or NOT item_list_suggestions.BOF %>                <br>	
            </td>
	      </tr>
</table>
        <% End If ' end Not item_detail.EOF Or NOT item_detail.BOF %>
<br>
<% If Not item_detail.EOF Or Not item_detail.BOF Then %>
        <table width="100%" border="0" cellspacing="2" cellpadding="2" align="center" class="tableborder">
          <% If item_detail.Fields.Item("Detailtxt1").Value <> "" Then %>
          <%End If%>
          <% If item_detail.Fields.Item("Detailtxt1").Value <> "" Then %>
          <tr>
            <td width="239" bgcolor="#666666"><font color="#FFFFFF">ExtraDetailtxt1</font></td>
            <td width="587" bgcolor="#CCCCCC">
              <div align="left"><%=(item_detail.Fields.Item("Detailtxt1").Value)%></div>
            </td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("Detailtxt2").Value <> "" Then %>
          <tr>
            <td width="239" bgcolor="#666666"><font color="#FFFFFF">ExtraDetailtxt2</font></td>
            <td width="587" bgcolor="#CCCCCC">
              <div align="left"><%=(item_detail.Fields.Item("Detailtxt2").Value)%></div>
            </td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("Detailtxt3").Value <> "" Then %>
          <tr>
            <td width="239" bgcolor="#666666"><font color="#FFFFFF">ExtraDetailtxt3</font></td>
            <td width="587" bgcolor="#CCCCCC">
              <div align="left"><%=(item_detail.Fields.Item("Detailtxt3").Value)%> </div>
            </td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("Detailtxt4").Value <> "" Then %>
          <tr>
            <td width="239" bgcolor="#666666"><font color="#FFFFFF">ExtraDetailtxt4</font></td>
            <td width="587" bgcolor="#CCCCCC">
              <div align="left"><%=(item_detail.Fields.Item("Detailtxt4").Value)%></div>
            </td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("Detailtxt5").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailtxt5</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("Detailtxt5").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailMemo1").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailMemo1</font></td>
            <td bgcolor="#CCCCCC"><%=Replace(item_detail.Fields.Item("DetailMemo1").Value,Chr(13),"<BR>")%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailMemo2").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailMemo2</font></td>
            <td bgcolor="#CCCCCC"><%=Replace(item_detail.Fields.Item("DetailMemo2").Value,Chr(13),"<BR>")%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailMemo3").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailMemo3</font></td>
            <td bgcolor="#CCCCCC"><%=Replace(item_detail.Fields.Item("DetailMemo3").Value,Chr(13),"<BR>")%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailMemo4").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailMemo4</font></td>
            <td bgcolor="#CCCCCC"><%=Replace(item_detail.Fields.Item("DetailMemo4").Value,Chr(13),"<BR>")%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailMemo5").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailMemo5</font></td>
            <td bgcolor="#CCCCCC"><%=Replace(item_detail.Fields.Item("DetailMemo5").Value,Chr(13),"<BR>")%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailDate1").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailDate1</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailDate1").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailDate2").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailDate2</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailDate2").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailDate3").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailDate3</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailDate3").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailDate4").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailDate4</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailDate4").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailDate5").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailDate5</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailDate5").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailNumber1").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailNumber1</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailNumber1").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailNumber2").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailNumber2</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailNumber2").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailNumber3").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailNumber3</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailNumber3").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailNumber4").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailNumber4</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailNumber4").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailNumber5").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailNumber5</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailNumber5").Value)%></td>
          </tr>
		   <%End If%>
		   <% If item_detail.Fields.Item("DetailFlag1").Value <> "" Then %>
		  <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailFlag1</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailFlag1").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailFlag2").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailFlag2</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailFlag2").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailFlag3").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailFlag3</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailFlag3").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailFlag4").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailFlag4</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailFlag4").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailFlag5").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailFlag5</font></td>
            <td bgcolor="#CCCCCC"><%=(item_detail.Fields.Item("DetailFlag5").Value)%></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailImage1").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailImage1</font></td>
            <td bgcolor="#CCCCCC">              <% if item_detail.Fields.Item("DetailImage1").Value <> "" then %>
                <a href="javascript:;"><img src="/applications/CatalogManager/images/<%=(item_detail.Fields.Item("DetailImage1").Value)%>" alt="Click to Zoom" width="50" border="0" onClick="openPictureWindow_Fever('/applications/CatalogManager/images/<%=(item_detail.Fields.Item("DetailImage1").Value)%>','400','400','<%=(item_detail.Fields.Item("ItemName").Value)%>','','')"></a>
                <% end if %>
</td></tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailImage2").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailImage2</font></td>
            <td bgcolor="#CCCCCC">              <% if item_detail.Fields.Item("DetailImage2").Value <> "" then %>
                <a href="javascript:;"><img src="/applications/CatalogManager/images/<%=(item_detail.Fields.Item("DetailImage2").Value)%>" alt="Click to Zoom" width="50" border="0" onClick="openPictureWindow_Fever('/applications/CatalogManager/images/<%=(item_detail.Fields.Item("DetailImage2").Value)%>','400','400','<%=(item_detail.Fields.Item("ItemName").Value)%>','','')"></a>
                <% end if %>
</td></tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailImage3").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailImage3</font></td>
            <td bgcolor="#CCCCCC">              <% if item_detail.Fields.Item("DetailImage3").Value <> "" then %>
                <a href="javascript:;"><img src="/applications/CatalogManager/images/<%=(item_detail.Fields.Item("DetailImage3").Value)%>" alt="Click to Zoom" width="50" border="0" onClick="openPictureWindow_Fever('/applications/CatalogManager/images/<%=(item_detail.Fields.Item("DetailImage3").Value)%>','400','400','<%=(item_detail.Fields.Item("ItemName").Value)%>','','')"></a>
                <% end if %>
</td></tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailImage4").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailImage4</font></td>
            <td bgcolor="#CCCCCC">              <% if item_detail.Fields.Item("DetailImage4").Value <> "" then %>
                <a href="javascript:;"><img src="/applications/CatalogManager/images/<%=(item_detail.Fields.Item("DetailImage4").Value)%>" alt="Click to Zoom" width="50" border="0" onClick="openPictureWindow_Fever('/applications/CatalogManager/images/<%=(item_detail.Fields.Item("DetailImage4").Value)%>','400','400','<%=(item_detail.Fields.Item("ItemName").Value)%>','','')"></a>
                <% end if %>
</td></tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailImage5").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailImage5</font></td>
            <td bgcolor="#CCCCCC">              <% if item_detail.Fields.Item("DetailImage5").Value <> "" then %>
                <a href="javascript:;"><img src="/applications/CatalogManager/images/<%=(item_detail.Fields.Item("DetailImage5").Value)%>" alt="Click to Zoom" width="50" border="0" onClick="openPictureWindow_Fever('/applications/CatalogManager/images/<%=(item_detail.Fields.Item("DetailImage5").Value)%>','400','400','<%=(item_detail.Fields.Item("ItemName").Value)%>','','')"></a>
                <% end if %>
</td></tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailDownloadFile1").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailDownloadFile1</font></td>
            <td bgcolor="#CCCCCC">		
			<a href="<%If instr(item_detail.Fields.Item("DetailDownloadFile1").Value,"http") Then %><%=(item_detail.Fields.Item("DetailDownloadFile1").Value)%><%else%>/applications/CatalogManager/download/<%=(item_detail.Fields.Item("DetailDownloadFile1").Value)%><%end if%>"><%=(item_detail.Fields.Item("DetailDownloadFile1").Value)%></a>	
			</td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailDownloadFile2").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailDownloadFile2</font></td>
            <td bgcolor="#CCCCCC"><a href="<%If instr(item_detail.Fields.Item("DetailDownloadFile2").Value,"http") Then %><%=(item_detail.Fields.Item("DetailDownloadFile2").Value)%><%else%>/applications/CatalogManager/download/<%=(item_detail.Fields.Item("DetailDownloadFile2").Value)%><%end if%>"><%=(item_detail.Fields.Item("DetailDownloadFile2").Value)%></a></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailDownloadFile3").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailDownloadFile3</font></td>
            <td bgcolor="#CCCCCC"><a href="<%If instr(item_detail.Fields.Item("DetailDownloadFile3").Value,"http") Then %><%=(item_detail.Fields.Item("DetailDownloadFile3").Value)%><%else%>/applications/CatalogManager/download/<%=(item_detail.Fields.Item("DetailDownloadFile3").Value)%><%end if%>"><%=(item_detail.Fields.Item("DetailDownloadFile3").Value)%></a></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailDownloadFile4").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailDownloadFile4</font></td>
            <td bgcolor="#CCCCCC"><a href="<%If instr(item_detail.Fields.Item("DetailDownloadFile4").Value,"http") Then %><%=(item_detail.Fields.Item("DetailDownloadFile4").Value)%><%else%>/applications/CatalogManager/download/<%=(item_detail.Fields.Item("DetailDownloadFile4").Value)%><%end if%>"><%=(item_detail.Fields.Item("DetailDownloadFile4").Value)%></a></td>
          </tr>
          <%End If%>
          <% If item_detail.Fields.Item("DetailDownloadFile5").Value <> "" Then %>
          <tr>
            <td bgcolor="#666666"><font color="#FFFFFF">ExtraDetailDownloadFile5</font></td>
            <td bgcolor="#CCCCCC"><a href="<%If instr(item_detail.Fields.Item("DetailDownloadFile5").Value,"http") Then %><%=(item_detail.Fields.Item("DetailDownloadFile5").Value)%><%else%>/applications/CatalogManager/download/<%=(item_detail.Fields.Item("DetailDownloadFile5").Value)%><%end if%>"><%=(item_detail.Fields.Item("DetailDownloadFile5").Value)%></a></td>
          </tr>
          <%End If%>
        </table>
        <% End If ' end Not item_detail.EOF Or NOT item_detail.BOF %>
<%
item_detail.Close()
Set item_detail = Nothing
%>
<%
item_list_suggestions.Close()
Set item_list_suggestions = Nothing
%>
