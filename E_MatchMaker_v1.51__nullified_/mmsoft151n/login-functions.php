<?
##############################################################################
#                                                                            #
#                        login-functions.php                                 #
#                                                                            #
##############################################################################
# PROGRAM : E-MatchMaker                                                     #
# VERSION : 1.51                                                             #
#                                                                            #
# NOTES   : site using default site layout and graphics                      #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2001-2002                                                    #
# Supplied by          : CyKuH [WTN]                                         #
# Nullified by         : CyKuH [WTN]                                         #
# Distribution:        : via WebForum and xCGI Forums File Dumps             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of MatchMakerSoftware             #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?

require_once("siteconfig.php");

class loginlib {
  function register ($username, $password, $password2, $f_name, $l_name, $email) {

    global $mmconfig;
    global $db;
    global $errorval;
    

    if (!$username || !$password || !$password2 || !$f_name || !$l_name || !$email) {
        return $errorval->loginerror[0];
      }
      else {
        if (!eregi("^[a-z ]+$", $f_name)) {
            return $errorval->loginerror[1];
          }
        if (!eregi("^[a-z ]+$", $l_name)) {
            return $errorval->loginerror[2];
          }
        if (!eregi("^([a-z0-9]+)([._-]([a-z0-9]+))*[@]([a-z0-9]+)([._-]+([a-z0-9]+))*[.]([a-z0-9]){2}([a-z0-9])?$", $email)) {
            return $errorval->loginerror[3];
          }
        if (strlen($username) < 3) {
            return $errorval->loginerror[4];
          }
        if (strlen($username) > 20) {
            return $errorval->loginerror[5];
          }
        if (!ereg("^[[:alnum:]_-]+$", $username)) {
            return $errorval->loginerror[6];
          }
        if ($password != $password2) {
            return $errorval->loginerror[7];
          }
        if (strlen($password) < 3) {
            return $errorval->loginerror[8];
          }
        if (strlen($password) > 20) {
            return $errorval->loginerror[9];
          }
        if (!ereg("^[[:alnum:]_-]+$", $password)) {
            return $errorval->loginerror[10];
          }

        $query = &$db->Execute("select id from login_data where username = '$username'");
        $result = $query->RecordCount();

        if ($result) {
            return $errorval->loginerror[11];
          }

        $query = &$db->Execute("select id from login_data where email = '$email'");
        $result = $query->RecordCount();

        if ($result) {
            return $errorval->loginerror[12];
          }

        $hash = md5($mmconfig->secret.$username);
        $is_success = $db->Execute("insert into login_confirm values ('$hash', '$username', '$password', '$f_name', '$l_name', '$email', now())");


        if (!$is_success) {
            return $errorval->loginerror[13];
          }

        @mail($email, "$mmconfig->website Registration", "Thank You, $f_name for registering at $mmconfig->website. \n\nHere 
is the login information we received :
                \nName     : $f_name $l_name \nEmail    : $email \nUsername : $username \nPassword : $password

                \nBefore you can access the site you will need to confirm the account by pointing your browser at
                \n$mmconfig->webaddress/confirm.php?hash=$hash&username=$username

                \nIf you did not apply for the account please ignore this message.",
                "From: EmailConfirm@$mmconfig->domain");

        return 2;
      }
  }

  function login ($username, $password) {

    global $mmconfig;
    global $db;

    if (!$username || !$password) {
        return $errorval->loginerror[14];
      }
      else {
        if (!eregi("^[[:alnum:]_-]+$", $username)) {
            return $errorval->loginerror[15];
          }
        if (!eregi("^[[:alnum:]_-]+$", $password)) {
            return $errorval->loginerror[16];
          }

        $query = &$db->Execute("select id from login_data where username = '$username' and password = '$password'");
        $result = $query->RecordCount();

        if ($result < 1) {
            return false;
          }
          else {
            $id = $query->Fields("id");
            $hash = md5($username.$mmconfig->secret);
            setcookie("mmcookie", "$username:$hash:$id", 0);
            $query = $db->Execute("update login_data set lastlogin = now() where username = '$username' and id = '$id'");
            if($query) {
              return 2;
            }
          }
      }
  }

  function is_logged () {

    global $mmconfig;
    global $mmcookie;

    $session_vars = explode(":", $mmcookie);

    $hash = md5($session_vars[0].$mmconfig->secret);

    if ($hash != $session_vars[1]) {
        return false;
      }
      else {
          return array($session_vars[0], $session_vars[2]);
        }
  }

  function logout () {

    global $mmconfig;

    setcookie("mmcookie");
    header("Location: $mmconfig->logout_url");

  }

