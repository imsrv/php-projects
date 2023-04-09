###################################################################################
#                                                                                 #
#                   PerlDesk - Customer Help Desk Software                        #
#                                                                                 #
###################################################################################
#                                                                                 #
#     Author: John Bennett	                                                  #
#      Email: j.bennett@perldesk.com                                              #
#        Web: http://www.perldesk.com                                             #
#   Filename: user.cgi                                                            #
#    Details: The template parsing file for the user end                          #
#    Release: 1.7                                                                 #
#   Revision: 0                                                                   #
#                                                                                 #
###################################################################################
# Please direct bug reports,suggestions or feedback to the perldesk forums.       #
# www.perldesk.com/board                                                          #
#                                                                                 #
# (c) PerlDesk (JBSERVE LTD) 2002/2003                                            #
# PerlDesk is protected under copyright laws and cannot be resold, redistributed  # 
# in any form without prior written permission from JBServe LTD.                  #
#                                                                                 #
# This program is commercial and only licensed customers may have an installation #
################################################################################### 

  %template = (
                 lang     => $language,
                 baseurl  => $global{'baseurl'},
                 imgbase  => $global{'imgbase'},
                 title    => $global{'title'},
                 logo     => $global{'logo_url'},
                 timen    => $timenow,
                 mainfile => 'pdesk.cgi',
                 custom   => 'custom_value'            
             );


sub parse {

 my $file  = "@_";
    $file .= '.tpl';

 my $html;
 my $default;


 $template{'usernav'} =   qq~<div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=main&lang=$template{'lang'}">$LANG{main}</a> | <a href="$template{'mainfile'}?do=submit_ticket&lang=$template{'lang'}"> $LANG{sreq}</a> | <a href="$template{'mainfile'}?do=listcalls&status=open&lang=$template{'lang'}"> $LANG{opencalls}</a> | <a href="$template{'mainfile'}?do=listcalls&status=closed&lang=$template{'lang'}">$LANG{closedcalls}</a> | <a href="$template{'mainfile'}?do=profile&lang=$template{'lang'}">$LANG{editprofile}</a></font></div>~ if !$ignorenav;


     $file  = "@_";
     $file .= '.tpl';

     foreach $translation (@languages) 
        {
             my $name      =  $translation;
             $translation .=  '.gif';
             $template{'htmlbar'} .= qq| <img src=$global{'imgbase'}/lang/$translation> <a href=\"$template{'mainfile'}?lang=$name\"><font size=2 face="Trebuchet MS,Verdana, Arial, Helvetica, sans-serif">$langdetails{$name}</font></a>&nbsp;|;
        }


if (-e "include/tpl/default.tpl")
 {
   open MAIN, "include/tpl/default.tpl" || die_nice("Error: $!");
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

}


sub lang_parse {    $_ =~ s/\%(\S+)\%/$LANG{$1}/g;   }




1;