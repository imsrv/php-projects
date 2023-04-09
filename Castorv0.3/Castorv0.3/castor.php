<?php
/****************************************************************************
*    Copyright (C) 2000 Bleetz corporation
*                       Carmelo Guarneri.
*    This program is free software; you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation; either version 2 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program; if not, write to the Free Software
*    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*****************************************************************************
*/
/*
 * Castor V.0.3 8 may 2000
 */
$SUBMITDATA = Array (
/*
"Somewhere" => Array (
   "where"  => "somewhere.com",    // server where we post our request
   "wzone"  => "WRD",              // world zone of server
   "method" => "GET",              // method used for request
                                   // template url for submission
   "url"    => "http://somewhere.com?q={url}&e={email}",
                                   // string displayed in case of success
   "success" => array ( "has been scheduled for addition" ),
                                   // string displayed in case of failure
   "failure"=> array ( "Invalid URL", "URL was not added" )
   ),
*/
"Altavista" => Array (
   "where"  => "Altavista.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://add-url.altavista.com/cgi-bin/newurl?q={url}&ad=1",
   "success" => array ( "Thank you for your submission" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid", "Too many URLs at that site have been submitted today" )
   ),
"AllTheWeb" => Array (
   "where"  => "AllTheWeb.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://www.ussc.alltheweb.com/add_url_done.php3?url={url}&email={email}&Submit=Add+URL",
   "success" => array ( "has been scheduled for addition" ),
   "failure"=> array ( "Invalid URL", "URL was not added" )
   ),
   /*
   is part of dmoz open diretory project
"aol" => Array (
//bad
   "where"  => "Aol.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://netfind.aol.com/cgi/nfadd_url.cgi?look=netfind&url={url}&email={email}",
   "success" => array ( "has been scheduled for addition" ),
   "failure"=> array ( "Invalid URL", "URL was not added" )
   ),
   */
"excite" => Array (
   "where"  => "Excite.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://www.excite.com/cgi/add_url.cgi?look=excite&url={url}&email={email}",
   "success" => array ( "Your site has been submitted" ),
   "failure"=> array ( "Invalid URL", "URL was not added" )
   ),
"google" => Array (
   "where"  => "Google.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://www.google.com/addurl?q={url}&dq=",
   "success" => array ( "successfully added" ),
   "failure"=> array ( "Invalid URL", "URL was not added" )
   ),
"hotbot" => Array (
   "where"  => "Hotbot.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://hotbot.lycos.com/addurl.asp?MM=1&success_page=http://www.hotbot.com/addurl.asp&failure_page=http://www.hotbot.com/oops.asp&ACTION=subscribe&SOURCE=hotbot&ip={REMOTE_HOST}&redirect=http://www.hotbot.com://addurl2.html&newurl={url}&email={email}&send=Add+my+URL",
   "success" => array ( "Web site added" ),
   "failure"=> array ( "email field blank", "invalid email address" )
   ),
"go" => Array (
   "where"  => "Go.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://www.go.com/AddUrl/AddingURL?url={url}&CAT=Add%2FUpdate+Site&sv=AD",
   "success" => array ( "successfully submitted" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   ),
"lycos" => Array (
   "where"  => "Lycos.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://www.lycos.com/cgi-bin/spider_now.pl?query={url}&email={email}",
   "success" => array ( "We successfully spidered your page" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   ),
"Northernlight" => Array (
   "where"  => "Northernlight.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://urls.northernlight.com/cgi-bin/urlsubmit.pl?page={url}&contact=Webmaster&email={email}",
   "success" => array ( "Thank you for your URL submission." ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   ),
"webcrawler" => Array (
   "where"  => "Webcrawler.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://www.webcrawler.com/cgi-bin/add_url_new.cgi?Service=webcrawler&url={url}&email={email}",
   "success" => array ( "has been submitted" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   ),
   /*
"Intersearchde" => Array (
   "where"  => "de.Intersearch.net",
   "wzone"  => "DE",
   "method" => "GET",
   "url"    => "http://de.intersearch.net/cgi-bin/add?u={url}&e={email}",
   "success" => array ( "Got it! Your Web site will be added" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   ),
"intersearchau" => Array (
   "where"  => "austria.Intersearch.net",
   "wzone"  => "AU",
   "method" => "GET",
   "url"    => "http://austria.intersearch.net/cgi-bin/add?u={url}&e={email}",
   "success" => array ( "Got it! Your Web site will be added" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   ),*/
   /*
   //part of open directory project
"Webwombat" => Array (
   "where"  => "Webwombat.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://www.webwombat.com/Wregister?newurl={url}&email={email}",
   "success" => array ( "Got it! Your Web site will be added" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   ),
   */
"Voila" => Array (
   "where"  => "Voila.fr",
   "wzone"  => "FR",
   "method" => "GET",
   "url"    => "http://www.voila.fr/submit?url={url}&email={email}",
   "success" => array ( "Votre site Web sera rapidement visit" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   ),
"Infomak" => Array (
   "where"  => "Infomak.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://url.infomak.com/?site=home_zz&url={url}&email={email}&Page=url",
   "success" => array ( "Your URL has been added to our list" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   ),
"WebTop" => Array (
   "where"  => "WebTop.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://www.webtop.com/cgi-bin/addurl?NEWURL={url}&EMAIL={email}&Submit=Add+URL",
   "success" => array ( "confirm the addition of this" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   ),
"Anzwers" => Array (
   "where"  => "Anzwers.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://www.Anzwers.com/cgi-bin/print_addurl.pl?url={url}&email={email}&Submit=Submit",
   "success" => array ( "Success! Your URL has been added" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   ),
"Whatyouseek" => Array (
   "where"  => "Whatuseek.com",
   "wzone"  => "WRD",
   "method" => "GET",
   "url"    => "http://add.whatuseek.com/cgi-bin/addurl.cgi?submit=Add+This+URL&url={url}&email={email}",
   "success" => array ( "Thank you for submitting your site to whatUseek" ),
   "failure"=> array ( "not a valid URL", "page is no longer valid" )
   )
);

Class Castor {
    var $classname = "Castor";
    var $debug=0;

//internal variables
    var $buffer;
    var $debug=0;

    var $proxy_host     =   "";                 // proxy host to use
    var $proxy_port     =   "";                 // proxy port to use

function Castor($proxy_host="",  $proxy_port="") {
  $this->proxy_host=$proxy_host;
  $this->proxy_port=$proxy_port;
}

function fetchURL($URI) {
  $buffer="";
  $this->status=0;
  $snooper = new Snoopy;
  $snooper->proxy_host=$proxy_host;
  $snooper->proxy_port=$proxy_port;
  $snooper->read_timeout=3;
  $snooper->_fp_timeout=2;
  $code=$snooper->fetch($URI);
  if($code)
  {
     /*
     while(list($key,$val) = each($snooper->headers))
       echo $key.": ".$val."<br>\n";
     echo "<p>\n";
     */
     $buffer=$snooper->results;
     $this->buffer=$buffer;
     $this->status=$snooper->status;
     //return True;
  }
  else 
  {
     $this->status=$snooper->status;
  };
  return $this->status==200;
}

function submitengine($engine, $params) {
  $this->buffer="";
  //this is the engine template url
  $surl=$engine["url"];
  //this is the url to submit
  $eurl=urlencode($params["url"]);
  $email=urlencode($params["email"]);
  $URI= preg_replace( array("/{url}/", "/{email}/"), array($eurl, $email), $surl);

  if ($this->debug)
    echo $URI;
  //$URI=$params["url"];
  if ($this->fetchURL($URI)) {
    $this->buffer=preg_replace("/[\n\r]/", " ", $this->buffer);
  } else {
    $this->buffer="";
  }
  //echo $this->buffer;
  //echo "<b>".$this->status."</b><br>";
  //echo $this->error."<br>";
  return $this->status;
}

function check($d) {
//---------------------------------------------------------------
// on repere les messages et on en deduit la reussite ou l'echec
//---------------------------------------------------------------
  if ($this->debug&&4)
    //echo $this->buffer;
  $fail=$d["failure"];
  for ($i=0; $i<sizeof($fail); $i++)
  if (preg_match("/".$fail[$i]."/sm", $this->buffer, $match)) {
    $this->rawdata=$match[0];
    if ($this->debug)
      echo "<b>failed</b>";
    $this->report="Votre site n'a pas put etre annoncé sur $this->where, essayez a nouveau plus tard <br>";
    $remove=strlen($match[1])+strlen($this->S_RAWDATA);
    return 0;
  };
  $success=$d["success"];
  for ($i=0; $i<sizeof($success); $i++)
  if (preg_match("/".$success[$i]."/sm", $this->buffer, $match)) {
    if ($this->debug)
      echo "<b>success</b><br>";
    $this->report="Votre site a bien été annoncé sur $this->where. <br>";
    return 1;
  }
  if ($this->debug)
    echo "<b>failed no load</b><br>";
  $this->report="Votre site n'a pas put etre annoncé sur $this->where, essayez a nouveau plus tard <br>";
  return 0;
}

function processSubmit($params) {
  $url=$params["url"];
  if (!$this->fetchURL($url)) {
    return False;
  };

  if ($this->debug&&2)
    echo htmlentities($buffer);

  $submitdata=$GLOBALS["SUBMITDATA"];

  $submitto=$params["submitto"];
  $stok=False;
  if (is_array($submitto))
  if (sizeof($submitto)>0) {
    $stok=True;
  };
  
  if (!$stok) {
    reset($submitdata);
    while (list($se, $d) =each($submitdata)){
      $submitto[$se]=1;
    }
  };
 
  $this->report="";
  reset($submitto);
  while (list($e, $f) =each($submitto)) {
    $d=$submitdata[$e];
    //echo "<b>$e </b>";
    $code=$this->submitengine($d, $params);
    if ($code==200) {
      if (!$this->check($d)) $return[]=array("submitengine"=>$e, "submitsuccess"=>"nok");
      else $return[]=array("submitengine"=>$e, "submitsuccess"=>"ok");
    } else {
      echo $this->buffer;
      $return[]=array("submitengine"=>$e, "submitsuccess"=>$code);
    };
  };
  $this->return=$return;
  return True;
}
}


?>
