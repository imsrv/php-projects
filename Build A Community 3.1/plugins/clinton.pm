
################################################################################################
## Called by "PLUGIN:CUSTOM:LinkExchange" from within your Templates...
## This plugin will insert a LinkExchange Ad into your page with random numbers inserted in the appropriate places.
################################################################################################

sub LINKEXCHANGE {
	srand();
	$seed=100000;
	$rnd=int rand $seed;

	my $AD = undef;

    	$AD = "<center><iframe src=\"http://leader.linkexchange.com/$rnd/$CONFIG{'LE_account'}/showiframe?\" width=468 height=60 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=no>\n";
	$AD .= "<a href=\"http://leader.linkexchange.com/$rnd/$CONFIG{'LE_account'}/clickle\" target=\"_top\">\n";
	$AD .= "<img width=468 height=60 border=0 ismap alt=\"\" src=\"http://leader.linkexchange.com/$rnd/$CONFIG{'LE_account'}/showle?\"></a>\n";
	$AD .= "</iframe>\n";
	$AD .= "<a href=\"http://leader.linkexchange.com/$rnd/$CONFIG{'LE_account'}/clicklogo\" target=\"_top\"><img src=\"http://leader.linkexchange.com/$rnd/$CONFIG{'LE_account'}/showlogo?\" width=468 height=16 border=0 ismap alt=\"\"></a><br></center>\n";

	return $AD;
}

################################################################################################
## Called by "PLUGIN:CUSTOM:Web_Adverts" from within your Templates.  
## This plugin will make use of WebAdverts instead of Ad-Master
################################################################################################

sub WEB_ADVERTS {

   
     ### The Real System path to where your webadverts .cgi files are
     ###   We assume (or look for) a .cgi file matching the name of
     ###   the current category or search terms
     ###   See your webadverts docs for details on how to create ZONES
     ### The URL to call these programs from $CONFIG{'webadvert_url'}
     ### The full path to the default webadvert program if no matches found. $CONFIG{'WebAdvertsDefaultZone'}

	my $zone = $_[0];

	if ( -e "$CONFIG{'webadvert_path'}/$zone.cgi" ){
		$CONFIG{'webadvert_path'} = $zone;
		$webadvert_basename = "$zone.cgi";
	}
	elsif ( -e "$CONFIG{'webadvert_path'}/$CONFIG{'WebAdvertsDefaultZone'}.cgi" ){
		$CONFIG{'webadvert_program'} = $CONFIG{'WebAdvertsDefaultZone'};
		$webadvert_basename = "$CONFIG{'WebAdvertsDefaultZone'}.cgi";
	}		
	else {
		return undef;
	}

	$TRY .= "Using: >>>$CONFIG{'webadvert_program'}<<<<BR>\n";

	open( WEBADVERTS, "$CONFIG{'webadvert_program'}|");
	while(<WEBADVERTS>) { $WEBADVERTS .= $_; }
	close(WEBADVERTS);

	$CT = "Content-type: text/html";
	$WEBADVERTS =~ s/$CT//g;


	# Uncomment one or the other here, depending on if you're running live or
	# from built HTML Files

	# $OUT .=  "\<!--#exec cgi=\"$CONFIG{'webadvert_url'}/$webadvert_basename\" -->";
	return $WEBADVERTS;
}

################################################################################################
## Called by "PLUGIN:CUSTOM:Amazon" from within your Templates.  
## This plugin will draw a simple Amazon.com "Buy Books" form.
################################################################################################

sub AMAZON {
	my $words = $_[0];
	my $pwords = $words;
	$pwords =~ s/_/ /g;
	$words =~ s/_/+/g;
	my $AD = undef;
	$AD .= <<DONE_AMAZON;
	<table border="1"><tr><td><center><font face="$CONFIG{'font_face'}" color="$CONFIG{'text_color'}" size= "-1">Buy books about<BR><b>$pwords</b></font><BR>
	<a href="http://www.amazon.com/exec/obidos/external-search?mode=books&keyword=$words&tag=$CONFIG{'aff_code'}"><img src="$CONFIG{'amazon_image'}"></a></center></td></tr></table>
DONE_AMAZON

	return $AD;
}

################################################################################################
#
################################################################################################

sub HELLO {
	if ($IUSER{username}){
      	$CONFIG{'hello_string'} =~ s/\[USERNAME\]/$IUSER{'username'}/g;
      	$CONFIG{'hello_string'} =~ s/\[REALNAME\]/$IUSER{'realname'}/g;
      	$CONFIG{'hello_string'} =~ s/\[FIRSTNAME\]/$IUSER{'firstname'}/g;
      	$CONFIG{'hello_string'} =~ s/\[LASTNAME\]/$IUSER{'lastname'}/g;
      	$CONFIG{'hello_string'} =~ s/\[HANDLE\]/$IUSER{'handle'}/g;
		return $CONFIG{'hello_string'};
	}
	else {
		return $CONFIG{'default_hello_string'};
	}		
}
################################################################################################
#
################################################################################################

