<?php

//------------------------------------------------------------------------
// This script is a part of Zakkis ABC Catalog.
//
// Version: 2.0
// Homepage: www.zakkis.ca
// Copyright (c) 2002-2003 Zakkis Technology, Inc.
// All rights reserved.
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
// "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
// LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
// FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
// REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
// INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
// (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
// SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
// HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
// STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
// ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
// OF THE POSSIBILITY OF SUCH DAMAGE.
//
//------------------------------------------------------------------------

//
// Workaround versioning issue for parser (it works from v4.2, catalog from 4.1)

$php_version = split( "\.", phpversion() );
if( $php_version[0] == 4 && $php_version[1] <= 1 )
{
	if( !function_exists('var_export') )
	{
		function var_export( $exp, $ret )
		{
			ob_start();
			var_dump( $exp );
			$result = ob_get_contents();
			ob_end_clean();
			return $result;
		}
	}
}

//
// Function to detect operation system (windows or not)

function IsWindows()
{
	$phpOS = strtolower(PHP_OS);
	if( substr_count( $phpOS, 'win' ) == 0 )
		return false;
	else
		return true;
}

//
// Setup include paths

$path = ini_get('include_path');
if( IsWindows() )
	$path .= ";./parser;./include";
else
	$path .= ":./parser:./include";

ini_set( 'include_path', $path );

//
// Include modules

include_once ('template.php');
include_once ('util.php');
include_once ('auth.inc');

//
// Function to redirect to login page (with message)

function ShowLoginPage( $msg )
{
	$templ = new Template('data/login.html');
	$templ->param('msg', $msg);
	$templ->param('login', $_POST[login]);
	echo $templ->parse();
	exit;
}

//
// Fetch site section needed

$sect = $_GET[sect];

//
// Process login

session_start();
if( !$_SESSION[auth] )
{
	$sect = '';
	session_destroy();
	$auth_msg = CheckUserAuth();
	if( $auth_msg != 'ok' )
		ShowLoginPage( $auth_msg );
}

//
// Fetch session variables

$guest = $_SESSION[guest];
$auth = $_SESSION[auth];

//
// Process logout

if( $sect == 'logout' )
{
	if( session_id() )
		session_start();
	session_unset();
	session_destroy();
	ShowLoginPage( 'Logged out.' );
}

//
// Create and setup main template

$tmain = new Template("data/main.html");

//
// Error & nessage handling API function

$errors = array();
$has_errors = false;
function AddError( $msg )
{
	global $has_errors, $errors;
	$errors[]['msg'] = $msg;
	$has_errors = true;
}

$message = '';

//
// Choose template based on section id.

switch( $sect )
{
case 'catalog':
	$page = 'viewcat.html';
	break;
case 'styles':
	$page = 'styles.html';
	break;
case 'parse':
case 'index':
case 'login':
default:
	$page = 'admin.html';
	break;
}

//
// Create and prepare template

$templ = new Template("data/$page");
$has_template = file_exists('table.html');

//
// Chpoose code module for section id

switch( $sect )
{
case 'catalog':
	if( IsPost() )
	{
		include_once ('catalog_p.inc');
	}
	{	include_once ('catalog_g.inc');	}
	break;
case 'styles':
	if( IsPost() )
	{
		include_once ('styles_p.inc');
	}
	{	include_once ('styles_g.inc');	}
	break;
case 'parse':
	if( IsPost() )
	{
		include_once ('admin.inc');
	}
	break;
}

//
// Parse and output page template

$templ->param('has_template', $has_template);
$templ->param('guest', $guest);

if( $has_errors )
	$tmain->param('err', $errors);
if( $message != '' )
	$tmain->param('message', $message);
	
$tmain->param('content', $templ->parse() );

echo $tmain->parse();
exit;

?>