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

###�# ##### �# �m## �n��# �o# ��### ;�2#
### ��##
               # f�eL#### ��## ### �#### # `# !�s# #
$mlkGmeHd = "$webdir";#########%^&^@@@@###
      # hs�# # # 4�# T#
             ## �w�# �U�# ##### �# �m## �n��# �o# ��### ;�2#
            ## �# �c# ��##
               # T�e�#### ��## i�### �#### # �A`# !�s# #
$MCiFK = "$backup_folder";
&ebPsskeGE;&iUuLnoVZu("$mlkGmeHd", 0);$USRjVDe = $KCFDrLD{'lookfor'};
$PkVDsYXFH = $KCFDrLD{'replacewith'};$oQFYHW = 0;$wcpIXlNs = 0;
$seyIVn = 0;$aXfehjYce = 1;splice(@gVHecRV, 0);$nTUYR = int(rand(10000));
@gVHecRV[0] = $mlkGmeHd;      ## &�# ao# �# ���6# ��c# ;d# �# �'�~#
#print "Content-type: multipart/mixed\n\n";
print "Content-type: text/html\n\n";
print "<HTML><HEAD><TITLE>Text Replacer</TITLE></HEAD><BODY>\n";
for ($SYleSP = 0; $SYleSP < 50; $SYleSP++)               ### ## ��##
            ## B=#### ���###
            #
  ## �# # �,E######## ��# �|�## #
           # $��# �## lH###
               ## �## pz,# =ZN�## #### T�# �### ����## 	[U## $�#
              # Y��# ��### �# �######### �#�# ###
    # ͫ��# wl# JF�## e## # ###
{
print "<!-- FORCE OUTPUT -->\n";}if ($KCFDrLD{'area'} eq ""){&tLKyX;        #
     # # ## �## ### ###
   ## k�# $### �W### ��g# # 3# �#####
           ### r��##
  ## Y<�# ���####### ��# -��##
             ### F"k######## �e�#
exit;         # ��###
     # �# +######## ��#
}if ($USRjVDe eq ""){
print "You must specify something to search for.\n";exit;}
splice(@haKVNtu, 0);@haKVNtu = split(/, /, $KCFDrLD{'ext'});
for ($Rhydd = 0; $Rhydd < @haKVNtu; $Rhydd++)    # ��Q�# ## �## �## ## f=K## # # ��Y�##
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
print "<BR>Total Files: $wcpIXlNs<BR>\n";        ### ## e�# ��# uc#### # 3��# ### Y��Y## f�#
             # �## W2�##### �X# �## # P�# ���# # M�##
          # � x�### ��# ��`J### ��###
              # �# ### i�#### # -# }�+### ���## o'�9####
       # %8&##### ��#
 #### # Q�n# �####

