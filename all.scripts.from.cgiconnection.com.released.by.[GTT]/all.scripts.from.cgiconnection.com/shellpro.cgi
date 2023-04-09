#!/usr/bin/perl
#WebShell PRO
#This script is intended to help those who do not
#have telnet access to install software onto their
#servers.

#The CGI Connection takes no responsibility for
#the use or actions of this script.  Install and
#use at your own risk.
#http://www.CGIConnection.com

$| = 1;
srand();

use CGI;
$query = new CGI;
$query->import_names();

&check_browser;

#################################################
#Change only values between these lines

#Username and password to login to the shell
$username = "!USERNAME!";
$password = "!PASSWORD!";

#A temporary directory that can be read and written to (CHMOD to 777)
#Eg. /tmp/
$locks = "!TMPDIR!/";

#Background Color
$bgcolor = "#FFFCCC";

# Send Keep alive message to browser every n seconds (0 = off)
$keep_alive = 10;

#Relative path to your cgi-bin directory
#Most will not have to change this
$cgi_location = "$ENV{'SCRIPT_NAME'}";


#################################################
$area = $Q::area;
$session = $Q::session;
$command = $Q::command;
$command_file = "shell$session\.tmp";

if ($area eq "")
 {
 $session = int(rand(1000000));
 print "Content-type: text/html\n\n";

 if ("\U$username\E" ne "\U$Q::username\E" or "\U$password\E" ne "\U$Q::password\E" or $Q::username eq "" or $Q::password eq "")
  {
  &show_login;
  exit;
  }

 &show_frames;
 exit;
 }

if ($area eq "upload")
 {
 &upload_file;
 exit;
 }

if ($area eq "download")
 {
 $dl_name = $Q::filename;
 $directory = $Q::directory;
 &download;
 exit;
 }

if ($area eq "command")
 {
 print "Content-type: text/html\n\n";

 if ("\U$username\E" ne "\U$Q::username\E" or "\U$password\E" ne "\U$Q::password\E" or $Q::username eq "" or $Q::password eq "")
  {
  &show_login;
  exit;
  }

 print "<HTML><BODY>\n";

 $lock_name = "shell$session\.lock";
 &lock;

 open(FILE, ">>$locks$command_file");
 print FILE "$command\n";
 close(FILE);

 &unlock;

 print "</BODY></HTML>\n";
 exit;
 }

if ($area eq "type")
 {
 print "Content-type: text/html\n\n";
 &show_jscript;
 print "<HTML><BODY BGCOLOR=$bgcolor>\n";
 print "<FORM NAME=\"type\" ACTION=\"$cgi_location\" target=\"empty\" onSubmit='return submit_form();'>\n";
 print "<INPUT TYPE=HIDDEN NAME=area VALUE=\"command\">\n";
 print "<INPUT TYPE=HIDDEN NAME=username VALUE=\"$Q::username\">\n";
 print "<INPUT TYPE=HIDDEN NAME=password VALUE=\"$Q::password\">\n";
 print "<INPUT TYPE=HIDDEN NAME=session VALUE=\"$session\">\n";
 print "<INPUT TYPE=HIDDEN NAME=command>\n";
 print "<INPUT NAME=command2>\n";
 print "<INPUT TYPE=SUBMIT NAME=submit VALUE=\"Enter\">\n";
 print "<INPUT TYPE=BUTTON NAME=dir VALUE=\"Directory\" onClick=\"document.type.command2.value='/dir';document.type.submit.click();\">\n";
 print "<INPUT TYPE=BUTTON NAME=view VALUE=\"View\" onClick=\"document.type.command2.value='/view';document.type.submit.click();\">\n";
 print "<INPUT TYPE=BUTTON NAME=upload VALUE=\"Upload\" onClick=\"document.type.command2.value='/upload';document.type.submit.click();\">\n";
 print "<INPUT TYPE=BUTTON NAME=download VALUE=\"Download\" onClick=\"document.type.command2.value='/download';document.type.submit.click();\">\n";
 print "<INPUT TYPE=BUTTON NAME=help VALUE=\"Help\" onClick=\"document.type.command2.value='/help';document.type.submit.click();\">\n";
 print "<INPUT TYPE=BUTTON NAME=exit VALUE=\"Exit\" onClick=\"document.type.command2.value='exit';document.type.submit.click();\">\n";
 print "</FORM></BODY></HTML>\n";

 exit;
 }

