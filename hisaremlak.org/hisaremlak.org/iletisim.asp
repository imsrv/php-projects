<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link href="stil.css" rel="stylesheet" type="text/css">
<!-- #include file = template.asp -->
<%
sub sayfa()
on error resume next
%>
<table width="100%"  border="0" cellpadding="0" cellspacing="3">
  <tr>
    <td colspan="3"><img src="images/tit_iletisim.gif" alt=" " width="596" height="42" /></td>
  </tr>
  <tr>
    <td>    
	<%if request.QueryString("action")="" then%>      <table width="100%"  border="0" cellpadding="0" cellspacing="4">
      <tr>
        <td valign="top" class="standart"><%
sql = "select TOP 1 * FROM iletisim"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3 
if rs.recordcount>0 then 
%>
            <div align="justify"> <%=rs("iletisim")%> <br>
                <%end if%>
          </div></td>
      </tr>
      <tr>
        <td valign="top" class="standart">&nbsp;</td>
      </tr>
    </table>
      <span class="vurgu"><img src="images/tit_iletisimform.gif" alt=" " width="596" height="42" /></span><br>
      <table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td valign="top" class="standart"><form name="form1" method="post" action="iletisim.asp?action=mailyolla">
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr class="standart">
                <td width="40%">Adınız, Soyadınız <strong><br />
                      <input name="textfield2" type="text" class="tablo_TEXTBOX" size="39" />
                </strong></td>
                <td width="60%" rowspan="2" valign="top">Mesajınız <br />
                    <textarea name="textarea3" cols="45" rows="9" style="width:100%" class="tablo_TEXTBOX"></textarea></td>
              </tr>
              <tr class="standart">
                <td>İletişim Bilgileri (Telefon, email) <strong><br />
                      <textarea name="textarea" cols="38" rows="6" class="tablo_TEXTBOX"></textarea>
                </strong></td>
              </tr>
              <tr class="standart">
                <td colspan="2"><img src="images/spacer.gif" width="20" height="8" /></td>
              </tr>
              <tr class="standart">
                <td colspan="2"><input name="Submit" type="submit" class="tablo_TEXTBOX" value="FORMU GÖNDER" />
                </td>
              </tr>
            </table>
          </form></td>
        </tr>
      </table>
      <%
	  end if
	  if request.QueryString("action")="tesekkur" then
	  %>
	  <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td height="328" class="standart"><div align="center">Mesajınız alınmıştır. Teşekkürler. </div></td>
        </tr>
      </table>
	  <%
	  end if
	  %>	  
    </td>
  </tr>
</table>
<%
if request.QueryString("action")="mailyolla" then
response.Redirect("iletisim.asp?action=tesekkur")
end if
%>
<%end sub%>