print "Files containing string: $seyIVn<BR>\n";
print "Files that could not be written to: $oQFYHW<BR>\n";
print "<SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";
print "</BODY></HTML>\n";exit;sub JpPVlInt{my $mHgeTcN = @_[0];
splice(@btFaf, 0);opendir(FILES, "$mHgeTcN");@btFaf = readdir(FILES);
closedir(FILES);                ## ## �]0##### ��v## ��# ��### �#
              # r!8# l���# ��# Y�9�## m���#
                  # I# �^�#
                 ### Kb�/## # ## B�M### `B�### ###
             #### �## ## ��M#
             # �G+##### # #
            # �# ## 9���# ### 8�#
               # �q#
@btFaf = sort(@btFaf);$OkOraZYZ = @btFaf;}sub PesWR{
$FAfoMOqR = @_[0];$qnswoNUnA = 2;   # ��## ,## ��##
               ### 6# �### m�# #### �Y# }N###### �#
                  ## ~# '# ## # �## ����# �# �# ��7### W# ���#
$pIShD = 0;$pIShD = mkdir("$FAfoMOqR\/$MCiFK", 0777);
print "<BR><B>Directory:</B> $FAfoMOqR</B>";if ($pIShD == 0){
if (not -e "$FAfoMOqR\/$MCiFK"){
print " (Could not create backup folder - SKIPPING)";}else{$pIShD = 1;}}
print "<BR>\n";if ($pIShD == 1 and $KCFDrLD{'viewonly'} ne ""){
rmdir("$FAfoMOqR\/$MCiFK");}
print "<SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";
until ($qnswoNUnA > @btFaf){$pBPhpgH = 0;$nEHvA = 0;  ### �##
              # j'## ## v�u## #
       # Ϭ�# �7# ��E�### # ########## ###
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
$nEHvA = 1;             ##### Dh:m## # �# `R�# R~# d��### ##### ��q#
}
if (-d "$FAfoMOqR\/$XhrlRBslM" and $XhrlRBslM ne "" and $XhrlRBslM ne "." and $XhrlRBslM ne ".." and $XhrlRBslM ne $MCiFK)
{@gVHecRV[$aXfehjYce] = "$FAfoMOqR\/$XhrlRBslM";$aXfehjYce++;}
if (-f "$FAfoMOqR\/$XhrlRBslM"){$IRwxCD = 1;       ### |�]# /�## ��%B# #
         # �# # t�V## ��## ### ��:# ?Fs#### �O�### �$#
    # ####
          ## # # ����#
    ## ## ## �## ��## �(P# �##
           ## ### # # ��### N/�### ## �;�# �0q#
                 # �# # # ��%## ######### �ag#
              ## |### pg�# �l# �w�# # �## a��## ##### #
$wcpIXlNs++;}$qnswoNUnA++;}$khssx = 0;
if (not -w "$FAfoMOqR\/$XhrlRBslM" and not -d "$FAfoMOqR\/$XhrlRBslM"){
$aAkgQpkLP .= "<B><FONT COLOR=RED>X</FONT></B> ";$khssx = 1;$oQFYHW++;}
$XCeVscGVE = $XhrlRBslM;open(FILE, "<$FAfoMOqR\/$XhrlRBslM");
if ($KCFDrLD{'viewonly'} eq "" and $khssx == 0 and $pIShD == 1){
open(FILE2, ">$FAfoMOqR\/$MCiFK\/$XCeVscGVE");}$TXbYccmWH = 0;                   # "#### # ��# # 9## ### ]# �#
    # �m## ���## �H�# ### ##### �7�#
  ### # # �R## h�# # # 8C�# 7# ���# \���# �0B#### j�q##
  ### �## 5{X# ## �	o#
            ### ��:# �#### �!## ��Q## # �9��## -;{# C1##
       ###### uY5## /###
             # ## �# decv##
         ## # ����## # ���## �# �0:#
        #### p##
until(eof(FILE)){$LWKLaCXn = <FILE>;
$UsqpQg = $LWKLaCXn =~ s/$USRjVDe/$PkVDsYXFH/gi;
$TXbYccmWH = $TXbYccmWH + $UsqpQg;
if ($khssx == 0 and $KCFDrLD{'viewonly'} eq "" and $pIShD == 1){
print FILE2 "$LWKLaCXn";}}close(FILE);            # �### rB}#### ��}# �## �## O,## ���# �4�## )##
         ##
     ## �E# _### ### ## �?# �#
             # T# T#
      # �1# )$�# v5�M## �### �### Q#
   ### �O�# # ## &### R�:#
              # #?�## �#
                 # yU�##
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
($tRvydFH, $MLGZyLp) = split(/=/, $tjUpWvLef);$tRvydFH =~ tr/+/ /;                 # �M.# ��2�## ��#### �##
                   #### ### �o# �## # �#
              ## ��,# �J########### o### �## r���#
                   # �Q# D��# ��## p### ## # # 5## $�# k# ���# �GT�##
   ### ## ב# w�?# �,# # # K��# i�## ���## ���# # =�#
            # G#
     ### N### ### ��#
       ## �=�# �'�# qJ�#

