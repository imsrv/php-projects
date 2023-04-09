

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">

<html>
<head>

      <title>{page_title} {page_sub_title}</title>

      <meta name="description" content="Secure system is an advances access manager">
      <meta name="rating" content="General">
      <meta name="robots" content="index,follow">
      <meta name="expires" content="never">
      <meta name="distribution" content="Global">
      <meta name="revisit-after" content="7 Days">
      <meta name="publisher" content="Publish">
      <meta name="copyright" content="Something">
      <meta http-Equiv="Content-Type" content="text/html; charset=koi8-r" />

      <style type=text/css media=all>@import url(style.css);</style>
      <link rel="stylesheet" type="text/css" href="style.css">

      <script language='JavaScript' type='text/javascript'>
        function contact_webmaster() {
                admin_email_one = 'friend';
                admin_email_two = 'domain.xxx';
                window.location = 'mailto:'+admin_email_one+'@'+admin_email_two+'?subject=Message from otherdomain.xxx';
        }
      </script>

</head>

<body>

<table width="100%" height="100%" cellSpacing="0" cellPadding="0" border="0" align="center"><tr>
 <td align="center" vAlign="middle">

    <table width="500" cellSpacing="0" cellPadding="0" border="0" align="center"><tr>
      <table width="500" cellSpacing="3" cellPadding="0" border="0" align="center"><tr>
      <td height='20' style='border: 1px solid black; background-color: #aab9d6;' align='center' vAlign='middle'>
        <strong>{words_register_header}</strong>
      </td>
    </tr><tr>
     <td vAlign="middle" style="border: 1px solid #DDDDDD; background-color: #F0F0F0;">
     <br>

    <!--BeginRegDone-->
        <br>
	<center>
        <strong>{words_reg_done}</strong><br>
        <br><br>
	<!--BeginLoginLink-->
	<a class='news_lnk' href='{base_url}&act=login'>{words_proceed_to_login_link_text}</a>
	<!--EndLoginLink-->
	</center>
	<br><br>
    <!--EndRegDone-->

    <!--BeginAuthCode-->
    <br>
    <script language="JavaScript" type="text/javascript">
        function ValidateRegForm() {
         var errors = "";
	    if (document.AUTHFORM.email.value == '') { errors = "Email required"; }
            if (document.AUTHFORM.auth.value == '') { errors = "Auth Code required"; }
            if ( errors ) {
                alert( errors );
		errors = "";
                return false;
            } else {
                return true;
	    }
        }
     </script>

     <form name="AUTHFORM" action="index.php" method="post">
	<input type="hidden" name="s" value="{session_id}">
	<input type="hidden" name="act" value="reg">
	<input type="hidden" name="code" value="activate">
	<input type="hidden" name="step" value="proceed">

	<table width="400" cellSpacing="5" cellPadding="0" border="0" align="center">
	 <tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_email}</strong><br>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="text" name="email" value="{member_email}" style='width: 200px;'><br>
          </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_authcode}</strong><br>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="text" name="auth" value="{member_auth}" style='width: 200px;'><br>
          </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle"></td>
	  <td width="230" align="left" vAlign="middle">
	   <input class="submit" type="submit" value="{words_activate_account}" style='width: 200px;'><br>
          </td>
	 </tr>
	</table>
	</form>
	<br><br>
    <!--EndAuthCode-->

    <!--BeginRegForm-->

    <script language="JavaScript" type="text/javascript">
     function ValidateRegForm() {
            var Check = 0;
            if (document.REGFORM.email.value == '') { errors = "Email required"; }
            if (document.REGFORM.realname.value == '') { errors = "Real name required"; }
	    if (document.REGFORM.name.value == '') { errors = "UserName required"; }
            if ( errors ) {
                alert( errors );
                return false;
            } else {
                return true;
	    }
        }
     </script>

     <form name="REGFORM" action="index.php" method="post">
	<input type="hidden" name="s" value="{session_id}">
	<input type="hidden" name="act" value="reg">
	<input type="hidden" name="step" value="proceed">

	<table width="400" cellSpacing="5" cellPadding="0" border="0" align="center">
	 <tr>
          <td width="170" align="left" vAlign="middle">
	   <strong>{words_desired_username}</strong>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="text" name="name" value="" style='width: 200px;'><br>
	  </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_realname}</strong>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="text" name="realname" value="" style='width: 200px;'><br>
	  </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_email}</strong><br>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="text" name="email" value="" style='width: 200px;'><br>
          </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle"></td>
	  <td width="230" align="left" vAlign="middle">
	   <input class="submit" type="submit" value="{words_register_me}" style='width: 200px;'><br>
          </td>
	 </tr>
	</table>
	</form>
        <br>
     <!--EndRegForm-->

    </tr><tr>
      <td height='20' style='border: 1px solid black; background-color: #aab9d6;' align='center' vAlign='middle'>
        <strong>
	 <a class='my_error_lnk' href='javascript:history.back()'>{words_go_back}</a>
	 &nbsp;&nbsp;|&nbsp;&nbsp;
	 <a class='my_error_lnk' href='javascript:contact_webmaster()'>{words_contact_webmaster}</a>
	 </strong>
      </td>
    </tr></table>

 </td>
</tr></table>

</body>
</html>