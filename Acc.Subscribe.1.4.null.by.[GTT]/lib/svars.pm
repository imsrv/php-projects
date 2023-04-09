use vars qw($vars_server_url $vars_path_to_sendmail
	$vars_path_to_images $vars_dns $vars_emails_on_page $vars_order $vars_password $vars_site_name);

$vars_server_url = "http://free/mmn/";
$vars_path_to_sendmail = '/usr/sbin/sendmail -t -oi 1>/dev/null 2>/dev/null';
$vars_path_to_images = "http://free/mmn/i/";
$vars_dns = '66.66.66.66';
$vars_emails_on_page = 20;
$vars_site_name = 'site name';
1;
