#!/usr/bin/perl
# Web Hog
# Provided by CGI Connection
# http://www.cgiconnection.com
$| = 1;

# Where to start searching for files
# Eg. /path/to/your/files
$save_dir = "!SAVEDIR!";

# Default font value
$font = "Arial";

# Administrator username and password
$username = "!USERNAME!";
$password = "!PASSWORD!";

# Show size of file in bold when it is equal or greater than x megabytes
$alert_size = 5;

# Default sorting method.  Specify: date, name, or size
$default_sort = "name";

############################################
# DO NOT EDIT BELOW THIS LINE
############################################

srand();
$rand_num = int(rand(1000000));

&parse_form;
$area = $FORM{'area'};
$dir = $FORM{'dir'};
$max = $FORM{'max'};
$file = $FORM{'file'};
$sort = "\L$FORM{'sort'}\E";
$prev = $FORM{'prev'};
$alert_size = $alert_size * 1024000;

$sort = $default_sort if $sort eq "";

print "Content-type: text/html\n\n";

if ($area eq "")
 {
 &login_screen;
 exit;
 }

if ($area eq "login2")
 {
 &check_login;
 &show_main($dir);
 exit;
 }

if ($area eq "view")
 {
 &check_login;
 &get_file;
 exit;
 }

if ($area eq "delete")
 {
 &check_login;

 if ($dir eq "")
  {
  $new_dir = "$save_dir";
  }
  else
  {
  $new_dir = "$save_dir\/$dir";
  }

 for ($j = 0; $j < $max; $j++)
  {
  $tempfile = "file$j";
  $tempfile2 = $FORM{$tempfile};

  if ($tempfile2 ne "")
   {
   $stats = unlink("$new_dir\/$tempfile2");

   if ($stats == 0)
    {
    print "Could not delete $tempfile2<BR>\n";
    }
    else
    {
    print "$tempfile2 was deleted<BR>\n";
    }
   }
  }

 &show_main($dir);
 exit;
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
    
      # Create two associative arrays here.  One is a configuration array
      # which includes all fields that this form recognizes.  The other
      # is for fields which the form does not recognize and will report 
      # back to the user in the html return page and the e-mail message.
      # Also determine required fields.

      if ($FORM{$name} && ($value)) {
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
<HTML>
<TITLE>Web Hog</TITLE>
<BODY>
<FONT FACE="$font"><CENTER>
<H2>Web Hog</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="login2">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE>

<BR>
Provided by <A HREF="http://www.cgiconnection.com">CGI Connection</A>
</CENTER></FONT>
</BODY></HTML>
END
}

}

sub check_login
{
if ($username ne $FORM{'username'})
 {
 print "<HTML><BODY>Invalid Username.</BODY></HTML>\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "<HTML><BODY>Invalid Password.</BODY></HTML>\n";
 exit;
 }
}

sub get_file
{
my $dl = 0;
my $totalread = 0;
my $btr = 4096;
my $size;
my $tempname;

if ($dir eq "")
 {
 $new_dir = "$save_dir";
 }
 else
 {
 $new_dir = "$save_dir\/$dir";
 }

$tempname = "$new_dir\/$file";

if (not -r "$tempname")
 {
 print "<HTML><TITLE>Web Hog</TITLE><BODY>\n";
 print "Sorry, $file cannot be read";
 print "</BODY></HTML>\n";
 exit;
 }

splice(@file_info, 0);
@file_info = stat("$tempname");
my ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size,$la,$lm,$slc,$obs,$blocks) = @file_info;

open (DL, "<$new_dir\/$file");
binmode(DL);

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

sub check_dir
{
my ($save_dir, $dir) = @_;
my ($backok);

if (not -e "$save_dir\/$dir")
 {
 $backok = mkdir("$save_dir\/$dir", 0777);

 if ($backok == 0)
  {
  print "Content-type: text/html\n\n";
  print "<SCRIPT>alert('$save_dir\/$dir could not be created'); history.back(-1);</SCRIPT>";
  exit;
  }
 }

if (not -w "$save_dir\/$dir")
 {
 print "Content-type: text/html\n\n";
 print "<SCRIPT>alert('Cannot write to $save_dir\/$dir'); history.back(-1);</SCRIPT>";
 exit;
 }
}

sub lock
{
my $lock_name = @_[0];
my $locks = "$save_dir\/";
my $lock_timer = 0;
my $lock_timer_stop = 0;
my $lock_passed = 0;
my (@lock_info);

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
  @lock_info = stat("$locks$lock_name");
  ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @lock_info;

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
my $locks = "$save_dir\/";
my $lock_name = @_[0];
unlink ("$locks$lock_name");
}

