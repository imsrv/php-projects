<?
//+----------------------------------
//	AnnoucementX
//	Version: 1.0
//	Author: Cat
//	Created: 2004/10/22
//	Updated: 10/12/2005
//+----------------------------------

// Let's define the ROOT folder

define ('ROOT','');

// Errors and magic quotes

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

$index=true; // A security thingy that prevents users from accessing script files ;)

// Special Bug Fix, added in v.1.1:

if (phpversion() >= "4.2.0") {

	@ $step = $_GET['step'];
	@ $do = $_GET['do'];
	@ $who = $_GET['who'];
	@ $what = $_GET['what'];
	@ $category = $_GET['category'];
	@ $post = $_GET['post'];
	@ $poster = $_GET['poster'];

}

// And include some files we strongly need :D

require ("./conf_global.php");
require ("./sources/main_functions.php");
require ("./sources/error_functions.php");

//-----------
// Let's define some values for our beloved database, ok?
//-----------

define ('USER',$username_file);
define ('PASS',$password_file);
define ('DATA',$database_file);
define ('HOST',$host_file);

//-----------
// So, what about our classes and title?
//-----------

$errors=new ERRFUNC;
$functions=new FUNC;
$functions->do_title();

//Main Section


	session_start(); // Handles the sessions stuff ;)
	
	// While we login we checked remember?
	
	if ($ce == 1) {
	
		$functions->give_a_cookie($uc,$up);	
	
	}
	
$used_skin='';
$used_css='';
$functions->get_skin(); // Handles the skin stuff ;)

// Are we online or offline??? Let's check!

	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	$app_check_qr="SELECT Value FROM config WHERE Name='Application'";
	$app_check_run=mysql_query($app_check_qr) or die ('AnnouncementX Error: ' . mysql_error());
	$offline_msg_qr=mysql_query("SELECT Value FROM config WHERE Name='Offline_message'");
	$offline_msg=mysql_fetch_row($offline_msg_qr);
	$app_check_result=mysql_fetch_row($app_check_run);
	mysql_close($link);
	
	if ($app_check_result[0] == 'Off') {
	echo $offline_msg[0];
	exit;
	}

//-----------
// Here we manage our username and password,
// if we're logged in...
//-----------

if (isset($_COOKIE['a_username'], $_COOKIE['a_password']) && $_COOKIE['a_username']!='' && $_SESSION['username']=='') {

	$_SESSION['username']=$_COOKIE['a_username'];
	$_SESSION['password']=$_COOKIE['a_password'];
	$GLOBALS['username']=$_SESSION['username'];
	$GLOBALS['password']=$_SESSION['password'];
	
} elseif (isset($_SESSION['username'],$_SESSION['password']) && $_SESSION['username']!='') {

	$GLOBALS['username']=$_SESSION['username'];
	$GLOBALS['password']=$_SESSION['password'];

} else {

}

$username=$GLOBALS['username'];
$password=$GLOBALS['password'];

// EasyDeBug Module - Enable if u want your members to view their username/password at the top of each page when they're logged in
// For advanced debugging you the debug_mode stuff, it's right after the EasyDeBug ;)

/*
if (isset($username,$password)) {

	echo "Your username is: $username<br />Your password is: $password";
	
}
*/

// OK, now our main switch, hope it'll work this time :)

// DEBUG Thingy, Important for testing :)
// To use it just add the folowing to the address bar: &debug=1

if ($debug == 1) {

	$functions->debug_mode(); // It's still in development, so, it's not recommended to use it because it just will not work ;P
	
}

// Finish of DEBUG Section

switch ($do) {

case "login":

	/*$remember=$_POST['remember'];

	if ($remember==1) {
	
		$user=$_POST['user'];
		$pass=$_POST['pass'];

		setcookie('a_username',$user,time()+60*60*24*100);
		setcookie('a_password',$pass,time()+60*60*24*100);
	
	} else {

	}*/
		
	include("./Skin".$used_skin."login.php");
	
	$template=new LOGIN;
	
	$template->go_switch($step);
	
	$functions->do_copyright();
	
	$functions->do_bottom();
	
break;

case "logout":

	if (isset($_COOKIE['a_username'],$_COOKIE['a_password']) && $_COOKIE['a_username']!='') {
	
		setcookie('a_username','',time()-3600);
		setcookie('a_password','',time()-3600);
	
	}

	$functions->do_header_logout();
	
	$functions->do_script($form_name='logout');
		
	include("./Skin".$used_skin."logout.php");
	
	$template=new LogOut;
	
	$template->LogOut();
	
	$functions->do_bottom();
	
break;

case "register":

	$functions->do_header_reg();
	
	$functions->do_script('register');
	
	include("./Skin".$used_skin."register.php");
	
	$template=new Register;
	
	$template->go_switch($step);
	
	$functions->do_copyright();
	
	$functions->do_bottom();
	
break;

case "pm":
	
	$functions->do_header_pm();
	
	$functions->do_script('pm');
	
	include("./Skin".$used_skin."pm.php");
	
	$template=new pms;
	
	$template->go_switch($step);

	$functions->do_copyright();

	$functions->do_bottom();
	
break;

case "profile":
	$functions->do_login_check();
	
	$functions->do_header_prof();

	$functions->do_script('profile');
	
	if (isset($username,$password) && $username!='') {
	
	$functions->do_private_messages($username,$password);
	
	}
	
	include(ROOT."./Skin".$used_skin."profile.php");
	
	$template=new Profile;
	
	$template->go_switch($step);
	
	$functions->do_copyright();
	
	$functions->do_bottom();
	
break;

case "show":
	
	$jumper_id=$_POST['forums'];
	
	if (isset($jumper_id)) {
	
	$category=$jumper_id;
	
	}

	$functions->do_login_check();
	
	$functions->do_header_show();
	
	$functions->do_script('show');
	
	if (isset($username,$password) && $username!='') {
	
	$functions->do_private_messages($username,$password);
	
	}
	
	include (ROOT."./Skin".$used_skin."show.php");
	
	$template=new Show;
	
	$template->do_show_category($category);
	
	$functions->do_copyright();
	
	$functions->do_bottom();
break;

case "replies":
	
	$functions->do_header_show();
	
	$functions->do_script('replies');
	
	if (isset($username,$password) && $username!='') {
	
	$functions->do_private_messages($username,$password);
	
	}
	
	include ("./Skin".$used_skin."replies.php");
	
	$template=new Replies;
	
	$template->go_switch($step);
	
	$functions->do_copyright();
	
	$functions->do_bottom();
	
break;

case "search":

	$functions->do_header_search();
	
	if (isset($username,$password) && $username!='') {
	
		$functions->do_private_messages($username,$password);
	
	}
	
	include ("./Skin".$used_skin."search.php");
	
	$template=new Search;
	
	$template->go_switch($step);
	
	$functions->do_copyright();
	
	$functions->do_bottom();

break;

case "admin":

	$functions->do_header_index();
		
		$url='./admin';
		
	$functions->do_redirect($url);
	
	$functions->do_copyright();
	
	$functions->do_bottom();
	
break;

case "bbcode_help":

	$functions->do_header_index();
	
	$functions->bbcode_reference();
	
	$functions->do_bottom();

break;

default:
	
	$functions->do_header_index();
	
	if (isset($username,$password) && $username!='') {
	
		$functions->do_private_messages($username,$password);
		
	}
	
	include("./Skin".$used_skin."board_2.php");
	
	$template=new BOARD;
	
	$template->show_board();
	
	$functions->do_copyright();
	
	$functions->do_bottom();
break;

}

?>
