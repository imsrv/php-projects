<%@ LANGUAGE="VBSCRIPT" %>

<!--#include file ="Module/module.asp"-->
<!--#include file ="Module/sub.asp"-->
<HTML>
<HEAD>
<TITLE>Clicksee AdNow! Version 2.0 - Database Page</TITLE>
<META content=no-cache http-equiv=pragma>
</HEAD>
<body background="../images2/bg.gif" topmargin="0" bottommargin="0" marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" text="#FFFF00">
<!--#include file="logo.asp"-->

<% 
   If Instr(lcase(Request.ServerVariables ("HTTP_REFERER")),"pwd.asp")<>0 then	 
     Dim mObjConn
     Dim mObjRSData
     On Error Resume Next
     
	 setConnection "", "", Request ("ODBC")

     If Err.Number = 0 Then
       Response.Write "<form method=""Post"" action=""mcdb.asp"">"
       Response.Write "<table width=""39%"" border=""0"" align=""center"">"
       Response.Write "<tr><td width=""39%""><div align=""left""><font face=""Verdana,Arial"" color=""#CCCCCC"">You want to : </font></div></td>"
       Response.Write "<td width=""61%"">&nbsp;</td></tr>"
       Response.Write "<tr><td width=""39%"">&nbsp;</td>"
       Response.Write "<td width=""61%""><div align=""left""><input type=""radio"" name=""choice"" value=""Modify"" checked><font face=""Verdana,Arial"" color=""#CCCCCC"">Modify </font></div></td></tr>"
       Response.Write "<tr><td width=""39%"">&nbsp;</div></td>"
       Response.Write "<td width=""61%"">&nbsp;</td></tr>"
       Response.Write "<tr><td width=""39%"">&nbsp;</td>"
       Response.Write "<td width=""61%""><div align=""left""><input type=""image"" border=""0"" name=""imageField"" src=""../images2/btnext.gif"" width=""69"" height=""21"" alt=""Next""></div></td></tr>"
       Response.Write "</table>"
       Response.Write "<input type=""hidden"" name=""ODBC"" Value="""&Request("ODBC")&""">"
       Response.Write "</form>"

       Set mObjRSData = Nothing     
       setDisconnection mObjConn   
     Else
       Response.Write "<br>"
       Response.Write "<Center><font face=""Verdana,Arial"" color=""#CCCCCC"">Connection error! please check your odbc....</font></Center>"
     End If 
   End If
%>   
</body>
</html>