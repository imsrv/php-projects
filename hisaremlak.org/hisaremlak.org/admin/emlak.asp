<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Emlak Portalı - Yönetim Bölümü</title>
<link href="stil.css" rel="stylesheet" type="text/css">
<SCRIPT language=Javascript src="javascripts.js"></SCRIPT>
</head>

<body>
<!-- #include file = "../config.asp" -->
<!-- #include file = "dbbaglan.asp" -->
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="4" class="tablogri2">
  <tr>
    <td valign="top" class="tablogri4">
	
	<!-- #include file = "menu.asp" --></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4">
      <%if request.querystring("action")="yeni" then%>
      <table width="100%"  border="0" cellpadding="4" cellspacing="4">
        <tr>
          <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon2.gif" width="40" height="43"></div></td>
          <td width="91%" class="tablogri2"><span class="baslik">YENİ EMLAK EKLE </span></td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="tablogri2">
            <tr>
              <td width="33%" bgcolor="#99CC00"><div align="center" class="vurgu">1. ADIM - EMLAK BİLGİLERİNİ GİRİN </div></td>
              <td width="33%"><div align="center" class="vurgu">2. ADIM - EMLAK RESİMLERİNİ YÜKLEYİN </div></td>
              <td width="33%"><div align="center" class="vurgu">3. ADIM - EMLAK VİDEOSUNU YÜKLEYİN </div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2"><form name="form1" method="post" action="actions.asp?step=emlak&action=kayit">
            <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="standart">
              <tr valign="top">
                <td height="28" colspan="2"><div align="justify" class="vurgu">Eklemek istediğiniz emlağın bilgilerini aşağıdaki ilgili yerlere giriniz. Bilgileri girdikten sonra &quot;BİLGİLERİ KAYDET VE RESİM EKLE&quot; butonuna tıklayarak resim ekleme sayfasına geçebilirsiniz. </div></td>
              </tr>
              <tr valign="top">
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr valign="top">
                <td valign="middle" class="vurgu">Emlak Adı </td>
                <td valign="top"><input name="emlakad" type="text" class="KUTUCUK" id="emlakad">
                    <span class="kucuk"> Kullanıcılar göremez, sadece yönetim bölümünde görülür. </span></td>
              </tr>
              <tr>
                <td width="17%" class="vurgu">Emlak Tipi </td>
                <td width="83%"><select name="emlaktip" class="KUTUCUK" id="select2">
                    <%
sql = "SELECT * FROM kategori order by kategori asc"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
if rs.recordcount>0 then 	
do while not rs.eof
%>
                    <option><%=rs("kategori")%></option>
                    <%
rs.movenext
loop
else
%>
                    <option >Kategori Bulunamadı! Kategorilerden bölümünden kategori ekleyin.</option>
                    <%
