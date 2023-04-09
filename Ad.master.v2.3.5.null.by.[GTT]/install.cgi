#!/usr/bin/perl

#########################################################################
###    Supplied by Shadoff [GTT]    Nullified by Vorga1664 [GTT]      ###
###              Grinderz Translation Team '2004                      ###
#########################################################################

use CGI::Carp qw(fatalsToBrowser);
use strict;
use Cwd;
use File::Copy;

use lib "./";

use Template;
use svars;


require 'site.pl';
require 'logon.pl';

my %keys = parse_form();
my %cookie = parse_cookie();
my $ver = 'am_v2_3';


my ($sth, $row, $template, $q, $main);

if (($keys{page} eq '')or($keys{page} eq 'step1')) {
  &Step1();
}
if ($keys{page} eq 'step2') {
  &Step2();
}
if ($keys{page} eq 'step3') {
  &Step3();
}

my $dbh = login();

sub Step1 {
  my $flag = 1;
  my $err = '';
  my @info = ();
  if ($keys{page} eq 'step1') {
    print "Content-type: text/html\n\n";

    $flag = 0;
    my $dir = cwd();
    chdir("$keys{imagepath}") or $flag = 1;
    if ($flag == 1) {
      my %in = ('message' => 'chdir error:', 'info' => "Cannot chdir $keys{images} ($!)");
      @info = (@info, \%in);
      $flag = 0;
    } else {
      mkdir('am_v2_3', 0777) or $flag = 1;
      if ($flag == 1) {
        my %in = ('message' => 'mkdir error:', 'info' => "Cannot mkdir $keys{imagepath}/am_v2_3 ($!)");
        @info = (@info, \%in);
        $flag = 0;
      }
      chdir($dir);
      $keys{imagepath}.= '/' if ($keys{imagepath} !~ /\/$/);
      $keys{imageurl}.= '/' if ($keys{imageurl} !~ /\/$/);
      $keys{imagepath}.= 'am_v2_3';
      $keys{imageurl}.= 'am_v2_3/';
      @info = (@info, am_copydir("$dir/i", $keys{imagepath}));
      $keys{imagepath} .= '/';
      $template = new Template('tmpl/svars.pm');
      my $ru;
      my $filename = (split /[\/|\\]/, $0)[-1];


      ($ru = $ENV{REQUEST_URI}) =~ s/$filename//;

      $vars_server_url = "http://$ENV{HTTP_HOST}$ru";

      my %in = (
        	'imagesurl' => $keys{imageurl},
        	'imagespath' => $keys{imagepath},
        	'sendmail_path' => '/usr/sbin/sendmail -t',
        	'dupviewtime' => 1,
        	'dupclicktime' => 1,
        	'maxbannersize' => 100,
        	'server_path' => $vars_server_url,
        	'ignoreIP' => ''
      );
      $template->replace_hash(%in);
      open FILE, '>svars.pm' or $flag = 1;
      if ($flag == 1) {
        my %in = ('message' => "Create file error", 'info' => "Create file svars.pm error ($!)");
        @info = (@info, \%in);
        $flag = 0;
      } else {
        print FILE $template->{code};
        close FILE;
      }
    }
    my $main = new Template('tmpl/setup/main.html');
    $template = new Template('tmpl/setup/step1.5.html');
    $main->replace('content', $template->{code});
    if ($#info >= 0) {
      my $info = $main->get_area('info-area');
      $main->make_for_array('info-area', $info, @info);
    } else {
      $main->replace('info-area', $main->get_area('no-info'));
    }
    $main->clear_areas('info-area', 'no-info');
    print $main->{code};
    exit;

  }
  if ($flag == 1) {
    print "Content-type: text/html\n\n";
    my $imagepath = $keys{imagepath};
    my $imageurl = $keys{imageurl};
    $imagepath = cwd() if ($keys{imagepath} eq '');
    $imageurl = 'http://'.$ENV{HTTP_HOST} if ($keys{imageurl} eq '');
    my %in = (
  	'imagepath' => $imagepath,
  	'imageurl' => $imageurl
    );
    $template = new Template('tmpl/setup/step1.html');
    $main = new Template('tmpl/setup/main.html');
    $main->replace('content', $template->{code});
    $main->replace_hash(%in);
    print $main->{code};
    exit;
  }
}

