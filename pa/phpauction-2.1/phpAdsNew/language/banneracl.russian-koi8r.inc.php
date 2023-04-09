<?
// russian doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>��������</b></td>
					<td bgcolor="#FFFFFF"><b>��������</b></td>
					<td bgcolor="#FFFFFF"><b>��������</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Client IP</td>
					<td bgcolor="#FFFFFF">IP net/mask: ip.ip.ip.ip/mask.mask.mask.mask, �������� 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">���������� ������ ������ ��� ����������� ��������� IP-�������.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">User agent regexp</td>
					<td bgcolor="#FFFFFF">Regular expression matching a user agent, for example ^Mozilla/4.? </td>
		 			<td bgcolor="#FFFFFF">���������� ������ ������ ��� ���������� ���������.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">���� ������ (0-6)</td>
					<td bgcolor="#FFFFFF">���� ������, �� 0 = ����������� �� 6 = �������</td>
					<td bgcolor="#FFFFFF">���������� ������ ������ �� ��������� ���� ������.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">�����</td>
					<td bgcolor="#FFFFFF">�������� ������� (�.�. .jp, .edu, ��� google.com)</td>
					<td bgcolor="#FFFFFF">���������� ������ ������ ����������� ������.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">��������</td>
					<td bgcolor="#FFFFFF">��� �������� ��������</td>
					<td bgcolor="#FFFFFF">���������� ������ ������ �� ���������� ���������.</td>
				</tr>
                <tr> 
                    <td bgcolor="#FFFFFF">����� (0-23)</td>
                    <td bgcolor="#FFFFFF">����� �����, �� 0 = ������� �� 23 = 23:00</td>
                    <td bgcolor="#FFFFFF">���������� ������ ������ � ��������� ����� �����.</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>��������, ���� �� ������ ���������� ���� ������ ������ �� ��������, ����� �������� ��� ������ ACL:</p>
<ul>
	<li>���� ������ (0-6), <? echo $strAllow; ?>, �������� 6 (�������)</li>
	<li>���� ������ (0-6), <? echo $strAllow; ?>, �������� 0 (�����������)</li>
    <li>���� ������ (0-6), <? echo $strDeny; ?>, �������� * (����� ����)</li>
</ul>
��������, ��� ��������� ������ �� ����������� ������ ���� ���� &quot;���� ������&quot;. ����� <? echo $strDeny; ?> * ACL �������� ��� ���������� ������ �������, ���� ��� �� ��������� ���������� �� ���������������� <? echo $strAllow; ?>.
<p>��� ������ ������� ����� 17:00 � 20:00:</p>
<ul>
    <li>�����, <? echo $strAllow; ?>, �������� 17</li>  (17:00 - 17:59)
    <li>�����, <? echo $strAllow; ?>, �������� 18</li>  (18:00 - 18:59)
	<li>�����, <? echo $strAllow; ?>, �������� 19</li>  (19:00 - 19:59)
    <li>�����, <? echo $strDeny; ?>, �������� * (����� �����)</li>
</ul>
<?
// EOF russian doc file for Banner ACL administration
?>
