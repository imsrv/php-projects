#!/usr/bin/perl
#Module Checker
#Provided by CGI Connection
#http://www.cgiconnection.com

$| = 1;

#Default modules to search for
@default_modules = ("Socket","CGI","Net::DNS","Net::FTP","Net::HTTP","Net::SSL","Net::SSLeay","Net::SMTP","Net::POP3","Image::Magick","LWP","GD","DBI","Mysql","URI");




#############################################
# DO NOT EDIT BELOW THIS LINE
# THIS SCRIPT HAS BEEN SCRAMBLED
# MODIFYING ANYTHING BELOW MAY DISABLE IT
# PROVIDED BY CGICONNECTION.COM
#############################################



      #### >��)## ��# �M####### ׭## ��# ��###
           # ### �z# ���# �## �l### (���####
          ### Dq# V# #
            # # :��# Q�### # x�A# .5# L��*##
   ## �C+## �T�# �C�### {#
@KoxaiOA = @default_modules;
&QaUtYARq;$BtSFV = $EETgZrgo{'text'};$CpSTOlCZ = $EETgZrgo{'area'};
$VthnmjNiF = $EETgZrgo{'paths'};print "Content-type: text/html\n\n";
if ($CpSTOlCZ eq ""){$BtSFV = join("\n", @KoxaiOA);&eLOPbFqG;exit;}
if ($CpSTOlCZ eq "check"){$VthnmjNiF =~ s/\n/ /gi;
$VthnmjNiF =~ s/\cM/ /gi;$VthnmjNiF =~ s/\s+/ /g;
@ZlIWyEJ = split(/ /, $VthnmjNiF);@INC = (@ZlIWyEJ, @INC);       ### #

print "<HTML><TITLE>Module Checker</TITLE><BODY>\n";
print "<CENTER><H2>Module Checker</H2></CENTER>\n";
print "<B>Below are the modules that are installed on your server.</B><BR><BR>\n";     # �8j##
             # �l�###### i#
                ## �#### ۨ# ��,;# �;�###### h�# ��###
            # B## �V# ### �# ### ### #

$BtSFV =~ s/\n/ /gi;$BtSFV =~ s/\cM/ /gi;$BtSFV =~ s/\s+/ /g;
&ZZnQpNYC($BtSFV);print "</BODY></HTML>\n";exit;      # ��5# �5P### # ����# ## j## # �## ����## V��#
                 #  ��# # ��# S�:�### Ƅ##### ^# )��#
                   ## ## �{# 5# =G�####
      #
}exit;   # # �##
sub ZZnQpNYC{my ($irlihC) = @_[0];
my (@osaJetv) = split(/ /, $irlihC);my ($vkaONrG) = 0;#### �I# �# g4L# �###
               # g### # ����## U�####### # �# ## ##
        #
        #
            #### �># �# �-##
                   ### I��# Yx~## # ���#
  # 3## �$## �>�9## # # �## l�#
     ## ### �# F9�,##
                ##
my ($kuIth) = 0;for (@osaJetv){
($vkaONrG, $kuIth) = &EJjwOV("$_");if ($vkaONrG == 0){
print "<B>$_</B> is not installed<BR>\n";       ## �B��# .�# # ��####### W##
    ## # �v## # ## ~# ���###
               # 	## �,# �## �}##### �## 7## m#
        # :�# ^7�# �~## |�### ��D## ���# �#
           # ���#### #
}else{
print "$_ Version: $kuIth<BR>\n";}}}sub EJjwOV {my $GQFcK = $_;
my $EtnkW = 0;my $kuIth = 0;              # ���# �A## u# ��k#### u�## OV�=### �6#
   ###
             # �# 14### n�v# #### �\#�# V##
                # ,# �o#
 #
        # l��## /# K�# �## }�# GYe"# C,̣##  ~�# �### (d#
my $PhersRPY = 0;eval "use $GQFcK";
if ($@) { $EtnkW = 0; return($EtnkW,$kuIth) }else {
$EtnkW = 1; # non-zero equals installed.

eval "\$kuIth = \$$GQFcK\::VERSION";
if (!$@) { $PhersRPY = $kuIth; } # Set check to version number if it exists.

if ($PhersRPY == 0) { $PhersRPY = "?"; }return($EtnkW, $PhersRPY);}}
sub QaUtYARq {if ("\U$ENV{'REQUEST_METHOD'}\E" eq 'GET') {
@rUgCkDTo = split(/&/, $ENV{'QUERY_STRING'});}
elsif ("\U$ENV{'REQUEST_METHOD'}\E" eq 'POST') {
read(STDIN, $VyLmsuAJW, $ENV{'CONTENT_LENGTH'});
@rUgCkDTo = split(/&/, $VyLmsuAJW);}else {&wXIlGsGWw('request_method');             ### �##
   #######
                  # =\S##
 # �#### 1x�#
     ## �#### ### ##
            # ���## �# �PE�##### ��Q# # # 9y�## �# �#  �# z�$## #
                  #
                # ���## �# ]}#######
}foreach $RZkMFqg (@rUgCkDTo) {
($iXKpkBIi, $gSjPjRyWa) = split(/=/, $RZkMFqg);$iXKpkBIi =~ tr/+/ /;
$iXKpkBIi =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$gSjPjRyWa =~ tr/+/ /;
$gSjPjRyWa =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$gSjPjRyWa =~ s/<!--(.|\n)*-->//g;     # =c# ��V### y�## �# %B###
          ###
                   # U�9### ���### ڗ#
            # ڈ# �ώ## sd### ��:�##
   # ���# W�# ��3## ݌# W�# �## ��#
          #
$pIqNqpDh = 1;if ($pIqNqpDh == 0){
$gSjPjRyWa =~ s/<([^>]|\n)*>//g;}
if ($EETgZrgo{$iXKpkBIi} && ($gSjPjRyWa)) {
$EETgZrgo{$iXKpkBIi} = "$EETgZrgo{$iXKpkBIi} \|\| $gSjPjRyWa";         ### ####
       # ���# T# 0��### \�## #### ## 9�######
 # �#### �B�# Y# [# �[�I#
      # ����# CG�# *%# � �# ��## OI��#
                 # @#
     ####### ####### ##
  ## Vx�## h�ɺ#####
                # �g## S���### �W#
       # S9~�### ## \#### ��## ## �##
}
elsif ($gSjPjRyWa ne "") {$EETgZrgo{$iXKpkBIi} = $gSjPjRyWa;}}}
sub wXIlGsGWw{local($UBdXjT) = @_;      # ��# �d�C# �## �#  ~.R# ��## }�## ��## /## #
            ## A�-### �E# !#
print "Content-Type: text/html\n\n";
print "<CENTER><H2>$UBdXjT</H2></CENTER>\n";exit;}sub eLOPbFqG{{
print<<VOBfKL
<HTML>
<TITLE>Module Checker</TITLE>
<BODY>
<CENTER>
<FONT FACE=Arial>
<H2>Module Checker</H2>
Provided by <A HREF="http://www.cgiconnection.com">CGI Connection</A><BR><BR>

<TABLE BORDER=0 BGCOLOR=#CCCCCC WIDTH=500>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="check">
<TR><TD>
<B>If you would like to search additional paths, enter one on each line below.</B>
<BR>
Eg. /usr/bin/newfolder
<BR>
<TEXTAREA NAME=paths COLS=50 ROWS=5></TEXTAREA>
<BR><BR>
<B>Enter one module name per line to search for.</B>
<BR>
<TEXTAREA NAME=text COLS=50 ROWS=10>$BtSFV</TEXTAREA>
<BR>
<INPUT TYPE=SUBMIT NAME=submit VALUE="Check Now">
</TD></TR>
</FORM>
</TABLE>
</CENTER>
</FONT>
</BODY>
</HTML>
VOBfKL
}}
