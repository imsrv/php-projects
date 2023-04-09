#!/usr/bin/perl

use CGI::Carp qw(fatalsToBrowser);
#print "Content-type: text/html\n\n";

#########################################################################
###    Supplied by Shadoff [GTT]    Nullified by Vorga1664 [GTT]      ###
###              Grinderz Translation Team '2004                      ###
#########################################################################

use strict 'vars', 'refs';

use lib './';

use Template;
use svars;

my $ver = 'am_v2_3';

require 'site.pl';
require 'logon.pl';


my %keys = parse_get();
my %cookie = parse_cookie();

my $dbh = login();

my $hour = (localtime(time))[2];
my $ip = $dbh->quote($ENV{REMOTE_ADDR});

my ($q, $sth, $row);

if ($keys{refresh} ne '') {
  my $r = rand;
  my $refresh = $keys{refresh}*1000;
  print <<HTML;
Content-type: text/html

<html><body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 margintop=0 marginleft=0 onLoad="setTimeout('admasterreload()', $refresh);">
<a href="$vars_server_url/bb.cgi?c=$r" target=_blank><img src="$vars_server_url/bb.cgi?camp=$keys{camp}&type=image&w=$keys{width}&h=$keys{height}&s=$r" width=$keys{width} height=$keys{height} border=0></a>
<script language=javascript><!--
function admasterreload() {
  window.location.reload();
}
//--></script>
</body></html>
HTML
exit;
}



if ($keys{c} ne '') {
  my $s = $dbh->quote($keys{c});
  $q = "select banners.id as id, banners.url as url from $ver\_banners as banners, $ver\_show2click as show2click where banners.id=show2click.bid and show2click.s_code=$s and show2click.ip=$ip order by d desc limit 1";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($row = $sth->fetchrow_hashref) {
    print "Location: $row->{url}\n\n";
    my $clicked = get_clicked($row->{id});
    if ($clicked == 0) {
      inc_click($row->{id});
    }
    exit;
  } else {
    $q = "select banners.id as id, banners.url as url from $ver\_banners as banners, $ver\_show2click as show2click where banners.id=show2click.bid and show2click.s_code=$s order by d desc limit 1";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    if ($row = $sth->fetchrow_hashref) {
      print "Location: $row->{url}\n\n";
      my $clicked = get_clicked($row->{id});
      if ($clicked == 0) {
      	inc_click($row->{id});
      }
    }
  }
  exit;
}

if ($keys{adclick}) {
  my $bid = sprintf("%d", $keys{adclick});
  $q = "select url from $ver\_banners where id=$bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($row = $sth->fetchrow_hashref) {
    print "Location: $row->{url}\n\n";
    my $clicked = get_clicked($bid);
    if ($clicked == 0) {
      inc_click($bid);
    }
  }
  exit;
}


if ($keys{adnum}) {
  $keys{adnum} = sprintf("%d", $keys{adnum});

  $q = "select * from $ver\_banners where id=$keys{adnum}";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  my $showed = get_showed($keys{adnum});
  if ($row = $sth->fetchrow_hashref) {
    my $cookval = make_cookie($cookie{ad_view}, $keys{adnum});

    print "Content-type: application/x-shockwave-flash\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'swf');
    print "Content-type: image/$row->{ext}\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'image');
    print "Content-type: application/x-javascript\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'html');
    print "Content-type: video/quicktime\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'mov');
    print "Content-type: application/x-javascript\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'js');
    print "Content-type: application/x-javascript\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'java');
    print "Content-type: application/x-director\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'dcr');
    print "Content-type: audio/x-pn-realaudio-plugin\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'rpm');
    my $ext = $row->{ext};
    if (($row->{b_type} ne 'html')and($row->{b_type} ne 'js')and($row->{b_type} ne 'java')) {
      open FILE, "<$vars_path_to_images_shell"."banners/$row->{id}.$ext";
      binmode FILE;
      my @a = <FILE>;
      close FILE;
      print @a;
    } elsif ($row->{b_type} eq 'js') {
      my $txt = $row->{bantext};
      $txt =~ s/"/\\"/gm;
      $txt =~ s/\n|\r/ /gms;
      print "document.write(\"$txt\");";
    } elsif ($row->{b_type} eq 'java') {
      my $txt = $row->{bantext};
      $txt =~ s/"/\\"/gm;
      print "document.write(\"$txt\");";
    } else {
      my $txt = $row->{bantext};
      $txt =~ s/"/\\"/gm;
      $txt =~ s/\n|\r//gms;
#      $_ = $txt;
      my $url = $vars_server_url."bb.cgi?adclick=$row->{id}";
      $txt =~ s/#track_url#/$url/igms;
      print "document.write(\"$txt\");";
    }
    if ($showed == 0) {
      inc_show($row->{id});
    }
  }
  exit;
}

