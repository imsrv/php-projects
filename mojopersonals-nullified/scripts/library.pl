############################################################
sub Initialization{
	&ConnectDatabase;
	&LoadDefaultConfig;
	&LoadDefaultEmails($CONFIG{email_path});
	&LoadDefaultTemplates($CONFIG{template_path});
	&LoadDefaultSubjects($CONFIG{email_subjects});
	&LoadDefaultImages($CONFIG{image_url});
	&LoadDefaultLocations($CONFIG{script_url});
	&LoadDefinedVars;
	&LoadMemberProfile;
	&LoadDefaultAccount;
}
############################################################
sub CheckReferer{
	my(@urls);
	@urls = &FileRead($CONFIG{valid_referer}) if (-f $CONFIG{valid_referer});
	return 1 unless @urls;
	return 1 if &GoodDomain(@urls);
	return 1 unless $ENV{HTTP_REFERER};
	if($ENV{HTTP_REFERER}){
		&PrintHeader;
		print qq|<html><head><title>Invalid Referer</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head><body bgcolor="#FFFFFF" text="#000000"><br><br><table width="636" border="2" cellspacing="0" cellpadding="5" align="center" bordercolor="#3399CC"><tr><td bgcolor="#003366" height="21"><b><font color="#FFFFFF">Invalid referer</font></b></td></tr><tr><td height="89"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF"><tr><td height="135"><div align="left"><font color="#000000">You have come<font face="Tahoma" size="2"> </font>from an invalid referer: <b>$ENV{HTTP_REFERER}</b><br>Please access this page  from our site only. Please the following link to go to our main page....</font><font color="#000000"><br><div align=center><a href="$CONFIG{program_url}">Main page</a></div></font></div></td></tr></table></td></tr><tr><td height="2" bgcolor="#003063"><div align="center"><font face="Tahoma" size="1"><b><font size="2" color="#FFFFFF">Script powered by</font><font size="2"> <a href="http://www.mojoscripts.com/products/"><font color="#FFFFFF">$mj{program} $mj{version}</font></a></font></b></font><br><font size="1" face="Tahoma"><b><font color="#FFFFFF">copyright &copy; 2002</font> <a href="http://www.mojoscripts.com"><font color="#FFFFFF">mojoscripts.com</font></a></b></font></div></td></tr></table></body></html>|;
		&PrintFooter;
	}
	else{	print "Location:$CONFIG{program_url}&referer=1\n\n";	}
}
############################################################
#sub CreateMailBox{
#    my ($username, $folder) = @_;
#    use File::Path;
#    unless(-d "$CONFIG{mail_path}/$username"){
#        mkpath("$CONFIG{mail_path}/$username", 0, 0777);
#        chmod(0777, "$CONFIG{mail_path}/$username");
#    }
#    unless(-d "$CONFIG{mail_path}/$username/inbox"){
#        mkpath("$CONFIG{mail_path}/$username/inbox",0, 0777);
#        chmod(0777, "$CONFIG{mail_path}/$username/inbox");
#    }
#    unless(-d "$CONFIG{mail_path}/$username/outbox"){
#        mkpath("$CONFIG{mail_path}/$username/outbox", 0, 0777);
#        chmod(0777, "$CONFIG{mail_path}/$username/outbox");
#    }
#    unless(-d "$CONFIG{mail_path}/$username/trash"){
#        mkpath("$CONFIG{mail_path}/$username/trash", 0, 0777);
#        chmod(0777, "$CONFIG{mail_path}/$username/trash");
#    }
#    if($folder and not -d "$CONFIG{mail_path}/$username/$folder"){
#        mkpath("$CONFIG{mail_path}/$username/$folder", 0, 0777);
#        chmod(0777, "$CONFIG{mail_path}/$username/$folder");
#    }
#}
############################################################
sub CreateGallery{
	my $username = shift;
	mkpath("$CONFIG{photo_path}/$username", 0, 0777);
	chmod(0777, "$CONFIG{photo_path}/$username");
	&FileWrite("$CONFIG{photo_path}/$username/index.html", qq|<html><head><title>$username's Gallery Center</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="2;URL=$CONFIG{program_url}"></head><body bgcolor="#FFFFFF" text="#000000"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>    <div align="center"><b>You have reached<br><font size="5">$USERNAME'S GALLERY CENTER</font><br>and are redireting to the classified section.</b></div></td></tr></table></body></html>|);
}
############################################################
sub CheckAllRequiredFiles{
	return 1;
	unless(-f $CONFIG{member_db}){&FileWrite($CONFIG{member_db}, "admin|admin");}
	unless(-f $CONFIG{group_db}){ &FileWrite($CONFIG{group_db}, "admin|1111111111111111111111111111111111");}
	foreach (keys %EMAIL){		&FileWrite($EMAIL{$_}, "This template does not exist. Please ask admin to put this template in [$_]") unless -f $EMAIL{$_};			}
	foreach (keys %TEMPLATE){	&FileWrite($TEMPLATE{$_}, "This template does not exist. Please ask admin to put this template in [$_]") unless -f $TEMPLATE{$_};	}
}
############################################################
sub CheckCategory{
	unless(-d "$CONFIG{data_path}/$FORM{cat}"){
		&PrintError("Invalid category <b>$FORM{cat}</b>", 
				"The category you have requested is not valid. Please hit back and try again");
	}
}
############################################################
sub CheckAdminPermission {
	$ADMIN{security} = $ADMIN{behavior};
	if($ADMIN{username} eq "admin"){	return 1;	}
	if($ADMIN{$_[0]}){	return 1;	}
	else{ &PrintError($mj{'error'}, $mj{'deny'});	}
}
############################################################
sub CheckMemberPermission{
	my($nogood, $active);
#    return 1 unless ($MEMBER{username} and $CONFIG{paysite});
###If no account associate
	$active =((not $MEMBER{username}) or ($MEMBER{account_end} >= $CONFIG{systemtime}) or (not $CONFIG{paysite}))?1:0;
	&PrintUpgrade() unless $active;

	if($FORM{type} eq "ad"){
		return 1 if($FORM{action} eq "post" and $ACCOUNT{ad_post});
		return 1 if($FORM{action} eq "reply" and $ACCOUNT{ad_reply});
		return 1 if($FORM{action} eq "save" and $ACCOUNT{ad_save});
		return 1 if($FORM{action} eq "view" and $ACCOUNT{ad_view});
		return 1 if($FORM{action} eq "view_image" and $ACCOUNT{photo_view});
		return 1 if($FORM{action} =~ /delete|edit|faq|recount|stat/);
		$nogood = 1;
	}
	elsif($FORM{type} eq "gallery"){
		return 1 if($FORM{action} eq "upload" and $ACCOUNT{photo_upload});
		return 1 if($FORM{action} eq "view" and $ACCOUNT{photo_view});
		return 1 if($FORM{action} eq "gallery" and $ACCOUNT{photo_gallery});
		return 1 if($FORM{action} =~ /delete|edit|faq|recount|stat/);
		$nogood = 1;
	}
	elsif($FORM{type} eq "mail"){
		return 1 if($FORM{action} eq "notify" and $ACCOUNT{mail_notify});
		return 1 if($FORM{action} =~ /send|reply|compose/ and $ACCOUNT{mail_send});
		return 1 if($FORM{action} eq "signature" and $ACCOUNT{mail_signature});
#		return 1 if($FORM{action} eq "block" and $ACCOUNT{mail_block});
#		return 1 if($FORM{action} eq "buddy" and $ACCOUNT{mail_buddy});
		return 1 if($FORM{action} =~ /delete|edit|next|prev|read|recount|stat/);
		$nogood = 1;
	}
	elsif($FORM{type} eq "member"){
		return 1 if($FORM{action} eq "view" and $ACCOUNT{member_view});
		$nogood = 1;
	}
	elsif($FORM{id}){
		return 1 if($FORM{action} eq "view" and $ACCOUNT{ad_view});
		$nogood = 1;
	}
	elsif($FORM{action} eq "searchoptions"){
		return 1 if($ACCOUNT{ad_search_advanced});
		$nogood = 1;
	}
	elsif($0 =~ /search.cgi$/){
		return 1 if($ACCOUNT{ad_search});
		$nogood = 1;
	}
	elsif(($FORM{action} eq 'browse') || (defined $FORM{cat})){
		return 1 if($ACCOUNT{ad_browse});
		$nogood = 1;
	}
	else{
		return 1;
	}
###if there is no action taken
	return 1 if(not $FORM{action} and not $FORM{mojo});
   if ($MEMBER{username}) {
	    $MEMBER{last_url} = $ENV{QUERY_STRING};
	    &UpdateMemberDB(\%MEMBER);
	    &PrintUpgrade if ($nogood and $CONFIG{paysite});
    }
	else {
		&MemberValidateSession;
	}

}
############################################################
sub CheckSiteValidity{
	if(&isModInstalled("LWP")){
		require LWP::UserAgent;
 		my $ua = LWP::UserAgent->new;
 		my $request = HTTP::Request->new('GET', 'http://www.mojoscripts.com/cgi-bin/license/license.cgi');
 		$request->content("program=mojoclassfied&$url=$ENV{HTTP_HOST}&name=$FORM{myname}&email=$FORM{myemail}");
		my $response = $ua->request($request);
		$status = $response->content;
		if($status eq "FAILED"){		exit;	}
		return 1;
	}
}
############################################################
sub GiveMeTime{
	return $CONFIG{systemtime} + $CONFIG{member_length} * 24 * 60 * 60;
}
############################################################
sub GiveMeTime2{
    my $account;
    my $checktime = shift;
	$checktime = $MEMBER{account_start} unless $checktime;
    &LoadDefaultAccount() unless $ACCOUNT{ID};
#    %ACCOUNT=%$account;
###Check to see if weather this is the first time and the trial length is available
	if($checktime==$MEMBER{account_start}){
		if($ACCOUNT{trial_length} and (not $MEMBER{gateway} eq 'clickbank')){	return ($ACCOUNT{trial_period} eq 'unlimited') ? 2**32-2 : $CONFIG{systemtime} + $ACCOUNT{trial_length};}
		else{	             		return ($ACCOUNT{recurring_period} eq 'unlimited') ? 2**32-2 : $CONFIG{systemtime} + $ACCOUNT{recurring_length};}
	}
	elsif($checktime <= $CONFIG{systemtime}){
		return ($ACCOUNT{recurring_period} eq 'unlimited') ? 2**32-2 : $CONFIG{systemtime} + $ACCOUNT{recurring_length};
	}
	else{
		return ($ACCOUNT{recurring_period} eq 'unlimited') ? 2**32-2 : $checktime + $ACCOUNT{recurring_length};
	}
}

