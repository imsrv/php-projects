#!/usr/bin/perl

#########################################################################
###    Supplied by Shadoff [GTT]    Nullified by Vorga1664 [GTT]      ###
###              Grinderz Translation Team '2004                      ###
#########################################################################

use CGI::Carp qw(fatalsToBrowser);

use lib 'lib';
use strict;
use Cwd;
use File::Copy;

use Template;
use svars;


require 'site.pl';
require 'logon.pl';

my %keys = parse_form();
my %cookie = parse_cookie();
my $ver = 'acc14';


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
  if ($keys{page} eq 'step1') 
  {
    print "Content-type: text/html\n\n";
    $flag = 0;
    my $dir = cwd();
    chdir("$keys{imagepath}") or $flag = 1;
    if ($flag == 1) {
      my %in = ('message' => 'chdir error:', 'info' => "Cannot chdir $keys{images} ($!)");
      @info = (@info, \%in);
      $flag = 0;
    } else 
    {
      mkdir('acc14', 0777) or $flag = 1;
      if ($flag == 1) {
        my %in = ('message' => 'mkdir error:', 'info' => "Cannot mkdir $keys{imagepath}/acc14 ($!)");
        @info = (@info, \%in);
        $flag = 0;
      }
      chdir($dir);
      $keys{imagepath}.= '/' if ($keys{imagepath} !~ /\/$/);
      $keys{imageurl}.= '/' if ($keys{imageurl} !~ /\/$/);
      $keys{imagepath}.= 'acc14';
      $keys{imageurl}.= 'acc14/';
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
        	'server_path' => $vars_server_url,
        	'dns-ip' => '',
		'emails-on-page' => 20,
		'site-name' => $keys{sitename},  
      );
      $template->replace_hash(%in);
      open FILE, '>lib/svars.pm' or $flag = 1;
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
"CREATE TABLE acc14_adminlog (  ip varchar(15) default NULL,  d datetime default NULL,  name varchar(200) NOT NULL default '',  country varchar(100) default NULL)",
"CREATE TABLE acc14_attache (  id bigint(20) NOT NULL auto_increment,  atype enum('footer','header','html','body','attache','nottemplate') default NULL,  name varchar(200) default NULL,  cont mediumblob,  path text,  content_type varchar(200) default NULL,  user_id bigint(20) NOT NULL default '0',  PRIMARY KEY  (id))",
"CREATE TABLE acc14_bulk (  id bigint(20) NOT NULL auto_increment,  params text,  done int(11) NOT NULL default '0',  processed bigint(20) NOT NULL default '0',  start_date date default NULL,  start_hour int(11) default NULL,  lid bigint(20) NOT NULL default '0',  notify_email text,  startat datetime, endat datetime, seen bigint not null, undelivered bigint not null, PRIMARY KEY  (id))",
"CREATE TABLE acc14_copy (  id bigint(20) NOT NULL auto_increment,  processed bigint(20) NOT NULL default '0',  dest bigint(20) NOT NULL default '0',  source bigint(20) NOT NULL default '0',  grp bigint(20) NOT NULL default '0',  status varchar(200) default NULL,  done int(11) NOT NULL default '0',  PRIMARY KEY  (id))",
"CREATE TABLE acc14_deldup (  id bigint(20) NOT NULL auto_increment,  done int(11) NOT NULL default '0',  processed bigint(20) NOT NULL default '0',  tid bigint(20) NOT NULL default '0',  PRIMARY KEY  (id))",
"CREATE TABLE acc14_export (  id bigint(11) NOT NULL auto_increment,  pid bigint(20) NOT NULL default '0',  param text,  d datetime default NULL,  done int(11) NOT NULL default '0',  exp_fields text,  report_type varchar(200) default NULL,  point int(11) NOT NULL default '0',  processed bigint(11) NOT NULL default '0',  confirmemail varchar(100) NOT NULL default '',  PRIMARY KEY  (id))",
"CREATE TABLE acc14_filter (  id int(11) NOT NULL auto_increment,  sid bigint(20) NOT NULL default '0',  filter text,  period varchar(200) default NULL,  e_type varchar(200) default NULL,  u_type varchar(200) default NULL,  done int(11) NOT NULL default '0',  PRIMARY KEY  (id))",
"CREATE TABLE acc14_import (  id bigint(20) NOT NULL auto_increment,  pid bigint(20) NOT NULL default '0',  source varchar(100) default NULL,  sendconfirm int(11) NOT NULL default '0',  sendadminconfirm varchar(200) default NULL,  mysqlhost varchar(200) default NULL,  mysqldatabase varchar(200) default NULL,  mysqllogin varchar(200) default NULL,  mysqlpassword varchar(200) default NULL,  mysqltable varchar(200) default NULL,  done int(11) NOT NULL default '0',  processed bigint(20) NOT NULL default '0',  imp_fields varchar(200) default NULL,  to_fields text,  sid bigint(20) NOT NULL default '0',  setapproved int(11) NOT NULL default '0',  setdisabled int(11) NOT NULL default '0',  PRIMARY KEY  (id))",
"CREATE TABLE acc14_letters (  id bigint(20) NOT NULL auto_increment,  subject text NOT NULL,  text_letter mediumtext,  from_field varchar(200) default NULL,  sub bigint(20) NOT NULL default '0',  delay_min bigint(20) NOT NULL default '0',  sid bigint(20) NOT NULL default '0',  done int(11) NOT NULL default '0',  footer_id bigint(20) NOT NULL default '0',  header_id bigint(20) NOT NULL default '0',  body_id bigint(20) NOT NULL default '0',  html_ids text,  attache_ids text,  delay_type enum('min','hour','day','week','month') default NULL,  additional_header text,  shedule int(11) NOT NULL default '0',  dayly_hour int(11) NOT NULL default '0',  dayly_min int(11) NOT NULL default '0',  weekly_day int(11) NOT NULL default '0',  weekly_hour int(11) NOT NULL default '0',  weekly_min int(11) NOT NULL default '0',  monthly_day int(11) NOT NULL default '0',  monthly_hour int(11) NOT NULL default '0',  monthly_min int(11) NOT NULL default '0',  PRIMARY KEY  (id))",
"CREATE TABLE acc14_stat (  id bigint(20) NOT NULL auto_increment,  sid bigint(20) NOT NULL default '0',  col bigint(20) NOT NULL default '0',  unsub bigint(20) NOT NULL default '0',  dup bigint(20) NOT NULL default '0',  checked bigint(20) NOT NULL default '0',  bad bigint(20) NOT NULL default '0',  d date default NULL,  h int(11) NOT NULL default '0',  PRIMARY KEY  (id))",
"CREATE TABLE acc14_types (  id bigint(20) NOT NULL auto_increment,  name varchar(200) default NULL,  t_desc text,  col bigint(20) NOT NULL default '0',  dupes bigint(20) NOT NULL default '0',  checked bigint(20) NOT NULL default '0',  bad bigint(20) NOT NULL default '0',  point_export datetime default NULL,  unsub bigint(20) NOT NULL default '0',  save_dupes enum('save','kill','replace') default 'save',  point_send datetime default NULL,  unpage text,  admin_email varchar(200) default NULL,  col_on_page bigint(20) NOT NULL default '0',  active_days bigint(20) NOT NULL default '0',  subscribe_html text,  subscribe_url text,  unsubscribe_html text,  unsubscribe_url text,  subscribe_text_url int(11) NOT NULL default '0',  unsubscribe_text_url int(11) NOT NULL default '0',  send_confirm_subscribe int(11) NOT NULL default '0',  send_confirm_unsubscribe int(11) NOT NULL default '0',  confirm_subscribe_email varchar(200) default NULL,  confirm_unsubscribe_email varchar(200) default NULL,  confirm_subscribe_subject varchar(200) default NULL,  confirm_unsubscribe_subject varchar(200) default NULL,  confirm_subscribe_message text,  confirm_unsubscribe_message text,  use_autoresponce int(11) NOT NULL default '0',  autoresponce_email varchar(200) default NULL,  autoresponce_host varchar(200) default NULL,  autoresponce_login varchar(200) default NULL,  autoresponce_password varchar(200) default NULL,  autoresponce_emails int(11) NOT NULL default '0',  processing_emails text,  use_approve int(11) NOT NULL default '0',  send_approve int(11) NOT NULL default '0',  approve_email varchar(200) default NULL,  approve_subject text,  approve_message text,  send_notapprove int(11) NOT NULL default '0',  notapprove_email varchar(200) default NULL,  notapprove_subject text,  notapprove_message text,  autoresponce_deleteletters int(11) NOT NULL default '0',  create_date date default NULL,  change_date date default NULL,  use_confirm_url int(11) NOT NULL default '0',  subscribe_confirm_text_url int(11) NOT NULL default '0',  subscribe_confirm_html text,  subscribe_confirm_url text,  parent bigint(20) NOT NULL default '0',  dayly_stats text,  weekly_stats text,  monthly_stats text,  user_id int(11) NOT NULL default '0',  PRIMARY KEY  (id))",
"CREATE TABLE acc14_users (  id bigint(20) NOT NULL auto_increment,  name varchar(200) NOT NULL default '',  last_d datetime default NULL,  last_ip varchar(15) default NULL,  email varchar(200) default NULL,  url varchar(200) default NULL,  passwd varchar(200) default NULL,  descr text,  send_login int(11) NOT NULL default '0',  firstname varchar(200) default NULL,  lastname varchar(200) default NULL,  address varchar(200) default NULL,  city varchar(200) default NULL, state varchar(200) default NULL,  zip varchar(20) default NULL,  country varchar(200) default NULL,  phone varchar(200) default NULL,  start_date date default '2000-01-01',  end_date date default '2000-01-01',  allow_create_camp_bool int(11) NOT NULL default '0',  allow_create_camp_limit bigint(20) NOT NULL default '0',  allow_create_camp_limit_bool int(11) NOT NULL default '0',  other_camp_edit text,  other_camp_stat text,  end_date_bool int(11) NOT NULL default '0',  last_country char(3) default NULL,  type int(11) NOT NULL default '0',  PRIMARY KEY  (id))",
"cREATE TABLE acc14_settings (  header_html text,  footer_html text,  update_url varchar(250) default NULL,  returnemail varchar(200) NOT NULL default '',  returnhost varchar(200) NOT NULL default '',  returnlogin varchar(200) NOT NULL default '',  returnpassword varchar(200) NOT NULL default '')",
"insert into acc14_settings set header_html = ''",
"CREATE TABLE acc14_undeliver (  bid bigint(20) NOT NULL default '0',  email varchar(200) NOT NULL default '')",
"INSERT INTO acc14_types VALUES (1, '', '', 0, 0, 0, 0, NULL, 0, 'replace', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', 0, NULL, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, 0)",


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
    my $email = $dbh->quote($keys{email});
$q = "INSERT INTO $ver\_users VALUES (1, $login, '', '', $email, '', $passwd, '', 0, '', '', '', '', '', '', '', '', '2000-01-01', '2000-01-01', 0, 0, 0, '', '', 0, '', 0)";
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
        next if ($file eq 'acc14');
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