<?
include('./db.php');
include('./dir/config.php');

	$account = $HTTP_GET_VARS["a"];
	$img = $HTTP_GET_VARS["img"];
	
	function spy($in,$out1,$out2) {
		$file = fopen('./spy',"a+");
		fputs($file,"input = '$in' \n");
		fputs($file,"engine = '$out1' \n");
		fputs($file,"query = '$out2' \n\n");
		fclose($file);
	}

	function GetReferrer($string) {
		if (strstr($string,'servustats')) {
			return 'A web site URL';
		}
		if ($string) {
			if ($pos = strpos($string,'?')) {
				return substr($string,0,$pos);
			} else {
				return $string;
			}
		} else {
			return 'A web site URL';
		}
	}

	function Cleaner($words) {
		$nosearch = array("act=","annuaire=","btng=","categoria=",
			"cfg=","cou=","dd=","domain=","dt=","dw=","exec=","geo=",
			"hc=","height=","hl=","hs=","kl=","lang=","loc=","lr=",
			"matchmode=","medor=","message=","meta=","mode=","order=",
			"page=","par=","pays=","pg=","pos=","prg=","qc=","refer=",
			"sa=","safe=","sc=","sort=","src=","start=","stype=","tag=",
			"temp=","theme=","url=","user=","width=","what=","\.x=","\.y=");
		reset($nosearch);
		if (strstr($words,'&')) {
			$words = substr($words,0,strpos($words,'&'));
		}
		$words = str_replace('+',' ',$words);
		do {
			$words = str_replace(current($nosearch),'',$words);
		} while (next($nosearch));
		if (!($words)) {
			return 'No keywords';
		} else {
			return $words;
		}
	}

	function GetQuery($string) {
		$querykey = array(
			"yahoo" => "p=",
			"altavista" => "q=",
			"alta-vista" => "q=",
			"msn.directhit" => "qry=",
			"msn" => "mt=",
			"voila" => "kw=",
			"hotbot.lycos" => "mt=",
			"lycos" => "query=",
			"nbci." => "q=",
			"google" => "q=",
			"goto.com" => "keywords=",
			"alltheweb" => "query=",
			"search.terra" => "claus=",
			"search.aol." => "query=",
			"netscape" => "search=",
			"northernlight" => "qr=",
			"dmoz.org" => "search=",
			"search.aol.co" => "query=",
			"webcrawler" => "s=",
			"websearch.cs.com" => "sterm=",
			"metacrawler" => "general=",
			"go2net.com" => "general=",
			"euroseek" => "query=",
			"excite" => "search=",
			"spray" => "string=",
			"your.com" => "keywords=",
			"kanoodle." => "query=",
			"francite" => "name=",
			"search.megaspider.com" => "",
			"ask." => "ask=",
			"askjeeves." => "ask=",
			"mamma" => "query=",
			"dogpile.com" => "q=",
			"vindex" => "in=",
			"nomade.fr/" => "s=",
			"fireball.de" => "q=",
			"suche.web.de","su=");
		reset($querykey);
		$string = trim($string);
		$string = str_replace('%20',' ',$string);
		$string = str_replace('%22',' ',$string);
		$string = str_replace('%2b',' ',$string);
		while (list($key,$value) = each($querykey)) {
			if (strstr($string,$key)) {
				$str = strstr($string,$value);
				if (strstr($str,'&')) {
					$res = substr($str,strlen($value),strpos($str,'&') - 2);
				} else {
					$res = substr($str,strlen($value));
				}
				return Cleaner($res);
			}
		}
		return "No keywords";
	}

	function GetEngine($string){
//	include ('./engines.php');
		$engines = array(
			"yahoo." => "Yahoo",
			"altavista." => "AltaVista",
			"alta-vista" => "AltaVista",
			"directhit" => "DirectHit",
			"msn." => "MSN",
			"voila." =>  "Voila",
			"hotbot." => "Hotbot",
			"lycos." => "Lycos",
			"nbci." => "NBCI",
			"search.terra." => "Terra",
			"google." => "Google",
			"websearch.cs.com" => "WebSearch",
			"alltheweb.com" => "AllTheWeb",
			"netscape." => "Netscape",
			"northernlight." => "NorthernLight",
			"dmoz.org" => "DMOZ",
			"search.aol.co" => "AOL",
			"webcrawler" => "WebCrawler",
			"metacrawler." => "MetaCrawler (Metamoteur)",
			"go2net.com" => "Go2Net (Metamoteur)",
			"goto.com" => "Go.com",
			"euroseek." => "Euroseek",
			"excite." => "Excite",
			"lokace." =>  "Lokace",
			"spray." => "Spray",
			"your.com" => "Your.com",
			"search.megaspider.com" => "MegaSpider",
			"netfind.aol.com" => "AOL",
			"recherche.aol.fr" => "AOL",
			"ask." => "Ask Jeeves",
			"askjeeves." => "Ask Jeeves",
			"mamma." => "Mamma",
			"kanoodle." => "Kanoodle",
			"search.dogpile.com" => "Dogpile",
			"vindex." => "Vindex.nl",	
			"nomade.fr/" => "Nomade",
			"ctrouve." => "C'est trouvé",
			"francite." => "Francité", 
			".lbb.org" => "LBB", 
			"rechercher.libertysurf.fr" => "Libertysurf",
			"fireball.de" => "Fireball", 
			"suche.web.de" => "Web.de", 
			"meta.ger" => "MetaGer");
		reset($engines);
		while (list($key,$value) = each($engines)) {
			if (strstr($string,$key)) {
				return $value;
			}
		}
		return 'Unknown engine';
	}


	function GetColor($string) {
		if ($string) {
			return $string." bit";
		} else {
			return 'Unknown';
		}
	}

	function GetCountry($string) {
		$substr = substr(strstr($string,'://'),3);
		$substr = substr($substr,0,strpos($substr,'/'));
		$country = substr(strrchr($substr,'.'),1);
		$filename = 'country';
		$file = fopen($filename,"r");
		while (!(feof($file))) {
			$line = fgets($file,50);
			if (strtoupper($country) == substr($line,0,strpos($line,' '))) {
				fclose($file);
				return substr($line,strchr($line,' '));
			}
		}
		fclose($file);
		return 'Unknown';
	}

	function GetLanguage($string) {
		$filename = 'language';
		$string = substr($string,0,2);
		$file = fopen($filename,"r");
		while (!(feof($file))) {
			$line = fgets($file,50);
			if ($string == substr($line,0,strpos($line,' '))) {
				fclose($file);
				return trim(strchr($line,' '));
			}
		}
		fclose($file);
		return "Unknown";
	}

