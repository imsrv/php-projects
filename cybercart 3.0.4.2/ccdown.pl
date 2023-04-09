print "HTTP/1.0 200 OK\n";
#
# CyberCart Pro Internet Commerce System, Version 3.04
# Copyright 1997, Richard Torzynski
# 1-25-98
# All rights reserved
# This is NOT a shareware script.
# Download script for CyberCart

# Merchant root directory
$merchant_data = "c:\\Merchant";

# URL of this script
$dl_url = "http://www.name.com/cgi-bin/ccdown.pl";

# URL of the CyberCart download HTML page
$dl_html = "http://www.name.com/ccdown.html";

# How long to retain the filelist files
$expire_time = 2;

# Make sure to include the mimetype for the type of files
# available for download.
%mimetypes = (
   'pdf' => 'application/pdf',
   'jpg' => 'image/jpeg',
   'doc' => 'application/msword'
);

#
##################################################################

&decode2;

%cookies = split('[;=] *',$ENV{'HTTP_COOKIE'});

if ($ENV{'PATH_INFO'} =~ m/\+/) {
  ($merchant,$session_id,$filename) = split(/\+/,$ENV{'PATH_INFO'});

  # take off any unnecessary pathinfo
  $merchant =~ s/^\/[\w]*ccdown.pl//;

  $dl_file_path = $merchant_data . "$merchant\\Files\\$filename";
  $dl_list = $merchant_data . "$merchant\\Data\\$session_id" . ".files";

  # Check for old filelist
  &cleanup;

  if (-s $dl_list) {
    open(LIST, "<$dl_list") || &no_order;
    while (<LIST>) {
      chop;
      if ($filename eq $_) {
        $found = 1;
        last;
      }
    }
    close(LIST);
    if (!$found) {
      &no_sale;
    }
  } else {
    &no_such_order;
  }

  if (-s $dl_file_path) {
    ($prefix,$ext) = split(/\./,$filename);
    $ENV{'PATH_INFO'} = $filename;
    print "Content-type: $mimetypes{$ext}\n\n";
    open(FILE, "<$dl_file_path");
    while (<FILE>) {
      print "$_";
    }
    exit;
  } else {
    print "Content-type: text/html\n\n";
    print "<h1>File Not Found</h1>";
    print "$dl_file_path";
    exit;
  }
} elsif ($post_query{'merchant'} && $post_query{'session_id'}) {
  $merchant = $post_query{'merchant'};
  $session_id = $post_query{'session_id'};
  &show_files;
} else {
  print "Content-type: text/html\n\n";
  &unknown; 
}
  
exit;    

sub unknown {

print qq[<html>
<body>
<h1>CyberCart Download Error</h1>
Your reference to the CyberCart Download Script is incorrect.  Please
return to your merchant's homepage or email the merchant for information
on retrieving your files.
</body>
</html>
];
}

sub show_files {
  
$dl_file_path = $merchant_data . "\\$merchant\\Data\\" . $session_id . ".files";
if (-s $dl_file_path) {
  print "Content-type: text/html\n\n";
  print qq[<html>
<body>
<h1>Order \#$session_id - Download Files</h1>
To download your files, click on the link(s) below to download.
<p>
File(s) to download:<br>
<ol>
  ];
  open(LIST, "<$dl_file_path") || &no_order;
  while(<LIST>) {
    chop;
    if ($_ =~ m/[\w]*\.[\w]*/i)  {
      print "<li><a href=$dl_url/$merchant\+$session_id\+$_>$_</a>";
    }
  }
  print "</ol></body></html>";
} else {
  &no_order;
}

}

sub no_order {
  
print "Content-type: text/html\n\n";
print qq[<html>
<body>
<h1>No Order</h1>
No such order number found.
];
exit;
}


sub no_sale {
print "Content-type: text/html\n\n";
print qq[<html>
<body>
<h1>File Not Part of Order</h1>
The file requested is not part of the order.
$f</body>
</html>
];
exit;
}

sub no_such_order {
print "Content-type: text/html\n\n";
print qq[<html>
<body>
<h1>No Such Order</h1>
There is no files for order \#$session_id.
</body>
</html>
];
exit;
}

sub cleanup {
#Open merchant temp directory, delete files older than 2 days
$dl_file_dir = $merchant_data . "$merchant\\Files\\";

opendir(ORD, "$dl_file_dir") || &error("cant open $dl_file_dir in sub cleanup.");
while ($name = readdir(ORD)) {
  if ($name =~ m/files/) {
    $name = $order_dir . "\\$name";
    if (-M $name > $expire_time) {
      unlink($name);
    }
  } #close if
}  #close while
close(ORD);
}
# End Cleanup
#---------------------------------------------------------------

sub error {

my $message = $_[0];

print "Content-type: text/html\n\n";
print "<html><body>";
print "<h1>CyberCart Error</h1>";
print "$message";
print "</body></html>";

exit;
}

sub decode2 {
if ($ENV{'REQUEST_METHOD'} eq 'GET') {
  @pairs = split(/&/, $ENV{'QUERY_STRING'});
} elsif ($ENV{'REQUEST_METHOD'} eq 'POST') {
  read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
  @pairs = split(/&/, $buffer);
}
# print "Content-type: text/html\n\n";

foreach $pair (@pairs) {
  ($name, $value) = split(/=/, $pair);
  $name =~ tr/+/ /;
  $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

  $value =~ tr/+/ /;
  $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

  # Take care of server side includes
  $value =~ s/<!--(.|\n)*-->//g;

  # Taint check
  $value =~ m/([\w+@\-\_\|\:\/\\+=\. \!\~]*)/i;
  # $post_query{$name} = $value;
  $post_query{$name} = $1;
}
}
# End sub decode2
#----------------------------------------------------#

sub debug {

print "Content-type: text/html\n\n";
foreach $key (keys %cookies) {
  print "$key = $cookies{$key}<br>";
}
print "dl_file_path = $dl_file_path<br>";
print "dl_list = $dl_list<br>";
print "PATH_INFO = $ENV{'PATH_INFO'}<br>";
print "merchant = $merchant<br>";
print "session_id = $session_id<br>";
exit;
}
