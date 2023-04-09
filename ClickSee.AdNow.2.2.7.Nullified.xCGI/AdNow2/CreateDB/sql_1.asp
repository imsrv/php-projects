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
     Dim mFound(4)
     Dim mObjConn
     Dim mObjRSData
     On Error Resume Next

     setConnection Request("USER"), Request("PWD"), Request("DataSource")
     
     If Err.Number = 0 Then
       Set mObjRSData = exeCmd(mObjConn, mDBName, Request("USER"), Request("PWD"), Request("DataSource"))
   
       If Not (mObjRSData.BOF And mObjRSData.EOF) Then
         exeCmd mObjConn, mUseDB, Request("USER"), Request("PWD"), Request("DataSource")
     
     mFound(1)=Funcexe(mObjConn, mTblName1, Request("USER"), Request("PWD"), Request("DataSource"))
     mFound(2)=Funcexe(mObjConn, mTblName2, Request("USER"), Request("PWD"), Request("DataSource"))         
     mFound(3)=Funcexe(mObjConn, mTblName3, Request("USER"), Request("PWD"), Request("DataSource"))         
     mFound(4)=Funcexe(mObjConn, mTblName4, Request("USER"), Request("PWD"), Request("DataSource"))         
'         For iLoop = 1 to 4
'           Select Case iLoop
'             Case 1
'               Set mObjRSData2 = exeCmd(mObjConn, mTblName1, Request("USER"), Request("PWD"), Request("DataSource"))
'               'Response.Write Funcexe(mObjConn, mTblName1, Request("USER"), Request("PWD"), Request("DataSource"))
'             Case 2
'               Set mObjRSData2 = exeCmd(mObjConn, mTblName2, Request("USER"), Request("PWD"), Request("DataSource"))         
'             Case 3
'               Set mObjRSData2 = exeCmd(mObjConn, mTblName3, Request("USER"), Request("PWD"), Request("DataSource"))         
'             Case 4
'               Set mObjRSData2 = exeCmd(mObjConn, mTblName4, Request("USER"), Request("PWD"), Request("DataSource"))         
'           End Select
'         
'           If Not (mObjRSData2.BOF And mObjRSData2.EOF) then
'             mFound(iLoop) = mObjRSData2("name")
'           Else
'             mFound(iLoop) = ""   
'           End If
       
'           Set mObjRSData2 = Nothing
'         Next
         If (UCase(mFound(1)) = "AD_DATA") and (UCase(mFound(2)) = "ADMIN") and _
            (UCase(mFound(3)) = "COMPANIES") and (UCase(mFound(4)) = "STATS") Then
     	   ' Found db and all tables
%>	
	   <form method="Post" action="scdb.asp">
	   <input type="hidden" name="USER" value="<%=Request("USER")%>">
	   <input type="hidden" name="PWD" value="<%=Request("PWD")%>">
	   <input type="hidden" name="DataSource" value="<%=Request("DataSource")%>">
	   <input type="hidden" name="FileName" value="<%=Request ("FileName")%>">
	   
   	   <table width="366" border="0" align="center">
       <tr>
       <td><font face="Verdana,Arial" color="#CCCCCC">You want to :</font></td><td>&nbsp;</td>
       </tr>
       <tr>
       <td>&nbsp;</td><td><input type="radio" name="choice" value="Modify1"><font face="Verdana,Arial" color="#CCCCCC">Modify</font></td>
       </tr>
       <tr>
       <td>&nbsp;</td><td><input type="radio" name="choice" value="Create"><font face="Verdana,Arial" color="#CCCCCC">Create new</font></td>
       </tr>
       <tr>
       <td>&nbsp;</td><td>&nbsp;</td>
       </tr>
       <tr>
       <td>&nbsp;</td><td>
        <input type="image" border="0" name="imageField" src="../images2/btnext.gif" width="69" height="21" alt="Next">
      </td>
       </tr>	   	   	   
	   </table>	    
       </form>
<%	
         Else
%>
	   <form method="Post" action="scdb.asp">	 
  	   <input type="hidden" name="tbl1" value="<% =mFound(1)%>">
	   <input type="hidden" name="tbl2" value="<% =mFound(2)%>">
	   <input type="hidden" name="tbl3" value="<% =mFound(3)%>">
	   <input type="hidden" name="tbl4" value="<% =mFound(4)%>">
 	   
	   <input type="hidden" name="USER" value="<%=Request("USER")%>">
	   <input type="hidden" name="PWD" value="<%=Request("PWD")%>">
	   <input type="hidden" name="DataSource" value="<%=Request("DataSource")%>">
	   <input type="hidden" name="FileName" value="<%=Request ("FileName")%>">
       
  <table width="627" border="0" align="center">
    <tr> 
      <td colspan="3"> 
        <div align="left"><font face="Verdana,Arial" color="#CCCCCC">Found DB "ADNOW" but some tables no found. You want 
          to :</font></div>
      </td>
    </tr>
    <tr> 
      <td width="207"> 
        <div align="left"></div>
      </td>
      <td width="173"> 
        <div align="left">
          <input type="radio" name="choice" value="Modify2"><font face="Verdana,Arial" color="#CCCCCC">
          Modify</font></div>
      </td>
      <td width="225"> 
        <div align="left"></div>
      </td>
    </tr>
    <tr> 
      <td width="207"> 
        <div align="left"></div>
      </td>
      <td width="173"> 
        <div align="left"> 
          <input type="radio" name="choice" value="Create">
          <font face="Verdana,Arial" color="#CCCCCC">Create new</font></div>
      </td>
      <td width="225"> 
        <div align="left"></div>
      </td>
    </tr>
    <tr> 
      <td width="207">&nbsp;</td>
      <td width="173">&nbsp;</td>
      <td width="225">&nbsp;</td>
    </tr>
    <tr> 
      <td width="207"> 
        <div align="center"></div>
      </td>
      <td width="173"> 
        <div align="center"> 
          <input type="image" border="0" name="imageField" src="../images2/btnext.gif" width="69" height="21" alt="Next">
        </div>
      </td>
      <td width="225"> 
        <div align="center"></div>
      </td>
    </tr>
  </table>	    
       </form>
<%     
         End If
       Else    
         ' No found db and all tables 
%>   
     <form method="Post" action="scdb.asp">	  
  	 <input type="hidden" name="choice" value="Create">	

	<input type="hidden" name="USER" value="<%=Request("USER")%>">
	<input type="hidden" name="PWD" value="<%=Request("PWD")%>">
	<input type="hidden" name="DataSource" value="<%=Request("DataSource")%>">
	<input type="hidden" name="FileName" value="<%=Request ("FileName")%>">
	 
     
  <table border="0" align="center">
    <tr> 
      <td><font face="Verdana,Arial" color="#CCCCCC">Create new DB</font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td> 
        <div align="center"> 
          <input type="image" border="0" name="imageField" src="../images2/btnext.gif" width="69" height="21" alt="Next">
        </div>
      </td>
    </tr>
  </table> 
     </form>
<%
       End If
     
       Set mObjRSData = Nothing
       setDisconnection mObjConn     
    Else
      Response.Write "<br>"
      Response.Write "<center><font face=""Verdana,Arial"" color=""#CCCCCC"">"&Err.description&"</font></center>" 
    End If
  End If
%>   
</body>
</html>