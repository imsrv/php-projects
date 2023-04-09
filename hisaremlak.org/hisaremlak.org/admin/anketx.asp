<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Emlak Portal� - Y�netim B�l�m�</title>
<link href="stil.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="800"  border="0" align="center" cellpadding="0" cellspacing="4" class="tablogri2">
  <tr>
    <td valign="top" class="tablogri4"><!-- #include file = "menu.asp" --></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><table width="100%"  border="0" cellpadding="4" cellspacing="4">
      <tr>
        <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon16.gif" width="41" height="41"></div></td>
        <td width="91%" class="tablogri2"><span class="baslik">ANKET</span></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%"  border="0" cellpadding="0" cellspacing="2" class="vurgu">
            <tr valign="top">
              <td width="100%" height="28"><div align="justify" class="standart">Bu b�l�mde yeni bir anket olu�turabilir ve var olan anketleri d�zenleyebilirsiniz.</div></td>
            </tr>
            <tr valign="top">
              <td><!-- #include file = "dbbaglan.asp" -->
                <%
Session.TimeOut = 1000
Response.Buffer = True

'Response.Expires = -1
'Response.ExpiresAbsolute = Now() - 1
'Response.AddHeader "pragma","no-cache"
'Response.AddHeader "cache-control","private"
'Response.CacheControl = "no-cache"

'************************************
Gunler = Array("", "Pazar", "Pazartesi", "Sal�", "�ar�amba", "Per�embe", "Cuma", "Cumartesi")
Aylar = Array("", "Ocak", "�ubat", "Mart", "Nisan", "May�s", "Haziran", "Temmuz", "A�ustos", "Eyl�l", "Ekim", "Kas�m", "Aral�k")

Function AcikTarih(Tarih)
	AcikTarih = Day(Tarih) & " " & Aylar(Month(Tarih)) & " " & Year(Tarih) & " " & Gunler(WeekDay(Tarih))
End Function
%></td>
            </tr>
            <tr valign="top">
              <td><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="standart">
                <tr>
                  <td><%
BuSayfa = Request("script_name")
eylem = Request("eylem")

If eylem = "anket_goster" Then
 
	AnketGoster

ElseIf eylem = "etkinlestir" Then

	If Not Request("aktiflestirilecek") = "" Then
		Con.Execute("UPDATE anketler SET aktif = False")
		Con.Execute("UPDATE anketler SET aktif = True WHERE anket_id = "&Request("aktiflestirilecek")&" ")
	End If

	Response.Redirect BuSayfa

ElseIf eylem = "yeni_secenek" Then

	If Not Request("Secenek") = "" Then
		Set SecenekSay = Con.Execute("Select Count(anket_id) from secenekler where anket_id = "&Request("anket_id")&" ")
		Kacinci = SecenekSay(0) + 1
		Con.Execute("insert into secenekler(anket_id, secenek, sec_sayac,sirasi) values ('" & Request("anket_id") & "','" & Request("Secenek") & "',0,"&Kacinci&")")
	End If
	
	Response.Redirect BuSayfa & "?eylem=anket_goster&anket_id=" & Request("anket_id")

ElseIf eylem = "secenek_sil" Then

	Con.Execute("Delete From secenekler where sec_id = "&Request("sec_id")&" ")

	Response.Redirect BuSayfa & "?eylem=anket_goster&anket_id=" & Request("anket_id")

ElseIf eylem = "anket_sil" Then

	Con.Execute("Delete From anketler where anket_id = "&Request("anket_id")&" ")
	Con.Execute("Delete From secenekler where anket_id = "&Request("anket_id")&" ")

	Response.Redirect BuSayfa

ElseIf eylem = "yeni_anket" Then

	YeniAnket

ElseIf eylem = "anket_kaydet" Then

	If Not Request("AnketSoru") = "" Then
		Con.Execute("UPDATE anketler SET aktif = False")
		Con.Execute("insert into anketler(anket_soru,anket_tarih,aktif) values ('" & Request("AnketSoru") & "',Date(),True)")
	End If
	
	Response.Redirect BuSayfa

ElseIf eylem = "anket_duzenle" Then

	AnketDuzenle	

Else
	Response.Write "D�zenlemek i�in listeden bir ankete t�klay�n.<br>"
