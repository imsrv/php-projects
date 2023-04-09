#!/usr/bin/perl

my $ver = "acc14";

use lib './lib';
use CSV;
use svars;
require 'logon.pl';
require 'site.pl';

close STDOUT;
if ($pid = fork) {
  exit;
} else {
  if ($ARGV[0] eq '-import') {
    $dbh = login();
    $id = $ARGV[1];
    $q = "update $ver\_import set pid=$$ where id=$id";
    $dbh->do($q) or print $dbh->errstr;
    %imp = get_record($dbh, "select * from $ver\_import where id=$id");
    %sub = get_record($dbh, "select * from $ver\_types where id=$imp{sid}");
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
    my @imp_fields = split /\,/, $imp{imp_fields};
    my @to_fields = split /\,/, $imp{to_fields};
    my %d = ();
    for ($i = 0; $i<@imp_fields; $i++) {
      $d{$imp_fields[$i]} = $to_fields[$i];
    }
    if ($imp{source} eq 'file') {
      open FILE, "<export/imp$id" or print $!;
      $i = 0;
      while ($a = <FILE>) {
        $i++;
        next if ($i == 1);
        my $csv = CSV->new();
        $csv->parse($a);
        @flds = $csv->fields();
        $cont = '';
        $email = '';
        for $i (keys %d) {
          $cont .= ', ' if ($cont ne '');
          $cont .= "$d{$i} = ".$dbh->quote($flds[$i]);
          $email = $flds[$i] if ($d{$i} eq 'email');
        }

        if ($imp{sendconfirm} eq '1') {
          if (($sub{use_confirm_url} eq '1')and($sub{send_confirm_subscribe} eq '1')) {
            $cont .= ", confirm = 0";
          } else {
            $cont .= ", confirm = 1";
          }
        } else {
          $cont .= ", confirm = 1";
        }

        if ($imp{setapproved} eq '1') {
          $cont .= ", approved = 1";
        } else {
          if ($sub{use_approve} eq '1') {
            $cont .= ", approved = 0";
          } else {
            $cont .= ", approved = 1";
          }
        }
        if ($imp{setdisabled} eq '1') {
          $cont .= ", active = 0";
        } else {
          $cont .= ", active = 1";
        }
        $q = "insert into $ver\_sub_$imp{sid} set $cont";
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr;
        $e_id = $sth->{insertid} || $sth->{mysql_insertid};

#	Check($email, $e_id, $imp{sid});

        $q = "update $ver\_import set processed = processed+1 where id=$id";
        $dbh->do($q) or print $dbh->errstr;
        $q = "update $ver\_types set col=col+1 where id=1 or id=$imp{sid}";
        $dbh->do($q) or print $dbh->errstr;
      }
    } else {
      my $dbh2 = DBI->connect("DBI:mysql:$imp{mysqldatabase}:$imp{mysqlhost}", $imp{mysqllogin}, $imp{mysqlpassword}) || print "Can't connect: $DBI::errstr\n";
      $q = "select * from $imp{mysqltable}";
      my $sth2 = $dbh2->prepare($q);
      $sth2->execute() or print $sth2->errstr;
      while ($row = $sth2->fetchrow_arrayref) {
        $cont = '';
        for $i (keys %d) {
          $cont .= ', ' if ($cont ne '');
          $cont .= "$d{$i} = ".$dbh->quote($row->[$i]);
        }

        if ($imp{sendconfirm} eq '1') {
          if (($sub{use_confirm_url} eq '1')and($sub{send_confirm_subscribe} eq '1')) {
            $cont .= ", confirm = 0";
          } else {
            $cont .= ", confirm = 1";
          }
        } else {
          $cont .= ", confirm = 1";
        }

        if ($imp{setapproved} eq '1') {
          $cont .= ", approved = 1";
        } else {
          if ($sub{use_approve} eq '1') {
            $cont .= ", approved = 0";
          } else {
            $cont .= ", approved = 1";
          }
        }
        if ($imp{setdisabled} eq '1') {
          $cont .= ", active = 0";
        } else {
          $cont .= ", active = 1";
        }
        $q = "insert into $ver\_sub_$imp{sid} set $cont";
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr;
        $e_id = $sth->{insertid} || $sth->{mysql_insertid};

#	Check($email, $e_id, $imp{sid});

        $q = "update $ver\_import set processed = processed+1 where id=$id";
        $dbh->do($q) or print $dbh->errstr;
        $q = "update $ver\_types set col=col+1 where id=1 or id=$imp{sid}";
        $dbh->do($q) or print $dbh->errstr;
      }
      
    }
    $q = "update $ver\_import set done=1 where id=$id";
    $dbh->do($q) or print $dbh->errstr;
    if ($imp{sendadminconfirm} ne '') {
      my $letter = "From: $imp{sendadminconfirm}\nTo: $imp{sendadminconfirm}\nSubject: Import done\n\nImport has been done";
      open FILE, "| $vars_path_to_sendmail";
      print FILE $letter;
      close FILE;
    }
    exit;
  } else {
    #export
    $dbh = login();
    $id = $ARGV[0];
    $expid = $id;
    $q = "update $ver\_export set pid=$$ where id=$id";
    $dbh->do($q) or print $dbh->errstr;
    $q = "select * from $ver\_export where id=$id";
    $sth = $dbh->prepare($q);
    $sth->execute() or print $sth->errstr;
    my $email_for_confirm = '';
    if ($row = $sth->fetchrow_hashref) {
      $email_for_confirm = $row->{confirmemail};
      $q = $row->{param};
      $efields = $row->{exp_fields};
      @efields = split /,/, $efields;
      $point = $row->{point};
      %f_sql = (
  	'email' => 'email',
  	'firstname' => 'first_name',
  	'lastname' => 'last_name',
  	'fullname' => 'full_name',
  	'company' => 'company',
  	'phone' => 'phone',
  	'icq' => 'icq',
  	'address' => 'address',
  	'address2' => 'address2',
  	'city' => 'city',
  	'state' => 'state',
  	'country' => 'country',
  	'birthdate' => "birthdate",
  	'age' => "age",
  	'sex' => "sex",
  	'website' => "website",
  	'heard' => "heard",
  	'business' => "business",
  	'subscribe_date' => 'date_sub',
  	'unsubscribe_date' => 'date_unsub',
  	'ip' => 'ip',
  	'language' => 'language',
  	'letterformat' => 'lettersformat',
  	'add1' => "additional1",
  	'add2' => "additional2",
  	'add3' => "additional3",
  	'add4' => "additional4",
  	'add5' => "additional5",
  	'add6' => "additional6",
  	'add7' => "additional7",
  	'add8' => "additional8",
  	'add9' => "additional9",
  	'add10' => "additional10",
  	'add11' => "additional11",
  	'add12' => "additional12"
      );
      %f_header = (
  	'email' => 'E-mail',
  	'firstname' => 'First name',
  	'lastname' => 'Last name',
  	'fullname' => 'Full Name',
  	'company' => 'Company',
  	'phone' => 'Phone',
  	'icq' => 'ICQ',
  	'address' => 'Address',
  	'address2' => 'Address2',
  	'city' => 'City',
  	'state' => 'State',
  	'country' => 'Country',
  	'birthdate' => "Birthdate",
  	'age' => "Age",
  	'sex' => "Sex",
  	'website' => "Website",
  	'heard' => "Heard about",
  	'business' => "Business",
  	'subscribe_date' => 'Subscribtion date',
  	'unsubscribe_date' => 'Unsubscribe date',
  	'ip' => 'IP Address',
  	'language' => 'Language',
  	'letterformat' => 'Letters Format',
  	'add1' => "Additional 1",
  	'add2' => "Additional 2",
  	'add3' => "Additional 3",
  	'add4' => "Additional 4",
  	'add5' => "Additional 5",
  	'add6' => "Additional 6",
  	'add7' => "Additional 7",
  	'add8' => "Additional 8",
  	'add9' => "Additional 9",
  	'add10' => "Additional 10",
  	'add11' => "Additional 11",
  	'add12' => "Additional 12"
      );
      $format = $row->{report_type};
      $sth = $dbh->prepare($q);
      $sth->execute() or print $sth->errstr;
      if ($format eq 'html') {
        $header = '';
        for $i (@efields) {
          $header .= "<th>$f_header{$i}</th>";
        }
      }
      if ($format =~ /text - ([^\s]+) - (\d+)/) {
        %delim = (
  	'tab' => "\t",
  	'space' => ' ',
  	'|' => '|',
  	'=' => '=',
  	'+' => '+',
  	'-' => '-'
        );
        $format = 'text';
        $delimeter = $delim{$1} x $2;
      }
      if ($format eq 'csv') {
        $header = '';
        $csv = new CSV();
        $header = $csv->combine(@efields);
        $header = $csv->string;
      }
      open FILE, ">>export/$id";
      if ($format eq 'html') {
        print FILE "<html><body><table cellspacing=0 cellpadding=1 border=1><tr>$header</tr>";
      }
      if ($format eq 'text') {
      }
      if ($format eq 'csv') {
        print FILE "$header\n";
      }
  
      $cont = '';
      while ($row = $sth->fetchrow_hashref) {
        if ($format eq 'html') {
          $line = '<tr>';
          for $i (@efields) {
            $line .= "<td>$row->{$f_sql{$i}}</td>";
          }
          $line .= "</tr>\n";
        }
        if ($format eq 'text') {
          $line = '';
          for $i (@efields) {
            $line .= "$row->{$f_sql{$i}}$delimeter";
          }
          $line .= "\n";
        }
        if ($format eq 'csv') {
          $line = '';
          my $csv = CSV->new();
          @f = ();
          for $i (@efields) {
            $value = $row->{$f_sql{$i}};
            @f = (@f, $value);
          }
          $csv->combine(@f);
          $line = $csv->string."\n";
        }
        print FILE $line;
        $q = "update $ver\_export set processed = processed+1 where id=$expid";
        $dbh->do($q) or print $dbh->errstr;
      }
      if ($format eq 'html') {
        print FILE "</table></body></html>";
      }
      close FILE;
      if ($point > 0) {
        $q = "update $ver\_types set point_export = now() where id=$point";
        $sth = $dbh->prepare($q);
        $sth->execute() or print $sth->errstr;
      }
  
    }
    
    $q = "update $ver\_export set done=1 where id=$id";
    $sth = $dbh->prepare($q);
    $sth->execute();
    if ($email_for_confirm ne '') {
      my $letter = "From: $email_for_confirm\nTo: $email_for_confirm\nSubject: Export done\n\nDownload results here: $vars_server_url/admin.cgi?page=export&action=download&id=$expid";
      open FILE, "| $vars_path_to_sendmail" or print FILE1 $!;
      print FILE $letter;
      close FILE;
    }
  }
}