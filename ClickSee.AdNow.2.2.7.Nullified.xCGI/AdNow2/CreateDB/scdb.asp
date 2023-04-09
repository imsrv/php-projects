<!--#include file ="Module/module.asp"-->
<!--#include file ="Module/sub.asp"-->
<!--#include file ="Module/convertdb.asp"-->
<%
   If Instr(lcase(Request.ServerVariables ("HTTP_REFERER")),"sql_1.asp")<>0 then	 
     Dim mObjConn
     Dim mObjRSData
'     On Error Resume Next
   
     setConnection Request("USER"), Request("PWD"), Request("DataSource")
     If (Request("choice") <> "") Then
       Select Case Request("choice")
         Case "Modify1"
           exeCmd mObjConn, mUseDB, Request("USER"), Request("PWD"), Request("DataSource")                  
     	   exeCmd mObjConn, mSQL4, Request("USER"), Request("PWD"), Request("DataSource")                    ' Create table campaign
    	   exeCmd mObjConn, mAlterSQL1, Request("USER"), Request("PWD"), Request("DataSource")	            ' Modify field of ad_data
    	   exeCmd mObjConn, mAlterSQL2, Request("USER"), Request("PWD"), Request("DataSource")               ' Modify field of companies
         Case "Modify2"
           exeCmd mObjConn, mUseDB, Request("USER"), Request("PWD"), Request("DataSource")
           
           If (UCase(Request("tbl1")) = "AD_DATA") Then
             exeCmd mObjConn, mAlterSQL1, Request("USER"), Request("PWD"), Request("DataSource")	            ' Found ad_data modify it              
           Else
    	     exeCmd mObjConn, mSQL2, Request("USER"), Request("PWD"), Request("DataSource")                  ' No found create it
           End If
           
           If Not (UCase(Request("tbl2")) = "ADMIN") Then   ' No found create it
             exeCmd mObjConn, mSQL3, Request("USER"), Request("PWD"), Request("DataSource")  	   
           End If
           
           If (UCase(Request("tbl3")) = "COMPANIES") Then
             exeCmd mObjConn, mAlterSQL2, Request("USER"), Request("PWD"), Request("DataSource")       	    ' Found companies modify it 
           Else
             exeCmd mObjConn, mSQL5, Request("USER"), Request("PWD"), Request("DataSource")   	            ' No found companies create it 
           End If
           
           If Not (UCase(Request("tbl4")) = "STATS") Then   ' No found create it
             exeCmd mObjConn, mSQL6, Request("USER"), Request("PWD"), Request("DataSource")
           End If
           
           exeCmd mObjConn, mSQL4, Request("USER"), Request("PWD"), Request("DataSource")		    ' Create table campaign	      	      	      	      	              
         Case "Create"
				 exeCmd mObjConn, mDropTable1, Request("USER"), Request("PWD"), Request("DataSource")
				 exeCmd mObjConn, mDropTable2, Request("USER"), Request("PWD"), Request("DataSource")
				 exeCmd mObjConn, mDropTable3, Request("USER"), Request("PWD"), Request("DataSource")
				 exeCmd mObjConn, mDropTable4, Request("USER"), Request("PWD"), Request("DataSource")
				 exeCmd mObjConn, mDropTable5, Request("USER"), Request("PWD"), Request("DataSource")
    	   exeCmd mObjConn, mUseDB, Request("USER"), Request("PWD"), Request("DataSource")                     
    	   exeCmd mObjConn, mSQL2, Request("USER"), Request("PWD"), Request("DataSource")  	            ' Create ad_data
    	   exeCmd mObjConn, mSQL3, Request("USER"), Request("PWD"), Request("DataSource")                    ' Create admin
    	   exeCmd mObjConn, mSQL4, Request("USER"), Request("PWD"), Request("DataSource")                    ' Create compaign 	   
    	   exeCmd mObjConn, mSQL5, Request("USER"), Request("PWD"), Request("DataSource")                    ' Create campanies
    	   exeCmd mObjConn, mSQL6, Request("USER"), Request("PWD"), Request("DataSource")                    ' Create stats
       End Select           
       
       ConvertDB Request("USER"), Request("PWD"), Request("DataSource")
       
	   IF Err.number <>0 THEN
 	   Response.Write "<br>"	
	   Response.Write "<br>"	
       Response.Write "<center><font face=""Verdana,Arial"" color=""#000000"">"&Err.description &"</font></center>"
       ELSE
       On Error Goto 0
		Response.Redirect "sql_2.asp"
       END IF
       On Error Goto 0
     End If

     Set mObjRSData = Nothing   
   
     setDisconnection mObjConn
     Session("USER") = abandon
     Session("PWD") = abandon
     Session("InitCatalog") = abandon
     Session("DataSource") = abandon
   ELSE
	Response.Redirect "sql_1.asp"
   End If     
%>