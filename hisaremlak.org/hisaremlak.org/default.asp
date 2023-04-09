<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link href="stil.css" rel="stylesheet" type="text/css">
<!-- #include file = template.asp -->
<!-- #include file = sayacsay.asp -->
<%
sub sayfa()
on error resume next
%>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="3">
  <tr>
    <td height="54"><table width="596" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="images/box_ust.gif" width="596" height="43" /></td>
        </tr>
      <tr>
        <td height="131" valign="top" background="images/box_back.gif">
		<table width="100%" border="0" cellspacing="3">
          <tr>
            <td>
<div id="tempholder"></div>
        <script language="JavaScript" src="dhtmllib.js" type="text/javascript"></script>
        <script language="JavaScript" src="scroller.js" type="text/javascript"></script>
        <script language="JavaScript" type="text/javascript">

/*
Mike's DHTML scroller (By Mike Hall)
Last updated July 21st, 02' by Dynamic Drive for NS6 functionality
For this and 100's more DHTML scripts, visit http://www.dynamicdrive.com
*/

//SET SCROLLER APPEARANCE AND MESSAGES
var myScroller1 = new Scroller(10, 4, 580, 130, 0, 5); //(xpos, ypos, width, height, border, padding)
myScroller1.setColors("#000000", "#D4EA94", "#edebe8"); //(fgcolor, bgcolor, bdcolor)
myScroller1.setFont("Arial,Helvetica", 2);

<%
sql = "SELECT * FROM emlak WHERE anasayfa=true"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
 do while not rs.eof

xsql = "SELECT top 1 * FROM resim WHERE emlakid="&cint(rs("id"))
set xrs = server.createobject("ADODB.Recordset")
xrs.open xsql, con, 1, 3
	
additem="myScroller1.addItem(""<table class=standart width=100% border=0 cellspacing=4 cellpadding=0> <tr> <td width=20% >"
additem=additem&"<a href=goster.asp?emlakid="&rs("id")&"><img border=0 src=resimarsiv/thumb/"&xrs("resim")&"></img></a></td><td width=80% >"
additem=additem&"<a href=goster.asp?emlakid="&rs("id")&">"
if rs("emlakdurum")="k" then additem=additem&" KİRALIK - "
if rs("emlakdurum")="s" then additem=additem&" SATILIK - "
additem=additem&"<b>"&rs("emlaktip")&"</b><br><br>"&rs("not")
additem=additem&"</a></td></tr></table>"");"
 response.Write additem
 
 rs.movenext
 loop
%>


//SET SCROLLER PAUSE
myScroller1.setPause(2500); //set pause beteen msgs, in milliseconds

function runmikescroll() {

  var layer;
  var mikex, mikey;

  // Locate placeholder layer so we can use it to position the scrollers.

  layer = getLayer("placeholder");
  mikex = getPageLeft(layer);
  mikey = getPageTop(layer);

  // Create the first scroller and position it.

  myScroller1.create();
  myScroller1.hide();
  myScroller1.moveTo(mikex, mikey);
  myScroller1.setzIndex(100);
  myScroller1.show();
}

window.onload=runmikescroll
  </script>
        <div id="placeholder" style="position:relative; width:580px; height:125px;"> </div>			
			</td>
          </tr>
        </table>



		</td>
      </tr>
      <tr>
        <td height="25" valign="top"><img src="images/box_alt.gif" width="596" height="12" /></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td><img src="images/tit_soneklenenler.gif" width="596" height="39" /></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="4" class="vurgu" style="border-collapse: collapse">
  <%
sql = "select top 8 * FROM emlak order by id desc"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3 
%>
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
          <td height="31" class="standart"><div align="center">
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
<a href="goster.asp?emlakid=<%=rs("id")%>"><img src="<%=emlakresim%>" border="0" class="tablogri3" /></a>

          </div></td>
        </tr>
        <tr>
          <td height="18" class="standart"><div align="center"><a href="goster.asp?emlakid=<%=rs("id")%>"><strong><%=rs("emlaktip")%></strong><br />
                      <%=rs("il")%> (<%=rs("ilce")%>)<br />
                      <%=rs("fiyat")%> YTL</a></div></td>
        </tr>
      </table>
    </div></td>
    <% ElseIf i mod bol = 0 Then %>
    <td width="<%=yuzde %>%"><div align="center">
      <table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td height="31" class="standart"><div align="center">
<%
xsql = "select * FROM resim WHERE emlakid="&cint(rs("id"))
set xrs = server.createobject("ADODB.Recordset")
xrs.open xsql, con, 1, 3 
if xrs.recordcount<>0 then
  emlakresim="resimarsiv/thumb/"&xrs("resim")
else
  emlakresim="images/resimyok.gif"
end if 
xrs.close
%>
            <a href="goster.asp?emlakid=<%=rs("id")%>"><img src="<%=emlakresim%>" border="0" class="tablogri3" /></a> </div></td>
        </tr>
        <tr>
          <td height="18" class="standart"><div align="center"><a href="goster.asp?emlakid=<%=rs("id")%>"><strong><%=rs("emlaktip")%></strong><br />
                      <%=rs("il")%> (<%=rs("ilce")%>)<br />
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
</table>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="3">
  <tr>
    <td width="100%" height="20"><img src="images/tit_haberler.gif" width="596" height="35" /></td>
  </tr>
  <tr>
    <td><div align="justify" class="standart">
      <%
sql = "select TOP 2 * FROM haber order by id desc"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3 
if rs.recordcount>0 then 
do while not rs.eof 
%>
      <a href="haber.asp"><strong><%=rs("baslik")%></strong> - <%=rs("tarih")%> <br />
      <%=left(rs("haber"),180)%>...</a><br />
      <br />
      <%
rs.movenext
loop
end if
%>
    </div></td>
  </tr>
</table>
<%
rs.close
end sub
%>

