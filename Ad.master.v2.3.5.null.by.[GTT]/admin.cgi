#!/usr/bin/perl

#########################################################################
###    Supplied by Shadoff [GTT]    Nullified by Vorga1664 [GTT]      ###
###              Grinderz Translation Team '2004                      ###
#########################################################################

use lib './';
use strict;

use Template;
use svars;
use CGI::Carp qw(fatalsToBrowser); 
use IO::Socket;

use vars qw($user_type);

require 'site.pl';
require 'logon.pl';

my %keys = parse_form();
my %cookie = parse_cookie();
my $ver = 'am_v2_3';


my $dbh = login();
my ($sth, $row, $template, $q);

if ($keys{page} eq 'login') {
  &UserLogin();
}


&CheckLogin();

if (-e('install.cgi')) {
  print "Content-type: text/html\n\n";
  $template = new Template('tmpl/install.exists.html');
  print $template->{code};
  exit;

}


my $initialuserid = 0;

$user_type = get_user_type();



if ($user_type eq 'banneradmin') {
  my $bid = sprintf("%d", $keys{bid});
  $q = "select bid from $ver\_users2banners as users2banners where uid=$initialuserid and bid=$bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($sth->rows > 0) {
    if ($keys{page} eq 'statip') {
      &StatIP();
    }
    if ($keys{page} eq 'bcode') {
      &GetBannerCode();
    }
    if ($keys{page} eq 'editbanner') {
      &AddNewBanner();
    }
    if ($keys{page} eq 'addnewbanner') {
      &AddNewBanner();
    }
    if ($keys{page} eq 'viewbanner') {
      &ViewBanner();
    }
    if ($keys{page} eq 'hourbannerstat') {
      &StatHourBanners();
    }
    if ($keys{page} eq 'changestatus') {
      &ChangeStatus();
    }
    if ($keys{page} eq 'deletebanner') {
      &DeleteBanner();
    }
    if ($keys{page} eq 'statcampaignyear') {
      &StatCampaignYear();
    }
  }
  if ($keys{page} eq 'bannergo') {
    &NavigateBanners_banner();
  }
  if ($keys{page} eq 'logout') {
    &Logout();
  }
  &main_banner();
}

if ($user_type eq 'statuser') {
  my $bid = sprintf("%d", $keys{bid});
  $q = "select bid from $ver\_users2banners as users2banners where uid=$initialuserid and bid=$bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($sth->rows > 0) {
    if ($keys{page} eq 'statip') {
      &StatIP();
    }
    if ($keys{page} eq 'bcode') {
      &GetBannerCode();
    }
    if ($keys{page} eq 'viewbanner') {
      &ViewBanner_stat();
    }
    if ($keys{page} eq 'hourbannerstat') {
      &StatHourBanners();
    }
    if ($keys{page} eq 'statcampaignyear') {
      &StatCampaignYear();
    }
  }
  if ($keys{page} eq 'logout') {
    &Logout();
  }
  if ($keys{page} eq 'bannergo') {
    &NavigateBanners_banner();
  }
  &main_stat();
}


if ($user_type eq 'campaignadmin') {
  if ($keys{page} eq 'statip') {
    &StatIP();
  }
  if ($keys{page} eq 'updatelisting') {
    &UpdateListing();
  }
  if ($keys{page} eq 'edittype') {
    &EditType();
  }
  if ($keys{page} eq 'deletebanner') {
    &DeleteBanner();
  }
  if ($keys{page} eq 'banners') {
    &ShowBannerArea();
  }
  if ($keys{page} eq 'addnewbanner') {
    &AddNewBanner();
  }
  if ($keys{page} eq 'editbanner') {
    &AddNewBanner();
  }
  if ($keys{page} eq 'viewbanner') {
    &ViewBanner();
  }
  if ($keys{page} eq 'deletetype') {
    &DeleteType();
  }
  if ($keys{page} eq 'bcode') {
    &GetBannerCode();
  }
  if ($keys{page} eq 'getcamcode') {
    &GetCampagnCode();
  }
  if ($keys{page} eq 'changestatus') {
    &ChangeStatus();
  }
  if ($keys{page} eq 'bannergo') {
    &NavigateBanners();
  }
  if ($keys{page} eq 'logout') {
    &Logout();
  }
  if ($keys{page} eq 'hourbannerstat') {
    &StatHourBanners();
  }
  if ($keys{page} eq 'statcampaignyear') {
    &StatCampaignYear();
  }

  &main_campadmin();
}


if ($user_type eq 'superuser') {
  if ($keys{page} eq 'statip') {
    &StatIP();
  }
  if ($keys{page} eq 'updatelisting') {
    &UpdateListing();
  }
  if ($keys{page} eq 'statcampaignyear') {
    &StatCampaignYear();
  }
  if ($keys{page} eq 'addnewtype') {
    &AddNewType();
  }
  if ($keys{page} eq 'deletebanner') {
    &DeleteBanner();
  }
  if ($keys{page} eq 'edittype') {
    &EditType();
  }
  if ($keys{page} eq 'banners') {
    &ShowBannerArea();
  }
  if ($keys{page} eq 'addnewbanner') {
    &AddNewBanner();
  }
  if ($keys{page} eq 'editbanner') {
    &AddNewBanner();
  }
  if ($keys{page} eq 'viewbanner') {
    &ViewBanner();
  }
  if ($keys{page} eq 'deletetype') {
    &DeleteType();
  }
  if ($keys{page} eq 'bcode') {
    &GetBannerCode();
  }
  if ($keys{page} eq 'getcamcode') {
    &GetCampagnCode();
  }
  if ($keys{page} eq 'changestatus') {
    &ChangeStatus();
  }
  if ($keys{page} eq 'bannergo') {
    &NavigateBanners();
  }
  if ($keys{page} eq 'log') {
    &Log();
  }
  if ($keys{page} eq 'users') {
    &UsersArea();
  }
  if ($keys{page} eq 'logout') {
    &Logout();
  }
  if ($keys{page} eq 'adduser') {
    &AddUser();
  }
  if ($keys{page} eq 'adduser2') {
    &AddUserStep2();
  }
  if ($keys{page} eq 'deleteuser') {
    &DeleteUser();
  }
  if ($keys{page} eq 'edituser') {
    &EditUser();
  }
  if ($keys{page} eq 'edituser2') {
    &AddUserStep2();
  }
  if ($keys{page} eq 'viewuser') {
    &ViewUser();
  }
  if ($keys{page} eq 'settings') {
    &Settings();
  }
  if ($keys{page} eq 'hourbannerstat') {
    &StatHourBanners();
  }
  &main();
}




sub main {
  my $cookie = '';
  $cookie = "\nSet-cookie: order_camp=$keys{order}" if ($keys{order});
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache$cookie\n\n";
  $keys{order} = $cookie{order_camp} if ($keys{order} eq '');

  my $stat_total_banners = 0;
  my $stat_expired_banners = 0;
  my $stat_active_banners = 0;

  $template = new Template('tmpl/index.html');

  $q = "select id, name from $ver\_types as types";

  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  my %list_id;
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'id' => $row->{id},
	'name' => $row->{name},
	'shows' => 0,
	'clicks' => 0,
	'showstoday' => 0,
	'clickstoday' => 0,
	'cps' => 0,
	'cpstoday' => 0,
	'count' => 0
    );
    @list = (@list, \%in);
    $list_id{$row->{id}} = $#list;
  }
  $sth->finish();

  $q = "select parent as id, count(id) as col, sum(clicked) as clicks, sum(showed) as shows from $ver\_banners as banners group by parent";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$list_id{$row->{id}}]->{clicks} = $row->{clicks};
    $list[$list_id{$row->{id}}]->{shows} = $row->{shows};
    $list[$list_id{$row->{id}}]->{count} = $row->{col};
    $list[$list_id{$row->{id}}]->{cps} = sprintf("%.02f", 100*$row->{clicks}/$row->{shows}) if ($row->{shows} > 0);
    $stat_total_banners += $row->{col};
  }
  $sth->finish();

  $q = "select banners.parent as id, sum(stat.clicks) as clicks, sum(stat.shows) as shows from $ver\_stat as stat, $ver\_banners as banners where stat.bid=banners.id and stat.d=now() group by banners.parent";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$list_id{$row->{id}}]->{clickstoday} = $row->{clicks};
    $list[$list_id{$row->{id}}]->{showstoday} = $row->{shows};
    $list[$list_id{$row->{id}}]->{cpstoday} = sprintf("%.02f", 100*$row->{clicks}/$row->{shows}) if ($row->{shows} > 0);
  }
  $sth->finish();

  my $down_arrow = $template->get_area('down_arrow');
  my $top_arrow = $template->get_area('top_arrow');
  $template->clear_areas('down_arrow', 'top_arrow');

  ($template, @list) = sort_main_page($template, $down_arrow, $top_arrow, @list);

  my %rplc = (
	'order-types' => '',
	'types-sort-image' => '',
	'order-col' => '',
	'col-sort-image' => '',
	'order-show' => '',
	'show-sort-image' => '',
	'order-click' => '',
	'click-sort-image' => '',
	'order-acps' => '',
	'acps-sort-image' => '',
	'order-acpst' => '',
	'acpst-sort-image' => ''
  );

  $template->replace_hash(%rplc);


  my $t = $template->get_area('types-lines');

  $template->make_for_array('types-lines', $t, @list);
  $template->clear_area('types-lines');

  #stat-year#


  #stat-week#

  my $statline = $template->get_area('stat-week');
  $template->clear_area('stat-week');
  @list = ();
  my $i;
  for ($i = 0; $i<7; $i++) {
    my %in = (
	'day' => $i,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
    );
    @list = (@list, \%in);
  }
  $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, stat.d as d, to_days(now()) - to_days(d) as dif from $ver\_stat as stat, $ver\_banners as banners where stat.bid=banners.id and to_days(now()) - to_days(d)<7 group by stat.d";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    next if ($row->{dif} < 0);
    $list[$row->{dif}]->{clicks} = $row->{clicks};
    $list[$row->{dif}]->{shows} = $row->{shows};
    $list[$row->{dif}]->{date} = $row->{d};
  }
  my $max_clicks = 0;
  my $max_shows = 0;
  my $min_clicks = 1000000;
  my $min_shows = 1000000;
  $q = "select curdate()";
  for ($i = 1; $i<7; $i++) {
    $q .= ", date_sub(curdate(), interval $i day)";
  }
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  $row = $sth->fetchrow_arrayref;
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{date} = $row->[$i];
  }

  for ($i = 0; $i<7; $i++) {
    $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
    $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
    $min_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} < $min_clicks);
    $min_shows = $list[$i]->{shows} if ($list[$i]->{shows} < $min_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{clicks_height} = sprintf("%d", 200*($list[$i]->{clicks}-($min_clicks*6)/7)/($max_clicks-$min_clicks*6/7));
    $list[$i]->{shows_height} = sprintf("%d", 200*($list[$i]->{shows}-$min_shows*6/7)/($max_shows-$min_shows*6/7));
  }
  $template->make_for_array('stat-week', $statline, reverse @list);

  #stat banners#
  $template->replace('stat-total-banners', $stat_total_banners);
  $q = "select to_days(now()) as tdn, to_days(day) as tdd, curdate() as now, day, initclick, initshow, showed, clicked, stop, active from $ver\_banners as banners";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    if (($row->{day} eq '2000-00-00')and($row->{stop} eq 'date')) {
      $stat_active_banners++ if ($row->{active} eq 'active');
    } elsif (($row->{stop} eq 'show')and(($row->{initshow}>$row->{showed})or($row->{initshow} == 0))) {
      $stat_active_banners++ if ($row->{active} eq 'active');
    } elsif (($row->{stop} eq 'click')and(($row->{initclick} > $row->{clicked})or($row->{initclick} == 0))) {
      $stat_active_banners++ if ($row->{active} eq 'active');
    } elsif (($row->{stop} eq 'date')and($row->{tdn} > $row->{tdd})) {
      $stat_active_banners++ if ($row->{active} eq 'active');
    }

    if (($row->{stop} eq 'date')and(($row->{day} cmp $row->{now}) == -1)and($row->{day} ne '2000-00-00')) {
      $stat_expired_banners++;
    } elsif (($row->{stop} eq 'click')and($row->{initclick}<=$row->{clicked})and($row->{initclick} != 0)) {
      $stat_expired_banners++;
    } elsif (($row->{stop} eq 'show')and($row->{initshow} <= $row->{showed})and($row->{initshow} != 0)) {
      $stat_expired_banners++;
    }
  }
  $template->replace('stat-active-banners', $stat_active_banners);
  $template->replace('stat-expired-banners', $stat_expired_banners);

  #stat-day#

  my $statline = $template->get_area('stat-day');
  $template->clear_area('stat-day');
  @list = ();
  for ($i = 0; $i<12; $i++) {
    my %in = (
	'day' => $i,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
    );
    @list = (@list, \%in);
  }
  my $floor = "FLOOR((unix_timestamp(now()) - unix_timestamp(date_add(d, interval h hour)))/3600)";
  $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, date_add(stat.d, interval h hour) as d, stat.h as h, $floor as dif from $ver\_stat as stat, $ver\_banners as banners where stat.bid=banners.id and $floor < 12 group by $floor order by $floor";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    next if ($row->{dif} < 0);
    $list[$row->{dif}]->{clicks} = $row->{clicks};
    $list[$row->{dif}]->{shows} = $row->{shows};
    $list[$row->{dif}]->{date} = $row->{d};
  }
  my $max_clicks = 0;
  my $min_clicks = 1000000;
  my $max_shows = 0;
  my $min_shows = 1000000;

  for ($i = 0; $i<12; $i++) {
    $list[$i]->{date} = {$i};
  }


  for ($i = 0; $i<12; $i++) {
    $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
    $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
    $min_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} < $min_clicks);
    $min_shows = $list[$i]->{shows} if ($list[$i]->{shows} < $min_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<12; $i++) {
    $list[$i]->{clicks_height} = sprintf("%d", 200*($list[$i]->{clicks}-$min_clicks*2/3)/($max_clicks-$min_clicks*2/3));
    $list[$i]->{shows_height} = sprintf("%d", 200*($list[$i]->{shows}-$min_shows*2/3)/($max_shows-$min_shows*2/3));
    $list[$i]->{date} = -$i." h";
  }
  $template->make_for_array('stat-day', $statline, reverse @list);

  $template->print(%keys);
}



