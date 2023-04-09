#!/usr/bin/perl
# Meta Tag Generator
# Provided by CGI Connection
# http://www.CGIConnection.com
$| = 1;

srand();

# Where to start searching for your web pages
# Generally it's the absolute path to your home pages
# Eg. /path/to/your/pages
$webdir = "!WEBDIR!";

# Name of folder to create to place backups of pages in
# This folder will be created under each directory
# where files were converted
$backup_folder = "backup";

# Filename extension to use for backups
$backupext = "old";

# DO NOT EDIT BELOW HERE
#########################################
&parse_form;

$nonwritable = 0;
$htmlfiles = 0;
$foundtags = 0;
$mdfoundtags = 0;
$mkfoundtags = 0;
$nofoundtags = 0;
$dircount = 1;
splice(@all_dirs, 0);
$tmpext = int(rand(10000));

@all_dirs[0] = $webdir; 

print "Content-type: multipart/mixed\n\n";
print "<HTML><HEAD><TITLE>Meta Tag Generator</TITLE></HEAD><BODY>\n";

for ($x = 0; $x < 50; $x++)
 {
 print "<!-- FORCE OUTPUT -->\n";
 }

if ($FORM{'area'} eq "")
 {
 &login_screen;
 exit;
 }

splice(@all_ext, 0);
@all_ext = split(/, /, $FORM{'ext'});

for ($xx = 0; $xx < @all_ext; $xx++)
 {
 $DOEXT{@all_ext[$xx]} = 1;
 }

print "<CENTER><H2>Meta Tag Generator</H2></CENTER>\n";

if ($FORM{'viewonly'} ne "")
 {
 print "<CENTER><i>Files are not being converted (view only)</i></CENTER><BR><BR>\n";
 }

print "<CENTER><B><FONT COLOR=BLUE>X</FONT></B>: Could not write to file<BR>\n";
print "<B><FONT COLOR=RED>S</FONT></B>: File contains Smart Tag<BR>\n";
print "<B><FONT COLOR=GREEN>M</FONT></B>: File contains Meta Tag</CENTER><BR><BR>\n";

for ($xx = 0; $xx < @all_dirs; $xx++)
 {
 if (@all_dirs[$xx] ne "")
  {
  &get_files(@all_dirs[$xx]);
  &convert_files(@all_dirs[$xx]);
  }

# splice(@all_dirs, $xx, 1);
 }

$tmfoundtags = $mkfoundtags + $mdfoundtags;

print "Total Files: $htmlfiles<BR>\n";
print "Files converted: $nofoundtags<BR>\n";
print "Files that could not be written to: $nonwritable<BR>\n";
print "Files already containing smart tag: $foundtags<BR>\n";
print "Files already containing meta tags: $tmfoundtags<BR>\n";
print "<SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";
print "</BODY></HTML>\n";
exit;

sub get_files
{
my $tempdir = @_[0];
splice(@all_files, 0);
opendir(FILES, "$tempdir");
@all_files = readdir(FILES);
closedir(FILES);

@all_files = sort(@all_files);
$filecount = @all_files;
}

