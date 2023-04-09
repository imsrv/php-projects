
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> <font class="directory">帖子批处理</font> 
            <p>在您确认进行完所有的帖子批处理后，必须运行“<a href="?action=fix_count">修复帖子统计</a>”，以便使论坛的帖子数目统计达到精确。</p>
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
                  <th colspan="2">查询条件 </th>
                </tr>
                <tr> 
                  <td colspan="2" class="type">所属版块</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">如果选择的是一个类别，那么该类下所有的版块都将被查询</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <select name="move_from">
                      <option value="0" selected>所有版块</option>
					  {selection}
                    </select>
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">所属的区</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="radio" name="folder" value="topic">
                    常规区 
                    <input type="radio" name="folder" value="faq">
                    FAQ 
                    <input type="radio" name="folder" value="cream">
                    精华区 
                    <input type="radio" name="folder" value="recovery" checked>
                    回收站</td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">日期选项（‘0’表示不限制）</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">主题发布时间距离现在的天数：</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 不少于 
                    <input type="text" name="thread_min" size="10" value="0">
                    天， 不超过 
                    <input type="text" name="thread_max" size="10" value="0">
                    天</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">最后回复的时间距离现在的天数：</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">不少于 
                    <input type="text" name="post_min" size="10" value="0">
                    天， 不超过 
                    <input type="text" name="post_max" size="10" value="0">
                    天</td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">访问选项</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">主题被浏览的次数：</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">不少于 
                    <input type="text" name="view_min" size="10" value="0">
                    次， 不超过 
                    <input type="text" name="view_max" size="10" value="0">
                    次</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">主题的回复数：</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">不少于 
                    <input type="text" name="reply_min" size="10" value="0">
                    次， 不超过 
                    <input type="text" name="reply_max" size="10" value="0">
                    次 </td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">帖子信息</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">帖子标题</td>
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
                  <td width="24%" height="25" bgcolor="#FFFFFF">是否包括置顶贴</td>
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
      处理<b></b> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                <tr> 
                  <td align="center" class="type">查找结果</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#FFFFFF">一共找到 <font color="#990000"><b><font color="#FF0000">{searchnums}</font></b></font> 
                    条主题，这些主题共有 <b><font color="#FF0000">{replies}</font></b> 条回复，请在下面选择对这些记录的操作方式，或者点击‘返回’不做任何操作。</td>
                </tr>
                <tr> 
                  <td align="center" class="type">处理</td>
                </tr>
                <tr> 
                  <td align="center" bgcolor="#FFFFFF"> 
                    <p> 
                      <input type="radio" name="batch" value="del">
                      删除 
                      <input type="radio" name="batch" value="move" checked>
                      移动到 
                      <select name="move_to">
                        <option value="0" selected>请选择</option>
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
