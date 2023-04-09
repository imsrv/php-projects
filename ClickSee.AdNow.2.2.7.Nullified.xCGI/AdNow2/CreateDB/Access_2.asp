<%@ LANGUAGE="VBSCRIPT" %>

<!--#include file ="Module/module.asp"-->
<!--#include file ="Module/sub.asp"-->
<!--#include file ="Module/convertdb.asp"-->

<HTML>
<HEAD>
<TITLE>Clicksee AdNow! Version 2.0 - Database Page</TITLE>
<META content=no-cache http-equiv=pragma>
</HEAD>
<body background="../images2/bg.gif" topmargin="0" bottommargin="0" marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" text="#FFFF00">
<!--#include file="logo.asp"-->

<%   
   If Session("mDataSource")<>EMPTY then	 
'	On Error Resume Next
	ConvertDB2  		
	IF Err.number =0 THEN
        Response.Write "<br>"	
        Response.Write "<center><font face=""Verdana,Arial"" color=""#CCCCCC"">Successfully</font></center>"   	   
    ELSE
        Response.Write "<br>"	
        Response.Write "<center><font face=""Verdana,Arial"" color=""#CCCCCC"">"&Err.description&"</font></center>"   	   
    End If
'    On Error Goto 0
    
     setDisconnection mObjConn
   End If  
%>   
</body>
</html>