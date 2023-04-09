<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Emlak Portalı - Yönetim Bölümü</title>
<link href="stil.css" rel="stylesheet" type="text/css">
<script language="Javascript1.2"><!-- // load htmlarea
_editor_url = "";                     // URL to htmlarea files
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
  document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js"');
  document.write(' language="Javascript1.2"></scr' + 'ipt>');  
} else { document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); }
// --></script>
<SCRIPT language=Javascript src="javascripts.js"></SCRIPT>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
</head>

<body>
<!-- #include file = "../config.asp" -->
<!-- #include file = "dbbaglan.asp" -->
<script language="javascript1.2">
var config = new Object();    // create new config object

config.width = "100%";
config.height = "200px";
config.bodyStyle = 'background-color: white; font-family: "Verdana"; font-size: x-small;';
config.debug = 0;

// NOTE:  You can remove any of these blocks and use the default config!

config.toolbar = [
    ['fontname'],
    ['fontsize'],
    ['fontstyle'],
    ['linebreak'],
    ['bold','italic','underline','separator'],
//  ['strikethrough','subscript','superscript','separator'],
    ['justifyleft','justifycenter','justifyright','separator'],
    ['OrderedList','UnOrderedList','Outdent','Indent','separator'],
    ['forecolor','backcolor','separator'],
    ['HorizontalRule','Createlink','InsertImage','htmlmode','separator'],
    ['about','help','popupeditor'],
];

config.fontnames = {
    "Arial":           "arial, helvetica, sans-serif",
    "Courier New":     "courier new, courier, mono",
    "Georgia":         "Georgia, Times New Roman, Times, Serif",
    "Tahoma":          "Tahoma, Arial, Helvetica, sans-serif",
    "Times New Roman": "times new roman, times, serif",
    "Verdana":         "Verdana, Arial, Helvetica, sans-serif",
    "impact":          "impact",
    "WingDings":       "WingDings"
};
config.fontsizes = {
    "1 (8 pt)":  "1",
    "2 (10 pt)": "2",
    "3 (12 pt)": "3",
    "4 (14 pt)": "4",
    "5 (18 pt)": "5",
    "6 (24 pt)": "6",
    "7 (36 pt)": "7"
  };

//config.stylesheet = "http://www.domain.com/sample.css";
  
config.fontstyles = [   // make sure classNames are defined in the page the content is being display as well in or they won't work!
  { name: "headline",     className: "headline",  classStyle: "font-family: arial black, arial; font-size: 28px; letter-spacing: -2px;" },
  { name: "arial red",    className: "headline2", classStyle: "font-family: arial black, arial; font-size: 12px; letter-spacing: -2px; color:red" },
  { name: "verdana blue", className: "headline4", classStyle: "font-family: verdana; font-size: 18px; letter-spacing: -2px; color:blue" }

// leave classStyle blank if it's defined in config.stylesheet (above), like this:
//  { name: "verdana blue", className: "headline4", classStyle: "" }  
];
</script>	
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="4" class="tablogri2">
  <tr>
    <td valign="top" class="tablogri4"><!-- #include file = "menu.asp" --></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><table width="100%"  border="0" cellpadding="4" cellspacing="4">
      <tr>
        <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon6.gif" width="41" height="41"></div></td>
        <td width="91%" class="tablogri2"><span class="baslik">AYARLAR</span></td>
      </tr>
      <tr>
        <td colspan="2"><form name="form1" method="post" action="actions.asp?step=ayar&action=sifredegis">
          <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="vurgu">
            <tr valign="top">
              <td height="28" colspan="2"><div align="justify" class="standart">Yönetim bölümüne giriş için kullanıcı adı ve şifre, kayıtlar ve görünüm ile ilgili ayarları bu bölümde değiştirebilirsiniz. </div></td>
            </tr>
            <tr valign="top">
              <td colspan="2" class="tablogri2">KULLANICI ADI / ŞİFRE DEĞİŞİKLİĞİ </td>
            </tr>
            <tr valign="top">
              <td colspan="2">
<%
 sql = "SELECT top 1 * FROM admin"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
%>
              </td>
            </tr>
            <tr>
              <td width="22%">Kullanıcı Adı </td>
              <td width="78%"><input name="user" type="text" id="user" value="<%=rs("user")%>"></td>
            </tr>
            <tr>
              <td>Şifre</td>
              <td><input name="pass" type="text" id="pass" value="<%=rs("pass")%>"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="Submit" type="submit" class="tabloyesil" value="KAYDET"></td>
            </tr>
          </table>
        </form></td>
      </tr>
      <tr>
        <td colspan="2"><form name="form2" method="post" action="actions.asp?step=ayar&action=iletisim">
          <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="standart">
            <tr valign="top">
              <td colspan="2" class="tablogri2"><strong>İLETİŞİM KISMI AYARLARI </strong></td>
            </tr>
            <tr valign="top">
              <td>
<%
 sql = "SELECT top 1 * FROM iletisim"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
%>			  
			  </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="22%"><strong>Mail Adresi </strong></td>
              <td width="78%"><input name="mail" type="text" id="mail2" value="<%=rs("mail")%>" size="40">
      Formun gönderileceği mail adresini girin. </td>
            </tr>
            <tr>
              <td><strong>Mail Bileşeni </strong></td>
              <td><select name="bilesen" id="bilesen">
                <option <%if rs("bilesen")="persist" then response.write "selected" %> value="persist">Persist ASP EMail</option>
                <option <%if rs("bilesen")="jmail" then response.write "selected" %> value="jmail">Jmail</option>
                <option <%if rs("bilesen")="cdosys" then response.write "selected" %> value="cdosys">CDOSYS</option>
                </select>
      Server Test kısmından desteklenen mail bileşenlerini görebilirsiniz. </td>
            </tr>
            <tr>
              <td height="20" colspan="2"><hr size="1"></td>
            </tr>
            <tr>
              <td><strong>İletişim Bilgileri </strong><br>
      Adres, Telefon vb. iletişim bilgilerinizi bu alana girebilirsiniz. </td>
              <td>
                <textarea name="sayfa" cols="100" style="width:100%; height:200"><%=rs("iletisim")%></textarea>
                <script language="javascript1.2">
editor_generate('sayfa');
          </script>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="Submit2" type="submit" class="tabloyesil" value="KAYDET"></td>
            </tr>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><div align="center"><span class="standart">DCEmlak 2007© Gürkan KARA tarafından programlanmıştır. gurkan@designcube.net </span></div></td>
  </tr>
</table>
<%call DBClose()%>
</body>
</html>
