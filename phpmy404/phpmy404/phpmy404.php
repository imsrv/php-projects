<?php
// {{{ description

/****************************************************************************
This script was developed by Aero77.com .
Title: PHPmy404
Version: 1.2
Homepage: www.Aero77.com
Copyright (c) 2004 Aero77.com and its owners.
All rights reserved.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
OF THE POSSIBILITY OF SUCH DAMAGE.

USAGE:
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

More Info About The Licence At http://www.gnu.org/copyleft/gpl.html
****************************************************************************/

// Configuration

// This is where all of the various parameters for the script are set.
// The e-mail address of the person to notify when an error occurs.
$notify = 'admin@aero77.com';

// The name of your site
$sitename = 'Aero77.com';

// The text for returning to the homepage 
$returnLink = 'Please <a href="http://www.aero77.com">CLICK HERE</a> to return to the homepage.';

// The full path to the error log.  Make sure it is writable
$errorLog = 'logs/error/error_log.txt';

// The default language to use (if there is no support for the browser language)
// Right now options are 'en',
$default_lang = 'en';

// images to display on left hand side (full path to the image)
$images = array (
         '000' => '/phpmy404/globe.png',
         '400' => '/phpmy404/globe.png',
         '401' => '/phpmy404/globe.png',
         '403' => '/phpmy404/globe.png',
         '404' => '/phpmy404/globe.png',
         '500' => '/phpmy404/globe.png');

// These are the Subject Lines for the e-mail notification
$subjects = array ( 
         '000' => 'Unknown Error',
         '400' => 'Bad Request',
         '401' => 'No Authorization',
         '403' => 'Forbidden URL',
         '404' => 'Missing URL',
         '500' => 'Configuration Error');

// True or false, depending on if you want to receive e-mail when a particular error occurs.
$email = array (
        '000' => false,
        '400' => false,
        '401' => false,
        '403' => false,
        '404' => false,
        '500' => false);

// True or false, depending on if you want to log a particular error to file 
$log = array (
        '000' => true,
        '400' => true,
        '401' => true,
        '403' => true,
        '404' => true,
        '500' => true);

// The CSS used for the error page
$css = '
body {
  background-color: #ffffff;
  color: #000000;
}
a:link,a:active,a:visited {
  font-weight: bold;
  text-decoration: none;
  color: blue;
}
a:hover {
  font-weight: bold;
  text-decoration: underline;
  color: blue;
}
div.container {
  width: 650px; 
  text-align: center; 
  margin-left: auto; 
  margin-right: auto;
  margin-top: 150px;
  border: thin solid #000000;
}
div.imageBox {
  background-color: #ffffff;
  float: left;
  width: 300px;
  border-right: thin solid #000000;
  height: 100%;
  padding: 5px;
}
div.textBox {
  padding: 5px;
  background-color: #ffffff;
  text-align: center;
  height: 218px;
}
div.errorHeader {
  color: #dd0101;
  font-weight: bold;
  margin-bottom: 10px;
}
div.error {
  font-weight: bold;
  margin-bottom: 10px;
}
div.errorDetails {
  font-size: small;
  font-weight: bold;
}
div.return {
  font-weight: small;
}';

/**
 * Info on the internal definition of the error codes:
 * 000 = HTML CODE TO APPEAR WHEN AN UNAUTHORIZED PAGE ACCESS ATTEMP OCCURS
 * 400 = HTML CODE TO APPEAR WHEN A BAD REQUEST OCCURS
 * 401 = HTML CODE TO APPEAR WHEN AN UNAUTHORIZED PAGE ACCESS ATTEMP OCCURS
 * 403 = HTML CODE TO APPEAR WHEN A FORBIDDEN ATTEMPT IS MADE
 * 404 = HTML CODE TO APPEAR WHEN A DOCUMENT NOT FOUND HAPPENS
 * 500 = HTML CODE TO APPEAR WHEN A SERVER CONFIGURATION ERROR OCCURS
 * See the Apache manual <http://Apache.org/> for further explanations and translations.
 *
 * Note: %url% will be replaced with $REDIRECT_URL
 */
 
