#!/usr/bin/perl

#use CGI::Carp 'fatalsToBrowser';
use CGI; $q = new CGI;
use LWP;
use lib qw(./lib);
use IPC::Shareable;
$domains = $q->param('domains');
$|++;
print $q->header;

$use_IPC = 1; # much faster, but taxes server more...(1 for on, 0 for off)
$max_domains = 3;

# EDIT THE HASH BELOW TO ADD/EDIT/DELETE SEARCH ENGINES

my %engines = (	"AllTheWeb" 	=> [	"http://www.alltheweb.com/search",						# URL TO SEARCH ENGINE
					"GET",										# REQUEST METHOD (POST,GET)
					"?cat=web&cs=utf-8&q=%2Bsite%3A<domain>+%2Burl.all%3A<domain>&_sb_lang=en",	# ATTACHED VARIABLES <domain> replaced by the domains
					"<span class=\"ofSoMany\">([0-9,]*)<\/span>  Results"				# REGEX TO SEARCH FOR
			       	   ],
		
		"AltaVista" 	=> [	"http://www.altavista.com/web/results",		
					"GET",							
					"q=host%3A<domain>+url%3A<domain>&kgs=0&kls=1&avkw=aapt",		
					"AltaVista found ([0-9,]*) results"
			           ],
		
		"Teoma" 	=> [	"http://s.teoma.com/search",		
					"GET",							
					"q=<domain>+site%3a<domain>&qsrc=23&nw=False&u=10",		
					"of about ([0-9,]*):</span>"				
			           ],


		"Google" 	=> [	"http://www.google.com/search",		
					"GET",							
					"hl=en&lr=&ie=ISO-8859-1&safe=off&q=site%3A<domain>+inurl%3A<domain>",		
					"of about <b>([0-9,]*)</b>.   Search"				
			           ],

	     	"HotBot"  	=> [	"http://www.hotbot.com/adv.asp",		
					"GET",							
					"prov=HotBot&query=*&loc=searchbox&tab=web&dfi=<domain>&wfc=2&dateop=after",		
					"of ([0-9,]*).<\/div><!-- RESULTS -->"			
			           ],
			           
		"MSN" 		=> [	"http://search.msn.com/advresults.aspx",		
					"GET",							
					"q=<domain>&FORM=SMCA&adv_f=all&adv_sort=&adv_rgn=&adv_lng=&adv_dom=<domain>&adv_depth=&adv_dt=html&adv_dt=pdf&adv_dt=ppt&adv_dt=msword&adv_dt=xl&adv_cf=",		
					"of about ([0-9,]*) containing"
			           ]
	   );
	   
## EDIT THE BELOW HTML TO CHANGE THE SUBMISSION FORM	   

if (!$domains) {
print<<EOF;
<html>
<head>
<title>Search Engine Saturation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="400" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#999999">
  <tr bgcolor="#CCCCCC"> 
    <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Search Engine Saturation Analyzer</strong></font></div></td>
  </tr>
  <tr bgcolor="#F3F3F3"> 
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Search engine saturation 
      is a count of the number of your web pages that are stored in each search engine. 
      This is determined by analyzing the search results from six of the most 
      popular search engines.</font></td>
  </tr>
  <tr bgcolor="#F3F3F3"> 
    <td><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Single 
      Site Search:</font></strong> <br>
      <form action="linksat.cgi" method="post" name="" id="">
        <table width="292" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr> 
            <td width="151" height="48" valign="top"> <div align="left"> 
                <input type=text size=40 name=domains>
                <font size="1" face="Verdana, Arial, Helvetica, sans-serif">www.yourdomain.com 
                </font></div></td>
            <td width="141" valign="top"><input name="submit" type=submit value="Submit"></td>
          </tr>
        </table>
      </form>
      
    </td>
  </tr>
  <tr bgcolor="#F3F3F3">
    <td><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Multiple 
      Site Search:<br>
      </font></strong>
      <form action=linksat.cgi method=post>
        <div align="center">
          <table width="156" border="0" cellpadding="5" cellspacing="0">
            <tr> 
              <td nowrap><p> 
                  <textarea name="domains" cols="30" rows="5" id="domains"></textarea><br>
                  <font size="1" face="Verdana, Arial, Helvetica, sans-serif">www.yourdomain.com&nbsp;&nbsp;&nbsp;&nbsp;<br>
                  www.nextdomain.com<br>
                  </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Put a single domain on each line</font></td><td valign="top"><div align="right"> 
                  <input name="submit2" type=submit value="Submit">
                </div></td>
            </tr>
          </table>
          
        </div>
      </form>
      
    </td>
  </tr>
</table>
</body>
</html>

EOF
exit;
}

