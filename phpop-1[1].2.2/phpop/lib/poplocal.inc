<?php
# ---------------------------------------------------------------
# phpop
# A WWW based POP3 basic mail user agent (MUA)
# Copyright (C) 1999  Padraic Renaghan
# Licensed under terms of GNU General Public License
# (see http://www.renaghan.com/phpop/source/LICENSE)
# ---------------------------------------------------------------
# $Id: poplocal.inc,v 1.12 2000/07/06 15:08:50 prenagha Exp $
# ---------------------------------------------------------------
# Our local versions of the PHPLIB classes.

class pop_db extends DB_Sql {
  var $Host     = "localhost";
  var $Database = "phpop";
  var $User     = "test";
  var $Password = "test";
  
  var $Auto_Free     = 1;     ## Set to 1 for automatic mysql_free_result()
  var $Debug         = 0;     ## Set to 1 for debugging messages.
  var $Halt_On_Error = "yes"; ## "yes" (halt with message),
                              ## "no" (ignore errors quietly),
                              ## "report" (ignore errror, but spit a warning)
}

class pop_Template extends Template {

  var $classname = "pop_Template";

  /* if set, echo assignments */
  /* 1 = debug set, 2 = debug get, 4 = debug internals */
  var $debug     = false;

  /* Template searches for files in one of these directories */
  var $root   = array( "./lib/templates" );

  /* "remove"  => remove undefined variables
   * "comment" => replace undefined variables with comments
   * "keep"    => keep undefined variables
   */
  var $unknowns = "remove";
  
  /* "yes" => halt, "report" => report error, continue, 
   * "no" => ignore error quietly 
  */
  var $halt_on_error  = "yes";

}


class pop_ct_sql extends CT_Sql {
  var $database_class = "pop_db";          ## which database to connect
  var $database_table = "active_sessions"; ## find session data in this tbl
}

/*
# I tried switching out the ct_sql class with ct_dbm so you
# wouldn't be required to have a database with PHPOP. I had
# trouble with file locking when using dbm files. You might
# have better luck. If you want to try the dbm files for 
# session data you need to:
#  change poprepend.inc to include the ct_dbm file and
#    not include the ct_sql and db_mysql files
#  uncomment the pop_ct_dbm section below
#  comment out the pop_ct_sql and pop_db sections above
#  change the $that_class var in pop_sess below to refer
#    to the pop_ct_dbm class
#  update the filename in pop_ct_dbm and make sure the
#    file exists and is writeable by the server.
#
# Let me know if you get it to work.
#
class pop_ct_dbm extends CT_DBM {
	var $dbm_file = "/home/httpd/phpop-session.dbm";    ## PREEXISTING DBM File 
                         ## writable by the web server UID
}
*/

class pop_sess extends Session {
  var $classname      = "pop_sess";
  var $cookiename     = "";                ## defaults to classname
  var $auto_init      = "";
  var $magic          = "054378354";       ## ID seed
  var $mode           = "cookie";          ## We propagate session IDs with cookies
  var $fallback_mode  = "get";
  var $lifetime       = 0;                 ## 0 = do session cookies, else minutes
  var $gc_time  = 90;                      ## Purge all session data older than x minutes.
  var $gc_probability = 1;                 ## Garbage collect probability in percent
  var $gc_probability = 5;  
  
  var $allowcache     = "no";              ## if you want to allow caching
  var $allowcache_expire = 30;             ## cached pages expire in this many
                                           ## minutes

  var $that_class = "pop_ct_sql";          ## Name of data storage container
}

class pop_auth extends Auth {
  var $classname      = "pop_auth";
  var $lifetime       =  120;
  var $mode           = "log";         ## "log" for login only systems,
                                       ## "reg" for user self registration
  var $nobody         = false;         ## If true, a default auth is created...
  var $magic          = "857348a7f";   ## ID seed

  function auth_loginform() {
    include(LIBDIR . "poplogin.inc");
  }
  
  function auth_validatelogin() {
    global $username, $password, $popserver, $popport, $phpop, $sess, $pop3;

    if (empty($username)) return false;

    $this->auth["uname"]=$username;   

    # create a bogus uid for this user.
    $uid = md5(uniqid($username));

    # figure out what to use as the mail server
    if (!$phpop->login_servers) {
      $mailserver = $popserver;
    } else {
      if (sizeof($phpop->login_servers) == 1) {
        $mailserver = $phpop->login_servers[0];
      } else {
        $mailserver = "no.hacking.allowed";
        reset($phpop->login_servers);
        while (list($index, $server) = each ($phpop->login_servers)) {
          if ($server == $popserver) {
            $mailserver = $server;
          }
        }
      }
    }

    if ($phpop->login_port && $phpop->login_port > 0) {
      $mailport = $popport;
    } else {
      $mailport = $pop3->PORT;
    }

    # connect to the pop server
    if ( ! $pop3->connect($mailserver, $mailport) ) {
      echo "<p>Failed to connect to POP server $mailserver on port $mailport.<br><small>$pop3->ERROR</small>";
      return false;
    }

# login to the POP server
    $count = $pop3->apop($username, $password);
    if ( $count < 0 ) {
      echo "<p>Failed to login to POP server<br><small>$pop3->ERROR</small>";
      return false;
    }
    $pop3->quit();

    $this->auth["passwd"]=$password;
    $this->auth["server"]=$mailserver;
    $this->auth["port"]=$mailport;

    return $uid;
  }
}
?>
