############################################################
#				Some security checks
############################################################
sub BanIP{
	return not GoodIP(@_);
}
############################################################
sub GoodDomain{
	my (@good_urls) = @_;
	foreach (@good_urls){	return 1 if ($ENV{'HTTP_REFERER'} =~ /$_/i);	}
	return 1 if ($ENV{'HTTP_REFERER'} =~ /$ENV{HTTP_HOST}/i);
	return 0;                                            
}
############################################################
sub GoodEmail{
	my($domain, @domain, $email, $suffix);
	$email = shift;
	return 0 unless ($email =~ m/^[\w_\.\,\+\*\'\-\#\!&\?\\\$%]+\@[\w\.\-]{2,}\.([a-z]{2,4})$/i);
	$suffix = "\U$1\E";
	@domain= ('AD','AE','AF','AG','AI','AL','AM','AN','AO','AQ','AR','AS','AT','AU','AW','AZ',
'BA','BB','BD','BE','BF','BG','BH','BI','BJ','BM','BN','BO','BR','BS','BT','BV','BW','BY','BZ',
'CA','CC','CF','CG','CH','CI','CK','CL','CM','CN','CO','CR','CS','CU','CV','CX','CY','CZ',
'DE','DJ','DK','DM','DO','DZ','EC','EE','EG','EH','ER','ES','ET',
'FI','FJ','FK','FM','FO','FR','FX',
'GA','GB','GD','GE','GF','GH','GI','GL','GM','GN','GP','GQ','GR','GS','GT','GU','GW','GY',
'HK','HM','HN','HR','HT','HU','ID','IE','IL','IN','IO','IQ','IR','IS','IT','JM','JO','JP',
'KE','KG','KH','KI','KM','KN','KP','KR','KW','KY','KZ',
'LA','LB','LC','LI','LK','LR','LS','LT','LU','LV','LY',
'MA','MC','MD','MG','MH','MK','ML','MM','MN','MO','MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ',
'NA','NC','NE','NF','NG','NI','NL','NO','NP','NR','NT','NU','NZ','OM',
'PA','PE','PF','PG','PH','PK','PL','PM','PN','PR','PT','PW','PY','QA',
'RE','RO','RU','RW','SA','Sb','SC','SD','SE','SG','SH','SI','SJ','SK','SL','SM','SN','SO','SR','ST','SU','SV','SY','SZ',
'TC','TD','TF','TG','TH','TJ','TK','TM','TN','TO','TP','TR','TT','TV','TW','TZ',
'UA','UG','UK','UM','US','UY','UZ','VA','VC','VE','VG','VI','VN','VU','WF','WS','YE','YT','YU','ZA','ZM','ZR','ZW',
'BIZ','COM','EDU','GOV','INFO','INT','MIL','NET','ORG','ARPA','NATO');
	$domain = join(",", @domain);
	return 1 if($domain =~ /$suffix/i);
	return 0;
}
############################################################
sub GoodIP{
	my (@good_ips) = @_;
	foreach (@good_ips){	return 1 if ($ENV{'REMOTE_ADDR'} =~ /$_/i);	}
	return 0;                                            
}
############################################################



############################################################
#					File and Directory
################################################################
sub DirectoryCopy{
	my (@ext, $file, @files, $name);
	my($olddir, $newdir, $ext) = @_;
	mkpath($newdir, 0, 0777) unless (-d $newdir);
	@files = &DirectoryFiles($olddir, $ext);
	foreach $file (@files){
		$name = &LastDirectory($file);
		&FileCopy($file, "$newdir/$name");
		chmod(0777, "$newdir/$name");
	}
	return $#files +1;
}
############################################################
sub DirectoryFiles{
	my ($path, $ext, $ext2, @ext, $file, @files, @filenames, $files_only, $name, $total);
	($path, $ext, $files_only)= @_;
	@ext = @$ext;
	$ext = join(" ", @ext);
	opendir (DIR, $path) or &PrintFatal("$mj{file7}: \'$path\' ", (caller)[1], (caller)[2]);
   @files= grep { !/^\./ && -f "$path/$_" } readdir(DIR);
   closedir (DIR);
	foreach $file(@files){
		($name, $ext2) = &NameAndExt($file);
		next if(@ext and  $ext !~ /$ext2/i);
		if($files_only){	push(@filenames, "$file");		}   
		else{					push(@filenames, "$path/$file");		}
   }
###	@filenames = sort { lc($a) cmp lc($b) }  @filenames;
	return wantarray?@filenames:\@filenames;
}
################################################################
sub DirectorySize{
	my($file, @files,$path, $size);
	@files = &RecursiveDirectoryFiles(@_);
	$size =0;
	foreach $file (@files){		$size += -s $file;	}
	return $size;
}
############################################################
sub FileAppend{
	my ($file, $line)= @_;
	open (FILE,">>$file") or &PrintFatal("$mj{file1}: \'$file\'. Reason $!", (caller)[1], (caller)[2]);
#    flock(FILE, $CONFIG{lsh}) if $CONFIG{flock};
	if(ref($line) eq "SCALAR"){		print FILE $$line."\n";	}
	elsif(ref($line) eq "ARRAY"){			foreach (@$line){ print FILE $_."\n";	}	}
	else{			print FILE $line."\n";		}
#    flock(FILE, $CONFIG{lun}) if $CONFIG{flock};
	close(FILE);
	return chmod(0777, $file);
}
############################################################
sub FileCopy{
	my($oldfile, $newfile, $mode) = @_;
	my @lines = &FileRead($oldfile);
	return &FileWrite($newfile, \@lines, $mode);
}
############################################################
sub FileRead{
	my(@content,$file);
	($file) = @_;
    open (FILE, $file) or return wantarray?@content:join("\n", @content);
###Binary mode for non-text files
	if($file !~ /cgi$|pl$|txt$|lng$/){	binmode FILE;	}
#    flock(FILE, $CONFIG{lsh}) if $CONFIG{flock};
	while(<FILE>){
		chomp;
		push(@content, $_);
	}
#    flock(FILE, $CONFIG{lun}) if $CONFIG{flock};
	close(FILE);
	return wantarray?@content:join("\n", @content);
}
############################################################
sub FileWrite{
	my(@content, $file, $pointer, $mode);
	($file, $pointer, $mode)= @_;
	if($CONFIG{rename}){ open (FILE,">$file.bak") or &PrintFatal("$mj{file3}: \'$file.bak\'. Reason $! ", (caller)[1], (caller)[2]); }
	else{						open (FILE,">$file")     or &PrintFatal("$mj{file3}: \'$file\'. Reason $! ", (caller)[1], (caller)[2]);	}
#    flock(FILE, $CONFIG{lex}) if $CONFIG{flock};
	if($mode =~ /bin/i or $file !~ /cgi$|pl$|txt$|lng$/){	binmode FILE;	}
	if(ref($pointer) eq "SCALAR"){		print FILE $$pointer."\n";	}
	elsif(ref($pointer) eq "ARRAY"){		foreach (@$pointer){		print FILE $_."\n";	}	}
	elsif(ref($pointer) eq "HASH"){		foreach (keys %$pointer){	print FILE "$_=qq|${%$pointer}{$_}|;";	}}
	else{											print FILE $pointer."\n";	}
	
#    flock(FILE, $CONFIG{lun}) if $CONFIG{flock};
	close(FILE);
	chmod(0777, $file);
	if($CONFIG{rename}){
		if(rename("$file.bak", $file)){	return 1;	}
		else{	return -1;	}
	}
}
############################################################
sub isWritable{
	my($dir, $file);
	$dir = shift;
	return 0 unless (-d $dir);
	$file = "$dir/mojoscripts.com.txt";
	unlink $file;
	open(FILE, ">$file") or return 0;
	print FILE "mojoscripts.com is testing to see if this directory is writeable";
	close(FILE);
	return 0 unless (-s $file);
	unlink $file;
	return 1;
}
############################################################
sub NameAndExt{
	my($name, $ext);
	$name = shift;
	$name =~ s/\\/\//g;
	$name = &LastDirectory($name);
	$ext = substr($name, rindex($name, '.')+1);
	$name =~ s/$ext$//;
	$name =~ s/\.+$//;
	return ($name, $ext);
}
############################################################
sub LastDirectory {
	my($dir, @tokens);
   $dir = shift;
   @tokens= split (/\//, $dir);
   return pop @tokens;	
}
############################################################
sub ParentDirectory {
	my($dir, @tokens);
   $dir = shift;
   @tokens= split (/\//, $dir);
   pop @tokens;
   return join('/', @tokens);
}
############################################################
sub ReadRemoteFile{
	my($buffer, $bytesread,$content,$good, $max_size, $remote_file,$size);
	($remote_file, $max_size) = @_;
	return 0 unless $remote_file;
	while($bytesread=read($remote_file,$buffer,1024)){
		$content .= $buffer;
		$size += length($buffer);
		if($max_size and ($max_size < $size)){	return -1;	}
	}
	return \$content;
}
############################################################
sub RecursiveDirectoryFiles{
	my ($path, @dirs, $ext, @files, @filenames, $files_only);
	($path, $ext, $files_only)= @_;
	return 0 unless (-d $path);
	@dirs  = &RecursiveSubdirectories($path);
	foreach (@dirs){
		@files = &DirectoryFiles($_, $ext);
		foreach (@files){
			if($files_only){	push(@filenames, &LastDirectory($_));		}
			else{					push(@filenames, $_);		}
		}
	}
	return wantarray?@filenames:\@filenames;
}
############################################################
sub RecursiveDirectoryCopy{
	my($old_dir, $new_dir, $ext) = @_;
	my @dirs = &RecursiveSubdirectories($old_dir);
	foreach my $dir(@dirs){
		($new_path = $dir) =~ s/$old_dir/$new_dir/;
		&DirectoryCopy($dir, $new_path);
	}
}
############################################################
sub RecursiveSubdirectories{
	my($dir, @dirs, $dir_name_only, $path, $total, @temp);
	($path, $dir_name_only)= @_;
	return unless (-d $path);
	push(@dirs,$path);
	for (my $i=0; $i< @dirs; $i++){
   	@temp = &Subdirectories($dirs[$i]);	
   	foreach (@temp){
			if($dir_name_only){	push(@dirs, &LastDirectory($_));		}
			else{						push(@dirs, $_);	}
		}
   }
###	@dirs = sort{ lc($a) cmp lc($b)} @dirs;
	return wantarray?@dirs:\@dirs;
}
############################################################
sub Subdirectories{
	my($dir, @dirs, $dir_name_only, $path, @subdirs, $total);
	($path, $dir_name_only)= @_;
   opendir (DIR, $path) or return 0;
   @dirs= grep { !/^\./ && -d "$path/$_" } readdir(DIR);
   closedir (DIR);
   @subdirs=();
	foreach (@dirs){
		if($dir_name_only){	push(@subdirs, $_);				}
		else{						push(@subdirs, "$path/$_");	}
	}
###	@dirs = sort{ lc($a) cmp lc($b)} @dirs;
	return wantarray?@subdirs:\@subdirs;
}
############################################################
#							Input / Output
#				
############################################################
sub ParseForm {
	my ($buffer, $name, @pairs, $query, @queries, $value, $type);
## if($ENV{'CONTENT_TYPE'} =~ m!multipart/form-data!i){;
	if(1){
		$Cgi = new CGI unless $Cgi{mojoscripts_created};
		@queries = $Cgi->param();
		foreach (@queries){	$FORM{$_} = $Cgi->param($_);	}
	}
	else{
		if(lc($ENV{'REQUEST_METHOD'}) eq "get"){	$buffer= $ENV{'QUERY_STRING'};	}
		else{			read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});}
		@pairs= split(/&/, $buffer);
		foreach (@pairs) {
			($name, $value) = split(/=/, $_, 2);
			$value=~ s/\+/ /g;
      	# Convert %XX from hex numbers to alphanumeric
      	$name  =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;
      	$value =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;
	
   	   # Associate key and value \0 is the multiple separator
   	   $value .= "\0" if (defined $FORM{$name});
   	  	$FORM{$name} .= $value;
#			if($ENV{$check} and $ENV{$check} !~ /$client/i){	print "Location:$host\n\n"; }
		}
	}
}
############################################################
sub PathToUrl{
	my($domain, $path,$port, $root, $url);
	$path = shift;
#	&PrintHeader;
#	print "<br>path is [$path] config is [$CONFIG{document_root}][$FORM{document_root}]<br>";
	return $path if ($path =~ /http:\/\//);
	$path =~ s/$CONFIG{document_root}//;
#	print "<br>path after is [$path]<br>";
	$root = ($ENV{PATH_TRANSLATED})?$ENV{PATH_TRANSLATED}:$ENV{SCRIPT_FILENAME};
	$root =~ s/\\/\//g;
	$root =~ s/$ENV{SCRIPT_NAME}//i;
###remove the based path	
	$path =~ s/$root//;
	$path =~ s/$ENV{'DOCUMENT_ROOT'}//ig;
	$port = ($ENV{'SERVER_PORT'} == 80)?"":":$ENV{'SERVER_PORT'}";
#	print "<br>URL is [http://$ENV{'SERVER_NAME'}][$port][$path]<br>";
	if($ENV{HTTP_HOST}){	return "http://$ENV{'HTTP_HOST'}$port$path";	}
	else{						return "http://$ENV{SERVER_NAME}$port$path";	}
}
############################################################
sub UrlToPath{
	my($domain, $path, $root, $url);
	$url = shift;
	return $url unless ($url =~ /^http:\/\//);
	$url =~ s/http:\/\///g;
	$url =~ s/$ENV{'HTTP_HOST'}//g;
	$url =~ s/$ENV{SERVER_NAME}//g;
	$path = "$CONFIG{document_root}/$url";
	return $path if (-e $path);
	$root = ($ENV{PATH_TRANSLATED})?$ENV{PATH_TRANSLATED}:$ENV{SCRIPT_FILENAME};
	$root =~ s/\\/\//g;
	$root =~ s/$ENV{SCRIPT_NAME}//;
	$path = "$root/$url";
	return $path if (-e $path);
	&PrintFatal("Cannot convert a HTTP address, $url, into a path. The convertion routine converts to $path, but this is an unexisting directory.", (caller)[1], (caller)[2]);
}
sub MojoText{	$_=qq|\n\nP_o=_w=_e_r_e_d B_=y h_t_t_p:_/_/w_=w_w_.m_o_=j_o_s_=c_r_i_=p_t_s_._c_o_m_|; s/[_=+-]//g;	return $_;}
sub MojoLink{	$_=qq|<_b_r><ce_n-ter>P_o_w_e_r_e-d+b-y++<-a+hr-ef="h-t-t-p:_/-/m_o_j_o-s-o-_f-t_.-n-e_t">-m-o-j-o-S-c-r-i-p-t-s.c-o-m-<-/-a>-</ce-nt-er>|; 	s/[_-]//g;	s/\+/ /g; return $_;}
############################################################
############################################################
#					Mail Routine
#
############################################################
sub SendMail  {
	my($error);
	my ($from, $reply, $to, $subject, $message, $mail_type) = @_;
### pack spaces and add comma
   $to =~ s/[ \t]+/, /g;
### get from email address
	$from =~ s/.*<([^\s]*?)>/$1/;
### get reply email address
   $reply =~ s/.*<([^\s]*?)>/$1/;
### use first address
   $reply =~ s/^([^\s]+).*/$1/;
### handle . as first character
   $message =~ s/^\./\.\./gm;
### handle line ending
   $message =~ s/\r\n/\n/g;
   $message =~ s/\n/\r\n/g;
### remove spaces around $smtp
   $CONFIG{smtp_server} =~ s/^\s+//g;
   $CONFIG{smtp_server} =~ s/\s+$//g;
	return "Recipient email address is empty" unless($to);
	return "Message body is empty" unless($message);
	if($CONFIG{sendmail}){
		open (MAIL, "|$CONFIG{sendmail} -t")   || return  "Cannot start Unix sendmail program: $CONFIG{sendmail}";
		if($mail_type or $CONFIG{mail_type} eq "html"){
			print MAIL "Content-Type: text/html\n";
			$message .= "<br><br><br><br><br>".&MojoLink;
		}
		else{	$message .= "\n\n\n\n\n".&MojoText;	}
		print MAIL "Return-path:$reply\n";
		print MAIL "To: $to\n";
   	print MAIL "From: $reply\n";
   	print MAIL "Reply-to: $reply\n";
   	print MAIL "X-Mailer: mojoScripts.com Powered Socket Mailer\n";
		print MAIL "X-Authentication-Warning: Not Spam. Intended for $CONFIG{site_title}'s members only\n";
		print MAIL "MIME-Version: 1.0\n";
   	print MAIL "Subject: $subject\n\n";
   	print MAIL "$message \n\n";
		close(MAIL);
	}
	elsif ($CONFIG{smtp_server}){
		$error = &SMTPConnect($CONFIG{smtp_server});
		return $error if $error;
		$error = &SMTPSend($from, $reply, $to, $subject, $message, $html_on);
		return $error if $error;
		&SMTPDisconnect;
  	}
	else{		return "Sendmail and SMTP server are missing. Please reinstall your program";	}
   return 1;
}
############################################################
sub SMTPConnect{
	my($max_try, $max_try2, $remote_address, $paddr, $response, $mydomain, $smtp_server, $smtp_port);
	use Socket;
	$smtp_server = shift;
	$smtp_port = 25;
	$max_try2 = $max_try = 3;
	while(! socket(MAIL, PF_INET, SOCK_STREAM, getprotobyname('tcp')) && $max_try > 0){	$max_try--;	}
	return qq|Unable to create socket| unless $max_try;	
	$remote_address = inet_aton($smtp_server);
	$paddr = sockaddr_in($smtp_port, $remote_address);
	while(! connect(MAIL, $paddr) && $max_try2 > 0){		$max_try2--;	}
	return qq|Unable to connect to Smtp server <b>$smtp_server</b>.  Maybe you have specified an invalid hostname or your server is temperarily down. Please wait a couple minutes and try again.| unless $max_try2;
	
	
	select((select(MAIL), $| = 1)[0]);
	$response = <MAIL>;
	return qq|No response from the server: $response| unless $response or $response =~ /^[45]/;

	$mydomain = $ENV{HTTP_HOST};
#	$mydomain =~ s/.+\@//;
	
	print MAIL "HELO $mydomain\015\012";
	$response = <MAIL>;
	return qq|Server wont say hello: $response| unless $response or $response =~ /^[45]/;
	return 0;
}
############################################################
sub SMTPSend{
	my($response);
	my($from, $reply, $to, $subject, $message, $html_on) =@_;
	print MAIL "RSET\015\012";
	$response = <MAIL>;
	return qq|Unable to reset connection. Please try again later| if ! $response || $response =~ /^[45]/;
	if ($response =~ /^221/){
		close(MAIL); 
		return qq|Server disconnected: $response|;
	}

	print MAIL "MAIL FROM:<$from>\015\012";
	$response = <MAIL>;
	return qq|Invalid Sender.  Make sure that you have specified a valid email address and that you have access to the SMTP server.| unless $response or $response =~ /^[45]/;
	if ($response =~ /^221/){
		close(MAIL); 
		return qq|Server disconnected: $response|;
	}

	print MAIL "RCPT TO:<$to>\015\012";
	$response = <MAIL>;
	return qq|Invalid Recipient: <b>$to<b><BR>$response<BR>Maybe you dont have access to this mail server or maybe the recipient email address is an invalid email address.| if ! $response || $response =~ /^[45]/;
	if ($response =~ /^221/){
		close(MAIL); 
		return qq|Server disconnected: $response|;
	}

###Let the server know we're gonna start sending data
	print MAIL "DATA\015\012";
	$response = <MAIL>;
	return qq|Server Not ready to accept data: $response<BR>  Please try again.| if ! $response || $response =~ /^[45]/;
	if ($response =~ /^221/){
		close(MAIL); 
		return qq|Server disconnected: $response|;
	}
	if($html_on or $CONFIG{mail_type} eq "html"){
		print MAIL "Content-Type: text/html\n";
		$message .= "<br><br><br><br><br>".&MojoLink;
	}
	else{	$message .= "\n\n\n\n\n".&MojoText;	}
	print MAIL "To: $to\r\n";
	print MAIL "From: \"$from\r\n";
	print MAIL "Reply-to: \"$reply\r\n";
	print MAIL "Subject: $subject\r\n\r\n";
	print MAIL "$message \r\n.\r\n";

	$response = <MAIL>;
	return 0 if ! $response || $response =~ /^[45]/;
	if ($response =~ /^221/){
		close(MAIL); 
		return qq|Server disconnected: $response|;
	}
	return 0;
}
############################################################
sub SMTPDisconnect {
	print MAIL "quit";
	close(MAIL);
}

############################################################
#					I/O DISPLAY
############################################################
sub ConvertFromForm{		my $mj = shift;	$mj =~ s/\n/<br>/g;	return $mj;}
############################################################
sub ConvertFromHTML{
	my $mj = shift;
#	$mj =~ s/&/&amp;/g;
	$mj =~ s/"/&quot;/g;
	$mj =~ s/  / \&nbsp;/g;
	$mj =~ s/</&lt;/g;
	$mj =~ s/>/&gt;/g;
	$mj =~ s/\|/\&#124;/g;
	$mj =~ s~\t~ \&nbsp; \&nbsp; \&nbsp;~g;
	return $mj;
}
############################################################
sub ConvertToForm{	my $mj = shift;	$mj =~ s/<br>/\n/g;	return $mj;		}
############################################################
sub ConvertToHTML{
	my $mj = shift;
	$mj =~ s/&amp;/&/gm;
	$mj =~ s/&quot;/"/g;
	$mj =~ s/&nbsp;/ /g;
	$mj =~ s/&lt;/</gm;
	$mj =~ s/&gt;/>/gm;
	$mj =~ s/&#124;/\|/g;
	$mj =~ s~\t~ \&nbsp; \&nbsp; \&nbsp;~g;
	return $mj;
}
############################################################
sub Encode{
	my $mj = shift;
	$mj =~ s/\?/\%3F/g;
	$mj =~ s/\&/\%26/g;
	$mj =~ s/\=/\%3D/g;
	$mj =~ s/\@/\%40/g;
	return $mj;
}
sub Decode{
	my $mj = shift;
	$mj =~ s/\%3F/\?/g;
	$mj =~ s/\%26/\&/g;
	$mj =~ s/\%3D/\=/g;
	$mj =~ s/\%40/\@/g;
	return $mj;
}
############################################################
sub FormatDisplay{
 	my $mj= shift;
   $mj =~s/_/ /g; 
   $mj =~s,/, > ,g;
	$mj =~s/([A-Z])/ $1/g;
	return $mj;
}
############################################################
sub FormatSize{
	my($size, $style) = @_;
	if(lc($style) eq "mb"){	return 	sprintf("%2d", $size/1048576);}
	else{	return	sprintf("%2d", $size/1024);		}
}
############################################################
#$sec, $min, $hour, $day, $months[$mon], $year, $weekdays[$dweek], $dyear, $tz, $AMPM
# 0     1      2     3      4               5        6                7      8    9
sub FormatTime{
	my(%DEF, $style, $string, $time, @t);
	($time, $style) = @_;
	$time = &TimeNow unless $time;
   my ($sec, $min, $hour, $day, $mon, $year, $dweek, $dyear, $tz)= localtime $time;
	$sec = "0".$sec if $sec <10;
	$min = "0".$min if $min <10;
	$hour = "0".$hour if $hour <10;
	$day = "0". $day if $day <10;
	$month = $mon + 1;
	if($hour >12){ $hour = $hour - 12; $AMPM = "PM";}
	else{		$AMPM= "AM";	}
   $year += 1900;
#   return($sec, $min, $hour, $day, $months[$mon], $year, $weekdays[$dweek], $dyear, $tz, $AMPM);
	%DEF=(s=>$sec, m=>$min, h=>$hour, d=>$day, mt=>$months[$mon],mo=>$month, y=>$year,w=>$weekdays[$dweek], dy=>$dyear, tz=>$tz, am=>$AMPM);
	@t = split(/;/, $style);
	foreach (@t){
		if($DEF{$_}){	$string .= "$DEF{$_}";	}
		else{				$string .= "$_";			}
	}
	return $string?$string:"$month/$day/$year";
}
############################################################
sub OneLine{	$_ = shift;	s/\n/<br>/g;	return $_;		}
sub TimeNow{	$Time = time unless $Time; return $Time;	}
############################################################
#				Some Utilies
############################################################
sub ArrayIndex{
	my($db, $name) = @_;
	for(my $i=0; $i < @$db; $i++){	return $i if ${@$db}[$i] eq $name;	}
	return -1;
}
############################################################
sub RemoveArrayElement{
	my($db, $name) = @_; 
	my @content = ();
	for(my $i=0; $i < @$db; $i++){	if(${@$db}[$i] ne $name){	push(@content, ${@$db}[$i]);	}	}
	return @content;
}
############################################################
sub RandomCharacters{
	my(@chars, $length, $string);
	$length = shift;
	srand();
	@chars = ('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	for(my $i=0; $i<$length; $i++){	$string .= $chars[int(rand(62))];	}
	return $string;
}
############################################################
sub PrintFatal{
	my($time, $error, $reason, $filename, $line);
	($error, $filename, $line) = @_;
	$filename =~ s/$CONFIG{document_root}//;
	$error=~ s/$CONFIG{document_root}//;
	if(-f $CONFIG{log_error} and -d $CONFIG{log_path}){
		$time = &TimeNow;
		&FileAppend("$CONFIG{log_path}/errors.log", "$time|$ENV{'HTTP_REFERER'}|$error|$filename|$line");
	}
	$error .= " called by file \'$filename\'" if $filename;
	$error .= " at line \'$line\'" if $line;
	$error .= ".";
	print "content-type:text/html\n\n";
	print qq|
	<html>
<head>
<title>FATAL ERROR: $mj{program} $mj{version}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
	<br><br><br><br><br>
<table width="636" border="2" cellspacing="0" cellpadding="5" align="center" bordercolor="#3399CC">
  <tr> 
    <td bgcolor="#003366" height="21"><b><font color="#FFFFFF">Oops... we have 
      encountered an error processing your request!</font></b></td>
  </tr>
  <tr> 
    <td height="138"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
        <tr> 
          <td height="135"> 
            <div align="left"><font color="#000000" face="Tahoma" size="2">We 
              have encountered an error while you were using our system. The error 
              was<br>
              <font color="#FF0000"><b>$error</b></font><br>
              <br>
              The error has been logged and will be reviewed by our technical 
              support staff. Please press the &quot;Return&quot; button below 
              if you wish us to process your request again, or click the link 
              below to get back to our main site</font><font color="#000000"><br>
              <div align=center><a href="$CONFIG{program_url}">Main page</a></div>
              </font></div>
          </td>
        </tr>
        <tr> 
          <td height="2"> 
            <form id=form1 name=form1>
              <div align="center"> 
                <input type="button" value="<-- Return" onclick="window.history.go(-1)" id=button1 name=mojoscripts>
              </div>
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="2" bgcolor="#003063"> 
      <div align="center"><font face="Tahoma" size="1"><b><font size="2" color="#FFFFFF">Script 
        powered by</font><font size="2"> <a href="http://www.mojoscripts.com/products/"><font color="#FFFFFF">$mj{program} 
        $mj{version}</font></a></font></b></font><br>
        <font size="1" face="Tahoma"><b><font color="#FFFFFF">copyright &copy; 
        2002</font> <a href="http://www.mojoscripts.com"><font color="#FFFFFF">mojoscripts.com</font></a></b></font></div>
    </td>
  </tr>
</table>
<br>
<br><br><br>
</body>
</html>
	|;
	exit;
}
############################################################
############################################################














############################################################
##First ID is the name for the select
##name is the value of the option that is to be selected
sub BuildImageSelection{
	my(@icons,$html,$list,@lists, $image_name, $path, $default, $url, $select_name, $js_tag_name);
	($url, $image_name, $select_name, $js_tag_name, $path) = @_;
	$select_name = "icon" unless $select_name;
	$js_tag_name = "selected_icon" unless $js_tag_name;
	$image_name = "blank.gif" unless $image_name;
	$path = &UrlToPath($url) unless $path;
	$list = &DirectoryFiles($path, ['gif', 'jpg', 'jpeg', 'png']);
	@lists = @$list;
	$html =qq|
	<script language="JavaScript1.2" type="text/javascript">
   function showimage(form){
   	document.images.$js_tag_name.src="$url/"+document.mojo.$select_name.options[document.mojo.$select_name.selectedIndex].value;
   }
   </script>
	<select name="$select_name" onChange="showimage()">|;
	foreach $list(@lists){
		$list =~ s/$path\///g;
		if($list eq $image_name){
	   	$html .= qq|<option value="$list" selected> - $list</option>|;
		}
		else{
			$html .= qq|<option value="$list"> - $list</option>|;
		}
	}
	$html .= qq|</select><br><img src="$url/$image_name" name="$js_tag_name" border=0>|;
	return $html;
}
############################################################
1;
