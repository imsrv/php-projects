#!/usr/local/bin/perl
# --------------------------------------------------------

BEGIN {
    eval {
        print "HTTP/1.0 200 OK\n";
        print "Content-type: text/html\n\n";    
        
        require 5.004; 
        require "links.cfg";         # Change this to full path to links.cfg if you have problems.      
        unshift @INC, $db_lib_path;
        require "db_utils.pl";
        require "links.def";        
    };
    if ($@) { print "Error Loading System Libraries. Reason: $@"; die $@; }
}

# ========================================================
eval { &verify_links; };                    # Trap any fatal errors so the program hopefully 
$@  and &cgierr("Fatal error: $@");         # never produces that nasty 500 server error page.
exit;   
# ========================================================

sub verify_links {
# -----------------------------------------------------

    use strict;
    use vars qw(%urls %code %msg $method $db_url $db_key_pos $db_key $db_script_url $db_file_name);
    
    my $use_html = $ENV{'REQUEST_METHOD'};;
    my $start    = time(); my $start_t = localtime($start);

    if ($use_html) {
        print qq|
            <html><head><title>Links Manager: Verifying Links</title></head>
            <body bgcolor=#FFFFFF link="#000000" vlink="#000000" alink="#000000">
<table width=95% border="0" cellspacing="1" cellpadding="2" bgcolor="#000000" align="center">
<tr bgcolor="#A8D1FF"><td colspan=2>
                    <font face="verdana,arial,helvetica" size="2"><b>Verifying Links</b></font></td></tr>
<tr bgcolor="#F2F2F2"><td>
      <font face="verdana,arial,helvetica" size="2"><b>Link checking started at: $start_t</b></font><font face="verdana,arial,helvetica" size="1"><br><br>--------------------------------------------------------<br>|;
    }
    else {
        print "Link Checking started: $start_t<br>";
    }
    
# Try to init the Parallel User Checker.
    my ($checker, $slow, %ok_status, %fail_status);
    eval { require Validator; };
    if ($@) {
        print "Unable to load Parallel User Checker. System Error:<br>";
        print "--<br>";
        print "$@";
        print "--<br>";
        print "Using IO::Socket method instead.<br><br>";
        print "--------------------------------------------------------<br>";
        $slow++;
        %ok_status = (
              200, "OK 200",
              201, "CREATED 201",
              202, "Accepted 202",
              203, "Partial Information 203",
              204, "No Response 204",
        );

        %fail_status = (
              -1,  "Could not lookup server",
              -2,  "Could not open socket",
              -3,  "Could not bind socket",
              -4,  "Could not connect",
              301, "Found, but moved",
              302, "Found, but data resides under different URL (add a /)",
              303, "Method",
              304, "Not Modified",
              400, "Bad request",
              401, "Unauthorized",
              402, "PaymentRequired",
              403, "Forbidden",
              404, "File Not found",
              500, "Internal Error",
              501, "Not implemented",
              502, "Service temporarily overloaded",
              503, "Gateway timeout ",
              600, "Bad request",
              601, "Not implemented",
              602, "Connection failed (host not found?)",
              603, "Timed out",
        );      
    }
    else {
        $checker = new Validator;
# Using a proxy? You should have the environment variable HTTP_proxy set to your
# proxy server, or try manually by setting: 
#       $ENV{'HTTP_PROXY'} = "http://host";
        $checker->env_proxy();              # Set up any proxy settings from environment.   

# Please do not change the user agent.
        $checker->agent('Links - http://gossamer-threads.com/scripts/links/'); 
    
# Set some other options.   
        $checker->remember_failures(1);     # If it's bad once, it's bad.
        $checker->max_req(5);               # Tinker for performance. Number of requests to check in parallel.
        $checker->redirect(0);              # Should we follow redirects? Default is no.
        $checker->in_order(1);              # Keep the order.
        $checker->timeout(5);               # Number of seconds to wait.
        print "Registering URLs ... <br>";
    }

# Use HEAD for quick checks, GET for full checks.
    (($ENV{'QUERY_STRING'} eq 'detailed') or (@ARGV > -1 and $ARGV[0] eq 'detailed')) ? ($method = 'GET') : ($method = 'HEAD'); 

# Go through and register all the URL's.    
    my (@data, $total, $request, %seen, $status, $error, $url, $id);    
    open (DB, "<$db_file_name") or &cgierr("error in verify_links. unable to open db file: $db_file_name. Reason: $!");
    while (<DB>) {
        /^#/      and next;     # Skip comment Lines.
        /^\s*$/   and next;     # Skip blank lines.
        chomp;
        @data = &split_decode($_);
        if (($data[$db_url] =~ /^http/) or ($data[$db_url] =~ /^ftp/)) {
            my $id  = $data[$db_key_pos];
            my $url = $data[$db_url];       
            $seen{$url}++ and next;
            if ($slow) {
                ($status, $error) = &check_link ($url);
                $urls{$url} = $id;
                if (exists $ok_status{$status}) {
                    $use_html ?
                        print qq|<font size=1>Checked <a href="$url" target="_blank">$id</a> - Success ($status). Message: $ok_status{$status}. URL: $url<br></font>| :
                        print qq|Checked $id - Success ($status). Message: $ok_status{$status}<br>|;                  
                }
                else {
                    $error =~ s/\n//g;
                    $code{$url} = $status || 'unresolvable';
                    $msg{$url}  = $fail_status{$status} || $error;
                    if (exists $fail_status{$status}) {
                        $use_html ?
                            print qq|Checked <a href="$url" target="_blank">$id</a> - Request Failed ($status). Message: $fail_status{$status}. URL: $url\n| :
                            print qq|Checked $id - Request Failed ($status). Message: $fail_status{$status}. URL: $url\n|;              
                    }
                    else {
                        $use_html ?
                            print qq|Checked <a href="$url" target="_blank">$id</a> - Request Failed. Message: $error. URL: $url\n| :
                            print qq|Checked $id - Request Failed. Message: $error. URL: $url\n|;               
                    }
                }
                $total++;
            }
            else {
                $url = $checker->load ($url);
                $urls{$url} = $id;
                $total++;
                !($total % 100)  and print "$total ";
                !($total % 1000) and print "$total\n";          
            }
        }
    }
    close DB;

# All done registering. Now let's look them up!
    if (! $slow) {
        print "<br><b>Done.</b><br><br>Links to check '$total' using $method method. Please be patient... <br><br>";
        my $entries = $checker->wait(); # responses will be caught by on_return, etc
    }
    
# All done. Print out finish time and summary stats.
    my $finish  = time();
    my $elapsed = $finish - $start;
    print "<br>Took: $elapsed seconds to check $total links.\n";

    my ($code, $msg, $badcount);
    print "<br><br>Bad Link Summary<br>-----------------------------------------------<br>";
    foreach $url (sort { $code{$b} <=> $code{$a} } keys %code) {
        $code  = $code{$url};
        $msg   = $msg{$url};
        $id    = $urls{$url};       
        $use_html ?
            print qq~$id - <a href="$url" target="_blank">$url</a> <font face="verdana,arial,helvetica" size="1">[<a href="$db_script_url?db=links&modify_form=1&$db_key=$id&ww=1" target="_blank">modify</a>|<a href="$db_script_url?db=links&delete_form=1&$db_key=$id&ww=1" target="_blank">delete</a>]</font> : $code - $msg<br>~ :
            print qq~$id - $url : $code - $msg\n~;
        $badcount++;
    }
    print "-----------------------------------------------\n";
    print "<br>Good Links: ", $total - $badcount;
    print "<br>Bad Links : $badcount<br>";
      print "<br></font></td></tr>\n";
  print "\n</table></font>\n";
  print "\n<\/body><\/html>\n";
}

sub check_link {
# -----------------------------------------------------
# Check links without LWP.
#
    my ($url) = shift;
    my ($host, $port, $path, $sock, $line);

    ($url =~ m,^http://([^:/]+):?(\d*)(.*),i) and (($host, $port, $path) = ($1, $2, $3));
    $path ||= '/';
    $port ||= 80;
    $path =~ s/#.*//;

    $host or return undef, "Can't parse host from url: $url";   
    use IO::Socket;
    $sock = new IO::Socket::INET ( PeerAddr => $host,
                                   PeerPort => 80,
                                   Proto    => 'tcp',
                                   Type     => SOCK_STREAM ) or return undef, $@;
    print $sock "$method $path HTTP/1.0\n";
    print $sock "User-Agent: Links 2.0 (http://gossamer-threads.com/scripts/links/)\n\n";
    my $response = <$sock>;
    ($protocol, $status) = split / /, $response;
    while (defined ($line = <$sock>)) { }
    close ($sock);
    
    return $status;
}   