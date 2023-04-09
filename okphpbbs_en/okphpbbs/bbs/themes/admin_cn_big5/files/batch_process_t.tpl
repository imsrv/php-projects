
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> <font class="directory">帖子批處理</font> 
            <p>在您確認進行完所有的帖子批處理後，必須運行「<a href="?action=fix_count">修復帖子統計</a>」，以便使論壇的帖子數目統計達到精確。</p>
          </td>
        </tr>
      </table>
      <br>
      <!-- BEGIN find_threads -->
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                <tr> 
                  <th colspan="2">查詢條件 </th>
                </tr>
                <tr> 
                  <td colspan="2" class="type">所屬版塊</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">如果選擇的是一個類別，那麼該類下所有的版塊都將被查詢</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <select name="move_from">
                      <option value="0" selected>所有版塊</option>
					  {selection}
                    </select>
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">所屬的區</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="radio" name="folder" value="topic">
                    常規區 
                    <input type="radio" name="folder" value="faq">
                    FAQ 
                    <input type="radio" name="folder" value="cream">
                    精華區 
                    <input type="radio" name="folder" value="recovery" checked>
                    回收站</td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">日期選項（『0』表示不限制）</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">主題發佈時間距離現在的天數：</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 不少於 
                    <input type="text" name="thread_min" size="10" value="0">
                    天， 不超過 
                    <input type="text" name="thread_max" size="10" value="0">
                    天</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">最後回復的時間距離現在的天數：</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">不少於 
                    <input type="text" name="post_min" size="10" value="0">
                    天， 不超過 
                    <input type="text" name="post_max" size="10" value="0">
                    天</td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">訪問選項</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">主題被瀏覽的次數：</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">不少於 
                    <input type="text" name="view_min" size="10" value="0">
                    次， 不超過 
                    <input type="text" name="view_max" size="10" value="0">
                    次</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">主題的回複數：</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">不少於 
                    <input type="text" name="reply_min" size="10" value="0">
                    次， 不超過 
                    <input type="text" name="reply_max" size="10" value="0">
                    次 </td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">帖子信息</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">帖子標題</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="text" name="subject" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">帖子作者</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="text" name="author" size="15">
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">是否包括置頂貼</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="radio" name="top_thread" value="1">
                    包括， 
                    <input type="radio" name="top_thread" value="0" checked>
                    不包括</td>
                </tr>
                <tr> 
                  <td colspan="2" align="center" bgcolor="#FFFFFF"> 
                    <input type="submit" name="Submit" value="Submit">
                    <input type="hidden" name="action" value="batch_process_t">
                    <input type="hidden" name="step" value="2">
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
      <!-- END find_threads -->
      <!-- BEGIN threads_list -->
      處理<b></b> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                <tr> 
                  <td align="center" class="type">查找結果</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#FFFFFF">一共找到 <font color="#990000"><b><font color="#FF0000">{searchnums}</font></b></font> 
                    條主題，這些主題共有 <b><font color="#FF0000">{replies}</font></b> 條回復，請在下面選擇對這些記錄的操作方式，或者點擊『返回』不做任何操作。</td>
                </tr>
                <tr> 
                  <td align="center" class="type">處理</td>
                </tr>
                <tr> 
                  <td align="center" bgcolor="#FFFFFF"> 
                    <p> 
                      <input type="radio" name="batch" value="del">
                      刪除 
                      <input type="radio" name="batch" value="move" checked>
                      移動到 
                      <select name="move_to">
                        <option value="0" selected>請選擇</option>
     {move_to}
                      
                      </select>
                    </p>
                    <p> 
                      <input type="submit" name="Submit2" value="Submit">
                      <input type="hidden" name="action" value="batch_process_t">
                      <input type="hidden" name="step" value="4">
                      <input type="hidden" name="searchid" value="{searchid}">
                      <input type="hidden" name="thread_table" value="{thread_table}">
                      <input type="hidden" name="post_table" value="{post_table}">
                      <input type="hidden" name="folder" value="{folder}">
                      <input type="hidden" name="searchnums" value="{searchnums}">
                      [<a href="?action=batch_process_t">返回</a>]</p>
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
