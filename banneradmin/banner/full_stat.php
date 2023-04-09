<?
include 'common.php';
$table="banner_stat";
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

<body>  <?

  $total_cl=0;
  $tootal_vi=0;
 $query="select clicks, views, date,id, bannerID from banner_stat where bannerID='$bannerID' AND YEAR(date)='".date("Y")."'";
              $res = mysql_query($query,$connection)
                    or die ("Couldn't select records!/2");

                   while($row= mysql_fetch_array($res)) {
                     if($row["clicks"]!=0)
                    $total_cl++;
                     if($row["views"]!=0)
                   $total_vi++;

                   }
          ?>








  <table border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#000099">
  <tr>
    <td>
      <table border="0" align="center" bgcolor="#FFFFFF" cellspacing="0" cellpadding="5">
        <tr bgcolor="#000099">
          <td><span class="heading">Banner Adminstration / Statistic /
        <?
         $query2="select bannerID, title, src, client from banners WHERE bannerID='$bannerID'";
         $res2 = mysql_query($query2,$connection)
                    or die ("Couldn't select records!/3");
         $client = mysql_fetch_array($res2);
                           echo $client["client"];

          ?>
          </span></td>
        </tr>

         <tr>
  <td bgcolor="#CCCCCC">
 <a href=index.php>Home</a></td>
 </tr>
 <tr><td align=center>
 <?
 echo "<img src=".$client["src"].">";
 ?>
 <hr>
 </td></tr>

        <tr><td>


        <table border="0" cellspacing="2" cellpadding="2" align="center">
        <tr>
        <th colspan=2>January</th>
        <th colspan=2 >February</th>
        <th colspan=2>March</th>
        <th colspan=2>April</th>
        <th colspan=2>May</th>
        <th colspan=2>June</th>
        <th colspan=2>July</th>
        <th colspan=2>August</th>
        <th colspan=2>September</th>
        <th colspan=2>October</th>
        <th colspan=2>November</th>
        <th colspan=2>December</th>

        </tr>
        <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>


        </tr>
        <tr>
          <?


for($k=1; $k<=12; $k++){

          $query1="select clicks, views, date,id, bannerID from banner_stat where bannerID='$bannerID' AND MONTH(date)='$k' AND YEAR(date)='".date("Y")."'";
              $res1 = mysql_query($query1,$connection)
                    or die ("Couldn't select records!/2");
                   $i=0;
                   $j=0;
                   if(mysql_num_rows($res1)!=0){
                   while($row1= mysql_fetch_array($res1)) {
                     if($row1["clicks"]!=0)
                       $j++;

                     if($row1["views"]!=0)
                       $i++;

                    }
                   }
                   if($total_vi!=0)
                   $height1 = round(($i/$total_vi)*100);
                   if($total_vi!=0)
                   $height2 = round(($j/$total_vi)*100);


                   echo "<td valign=bottom align=center>";
                   if($height1!=0)
                   echo "<font size=1><b>$i</b></font><br><img src=1.jpg WIDTH=10 HEIGHT=$height1>";
                   echo "</td>";
                   echo "<td valign=bottom align=center>";
                   if($height2!=0)
                   echo "<font  size=1><b>$j</b></font><br><img src=2.jpg WIDTH=10 HEIGHT=$height2";
                   echo "</td>";



                   }
                  ?>
               </tr>
               </table>
         <FORM action=<?echo $PHP_SELF?> method=post name=request>
                 <hr>
               <table width=100%><tr><td>
                 <img src=1.jpg WIDTH=10 HEIGHT=10> - Views<br>
                  <img src=2.jpg WIDTH=10 HEIGHT=10> - Clicks<br>
                  </td><td>
                    Choose client:

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




                  </td></tr></table>
                  <hr>

        <?
if ( trim($mon) == "")
$mon=date("m");

        $date_mon=date("n");
             $query="select clicks, views, date,id, bannerID from banner_stat where bannerID='$bannerID' AND MONTH(date)='$mon' AND YEAR(date)='".date("Y")."'";
              $res = mysql_query($query,$connection)
                    or die ("Couldn't select records!/2");
                   $mon_cl=0;
                   $mon_vi=0;
                   while($row= mysql_fetch_array($res)) {
                      if($row["clicks"]!=0)
                       $mon_cl++;

                     if($row["views"]!=0)
                       $mon_vi++;

                   }

                      if($mon_vi!=0)
                         $mon_stat_rat = round(100 * ($mon_cl/$mon_vi));
                     else
                        $mon_stat_rat=0;

                     if($total_cl!=0 )
                         $total_stat_rat =  round(100 * ($total_cl/$total_vi));
                     else
                         $total_stat_rat=0;







                                 ?>

  <table border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#000099" width=70%>
  <tr>
    <td>
      <table border="0" align="center" bgcolor="#FFFFFF" cellspacing="0" cellpadding="5" width=100%>

              <tr>
               <td></td>
               <th colspan=3><font  size=3>Statistic for year : <?echo date("Y")?></font></th>
               </tr>
               <tr>
                 <th></th>
                 <th><font  size=2>Views</font></td>
                 <th><font  size=2>Clicks</font></th>
                  <th><font  size=2>Click-Through Ratio</font></th>
               </tr>
               <tr>
                   <th>

<SELECT NAME="mon" style="font-size: 14px;  padding-top: 1;font-weight: bold; padding-bottom: 1; border-style: dotted;">
<OPTION VALUE="01"<?php
if ($mon == "01") echo " SELECTED" ?>>Jnauary
<OPTION VALUE="02"<?php
if ($mon == "02") echo " SELECTED" ?>>Febuary
<OPTION VALUE="03"<?php
if ($mon == "03") echo " SELECTED" ?>>March
<OPTION VALUE="04"<?php
if ($mon == "04") echo " SELECTED" ?>>April
<OPTION VALUE="05"<?php
if ($mon == "05") echo " SELECTED" ?>>May
<OPTION VALUE="06"<?php
if ($mon == "06") echo " SELECTED" ?>>June
<OPTION VALUE="07"<?php
if ($mon == "07") echo " SELECTED" ?>>July
<OPTION VALUE="08"<?php
if ($mon == "08") echo " SELECTED" ?>>August
<OPTION VALUE="09"<?php
if ($mon == "09") echo " SELECTED" ?>>September
<OPTION VALUE="10"<?php
if ($mon == "10") echo " SELECTED" ?>>October
<OPTION VALUE="11"<?php
if ($mon == "11") echo " SELECTED" ?>>November
<OPTION VALUE="12"<?php
if ($mon == "12") echo " SELECTED" ?>>December
</SELECT></th>
                   <td align=center><? echo $mon_vi?></td>
                   <td align=center><? echo $mon_cl?></td>
                      <td align=center><? echo $mon_stat_rat?> %</td>
                </tr>
               <tr>
                   <th><font size=3>Total<font></th>
                   <td align=center><? echo $total_vi?></td>
                   <td align=center><? echo $total_cl?></td>
                      <td align=center><? echo $total_stat_rat?> %</td>

                </tr></table></td></tr></table>

   <input type=hidden name=position value=<?echo $position?>>

<center><input type=submit name=sum value=submit>
        </form>        </center>
        </td></tr></table></td></tr></table>


        </body>
        </html>