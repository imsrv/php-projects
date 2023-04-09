<?php

/*+---------------------------------------------------------------------------+

*|	SnippetMaster 

*|	by Electric Toad Internet Solutions, Inc.

*|	Copyright (c) 2002 Electric Toad Internet Solutions, Inc.

*|	All rights reserved.

*|	http://www.snippetmaster.com

*|

*|+----------------------------------------------------------------------------+

*|  Evaluation copy may be used without charge on an evaluation basis for 30 

*|  days from the day that you install SnippetMaster.  You must pay the license 

*|  fee and register your copy to continue to use SnippetMaster after the 

*|  thirty (30) days.

*|

*|  Please read the SnippetMaster License Agreement (LICENSE.TXT) before 

*|  installing or using this product. By installing or using SnippetMaster you 

*|  agree to the SnippetMaster License Agreement.

*|

*|  This program is NOT freeware and may NOT be redistributed in ANY form

*|  without the express permission of the author. It may be modified for YOUR

*|  OWN USE ONLY so long as the original copyright is maintained. 

*|

*|  All copyright notices relating to SnippetMaster and Electric Toad Internet 

*|  Solutions, including the "powered by" wording must remain intact on the 

*|  scripts and in the HTML produced by the scripts.  These copyright notices 

*|  MUST remain visible when the pages are viewed on the Internet.

*|+----------------------------------------------------------------------------+

*|

*|  For questions, help, comments, discussion, etc., please join the

*|  SnippetMaster support forums:

*|

*|       http://www.snippetmaster.com/forums/

*|

*|  You may contact the author of SnippetMaster by e-mail at:

*|	

*|       info@snippetmaster.com

*|

*|  The latest version of SnippetMaster can be obtained from:

*|

*|       http://www.snippetmaster.com/

*|

*|	

*| Are you interested in helping out with the development of SnippetMaster?

*| I am looking for php coders with expertise in javascript and DHTML/MSHTML.

*| Send me an email if you'd like to contribute!

*|

*|

*|+--------------------------------------------------------------------------+



#+-----------------------------------------------------------------------------+

#| 		DO NOT MODIFY BELOW THIS LINE!

#+-----------------------------------------------------------------------------*/

include("./includes/config.inc.php");



// Used for SnippetMaster.



	// To allow meta tag(s) editing, set to 1; to disable change to 0.

	$META = 0;



	// To allow title tag editing, set to 1; to disable change to 0.

	$TITLE = 0;

	

	/* Set to 1 to convert new lines ("\n") to line breaks ("<br>"), otherwise set to 0 */

	$CONVERT = 0;



	/* Set to 1 to allow HTML tags, otherwise set to 0 */

	/* NOTE: if this is set to 0, any existing HTML will not be displayed */

	$HTML = 1;



	include("./includes/shared.lib.php");

	$snippetmaster = new SnippetMaster;

	$snippetmaster->start();



	/* Set path for "ROOT" and "PATH" directories */

	$snippetmaster->set(ROOT, $ROOT);

	$snippetmaster->set(PATH, $PATH);



	/* Set path for "PREVIEW" and "URL" paths */

	$snippetmaster->set(PREVIEW, $PREVIEW);

	$snippetmaster->set(URL, $URL);



	/* Create a list of directories to ignore */

	$snippetmaster->set(DIR_IGNORE, $IGNORE);



	/* Set to 1 to use basic authentication, otherwise set to 0 */

	$snippetmaster->set(AUTH, $AUTH);

	$snippetmaster->set(USER, $USER);

	$snippetmaster->set(PASS, $PASS);



	/* Set to 1 to edit meta tags, otherwise set to 0 */

	$snippetmaster->set(META, $META);



	/* Set to 1 to edit page titles, otherwise set to 0 */

	$snippetmaster->set(TITLE, $TITLE);



	/* Set to 1 to convert new lines ("\n") to line breaks ("<br>"), otherwise set to 0 */

	$snippetmaster->set(CONVERT, $CONVERT);



	/* Set to 1 to allow HTML tags, otherwise set to 0 */

	/* NOTE: if this is set to 0, any existing HTML will not be displayed */

	$snippetmaster->set(HTML, $HTML);



	/* Set email address for reporting errors */

	$snippetmaster->set(EMAIL, $EMAIL);



	/* Set report to 1 to email errors that occur */

	$snippetmaster->set(REPORT, $REPORT);

	//$snippetmaster->set(MESSAGE, $LICENSE_KEY);



?>