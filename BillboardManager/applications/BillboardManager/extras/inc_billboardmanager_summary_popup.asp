<!--#include virtual="/Connections/billboardmanager.asp" -->
<%
set billboard = Server.CreateObject("ADODB.Recordset")
billboard.ActiveConnection = MM_billboardmanager_STRING
billboard.Source = "SELECT Billboard.*, BillboardCategory.CategoryName  FROM Billboard INNER JOIN BillboardCategory ON Billboard.CategoryID = BillboardCategory.CategoryID  WHERE Activated = 'True'  ORDER BY BillboardCategory.CategoryID, DateAdded DESC"
billboard.CursorType = 0
billboard.CursorLocation = 2
billboard.LockType = 3
billboard.Open()
billboard_numRows = 0
%>
<%
Dim HLooper1_billboard__numRows
HLooper1_billboard__numRows = -1
Dim HLooper1_billboard__index
HLooper1_billboard__index = 0
billboard_numRows = billboard_numRows + HLooper1_billboard__numRows
%>
<html>
<head>
<title>Billboard Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../styles.css" rel="stylesheet" type="text/css">
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
<body>
<% Dim TFM_nest, lastTFM_nest%>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<table width="200" align="right" cellpadding="0" class="tableborder" >
  <%
startrw = 0
endrw = HLooper1_billboard__index
numberColumns = 1
numrows = -1
while((numrows <> 0) AND (Not billboard.EOF))
	startrw = endrw + 1
	endrw = endrw + numberColumns
%>
  <tr valign="top"> 
    <%
While ((startrw <= endrw) AND (Not billboard.EOF))
%>
    <td> 
        <% TFM_nest = billboard.Fields.Item("CategoryName").Value
If lastTFM_nest <> TFM_nest Then 
	lastTFM_nest = TFM_nest %>
      <table width="100%" height="12" border="0" cellpadding="0" cellspacing="0" class="row2">
        <tr> 
          <td height="17" width="100%">            &nbsp;<b><%=(billboard.Fields.Item("CategoryName").Value)%></b><font size="1"> for &nbsp;
            <% Response.Write FormatDateTime(Date(), vbShortDate) %>
            </font>            <br>
<hr size="1" noshade>
          </td>
        </tr>
      </table>
      <%End If 'End Basic-UltraDev Simulated Nested Repeat %>      
      <table width="100%" border="0" cellspacing="5" cellpadding="3" class="tableborder">
        <tr>
          <td valign="top">            <a href="javascript:;" onClick="MM_openBrWindow('../inc_billboardmanager.asp?ItemID=<%=(billboard.Fields.Item("ItemID").Value)%>','Detail','scrollbars=yes,width=600,height=400')"><%=(billboard.Fields.Item("ItemName").Value)%></a> <br>
            <% if billboard.Fields.Item("ImageFile").Value <> "" then %>
            <div align="center">
              <p><a href="javascript:;" onClick="MM_openBrWindow('../inc_billboardmanager.asp?ItemID=<%=(billboard.Fields.Item("ItemID").Value)%>','Detail','scrollbars=yes,width=600,height=400')"><img src="../images/<%=(billboard.Fields.Item("ImageFile").Value)%>" width="100" border="0"></a></p>
            </div>
                        <% end if ' image check %>               
         <a href="javascript:;" onClick="MM_openBrWindow('../inc_billboardmanager.asp?ItemID=<%=(billboard.Fields.Item("ItemID").Value)%>','Detail','scrollbars=yes,width=600,height=400')"><%=(DoTrimProperly((billboard.Fields.Item("ItemDesc").Value), 50, 1, 1, "...")) %></a></td>
        </tr>
      </table>      
    </td>
    <%
	startrw = startrw + 1
	billboard.MoveNext()
	Wend
	%>
  </tr>
  <%
 numrows=numrows-1
 Wend
 %>
</table>
</body>
</html>
<%
billboard.Close()
%>
