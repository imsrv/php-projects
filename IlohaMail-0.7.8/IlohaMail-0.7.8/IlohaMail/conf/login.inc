<?
/********************************************************
	conf/defaults.inc
		
	PURPOSE:
		Configuration options for login screen

********************************************************/

/***************** HOSTS *******************************
	The $host variable is used to determine how the user
	specifies the email server to log into.
********************************************************/

// default.  index.php will display an empty text box
$default_host = "";


//	Use the following to hard code the server.  If the
//	following line is used, index.php will not allow
//	users to specify any other server
//
//$default_host = "imap.example.com";


//	Use the following if you have multiple supported
//	servers, from which users can choose from.
//
//$default_host = array(
//	"red.example.com"=>"Red", 
//	"green.example.com"=>"Green", 
//	"imap.example.com"=>"imap.example.com"
//	);



/***************** ADVANCED ****************************
	The "advanced" login screen allows the users to specify
	the protocol (POP/IMAP) as well as the root directory,
	in addition to the standard parameters.
	Set the value to 0 if you do not want to give users 
	the ability to specify the protocol or rootdir.
********************************************************/

$adv_mode = 1;



/***************** Default Port *************************
	Specify the default port.  If "advanced" mode is enabled,
	the value specified here will be the default value, but
	the user will be able to change it.
	IlohaMail currently does not support nonstandard ports.
	Ports:
		143 for IMAP
		110 for POP3
********************************************************/

$default_port = 143;



/***************** Default Root Direcotry ***************
	Specify the default rootdir.  If "advanced" mode is 
	enabled, the value specified here will be the default 
	value, but the user will be able to change it.
********************************************************/

$default_rootdir = "";



/***************** Default Root Direcotry ***************
    Default language to use if user doesn't specify one
    when first logging in.  See include/langs.inc for
    available languages.
********************************************************/

$default_lang = "eng/";




/******************* Show / Hide Fields *****************
	The following directives allow you to hide some of
	the fields in the login screen.
	A default value should be specified  above, if the
	fields are hidden.
	Values:
		1 = Hide
		0 = Show (default)
********************************************************/

$hide_host = 0;

$hide_protocol = 0;

$hide_rootdir = 0;



/******************* Log out redirect *******************
    URL to be redirected to after user logs out.  Default
    is "index.php" which is the login screen.
********************************************************/

$logout_url = "index.php";

?>