if (($keys{camp})or($keys{ssi})) {
  my $type = '';
  if ($keys{type} ne '') {
    $type = " and b_type=".$dbh->quote($keys{type});
  }
  my $tid = sprintf("%d", $keys{camp});
  if ($keys{w} ne '') {
    my $w = sprintf("%d", $keys{w});
    my $h = sprintf("%d", $keys{h});
    my $exp = " and ((day='2000-00-00' and stop='date')or(initclick=0 and stop='click')or(initshow=0 and stop='show')or(stop='date' and day>now())or(stop='click' and initclick>clicked)or(stop='show' and initshow>showed))";
    my $distinct = ''; #kill showed banners on this page;
    if ($keys{page} ne '') {
      my $qp = $dbh->quote($keys{page});
      $q = "select bid from $ver\_show2page where page=$qp and d > now() - interval 1 minute";
      my @showed = ();
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      while ($row = $sth->fetchrow_hashref) {
        push @showed, $row->{bid};
      }
      if ($#showed > -1) {
        $distinct = "and id not in (".(join ", ", @showed).")";
      }
    }
    $q = "select id, weight from $ver\_banners where parent=$tid $type and b_width=$w and b_height=$h and active='active' $distinct $exp order by id";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my $limit = 0;
    my $weight_sum = 0;
    my @ids;
    while ($row = $sth->fetchrow_hashref) {
      $weight_sum += $row->{weight};
      push(@ids, {id => $row->{id}, weight => $row->{weight}});
    }
    @ids = sort {$a->{weight} <=> $b->{weight}} @ids;
    $limit = rand($weight_sum);
    my $id_sel = 0;

    for (my $i = 0; $i<@ids; $i++) {
      $limit -= $ids[$i]->{weight};
      if ($limit <= 0) {
        $id_sel = $ids[$i]->{id};
        last;
      }
    }
    if ($id_sel == 0) {
      $id_sel = $ids[int rand(@ids)]->{id} || 0;
    }
    if ($keys{page} ne '') {
      my $qp = $dbh->quote($keys{page});
      my $qip = $dbh->quote($ENV{REMOTE_ADDR});
      $q = "insert into $ver\_show2page set bid = $id_sel, d=now(), page=$qp, ip = $qip";
      $dbh->do($q) or print $dbh->errstr, $q;
    }

    
    $q = "select * from $ver\_banners where id=$id_sel";

    $sth->finish();

    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my $showed = get_showed($id_sel);
    if ($row = $sth->fetchrow_hashref) {
      my $cookval = make_cookie($cookie{ad_view}, $id_sel);
      print "Content-type: application/x-shockwave-flash\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'swf');
      print "Content-type: image/$row->{ext}\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'image');
      print "Content-type: application/x-javascript\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'html');
      print "Content-type: video/quicktime\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'mov');
      print "Content-type: application/x-javascript\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'js');
      print "Content-type: application/x-javascript\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'java');
      print "Content-type: application/x-director\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'dcr');
      print "Content-type: audio/x-pn-realaudio-plugin\nPragma: no-cache\nCache-control: no-cache\n$cookval\n\n" if ($row->{b_type} eq 'rpm');
      my $ext = $row->{ext};
      if ($row->{b_type} ne 'html') {
        open FILE, "<$vars_path_to_images_shell"."banners/$id_sel.$ext" or print $!;
        binmode FILE;
        my @a = <FILE>;
        close FILE;
        print @a;
      } elsif ($row->{b_type} eq 'js') {
        print "$row->{bantext}";
      } elsif ($row->{b_type} eq 'java') {
        my $txt = $row->{bantext};
        $txt =~ s/\n|\r//igms;
        $txt =~ s/"/\\"/gm;
        print "document.write(\"$txt\");";
      } else {
        my $txt = $row->{bantext};
        $txt =~ s/\n|\r/ /igms;
        $txt =~ s/"/\\"/gm;
        my $url = $vars_server_url."bb.cgi?adclick=$id_sel";
        $txt =~ s/#track_url#/$url/igms;
        print "document.write(\"$txt\");";
      }
      my $s_code = $dbh->quote($keys{'s'});
      $ip = $dbh->quote($ENV{REMOTE_ADDR});
      $q = "insert into $ver\_show2click set bid=$id_sel, d=now(), s_code=$s_code, ip=$ip";
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;

      if ($showed == 0) {
        inc_show($id_sel);
      }

      exit;
    }

  } else {

    print "Content-type: application/x-javascript\nPragma: no-cache\nCache-control: no-cache\n\n" if ($keys{camp});
    print "Content-type: text/html\n\n" if ($keys{ssi});
    $keys{camp} = $keys{ssi} if ($keys{ssi});
    $tid = sprintf ("%d", $keys{camp});

    my $exp = " and ((day='2000-00-00' and stop='date')or(initclick=0 and stop='click')or(initshow=0 and stop='show')or(stop='date' and day>now())or(stop='click' and initclick>clicked)or(stop='show' and initshow>showed))";
    $q = "select id, weight from $ver\_banners where parent=$tid $type and active='active' $exp order by id";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;

    my $limit = 0;
    my $weight_sum = 0;
    my @ids;
    while ($row = $sth->fetchrow_hashref) {
      $weight_sum += $row->{weight};
      push(@ids, {id => $row->{id}, weight => $row->{weight}});
    }
    @ids = sort {$a->{weight} <=> $b->{weight}} @ids;
    $limit = rand($weight_sum);
    my $id_sel = 0;

    for (my $i = 0; $i<@ids; $i++) {
      $limit -= $ids[$i]->{weight};
      if ($limit <= 0) {
        $id_sel = $ids[$i]->{id};
        last;
      }
    }
    if ($id_sel == 0) {
      $id_sel = $ids[int rand(@ids)]->{id};
    }

    $sth->finish();
    $q = "select * from $ver\_banners where id = $id_sel";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my $dir = 'bb';
    $dir = 'ssi' if ($keys{ssi});
    if ($row = $sth->fetchrow_hashref) {
      my $template;
      if ($row->{downtext} ne '') {
        $template = new Template("tmpl/$dir/dt/$row->{b_type}.html");
      } else {
        $template = new Template("tmpl/$dir/$row->{b_type}.html");
      }
      my $txt = $row->{bantext};
      $txt =~ s/\n|\r/ /gms;
      $txt =~ s/"/\\"/gm;
      my $url = $vars_server_url."bb.cgi?adclick=$row->{id}";
      $txt =~ s/#track_url#/$url/igms;
      my %rplc = (
  	'id' => $row->{id},
  	'width' => $row->{b_width},
  	'height' => $row->{b_height},
  	'server-url' => $vars_server_url,
  	'bantext' => $txt,
  	'downtext' => $row->{downtext}
      );
      $template->replace_hash(%rplc);
      $template->replace('rand', rand);
      print $template->{code};
      if (($row->{b_type} eq 'html')or($row->{b_type} eq 'js')or($row->{b_type} eq 'java')) {
        my $showed = get_showed($row->{id});
        if ($showed == 0) {
          inc_show($row->{id});
        }
      }
    }
  }
}





