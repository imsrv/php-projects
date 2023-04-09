
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><font class="directory">修复统计统计</font></td>
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
                  <th>常规</th>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#FFFFFF" align="center">
                    <p>上次修复时间：{last_fix}</p>
                  </td>
                </tr>
                <tr> 
                  <td bgcolor="#FFFFFF" height="72"> 
                    <p>本程序用以修复各种原因引起的论坛帖子统计数目不准确的状态</p>
                    <p>在您确认进行完所有的帖子批处理后，必须运行本程序，以便使论坛的帖子数目统计达到精确。</p>
                    <p>不管您进行了多少次批处理，只要最后运行一次修复就可以。</p>
                    <p>我们没有把该程序插到批处理中自动完成，以免每次都执行。</p>
                    <p>修复时间可能会比较长，在此期间请耐心等待，不要关闭窗口</p>
                  </td>
                </tr>
                <tr> 
                  <td align="center" bgcolor="#FFFFFF"> 
                    <p>&nbsp;</p>
                    <p>-&gt; 
                      <input type="submit" name="submit" value=" 开始修复 ">
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
