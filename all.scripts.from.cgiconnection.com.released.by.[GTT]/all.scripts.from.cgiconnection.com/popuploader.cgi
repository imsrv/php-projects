#!/usr/bin/perl
#Pop Uploader
#Provided by CGI Connection
#http://www.CGIConnection.com
$| = 1;

srand();

use CGI;
$query = new CGI;
$query->import_names();

#The entire URL to the popuploader.cgi script on your server
#Eg. http://www.yourserver.com/cgi-bin/popuploader.cgi
$cgi_url = "http://!CGIURL!/popuploader.cgi";

#Temporary directory to store files (CHMOD directory to 777)
#Eg. /path/to/save/uploads/
$tmp_dir = "!SAVEDIR!/";

# Username to login to administration section
$username = "!USERNAME!";

# Password to login to administration section
$password = "!PASSWORD!";

# DO NOT EDIT BELOW THIS LINE
############################################

$width = $Q::width;
$height = $Q::height;
$background = $Q::background;
$background2 = $Q::background2;
$mode = $Q::mode;
$area = $Q::area;
$datafile = $Q::datafile;
$description = $Q::description;
$ext = "pup";
$lock_name = "$datafile\.lock";

if ($width < 400)
 {
 $width = 400;
 }

if ($height < 100)
 {
 $height = 100;
 }

$locks = $tmp_dir;

if ($area eq "download")
 {
 &download_file;
 exit;
 }

print "Content-type: text/html\n\n";

if ($area eq "login")
 {
 &login_screen;
 exit;
 }

if ($area eq "login2")
 {
 &show_files;
 exit;
 }

if ($area eq "login3")
 {
 &read_file;
 exit;
 }

if ($area eq "save")
 {
 &save_file;
 exit;
 }

if ($area eq "upload")
 {
 ($fsize, $fname) = &upload_file;

 if ($fsize == 0)
  {
  print "<SCRIPT>alert('$fname did not upload'); history.back(-1);</SCRIPT>\n";
  }
  else
  {
  &add_description("$fname");
  print "<SCRIPT>alert('$fname uploaded successfully with $fsize bytes'); history.back(-1);</SCRIPT>\n";
  }

 exit;
 }

if ($datafile eq "")
 {
 print "alert('You must specify a data filename');\n";
 exit;
 }

if ($area eq "showfiles")
 {
 print "document.write('<TABLE BORDER=1 WIDTH=$width CELLPADDING=0 CELLSPACING=0>');\n";
 open(FILE, "<$tmp_dir$datafile\.$ext");

 $line = <FILE>;
 chop($line);

 until(eof(FILE))
  {
  if ($line eq "<!--FILE-->")
   {
   $line = <FILE>;
   chop($line);

   $fsize = -s "$tmp_dir$line";
   $new_number = &commify("$fsize");

   print "document.write('<TR><TD BGCOLOR=$background><A HREF=\"$cgi_url?area=download&filename=$line\">$line</A> [$new_number bytes]</TD></TR>');\n";
   print "document.write('<TR><TD BGCOLOR=$background2>";

   until(eof(FILE) or $line eq "<!--FILE-->")
    {
    $line = <FILE>;
    chop($line);
    
    if ($line ne "<!--FILE-->")
     {
     $line =~ s/\n/<BR>/g;
     $line =~ s/\cM/<BR>/g;
     $line =~ s/\'/\\\'/g;

     print "$line";
     }
    }

   print "</TD></TR>');\n";
   }
  }

 close(FILE);
 print "document.write('</TABLE>');\n";
 exit;
 }

if ($mode == 0)
 {
 if ($area eq "")
  {
  &show_popscript;
  }
 
 if ($area eq "screen")
  {
  &show_screen;
  }
 }
 else
 {
 &show_static_screen;
 }

exit;

