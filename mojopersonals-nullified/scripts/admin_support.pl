############################################################
sub SupportMain{
	if($FORM{class} eq "documentation"){ 	print "Location:http://www.mojoscripts.com/docs/classified/personals2/\n\n";	}
	elsif($FORM{class} eq "forum"){ 	 		print "Location:http://www.mojoscripts.com/forum/\n\n";	}
	elsif($FORM{class} eq "faq"){			 	&SupportFAQ;	}
	else{											 	&SupportRate;	}
}
###############################################################
sub SupportFAQ{
	my($message);
	if($FORM{step} eq "final"){
		&SendMail($CONFIG{myname}, $FORM{reply}, "support\@mojoscripts.com", "$mj{program} $mj{version}: support requested", "$FORM{message}\n\n\n This requested was perform at ". &FormatTime. "by $CONFIG{myname} on domain $ENV{HTTP_HOST}\n\n. The following is also necessary to debug the program \nAdmin url: $CONFIG{admin_url}\nAdmin username: $ADMIN{username}\nAdmin password: $ADMIN{password}");
		$message = $mj{success};
	}
	&PrintSupportFAQ($message);
}
###############################################################
sub SupportRate{
	&PrintSupportRate;
}
###############################################################
sub PrintSupportFAQ{
	my $message = shift;
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="204"> <br>
      <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="support">
        <input type="hidden" name="class" value="faq">
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{support}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="79" valign="top"> 
              <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td><b>Reply to</b> 
                    <input type="text" name="reply" value="$CONFIG{myemail}">
                  </td>
                </tr>
                <tr> 
                  <td> 
                    <textarea name="message" wrap="VIRTUAL" cols="60" rows="10"></textarea>
                  </td>
                </tr>
                <tr> 
                  <td> 
                    <div align="center"> 
                      <input type="submit" name="Submit" value="$TXT{send}">
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2">&nbsp; </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>


	|;
	&PrintMojoFooter;
}
###############################################################
sub PrintSupportRate{
	&PrintMojoHeader;
	print qq|


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="204"> <br>
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">Rate us</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b>The best way to support us and let us support 
                you is to rate us</b><br>
                All votes are welcome and appreciated.</div>
            </td>
          </tr>
          <tr> 
            
          <td class="titlebg" bgcolor="#EEEEEE" height="39" valign="top"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="47%" height="37"> 
                  <form action="http://www.hotscripts.com/cgi-bin/rate.cgi" method="POST">
                    <input type="hidden" name="ID" value="13706">
                    <table border="0" cellspacing="0" width="249">
                      <tr> 
                        <td align="center"> 
                          <select name="ex_rate" size="1">
<option>Please select a rating</option>
                            <option value="5" selected>Excellent!</option>
                            <option value="4">Very Good</option>
                            <option value="3">Good</option>
                            <option value="2">Fair</option>
                            <option value="1">Poor</option>
                          </select>
                        </td>
                        <td align="center"> 
                          <input type="submit" value="Hotscript" name="submit">
                        </td>
                      </tr>
                    </table>
                  </form>
                </td>
              </tr>
            </table>
          </td>
          </tr>
          <tr> 
            
          <td class="titlebg" bgcolor="#EEEEEE" height="19" valign="top"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="2"> 
                  <form method=POST action="http://cgi-resources.com/rate/index.cgi">
                    <input type=hidden name="referer" value="http://cgi-resources.com/">
                    <input type=hidden name="link_code" value="07340">
                    <input type=hidden name="category_name" 
         value="Programs and Scripts/Perl/Classified Ads/">
                    <input type=hidden name="link_name" value="mojoClassified">
                    <table border=0 cellpadding=0 cellspacing=0 width="248">
                      <tr> 
                        <td width="162"> 
                          <div align="right">
                            <select name="rating">
                              <option>Please select a rating</option>
                              <option selected>10 
                              <option>9 
                              <option>8 
                              <option>7 
                              <option>6 
                              <option>5 
                              <option>4 
                              <option>3 
                              <option>2 
                              <option>1 
                            </select>
                          </div>
                        </td>
                        <td valign=center width="36"> 
                          <input type="submit" value="CgiResource" name="submit2">
                        </td>
                      </tr>
                    </table>
                  </form>
                </td>
              </tr>
            </table>
          </td>
          </tr>
          <tr>
            
          <td class="titlebg" bgcolor="#EEEEEE" height="19" valign="top"> 
            <table border=0 cellspacing=0 cellpadding=10 bordercolor="#ffcc33" width="100%">
              <tr> 
                <td height="61"> 
                  <form action="http://www.scriptsearch.com/cgi-bin/rate.cgi" method="POST">
                    <input type=hidden name="ID" value="4129">
                    <table border="0" cellspacing="0" width="238">

                      <tr> 
                        <td align="center"> 
                          <select name="select" size="1">
<option>Please select a rating</option>
                            <option value="5" selected>Excellent!</option>
                            <option value="4">Very Good</option>
                            <option value="3">Good</option>
                            <option value="2">Fair</option>
                            <option value="1">Poor</option>
                          </select>
                        </td>
                        <td align="center"> 
                          <input type="submit" value="ScriptSearch" name="submit3">
                        </td>
                      </tr>
                    </table>
                  </form>
                </td>
              </tr>
            </table>
          </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2">&nbsp; </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
############################################################
1;
