<?
if(!isset($PHP_AUTH_USER)) {
    Header("WWW-Authenticate: Basic realm=\"Banner-Administration\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "A username and password with administrative privileges are required for access to these pages.\n";
    exit;
  } else {


 if($PHP_AUTH_USER!='tml' || $PHP_AUTH_PW!='rap7855'){

            Header("WWW-Authenticate: Basic realm=\"Banner-Administration\"");
            Header("HTTP/1.0 401 Unauthorized");
                echo "Invalid username or password.\n";
                exit;
        }

}

 include 'common.php';

$banner= "<A HREf=\"$url\" TARGET=\"_TOP\"><img src=\"$src\" width=\"$width\" height=\"$height\" alt=\"$alt\" border=0></A>";
 if(isset($submission)) {
        if (!isset($bannerID)) {
                $query = "SELECT title, bannerID FROM banners WHERE title='".$title."'";
                   $resexist = mysql_query($query,$connection)
                        or die ("Couldn't execute query!");
                if ($existsarray = mysql_fetch_array($resexist)) {
                        $duplicate = 1;
                }
        }



        $update = 0;
   if ($title != "" & trim($banner) != ""  & ($position!="") & trim($client)!="" & $duplicate == 0) {
                  $submission = "complete";
                  if (isset($bannerID) && $bannerID!="") {
                          $query = "UPDATE banners SET  ";
                          $update = 1;
                  } else {

                          $query = "INSERT INTO banners SET  ";
                  }

                $query = $query."banner='".$banner."',";
                $query = $query."title='".$title."',";
               // $query = $query."type='".$type."',";
                  $query = $query."date='".date("Y-m-d")."',";
                   $query = $query."src='".$src."',";
                   $query = $query."width='".$width."',";
                   $query = $query."height='".$height."',";
                  $query = $query."url='".$url."',";
                  $query = $query."client='".$client."',";
                  $query = $query."local_banner='".$position."',";
                  $query = $query."alt='".$alt."'";
                  if ($update == 1)
                          $query = $query." WHERE bannerID='$bannerID'";
                             $res = mysql_query($query,$connection);
                             echo mysql_error();
                             //                               or die ("Couldn't execute query!");
                          if (mysql_error()==""){
                                  $submission="Complite";

                          }
                  } else {
                       $submission = "Incomplete";
          }
  } else if (isset($bannerID) & !isset($submission) & $duplicate == 0) {
          $query = "SELECT * FROM banners where bannerID='$bannerID'";
        $res = mysql_query($query,$connection)
                        or die ("Couldn't execute query!");
                        $ret=1;
          if ($row = mysql_fetch_array($res)) {

          } else {
                  $submission = " Submission Error";
          }
  }


if($submission=="Complite"){
   header("Location:admin.php?position=$position&info=Submission $submission");
   exit();

}
?>
 <HTML>
<head>
 <style type="text/css">
<!--
body {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt}
table { font-family: Arial, Helvetica, sans-serif; font-size: 10pt }
td { font-family: Arial, Helvetica, sans-serif; font-size: 10pt }
.heading { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14pt; font-weight: bold; color: white; margin-bottom: 0px;}
-->
</style>
</head>

<body>
  <table border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#000099">
  <tr>
    <td>
      <table border="0" align="center" bgcolor="#FFFFFF" cellspacing="0" cellpadding="5">
        <tr bgcolor="#000099">
          <td><span class="heading">Banner Adminstration  /
            <?
            if($ret==1)
               echo " Editing  / ";
             else
               echo "  Adding  / ";

            if($position==1 || $row["local_banner"] == 1)
             echo " Front page Banners";
            if($position==2  || $row["local_banner"] == 2)
             echo " Inside Page Banners";
            ?>



          </span></td>
        </tr>
        <tr>
          <td>
   </td>
 </tr>
 <tr>
  <td bgcolor="#CCCCCC">
 <a href=index.php>Home</a> <img src=arrow.gif  width=8 height=7> <a href=admin.php?position=<?echo$position?>>Banner Adminstration</a> <img src=arrow.gif width=8 height=7> Add new banner<br></td>
 </tr>
 <tr>
  <td>


<table width="100%" cellspacing="0" cellpadding="1"  align=center> <tr><td>
<form action="<?echo basename($PHP_SELF);?>" method="POST" enctype="multipart/form-data">
   <INPUT TYPE="hidden" NAME="submission" VALUE="TRUE">
<INPUT TYPE="hidden" NAME="bannerID" VALUE="<? echo$bannerID ?>">
                        <table width="100%" cellspacing="0" cellpadding="1" bgcolor="#000099">



              <tr align="center">
                <td>
                  <font color="#FFFFFF"><b>Banner</b></font>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                    <tr>
                      <td>
                        <table>
                          <tr>
                              <td height="32">New banner URL (incl. http://):</td>
                              <td height="32">
                                <input size="80" type="text" name="src" value="<?echo $row["src"];?>">
                            </td>
                          </tr>
                          <tr>
                            <td>Linked to URL (incl. http://):</td>
                            <td>
                                <input size="80" type="text" name="url" value="<?echo $row["url"];?>">
                            </td>
                          </tr>
                          <tr>
                            <td>Width:</td>
                            <td>
                                <input size="20" type="text" name="width" value="<?echo $row["width"];?>">
                            </td>
                          </tr>
                          <tr>
                            <td>Height:</td>
                            <td>
                                <input size="20" type="text" name="height" value="<?echo $row["height"];?>">
                            </td>
                          </tr>
                          <tr>
                            <td>Alt-Text:</td>
                            <td>
                                <input size="80" type="text" name="alt" value="<? echo $row["alt"];?>">
                            </td>
                          </tr>

                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

              <table cellpadding=3 cellspacing=3 width="100%">
                <tr>
                  <td width=30%>Title:</td>
                  <td width=50%>
                    <input size="60" type="text" name="title" value="<?echo $row["title"];?>">
                  </td>
                </tr>
                <tr>
                  <td>Client:</td>
                   <td >
                     <input size="40" type="text" name="client" value="<?echo $row["client"];?>">
                    </td>
                </tr>
                          <tr>
                            <td>This banner will be desplayed on:</td>
                            <td><font color= red size=3><b>

                            <?
                                if ($row["local_banner"] == 1 || $position==1){
                                   echo "Front page";
                                     echo "<INPUT TYPE=hidden NAME=position VALUE=1> ";
                                   }
                                if ($row["local_banner"] == 2 || $position==2){
                                   echo "Inside pages";
                                   echo "<INPUT TYPE=hidden NAME=position VALUE=2> ";
                                }
                                   ?>
                                   </b></font>
                            </td>
                          </tr>

                <tr>
                  <td>Bubmit banner</td>
                  <td>
                    <input type="submit" name="submit" value="Submit">
                  </td>
                </tr>
              </table></td></tr></table>
            </form>
            </body>