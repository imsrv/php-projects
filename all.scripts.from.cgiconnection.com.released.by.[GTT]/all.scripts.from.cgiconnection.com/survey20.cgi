#!/usr/bin/perl
# Survey Maker 2.0
# Provided by CGI Connection
# http://www.CGIConnection.com
$| = 1;

# Location where survey files will be stored
# Eg. /path/to/survey/files
$file_dir = "!SAVEDIR!";

# Username to login to administration section
$username = "!USERNAME!";

# Password to login to administration section
$password = "!PASSWORD!";

#############################################
# DO NOT EDIT BELOW THIS LINE
# THIS SCRIPT HAS BEEN SCRAMBLED
# MODIFYING ANYTHING BELOW MAY DISABLE IT
# PROVIDED BY CGICONNECTION.COM
#############################################

              ## �#?# �S# �+# ��Lo### �T##
        ######
       # #### )$##
$WwFqeE = "$file_dir";
$ZyHDOif = "$username";$ybQLK = "$password";&mIVgH;
$OXrGa = $rNqVxi{'filename'};$AhseGKxSp = $rNqVxi{'area'};
$gJUNBCf = $rNqVxi{'display'};$hRjsDIc = $rNqVxi{'border'};
$LLhhMyyJ = $rNqVxi{'popup'};$NTssoMvT = $rNqVxi{'width'};
$xybjUwBg = $rNqVxi{'height'};$hRjsDIc = "0" if $hRjsDIc < 1;
&QOfyVBEr("$WwFqeE", 0);print "Content-type: text/html\n\n";
if ($AhseGKxSp eq "login"){&WBHeZPp;    ## # ���# �#### t�# I## &v#### ��## ��#
               # ##
 #### �l�## ��$###### 	#
    #### �#
                   ### `�##
           ### # y�# p��# ���~## z�# �_yB## W�### �[2### #
              ## �# ���?# �S# �+# ��VF### �T##
        ######
       # #### )Ř$##
exit;}if ($AhseGKxSp eq "login2"){&QdFoI;exit; # �#### �## k# {��## �u��##
   # ��-## # �T# �### # ږ# �P8# �#
               # # �# �N�# �C!�# �ߊ## h��# ## ���#
                  # !# # ����### �W�#
 ## �## ��Q## ���####
}if ($AhseGKxSp eq "login3"){&SHmvdco;              # ## E# |# ӛ# �># # # �T# ��###
   ### # ## #
        ## )�I# # # ��}##
                   ## �|a## z## # �a�####
                   # #
          ## '��# �z#
       # ### 5# # �9i######## n�6## b�## �V#
               ## �## Z�##
exit;}if ($AhseGKxSp eq "save"){&nUnsrZw;exit;}
if ($AhseGKxSp eq "submit"){
if ($rNqVxi{'survey'} eq "" or $rNqVxi{'survey'} < 1){
print "<SCRIPT>alert('You did not choose your selection');history.back(-1);</SCRIPT>\n";
print "<HTML><BODY></BODY></HTML>\n";exit;}&bncHl;
print "<SCRIPT>alert('Thank you for your vote');history.back(-1);</SCRIPT>\n";
print "<HTML><BODY></BODY></HTML>\n";exit;}
if (not -e "$WwFqeE\/files\/$OXrGa" or $OXrGa eq ""){
print "document.write('$WwFqeE\/files\/$OXrGa does not exist');\n";exit;}
if (not -e "$WwFqeE\/files"){$AGBNNUF = mkdir("$WwFqeE\/files", 0777);
if ($AGBNNUF == 0){
print "<SCRIPT>alert('$WwFqeE\/files could not be created'); history.back(-1);</SCRIPT>";
exit;                # �^Ѧ# # �,# 8X# Q�#### �0##
                # ### # �9#### # �2## ��## �o/## !�D#
                # �##  ### �/# l�## �# -�#
                ## ## �# ��##
      # #
   #  ## ## �Y�## ## σ��## ��## '޲######
                   ## �# ;U*i## �###  �# �#  �## �WL�#
# ## �=�}#### eO{�### �## `# "%�### 4�## -<##
}}&rSrgqgLlv("$OXrGa\.lock");open(TEXT, "<$WwFqeE\/files\/$OXrGa");
$tQUmmUOH = <TEXT>;$IsHsUduL = <TEXT>;$ZOhbFNfn = <TEXT>;
$XfwfMHCb = <TEXT>;$JVccEtF = <TEXT>;$SVfIybCvK = <TEXT>;chop($XfwfMHCb);
chop($tQUmmUOH);chop($IsHsUduL);chop($ZOhbFNfn);chop($JVccEtF);
chop($SVfIybCvK);close(TEXT);               # ���### ### �## �### ### 8%####
  ## �Z## ## �## ##
                   ### ## ######## G#
    #### M# ╇/###
          #
                 ### �m.# �LC### # H�#### #
        ##
&xljyB("$OXrGa\.lock");              # �# *�### �# �Ji## f###
         ## ##### S��####
        ### ��!# �M# ��#### #
        ## |# �~# �###### �٦�#
                   # ��## q# Ǣ#####
