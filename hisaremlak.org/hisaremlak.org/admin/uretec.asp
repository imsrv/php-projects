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
        <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon15.gif" width="41" height="41"></div></td>
        <td width="91%" class="tablogri2"><span class="baslik">SAYFA ÜRETECİ </span></td>
      </tr>
      <tr>
        <td colspan="2"><%
if request.querystring("action")="form" then
%>          <form name="form1" method="post" action="actions.asp?step=uretec&action=kayit">
          <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="vurgu">
            <tr valign="top">
              <td width="100%" height="28"><div align="justify" class="standart">Bu bölümden sitenize içerik olarak sayfa ekleyebilirsiniz. Eklediğiniz sayfalar ana sayfada ana menüye eklenir. </div></td>
            </tr>
            <tr valign="top">
              <td class="tablogri2"><div align="center" class="vurgu">
                <div align="left">SAYFA ADI </div>
              </div></td>
            </tr>
            <tr valign="top">
              <td>                  <div align="center">
                <input name="sayfaadi" type="text" style="width:100%" class="KUTUCUK" id="sayfaadi" size="109">
              </div></td>
            </tr>
            <tr valign="top">
              <td class="tablogri2"><div align="center" class="vurgu">
                <div align="left">SAYFA İÇERİĞİ </div>
              </div></td>
            </tr>
            <tr valign="top">
              <td class="tablogri2">
                <textarea name="sayfa" cols="100" style="width:100%; height:200"></textarea>
<script language="javascript1.2">
editor_generate('sayfa');
</script>
			
              </td>
            </tr>
            <tr valign="top">
              <td><div align="center">
                <input name="Submit" type="submit" class="tabloyesil" value="SAYFA İÇERİĞİNİ KAYDET">
              </div></td>
            </tr>
          </table>
        </form>          
          <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="standart">
            <tr class="vurgu">
              <td colspan="3" class="tablogri2">KAYITLI SAYFALAR </td>
            </tr>
<%
sql = "SELECT * FROM sayfa order by id desc"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
if rs.recordcount>0 then
do while not rs.eof
%>
            <tr>
              <td width="92%"><%=rs("sayfaadi")%></td>
              <td width="4%"><div align="right"> <a href="uretec.asp?action=edit&id=<%=rs("id")%>"> <img src="images/icon12.gif" width="16" height="16" border="0"></a></div></td>
              <td width="4%"><div align="right"> <a href="javascript:OnayIste('Bu işlemi geri alamayacaksınız. Kaydı silmek istediğinizden emin misiniz?','actions.asp?step=uretec&action=sil&id=<%=rs("id")%>')"> <img src="images/icon11.gif" alt="Bu emlak kaydını sil!" width="16" height="16" border="0"></a></div></td>
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
sql = "SELECT * FROM sayfa WHERE id="&request.querystring("id")
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
%>		  
          <form name="form1" method="post" action="actions.asp?step=uretec&action=edit&id=<%=request.querystring("id")%>">
            <table width="100%"  border="0" cellpadding="0" cellspacing="2" class="vurgu">
              <tr valign="top">
                <td width="100%" height="28"><div align="justify" class="standart">		
				Bu bölümde sayfa içeriğini görebilir ve düzenleyebilirsiniz. </div></td>
              </tr>
              <tr valign="top">
                <td class="tablogri2"><div align="center" class="vurgu">
                    <div align="left">SAYFA ADI </div>
                </div></td>
              </tr>
              <tr valign="top">
                <td>
                  <div align="center">
                    <input name="sayfaadi" type="text" class="KUTUCUK" id="sayfaadi" value="<%=rs("sayfaadi")%>" size="108">
                </div></td>
              </tr>
              <tr valign="top">
                <td class="tablogri2"><div align="center" class="vurgu">
                    <div align="left">SAYFA İÇERİĞİ </div>
                </div></td>
              </tr>
              <tr valign="top">
                <td class="tablogri2">
                  <textarea name="sayfa" id="sayfa" style="width:100%; height:200"><%=rs("sayfa")%></textarea>
<script language="javascript1.2">
editor_generate('sayfa');
</script>
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
