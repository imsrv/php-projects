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

require "snoopy.class.php";
require "castor.php";

   $d["url"]= "http://www.yoursite.com/";
   $d["email"] = "contact@yoursite.com";
   $d["submitto"] = array("webcrawler"=>1, "excite"=>1, "google"=>1);
   $castor= new Castor;
   $castor->debug=0;
   $castor->processSubmit($d);
   while (list($e, $f) =each($castor->return)) {
     if ($f["submitsuccess"]=="ok") {
       echo "your site has been submitted sucessfully on <b>".$f["submitengine"]."</b><br>";
     } 
     else {
       echo "your site has not been submitted on <b>".$f["submitengine"]."</b><br>";
     };
   };

?>