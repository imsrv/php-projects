<!--#include virtual="/Connections/sitechassismanager.asp" -->
<%
Dim footer
Dim footer_numRows

Set footer = Server.CreateObject("ADODB.Recordset")
footer.ActiveConnection = MM_sitechassismanager_STRING
footer.Source = "SELECT * FROM tblSitePreferences"
footer.CursorType = 0
footer.CursorLocation = 2
footer.LockType = 1
footer.Open()

footer_numRows = 0
%>
<a href="../../admin/SiteChassisManager/admin.asp" target="_blank">CP</a> - &copy;<%=(footer.Fields.Item("CopyrightYear").Value)%>&nbsp; <%=(footer.Fields.Item("DomainName").Value)%>. <%=(footer.Fields.Item("FooterText").Value)%>
<!--#include file="inc_edit_button.asp" -->
<%
footer.Close()
Set footer = Nothing
%>
