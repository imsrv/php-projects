
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> <font class="directory">����������</font> 
            <p>����ȷ�Ͻ��������е�����������󣬱������С�<a href="?action=fix_count">�޸�����ͳ��</a>�����Ա�ʹ��̳��������Ŀͳ�ƴﵽ��ȷ��</p>
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
                  <th colspan="2">��ѯ���� </th>
                </tr>
                <tr> 
                  <td colspan="2" class="type">�������</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">���ѡ�����һ�������ô���������еİ�鶼������ѯ</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <select name="move_from">
                      <option value="0" selected>���а��</option>
					  {selection}
                    </select>
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">��������</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="radio" name="folder" value="topic">
                    ������ 
                    <input type="radio" name="folder" value="faq">
                    FAQ 
                    <input type="radio" name="folder" value="cream">
                    ������ 
                    <input type="radio" name="folder" value="recovery" checked>
                    ����վ</td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">����ѡ���0����ʾ�����ƣ�</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">���ⷢ��ʱ��������ڵ�������</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> ������ 
                    <input type="text" name="thread_min" size="10" value="0">
                    �죬 ������ 
                    <input type="text" name="thread_max" size="10" value="0">
                    ��</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">���ظ���ʱ��������ڵ�������</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">������ 
                    <input type="text" name="post_min" size="10" value="0">
                    �죬 ������ 
                    <input type="text" name="post_max" size="10" value="0">
                    ��</td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">����ѡ��</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">���ⱻ����Ĵ�����</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">������ 
                    <input type="text" name="view_min" size="10" value="0">
                    �Σ� ������ 
                    <input type="text" name="view_max" size="10" value="0">
                    ��</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">����Ļظ�����</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">������ 
                    <input type="text" name="reply_min" size="10" value="0">
                    �Σ� ������ 
                    <input type="text" name="reply_max" size="10" value="0">
                    �� </td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">������Ϣ</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">���ӱ���</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="text" name="subject" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">��������</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="text" name="author" size="15">
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">�Ƿ�����ö���</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="radio" name="top_thread" value="1">
                    ������ 
                    <input type="radio" name="top_thread" value="0" checked>
                    ������</td>
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
      ����<b></b> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                <tr> 
                  <td align="center" class="type">���ҽ��</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#FFFFFF">һ���ҵ� <font color="#990000"><b><font color="#FF0000">{searchnums}</font></b></font> 
                    �����⣬��Щ���⹲�� <b><font color="#FF0000">{replies}</font></b> ���ظ�����������ѡ�����Щ��¼�Ĳ�����ʽ�����ߵ�������ء������κβ�����</td>
                </tr>
                <tr> 
                  <td align="center" class="type">����</td>
                </tr>
                <tr> 
                  <td align="center" bgcolor="#FFFFFF"> 
                    <p> 
                      <input type="radio" name="batch" value="del">
                      ɾ�� 
                      <input type="radio" name="batch" value="move" checked>
                      �ƶ��� 
                      <select name="move_to">
                        <option value="0" selected>��ѡ��</option>
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
                      [<a href="?action=batch_process_t">����</a>]</p>
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
