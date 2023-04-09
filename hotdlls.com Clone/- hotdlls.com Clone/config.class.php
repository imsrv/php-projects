<?php

class config {


  var $site_url = "http://www.yoursite.com/";  // Your sites url

  var $site_name = "DailyX Downloads";      // Your sites name

  var $site_mail = "youremail@yoursite.com";     // Your e-mail



  var $r_user = "admin";            // Admin Username (Case Sensitive)

  var $r_pass = "admin";            // Admin Password (Case Sensitive)



  var $limit = 40;              // Number of downloads per page

  var $max_dl = 0;              // Maximum numbers of downloads in database (0 for unlimited)

  var $date_format = "d-m-Y";          // How the dates shall be displayed (Y = year, m = month, d = date) ex. (24-12-2002)



  var $admin_email = "youremail@yoursite.com";              // Your e-mail

  var $mysql_host = "localhost";        // MySQL host - usually localhost

  var $mysql_user = "dusername";          // MySQL username

  var $mysql_pass = "dpass";          // MySQL password

  var $mysql_db = "dname";            // Your MySQL database



  var $type = array(              // The different types of downloads - you see how it goes

    "Apps",                  // You can have as many (or few) categories as you want

    "Games",

    "Music",

    "Movies",

    "Other",

    "XXX",

  );



  ######################################################################

  ##   DONT EDIT BELOW THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING!   ##

  ######################################################################



  var $mysql_tb_dl = "downloads";        // The downloads table

  var $mysql_tb_que = "que";          // The table for downloads submitted but not reviewed

  var $mysql_tb_le = "linker";        // The links information

  var $mysql_tb_ip = "iplogg";        // Ip-logging, for anti-cheating (and for you to check if you suspect cheating)

  var $connect = false;



  function option_list() {

    for ($i=0; $i<count($this->type); $i++) {

      $return .= "<select>
  <option>".$this->type[$i]."</option>";

    }

    return $return;

  }



  function open() {

    $this->connect = @mysql_connect($this->mysql_host, $this->mysql_user, $this->mysql_pass)

      or die("Reinstall <a href=\"mailto:".$this->admin_email."\">".$this->admin_email."</a>");

    @mysql_select_db($this->mysql_db)

      or die("Failed to connect to databases, contact <a href=\"mailto:".$this->admin_email."\">".$this->admin_email."</a>");

  }



  function close() {

    @mysql_close($this->connect);

  }



  function dato() {

    $dato = date($this->date_format);

    return $dato;

  }



  function run($list) {

    $check_first = 1;

    for ($i=0; $i<count($list); $i++) {

      if ($check_first) {

        $hvahvor = "id = '".$list[$i]."'";

        $check_first = 0;

      } else

        $hvahvor .= " || id = '".$list[$i]."'";

    }

    return $hvahvor;

  }



  function page($url) {

    global $page;

    $pages=1;

    for ($starter=0; $this->total>$starter; $starter+=$this->limit) {

      if ($pages != $page)

        echo "<a href=\"".$url.$pages."\" class=\"page\">$pages</a> \n";

      else

        echo "<b>[ $pages ]</b> \n";

    $pages++;

    }

  }



  function blacklist($url) {

    $fil = @file("blacklist.txt");

    $go = false;

    for ($i=0; $i<count($fil); $i++) {

      if (eregi(substr($fil[$i], 0, strlen($fil[$i])-3), $url)) {

        $go = true;

        break;

      }

    }

    if ($go)

      return true;

    else

      return false;

  }

}

?>