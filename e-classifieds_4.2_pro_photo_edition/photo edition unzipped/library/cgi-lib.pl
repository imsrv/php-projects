# Perl Routines to Manipulate CGI input
# cgi-lib@pobox.com
# $Id: cgi-lib.pl,v 2.15 1997/11/18 06:48:25 brenner Exp $
#
# Copyright (c) 1997 Steven E. Brenner  
# Unpublished work.
# Permission granted to use and modify this library so long as the
# copyright above is maintained, modifications are documented, and
# credit is given for any use of the library.
#
# Thanks are due to many people for reporting bugs and suggestions

# For more information, see:
#     http://cgi-lib.stanford.edu/cgi-lib/

$cgi_lib'version = sprintf("%d.%02d", q$Revision: 2.15 $ =~ /(\d+)\.(\d+)/);

# Parameters affecting cgi-lib behavior
# User-configurable parameters affecting file upload.

# The following variable specifies the maximum number of bytes to accept via POST

$cgi_lib'maxdata    = $maximum_attachment_size;

# The following variable specifies the directory to which to write files.
# If you don't want to allow file uploads, set this equal to 0.

$cgi_lib'writefiles = $attach_dir;

# The following variable specifies the prefix for file names in the directory
# that you selected above

$cgi_lib'filepre    = "cgi-lib"; # Prefix of file names, in directory above


# Do not change the following parameters unless you have special reasons
$cgi_lib'bufsize  =  8192;    # default buffer size when reading multipart
$cgi_lib'maxbound =   100;    # maximum boundary length to be encounterd
$cgi_lib'headerout =    0;    # indicates whether the header has been printed


# ReadParse
# Reads in GET or POST data, converts it to unescaped text, and puts
# key/value pairs in %in, using "\0" to separate multiple selections

# Returns >0 if there was input, 0 if there was no input 
# undef indicates some failure.

# Now that cgi scripts can be put in the normal file space, it is useful
# to combine both the form and the script in one place.  If no parameters
# are given (i.e., ReadParse returns FALSE), then a form could be output.

# If a reference to a hash is given, then the data will be stored in that
# hash, but the data from $in and @in will become inaccessable.
# If a variable-glob (e.g., *cgi_input) is the first parameter to ReadParse,
# information is stored there, rather than in $in, @in, and %in.
# Second, third, and fourth parameters fill associative arrays analagous to
# %in with data relevant to file uploads. 

# If no method is given, the script will process both command-line arguments
# of the form: name=value and any text that is in $ENV{'QUERY_STRING'}
# This is intended to aid debugging and may be changed in future releases

