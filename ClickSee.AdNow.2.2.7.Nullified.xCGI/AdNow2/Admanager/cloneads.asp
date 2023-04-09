<%@ Language=VBScript %>
<!--#include file="include/clone.asp"-->
<HTML>
<HEAD>
<TITLE>Clone Advertisement</TITLE>
<!--#include file="include/date_validation.html"-->
<!-- START open.window script -->
<script language="JavaScript">
<!--//BEGIN Script

function new_window(url) {

link = window.open(url,"Link","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=400height=360,left=80,top=80");

}
//END Script-->
</script>
<!-- END open.window script -->
</HEAD>

<BODY text="#000000" link="#FF6600" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" rightmargin="0" bottommargin="0" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br>
<form method="POST" action="include/clone.asp?<%=Request.ServerVariables ("Query_String")%>" onsubmit="return validate(this)" id=theForm name=theForm>
<script Language="JavaScript">

function validate(theForm)
{
  if (theForm.elements["adname"].value == "") {
    theForm.elements["adname"].focus();
    alert("Please enter a value for the \"Ad Name\" field.");
    return false;
  }


  if (theForm.elements["URL"].value == "")
  {
    theForm.elements["URL"].focus();
    alert("Please enter a value for the \"Link to URL\" field.");
    return (false);
  }

  if (theForm.elements["target"].value == "")
  {
    theForm.elements["target"].focus();
    alert("Please enter a value for the \"Location\" field.");
    return (false);
  }

  if (theForm.elements["status"].value == "")
  {
    theForm.elements["status"].focus();
    alert("Please enter a value for the \"Status\" field.");
    return (false);
  }

  if (theForm.elements["datestart"].value == "")
  {
    theForm.elements["datestart"].focus();
    alert("Please enter a value for the \"Date Start\" field.");
    return (false);
  }

  if (((theForm.elements["dateend"].value == "") && (theForm.elements["clickexpire"].value == "")) && (theForm.elements["impressionsPurchased"].value == ""))
  {
    theForm.elements["dateend"].focus();
    alert("Please enter 'Date End' or 'Click Expire' or 'Imp Purchased'.");
    return (false);
  }

  if (((theForm.elements["dateend"].value != "") && (theForm.elements["clickexpire"].value != ""))  && ((theForm.elements["impressionsPurchased"].value != "" )))
  {
    theForm.elements["dateend"].focus();
    alert("Please enter 'Date End' or 'Click Expire' or 'Imp Purchased'.");
    return (false);
  }

  if ((theForm.elements["dateend"].value != "") && (theForm.elements["clickexpire"].value != ""))
  {
    theForm.elements["dateend"].focus();
    alert("Please enter 'Date End' or 'Click Expire' or 'Imp Purchased'.");
    return (false);
  }
  if ((theForm.elements["clickexpire"].value != "")  && (theForm.elements["impressionsPurchased"].value != "" ))
  {
    theForm.elements["dateend"].focus();
    alert("Please enter 'Date End' or 'Click Expire' or 'Imp Purchased'.");
    return (false);
  }
  
  //----------------------
  if (theForm.elements["dateend"].value != "" )
  {  if((theForm.elements["dateend"].value.length != 10))  
     {   alert("Invalid Syntax ' Date End ' !");
	     return (false);
     }
	 if(convert_date(theForm.elements["dateend"]) == false)
	 	{ return (false);}
  } 
  if (theForm.elements["datestart"].value != "" )
  {  if((theForm.elements["datestart"].value.length != 10))
     {  alert("Invalid Syntax ' Date Start ' !");
         return (false);
     }
	 if(convert_date(theForm.elements["datestart"]) == false)
	 	{ return (false);}
  } 

}
</script>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
<!-- SPACER -->
<TR><TD VALIGN="TOP"><IMG SRC="../images2/spacer.gif" HEIGHT=10 BORDER="0"></TD></TR>

