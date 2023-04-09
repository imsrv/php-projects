##########################################################
##  CGI Works Library v2.0.0                 8/26/2001  ##
##########################################################
#   Program Name	: AutoGallery Pro
#   Website		: http://www.jmbsoft.com
#   Version		: 2.0.0b
#   Supplier By  	: Sliding
#   Nullified By	: CyKuH
##########################################################
use Socket;
use Exporter;
use Fcntl qw(:DEFAULT :flock);

use vars qw( 
             @ISA @EXPORT 
             $LIB_VER $HEADER $RMTUSR $OPSYS $TDIR $DDIR $ERRLOG $REQMTH $RMTADR $QUERY
             $LOCK_SH $LOCK_EX $LOCK_NB $LOCK_UN $O_RDONLY $O_WRONLY $O_RDWR $O_CREAT
             $O_EXCL $O_APPEND $O_TRUNC $O_NONBLOCK $DEL $O_REC_LONG
             %TPL %FRM %QRY %MTHS %DAYS
           );

@ISA     = qw(
               Exporter
             );

@EXPORT  = qw( 
               $HEADER $DDIR $REQMTH $RMTUSR $RMTADR $TDIR $LOCK_SH $LOCK_EX $LOCK_NB $LOCK_UN $O_RDONLY $O_WRONLY $O_RDWR $O_CREAT
               $O_EXCL $O_APPEND $O_TRUNC $O_NONBLOCK $DEL $QUERY $O_REC_LONG %TPL %FRM %QRY derr err fcreate fremove freadline freadall 
               fparse mode dbdelete dbinsert dbupdate dbselect dcreate dread timetostr fdate ftime vparse freadalls fwritenew ssize
               fjoin urlencode parseget parsepost getsalt validpass fappend fwrite fsplit mail dbsize fprint tprint diskspace
             );

$OPSYS   = 'UNIX';                     ##  If you are on an NT server, change this to NT
$DDIR    = './data';                   ##  Set this to the full path to your data directory
$TDIR    = './templates';              ##  Set this to the full path to your templates directory
$ERRLOG  = 0;                          ##  Change this to a 1 (one) if you want to log error messages

%MTHS = ( 
          0  => "January",
          1  => "February",
          2  => "March",
          3  => "April",
          4  => "May",
          5  => "June",
          6  => "July",
          7  => "August",
          8  => "September",
          9  => "October",
          10 => "November",
          11 => "December"
        );


%DAYS = ( 
          0 => "Sunday",
          1 => "Monday",
          2 => "Tuesday",
          3 => "Wednesday",
          4 => "Thursday",
          5 => "Friday",
          6 => "Saturday"
        );

########################################################
##                DONE EDITING THIS FILE              ##
########################################################

$LIB_VER    = '2.0.0';
$REQMTH     = $ENV{'REQUEST_METHOD'};
$RMTUSR     = $ENV{'REMOTE_USER'};
$QUERY      = $ENV{'QUERY_STRING'};
$RMTADR     = $ENV{'REMOTE_ADDR'};
$HEADER     = 0;
$LOCK_SH    = LOCK_SH;
$LOCK_EX    = LOCK_EX;
$LOCK_NB    = LOCK_NB;
$LOCK_UN    = LOCK_UN;
$O_RDONLY   = O_RDONLY;
$O_WRONLY   = O_WRONLY;
$O_RDWR     = O_RDWR;
$O_CREAT    = O_CREAT;
$O_EXCL     = O_EXCL;
$O_APPEND   = O_APPEND;
$O_TRUNC    = O_TRUNC;
$O_NONBLOCK = O_NONBLOCK;
$O_REC_LONG = 'HTML';
$DEL        = '|';
$|          = 1;
1;

###                                     ###
###  BEGIN FILE MANIPULATION FUNCTIONS  ###
###                                     ###

sub fcreate {
  my($file, $perms) = @_;

  err('Security Violation [.. in filename]', $file) if( index($file, '..') != -1 );

  $perms = 0666 if( !defined $perms );

  if( !-e $file ) {
    open(FILE, ">$file") || err("$!", $file);
    close(FILE);
    chmod($perms, $file) || err("$!", $file);
  }
}

sub fremove {
  my($file) = shift;

  err('Security Violation [.. in filename]', $file) if( index($file, '..') != -1 );

  unlink($file) || err("$!", $file);
}

sub freadline {
  my($file) = shift;

  err('Security Violation [.. in filename]', $file) if( index($file, '..') != -1 );

  open(FILE, $file) || err("$!", $file);
  flock(FILE, $LOCK_SH);
  my $line = <FILE>;
  close(FILE);
  flock(FILE, $LOCK_UN);
  chomp($line);

  return $line;
}