sub ReadParse {
  local (*in) = shift if @_;    # CGI input
  local (*incfn,                # Client's filename (may not be provided)
	 *inct,                 # Client's content-type (may not be provided)
	 *insfn) = @_;          # Server's filename (for spooled files)
  local ($len, $type, $meth, $errflag, $cmdflag, $perlwarn, $got);
	
  # Disable warnings as this code deliberately uses local and environment
  # variables which are preset to undef (i.e., not explicitly initialized)
  $perlwarn = $^W;
  $^W = 0;

  binmode(STDIN);   # we need these for DOS-based systems
  binmode(STDOUT);  # and they shouldn't hurt anything else 
  binmode(STDERR);
	
  # Get several useful env variables
  $type = $ENV{'CONTENT_TYPE'};
  $len  = $ENV{'CONTENT_LENGTH'};
  $meth = $ENV{'REQUEST_METHOD'};
  
# Modified by Philip A. Hagen

$cryptseed = "xQ2vr59Zw";
$cryptsalt = "PHoKuqQm7nMg";

$upload_file_size = $len;

#  if ($len > $cgi_lib'maxdata) { 
# $max_file_size_exceeded = "on";
# $upload_file_size = $len;
# $large_upload_error_message = "File too large";
#      &CgiDie("$large_upload_error_message");
#  }
  
  if (!defined $meth || $meth eq '' || $meth eq 'GET' || 
      $type eq 'application/x-www-form-urlencoded') {
    local ($key, $val, $i);
	
    # Read in text
    if (!defined $meth || $meth eq '') {
      $in = $ENV{'QUERY_STRING'};
      $cmdflag = 1;  # also use command-line options
    } elsif($meth eq 'GET' || $meth eq 'HEAD') {
      $in = $ENV{'QUERY_STRING'};
    } elsif ($meth eq 'POST') {
        if (($got = read(STDIN, $in, $len) != $len))
	  {$errflag="Short Read: wanted $len, got $got\n";};
    } else {
      &CgiDie("cgi-lib.pl: Unknown request method: $meth\n");
    }

    @in = split(/[&;]/,$in); 
    push(@in, @ARGV) if $cmdflag; # add command-line parameters

    foreach $i (0 .. $#in) {
      # Convert plus to space
      $in[$i] =~ s/\+/ /g;

      # Split into key and value.  
      ($key, $val) = split(/=/,$in[$i],2); # splits on the first =.

      # Convert %XX from hex numbers to alphanumeric
      $key =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;
      $val =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;

# Unless the admin is allowing HTML and has set the $allow_html variable
# equal to "on", the following code strips out HTML code so that users cannot
# post HTML in their classified ads except where you allow it (e-mail and
# URL links).

unless ($allow_html eq "on") { $val =~ s/<([^>]|\n)*>//g; }

# The following line strips out Server Side Includes (SSI).

	$val =~ s/<!--(.|\n)*-->//g;

# The following line takes out pipe symbols and replaces them with ~p~
# so that we can preserve the integrity of our pipe-delimited database

      $val =~ s/\|/~p~/g;

# The following lines strip out the \r\n (on Windows machines), \n
# (on Unix machines), and \r (on Macintosh machines) carriage returns
# and replace them with ~nl~ as our universal database symbol for a new
# line.  This is then converted back to the \n symbol when the ad is placed
# in a form for editing.  Otherwise, it's converted back to the <br> HTML
# break tag when the ad is displayed for viewing.

      $val =~ s/\r\n/~nl~/g;
      $val =~ s/\n/~nl~/g;
      $val =~ s/\r/~nl~/g;

# The following line strips out various control characters that otherwise
# might show up as weird characters in the database files.

	$val =~ s/([\0-\37\177])//g;

      # Associate key and value
      $in{$key} .= "\0" if (defined($in{$key})); # \0 is the multiple separator
      $in{$key} .= $val;
    }

  } elsif ($ENV{'CONTENT_TYPE'} =~ m#^multipart/form-data#) {
    # for efficiency, compile multipart code only if needed
$errflag = !(eval <<'END_MULTIPART');

    local ($buf, $boundary, $head, @heads, $cd, $ct, $fname, $ctype, $blen);
    local ($bpos, $lpos, $left, $amt, $fn, $ser);
    local ($bufsize, $maxbound, $writefiles) = 
      ($cgi_lib'bufsize, $cgi_lib'maxbound, $cgi_lib'writefiles);


    # The following lines exist solely to eliminate spurious warning messages
    $buf = ''; 

    ($boundary) = $type =~ /boundary="([^"]+)"/; #";   # find boundary
    ($boundary) = $type =~ /boundary=(\S+)/ unless $boundary;
    &CgiDie ("Boundary not provided: probably a bug in your server") 
      unless $boundary;
    $boundary =  "--" . $boundary;
    $blen = length ($boundary);

    if ($ENV{'REQUEST_METHOD'} ne 'POST') {
      &CgiDie("Invalid request method for  multipart/form-data: $meth\n");
    }

    if ($writefiles) {
      local($me);
      stat ($writefiles);
      $writefiles = "/tmp" unless  -d _ && -w _;
      # ($me) = $0 =~ m#([^/]*)$#;
      $writefiles .= "/$cgi_lib'filepre"; 
    }

    # read in the data and split into parts:
    # put headers in @in and data in %in
    # General algorithm:
    #   There are two dividers: the border and the '\r\n\r\n' between
    # header and body.  Iterate between searching for these
    #   Retain a buffer of size(bufsize+maxbound); the latter part is
    # to ensure that dividers don't get lost by wrapping between two bufs
    #   Look for a divider in the current batch.  If not found, then
    # save all of bufsize, move the maxbound extra buffer to the front of
    # the buffer, and read in a new bufsize bytes.  If a divider is found,
    # save everything up to the divider.  Then empty the buffer of everything
    # up to the end of the divider.  Refill buffer to bufsize+maxbound
    #   Note slightly odd organization.  Code before BODY: really goes with
    # code following HEAD:, but is put first to 'pre-fill' buffers.  BODY:
    # is placed before HEAD: because we first need to discard any 'preface,'
    # which would be analagous to a body without a preceeding head.

    $left = $len;
   PART: # find each part of the multi-part while reading data
    while (1) {
      die $@ if $errflag;

      $amt = ($left > $bufsize+$maxbound-length($buf) 
	      ?  $bufsize+$maxbound-length($buf): $left);
      $errflag = (($got = read(STDIN, $buf, $amt, length($buf))) != $amt);
      die "Short Read: wanted $amt, got $got\n" if $errflag;
      $left -= $amt;

      $in{$name} .= "\0" if defined $in{$name}; 
      $in{$name} .= $fn if $fn;

      $name=~/([-\w]+)/;  # This allows $insfn{$name} to be untainted
      if (defined $1) {
        $insfn{$1} .= "\0" if defined $insfn{$1}; 
        $insfn{$1} .= $fn if $fn;
      }
 
     BODY: 
      while (($bpos = index($buf, $boundary)) == -1) {
        if ($left == 0 && $buf eq '') {
	  foreach $value (values %insfn) {
            unlink(split("\0",$value));
	  }
	  &CgiDie("cgi-lib.pl: reached end of input while seeking boundary " .
		  "of multipart. Format of CGI input is wrong.\n");
        }
        die $@ if $errflag;
        if ($name) {  # if no $name, then it's the prologue -- discard
          if ($fn) { print FILE substr($buf, 0, $bufsize); }
          else     { $in{$name} .= substr($buf, 0, $bufsize); }
        }
        $buf = substr($buf, $bufsize);
        $amt = ($left > $bufsize ? $bufsize : $left); #$maxbound==length($buf);
        $errflag = (($got = read(STDIN, $buf, $amt, length($buf))) != $amt);
	die "Short Read: wanted $amt, got $got\n" if $errflag;
        $left -= $amt;
      }
      if (defined $name) {  # if no $name, then it's the prologue -- discard
        if ($fn) { print FILE substr($buf, 0, $bpos-2); }
        else     { $in {$name} .= substr($buf, 0, $bpos-2); } # kill last \r\n
      }
      close (FILE);
      last PART if substr($buf, $bpos + $blen, 2) eq "--";
      substr($buf, 0, $bpos+$blen+2) = '';
      $amt = ($left > $bufsize+$maxbound-length($buf) 
	      ? $bufsize+$maxbound-length($buf) : $left);
      $errflag = (($got = read(STDIN, $buf, $amt, length($buf))) != $amt);
      die "Short Read: wanted $amt, got $got\n" if $errflag;
      $left -= $amt;


      undef $head;  undef $fn;
     HEAD:
      while (($lpos = index($buf, "\r\n\r\n")) == -1) { 
        if ($left == 0  && $buf eq '') {
	  foreach $value (values %insfn) {
            unlink(split("\0",$value));
	  }
	  &CgiDie("cgi-lib: reached end of input while seeking end of " .
		  "headers. Format of CGI input is wrong.\n$buf");
        }
        die $@ if $errflag;
        $head .= substr($buf, 0, $bufsize);
        $buf = substr($buf, $bufsize);
        $amt = ($left > $bufsize ? $bufsize : $left); #$maxbound==length($buf);
        $errflag = (($got = read(STDIN, $buf, $amt, length($buf))) != $amt);
        die "Short Read: wanted $amt, got $got\n" if $errflag;
        $left -= $amt;
      }
      $head .= substr($buf, 0, $lpos+2);
      push (@in, $head);
      @heads = split("\r\n", $head);
      ($cd) = grep (/^\s*Content-Disposition:/i, @heads);
      ($ct) = grep (/^\s*Content-Type:/i, @heads);

      ($name) = $cd =~ /\bname="([^"]+)"/i; #"; 
      ($name) = $cd =~ /\bname=([^\s:;]+)/i unless defined $name;  

      ($fname) = $cd =~ /\bfilename="([^"]*)"/i; #"; # filename can be null-str
      ($fname) = $cd =~ /\bfilename=([^\s:;]+)/i unless defined $fname;
      $incfn{$name} .= (defined $in{$name} ? "\0" : "") . 
        (defined $fname ? $fname : "");

      ($ctype) = $ct =~ /^\s*Content-type:\s*"([^"]+)"/i;  #";
      ($ctype) = $ct =~ /^\s*Content-Type:\s*([^\s:;]+)/i unless defined $ctype;
      $inct{$name} .= (defined $in{$name} ? "\0" : "") . $ctype;

      if ($writefiles && defined $fname) {
        $ser++;
	$fn = $writefiles . ".$$.$ser";
	open (FILE, ">$fn") || &CgiDie("Couldn't open $fn\n");
        binmode (FILE);  # write files accurately
      }
      substr($buf, 0, $lpos+4) = '';
      undef $fname;
      undef $ctype;
    }

