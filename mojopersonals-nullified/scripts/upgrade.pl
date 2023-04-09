sub CorrectDatabaseFields{
	my ($filename,@lines,@line);
#	@boolean=("editable","require","searchable","viewable","active");
	$filename=$CONFIG{ad_fields};
	@lines = &FileRead($filename) if (-f $filename);
	for(my $i=0; $i < @lines; $i++){
		@line=split(/\|/,$lines[$i]);
		for (my $j=9; $j<=13; $j++) {
			  if (lc($line[$j]) eq 'no') {$line[$j]='0';}
		}
		if (lc($line[3]) eq 'radio_group') {$line[3]='radio';}
		$lines[$i]=join('|',@line);
		push(@content, $lines[$i]);
	}
	&FileWrite($filename, \@content);

	$filename=$CONFIG{member_fields};
	@lines = &FileRead($filename) if (-f $filename);
	for(my $i=0; $i < @lines; $i++){
		@line=split(/\|/,$lines[$i]);
		for (my $j=9; $j<=13; $j++) {
			  if (lc($line[$j]) eq 'no') {$line[$j]='0';}
		}
		if (lc($line[3]) eq 'radio_group') {$line[3]='radio';}
		$lines[$i]=join('|',@line);
		push(@content, $lines[$i]);
	}
	&FileWrite($filename, \@content);
}