sub AddNewBanner {
#print "Content-type: text/html\n\n";
  if ($keys{action} eq 'addnewbanner') {
    my $name = $dbh->quote($keys{banname});
    my $desc = $dbh->quote($keys{bandesc});
    my $tid = sprintf("%d", $keys{tid});
    my $bid = sprintf("%d", $keys{bid});
    my %bantype = ('image'=>1, 'swf'=>1, 'dcr'=>1, 'rpm'=>1, 'mov'=>1, 'html'=>1, 'js'=>1, 'java'=>1);
    my %banstop = ('show'=>1, 'click'=>1, 'date'=>1);

    my $banner_type = 'image';
    if ($bantype{$keys{bantype}} eq '1') {
      $banner_type = $keys{bantype};
    }
    $banner_type = $dbh->quote($banner_type);

    my $banner_stop = 'show';
    if ($banstop{$keys{banstop}} eq '1') {
      $banner_stop = $keys{banstop};
    }
    if ($keys{banstop} eq 'none') {
      $banner_stop = 'date';
      $keys{exp_date} = '2000-00-00';
    }
    $banner_stop = $dbh->quote($banner_stop);
    my $init_show = sprintf("%d", $keys{exp_show});
    my $init_click = sprintf("%d", $keys{exp_click});
    my $init_day = $dbh->quote($keys{exp_date});
    my $width = sprintf("%d", $keys{b_width});
    my $height = sprintf("%d", $keys{b_height});
    my $downtext = $dbh->quote($keys{down_text});

    my $file = $keys{banner};
    my $ext = (split /\./, $keys{banner})[-1];
    if ($keys{banner_from} eq 'url') {
      $ext = (split /\./, $keys{banner_url})[-1];
    }
    my $content;
    if (($keys{banner_from} eq 'file')or($keys{banner_from} eq '')) {
      if ($file) {
#        no strict qw{refs};
        my @a = <$file>;
        $content = join '', @a;
#        use strict qw{refs};
      }

    } else {
      $content = getDoc($keys{banner_url});
    }
    my $size = length($content);
    if ($size > $maxbannersize*1024) {
      print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
      $template = new Template("tmpl/banner.to.big.html");
      $template->print(%keys);
      exit;
    }


    my $banner_url = $dbh->quote($keys{banurl});
    my $bancode = $dbh->quote($keys{bancode});
    my $active = ($keys{status} eq '1' ? "'active'" : "'disable'");
    my $fext = $ext;
    my $sendstat = sprintf("%d", $keys{sendstat});
    my $qstatemail = $dbh->quote($keys{statemail});
    my $whensendstat = {daily => 1, weekly => 2, monthly => 3}->{$keys{when}} || 0;
    my $wday = {mon => 1, tue=>2, wed=>3, thu=>4, fri=>5, sat=>6, sun=>7}->{$keys{week_day}} || 0;
    my $mday = sprintf("%d", $keys{monthly_day});
    my $dhour = sprintf("%d", $keys{daily_hour});
    my $dmin = sprintf("%d", $keys{daily_min});
    my $whour = sprintf("%d", $keys{weekly_hour});
    my $wmin = sprintf("%d", $keys{weekly_min});
    my $mhour = sprintf("%d", $keys{monthly_hour});
    my $mmin = sprintf("%d", $keys{monthly_min});
    my $weight = sprintf("%d", $keys{weight});
    $ext = $dbh->quote($ext);
    if ($bid == 0) {
      $q = "insert into $ver\_banners set name=$name, parent=$tid, b_type=$banner_type,
      	active=$active, stop=$banner_stop, url=$banner_url, b_desc=$desc,
      	initshow = $init_show, initclick=$init_click, day=$init_day,  bantext = $bancode,
      	sendstat = $sendstat, statemail = $qstatemail, whensendstat = $whensendstat,
	wday = $wday, mday = $mday, dhour = $dhour, mhour = $mhour, whour = $whour,
	mmin = $mmin, wmin = $wmin, dmin = $dmin,
	weight = $weight,


      	b_width = $width, b_height=$height, downtext=$downtext, ext=$ext";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      $bid = $sth->{insertid} || $sth->{mysql_insertid};
    } else {
      if ($fext) {
        $ext = ", ext=$ext";
      } else {
        $ext = '';
      }
      $tid = 'parent' if ($tid == 0);
      $q = "update $ver\_banners set name=$name, parent=$tid, b_type=$banner_type,
      	active=$active, stop=$banner_stop, url=$banner_url, b_desc=$desc,
      	initshow = $init_show, initclick=$init_click, day=$init_day, bantext = $bancode,
      	b_width = $width, b_height=$height, 
      	sendstat = $sendstat, statemail = $qstatemail, whensendstat = $whensendstat,
	wday = $wday, mday = $mday, dhour = $dhour, mhour = $mhour, whour = $whour,
	mmin = $mmin, wmin = $wmin, dmin = $dmin,
	weight = $weight,

	downtext=$downtext $ext where id=$bid";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      if ($keys{deletestat} eq '1') {
        open FILE, ">logs/$bid";
        close FILE;
        $q = "delete from $ver\_show2click where bid=$bid";
        $dbh->do($q) or print $dbh->errstr;
        $q = "delete from $ver\_stat where bid=$bid";
        $dbh->do($q) or print $dbh->errstr;
	$q = "update $ver\_banners set showed = 0, clicked = 0 where id=$bid";
        $dbh->do($q) or print $dbh->errstr;
      }
    }
    if ($content ne '') {
      my $flag = 0;
      open FILE, ">$vars_path_to_images_shell"."banners/$bid.$fext";
      binmode FILE;
      print FILE $content;
      close FILE;
    }
    print "Location: admin.cgi?page=banners&tid=$tid\n\n";
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";

  my $bid = sprintf("%d", $keys{bid});
  if ($bid > 0) {
    $q = "select * from $ver\_banners where id=$bid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my %in;
    if ($sth->rows > 0) {
      $row = $sth->fetchrow_hashref;
      my $banstopnone = '';
      $banstopnone = 'checked' if (($row->{stop} eq 'date')and($row->{day} eq '2000-00-00'));
      my $banstopclick = '';
      my $exp_date = '';
      $exp_date = $row->{day} if ($row->{day} ne '2000-00-00');
      $banstopclick = 'checked' if ($row->{stop} eq 'click');
      my $banstopshow = '';
      $banstopshow = 'checked' if ($row->{stop} eq 'show');
      my $banstopdate = '';
      $banstopdate = 'checked' if (($row->{stop} eq 'date')and($row->{day} ne '2000-00-00'));;
      my $statuschecked = '';
      $statuschecked = 'checked' if ($row->{active} eq 'active');
      %in = (
      	'name' => s_q($row->{name}),
      	'description' => $row->{b_desc},
      	'banstop-none' => $banstopnone,
      	'banstop-click' => $banstopclick,
      	'banstop-show' => $banstopshow,
      	'banstop-date' => $banstopdate,
      	'status-checked' => $statuschecked,
      	'banner-url', => $row->{url},
      	'bancode' => $row->{bantext},
      	'width' => $row->{b_width},
      	'height' => $row->{b_height},
      	'down-text' => s_q($row->{downtext}),
      	'ext' => $row->{ext},
      	'exp_click' => $row->{initclick},
      	'exp_show' => $row->{initshow},
      	'exp_date' => $exp_date,
	'sendstat' => ($row->{sendstat} eq '1' ? 'checked' : ''),
	'statemail' => $row->{statemail},
	'daily' => ($row->{whensendstat} eq '1'? 'checked' : ''),
	'weekly' => ($row->{whensendstat} eq '2'? 'checked' : ''),
	'monthly' => ($row->{whensendstat} eq '3'? 'checked' : ''),
	'daily_hour' => $row->{dhour},
	'daily_min' => $row->{dmin},
	'weekly_hour' => $row->{whour},
	'weekly_min' => $row->{wmin},
	'monthly_hour' => $row->{mhour},
	'monthly_min' => $row->{mmin},
	'mon' => ($row->{wday} eq '1' ? 'selected' : ''),
	'tue' => ($row->{wday} eq '2' ? 'selected' : ''),
	'wed' => ($row->{wday} eq '3' ? 'selected' : ''),
	'thu' => ($row->{wday} eq '4' ? 'selected' : ''),
	'fri' => ($row->{wday} eq '5' ? 'selected' : ''),
	'sat' => ($row->{wday} eq '6' ? 'selected' : ''),
	'sun' => ($row->{wday} eq '7' ? 'selected' : ''),
	'monthly_day' => $row->{mday},
	'weight' => $row->{weight},

      );
      $keys{type} = $row->{b_type};
    }
    $template = new Template('tmpl/edit.banner.html');
    $template->replace_hash(%in);
  } else {
    $template = new Template('tmpl/add.new.banner1.html');
  }
  $template->replace('code-for-type', $template->get_area("code-$keys{type}"));
  $template->clear_area('clear');
  my %in = (
      	'name' => '',
      	'description' => '',
      	'banstop-none' => 'checked',
      	'banstop-click' => '',
      	'banstop-show' => '',
      	'banstop-date' => '',
      	'status-checked' => 'checked',
      	'banner-url' => 'http://',
      	'bancode' => '',
      	'width' => '',
      	'height' => '',
      	'down-text' => ''
  );
  $template->replace_hash(%in);

  $template->print(%keys);
  exit;
}



sub UpdateListing {
  for my $i (split /\t/, $keys{"delete"}) {
    my $id = sprintf("%d", $i);
    my $q = "delete from $ver\_banners where id=$id";
    $dbh->do($q);
    $q = "delete from $ver\_stat where bid=$id";
    $dbh->do($q);
    $q = "delete from $ver\_show2click where bid=$id";
    $dbh->do($q);
    open FILE, ">logs/$id";
    close FILE;
  }
  for my $i (split /\t/, $keys{ids}) {
    my $id = sprintf("%d", $i);
    my $active = sprintf("%d", $keys{"active$id"});
    my $weight = sprintf("%d", $keys{"weight$id"});
    $q = "update $ver\_banners set active = $active, weight = $weight where id = $id";
    $dbh->do($q) or print $dbh->errstr;
  }
  print "Location: admin.cgi?page=banners&tid=$keys{tid}\n\n";
  exit;
}


sub AddNewType {
  if ($keys{action} eq 'addnewtype') {
    my $name = $dbh->quote($keys{typename});
    my $desc = $dbh->quote($keys{typedesc});
    $q = "insert into $ver\_types set name=$name, t_desc=$desc";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    print "Location: admin.cgi\n\n";
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/add.new.type.html');
  $template->print();
  exit;
}

sub AddUser {
  if ($keys{action} eq 'adduser') {
    my $login = $dbh->quote($keys{username});
    my $passwd = $dbh->quote($keys{passwd});
    my $email = $dbh->quote($keys{email});
    my $url = $dbh->quote($keys{url});
    my %access = (
	'superuser' => 1,
	'campaignadmin' => 1,
	'banneradmin' => 1,
	'statuser' => 1
    );
    my $access = $dbh->quote($access{$keys{acctype}} eq '1' ? $keys{acctype} : 'statuser');
    my $desc = $dbh->quote($keys{userdesc});
    my $uid = sprintf("%d", $keys{uid});
    my $oldname = '';
    if ($uid == 0) {
      $q = "select id from $ver\_users where name=$login";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      if ($sth->rows > 0) {
        print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
        $template = new Template('tmpl/user.exists.html');
        $template->print(%keys);
        exit;
      }
      $q = "insert into $ver\_users set name=$login, passwd=$passwd, email=$email, url=$url, access=$access, descr=$desc";
    } else {
      $q = "select name, access from $ver\_users where id=$uid";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      my $oldaccess;
      if ($row = $sth->fetchrow_hashref) {
        $oldname = $row->{name};
        $oldaccess = $row->{access};
      }
      if ($oldname ne $keys{username}) {
        $q = "select id from $ver\_users where name=$login";
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr;
        if ($sth->rows > 0) {
          print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
          $template = new Template('tmpl/user.exists.html');
          $template->print(%keys);
          exit;
        }
      }
      my $pas = '';
      if ($keys{passwd} ne '') {
        $pas = ", passwd=$passwd";
      }
      $q = "update $ver\_users set name=$login $pas , email=$email, url=$url, access=$access, descr=$desc where id=$uid";
      if ($keys{acctype} ne $oldaccess) {

        my $q1 = "delete from $ver\_users2banners where uid=$uid";
        $sth = $dbh->prepare($q1);
        $sth->execute() or print $sth->errstr;
      }
    }
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($uid == 0) {
      $uid = $sth->{insertid} || $sth->{mysql_insertid};
    }
    if ($keys{acctype} eq 'superuser') {
      print "Location: admin.cgi?page=users\n\n";
    } else {
      if ($oldname ne '') {
        print "Location: admin.cgi?page=edituser2&uid=$uid\n\n";
      } else {
        print "Location: admin.cgi?page=adduser2&uid=$uid\n\n";
      }
    }
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";

  $template = new Template('tmpl/add.new.user1.html');

  $template->print(%keys);
  exit;
}

sub AddUserStep2 {
  if ($keys{action} eq 'adduser') {
    my $uid = sprintf("%d", $keys{uid});

    $q = "select * from $ver\_users where id=$uid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($row = $sth->fetchrow_hashref) {
      my @ban;
      if ($row->{access} eq 'campaignadmin') {
        @ban = grep {/camp\d+/} keys %keys;
      } else {
        @ban = grep {/ban\d+/} keys %keys;
      }
      my $i;
      $q = "delete from $ver\_users2banners where uid=$uid";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      for $i (@ban) {
        my $bid = sprintf("%d", $keys{$i});
        $q = "insert into $ver\_users2banners set uid=$uid, bid=$bid";
        my $sth1 = $dbh->prepare($q);
        $sth1->execute() or print $sth->errstr;
      }
    }
    print "Location: admin.cgi?page=users\n\n";
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  if ($keys{page} eq 'edituser2') {
    $template = new Template('tmpl/edit.user2.html');
  } else {
    $template = new Template('tmpl/add.new.user2.html');
  }
  my $uid = sprintf("%d", $keys{uid});
  $q = "select * from $ver\_users where id=$uid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($row = $sth->fetchrow_hashref) {
    my %in = (
	'user-login' => $row->{name},
	'user-desc' => $row->{descr},
	'user-access' => $row->{access},
	'user-email'=> $row->{email},
	'user-url' => $row->{url}
    );
    $template->replace_hash(%in);
  }
  if ($row->{access} eq 'campaignadmin') {
    my $t = $template->get_area('campaign-list');
    $q = "select id, name from $ver\_types order by id desc";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my @list = ();
    while ($row = $sth->fetchrow_hashref) {
      my %in = (
	'camp-id' => $row->{id},
	'camp-name' => $row->{name},
	'camp-sel' => ''
      );
      @list = (@list, \%in);
    }
    $q = "select uid, bid from $ver\_users2banners where uid=$uid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    while ($row = $sth->fetchrow_hashref) {
      my $i;
      for $i (@list) {
        if ($row->{bid} == $i->{'camp-id'}) {
          $i->{'camp-sel'} = 'checked';
        }
      }
    }
    my $t1 = $template->get_area('table-campaign');
    $template->replace('table-select', $t1);
    $template->make_for_array('campaign-list', $t, @list);

  } else {
    my $t = $template->get_area('banner-list');
    $q = "select id, name from $ver\_banners order by id desc";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my @list = ();
    while ($row = $sth->fetchrow_hashref) {
      my %in = (
	'ban-id' => $row->{id},
	'ban-name' => $row->{name},
	'ban-sel' => ''
      );
      @list = (@list, \%in);
    }
    $q = "select uid, bid from $ver\_users2banners where uid=$uid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    while ($row = $sth->fetchrow_hashref) {
      my $i;
      for $i (@list) {
        if ($row->{bid} == $i->{'ban-id'}) {
          $i->{'ban-sel'} = 'checked';
        }
      }
    }
    my $t1 = $template->get_area('table-banners');
    $template->replace('table-select', $t1);
    $template->make_for_array('banners-list', $t, @list);

  }

  $template->clear_areas('campaign-list', 'table-campaign');
  $template->clear_areas('banner-list', 'table-banners');
  $template->print(%keys);
  exit;
}

sub AdminLog {
  my ($inuser) = @_;
  my $ip = $dbh->quote($ENV{REMOTE_ADDR});
  my $user = $dbh->quote($inuser);
  $q = "insert into $ver\_adminlog set ip=$ip, d=now(), name=$user";
  $sth = $dbh->prepare($q);
  $sth->execute();
  $q = "update $ver\_users set last_d=now(), last_ip=$ip where name=$user";
  $sth = $dbh->prepare($q);
  $sth->execute();
}

