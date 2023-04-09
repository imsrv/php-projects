# System Paths
$path = '/home/user/public_html/cgi-bin/rankmaster';
$membpath = '/home/user/public_html/cgi-bin/rankmaster/members';
$tmplpath = '/home/user/public_html/cgi-bin/rankmaster/templates';

# URLs
$scripturl = 'http://www.mywebsite.com/cgi-bin/rankmaster';
$flagsurl = 'http://www.mywebsite.com/cgi-bin/rankmaster/flags';
$voteimg = 'http://www.mywebsite.com/cgi-bin/rankmaster/rankpic01.gif';
$gainimg = 'http://www.mywebsite.com/cgi-bin/rankmaster/green_arrow_1.gif';
$lostimg = 'http://www.mywebsite.com/cgi-bin/rankmaster/red_arrow_1.gif';
$nochangeimg = 'http://www.mywebsite.com/cgi-bin/rankmaster/blue_dot.gif';

# E-Mail Options
$mailprog = '/usr/sbin/sendmail';
$adminemail = 'admin@mywebsite.com';
$regadmin = '0';
$newuseremail = '0';
$newusersubject = 'Top Sites Registration';
$newusertext = 'Dear [name],

Thank you for registering with Top Sites.
Your site ID is [id] and your password is [pass]. Please keep these in safe place as your will need them for member area access.
You can add the following HTML code to your website so that your visitors could vote for you:

<!-------START VOTING HTML CODE------->
[boxcode]
<!-------END VOTING HTML CODE------->


Sincerely,

Top Sites Administration';

# Security Options
$refercheck = '0';
$emailcheck = '0';
$badwords = '';

# Logging/Update Options
$iptimelbl = 1;
$iptimemult = 86400;
$iptime = 86400;
$updtimelbl = 30;
$updtimemult = 60;
$updtime = 1800;
$restimelbl = 30;
$restimemult = 86400;
$restime = 2592000;
$idletimelbl = 10;
$idletimemult = 86400;
$idletime = 864000;
$idleshow = '1';
$usecrontab = '0';

# Date and Time
$dateformat = '1';
$timeformat = '2';
$timeoffset = '0';
$timezone = '';

# Display Options
$fontname = 'Arial, Helvetica, sans-serif';
$fontsize = '-1';
$sfontname = 'Arial, Helvetica, sans-serif';
$sfontsize = '-2';
$tablewidth = '500';
$headcolor = '#F4E8EF';
$primcolor = '#F4F4FF';
$seconcolor = '#E8E8FF';
$showboxlink = '1';
$showimglink = '1';
$showtxtlink = '1';

# Top List options
$sitesperpage = 10;
$topsort = 'score'; # in/out/hits/votes/rating/score
$topwidth = '700';
$topheadcolor = '#F4E8EF';
$topprimcolor = '#F4F4FF';
$topseconcolor = '#E8E8FF';
$topborder = '1';
$topbordercolor = 'black';
$topspacing = '1';
$toppadding = '3';
$showimgindicator = '1';
$showtxtindicator = '1';
$showflag = '1';
$showrateit = '1';
$showin = '1';
$showout = '1';
$showhits = '1';
$showvotes = '1';
$showrating = '1';
$showscore = '1';
$gaincolor = 'green';
$lostcolor = 'red';
$nochangecolor = 'blue';

1; # Do not remove this line