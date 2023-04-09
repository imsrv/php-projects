############################################################
sub AdminMain{
	$ADMIN{admin_add} = $ADMIN{admin_delete} = $ADMIN{admin_edit} = $ADMIN{admin};
	if($FORM{'action'} eq "add"){				&AdminAdd;		}	
	elsif ($FORM{'action'} eq "delete"){	&AdminDelete; 	}
	elsif($FORM{'action'} eq "edit" ){		&AdminEdit;		}
	elsif ($FORM{'action'}){ 		&PrintError($mj{'error'}, $mj{'confuse'});		}
	&AdminDisplay;
}
#################################################################
sub AdminAdd{
	my($message, %MEM);
	
	if($FORM{'cancel'}){	$message = $mj{'cancel'};	}
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("admin", "add");
		$message = &CheckAdminAddInput;
		&PrintAdminAdd($message) if $message;
		&AddAdminDB(\%FORM);
		$message = $mj{'success'};
	}
	else{		&PrintAdminAdd;	}
	&AdminDisplay($message);
}
#################################################################
sub AdminDelete{
	my($message);
	
	if($FORM{'cancel'}){	$message = $mj{'cancel'};	}
	elsif($FORM{step} eq "final"){
		&CheckAdminPermission("admin", "delete");
		&DeleteAdminDB(\%FORM);
		$message = $mj{'success'};
	}
	&AdminDisplay($message);
}
#################################################################
sub AdminEdit{
	my($message);
	
	if($FORM{'cancel'}){			$message = $mj{'cancel'};	}
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("admin", "delete");
		$message = &CheckAdminEditInput;
		&PrintAdminEdit($message) if $message;
		&UpdateAdminDB(\%FORM);
		$message = $mj{'success'};
	}
	else{	&PrintAdminEdit;	}
	&AdminDisplay($message);
}
#################################################################
sub AdminDisplay{
	my(%DB, $html, $line, @lines,$message);
	($message) = @_;
	unless(-f $CONFIG{admin_db}){		&FileWrite($CONFIG{admin_db}, "admin|admin|");	}
	@lines	= &FileRead($CONFIG{admin_db});
	foreach $line(@lines){
		%DB = &RetrieveAdminDB($line);
		next unless $DB{username};
		$html .= qq|<tr>
				<td><a href="$CONFIG{admin_url}?type=member&action=edit&username=$DB{username}">$DB{username}</a></td>																			
				<td><a href="$CONFIG{admin_url}?type=group&action=edit&group=$DB{group}">$DB{group}</a></td>
				<td><a href="$CONFIG{admin_url}?type=admin&action=edit&username=$DB{username}"> $TXT{'edit'}</a>
				\|  <a href="$CONFIG{admin_url}?type=admin&action=delete&username=$DB{username}&step=final">$TXT{remove}</a></td>
				</tr> |;
	}
	&PrintAdminDisplay($html, $message);
}
#################################################################
sub BuildAdminGroupMenu{
	my(@content, %DB, $group, @lines);
	($group) = @_;
	@lines = &FileRead($CONFIG{group_db});
 	foreach (@lines){
		%DB = &RetrieveGroupDB($_);
		next unless $DB{group};
		push(@content, $DB{group});
	}
	return  $Cgi->popup_menu("group", \@content, $group?$group:$FORM{group});
}
#################################################################
sub CheckAdminAddInput{
	my (%DB, @lines, $message);
	$message = &CheckAdminEditInput(@_);
	@lines = &FileRead($CONFIG{admin_db}) if (-f $CONFIG{admin_db});
	foreach (@lines){
		%DB = &RetrieveAdminDB($_);
		$message .=qq|<li>$mj{mem57}</li>| if ($DB{username} eq $FORM{username});
	}
	return $message;
}
#################################################################
sub CheckAdminEditInput{
	my ($mem, %MEM, $message);
	$mem = &isMemberExist($FORM{username});
	return qq|<li>$mj{mem1}</li>| unless $FORM{username};
	return qq|<li>$mj{mem2}</li>| unless $mem;
	%MEM = %$mem;
	return qq|<li>$mj{mem5}</li>| if $MEM{status} eq "pending";
	return qq|<li>$mj{mem6}</li>| if $MEM{status} eq "expire";
	return qq|<li>$mj{mem8}</li>| if $MEM{status} eq "suspend";
	return "";
}
#################################################################
sub PrintAdminAdd{
	my($message, $html);
	($message) = @_;
	$html = &BuildAdminGroupMenu;
	&PrintMojoHeader;
	print qq|
	<table  cellpadding="5" cellspacing="0" width="100%" align="center">
  <tr> 
    <td width="100%" valign="top" align="center" height="164"> 
      <form name="form1" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="admin">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="step" value="final">
        <table  cellpadding="3" cellspacing="0" width="500" align="center" border="1" bordercolor="#DDDDDD" bgcolor="#FFFFFF">
          <tr> 
            <td colspan="2"> 
              <div align="center"><font size="5">$mj{admin11}</font><font size="4"></font></div>
              <div align="center"><b><font color="#FF0000">$message </font></b> 
              </div>
            </td>
          </tr>
          <tr> 
            <td width="32%" valign="top" align="center"> 
              <div align="right"><font face="Arial, Helvetica, sans-serif"><b>$TXT{'username'}</b></font></div>
            </td>
            <td width="68%" valign="top" align="center"> 
              <div align="left"> 
                <input type="text" name="username" value="$FORM{username}">
              </div>
            </td>
          </tr>
          <tr> 
            <td width="32%" valign="top" align="center" height="15"> 
              <div align="right"><font face="Arial, Helvetica, sans-serif"><b>$TXT{'group'}</b></font></div>
            </td>
            <td width="68%" valign="top" align="center" height="15"> 
              <div align="left"> $html</div>
            </td>
          </tr>
          <tr> 
            <td colspan="2" valign="top" align="center" height="2"> 
              <input type="submit" name="add" value=" $TXT{save}">
              <input type="reset" name="cancel" value=" $TXT{'reset'} ">
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
#################################################################
sub PrintAdminEdit{
	my(%DB, $message, $html);
	($message) = @_;
	%DB = &RetrieveAdminDB($FORM{'username'});
	$html = &BuildAdminGroupMenu($DB{group});
	&PrintMojoHeader;
	print qq|
	<table  cellpadding="5" cellspacing="0" width="100%" align="center">
  <tr> 
    <td width="100%" valign="top" align="center" height="164"> 
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="admin">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="username" value="$FORM{username}">
        <input type="hidden" name="step" value="final">
        <table  cellpadding="3" cellspacing="0" width="500" align="center" border="1" bordercolor="#DDDDDD" bgcolor="#FFFFFF">
          <tr> 
            <td colspan="2" height="31"> 
              <div align="center"><font size="5">$TXT{edit}</font><font size="4"><br>
                </font></div>
              <div align="center"><b><font color="#FF0000">$message </font></b> 
              </div>
            </td>
          </tr>
          <tr> 
            <td width="39%" valign="top" align="center"> 
              <div align="right"><font face="Arial, Helvetica, sans-serif"><b>$TXT{'username'}</b></font></div>
            </td>
            <td width="61%" valign="top" align="center"> 
              <div align="left"> <b>$FORM{username}</b></div>
            </td>
          </tr>
          <tr> 
            <td width="39%" valign="top" align="center" height="15"> 
              <div align="right"><font face="Arial, Helvetica, sans-serif"><b>$TXT{'group'}</b></font></div>
            </td>
            <td width="61%" valign="top" align="center" height="15"> 
              <div align="left"> $html</div>
            </td>
          </tr>
          <tr> 
            <td colspan="2" valign="top" align="center" height="2"> 
              <input type="submit" name="add" value=" $TXT{save}">
              <input type="submit" name="cancel" value=" $TXT{cancel} ">
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
#################################################################
sub PrintAdminDisplay{
	my ($html, $message) = @_;
	&PrintMojoHeader;
	print qq|

<table border="1" cellpadding="5" cellspacing="0" width="100%" align="center" bordercolor="#DDDDDD">
  <tr> 
    <td height="24" colspan="3"> 
      <div align="center"><font size="5">$mj{'admin8'}</font><font size="4"><font size="2"><br>
        $mj{'admin9'}<br>
        <font color="#FF00FF"><b><font size="3">$message </font></b></font></font></font></div>
    </td>
  </tr>
  <tr> 
    <td height="25" colspan="3">
      <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr bgcolor="#EBEBEB"> 
          <td><b>Username</b></td>
          <td><b>Group</b></td>
          <td><b>Actions</b></td>
        </tr>
        $html 
      </table>
    </td>
  </tr>
  <tr> 
    <td valign="top" align="center" colspan="3"> 
      <form  method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="account" value="$FORM{'account'}">
        <input type="hidden" name="type" value="admin">
        <input type="hidden" name="class" value="admin">
        <input type="hidden" name="action" value="add">
        <input type="submit" name="add" value=" $mj{'admin11'} ">
      </form>
    </td>
  </tr>
</table>
	|;
&PrintMojoFooter;
}
############################################################
1;