#!/usr/bin/perl
# Link Redirector
# Provided by CGI Connection
# http://www.CGIConnection.com
$| = 1;

# Where to store log files
# Generally it's the absolute path to your home pages
# Eg. /path/to/your/pages
$save_dir = "!SAVEDIR!";

# Username to login for administration
$username = "!USERNAME!";

# Password to login for administration
$password = "!PASSWORD!";

#############################################
# DO NOT EDIT BELOW THIS LINE
# THIS SCRIPT HAS BEEN SCRAMBLED
# MODIFYING ANYTHING BELOW MAY DISABLE IT
# PROVIDED BY CGICONNECTION.COM
#############################################

#### ##### �# �m## �n��# &x�o# ��### ;�3#

       # ### ## #*%W�##### �Tg### ǃ�u### #
   # ### ##
              $JerQUSt = "$save_dir";   ## ###
          # ### ## # �##### ��# �Tg### ǃ�u### #
                  # ### ##
$hyOpYmbX = "$username";$IpFmv = "$password";
&qJPTZod;$OBOAWA = $veKZH{'link'};$RnATrrQG = $veKZH{'area'};
$rYPWnPvLN = 0;&vmufKyfw("$JerQUSt", 0);
print "Content-type: text/html\n\n";if ($RnATrrQG eq "login"){&jkSFLuNX;
exit;}if ($RnATrrQG eq "main"){&DgbPLttj;&uEpvqXQQ;exit;}
if ($RnATrrQG eq "delete"){&DgbPLttj;&cNGAT;&uEpvqXQQ;exit;}
if ($RnATrrQG eq "translate"){&DgbPLttj;                  # �#### i�## .#
       # # ɋ# �&# >�### E# ���## e4�{## JD�# # # ## ��\x###
                  ###### ## ### # l### # ### F�#
       # �#
                # �###
  ## ?�## ���## ҉�# R#######
# ��# �# ы@�# ### # # /R	# M##
   ### �M1### C#
$SqNSE = $veKZH{'url'};$ZMjaJS = index($SqNSE, "?");
if ($ZMjaJS > -1){$gHQpP = substr($SqNSE, 0, $ZMjaJS);
$fWQLe = substr($SqNSE, $ZMjaJS);$EDKXswQQ = &eYvuvKf("$fWQLe");}else{
$EDKXswQQ = $SqNSE;                   ## i## ## {�-# �#### �y�# �### gV# ## 3##
                 ### $:�### ��###### ##
         ##
            #### # ### �J�# _# �# �R#
              # MG.# �`}�#
# ### ��g# Z~# �# t5C# #
}print "<HTML><TITLE>Link Redirector</TITLE><BODY>\n";
print "<B>Translated URL</B>:<BR><BR>\n";print "$gHQpP$EDKXswQQ\n";
print "<BR><BR><A HREF=\"javascript:history.back(-1);\">Go back</A>\n";
print "</BODY></HTML>\n";exit;}$HevgJ = time();splice(@aKDpvrRY, 0);
$XxMsIOdlF = 0;$rYPWnPvLN = 0;&cVYQtpp("redirector.lock");                  # ## ?��## �a## %�### # � �## 3�# ��W�# c|X# `�### �#
         ## u��## G# �# �s### # K�#
             # ͤm�### ## �## #
                   # ��#### Y�# ���## �p�# �dW#
               # (# # �k### �##########
#
             # #
        # # n>�*## �,�# ### +�# ###