sub freadall {
  my($file) = shift;

  err('Security Violation [.. in filename]', $file) if( index($file, '..') != -1 );

  open(FILE, $file) || err("$!", $file);
  flock(FILE, $LOCK_SH);
  my @lines = <FILE>;
  close(FILE);
  flock(FILE, $LOCK_UN);
  chomp(@lines);

  return \@lines;
}

sub freadalls {
  my($file, $line) = shift;

  err('Security Violation [.. in filename]', $file) if( index($file, '..') != -1 );

  open(FILE, $file) || err("$!", $file);
  flock(FILE, $LOCK_SH);
  while( <FILE> ) {
    $line .= $_;
  }
  flock(FILE, $LOCK_UN);
  close(FILE);
  return \$line;
}

sub fwrite {
  my($file, $data) = @_;

  err('Security Violation [.. in filename]', $file) if( index($file, '..') != -1 );

  diskspace();

  sysopen(FILE, $file, $O_WRONLY | $O_CREAT) || err("$!", $file);
  flock(FILE, $LOCK_EX);
  truncate(FILE, 0);
  print FILE $data;
  flock(FILE, $LOCK_UN);
  close(FILE);
  chmod(0666, $file) if( -O $file );
}

sub fwritenew {
  my($file, $data) = @_;

  err('Security Violation [.. in filename]', $file) if( index($file, '..') != -1 );

  diskspace();

  if( !-e $file ) {
    sysopen(FILE, $file, $O_WRONLY | $O_CREAT) || err("$!", $file);
    flock(FILE, $LOCK_EX);
    truncate(FILE, 0);
    print FILE $data;
    flock(FILE, $LOCK_UN);
    close(FILE);
    chmod(0666, $file) if( -O $file );
  }
}

sub fappend {
  my($file, $data) = @_;

  err('Security Violation [.. in filename]', $file) if( index($file, '..') != -1 );

  diskspace();

  open(FILE, ">>$file") || err("$!", $file);
  flock(FILE, $LOCK_EX);
  print FILE $data;
  flock(FILE, $LOCK_UN);
  close(FILE);
  chmod(0666, $file) if( -O $file );
}

sub fsplit {
  my($file) = shift;

  err('Security Violation [.. in filename]', $file) if( index($file, '..') != -1 );

  open(FILE, "$file") || err("$!", $file);
  flock(FILE, $LOCK_SH);
  my @data = split(/\|/, <FILE>);
  flock(FILE, $LOCK_UN);
  close(FILE);

  return \@data;
}

sub fjoin {
  my($file, @data) = @_;

  err('Security Violation [.. in filename]', $file) if( index($file, '..') != -1 );

  diskspace();

  sysopen(FILE, $file, $O_WRONLY | $O_CREAT) || err("$!", $file);
  flock(FILE, $LOCK_EX);
  truncate(FILE, 0);
  print FILE join('|', @data);
  flock(FILE, $LOCK_UN);
  close(FILE);
  chmod(0666, $file) if( -O $file );
}

sub fprint {
  my $file = shift;

  err('Security Violation [.. in filename]', $file) if( index($file, '..') != -1 );

  open(FILE, $file) || err("$!", $file);
  flock(FILE, $LOCK_SH);
  while( <FILE> ) { print }
  flock(FILE, $LOCK_UN);
  close(FILE);
}

sub mode {
  my($perms, $file) = @_;
  if( -O $file ) {
    chmod($perms, $file) || err("$!", $file);
  }
}

sub diskspace {
  fremove("$DDIR/test.file") if( -e "$DDIR/test.file");

  sysopen(FILE, "$DDIR/test.file", $O_WRONLY | $O_CREAT) || err("$!", "Disk Space Test");
  flock(FILE, $LOCK_EX);
  truncate(FILE, 0);
  print FILE "THIS FILE IS USED TO CHECK FOR FREE DISK SPACE";
  flock(FILE, $LOCK_UN);
  close(FILE);
  mode(0666, "$DDIR/test.file");

  my $size = (-s "$DDIR/test.file");

  fremove("$DDIR/test.file");

  err("No Disk Space Available", $file) if( $size == 0 ); 
}

###                                 ###
###  BEGIN TEXT DATABASE FUNCTIONS  ###
###                                 ###

