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
#                                                                   #
#####################################################################
# Please see the README/INSTALL files if you have any problems      #
# with this software.                                               #
##################################################################### 
#                                                                   #
# TEMPLATE PARSING                                                  #
# You can add any custom template tags here                         #
#                                                                   #
#####################################################################

  %template = ( 
                 lang      => $language,
                 baseurl   => $global{'baseurl'},
                 imgbase   => $global{'imgbase'},
                 title     => $global{'title'},
                 timen     => $timenow,
                 custom    => 'custom_value',
                 rtime     => "900",
                 rdirector => "",
                 sounda     => "",
                 soundb     => ""
             );

####################################################################


sub parse 
 {
###########################


 my $file  = "@_";
    $file .= '.tpl';

 my $html;
 my $default;



if (-e "include/tpl/staff/default.tpl")
 {
   open MAIN, "include/tpl/staff/default.tpl" || die_nice("Error: $!");
      while (<MAIN>) 
       {  
          if (/\{CONTENT\}/)
            {
               open TPL, "$file" || die "Error opening $file: $!";
                   while (<TPL>)
                    {                          
                          s/\{(\S+?)\}/$template{$1}/gi;
                          s/\%(\S+?)\%/$LANG{$1}/gi;
                          print;
                    }
               close TPL;               
            }

          s/\{(\S+?)\}/$template{$1}/gi;
          s/\%(\S+?)\%/$LANG{$1}/gi;
           print;
       }                                          
    close MAIN;
 }

############################

 }


sub lang_parse {  $_ =~ s/\%(\S+)\%/$LANG{$1}/g;  }


1;