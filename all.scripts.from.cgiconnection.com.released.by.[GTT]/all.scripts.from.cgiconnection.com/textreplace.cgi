#!/usr/bin/perl
# Text Replacer
# Provided by CGI Connection
# http://www.CGIConnection.com
$| = 1;

srand();

# Where to start searching for your web pages
# Generally it's the absolute path to your home pages
# Eg. /path/to/your/pages
$webdir = "!SAVEDIR!";

# Name of folder to create to place backups of pages in
# This folder will be created under each directory
# where files were converted
$backup_folder = "backup";

#############################################
# DO NOT EDIT BELOW THIS LINE
# THIS SCRIPT HAS BEEN SCRAMBLED
# MODIFYING ANYTHING BELOW MAY DISABLE IT
# PROVIDED BY CGICONNECTION.COM
#############################################

###‰ó# ##### ë# Åm## ≥n¿À# ©o# ∂ç### ;¥2#
### ﬁÛ##
               # f‚eL#### ï„## ### ü#### # `# !Ás# #
$mlkGmeHd = "$webdir";#########%^&^@@@@###
      # hs›# # # 4ƒ# T#
             ## ¸wÉ# –U‰ó# ##### ë# Åm## ≥n¿À# ©o# ∂ç### ;¥2#
            ## ´# —c# ﬁÛ##
               # T‚e◊#### ï„## iå### ü#### # ºA`# !Ás# #
$MCiFK = "$backup_folder";
&ebPsskeGE;&iUuLnoVZu("$mlkGmeHd", 0);$USRjVDe = $KCFDrLD{'lookfor'};
$PkVDsYXFH = $KCFDrLD{'replacewith'};$oQFYHW = 0;$wcpIXlNs = 0;
$seyIVn = 0;$aXfehjYce = 1;splice(@gVHecRV, 0);$nTUYR = int(rand(10000));
@gVHecRV[0] = $mlkGmeHd;      ## &Â# ao# è# Ä∫∞6# »¡c# ;d# °# ò'∏~#
#print "Content-type: multipart/mixed\n\n";
print "Content-type: text/html\n\n";
print "<HTML><HEAD><TITLE>Text Replacer</TITLE></HEAD><BODY>\n";
for ($SYleSP = 0; $SYleSP < 50; $SYleSP++)               ### ## “„##
            ## B=#### ≤Ü‰###
            #
  ## À# # Ï≤,E######## º≈# ‚|•## #
           # $æÇ# ˜## lH###
               ## Î## pz,# =ZN˝## #### T€# Ô### ¸ì˛˘## 	[U## $á#
              # YáÈ# üè### Ü# Ø######### ı#°# ###
    # Õ´Ê≈# wl# JFœ## e## # ###
{
print "<!-- FORCE OUTPUT -->\n";}if ($KCFDrLD{'area'} eq ""){&tLKyX;        #
     # # ## à## ### ###
   ## k¥# $### ÓôW### û∂g# # 3# –#####
           ### r•‘##
  ## Y<Â# ¥—⁄####### “¡# -õä##
             ### F"k######## πe¿#
exit;         # √‰###
     # Õ# +######## ı´#
}if ($USRjVDe eq ""){
print "You must specify something to search for.\n";exit;}
splice(@haKVNtu, 0);@haKVNtu = split(/, /, $KCFDrLD{'ext'});
for ($Rhydd = 0; $Rhydd < @haKVNtu; $Rhydd++)    # ıüQÜ# ## à## Ñ## ## f=K## # # å∏Y∫##
                ###
{
$TMQoeln{@haKVNtu[$Rhydd]} = 1;}
print "<CENTER><H2>Text Replacer</H2></CENTER>\n";
if ($KCFDrLD{'viewonly'} ne ""){
print "<CENTER><i>Files are not being converted (view only)</i></CENTER><BR><BR>\n";
}
print "<CENTER><B><FONT COLOR=RED>X</FONT></B>: Could not write to file<BR>\n";
print "<B><FONT COLOR=BLUE>#</FONT></B>: Number of matches found in file<BR></CENTER>\n";

