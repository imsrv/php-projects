<!-- #include file = "../config.asp" -->
<!-- #include file = "dbbaglan.asp" -->
<%
'AYARLAR
if request.QueryString("step")="ayar" then

if request.QueryString("action")="sifredegis" then 
 sql = "select * FROM admin"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs.delete
 rs.update
 sql = "select * FROM admin"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3 
 rs.addnew
 rs("user")=request.Form("user")
 rs("pass")=request.Form("pass")
 rs.update
call DBClose()
response.Redirect("ayar.asp")
end if

if request.QueryString("action")="iletisim" then 
 sql = "select * FROM iletisim"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs.delete
 rs.update
 sql = "select * FROM iletisim"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3 
 rs.addnew
 if request.Form("mail")<>"" then    rs("mail")=request.Form("mail")
 if request.Form("bilesen")<>"" then rs("bilesen")=request.Form("bilesen")
 if request.Form("sayfa")<>"" then   rs("iletisim")=request.Form("sayfa")
 rs.update
call DBClose()
response.Redirect("ayar.asp")
end if

end if 'AYAR
%>


<%
'EMLAK
if request.QueryString("step")="emlak" then

if request.QueryString("action")="kayit" then 
 sql = "select * FROM emlak"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3 
 rs.addnew
 rs("emlakad")=request.Form("emlakad")
 rs("emlaktip")=request.Form("emlaktip")
 rs("emlakdurum")=request.Form("emlakdurum")
 rs("il")=request.Form("il")
 rs("ilce")=request.Form("ilce")
 rs("m2")=request.Form("m2")
 rs("oda")=request.Form("oda")
 rs("fiyat")=request.Form("fiyat")
 rs("not")=request.Form("not")
 rs("tarih")=date()

 session("a1")=request.Form("emlakad")
 session("a2")=request.Form("emlaktip")
 session("a3")=request.Form("emlakdurum")
 session("a4")=request.Form("il")
 session("a5")=request.Form("ilce")
 session("a6")=request.Form("m2")
 session("a7")=request.Form("oda")
 session("a8")=request.Form("fiyat")
 session("a9")=request.Form("not")
 
 rs.update
 id=rs("id")
call DBClose()
response.Redirect("emlak.asp?action=resim&emlakid="&id)
end if

if request.QueryString("action")="edit" then 
 sql = "select * FROM emlak where id="&request.QueryString("id")
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3 
 rs("emlakad")=request.Form("emlakad")
 rs("emlaktip")=request.Form("emlaktip")
 rs("emlakdurum")=request.Form("emlakdurum")
 rs("il")=request.Form("il")
 rs("ilce")=request.Form("ilce")
 rs("m2")=request.Form("m2")
 rs("oda")=request.Form("oda")
 rs("fiyat")=request.Form("fiyat")
 rs("not")=request.Form("not")
 rs("tarih")=date()

 session("a1")=request.Form("emlakad")
 session("a2")=request.Form("emlaktip")
 session("a3")=request.Form("emlakdurum")
 session("a4")=request.Form("il")
 session("a5")=request.Form("ilce")
 session("a6")=request.Form("m2")
 session("a7")=request.Form("oda")
 session("a8")=request.Form("fiyat")
 session("a9")=request.Form("not")
 
 rs.update
 id=rs("id")
call DBClose()
response.Redirect("emlak.asp?action=resim&emlakid="&id)
end if

'KAYIT VE RESÝM SÝL
if request.QueryString("action")="kayitsil" then 
 ON ERROR RESUME NEXT
 sql = "select * FROM emlak where id="&cint(request.QueryString("id"))
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3 
 emlakid=rs("id")
 rs.delete
 rs.update

sql = "SELECT * FROM resim where emlakid="&cint(emlakid)
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
do while not rs.eof
dosyax=rs("resim")
rs.delete
rs.update

Set FSO=Server.CreateObject("Scripting.FileSystemObject")
FSO.DeleteFile resimklasoru&dosyax
FSO.DeleteFile resimklasoru&"thumb\"&dosyax
rs.movenext
loop
call DBClose()
response.Redirect("emlak.asp?action=liste")
end if 'KAYIT VE RESÝM SÝL

'RESÝM THUMB & KAYIT
if request.QueryString("action")="thumb" then
emlakid = cint(request.QueryString("emlakid"))
Set Jpeg = Server.CreateObject("Persits.Jpeg")
Jpeg.Open resimklasoru&session("dosya")
L = 120
Jpeg.Width = L
Jpeg.Height = Jpeg.OriginalHeight * L / Jpeg.OriginalWidth
if Jpeg.OriginalHeight>90 then
Jpeg.Crop 0, 0, L, 90
end if
Jpeg.Save resimklasoru&"thumb\"&session("dosya")

