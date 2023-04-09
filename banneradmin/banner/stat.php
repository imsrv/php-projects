 <?

include 'common.php';
$table="banners";
 $j=0;

    $query = "select * from $table ";
    if(isset($bannerID))
     $query=$query." WHERE bannerID='$bannerID'";
     else if(($position==1 || $position==2))
       $query=$query." WHERE local_banner='$position' ORDER by title";
     $res = mysql_query($query,$connection)
        or die ("Couldn't select records!");


?>
<html>
<HEAD>
<style>
<!--
A {COLOR: blue; TEXT-DECORATION: none}
a:hover {COLOR: red; TEXT-DECORATION: underline}

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
          <td><span class="heading">Banner Adminstration / Statistic /
                 <?
           if(isset($bannerID)){
        $res3 = mysql_query($query,$connection)
              or die ("Couldn't select records!");
              $row3= mysql_fetch_array($res3);
              echo "".$row3["client"]."";

             } else {

             if($position==1 )
             echo " Front page Banners";
            if($position==2 )
             echo " Inside Page Banners";

            }
            ?>


          </span></td>
        </tr>
        <tr>
          <td>
   </td>
 </tr>
 <tr>
  <td bgcolor="#CCCCCC">
 <a href=index.php> Home </a> <img src=arrow.gif  width=8 height=7> <a href=admin.php?position=<?echo$position?>> Banner Adminstrationr </a> <img src=arrow.gif width=8 height=7> Banner Stat <br>  </td>
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


<table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr><td bgcolor=#99999>
<table width="100%" cellpadding=3 cellspacing=1 border=0>

<?
if($empty!=1){
while ($row= mysql_fetch_array($res)) {
         $bgcolor="#F7F7F7";
         $i % 2 ? 0: $bgcolor= "#ECECFF";
         $i++;
         ?>
    <tr>
     <td colspan=6 bgcolor="<?echo $bgcolor;?>" align="center">
            <?
            echo "".$row["title"]."<br>";
           echo "<A href=full_stat.php?bannerID=".$row["bannerID"]."><img src=".$row["src"]."></A><br> Click on the banner to view full statistic!";
        $query1="select clicks, views, date,id, bannerID from banner_stat where bannerID='".$row["bannerID"]."' AND date>DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY) ORDER BY date desc";
              $res1 = mysql_query($query1,$connection);
							echo mysql_error();
              //      or die ("Couldn't select records!/2");
                   $i=0;
                   $j=0;
                   while($row1= mysql_fetch_array($res1)) {
                   if($row1["clicks"]!=0)
                    $j++  ;
                    if($row1["views"]!=0)
                    $i++;
                    $dateFROM=$row1["date"];
                   }
           ?>
     </td>
    </tr>
        <tr>
     <td bgcolor="<?echo $bgcolor;?>"> Stat from </td>
     <?
             if(trim($dateFROM)!=""){
             $deadparts = explode("-",$dateFROM);
                           $year = $deadparts[0];
                           $month = $deadparts[1];
                           $day = $deadparts[2];

        $monthstamp = mktime(0,0,0,$month,$day,$year);
         $date1=date("M-d-Y",$monthstamp);
        } else {
          $date1="No stat";
          //date("M-d-Y");
        }

     ?>
      <td bgcolor="<?echo $bgcolor;?>"><?  echo$date1; ?>   </td>
    </tr>
      <tr>
     <td bgcolor="<?echo $bgcolor;?>"> Views </td>
      <td bgcolor="<?echo $bgcolor;?>"><? echo "$i"; ?>   </td>
    </tr>
    <tr>
     <td bgcolor="<?echo $bgcolor;?>"> Clicks </td>
      <td bgcolor="<?echo $bgcolor;?>"><? echo "$j";   ?> </td>
    </tr>
    <tr>
     <td bgcolor="<?echo $bgcolor;?>"> Click-Through Ratio:</td>
         <?


          if($i!=0 && $j!=0)
            $percent = 100 * ($j/$i);

         if ($i==0)
          $percent =100;

         if($j==0)
         $percent=0;

            ?>
      <td bgcolor="<?echo $bgcolor;?>"> <?  printf(" %.2f%%", $percent);    ?> </td>
    </tr>
          <tr>
     <td colspan=6 bgcolor='#FFFFFF' align=center>
<form action="statEmpty.php" method="POST" enctype="multipart/form-data">
<INPUT TYPE="hidden" NAME="bannerID" VALUE="<?echo$row["bannerID"]?>">
<INPUT TYPE="hidden" NAME="position" VALUE="<?echo$position?>">
<INPUT TYPE="submit" name="empt" VALUE="Empty Statistic -Banner ID # <?echo$row["bannerID"]?>">
</FORM>
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



</form>
  </td></tr></table>

</body>
</html>