sub TEXT {
	my $file = $_[0];

	$file =~ s/\W//g;
	my $fn = $GPath{'template_data'} . "/inserts/" . $file;

	open(FILE, $fn) || return ("Can't open file $fn: $!");
	my $AD = undef;
	foreach my $entry (<FILE>) {
		$AD .= $entry;	
	}
   	close(FILE);  
	return $AD;
}

################################################################################################
#
################################################################################################

sub REGISTER {
	return "$GUrl{'register.cgi'}";
}

################################################################################################
#
################################################################################################

sub LOGIN {
}

################################################################################################
#
################################################################################################

sub LOGOUT {
	return "$GUrl{'users_utilities.cgi'}?action=Logout";
}

################################################################################################
#
################################################################################################

sub FLYCAST {
	srand();
	$seed=100000;
	$rnd=int rand $seed;

	my $page = $_[0];
	my $flycastpage = undef;

 	if ($page){
		$flycastpage = $page;
	}
	else {
		$flycastpage = $CONFIG{'flycast_defaultpage'};
	
	}		
	$OUT .= "<SCRIPT LANGUAGE=\"JAVASCRIPT\">\n";
	$OUT .= "<!--\n";
	$OUT .= "FlycastSite = \"$CONFIG{'flycast_site'}\";\n";
	$OUT .= "FlycastPage = \"$flycastpage\";\n";
	$OUT .= "FlycastWidth = 468;\n";
	$OUT .= "FlycastHeight = 60;\n";
	$OUT .= "FlycastPrintTag = true;\n";
	$OUT .= "FlycastNewAd = true;\n";
	$OUT .= "FlycastLoaded = false;\n";
	$OUT .= "FlycastVersion = 3.5;\n";
	$OUT .= "//-->\n";
	$OUT .= "</SCRIPT>\n";
	$OUT .= "<SCRIPT SRC=\"http://js-adex3.flycast.com/FlycastUniversal/\" LANGUAGE=\"JAVASCRIPT\"></SCRIPT>\n";
	$OUT .= "<SCRIPT LANGUAGE=\"JAVASCRIPT\">\n";
	$OUT .= "<!--\n";
	$OUT .= "if (FlycastLoaded) FlycastDeliverAd();\n";
	$OUT .= "//--> \n";
	$OUT .= "</SCRIPT> \n";
	$OUT .= "<NOSCRIPT><IFRAME WIDTH=468 HEIGHT=60 SRC=\"http://ad-adex3.flycast.com/server/iframe/$CONFIG{'flycast_site'}/$flycastpage/$rnd\" scrolling=\"no\" marginwidth=0 marginheight=0 frameborder=0 vspace=0 hspace=0><A target=\"_top\" HREF=\"http://ad-adex3.flycast.com/server/click/$CONFIG{'flycast_site'}/$flycastpage/$rnd\"><IMG BORDER=0 WIDTH=468 HEIGHT=60 SRC=\"http://ad-adex3.flycast.com/server/img/$CONFIG{'flycast_site'}/$flycastpage/$rnd\"></A></IFRAME></NOSCRIPT>\n";
	$OUT .= "<!--End Flycast Ad Copyright 1999 Flycast Communications. All rights reserved. Patent Pending -->\n";
}


################################################################################################
#
################################################################################################

sub RANDOMIMAGE {
}

################################################################################################
#
################################################################################################

sub HYPERSEEKSEARCH {
}

################################################################################################
#
################################################################################################

sub FINDSEARCH {

	my $AD= undef;
	$AD .= "<form ENCTYPE=\"application/x-www-form-urlencoded\" action=\"$GUrl{'find.cgi'}\" method=GET>";
	$AD .= "<INPUT TYPE=text NAME=search VALUE=\"$FORM{'search'}\">";
	$AD .= "<INPUT TYPE=hidden NAME=dir VALUE=\"$FORM{'dir'}\">";
	$AD .= "<INPUT TYPE=hidden NAME=action VALUE=search>";
	$AD .= "<INPUT TYPE=submit VALUE=\"Search!\">";
	$AD .= "</FORM>";
	return $AD;
}


################################################################################################
#
################################################################################################

sub CENTRALAD {
}

################################################################################################
#
################################################################################################

sub RANDOMTEXT {
}

################################################################################################
#
################################################################################################

sub NUMBERMEMBERS {
}

################################################################################################
#
################################################################################################

sub PAGEVIEWS {
	my $fn = $_[0];
	my $day= &US_Date;
	$fn =~ s/\W//g;
	$day =~ s/\///g;
	$fn=$fn || "default";
	$fn = $fn . $day . "txt";
	$fn= "$GPath{'counter_data'}/$fn";
	open (FILE, $fn);
	my @t = <FILE>;
   	close(FILE);  
	open (FILE, ">$fn")|| return ("Can't open file $fn: $!");
	print FILE ++$t[0];
   	close(FILE); 
	return $t[0];
}

1;

