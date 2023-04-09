<?

if (ereg( 'MSIE ([0-9].[0-9]{1,2})',$HTTP_USER_AGENT,$log_version)) {
        $agent_ver=$log_version[1];
        $agent='MSIE';

} elseif (ereg( 'Opera ([0-9].[0-9]{1,2})',$HTTP_USER_AGENT,$log_version)) {
        $agent_ver=$log_version[1];
        $agent='Opera';

} elseif (ereg( 'Mozilla/([0-9].[0-9]{1,2})',$HTTP_USER_AGENT,$log_version)) {
        $agent_ver=$log_version[1];
        $agent='Mozilla';

} else {
        $agent_ver='';
        $agent='Unknown';

}



if (strstr($HTTP_USER_AGENT,'Win')) {
        $os='Win';

} else if (strstr($HTTP_USER_AGENT,'Mac')) {
        $os='Mac';

} else if (strstr($HTTP_USER_AGENT,'Linux')) {
        $os='Linux';

} else if (strstr($HTTP_USER_AGENT,'Unix')) {
        $os='Unix';

} else {
        $os='Other';

}

?>