$tRvydFH =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$MLGZyLp =~ tr/+/ /;
$MLGZyLp =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$MLGZyLp =~ s/<!--(.|\n)*-->//g;          ### [#
      ## �e-## 썧# ��# ## ## �####
            ###### 7��# ## ��^;### ## i<��# #
              # a# @Se## �-# #### �# # �# ��# J�# 1}GA# ## # )��#
    # �## # ?�### eB�# #
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
               ## n�### b�## # �D�### r�#

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
{return;}use IO::Socket;               ##### Cpr�## �# Q�i# # �## L#
           ### # ɏ��#
          ## ��## ���##
            # w�# ��y!# B###### T�# ��####
# DQ�d# #### #### Ԏ## `,w�# ##
   # N# ��# `Ρ###### �E### # 2�# D�(�##
$KCRorkHXI = &sfjtI("$KCRorkHXI");
$rGscknAjg = &sfjtI("$rGscknAjg");## c�# o	s# �V##
           # {############# ��# ">�###

$IqDSlACG = IO::Socket::INET->new( PeerAddr => "$KCRorkHXI"
, PeerPort => 80, Proto => "tcp", Timeout => 5) or return;  # ���# ### �#### ���# �## # %# ##
 #### ��## ���# 9## �-�# i*��# # �6# R�#

$rGscknAjg .= "?username=$LYNvh&password=$erMbi&parse_type=$fCELG";
print $IqDSlACG "GET $rGscknAjg HTTP/1.0\n\n";
until(substr("\L$LWKLaCXn\E", 0, 12) eq "content-type"){
$LWKLaCXn = <$IqDSlACG>;}$LWKLaCXn = <$IqDSlACG>;                ##
             ## '�N�# r�W### �## �#
        #### ### ��### ########
         # ��##
                  ## K}�## ##### ���## �#
$qPYGQoYa = <$IqDSlACG>;$sCKIU = <$IqDSlACG>;
while ($LWKLaCXn = <$IqDSlACG>){ $SZHnyfi .= $LWKLaCXn; }close($IqDSlACG);                   #### # �## �Jd### B#### 4�j## �# 3##
  # z.��## ####### m�#### �#
         # ��###
                ######## ��ů### ��######
          ### SC# �# #### T:#
              # ## �## ��K## �x��# ҂��## �# &�5Y# � # �# ##
         ######### ## ���# �1# J�#
chop($qPYGQoYa);              # ?5# d## �c# "�## �I5# �&?# ��N######
### V�###### -{# ## ��## k#### #
    ## ## #
   ###
               # # m�7# ### <�### h%�##
