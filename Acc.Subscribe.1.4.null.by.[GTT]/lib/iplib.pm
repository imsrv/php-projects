package iplib;

use strict;
use vars qw(@ISA $VERSION @EXPORT);
use FileHandle;

use constant COUNTRY_BEGIN => 16776960;
use constant RECORD_LENGTH => 3;

$VERSION = '1.10';

require Exporter;
@ISA = qw(Exporter);

sub GEOIP_STANDARD(){0;}
sub GEOIP_MEMORY_CACHE(){1;}

@EXPORT = qw( GEOIP_STANDARD GEOIP_MEMORY_CACHE );

my @countries = (undef,"AP","EU","AD","AE","AF","AG","AI","AL","AM","AN","AO","AQ","AR","AS","AT","AU","AW","AZ","BA","BB","BD","BE","BF","BG","BH","BI","BJ","BM","BN","BO","BR","BS","BT","BV","BW","BY","BZ","CA","CC","CD","CF","CG","CH","CI","CK","CL","CM","CN","CO","CR","CU","CV","CX","CY","CZ","DE","DJ","DK","DM","DO","DZ","EC","EE","EG","EH","ER","ES","ET","FI","FJ","FK","FM","FO","FR","FX","GA","GB","GD","GE","GF","GH","GI","GL","GM","GN","GP","GQ","GR","GS","GT","GU","GW","GY","HK","HM","HN","HR","HT","HU","ID","IE","IL","IN","IO","IQ","IR","IS","IT","JM","JO","JP","KE","KG","KH","KI","KM","KN","KP","KR","KW","KY","KZ","LA","LB","LC","LI","LK","LR","LS","LT","LU","LV","LY","MA","MC","MD","MG","MH","MK","ML","MM","MN","MO","MP","MQ","MR","MS","MT","MU","MV","MW","MX","MY","MZ","NA","NC","NE","NF","NG","NI","NL","NO","NP","NR","NU","NZ","OM","PA","PE","PF","PG","PH","PK","PL","PM","PN","PR","PS","PT","PW","PY","QA","RE","RO","RU","RW","SA","SB","SC","SD","SE","SG","SH","SI","SJ","SK","SL","SM","SN","SO","SR","ST","SV","SY","SZ","TC","TD","TF","TG","TH","TJ","TK","TM","TN","TO","TP","TR","TT","TV","TW","TZ","UA","UG","UM","US","UY","UZ","VA","VC","VE","VG","VI","VN","VU","WF","WS","YE","YT","YU","ZA","ZM","ZR","ZW","A1","A2");

sub open {
  print "iplib::open() requires a path name"
    unless( @_ > 1 and $_[1] );
  my ($class, $db_file, $flags) = @_;
  my $fh = new FileHandle;
  open $fh, "<$db_file";
#  open $fh, "<$db_file" or print "Error opening $db_file";
  binmode($fh);
  if ($flags && $flags & GEOIP_MEMORY_CACHE == 1) {
    my $buf;
    local($/) = undef;
    $buf = <$fh>;
    bless {buf => $buf}, $class;
  } else {
    bless {fh => $fh}, $class;
  }
}

sub new {
  my ($class, $db_file, $flags) = @_;

  $class->open( $db_file, $flags );
}

sub country_code_by_addr {
  my ($gi, $ip_address) = @_;
  return unless $ip_address =~ m!^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$!;
  return $countries[$gi->_seek_country(addr_to_num($ip_address))];
}

sub _seek_country {
  my ($gi, $ipnum) = @_;

  my $fh  = $gi->{fh};
  my $buf = $gi->{buf};
  my $offset = 0;

  my ($x0, $x1);

  for (my $depth = 31; $depth >= 0; $depth--) {
    if ($fh) {
      seek $fh, $offset * 2 * RECORD_LENGTH, 0;
      read $fh, $x0, RECORD_LENGTH;
      read $fh, $x1, RECORD_LENGTH;
    } else {
      $x0 = substr($buf, $offset * 2 * RECORD_LENGTH, RECORD_LENGTH);
      $x1 = substr($buf, $offset * 2 * RECORD_LENGTH + RECORD_LENGTH, RECORD_LENGTH);
    }

    $x0 = unpack("I1", $x0."\0");
    $x1 = unpack("I1", $x1."\0");

    if ($ipnum & (1 << $depth)) {
      if ($x1 >= COUNTRY_BEGIN) {
        return $x1 - COUNTRY_BEGIN;
      }
      $offset = $x1;
    } else {
      if ($x0 >= COUNTRY_BEGIN) {
        return $x0 - COUNTRY_BEGIN;
      }
      $offset = $x0;
    }
  }
}

sub addr_to_num {
  my @a = split('\.',$_[0]);
  return $a[0]*16777216+$a[1]*65536+$a[2]*256+$a[3];
}

1;


