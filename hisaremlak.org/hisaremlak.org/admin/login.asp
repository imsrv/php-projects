<link href="stil.css" rel="stylesheet" type="text/css">
<!-- #include file = dbbaglan.asp -->
<%
session("giris")= false
set rs = server.createobject("ADODB.Recordset")
Rs.Open "SELECT * FROM admin WHERE user like '"&request("user")&"' and pass like '"&request("pass")&"' ", con, 1, 3
if rs.bof and rs.eof then
%>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="27%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FF0000">
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="baslik">HATA!</div></td>
  </tr>
  <tr>
    <td height="132" bgcolor="#FFFFCC"><div align="center" class="vurgu"><img src="images/icon13.gif" width="41" height="41"><br>
      <br>
      Yanlis Kullanici Adi / Sifre girildi.<br>
        <br>
          <span class="standart"><a href="javascript:history.go(-1);">[Geri dönmek için tiklayin]</a> </span> </div>      
      </td>
  </tr>
</table>
<%
  rs.close
  else

  session("admingiris")= true
  session.Timeout=30
  
rs.close
Response.Redirect "default.asp" 
end if
%> 
