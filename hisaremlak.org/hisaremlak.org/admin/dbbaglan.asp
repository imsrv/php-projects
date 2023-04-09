<!-- #include file = "../config.asp" -->

<% 
on error resume next
Set con = Server.CreateObject("ADODB.Connection")
con.Open("DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=" & databaseyolu)

sub DBClose()
 rs.close
 set rs = nothing
 con.close
 set con = nothing
end sub
%>