end if
%>
                </select></td>
              </tr>
              <tr>
                <td width="17%" class="vurgu">Emlak Durumu </td>
                <td><select name="emlakdurum" class="KUTUCUK" id="emlakdurum">
                    <option value="k">Kiralık</option>
                    <option value="s">Satılık</option>
                  </select>                </td>
              </tr>
              <tr>
                <td class="vurgu">Bulunduğu İl </td>
                <td><select name="il" class="KUTUCUK" id="select2">
                    <option>İstanbul</option>
                    <option>Ankara</option>
                    <option>İzmir</option>
                    <option>Adana</option>
                    <option>Adıyaman</option>
                    <option>Afyon</option>
                    <option>Ağrı</option>
                    <option>Aksaray</option>
                    <option>Amasya</option>
                    <option>Antalya</option>
                    <option>Ardahan</option>
                    <option>Artvin</option>
                    <option>Aydın</option>
                    <option>Balıkesir</option>
                    <option>Bartın</option>
                    <option>Batman</option>
                    <option>Bayburt</option>
                    <option>Bilecik</option>
                    <option>Bingöl</option>
                    <option>Bitlis</option>
                    <option>Bolu</option>
                    <option>Burdur</option>
                    <option>Bursa</option>
                    <option>Çanakkale</option>
                    <option>Çankırı</option>
                    <option>Çorum</option>
                    <option>Denizli</option>
                    <option>Diyarbakır</option>
                    <option>Duzce</option>
                    <option>Edirne</option>
                    <option>Elazığ</option>
                    <option>Erzincan</option>
                    <option>Erzurum</option>
                    <option>Eskişehir</option>
                    <option>Gaziantep</option>
                    <option>Giresun</option>
                    <option>Gümüşhane</option>
                    <option>Hakkari</option>
                    <option>Hatay</option>
                    <option>Iğdır</option>
                    <option>Isparta</option>
                    <option>İçel(Mersin)</option>
                    <option>Karabük</option>
                    <option>Karaman</option>
                    <option>Kars</option>
                    <option>Kastamonu</option>
                    <option>Kayseri</option>
                    <option>Kırıkkale</option>
                    <option>Kırklareli</option>
                    <option>Kırşehir</option>
                    <option>Kilis</option>
                    <option>Kocaeli</option>
                    <option>Konya</option>
                    <option>Kütahya</option>
                    <option>Malatya</option>
                    <option>Manisa</option>
                    <option>Maraş</option>
                    <option>Mardin</option>
                    <option>Muğla</option>
                    <option>Muş</option>
                    <option>Nevşehir</option>
                    <option>Niğde</option>
                    <option>Ordu</option>
                    <option>Osmaniye</option>
                    <option>Rize</option>
                    <option>Sakarya</option>
                    <option>Samsun</option>
                    <option>Siirt</option>
                    <option>Sinop</option>
                    <option>Sivas</option>
                    <option>Şırnak</option>
                    <option>Tekirdağ</option>
                    <option>Tokat</option>
                    <option>Trabzon</option>
                    <option>Tunceli</option>
                    <option>Urfa</option>
                    <option>Uşak</option>
                    <option>Van</option>
                    <option>Yalova</option>
                    <option>Yozgat</option>
                    <option>Zonguldak</option>
                  </select>                </td>
              </tr>
              <tr>
                <td class="vurgu">İlçe / Semt </td>
                <td><input name="ilce" type="text" class="KUTUCUK" id="ilce"></td>
              </tr>
              <tr>
                <td class="vurgu">m2</td>
                <td><input name="m2" type="text" class="KUTUCUK" id="m2"></td>
              </tr>
              <tr>
                <td class="vurgu">Oda Sayısı </td>
                <td><input name="oda" type="text" class="KUTUCUK" id="oda"></td>
              </tr>
              <tr>
                <td class="vurgu">Fiyatı</td>
                <td><input name="fiyat" type="text" class="KUTUCUK" id="fiyat"></td>
              </tr>
              <tr>
                <td class="vurgu">Notlar</td>
                <td><textarea name="not" cols="50" rows="10" class="KUTUCUK" id="not"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="Submit" type="submit" class="tabloyesil" value="BİLGİLERİ KAYDET VE RESİM EKLE"></td>
              </tr>
            </table>
          </form></td>
        </tr>
      </table>
      <%