(@domains) = split (/\r\n/, $domains);
@domains = splice (@domains, 0, $max_domains);

if ($use_IPC) {
 my $glue = 'test';
 my %options = (
     create    => 1,
     exclusive => 0,
     mode      => 0644,
     destroy   => 1,
     size      => 2000,
 );

tie %results, 'IPC::Shareable', $glue, { %options } or die "server: tie failed\n";
}

print<<EOF;
<html>
<title>Search Engine Saturation</title>
<head>
<style>
A {
	COLOR: #004080; TEXT-DECORATION: none; FONT-WEIGHT: bold;
}
A:hover {
	COLOR: #000000; TEXT-DECORATION: none;
}
</style>
</head>
<body>
<Span id=txt><font face=verdana,arial size=2><center>Please wait while we fetch the results...<br>
EOF

foreach $domain (@domains) {
foreach $key (keys %engines) {
if ($use_IPC) {
	$i++; $t = "pid$i";
	unless( defined (${$t}=fork()) ){  die "fork failed $!"; }
	unless( ${$t} ){ 
		&doit;
	exit;
	}
} else { &doit; }
}
}
while ($z < $i) {
$z++; $t2 = "pid$z";
waitpid(${$t2}, 0);
}


print<<EOF;
</span>
<Script Langauge="JavaScript1.2">
txt.style.visibility = "hidden";
</script>
<center><font face=verdana,arial size=5><b><br>Search Engine Saturation Results</font><p><table><tr><td>
EOF

foreach $domain (@domains) {
$o++; if ($o % 2) { $bgcolor= "DFDFDF"; } else { $bgcolor = "F4F4F4"; }

print<<EOF;
<table width=100% cellpadding=5 cellspacing=0 border=0><tr bgcolor=$bgcolor>
<td width=100% valign=top><table cellpadding=2 cellspacing=0 border=0><tr><td nowrap><font face=verdana size=2><a href="http://$domain" target=new>$domain</a></td></tr></table></td>
EOF

foreach $key (keys %engines) {
$sum = $sum + $results{$domain}{$key};

$link = "$engines{$key}[0]\?$engines{$key}[2]";
$link =~ s/<domain>/$domain/ig;
if (!$results{$domain}{$key} && $results{$domain}{$key} ne "0") { 
$results{$domain}{$key}  = "retry";
}

1 while $results{$domain}{$key} =~ s/^([-+]?\d+)(\d{3})/$1\,$2/;
print<<EOF;
<td>
<table width=60><tr><td align=right nowrap>
<font face=verdana size=1>$key
</td></tr><tr><td align=right nowrap>
<font face=verdana size=1><a href="$link" target=new>$results{$domain}{$key}</a> 
</td></tr></table>
</td>
EOF
}

1 while $sum =~ s/^([-+]?\d+)(\d{3})/$1\,$2/;

print<<EOF;
<td>
<table width=75><tr><td align=right nowrap>
<font face=verdana size=1><b>Total</b>
</td></tr><tr><td align=right nowrap>
<font face=verdana size=1><b>$sum</b> 
</td></tr></table>
</td>
</tr></table>
EOF
$sum = 0;

}

print<<EOF;
</td></tr></table></center>
EOF

(%results)->remove;
IPC::Shareable->clean_up_all;
exit;




		sub doit {
		$engines{$key}[2] =~ s/<domain>/$domain/ig;
 		$ua = LWP::UserAgent->new;
 		$ua->timeout('10');
 		$ua->agent("Link Saturation/v1.0.0");
 		if ($engines{$key}[1] eq "GET") {
			$request = HTTP::Request->new(GET, "$engines{$key}[0]\?$engines{$key}[2]"); 
  		} else {
  			$request = HTTP::Request->new(POST, $engines{$key}[0]);
  			$request->content($engines{$key}[2]);
  			$request->content_type('application/x-www-form-urlencoded');
  			$request->referer("http://warez.tebe.net");
  		}
 		$response = $ua->request($request);
 		if ($response->is_success) {
 			$html = $response->content;
 			$html =~ m/$engines{$key}[3]/ig;
 			$temp = $1;
 			$temp =~ s/[^0-9]//g;
 			if (!$temp) { $temp = "0"; }
 			print ">";
 			$results{$domain}{$key}  = $temp;
 		} else {
 		        if ($tries < 3) { &doit; $tries++; exit; }
 		        else {
 			$results{$domain}{$key}  = "down";
 			}
 		}
 		}
