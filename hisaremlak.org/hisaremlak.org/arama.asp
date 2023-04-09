<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link href="stil.css" rel="stylesheet" type="text/css">
<!-- #include file = template.asp -->
<%
sub sayfa()
on error resume next

sorgu="SELECT * FROM emlak WHERE "

if request.form("sehir")<>"Farketmez" then
sorgu=sorgu&" il='"&request.form("sehir")&"' "
if request.form("durum")="f" and request.form("emlaktip")<>"Farketmez" then
sorgu=sorgu&"and "
end if
end if

if request.form("durum")<>"f" then
if request.form("sehir")<>"Farketmez" then 
sorgu=sorgu&"and "
end if
sorgu=sorgu&" emlakdurum='"&request.form("durum")&"' "
end if

if request.form("emlaktip")<>"Farketmez" then
if request.form("durum")<>"f" then 
sorgu=sorgu&"and "
end if
sorgu=sorgu&" emlaktip='"&request.form("emlaktip")&"' "
end if

if request.form("minfiyat")<>"" and request.form("maxfiyat")<>"" then
sorgu=sorgu&"and fiyat between "&request.form("minfiyat")&" and "&request.form("maxfiyat")
end if

if request.form("minfiyat")<>"" and request.form("maxfiyat")="" then
sorgu=sorgu&"and fiyat  >"&request.form("minfiyat")
end if

if request.form("minfiyat")="" and request.form("maxfiyat")<>"" then
sorgu=sorgu&"and fiyat  <"&request.form("maxfiyat")
end if

sorgu=sorgu&" order by id desc"
%>

<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><table width="100%"  border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td height="10"><img src="images/tit_arama.gif" width="596" height="22" /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
<%
sql = sorgu
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3 
do while not rs.eof 
%>
    <td valign="top">
        <table width="100%" border="0" cellpadding="0" cellspacing="4" class="vurgu" style="border-collapse: collapse">
          <tr valign="bottom">
<%
for i=1 to rs.recordcount
bol = 4 
yuzde = CInt(100/bol) 
If not i mod bol = 0 Then 
%>
            <td width="<%=yuzde %>%"><div align="center">
                <table width="100%"  border="0" cellpadding="0" cellspacing="4">
                  <tr>
                    <td height="31" class="standart">
                      <div align="center">
                        <%
xsql = "select * FROM resim WHERE emlakid="&cint(rs("id"))
set xrs = server.createobject("ADODB.Recordset")
xrs.open xsql, con, 1, 3 
if xrs.recordcount<>0 then
  emlakresim="resimarsiv/thumb/"&xrs("resim")
else
  emlakresim="images/resimyok.gif"
end if 					
%>
<a href="goster.asp?emlakid=<%=rs("id")%>"><img src="<%=emlakresim%>" border="0" class="tablogri3"></a>   
                    </div></td>
                  </tr>
                  <tr>
                    <td height="18" class="standart">
                      <div align="center"><a href="goster.asp?emlakid=<%=rs("id")%>"><strong><%=rs("emlaktip")%></strong><br>
                            <%=rs("il")%> (<%=rs("ilce")%>)<br>
                            <%=rs("fiyat")%> YTL</a></div></td>
                  </tr>
              </table>
            </div></td>
            <% ElseIf i mod bol = 0 Then %>
            <td width="<%=yuzde %>%"><div align="center">
                <table width="100%"  border="0" cellpadding="0" cellspacing="4">
                  <tr>
                    <td height="31" class="standart">
                      <div align="center">
                        <%
xsql = "select * FROM resim WHERE emlakid="&cint(rs("id"))
set xrs = server.createobject("ADODB.Recordset")
xrs.open xsql, con, 1, 3 
if xrs.recordcount<>0 then
  emlakresim="resimarsiv/thumb/"&xrs("resim")
else
  emlakresim="images/resimyok.gif"
end if 					
%>
<a href="goster.asp?emlakid=<%=rs("id")%>"><img src="<%=emlakresim%>" border="0" class="tablogri3"></a>   
                    </div></td>
                  </tr>
                  <tr>
                    <td height="18" class="standart">
                      <div align="center"><a href="goster.asp?emlakid=<%=rs("id")%>"><strong><%=rs("emlaktip")%></strong><br>
                            <%=rs("il")%> (<%=rs("ilce")%>)<br>
                            <%=rs("fiyat")%> YTL</a></div></td>
                  </tr>
              </table>
            </div></td>
          </tr>
          <tr> </tr>
          <tr>
            <% 
End If 
rs.Movenext 
next
%>
          </tr>
      </table></td>
    <%
rs.movenext
loop
%>
  </tr>
</table>
<%end sub%>