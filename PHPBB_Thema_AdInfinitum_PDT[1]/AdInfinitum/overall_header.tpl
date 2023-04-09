<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel="icon" href="templates/AdInfinitum/images/favicon.ico" />
<link href="templates/AdInfinitum/AdInfinitum.css" rel="stylesheet" type="text/css">

<!--
  The AdInfinitum 1.00 Theme for phpBB version 2+
  Created by Mike Lothar
  http://www.mikelothar.com
-->

{META}
{NAV_LINKS}
<title>{SITENAME} ~ {PAGE_TITLE}</title>

<!-- BEGIN switch_enable_pm_popup -->
<script language="Javascript" type="text/javascript">
<!--
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;
	}
//-->
</script>
<!-- END switch_enable_pm_popup -->
<script language="javascript" type="text/javascript"> 
<!-- 
  function resize_images() 
  { 
    for (i = 1; i < document.images.length; i++) 
    { 
      while ( !document.images[i].complete ) 
      { 
        break;
      } 
      if ( document.images[i].width > 500 ) 
      { 
        document.images[i].width = 550; 
      } 
    } 
  } 

//--> 
</script> 
</head>
<body bgcolor="#FFFFFF" text="#e5e5e5" link="#C10003" vlink="#C10003" leftmargin="0" topmargin="0" onload="resize_images()" >

<a name="top"></a>
<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" align="center"> 


	<table width="780" height="100%" cellspacing="0" cellpadding="10" border="0" align="center"> 
	<tr> 
		<td class="bodyline" valign="top">
		
<table width="717" height="231" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><a href="{U_INDEX}"><img src="templates/AdInfinitum/images/top_image.jpg" border="0" alt="{L_INDEX}" vspace="1" /></a></td>
  </tr>
</table>
<table width="715" height="20" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><a href="{U_FAQ}" class="mainmenu">{L_FAQ}</a>&nbsp;&nbsp;<a href="{U_SEARCH}" class="mainmenu">{L_SEARCH}</a>&nbsp;&nbsp;<a href="{U_MEMBERLIST}" class="mainmenu">{L_MEMBERLIST}</a>&nbsp;&nbsp;<a href="{U_GROUP_CP}" class="mainmenu">{L_USERGROUPS}</a>&nbsp;&nbsp;<a href="{U_PROFILE}" class="mainmenu">{L_PROFILE}</a>&nbsp;&nbsp;<a href="{U_PRIVATEMSGS}" class="mainmenu">{PRIVATE_MESSAGE_INFO}</a></td><td align="right"><span class="mainmenu"><a href="{U_LOGIN_LOGOUT}" class="mainmenu">{L_LOGIN_LOGOUT}</a>
	<!-- BEGIN switch_user_logged_out -->
	&nbsp;&nbsp;<a href="{U_REGISTER}" class="mainmenu">{L_REGISTER}</a>
	<!-- END switch_user_logged_out --></span></td>
  </tr>
</table>