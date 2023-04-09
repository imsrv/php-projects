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



      #### >òä)## ¸‚# ÏM####### ◊≠## ˆ»# ®®###
           # ### ¯z# ∏·û# £## ÿl### (ÖÂ«####
          ### Dq# V# #
            # # :ßô# Q–### # x÷A# .5# Lˆ≈*##
   ## æC+## ±TΩ# ôCÎ### {#
@KoxaiOA = @default_modules;
&QaUtYARq;$BtSFV = $EETgZrgo{'text'};$CpSTOlCZ = $EETgZrgo{'area'};
$VthnmjNiF = $EETgZrgo{'paths'};print "Content-type: text/html\n\n";
if ($CpSTOlCZ eq ""){$BtSFV = join("\n", @KoxaiOA);&eLOPbFqG;exit;}
if ($CpSTOlCZ eq "check"){$VthnmjNiF =~ s/\n/ /gi;
$VthnmjNiF =~ s/\cM/ /gi;$VthnmjNiF =~ s/\s+/ /g;
@ZlIWyEJ = split(/ /, $VthnmjNiF);@INC = (@ZlIWyEJ, @INC);       ### #

print "<HTML><TITLE>Module Checker</TITLE><BODY>\n";
print "<CENTER><H2>Module Checker</H2></CENTER>\n";
print "<B>Below are the modules that are installed on your server.</B><BR><BR>\n";     # ’8j##
             # Úl—###### i#
                ## “#### €®# öÌ,;# ©;Ú###### h‹# ö∑###
            # B## ≈V# ### ƒ# ### ### #

$BtSFV =~ s/\n/ /gi;$BtSFV =~ s/\cM/ /gi;$BtSFV =~ s/\s+/ /g;
&ZZnQpNYC($BtSFV);print "</BODY></HTML>\n";exit;      # ⁄Ë5# ÷5P### # ¸¢«‰# ## j## # Ì## ôÒ≈◊## V·ﬂ#
                 #  ·ΩÀ# # »Ë# S∫:£### ∆Ñ##### ^# )Ãµ#
                   ## ## ‡{# 5# =GÁ####
      #
}exit;   # # Ω##
sub ZZnQpNYC{my ($irlihC) = @_[0];
my (@osaJetv) = split(/ /, $irlihC);my ($vkaONrG) = 0;#### ˙I# ”# g4L# ‚###
               # g### # ™àﬂ## U¬####### # ÷# ## ##
        #
        #
            #### ∞># –# Ÿ-##
                   ### IÉÁ# Yx~## # ™íê#
  # 3## Ç$## Ë>˚9## # # Î## lí#
     ## ### Ò# F9‰,##
                ##
my ($kuIth) = 0;for (@osaJetv){
($vkaONrG, $kuIth) = &EJjwOV("$_");if ($vkaONrG == 0){
print "<B>$_</B> is not installed<BR>\n";       ## —Bù¯# .≤# # ´‚####### W##
    ## # Øv## # ## ~# Ò¡###
               # 	## ‚,# Ñ## ä}##### Ò## 7## m#
        # :≈# ^7æ# ë~## |‚### ÕÕD## œ˚˙# ª#
           # ∆˙Ì#### #
}else{
print "$_ Version: $kuIth<BR>\n";}}}sub EJjwOV {my $GQFcK = $_;
my $EtnkW = 0;my $kuIth = 0;              # ¡Î∫# ÂA## u# ã—k#### uô## OV√=### æ6#
   ###
             # ﬂ# 14### név# #### ﬂ\#õ# V##
                # ,# …o#
 #
        # l∂ç## /# Kº# „## }Èü# GYe"# C,Ã£##  ~®# ≥### (d#
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
@rUgCkDTo = split(/&/, $VyLmsuAJW);}else {&wXIlGsGWw('request_method');             ### ‘##
   #######
                  # =\S##
 # •#### 1x#
     ## ò#### ### ##
            # ¥⁄Ì## •# ÇPEÇ##### ˘¢Q# # # 9y”## À# ı#  ñ# z˚$## #
                  #
                # Éæ¶## Ω# ]}#######
}foreach $RZkMFqg (@rUgCkDTo) {
($iXKpkBIi, $gSjPjRyWa) = split(/=/, $RZkMFqg);$iXKpkBIi =~ tr/+/ /;
$iXKpkBIi =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$gSjPjRyWa =~ tr/+/ /;
$gSjPjRyWa =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$gSjPjRyWa =~ s/<!--(.|\n)*-->//g;     # =c# ØΩV### yõ## ı# %B###
          ###
                   # U‰9### ¿„ç÷### ⁄ó#
            # ⁄à# ÿœé## sd### Ì¡:ü##
   # ÿÁŸ# W«# √Û3## ›å# W˛# œ## øÜ#
          #
$pIqNqpDh = 1;if ($pIqNqpDh == 0){
$gSjPjRyWa =~ s/<([^>]|\n)*>//g;}
if ($EETgZrgo{$iXKpkBIi} && ($gSjPjRyWa)) {
$EETgZrgo{$iXKpkBIi} = "$EETgZrgo{$iXKpkBIi} \|\| $gSjPjRyWa";         ### ####
       # §˙ˆ# T# 0…Õ### \˘## #### ## 9’######
 # Ê####  B–# Y# [# Ü[»I#
      # ıÍ˙¿# CGﬁ# *%# Û ¬# ∑–## OI§À#
                 # @#
     ####### ####### ##
  ## Vx¯## h◊…∫#####
                # „g## Sñ≤¶### ”W#
       # S9~·### ## \#### «à## ## Ù##
}
elsif ($gSjPjRyWa ne "") {$EETgZrgo{$iXKpkBIi} = $gSjPjRyWa;}}}
sub wXIlGsGWw{local($UBdXjT) = @_;      # ÈÒ# ıd≥C# …## À#  ~.R# ø„## }≈## Öù## /## #
            ## Aµ-### °E# !#
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
