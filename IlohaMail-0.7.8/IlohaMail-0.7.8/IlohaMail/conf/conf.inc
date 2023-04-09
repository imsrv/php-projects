<?
/********************************************************
	conf/conf.inc
	
	PURPOSE:
		General settings and configuration.

********************************************************/

/***************** BACKEND ****************
	IlohaMail supports multiple backends, namely, file
	and/or database based.  If a database backend is used,
	a file-based backend can still be used to certain
	features.
	
	Set the value of $backend to one of the following:
		"FS" : default, file-based
		"MySQL" : MySQL based
*/
$backend = "FS";


/********************* LOG *****************
	The log feature in IlohaMail logs all log in/out
	attempts, and works with both file-base and DB-based
	backends.  The log feature is deactivated by default.
*/

//	Set the following value to true to active logging
$log_active = false;

//	Log backend
//	The log backend defaults to $backend, but falls
//	back to "FS" if $log_file (below) is set.
//	In other words, the options are:
//		"": default
//		"syslog" : log to syslog
$log_backend = "";

//	Log file path (file-based backend only)
//	Use relative path to source file, or absolute path
//	PHP must have write privileges to the file and/or
// 	parent directory.
$log_file = "";

//	Template entry (file-based backend only)
//	The log feature will take this line, and replace the
//	keywords with appropriate information to enter in the
//	log.  Use any combination of the following keywords:
//		"date" : date and time
//		"ip" : client IP address
//		"acct" : if available, email account and server
//		"comment" : Error messages or comments
$log_template = "[date] ip:acct - action (comment)";


/**************** Spam Prevention ************
	This feature is not for blocking incoming spam, but 
	for preventing possible use of IlohaMail for spamming
	purposes.
	
	This will involve a three-level approach.
	Level 1: Restrict number of recepients per email
	Level 2: Restrict number of recepients per session
	Level 3: Set minimum interval between sending
	
	In a restrictive setting, a spammer may be forced
	to send to 10 people at a time, once every minute
	and log out and log back in after sending 5 messages.  
	This should effectively discourage manual and automated 
	spamming.
*/

//	Maximum number of recepients per message.
//	Will count To,CC,BCC fields.  More specifically
//	it will count the number of '@' symbols.
$max_rcpt_message = 50;

//	Maximum number of recepients per session.
//	Note: This is not the number of messages,
//	but the total number of recepients.
$max_rcpt_session = 100;

//	Minimum interval between send operations,
//	in seconds.
$min_send_interval = 15;


/**************** spam reporting *************
	Specify an email address, if one is available,
	where users can report spam.  This will add a
	link in the read message window allowing users
	to report spam in two simpl clicks.
	
	Leave the string empty to disable this feature.
*/

$report_spam_to="";


/***************** Auth Mode ***************
	Specify default IMAP authentication method.
	Choices are:
		"plain" : 	Always use plain text
					Greatest compatibility
					
		"auth"	:	Try encrypted authenctication
					(CRAM-MD5), first, then plain
					
		"check" :	Check the server's capabilities
					for CRAM-MD5, and use appropriate
					auth method.
*/

$AUTH_MODE = "plain";


/***************** Time Limit ***************
	Set maximum execution time.  Opening mailboxes
	with even thousands of messages shouldn't have
	problems, but a large POP account may time out.
	
	Set value to 0 for unlimited timeout.
*/

$MAX_EXEC_TIME = 60;


/***************** Trust User Address ********
    This directive specifies whether to use the
    user specified email address in the From header.
    
    When on (set to true or 1):
        User specified address is used in From header
        Authenticated email address used for Sender header
        *the 'init_from_address' should be set if mail
    When off (set to false or 0):
        Authenticated email address used for From header
        User specified address used in Reply-To header
        
    Note:
        The 'init_from_address' option needs to be configured
        in conf/defaults.generic.inc (or defaults.host.inc)
        if server host name is not same as email domain name
        e.g. 
            if server is imap.domain.com but email address
            is user@domain.com
         
*/

$TRUST_USER_ADDRESS = 0;


/***************** SMTP Server  **************
	SMTP server to use.  Default is "localhost",
	however any SMTP server that'll allow relaying
	from your webmail server can be used.
	Authenticated SMTP is currently not supported.
*/

$SMTP_SERVER = "localhost";

?>
