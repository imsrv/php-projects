#!/usr/bin/perl

# ==================================================================
# MojoPersonals MySQL
#
#   Website  : http://mojoscripts.com/
#   Support  : http://mojoscripts.com/contact/
# 
# Copyright (c) 2002 mojoscripts.com Inc.  All Rights Reserved.
# Redistribution in part or in whole strictly prohibited.
# ==================================================================
#
#    End-User License Agreement for MojoPersonals MySQL:
#--------------------------------------------------------------------
# After reading this agreement carefully, if you do not agree
# to all of the terms of this agreement, you may not use this software.
#
# This software is owned by ascripts.com Inc. and is protected by
# national copyright laws and international copyright treaties.
#
# This software is licensed to you.  You are not obtaining title to
# the software or any copyrights.  You may not sublicense, sell, rent,
# lease or free-give-away the software for any purpose.  You are free
# to modify the code for your own personal use. The license may be
# transferred to another only if you keep NO copies of the software.
#
# This license covers one installation of the program on one domain/url only.
#
# THIS SOFTWARE AND THE ACCOMPANYING FILES ARE SOLD "AS IS" AND
# WITHOUT WARRANTIES AS TO PERFORMANCE OR MERCHANTABILITY OR ANY
# OTHER WARRANTIES WHETHER EXPRESSED OR IMPLIED.
#
# NO WARRANTY OF FITNESS FOR A PARTICULAR PURPOSE IS OFFERED.
# ANY LIABILITY OF THE SELLER WILL BE LIMITED EXCLUSIVELY TO PRODUCT
# REPLACEMENT OR REFUND OF PURCHASE PRICE. Failure to install the
# program is not a valid reason for refund of purchase price.
#
# The user assumes the entire risk of using the program.
#--------------------------------------------------------------------

