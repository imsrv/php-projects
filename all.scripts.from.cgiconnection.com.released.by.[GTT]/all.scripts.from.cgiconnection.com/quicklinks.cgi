#!/usr/bin/perl
# Quick Links
# Provided By CGI Connection
# http://www.CGIConnection.com
$| = 1;

# Location to save your news file
$save_dir = "!SAVEDIR!";

# Username to login to the administration section
$username = "!USERNAME!";

# Password to login to the administration section
$password = "!PASSWORD!";

# Default font to use
$font = "Arial";

#############################################
# DO NOT EDIT BELOW THIS LINE
# THIS SCRIPT HAS BEEN SCRAMBLED
# MODIFYING ANYTHING BELOW MAY DISABLE IT
# PROVIDED BY CGICONNECTION.COM
#############################################


           # �#
    #### b# ��#### 0���# ;## ��### ##
            #### K#
  # ###### �# ��n### ��### ### &# �2��##
            ## # [# ��##### #### M# �9# z(q##

$HBeBecSWN = "$save_dir";$KyWAGV = "$username";
$JCJtTcwV = "$password";$dPoyhWPCq = "$font";&stxgkGM;
$gqIgO = $PRNOYtoUf{'area'};$ilfFl = $PRNOYtoUf{'filename'};
$QmaUxXNta = $PRNOYtoUf{'width'};$hhdVK = $PRNOYtoUf{'height'};      ### ######## c#
     #### m## # �# ��|#### #
  ## .9�t###### �## #
                 ### ��## #
     ###### ## ## �### #
$UWQMeo = $PRNOYtoUf{'title'};
$fStMqA = $PRNOYtoUf{'bordercolor'};
$HUZpZ = $PRNOYtoUf{'backgroundcolor'};$DfxtnE = $PRNOYtoUf{'max'};
$QmaUxXNta = 175 if $QmaUxXNta eq "";$hhdVK = 200 if $hhdVK eq "";                   ### `�### ## �## ���#### ##
                #
         ##
                # ## ##
         # ��### # �rb# ����##
# ## %## 3�+### ߦ$# �# # ~I###### @�3##
                 # �# .9### �\## u���# �#
             ## @##### ~## `��#### ��## d���#