sub lock
{
$lock_timer = 0;
$lock_timer_stop = 0;
$lock_passed = 0;

while ($lock_timer_stop < 1)
 {
 for ($locka = 0; $locka < 10; $locka++)
  {
  if (not -e "$locks$lock_name")
   {
   $lock_timer_stop = 1;
   }
   else
   {
   $lock_timer_stop = 0;
   }
  }

 if ($lock_timer_stop == 1)
  {
  open (LOCKIT, ">$locks$lock_name");
  print LOCKIT "LOCKED\n";
  close (LOCKIT);
  }
  else
  {
  $idle_max = 30;
  splice(@lock_info, 0);
  @lock_info=stat("$locks$lock_name");
  ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks)=@lock_info;

  $id_time = time() - $lm;

  if ($id_time > $idle_max and $lm > 0)
   {
   $lock_passed = 1;
   unlink ("$locks$lock_name");
   }

  select(undef,undef,undef,0.01);
  $lock_timer++;
  }
 }

}

sub unlock
{
unlink ("$locks$lock_name");
}

sub show_popscript
{
$height2 = $height + 100;

{
print<<END
document.onkeypress = function (evt) {
  var r = '';

  if (document.all) {
    r += event.shiftKey ? 'SHIFT' : '';
    r += event.keyCode;
  }
  else if (document.getElementById) {
    r += evt.shiftKey ? 'SHIFT' : '';
    r += evt.charCode;
  }
  else if (document.layers) {
    r += evt.modifiers & Event.SHIFT_MASK ? 'SHIFT' : '';
    r += evt.which;
  }

  if (r == 'SHIFT85' || r == '85')
   {
   var IChatWindow;
   window.open('$cgi_url?area=screen&mode=$mode&width=$width&height=$height&background=$background&datafile=$datafile',IChatWindow++,'width=$width,height=$height2,scrollbars=yes');
   }

  return true;
}

END
}
   
}

sub show_screen
{

{
print <<END
<HTML><TITLE>Pop Uploader</TITLE><BODY BGCOLOR="$background">
<FORM METHOD=POST ACTION="$cgi_url" enctype="multipart/form-data">
<TABLE BORDER=1 CELLSPACING=0 CELLPADDING=0 WIDTH=$width HEIGHT=$height>
<INPUT TYPE=HIDDEN NAME=area VALUE="upload">
<INPUT TYPE=HIDDEN NAME=datafile VALUE="$datafile">
<TR><TD BGCOLOR=$background><B>Filename:</B> <INPUT TYPE=FILE NAME=filename></TD></TR>
<TR><TD BGCOLOR=$background><B>Description:</B> <TEXTAREA NAME=description COLS=40 ROWS=4></TEXTAREA> <INPUT TYPE=submit NAME=submit VALUE="Upload"></TD></TR>
</FORM></BODY></HTML>
END
}

}

sub show_static_screen
{

{
print <<END
document.write('<HTML><TITLE>Pop Uploader</TITLE><BODY>');
document.write('<FORM METHOD=POST ACTION="$cgi_url" enctype="multipart/form-data">');
document.write('<TABLE BORDER=1 CELLSPACING=0 CELLPADDING=0 WIDTH=$width HEIGHT=$height>');
document.write('<INPUT TYPE=HIDDEN NAME=area VALUE="upload">');
document.write('<INPUT TYPE=HIDDEN NAME=datafile VALUE="$datafile">');
document.write('<TR><TD BGCOLOR=$background><B>Filename:</B> <INPUT TYPE=FILE NAME=filename></TD></TR>');
document.write('<TR><TD BGCOLOR=$background><B>Description:</B> <TEXTAREA NAME=description COLS=40 ROWS=4></TEXTAREA> <INPUT TYPE=submit NAME=submit VALUE="Upload"></TD></TR>');
document.write('</TABLE>');
document.write('</FORM></BODY></HTML>');
END
}

}

