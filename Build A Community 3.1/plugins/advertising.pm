
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
#
################################################################################################


sub WEB_ADVERTS {
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
#
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
	$AD .= "<SCRIPT LANGUAGE=\"JAVASCRIPT\">\n";
	$AD .= "<!--\n";
	$AD .= "FlycastSite = \"$CONFIG{'flycast_site'}\";\n";
	$AD .= "FlycastPage = \"$flycastpage\";\n";
	$AD .= "FlycastWidth = 468;\n";
	$AD .= "FlycastHeight = 60;\n";
	$AD .= "FlycastPrintTag = true;\n";
	$AD .= "FlycastNewAd = true;\n";
	$AD .= "FlycastLoaded = false;\n";
	$AD .= "FlycastVersion = 3.5;\n";
	$AD .= "//-->\n";
	$AD .= "</SCRIPT>\n";
	$AD .= "<SCRIPT SRC=\"http://js-adex3.flycast.com/FlycastUniversal/\" LANGUAGE=\"JAVASCRIPT\"></SCRIPT>\n";
	$AD .= "<SCRIPT LANGUAGE=\"JAVASCRIPT\">\n";
	$AD .= "<!--\n";
	$AD .= "if (FlycastLoaded) FlycastDeliverAd();\n";
	$AD .= "//--> \n";
	$AD .= "</SCRIPT> \n";
	$AD .= "<NOSCRIPT><IFRAME WIDTH=468 HEIGHT=60 SRC=\"http://ad-adex3.flycast.com/server/iframe/$CONFIG{'flycast_site'}/$flycastpage/$rnd\" scrolling=\"no\" marginwidth=0 marginheight=0 frameborder=0 vspace=0 hspace=0><A target=\"_top\" HREF=\"http://ad-adex3.flycast.com/server/click/$CONFIG{'flycast_site'}/$flycastpage/$rnd\"><IMG BORDER=0 WIDTH=468 HEIGHT=60 SRC=\"http://ad-adex3.flycast.com/server/img/$CONFIG{'flycast_site'}/$flycastpage/$rnd\"></A></IFRAME></NOSCRIPT>\n";
	$AD .= "<!--End Flycast Ad Copyright 1999 Flycast Communications. All rights reserved. Patent Pending -->\n";

	return $AD;
}

1;