sub convert_files
{
$nowdir = @_[0];
$j = 2;
$backok = 0;

$backok = mkdir("$nowdir\/$backup_folder", 0777);

print "<BR><B>Directory:</B> $nowdir</B>";

if ($backok == 0 and not -e "$nowdir\/$backup_folder")
 {
 print " (Could not create backup folder - SKIPPING)";
 }

print "<BR>\n";

if ($backok == 1 and $FORM{'viewonly'} ne "")
 {
 rmdir("$nowdir\/$backup_folder");
 }

print "<SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";

until ($j > @all_files)
 {
 $count = 0;
 $headline = 0;
 $htmlline = 0;

 $tfile = "";
 $found = 0;
 $foundit = 0;

 until($foundit == 1 or $j > @all_files)
  {
  $readfile = @all_files[$j];
  $ridx = rindex($readfile, ".");
  $tfile = substr($readfile, $ridx + 1);

  if ("\L$tfile\E" eq "htm" and $DOEXT{'htm'} == 1)
   {
   $foundit = 1;
   }
   elsif ("\L$tfile\E" eq "html" and $DOEXT{'html'} == 1)
   {
   $foundit = 1;
   }
   elsif ("\L$tfile\E" eq "shtm" and $DOEXT{'shtm'} == 1)
   {
   $foundit = 1;
   }
   elsif ("\L$tfile\E" eq "shtml" and $DOEXT{'shtml'} == 1)
   {
   $foundit = 1;
   }
   elsif ("\L$tfile\E" eq "lasso" and $DOEXT{'lasso'} == 1)
   {
   $foundit = 1;
   }
   elsif ("\L$tfile\E" eq "pl" and $DOEXT{'pl'} == 1)
   {
   $foundit = 1;
   }
   elsif ("\L$tfile\E" eq "cgi" and $DOEXT{'cgi'} == 1)
   {
   $foundit = 1;
   }
   elsif ("\L$tfile\E" eq "php" and $DOEXT{'php'} == 1)
   {
   $foundit = 1;
   }

  if (-d "$nowdir\/$readfile" and $readfile ne "" and $readfile ne "." and $readfile ne "..")
   {
   @all_dirs[$dircount] = "$nowdir\/$readfile";
   $dircount++;
   }

  $j++;
  }

 $htmlfiles++;
 $htmllinepassed = 0;
 $headlinepassed = 0;
 $foundmetak = 0;
 $foundmetad = 0;
 $mdarea = 0;
 $mkarea = 0;
 $smarea = 0;

 open(FILE, "<$nowdir\/$readfile");

 until(eof(FILE) or $found == 3)
  { 
  $line = <FILE>;

  if ($line =~ m/<HTML>/i and $htmllinepassed == 0)
   {
   $htmlline = $count;
   $htmllinepassed = 1;
   }

  if ($line =~ m/<HEAD>/i and $headlinepassed == 0)
   {
   $headline = $count;
   $headlinepassed = 1;
   }

  if ($line =~ m/<meta[\s]*name[\s]*=[\s]*\"MSSmartTagsPreventParsing\"/i)
   {
   $found++;
   $foundtags++;
   $smarea = $count;
   }

  if ($line =~ m/<meta[\s]*name[\s]*=[\s]*\"keywords\"/i)
   {
   $found++;
   $mkarea = $count;
   $mkfoundtags++;
   }

  if ($line =~ m/<meta[\s]*name[\s]*=[\s]*\"description\"/i)
   {
   $found++;
   $mdarea = $count;
   $mdfoundtags++;
   }

  $count++;
  }

 close(FILE);

 $hadit = "";
 $nowrite = 0;
 $nodir = 0;

 if (not -w "$nowdir\/$readfile" and not -d "$nowdir\/$readfile")
  {
  $hadit .= "<B><FONT COLOR=BLUE>X</FONT></B> ";
  $nowrite = 1;
  $nonwritable++;
  }

 if (-d "$nowdir\/$readfile")
  {
  $nodir = 1;
  }

 if ($smarea > 0 and $FORM{'addsmart'} ne "")
  {
  $hadit .= "<B><FONT COLOR=RED>S</FONT></B> ";
  }

 if ($mdarea > 0 or $mkarea > 0 and $FORM{'addmeta'} ne "")
  {
  $hadit .= "<B><FONT COLOR=GREEN>M</FONT></B> ";
  }

 print "$hadit$readfile<BR>\n";
 print "<SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";

 if ($nowrite == 0 and $nodir == 0 and $backok == 1)
 {
 $count = 0;
 $metapassk = 0;
 $metapassd = 0;
 $smartpass = 0;
 $nofoundtags++;
 $writefile = "$readfile\.$backupext";

 if ($FORM{'viewonly'} eq "")
  {
  open(FILE, "<$nowdir\/$readfile");
  open(FILE2, ">$nowdir\/$backup_folder\/$writefile");

  until(eof(FILE))
   {
   $didit = 0;
   $line = <FILE>;

   if ($FORM{'addsmart'} ne "" and $smartpass == 0)
    {
    $smdid = 0;

    if ($count == $smarea)
     {
     print FILE2 "<META NAME=\"MSSmartTagsPreventParsing\" CONTENT=\"TRUE\">\n";
     $smdid = 1;
     $smartpass = 1;
     $didit = 1;
     }

    if ($smarea == 0 and $smdid == 0)
     {
     print FILE2 "<META NAME=\"MSSmartTagsPreventParsing\" CONTENT=\"TRUE\">\n";
     $smartpass = 1;
     $didit = 1;
     }
    }

   if ($FORM{'addmeta'} ne "" and $metapassk == 0)
    {
    $mkdid = 0;

    if ($count == $mkarea)
     {
     print FILE2 "<META NAME=\"keywords\" CONTENT=\"$FORM{'metakeywords'}\">\n";
     $mkdid = 1;
     $metapassk = 1;
     $didit = 1;
     }

    if ($mkarea == 0 and $mkdid == 0)
     {
     print FILE2 "<META NAME=\"keywords\" CONTENT=\"$FORM{'metakeywords'}\">\n";
     $metapassk = 1;
     $didit = 1;
     }
    }

   if ($FORM{'addmeta'} ne "" and $metapassd == 0)
    {
    $mddid = 0;

    if ($count == $mdarea)
     {
     print FILE2 "<META NAME=\"description\" CONTENT=\"$FORM{'metadescription'}\">\n";
     $mddid = 1;
     $metapassd = 1;
     $didit = 1;
     }
    
    if ($mdarea == 0 and $mddid == 0)
     {
     print FILE2 "<META NAME=\"description\" CONTENT=\"$FORM{'metadescription'}\">\n";
     $metapassd = 1;
     $didit = 1;
     }
    }

   if ($didit == 0)
    {
    print FILE2 "$line";
    }

   $count++;
   }

  close(FILE);
  close(FILE2);
  rename("$nowdir\/$readfile", "$nowdir\/$readfile\.$tmpext");
  rename("$nowdir\/$backup_folder\/$writefile", "$nowdir\/$readfile");
  rename("$nowdir\/$readfile\.$tmpext", "$nowdir\/$backup_folder\/$writefile");
  }
 }

}

}

sub parse_form {

   if ("\U$ENV{'REQUEST_METHOD'}\E" eq 'GET') {
      # Split the name-value pairs
      @pairs = split(/&/, $ENV{'QUERY_STRING'});
   }
   elsif ("\U$ENV{'REQUEST_METHOD'}\E" eq 'POST') {
      # Get the input
      read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
 
      # Split the name-value pairs
      @pairs = split(/&/, $buffer);
   }
   else {
      &error('request_method');
   }

   foreach $pair (@pairs) {
      ($name, $value) = split(/=/, $pair);
 
      $name =~ tr/+/ /;
      $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      $value =~ tr/+/ /;
      $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      # If they try to include server side includes, erase them, so they
      # arent a security risk if the html gets returned.  Another 
      # security hole plugged up.

      $value =~ s/<!--(.|\n)*-->//g;


      # Remove HTML Tags

      if ($allow_html == 0)
       {
       $value =~ s/<([^>]|\n)*>//g;
       }
    
      # Create two associative arrays here.  One is a configuration array
      # which includes all fields that this form recognizes.  The other
      # is for fields which the form does not recognize and will report 
      # back to the user in the html return page and the e-mail message.
      # Also determine required fields.

      if ($FORM{$name}) {
          $FORM{$name} = "$FORM{$name}, $value";
	 }
         elsif ($value ne "") {
            $FORM{$name} = $value;

         }
  }
}


sub error
{
local($msg) = @_;
print "Content-Type: text/html\n\n";
print "<CENTER><H2>$msg</H2></CENTER>\n";
exit;
}

sub login_screen
{

{
print<<END
<HTML><BODY>
<CENTER>
<TITLE>Meta Tag Generator</TITLE>
<H2>Meta Tag Generator</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="go">
<TR><TD COLSPAN=4>Choose the files you would like to add smart tags to</TD></TR>
<TR><TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="htm" CHECKED> htm</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="html" CHECKED> html</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="shtm" CHECKED> shtm</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="shtml" CHECKED> shtml</TD></TR>
<TR><TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="lasso"> lasso</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="pl"> pl</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="cgi"> cgi</TD> <TD><INPUT TYPE=CHECKBOX NAME=ext VALUE="php"> php</TD></TR>
<TR><TD COLSPAN=4><INPUT TYPE=CHECKBOX NAME=addsmart VALUE="YES"> Add Smart Tags?</TD></TR>
<TR><TD COLSPAN=4><INPUT TYPE=CHECKBOX NAME=addmeta VALUE="YES"> Add Meta Tags?</TD></TR>
<TR><TD COLSPAN=2 VALIGN=TOP><B>Meta Keywords:</B></TD> <TD COLSPAN=2><INPUT NAME=metakeywords SIZE=40><BR><I>Separate keywords with a comma</I></TD></TR>
<TR><TD COLSPAN=2 VALIGN=TOP><B>Meta Description:</B></TD> <TD COLSPAN=2><TEXTAREA NAME=metadescription COLS=30 ROWS=5></TEXTAREA><BR><I>Describe your web site here</I></TD></TR>
<TR><TD COLSPAN=4><INPUT TYPE=CHECKBOX NAME=viewonly VALUE="YES"> <B><I>Only view files, do not convert</I></B></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Start"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}
