<?
/*
   File name         : global.inc
   Version           : 1.1.3
   Last Modified By  : Umut Gokbayrak
   e-mail            : umut@trlinux.com
   Purpose           : Global configuration File for Postaci Webmail
   Last modified     : 7 Nov. 2000
*/

  // 1.
  // you should select the default language. version 1.1.1 defaults to English
  // Possible values : english, portugues, dutch, deutsch, italiano, turkce, espanol, 
  // francais, norsk, polski

  $default_lang = "english";

  // 2.
  // Select the database engine. Possible values are postgresql, mysql, msql, sybase, mssql.
  // You can find the default sql queries in queries directory for mysql, postgresql and mssql
  // MS SQL support is under test please report any errors/improvements to
  // "Umut Gokbayrak" <umut@trlinux.com>

  $database_type = "mysql";

  // 3.
  // Specify the hostname where database is located. It may be an IP number, hostname or dns name
  // You should grant usage to the webmail server(IP) and database user the select, insert, delete,
  // update permissions in order to install Postaci if the database server is a remote one.
  // See INSTALL file for details. If Postaci is on the database server no need to change this.

  $database_host = "localhost";

  // 4. The database name, username and password.
  // YOU REALLY NEED TO CHANGE THESE.

  $database_user = "DATABASE_USER";
  $database_user_pass = "DATABASE_USER_PASSWORD";
  $database_name = "postaci";

  // 5.
  // You should select which protocol to use. Postaci supports both IMAP and POP3 mailboxes.
  // Possible values : imap, pop3

  $default_protocol = "imap";

  // 6.
  // The POP3/IMAP servername, IP or DNS name. If Postaci is on the POP3/IMAP server, no need
  // to change this.

  $default_host = "localhost";

  // 7.
  // Default port for IMAP access is 143 and it is 110 for POP3. If yours is different simply
  // change this value. If you are not sure leave as default.

  $default_port = "143";

  // 8.
  // SMTP host information. Postaci can use another relay server for sending mail. If $smtp_host is
  // left as default value(localhost) things will go slightly faster. If you want to use another SMTP
  // server for sending e-mail you can use the IP, hostname or DNS name here.
  // If a remote server is defined here, Postaci will try to connect to the server via SMTP port and
  // try to deliver the mail. This is work in progress, so please report any success or failure.
  // SMTP servers normally reside on port 25. So you normally don' t need to change $smtp port value.

  $smtp_host = "localhost";
  $smtp_port = "25";

  // 9.
  // $attach_directory is the place where Postaci uploads the attachments to be sent for temporary
  // storage.
  // DO NOT FORGET THE TAILING SLASH!!!, YOU REALLY NEED TO CHANGE THIS.

  $attach_directory = "/tmp/postaci/send/";

  // 10.
  // postaci_directory is where the Postaci installation resides on your directory structure.
  // This varible is really important. If you do not set it you will get an empty screen.
  // DO NOT FORGET THE TAILING SLASH!!! YOU REALLY NEED TO CHANGE THIS

  $postaci_directory = "/home/httpd/htdocs/postaci/";

  // 11.
  // Although Cyrus IMAP has some slight differences, Postaci seems to work with all IMAP servers.
  // In case you need it set this value to true and please report any incompatibilities.

  $cyrus_imap_server = false;

  // 12.
  // If you are using POP3 protocol, you should have a non-web accessable directory for
  // storing attachments. This directory' s permissions should be 700 and the owner should be nobody
  // (the user that runs the httpd). Although you don' t use POP3 this directory should lead to an
  // existing directory. (Ex : /tmp)
  // DO NOT FORGET THE TAILING SLASH!!!

  $pop3_attach_dir = "/tmp/postaci/store/";

  // 13.
  // You set the title here.

  $title = "Postaci Webmail 1.1.3";

  // 14.
  // Seperator is the value used for limiting the number of messages to be shown at each page.
  // NO NEED TO CHANGE THIS.

  $seperator = 15;

  // 15.
  // Operating system. As from version 1.1.1, Postaci both supports Unix/Linux/BSD and Windows systems.
  // You can select you operating system here.
  // Possible values : windows, unix

  $operating_system = "unix";

  // 16.
  // This is the error value for PHP configuration. If you think you have found a bug or want to
  // contact the author, comment the following line with two slashes and e-mail the error/warning messages to
  // "Umut Gokbayrak <umut@trlinux.com>"

  error_reporting(32);

  // 17.
  // Please enter your TEMP directory here. This directory is used for temprarily storing session files.
  // Windows port of PHP doesn't handle TEMP directories by itself so Windows users need to specify it here.
  // It can be any directory with appropriate permissions. Just uncomment it (delete two slashes) and assing
  // the correct value.
  // WINDOWS USERS NEED THIS.

  // $temp_directory = "c:\\temp";

  // 18.
  // If you want to remove that sponsored by... banner simply change this value to false.

  $show_sponsor = true;

  // 19.
  // Qmail users which store accounts and messages in databases require special login format. In order to avoid
  // this imcompatibility simply change this value to true.

  $qmail_support = false;

  // 20.
  // You can specify a footer text for every message outgoing from the server.
  // This field is optinal. If you need a new line in the text, use \n for the purpose.

  $footer_message = "---------------------------------------\nThis message was sent using Postaci Webmail. (http://www.trlinux.com)";

  // 21.
  // To cope with courier-imap personal folders

  $courier_imap_support = false;

  // The following only are considered if courier-imap support is on
  // If php imap supports NAMESPACE server extension (RFC2342) this
  // could be configured automatically.
  // DO NOT FORGET THE TRAILING PERIOD

  $personal_namespace = "INBOX.";

  // 22. 
  // Decide which language selections to show in the main page. 
  // If any language is set to true a button will appear
  // on the intro screen which will let you use Postaci using that language settings. 
  // Possible values : true and false

  $turkce_support     = false;
  $english_support    = false;
  $francais_support   = false;
  $deutsch_support    = false;
  $polski_support     = false;
  $espanol_support    = false;
  $portugues_support  = false;
  $dutch_support      = false;
  $norsk_support      = false;
  $italiano_support   = false;

/**************************************************************/
/*          No Need to change anything below.                 */
/**************************************************************/

  $postaci_version = "1.1.3";
  if ($operating_system == "windows") {
    session_save_path($temp_directory);
  }

  session_start();
  $to_folder = "Sent Items";

  if (trim($l) != "" && trim($l) != '$lang_choice') {
    $lang_choice = $l;
  } else {
    if ($lang_choice == "") {
      $lang_choice = $default_lang;
    }
  }

  switch ($lang_choice) {
    case "portugues":
    case "dutch":
    case "deutsch":
    case "italiano":
    case "francais":    
    case "norsk":
    case "turkce":
    case "espanol":
    case "polski":
    case "english":
      include("$postaci_directory" . "lang/" . "$lang_choice" . ".inc");
      break;
    default:
      die("<center><font color='red'><p><b>Invalid language selection</b></p></font></conter>");
  }

  include("$postaci_directory" . "classes/phpDB.inc");

  $db = new phpDB();
  $db->pconnect("$database_host", "$database_user", "$database_user_pass", "$database_name") or die ("<center><font color='red'><p><b>$text75</b></p></font></conter>");
?>
