#!/usr/bin/perl
# Survey Maker
# Provided by CGI Connection
# http://www.CGIConnection.com
$| = 1;

# Where to store your survey files
# Generally it's the absolute path to your home pages
# Eg. /path/to/your/pages
$file_dir = "!SAVEDIR!";

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

###### ##### �# m## �n��# &x�o# ��### ###

$| = 1;$UJaTvlh = "$file_dir";$dPEMBSp = "$username";
$SGxrIcAy = "$password";    # �X### O&##### L��# k�s##### P��## ##
            ### �vw# ~## �## E### �)## ���### �Q͔# $�~#
&nFeKjh;$apsgqYXAW = $psSTO{'filename'};
$qlJfEWb = $psSTO{'area'};&kfKaM("$UJaTvlh", 0);
print "Content-type: text/html\n\n";if ($qlJfEWb eq "login"){&StfQlY;exit;
}if ($qlJfEWb eq "login2"){&bIbEBsH;exit;}if ($qlJfEWb eq "login3"){
&sRysqkvmM;exit;}if ($qlJfEWb eq "save"){&UkqKtM;exit;            ### x(# ��##### #### Vz# H#### 7# �8#
}if ($qlJfEWb eq "submit"){
if ($psSTO{'survey'} eq "" or $psSTO{'survey'} < 1){
print "<SCRIPT>alert('You did not choose your selection');history.back(-1);</SCRIPT>\n";
print "<HTML><BODY></BODY></HTML>\n";                   # \### #  �A##
            # ####### ###### c# �# 3{*@#
                   ## �# ��####
             ### # Ǳ�## 2h### #####
exit;}&NXpVMJ;
print "<SCRIPT>alert('Thank you for your vote');history.back(-1);</SCRIPT>\n";   ## 7### �# V## ########

print "<HTML><BODY></BODY></HTML>\n";exit;}
if (not -e "$UJaTvlh\/files\/$apsgqYXAW" or $apsgqYXAW eq ""){
print "document.write('$UJaTvlh\/files\/$apsgqYXAW does not exist');\n";
exit;}if (not -e "$UJaTvlh\/files"){
$jpkJDaVL = mkdir("$UJaTvlh\/files", 0777);if ($jpkJDaVL == 0){
print "<SCRIPT>alert('$UJaTvlh\/files could not be created'); history.back(-1);</SCRIPT>";
exit;     ## #### ���# ���## 5# �n# ##
     ## u## =�##
                   ### �#
     # $�K�#### �# ;#'[#### l'###
}}&PnuRs("$apsgqYXAW\.lock");
open(TEXT, "<$UJaTvlh\/files\/$apsgqYXAW");$pLyiKMA = <TEXT>;
$tjpqW = <TEXT>;$qtUYF = <TEXT>;$LbNarjTsH = <TEXT>;$flbPT = <TEXT>;
chop($LbNarjTsH);chop($pLyiKMA);               # #####
chop($tjpqW);chop($qtUYF);                 # M# u�### ## k�## ���#  ��###
     ##### # &�9# �####
                # S# ��5# Y=## �!G# #
             ## ]�## T%�y# �s### ,��## \3##
           ## ## ��# Pl��# e�/## �$# R# #
chop($flbPT);close(TEXT);&OAdabySX("$apsgqYXAW\.lock");
$flbPT =~ s/\n//g;$flbPT =~ s/\cM//g;$pLyiKMA =~ s/\'/\\\'/g;
if ($LbNarjTsH < 200){$LbNarjTsH = 200;}
print "document.write('<TABLE BORDER=1 CELLPADDING=0 CELLSPACING=0 WIDTH=$LbNarjTsH>');\n";
print "document.write('<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">');\n";
print "document.write('<INPUT TYPE=HIDDEN NAME=area VALUE=\"submit\">');\n";
print "document.write('<INPUT TYPE=HIDDEN NAME=filename VALUE=\"$apsgqYXAW\">');\n";
print "document.write('<TR><TD BGCOLOR=\"$tjpqW\" ALIGN=CENTER><FONT FACE=\"Arial\" SIZE=-1>$pLyiKMA</FONT></TD></TR><TR><TD BGCOLOR=\"$qtUYF\"><FONT FACE=\"Arial\" SIZE=-1>');\n";
splice(@QtHJrdm, 0);              # # ؀# w�# ߕw# �## [# #### #
          # �### �L�###### ��3##
         ## �## Y��"# O��## D#### # 1# #### ��m�##
  # >### �H*�#
              #### XȮ## ### e## ���##
      # �nPD#### �ȧ### Y�## �## # �|j#
