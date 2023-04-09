#### Select British ("") or US ("1") date pattern ---------------#
$dtUS = "";

## An array of accepted referers domain names / IP#s ------------#
@referers = ('www.yourdomain.name','yourdomain.name');

## data and sendmail paths , SEE readme.txt file ----------------#
$mailprog = "/usr/sbin/sendmail";
$adminword_pth = "mrglists/mrgml.pw";
$cnfg_pth = "sets/lmrgeset.pl";
$gmt_pth = "sets/gmtset.pl";
$mrgdatdir_pth = "mrglists";
$deflt_mail = 'you@yourdomain.name';

## URL of your prefered return page (Home)-----------------------#
	$hm_url = "http://www.yourdomain.name/webmster.html";

## URL of the MRGMAIL.CGI script --------------------------------#
	$theScrpt = "http://www.yourdomain.name/cgi-bin/lstmrge.cgi";

## Enter Accessword, SEE readme.txt file ------------------------#
	$theword = "accessword";

## text e-mails ISO character (change ONLY BETWEEN quotes) ------#
	$ISO = 'charset="iso-8859-1"';

## Copied List delimiters ( ","=comma "|"=pipe,"\t"=tab, "``"=double backticks )
## $sep (see below) is the default for personalising - rest will be address only!
	@seps = ("|",",","\t","``");
	
# -----------E-Lists/ListMerge/ennyForms compatability variables----------------

# Path to the mail lists directory (default = relative) NOTE: NO closing "/"
	$edat_path = "maillists";
# File Name Extension(s) added to each list name. (multiple allowed, "|" separated)
	$elst_exten = ".elf|.txt|.mfl";
# Field separator (default comma="," ("|"=pipe,"\t"=tab) FOR ALL ADDRESS OPTIONS 
	$sep = ",";

1;	# this line MUST remain in all 'require' files.
