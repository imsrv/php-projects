

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
        <strong>{page_sub_title}</strong>
      </td>
    </tr><tr>

    <!--BeginLostPasswdForm-->
     <form name='lpwdform' action='index.php' method='post' autocomplete="off">
     <input type='hidden' name='s' value='{session_id}'>
     <input type='hidden' name='act' value='login'>
     <input type='hidden' name='code' value='03'>
     <input type='hidden' name='step' value='01'>

      <td height="50" align="center" vAlign="middle" style="border: 1px solid #DDDDDD; background-color: #F0F0F0;">

        <br>
        <strong>{words_lpwd_email}</strong><br>
        <input type='text' name='email' style='width: 200px;'><br><br>
        <input class='submit' type='submit' style='width: 200px;' value=' {words_submit_email} '>
        <br><br>

      </td>

     </form>
    <!--EndLostPasswdForm-->

    <!--BeginLostPasswdSent-->
      <td height="50" align="center" vAlign="middle" style="border: 1px solid #DDDDDD; background-color: #F0F0F0;">

        <br>
        <strong>{words_pwd_email_sent}</strong><br>
        <br><br>
	    <a class="news_lnk" href="{base_url}&act=login">{words_procced_to_login_link_text}</a>
	<br><br>

      </td>
     <!--EndLostPasswdSent-->

    <!--BeginLoginForm-->
     <form name='loginform' action='index.php' method='post' autocomplete="off">
     <input type='hidden' name='s' value='{session_id}'>
     <input type='hidden' name='act' value='login'>
     <input type='hidden' name='code' value='01'>

      <td height="50" align="center" vAlign="middle" style="border: 1px solid #DDDDDD; background-color: #F0F0F0;">

        <br>
        <strong>{words_username}</strong><br>
        <input type='text' name='login' style='width: 200px;'><br>
        <strong>{words_password}</strong><br>
        <input type='password' name='password' style='width: 200px;'><br><br>
        <input type='checkbox' name='remember'>&nbsp;&nbsp;
        <strong>{words_remember_login}</strong><br>
        <br>
        <input class='submit' type='submit' style='width: 200px;' value=' {words_submit_login} '>
        <br><br>
        <a class='news_lnk' href='{base_url}&act=login&code=03&step=00'>{words_lost_passwd_link_text}</a>
        &nbsp;|&nbsp;
        <a class='news_lnk' href='{base_url}&act=reg'>{words_register_link_text}</a>
	<br><br>
      </td>

     </form>
     <!--EndLoginForm-->

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