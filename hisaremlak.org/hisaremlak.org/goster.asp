<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link href="stil.css" rel="stylesheet" type="text/css">
<!-- #include file = template.asp -->
<%
sub sayfa()
on error resume next
%>
<%
sql = "select * FROM emlak where id="&cint(request.querystring("emlakid"))
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3 
%>
<style type="text/css">
<!--
.style1 {color: #CC0000}
-->
</style>
<table width="596"  border="0" cellpadding="0" cellspacing="4">
  <tr>
    <td valign="top" class="standart"><div align="center">
      <table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" class="standart">
        <tr valign="top">
          <td height="16" colspan="2" class="baslik"><img src="images/tit_emlakbilgi.gif" width="596" height="39" /></td>
        </tr>
        <tr valign="top">
          <td height="31" valign="middle" class="baslik"><span class="vurgu">Emlak Tipi </span></td>
          <td height="31" valign="middle" class="baslik"><span class="style1"><%=rs("emlaktip")%></span></td>
        </tr>
        <tr valign="top">
          <td width="18%" valign="middle" class="vurgu">Emlak Durumu </td>
          <td width="82%" valign="middle" class="standart">:
            <%
				  if rs("emlakdurum")="k" then
				  response.write "Kiralık"
				  else
				  response.write "Satılık"
				  end if 
				  %></td>
        </tr>
        <tr valign="top">
          <td valign="middle" class="vurgu">Bulunduğu İl </td>
          <td valign="middle" class="standart">: <%=rs("il")%></td>
        </tr>
        <tr valign="top">
          <td valign="middle" class="vurgu">İlçe / Semt </td>
          <td valign="middle" class="standart">: <%=rs("ilce")%></td>
        </tr>
        <tr valign="top">
          <td valign="middle" class="vurgu">m2</td>
          <td valign="middle" class="standart">: <%=rs("m2")%></td>
        </tr>
        <tr valign="top">
          <td valign="middle" class="vurgu">Oda Sayısı </td>
          <td valign="middle" class="standart">: <%=rs("oda")%></td>
        </tr>
        <tr valign="top">
          <td valign="middle" class="vurgu">Fiyatı</td>
          <td valign="middle" class="standart">: <%=rs("fiyat")%></td>
        </tr>
        <tr valign="top">
          <td valign="middle" class="vurgu">Notlar</td>
          <td valign="middle" class="standart"><div align="justify">:&nbsp;<%=rs("not")%></div></td>
        </tr>
        <tr valign="top">
          <td class="vurgu">&nbsp;</td>
          <td class="standart">&nbsp;</td>
        </tr>
      </table>
    </div></td>
    </tr>
  
  <tr>
    <td valign="top" class="standart"><img src="images/tit_resim.gif" alt=" " width="596" height="37" /></td>
  </tr>
  <tr>
    <td valign="top" class="standart">
      <%
sql = "select * FROM resim WHERE emlakid="&cint(request.querystring("emlakid"))
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3 					
do while not rs.eof
%>  &nbsp;&nbsp; <a href="<%="resimarsiv/"&rs("resim")%>" target="_blank"><img src="<%="resimarsiv/thumb/"&rs("resim")%>" alt="Büyük halini görmek için tıklayın" border="0" class="tablogri3" /></a>&nbsp;&nbsp;&nbsp;
  <%
rs.movenext
loop
%>    </td>
  </tr>
  <tr>
    <td valign="top" class="standart">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="standart"><span class="vurgu"><img src="images/tit_video.gif" width="596" height="43" /></span></td>
  </tr>
  <tr>
    <td valign="top" class="standart">
<%
sql = "select * FROM emlak WHERE id="&cint(request.querystring("emlakid"))
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3 	
if rs("video")<>"" or rs("video")<>null then 
%>
     <p id="player1"><a href="http://www.macromedia.com/go/getflashplayer"><strong>Videoyu seyretmek için Flash Player yüklemelisiniz.</strong></a> </p>
      <script type="text/javascript">
	var FO = {	movie:"flvplayer.swf",width:"400",height:"250",majorversion:"7",build:"0",bgcolor:"#FFFFFF",
				flashvars:"file=<%="videoarsiv/"&rs("video")%>&showdigits=false&autostart=true&showfsbutton=true&repeat=true" };
	UFO.create(	FO, "player1");
      </script>
<%
else
response.write "Video dosyası mevcut değil"
end if
%></td>
  </tr>
  <tr>
    <td valign="top" class="standart">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="standart"><form id="form1" name="form1" method="post" action="mailyolla.asp?action=bilgial">
      <img src="images/tit_bilgi.gif" alt=" " width="596" height="42" />
      <table width="100%" border="0" cellspacing="2" cellpadding="0">

        <tr class="standart">
          <td width="40%">Adınız, Soyadınız 
              <strong><br />
              <input name="textfield2" type="text" class="tablo_TEXTBOX" size="39" />
              </strong></td>
          <td width="60%" rowspan="2" valign="top">Mesajınız
            <br />
            <textarea name="textarea3" cols="45" rows="6" class="tablo_TEXTBOX"></textarea></td>
        </tr>
        <tr class="standart">
          <td>İletişim Bilgileri (Telefon, email) <strong><br />
              <textarea name="textarea" cols="38" rows="3" class="tablo_TEXTBOX"></textarea>
              </strong></td>
          </tr>
        <tr class="standart">
          <td colspan="2"><img src="images/spacer.gif" width="20" height="8" /></td>
          </tr>
        <tr class="standart">
          <td colspan="2">            <input name="Submit" type="submit" class="tablo_TEXTBOX" value="GÖNDER" />          </td>
          </tr>
      </table>
        </form>    </td>
  </tr>
</table>
<%end sub%>