sub Step2 {
  if ($keys{dbname}) {
    print "Content-type: text/html\n\n";
    my @info;
    my $flag = 0;
    open FILE, ">logon.pl" or $flag = 1;
    if ($flag == 1) {
      my %in = ('message' => 'create file error', 'info' => "Cannot create file logon.pl ($!)");
      @info = (@info, \%in);
      $flag = 0;
    } else {
      print FILE <<AAA;
use DBI;
sub login {
  \$dbh = DBI->connect("DBI:mysql:$keys{dbname}:$keys{dbhost}", '$keys{dbuser}', '$keys{dbpasswd}') || print "Can't connect: \$DBI::errstr\n";
  return \$dbh;
}
1;
AAA
      close FILE;
    }
    $dbh = DBI->connect("DBI:mysql:$keys{dbname}:$keys{dbhost}", "$keys{dbuser}", "$keys{dbpasswd}") or $flag = 1;
    if ($flag == 1) {
      my %in = ('message' => 'mysql error', 'info' => "Cannot connect to mysql: $DBI::errstr");
      @info = (@info, \%in);
      $flag = 0;
    } else {
      my @q = (
      	"CREATE TABLE $ver\_adminlog (ip varchar(15) default NULL, d datetime default NULL, name varchar(200) NOT NULL default '')",
	"CREATE TABLE $ver\_banners (  id bigint(20) NOT NULL auto_increment,  name varchar(200) default NULL,  parent bigint(20) NOT NULL default '0',  b_type enum('image','swf','dcr','rpm','mov','html','js','java') default NULL,  active enum('active','disable') default NULL,  stop enum('show','click','date') default NULL,  url text,  bantext text,  initshow bigint(20) NOT NULL default '0',  initclick bigint(20) NOT NULL default '0',  b_desc text,  day date NOT NULL default '2000-00-00',  b_width int(11) NOT NULL default '0',  b_height int(11) NOT NULL default '0',  ext varchar(100) default NULL,  clicked bigint(20) NOT NULL default '0',  showed bigint(20) NOT NULL default '0',  downtext text,  weight int(11) NOT NULL default '1',  sendstat int(11) NOT NULL default '0',  statemail varchar(200) default NULL,  whensendstat int(11) NOT NULL default '0',  wday int(11) NOT NULL default '0',  mday int(11) NOT NULL default '0',  dhour int(11) NOT NULL default '0',  dmin int(11) NOT NULL default '0',  whour int(11) NOT NULL default '0',  wmin int(11) NOT NULL default '0',  mhour int(11) NOT NULL default '0',  mmin int(11) NOT NULL default '0',  PRIMARY KEY  (id))",
      	"CREATE TABLE $ver\_show2click (  bid bigint NOT NULL default '0',  d datetime default NULL,  s_code varchar(100) default NULL,  ip varchar(15) default NULL)",
	"CREATE TABLE $ver\_show2page (  bid bigint(20) NOT NULL default '0',  d datetime default NULL,  page varchar(100) default NULL,  ip varchar(15) default NULL)",
      	"CREATE TABLE $ver\_stat (  bid bigint NOT NULL default '0',  d date default NULL,  clicks bigint NOT NULL default '0',  shows bigint NOT NULL default '0',  h int(11) NOT NULL default '0')",
      	"CREATE TABLE $ver\_types (  id bigint NOT NULL auto_increment,  name varchar(200) default NULL,  t_desc text,  PRIMARY KEY  (id))",
      	"INSERT INTO $ver\_types VALUES (1,'Main campaign','main campaign')",
      	"CREATE TABLE $ver\_users (  id bigint NOT NULL auto_increment,  name varchar(200) NOT NULL default '',  last_d datetime default NULL,  last_ip varchar(15) default NULL,  email varchar(200) default NULL,  url varchar(200) default NULL,  access enum('superuser','campaignadmin','banneradmin','statuser') default NULL,  passwd varchar(200) default NULL,  descr text,  PRIMARY KEY  (id))",
      	"CREATE TABLE $ver\_users2banners (  uid bigint NOT NULL default '0',  bid bigint NOT NULL default '0')"
      );
      for $q (@q) {
        $sth = $dbh->prepare($q);
        $sth->execute() or $flag = 1;
        if ($flag == 1) {
          my %in = ('message' => 'sql error', 'info' => "Cannot run query: $q (".$sth->errstr.")");
          @info = (@info, \%in);
          $flag = 0;
        }
      }
    }

    my $main = new Template('tmpl/setup/main.html');
    $template = new Template('tmpl/setup/step2.5.html');
    $main->replace('content', $template->{code});
    if ($#info >= 0) {
      my $info = $main->get_area('info-area');
      $main->make_for_array('info-area', $info, @info);
    } else {
      $main->replace('info-area', $main->get_area('no-info'));
    }
    $main->clear_areas('info-area', 'no-info');
    print $main->{code};
    exit;
  } else {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/setup/step2.html');
    $main = new Template('tmpl/setup/main.html');
    $main->replace('content', $template->{code});
    print $main->{code};
    exit;
  }
}

