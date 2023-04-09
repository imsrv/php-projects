<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html 
          PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Admin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="templates/scripts/style.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="templates/images/favicon.ico" />
    <link rel="shortcut icon" href="templates/images/favicon.ico" />  
    <script src="templates/scripts/script.js" type="text/javascript"></script>    
  </head>
 <body style="padding: 5em;">

  <div style="width: 85%; margin: 0 auto; text-align: center;">
  <ul id="nav">
	<li><a href="index.php?page=orders"{scal:section_1}>Order queue</a></li>
	<li><a href="index.php?page=ads"{scal:section_2}>Approved ads</a></li>
	<li><a href="index.php?page=blog"{scal:section_3}>Blog</a></li>
	<li><a href="index.php?page=faq"{scal:section_4}>FAQ</a></li>
	<li><a href="index.php?page=pages"{scal:section_5}>Static pages</a></li>
	<li><a href="index.php?page=adsense"{scal:section_6}>Adsense</a></li>
	<li><a href="index.php?page=contacts"{scal:section_7}>Contact messages</a></li>
	<li><a href="index.php?page=settings"{scal:section_8}>Settings</a></li>
   </ul>
   </div>
   <div class="container">
  
     [include:templates/pages/{scal:page}]
   
   </div>
 
 </body>
 
</html>