<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Emlak Portalı - Yönetim Bölümü</title>
<link href="stil.css" rel="stylesheet" type="text/css">
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
        <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon1.gif" width="41" height="41"></div></td>
        <td width="91%" class="tablogri2"><span class="baslik">İSTATİSTİKLER</span></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%"  border="0" cellpadding="0" cellspacing="2" class="vurgu">
            <tr valign="top">
              <td height="28" colspan="2"><div align="justify" class="standart">Şu anda veritabanında kayıtlı emlaklara ve sitenizin ziyaret sayısına ait istatistiki bilgileri aşağıda görebilirsiniz. </div></td>
            </tr>
            <tr valign="top">
              <td colspan="2" class="tablogri2">EMLAK İSTATİSTİKLERİ </td>
            </tr>
            <tr valign="top">
              <td valign="middle">TOPLAM EMLAK </td>
              <td valign="top">
<%
sql = "SELECT * FROM EMLAK"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
response.write rs.recordcount
%></td>
            </tr>
            <tr>
              <td width="16%">KİRALIK </td>
              <td width="84%"><%
sql = "SELECT * FROM EMLAK where emlakdurum='k'" 
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
response.write rs.recordcount
%></td>
            </tr>
            <tr>
              <td>SATILIK</td>
              <td><%
sql = "SELECT * FROM EMLAK where emlakdurum='s'" 
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
response.write rs.recordcount
%></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
        </table>
          <table width="100%" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td colspan="7" bgcolor="#E8F3FF" class="tablogri2"><strong class="vurgu">SAYAÇ İSTATİSTİKLERİ </strong></td>
            </tr>
            <tr>
              <td width="95" height="25" valign="middle" class="standart"><%
Function tarihFormatla(tarih)
	Bol = Split(CStr(tarih),".",-1,1)
	tarihFormatla = Bol(1) & "/" & Bol(0) & "/" & Bol(2)
End Function

'on error resume next


sql = "SELECT * FROM sayac WHERE tarih =#"&tarihFormatla(date())&"#"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3

BTek=rs("tekil")
BCok=rs("cogul")

tarihx=1&"."&month(date())&"."&year(date())
sql = "select sum(tekil) As Atek, SUM(cogul) as ACok FROM sayac Where tarih >=#"&tarihFormatla(tarihx)&"#"   
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
ATek=rs("Atek")
ACok=rs("Acok")

sql = "select sum(tekil) As Ytek, SUM(cogul) as YCok FROM sayac"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
YTek=rs("Ytek")
YCok=rs("Ycok")

%>
                Bugün Tekil</td>
              <td width="149" valign="middle" class="baslik"><%=BTek%></td>
              <td width="85" valign="middle" class="standart">Bu Ay Tekil </td>
              <td width="186" valign="middle" class="baslik"><%=ATek%></td>
              <td width="92" valign="middle" class="standart">Toplam Tekil </td>
              <td width="177" valign="middle" class="baslik"><%=YTek%></td>
              <td width="131" valign="bottom" class="vurgu">TOPLAM</td>
            </tr>
            <tr>
              <td valign="middle" class="standart">Bugün Çoğul</td>
              <td valign="middle" class="baslik"><%=BCok%></td>
              <td valign="middle" class="standart">Bu Ay Çoğul </td>
              <td valign="middle" class="baslik"><%=ACok%></td>
              <td valign="middle" class="standart">Toplam Çoğul </td>
              <td valign="middle" class="baslik"><%=YCok%></td>
              <td valign="bottom" class="baslik"><%=Cint(YTek)+cint(YCok)%></td>
            </tr>
            <tr>
              <td colspan="7">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="7" bgcolor="#E8F3FF" class="tablogri2"><strong class="vurgu"> GRAFİKSEL GÖSTERİM </strong></td>
            </tr>
            <tr>
              <td height="30" colspan="7"><form name="form1" method="post" action="sayac.asp">
                  <table width="100%" border="0" cellpadding="0" cellspacing="2" class="tablogri4">
                    <tr>
                      <td width="26%" class="standart">Grafiğini görmek istediğiniz ay ve yılı giriniz.</td>
                      <td width="74%" class="standart">Ay
                        <input name="ay" type="text" class="KUTUCUK" id="ay" size="2" maxlength="2">
                        Yıl
                        <input name="yil" type="text" class="KUTUCUK" id="yil" size="4" maxlength="4">
                        <input name="Submit" type="submit" class="tabloyesil" value="Göster">
                        <%
