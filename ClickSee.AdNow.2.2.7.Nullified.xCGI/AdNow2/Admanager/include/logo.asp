<%IF instr(lcase(Request.ServerVariables ("Path_info")),"default.asp")=0 THEN%>
<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 align="right">
	<TR>
<%
		IF instr(lcase(Request.ServerVariables ("Path_info")),"adcenter.asp")=0 THEN
%>
   <td> <img src="../images2/menubar.gif" width=189 height=20></td>
<% If instr(lcase(Request.ServerVariables ("Path_info")),"company.asp")=0 THEN %>
    <td> <a href="company.asp<%IF instr(lcase(Request.ServerVariables ("Path_info")),"adcenter.asp")=0 THEN Response.Write "?"&VarBACK%>"><img src="../images2/addcompany.gif" width="152" height="20" border="0" alt="ADD NEW COMPANY"></a></td>
<% End If %>	
    <td> <a href="adcenter.asp"><img src="../images2/admincenter.gif" width="123" height="20" border="0" alt="ADMINISTRATOR CENTER"></a></td>
    <td> <a href="logout.asp"><img src="../images2/logout.gif" width="94" height="20" border="0" alt="LOGOUT"></a></td>
<% Else  %>			
    <td> <img src="../images2/menubar2.gif" width="304" height="20"></td>
<% If instr(lcase(Request.ServerVariables ("Path_info")),"company.asp")=0 THEN %>
    <td> <a href="company.asp<%IF instr(lcase(Request.ServerVariables ("Path_info")),"adcenter.asp")=0 THEN Response.Write "?"&VarBACK%>"><img src="../images2/addcompany2.gif" width="157" height="20" border="0" alt="ADD NEW COMPANY"></a></td>
<% End If %>	
    <td> <a href="logout.asp"><img src="../images2/logout2.gif" width="104" height="20" border="0" alt="LOGOUT"></a></td>
<% End If %>
	</TR>
</TABLE>
<% Else %>
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="../images2/bgbar03.gif">
<tr>
<td align="left" width="600"><img src="../images2/bar03.gif" width="600" height="17" border="0" alt=""></td>
</tr>
</table>
<%END IF%>
<br><br>