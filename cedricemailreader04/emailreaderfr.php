<?
// ************************************************************
// * Cedric email reader, lecture des emails d'une boite IMAP.*
// * Function library for IMAP email reading.                 *
// * Realisation : Cedric AUGUSTIN <cedric@isoca.com>         *
// * Web : www.isoca.com                                      *
// * Version : 0.4                                            *
// * Date : Septembre 2001                                    *
// ************************************************************

// This job is licenced under GPL Licence.


// Check if user has a profil
$ini_file = 'perso/'.$username.'/emailreader.ini.php';
if(file_exists($ini_file)){ // this user is registered and have his own profil
    $emailreader_ini = $ini_file;
} else { // no profile, so use default profile
    $emailreader_ini = 'common/emailreaderdefault.ini.php';
};

// According to server type, include the right library
// this value could be imap, pop or news. With version 0.4 only imap is suported
if(!isset($server_type)){
    $server_type = $cer_server_type;
};
include('lib/'.$server_type.'.inc.php');

// now test if user and password are ok 
if($mbox = @open_mailbox($server, $username, $password)){ // ok, let's go
    close_mailbox($mbox);
    $param = "server=$server&username=$username&password=$password&server_type=$server_type&lang=$lang&emailreader_ini=$emailreader_ini";
    $login=imap_binary($param);
} else { // login or password error
    header("Location: emailreaderloginerror.php?server=$server&username=$username&lang=$lang");
    exit;
};

?>

<html>
<head>
   <title>Webmail - Isoca.com</title>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<frameset cols="109,*" frameborder="NO" border="0" framespacing="0"> 
    <frame src="emailreaderfrleftpanel.php?&login=<? echo $login; ?>" name="leftpanel" scrolling="NO" frameborder="NO" noresize>
    <frameset rows="250,*" cols="*" frameborder="NO" border="1" framespacing="1" bordercolor="#ECECEC"> 
        <frame src="emailreaderlist.php?&login=<? echo $login; ?>" name="listpanel" scrolling="YES" frameborder="NO" bordercolor="#ECECEC">
        <frame src="blanck.html" name="detailpanel">
    </frameset>
</frameset>

<noframes>
  <body bgcolor="#FFFFFF">
  Your browser should be at least version 4 to support frame (IE, Netscape or Mozilla)
  </body>
</noframes>

</html>
