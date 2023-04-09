<!-- {{ Reset a forgotten password for logging into the user area }} -->
 
<style type="text/css">
 .bginput {
	FONT-SIZE: 12px;
	FONT-FAMILY: Verdana,Arial,Helvetica,sans-serif;
	COLOR: #000000;
	BACKGROUND-COLOR: #ffffff
}
 .binput {
	FONT-SIZE: 12px;
	FONT-FAMILY: Verdana,Arial,Helvetica,sans-serif;
	COLOR: #000000;
	BACKGROUND-COLOR: #cccccc
}

</style>

<form action="{mainfile}" method=post>
  <table width="90%" border="0" cellspacing="0" align="center" cellpadding="3">
    <tr valign="top"> 
      <td colspan="4" height="36"> 
        <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="{mainfile}?do=register&lang={lang}"><img src="{imgbase}/user_register.gif" width="104" height="19" border="0"></a> 
          <a href="{mainfile}?do=submit_ticket&lang={lang}"><img src="{imgbase}/user_submitreq.gif" width="104" height="19" border="0"></a> 
          <a href="{mainfile}?do=track&lang={lang}"><img src="{imgbase}/user_track.gif" width="104" height="19" border="0"></a> 
          <a href="kb.cgi"> <img src="{imgbase}/user_kb.gif" width="104" height="19" border="0"></a></strong></font></div>
      </td>
    </tr>
    <tr> 
      <td colspan="4" valign="middle"><font size="2"><b><font face="Verdana, Arial, Helvetica, sans-serif"><a href="{baseurl}/{mainfile}?lang={lang}">{title}</a>: 
        %lpassword%</font></b></font></td>
    </tr>
    <tr> 
      <td width="25%" valign="middle">&nbsp;</td>
      <td width="23%" valign="middle">&nbsp;</td>
      <td width="38%" valign="middle">&nbsp;</td>
      <td width="14%" valign="middle">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" valign="middle">
        <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%lpasstext% </font></div>
      </td>
    </tr>
    <tr> 
      <td width="25%" valign="middle">&nbsp;</td>
      <td width="23%" valign="middle">&nbsp;</td>
      <td width="38%" valign="middle">&nbsp;</td>
      <td width="14%" valign="middle">&nbsp;</td>
    </tr>
    <tr> 
      <td width="25%" valign="middle">&nbsp;</td>
      <td width="23%" valign="middle"> 
        <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%username%</font></div>
      </td>
      <td width="38%" valign="middle"> 
        <input type="text" name="username" class="bginput">
      </td>
      <td width="14%" valign="middle">&nbsp;</td>
    </tr>
    <tr> 
      <td width="25%" valign="middle">&nbsp;</td>
      <td width="23%" valign="middle"> 
        <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%email%</font></div>
      </td>
      <td width="38%" valign="middle"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type="text" name="email" class="bginput">
        </font></td>
      <td width="14%" valign="middle">&nbsp;</td>
    </tr>
    <tr> 
      <td width="25%" valign="middle" height="31">&nbsp;</td>
      <td colspan="2" valign="middle" height="31"> 
        <div align="right"></div>
      </td>
      <td width="14%" valign="middle" height="31">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"> 
        <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
          <input type="hidden" name="do" value="setpass">
          <input type="hidden" name="lang" value="{lang}">
          <input type="submit" name="Submit" value="%submit%" class="binput">
          </font></div>
      </td>
    </tr>
  </table>
</form>