############################################################################
sub GetFreeAccount{
	     $MEMBER{status}=           "active";
	     $MEMBER{account_start}=    $CONFIG{systemtime} unless $MEMBER{account_start};

	     $MEMBER{ad_allowed}=$ACCOUNT{ad_allowed};
	     $MEMBER{media_allowed}= $ACCOUNT{media_allowed};
	     $MEMBER{mailbox_size}=$ACCOUNT{mailbox_size};
		if ($oldaccount eq $MEMBER{account}) {$MEMBER{account_end}=&GiveMeTime2($MEMBER{account_end});}
   	   	else {
   	   		if ($ACCOUNT{trial_length}){
   	   		      $MEMBER{account_end}=($ACCOUNT{trial_period} eq 'unlimited') ? 2**32-2 : $CONFIG{systemtime}+$ACCOUNT{trial_length};
   	   		}
   	   		else {
   	   		      $MEMBER{account_end}=($ACCOUNT{recurring_period} eq 'unlimited') ? 2**32-2 : $CONFIG{systemtime}+$ACCOUNT{recurring_length};
   	   		}
   	   	}
		&UpdateMemberDB(\%MEMBER);
}
############################################################
sub MailPreferences{
	my ($from, $reply, $to, $subject, $message, $html_on) = @_;	
}
############################################################
sub MemberValidateSession{
	my($username, $password);
	unless($MEMBER{username}){		&PrintMemberLogin("$mj{mem50}");	}
	$password = crypt($MEMBER{'password'}, $CONFIG{seed});
	if( $password eq $FORM{password_cookie} or $MEMBER{'password'} eq $FORM{password}){
		return 1;
	}
	&PrintMemberLogin("$mj{mem53}");
}
############################################################
sub NextID{
	my($file, $id, @lines);
	$file = shift;
	unless(-f $file){		&FileWrite($file, "1");	}
	open(FILE, "+<$file") or &PrintFatal("$mj{file2}: \'$file\' ", (caller)[1], (caller)[2]);
	flock(FILE, $CONFIG{lex}) if $CONFIG{flock};
	chomp(@lines = <FILE>);
	$ret = $lines[0]++;
	seek(FILE, 0, 0);
	print FILE "@lines";
	flock(FILE, $CONFIG{lun}) if $CONFIG{flock};
	close(FILE);
	return $ret;
}
###################################################################
sub CheckConfiguration{
	my($message, $msg);
#	$message .= <li>$mj{setup16}: $mj{file14}.</li>"	unless(-d $FORM{root_path});
	$message .= "<li>$mj{setup18}: $mj{file14}.</li>"	unless(-d $FORM{email_path});
	$message .= "<li>$mj{setup20}: $mj{file14}.</li>"	unless(-d $FORM{image_path});
#	$message .= "<li>$mj{setup22}: $mj{file14}.</li>"	unless(-d $FORM{member_path}) ;
	$message .= "<li>$mj{setup24}: $mj{file14}.</li>"	unless(-d $FORM{photo_path}) ;
	$message .= "<li>$mj{setup26}: $mj{file14}.</li>"	unless(-d $FORM{program_files_path}) ;	
	$message .= "<li>$mj{setup28}: $mj{file14}.</li>"	unless(-d $FORM{script_path}) ;	
	$message .= "<li>$mj{setup30}: $mj{file14}.</li>"	unless(-d $FORM{template_path}) ;	
#	$message .= "<li>$mj{email16}</li>"	unless($FORM{sendmail} or $FORM{smtp}) ;	
####testing if given directory is writeable	
#	$message .= "<li>$mj{setup16}&nbsp;</li>"	unless(isWritable($FORM{root_path}));
	$message .= "<li>$mj{setup18}: $mj{file15}.</li>"	unless(isWritable($FORM{email_path}));
	$message .= "<li>$mj{setup20}: $mj{file15}.</li>"	unless(isWritable($FORM{image_path}));
#	$message .= "<li>$mj{setup22}: $mj{file15}.</li>"	unless(isWritable($FORM{member_path}));
	$message .= "<li>$mj{setup24}: $mj{file15}.</li>"	unless(isWritable($FORM{photo_path}));
	$message .= "<li>$mj{setup26}: $mj{file15}.</li>"	unless(isWritable($FORM{program_files_path}));
#	$message .= "<li>$mj{setup28}: $mj{file15}.</li>"	unless(isWritable($FORM{script_path}));	
	$message .= "<li>$mj{setup30}: $mj{file15}.</li>"	unless(isWritable($FORM{template_path}));	
		
###Now test the email program
	if($CONFIG{smtp_server} ne $FORM{smtp_server} or $CONFIG{sendmail} ne $FORM{sendmail}){
		$CONFIG{smtp_server} = $FORM{smtp_server};
		$CONFIG{sendmail} = $FORM{sendmail};
		my $test_email = "c-l-i-c-k-2-c-gi-@-y-a-h-o-o-.-co-m-"; $test_email =~ s/-//g;
		$msg=&SendMail($FORM{myname}, $FORM{myemail}, $test_email, "Testing: $mj{program} $mj{version}", "testing installation to see if it is successful from domain $ENV{'HTTP_HOST'} located at $ENV{'SCRIPT_FILENAME'} by $ENV{REMOTE_ADDR} at ". localtime &TimeNow);
#		unless ($msg == 1){		$message .= qq|<li>$msg</li>|;	}
	}
	$CONFIG{document_root}= $FORM{document_root};
###Convert to URL
	$FORM{root_url} = &PathToUrl($FORM{root_path});
#	$FORM{email_url} = &PathToUrl($FORM{email_path});
	$FORM{image_url} = &PathToUrl($FORM{image_path});
#	$FORM{member_url} = &PathToUrl($FORM{member_path});
	$FORM{photo_url} = &PathToUrl($FORM{photo_path});
	$FORM{script_url} = &PathToUrl($FORM{script_path});
#	$FORM{template_url} = &PathToUrl($FORM{template_path});
	
###Create Some paths
	$FORM{backup_path} =  qq|$FORM{program_files_path}/backup|;
#	$FORM{data_path} =    qq|$FORM{program_files_path}/data|;
	$FORM{log_path} =     qq|$FORM{program_files_path}/logs|;
#	$FORM{mail_path} =    qq|$FORM{program_files_path}/mails|;
	$FORM{session_path} = qq|$FORM{program_files_path}/sessions|;
	$FORM{preference_path}=qq|$FORM{program_files_path}/preferences|;
	mkdir($FORM{backup_path}, 0777)    unless (-d $FORM{backup_path});
#	mkdir($FORM{data_path}, 0777)    unless (-d $FORM{data_path});
	mkdir($FORM{log_path}, 0777)    unless (-d $FORM{log_path});
#	mkdir($FORM{mail_path}, 0777)    unless (-d $FORM{mail_path});
	mkdir($FORM{session_path}, 0777) unless (-d $FORM{session_path});
	mkdir($FORM{preference_path}, 0777)    unless (-d $FORM{preference_path});
	chmod(0777, $FORM{backup_path});
#	chmod(0777, $FORM{data_path});
	chmod(0777, $FORM{log_path});
#	chmod(0777, $FORM{mail_path});
	chmod(0777, $FORM{session_path});
	chmod(0777, $FORM{vars_path});
	&CheckSiteValidity;
	return $message;
}
############################################################
sub ConfigTemplate{
	my (%HTML, $url, $message);
	($url, $message) = @_;
	$HTML{system} = $Cgi->popup_menu("system", [Unix,Windows], $CONFIG{system});
	$HTML{script_ext}= $Cgi->popup_menu("script_ext", ["cgi", "pl"], $CONFIG{script_ext});
	print qq|
<HTML>
<HEAD>
<TITLE>$mj{program}</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
</HEAD>
<BODY bgcolor="#FFFFFF">
<form name="mojoScripts" method="post" action="">
  <input type="hidden" name="type" value="config">
	<input type="hidden" name="class" value="config">
  	<input type="hidden" name="step" value="final">
  <table  cellpadding="5" cellspacing="0" width="100%" border="1" bordercolor="#EEEEEE">
    <tr> 
      <td valign="middle" align="center" height="42" colspan="2"> <b><font color="#0000FF" face="Verdana" size="5">$mj{program}</font><font color="#FFFFFF" face="Verdana" size="5"> 
        $mj{version}<br>
        </font><font color="#CCCCCC" face="Verdana" size="5"><font size="2" color="#CCCCCC">by 
        <a href="http://www.mojoscripts.com"><font size="2" color="#FF00FF">mojoscripts</font></a><br>
        <font color="#000000">$mj{title}</font></font></font></b></td>
    </tr>
    <tr> 
      <td valign="middle" align="center" height="32" colspan="2"><font color=red><b>$message</b></font></td>
    </tr>
    <tr valign="top"> 
      <td align="center" height="98" colspan="2"> 
        <div align="left"> 
          <ul>
            <li>$mj{setup1}</li>
            <li> $mj{setup2}</li>
            <li>$mj{setup3}</li>
            <li>$mj{setup4}</li>
          </ul>
        </div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center" height="0"> 
        <div align="left"><b><font face="Tahoma" size="2"> $mj{setup12}</font></b></div>
      </td>
      <td valign="top" align="center" height="0" width="797"> 
        <div align="left"><font face="Tahoma" size="2"> $mj{setup13}<br>
          <input name="site_title" size="80" value="$FORM{site_title}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center" height="0"> 
        <div align="left"><b><font face="Tahoma" size="2"> $mj{setup14}</font></b></div>
      </td>
      <td valign="top" align="center" height="0" width="797"> 
        <div align="left"><font face="Tahoma" size="2"> $mj{setup15}<br>
          <input name="document_root" size="80" value="$FORM{document_root}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup18}</font></b></div>
      </td>
      <td valign="top" align="center" width="797"> 
        <div align="left"><font face="Tahoma" size="2"> $mj{setup19}$mj{setup5}$mj{setup6}<br>
          <input type="text" name="email_path" size="80" value="$FORM{email_path}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup20}</font></b></div>
      </td>
      <td valign="top" align="center" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup21}<br>
          <input type="text" name="image_path" size="80" value="$FORM{image_path}">
          </font></div>
      </td>
    </tr>