end if
if request.querystring("action")="resim" then
%>
      <table width="100%"  border="0" cellpadding="4" cellspacing="4">
        <tr>
          <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon4.gif" width="41" height="43"></div></td>
          <td width="91%" class="tablogri2"><span class="baslik">FOTOĞRAF EKLE </span></td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="tablogri2">
            <tr>
              <td width="33%"><div align="center" class="vurgu">1. ADIM - EMLAK BİLGİLERİNİ GİRİN </div></td>
              <td width="33%" bgcolor="#99CC00"><div align="center" class="vurgu">2. ADIM - EMLAK RESİMLERİNİ YÜKLEYİN </div></td>
              <td width="33%"><div align="center" class="vurgu">3. ADIM - EMLAK VİDEOSUNU YÜKLEYİN </div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2"><form action="fsoupload.asp?action=resim&emlakid=<%=request.querystring("emlakid")%>" method="post" enctype="multipart/form-data" name="" id="">
            <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="standart">
              <tr valign="top">
                <td height="28" colspan="2"><div align="justify" class="vurgu">Aşağıda bilgileri bulunan emlağa resim eklemek için &quot;GÖZAT&quot; butonuna tıklayarak bilgisayarınızdan istediğiniz resmi seçiniz. &quot;RESİMLERİ KAYDET&quot; butonuna tıklayarak seçtiğiniz resmi kaydedebilirsiniz. İstediğiniz kadar resim ekleyebilirsiniz. Tüm resimleri yüklediğinizde &quot;DEVAM ET&quot; butonuna tıklayarak video yükleme aşamasına geçebilirsiniz. </div></td>
              </tr>
              <tr valign="top">
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td width="17%" class="vurgu">Emlak Adı </td>
                <td width="83%" class="standart"><%=session("a1")%></td>
              </tr>
              <tr>
                <td class="vurgu">Emlak Tipi </td>
                <td class="standart"><%=session("a2")%></td>
              </tr>
              <tr>
                <td class="vurgu">Emlak Durumu </td>
                <td class="standart"><%
				  if session("a3")="k" then
				  response.write "Kiralık"
				  else
				  response.write "Satılık"
				  end if 
				  %></td>
              </tr>
              <tr>
                <td class="vurgu">Bulunduğu İl </td>
                <td class="standart"><%=session("a4")%></td>
              </tr>
              <tr>
                <td class="vurgu">İlçe / Semt </td>
                <td class="standart"><%=session("a5")%></td>
              </tr>
              <tr>
                <td class="vurgu">m2</td>
                <td class="standart"><%=session("a6")%></td>
              </tr>
              <tr>
                <td class="vurgu">Oda Sayısı </td>
                <td class="standart"><%=session("a7")%></td>
              </tr>
              <tr>
                <td class="vurgu">Fiyatı</td>
                <td class="standart"><%=session("a8")%></td>
              </tr>
              <tr>
                <td class="vurgu">Notlar</td>
                <td class="standart"><%=session("a9")%></td>
              </tr>
              <tr>
                <td class="vurgu">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="vurgu">Resim Seç </td>
                <td><input name="FILE1" type="file" class="KUTUCUK" id="FILE1" size="40"></td>
              </tr>
              <tr>
                <td class="vurgu">&nbsp;</td>
                <td><input name="Submit2" type="submit" class="tabloyesil" value="RESİMLERİ KAYDET"> <label></label></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><div align="right"><span class="tablokirmizi"> &nbsp;<a class="vurguBEYAZ" href="emlak.asp?action=video&emlakid=<%=request.querystring("emlakid")%>">DEVAM ET >></a>&nbsp; </span></div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" class="tablogri2"><strong>EKLEDİĞİNİZ RESİMLER </strong></td>
              </tr>
              <tr>
                <td colspan="2"><%
on error resume next
sql = "select * FROM resim where emlakid="&CINT(request.QueryString("emlakid"))
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
%>
                    <table width="100%" border="0" cellspacing="5" style="border-collapse: collapse">
                      <tr>
                        <%
for i=1 to rs.recordcount
bol = 4 
yuzde = CInt(100/bol) 
%>
                        <% If not i mod bol = 0 Then %>
                        <td width="<%=yuzde %>%" valign="top"><div align="center"><img src="<%="../resimarsiv/thumb/"&rs("resim")%>" class="tablogri2"> <br>
                            <a href="actions.asp?step=emlak&action=resimsil&id=<%=rs("id")%>"><img src="images/icon10.gif" border="0"></a></div></td>
                        <% ElseIf i mod bol = 0 Then %>
                        <td width="<%=yuzde %>%" valign="top"><div align="center"><img src="<%="../resimarsiv/thumb/"&rs("resim")%>" class="tablogri2"> <br>
                            <a href="actions.asp?step=emlak&action=resimsil&id=<%=rs("id")%>"><img src="images/icon10.gif" border="0"></a></div></td>
                      </tr>
                      <tr>
                        <% 
End If 						
rs.Movenext 
next
%>
                      </tr>
                  </table></td>
              </tr>
            </table>
          </form></td>
        </tr>
      </table>
      <%
