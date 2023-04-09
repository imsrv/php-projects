<%
on error resume next

Function tarihFormatla(tarih)
	Bol = Split(CStr(tarih),".",-1,1)
	tarihFormatla = Bol(1) & "/" & Bol(0) & "/" & Bol(2)
End Function

if session("sayalim")<>"True" then

sql = "SELECT * FROM sayac WHERE tarih = #"&tarihFormatla(date())&"#"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
TopKayit = RS.recordcount

if cint(TopKayit)=0 then
 sql = "SELECT * FROM sayac"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs.addnew
    rs("tekil")=1
	rs("cogul")=0
	rs("tarih")=date()
 rs.update	
 Response.Cookies("hisaremlak") = "True"
 Response.Cookies("hisaremlak").Expires = date()+1
else

sql = "SELECT * FROM sayac WHERE tarih = #"&tarihFormatla(date())&"#"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
tekx = rs("tekil")
cokx = rs("cogul")

if Request.Cookies("hisaremlak") = "True" then 
 rs("cogul")= cint(rs("cogul"))+1 
 rs.update
else
 rs("tekil")= cint(rs("tekil"))+1 
 rs.update
 Response.Cookies("hisaremlak") = "True"
 Response.Cookies("hisaremlak").Expires = date()+1
end if
end if

'REFERER KAYIT
	Referer = Request.ServerVariables("HTTP_REFERER")
	Words = Array("http://", "www.", ";", ",", "'") 
    For i = 0 to uBound(Words)
    	Referer = Replace(Referer, Words(i), "") 
    Next
	Referer = Mid(Referer, 1, (InStr(1, Referer, "/")))
	If Referer = "" Then Referer = "DirektGiris"

sql = "SELECT * FROM referer WHERE referersite ='"&referer&"'"
set rs = server.createobject("ADODB.Recordset")
rs.open sql, con, 1, 3
TopKayit = RS.recordcount

if cint(TopKayit)=0 then
 sql = "SELECT * FROM referer"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
 rs.addnew
	rs("hitsay")=1
	rs("referersite")=referer
 rs.update
else
 sql = "SELECT * FROM referer WHERE referersite='"&referer&"'"
 set rs = server.createobject("ADODB.Recordset")
 rs.open sql, con, 1, 3
	rs("hitsay")=cint(rs("hitsay"))+1
	rs("referersite")=referer
 rs.update
end if
session("sayalim")="True"
session.Timeout=30
call DBClose()
end if
%>