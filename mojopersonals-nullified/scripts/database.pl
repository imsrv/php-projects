
############################################################
###					ADS DATABASE
### Public subroutines
### [%] = &RetrieveAdDB($filename|\%);
### &SaveAdDB(\%);
### &UpdateAdDB(\%);
### &DeleteAdDB($filename|\%)
### [%] = &isAdExist($adid|\%);
############################################################
sub DefineAdString{
	my ($db, @db, %DB, $string);
	$db = shift;
	%DB = %$db;
	@db = &DefineAdDB;
	foreach (@db){	$string.= "$DB{$_}|";	}
	return $string;
}
############################################################
sub RetrieveAdString{
	my ($db, @db, %DB, @lines,  $string);
	$string = shift;
	@lines = split(/\|/, $string);
	@db = &DefineAdDB;
	for(my $i=0; $i< @db; $i++){		$DB{$db[$i]} = $lines[$i];	}
	return \%DB if $FORM{fast_parse};
	
	%P = &RetrievePhotoDB("$CONFIG{photo_path}/$DB{username}/$DB{image}", "$CONFIG{ad_url}&action=view_image&cat=$DB{cat}&adid=$DB{adid}&image=1");
	$DB{image_url}= $P{images_url};
	$DB{thumbnail}= $P{thumbnail};
	$DB{date_posted}= &FormatTime($DB{date_create});
	$DB{date_expired}= &FormatTime($DB{date_end});
	return wantarray?%DB:\%DB;
}
############################################################
#								MEMBER DATABASE
#######################################################
############################################################
sub DefineMemberString{
	my ($db, @db, %DB, $string);
	$db = shift;
	%DB = %$db;
	@db = &DefineMemberDB;
	foreach (@db){	$string.= "$DB{$_}|";	}
	return $string;
}
############################################################
sub RetrieveMemberString{
	my ($db, @db, %DB, @lines,  $string);
	$string = shift;
	@lines = split(/\|/, $string);
	@db = &DefineMemberDB;
	for(my $i=0; $i< @db; $i++){		$DB{$db[$i]} = $lines[$i];	}
	return wantarray?%DB:\%DB;
}