############################################################
eval {
	($0=~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");
	($0=~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");
	require "config.pl";
	unshift(@INC, $CONFIG{script_path});
	unshift(@INC, "$CONFIG{script_path}/scripts");
	require "ads.pl";
	require "adpost.pl";
  	require "database.pl";
  	require "new_database.pl";
	require "default_config.pl";
	require "display.pl";
	require "members.pl";
	require "english.lng";
	require "gateway.pl";
	require "html.pl";
	require "library.pl";
	require "logs.pl";
	require "templates.pl";
	require "mojoscripts.pl";
	require "parse_template.pl";
	use CGI qw(:standard);
	use CGI::Carp qw(fatalsToBrowser);
   &main;
};
if ($@) {
	print "content-type:text/html\n\n";
	print "Error Including configuration file, Reason: $@";
	exit;
}
############################################################
sub main {
	$|++;
	$Cgi  = new CGI; $Cgi{mojoscripts_created}=1;
	&ParseForm;
	&Initialization;
	&CheckAllRequiredFiles;
	&CheckMemberPermission;
        if($FORM{action} eq "searchoptions"){   &PrintSearchOptions;   }
#        elsif($FORM{action} eq "new"){                  &NewListings;  }
#        elsif($FORM{action} eq "popular"){              &PopularListings;  }
#	elsif($FORM{action} eq "mostreplied"){	&MostRepliedListings;	}
#        elsif($FORM{action} eq "mostsaved"){    &MostSavedListings;  }
        else{ &PrintSearch;  }
}
############################################################
sub PrintSearchOptions{
	$FORM{insert_blank_option} = 1;
	&PrintTemplate(&BuildAdPost1("", $TEMPLATE{search}));
}
############################################################
sub PrintSearch{
	&AdSearchFile;
	&BuildNextPrevFiles();
	&PrintTemplate($TEMPLATE{category}, "");
}
############################################################
#sub Search{				&PrintSearch();	}
#sub NewListings{		&PrintSearch();	}
#sub PopularListings{	&PrintSearch();	}
#sub MostRepliedListings{	&PrintSearch();	}
#sub MostSavedListings{	&PrintSearch();	}
################################################################
sub AdSearchFile{
        my(@ads, @content, %DB, @files, @lines, @temp, @tokens,
        $tokens, $where,@where,
        $db,@db,@cats, $cats, $keywords, $pattern,
        @equalities,@checkboxes,$start,$end, @ad, %AD, $num,
        $order,$sth,$time_now);
        if($FORM{action} eq "new"){   $FORM{order}='date_create'; $time_now=&TimeNow; $where=" AND date_create>=$time_now-$FORM{daysnew}*3600*24";}
        elsif($FORM{action} eq "popular"){   $FORM{order}='view';}
        elsif($FORM{action} eq "toprated"){  $FORM{order}='rate';}
	elsif($FORM{action} eq "mostreplied"){$FORM{order}='reply';}
	elsif($FORM{action} eq "mostsaved"){  $FORM{order}='save';}
        elsif($FORM{action} eq "old"){            $FORM{order}='date_end';}

        else {$FORM{order}='date_create';}

        if ($FORM{cat}>0) {
                @cats=($FORM{cat});
                @cats=&GetSubcatsList(\@cats);
                push @cats, $FORM{cat};
                @cats=map("cat=$_",@cats);
                $cats=join(' OR ',@cats);
                push @where, "($cats)";
        }
        if($FORM{minage}) { push @where, "age>=$FORM{minage}";}
        if($FORM{maxage}) { push @where, "age<=$FORM{maxage}";}
        if($FORM{photo} eq "y") { push @where, "\(image IS NOT NULL AND image<>\'\'\)";}
        if($FORM{photo} eq "n") { push @where, "(image IS NULL OR image=\'\')";}
	if($FORM{keywords}){
                $keywords=$dbh->quote($FORM{keywords});
                $keywords=~s/^["'](.*)["']$/$1/;
                push @where, "(description LIKE \'\%$keywords\%\' OR title LIKE \'\%$keywords\%\')"; #?
        }

###Location
        if($FORM{city}){ $pattern=$dbh->quote($FORM{city}); push @where, "city=$pattern";       }
        if($FORM{state}) { $pattern=$dbh->quote($FORM{state}); push @where, "(state=$pattern OR state2=$pattern)";    }
        if($FORM{province}){  $pattern=$dbh->quote($FORM{province}); push @where, "(state=$pattern OR state2=$pattern)";      }
        if($FORM{country}){     $pattern=$dbh->quote($FORM{country}); push @where, "country=$pattern";}
        @equalities=('zip','gender','bdy', 'bdd','bdm','eye','hair',
        'body','height1','height2','weight','ethnic','education',
        'employment','profession','income','marital','religion',
        'smoke','drink','kid1','kid2','horoscopes','political','rel_services');


        foreach $item(@equalities){
                if($FORM{$item}) {push @where, "$item=\'$FORM{$item}\'"; }
        }

        @checkboxes=('relationship','interests','groups');


        foreach $item(@checkboxes){
     if($FORM{$item}){
		    @tokens = $Cgi->param($item);
                    foreach $token(@tokens) {
                          $token=$dbh->quote($token);
                          $token=~s/^["'](.*)["']$/$1/;
                    }
                    @tokens=map("$item LIKE \'\%$_\%\'",@tokens);
                    $tokens=join(' AND ',@tokens);
                    push @where, "($tokens)";}
        }
        $where=join(" AND ",@where);
        if ($where ne '') {$where=" AND ".$where;}

        @db=&DefineAdDB;
        $db=join(', ',@db);
        unless ($FORM{total}>0){
            $sth=runSQL("SELECT COUNT(*) FROM ads WHERE status=\'active\' $where");
            $FORM{total} = $sth->fetchrow();
        }
        $template = $TEMPLATE{ad1};
	$template = &FileRead($template) if (-f $template);

	$start = ($FORM{offset}> 0)? $FORM{offset}: 0;
	$end = ($start + $FORM{lpp} > $FORM{total})? $FORM{total}:$start + $FORM{lpp};
    $sth=runSQL("SELECT $db FROM ads WHERE status=\'active\' $where
                 ORDER BY $FORM{order} DESC LIMIT $start, $FORM{lpp}");
    $num=$start;
    while (@ad=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$AD{$db[$i]}=$ad[$i]};
        $FORM{file} = $num+1;
        %P = &RetrievePhotoDB("$CONFIG{photo_path}/$AD{username}/$AD{image}", "$CONFIG{ad_url}&action=view_image&cat=$AD{cat}&id=$AD{id}&image=1");
        $AD{image_url}= $P{images_url};
        $AD{thumbnail}= $P{thumbnail};
        $AD{date_create}=&FormatTime($AD{date_create});
        $MOJO{ads} .= &ParseAdTemplate($template, \%AD);
        $num++;
	}
	unless($MOJO{ads} or $MOJO{cats}){
		$MOJO{ads} =qq|<h2>No Matches Found</h2>
      <BLOCKQUOTE>
  			We're sorry, but it appears that there were no ads in the database
  			that matched your search criteria.  Please go back and try again.
  		</BLOCKQUOTE>|;
	}

#	my(%AD, $end, $file, @files, $start, $template);
}

################################################################
