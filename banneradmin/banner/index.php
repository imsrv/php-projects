<?
if(!isset($PHP_AUTH_USER)) {
    Header("WWW-Authenticate: Basic realm=\"Banner-Administration\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "A username and password with administrative privileges are required for access to these pages.\n";
    exit;
  } else {


 if($PHP_AUTH_USER!='xxxxxx' || $PHP_AUTH_PW!='xxxxxx'){

            Header("WWW-Authenticate: Basic realm=\"Banner-Administration\"");
            Header("HTTP/1.0 401 Unauthorized");
                echo "Invalid username or password.\n";
                exit;
        }

}

 include 'common.php';    
  ?>

<html>
<HEAD>
<style>
<!--
A {COLOR: blue; TEXT-DECORATION: none}
a:hover {COLOR: red; TEXT-DECORATION: underline}

-->
</style>

 <style type="text/css">
<!--
body {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt}
table { font-family: Arial, Helvetica, sans-serif; font-size: 10pt }
td { font-family: Arial, Helvetica, sans-serif; font-size: 10pt }
.heading { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14pt; font-weight: bold; color: white; margin-bottom: 0px;}
-->
</style>



</HEAD>
<body bgcolor=white>
 <table border="0" cellspacing="0" cellpadding="1" align="center"  bgcolor="#000099">
  <tr>
    <td>
      <table border="0" align="center" bgcolor="#FFFFFF" cellspacing="0" cellpadding="5">
        <tr bgcolor="#000099">
          <td align=center><span class="heading">Banner Adminstration Main Page</span>

          </td>
        </tr>
        <tr><td align=center>
             To admin front page banner click here!  <br>

<form action="admin.php" method="POST" enctype="multipart/form-data">
<INPUT TYPE="hidden" NAME="position" VALUE="1">
<INPUT TYPE="submit"  VALUE="Admin Front page Banners">
</FORM>
<hr>
To admin insede page banners click here!                <br>
 <form action="admin.php" method="POST" enctype="multipart/form-data">
<INPUT TYPE="hidden" NAME="position" VALUE="2">
<INPUT TYPE="submit" VALUE="Admin Inside page Banners">
</FORM>
</td></tr>
<tr bgcolor="#000099"><td>
<span class="heading">Statistic</span>
</td></tr>


<tr><td align=center>

To admin front page banner click here!  <br>

<form action="stat.php" method="POST" enctype="multipart/form-data">
<INPUT TYPE="hidden" NAME="position" VALUE="1">
<INPUT TYPE="submit" name="bannerStat" VALUE="Stat / Front page Banners">
</FORM>

<hr>
To admin insede page banners click here!                <br>
 <form action="stat.php" method="POST" enctype="multipart/form-data">
<INPUT TYPE="hidden" NAME="position" VALUE="2">
<INPUT TYPE="submit" name="bannerStat" VALUE="Stat / Inside page Banners">
</FORM>
<hr>
<form action="full_stat.php" method="POST" enctype="multipart/form-data">
<SELECT NAME="bannerID">

<?
$query="select bannerID, title from banners";
         $res = mysql_query($query,$connection)
                    or die ("Couldn't select records!/3");
while ($clients = mysql_fetch_array($res)) {

        echo "<OPTION VALUE=\"".$clients["bannerID"]."\"";
        if ($bannerID == $clients["bannerID"])
                echo " SELECTED";
        echo ">".$clients["title"]."\n";
}
?>
</SELECT>
<INPUT TYPE=submit value=Go!>
</form>
 <tr bgcolor="#000099">
          <td align=center><span class="heading">General Info</span>
</td></tr>
<tr> <td>
To dispay first page banners, type this:<br>
<INPUT type=text size=65 value="include '<? echo "$HTTP_HOST/$DOCROOT/"?>FrontPageBanner.php';">
<br>
To dispay inside page banners, type this:<br>
<INPUT type="Text" size=65 value="include '<? echo "$HTTP_HOST/$DOCROOT/"?>InsidePageBanner.php'; ">


</td></tr>

</td></tr></table> </td></tr></table>

</BODY>
</HTML>