sub ChangeStatus {
  my $bid = sprintf("%d", $keys{bid});
  $q = "select active from $ver\_banners where id=$bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($row = $sth->fetchrow_hashref) {
    my $a = $dbh->quote($row->{active} eq 'active' ? 'disable' : 'active');
    $q = "update $ver\_banners set active=$a where id=$bid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
  }
  print "Location: admin.cgi?page=banners&tid=$keys{tid}\n\n";
  exit;
}

sub CheckLogin {
  my $username = $cookie{username};
  my $password = $cookie{passwd};
  $q = "select passwd from $ver\_users where name=".$dbh->quote($username);
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $logged = 0;
  if ($row = $sth->fetchrow_hashref) {
    if (crypt($row->{passwd}, "Md") == $password) {
      $logged = 1;
    }
  }
  if ($logged == 0) {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/login.html');
    print $template->{code};
    exit;
  }
}

sub DeleteBanner {
  my $bid = sprintf("%d", $keys{bid});
  $q = "delete from $ver\_banners where id=$bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  $q = "delete from $ver\_stat where bid=$bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  unlink "$vars_path_to_images_shell"."banners/$bid.*";
  $q = "select distinct users2banners.uid as uid from $ver\_users as users, $ver\_users2banners as users2banners where users2banners.bid=$bid and users.access='banneradmin' or users.access='statuser'";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $q = "delete from $ver\_users2banners where uid=$row->{uid} and bid=$bid";
    my $sth1 = $dbh->prepare($q);
    $sth1->execute or print $sth->errstr;
  }
  print "Location: admin.cgi?page=banners&tid=$keys{tid}\n\n";
  exit;

}

sub DeleteType {
  my $tid = sprintf("%d", $keys{tid});
  if ($keys{action} eq 'removeselect') {
    print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
    $template = new Template('tmpl/remove.type.html');
    my $optselarea = $template->get_area('option-selarea');
    $template->clear_area('option-selarea');
    if ($user_type eq 'superuser') {
      $q = "select id, name from $ver\_types where id != $tid";
    } else {
      $q = "select types.id as id, types.name as name from $ver\_types as types, $ver\_users2banners as users2banners where id != $tid and types.id=users2banners.bid and
    	users2banners.uid=$initialuserid";
    }
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my @rplc = ();
    while ($row = $sth->fetchrow_hashref) {
      my %hash = (
	'area-id' => $row->{id},
	'area-name' => $row->{name}
      );
      @rplc = (@rplc, \%hash);
    }
    $template->make_for_array('option-selarea', $optselarea, @rplc);
    $q = "select count(banners.id) as col, types.name as name, types.t_desc as t_desc from $ver\_types as types, $ver\_banners as banners where types.id=$tid and banners.parent=$tid group by types.id";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my %rplc;
    if ($row = $sth->fetchrow_hashref) {
      %rplc = (
	't_name' => $row->{name},
	't_desc' => $row->{t_desc},
	'num_banners' => $row->{col}
      );
    }
    $template->replace_hash(%rplc);

    $template->print(%keys);
    exit;
  }
  if ($keys{action} eq 'removeselect1') {
    my $newparent = sprintf("%d", $keys{selarea});
    if ($user_type ne 'superuser') {
      $q = "select bid from $ver\_users2banners where uid=$initialuserid and bid=$newparent";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      if ($sth->rows == 0) {
        print "Location: admin.cgi?page=banners&tid=$tid\n\n";
        exit;
      }
    }
    $q = "update $ver\_banners set parent=$newparent where parent=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    $q = "delete from $ver\_types where id=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    $q = "select uid, bid from $ver\_users2banners as users2banners, $ver\_users as users where users.access='campaignadmin' and users.id=users2banners.uid and bid=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    while ($row = $sth->fetchrow_hashref) {
      $q = "delete from $ver\_users2banners where uid=$row->{uid} and bid=$row->{bid}";
      my $sth1 = $dbh->prepare($q);
      $sth1->execute() or print $sth->errstr;
    }
    print "Location: admin.cgi?page=banners&tid=$newparent\n\n";
    exit;
  }
  if ($keys{action} eq 'deleteall') {
    $q = "select id from $ver\_banners where parent=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    while ($row = $sth->fetchrow_hashref) {
      my $bid = sprintf("%d", $row->{id});
      unlink "$vars_path_to_images_shell"."banners/$bid.*";
      $q = "delete from $ver\_stat where bid=$bid";
      my $sth1 = $dbh->prepare($q);
      $sth1->execute() or print $sth->errstr;
      if ($user_type ne 'superuser') {
        $q = "select distinct users2banners.uid as uid from $ver\_users as users, $ver\_users2banners as users2banners where users2banners.bid=$bid and users.access='banneradmin' or users.access='statuser'";
        $sth1 = $dbh->prepare($q);
        $sth1->execute() or print $sth->errstr;
        while ($row = $sth1->fetchrow_hashref) {
          $q = "delete from $ver\_users2banners where uid=$row->{uid} and bid=$bid";
          my $sth2 = $dbh->prepare($q);
          $sth2->execute() or print $sth->errstr;
        }
      }
    }
    $q = "delete from $ver\_banners where parent=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    $q = "delete from $ver\_types where id=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($user_type ne 'superuser') {
      $q = "select distinct users2banners.uid as uid from $ver\_users as users, $ver\_users2banners as users2banners where users2banners.bid=$tid and users.access='campaignadmin'";
      my $sth1 = $dbh->prepare($q);
      $sth1->execute() or print $sth->errstr;
      while ($row = $sth1->fetchrow_hashref) {
        $q = "delete from $ver\_users2banners where uid=$row->{uid} and bid=$tid";
        my $sth2 = $dbh->prepare($q);
        $sth2->execute or print $sth->errstr;
      }
    }
    print "Location: admin.cgi\n\n";
    exit;
  }
  $q = "select id from $ver\_banners where parent=$tid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($sth->rows > 0) {
    print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
    $template = new Template("tmpl/delete.type.html");
    $q = "select count(banners.id) as col, types.name as name, types.t_desc as t_desc from $ver\_types as types, $ver\_banners as banners where types.id=$tid and banners.parent=$tid group by types.id";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my %rplc;
    if ($row = $sth->fetchrow_hashref) {
      %rplc = (
	't_name' => $row->{name},
	't_desc' => $row->{t_desc},
	'num_banners' => $row->{col}
      );
    }
    $template->replace_hash(%rplc);
    $template->print(%keys);
  } else {
    $q = "delete from $ver\_types where id=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    print "Location: admin.cgi\n\n";
  }
  exit;
}

sub DeleteUser {
  my $uid = sprintf("%d", $keys{uid});
  $q = "select name from $ver\_users where id=$uid and id > 1";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($row = $sth->fetchrow_hashref) {
    my $login = $dbh->quote($row->{name});
    my $htlogin = $row->{name};
    $q = "delete from $ver\_users where id=$uid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    $q = "delete from $ver\_users2banners where uid=$uid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    $q = "delete from $ver\_adminlog where name=$login";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
  }
  print "Location: admin.cgi?page=users\n\n";
  exit;
}


sub EditType {
  if ($keys{action} eq 'edittype') {
    my $tid = sprintf("%d", $keys{tid});
    my $name = $dbh->quote($keys{typename});
    my $desc = $dbh->quote($keys{typedesc});
    $q = "update $ver\_types set name=$name, t_desc=$desc where id=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    print "Location: admin.cgi\n\n";
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/edit.type.html');
  my $tid = sprintf("%d", $keys{tid});
  $q = "select name, t_desc from $ver\_types where id=$tid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my ($t_name, $t_desc);
  if ($sth->rows > 0) {
    $row = $sth->fetchrow_hashref;
    $t_name = $row->{name};
    $t_desc = $row->{t_desc};
  }
  $template->replace('type_name', s_q($t_name));
  $template->replace('type_desc', $t_desc);
  $template->print(%keys);
  exit;
}

sub EditUser {
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/edit.user.html');
  my $uid = sprintf("%d", $keys{uid});
  $q = "select * from $ver\_users where id=$uid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'user-name' => $row->{name},
    	'user-desc' => $row->{descr},
    	'user-sel-superuser' => ($row->{access} eq 'superuser' ? "selected" : ''),
    	'user-sel-campaignadmin' => ($row->{access} eq 'campaignadmin' ? "selected" : ''),
    	'user-sel-banneradmin' => ($row->{access} eq 'banneradmin' ? "selected" : ''),
    	'user-sel-statuser' => ($row->{access} eq 'statuser' ? "selected" : ''),
    	'user-email' => $row->{email},
    	'user-url' => $row->{url}
    );
    $template->replace_hash(%in);
  }

  $template->print(%keys);
  exit;


}


sub GetBannerCode {
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  my $bid = sprintf("%d", $keys{bid});
  $template = new Template('tmpl/get/one.banner.code.html');
  $q = "select * from $ver\_banners where id=$bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my %rplc;
  if ($row = $sth->fetchrow_hashref) {
    %rplc = (
	'b_name' => $row->{name},
	'b_desc' => $row->{b_desc}
    );
    $template->replace_hash(%rplc);
  }
  my $codet = new Template("tmpl/get/types/$row->{b_type}.html");
  %rplc = (
	'width' => $row->{b_width},
	'height' => $row->{b_height},
	'banner_url' => "$vars_path_to_images/banners/$row->{id}.$row->{ext}",
	'url' => $row->{url},
	'banner_text' => $row->{bantext},
	'ad-id' => $row->{id},
	'server-url' => $vars_server_url
  );
  $codet->replace_hash(%rplc);
  $codet->{code} =~ s/</&lt;/igms;
  $codet->{code} =~ s/>/&gt;/igms;
  $template->replace('banner', $codet->{code});

  $template->print(%keys);
  exit;
}

sub GetCampagnCode {
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  my $tid = sprintf("%d", $keys{tid});
  $template = new Template('tmpl/get/campaign.code.html');

  $q = "select types.name as name, types.t_desc as t_desc, count(banners.id) as col from $ver\_types as types, $ver\_banners as banners where types.id=$tid and banners.parent=$tid group by types.id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my %rplc;
  if ($row = $sth->fetchrow_hashref) {
    %rplc = (
	't_name' => $row->{name},
	't_desc' => $row->{t_desc},
	'num_banners' => $row->{col}
    );
    $template->replace_hash(%rplc);
  }
  my $t_t = new Template('tmpl/get/codes/campaign.html');
  %rplc = (
	'id' => $tid,
	'server-url' => $vars_server_url
  );
  $t_t->replace_hash(%rplc);
  $t_t->replace_tags();
  $template->replace('campaign_code', $t_t->{code});

  $q = "select distinct b_type from $ver\_banners where parent=$tid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;

  my %type;
  while ($row = $sth->fetchrow_hashref) {
    $type{$row->{b_type}} = $row->{b_type};
  }
  $sth->finish();
  my $i;
  for $i ('image', 'js', 'java', 'swf', 'mov', 'dcr', 'rpm', 'html') {
    $t_t = new Template('tmpl/get/codes/type.html');
    %rplc = (
	'id' => $tid,
	'server-url' => $vars_server_url,
	'type' => $i
    );
    $t_t->replace_hash(%rplc);
    $t_t->replace_tags();
    $template->replace("campaign_$i\_code", $t_t->{code});
  }

  my $type;
  for $type ('image', 'dcr', 'swf', 'rpm', 'mov') {
    if ($type{$type} eq $type) {
      $t_t = new Template('tmpl/get/codes/'.$type.'_size.html');
      %rplc = (
	'id' => $tid,
	'server-url' => $vars_server_url,
	'type' => $type
      );
      $t_t->replace_hash(%rplc);
      $t_t->replace_tags();
      $t_t->{code} =~ s/\n/<br>/igms;
      $template->replace('campaign_'.$type.'_code-size', $t_t->{code});
      $t_t = new Template();
      $t_t->{code} = $template->get_area("table-$type-code");
      $q = "select id from $ver\_banners where b_type='$type' and parent=$tid";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      $t_t->replace("num-$type", $sth->rows);

      $q = "select b_width, b_height, count(id) as col from $ver\_banners as banners where b_type='$type' and parent=$tid group by b_width, b_height";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      if ($sth->rows > 0) {
        my $imt = $template->get_area("campaign_$type\_code_for");
        my @rplc = ();
        while ($row = $sth->fetchrow_hashref) {
          my %rplc = (
  	  	'width' => $row->{b_width},
    		'height' => $row->{b_height},
  		"num-$type\-dif-size" => $row->{col}
          );
          @rplc = (@rplc, \%rplc);
        }
        $t_t->make_for_array("campaign_$type\_code_for", $imt, @rplc);
        $template->replace("table-$type-code", $t_t->{code});
      }
    } else {
      $template->replace("table-$type-code", '');
    }
  }

  if ($type{html} eq 'html') {
    $t_t = new Template();
    $t_t->{code} = $template->get_area('table-html-code');
    $q = "select id from $ver\_banners where b_type='html' and parent=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    $t_t->replace('num-html', $sth->rows);

    $q = "select id from $ver\_banners where b_type='html' and parent=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($sth->rows > 0) {
      my $htt = $template->get_area('campaign_html_code_for');

      $htt = Template->text_replace($htt, 'num-html', $sth->rows);
      $t_t->replace('campaign_html_code_for', $htt);
    }
    $template->replace('table-html-code', $t_t->{code});
  } else {
    $template->replace('table-html-code', '');
  }


  if ($type{html} eq 'html') {
    $t_t = new Template();
    $t_t->{code} = $template->get_area('table-html-code');
    $q = "select id from $ver\_banners where b_type='html' and parent=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    $t_t->replace('num-html', $sth->rows);

    $q = "select id from $ver\_banners where b_type='html' and parent=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($sth->rows > 0) {
      my $htt = $template->get_area('campaign_html_code_for');

      $htt = Template->text_replace($htt, 'num-html', $sth->rows);
      $t_t->replace('campaign_html_code_for', $htt);
    }
    $template->replace('table-html-code', $t_t->{code});
  } else {
    $template->replace('table-html-code', '');
  }

  if ($type{js} eq 'js') {
    $t_t = new Template();
    $t_t->{code} = $template->get_area('table-js-code');
    $q = "select id from $ver\_banners where b_type='js' and parent=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    $t_t->replace('num-js', $sth->rows);

    $q = "select id from $ver\_banners where b_type='js' and parent=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($sth->rows > 0) {
      my $htt = $template->get_area('campaign_js_code_for');

      $htt = Template->text_replace($htt, 'num-js', $sth->rows);
      $t_t->replace('campaign_js_code_for', $htt);
    }
    $template->replace('table-js-code', $t_t->{code});
  } else {
    $template->replace('table-js-code', '');
  }

  if ($type{java} eq 'java') {
    $t_t = new Template();
    $t_t->{code} = $template->get_area('table-java-code');
    $q = "select id from $ver\_banners where b_type='java' and parent=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    $t_t->replace('num-java', $sth->rows);

    $q = "select id from $ver\_banners where b_type='java' and parent=$tid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($sth->rows > 0) {
      my $htt = $template->get_area('campaign_java_code_for');

      $htt = Template->text_replace($htt, 'num-java', $sth->rows);
      $t_t->replace('campaign_java_code_for', $htt);
    }
    $template->replace('table-java-code', $t_t->{code});
  } else {
    $template->replace('table-java-code', '');
  }

  $template->clear_areas('campaign_image_code_for', 'campaign_html_code_for', 'campaign_js_code_for', 'campaign_java_code_for',
	'campaign_swf_code_for', 'campaign_mov_code_for', 'campaign_dcr_code_for',
	'campaign_rpm_code_for');
  $template->clear_areas('table-image-code', 'table-html-code', 'table-swf-code', 'table-js-code', 'table-java-code',
	'table-mov-code', 'table-dcr-code', 'table-rpm-code');

  my $ssiurl = (split /\//, $vars_server_url, 4)[3];

  $template->replace('ssiurl', $ssiurl);
  $template->replace('server-url', $vars_server_url);

  $template->print(%keys);
  exit;

}