sub date_info
{
my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(@_[0]);
my ($month);

   if ($sec < 10) {
   $sec = "0$sec";
   }
   if ($min < 10) {
      $min = "0$min";
   }
   if ($hour < 10) {
      $hour = "0$hour";
   }
   $mon++;
   if ($mon < 10) {
   $month = "0$mon";
   }
   else
   {
   $month = "$mon";
   }

   if ($mday < 10)
   {
   $mday = "0$mday";
   }

$year += 1900;
return("$month\-$mday\-$year","$hour\:$min\:$sec");
}

sub show_main
{
my ($dir) = @_[0];

$new_dir = "$save_dir$dir";
$bytes = 0;

splice(@all_files, 0);
opendir(FILES, "$new_dir");
@all_files = readdir(FILES);
closedir(FILES);

splice(@all_files, 0, 2);
@all_files = sort (@all_files);

splice(@files, 0);
splice(@dirs, 0);
splice(@all_dirs, 0);
$fcount = 0;
$dcount = 0;

print "<HTML>\n";

{
print<<END
<SCRIPT>
//function checkAll(theCheck) {
//  theForm = theCheck.form;
//  chk=theCheck.checked;
//  name=theCheck.name;
//  for (i=0;i<theForm.length;i++) {
//     if (theForm.elements[i].type=='checkbox'&&
//         theForm.elements[i].name.indexOf(name)==0) {
//         theForm.elements[i].checked=chk;
//     }
//  }
//}


function checkAll(start, stop, name)
{ 
for (i = start; i < stop; i++) 
{ 
var myChkName = new String(name); 
myChkName += i;
var tmpCheck = document.forms.allfiles[myChkName].checked;
if (tmpCheck == true)
 {
 document.forms.allfiles[myChkName].checked = false;
 }
 else
 {
 document.forms.allfiles[myChkName].checked = true;
 }
} 
} 

</SCRIPT>
END
}

print "<TITLE>Web Hog</TITLE><BODY><FONT FACE=\"$font\"><CENTER><H2>Web Hog</H2>\n";
print "<B>Current folder:</B> $new_dir<BR>\n";
print "<B>Sort by:</B> <A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&sort=date&username=$username&prev=$prev&password=$password&dir=$dir\">Date</A> <A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&sort=name&username=$username&prev=$prev&password=$password&dir=$dir\">Name</A>  <A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&sort=size&username=$username&prev=$prev&password=$password&dir=$dir\">Size</A>\n"; 
print "<FORM NAME=allfiles METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">\n";
print "<INPUT TYPE=HIDDEN NAME=area VALUE=\"delete\">\n";
print "<INPUT TYPE=HIDDEN NAME=dir VALUE=\"$dir\">\n";
print "<INPUT TYPE=HIDDEN NAME=sort VALUE=\"$sort\">\n";
print "<INPUT TYPE=HIDDEN NAME=username VALUE=\"$username\">\n";
print "<INPUT TYPE=HIDDEN NAME=password VALUE=\"$password\">\n";

for ($j = 0; $j < @all_files; $j++)
 {
 if (not -d "$new_dir\/@all_files[$j]")
  {
  splice(@file_info, 0);
  @file_info = stat("$new_dir\/@all_files[$j]");
  ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size,$la,$lm,$slc,$obs,$blocks) = @file_info;

  $bytes = $bytes + $size;
  @new_files[$fcount] = [$lm, @all_files[$j], $size];
  $fcount++;
  }
  else
  {
  splice(@file_info, 0);
  @file_info = stat("$new_dir\/@all_files[$j]");
  ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size,$la,$lm_dir,$slc,$obs,$blocks) = @file_info;

  $sub_bytes = 0;
  $sub_dirs = 0;
  $sub_files = 0;
  splice(@sub_files, 0);
  opendir(FILES, "$new_dir\/@all_files[$j]");
  @sub_files = readdir(FILES);
  closedir(FILES);
  splice(@sub_files, 0, 2);

  for ($x = 0; $x < @sub_files; $x++)
   {
   if (not -d "$new_dir\/@all_files[$j]\/@sub_files[$x]")
    {
    splice(@file_info, 0);
    @file_info = stat("$new_dir\/@all_files[$j]\/@sub_files[$x]");
    ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size,$la,$lm,$slc,$obs,$blocks) = @file_info;
    $sub_bytes = $sub_bytes + $size;
    $sub_files++;
    }
    else
    {
    $sub_dirs++;
    }
   }

  @all_dirs[$dcount] = [$lm_dir, @all_files[$j], $sub_bytes, $sub_files, $sub_dirs];
  $dcount++;
  }
 }


# sort files and directories
splice(@files, 0);

if ($sort eq "size")
 {
 @files = reverse sort{$a->[2] <=> $b->[2]} @new_files;
 @dirs = reverse sort{$a->[2] <=> $b->[2]} @all_dirs;
 }

if ($sort eq "date")
 {
 @files = reverse sort{$a->[0] <=> $b->[0]} @new_files;
 @dirs = reverse sort{$a->[0] <=> $b->[0]} @all_dirs;
 }

if ($sort eq "name")
 {
 @files = sort{$a->[1] cmp $b->[1]} @new_files;
 @dirs = sort{$a->[1] <=> $b->[1]} @all_dirs;
 }