############################################################
#										ACCOUNT DATABASE
############################################################
sub DefineAccountDB{
	my(@db);
	@db =("date_create","date_end","ID","name","description","setup_finished",
	"trial_amount","trial_period","trial_time","trial_length",
	"recurring_amount","recurring_period","recurring_time","recurring_length",
	"activation","protected","password_file","email","gateway","recurring",
	"ad_browse", "ad_post", "ad_post_audio", "ad_post_pix", "ad_post_video", "ad_reply", "ad_save", "ad_search", "ad_search_advanced", "ad_view",
	"photo_comment", "photo_upload", "photo_view", "photo_gallery",
	"cupid_search", "mail_new_ad", "mail_notify", "mail_send", "mail_signature", "auto_reply",
	"member_search", "member_search_advanced", "member_view",
	"ad_allowed", "media_allowed", "mailbox_size");
	return wantarray?@db:\@db;
}
############################################################
sub AddAccountDB{
	my(@content,$db, @db, @lines, $filename, %DB);
	($db) = @_;
	%DB = %$db;
	$DB{recurring} = "checked" if ($DB{recurring_amount} or $DB{recurring_time});
	@db = &DefineAccountDB;
	foreach (@db){	push(@content, $DB{$_});	}
	&FileWrite("$CONFIG{account_path}/$DB{ID}/account.pl", \@content);
}
############################################################
sub DeleteAccountDB{
	my ($ID) = &RearrangeParam([ID], @_);
	rmtree("$CONFIG{account_path}/$ID", 0);
}
############################################################
sub RetrieveAccountDB{
	my($db, @db, $line, @lines, $filename, %DB);
	($filename) = @_;
	unless(-f $filename){	$filename = "$CONFIG{account_path}/$filename/account.pl";	}
	return wantarray?%DB:\%DB unless (-f $filename);
	@lines= &FileRead($filename);
	@db = &DefineAccountDB;
	for(my $i=0; $i< @db; $i++){		$DB{$db[$i]} = $lines[$i];	}
	$DB{path} = qq|$CONFIG{account_path}/$DB{ID}|;
	return wantarray?%DB:\%DB;
}
############################################################
sub UpdateAccountDB{
	my(@content, $db, %DB, @db, $filename, %TEMP);
	($db) = @_;
	%DB = %$db;
	$DB{recurring} = "checked" if ($DB{recurring_amount} or $DB{recurring_time});
	$filename = "$CONFIG{account_path}/$DB{ID}/account.pl";
	%TEMP = &RetrieveAccountDB($filename);
    foreach (keys %TEMP){   $DB{$_} = $TEMP{$_} unless ( $DB{$_} eq '0' or defined $DB{$_}); }
	@db = &DefineAccountDB;
	foreach (@db){	push(@content, $DB{$_});	}
	&FileWrite($filename, \@content);
	return wantarray?%DB:\%DB;
}
############################################################
###					ADMIN DATABASES
############################################################
sub DefineAdminDB{	return ("username", "group");		}
############################################################
sub DefineAdminString{
	my($db, @db, %DB,$string);
	($db) = @_;
	%DB = %$db;
	@db = &DefineAdminDB;
	for(my $i=0; $i <@db; $i++){		$string .= "$DB{$db[$i]}|";	}
	return $string;
}
############################################################
sub AddAdminDB{
	my ($db, %DB, %MEM);
	$db = shift;
	%DB = %$db;
	%MEM = &RetrieveMemberDB($DB{username});
	$MEM{position} = $DB{group};
	&UpdateMemberDB(\%MEM);
	return &FileAppend($CONFIG{admin_db}, &DefineAdminString(\%DB));
}
############################################################
sub DeleteAdminDB{
	my(%DB, @content, $line, @lines, %MEM, @tokens);
	my($username) = &RearrangeParam([USERNAME], @_);
	%MEM = &RetrieveMemberDB($username);
	$MEM{position} = "";
	&UpdateMemberDB(\%MEMBER);
	@lines = &FileRead($CONFIG{admin_db});
	foreach $line(@lines){
		%DB = &RetrieveAdminDB($line);
		next if($DB{username} eq $username);
		push (@content, $line);
	}
	return &FileWrite($CONFIG{admin_db}, \@content);
}
############################################################
sub RetrieveAdminDB{
	my(@db, %DB, $string, @tokens);
	$string = shift;
	@lines = split(/\|/, $string);
	@db = &DefineAdminDB;
	for(my $i=0; $i <@db; $i++){		$DB{$db[$i]} = $lines[$i];		}
	return wantarray?%DB:\%DB;
}
############################################################
sub SaveAdminDB{			return &AddAdminDB(@_);					}
############################################################
sub UpdateAdminDB{
	my($db, %DB, @content, $line, @lines, %TEMP, @tokens);
	($db) = @_;
	%DB = %$db;
	@lines = &FileRead($CONFIG{admin_db});
	for(my $i=0; $i <@lines; $i++){
		%TEMP = &RetrieveAdminDB($lines[$i]);
		if($DB{username} eq $TEMP{username}){		$lines[$i] = &DefineAdminString(\%DB);	}
	}
	return &FileWrite($CONFIG{admin_db}, \@lines);
}
############################################################
#										CATEGORIES