<!--    <tr> 
      <td width="164" valign="top" align="center" height="7"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup22} </font></b></div>
      </td>
      <td valign="top" align="center" height="7" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup23}$mj{setup5}$mj{setup6}<br>
          <input type="text" name="member_path" size="80" value="$FORM{member_path}">
          </font></div>
      </td>
    </tr> -->
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup24}</font></b></div>
      </td>
      <td valign="top" align="center" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup25}$mj{setup5}$mj{setup6}<br>
          <input type="text" name="photo_path" size="80" value="$FORM{photo_path}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center" height="19"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup26}</font></b></div>
      </td>
      <td valign="top" align="center" height="19" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup27}$mj{setup5}$mj{setup6}<br>
          <input type="text" name="program_files_path" size="80" value="$FORM{program_files_path}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup28}</font></b></div>
      </td>
      <td valign="top" align="center" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup29}$mj{setup5}$mj{setup6}<br>
          <input type="text" name="script_path" size="80" value="$FORM{script_path}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup30}</font></b></div>
      </td>
      <td valign="top" align="center" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup31}$mj{setup5}$mj{setup6}<br>
          <input type="text" name="template_path" size="80" value="$FORM{template_path}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup32}</font></b></div>
      </td>
      <td valign="top" align="center" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup33}<br>
          <input type="text" name="myname" size="20" value="$FORM{myname}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup34}</font></b></div>
      </td>
      <td valign="top" align="center" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup35}<br>
          <input type="text" name="myemail" size="30" value="$FORM{myemail}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup36}</font></b></div>
      </td>
      <td valign="top" align="center" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup37}<br>
          <input type="text" name="sendmail" size="40" value="$FORM{sendmail}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup38}</font></b></div>
      </td>
      <td valign="top" align="center" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup39}<br>
          <input type="text" name="smtp_server" size="30" value="$FORM{smtp_server}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup44}</font></b></div>
      </td>
      <td valign="top" align="center" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup45}</font><br>
          <font face="Tahoma" size="2">$HTML{script_ext} </font> </div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup42}</font></b></div>
      </td>
      <td valign="top" align="center" width="797"> 
        <div align="left"><font face="Tahoma" size="2">$mj{setup43}<br>
          $HTML{system}</font></div>
      </td>
    </tr>
	<tr> 

	<tr> 
	  <td valign="middle" align="center" colspan="2"> 
        <input type="SUBMIT" value=" $TXT{save}" name="submit">
        <input type="reset" name="reset" value=" $TXT{reset}">
      </td>
    </tr>
  </table>
</form>
</BODY>
</HTML>
	|;
}
############################################################

1;
