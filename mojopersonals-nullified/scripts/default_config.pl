############################################################
sub LoadDefaultAccount{

	if($FORM{account} and -f "$CONFIG{account_path}/$FORM{account}/account.pl"){
		%ACCOUNT = &RetrieveAccountDB("$CONFIG{account_path}/$FORM{account}/account.pl");
	}
	elsif($MEMBER{account} and -f "$CONFIG{account_path}/$MEMBER{account}/account.pl"){
		%ACCOUNT = &RetrieveAccountDB("$CONFIG{account_path}/$MEMBER{account}/account.pl");
	}
	else{
       if ($MEMBER{username}){
           $MEMBER{account} = $CONFIG{default_account};
#           $MEMBER{account_end} = &GiveMeTime2($MEMBER{account_end}) unless $MEMBER{account_end} > $CONFIG{systemtime};
		   %ACCOUNT = &RetrieveAccountDB("$CONFIG{account_path}/$CONFIG{default_account}/account.pl");
	       if (not (($ACCOUNT{trial_amount} > 0) or ($ACCOUNT{recurring_amount} > 0))){
		       $oldaccount='';
		       &GetFreeAccount;
		   }
		   else {&UpdateMemberDB(\%MEMBER);}
       }
       elsif (-f "$CONFIG{account_path}/guest/account.pl"){
           %ACCOUNT=&RetrieveAccountDB("$CONFIG{account_path}/guest/account.pl");
       }
       else {
           %ACCOUNT = &RetrieveAccountDB("$CONFIG{account_path}/$CONFIG{default_account}/account.pl");
       }
    }

#        $ACCOUNT{recurring_length}=  $CONFIG{member_length} * 24 * 60 *60;
#		$ACCOUNT{ad_length}=      qq|$CONFIG{ad_length}|; 
#		$ACCOUNT{ad_type}=        qq|$CONFIG{ad_type}|; 
#		$ACCOUNT{ad_allowed}=     qq|$CONFIG{ad_allowed}|;
#		$ACCOUNT{ad_notify}=       q|$CONFIG{ad_notify}|;
#
#		$ACCOUNT{media_size}=     qq|$CONFIG{media_size}|;
#		$ACCOUNT{media_allowed}=  qq|$CONFIG{media_allowed}|;
#		$ACCOUNT{media_ext}=      qq|$CONFIG{media_ext}|;
#		$ACCOUNT{media_width}=    qq|$CONFIG{media_width}|;
#		$ACCOUNT{media_height}=   qq|$CONFIG{media_height}|;
#
#		$ACCOUNT{member_type}=    qq|$CONFIG{member_type}|;
#		$ACCOUNT{member_notify}=   q|$CONFIG{member_notify}|;
#		$ACCOUNT{member_length}=  qq|$CONFIG{member_length}|;
}
############################################################
sub LoadDefaultConfig{
	$CONFIG{ad_ext}=         qq|ads|;
	$CONFIG{ad_deny}=        qq|den|;
	$CONFIG{ad_exp}=         qq|exp|;
	$CONFIG{ad_wai}=         qq|wai|;
	$CONFIG{ad_inc}=         qq|inc|;
	
	$CONFIG{member_ext}=     qq|mem|;
	$CONFIG{expire_ext}=     qq|exp|;
	$CONFIG{pending_ext}=    qq|wai|;
	
	$CONFIG{log}=            qq|yes|;
	$CONFIG{lsh}=            qq|1|;
	$CONFIG{lex}=            qq|2|;
	$CONFIG{lun}=            qq|8|;
	$CONFIG{seed}=           qq|mj|;
	$CONFIG{systemtime}=     &TimeNow;
	$CONFIG{usertime}=       &TimeNow("user");
	
	$CONFIG{cookie_username}=qq|mojousn|;
	$CONFIG{cookie_password}=qq|mojopsw|;
	
	$CONFIG{admin_db}=       qq|$CONFIG{program_files_path}/admin_db.db|;
	$CONFIG{group_db}=       qq|$CONFIG{program_files_path}/groups_db.db|;
#	$CONFIG{member_db}=      qq|$CONFIG{program_files_path}/members_db.db|;
	
	$CONFIG{email_subjects}= qq|$CONFIG{program_files_path}/email_subjects.txt|;
	$CONFIG{ad_fields}=      qq|$CONFIG{program_files_path}/ad_fields.txt|;
	$CONFIG{member_fields}=  qq|$CONFIG{program_files_path}/member_fields.txt|;
		
	$CONFIG{reserved_username}= qq|$CONFIG{program_files_path}/reserved_usernames.txt|;
	$CONFIG{banned_email}=   qq|$CONFIG{program_files_path}/banned_emails.txt|;
	$CONFIG{banned_ip}=      qq|$CONFIG{program_files_path}/banned_IPs.txt|;
	$CONFIG{banned_username}=qq|$CONFIG{program_files_path}/banned_usernames.txt|;
	$CONFIG{valid_referer}=  qq|$CONFIG{program_files_path}/valid_referer.txt|;
	
	$CONFIG{cat_order}=      qq|cat_order.cgi|;
	$CONFIG{cat_db}=         qq|cats.cgi|;
	$CONFIG{file_db}=        qq|files.cgi|;
	
}
############################################################
sub LoadDefaultEmails{
	my $path = $_[0]?$_[0]:$CONFIG{email_path};
	$EMAIL{ad_approved}=   qq|$path/ad_approved.txt|;
	$EMAIL{ad_deleted}=    qq|$path/ad_deleted.txt|;
	$EMAIL{ad_denied}=     qq|$path/ad_denied.txt|;
	$EMAIL{ad_expired}=    qq|$path/ad_expired.txt|;
	$EMAIL{ad_replied}=    qq|$path/ad_replied.txt|;
	$EMAIL{ad_posted}=     qq|$path/ad_posted.txt|;
	$EMAIL{ad_updated}=    qq|$path/ad_updated.txt|;

	$EMAIL{activated}=     qq|$path/activated.txt|;
	$EMAIL{admin}=         qq|$path/admin.txt|;
	$EMAIL{approved}=      qq|$path/approved.txt|;
	$EMAIL{bill}=          qq|$path/bill.txt|;
	$EMAIL{credit}=        qq|$path/credit.txt|;
	$EMAIL{deleted}=       qq|$path/deleted.txt|;
	$EMAIL{denied}=        qq|$path/denied.txt|;
	$EMAIL{expired}=       qq|$path/expired.txt|;
	$EMAIL{lost}=          qq|$path/lost.txt|;
	$EMAIL{pending}=       qq|$path/pending.txt|;
	$EMAIL{remind}=        qq|$path/remind.txt|;
	$EMAIL{registered}=    qq|$path/registered.txt|;
	$EMAIL{unexpired}=     qq|$path/unexpired.txt|;
	$EMAIL{updated}=       qq|$path/updated.txt|;
	$EMAIL{validated}=     qq|$path/validated.txt|;
	$EMAIL{welcome}=       qq|$path/welcome.txt|;
}
############################################################
sub LoadDefaultTemplates{
	my $path = $_[0]?$_[0]:$CONFIG{template_path};
	$TEMPLATE{home}=            qq|$path/cat.html|;
	$TEMPLATE{category}=        qq|$path/cat.html|;
	$TEMPLATE{cat1}=            qq|$path/cat1.html|;
	$TEMPLATE{ad_full}=         qq|$path/ad_full.html|;
        $TEMPLATE{ad}=              qq|$path/ad.html|;
	$TEMPLATE{ad1}=             qq|$path/ad1.html|;
	$TEMPLATE{ad1_new}=         qq|$path/ad1_new.html|;
	$TEMPLATE{ad1_popular}=     qq|$path/ad1_popular.html|;
	
	$TEMPLATE{error}=           qq|$path/error.html|;
	$TEMPLATE{image}=           qq|$path/image.html|;

	$TEMPLATE{member_delete}=   qq|$path/member_delete.html|;
	$TEMPLATE{member_login}=    qq|$path/member_login.html|;
	$TEMPLATE{member_lost}=     qq|$path/member_lost.html|;
	$TEMPLATE{member_panel}=    qq|$path/member_panel.html|;
	$TEMPLATE{member_preference}=qq|$path/member_preference.html|;
	$TEMPLATE{member_profile}=  qq|$path/member_profile.html|;
	$TEMPLATE{member_register}= qq|$path/member_register.html|;
	$TEMPLATE{member_success}=  qq|$path/member_success.html|;
	$TEMPLATE{member_update}=   qq|$path/member_update.html|;

	$TEMPLATE{post1}=           qq|$path/post1.html|;
        $TEMPLATE{post0}=       qq|$path/post0.html|;
	$TEMPLATE{post2}=           qq|$path/post2.html|;
	$TEMPLATE{post3}=           qq|$path/post3.html|;
	$TEMPLATE{post4}=           qq|$path/post4.html|;
	$TEMPLATE{post5}=    	    qq|$path/post5.html|;
	$TEMPLATE{reply}=           qq|$path/reply_ad.html|;
	$TEMPLATE{search}=          qq|$path/search.html|;

	$TEMPLATE{upgrade}=         qq|$path/upgrade.html|;
	$TEMPLATE{payment}=         qq|$path/payment.html|;
	$TEMPLATE{gallery}=         qq|$path/template.html|;
	$TEMPLATE{mailbox}=         qq|$path/template.html|;
	$TEMPLATE{adcenter}=        qq|$path/template.html|;
	$TEMPLATE{member}=          qq|$path/template.html|;
	$TEMPLATE{web900}=          qq|$path/web900.html|;
}
############################################################
sub LoadDefaultSubjects{
	my $path = $_[0]?$_[0]:$CONFIG{email_subjects};
	if(-f "$path"){ require "$path";	}
}
############################################################
sub LoadDefaultImages{
	my $path = $_[0]?$_[0]:$CONFIG{image_url};
	$IMG{cat}=                qq|$path/category.gif|;
	$IMG{new}=                qq|$path/new.gif|;
	$IMG{hearts}=             qq|$path/personals.gif|;
	$IMG{search}=             qq|$path/search.gif|;
}
############################################################
sub LoadDefaultLocations{
	my $path = $_[0]?$_[0]:$CONFIG{script_url};
	$CONFIG{admin_url}=       qq|$path/admin.$CONFIG{script_ext}|;
	$CONFIG{ad_url}=          qq|$path/mojoClassified.$CONFIG{script_ext}?type=ad|;
	$CONFIG{cron_url}=        qq|$path/cron.$CONFIG{script_ext}|;
	$CONFIG{gallery_url}=     qq|$path/mojoClassified.$CONFIG{script_ext}?type=gallery|;
	$CONFIG{mail_url}=        qq|$path/mojoClassified.$CONFIG{script_ext}?type=mail|;
	$CONFIG{member_url}=      qq|$path/mojoClassified.$CONFIG{script_ext}?type=member|;
	$CONFIG{program_url}=     qq|$path/mojoClassified.$CONFIG{script_ext}?mojo=1|;
	$CONFIG{rate_url}=        qq|$path/rate.$CONFIG{script_ext}?mojo=1|;
	$CONFIG{search_url}=      qq|$path/search.$CONFIG{script_ext}?type=search|;
	$CONFIG{verify_url}=      qq|$path/verify.$CONFIG{script_ext}?a=time|;
	

	$CONFIG{checkout_url}=    qq|$path/2checkout.$CONFIG{script_ext}?mojo=1|;
	$CONFIG{ibill_url}=       qq|$path/ibill.$CONFIG{script_ext}|;
	$CONFIG{clickbank_url}=   qq|$path/clickbank.$CONFIG{script_ext}?mojo=1|;
	$CONFIG{paypal_url}=      qq|$path/paypal.$CONFIG{script_ext}?mojo=1|;
}
############################################################
sub LoadDefinedVars{
	$FORM{'lpp'} = ($FORM{'lpp'})?$FORM{'lpp'}:$CONFIG{lpp};
	$FORM{daysnew} = ($FORM{daysnew})?$FORM{daysnew}:$CONFIG{daysnew};
	
	$FORM{'username'} = $Cgi->cookie($CONFIG{cookie_username}) unless ((defined $FORM{'username'}) or $anonyminit);
	$FORM{password_cookie} = $Cgi->cookie($CONFIG{cookie_password});
	
#	$CONFIG{category_path} = ($FORM{cat})?"$CONFIG{data_path}/$FORM{cat}":$CONFIG{data_path};
#	$CONFIG{category_db}   = qq|$CONFIG{category_path}/$CONFIG{cat_db}|;
#	$CONFIG{category_order}= qq|$CONFIG{category_path}/$CONFIG{cat_order}|;
	
	$CONFIG{preference_path}=qq|$CONFIG{program_files_path}/preferences|;
	$CONFIG{account_path}=   qq|$CONFIG{program_files_path}/accounts|;
	$CONFIG{this_account}=   $FORM{account}?"$CONFIG{account_path}/$FORM{account}":$CONFIG{account_path};
#	$CONFIG{account_file}=   qq|$CONFIG{this_account}/account.pl|;
#	$CONFIG{password_file}=  qq|$CONFIG{this_account}/.htpsswd|;
#	$CONFIG{userlog}=        qq|$CONFIG{log_path}/$FORM{username}.log|;
}
############################################################
sub LoadMemberProfile{
	my (%MEM);
    return unless (defined $FORM{username});
    %MEM = &isMemberExist($FORM{'username'});
	undef %MEMBER;
	my $password = crypt($MEM{'password'}, $CONFIG{seed});
    if($password eq $FORM{password_cookie} or $MEM{'password'} eq $FORM{password}){
           %MEMBER = %MEM;
    }
    else{ return;}
#	$FORM{username}=''; return;
#        $MEMBER{username} = $MEM{username}; }
	my %PREF = &RetrievePreferenceDB($MEMBER{username});
	foreach (keys %PREF){	$MEMBER{$_} = $PREF{$_};	}
	if($MEMBER{P_lpp}){		$FORM{'lpp'}= $MEMBER{P_lpp};	}
	if($MEMBER{P_show_empty_subs}){		$CONFIG{show_empty_subs}= $MEMBER{P_show_empty_subs};	}
}
############################################################
1;
