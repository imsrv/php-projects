<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Emlak Portal�</title>
<link href="stil.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<script type="text/javascript" src="ufo.js"></script>
</head>

<body class="body">
<!-- #include file = "config.asp" -->
<!-- #include file = "admin/dbbaglan.asp" -->
<!-- #include file = "func.asp" -->

<table width="868" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="images/temp_ust.gif" width="868" height="32"></td>
  </tr>
  <tr>
    <td background="images/temp_zemin.gif"><table width="868" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="images/spacer.gif" width="21" height="40"></td>
        <td valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="3">
            <tr>
              <td><div align="center"><img src="images/logo.gif" width="180" height="203"></div></td>
            </tr>
            <tr>
              <td><table width="180"  border="0" align="center" cellpadding="0" cellspacing="4">
                  <tr>
                    <td width="202" colspan="2"><div align="center"><img src="images/tit_menu.gif" width="187" height="22"></div></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="vurgu"><div align="center" class="tabloalt"><a href="default.asp">ANASAYFA</a></div></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="vurgu"><div align="center" class="tabloalt"><a href="emlak.asp?action=k">K�RALIKLAR</a></div></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="vurgu"><div align="center" class="tabloalt"><a href="emlak.asp?action=s">SATILIKLAR</a></div></td>
                  </tr>
                  <%
sql = "select * FROM sayfa order by id desc"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
if rs.recordcount>0 then 					
do while not rs.eof
%>
                  <tr>
                    <td colspan="2" class="vurgu"><div align="center" class="tabloalt"><a href="sayfa.asp?id=<%=rs("id")%>"><%=ucase(rs("sayfaadi"))%></a></div></td>
                  </tr>
                  <%
rs.movenext
loop
end if
%>
                  <tr>
                    <td colspan="2" class="vurgu"><div align="center" class="tabloalt"><a href="iletisim.asp">�LET���M</a></div></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="vurgu"><img src="images/spacer.gif" width="100" height="10"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="center"><img src="images/tit_emlakara2.gif" width="187" height="22"></div></td>
                  </tr>
                  <tr>
                    <td height="123" colspan="2" valign="top"><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2" class="standart">
                        <form name="form1" method="post" action="arama.asp">
                          <tr>
                            <td width="44%" class="standart"><strong>�EH�R</strong></td>
                            <td width="56%" class="vurguBEYAZ"><select name="sehir" style="width:100%; BORDER-TOP: #DADADA 1px solid; BORDER-LEFT: #DADADA 1px solid; BORDER-RIGHT: #DADADA 1px solid; background-color:#f6f6f6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 10px;" #invalid_attr_id="#DADADA 1px solid">
                                <option>�stanbul</option>
                                <option>Ankara</option>
                                <option>�zmir</option>
                                <option>Adana</option>
                                <option>Ad�yaman</option>
                                <option>Afyon</option>
                                <option>A�r�</option>
                                <option>Aksaray</option>
                                <option>Amasya</option>
                                <option>Antalya</option>
                                <option>Ardahan</option>
                                <option>Artvin</option>
                                <option>Ayd�n</option>
                                <option>Bal�kesir</option>
                                <option>Bart�n</option>
                                <option>Batman</option>
                                <option>Bayburt</option>
                                <option>Bilecik</option>
                                <option>Bing�l</option>
                                <option>Bitlis</option>
                                <option>Bolu</option>
                                <option>Burdur</option>
                                <option>Bursa</option>
                                <option>�anakkale</option>
                                <option>�ank�r�</option>
                                <option>�orum</option>
                                <option>Denizli</option>
                                <option>Diyarbak�r</option>
                                <option>Duzce</option>
                                <option>Edirne</option>
                                <option>Elaz��</option>
                                <option>Erzincan</option>
                                <option>Erzurum</option>
                                <option>Eski�ehir</option>
                                <option>Gaziantep</option>
                                <option>Giresun</option>
                                <option>G�m��hane</option>
                                <option>Hakkari</option>
                                <option>Hatay</option>
                                <option>I�d�r</option>
                                <option>Isparta</option>
                                <option>��el(Mersin)</option>
                                <option>Karab�k</option>
                                <option>Karaman</option>
                                <option>Kars</option>
                                <option>Kastamonu</option>
                                <option>Kayseri</option>
                                <option>K�r�kkale</option>
                                <option>K�rklareli</option>
                                <option>K�r�ehir</option>
                                <option>Kilis</option>
                                <option>Kocaeli</option>
                                <option>Konya</option>
                                <option>K�tahya</option>
                                <option>Malatya</option>
                                <option>Manisa</option>
                                <option>Mara�</option>
                                <option>Mardin</option>
                                <option>Mu�la</option>
                                <option>Mu�</option>
                                <option>Nev�ehir</option>
                                <option>Ni�de</option>
                                <option>Ordu</option>
                                <option>Osmaniye</option>
                                <option>Rize</option>
                                <option>Sakarya</option>
                                <option>Samsun</option>
                                <option>Siirt</option>
                                <option>Sinop</option>
                                <option>Sivas</option>
                                <option>��rnak</option>
                                <option>Tekirda�</option>
                                <option>Tokat</option>
                                <option>Trabzon</option>
                                <option>Tunceli</option>
                                <option>Urfa</option>
                                <option>U�ak</option>
                                <option>Van</option>
                                <option>Yalova</option>
                                <option>Yozgat</option>
                                <option>Zonguldak</option>
                            </select></td>
                          </tr>
                          <tr>
                            <td class="standart"><strong> DURUMU</strong></td>
                            <td class="vurguBEYAZ"><select name="durum"  style="width:100%; BORDER-TOP: #DADADA 1px solid; BORDER-LEFT: #DADADA 1px solid; BORDER-RIGHT: #DADADA 1px solid; background-color:#f6f6f6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 10px;" #invalid_attr_id="#DADADA 1px solid">
                                <option value="f">Farketmez</option>
                                <option value="k">Kiral�k</option>
                                <option value="s">Sat�l�k</option>
                            </select></td>
                          </tr>
                          <tr>
                            <td class="standart"><strong>EMLAK T�P� </strong></td>
                            <td class="vurguBEYAZ"><select name="emlaktip" style="width:100%; BORDER-TOP: #DADADA 1px solid; BORDER-LEFT: #DADADA 1px solid; BORDER-RIGHT: #DADADA 1px solid; background-color:#f6f6f6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 10px;" #invalid_attr_id="#DADADA 1px solid">
                                <option >Farketmez</option>
                                <%