<!-- FORM -->
<TR>
<TD WIDTH="100%" VALIGN="TOP" COLSPAN="3" ALIGN="CENTER">
	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
	<TR>
	<!-- Text "Required*" -->
	<TD WIDTH="169" VALIGN="TOP" ALIGN="CENTER">
		<TABLE WIDTH="150" BORDER="0" CELLSPACING="0" CELLPADDING="0">
		<TR>
		<TD WIDTH="150"><IMG SRC="../images2/spacer.gif" WIDTH=150 HEIGHT=6 ALT="" BORDER="0"></TD>
		</TR>
		<TR>
		<TD WIDTH=150 ALIGN="RIGHT"><FONT COLOR="#FF9900" FACE="arial, helvetica" SIZE="-1"><font size="3"><b>*</b></font>&nbsp;&nbsp;Required</FONT></TD>
		</TR>
		</TABLE>
	</TD>
	
	<!-- V LINE -->
	<TD VALIGN="TOP"><IMG SRC="../images2/grey.gif" WIDTH=1 HEIGHT=850 BORDER="0"></TD>


	<!-- Form Text Field -->	
	<TD WIDTH="428" VALIGN="TOP" ALIGN="CENTER">
	<div align="right"><strong><font size="4" COLOR="#CCCCCC"><span style="font-family: Arial;">CLONE AD ADVERTISEMENT</strong></font></div>
	<FONT FACE="arial,helvetica" SIZE="-1" COLOR="#FF0000"><STRONG><%ErrMSG%></STRONG></FONT>
		<table>
		<TR>
		<TD align="right" VALIGN="TOP" COLSPAN="2">
		<strong><font size="-1" COLOR="#FFFFFF"><span style="font-family: Arial;"><%ErrMSG%></strong></font></TD>
		</TR>
		<tr>
	    <td align="right" VALIGN="TOP"><strong><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Ad Name*</span></font></strong></td>
        <td><input type="text" name="adname" size="40" value=""></td>
	    </tr>
	
		<tr>
	    <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Image URL</span></font></td>
        <td><input type="text" name="imageurl" size="40" value="<%=Print_ad ("imageurl",Request.QueryString ("adid"))%>"></td>
       </tr>
	
	
		<tr>
	    <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">IMAGE width</span></font></td>
	    <td><INPUT type="text" name="adwidth" size="40" value="<%=Print_ad ("adwidth",Request.QueryString ("adid"))%>"></td>
	    </tr>
		
		<tr>
	    <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">IMAGE height</span></font></td>
	    <td><INPUT type="text" name="adheight" size="40" value="<%=Print_ad ("adheight",Request.QueryString ("adid"))%>"></td>
	    </tr>
	
		<tr>
	    <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">IMAGE border</span></font></td>
	    <td><INPUT type="text" name="adborder" size="40" value="<%=Print_ad ("adborder",Request.QueryString ("adid"))%>"></td>
	    </tr>
	
		<tr>
	    <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Image ALT</span></font></td>
	    <td><input type="text" name="ALT" size="40" Value="<%=Print_ad ("ALT",Request.QueryString ("adid"))%>"></td>
	    </tr>
	
	
		<tr>
	    <td align="right"><strong><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Link to URL*</span></font></strong></td>
	    <td><input type="text" name="URL" size="40" value="<%=Print_ad ("URL",Request.QueryString ("adid"))%>"></td>
	    </tr>
	
		<tr>
	    <td align="right"><font size="-1" COLOR="#CCCCCC"><span style="font-family: Arial;">Link target</span></font></td>
	    <td><input type="text" name="adtarget" size="40" value="<%=Print_ad ("adTarget",Request.QueryString ("adid"))%>">&nbsp;&nbsp;<a href="javascript:new_window('glossary.asp#dateend')"><img src="../images2/help.gif" width="17" height="17" border="0" alt="What is 'LINK TARGET'?"></a></td>
	    </tr>
	
		<tr>
	    <td align="right"><strong><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Location*</span></font></strong></td>
	    <td><input type="text" name="target" size="40" value="<%=Print_ad ("target",Request.QueryString ("adid"))%>"></td>
	    </tr>
	
		<tr>
	    <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Weight</span></font></td>
        <td><select name="adWeight" size="1">
        <option value="1" 
        <%If Print_ad ("adWeight",Request.QueryString ("adid"))="1" or Print_ad ("adWeight",Request.QueryString ("adid"))=empty Then%>
        selected
        <%End If%>
        >--1--</option>
        <option 
        <%If Print_ad ("adWeight",Request.QueryString ("adid"))="2" Then%>
        selected 
        <%End If%>
        value="2">--2--</option>
        <option 
        <%If Print_ad ("adWeight",Request.QueryString ("adid"))="3" Then%>
        Selected 
        <%End IF%>
        value="3">--3--</option>
        <option 
        <%If Print_ad ("adWeight",Request.QueryString ("adid"))="4" Then%>
        selected 
        <%End If%>
        value="4">--4--</option>
        <option 
        <%If Print_ad ("adWeight",Request.QueryString ("adid"))="5" Then%>
        selected 
        <%End If%>
        value="5">--5--</option>
        <option 
        <%If Print_ad ("adWeight",Request.QueryString ("adid"))="6" Then%>
        selected 
        <%End If%>
        value="6">--6--</option>
        <option 
        <%If Print_ad ("adWeight",Request.QueryString ("adid"))="7" Then%>
        selected 
        <%End If%>
        value="7">--7--</option>
        <option 
        <%If Print_ad ("adWeight",Request.QueryString ("adid"))="8" Then%>
        selected 
        <%End If%>
        value="8">--8--</option>
        <option 
        <%If Print_ad ("adWeight",Request.QueryString ("adid"))="9" Then%>
        selected 
        <%End If%>
        value="9">--9--</option>
        <option 
        <%If Print_ad ("adWeight",Request.QueryString ("adid"))="10" Then%>
        selected 
        <%End If%>
        value="10">--10--</option>
     </select>
	 </td>
     </tr>&nbsp;
	<tr>
      <td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Text Message</span></font></td>
      <td><TEXTAREA rows=5 cols=35 id=textarea1 name="textmsg"><%=Print_ad ("textmsg",Request.QueryString ("adid"))%></TEXTAREA></td>
    </tr>

	 <tr>
     <td align="right"><strong><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Status*</span></font></strong></td>
     <td><select name="status" size="1">
        <option selected value="Active">Active</option>
        <option value="Expired">Expired</option>
        <option value="Hold">Hold</option>
        <option value="Hold%20to%20launch">Hold to launch</option>
      </select>
	 </td>
     </tr>
	
	
	 <tr>
     <td align="right"><strong><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Date Start*</span></font></strong><br><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">( mm/dd/yyyy )</span></font></td>
     <td><input type="text" name="datestart" size="40" 
      value="<%=C_F_date(date)%>">
	 </td>
     </tr>
	 <tr>
	   <td colspan="2" align="center"><br><font size="-1" color="FF3333"><span style="font-family: Arial;"><b>Please select ONE of the following ONLY:<br>
	    "Date End",  "Click Expire" or "# of Impression Purchased".</b></span></font></td>
	 </tr>
	 <tr>
     <td align="right"><br><font size="-1" COLOR="#FFCC00"><span style="font-family: Arial;">Date End</span></font><br><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">( mm/dd/yyyy )</span></font></td>
     <td><input type="text" name="dateend" size="40" value="">&nbsp;&nbsp;<a href="javascript:new_window('glossary.asp#dateend')"><img src="../images2/help.gif" width="17" height="17" border="0" alt="What is 'DATE END'?"></a>
	 </td>
     </tr>
	<tr>
      <td align="right"><font size="-1" COLOR="#FFCC00"><span style="font-family: Arial;">Click Expire</span></font></td>
      <td><input type="text" name="clickexpire" size="40" value="">&nbsp;&nbsp;<a href="javascript:new_window('glossary.asp#clickexpire')"><img src="../images2/help.gif" width="17" height="17" border="0" alt="What is 'CLICK EXPIRE'?"></a></td>
    </tr>
	<tr>
      <td align="right"><font size="-1" COLOR="#FFCC00"><span style="font-family: Arial;"># of Impression Purchased</span></font></td>
      <td><input type="text" name="impressionsPurchased" size="40" value="">&nbsp;&nbsp;<a href="javascript:new_window('glossary.asp#imp')"><img src="../images2/help.gif" width="17" height="17" border="0" alt="What is '# OF IMPRESSION PURCHASED'?"></a></td>
    </tr>
    
	<tr>
      <td>
		&nbsp;
      </td>
	</tr>
	
   
    <tr>
	  <td>&nbsp;</td>
      <td>
      <input type="submit" value="C L O N E" name="Finish" style="font-weight: bold;">
       <input type="reset" value="Reset" name=reset1> 
	  <p>&nbsp;
	<%IF Request.QueryString ("BURL")<>EMPTY THEN%>
	<A HREF="<%=decode(Request.QueryString ("BURL"))%>"><img src="../images2/back.gif" width="52" height="19" border="0" alt="BACK TO PREVIOUS"></A>
	<%END IF%>

</td>
    </tr>
  </table>
	
	</TD>
	</TR>
	</TABLE>
</TD>
</TR>

<!-- SPACER -->
<TR><TD><IMG SRC="../images2/spacer.gif" HEIGHT=23 BORDER="0"></TD></TR>
</TABLE>

</FORM>
<!--#include file="include/bottom.html"-->

</BODY>
</HTML>