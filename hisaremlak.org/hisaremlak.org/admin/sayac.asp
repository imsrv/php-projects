<% Session.LCID = 1055 %>
<html>
<head>
<title>E-Dergi Sistemi Yönetim Bölümü</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link href="../stil.css" rel="stylesheet" type="text/css">
<SCRIPT language=Javascript src="js/javascripts.js"></SCRIPT>
</head>

<body class="body">
<!-- #include file="DB_Islem.asp" -->
<table width="770"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#131C2B" bgcolor="#FFFFFF">
  <tr>
    <td height="286" valign="top"><table width="100%"  border="0" cellspacing="5" class="standart">
      <tr>
        <td height="20" bgcolor="#131C2B"><div align="center" class="baslik">YAZILARIM</div></td>
        </tr>
      <tr>
        <td height="81"><!-- #include file="menu.asp" --></td>
      </tr>
    </table>
      <table width="100%"  border="0" cellspacing="5" class="standart">
        <tr>
          <td width="100%" bgcolor="#C4E1FF"><div align="center" class="vurgu">SAYAC</div></td>
        </tr>
        <tr>
          <td>
		  
		  <table width="100%" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td colspan="7" bgcolor="#E8F3FF" class="tablogri2"><strong class="vurgu">SAYAÇ İSTATİSTİKLERİ </strong></td>
            </tr>
            <tr>
              <td width="95" height="25" valign="bottom" class="standart">
<%
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
              <td width="103" valign="bottom" class="baslikXXL"><%=BTek%></td>
              <td width="101" valign="bottom" class="standart">Bu Ay Tekil </td>
              <td width="118" valign="bottom" class="baslikXXL"><%=ATek%></td>
              <td width="98" valign="bottom" class="standart">Toplam Tekil </td>
              <td width="120" valign="bottom" class="baslikXXL"><%=YTek%></td>
              <td width="103" valign="bottom" class="vurgu">TOPLAM</td>
            </tr>
            <tr>
              <td valign="bottom" class="standart">Bugün Çoğul</td>
              <td valign="bottom" class="baslikXXL"><%=BCok%></td>
              <td valign="bottom" class="standart">Bu Ay Çoğul </td>
              <td valign="bottom" class="baslikXXL"><%=ACok%></td>
              <td valign="bottom" class="standart">Toplam Çoğul </td>
              <td valign="bottom" class="baslikXXL"><%=YCok%></td>
              <td valign="bottom" class="baslikXXL"><%=Cint(YTek)+cint(YCok)%></td>
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
%>
                      </td>
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
              </table>
                </td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="standart">
            <tr>
              <td colspan="2" bgcolor="#E8F3FF"><strong>REFERER SİTELER</strong> </td>
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
				  %>			
		  </td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</body>
</html>