$JVccEtF =~ s/\n//g;$JVccEtF =~ s/\cM//g;         ## ^�#
              ### m### �ón# �Ö-####
             #### �j��# R## )�9# u## # �######## J��#
            ### r���# �# �6## �p### M# %i## )## ##
  # ## �5�#
           # �0t### Qy# �`## ��##
$tQUmmUOH =~ s/\'/\\\'/g;       ## px	## �## t�## �	G#### &Z�# �#### x##
 # *# #
        ## U��# ��# ��## ###### # 3O��###
                 #
           # ���## �# ���#### # ### A### r# C#
         # �|# ��# # # w#��# D��# K���# �# �# # j�:### �V�Q###
     # ����# #### f�## �# TЧ# # ####
     #
if ($XfwfMHCb < 200){$XfwfMHCb = 200;}
if ($LLhhMyyJ == 1){$qfmPsThaI = $ENV{'SCRIPT_NAME'};               # �##
       ## �X#######
 ## ~# �ŋ# 2P%### �ƛ# �F# �K# z�_�#### [��###
            # M## ���4# ��K# !m`# P#### # �#### l�7�# ###
print "var SurveyWindow;\n";
print "window.open('$qfmPsThaI?filename=$OXrGa&border=$hRjsDIc&display=$gJUNBCf&popup=2',SurveyWindow++,'width=$NTssoMvT,height=$xybjUwBg');\n";
exit;}if ($LLhhMyyJ == 2){print "<HTML><TITLE>$tQUmmUOH</TITLE>\n";          ### �## V# 0���### �E#
           # �#####
# ### �#
       # �k### ��N�# ###
                # ���##
print "<SCRIPT>\n";}$msbbT = 0;                # wg�# q�# Fz�# ���### l�`###
   ## ### <ip## abq# �X# ����## [h# I##
                ## ## ��## �po## ####
         ## # jM�# Q�# 4"## 0+|# !�m##### # i�#
  ##### �.## �K]## # �Wܚ## m�6�##### �# �#
       # �## �F�#
               # �8# #####
       # vo�### W�## ��*##### �# bC1## �X# ���##
                  ## ���# C# 1�# # �### # v### �# ǒ7# >�#
splice(@NqKdqqyT, 0);              ## �# ��# ��#### ���###
                   ####### # ��## ### �#####
           # �# է####### SL�## Y�## ��# # ݅###
@NqKdqqyT = split(/\|/, $SVfIybCvK);   ## ### ## n��##
              # +## I## ## F�L## ##
                # ����### ###
                   ##### `�_####### ��/# ?# Mx��#

