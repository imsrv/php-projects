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
if ($username)
{
  $lines = file('files/adminaccess.php');

  array_splice($lines,0,1);
  array_splice($lines,count($lines)-1);
  
  $parser = array();
  $parser = split(";",$lines[0]);
  $id_ffile = $parser[0];
  $username_ffile = $parser[1];
  $password_ffile = $parser[2];
  $type_ffile = ereg_replace("(\r\n|\n|\r)", "", $parser[3]);
  if ($username_ffile == $username && $password_ffile == $password && $type_ffile == "admin")
	{
		session_register("password");
		session_register("auth");
		$auth["id"]=$id_ffile;
		$auth["username"]=$username_ffile;
		$auth["type"]=$type_ffile;
		header ("Location: gallery/index.php?".SID);
	}else
	{
		include("index.php");
	}
}
else
{
  include("index.php");
}
?>