splice(@new_files, 0);
splice(@all_dirs, 0);
$total_files = @files;
$total_files_tmp = $total_files;
$total_folders = @dirs;
$total_files = &commify($total_files);
$total_folders = &commify($total_folders);

print "<INPUT TYPE=HIDDEN NAME=max VALUE=\"$total_files\">\n";
print "<TABLE BORDER=1 WIDTH=60%>\n";


# Display folders / directories
print "<TR><TD><B>Last Modified</B></TD> <TD><B>Folder name</B></TD> <TD><B>Size</B></TD> <TD><B>Files</B></TD> <TD><B>Sub folders</B></TD></TR>\n";

if ($dir ne "")
 {
 print "<TR><TD COLSPAN=5><A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&sort=$sort&username=$username&password=$password&dir=$prev\">Previous folder</A></TD></TR>\n"; 
 }

$folder_size = 0;

for ($j = 0; $j < @dirs; $j++)
 {
 $lm_dir = @dirs[$j]->[0];
 $temp_dir = "@dirs[$j]->[1]";
 $size = @dirs[$j]->[2];
 $sub_files = &commify(@dirs[$j]->[3]);
 $sub_dirs = &commify(@dirs[$j]->[4]);
 $folder_size = $folder_size + $size;

 ($sub_bytes, $total_perc, $new_numbera) = &calc_size($size);
 ($tdate, $ttime) = &date_info($lm_dir);
 print "<TR><TD>$tdate $ttime</TD> <TD><A HREF=\"$ENV{'SCRIPT_NAME'}?area=login2&sort=$sort&username=$username&password=$password&prev=$dir&dir=$dir\/$temp_dir\">$temp_dir</A></TD> <TD>$sub_bytes$new_numbera</TD> <TD>$sub_files</TD> <TD>$sub_dirs</TD></TR>\n"; 
 }

$folder_size = &commify($folder_size);
print "<TR><TD><B>Total folders:</B> $total_folders</TD> <TD COLSPAN=4><B>Bytes:</B> $folder_size</TD></TR>";
print "<TR><TD COLSPAN=5><HR></TD></TR>\n";


# Display files
print "<TR><TD><B>Last Modified</B></TD> <TD><B>Filename</B></TD> <TD><B>Size</B></TD> <TD><B>Used</B></TD> <TD><A HREF=\"javascript:checkAll(0, $total_files_tmp, 'file');\"><B>Del</A></B></TD></TR>\n";

for ($j = 0; $j < @files; $j++)
 {
 $temp_info = @files[$j]->[0];
 $filename = @files[$j]->[1];
 $size = @files[$j]->[2];
 $old_size = $size;

 ($size, $total_perc, $new_numbera) = &calc_size($size, $bytes);
 ($tdate, $ttime) = &date_info($temp_info);

 if ($old_size >= $alert_size)
  {
  $new_number = "<B>$size$new_numbera</B>";
  $new_perc = "<B>$total_perc\%</B>";
  $all_time = "<B>$tdate $ttime</B>";
  }
  else
  {
  $new_perc = "$total_perc\%";
  $new_number = "$size$new_numbera";
  $all_time = "$tdate $ttime";
  }

 print "<TR><TD>$all_time</TD> <TD><A HREF=\"$ENV{'SCRIPT_NAME'}?area=view&username=$username&password=$password&dir=$dir&file=$filename\" target=_blank>$filename</A></TD> <TD>$new_number</TD> <TD>$new_perc</TD> <TD><INPUT TYPE=CHECKBOX NAME=\"file$j\" VALUE=\"$filename\"></TD></TR>\n"; }
 $bytes = &commify($bytes);

 if ($total_files <= 0)
  {
  print "<TR><TD COLSPAN=4><B>No files to display</B></TD></TR>\n";
  }

print "<TR><TD><B>Total files:</B> $total_files</TD> <TD COLSPAN=4><B>Bytes:</B> $bytes</TD></TR>\n";
print "</TABLE><BR><INPUT TYPE=submit NAME=submit VALUE=\"Delete Files\"></FORM></CENTER></FONT></BODY></HTML>\n";
}

sub commify {
local $_  = shift;
1 while s/^(-?\d+)(\d{3})/$1,$2/;
return $_;
}

sub calc_size
{
my $total_perc = 0;
my ($size, $bytes) = @_;
my $new_numbera;

if ($bytes > 0)
 {
 $total_perc = ($size / $bytes) * 100;
 }

$total_perc = sprintf "%.2f", $total_perc;

 if ($size > 0 and $size >= 1024000)
  {
  $size = ($size / 1024) / 1024;
  $size = sprintf "%.2f", $size;
  $new_numbera = "M";
  }
  else
  {
  $size = ($size / 1024);
  $size = int($size);
  $new_numbera = "k";
  }

return($size, $total_perc, $new_numbera);
}
