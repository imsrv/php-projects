<?php



class config {







        ######################################################################



        # This script is developed by Kaoz.net                               #



        # Do not redistrubute or modify without permission                   #



        ######################################################################



        #                                                                    #



        # Version: 2.2                                                       #



        # Last modified: 22-01-2001                                          #



        #                                                                    #



        ######################################################################



        ##     EDIT THE VARIABLES BELOW - FOR HELP VIEW THE COMMENT ;)      ##



        ######################################################################







        var $site_url = "http://www.x-ddl.com/";        // Your sites url



        var $site_name = "www.x-ddl.com - more then 100.000 downloads updates daily";                        // Your sites name



        var $site_mail = "info@x-ddl.com";     // Your e-mail







        var $r_user = "punkais";                                                // Admin Username (Case Sensitive)



        var $r_pass = "money78";                                           // Admin Password (Case Sensitive)







        var $limit = 80;                                                        // Number of downloads per page



        var $max_dl = 0;                                                        // Maximum numbers of downloads in database (0 for unlimited)



        var $date_format = "d-m-Y";   // How the dates shall be displayed (Y = year, m = month, d = date) ex. (24-12-2002)







        var $admin_email = "info@x-ddl.com";                    // Your e-mail



        var $mysql_host = "localhost";                                // MySQL host - usually localhost



        var $mysql_user = "xddl_kais";                                        // MySQL username



        var $mysql_pass = "kais";                                        // MySQL password



        var $mysql_db = "xddl_xbase";                                                // Your MySQL database







        var $type = array(                                                        // The different types of downloads - you see how it goes



                "Game",                                                                        // You can have as many (or few) categories as you want



                "App",



                "Movie",



                "XXX",



                "Other",



        );







        ######################################################################



        ##   DONT EDIT BELOW THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING!   ##



        ######################################################################







        var $mysql_tb_dl = "downloads";                                // The downloads table



        var $mysql_tb_que = "que";                                        // The table for downloads submitted but not reviewed



        var $mysql_tb_le = "linker";                                // The links information



        var $mysql_tb_ip = "iplogg";                                // Ip-logging, for anti-cheating (and for you to check if you suspect cheating)



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



                        or die("This is the new DDLPost server! It is still being installed! For DDLPost on the old server, Go to: http://216.138.225.70/ddl.php <a href=\"mailto:".$this->admin_email."\">".$this->admin_email."</a>");



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