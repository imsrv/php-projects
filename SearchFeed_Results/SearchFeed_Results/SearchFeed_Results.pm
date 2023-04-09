# ==================================================================
# Plugins::SearchFeed_Results - Auto Generated Program Module
#
#   Plugins::SearchFeed_Results
#   Author  : Andy Newby
#   Version : 1.3
#   Updated : Sat Sep 14 13:49:47 2002
#
# ==================================================================
#

package Plugins::SearchFeed_Results;
# ==================================================================

    use strict;
    use GT::Base;
    use vars        qw/$VERSION $DEBUG $NAME $FONT $SEARCHED/;
    use GT::Plugins qw/STOP/;
    use Links       qw/$IN $DB $CFG/;
    use Links::Plugins;
    use Links::SiteHTML;
    use LWP::Simple;
    use XML::Simple;

# Inherit from base class for debug and error methods
    @Plugins::SearchFeed_Results::ISA = qw(GT::Base);

# Your code begins here! Good Luck!


# PLUGIN HOOKS
# ===================================================================


sub do_checks {
# -------------------------------------------------------------------
# This subroutine will get called whenever the hook 'search_results'
# is run. You should call GT::Plugins->action ( STOP ) if you don't 
# want the regular code to run, otherwise the code will continue as
# normal.
#
    my (@args) = @_;

# Do something useful here

    my $results = shift;
    if ($SEARCHED) { return $results; }

    my $opts    = Links::Plugins->get_plugin_user_cfg ('SearchFeed_Results');
    my $inc     = $opts->{Active};

    if ($inc == 0) { return $results; }
    if ($inc == 1 and $results->{link_hits} > 0) { return $results; }

    print $IN->header();

    my $self_ip  = $ENV{REMOTR_ADDR};
    my $affil_id = $opts->{SearchFeed_Affiliate_ID};
    my $query    = $IN->param('query');
       $query =~ s/ /\+/g;
       $query =~ s/\W/+/g;

    my $page = get("http://www.searchfeed.com/rd/feed/XMLFeed.jsp?cat=$query&pID=$affil_id&nl=25&ip=$self_ip");

    if (!$page) { 
        print "Could not get SearchFeed content. Site may be down...please try again later!"; 
        exit; 
    } 

    my $ref        = XMLin($page);  
    my $link_count = $ref->{Count};

   # if we didnt get any results from here either, lets let em know!
    if (!$link_count) { 

      print Links::SiteHTML::display('search', { error => "No links were found!" }); 
      exit; 

    }


my ($count, $html_links);

  for ($count = 0; $count <= 25; $count++) {

      # catch if there are no more results...
       if (!$ref->{Listing}->[$count]->{Title}) { last; }

       # get the variables all setup...
       my $Description = $ref->{Listing}->[$count]->{Description};
       my $Title       = $ref->{Listing}->[$count]->{Title};
       my $URI         = $ref->{Listing}->[$count]->{URI};
       my $Bid         = $ref->{Listing}->[$count]->{Bid};

      # some people think its clever to bid 
      # like 0.024343, so lets narrow it tro a round, 2 digit number... 
       $Bid = sprintf("%.2f", $Bid);

     # put the links into HTML format... 
      $html_links .= Links::SiteHTML::display('search_link', { Description => $Description, Title => $Title, URL => $URI, Bid => $Bid });

  }

      # now show the results page!
       print Links::SiteHTML::display('search_results', { link_results => $html_links, cat_hits => 0, link_hits => $link_count });

      # stop the script from running other stuff!
       exit;

}


# ADMIN MENU OPTIONS
# ===================================================================

sub Readme {
# -------------------------------------------------------------------
# This subroutine will get called whenever the user clicks
# on 'Readme' in the admin menu. Remember, you need to print
# your own content-type headers; you should use 
#
   print $IN->header();
#

print qq|

<html>

<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
</head>

<body>

<p align="center"><b><font face="Arial" size="4">SearchFeed_Results</font></b></p>
<p align="center"><font face="Arial" size="2">Author: Andy Newby<br>
Contact: <a href="mailto:webmaster\@ace-installer.com">
webmaster\@ace-installer.com</a><br>
WWW: <a href="http://www.ace-installer.com">http://www.ace-installer.com</a></font></p>
<p align="center"><font face="Arial" size="2">Last Update: 16/9/2002</font></p>
<p align="center"><font face="Arial" size="2">There is nothing really much to 
say here. All you need to do, is install this plugin, then edit the settings 
(via Plugins &gt; Edit (next to the 'uninstall' option), and update it to your own 
Search Affiliate ID, so you get credit ;)</font></p>
<p align="center"><font face="Arial" size="2">A new template has been added, 
called search_link.html, which is the HTML that is used to show results from 
SearchFeed.com.</font></p>
<p align="center"><font face="Arial" size="2">That's about it. Please be sure to 
refer me when signing up with SearchFeed ;)</font></p>
<p align="center">&nbsp;</p>

</body>

</html>

|;

}

# Always end with a 1.
1;