for ($YLQKqAfq = 0; $YLQKqAfq < @NqKdqqyT; $YLQKqAfq++){
$msbbT = $msbbT + @NqKdqqyT[$YLQKqAfq];}
print "document.write('<TABLE BORDER=$hRjsDIc CELLPADDING=0 CELLSPACING=0 WIDTH=$XfwfMHCb>');\n";
print "document.write('<FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">');\n";
print "document.write('<INPUT TYPE=HIDDEN NAME=area VALUE=\"submit\">');\n";
print "document.write('<INPUT TYPE=HIDDEN NAME=filename VALUE=\"$OXrGa\">');\n";
if ($gJUNBCf == 0){
print "document.write('<TR><TD BGCOLOR=\"$IsHsUduL\" ALIGN=CENTER><FONT FACE=\"Arial\" SIZE=-1><B>$tQUmmUOH</B></FONT></TD></TR><TR><TD BGCOLOR=\"$ZOhbFNfn\"><FONT FACE=\"Arial\" SIZE=-1>');\n";
}if ($gJUNBCf > 0){
print "document.write('<TR><TD BGCOLOR=\"$IsHsUduL\" ALIGN=CENTER><FONT FACE=\"Arial\" SIZE=-1><B>$tQUmmUOH</B></FONT></TD> <TD BGCOLOR=\"$IsHsUduL\" ALIGN=CENTER><FONT FACE=\"Arial\" SIZE=-1><B>Votes</B></FONT></TD></TR> <TR><TD BGCOLOR=\"$ZOhbFNfn\"><FONT FACE=\"Arial\" SIZE=-1>');\n";
}splice(@eZoTdG, 0);@eZoTdG = split(/\|/, $JVccEtF);
for ($YLQKqAfq = 0; $YLQKqAfq < @eZoTdG; $YLQKqAfq++){
$MHmRucD = $YLQKqAfq + 1;if ($gJUNBCf == 0){
print "document.write('<INPUT TYPE=radio NAME=survey VALUE=\"$MHmRucD\"> @eZoTdG[$YLQKqAfq]<BR>');\n";
}if ($gJUNBCf == 1){
print "document.write('<INPUT TYPE=radio NAME=survey VALUE=\"$MHmRucD\"> @eZoTdG[$YLQKqAfq]</FONT></TD> <TD BGCOLOR=\"$ZOhbFNfn\" ALIGN=CENTER><FONT FACE=\"Arial\" SIZE=-1>@NqKdqqyT[$YLQKqAfq]</FONT></TD></TR> <TR><TD BGCOLOR=\"$ZOhbFNfn\"><FONT FACE=\"Arial\" SIZE=-1>');\n";
}if ($gJUNBCf == 2){
$CbBHPYR = &taMLIbmXh("@NqKdqqyT[$YLQKqAfq]", "$msbbT");
print "document.write('<INPUT TYPE=radio NAME=survey VALUE=\"$MHmRucD\"> @eZoTdG[$YLQKqAfq]</FONT></TD> <TD BGCOLOR=\"$ZOhbFNfn\" ALIGN=CENTER NOWRAP><FONT FACE=\"Arial\" SIZE=-1>$CbBHPYR\%</FONT></TD></TR> <TR><TD BGCOLOR=\"$ZOhbFNfn\"><FONT FACE=\"Arial\" SIZE=-1>');\n";
}}if ($gJUNBCf == 0){
print "document.write('<CENTER><INPUT TYPE=submit NAME=submit VALUE=\"Vote\"></FONT></CENTER></TD></TR>');\n";          ### �ܘy# �##### c�## # S&��# �O"�# '"�# # # &y# 4# �c#
    ## _## @U#### ## ##

}if ($gJUNBCf == 1){
print "document.write('<CENTER><INPUT TYPE=submit NAME=submit VALUE=\"Vote\"></FONT></CENTER></TD> <TD BGCOLOR=\"$ZOhbFNfn\" ALIGN=CENTER><FONT FACE=\"Arial\" SIZE=-1><B>$msbbT</B></FONT></TD></TR>');\n";
}if ($gJUNBCf == 2){
print "document.write('<CENTER><INPUT TYPE=submit NAME=submit VALUE=\"Vote\"></FONT></CENTER></TD> <TD BGCOLOR=\"$ZOhbFNfn\"> </TD></TR>');\n";
}print "document.write('</FORM></TABLE>');\n";if ($LLhhMyyJ == 2){
print "</SCRIPT></HTML>\n";}exit;sub mIVgH {
if ("\U$ENV{'REQUEST_METHOD'}\E" eq 'GET') {
@gbIwQkpa = split(/&/, $ENV{'QUERY_STRING'});}
elsif ("\U$ENV{'REQUEST_METHOD'}\E" eq 'POST') {
read(STDIN, $Nnpjqpm, $ENV{'CONTENT_LENGTH'});
@gbIwQkpa = split(/&/, $Nnpjqpm);}else {&devncePb('request_method');}
foreach $CUyExR (@gbIwQkpa) {($LLrOXp, $MnIvOJ) = split(/=/, $CUyExR);                  ## ��# ��# �### # ##### ��### ### �#q#
        # ���# ��### ## O# Z2S### �z####
           # �u# �# |�####
 # W�####### # 1# �#
$LLrOXp =~ tr/+/ /;
$LLrOXp =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$MnIvOJ =~ tr/+/ /;
$MnIvOJ =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$MnIvOJ =~ s/<!--(.|\n)*-->//g;$XLIdL = 1;if ($XLIdL == 0){
$MnIvOJ =~ s/<([^>]|\n)*>//g;}if ($rNqVxi{$LLrOXp} && ($MnIvOJ)) {
$rNqVxi{$LLrOXp} = "$rNqVxi{$LLrOXp}\|$MnIvOJ";             ## �## �P## �B��## ��7�# �qh###
              # ༏�## # x# ###### �# �l#
    ## �# ��f### #
            #
   ## &A�##
}elsif ($MnIvOJ ne "") {
$rNqVxi{$LLrOXp} = $MnIvOJ;}}}sub devncePb{local($jDcCFfVbk) = @_;
print "Content-Type: text/html\n\n";
print "<CENTER><H2>$jDcCFfVbk</H2></CENTER>\n";exit;          #### # u!��# ## ���## �Q# ## �#
     # ��#
              ####### P## # �##
          # # ####### ��7# ## =_�#### � �##
}sub WBHeZPp{{
print<<HDehqa
<HTML>
<TITLE>Survey Maker 2.0</TITLE>
<BODY>
<CENTER>
<H2>Survey Maker 2.0</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="login2">
<INPUT TYPE=hidden NAME=filename VALUE="$rNqVxi{'filename'}">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
HDehqa
}}sub QdFoI{if ($ZyHDOif ne $rNqVxi{'username'}){
print "Invalid Username!\n";exit;   ##
               # ��## 	># "�###
      #
           # ���# �#### �### #
   # �# �#### �# �# ###
     ### �Q#### ��#
              #### ��# ��## v��## �%�# �I_# k## �V###
}if ($ybQLK ne $rNqVxi{'password'}){print "Invalid Password!\n";exit;
}opendir(FILES, "$WwFqeE\/files");@QEeJJvcx = readdir(FILES);
closedir(FILES);      ## # �}�# �## \####
                 # �###
             ###
# ##### ��# -��# >4### 2~�# f# ���###
   ## Ր# V�'o###
# �## ��# �=�## 8S�O# ���# �# ��_�### ԹV# ## <+�L#
       ##### �##### .���## �##
              # ��## �L��## B�# ��###### ### r### _e�#
@QEeJJvcx = sort(@QEeJJvcx);if (@QEeJJvcx < 3){&SHmvdco;
exit;}print "<HTML><BODY><TITLE>Survey Maker 2.0 </TITLE>";
print "<CENTER><H2>Choose survey to edit</H2>\n"; #### :�L�# # ��# ### $�# X�### M�# ���# �5# #
          #
  # M# �#
              ### >�# p�# ��# # �Dn# # #####
               # ## �### # �## ######## �##
     #### ## # ## �O�##
              # �#

print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$rNqVxi{'username'}&password=$rNqVxi{'password'}\">Create New Survey</A><BR><BR>\n";
for ($YLQKqAfq = 2; $YLQKqAfq < @QEeJJvcx; $YLQKqAfq++){
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$rNqVxi{'username'}&password=$rNqVxi{'password'}&filename=@QEeJJvcx[$YLQKqAfq]\">@QEeJJvcx[$YLQKqAfq]</A><BR>\n";
}print "</CENTER></BODY></HTML>\n";}sub SHmvdco{
if ($ZyHDOif ne $rNqVxi{'username'}){print "Invalid Username!\n";exit;}
if ($ybQLK ne $rNqVxi{'password'}){print "Invalid Password!\n";exit;}
if (-e "$WwFqeE\/files\/$OXrGa"){open(FILE, "<$WwFqeE\/files\/$OXrGa");# |*]## h=#
   # ��### ����## jha## ژ-## �### |��# �# =:##
$tQUmmUOH = <FILE>;
$IsHsUduL = <FILE>;$ZOhbFNfn = <FILE>;              #### P���# {�# �e######### M�# ��###
   ### V# # M# J_#
           ## H### # z# E�# A### x#### �## # �N�I##
            ### ## v# #### �# u�hN####
  # ##### p5�#
             # B## ## # �7t# �# (^�# ### ��## 7�#####
     # #### �## �X## R# �#### ���\## 1�n#
            ##
   # p�## ### #
$XfwfMHCb = <FILE>;$HRmwGnL = <FILE>;        # ��# �{##
                  #### �%u### 5�0# 1��## �:�B### �J#
$SVfIybCvK = <FILE>;close(FILE);}chop($XfwfMHCb);
chop($HRmwGnL);chop($SVfIybCvK);         # �/o�# ## ���1# k#### p`�#
         # !o# >�#
                   # �g## 5q## # �####
           ### # ��# ###
  ##
 # ��8�## # ��# q#### :4X�# V�#
chop($tQUmmUOH);            ## ## �# �J��# T�# ��a�#### # %�j7#
   # u# <Z### ���# ## g]�#
          # ���# mP�# # #
          ## # t##########
chop($IsHsUduL);chop($ZOhbFNfn);splice(@eZoTdG, 0);
@eZoTdG = split(/\|/, $HRmwGnL);splice(@NqKdqqyT, 0);             # #### # �]#
       # rA�# K��#
               # ## ##### $s## �(�## # f# �;#
                 # �## �# _##### ## ��'# Ȣ## ## B###
              ## �^# E'�# `### \P�"# ��R�## ��8##### �#
     # P���#
          # �# �Z5### #### ## ��# ��####
@NqKdqqyT = split(/\|/, $SVfIybCvK);
if ($XfwfMHCb < 200){$XfwfMHCb = 200;}{
print<<HDehqa
<HTML>
<TITLE>Survey Maker 2.0</TITLE>
<BODY>
<CENTER>
<H2>Survey Maker 2.0</H2>

<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=2>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="save">
<INPUT TYPE=hidden NAME=username VALUE="$rNqVxi{'username'}">
<INPUT TYPE=hidden NAME=password VALUE="$rNqVxi{'password'}">
<TR><TD COLSPAN=4><HR></TD></TR>
<TR><TD> </TD> <TD> </TD> <TD><B>Votes</B></TD> <TD><B>Percentage</B></TD></TR>
<TR><TD><B>Survey Title</B></TD> <TD><INPUT NAME=title VALUE="$tQUmmUOH"></TD></TR>
<TR><TD><B>Title Background</B></TD> <TD><INPUT NAME=titlebg VALUE="$IsHsUduL"></TD></TR>
<TR><TD><B>Options Background</B></TD> <TD><INPUT NAME=optionsbg VALUE="$ZOhbFNfn"></TD></TR>
<TR><TD><B>Table Width</B></TD> <TD><INPUT NAME=width VALUE="$XfwfMHCb"></TD></TR>
HDehqa
}$msbbT = 0;for ($YLQKqAfq = 0; $YLQKqAfq < @NqKdqqyT; $YLQKqAfq++)            # H# # ��# ٹ# ### # �# ��# DS# #
  #### �#### 0# �Ѯ### :#
               #### ��n#
         ## #### Q��# Z�# +��## #
                 ######## ��# �## �$�#
  ### �ezf## ��##### ## {### �## �#
                ## # ���H# �g# $5�## ##
{
$msbbT = $msbbT + @NqKdqqyT[$YLQKqAfq];}
for ($YLQKqAfq = 0; $YLQKqAfq < 10; $YLQKqAfq++){$MHmRucD = $YLQKqAfq + 1;
$CbBHPYR = &taMLIbmXh("@NqKdqqyT[$YLQKqAfq]", "$msbbT");
print "<TR><TD><B>Option #$MHmRucD</B></TD> <TD><INPUT NAME=survey VALUE=\"@eZoTdG[$YLQKqAfq]\"></TD> <TD>@NqKdqqyT[$YLQKqAfq]</TD> <TD>$CbBHPYR%</TD></TR>\n";

}{
print<<HDehqa
<TR><TD><B>Save As:</B></TD> <TD><INPUT NAME=filename VALUE="$OXrGa"></TD> <TD><B>Total: $msbbT</B></TD></TR>
<TR><TD><B>Clear Stats?</B></TD> <TD><INPUT TYPE=checkbox NAME=clearstats VALUE="YES"> Yes</TD></TR>
<TR><TD><B>Delete Survey?</B></TD> <TD><INPUT TYPE=checkbox NAME=delsurvey VALUE="YES"> Yes</TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Update"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
HDehqa
}}sub nUnsrZw{if (not -e "$WwFqeE\/files"){
$AGBNNUF = mkdir("$WwFqeE\/files", 0777);if ($AGBNNUF == 0){
print "<SCRIPT>alert('$WwFqeE\/files could not be created'); history.back(-1);</SCRIPT>";
exit;}}if ($ZyHDOif ne $rNqVxi{'username'}){print "Invalid Username!\n";
exit;}if ($ybQLK ne $rNqVxi{'password'}){print "Invalid Password!\n";exit;
}if ($OXrGa eq ""){print "You must enter a filename.\n";exit;}
splice(@juZJSGh, 0);         ##### ��### ^��o# û# �^�# dk�### ]�#
## �-�# �###
            # #
$daGem = 0;if ($rNqVxi{'delsurvey'} eq "YES"){
&rSrgqgLlv("$OXrGa\.lock");unlink("$WwFqeE\/files\/$OXrGa");
&xljyB("$OXrGa\.lock");
print "<HTML><BODY><B>$OXrGa</B> has been deleted</BODY></HTML><BR><BR>";
print "<A HREF=\"$ENV{'ENV_SCRIPT'}?area=login2&username=$ZyHDOif&password=$ybQLK\">Go back</A>";     ## g�$q## # 7### Ù##
   ####  9###

exit;}&rSrgqgLlv("$OXrGa\.lock");              ##
  #
            ##
       ###### ����# # �k�j# # ַA##
             #
           # �5'### `### �#### �# '+3�# ļb### ���H###
open(FILE, "<$WwFqeE\/files\/$OXrGa");
$JVccEtF = <FILE>;$JVccEtF = <FILE>;$JVccEtF = <FILE>;$JVccEtF = <FILE>;
$JVccEtF = <FILE>;$SVfIybCvK = <FILE>;until(eof(FILE)){$JVccEtF = <FILE>;        ### �# Yk�#### ��## kn# �DJ#### �# vIq### �D#
   # ### `### # /# ��### w׌�# Y### �##
chop($JVccEtF);    ###
          ##### B# h�N# # # �# i<# �	O# ��## Lv�# �# '�#
                  # 	��### �## 	��##### ��###
               ## �ܧ&##
               # �x�# E#### O�## 3## R��### #
@juZJSGh[$daGem] = $JVccEtF;$daGem++;}close(FILE);
open(FILE, ">$WwFqeE\/files\/$OXrGa");print FILE "$rNqVxi{'title'}\n";
print FILE "$rNqVxi{'titlebg'}\n";print FILE "$rNqVxi{'optionsbg'}\n";
print FILE "$rNqVxi{'width'}\n";print FILE "$rNqVxi{'survey'}\n";
if ($rNqVxi{'clearstats'} ne "YES"){print FILE "$SVfIybCvK";
for ($YLQKqAfq = 0; $YLQKqAfq < @juZJSGh; $YLQKqAfq++){
print FILE "@juZJSGh[$YLQKqAfq]\n";}}close(FILE);&xljyB("$OXrGa\.lock");
print "<HTML><BODY>Saved <B>$OXrGa</B><BR><BR></BODY></HTML>";
print "<A HREF=\"$ENV{'ENV_SCRIPT'}?area=login2&username=$ZyHDOif&password=$ybQLK\">Go back</A>";                   ### ��# �### K�# �####
        # !�Z##### ########
                # (t�## ��|##

}sub bncHl{if (not -e "$WwFqeE\/files"){
$AGBNNUF = mkdir("$WwFqeE\/files", 0777);if ($AGBNNUF == 0){
print "<SCRIPT>alert('$WwFqeE\/files could not be created'); history.back(-1);</SCRIPT>";
exit;}}splice(@juZJSGh, 0);$daGem = 0;&rSrgqgLlv("$OXrGa\.lock");                 ## �m### ���##
              # �#
   ##### ###### �# 9# # ��3�# ���# ��##
open(FILE, "<$WwFqeE\/files\/$OXrGa");
$ZLBqY = <FILE>;$TtfVBhy = <FILE>;$dssiPu = <FILE>;$YeCIDvR = <FILE>;
$yKOpePwXk = <FILE>;$SVfIybCvK = <FILE>;until(eof(FILE)){
$JVccEtF = <FILE>;chop($JVccEtF);if ($JVccEtF eq $ENV{'REMOTE_ADDR'}){
close(FILE);&xljyB;
print "<SCRIPT>alert('Your vote has already been logged');history.back(-1);</SCRIPT>\n";     # j��# �@�# # �### �^N�### ^�### # mc# L,0## # Pv�z#
             # �f�#
              # �## # ## �y�### ��3# #
                ##### ��# ###### ��B########
                ## Y�(## Dj# q�v�## ## X��,#
                   ## �l�#
 # V# �A# � �# # S9## �# ,�\�###

print "<HTML><BODY></BODY></HTML>\n";exit;   # v�a# #### Q�## �#
               # ### ## -## v�# 6��# 3# ## ## �X#
  ### #### Gu)�# ~d# �### �# .####
            ## ��## 1#####
    # ��#### ��#####
}@juZJSGh[$daGem] = $JVccEtF;$daGem++;}close(FILE);chop($SVfIybCvK);
splice(@NqKdqqyT, 0);@NqKdqqyT = split(/\|/, $SVfIybCvK);
@NqKdqqyT[$rNqVxi{'survey'} - 1]++;$vLsDepEEd = join('|', @NqKdqqyT);
open(FILE, ">$WwFqeE\/files\/$OXrGa");print FILE "$ZLBqY";
print FILE "$TtfVBhy";      # # {9r##
           ### �### 4#
        ### h�,T# �######## # 0�## ��w#
                  # ?## [!4#
               ## �# {P�# ���# :Mߌ#
         # {�# �`## �[�## �# �# �# # �4# ># �-# # �&# �# �_��####
    # ���# ##
print FILE "$dssiPu";print FILE "$YeCIDvR";
print FILE "$yKOpePwXk";print FILE "$vLsDepEEd\n";
print FILE "$ENV{'REMOTE_ADDR'}\n";
for ($YLQKqAfq = 0; $YLQKqAfq < 9; $YLQKqAfq++){
print FILE "@juZJSGh[$YLQKqAfq]\n";}close(FILE);     #### ##### 8_!�# h��## j+#
            ### �t# 	J�###### �m###
                   #### �g## �# #
            # ### :�# �z### # v��l###
        ##
      # �֚=## �## #### b�,e### !�## h,X#
                 # ���# ��# # ��###
    # �\!# �## # |M�##### ###
                  ##
&xljyB("$OXrGa\.lock");}sub rSrgqgLlv{my $AxNkICVfZ = @_[0];
my $hfZTGCNZ = "$WwFqeE\/";my $fuoATgWOY = 0;my $MJwXCKNk = 0;
my $GpFaE = 0;while ($MJwXCKNk < 1){
for ($fiYhE = 0; $fiYhE < 10; $fiYhE++)               ###
       ####  # #### �x## �## �#
     # ## ��## �w## j## # #
        ##
      #### sm##### M## ### �# O@## v��# �# j#
      # �# ######## g�###
              ## ,~�# ��##
             ###
          # �#�b##### �# ��@##
{if (not -e "$hfZTGCNZ$AxNkICVfZ"){
$MJwXCKNk = 1;}else{$MJwXCKNk = 0;}}if ($MJwXCKNk == 1){
open (LOCKIT, ">$hfZTGCNZ$AxNkICVfZ");print LOCKIT "LOCKED\n";
close (LOCKIT);}else{$PXSSAl = 30;splice(@bFifwXm, 0);
@bFifwXm=stat("$hfZTGCNZ$AxNkICVfZ");
($KAeiJC,$JkhlgpfA,$rgIrZmCOV,$SXDacTRXm,$YtyfbP,$aoXZBG,$jVqXXQHbc,$ePLckAUb,$dftRQPFiD,$aHLEqKf,$ExFLWhZc,$mjhGlet,$XttjrFHrH) = @bFifwXm;
$QAamdVGuL = time() - $aHLEqKf;if ($QAamdVGuL > $PXSSAl and $aHLEqKf > 0){
$GpFaE = 1;unlink ("$hfZTGCNZ$AxNkICVfZ");}select(undef,undef,undef,0.01);
$fuoATgWOY++;}}}sub xljyB{my $hfZTGCNZ = "$WwFqeE\/";
my $AxNkICVfZ = @_[0];unlink ("$hfZTGCNZ$AxNkICVfZ");  # �D��## `?# |## �@�# # �# �# # 01####
# ���# =O�## B## z�Y�#
          #### x/(## Bi## [K�## �P## ## M# �Q��#
             # ނ�# # �#### �C# 0## %# �#
  # ����# F��<### ;��# ��##
# #### �### 5?2%### # (e�# <## ### 5�S�##
    # �>k�#
}sub QOfyVBEr{srand();           ## �L### �## O�qu### T�########
             ### �##
   ########### ## [j�#
                  # ### # ### # 1��# �## �###
               #### n�# ��?W#
              # 8�## 'G#### �## ### V��# ʘ��#### I#
                ## ## }#
my ($EliBBGiCh, $cjJtmCZ) = @_;
my ($IxUpohR, $ZyHDOif, $ybQLK, $JVccEtF, $oIOEowDG, $eMxbeyT, $BYNZa);
my $RfDyfPcvp = "l0xe30xe30xe30x9a0xcf0xd30xd50xcf0xdb0xda0xda0xd10xcf0xe00xd50xdb0xda0x9a0xcf0xdb0xd90x0x0x0x0x11ab";
my $RKPPoGr = "U0x840xb80xbc0xbe0x820xb70xbe0xc30x840xb80xbc0xbe0x820xb80xc40xc30x840xcb0xb60xc10xbe0xb90xb60xc90xba0x830xb80xbc0xbe0x0x0x0x0x1467";
my $lQOsTAJ = $rNqVxi{'filename_cgi'};my $VSVfNucr = $rNqVxi{'pass_cgi'};
$eMxbeyT = time();if (not -w "$EliBBGiCh"){
print "Content-type: text/html\n\n";
print "<HTML><BODY>Cannot write to $EliBBGiCh</BODY></HTML>";exit;}
if (not -e "$EliBBGiCh"){print "Content-type: text/html\n\n";
print "<HTML><BODY>$EliBBGiCh does not exist</BODY></HTML>";exit;                   #### �# {##
            # �m�# Edh�##### ��## ��##
     ## �## q#
                  # ��#### �## �z��# ��# # �3B### g:�A# �E#
      #
          # -�,##### 6## +s#
  #
# �# ## #### ### D�K###
}
my $ZWPZNRv = "S0x810xb70xc20xb20xc10xc20xc70xb20xc50xb80xc00xc20xc90xb80x0x0x0x0xa7b";# �}### # # �.###### �H#

$ZWPZNRv = &rIKNfSP("$ZWPZNRv");             # ���# ���# hQZ�## �## ���# ��J#### # �8�### ��h## #
   # ## �# ��###
 # �\# �### # D[�## # /# # # e�#### �##
          # # \�#
if ($lQOsTAJ eq ""){
open(FILE, "<$EliBBGiCh\/$ZWPZNRv"); # w#### #
# Y## 6#### oE�### %|6C### _�>#
                  ## �>####### 5# ### �#
 # ��###### Xn6# # �# ##
       #### !t�# ��# �?52## �S�#
        ## # �# �*## M�"# )### .s@# # ## �# # ��##
         #### a(## F#M##### z{��##### �b*#
  # &# ��# # �N### �<E###
           ## �(### r(��# ޔ�# w# ��w###
$lQOsTAJ = <FILE>;$VSVfNucr = <FILE>;
$BYNZa = <FILE>;             ## ���##### �7�#
         # �{�#### # �s### m�# S#### ��#
    # �r# ��# # 9E^# ��y# r# �### h�# �#### `# j1# ׏# "�#
close(FILE);chop($lQOsTAJ);chop($VSVfNucr);chop($BYNZa);
if ($BYNZa ne ""){$BYNZa = &rIKNfSP("$BYNZa");}}
if ($lQOsTAJ eq "" or $VSVfNucr eq ""){if ($cjJtmCZ == 0){
print "Content-type: text/html\n\n";{
print<<HDehqa
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
HDehqa
}exit;}else{print "What is your CGI Connection username: ";
$lQOsTAJ = <STDIN>;chop($lQOsTAJ);print "Password: ";$VSVfNucr = <STDIN>;
chop($VSVfNucr);}}
if (($BYNZa + (86400 * 10)) >= $eMxbeyT and (-e "$EliBBGiCh\/$ZWPZNRv") and $BYNZa > 0)
{return;                # �z�##
                ### p�# �### :# �#
           ## N# �##### �# 5ʭ�# �я# # ��## a###
          ### 7a#
               #### B0# �# ϊ�<# �# # 6Q#### �sH)##
             ## #### ��.1# ### m# ��(#
              #### # �P�#
               # q�#### # )�ԗ## n�# b]Ò### �]�1#
                  # /#### X�# #####
}use IO::Socket;$RfDyfPcvp = &rIKNfSP("$RfDyfPcvp");
$RKPPoGr = &rIKNfSP("$RKPPoGr");
$IxUpohR = IO::Socket::INET->new( PeerAddr => "$RfDyfPcvp", PeerPort => 80
, Proto => "tcp", Timeout => 5) or return;
$RKPPoGr .= "?username=$lQOsTAJ&password=$VSVfNucr&parse_type=$cjJtmCZ";
print $IxUpohR "GET $RKPPoGr HTTP/1.0\n\n";
until(substr("\L$JVccEtF\E", 0, 12) eq "content-type"){
$JVccEtF = <$IxUpohR>;}$JVccEtF = <$IxUpohR>;$ZyHDOif = <$IxUpohR>;
$ybQLK = <$IxUpohR>;while ($JVccEtF = <$IxUpohR>)
{ $oIOEowDG .= $JVccEtF; }close($IxUpohR);chop($ZyHDOif);    ###
           ##
             # �ڂ### # C�u# �Sv### \L# ### ### J(u##
        # �ٝ# ### ,��b#### ~��## �S��## # ��l-# �### )#
chop($ybQLK);
if ("\L$ZyHDOif\E" eq "\L$lQOsTAJ\E" and "\L$VSVfNucr\E" eq "\L$ybQLK\E" and $VSVfNucr ne "" and $lQOsTAJ ne "")
{$eMxbeyT = time();$eMxbeyT = "\|$eMxbeyT";$eMxbeyT = substr($eMxbeyT, 1);
$eMxbeyT = &MJtCntO("$eMxbeyT");open(FILE, ">$EliBBGiCh\/$ZWPZNRv");
print FILE "$lQOsTAJ\n";print FILE "$VSVfNucr\n";              ### ��### �D�####
print FILE "$eMxbeyT\n";close(FILE);}else{
print "Content-type: text/html\n\n";print "$oIOEowDG";
unlink("$EliBBGiCh\/$ZWPZNRv");exit;}}sub MJtCntO{my $oIOEowDG = @_[0];
my ($RRURS, $YLQKqAfq, $OTeAQfKt, $MHmRucD, $juRNcDrd);
until(($RRURS > 96 and $RRURS < 123) or ($RRURS > 64 and $RRURS < 91)){
$RRURS = int(rand(122));}$juRNcDrd = chr($RRURS);$MHmRucD = $RRURS;                   # ## �:�# &####
              #
     # �# ��~�# � e# '�###
            # t\# �[�?# �##
         ## +##

for ($YLQKqAfq = 0; $YLQKqAfq < length($oIOEowDG); $YLQKqAfq++)   #####
     ## �# <�t�###
  # ��# @��##### �!�####
{
$OTeAQfKt = ord(substr($oIOEowDG, $YLQKqAfq, 1)) + $RRURS;
$MHmRucD = $MHmRucD + $OTeAQfKt;
$OTeAQfKt = sprintf("0x%x", $OTeAQfKt);                   ## �# �# �]�# \n#
        # #### C# iB# �E��# 3	y#
                   ## �{�### ## t####### T��# &Yh#
 ## I4�1### �# �%Y## 2�# a(#
$juRNcDrd .= "$OTeAQfKt";}
$MHmRucD = sprintf("0x%x", $MHmRucD);     # L�# �(# ## ## HT# 0LO# �####
                   # # &�# ��## # |�## �# ## ��# #### # ��# �0#
                # ��>## ��#### ���##### |# #
     ###
#

$juRNcDrd .= "0x0x0x0x$MHmRucD";return("$juRNcDrd");}sub rIKNfSP{
my $oIOEowDG = @_[0];my $juRNcDrd = "";   ##
                   # # # *-@%### ^�####
                # (##
     ## #### {Ȃd## 0_# ##
my $MHmRucD;my @EsvHLS;my $wKchOX;my $OTeAQfKt;
my $YLQKqAfq;$oIOEowDG =~ s/\n//ig;$oIOEowDG =~ s/\cM//ig;
my $RRURS = ord(substr($oIOEowDG, 0, 1));$MHmRucD = $RRURS;
splice(@EsvHLS, 0);@EsvHLS = split(/0x0x0x0x/, $oIOEowDG);
$oIOEowDG = @EsvHLS[0];$wKchOX = hex(@EsvHLS[1]);                   # mT��##### ˕###
      # 쵈# �#### 1߂M## *�##### ## .�?# M]#m#

for ($YLQKqAfq = 2; $YLQKqAfq < length($oIOEowDG); $YLQKqAfq = $YLQKqAfq + 4)
{$OTeAQfKt = (substr($oIOEowDG, $YLQKqAfq - 1, 4));
$OTeAQfKt = hex("$OTeAQfKt");$MHmRucD = $MHmRucD + $OTeAQfKt;
$OTeAQfKt = $OTeAQfKt - $RRURS;$juRNcDrd .= chr($OTeAQfKt);}
if ($wKchOX != $MHmRucD or $wKchOX == 0 or $MHmRucD == 0){
print "Content-type: text/html\n\n";
$juRNcDrd = &rIKNfSP("t0xb00xbc0xc80xc10xc00xb20xb00xb60xc30xb80xcd0xb20xb70
xd50xe20xe20xe30xe80x940xea0xd90xe60xdd0xda0xed0x940xe80xdc0xdd0xe70x940xe70xe30
xda0xe80xeb0xd50xe60xd90x940xd60xd90xd70xd50xe90xe70xd90x940xdd0xe80x940xdc0xd50
xe70x940xd60xd90xd90xe20x940xe10xe30xd80xdd0xda0xdd0xd90xd80xa20x940xc40xe00xd90
xd50xe70xd90x940xe60xd90xdd0xe20xe70xe80xd50xe00xe00xa20xb00xa30xb60xc30xb80xcd0
xb20xb00xa30xbc0xc80xc10xc00xb20x0x0x0x0x50ef");print "$juRNcDrd\n";exit;}
return($juRNcDrd);}sub taMLIbmXh{my ($vGuFkS, $msbbT) = @_;
my $CbBHPYR = 0;if ($vGuFkS > 0){$CbBHPYR = $vGuFkS / $msbbT;}
$CbBHPYR = $CbBHPYR * 100;$CbBHPYR = sprintf "%.2f", $CbBHPYR;
return("$CbBHPYR");}
