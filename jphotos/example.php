<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
 <title> jphotos example </title>
 <meta http-equiv="content-type" content="text/html; charset=windows-1250"> 
 <link rel="stylesheet" media="screen" href="./style.css" type="text/css">
</head>
<body>

<?
   require("./foto.php");
   switch($_REQUEST["st"]) {
     case "foto_detail":
       echo foto_detail($_REQUEST["foto_dir"],$_REQUEST["foto"]);
     break;
     case "foto":
     default:
       echo foto($_REQUEST["foto_dir"]);
     break;
   }

?>

<a href="http://validator.w3.org/check?uri=referer"> <img border="0" src="http://www.w3.org/Icons/valid-html401" alt="Valid HTML 4.01!" height="31" width="88"></a>
<a href="http://jigsaw.w3.org/css-validator/" target="w3c"> <img src="http://www.w3.org/Icons/valid-css" alt="Valid CSS!" border="0" width="88" height="31"> </a>

</body>
</html>
