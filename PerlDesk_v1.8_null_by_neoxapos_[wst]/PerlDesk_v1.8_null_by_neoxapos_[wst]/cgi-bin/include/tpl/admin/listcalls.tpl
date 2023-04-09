<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
 
<table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
  <tr>
    <td colspan="4" height="32">
      <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr> 
          <td width="91%">
            <div align="right"> 
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
                <a href="admin.cgi?do=del_range"><img src="{imgbase}/admin/delete_range.gif" width="104" height="19" border="0"></a> 
                <a href="admin.cgi?do=listcalls&amp;status=closed"><img src="{imgbase}/admin/resolved.gif" width="104" height="19" border="0"></a> 
                <a href="admin.cgi?do=listcalls&amp;status=open"><img src="{imgbase}/admin/unresolved.gif" width="104" height="19" border="0"></a></strong></font></p>
            </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td colspan="4" height="32"> 
      <div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
        </font></div>
    </td>
  </tr>
  <tr>
    <td colspan="4"><div align="right">
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr bgcolor="#336633">
            <td height="19" colspan="4">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="1%"><img src="{imgbase}/admin/geen_corner_left.gif" width="18" height="24"></td>
                  <td width="98%"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;Ticket 
                    Filters</font> </td>
                  <td width="1%"><div align="right"><img src="{imgbase}/admin/green_corner.gif" width="18" height="24"></div></td>
                </tr>
              </table></td>
          </tr>
        <tr bgcolor="#efefef">
            <td width="25%" height="34"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Filter 
              by Department</font></td>
            <td width="25%">&nbsp; 
              <select name="select" class="query" onChange="MM_jumpMenu('parent',this,0)">
            <option>Please Select</option>
            
                    {deps}</select></td>
            <td width="25%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Filter 
              by Assignment</font></td>
            <td width="25%">&nbsp; 
              <select name="select2" class="query" onChange="MM_jumpMenu('parent',this,0)">
            <option>Please Select</option>
            
          {staff}
          </select></td>
        </tr>
        <tr>
          <td width="25%">&nbsp;</td>
          <td width="25%">&nbsp;</td>
          <td width="25%">&nbsp;</td>
          <td width="25%">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4"><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{nav}</font></div>
          </td>
          </tr>
      </table>
      &nbsp;    </div></td>
  </tr>
  <tr bgcolor="#5454AB">
    <td height="21" colspan="4" class="toptab"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;
    </strong><font color="#FFFFFF">Requests</font></font></td>
  </tr>
  <tr> 
    <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" align="center" height="19" cellpadding="0">
              <tr> 
                <td width="9%" bgcolor="#D7D7D7"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top"> 
                      <td height="20"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                        ID</font></td>
                    </tr>
                    <tr> 
                      <td height="5"> 
                        <div align="right"><font size="1"> </font></div>
                      </td>
                    </tr>
                  </table>
                </td>
                <td width="17%" bgcolor="#D7D7D7"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top"> 
                      <td height="20"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Logged 
                        By </font></td>
                    </tr>
                    <tr> 
                      <td height="5"> 
                        <div align="right"><font size="1"> </font></div>
                      </td>
                    </tr>
                  </table>
                </td>
                <td width="25%" bgcolor="#D7D7D7"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top"> 
                      <td height="20"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Subject</font></td>
                    </tr>
                    <tr> 
                      <td height="5"> 
                        <div align="right"><font size="1"> </font></div>
                      </td>
                    </tr>
                  </table>
                </td>
                <td width="22%" bgcolor="#D7D7D7"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top"> 
                      <td height="20"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Department</font></td>
                    </tr>
                    <tr> 
                      <td height="5"> 
                        <div align="right"><font size="1"> </font></div>
                      </td>
                    </tr>
                  </table>
                </td>
                <td width="8%" bgcolor="#D7D7D7"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top"> 
                      <td height="20"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Status</font></td>
                    </tr>
                    <tr> 
                      <td height="5"> 
                        <div align="right"><font size="1"> </font></div>
                      </td>
                    </tr>
                  </table>
                </td>
                <td width="19%" bgcolor="#D7D7D7"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top"> 
                      <td height="20"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">When 
                        Logged </font></td>
                    </tr>
                    <tr> 
                      <td height="5"> 
                        <div align="right"> </div>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td> 
            <div align="center">{listcalls}{navbar}</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td colspan="4" valign="top"> 
      <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td> 
            <div align="center"></div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td width="149" valign="top">&nbsp;</td>
    <td width="97">&nbsp;</td>
    <td width="123">&nbsp;</td>
    <td width="131">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="4" valign="top"> 
      <div align="center"><br>
      </div>
    </td>
  </tr>
</table>
  <br>
  <br>
<p>&nbsp;</p>
