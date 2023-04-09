#####################################################################
#                                                                   #
#             PerlDesk - Customer Help Desk Software                #
#                                                                   #
#####################################################################
#                                                                   #
#     Author: John Bennett	                                    #
#      Email: j.bennett@perldesk.com                                #
#        Web: http://www.perldesk.com                               #
#    Release: 1.8                                                   #
#   Revision: 0                                                     #
#                                                                   #
#####################################################################
# Please direct bug reports,suggestions or feedback to the perldesk #
# forums. www.perldesk.com/board                                    #
#####################################################################
# Please see the README/INSTALL files if you have any problems      #
# with this software.                                               #
##################################################################### 
# TEMPLATE PARSING                                                  #
# You can add any custom template tags here                         #


  %template = ( 
                 lang    => $language,
                 baseurl => $global{'baseurl'},
                 imgbase => $global{'imgbase'},
                 title   => $global{'title'},
                 custom  => 'custom_value'
             );



sub parse {

 my $file  = "@_";
    $file .= '.tpl';

 my $html;
 my $default;

 open MAIN, "$global{'data'}/include/tpl/admin/default.tpl" || die print "Error: $!";
   while (<MAIN>) { $default .= $_; }
 close MAIN;

 open TPL, "$file" || die print "Error opening $file: $!";
    while (<TPL>) {
             $html  .= $_; 
      }
 close TPL;

 $default =~ s/\{CONTENT\}/$html/g;

 foreach my $key (keys %template) {
      $default =~ s/\{$key\}/$template{$key}/eg;
   }

   $default =~ s/\%(\S+)\%/$LANG{$1}/g;

   return $default;

}


sub lang_parse {
      
   $_ =~ s/\%(\S+)\%/$LANG{$1}/g;
   
  }


1;