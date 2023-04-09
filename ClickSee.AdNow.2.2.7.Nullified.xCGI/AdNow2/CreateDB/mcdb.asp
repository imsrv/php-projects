<!--#include file ="Module/module.asp"-->
<!--#include file ="Module/sub.asp"-->
<!--#include file ="Module/convertdb.asp"-->
<%   
   If Instr(lcase(Request.ServerVariables ("HTTP_REFERER")),"pwd.asp")<>0 then	 
     Dim mObjConn
     Dim mObjRSData
     
     On Error Resume Next
     
	 setConnection "", "", Request("ODBC")

	 IF Err.number <>0 THEN
        Response.Write "<br>"	
        Response.Write "<center><font face=""Verdana,Arial"" color=""#CCCCCC"">"&Err.description&"</font></center>"   	   
     On Error Goto 0
	 ELSE
	 On Error Goto 0
		' Create table campaign
		exeCmd mObjConn, mAccess1, "", "", Request("ODBC")
		' Modify field of ad_data
   		exeCmd mObjConn, mAlterACCESS1, "", "", Request("ODBC")
   		' Modify field of companies
		exeCmd mObjConn, mAlterACCESS2, "", "", Request("ODBC")
		
		ConvertDB "", "", Request("ODBC")
  		
  		Response.Redirect "access_2.asp"
     End If
     
     setDisconnection mObjConn
   ELSE
	Response.Redirect "access_1.asp"  
   End If  
%>