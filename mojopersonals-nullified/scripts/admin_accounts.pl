############################################################
sub AccountMain{
	$CONFIG{message} = "";
	if($FORM{action} eq "add"){				&AccountAdd;			}
	elsif($FORM{action} eq "delete"){		&AccountDelete;		}
	elsif($FORM{action} eq "edit"){			&AccountEdit;			}
	elsif($FORM{action} eq "default"){		&AccountDefault;		}
	elsif($FORM{action} eq "permission"){	&AccountPermission;	}
	&DisplayAccount($message);
}
############################################################
sub DisplayAccount{
	my(%ACCOUNT, $cc,$default, $dir, @dirs, $html, $name,$edit,$delete,$make_default);
	@dirs = &Subdirectories($CONFIG{account_path});
	unless($CONFIG{default_account} and -d "$CONFIG{account_path}/$CONFIG{default_account}"){	&SetDefaultAccount;	}
	
	foreach $dir (@dirs){
		%ACCOUNT = &RetrieveAccountDB("$dir/account.pl");
		next unless ($ACCOUNT{ID});
		$cc = &GatewayDisplay($ACCOUNT{ID}, 1);
		unless($cc){	$cc = qq|<font size=2>No credit card module available</font>|;	}
		$default = ($ACCOUNT{ID} eq $CONFIG{default_account})?qq|(default)|:"";
		if ($ACCOUNT{ID} eq 'guest') {$edit="<font size=2>Edit</font>";}
		else {$edit=qq|<a href="$CONFIG{admin_url}?type=account&action=edit&ID=$ACCOUNT{ID}"><font size=2>Edit</font></a>|;}
		if (($ACCOUNT{ID} eq 'guest') or ($ACCOUNT{ID} eq $CONFIG{default_account})) {
			$delete="<font size=2>Delete</font>";
			$make_default="<font size=2>Make default</font>";
		}
		else {
			$delete=qq|<a href="$CONFIG{admin_url}?type=account&action=delete&ID=$ACCOUNT{ID}"><font size=2>Delete</font></a>|;
			$make_default=qq|<a href="$CONFIG{admin_url}?default_account=$ACCOUNT{ID}&type=account&action=default"><font size=2>Make default</font></a>|;
		}

		$html .= qq|<tr>
    		<td><a href="$CONFIG{admin_url}?account=$ACCOUNT{ID}&type=member">$ACCOUNT{name}</a>$default</td>
    		<td>\$$ACCOUNT{recurring_amount}</td>
	 		<td>$cc</td>
    		<td>$edit \| $delete \| $make_default \|
			<a href="$CONFIG{admin_url}?type=account&action=permission&ID=$ACCOUNT{ID}"><font size=2>Permissions</font></a>
  			</tr>
		|;
	}
	unless ($html) { $html =qq|<tr><td colspan=4 align=center><br />No accounts available<br /><br /></td></tr>|;	}
	&PrintDisplayAccount($html, $message);
}
############################################################
sub AccountAdd{
	my($mesasge);
	
	if($FORM{'cancel'}){ 	$CONFIG{message} = $mj{'cancel'}; }
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("account", "add");
		$message = &CheckAccountAddInput;
		&PrintAccountAdd($message) if $message;
        unless(-d "$CONFIG{account_path}/$FORM{ID}"){
            mkdir("$CONFIG{account_path}/$FORM{ID}", 0777);
            chmod(0777, "$CONFIG{account_path}/$FORM{ID}");
        }
        &AddAccountDB(\%FORM);
		&PrintAccountPermission($mj{success});;
	}
	else{	&PrintAccountAdd;	}
}
############################################################
sub AccountDelete{
	my($message);
	
	if($FORM{'cancel'}){ 	$CONFIG{message} = $mj{'cancel'}; }
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("account", "delete");
		&DeleteAccountDB(\%FORM);
		$CONFIG{message} = $mj{success};	
	}
	else{	&PrintAccountDelete;	}
}
############################################################
sub AccountEdit{
	my($message);
	
	if($FORM{'cancel'}){ 	$CONFIG{message} = $mj{'cancel'}; }
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("account", "delete");
		$message = &CheckAccountEditInput;
		&PrintAccountEdit($message) if $message;
		&UpdateAccountDB(\%FORM);
		$CONFIG{message} = $mj{success};
	}
	else{	&PrintAccountEdit;		}
}
############################################################
sub AccountPermission{
    my($message,@fields,$subm);
    $subm=$Cgi->param('edit');
    if($FORM{step} eq "final" and $subm){
		&CheckAdminPermission("account", "permission");
    	require "$CONFIG{program_files_path}/membership.txt";
		&AccountDef;
		if ($FORM{ID} eq 'guest') {
			  @fields = ("ad_browse","ad_search","ad_search_advanced","ad_view",
	          "photo_view","photo_gallery","cupid_search",
		      "member_search","member_search_advanced","member_view");
		}
		else {@fields=@order;}
		foreach $db (@fields){
           $FORM{$db}='' unless (($db =~ /ad_allowed|media_allowed|mailbox_size/) or $FORM{$db});
        }
        &UpdateAccountDB(\%FORM);
	}
	else{		&PrintAccountPermission;	}
}
############################################################
sub AccountDefault{
		&CheckAdminPermission("account", "default");
		require "admin_setup.pl";
		&LoadConfigFile;
		$CONFIG{default_account} = $FORM{default_account};
		&WriteConfig;
}
############################################################
sub SetDefaultAccount{
	my @dirs = &Subdirectories($CONFIG{account_path}, 1);
	require "admin_setup.pl";
	&LoadConfigFile;
	if ($dirs[0]=~/guest$/) {$CONFIG{default_account} = $dirs[1];} else {$CONFIG{default_account} = $dirs[0];}
	&WriteConfig;
}
############################################################
sub CheckAccountAddInput{
	my $message = &CheckAccountEditInput;
	$message .= qq|<li>The account ID you have entered already exist</li>| if (-d "$CONFIG{account_path}/$FORM{ID}");
	return $message;
}
############################################################
sub CheckAccountEditInput{
	my($message);
	$message .= qq|<li>Invalid account ID entered</li>| unless ($FORM{ID} =~ /^[0-9a-zA-Z\_\-]+$/);
	$message .= qq|<li>The trial amount is invalid. Should be xx.xx. No $ sign</li>| if($FORM{trial_amount} =~ /\$/ or $FORM{trial_amount} !~ /\./);
	$message .= qq|<li>The recurring amount is invalid. Should be xx.xx. No $ sign</li>| if($FORM{recurring_amount} =~ /\$/ or $FORM{recurring_amount} !~ /\./);
	$message .= qq|<li>Missing account description</li>| unless ($FORM{description});
	
	if($FORM{email}){
		$message .= qq|<li>The notification email is invalid| unless (&GoodEmail($FORM{email}));
	}

	if($FORM{protected}){
		unless(-d "$FORM{protected}"){
			if(mkpath($FORM{protected}, 0, 0777)){
				chmod(0777, $FORM{protected});
				$CONFIG{message} = "The directory you want to protect does not exist, and has been created";
			}
			else{
				&PrintError($mj{error}, "The directory you want to protect does not exist<br>$FORM{protected}, and cannot be created.");
			}
		}
		unless (&isWritable($FORM{protected})){
			$message .= qq|<li>The protected directory is not writeable. Please chmod to 0777</li>|;
		}
	}
	
	$FORM{setup_finished}=  qq|powered by mojoscripts.com|;
	$FORM{trial_length}=    &DetermineAccountLength($FORM{trial_time}, $FORM{trial_period});
	$FORM{recurring_length}=&DetermineAccountLength($FORM{recurring_time}, $FORM{recurring_period});
	return $message;
}
############################################################
sub DetermineAccountLength{
	my ($length, $multiplier, $period, $notation);
	($notation, $period) = @_;
	if($notation eq "Min"){		$multiplier = 60;			}
	elsif($notation eq "H"){	$multiplier = 3600;		}
	elsif($notation eq "D"){	$multiplier = 86400;		}
	elsif($notation eq "W"){	$multiplier = 604800;	}
	elsif($notation eq "M"){	$multiplier = 2592000;	}
	elsif($notation eq "Y"){	$multiplier = 31536000;	}
	else{								$multiplier = 604800;	}
	if($period eq "unlimited"){$length = 2**32-2;	}
	else{								$length = $period * $multiplier;	}
	return $length;
}
############################################################
sub PrintDisplayAccount{
	my($html, $message,$add) = @_;
	if ($CONFIG{paysite}) {
		$add=qq|<tr> 
      <td colspan="4"> 
        <div align="center"><a href="$CONFIG{admin_url}?type=account&action=add">Add new 
          account</a></div>
      </td>
      </tr>|;
	}
	&PrintMojoHeader;
	print qq|
<div align=center>
  <table width="95%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="4"> 
        <div align="center"><font size="5"><b>Accounting Manager<br>
          </b></font><font color="#FF0000"><b>$message </b></font></div>
      </td>
    </tr>
    <tr> 
      <td width="20%"><b>Account Name</b></td>
      <td width="15%"><b>Prices</b></td>
      <td width="29%"><b>Currently Working With</b></td>
      <td width="33%"><b>Action</b></td>
    </tr>
    $html 
    $add
  </table>
	</div>
	|;
	&PrintMojoFooter;
}
############################################################
sub PrintAccountAdd{		&PrintAccountFields(@_);	}
############################################################
sub PrintAccountDelete{
	my %ACCOUNT = &RetrieveAccountDB($FORM{ID});
	my ($message) = @_;
	my $html =qq|All members that belong to this account will lose their former privileges|;
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="172">
  <tr> 
    <td height="18"> 
      <div align="center"><font size="5"><b>Delete Account: $ACCOUNT{ID}<br>
        </b></font><b>$ACCOUNT{description} </b><font size="5"><b><br>
        </b></font><font color="#FF0000"><b>$message </b></font></div>
    </td>
  </tr>
  <tr> 
    <td height="46"> 
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <div align="center">
          <input type="hidden" name="type" value="account">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="ID" value="$FORM{ID}">
          <input type="hidden" name="step" value="final">
          <br>
          <font color="#FF0000">$mj{confirm}<br>
          <b>$html<br>
          <input type="submit" name="yes" value="$TXT{yes}">
          <input type="submit" name="cancel" value="$TXT{no}">
          </b></font></div>
      </form>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
############################################################
#sub PrintAccountDefault{
#	my @dirs = &Subdirectories($CONFIG{account_path}, 1);
#	for (my $i=0; $i<@dirs; $i++) {if (@dirs[$i] eq 'guest') {splice(@dirs,$i,1); last;}}
#	my $html = $Cgi->popup_menu("default_account", \@dirs, $CONFIG{default_account});
#	&PrintMojoHeader;
#	print qq|
#<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
#  <tr>
#    <td bgcolor="#EBEBEB">
#      <div align="center"><b>Set Default Account</b></div>
#    </td>
#  </tr>
#  <tr>
#    <td>
#      <form name="mojo" method="post" action="$CONFIG{admin_url}">
#        <input type="hidden" name="type" value="account">
#        <input type="hidden" name="action" value="default">
#        <input type="hidden" name="step" value="final">
#        <table width="100%" border="0" cellspacing="0" cellpadding="0">
#          <tr> 
#            <td>Select the default account </td>
#          </tr>
#          <tr> 
#            <td> 
#              <div align="center">$html</div>
#            </td>
#          </tr>
#          <tr>
#            <td> 
#              <div align="center">
#                <input type="submit" name="Submit" value="Submit">
#              </div>
#            </td>
#          </tr>
#        </table>
#      </form>
#    </td>
#  </tr>
#</table>
#	|;
#	&PrintMojoFooter;
#}
############################################################
sub PrintAccountEdit{
	my %ACCOUNT = &RetrieveAccountDB($FORM{ID});
	foreach (keys %ACCOUNT){	$FORM{$_} = $ACCOUNT{$_} unless $FORM{$_};	}
	&PrintAccountFields(@_);
}
############################################################
sub PrintAccountFields{
	my ($message) = @_;
	my(@label, @label2, @label3,@label4, %LABEL, %HTML);
	@label2 = ("sendmail","instant", "pending");
	@label3 = ("", "clickbank", "ibill", "paypal");
	@label4 = ("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20", "21","22","23","24","25","26","27","28","29","30", "unlimited");
	@label5 = ("D","W","M","Y");
	%LABEL5 = ("D"=>"Days", "W"=>"Weeks","M"=>"Months","Y"=>"Years");

	$HTML{activation}=  $Cgi->popup_menu("activation", \@label2, $FORM{activation});
	$HTML{protected}=   $Cgi->textfield("protected", $FORM{'protected'}, 65,200);
	$HTML{email}=       $Cgi->textfield("email", $FORM{'email'}, 35, 100);
	$HTML{gateway}=     $Cgi->popup_menu("gateway", \@label3, $FORM{'gateway'});
	
	if($FORM{action} eq "add"){
		$HTML{ID}=     $Cgi->textfield("ID", $FORM{ID}, 30, 50);
		$HTML{hidden_fields}=qq|<input type="hidden" name="action" value="add">|;
	}
	else{
		$HTML{ID}=         qq|<b>$FORM{ID}</b>|;
		$HTML{hidden_fields}=qq|<input type="hidden" name="action" value="edit">
			<input type="hidden" name="ID" value="$FORM{ID}">
			|;
	}
	$HTML{name}=            $Cgi->textfield("name", $FORM{name}, 30, 50);
	$HTML{description}=     $Cgi->textfield("description", $FORM{'description'}, 50, 150);
	$HTML{display}=         $Cgi->textfield("display", $FORM{display}, 50, 150);
	$HTML{trial_amount}=    $Cgi->textfield("trial_amount", $FORM{trial_amount}, 10, 10);
	$HTML{trial_period}=    $Cgi->popup_menu("trial_period", \@label4, $FORM{trial_period});
	$HTML{trial_time}=      $Cgi->popup_menu("trial_time", \@label5, $FORM{trial_time}, \%LABEL5);
	$HTML{recurring_amount}=$Cgi->textfield("recurring_amount", $FORM{recurring_amount}, 10, 10);
	shift @label4;
	$HTML{recurring_period}=$Cgi->popup_menu("recurring_period", \@label4, $FORM{recurring_period});
	$HTML{recurring_time}=  $Cgi->popup_menu("recurring_time", \@label5, $FORM{recurring_time}, \%LABEL5);
	$HTML{activation}=      $Cgi->popup_menu("activation", \@label2, $FORM{activation});
	$HTML{protected}=       $Cgi->textfield("protected", $FORM{protected}, 60, 150);
	if($FORM{protected}){
		$FORM{protected_url}=  &PathToUrl($FORM{protected}) unless $FORM{protected_url};
	}
	$HTML{protected_url}=   $Cgi->textfield("protected_url", $FORM{protected_url}, 60, 150);
	$HTML{email}=           $Cgi->textfield("email", $FORM{email}, 40, 100);
	$HTML{gateway}=         $Cgi->popup_menu("gateway", \@label3, $FORM{gateway});
	$HTML{recurring}=			$Cgi->checkbox("recurring", $FORM{recurring}, "checked", "yes");
	&PrintMojoHeader;
	print qq|
<i><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <form name="mojo" method="post" action="$admin_url">
        <div align="center">
          <input type="hidden" name="type" value="account">
           $HTML{hidden_fields}
          <input type="hidden" name="step" value="final">
			
          <table  cellpadding="1" cellspacing="0" width="95%" align="center" border=0>
            <tr> 
              <td valign="top" align="center" height="17"> <b>$mj{account} <b><font color="#FF0000"><br>
                $message </font></b> <br>
                </b> 
                <hr width="400" size="1" color="#5B9FBE">
                
                </td>
            </tr>
            <tr> 
              <td valign="top" align="center" height="37"> 
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr bordercolor="#EEEEEE"> 
                    <td valign="top" align="center" colspan="2" height="3"> 
                      <div align="right"></div>
                      <div align="left"><font color="#660066"><b>$mj{account1}<br>
                        </b></font> $mj{account2} </div>
                    </td>
                  </tr>
                  <tr bordercolor="#EEEEEE"> 
                    <td valign="top" align="center" width="234" height="3"> 
                      <div align="right"><b>$mj{account3}&nbsp;&nbsp;</b></div>
                    </td>
                    <td valign="top" align="center" height="3" width="702"> 
                      <div align="left">&nbsp;&nbsp;$HTML{ID}</div>
                    </td>
                  </tr>
                  <tr bordercolor="#EEEEEE"> 
                    <td valign="top" align="center" width="234" height="3"> 
                      <div align="right"><b>$mj{account4}&nbsp;&nbsp;</b></div>
                    </td>
                    <td valign="top" align="center" height="3" width="702"> 
                      <div align="left">&nbsp;&nbsp;$HTML{name}</div>
                    </td>
                  </tr>
                  <tr bordercolor="#EEEEEE"> 
                    <td valign="top" align="center" width="234" height="7"> 
                      <div align="right"><b>$mj{account5}&nbsp;&nbsp;</b></div>
                    </td>
                    <td valign="top" align="center" height="7" width="702"> 
                      <div align="left">&nbsp;&nbsp;$HTML{description}</div>
                    </td>
                  </tr>
                  <!--
                  <tr bordercolor="#EEEEEE">
                    <td valign="top" align="center" width="234" height="7"> 
                      <div align="right"><b>$mj{account7} </b></div>
                    </td>
                    <td valign="top" align="center" height="7" width="702"> 
                      <div align="left">&nbsp;&nbsp;$HTML{display}</div>
                    </td>
                  </tr>-->
                </table>
              </td>
            </tr>
            <tr> 
              <td valign="top" align="center" height="8">
                <hr width="400" size="1" color="#5B9FBE">
              </td>
            </tr>
            <tr> 
              <td valign="top" align="center" height="77"> 
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td colspan="2"><b><font color="#660066">$mj{account10}</font></b><br>
                      $mj{account11} </td>
                  </tr>
                  <tr> 
                    <td width="516"> 
                      <div align="right"><b>$mj{account12} </b></div>
                    </td>
                    <td valign="top" align="center" width="420" bordercolor="#EEEEEE"> 
                      <div align="left"> &nbsp;&nbsp;\$ $HTML{trial_amount}</div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="516"> 
                      <div align="right"><b>$mj{account13} </b></div>
                    </td>
                    <td valign="top" align="center" width="420" bordercolor="#EEEEEE"> 
                      <div align="left"> &nbsp;&nbsp;$HTML{trial_period} $HTML{trial_time} 
                      </div>
                    </td>
                  </tr>
                </table>
                <hr width="400" size="1" color="#5B9FBE">
              </td>
            </tr>
            <tr> 
              <td valign="top" align="center" height="82"> 
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td colspan="2" height="11"><b><font color="#660066">$mj{account15} 
                      </font></b><br>
                      $mj{account16} </td>
                  </tr>
                  <tr> 
                    <td width="524" height="2"> 
                      <div align="right"><b>$mj{account17}&nbsp;&nbsp;</b></div>
                    </td>
                    <td valign="top" align="center" width="412" bordercolor="#EEEEEE" height="2"> 
                      <div align="left"> &nbsp;&nbsp;\$ $HTML{recurring_amount} 
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="524"> 
                      <div align="right"><b>$mj{account19}&nbsp;&nbsp;</b></div>
                    </td>
                    <td valign="top" align="center" width="412" bordercolor="#EEEEEE"> 
                      <div align="left"> &nbsp;&nbsp;$HTML{recurring_period} $HTML{recurring_time} 
                      </div>
                    </td>
                  </tr>
                </table>
                <hr width="400" size="1" color="#5B9FBE">
              </td>
            </tr>
            <!--<tr> 
              <td valign="top" align="center" height="2"> 
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td height="20"><b><font color="#660066">$mj{account20}</font></b>&nbsp;&nbsp; 
                      $HTML{activation} <br>
                      $mj{account21}</td>
                  </tr>
                  <tr> 
                    <td> 
                      <li>$mj{account22}</li>
                      <li> $mj{account23}</li>
                      <li>$mj{account24}</li>
                      <div align="left"> 
                        <hr width="400" size="1" color="#5B9FBE">
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr> 
              <td valign="top" align="center" height="42"> 
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="12%"><font color="#660066"><b>$mj{account25}</b></font>&nbsp;&nbsp;&nbsp;<br>
                    </td>
                    <td width="88%">&nbsp;$HTML{protected}</td>
                  </tr>
                  <tr> 
                    <td colspan="2"> 
                      <div align="right"></div>
                      <div align="left">$mj{account26} </div>
                    </td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>$HTML{protected_url}</td>
                  </tr>
                  <tr> 
                    <td colspan="2">$mj{account28}</td>
                  </tr>
                </table>
                <hr width="400" size="1" color="#5B9FBE">
              </td>
            </tr>-->
            <tr> 
              <td valign="top" align="center" height="50"> 
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td height="9"><b><font color="#660066">$mj{account30}&nbsp;&nbsp;&nbsp;&nbsp;$HTML{member_notify}</font></b></td>
                  </tr>
                  <tr> 
                    <td> 
                      <div align="right"></div>
                      <div align="left">$mj{account31} </div>
                    </td>
                    <td valign="top" align="center" bordercolor="#EEEEEE"> 
                      <div align="left"> $HTML{email} 
                      </div>
                    </td>
                  </tr>
                </table>
                <hr width="400" size="1" color="#5B9FBE">
              </td>
            </tr>
            <tr> 
              <td valign="top" align="center" height="43"> 
                <div align="right">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td height="11"><b><font color="#660066">$mj{account35} 
                        $HTML{gateway}</font></b></td>
                    </tr>
                    <tr> 
                      <td> 
                        <div align="right"></div>
                        <div align="left">$mj{account36} </div>
                      </td>
                    </tr>
                  </table>
                  <hr width="400" size="1" color="#5B9FBE">
                </div>
                </td>
            </tr>
            <tr> 
              <td valign="top" align="center"> 
                <input type="submit" name="Submit" value="Save">
                <input type="reset" name="reset" value="Reset">
              </td>
            </tr>
          </table>
        </div>
      </form>
    </td>
  </tr>
</table></i>
|;
	&PrintMojoFooter;
	exit;
}
############################################################
sub PrintAccountPermission{
	my(%ACCOUNT, @db, %DEF, $html, $message, $selectbox,@fields);
	$message = shift;
	require "$CONFIG{program_files_path}/membership.txt";
	%DEF = &AccountDef;
	%ACCOUNT = &RetrieveAccountDB($FORM{ID});
	foreach (keys %ACCOUNT){	$FORM{$_} = $ACCOUNT{$_} unless $FORM{$_};	}
		if ($FORM{ID} eq 'guest') {
			  @fields = ("ad_browse","ad_search","ad_search_advanced","ad_view",
	          "photo_view","photo_gallery","cupid_search",
		      "member_search","member_search_advanced","member_view");
		}
		else {@fields=@order;}
   	foreach $db (@fields){
        if($db =~ /ad_allowed|media_allowed|mailbox_size/){ $selectbox = $Cgi->textfield($db, $FORM{$db}, 5, 3);    }
		else{		$selectbox = $Cgi->checkbox($db, $FORM{$db}, "checked", "");	}
		$html .= qq|<tr> 
                  <td width="715">$DEF{$db}</td>
                  <td width="100"><font size="1">$selectbox</font></td>
                </tr>
					|;
	}
	
	&PrintMojoHeader;
	print qq|
		<table  cellpadding="5" cellspacing="0" width="100%" align="center">
  <tr> 
    <td width="100%" valign="top" align="center" height="111"> 
      <form name="mojo" method="get" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="account">
        <input type="hidden" name="ID" value="$FORM{ID}">
        <input type="hidden" name="action" value="permission">
        <input type="hidden" name="step" value="final">
        <table  cellpadding="5" cellspacing="0" width="90%" align="center">
          <tr> 
            <td width="100%" valign="top" align="center" height="8"><font color="#000000" size="5"><b><i> 
              Set Membership Permission<br>
              </i></b></font><font color="#000000"><b><font color="#FF0000">$message</font></b></font></td>
          </tr>
          <tr> 
            <td width="100%" valign="top" align="center" height="2"> 
              <table width="100%"  cellspacing="0" cellpadding="2" bordercolor="#EBEBEB" border="1">
                <tr> 
                  <td width="715" bgcolor="#00659C"><b><font size="4" color="#FFFFFF">Membership 
                    Permissions</font></b></td>
                  <td width="100" bgcolor="#00659C"><b><font size="4" color="#FFFFFF">$TXT{yes}</font></b></td>
                </tr>
                $html
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
	exit;
}
############################################################
1;