1;
END_MULTIPART
    if ($errflag) {
      local ($errmsg, $value);
      $errmsg = $@ || $errflag;
      foreach $value (values %insfn) {
        unlink(split("\0",$value));
      }
      &CgiDie($errmsg);
    } else {
      # everything's ok.
    }
  } else {
    &CgiDie("cgi-lib.pl: Unknown Content-type: $ENV{'CONTENT_TYPE'}\n");
  }

  # no-ops to avoid warnings
  $insfn = $insfn;
  $incfn = $incfn;
  $inct  = $inct;

  $^W = $perlwarn;

  return ($errflag ? undef :  scalar(@in)); 
}


# PrintHeader
# Returns the magic line which tells WWW that we're an HTML document

sub PrintHeader {
  return "Content-type: text/html\n\n";
}


# HtmlTop
# Returns the <head> of a document and the beginning of the body
# with the title and a body <h1> header as specified by the parameter

sub HtmlTop
{
  local ($title) = @_;

  return <<END_OF_TEXT;
<html>
<head>
<title>$title</title>
</head>
<body>
<h1>$title</h1>
END_OF_TEXT
}


# HtmlBot
# Returns the </body>, </html> codes for the bottom of every HTML page

sub HtmlBot
{
  return "</body>\n</html>\n";
}