sql = "SELECT * FROM resim" 
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
 rs.AddNew
 rs("emlakid") = emlakid
 rs("resim") = session("dosya")
 rs.update
call DBClose()
response.Redirect "emlak.asp?action=resim&emlakid="&emlakid
end if 'RESÝM THUMB & KAYIT


'VÝDEO KAYIT
if request.QueryString("action")="video" then
sql = "SELECT * FROM emlak WHERE id="&cint(request.QueryString("emlakid")) 
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
 rs("video") = session("dosya")
 rs.update
call DBClose()
response.Redirect "emlak.asp?action=liste"
end if 'VÝDEO KAYIT

'ANASAYFADA GÖSTER
if request.QueryString("action")="anasayfatrue" then
sql = "SELECT * FROM emlak WHERE id="&cint(request.QueryString("id")) 
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
 rs("anasayfa") = True
 rs.update
call DBClose()
response.Redirect "emlak.asp?action=liste"
end if 

if request.QueryString("action")="anasayfafalse" then
sql = "SELECT * FROM emlak WHERE id="&cint(request.QueryString("id")) 
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
 rs("anasayfa") = False
 rs.update
call DBClose()
response.Redirect "emlak.asp?action=liste"
end if 'ANASAYFADA GÖSTER



'RESÝM SÝL
if request.QueryString("action")="resimsil" then
on error resume next
GeriDon=request.ServerVariables("HTTP_REFERER")
sql = "SELECT * FROM resim where id="&request.QueryString("id")
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
dosyax=rs("resim")
rs.delete
rs.update
call DBClose()
Set FSO=Server.CreateObject("Scripting.FileSystemObject")
FSO.DeleteFile resimklasoru&dosyax
FSO.DeleteFile resimklasoru&"thumb\"&dosyax
response.redirect geridon
end if 'RESÝM SÝL

end if 'EMLAK
%>

<%
'URETEC
if request.QueryString("step")="uretec" then

if request.QueryString("action")="kayit" then 
 sql = "select * FROM sayfa"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs.addnew
 rs("sayfaadi")=request.Form("sayfaadi")
 rs("sayfa")=request.Form("sayfa")
 rs.update
call DBClose()
response.Redirect("uretec.asp?action=form")
end if

if request.QueryString("action")="edit" then 
 sql = "select * FROM sayfa where id="&cint(request.querystring("id"))
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs("sayfaadi")=request.Form("sayfaadi")
 rs("sayfa")=request.Form("sayfa")
 rs.update
call DBClose()
response.Redirect("uretec.asp?action=form")
end if

if request.QueryString("action")="sil" then 
on error resume next
 sql = "DELETE * FROM sayfa where id="&cint(request.querystring("id"))
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs.update
call DBClose()
response.Redirect("uretec.asp?action=form")
end if

end if 'URETEC
%>



<%
'HABER
if request.QueryString("step")="haber" then

if request.QueryString("action")="kayit" then 
 sql = "select * FROM haber"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs.addnew
 rs("baslik")=request.Form("baslik")
 rs("haber")=request.Form("haber")
 rs("tarih")=date()
 rs.update
call DBClose()
response.Redirect("haber.asp?action=form")
end if

if request.QueryString("action")="edit" then 
 sql = "select * FROM haber where id="&cint(request.querystring("id"))
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs("baslik")=request.Form("baslik")
 rs("haber")=request.Form("haber")
 rs.update
call DBClose()
response.Redirect("haber.asp?action=form")
end if

if request.QueryString("action")="sil" then 
on error resume next
 sql = "DELETE * FROM haber where id="&cint(request.querystring("id"))
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs.update
call DBClose()
response.Redirect("haber.asp?action=form")
end if

end if 'HABER
%>





<%
'KATEGORI
if request.QueryString("step")="kategori" then

if request.QueryString("action")="kayit" then 
 sql = "select * FROM kategori"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs.addnew
 rs("kategori")=request.Form("kategori")
 rs.update
response.Redirect("kategori.asp")
end if

if request.QueryString("action")="edit" then 
 sql = "select * FROM haber where id="&cint(request.querystring("id"))
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs("baslik")=request.Form("baslik")
 rs("haber")=request.Form("haber")
 rs.update
response.Redirect("haber.asp?action=form")
end if

if request.QueryString("action")="sil" then 
on error resume next
 sql = "DELETE * FROM kategori where id="&cint(request.querystring("id"))
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs.update
response.Redirect("kategori.asp")
end if

call DBClose()
end if 'KATEGORI
%>