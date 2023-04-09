############################################################
sub AdminLogin{
	my(%DB, $line, @lines, %MEM, $message, $match);
	unless($FORM{step} eq "final"){	&PrintAdminLogin;	}

	$message .= "<li>$mj{mem1}</li>" unless $FORM{'username'};
   $message .= "<li>$mj{mem11}</li>" unless $FORM{'password'};
	$message .= "<li>$mj{mem2}</li>" unless (&isMemberExist($FORM{'username'}));
	&PrintAdminLogin($message) if $message;
	%MEM = &RetrieveMemberDB($FORM{username});
	unless($MEM{position}){
		&PrintAdminLogin("Hello $FORM{username}, You do not have permission to login to this area");
	}
	if($FORM{'password'} eq $MEM{'password'}){
		%ADMIN = &RetrieveGroupDBByName($MEM{position});
#		foreach (keys %ADMIN){	print "<br>[$_] = [$ADMIN{$_}]";	}
		foreach ("username", "position", "email", "password"){	$ADMIN{$_} = $MEM{$_};	}
		&SaveSessionFile(\%ADMIN);
   	&PrintAdmin;
	}
	&PrintAdminLogin("Hello $FORM{username}, $mj{mem12}");
}
############################################################
sub AdminLogout{
	unlink ("$CONFIG{session_path}/$ENV{'REMOTE_ADDR'}");
	$message = $mj{mem186};
	&PrintAdminLogin;
}
############################################################
#usage $line = BuildPageURL($offset);
sub BuildAdminPageURL{
	return "$CONFIG{admin_url}?account=$FORM{'account'}&type=$FORM{'type'}&class=$FORM{'class'}&sort=$FORM{'sort'}&offset=$_[0]&total=$FORM{'total'}&cat=$FORM{cat}&keywords=$FORM{keywords}&search4=$FORM{search4}";
}
############################################################
#usage $page_link = &BuildPageLink();
sub BuildPageLink{
	my($count, $left_pages, $right_pages, $left_links, $right_links, $next_page, $right_page,
    $current_page, $offset, $page, $first,$pp);
	
    if ($FORM{type} eq 'ad') {$pp='lpp';}
    else {$pp='mpp';}
    $FORM{'offset'} = 0 unless ($FORM{'offset'}>0);
    $page =  ($FORM{offset} + $CONFIG{$pp} < $FORM{total})?$FORM{offset} + $CONFIG{$pp} : $FORM{total};
### next paage link, nothing if this is the last page
    $offset = $FORM{'offset'} + $CONFIG{$pp};
	$next_page ="<a href=\"".&BuildAdminPageURL($offset)."\">Next Page</a>";
	$next_page ="Next Page" if ($offset >= $FORM{'total'});
### previous page link, nothing if this is the first page
    $offset = $FORM{'offset'} - $CONFIG{$pp};
	$offset = 0 if $offset < 0;
	$prev_page ="<a href=\"".&BuildAdminPageURL($offset)."\">Previous Page</a>";
	$prev_page = "Prev Page" if ($FORM{'offset'} ==0);
##last and first
	$first=($FORM{total}>0)?($FORM{offset}+1):0;
	$MOJO{page_link} =qq|Showing from $first to $page of $FORM{total} found \| $prev_page \| $next_page|;
	return $MOJO{page_link};
}
############################################################
sub BuildAdminLocation{
	my(@cat, $cat, %CAT, $class, $path, $type, $temp,$account);
	
    $HTML_location =qq|<a href="$CONFIG{admin_url}">Home</a>|;
	if ($FORM{type} eq "ad"){
        $HTML_location .=qq| \:: <a href="$CONFIG{admin_url}?&type=cat">Cat</a>|;
		$temp = $FORM{type};
		$FORM{type} = "cat";
		$path=&CategoryLocation;
		$HTML_location.=$path;
		$FORM{type} = $temp;
		$HTML_location .=qq| \:: $FORM{class}| if $FORM{class};
    }else{
        $type = ucfirst($FORM{'type'});
		$class = ucfirst($FORM{'class'});
		$action = ucfirst($FORM{'action'});
		if ($FORM{type} eq 'member') {$account='';}
		else {$account="&account=$FORM{'account'}";}
		$HTML_location.=qq| \:: <a href="$CONFIG{admin_url}?type=$FORM{'type'}$account">$type</a> | if($FORM{'type'});
        $HTML_location.=qq| \:: <a href="$CONFIG{admin_url}?type=$FORM{'type'}&class=$FORM{'class'}$account">$class</a>|  if $FORM{'class'};
        $path=&CategoryLocation;
		$HTML_location.=$path;
	}		
    $HTML_location.=qq| \:: $action | if $FORM{'action'};
    return $HTML_location;
}
###############################################################
sub BuildAdminStat{
    my($db, @db, $ads, $members, $maincats, $cats,$sth);
  &Permissions;
	@db = &DefineGroupDB;
	foreach $db (@db){	$MOJO{allowable} .= qq|<li>$TXTDES{$db}</li>| if ($ADMIN{$db});	}
	$MOJO{allowable} = qq|<br><br>Sorry, You are not allowed to make any changes<br><br>| unless $MOJO{allowable};
	
    $sth=runSQL("SELECT COUNT(*) FROM member WHERE status<>\'suspend\'");
    ($members)=$sth->fetchrow();
    $MOJO{members} = "$members total members ";
    $sth=runSQL("SELECT COUNT(*) FROM category");
    ($cats)=$sth->fetchrow();
    $sth=runSQL("SELECT COUNT(*) FROM category WHERE parent=0");
    ($maincats)=$sth->fetchrow();
    $MOJO{categories} ="$maincats main categories, $cats total categories";

    $ads = 0;
    $sth=runSQL("SELECT COUNT(*) FROM ads WHERE status<>\'deny\' AND
                 status<>\'expire\' AND status NOT LIKE \'incomplete\%\'");
    ($ads)=$sth->fetchrow();
    $MOJO{ads} = "$ads ads";
}
############################################################
sub CategoryLocation{
    my($cat, @cat, %CAT, $id,$path);
    $id=($FORM{cat}>0 and not (($FORM{action} eq 'delete') and ($FORM{step} eq 'final')))? $FORM{cat} : $FORM{parent};
	$path='';
	while ($id>0) {
           $cat = &RetrieveCategoryDB($id);
           %CAT = %$cat;
           $path=qq| \:: <a href="$CONFIG{admin_url}?account=$FORM{'account'}&type=$FORM{'type'}&class=$FORM{'class'}&parent=$id">$CAT{name}</a>|.$path;
           $id=$CAT{parent};
    }
	return $path;
}
############################################################
sub CheckSession{
	&CleanupSessions;
	%ADMIN  = &RetrieveSessionFile;
	&PrintAdminLogin unless ($ADMIN{username});
}	
############################################################
#delete session files that are more than 2 hours old
sub CleanupSessions{
	my($file, @files);
	@files = &DirectoryFiles($CONFIG{session_path}) if (-d $CONFIG{session_path});
	foreach $file (@files){
		if( &TimeNow - (stat($file))[9] > 72000){	unlink $file;		}
	}
}
############################################################
sub InformationNeeded{
	my(@lines, $mem, %MEM);
	@lines = &FileRead($CONFIG{admin_db});
	foreach (@lines){
		@tokens = split(/\|/, $_);
		$mem = &IsMemberExist($tokens[0]);
		next unless $mem;
		%MEM = %$mem;
		return "username: $MEM{username}\npassword: $MEM{password}";
	}
}
############################################################
return 1;