end if
if request.querystring("action")="video" then
%>
      <table width="100%"  border="0" cellpadding="4" cellspacing="4">
        <tr>
          <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon18.gif" width="41" height="41"></div></td>
          <td width="91%" class="tablogri2"><span class="baslik">VİDEO EKLE </span></td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="tablogri2">
              <tr>
                <td width="33%"><div align="center" class="vurgu">1. ADIM - EMLAK BİLGİLERİNİ GİRİN </div></td>
                <td width="33%"><div align="center" class="vurgu">2. ADIM - EMLAK RESİMLERİNİ YÜKLEYİN </div></td>
                <td width="33%" bgcolor="#99CC00"><div align="center" class="vurgu">3. ADIM - EMLAK VİDEOSUNU YÜKLEYİN </div></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2"><form action="fsoupload.asp?action=video&emlakid=<%=request.querystring("emlakid")%>" method="post" enctype="multipart/form-data" name="" id="">
              <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="standart">
                <tr valign="top">
                  <td height="28" colspan="2"><div align="justify" class="vurgu">Aşağıda bilgileri bulunan emlağa video eklemek için &quot;GÖZAT&quot; butonuna tıklayarak bilgisayarınızdan istediğiniz video dosyasını seçiniz. &quot;VİDEOYU KAYDET&quot; butonuna tıklayarak seçtiğiniz videoyu kaydedebilirsiniz. Video dosyası flash video (*.flv) türünde olmalıdır. </div></td>
                </tr>
                <tr valign="top">
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td width="17%" class="vurgu">Emlak Adı </td>
                  <td width="83%" class="standart"><%=session("a1")%></td>
                </tr>
                <tr>
                  <td class="vurgu">Emlak Tipi </td>
                  <td class="standart"><%=session("a2")%></td>
                </tr>
                <tr>
                  <td class="vurgu">Emlak Durumu </td>
                  <td class="standart"><%
				  if session("a3")="k" then
				  response.write "Kiralık"
				  else
				  response.write "Satılık"
				  end if 
				  %></td>
                </tr>
                <tr>
                  <td class="vurgu">Bulunduğu İl </td>
                  <td class="standart"><%=session("a4")%></td>
                </tr>
                <tr>
                  <td class="vurgu">İlçe / Semt </td>
                  <td class="standart"><%=session("a5")%></td>
                </tr>
                <tr>
                  <td class="vurgu">m2</td>
                  <td class="standart"><%=session("a6")%></td>
                </tr>
                <tr>
                  <td class="vurgu">Oda Sayısı </td>
                  <td class="standart"><%=session("a7")%></td>
                </tr>
                <tr>
                  <td class="vurgu">Fiyatı</td>
                  <td class="standart"><%=session("a8")%></td>
                </tr>
                <tr>
                  <td class="vurgu">Notlar</td>
                  <td class="standart"><%=session("a9")%></td>
                </tr>

                <tr>
                  <td class="vurgu">Resimler</td>
                  <td class="vurgu"><%
on error resume next
sql = "select * FROM resim where emlakid="&CINT(request.QueryString("emlakid"))
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
%>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
                      <tr>
                        <%
for i=1 to rs.recordcount
bol = 4 
yuzde = CInt(100/bol) 
%>
                        <% If not i mod bol = 0 Then %>
                        <td width="<%=yuzde %>%" valign="top"><div align="left"><img src="<%="../resimarsiv/thumb/"&rs("resim")%>" class="tablogri2"> <br>
                          <a href="actions.asp?step=emlak&action=resimsil&id=<%=rs("id")%>"><img src="images/icon10.gif" border="0"></a></div></td>
                        <% ElseIf i mod bol = 0 Then %>
                        <td width="<%=yuzde %>%" valign="top"><div align="left"><img src="<%="../resimarsiv/thumb/"&rs("resim")%>" class="tablogri2"> <br>
                        <a href="actions.asp?step=emlak&action=resimsil&id=<%=rs("id")%>"><img src="images/icon10.gif" border="0"></a></div></td>
                      </tr>
                      <tr>
                        <% 
End If 						
rs.Movenext 
next
%>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td class="vurgu">&nbsp;</td>
                  <td><label></label></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="vurgu">Video Seç </span></td>
                  <td>
                    <input name="FILE12" type="file" class="KUTUCUK" id="FILE12" size="40">
                  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input name="Submit22" type="submit" class="tabloyesil" value="VİDEOYU KAYDET"></td>
                </tr>

                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
              </table>
          </form></td>
        </tr>
      </table>
      <p>
        <%