if ($area eq "screen")
 {
 print "Content-type: multipart/mixed;boundary=\"boundary\"\n\n";

 if ($browser == 1)
  {
  print "\n--boundary\n";
  print "Content-type: text/html\n\n";
  }

 if ("\U$username\E" ne "\U$Q::username\E" or "\U$password\E" ne "\U$Q::password\E" or $Q::username eq "" or $Q::password eq "")
  {
  &show_login;
  exit;
  }

 print "<HTML><BODY BGCOLOR=\"$bgcolor\">";
 &show_start;

 $ka_count = time();

 $cd_dir = $ENV{'DOCUMENT_ROOT'};
 chdir("$cd_dir");

 print "Current directory: $cd_dir<BR>\n";
 print "Type <i>/help</i> for command list\n";
 &scroll;

 until($line eq "exit")
  {
  if (time() > $ka_count and $keep_alive > 0)
   {
   $ka_count = time() + $keep_alive;
   print "<!--KEEP ALIVE-->\n";
   }
  
  if (-e "$locks$command_file")
   {
   $lock_name = "shell$session\.lock";
   &lock;

   open(FILE, "<$locks$command_file");

   until(eof(FILE))
    {
    $line = <FILE>;
    chop($line);
    
    if (substr($line, 0, 3) eq "!C!")
     {
     $show = 1;
     print substr ($line, 3);
     &scroll;
     }

    if (substr("\L$line\E", 0, 3) eq "cd ")
     {
     $show = 1;
     $cd_dir2 = substr($line, 3);

     $cdval = chdir("$cd_dir2") or print "Cannot change directory to $cd_dir2\n";

     if ($cdval == 1)
      {
      if (substr($cd_dir2, 0, 1) eq "/")
       {
       $cd_dir = $cd_dir2;
       }
       else
       {
       $cd_dir = "$cd_dir\/$cd_dir2";
       }
      }
     
     if (substr($cd_dir, (length($cd_dir) - 1)) eq "/" and $cd_dir ne "/")
      {
      $cd_dir = substr($cd_dir, 0, (length($cd_dir) - 1));
      }

     if ($cdval)
      {
      print "Changed directory to: $cd_dir\n";
      }

     &scroll;
     }

    splice(@tmp_line, 0);
    @tmp_line = split(/ /, $line);
    
    if (substr(@tmp_line[0], 0, 1) eq "/")
     {
     if ("\L$line\E" eq "/currdir")
      {
      $show = 1;
      print "Current directory: $cd_dir\n";
      &scroll;
      }
    
     if ("\L$line\E" eq "/help")
      {
      $show = 1;
      &show_help;
      &scroll;
      }

     if ("\L@tmp_line[0]\E" eq "/dir" or "\L@tmp_line[0]\E" eq "/ls")
      {
      $show = 1;
      splice(@all_data, 0);
      opendir(FILE, "$cd_dir");
      @all_data = readdir(FILE);
      closedir(FILE);
  
      for($j = 2; $j < @all_data; $j++)
       {
       if (-f "$cd_dir\/@all_data[$j]")
        {
        print "@all_data[$j]\n";
        }
        else
        {
        print "<A HREF=\"javascript:onClick=parent.type.document.type.command2.value='cd $cd_dir\/@all_data[$j]';parent.type.document.type.submit.click();parent.type.document.type.command2.value='';parent.type.document.type.command2.focus();\" target=\"empty\">@all_data[$j]</A>\n";
        }

       &scroll;
       }
      }

     if ("\L@tmp_line[0]\E" eq "/view")
      {
      $dl_name = @tmp_line[1];
      $show = 1;

      if ($dl_name eq "")
       {
       $cf = 0;
       splice(@all_data, 0);
       opendir(FILE, "$cd_dir");
       @all_data = readdir(FILE);
       closedir(FILE);
       
       print "<B>Files in this directory:</B>\n";
       &scroll;
  
       for($j = 2; $j < @all_data; $j++)
        {
        if (-f "$cd_dir\/@all_data[$j]")
         {
         splice(@fileinfo, 0);
         @fileinfo=stat("$cd_dir\/@all_data[$j]");
         ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @fileinfo;

         print "<A HREF=\"javascript:onClick=parent.type.document.type.command2.value='/view @all_data[$j]';parent.type.document.type.submit.click();parent.type.document.type.command2.value='';parent.type.document.type.command2.focus();\" target=\"empty\">@all_data[$j]</A> $size2 bytes\n";
         &scroll;
         $cf++;
         }
        }

       if ($cf == 0)
        {
        print "<B>No files in this directory</B>\n";
        &scroll;
        }
       }
       else
       {
       if (not -e "$cd_dir\/$dl_name")
        {
        print "<i>$dl_name</i> does not exist in <i>$cd_dir</i>\n";
        &scroll;
        }
        else
        {
        open(VIEWIT, "<$cd_dir\/$dl_name");

        until(eof(VIEWIT))
         {
         $viewit = <VIEWIT>;
         chop($viewit);

         $viewit =~ s/<([\w\d\D\s]*)>/&lt;\1&gt;/g;

         print "$viewit\n";
         &scroll;
         }

        close(VIEWIT);
        }
       }
      }
  
     if ("\L@tmp_line[0]\E" eq "/upload")
      {
      $show = 1;
      &upload_screen;
      }       
 
     if ("\L@tmp_line[0]\E" eq "/download")
      {
      $dl_name = @tmp_line[1];
      $show = 1;
      
      if ($dl_name eq "")
       {
       $cf = 0;
       splice(@all_data, 0);
       opendir(FILE, "$cd_dir");
       @all_data = readdir(FILE);
       closedir(FILE);
       
       print "<B>Files in this directory:</B>\n";
       &scroll;
  
       for($j = 2; $j < @all_data; $j++)
        {
        if (-f "$cd_dir\/@all_data[$j]")
         {
         splice(@fileinfo, 0);
         @fileinfo=stat("$cd_dir\/@all_data[$j]");
         ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @fileinfo;

         print "<A HREF=\"javascript:onClick=parent.type.document.type.command2.value='/download @all_data[$j]';parent.type.document.type.submit.click();parent.type.document.type.command2.value='';parent.type.document.type.command2.focus();\" target=\"empty\">@all_data[$j]</A> $size2 bytes\n";
         &scroll;
         $cf++;
         }
        }

       if ($cf == 0)
        {
        print "<B>No files in this directory</B>\n";
        &scroll;
        }
       }
       elsif (not -e "$cd_dir\/$dl_name")
       {
       print "<i>$dl_name</i> does not exist in <i>$cd_dir</i>\n";
       }
       else
       {
       print "<SCRIPT>window.open('$cgi_location?area=download&directory=$cd_dir&filename=$dl_name&session=$session');</SCRIPT>\n";
       }

      &scroll;
      }
     
     if ($show == 0)
      {
      print "Invalid command!\n";
      &scroll;
      }
     }

    if ($line ne "exit" and $show == 0)
     {
     print "<PRE>";
     print `$line 2>&1`;
     print "</PRE>";
     &scroll;
     $command_status = $?;
     }

    $show = 0;
    }

   close(FILE);
   unlink("$locks$command_file");
   &unlock;
   }
  }

 print "Connection closed\n";
 &scroll;
 print "</BODY></HTML>\n";
 print "<SCRIPT>top.location.href='$cgi_location';</SCRIPT>";
 exit;
 }

