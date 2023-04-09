## Select British ("") or US ("1") date pattern ----------------#
$dtUS = "";

## An array of accepted referers domain names / IP#s -----------#
@referers = ('www.yourdomain.nme','yourdomain.nme');

## Path to Records and Programs, SEE readme.txt file -----------#
$mailprog = '/usr/sbin/sendmail';
$gmt_pth = 'sets/gmtset.pl';
$cnfg_pth = 'sets/elistset.pl';
$admin_pth = "elistdat/";	# KEEP end forward-slash!
$xport_pth = "export/";		# KEEP end forward-slash!
$aux_pth = "work/";			# KEEP end forward-slash!
$wbmstr_notify = '1';
$theword = 'boo';
$bitword = ".j";		# TWO letters and/or numbers and/or "." or "/" ....$theword seed

# Accepted mail-lists file name:description ( set readme )------#
 	@alwFiles = ('0:list1:Test Form One:1');

# DEFAULT Webmasters Address AND Name---(note ":" divider)------#
	$webmstr = 'webmaster@yourdomain.nme:List Editor';

# URL of the ELISTS.CGI script --------program------------------#
	$prog_url = "http://www.yourdomain.nme/cgi-bin/elists.cgi";

# URL of the ELISTADM.CGI script ------admin--------------------#
	$admn_url = "http://www.yourdomain.nme/cgi-bin/elistadm.cgi";

# URL of the ELC.CGI script ---for mail confirm option----------#
	$cnfm_url = "http://www.yourdomain.nme/cgi-bin/elc.cgi";

# URL of the ELOAD.CGI script -------admin----see readme--------#
	$uload_url = "http://www.yourdomain.nme/cgi-bin/eload.cgi";

# URL of the DEFAULT return page (Home)-------------------------#
	$hm_url = "http://www.yourdomain.nme/";

# URL of the webmasters page ( form for Admin access )----------#
	$wmsta_url = "http://www.yourdomain.nme/webmster.html";

# <<-----E-Lists/ListMerge/ennyForms/VizBook compatability----->>

## PATH to the directory that lists are saved in ---------------#
	$listDir = "maillists/";	# KEEP end forward-slash!
## Mail Lists FILE NAME Extension ------------------------------# 
	$list_exten = ".elf";
## Field separator (default is comma "," ("|"=pipe,"\t"=tab) ---#
	$sep = ",";

1;	# this line MUST remain in all 'require' files.
