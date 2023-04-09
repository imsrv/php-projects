<!-- {{ Submit a new support request from the members area }} -->
<form action="{mainfile}" method=post enctype="multipart/form-data">
  <table width="90%" border="0" cellspacing="1" align="center" cellpadding="1">
    <tr>
      <td height="47" colspan="2"><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">To
            keep track of user satisfaction, we would like you to tell us how
            helpful  this response was.</font></p>
        </td>
    </tr>
    <tr>
      <td height="23">&nbsp;</td>
      <td height="23">&nbsp;</td>
    </tr>
    <tr bgcolor="#336633">
      <td height="23" colspan="2"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;Ticket Details</strong></font></td>
    </tr>
    <tr bgcolor="#F3F3F3">
      <td height="23"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Response ID</font></td>
      <td height="23"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{id}</font></strong></td>
    </tr>
    <tr bgcolor="#F3F3F3">
      <td height="23"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Staff Member</font></td>
      <td height="23"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{author}</font></strong></td>
    </tr>
    <tr>
      <td height="23">&nbsp;</td>
      <td height="23">&nbsp;</td>
    </tr>
    <tr> 
      <td width="24%" height="47" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Rating</strong></font></td>
      <td width="76%" height="47" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="34%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <input type="radio" name="rating" value="5"> 
              <img src="{imgbase}/star_filled.gif" width="14" height="13"><img src="{imgbase}/star_filled.gif" width="14" height="13"><img src="{imgbase}/star_filled.gif" width="14" height="13"><img src="{imgbase}/star_filled.gif" width="14" height="13"><img src="{imgbase}/star_filled.gif" width="14" height="13"></font></td>
            <td width="66%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Very
            Helpful</font></td>
          </tr>
          <tr>
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <input type="radio" name="rating" value="4"> 
              <img src="{imgbase}/star_filled.gif" width="14" height="13"><img src="{imgbase}/star_filled.gif" width="14" height="13"><img src="{imgbase}/star_filled.gif" width="14" height="13"><img src="{imgbase}/star_filled.gif" width="14" height="13"></font></td>
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Helpful</font></td>
          </tr>
          <tr>
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <input type="radio" name="rating" value="3"> 
              <img src="{imgbase}/star_filled.gif" width="14" height="13"><img src="{imgbase}/star_filled.gif" width="14" height="13"><img src="{imgbase}/star_filled.gif" width="14" height="13"></font></td>
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Satisfactory</font></td>
          </tr>
          <tr>
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <input type="radio" name="rating" value="2"> 
              <img src="{imgbase}/star_filled.gif" width="14" height="13"><img src="{imgbase}/star_filled.gif" width="14" height="13"></font></td>
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Not
            Helpful </font></td>
          </tr>
          <tr>
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="radio" name="rating" value="1"> 
              <img src="{imgbase}/star_filled.gif" width="14" height="13"></font></td>
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Poor</font></td>
          </tr>
        </table>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;        </font></td>
    </tr>
    <tr>
      <td valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Name</font></td>
      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <input name="name" type="text" class="gbox" id="name" value="" size="30">
      </font></td>
    </tr>
    <tr> 
      <td width="24%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%comments%</font></td>
      <td width="76%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <textarea name="comments" cols="55" rows="10" class="gbox" id="comments"></textarea>
        </font></td>
    </tr>
    <tr> 
      <td colspan="2"> 
        <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
            <input name="key" type="hidden" id="key" value="{key}">
          <input type="hidden" name="lang" value="{lang}">
          <input name="nid" type="hidden" id="nid" value="{id}">
          <input type="hidden" name="do" value="save_rate">
          <input type="submit" name="Submit" class="forminput" value="%submit%">
          </font></div>
      </td>
    </tr>
  </table>
  <br>
</form>
