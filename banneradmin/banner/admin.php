<?
if(!isset($PHP_AUTH_USER)) {
    Header("WWW-Authenticate: Basic realm=\"Banner-Administration\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "A username and password with administrative privileges are required for access to these pages.\n";
    exit;
  } else {


 if($PHP_AUTH_USER!='xxx' || $PHP_AUTH_PW!='xxx'){

            Header("WWW-Authenticate: Basic realm=\"Banner-Administration\"");
            Header("HTTP/1.0 401 Unauthorized");
                echo "Invalid username or password.\n";
                exit;
        }

}


if($position!=1  && $position!=2){

    // echo "position $position";
   header("Location:index.php?info=Please choose banner location");
   exit();
}
include 'common.php';
$table="banners";
 $j=0;

 //++++++++   searching function ++++++++++++++++++++++++++++++++++++++





//++++++++++ deleting function, second level  +++++++++++++++++++++++++++++++++++

if($reDel=='Delete'){
                for($i=0; $i<count($delarr); $i++){
                         $query = "delete from $table where bannerID ='$delarr[$i]' AND local_banner='$position'";
                          $res = mysql_query($query,$connection)
                                 or die ("Couldn't insert records!");
                }
                       $info="Deleting completed!";
 }



//+++++++++++++++++++ del positions +++++++++++++++++++++++




    if(isset($submit)){
    ?>
     <FORM METHOD="POST" ACTION="admin.php">

    <?
    echo "<input type=hidden name=position value=$position >";
          $query = "select * from $table WHERE local_banner='$position'";
            $res = mysql_query($query,$connection)
               or die ("Couldn't insert records!");
                    echo "<center><h1><b>You want to delete this banner:</b><br></h1>";
                  while($news=mysql_fetch_array($res)){
                  $bannerID = $news["bannerID"];
                          if(($delete[$bannerID])  && ($delete[$bannerID] =="ON")){
                          $delition=1;
                          $delarr[$i]=$bannerID;
                          echo "<input type=hidden name=delarr[] value=$delarr[$i] >";
                  $query1 = "select * from $table where bannerID='$bannerID' ";
                   $res1 = mysql_query($query1,$connection)
                    or die ("Couldn't insert records!");
                  while($news1=mysql_fetch_array($res1)){
                  echo "".$news1["title"]."<br>";

                  }

                                  ++$i;

                          }

                    }

  if(isset($delition)){
  echo " <input type =submit value=Delete name=reDel >";
  echo "    <input type =submit value=Cancel name=reDel>";
 } else {
 echo "<font color=red face=areal>No Banner selected!</font>";
   echo "    <input type =submit value=Back >";
 }
 ?>
  </form>
  </center>
  <?
    } else {

    $query = "select * from $table  WHERE local_banner='$position' order by title";
     $res = mysql_query($query,$connection)
        or die ("Couldn't insert records!");
           if(mysql_num_rows($res)=="0"){
               $info="No Banners!";
                 $empty=1;
           }

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
 <table border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#000099">
  <tr>
    <td>
      <table border="0" align="center" bgcolor="#FFFFFF" cellspacing="0" cellpadding="5">
        <tr bgcolor="#000099">
          <td><span class="heading">Banner Adminstration /
            <?
            if($position==1)
             echo " Front page Banners";
            if($position==2)
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
 <a href=index.php> Home </a> <img src=arrow.gif width=8 height=7> Banner Adminstration <img src=arrow.gif  width=8 height=7> <a href=form.php?position=<?echo$position;?>> Add new banner </a> <br>  </td>
 </tr>
 <tr>
  <td>

<?
if (isset($info)){
?>
<table wbannerIDth=80%><tr> <td bgcolor=white align=center>
<font size=4 color=red face=arial><?echo $info?></font>
</td></tr></table>
<? } ?>
<FORM METHOD=POST ACTION="admin.php" bannerID=form1 name=form1>

<table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr><td bgcolor=#99999>
<table width="100%" cellpadding=3 cellspacing=1 border=0>

<?
if($empty!=1){
while ($row= mysql_fetch_array($res)) {
         {
         $bgcolor="#F7F7F7";
         $i % 2 ? 0: $bgcolor= "#ECECFF";
         $i++;
         ?>
    <tr>
     <td colspan=6 bgcolor="<?echo $bgcolor;?>" align="center">
            <?
            echo "".$row["title"]."<br>";
           echo "".$row["banner"]."";
           ?>
     </td>
    </tr>
    <tr>
     <td bgcolor="<?echo $bgcolor;?>">
<INPUT TYPE ="checkbox" VALUE ="ON" NAME ="delete[<?php echo$row["bannerID"]; ?>]">
     </td>
     <td bgcolor="<?echo $bgcolor;?>">
            <?
           echo "".$row["client"]."";
           ?>
     </td>
     <td bgcolor="<?echo $bgcolor;?>">
      <a href="banneractivate.php?bannerID=<?echo $row["bannerID"];?>&value=<?echo $row["active"];?>&position=<? echo $position;?>">
      <?
       if ($row["active"] == "true")
          echo "De-Activate";
       else
          echo "Activate";
      ?></a>
     </td>
     <td bgcolor="<?echo $bgcolor;?>">
      <a href="form.php?bannerID=<?echo $row["bannerID"];?>">Modify Banner</a>
     </td>
     <td bgcolor="<?echo $bgcolor;?>">
      <a href="stat.php?bannerID=<?echo $row["bannerID"];?>">View Stat.</a>
     </td>
    </tr>
    <tr>
     <td colspan=6 bgcolor='#FFFFFF'>&nbsp;</td>
    </tr>

 <?
 }
}

 ?>
        </table></td></tr>
       </table>
 <INPUT TYPE=HIDDEN NAME=position value=<?echo $position;?>>
<INPUT TYPE=HIDDEN NAME=submit value=1>
<INPUT TYPE=SUBMIT VALUE="Delete" name="del1" style="BACKGROUND-COLOR: #3A2B86; COLOR: white">

</form>
  <?
 }
 }
?>
  </td></tr></table>

</body>
</html>