end if
if request.querystring("action")="edit" then
%>
      </p>
      <table width="100%"  border="0" cellpadding="4" cellspacing="4">
        <tr>
          <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon2.gif" width="40" height="43"></div></td>
          <td width="91%" class="tablogri2"><span class="baslik"> EMLAK BİLGİLERİNİ DÜZENLE </span></td>
        </tr>
        <tr>
          <td colspan="2"><form name="form1" method="post" action="actions.asp?step=emlak&action=edit&id=<%=request.querystring("id")%>">
              <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="standart">
                <tr valign="top">
                  <td height="28" colspan="2"><div align="justify" class="vurgu">Düzenlemek istediğiniz emlağın bilgilerini aşağıdaki ilgili yerlere giriniz. Bilgileri girdikten sonra &quot;DÜZENLEMEYİ KAYDET VE RESİM EKLE&quot; butonuna tıklayarak resim ekleme sayfasına geçebilirsiniz. </div></td>
                </tr>
                <tr valign="top">
                  <td colspan="2"> &nbsp;
                      <%
sql = "SELECT * FROM emlak where id="&cint(request.querystring("id"))
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3		
kat=rs("emlaktip")		
%>
                  </td>
                </tr>
                <tr valign="top">
                  <td valign="middle" class="vurgu">Emlak Adı </td>
                  <td valign="top"><input name="emlakad" type="text" class="KUTUCUK" id="emlakad" value="<%=rs("emlakad")%>">
                      <span class="kucuk"> Kullanıcılar göremez, sadece yönetim bölümünde görülür. </span></td>
                </tr>
                <tr>
                  <td width="17%" class="vurgu">Emlak Tipi </td>
                  <td width="83%"><select name="emlaktip" class="KUTUCUK" id="select3">
                    <%
sql = "SELECT * FROM kategori order by kategori asc"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
if rs.recordcount>0 then 	
do while not rs.eof
%>
<option <%if kat=rs("kategori") then response.write "selected "%>>
<%
response.write rs("kategori")
%></option>
<%
rs.movenext
loop
else
%>
<option >Kategori Bululnamadı! Kategorilerden bölümünden kategori ekleyin.</option>
<%
end if

