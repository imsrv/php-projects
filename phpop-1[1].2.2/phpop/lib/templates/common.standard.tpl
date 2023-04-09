<html>
<head>
<!-- <link title="phpop styles" rel="stylesheet" type="text/css" href="phpop.css"> -->
<title>phpop: {TITLE}</title>
<!-- $Id: common.standard.tpl,v 1.3 2000/02/19 21:17:53 prenagha Exp $ -->
</head>

<body bgcolor="#FFFFFF">

<table width=95% border=0 cellspacing=0 bgcolor=#99CC99>
 <tr class=std>
  <td valign="top"><h3 class=std>{TITLE}</h3></td>
  <td valign="bottom" align="right">
    <a href="{LIST_URL}"    class=std>list</a>&nbsp;&nbsp;
    <a href="{NEW_URL}"     class=std>new</a>&nbsp;&nbsp;
  </td>
 </tr>
</table>

<table width=95% border=0 cellspacing=0>
 <tr>
  <td>    

{BODY}

  </td>
 </tr>
</table>

<table width=95% border=0 cellspacing=0 bgcolor=#99CC99>
 <tr class=std>
  <td valign="bottom">
   <strong class=std><a href="http://renaghan.com/pcr/phpop.html">phpop</a> at {SERVER_NAME}</strong>
   <br>logged in as {USER_NAME}
  </td>
  <td valign="top" align="right">
    <a href="{LOGOUT_URL}"      class=std>logout</a>
    <br>version {VERSION}
 </tr>
</table>
</body>
</html>
