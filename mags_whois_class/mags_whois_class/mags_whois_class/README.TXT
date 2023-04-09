/*======================================================================*\
|| #################################################################### ||
|| # Mags Whois Class Version 1.0 (graycheryal@qwest.net)             # ||
|| # ---------------------------------------------------------------- # ||
|| # All code is ©2002-2003 Marcus Gray                               # ||
|| #                                                                  # ||
|| #     You are free to use this script as long as you keep all      # ||
|| #   copyright statements in tact! Removal could result in legal    # ||
|| #                    action taken against you!                     # ||
|| #                                                                  # ||
|| # ------------------ REQUIRED FOR USE OF SCRIPT ------------------ # ||
|| #        - PHP Version 4.1.0 or above...                           # ||
|| #        - Apache                                                  # ||
|| #        - Linux or Windows NT (tested on these only)              # ||
|| #        - Internet Explorer 6 (tested on this browser only)       # ||
|| #                                                                  # ||
|| #         For Entertainment: http://www.vgfanatics.com             # ||
|| #                                                                  # ||
|| # This script parses for the following domain extensions, more to  # ||
|| # come with the next version release!                              # ||
|| #                                                                  # ||
|| #   .com, .net, .org, .biz, .info, .bz, .ws, .nu, .us, .uk, .ca    # ||
|| #                                                                  # ||
|| #################################################################### ||
\*======================================================================*/

This directory contains the following files:

readme.txt - this file
class/class.whois.php - The engine of the script. This particular file does all of the work.
class/form.php - The form portion of the script that shows when the user first views the script.
common/global.php - Global varibales used in the script for you to edit to better fit your site.
index.php - The file where the script should be used... (Better explanation below)
phpinfo.php - Shows the php info for your server. Useful for script compatability detection.
source.php - Shows the source of the [class/class.whois.php] file.
stats.php - Shows the whois information of the specified domain.


/*====================*\
|| ################## ||
|| #   TO INSTALL   # ||
|| ################## ||
\*====================*/

1. Upload the contents of this directory into the directory you would like to install the script
   on your server. I reccommend creating a "whois" directory and uploading these scripts there.

                         ***** KEEP THE SAME DIRECTORY STRUCTURE *****                          

---------------

/*====================*\
|| ################## ||
|| #  TO CUSTOMIZE  # ||
|| ################## ||
\*====================*/

*** This script is completely customizable and will fit into your site wherever it is needed. ***

1. To edit the way the form looks (the form that the user sees when they first view your script),
   open the [class/form.php] file. Note that this only edits the form of the script... you should
   not actually put your site coding in this file since the index.php file includes this form.php

2. To change the variables (or text that the user sees throughout their search), open the
   [common/global.php] file and search for the desired variable.

3. If you rearrange the files (directory structure [REMEMBER: NOT RECCOMENDED]), then you must
   open the [class/class.whois.php] file and change the two 'include()' variables at the top to
   point to where those files are now located on your server. When specifying the location to the
   files on your server, use the server path (i.e. /whois/index.php) and not the absolute path
   (i.e. /home/username/public_html/whois/index.html).

---------------

/*====================*\
|| ################## ||
|| #     TO USE     # ||
|| ################## ||
\*====================*/

    ***** There are two different ways to include this script... they are listed below! *****

1. You can inlcude the whole site that goes around this script into the index.php file...

     or

2. You can create a new .php file or include the following code in your existing site .php file:

          ***** NOTE: YOU MUST USE A .PHP EXTENSION FILE FOR THIS SCRIPT TO WORK *****


 CODE TO INCLUDE (Make sure that the essential <?php ?> tags are used and that the following code
 is placed in the middle of the two tags with other PHP functions.

-----

include("path/to/class.whois.php");
$build = new Build(); // this makes the form

// this checks if the form has been submited
if( isset($HTTP_POST_VARS["domain"]) AND isset($HTTP_POST_VARS["extensions"]) AND $HTTP_POST_VARS["domain"] != "" )
{
	$whois = new Whois($HTTP_POST_VARS["domain"], $HTTP_POST_VARS["extensions"]);
	$whois->PrintResults(); // this prints the results .. put where you want the results to be placed
	
	// To Show Errors Just [echo $whois->errors;] //
	
	//... to show the domains whois information do ... //
	
        echo(" <a href=\"stats.php?domain=".$HTTP_POST_VARS['domain']."&extension=".$HTTP_POST_VARS['extensions']."\">Show Stats </a>");
	
	//... extra php code here... //
}

-----

 You must change the 'include("path/to/class.whois.php");' to point to the server path where your
 [class.whois.php] file is for this script to work properly.


 DONE!

 *** For EXTRA fun, please visit http://www.vgfanatics.com ***