sub dbsize {
  my $db    = shift;
  my $count = 0;

  err('Security Violation [.. in filename]', $db) if( index($db, '..') != -1 );

  open(DB, $db) || err("$!", $db);
  flock(DB, $LOCK_SH);
  while( <DB> ) {
    $count++ if( $_ !~ /^\s*$/ );
  }
  flock(DB, $LOCK_UN);
  close(DB);

  return $count;
}

#dmitry

sub dbdelete {
  my( $db, $key ) = @_;
  my($line, $found);
  
  err('Security Violation [.. in filename]', $db) if( index($db, '..') != -1 );

  diskspace();

  sysopen(DB, $db, $O_RDWR | $O_CREAT) || err("$!", $db);
  flock(DB, $LOCK_EX);
  my @old = <DB>;
  seek(DB, 0, 0);  
  foreach $line ( @old ) {
    if( index($line, "$key$DEL") == 0 ) {
      $found = 1;
    }
    else {
      print DB $line if( $line !~ /^\s*$/ );
    }
  }
  truncate(DB, tell(DB));
  flock(DB, $LOCK_UN);
  close(DB);
  mode(0666, $db);

  return $found;
}

sub dbinsert {
  my( $db, @data ) = @_;
  my $line;

  err('Security Violation [.. in filename]', $db) if( index($db, '..') != -1 );

  diskspace();

  chomp(@data);

  sysopen(DB, $db, $O_RDWR | $O_CREAT) || err("$!", $db);
  flock(DB, $LOCK_EX);

  while( $line = <DB> ) {
    if( index($line, "$data[0]$DEL") == 0 ) {
      flock(DB, $LOCK_UN);
      close(DB);
      return 0;
    }
  }

  print DB join($DEL, @data) . "\n";
  flock(DB, $LOCK_UN);
  close(DB);

  return 1;
}

sub dbselect {
  my( $db, $key ) = @_;
  my $line;

  err('Security Violation [.. in filename]', $db) if( index($db, '..') != -1 );

  open(DB, $db) || err("$!", $db);
  flock(DB, $LOCK_SH);
  while( $line = <DB> ) {
    if( index($line, "$key$DEL") == 0 ) {
      flock(DB, $LOCK_UN);
      close(DB);
      my @data = split(/\Q$DEL\E/, $line);
      chomp(@data);
      return \@data;
    }
  }
  flock(DB, $LOCK_UN);
  close(DB);

  mode(0666, $db);

  return 0;
}

sub dbupdate {
  my( $db, $key, @data ) = @_;
  my( $line, $found );

  err('Security Violation [.. in filename]', $db) if( index($db, '..') != -1 );

  diskspace();

  chomp(@data);

  sysopen(DB, $db, $O_RDWR | $O_CREAT) || err("$!", $db);
  flock(DB, $LOCK_EX);
  my @old = <DB>;
  seek(DB, 0, 0);
  
  foreach $line ( @old ) {
    if( index($line, "$key$DEL") == 0 ) {
      print DB join($DEL, @data) . "\n";
      $found = 1;
    }
    else {
      print DB $line if( $line !~ /^\s*$/ );
    }
  }
  truncate(DB, tell(DB));
  flock(DB, $LOCK_UN);
  close(DB);

  mode(0666, $db);

  return $found;
}



###                                          ###
###  BEGIN DIRECTORY MANIPULATION FUNCTIONS  ###
###                                          ###

sub dcreate {
  my($dir, $perms) = @_;
  $perms = 0777 if( !defined $perms );

  err('Security Violation [.. in filename]', $dir) if( index($dir, '..') != -1 );

  if( !-e $dir ) {
    mkdir($dir, $perms) || err("$!", $dir);
    chmod($perms, $dir) || err("$!", $dir);
  }
}

sub dread {
  my($dir, $patt) = @_;

  err('Security Violation [.. in filename]', $dir) if( index($dir, '..') != -1 );

  opendir(DIR, $dir) || err("$!", $dir);
  my @files = grep { /$patt/ } readdir(DIR);
  closedir(DIR);

  return \@files;
}

###                                          ###
###  BEGIN DATE/TIME MANIPULATION FUNCTIONS  ###
###                                          ###

sub timetostr {
  my $time = shift;
  my $days = int($time / (60*60*24));
  my $string = "";
  
  $string .= $days . "d " if ($days > 0);
  $time -= $days * 60*60*24;
  my $hours = int($time / (60*60));
  $string .= $hours."h " if ($hours > 0);
  $time -= $hours *60*60;
  my $minutes = int($time / 60);
  $string .= $minutes."m " if ($minutes > 0);
  $time -= $minutes * 60;
  my $seconds = $time . "s";
  $string .= $seconds;
  
  return $string;
}

