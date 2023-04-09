<%@ Language=VBScript %>
<!--#Include File="include/center.asp"-->
<HTML>
<HEAD>
<title>Clicksee AdNow! Version 2.0 - Administrative Center</title>
<!-- START open.window script -->
<script language="JavaScript">
<!--//BEGIN Script

function new_window(url) {

link = window.open(url,"Link","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=400,height=360,left=80,top=80");

}
//END Script-->
</script>
<!-- END open.window script -->
</HEAD>
<BODY text="#000000" link="#0000FF" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" background="../images2/bg.gif" bgcolor="#003366">

<!--Logo-->
<!--#include file="include/logo.asp"--><br>
<!-- MENU -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="510">
<tr>
<td valign="top">
<p align="center"><font face="Arial" color="#CCCCCC" size="4"><b>ADMINISTRATOR CENTER</b></font></p>
<!-- MIDDLE PART -->
<FORM action="stats.asp" method=POST>
  <table border="0" cellpadding="2" cellspacing="0" width="75%" bgcolor="#FFFFFF" align="center">
    <tr>
      <td>
          <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#003366">
            <tr>
              <td width="100%">
				<table border="0" cellpadding="2" cellspacing="5" width="100%">
				  <TR> 
				    <TD valign="top" align="center" colspan="3" bgcolor="#FF9900"> <a href="javascript:new_window('glossary.asp#ad_management')"><img alt="What is 'ADVERTISING MANAGEMENT'?" border="0" src="../images2/help01.gif" align="right" width="17" height="17"></a><strong><font style="font-family: Arial" color="#003366" size="-1">ADVERTISING
				      MANAGEMENT</font></strong>
					</TD>
				  </TR>
				  <TR> 
				    <TD valign="top" align="center"> <font color="#CCCCCC"><STRONG><font style="font-family: Arial;" size="-1">Company</font></STRONG><br>
				        <SELECT id=select2 name="CompanyCode" size="10">
				          <OPTION selected value="">&nbsp;&nbsp;--- All Companies ---&nbsp;&nbsp;</OPTION>
				          <%ListComopany%> 
				        </SELECT></font>
					</TD>
				    <TD valign="top" align="center"><font color="#CCCCCC"><STRONG><font style="font-family: Arial;" size="-1">Location</font></STRONG><br>
				        <SELECT name="Location" size="10">
				          <OPTION selected Value="">&nbsp;&nbsp;--- All Locations ---&nbsp;&nbsp;</OPTION>
				          <%ListAds%> 
				        </SELECT></font>
					</TD>
				    <TD valign="top" align="center"><font color="#CCCCCC"><STRONG><font style="font-family: Arial;" size="-1">Status</font></STRONG><br>
				        <STRONG> 
				        <SELECT id=select3 name="Status" size="5">
				          <OPTION selected Value="">&nbsp;&nbsp;--- All ---&nbsp;&nbsp;</OPTION>
				          <OPTION Value="Active">Active</OPTION>
				          <OPTION Value="Expired">Expired</OPTION>
				          <OPTION Value="Hold">Hold</OPTION>
				          <OPTION Value="Hold%20to%20launch">Hold to launch</OPTION>
				        </SELECT>
				        </STRONG> </font>
					</TD>
				  </TR>
				  <tr> 
				  	<td>&nbsp;</td>
				    <td align="center"> <%IF CheckRecord THEN%>
				        <INPUT type="image" src="../images2/viewbig01.gif" border="0" value="View Report" id=submit1 name="View" style="font-weight: bold;">
				        <%ELSE%> &nbsp; <%END IF%> </td>
				    <td>&nbsp;</td>
				  </tr>
				 </table>
              </td>
            </tr>
          </table>
      </td>
    </tr>
  </table>
</form>
<%'IF CheckRecord THEN%>
<!-- View Expire --> 
<table border="0" cellpadding="0" cellspacing="0" ALIGN="CENTER" width="75%">
  <tr> 
    <td colspan="3"> 
