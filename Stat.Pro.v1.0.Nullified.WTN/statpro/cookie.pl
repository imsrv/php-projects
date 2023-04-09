##############################################################################
##                                                                          ##
##  Program Name         : Stat Pro                                         ##
##  Release Version      : 1.0                                              ##
##  Home Page            : http://www.cidex.ru                              ##
##  Supplied by          : CyKuH [WTN]                                      ##
##  Distribution         : via WebForum, ForumRU and associated file dumps  ##
##                                                                          ##
##############################################################################
$Cookie_Exp_Date = '';
$Cookie_Path = '';
$Cookie_Domain = '';
$Secure_Cookie = '0';
@Cookie_Encode_Chars = ('\%', '\+', '\;', '\,', '\=', '\&', '\:\:', '\s');

%Cookie_Encode_Chars = ('\%',   '%25',
                        '\+',   '%2B',
                        '\;',   '%3B',
                        '\,',   '%2C',
                        '\=',   '%3D',
                        '\&',   '%26',
                        '\:\:', '%3A%3A',
                        '\s',   '+');

@Cookie_Decode_Chars = ('\+', '\%3A\%3A', '\%26', '\%3D', '\%2C', '\%3B', '\%2B', '\%25');

%Cookie_Decode_Chars = ('\+',       ' ',
                        '\%3A\%3A', '::',
                        '\%26',     '&',
                        '\%3D',     '=',
                        '\%2C',     ',',
                        '\%3B',     ';',
                        '\%2B',     '+',
                        '\%25',     '%');

#======================================================================#                 
sub DelCookies {

  local(@to_delete) = @_;
  local($name);
  foreach $name (@to_delete) {
   undef $cookie{$name};
   print "Set-Cookie: $name=deleted; expires=Thu, 01-Jan-1970 00:00:00 GMT;\n";
  }
}

#======================================================================#                  
sub GetCookies {

    local(@ReturnCookies) = @_;
    local($cookie_flag) = 0;
    local($cookie,$value);

    if ($ENV{'HTTP_COOKIE'}) {

        if ($ReturnCookies[0] ne '') {

            foreach (split(/; /,$ENV{'HTTP_COOKIE'})) {

                ($cookie,$value) = split(/=/);

                foreach $char (@Cookie_Decode_Chars) {
                    $cookie =~ s/$char/$Cookie_Decode_Chars{$char}/g;
                    $value =~ s/$char/$Cookie_Decode_Chars{$char}/g;
                }

                foreach $ReturnCookie (@ReturnCookies) {

                    if ($ReturnCookie eq $cookie) {
                        $Cookies{$cookie} = $value;
                        $cookie_flag = "1";
                    }
                }
            }

        }

        else {

            foreach (split(/; /,$ENV{'HTTP_COOKIE'})) {
                ($cookie,$value) = split(/=/);

                foreach $char (@Cookie_Decode_Chars) {
                    $cookie =~ s/$char/$Cookie_Decode_Chars{$char}/g;
                    $value =~ s/$char/$Cookie_Decode_Chars{$char}/g;
                }

                $Cookies{$cookie} = $value;
            }
            $cookie_flag = 1;
        }
    }

    return $cookie_flag;
}

#======================================================================#
sub SetCookieExpDate {

    if ($_[0] =~ /^\w{3}\,\s\d{2}\-\w{3}-\d{4}\s\d{2}\:\d{2}\:\d{2}\sGMT$/ ||
        $_[0] eq '') {
        $Cookie_Exp_Date = $_[0];
        return 1;
    }
    else {
        return 0;
    }
}

#======================================================================#
sub SetCookiePath {

    $Cookie_Path = $_[0];
}

#======================================================================#
sub SetCookieDomain {


    if ($_[0] =~ /(.com|.edu|.net|.org|.gov|.mil|.int)$/i &&
        $_[0] =~ /\..+\.\w{3}$/) {
        $Cookie_Domain = $_[0];
        return 1;
    }
    elsif ($_[0] !~ /(.com|.edu|.net|.org|.gov|.mil|.int)$/i &&
           $_[0] =~ /\..+\..+\..+/) {
        $Cookie_Domain = $_[0];
        return 1;
    }
    else {
        return 0;
    }
}

