
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> <font class="directory">���l��B�z</font> 
            <p>�b�z�T�{�i�槹�Ҧ������l��B�z��A�����B��u<a href="?action=fix_count">�״_���l�έp</a>�v�A�H�K�Ͻ׾ª����l�ƥزέp�F���T�C</p>
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
                  <th colspan="2">�d�߱��� </th>
                </tr>
                <tr> 
                  <td colspan="2" class="type">���ݪ���</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">�p�G��ܪ��O�@�����O�A��������U�Ҧ����������N�Q�d��</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <select name="move_from">
                      <option value="0" selected>�Ҧ�����</option>
					  {selection}
                    </select>
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">���ݪ���</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="radio" name="folder" value="topic">
                    �`�W�� 
                    <input type="radio" name="folder" value="faq">
                    FAQ 
                    <input type="radio" name="folder" value="cream">
                    ��ذ� 
                    <input type="radio" name="folder" value="recovery" checked>
                    �^����</td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">����ﶵ�]�y0�z��ܤ�����^</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">�D�D�o�G�ɶ��Z���{�b���ѼơG</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> ���֩� 
                    <input type="text" name="thread_min" size="10" value="0">
                    �ѡA ���W�L 
                    <input type="text" name="thread_max" size="10" value="0">
                    ��</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">�̫�^�_���ɶ��Z���{�b���ѼơG</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">���֩� 
                    <input type="text" name="post_min" size="10" value="0">
                    �ѡA ���W�L 
                    <input type="text" name="post_max" size="10" value="0">
                    ��</td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">�X�ݿﶵ</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">�D�D�Q�s�������ơG</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">���֩� 
                    <input type="text" name="view_min" size="10" value="0">
                    ���A ���W�L 
                    <input type="text" name="view_max" size="10" value="0">
                    ��</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">�D�D���^�ƼơG</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">���֩� 
                    <input type="text" name="reply_min" size="10" value="0">
                    ���A ���W�L 
                    <input type="text" name="reply_max" size="10" value="0">
                    �� </td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">���l�H��</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">���l���D</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="text" name="subject" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">���l�@��</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="text" name="author" size="15">
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF">�O�_�]�A�m���K</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="radio" name="top_thread" value="1">
                    �]�A�A 
                    <input type="radio" name="top_thread" value="0" checked>
                    ���]�A</td>
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
      �B�z<b></b> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                <tr> 
                  <td align="center" class="type">�d�䵲�G</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#FFFFFF">�@�@��� <font color="#990000"><b><font color="#FF0000">{searchnums}</font></b></font> 
                    ���D�D�A�o�ǥD�D�@�� <b><font color="#FF0000">{replies}</font></b> ���^�_�A�Цb�U����ܹ�o�ǰO�����ާ@�覡�A�Ϊ��I���y��^�z��������ާ@�C</td>
                </tr>
                <tr> 
                  <td align="center" class="type">�B�z</td>
                </tr>
                <tr> 
                  <td align="center" bgcolor="#FFFFFF"> 
                    <p> 
                      <input type="radio" name="batch" value="del">
                      �R�� 
                      <input type="radio" name="batch" value="move" checked>
                      ���ʨ� 
                      <select name="move_to">
                        <option value="0" selected>�п��</option>
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
                      [<a href="?action=batch_process_t">��^</a>]</p>
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