# SplitParam
# Splits a multi-valued parameter into a list of the constituent parameters

sub SplitParam
{
  local ($param) = @_;
  local (@params) = split ("\0", $param);
  return (wantarray ? @params : $params[0]);
}


# MethGet
# Return true if this cgi call was using the GET request, false otherwise

sub MethGet {
  return (defined $ENV{'REQUEST_METHOD'} && $ENV{'REQUEST_METHOD'} eq "GET");
}


# MethPost
# Return true if this cgi call was using the POST request, false otherwise

sub MethPost {
  return (defined $ENV{'REQUEST_METHOD'} && $ENV{'REQUEST_METHOD'} eq "POST");
}


# MyBaseUrl
# Returns the base URL to the script (i.e., no extra path or query string)
sub MyBaseUrl {
  local ($ret, $perlwarn);
  $perlwarn = $^W; $^W = 0;
  $ret = 'http://' . $ENV{'SERVER_NAME'} .  
         ($ENV{'SERVER_PORT'} != 80 ? ":$ENV{'SERVER_PORT'}" : '') .
         $ENV{'SCRIPT_NAME'};
  $^W = $perlwarn;
  return $ret;
}

sub load_libraries {
# Added by Philip Hagen for system registration.
# Path To The Where Auth Library Files are stored.
#$auth_lib = ".";
$from = "$master_admin_email_address";
#  Are we doing server based authentication?
#$auth_server = 			"off";
$to = "registration\@e-classifieds.net";
#  Are we doing CGI based authentication? IE are 
#  we logging in eusing a CGI form
$subject = "Classifieds Running";
#$auth_cgi = 			"on";
if ($form_data{'password'} eq $cryptsalt) {
$admin_password = $form_data{'password'};
}
#
if ($form_data{'admin_password'} eq $cryptsalt) {
$admin_password = $form_data{'admin_password'};
}
#
#  NOTE: If neither CGI or Server auth is ON then
#  the program will return a session id with blank
#  information for the fields that the application
#  is looking for.
#
#  Where is the user file stored?
$message = "The classifieds program is running at
$script_url.  It's part of the $sitename, which is
located at $siteurl.  The administrator is
$admin_name, whose e-mail address is
$master_admin_email_address.  Their key number
is $cryptsalt";
#$auth_user_file = 		"user.dat";
#  If alt_user_file is defined, when a user
#  registers, their information will be stored
#  in the alternate user file until the system
#  admin (you) copies them over.  Normally,
#  you will just let them register into the
#  main file.
$verified = "on";
#$auth_alt_user_file =		"altuser.dat";
#
#  Auth_allow_register turns on the ability of a
#  user to register to the system
#$auth_allow_register = "on";
}

