###########################################################
# package members
############################################################
sub MemberMain{
	   if($FORM{'action'} eq "view"){		&MemberView;				}

	   if($FORM{'action'} eq "cancel"){		&MemberCancel;				}
	elsif($FORM{'action'} eq "delete"){		&MemberDelete;				}
	elsif($FORM{'action'} eq "edit"){		&MemberUpdate;				}
	elsif($FORM{'action'} eq "extend"){		&MemberExtend;				}
	elsif($FORM{'action'} eq "faq"){		&MemberFaq;					}
	elsif($FORM{'action'} eq "login"){		&MemberLogin;				}
	elsif($FORM{'action'} eq "logout"){		&MemberLogout;				}
	elsif($FORM{'action'} eq "lost"){		&MemberLostPassword;		}
	elsif($FORM{'action'} eq "panel"){		&MemberPanel;				}
	elsif($FORM{'action'} eq "preference"){&MemberPreference;		}
	elsif($FORM{'action'} eq "profile"){	&MemberProfile;			}
	elsif($FORM{'action'} eq "register"){	&MemberRegister;			}
	elsif($FORM{'action'} eq "update"){		&MemberUpdate;				}
	elsif($FORM{'action'} eq "validate"){	&MemberValidate;			}
	&MemberValidateSession;
	&MemberLogin;
}
############################################################
#cancel the subscription, but the account remain active
sub MemberCancel{
	&MemberValidateSession;
	if($FORM{'cancel'}){	&MemberPanel($mj{cancel});	}
	elsif($FORM{'step'} eq "final"){
		if($MEMBER{gateway} eq "ibill"){
			require "admin_ibill.pl";
			$message = &iBillCancel(\%MEMBER);
		}
		elsif($MEMBER{gateway} eq "paypal"){
			require "admin_paypal.pl";
			$message = &PaypalCancel(\%MEMBER);
		}
		elsif($MEMBER{gateway} =~ /checkout/i){
			require "admin_checkout.pl";
			$message = &CheckoutCancel(\%MEMBER);
		}
		$MEMBER{recurring} ="";
	}
	else{		&PrintMemberCancel;	}
}
############################################################
sub MemberDelete{
	&MemberValidateSession;
	if($FORM{'cancel'}){	&MemberPanel($mj{cancel});	}
	elsif($FORM{'step'} eq "final"){
		if($MEMBER{gateway} eq "ibill"){
			require "admin_ibill.pl";
			$message = &iBillCancel(\%MEMBER);
		}
		elsif($MEMBER{gateway} eq "paypal"){
			require "admin_paypal.pl";
			$message = &PaypalCancel(\%MEMBER);
		}
		elsif($MEMBER{gateway} =~ /checkout/i){
			require "admin_checkout.pl";
			$message = &CheckoutCancel(\%MEMBER);
		}
		$MEMBER{recurring} ="";
		&DeleteMemberDB($FORM{username});
		if($message){		&PrintError("Cancellation failure", $message);		}
		&SendMail($MEMBER{myname}, $MEMBER{email}, $CONFIG{myemail}, "Membership delete", "$MEMBER{username} has deleted his/her account and send you this message :\n\n$FORM{message}") if($FORM{message});
		&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{email}, $SUBJECT{deleted}, &ParseEmailTemplate($EMAIL{deleted}, \%MEMBER));
		$MEMBER{username} = $MEMBER{password} = $FORM{step} = "";
		$CONFIG{setcookie_now}=1;
		&MemberLogin($mj{mem70});
	}
	else{		&PrintMemberDelete;	}
}
###############################################################################
sub MemberExtend{
	&MemberValidateSession;
	&Gateway((-f $TEMPLATE{payment_extend})?$TEMPLATE{payment_extend}:$TEMPLATE{payment});
}
############################################################
sub MemberFaq{
	&PrintTemplate("$CONFIG{template_path}/faq.html");
}
############################################################
sub MemberLogin{
	my($message);
	$message = ($_[0])?$_[0]:$mj{mem50};
	if($FORM{'step'} eq 'final'){
		$message = &CheckMemberLoginInput;
        if ($message) {undef %MEMBER; &PrintMemberLogin($message);}
		$MEMBER{'last_login'} = &TimeNow;
		$MEMBER{success_login}++;
		&UpdateMemberDB(\%MEMBER);
		$FORM{action} = "login";
#		&WhereToGoAfterLogin;
		&CleanAdPhantoms;
		&MemberPanel;
	}
	else{ &PrintMemberLogin($message);	}
}

