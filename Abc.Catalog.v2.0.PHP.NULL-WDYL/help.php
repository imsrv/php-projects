<html>
<head>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="content-language" content="en">
<title>ABC Catalog Help</title>
<STYLE>
<!--
.productName2 {
	color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 20px;
	text-decoration: none;
	font-weight : bold;
}

.loginText
 {
	color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-decoration: none;
	font-weight : bold;
}

a.signatureText {
	color: #666666;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	text-decoration: none;
	font-weight : bold;
}

a.LinkText {
	color: #005177;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	text-decoration: none;
	font-weight : bold;
}

.MessageText {
	color: #000000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 17px;
	text-decoration: none;
	font-weight : bold;
}

.BodyText {
	color: #000000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-decoration: none;
	font-weight : normal;
}

.BodyText2 {
	color: #000000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	text-decoration: none;
	font-weight : bold;
}

-->
</STYLE>
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">


<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#006699">
  <tr>
    <td width="50%" align="left"><font class="productName2">ABC Catalog/User Guide</font></td>
    <td width="50%" align="right">&nbsp;</td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="10" cellspacing="0" class="BodyText">
<tr>
<td>
<p>
ABC Catalog was developped to allow user to promtly create various 
databases like product catalogs, price-lists, specifications and other 
information in table form. 
<p>
As the source of the your data a Microsoft Excel 97/2000/XP file is used. 
<p>
In order to create a catalog you just need to indicate the Excel file 
on your local computer and press <b>[Parse]</b> button.
<p>
You may create as many catalogs as you need by using various Excel files.
<p>
<b>Note:</b>
<br>
Only the first Excel file sheet is being parsed, the next sheets are ignored. 
Cannot be parsed Excel files created on Macintosh.
<p>
<b>Software installation</b>
<br>
All you need to do is to copy all program files into required directory 
on your WEB server. This directory should have the right for writing enabled. 
<p>
<b>System requirements</b>
<br>
You need to have PHP 4.x installed on your WEB server. 


<p>&nbsp;</p>
<font class="MessageText">Change Password</font> 
<hr width="100%" size="1" noshade>
<p>In order to maintain security you'll need to change Login and Password after the first launch of software.
<p>Default values are:
<br>Login: admin
<br>Password: admin
<p>
Open file 'secure.inc' and change the values for variables of login and password.
<pre>
$LOGIN = 'admin';
$PASSWORD = 'admin';
</pre>


<p>&nbsp;</p>
<font class="MessageText">Select Template</font>
<hr width="100%" size="1" noshade>
<p>
If you launch this program for the first time you already have a preloaded 
Temlate. The Template determines the external look of the web-pages that 
are created during the parsing process. The template file is 'table.html'</p>
<p>
In order to customize the design of created pages according to your requirements, you'll need to:
<br>1. In any HTML editor create an HTML file according to your design needs and requirements.
<br>2. By using Select Template command, choose this HTML from your local 
disk. The software includes Demo Template (demo_temlate.html). 
You may wish tio examine its structure and modify it to suit your needs. 
You may also use any other HTML file - but it must always include special tags responsible for page generation.
<p>Here are these tags:
<p><b> &lt%PREVPAGE%&gt </b> - previous page
<p><b> &lt%PAGENO%&gt </b> - current page number 
<p><b> &lt%PAGECOUNT%&gt </b> - total pages 
<p><b> &lt%NEXTPAGE%&gt </b> - next tage 
<p><b> &lt%TABLE%&gt </b>- shows tables with data 
<p><b> &lt%NAVIGATOR%&gt </b> - pages navigation block 
<p>You may use only that tags that you need. 
<p>But the main tag, <b> &lt%TABLE%&gt, </b> used for dispaying data tables, must always be included. 


<p>&nbsp;</p>
<font class="MessageText">Select Excel file</font>
<hr width="100%" size="1" noshade>
<p>You must select an Excel file with information from your local disk.


<p>&nbsp;</p>
<font class="MessageText">Directory name</font>
<hr width="100%" size="1" noshade>
<p>The name of the directory, where HTML pages, created from Excel file, will 
be stored. The directory is created directly on your server.


<p>&nbsp;</p>
<font class="MessageText">Rows on page</font> </p>
<hr width="100%" size="1" noshade>
<p>You may indicate the quantity of rows, which will be accessible on each created HTML page. 
By default there are 30 rows on a page.


<p>&nbsp;</p>
<font class="MessageText">Pages navigator</font>
<hr width="100%" size="1" noshade>
<p>
You may indicate the quatity of elements for navigation on cretated HTML pages. 
By default there are 10 elements per page.

<p>&nbsp;</p>
After all the above mentioned actions have been performed, press the <b>[Parse]</b> button.</p>
<p>
The program will automatically create HTML pages from your Excel file.
<p>
After successful comletion of parsing you'll receive a message, like File 1/index.htm generated from price.xls.</p>


<p>&nbsp;</p>
<font class="MessageText">Change Styles</font>
<hr width="100%" size="1" noshade>
<p>
<b>Table border option.</b> You can change the color and width of data table border. 
<p>
<b>Category colors option.</b> You can change the Font Color and Background Color for category headers of data tables.
<p>
The information is stored in 'style.rc' file.
<p>
The changes will take effect only after all the necessary settings on the main page have been done 
and the <b>[Parse]</b> button have been pushed.


<p>&nbsp;</p>
<font class="MessageText">View Catalog</font>
<hr width="100%" size="1" noshade>
<p>
On this page is displayed the list of catalogs which you've created. 
You are able to view the information from catalog.</p>


</td>
</tr>
</table>


<p>&nbsp;</p>
</body>
</html>
