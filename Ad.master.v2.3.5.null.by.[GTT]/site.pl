use IO::Socket;

sub parse_form {
    use CGI;
    my $q = new CGI();
    my ($l, %FORM);
    my @list = $q->all_parameters();
    for $l (@list) {
      my @a = $q->param($l);
      if ($#a == 0) {
        $FORM{$l} = $q->param($l);
      } else {
        $FORM{$l} = join "\t", $q->param($l);
      }
    }
    return %FORM;
}

sub s_q {
  my $t = shift;
  $t =~ s/\"/&quot;/igms;
  return $t;
}

sub parse_get {
    my %FORM;
    my ($request_method, $query_string, @key_value_pairs, $key, $value, $key_value);

    $request_method = $ENV{'REQUEST_METHOD'};
    if ($request_method eq "GET") {
        $query_string = $ENV{'QUERY_STRING'};
    } else {
	exit;
        read (STDIN, $query_string, $ENV{'CONTENT_LENGTH'});
    }

    @key_value_pairs = split (/&/, $query_string);
    foreach $key_value (@key_value_pairs) {
        ($key, $value) = split (/=/, $key_value);
        $key =~ tr/+/ /;
        $key =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;
        $value =~ tr/+/ /;
        $value =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;
	if (exists($FORM{$key})) {
	  $FORM{$key} .= "\t$value";
        } else {
          $FORM{$key} = $value;
        }
    }
    return %FORM;
}



sub parse_cookie {
    my %FORM;
    my (@key_value_pairs, $key, $value, $key_value);

    @key_value_pairs = split (/;\s*/, $ENV{HTTP_COOKIE});
    foreach $key_value (@key_value_pairs) {
        ($key, $value) = split (/=/, $key_value);
        $value =~ tr/+/ /;
        $value =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;
        $FORM{$key} = $value;
    }
    return %FORM;
}



sub getDoc {
  my ($in) = @_;
  $in =~ s/http:\/\///g;
  my ($server, $page) = split /\//, $in, 2;
  my ($auth, $soc, $get, $sentBytes, @doc, $doc, $getBytes);
  my ($head, $body);
  $soc = IO::Socket::INET->new( PeerAddr => "$server", 
                                PeerPort => 80,
                                Proto => 'tcp',
                                Type => SOCK_STREAM) or print $!;
  return if (!$soc);
  $get = "GET /$page HTTP/1.0\nAccept: */*\nAccept-Language: en-us\nUser-Agent: Mozilla/4.0 (compatible; MSIE 5.0; Windows 98; DigExt)\n".$auth."Host: $server\n\n";
  print $soc $get;

  @doc = <$soc>;
  close $soc;
  $doc = join '', @doc;
  ($head, $body) = split "\r*\n\r*\n", $doc, 2;
  return $body;
}


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
  $post_data = $param;
  $l = length($post_data);

  $post = "POST /$doc HTTP/1.0
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

1;
