<html>

<head>
<title>perlDesk Administration</title>

<style type="text/css">
BODY {
background: #FFFFFF;
margin-bottom:0px; 
margin-left:0px; 
margin-right:0px; 
margin-top:0px;
padding: 0px;
SCROLLBAR-BASE-COLOR: #2F3D50;
SCROLLBAR-ARROW-COLOR: #FFFFFF;


}

A:active  { COLOR: #006699; TEXT-DECORATION: none }
A:visited { COLOR: #334A9B; TEXT-DECORATION: none }
A:hover   { COLOR: #334A9B; TEXT-DECORATION: underline }
A:link    { COLOR: #334A9B; TEXT-DECORATION: none }
 
  .query          { BORDER-RIGHT: #666666 1px solid; PADDING-RIGHT: 2px; BORDER-TOP: #666666 1px solid; PADDING-LEFT: 2px; FONT-SIZE: 11px; PADDING-BOTTOM: 3px; BORDER-LEFT: #666666 1px solid; PADDING-TOP: 3px; BORDER-BOTTOM: #666666 1px solid }
  .title, h1, h2  { font-size: 23px; font-weight: bold; font-family: Trebuchet MS,Verdana, Arial, Helvetica, sans-serif; text-decoration: none; line-height : 120%; color : #000066; }
  .forminput      { font-size: 8pt; background-color: #CCCCCC; font-family: verdana, helvetica, sans-serif; vertical-align:middle }
  .tbox           { FONT-SIZE: 11px; FONT-FAMILY: Verdana; COLOR: #000000; BACKGROUND-COLOR: #ffffff }
  .gbox           { FONT-SIZE: 11px; FONT-FAMILY: Verdana; COLOR: #000000; BACKGROUND-COLOR: #F7F7F7 }
.normal {
	font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.small {
	font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: bold;
}
A.nav:link { COLOR: #202E3E;
                    TEXT-DECORATION: none;}
A.nav:visited { COLOR: #202E3E;
                    TEXT-DECORATION: none;}
A.nav:active { COLOR: #202E3E;
                     TEXT-DECORATION: none;}
A.nav:hover { COLOR: #FF9400;
                      TEXT-DECORATION: none;}
.search {
	FONT-SIZE: 10px;
	FONT-FAMILY: Tahoma,Arial,Helvetica,sans-serif;
	COLOR: #F6F6F6;
    border-top:1px solid;
    border-bottom:1px solid;
    border-left: 1px solid;
    border-right:1px solid;
    BORDER-COLOR: #FFFFFF;
    width: 125px;
    height: 17px;
	BACKGROUND-COLOR: #3E4462
}
</style>
<script language="javascript"> 
<!-- 

if (document.images) { 
image1on = new Image(); 
image1on.src = "{imgbase}/users1.gif"; 
image1off = new Image(); 
image1off.src = "{imgbase}/users.gif";  
image2on = new Image(); 
image2on.src = "{imgbase}/staff1.gif"; 
image2off = new Image(); 
image2off.src = "{imgbase}/staff.gif";
image3on = new Image(); 
image3on.src = "{imgbase}/requests1.gif"; 
image3off = new Image(); 
image3off.src = "{imgbase}/requests.gif";
image4on = new Image(); 
image4on.src = "{imgbase}/settings1.gif"; 
image4off = new Image(); 
image4off.src = "{imgbase}/settings.gif";          
}  

function changeImages() { 
if (document.images) { 
for (var i=0; i<changeImages.arguments.length; i+=2) { 
document[changeImages.arguments[i]].src = eval(changeImages.arguments[i+1] + ".src"); 
} 
} 
} 

 function Popup(url, window_name, window_width, window_height) 
  { 
    settings="toolbar=no,location=no,directories=no,"+ 
             "status=no,menubar=no,scrollbars=yes,"+ 
             "resizable=yes,width="+window_width+",height="+window_height; 
    NewWindow=window.open(url,window_name,settings); 
  }


  var checkflag = "false";
      
	function check(field) 
	 {
       if (checkflag == "false") 
	      {
                for (i = 0; i < field.length; i++)       {  field[i].checked = true;   }
                checkflag = "true";
                return "Uncheck All"; 
		  }
           else {
                    for (i = 0; i < field.length; i++)  {  field[i].checked = false;  }
                      checkflag = "false";
                      return "Check All"; 
			    }
      }


function MM_jumpMenu(targ,selObj,restore){ 
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

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
-->

</script> 
</head>

<body>

<a name="top"></a>

<!-- Main Outline Table Start -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="100%">
<!-- //Main Outline Table Start -->


<!-- Header Outline Table Start -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="100%" background="{imgbase}/toprightbg.gif">
<!-- //Header Outline Table Start -->


<!-- Header Start -->
    <table border="0" cellpadding="0" cellspacing="0" width="758">
      <tr>
        <td width="100%" background="{imgbase}/topleftbg.gif">
        <p align="right">
        <img border="0" src="{imgbase}/topleftedge.gif" width="40" height="36"><a onmouseover="changeImages('image1', 'image1on')" onmouseout="changeImages('image1', 'image1off')" href="admin.cgi?do=users"><img name="image1" border="0" src="{imgbase}/users.gif" width="149" height="36" alt="Users"></a><a onmouseover="changeImages('image2', 'image2on')" onmouseout="changeImages('image2', 'image2off')" href="admin.cgi?do=staff"><img name="image2" border="0" src="{imgbase}/staff.gif" width="149" height="36" alt="Staff"></a><a onmouseover="changeImages('image3', 'image3on')" onmouseout="changeImages('image3', 'image3off')" href="admin.cgi?do=listcalls&status=open"><img name="image3" border="0" src="{imgbase}/requests.gif" width="149" height="36" alt="Requests"></a><a onmouseover="changeImages('image4', 'image4on')" onmouseout="changeImages('image4', 'image4off')" href="admin.cgi?do=settings"><img name="image4" border="0" src="{imgbase}/settings.gif" width="149" height="36" alt="Settings"></a><img border="0" src="{imgbase}/toprightedge.gif" width="43" height="36"></td>
      </tr>
    </table>
<!-- Header End -->

<!-- Header Outline Table End -->    
    </td></tr></table>
<!-- //Header Outline Table End -->


<!-- Search Area Table Outline Start -->
     <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="100%" background="{imgbase}/searchbg.gif">
<!-- //Search Area Table Outline Start -->

<!-- Search Area -->
    <table border="0" cellpadding="4" cellspacing="0" width="758" background="{imgbase}/searchbg.gif">
      <tr>
      <form action="admin.cgi" method="post"> <td width="50%">
        <input name="query" type="text" class="search" id="query" size="15">&nbsp;
        <select name="area" class="search">
          <option value="username">Username</option>
          <option value="name">Name</option>
          <option value="email">E-Mail</option>
          <option value="url">URL</option>
          <option value="company">Company</option>
        </select>
        <input type="image" border="0" src="{imgbase}/go1.gif" width="10" height="10">
        <font color="#333333" size="2" face="Trebuchet MS, Verdana, Arial"><strong><font color="#000000">
        <input name="do" type="hidden" id="do" value="search_clients">
        </font></strong></font></td>
        <td width="50%">
        <p align="right"><b><font class="small"><font color="#FFFFFF"> |</font>&nbsp; <a href="admin.cgi?do=main"><font color="#000000">Main</font></a>&nbsp; <font color="#FFFFFF"></font><font color="#FFFFFF">|</font>&nbsp; 
                    <a href="admin.cgi?do=announcements"><font color="#000000">Announcements</font></a>&nbsp;
        <font color="#FFFFFF">|</font>  &nbsp;<a href="admin.cgi?do=stats"><font color="#000000">Statistics</font></a>&nbsp;<font color="#FFFFFF">|</font>&nbsp; <a href="admin.cgi?do=logout"><font color="#000000">Logout </font></a>&nbsp; <font color="#FFFFFF"></font> <font color="#FFFFFF">|</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font></b> </td>
     </form> </tr>
    </table>
<!-- //Search Area -->

<!-- Search Area Table Outline End -->
</td></tr></table>
<!-- //Search Area Table Outline End -->
    
    <!-- Shadow Area -->
    <!-- //Shadow Area -->
    
    
<!-- Main Content Table -->

      <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="24">&nbsp;</td>
        </tr>
        <tr> 
          <td> 
            <div align="center">{CONTENT}</div>
          </td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>
            <hr size="1">
          </td>
        </tr>
        <tr> 
          <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&copy; 
            PerlDesk 2003<font color="#666666"> ( www.perldesk.com) </font></font></td>
        </tr>
        <tr>
          <td>
            <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#666666">PerlDesk 
              1.8 Revision 0</font></div>
          </td>
        </tr>
      </table>
      <!-- //Main Content Table -->
    
    <!-- Footer Top -->
    <!-- //Footer Nav Area Outline End -->
    
    <!-- Footer Bottom -->
    <!-- //Footer Bottom -->
    
    <!-- Main Table Outline Close -->
    </td>
  </tr>
</table>
<!-- //Main Table Outline Close -->

<p>&nbsp;</p>

</body>

</html>