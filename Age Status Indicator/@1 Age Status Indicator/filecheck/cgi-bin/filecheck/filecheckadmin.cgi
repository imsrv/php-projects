#!/usr/bin/perl -w
use strict;
use CGI;
use CGI::Carp qw/fatalsToBrowser/;

#This is the only customization that should be done in this script:
#(Save the shebang line above! :-)

my $configFile = "filecheck.config";

my %config = &readConfig($configFile);
my $dataFile = &readDB($config{'dbFile'});

my $q = new CGI;

print $q->header;
print $q->start_html(-title=>'Admin Access');

print '<p><h1>Admin Access</h1></p>';

unless ( defined($q->param('password')) && crypt($q->param('password'), $config{'password'}) eq $config{'password'} ) {
   print '<p><b>Please login:</b> (Password is case sensitive!)';
   print $q->startform(-method=>'POST',
                       -action=>$config{'adminScriptFile'},
                       -enctype=>&CGI::MULTIPART);
   print '<input type=password name="password" size=30 maxlength=30>';
   print $q->endform;
   print '</p>';
   print $q->end_html;
   exit;
}

if ( defined($q->param('mode')) && $q->param('mode') eq 'change' ) {
   if ( defined($q->param('old')) && crypt($q->param('old'), $config{'password'}) eq $config{'password'}) {
      if ( defined($q->param('new1')) && defined($q->param('new2')) && $q->param('new1') eq $q->param('new2') ) {
         $config{'password'} = crypt ($q->param('new1'), join ( '', ('.', '/', 0..9, 'A'..'Z', 'a'..'z')[rand 64, rand 64] ) );
         $config{'password'} =~ s/"/&quot;/g;
         unless ( open(CONFIG, "+<$configFile") ) {
            print "Configuration File $configFile not found $!";
            die("file not found");
         }
         flock(CONFIG, 2)
           or die "Could not lock file $configFile: $!";
         seek(CONFIG,0,0);
         truncate(CONFIG,0);
         my $key;
         foreach $key (keys %config) {
            my $content = $config{$key};
            $content =~ s/&quot;/"/g;
            print CONFIG $key . "\|" . $content . "\n";
         }
         close CONFIG
           or die "Could not close file $configFile: $!";
         $config{'password'} =~ s/&quot;/"/g;
         print '<p><h2>The new password has been saved.</h2></p>';
      }
      else { print '<p><h2>The new passwords you entered do not match!</h2></p>' }
   }
   else { print '<p><h2>The old password you entered is not correct!</h2></p>' }
}

