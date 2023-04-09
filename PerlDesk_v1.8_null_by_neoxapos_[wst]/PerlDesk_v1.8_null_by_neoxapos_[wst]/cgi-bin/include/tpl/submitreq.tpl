<!-- {{ Submit a new support request from the members area }} -->
<form action="{mainfile}" method=post enctype="multipart/form-data">
  <table width="482" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr> 
      <td> 
        {usernav}
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="90%" border="0" cellspacing="0" align="center" cellpadding="2">
    <tr> 
      <td height="20" colspan="2" valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        <font color="#990000"> 
        <ul>
          {error}
        </ul>
        </font></font> </td>
    </tr>
    <tr> 
      <td height="2" colspan="2" valign="top">{form}</td>
    </tr>
    <tr> 
      <td height="2" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email 
        Address</font></td>
      <td height="2" valign="top"><input name="email" type="text" class="gbox" id="email" value="{email}" size="30"></td>
    </tr>
    <tr> 
      <td width="24%" height="2" valign="top">&nbsp;</td>
      <td width="76%" height="2" valign="top">&nbsp;</td>
    </tr>
    <tr> 
      <td rowspan="2" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%priority%</font></td>
      <td width="76%" height="38"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <select name="priority"  class="tbox">
          <option value="1">1 - %urgent%</option>
          <option value="2">2</option>
          <option value="3" selected>3</option>
          <option value="4">4</option>
          <option value="5">5 - %inquiry%</option>
        </select>
        </font></td>
    </tr>
    <tr> 
      <td width="76%"> <table width="95%" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#F5F5F5"> 
            <td width="1%" bgcolor="#FFFFFF"><img src="{imgbase}/blue_topleft.gif" width="13" height="11"></td>
            <td rowspan="3" bgcolor="#D1DAE7"><p><font size="1" face="Geneva, Arial, Helvetica, san-serif">%logtext4%</font></p></td>
            <td width="1%" bgcolor="#FFFFFF"><img src="{imgbase}/blue_topright.gif" width="13" height="11"></td>
          </tr>
          <tr bgcolor="#F5F5F5"> 
            <td width="1%" bgcolor="#D1DAE7">&nbsp;</td>
            <td width="1%" bgcolor="#D1DAE7">&nbsp;</td>
          </tr>
          <tr bgcolor="#F5F5F5"> 
            <td width="1%" bgcolor="#FFFFFF"><img src="{imgbase}/blue_bottomleft.gif" width="13" height="11"></td>
            <td width="1%" bgcolor="#FFFFFF"><img src="{imgbase}/blue_bottomrigt.gif" width="13" height="11"></td>
          </tr>
        </table>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; </font></td>
    </tr>
    <tr> 
      <td width="24%" height="47"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%category%</font></td>
      <td width="76%" height="47"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <select name="category" class="tbox">
                {category}
              
        </select>
        </font></td>
    </tr>
    <tr> 
      <td height="56" colspan="2" valign="middle"> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Request 
        Details</font></strong></td>
    </tr>
    <tr> 
      <td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%subject%</font></td>
      <td width="76%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type="text"  class="tbox" name="subject" size="35" value="{subject}">
        </font></td>
    </tr>
    <tr> 
      <td width="24%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%comments%</font></td>
      <td width="76%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <textarea name="description" class="tbox" cols="55" rows="13">{desc}
</textarea>
        </font></td>
    </tr>
    <tr> 
      <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">File 
        Attachment</font></td>
      <td><input type="file" name="file"></td>
    </tr>
    <tr> 
      <td colspan="2"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
          <input type="hidden" name="lang" value="{lang}">
          <input type="hidden" name="user" value="{uname}">
          <input type="hidden" name="username" value="{uname}">
          <input type="hidden" name="do" value="submit_req">
          <input type="submit" name="Submit" class="forminput" value="%submit%">
          </font></div></td>
    </tr>
  </table>
  <br>
</form>
