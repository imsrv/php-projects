

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

 <!--BeginPasswdJava-->
 function disable() {
            if ( document.PASSWDFORM.random_passwd.checked == true ) {
                 document.PASSWDFORM.new_password.value = 'Field disabled';
	         document.PASSWDFORM.new_password.disabled = true;
                 document.PASSWDFORM.new_password_again.value = 'Field disabled';
	         document.PASSWDFORM.new_password_again.disabled = true;
                 document.PASSWDFORM.old_password.focus();
		 return true;
	    } else if ( document.PASSWDFORM.random_passwd.checked == false ) {
                 document.PASSWDFORM.new_password.value = '';
	         document.PASSWDFORM.new_password.disabled = false;
                 document.PASSWDFORM.new_password_again.value = '';
	         document.PASSWDFORM.new_password_again.disabled = false;
                 document.PASSWDFORM.old_password.focus();
		 return false;
	    }
	}
 <!--EndPasswdJava-->

 <!--BeginProfileJava-->
        function ValidateProfileForm() {
            var Check = 0;
            if (document.PROFILEFORM.realname.value == '') { Check = 1; }
	    if (document.PROFILEFORM.email.value == '') { Check = 1; }
            if (Check == 1) {
                alert('Not all fields completed');
                return false;
            }
        }
 <!--EndProfileJava-->
      </script>

</head>

<!--BeginPassBody-->
<body onLoad="return disable()">
<!--EndPassBody-->

<!--BeginOtherBody-->
<body>
<!--EndOtherBody-->

<table width="600" cellSpacing="0" cellPadding="0" border="0" align="center"><tr>
 <td colSpan="2" height="45" align="center" vAlign="middle">
  <img src="{img_url}ns_top.jpg" border="0" alt="Secure"></td>
</tr><tr>
 <td colSpan="2" height="25" style="background-color: #4E4E4E; border: 1px solid #000000;" align="left" vAlign="middle">

  <table width="100%" cellSpacing="0" cellPadding="0" border="0" align="center"><tr>
   <td width="80% align="left" vAlign="middle" style="padding-left: 5px;">
    <span class="top_menu_line">{words_welcome} <strong>{realname}</strong>. {words_last_visit}: {last_login}.</span>
   </td>
   <td width="20%" align="center" vAlign="middle">
    <a class="top_menu_link" href="{base_url}&act=login&code=02">{words_logout}</a>
   </td>
  </tr></table>

 </td>
