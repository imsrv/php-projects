<?

include("cls.php");

$news = new newsletter; 


// Get the newsletter config

$news->get_config($host,$db,$user,$pass,$tableconfig); 


$mysql_link =  @MYSQL_CONNECT($news->host,$news->user,$news->passwd);
@mysql_select_db($news->db ,$mysql_link);



$sql  = "SELECT * FROM $news->tablenews";
$resultat = mysql_db_query($news->db, $sql);
    $nrows=mysql_num_rows($resultat);


     

header("Content-disposition: filename=listing.txt");
    header("Content-type: application/octetstream");
    header("Pragma: no-cache");
    header("Expires: 0");

  $client = getenv("HTTP_USER_AGENT");
    if(ereg('[^(]*\((.*)\)[^)]*',$client,$regs)) 
    {
        $os = $regs[1];
        // this looks better under WinX
        if (eregi("Win",$os)) 
            $crlf="\r\n";
	else $crlf="\n";
    }


     while ($enr = mysql_fetch_array($resultat)) {
       print $enr[0] . $crlf;
     }
     
exit();








   ?>