if ( defined($q->param('mode')) && $q->param('mode') eq 'post' && $q->param('pass') ne 'change' ) {
   my @configData;
   my @HTML = ($q->param('HTML0'), $q->param('HTML1'), $q->param('HTML2'), $q->param('HTML3'));
   for (my $i; $i < @HTML; $i++) {$HTML[$i] =~ s/&quot;/"/g}
   open (CONFIG, "+<$configFile") or die "Could not open config file $configFile: $!";
   flock(CONFIG,2) or die "Could not lock config file $configFile: $!";
   while (<CONFIG>) { push (@configData, $_) }

   for (my $i = 0;
           $i < @configData;
           $i++) {
      if ( substr($configData[$i], 0, 4) eq 'HTML') {
         foreach my $count (0..3) {
            if ( substr($configData[$i], 4, 1) eq $count ) { $configData[$i] = 'HTML' . $count . '|' . $HTML[$count] . "\n" }
         }
      }
      elsif ( substr($configData[$i], 0, 9) eq 'olderThan') {
         foreach my $count (1..3) {
            if ( substr($configData[$i], 9, 1) eq $count ) { $configData[$i] = 'olderThan' . $count . '|' . $q->param('age'.$count)*24 . "\n" }
         }
      }
      elsif ( substr($configData[$i], 0, 14) eq 'numberOfLevels') {
         $configData[$i] = 'numberOfLevels|' . $q->param('level') . "\n";
      }
   }

   seek(CONFIG,0,0);
   truncate(CONFIG,0);
   foreach my $line (@configData) { print CONFIG $line }
   close CONFIG;

   my @list = split ("\n", $q->param('data'));

   open (DB, "+<$config{'dbFile'}") or die "Could not open db file $config{'dbFile'}: $!";
   flock(DB,2) or die "Could not lock db file $config{'dbFile'}: $!";
   seek(DB,0,0);
   truncate(DB,0);
   foreach (@list) {
      chop;
      print DB $_."\n";
   }
   close DB;      

   %config = &readConfig($configFile);
   my $dataFile = &readDB($config{'dbFile'});
   print '<p><h2>Your changes have been saved!</h2></p>';
   print '<p><a href="' . $config{'adminScriptFile'} . '">Return to the admin section</a></p>';
   print $q->end_html;
   exit;
}

print $q->startform(-method=>'POST',
                    -action=>$config{'adminScriptFile'},
                    -enctype=>&CGI::MULTIPART);
print $q->hidden(-name=>'mode',
                 -default=>'post');
print $q->hidden(-name=>'password',
                 -default=>$q->param('password'));
print '<p><b>Please select a depth of age distinction:</b><br>';
print '<input type=radio value="1" name="level"' . (($config{'numberOfLevels'} < 2)  ? ' checked' : '') . '> Only one level of age distinction<br>';
print '<input type=radio value="3" name="level"' . (($config{'numberOfLevels'} >= 2) ? ' checked' : '') . '> Three levels of age distinction<br>';
print '</p><p><b>Please enter the age in days:</b><br>';
print 'X, Level 1: <input type=text name="age1" size=20 maxlength=20 value="' . $config{'olderThan1'}/24 . '"><br><br>';
print '<i>(Neglected if choosing 1-level age distinction above)</i><br>';
print 'Y, Level 2: <input type=text name="age2" size=20 maxlength=20 value="' . $config{'olderThan2'}/24 . '"><br>';
print 'Z, Level 3: <input type=text name="age3" size=20 maxlength=20 value="' . $config{'olderThan3'}/24 . '"></p>';
print '<p><b>HTML to be displayed:</b><br>';

print 'Show 1: <input type=text name="HTML0" size=50 maxlength=400 value="' . $config{'HTML0'} . '"><br><font face="Verdana, arial" size="-2">1-level: Show this if age is < X.<br>3-level: Show this if age is < X.</font><BR><BR>';
print 'Show 2: <input type=text name="HTML1" size=50 maxlength=400 value="' . $config{'HTML1'} . '"><br><font face="Verdana, arial" size="-2">1-level: Show this if age is > X.<BR>3-level: Show this if age is between X ~ Y.</font><BR><BR>';
print 'Show 3: <input type=text name="HTML2" size=50 maxlength=400 value="' . $config{'HTML2'} . '"><br><font face="Verdana, arial" size="-2">1-level: Neglected if choosing 1-level age distinction above.<BR>3-level: Show this if age is between Y ~ Z.</font><BR><BR>';
print 'Show 4: <input type=text name="HTML3" size=50 maxlength=400 value="' . $config{'HTML3'} . '"><br><font face="Verdana, arial" size="-2">1-level: Neglected if choosing 1-level age distinction above.<BR>3-level: Show this if age is > Z.</font><BR><BR>';
print '</p><p><b>Edit the data file here:</b></p>';

print '<p><textarea name="data" rows=10 wrap=off nowrap cols=50>' . $dataFile . '</textarea></p>';

print '<p><i>Please use the following syntax:</i><br><br>';
print '<code>XXXXX|Y|ZZZZZ</code><BR>Eg. 00003|1|/home/upoint/www/webdesign (Folder checking)<BR>Eg. 00007|0|/home/upoint/www/index.shtml (File checking)<br><br>';
print 'Where XXXXX is a number with five digits. Add leading 0\'s if necessary.<br>';
print 'Y is the folder flag. Set it to 1 if you are pointing at a folder and to 0 if you are pointing at a file.<br>';
print 'ZZZZZ is a path or file name. Do not use the | symbol in the file name.<br>';
print '</p>';

print '<p><input type=submit name="Save changes" value="Save Changes"></p>';
print $q->endform;

print $q->startform(-method=>'POST',
                    -action=>$config{'adminScriptFile'},
                    -enctype=>&CGI::MULTIPART);
print $q->hidden(-name=>'mode',
                 -default=>'change');
print $q->hidden(-name=>'password',
                 -default=>$q->param('password'));
print '<br><p><b>Want to change the password?</b></p>';
print '<p>Please enter the old password for confirmation:<br><input type=password name="old" size=30 maxlength=30></p>';
print '<p>Please enter the new password twice:<br><input type=password name="new1" size=30 maxlength=30><br><input type=password name="new2" size=30 maxlength=30></p>';
print '<p><input type=submit name="Change Password" value="Change Password"></p>';
print $q->endform;
print $q->end_html;
exit;

##################################
sub readConfig {
   # reads configuration file and returns relevant data (see below)
   my %config;
   unless ( open(CONFIG, "<$_[0]") ) {
      print "Configuration File $_[0] not found $!";
      die("file not found");
   }
   flock(CONFIG, 1)
     or die "Could not lock file $_[0]: $!";
   while (<CONFIG>) {
      chomp;
      (my $key, my $content) = split ('\|', $_);
      $content =~ s/"/&quot;/g if ( !( $key eq 'password' ) );
      $config{$key} = $content;
   }
   close CONFIG
     or die "Could not close file $_[0]: $!";
   return %config;
}
##################################
sub readDB {
   # reads db file and returns relevant data (see below)
   my @data;
   unless ( open(DB, "<$_[0]") ) {
      print "db File $_[0] not found $!";
      die("file not found");
   }
   flock(DB, 1)
     or die "Could not lock file $_[0]: $!";
   while (<DB>) {
      push (@data, $_);
   }
   close DB
     or die "Could not close file $_[0]: $!";
   my $string = join ('', @data);
   return $string;
}
##################################