sub upload_file
{
my $fsize = 0;
my $filename1 = $query->param('filename');      # Filename on client computer

# Get upload filename
$tmpfilen1 = rindex($filename1, "\\");
$tmpfilen2 = rindex($filename1, "/");

if ($tmpfilen2 > $tmpfilen1)
 {
 $tmpfilen1 = $tmpfilen2;
 }

$tmpfilen1++;
my $real_name = substr ($filename1, $tmpfilen1);
$real_name =~ s/[\\\/!@#\$\%^&*()+=|<>;:`',\"?\[\]\{\} ]//g;

my $tempname = "$tmp_dir$real_name";

if ($real_name eq "")
 {
 print "<SCRIPT>alert('You must specify a filename'); history.back(-1);</SCRIPT>\n";
 exit;
 }

if (-e "$tempname")
 {
 print "<SCRIPT>alert('$real_name already exists'); history.back(-1);</SCRIPT>\n";
 exit;
 }

open(FILEUP, ">$tempname");

$syllabus = $query->param('filename');

while($bytesread=read($syllabus, $buffer, 4096))
 {
 print FILEUP $buffer;
 }

close(FILEUP);

$fsize = -s "$tempname";

if ($fsize == 0)
 {
 unlink("$tempname");
 }

return("$fsize", "$real_name");
}

sub add_description
{
my ($fname) = @_[0];

&lock;
open(FILE, ">>$tmp_dir$datafile\.$ext");
print FILE "<!--FILE-->\n";
print FILE "$fname\n";
print FILE "$description\n";
close(FILE);
&unlock;
}

sub download_file
{
splice(@fileinfo, 0);

my $filename = $Q::filename;
my $tempname = "$tmp_dir$filename";
my @fileinfo = stat("$tempname");

my ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size,$la,$lm,$slc,$obs,$blocks) = @fileinfo;

if ($filename eq "" or $filename eq "." or $filename eq "..")
 {
 print "Content-type: text/html\n\n";
 print "<HTML><BODY>\n";
 print "You must specify a filename to download\n";
 print "</BODY></HTML>\n";
 exit;
 }

print "Content-length: $size\n";
print "Content-type: application/octect-stream\n";
print "Content-disposition: attachment;filename=$filename\n\n";

my $dl = 0, $totalread = 0, $btr = 4096;

open (DL, "<$tempname");

until ($dl == 1)
 {
 $read = "";

 if ($totalread >= $size)
  {
  $btr = $totalread - $size;
  $dl = 1;
  }

 sysread (DL, $read, $btr);
 print "$read";

 $totalread = $totalread + $btr;
 }

close(DL);
}


exit;

sub commify {
local $_  = shift;
1 while s/^(-?\d+)(\d{3})/$1,$2/;
return $_;
}

