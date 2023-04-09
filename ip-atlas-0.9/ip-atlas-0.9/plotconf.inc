<?

# language
$language = "language.en.inc";

# earth images
# url path:name:width:height
# everything must be accurate!
$earthimages = array();
$earthimages[0] = "earth_620.jpg:Color:620:310";
$earthimages[1] = "earth_620_bw.jpg:Grayscale:620:310";

# which image out of those is the default?
$defaultimage = 0;

# css dots for netscape 4 users and systems without GD
# url path:name:width:height
$cssdots = array();
$cssdots[0] = "reddot.gif:Red 7x7:7:7";
$cssdots[1] = "yellowdot.gif:Yellow 7x7:7:7";
$defaultdot = 0;

# log entries? comment the line to disable.
$logging = "yes";

# path to the cookie
$cookiepath = "/";

# set $use_firewall to "1" if behind a proxy
$use_firewall="";
$firewall_host="localhost";
$firewall_port=3128;

?>
