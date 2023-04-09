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
if(!session_is_registered("auth") && !isset($oldp)) header ("Location: index.php");
$file = "files/adminmail.php";
$fp = fopen("$file","w");
$err = $fp>0;
$oldp = '<?
'.$oldp.'
?>';
fputs($fp, $oldp); 
fclose($fp);
header("Location: changeemail.php?err=$err");
?>