sub login_screen
{

{
print<<END
<HTML>
<TITLE>Pop Uploader</TITLE>
<BODY>
<CENTER>
<H2>Pop Uploader</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$cgi_url">
<INPUT TYPE=hidden NAME=area VALUE="login2">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}

sub show_files
{
if ($username ne $Q::username)
 {
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $Q::password)
 {
 print "Invalid Password!\n";
 exit;
 }

opendir(FILES, "$tmp_dir");
@all_files = readdir(FILES);
closedir(FILES);

@all_files = sort(@all_files);

print "<HTML><BODY>";
print "<CENTER><H2>Choose file to edit</H2>\n";

for ($j = 2; $j < @all_files; $j++)
 {
 $ridx = rindex(@all_files[$j], ".");
 
 if (substr(@all_files[$j], ($ridx + 1)) eq "$ext")
  {
  $new_name = substr(@all_files[$j], 0, $ridx);
  print "<A HREF=\"$cgi_url?area=login3&username=$Q::username&password=$Q::password&datafile=$new_name\">$new_name</A><BR>\n";
  }
 }

print "</CENTER></BODY></HTML>\n";
}

sub read_file
{
if ($username ne $Q::username)
 {
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $Q::password)
 {
 print "Invalid Password!\n";
 exit;
 }

my $count = 0;
print "<HTML><BODY><TITLE>Pop Uploader</TITLE>\n";
print "<CENTER><H2>Pop Uploader</H2>\n";
print "<FORM METHOD=POST ACTION=\"$cgi_url\">\n";
print "<INPUT TYPE=HIDDEN NAME=area VALUE=\"save\">\n";
print "<INPUT TYPE=HIDDEN NAME=datafile VALUE=\"$datafile\">\n";
print "<INPUT TYPE=HIDDEN NAME=username VALUE=\"$username\">\n";
print "<INPUT TYPE=HIDDEN NAME=password VALUE=\"$password\">\n";
print "<TABLE BORDER=0>\n";
print "<TR><TD><B>Delete?</B></TD> <TD></TD></TR>\n";

&lock;
open(FILE, "<$tmp_dir$datafile\.$ext");

$line = <FILE>;
chop($line);

until(eof(FILE))
 {
 if ($line eq "<!--FILE-->")
  {
  $line = <FILE>;
  chop($line);

  $fsize = -s "$tmp_dir$line";
  $new_number = &commify("$fsize");

  print "<TR><TD><INPUT TYPE=CHECKBOX NAME=delete$count VALUE=\"$line\"></TD> <TD><INPUT TYPE=HIDDEN NAME=originalname$count VALUE=\"$line\"><INPUT NAME=filename$count VALUE=\"$line\"> [$new_number bytes]</TD></TR>\n";
  print "<TR><TD></TD> <TD><TEXTAREA NAME=\"description$count\" COLS=40 ROWS=3>";

  until(eof(FILE) or $line eq "<!--FILE-->")
   {
   $line = <FILE>;
   chop($line);
    
   if ($line ne "<!--FILE-->")
    {
    print "$line";
    }
   }

  print "</TEXTAREA></TD></TR>\n";
  $count++;
  }
 }

close(FILE);
&unlock;
print "</TABLE><BR><INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=\"Update\"></FORM></CENTER></BODY></HTML>\n";
}

sub save_file
{
if ($username ne $Q::username)
 {
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $Q::password)
 {
 print "Invalid Password!\n";
 exit;
 }

my $ext2 = "tmp";
my $count = 0;
my $finished = 0;

&lock;
open(FILE, "<$tmp_dir$datafile\.$ext");
open(FILE2, ">$tmp_dir$datafile\.$ext$ext2");

until(eof(FILE))
 {
 $rdelete = "delete$count";
 $rdelete2 = $query->param($rdelete);
 $didfile = 0;

 $line = <FILE>;
 chop($line);

 if ($line eq "<!--FILE-->")
  {
  if ($rdelete2 eq "")
   {
   print FILE2 "<!--FILE-->\n";

   $rfilename = "filename$count";
   $rfilename2 = $query->param($rfilename);

   $roriginalname = "originalname$count";
   $roriginalname2 = $query->param($roriginalname);

   $rdescription = "description$count";
   $rdescription2 = $query->param($rdescription);

   if ($roriginalname2 ne $rfilename2 and $rfilename2 ne "" and not -e "$tmp_dir$rfilename2")
    {
    print FILE2 "$rfilename2\n";
    rename("$tmp_dir$roriginalname2", "$tmp_dir$rfilename2");
    }
    else
    {
    print FILE2 "$roriginalname2\n";
    }

   print FILE2 "$rdescription2\n";
   $count++;
   }
   else
   {
   $count++;
   print "Deleting $rdelete2<BR>\n";
   unlink("$tmp_dir$rdelete2");
   }
  }
 
 }

close(FILE);
close(FILE2);
unlink("$tmp_dir$datafile\.$ext");
rename("$tmp_dir$datafile\.$ext$ext2", "$tmp_dir$datafile\.$ext");
&unlock;

print "Update complete.<BR><BR>\n";
print "<A HREF=\"$cgi_url?area=login2&username=$Q::username&password=$Q::password\">Menu</A><BR>\n";
}