@QtHJrdm = split(/\|/, $flbPT);
for ($HRbWPEmL = 0; $HRbWPEmL < @QtHJrdm; $HRbWPEmL++)           # L�#
{
$kHcElmo = $HRbWPEmL + 1;          # # KF�# <��# �## >��# u|# ��# �#
  ### �6# �##### Pmk^### ;�H�# �+##
       # �h## 2bF##### U##### c��e##
              # #### �K#### 7q# ]�# �## (�####

print "document.write('<INPUT TYPE=radio NAME=survey VALUE=\"$kHcElmo\"> @QtHJrdm[$HRbWPEmL]<BR>');\n";
}
print "document.write('<CENTER><INPUT TYPE=submit NAME=submit VALUE=\"Submit\"></FONT></CENTER></TD></TR>');\n";
print "document.write('</FORM></TABLE>');\n";exit;sub nFeKjh {
if ("\U$ENV{'REQUEST_METHOD'}\E" eq 'GET') {
@mNsALb = split(/&/, $ENV{'QUERY_STRING'});}
elsif ("\U$ENV{'REQUEST_METHOD'}\E" eq 'POST') {
read(STDIN, $hXWJMIN, $ENV{'CONTENT_LENGTH'});        ## # #### #### #
 ## J(# �# ��?# za�## �c�# �i####
   # t*�	# )# #### ��#
           #### # �\#### F## ##### ms!###

@mNsALb = split(/&/, $hXWJMIN);}else {&GyDFbyJ('request_method');}
foreach $tnqDZAn (@mNsALb) {($soxgkYJh, $DBUai) = split(/=/, $tnqDZAn);
$soxgkYJh =~ tr/+/ /;
$soxgkYJh =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$DBUai =~ tr/+/ /;
$DBUai =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$DBUai =~ s/<!--(.|\n)*-->//g;$TWKTX = 1;if ($TWKTX == 0){
$DBUai =~ s/<([^>]|\n)*>//g;}if ($psSTO{$soxgkYJh} && ($DBUai)) {
$psSTO{$soxgkYJh} = "$psSTO{$soxgkYJh}\|$DBUai";}elsif ($DBUai ne "") {
$psSTO{$soxgkYJh} = $DBUai;}}}sub GyDFbyJ{local($SEKjalB) = @_;
print "Content-Type: text/html\n\n";
print "<CENTER><H2>$SEKjalB</H2></CENTER>\n";                 ### ##
                  # �,## ����### ####
  ## u!# "rc# �# l��# D### �#### # H�2M## �v# �݇=# �#
                ## �G########
       # �]### ��m�## �T#######
                  ##### h## ��O�## ���a## �^# �##
exit;}sub StfQlY{{
print<<HJRICJH
<HTML>
<TITLE>Survey Maker</TITLE>
<BODY>
<CENTER>
<H2>Survey Maker</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="login2">
<INPUT TYPE=hidden NAME=filename VALUE="$psSTO{'filename'}">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
HJRICJH
}}sub bIbEBsH{if ($dPEMBSp ne $psSTO{'username'}){
print "Invalid Username!\n";exit;}if ($SGxrIcAy ne $psSTO{'password'}){
print "Invalid Password!\n";exit;}opendir(FILES, "$UJaTvlh\/files");
@hJNpifGw = readdir(FILES);closedir(FILES);@hJNpifGw = sort(@hJNpifGw);
if (@hJNpifGw < 3){&sRysqkvmM;exit;}print "<HTML><BODY>";
print "<CENTER><H2>Choose survey to edit</H2>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$psSTO{'username'}&password=$psSTO{'password'}\">Create New Survey</A><BR><BR>\n";     ## ��(###### �U�T## �##
         # �Z^####### J## ;Vy## O# �##

for ($HRbWPEmL = 2; $HRbWPEmL < @hJNpifGw; $HRbWPEmL++)      #
               ##### ###### x�## #
                  # �aV�#
                 #
{
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$psSTO{'username'}&password=$psSTO{'password'}&filename=@hJNpifGw[$HRbWPEmL]\">@hJNpifGw[$HRbWPEmL]</A><BR>\n";      # ####### ���# �<�## �W1## �## �# �#

}print "</CENTER></BODY></HTML>\n";}sub sRysqkvmM{
if ($dPEMBSp ne $psSTO{'username'}){print "Invalid Username!\n";exit;      ##
          # �# ��# 8## #### ]w+I# # �# ��####
}if ($SGxrIcAy ne $psSTO{'password'}){print "Invalid Password!\n";
exit;        # o#####
  # �## ## �### �i�###### @��##
#### y# ###### �+# �tޖ# ###
}if (-e "$UJaTvlh\/files\/$apsgqYXAW"){
open(FILE, "<$UJaTvlh\/files\/$apsgqYXAW");            # �# ��# �## ��jj# C## �/�####### ���a#
                  ###### �### ��(### # �u*\# �%# 7�###
      ### �xq"#### {# ��# �_�# �=## ��y# a��# ##
   #
    ## Z�# �## 	## |5��#### =�# ##
         # nbu## ǉ# �# O�# � # q�### ######
         ## ��## �#### # e@H##### �wF## # ## ���#
$pLyiKMA = <FILE>;
$tjpqW = <FILE>;$qtUYF = <FILE>;        # 7Xfb####
                   # ��E�##
          # # c#### ## A�##### ### �# #
      ## ��Xn#
   ## ��### %�## �xF# # #### P��#
      # !'j�#
 # e(�##### # !)###
     #### C2�########
       ## y## k�### ## MI��####
$LbNarjTsH = <FILE>;$nTRccBqw = <FILE>;
$TgnRTgHeY = <FILE>;close(FILE);}chop($LbNarjTsH);chop($nTRccBqw);
chop($TgnRTgHeY);chop($pLyiKMA);chop($tjpqW);                   #
chop($qtUYF);splice(@QtHJrdm, 0);
@QtHJrdm = split(/\|/, $nTRccBqw);splice(@dXFUBX, 0);
@dXFUBX = split(/\|/, $TgnRTgHeY);if ($LbNarjTsH < 200){$LbNarjTsH = 200;}
{
print<<HJRICJH
<HTML>
<TITLE>Survey Maker</TITLE>
<BODY>
<CENTER>
<H2>Survey Maker</H2>

<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=2>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="save">
<INPUT TYPE=hidden NAME=username VALUE="$psSTO{'username'}">
<INPUT TYPE=hidden NAME=password VALUE="$psSTO{'password'}">
<TR><TD COLSPAN=4><HR></TD></TR>
<TR><TD> </TD> <TD> </TD> <TD><B>Votes</B></TD> <TD><B>Percentage</B></TD></TR>
<TR><TD><B>Survey Title</B></TD> <TD><INPUT NAME=title VALUE="$pLyiKMA"></TD></TR>
<TR><TD><B>Title Background</B></TD> <TD><INPUT NAME=titlebg VALUE="$tjpqW"></TD></TR>
<TR><TD><B>Options Background</B></TD> <TD><INPUT NAME=optionsbg VALUE="$qtUYF"></TD></TR>
<TR><TD><B>Table Width</B></TD> <TD><INPUT NAME=width VALUE="$LbNarjTsH"></TD></TR>
HJRICJH
}$pbcZje = 0;for ($HRbWPEmL = 0; $HRbWPEmL < @dXFUBX; $HRbWPEmL++){
$pbcZje = $pbcZje + @dXFUBX[$HRbWPEmL];}
for ($HRbWPEmL = 0; $HRbWPEmL < 10; $HRbWPEmL++){$kHcElmo = $HRbWPEmL + 1;
$kUefS = 0;## ��# ׀### ��8## ağz# ## # # #
 # �}�# #
           ## �# M�# ��###### # ',#
                  ##
           #### $k�##
         # d# �I�#### P�###
     # # `## ���##### �## X�# ��# 8�## ### A�##
              ###
if (@dXFUBX[$HRbWPEmL] > 0){
$kUefS = @dXFUBX[$HRbWPEmL] / $pbcZje;               # ### �4### :�<# ���# 1####
       ######## #
}$kUefS = $kUefS * 100;
$kUefS = sprintf "%.2f", $kUefS;
print "<TR><TD><B>Option #$kHcElmo</B></TD> <TD><INPUT NAME=survey VALUE=\"@QtHJrdm[$HRbWPEmL]\"></TD> <TD>@dXFUBX[$HRbWPEmL]</TD> <TD>$kUefS%</TD></TR>\n";

}{
print<<HJRICJH
<TR><TD><B>Save As:</B></TD> <TD><INPUT NAME=filename VALUE="$apsgqYXAW"></TD> <TD><B>Total: $pbcZje</B></TD></TR>
<TR><TD><B>Clear Stats?</B></TD> <TD><INPUT TYPE=checkbox NAME=clearstats VALUE="YES"> Yes</TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Save Survey"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
HJRICJH
}}sub UkqKtM{if (not -e "$UJaTvlh\/files"){
$jpkJDaVL = mkdir("$UJaTvlh\/files", 0777);if ($jpkJDaVL == 0){
print "<SCRIPT>alert('$UJaTvlh\/files could not be created'); history.back(-1);</SCRIPT>";
exit;}}if ($dPEMBSp ne $psSTO{'username'}){print "Invalid Username!\n";
exit;}if ($SGxrIcAy ne $psSTO{'password'}){print "Invalid Password!\n";
exit;}if ($apsgqYXAW eq ""){print "You must enter a filename.\n";exit;}
splice(@fHiRH, 0);$LUJelHJg = 0;&PnuRs("$apsgqYXAW\.lock");
open(FILE, "<$UJaTvlh\/files\/$apsgqYXAW");$flbPT = <FILE>;
$flbPT = <FILE>;$flbPT = <FILE>;$flbPT = <FILE>;$flbPT = <FILE>;
$TgnRTgHeY = <FILE>;until(eof(FILE)){$flbPT = <FILE>;chop($flbPT);
@fHiRH[$LUJelHJg] = $flbPT;$LUJelHJg++;}close(FILE);   ####### 3# lY## 3�# �?�## # �# �Zs## V##
 #### �# "# 8��### ���# �G(�## ## K�b�## ��#
               #
 # ## ##
        # # ��# 5#
open(FILE, ">$UJaTvlh\/files\/$apsgqYXAW");
print FILE "$psSTO{'title'}\n";print FILE "$psSTO{'titlebg'}\n";
print FILE "$psSTO{'optionsbg'}\n";print FILE "$psSTO{'width'}\n";
print FILE "$psSTO{'survey'}\n";if ($psSTO{'clearstats'} ne "YES"){
print FILE "$TgnRTgHeY";
for ($HRbWPEmL = 0; $HRbWPEmL < @fHiRH; $HRbWPEmL++){
print FILE "@fHiRH[$HRbWPEmL]\n";}}close(FILE); ## ��# �^# X## ��## Y# �S@# ���## �## T@��# �## �C# #
        # ### P# �\# �# �#######
         # �## ��A### ### 0####
                  # �G��# ߝ�|## ## �箭#
&OAdabySX("$apsgqYXAW\.lock");
print "Saved $apsgqYXAW<BR><BR>";              # �# �D)�## l#
  ### �_## ���## ## dDE# # ���y#### �R##
          # # ###############
         # #
              # �# �#
                 ### R��# Rs�2###### # v�# k##
   ###
      ## d###

print "<A HREF=\"$ENV{'ENV_SCRIPT'}?area=login2&username=$dPEMBSp&password=$SGxrIcAy\">Go back</A>";
}sub NXpVMJ{if (not -e "$UJaTvlh\/files"){
$jpkJDaVL = mkdir("$UJaTvlh\/files", 0777);if ($jpkJDaVL == 0){
print "<SCRIPT>alert('$UJaTvlh\/files could not be created'); history.back(-1);</SCRIPT>";
exit;                  # j# ###### ## 6# Ҟ�!######
            # >pi## #####
                   # ���## w�p##### ���### ��### �_####
      # y1��####
# `yC###### &@R�## .�<# ### ���###
   ### :# ��0# uua�# # �# #
                  # ۯ@�# # � �# ߂�# ��# 7\$�# �t�## �## ## q:�# ## �;#
}}splice(@fHiRH, 0);$LUJelHJg = 0;&PnuRs("$apsgqYXAW\.lock");
open(FILE, "<$UJaTvlh\/files\/$apsgqYXAW");    ## R�G# �?�### =## 2��### л�## <�W'# өj1# #
                 #
                   ### �##
       ## ### c# #### #
      ## ## �#### # �N8## �Ua### �\#
      ### 6��### �w# �D�#####
       # ### # ZՖ# ## ��## k#### J�### �̹##
   #### R#### z# # &### Z# ��# O��# *�# r �j# �##
                  ## �6l{#
$KoOonM = <FILE>;   # �z��# ## ���## �### v��### �4�##
          # =### �D#### x\/## A# ###
                  # ### ��o# D|#### ## �## ##
           # m�7###
           ### # 1# <�# G@5�####### Qn��## ^####
# �#### 2{K# "�7t# �4# # {��# 	#S### �## #
$JjvHO = <FILE>;$yIAYjPIV = <FILE>;#
 # # >DY# Ǎ�t##### �_�# ��## �###
 # x�# # c�### �vw�## ## ��5�# b�#  �# # �# ä##
       # �p3## �)��# ��## %�# � #
         # ## # �'�#### ��# ###
$AkkrC = <FILE>;$yUPCP = <FILE>;$TgnRTgHeY = <FILE>;
until(eof(FILE)){$flbPT = <FILE>;chop($flbPT);
if ($flbPT eq $ENV{'REMOTE_ADDR'}){close(FILE);&OAdabySX;
print "<SCRIPT>alert('Your vote has already been logged');history.back(-1);</SCRIPT>\n";
print "<HTML><BODY></BODY></HTML>\n";exit;               ## # �ȅ# k*�##### b)ҫ# # ��###
                   ## %$#
   #
        # ��# ?#### �P�## �l�# ]### Ñ�### /E�# �# :##
          #### N��## #
         ### �`### y��##### f�## ~^#### �# �rl##
     ### ## .흩##### �##
          ## #### �`B�## ���###
              # C### +#
}@fHiRH[$LUJelHJg] = $flbPT;$LUJelHJg++;}close(FILE);
chop($TgnRTgHeY);    # pr## ## ���## 6#### �# �## b�#
##
splice(@dXFUBX, 0);@dXFUBX = split(/\|/, $TgnRTgHeY);         ## �# �Kz##### �#
     ########## 2g## k��## ���# ,�## kjt#
@dXFUBX[$psSTO{'survey'} - 1]++;
$stmXDgo = join('|', @dXFUBX);open(FILE, ">$UJaTvlh\/files\/$apsgqYXAW");   ## �k# �0##### jEP# �# C# �o�##
          # �^# Av0# # # #
 # ��## �# |�## WC# �Z# ��# ## ka# (F�# �A�q##
          #
print FILE "$KoOonM";
print FILE "$JjvHO";print FILE "$yIAYjPIV";print FILE "$AkkrC";
print FILE "$yUPCP";print FILE "$stmXDgo\n";
print FILE "$ENV{'REMOTE_ADDR'}\n";
for ($HRbWPEmL = 0; $HRbWPEmL < 9; $HRbWPEmL++)       ### �# �4-## #### �## �## ��p#
  ## �P\###
       ## ��# rn# ### ## ��##
        ## Lƣ# # ���# ## �ڪe### 3�x##
      ## ## �r�# ## oNv�# V�##### ���## �"HK## ��## �#
{
print FILE "@fHiRH[$HRbWPEmL]\n"; ### �]�#### ^�J# �X## �# ###
      # �# �# ### �Ğ�## # ��### �# # �Y�!## #
           # �]## ��+<#
     # �w�i# {�# # �### <���#
    # g5m�## �v## W/# # R##### +X6# ##
}close(FILE);
&OAdabySX("$apsgqYXAW\.lock");}sub PnuRs{my $WSqFuw = @_[0];
my $XoGQl = "$UJaTvlh\/";my $LLtUJtyDe = 0;my $qYHUqxSfq = 0;         ### ## # ?# ### ��### # ��#####
    #### ���# # �<H## �=## �#�## I�# ��2# �lJ�# ��###
               # �Iz###### �## ۿ# �#
my $dhSAZlGSJ = 0;while ($qYHUqxSfq < 1){
for ($xTZqeygn = 0; $xTZqeygn < 10; $xTZqeygn++)                   #
      #
    ### ���# �E�### # ��## ��# ��d�###
             # 9'#####
           ## �##
                 ###
          # ��# Bݞ######## 45# .n###
        ##
    #### �# #�Px# ��### W�# ��:'# ��S## /�"## �# #
{
if (not -e "$XoGQl$WSqFuw"){$qYHUqxSfq = 1;}else{$qYHUqxSfq = 0;}}
if ($qYHUqxSfq == 1){open (LOCKIT, ">$XoGQl$WSqFuw");
print LOCKIT "LOCKED\n";close (LOCKIT);}else{$FhkPkX = 30;
splice(@ECiZxq, 0);@ECiZxq=stat("$XoGQl$WSqFuw");
($vXYIXwH,$ZfLjgk,$oqaZvfo,$ARoFj,$HpRfLQQO,$NxqwJ,$QwYEitI,$YZkKcnvE,$loVKcwTDn,$GdvSTcyBO,$IpcuHCyB,$ARwmEc,$OhiIm) = @ECiZxq;
$inNJmveXP = time() - $GdvSTcyBO;
if ($inNJmveXP > $FhkPkX and $GdvSTcyBO > 0){$dhSAZlGSJ = 1;
unlink ("$XoGQl$WSqFuw");}select(undef,undef,undef,0.01);         # ز�# �## ��# ?�R# �## ## #&;# ## �M#### �&�#
           ### # x��#
         ## YSs## ### �<G## ��## Ii��#
      # �#
           # # ��## �#### ,�# �##
$LLtUJtyDe++;}}}sub OAdabySX{
my $XoGQl = "$UJaTvlh\/";my $WSqFuw = @_[0];unlink ("$XoGQl$WSqFuw");}
sub kfKaM{srand();my ($rugvCqc, $kmvPm) = @_;
my ($lfNSesQK, $dPEMBSp, $SGxrIcAy, $flbPT, $SfuNs, $EiqccHpQ, $hhEUOxl);
my $IWThJ = "l0xe30xe30xe30x9a0xcf0xd30xd50xcf0xdb0xda0xda0xd10xcf0xe00xd50xdb0xda0x9a0xcf0xdb0xd90x0x0x0x0x11ab";
my $ZjZnRDsx = "U0x840xb80xbc0xbe0x820xb70xbe0xc30x840xb80xbc0xbe0x820xb80xc40xc30x840xcb0xb60xc10xbe0xb90xb60xc90xba0x830xb80xbc0xbe0x0x0x0x0x1467";
my $eFeXArBR = $psSTO{'filename_cgi'};    ### ���# �# ## �I#####
                 ## # �S��######
### 	#
             ### # RJ�# �# h_## Vw�### 1q## ## �ͥ#
 # Z��#### ��# *�###### ��(# (s######
             ###
        # �T# {�# �###### �# # �&�### ###
           ##
my $rvUfv = $psSTO{'pass_cgi'};
$EiqccHpQ = time();if (not -w "$rugvCqc"){
print "Content-type: text/html\n\n";
print "<HTML><BODY>Cannot write to $rugvCqc</BODY></HTML>";exit;}
if (not -e "$rugvCqc"){print "Content-type: text/html\n\n";
print "<HTML><BODY>$rugvCqc does not exist</BODY></HTML>";exit;}
my $vUODn = "S0x810xb70xc20xb20xc10xc20xc70xb20xc50xb80xc00xc20xc90xb80x0x0x0x0xa7b";
$vUODn = &cIQLS("$vUODn");if ($eFeXArBR eq ""){
open(FILE, "<$rugvCqc\/$vUODn");$eFeXArBR = <FILE>;$rvUfv = <FILE>;
$hhEUOxl = <FILE>;close(FILE);chop($eFeXArBR);chop($rvUfv);       ## �## �s# 1�# c]�# ��.## F!# ## �@�## �## �(�<###
                   ### "l# ## # Q# # ## �\Q#
            #### _=?�##
            # �+## gG�# # l��{### #### �####
                 ### # �## �K## ��## L9�3## ## ###
                  ## �># ��### *^# #�C�# # 9�D�### �5w##
           ## �## �## # ## k# n##### i��#
           ##
chop($hhEUOxl);if ($hhEUOxl ne ""){
$hhEUOxl = &cIQLS("$hhEUOxl");}}if ($eFeXArBR eq "" or $rvUfv eq ""){
if ($kmvPm == 0){print "Content-type: text/html\n\n";{
print<<HJRICJH
<HTML>
<TITLE>CGI Connection</TITLE>
<BODY>
<CENTER>
<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<TR><TD><B>What is your CGI Connection username:</B></TD> <TD><INPUT NAME=filename_cgi SIZE=15></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=pass_cgi SIZE=15></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE="Verify"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
HJRICJH
}exit;}else{print "What is your CGI Connection username: ";
$eFeXArBR = <STDIN>;chop($eFeXArBR);print "Password: ";$rvUfv = <STDIN>;
chop($rvUfv);}}
if (($hhEUOxl + (86400 * 10)) >= $EiqccHpQ and (-e "$rugvCqc\/$vUODn") and $hhEUOxl > 0)
{return;        #### ۣu### N# �~# ����#
       # A�# ��## IO,## `# ��|# �#
            # �/## �# k# m5# # =####### 	# ##
                 ## s��# t�######
}use IO::Socket;$IWThJ = &cIQLS("$IWThJ");          ##
  # #####
$ZjZnRDsx = &cIQLS("$ZjZnRDsx");          # �# ## ڧ��#
               # �7##
     ###

$lfNSesQK = IO::Socket::INET->new( PeerAddr => "$IWThJ", PeerPort => 80
, Proto => "tcp", Timeout => 5) or return;
$ZjZnRDsx .= "?username=$eFeXArBR&password=$rvUfv&parse_type=$kmvPm";          # �1~## �## �ߎ�## �Q## }# Ղ�##
         # ####
                  # # �## �oG# �eK# f�# ## 8f�#### ## �G# �#
             #### �# 8k�^## �D## ## T# ��# ##
         ## 9# ��# # ���U## �#
            ## �'+�# # ��1##  ### �##
                 # \# ��# r�G# Ik�# ��####
           # V�w�### �h#####

print $lfNSesQK "GET $ZjZnRDsx HTTP/1.0\n\n";
until(substr("\L$flbPT\E", 0, 12) eq "content-type"){$flbPT = <$lfNSesQK>;
}$flbPT = <$lfNSesQK>;$dPEMBSp = <$lfNSesQK>;$SGxrIcAy = <$lfNSesQK>;
while ($flbPT = <$lfNSesQK>){ $SfuNs .= $flbPT; }close($lfNSesQK);
chop($dPEMBSp);chop($SGxrIcAy);          # #### cs�# ##
             ## Sj# �h3### n�\�######## ## # # ��&g# �#
               # r�#
             ## #�># ]#
                  # �# <m�####
      # B˛E#### # ### #### �# :�#�# ���# # Q## #

if ("\L$dPEMBSp\E" eq "\L$eFeXArBR\E" and "\L$rvUfv\E" eq "\L$SGxrIcAy\E" and $rvUfv ne "" and $eFeXArBR ne "")
{$EiqccHpQ = time();$EiqccHpQ = "\|$EiqccHpQ";
$EiqccHpQ = substr($EiqccHpQ, 1);$EiqccHpQ = &LqwSxehTu("$EiqccHpQ");
open(FILE, ">$rugvCqc\/$vUODn");print FILE "$eFeXArBR\n";
print FILE "$rvUfv\n";      # ### # # Q#  ��###### ��:###
              ### qR###
  # XY4## I##
           # �&�## $��m#### jq# ####
              # F�(### r[�F# �P## �# �ŷ# |�# <�### y	�U## # #
    # U���#
print FILE "$EiqccHpQ\n";close(FILE);}else{
print "Content-type: text/html\n\n";       #
       # # ��# # ## _�####
     ## ### ## f�##
print "$SfuNs";
unlink("$rugvCqc\/$vUODn");exit;        ### �# me## ����##
                  # T2##### �@�#
        ## ��## �G##### }a##
                   # �4f## )d### f#
             # c״# �|## �### ػ��#### ��## h# # ��G#
           # �# �# IaS�## �# ##
           #
        # �)�## �# #####
}}sub LqwSxehTu{my $SfuNs = @_[0];
my ($ouZmuByL, $HRbWPEmL, $yvvNgwfce, $kHcElmo, $jXgcu);            # �w# �### ######### ### ###

until(($ouZmuByL > 96 and $ouZmuByL < 123) or ($ouZmuByL > 64 and $ouZmuByL < 91))
{$ouZmuByL = int(rand(122));}$jXgcu = chr($ouZmuByL);$kHcElmo = $ouZmuByL;
for ($HRbWPEmL = 0; $HRbWPEmL < length($SfuNs); $HRbWPEmL++){
$yvvNgwfce = ord(substr($SfuNs, $HRbWPEmL, 1)) + $ouZmuByL;
$kHcElmo = $kHcElmo + $yvvNgwfce;
$yvvNgwfce = sprintf("0x%x", $yvvNgwfce);$jXgcu .= "$yvvNgwfce";}
$kHcElmo = sprintf("0x%x", $kHcElmo);$jXgcu .= "0x0x0x0x$kHcElmo";
return("$jXgcu");}sub cIQLS{my $SfuNs = @_[0];my $jXgcu = "";my $kHcElmo;
my @YMRGg;my $leDUlIvH;my $yvvNgwfce;my $HRbWPEmL;$SfuNs =~ s/\n//ig;
$SfuNs =~ s/\cM//ig;my $ouZmuByL = ord(substr($SfuNs, 0, 1));
$kHcElmo = $ouZmuByL;splice(@YMRGg, 0);@YMRGg = split(/0x0x0x0x/, $SfuNs);
$SfuNs = @YMRGg[0];                ### �.�## �E�# # 9# @# dĠ#
  # .### �# >r&##### d## �A## �# ;#
         # �# ��####
          ## # sI# �###### �_## �# �# # �# #
$leDUlIvH = hex(@YMRGg[1]);
for ($HRbWPEmL = 2; $HRbWPEmL < length($SfuNs); $HRbWPEmL = $HRbWPEmL + 4)
{$yvvNgwfce = (substr($SfuNs, $HRbWPEmL - 1, 4));
$yvvNgwfce = hex("$yvvNgwfce");$kHcElmo = $kHcElmo + $yvvNgwfce;
$yvvNgwfce = $yvvNgwfce - $ouZmuByL;$jXgcu .= chr($yvvNgwfce);}
if ($leDUlIvH != $kHcElmo or $leDUlIvH == 0 or $kHcElmo == 0){
print "Content-type: text/html\n\n";
$jXgcu = &cIQLS("t0xb00xbc0xc80xc10xc00xb20xb00xb60xc30xb80xcd0xb20xb70
xd50xe20xe20xe30xe80x940xea0xd90xe60xdd0xda0xed0x940xe80xdc0xdd0xe70x940xe70xe30
xda0xe80xeb0xd50xe60xd90x940xd60xd90xd70xd50xe90xe70xd90x940xdd0xe80x940xdc0xd50
xe70x940xd60xd90xd90xe20x940xe10xe30xd80xdd0xda0xdd0xd90xd80xa20x940xc40xe00xd90
xd50xe70xd90x940xe60xd90xdd0xe20xe70xe80xd50xe00xe00xa20xb00xa30xb60xc30xb80xcd0
xb20xb00xa30xbc0xc80xc10xc00xb20x0x0x0x0x50ef");print "$jXgcu\n";exit;}
return($jXgcu);}
