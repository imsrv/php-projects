<!-- {{ Ticket Search Results, presented after a user submits a search on the ticket listings page }} -->

<form action="{mainfile}" method=post>
  <table width="100%" border="0" cellspacing="1" align="center">
    <tr> 
      <td> 
        <div align="center"> 
          <table width="482" border="0" cellpadding="0" cellspacing="0">
            <tr> 
              <td> 
                {usernav}
              </td>
            </tr>
            <tr> 
              <td> 
                <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <a href="{mainfile}?do=logout&lang={lang}"><font color="#666666">LOG OUT, {name}</font></a></font></div>
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
      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%searchtext% <b>{noresults}</b> %results%.</font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td> 
        <table width="100%" border="0" cellspacing="1" align="center" height="19">
          <tr class="usertab"> 
            <td width="12%"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%callid%</font></td>
                </tr>
                <tr> 
                  <td height="5"> 
                    <div align="right"><font size="1"><a href="search.pl?action=search&query={query}&field={field}&sort=id&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                      <a href="search.pl?action=search&query={query}&field={field}&sort=id&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
                  </td>
                </tr>
              </table>
            </td>
            <td width="10%"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%status%</font></td>
                </tr>
                <tr> 
                  <td height="5"> 
                    <div align="right"><font size="1"><a href="search.pl?action=search&query={query}&field={field}&sort=status&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                      <a href="search.pl?action=search&query={query}&field={field}&sort=status&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
                  </td>
                </tr>
              </table>
            </td>
            <td width="9%"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%priority%</font></td>
                </tr>
                <tr> 
                  <td height="5"> 
                    <div align="right"><font size="1"><a href="search.pl?action=search&query={query}&field={field}&sort=priority&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                      <a href="search.pl?action=search&query={query}&field={field}&sort=priority&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
                  </td>
                </tr>
              </table>
            </td>
            <td width="45%" class="usertab"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%subject%</font></td>
                </tr>
                <tr> 
                  <td height="5"> 
                    <div align="right"><font size="1"><a href="search.pl?action=search&query={query}&field={field}&sort=subject&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                      <a href="search.pl?action=search&query={query}&field={field}&sort=subject&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
                  </td>
                </tr>
              </table>
            </td>
            <td width="24%"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%whenlogged%</font></td>
                </tr>
                <tr> 
                  <td height="5"> 
                    <div align="right"><font size="1"><a href="search.pl?action=search&query={query}&field={field}&sort=time&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                      <a href="search.pl?action=search&query={query}&field={field}&sort=time&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <div align="center">{results}{bar}</div>
      </td>
    </tr>
    <tr> 
      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td> 
        <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#999999">
      
 <input type="hidden" name="lang" value="{lang}">    <input type="hidden" name="do" value="search">
         %search% </font> 
          <input type="text" name="query" class="tbox" size="10">
          <font color="#999999">IN</font> 
          <select name="select" class="tbox">
            <option value="id">%callid%</option>
            <option value="subject">%subject%</option>
            <option value="comments">%comments%</option>
            <option value="status">%status%</option>
          </select>
          <input type="image" border="0" name="imageField" src="{imgbase}/go.gif" width="20" height="16">
          </b></font></div>
      </td>
    </tr>
  </table>
</form>