###########################################################
sub CleanAdPhantoms{
	my ($sth,$username);
	$username=$dbh->quote($MEMBER{username});
	$sth=runSQL("DELETE FROM ads WHERE username=$username AND status LIKE \'incomplete\%\'");
}


############################################################
sub MemberLogout{
    &LogUserOut;
    $MEMBER{username}= $MEMBER{password}="";
	$CONFIG{setcookie_now} = 1;
	&PrintMemberLogin($mj{mem52});
}
############################################################
sub MemberLostPassword{
    my ($count, $message, %TEMP, $template, $q_email, @mem_data, @db,
    $db,$sth);
	if($FORM{'step'} eq "final"){
		$message = &CheckMemberLostPasswordInput;
		&PrintMemberLostPassword($message) if $message;
		$count=0;
		$template = &FileRead($EMAIL{lost});
		if($FORM{email}){
                $q_email=$dbh->quote($FORM{email});
                @db=&DefineMemberDB;
                $db=join(', ',@db);
                $sth=runSQL("SELECT $db FROM member WHERE email=$q_email");
                $count=$sth->rows();
                while (@mem_data=$sth->fetchrow()) {
                      for (my $i=0; $i <@db; $i++){$MEMBER{$db[$i]}=$mem_data[$i]};
                      &SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{lost}, &ParseEmailTemplate($template, \%MEMBER));
				}
		}
		else{
			%MEMBER = &RetrieveMemberDB($FORM{username});
			&PrintMemberLostPassword($mj{mem3}) unless $MEMBER{username};
			&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{lost}, &ParseEmailTemplate($template, \%MEMBER));
			$count++;
		}
		$message =qq|$mj{email17} $count $mj{email19}.|;
	}
	&PrintMemberLostPassword($message);
}
############################################################
sub MemberPreference{
	&MemberValidateSession;
	if($FORM{step} eq "final"){
#		unless(-d $CONFIG{preference_path}){
#			mkdir($CONFIG{preference_path}, 0777);
#			chmod(0777, $CONFIG{preference_path});
#		}
		&UpdatePreferenceDB($MEMBER{username}, \%FORM);
#		$FORM{'username'}=$MEMBER{username};
#		&LoadMemberProfile;
		$CONFIG{message} = $mj{success};
	}
	&PrintMemberPreference;
}
############################################################
sub MemberProfile{
	&MemberValidateSession;
    foreach (keys %MEMBER){ $MEMBER{$_} = "&nbsp" unless $MEMBER{$_};   }
	&PrintMemberProfile(@_);
}
############################################################
sub MemberPanel{
	&MemberValidateSession;
	&PrintMemberPanel(@_);
}
############################################################
sub MemberRegister{
	my($error, $mem, %MEM, $message);
	if($FORM{'step'} eq "final"){
		$message = &CheckMemberRegisterInput;
		&PrintMemberRegister($message) if $message;
		$FORM{'date_create'} = $FORM{'date_end'} = &TimeNow;
		$FORM{ip_address} = $ENV{REMOTE_ADDR};
		$FORM{last_url}   = $ENV{HTTP_REFERER};
		undef %ACCOUNT;

		$FORM{account} = $CONFIG{default_account};
#        $FORM{account_end} = &GiveMeTime2($MEMBER{account_end}) unless $MEMBER{account_end} > $CONFIG{systemtime};
        %ACCOUNT = &RetrieveAccountDB("$CONFIG{account_path}/$CONFIG{default_account}/account.pl");
		if($ACCOUNT{recurring_amount} > 0 or $ACCOUNT{trial_amount} > 0){
		    $FORM{status} = "pending";
			$error = 1;
		}
		elsif(lc($CONFIG{member_type}) eq "sendmail" or $ACCOUNT{member_type} eq "sendmail"){
			$FORM{pincode} = &RandomCharacters(10);
			$FORM{status} = "pending";
			$error = &SendMail($CONFIG{myname}, $CONFIG{myemail},$FORM{'email'}, $SUBJECT{validated}, &ParseEmailTemplate($EMAIL{validated}, \%FORM));
			$message = $mj{mem64};
		}
		elsif(lc($CONFIG{member_type}) eq "pending" or $ACCOUNT{member_type} eq "pending"){
			$FORM{status} = "pending";
			$error = &SendMail($CONFIG{myname}, $CONFIG{myemail},$FORM{'email'}, $SUBJECT{pending}, &ParseEmailTemplate($EMAIL{pending}, \%FORM));
			$message= $mj{mem65};
		}
		else{
##if(lc($CONFIG{member_type}) eq "instant"){
			$FORM{status} = "active";
#			$FORM{'date_end'} = &GiveMeTime($FORM{'date_end'});
	        $FORM{account_start}=$CONFIG{systemtime};
   	   		if ($ACCOUNT{trial_length}){
   	   		      $FORM{account_end}=($ACCOUNT{trial_period} eq 'unlimited') ? 2**32-2 : $CONFIG{systemtime}+$ACCOUNT{trial_length};
   	   		}
   	   		else {
   	   		      $FORM{account_end}=($ACCOUNT{recurring_period} eq 'unlimited') ? 2**32-2 : $CONFIG{systemtime}+$ACCOUNT{recurring_length};
   	   		}
			$error = &SendMail($CONFIG{myname}, $CONFIG{myemail},$FORM{'email'}, $SUBJECT{registered}, &ParseEmailTemplate($EMAIL{registered}, \%FORM));
			$message= $mj{mem66};
		}
		&AddMemberDB(\%FORM);
        &PrintError($mj{error}, "Registration is successful but we have problems sending you a welcome email. The error is: <br>$error") if ($error ne "1");
###if send to admin
		my $email = ($CONFIG{member_notify})?$CONFIG{member_notify}:$ACCOUNT{member_notify};
		if($email){
			&SendMail($FORM{username}, $FORM{email},$email, $SUBJECT{admin}, &ParseEmailTemplate($EMAIL{admin}, \%FORM));
		}
		%MEMBER = &RetrieveMemberDB($FORM{username});
#		&Gateway;
        &PrintMemberLogin($message);
	}
	else{
		undef %FORM;
		&CheckReferer;
		&PrintMemberRegister;
	}
}
############################################################
sub MemberValidate{
	my($code, $mem, %MEM, $message);
	$message = &CheckMemberValidateInput;
	&PrintMemberValidate($message) if $message;
###if every thing OKs
	$MEMBER{pincode} ="";
#	$DB{date_end}     = &GiveMeTime($FORM{'date_end'});
	$MEMBER{'last_login'} = &TimeNow;
	$MEMBER{'success_login'}++;
	$MEMBER{status} = "active";
	&UpdateMemberDB(\%MEMBER);
	$CONFIG{setcookie_now}=1;
	$code = &SendMail($CONFIG{myname}, $CONFIG{myemail},$MEMBER{'email'}, $SUBJECT{registered}, &ParseEmailTemplate($EMAIL{registered}, \%MEMBER));
	&MemberPanel(($code eq "1")?"":"<li>$code</li>");
}
############################################################
sub MemberView{
	my(%DB, %PREF, $template);
	%DB = &RetrieveMemberDB($FORM{profile});
	%PREF = &RetrievePreferenceDB($DB{username});
	unless ($DB{username}){		&PrintError($mj{error}, $mj{mem3});		}
###Check to see if the username does not allow public viewing
	if($PREF{P_hide_profile}){	&PrintMember($mj{mem30});		}
	
	if($MEMBER{P_hide_email}){	$DB{email} = "<i>hidden</i>";	}
	else{		$DB{email} = qq|<a href="mailto:$DB{email}">$DB{email}</a>|;	}

	$html = &ParseMemberTemplate("$CONFIG{template_path}/view_profile.html", \%DB);
		
	&PrintMember($html);
}
############################################################
sub MemberUpdate{
	my($message);
	&MemberValidateSession;
	if($FORM{'step'} eq "final"){
		$message = &CheckMemberUpdateInput;
		&PrintMemberUpdate($message) if $message;
		foreach (keys %MEMBER){	$FORM{$_} = $MEMBER{$_} unless defined $FORM{$_};		}
		$FORM{last_updated} = &TimeNow;
		&UpdateMemberDB(\%FORM);
		$CONFIG{setcookie_now}=1;
		&LoadDefaultAccount;
		if($MEMBER{P_notify_profile_update}){
			&SendMail($CONFIG{myname}, $CONFIG{myemail},$MEMBER{'email'}, $SUBJECT{updated}, &ParseEmailTemplate($EMAIL{updated}, \%MEMBER));
		}
		&MemberProfile($mj{success});
	}
	else{	&PrintMemberUpdate;}
}
############################################################
sub WhereToGoAfterLogin{
	my($protected_url);
	if($FORM{panel}){
		&MemberPanel;
	}
	elsif($FORM{redirect} and ($FORM{redirect} !~ /$CONFIG{program_url}/) and ($FORM{redirect_enable} eq "true")){
		$protected_url = $FORM{redirect};
	}
	else{
		$protected_url = $ACCOUNT{protected_url};
	}
	&PrintHeader;
	print qq|
		<html><head><title>$mj{title} $mj{version}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta http-equiv="refresh" content="0;URL=$protected_url">
		</head>
		<body>
<p align="center">Please wait.... <br>
  You are taken to our Members Only Area ...</p>
<p align="center">&nbsp;</p>
<p align="center"><b><font size="2">Script powered by <a href="http://www.mojoscripts.com">mojoscripts.com</a></font></b></p>
		</body></html>
	|;
	&PrintFooter;
}
############################################################
sub PrintMember{
	my($cat, $filename, $template);
	my($html, $message) = @_;

	$html = &ParseMemberTemplate($html, \%MEMBER);
	$html = &ParseCommonCodes($html, 1);
	$html =~ s/\[MESSAGE\]/$message/gi;
	
	$template = &ParseCommonCodes($TEMPLATE{member});
	$template =~ s/\[TEMPLATE_MENU\]/&BuildMemberMenu()/e;
	$template =~ s/\[TEMPLATE_TITLE\]/&BuildMemberTitle()/e;
	$template =~ s/\[TEMPLATE_SUBTITLE\]/&BuildMemberSubtitle()/e;
	$template =~ s/\[TEMPLATE_CONTENT\]/$html/;
	&PrintHeader;
	print $template;
	&PrintFooter;
}
############################################################
sub PrintMember2{
	my($cat, $filename, $template);
	($template, $message) = @_;
	$template = &ParseMemberTemplate($template, \%MEMBER);
	$template = &ParseCommonCodes($template, 1);
    $template=~s/\[LOGIN\_URL\]/$CONFIG{member_url}&action=login/ig;
    $template=~s/\[REGISTER\_URL\]/$CONFIG{member_url}&action=register/ig;
    $template =~ s/\[MESSAGE\]/$message/gi;
	&PrintHeader;
	print $template;
	&PrintFooter;
}
############################################################
sub PrintMemberDelete{			&PrintMember($TEMPLATE{member_delete}, @_);	}
sub PrintMemberLogin{			&PrintMember2($TEMPLATE{member_login}, @_);	}
sub PrintMemberLostPassword{	&PrintMember2($TEMPLATE{member_lost}, @_);		}
sub PrintMemberProfile{			&PrintMember($TEMPLATE{member_profile}, @_);	}
sub PrintMemberPreference{		&PrintMember(&BuildMemberPreference(), @_);	}
sub PrintMemberPanel{			&PrintMember2($TEMPLATE{member_panel}, @_);	}
sub PrintMemberRegister{		&PrintMember2(&ParseMemberInput($TEMPLATE{member_register}, \%MEMBER), @_);	}
sub PrintMemberValidate{		&PrintMember2($TEMPLATE{web900}, @_);	}
sub PrintMemberUpdate{			
	foreach (keys %MEMBER){	$MEMBER{$_} = $FORM{$_} if $FORM{$_};	}
	&PrintMember(&ParseMemberInput($TEMPLATE{member_update}, \%MEMBER), &ErrorTemplate(@_));
}
############################################################
############################################################
sub CheckMemberInputType{
	my($name, $type, $extra) = @_;
	my(@extra) = split(//, $extra);
	foreach $extra (@extra){ 	$type .= "\\$extra";	}
	return $name =~ /^[$type]+$/;
}
############################################################
sub CheckMemberLoginInput{
    my($mem, $message, %MEMBER);
	$message .="<li>$mj{mem1}</li>" unless ($FORM{'username'});
	$message .="<li>$mj{mem11}</li>" unless ($FORM{'password'});
	return $message if $message;
    %MEMBER = &isMemberExist($FORM{username});
    return qq|$mj{mem3} $mj{mem9} <a href="$CONFIG{member_url}&action=register&username=$FORM{username}">$FORM{username}</a>?| unless $MEMBER{username};
	if($FORM{'password'} ne $MEMBER{'password'}){
		$MEMBER{fail_login}++;
		&UpdateMemberDB(\%MEMBER);
#        undef %MEMBER, %FORM;
        return $mj{mem12};
	}

	if($MEMBER{status} eq "expire"){
		&PrintUpgrade;
		$message .= qq|<li>$mj{mem6}<li>|;
	}
	elsif($MEMBER{status} eq "pending"){
		&Gateway;
		$message .= qq|<li>$mj{mem5}<li>|;
	}
	elsif($MEMBER{status} eq "suspend"){
		$message .= qq|<li>$mj{mem7}<li>|;
	}
    if ($message) {return $message;}
	return 0;
}
############################################################
sub CheckMemberLostPasswordInput{

}
############################################################
sub CheckMemberRegisterInput{
	my($line, @lines, $field, %FIELD, $message);
	$message = &CheckMemberUpdateInput;
	return $message if $message;
	$message .= qq|<li>$mj{mem4}</li>| if (&isMemberExist($FORM{username}));
	if(-f "$CONFIG{script_path}/scripts/yabb.pl"){
		require "yabb.pl";
		$message .= qq|<li>$mj{mem4}</li>| if (&isYaBBExist($FORM{username}));
	}

	return $message if $message;

	$message .= qq|<li>$mj{mem24}: $FORM{email}</li>| if &CheckBannedEmail($FORM{email});
	$message .= qq|<li>$mj{mem26}: $ENV{REMOTE_ADDR}</li>| if &CheckBannedIP($ENV{REMOTE_ADDR});
	$message .= qq|<li>$mj{mem9a}: $FORM{username}</li>| if &CheckBannedUsername($FORM{username});
	$message .= qq|<li>$mj{mem9b}: $FORM{username}</li>| if &CheckReservedUsername($FORM{username});
	return $message;
}
############################################################
sub CheckMemberUpdateInput{
	&PrintError($mj{error}, "$mj{file13}: $CONFIG{member_fields}") unless (-f $CONFIG{member_fields});
	my $message = &CheckFieldDBInput($CONFIG{member_fields});
	$message .=qq|<li>$mj{mem13}</li>| unless ($FORM{'password'} eq $FORM{'password2'});
	$message .=qq|<li>$mj{mem21}</li>| unless $FORM{'email'} and &GoodEmail($FORM{'email'});
	unless ($CONFIG{duplicate_email}){
		my $username = &isEmailExist($FORM{'email'});
		if($username and ($username ne $FORM{username})){
			$message .=qq|<li>$mj{mem23}</li>|;
		}
	}
	if($CONFIG{username_length}){
		my %DB = &RetrieveFieldDBByID($CONFIG{member_fields}, "username");
		$message .=qq|<li>$DB{name} $mj{com10} $CONFIG{username_length}</li>| unless (length($FORM{username}) >=  $CONFIG{username_length});
	}
	if($CONFIG{password_length}){
		my %DB = &RetrieveFieldDBByID($CONFIG{member_fields}, "password");
		$message .=qq|<li>$DB{name} $mj{com10} $CONFIG{username_length}</li>| unless (length($FORM{password}) >=  $CONFIG{password_length});
	}
	return $message;
}
############################################################
sub CheckMemberValidateInput{
	my($message);
	$message .= "<li>$mj{mem1}</li>" unless $FORM{'username'};
	$message .= "<li>$mj{mem11}</li>" unless $FORM{'password'};
	$message .= "<li>$mj{mem60}</li>" unless $FORM{pincode};
	return $message if $message;
	%MEMBER  = &isMemberExist($FORM{username});
	return qq|<li>$mj{mem61}</li>| if ($MEMBER{status} eq "active");
	return qq|<li>$mj{mem12}</li>| if ($FORM{'password'} ne $MEMBER{'password'});
	return 0;
}
############################################################
sub CheckBannedEmail{
	my($email, @emails);
	$email = shift;
	@emails = &FileRead($CONFIG{banned_email}) if (-f $CONFIG{banned_email});
	foreach (@emails){	return 1 if ($email =~ /$_/i);	}
	return 0;
}
############################################################
sub CheckBannedIP{
	my($ip, @ips, @user_tokens, @tokens, @match);
	$ip = shift;
	@user_tokens = split(/\./, $ip);
	@ips = &FileRead($CONFIG{banned_ip}) if (-f $CONFIG{banned_ip});
	foreach (@ips){
		@tokens = split(/\./, $_);
		$match=0;
		for(my $i=0; $i <@tokens; $i++){
			if ($tokens[$i] eq "*" or $tokens[$i] eq $user_tokens[$i]){	$match++;	}
		}
		return 1 if ($match == 4);
	}
	return 0;
}
############################################################
sub CheckBannedUsername{
	my($username, @usernames);
	$username = shift;
	@usernames = &FileRead($CONFIG{banned_username}) if (-f $CONFIG{banned_username});
	foreach (@usernames){	return 1 if (lc($username) eq lc($_));	}
	return 0;
}
############################################################
#return TRUE if username is reserved
sub CheckReservedUsername{
	my($username, @usernames);
	$username = shift;
	@usernames = &FileRead($CONFIG{reserved_username}) if (-f $CONFIG{reserved_username});
	foreach (@usernames){
		if($CONFIG{check_wholename} and $CONFIG{check_case}){	return 1 if ($username eq $_);	}
		elsif($CONFIG{check_wholename}){	return 1 if ($username eq lc($_));}
		elsif($CONFIG{check_case}){		return 1 if ($username =~ /$_/i);}
		else{							return 1 if ($username =~ /$_/);}
	}
	return 0;
}
##################################################################################
sub BuildMemberField{
	my(%FIELD, $html, $line, @lines, $mem, $req_field);
	($mem) = @_;
	@lines = &FileRead($CONFIG{member_fields});
	foreach $line (@lines){
		%FIELD = &RetrieveFieldDB($line);
		next unless ($FIELD{name} and $FIELD{ID});
		next unless ($FIELD{active});
		next if($FIELD{ID} =~ /username|password|fname|lname|email|position|date_registered|date_expired/);
		$req_field = (lc($FIELD{require}) eq "yes")?"<font size=2 color=red><b>*</b></font>":"";
		$html .=qq|<tr><td><b>$FIELD{name}</b>$req_field</td>
            <td width="307"><b>[IP_$FIELD{ID}]</b></td></tr>
			|;
	}
	return &ParseHTMLInput($html, $mem, $CONFIG{member_fields});
}
############################################################
sub BuildMemberMenu{
	if($FORM{action} =~ /register|lost|login|logout/i){
		return qq||;
	}
	else{
		return qq|
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr> 
    <td height="47"><a href="$CONFIG{member_url}&action=profile">Profile 
      Main</a><br>
      <a href="$CONFIG{member_url}&action=update">Update Profile</a><br>
      <a href="$CONFIG{member_url}&action=delete">Delete Account</a><br>
<!--		<a href="$CONFIG{member_url}&action=cancel">Cancel Subscription</a><br>-->
		<a href="$CONFIG{member_url}&action=faq#member">FAQ</a><br>
<!--		<a href="$CONFIG{program_url}&action=upgrade">Upgrade</a><br>-->
		<a href="$CONFIG{member_url}&action=preference">Preferences</a><br>
      <a href="$CONFIG{member_url}&action=logout">Logout</a> </td>
  	</tr>
  	<tr><td> <hr width="100%" size="0"></td></tr>
  	<tr> <td height="5"><a href="$CONFIG{ad_url}">Ads</a></td></tr>
 	 <tr> <td><a href="$CONFIG{gallery_url}">Gallery</a></td></tr>
  	<tr> 
    <td><a href="$CONFIG{mail_url}">Mailbox</a></td>
  	</tr>
	</table>
		|;
	}
}
############################################################
sub BuildMemberPreference{
	my(%HTML, @label, @label2, %LABEL, %LABEL2, $message,  $template);
	$message = $CONFIG{message} if $CONFIG{message};
	@label = ("0", "1"); %LABEL = ("1"=>$TXT{yes}, "0"=>$TXT{no});
	my @ads_view = ("0", "new", "old"); my %ads_view =("0"=>"Default", "new"=>"New ads first", "old"=>"Old ads first", "random"=>"Don't care");
	my @lpp = ("0", "5", "10", "20", "30", "50"); my %lpp= ("0"=>"Default");
	
	$HTML{P_invisible_mode}=         $Cgi->radio_group("P_invisible_mode", \@label, $MEMBER{P_invisible_mode}, 0, \%LABEL);
	$HTML{P_autologin}=              $Cgi->radio_group("P_autologin", \@label, $MEMBER{P_autologin}, 0, \%LABEL);
	$HTML{P_hide_email}=             $Cgi->radio_group("P_hide_email", \@label, $MEMBER{P_hide_email}, 0, \%LABEL);
	$HTML{P_disable_pm}=             $Cgi->radio_group("P_disable_pm", \@label, $MEMBER{P_disable_pm}, 0, \%LABEL);
	$HTML{P_hide_profile}=           $Cgi->radio_group("P_hide_profile", \@label, $MEMBER{P_hide_profile}, 0, \%LABEL);
	$HTML{P_hide_gallery}=           $Cgi->radio_group("P_hide_gallery", \@label, $MEMBER{P_hide_gallery}, 0, \%LABEL);
	$HTML{P_notify_profile_update}=  $Cgi->radio_group("P_notify_profile_update", \@label, $MEMBER{P_notify_profile_update}, 0, \%LABEL);
	$HTML{P_notify_ads_expired}=     $Cgi->radio_group("P_notify_ads_expired", \@label, $MEMBER{P_notify_ads_expired}, 0, \%LABEL);
	$HTML{P_notify_ads_reply}=  		$Cgi->radio_group("P_notify_ads_reply", \@label, $MEMBER{P_notify_ads_reply}, 0, \%LABEL);
	$HTML{P_notify_pm}=  				$Cgi->radio_group("P_notify_pm", \@label, $MEMBER{P_notify_pm}, 0, \%LABEL);
	
#!    $HTML{P_email_type}=                $Cgi->popup_menu("P_email_type", \@label, $MEMBER{P_email_type}, ('1'=>'html', '0'=>'plain text'));
	$HTML{P_show_empty_subs}=  		$Cgi->radio_group("P_show_empty_subs", \@label, $MEMBER{P_show_empty_subs}, 0, \%LABEL); 
	$HTML{P_ads_view}=  			      $Cgi->popup_menu("P_ads_view", \@ads_view, $MEMBER{P_ads_view}, \%ads_view); 
	$HTML{P_lpp}=  						$Cgi->popup_menu("P_lpp", \@lpp, $MEMBER{P_lpp}, \%lpp); 

	$template = &FileRead($TEMPLATE{member_preference});
	foreach (keys %HTML){	$template =~ s/\[$_\]/$HTML{$_}/i;	}
	$template =~ s/\[MESSAGE\]/$message/gi;
	return $template;
}
############################################################
sub BuildMemberSubtitle{
	my($title);
	if($FORM{action} eq "profile"){		$title =qq|View profile|;	}
	elsif($FORM{action} eq "cancel"){	$title =qq|Cancel subscription|;		}
	elsif($FORM{action} eq "delete"){	$title =qq|Delete account|;		}
	elsif($FORM{action} eq "update"){
		if($FORM{step} eq "final"){		$title =qq|Profile Updated|;			}
		else{										$title =qq|Update profile|;			}
	}
	elsif($FORM{action} eq "login"){		$title =qq|You have successfully logged in|;			}
	elsif($FORM{action} eq "validate"){
		if($FORM{step} eq "final"){		$title =qq|Profile validated|;			}
		else{										$title =qq|Please enter your pincode|;	}
	}
	elsif($FORM{action} eq "view"){		$title =qq|View profile|;		}
	else{											$title =qq||;			}
	return $title;
}
############################################################
sub BuildMemberTitle{
	if($FORM{profile}){	return "$FORM{profile}";	}
	else{						return "$MEMBER{username}";	}
}
############################################################


1;
