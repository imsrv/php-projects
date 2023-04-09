<?

define('SMC_VERSION', '1.0.0a');
define('SMC_DIR', str_replace("\\", '/', getcwd()).'/');

// database options
$db_types = array (
    'mysql' => 'MySQL',
    'mssql' => 'Microsoft SQL'
);
$db_type = 'mysql';
$db_host = 'localhost';
$db_name = 'smc';
$db_user = 'root';
$db_pass = '';
$db_tables = array();
$db_version = 'N/A';

$ini_filename = 'smc.ini';
$dir_plugins = './plugin';

$listen_address = 'localhost:10000';
$mud_address = 'localhost:4000';
$connect_to_mud = 1;
$allowed_ip = '*.*.*.*';
$password = '';
$mud_connected = false; // connection to mud flag
$client_connected = false; // connection to client flag

$script_prefix = '';
$cmd_prefix = '!';
$cmd_quite = '@';
$cmd_delimiter = '#';
$cmd_color = 'gray';

$text_color = 'silver';
$profile_extension = 'cmd';
$default_profile = 'default';

$colors_a  = array (
    "\x1B[1;30m"=>"gray",
    "\x1B[1;31m"=>"red",
    "\x1B[1;32m"=>"lime",
    "\x1B[1;33m"=>"yellow",
    "\x1B[1;34m"=>"blue",
    "\x1B[1;35m"=>"fuchsia",
    "\x1B[1;36m"=>"cyan",
    "\x1B[1;37m"=>"white",
    "\x1B[0;30m"=>"black",
    "\x1B[0;31m"=>"maroon",
    "\x1B[0;32m"=>"green",
    "\x1B[0;33m"=>"olive",
    "\x1B[0;34m"=>"navy",
    "\x1B[0;35m"=>"purple",
    "\x1B[0;36m"=>"teal",
    "\x1B[0;37m"=>"silver",
    "\x1B[0m"=>$text_color
);
$colors_c = array_flip($colors_a);
$colors_c['default'] = $colors_c[$text_color];

$profile = $default_profile;
$log = '';
$out = '';
$processing_out = 0;

$logfile = '';
$logformat = '';
$log_input = 1;
$log_html_header = '<html><body style="background: black; color: silver; font-family: Fixedsys; font-size: 8pt">';
$log_html_footer = '</body></html>';
$maxlogsize = 1000000;


$block = '';
$freg = 'ereg';
$brackets = '{}';
$varformat = '\$[A-Za-z0-9_]+';
$varnameformat = '[A-Za-z0-9_]+';
$varvalue = '.+';
$parsed_str = ''; // holder of matched string after parse_str_vars()
$float_format = '%2.0f';
$ansi_format = "\x1B[(0,1);[0-9]+m";
$modes['quite'] = 0;
$modes['verbatium'] = 0;
$modes['gag'] = 0;
$prompt = '';
$flprompt = false;

$commands = array();
$vars = array();
$aliases = array();
$highlights = array();
$triggers = array();
$actions = array();
$subs = array();
$gags = array();
$funcs = array();
$plugins = array();

$ignore = array (
    'hls'       => 0,
    'triggers'  => 0,
    'actions'   => 0,
    'subs'      => 0,
    'gags'      => 0
);

function ini_var($vname) {
    global $ini;
    if (isset($ini[$vname]) and isset($GLOBALS[$vname])) {
        eval("\$l = \"$ini[$vname]\";");
        $GLOBALS[$vname] = $l;
    }
}

    $ini = @parse_ini_file($ini_filename, true);
    //print_r($ini);
    foreach ($ini as $n => $v) ini_var($n);
    $plugins = array();
    if (is_array($ini['plugins']))
    foreach ($ini['plugins'] as $plugname => $fname) {
        $fname = "$dir_plugins/$fname";
        if (file_exists($fname) and !array_key_exists($plugname, $plugins)) {
            include_once($fname);
            $plugins[$plugname] = $fname;
        }
    }
    unset($ini);
    //echo "$ansi_format\n";
    //echo "$varformat, $varvalue, $freg";
    //exit;

?>