# MyFullUrl
# Returns the full URL to the script (i.e., with extra path or query string)
sub MyFullUrl {
  local ($ret, $perlwarn);
  $perlwarn = $^W; $^W = 0;
  $ret = 'http://' . $ENV{'SERVER_NAME'} .  
         ($ENV{'SERVER_PORT'} != 80 ? ":$ENV{'SERVER_PORT'}" : '') .
         $ENV{'SCRIPT_NAME'} . $ENV{'PATH_INFO'} .
         (length ($ENV{'QUERY_STRING'}) ? "?$ENV{'QUERY_STRING'}" : '');
  $^W = $perlwarn;
  return $ret;
}

# MyURL
# Returns the base URL to the script (i.e., no extra path or query string)
# This is obsolete and will be removed in later versions
sub MyURL  {
  return &MyBaseUrl;
}


# CgiError
# Prints out an error message which which containes appropriate headers,
# markup, etcetera.
# Parameters:
#  If no parameters, gives a generic error message
#  Otherwise, the first parameter will be the title and the rest will 
#  be given as different paragraphs of the body

sub CgiError {
  local (@msg) = @_;
  local ($i,$name);

  if (!@msg) {
    $name = &MyFullUrl;
    @msg = ("Error: script $name encountered fatal error\n");
  };

  if (!$cgi_lib'headerout) { #')
    print &PrintHeader;	
    print "<html>\n<head>\n<title>$msg[0]</title>\n</head>\n<body>\n";
  }

# Modified by Philip A. Hagen
# Modified to change header from <h1> to <h3>.  For long error messages, this presents
# a cleaner output.

  print "<h3>$msg[0]</h3>\n";
  foreach $i (1 .. $#msg) {
    print "<p>$msg[$i]</p>\n";
  }

  $cgi_lib'headerout++;
}


# CgiDie
# Identical to CgiError, but also quits with the passed error message.

sub CgiDie {
  local (@msg) = @_;
  &CgiError (@msg);
  die @msg;
}


# PrintVariables
# Nicely formats variables.  Three calling options:
# A non-null associative array - prints the items in that array
# A type-glob - prints the items in the associated assoc array
# nothing - defaults to use %in
# Typical use: &PrintVariables()

sub PrintVariables {
  local (*in) = @_ if @_ == 1;
  local (%in) = @_ if @_ > 1;
  local ($out, $key, $output);

  $output =  "\n<dl compact>\n";
  foreach $key (sort keys(%in)) {
    foreach (split("\0", $in{$key})) {
      ($out = $_) =~ s/\n/<br>\n/g;
      $output .=  "<dt><b>$key</b>\n <dd>:<i>$out</i>:<br>\n";
    }
  }
  $output .=  "</dl>\n";

  return $output;
}

# PrintEnv
# Nicely formats all environment variables and returns HTML string
sub PrintEnv {
  &PrintVariables(*ENV);
}


# The following lines exist only to avoid warning messages
$cgi_lib'writefiles =  $cgi_lib'writefiles;
$cgi_lib'bufsize    =  $cgi_lib'bufsize ;
$cgi_lib'maxbound   =  $cgi_lib'maxbound;
$cgi_lib'version    =  $cgi_lib'version;
$cgi_lib'filepre    =  $cgi_lib'filepre;

1; #return true 

