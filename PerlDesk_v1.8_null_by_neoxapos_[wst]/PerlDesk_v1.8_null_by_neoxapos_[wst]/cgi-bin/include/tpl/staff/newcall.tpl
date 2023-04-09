
<form action="staff.cgi" method="post">
    
  <table width="95%" border="0" align="center">
    <tr> 
        <td colspan="2"> 
      <tr> 
        <td colspan="4"> 
          
        </td>
      </tr>
      <tr> 
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr> 
        
      <td colspan="2" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="4%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><img src="{imgbase}/newcall.gif"> 
              </b></font></td>
            <td width="96%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Submit
            New Request</b></font> </td>
          </tr>
        </table></td>
      </tr>
      <tr> 
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr valign="middle">
        <td colspan="2" height="42">
          
        <table width="90%" border="1" cellspacing="0" cellpadding="0" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td colspan="2" height="25"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Please 
              fill in the below fields to log a new call and assign it to a department.</font></td>
          </tr>
          <tr> 
            <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Username</font></td>
            <td width="72%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="text" style="font-size: 12px" name="username" size="30" value="{username}">
              (<a href="staff.cgi?do=lookup"><font size="1">Lookup</font></a>) 
              </font></td>
          </tr>
        </table>
        &nbsp; 
        <table width="90%" border="1" cellspacing="0" cellpadding="0" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Contact 
              Email</font></td>
            <td width="72%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="text" style="font-size: 12px" name="email2" size="30" value="{email}">
              </font></td>
          </tr>
        </table>
        <br>
          <table width="90%" border="0" cellspacing="1" cellpadding="0" align="center">
            <tr> 
              
            <td height="19">&nbsp; </td>
            </tr>
          </table>
          
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          {form} 
        </table>
          </font><br>
          
        <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td width="19%" height="5"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Assign 
              To</font></td>
            <td width="72%" height="5"> 
              <select name="category" style="font-size: 12px">
                {category}
              
                
              </select>
            </td>
          </tr>
          <tr> 
            <td width="19%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Priority</font></td>
            <td width="72%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="priority" style="font-size: 12px">
                <option value="1">1 - Urgent</option>
                <option value="2">2</option>
                <option value="3" selected>3</option>
                <option value="4">4</option>
                <option value="5">5 - Inquiry</option>
              </select>
              </font> </td>
          </tr>
          <tr> 
            <td width="19%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subject</font></td>
            <td width="72%" height="2"> 
              <input type="text" name="subject" style="font-size: 12px" size="40">
            </td>
          </tr>
          <tr> 
            <td width="19%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Description</font></td>
            <td width="72%"> 
              <textarea name="description" style="font-size: 12px" cols="45" rows="12"></textarea>
            </td>
          </tr>
          <tr>
            <td width="19%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Email 
              User</font></td>
            <td width="72%">
              <input type="checkbox" name="email_user" value="1" checked>
            </td>
          </tr>
        </table>
          
      </td>
      </tr>
      <tr valign="middle"> 
        <td colspan="2" height="42"> 
          <div align="center">
          <table width="90%" border="0" cellspacing="1" cellpadding="0" align="center">
            <tr> 
              <td height="19"> 
                <div align="right">
                  <input type="hidden" name="hidden">
                  <input type="hidden" name="do" value="logsave">
                  <input type="image" border="0" name="imageField" src="{imgbase}/log_request.gif">
                </div>
              </td>
            </tr>
          </table>
          
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan="2">&nbsp;</td>
      </tr>
    </table>
  <br>
  <br>
</form>
<p>&nbsp;</p>
