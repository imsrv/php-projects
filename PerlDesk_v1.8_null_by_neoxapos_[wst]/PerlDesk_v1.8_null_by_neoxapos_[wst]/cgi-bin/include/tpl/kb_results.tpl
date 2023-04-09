<!-- {{ Search Results in the Knowledge Base }} --> 
<form action="kb.pl?search" method=post>
  <table width="90%" border="0" cellspacing="1" align="center">
    <tr>
      <td> 
        <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="{mainfile}?do=register&lang={lang}"><img src="{imgbase}/user_register.gif" width="104" height="19" border="0"></a> 
          <a href="{mainfile}?do=submit_ticket&lang={lang}"><img src="{imgbase}/user_submitreq.gif" width="104" height="19" border="0"></a> 
          <a href="{mainfile}?do=track&lang={lang}"><img src="{imgbase}/user_track.gif" width="104" height="19" border="0"></a> 
          <a href="kb.cgi"> <img src="{imgbase}/user_kb.gif" width="104" height="19" border="0"></a></strong></font><br>
          &nbsp; </div>
      </td>
    </tr>
    <tr> 
      <td> 
        <div align="center"> 
          <table width="482" border="0" cellpadding="0" cellspacing="0">
            <tr> 
              <td> 
                <div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="{mainfile}?do=main&lang={lang}">%helpdesk%</a>: 
                  <a href="kb.cgi?lang={lang}">%kb%</a></font></div>
              </td>
            </tr>
            <tr> 
              <td> 
                <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                  </font></div>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td height="2">
        <table width="90%" border="0" cellpadding="2" align="center">
          <tr> 
            <td> 
              <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="kb.cgi?lang={lang}">KB 
                %search%</a>: {num} %results%</b></font></div>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="90%" border="0" cellspacing="1" cellpadding="2" align="center" bgcolor="#CCCCCC">   
        {results}{bar} </table>
      </td>
    </tr>
  </table>
</form>

