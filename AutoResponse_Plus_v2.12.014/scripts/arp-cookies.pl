##################################################
##                                              ##
##             AUTORESPONSE PLUS (tm)           ##
##       Sequential Autoresponder System        ##
##                Version 2.12                  ##
##                                              ##
##   Copyright Gobots Internet Solutions, 2001  ##
##             All rights reserved              ##
##                                              ##
##  For support and latest product information  ##
##    visit http://www.autoresponseplus.com.    ##
##                                              ##
##  Use of AutoResponse Plus is subject to our  ##
##   license agreement and limited warranty.    ##
##  See the file license.txt for more details.  ##
##                                              ##
##################################################

sub SetCookie() {
  my ($name,$value,$expires,$path,$domain) = @_;

  $name=&CookieScrub($name);
  $value=&CookieScrub($value);

  $expires=$expires * 24 * 60 * 60;

  my $expire_at=&CookieDate($expires);
  my $namevalue="$name=$value";

  my $COOKIE="";

  if ($expires != 0) {
     $COOKIE= "Set-Cookie: $namevalue; expires=$expire_at; ";
  }
   else {
     $COOKIE= "Set-Cookie: $namevalue; ";
   }
  if ($path ne ""){
     $COOKIE .= "path=$path; ";
  }
  if ($domain ne ""){
     $COOKIE .= "domain=$domain; ";
  }
   
  $COOKIE .= "\n";

  return $COOKIE;
} # END OF SUB SetCookie

sub RemoveCookie() {
  my ($name,$path,$domain) = @_;

  $name=&CookieScrub($name);
  my $value="";
  my $expire_at=&CookieDate(-86400);
  my $namevalue="$name=$value";

  my $COOKIE= "Set-Cookie: $namevalue; expires=$expire_at; ";
  if ($path ne ""){
     $COOKIE .= "path=$path; ";
  }
  if ($domain ne ""){
     $COOKIE .= "domain=$domain; ";
  }

  $COOKIE .= "\n";

  return $COOKIE;
} # END OF SUB RemoveCookie

sub GetCookie() {
  my ($name) = @_;

  $name=&CookieScrub($name);
  my $temp=$ENV{'HTTP_COOKIE'};
  @pairs=split(/\; /,$temp);
  foreach my $sets (@pairs) {
    my ($key,$value)=split(/=/,$sets);
    $clist{$key} = $value;
  }
  my $retval=$clist{$name};

  return $retval;
} # END OF SUB GetCookie

sub CookieDate() {
  my ($seconds) = @_;

  my %mn = ('Jan','01', 'Feb','02', 'Mar','03', 'Apr','04',
            'May','05', 'Jun','06', 'Jul','07', 'Aug','08',
            'Sep','09', 'Oct','10', 'Nov','11', 'Dec','12' );
  my $sydate=gmtime(time+$seconds);
  my ($day, $month, $num, $time, $year) = split(/\s+/,$sydate);
  my    $zl=length($num);
  if ($zl == 1) { 
    $num = "0$num";
  }

  my $retdate="$day $num-$month-$year $time GMT";

  return $retdate;
} # END OF SUB CookieDate

sub CookieScrub() {
  my($retval) = @_;

  $retval=~s/\;//;
  $retval=~s/\=//;

  return $retval;
} # END OF SUB CookieScrub

return 1;
