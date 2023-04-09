#################################################################
sub GroupMain{
	$ADMIN{group_add} = $ADMIN{group_delete} = $ADMIN{group_edit} = $ADMIN{admin_group};
	if($FORM{'action'} eq "add"){				&GroupAdd;		}	
	elsif ($FORM{'action'} eq "delete"){	&GroupDelete; 	}
	elsif($FORM{'action'} eq "edit" ){		&GroupEdit;		}
	elsif ($FORM{'action'}){ 		&PrintError($mj{'error'}, $mj{'confuse'});		}
	&GroupDisplay;
}
#################################################################
sub GroupAdd{
	my($message);
	
	if($FORM{'cancel'}){		$message = $mj{'cancel'};	}
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("admin_group", "add");
		$message = &CheckGroupAddInput;
		&PrintGroupAdd($message) if $message;
		&AddGroupDB(\%FORM);
		$message = $mj{'success'};
	}
	elsif($FORM{'step'} eq "final"){		&PrintError($mj{'error'}, $mj{'deny'});	}
	else{		&PrintGroupAdd;	}
	&GroupDisplay($message);
}
#################################################################
sub GroupDelete{
	my($message);
	
	if($FORM{'cancel'}){		$message = $mj{'cancel'};	}
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("admin_group", "delete");
		&DeleteGroupDB(\%FORM);
		$message = $mj{'success'};
	}
	elsif($FORM{'step'} eq "final"){		&PrintError($mj{'error'}, $mj{'deny'});	}
	else{		&PrintGroupDelete;	}
	&GroupDisplay($message);
}
#################################################################
sub GroupEdit{
	my($message);
	
	if($FORM{'cancel'}){	$message = $mj{'cancel'};	}
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("admin_group", "edit");
		$message = &CheckGroupEditInput;
		&PrintGroupEdit($message) if $message;
		&UpdateGroupDB(\%FORM);
		$message = $mj{'success'};
	}
	elsif($FORM{'step'} eq "final"){		&PrintError($mj{'error'}, $mj{'deny'});	}
	else{	&PrintGroupEdit;	}
	&GroupDisplay($message);
}
#################################################################
sub GroupDisplay{
	my(%DB, $html, $line, @lines, $message, @tokens);
	$message = shift;
	@lines = &FileRead($CONFIG{group_db});
	foreach $line (@lines){
		%DB = &RetrieveGroupDB($line);
		next unless ($DB{group} and $DB{string});
		$html.=qq|<tr><td>$DB{group}</td>
			<td>$DB{string}</td>
			<td><a href="$CONFIG{admin_url}?type=group&action=delete&group=$DB{group}">$TXT{delete}</a>
			\|  <a href="$CONFIG{admin_url}?type=group&action=edit&group=$DB{group}">$TXT{edit}</a></td></tr>|;
	}
	&PrintGroupDisplay($html, $message);
}
#################################################################
sub CheckGroupAddInput{
	my(%DB, $line, @lines, $message);
	$message = &CheckGroupEditInput;
	@lines = &FileRead($CONFIG{group_db});
	foreach $line(@lines){
      %DB = &RetrieveGroupDB($line);
		if($DB{group} eq $FORM{group}){	$message .= qq|<li>$mj{admin38}</li>|;	last;	}
	}
	$message .=qq|<li>$mj{'invalid_ip'}: $mj{'admin17'}</li>| unless ($FORM{'group'} =~ /^[0-9a-zA-Z]+$/);
	return $message;	
}
sub CheckGroupEditInput{
	return qq|<li>$mj{'admin37'}</li>| unless ($FORM{'group'});
	return "";
}
############################################################
sub PrintGroupDisplay{
	my($html, $message) = @_;
	&PrintMojoHeader;
	print qq|
<table  cellpadding="5" cellspacing="0" width="100%" align="center" border="1" bordercolor="#EBEBEB">
  <tr> 
    <td height="13"> 
      <div align="center"><font size="5">$mj{'admin30'}</font><font size="4"><font size="2"><br>
        <font color="#FF00FF"><b><font size="3" face="Geneva, Arial, Helvetica, san-serif" color="#FF0000">$message 
        </font></b></font></font></font></div>
    </td>
  </tr>
  <tr> 
    <td height="3"> 
      <div align="center">
        <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr bgcolor="EBEBEB"> 
            <td><b>Group names</b></td>
            <td><b>Permissions</b></td>
            <td><b>Actions</b></td>
          </tr>
			 $html
        </table>
        <br>
        <a href="$CONFIG{admin_url}?type=group&action=add&group=newname">$mj{admin32}</a></div>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
############################################################
sub PrintGroupAdd{		&PrintGroupMiddle(@_);			}
############################################################
sub PrintGroupDelete{
	&PrintMojoHeader;
	print qq|
	<table  cellpadding="5" cellspacing="0" width="100%" align="center">
  <tr> 
    <td width="100%" valign="top" align="center" height="113"> 
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="group">
        <input type="hidden" name="group" value="$FORM{'group'}">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="step" value="final">
        <table  cellpadding="5" cellspacing="0" width="500" align="center" border="1" bordercolor="#DDDDDD">
          <tr> 
            <td> 
              <div align="center"><font size="4">$mj{'admin34'}: $FORM{'group'}<br>
                <font color="#0000FF">$message </font></font></div>
            </td>
          </tr>
          <tr> 
            <td valign="top" align="center" height="7"> 
              <div align="center"><b>$mj{'sure'}</b></div>
            </td>
          </tr>
          <tr> 
            <td valign="top" align="center"> 
              <input type="submit" name="delete" value=" $TXT{'yes'} ">
              <input type="submit" name="cancel" value=" $TXT{'no'} ">
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
sub PrintGroupEdit{		&PrintGroupMiddle(@_);			}
############################################################
sub PrintGroupMiddle{
	my(%DB, $html, %HTML, $hidden, $title);
	($message) = @_;
	&Permissions;
	if($FORM{'action'} eq 'add'){
		$html =qq|$mj{'admin36'}: <input type="text" name="group" size="20" maxlength="20" value="$FORM{'group'}">|;
		$hidden =qq|<input type="hidden" name="action" value="add">|;
		$title = $mj{'admin32'};
		@lines = &DefineGroupDB;
		for(my $i=0; $i<@lines; $i++){
			if($i <13){		$DB{$lines[$i]} = 0;	}
			else{				$DB{$lines[$i]} = 1;	}
		}
	}
	else{
	 	$html =qq| <b>$FORM{'group'}</b>|;
		$hidden =qq|<input type="hidden" name="action" value="edit">
						<input type="hidden" name="group" value="$FORM{'group'}">|;	
		$title = qq|$mj{admin35}|;
		%DB = &RetrieveGroupDBByName($FORM{'group'});
	}
	foreach $key (keys %DB){
		if($DB{$key}){		$HTML{$key} =qq|<input type=checkbox name="$key" value="1" checked>|;}
		else{					$HTML{$key} =qq|<input type=checkbox name="$key" value="1">|;}
	}
	&PrintMojoHeader;
	print qq|
	<table  cellpadding="5" cellspacing="0" width="100%" align="center">
  <tr> 
    <td width="100%" valign="top" align="center" height="793"> 
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="group">
        $hidden 
        <input type="hidden" name="step" value="final">
        <table  cellpadding="5" cellspacing="0" width="90%" align="center">
          <tr> 
            <td width="100%" valign="top" align="center" height="30"><font color="#000000" size="5"><b><i> 
              $title<br>
              </i></b></font><font color="#000000">$html</font><font color="#000000" size="5"><b><i><br>
              </i></b></font><font color="#000000"><b><font color="#FF0000">$message 
              </font></b></font></td>
          </tr>
          <tr> 
            <td width="100%" valign="top" align="center" height="608"> 
              <table width="100%"  cellspacing="0" cellpadding="2" bordercolor="#EBEBEB" border="1">
                <tr> 
                  <td width="715" bgcolor="#00659C"><b><font size="4" color="#FFFFFF">Administrative 
                    Permissions</font></b></td>
                  <td width="100" bgcolor="#00659C"><b><font size="4" color="#FFFFFF">$TXT{yes}</font></b></td>
                </tr>
                <tr> 
                  <td width="715">$TXTDES{behavior}</td>
                  <td width="100"><font size="1">$HTML{behavior}</font></td>
                </tr>
                <tr> 
                  <td width="715">$TXTDES{config}</td>
                  <td width="100"><font size="1">$HTML{config}</font></td>
                </tr>
                <tr> 
                  <td width="715">$TXTDES{template_email}</td>
                  <td width="100"><font size="1">$HTML{template_email}</font></td>
                </tr>
                <tr> 
                  <td width="715">$TXTDES{template_html}</td>
                  <td width="100"><font size="1">$HTML{template_html}</font></td>
                </tr>
                <tr> 
                  <td width="715" bgcolor="#EBEBEB">&nbsp;</td>
                  <td width="100" bgcolor="#EFEBEF">&nbsp;</td>
                </tr>
                <tr> 
                  <td width="715">$TXTDES{account}</td>
                  <td width="100"><font size="1">$HTML{account}</font></td>
                </tr>
                <tr> 
                  <td width="715">$TXTDES{admin}</td>
                  <td width="100"><font size="1">$HTML{admin}</font></td>
                </tr><!--
                <tr> 
                  <td width="715">$TXTDES{affiliate}</td>
                  <td width="100"><font size="1">$HTML{affiliate}</font></td>
                </tr>-->
                <tr> 
                  <td width="715">$TXTDES{database}</td>
                  <td width="100"><font size="1">$HTML{database}</font></td>
                </tr>
                <tr> 
                  <td width="715">$TXTDES{admin_group}</td>
                  <td width="100"><font size="1">$HTML{admin_group}</font></td>
                </tr>
                <tr> 
                  <td width="715">$TXTDES{member}</td>
                  <td width="100"><font size="1">$HTML{member}</font></td>
                </tr>
                <tr> 
                  <td width="715">$TXTDES{protector}</td>
                  <td width="100"><font size="1">$HTML{protector}</font></td>
                </tr>
					 <tr> 
                  <td width="715">$TXTDES{security}</td>
                  <td width="100"><font size="1">$HTML{security}</font></td>
                </tr>
                <tr> 
                  <td bgcolor="#EBEBEB" width="715">&nbsp;</td>
                  <td bgcolor="#EFEBEF" width="100">&nbsp;</td>
                </tr>
                <tr> 
                  <td width="715">$TXTDES{ads}</td>
                  <td width="100"><font size="1">$HTML{ads}</font></td>
                </tr>
                <tr> 
                  <td width="715">$TXTDES{cat}</td>
                  <td width="100"><font size="1">$HTML{cat}</font></td>
                </tr><!--
                <tr> 
                  <td height="10" width="715">$TXTDES{file}</td>
                  <td height="10" width="100"><font size="1">$HTML{file}</font></td>
                </tr>-->
                <tr> 
                  <td width="715">$TXTDES{gateway}</td>
                  <td width="100"><font size="1">$HTML{gateway}</font></td>
                </tr>
                <tr> 
                  <td height="32" width="715">$TXTDES{mail}</td>
                  <td height="32" width="100"><font size="1">$HTML{mail}</font></td>
                </tr><!--
                <tr> 
                  <td width="715" >$TXTDES{story}</td>
                  <td width="100" ><font size="1">$HTML{story}</font></td>
                </tr>-->
                <tr> 
                  <td width="715" >$TXTDES{utils}</td>
                  <td width="100" ><font size="1">$HTML{utils}</font></td>
                </tr><!--
                <tr> 
                  <td width="715" >$TXTDES{upload}</td>
                  <td width="100" ><font size="1">$HTML{upload}</font></td>
                </tr>-->
                <tr> 
                  <td width="715" bgcolor="#EBEBEB">&nbsp;</td>
                  <td width="100" bgcolor="#EFEBEF">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td width="100%" valign="top" align="center" height="2"> 
              <input type="submit" name="edit" value="$TXT{'save'}">
              <input type="submit" name="cancel" value="$TXT{cancel}">
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
1;