
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><font class="directory">修復統計統計</font></td>
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
                  <th>常規</th>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#FFFFFF" align="center">
                    <p>上次修復時間：{last_fix}</p>
                  </td>
                </tr>
                <tr> 
                  <td bgcolor="#FFFFFF" height="72"> 
                    <p>本程序用以修復各種原因引起的論壇帖子統計數目不準確的狀態</p>
                    <p>在您確認進行完所有的帖子批處理後，必須運行本程序，以便使論壇的帖子數目統計達到精確。</p>
                    <p>不管您進行了多少次批處理，只要最後運行一次修復就可以。</p>
                    <p>我們沒有把該程序插到批處理中自動完成，以免每次都執行。</p>
                    <p>修復時間可能會比較長，在此期間請耐心等待，不要關閉窗口</p>
                  </td>
                </tr>
                <tr> 
                  <td align="center" bgcolor="#FFFFFF"> 
                    <p>&nbsp;</p>
                    <p>-&gt; 
                      <input type="submit" name="submit" value=" 開始修復 ">
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