End If
%>
                      <% '============================================================================== %>
                      <% '============================================================================== %>
                      <form action="<%=BuSayfa%>" method="post">
                        <input type="hidden" name="eylem" value="etkinlestir">
                        <p class="tablogri2"><b class="vurgu">Mevcut Anketler</b><br>
                            <br>
                            <%
Set anketler = Con.Execute("SELECT * FROM anketler ORDER BY anket_tarih desc ")

If anketler.Eof Then 
%>
                            Kay�tl� anket yok
                            <% End If %>
                            <% do while not anketler.eof %>
                            <a href="<%=BuSayfa%>?eylem=anket_goster&anket_id=<%=anketler("anket_id") %>">
                          <input type="radio" name="aktiflestirilecek" value="<%=anketler("anket_id")%>" <%If anketler("aktif") = True Then%>checked<%End If%>>
                          <% = anketler("anket_soru") %>
                            </a> (<%=AcikTarih(anketler("anket_tarih"))%>)<br>
                            <% anketler.movenext : loop %>
                        </p>
                        <input name="submit" type="submit" class="tabloyesil" value="Se�ili Anketi Etkinle�tir">
                        <input name="button" type="button" class="tabloyesil" onclick="self.location='<%=BuSayfa%>?eylem=yeni_anket';" value="Yeni Anket Olu�tur">
                    </form></td>
                </tr>
              </table></td>
            </tr>
            <tr valign="top">
              <td>&nbsp;</td>
            </tr>
            <tr valign="top">
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><div align="center"><span class="standart">DCEmlak 2007� G�rkan KARA taraf�ndan programlanm��t�r. gurkan@designcube.net </span></div></td>
  </tr>
</table><% '============================================================================== %>
  <% '============================================================================== %>
  <% Sub AnketGoster 

Set HangiAnket = Con.Execute("SELECT * FROM anketler where anket_id = "&Request("anket_id")&" ")
Set Secenekler = Con.Execute("SELECT * FROM secenekler where anket_id = "&Request("anket_id")&" order by sirasi asc")
%>
</div>
<form action="<%=BuSayfa%>" method="post">
  <div align="left">
  <input type="hidden" name="eylem" value="anket_duzenle">
  <input type="hidden" name="anket_id" value="<%=HangiAnket("anket_id")%>">
  
<table width="100%" cellpadding="2" cellspacing="1" border="0">
  </div>
  <tr class="vurgu">
	<td class="caption" colspan="3"><div align="left">A<span class="standart">nket Sorusu:</span></div></td>
  </tr>
  <tr>
	<td class="cell" colspan="3"><div align="left">
	    <span class="standart">
								   <input type="text" name="AnketSoru" value="<% = HangiAnket("anket_soru")%>" class="inputtxt" size="60">
								   <input type="button" value="anketi sil" class="tablokirmizi" onclick="self.location='<%=BuSayfa%>?eylem=anket_sil&anket_id=<%=HangiAnket("anket_id")%>';alert('Silinecek')">
	    </span></div></td>
  </tr>
  <tr>
	<td class="caption"><div align="left" class="standart"><b>Se�enekler:</div></td>
	<td  class="caption"><div align="left" class="standart"><b>G�sterim S�ras�</div></td>
	<td  class="caption"><div align="left" class="standart"><b>Oylayan Ki�i</div></td>
  </tr>

  <div align="left">
    <span class="standart">
    <% If Secenekler.Eof Then %>
    </span></div>
  <tr class="vurgu">
	<td class="cell" colspan="3" align="center"><div align="left" class="standart"><b>Bu ankete ait se�enek yok.</div></td>
  </tr>
  <div align="left">
    <% Else %>
  
    <% Do While Not Secenekler.Eof %>
    <input type="hidden" name="SecID" value="<%=Secenekler("sec_id")%>">
  </div>
  <tr>
	<td  class="cell"><div align="left">
	    <input size="20" type="text" name="SecDeger" value="<%=Secenekler("secenek")%>" class="inputtxt"> 
	    &nbsp;
					 <input type="button" value="sil" class="tablokirmizi" onclick="self.location='<%=BuSayfa%>?eylem=secenek_sil&anket_id=<%=HangiAnket("anket_id")%>&sec_id=<%=Secenekler("sec_id") %>';">
	</div></td>

	<td  class="cell"><div align="left">
	  <input size="3" type="text" name="SecSira" value="<%=Secenekler("sirasi")%>" class="inputtxt">
    </div></td>


	<td  class="cell"><div align="left">
	  <input size="3" type="text" name="SecSayac" value="<%=Secenekler("sec_sayac")%>" class="inputtxt">
  
	</div></td>
  </tr>
  <div align="left">
    <% Secenekler.MoveNext : Loop %>
  </div>
  <tr>
	<td class="cell" colspan="2">&nbsp;</td>
	<td class="cell"><div align="left">
	  <input type="Submit" value="Kaydet" class="tabloyesil">
    </div></td>
  </tr>

  <div align="left">
    <% End If %>
  