############################################################
#										FIELD DATABASE
############################################################
sub DefineFieldDB{
	my(@db) = (
	"ID",	"name","message","type","input_type","input_char","size","max",
	"default","editable","require","searchable","viewable","active","choices");
	return wantarray?@db:\@db;
}
############################################################
sub AddFieldDB{
	my($db, @db, %DB, $filename, $string);
	($filename, $db) = @_;
	%DB = %$db;
	@db = &DefineFieldDB;
	foreach (@db){	$string .= "$DB{$_}";	}
	return &FileAppend($filename, $string);
}
############################################################
sub DeleteFieldDB{
	my(@content, $db, @db, %DB, $id, $filename, $found, @lines,  %TEMP);
	($filename, $id) = @_;
	@db = &DefineFieldDB;
	@lines = &FileRead($filename) if (-f $filename);
	for(my $i=0; $i < @lines; $i++){
		%TEMP = &RetrieveFieldDB($lines[$i]);
		if($TEMP{ID} eq $id){	$found=1; 	}
		else{	push(@content, $lines[$i]);		}
	}
	return &FileWrite($filename, \@content) if $found;
	return 0;
}
############################################################
sub RetrieveFieldDB{
	my(@db, %DB, $string, @tokens);
	$string = shift;
	@tokens = split(/\|/, $string);
	@db = &DefineFieldDB;
	for(my $i=0; $i< @db; $i++){		$DB{$db[$i]} = $tokens[$i];	}
	return wantarray?%DB:\%DB;
}
############################################################
sub RetrieveFieldDBByID{
	my(@db, %DB, @lines, $filename, $id);
	($filename, $id) = @_;
	@lines = &FileRead($filename) if (-f $filename);
	foreach (@lines){
		%DB = &RetrieveFieldDB($_);
		return wantarray?%DB:\%DB if ($DB{ID} eq $id);
	}
	return 0;
}
############################################################
sub UpdateFieldDB{
	my($db, @db, %DB, $filename, $found, @lines,  %TEMP,$item);
	($filename, $db) = @_;
#	&DeleteFieldDB($filename, $db);
#	&AddFieldDB($filename, $db);
#	return 1;
	%DB = %$db;
	@db = &DefineFieldDB;
	@lines = &FileRead($filename) if (-f $filename);
	for(my $i=0; $i < @lines; $i++){
		%TEMP = &RetrieveFieldDB($lines[$i]);
		if($TEMP{ID} eq $DB{ID}){
			$lines[$i] ="";
			foreach $item(@db){ if (defined $DB{$item}) {$lines[$i] .="$DB{$item}|";} else	{$lines[$i].="$TEMP{$item}|";}}
			$found=1;
			last;
		}
	}
	return &FileWrite($filename, \@lines) if $found;
	return 0;
}
############################################################
##					GROUPS PERMISSION DATABASE
############################################################
sub DefineGroupDB{
	my(@db) =(
	"behavior",
	"config",
	"template_email",
	"template_html",

	"account",
	"admin",
#	"affiliate",
	"database",
	"admin_group",
	"member",
#	"protect",
	"security",

	"ads",
	"cat",
#	"file",
	"gateway",
	"mail",
#	"news",
#	"story",
	"utils",
#	"upload"
	);
	return wantarray?@db:\@db;
}
############################################################
sub DefineGroupString{
	my($db, @db, %DB, $group, $string);
	($db) =@_;
	%DB = %$db;
	@db = &DefineGroupDB;
	$string ="$DB{group}|";
	foreach (@db){
		if($DB{$_}){	$string .= "1";	}
		else			 {	$string .= "0";	}
	}
	return $string;
}
############################################################
sub AddGroupDB{ &FileAppend($CONFIG{group_db}, &DefineGroupString(@_));	}
############################################################
sub DeleteGroupDB{
	my(@content,%DB, $group, $line, @lines);
	($group) = &RearrangeParam([GROUP], @_);
	@lines = &FileRead($CONFIG{group_db});
	foreach $line(@lines){
		%DB = &RetrieveGroupDB($line);
		next if ($DB{group} eq $group);
		push(@content, $line);
	}
	return &FileWrite($CONFIG{group_db}, \@content);
}
############################################################
sub RetrieveGroupDB{
	my(@db, %DB, $group, @lines, $string, @tokens);
	($string) = @_;
	($group, $string) = split(/\|/, $string, 2);
	@lines = split(//, $string);
	@db= &DefineGroupDB;
	for(my $i=0; $i< @db; $i++){	$DB{$db[$i]} = $lines[$i];	}
	$DB{group} = $group;
	$DB{string} = $string;
	return wantarray?%DB:\%DB;
}
############################################################
sub RetrieveGroupDBByName{
	my(@db, %DB, $group, @lines, $string, @tokens);
	($group) = @_;
	@lines = &FileRead($CONFIG{group_db});
	foreach $line (@lines){
		@tokens = split(/\|/, $line);
		if($tokens[0] eq $group){	return &RetrieveGroupDB($line);	}
	}
	return wantarray?%DB:\%DB;
}
############################################################
sub SaveGroupDB{ &AddGroupDB(@_);	}
############################################################
sub UpdateGroupDB{
	my($db, @db, %DB, $group, @lines, $string, @tokens);
	($db) =@_;
	%DB = %$db;
	@lines  = &FileRead($CONFIG{group_db});
	for(my $i=0; $i< @lines; $i++){
		@tokens = split(/\|/, $lines[$i]);
		if($tokens[0] eq $DB{group}){	$lines[$i] = &DefineGroupString($db);	}
	}
	return &FileWrite($CONFIG{group_db}, \@lines);
}
############################################################
############################################################
#								PHOTOS
############################################################
sub DefinePhotoDB{
	my(@db)=("ID","username","title","description","width","height","thumbnail");
	return wantarray?@db:\@db;
}
############################################################
sub AddPhotoDB{
	my(@content, $db, @db, %DB, $filename,@lines);
	($filename, $db) = @_;
	%DB = %$db;
	$DB{message} = &OneLine($DB{message});
	$DB{width} = $CONFIG{media_width} unless $DB{width};
	$DB{height} = $CONFIG{media_height} unless $DB{height};
	@db = &DefinePhotoDB;
	foreach (@db){	push(@content, $DB{$_});	}
	&FileWrite($filename, \@content);
}
############################################################
sub RetrievePhotoDB{
	my(%DB, @db, $dir, $ext, @lines, $name, $photo);
	my($photo, $image_url) = @_;
	return \%DB unless (-f $photo);
	my($name, $ext) = &NameAndExt($photo);
	my $dir = &ParentDirectory($photo);
	if(-f "$dir/$name.txt"){
		@lines = &FileRead("$dir/$name.txt");
		@db = &DefinePhotoDB;
		for(my $i=0; $i< @db; $i++){		$DB{$db[$i]} = $lines[$i];	}
	}
	$DB{fullsize_url} = &PathToUrl($photo);
	if(-f "$dir/$DB{thumbnail}"){					$DB{thumbnail_url} = &PathToUrl("$dir/$DB{thumbnail}");	}
	elsif(-f "$dir/mojoscripts_$name.$ext"){	$DB{thumbnail_url} = &PathToUrl("$dir/mojoscripts_$name.$ext");	}
	elsif(-f "$dir/mojoscripts_$name.jpg"){	$DB{thumbnail_url} = &PathToUrl("$dir/mojoscripts_$name.jpg");	}
	else{													$DB{thumbnail_url} = "";	}
###If the caller wants a different big image URL
	if($image_url){	$DB{image_url} = $image_url;	}
	else{		$DB{image_url} = qq|$CONFIG{gallery_url}&gallery=$DB{username}&action=view&file=$name.$ext&cat=$AD{cat}&adid=$AD{adid}|;	}

###Now check whether there is a thumbnail
	if($DB{thumbnail_url}){		$DB{thumbnail} = qq|<a href="$DB{image_url}"><img src="$DB{thumbnail_url}" border=0></a>|;	}
	elsif($DB{width} > $CONFIG{media_width}){$DB{thumbnail} = qq|<a href="$DB{image_url}"><img src="$DB{fullsize_url}" border=0 width="$CONFIG{media_width}"></a>|;	}
	else{	$DB{thumbnail} = qq|<a href="$DB{image_url}"><img src="$DB{fullsize_url}" border=0 width="$DB{width}"></a>|;	}
	$DB{fullsize} = qq|<img src="$DB{fullsize_url}">|;
	return %DB;
}
sub UpdatePhotoDB{	&AddPhotoDB(@_);	}
############################################################
#								RECEIPTS
############################################################
sub DefineReceiptDB{	return ("time", "account", "username", "pincode", "transaction_id", "subscription_id", "gateway");	}
############################################################
sub AddReceiptDB{
	my($string, @db, %DB, $filename);
	($filename, $db) = @_;
	%DB = %$db;
	@db = &DefineReceiptDB;
	foreach (@db){	$string .= "$DB{$_}|";	}
	&FileAppend($filename, $string);
}
############################################################
sub RetrieveReceiptDB{
	my(@db, %DB, @lines, $string);
	$string = shift;
	@lines = split(/\|/, $string);
	@db = &DefineReceiptDB;
	for(my $i=0; $i< @db; $i++){		$DB{$db[$i]} = $lines[$i];	}
	return wantarray?%DB:\%DB;
}
############################################################
#								SESSIONS
############################################################
sub DefineSessionDB{
	my @db = &DefineGroupDB;
	push(@db, "username");
	push(@db, "position");
	return wantarray?@db:\@db;
}
############################################################
sub RetrieveSessionFile{
	my(@db, %DB, @lines, $filename);
	$filename = "$CONFIG{session_path}/$ENV{'REMOTE_ADDR'}";
	return unless (-f $filename);
	@lines = &FileRead($filename);
	@db = &DefineSessionDB;
	for(my $i=0; $i< @db; $i++){		$DB{$db[$i]} = $lines[$i];	}
	return wantarray?%DB:\%DB;
}
############################################################
sub SaveSessionFile{
	my(@content, $db, %DB, @db,$filename);
	($db) = shift;
	%DB = %$db;
	@db = &DefineSessionDB;
	foreach (@db){	push(@content, $DB{$_});	}
	&FileWrite("$CONFIG{session_path}/$ENV{'REMOTE_ADDR'}", \@content);
}
############################################################

1;