<!-- Start Expire View -->
		<table width="100%" border="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
		  <tr>
		    <td>
				<table width="100%" border="0" cellpadding="0" cellspacing="2" bgcolor="#003366" align="center">
				  <tr>
				    <td>
					  <table width="100%" border="0" cellpadding="2" cellspacing="5" bgcolor="#003366">
				          <tr>
				            <td align="center" colspan="3" bgcolor="#FF9900"><a href="javascript:new_window('glossary.asp#expiration_meter')"><img alt="What is 'EXPIRATION METER'?" border="0" src="../images2/help01.gif" align="right" width="17" height="17"></a><b><font size="2" face="Arial" color="#003366">TOOL:
				              EXPIRATION METER</font></b></td>
				          </tr>
						  <tr><FORM action="stats.asp" method=POST id=form1 name=form1>
						    <td align="right"><font size="2" face="Arial" color="#FFFFFF">Ads that expire</font></td>
							<td>
							  <select name="monthexpire" size="1">
	                            <OPTION selected value="-1">Last Month</OPTION>
	                            <OPTION value="0">This Month</OPTION>
	                            <OPTION value="+1">Next Month</OPTION>
							  </select>
							</td>
            				<td>
							  <input type="hidden" value="View" name="ViewEx1">
							  <input type="image" src="../images2/view01.gif" border="0">
							</td></form>
						  </tr>
						  <tr><FORM action="stats.asp" method=POST>
						    <td align="right"><font size="2" face="Arial" color="#FFFFFF">Ads that have less than</font></td>
							<td><INPUT type="text" name="imp_left" size="10"><font size="2" face="Arial" color="#FFFFFF">&nbsp;impressions remaining.</font></td>
							<td>
							  <input type="hidden" value="View" name="ViewEx2">
							  <input type="image" src="../images2/view01.gif" border="0">
							</td></form>
						  </tr>
						  <tr><FORM action="stats.asp" method=POST id=form2 name=form2>
						    <td align="right"><font size="2" face="Arial" color="#FFFFFF">Ads that have less than</font></td>
							<td><INPUT type="text" name="day_left" size="10"><font size="2" face="Arial" color="#FFFFFF">&nbsp;days remaining.</font></td>
							<td>
							  <input type="hidden" value="View" name="ViewEx3">
							  <input type="image" src="../images2/view01.gif" border="0">
							</td></form>
						  </tr>
						  <tr><FORM action="stats.asp" method=POST id=form3 name=form3>
						    <td align="right"><font size="2" face="Arial" color="#FFFFFF">Ads that have less than</font></td>
							<td><INPUT type="text" name="click_left" size="10"><font size="2" face="Arial" color="#FFFFFF">&nbsp;clicks remaining.</font></td>
							<td>
							  <input type="hidden" value="View" name="ViewEx4">
							  <input type="image" src="../images2/view01.gif" border="0">
							</td></form>
						  </tr>
						</table>
				      </td>
				    </tr>
				  </table>
				</td>
			  </tr>
			</table>
		  </td>
		</tr>
	  </TABLE>
    <!-- End Expire View --> 
<br>
<form action="StatsLocation.asp" method="post">
<table border="0" cellpadding="0" cellspacing="0" ALIGN="CENTER" width="75%">
  <tr> 
    <td colspan="3"> 
	  <table width="100%" border="0" cellspacing="0" bgcolor="#FFFFFF">
	    <tr>
	      <td>
  			<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#003366">
    		  <tr>
      		 	<td width="100%">
	        	  <table border="0" cellpadding="2" cellspacing="5" width="100%">
	          		<tr>
	            	  <td align="center" colspan="3" bgcolor="#FF9900"><a href="javascript:new_window('glossary.asp#avg_click_by_location')"><img alt="What is 'STATISTICS OF AVERAGE CLICK THRU BY LOCATION'?" border="0" src="../images2/help01.gif" align="right" width="17" height="17"></a><font face="Arial" size="2" color="#003366"><b>TOOL:
	              STATISTICS OF AVERAGE CLICK THRU BY LOCATION</b></font></td>
	          	    </tr>
	          		<tr>
	            	  <td align="right"><font size="2" face="Arial" color="#FFFFFF">Select Location<%= Count %></font></td>
	            	  <td>
					  <select size="1" name="selectlocation">
					  <option value="all">ALL
<%bringTarget%>
<% session("Location")=abandon %>
	              	  </select>
					  </td>
	            	  <td><font face="Arial" size="2" color="#FFFFFF"><input type="image" src="../images2/view01.gif" border="0"></font></td>
	          		</tr>
	        	  </table>
			    </td>
			  </tr>
			</table>
		  </td>
  		</tr>
	  </table>
	</td>
  </tr>
</TABLE>
</form>
<br>
<form action="statsAVG1.asp" method="post">
<table border="0" cellpadding="0" cellspacing="0" ALIGN="CENTER" width="75%">
  <tr> 
    <td colspan="3"> 
	  <table width="100%" border="0" cellspacing="0" bgcolor="#FFFFFF">
	    <tr>
	      <td>
		    <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#003366">
		      <tr>
		        <td width="100%">
        		  <table border="0" cellpadding="2" cellspacing="5" width="100%">
          			<tr>
            		  <td align="center" colspan="2" bgcolor="#FF9900"><a href="javascript:new_window('glossary.asp#avg_imp_by_location')"><img alt="What is 'STATISTICS OF AVERAGE IMPRESSION BY LOCATION'?" border="0" src="../images2/help01.gif" align="right" width="17" height="17"></a><b><font face="Arial" size="2" color="#003366">TOOL:
              			<span style="mso-fareast-font-family: Times New Roman; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA">STATISTICS OF AVERAGE IMPRESSION BY LOCATION</span></font></b></td>
          			</tr>
          			<tr>
            		  <td align="right"><font size="2" face="Arial" color="#FFFFFF">View stats of</font></td>
            		  <td> 
					    <select name="Location">
						<option value="">Select Location</option>
						<% bringTarget %>
						</select>
            		  </td>
          			</tr>
          			<tr>
            		  <td align="right"><font face="Arial" size="2" color="#FFFFFF">in the past</font></td>
            		  <td><font face="Arial" size="2" color="#FFFFFF"><input type="text" name="day" size="5" value="30" maxlength="3">
              			days</font></td>
          			</tr>
          			<tr>
            		  <td align="right"></td>
            		  <td><font face="Arial" size="2" color="#FFFFFF"><input type="image" src="../images2/view01.gif" border="0"></font></td>
          		 	</tr>
        		  </table>
      			</td>
    		  </tr>
  		 	</table>
		  </td>
  		</tr>
	  </table>
	</td>
  </tr>
</TABLE>
</form>
<%'END IF%>
</td>
</tr>
</table>
<!--#include file="include/bottom.html"-->
</BODY>
</HTML>
