
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#003366">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><b>�b </b><font class="directory">{type_name}</font><b> �U�إ߷s�׾�</b></td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">[ <a href="index.php?action=list_file&type_id={back_id}">��^</a> 
            ] </td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#CCCCCC">
              <form>
                <input type="hidden" name="newsContent" value="">
              </form>
              <form name="form" method="post" action="index.php">
                <tr align="center"> 
                  <td colspan="3" class="type">�򥻫H�� </td>
                </tr>
                <tr> 
                  <td width="15%" bgcolor="#FFFFFF">�׾¦W�١G</td>
                  <td colspan="2" bgcolor="#FFFFFF"> 
                    <input type="text" name="name" size="30">
                  </td>
                </tr>
                <tr> 
                  <td width="15%" bgcolor="#FFFFFF">���ѹϤ��a�}�G</td>
                  <td colspan="2" bgcolor="#FFFFFF"> 
                    <input type="text" name="type_pic" size="30">
                  </td>
                </tr>
                <tr> 
                  <td width="15%" bgcolor="#FFFFFF">�׾�²���G</td>
                  <td colspan="2" bgcolor="#FFFFFF"> 
                    <textarea name="intr" cols="60"></textarea>
                  </td>
                </tr>
                <tr align="center"> 
                  <td colspan="3" class="type">���v�]���Ī��Q���v�^</td>
                </tr>
                <tr> 
                  <td width="15%" bgcolor="#FFFFFF">�X�ݱ��v�G</td>
                  <td colspan="2" bgcolor="#FFFFFF">{protect_view} </td>
                </tr>
                <tr> 
                  <td width="15%" bgcolor="#FFFFFF">�^�_���v�G</td>
                  <td colspan="2" bgcolor="#FFFFFF">{protect_reply} </td>
                </tr>
                <tr> 
                  <td width="15%" bgcolor="#FFFFFF">�o�K���v�G</td>
                  <td colspan="2" bgcolor="#FFFFFF">{protect_post} </td>
                </tr>
                <tr align="center"> 
                  <td colspan="3" class="type">�����˯��[�c</td>
                </tr>
                <tr> 
                  <td width="15%" height="29" bgcolor="#FFFFFF">���l�C���ǡG<br>
                  </td>
                  <td width="24%" valign="middle" height="29" bgcolor="#FFFFFF"> 
                    <input type="radio" name="theme_id" value="1" checked >
                    �H�̫�^�_�ɶ��Ƨ�</td>
                  <td width="61%" valign="middle" height="29" bgcolor="#FFFFFF"> 
                    <input type="radio" name="theme_id" value="2">
                    �H�D�D�o�G�ɶ��Ƨ�</td>
                </tr>
                <tr align="center"> 
                  <td colspan="3" class="type">���D�]�m</td>
                </tr>
                <tr> 
                  <td width="15%" bgcolor="#FFFFFF">�W��D�G<br>
                  </td>
                  <td bgcolor="#FFFFFF" colspan="2"> 
                    <input type="text" name="moderator" size="70">
                    <br>
                    �]��J�|���W�C���]�m�i�d�šA�]�m�h�Ӻ޲z���ХΡu,�v���j�}�C�^ </td>
                </tr>
                <tr> 
                  <td colspan="3" bgcolor="#FFFFFF" align="center"> 
                    <input type="hidden" name="type_class" value="{type_class}">
                    <input type="hidden" name="action" value="add_file_type">
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="type_id" value="{belong_id}">
                    <input type=submit name="submit" value="  Submit  ">
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
      <p>&nbsp;</p>
    </td>
  </tr>
</table>
