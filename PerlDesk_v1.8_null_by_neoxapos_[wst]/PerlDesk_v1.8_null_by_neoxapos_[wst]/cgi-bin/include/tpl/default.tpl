<html>
<head>
<title>{title} - powered by Your Site Name Here</title>
<STYLE type=text/css>
A:active  {	COLOR: #006699; TEXT-DECORATION: none      }
A:visited { COLOR: #334A9B; TEXT-DECORATION: none      }
A:hover   { COLOR: #334A9B; TEXT-DECORATION: underline }
A:link    { COLOR: #334A9B; TEXT-DECORATION: none      }

 .title, h1, h2	{ font-size: 23px; font-weight: bold; font-family: Trebuchet MS,Verdana, Arial, Helvetica, sans-serif; text-decoration: none; line-height : 120%; color : #000066; }
 .forminput     { font-size: 8pt; background-color: #CCCCCC; font-family: verdana, helvetica, sans-serif; vertical-align:middle }
 .tbox          { FONT-SIZE: 11px; FONT-FAMILY: Verdana,Arial,Helvetica,sans-serif; COLOR: #000000; BACKGROUND-COLOR: #ffffff }
 .gbox          { FONT-SIZE: 11px; FONT-FAMILY: Verdana; COLOR: #000000; BACKGROUND-COLOR: #F7F7F7 }

</STYLE>
<link rel="stylesheet" href="{imgbase}/style.css">
</head>
<body bgcolor="#FFFFFF" text="#000000">


<!-- BEGIN TEMPLATE JAVASCRIPT CODE - DO NOT REMOVE - -->

	<script language="javascript">
      function DisableForm (formname)  
	  	<!-- Prevent The Form being submitted twice -->
	      {
                browser = new String(navigator.userAgent);
			    if (browser.match(/IE/g))  { for (i=1; i<formname.elements.length; i++)   {   if (formname.elements[i].type == 'submit')  {  formname.elements[i].disabled = true;  } } }
		        formname.submit();
		  }
		  
      function Disable (formname)  
	      {
		      for (i=1; i<formname.elements.length; i++)   {   if (formname.elements[i].type == 'text')  {  formname.elements[i].onFocus = blur;  }  }
		  }
	</script>
	
<!-- END TEMPLATE JAVASCRIPT CODE - DO NOT REMOVE - -->


<table width="625" border="0" cellspacing="1" cellpadding="0" align="center">
  <tr> 
    <td>      <div align="left"> 
        <table width="100%" border="0" cellpadding="3">
          <tr>
            <td width="55%"><a href="pdesk.cgi"><img src="{logo}" border="0"></a></td>
            <td width="45%">
              <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></div>
            </td></tr>
        </table>
      </div>
    </td>
  </tr>
  <tr> 
    <td width="10%" height="18" valign="top"> 
      <table width="90%" border="0" cellspacing="1" cellpadding="0" align="center">
        <tr> 
          <td width="96%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="96%"> 
            <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{CONTENT}</font></div>
          </td>
        </tr>
        <tr> 
          <td width="96%">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
  <a href="">Powered by PerlDesk</a><br>
  Copyright &copy; 2003 <a href="">PerlDesk</a></font></p>
<p align="center">&nbsp;</p>
</body>
</html>