$webMsg = array();
$webMsg['en']['400'] = 'The URL that you requested, %url% was a bad request.';
$webMsg['en']['401'] = 'The URL that you requested, %url% requires preauthorization to access.';
$webMsg['en']['403'] = 'Access to the URL that you requested, %url%, is forbidden.';
$webMsg['en']['404'] = 'The URL that you requested, %url%, could not be found. Perhaps you either mistyped the URL or we have a broken link.<br /><br />We have logged this error and will correct the problem if it is a broken link.';
$webMsg['en']['500'] = 'The URL that you requested,  resulted in a server configuration error. It is possible that the condition causing the problem will be gone by the time you finish reading this.<br /><br />We have logged this error and will correct the problem.';
$webMsg['en']['000'] = 'The URL that you requested, %url% resulted in an unknown error code.  It is possible that the condition causing the problem will be gone by the time you finish reading this.<br /><br />We have logged this error and will correct the problem.';

// Main
$resultCode = $_SERVER['QUERY_STRING'];
if ($resultCode != '400' && $resultCode != '401' && 
    $resultCode != '403' && $resultCode != '404' && 
    $resultCode != '500') {
    $resultCode = '000';
}

print_page($resultCode);
if ($log[$resultCode]) notify('L', $resultCode);
if ($email[$resultCode]) notify('M', $resultCode);

/**
 * This routine sends an e-mail or writes to a log depending
 * on whether it was called with an "L" or "M"
 *
 * @param string $action What action to take: log or mail
 * @param int $resultCode The result code
 *
 * @access public
 * @return void
 */
function notify($action, $resultCode)
{
    global $errorLog, $subjects, $notify, $sitename;
    $date = date('D M j G:i:s T Y');
    // see what action to take
    if ($action == 'L') { 
        $message = "[$date] [client: {$_SERVER['REMOTE_ADDR']} ({$_SERVER['HTTP_USER_AGENT']})] {$_SERVER['REDIRECT_ERROR_NOTES']}\n";
        $fp = fopen ($errorLog,'a+');
        fwrite($fp, $message);
        fclose($fp);
    } 
    else {
        $message = " 
------------------------------------------------------------------------------
Site:\t\t$sitename ({$_SERVER['SERVER_NAME']})
Error Code:\t$resultCode $subjects[$resultCode] ({$_SERVER['REDIRECT_ERROR_NOTES']})
Occurred:\t$date
Requested URL:\t{$_SERVER['REQUEST_URI']}
User Address:\t{$_SERVER['REMOTE_ADDR']}
User Agent:\t{$_SERVER['HTTP_USER_AGENT']}
Referer:\t{$_SERVER['HTTP_REFERER']}
------------------------------------------------------------------------------";
        mail($notify, "[ $sitename Error: $subjects[$resultCode] ]", $message);
    }
}

// Prints the page
function print_page($resultCode) 
{
    global $subjects, $images, $webMsg, $css, $sitename, $returnLink;
    $lang = get_lang($GLOBALS['default_lang']);
    $msg = str_replace('%url%', $_SERVER['REDIRECT_URL'], $webMsg[$lang][$resultCode]);
    // take off the path to the script, we don't want them to see that
    $error_notes = preg_replace('/:.*/', '', $_SERVER['REDIRECT_ERROR_NOTES']);
    if (!empty($error_notes)) {
        $error_notes = '(' . $error_notes . ')';
    }

    echo <<< EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 //EN" "http://www.w3.org/TR/REC-html40/strict.dtd">
<html>
  <head>
    <title>$subjects[$resultCode]</title>
    <style>
    $css
    </style>
  </head>
</html>
<body>
  <div class="container">
    <div class="imageBox"><img src="$images[$resultCode]" alt="Error" title="An Error Has Occured" /></div>
    <div class="textBox">
      <div class="errorHeader">$sitename Error $resultCode</div>
      <div class="error">$msg</div>
      <div class="errorDetails">$error_notes</div>
      <div class="return">$returnLink</div>
    </div>
  </div>
</body>
</html>
EOT;
}

/**
 * Determines the language via the browser and sees if that language is
 * supported.  If not returns the default language. Mostly for future use.
 *
 * @param string $in_default The default language
 *
 * @access public
 * @return string The two character language identifier
 */
function get_lang($in_default)
{
    global $webMsg;
    if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $a_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach ($a_langs as $s_lang) {
            if (isset($webMsg[$s_lang])) {
                return $s_lang;
            }

            $s_lang = strtolower(substr($s_lang, 0, 2));
            if (isset($webMsg[$s_lang])) {
                return $s_lang;
            }
        }
    }

    return isset($webMsg[$in_default]) ? $in_default : 'en';
}

?>
