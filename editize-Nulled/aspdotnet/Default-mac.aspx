<%@ Page language="VB" AutoEventWireup="True" %>
<%@ Register TagPrefix="SitePoint" Namespace="EditizeDotNet" Assembly="EditizeDotNet" %>
<html>
	<!--
	  -- Editize API for ASP.NET demo (Mac OS 10.1 Compatible)
	  -- by Kevin Yank
	  --
	  -- This example presents a form with only one instance of Editize.
	  -- Due to a bug in Mac OS 10.1, multiple signed Java applets in a
	  -- single page will cause the browser to hang when the security
	  -- dialog box appears. This example therefore uses a single Editize
	  -- applet with a built-in submit button, and should work well on
	  -- Mac OS 10.1. NOTE: Mac OS 10.2 fixes this bug, so multiple
	  -- instances of Editize may safely be used with that version.
	  -->
	<head>
		<title>Editize API for ASP.NET Demo (VB.NET)</title>
		<script runat="server">
			protected Sub FormContent_Changed(sender as object, e as EventArgs)
				' Handle form submissions by displaying the resulting document
				PreviewLabel.Visible = true
				TitleLabel.Visible = true
				ArticleLabel.Visible = true
				SeparatorLabel.Visible = true
				
				TitleLabel.Text = "<h1>" + TitleTextBox.Text + "</h1>"
				ArticleLabel.Text = ArticleEditize.Content
			End Sub
		</script>
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
	</head>
	<body bgcolor="#FFFFFF" text="#000000">
		<form id="Form1" method="post" runat="server">
			<asp:Label Runat="server" ID="PreviewLabel" Visible="False"><p>Here are the documents you created! Scroll down to edit them further if your like.</p></asp:Label>
			<asp:Label Runat="server" ID="TitleLabel" Visible="False" />
			<asp:Label Runat="server" ID="ArticleLabel" CssClass="articletext" Visible="False" />
			<asp:Label Runat="server" ID="SeparatorLabel" Visible="False"><hr></asp:Label>
			<p>This sample form contains an Editize field. It's designed to look like a typical form that you might see in a content management system.</p>
			<h3>Title:</h3>
			<asp:TextBox Runat="server" ID="TitleTextBox" onTextChanged="FormContent_Changed" />
			<h3>Article:</h3>
			<!-- Here's our Editize field. We leave all the features enabled
			  -- and configure a 14 pixel font size, which matches the
			  -- stylesheet setting for the article text size (see above).
			  -- In addition, we provide an image list URL.
			  -- Finally, we enable the integrated submit button to avoid having
			  -- to use a second applet for this (which would hang Mac OS 10.1). -->
			<SitePoint:Editize id="ArticleEditize" runat="server"
				onContentChanged="FormContent_Changed" 
				width="100%" height="400px" basefontface="Verdana" basefontsize="14"
				linkurls="mailto:,http://www.sitepoint.com/article.php/"
				imglisturl="http://www.sitepoint.com/graphics/imglist.php"
				showsubmitbutton="true" submitbuttonlabel="Submit Article" />
		</form>
	</body>
</html>