sql = "SELECT * FROM kategori order by kategori asc"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
if rs.recordcount>0 then 	
do while not rs.eof
%>
                                <option>
                                <%
response.write rs("kategori")
%>
                                </option>
                                <%
rs.movenext
loop
end if
%>
                            </select></td>
                          </tr>
                          <tr>
                            <td class="standart"><strong>M�N F�YAT </strong></td>
                            <td class="vurguBEYAZ"><input name="minfiyat" type="text" id="minfiyat" style="width:100%; BORDER-TOP: #DADADA 1px solid; BORDER-LEFT: #DADADA 1px solid; BORDER-RIGHT: #DADADA 1px solid; background-color:#f6f6f6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 10px;" #invalid_attr_id="#DADADA 1px solid"></td>
                          </tr>
                          <tr>
                            <td class="standart"><strong>MAX F�YAT </strong></td>
                            <td class="vurguBEYAZ"><input name="maxfiyat" type="text" id="maxfiyat" style="width:100%; BORDER-TOP: #DADADA 1px solid; BORDER-LEFT: #DADADA 1px solid; BORDER-RIGHT: #DADADA 1px solid; background-color:#f6f6f6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 10px;" #invalid_attr_id="#DADADA 1px solid"></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div align="center">Bir veya birka� alan� doldurun.<br>
                            </div></td>
                          </tr>
                          <tr>
                            <td colspan="2" class="vurguBEYAZ"><div align="center">
                                <input name="Submit" type="submit" class="tablo_TEXTBOX" value="EMLAK ARA">
                            </div></td>
                          </tr>
                          <tr>
                            <td colspan="2" class="vurguBEYAZ"><img src="images/spacer.gif" width="100" height="10"></td>
                          </tr>
                        </form>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="2" valign="top"><span class="vurguBEYAZ"><img src="images/tit_hava.gif" width="187" height="22"></span></td>
                  </tr>
                  <tr>
                    <td colspan="2" valign="top"><table width="170" border="0" align="center" cellpadding="0" cellspacing="2" class="standart">
                      <tr>
                        <td width="33%"><div align="center"><img src="http://www.meteor.gov.tr/sunum/imgtahmingor-c1-g.aspx?merkez=ANKARA&amp;gun=1" /></div></td>
                        <td width="33%"><div align="center"><img src="http://www.meteor.gov.tr/sunum/imgtahmingor-c1-g.aspx?merkez=ISTANBUL&amp;gun=1" width="50" height="50" /></div></td>
                        <td width="33%"><div align="center"><img src="http://www.meteor.gov.tr/sunum/imgtahmingor-c1-g.aspx?merkez=IZMIR&amp;gun=1" width="50" height="50" /></div></td>
                      </tr>
                      <tr>
                        <td><div align="center">Ankara</div></td>
                        <td><div align="center">�stanbul</div></td>
                        <td><div align="center">�zmir</div></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="2" valign="top"><img src="images/spacer.gif" width="100" height="10"></td>
                  </tr>
                  <tr>
                    <td colspan="2" valign="top"><span class="vurguBEYAZ"><img src="images/tit_doviz.gif" width="187" height="22"></span></td>
                  </tr>
                  <tr>
                    <td valign="top" class="standart"><div align="right"><img src="images/doviz.gif" width="12" height="30"></div></td>
                    <td valign="top" class="standart"><!--#include file="doviz.asp" --></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
        <td><img src="images/spacer.gif" width="18" height="40"></td>
        <td valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr>
              <td><%call sayfa()%></td>
            </tr>
        </table></td>
        <td width="3%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="images/temp_alt.gif" width="868" height="35"></td>
  </tr>
  <tr>
    <td><div align="center" class="standart">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="kucuk">
        <tr>
          <td><img src="images/tarayiciler.jpg" width="203" height="17"></td>
          <td width="14%"><a href="http://www.designcube.net"><img src="images/dc.gif" alt="Tasar�m ve Programlamas� designcube.net taraf�ndan yap�lm��t�r." width="131" height="16" border="0"></a></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</body>
</html>
