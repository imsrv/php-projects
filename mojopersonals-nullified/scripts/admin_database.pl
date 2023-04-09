############################################################
sub DatabaseMain{
	   if($FORM{class} eq "ad"){		&DatabaseAd;		}
	elsif($FORM{class} eq "member"){	&DatabaseMember;	}
	elsif($FORM{class}){	&PrintError($mj{'error'}, $mj{'confuse'});	}
	&PrintDatabase;
}
############################################################
sub DatabaseAd{
	$CONFIG{database_file} = $CONFIG{ad_fields};
	if($FORM{'action'} eq "add"){				&DatabaseAdd;		}
	elsif($FORM{'action'} eq "delete"){		&DatabaseDelete;	}
	elsif($FORM{'action'} eq "edit"){		&DatabaseEdit;		}
#	elsif($FORM{'action'} eq "arrange"){	&DatabaseArrangeFields;	}
	elsif($FORM{action}){	&PrintError($mj{'error'}, $mj{'confuse'});	}
	&DatabaseDisplay($CONFIG{message});
}
############################################################
sub DatabaseMember{
	$CONFIG{database_file} = $CONFIG{member_fields};
	if($FORM{'action'} eq "add"){				&DatabaseAdd;		}
	elsif($FORM{'action'} eq "delete"){		&DatabaseDelete;	}
	elsif($FORM{'action'} eq "edit"){		&DatabaseEdit;		}
#	elsif($FORM{'action'} eq "arrange"){	&DatabaseArrangeFields;	}
	elsif($FORM{action}){	&PrintError($mj{'error'}, $mj{'confuse'});	}
	&DatabaseDisplay($CONFIG{message});
}
############################################################
sub DatabaseAdd{
	my($message);
	
	if($FORM{'cancel'}){		$CONFIG{message} = $mj{'cancel'};	}
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("database", "add");
		$FORM{'type'} = $FORM{'db_type'};
		$message = &CheckDatabaseAddInput;
		&PrintDatabaseAdd($message) if $message;
		&AddFieldDB($CONFIG{database_file}, \%FORM);
		$CONFIG{message} = $mj{success};
	}
	else{	&PrintDatabaseAdd;}
}
################################################################
sub DatabaseDelete{
	my($message);
	
	if($FORM{'cancel'}){			$CONFIG{message} = $mj{'cancel'};	}
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("database", "delete");
		&DeleteFieldDB($CONFIG{database_file}, $FORM{ID});
		$CONFIG{message} = $mj{success};
	}
	else{	&PrintDatabaseDelete;}
}
################################################################
sub DatabaseEdit{
	my($message);
	
	if($FORM{'cancel'}){		$CONFIG{message} = $mj{'cancel'};	}
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("database", "edit");
		$FORM{'type'} = $FORM{'db_type'};
		$message = &CheckDatabaseEditInput;
		&PrintDatabaseEdit($message) if $message;
		&UpdateFieldDB($CONFIG{database_file}, \%FORM);
		$CONFIG{message} = $mj{success};
	}
	else{	&PrintDatabaseEdit;}
}
################################################################
sub DatabaseDisplay{
	my($counts, %DB, $html, @lines, $message);
	($message) = @_;
	@lines = &FileRead($CONFIG{database_file});
	foreach (@lines){
		%DB = &RetrieveFieldDB($_);
		next unless ($DB{ID} and $DB{name});
		$DB{require} = $DB{require}?Yes:No;
		$DB{active} = $DB{active}?Yes:No;
		$DB{message} = substr($DB{message}, 0, 45);
		$html .= qq|<tr><td><a href="$CONFIG{admin_url}?account=$FORM{'account'}&type=database&class=$FORM{class}&action=edit&ID=$DB{ID}"><NOBR>$DB{name}</NOBR></a></td>
			<td>$DB{message}</td>
			<td>$DB{active}/$DB{require}</td>
			<td><a href="$CONFIG{admin_url}?account=$FORM{'account'}&type=database&class=$FORM{class}&action=edit&ID=$DB{ID}">$TXT{edit}</a></td>
			</tr>|;
	}
	&PrintDatabaseDisplay($html, $message);
}
################################################################
sub CheckDatabaseAddInput{
	sub CDB{ return 1 if ($_[0]=~ /^[\w\d\-\_]+$/ ); return 0;}
	sub CDB2{ return 1 if($_[0]=~ /^[\w\d\-\_\,\'\.\s\?\(\)]+$/); return 0;}
	sub CDB3{ return 1 if($_[0]=~ /^[\d]+$/); return 0;}
	sub CDB4{ return 0 if($_[0]=~ /\|/); return 1;}
	my ($message);
	$message .= "<li>Missing Field ID, or it contains invalid characters</li>" unless ($FORM{ID} && &CDB($FORM{ID}));
	$message .= "<li>Missing Field Name, or it contains invalid characters</li>" unless ($FORM{'name'} && &CDB2($FORM{'name'}));
	$message .= "<li>Missing Error Message, or it contains invalid characters</li>" unless ($FORM{message} && &CDB2($FORM{message}));
	
	$message .= "<li>Missing Field Type</li>" unless ($FORM{'type'});
	#	$message .= "<li>Missing Field Options</li>" unless ($FORM{'options'} && ($FORM{'type'} eq "radio"));
	if($FORM{'type'} =~ /radio|select|checkbox_group/){
		if($FORM{choices}){		}
		else{
			$message .="<li>If input type is checkbox group, radio, or menu, you have to specify options to select from";
		}
	}
	else{
		if($FORM{size}){	$message .="<li>Size contains invalid characters" unless ($FORM{'size'} =~ /^[\d\w]+$/ );	}
		else{					$FORM{'size'} = 40;	}
		if($FORM{max}){	$message .="<li>Max Size contains invalid characters" unless ($FORM{max} =~ /^[\d\w]+$/ );	}
		else{					$FORM{max} = 150;		}
	}
	$message .="<li>Default Value contains database used characters" unless (&CDB4($FORM{'default'}));
	if($FORM{'type'} eq "textbox" or $FORM{'type'} eq "textarea"){
		$message .= "<li>Missing Value Type</li>" unless ($FORM{'input_type'});
	}
		return $message;
}
############################################################
sub CheckDatabaseEditInput{
	return &CheckDatabaseAddInput;
}

############################################################
sub PrintDatabase{
	my(%HTML, $message, @label, %LABEL);
	($message) = @_;
	@label = ("ad", "member");
	%LABEL = ("ad"=>"Ad database", "member"=>"Member Database");
	$HTML{database} = $Cgi->popup_menu("class", \@label, $FORM{class}, \%LABEL);
	&PrintMojoHeader;
	print qq|
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="178"> <br>
      <br>
      <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
        <tr> 
          <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{database1}</font></b></font></td>
        </tr>
        <tr> 
          <td class="titlebg" bgcolor="#EEEEEE" height="4"> 
            <div align="center"><b><font color="#FF0000">$message</font></b></div>
          </td>
        </tr>
        <tr> 
          <td class="windowbg" bgcolor="#EEEEEE" height="41"> 
            <li>Please select a database to edit<br>
              <form name="mojo" method="post" action="$CONFIG{admin_url}">
                <input type="hidden" name="type" value="database">
                <input type="submit" name="load" value="$TXT{edit}">
                $HTML{database} 
              </form>
            </li>
          </td>
        </tr>
        <tr> 
          <td bgcolor="#EBEBEB" height="2"> 
            <div align="center"> </div>
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
sub PrintDatabaseDisplay{
	my($html, $message) = @_;
	&PrintMojoHeader;
	print qq|
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="178"> <br>
      <br>
      <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
        <tr> 
          <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{database1}</font></b></font></td>
        </tr>
        <tr> 
          <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
            <div align="center"><b><font color="#FF0000">$message</font></b></div>
          </td>
        </tr>
        <tr>
          <td class="titlebg" bgcolor="#EEEEEE" height="2">
            <table width="103%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#CCCCCC">
              <tr bgcolor="#EBEBEB"> 
                <td width="61"><b><font size="2">Name</font></b></td>
                <td width="332"><b><font size="2">Error Message</font></b></td>
                <td width="90"><b><font size="2">Active/Required</font></b></td>
                <td width="98"><b><font size="2">Actions</font></b></td>
              </tr>
              $html 
            </table>
          </td>
        </tr>
        <tr> 
          <td bgcolor="#EBEBEB" height="2"> 
            <div align="center"> </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
################################################################



















############################################################
sub PrintDatabaseAdd{		&PrintDatabaseMiddle(@_);			}
############################################################
sub PrintDatabaseEdit{		&PrintDatabaseMiddle(@_);			}
############################################################
sub PrintDatabaseMiddle{
	my(%DB, $hidden, %HTML, $line, @lines, %LABEL, @label);
	($message) = @_;
	
	%DB = &RetrieveFieldDBByID($CONFIG{database_file}, $FORM{ID});
	foreach (keys %DB){		$FORM{$_} = $DB{$_};		}
	@label2=('text','textarea', 'hidden','radio', 'checkbox', 'menu');
	@label3=('alpha','char', 'digit', 'any');
	
	%LABEL = ("Yes"=>"Yes", "0"=>"No");
	%LABEL2 = ('text'=>'Text Field',	'textarea'=>'Text Area',	'password'=>'Password',
			'radio'=>'Radio Button(s)',	'checkbox'=>'Checkbox(es)',	'menu'=>'Select menu');
	%LABEL3 = ('alpha'=>'Numbers And Characters', 'char'=>'Characters',
				'digit'=>'Numbers','date'=>'Time And Date',	'any'=>'Mixed Input');
	$HTML{type} = $Cgi->popup_menu("db_type", \@label2, $FORM{'type'}, \%LABEL2);
	$HTML{input_type} = $Cgi->popup_menu("input_type", \@label3, $FORM{'type'}, \%LABEL3);
	$HTML{active} = $Cgi->radio_group("active", ['Yes','0'], $FORM{'active'}, 0, \%LABEL);
	$HTML{require} = $Cgi->radio_group("require", ['Yes','0'], $FORM{'require'}, 0, \%LABEL);
	
	if($FORM{action} eq "edit"){
		$HTML{ID} = qq|<b>$FORM{ID}</b>|;
		$hidden = qq|<input type="hidden" name="ID" value="$FORM{ID}">|;
	}
	else{
		$HTML{ID} = qq| <input name="ID" size=35 value="$FORM{ID}">|;
		$hidden =qq||;
	}

	&PrintMojoHeader;
	print qq|
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="302"> <br>
      <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="database">
		  <input type="hidden" name="class" value="$FORM{class}">
		  <input type="hidden" name="action" value="$FORM{action}">
        $hidden 
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{database1}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="475"> 
              <table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#CCCCCC">
                <tr> 
                  <td colspan="2"> 
                    <div align="center"><b>$FORM{name}</b></div>
                  </td>
                </tr>
                <tr> 
                  <td width="193" valign="top" height="24"><b><font size="2" color="red">Internal 
                    ID</font></b></td>
                  <td width="307" height="24"><b>$HTML{ID}</b></td>
                </tr>
                <tr> 
                  <td width="193" valign="top"><font color="#FF0000"><b>Name</b></font></td>
                  <td width="307"> 
                    <input type="text" name="name" size="50" value="$FORM{name}">
                  </td>
                </tr>
                <tr> 
                  <td width="193" valign="top"><b><font size="2" color="red">Error 
                    Message</font></b></td>
                  <td width="307"> 
                    <input type="text" name="message" size="50" value="$FORM{message}" maxlength="250">
                  </td>
                </tr>
                <tr> 
                  <td width=193 valign="top"><b><font size="2" color="red">Field 
                    Type</font></b></td>
                  <td width="307"> $HTML{type}</td>
                </tr>
                <tr> 
                  <td width=193 height="2" valign="top"><b><font size="2" face="Arial, Helvetica, sans-serif">Select 
                    Options</font></b></td>
                  <td height="2" width="307"> 
                    <textarea name="choices" cols="50" rows="2" wrap="VIRTUAL">$FORM{choices}</textarea>
                    <br>
                    <font size="2">If you choose radio button, checkbox, or menu 
                    as a field type, enter the options here, separated by a semicolon ";".</font></td>
                </tr>
                <tr> 
                  <td width=193 valign="top"><b><font face="Arial, Helvetica, sans-serif" size="2" color="#FF0000">Input 
                    Value Type </font></b></td>
                  <td width="307"> $HTML{input_type}</td>
                </tr>
                <tr> 
                  <td width=193 valign="top"><b><font face="Arial, Helvetica, sans-serif" size="2">Extra 
                    characters expected?</font></b></td>
                  <td width="307"> 
                    <input type="text" name="input_char" size="35" value="$FORM{'input_char'}">
                  </td>
                </tr>
                <tr> 
                  <td width=193 height="4" valign="top"><b><font face="Arial, Helvetica, sans-serif" size="2">Size 
                    (rows)</font></b></td>
                  <td width="307" height="4"> 
                    <input type="text" name="size" size="50" value="$FORM{size}">
                  </td>
                </tr>
                <tr> 
                  <td width=193 valign="top" height="2"><b><font face="Arial, Helvetica, sans-serif" size="2">Max 
                    Size (columns)</font></b></td>
                  <td width="307" height="2"> 
                    <input type="text" name="max" size="50" value="$FORM{max}">
					<br><font size="2">If your field type is radio button or checkbox, set this field to 'true' to put line breaks between the items, creating a vertical list. 
                  </td>
                </tr>
                <tr> 
                  <td width=193 valign="top" height="13"><b><font face="Arial, Helvetica, sans-serif" size="2">Default 
                    Value</font></b></td>
                  <td width="307" height="13"> 
                    <input type="text" name="default" size="50" value="$FORM{default}">
                  </td>
                </tr>
                <tr> 
                  <td width=193 valign="top"><b><font size="2" face="Arial, Helvetica, sans-serif" color="red">Active</font></b></td>
                  <td width="307"><font size=2 face="arial">$HTML{active}</font></td>
                </tr>
                <tr> 
                  <td width=193 valign="top"><b><font size="2" face="Arial, Helvetica, sans-serif" color="red">Required 
                    field</font></b></td>
                  <td width="307"><font size=2 face="arial">$HTML{require}</font></td>
                </tr>
              </table>
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

1;
