Thank you for downloading Tizag PHP Counter

----------------------------------------
 1. Installation Guide
----------------------------------------

	Unzip tizag-counter.zip to the web directory which contains the web pages that will have
the counter on them.  After you have unzipped the files, CHMOD 777 the file "stats".  If you
do not CHMOD the "stats" file then the counter will not function properly.

	Next, load the "install.php" web page, set the initial count for the counter and
pick the counter style you would like displayed.  Hit Update / Install at the bottom
of the page to set the information and you're done!

----------------------------------------
 2. Placing The Counter
----------------------------------------

	After completing the installation, simply copy and paste the following code
onto your webpages to place the counter.

Code: 
	<?php include ("counter.php"); ?>
	
	Place this code on every webpage that you want the counter displayed.  
NOTE: The files must be in the same directory as the web pages for the counter to
work with these given directions.  

NOTE 2: Be sure that all the web pages that are going to include the counter have
the extension ".php" because the code above is PHP and will not work on a web page
with a ".html" extension.

----------------------------------------
 2. Cleanup
----------------------------------------
	It is recommended that you removed "install.php" after you have completed
the installation process.