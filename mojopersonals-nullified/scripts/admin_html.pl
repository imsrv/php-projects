############################################################
sub PrintAdmin{
	&PrintMojoHeader;
	&BuildAdminStat;
	print qq|
<table width="600" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#EFEFEF">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> 
            <div align="center"><b>Welcome to the admin area of</b><br>
              <b><font size="4">$mj{program} $mj{version}</font></b></div>
          </td>
        </tr>
        <tr> 
          <td>You are logged in as <b>$ADMIN{username}</b>, position: <b>$ADMIN{position}. 
            </b>Please remember to logout when you're done to stop other who might 
            use your computer to have access to this restricted area.</td>
        </tr>
        <tr> 
          <td> 
            <div align="center"><b>Here is a short summary of stats</b></div>
          </td>
        </tr>
        <tr> 
          <td height="46"> 
            <table width="500" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="#EEEEEE">
              <tr> 
                <td width="149">Members</td>
                <td width="351">$MOJO{members}</td>
              </tr>
              <tr> 
                <td width="149">Categories</td>
                <td width="351">$MOJO{categories}</td>
              </tr>
              <tr> 
                <td width="149">Ads</td>
                <td width="351">$MOJO{ads}</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td align=center><br><br>As a(n) <b>$ADMIN{position}</b> position, you can do the following:</a></td>
        </tr>
        <tr> 
          <td bgcolor="#EFEFEF">$MOJO{allowable}</td>
        </tr>
        <tr> 
          <td>For complete permission settings, please <a href="$CONFIG{admin_url}?type=group&class=group&action=edit&group=$ADMIN{position}">click 
            here</a></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<p>&nbsp;</p>

	|;
&PrintMojoFooter;
}
############################################################
sub PrintError{
	my($title, $message) = @_;
&PrintMojoHeader;
print qq|
	<table bgcolor="#bfbfbf" border=2 cellspacing=0 cellpadding=0 align="center">
  <tr> 
    <td height="131" valign="top">
<form> 
      <table border=0 cellspacing=0 cellpadding=2>
        <tr bgcolor="#00007f"> 
          <td colspan=3 height="9"> 
            <table width=100% border=0 cellspacing=0 cellpadding=0 height="8">
              <tr> 
                  <td height="2"><font face="Tahoma" color="#FFFFFF"><b>&nbsp;&nbsp;$title</b></font></td>
                  <td height="2" align="right"> 
                    <input type="button" value=" X " onClick="history.go(-1)" name="button">
                  &nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td width=25 height="26"><br>
          </td>
            <td width=400 height=26><font face="Arial, Helvetica" size=2><br>
              $message<br>
              <br>
              </font></td>
          <td width=25 height="26"><br>
          </td>
        </tr>
        <tr> 
          <td width=25 height="26">&nbsp;</td>
          <td width=10 align="center"> 
                <input type="button" value=" OK " onClick="history.go(-1)" name="button">
          </td>
          <td width=25 height="26">&nbsp;</td>
        </tr>
      </table></form>
    </td>
  </tr>
</table>
|;
&PrintMojoFooter;
}
############################################################
sub PrintAdminLogin{
	$message = shift if $_[0];
	$FORM{username} = cookie($cookie_username) unless $FORM{username};
#	$FORM{password} = $COOKIES{$cookie_password} unless $FORM{password};
	print "content-type:text/html\n\n";
	print qq|
	<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td> 
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="action" value="login">
        <input type="hidden" name="step" value="final">
        <table width="400" border="1" cellspacing="1" cellpadding="5" align="center" bordercolor="#000000">
          <tr bgcolor="#666666"> 
            <td colspan="2" height="23"> 
              <div align="center"> <font color="#FFFFFF">MojoScripts' <br>
                <font size="6">$mj{program} $mj{version}</font></font></div>
            </td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td colspan="2" height="23"> 
              <div align="center">$message</div>
            </td>
          </tr>
          <tr> 
            <td>$TXT{username}</td>
            <td> 
              <input type="text" name="username" value="$FORM{username}">
            </td>
          </tr>
          <tr> 
            <td>$TXT{password}</td>
            <td> 
              <input type="password" name="password" value="$FORM{password}">
            </td>
          </tr>
          <tr> 
            <td colspan="2"> 
              <div align="center"> 
                <input type="submit" name="login" value="  $TXT{login} ">
              </div>
            </td>
          </tr>
        </table>
        <div align="center"><br>
          Powered by <a href="http://mojoscripts.com/products/mojoclassified/">$mj{program} 
          $mj{version}</a></div>
        <div align="center"><font size="1" face="Tahoma">&copy; 2001-2002 <a href="http://mojoscripts.com">mojoscripts</a>. 
          All rights reservered.<br>
          Re-distribution, re-use any part of the sourcecode is forbidden.</font></div>
      </form>
    </td>
  </tr>
</table>
|;
exit;
}
############################################################
sub PrintMojoHeader{
	my(@gateways, %HTML);
	@gateways = &GatewayAvailable();
	if(@gateways){	$HTML{membership} = qq|<tr><td bgcolor="#FFFFFF"><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=account">Membership Accounts</a></font></b></td></tr>|;	}
		
	&PrintHeader;
	print qq|
	<HTML>
<HEAD>
<TITLE>$CONFIG{page_title}</TITLE>
<style>

<!--a:hover{color:bd7637; }-->
</style>

</HEAD>
<BODY BGCOLOR=#FFFFFF topmargin="0" leftmargin="0" marginheight=0 marginwidth=0 rightmargin=0 bottommargin=0 link="#000000" vlink="#000000">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="516" valign="top"> 
      <table width="100%" border=0 cellpadding=0 cellspacing=0 style="border-collapse: collapse" bordercolor="#111111" height="25">
        <tr> 
          <td bgcolor="#5B9FBE" height="25" colspan="3"> 
            <div align="center"> 
              <p><font color="#FFFF00"><b><font face="Tahoma" size="6">$mj{program} 
                $mj{version}</font></b></font></p>
            </div>
          </td>
        </tr>
        <tr> 
          <td bgcolor="#5B9FBE" height="2" width="32%"><a href="$CONFIG{member_url}"><b><font color="#FFFFFF">User 
            area</font></b></a></td>
          <td bgcolor="#5B9FBE" height="2" width="53%"><b><font color="#FFFFFF">by</font> 
            <a href="http://www.mojoscripts.com"><font color="#FFFFFF">mojoscripts.com</font></a></b></td>
          <td bgcolor="#5B9FBE" height="2" width="15%"> 
            <div align="right"><b><font size="2" face="Tahoma"><a href="$CONFIG{admin_url}?action=logout"><font color="#FFFFFF">Logout</font></a></font></b></div>
          </td>
        </tr>
        <tr> 
          <td bgcolor="#000000" height="2" colspan="3"></td>
        </tr>
      </table>
      <table border="1" cellpadding="0" cellspacing="0" width="100%" bordercolor="#5A9EBD">
        <tr> 
          <td width="157" valign="top" bgcolor="#FFFFFF" height="450"> 
            <table border="0" cellspacing="0" width="157" style="border-collapse: collapse" bordercolor="#111111">
              <tr> 
                <td bgcolor="#5B9FBE" width="8">&nbsp;</td>
                <td bgcolor="#5B9FBE" width="145"> 
                  <p align="center"><b> <font size="2" face="Verdana" color="#FFFFFF">Configurations</font> 
                    </b> 
                </td>
              </tr>
              <tr> 
                <td valign="top" height="86" width="8">&nbsp;</td>
                <td valign="top" height="86" width="145"> 
                  <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr> 
                      <td><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=config&class=behavior">Behavior</a></font></b></td>
                    </tr>
                    <tr> 
                      <td height="4"><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=config&class=config">Configurations</a></font></b></td>
                    </tr>
                    <tr> 
                      <td><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=template">Templates</a></font></b></td>
                    </tr>
                    <tr> 
                      <td><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=config&class=display">Display</a></font></b></td>
                    </tr>
                    <tr> 
                      <td><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=database">Database 
                        Fields </a></font></b></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td bgcolor="#5B9FBE" width="8">&nbsp;</td>
                <td bgcolor="#5B9FBE" width="145"> 
                  <p align="center"><b> <font size="2" face="Verdana" color="#FFFFFF">Members</font></b> 
                </td>
              </tr>
              <tr> 
                <td valign="top" height="67" width="8">&nbsp;</td>
                <td valign="top" height="67" width="145"> 
                  <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr> 
                      <td height="4" bgcolor="#FFFFFF"><font color="#5A9EBD" face="Tahoma" size="2"></font><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=member&class=active">Active 
                        Members </a></font></b></td>
                    </tr>
                    <tr> 
                      <td bgcolor="#FFFFFF"><font color="#5A9EBD" face="Tahoma" size="2"></font><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=member&class=pending">Pending 
                        Members</a></font></b></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><font color="#5A9EBD" face="Tahoma" size="2"></font><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=member&class=suspend">Suspended&nbsp;Members
                      </a></font></b></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><font color="#5A9EBD" face="Tahoma" size="2"></font><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=member&class=expire">Expired 
                        Members </a></font></b></td>
                    </tr>
                    <tr> 
                      <td bgcolor="#FFFFFF"><font color="#5A9EBD" face="Tahoma" size="2"></font><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=member&class=search">Search 
                        Members </a></font></b></td>
                    </tr>
                    <tr> 
                      <td bgcolor="#FFFFFF"><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=mail">Email 
                        Members</a></font></b></td>
                    </tr>
                    <tr> 
                      <td bgcolor="#FFFFFF"><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=security">Security</a></font></b></td>
                    </tr>
<!--						  $HTML{membership} -->
                  </table>
                </td>
              </tr>
              <tr> 
                <td bgcolor="#5B9FBE" height="9" width="8">&nbsp;</td>
                <td bgcolor="#5B9FBE" height="9" width="145"> 
                  <div align="center"><b><font color="#FFFFFF">Categories/Ads</font></b></div>
                </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="2" width="8">&nbsp;</td>
                <td height="2" width="145"> 
                  <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr> 
                      <td height="6"><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=cat">Category 
                        Manager</a></font></b></td>
                    </tr>
                    <tr> 
                      <td><font face="Tahoma" size="2"></font><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=cat&action=add">Add 
                        Top Category</a></font></b></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td bgcolor="#5B9FBE" height="9" width="8">&nbsp;</td>
                <td bgcolor="#5B9FBE" height="9" width="145"> 
                  <div align="center"><b><font color="#FFFFFF">Accounts</font></b></div>
                </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="2" width="8">&nbsp;</td>
                <td height="2" width="145"> 
                  <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr> 
                      <td height="6"><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=account">Account
                        Manager</a></font></b></td>
                    </tr>
                    <tr> 
                      <td><font face="Tahoma" size="2"></font><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=account&action=add">Add 
                        New Account</a></font></b></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td bgcolor="#5B9FBE" width="8">&nbsp;</td>
                <td bgcolor="#5B9FBE" width="145"> 
                  <div align="center"><b><font size="2" face="Verdana" color="#FFFFFF">Administrators</font></b></div>
                </td>
              </tr>
              <tr> 
                <td valign="top" height="40" width="8">&nbsp;</td>
                <td valign="top" height="40" width="145"> 
                  <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr> 
                      <td height="4"><font size="2" face="Tahoma"></font><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=admin">Administrators</a></font></b></td>
                    </tr>
                    <tr> 
                      <td><font size="2" face="Tahoma"></font><b><font size="2" face="Tahoma"><a href="$CONFIG{admin_url}?type=group">Admin 
                        Groups</a></font></b></td>
                    </tr>
                    <tr> 
                      <td height="2"><font size="2" face="Tahoma"></font><b><font size="2" face="Tahoma"><a href="$CONFIG{admin_url}?action=logout">Logout</a></font></b></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td bgcolor="#5B9FBE" width="8">&nbsp;</td>
                <td bgcolor="#5B9FBE" width="145"> 
                  <div align="center"><b><font size="2" face="Verdana" color="#FFFFFF">Support 
                    &amp; Utilities</font></b></div>
                </td>
              </tr>
              <tr> 
                <td height="51" width="8">&nbsp;</td>
                <td height="51" width="145"> 
                  <table border="0" cellspacing="0" cellpadding="1" width="100%">
                    <tr> 
                      <td height="4"><font face="Tahoma" size="2"></font> 
                        <div align="right"><font face="Tahoma" size="2"><b><a href="$CONFIG{admin_url}?type=support&class=faq">FAQ</a></b></font></div>
                      </td>
                    </tr>
                    <tr> 
                      <td><font face="Tahoma" size="2"></font> 
                        <div align="right"><font face="Tahoma" size="2"><b><a href="$CONFIG{admin_url}?type=support&class=documentation">Documentation</a></b></font></div>
                      </td>
                    </tr>
                    <tr> 
                      <td height="2"><font face="Tahoma" size="2"></font> 
                        <div align="right"><font face="Tahoma" size="2"><b><a href="$CONFIG{admin_url}?type=support&class=forum">Support 
                          Forum</a></b></font></div>
                      </td>
                    </tr>
                    <tr> 
                      <td height="2"><font face="Tahoma" size="2"></font> 
                        <div align="right"><font face="Tahoma" size="2"><b><a href="$CONFIG{admin_url}?type=support&class=rate">Rate 
                          This</a></b></font></div>
                      </td>
                    </tr>
                    <tr> 
                      <td height="2"> 
                        <div align="right"><b><font face="Tahoma" size="2"><a href="$CONFIG{admin_url}?type=utils">Utilities</a></font></b></div>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
          <td valign="top" bgcolor="#FFFFFF" height="450"> $HTML_location 
			|;
	} 
############################################################ 
sub PrintMojoFooter{ 
            print qq| 
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="18" bgcolor="#5A9EBD"> 
      <div align="center"><font face="Tahoma" color="#FFFFFF">written and copyright 
        &copy;2001-2002 <a href="http://www.mojoscripts.com"><font color="#0000FF">mojoscripts.com</font></a><br>
        <font size="1">no part of this package can be distributed without our 
        written expression.</font></font></div>
    </td>
  </tr>
</table>
</BODY>
</HTML>
|;
 &PrintFooter;
exit;
}
############################################################
sub Permissions{
	%TXTDES=(
	"behavior"	=> qq|Ability to change the way the program behaves.|,
	"config"		=> qq|Ability to change system configurations.|,
	"template_email"=> qq|Ability to change email templates.|,
	"template_html" => qq|Ability to change HTML templates.|,

	"account"	=> qq|Ability to add/delete/edit pricing structure.|,
	"admin"		=> qq|Ability to add/delete/edit administrators.|,
	"affiliate"	=> qq|Ability to add/approve/delete/deny/edit/ affiliates.|,
	"database"	=> qq|Ability to add/delete/edit database fields.|,
	"admin_group"=>qq|Ability to add/delete/edit administrative groups.|,
	"member"		=> qq|Ability to add/approve/delete/deny/edit/expire/ etc.. members|,
	"protect"	=> qq|Ability to add/delete/edit protected directory.|,
	"member_group"=>qq|Ability to add/delete/edit membership level|,
	"security"  => qq|Ability to add/delete/edit security features|,

	"ads"			=> qq|Ability to add/delete/edit etc.. ads|,
	"cat"	      => qq|Ability to add/delete/edit categories|,
	"file"		=> qq|Ability to add/delete/edit etc. files|,
	"gateway"	=> qq|Ability to add/delete/edit gateways or credit card processors.|,
	"mail"		=> qq|Ability to (mass) mail members.|,
	"news"		=> qq|Ability to add/delete/edit news.|,
	"story"		=> qq|Ability to add/delete/edit submit stories.|,
	"utils"		=> qq|Ability to execute system utilities such as backup/restore/export/import/, etc.|,
	"upload"		=> qq|Ability to upload files to server.|,
	);
	return %TXTDES;
}
############################################################
1;
