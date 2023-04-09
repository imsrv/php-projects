<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link href="stil.css" rel="stylesheet" type="text/css">
<!-- #include file = template.asp -->
<%
sub sayfa()
on error resume next
%>

<table width="100%"  border="0" cellpadding="0" cellspacing="4" class="standart">
  <tr>
    <td colspan="3"><img src="images/tit_haberler.gif" width="596" height="35" /></td>
  </tr>
<%
sql = "select * FROM haber ORDER BY id desc"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
if rs.recordcount>0 then
do while not rs.eof 
%>  
  <tr>

    <td><table width="100%"  border="0" cellpadding="0" cellspacing="4" class="standart">
      <tr>
        <td><div align="justify"><strong><%=rs("baslik")%></strong> - <%=rs("tarih")%> <br />
                <%=rs("haber")%></div></td>
      </tr>
    </table></td>
  </tr>
<%
rs.movenext
loop
end if
%>  
</table>
<%
end sub
%>