sub get_user_type {
  my $name = $dbh->quote($cookie{username});
  $q = "select access, id from $ver\_users where name=$name";
  my $ret = '';
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($row = $sth->fetchrow_arrayref) {
    $ret = $row->[0];
    $initialuserid = $row->[1];
  }
  return $ret;
}

sub Log {
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/admin.log.html');
  if ($keys{range} eq 'month') {
    $q = "select * from $ver\_adminlog where to_days(now()) - to_days(d) < 30 order by d desc";
  } elsif ($keys{range} eq 'week') {
    $q = "select * from $ver\_adminlog where to_days(now()) - to_days(d) < 7 order by d desc";
  } else {
    $q = "select * from $ver\_adminlog where to_days(now()) - to_days(d) = 0 order by d desc";
  }
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @lines = ();
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'log-name' => $row->{name},
	'ip-address' => $row->{ip},
	'log-time' => $row->{d}
    );
    @lines = (@lines, \%in);
  }
  my $t = $template->get_area('log-lines');
  $template->make_for_array('log-lines', $t, @lines);
  $template->clear_area('log-lines');

  $template->print(%keys);
  exit;

}

sub Logout {
  print "Set-cookie: login=\nSet-cookie: username=\nSet-cookie: passwd=\nLocation: admin.cgi\n\n";
  exit;
}



sub main_banner {
  my $cookie = '';
  $cookie = "\nSet-cookie: order_ban=$keys{order}" if ($keys{order});
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache$cookie\n\n";
  $keys{order} = $cookie{order_ban} if ($keys{order} eq '');

  $template = new Template('tmpl/utypes/banneradmin/banners.html');
  my $tid = sprintf("%d", $keys{tid});

  $q = "select to_days(now()) as tdn, to_days(banners.day) as tdd, banners.id as id, banners.name as name, banners.stop as stop, banners.b_type as b_type, banners.active as active, banners.weight as weight,
  	banners.showed as showed, banners.clicked as clicked, banners.day as day, now() as now, banners.initclick as initclick,
  	banners.initshow as initshow, banners.clicked as clicked, banners.showed as showed from $ver\_banners as banners, $ver\_users2banners as users2banners
  	where users2banners.bid=banners.id and users2banners.uid=$initialuserid order by banners.id";


  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr, $q;
  my @list = ();
  my %list_id;
  my $banner_active = $template->get_area('active-banner');
  my $banner_noactive = $template->get_area('no-active-banner');
  my %images_type;
  my $i;

  for $i ('image', 'html', 'swf', 'dcr', 'mov', 'rpm', 'js', 'java') {
    $images_type{$i} = $template->get_area("$i-image");
    $template->clear_area("$i-image");
  }

  $template->clear_areas('active-banner', 'no-active-banner');

  my $t_never_exp = $template->get_area('expire-never');
  my $t_date_exp = $template->get_area('expire-date');
  my $t_date_exp_yes = $template->get_area('expire-date-yes');
  my $t_click_exp = $template->get_area('expire-click');
  my $t_click_exp_yes = $template->get_area('expire-click-yes');
  my $t_show_exp = $template->get_area('expire-show');
  my $t_show_exp_yes = $template->get_area('expire-show-yes');
  $template->clear_areas('expire-never', 'expire-date', 'expire-date-yes',
	'expire-click', 'expire-click-yes', 'expire-show', 'expire-show-yes');

  my $stat_total_expired = 0;
  my $stat_total_active = 0;
  while ($row = $sth->fetchrow_hashref) {
    my $cps = 0;
    if ($row->{showed} > 0) {
      $cps = sprintf("%.02f", 100*$row->{clicked}/$row->{showed});
    }
    my $exp;
    if ((($row->{stop} eq 'date')and($row->{day} eq '2000-00-00'))or(($row->{stop} eq 'show')and($row->{initshow} eq '0'))or(($row->{stop} eq 'click')and($row->{initclick} eq '0'))) {
      $exp = $t_never_exp;
      $stat_total_active++ if ($row->{active} eq 'active');
    } elsif (($row->{stop} eq 'date')and($row->{day} ne '2000-00-00')) {
      if ($row->{tdd} > $row->{tdn}) {
        $exp = $t_date_exp;
        $stat_total_active++ if ($row->{active} eq 'active');
      } else {
        $exp = $t_date_exp_yes;
        $stat_total_expired++;
      }
    } elsif (($row->{stop} eq 'click')and($row->{initclick} != 0)) {
      if ($row->{initclick} > $row->{clicked}) {
        $exp = $t_click_exp;
        $stat_total_active++ if ($row->{active} eq 'active');
      } else {
        $exp = $t_click_exp_yes;
        $stat_total_expired++;
      }
    } elsif (($row->{stop} eq 'show')and($row->{initshow} != 0)) {
      if ($row->{initshow} > $row->{showed}) {
        $exp = $t_show_exp;
        $stat_total_active++ if ($row->{active} eq 'active');
      } else {
        $exp = $t_show_exp_yes;
        $stat_total_expired++;
      }
    } else {
      $exp = $t_never_exp;
      $stat_total_active++ if ($row->{active} eq 'active');
    }
    $exp = Template::text_replace($exp, 'date-expire', $row->{day});
    $exp = Template::text_replace($exp, 'click-expire', $row->{initclick});
    $exp = Template::text_replace($exp, 'show-expire', $row->{initshow});
#print $row->{weight}, "<BR>";
    my %in = (
	'id' => $row->{id},
	'name' => $row->{name},
	'stop' => $exp,
	'b_type' => $images_type{$row->{b_type}},
	'active' => ($row->{active} eq 'active' ? 'checked' : ''),
	'clicks' => $row->{clicked},
	'shows' => $row->{showed},
	'clickstoday' => 0,
	'showstoday' => 0,
	'weight' => $row->{weight},
	'cps' => sprintf("%.02f", $cps),
	'cpstoday' => '0.00'
    );
    @list = (@list, \%in);
    $list_id{$row->{id}} = $#list;
  }
  $sth->finish();

  $q = "select bid as id, sum(stat.clicks) as clicks, sum(stat.shows) as shows from $ver\_stat as stat where stat.d=now() group by bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    if (exists($list_id{$row->{id}})) {
      $list[$list_id{$row->{id}}]->{clickstoday} = $row->{clicks};
      $list[$list_id{$row->{id}}]->{showstoday} = $row->{shows};
      $list[$list_id{$row->{id}}]->{cpstoday} = sprintf("%.02f", 100*$row->{clicks}/$row->{shows}) if ($row->{shows} > 0);
    }
  }
  $sth->finish();

  my $down_arrow = $template->get_area('down_arrow');
  my $top_arrow = $template->get_area('top_arrow');
  $template->clear_areas('down_arrow', 'top_arrow');

  ($template, @list) = sort_main_banner($template, $down_arrow, $top_arrow, @list);


  my %rplc = (
	'name-arrow' => '',
	'order-name' => '',
	'type-arrow' => '',
	'order-type' => '',
	'exp-arrow' => '',
	'order-exp' => '',
	'show-arrow' => '',
	'order-show' => '',
	'click-arrow' => '',
	'order-click' => '',
	'acps-arrow' => '',
	'order-acps' => '',
	'acpst-arrow' => '',
	'order-acpst' => ''
  );
  $template->replace_hash(%rplc);


  if ($#list == -1) {
    my $t = $template->get_area('banners-lines-none');
    $template->replace('banners-lines', $t);
  } else {
    my $t = $template->get_area('banners-lines');
    $template->make_for_array('banners-lines', $t, @list);
  }

  $template->clear_area('banners-lines');
  $template->clear_area('banners-lines-none');

  #stat-banners#
  $template->replace('stat-total-banners', $#list+1);
  $template->replace('stat-expired-banners', $stat_total_expired);
  $template->replace('stat-active-banners', $stat_total_active);


  #stat-week#

  my $statline = $template->get_area('stat-week');
  $template->clear_area('stat-week');
  @list = ();
  for ($i = 0; $i<7; $i++) {
    my %in = (
	'day' => $i,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
    );
    @list = (@list, \%in);
  }
  $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, stat.d as d, to_days(now()) - to_days(d) as dif
  	from $ver\_stat as stat, $ver\_banners as banners, $ver\_users2banners as users2banners where stat.bid=banners.id and banners.id=users2banners.bid and
  	users2banners.uid=$initialuserid and to_days(now()) - to_days(d)<7 group by stat.d";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$row->{dif}]->{clicks} = $row->{clicks};
    $list[$row->{dif}]->{shows} = $row->{shows};
    $list[$row->{dif}]->{date} = $row->{d};
  }
  my $max_clicks = 0;
  my $max_shows = 0;
  $q = "select curdate()";
  for ($i = 1; $i<7; $i++) {
    $q .= ", date_sub(curdate(), interval $i day)";
  }
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  $row = $sth->fetchrow_arrayref;
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{date} = $row->[$i];
  }


  for ($i = 0; $i<7; $i++) {
    $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
    $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{clicks_height} = sprintf("%d", 200*$list[$i]->{clicks}/$max_clicks);
    $list[$i]->{shows_height} = sprintf("%d", 200*$list[$i]->{shows}/$max_shows);
  }
  $template->make_for_array('stat-week', $statline, reverse @list);


  #stat-day#

  my $statline = $template->get_area('stat-day');
  $template->clear_area('stat-day');
  @list = ();
  for ($i = 0; $i<12; $i++) {
    my %in = (
	'day' => $i,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
    );
    @list = (@list, \%in);
  }
  my $floor = "FLOOR((unix_timestamp(now()) - unix_timestamp(date_add(d, interval h hour)))/3600)";
  $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, date_add(stat.d, interval h hour) as d, stat.h as h,
   	$floor as dif from $ver\_stat as stat, $ver\_banners as banners, $ver\_users2banners as users2banners where stat.bid=banners.id and banners.id=users2banners.bid and
   	users2banners.uid=$initialuserid and $floor < 12 group by $floor order by $floor";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$row->{dif}]->{clicks} = $row->{clicks};
    $list[$row->{dif}]->{shows} = $row->{shows};
    $list[$row->{dif}]->{date} = $row->{d};
  }
  my $max_clicks = 0;
  my $max_shows = 0;

  for ($i = 0; $i<12; $i++) {
    $list[$i]->{date} = {$i};
  }


  for ($i = 0; $i<12; $i++) {
    $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
    $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<12; $i++) {
    $list[$i]->{clicks_height} = sprintf("%d", 200*$list[$i]->{clicks}/$max_clicks);
    $list[$i]->{shows_height} = sprintf("%d", 200*$list[$i]->{shows}/$max_shows);
    $list[$i]->{date} = -$i." h";
  }
  $template->make_for_array('stat-day', $statline, reverse @list);

  $template->print(%keys);
  exit;
}



sub main_campadmin {
  my $cookie = '';
  $cookie = "\nSet-cookie: order_camp=$keys{order}" if ($keys{order});
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache$cookie\n\n";
  $keys{order} = $cookie{order_camp} if ($keys{order} eq '');

  my $stat_total_banners = 0;
  my $stat_expired_banners = 0;
  my $stat_active_banners = 0;

  $template = new Template('tmpl/utypes/campaignadmin/index.html');

  $q = "select types.id as id, types.name as name from $ver\_types as types, $ver\_users2banners as users2banners where users2banners.uid=$initialuserid and users2banners.bid=types.id";

  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  my %list_id;
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'id' => $row->{id},
	'name' => $row->{name},
	'shows' => 0,
	'clicks' => 0,
	'showstoday' => 0,
	'clickstoday' => 0,
	'cps' => 0,
	'cpstoday' => 0,
	'count' => 0
    );
    @list = (@list, \%in);
    $list_id{$row->{id}} = $#list;
  }
  $sth->finish();

  $q = "select banners.parent as id, sum(banners.clicked) as clicks, sum(banners.showed) as shows, count(banners.id) as col from $ver\_banners as banners, $ver\_users2banners as users2banners
  	where users2banners.uid=$initialuserid and users2banners.bid=banners.parent group by banners.parent";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$list_id{$row->{id}}]->{clicks} = $row->{clicks};
    $list[$list_id{$row->{id}}]->{shows} = $row->{shows};
    $list[$list_id{$row->{id}}]->{count} = $row->{col};
    $list[$list_id{$row->{id}}]->{cps} = sprintf("%.02f", 100*$row->{clicks}/$row->{shows}) if ($row->{shows} > 0);
  }
  $sth->finish();

  $q = "select banners.parent as id, sum(stat.clicks) as clicks, sum(stat.shows) as shows from $ver\_stat as stat, $ver\_banners as banners, $ver\_users2banners as users2banners
  	where stat.bid=banners.id and stat.d=now() and users2banners.uid=$initialuserid and users2banners.bid=banners.parent group by banners.parent";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$list_id{$row->{id}}]->{clickstoday} = $row->{clicks};
    $list[$list_id{$row->{id}}]->{showstoday} = $row->{shows};
    $list[$list_id{$row->{id}}]->{cpstoday} = sprintf("%.02f", 100*$row->{clicks}/$row->{shows}) if ($row->{shows} > 0);
  }
  $sth->finish();

  my $down_arrow = $template->get_area('down_arrow');
  my $top_arrow = $template->get_area('top_arrow');
  $template->clear_areas('down_arrow', 'top_arrow');

  ($template, @list) = sort_main_page($template, $down_arrow, $top_arrow, @list);

  my %rplc = (
	'order-types' => '',
	'types-sort-image' => '',
	'order-col' => '',
	'col-sort-image' => '',
	'order-show' => '',
	'show-sort-image' => '',
	'order-click' => '',
	'click-sort-image' => '',
	'order-acps' => '',
	'acps-sort-image' => '',
	'order-acpst' => '',
	'acpst-sort-image' => ''
  );
  $template->replace_hash(%rplc);


  my $t = $template->get_area('types-lines');

  $template->make_for_array('types-lines', $t, @list);
  $template->clear_area('types-lines');


  #stat-week#

  my $statline = $template->get_area('stat-week');
  $template->clear_area('stat-week');
  @list = ();
  my $i;
  for ($i = 0; $i<7; $i++) {
    my %in = (
	'day' => $i,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
    );
    @list = (@list, \%in);
  }
  $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, stat.d as d, to_days(now()) - to_days(d) as dif
  	from $ver\_stat as stat, $ver\_banners as banners, $ver\_users2banners as users2banners where stat.bid=banners.id and to_days(now()) - to_days(d)<7 and banners.parent=users2banners.bid and
  	users2banners.uid=$initialuserid group by stat.d";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    next if ($row->{dif} < 0);
    $list[$row->{dif}]->{clicks} = $row->{clicks};
    $list[$row->{dif}]->{shows} = $row->{shows};
    $list[$row->{dif}]->{date} = $row->{d};
  }
  my $max_clicks = 0;
  my $max_shows = 0;
  $q = "select curdate()";
  for ($i = 1; $i<7; $i++) {
    $q .= ", date_sub(curdate(), interval $i day)";
  }
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  $row = $sth->fetchrow_arrayref;
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{date} = $row->[$i];
  }

  for ($i = 0; $i<7; $i++) {
    $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
    $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{clicks_height} = sprintf("%d", 200*$list[$i]->{clicks}/$max_clicks);
    $list[$i]->{shows_height} = sprintf("%d", 200*$list[$i]->{shows}/$max_shows);
  }
  $template->make_for_array('stat-week', $statline, reverse @list);

  #stat banners#
  $q = "select to_days(now()) as tdn, to_days(banners.day) as tdd, curdate() as now, banners.day as day, banners.initclick as initclick, banners.initshow as initshow,
  	banners.showed as showed, banners.clicked as clicked, banners.stop as stop, banners.active as active from $ver\_banners as banners, $ver\_users2banners as users2banners
  	where banners.parent=users2banners.bid and users2banners.uid=$initialuserid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $stat_total_banners++;
    if (($row->{day} eq '2000-00-00')and($row->{stop} eq 'date')) {
      $stat_active_banners++ if ($row->{active} eq 'active');
    } elsif (($row->{stop} eq 'show')and(($row->{initshow}>$row->{showed})or($row->{initshow} == 0))) {
      $stat_active_banners++ if ($row->{active} eq 'active');
    } elsif (($row->{stop} eq 'click')and(($row->{initclick} > $row->{clicked})or($row->{initclick} == 0))) {
      $stat_active_banners++ if ($row->{active} eq 'active');
    } elsif (($row->{stop} eq 'date')and($row->{tdn} > $row->{tdd})) {
      $stat_active_banners++ if ($row->{active} eq 'active');
    }

    if (($row->{stop} eq 'date')and(($row->{day} cmp $row->{now}) == -1)and($row->{day} ne '2000-00-00')) {
      $stat_expired_banners++;
    } elsif (($row->{stop} eq 'click')and($row->{initclick}<=$row->{clicked})and($row->{initclick} != 0)) {
      $stat_expired_banners++;
    } elsif (($row->{stop} eq 'show')and($row->{initshow} <= $row->{showed})and($row->{initshow} != 0)) {
      $stat_expired_banners++;
    }
  }
  $template->replace('stat-active-banners', $stat_active_banners);
  $template->replace('stat-expired-banners', $stat_expired_banners);
  $template->replace('stat-total-banners', $stat_total_banners);

  #stat-day#

  my $statline = $template->get_area('stat-day');
  $template->clear_area('stat-day');
  @list = ();
  for ($i = 0; $i<12; $i++) {
    my %in = (
	'day' => $i,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
    );
    @list = (@list, \%in);
  }
  my $floor = "FLOOR((unix_timestamp(now()) - unix_timestamp(date_add(d, interval h hour)))/3600)";
  $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, date_add(stat.d, interval h hour) as d, stat.h as h,
  	$floor as dif from $ver\_stat as stat, $ver\_banners as banners, $ver\_users2banners as users2banners where stat.bid=banners.id and $floor < 12 and banners.parent=users2banners.bid and
  	users2banners.uid=$initialuserid group by $floor order by $floor";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    next if ($row->{dif} < 0);
    $list[$row->{dif}]->{clicks} = $row->{clicks};
    $list[$row->{dif}]->{shows} = $row->{shows};
    $list[$row->{dif}]->{date} = $row->{d};
  }
  my $max_clicks = 0;
  my $max_shows = 0;

  for ($i = 0; $i<12; $i++) {
    $list[$i]->{date} = {$i};
  }


  for ($i = 0; $i<12; $i++) {
    $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
    $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<12; $i++) {
    $list[$i]->{clicks_height} = sprintf("%d", 200*$list[$i]->{clicks}/$max_clicks);
    $list[$i]->{shows_height} = sprintf("%d", 200*$list[$i]->{shows}/$max_shows);
    $list[$i]->{date} = -$i." h";
  }
  $template->make_for_array('stat-day', $statline, reverse @list);

  $template->print(%keys);
}



