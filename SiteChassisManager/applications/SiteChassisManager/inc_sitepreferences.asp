<!--#include virtual="/Connections/sitechassismanager.asp" -->
<%
Dim sitepreferences
Dim sitepreferences_numRows

Set sitepreferences = Server.CreateObject("ADODB.Recordset")
sitepreferences.ActiveConnection = MM_sitechassismanager_STRING
sitepreferences.Source = "SELECT *  FROM tblSitePreferences"
sitepreferences.CursorType = 0
sitepreferences.CursorLocation = 2
sitepreferences.LockType = 1
sitepreferences.Open()

sitepreferences_numRows = 0

Title = (sitepreferences.Fields.Item("SiteTitle").Value)
MetaDescription = (sitepreferences.Fields.Item("MetaDescription").Value)
MeatKeywords = (sitepreferences.Fields.Item("MetaKeywords").Value)

sitepreferences.Close()
Set sitepreferences = Nothing
%>
<HTML>
<HEAD>
<TITLE><%=Title%></TITLE>
<META name="DESCRIPTION" content= "<%=MetaDescription%>">
<META name="KEYWORDS" content= "<%=MetaKeywords%>">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="../../styles.css" rel="stylesheet" type="text/css">