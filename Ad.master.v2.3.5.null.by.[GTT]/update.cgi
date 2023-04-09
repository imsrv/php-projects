#!/usr/bin/perl

use IO::Socket;
#print "Content-type: text/html\n\n";

#########################################################################
###    Supplied by Shadoff [GTT]    Nullified by Vorga1664 [GTT]      ###
###              Grinderz Translation Team '2004                      ###
#########################################################################

use CGI::Carp qw(fatalsToBrowser); 
use strict;
use Template;
use svars;

require 'site.pl';
require 'logon.pl';
my %keys = parse_form();
my %cookie = parse_cookie();

my $ver = 'am_v2_3';

my $dbh = login();


if (-e('./install.cgi')) {
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  my $template = new Template('tmpl/install.exists.html');
  $template->print(%keys);
  exit;
}

&Settings();



sub Settings {
  if ($keys{action} eq 'set') {
    print "Content-type: text/html\n\n";
    my @q = (
	"alter table $ver\_banners add column weight int(11) NOT NULL default '1', add column  sendstat int(11) NOT NULL default '0', add column  statemail varchar(200) default NULL, add column  whensendstat int(11) NOT NULL default '0', add column  wday int(11) NOT NULL default '0', add column  mday int(11) NOT NULL default '0', add column  dhour int(11) NOT NULL default '0', add column  dmin int(11) NOT NULL default '0', add column  whour int(11) NOT NULL default '0', add column  wmin int(11) NOT NULL default '0', add column  mhour int(11) NOT NULL default '0', add column  mmin int(11) NOT NULL default '0'",
	"CREATE TABLE $ver\_show2page (  bid bigint(20) NOT NULL default '0',  d datetime default NULL,  page varchar(100) default NULL,  ip varchar(15) default NULL)"
    );
    for my $q(@q) {
      $dbh->do($q) or push @info, {'message' => 'mysql error', 'info' => $dbh->errstr};
    }

    my $template = new Template('tmpl/svars.pm');
    my $ignoreIP = "'".(join '\', \'',grep {/\d/} ( @ignoreIP))."'";
    my %in = (
    	'dupviewtime' => sprintf("%d", $dupviewtime),
    	'dupclicktime' => sprintf("%d", $dupclicktime),
    	'maxbannersize' => sprintf("%d", $maxbannersize),
    	'ignoreIP' => $ignoreIP,
    	'server_path' => $vars_server_url,
    	'sendmail_path' => $vars_path_to_sendmail,
    	'imagesurl' => $vars_path_to_images,
    	'imagespath' => $vars_path_to_images_shell,
    );
    $template->replace_hash(%in);
    open FILE, ">svars.pm";
    print FILE $template->{code};
    close FILE;
    $template = new Template('tmpl/settings2.html');
    $template->replace('info-area', $template->get_area('no-info'));
    $template->clear_area('main_form');
    $template->clear_area('clear');
    $template->print(%keys);
#    print "Location: admin.cgi?page=settings\n\n";
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  my $template = new Template('tmpl/settings2.html');
  my $ignoreIP = join ' ', @ignoreIP;
  my %in = (
  	'timeview' => $dupviewtime,
  	'timeclick' => $dupclicktime,
  	'ignoreIP' => $ignoreIP,
  	'maxbannersize' => $maxbannersize,
  	'installurl' => s_q($vars_server_url),
  	'sendmailpath' => Template->text_replace_tags(s_q($vars_path_to_sendmail)),
  	'imagesurl' => $vars_path_to_images,
  	'imagespath' => $vars_path_to_images_shell
  );
  $template->replace_hash(%in);
  $template->clear_area('error-area');
  $template->clear_area('clear');
  $template->print(%keys);
  exit;
}

=item
sub Settings {
  my $template;
  if ($keys{action} eq 'set') {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/svars.pm');
    my %in = (
    	'adminlogin' => $admin_login,
    	'adminpassword' => $admin_password,
    	'server_path' => s_q($vars_server_url),
    	'sendmail_path' => s_q($vars_sendmail_path),
	'tar_path' => s_q($vars_tar_path),
    	'imagesurl' => $vars_images_url,

    );
    $template->replace_hash(%in);
    my @info = ();
    open FILE, ">svars.pm" or push (@info, {'message' => "cannot open file svars.pm", 'info' => $!});
    print FILE $template->{code};
    close FILE;

    $template = new Template('tmpl/admin/main2.html', 'content', 'tmpl/admin/settings2.html');

    if ($#info >= 0) {
      $template->make_for_array('info-area', $template->get_area('info-area'), @info);
    } else {
      $template->replace('info-area', $template->get_area('no-info'));
      $template->clear_area('error_area');
    }
    $template->clear_areas('info-area', 'no-info', 'clear', 'main_form');
    $template->Translate();
    print $template->{code};
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/admin/main2.html', 'content', 'tmpl/admin/settings2.html');
  my %in = (
    	'adminlogin' => $admin_login,
    	'adminpassword' => $admin_password,
    	'server_path' => $vars_server_url,
    	'sendmail_path' => $vars_sendmail_path,
	'tar_path' => $vars_tar_path,
    	'imagesurl' => $vars_images_url
  );
  $template->replace_hash(%in);
  $template->clear_areas('clear', 'info-area', 'error-area');
  $template->Translate();
  $template->print(%keys);
  exit;
}
=cut


sub postDoc {
  my ($in, $param) = @_;
  $in =~ s/^http:\/\///g;
  my ($host, $doc) = split /\//, $in, 2;
  my ($soc, @doc, @refs, $i, @refsToGroup, $r, $curRef, $get, @b, @mails);

  $soc = IO::Socket::INET->new( PeerAddr => $host,
                                PeerPort => 80,
                                Proto => 'tcp',
                                Type => SOCK_STREAM) or return "$! cannot connect to $host";

  return if (!$soc);
  my $post_data = $param;
  my $l = length($post_data);

  my $post = "POST /$doc HTTP/1.0
Host: $host
Content-Type: application/x-www-form-urlencoded
Content-Length: $l

$post_data\n\n";

  print $soc $post;


  @doc = <$soc>;
  close $soc;
  $doc = join '', @doc;
  my ($head, $body) = split "\r*\n\r*\n", $doc, 2;

  return $body;
}
