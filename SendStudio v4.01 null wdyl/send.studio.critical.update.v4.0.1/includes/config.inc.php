<?

ERROR_REPORTING(E_ALL);

$IsSetup = 0;

$DBHOST="";
$DBUSER="";
$DBPASS="";
$DBNAME="";
$TABLEPREFIX="";

$ROOTURL="";
$ROOTDIR="";

$LicenseKey="000";
$ShowInfoTips=1;
$AutoArchive=1;

$SYSTEMTYPE="L";
$LOGINDURATION=7200;
$SYSTEMTIME=time();
$DateFormat="j M Y";
$ImageFileSizeLimit=1000000;

@mysql_connect($DBHOST, $DBUSER,$DBPASS);
@mysql_select_db($DBNAME);

$FIELDTYPES["shorttext"]="One Line Textbox";
$FIELDTYPES["longtext"]="Multiline Textbox";
$FIELDTYPES["dropdown"]="Dropdown List";
$FIELDTYPES["checkbox"]="Checkbox (Yes/No)";

$DIRSLASH='/';

function DisplayDate($Date){
GLOBAL $DateFormat;
return date($DateFormat, $Date);
}

?>