use vars qw($dupviewtime $dupclicktime $maxbannersize $vars_server_url $vars_path_to_sendmail
	@ignoreIP $vars_path_to_images $vars_path_to_images_shell);

$dupviewtime = 0;
$dupclicktime = 0;
$maxbannersize = 60;
@ignoreIP = ();
$vars_server_url = "#server_path#";
$vars_path_to_sendmail = '/usr/sbin/sendmail -t -oi 1>/dev/null 2>/dev/null';
$vars_path_to_images = "http://yoursitename.com/ad_master/i/";
$vars_path_to_images_shell = "/usr/home/yoursitename_com/htdocs/ad_master/i/";