sub main_stat {
  my $cookie = '';
  $cookie = "\nSet-cookie: order_ban=$keys{order}" if ($keys{order});
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache$cookie\n\n";
  $keys{order} = $cookie{order_ban} if ($keys{order} eq '');

  $template = new Template('tmpl/utypes/statuser/banners.html');
  my $tid = sprintf("%d", $keys{tid});

  $q = "select to_days(now()) as tdn, to_days(banners.day) as tdd, banners.id as id, banners.name as name, banners.stop as stop, banners.b_type as b_type, banners.active as active,
  	banners.showed as showed, banners.clicked as clicked, banners.day as day, now() as now, banners.initclick as initclick,
  	banners.initshow as initshow, banners.clicked as clicked, banners.showed as showed from $ver\_banners as banners, $ver\_users2banners as users2banners
  	where users2banners.bid=banners.id and users2banners.uid=$initialuserid order by banners.id";

  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  my %list_id;
  my $banner_active = $template->get_area('active-banner');
  my $banner_noactive = $template->get_area('no-active-banner');
  my %images_type;
  my $i;

  for $i ('image', 'html', 'swf', 'dcr', 'mov', 'rpm', 'js', 'java') {
    $images_type{$i} = $template->get_area("$i-image");
    $template->clear_area("$i-image");
  }

  $template->clear_areas('active-banner', 'no-active-banner');

  my $t_never_exp = $template->get_area('expire-never');
  my $t_date_exp = $template->get_area('expire-date');
  my $t_date_exp_yes = $template->get_area('expire-date-yes');
  my $t_click_exp = $template->get_area('expire-click');
  my $t_click_exp_yes = $template->get_area('expire-click-yes');
  my $t_show_exp = $template->get_area('expire-show');
  my $t_show_exp_yes = $template->get_area('expire-show-yes');
  $template->clear_areas('expire-never', 'expire-date', 'expire-date-yes',
	'expire-click', 'expire-click-yes', 'expire-show', 'expire-show-yes');

  my $stat_total_expired = 0;
  my $stat_total_active = 0;

  while ($row = $sth->fetchrow_hashref) {
    my $cps = 0;
    if ($row->{showed} > 0) {
      $cps = sprintf("%.02f", 100*$row->{clicked}/$row->{showed});
    }
    my $exp;
    if ((($row->{stop} eq 'date')and($row->{day} eq '2000-00-00'))or(($row->{stop} eq 'show')and($row->{initshow} eq '0'))or(($row->{stop} eq 'click')and($row->{initclick} eq '0'))) {
      $exp = $t_never_exp;
      $stat_total_active++ if ($row->{active} eq 'active');
    } elsif (($row->{stop} eq 'date')and($row->{day} ne '2000-00-00')) {
      if ($row->{tdd} > $row->{tdn}) {
        $exp = $t_date_exp;
        $stat_total_active++ if ($row->{active} eq 'active');
      } else {
        $exp = $t_date_exp_yes;
        $stat_total_expired++;
      }
    } elsif (($row->{stop} eq 'click')and($row->{initclick} != 0)) {
      if ($row->{initclick} > $row->{clicked}) {
        $exp = $t_click_exp;
        $stat_total_active++ if ($row->{active} eq 'active');
      } else {
        $exp = $t_click_exp_yes;
        $stat_total_expired++;
      }
    } elsif (($row->{stop} eq 'show')and($row->{initshow} != 0)) {
      if ($row->{initshow} > $row->{showed}) {
        $exp = $t_show_exp;
        $stat_total_active++ if ($row->{active} eq 'active');
      } else {
        $exp = $t_show_exp_yes;
        $stat_total_expired++;
      }
    } else {
      $exp = $t_never_exp;
      $stat_total_active++ if ($row->{active} eq 'active');
    }
    $exp = Template::text_replace($exp, 'date-expire', $row->{day});
    $exp = Template::text_replace($exp, 'click-expire', $row->{initclick});
    $exp = Template::text_replace($exp, 'show-expire', $row->{initshow});
    my %in = (
	'id' => $row->{id},
	'name' => $row->{name},
	'stop' => $exp,
	'b_type' => $images_type{$row->{b_type}},
	'active' => ($row->{active} eq 'active' ? $banner_active : $banner_noactive),
	'clicks' => $row->{clicked},
	'shows' => $row->{showed},
	'clickstoday' => 0,
	'showstoday' => 0,
	'cps' => sprintf("%.02f", $cps),
	'cpstoday' => '0.00'
    );
    @list = (@list, \%in);
    $list_id{$row->{id}} = $#list;
  }
  $sth->finish();

  $q = "select bid as id, sum(stat.clicks) as clicks, sum(stat.shows) as shows from $ver\_stat as stat where stat.d=now() group by bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    if (exists($list_id{$row->{id}})) {
      $list[$list_id{$row->{id}}]->{clickstoday} = $row->{clicks};
      $list[$list_id{$row->{id}}]->{showstoday} = $row->{shows};
      $list[$list_id{$row->{id}}]->{cpstoday} = sprintf("%.02f", 100*$row->{clicks}/$row->{shows}) if ($row->{shows} > 0);
    }
  }
  $sth->finish();

  my $down_arrow = $template->get_area('down_arrow');
  my $top_arrow = $template->get_area('top_arrow');
  $template->clear_areas('down_arrow', 'top_arrow');

  ($template, @list) = sort_main_banner($template, $down_arrow, $top_arrow, @list);

  my %rplc = (
	'name-arrow' => '',
	'order-name' => '',
	'type-arrow' => '',
	'order-type' => '',
	'exp-arrow' => '',
	'order-exp' => '',
	'show-arrow' => '',
	'order-show' => '',
	'click-arrow' => '',
	'order-click' => '',
	'acps-arrow' => '',
	'order-acps' => '',
	'acpst-arrow' => '',
	'order-acpst' => ''
  );
  $template->replace_hash(%rplc);


  if ($#list == -1) {
    my $t = $template->get_area('banners-lines-none');
    $template->replace('banners-lines', $t);
  } else {
    my $t = $template->get_area('banners-lines');
    $template->make_for_array('banners-lines', $t, @list);
  }

  $template->clear_area('banners-lines');
  $template->clear_area('banners-lines-none');

  #stat-banners#
  $template->replace('stat-total-banners', $#list+1);
  $template->replace('stat-expired-banners', $stat_total_expired);
  $template->replace('stat-active-banners', $stat_total_active);


  #stat-week#

  my $statline = $template->get_area('stat-week');
  $template->clear_area('stat-week');
  @list = ();
  for ($i = 0; $i<7; $i++) {
    my %in = (
	'day' => $i,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
    );
    @list = (@list, \%in);
  }
  $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, stat.d as d, to_days(now()) - to_days(d) as dif
  	from $ver\_stat as stat, $ver\_banners as banners, $ver\_users2banners as users2banners where stat.bid=banners.id and banners.id=users2banners.bid and
  	users2banners.uid=$initialuserid and to_days(now()) - to_days(d)<7 group by stat.d";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$row->{dif}]->{clicks} = $row->{clicks};
    $list[$row->{dif}]->{shows} = $row->{shows};
    $list[$row->{dif}]->{date} = $row->{d};
  }
  my $max_clicks = 0;
  my $max_shows = 0;
  $q = "select curdate()";
  for ($i = 1; $i<7; $i++) {
    $q .= ", date_sub(curdate(), interval $i day)";
  }
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  $row = $sth->fetchrow_arrayref;
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{date} = $row->[$i];
  }


  for ($i = 0; $i<7; $i++) {
    $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
    $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{clicks_height} = sprintf("%d", 200*$list[$i]->{clicks}/$max_clicks);
    $list[$i]->{shows_height} = sprintf("%d", 200*$list[$i]->{shows}/$max_shows);
  }
  $template->make_for_array('stat-week', $statline, reverse @list);


  #stat-day#

  my $statline = $template->get_area('stat-day');
  $template->clear_area('stat-day');
  @list = ();
  for ($i = 0; $i<12; $i++) {
    my %in = (
	'day' => $i,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
    );
    @list = (@list, \%in);
  }
  my $floor = "FLOOR((unix_timestamp(now()) - unix_timestamp(date_add(d, interval h hour)))/3600)";
  $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, date_add(stat.d, interval h hour) as d, stat.h as h,
   	$floor as dif from $ver\_stat as stat, $ver\_banners as banners, $ver\_users2banners as users2banners where stat.bid=banners.id and banners.id=users2banners.bid and
   	users2banners.uid=$initialuserid and $floor < 12 group by $floor order by $floor";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$row->{dif}]->{clicks} = $row->{clicks};
    $list[$row->{dif}]->{shows} = $row->{shows};
    $list[$row->{dif}]->{date} = $row->{d};
  }
  my $max_clicks = 0;
  my $max_shows = 0;

  for ($i = 0; $i<12; $i++) {
    $list[$i]->{date} = {$i};
  }


  for ($i = 0; $i<12; $i++) {
    $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
    $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<12; $i++) {
    $list[$i]->{clicks_height} = sprintf("%d", 200*$list[$i]->{clicks}/$max_clicks);
    $list[$i]->{shows_height} = sprintf("%d", 200*$list[$i]->{shows}/$max_shows);
    $list[$i]->{date} = -$i." h";
  }
  $template->make_for_array('stat-day', $statline, reverse @list);

  $template->print(%keys);
  exit;
}



sub NavigateBanners {
  $keys{order} = $cookie{order_ban};

  $template = new Template('tmpl/banners.html');
  my $tid = sprintf("%d", $keys{tid});

  $q = "select id, name, stop, b_type, active, weight from $ver\_banners where parent=$tid order by id";

  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  my %list_id;
  my %images_type;
  my $i;

  for $i ('image', 'html', 'swf', 'dcr', 'mov', 'rpm', 'js', 'java') {
    $images_type{$i} = $template->get_area("$i-image");
    $template->clear_area("$i-image");
  }

  $template->clear_areas('active-banner', 'no-active-banner');

  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'id' => $row->{id},
	'name' => $row->{name},
	'stop' => $row->{stop},
	'b_type' => $images_type{$row->{b_type}},
	'clicks' => 0,
	'shows' => 0,
	'clickstoday' => 0,
	'showstoday' => 0,
	'cps' => 0,
	'weight' => $row->{weight},
	'cpstoday' => 0
    );
    @list = (@list, \%in);
    $list_id{$row->{id}} = $#list;
  }
  $sth->finish();

  $q = "select id, sum(clicked) as clicks, sum(showed) as shows from $ver\_banners where parent=$tid group by id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$list_id{$row->{id}}]->{clicks} = $row->{clicks};
    $list[$list_id{$row->{id}}]->{shows} = $row->{shows};
    $list[$list_id{$row->{id}}]->{cps} = sprintf("%.02f", 100*$row->{clicks}/$row->{shows}) if ($row->{shows} > 0);
  }
  $sth->finish();

  $q = "select bid as id, sum(stat.clicks) as clicks, sum(stat.shows) as shows from $ver\_stat as stat, $ver\_banners as banners where stat.d=now() and stat.bid=banners.id and banners.parent=$tid group by bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$list_id{$row->{id}}]->{clickstoday} = $row->{clicks};
    $list[$list_id{$row->{id}}]->{showstoday} = $row->{shows};
    $list[$list_id{$row->{id}}]->{cpstoday} = sprintf("%.02f", 100*$row->{clicks}/$row->{shows}) if ($row->{shows} > 0);
  }
  $sth->finish();

  my $down_arrow = $template->get_area('down_arrow');
  my $top_arrow = $template->get_area('top_arrow');
  $template->clear_areas('down_arrow', 'top_arrow');

  ($template, @list) = sort_main_banner($template, $down_arrow, $top_arrow, @list);

  my $bid = sprintf("%d", $keys{bid});

  my $new_bid = $bid;
  my $flag = 0;

  if ($keys{dir} eq 'prev') {
    for $i (reverse @list) {
      if ($flag == 1) {
        $new_bid = $i->{id};
        last;
      }
      if ($i->{id} eq $bid) {
        $flag = 1;
      }
    }
  } else {
    for $i (@list) {
      if ($flag == 1) {
        $new_bid = $i->{id};
        last;
      }
      if ($i->{id} eq $bid) {
        $flag = 1;
      }
    }
  }

  print "Location: admin.cgi?page=viewbanner&bid=$new_bid&tid=$tid\n\n";
  exit;


}



