
<table width="100%" border="0" align="center">
  <tr> 
    <td> </td>
  </tr>
  <tr>
    <td height="38" valign="top"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr> 
          <td width="91%"> 
            <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="admin.cgi?do=staff"><img src="{imgbase}/admin/list_staff.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=addstaff"><img src="{imgbase}/admin/add_staff.gif" width="104" height="19" border="0"> 
              </a><a href="#" onClick="Popup('admin.cgi?do=pm&to=inbox', 'Window', 425, 400)"><img src="{imgbase}/admin/staff_messaging.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=emailstaff"><img src="{imgbase}/admin/email_all.gif" width="104" height="19" border="0"></a></strong></font></div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td height="20"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      <a href="admin.cgi?do=staff">Staff</a>: Email Staff</b></font></td>
  </tr>
  <tr> 
    <td> 
      <div align="right"><font size="2"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"></font></font></font></div>
    </td>
  </tr>
  <tr> 
    <td> 
      <form name="form1" method="post" action="admin.cgi">
        <table width="100%" border="0" cellspacing="1" cellpadding="5">
          <tr> 
            <td colspan="2"> 
              <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Below, 
                you can send an email to all staff members.</font></div>
            </td>
          </tr>
          <tr> 
            <td width="24%"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">From 
              Email:</font></b></td>
            <td width="76%"> 
              <input type="text" class="gbox" name="email" size="50">
            </td>
          </tr>
          <tr> 
            <td width="24%"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></b></td>
            <td width="76%"> 
              <input type="text" class="gbox" name="subject" size="50">
            </td>
          </tr>
          <tr> 
            <td width="24%" valign="top"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Message:</font></b></td>
            <td width="76%"> 
              <textarea name="message" class="gbox" cols="60" rows="15"></textarea>
            </td>
          </tr>
        </table>
        <p align="center"> 
          <input type="hidden" name="do" value="sendstaff">
          <input type="submit" class="forminput" name="Submit" value="Submit">
        </p>
      </form>
    </td>
  </tr>
</table>
