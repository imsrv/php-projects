#!/usr/bin/perl

#########################################################################
###    Supplied by Shadoff [GTT]    Nullified by Vorga1664 [GTT]      ###
###              Grinderz Translation Team '2004                      ###
#########################################################################

#print "Content-type: text/html\n\n";

use lib './lib';
use CGI::Carp qw(fatalsToBrowser);

use strict;
use CSV;

use Template;
use svars;
use iplib;
use IO::Socket;

use vars qw($user_type $q_CGI);

require 'site.pl';
require 'logon.pl';

my %keys = parse_form();
my %cookie = parse_cookie();
my $ver = 'acc14';

open FILE, "$0";
my $pathtoperl = <FILE>;
chomp $pathtoperl;
close FILE;
$pathtoperl =~ s/\#\!//;

my @fimg = qw(cr cu cv cy cz de dk dz ec ee eg er es et eu fi fj fo fr ga gb ge gi gl gp gr gs gt gu gy hk hr ht hu id ie il in iq ir is it jm jo jp ke kg kh ki kp kr ky kz lb lc lk lt lu lv ly ma mc md mg mn mo mp ms mt mx my mz na nc nf nl no np nr nz om pa pe pf ph pk pl pm pr pt py qa ro ru sa sb sd se sg si sk sl so sr sy tc tg th tn to tp tr tt tv tw tz ua ug us uy va ve vg vn wf ws ye yu za zw vi af al am an ao ar at au aw az ba bb bd be bf bg bh bi bj bm bn bo br bs bt bw by bz ca cf cg ch ci ck cl cm cn co);
my %fimg;
for my $i (@fimg) {
  $fimg{$i} = $i;
}




my $dbh = login();
my ($sth, $row, $template, $q);

if ($keys{page} eq 'login') {
  &UserLogin();
}


my $USERID = &CheckLogin();


my %userinfo = get_record($dbh, "select * from $ver\_users where id=$USERID");


my ($day, $mon, $year) = (localtime(time()))[3,4,5];
my $DATE_NOW = sprintf("%04d-%02d-%02d", $year+1900, $mon+1, $day);

#&CheckLogin();

my $initialuserid = 0;

$user_type = 'superuser';




if ($user_type eq 'superuser') {
  if ($keys{page} eq 'undelivered') {
    &GetUndelivered();
  }
  if ($keys{page} eq 'deleteadmin') {
    &DeleteAdmin();
  }
  if ($keys{page} eq 'deletebulk') {
    &DeleteBulkInfo();
  }
  if ($keys{page} =~ /help\d+/) {
    &Help();
  }
  if ($keys{page} eq 'copyprocess') {
    &CopyProcess();
  }
  if ($keys{page} eq 'deldupes') {
    &DeleteDupes();
  }
  if ($keys{page} eq 'log') {
    &Log();
  }
  if ($keys{page} eq 'opencampedit') {
    &OpenPopupUserEditCamp();
  }
  if ($keys{page} eq 'addadmin') {
    &AddAdmin();
  }
  if ($keys{page} eq 'editadmin') {
    &EditAdmin();
  }
  if ($keys{page} eq 'users') {
    &UsersArea();
  }
  if ($keys{page} eq 'bulk') {
    &BulkIndex();
  }
  if ($keys{page} eq 'downloadattache') {
    &DownloadAttache();
  }
  if ($keys{page} eq 'attaches') {
    &Attaches();
  }
  if ($keys{page} eq 'subscraction') {
    &SubscribtionAction();
  }
  if ($keys{page} eq 'addgroup') {
    &AddGroup();
  }
  if ($keys{page} eq 'forms') {
    &Forms();
  }
  if ($keys{page} eq 'importpage') {
    &ImportPage();
  }
  if ($keys{page} eq 'exportpage') {
    &ExportPage();
  }
  if ($keys{page} eq 'import') {
    &Import();
  }
  if ($keys{page} eq 'adduser') {
    &AddUser();
  }
  if ($keys{page} eq 'edituser') {
    &EditUser();
  }
  if ($keys{page} eq 'export') {
    &Export();
  }
  if ($keys{page} eq 'deleterecentemail') {
    &DeleteRecentEmail();
  }
  if ($keys{page} eq 'deleterecentfilter') {
    &DeleteRecentFilter();
  }
  if ($keys{page} eq 'formfields') {
    &ViewFields();
  }
  if ($keys{page} eq 'deleteemail') {
    &DeleteEmail();
  }
  if ($keys{page} eq 'dupes') {
    &SetDupes();
  }
  if ($keys{page} eq 'deleteletter') {
    &DeleteLetter();
  }
  if ($keys{page} eq 'statcampaignyear') {
    &StatCampaignYear();
  }
  if ($keys{page} eq 'addnewtype') {
    &AddNewType();
  }
  if ($keys{page} eq 'edittype') {
    &EditType();
  }
  if ($keys{page} eq 'subscr') {
    &ShowSubscribtionArea();
  }
  if ($keys{page} eq 'deletetype') {
    &DeleteType();
  }
  if ($keys{page} eq 'logout') {
    &Logout();
  }
  if ($keys{page} eq 'newletter') {
    &NewLetter();
  }
  if ($keys{page} eq 'settings') {
    &Settings();
  }
  if ($keys{page} eq 'editletter') {
    &EditLetter();
  }
  if ($keys{page} eq 'sendimmediatly') {
    &SendImmediatly();
  }
  if ($keys{page} eq 'deletetemplate') {
    &DeleteTemplate();
  }
  if ($keys{page} eq 'support') {
    &Support();
  }
  &main();
}





sub main {

  my $cookie = '';
  $cookie = "\nSet-cookie: order_camp=$keys{order}" if ($keys{order});
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache$cookie\n\n";
  $keys{order} = $cookie{order_camp} if ($keys{order} eq '');


  $template = new Template('tmpl/index.html');

  $q = "select * from $ver\_types as types where id!=1 and parent = 0";

  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  my %list_id;
  my $total_active = 0;
  my $total_expired = 0;
  my @campaigns = split /\-/, $userinfo{other_camp_edit};
  while ($row = $sth->fetchrow_hashref) {
    unless ($userinfo{id} eq '1') {
      if ($row->{user_id} ne $userinfo{id}) {
        my $flag = 0;
        for my $i (@campaigns) {

          if ($row->{id} == $i) {
            $flag = 1;
            last;
          }
        }
        next if ($flag == 0);
      }
    }
    my %in = (
	'id' => $row->{id},
	'name' => $row->{name},
	'col' => $row->{col},
	'dup' => $row->{dupes},
	'checked' => $row->{checked},
	'bad' => $row->{bad},
	'unsub' => $row->{unsub},
	'createdate' => $row->{create_date},
	'changedate' => $row->{change_date}
    );
    my %info = get_record($dbh, "select count(id) as count from $ver\_types where parent = $row->{id}");
    $in{qgroups} = $info{count}+1;
    %info = get_record($dbh, "select count(id) as count from $ver\_sub_$row->{id} where approved=1 and expired=0 and confirm = 1 and unsub = 0");
    $in{qactive} = $info{count};
    %info = get_record($dbh, "select count(id) as count from $ver\_sub_$row->{id} where expired = 1");
    $in{qexpired} = $info{count};
    %info = get_record($dbh, "select count(id) as count from $ver\_sub_$row->{id} where unsub = 1");
    $in{qunsub} = $info{count};
    @list = (@list, \%in);
    $list_id{$row->{id}} = $#list;

    $total_active += $in{qactive};
    $total_expired += $in{qexpired};

  }
  $sth->finish();
  $template->make_for_array('types-lines', $template->get_area('types-lines'), @list);
  $template->make_for_array('sub-list', $template->get_area('sub-list'), @list);


  my $down_arrow = $template->get_area('down_arrow');
  my $top_arrow = $template->get_area('top_arrow');
#  $template->clear_areas('down_arrow', 'top_arrow');

#  ($template, @list) = sort_main_page($template, $down_arrow, $top_arrow, @list);

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


#  $template->clear_area('types-lines');


  #stat-week#

  my $statline = $template->get_area('stat-week');
#  $template->clear_area('stat-week');
  @list = ();
  my $i;
  for ($i = 0; $i<7; $i++) {
    my %in = (
	'day' => $i,
	'col' => 0,
	'unsub' => 0,
	'col_height' => 0,
	'unsub_height' => 0
    );
    @list = (@list, \%in);
  }
  $q = "select sum(stat.unsub) as unsub, sum(stat.col) as col, stat.d as d, to_days(now()) - to_days(d) as dif from $ver\_stat as stat where stat.sid=1 and to_days(now()) - to_days(d)<7 group by stat.d";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    next if ($row->{dif} < 0);
    $list[$row->{dif}]->{unsub} = $row->{unsub};
    $list[$row->{dif}]->{col} = $row->{col};
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
    $max_clicks = $list[$i]->{unsub} if ($list[$i]->{unsub} > $max_clicks);
    $max_shows = $list[$i]->{col} if ($list[$i]->{col} > $max_shows);
    $min_clicks = $list[$i]->{unsub} if ($list[$i]->{unsub} < $min_clicks);
    $min_shows = $list[$i]->{col} if ($list[$i]->{col} < $min_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{unsub_height} = sprintf("%d", 200*($list[$i]->{unsub}-($min_clicks*6)/7)/($max_clicks-$min_clicks*6/7));
    $list[$i]->{col_height} = sprintf("%d", 200*($list[$i]->{col}-$min_shows*6/7)/($max_shows-$min_shows*6/7));
  }
  $template->make_for_array('stat-week', $statline, reverse @list);

  #stat emails#

  $q = "select col, dupes, checked, bad, unsub from $ver\_types where id=1";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'stat-total-emails' => $row->{col},
    	'stat-dup-emails' => $row->{dupes},
    	'stat-checked-emails' => $row->{checked},
    	'stat-bad-emails' => $row->{bad},
    	'stat-unsub-emails' => $row->{unsub},
    	'stat-active-emails' => $total_active,
    	'stat-expired-emails' => $total_expired,
    );
    $template->replace_hash(%in);
  }

  $template->clear_area('clear');
  $template->print(%keys);
}

sub DeleteTemplate {
  my $id = sprintf("%d", $keys{id});
  $q = "delete from $ver\_attache where id=$id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  print "Location: admin.cgi?page=attaches\n\n";
  exit;
}

sub DeleteLetter {
  my $id = sprintf("%d", $keys{lid});
  $q = "delete from $ver\_letters where id=$id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  print "Location: admin.cgi?page=subscr&tid=$keys{tid}\n\n";
  exit;
}

sub EditUser {
  print "Content-type: text/html\n\n";
  if ($userinfo{id} ne '1') {
    $template = new Template('tmpl/user.error.action.html');
    $template->print(%keys);
    exit;
  }
  my $sub = sprintf("%d", $keys{tid});
  $keys{id} = sprintf("%d", $keys{id});

  $q = "select * from $ver\_sub_$sub where id=$keys{id}";

  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  $row = $sth->fetchrow_hashref;
  $template = new Template('tmpl/edit.user.html');
  $template->replace_hash(%$row);
  $template->print(%keys);
  exit;
}

sub Forms {
  if ($keys{action} eq 'generate3') {
    my $form = $keys{'form_code'};
    $form =~ s/\&lt;/</igms;
    $form =~ s/\&gt;/>/igms;
    print "Content-type: text/html\n\n";
    print $form;
    exit;
  }
  if ($keys{action} eq 'generate2') {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/forms3.html');
    my $form = "<form action='$vars_server_url/subscribe.cgi' method=get><input type=hidden name=mm_id value=sub>\n";
    my @subs = CGI::param("subs");
    if ($keys{allow_select_subs} eq '') {
      for (@subs) {
    	$form .= "<input type=hidden name=sub value='$_'>\n";
      }
    }
    my @fields = ('email', 'first_name', 'last_name', 'full_name', 'company', 'language', 'phone', 'icq',
    	'address', 'address2', 'city', 'state', 'country', 'birthdate', 'age', 'sex', 'website', 'heard', 'business',
    	'additional1', 'additional2', 'additional3', 'additional4', 'additional5', 'additional6',
    	'additional7', 'additional8', 'additional9', 'additional10', 'additional11', 'additional12');
    for my $i (@fields) {
      if ($keys{"$i\_html_name"} ne '') {
        if (($keys{"$i\_type"} eq '')or($keys{"$i\_type"} eq 'text')) {
          $form .= $keys{"$i\_title"}." <input type=text name='".$keys{"$i\_html_name"}."'><input type=hidden name=mm_$i value='".$keys{"$i\_html_name"}."'><br>\n";
        } elsif ($keys{"$i\_type"} eq 'radio') {
          $keys{"$i\_options"} =~ /\r/igs;
          my @opt = split /\n/, $keys{"$i\_options"};
          $form .= qq~$keys{"$i\_title"} ~;
          for (@opt) {
            my $r = $_;
            $r =~ s/[\n|\r]//igm;
            next if $r eq '';
            $form .= qq~<input type=radio name="$keys{"$i\_html_name"}" value="$r"> $r &nbsp; ~;
          }
          $form .= "<br>\n";
        } elsif ($keys{"$i\_type"} eq 'select') {
          $keys{"$i\_options"} =~ /\r/igs;
          my @opt = split /\n/, $keys{"$i\_options"};
          $form .= qq~$keys{"$i\_title"} <select name="$keys{"$i\_html_name"}">~;
          for (@opt) {
            my $r = $_;
            $r =~ s/[\n|\r]//igm;
            next if $r eq '';
            $form .= qq~<option value="$r"> $r~;
          }
          $form .= "</select><br>\n";
        } elsif ($keys{"$i\_type"} eq 'checkbox') {
          $keys{"$i\_options"} =~ /\r/igs;
          my @opt = split /\n/, $keys{"$i\_options"};
          $form .= qq~$keys{"$i\_title"} ~;
          for (@opt) {
            my $r = $_;
            $r =~ s/[\n|\r]//igm;
            next if $r eq '';
            $form .= qq~<input type=checkbox name="$keys{"$i\_html_name"}" value="$r"> $r &nbsp; ~;
          }
          $form .= "<br>\n";
        } elsif ($keys{"$i\_type"} eq 'textarea') {
          $form .= qq~$keys{"$i\_title"} <textarea name="$keys{"$i\_html_name"}"></textarea><br>\n~;
        }
      }
    }
    if ($keys{thanks_url} ne '') {
      $form .= qq~<input type=hidden name=mm_action value="$keys{thanks_url}">\n~;
      $form .= qq~<input type=hidden name=mm_method value=url>\n~;
    }
    if ($keys{thanks_get} ne '') {
      $form .= qq~<input type=hidden name=mm_action value="$keys{thanks_get}">\n~;
      $form .= qq~<input type=hidden name=mm_method value=get>\n~;
    }
    if ($keys{thanks_post} ne '') {
      $form .= qq~<input type=hidden name=mm_action value="$keys{thanks_post}">\n~;
      $form .= qq~<input type=hidden name=mm_method value=post>\n~;
    }
    if ($keys{allow_select_subs} ne '') {
      if ($keys{select_type} eq 'select') {
        $form .= "<select name=sub>";
        for my $j (@subs) {
          my %q = get_record($dbh, "select name from $ver\_types where id=$j");
    	  $form .= "<option value='$j'> ".$q{name}."\n";
    	}
      }
      if ($keys{select_type} eq 'radio') {
        for my $j (@subs) {
          my %q = get_record($dbh, "select name from $ver\_types where id=$j");
    	  $form .= "<input type=radio name=sub value='$j'> $q{name} &nbsp; ";
    	}
      }
      if ($keys{select_type} eq 'checkboxes') {
        for my $j (@subs) {
          my %q = get_record($dbh, "select name from $ver\_types where id=$j");
    	  $form .= "<input type=checkbox name=sub value='$j'> $q{name} &nbsp; ";
    	}
      }
      $form .= "<br>\n";
    }
    my $hidden_lettersformat = qq~<input type=hidden name=mm_lettersformat value="$keys{lettersformat_html_name}">~;
    if ($keys{lettersformat_type} eq 'select') {
      $form .= qq~$keys{lettersformat_title} <select name="$keys{lettersformat_html_name}"><option value=html>HTML<option value=text>TEXT</select>$hidden_lettersformat<br>\n~;
    }
    if ($keys{lettersformat_type} eq 'radio') {
      $form .= qq~$keys{lettersformat_title} <input type=radio name="$keys{lettersformat_html_name}" value=html>HTML &nbsp; <input type=radio name="$keys{lettersformat_html_name}" value=text> TEXT$hidden_lettersformat<br>\n~;
    }
    if ($keys{lettersformat_type} eq 'checkbox') {
      $form .= qq~$keys{lettersformat_title} <input type=checkbox name="$keys{lettersformat_html_name}" value=html>HTML$hidden_lettersformat<br>\n~;
    }
    $form .= qq~<input type=submit value="subscribe">\n~;
    $form .= qq~</form>~;

    $form =~ s/\&/&amp;/igms;
    $form =~ s/</&lt;/igms;
    $form =~ s/>/&gt;/igms;

    $template->replace('form-code', $form);
    $template->print(%keys);
    exit;
  }
  if ($keys{action} eq 'generate1') {
    print "Content-type: text/html\n\n";
#    print map {"$_ = $keys{$_}<br>"} sort keys %keys;
#    print "<hr>";

    $template = new Template('tmpl/forms2.html');

    my @ids = grep {/.*?_html_name/} keys %keys;
    my @list = ();
    my @hidden = ();
    my @subs = CGI::param("subs");
    for (@subs) {
      my %in1 = ('hidden-name' => 'subs', 'hidden-value' => $_);
      @hidden = (@hidden, \%in1);
    }
    for ('allow_select_subs', 'select_type', 'thanks_html', 'thanks_url', 'thanks_get', 'thanks_post') {
      my %in1 = ('hidden-name' => $_, 'hidden-value' => $keys{$_});
      @hidden = (@hidden, \%in1);
    }
    for my $i (@ids) {
      my $k = '';
      if ($i =~ /(.*?)_html_name/) {
        $k = $1;
#        next if ($k eq 'lettersformat');
      }
      my %in1 = (
      	'hidden-name' => "$k\_html_name",
      	'hidden-value' => $keys{"$k\_html_name"}
      );
      @hidden = (@hidden, \%in1);
      my %in1 = (
      	'hidden-name' => "$k\_title",
      	'hidden-value' => $keys{"$k\_title"}
      );
      @hidden = (@hidden, \%in1);
      my %in1 = (
      	'hidden-name' => "$k\_type",
      	'hidden-value' => $keys{"$k\_type"}
      );
      @hidden = (@hidden, \%in1);

#      print "$i == $keys{$i} == $k<br>";
      if (($keys{"$k\_type"} eq 'radio') or ($keys{"$k\_type"} eq 'checkbox') or ($keys{"$k\_type"} eq 'select')) {
        if ($k ne 'lettersformat') {
          my %in = (
            'key' => $k
          );
          @list = (@list, \%in);
        }
        my %in1 = (
        	'hidden-name' => $i,
        	'hidden-value' => $keys{$i}
        );
      }

    }
    $template->make_for_array('subs-options', $template->get_area('subs-options'), @list);
    $template->make_for_array('hidden', $template->get_area('hidden'), @hidden);
    $template->make_for_array('get-options', $template->get_area('get-options'), @list);
    if ($#list > -1) {
      $template->clear_area('redirect');
    }

    $template->replace('server-url', $vars_server_url);
    $template->clear_area('clear');
    $template->print(%keys);
    exit;
  }
  print "Content-type: text/html\n\n";

#  $q = "select * from $ver\_sub_$sub where id=$keys{id}";

#  $sth = $dbh->prepare($q);
#  $sth->execute() or print $sth->errstr;
#  $row = $sth->fetchrow_hashref;
  $template = new Template('tmpl/forms.html');
  $q = "select * from $ver\_types where parent = 0 and id > 1 order by id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'id' => $row->{id},
    	'name' => $row->{name},
    	'parent' => '',
    );
    @list = (@list, \%in);
    $q = "select * from $ver\_types where parent = $row->{id} order by id";
    my $sth1 = $dbh->prepare($q);
    $sth1->execute() or print $sth1->errstr;
    my $row1;
    while ($row1 = $sth1->fetchrow_hashref) {
      my %in = (
    	'id' => $row1->{id},
    	'name' => $row1->{name},
    	'parent' => ' ---- ',
      );
      @list = (@list, \%in);
    }

  }
  $template->make_for_array('subs-options', $template->get_area('subs-options'), @list);
  $template->replace('server-url', $vars_server_url);
  $template->clear_area('clear');
  $template->print(%keys);
  exit;
}

