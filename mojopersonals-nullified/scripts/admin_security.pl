############################################################
sub SecurityMain{
	   if($FORM{class} eq "ban"){					&SecurityBanning;				}
	elsif($FORM{class} eq "referer"){			&SecurityReferer;				}
	elsif($FORM{class} eq "reservedname"){		&SecurityReservedUsername;	}
	&PrintSecurity;
}
############################################################
sub SecurityBanning{
	my(@content, $message);
	
	if($FORM{cancel}){		$message = $mj{cancel};	}
	elsif($FORM{step} eq "final"){
		&CheckAdminPermission("security", "ban");
		
		@content = split(/\n/, $FORM{banned_ip});
		&FileWrite($CONFIG{banned_ip}, \@content);
		
		@content = split(/\n/, $FORM{banned_email});
		&FileWrite($CONFIG{banned_email}, \@content);
		
		@content = split(/\n/, $FORM{banned_username});
		&FileWrite($CONFIG{banned_username}, \@content);
		$CONFIG{message} = $mj{success};
	}
	&PrintSecurityBanning;
}
############################################################
sub SecurityReferer{
	my(@content, $message);
	
	if($FORM{cancel}){		$message = $mj{cancel};	}
	elsif($FORM{step} eq "final"){
		&CheckAdminPermission("security", "referer");
		
		@content = split(/\n/, $FORM{valid_referer});
		&FileWrite($CONFIG{valid_referer}, \@content);
		$CONFIG{message} = $mj{success};
	}
	&PrintSecurityReferer;
}
############################################################
sub SecurityReservedUsername{
	my(@content, $message);
	
	if($FORM{cancel}){		$message = $mj{cancel};	}
	elsif($FORM{step} eq "final"){
		&CheckAdminPermission("security", "reservedusername");
		
		@content = split(/\n/, $FORM{names});
		&FileWrite($CONFIG{reserved_username}, \@content);
		$CONFIG{check_wholename}= $FORM{check_wholename};
		$CONFIG{check_case}=      $FORM{check_case};
		require "admin_setup.pl";
		&LoadConfigFile;
		&WriteConfig;
		$CONFIG{message} = $mj{success};
	}
	&PrintSecurityReservedUsername;
}
############################################################
sub PrintSecurityBanning{
	my(%HTML, $message);
	$message = shift;
#	$message = $mj{security6} unless $message;
	$FORM{banned_ip}=       &FileRead($CONFIG{banned_ip}) if(-f $CONFIG{banned_ip});
	$FORM{banned_email}=    &FileRead($CONFIG{banned_email}) if(-f $CONFIG{banned_email});
	$FORM{banned_username}= &FileRead($CONFIG{banned_username}) if(-f $CONFIG{banned_username});
	&PrintMojoHeader;
	print qq|
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="431"> <br>
      <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="security">
        <input type="hidden" name="class" value="ban">
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{security6}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="352"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{security7}</font></b></font><br>
              <textarea name="banned_ip" cols="40" rows="5" wrap="VIRTUAL">$FORM{banned_ip}</textarea>
              <br>
              <br>
              &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{security8}</font></b></font><br>
              <textarea name="banned_email" cols="40" rows="5" wrap="VIRTUAL">$FORM{banned_email}</textarea>
              <br>
              <font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{security9}</font></b></font><br>
              <textarea name="banned_username" cols="40" rows="5" wrap="VIRTUAL">$FORM{banned_username}</textarea>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2"> 
              <div align="center"> 
                <input type="submit" name="Submit" value="$TXT{save}">
                <input type="reset" name="reset" value="$TXT{reset}">
              </div>
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
############################################################
sub PrintSecurityReferer{
	my(%HTML, $message);
	$message = shift;	$message = $CONFIG{message} if $CONFIG{message};
	$FORM{valid_referer}=&FileRead($CONFIG{valid_referer}) if(-f $CONFIG{valid_referer});
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="175" valign="top"> <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="security">
        <input type="hidden" name="class" value="referer">
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{security11}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="100" valign="top"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{security12}</font></b></font><br>
              <textarea name="valid_referer" cols="40" rows="5" wrap="VIRTUAL">$FORM{valid_referer}</textarea>
              </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2"> 
              <div align="center"> 
                <input type="submit" name="Submit" value="$TXT{save}">
                <input type="reset" name="reset" value="$TXT{reset}">
              </div>
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
############################################################
sub PrintSecurityReservedUsername{
	my(%HTML, $message);
	$message = shift;
	$message = $mj{security2} unless $message;
	$HTML{check_wholename} = $Cgi->checkbox("check_wholename", $CONFIG{check_wholename}, "checked", $mj{security3});
	$HTML{check_case} = $Cgi->checkbox("check_case", $CONFIG{check_case}, "checked", $mj{security4});
	$FORM{names} = &FileRead($CONFIG{reserved_username}) if (-f $CONFIG{reserved_username});
	&PrintMojoHeader;
	print qq|
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="255"> <br>
      <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="security">
       <input type="hidden" name="class" value="reservedname">
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{security1}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="51"> 
              <textarea name="names" cols="40" rows="5" wrap="VIRTUAL">$FORM{names}</textarea>
            </td>
          </tr>
          <tr>
            <td class="titlebg" bgcolor="#EEEEEE" height="25">$HTML{check_wholename}<br>
              $HTML{check_case} </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2"> 
              <div align="center"> 
                <input type="submit" name="Submit" value="$TXT{save}">
                <input type="reset" name="reset" value="$TXT{reset}">
              </div>
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
############################################################
sub PrintSecurity{
	&PrintMojoHeader;
	print qq|
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="255">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6" colspan="2"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{security}</font></b></font></td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2" colspan="2"> 
              <div align="left">
                
              <ul>
                  
                <li><a href="$CONFIG{admin_url}?type=security&class=reservedname">$mj{security1}</a></li>
                <li><a href="$CONFIG{admin_url}?type=security&class=ban">$mj{security6}</a></li>
                <li><a href="$CONFIG{admin_url}?type=security&class=referer">$mj{security11}</a></li>
              </ul>
              </div>
            </td>
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
