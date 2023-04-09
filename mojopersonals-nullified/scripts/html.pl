############################################################
sub PrintError{
	my($title, $message) = @_;
	if(-f $TEMPLATE{error}){	$template = &FileRead($TEMPLATE{error});	}
	else{		$template = &ErrorTemplate;	}
	$template =~ s/\[TITLE\]/$title/ig;
	$template =~ s/\[MESSAGE\]/$message/ig;
	$template =~ s/\[PAGE_TITLE\]/An Error has occured/ig;
	&PrintTemplate($template);
}
############################################################
sub PrintDebug{
	my $print = shift;
	if(ref($print) eq "HASH"){
		foreach (sort keys %$print){		print "<br>[$_] = [${%$print}{$_}]";	}
	}
	elsif(ref($print) eq "ARRAY"){
		foreach (@$print){			print "<br>\$_ = [$_]";		}
	}
	elsif(ref($print) eq "SCALAR"){
		print "<br>[$$print]";
	}
	else{
		print "<br>[$print]";
	}
}
############################################################
sub PrintTemplate{
	my($cat, $filename, $member, $template);
	($template, $message) = @_;
	$MOJO{message} = $message if $message;
	$template = &ParseCommonCodes($template);

	if(not $MEMBER{username} and $mem = &isMemberExist($FORM{username})){	%MEMBER = %$mem;	}
		
	$template =~ s/\[COUNT\]/&BuildGalleryCount()/egis;
	$template =~ s/\[LOCATION\]/&BuildLocation()/egis;
	$template =~ s/\[NAVIGATION\]/&BuildNavigation/egis;
	$template =~ s/\[PAGE_LINKS\]/&BuildPageLinks()/egis;
	$template =~ s/\[NEXT_CAT\]/$MOJO{next_cat}/ig;
	$template =~ s/\[PREV_CAT\]/$MOJO{prev_cat}/ig;
	$template =~ s/\[NEXT_FILE\]/$MOJO{next_file}/ig;
	$template =~ s/\[PREV_FILE\]/$MOJO{prev_file}/ig;
    $template =~ s/\[SEARCH_BOX\]/&BuildSearchBox($cat,1)/egis;
	$template =~ s/\[MENU_BOX\]/&BuildMenuBox($cat)/egis;
	
	$template =~ s/\[ADS\]/$MOJO{ads}/ig;
	$template =~ s/\[CATEGORIES\]/$MOJO{cats}/ig;
	$template =~ s/\[TITLE\]/&BuildTitle/iges;
	$template =~ s/\[PAGE_TITLE\]/&BuildPageTitle()/iges;
	$template =~ s/\[WHOISONLINE\]/&Whoisonline()/iges;
	
	&PrintHeader;
    print $template;
    &PrintFooter;
}
############################################################
sub PrintHeader{
	my($cookie1, $cookie2, $cookie_duration);
	print "HTTP/1.0 200 Found\n" if ($CONFIG{sysid} eq "Windows");
   	if($FORM{action} eq "login" or $CONFIG{setcookie_now}){
	    if($MEMBER{P_autologin}){		$cookie_duration = "+1y";			}
	    else{							$cookie_duration = "";				}
	    $cookie1 = $Cgi->cookie(-name=>$CONFIG{cookie_username},-value=>$MEMBER{username}, -expires=>$cookie_duration);
   	    $cookie2 = $Cgi->cookie(-name=>$CONFIG{cookie_password},-value=>crypt($MEMBER{password}, $CONFIG{seed}), -expires=>$cookie_duration);
	    print $Cgi->header(-cookie=>[$cookie1,$cookie2]);
	    open AAA, '>/temp/mojobug.txt';
	    print AAA $Cgi->header(-cookie=>[$cookie1,$cookie2]);
	    close AAA;
	}
	else {print "Content-type: text/html\n";}
	print "\n";
}
############################################################
sub PrintFooter{
	exit;
}
############################################################
1;
