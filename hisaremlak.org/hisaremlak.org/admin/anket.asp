<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Emlak Portalı - Yönetim Bölümü</title>
<link href="stil.css" rel="stylesheet" type="text/css">
</head>

<body>
<!-- #include file = "../config.asp" -->
<!-- #include file = "dbbaglan.asp" -->
<table width="800"  border="0" align="center" cellpadding="0" cellspacing="4" class="tablogri2">
  <tr>
    <td valign="top" class="tablogri4"><!-- #include file = "menu.asp" --></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><table width="100%"  border="0" cellpadding="4" cellspacing="4">
      <tr>
        <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon16.gif" width="41" height="41"></div></td>
        <td width="91%" class="tablogri2"><span class="baslik">ANKETLER</span></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%"  border="0" cellpadding="0" cellspacing="2" class="vurgu">
            <tr valign="top">
              <td height="28" colspan="2"><div align="justify" class="standart">Şu anda veritabanında kayıtlı emlaklara ait istatistiki bilgileri aşağıda görebilirsiniz. </div></td>
            </tr>
            <tr valign="top">
              <td colspan="2" class="tablogri2">ANKET YÖNETİMİ </td>
            </tr>
            <tr>
              <td width="16%">&nbsp;</td>
              <td width="84%">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><% 
Response.Buffer = True 
gorev=request.querystring("gorev")

%>
                <P> <B>MEVCUT ANKETLER</B>
                <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#F7F7F7" background="" bgcolor="" class="tablogri4">
                  <% sor="select * from anket  where soruid=0  order by id desc"
efkan.Open sor,Sur,1,3
if efkan.eof or efkan.bof then
Response.Write "<BR><BR><BR><CENTER><B>Anket Yok</B></CENTER>"
end if
do while not efkan.eof   'ANKET SORULARINI DİZ
%>
                  <tr bgcolor="#F8F8F8">
                    <td align="LEFT" width="80%"><B><%=efkan("konu")%></B>&nbsp;&nbsp;<%=efkan("tarih")%></td>
                    <TD align="center" width="20%"><B><A HREF="default.asp?gorev=sil&id=<%=efkan("id")%>">ANKETİ SİL</A></B></TD>
                  </tr>
                  <%sor="select * from anket where soruid = "& efkan("id") &"    "
efkan1.Open sor,Sur,1,3
do while not efkan1.eof   'SEÇENEKLERİ DİZ
%>
                  <tr>
                    <td><li><%=efkan1("konu")%></td>
                    <td align="right"><%=efkan1("hit")%> Hit</td>
                  </tr>
                  <% 
efkan1.movenext 
loop 
efkan1.close
efkan.movenext 
loop 
efkan.close
%>
                </table>
                <% end if 

if gorev="sil" Then


id=Request.querystring("id")
sor="Delete  from anket where id="&id&" or soruid="&id&"   "
efkan.Open sor,Sur,1,3
Response.write "Bu Anket Silindi"
Response.Redirect "default.asp?"
end if


%>
                <form action="default.asp?gorev=ekle2" method="POST" >
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#EBEBEB" background="" bgcolor="" class="standart">
                    <tr>
                      <TD align="center" valign="center" width="100%" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                        <B>Anket Sorusu</B>
                          <input name="konu" size="40">
                          <br>
                       
                          <B>Secenek 1</B>
                          <input name="konu1" size="40">
                        
                          <br>
                          <B>Seçenek 2</B>
                          <input name="konu2" size="40">
                       
                          <br>
                          <B>Secenek 3</B>
                          <input name="konu3" size="40">
                      
                          <B><br>
                          Secenek 4</B>
                          <input name="konu4" size="40">
                        
                          <B><br>
                          Secenek 5</B>
                          <input name="konu5" size="40">
                          <P>
                            <input type="hidden" name="tarih" size="30"   value="<%=(Date)%>">
                            <input name="submit" type="submit" value=" Anketi Ekle ">
                          </p>
                        <BR>
                      </TD>
                    </tr>
                  </table>
                </form>
                <%


if gorev="ekle2" then 

sor="select * from anket  "
efkan.Open sor,Sur,1,3

if  request.form("konu")="" or request.form("konu1")="" or  request.form("konu2")="" then
Response.Write "<BR><BR><BR><center>Ankette bir konu ve en az 2 seçenek olmalıdır<br> Lütfen <a href=""javascript:history.back(1)""><B>geri</B></a> gidip tekrar deneyiniz"
response.end
end if

efkan.AddNew
efkan("konu")=trim(request.form("konu"))
efkan("tarih") = Request.Form ("tarih")
efkan.update
id=efkan("id")

if  request.form("konu1")<>"" then
efkan.AddNew
efkan("soruid")=id
efkan("konu")=trim(request.form("konu1"))
efkan.update
end if

if request.form("konu2")<>""  then
efkan.AddNew
efkan("soruid")=id
efkan("konu")=trim(request.form("konu2"))
efkan.update
end if
if request.form("konu3")<>""  then
efkan.AddNew
efkan("soruid")=id
efkan("konu")=trim(request.form("konu3"))
efkan.update
end if
if request.form("konu4")<>""  then
efkan.AddNew
efkan("soruid")=id
efkan("konu")=trim(request.form("konu4"))
efkan.update
end if
if request.form("konu5")<>""  then
efkan.AddNew
efkan("soruid")=id
efkan("konu")=trim(request.form("konu5"))
efkan.update
end if
efkan.close
response.redirect "anket.asp?"
end if
%></td>
              </tr>
            
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><div align="center"><span class="standart">DCEmlak 2007© Gürkan KARA tarafından programlanmıştır. gurkan@designcube.net </span></div></td>
  </tr>
</table>
</body>
</html>
