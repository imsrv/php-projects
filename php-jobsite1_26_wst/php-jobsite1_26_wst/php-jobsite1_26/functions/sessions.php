<?php
############################################################
# php-Jobsite(TM)                                          #
# Copyright © 2002-2003 BitmixSoft. All rights reserved.   #
#                                                          #
# http://www.scriptdemo.com/php-jobsite/                   #
# File: application_config_file.php                        #
# Last update: 08/02/2003                                  #
############################################################
//session management functions
  function bx_session_start() {

    return session_start();

  }

  function bx_session_register($variable) {

    return session_register($variable);

  }

  function bx_session_is_registered($variable) {

    return session_is_registered($variable);

  }

  function bx_session_unregister($variable) {

    return session_unregister($variable);

  }

  function bx_session_destroy() {

    return session_destroy();

  }

  function bx_session_id() {

    return session_id();

  }
?>