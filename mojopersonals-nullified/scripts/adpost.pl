
############################################################
sub AdPost{
#	&PrintHeader;
	$FORM{action} = "post" unless $FORM{action};

	if(($FORM{action} eq "post") && ($MEMBER{ad_allowed} - $MEMBER{ad_used}) <= 0 ){
		$FORM{action} = $FORM{error} = 1;
        &PrintAdCenter(qq|Sorry, you can only post <b>$MEMBER{ad_allowed}</b> personal ads in the system, and you have used all available credit. All your personal ads will remain online until either they expire or you delete them. To post a new ad, please delete the ads you no longer need and try again.</font>|);
	}
    elsif($FORM{'step'} eq "0"){        &AdPost0;   }
    elsif($FORM{'step'} eq "1"){        &AdPost1;   }
	elsif($FORM{'step'} eq "2"){		&AdPost2;	}
	elsif($FORM{'step'} eq "3"){		&AdPost3;	}
	elsif($FORM{'step'} eq "4"){		&AdPost4;
		if($FORM{submit}){		&PrintAdPost5;	}
		else{							&PrintAdPost4;	}
	}
	elsif($FORM{'step'} eq "5" or $FORM{'step'} eq "final"){
		&AdPost5;
		&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{email}, $SUBJECT{ad_posted}, &ParseEmailTemplate($EMAIL{ad_posted}, \%MEMBER));
		&PrintAdCenter("Your ad has been posted");
	}
    else{       &AdPost0;          }
}
############################################################
sub AdPost0{
    my(%DB, $message, @temp,$newid);   
	if($FORM{submit}){
		my %TEMP = %FORM;
        $FORM{cat} = $Cgi->param(cat);
        $FORM{oldcat} = $Cgi->param(oldcat);
		if($FORM{action} eq "edit"){
			$FORM{updated} = $CONFIG{systemtime};
		  	&UpdateAdDB(\%FORM);
			%FORM = %TEMP;
		}
#    if (($FORM{oldcat}>0) && ($FORM{oldcat} != $FORM{cat})){
#             @cats=&GetParentCatsList($FORM{oldcat});
#             @cats=map("id=$_",@cats);
#             $cats=join(' OR ',@cats);
#             $sth=runSQL("UPDATE category SET ads=ads-1 WHERE $cats");
#        }
        &PrintAdPost1;
	}
    else{
		 if(($FORM{action} eq "edit") and (not defined $FORM{inside})){
			 $newid=&CopyAd($FORM{id});
			 $FORM{status}="incomplete\|$FORM{id}";
			 $FORM{id}=$newid;
		 }
		else {$FORM{status} = "incomplete";}
        &PrintAdPost0;
	}
}
############################################################
sub AdPost1{
	my(%DB, $message, @temp);	
	if($FORM{submit}){
		$message = &CheckAdInput1;
		&PrintAdPost1($message) if $message;
		my %TEMP = %FORM;
#		$FORM{status} = "incomplete";
		@temp = $Cgi->param(relationship);
		$FORM{relationship} = join(" &#183; ", @temp);
		@temp = $Cgi->param(interests);
		$FORM{interests} = join(" &#183; ", @temp);
		@temp = $Cgi->param(groups);
		$FORM{groups} = join(" &#183; ", @temp);
		$FORM{username} = $MEMBER{username};
		if($FORM{action} eq "edit"){
			$FORM{updated} = $CONFIG{systemtime};
			&UpdateAdDB(\%FORM);
			%FORM = %TEMP;
		}
		else{
			%FORM = &AddAdDB(\%FORM);
			$MEMBER{ad_used}++;
			&UpdateMemberDB(\%MEMBER);		
		}
		&PrintAdPost2;
	}
	else{	&PrintAdPost1;	}
}
############################################################
sub AdPost2{
	my($message);
	if($FORM{submit}){
		$message = &CheckAdInput2;
		&PrintAdPost2($message) if $message;
#		$FORM{status} = "incomplete";
		$FORM{title}= &ConvertToHTML($FORM{title});
		$FORM{description}= &OneLine(&ConvertToHTML($FORM{description}));
		&UpdateAdDB(\%FORM);
		&PrintAdPost3;
	}
	else{	&PrintAdPost2;	}
}
############################################################
sub AdPost3{
	my($message);
	if($FORM{submit}){
		$message = &CheckAdInput3;
		&PrintAdPost3($message) if $message;
#		$FORM{status} = "incomplete";
		&UpdateAdDB(\%FORM);
###if the member account does not allow post pictures, then skip this part
		if(defined $ACCOUNT{ad_post_pix} and not $ACCOUNT{ad_post_pix}){	&PrintAdPost5;	}
		else{		&PrintAdPost4;	}
	}
	else{	&PrintAdPost3;	}
}
############################################################
sub AdPost4{
	my(%DB, $content, $ext, $filename, $name, $message, %PHOTO);
	if($FORM{submit} or $FORM{preview}){
		if($FORM{file}){
##Check for rigth image extensions
			if($MEMBER{media_allowed} - $MEMBER{media_used} <= 0){
				&PrintAdPost4("You have used all your available upload credit. Please delete some unwanted images from your gallery and continue");
			}
			($name, $ext) = &NameAndExt($FORM{file});
			&PrintAdPost4("Invalid Image extensions: $ext") unless ($CONFIG{media_ext} =~ /$ext/i);
			$content = &ReadRemoteFile($FORM{file});
			&PrintAdPost4("Image size exceeds maximum file size allowed: $CONFIG{media_size} bytes") if ($content == -1);
			$filename = "$CONFIG{photo_path}/$MEMBER{username}/$name.$ext";
			&PrintAdPost4("Image name already exists. Please select another file") if (-f "$filename");
			mkpath("$CONFIG{photo_path}/$MEMBER{username}", 0, 0777) unless (-d "$CONFIG{photo_path}/$MEMBER{username}");
			
			&FileWrite($filename, $content, "binary");
			$FORM{image} = "$name.$ext";
			
			$MEMBER{media_used}++;
			&UpdateMemberDB(\%MEMBER);
###Create the thumbnail and write a image description			
			require "images.pl";
			%PHOTO = &Thumbnail($filename, $CONFIG{media_width},$CONFIG{media_height});
			$PHOTO{username} = $MEMBER{username};
			&AddPhotoDB("$CONFIG{photo_path}/$MEMBER{username}/$name.txt",\%PHOTO);
		}
		elsif($FORM{mojochecklist}){
			$FORM{image} = $FORM{mojochecklist};
			
		}
		
#		$FORM{status} = "incomplete";
		&UpdateAdDB(\%FORM);
###If the user want to preview his uploaded images, then load the preview		
		if($FORM{preview}){	&PrintAdPost4;	}
		else{						&PrintAdPost5;	}
	}
	else{	&PrintAdPost4;	}
}
############################################################
sub AdPost5{
	my($ad, %AD, $message,@cats,$cats,$sth);
	if($FORM{submit}){
        %AD = &RetrieveAdDB($FORM{id});
		foreach (keys %AD){	$FORM{$_} = $AD{$_} unless defined $FORM{$_};	}
		$message = &CheckAdInput1;
		&PrintAdPost1($message) if $message;
		$message = &CheckAdInput2;
		&PrintAdPost2($message) if $message;

		@status=split(/\|/,$AD{status});
		if (@status[1]>0) {
			&DeleteAdDB($FORM{id});
		    $FORM{id}=@status[1];
		}
###Check to see if manualy ad approval is selected
		if(lc($CONFIG{ad_type}) eq "pending"){	$FORM{status} = "pending";		}
		else{ 									$FORM{status} = "active";		}
###Check to see if new ad notification is chosen (for ad posting)
		if($CONFIG{ad_notify}){
			&SendMail("$MEMBER{fname} $MEMBER{lname}", $MEMBER{email}, $CONFIG{ad_notify}, "New ad posted", &NewAdTemplate(\%AD), 1);
		}
		&UpdateAdDB(\%FORM);
		$FORM{action} = "";
		print "Location:$CONFIG{ad_url}\n\n";
	}
	else{	&PrintAdPost5;	}
}
############################################################
sub PrintAdPost0{       &PrintAdCenter(&BuildAdPost0(@_));      }
sub PrintAdPost1{		&PrintAdCenter(&BuildAdPost1(@_));		}
sub PrintAdPost2{		&PrintAdCenter(&BuildAdPost2(@_));		}
sub PrintAdPost3{		&PrintAdCenter(&BuildAdPost3(@_));		}
sub PrintAdPost4{		&PrintAdCenter(&BuildAdPost4(@_));		}
sub PrintAdPost5{		&PrintAdCenter(&BuildAdPost5(@_));		}
############################################################
sub BuildAdPost0{
	my($ad, %AD, $message, $template);
	($message, $template) = @_;
    $template = (-f $template)?$template:$TEMPLATE{post0};
	$message = &ErrorTemplate($message) if $message;
    %AD = &RetrieveAdDB($FORM{id}) if ($FORM{id});
	foreach (keys %AD){	$FORM{$_} = $AD{$_} unless defined $FORM{$_};	}
###set up the checkbox so that selected fields will be chosen
	$template = &ParseHTMLInput($template, \%FORM, $CONFIG{ad_fields});
    $template =~ s/\[HIDDEN_FIELDS\]/&BuildAdHiddenFields(0)/e;
    $template =~ s/\[CATEGORIES\]/&BuildAdCatMenu(0)/e;
	$template =~ s/\[ERROR\]/$message/i;
	$FORM{step}='0';
	return $template;
}
############################################################
sub BuildAdPost1{
	my($ad, %AD, $message, $template);
	($message, $template) = @_;
	$template = (-f $template)?$template:$TEMPLATE{post1};
	$message = &ErrorTemplate($message) if $message;
    %AD = &RetrieveAdDB($FORM{id}) if ($FORM{id});
    foreach (keys %AD){ $FORM{$_} = $AD{$_} unless defined $FORM{$_};   }
###set up the checkbox so that selected fields will be chosen
	$FORM{relationship} =~ s/(\s)+(&#183;)(\s)+/;/g;
	$FORM{interests} =~ s/(\s)+(&#183;)(\s)+/;/g;
	$FORM{groups} =~ s/(\s)+(&#183;)(\s)+/;/g;
	$template = &ParseHTMLInput($template, \%FORM, $CONFIG{ad_fields});
    $template =~ s/\[HIDDEN_FIELDS\]/&BuildAdHiddenFields(1)/e;
    if ($FORM{type} eq "search") {
        $template =~ s/\[IP_CAT\]/&BuildSearchCatMenu/e;
    }
    else {
        $template =~ s/\[IP_CAT\]/&BuildAdCatMenu(1)/e;
    }
	$template =~ s/\[ERROR\]/$message/i;
	$FORM{step}='1';
	return $template;
}
############################################################
sub BuildAdPost2{
	my($ad, %AD, $message, $template);
	($message, $template) = @_;
	$template = (-f $template)?$template:$TEMPLATE{post2};
	$message = &ErrorTemplate($message) if $message;
    %AD = &RetrieveAdDB($FORM{id});
	foreach (keys %AD){	$FORM{$_} = $AD{$_} unless defined $FORM{$_};	}
	$FORM{description}= &ConvertToForm($FORM{description});
	$FORM{description}=~ s/\s+/ /g;
	
	$template = &ParseHTMLInput($template, \%FORM, $CONFIG{ad_fields});
	$template =~ s/\[HIDDEN_FIELDS\]/&BuildAdHiddenFields(2)/e;
	$template =~ s/\[ERROR\]/$message/i;
	$FORM{step}='2';
	return $template;
}
############################################################
sub BuildAdPost3{
	my($ad, %AD, $message, $template);
	($message, $template) = @_;
	$message = &ErrorTemplate($message) if $message;
	$template = (-f $template)?$template:$TEMPLATE{post3};
    %AD = &RetrieveAdDB($FORM{id});
	foreach (keys %AD){	$FORM{$_} = $AD{$_} unless defined $FORM{$_};	}
	
	$template = &ParseHTMLInput($template, \%FORM, $CONFIG{ad_fields});
	$template =~ s/\[HIDDEN_FIELDS\]/&BuildAdHiddenFields(3)/e;
	$template =~ s/\[ERROR\]/$message/i;
	$FORM{step}='3';
	return $template;
}
############################################################
sub BuildAdPost4{
	my($ad, %AD, $message, $template);
	($message, $template) = @_;
	$message = &ErrorTemplate($message) if $message;
	$template = (-f $template)?$template:$TEMPLATE{post4};
    %AD = &RetrieveAdDB($FORM{id});
	foreach (keys %AD){	$FORM{$_} = $AD{$_} unless defined $FORM{$_};	}
	
	$template = &ParseHTMLInput($template, \%FORM, $CONFIG{ad_fields});
	$template =~ s/\[HIDDEN_FIELDS\]/&BuildAdHiddenFields(4)/e;
	$template =~ s/\[ERROR\]/$message/i;
	$template =~ s/\[IP_FILEUPLOAD\]/$Cgi->filefield(-name=>'file',-default=>'C:\\',-size=>40,-maxlength=>80)/egis;
	$template =~ s/\[THUMBNAIL\]/$AD{thumbnail}/i;
	$template =~ s/\[GALLERY(_IMAGES)*\]/&BuildAdGallery()/e;
	$FORM{step}='4';
	return $template;
}
############################################################
sub BuildAdPost5{
	my($ad, %AD, $message, $template);
	($message, $template) = @_;
	$template = (-f $template)?$template:$TEMPLATE{post5};
	$message = &ErrorTemplate($message) if $message;
    %AD = &RetrieveAdDB($FORM{id});

	foreach (keys %AD){	$FORM{$_} = $AD{$_};	}
	
	$template = &ParseHTMLInput($template, \%FORM, $CONFIG{ad_fields});
	$template =~ s/\[HIDDEN_FIELDS\]/&BuildAdHiddenFields(5)/e;
	$template =~ s/\[CONTENT\]/&ParseAdTemplate($TEMPLATE{ad}, \%FORM)/e;
	$template =~ s/\[ERROR\]/$message/i;
	$FORM{step}='5';
	return $template;
}
############################################################
sub CheckAdInput1{
	my(@db, %FIELD, $line, @lines, $message,$state,$state2);
	@db =(age,bdd,bdy,bdm,body,city,country,drink,education,employment,ethnic,eye,gender,hair,
height1,height2,horoscopes,income,kid1,kid2,marital,political,profession,religion,rel_services,
smoke,weight,state,state2,state3,zip,business_url,favorite_url,favorite_url2,aim,yim,icq,msn,
relationship,groups,interests);
	$message = &CheckFieldDBInput($CONFIG{ad_fields}, \@db);
#	$message .= qq|<li>Please select a category<li>| unless $FORM{cat};
	if ($FORM{state} and $FORM{state2}) {
        %FIELD=&RetrieveFieldDBByID($CONFIG{ad_fields},'state');
		$state=$FIELD{name};
        %FIELD=&RetrieveFieldDBByID($CONFIG{ad_fields},'state2');
		$state2=$FIELD{name};
		$message.=qq|<li>Please set either $state or $state2, not both</li>|;
	}
	return $message;
}
############################################################
sub CheckAdInput2{
	my($message, @tokens,%FIELD);
    %FIELD=&RetrieveFieldDBByID($CONFIG{ad_fields},'title');
	if ($FIELD{'require'} && !$FORM{title}) {$message .=qq|&nbsp;&nbsp;<b>&#183</b>You must enter a title for your ad.<br>|;}
    %FIELD=&RetrieveFieldDBByID($CONFIG{ad_fields},'description');
	if ((length($FORM{'description'}) < $CONFIG{min_description}) && $FIELD{'require'}) {
		  $message .=qq|&nbsp;&nbsp;<b>&#183</b>Your description must have at least $CONFIG{min_description} characters. You have entered |. length($FORM{'description'}) .qq| characters.<br>|;
    }
	$message .=qq|&nbsp;&nbsp;<b>&#183</b>The maximum allowable characters in your description is $CONFIG{max_description}.  You have entered |. length($FORM{'description'}) .qq| characters.<br>| if (length($FORM{'description'}) >= $CONFIG{max_description});
	@tokens = split(/\s/, $FORM{description});
	foreach (@tokens){
		if(length > $CONFIG{max_wordlength}){
			$message .=qq|&nbsp;&nbsp;<b>&#183</b>Sorry, no words more than $CONFIG{max_wordlength} characters are accepted.<br>|;
			last;
		}
	}
	@tokens = split(/\s/, $FORM{title});
	foreach (@tokens){
		if(length > $CONFIG{max_wordlength}){
			$message .=qq|&nbsp;&nbsp;<b>&#183</b>Sorry, no words more than $CONFIG{max_wordlength} characters are accepted.<br>|;
			last;
		}
	}	
	return $message;	
}
############################################################
sub CheckAdInput3{
	my(@db, $message);
	@db =("dd","fs","fd","pet","bot","known","toy","esc");
	$message = &CheckFieldDBInput($CONFIG{ad_fields}, \@db);
	return $message;
}
############################################################
1;