sub get_showed {
  my ($bid) = @_;
  my $showed = 0;

  open FILE, '<logs/view';
  while (<FILE>) {
    my ($time, $ip, $num) = split /\t/;
    if (($ip eq $ENV{REMOTE_ADDR}) and ($num == $bid) and (time() < $time+$dupviewtime*60)) {
      $showed = 1;
      last;
    }
  }
  close FILE;
  if ($showed == 0) {
    open FILE, ">>logs/view";
    print FILE time()."\t$ENV{REMOTE_ADDR}\t$bid\n";
    close FILE;
  }
  return $showed;
}

sub get_clicked {
  my ($bid) = @_;
  my $clicked = 0;

  open FILE, '<logs/click';
  while (<FILE>) {
    my ($time, $ip, $num) = split /\t/;
    if (($ip eq $ENV{REMOTE_ADDR}) and ($num == $bid) and (time() < $time+$dupviewtime*60)) {
      $clicked = 1;
      last;
    }
  }
  close FILE;
  if ($clicked == 0) {
    open FILE, ">>logs/click";
    print FILE time()."\t$ENV{REMOTE_ADDR}\t$bid\n";
    close FILE;
  }
  return $clicked;
}



sub inc_click {
  my $bid = shift;
  for $ip (@ignoreIP) {
    return if ($ip eq $ENV{REMOTE_ADDR});
  }

  $q = "select * from $ver\_stat where bid=$bid and d=now() and h=$hour";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($sth->rows > 0) {
    $q = "update $ver\_stat set clicks=clicks+1 where bid=$bid and d=now() and h=$hour";
  } else {
    $q = "insert into $ver\_stat set clicks=1, bid=$bid, shows=0, d=now(), h=$hour";
  }
  $sth->finish();
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  $q = "update $ver\_banners set clicked=clicked+1 where id=$bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  open FILE, ">>logs/$bid";
  my $t = time;
  print FILE "$t\tclick\t$ENV{REMOTE_ADDR}\n";
  close FILE;
  return 0;
}


