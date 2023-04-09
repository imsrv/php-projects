 
<script language="JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<form action="staff.cgi" method="post">
  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
    <tr>
      <td colspan="4"> </td>
    </tr>
    <tr> 
      <td colspan="4" valign="top"> 
        <table width="100%" border="0">
          <tr> 
            <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Search
                  Requests</b></font></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr valign="top"> 
            <td colspan="2" height="47"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">This 
              will perform a search in the areas you specify, this will only return 
              results in your department unless you have GLOBAL help desk access.</font></td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" height="42"> 
              <div align="center"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font>
                <table width="90%" border="0" cellspacing="0" cellpadding="2">
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr> 
                    <td width="22%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Query</font></td>
                    <td width="40%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <input type="text" class="gbox" name="query" size="30">
                      </font></td>
                    <td rowspan="3" valign="top"> 
                      <div align="center"> 
                        <select name="menu" class="gbox" onChange="MM_jumpMenu('parent',this,0)">
                          <option selected>View Tickets By Ownership</option>{staff}
                      
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="22%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Field</font></td>
                    <td width="40%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <select class="gbox" name="select">
                        <option value="id">Call ID</option>
                        <option value="Username">Username</option>
                        <option value="email">Senders Email Address</option>
                        <option value="subject">Subject</option>
                        <option value="priority">Priority</option>
                        <option value="description">Text</option>
                      </select>
                      </font></td>
                  </tr>
                  <tr> 
                    <td width="22%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Results 
                      Per Page</font></td>
                    <td width="40%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <select class="gbox" name="pae">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                      </select>
                      </font></td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr> 
                    <td colspan="2"> 
                      <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=#000000> 
                        <input type="image" border="0" name="imageField" src="{imgbase}/search_button.gif">
                        </font></div>
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font></div>
            </td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" height="42"> 
              <div align="center"> 
                <input type="hidden" name="do" value="sresults">
              </div>
            </td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <br>
  <br>
</form>
<p>&nbsp;</p>