if request.form("ay")="" and request.form("yil")="" then    
response.Write("Bu aya ait istatistik görüntüleniyor.")
else
response.Write(request.form("ay")&"."&request.form("yil")&" tarihine ait istatistik görüntüleniyor.")
end if                
%>                      </td>
                    </tr>
                  </table>
              </form></td>
            </tr>
            <tr>
              <td colspan="7"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="standart">
                  <tr>
                    <td align="center" valign="bottom" background="images/barback.gif" class="tablogri2"><strong>Hit</strong><br>
                      Tekil<br>
                      Çoğul<br>
                      <img src="images/bar.gif"  width="20" height="80"><br>
                      <span class="tablomavi">Gün</span></td>
                    <%
				  if request.form("ay")<>"" and request.form("yil")<>"" then
				  saygun=01&"."&request.form("ay")&"."& request.form("yil")
				  else
				  saygun=date()
				  end if
				  
				  for i=1 to DateDiff("d", saygun, DateAdd("m", 1, saygun))
				  'on error resume next
				  if request.form("ay")<>"" and request.form("yil")<>"" then
				  tarihx=i&"."&request.form("ay")&"."&request.form("yil")
				  else
				  tarihx=i&"."&month(date)&"."&year(date)
				  end if
				  
				  sql = "SELECT * FROM sayac"
				  set rs = server.createobject("ADODB.Recordset")
				  rs.open sql, con, 1, 3
				  
				  do while not rs.eof
				  if rs("tarih")=cdate(tarihx) then  
				    tek=(rs("tekil")+rs("cogul")) *0.1
				    toplamx=rs("tekil")+rs("cogul")
					tx=rs("tekil")
					cx=rs("cogul")
				  end if	
				  rs.movenext
				  loop
				  
				  
				  %>
                    <td height="150" align="center" valign="bottom" background="images/barback.gif"><%
				
				if toplamx=null or toplamx="" then 
				response.Write("")
				else
				response.Write(tx&"<br>"&cx)
				end if
				%>
                        <br>
                        <img src="images/bar.gif"  width="20" height="<%=cint(tek)%>"><br>
                        <strong class="tablomavi"><%=i%></strong></td>
                    <%
				  toplamx=0
				  tek=0
				  tx=null
				  cx=null
				  next
				  %>
                  </tr>
                  <tr>
                    <td colspan="2"  valign="bottom">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="7"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="standart">
                <tr>
                  <td colspan="2" bgcolor="#E8F3FF" class="tablogri2"><strong>REFERER SİTELER</strong> </td>
                </tr>
                <tr>
                  <td width="10%"><strong>Hit</strong></td>
                  <td width="90%"><strong>Referer Site </strong></td>
                </tr>
              </table>
                <%
				  sql = "SELECT * FROM REFERER order by hitsay desc"
				  set rs = server.createobject("ADODB.Recordset")
				  rs.open sql, con, 1, 3 
				  do while not rs.eof
				  %>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="standart">
                  <tr>
                    <td width="10%"><%=rs("hitsay")%></td>
                    <td width="90%"><%=rs("referersite")%></td>
                  </tr>
                </table>
                <%
				  rs.movenext
				  loop
				  rs.close					
				  %></td>
            </tr>
          </table>
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><div align="center"><span class="standart">DCEmlak 2007© Gürkan KARA tarafından programlanmıştır. gurkan@designcube.net </span></div></td>
  </tr>
</table>
</body>
</html>