  function confirm ($hash, $username) {

    global $mmconfig;
    global $db;

    if (!$hash || !$username) {
        return $errorval->loginerror[17];
      }
      else {

        $query = &$db->Execute("select * from login_confirm where mdhash = '$hash' AND username = '$username'");
        $result = $query->RecordCount();

        if (!$result) {
            return $errorval->loginerror[18];
          }

        $username = $query->Fields("username");
        $password = $query->Fields("password");
        $f_name = $query->Fields("f_name");
        $l_name = $query->Fields("l_name");
        $email = $query->Fields("email");

        $is_success_first = $db->Execute("insert into login_data (f_name, l_name, email, username, password, usersince) values ('$f_name', '$l_name', '$email', '$username', '$password', now())");

        if ($is_success_first) {
            $is_success_second = $db->Execute("delete from login_confirm where username = '$username'");

          }

        if (!$is_success_first) {
            return $errorval->loginerror[19];
          }

        if (!$is_success_second) {
            @mail($mmconfig->webmaster, "Alert, Purge Account!!!", "Database Error:\n
                  The Database errored out removing account $username from table login.confirm.\n
                  Please manually purge this account.", "From: EmailConfirm@$mmconfig->domain");
            return 2;
          }

        @mail($email, "$mmconfig->website Registration Confirmation", "Thank You, $f_name for confirming your email address at $mmconfig->website. \n
					\nHere is a copy of your login information for your records :
                                        \nName     : $f_name $l_name
                                        \nEmail    : $email
                                        \nUsername : $username
                                        \nPassword : $password
					\nNo games no gimmicks just singles. $mmconfig->webaddress
				\n\nThank you for selecting $mmconfig->website. We look forward to your next visit.", "From: EmailConfirm@$mmconfig->domain");

        return 2;

      }
  }

  function conf_flush () {

    global $mmconfig;
    global $db;

    $query = $db->Execute("delete from login_confirm where date_add(date, interval 2 day) < now()");

    if (!$query) {
        return $errorval->loginerror[20];
      }
    return 2;
  }

  function lostpwd ($email) {

    global $mmconfig;
    global $db;

    if (!$email) {
        return $errorval->loginerror[21];
      }

    $query = &$db->Execute("select username, password, f_name from login_data where email = '$email'");
    $result = $query->RecordCount();

    if (!$result) {
        return $errorval->loginerror[22];
      }

    $username = $query->Fields("username");
    $password = $query->Fields("password");
    $f_name = $query->Fields("f_name");

    @mail($email, "Account Info", "Hello $f_name,\nAs per your request here is your account information:\n
                                \nUsername: $username
                                \nPassword: $password
                                \nWe hope you remember your password next time!", "From: support@$mmconfig->domain");

    return 2;
  }

  function chemail ($id, $email, $email2) {

    global $mmconfig;
    global $db;

    if ($email != $email2) {
        return $errorval->loginerror[23];
      }

      else {
        if (!eregi("^([a-z0-9]+)([._-]([a-z0-9]+))*[@]([a-z0-9]+)([._-]([a-z0-9]+))*[.]([a-z0-9]){2}([a-z0-9])?$", $email)) {
            return $errorval->loginerror[24];
          }

        $query = &$db->Execute("select id from login_data where email = '$email'");
        $result = $query->RecordCount();

        if ($result) {
            $id_from_db = $query->Fields("id");
            if ($id_from_db != $id) {
                return $errorval->loginerror[25];
              }
            return $errorval->loginerror[26];
          }

        $mdhash = md5($id.$email.$mmconfig->secret);

        $query = $db->Execute("insert into login_confirm_email values ('$id', '$email', '$mdhash', now())");

        if (!$query) {
            return $errorval->loginerror[27];
          }
        @mail($email, "$mmconfig->website Email Change", "Dear User, You have requested an email change \n
                   in our database. We, to ensure authenticity of the email address,\n
                   expect you to goto $mmconfig->webaddress/confirm_email.php?mdhash=$mdhash&id=$id&email=$email
                   \n\n Thank You!");

        return 2;
      }
  }

  function confirm_email($id, $email, $mdhash) {

    global $mmconfig;
    global $db;

    if (!$id || !$email || !$mdhash) {
        return $errorval->loginerror[28];
      }
      else {

        $query = &$db->Execute("select * from login_confirm_email where id = '$id' AND email = '$email' AND mdhash = '$mdhash'");
        $result = $query->RecordCount();

        if (!$result) {
            return $errorval->loginerror[29];
          }

        $update = $db->Execute("update login_data set email = '$email' where id = '$id'");
        $delete = $db->Execute("delete from login_confirm_email where email = '$email'");


        return 2;
      }
  }

  function email_flush () {

    global $mmconfig;
    global $db;

    $query = $db->Execute("delete from login_confirm_email where date_add(date, interval 2 day) < now()");

    if (!$query) {
        return $errorval->loginerror[30];
      }
    return 2;
  }

  function chpass ($id, $password, $password2) {

    global $mmconfig;
    global $db;

    if ($password != $password2) {
        return $errorval->loginerror[31];
      }
      else {
        if (strlen($password) < 5) {
            return $errorval->loginerror[32];
          }
        if (strlen($password) > 20) {
            return $errorval->loginerror[33];
          }
        if (!ereg("^[[:alnum:]_-]+$", $password)) {
            return $errorval->loginerror[34];
          }

        $query = $db->Execute("update login_data set password = '$password' where id = '$id'");

        if (!$query) {
            return $errorval->loginerror[35];
          }
        return 2;
      }
  }

  function delete($id) {

    global $mmconfig;
    global $db;

    $query = &$db->Execute("delete from login_data where id = '$id'");

    return 2;
  }

}

$loginlib = new loginlib;

?>
