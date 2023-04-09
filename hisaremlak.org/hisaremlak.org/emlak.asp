<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link href="stil.css" rel="stylesheet" type="text/css">
<!-- #include file = template.asp -->
<%
sub sayfa()
on error resume next
if request.QueryString("action")="k" then
%>
<table width="100%"  border="0" cellpadding="0" cellspacing="3">
  <tr>
    <td colspan="3"><img src="images/tit_kiralik.gif" width="596" height="39" /></td>
  </tr>
  <tr>
    <td valign="top"><%
sql = "select * FROM emlak where emlakdurum='k'"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3 
%>
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

  </tr>
</table>
<%
end if
if request.QueryString("action")="s" then
%>
<table width="100%"  border="0" cellpadding="0" cellspacing="3">
  <tr>
    <td colspan="3"><img src="images/tit_satilik.gif" width="596" height="39" /></td>
  </tr>
  <tr>
    <td valign="top"><%
sql = "select * FROM emlak where emlakdurum='s'"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3 
%>        
      <table width="100%" border="0" cellpadding="0" cellspacing="3" class="vurgu" style="border-collapse: collapse">
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
  </tr>
</table>
<%
rs.close
end if
end sub
%>