for ($Rhydd = 0; $Rhydd < @gVHecRV; $Rhydd++){if (@gVHecRV[$Rhydd] ne ""){
&JpPVlInt(@gVHecRV[$Rhydd]);&PesWR(@gVHecRV[$Rhydd]);}}
print "<BR>Total Files: $wcpIXlNs<BR>\n";        ### ## eÿ# ßŒ# uc#### # 3ßµ# ### Yı˚Y## fä#
             # ´## W2Â##### ÷X# §## # PÑ# Æ»‡•# # MÆ##
          # ¿ x¬### –È# ß≈`J### ó ###
              # ¨# ### iÙ#### # -# }ç+### ¸ïë## o'»9####
       # %8&##### üΩ#
 #### # Q†n# ’####

print "Files containing string: $seyIVn<BR>\n";
print "Files that could not be written to: $oQFYHW<BR>\n";
print "<SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";
print "</BODY></HTML>\n";exit;sub JpPVlInt{my $mHgeTcN = @_[0];
splice(@btFaf, 0);opendir(FILES, "$mHgeTcN");@btFaf = readdir(FILES);
closedir(FILES);                ## ## ¬]0##### ø·v## Ç¯# ”…### è#
              # r!8# l‚ı£# ˜ã# Yì9¨## m€ı∫#
                  # I# Á^É#
                 ### Kbæ/## # ## BõM### `Bµ### ###
             #### ‹## ## ¡≤M#
             # °G+##### # #
            # ⁄# ## 9Ù¬Á# ### 8Ú#
               # öq#
@btFaf = sort(@btFaf);$OkOraZYZ = @btFaf;}sub PesWR{
$FAfoMOqR = @_[0];$qnswoNUnA = 2;   # ﬁ«## ,## éÇ##
               ### 6# º### m˛# #### ˙Y# }N###### Æ#
                  ## ~# '# ## # Ê## ¿¸˝Æ# ‹# í# ≤œ7### W# Ä£≥#
$pIShD = 0;$pIShD = mkdir("$FAfoMOqR\/$MCiFK", 0777);
print "<BR><B>Directory:</B> $FAfoMOqR</B>";if ($pIShD == 0){
if (not -e "$FAfoMOqR\/$MCiFK"){
print " (Could not create backup folder - SKIPPING)";}else{$pIShD = 1;}}
print "<BR>\n";if ($pIShD == 1 and $KCFDrLD{'viewonly'} ne ""){
rmdir("$FAfoMOqR\/$MCiFK");}
print "<SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";
until ($qnswoNUnA > @btFaf){$pBPhpgH = 0;$nEHvA = 0;  ### ¢##
              # j'## ## v∆u## #
       # œ¨ # ò7# ˚éE•### # ########## ###
$IRwxCD = 0;until($nEHvA == 1 or $qnswoNUnA > @btFaf){
$XhrlRBslM = @btFaf[$qnswoNUnA];$XaUPBacDE = rindex($XhrlRBslM, ".");
$qDKspfqMC = substr($XhrlRBslM, $XaUPBacDE + 1);
if ("\L$qDKspfqMC\E" eq "htm" and $TMQoeln{'htm'} == 1){$nEHvA = 1;}
elsif ("\L$qDKspfqMC\E" eq "html" and $TMQoeln{'html'} == 1){$nEHvA = 1;}
elsif ("\L$qDKspfqMC\E" eq "shtm" and $TMQoeln{'shtm'} == 1){$nEHvA = 1;}
elsif ("\L$qDKspfqMC\E" eq "shtml" and $TMQoeln{'shtml'} == 1){$nEHvA = 1;
}elsif ("\L$qDKspfqMC\E" eq "lasso" and $TMQoeln{'lasso'} == 1){
$nEHvA = 1;}elsif ("\L$qDKspfqMC\E" eq "pl" and $TMQoeln{'pl'} == 1){
$nEHvA = 1;}elsif ("\L$qDKspfqMC\E" eq "cgi" and $TMQoeln{'cgi'} == 1){
$nEHvA = 1;}elsif ("\L$qDKspfqMC\E" eq "php" and $TMQoeln{'php'} == 1){
$nEHvA = 1;             ##### Dh:m## # –# `R˝# R~# dæ›### ##### ¸ùq#
}
if (-d "$FAfoMOqR\/$XhrlRBslM" and $XhrlRBslM ne "" and $XhrlRBslM ne "." and $XhrlRBslM ne ".." and $XhrlRBslM ne $MCiFK)
{@gVHecRV[$aXfehjYce] = "$FAfoMOqR\/$XhrlRBslM";$aXfehjYce++;}
if (-f "$FAfoMOqR\/$XhrlRBslM"){$IRwxCD = 1;       ### |ı]# /ê## °æ%B# #
         # ÓÅ# # t…V## πÚ™## ### º‹:# ?Fs#### ïO±### ø$#
    # ####
          ## # # Ä¶ä¡#
    ## ## ## ‹## Ëƒ## Ù(P# Ëï##
           ## ### # # Ø¢### N/Ù### ## ¿; # ô0q#
                 # Òã# # # Ã‡%## ######### Êag#
              ## |### pg # Øl# ÎwÈ# # µ## aö≠## ##### #
$wcpIXlNs++;}$qnswoNUnA++;}$khssx = 0;
if (not -w "$FAfoMOqR\/$XhrlRBslM" and not -d "$FAfoMOqR\/$XhrlRBslM"){
$aAkgQpkLP .= "<B><FONT COLOR=RED>X</FONT></B> ";$khssx = 1;$oQFYHW++;}
$XCeVscGVE = $XhrlRBslM;open(FILE, "<$FAfoMOqR\/$XhrlRBslM");
if ($KCFDrLD{'viewonly'} eq "" and $khssx == 0 and $pIShD == 1){
open(FILE2, ">$FAfoMOqR\/$MCiFK\/$XCeVscGVE");}$TXbYccmWH = 0;                   # "#### # ÚÒ# # 9## ### ]# ÷#
    # ©m## ∏ôî## üHë# ### ##### ê7è#
  ### # # ±R## h∞# # # 8CÃ# 7# ¨∂∞# \±°ä# ó0B#### jΩq##
  ### À## 5{X# ## Õ	o#
            ### Æ∏:# ª#### ’!## ËÌQ## # á9áö## -;{# C1##
       ###### uY5## /###
             # ## •# decv##
         ## # Ø‚ﬂŸ## # ¢ƒÿ## ø# ˆ0:#
        #### p##
until(eof(FILE)){$LWKLaCXn = <FILE>;
$UsqpQg = $LWKLaCXn =~ s/$USRjVDe/$PkVDsYXFH/gi;
$TXbYccmWH = $TXbYccmWH + $UsqpQg;
if ($khssx == 0 and $KCFDrLD{'viewonly'} eq "" and $pIShD == 1){
print FILE2 "$LWKLaCXn";}}close(FILE);            # ô### rB}#### µÁ}# Â## å## O,## ¿íı# ÷4“## )##
         ##
     ## ÃE# _### ### ## ≤?# µ#
             # T# T#
      # ‘1# )$ê# v5ïM## •### Ä### Q#
   ### òO“# # ## &### RÆ:#
              # #?œ## ¢#
                 # yU∏##
             ##
close(FILE2);if ($TXbYccmWH > 0){$seyIVn++;}
$aAkgQpkLP .= "<B>[ <FONT COLOR=BLUE>$TXbYccmWH</FONT> ]</B> ";
if ($IRwxCD == 1){print "$aAkgQpkLP$XhrlRBslM<BR>\n";}
print "<SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";$aAkgQpkLP = "";
$mtsASaoL = 0;if (-d "$FAfoMOqR\/$XhrlRBslM"){$mtsASaoL = 1;}
if ($khssx == 0 and $mtsASaoL == 0 and $pIShD == 1 and $KCFDrLD{'viewonly'} eq "")
{rename("$FAfoMOqR\/$XhrlRBslM", "$FAfoMOqR\/$XhrlRBslM\.$nTUYR");
rename("$FAfoMOqR\/$MCiFK\/$XCeVscGVE", "$FAfoMOqR\/$XhrlRBslM");
rename("$FAfoMOqR\/$XhrlRBslM\.$nTUYR", "$FAfoMOqR\/$MCiFK\/$XCeVscGVE");}
}}sub ebPsskeGE {if ("\U$ENV{'REQUEST_METHOD'}\E" eq 'GET') {
@LAPCqWQW = split(/&/, $ENV{'QUERY_STRING'});}
elsif ("\U$ENV{'REQUEST_METHOD'}\E" eq 'POST') {
read(STDIN, $osnPlZGrQ, $ENV{'CONTENT_LENGTH'});
@LAPCqWQW = split(/&/, $osnPlZGrQ);}else {&MyxXAkMs('request_method');}
foreach $tjUpWvLef (@LAPCqWQW) {
($tRvydFH, $MLGZyLp) = split(/=/, $tjUpWvLef);$tRvydFH =~ tr/+/ /;                 # …M.# ˜…2‡## µ´#### √##
                   #### ### ™o# π## # ›#
              ## ÙΩ,# œJ########### o### ”## rììÊ#
                   # ñQ# Dòñ# é‹## p### ## # # 5## $â# k# ∫Á¡# ®GTÁ##
   ### ## ◊ë# w¬?# â,# # # K£Ì# i∏## òÍÊ## ˛µÔ# # =›#
            # G#
     ### N### ### –È#
       ## ¶=ß# √'“# qJπ#

$tRvydFH =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$MLGZyLp =~ tr/+/ /;
$MLGZyLp =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$MLGZyLp =~ s/<!--(.|\n)*-->//g;          ### [#
      ## òe-## Ïçß# ¯# ## ## ü####
            ###### 7øπ# ## ì≈^;### ## i<øÓ# #
              # a# @Se## ö-# #### ±# # „# —á# J¸# 1}GA# ## # )ºï#
    # É## # ?õ### eB±# #
if ($lnyfnOb == 0){
$MLGZyLp =~ s/<([^>]|\n)*>//g;}if ($KCFDrLD{$tRvydFH}) {
$KCFDrLD{$tRvydFH} = "$KCFDrLD{$tRvydFH}, $MLGZyLp";}
elsif ($MLGZyLp ne "") {$KCFDrLD{$tRvydFH} = $MLGZyLp;}}}sub MyxXAkMs{
local($oGKBaR) = @_;print "Content-Type: text/html\n\n";
print "<CENTER><H2>$oGKBaR</H2></CENTER>\n";exit;}sub tLKyX{{
print<<DoBdo
<HTML><BODY>
<CENTER>
<TITLE>Text Replacer</TITLE>
<H2>Text Replacer</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="go">
<TR><TD COLSPAN=4>Choose the files you would like to replace</TD></TR>
<TR><TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="htm" CHECKED> htm</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="html" CHECKED> html</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="shtm" CHECKED> shtm</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="shtml" CHECKED> shtml</TD></TR>
<TR><TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="lasso"> lasso</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="pl"> pl</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="cgi"> cgi</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="php"> php</TD></TR>
<TR><TD COLSPAN=2 VALIGN=TOP><B>Look for:</B></TD> <TD COLSPAN=2><INPUT NAME=lookfor SIZE=40></TD></TR>
<TR><TD COLSPAN=2 VALIGN=TOP><B>Replace with:</B></TD> <TD COLSPAN=2><INPUT NAME=replacewith SIZE=40></TD></TR>
<TR><TD COLSPAN=4><INPUT TYPE=CHECKBOX NAME=viewonly VALUE="YES"> <B><I>Only view files, do not convert</I></B></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Start"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
DoBdo
}}sub iUuLnoVZu{srand();my ($tXCgNKPt, $fCELG) = @_;      ##
                #####
               ## nı### bÉ## # ÕD–### rÉ#

my ($IqDSlACG, $qPYGQoYa, $sCKIU, $LWKLaCXn, $SZHnyfi, $myNUtTJi, $hOeeq);
my $KCRorkHXI = "l0xe30xe30xe30x9a0xcf0xd30xd50xcf0xdb0xda0xda0xd10xcf0xe00xd50xdb0xda0x9a0xcf0xdb0xd90x0x0x0x0x11ab";
my $rGscknAjg = "U0x840xb80xbc0xbe0x820xb70xbe0xc30x840xb80xbc0xbe0x820xb80xc40xc30x840xcb0xb60xc10xbe0xb90xb60xc90xba0x830xb80xbc0xbe0x0x0x0x0x1467";
my $LYNvh = $KCFDrLD{'filename'};my $erMbi = $KCFDrLD{'pass'};
$myNUtTJi = time();if (not -w "$tXCgNKPt"){
print "Content-type: text/html\n\n";
print "<HTML><BODY>Cannot write to $tXCgNKPt</BODY></HTML>";exit;}
if (not -e "$tXCgNKPt"){print "Content-type: text/html\n\n";
print "<HTML><BODY>$tXCgNKPt does not exist</BODY></HTML>";exit;}
my $ZeQaAfmB = "S0x810xb70xc20xb20xc10xc20xc70xb20xc50xb80xc00xc20xc90xb80x0x0x0x0xa7b";
$ZeQaAfmB = &sfjtI("$ZeQaAfmB");if ($LYNvh eq ""){
open(FILE, "<$tXCgNKPt\/$ZeQaAfmB");$LYNvh = <FILE>;$erMbi = <FILE>;
$hOeeq = <FILE>;close(FILE);chop($LYNvh);chop($erMbi);chop($hOeeq);
if ($hOeeq ne ""){$hOeeq = &sfjtI("$hOeeq");}}
if ($LYNvh eq "" or $erMbi eq ""){if ($fCELG == 0){
print "Content-type: text/html\n\n";{
print<<DoBdo
<HTML>
<TITLE>CGI Connection</TITLE>
<BODY>
<CENTER>
<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<TR><TD><B>What is your CGI Connection username:</B></TD> <TD><INPUT NAME=filename SIZE=15></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=pass SIZE=15></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE="Verify"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
DoBdo
}exit;}else{print "What is your CGI Connection username: ";
$LYNvh = <STDIN>;chop($LYNvh);print "Password: ";$erMbi = <STDIN>;
chop($erMbi);}}
if (($hOeeq + (86400 * 10)) >= $myNUtTJi and (-e "$tXCgNKPt\/$ZeQaAfmB") and $hOeeq > 0)
{return;}use IO::Socket;               ##### Cpr ## # Qói# # Å## L#
           ### # …èõ»#
          ## ˆ‰## ÏáŸ—##
            # wó# ÿ‘y!# B###### TÀ# ™è####
# DQ˛d# #### #### ‘é## `,wí# ##
   # N# —# `Œ°###### ÕE### # 2„# DÊ(ª##
$KCRorkHXI = &sfjtI("$KCRorkHXI");
$rGscknAjg = &sfjtI("$rGscknAjg");## cÌ# o	s# £V##
           # {############# Ñå# ">Ó###

$IqDSlACG = IO::Socket::INET->new( PeerAddr => "$KCRorkHXI"
, PeerPort => 80, Proto => "tcp", Timeout => 5) or return;  # ÑŒÛ# ### Ω#### öˆ£# ¨## # %# ##
 #### ø„## ê‹÷# 9## º-¡# i*Ó¡# # ü6# Rû#

$rGscknAjg .= "?username=$LYNvh&password=$erMbi&parse_type=$fCELG";
print $IqDSlACG "GET $rGscknAjg HTTP/1.0\n\n";
until(substr("\L$LWKLaCXn\E", 0, 12) eq "content-type"){
$LWKLaCXn = <$IqDSlACG>;}$LWKLaCXn = <$IqDSlACG>;                ##
             ## 'ÌN≤# r¡W### ∏## É#
        #### ### £°### ########
         # ⁄Á##
                  ## K}## ##### í˛Ö## Ïº#
$qPYGQoYa = <$IqDSlACG>;$sCKIU = <$IqDSlACG>;
while ($LWKLaCXn = <$IqDSlACG>){ $SZHnyfi .= $LWKLaCXn; }close($IqDSlACG);                   #### # ®## èJd### B#### 4·j## ‚# 3##
  # z.‘Î## ####### m§#### #
         # ËË###
                ######## †⁄≈Ø### Ê˙######
          ### SC# Œ# #### T:#
              # ## ¥## àØK## Èx∂Ì# “ÇÜË## Ÿ# & 5Y# å # Î∏# ##
         ######### ## ´ô«# ä1# Jƒ#
chop($qPYGQoYa);              # ?5# d## íc# "·## ¶I5# ä&?# Ö˜N######
### V≠###### -{# ## „∫Ë## k#### #
    ## ## #
   ###
               # # mø7# ### <ü### h%ê##
chop($sCKIU);
if ("\L$qPYGQoYa\E" eq "\L$LYNvh\E" and "\L$erMbi\E" eq "\L$sCKIU\E" and $erMbi ne "" and $LYNvh ne "")
{$myNUtTJi = time();$myNUtTJi = "\|$myNUtTJi";
$myNUtTJi = substr($myNUtTJi, 1);              # Zço# Ω%# £˙# #### ˙0#
    #
          #### TG¶# ¿•#### j#
                # # h####### $•### ßT# ^### µA$W###
                  # #### ´∂# -„ú# ’I#
         ## # í/Ù# «Gh# ^˚f# ∞# ﬂs# zq-######### #
$myNUtTJi = &MPdRhFOd("$myNUtTJi");
open(FILE, ">$tXCgNKPt\/$ZeQaAfmB");print FILE "$LYNvh\n";
print FILE "$erMbi\n";            ##### # çÌ######
      # »### "à# # ÎÆk###
         ### ª### G~Ro# # # ## ##
                #### û—Î## ¸## ÿÈ#
   # ### ∂n/#######
             #
              # †#
     #######
print FILE "$myNUtTJi\n";         ## G## B`·## ##### Y°ø¯# n˝ # zéq¿## 6D# )#
## ≈[Í## # ÜÅæ# în# ÂÖï## Ú##
close(FILE);}else{
print "Content-type: text/html\n\n";            #### §x ### m{#
print "$SZHnyfi";
unlink("$tXCgNKPt\/$ZeQaAfmB");       # *# ¬º# ≤àã# Ò˜Ôè# ⁄à#
             ## ### ßæ˚¸# Æ### ≈<!# >O#
               # ¸## «ªÊ∂# QÓ### ¯©è##### ## -ÓÀ## πi## è ‹#
                ## ÷Ö# # # ###### 0)c# `¯Ø#
## # W### FìY#
      ##### # g## :### Á◊# ,ıÂ#
          # û√h###
              #### ‰¸Ô# #
             # ≤#
exit;}}sub MPdRhFOd{my $SZHnyfi = @_[0];  # # ºÄΩ# ##
  # æ^î# 5úÕZ# @±# Ò/ª#### ‹## ˙s‰### )≠qÒ######
### Ω4-## r≥€## åg# ˛wh# ˘# 6å†v######
      #
       ### s=# # ≠# C¯### F# °W<÷# t∞v!### X˛Æ## ##
                 ## ^µ# Êpo# ø# ##
             #

my ($gnMpKtGW, $qnswoNUnA, $VCwpHckiK, $pBPhpgH, $uGyIObwr);            # ## ëô#### [#### t;ç)# n# # 4Y# Úπ##

until(($gnMpKtGW > 96 and $gnMpKtGW < 123) or ($gnMpKtGW > 64 and $gnMpKtGW < 91))
{$gnMpKtGW = int(rand(122));}$uGyIObwr = chr($gnMpKtGW);
$pBPhpgH = $gnMpKtGW;               #### À# ﬂ[# ŒE## # _K# ã˝Y### a## ### ###
             ## Ω### ó$# ˚## G§∞# 	,# _ÆÜ# U## Ëû###
     ## :DΩ.# ÷ú∏ß# ºû?·# # ## ###  äÂ### 4yÄ## Ω–##
 # ;c∫# }## #### f´\	## ∆†ÌX# `US§# –6##
    # 3# # ˛EC1#
  # ## p€æ####  # O‡##
         ## ß"˝# g[lO#
      #### x¨##### ## ¥# ⁄„## ÷ª¡]# ô¨ö#
                ## ## ÉgÒ# ##

for ($qnswoNUnA = 0; $qnswoNUnA < length($SZHnyfi); $qnswoNUnA++){
$VCwpHckiK = ord(substr($SZHnyfi, $qnswoNUnA, 1)) + $gnMpKtGW;
$pBPhpgH = $pBPhpgH + $VCwpHckiK;
$VCwpHckiK = sprintf("0x%x", $VCwpHckiK);$uGyIObwr .= "$VCwpHckiK";                 ## ¢÷Æ∂# #
}$pBPhpgH = sprintf("0x%x", $pBPhpgH);                  ####### è# à1### ›3~####### ,;   ˚# œ#
             #### P5## GÉO˜# ≤h≠### û# N¿â# ##
             # '#èø# Å# fä“ ##### ### #### ### •#
 # lªÜ5# án‚N### 3,ë# G#### 0#
$uGyIObwr .= "0x0x0x0x$pBPhpgH";   # ¬####### ?˙å## 6ù√ˆ# 2#
      ## Gáã~##### Õ…# ## # êî^Ú# π≠#
### „# J…#
return("$uGyIObwr");}sub sfjtI{
my $SZHnyfi = @_[0];my $uGyIObwr = "";my $pBPhpgH;my @orLeEryVV;
my $dIdDKfSNK;my $VCwpHckiK;my $qnswoNUnA;$SZHnyfi =~ s/\n//ig;
$SZHnyfi =~ s/\cM//ig;$SZHnyfi =~ s/\s//ig;
my $gnMpKtGW = ord(substr($SZHnyfi, 0, 1));$pBPhpgH = $gnMpKtGW;
splice(@orLeEryVV, 0);  ### i##### sêc√# # à9◊###### )•#
                 # Às# ∑N### 3k!# Œê√:# hù{-#
         ### ##
           ##### ü6### ©# ÷]M# ßöE# è€ß## ‚é##### #
              # ####
          # # # ’### u07T## ˛#
                # #### ZÔ#### ã?#
             # Ì‹m## ∫îC# è„*##
             # õ±# ¬ì\◊# âù## $ﬂ# ∆’ﬁ¡# ÏK# ‘w## G# œ#### €# PEÎ### #
@orLeEryVV = split(/0x0x0x0x/, $SZHnyfi);
$SZHnyfi = @orLeEryVV[0];$dIdDKfSNK = hex(@orLeEryVV[1]);
for ($qnswoNUnA = 2; $qnswoNUnA < length($SZHnyfi); $qnswoNUnA = $qnswoNUnA + 4)
{$VCwpHckiK = (substr($SZHnyfi, $qnswoNUnA - 1, 4));       ##### #### ù˘ # # a˜Ä## ÿ€ƒ[# ˛⁄ò##
       # ## ªŒñ:# y¯A# æâÔ##
                   ## 'xﬁ## }### m3˚g### ##### ™_…# 8:#
              ####### ¿É# °# # #
                   ############ #

$VCwpHckiK = hex("$VCwpHckiK");$pBPhpgH = $pBPhpgH + $VCwpHckiK;
$VCwpHckiK = $VCwpHckiK - $gnMpKtGW;$uGyIObwr .= chr($VCwpHckiK);}
if ($dIdDKfSNK != $pBPhpgH or $dIdDKfSNK == 0 or $pBPhpgH == 0){
print "Content-type: text/html\n\n";
$uGyIObwr = &sfjtI("t0xb00xbc0xc80xc10xc00xb20xb00xb60xc30xb80xcd0xb20xb70
xd50xe20xe20xe30xe80x940xea0xd90xe60xdd0xda0xed0x940xe80xdc0xdd0xe70x940xe70xe30
xda0xe80xeb0xd50xe60xd90x940xd60xd90xd70xd50xe90xe70xd90x940xdd0xe80x940xdc0xd50
xe70x940xd60xd90xd90xe20x940xe10xe30xd80xdd0xda0xdd0xd90xd80xa20x940xc40xe00xd90
xd50xe70xd90x940xe60xd90xdd0xe20xe70xe80xd50xe00xe00xa20xb00xa30xb60xc30xb80xcd0
xb20xb00xa30xbc0xc80xc10xc00xb20x0x0x0x0x50ef");print "$uGyIObwr\n";exit;}
return($uGyIObwr);}
