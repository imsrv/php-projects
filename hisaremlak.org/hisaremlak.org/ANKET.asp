<%
Session.TimeOut = 1000
Response.Buffer = True
%>
<html>
<head>
<title>Anket</title>
<link rel="stylesheet" href="stil.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function openpage(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>

<div align="left">
  <% 
anket_id = Request("anket_id")

If Len(anket_id) = 0 OR Not IsNumeric(anket_id) then
	Set anket = Con.Execute("SELECT * FROM anketler order by anket_tarih desc")
Else
	Set anket = Con.Execute("SELECT * FROM anketler WHERE anket_id=" & anket_id)
End if


If anket.Eof Then
	Response.write "<center><H4>Anket bulunamadý(!)</H4>"
Else 

	anket_id = anket("anket_id")
	anket_soru = anket("anket_soru")
	anket_tarih = anket("anket_tarih")
	anket_durum = anket("aktif")

	anket.close
	Set anket = Nothing

	If Request.Cookies("VBSTurkAnket")(cstr(anket_id)) = "oylandi" OR anket_durum = False Then
 
		OyDurum = True
 
	Else 

		SecID = Request.Form("sec_id")

		If Len(SecID) > 0 AND IsNumeric(SecID) Then '<%  

			Con.Execute("UPDATE secenekler SET sec_sayac = sec_sayac + 1 WHERE sec_id=" & SecID) 

			Response.Cookies("VBSTurkAnket")(cstr(anket_id)) = "oylandi"
			Response.Cookies("VBSTurkAnket").Expires = Now() + 1
	
			OyDurum = True 
		Else
			OyDurum = True
		End If

	End If

Set SecenekSay = Con.Execute("select Sum(sec_sayac) from secenekler where anket_id = "&anket_id&"")
Total = SecenekSay(0)

set secenekler = Con.Execute("SELECT * FROM secenekler WHERE anket_id = " & anket_id & "  order by  sirasi asc")
%>
  
  <%'#################    KASIMPAÞA  YOKUÞU   ####################  %>
  
</div>
<form method="post" action="anket_sonuc.asp?anket_id=<%=anket_id%>">

  <div align="left"><span class="vurgulu"><%= anket_soru%></span><br>
  

  
    <table class="standart" border="0" cellpadding="0" cellspacing="0" align="center">
    
<%
If secenekler.Eof Then
	Response.Write "<center><h5>Bu anket için kayýtlý seçenek yok</h5></center>"
End If

Do While Not secenekler.EOF

	If Total > 0 Then '<%
		yuzde = Int((secenekler("sec_sayac") / Total) * 100)
	Else
		yuzde = 0
	End If
%>
    
  <tr>
    
	<% If OyDurum = True AND anket_durum = True Then%>
	    <td width="20"><input type="radio" name="sec_id" value="<% = secenekler("sec_id") %>" style="height:10 px;"></td>
	    <% end if %>
	    <td width="129"><div align="left"><%= secenekler("secenek") %></div></td>
	    <td width="35"><%=yuzde%>%</td>
      </tr>
    
<%
secenekler.MoveNext : Loop
secenekler.close : set secenekler = Nothing
%>
    
  <tr>
	    <td colspan="3" align="left"><br>
    

	    <% If OyDurum = True AND anket_durum = True then%>
	    <input type=submit value="Oyla" class="buton">
	    <% End If %>
	    
	
    <span class="aciklama"><%=Total%> oy verildi.</span>
    </td>
      </tr>
    </table>
  </div>
</form>

<div align="left">
  <% End If %>
  
  <% ' ####################   THE OTHERS  ################ %>
  
  <% Set EskiAnketler = Con.Execute("SELECT * FROM anketler order by anket_tarih desc") %>
  <% 
If EskiAnketler("anket_id") = anket_id Then EskiAnketler.MoveNext
If Not EskiAnketler.Eof Then
%>
  
  <% End If %>
  

  
</div>