exit;

sub check_browser
{
$browser = 0;  #MSIE / AOL
if ($ENV{'HTTP_USER_AGENT'} =~ /Mozilla/i)
 {
 if ($ENV{'HTTP_USER_AGENT'} !~ /MSIE/i and $ENV{'HTTP_USER_AGENT'} !~ /opera/i)
  {
  $browser = 1; #Netscape
  }
 }
}

sub show_frames
{
print <<END
<HTML><TITLE>WebShell PRO</TITLE>
<FRAMESET ROWS=*,60,1 FRAMEBORDER=1 FRAMESPACING=0 BORDER=1>
<FRAME NAME="screen" SRC="$cgi_location\?area=screen&session=$session&username=$Q::username&password=$Q::password" SCROLLING="auto">
<FRAME NAME="type" SRC="$cgi_location\?area=type&session=$session&username=$Q::username&password=$Q::password" SCROLLING="auto">
<FRAME NAME="empty" SRC="" SCROLLING="auto">
</FRAMESET>
</HTML>
END
}

sub show_login
{
print<<END
<HTML>
<TITLE>WebShell Pro</TITLE>

<BODY BGCOLOR="$bgcolor">
<CENTER>
<H2>Web Shell Pro</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$cgi_location">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT NAME=password TYPE=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit VALUE="Login"></TD></TR>
</FORM>
</TABLE>

</CENTER>
</BODY></HTML>
END
}


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

  select(undef,undef,undef,0.05);
  $lock_timer++;
  }
 }
}

sub unlock
{
unlink ("$locks$lock_name");
}