#======================================================================#
sub SetSecureCookie {

    if ($_[0] =~ /^[01]$/) {
        $Secure_Cookie = $_[0];
        return 1;
    }
    else {
        return 0;
    }
}

#======================================================================#
sub SetCookies {

    local(@cookies) = @_;
    local($cookie,$value,$char);

    while( ($cookie,$value) = @cookies ) {

        foreach $char (@Cookie_Encode_Chars) {
            $cookie =~ s/$char/$Cookie_Encode_Chars{$char}/g;
            $value =~ s/$char/$Cookie_Encode_Chars{$char}/g;
        }

        print 'Set-Cookie: ' . $cookie . '=' . $value . ';';

        if ($Cookie_Exp_Date) {
            print ' expires=' . $Cookie_Exp_Date . ';';
        }

        if ($Cookie_Path) {
            print ' path=' . $Cookie_Path . ';';
        }

        if ($Cookie_Domain) {
            print ' domain=' . $Cookie_Domain . ';';
        }

        if ($Secure_Cookie) {
            print ' secure';
        }

        print "\n";

        shift(@cookies); shift(@cookies);
    }
}

#======================================================================#
sub SetCompressedCookies {

    local($cookie_name,@cookies) = @_;
    local($cookie,$value,$cookie_value);

    while ( ($cookie,$value) = @cookies ) {

        foreach $char (@Cookie_Encode_Chars) {
            $cookie =~ s/$char/$Cookie_Encode_Chars{$char}/g;
            $value =~ s/$char/$Cookie_Encode_Chars{$char}/g;
        }

        if ($cookie_value) {
            $cookie_value .= '&' . $cookie . '::' . $value;
        }
        else {
            $cookie_value = $cookie . '::' . $value;
        }

        shift(@cookies); shift(@cookies);
    }

    &SetCookies("$cookie_name","$cookie_value");
}

#======================================================================#
sub GetCompressedCookies {

    local($cookie_name,@ReturnCookies) = @_;
    local($cookie_flag) = 0;
    local($ReturnCookie,$cookie,$value);

    if (&GetCookies($cookie_name)) {

        if ($ReturnCookies[0] ne '') {

            foreach (split(/&/,$Cookies{$cookie_name})) {

                ($cookie,$value) = split(/::/);

                foreach $char (@Cookie_Decode_Chars) {
                    $cookie =~ s/$char/$Cookie_Decode_Chars{$char}/g;
                    $value =~ s/$char/$Cookie_Decode_Chars{$char}/g;
                }

                foreach $ReturnCookie (@ReturnCookies) {
                    if ($ReturnCookie eq $cookie) {
                        $Cookies{$cookie} = $value;
                        $cookie_flag = 1;
                    }
                }
            }
        }

        else {

            foreach (split(/&/,$Cookies{$cookie_name})) {
                ($cookie,$value) = split(/::/);

                foreach $char (@Cookie_Decode_Chars) {
                    $cookie =~ s/$char/$Cookie_Decode_Chars{$char}/g;
                    $value =~ s/$char/$Cookie_Decode_Chars{$char}/g;
                }

                $Cookies{$cookie} = $value;
            }
            $cookie_flag = 1;
        }

        delete($Cookies{$cookie_name});
    }

    return $cookie_flag;
}

#======================================================================#
sub get_cookie {
  my ($cookie) = shift;
  my (@key_value_pairs, $key, $value);
  @key_value_pairs = split (/;\s/, $ENV{'HTTP_COOKIE'});
  foreach (@key_value_pairs) {
    ($key,$value) = split (/=/, $_);
    if ($key eq $cookie) {
      return $value;
    }
  }
  return 0;
}

#======================================================================#
sub send_cookie {

  my ($key,$value,$expires,$domain) = @_;
  if ($expires ne "") {
      print "Set-Cookie: $key=$value; expires=$expires; path=/; \n";
   }
   else {
      print "Set-Cookie: $key=$value; path=/; \n";
   }

}


1;