sub Step3 {
  if ($keys{login} ne '') {
    print "Content-type: text/html\n\n";
    my $flag = 0;
    my @info;
    $dbh = login();
    my $login = $dbh->quote($keys{login});
    my $passwd = $dbh->quote($keys{passwd});
    $q = "INSERT INTO $ver\_users VALUES (1,$login,'','','','','superuser',$passwd,'')";
    $sth = $dbh->prepare($q);
    $sth->execute() or $flag = 1;
    if ($flag == 1) {
      my %in = ('message' => 'sql error', 'info' => "Cannot run query: $q (".$sth->errstr.")");
      @info = (@info, \%in);
      $flag = 0;
    }

    my $main = new Template('tmpl/setup/main.html');
    $template = new Template('tmpl/setup/step3.5.html');
    $main->replace('content', $template->{code});
    if ($#info >= 0) {
      my $info = $main->get_area('info-area');
      $main->make_for_array('info-area', $info, @info);
    } else {
      $main->replace('info-area', $main->get_area('no-info'));
    }
    $main->clear_areas('info-area', 'no-info');
    print $main->{code};
    exit;
  } else {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/setup/step3.html');
    $main = new Template('tmpl/setup/main.html');
    $main->replace('content', $template->{code});
    print $main->{code};
    exit;
  }
}

sub am_copydir {
  my ($from, $to) = @_;
  my $flag = 0;
  my @info = ();
  opendir DIR, "$from" or $flag = 1;
  if ($flag == 1) {
    my %in = ('message' => 'opendir error', 'info' => "cannot opendir $from ($!)");
    @info = (@info, \%in);
    $flag = 0;
  } else {
    my @files = readdir DIR;
    closedir DIR;
    my $file;
    for $file (@files) {
      if (-d("$from/$file")) {
        next if ($file eq 'am_v2_3');
        if (($file ne '.')and($file ne '..')) {
          mkdir("$to/$file", 0777) or ($flag = 1);
          if ($flag == 1) {
            my %in = ('message' => 'mkdir error', 'info' => "Cannot mkdir $to/$file ($!)");
            @info = (@info, \%in);
            $flag = 0;
          } else {
            @info = (@info, am_copydir("$from/$file", "$to/$file"));
          }
        }
      } elsif (-e("$from/$file")) {
        copy("$from/$file", "$to/$file") or $flag = 1;
        if ($flag == 1) {
          my %in = ('message' => 'copy file error', 'info' => "Cannot copy file $from/$file to $to/$file ($!)");
          @info = (@info, \%in);
          $flag = 0;
        }
      }
    }
  }
  return @info;
}