function GetBrowserName($aV,$agt) {
    $is_minor =  (float)$aV;
    $is_major = floor($is_minor);

// Netscape
    $is_nav  = ((strstr($agt,'mozilla')) && (!(strstr($agt,'spoofer')))
                && (!(strstr($agt,'compatible'))) && (!(strstr($agt,'opera')))
                && (!(strstr($agt,'webtv'))) && (!(strstr($agt,'hotjava'))));
   if ($is_nav) {
	    if ($is_major == 2) { 
			return array("Netscape Navigator",2);
		}
	    if ($is_major == 3) { 
			return array("Netscape Navigator",3);
		}
	    if ($is_major == 4) { 
			return array("Netscape Navigator",4);
		}
	    if ($is_major == 5) { 
			return array("Netscape Navigator",6);
		}
	    if ($is_minor >= 5) { 
			return array("Netscape Navigator","6up");
		}
	    if ((strstr($agt,";nav")) || (strstr($agt,"; nav"))) {
			return array("Netscape Navigator",'');
		}
		return array("Netscape Navigator",'');
	}

    if (strstr($agt,'gecko')) {
		return array("Gecko",'');
	}

// Internet Explorer

    $is_ie = ((strstr($agt,"msie")) && (!(strstr($agt,"opera"))));
    if ($is_ie) {
		if ($is_minor < 4) {
			return array("Internet Explorer",3);
		}
		if (($is_major = 4) && (strstr($agt,"msie 6"))) {
			return array("Internet Explorer",'6');
		}
		if (($is_major = 4) && (!(strstr($agt,"msie 5")))) {
			return array("Internet Explorer",'4');
		}
		if (($is_major = 4) && (strstr($agt,"msie 5.0"))) {
			return array("Internet Explorer",'5');
		}
		if (($is_major = 4) && (strstr($agt,"msie 5.5"))) {
			return array("Internet Explorer",'5.5');
		}
	}

// AOL

	$is_aol = (strstr($agt,"aol"));
	if (strstr($agt,"aol 5")) {
		return array("AOL",5);
	}
	if (strstr($agt,"aol 6")) {
		return array("AOL",6);
	}

// Opera

	$is_opera = (strstr($agt,"opera"));
	if ($is_opera) {
		if ((strstr($agt,"opera 2")) || (strstr($agt,"opera/2"))) {
			return array("Opera",2);
		}
		if ((strstr($agt,"opera 3")) || (strstr($agt,"opera/3"))) {
			return array("Opera",3);
		}
		if ((strstr($agt,"opera 4")) || (strstr($agt,"opera/4"))) {
			return array("Opera",4);
		}
		if ((strstr($agt,"opera 5")) || (strstr($agt,"opera/5"))) {
			return array("Opera",5);
		}
		return array("Opera",'5up');
	}

// Others

	    if (strstr($agt,"webtv")) {
			return array("WebTV",'');
		}
	
	    if ((strstr($agt,"navio")) || (strstr($agt,"navio_aoltv"))) {
			return array("TVNavigator",'');
		}
	
	    $is_hotjava = (strstr($agt,"hotjava"));
	    if ($is_hotjava && ($is_major == 3)) {
			return array("HotJava",3);
		}
	    if ($is_hotjava && ($is_minor >= 3)) {
			return array("HotJava",'3up');
		}
		return array('Unknown','');
	}

	function GetBrowser($string1,$string2) {
		list($name,$version) = GetBrowserName($string1,$string2);
		return $name." ".$version;
	}

	function GetOS($aV,$agt) {

	// Windows

		$is_win = ((strstr($agt,'win')) || (strstr($agt,'16bit')));
		if ($is_win) {
			if ((strstr($agt,'win95')) || (strstr($agt,'windows 95'))) {
				return "Windows 95";
			}
			if ((strstr($agt,'windows 3.1')) || (strstr($agt,'win16')) 
				|| (strstr($agt,'windows 16-bit'))) {
				return "Windows 3.1";
			}
			if (strstr($agt,'16bit')) {
				return "Windows 16-bit";
			}
			if (strstr($agt,'win 9x 4.90')) {
				return "Windows ME";
			}
			if (strstr($agt,'windows nt 5.0')) {
				return "Windows 2000";
						}
			if (strstr($agt,'windows nt 5.1')) {
				return "Windows XP";
			}
			if ((strstr($agt,'win98')) || (strstr($agt,'windows 98'))) {
				return "Windows 98";
			}
			if ((strstr($agt,'winnt')) || (strstr($agt,'windows nt'))) {
				return "Windows NT";
			}
			return "Windows 32";
		}
		if ((strstr($agt,'os/2')) || (strstr($aV,'OS/2')) || (strstr($agt,'ibm-webexplorer'))) {
			return "Windows 98";
		}

	// Mac OS

		$is_mac = (strstr($agt,'mac'));
		if ($is_mac) {
			if ((strstr($agt,'68k')) || (strstr($agt,'68000'))) {
				return "Mac 68000";
			}
			if ((strstr($agt,'ppc')) || (strstr($agt,'powerpc'))) {
				return "Mac Power PC";
			}
			return "Mac OS";
		}

	// Sun

		$is_sun = (strstr($agt,'sunos'));
		if ($is_sun) {
			if (strstr($agt,'sunos 4')) {
				return "SunOS 4";
			}
			if (strstr($agt,'sunos 5')) {
				return "SunOS 5";
			}
			if (strstr($agt,'i86')) {
				return "Sun i86";
			}
			return "Sun";
		}

	// Irix

		$is_irix = (strstr($agt,'irix'));
		if ($is_irix) {
			if (strstr($agt,'irix 5')) {
				return "Irix 5";
			}
			if (strstr($agt,'Irix 6')) {
				return "Irix 6";
			}
			return "Irix";
		}

	// HPUX

		$is_hpux = (strstr($agt,'hpux'));
		if ($is_hpux) {
			if (strstr($agt,'09.')) {
				return "HP-ux 9";
			}
			if (strstr($agt,'10.')) {
				return "HP-ux 10";
			}
			return "HP-ux";
		}

	// Aix

		$is_aix = (strstr($agt,'aix'));
		if ($is_irix) {
			if (strstr($agt,'aix 1')) {
				return "Aix 1";
			}
			if (strstr($agt,'aix 2')) {
				return "Aix 2";
			}
			if (strstr($agt,'aix 3')) {
				return "Aix 3";
			}
			if (strstr($agt,'aix 4')) {
				return "Aix 4";
			}
			return "Aix";
		}

	//Others

		if (strstr($agt,'inux')) {
			return "Linux";
		}
		if ((strstr($agt,'sco')) || (strstr($agt,'unix_sv'))) {
			return "SCO";
		}
		if (strstr($agt,'unix_sysytem_v')) {
			return "Unix Ware";
		}
		if (strstr($agt,'ncr')) {
			return "mpras";
		}
		if (strstr($agt,'reliantunix')) {
			return "Reliant Unix";
		}
		if ((strstr($agt,'dec')) || (strstr($agt,'osfl')) || (strstr($agt,'dec_alpha')) ||
			 (strstr($agt,'alphaserver')) || (strstr($agt,'ultrix')) || (strstr($agt,'alphastation'))) {
			return "Dec";
		}
		if (strstr($agt,'sinix')) {
			return "Sinix";
		}
		if (strstr($agt,'freebsd')) {
			return "Free BSD";
		}
		if (strstr($agt,'dsb')) {
			return "BSD";
		}
		if ((strstr($agt,'vax')) || (strstr($agt,'openvms'))) {
			return "VMS";
		}
		return 'Unknown';

	}

	function GetJavaScript($aV,$agt) {
	    $is_major = (integer)$aV;
    	$is_minor = (float)$aV;
		list($browser,$version) = GetBrowserName($aV,$agt);
		if ($browser == "Netscape Navigator") {
			$is_nav = 1;
		}
		if ($browser == "Internet Explorer") {
			$is_ie = 1;
		}
		if ($browser == "Opera") {
			$is_opera = 1;
		}
		if ($browser == "HotJava") {
			$is_hotjava = 1;
		}
		if ($browser == "Gecko") {
			$is_hotjava = 1;
		}
		if ((($is_nav) && ($version == 2)) || (($is_ie) && ($version == 3))) {
			return "JavaScript 1.0";
		} 
		if (($is_nav) && ($version == 3)) {
			return "JavaScript 1.1";
		} 
		if (($is_opera) && ($version == '5up')) {
			return "JavaScript 1.3";
		}
		if ($is_opera) {
			return "JavaScript 1.1";
		}
		if (((($is_nav) && ($version == 4)) && ($is_minor <= 4.05)) || (($is_ie) && ($version == 4))) {
			return "JavaScript 1.2";
		}
		if (((($is_nav) && ($version == 4)) && ($is_minor > 4.05)) || (($is_ie) && (($version == 5) || ($version == '5.5')))) {
			return "JavaScript 1.3";
		}
		if (($is_hotjava) && ($version == '3up')) {
			return "JavaScript 1.4";
		}
		if ((($is_nav) && (($version == 6) || ($version == '6up'))) || ($is_gecko)) {
			return "JavaScript 1.6";
		}
		return 'Unknown';
	}

	function GetJava($string) {
		if ($string == "true") {
			return "Java enabled";
		} else {
			return "Java disabled";
		}
	}

	$referrer = GetReferrer($HTTP_GET_VARS["r"]);
	$engine = GetEngine(strtolower($HTTP_GET_VARS["r"]));
	$colordepth = GetColor($HTTP_GET_VARS["cd"]);
	$resolution = $HTTP_GET_VARS["p"];
	$operationsystem = GetOS($HTTP_GET_VARS["aV"],$HTTP_GET_VARS["agt"]);
	$country = GetCountry($HTTP_GET_VARS["r"]);
	$language = GetLanguage(getenv(HTTP_ACCEPT_LANGUAGE));
 	$browser = GetBrowser($HTTP_GET_VARS["aV"],$HTTP_GET_VARS["agt"]);
	$query = GetQuery(strtolower($HTTP_GET_VARS["r"]));
	$javascript = GetJavaScript($HTTP_GET_VARS["aV"],$HTTP_GET_VARS["agt"]);
	$java = GetJava($HTTP_GET_VARS["je"]);
	if (!($resolution)) {
		$resolution = "Unknown";
	}

	if (!($country)) {
		$country = 'Unknown';
	}

	if (!($language)) {
		$language = 'Unknown';
	}

	$im = ImageCreateFromJPEG($img);
	ImageJPEG($im);

	$db1 = new DB;
	$db1 -> open($dbhost,$dbuser,$dbpasswd,$db);
	$visited = $db1 -> onHit($account,getenv(REMOTE_ADDR));
	if (!($visited)) {
		//spy(strtolower($HTTP_GET_VARS["r"]),$engine,$query);
		$db1 -> addHitToTable($db1 -> currentID,"referrer",$referrer);
		if ($engine != "Unknown engine") {
			$db1 -> addHitToTable($db1 -> currentID,"engine",$engine);
		}
		$db1 -> addHitToTable($db1 -> currentID,"color",$colordepth);
		$db1 -> addHitToTable($db1 -> currentID,"resolution",$resolution);
		$db1 -> addHitToTable($db1 -> currentID,"os",$operationsystem);
		$db1 -> addHitToTable($db1 -> currentID,"country",$country);
		$db1 -> addHitToTable($db1 -> currentID,"language",$language);
		$db1 -> addHitToTable($db1 -> currentID,"browser",$browser);
		if ($query != "No keywords") {
			$db1 -> addHitToTable($db1 -> currentID,"query",$query);
		}
		$db1 -> addHitToTable($db1 -> currentID,"java",$java);
		$db1 -> addHitToTable($db1 -> currentID,"javascript",$javascript);
	}

?>