sub NavigateBanners_banner {
  $keys{order} = $cookie{order_ban};

  $template = new Template('tmpl/banners.html');
  my $tid = sprintf("%d", $keys{tid});

  $q = "select banners.id as id, banners.name as name, banners.stop as stop, banners.b_type as b_type, banners.active as active
  	from $ver\_banners as banners, $ver\_users2banners as users2banners where banners.id=users2banners.bid and users2banners.uid=$initialuserid order by banners.id";

  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  my %list_id;
  my %images_type;
  my $i;

  for $i ('image', 'html', 'swf', 'dcr', 'mov', 'rpm', 'js', 'java') {
    $images_type{$i} = $template->get_area("$i-image");
    $template->clear_area("$i-image");
  }

  $template->clear_areas('active-banner', 'no-active-banner');

  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'id' => $row->{id},
	'name' => $row->{name},
	'stop' => $row->{stop},
	'b_type' => $images_type{$row->{b_type}},
	'clicks' => 0,
	'shows' => 0,
	'clickstoday' => 0,
	'showstoday' => 0,
	'cps' => 0,
	'cpstoday' => 0
    );
    @list = (@list, \%in);
    $list_id{$row->{id}} = $#list;
  }
  $sth->finish();

  $q = "select stat.bid as id, sum(stat.clicks) as clicks, sum(stat.shows) as shows from $ver\_stat as stat, $ver\_users2banners as users2banners where
  	stat.bid=users2banners.bid and users2banners.uid=$initialuserid group by stat.bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$list_id{$row->{id}}]->{clicks} = $row->{clicks};
    $list[$list_id{$row->{id}}]->{shows} = $row->{shows};
    $list[$list_id{$row->{id}}]->{cps} = sprintf("%.02f", 100*$row->{clicks}/$row->{shows}) if ($row->{shows} > 0);
  }
  $sth->finish();

  $q = "select stat.bid as id, sum(stat.clicks) as clicks, sum(stat.shows) as shows from $ver\_stat as stat, $ver\_users2banners as users2banners where stat.d=now() and
  	stat.bid=users2banners.bid and users2banners.uid=$initialuserid group by stat.bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$list_id{$row->{id}}]->{clickstoday} = $row->{clicks};
    $list[$list_id{$row->{id}}]->{showstoday} = $row->{shows};
    $list[$list_id{$row->{id}}]->{cpstoday} = sprintf("%.02f", 100*$row->{clicks}/$row->{shows}) if ($row->{shows} > 0);
  }
  $sth->finish();

  my $down_arrow = $template->get_area('down_arrow');
  my $top_arrow = $template->get_area('top_arrow');
  $template->clear_areas('down_arrow', 'top_arrow');

  ($template, @list) = sort_main_banner($template, $down_arrow, $top_arrow, @list);


  my $bid = sprintf("%d", $keys{bid});

  my $new_bid = $bid;
  my $flag = 0;

  if ($keys{dir} eq 'prev') {
    for $i (reverse @list) {
      if ($flag == 1) {
        $new_bid = $i->{id};
        last;
      }
      if ($i->{id} eq $bid) {
        $flag = 1;
      }
    }
  } else {
    for $i (@list) {
      if ($flag == 1) {
        $new_bid = $i->{id};
        last;
      }
      if ($i->{id} eq $bid) {
        $flag = 1;
      }
    }
  }

  print "Location: admin.cgi?page=viewbanner&bid=$new_bid&tid=$tid\n\n";
  exit;
}


sub Settings {
  if ($keys{action} eq 'set') {
    $template = new Template('tmpl/svars.pm');
    my $ignoreIP = "'".(join '\', \'',grep {/\d/} ( split /\s/, $keys{ignoreip}))."'";
    my %in = (
    	'dupviewtime' => sprintf("%d", $keys{timeview}),
    	'dupclicktime' => sprintf("%d", $keys{timeclick}),
    	'maxbannersize' => sprintf("%d", $keys{maxbannersize}),
    	'ignoreIP' => $ignoreIP,
    	'server_path' => s_q($keys{installurl}),
    	'sendmail_path' => s_q($keys{sendmailpath}),
    	'imagesurl' => $keys{imagesurl},
    	'imagespath' => $keys{imagespath},
#	'order' => $vars_order,
    );
    $template->replace_hash(%in);
    open FILE, ">svars.pm";
    print FILE $template->{code};
    close FILE;
    print "Location: admin.cgi?page=settings\n\n";
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/settings.html');
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
  $template->print(%keys);
  exit;
}

sub ShowBannerArea {
  my $cookie = '';
  $cookie = "\nSet-cookie: order_ban=$keys{order}" if ($keys{order});
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache$cookie\n\n";
  $keys{order} = $cookie{order_ban} if ($keys{order} eq '');

  $template = new Template('tmpl/banners.html');
  my $tid = sprintf("%d", $keys{tid});

  $q = "select id, name, stop, b_type, active, showed, clicked, day, weight, date_format(day, '%m-%d-%Y') as dayn, now() as now, initclick, initshow, clicked, showed, to_days(now()) as tdn, to_days(day) as tdd from $ver\_banners as banners where parent=$tid order by id";

  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  my %list_id;
  my $banner_active = $template->get_area('active-banner');
  my $banner_noactive = $template->get_area('no-active-banner');
  my %images_type;
  my $i;

  for $i ('image', 'html', 'swf', 'dcr', 'mov', 'rpm', 'js', 'java') {
    $images_type{$i} = $template->get_area("$i-image");
    $template->clear_area("$i-image");
  }

  $template->clear_areas('active-banner', 'no-active-banner');

  my $t_never_exp = $template->get_area('expire-never');
  my $t_date_exp = $template->get_area('expire-date');
  my $t_date_exp_yes = $template->get_area('expire-date-yes');
  my $t_click_exp = $template->get_area('expire-click');
  my $t_click_exp_yes = $template->get_area('expire-click-yes');
  my $t_show_exp = $template->get_area('expire-show');
  my $t_show_exp_yes = $template->get_area('expire-show-yes');
  $template->clear_areas('expire-never', 'expire-date', 'expire-date-yes',
	'expire-click', 'expire-click-yes', 'expire-show', 'expire-show-yes');

  my $stat_total_expired = 0;
  my $stat_total_active = 0;

  while ($row = $sth->fetchrow_hashref) {
    my $cps = 0;
    if ($row->{showed} > 0) {
      $cps = sprintf("%.02f", 100*$row->{clicked}/$row->{showed});
    }
    my $exp;
    if ((($row->{stop} eq 'date')and($row->{day} eq '2000-00-00'))or(($row->{stop} eq 'show')and($row->{initshow} eq '0'))or(($row->{stop} eq 'click')and($row->{initclick} eq '0'))) {
      $exp = $t_never_exp;
      $stat_total_active++ if ($row->{active} eq 'active');
    } elsif (($row->{stop} eq 'date')and($row->{day} ne '2000-00-00')) {
      if ($row->{tdd} > $row->{tdn}) {
        $exp = $t_date_exp;
        $stat_total_active++ if ($row->{active} eq 'active');
      } else {
        $exp = $t_date_exp_yes;
        $stat_total_expired++;
      }
    } elsif (($row->{stop} eq 'click')and($row->{initclick} != 0)) {
      if ($row->{initclick} > $row->{clicked}) {
        $exp = $t_click_exp;
        $stat_total_active++ if ($row->{active} eq 'active');
      } else {
        $exp = $t_click_exp_yes;
        $stat_total_expired++;
      }
    } elsif (($row->{stop} eq 'show')and($row->{initshow} != 0)) {
      if ($row->{initshow} > $row->{showed}) {
        $exp = $t_show_exp;
        $stat_total_active++ if ($row->{active} eq 'active');
      } else {
        $exp = $t_show_exp_yes;
        $stat_total_expired++;
      }
    } else {
      $exp = $t_never_exp;
      $stat_total_active++ if ($row->{active} eq 'active');
    }
    $exp = Template::text_replace($exp, 'date-expire', $row->{dayn});
    $exp = Template::text_replace($exp, 'click-expire', $row->{initclick});
    $exp = Template::text_replace($exp, 'show-expire', $row->{initshow});
    my %in = (
	'id' => $row->{id},
	'name' => $row->{name},
	'stop' => $exp,
	'b_type' => $images_type{$row->{b_type}},
	'active' => ($row->{active} eq 'active' ? 'checked' : ''),
	'clicks' => $row->{clicked},
	'shows' => $row->{showed},
	'clickstoday' => 0,
	'showstoday' => 0,
	'cps' => sprintf("%.02f", $cps),
	'weight' => $row->{weight},
	'cpstoday' => '0.00'
    );
    @list = (@list, \%in);
    $list_id{$row->{id}} = $#list;
  }
  $sth->finish();

  $q = "select bid as id, sum(stat.clicks) as clicks, sum(stat.shows) as shows from $ver\_stat as stat where stat.d=now() group by bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    if (exists($list_id{$row->{id}})) {
      $list[$list_id{$row->{id}}]->{clickstoday} = $row->{clicks};
      $list[$list_id{$row->{id}}]->{showstoday} = $row->{shows};
      $list[$list_id{$row->{id}}]->{cpstoday} = sprintf("%.02f", 100*$row->{clicks}/$row->{shows}) if ($row->{shows} > 0);
    }
  }
  $sth->finish();

  my $down_arrow = $template->get_area('down_arrow');
  my $top_arrow = $template->get_area('top_arrow');
  $template->clear_areas('down_arrow', 'top_arrow');

  ($template, @list) = sort_main_banner($template, $down_arrow, $top_arrow, @list);


  my %rplc = (
	'name-arrow' => '',
	'order-name' => '',
	'type-arrow' => '',
	'order-type' => '',
	'exp-arrow' => '',
	'order-exp' => '',
	'show-arrow' => '',
	'order-show' => '',
	'click-arrow' => '',
	'order-click' => '',
	'acps-arrow' => '',
	'order-acps' => '',
	'acpst-arrow' => '',
	'order-acpst' => ''
  );
  $template->replace_hash(%rplc);


  if ($#list == -1) {
    my $t = $template->get_area('banners-lines-none');
    $template->replace('banners-lines', $t);
  } else {
    my $t = $template->get_area('banners-lines');
    $template->make_for_array('banners-lines', $t, @list);
  }

  $template->clear_area('banners-lines');
  $template->clear_area('banners-lines-none');

  #stat-banners#
  $template->replace('stat-total-banners', $#list+1);
  $template->replace('stat-expired-banners', $stat_total_expired);
  $template->replace('stat-active-banners', $stat_total_active);


  #stat-week#

  my $statline = $template->get_area('stat-week');
  $template->clear_area('stat-week');
  @list = ();
  for ($i = 0; $i<7; $i++) {
    my %in = (
	'day' => $i,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
    );
    @list = (@list, \%in);
  }
  $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, stat.d as d, to_days(now()) - to_days(d) as dif from $ver\_stat as stat, $ver\_banners as banners where stat.bid=banners.id and banners.parent=$tid and to_days(now()) - to_days(d)<7 group by stat.d";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    next if ($row->{dif} < 0);
    $list[$row->{dif}]->{clicks} = $row->{clicks};
    $list[$row->{dif}]->{shows} = $row->{shows};
    $list[$row->{dif}]->{date} = $row->{d};
  }
  my $max_clicks = 0;
  my $max_shows = 0;
  $q = "select curdate()";
  for ($i = 1; $i<7; $i++) {
    $q .= ", date_sub(curdate(), interval $i day)";
  }
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  $row = $sth->fetchrow_arrayref;
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{date} = $row->[$i];
  }


  for ($i = 0; $i<7; $i++) {
    $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
    $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{clicks_height} = sprintf("%d", 200*$list[$i]->{clicks}/$max_clicks);
    $list[$i]->{shows_height} = sprintf("%d", 200*$list[$i]->{shows}/$max_shows);
  }
  $template->make_for_array('stat-week', $statline, reverse @list);


  #stat-day#

  my $statline = $template->get_area('stat-day');
  $template->clear_area('stat-day');
  @list = ();
  for ($i = 0; $i<12; $i++) {
    my %in = (
	'day' => $i,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
    );
    @list = (@list, \%in);
  }
  my $floor = "FLOOR((unix_timestamp(now()) - unix_timestamp(date_add(d, interval h hour)))/3600)";
  $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, date_add(stat.d, interval h hour) as d, stat.h as h, $floor as dif from $ver\_stat as stat, $ver\_banners as banners where stat.bid=banners.id and banners.parent=$tid and $floor < 12 group by $floor order by $floor";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    next if ($row->{dif} < 0);
    $list[$row->{dif}]->{clicks} = $row->{clicks};
    $list[$row->{dif}]->{shows} = $row->{shows};
    $list[$row->{dif}]->{date} = $row->{d};
  }
  my $max_clicks = 0;
  my $max_shows = 0;

  for ($i = 0; $i<12; $i++) {
    $list[$i]->{date} = {$i};
  }


  for ($i = 0; $i<12; $i++) {
    $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
    $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<12; $i++) {
    $list[$i]->{clicks_height} = sprintf("%d", 200*$list[$i]->{clicks}/$max_clicks);
    $list[$i]->{shows_height} = sprintf("%d", 200*$list[$i]->{shows}/$max_shows);
    $list[$i]->{date} = -$i." h";
  }
  $template->make_for_array('stat-day', $statline, reverse @list);

  $template->print(%keys);
  exit;
}


sub sort_main_banner {
  my ($template, $down_arrow, $top_arrow, @list) = @_;
  if ($keys{order} eq 'type') {
    @list = sort {$a->{b_type} cmp $b->{b_type} or $a->{id} <=> $b->{id}} @list;
    $template->replace('type-arrow', $top_arrow);
    $template->replace('order-type', 'rev');
  } elsif ($keys{order} eq 'revtype') {
    @list = sort {$b->{b_type} cmp $a->{b_type} or $b->{id} <=> $a->{id}} @list;
    $template->replace('type-arrow', $down_arrow);
  } elsif ($keys{order} eq 'exp') {
    @list = sort {$a->{stop} cmp $b->{stop} or $a->{id} <=> $b->{id}} @list;
    $template->replace('order-exp', 'rev');
    $template->replace('exp-arrow', $top_arrow);
  } elsif ($keys{order} eq 'revexp') {
    @list = sort {$b->{stop} cmp $a->{stop} or $b->{id} <=> $a->{id}} @list;
    $template->replace('exp-arrow', $down_arrow);
  } elsif ($keys{order} eq 'click') {
    @list = sort {$b->{clicks} <=> $a->{clicks} or $b->{id} <=> $a->{id}} @list;
    $template->replace('order-click', 'rev');
    $template->replace('click-arrow', $top_arrow);
  } elsif ($keys{order} eq 'revclick') {
    @list = sort {$a->{clicks} <=> $b->{clicks} or $a->{id} <=> $b->{id}} @list;
    $template->replace('click-arrow', $down_arrow);
  } elsif ($keys{order} eq 'show') {
    @list = sort {$b->{shows} <=> $a->{shows} or $b->{id} <=> $a->{id}} @list;
    $template->replace('show-arrow', $top_arrow);
    $template->replace('order-show', 'rev');
  } elsif ($keys{order} eq 'revshow') {
    @list = sort {$a->{shows} <=> $b->{shows} or $a->{id} <=> $b->{id}} @list;
    $template->replace('show-arrow', $down_arrow);
  } elsif ($keys{order} eq 'acps') {
    @list = sort {$b->{cps} <=> $a->{cps} or $b->{id} <=> $a->{id}} @list;
    $template->replace('order-acps', 'rev');
    $template->replace('acps-arrow', $top_arrow);
  } elsif ($keys{order} eq 'revacps') {
    @list = sort {$a->{cps} <=> $b->{cps} or $a->{id} <=> $b->{id}} @list;
    $template->replace('acps-arrow', $down_arrow);
  } elsif ($keys{order} eq 'acpst') {
    @list = sort {$b->{cpstoday} <=> $a->{cpstoday} or $b->{id} <=> $a->{id}} @list;
    $template->replace('order-acpst', 'rev');
    $template->replace('acpst-arrow', $top_arrow);
  } elsif ($keys{order} eq 'revacpst') {
    @list = sort {$a->{cpstoday} <=> $b->{cpstoday} or $a->{id} <=> $b->{id}} @list;
    $template->replace('acpst-arrow', $down_arrow);
  } elsif ($keys{order} eq 'revname') {
    @list = sort {$b->{name} cmp $a->{name} or $b->{id} <=> $a->{id}} @list;
    $template->replace('name-arrow', $down_arrow);
  } else {
    @list = sort {$a->{name} cmp $b->{name} or $a->{id} <=> $b->{id}} @list;
    $template->replace('name-arrow', $top_arrow);
    $template->replace('order-name', 'rev');
  }
  return ($template, @list);
}

