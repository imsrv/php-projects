
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><font class="directory">Fix Count</font></td>
        </tr>
      </table>
      <br>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                <tr> 
                  <th>Basic</th>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#FFFFFF" align="center">
                    <p>Last update: {last_fix}</p>
                  </td>
                </tr>
                <tr> 
                  <td bgcolor="#FFFFFF" height="72"> 
                    <p>This function is to fix the Threads&amp;Posts count.</p>
                    <p>&nbsp;</p>
                    </td>
                </tr>
                <tr> 
                  <td align="center" bgcolor="#FFFFFF"> 
                    <p>&nbsp;</p>
                    <p>-&gt; 
                      <input type="submit" name="submit" value=" Begin to Fix! ">
                      <input type="hidden" name="action" value="fix_count">
                      <input type="hidden" name="step" value="2">
                      {fix_form} </p>
                  </td>
                </tr>
              </form>
            </table>
          </td>
        </tr>
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
      </table>
      <!-- END threads_list -->
      <p>&nbsp; </p>
    </td>
  </tr>
</table>
