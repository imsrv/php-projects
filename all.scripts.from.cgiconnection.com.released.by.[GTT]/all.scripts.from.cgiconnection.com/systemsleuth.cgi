#!/usr/bin/perl
# System Sleuth 1.0
# Provided by CGI Connection
# http://www.CGIConnection.com

# Search for this many directories before stopping
$max_directories = 10;

&check_browser;

print "Content-type: multipart/mixed;boundary=\"boundary\"\n\n";

if ($browser == 1)
 {
 print "\n--boundary\n";
 print "Content-type: text/html\n\n";
 }

print "<HTML><BODY>\n";

print "<CENTER><H2>System Sleuth 1.0</H2></CENTER>\n";

for ($j = 0; $j < 50; $j++)
 {
 print "<!-- FORCE OUTPUT -->\n";
 }

$absolute_root = $ENV{'DOCUMENT_ROOT'};
$url = "http://$ENV{'HTTP_HOST'}";

$idx = rindex($ENV{'SCRIPT_FILENAME'}, "/");
$absolute_cgi = substr($ENV{'SCRIPT_FILENAME'}, 0, $idx);

$idx = rindex($ENV{'SCRIPT_NAME'}, "/");
$main_cgi = substr($ENV{'SCRIPT_NAME'}, 1, $idx - 1);

$sys_info = `uname -a`;
$sendmail = `which sendmail`;
$perl = `which perl`;

$absolute_cgi_link = readlink("$absolute_cgi");
$absolute_root_link = readlink("$absolute_root");

print "<B>Absolute web site URL:</B> $url<br>\n";
print "<B>Absolute path to home directory:</B> $absolute_root<br>\n";

if ($absolute_root_link ne "")
 {
 print "<B>Absolute path to home directory (alias):</B> $absolute_root_link<br>\n";
 }

{
print<<END
<br>
The locations above are relative to eachother.  The path is where the<br>
files are stored on the server, and can be viewed when you call the URL<br>
from your browser.
<br><br>
END
}

print "<B>Absolute URL to cgi-bin:</B> $url\/$main_cgi<br>\n";
print "<B>Absolute path to cgi-bin directory:</B> $absolute_cgi<br>\n";

if ($absolute_cgi_link ne "")
 {
 print "<B>Absolute path to cgi-bin directory (alias):</B> $absolute_cgi_link<br>\n";
 }

{
print<<END
<br>
The locations above are relative to eachother.  The path is where your<br>
cgi files are stored on the server, and can be viewed and/or executed when<br>
you call the URL from your browser.
<br><br>
END
}

if ($sendmail ne "")
 {
 print "<b>Location of sendmail:</b> $sendmail<br>\n";
 }

if ($perl ne "")
 {
 print "<b>Location of Perl:</b> $perl<br>\n";
 }

print "<b>Platform:</b> [ $^O ] $sys_info";

print "<br><br>\n";
print "Searching for writable directories (Absolute paths shown):<br>\n";
print "Starting from $absolute_root [ Max: $max_directories ]<br>\n";

&traverse($absolute_root);

if ($foundcount > 0)
 {
 print "<br><br>\n";

 for ($j = 0; $j < @all_found; $j++)
  {
  $num = $j + 1;
  print "[$num] @all_found[$j]<br>\n";
  }

{
print<<END
<br>
All of the directories above can be written to by your web server.<br>
This means if a script in your cgi-bin needs to write to any files<br>
or directories, any of the above can be used.  You can always create<br>
more under <i>$absolute_root</i> and CHMOD them to 777.
<br><br>
END
}
 }
 else
 {
 print "<br>No writable directories were found.<br>Create and chmod one below $absolute_root to 777\n";
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

sub traverse {

    local($dir) = shift;
    local($path);

    unless (opendir(DIR, $dir)) {
	warn "Can't open $dir\n";
	closedir(DIR);
	return;
    }

    foreach (readdir(DIR)) {
	next if $_ eq '.' || $_ eq '..';
        $path = "$dir/$_";

        if (-d $path) {          # a directory

        if ($tcount > 50)
         {
         $tcount = 0;
         print "<br><SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";
         }

        print ".\n";
        $tcount++;

        if ($foundcount >= $max_directories)
         {
         return;
         }

        if (-w "$path")
         {
         @all_found[$foundcount] = $path;
         $foundcount++;
         }

            &traverse($path);
	} elsif (-f _) {	# a plain file

           splice(@filename, 0);
           @filename = split(/\//, $path);
           $size = @filename - 1;
           $tcount++;

           print ".\n";

           if ($tcount > 50)
            {
            $tcount = 0;
            print "<br><SCRIPT>self.scrollBy(0,10000000)</SCRIPT>\n";
            }

	    # or do something you want to
	}
    }
    closedir(DIR);
}
