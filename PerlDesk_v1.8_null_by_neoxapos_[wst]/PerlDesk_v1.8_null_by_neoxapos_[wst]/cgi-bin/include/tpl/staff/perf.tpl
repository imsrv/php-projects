 
<script language="JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>


<form action="staff_search.pl" method="post">
  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
          <tr> 
      <td colspan="4"> 
        
      </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" valign="top"> 
        <table width="94%" border="0" align="center">
          <tr> 
            <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>PERFORMANCE</b>: 
              {name}</font></td>
          </tr><tr>
            <td colspan="2">&nbsp;</td>
          </tr><tr> 
            <td colspan="2"> 
              <table width="78%" border="0" cellspacing="1" cellpadding="0" align="center">
                <tr bgcolor="#CCCCCC"> 
                  <td colspan="3"> 
                    <table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <tr bgcolor="#F3F2F1"> 
                        <td> 
                          <table width="95%" border="0" cellspacing="1" cellpadding="4" align="center">
                            <tr> 
                              <td width="77%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>YOUR 
                                AVERAGE RESPONSE TIME</b></font></td>
                            </tr>
                            <tr> 
                              <td width="77%"> 
                                <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{avgresp}</font></p>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr> 
                  <td width="3%">&nbsp;</td>
                  <td width="43%">&nbsp;</td>
                  <td width="54%">&nbsp;</td>
                </tr>
              </table>
              <table width="78%" border="0" cellspacing="1" cellpadding="0" align="center">
                <tr> 
                  <td width="45%">&nbsp;</td>
                  <td width="55%">&nbsp;</td>
                </tr>
                <tr bgcolor="#336633">
                  <td height="19" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td width="1%"><img src="{imgbase}/admin/geen_corner_left.gif" width="18" height="24"></td>
                        <td width="98%"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;Your 
                          Rating </font></td>
                        <td width="1%"><div align="right"><img src="{imgbase}/admin/green_corner.gif" width="18" height="24"></div></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td height="26"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Your Rating</font></td>
                  <td height="26"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{rating}</font></td>
                </tr>
                <tr>
                  <td height="26"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Total Reviews</font></td>
                  <td height="26"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{total_reviews}</font></td>
                </tr>
                <tr>
                  <td height="26">&nbsp;</td>
                  <td height="26">&nbsp;</td>
                </tr>
                <tr bgcolor="#f0f0f0"> 
                  <td width="45%" height="26"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Total 
                    requests closed</font></td>
                  <td width="55%" height="26"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>{closed}</b></font></td>
                </tr>
                <tr bgcolor="#f0f0f0"> 
                  <td width="45%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                  <td width="55%"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">({perc}% 
                    of all closed requests)</font></b></td>
                </tr>
              </table>
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