sql = "SELECT * FROM emlak where id="&cint(request.querystring("id"))
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3		
kat=rs("emlaktip")		
%>
                  </select>     </td>
                </tr>
                <tr>
                  <td width="17%" class="vurgu">Emlak Durumu </td>
                  <td><select name="emlakdurum" class="KUTUCUK" id="emlakdurum">
                      <%
				  if rs("emlakdurum")="k" then
				  response.write "<option selected value='k'>Kiralık</option>"
				  response.write "<option value='s'>Satılık</option>"
				  else
				  response.write "<option value='k'>Kiralık</option>"
				  response.write "<option selected value='s'>Satılık</option>"
				  end if 
				  %>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="vurgu">Bulunduğu İl </td>
                  <td><select name="il" class="KUTUCUK" id="il">
                      <%response.write "<option selected>"&rs("il")&"</option>"%>
                      <option>İstanbul</option>
                      <option>Ankara</option>
                      <option>İzmir</option>
                      <option>Adana</option>
                      <option>Adıyaman</option>
                      <option>Afyon</option>
                      <option>Ağrı</option>
                      <option>Aksaray</option>
                      <option>Amasya</option>
                      <option>Antalya</option>
                      <option>Ardahan</option>
                      <option>Artvin</option>
                      <option>Aydın</option>
                      <option>Balıkesir</option>
                      <option>Bartın</option>
                      <option>Batman</option>
                      <option>Bayburt</option>
                      <option>Bilecik</option>
                      <option>Bingöl</option>
                      <option>Bitlis</option>
                      <option>Bolu</option>
                      <option>Burdur</option>
                      <option>Bursa</option>
                      <option>Çanakkale</option>
                      <option>Çankırı</option>
                      <option>Çorum</option>
                      <option>Denizli</option>
                      <option>Diyarbakır</option>
                      <option>Duzce</option>
                      <option>Edirne</option>
                      <option>Elazığ</option>
                      <option>Erzincan</option>
                      <option>Erzurum</option>
                      <option>Eskişehir</option>
                      <option>Gaziantep</option>
                      <option>Giresun</option>
                      <option>Gümüşhane</option>
                      <option>Hakkari</option>
                      <option>Hatay</option>
                      <option>Iğdır</option>
                      <option>Isparta</option>
                      <option>İçel(Mersin)</option>
                      <option>Karabük</option>
                      <option>Karaman</option>
                      <option>Kars</option>
                      <option>Kastamonu</option>
                      <option>Kayseri</option>
                      <option>Kırıkkale</option>
                      <option>Kırklareli</option>
                      <option>Kırşehir</option>
                      <option>Kilis</option>
                      <option>Kocaeli</option>
                      <option>Konya</option>
                      <option>Kütahya</option>
                      <option>Malatya</option>
                      <option>Manisa</option>
                      <option>Maraş</option>
                      <option>Mardin</option>
                      <option>Muğla</option>
                      <option>Muş</option>
                      <option>Nevşehir</option>
                      <option>Niğde</option>
                      <option>Ordu</option>
                      <option>Osmaniye</option>
                      <option>Rize</option>
                      <option>Sakarya</option>
                      <option>Samsun</option>
                      <option>Siirt</option>
                      <option>Sinop</option>
                      <option>Sivas</option>
                      <option>Şırnak</option>
                      <option>Tekirdağ</option>
                      <option>Tokat</option>
                      <option>Trabzon</option>
                      <option>Tunceli</option>
                      <option>Urfa</option>
                      <option>Uşak</option>
                      <option>Van</option>
                      <option>Yalova</option>
                      <option>Yozgat</option>
                      <option>Zonguldak</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="vurgu">İlçe / Semt </td>
                  <td><input name="ilce" type="text" class="KUTUCUK" id="ilce" value="<%=rs("ilce")%>"></td>
                </tr>
                <tr>
                  <td class="vurgu">m2</td>
                  <td><input name="m2" type="text" class="KUTUCUK" id="m2" value="<%=rs("m2")%>"></td>
                </tr>
                <tr>
                  <td class="vurgu">Oda Sayısı </td>
                  <td><input name="oda" type="text" class="KUTUCUK" id="oda" value="<%=rs("oda")%>"></td>
                </tr>
                <tr>
                  <td class="vurgu">Fiyatı</td>
                  <td><input name="fiyat" type="text" class="KUTUCUK" id="fiyat" value="<%=rs("fiyat")%>"></td>
                </tr>
                <tr>
                  <td class="vurgu">Notlar</td>
                  <td><textarea name="not" cols="50" rows="10" class="KUTUCUK" id="not"><%=rs("not")%></textarea></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input name="Submit3" type="submit" class="tabloyesil" value="BİLGİLERİ KAYDET VE RESİM EKLE"></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" class="tablogri2"><strong>EKLEDİĞİNİZ RESİMLER </strong></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <%
sql = "select * FROM resim where emlakid="&CINT(rs("id"))
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
%>
                    <table width="100%" border="0" cellspacing="5" style="border-collapse: collapse">
                      <tr>
                        <%
for i=1 to rs.recordcount
bol = 4 
yuzde = CInt(100/bol) 
%>
                        <% If not i mod bol = 0 Then %>
                        <td width="<%=yuzde %>%" valign="top">
                          <div align="center"><img src="<%="../resimarsiv/thumb/"&rs("resim")%>" class="tablogri2"> <br>
                              <a href="actions.asp?step=emlak&action=resimsil&id=<%=rs("id")%>"><img src="images/icon10.gif" border="0"></a></div></td>
                        <% ElseIf i mod bol = 0 Then %>
                        <td width="<%=yuzde %>%" valign="top">
                          <div align="center"><img src="<%="../resimarsiv/thumb/"&rs("resim")%>" class="tablogri2"> <br>
                              <a href="actions.asp?step=emlak&action=resimsil&id=<%=rs("id")%>"><img src="images/icon10.gif" border="0"></a></div></td>
                      </tr>
                      <tr>
                        <% 
