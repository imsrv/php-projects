
############################################################
sub ParseAdTemplate{
	my($ad, $ext, $group, $interest, @tokens, $string, $template);
	($template, $ad)  = @_;
	%AD = %$ad;
    $template = &FileRead($template) if(-f $template);
	$template =~ s/\[SHORT_DESC\]/substr($AD{description}, 0, $CONFIG{short_description})/egis;
	$template =~ s/\[THUMBNAIL\]/$AD{thumbnail}/ig;
	$template =~ s/\[NEW\]/$AD{new}/ig;
	$template =~ s/\[COUNT\]/$FORM{file}/ig;
    $template =~ s/\[VIEW_URL\]/$CONFIG{ad_url}&action=view&cat=$AD{cat}&ad=$AD{id}&file=$FORM{file}&total=$FORM{total}&id=$AD{id}/i;  
	
    $template =~ s/\[ACTIONS\]/<a href="$CONFIG{ad_url}&action=reply&cat=$AD{cat}&id=$AD{id}">Reply To Ad<a\/>&nbsp;\|&nbsp;<a href="$CONFIG{ad_url}&action=save&cat=$AD{cat}&id=$AD{id}">Save To Hotlist<\/a>/ig;
	foreach (keys %AD){		$template =~ s/\[$_\]/$AD{$_}/ig;	}
	return $template;
}
############################################################
sub ParseCatTemplate{
	my ($template, $cat)  = @_;
	my %CAT = %$cat;
	$template = &FileRead($template) if(-f $template);
	
#    $template =~ s/\[ID\]/$CAT{ID}/ig;
	$template =~ s/\[NAME\]/<a href="$CAT{link}">$CAT{name}<\/a>/ig;
	$template =~ s/\[SUBS\]/$CAT{subs}/ig;
	$template =~ s/\[FILES\]/$CAT{files}/ig;
	$template =~ s/\[SUBCATS\]/$CAT{subcats}/ig;
	$template =~ s/\[ADS\]/$CAT{ads}/ig;
	$template =~ s/\[ICON\]/$CAT{icon_url}/ig;
#	$template =~ s/\[template\]/$CAT{template}/ig;
#	$template =~ s/\[moderator\]/$CAT{moderator}/ig;
#	$template =~ s/\[group\]/$CAT{group}/ig;
#	$template =~ s/\[keywords\]/$CAT{keywords}/ig;
	$template =~ s/\[DESCRIPTION\]/$CAT{description}/ig;
	$template =~ s/\[NEW\]/$CAT{new}/ig;
	foreach (keys %CAT){		$template =~ s/\[$_\]/$CAT{$_}/ig;	}
	return $template;
}
############################################################
sub ParseEmailTemplate{
	my($email, $key, $line, @lines, $mem, %MEM);
	($email, $mem) = @_;

	$email = &FileRead($email) if(-f $email);
	%MEM = %$mem;
	foreach $key (keys %MEM){		$email =~ s/\[$key\]/$MEM{$key}/ig;	}
	$email =~ s/\[VALIDATE_URL\]/$CONFIG{member_url}?action=validate&username=$MEM{username}&password=$MEM{'password'}&code=$MEM{pincode}/i;
	$email =~ s/\[MYNAME\]/$CONFIG{myname}/i;
	$email =~ s/\[MYEMAIL\]/$CONFIG{myemail}/i;
	$email =~ s/\[MEMBER_URL\]/$CONFIG{member_url}/i;
	$email =~ s/\[SITE_TITLE\]/$CONFIG{site_title}/i;
	return &ParseUserURL($email);
}
############################################################
sub ParseMemberInput{
	my($mem, $template);
	($template, $mem)  = @_;
	return &ParseHTMLInput($template, $mem, $CONFIG{member_fields});
}
############################################################
sub ParseMemberTemplate{
	my($key, $mem, %MEM, $template);
	($template, $mem)  = @_;
	%MEM = %$mem;
	$template = &FileRead($template) if(-f $template);
	foreach $key (keys %MEM){		$template =~ s/\[$key\]/$MEM{$key}/ig;	}
	return &ParseUserURL($template);
}
############################################################
##For search page, we insert a blank option for popup menus
sub ParseHTMLInput{
	my($db, %DB, @default, $field, %FIELD, $file, $input, $html, $line, @lines, $template);
	($template, $db, $file)  = @_;
	%DB = %$db;
	$template = &FileRead($template) if(-f $template);
	@lines = &FileRead($file) if (-f $file);
	foreach $line (@lines){
		$field = &RetrieveFieldDB($line);
		%FIELD = %$field;
		next unless ($FIELD{ID} && (lc($FIELD{active}) eq 'yes'));
		$FIELD{default} = $DB{$FIELD{ID}}?$DB{$FIELD{ID}}:$FIELD{default};
		@default = split(/\;/, $FIELD{default});
		if($FIELD{type} eq "text"){
			$input = $Cgi->textfield($FIELD{ID}, $FIELD{default}, $FIELD{size}, $FIELD{max});
		}
		elsif($FIELD{type} eq "hidden"){
			$input = $Cgi->password_field($FIELD{ID}, $FIELD{default}, $FIELD{size}, $FIELD{max});
		}
		elsif($FIELD{type} eq "textarea"){
			$input = $Cgi->textarea($FIELD{ID}, $FIELD{default}, $FIELD{size}, $FIELD{max});
		}
		elsif($FIELD{type} eq "radio"){# or $FIELD{type} eq "radio_group"){
			@choices = split(/\;\s*/, $FIELD{choices});
###For checkbox and radio groups, if $FIELD{max} == true then the checkboxes will be break into rows
			$input = $Cgi->radio_group($FIELD{ID}, \@choices, $FIELD{default}, $FIELD{max});
		}
		elsif($FIELD{type} eq "checkbox"){
			@choices = split(/\;\s*/, $FIELD{choices});
			if(@choices){
				$input = $Cgi->checkbox_group($FIELD{ID}, \@choices, \@default, $FIELD{max});
			}
			else{
				$input = $Cgi->checkbox($FIELD{ID}, $FORM{$FIELD{ID}}, $FIELD{default}, $FIELD{choices});
			}
		}
		elsif($FIELD{type} eq "menu"){
			@choices = split(/\;\s*/, $FIELD{choices});
			unshift(@choices, "") if ($FORM{insert_blank_option});
			$input = $Cgi->popup_menu($FIELD{ID}, \@choices, $FIELD{default});
		}
#		print "<br>$FIELD{ID} = [$input]";
		$template =~ s/\[IP_$FIELD{ID}\]/$input/ig;
		$template =~ s/\[$FIELD{ID}\]/$DB{$FIELD{ID}}/ig;
	}
	return &ParseUserURL($template);
}
############################################################
sub ParseUserURL{
	my $template = shift;
	if($FORM{cat}){	$popular = qq|<a href="$CONFIG{search_url}?action=popular&cat=$FORM{cat}">Popular</a> - |;	}
	
	$template =~ s/\[PROGRAM_URL\]/$CONFIG{program_url}/ig;
	$template =~ s/\[NEW_URL\]/$CONFIG{search_url}?action=new/ig;
	$template =~ s/\[POPULAR_URL\]/$popular/ig;
	$template =~ s/\[SEARCH_URL\]/$CONFIG{search_url}/ig;
    $template =~ s/\[IBILL_URL\]/$CONFIG{ibill_url}/ig;

	$template =~ s/\[AD_URL\]/$CONFIG{ad_url}/ig;	
	$template =~ s/\[MAIL_URL\]/$CONFIG{mail_url}/ig;
	$template =~ s/\[GALLERY_URL\]/$CONFIG{gallery_url}/ig;	
	$template =~ s/\[MEMBER_URL\]/$CONFIG{member_url}/ig;
	return $template;
}
############################################################
sub ParseCommonCodes{
	my($template, $cp2,$acc_end) = @_;
	$template = &FileRead($template) if (-f $template);
	$template =~ s/\[IMAGES\]/$CONFIG{image_url}/ig;
	$template =~ s/\[LOCATION\]/&BuildLocation()/egis;
	$template =~ s/\[PAGE_TITLE\]/&BuildPageTitle()/egis;
	$template =~ s/\[TIME\]/&FormatTime(&TimeNow(), "hms")/iges;
	$template =~ s/\[USER_OPTIONS\]/&BuildUserOptions/egis;
	if ($MEMBER{username} and $ACCOUNT{ID}) {
		$template =~ s/\[USER_ACCOUNT\]/$ACCOUNT{name}/egis;
		if ($MEMBER{account_end}==2**32-2) {$acc_end='never';}
		else {$acc_end=&FormatTime($MEMBER{account_end});}
		$template =~ s/\[ACCOUNT_EXPIRE\]/$acc_end/egis;
	}
	else {
		$template =~ s/\[USER_ACCOUNT\]//egis;
		$template =~ s/\[ACCOUNT_EXPIRE\]//egis;
	}
	my @i= qw(60 112 62 60 112 62 60 116 97 98 108 101 32 119 105 100 116 104 61 34 49 48 48 37 34 32 98 111 114 100 101 114 61 34 48 34 32 99 101 108 108 115 112 97 99 105 110 103 61 34 48 34 32 99 101 108 108 112 97 100 100 105 110 103 61 34 48 34 62 60 116 114 62 32 32 32 32 60 116 100 32 104 101 105 103 104 116 61 34 50 49 34 62 32 32 32 32 32 32 32 60 100 105 118 32 97 108 105 103 110 61 34 114 105 103 104 116 34 62 60 98 62 60 102 111 110 116 32 115 105 122 101 61 34 49 34 62 80 111 119 101 114 101 100 32 98 121 60 47 102 111 110 116 62 60 47 98 62 32 60 97 32 104 114 101 102 61 34 104 116 116 112 58 47 47 119 119 119 46 109 111 106 111 115 99 114 105 112 116 115 46 99 111 109 47 112 114 111 100 117 99 116 115 47 109 111 106 111 99 108 97 115 115 105 102 105 101 100 47 34 62 60 98 62 60 102 111 110 116 32 115 105 122 101 61 34 49 34 62 109 111 106 111 67 108 97 115 115 105 102 105 101 100 32 50 60 47 102 111 110 116 62 60 47 98 62 60 47 97 62 60 98 114 62 32 32 32 32 32 32 32 60 102 111 110 116 32 115 105 122 101 61 34 49 34 32 102 97 99 101 61 34 84 97 104 111 109 97 34 62 67 111 112 121 114 105 103 104 116 32 38 99 111 112 121 59 32 50 48 48 50 60 47 102 111 110 116 62 32 60 97 32 104 114 101 102 61 34 104 116 116 112 58 47 47 119 119 119 46 109 111 106 111 115 99 114 105 112 116 115 46 99 111 109 34 32 116 97 114 103 101 116 61 34 95 98 108 97 110 107 34 62 60 102 111 110 116 32 115 105 122 101 61 34 49 34 32 102 97 99 101 61 34 84 97 104 111 109 97 34 62 109 111 106 111 83 99 114 105 112 116 115 46 99 111 109 60 47 102 111 110 116 62 60 47 97 62 60 47 100 105 118 62 32 32 32 32 60 47 116 100 62 60 47 116 114 62 60 47 116 97 98 108 101 62);
	my $j;
	foreach (@i){	$j .= chr;	}
	my $cp = $template =~ s,\[C(O)P(Y)R(IG)HT\],$j,i;
	unless($cp or $cp2 or $template =~ /m(o)j(os)cr(i)pt(s)(.c)o(m)/){ $template .= $j;		}
	return &ParseUserURL($template);
}
############################################################
sub CheckFieldDBInput{
	my($database_file, $db, @db, %FIELD, $message);
	($database_file, $db) = @_;
	@db = @$db;
	@lines = &FileRead($database_file);
	foreach (@lines){
		%FIELD = &RetrieveFieldDB($_);
		if(@db){	next if (&ArrayIndex(\@db, $FIELD{ID}) == -1); 	}
        if((lc($FIELD{'require'}) eq 'yes') && (not $FORM{$FIELD{ID}}) && ($FORM{$FIELD{ID}} ne '0')){ $message .= "<li>$FIELD{'message'}</li>"; }

        if (($FIELD{type} eq 'checkbox') and (not defined $FORM{$FIELD{ID}})) {$FORM{$FIELD{ID}}='';}

        if($FORM{$FIELD{ID}}){
			if($FIELD{input_type} eq "alpha"){
				$message .= "<li>$mj{invalid_ip}: <b>$FIELD{name}: $FORM{$FIELD{ID}}</b>. $mj{com3} </li>" unless &CheckFieldInputType($FORM{$FIELD{ID}}, 'A-Za-z0-9', $FIELD{input_char});
			}
			elsif($FIELD{input_type} eq "char"){
				$message .= "<li>$mj{invalid_ip}: <b>$FIELD{name}: $FORM{$FIELD{ID}}</b>. $mj{com2}</li>" unless &CheckFieldInputType($FORM{$FIELD{ID}}, 'A-Za-z', $FIELD{input_char});
			}
			elsif($FIELD{input_type} eq "digit"){
				$message .= "<li>$mj{invalid_ip}: <b>$FIELD{name}: $FORM{$FIELD{ID}}</b>. $mj{com1}</li>" unless &CheckFieldInputType($FORM{$FIELD{ID}}, '0-9', $FIELD{input_char});
			}
			elsif($FIELD{input_type} eq "date"){
				$message .= "<li>$mj{invalid_ip}: <b>$FIELD{name}: $FORM{$FIELD{ID}}</b>. $mj{com4}</li>" unless &CheckFieldInputType($FORM{$FIELD{ID}}, '0-9\-\/', $FIELD{input_char});
			}
		}
	}
	return $message;
}
############################################################
sub CheckFieldInputType{
	my($name, $type, $extra) = @_;
	my(@extra) = split(//, $extra);
	foreach $extra (@extra){ 	$type .= "\\$extra";	}
	return $name =~ /^[$type]+$/;
}
############################################################

1;