</tr><tr>
 <td width="150" align="left" vAlign="top" style="background-color: #FFFFFF; padding-left: 10px; padding-right: 10px; border-left: 1px dotted #DDDDDD; border-right: 1px dotted #DDDDDD;">
  <!--BeginMemberMenu-->
   <br>
    <strong>::&nbsp;</strong><a class="common_link" href="{base_url}&act=idx&code=00">{words_menu_anounces}</a><br>
    <strong>::&nbsp;</strong><a class="common_link" href="{base_url}&act=idx&code=01">{words_menu_edit_profile}</a><br>
    <strong>::&nbsp;</strong><a class="common_link" href="{base_url}&act=idx&code=02">{words_menu_edit_password}</a><br>
    <strong>::&nbsp;</strong><a class="common_link" href="{base_url}&act=idx&code=03">{words_menu_accessing_dirs}</a><br>
   <br><br>
  <!--EndMemberMenu-->
 </td>
 <td width="450" style="background-color: #FFFFFF; padding-left: 10px; padding-right: 10px; border-right: 1px dotted #DDDDDD;">
  <br>
  <!--BeginSystemAnounces-->
  <table width="420" cellSpacing="0" cellPadding="0" border="0" align="center"><tr>
   <td style="background-color: #fbfbfb; border: 1px solid #eeeeee;" align="center">
    <strong>:: {words_anounces_header} ::</strong>
   </td>
  </tr><tr>
   <td>
      <br>
	<!--BeginNoAnounces-->
	<center>
	 <span class="anounce_header">{words_no_anounces}</span>
	</center>
	<br>
	<!--EndNoAnounces-->

	<!--BeginAnounceRow-->
        <span class="anounce_header">[ {anounce_date} ]</span><br>
        <a class="anounce_header_link" href="{base_url}&act=idx&code=00&id={anounce_id}">{anounce_header}</a>
        <br><br>
        <!--EndAnounceRow-->

	<!--BeginOneAnounce-->
	<span class="anounce_header">[ {anounce_date} ]</span><br>
        <span class="anounce_header">{anounce_header}</span>
	<p align="justify">
	{anounce_body}
	</p>
        <br>
	<!--EndOneAnounce-->

   </td>
  </tr><tr>
   <td style="background-color: #fbfbfb; border: 1px solid #eeeeee;" align="center">
    <span class=""><<</span>&nbsp;<a class="news_link" href="{base_url}&act=idx&code=00">{words_more_anounces_link}</a>&nbsp;<span class="">>></span>
   </td>
  </tr></table>
  <!--EndSystemAnounces-->

  <!--BeginMemberProfile-->
  <table width="420" cellSpacing="0" cellPadding="0" border="0" align="center"><tr>
   <td style="background-color: #fbfbfb; border: 1px solid #eeeeee;" align="center">
    <strong>:: {words_profile_header} ::</strong>
   </td>
  </tr><tr>
   <td>
	<!--BeginProfiledSaved-->
	<center>
	 <span class="anounce_header">{words_profile_saved}</span>
	</center>
	<br><br>
	<!--EndProfileSaved-->

	<!--BeginProfileForm-->
	<form name="PROFILEFORM" action="index.php" method="post"  onSubmit="return ValidateForm()">
	<input type="hidden" name="s" value="{session_id}">
	<input type="hidden" name="act" value="idx">
	<input type="hidden" name="code" value="01">
	<input type="hidden" name="step" value="proceed">

	<table width="400" cellSpacing="5" cellPadding="0" border="0" align="center">
	 <tr>
          <td width="170" align="left" vAlign="middle">
	   <strong>{words_username}</strong>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="text" name="name" value="{member_name}" style='width: 200px;' disabled><br>
	  </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_realname}</strong>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="text" name="realname" value="{member_realname}" style='width: 200px;'><br>
	  </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_regdate}</strong>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="text" name="regdate" value="{member_regdate}" style='width: 200px;' disabled><br>
	  </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_expire}</strong><br>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="text" name="expire" value="{member_expire}" style='width: 200px;' disabled><br>
          </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_email}</strong><br>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="text" name="email" value="{member_email}" style='width: 200px;'><br>
          </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_interface_lang}</strong><br>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <select size="1" name="lang" style='width: 200px;'>
	    {lang_select_options}
	   </select>
          </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle"></td>
	  <td width="230" align="left" vAlign="middle">
	   <input class="submit" type="submit" value="{words_save_profile}" style='width: 200px;'><br>
          </td>
	 </tr>
	</table>
	</form>
        <br>
        <!--EndProfileForm-->

   </td>
  </tr><tr>
   <td style="background-color: #fbfbfb; border: 1px solid #eeeeee;" align="center">
     &nbsp;
   </td>
  </tr></table>
  <!--EndMemberProfile-->

  <!--BeginChangePasswd-->
  <table width="420" cellSpacing="0" cellPadding="0" border="0" align="center"><tr>
   <td style="background-color: #fbfbfb; border: 1px solid #eeeeee;" align="center">
    <strong>:: {words_change_passwd_header} ::</strong>
   </td>
  </tr><tr>
   <td>

	<!--BeginChangePasswdForm-->
	<form name="PASSWDFORM" action="index.php" method="post">
	<input type="hidden" name="s" value="{session_id}">
	<input type="hidden" name="act" value="idx">
	<input type="hidden" name="code" value="02">
	<input type="hidden" name="step" value="proceed">

	<br>
        <center>
         <span style="color: red; font-weight: 500;">
          {words_passwd_creation_message}
	 </span>
	</center>
	<br>

	<table width="400" cellSpacing="5" cellPadding="0" border="0" align="center">
	 <tr>
          <td width="170" align="left" vAlign="middle">
	   <strong>{words_old_password}</strong>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="password" name="old_password" value="" style='width: 200px;'><br>
	  </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_new_password}</strong>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="password" name="new_password" value="" style='width: 200px;'><br>
	  </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_new_password_again}</strong>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="password" name="new_password_again" value="" style='width: 200px;'><br>
	  </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle">
	   <strong>{words_create_random_passwd}</strong>
	  </td>
	  <td width="230" align="left" vAlign="middle">
	   <input type="checkbox" name="random_passwd" onClick="this.checked = disable()"><br>
	  </td>
	 </tr><tr>
	  <td width="170" align="left" vAlign="middle"></td>
	  <td width="230" align="left" vAlign="middle">
	   <input class="submit" type="submit" value="{words_change_my_passwd}" style='width: 200px;'><br>
          </td>
	 </tr>
	</table>
	</form>
        <br>
        <!--EndChangePasswdForm-->

   </td>
  </tr><tr>
   <td style="background-color: #fbfbfb; border: 1px solid #eeeeee;" align="center">
     &nbsp;
   </td>
  </tr></table>
  <!--EndChangePasswd-->

  <!--BeginAccessingDirs-->
  <table width="420" cellSpacing="0" cellPadding="0" border="0" align="center"><tr>
   <td style="background-color: #fbfbfb; border: 1px solid #eeeeee;" align="center">
    <strong>:: {words_accessing_dirs_header} ::</strong>
   </td>
  </tr><tr>
   <td>
     <br>
        <table width="400" cellSpacing="0" cellPadding="0" border="0" align="center"><tr>
         <td width="200" vAlign="top">
          <strong>{words_username}</strong><br><br>
	  <span style="color: navy; font-size: 14px; font-weight: bold;">{member_name}</span><br><br>
	 </td>
	 <td width="200" align="center" vAlign="top">

                <table width="190" cellSpacing="2" cellPadding="3" border="0" align="center">
                 <!--BeginAccessDirsRow-->
		 <tr>
		  <td style="border: 1px solid #eeeeee;" align="center" vAlign="middle">
                    <a class="news_link" href="{url}" target="_blank">{dirname}</a>
		  </td>
		 </tr>
                 <!--EndAccessDirsRow-->
		</table>

	 </td>
        </tr></table>
     <br>
   </td>
  </tr><tr>
   <td style="background-color: #fbfbfb; border: 1px solid #eeeeee;" align="center">
     &nbsp;
   </td>
  </tr></table>
  <!--EndAccessingDirs-->

  <br>
 </td>
</tr><tr>
<td colSpan="2" height="25" style="padding-left: 5px; background-color: #4E4E4E; border: 1px solid #000000;" align="left" vAlign="middle"></td>
</tr></table>

</body>
</html>
