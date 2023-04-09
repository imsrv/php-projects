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
<!--#include file="../../../Connections/eventlistingmanager.asp" -->
<%
set eventsummary = Server.CreateObject("ADODB.Recordset")
eventsummary.ActiveConnection = MM_eventlistingmanager_STRING
eventsummary.Source = "SELECT tblEventListings.*, tblEventCategory.CategoryName  FROM tblEventListings INNER JOIN tblEventCategory ON tblEventListings.CategoryID = tblEventCategory.CategoryID"
eventsummary.CursorType = 0
eventsummary.CursorLocation = 2
eventsummary.LockType = 3
eventsummary.Open()
eventsummary_numRows = 0
%>
<%
Dim HLooper1_eventsummary__numRows
HLooper1_eventsummary__numRows = 2
Dim HLooper1_eventsummary__index
HLooper1_eventsummary__index = 0
eventsummary_numRows = eventsummary_numRows + HLooper1_eventsummary__numRows
%>
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
<% Dim TFM_events_nest, lastTFM_events_nest%>

<table width="100%" cellpadding="0">
  <%
startrw = 0
endrw = HLooper1_eventsummary__index
numberColumns = 1
numrows = 2
while((numrows <> 0) AND (Not eventsummary.EOF))
	startrw = endrw + 1
	endrw = endrw + numberColumns
%>
  <tr valign="top"> 
    <%
While ((startrw <= endrw) AND (Not eventsummary.EOF))
%>
    <td> 
        <% TFM_events_nest = eventsummary.Fields.Item("CategoryName").Value
If lastTFM_events_nest <> TFM_events_nest Then 
	lastTFM_events_nest = TFM_events_nest %>
      <table width="100%" height="12" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="17" width="100%">            &nbsp;<b><%=(eventsummary.Fields.Item("CategoryName").Value)%></b><br>
<hr size="1" noshade>
          </td>
        </tr>
      </table>
      <%End If 'End Basic-UltraDev Simulated Nested Repeat %>      
      <table width="100%" border="0" cellspacing="5" cellpadding="3">
        <tr>
          <td valign="top">            <b><%=(eventsummary.Fields.Item("ItemName").Value)%> </b>  - <font size="1"><%= DoDateTime((eventsummary.Fields.Item("EventStartDate").Value), 1, 2057) %></font><br>
            <%		  						  
Dim objimageEvents
strImage = "applications/EventListingManager/images/" & eventsummary.Fields.Item("ImageFileA").Value
Set objimageEvents = CreateObject("Scripting.FileSystemObject")
If objimageEvents.FileExists(Server.MapPath(strImage)) then
%>
            <% if eventsummary.Fields.Item("ImageFileA").Value <> "" then %>
    <div align="center"><img src="applications/EventListingManager/images/<%=(eventsummary.Fields.Item("ImageFileA").Value)%>" width="100"></div>
            <p>
              <% end if ' image check %>
              <% end if ' image check %>              
              <% =(DoTrimProperly((eventsummary.Fields.Item("ItemDesc").Value), 150, 1, 1, "...")) %>
            </p>
          <p align="right">      <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FFFF99">&gt;&gt;&gt;&gt;&gt;&gt;</font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font> </p>     </td>
        </tr>
      </table>      
    </td>
    <%
	startrw = startrw + 1
	eventsummary.MoveNext()
	Wend
	%>
  </tr>
  <%
 numrows=numrows-1
 Wend
 %>
</table>
<%
eventsummary.Close()
%>
