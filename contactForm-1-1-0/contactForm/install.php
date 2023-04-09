<?php
/*
 * Mike's Contact Script - A web based contact form.
 * Copyright (C) 2005  Mike Hanson (themike.com)
 *
 * This file is part of Mike's Contact Script.
 *
 * Mike's Contact Script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Mike's Contact Script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Mike's Contact Script; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */
 
session_start();
header("Cache-control: private"); // For lovely IE 6
 
header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");

// Set up our session
if( !isset($_SESSION['vaildSession']) ) {
    session_regenerate_id();
    $_SESSION['vaildSession'] = session_id();
    $_SESSION['numTries'] = 0;
} else if ($_SESSION['vaildSession'] != session_id()) {
    // Possibly a hijack attempt, kill off the session and inform the user to try again.
    echo "Sorry please try again from the main page.";
    session_unset();
    session_destroy();
	session_write_close();
	exit(0);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Mike's Contact Script - Install</title>
<link rel="stylesheet" type="text/css" href=
"templates/contactForm.css">
<style type="text/css">
.statusGood {
color:#0000FF;
font-size:small;
font-weight:bold;
}
.warning {
color:#FF0000;
font-size:x-large;
font-weight:bold;
text-align:center;
}
</style>
</head>
<body>
<table width="100%" summary="">
<tr>
<td>
<table width="80%" class="mainLayout" summary="">
<tr>
<td>
<div class="contactForm"><span class="header">Install Mike's
Contact Script</span></div>

<?php
// Do a quick test to see if user input is correct.
$correctInput = false;
if ( isset($_POST['submitted']) && ($_POST['submitted'] == 1) ) {
    if ( empty($_POST['emails'])
            || empty($_POST['site'])
            || empty($_POST['maxSubject'])
            || empty($_POST['maxMessage'])
            || empty($_POST['maxName'])
            || empty($_POST['maxAddress'])
            || empty($_POST['maxAttempts'])
            || empty($_POST['gdVersion']) ) {

        echo "<div class=\"contactForm\"><div class=\"error\">Please fill in the entire form.</div></div>";
        $correctInput = false;
    } else if ( !is_numeric($_POST['maxSubject'])
            || !is_numeric($_POST['maxMessage'])
            || !is_numeric($_POST['maxName'])
            || !is_numeric($_POST['maxAddress'])
            || !is_numeric($_POST['maxAttempts'])
            || !is_numeric($_POST['gdVersion']) ) {

        echo "<div class=\"contactForm\"><div class=\"error\">Sorry, only numbers are allowed in the following fields:<br>Max Name:<br>Max Address:<br>Max Subject:<br>Max Message:<br>Max Attempts<br>GD Version:</div></div>";
        $correctInput = false;
    } else {
        $correctInput = true;
    }
}
?>

<?php
if( $correctInput ) {
    /* Get the users data and parse it accordingly */
    // Split the string into different email addresses
    $emails = explode( "\n", trim($_POST['emails']) );
    $numEmails = count($emails);

    // Now split the string again, this time according to each section.
    for($i=0; $i<$numEmails; ++$i) {
        $emails[$i] = trim($emails[$i]);
        $emails[$i] = explode(";", $emails[$i]);

        // Get rid of any extra white space the user may have entered
        for($j=0; $j<3; ++$j) {
            $emails[$i][$j] = stripslashes( trim($emails[$i][$j]) );
        }
        
        // Create an array of extra addresses
        $emails[$i][2] = explode(",", $emails[$i][2]);
    }

    // Now we have an array as follows:
    // [0][0]: First Email Description
    // [0][1]: First Email Name
    // [0][2]: Array of Email addresses
    // Let's do something with it!

    /* We're using two files to store the email data, one for the php side of things and the other for
    the html side.  While other ways are possible and probably nicer looking this is the easiest way
    to do it. */
    
    /* Put together the emails.php file, this file contains a switch statement for the email addresses.*/
    echo "<div class=\"contactForm\">\r\n";
    echo "<p class=\"status\"><b>Opening emails.php</b></p>\r\n";

    // Attempt to open up our emails file
    $fp = fopen("emails.php", "wb");
    if ( $fp === FALSE ) {
        echo "Error opening emails.php, aborting.";
        exit ("Unable to open emails.php.");
    }

    // *** Create the emails file ***
    // No reason to have a multiple selection box for only one email address
    if ( $numEmails > 1 ) {
        // Put together the beginning of our emails file
        $buffer = "<?php\r\nswitch (\$to[\$i]) {\r\n    case 0: break; // Unused, actually it's reserved for the default selection.\r\n";
        $buffer .= "// ********************************************************************************\r\n";
        $buffer .= "//                      Enter your email addresses below.\r\n";
        $buffer .= "//  \$sendTo is the actual address the email will be sent to.\r\n";
        $buffer .= "//  \$toName is a description of that address.\r\n";
        $buffer .= "//  Entries must be in this format:\r\n";
        $buffer .= "//  case #: \$sendTo .= \"\\\"NAME\\\" <EMAIL@ADDRESS.HERE>\";         \$toName .= \"A DISCRIPTON OF THE ADDRESS\";       break;\r\n";
        $buffer .= "//  Or if you wish to recieve multiple copies per email:\r\n";
        $buffer .= "//  case #: \$sendTo .= \"\\\"NAME\\\" <EMAIL@ADDRESS.HERE>,NAME2 <EMAIL2@ADDRESS.HERE>, NAME3 <EMAIL3@ADDRESS.HERE>\";         \$toName .= \"A DISCRIPTON OF THE ADDRESS\";       break;\r\n";
        

        // Time to form switch/case statement.
        echo "<p class=\"status\">Inserting the following email addresses:<br>";
        for($i=0; $i<$numEmails; ++$i) {
            // Form the case statement
            $buffer .= "    case ".($i+1).": \$sendTo .= \"\\\"".$emails[$i][1]."\\\"".formatSendto($emails[$i])."\";       \$toName .= \"".$emails[$i][0]."\";     break;\r\n";

            // Output for the install script
            echo $emails[$i][0] . " - ".htmlspecialchars(formatSendto($emails[$i]))."<br>\r\n";
        }
        echo "<br>Success!</p>\r\n";
        
        $buffer .= "    default: echo \"There was an error with your input\";\nsession_unset();\nsession_destroy();\nsession_write_close();\nexit(0);\n";
        $buffer .= "// ********************************************************************************\r\n} // end switch\r\n?>";
    } else {
        // Put together the beginning of our emails file
        $buffer = "<?php\r\nswitch (\$to[\$i]) {\r\n";
        $buffer .= "// ********************************************************************************\r\n";
        $buffer .= "//                      Enter your email addresses below.\r\n";
        $buffer .= "//  \$sendTo is the actual address the email will be sent to.\r\n";
        $buffer .= "//  \$toName is a description of that address.\r\n";
        $buffer .= "//  Entries must be in this format:\r\n";
        $buffer .= "//  case #: \$sendTo .= \"\\\"NAME\\\" <EMAIL@ADDRESS.HERE>\";         \$toName .= \"A DISCRIPTON OF THE ADDRESS\";       break;\r\n";
        $buffer .= "//  Or if you wish to recieve multiple copies per email:\r\n";
        $buffer .= "//  case #: \$sendTo .= \"\\\"NAME\\\" <EMAIL@ADDRESS.HERE>,NAME2 <EMAIL2@ADDRESS.HERE>, NAME3 <EMAIL3@ADDRESS.HERE>\";         \$toName .= \"A DISCRIPTON OF THE ADDRESS\";       break;\r\n";

        // We start at one because we use 0 for the default value with multiple emails.
        $buffer .= "    case ".(1).": \$sendTo .= \"\\\"".$emails[0][1]."\\\"".formatSendto($emails[0])."\";       \$toName .= \"".$emails[0][0]."\";     break;\r\n";

        // Output for the install script
        echo "<p class=\"status\">".$emails[0][0]." - ".htmlspecialchars(formatSendto($emails[0]))."<br>\r\n";
            
        echo "<br>Success!</p>\r\n";

        $buffer .= "    default: echo \"There was an error with your input\";\nsession_unset();\nsession_destroy();\nsession_write_close();\nexit(0);\n";
        $buffer .= "// ********************************************************************************\r\n} // end switch\r\n?>";
    }

    if ( fwrite($fp, $buffer) === FALSE ) {
        echo "Error writing to emails.php, aborting.";
        exit ("Unable to write to emails.php");
    }

    echo "<p class=\"status\">Closing emails.php</p><br>\r\n";
    if ( fclose($fp) === FALSE ) {
        echo "Error closing emails.php, aborting.";
        exit("Unable to close emails.php");
    }

    /* Put together our formSelection.php, this file contains the html side of the emails */
    echo "<p class=\"status\"><b>Opening formSelection.php</b></p>\r\n";
    $fp = fopen("formSelection.php", "wb");
        if ( $fp === FALSE ) {
        echo "Error opening formSelection.php, aborting.";
        exit ("Unable to open formSelection.php.");
    }

    // *** Create the formSelection file ***
    // Again, no reason to have a multiple selection box for only one email address
    if ( $numEmails > 1 ) {
        $buffer  = "<select name=\"to[]\" multiple=\"multiple\" size=\"";
        if ( $numEmails < 5 ) { $buffer .= $numEmails + 1; } else { $buffer .= "5"; }
        $buffer .= "\">\r\n";
        $buffer .= "    <option value=\"0\" <?php checkSelected(0); ?>>Please select the recipients ...     </option>\r\n";
        $buffer .= "<?php\r\n// ********************************************************************************\r\n";
        $buffer .= "// Add your selections here!  Entries must be in this format:\r\n";
        $buffer .= "//  <option value=\"#\" < ?php checkSelected(#); ? >>NAME</option>\r\n";
        $buffer .= "?>\r\n";

        // Time to form switch/case statement.
        echo "<p class=\"status\">Inserting the following options:<br>";
        for($i=0; $i<$numEmails; ++$i) {
            $buffer .= "    <option value=\"".($i+1)."\" <?php checkSelected(".($i+1)."); ?>>".$emails[$i][0]."</option>\r\n";

            // Output for the install script
            echo "Option " . ($i+1) . " - " . $emails[$i][0] . "<br>\r\n";
        }
        echo "<br>Success!</p>\r\n";

        $buffer .= "</select>";
        $buffer .= "<?php\r\n// ********************************************************************************\r\n?>";
    } else {
        $buffer  = "<select name=\"to[]\">";
        $buffer .= "<?php\r\n// ********************************************************************************\r\n";
        $buffer .= "// Add your selections here!  Entries must be in this format:\r\n";
        $buffer .= "//  <option value=\"#\" < ?php checkSelected(#); ? >>NAME</option>\r\n";
        $buffer .= "?>\r\n";

        // Time to form switch/case statement.
        echo "<p class=\"status\">Inserting the following options:<br>";
        // We start at one because we use 0 for the default value with multiple emails.
        $buffer .= "    <option value=\"".(1)."\" <?php checkSelected(".(1)."); ?>>".$emails[0][0]."</option>\r\n";

        // Output for the install script
        echo "Option " . (1) . " - " . $emails[0][0] . "<br>\r\n";
        
        echo "<br>Success!</p>\r\n";

        $buffer .= "</select>";
        $buffer .= "<?php\r\n// ********************************************************************************\r\n?>";
    }

    if ( fwrite($fp, $buffer) === FALSE ) {
        echo "Error writing to formSelection.php, aborting.";
        exit ("Unable to write to formSelection.php");
    }

    echo "<p class=\"status\">Closing formSelection.php</p><br>\r\n";
    if ( fclose($fp) === FALSE ) {
        echo "Error closing formSelection.php, aborting.";
        exit("Unable to close formSelection.php");
    }
    
    /* Finally, write our constant values to constants.php */
    echo "<p class=\"status\"><b>Opening constants.php</b></p>\r\n";
    $fp = fopen("constants.php", "wb");
        if ( $fp === FALSE ) {
        echo "Error opening constants.php, aborting.";
        exit ("Unable to open constants.php.");
    }

    if ( $_POST['gdVersion'] >= 2 ) {
        $gd_version = true;
    } else {
        $gd_version = false;
    }
    
    // *** Create the constants file ***
    $buffer = "<?php\r\n/* Constants */\r\n";
    $buffer .= "\$siteName   = \"" . trim($_POST['site']) . "\"; // The name of your site (e.g. example.com)\r\n";
    $buffer .= "\$scriptName = \"index.php\"; // The filename of this script.\r\n";
    $buffer .= "\$gd_version = ";
    if ( $gd_version ) { $buffer .= "true"; } else { $buffer .= "false"; }
    $buffer .= "; // True if you are using GD lib +2.0, false if you are using a previous version.\r\n";
    $buffer .= "\$captcha = " . $_POST['capType'] . ";\r\n";
    $buffer .= "\r\n/* Maximum Lengths */\r\n";
    $buffer .= "\$maxSubject  = " . trim($_POST['maxSubject']) . ";     // The maximum subject length.\r\n";
    $buffer .= "\$maxMessage  = " . trim($_POST['maxMessage']) . ";    // The maximum message length.\r\n";
    $buffer .= "\$maxName     = " . trim($_POST['maxName']) . ";     // The maximum from name length.\r\n";
    $buffer .= "\$maxAddress  = " . trim($_POST['maxAddress']) . ";     // The maximum from address length.\r\n";
    $buffer .= "\$maxAttempts = " . trim($_POST['maxAttempts']) . ";      // The maximum number of bad attampts.\r\n?>";
    
    echo "<p class=\"status\">Writing to constants.php</p>\r\n";
    if ( fwrite($fp, $buffer) === FALSE ) {
        echo "Error writing to constants.php, aborting.";
        exit ("Unable to write to constants.php");
    }

    echo "<p class=\"status\">Success!</p>\r\n";

    echo "<p class=\"status\">Closing constants.php</p><br>\r\n";
    if ( fclose($fp) === FALSE ) {
        echo "Error closing constants.php, aborting.";
        exit("Unable to close constants.php");
    }
    
    $buffer = NULL;
    
    echo "<p class=\"statusGood\">Install Was Successful!</p><br>\r\n";

    echo "<p class=\"status\">Please double check these values:</p>\r\n";
    
    echo "<table border=\"1\" cellpadding=\"2\" align=\"center\" class=\"status\" summary=\"Emails entered\">\r\n";
    echo "<tr><td><strong>Description</strong></td><td><strong>Name</strong></td><td><strong>Email Adddress</strong></td></tr>\r\n";
    for($i=0; $i<$numEmails; ++$i) {
        echo "<tr><td>" . $emails[$i][0] . "</td><td>" . $emails[$i][1] . "</td><td>" . htmlspecialchars(formatSendto($emails[$i])) . "</td></tr>\r\n";
    }
    echo '</table>';

    echo "<p class=\"status\">If there was an error, please press the back button on your browser and fix it now.  \r\n";
    echo "Make sure that you entered the email addresses in the correct format.</p>\r\n";

    echo "<p class=\"status\">If all of the values look correct and there were no errors then you are done, congratulations!<br>\r\n";
    echo "Please remember to <strong>delete this file</strong> (install.php), leaving it on the server creates a <strong>major security risk!</strong></p>\r\n";

    echo "<p class=\"warning\">Last warning: DELETE install.php</p>";

    echo "<p class=\"center\"><a href=\"index.php\">Go to the contact form!</a></p>";

    echo "<div class=\"contactCopyright\">Powered by <a href=\"http://programs.themike.com/\">Mike's Contact Script</a> &copy; 2005</div>\r\n";
    echo "</div>";
    
    $_POST['submitted'] = 0;
    
} else {
    // Nothing to parse yet
?>
<div class="contactForm">
<form name="install" method="post" action="install.php">
<table summary="Install Form" width="760" align="center">
<colgroup span="2">
<col width="150">
<col></colgroup>
<tr>
<td colspan="2">
<p>Thank you for choosing Mike's Contact Script! I put a lot of
(fun!) work into it and I hope that you find it useful!</p>
<p>This install script is pretty straight forward. Just fill in the
fields as directed and press install. Don't forget to delete this
file when you are finished!</p>
<p>- Mike Hanson</p>
<br></td>
</tr>
<?php if ( fopen("emails.php", "ab") === FALSE ) { ?>
<tr>
<td colspan="2"><div class="error">Error opening emails.php, check the permissions and try again.</div></td>
</tr>
<?php } ?>
<?php if ( fopen("formSelection.php", "ab") === FALSE ) { ?>
<tr>
<td colspan="2"><div class="error">Error opening formSelection.php, check the permissions and try again.</div></td>
</tr>
<?php } ?>
<?php if ( fopen("constants.php", "ab") === FALSE ) { ?>
<tr>
<td colspan="2"><div class="error">Error opening constants.php, check the permissions and try again.</div></td>
</tr>
<?php } ?>
<tr>
<td valign="top">
<div class="contactDescript">Site Name:</div>
</td>
<td>
<div class="contactFinePrint">The name or URL of your site. (e.g.
example.com)</div><input type="text" name="site" size="72" maxlength="1000" value=
"<?php if(isset($_POST['site'])) { echo $_POST['site']; } else { echo "example.com"; } ?>"></td>
</tr>
<tr>
<td valign="top">
<div class="contactDescript">Max Name:</div>
</td>
<td>
<div class="contactFinePrint">The maximum length of the name
field.</div><input type="text" name="maxName" size="72" maxlength="1000" value=
"<?php if(isset($_POST['maxName'])) { echo $_POST['maxName']; } else { echo "500"; } ?>"></td>
</tr>
<tr>
<td valign="top">
<div class="contactDescript">Max Address:</div>
</td>
<td>
<div class="contactFinePrint">The maximum length of the address
field.</div><input type="text" name="maxAddress" size="72" maxlength="1000"
value="<?php if(isset($_POST['maxAddress'])) { echo $_POST['maxAddress']; } else { echo "500"; } ?>"></td>
</tr>
<tr>
<td valign="top">
<div class="contactDescript">Max Subject:</div>
</td>
<td>
<div class="contactFinePrint">The maximum length of the subject
field.</div><input type="text" name="maxSubject" size="72" maxlength="1000"
value="<?php if(isset($_POST['maxSubject'])) { echo $_POST['maxSubject']; } else { echo "1000"; } ?>"></td>
</tr>
<tr>
<td valign="top">
<div class="contactDescript">Max Message:</div>
</td>
<td>
<div class="contactFinePrint">The maximum length of a
message.</div><input type="text" name="maxMessage" size="72" maxlength="1000"
value="<?php if(isset($_POST['maxMessage'])) { echo $_POST['maxMessage']; } else { echo "10000"; } ?>"></td>
</tr>
<tr>
<td valign="top">
<div class="contactDescript">Max Attempts:</div>
</td>
<td>
<div class="contactFinePrint">The maximum number of times a user
can mess up.</div><input type="text" name="maxAttempts" size="72" maxlength="1000"
value="<?php if(isset($_POST['maxAttempts'])) { echo $_POST['maxAttempts']; } else { echo "20"; } ?>"></td>
</tr>
<tr>
<td valign="top">
<div class="contactDescript">CAPTCHA image:</div>
</td>
<td>
<div class="contactFinePrint">Choose which CAPTCHA image to use for
spam protection, you can also turn it off.</div>
<table summary="">
<tr>
<td></td>
<td valign="bottom">
<div class="center"><img src="freecap14.php" id="freecap" height="90" alt="CAPTCHA image"><br>
<input type="radio" name="capType" value="1" <?php isChecked(1); ?>><br>
FreeCap v1.4</div>
</td>
<td valign="bottom">
<div class="center"><img src="captcha_image.php" id="gotcha-captcha" style="width: 230px; height: 60px" alt="CAPTCHA image"><br>
<input type="radio" name="capType" value="2" <?php isChecked(2); ?>><br>
GOTCHA v0.01</div>
</td>
<td valign="bottom">
<div class="center"><input type="radio" name="capType" value="0" <?php isChecked(0); ?>><br>
None</div>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td valign="top">
<div class="contactDescript">GD Version:</div>
</td>
<td>
<div class="contactFinePrint">This is only required if you are
using a CAPTCHA image. We tried to auto-detect it so you only need
to change it if it doesn't look right.</div><input type="text" name="gdVersion" size="72" maxlength="1000" value="<?php echo gdVersion(); ?>"></td>
</tr>
<tr>
<td valign="top">
<div class="contactDescript">Email Addresses:</div>
</td>
<td valign="top">
<p class="contactFinePrint">Enter your email addresses here:<br>
Entries should be the email's description, the name associated with
the email, and the actual email address each seperated by a
semi-colon (;). One email per line!<br>
Email description; Name; email@address<br>
Example: John Doe - Sales; John Doe; john@example.com</p>
</td>
</tr>
<tr>
<td colspan="2" class="center"><textarea name="emails" rows="15" cols="90" wrap="off"><?php if(isset($_POST['emails'])) { echo $_POST['emails']; } else { echo "Mike's Email Address; Mike; email@example.com
John Doe - Sales; John Doe; john@example.com"; } ?></textarea></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><span class="center"><input type="hidden" name="submitted"
value="1"><input type="submit" name="go" value=
"Install"></span></td>
</tr>
<tr>
<td colspan="2">
<div class="contactCopyright">Powered by <a href="http://programs.themike.com/">Mike's Contact Script</a> &#169;
2005</div>
</td>
</tr>
</table>
</form>
</div>
<?php
}
?>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
<?php
/*
 *  Put the to addresses in the correct format.
 *      $addrArray[1]: Email Name
 *      $addrArray[2]: Array of email addresses
 */
function formatSendto($addrArray) {
    // Ya with me? Format the first email address, it includes a name.
    $sendString = " <".stripslashes( trim($addrArray[2][0]) ).">";
    
    // Tack on the other addresses
    for($i=1; $i<count($addrArray); ++$i) {
        if ( !empty($addrArray[2][$i]) ) {
            $sendString .= ", <".stripslashes( trim($addrArray[2][$i]) ).">";
        }
    }

    return $sendString;
}

/*
 *  Outputs "checked" if the user selected this value last time around.
 */
function isChecked($num) {

    if( isset($_POST['capType']) ) {
        if ( $_POST['capType'] == $num ) {
            echo "checked";
            return;
        }
    } else if ( $num == 2 ) {
        // By default the 1 option should be selected.
        echo "checked";
        return;
    }
}

/*
 *  Tries to determine what version of GD is running.
 *      Function from php manual http://us3.php.net/manual/en/function.imagecreatetruecolor.php
 */
function gdVersion($user_ver = 0)
{
   if (! extension_loaded('gd')) {
        echo "<div class=\"contactForm\"><div class=\"error\">The GD library may not be installed! Please confirm that it is installed before continuing.</div></div>";
        return;
   }
   static $gd_ver = 0;
   // Just accept the specified setting if it's 1.
   if ($user_ver == 1) { $gd_ver = 1; return 1; }
   // Use the static variable if function was called previously.
   if ($user_ver !=2 && $gd_ver > 0 ) { return $gd_ver; }
   // Use the gd_info() function if possible.
   if (function_exists('gd_info')) {
       $ver_info = gd_info();
       preg_match('/\d/', $ver_info['GD Version'], $match);
       $gd_ver = $match[0];
       return $match[0];
   }
   // If phpinfo() is disabled use a specified / fail-safe choice...
   if (preg_match('/phpinfo/', ini_get('disable_functions'))) {
       if ($user_ver == 2) {
           $gd_ver = 2;
           return 2;
       } else {
           $gd_ver = 1;
           return 1;
       }
   }
   // ...otherwise use phpinfo().
   ob_start();
   phpinfo(8);
   $info = ob_get_contents();
   ob_end_clean();
   $info = stristr($info, 'gd version');
   preg_match('/\d/', $info, $match);
   $gd_ver = $match[0];
   return $match[0];
} // End gdVersion()
?>
