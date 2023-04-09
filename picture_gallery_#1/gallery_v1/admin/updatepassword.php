<?
if (!ini_get('register_globals')) 
   {
       $types_to_register = array('GET','POST','COOKIE','SESSION','SERVER');
       foreach ($types_to_register as $type)
       {
           if (@count(${'HTTP_' . $type . '_VARS'}) > 0)
           {
               extract(${'HTTP_' . $type . '_VARS'}, EXTR_OVERWRITE);
           }
       }
   }

session_start();
if(!session_is_registered("auth") && !isset($oldp) && !isset($newp) && !isset($rnewp))
	header ("Location: index.php");
if ($rnewp != $newp){
	$err=3;
} else {

  $lines = file('files/adminaccess.php');

  array_splice($lines,0,1);
  array_splice($lines,count($lines)-1);
  
  $parser = array();
  $parser = split(";",$lines[0]);
  $id_ffile = $parser[0];
  $username_ffile = $parser[1];
  $password_ffile = $parser[2];

	if ($oldp!=$password_ffile) {
		$err=2;
	} else {
		$string = '<?
1;admin;'.$rnewp.';admin
?>';
		$file = "files/adminaccess.php";
		$fp = fopen("$file","w");
		fputs($fp, $string); 
		fclose($fp);
		$err=1;
	}
}
header("Location: changepass.php?err=$err");
?>
