<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>bookmarker: {TITLE}</title>
<!-- $Id: common.standard.tpl,v 1.16 2000/03/24 17:51:18 prenagha Exp $ -->

<style>
<!--
 html,body { background-color: white;  
             font-family: "Arial, Helvetica"; }

 a:LINK    { color: blue; }
 a:VISITED { color: #000066; }
 a:ACTIVE  { color: red; }
 a:HOVER   { color: black; }

 table.hdr { background-color: #5B68A6;
             color: white; }
 big.hdr    { color: white; }
 small.hdr  { color: #CCCCCC; }

 a.hdr:LINK    { color: #CCCCCC; }
 a.hdr:VISITED { color: #CCCCCC; }
 a.hdr:ACTIVE  { color: #CCCCCC; }
 a.hdr:HOVER   { color: #000000; }

-->
</style>

<script type="text/javascript">
<!-- start Javascript
  function pop_tree() {
    window.open("{TREE_URL}", "treeview", "scrollbars,resizable,height=640,width=250");
  }
{MSIE_JS}
// end Javascript -->
</script>
</head>

<body bgcolor="#FFFFFF">

<table width=95% border=0 cellspacing=0 bgcolor=#CCCCCC class=hdr>
 <tr>
  <td valign="top"    align="left"><strong><big class=hdr>{TITLE}</big></strong></td>
  <td valign="bottom" align="right">
    <a class=hdr href="{START_URL}"><img width=24 height=24 src="{IMAGE_URL_PREFIX}home.{IMAGE_EXT}" border=0 alt="Home"></a>
    <a class=hdr href="javascript:pop_tree()"><img width=24 height=24 src="{IMAGE_URL_PREFIX}tree.{IMAGE_EXT}" border=0 alt="Tree View"></a>
    <a class=hdr href="{LIST_URL}"><img width=24 height=24 src="{IMAGE_URL_PREFIX}list.{IMAGE_EXT}" border=0 alt="List View"></a>
    <a class=hdr href="{CREATE_URL}"><img width=24 height=24 src="{IMAGE_URL_PREFIX}create.{IMAGE_EXT}" border=0 alt="New"></a>
    <a class=hdr href="{SEARCH_URL}"><img width=24 height=24 src="{IMAGE_URL_PREFIX}search.{IMAGE_EXT}" border=0 alt="Search"></a>
    <a class=hdr href="{FAQ_URL}"><img width=24 height=24 src="{IMAGE_URL_PREFIX}help.{IMAGE_EXT}" border=0 alt="Help"></a>
    <a class=hdr href="{USER_URL}"><img width=24 height=24 src="{IMAGE_URL_PREFIX}user.{IMAGE_EXT}" border=0 alt="User Preferences"></a>
    {LOGOUT_HTML}
  </td>
 </tr>
</table>

<table width=95% border=0 cellspacing=0>
{MESSAGES}
 <tr>
  <td>    

{BODY}

  </td>
 </tr>
 <tr>
   <td align=right valign=bottom><hr>
   <small><a href="http://renaghan.com/pcr/bookmarker.html">bookmarker</a> {VERSION} at {SERVER_NAME} {NAME_HTML}</small>
   </td>
 </tr>
</table>
</body>
</html>
