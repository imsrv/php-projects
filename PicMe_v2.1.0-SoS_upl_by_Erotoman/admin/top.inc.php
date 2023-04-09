<?PHP
/*
#
#	$Id: TOP.INC.PHP
#	Version 2.0.0
#
*/
header("Cache-control: private"); // IE 6 Fix. 
include "../settings.php";
?>
 <html>
<TITLE><? echo $sitename ?> Admin</TITLE>
<body bgcolor="#EAEAEA">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> <a href="<? echo "index.php?action=showunapproved"; ?>"><img src="images/newpics.jpg" border="0" alt="Unapproved Pictures"></a> 
      <a href="<? echo "index.php?action=showall";?>"><img src="images/allpics.jpg" border="0" alt="All Pictures"></a> 
      <a href="<? echo "index.php?action=showusers";?>"><img src="images/users.jpg" border="0" alt="Edit Users"></a> 
      <a href="<? echo "index.php";?>"><img src="images/catagory.jpg" border="0" alt="Edit Catagories"></a> 
      <a href="<? echo "index.php?action=news";?>"><img src="images/news.jpg" border="0" alt="Edit News"></a> 
     <a href="<? echo "index.php?action=showfaq";?>"><img src="images/faq.jpg" border="0" alt="Edit FAQ"></a> 
     <a href="<? echo "banner.php";?>"><img src="images/banner.jpg" border="0" alt="Banners"></a>
</td>
  </tr>
</table>
<br>