sub GetUndelivered {
  print "Content-type: text/plain\n\n";
  my $id = sprintf("%d", $keys{id});
  $q = "select * from $ver\_undeliver where bid=$id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    print "$row->{email}\n";
  }
  print "=============================\nTotal: ".$sth->rows;
  exit;

}

sub ExportPage {
  print "Content-type: text/html\n\n";

  $template = new Template('tmpl/export.html');
  if ($userinfo{id} eq '1') {
    $q = "select * from $ver\_types as types where id!=1 and parent = 0";
  } else {
    my @campaigns = grep {/\d+/} split /-/, $userinfo{other_camp_edit};
    my $camps = join ', ', @campaigns;
    $camps = 0 if ($camps eq '');
    $q = "select * from $ver\_types as types where id!=1 and parent = 0 and (user_id=$userinfo{id} or id in ($camps))";
  }
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  my %list_id;
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'id' => $row->{id},
	'name' => $row->{name},
	'col' => $row->{col},
	'dup' => $row->{dupes},
	'checked' => $row->{checked},
	'bad' => $row->{bad},
	'unsub' => $row->{unsub}
    );
    @list = (@list, \%in);
    $list_id{$row->{id}} = $#list;
  }
  $sth->finish();
  $template->make_for_array('sub-list', $template->get_area('sub-list'), @list);

  $template->clear_area('clear');
  $template->print(%keys);
  exit;
}

sub AddUser {
  if ($userinfo{id} ne '1') {
    my $tid = sprintf("%d", $keys{tid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }
  if ($keys{action} eq 'adduser') {
    my $sub = sprintf("%d", $keys{tid});
    my $email = $dbh->quote($keys{email});
    my %count = get_record($dbh, "select count(id) as count from $ver\_sub_$sub");
    my $first_name = $dbh->quote($keys{first_name});
    my $last_name = $dbh->quote($keys{last_name});
    my $full_name = $dbh->quote($keys{full_name});
    my $company = $dbh->quote($keys{company});
    my $language = $dbh->quote($keys{language});
    my $phone = $dbh->quote($keys{phone});
    my $icq = $dbh->quote($keys{icq});
    my $address = $dbh->quote($keys{address});
    my $address2 = $dbh->quote($keys{address2});
    my $city = $dbh->quote($keys{city});
    my $state = $dbh->quote($keys{state});
    my $country = $dbh->quote($keys{country});
    my $birthdate = $dbh->quote($keys{birthdate});
    my $age = $dbh->quote($keys{age});
    my $sex = $dbh->quote($keys{sex});
    my $website = $dbh->quote($keys{website});
    my $heard = $dbh->quote($keys{heard});
    my $business = $dbh->quote($keys{business});
    my $date_sub = $dbh->quote($keys{date_sub});
    my $date_unsub = $dbh->quote($keys{date_unsub});
    my $ip = $dbh->quote($keys{ip});
    my $lettersformat = $dbh->quote($keys{lettersformat});
    my $additional1 = $dbh->quote($keys{additional1});
    my $additional2 = $dbh->quote($keys{additional2});
    my $additional3 = $dbh->quote($keys{additional3});
    my $additional4 = $dbh->quote($keys{additional4});
    my $additional5 = $dbh->quote($keys{additional5});
    my $additional6 = $dbh->quote($keys{additional6});
    my $additional7 = $dbh->quote($keys{additional7});
    my $additional8 = $dbh->quote($keys{additional8});
    my $additional9 = $dbh->quote($keys{additional9});
    my $additional10 = $dbh->quote($keys{additional10});
    my $additional11 = $dbh->quote($keys{additional11});
    my $additional12 = $dbh->quote($keys{additional12});
    my $group = sprintf("%d", $keys{group});
    $keys{id} = sprintf("%d", $keys{id});
    if ($keys{id} == 0) {
      $q = "insert into $ver\_sub_$sub set
        confirm=1,
        approved=1,
        active=0,
        grp=$group,
    	email = $email,
    	first_name = $first_name,
    	last_name = $last_name,
    	full_name = $full_name,
    	company = $company,
    	language = $language,
    	phone = $phone,
    	icq = $icq,
    	address = $address,
    	address2 = $address2,
    	city = $city,
    	state = $state,
    	country = $country,
    	birthdate = $birthdate,
    	age = $age,
    	sex = $sex,
    	website = $website,
    	heard = $heard,
    	business = $business,
    	date_sub = now(),
    	ip = $ip,
    	lettersformat = $lettersformat,
    	additional1 = $additional1,
    	additional2 = $additional2,
    	additional3 = $additional3,
    	additional4 = $additional4,
    	additional5 = $additional5,
    	additional6 = $additional6,
    	additional7 = $additional7,
    	additional8 = $additional8,
    	additional9 = $additional9,
    	additional10 = $additional10,
    	additional11 = $additional11,
    	additional12 = $additional12
    	";
    } else {
      $q = "update $ver\_sub_$sub set
        confirm=1,
        approved=1,
        active=0,
        grp=$group,
    	email = $email,
    	first_name = $first_name,
    	last_name = $last_name,
    	full_name = $full_name,
    	company = $company,
    	language = $language,
    	phone = $phone,
    	icq = $icq,
    	address = $address,
    	address2 = $address2,
    	city = $city,
    	state = $state,
    	country = $country,
    	birthdate = $birthdate,
    	age = $age,
    	sex = $sex,
    	website = $website,
    	heard = $heard,
    	business = $business,
    	date_sub = $date_sub,
    	date_unsub = $date_unsub,
    	ip = $ip,
    	lettersformat = $lettersformat,
    	additional1 = $additional1,
    	additional2 = $additional2,
    	additional3 = $additional3,
    	additional4 = $additional4,
    	additional5 = $additional5,
    	additional6 = $additional6,
    	additional7 = $additional7,
    	additional8 = $additional8,
    	additional9 = $additional9,
    	additional10 = $additional10,
    	additional11 = $additional11,
    	additional12 = $additional12
    	 where id=$keys{id}";
    }
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my ($id, $userid);
    $userid = $id = $sth->{insertid} || $sth->{mysql_insertid};
#    `$pathtoperl checkemail.pl $email $sub $id 2>&1`;
    $q = "update $ver\_types set col=col+1 where id=$sub or id=1";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    print "Location: admin.cgi?page=subscr&tid=$sub&group=$keys{group}&area=$keys{area}&p=$keys{p}&search=$keys{search}&where=$keys{where}\n\n";
    exit;
  }
  print "Content-type: text/html\n\n";
  $template = new Template('tmpl/add.user.html');
  $template->print(%keys);
  exit;
}

sub OpenPopupUserEditCamp {
  if ($userinfo{id} ne '1') {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/main.html', 'content', 'tmpl/user.error.action.html');
    $template->print(%keys);
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/user.camptoedit.html');
  my $uid = sprintf("%d", $keys{uid});
  $q = "select * from $ver\_types where parent = 0 and id <> 1";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  my (@id, %id);
  @id = split /\-/, $keys{id};
  my $id;
  for $id (@id) {
    $id{$id} = $id;
  }
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'id' => $row->{id},
    	'name' => $row->{name},
    	'status' => ($id{$row->{id}} eq $row->{id}? 'checked' : '')
    );
    @list = (@list, \%in);
  }
  $template->make_for_array('campaigns', $template->get_area('campaigns'), @list);

  $template->clear_area('clear');
  $template->print_self(%keys);
  exit;
}


sub Import {
  if ($keys{action} eq 'step4') {
    print "Content-type: text/html\n\n";

    my $iid = sprintf("%d", $keys{iid});
    $q = "select * from $ver\_import where id=$iid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($row = $sth->fetchrow_hashref) {
      if ($row->{done} ne '1') {
        $template = new Template ("tmpl/import.process.html");
#        $a = `ps -aux | grep $row->{pid}`;
#        print $a;
#        if ($a =~ /export.pl/gm) {
          $template->replace('processing', $template->get_area('till-processing'));
#        } else {
#          $template->replace('processing', $template->get_area('processing-failture'));
#        }
      } else {
        $template = new Template("tmpl/import.success.html");
      }
      $template->replace('records', $row->{processed});
    }
    $template->clear_area('clear');
    $template->print_self(%keys);
    exit;
  }
  if ($keys{action} eq 'step3') {
    my $iid = sprintf("%d", $keys{iid});
    my @from = grep {$_ =~ /f\d+/} keys %keys;
    my $imp_field = '';
    my $to_field = '';
    my $i;
    for $i (@from) {
     next if ($keys{$i} eq '');
      if ($i =~ /f(\d+)/) {
        my $f = $1;
        $imp_field .= "," if ($imp_field ne '');
        $imp_field .= $f;
        $to_field .= "$keys{$i},";
      }
    }
    $imp_field = $dbh->quote($imp_field);
    $to_field = $dbh->quote($to_field);
    $q = "update $ver\_import set imp_fields = $imp_field, to_fields = $to_field where id=$iid";
    $dbh->do($q) or print $dbh->errstr;
#    print $q;
    my $a = `$pathtoperl export.pl -import $iid &`;
    print "Location: admin.cgi?page=import&action=step4&iid=$iid\n\n";
    exit;
  }
  if ($keys{action} eq 'step2') {
    print "Content-type: text/html\n\n";
    my $iid = sprintf("%d", $keys{iid});
    my %imp = get_record($dbh, "select * from $ver\_import where id=$iid");
    my @fields = ();
    if ($imp{source} eq 'file') {
      open FILE, "<export/imp$iid";
      my $a = <FILE>;
      close FILE;
      my $csv = CSV->new();
      $csv->parse($a);
      @fields = $csv->fields();
    } else {
      my $dbh2 = DBI->connect("DBI:mysql:$imp{mysqldatabase}:$imp{mysqlhost}", $imp{mysqllogin}, $imp{mysqlpassword}) || print "Can't connect: $DBI::errstr\n";
      $q = "show columns from $imp{mysqltable}";
      $sth = $dbh2->prepare($q);
      $sth->execute() or print $sth->errstr;
      my @row;
      while (@row = $sth->fetchrow_array) {
        @fields = (@fields, $row[0]);
      }
    }

    $template = new Template('tmpl/import2.html');
    my ($i, $j);
    $j = 0;
    my @flds;
    for $i (@fields) {
      my %in = (
      	'field-id' => $j,
      	'field-name' => $i
      );
      @flds = (@flds, \%in);
      $j ++;
    }
    $template->make_for_array('import-fields', $template->get_area('fields-list'), @flds);

    $template->clear_area('clear');
    $template->print(%keys);
    exit;
  }
  my $sub = sprintf("%d", $keys{sub});
  my $sendconfirm = $keys{sendconfirm} eq '1' ? 1 : 0;
  my $sendadminconfirm = $keys{sendadminconfirm} eq '1' ? $dbh->quote($keys{admin_email}) : '""';
  my $setapproved = $keys{setapproved} eq '1' ? 1 : 0;
  my $setdisabled = $keys{setdisabled} eq '1' ? 1 : 0;
  if ($keys{importfrom} eq 'file') {
    $q = "insert into $ver\_import set done = 0, source = 'file', sendconfirm = $sendconfirm, sendadminconfirm = $sendadminconfirm,
    	setapproved = $setapproved, setdisabled = $setdisabled,
    	processed = 0, sid = $sub";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my $iid = $sth->{insertid} || $sth->{mysql_insertid};
    my $file = $keys{file};
    open FILE, ">export/imp$iid";
    while (<$file>) {
      print FILE;
    }
    close FILE;

    print "Location: admin.cgi?page=import&iid=$iid&action=step2\n\n";
#    `perl checkemail.pl --import $sub & >/dev/null 2>/dev/null`;
#    print "Location: admin.cgi?page=subscr&tid=$keys{tid}\n\n";
    exit;
  }
  if ($keys{importfrom} eq 'mysql') {
    my $mysqlhost = $dbh->quote($keys{mysqlhost});
    my $mysqldatabase = $dbh->quote($keys{mysqldatabase});
    my $mysqllogin = $dbh->quote($keys{mysqluser});
    my $mysqlpassword = $dbh->quote($keys{mysqlpassword});
    my $mysqltable = $dbh->quote($keys{mysqltable});
    $q = "insert into $ver\_import set done = 0, source = 'mysql', sendconfirm = $sendconfirm, sendadminconfirm = $sendadminconfirm,
    	setapproved = $setapproved, setdisabled = $setdisabled, processed = 0, sid = $sub, mysqlhost = $mysqlhost, mysqllogin=$mysqllogin, mysqlpassword = $mysqlpassword,
    	mysqldatabase = $mysqldatabase, mysqltable=$mysqltable";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my $iid = $sth->{insertid} || $sth->{mysql_insertid};

    print "Location: admin.cgi?page=import&iid=$iid&action=step2\n\n";
    exit;
  }
}

