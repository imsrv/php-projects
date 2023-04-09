<?
// ------------------------------------------------------------------
// admin.php
// ------------------------------------------------------------------
require('./includes/common/shared.inc.php');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

//function adminMenu()
function adminMenu(){
  global $html;

	$html->define('menu', 'menu.htmlt');
	$html->extract('menu');

	// check safe_mode
	if (ini_get('safe_mode')) {
		$html->assign('max_execution_time',ini_get('max_execution_time'));
		$html->parse('safe_mode');
		}

	printPage('menu');
	}

 //function adminLogged()
 function adminLogged() {
  global $html;

	if (!$_SESSION['adminID'] || ($_SESSION[adminExpire]<time())) return 0;

	$html->assign('alias', $_SESSION[adminAlias]);
	$html->parse('logged');

	return 1;
 	}

 //function logAdmin()
 function logAdmin() {
  global $PARAM;
  global $html;

	//get the account file
	list($A_user, $A_pass) = file(get_Setting('AUTH_FILE'));

	if ((md5($PARAM['alias']) == trim($A_user))
		&& (md5($PARAM['password']) == trim($A_pass))) {

		// add details to session
		$_SESSION[adminID] = md5($PARAM['alias']);
		$_SESSION[adminAlias] = $PARAM['alias'];
		if(sessionExpire()) {
			$_SESSION[adminExpire] = time() + 0x0e10;
			}

		$html->assign('alias', $_SESSION[adminAlias]);
		$html->parse('logged');

		return 1;
		} else {
		$html->assign('old', $PARAM ['alias']);

		if (!$fp = @fopen (get_Setting('AUDIT_LOG'),'a')) {
			setLogAndStatus("Opening $adminLogFile", __FILE__, __LINE__);
			} else {
			fwrite ($fp, date('[l, j F Y, H.i:s] [B]')."\r\n");
			fwrite ($fp, "Address: $_SERVER[REMOTE_ADDR]\r\n");
			fwrite ($fp, "Referer: $_SERVER[HTTP_REFERER]\r\n");
			fwrite ($fp, "User Agent: $_SERVER[HTTP_USER_AGENT]\r\n");
			fwrite ($fp, "Username: ".$PARAM['alias']."\r\n");
			fwrite ($fp, "Password: ".$PARAM['password']."\r\n");
			fwrite ($fp, "\r\n");
			fclose ($fp);
			}

		return 0;
		}
 	}

 //function adminLogout()
 function adminLogout() {
  global $html;
  global $PARAM;

 	$html->clear('logged');

	//zapazi dannite ot sesiyata
 	unset($_SESSION[adminID]);
 	unset($_SESSION[adminAlias]);
 	unset($_SESSION[adminExpire]);

	$html->define('login', 'login.htmlt');
	$html->extract('login');
	
	$_SESSION[login_return] = null;
	unset($_SESSION[login_return]);

	if (($PARAM['err'] != '') && ($html->get_subs('error')=='')) {
		$html->message('error', $PARAM['err']);
		$html->parse('error');
		$html->assign('login_error', $html->fetch('error'));
		}

	printPage ('login');
	}
//- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// template system
$html = new Template(get_Setting('TEMPLATES_DIR'),
	get_Setting('TEMPLATE_LOG'),
	'__admin_default_messages_and_template__.htmlt');

// define common templates
$html->define(array(
	header=>'header.htmlt',
	footer=>'footer.htmlt')
	);

// setting system variables
$html->assign('images_dir', get_Setting('IMAGES_DIR'));

// compatibility
if (!$PATH_INFO) $PATH_INFO = $SCRIPT_NAME;
$html->assign('action', $PATH_INFO);

// prepare the templates
$html->extract('header');
$html->extract('footer');

if (init())	{
	if ($HTTP_POST_VARS['Login']) {
		if (!logAdmin()) {

			$html->define('login', 'login.htmlt');
			$html->extract('login');

			$html->message('error', 'error_access_denied');
			$html->parse('error');
			$html->assign('login_error', $html->fetch('error'));

			printPage ('login');

			} else {

			$html->assign('command', 'load&load=1&' . $_SESSION[login_return] );	// load params
			printPage('done');
			return;
			}

		}elseif	(!adminLogged()) {

				$html->define('login', 'login.htmlt');
				$html->extract('login');

				if (($PARAM['cmd'] != '') && ($PARAM['cmd'] != 'logout')) {
					$html->message('error', 'error_unauthorized_access');
					$html->parse('error');
					$html->assign('login_error', $html->fetch('error'));

					$_SESSION[login_return] = $_SERVER[QUERY_STRING];
					$_SESSION[login_POST] = $_POST;
					}

				printPage ('login');

				} else {
				
				///if ($PARAM['load']) {	//right after login
				///	$_POST = array_merge($_POST, $_SESSION[login_POST]);
				///	}
				
				switch ($PARAM['cmd']) {

					case 'run' :
						require('./includes/admin.run.inc.php');
						adminRun();
						break;

					case 'project' :
						require('./includes/admin.project.inc.php');
						adminProject();
						break;

					case 'proxy' :
						require('./includes/admin.proxy.inc.php');
						adminProxy();
						break;

					case 'referer' :
						require('./includes/admin.referer.inc.php');
						adminReferer();
						break;

					case 'user-agent' :
						require('./includes/admin.useragent.inc.php');
						adminUserAgent();
						break;

					case 'upload' :
						require('./includes/admin.upload.inc.php');
						adminUpload();
						break;

					case 'proxy-extractor' :
						require('./includes/admin.proxy-extract.inc.php');
						adminProxyExtract();
						break;

					case 'log-extractor' :
						require('./includes/admin.log-extract.inc.php');
						adminLogExtract();
						break;

					case 'change' :
						require('./includes/admin.password.inc.php');
						adminPassword();
						break;

					case 'logout' :
						adminLogout();
						break;

					default :	//default;
						adminMenu();
					}
				}
	halt();
	}

?>