sub show_jscript
{
print <<END
<HEAD>
<script>

function submit_form()
 {
 document.type.command.value = document.type.command2.value;
 document.type.command2.value = '';
 return true;
 }

</script>
</HEAD>
END
}

sub show_start
{
$server_type = `uname -a`;

for ($j = 0; $j < 50; $j++)
 {
 print "<!-- FORCE OUTPUT -->\n";
 }

{
print<<END
<PRE>
You are now logged into your server:
[ $^O ] $server_type

Type 'exit' to close the connection.
</PRE>
END
}

}

sub scroll
{
print "<BR><SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";
}

sub download
{
splice(@fileinfo, 0);

$tempname = "$directory\/$dl_name";
@fileinfo=stat("$tempname");
($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @fileinfo;

print "Content-length: $size2\n";
print "Content-type: application/octect-stream\n";
print "Content-disposition: attachment;filename=$dl_name\n\n";

$dl = 0;
$totalread = 0;
$btr = 4096;
open (DL, "<$tempname");

until ($dl == 1)
 {
 $read = "";

 if ($totalread >= $size2)
  {
  $btr = $totalread - $size2;
  $dl = 1;
  }

 sysread (DL, $read, $btr);
 print "$read";

 $totalread = $totalread + $btr;
 }

close(DL);
}

sub show_help
{
print <<END
<BR><BR>

<B>Valid Commands:</B>

<BR><BR>

<i>/currdir</i> displays current directory
<BR>
<i>cd directory</i> changes to another directory
<BR>
<i>/view filename</i> displays a file on the screen
<BR>
<i>/upload</i> send a file to the current directory
<BR>
<i>/download filename</i> download the file from current directory
<BR>
<i>/dir</i> or <i>/ls</i> Show HTML formatted directory (Clickable)
<BR>

<i>/help</i> displays this help screen

<BR><BR>
End of help
<BR>
END
}

sub upload_screen
{

{
print<<END
<SCRIPT>
var num;
exwin = window.open("",num,"width=400,height=100");
exwin.document.writeln('<HTML><TITLE>WebShell PRO</TITLE><BODY BGCOLOR="$bgcolor">');
exwin.document.writeln('<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}" enctype="multipart/form-data">');
exwin.document.writeln('<INPUT TYPE=HIDDEN NAME=area VALUE="upload">');
exwin.document.writeln('<INPUT TYPE=HIDDEN NAME=session VALUE="$session">');
exwin.document.writeln('<INPUT TYPE=HIDDEN NAME=currdir VALUE="$cd_dir">');
exwin.document.writeln('<B>Filename:</B> <INPUT TYPE=FILE NAME=filename>');
exwin.document.writeln('<INPUT TYPE=submit NAME=submit VALUE="Upload">');
exwin.document.writeln('</FORM></BODY></HTML>');
</SCRIPT>
END
}

}

sub upload_file
{
print "Content-type: text/html\n\n";
print "<HTML><BODY>\n";

$filename1 = $Q::filename;      # Filename on client computer
$write_dir = $Q::currdir;

# Get upload filename
$tmpfilen1 = rindex($filename1, "\\");
$tmpfilen2 = rindex($filename1, "/");

if ($tmpfilen2 > $tmpfilen1)
 { 
 $tmpfilen1 = $tmpfilen2;
 }

$tmpfilen1++;
$sfname = substr ($filename1, $tmpfilen1);
$sfname =~ s/[\\\/!@#\$\%^&*()+=|<>;:`',\"?\[\]\{\} ]//g;

if ($sfname ne "")
 {
 $tempname = "$write_dir\/$sfname";
 open(FILE, ">$tempname");

 $syllabus = $query->param('filename');

 while($bytesread=read($syllabus, $buffer, 4096))
  {
  print FILE $buffer;
  }

 close(FILE);
 }

if (-s "$tempname" > 0)
 {
 $lock_name = "shell$session\.lock";
 &lock;

 open(FILE2, ">$locks$command_file");
 print FILE2 "!C! Successfully uploaded <i>$sfname</i> to <i>$write_dir</i>\n";
 close(FILE2);

 &unlock; 
 }
 else
 {
 $lock_name = "shell$session\.lock";
 &lock;

 open(FILE2, ">$locks$command_file");
 print FILE2 "!C! <i>$sfname</i> did not upload to <i>$write_dir</i>\n";
 close(FILE2);

 &unlock; 
 }

print "Done</BODY></HTML>\n";
}
