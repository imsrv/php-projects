<?

//////////////////////////////////////////////////////
// PHP Error Reporting 		    		    //
//////////////////////////////////////////////////////

// error_reporting (32);


//////////////////////////////////////////////////////
// MySQL Variables    		    		    //
//////////////////////////////////////////////////////

// MySQL Username 
	$user = "amorajato";
	// $user = "unrealtop";
// MySQL Password
	$pass = "sua-senha aqui";
// MySQL database name
	$dbname = "amorajato";
// MySQL HOST OR IP Address
	$dbhost = "sql.locasite";


//////////////////////////////////////////////////////
// MySQL DataBase Connection		    	    //
//////////////////////////////////////////////////////

   $db=mysql_connect("$dbhost","$user","$pass") or die ("Can't connect to mySQL server"); //


//////////////////////////////////////////////////////
// Tables Variables			    	    //
//////////////////////////////////////////////////////

// Number of sites per page
	$t_step = 10;
// Number of sites on Last xx Submitted Sites
	$last_ssites = 10;

//////////////////////////////////////////////////////
// Path's AND Banners Variables	    	    	    //
//////////////////////////////////////////////////////

// Width for all banners
	$max_banner_width = 120;

// Height for all banners
	$max_banner_height = 60;

// URL to your vote image
	$vote_image_url = "http://www.amorajato.com.br/toplist/images/88logo.gif";

// Top List http:// URL
	$url_to_folder = "http://www.amorajato.com.br/toplist";

// Path to reset file
	$reset_log_file = "admin/reset.txt";

// Path to count file
	$count_log_file = "admin/count.txt";


//////////////////////////////////////////////////////
// Anti-Cheating Variables	    	    	    //
//////////////////////////////////////////////////////

// Incoming hits to be shown ?
	$shown = 1;

// Use cookies for Anti-Cheat (for more protection) (1-Enable;0-Disable)
	$use_cookies = 1;  
// Use Anti-Cheating Gateway (1-Enable;0-Disable)
	$gateway = 0;

	$anti_cheat_message = "<font color=red face=verdana size=2>You have already voted within the last 24 hours! Your vote hasn't been logged.</font><br>";
	$vote_log_message = "<font color=red face=verdana size=2>Thanks! Your vote has been counted!</font><br>";
	$cookie_message = "<font color=red face=verdana size=2>Please enable cookies.</font><br>";


//////////////////////////////////////////////////////
// List Variables	    	    	    	    //
//////////////////////////////////////////////////////

// List will be reseted after XX days
	$days_to_reset = 1;

// Site will be with "New Site" Icon in XX days. (set 0 to disable)
	$new_site_days = 10;

// HTML Code for NewSite Icon
	$new_site_image = "<font size=1 color=red><SUP>NOVO</SUP></FONT>";
        // You can also insert image tag such as 
	// <img src=\"images/new.gif\" width=\"xx\" height=\"xx\" border=\"0\">

// Text for Submit Button on in.php 
	$button_text = "Vote neste site";			   

// Top List Name
	$top_name = "Amorajato.com.br - Top Sites -Os Melhores estão aqui!";

// Admin Email
	$admin_email = "toplist@amorajato.com.br";

// Get an email when there is a new member "yes" or "no"
	$new_member = "yes";

// Site will be added without Webmaster Validation , "yes" or "no"
	$auto_validation = "no";


//////////////////////////////////////////////////////
// Review Variables	    	    	    	    //
//////////////////////////////////////////////////////

// Use a site review system (1-Enable;0-Disable)
	$use_review = 1;    

// XX Reviews per page.
	$review_step = 10;  

//////////////////////////////////////////////////////
// Recommend-it Variables	    	    	    //
//////////////////////////////////////////////////////

// Use a Recommend-it Service (1-Enable;0-Disable)
	$use_taf = 1;

// Email subject for Recommend-it Service
	$r_subject = "Recomenda de sites para você";

//////////////////////////////////////////////////////
// Cosmetic Variables	    	    	    	    //
//////////////////////////////////////////////////////

	$font_face = "Verdana";
	$font_size = "2";
	$font_color = "black";

	$RANK = "Posição";
	$SITE = "SITES";
	$VOTES = "IN";
	$HITS = "OUT";
	$RATING = "Avaliação";


	$ver = " Versão 2002";

function get_site_category($sid,$cid) {
	Global $dbname,$db;
	$query = mysql_db_query ($dbname,"select catname from top_cats where cid=$cid",$db) or die (mysql_error());
	$rows = mysql_fetch_array($query);
	$cc = $rows[catname];
	return $cc;
}

function get_site_reviews($sid) {
	Global $dbname,$db;
	$query = mysql_db_query ($dbname,"select count(rid) as reviews from top_review where sid=$sid",$db) or die (mysql_error());
	$rows = mysql_fetch_array($query);
	$cc = 0;
	$cc = $rows[reviews];
	return $cc;
}

function reset_update_time() {

	Global $days_to_reset,$reset_log_file;

	$days_code = 86400 * $days_to_reset;
	$reset_date = time()+$days_code;

	$fp = fopen($reset_log_file, "w");
	flock($fp,2);
	$fw = fwrite($fp, $reset_date);
	fclose($fp);
}

function reset_list() {
	
	Global $dbname,$db;
	mysql_db_query ($dbname,"update top_user set hitin=0, hitout=0",$db) or die (mysql_error());
	mysql_db_query ($dbname,"delete from top_hits",$db) or die (mysql_error());

}

function check_email_addr($email) {
	if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email)) {
		return 1;
	}else{
		return 0;
	}
}
?>