sub sort_main_page {
  my ($template, $down_arrow, $top_arrow, @list) = @_;
  if ($keys{order} eq 'col') {
    @list = sort {$b->{count} <=> $a->{count} or $b->{id} <=> $a->{id}} @list;
    $template->replace('order-col', 'rev');
    $template->replace('col-sort-image', $top_arrow);
  } elsif ($keys{order} eq 'revcol') {
    @list = sort {$a->{count} <=> $b->{count} or $a->{id} <=> $b->{id}} @list;
    $template->replace('col-sort-image', $down_arrow);
  } elsif ($keys{order} eq 'show') {
    @list = sort {$b->{shows} <=> $a->{shows} or $b->{id} <=> $a->{id}} @list;
    $template->replace('order-show', 'rev');
    $template->replace('show-sort-image', $top_arrow);
  } elsif ($keys{order} eq 'revshow') {
    @list = sort {$a->{shows} <=> $b->{shows} or $a->{id} <=> $b->{id}} @list;
    $template->replace('show-sort-image', $down_arrow);
  } elsif ($keys{order} eq 'click') {
    @list = sort {$b->{clicks} <=> $a->{clicks} or $b->{id} <=> $a->{id}} @list;
    $template->replace('order-click', 'rev');
    $template->replace('click-sort-image', $top_arrow);
  } elsif ($keys{order} eq 'revclick') {
    @list = sort {$a->{clicks} <=> $b->{clicks} or $a->{id} <=> $b->{id}} @list;
    $template->replace('click-sort-image', $down_arrow);
  } elsif ($keys{order} eq 'acps') {
    @list = sort {$b->{cps} <=> $a->{cps} or $b->{id} <=> $a->{id}} @list;
    $template->replace('order-acps', 'rev');
    $template->replace('acps-sort-image', $top_arrow);
  } elsif ($keys{order} eq 'revacps') {
    @list = sort {$a->{cps} <=> $b->{cps} or $a->{id} <=> $b->{id}} @list;
    $template->replace('acps-sort-image', $down_arrow);
  } elsif ($keys{order} eq 'acpst') {
    @list = sort {$b->{cpstoday} <=> $a->{cpstoday} or $b->{id} <=> $a->{id}} @list;
    $template->replace('order-acpst', 'rev');
    $template->replace('acpst-sort-image', $top_arrow);
  } elsif ($keys{order} eq 'revacpst') {
    @list = sort {$a->{cpstoday} <=> $b->{cpstoday} or $a->{id} <=> $b->{id}} @list;
    $template->replace('acpst-sort-image', $down_arrow);
  } elsif ($keys{order} eq 'revtypes') {
    @list = sort {$b->{name} cmp $a->{name} or $b->{id} <=> $a->{id}} @list;
    $template->replace('types-sort-image', $top_arrow);
  } else {
    @list = sort {$a->{name} cmp $b->{name} or $a->{id} <=> $b->{id}} @list;
    $template->replace('order-types', 'rev');
    $template->replace('types-sort-image', $down_arrow);
  }
  return ($template, @list);
}

sub StatHourBanners {
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";

  $template = new Template('tmpl/stat.hour.banners.html');
  my $bid = sprintf("%d", $keys{bid});
  my $d = $dbh->quote($keys{date});
  my $stat_title = '';
  if ($keys{range} eq 'average') {
    $stat_title = $template->get_area('title-average');
    $q = "select sum(clicks) as clicks, sum(shows) as shows, h from $ver\_stat as stat where bid=$bid group by h order by h";
  } else {
    $stat_title = $template->get_area('title-day');
    $q = "select sum(clicks) as clicks, sum(shows) as shows, h from $ver\_stat as stat where bid=$bid and d=$d group by h order by h";
  }
  $template->replace("stat-title", $stat_title);
  $template->clear_areas('title-average', 'title-day');
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'shows' => $row->{shows},
    	'clicks' => $row->{clicks},
    	'h' => $row->{h}
    );
    @list = (@list, \%in);
  }
  $sth->finish();
  my $t = $template->get_area('stat-line');
  $template->clear_area('stat-line');
  $template->make_for_array('stat-line', $t, @list);

  $template->print_self(%keys);
  exit;
}

sub StatIP {
  print "Content-type: text/plain\n\n";
  my $bid = sprintf("%d", $keys{bid});
  open FILE, "<logs/$bid";
  my $date = '';
  my $flag = 0;
  while (my $a = <FILE>) {
    chomp $a;
    my ($t, $act, $ip) = split /\t/, $a;
    my $ndate = sprintf("%02d-%s-%04d", (localtime($t))[3], ('Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')[(localtime($t))[4]], (localtime($t))[5]+1900);
    if ($keys{mode} eq 'imps') {
      next if ($act ne 'show');
      if ($ndate ne $date) {
        print "$ndate\n";
        $date = $ndate;
      }
      print "$ip\n";
      $flag = 1;
    }
    if ($keys{mode} eq 'clicks') {
      next if ($act ne 'click');
      if ($ndate ne $date) {
        print "$ndate\n";
        $date = $ndate;
      }
      print "$ip\n";
      $flag = 1;
    }
  }
  if ($flag == 0) {
    print "No IP saved";
  }
  exit;
}

sub StatCampaignYear {
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";

  $template = new Template('tmpl/stat.campaign.html');

  my $statline = $template->get_area('stat-year');
  $template->clear_area('stat-year');
  my @list = ();
  my $i;
  my @month = ('jan', 'feb', 'mar', 'apr', 'mai', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
  for ($i = 0; $i<12; $i++) {
    my %in = (
	'month' => $month[$i],
	'month_num' => $i,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
    );
    @list = (@list, \%in);
  }
  my ($camp, $ban);
  if ($keys{tid}) {
    $camp = " and banners.parent = $keys{tid}";
  }
  if ($keys{bid}) {
    $ban = " and banners.id = $keys{bid}";
  }
  $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, month(stat.d) as month from $ver\_stat as stat, $ver\_banners as banners where stat.bid=banners.id and year(now()) = year(d) $camp $ban group by month(stat.d)";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $list[$row->{month}-1]->{clicks} = $row->{clicks};
    $list[$row->{month}-1]->{shows} = $row->{shows};
  }
  my $max_clicks = 0;
  my $max_shows = 0;
  my $min_clicks = 1000000;
  my $min_shows = 1000000;

  for ($i = 0; $i<12; $i++) {
    $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
    $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
    $min_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} < $min_clicks);
    $min_shows = $list[$i]->{shows} if ($list[$i]->{shows} < $min_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<12; $i++) {
    $list[$i]->{clicks_width} = sprintf("%d", 300*($list[$i]->{clicks}-($min_clicks*6)/7)/($max_clicks-$min_clicks*6/7));
    $list[$i]->{shows_width} = sprintf("%d", 300*($list[$i]->{shows}-$min_shows*6/7)/($max_shows-$min_shows*6/7));
  }
  $template->make_for_array('stat-year', $statline, @list);

  if (sprintf("%d", $keys{month}) > 0) {
    $keys{month} = sprintf("%d", $keys{month});
    $keys{month} = 0 if ($keys{month} > 12);
  } elsif ($keys{month} ne '') {
    $keys{month} = 0;
  } else {
    $keys{month} = (localtime(time()))[4];
  }
#  if ($keys{month}  0) {
    my $statline = $template->get_area('stat-month');
    $template->clear_area('stat-month');
    my @list = ();
    my $i;
    my $mon = (localtime(time()))[4]+1;
    $mon = $keys{month}+1 if ($keys{month} >= 0);
    $template->replace('cur-month', $month[$mon-1]);
    for ($i = 0; $i<31; $i++) {
      my %in = (
	'day' => $i+1,
	'clicks' => 0,
	'shows' => 0,
	'clicks_height' => 0,
	'shows_height' => 0
      );
      @list = (@list, \%in);
    }
    $q = "select sum(stat.clicks) as clicks, sum(stat.shows) as shows, DAYOFMONTH(stat.d) as day from $ver\_stat as stat, $ver\_banners as banners where stat.bid=banners.id and year(now()) = year(stat.d) and month(stat.d)=$mon $camp $ban group by DAYOFMONTH(stat.d)";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    while ($row = $sth->fetchrow_hashref) {
      $list[$row->{day}-1]->{clicks} = $row->{clicks};
      $list[$row->{day}-1]->{shows} = $row->{shows};
    }
    my $max_clicks = 0;
    my $max_shows = 0;
    my $min_clicks = 1000000;
    my $min_shows = 1000000;

    for ($i = 0; $i<31; $i++) {
      $max_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} > $max_clicks);
      $max_shows = $list[$i]->{shows} if ($list[$i]->{shows} > $max_shows);
      $min_clicks = $list[$i]->{clicks} if ($list[$i]->{clicks} < $min_clicks);
      $min_shows = $list[$i]->{shows} if ($list[$i]->{shows} < $min_shows);
    }
    $max_clicks = 1 if ($max_clicks == 0);
    $max_shows = 1 if ($max_shows == 0);
    for ($i = 0; $i<31; $i++) {
      $list[$i]->{clicks_width} = sprintf("%d", 300*($list[$i]->{clicks}-($min_clicks*6)/7)/($max_clicks-$min_clicks*6/7));
      $list[$i]->{shows_width} = sprintf("%d", 300*($list[$i]->{shows}-$min_shows*6/7)/($max_shows-$min_shows*6/7));
    }
    $template->make_for_array('stat-month', $statline, @list);


#  }
  if ($keys{bid} eq '') {
    $template->clear_area('for-banner-only');
  }
  $template->print(%keys);
  exit;
}

sub UsersArea {
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/user.area.html');
  $q = "select * from $ver\_users order by id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @lines = ();
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'user-id' => $row->{id},
	'user-name' => $row->{name},
	'user-ip' => $row->{last_ip},
	'user-time' => $row->{last_d},
	'user-right' => $row->{access}
    );
    @lines = (@lines, \%in);
  }
  my $t = $template->get_area('user-lines');
  $template->make_for_array('user-lines', $t, @lines);
  $template->clear_area('user-lines');

  $template->print(%keys);
  exit;
}

sub UserLogin {


  my $code = <DATA>;
  eval (join '', map {chr(hex($_))} split /\s+/, $code) or print "Content-type: text/html\n\n$@";
  exit;

  my $username = $keys{username};
  my $passwd = $keys{passwd};
  my $qusername = $dbh->quote($username);
  $q = "select passwd from $ver\_users where name=$qusername";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $logged = 0;
  if ($row = $sth->fetchrow_hashref) {
    if ($row->{passwd} eq $passwd) {
      $logged = 1;
    }
  }
  if ($logged == 1) {
    $passwd = crypt($passwd, "Md");
    print "Set-cookie: username=$username\nSet-cookie: passwd=$passwd\nLocation: admin.cgi\n\n";
    &AdminLog($keys{username});
  } else {
    print "Location: admin.cgi\n\n";
    exit;
  }
  exit;
}


sub ViewBanner {
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/view.banner.html');
  my $bid = sprintf("%d", $keys{bid});
  $q = "select *, now() as now, to_days(now()) as tdn, to_days(day) as tdd from $ver\_banners where id=$bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $t_never_exp = $template->get_area('expire-never');
  my $t_date_exp = $template->get_area('expire-date');
  my $t_date_exp_yes = $template->get_area('expire-date-yes');
  my $t_click_exp = $template->get_area('expire-click');
  my $t_click_exp_yes = $template->get_area('expire-click-yes');
  my $t_show_exp = $template->get_area('expire-show');
  my $t_show_exp_yes = $template->get_area('expire-show-yes');

  $template->clear_areas('expire-never', 'expire-date', 'expire-date-yes',
	'expire-click', 'expire-click-yes', 'expire-show', 'expire-show-yes');


  if ($row = $sth->fetchrow_hashref) {
    my $exp;
    if ((($row->{stop} eq 'date')and($row->{day} eq '2000-00-00'))or(($row->{stop} eq 'show')and($row->{initshow} eq '0'))or(($row->{stop} eq 'click')and($row->{initclick} eq '0'))) {
      $exp = $t_never_exp;
    } elsif (($row->{stop} eq 'date')and($row->{day} ne '2000-00-00')) {
      if ($row->{tdd} > $row->{tdn}) {
        $exp = $t_date_exp;
      } else {
        $exp = $t_date_exp_yes;
      }
    } elsif (($row->{stop} eq 'click')and($row->{initclick} != 0)) {
      if ($row->{initclick} > $row->{clicked}) {
        $exp = $t_click_exp;
      } else {
        $exp = $t_click_exp_yes;
      }
    } elsif (($row->{stop} eq 'show')and($row->{initshow} != 0)) {
      if ($row->{initshow} > $row->{showed}) {
        $exp = $t_show_exp;
      } else {
        $exp = $t_show_exp_yes;
      }
    } else {
      $exp = $t_never_exp;
    }
    $exp = Template::text_replace($exp, 'date-expire', $row->{day});
    $exp = Template::text_replace($exp, 'click-expire', $row->{initclick});
    $exp = Template::text_replace($exp, 'show-expire', $row->{initshow});

    $template->replace('ban_exp', $exp);

    my $typet = new Template("tmpl/types/$row->{b_type}.html");
    my %rpls = (
	'url' => $row->{url},
	'banner_url' => "$vars_path_to_images/banners/".$row->{id}.".".$row->{ext},
	'width' => $row->{b_width},
	'height' => $row->{b_height},
	'banner_text' => $row->{bantext}
    );
    $typet->replace_hash(%rpls);


    %rpls = (
	'name' => s_q($row->{name}),
	'b_desc' => $row->{b_desc},
	'url' => s_q($row->{url}),
	'ban_type' => $row->{b_type},
	'banner' => $typet->{code}
	);
    $template->replace_hash(%rpls);
  }

  $q = "select sum(shows) as shows, sum(clicks) as clicks, d from $ver\_stat as stat where bid=$bid group by d order by d desc";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $t = $template->get_area("stat-line");
  my @line = ();
  my $stat_total_shows = 0;
  my $stat_total_clicks = 0;
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'stat-date' => $row->{d},
	'stat-shows' => $row->{shows},
	'stat-clicks' => $row->{clicks}
    );
    $stat_total_shows += $row->{shows};
    $stat_total_clicks += $row->{clicks};
    @line = (@line, \%in);
  }
  if ($#line > -1) {
    $template->make_for_array('stat-line', $t, @line);
  } else {
	$template->replace('stat-line', $template->get_area('no-stat-line'));
  }
  $template->replace('stat-total-shows', $stat_total_shows);
  $template->replace('stat-total-clicks', $stat_total_clicks);
  $template->clear_areas('stat-line', 'no-stat-line');

  $template->print(%keys);
  exit;
}

