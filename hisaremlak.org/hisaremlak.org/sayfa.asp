<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link href="stil.css" rel="stylesheet" type="text/css">
<!-- #include file = template.asp -->
<%
sub sayfa()
on error resume next
%>
<%
sql = "select * FROM sayfa where id="&cint(request.querystring("id"))
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
if rs.recordcount>0 then
%>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="4">
  <tr>
    <td height="33" colspan="3" valign="top" class="baslik"><%=ucase(rs("sayfaadi"))%></td>
  </tr>
  <tr>

    <td valign="top"><div align="justify"><span class="standart"><%=rs("sayfa")%></span></div></td>
  </tr>
</table>
<%
end if
end sub
%>
