<!-- {{ View a support request and any responses }} --> 

<form action="{mainfile}" method="post">
  <table width="84%" border="0" cellspacing="0" align="center" cellpadding="2">
    <tr> 
      <td colspan="4"> 
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
          <br>
        </div>
      </td>
    </tr>
    <tr valign="top"> 
      <td colspan="4" height="38"> 
        <table width="95%" border="0" cellspacing="1" cellpadding="3" align="center">
          <tr> 
            <td colspan="3"> 
              <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><a href="{mainfile}?do=print&amp;cid={trackno}&lang={lang}"><font color="#000000">PRINT 
                REQUEST</font></a> | <a href="{mainfile}?do=emailreq&amp;cid={trackno}&lang={lang}"><font color="#000000">EMAIL 
                REQUEST</font></a> | <a href="{mainfile}?do=closereq&id={trackno}&lang={lang}"><font color="#000000">CLOSE 
                THIS TICKET</font></a></font></div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr class="usertab"> 
      <td colspan="4" height="11"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#333333">%request% 
        %details% </font></b></font> </td>
    </tr>
    <tr> 
      <td colspan="4"> 
        <table width="100%" border="0" cellpadding="2" cellspacing="1" bordercolorlight="#CCCCCC">
          <tr bgcolor="#F1F1F1"> 
            <td width="29%" height="5"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">%callid%</font></td>
            <td width="71%" height="5"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{trackno}</font></td>
          </tr>
          <tr bgcolor="#F1F1F1"> 
            <td width="29%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%status%</font></td>
            <td width="71%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{status}</font></td>
          </tr>
          <tr bgcolor="#F1F1F1"> 
            <td width="29%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%logged%</font></td>
            <td width="71%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">{date}</font></td>
          </tr>
          <tr bgcolor="#F1F1F1"> 
            <td width="29%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%priority%</font></td>
            <td width="71%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{priority} 
              <font size="1">&nbsp;&nbsp;[<a href="{mainfile}?do=changepri&cid={trackno}&lang={lang}">%change%</a>] 
              </font></font></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td colspan="4"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="4">
        <table width="100%" border="0" cellpadding="2" cellspacing="1" bordercolorlight="#CCCCCC">
          <tr bgcolor="#F1F1F1"> 
            <td width="29%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Elapsed 
              Time</font></td>
            <td width="71%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{ttime}</font></td>
          </tr>
          <tr bgcolor="#F1F1F1"> 
            <td width="29%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Since 
              Last Action</font></td>
            <td width="71%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{ltime}</font></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td colspan="4" height="3">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" valign="top"> 
        <table width="99%" border="0" align="center" cellpadding="7">
          <tr class="usertab"> 
            <td><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#333333">{subject}</font></b></td>
          </tr>
          <tr bgcolor="#F1F1F1"> 
            <td> 
              <table width="100%" border="0" cellpadding="3">
                <tr> 
                  <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{description}</font> 
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr class="usertab"> 
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#333333">%usfollow%</font></b></font></td>
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
      <td width="240" valign="top">&nbsp;</td>
      <td width="131">&nbsp;</td>
      <td width="185">&nbsp;</td>
      <td width="196">&nbsp;</td>
    </tr>
    <tr> 
      <td width="240" valign="top"> 
        <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%addtocall%</font></div>
      </td>
      <td colspan="3"> 
        <textarea name="note" class="tbox" cols="55" rows="10"></textarea>
      </td>
    </tr>
    <tr> 
      <td colspan="4" valign="top"> 
        <div align="center"> 
          <input type="hidden" name="ticket" value="{trackno}">
          <input type="hidden" name="do" value="addnote">
          <input type="hidden" name="id" value="{trackno}">
          <input type="hidden" name="lang" value="{lang}">
          <input type="submit" name="Submit" class="forminput" value="%submit%">
          <br>
        </div>
      </td>
    </tr>
    <tr> 
      <td colspan="4"> 
        <div align="right"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"></font></div>
      </td>
    </tr>
  </table>
  <br>
  <br>
</form>
<p>&nbsp;</p>