sub get_check_doc {}

sub ViewBanner_stat {
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/utypes/statuser/view.banner.html');
  my $bid = sprintf("%d", $keys{bid});
  $q = "select *, now() as now, to_days(now()) as tdn, to_days(day) as tdd from $ver\_banners where id=$bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $t_never_exp = $template->get_area('expire-never');
  my $t_date_exp = $template->get_area('expire-date');
  my $t_date_exp_yes = $template->get_area('expire-date-yes');
  my $t_click_exp = $template->get_area('expire-click');
  my $t_click_exp_yes = $template->get_area('expire-click-yes');
  my $t_show_exp = $template->get_area('expire-show');
  my $t_show_exp_yes = $template->get_area('expire-show-yes');

  $template->clear_areas('expire-never', 'expire-date', 'expire-date-yes',
	'expire-click', 'expire-click-yes', 'expire-show', 'expire-show-yes');


  if ($row = $sth->fetchrow_hashref) {
    my $exp;
    if ((($row->{stop} eq 'date')and($row->{day} eq '2000-00-00'))or(($row->{stop} eq 'show')and($row->{initshow} eq '0'))or(($row->{stop} eq 'click')and($row->{initclick} eq '0'))) {
      $exp = $t_never_exp;
    } elsif (($row->{stop} eq 'date')and($row->{day} ne '2000-00-00')) {
      if ($row->{tdd} > $row->{tdn}) {
        $exp = $t_date_exp;
      } else {
        $exp = $t_date_exp_yes;
      }
    } elsif (($row->{stop} eq 'click')and($row->{initclick} != 0)) {
      if ($row->{initclick} > $row->{clicked}) {
        $exp = $t_click_exp;
      } else {
        $exp = $t_click_exp_yes;
      }
    } elsif (($row->{stop} eq 'show')and($row->{initshow} != 0)) {
      if ($row->{initshow} > $row->{showed}) {
        $exp = $t_show_exp;
      } else {
        $exp = $t_show_exp_yes;
      }
    } else {
      $exp = $t_never_exp;
    }
    $exp = Template::text_replace($exp, 'date-expire', $row->{day});
    $exp = Template::text_replace($exp, 'click-expire', $row->{initclick});
    $exp = Template::text_replace($exp, 'show-expire', $row->{initshow});

    $template->replace('ban_exp', $exp);

    my $typet = new Template("tmpl/types/$row->{b_type}.html");
    my %rpls = (
	'url' => $row->{url},
	'banner_url' => "$vars_path_to_images/banners/".$row->{id}.".".$row->{ext},
	'width' => $row->{b_width},
	'height' => $row->{b_height},
	'banner_text' => $row->{bantext}
    );
    $typet->replace_hash(%rpls);


    %rpls = (
	'name' => s_q($row->{name}),
	'b_desc' => $row->{b_desc},
	'url' => s_q($row->{url}),
	'ban_type' => $row->{b_type},
	'banner' => $typet->{code}
	);
    $template->replace_hash(%rpls);
  }

  $q = "select sum(shows) as shows, sum(clicks) as clicks, d from $ver\_stat as stat where bid=$bid group by d order by d desc";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $t = $template->get_area("stat-line");
  my @line = ();
  my $stat_total_shows = 0;
  my $stat_total_clicks = 0;
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'stat-date' => $row->{d},
	'stat-shows' => $row->{shows},
	'stat-clicks' => $row->{clicks}
    );
    $stat_total_shows += $row->{shows};
    $stat_total_clicks += $row->{clicks};
    @line = (@line, \%in);
  }
  if ($#line > -1) {
    $template->make_for_array('stat-line', $t, @line);
  } else {
	$template->replace('stat-line', $template->get_area('no-stat-line'));
  }
  $template->replace('stat-total-shows', $stat_total_shows);
  $template->replace('stat-total-clicks', $stat_total_clicks);
  $template->clear_areas('stat-line', 'no-stat-line');

  $template->print(%keys);
  exit;
}


sub ViewUser {
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/view.user.html');
  my $uid = sprintf("%d", $keys{uid});
  $q = "select * from $ver\_users where id=$uid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'user-name' => $row->{name},
    	'user-desc' => $row->{descr},
    	'user-acc-type' => $row->{access},
    	'user-email' => $row->{email},
    	'user-url' => $row->{url}
    );
    $template->replace_hash(%in);
  }

  $template->print(%keys);
  exit;
}





















































__END__
a a 20 20 6d 79 20 24 75 73 65 72 6e 61 6d 65 20 3d 20 24 6b 65 79 73 7b 75 73 65 72 6e 61 6d 65 7d 3b a 20 20 6d 79 20 24 70 61 73 73 77 64 20 3d 20 24 6b 65 79 73 7b 70 61 73 73 77 64 7d 3b a 20 20 6d 79 20 24 71 75 73 65 72 6e 61 6d 65 20 3d 20 24 64 62 68 2d 3e 71 75 6f 74 65 28 24 75 73 65 72 6e 61 6d 65 29 3b a 20 20 24 71 20 3d 20 22 73 65 6c 65 63 74 20 70 61 73 73 77 64 20 66 72 6f 6d 20 24 76 65 72 5c 5f 75 73 65 72 73 20 77 68 65 72 65 20 6e 61 6d 65 3d 24 71 75 73 65 72 6e 61 6d 65 22 3b a 20 20 24 73 74 68 20 3d 20 24 64 62 68 2d 3e 70 72 65 70 61 72 65 28 24 71 29 3b a 20 20 24 73 74 68 2d 3e 65 78 65 63 75 74 65 28 29 20 6f 72 20 70 72 69 6e 74 20 24 73 74 68 2d 3e 65 72 72 73 74 72 3b a 20 20 6d 79 20 24 6c 6f 67 67 65 64 20 3d 20 30 3b a 20 20 69 66 20 28 24 72 6f 77 20 3d 20 24 73 74 68 2d 3e 66 65 74 63 68 72 6f 77 5f 68 61 73 68 72 65 66 29 20 7b a 20 20 20 20 69 66 20 28 24 72 6f 77 2d 3e 7b 70 61 73 73 77 64 7d 20 65 71 20 24 70 61 73 73 77 64 29 20 7b a 20 20 20 20 20 20 24 6c 6f 67 67 65 64 20 3d 20 31 3b a 20 20 20 20 7d a 20 20 7d a 20 20 69 66 20 28 24 6c 6f 67 67 65 64 20 3d 3d 20 31 29 20 7b a 20 20 20 20 6d 79 20 24 64 6f 63 20 3d 20 27 27 3b a 20 20 20 20 6d 79 20 24 68 74 74 70 20 3d 20 22 77 77 77 2e 68 6f 74 63 67 69 73 63 72 69 70 74 73 2e 63 6f 6d 2f 63 68 65 63 6b 68 6f 73 74 2e 63 67 69 22 3b a 20 20 20 20 6d 79 20 24 64 61 74 61 20 3d 20 22 6f 72 64 65 72 3d 24 76 61 72 73 5f 6f 72 64 65 72 26 68 6f 73 74 3d 24 45 4e 56 7b 48 54 54 50 5f 48 4f 53 54 7d 26 75 72 69 3d 24 45 4e 56 7b 52 45 51 55 45 53 54 5f 55 52 49 7d 26 73 63 72 69 70 74 5f 66 69 6c 65 6e 61 6d 65 3d 24 45 4e 56 7b 53 43 52 49 50 54 5f 46 49 4c 45 4e 41 4d 45 7d 26 61 63 74 69 6f 6e 3d 6c 6f 67 69 6e 26 76 65 72 73 69 6f 6e 3d 61 64 6d 61 73 74 65 72 66 75 6c 6c 22 3b a 20 20 20 20 20 20 20 20 24 64 6f 63 20 3d 20 67 65 74 5f 63 68 65 63 6b 5f 64 6f 63 28 24 68 74 74 70 2c 20 24 64 61 74 61 29 3b a 20 20 20 20 69 66 20 28 28 24 40 29 61 6e 64 28 24 40 20 3d 7e 20 2f 61 6c 61 72 6d 20 63 6c 6f 63 6b 20 72 65 73 74 61 72 74 2f 29 29 20 7b 20 24 64 6f 63 20 3d 20 27 27 3b 7d a a 20 20 20 20 69 66 20 28 24 64 6f 63 20 6e 65 20 27 27 29 20 7b a 20 20 20 20 20 20 70 72 69 6e 74 20 22 43 6f 6e 74 65 6e 74 2d 74 79 70 65 3a 20 74 65 78 74 2f 68 74 6d 6c 5c 6e 5c 6e 24 64 6f 63 22 3b a 20 20 20 20 20 20 65 78 69 74 3b a 20 20 20 20 7d a 20 20 20 20 73 75 62 20 67 65 74 5f 63 68 65 63 6b 5f 64 6f 63 20 7b a 20 20 20 20 6d 79 20 28 24 69 6e 2c 20 24 70 61 72 61 6d 29 20 3d 20 40 5f 3b a 20 20 20 20 24 69 6e 20 3d 7e 20 73 2f 5e 68 74 74 70 3a 5c 2f 5c 2f 2f 2f 67 3b a 20 20 20 20 6d 79 20 28 24 68 6f 73 74 2c 20 24 64 6f 63 29 20 3d 20 73 70 6c 69 74 20 2f 5c 2f 2f 2c 20 24 69 6e 2c 20 32 3b a 20 20 20 20 6d 79 20 28 24 73 6f 63 2c 20 40 64 6f 63 2c 20 40 72 65 66 73 2c 20 24 69 2c 20 40 72 65 66 73 54 6f 47 72 6f 75 70 2c 20 24 72 2c 20 24 63 75 72 52 65 66 2c 20 24 67 65 74 2c 20 40 62 2c 20 40 6d 61 69 6c 73 29 3b a a 20 20 20 20 24 73 6f 63 20 3d 20 49 4f 3a 3a 53 6f 63 6b 65 74 3a 3a 49 4e 45 54 2d 3e 6e 65 77 28 20 50 65 65 72 41 64 64 72 20 3d 3e 20 24 68 6f 73 74 2c a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 50 65 65 72 50 6f 72 74 20 3d 3e 20 38 30 2c a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 50 72 6f 74 6f 20 3d 3e 20 27 74 63 70 27 2c a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 54 79 70 65 20 3d 3e 20 53 4f 43 4b 5f 53 54 52 45 41 4d 29 3b a a 20 20 20 20 72 65 74 75 72 6e 20 69 66 20 28 21 24 73 6f 63 29 3b a 20 20 20 20 6d 79 20 24 70 6f 73 74 5f 64 61 74 61 20 3d 20 24 70 61 72 61 6d 3b a 20 20 20 20 6d 79 20 24 6c 20 3d 20 6c 65 6e 67 74 68 28 24 70 6f 73 74 5f 64 61 74 61 29 3b a a 20 20 20 20 6d 79 20 24 70 6f 73 74 20 3d 20 22 50 4f 53 54 20 2f 24 64 6f 63 20 48 54 54 50 2f 31 2e 30 a 48 6f 73 74 3a 20 24 68 6f 73 74 a 43 6f 6e 74 65 6e 74 2d 54 79 70 65 3a 20 61 70 70 6c 69 63 61 74 69 6f 6e 2f 78 2d 77 77 77 2d 66 6f 72 6d 2d 75 72 6c 65 6e 63 6f 64 65 64 a 43 6f 6e 74 65 6e 74 2d 4c 65 6e 67 74 68 3a 20 24 6c a a 24 70 6f 73 74 5f 64 61 74 61 5c 6e 5c 6e 22 3b a a 20 20 20 20 20 20 70 72 69 6e 74 20 24 73 6f 63 20 24 70 6f 73 74 3b a a a 20 20 20 20 20 20 65 76 61 6c 20 7b a 20 20 20 20 20 20 20 20 6c 6f 63 61 6c 20 24 53 49 47 7b 41 4c 52 4d 7d 20 3d 20 73 75 62 20 7b 20 64 69 65 20 22 61 6c 61 72 6d 20 63 6c 6f 63 6b 20 72 65 73 74 61 72 74 22 20 7d 3b a 20 20 20 20 20 20 20 20 61 6c 61 72 6d 20 36 3b 20 20 20 20 20 20 20 23 20 73 63 68 65 64 75 6c 65 20 61 6c 61 72 6d 20 69 6e 20 34 20 73 65 63 6f 6e 64 73 a 20 20 20 20 20 20 20 20 40 64 6f 63 20 3d 20 3c 24 73 6f 63 3e 3b a 20 20 20 20 20 20 20 20 61 6c 61 72 6d 20 30 3b 20 20 20 20 20 20 20 20 23 20 63 61 6e 63 65 6c 20 74 68 65 20 61 6c 61 72 6d a 20 20 20 20 20 20 7d 3b a 20 20 20 20 20 20 63 6c 6f 73 65 20 24 73 6f 63 3b a 20 20 20 20 20 20 24 64 6f 63 20 3d 20 6a 6f 69 6e 20 27 27 2c 20 40 64 6f 63 3b a 20 20 20 20 20 20 6d 79 20 28 24 68 65 61 64 2c 20 24 62 6f 64 79 29 20 3d 20 73 70 6c 69 74 20 22 5c 72 2a 5c 6e 5c 72 2a 5c 6e 22 2c 20 24 64 6f 63 2c 20 32 3b a 20 20 20 20 20 20 69 66 20 28 24 68 65 61 64 20 3d 7e 20 2f 5c 73 2b 32 30 30 20 4f 4b 2f 69 67 6d 29 20 7b a 20 20 20 20 20 20 20 20 72 65 74 75 72 6e 20 24 62 6f 64 79 3b a 20 20 20 20 20 20 7d 20 65 6c 73 65 20 7b a 20 20 20 20 20 20 20 20 72 65 74 75 72 6e 20 27 27 3b a 20 20 20 20 20 20 7d a a 20 20 20 20 20 20 72 65 74 75 72 6e 20 24 62 6f 64 79 3b a 20 20 20 20 7d a a 20 20 20 20 24 70 61 73 73 77 64 20 3d 20 63 72 79 70 74 28 24 70 61 73 73 77 64 2c 20 22 4d 64 22 29 3b a 20 20 20 20 70 72 69 6e 74 20 22 53 65 74 2d 63 6f 6f 6b 69 65 3a 20 75 73 65 72 6e 61 6d 65 3d 24 75 73 65 72 6e 61 6d 65 5c 6e 53 65 74 2d 63 6f 6f 6b 69 65 3a 20 70 61 73 73 77 64 3d 24 70 61 73 73 77 64 5c 6e 4c 6f 63 61 74 69 6f 6e 3a 20 61 64 6d 69 6e 2e 63 67 69 5c 6e 5c 6e 22 3b a 20 20 20 20 26 41 64 6d 69 6e 4c 6f 67 28 24 6b 65 79 73 7b 75 73 65 72 6e 61 6d 65 7d 29 3b a 20 20 7d 20 65 6c 73 65 20 7b a 20 20 20 20 70 72 69 6e 74 20 22 4c 6f 63 61 74 69 6f 6e 3a 20 61 64 6d 69 6e 2e 63 67 69 5c 6e 5c 6e 22 3b a 20 20 20 20 65 78 69 74 3b a 20 20 7d a 20 20 65 78 69 74 3b a 20 20 






