############################################################################
sub CreateAccounts{
	my ($message,$sth,%ACCOUNT,$dir);
	if ($FORM{guestid}) {
	    if (not $FORM{guestid} =~ /^[0-9a-zA-Z\_\-]+$/) {
			$message=qq|Invalid account ID entered. Please enter another:
		             <br><input type=text name="guestid" value="$FORM{guestid}">|;
		}
		elsif (-d "$CONFIG{account_path}/$FORM{guestid}") {
			$message=qq|Account ID you have entered already used. Please enter another:
		             <br><input type=text name="guestid" value="$FORM{guestid}">|;
		}
		else {
			 %ACCOUNT=&RetrieveAccountDB("$CONFIG{account_path}/guest/account.pl");
			 rename "$CONFIG{account_path}/guest","$CONFIG{account_path}/$FORM{guestid}";
			 $ACCOUNT{ID}=$FORM{guestid};
			 &UpdateAccountDB(\%ACCOUNT);
			 $FORM{guestid}=$dbh->quote($FORM{guestid});
			 $sth=runSQL("UPDATE member SET account=$FORM{guestid} WHERE
						  account=\'guest\'");
			 &CreateGuest;
		}
	}
    elsif (-d "$CONFIG{account_path}/guest") {
		$message=qq|Account ID \'guest\' must be reserved for built-in account \'Guest\' (given to non-registered visitors of your site),
	                 but there already exists an account with such ID. Please enter another ID for it:
		             <br><input type=text name="guestid" value="guest">|;
	}
	else {
		$dir=&Subdirectories("$CONFIG{account_path}");
		if (($dir==0) or (@$dir==0) or (not $CONFIG{paysite})){&CreateDefaultAccounts;}
		else {&CreateGuest;}
	}
	return $message;
}

###############################################################
sub CreateGuest{
	 my(%DB);
		$DB{date_create}=time;
        $DB{date_end}='';
        $DB{ID}='guest';
        $DB{name}='Guest account (default account for non-registered visitors)';
        $DB{description}='Guest account (default account for non-registered visitors)';
        $DB{setup_finished}=qq|powered by mojoscripts.com|;
        $DB{trial_amount}='00.00';
        $DB{trial_period}='unlimited';
        $DB{trial_time}="D";
        $DB{trial_length}=2**32-2;
        $DB{recurring_amount}='00.00';
        $DB{recurring_period}="unlimited";
        $DB{recurring_time}="D";
        $DB{recurring_length}=2**32-2;
        $DB{email}='';
        $DB{gateway}='';
#        $DB{recurring}='';

        $DB{ad_browse}='checked';
        $DB{ad_search}='checked';
        $DB{ad_search_advanced}='checked';
        $DB{ad_view}='checked';
        $DB{cupid_search}='';
        $DB{member_view}='checked';
        unless(-d "$CONFIG{account_path}/guest"){
            mkdir("$CONFIG{account_path}/guest", 0777);
            chmod(0777, "$CONFIG{account_path}/guest");
        }

        &AddAccountDB(\%DB);
}



############################################################
sub ConvertMemberDB{
	my(@content,@members, @lines, @content,$set,%MEMBER,%ACCOUNT, %DB,@olddb,
	@db,$sth,@prefdb,$username,@sads,@rads);
 	@olddb =('date_create','date_end','ID','status','position','username','password',
	'email','fname','lname','address','address2','city','state','province','country','zip',
	'phone','fax','website','aim','yim','icq','msn','gender','mojo',
	'ip_address','fail_login','success_login','last_login','last_url','last_updated',
	'ad_allowed','ad_used','media_allowed','media_used','ads','sads','rads','buddies',
	'html_mail', 'email_notify', 'maillist',
	'account', 'account_start', 'account_end', 'pincode', 'subscription_id', 'transaction_id', 'recurring',
	'custom1','custom2','custom3','custom4','custom5');
    @db = &DefineMemberDB;
	@prefdb = &DefinePreferenceDB;
	@members=&DirectoryFiles($CONFIG{member_path});
	foreach (@members){
		@lines = &FileRead($_);
	    for(my $i=0; $i< @olddb; $i++) {$MEMBER{$olddb[$i]} = $lines[$i];	}
		next unless $MEMBER{username};
		$username=$MEMBER{username};
		if (($MEMBER{status} eq "expire") or ($MEMBER{status} eq 'pending')) {$MEMBER{date_end}=$CONFIG{systemtime};}
		if ($MEMBER{account} and (-f "$CONFIG{account_path}/$MEMBER{account}/account.pl")) {
		     %ACCOUNT = &RetrieveAccountDB("$CONFIG{account_path}/$CONFIG{default_account}/account.pl");
		     $MEMBER{mailbox_size}=$ACCOUNT{mailbox_size};
		}
		else {$MEMBER{mailbox_size}=$CONFIG{mailbox_size};}
		if (-f "$CONFIG{mail_path}/$MEMBER{username}/\.signature") {
			 $MEMBER{signature}=&FileRead("$CONFIG{mail_path}/$MEMBER{username}/.signature");
		}

		@sads=split(/\|/,$MEMBER{sads});
		$DB{username}=$MEMBER{username};
		$DB{type}='s';
		foreach $item(@sads){
			next unless ($item>0);
			$DB{ad_id}=$item;
			&AddActionDB(\%DB);
		}
		undef %DB;
#		@rads=split(/\|/,$MEMBER{rads});

		@content=();
		foreach $item(@db){
           $MEMBER{$item}=$dbh->quote($MEMBER{$item});
           push(@content, "$item=".$MEMBER{$item});
        };
       $set=join(', ',@content);
       $sth=runSQL("INSERT INTO member SET $set");

	   @content=();
	   if (-f "$CONFIG{preference_path}/$username.pref") {
	   		@lines = &FileRead("$CONFIG{preference_path}/$username.pref");
	        for(my $i=0; $i <@prefdb; $i++) {$DB{$prefdb[$i]} = $lines[$i];}
	        foreach $item(@prefdb){
               if (defined $DB{$item}) {
		   	       $DB{$item}=$dbh->quote($DB{"$item"});
                   push(@content, "$item=".$DB{$item});
			   }
		   }
       }
	   push(@content,"username=".$MEMBER{username});
	   $set=join(', ',@content);
       $sth=runSQL("INSERT INTO preferences SET $set");
	}
}





############################################################
sub ConvertData{
   	&WriteSubcats(0,$CONFIG{data_path});
}
##############################################################
sub WriteSubcats{
	my(@subcats, @files,$item,@oldcatdb,@oldaddb,@lines,%CAT,%AD,
	$cat,%CATIDS,@order,%CATNUMS,$sth,$cat,$bad,$parent,$path,$file,$oldid);
	($parent,$path)=@_;

	@oldcatdb=("date_create","date_end","ID","name","icon","ricon","description","subs","files","account");
	@oldaddb = (
##mandotory
	"date_create","date_end","username","cat","adid","status",
## first page
	"city","state","province","country","zip","gender","bdm","bdd","bdy","age",
	"eye","hair","body", "height1","height2","weight","ethnic","education", "employment",
	"profession","income","marital","religion", "smoke","drink","kid1","kid2",
	"relationship","interests","groups",
#page 2
	"title","description",
##Third page, a survey like
	"dd","fs","fd","pet","bot","known","toy","esc",
##fourth page
	"image","image2","image3","image4","image5",
###options
	"visibility","priority","template",
###relevant info gather as we go on
	"view","reply","save",
###this value tells me if the ad is updated or new
	"updated");

	@files = &DirectoryFiles($path,['ads','exp','wai','den']);
	foreach $file(@files){
		@lines = &FileRead($file);
	    for(my $i=0; $i <@oldaddb; $i++){$AD{$oldaddb[$i]} = $lines[$i];}
	    $AD{state2}=$AD{province};
		$AD{cat}=$parent;
		$AD{id}=$AD{adid};
		&AddAdDB(\%AD);
		undef %AD;
	}

	@subcats=&Subdirectories($path,1);
	foreach $cat(@subcats){
		@lines = &FileRead("$path/$cat/$CONFIG{cat_db}");
	    for(my $i=0; $i <@oldcatdb; $i++){	$CAT{$oldcatdb[$i]} = $lines[$i];}
		$oldid=$CAT{ID};

		@lines = &RecursiveDirectoryFiles("$path/$cat", [$CONFIG{ad_ext}]);
	    $CAT{ads} = @lines;

		$CAT{parent}=$parent;
		%CAT=&AddCategoryDB(\%CAT);
		$CATIDS{$oldid}=$CAT{id};
		&WriteSubcats($CAT{id},"$path/$cat");
		undef %CAT;
	}

#	if (-f "$path/$CONFIG{cat_order}") {
#		@order = &FileRead("$path/$CONFIG{cat_order}");
#		for (my $i=0; $i<@order; $i++) {$CATNUMS{$order[$i]}=$i+1;}
##		foreach $item(keys %CATIDS) {if (not ($CATNUMS{$item}>0)) {$bad=1; last;}}
##		if (not $bad){
#		    foreach	$item(keys %CATIDS){
#			     $sth=runSQL("UPDATE category SET number=$CATNUMS{$item} WHERE
#			                 id=$CATIDS{$item}");
#		    }
##		}
#	}
}





############################################################
sub ConvertMailDB{
	my($file,@lines, @files, $member, $name, $username,@members,$sth,@oldmaildb,
	%MAIL,$exist,%AD);
	@oldmaildb=("ID","cat","adid","from","to","time","new","subject","message");
#    my @db=('id', 'cat','adid','sent_from','sent_to', 'date_sent',
#    'new','subject','message','folder_from','folder_to');
	@members =&Subdirectories($CONFIG{mail_path});
    foreach $member(@members){
		@files=&DirectoryFiles("$member/inbox");
		foreach	$file(@files){
			@lines = &FileRead($file);
	        for(my $i=0; $i< @oldmaildb; $i++){$MAIL{$oldmaildb[$i]} = $lines[$i];	}
			$sth=runSQL("SELECT * FROM mails WHERE id=$MAIL{ID}");
			$exist=$sth->rows();
			if ($exist) {
				$sth=runSQL("UPDATE mails SET folder_to='inbox' WHERE id=$MAIL{ID}");
			}
			else {
				$MAIL{id}=$MAIL{ID};
				if ($MAIL{adid}) {
					%AD=&RetrieveAdDB($MAIL{adid});
					$MAIL{cat}=$AD{cat};
				}
				$MAIL{sent_from}=$MAIL{from};
				$MAIL{sent_to}=$MAIL{to};
				$MAIL{date_sent}=$MAIL{'time'};
				$MAIL{folder_to}='inbox';
				$MAIL{folder_from}='';
				&AddMailDB(\%MAIL,1);
			}
		}
		@files=&DirectoryFiles("$member/outbox");
		foreach	$file(@files){
			@lines = &FileRead($file);
	        for(my $i=0; $i< @oldmaildb; $i++){$MAIL{$oldmaildb[$i]} = $lines[$i];	}
			$sth=runSQL("SELECT * FROM mails WHERE id=$MAIL{ID}");
			$exist=$sth->rows();
			if ($exist) {
				$sth=runSQL("UPDATE mails SET folder_from='outbox' WHERE id=$MAIL{ID}");
			}
			else {
				$MAIL{id}=$MAIL{ID};
				if ($MAIL{adid}) {
					%AD=&RetrieveAdDB($MAIL{adid});
					$MAIL{cat}=$AD{cat};
				}
				$MAIL{sent_from}=$MAIL{from};
				$MAIL{sent_to}=$MAIL{to};
				$MAIL{date_sent}=$MAIL{'time'};
				$MAIL{folder_to}='';
				$MAIL{folder_from}='outbox';
				&AddMailDB(\%MAIL,1);
			}
		}
	}
}

############################################################
sub DeleteOld{
	my (@oldfiles,$file);
	if (-d $CONFIG{member_path}) {&DeleteAllFromDir($CONFIG{member_path});}
	if (-d $CONFIG{data_path}) {&DeleteAllFromDir($CONFIG{data_path});}
	if (-d $CONFIG{mail_path}) {&DeleteAllFromDir($CONFIG{mail_path});}
	if (-d $CONFIG{preference_path}) {&DeleteAllFromDir($CONFIG{preference_path});}
	@oldfiles=("$CONFIG{program_files_path}/mailID.cgi","$CONFIG{program_files_path}/userID.cgi",
	           "$CONFIG{program_files_path}/user_logs.txt","$CONFIG{program_files_path}/members_db.db",
			   "$CONFIG{program_files_path}/adsID.cgi");
	foreach $file(@oldfiles) {unlink $file;}
}

###########################################################
sub DeleteAllFromDir{
	my ($path,@files,@subdirs,$file,$subdir);
	$path=@_[0];
	return unless (-d $path);
    opendir (DIR, $path) or print "failed to open $path";
    @files= grep {-f "$path/$_" } readdir(DIR);
    closedir (DIR);
  	foreach $file(@files){unlink "$path/$file";}
    opendir (DIR, $path) or return 0;
	@subdirs= grep {!/^\./ && -d "$path/$_" } readdir(DIR);
	closedir (DIR);
	foreach $subdir(@subdirs){
	  	&DeleteAllFromDir("$path/$subdir");
		rmdir "$path/$subdir";
	}
	rmdir $path;
}

###########################################################
sub PrintMessage{
	my $message=@_[0];
	$FORM{step}++;

	foreach (keys %CONFIG) {$FORM{$_}=$CONFIG{$_} unless defined $FORM{$_};}
        &PrintHeader;
	print qq|
<html>
<head>
<title>\$mj{program} $mj{version} Upgrading procedure</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
      <form name="mojo" method="post" action="upgrade.cgi">
<table width="80%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#330066">
  <tr>
    <td>
      <div align="center"><b><font size="4">$mj{program} $mj{version} Upgrading
        Procedure<br>
        from version 2.XX to $mj{version}</font></b></div>
    </td>
  </tr>
  <tr>
    <td height="200">
      <div align="center"><b><font color="#FF0000">$message</font></b></div>
    </td>
  </tr>
	<tr> 
	  <td valign="middle" align="center" colspan="2"> 
        <input type="SUBMIT" value="Next >>" name="submit">
      </td>
    </tr>
        </table>
        <input type="hidden" name="step" value="$FORM{step}">
      </form>
    </td>
  </tr>
</table>
</body>
</html>
	|;
	&PrintFooter;
}
############################################################
sub PrintEnd{
	my $message = shift;
	foreach (keys %CONFIG) {$FORM{$_}=$CONFIG{$_} unless defined $FORM{$_};}
        &PrintHeader;
	print qq|
<html>
<head>
<title>\$mj{program} $mj{version} Upgrading procedure</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table width="80%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#330066">
  <tr>
    <td>
      <div align="center"><b><font size="4">$mj{program} $mj{version} Upgrading
        Procedure<br>
        from version 2.XX to $mj{version}</font></b></div>
    </td>
  </tr>
    <td height="200">
      <div align="center"><b><font color="#FF0000">$message</font></b></div>
    </td>
  </tr>
  <tr>
    <td>
      <ol>
        <li>Copy attached files to corresponding folders of your old version, replacing when offered.</li>
        <li>Run upgrade.cgi module. Your old data will be copied into mysql database.
          (If your server times out, you may need to run this from the shell.)</li>
        <li>Test everything.</li>
        <li>If everything works as expected, then run delete_old.cgi to delete old database.</li>
        <li>If there are any problems, please contact us or have us do the upgrading
          for you for \$50.</li>
      </ol>
    </td>
  </tr>
</table>
</body>
</html>
	|;
	&PrintFooter;
}
###########################################################################
1;
