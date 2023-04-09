<!-- {{ View a support request and any responses }} --> 

<form action="{mainfile}" method="post">
  <br>
  <table width="84%" border="0" cellspacing="1" align="center" cellpadding="0">
    <tr bgcolor="#336633"> 
      <td colspan="4"> 
        <div align="left">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="1%"><img src="{imgbase}/admin/geen_corner_left.gif" width="18" height="24"></td>
              <td width="98%"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;View 
                Ticket ID {trackno}</font></td>
              <td width="1%"><div align="right"><img src="{imgbase}/admin/green_corner.gif" width="18" height="24"></div></td>
            </tr>
          </table>
          
        </div></td>
    </tr>
    <tr valign="top">
      <td colspan="4" height="38"><table width="100%" border="0" cellpadding="2" cellspacing="1" bordercolorlight="#CCCCCC">
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
          <td width="71%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{priority}</font></td>
        </tr>
      </table></td>
    </tr>
    <tr valign="top"> 
      <td colspan="4" height="38">&nbsp;      </td>
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
        <table width="99%" border="0" align="center" cellpadding="3">
          <tr> 
            <td height="30" bgcolor="#D3D6E4"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#333333">{subject}</font></b></td>
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
          <tr> 
            <td height="25" bgcolor="#D3D6E4"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#333333">%usfollow%</font></b></font></td>
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
      <td width="205" valign="top">&nbsp;</td>
      <td width="135">&nbsp;</td>
      <td width="172">&nbsp;</td>
      <td width="184">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top"><blockquote>
        <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Name</font></div>
      </blockquote></td>
      <td colspan="3"><input name="name" type="text" class="tbox" id="name" value="" size="35"></td>
    </tr>
    <tr> 
      <td width="205" valign="top"> 
        <blockquote>
          <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%addtocall%</font></div>
      </blockquote></td>
      <td colspan="3"> 
        <textarea name="note" class="tbox" cols="55" rows="10"></textarea>
      </td>
    </tr>
    <tr> 
      <td colspan="4" valign="top"> 
        <div align="center"> 
          <input name="key" type="hidden" id="key" value="{key}">
          <input type="hidden" name="ticket" value="{trackno}">
          <input type="hidden" name="do" value="track_reply">
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