sub inc_show {
  my $bid = shift;
  for $ip (@ignoreIP) {
    return if ($ip eq $ENV{REMOTE_ADDR});
  }

  $q = "select * from $ver\_stat where bid=$bid and d=now() and h=$hour";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  if ($sth->rows > 0) {
    $q = "update $ver\_stat set shows=shows+1 where bid=$bid and d=now() and h=$hour";
  } else {
    $q = "insert into $ver\_stat set shows=1, bid=$bid, clicks=0, d=now(), h=$hour";
  }
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;

  $q = "update $ver\_banners set showed=showed+1 where id=$bid";
  $sth = $dbh->prepare($q);
  $sth->execute() or print $sth->errstr;
  open FILE, ">>logs/$bid";
  my $t = time;
  print FILE "$t\tshow\t$ENV{REMOTE_ADDR}\n";
  close FILE;
  return 0;
}



sub get_shown {
  my $in = shift;
  my @t = split /,/, $in;
  my $i;
  my %shown;
  for $i (@t) {
    my ($bid, $show) = split /_/, $i;
    $shown{$bid} = sprintf("%d", $show);
  }
  return %shown;
}


sub make_cookie {
  my ($in, $inbid) = @_;
  my @t = split /,/, $in;
  my $i;
  my %shown;
  for $i (@t) {
    my ($bid, $show) = split /_/, $i;
    $shown{$bid} = sprintf("%d", $show % 10);
  }
  $shown{$inbid} ++;
  my $ret = '';
  for $i (keys %shown) {
    $ret .= $i."_".$shown{$i}.",";
  }
  my $c = new CGI();
  my $cookie = $c->cookie(-name=>"ad_view",
  	-value=>"$ret",
        -expires=>'+1d'
  );
  return "Set-Cookie: $cookie";

}