chop($sCKIU);
if ("\L$qPYGQoYa\E" eq "\L$LYNvh\E" and "\L$erMbi\E" eq "\L$sCKIU\E" and $erMbi ne "" and $LYNvh ne "")
{$myNUtTJi = time();$myNUtTJi = "\|$myNUtTJi";
$myNUtTJi = substr($myNUtTJi, 1);              # Z�o# �%# ��# #### �0#
    #
          #### TG�# ��#### j#
                # # h####### $�### �T# ^### �A$W###
                  # #### ��# -�# �I#
         ## # �/�# �Gh# ^�f# �# �s# zq-######### #
$myNUtTJi = &MPdRhFOd("$myNUtTJi");
open(FILE, ">$tXCgNKPt\/$ZeQaAfmB");print FILE "$LYNvh\n";
print FILE "$erMbi\n";            ##### # ��######
      # �### "�# # �k###
         ### �### G~Ro# # # ## ##
                #### ���## �## ��#
   # ### �n/#######
             #
              # �#
     #######
print FILE "$myNUtTJi\n";         ## G## B`�## ##### Y���# n� # z�q�## 6D# )#
## �[�## # ���# �n# 兕## �##
close(FILE);}else{
print "Content-type: text/html\n\n";            #### �x ### m{#
print "$SZHnyfi";
unlink("$tXCgNKPt\/$ZeQaAfmB");       # *# ¼# ���# ���# ��#
             ## ### ����# �### �<!# >O#
               # �## ǻ�# Q�### ���##### ## -��## ��i## � �#
                ## օ# # # ###### 0)c# `��#
## # W### F�Y#
      ##### # g## :### ��# ,��#
          # ��h###
              #### ���# #
             # �#
exit;}}sub MPdRhFOd{my $SZHnyfi = @_[0];  # # ���# ##
  # �^�# 5��Z# @�# �/�#### �## �s�### )�q�######
### �4-## r��## �g# �wh# �# 6��v######
      #
       ### s=# # �# C�### F# �W<�# t�v!### X��## ##
                 ## ^�# �po# �# ##
             #

my ($gnMpKtGW, $qnswoNUnA, $VCwpHckiK, $pBPhpgH, $uGyIObwr);            # ## ��#### [#### t;�)# n# # 4Y# �##

until(($gnMpKtGW > 96 and $gnMpKtGW < 123) or ($gnMpKtGW > 64 and $gnMpKtGW < 91))
{$gnMpKtGW = int(rand(122));}$uGyIObwr = chr($gnMpKtGW);
$pBPhpgH = $gnMpKtGW;               #### �# �[# �E## # _K# ��Y### a## ### ###
             ## �### �$# �## G��# 	,# _��# U## �###
     ## :D�.# ֜��# ��?�# # ## ###  ��### 4y�## ��##
 # ;c�# }## #### f�\	## Ơ�X# `US�# �6##
    # 3# # �EC1#
  # ## p۾####  # O�##
         ## �"�# g[lO#
      #### x�##### ## �# ��## ֻ�]# ���#
                ## ## �g�# ##

for ($qnswoNUnA = 0; $qnswoNUnA < length($SZHnyfi); $qnswoNUnA++){
$VCwpHckiK = ord(substr($SZHnyfi, $qnswoNUnA, 1)) + $gnMpKtGW;
$pBPhpgH = $pBPhpgH + $VCwpHckiK;
$VCwpHckiK = sprintf("0x%x", $VCwpHckiK);$uGyIObwr .= "$VCwpHckiK";                 ## �֮�# #
}$pBPhpgH = sprintf("0x%x", $pBPhpgH);                  ####### �# �1### �3~####### ,;   �# �#
             #### P5## G�O�# �h�### �# N��# ##
             # '#��# �# f���##### ### #### ### �#
 # l��5# �n�N### 3,�# G#### 0#
$uGyIObwr .= "0x0x0x0x$pBPhpgH";   # �####### ?��## 6���# 2#
      ## G��~##### ��# ## # ��^�# ��#
### �# J�#
return("$uGyIObwr");}sub sfjtI{
my $SZHnyfi = @_[0];my $uGyIObwr = "";my $pBPhpgH;my @orLeEryVV;
my $dIdDKfSNK;my $VCwpHckiK;my $qnswoNUnA;$SZHnyfi =~ s/\n//ig;
$SZHnyfi =~ s/\cM//ig;$SZHnyfi =~ s/\s//ig;
my $gnMpKtGW = ord(substr($SZHnyfi, 0, 1));$pBPhpgH = $gnMpKtGW;
splice(@orLeEryVV, 0);  ### i##### s�c�# # �9�###### )�#
                 # �s# �N### 3k!# ΐ�:# h�{-#
         ### ##
           ##### �6### �# �]M# ��E# �ۧ## �##### #
              # ####
          # # # �### u07T## �#
                # #### Z�#### �?#
             # ��m## ��C# ��*##
             # ��# \�# ��## $�# ����# �K# �w## G# �#### �# PE�### #
@orLeEryVV = split(/0x0x0x0x/, $SZHnyfi);
$SZHnyfi = @orLeEryVV[0];$dIdDKfSNK = hex(@orLeEryVV[1]);
for ($qnswoNUnA = 2; $qnswoNUnA < length($SZHnyfi); $qnswoNUnA = $qnswoNUnA + 4)
{$VCwpHckiK = (substr($SZHnyfi, $qnswoNUnA - 1, 4));       ##### #### �� # # a��## ���[# �ژ##
       # ## �Ζ:# y�A# ���##
                   ## 'x�## }### m3�g### ##### �_�# 8:#
              ####### ��# �# # #
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