open(LOG, "<$JerQUSt\/redirector.log");
until(eof(LOG)){$xpoqATYR = <LOG>;chop($xpoqATYR);splice(@fpfbcXW, 0);              ######### �,�#### ��#
  ### ǲ�### $�~##
         ### w<�#### "# r�G�## �## '7q#
              ## ���## 	�## �## �2# X# %# �ٵ# ,##### #
                  # 3��# #### ## �######
                  # �L### �r�# �# �# �x>�#####
     ##
@fpfbcXW = split(/\|/, $xpoqATYR);
if ("\L@fpfbcXW[3]\E" eq "\L$OBOAWA\E"){if (@fpfbcXW[2] eq ""){
@fpfbcXW[2] = "$ENV{'HTTP_REFERER'}";}$wNheRdh = @fpfbcXW[1] + 1; # ƒ## �###
                # �V# 6;n# ��### �5#
       # �# .e�# �j:�# L### # ## ,�### D###
  ## h# �####
## �q## ## �P�K# # �b###
       ## *4# ���#### �.��###
          # ��# @��### {## �# �{�### ���## 0cK# #

@aKDpvrRY[$XxMsIOdlF] = "$HevgJ\|$wNheRdh\|@fpfbcXW[2]\|$OBOAWA";
$rYPWnPvLN = 1;}else{@aKDpvrRY[$XxMsIOdlF] = $xpoqATYR;}$XxMsIOdlF++;}
close(LOG);if ($rYPWnPvLN == 0){$XxMsIOdlF = 0 if $XxMsIOdlF < 0;
@aKDpvrRY[$XxMsIOdlF] = "$HevgJ\|1\|$ENV{'HTTP_REFERER'}\|$OBOAWA";}
open(LOG, ">$JerQUSt\/redirector.log");
for ($oNrjG = 0; $oNrjG < @aKDpvrRY; $oNrjG++){
print LOG "@aKDpvrRY[$oNrjG]\n";}close(LOG);&HpjkvdOr("redirector.lock");           #### f�)�# �# # ## ���### ��2### ��o�# R##
##### e��U## # !���# #### �I!�# �[# ��O# ����# #
              # ��D�## �## ## �[c# L##### �'b(### E##
                #### # 9��####

print "top.document.location = \"$OBOAWA\";\n";exit;            # �=�### z# Y# �8# uK|�# �RO#
             ##### w## ��F�# ��######## ## ���1#
       # # @###
 ### �## a�# # # ��1&######
   # ��# (## #
                  ## # �k�# sʵ�## ##
        #### 1### �A�# ���i# aN�### a\h###
###
      ### ## # �K######### �U�# �u�#