End If 						
rs.Movenext 
next
%>
                      </tr>
                  </table></td>
                </tr>
              </table>
          </form></td>
        </tr>
      </table>
      <%
end if
if request.querystring("action")="liste" then
%>
      <table width="100%"  border="0" cellpadding="4" cellspacing="4">
        <tr>
          <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon3.gif" width="38" height="42"></div></td>
          <td width="91%" class="tablogri2"><span class="baslik">KAYITLI EMLAKLAR</span></td>
        </tr>
        <tr>
          <td colspan="2"><form name="form1" method="post" action="actions.asp?step=emlak&action=kayit">
              <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="standart">
                <tr valign="top">
                  <td height="28" colspan="9"><div align="justify" class="vurgu">Şu ana kadar kaydettiğiniz emlak bilgileri aşağıda listelenmektedir. Emlak adına tıklayarak bilgileri görebilir, düzenleyebilir yada silebilirsiniz. </div></td>
                </tr>
                <tr valign="top">
                  <td colspan="9">&nbsp;</td>
                </tr>
                <tr class="vurgu">
                  <td width="19%" class="tablogri2">EMLAK ADI </td>
                  <td width="17%" class="tablogri2">TİP</td>
                  <td width="15%" class="tablogri2">DURUM</td>
                  <td width="14%" class="tablogri2">İL</td>
                  <td width="15%" class="tablogri2">İLÇE</td>
                  <td colspan="4" class="tablogri2">FİYAT (YTL) </td>
                </tr>
                <%
sql = "SELECT * FROM emlak order by id desc"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
if rs.recordcount>0 then 
do while not rs.eof
%>
                <tr>
                  <td class="tablogrialt"><%=rs("emlakad")%></td>
                  <td class="tablogrialt"><%=rs("emlaktip")%></td>
                  <td class="tablogrialt"><%
				  if rs("emlakdurum")="k" then
				  response.write "Kiralık"
				  else
				  response.write "Satılık"
				  end if 
				  %></td>
                  <td class="tablogrialt"><%=rs("il")%></td>
                  <td class="tablogrialt"><%=rs("ilce")%></td>
                  <td width="12%" class="tablogrialt"><%=rs("fiyat")%></td>
                  <td width="2%"><div align="right"> 
				  <%
				  if rs("anasayfa")=False then
				  %>
				  <a href="actions.asp?step=emlak&action=anasayfatrue&id=<%=rs("id")%>"><img src="images/icon20.gif" alt="Anasayfada göstermek için tıklayın!" border="0"></a>
				  <%
				  end if
				  if rs("anasayfa")=True then
				  %>
				   <a href="actions.asp?step=emlak&action=anasayfafalse&id=<%=rs("id")%>"><img src="images/icon19.gif" alt="Anasayfada gösterimi iptal etmek için tıklayın!" width="16" height="16" border="0"></a>
				  <%
				  end if
				  %>
				  </div>
				  </td>
                  <td width="3%"><div align="right"><a href="emlak.asp?action=edit&id=<%=rs("id")%>"><img src="images/icon12.gif" alt="Gör / Düzenle" width="16" height="16" border="0" class="tablogrialt"></a></div></td>
                  <td width="3%"><div align="right"> <a href="javascript:OnayIste('Bu işlemi geri alamayacaksınız. Kaydı silmek istediğinizden emin misiniz?','actions.asp?step=emlak&action=kayitsil&id=<%=rs("id")%>')"> <img src="images/icon11.gif" alt="Bu emlak kaydını sil!" width="16" height="16" border="0" class="tablogrialt"></a></div></td>
                </tr>
                <%
rs.movenext
loop
end if
DBClose()
%>
              </table>
          </form></td>
        </tr>
      </table>
    <%
end if
%></td>
  </tr>
  <tr>
    <td class="tablogri4"><div align="center" class="standart">DCEmlak 2007© Gürkan KARA tarafından programlanmıştır. gurkan@designcube.net </div></td>
  </tr>
</table>
</body>
</html>