sub ViewFields {
  if ($userinfo{id} ne '1') {
    my $tid = sprintf("%d", $keys{tid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }
  print "Content-type: text/html\n\n";
  $template = new Template('tmpl/fields.html');
  my $id = sprintf("%d", $keys{lid});
  my $sub = sprintf("%d", $keys{tid});
  $q = "select * from $ver\_sub_$sub where id=$id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    my $f = $row->{form_fields};
    my $fields = new CGI("$f");
    my @param = $fields->param;
    my @list = ();
    my $i;
    for $i (sort @param) {
      my %in = (
      	'name' => $i,
      	'value' => $fields->param("$i")
      );
      @list = (@list, \%in);
    }
    $template->make_for_array('fields-list', $template->get_area('fields-list'), @list);
  }

  $template->clear_area('clear');
  $template->print(%keys);
  exit;

}


sub Export {
  if ($keys{export_id} eq '') {
    if ($keys{action} eq 'download') {
      my $id = sprintf("%d", $keys{id});
      $q = "select * from $ver\_export where id=$id";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      $row = $sth->fetchrow_hashref;
      if ($row->{report_type} eq 'html') {
        print "Content-type: text/html\n\n";
      } elsif ($row->{report_type} eq 'csv') {
        print "Content-type: application/vnd.ms-excel\n\n";
      } else {
        print "Content-type: text/plain\n\n";
      }
      open FILE, "export/$id";
      while (<FILE>) {
        print;
      }
      exit;
    }

    my $add = '';
#    print "Content-type: text/html\n\n";
    my $sub = sprintf("%d", $keys{sub});
    if ($keys{period} eq 'new') {
      $q = "select point_export from $ver\_types where id=$sub";
      my $sth2 = $dbh->prepare($q);
      $sth2->execute() or print $sth2->errstr;
      my $row2;
      if ($row2 = $sth2->fetchrow_hashref) {
        $add = "date_sub > '$row2->{point_export}' and " if ($row2->{point_export} ne '');
      }
    }
    if ($keys{period} eq 'period ') {
      if ($keys{p} eq 'today') {
        $add = "to_days(now()) = to_days(date_sub) and ";
      }
      if ($keys{p} eq 'yesterday') {
        $add = "to_days(now()) = to_days(date_sub)+1 and ";
      }
      if ($keys{p} eq 'week') {
        $add = "to_days(now()) <= to_days(date_sub)+7 and ";
      }
      if ($keys{p} eq 'month') {
        $add = "to_days(now()) <= to_days(date_add(date_sub, period 1 month)) and ";
      }
      if ($keys{p} eq 'quarter') {
        $add = "to_days(now()) <= to_days(date_add(date_sub, period 3 month)) and ";
      }
      if ($keys{p} eq 'year') {
        $add = "to_days(now()) <= to_days(date_add(date_sub, period 1 year)) and ";
      }
    }
    if ($keys{period} eq 'range') {
      $add = "to_days(now()) >= to_days('$keys{from}') and to_days(now() <= to_days('$keys{to}') and ";
    }

    if ($keys{e_type} eq 'good') {
      $add .= " bad='no' and ";
    }
    if ($keys{e_type} eq 'bad') {
      $add .= " bad='yes' and ";
    }
    if ($keys{u_type} eq 'active') {
      $add .= "isnull(date_unsub) and ";
    }
    if ($keys{u_type} eq 'unsubscribed') {
      $add .= "!isnull(date_unsub) and ";
    }
    $add .= "1=1";

    my $query = $dbh->quote("select * from $ver\_sub_$sub where $add");
#    print $query;
    my $fields = $dbh->quote(join ",", CGI::param("field"));
#    print $fields;

    my $format;
    if ($keys{format} eq 'text') {
      $format = $dbh->quote("$keys{format} - $keys{text_del} - $keys{text_del_count}");
    } else {
      $format = $dbh->quote($keys{format});
    }
#    print $format;
    my $point = 0;
    $point = $sub if ($keys{period} eq 'new');
    my $confirmemail = $dbh->quote($keys{sendtoemailemail});
    $q = "insert into $ver\_export set param=$query, exp_fields=$fields, report_type=$format, d=now(), point=$point, confirmemail=$confirmemail";
    $sth = $dbh->prepare($q);
    $sth->execute();
    my $export_id = $sth->{insertid} || $sth->{mysql_insertid};
    `$pathtoperl export.pl $export_id &`;
    print "Location: admin.cgi?page=export&export_id=$export_id\n\n";

    exit;
  } else {
    print "Content-type: text/html\n\n";

    my $export_id = sprintf("%d", $keys{export_id});
    $q = "select * from $ver\_export where id=$export_id";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($row = $sth->fetchrow_hashref) {
      if ($row->{done} ne '1') {
        $template = new Template ("tmpl/export.process.html");
#        $a = `ps -aux | grep $row->{pid}`;
#        if ($a =~ /export.pl/gm) {
          $template->replace('processing', $template->get_area('till-processing'));
#        } else {
#          $template->replace('processing', $template->get_area('processing-failture'));
#        }
      } else {
        $template = new Template("tmpl/export.success.html");
      }
      $template->replace('records', $row->{processed});
    }
    $template->clear_area('clear');
    $template->print_self(%keys);
    exit;
  }
}


sub DeleteRecentEmail {
  my $id = sprintf("%d", $keys{id});
  if ($userinfo{id} ne '1') {
    my %letter = get_record($dbh, "select * from $ver\_letters where id=$id");
    my $tid = sprintf("%d", $letter{sid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }

  $q = "delete from $ver\_letters where id=$id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  print "Location: admin.cgi?page=bulk\n\n";
  exit;
}

sub DeleteRecentFilter {
  my $id = sprintf("%d", $keys{id});
  $q = "delete from $ver\_filter where id=$id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  print "Location: admin.cgi?page=subscr&tid=$keys{tid}\n\n";
  exit;
}

sub NewLetter() {
  if ($userinfo{id} ne '1') {
    my $tid = sprintf("%d", $keys{tid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }
  my $tid = sprintf("%d", $keys{tid});
  my $qadmin_email = $dbh->quote($userinfo{email});
  $q = "insert into $ver\_letters set from_field=$qadmin_email, sid=$tid, done=0";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $lid = $sth->{insertid} || $sth->{mysql_insertid};
  print "Location: admin.cgi?page=editletter&lid=$lid&tid=$tid\n\n";
  exit;
}

sub save_letter {
   my $lid = sprintf("%d", $keys{lid});
    my $part;
    my $header_id = 0;
    my $body_id = 0;
    my $footer_id = 0;
    for $part ('header', 'body', 'footer') {
      if ($keys{"$part\_select"} eq '1') {
        if ($part eq 'header') {
          $header_id = $keys{"$part\_id"};
        } elsif ($part eq 'body') {
          $body_id = $keys{"$part\_id"};
        } else {
          $footer_id = $keys{"$part\_id"};
        }
      } else {
        my $cont = $dbh->quote($keys{$part."text"});
        $cont =~ s/\r//img;
        if ($keys{"save_$part\_template"} eq '1') {
          my $t_name = $dbh->quote($keys{"$part\_template_name"});
          $q = "insert into $ver\_attache set name = $t_name, cont = $cont, atype='$part', user_id = $userinfo{id}";
        } else {
          $q = "insert into $ver\_attache set name = '', cont = $cont, atype='nottemplate', user_id = $userinfo{id}";
        }
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr,"<b>$q</b>";
        if ($part eq 'header') {
          $header_id = $sth->{insertid} || $sth->{mysql_insertid};
        } elsif ($part eq 'body') {
          $body_id = $sth->{insertid} || $sth->{mysql_insertid};
        } else {
          $footer_id = $sth->{insertid} || $sth->{mysql_insertid};
        }
      }
    }
    my $subject = $dbh->quote($keys{subject});
    my $from_field = $dbh->quote($keys{from});
    my $delay = sprintf("%d", $keys{delay});
    my $delay_type = $dbh->quote($keys{delay_type});
    $keys{additional_header} =~ s/\r//igm;
    my $additional_header = $dbh->quote($keys{additional_header});
    my $shedule = sprintf("%d", $keys{shedule});
    my $weekly_day = sprintf("%d", $keys{weekly_day});
    my $monthly_day = sprintf("%d", $keys{monthly_day});
    my $dayly_hour = sprintf("%d", $keys{dayly_hour});
    my $weekly_hour = sprintf("%d", $keys{weekly_hour});
    my $monthly_hour = sprintf("%d", $keys{monthly_hour});
    my $dayly_min = sprintf("%d", $keys{dayly_min});
    my $weekly_min = sprintf("%d", $keys{weekly_min});
    my $monthly_min = sprintf("%d", $keys{monthly_min});

    $q = "update $ver\_letters set subject = $subject, from_field = $from_field, header_id=$header_id, body_id=$body_id, footer_id=$footer_id, delay_min = $delay, delay_type=$delay_type, additional_header=$additional_header, done=1,
    	shedule = $shedule, dayly_hour=$dayly_hour, dayly_min=$dayly_min, weekly_day=$weekly_day, weekly_hour=$weekly_hour, weekly_min=$weekly_min,
    	monthly_day=$monthly_day, monthly_hour=$monthly_hour, monthly_min=$monthly_min where id=$lid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr,"<b>$q</b>";


    my $i;
    $q = "select html_ids, attache_ids from $ver\_letters where id=$lid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr,"<b>$q</b>";
    my @html_ids;
    my @html_delete_ids = CGI::param("delete_html");
    my @html_ids_tmpl = CGI::param("template_html");

    my @file_ids;
    my @file_delete_ids = CGI::param("delete_file");
    my @file_ids_tmpl = CGI::param("template_file");

    while ($row = $sth->fetchrow_arrayref) {
      my $flag = 0;

      @html_ids = split /,/, $row->[0];
      @file_ids = split /,/, $row->[1];
      for (my $i = 0; $i<@html_delete_ids; $i++) {
        for (my $j = 0; $j<@html_ids; $j++) {
          splice(@html_ids, $j, 1) if ($html_delete_ids[$i] == $html_ids[$j]);
        }
      }
      for (my $i = 0; $i<@file_delete_ids; $i++) {
        for (my $j = 0; $j<@file_ids; $j++) {
          splice(@file_ids, $j, 1) if ($file_delete_ids[$i] == $file_ids[$j]);
        }
      }
      for (my $i = 0; $i<@html_ids; $i++) {
        my $flag = 0;
        for (my $j = 0; $j<@html_ids_tmpl; $j++) {
          $flag = 1 if ($html_ids[$i] == $html_ids_tmpl[$j]);
        }
        if ($flag == 0) {
          $q = "select atype from $ver\_attache where id=$html_ids[$i]";
          my $sth1 = $dbh->prepare($q);
          $sth1->execute() or print $sth1->errsrt,"<b>$q</b>";
          if ($sth1->rows > 0) {
            $row = $sth1->fetchrow_hashref;
            $flag = 1 if ($row->{atype} ne 'html');
          }
        }
        if ($flag == 0) {
          splice(@html_ids, $i, 1);
          $i--;
        }
      }
      @html_ids = (@html_ids, @html_ids_tmpl);

      for (my $i = 0; $i<@file_ids; $i++) {
        my $flag = 0;
        for (my $j = 0; $j<@file_ids_tmpl; $j++) {
          $flag = 1 if ($file_ids[$i] == $file_ids_tmpl[$j]);
        }
        if ($flag == 0) {
          $q = "select atype from $ver\_attache where id=$file_ids[$i]";
          my $sth1 = $dbh->prepare($q);
          $sth1->execute() or print $sth1->errsrt,"<b>$q</b>";
          if ($sth1->rows > 0) {
            $row = $sth1->fetchrow_hashref;
            $flag = 1 if ($row->{atype} ne 'attache');
          }
        }
        if ($flag == 0) {
          splice(@file_ids, $i, 1);
          $i--;
        }
      }
      @file_ids = (@file_ids, @file_ids_tmpl);

    }
    for $i (1..5) {
      my $file = $keys{"html$i"};
      if ($file) {
        my @a = <$file>;
        my $a = join '', @a;
        $a = $dbh->quote($a);
        my $path = $dbh->quote($file);
        if ($keys{"save_html$i"} eq '1') {
          my $name = $dbh->quote($keys{"html$i\_name"});
          $q = "insert into $ver\_attache set cont=$a, path=$path, atype='html', name=$name, content_type='text/html', user_id = $userinfo{id}";
        } else {
          $q = "insert into $ver\_attache set cont=$a, path=$path, atype='nottemplate', content_type='text/html', user_id = $userinfo{id}";
        }
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr,"<b>$q</b>";
        my $iiii = $sth->{insertid} || $sth->{mysql_insertid};
        @html_ids = (@html_ids, $iiii);
      }
      my $file = $keys{"file$i"};
      if ($file) {
        my @a = <$file>;
        my $a = join '', @a;
        $a = $dbh->quote($a);
        my $path = $dbh->quote($file);
        my $c = $q_CGI->param("file$i");

        my $ctype = $q_CGI->uploadInfo($c)->{"Content-Type"};
        if ($keys{"save_file$i"} eq '1') {
          my $name = $dbh->quote($keys{"file$i\_name"});
          $q = "insert into $ver\_attache set cont=$a, path=$path, atype='attache', name=$name, content_type='$ctype', user_id = $userinfo{id}";
        } else {
          $q = "insert into $ver\_attache set cont=$a, path=$path, atype='nottemplate', content_type='$ctype', user_id = $userinfo{id}";
        }
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr,"<b>$q</b>";
        my $iiii = $sth->{insertid} || $sth->{mysql_insertid};
        @file_ids = (@file_ids, $iiii);
      }
    }
    for $i (6..15) {
      my $file = $keys{"file$i"};
      if (($file ne 'http://')and($file ne '')) {
        my $qfile = $dbh->quote($file);
        $q = "insert into $ver\_attache set  path=$qfile, atype='nottemplate', content_type='external', user_id = $userinfo{id}";
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr,"<b>$q</b>";
        my $iiii = $sth->{insertid} || $sth->{mysql_insertid};
        @file_ids = (@file_ids, $iiii);
      }
    }
    my %c = ();
    for my $i(@html_ids) {
      $c{$i} ++;
    }
    @html_ids = keys %c;
    my %c = ();
    for my $i(@file_ids) {
      $c{$i} ++;
    }
    @file_ids = keys %c;

    $q = "update $ver\_letters set html_ids='".(join ',', @html_ids)."', attache_ids='".(join ',', @file_ids)."' where id=$lid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr,"<b>$q</b>";
    $q = "select header_id, body_id, footer_id, html_ids, attache_ids from $ver\_letters";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my @list = (0);
    while ($row = $sth->fetchrow_arrayref) {
      @list = (@list, $row->[0]);
      @list = (@list, $row->[1]);
      @list = (@list, $row->[2]);
      @list = (@list, grep {/\d+/} split ',', $row->[3]);
      @list = (@list, grep {/\d+/} split ',', $row->[4]);
    }
    @list = sort {$a <=> $b} @list;
    my $i = 1;
    while ($i < @list) {
      if ($list[$i] eq $list[$i-1]) {
        splice(@list, $i, 1);
      } else {
        $i++;
      }
    }
    my $ids = join ', ', @list;
    $q = "delete from $ver\_attache where atype='nottemplate' and id not in ($ids)";
    $dbh->do($q) or print $dbh->errstr;

}

sub EditLetter {
  my $lid = sprintf("%d", $keys{lid});
  my $tid = sprintf("%d", $keys{tid});
  if ($userinfo{id} ne '1') {
    my $tid = sprintf("%d", $keys{tid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }
  if ($keys{action} eq 'editletter') {
    &save_letter(%keys);
    print "Location: admin.cgi?page=subscr&tid=$tid\n\n";
    exit;
  }
  print "Content-type: text/html\n\n";
  $template = new Template('tmpl/main.html', 'content', 'tmpl/newletter.html');

  $template = make_html_for_letter($template, $lid);

  my @list  = ();

  for my $i ('hour', 'day', 'week', 'month') {
    my %in = (
    	'type' => $i,
    	'selected' => ($row->{delay_type} eq $i? 'selected' : '')
    );
    @list = (@list, \%in);
  }
  $template->make_for_array('delay-list', $template->get_area('delay-list'), @list);
  $template->replace('delay', $row->{delay_min});


  $template->clear_area('clear');

  $template->print_self(%keys);
  exit;
}

sub make_html_for_letter {
  my ($template, $lid) = @_;
  $lid = sprintf("%d", $lid);
  $q = "select * from $ver\_letters where id=$lid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr,$q;
  $row = $sth->fetchrow_hashref;
  my %in = (
  	'lid' => $row->{id},
  	'from' => $row->{from_field},
  	'subject' => $row->{subject},
  	'additional_header' => $row->{additional_header},
  	'check_immediatly' => ($row->{delay_min} eq '0' ? 'checked' : ''),
  	"shedule=$row->{shedule}" => 'checked',
  	'dayly_hour' => $row->{dayly_hour},
  	'dayly_min' => $row->{dayly_min},
  	"week_day=$row->{weekly_day}" => 'selected',
  	'weekly_hour' => $row->{weekly_hour},
  	'weekly_min' => $row->{weekly_min},
  	'monthly_day' => $row->{monthly_day},
  	'monthly_hour' => $row->{monthly_hour},
  	'monthly_min' => $row->{monthly_min},
  );

  $template->replace_hash(%in);
  my %in = (
  	'shedule=0' => '', 'shedule=1' => '',
  	'shedule=2' => '', 'shedule=3' => '',
  	'shedule=4' => '',
  	'week_day=1' => '', 'week_day=2' => '',
  	'week_day=3' => '', 'week_day=4' => '',
  	'week_day=5' => '', 'week_day=6' => '',
  	'week_day=7' => '',
  );
  my $part;
  for $part ('header', 'body', 'footer') {
    $q = "select id, name from $ver\_attache where atype='$part'";
    my $sth1 = $dbh->prepare($q);
    $sth1->execute() or print $sth->errstr, $q;
    my @list = ();
    my $row1;
    while ($row1 = $sth1->fetchrow_hashref) {
      my %in = (
    	'name' => $row1->{name},
    	'id' => $row1->{id},
    	'is-selected' => ($row1->{id} eq $row->{"$part\_id"} ? 'selected' : '')
      );
      @list = (@list, \%in);
    }
    $template->make_for_array("select-$part", $template->get_area("select-$part"), @list);

    $q = "select * from $ver\_attache where id=".$row->{"$part\_id"};
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr, $q;
    my $header = '';
    my $header_name = ();
    my $header_template_checked = '';
    my $header_text_checked = 'checked';
    if ($sth->rows > 0) {
      my $row1 = $sth->fetchrow_hashref;
      $header = $row1->{cont};
      $header_name = $row1->{name};
      $header_template_checked = ($row1->{atype} eq $part? 'checked' : '');
      $header_text_checked = ($row1->{atype} eq 'nottemplate'? 'checked' : '');
    }
    $template->replace("$part-text", $header);
    $template->replace("$part-template-name", $header_name);
    $template->replace("$part-template-checked", $header_template_checked);
    $template->replace("$part-text-checked", $header_text_checked);
  }


  $q = "select * from $ver\_attache where atype='html'";
  my $sth1 = $dbh->prepare($q);
  $sth1->execute() or print $sth->errstr,$q;
  my @list = ();
  my $row1;
  my @attached_html = split /,/, $row->{html_ids};
  while ($row1 = $sth1->fetchrow_hashref) {
    my $selected = '';
    for (@attached_html) {
      $selected = 'selected' if ($_ == $row1->{id});
    }

    my %in = (
    	'name' => $row1->{name},
    	'id' => $row1->{id},
    	'path' => $row1->{path},
    	'selected' => $selected
    );
    @list = (@list, \%in);
  }
  if ($#list > -1) {
    $template->make_for_array('html-file-list', $template->get_area('html-file-list'), @list);
  } else {
    $template->replace('html-file-list', $template->get_area('no-html-file-list'));
  }
  if ($row->{html_ids} ne '') {
    $q = "select * from $ver\_attache where id in ($row->{html_ids}) and atype='nottemplate'";
    $sth1 = $dbh->prepare($q);
    $sth1->execute() or print $sth->errstr, "<b>$q</b>";
    @list = ();
    while ($row1 = $sth1->fetchrow_hashref) {
      my %in = (
      	  'id' => $row1->{id},
    	  'name' => $row1->{name},
    	  'path' => $row1->{path}
      );
      @list = (@list, \%in);
    }
    if ($#list > -1) {
      $template->make_for_array('html-attached-list', $template->get_area('html-attached-list'), @list);
    } else {
      $template->replace('html-attached-list', $template->get_area('no-html-attached-list'));
    }
  }
  $template->replace('html-attached-list', $template->get_area('no-html-attached-list'));

  $q = "select * from $ver\_attache where atype='attache'";
  my $sth1 = $dbh->prepare($q);
  $sth1->execute() or print $sth->errstr, $q;
  my @list = ();
  my $row1;
  my @attached_file = split /,/, $row->{attache_ids};
  while ($row1 = $sth1->fetchrow_hashref) {
    my $selected = '';
    for (@attached_file) {
      $selected = 'selected' if ($_ == $row1->{id});
    }

    my %in = (
    	'name' => $row1->{name},
    	'id' => $row1->{id},
    	'path' => $row1->{path},
    	'selected' => $selected
    );
    @list = (@list, \%in);
  }
  if ($#list > -1) {
    $template->make_for_array('file-file-list', $template->get_area('file-file-list'), @list);
  } else {
    $template->replace('file-file-list', $template->get_area('no-file-file-list'));
  }
  if ($row->{attache_ids} ne '') {
    $q = "select * from $ver\_attache where id in ($row->{attache_ids}) and atype='nottemplate'";
    $sth1 = $dbh->prepare($q);
    $sth1->execute() or print $sth->errstr, $q;
    @list = ();
    while ($row1 = $sth1->fetchrow_hashref) {
      my %in = (
    	  'id' => $row1->{id},
    	  'name' => $row1->{name},
    	  'path' => $row1->{path}
      );
      @list = (@list, \%in);
    }
    if ($#list > -1) {
      $template->make_for_array('file-attached-list', $template->get_area('file-attached-list'), @list);
    } else {
      $template->replace('file-attached-list', $template->get_area('no-file-attached-list'));
    }
  }
  $template->replace('file-attached-list', $template->get_area('no-file-attached-list'));
  $template->replace('server-url', $vars_server_url);
  return $template;
}








sub AddNewType {
  if ($userinfo{id} ne '1') {
    if ($userinfo{allow_create_camp_bool} eq '0') {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
    my %info = get_record($dbh, "select count(id) as count from $ver\_types where user_id=$userinfo{id}");
    if ($userinfo{allow_create_camp_limit} != -100) {
      if ($info{count} >= $userinfo{allow_create_camp_limit}) {
        print "Content-type: text/html\n\n";
        print $userinfo{allow_create_camp_limit};
        $template = new Template('tmpl/user.error.action.html');
        $template->print(%keys);
        exit;
      }
    }
  }
  if ($keys{action} eq 'addnewtype') {
    my $name = $dbh->quote($keys{typename});
    my $desc = $dbh->quote($keys{typedesc});
    my $unpage = $dbh->quote($keys{unsubscribe_page});
    my $admin_email = $dbh->quote($keys{admin_email});
    my $col_on_page = sprintf("%d", $keys{num_on_page});
    $col_on_page = 30 if ($col_on_page == 0);
    my $active_days = sprintf("%d", $keys{delete_subscriber});
    $active_days = -100 if (($active_days == 0)or($keys{delete_subscriberno} eq '1'));
    $keys{subscribe_text} =~ s/\r//gs;
    my $subscribe_html = $dbh->quote($keys{subscribe_text});
    my $subscribe_url = $dbh->quote($keys{subscribe_url});
    my $subscribe_text_url = ($keys{subscribe_html_radio} eq 'html' ? 1 : 0);
    my $unsubscribe_html = $dbh->quote($keys{unsubscribe_text});
    my $unsubscribe_url = $dbh->quote($keys{unsubscribe_url});
    my $unsubscribe_text_url = ($keys{unsubscribe_html_radio} eq 'html' ? 1 : 0);
    my $send_confirm_subscribe = ($keys{confirmsubscribe} eq '1' ? 1 : 0);
    my $confirm_subscribe_email = $dbh->quote($keys{confirmsubscribefrom});
    my $confirm_subscribe_subject = $dbh->quote($keys{confirmsubscribesubject});
    my $confirm_subscribe_message = $dbh->quote($keys{confirmsubscribetext});
    my $send_confirm_unsubscribe = ($keys{confirmunsubscribe} eq '1' ? 1 : 0);
    my $confirm_unsubscribe_email = $dbh->quote($keys{confirmunsubscribefrom});
    my $confirm_unsubscribe_subject = $dbh->quote($keys{confirmunsubscribesubject});
    my $confirm_unsubscribe_message = $dbh->quote($keys{confirmunsubscribetext});
    my $use_autoresponce = $keys{checkemail} eq '1' ? 1 : 0;
    my $autoresponce_email = $dbh->quote($keys{checkemailemail});
    my $autoresponce_host = $dbh->quote($keys{checkemailhost});
    my $autoresponce_login = $dbh->quote($keys{checkemaillogin});
    my $autoresponce_password = $dbh->quote($keys{checkemailpassword});
    my $autoresponce_deleteletters = $keys{checkemaildelete} eq '1' ? 1 : 0;
    my $processing_emails = $dbh->quote($keys{processingemails});
    my $use_approve = $keys{approveusers} eq '1' ? 1 : 0;
    my $send_approve = $keys{approveapprove} eq '1' ? 1 : 0;
    my $approve_email = $dbh->quote($keys{approvefrom});
    my $approve_subject = $dbh->quote($keys{approvesubject});
    my $approve_message = $dbh->quote($keys{approvetext});
    my $send_notapprove = $keys{approvenotapprove} eq '1' ? 1 : 0;
    my $notapprove_email = $dbh->quote($keys{notapprovefrom});
    my $notapprove_subject = $dbh->quote($keys{notapprovesubject});
    my $notapprove_message = $dbh->quote($keys{notapprovetext});
    my $save_dupes = $dbh->quote($keys{dupe});
    my $use_confirm_url = sprintf("%d", $keys{use_confirm_url});
    my $subscribe_confirm_text_url = $keys{subscribe_confirm_html_radio} eq 'html' ? 1 : 0;
    my $subscribe_confirm_html = $dbh->quote($keys{subscribe_confirm_text});
    my $subscribe_confirm_url = $dbh->quote($keys{subscribe_confirm_url});
#    my $unsubscribe_confirm_text_url = $keys{unsubscribe_confirm_html_radio} eq 'html' ? 1 : 0;
#    my $unsubscribe_confirm_html = $dbh->quote($keys{unsubscribe_confirm_text});
#    my $unsubscribe_confirm_url = $dbh->quote($keys{unsubscribe_confirm_url});
    my $dayly_stats = $dbh->quote($keys{daylystats});
    my $weekly_stats = $dbh->quote($keys{weeklystats});
    my $monthly_stats = $dbh->quote($keys{monthlystats});


    $q = "insert into $ver\_types set name=$name, t_desc=$desc, unpage=$unpage, admin_email=$admin_email, col_on_page=$col_on_page,
    	active_days = $active_days, subscribe_html = $subscribe_html, subscribe_url = $subscribe_url,
    	subscribe_text_url = $subscribe_text_url, unsubscribe_html = $unsubscribe_html, unsubscribe_url = $unsubscribe_url,
    	unsubscribe_text_url = $unsubscribe_text_url,
    	send_confirm_subscribe = $send_confirm_subscribe, confirm_subscribe_email = $confirm_subscribe_email,
    	confirm_subscribe_subject = $confirm_subscribe_subject, confirm_subscribe_message = $confirm_subscribe_message,
    	send_confirm_unsubscribe = $send_confirm_unsubscribe, confirm_unsubscribe_email = $confirm_unsubscribe_email,
    	confirm_unsubscribe_subject = $confirm_unsubscribe_subject, confirm_unsubscribe_message = $confirm_unsubscribe_message,
    	use_autoresponce = $use_autoresponce, autoresponce_email = $autoresponce_email, autoresponce_host = $autoresponce_host,
    	autoresponce_login = $autoresponce_login, autoresponce_password = $autoresponce_password,
    	autoresponce_deleteletters = $autoresponce_deleteletters,
    	processing_emails = $processing_emails,
    	use_approve = $use_approve, send_approve = $send_approve, approve_email = $approve_email, approve_subject = $approve_subject,
    	approve_message = $approve_message,
    	send_notapprove = $send_notapprove, notapprove_email = $notapprove_email, notapprove_subject = $notapprove_subject,
    	notapprove_message = $notapprove_message,
    	use_confirm_url = $use_confirm_url, subscribe_confirm_text_url = $subscribe_confirm_text_url,
    	subscribe_confirm_html = $subscribe_confirm_html, subscribe_confirm_url = $subscribe_confirm_url,
    	dayly_stats = $dayly_stats, weekly_stats = $weekly_stats, monthly_stats = $monthly_stats,
    	user_id = $userinfo{id},
    	save_dupes = $save_dupes, create_date = now(), change_date = now()
    	";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my $id = $sth->{insertid} || $sth->{mysql_insertid};
    $q = "CREATE TABLE $ver\_sub_$id (
          id bigint(20) NOT NULL auto_increment,
          checked int(11) default '0',
          unsub int(11) default '0',
          bad int(11) default '0',
          confirm int(11) NOT NULL default '0',
          approved int(11) NOT NULL default '0',
          active int(11) NOT NULL default '0',
          expired int(11) NOT NULL default '0',
          email varchar(200) default NULL,
          first_name varchar(200) default NULL,
          last_name varchar(200) default NULL,
          full_name varchar(200) default NULL,
          company varchar(200) default NULL,
          language varchar(200) default NULL,
          phone varchar(200) default NULL,
          icq varchar(200) default NULL,
          address varchar(200) default NULL,
          address2 varchar(200) default NULL,
          city varchar(200) default NULL,
          state varchar(200) default NULL,
          country varchar(200) default NULL,
          birthdate varchar(200) default NULL,
          age varchar(200) default NULL,
          sex varchar(200) default NULL,
          website varchar(200) default NULL,
          heard varchar(200) default NULL,
          business varchar(200) default NULL,
          date_sub datetime default NULL,
          date_unsub datetime default NULL,
          ip varchar(15) default NULL,
          lettersformat varchar(20) default NULL,
          additional1 varchar(200) default NULL,
          additional2 varchar(200) default NULL,
          additional3 varchar(200) default NULL,
          additional4 varchar(200) default NULL,
          additional5 varchar(200) default NULL,
          additional6 varchar(200) default NULL,
          additional7 varchar(200) default NULL,
          additional8 varchar(200) default NULL,
          additional9 varchar(200) default NULL,
          additional10 varchar(200) default NULL,
          additional11 varchar(200) default NULL,
          additional12 varchar(200) default NULL,
          grp bigint not null default '0',
          confirm_url varchar(200) default NULL,
          once_approved int not null,
          once_expired int not null,
          form_fields blob,
          PRIMARY KEY  (id),
          KEY email (email),
          KEY checked (checked),
          KEY active (active),
          KEY expired (expired,approved,unsub,grp),
          KEY approved (approved,confirm,grp),
          KEY confirm (confirm,grp),
          KEY unsub (unsub,grp),
          KEY grp (grp,expired)
    )";
    $dbh->do($q) or print $dbh->errstr;
    print "Location: admin.cgi\n\n";
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/add.new.type.html');
  $template->replace('admin_email', $userinfo{email});
  $template->print(%keys);
  exit;
}




sub CheckLogin {
  my $username = $cookie{username};
  my $password = $cookie{passwd};
  $q = "select passwd, id from $ver\_users where name=".$dbh->quote($username)." and type=0";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $logged = 0;
  my $id = 0;
  if ($row = $sth->fetchrow_hashref) {
    if (crypt($row->{passwd}, "Md") == $password) {
      $id = $row->{id};
      $logged = 1;
    }
  }
  if ($logged == 0) {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/login.html');
    print $template->{code};
    exit;
  }
  return $id;
}


sub ImportPage {
  print "Content-type: text/html\n\n";
  if ($userinfo{id} eq '1') {
    $q = "select * from $ver\_types as types where id!=1 and parent = 0";
  } else {
    my @campaigns = grep {/\d+/} split /-/, $userinfo{other_camp_edit};
    my $camps = join ', ', @campaigns;
    $camps = 0 if ($camps eq '');
    $q = "select * from $ver\_types as types where id!=1 and parent = 0 and (user_id=$userinfo{id} or id in ($camps))";
  }
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  $template = new Template('tmpl/import.html');
  my @list = ();
  my %list_id;
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'id' => $row->{id},
	'name' => $row->{name},
	'col' => $row->{col},
	'dup' => $row->{dupes},
	'checked' => $row->{checked},
	'bad' => $row->{bad},
	'unsub' => $row->{unsub}
    );
    @list = (@list, \%in);
    $list_id{$row->{id}} = $#list;
  }
  $sth->finish();
  $template->make_for_array('sub-list', $template->get_area('sub-list'), @list);

  $template->clear_area('clear');
  $template->print(%keys);
  exit;
}


sub DeleteType {
  my $tid = sprintf("%d", $keys{tid});
  if ($userinfo{id} ne '1') {
    my $tid = sprintf("%d", $keys{tid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }

  $q = "select * from $ver\_types where id=$tid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    $q = "update $ver\_types set col=col-$row->{col}, dupes=dupes-$row->{dupes}, bad=bad-$row->{bad} where id=1";
    my $sth1 = $dbh->prepare($q);
    $sth1->execute() or print $sth->errstr;
    $q = "delete from $ver\_types where id=$tid";
    $sth1 = $dbh->prepare($q);
    $sth1->execute() or print $sth->errstr;
    $q = "delete from $ver\_letters where sid=$tid";
    $sth1 = $dbh->prepare($q);
    $sth1->execute() or print $sth->errstr;
    $q = "delete from $ver\_stat where sid=$tid";
    $sth1 = $dbh->prepare($q);
    $sth1->execute() or print $sth->errstr;

  }
  print "Location: admin.cgi\n\n";
  exit;
}



sub EditType {
  my $tid = sprintf("%d", $keys{tid});
  if ($userinfo{id} ne '1') {
    my $tid = sprintf("%d", $keys{tid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }

  if ($keys{action} eq 'edittype') {
    my $tid = sprintf("%d", $keys{tid});

    my $name = $dbh->quote($keys{typename});
    my $desc = $dbh->quote($keys{typedesc});
    my $unpage = $dbh->quote($keys{unsubscribe_page});
    my $admin_email = $dbh->quote($keys{admin_email});
    my $col_on_page = sprintf("%d", $keys{num_on_page});
    $col_on_page = 30 if ($col_on_page == 0);
    my $active_days = sprintf("%d", $keys{delete_subscriber});
    $active_days = -100 if (($active_days == 0)or($keys{delete_subscriberno} eq '1'));
    $keys{subscribe_text} =~ s/\r//gs;
    my $subscribe_html = $dbh->quote($keys{subscribe_text});
    my $subscribe_url = $dbh->quote($keys{subscribe_url});
    my $subscribe_text_url = ($keys{subscribe_html_radio} eq 'html' ? 1 : 0);
    my $unsubscribe_html = $dbh->quote($keys{unsubscribe_text});
    my $unsubscribe_url = $dbh->quote($keys{unsubscribe_url});
    my $unsubscribe_text_url = ($keys{unsubscribe_html_radio} eq 'html' ? 1 : 0);
    my $send_confirm_subscribe = ($keys{confirmsubscribe} eq '1' ? 1 : 0);
    my $confirm_subscribe_email = $dbh->quote($keys{confirmsubscribefrom});
    my $confirm_subscribe_subject = $dbh->quote($keys{confirmsubscribesubject});
    my $confirm_subscribe_message = $dbh->quote($keys{confirmsubscribetext});
    my $send_confirm_unsubscribe = ($keys{confirmunsubscribe} eq '1' ? 1 : 0);
    my $confirm_unsubscribe_email = $dbh->quote($keys{confirmunsubscribefrom});
    my $confirm_unsubscribe_subject = $dbh->quote($keys{confirmunsubscribesubject});
    my $confirm_unsubscribe_message = $dbh->quote($keys{confirmunsubscribetext});
    my $use_autoresponce = $keys{checkemail} eq '1' ? 1 : 0;
    my $autoresponce_email = $dbh->quote($keys{checkemailemail});
    my $autoresponce_host = $dbh->quote($keys{checkemailhost});
    my $autoresponce_login = $dbh->quote($keys{checkemaillogin});
    my $autoresponce_password = $dbh->quote($keys{checkemailpassword});
    my $autoresponce_deleteletters = $keys{checkemaildelete} eq '1' ? 1 : 0;
    my $processing_emails = $dbh->quote($keys{processingemails});
    my $use_approve = $keys{approveusers} eq '1' ? 1 : 0;
    my $send_approve = $keys{approveapprove} eq '1' ? 1 : 0;
    my $approve_email = $dbh->quote($keys{approvefrom});
    my $approve_subject = $dbh->quote($keys{approvesubject});
    my $approve_message = $dbh->quote($keys{approvetext});
    my $send_notapprove = $keys{approvenotapprove} eq '1' ? 1 : 0;
    my $notapprove_email = $dbh->quote($keys{notapprovefrom});
    my $notapprove_subject = $dbh->quote($keys{notapprovesubject});
    my $notapprove_message = $dbh->quote($keys{notapprovetext});
    my $save_dupes = $dbh->quote($keys{dupe});
    my $use_confirm_url = sprintf("%d", $keys{use_confirm_url});
    my $subscribe_confirm_text_url = $keys{subscribe_confirm_html_radio} eq 'html' ? 1 : 0;
    my $subscribe_confirm_html = $dbh->quote($keys{subscribe_confirm_text});
    my $subscribe_confirm_url = $dbh->quote($keys{subscribe_confirm_url});
#    my $unsubscribe_confirm_text_url = $keys{unsubscribe_confirm_html_radio} eq 'html' ? 1 : 0;
#    my $unsubscribe_confirm_html = $dbh->quote($keys{unsubscribe_confirm_text});
#    my $unsubscribe_confirm_url = $dbh->quote($keys{unsubscribe_confirm_url});
    my $dayly_stats = $dbh->quote($keys{daylystats});
    my $weekly_stats = $dbh->quote($keys{weeklystats});
    my $monthly_stats = $dbh->quote($keys{monthlystats});


    $q = "update $ver\_types set name=$name, t_desc=$desc, unpage=$unpage, admin_email=$admin_email, col_on_page=$col_on_page,
    	active_days = $active_days, subscribe_html = $subscribe_html, subscribe_url = $subscribe_url,
    	subscribe_text_url = $subscribe_text_url, unsubscribe_html = $unsubscribe_html, unsubscribe_url = $unsubscribe_url,
    	unsubscribe_text_url = $unsubscribe_text_url,
    	send_confirm_subscribe = $send_confirm_subscribe, confirm_subscribe_email = $confirm_subscribe_email,
    	confirm_subscribe_subject = $confirm_subscribe_subject, confirm_subscribe_message = $confirm_subscribe_message,
    	send_confirm_unsubscribe = $send_confirm_unsubscribe, confirm_unsubscribe_email = $confirm_unsubscribe_email,
    	confirm_unsubscribe_subject = $confirm_unsubscribe_subject, confirm_unsubscribe_message = $confirm_unsubscribe_message,
    	use_autoresponce = $use_autoresponce, autoresponce_email = $autoresponce_email, autoresponce_host = $autoresponce_host,
    	autoresponce_login = $autoresponce_login, autoresponce_password = $autoresponce_password,
    	autoresponce_deleteletters = $autoresponce_deleteletters,
    	processing_emails = $processing_emails,
    	use_approve = $use_approve, send_approve = $send_approve, approve_email = $approve_email, approve_subject = $approve_subject,
    	approve_message = $approve_message,
    	send_notapprove = $send_notapprove, notapprove_email = $notapprove_email, notapprove_subject = $notapprove_subject,
    	notapprove_message = $notapprove_message,
    	use_confirm_url = $use_confirm_url, subscribe_confirm_text_url = $subscribe_confirm_text_url,
    	subscribe_confirm_html = $subscribe_confirm_html, subscribe_confirm_url = $subscribe_confirm_url,
    	dayly_stats = $dayly_stats, weekly_stats = $weekly_stats, monthly_stats = $monthly_stats,
    	save_dupes = $save_dupes, change_date = now()
    	where id = $tid

    	";
    $dbh->do($q) or print $dbh->errstr;
    print "Location: admin.cgi\n\n";
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/edit.type.html');
  my $tid = sprintf("%d", $keys{tid});
  $q = "select * from $ver\_types where id=$tid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my ($t_name, $t_desc, $t_unpage, $admin_email);
  if ($sth->rows > 0) {
    $row = $sth->fetchrow_hashref;
    my $i;
    my %in;
    for $i (keys %$row) {
      $in{"s_$i"} = $row->{$i};
    }
    if ($in{s_col_on_page} == 0) {
      $in{s_col_on_page} = 30;
    }
    if ($in{s_active_days} == -100) {
      $in{s_active_days} = 0;
      $in{s_active_daysno} = 'checked';
    } else {
      $in{s_active_daysno} = '';
    }
    if ($in{s_subscribe_text_url} == 1) {
      $in{'s_subscribe_text_url=html'} = 'checked';
      $in{'s_subscribe_text_url=url'} = '';
    } else {
      $in{'s_subscribe_text_url=html'} = '';
      $in{'s_subscribe_text_url=url'} = 'checked';
    }
    if ($in{s_unsubscribe_text_url} == 1) {
      $in{'s_unsubscribe_text_url=html'} = 'checked';
      $in{'s_unsubscribe_text_url=url'} = '';
    } else {
      $in{'s_unsubscribe_text_url=html'} = '';
      $in{'s_unsubscribe_text_url=url'} = 'checked';
    }
    if ($in{"s_send_confirm_subscribe"} == 1) {
      $in{'s_send_confirm_subscribe=1'} = 'checked';
    } else {
      $in{'s_send_confirm_subscribe=1'} = '';
    }
    if ($in{"s_send_confirm_unsubscribe"} == 1) {
      $in{'s_send_confirm_unsubscribe=1'} = 'checked';
    } else {
      $in{'s_send_confirm_unsubscribe=1'} = '';
    }
    if ($in{s_use_autoresponce} == 1) {
      $in{"s_use_autoresponce=1"} = 'checked';
    } else {
      $in{"s_use_autoresponce=1"} = '';
    }
    if ($in{s_autoresponce_emails} == 1) {
      $in{"s_autoresponce_emails"} = 'checked';
    } else {
      $in{"s_autoresponce_emails"} = '';
    }
    $in{'s_save_dupes=kill'} = '';
    $in{'s_save_dupes=replace'} = '';
    if ($in{'s_save_dupes'} eq 'save') {
      $in{'s_save_dupes=save'} = 'checked';
    }
    if ($in{s_save_dupes} eq 'kill') {
      $in{'s_save_dupes=kill'} = 'checked';
    }
    if ($in{s_save_dupes} eq 'replace') {
      $in{'s_save_dupes=replace'} = 'checked';
    }
    if ($in{s_use_approve} == 1) {
      $in{'s_use_approve=1'} = 'checked';
    } else {
      $in{'s_use_approve=1'} = '';
    }
    if ($in{s_send_approve} == 1) {
      $in{'s_send_approve=1'} = 'checked';
    } else {
      $in{'s_send_approve=1'} = '';
    }
    if ($in{s_send_notapprove} == 1) {
      $in{'s_send_notapprove=1'} = 'checked';
    } else {
      $in{'s_send_notapprove=1'} = '';
    }
    if ($in{s_use_confirm_url} == 1) {
      $in{'s_use_confirm_url=1'} = 'checked';
    } else {
      $in{'s_use_confirm_url=1'} = '';
    }
    if ($in{s_subscribe_confirm_text_url} == 1) {
      $in{'s_subscribe_confirm_text_url=html'} = 'checked';
      $in{'s_subscribe_confirm_text_url=url'} = '';
    } else {
      $in{'s_subscribe_confirm_text_url=html'} = '';
      $in{'s_subscribe_confirm_text_url=url'} = 'checked';
    }
    if ($in{s_unsubscribe_confirm_text_url} == 1) {
      $in{'s_unsubscribe_confirm_text_url=html'} = 'checked';
      $in{'s_unsubscribe_confirm_text_url=url'} = '';
    } else {
      $in{'s_unsubscribe_confirm_text_url=html'} = '';
      $in{'s_unsubscribe_confirm_text_url=url'} = 'checked';
    }

    $template->replace_hash(%in);
#    $t_name = $row->{name};
#    $t_desc = $row->{t_desc};
#    $t_unpage = $row->{unpage};
#    $admin_email = $row->{admin_email};
  }
#  $template->replace('type_name', s_q($t_name));
#  $template->replace('type_desc', $t_desc);
#  $template->replace('unpage', $t_unpage);
#  $template->replace('admin_email', $admin_email);
  $template->print(%keys);
  exit;
}



sub Logout {
  print "Set-cookie: login=\nSet-cookie: username=\nSet-cookie: passwd=\nLocation: admin.cgi\n\n";
  exit;
}


sub Support {
  exit;
}


sub Settings {
  if ($userinfo{id} ne '1') {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/user.error.action.html');
    $template->print(%keys);
    exit;
  }

  if ($keys{action} eq 'set') {
    $template = new Template('tmpl/svars.pm');
    my %in = (
    	'server_path' => s_q($keys{installurl}),
    	'sendmail_path' => s_q($keys{sendmailpath}),
    	'imagesurl' => $keys{imagesurl},
    	'dns-ip' => $keys{dns},
    	'emails-on-page' => $keys{emails_on_page},
    	'site-name' => $keys{sitename},
    );
    $template->replace_hash(%in);
    open FILE, ">lib/svars.pm";
    print FILE $template->{code};
    close FILE;
    my $returnemail = $dbh->quote($keys{returnemail});
    my $returnhost = $dbh->quote($keys{returnhost});
    my $returnlogin = $dbh->quote($keys{returnlogin});
    my $returnpassword = $dbh->quote($keys{returnpassword});
    $q = "update $ver\_settings set returnemail=$returnemail, returnhost=$returnhost, returnlogin=$returnlogin, returnpassword=$returnpassword";
#    print "Content-type: text/html\n\n$q<br>";
    $dbh->do($q) or print $dbh->errstr;
    print "Location: admin.cgi?page=settings\n\n";
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  my %SETTINGS = get_record($dbh, "select * from $ver\_settings");
  $template = new Template('tmpl/settings.html');
  my %in = (
  	'installurl' => s_q($vars_server_url),
  	'sendmailpath' => s_q($vars_path_to_sendmail),
  	'imagesurl' => $vars_path_to_images,
    	'dns-ip' => $vars_dns,
    	'emails-on-page' => $vars_emails_on_page,
    	'site-name' => $vars_site_name,
    	'return-email' => $SETTINGS{returnemail},
    	'return-host' => $SETTINGS{returnhost},
    	'return-login' => $SETTINGS{returnlogin},
    	'return-password' => $SETTINGS{returnpassword},

  );
  $template->replace_hash(%in);
  $template->print(%keys);
  exit;
}

sub SendImmediatly {
#  if ($userinfo{id} ne '1') {
#    print "Content-type: text/html\n\n";
#    $template = new Template('tmpl/user.error.action.html');
#    $template->print(%keys);
#    exit;
#  }
  my $lid = sprintf("%d", $keys{lid});
  if ($keys{action} eq '') {
    if ($lid == 0) {
      my $qadminemail = $dbh->quote($userinfo{email});
      $q = "insert into $ver\_letters set from_field=$qadminemail, sid=0, done=0";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      $lid = $sth->{insertid} || $sth->{mysql_insertid};
    }

    my $c = new CGI;
    my $params = '';
    for my $i (keys %keys) {
      $i = encodeurl($i);
      my @k = CGI::param("$i");

      for my $k (@k) {
        $k = encodeurl($k);
        $params .= "$i=$k&";
      }
    }

    my $params = $dbh->quote($params);
    my $start_date = $dbh->quote($keys{date_start});
    my $start_hour = sprintf("%d", $keys{hour_start});
    $q = "insert into $ver\_bulk set params=$params, done=0, lid = $lid, processed=0, start_date = $start_date, start_hour=$start_hour";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my $bid = $sth->{insertid} || $sth->{mysql_insertid};
    print "Location: admin.cgi?page=sendimmediatly&lid=$lid&bid=$bid&action=letter\n\n";
    exit;
  }
  if ($keys{action} eq 'letter') {
    print "Content-type: text/html\n\n";

    $template = new Template('tmpl/main.html', 'content', 'tmpl/send.immediatly.html');
    $template = make_html_for_letter($template, $keys{lid});

    $template->clear_area('clear');
    $template->print_self(%keys);
    exit;
  }
  if ($keys{action} eq 'sendpage') {
    save_letter();
    my $sid = sprintf("%d", $keys{tid});
    my $fid = sprintf("%d", $keys{filter_id});
    if ($fid == 0) {
      $q = "insert into $ver\_filter set sid = $sid";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      $fid = $sth->{insertid} || $sth->{mysql_insertid};
    }
    print "Location: admin.cgi?page=sendimmediatly&bid=$keys{bid}&action=presendscreen&lid=$lid\n\n";
    exit;
  }
  if ($keys{action} eq 'presendscreen') {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/main.html', 'content', 'tmpl/bulk.presend.html');

    $template->clear_area('clear');
    $template->print_self(%keys);
    exit;
  }
  if ($keys{action} eq 'sendtest') {
    print "Content-type: text/html\n\n";
    my $filter_id = sprintf("%d", $keys{filter_id});
    my $lid = sprintf("%d", $keys{lid});
    my $test_email = $keys{"testemail"};
    `$pathtoperl send.pl "bid=$keys{bid}&letter=$lid&email=$test_email" 2>1 & `;
    $template = new Template('tmpl/bulk.test.done.html');

    $template->clear_area('clear');
    $template->print_self(%keys);
    exit;
  }
  if ($keys{action} eq 'sendlater') {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/bulk.later.html');
    $template->clear_area('clear');
    $template->print_self(%keys);
    exit;
  }
  if ($keys{action} eq 'startsend') {

    my $bid = sprintf("%d", $keys{bid});
    my $lid = sprintf("%d", $keys{lid});

    my $email = $dbh->quote($keys{notify_email});
    $q = "update $ver\_bulk set done=1, notify_email=$email where id=$bid";
    $dbh->do($q) or print $dbh->errstr;
    $q = "update $ver\_letters set done=1 where id=$lid";
    $dbh->do($q) or print $dbh->errstr;
    my %info = get_record($dbh, "select * from $ver\_bulk where id = $bid");
    if ($info{start_date} eq '') {
      `$pathtoperl send.pl "bid=$bid&letter=$lid" &`;
      print "Location: admin.cgi?bid=$bid&page=sendimmediatly&action=process\n\n";
    } else {
      print "Location: admin.cgi?page=sendimmediatly&action=sendlater\n\n";
    }
    exit;
  }
  if ($keys{action} eq 'process') {
  print "Content-type: text/html\n\n";
    my $bid = sprintf("%d", $keys{bid});
    my $lid = sprintf("%d", $keys{lid});
    $q = "select * from $ver\_bulk where id=$bid";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    while ($row = $sth->fetchrow_hashref) {
      if ($row->{done} eq '2') {
        $template = new Template('tmpl/bulk.process.done.html');
      } else {
        $template = new Template('tmpl/bulk.process.html');
      }
      $template->replace('records', $row->{processed});
    }

    $template->clear_area('clear');
    $template->print_self(%keys);
    exit;
  }

  exit;
}

sub SetDupes {
  my $tid = sprintf("%d", $keys{tid});
  my $dup = $dbh->quote($keys{dupe});
  $q = "update $ver\_types set save_dupes=$dup where id=$tid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  print "Location: admin.cgi?page=subscr&tid=$tid\n\n";
  exit;
}

sub DeleteEmail {
  my $tid = sprintf("%d", $keys{tid});
  if ($userinfo{id} ne '1') {
    my $tid = sprintf("%d", $keys{tid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }
  my $email = sprintf("%d", $keys{email});
  $q = "select email, bad, checked from $ver\_sub_$tid where id=$email";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $e_mail = '';
  while ($row = $sth->fetchrow_hashref) {
    $e_mail = $row->{email};
    if ($row->{bad} eq '1') {
      $q = "update $ver\_types set bad=bad-1 where id=$tid or id=1";
    } else {
      $q = "update $ver\_types set checked=checked-1 where id=$tid or id=1";
    }
#    print "Content-type: text/html\n\n$q", $row->{bad};
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
  }
  $q = "delete from $ver\_sub_$tid where id=$email";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  $q = "update $ver\_types set col=col-1 where id=$tid or id=1";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;

  print "Location: admin.cgi?page=subscr&tid=$tid&group=$keys{group}&area=$keys{area}&p=$keys{p}\n\n";
  `$pathtoperl subscribe.cgi delete "$e_mail" $tid &`;
  exit;
}

sub CopyProcess {
  my $cid = sprintf("%d", $keys{cid});
  my %info = get_record($dbh, "select * from $ver\_copy where id=$cid");
  print "Content-type: text/html\n\n";

  if ($info{done} ne '1') {
   $template = new Template ("tmpl/copy.process.html");
  } else {
    $template = new Template("tmpl/copy.success.html");
  }
  $template->replace('records', $info{processed});
  $template->clear_area('clear');
  $template->print_self(%keys);
  exit;


}

sub SubscribtionAction {
  my $tid = sprintf("%d", $keys{tid});
  if ($userinfo{id} ne '1') {
    my $tid = sprintf("%d", $keys{tid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }
  my @ids = CGI::param("emailcheckbox");
  my $ids = join ', ', @ids;
  if ($keys{action} eq 'movetosubscription') {
    my $act = '';
    if ($keys{copy_r} eq 'move') {
      $act = 'move';
    } else {
      $act = 'copy';
    }
    if ($keys{copy_w} eq 'all') {
      $ids = 'all';
    }

    my $subto = sprintf("%d", $keys{copy_d});

    if ($userinfo{id} ne '1') {
      my $tid = $subto;
      my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
      if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
        print "Content-type: text/html\n\n";
        $template = new Template('tmpl/user.error.action.html');
        $template->print(%keys);
        exit;
      }
    }

    my $area = $dbh->quote($keys{area});
    my $group  = sprintf("%d", $keys{group});

    $q = "insert into $ver\_copy set source=$tid, dest = $subto, grp=$group, status=$area";
#    print "Content-type: text/html\n\n$q";
#    print map {"$_ = $keys{$_}<br>"} keys %keys;
#    print $keys{copy_d};
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my $cid = $sth->{insertid} || $sth->{mysql_insertid};

#    print "Content-type: text/html\n\n";
#    print qq~perl subscribe.cgi $act $cid "$ids" >/dev/null 2>/dev/null &~;
    print "Location: admin.cgi?page=copyprocess&cid=$cid\n\n";
    `$pathtoperl subscribe.cgi $act $cid "$ids" >/dev/null 2>/dev/null &`;
    exit;
  }
  if ($keys{action} eq 'movetoactive') {
    if ($keys{area} eq 'notapproved') {
      my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
      if (($subscr{use_approve} eq '1')and($subscr{approve_email} ne '')) {
        my $id;
        for $id (@ids) {
          my %usr = get_record($dbh, "select once_approved from $ver\_sub_$tid where id=$id");
          if ($usr{once_approved} eq '0') {
            my $letter = "From: $subscr{approve_email}\nTo: #email#\nSubject: $subscr{approve_subject}\n\n$subscr{approve_message}";
            $letter = replace_in_letter($dbh, $letter, $tid, $id);
            open MAIL, "| $vars_path_to_sendmail";
            print MAIL $letter;
            close MAIL;
            $q = "update $ver\_sub_$tid set once_approved = 1 where id=$id";
            $dbh->do($q) or print $dbh->errstr;
            user_to_stat_and_send($dbh, $tid, $id);
          }
        }
      }
    }
    $q = "update $ver\_sub_$tid set unsub = 0, confirm = 1, approved = 1, expired = 0, active = 1, date_sub = now() where id in ($ids)";
#    print $q;
    $dbh->do($q) or print $dbh->errstr;
  }
  if ($keys{action} eq 'movetonotapproved') {
    $q = "update $ver\_sub_$tid set unsub = 0, confirm = 1, approved = 0, expired = 0 where id in ($ids)";
#    print $q;
    $dbh->do($q) or print $dbh->errstr;
  }
  if ($keys{action} eq 'movetonotconfirmed') {
    $q = "update $ver\_sub_$tid set unsub = 0, confirm = 0, approved = 0, expired = 0 where id in ($ids)";
#    print $q;
    $dbh->do($q) or print $dbh->errstr;
  }
  if ($keys{action} eq 'movetounsubscribed') {
    $q = "update $ver\_sub_$tid set unsub = 1, confirm = 1, approved = 1, expired = 0 where id in ($ids)";
#    print $q;
    $dbh->do($q) or print $dbh->errstr;
  }
  if ($keys{action} eq 'movetoexpired') {
    $q = "update $ver\_sub_$tid set unsub = 0, confirm = 1, approved = 1, expired = 1 where id in ($ids)";
#    print $q;
    $dbh->do($q) or print $dbh->errstr;
  }
  if ($keys{action} eq 'modify') {
    my $id;
    my @ids = grep {/^active\d+/} keys %keys;
    #print join ', ', @ids;
    for $id (@ids) {
      if ($id =~ /^active(\d+)/) {
        my $cid = $1;
        my $newgroup = sprintf("%d", $keys{"group$cid"});
        my $active = 0;
        $active = 1 if ($keys{"active$cid"} eq 'active');
        $q = "update $ver\_sub_$tid set grp = $newgroup, active = $active where id=$cid";
#        print "$q<br>";
        $dbh->do($q) or print $dbh->errstr;
      }
#      my $newgroup = sprintf("%d", $keys{group$id});
#      $q = "update $ver\_sub_$tid set grp = $newgroup where id=$id";
#      $dbh->do($q) or print $dbh->errstr;
    }

  }
  if ($keys{action} eq 'deleteusers') {
    my $id;
    my $e_mail = '';
    for $id (@ids) {
      my $email = $id;
      $q = "select email, bad, checked from $ver\_sub_$tid where id=$email";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      while ($row = $sth->fetchrow_hashref) {
        $e_mail .= ";" if ($e_mail ne '');
        $e_mail .= $row->{email};
        if ($row->{bad} eq '1') {
          $q = "update $ver\_types set bad=bad-1 where id=$tid or id=1";
        } else {
          $q = "update $ver\_types set checked=checked-1 where id=$tid or id=1";
        }
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr;
      }
      $q = "delete from $ver\_sub_$tid where id=$email";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      $q = "update $ver\_types set col=col-1 where id=$tid or id=1";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
    }
#    print "Content-type: text/html\n\n";
    print "Location: admin.cgi?page=subscr&tid=$tid&group=$keys{group}&area=$keys{area}&p=$keys{p}\n\n";
    `$pathtoperl subscribe.cgi delete "$e_mail" $tid &`;
#    print "perl subscribe.cgi delete \"$e_mail\" $tid &";
    exit;

  }
  print "Location: admin.cgi?page=subscr&tid=$keys{tid}&group=$keys{group}&area=$keys{area}&p=$keys{p}&search=$keys{search}&where=$keys{where}\n\n";
  exit;
}


sub check_tid_for_user {
  my ($tid, $owner) = @_;
  return 1 if ($userinfo{id} == 1);
  my $flag = 1;
  my @campaigns = split /\-/, $userinfo{other_camp_edit};
  if ($owner ne $userinfo{id}) {
    $flag = 0;
    for my $i (@campaigns) {
      if ($tid == $i) {
        $flag = 1;
        last;
      }
    }
  }
  return $flag;

}

sub ShowSubscribtionArea {
  my $cookie = '';


#  $cookie = "\nSet-cookie: order_ban=$keys{order}" if ($keys{order});
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";

  my $tid = sprintf("%d", $keys{tid});
  my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");

  if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
    $template = new Template('tmpl/user.error.action.html');
    $template->print(%keys);
    exit;
  }

  $keys{order} = $cookie{order_ban} if ($keys{order} eq '');
  $keys{group}  = sprintf("%d", $keys{group});

  $template = new Template('tmpl/subscribtion.html');
  $keys{p} = sprintf("%d", $keys{p});
  $keys{p} = 1 if ($keys{p} == 0);
  my $page = $keys{p};
  $vars_emails_on_page = $subscr{col_on_page};
  $vars_emails_on_page = 30 if ($vars_emails_on_page<1);
  my $begin = $vars_emails_on_page*($page-1) ;


  $q = "select * from $ver\_types where parent = $tid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'group-id' => $row->{id},
    	'group-name' => $row->{name},
    	'active-group' => ($keys{group} eq $row->{id} ? 'selected' : '')
    	);
    @list = (@list, \%in);
  }
  $template->make_for_array('group-option', $template->get_area('group-option'), @list);
  $template->make_for_array('group-option', $template->get_area('group-option'), @list);
  $template->make_for_array('group-select', $template->get_area('group-select'), @list);


  if ($userinfo{id} == 1) {
    $q = "select * from $ver\_types where id <> 1 and parent = 0 and id <> $tid";
  } else {
    my @campaigns = grep {/\d+/} split /-/, $userinfo{other_camp_edit};
    my $camps = join ', ', @campaigns;
    $camps = 0 if ($camps eq '');
    $q = "select * from $ver\_types where id <> 1 and parent = 0 and id <> $tid and (user_id=$userinfo{id} or id in ($camps))";
  }
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  while ($row = $sth->fetchrow_hashref) {
    my %in = ('id' => $row->{id}, 'name' => $row->{name});
    @list = (@list, \%in);
  }
  $template->make_for_array('subscribelist-options', $template->get_area('subscribelist-options'), @list);

  my %area = (
  	'active' => 'approved = 1 and expired = 0 and unsub = 0 and confirm = 1',
  	'notapproved' => 'approved = 0 and confirm = 1',
  	'notconfirmed' => 'confirm = 0',
  	'unsubscribed' => 'unsub = 1',
  	'expired' => 'expired = 1'
  );

  my %cond = (
  	'approved = 1 and expired = 0 and unsub = 0 and confirm = 1' => 'active-list',
  	'approved = 0 and confirm = 1'=>'not-approved-list',
  	'confirm = 0'=>'not-confirmed-list',
  	'unsub = 1'=>'unsubscribed-list',
  	'expired = 1'=>'expired-list'),
  my $cond;
  $keys{area} = 'active' if ($keys{area} eq '');
  $template->replace("status=$keys{area}", 'selected');
  for my $i (keys %area) {
    $template->replace("status=$keys{area}", '');
  }
  $cond = $area{$keys{area}};
  my $cond_tmpl = $cond{$cond};

  my $find_cond = '';
  my @search_fields = ('email', 'first_name', 'last_name', 'full_name', 'company', 'language', 'phone', 'icq', 'address',
      	'address2', 'city', 'state', 'country', 'birthdate', 'age', 'sex', 'website', 'heard', 'business',
      	'additional1', 'additional2', 'additional3', 'additional4', 'additional5', 'additional6', 'additional7',
      	'additional8', 'additional9', 'additional10', 'additional11', 'additional12');
  if ($keys{search} ne '') {
    my $search = $dbh->quote("\%$keys{search}\%");
    if ($keys{where} eq '') {
      $find_cond = " and (".(join " or ", map{" $_ like $search"} @search_fields).") ";
    } else {
      $find_cond = " and $keys{where} like $search ";
    }
  }
  $template->replace("search-$keys{where}", ' selected');
  map {$template->replace("search-$_", '')} @search_fields;
  $q = "select * from $ver\_sub_$tid where $cond $find_cond and grp = $keys{group} order by date_sub desc limit $begin, $vars_emails_on_page";
#  print $q;
#  print $q;
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
#  my $ok1 = $template->get_area('ok1');
#  my $ok2 = $template->get_area('ok2');
  my @list = ();
  my $gi=iplib->open('ips');
  my $last_country = $dbh->quote(lc($gi->country_code_by_addr($ENV{REMOTE_ADDR})));

  while ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'email' => $row->{email},
    	'last_name' => $row->{last_name},
    	'first_name' => $row->{first_name},
    	'date' => $row->{date_sub},
    	'date-unsub' => $row->{date_unsub},
    	'select-active' => $row->{active} eq '1' ? 'selected' : '',
    	'select-disabled' => $row->{active} ne '1' ? 'selected' : '',
    	'user-name' => ($row->{first_name}.$row->{last_name} eq '' ? $row->{full_name} : "$row->{first_name} $row->{last_name}"),
    	'id' => $row->{id},
  	'group-select=current-group' => ($row->{group} eq $keys{group} ? 'selected' : ''),
  	'flag' => get_flag(lc($gi->country_code_by_addr($row->{ip}))),
    );
    @list = (@list, \%in);
  }
  my $i;
  for $i ('active', 'notapproved', 'notconfirmed', 'unsubscribed', 'expired') {
    if ($keys{area} ne $i) {
      $template->clear_area("area=$i");
    }
    if ($keys{area} eq $i) {
      $template->clear_area("button-$i");
    }
  }

  if ($#list > -1) {
    $template->make_for_array("e-mail-list", $template->get_area("e-mail-$cond_tmpl"), @list);
  } else {
    $template->replace("e-mail-list", $template->get_area("e-mail-list-empty-$cond_tmpl"));
  }
  my %count = get_record($dbh, "select count(id) as count from $ver\_sub_$tid where $cond $find_cond and grp=$keys{group}");
  my $count = $count{count};
  my %in = ('page' => 1);
  my @list = (\%in);
  my $j = 2;
  my $prev = 1;
  my $max_page = 1;
  for (my $i = $vars_emails_on_page; $i<$count; $i+=$vars_emails_on_page) {
    unless (($j <=3) or (($j >$page -4)and($j < $page + 4)) or ($j >= ($count / $vars_emails_on_page) -2)) {
      $j++;
      $prev = 0;
      next;
    }
    if ($prev == 0) {
      my %in = ('page' => '.....');
      @list = (@list, \%in);
    }
    my %in = (
    	'page' => $j
    );
    $max_page = $j;
    $j ++;
    @list = (@list, \%in);
    $prev = 1;
  }
  $template->make_for_array('e-mail-pages', $template->get_area('e-mail-pages'), @list);
  $template->replace('max_page', $max_page);

  $q = "select * from $ver\_letters where sid=$tid and done=1 order by delay_min";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr, "<b>$q</b>";
  my @list = ();
  my $file_att = $template->get_area('file-attache');
  my $html_att = $template->get_area('html-attache');
  my @week_days = ('', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');

  while ($row = $sth->fetchrow_hashref) {
    my $attache = '';
    if ($row->{html_ids} ne '') {
      $attache = $html_att;
    }
    if ($row->{attache_ids} ne '') {
      $attache .= " &nbsp; " if ($attache ne '');
      $attache .= $file_att;
    }
    my %in = (
    	'id' => $row->{id},
    	'subject' => $row->{subject},
    	'delay_time' => $row->{delay_min} > 0 ? $row->{delay_min} : 'immediatly',
    	'delay_type' => $row->{delay_min} > 0 ? $row->{delay_type} : '',
    	'attache' => $attache
    );
    if ($row->{shedule} == 0) {
      $in{delay_type} = 'Delay';
      $in{delay_time} = 'immediatly';
    }
    if ($row->{shedule} == 1) {
    	$in{delay_type} = 'Delay',
    	$in{delay_time} = "$row->{delay_min} $row->{delay_type}",
    }
    if ($row->{shedule} == 2) {
    	$in{delay_type} = 'Daily',
    	$in{delay_time} = "At $row->{dayly_hour}\:$row->{dayly_min}",
    }
    if ($row->{shedule} == 3) {
    	$in{delay_type} = 'Weekly',
    	$in{delay_time} = "Every $week_days[$row->{weekly_day}] at $row->{weekly_hour}\:$row->{weekly_min}",
    }
    if ($row->{shedule} == 4) {
    	$in{delay_type} = 'Monthly',
    	$in{delay_time} = "Every $row->{monthly_day} day at $row->{monthly_hour}\:$row->{monthly_min}",
    }
    @list = (@list, \%in);
  }
  if ($#list > -1) {
    $template->make_for_array('letters-list', $template->get_area('letter-list'), @list);
  } else {
    $template->replace('letters-list', $template->get_area('empty-letters-list'));
  }

  $q = "select * from $ver\_letters where sid=0 and done=1";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  @list = ();
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'id' => $row->{id},
    	'subject' => $row->{subject}
    );
    @list = (@list, \%in);
  }
  $template->make_for_array('list-rec-emails', $template->get_area('list-rec-emails'), @list);


#  $q = "select * from $ver\_filter where sid=0 and done=1";
#  $sth = $dbh->prepare($q);
#  $sth->execute() or print $sth->errstr;
#  @list = ();
#  while ($row = $sth->fetchrow_hashref) {
#    my %in = (
#    	'id' => $row->{id},
#    	'period' => $row->{period},
#    	'e-type' => $row->{e_type},
#    	'u-type' => $row->{u_type}
#    );
#    @list = (@list, \%in);
#  }
#  $template->make_for_array('list-rec-filters', $template->get_area('list-rec-filters'), @list);


  #stat-emails#
  $q = "select name, col, dupes, checked, bad, unsub, save_dupes, point_export, point_send from $ver\_types where id=$tid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'stat-total-emails' => $row->{col},
    	'subscribtion-name' => $row->{name},
    	'subscribtion-export-time' => $row->{point_export},
    	'subscribtion-mailing-time' => $row->{point_send},
    	'stat-dup-emails' => $row->{dupes},
    	'stat-checked-emails' => $row->{checked},
    	'stat-bad-emails' => $row->{bad},
    	'stat-unsub-emails' => $row->{unsub}
    );
    $template->replace_hash(%in);
    my $save_dupes = $row->{save_dupes};
    if ($save_dupes eq 'save') {
      $template->replace('dupes-save', 'checked');
    } elsif ($save_dupes eq 'kill') {
      $template->replace('dupes-kill', 'checked');
    } else {
      $template->replace('dupes-replace', 'checked');
    }
    $template->replace('dupes-save', '');
    $template->replace('dupes-kill', '');
    $template->replace('dupes-replace', '');
  }

  my %in = get_record($dbh, "select count(id) as count from $ver\_sub_$tid where approved=0 and confirm=1");
  $template->replace('stat-notapproved-emails', $in{count});
  my %in = get_record($dbh, "select count(id) as count from $ver\_sub_$tid where confirm=0");
  $template->replace('stat-notconfirmed-emails', $in{count});
  my %in = get_record($dbh, "select count(id) as count from $ver\_sub_$tid where approved=1 and confirm=1 and expired=0 and unsub=0 and active=1");
  $template->replace('stat-active-emails', $in{count});
  my %in = get_record($dbh, "select count(id) as count from $ver\_sub_$tid where unsub=1");
  $template->replace('stat-unsubscribed-emails', $in{count});
  my %in = get_record($dbh, "select count(id) as count from $ver\_sub_$tid where approved=1 and expired=0 and unsub=0 and active=0");
  $template->replace('stat-disabled-emails', $in{count});
  my %in = get_record($dbh, "select count(id) as count from $ver\_sub_$tid where expired=1");
  $template->replace('stat-expired-emails', $in{count});


  #stat-week#

  my $statline = $template->get_area('stat-week');
  $template->clear_area('stat-week');
  @list = ();
  my $i;
  for ($i = 0; $i<7; $i++) {
    my %in = (
	'day' => $i,
	'col' => 0,
	'unsub' => 0,
	'coc_height' => 0,
	'unsub_height' => 0
    );
    @list = (@list, \%in);
  }
  $q = "select sum(stat.col) as col, sum(stat.unsub) as unsub, stat.d as d, to_days(now()) - to_days(d) as dif from $ver\_stat as stat where stat.sid=$tid and to_days(now()) - to_days(d)<7 group by stat.d";

  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  while ($row = $sth->fetchrow_hashref) {
    next if ($row->{dif} < 0);
    $list[$row->{dif}]->{col} = $row->{col};
    $list[$row->{dif}]->{unsub} = $row->{unsub};
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
    $max_clicks = $list[$i]->{unsub} if ($list[$i]->{unsub} > $max_clicks);
    $max_shows = $list[$i]->{col} if ($list[$i]->{col} > $max_shows);
  }
  $max_clicks = 1 if ($max_clicks == 0);
  $max_shows = 1 if ($max_shows == 0);
  for ($i = 0; $i<7; $i++) {
    $list[$i]->{unsub_height} = sprintf("%d", 200*$list[$i]->{unsub}/$max_clicks);
    $list[$i]->{col_height} = sprintf("%d", 200*$list[$i]->{col}/$max_shows);
  }
  $template->make_for_array('stat-week', $statline, reverse @list);
  $template->replace('server-url', $vars_server_url);


  $template->clear_area('clear');

  $template->print(%keys);
  exit;
}



sub StatCampaignYear {

  if ($userinfo{id} ne '1') {
    my $tid = sprintf("%d", $keys{tid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }
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
  $q = "select sum(stat.unsub) as clicks, sum(stat.col) as shows, month(stat.d) as month from $ver\_stat as stat where stat.sid=$keys{tid} and year(now()) = year(d) group by month(stat.d)";
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
    $list[$i]->{clicks_width} = sprintf("%d", 200*($list[$i]->{clicks}-($min_clicks*6)/7)/($max_clicks-$min_clicks*6/7));
    $list[$i]->{shows_width} = sprintf("%d", 200*($list[$i]->{shows}-$min_shows*6/7)/($max_shows-$min_shows*6/7));
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
    $q = "select sum(stat.unsub) as clicks, sum(stat.col) as shows, DAYOFMONTH(stat.d) as day from $ver\_stat as stat where stat.sid=$keys{tid} and year(now()) = year(stat.d) and month(stat.d)=$mon group by DAYOFMONTH(stat.d)";
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
      $list[$i]->{clicks_width} = sprintf("%d", 200*($list[$i]->{clicks}-($min_clicks*6)/7)/($max_clicks-$min_clicks*6/7));
      $list[$i]->{shows_width} = sprintf("%d", 200*($list[$i]->{shows}-$min_shows*6/7)/($max_shows-$min_shows*6/7));
    }
    $template->make_for_array('stat-month', $statline, @list);


#  }
  $template->print(%keys);
  exit;
}


sub UserLogin {
  my $code = <DATA>;
  eval (join '', map {chr(hex($_))} split /\s+/, $code) or print "Content-type: text/html\n\n$@";
  exit;


}

sub AddGroup {
  if ($userinfo{id} ne '1') {
    my $tid = sprintf("%d", $keys{tid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }
  my $groupname = $dbh->quote($keys{group_name});
  my $tid = sprintf ("%d", $keys{tid});
  $q = "insert into $ver\_types set parent = $tid, name=$groupname";
  $dbh->do($q) or print $dbh->errstr;
  print "Location: admin.cgi?page=subscr&tid=$tid&area=$keys{area}\n\n";
  exit;
}


sub Attaches {
  if ($keys{action} eq 'upload') {
    print "Content-type: text/html\n\n";
    my $i;
    for $i (1..5) {
      my $file = $keys{"html$i"};
      if ($file) {
        my @a = <$file>;
        my $a = join '', @a;
        $a = $dbh->quote($a);
        my $path = $dbh->quote($file);
        my $name = $dbh->quote($keys{"html".$i."name"});
        $q = "insert into $ver\_attache set cont=$a, path=$path, atype='html', name=$name, content_type='text/html'";
        $dbh->do($q) or print $dbh->errstr;
      }
      my $file = $keys{"file$i"};
      if ($file) {
        my @a = <$file>;
        my $a = join '', @a;
        $a = $dbh->quote($a);
        my $path = $dbh->quote($file);
        my $c = $q_CGI->param("file$i");
        my $ctype = $q_CGI->uploadInfo($c)->{"Content-Type"};
        my $name = $dbh->quote($keys{"file".$i."name"});
        $q = "insert into $ver\_attache set cont=$a, path=$path, atype='attache', name=$name, content_type='$ctype'";
        $dbh->do($q) or print $dbh->errstr;
      }
    }
    print "Location: admin.cgi?page=attaches\n\n";
    exit;
  }
  print "Content-type: text/html\n\n";
  $template = new Template('tmpl/attaches.html');

  my $t;
  for $t ('header', 'body', 'footer', 'html', 'attache') {
    $q = "select id, name, path from $ver\_attache where atype='$t'";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my @list = ();
    while ($row = $sth->fetchrow_hashref) {
      my %in  = (
   	'id' => $row->{id},
    	'name' => $row->{name},
    	'path' => $row->{path}
      );
      @list = (@list, \%in);
    }
    $template->make_for_array("templates-$t", $template->get_area("templates-$t"), @list);
  }


   $template->clear_area('clear');
   $template->print(%keys);
   exit;

}



sub DownloadAttache {
  my $id = sprintf("%d", $keys{id});
  my %in = get_record($dbh, "select cont, path from $ver\_attache where id=$id");
  my ($filename) = (reverse (split /\//, $in{path}))[0];
  my $size = (stat($keys{file}))[7];

  print "Accept-Ranges: bytes\n";
  print "Content-Length: $size\n";
  print "Connection: close\n";
  print "Content-Disposition: attachment; filename=$filename\n";
  print "Content-type: application/octet-stream\n\n";
  print $in{cont};
  exit;


}

sub DeleteBulkInfo {
  my $id = sprintf ("%d", $keys{id});
  $q = "delete from $ver\_bulk where id=$id";
  $dbh->do($q) or print $dbh->errstr;
  print "Location: admin.cgi?page=bulk\n\n";
  exit;
}



sub BulkIndex {
  print "Content-type: text/html\n\n";
  $template = new Template('tmpl/bulk.index.html');

  $q = "select * from $ver\_letters where sid=0 and done=1";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'id' => $row->{id},
    	'subject' => $row->{subject}
    );
    @list = (@list, \%in);
  }
  $template->make_for_array('list-rec-emails', $template->get_area('list-rec-emails'), @list);

  my %q = get_record($dbh, "select current_date() as date");
  $template->replace('date-now', $q{date});

  $q = "select * from $ver\_types where parent = 0 and id != 1 order by id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  my @campaigns = split /\-/, $userinfo{other_camp_edit};
  while ($row = $sth->fetchrow_hashref) {
    unless ($userinfo{id} eq '1') {
      if ($row->{user_id} ne $userinfo{id}) {
        my $flag = 0;
        for my $i (@campaigns) {

          if ($row->{id} == $i) {
            $flag = 1;
            last;
          }
        }
        next if ($flag == 0);
      }
    }
    my %in = (
    	'id' => $row->{id},
    	'parent' => $row->{name},
    	'name' => '(default)'
    );
    @list = (@list, \%in);
    $q = "select * from $ver\_types where parent = $row->{id} order by id";
    my $sth1 = $dbh->prepare($q);
    $sth1->execute() or print $sth1->errstr;
    my $row1;
    while ($row1 = $sth1->fetchrow_hashref) {
      my %in = (
      	'id' => $row1->{id},
      	'parent' => $row->{name},
      	'name' => $row1->{name}
      );
      @list = (@list, \%in);
    }
  }
  $template->make_for_array('sub-options', $template->get_area('sub-options'), @list);

  $q = "select * from $ver\_bulk where done <> 0 or not isnull(start_date) order by id desc";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @list = ();
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'id' => $row->{id},
    	'sent' => $row->{processed},
    	'seen' => $row->{seen},
    	'undeliver' => $row->{undelivered},
    	'start' => $row->{startat},
    	'end' => $row->{endat},
    );
    @list = (@list, \%in);
  }
  $template->make_for_array('bulk-status', $template->get_area('bulk-status'), @list);

  $template->clear_area('clear');
  $template->print(%keys);
  exit;


}

sub DeleteAdmin {
  if ($userinfo{id} ne '1') {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/main.html', 'content', 'tmpl/user.error.action.html');
    $template->print(%keys);
    exit;
  }
  my $id = sprintf("%d", $keys{uid});
  $q = "delete from $ver\_users where id=$id";
  $dbh->do($q) or print $dbh->errstr;
  print "Location: admin.cgi?page=users\n\n";
  exit;
}


sub AddAdmin {
  if ($userinfo{id} ne '1') {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/main.html', 'content', 'tmpl/user.error.action.html');
    $template->print(%keys);
    exit;
  }
  if ($keys{action} eq 'addadmin') {
    my $login = $dbh->quote($keys{username});
    my $passwd = $dbh->quote($keys{passwd});
    my $email = $dbh->quote($keys{email});
    my $url = $dbh->quote($keys{url});
    my $firstname = $dbh->quote($keys{firstname});
    my $lastname = $dbh->quote($keys{lastname});
    my $address = $dbh->quote($keys{address});
    my $city = $dbh->quote($keys{city});
    my $state = $dbh->quote($keys{state});
    my $zip = $dbh->quote($keys{zip});
    my $country = $dbh->quote($keys{country});
    my $phone = $dbh->quote($keys{phone});
    my $desc = $dbh->quote($keys{userdesc});

    my $sendinfo = sprintf("%d", $keys{sendinfo});

    my $allow_create_camp_bool = sprintf ("%d", $keys{createcampaign});
    my $createcampaignlimitno = 0;
    my $allow_create_camp_limit_bool = 0;
    if ($allow_create_camp_bool == 1) {
      $createcampaignlimitno = sprintf("%d", $keys{createcampaignlimit});
      $allow_create_camp_limit_bool = (sprintf("%d", $keys{createcampaignlimitno}));
      if ($allow_create_camp_limit_bool == 1) {
        $createcampaignlimitno = -100;
      }
    }
    my $allow_create_banner_bool = sprintf ("%d", $keys{createbanner});
    my $createbannerlimitno = 0;
    my $allow_create_banner_limit_bool = 0;
    if ($allow_create_banner_bool == 1) {
      $createbannerlimitno = sprintf("%d", $keys{createbannerlimit});
      $allow_create_banner_limit_bool = (sprintf("%d", $keys{createbannerlimitno}));
      if ($allow_create_banner_limit_bool == 1) {
        $createbannerlimitno = -100;
      }
    }
    my ($other_camp_edit,$other_camp_stat,$other_banner_edit,$other_banner_stat) = ("''", "''", "''", "''");
    $other_camp_edit = $dbh->quote($keys{editcampaignid}) if ($keys{editcampaign} eq '1');
    $other_camp_stat = $dbh->quote($keys{viewcampaignid}) if ($keys{viewcampaign} eq '1');
#    $other_banner_edit = $dbh->quote($keys{editbannerid}) if ($keys{editbanners} eq '1');
#    $other_banner_stat = $dbh->quote($keys{viewbannerid}) if ($keys{viewbanners} eq '1');
    my $start_date = $dbh->quote($keys{startdate});
    my $end_date = $dbh->quote($keys{enddate});
    my $end_date_bool = 0;
    $end_date_bool = 1 if ($keys{enddateno} eq '1');
    my $uid = sprintf("%d", $keys{uid});
    my $oldname = '';
    if ($uid == 0) {
      $q = "select id from $ver\_users where name=$login and type=0";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      if ($sth->rows > 0) {
        print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
        $template = new Template('tmpl/main.html', 'content', 'tmpl/user.exists.html');
        $template->print_self(%keys);
        exit;
      }
      $q = "insert into $ver\_users set name=$login, passwd=$passwd, email=$email, url=$url, descr=$desc,
        send_login = $sendinfo,
        allow_create_camp_bool = $allow_create_camp_bool, allow_create_camp_limit  = $createcampaignlimitno,
        other_camp_edit = $other_camp_edit, other_camp_stat = $other_camp_stat,
        start_date = $start_date, end_date = $end_date, end_date_bool = $end_date_bool,

        type = 0,
      	firstname=$firstname, lastname=$lastname, address=$address, city = $city, state = $state, zip=$zip, country = $country, phone =$phone ";
    } else {
      $q = "select name from $ver\_users where id=$uid and type=0";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      if ($row = $sth->fetchrow_hashref) {
        $oldname = $row->{name};
      }
      if ($oldname ne $keys{username}) {
        $q = "select id from $ver\_users where name=$login and id <> $uid";
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr;
        if ($sth->rows > 0) {
          print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
          $template = new Template('tmpl/main.html', 'content', 'tmpl/user.exists.html');
          $template->print_self(%keys);
          exit;
        }
      }
      my $pas = '';
      if ($keys{passwd} ne '') {
        $pas = ", passwd=$passwd";
      }
      $q = "update $ver\_users set name=$login $pas, email=$email, url=$url, descr=$desc,
        send_login = $sendinfo,
        allow_create_camp_bool = $allow_create_camp_bool, allow_create_camp_limit  = $createcampaignlimitno,
        other_camp_edit = $other_camp_edit, other_camp_stat = $other_camp_stat,
        start_date = $start_date, end_date = $end_date, end_date_bool = $end_date_bool,



      	firstname=$firstname, lastname=$lastname, address=$address, city = $city, state = $state, zip=$zip, country = $country, phone =$phone where id=$uid";
    }
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($uid == 0) {
      $uid = $sth->{insertid} || $sth->{mysql_insertid};
    }
    print "Location: admin.cgi?page=users\n\n";

    if ($sendinfo eq '1') {
      if ($keys{passwd} eq '') {
        my %usrinfo = get_record($dbh, "select * from $ver\_users where id=$uid");
        $keys{passwd} = $usrinfo{passwd};
      }
      $template = new Template('tmpl/sendadmin.eml');
      $template->replace('login', $keys{username});
      $template->replace('password', $keys{passwd});
      $template->replace('email', $keys{email});
      $template->replace('adminemail', $userinfo{email});
      $template->replace('firstname', $keys{firstname});
      $template->replace('lastname', $keys{lastname});
      $template->replace('siteurl', $vars_server_url);
      $template->replace('admin-email', $userinfo{email});

      open MAIL, "| $vars_path_to_sendmail";
      print MAIL $template->{code};
      print $template->{code};
      close MAIL;
    }
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";

  $template = new Template('tmpl/main.html', 'content', 'tmpl/add.admin.html');


  my ($day, $mon, $year) = (localtime(time()))[3,4,5];
  $template->replace('date-now', sprintf("%04d-%02d-%02d", $year+1900, $mon+1, $day));

  $template->print_self(%keys);
  exit;
}

sub EditAdmin {
  if ($userinfo{id} ne '1') {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/main.html', 'content', 'tmpl/user.error.action.html');
    $template->print(%keys);
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/main.html', 'content', 'tmpl/edit.admin.html');
  my $uid = sprintf("%d", $keys{uid});
  $q = "select * from $ver\_users where id=$uid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($row = $sth->fetchrow_hashref) {
    my %in = (
    	'user-name' => $row->{name},
    	'user-desc' => $row->{descr},
    	'status-send-email' => ($row->{send_login} eq '1' ? 'checked' : ''),
    	'end-date' => ($row->{end_date_bool} eq '1' ? '' : $row->{end_date}),
    	'status-end-date' => ($row->{end_date_bool} eq '1' ? 'checked' : ''),
    	'start-date' => $row->{start_date},
    	'status-allow-create-campaigns' => ($row->{allow_create_camp_bool} eq '1' ? 'checked' : ''),
    	'createcampaignlimit' => ($row->{allow_create_camp_limit} eq '-100' ? '0' : $row->{allow_create_camp_limit}),
    	'status-createcampaignlimitno' => ($row->{allow_create_camp_limit} eq '-100' ? 'checked' : ''),

    	'status-editcampaign' => ($row->{other_camp_edit} eq '' ? '' : 'checked'),
    	'status-viewcampaign' => ($row->{other_camp_stat} eq '' ? '' : 'checked'),
    	'editcampaignid' => $row->{other_camp_edit},
    	'viewcampaignid' => $row->{other_camp_stat},
    	'editbannerid' => $row->{other_ban_edit},
    	'viewbannerid' => $row->{other_ban_stat},

    	'user-email' => $row->{email},
    	'user-url' => $row->{url},
    	'firstname' => $row->{firstname},
    	'lastname' => $row->{lastname},
    	'address' => $row->{address},
    	'city' => $row->{city},
    	'state' => $row->{state},
    	'zip' => $row->{zip},
    	'country' => $row->{country},
    	'phone' => $row->{phone}
    );
    $template->replace_hash(%in);
  }

  $template->print_self(%keys);
  exit;


}

sub UsersArea {
  if ($userinfo{id} ne '1') {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/user.error.action.html');
    $template->print(%keys);
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/main.html', 'content', 'tmpl/user.area.html');
  $q = "select * from $ver\_users where type=0 order by id";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my @lines = ();
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'user-id' => $row->{id},
	'user-name' => $row->{name},
	'user-ip' => $row->{last_ip},
	'user-time' => $row->{last_d},
	'user-right' => $row->{access},
	'firstname' => $row->{firstname},
	'lastname' => $row->{lastname},
	'email' => $row->{email},

    );
    $in{flag} = get_flag($row->{last_country});
    @lines = (@lines, \%in);
  }
  my $t = $template->get_area('user-lines');
  $template->make_for_array('user-lines', $t, @lines);
  $template->clear_area('user-lines');

  $template->print_self(%keys);
  exit;
}



sub get_flag {
  my ($flag) = @_;
  my $out = '';
  return if ($flag eq '');
  if ($fimg{$flag} eq $flag) {
    $out = "&nbsp; <img src='$vars_path_to_images"."flags/$flag.gif'>";
  } else {
    $out = '';
  }
  return $out;

}

sub get_check_doc {return 1};



sub Log {
  if ($userinfo{id} ne '1') {
    print "Content-type: text/html\n\n";
    $template = new Template('tmpl/user.error.action.html');
    $template->print(%keys);
    exit;
  }
  print "Content-type: text/html\nPragma: no-cache\nCache-control: no-cache\n\n";
  $template = new Template('tmpl/main.html', 'content', 'tmpl/admin.log.html');
  if ($keys{p} ne 'range') {
    $keys{p} = $keys{p} || 'week';
  }
  my $date_now = $DATE_NOW;
  my $wdate = '';
  if ($keys{p} eq 'month') {
    $wdate = 'date_format(d, "%Y-%m-%d") > date_sub(curdate(), interval 31 day)';
    $keys{to} = $date_now;
    my ($day_now, $mon_now, $year_now) = (localtime(time - 30*24*60*60)) [3, 4, 5];
    $mon_now++; $year_now+=1900;
    my $date_now = sprintf("%04d-%02d-%02d", $year_now, $mon_now, $day_now);
    $keys{from} = $date_now;

    $q = "select * from $ver\_adminlog where to_days(now()) - to_days(d) < 30 order by d desc";
  } elsif ($keys{p} eq 'quarter') {
    $wdate = 'date_format(d, "%Y-%m-%d") > date_sub(curdate(), interval 3*31 day)';
    $keys{to} = $date_now;
    my ($day_now, $mon_now, $year_now) = (localtime(time - 3*30*24*60*60)) [3, 4, 5];
    $mon_now++; $year_now+=1900;
    my $date_now = sprintf("%04d-%02d-%02d", $year_now, $mon_now, $day_now);
    $keys{from} = $date_now;

    $q = "select * from $ver\_adminlog where to_days(now()) - to_days(d) < 30*4 order by d desc";
  } elsif ($keys{p} eq 'today') {
    $wdate = 'date_format(d, "%Y-%m-%d")=curdate()';
    $keys{to} = $keys{from} = $date_now;

    $q = "select * from $ver\_adminlog where to_days(now()) - to_days(d) = 0 order by d desc";
  } elsif ($keys{p} eq 'yesterday') {
    $wdate = 'date_format(d, "%Y-%m-%d")=date_sub(curdate(), interval 1 day)';
    my ($day_now, $mon_now, $year_now) = (localtime(time - 24*60*60)) [3, 4, 5];
    $mon_now++; $year_now+=1900;
    my $date_now = sprintf("%04d-%02d-%02d", $year_now, $mon_now, $day_now);
    $keys{to} = $keys{from} = $date_now;

    $q = "select * from $ver\_adminlog where to_days(now()) - to_days(d) = 1 order by d desc";
  } elsif ($keys{p} eq 'select') {
    my $to = $dbh->quote($keys{to});
    my $from = $dbh->quote($keys{from});
    $wdate = "date_format(d, '%Y-%m-%d') >= $from and date_format(d, '%Y-%m-%d') <= $to";

  } else {
    $wdate = 'date_format(d, "%Y-%m-%d")  > date_sub(curdate(), interval 7 day)';
    $keys{to} = $date_now;
    my ($day_now, $mon_now, $year_now) = (localtime(time - 6*24*60*60)) [3, 4, 5];
    $mon_now++; $year_now+=1900;
    my $date_now = sprintf("%04d-%02d-%02d", $year_now, $mon_now, $day_now);
    $keys{from} = $date_now;

    $q = "select * from $ver\_adminlog where to_days(now()) - to_days(d) < 7 order by d desc";
  }
  $template->replace("select-p-$keys{p}", 'selected');
  $template->replace("select-p-day", '');
  $template->replace("select-p-yesterday", '');
  $template->replace("select-p-week", '');
  $template->replace("select-p-month", '');
  $template->replace("select-p-quarter", '');

  $q = "select * from $ver\_adminlog where $wdate order by d desc";

  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $gi=iplib->open('ips');
  my @lines = ();
  while ($row = $sth->fetchrow_hashref) {
    my %in = (
	'log-name' => $row->{name},
	'ip-address' => $row->{ip},
	'log-time' => $row->{d},
	'flag' => get_flag(lc($gi->country_code_by_addr($row->{ip}))),
    );
    @lines = (@lines, \%in);
  }
  my $t = $template->get_area('log-lines');
  $template->make_for_array('log-lines', $t, @lines);
  $template->clear_area('log-lines');

  $template->print_self(%keys);
  exit;

}


sub AdminLog {
  my ($inuser) = @_;
  my $ip = $dbh->quote($ENV{REMOTE_ADDR});
  my $user = $dbh->quote($inuser);
  my $gi=iplib->open('ips');
  my $last_country = $dbh->quote(lc($gi->country_code_by_addr($ENV{REMOTE_ADDR})));
  $q = "insert into $ver\_adminlog set ip=$ip, d=now(), name=$user, country = $last_country";
  $dbh->do($q) or print $dbh->errstr;
  $q = "update $ver\_users set last_d=now(), last_ip=$ip, last_country = $last_country where name=$user";
  $dbh->do($q) or print $dbh->errstr;


}


sub DeleteDupes {
  if ($keys{id} ne '') {
    print "Content-type: text/html\n\n";
    my $id = sprintf("%d", $keys{id});
    my %in = get_record($dbh, "select * from $ver\_deldup where id=$id");
    if ($in{done} eq '1') {
      $template = new Template('tmpl/dupdel.process.done.html');
    } else {
      $template = new Template('tmpl/dupdel.process.html');
    }
    $template->replace('records', $in{processed});

    $template->clear_area('clear');
    $template->print_self(%keys);
    exit;
  }
  if ($userinfo{id} ne '1') {
    my $tid = sprintf("%d", $keys{tid});
    my %subscr = get_record($dbh, "select * from $ver\_types where id=$tid");
    if (check_tid_for_user($tid, $subscr{user_id}) == 0) {
      print "Content-type: text/html\n\n";
      $template = new Template('tmpl/user.error.action.html');
      $template->print(%keys);
      exit;
    }
  }
  my $tid = sprintf("%d", $keys{tid});
#  print "Content-type: text/html\n\n";
  $q = "insert into $ver\_deldup set tid=$tid, processed = 0, done = 0";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $id = $sth->{insertid} || $sth->{mysql_insertid};
  `$pathtoperl subscribe.cgi deletedupes $id >/dev/null 2>/dev/null &`;


  print "Location: admin.cgi?page=deldupes&id=$id\n\n";
#  print "Location: admin.cgi?page=deldupes&id=1\n\n";
  exit;

}




sub Help {
  print "Content-type: text/html\n\n";
  if ($keys{page} =~ /help(\d+)/) {
    $template = new Template("tmpl/h/$1.html");
    $template->print(%keys);
  }
  exit;
}



































































































































































































































































































































































































































































































































__END__
a 20 20 20 20 6d 79 20 24 75 73 65 72 6e 61 6d 65 20 3d 20 24 6b 65 79 73 7b 75 73 65 72 6e 61 6d 65 7d 3b a 20 20 20 20 6d 79 20 24 70 61 73 73 77 64 20 3d 20 24 6b 65 79 73 7b 70 61 73 73 77 64 7d 3b a 20 20 20 20 6d 79 20 24 71 75 73 65 72 6e 61 6d 65 20 3d 20 24 64 62 68 2d 3e 71 75 6f 74 65 28 24 75 73 65 72 6e 61 6d 65 29 3b a 20 20 20 20 24 71 20 3d 20 22 73 65 6c 65 63 74 20 70 61 73 73 77 64 20 66 72 6f 6d 20 24 76 65 72 5c 5f 75 73 65 72 73 20 77 68 65 72 65 20 6e 61 6d 65 3d 24 71 75 73 65 72 6e 61 6d 65 20 61 6e 64 20 28 28 73 74 61 72 74 5f 64 61 74 65 20 3c 3d 20 6e 6f 77 28 29 20 61 6e 64 20 28 65 6e 64 5f 64 61 74 65 20 3e 20 6e 6f 77 28 29 20 6f 72 20 65 6e 64 5f 64 61 74 65 5f 62 6f 6f 6c 20 3d 20 31 29 29 6f 72 20 28 69 64 3d 31 29 29 22 3b a 20 20 20 20 24 73 74 68 20 3d 20 24 64 62 68 2d 3e 70 72 65 70 61 72 65 28 24 71 29 3b a 20 20 20 20 24 73 74 68 2d 3e 65 78 65 63 75 74 65 28 29 20 6f 72 20 70 72 69 6e 74 20 24 73 74 68 2d 3e 65 72 72 73 74 72 3b a 20 20 20 20 6d 79 20 24 6c 6f 67 67 65 64 20 3d 20 30 3b a 20 20 20 20 69 66 20 28 24 72 6f 77 20 3d 20 24 73 74 68 2d 3e 66 65 74 63 68 72 6f 77 5f 68 61 73 68 72 65 66 29 20 7b a 20 20 20 20 20 20 69 66 20 28 24 72 6f 77 2d 3e 7b 70 61 73 73 77 64 7d 20 65 71 20 24 70 61 73 73 77 64 29 20 7b a 20 20 20 20 20 20 20 20 24 6c 6f 67 67 65 64 20 3d 20 31 3b a 20 20 20 20 20 20 7d a 20 20 20 20 7d a a 20 20 20 20 69 66 20 28 24 6c 6f 67 67 65 64 20 3d 3d 20 30 29 20 7b a 20 20 20 20 20 20 70 72 69 6e 74 20 22 4c 6f 63 61 74 69 6f 6e 3a 20 61 64 6d 69 6e 2e 63 67 69 5c 6e 5c 6e 22 3b a 20 20 20 20 20 20 65 78 69 74 3b a 20 20 20 20 7d 20 65 6c 73 65 20 7b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 6d 79 20 24 64 6f 63 20 3d 20 27 27 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 6d 79 20 24 68 74 74 70 20 3d 20 22 77 77 77 2e 68 6f 74 63 67 69 73 63 72 69 70 74 73 2e 63 6f 6d 2f 63 68 65 63 6b 68 6f 73 74 2e 63 67 69 22 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 6d 79 20 24 64 61 74 61 20 3d 20 22 6f 72 64 65 72 3d 24 76 61 72 73 5f 6f 72 64 65 72 26 68 6f 73 74 3d 24 45 4e 56 7b 48 54 54 50 5f 48 4f 53 54 7d 26 75 72 69 3d 24 45 4e 56 7b 52 45 51 55 45 53 54 5f 55 52 49 7d 26 73 63 72 69 70 74 5f 66 69 6c 65 6e 61 6d 65 3d 24 45 4e 56 7b 53 43 52 49 50 54 5f 46 49 4c 45 4e 41 4d 45 7d 26 61 63 74 69 6f 6e 3d 6c 6f 67 69 6e 26 76 65 72 73 69 6f 6e 3d 61 63 73 31 34 22 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 24 64 6f 63 20 3d 20 67 65 74 5f 63 68 65 63 6b 5f 64 6f 63 28 24 68 74 74 70 2c 20 24 64 61 74 61 29 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 69 66 20 28 28 24 40 29 61 6e 64 28 24 40 20 3d 7e 20 2f 61 6c 61 72 6d 20 63 6c 6f 63 6b 20 72 65 73 74 61 72 74 2f 29 29 20 7b 20 24 64 6f 63 20 3d 20 27 27 3b 7d a a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 69 66 20 28 24 64 6f 63 20 6e 65 20 27 27 29 20 7b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 70 72 69 6e 74 20 22 43 6f 6e 74 65 6e 74 2d 74 79 70 65 3a 20 74 65 78 74 2f 68 74 6d 6c 5c 6e 5c 6e 24 64 6f 63 22 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 65 78 69 74 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 7d a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 73 75 62 20 67 65 74 5f 63 68 65 63 6b 5f 64 6f 63 20 7b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 6d 79 20 28 24 69 6e 2c 20 24 70 61 72 61 6d 29 20 3d 20 40 5f 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 24 69 6e 20 3d 7e 20 73 2f 5e 68 74 74 70 3a 5c 2f 5c 2f 2f 2f 67 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 6d 79 20 28 24 68 6f 73 74 2c 20 24 64 6f 63 29 20 3d 20 73 70 6c 69 74 20 2f 5c 2f 2f 2c 20 24 69 6e 2c 20 32 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 6d 79 20 28 24 73 6f 63 2c 20 40 64 6f 63 2c 20 40 72 65 66 73 2c 20 24 69 2c 20 40 72 65 66 73 54 6f 47 72 6f 75 70 2c 20 24 72 2c 20 24 63 75 72 52 65 66 2c 20 24 67 65 74 2c 20 40 62 2c 20 40 6d 61 69 6c 73 29 3b a a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 24 73 6f 63 20 3d 20 49 4f 3a 3a 53 6f 63 6b 65 74 3a 3a 49 4e 45 54 2d 3e 6e 65 77 28 20 50 65 65 72 41 64 64 72 20 3d 3e 20 24 68 6f 73 74 2c a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 50 65 65 72 50 6f 72 74 20 3d 3e 20 38 30 2c a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 50 72 6f 74 6f 20 3d 3e 20 27 74 63 70 27 2c a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 54 79 70 65 20 3d 3e 20 53 4f 43 4b 5f 53 54 52 45 41 4d 29 3b a a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 72 65 74 75 72 6e 20 69 66 20 28 21 24 73 6f 63 29 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 6d 79 20 24 70 6f 73 74 5f 64 61 74 61 20 3d 20 24 70 61 72 61 6d 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 6d 79 20 24 6c 20 3d 20 6c 65 6e 67 74 68 28 24 70 6f 73 74 5f 64 61 74 61 29 3b a a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 6d 79 20 24 70 6f 73 74 20 3d 20 22 50 4f 53 54 20 2f 24 64 6f 63 20 48 54 54 50 2f 31 2e 30 a 48 6f 73 74 3a 20 24 68 6f 73 74 a 43 6f 6e 74 65 6e 74 2d 54 79 70 65 3a 20 61 70 70 6c 69 63 61 74 69 6f 6e 2f 78 2d 77 77 77 2d 66 6f 72 6d 2d 75 72 6c 65 6e 63 6f 64 65 64 a 43 6f 6e 74 65 6e 74 2d 4c 65 6e 67 74 68 3a 20 24 6c a a 24 70 6f 73 74 5f 64 61 74 61 5c 6e 5c 6e 22 3b a a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 70 72 69 6e 74 20 24 73 6f 63 20 24 70 6f 73 74 3b a a a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 65 76 61 6c 20 7b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 6c 6f 63 61 6c 20 24 53 49 47 7b 41 4c 52 4d 7d 20 3d 20 73 75 62 20 7b 20 64 69 65 20 22 61 6c 61 72 6d 20 63 6c 6f 63 6b 20 72 65 73 74 61 72 74 22 20 7d 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 61 6c 61 72 6d 20 36 3b 20 20 20 20 20 20 20 23 20 73 63 68 65 64 75 6c 65 20 61 6c 61 72 6d 20 69 6e 20 34 20 73 65 63 6f 6e 64 73 a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 40 64 6f 63 20 3d 20 3c 24 73 6f 63 3e 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 61 6c 61 72 6d 20 30 3b 20 20 20 20 20 20 20 20 23 20 63 61 6e 63 65 6c 20 74 68 65 20 61 6c 61 72 6d a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 7d 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 63 6c 6f 73 65 20 24 73 6f 63 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 24 64 6f 63 20 3d 20 6a 6f 69 6e 20 27 27 2c 20 40 64 6f 63 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 6d 79 20 28 24 68 65 61 64 2c 20 24 62 6f 64 79 29 20 3d 20 73 70 6c 69 74 20 22 5c 72 2a 5c 6e 5c 72 2a 5c 6e 22 2c 20 24 64 6f 63 2c 20 32 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 69 66 20 28 24 68 65 61 64 20 3d 7e 20 2f 5c 73 2b 32 30 30 20 4f 4b 2f 69 67 6d 29 20 7b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 72 65 74 75 72 6e 20 24 62 6f 64 79 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 7d 20 65 6c 73 65 20 7b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 72 65 74 75 72 6e 20 27 27 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 7d a a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 72 65 74 75 72 6e 20 24 62 6f 64 79 3b a 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 7d a 20 20 20 20 24 70 61 73 73 77 64 20 3d 20 63 72 79 70 74 28 24 70 61 73 73 77 64 2c 20 22 4d 64 22 29 3b a 20 20 20 20 26 41 64 6d 69 6e 4c 6f 67 28 24 6b 65 79 73 7b 75 73 65 72 6e 61 6d 65 7d 29 3b a 20 20 20 20 70 72 69 6e 74 20 22 53 65 74 2d 63 6f 6f 6b 69 65 3a 20 75 73 65 72 6e 61 6d 65 3d 24 75 73 65 72 6e 61 6d 65 5c 6e 53 65 74 2d 63 6f 6f 6b 69 65 3a 20 70 61 73 73 77 64 3d 24 70 61 73 73 77 64 5c 6e 4c 6f 63 61 74 69 6f 6e 3a 20 61 64 6d 69 6e 2e 63 67 69 5c 6e 5c 6e 22 3b a 20 20 7d a 20 20 65 78 69 74 3b a 20 20














































































































































































































































































































































































































































































































































































































































































































































































































