sub fdate {
  my($format, $time) = @_;
  my %fmt  = ();

  $format  = "%n-%j-%y" if( $format eq '' );
  $time    = time if( !defined $time );
  my @date = localtime($time);

  my $mth = $date[4] + 1;
  
  $fmt{'d'} = length($date[3]) < 2 ? "0" . $date[3] : $date[3];               ## day of the month, 2 digits with leading zeros; i.e. "01" to "31"
  $fmt{'j'} = $date[3];                                                       ## day of the month without leading zeros; i.e. "1" to "31"
  $fmt{'D'} = substr($DAYS{$date[6]}, 0, 3);                                  ## day of the week, textual, 3 letters; i.e. "Fri"
  $fmt{'w'} = $DAYS{$date[6]};                                                ## day of the week, textual, long; i.e. "Friday"
  $fmt{'M'} = substr($MTHS{$date[4]}, 0, 3);                                  ## month, textual, 3 letters; i.e. "Jan"
  $fmt{'F'} = $MTHS{$date[4]};                                                ## month, textual, long; i.e. "January"
  $fmt{'m'} = length($mth) < 2 ? "0" . $mth : $mth;                           ## month, 2 digits with leading zeros;; i.e. "01" to "12"
  $fmt{'n'} = $date[4] + 1;                                                   ## month without leading zeros; i.e. "1" to "12"
  $fmt{'Y'} = $date[5] + 1900;                                                ## year, 4 digits; i.e. "1999"
  $fmt{'y'} = substr($date[5] + 1900, 2, 2);                                  ## year, 2 digits; i.e. "99"

  for( keys %fmt ) {
    $format =~ s/%([a-zA-Z])/$fmt{$1}/gise;
  }
  return $format;
}

sub ftime {
  my($format, $time) = @_;
  my %fmt  = ();
  $format  = "%g:%i%a" if( $format eq '' );
  $time    = time if( !defined $time );
  my @date = localtime($time);
  
  $fmt{'a'} = $date[2] < 12 ? "am" : "pm";                                    ## "am" or "pm"
  $fmt{'h'} = $date[2] > 12 ? $date[2] - 12 : $date[2];                       ## hour, 12-hour format; i.e. "01" to "12"
  $fmt{'h'} = 12 if( $fmt{'h'} == 0 );
  $fmt{'h'} = length( $fmt{'h'} ) < 2 ? "0" . $fmt{'h'} : $fmt{'h'};
  $fmt{'H'} = length($date[2]) < 2 ? "0" . $date[2] : $date[2];               ## hour, 24-hour format; i.e. "00" to "23"
  $fmt{'g'} = $date[2] > 12 ? $date[2] - 12 : $date[2];                       ## hour, 12-hour format without leading zeros; i.e. "1" to "12"
  $fmt{'g'} = 12 if( $fmt{'g'} == 0 );
  $fmt{'G'} = $date[2];                                                       ## hour, 24-hour format without leading zeros; i.e. "0" to "23"
  $fmt{'i'} = length($date[1]) < 2 ? "0" . $date[1] : $date[1];               ## minutes; i.e. "00" to "59"
  $fmt{'s'} = length($date[0]) < 2 ? "0" . $date[0] : $date[0];               ## seconds; i.e. "00" to "59"

  for( keys %fmt ) {
    $format =~ s/%([a-zA-Z])/$fmt{$1}/gise;
  }
  return $format;
}


###                                 ###
###  BEGIN INPUT PARSING FUNCTIONS  ###
###                                 ###

sub parsepost {
  my( $rmhtml ) = shift;
  my( $value, $name, $buffer );
  read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
  my @pairs = split(/&/, $buffer);
	
  for (@pairs) {
    ($name, $value) = split(/=/, $_);
    $value =~ tr/+/ /;
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $value =~ s/</&lt;/g if($rmhtml);
    $value =~ s/>/&gt;/g if($rmhtml);
    $FRM{$name} .= (defined $FRM{$name}) ? "," . $value : $value;
  }
}

sub parseget {
  my @pairs = split(/&/, $ENV{'QUERY_STRING'});
  my ($name, $value);
  
  for (@pairs) {
    ($name, $value) = split(/=/, $_);
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $QRY{$name} = $value;
  }
}

sub urlencode {
  my $url = shift;
  $url =~ s/([^\w\.\-])/sprintf("%s%x", '%', ord($1))/eg;
  return $url;
}


###                            ###
###  BEGIN PASSWORD FUNCTIONS  ###
###                            ###

