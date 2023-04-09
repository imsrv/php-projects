##############################################################################
# PROGRAM : BuildACommunity.com Perl Module                                  #
# VERSION : 3.1                                                              #
#                                                                            #
# NOTES   :                                                                  #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 1999 -> 2017                                                 #
#           Eric L. Pickup, Ecreations, BuildACommunity                      #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    ------ DO NOT MODIFY ANYTHING BELOW THIS POINT !!! -------              #
#                                                                            #
##############################################################################
#
#    GLOBAL VARIABLES YOU CAN USE IN THESE FUNCTIONS
#
#    Hyperseek...
#       $grp:  The current category and subcategory combined (with "_" to 
#              indicate spaces (ie:  Computers_and_Internet_Software_Design)
#              Would be for Computers and Internet:Software:Design
#
#       $Saved_Terms: The currently entered search criteria by the user
#
#       $ReqCategory: Current Category the user is in
#       
#       $ReqSubCateogry:  Current Sub Category the user is in
#
#    iForums...
#       $forum:  The current forum
#       $user_email: This users email address
#
##############################################################################


##############################################################################
# PROGRAM: Custom / Userdef Library
# VERSION: 1.10
##############################################################################

## Called by "PLUGIN:CUSTOM:LinkExchange" from within your Templates...
## This plugin will insert a LinkExchange Ad into your page with random numbers inserted in the appropriate places.
sub LinkExchange {
	srand();
	$seed=100000;
	$rnd=int rand $seed;
	$account = "X160198";

    	$OUT .= "<center><iframe src=\"http://leader.linkexchange.com/$rnd/$account/showiframe?\" width=468 height=60 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=no>\n";
	$OUT .= "<a href=\"http://leader.linkexchange.com/$rnd/$account/clickle\" target=\"_top\">\n";
	$OUT .= "<img width=468 height=60 border=0 ismap alt=\"\" src=\"http://leader.linkexchange.com/$rnd/$account/showle?\"></a>\n";
	$OUT .= "</iframe>\n";
	$OUT .= "<a href=\"http://leader.linkexchange.com/$rnd/$account/clicklogo\" target=\"_top\"><img src=\"http://leader.linkexchange.com/$rnd/$account/showlogo?\" width=468 height=16 border=0 ismap alt=\"\"></a><br></center>\n";
}


## Called by "PLUGIN:CUSTOM:Other_Engines" from within your Templates...
## This plugin will perform the current search on other search engines.
sub Other_Engines {

    $words = $Saved_Terms;
    $words =~ s/ /+/;
  
    $OUT .= <<DONEENGINES;

    <b>Try this search on...</b><br>
      <a href="http://www.hotbot.com/?MT\=$words" target="new">HotBot</a> | 
      <a href="http://www.infoseek.com/Titles?qt\=$words" target="new">Infoseek</a> | 
      <a href="http://www.altavista.com/cgi-bin/query?pg=qkl=XX&q\=$words" target="new">AltaVista</a> | 
      <a href="http://search.excite.com/search.gw?search\=$words" target="new">Excite</a> |
      <a href="http://search.yahoo.com/bin/search?p\=$words" target="new">Yahoo</a> |
      <a href="http://www.lycos.com/cgi-bin/pursuit?query\=$words" target="new">Lycos</a> |
      <a href="http://searcher.mckinley.com/searcher.cgi?query\=$words" target="new">Magellan</a> |
      <a href="http://www.dejanews.com/dnquery.xp?QRY\=$words" target="new">Deja News</a> |
      <a href="http://www.metacrawler.com/cgi-bin/nph-metaquery?general\=$words" target="new">Metacrawler</a>

DONEENGINES

}

