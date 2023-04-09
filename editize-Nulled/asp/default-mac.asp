<%@ Language="VBScript" %>
<%
	Option Explicit
 
	' Editize API for ASP demo (Mac OS 10.1 Compatible)
	' by Kevin Yank
	'
	' This example presents a form with only one instance of Editize.
	' Due to a bug in Mac OS 10.1, multiple signed Java applets in a
	' single page will cause the browser to hang when the security
	' dialog box appears. This example therefore uses a single Editize
	' applet with a built-in submit button, and should work well on
	' Mac OS 10.1. NOTE: Mac OS 10.2 fixes this bug, so multiple
	' instances of Editize may safely be used with that version.

	' Assign some variables for the values that will be passed by the form
	' submissions in this script.
	Dim title, blurb, article
	title   = Request.Form("title")
	article = Request.Form("article")
%>
<html>
<head>
<title>Editize API for ASP Demo</title>
<!-- The following styles reflect the formatting of the Web site, which
     Editize will be configured to emulate... -->
<style type="text/css">
p, body {
  font-family: Verdana;
  font-size: 10pt;
}
h1 {
  font-family: Arial;
  font-size: 20pt;
}
h3 {
  font-family: Arial;
  font-size: 16pt;
}
.articletext, .articletext p {
  font-family: Verdana;
  font-size: 14px;
}
.highlighted { color: red; }
</style>
<% If Request.QueryString("submit").Count > 0 Then %><base href="http://www.sitepoint.com/" /><% End If %>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<%
	' Determine if the form has been submitted or not.
	If Request.QueryString("submit").Count < 1 Then ' The form has not been submitted
%>
<p>This sample form contains two Editize fields. It's designed to look like a
   typical form that you might see in a content management system.</p>
<form action="http://<%=Request.ServerVariables("HTTP_HOST") & Request.ServerVariables("SCRIPT_NAME")%>?submit=1" method="post">
<h3>Title:</h3>
<input type="text" name="title" value="<%=Server.HTMLEncode(title)%>" size="30" />
<h3>Article:</h3>
<%
	' Here's our Editize field. We leave all the features enabled
	' and configure a 14 pixel font size, which matches the
	' stylesheet setting for the article text size (see above).
	' In addition, we set a base URL for images and provide an image
	' list URL. Finally, we enable the integrated submit button to
	' avoid having to use a second applet for this (which would hang
	' Mac OS 10.1).
	Dim ed
	Set ed = GetObject ("script:" & Server.MapPath ("Editize.wsc"))
	' OR IF REGISTERED: Set ed = Server.CreateObject("Editize.aspapi")
	ed.name = "article"
	ed.width = "100%"
	ed.height = "400"
	ed.basefontface = "Verdana"
	ed.basefontsize = "14"
	Dim links(2)
	links(0) = "mailto:"
	links(1) = "http://www.sitepoint.com/article.php/"
	ed.linkUrls = links
	ed.showsubmitbutton = true;
	ed.submitbuttonlabel = "Submit Article";
	Response.Write(ed.DisplayContent(article))
%>
</form>
<%
	Else ' The form has been submitted
%>
<h1><%=Server.HTMLEncode(title)%></h1>
<h3>Article:</h3>
<div class="articletext"><%=article%></div>

<!-- This form will re-submit the article for editing -->
<form action="http://<%=Request.ServerVariables("HTTP_HOST") & Request.ServerVariables("SCRIPT_NAME")%>" method="POST">
<input type="hidden" name="title" value="<%=Server.HTMLEncode(title)%>" />
<input type="hidden" name="article" value="<%=Server.HTMLEncode(article)%>" />
<input type="submit" name="edit" value="Edit Further" />
</form>
<%
	End If
%>
</body>
</html>
