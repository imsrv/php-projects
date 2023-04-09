<!-- {{ This template lists the tickets a user has logged }} -->


<style type="text/css">
 .tbox {
	FONT-SIZE: 11px;
	FONT-FAMILY: Verdana,Arial,Helvetica,sans-serif;
	COLOR: #000000;
	BACKGROUND-COLOR: #ffffff
}
</style> 
<form action="{mainfile}" method=post>
  <table width="100%" border="0" cellspacing="1" align="center">
    <tr> 
      <td> 
        <div align="center"> 
          <table width="482" border="0" cellpadding="0" cellspacing="0">
            <tr> 
              <td> {usernav} </td>
            </tr>
            <tr> 
              <td> 
                <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <a href="{mainfile}?do=logout&lang={lang}"><font color="#666666">%logout%, 
                  {name}</font></a></font></div>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr> 
      <td height="37"> 
        <div align="right"><font face="Verdana" size="1">PAGE: {nav}</font></div>
      </td>
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
                    <div align="right"><font size="1"><a href="{path}&sort=id&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                      <a href="{path}&sort=id&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
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
                    <div align="right"><font size="1"><a href="{path}&sort=status&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                      <a href="{path}&sort=status&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
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
                    <div align="right"><font size="1"><a href="{path}&sort=priority&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                      <a href="{path}&sort=priority&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
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
                    <div align="right"><font size="1"><a href="{path}&sort=subject&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                      <a href="{path}&sort=subject&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
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
                    <div align="right"><font size="1"><a href="{path}&sort=time&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                      <a href="{path}&sort=time&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <div align="center">{listofcalls}</div>
      </td>
    </tr>
    <tr> 
      <td>&nbsp; </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <div align="right"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif">{url}</font></div>
      </td>
    </tr>
    <tr> 
      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Displaying 
        {from}-{to} of {total} results</font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td> 
        <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#999999"> 
          <input type="hidden" name="do" value="search">
          <input type="hidden" name="lang" value="{lang}">
          </font></b></font><font color="#999999">%search% </font> 
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