</div>
  <tr class="standart">
	<td class="cell" colspan="3"><div align="left"> G�sterim S�ras� se�eneklerin s�ralanma �l��t�d�r. 1,2,3..gibi artan �ekilde ayarlay�n.</div></td>
  </tr>
</form>

<form action="<%=BuSayfa%>" method="post" class="standart">
  <div align="left">
  <input type="hidden" name="eylem" value="yeni_secenek">
  <input type="hidden" name="anket_id" value="<%=HangiAnket("anket_id")%>">
  </div>
  <tr class="vurgu">
	<td class="caption" colspan="3"><div align="left">Yeni Se�enek Ekle</div></td>
  </tr>
  <tr>
	<td class="cell" colspan="2" align="right"><div align="left">
	  <input type="text" name="Secenek" class="inputtxt">
    </div></td>
	<td class="cell"><div align="left">
	  <input type="Submit" value="Se�enek Ekle" class="tabloyesil">
    </div></td>
  </tr>
  <tr>
	<td class="cell" colspan="3">&nbsp;</td>
  </tr>
</form>
<div align="left">
  </table>
  
<% End Sub %>
  

  <% '============================================================================== %>
  <% '============================================================================== %>
  <% Sub YeniAnket %>
  
</div>
<form action="<%=BuSayfa%>" method="post">
  <div align="left">
  <input type="hidden" name="eylem" value="anket_kaydet">
  
<table width="100%" cellpadding="2" cellspacing="1" border="0">
  </div>
  <tr class="vurgu">
	<td class="caption" colspan="2"><div align="left">Anket Sorusu:</div></td>
  </tr>
  <tr>
	<td class="cell" colspan="2"><div align="left">
	    <input type="text" name="AnketSoru" class="inputtxt" size="60"> 
	    &nbsp;
	    <input type="Submit" value="Olu�tur" class="tabloyesil">
	</div></td>
  </tr>
  <tr class="standart">
	<td class="cell" colspan="2"><div align="left">Sitede olu�turaca��n�z bu anket aktif olacakt�r.<br>
	    Se�enekleri anketi olu�turduktan sonra anketi se�erek olu�turabilirsiniz.</div></td>
  </tr>
  <tr>
	<td class="caption" colspan="2">&nbsp;</td>
  </tr>
</form>
<div align="left">
  </table>
  
<% End Sub %>
  
<% '============================================================================== %>
  <% '============================================================================== %>
  <% 
Sub AnketDuzenle

AnketID		= Request("anket_id")
AnketSoru	= Request("AnketSoru")

SecID		= Split(Request("SecID"),",",-1,1)
SecDeger	= Split(Request("SecDeger"),",",-1,1)
SecSayac	= Split(Request("SecSayac"),",",-1,1)
SecSira		= Split(Request("SecSira"),",",-1,1)

Con.Execute("UPDATE anketler SET anket_soru = '"&AnketSoru&"' WHERE anket_id = "&AnketID&" ")

	For x = 0 To Ubound(SecID)
		Con.Execute("UPDATE secenekler SET secenek = '"&Trim(SecDeger(x))&"',sec_sayac = "&Trim(SecSayac(x))&",sirasi = "&Trim(SecSira(x))&" WHERE sec_id = "&Trim(SecID(x))&" ")
	Next

Response.Redirect BuSayfa & "?eylem=anket_goster&anket_id=" & Request("anket_id")

End Sub 
%>
</body>
</html>