$fStMqA = "#CC9900" if $fStMqA eq "";
$HUZpZ = "#FFFF99" if $HUZpZ eq "";
splice(@jFiWQ, 0);splice(@ktKcJBBi, 0);
&CJvXilo("$HBeBecSWN", 0);print "Content-type: text/html\n\n";
if ($gqIgO eq "login"){&CXwUWJ;exit;}if ($gqIgO eq "login2"){&RPAxQqJR;
&KdlNxf;exit;}if ($gqIgO eq "login3"){&RPAxQqJR;&FTmbNP;exit;}
if ($gqIgO eq "save"){&RPAxQqJR;if ($PRNOYtoUf{'delfile'} ne ""){
unlink("$HBeBecSWN\/files\/$ilfFl");
print "$ilfFl has been deleted.<BR><BR>\n";
print "<HTML><BODY><A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$PRNOYtoUf{'username'}&password=$PRNOYtoUf{'password'}\">Show all files</A></BODY></HTML>\n";
exit;     # �a# *## �# �0�# i*��# 6�# ��### >�m##
           # ��##### "�# [�# �0F#
            ## �=# �W��### ��# �;��# �+�#
               ### e�### ##### G# �# ]_# m# %g�##
 #### .# ���t##### �## w�## ���### # #
           ## C�# n{,l# �# ��	# ¤# #####
             # b�?�# �q'�# ��#### m#### ## ]�-# �h# ��# �.##
### # :!#### ## # E�###
           # �|�}### ��n##
}&ulNtMXB;exit;      # |R.# # 巿# ��# # c��# ##
                 #### ��### �0#### AM�2##
                #
                  ### �O8�#### �q# ## ��HV# ���## `c1�# +��# g# ##
}&nAoqonmZF;exit;sub stxgkGM {
if ("\U$ENV{'REQUEST_METHOD'}\E" eq 'GET') {
@nsAIbJybn = split(/&/, $ENV{'QUERY_STRING'});         # �# ��# �### �#### # ��######
}
elsif ("\U$ENV{'REQUEST_METHOD'}\E" eq 'POST') {
read(STDIN, $pEIiHTfh, $ENV{'CONTENT_LENGTH'});
@nsAIbJybn = split(/&/, $pEIiHTfh);}else {&thUEL('request_method');}
foreach $qpSNqH (@nsAIbJybn) {($AqSgJ, $yhsuCn) = split(/=/, $qpSNqH);
$AqSgJ =~ tr/+/ /;    #
                 # # ��# �## -�l## �###
    # # �# ### �## �### ��;## �## ^#
 ##### # �# D��V# s���## ��# �# �### #
     ### �# &�# ###### ��## ��##
### ��## q�a### u���# h}## _### }�##
   # ���### �### Vd�##
       # M�## �# ## ��#######
          ## ��# �##

$AqSgJ =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$yhsuCn =~ tr/+/ /;
$yhsuCn =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;           # ��#### �8# ## ���#### # ## li�###
              #### ### �P&#
    # GW## E### ['####
# 4,��## ####### �## V�m# m�b## +��##
      ## =�## �)## s��# �# # )#
                 ### #### &Mb### �[4�####
                   #

$yhsuCn =~ s/<!--(.|\n)*-->//g;$tHAoXu = 1;if ($tHAoXu == 0){
$yhsuCn =~ s/<([^>]|\n)*>//g;}if ($PRNOYtoUf{$AqSgJ} && ($yhsuCn)) {
$PRNOYtoUf{$AqSgJ} = "$PRNOYtoUf{$AqSgJ}, $yhsuCn";}
elsif ($yhsuCn ne "") {$PRNOYtoUf{$AqSgJ} = $yhsuCn;   # aKn## γ�# 6,#
      # Л# #### ## ��# �# # ## ��I### ��}# !###
                   # ̀�### �# ��# �E#### g�# �Y#
              #####
}}}sub thUEL{local($CuTJu) = @_;
print "Content-Type: text/html\n\n";
print "<CENTER><H2>$CuTJu</H2></CENTER>\n";exit;}sub RPAxQqJR{
if ($KyWAGV ne $PRNOYtoUf{'username'}){
print "<HTML><BODY>Invalid Username.</BODY></HTML>\n";exit;              ## ��# ,�# �## ��####
                  ##### ####### �=E�##
               ## r�# # # # ### ��# q�o###
                ## ��d## ###
             # 9�# ��#### # �%### 'B�`### ## #
  ### ��#### �# �b#### 5## @# ## �j&e##
}if ($JCJtTcwV ne $PRNOYtoUf{'password'}){
print "<HTML><BODY>Invalid Password.</BODY></HTML>\n";exit;}}sub CXwUWJ{{
print<<odYbWW
<HTML>
<TITLE>Quick Links</TITLE>
<BODY>
<CENTER>
<H2>Quick Links</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="login2">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
odYbWW
}}sub KdlNxf{opendir(FILES, "$HBeBecSWN\/files");
@HXGvpWFG = readdir(FILES);closedir(FILES);@HXGvpWFG = sort(@HXGvpWFG);
if (@HXGvpWFG < 3){&FTmbNP;exit;           ## �e�## �q�### r�f# [�Y### �# �>�## #### #
}print "<HTML><TITLE>Quick Links</TITLE><BODY>";
print "<CENTER><H2>Choose file to edit</H2>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$PRNOYtoUf{'username'}&password=$PRNOYtoUf{'password'}\">Create new Quick Links file</A><BR><BR>\n";
for ($AsgaW = 2; $AsgaW < @HXGvpWFG; $AsgaW++)              ######## �##
          # #### # �?�######### �##
{
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$PRNOYtoUf{'username'}&password=$PRNOYtoUf{'password'}&filename=@HXGvpWFG[$AsgaW]\">@HXGvpWFG[$AsgaW]</A><BR>\n";
}print "</CENTER></BODY></HTML>\n";            #### ~###### ### kc#
                   ######## q# 淟�# 4�o�# \##
                  ##
}sub xVVrgHl{my $snaRyHbv = 0;
open(FILES, "<$HBeBecSWN\/files\/$ilfFl");$UWQMeo = <FILES>;chop($UWQMeo);           # # ���# Ϟ# ## �# �# �~# �c# #
                  ######## ###
 #### /##
              #
     # ��# �# �# �X�### u�##
  ## M��# A#### T�### �### �## i�### }#
until(eof(FILES)){$ObZWJZ = <FILES>;                  ## �# # # 2�# 7### #
                ## tEB�# ��### �##### i## �# B�#
              # # -## �# �## ###### ### ��# n�##
chop($ObZWJZ);splice(@ZujmOkFQY, 0);
@ZujmOkFQY = split(/\|/, $ObZWJZ);if ($ObZWJZ ne ""){
@ktKcJBBi[$snaRyHbv] = @ZujmOkFQY[0];@jFiWQ[$snaRyHbv] = @ZujmOkFQY[1];
$snaRyHbv++;}}close(FILES);}sub FTmbNP{&xVVrgHl;$ddJBIAY = @jFiWQ + 5;        #  ### # ��Q�#### I�y~# ��## %#### �##
 ## ���M# ��#
              # <###### �q######
               # �I# �9Z#
## 5# �## �## �# =�2�# ##
                  # @�V### Gf##### ######## ]�#
                 ###
print "<HTML><TITLE>Quick Links</TITLE><BODY>\n";
print "<CENTER><H2>Quick Links</H2>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$PRNOYtoUf{'username'}&password=$PRNOYtoUf{'password'}\">Show all files</A><BR><BR>\n";            ## ��#
   # �# ]## K## �V## ###
                  #### �## `### #
                 # ##### �ɳ## �K# [�G�# ���# �# N## �##
                 #### # #Q# �###### �C##
                ###### lߡo### �?�#
#
                   # >B�# J## d[###
                 # �#

print "<TABLE BORDER=0>\n";
print "<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">\n";        ######## ## ~�## K��##
# D###
  #### #

print "<INPUT TYPE=HIDDEN NAME=area VALUE=\"save\">\n";
print "<INPUT TYPE=HIDDEN NAME=username VALUE=\"$PRNOYtoUf{'username'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=password VALUE=\"$PRNOYtoUf{'password'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=max VALUE=\"$ddJBIAY\">\n";
print "<TR><TD VALIGN=TOP><B>Title</B></TD> <TD VALIGN=TOP><INPUT NAME=title VALUE=\"$UWQMeo\"></TD></TR>\n";
for ($AsgaW = 0; $AsgaW < $ddJBIAY; $AsgaW++)   ## # ## k��## �### D# �###
                 ##### �# =tѧ# /# f�# �w��## 8�# o# �O##
 # �D�## �d###
                  ##### �2#
                  ## q��G## ��# c�# ## $`# ���#
# ��### # ���# #### �##
    #### ##### ##
{$TgSNrRe = $AsgaW + 1;
$YqrOq = @jFiWQ[$AsgaW];$mQZKIxIHV = @ktKcJBBi[$AsgaW];#### ���-## #
      ## M# H�I# �## x# l+## �##### $pu# ]F# �###
if ($mQZKIxIHV eq ""){
$mQZKIxIHV = "http://";}
print "<TR><TD VALIGN=TOP><B>[ $TgSNrRe ] Delete?</B></TD> <TD VALIGN=TOP><INPUT TYPE=CHECKBOX NAME=del$AsgaW VALUE=\"Y\"></TD></TR>";
print "<TR><TD VALIGN=TOP><B>URL:</B></TD> <TD VALIGN=TOP><INPUT NAME=url$AsgaW VALUE=\"$mQZKIxIHV\" SIZE=30></TD></TR>\n";
print "<TR><TD VALIGN=TOP><B>Description:</B></TD> <TD VALIGN=TOP><INPUT NAME=desc$AsgaW VALUE=\"$YqrOq\" SIZE=30></TD></TR>\n";               # -\\^# �#### �If## R# ##### u;# # �5# #���# h##

print "<TR><TD VALIGN=TOP COLSPAN=2><BR><HR><BR></TD></TR>\n";}
print "<TR><TD COLSPAN=2><B>Filename:</B> <INPUT NAME=filename VALUE=\"$ilfFl\"></TD></TR>\n";     ### �### #### ֖�## ## # �#

print "<TR><TD COLSPAN=2><B>Delete $ilfFl?</B> <INPUT TYPE=CHECKBOX NAME=delfile VALUE=\"Y\"></TD></TR>\n";
print "<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE=\"Update\"></TD></TR>\n";
print "</FORM></TABLE></CENTER></BODY></HTML>\n";}sub ulNtMXB{
if (not -e "$HBeBecSWN\/files"){
$ptdordrY = mkdir("$HBeBecSWN\/files", 0777);if ($ptdordrY == 0){
print "<SCRIPT>alert('$HBeBecSWN\/files could not be created'); history.back(-1);</SCRIPT>";
exit;}}if ($ilfFl eq ""){
print "<HTML><BODY>You must specify a filename.</BODY></HTML>\n";                 ######## i�# D### �N#
                   ## &�c# J��### ��lw### # �# _## # le# �# #
               ##
        ## �$# wU#
exit;}
if (not -w "$HBeBecSWN\/files"){
print "<HTML><BODY>Cannot write to $HBeBecSWN\/files\/$ilfFl</BODY></HTML>\n";
exit;}open(FILE, ">$HBeBecSWN\/files\/$ilfFl");              ### �M# l# �## �z# @W�G######
          # �######## ��# �## # �u### �## #
  # X# ��O#
                ## ####### |P��# ## �]#### #
    ### #### �# ��|# 	 �###
 ####
      # # ��?# �## # L##
           ##
print FILE "$UWQMeo\n";
for ($AsgaW = 0; $AsgaW < $DfxtnE; $AsgaW++){$SEgdVyZI = "desc$AsgaW";
$YqrOq = $PRNOYtoUf{$SEgdVyZI};$mEdYY = "url$AsgaW";
$mQZKIxIHV = $PRNOYtoUf{$mEdYY};$oNYkjZIjx = "del$AsgaW";
$ZDygmgoc = $PRNOYtoUf{$oNYkjZIjx};$YqrOq =~ s/\n//gi;$YqrOq =~ s/\cM//gi;
if ($YqrOq ne "" and $ZDygmgoc eq ""){print FILE "$mQZKIxIHV\|$YqrOq\n";}}
close(FILE);
print "Saved <A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$PRNOYtoUf{'username'}&password=$PRNOYtoUf{'password'}&filename=$ilfFl\">$ilfFl</A><BR><BR>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&username=$PRNOYtoUf{'username'}&password=$PRNOYtoUf{'password'}\">Show all files</A><BR>\n";
}sub nAoqonmZF{$XVNaKFlC = "";open(FILE, "<$HBeBecSWN\/files\/$ilfFl");
$UWQMeo = <FILE>;chop($UWQMeo);until(eof(FILE)){$ObZWJZ = <FILE>;
chop($ObZWJZ);if ($ObZWJZ ne ""){splice(@OrFMPsuhC, 0);
@OrFMPsuhC = split(/\|/, $ObZWJZ);
$XVNaKFlC .= "<BR><BR><A HREF=\"@OrFMPsuhC[0]\">@OrFMPsuhC[1]</A>";}}
close(FILE);{
print<<odYbWW
var htmlcode = '<TABLE BORDER=2 WIDTH=$QmaUxXNta HEIGHT=$hhdVK BORDERCOLOR=$fStMqA CELLSPACING=0 CELLPADDING=0><TR><TD VALIGN=TOP BGCOLOR=$HUZpZ><CENTER><FONT FACE=\"$dPoyhWPCq\"><B>$UWQMeo</B></FONT><FONT FACE=\"$dPoyhWPCq\" SIZE=-1>$XVNaKFlC<BR><BR>[ <a href=javascript:closeWindow();>Close</a> ]</FONT></CENTER></TD></TR></TABLE>';

if (document.layers)
{
document.write('<layer name="allheadings" z-index="90" left="0" top="0" visibility="visible"></layer>');
}
else if (document.all)
{
document.write('<div id="allheadings" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;"></div>');
}
else if (document.getElementById)
{
document.write('<div id="allheadings" style="z-index:90;position:absolute;top:0;left:0;visibility:visible;"></div>');
}

function moveit() {

if (document.layers)
{
document.layers.allheadings.top = pageYOffset;
document.allheadings.left = window.innerWidth - $QmaUxXNta - 20;
}
else if (document.all)
{
document.all.allheadings.style.posLeft = document.body.clientWidth - $QmaUxXNta - 20;
document.all.allheadings.style.top = document.body.scrollTop;
}
else if (document.getElementById)
{
document.getElementById("allheadings").style.left = window.innerWidth - $QmaUxXNta - 20;
document.getElementById("allheadings").style.top = document.body.scrollTop;
}

setTimeout("moveit()",100);
}

function closeWindow() {

if (document.layers)
{
document.layers.allheadings.visibility = "hidden";
}
else if (document.all)
{
document.all.allheadings.style.visibility = "hidden";
}
else if (document.getElementById)
{
document.getElementById("allheadings").style.visibility = "hidden";
}
}

function oneTime() {

if (document.layers)
{
document.allheadings.document.write(htmlcode);
document.allheadings.document.close();
}
else if (document.all)
{
allheadings.innerHTML = htmlcode;
}
else if (document.getElementById)
{
newlayer = document.getElementById("allheadings");
newlayer.innerHTML = htmlcode;
}

setTimeout("moveit()",100);
}

setTimeout("oneTime()",100);
odYbWW
}}sub CJvXilo{srand();my ($oPGSscbtO, $FVHMPTL) = @_;             # # ��## # �Z#### ##
               # ��,### �# �# # ����# ## #
                 ###
    # y�ɍ# # l�#### ���#

my ($utgSJI, $KyWAGV, $JCJtTcwV, $ObZWJZ, $jlwOMuB, $ENhHo, $jeTQpf);
my $WINOx = "l0xe30xe30xe30x9a0xcf0xd30xd50xcf0xdb0xda0xda0xd10xcf0xe00xd50xdb0xda0x9a0xcf0xdb0xd90x0x0x0x0x11ab";## p### ## v4��## C)# �Ŷ### # :J##
               #
   ## ###### ��# y0## ### �U��###
         #### $�# �gX##
          ## �,|�##### # �## ��# 	x/V##### o# �#
#### _�# #��*### h�##### ?*######
  # "# �{# Cc#### ##
                  # # *pc##

my $pMuQpdWH = "U0x840xb80xbc0xbe0x820xb70xbe0xc30x840xb80xbc0xbe0x820xb80xc40xc30x840xcb0xb60xc10xbe0xb90xb60xc90xba0x830xb80xbc0xbe0x0x0x0x0x1467";
my $AYkZpHxAf = $PRNOYtoUf{'filename_cgi'};
my $QKbjlYu = $PRNOYtoUf{'pass_cgi'};$ENhHo = time();
if (not -w "$oPGSscbtO"){print "Content-type: text/html\n\n";
print "<HTML><BODY>Cannot write to $oPGSscbtO</BODY></HTML>";exit;}
if (not -e "$oPGSscbtO"){print "Content-type: text/html\n\n";
print "<HTML><BODY>$oPGSscbtO does not exist</BODY></HTML>";exit;}
my $lnGIhH = "S0x810xb70xc20xb20xc10xc20xc70xb20xc50xb80xc00xc20xc90xb80x0x0x0x0xa7b";
$lnGIhH = &mqYgAsWv("$lnGIhH");if ($AYkZpHxAf eq ""){
open(FILE, "<$oPGSscbtO\/$lnGIhH");$AYkZpHxAf = <FILE>;$QKbjlYu = <FILE>;
$jeTQpf = <FILE>;                 ##### �d# .Z�#### ###
 # ## �C�## ��# #### ���# ##
               # 0�# �## ### =|# U# �P9�####### ���# �p[�#
            ##
                # # �### �.�# ### �# o��u# 2��### ��##### #
         # ��# ### ��# # ��:H# # fI�\# �##
     ###
      ## iF�# �### �# # �q0##
        ## =k�W### �#### # ��##
close(FILE);chop($AYkZpHxAf);chop($QKbjlYu);
chop($jeTQpf);if ($jeTQpf ne ""){$jeTQpf = &mqYgAsWv("$jeTQpf");}}
if ($AYkZpHxAf eq "" or $QKbjlYu eq ""){if ($FVHMPTL == 0){
print "Content-type: text/html\n\n";        ##
      # # Ӛ# �#### �[�# #### �##
       ## �W��##### �# [(�## �;## �4�# ��;# # # w�fE# d�u##
                  ## �f#### �## �R### S0o# �## �9W#
  # ### ��# ##### �*��#
           ### p�# ######## \��###
{
print<<odYbWW
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
odYbWW
}exit;}else{print "What is your CGI Connection username: ";
$AYkZpHxAf = <STDIN>;               # ��E# ��# ���# �### ��Θ#### w#### ## j��# �|#
          # �### ��# �###### }�# `�C## ## ��P�# �θ�#
              ## ��v# d#
# ## �####
              # ��### ��# ###
                   ## # ���E####
               ## # �# RA�6# �+####  ��# �XN##### ��# ���##
                  ###
      ### n��#
chop($AYkZpHxAf);print "Password: ";
$QKbjlYu = <STDIN>;          ######## ��?�### �### ##
       # 	L### #####
            # # 2### :0# 2## P��# # S##  # z�7#
                  #### #
  #
# �/��# ��K# ���1## # #### # �12### /c�## #
chop($QKbjlYu);}}
if (($jeTQpf + (86400 * 10)) >= $ENhHo and (-e "$oPGSscbtO\/$lnGIhH") and $jeTQpf > 0)
{return;             # K##
                  #
  ### _�# �# ��%S# ### ��#### ܢ�##### #
                   # �##
}use IO::Socket;$WINOx = &mqYgAsWv("$WINOx");
$pMuQpdWH = &mqYgAsWv("$pMuQpdWH");   ## �## �#
                   # 5###
                # �?## ��## w# w�#
  ##
          # �# ��%3### �###
      ## # &`�### �## =e#
           ## W# �## ��e�# �+V#### ��R�### 53# # �####

$utgSJI = IO::Socket::INET->new( PeerAddr => "$WINOx", PeerPort => 80
, Proto => "tcp", Timeout => 5) or return;   ####
                ## �### �# ### # Nr{# ## ## 0��#

$pMuQpdWH .= "?username=$AYkZpHxAf&password=$QKbjlYu&parse_type=$FVHMPTL";
print $utgSJI "GET $pMuQpdWH HTTP/1.0\n\n";
until(substr("\L$ObZWJZ\E", 0, 12) eq "content-type"){$ObZWJZ = <$utgSJI>;
}$ObZWJZ = <$utgSJI>;   ## �/�# ��O### �i�## xr# ��N### *P�D# ��x#
       ### x��#
  # ��r### ��B�### [8+####
      ###
     ### �i# � # �## ��# �## # ��# # I1s### a# {# B#
$KyWAGV = <$utgSJI>;$JCJtTcwV = <$utgSJI>;
while ($ObZWJZ = <$utgSJI>){ $jlwOMuB .= $ObZWJZ; }close($utgSJI);
chop($KyWAGV);chop($JCJtTcwV);
if ("\L$KyWAGV\E" eq "\L$AYkZpHxAf\E" and "\L$QKbjlYu\E" eq "\L$JCJtTcwV\E" and $QKbjlYu ne "" and $AYkZpHxAf ne "")
{$ENhHo = time();$ENhHo = "\|$ENhHo";$ENhHo = substr($ENhHo, 1);
$ENhHo = &nCIeLTbVX("$ENhHo");open(FILE, ">$oPGSscbtO\/$lnGIhH");
print FILE "$AYkZpHxAf\n";print FILE "$QKbjlYu\n";print FILE "$ENhHo\n";
close(FILE);}else{print "Content-type: text/html\n\n";print "$jlwOMuB";
unlink("$oPGSscbtO\/$lnGIhH");          # 6a## ;####### ## �H# �Z��### #
  # �# C�E##### �7�# ## n# zg7## �o## �# # ��##
           # ?## �X�B##
     # �# �# # d##
      # �?�## # di��# ���# h# # �:�6### ��####
exit;}}sub nCIeLTbVX{my $jlwOMuB = @_[0];
my ($MEDDwVos, $AsgaW, $rPrZJvPSx, $NwRDcWy, $DxiTdr);
until(($MEDDwVos > 96 and $MEDDwVos < 123) or ($MEDDwVos > 64 and $MEDDwVos < 91))
{$MEDDwVos = int(rand(122));}$DxiTdr = chr($MEDDwVos);
$NwRDcWy = $MEDDwVos;for ($AsgaW = 0; $AsgaW < length($jlwOMuB); $AsgaW++)               ### �P########## �1�N# �#
             # #### # ��# x�Z# |f�##
 # �cH# �b## ## �7## # _# �T# ;�#
                # ��'m### �# �(# �#### H�1�## K# $y�=# #
{
$rPrZJvPSx = ord(substr($jlwOMuB, $AsgaW, 1)) + $MEDDwVos;
$NwRDcWy = $NwRDcWy + $rPrZJvPSx;
$rPrZJvPSx = sprintf("0x%x", $rPrZJvPSx);$DxiTdr .= "$rPrZJvPSx";}
$NwRDcWy = sprintf("0x%x", $NwRDcWy);$DxiTdr .= "0x0x0x0x$NwRDcWy";
return("$DxiTdr");}sub mqYgAsWv{my $jlwOMuB = @_[0];my $DxiTdr = "";                 # G# =�e# bk### �G# C�#
    # e###
                  ### �n# O# �S��##### z# N5### �# ;S5<## @c�#
           # �+# ��# ##
                ## # # # y# # .#### �:### ## \#
              ## �L�Z# ��D�# �# �###### ######
   # �R�##### �### �A##
                ## ## ### �5###
        # (#
my $NwRDcWy;my @jlMmoLp;my $rqIGvNqA;my $rPrZJvPSx;
my $AsgaW;$jlwOMuB =~ s/\n//ig;             # W�# # T�# �## �h�|##### ��S�## ���# ��## �##
  # ��## �}�### ��N## ## ##
           ######## w2�# �####
       ### ����#
    # ��##
$jlwOMuB =~ s/\cM//ig;
my $MEDDwVos = ord(substr($jlwOMuB, 0, 1));$NwRDcWy = $MEDDwVos;   ### fk�# �o+�## �##
# $w# 7### ���# ؓ�## �Y#### �##
                 # _### O�r# �U###### /�HZ#
           ###### ���#
 ## '# #
                 ### ###
             ### �7	## �## # �#### ���## >�t�# {>�##
           ## �###
splice(@jlMmoLp, 0);
@jlMmoLp = split(/0x0x0x0x/, $jlwOMuB);       ##### ��# A�#
              #### �_### �R�## �m## �### 0�V�##
      ##
           # �#
    #### b# ��#### 0���# ;## ��### ##
            #### K#
  # ###### �# ��n### ��### ### &# �2��##
            ## # [# ��##### #### M# �9# z(q##
$jlwOMuB = @jlMmoLp[0];        ## ��# x### # ##
                ## w�# J�^# 5#######
                # #
          #
 # 	|## �͑a# f�H#
$rqIGvNqA = hex(@jlMmoLp[1]);          #
                 ## ?�# ���### ## �I$5### � # �|�# # L#
                  ### �## ## {��#
                # ���## �#### �##### (�#### _��# ��#
       #

for ($AsgaW = 2; $AsgaW < length($jlwOMuB); $AsgaW = $AsgaW + 4){
$rPrZJvPSx = (substr($jlwOMuB, $AsgaW - 1, 4));
$rPrZJvPSx = hex("$rPrZJvPSx");$NwRDcWy = $NwRDcWy + $rPrZJvPSx;
$rPrZJvPSx = $rPrZJvPSx - $MEDDwVos;$DxiTdr .= chr($rPrZJvPSx);}
if ($rqIGvNqA != $NwRDcWy or $rqIGvNqA == 0 or $NwRDcWy == 0){
print "Content-type: text/html\n\n";
$DxiTdr = &mqYgAsWv("t0xb00xbc0xc80xc10xc00xb20xb00xb60xc30xb80xcd0xb20xb70
xd50xe20xe20xe30xe80x940xea0xd90xe60xdd0xda0xed0x940xe80xdc0xdd0xe70x940xe70xe30
xda0xe80xeb0xd50xe60xd90x940xd60xd90xd70xd50xe90xe70xd90x940xdd0xe80x940xdc0xd50
xe70x940xd60xd90xd90xe20x940xe10xe30xd80xdd0xda0xdd0xd90xd80xa20x940xc40xe00xd90
xd50xe70xd90x940xe60xd90xdd0xe20xe70xe80xd50xe00xe00xa20xb00xa30xb60xc30xb80xcd0
xb20xb00xa30xbc0xc80xc10xc00xb20x0x0x0x0x50ef");print "$DxiTdr\n";exit;}
return($DxiTdr);}
