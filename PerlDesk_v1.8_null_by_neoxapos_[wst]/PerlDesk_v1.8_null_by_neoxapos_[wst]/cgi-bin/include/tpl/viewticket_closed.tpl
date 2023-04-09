<!-- {{ View a support request that has been closed }} --> 

<form action="track.pl?{trackno}" method="post">
  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
    <tr> 
      <td colspan="4"> 
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
                  <a href="{mainfile}?do=logout&lang={lang}"><font color="#666666">%logout%, {name}</font></a></font></div>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"> 
        <div align="right"> 
          <table width="100%" border="0">
            <tr>
              <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Need 
                to re-open this issue? <a href="{mainfile}?do=reopen&id={trackno}&amp;lang={lang}">click 
                here</a></font></td>
            </tr>
            <tr> 
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="usertab"> 
              <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%request% 
                %details%</font></td>
            </tr>
            <tr bgcolor="#F1F1F8"> 
              <td width="29%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">%callid% 
                </font></td>
              <td width="71%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{trackno}</font></td>
            </tr>
            <tr bgcolor="#F1F1F8"> 
              <td width="29%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%status%</font></td>
              <td width="71%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>RESOLVED</b></font></td>
            </tr>
            <tr bgcolor="#F1F1F8"> 
              <td width="29%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%logged%</font></td>
              <td width="71%" bgcolor="#F1F1F8"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">{date}</font></td>
            </tr>
            <tr bgcolor="#F1F1F8"> 
              <td width="29%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%piority%</font></td>
              <td width="71%" bgcolor="#F1F1F8"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{priority}</font></td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp; </td>
    </tr>
    <tr> 
      <td colspan="4" valign="top"> 
        <table width="99%" border="0" align="center" cellpadding="7">
          <tr> 
            <td class="usertab"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{subject}</font></b></td>
          </tr>
          <tr> 
            <td bgcolor="#F1F1F8"> 
              <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{description}</font></div>
            </td>
          </tr>
        </table>
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td class="usertab"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>%usfollow%</b></font></td>
          </tr>
          <tr> 
            <td> 
              <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{notes}</font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td width="232" valign="top">&nbsp;</td>
      <td width="55">&nbsp;</td>
      <td width="143">&nbsp;</td>
      <td width="154">&nbsp;</td>
    </tr>
  </table>
  <br>
  <br>
</form>
<p>&nbsp;</p>
