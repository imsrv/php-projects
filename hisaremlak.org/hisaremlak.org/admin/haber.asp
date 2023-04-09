<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Emlak Portalı - Yönetim Bölümü</title>
<link href="stil.css" rel="stylesheet" type="text/css">
<SCRIPT language=Javascript src="javascripts.js"></SCRIPT>
</head>

<body>
<!-- #include file = "../config.asp" -->
<!-- #include file = "dbbaglan.asp" -->

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="4" class="tablogri2">
  <tr>
    <td valign="top" class="tablogri4"><!-- #include file = "menu.asp" --></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><table width="100%"  border="0" cellpadding="4" cellspacing="4">
      <tr>
        <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon14.gif" width="41" height="41"></div></td>
        <td width="91%" class="tablogri2"><span class="baslik">HABERLER</span></td>
      </tr>
      <tr valign="top">
        <td colspan="2"><%
if request.querystring("action")="form" then
%>          <form name="form1" method="post" action="actions.asp?step=haber&action=kayit">
          <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="vurgu">
            <tr valign="top">
              <td width="100%" height="28"><div align="justify" class="standart">Bu bölümden sitenize haber ekleyebilirsiniz. </div></td>
            </tr>
            <tr valign="top">
              <td class="tablogri2"><div align="center" class="vurgu">
                <div align="left">HABER BAŞLIĞI </div>
              </div></td>
            </tr>
            <tr valign="top">
              <td> <div align="center">
                <input name="baslik" type="text" style="width:100%" class="KUTUCUK" id="baslik" size="109">
              </div></td>
            </tr>
            <tr valign="top">
              <td class="tablogri2"><div align="center" class="vurgu">
                <div align="left">HABER İÇERİĞİ </div>
              </div></td>
            </tr>
            <tr valign="top">
              <td class="tablogri2">
                <textarea name="haber" cols="100" id="haber" style="width:100%; height:150"></textarea>
			
              </td>
            </tr>
            <tr valign="top">
              <td><div align="center">
                <input name="Submit" type="submit" class="tabloyesil" value="HABERİ KAYDET">
              </div></td>
            </tr>
          </table>
        </form>          
          <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="standart">
            <tr class="vurgu">
              <td colspan="3" class="tablogri2">KAYITLI HABERLER </td>
            </tr>
<%
sql = "SELECT * FROM haber order by id desc"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
if rs.recordcount>0 then 
do while not rs.eof
%>
            <tr>
              <td><strong><%=rs("baslik")%> </strong><br>                
                <%=left(rs("haber"),100)%>... </td>
              <td width="4%"><div align="right"> <a href="haber.asp?action=edit&id=<%=rs("id")%>"> <img src="images/icon12.gif" width="16" height="16" border="0"></a></div></td>
              <td width="4%"><div align="right"> <a href="javascript:OnayIste('Bu işlemi geri alamayacaksınız. Kaydı silmek istediğinizden emin misiniz?','actions.asp?step=haber&action=sil&id=<%=rs("id")%>')"> <img src="images/icon11.gif" alt="Bu emlak kaydını sil!" width="16" height="16" border="0"></a></div></td>
            </tr>
            <%
rs.movenext
loop
end if
%>
          </table>
<%
end if
if request.querystring("action")="edit" then
sql = "SELECT * FROM haber WHERE id="&request.querystring("id")
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
%>		  
          <form name="form1" method="post" action="actions.asp?step=haber&action=edit&id=<%=request.querystring("id")%>">
            <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="vurgu">
              <tr valign="top">
                <td width="100%" height="28"><div align="justify" class="standart">		
				Bu bölümde haber içeriğini görebilir ve düzenleyebilirsiniz. </div></td>
              </tr>
              <tr valign="top">
                <td class="tablogri2"><div align="center" class="vurgu">
                    <div align="left">HABER BAŞLIĞI </div>
                </div></td>
              </tr>
              <tr valign="top">
                <td>
                  <div align="center">
                    <input name="baslik" type="text" class="KUTUCUK" id="baslik" value="<%=rs("baslik")%>" size="109">
                </div></td>
              </tr>
              <tr valign="top">
                <td class="tablogri2"><div align="center" class="vurgu">
                    <div align="left">HABER İÇERİĞİ </div>
                </div></td>
              </tr>
              <tr valign="top">
                <td class="tablogri2">
                  <textarea name="haber" id="haber" style="width:100%; height:150"><%=rs("haber")%></textarea>
                </td>
              </tr>
              <tr valign="top">
                <td><div align="center">
                    <input name="Submit2" type="submit" class="tabloyesil" value="DÜZENLEMEYİ KAYDET">
                </div></td>
              </tr>
            </table>
          </form>
          <%end if%></td>
      </tr>
    </table>
</td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><div align="center"><span class="standart">DCEmlak 2007© Gürkan KARA tarafından programlanmıştır. gurkan@designcube.net </span></div></td>
  </tr>
</table>
</body>
</html>
