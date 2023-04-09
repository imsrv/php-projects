<%@ LANGUAGE="VBSCRIPT"%>
<!--#include file="includes/functions.asp"-->
<html>

<head><title>Home <% = GenerateDirectoryTitle(ID) %></title>

<link href="includes/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="includes/functions.js"></script>

</head>

<body topmargin="0" leftmargin="0" bgcolor="#FFFFFF">

<table cellpadding="8" cellspacing="0" width="100%">
<tr><td colspan="2" bgcolor="#F1F1F1" height="70">&nbsp;<img src="<%=CompanyLogo%>"></td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
<tr><td colspan="2" valign="bottom" align="right" bgcolor="#fdfdfd"><% ShowFeatures() %></td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
<tr>
<td class='bgnotile' height='100%' width="175" valign="top" bgcolor="#f5f5f5"><% ShowNewsletterBox() %><br><% ShowAdminLink() %></td>
<td valign="top">

<% 

	With Response

	 ' This displays the various links (What's Hot, What's New, Personalise etc)
	
	.Write "<table width='100%'>"
	.Write "<tr><td align='right'>"
	
		ShowSearchOptions() ' Display the directory search box
	
	.write "</td></tr></table>"
	
	'------------------------
	
	ShowNavigation() ' This displays the yahoo style navigation links
	ShowDirectory() ' This displays the yahoo style directory
	
	'------------------------
	
	if id = "" then ' if homepage then display latest additions / whats hot / favorites

			.Write "<table width='100%'>"
			.Write "<tr><td colspan='2' valign='top'>"
	
				ShowLatestAdditions() ' Show Latest Additions	
	
			.Write "</td></tr>" 
	
			.Write "<tr><td colspan='2'><br>"
	
				.write "<table width='100%' cellspacing='" & CellSpacing & "'" &_
				"cellpadding='" & CellPadding & "'>"		
				.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
				.write "<tr>" 
				.write "<td bgcolor='" & CellBGColor & "'>"
					
						.Write "<table width='100%' cellspacing='0' cellpadding='0'>"
						.Write "<tr>"
						.Write "<td width='50%' class='main_navigation'>Popular Resources</td>"
						.Write "<td width='50%' class='main_navigation'>Favorite Resources - (<a href='search.asp?action=fav' class='frontpage_links'>more...</a>)</td>"
						.Write "</tr>"
						.Write "</table>"				
						
				.Write "</td></tr>"
				.write "<tr><td bgcolor='" & CellSpilt & "'></td></tr>"
				.Write "</table><br>"
				
			.Write "</td></tr>"
				
			.Write "<tr><td width='50%' valign='top'>"
	
				ShowWhatsHot() ' Show Popular Resources
	
			.Write "</td><td width='50%' valign='top'>"
	
				ShowFavorites() ' Show Favorite Resources
			 
			.Write "</td></tr></table>"

	end if
	
	End With

%>

</td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
<tr><td colspan="2" bgcolor="#fdfdfd"><% ShowDirectoryStatisics() %></td></tr>
<tr><td colspan="2" bgcolor="#888888"></td></tr>
</table><br>

</body>
</html>



