
<form action="admin.cgi" method="post">
  <tr> 
    <table width="100%" border="0">
      <tr> 
        <td colspan="2"> 
      <tr> 
        <td colspan="4"> 
          
        </td>
      </tr>
      <tr valign="middle"> 
        <td colspan="2" height="42"> 
          <table width="80%" border="0" align="center">
            <tr> 
              <td colspan="2"> 
            <tr> 
              <td colspan="2" valign="top" height="192"> 
                <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="admin.cgi?do=staff"><img src="{imgbase}/admin/list_staff.gif" width="104" height="19" border="0"></a> 
                  <a href="admin.cgi?do=addstaff"><img src="{imgbase}/admin/add_staff.gif" width="104" height="19" border="0"> 
                  </a><a href="#" onClick="Popup('admin.cgi?do=pm&to=inbox', 'Window', 425, 400)"><img src="{imgbase}/admin/staff_messaging.gif" width="104" height="19" border="0"></a> 
                  <a href="admin.cgi?do=emailstaff"><img src="{imgbase}/admin/email_all.gif" width="104" height="19" border="0"></a></strong></font> 
                </div>
                <table width="100%" border="0" cellpadding="2" cellspacing="1">
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">( <a href="admin.cgi?do=del_pre&id={id}">delete
                    template</a> ) </font></div></td>
                  </tr>
                  <tr> 
                    <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF"><b><font color="#000000">Edit 
                      Pre-Defined Response </font></b></font></td>
                  </tr>
                  <tr> 
                    <td valign="middle" height="42"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></td>
                    <td width="71%" height="42"> 
                      <input type="text" class="gbox" name="subject" size="40" value="{subject}">
                    </td>
                  </tr>
                  <tr> 
                    <td valign="top" height="198"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Content: 
                      </font></td>
                    <td width="71%" height="198" valign="top"> 
                      <textarea class="gbox" name="content" cols="60" rows="15">{content}</textarea>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr valign="middle"> 
              <td colspan="2" height="50"> 
                <div align="center"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="id" value="{id}">
                  <input name="do" type="hidden" id="do" value="editsave">
                  </font> 
                  <input type="submit" name="Submit" value="Edit This Response Template">
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  <br>
  <br>
</form>
<p>&nbsp;</p>