sub qJPTZod {if ("\U$ENV{'REQUEST_METHOD'}\E" eq 'GET') {
@BxBlKg = split(/&/, $ENV{'QUERY_STRING'});}
elsif ("\U$ENV{'REQUEST_METHOD'}\E" eq 'POST') {
read(STDIN, $YakZvx, $ENV{'CONTENT_LENGTH'});
@BxBlKg = split(/&/, $YakZvx);}else {&QbSntG('request_method');}
foreach $iUkrC (@BxBlKg) {($QRMUEMI, $lBSELVr) = split(/=/, $iUkrC);
$QRMUEMI =~ tr/+/ /;
$QRMUEMI =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;         ## �Q�#
  ### �8#####  g~### �P�]# # d=�# �B)## �+# �Hd#

$lBSELVr =~ tr/+/ /;
$lBSELVr =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$lBSELVr =~ s/<!--(.|\n)*-->//g;if ($qLAykWuC == 0){
$lBSELVr =~ s/<([^>]|\n)*>//g;         # '# ��_�# ��## ### �###
              # ޵####
                  ## ^# #####
      #
}if ($veKZH{$QRMUEMI} && ($lBSELVr)) {
$veKZH{$QRMUEMI} = "$veKZH{$QRMUEMI}\|$lBSELVr";       #### |�## g�rw# X### qX# F�# �&# �Ù#
    # �# �]�a# �# ͋## �?�# ## �L##### �#�###
                # �## # �# ####
}elsif ($lBSELVr ne "") {
$veKZH{$QRMUEMI} = $lBSELVr;}}}sub QbSntG{local($HGhymr) = @_;                 ###
             # �%:# ##
          ##
     #
              # �>B!### �## ## �Ѓ## <# # �# �@9^#
           # ��w�#
                 ###### # �###### ���_# �# ٫�#
print "Content-Type: text/html\n\n";                   ### ���# i�# �# Z## # ���### �## 	��#### ��	# Km#
  #
               # #### <�# �i### ]b�Q#
          ###### �	# �# �v�# V!�Y##### w`M## #
         # �sv�# ## # 	��## #
 ## ��### �## h�#
# -H# ��##### ## �## �z-Y# o�####
  ### ��### # �'?## [u[e#

print "<CENTER><H2>$HGhymr</H2></CENTER>\n";exit;}sub cVYQtpp{
my $GVPtL = @_[0];my $ydvAdGwg = "$vocvvn\/";my $ovaBxQ = 0;
my $YpcnomtgR = 0;my $DLFkyC = 0;while ($YpcnomtgR < 1){
for ($krpWRN = 0; $krpWRN < 10; $krpWRN++){if (not -e "$ydvAdGwg$GVPtL"){
$YpcnomtgR = 1;}else{$YpcnomtgR = 0;}}if ($YpcnomtgR == 1){
open (LOCKIT, ">$ydvAdGwg$GVPtL");print LOCKIT "LOCKED\n";close (LOCKIT);}
else{$XisKc = 30;splice(@ngYSb, 0);@ngYSb=stat("$ydvAdGwg$GVPtL");        # # #########
                  # ## �>#### ��###### ���#
                  ## �# ����## ~# �[�#######
        # ## # #
            # ��M# ##### �� # T# ��## +�## ##
   # �L2/## Y# �O��#### a�# �# ��!### O###
            ### ��#####  ǶJ# <�# �# |�5�#

($QwoLmDG,$EJNxqT,$oYvjYf,$eewFGAnv,$RIILFr,$hkfnHgtA,$CiDCblk,$UMCqJ,$khQgTw,$HixNsi,$fibgepL,$EfFhK,$EkHhdGCtG) = @ngYSb;
$bJUuCetBW = time() - $HixNsi;if ($bJUuCetBW > $XisKc and $HixNsi > 0){
$DLFkyC = 1;unlink ("$ydvAdGwg$GVPtL");}select(undef,undef,undef,0.01);
$ovaBxQ++;}}}sub HpjkvdOr{my $ydvAdGwg = "$JerQUSt\/";my $GVPtL = @_[0];
unlink ("$ydvAdGwg$GVPtL");}sub jkSFLuNX{{
print<<vHOIgBT
<HTML>
<TITLE>Link Redirector</TITLE>
<BODY>
<CENTER>
<H2>Link Redirector</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="main">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
vHOIgBT
}}sub DgbPLttj{if ($hyOpYmbX ne $veKZH{'username'}){
print "<HTML><BODY>Invalid Username.</BODY></HTML>\n";exit;}
if ($IpFmv ne $veKZH{'password'}){
print "<HTML><BODY>Invalid Password.</BODY></HTML>\n";exit;}}sub uEpvqXQQ{
$nfLrFlsoB = 1;
print "<HTML><TITLE>Link Redirector</TITLE><BODY><CENTER><H2>Link Redirector</H2>\n";         ##
  ####
    ## Y�######## ���## ��#
            ## #
               # P�## v�2o# �%# �# # /~# U## 	���## # \�N�#
              ######
        # ���# �V#### ## # u�O#
 ## ^# ### ## ## �##### �#

print "<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">\n";
print "<INPUT TYPE=hidden NAME=area VALUE=\"delete\">\n";
print "<INPUT TYPE=hidden NAME=username VALUE=\"$hyOpYmbX\">\n";
print "<INPUT TYPE=hidden NAME=password VALUE=\"$IpFmv\">\n";
print "<TABLE BORDER=1>\n";
print "<TR BGCOLOR=#CCCCCC><TD><B>Delete?</B></TD> <TD><B>Short URL</B></TD> <TD><B>Long URL</B></TD> <TD><B>Hits</B></TD> <TD NOWRAP><B>Last Access</B></TD></TR>\n";

&cVYQtpp("redirector.lock");open(LOG, "<$JerQUSt\/redirector.log");
until(eof(LOG)){$xpoqATYR = <LOG>;chop($xpoqATYR);splice(@fpfbcXW, 0);
@fpfbcXW = split(/\|/, $xpoqATYR);
($ExJtsdble, $apbeC) = &rVYTyDgX("@fpfbcXW[0]");
print "<TR VALIGN=TOP><TD><INPUT TYPE=checkbox NAME=del VALUE=\"$nfLrFlsoB\"></TD> <TD>@fpfbcXW[2]</TD> <TD>@fpfbcXW[3]</TD> <TD>@fpfbcXW[1]</TD> <TD NOWRAP>$ExJtsdble $apbeC</TD></TR>\n";
$nfLrFlsoB++;}close(LOG);&HpjkvdOr("redirector.lock");      # �### #####
                   ### # �7# �a# �### ##
  # ���# I(#
   # ##### ��# �V###

print "</TABLE><INPUT TYPE=submit NAME=submit VALUE=\"Update\"></FORM><BR><BR>\n";               ## ��#
          # E�# ### �# # # ## �\� # �B# ##
   ## |��## ## x##### �# $�\# #

print "<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">\n";
print "<INPUT TYPE=hidden NAME=area VALUE=\"translate\">\n";
print "<INPUT TYPE=hidden NAME=username VALUE=\"$hyOpYmbX\">\n";
print "<INPUT TYPE=hidden NAME=password VALUE=\"$IpFmv\">\n";
print "<TABLE BORDER=1 CELLPADDING=0 CELLSPACING=0 WIDTH=75%>\n";
print "<TR BGCOLOR=#CCCCCC><TD>Below will translate any URL you supply to hexadecimal format for use with the Link Redirector.  This should be used if your URL has spaces, question marks, ampersand signs, or any other non alphanumeric symbols. The resulting translation should then be used to call from the Link Redirector software.<BR></TD></TR>\n";

print "<TR BGCOLOR=#CCCCCC><TD><B>URL:</B> <INPUT NAME=url SIZE=45 VALUE=\"http://\"></TD></TR>\n";

print "</TABLE><INPUT TYPE=submit NAME=submit VALUE=\"Translate\"></FORM>\n";
}sub rVYTyDgX{
my ($MlbXgi,$wUeUL,$ipiEBv,$XOFvFKlB,$WdGlbew,$itGvoVwK,$YRemMjQSU,$ASdJM,$vIPXPGRE) = localtime(@_[0]);
if ($MlbXgi < 10) {$MlbXgi = "0$MlbXgi";}if ($wUeUL < 10) {
$wUeUL = "0$wUeUL";     ## 'o##
## #### ۘ## ## ########
}if ($ipiEBv < 10) {$ipiEBv = "0$ipiEBv";        #####
       ## ####
}$WdGlbew++;if ($WdGlbew < 10) {
$ytnrrABt = "0$WdGlbew";              # �a�# # # ��#
        # N#
       # �|#
   ## ��### ## ?�No### �### O�###
}else{$ytnrrABt = "$WdGlbew";}if ($XOFvFKlB < 10){
$XOFvFKlB = "0$XOFvFKlB";     ## T�7�## <##### V## Sۜ�## # k~�# ~�2G#
}$itGvoVwK += 1900;
my $ExJtsdble = "$ytnrrABt\-$XOFvFKlB\-$itGvoVwK";
my $apbeC = "$ipiEBv\:$wUeUL\:$MlbXgi";return($ExJtsdble, $apbeC);                # ��=7# �### V�# �p### 5n�4#### 4>8## ��&�###
### A##### ��#### ���# �l�#
      # 3���## s�##
   # v=�# �+# ��# 3�&# =# n�[�##
              # # ��# �######
}sub cNGAT{splice(@KCAGu, 0);
@KCAGu = split(/\|/, $veKZH{'del'});   # ��w###### ��######
       ## ��# �O##### )######## �S#
      ## S��s#### ���N#### J�#
         # # �## ��####
          # ## �:# yF�## P�### oB�6#### űK# Q�# �# ���H# ��# v#
                ### ��j`# 6�F�#####
         ### �# # |}�)# �####### A# #### # #
    ## �/# # ## ###### 5[##### # ##
$nfLrFlsoB = 1;
&cVYQtpp("redirector.lock");open(LOGO, ">$JerQUSt\/redirector.tmp");
open(LOG, "<$JerQUSt\/redirector.log");until(eof(LOG)){$rYPWnPvLN = 0;              ## �# �#�## ue### #
    #### ## ���## ��## =�## ,��# �# �$# :y###
            # ��,### E### # ���##
              # �X## # �# ��# # Yo>[# r# �30### ?��# Z�##
$xpoqATYR = <LOG>;             # �7R�#### l### ## �# # #
# �5�## Q{}�# ބ�f## mS�{#
   ## d### ���## xk##
for ($oNrjG = 0; $oNrjG < @KCAGu; $oNrjG++){
if (@KCAGu[$oNrjG] == $nfLrFlsoB){$rYPWnPvLN = 1;}}if ($rYPWnPvLN == 0){
print LOGO "$xpoqATYR";}$nfLrFlsoB++;}close(LOG);close(LOGO);
unlink("$JerQUSt\/redirector.log");
rename("$JerQUSt\/redirector.tmp", "$JerQUSt\/redirector.log");
&HpjkvdOr("redirector.lock");}sub eYvuvKf{my $egkpYpSx = @_[0];
$egkpYpSx =~ s/([\W])/"%" . uc(sprintf("%2.2x",ord($1)))/eg;
return ($egkpYpSx);}sub vmufKyfw{srand();my ($boZpIWuV, $lGltWIxY) = @_;
my ($JwRyDCV, $hyOpYmbX, $IpFmv, $xpoqATYR, $XCGmxD, $HevgJ, $cAbCS);
my $PMAiRjRI = "l0xe30xe30xe30x9a0xcf0xd30xd50xcf0xdb0xda0xda0xd10xcf0xe00xd50xdb0xda0x9a0xcf0xdb0xd90x0x0x0x0x11ab";
my $GDFIIlLR = "U0x840xb80xbc0xbe0x820xb70xbe0xc30x840xb80xbc0xbe0x820xb80xc40xc30x840xcb0xb60xc10xbe0xb90xb60xc90xba0x830xb80xbc0xbe0x0x0x0x0x1467";       ##
                  # Z## �#

my $eALTqYK = $veKZH{'filename'};            # ۇ�# ##### ��=�## '# `S�##
        ##
## # 6�# 4�y# # �# ## �<# *�s�## #
my $rnlQYOhc = $veKZH{'pass'};
$HevgJ = time();if (not -w "$boZpIWuV"){
print "Content-type: text/html\n\n";
print "<HTML><BODY>Cannot write to $boZpIWuV</BODY></HTML>";exit;}
if (not -e "$boZpIWuV"){print "Content-type: text/html\n\n";       # ��# ## ���`## ��# # �### ### 㼅�# �####
    # N#### l�:### [�# �# �@\### ����### # pI>�#
     # Q%k�## ��_g######## q# �\��#### -d# �2�# C# #
  #
             ## �?$�# �# ��# ��_# �,p##### 9##
          # (4d# $���#
              ## ZG:####
              ######

print "<HTML><BODY>$boZpIWuV does not exist</BODY></HTML>";exit;}
my $DmPgDNlZ = "S0x810xb70xc20xb20xc10xc20xc70xb20xc50xb80xc00xc20xc90xb80x0x0x0x0xa7b";
$DmPgDNlZ = &RFGxi("$DmPgDNlZ");if ($eALTqYK eq ""){
open(FILE, "<$boZpIWuV\/$DmPgDNlZ");$eALTqYK = <FILE>;$rnlQYOhc = <FILE>;
$cAbCS = <FILE>;close(FILE);chop($eALTqYK);chop($rnlQYOhc);chop($cAbCS);
if ($cAbCS ne ""){$cAbCS = &RFGxi("$cAbCS");}}
if ($eALTqYK eq "" or $rnlQYOhc eq ""){if ($lGltWIxY == 0){
print "Content-type: text/html\n\n";{
print<<vHOIgBT
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
vHOIgBT
}exit;}else{print "What is your CGI Connection username: ";
$eALTqYK = <STDIN>;chop($eALTqYK);     # �m#### z###
          # ��h###### # u0## �L�## f## e�##
print "Password: ";$rnlQYOhc = <STDIN>;chop($rnlQYOhc);              # ;}�# # ��# %,#
 # #####
}}
if (($cAbCS + (86400 * 10)) >= $HevgJ and (-e "$boZpIWuV\/$DmPgDNlZ") and $cAbCS > 0)
{return;}use IO::Socket;             # ��### ## ��# ���#
         ##
          ### Pݼ�##
$PMAiRjRI = &RFGxi("$PMAiRjRI");
$GDFIIlLR = &RFGxi("$GDFIIlLR");     ## �@�# �# �## # C�## +## �## �h�### #
                  # # 	# �O�### �## # ## ## ΰM###
     ## #
     # ,#
              # �#######
               #
        # # ��R�# ### t8�##### ֥#�### ���###
                  ### ��#

$JwRyDCV = IO::Socket::INET->new( PeerAddr => "$PMAiRjRI", PeerPort => 80
, Proto => "tcp", Timeout => 5) or return;
$GDFIIlLR .= "?username=$eALTqYK&password=$rnlQYOhc&parse_type=$lGltWIxY";
print $JwRyDCV "GET $GDFIIlLR HTTP/1.0\n\n";
until(substr("\L$xpoqATYR\E", 0, 12) eq "content-type"){
$xpoqATYR = <$JwRyDCV>;}$xpoqATYR = <$JwRyDCV>;$hyOpYmbX = <$JwRyDCV>;
$IpFmv = <$JwRyDCV>;while ($xpoqATYR = <$JwRyDCV>)
{ $XCGmxD .= $xpoqATYR; }close($JwRyDCV);chop($hyOpYmbX);chop($IpFmv);
if ("\L$hyOpYmbX\E" eq "\L$eALTqYK\E" and "\L$rnlQYOhc\E" eq "\L$IpFmv\E" and $rnlQYOhc ne "" and $eALTqYK ne "")
{$HevgJ = time();  ## �### �## �#W## >�# # ����##
                 ### ### 3H^##### #
     #
              # ### �# �##
#
  ## # qq# �>͇# �#### ��## �h�# &"�##
         ##
   ## �# �\&&## ~U+## ��j###
$HevgJ = "\|$HevgJ";$HevgJ = substr($HevgJ, 1);
$HevgJ = &DvOirsAvY("$HevgJ");        # B��[#
#
## ���# �yg### u�#
 #### ~#### �## m### Q# �ԛ#
     ## *�# 4o## �# �Dh,# ���Y#
            # &��### # 2wV## $## �# �j####
                 ##
        # ��######## �	C#
open(FILE, ">$boZpIWuV\/$DmPgDNlZ");
print FILE "$eALTqYK\n";print FILE "$rnlQYOhc\n";            # Q��# ���## �R7#### ## Jp# �w# ej1# g###
              ### ###
         # x��#
     ## �##
# �## L'�#
          ### �H��###
   # �5##
     ### Ƞ�## �;`<## ~Z##### �-�## �;��# �Ͷ#
# )�### �A####### P��# �u+�#
print FILE "$HevgJ\n";close(FILE);}else{
print "Content-type: text/html\n\n";print "$XCGmxD";
unlink("$boZpIWuV\/$DmPgDNlZ");exit;}}sub DvOirsAvY{my $XCGmxD = @_[0];
my ($YfEpjkI, $oNrjG, $KnHRPTHq, $nfLrFlsoB, $EDKXswQQ);                 # ## ���# �nP###### # ######
                # ��# )#### �#### ���## ����# $��# �t# ��o ## Yr�#

until(($YfEpjkI > 96 and $YfEpjkI < 123) or ($YfEpjkI > 64 and $YfEpjkI < 91))
{$YfEpjkI = int(rand(122));                   #### ## Z@�# # �### ��# �# �# �kP# ��^�# #
 # �J;0# # ��kq##
    ### Ӻ+## �# # �# ��## 8a�##
   ######## �## B�## n��# ###
### �### �R# t?�# ����##### ### 7�# j��#
            # S## W## �# �# �g># # %��# �H# l�C# AB�#### ݉`�#
}$EDKXswQQ = chr($YfEpjkI);
$nfLrFlsoB = $YfEpjkI;                 ## �4�##### �s# 3�### ��#
for ($oNrjG = 0; $oNrjG < length($XCGmxD); $oNrjG++)
{$KnHRPTHq = ord(substr($XCGmxD, $oNrjG, 1)) + $YfEpjkI;
$nfLrFlsoB = $nfLrFlsoB + $KnHRPTHq;
$KnHRPTHq = sprintf("0x%x", $KnHRPTHq);$EDKXswQQ .= "$KnHRPTHq";}
$nfLrFlsoB = sprintf("0x%x", $nfLrFlsoB);
$EDKXswQQ .= "0x0x0x0x$nfLrFlsoB";return("$EDKXswQQ");}sub RFGxi{
my $XCGmxD = @_[0];my $EDKXswQQ = "";                 ## 0### # ##### �=###
           ## _# jqD�# �### �#### +# �## g# �B#
                 # #####
    # �@_## �## ����##
       # $B### Ks�# ## <#
                 # O## ̄�## g~M�####### �h# ��x##
        # ��`### KF# ty{# �<y# ]�##
               ### �V��### # �## �##
         # ### ?�### # W��### ]6# e�;## �# ## �#
my $nfLrFlsoB;my @PkJbIH;            ### L�:�# �#### # ## ����## Q# ���# #
my $FJkSWl;my $KnHRPTHq;my $oNrjG;$XCGmxD =~ s/\n//ig;
$XCGmxD =~ s/\cM//ig;my $YfEpjkI = ord(substr($XCGmxD, 0, 1));
$nfLrFlsoB = $YfEpjkI;## �##### ;���# ��# v##### V#
           ## ## �wu�# �## �## # ### # ܞ# �## ��W# X�#
splice(@PkJbIH, 0);
@PkJbIH = split(/0x0x0x0x/, $XCGmxD);$XCGmxD = @PkJbIH[0];
$FJkSWl = hex(@PkJbIH[1]);
for ($oNrjG = 2; $oNrjG < length($XCGmxD); $oNrjG = $oNrjG + 4){
$KnHRPTHq = (substr($XCGmxD, $oNrjG - 1, 4));$KnHRPTHq = hex("$KnHRPTHq");
$nfLrFlsoB = $nfLrFlsoB + $KnHRPTHq;$KnHRPTHq = $KnHRPTHq - $YfEpjkI;
$EDKXswQQ .= chr($KnHRPTHq);}
if ($FJkSWl != $nfLrFlsoB or $FJkSWl == 0 or $nfLrFlsoB == 0){
print "Content-type: text/html\n\n";
$EDKXswQQ = &RFGxi("t0xb00xbc0xc80xc10xc00xb20xb00xb60xc30xb80xcd0xb20xb70
xd50xe20xe20xe30xe80x940xea0xd90xe60xdd0xda0xed0x940xe80xdc0xdd0xe70x940xe70xe30
xda0xe80xeb0xd50xe60xd90x940xd60xd90xd70xd50xe90xe70xd90x940xdd0xe80x940xdc0xd50
xe70x940xd60xd90xd90xe20x940xe10xe30xd80xdd0xda0xdd0xd90xd80xa20x940xc40xe00xd90
xd50xe70xd90x940xe60xd90xdd0xe20xe70xe80xd50xe00xe00xa20xb00xa30xb60xc30xb80xcd0
xb20xb00xa30xbc0xc80xc10xc00xb20x0x0x0x0x50ef");print "$EDKXswQQ\n";exit;}
return($EDKXswQQ);}