sub validpass {
  my($cp, $pass) = @_;
  my $salt = substr($cp, 0, 2);
  $salt = substr($cp, 3, 2) if($cp =~ /^\$/);
  return crypt($pass, $salt) eq $cp;
}

sub getsalt {
  my @chars = ('a'..'z', 'A'..'Z', '0'..'9', '.', '/');
  return $chars[ int(rand( $#chars + 1 )) ] . $chars[ int(rand( $#chars + 1 )) ];
}


###                            ###
###  BEGIN TEMPLATE FUNCTIONS  ###
###                            ###

sub fparse {
  my($page, $fh, $line) = @_;  
  $fh = *STDOUT if(!$fh);

  open(FILE, "$TDIR/$page") || err("$!", $page);
  while( $line = <FILE> ) {
    $line =~ s/#%(.*?)%#/$TPL{$1}/gise;
    print $fh $line;
  }
  close(FILE);
}

sub vparse {
  my($html, $fh) = @_;
  $fh = *STDOUT if(!$fh);
  $html =~ s/#%(.*?)%#/$TPL{$1}/gise;
  print $fh $html;
}

sub tprint {
  my $file = shift;
  open(FILE, "$TDIR/$file") || err("$!", $file);
  while( <FILE> ) { print }
  close(FILE);
}


###                          ###
###  BEGIN E-MAIL FUNCTIONS  ###
###                          ###

sub mail {
  my($mailer, $msg, $tpl) = @_;
  $$msg =~ s/#%(.*?)%#/$tpl->{$1}/gise;
  $mailer =~ /\// ? shell($mailer, $msg) : smtp($mailer, $msg);
}

sub smtp {
  my($mailer, $msg) = @_;
  
  $$msg =~ /To:\s*([^\n]*)\nFrom:\s*([^\n]*)\n/i;
  my $from = $2;
  my $to   = $1;
  return if( $from eq '' || $to eq '' );

  my $ip   = inet_aton($mailer);
  my $padd = sockaddr_in(25, $ip);
  my $crlf = "\015\012"; 
  socket(SMTP, PF_INET, SOCK_STREAM, getprotobyname('tcp'));
  connect(SMTP, $padd) || err("$!", "SMTP Socket");

  my $line;

  $line = <SMTP>;
  send(SMTP, "HELO localhost$crlf", 0);
  $line = <SMTP>;
  send(SMTP, "RSET$crlf", 0);
  $line = <SMTP>;
  send(SMTP, "MAIL FROM: <$from>$crlf", 0);
  $line = <SMTP>;
  send(SMTP, "RCPT TO: <$to>$crlf", 0);
  $line = <SMTP>;
  send(SMTP, "DATA$crlf", 0);
  $line = <SMTP>;
  send(SMTP, "$$msg$crlf.$crlf", 0);
  $line = <SMTP>;
  send(SMTP, "QUIT$crlf", 0);
  $line = <SMTP>;

  close(SMTP);
}

sub shell {
  my($mailer, $msg) = @_;
  open(MAIL, "|$mailer -t >>$DDIR/sml.log") || err("$!", $mailer);
  print MAIL $$msg;
  close(MAIL);
}


###                                 ###
###  BEGIN ERROR HANDLING ROUTINES  ###
###                                 ###

sub err {
  my($cause, $file, $fnct) = @_;
  my $usr  = (getpwuid( $< ))[0] if( $OPSYS eq 'UNIX');
  my $grp  = (getgrgid( $) ))[0] if( $OPSYS eq 'UNIX');
  chomp($cause);
  
  fappend("$DDIR/error.log", "[ " . fdate("%m-%d-%y") . " " . ftime("%H:%i") . " ]  [ $file ]  [ $cause ]\n") if( $ERRLOG && $file !~ /error\.log/ );

  print "Content-type: text/html\n\n" if( !$HEADER && $ENV{'REQUEST_METHOD'} );
  print "<pre>\n" if( $ENV{'REQUEST_METHOD'} );
  print "A FATAL CGI ERROR HAS OCCURRED\n==============================\n";
  print "Error Message     :  $cause\n";   
  print "Accessing File    :  $file\n";
  print "Running as User   :  $usr\n" if( $OPSYS eq 'UNIX');
  print "Running as Group  :  $grp\n" if( $OPSYS eq 'UNIX');

  exit;
}

sub derr {
  my($num, $data) = @_;

  eval {
    require "$DDIR/errors.dat";
  };
  
  err("$@", 'errors.dat') if( $@ );
  $TPL{ERROR} = $data ? "$error{$num}: $data" : $error{$num};
  fparse('_error_data.htmlt');

  exit;
}