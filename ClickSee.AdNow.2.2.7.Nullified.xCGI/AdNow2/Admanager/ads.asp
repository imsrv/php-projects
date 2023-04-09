<%@ Language=VBScript %>
<!--#Include File="../Data_Connection/Connection.asp"-->
<HTML>
<HEAD>
<TITLE>Add a new advertisement</TITLE>
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

<body background="../images2/bg.gif" topmargin="0" bottommargin="0" marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" bgcolor="#003366">
<!--#include file="include/logo.asp"--><br><br><br><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
<!-- BEGIN DETAIL -->
<form method="POST" action="include/newads.asp?<%=Request.ServerVariables ("QUERY_STRING")%>" onsubmit="return validate(this)" id=form1 name=form1>
<script Language="JavaScript">

function validate(theForm)
{
  if (theForm.elements["adname"].value == "") {
    theForm.elements["adname"].focus();
    alert("Please enter a value for the \"Ad Name\" field.");
    return false;
  }


  if (theForm.elements["url"].value == "")
  {
    theForm.elements["url"].focus();
    alert("Please enter a value for the \"Link to URL\" field.");
    return (false);
  }

  if (theForm.elements["location"].value == "")
  {
    theForm.elements["location"].focus();
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

  if (((theForm.elements["dateend"].value == "") && (theForm.elements["clickex"].value == "")) && (theForm.elements["imp"].value == ""))
  {
    theForm.elements["dateend"].focus();
    alert("Please enter 'Date End' or 'Click Expire' or 'Imp Purchased'.");
    return (false);
  }

  if (((theForm.elements["dateend"].value != "") && (theForm.elements["clickex"].value != ""))  && ((theForm.elements["imp"].value != "" )))
  {
    alert("Please enter 'Date End' or 'Click Expire' or 'Imp Purchased'.");
    return (false);
  }

  if ((theForm.elements["dateend"].value != "") && (theForm.elements["clickex"].value != ""))
  {
    alert("Please enter 'Date End' or 'Click Expire' or 'Imp Purchased'.");
    return (false);
  }
  if ((theForm.elements["clickex"].value != "")  && (theForm.elements["imp"].value != "" ))
  {
    alert("Please enter 'Date End' or 'Click Expire' or 'Imp Purchased'.");
    return (false);
  }
  if ((theForm.elements["dateend"].value != "")  && (theForm.elements["imp"].value != "" ))
  {
    alert("Please enter 'Date End' or 'Click Expire' or 'Imp Purchased'.");
    return (false);
  }

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
		  <TD VALIGN="TOP"><IMG SRC="../images2/grey.gif" WIDTH=1 HEIGHT=900 BORDER="0"></TD>
	<!-- Form Text Field -->	
		  <TD WIDTH="500" VALIGN="TOP" ALIGN="CENTER">
	<strong><font size="4" COLOR="#CCCCCC"><span style="font-family: Arial;">ADD NEW ADVERTISEMENT</strong></font><br>
	<!-- Error Message -->
  	<FONT FACE="arial,helvetica" SIZE="-1" COLOR="#FF0000"><STRONG><%ErrMSG%></STRONG></FONT><br>
			<table border="0">
			  <tr>
	    		<td align="right" VALIGN="TOP"><strong><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Ad Name*</span></font></strong></td>
        		<td><input type="text" name="adname" size="40" value=<%=session("adname")%>></td>
	    	  </tr>
			  <tr>
	    		<td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Image URL</span></font></td>
        		<td><input type="text" name="imageurl" size="40" value=<%=session("imageurl")%>></td>
       		  </tr>
			  <tr>
	    		<td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">IMAGE width</span></font></td>
	    		<td><INPUT type="text" name="IMAGEwidth" size="40" value=<%=session("IMAGEwidth")%>></td>
	    	  </tr>
			  <tr>
	    		<td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">IMAGE height</span></font></td>
	    		<td><INPUT type="text" name="IMAGEheight" size="40" value=<%=session("IMAGEheight")%>></td>
	    	  </tr>
			  <tr>
	    		<td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">IMAGE border</span></font></td>
	    		<td><INPUT type="text" name="IMAGEborder" size="40" value=<%=session("IMAGEborder")%>></td>
	    	  </tr>
			  <tr>
	    		<td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Image ALT</span></font></td>
	    		<td><input type="text" name="ImageALT" size="40" Value="<%=session("ImageALT")%>"></td>
	    	  </tr>
			  <tr>
	    		<td align="right"><strong><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Link to URL*</span></font></strong></td>
	    		<td><input type="text" name="url" size="40" value="http://<%=session("url")%>"></td>
	    	  </tr>
			  <tr>
	    		<td align="right"><font size="-1" COLOR="#CCCCCC"><span style="font-family: Arial;">Link target</span></font></td>
	    		<td><input type="text" name="adtarget" size="40" value="<%=session("adtarget")%>">&nbsp;&nbsp;<a href="javascript:new_window('glossary.asp#linktarget')"><img src="../images2/help.gif" width="17" height="17" border="0" alt="What is 'LINK TARGET'?"></a></td>
	    	  </tr>
			  <tr>
	    		<td align="right"><strong><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Location*</span></font></strong></td>
	    		<td><input type="text" name="location" size="40" value=<%=session("location")%>></td>
	    	  </tr>
			  <tr>
	    		<td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Weight</span></font></td>
        		<td><select name="Weight" size="1">
			        <option value="1" 
			        <%If Session("Weight")<>"1" or session("Weight")=empty Then%>
			        selected
			        <%End If%>
			        >--1--</option>
			        <option 
			        <%If Session("Weight")="2" Then%>
			        selected 
			        <%End If%>
			        value="2">--2--</option>
			        <option 
			        <%If Session("Weight")="3" Then%>
			        Selected 
			        <%End IF%>
			        value="3">--3--</option>
			        <option 
			        <%If Session("Weight")="4" Then%>
			        selected 
			        <%End If%>
			        value="4">--4--</option>
			        <option 
			        <%If session("Weight")="5" Then%>
			        selected 
			        <%End If%>
			        value="5">--5--</option>
			        <option 
			        <%If session("Weight")="6" Then%>
			        selected 
			        <%End If%>
			        value="6">--6--</option>
			        <option 
			        <%If session("Weight")="7" Then%>
			        selected 
			        <%End If%>
			        value="7">--7--</option>
			        <option 
			        <%If session("Weight")="8" Then%>
			        selected 
			        <%End If%>
			        value="8">--8--</option>
			        <option 
			        <%If session("Weight")="9" Then%>
			        selected 
			        <%End If%>
			        value="9">--9--</option>
			        <option 
			        <%If session("Weight")="imp" Then%>
			        selected 
			        <%End If%>
			        value="10">--10--</option>
			     </select>
	 			</td>
     	  	  </tr>&nbsp;
		  	  <tr>
      			<td align="right"><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">Text Message</span></font></td>
      			<td><TEXTAREA rows=5 cols=35 id=textarea1 name="textmessage"><%=Session("textmessage")%></TEXTAREA></td>
    	  	  </tr>
	 	  	  <tr>
	     		<td align="right"><strong><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;">Status*</span></font></strong></td>
	     		<td><select name="status" size="1">
		        <option 
		        <%If session("status")="Active" Or Session("status")=empty Then%>
		        selected 
		        <%End If%>
		        value="Active">Active</option>
		        <option 
		        <%If session("status")="Expired" Then%>
		        selected 
		        <%End If%>
		        value="Expired">Expired</option>
		        <option 
		        <%If Session("status")="Hold" Then%>
		        selected 
		        <%End If%>
		        value="Hold">Hold</option>
		        <option 
		        <%If Session("status")="Hold%20to%20launch" Then%>
		        selected 
		        <%End If%>
		        value="Hold%20to%20launch">Hold to launch</option>
		      	</select>
	 			</td>
     	  	  </tr>
	 	  	  <tr>
     			<td align="right"><font size="-1" COLOR="#FF9900"><span style="font-family: Arial;"><strong>Date Start*</strong></span></font><br><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">( mm/dd/yyyy )</span></font></td>
     			<td><input type="text" name="datestart" size="40" 
		      	<%If Session("datestart")<>empty Then%>
		      	Value="<%=session("datestart")%>"
		      	<%Else%>
		      	value="<%=C_F_date(date)%>"
		      	<%End If%>>
	 			</td>
     	  	  </tr>
	 	  	  <tr>
	   			<td colspan="2" align="center"><br><font size="-1" color="#FF3333"><span style="font-family: Arial;"><b>Please select ONE of the following ONLY:<br>
	    		"Date End",  "Click Expire" or "# of Impression Purchased".</b></span></font></td>
	 	  	  </tr>
	 	  	  <tr>
     			<td align="right"><br><font size="-1" COLOR="#FFCC00"><span style="font-family: Arial;">Date End</span></font><br><font size="-1" color="#CCCCCC"><span style="font-family: Arial;">( mm/dd/yyyy )</span></font></td>
     			<td><input type="text" name="dateend" size="40" 
			      <%If Session("dateend")<>empty Then%>
			      Value="<%=session("dateend")%>"
			      <%Else%>
			      value=""
			      <%End If%>>&nbsp;&nbsp;<a href="javascript:new_window('glossary.asp#dateend')"><img src="../images2/help.gif" width="17" height="17" border="0" alt="What is 'DATE END'?"></a>
	 			</td>
     	  	  </tr>
		  	  <tr>
      			<td align="right"><font size="-1" COLOR="#FFCC00"><span style="font-family: Arial;">Click Expire</span></font></td>
      			<td><input type="text" name="clickex" size="40" 
				<% If session("clickex")<> empty then %>
				value=<%=session("clickex")%>
				<% Else  %>
				value=""
				<% End If %>>&nbsp;&nbsp;<a href="javascript:new_window('glossary.asp#clickexpire')"><img src="../images2/help.gif" width="17" height="17" border="0" alt="What is 'CLICK EXPIRE'?"></a></td>
    	  	  </tr>
		  	  <tr>
      			<td align="right"><font size="-1" COLOR="#FFCC00"><span style="font-family: Arial;"># of Impression Purchased</span></font></td>
      			<td><input type="text" name="imp" size="40" value=<%=session("imp")%>>&nbsp;&nbsp;<a href="javascript:new_window('glossary.asp#imp')"><img src="../images2/help.gif" width="17" height="17" border="0" alt="What is '# OF IMPRESSION PURCHASED'?"></a></td>
    	  	  </tr>
    	  	  <tr>
	  			<td>&nbsp;</td>
      			<td><p>&nbsp;</p>
			      <input type="submit" value="Add another advertisement >>" name="Continute">&nbsp;&nbsp;&nbsp;
			      <input type="submit" value="Done" name="Finish" style="font-weight: bold;"> 
				  <p>&nbsp;
					<%
					'Clear session.
						Session("campaignid")=abandon
						Session("adname")=abandon
						Session("imageurl")=abandon
						Session("url")=abandon
						Session("location")=abandon
						Session("textmessage")=abandon
						Session("status")=abandon
						Session("Date_start")=abandon
						Session("dateend")=abandon
						Session("Clickex")=abandon
						Session("imp")=abandon
						Session("Weight")=abandon
						Session("IMAGEwidth")=abandon
						Session("IMAGEheight")=abandon
						Session("IMAGEborder")=abandon
						Session("ImageALT")=abandon
					%>
					<%IF request("BURL")<>EMPTY THEN%>
					<a HREF="<%= request("BURL") %>"><img src="../images2/back.gif" width="52" height="19" border="0" alt="BACK TO PREVIOUS"></a>
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
<!-- END DETAIL -->	
	</td>
  </tr>
</table>
<!--#include file="include/bottom.html"-->
</BODY>
</HTML>