## Called by "PLUGIN:CUSTOM:Web_Adverts" from within your Templates.  
## This plugin will make use of WebAdverts instead of Ad-Master
sub Web_Adverts {


   ### You'll need to specify some pathnames here ###

     ### The Real System path to where your webadverts .cgi files are
     ###   We assume (or look for) a .cgi file matching the name of
     ###   the current category or search terms
     ###   See your webadverts docs for details on how to create ZONES
     local($webadverts_path) = "/home/sites/internet/webadverts/display";

     ### The URL to call these programs from
     local($webadverts_url) = "http://internet/webadverts/display";

     ### The full path to the default webadvert program if no matches found.
     local($webadvert_program) = "$webadverts_path/default.cgi";

   $TRY="";

   if ($search eq "T") {
       $sent = $Saved_Terms;
       $sent =~ s/\+//g;
       $sent =~ s/\-//g;
       if ($sent =~ "\"") {
          @words = split(/\"/,$sent);
          $sent = "";
          foreach $w (@words) {
            $w =~ s/ /_/g;
            $sent .= "$w ";
          }
       }

       @searched = split(/ /,$sent);

       $group = "ads";

       for $s( 0 .. $#searched ) {

          $zone = "$webadverts_path/$searched[$s].cgi";
          $TRY .= "Trying: >>>$zone<<<<BR>\n";
          $s =~ s/ //g;

          if (-e "$zone") {

             $webadvert_basename = "$searched[$s].cgi";
             $webadvert_program = $zone;
             last;

          }
       }

   }

   else {
       @wacats = split /_/, $grp;

       for ( $w = ($#wacats + 1); $w > 0; $w-- ){
          @ctemp = @wacats;
          @chunks = splice( @ctemp, 0, $w );
          $chunk = join( "_", @chunks );
          $zone = "$webadverts_path/$chunk.cgi";
          $TRY .= "Trying: >>>$zone<<<<BR>\n";
          if ( -e $zone ){
             $webadvert_program = $zone;
             $webadvert_basename = "$chunk.cgi";
             last;
          }
       }

   }


   $TRY .= "Using: >>>$webadvert_program<<<<BR>\n";

   open( WEBADVERTS, "$webadvert_program|");
       while(<WEBADVERTS>) { $WEBADVERTS .= $_; }
   close(WEBADVERTS);

   $CT = "Content-type: text/html";
   $WEBADVERTS =~ s/$CT//g;


   # Uncomment one or the other here, depending on if you're running live or
   # from built HTML Files

   # $OUT .=  "\<!--#exec cgi=\"$webadverts_url/$webadvert_basename\" -->";
   $OUT .= "$WEBADVERTS";
}


## Called by "PLUGIN:CUSTOM:Amazon" from within your Templates.  
## This plugin will draw a simple Amazon.com "Buy Books" form.
sub Amazon {

    ### Edit these 2 settings:
    $AFF_CODE = "your-amazon-affiliate-code-here";
    $AMAZON_IMAGE = "/virtual/path/to/amazon/image/to/use.gif";

    $words = $Saved_Terms;
    $words =~ s/ /+/;

    $OUT .= <<DONE_AMAZON
    <table border="1"><tr><td><center><font face="$font_face" color="$text_color" size= "-1">Buy books about <p><b>$words</b></p></font>
    <a href="http://www.amazon.com/exec/obidos/external-search?mode=books&keyword=$words&tag=$AFF_CODE"><img src="$AMAZON_IMAGE"></a></center></td></tr></table>

DONE_AMAZON
}


sub Radio_Search {

  $OUT .= <<RADIO;
<form ENCTYPE=\"application/x-www-form-urlencoded\"  method="POST" action="cgi-local/hyperseek/hyperseek.cgi">
  <div align="center">
  <center><p><input type="text" name="Terms" size="33" maxlength="800">
  <input type="submit" value="Go Get It!"><br>
  <input type="hidden" name="Range" value="ALL"><br>
  <input type="radio" value="ALL" checked name="howmuch">Entire Directory&nbsp;
  <input type="radio" name="howmuch" value="$ReqCategory">Just This Category</p>
  </center></div>
</form>
RADIO

}


sub Show_News {

   ### Assumes a news database in this format:
   ##   IDNUMBER|NEWS_URL|NEWS_TITLE|NEWS_DATE

   $newout = "";

   open(NEWS,"news.txt");
       while(<NEWS>) {
           chomp;
           @newsline = split(/\|/,$_);
           $newsout .= "$newsline[3]: <a href=\"$newsline[1]\">$newsline[2]</a>\n";
           $newsout .= "<BR>\n";  ## or whatever termination you want between records.
       }
   close(NEWS);

   $OUT .= $newsout;
}


sub List_Moderator {

   $foundmod = 0;
   for $d(0 .. $#details) {
       if ($details[$d]{'Category'} eq $Current) {
          $desc = "$details[$d]{'Description'}<BR><BR>";
          $mod_file = "$data_dir/hyperseek/moderators/$details[$d]{'Moderator'}.pm";
          $moderator = "$details[$d]{'Moderator'}";
          $foundmod = 1;
          last;
       }
   }

   if($foundmod) {
      $OUT .= "This category is moderated by: <A HREF=\"$moderator_url?action=viewprofile?moderator=$moderator\">$moderator</A>\n";
   
   }  
   else { 
      $OUT .= "This category is not moderated";
   }  
}


############################################################
# Called using PLUGIN:CUSTOM:Category_Matches 
#
# This prints a list of categories that match the current
# Search Term...
############################################################
sub Category_Matches {

  for $cc( 0 .. $#sub_categories) {
   
    $cstring = lc("$sub_categories[$cc]{'Category'} $sub_categories[$cc]{'SubCategory'}");
    $astring = "$sub_categories[$cc]{'Category'}:$sub_categories[$cc]{'SubCategory'}";
    $cstring =~ s/\:/ /g;

    $om = 0;
    $rm = 0; 

    if ($is_required) {
        $bad=0;
        foreach $req(split(/\|/,$req_reg)) {
           if ($cstring !~ /$req/) { $bad++; }
        }
        if(! $bad) { $rm++; }
    }

    if($opt_reg) { 
       if ($cstring =~ /$opt_reg/) { $om++; }
    }

    if ($om || $rm) {    
       $cmref = &urlencode($astring); 
       $cmhref = "<A HREF=\"$hyperseek_url?search=CAT&Category=$cmref\">$astring</A>";
       $cm{$cstring} = $cmhref;
    }

  }

  foreach $key(sort keys %cm) {
       $OUT .= "$cm{$key}<BR>\n";
  }
}


1;
