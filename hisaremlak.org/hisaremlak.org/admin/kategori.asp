<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Emlak Portal� - Y�netim B�l�m�</title>
<link href="stil.css" rel="stylesheet" type="text/css">
<SCRIPT language=Javascript src="javascripts.js"></SCRIPT>
</head>

<body>
<!-- #include file = "../config.asp" -->
<!-- #include file = "dbbaglan.asp" -->

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="4" class="tablogri2">
  <tr>
    <td valign="top" class="tablogri4"><!-- #include file = "menu.asp" --></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><table width="100%"  border="0" cellpadding="4" cellspacing="4">
      <tr>
        <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon7.gif" width="41" height="41"></div></td>
        <td width="91%" class="tablogri2"><span class="baslik">EMLAK KATEGOR�LER�</span></td>
      </tr>
      <tr valign="top">
        <td colspan="2"><table width="100%"  border="0" cellpadding="0" cellspacing="2" class="vurgu">
          <tr valign="top">
            <td height="28" colspan="2"><div align="justify" class="standart">Bu b�l�mde emlak kategorilerini ekleyebilirsiniz. Emlak kaydetmek i�in kategorileri tan�mlaman�z gerekiyor. </div></td>
          </tr>
          <tr valign="top">
            <td width="51%" class="tablogri2">KATEGOR� EKLE </td>
            <td width="49%" class="tablogri2">KAYITLI KATEGOR�LER </td>
          </tr>
          <tr valign="top">
            <td><form name="form1" method="post" action="actions.asp?step=kategori&action=kayit">
              <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="standart">
                <tr>
                  <td width="23%">&nbsp;</td>
                  <td width="77%">&nbsp;</td>
                </tr>
                <tr>
                  <td>Kategori Ad�</td>
                  <td><input name="kategori" type="text" id="kategori">                    </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input name="Submit" type="submit" class="tabloyesil" value="EKLE"></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </form></td>
            <td>
<%
sql = "SELECT * FROM kategori order by kategori asc"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
if rs.recordcount>0 then 
do while not rs.eof
%>
<table width="100%"  border="0" cellpadding="0" cellspacing="2" class="standart">
  <tr>
    <td><%=rs("kategori")%> </td>
    <td width="4%"><div align="right"> <a href="kategori.asp?action=edit&id=<%=rs("id")%>"> <img src="images/icon12.gif" width="16" height="16" border="0"></a></div></td>
    <td width="4%"><div align="right"> <a href="javascript:OnayIste('Bu i�lemi geri alamayacaks�n�z. Kayd� silmek istedi�inizden emin misiniz?','actions.asp?step=kategori&action=sil&id=<%=rs("id")%>')"> <img src="images/icon11.gif" alt="Bu kategoriyi sil!" width="16" height="16" border="0"></a></div></td>
  </tr>
</table>

<%
rs.movenext
loop
end if
%>			</td>
          </tr>
          <tr valign="top">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
</td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><div align="center"><span class="standart">DCEmlak 2007� G�rkan KARA taraf�ndan programlanm��t�r. gurkan@designcube.net </span></div></td>
  </tr>
</table>
</body>
</html>
