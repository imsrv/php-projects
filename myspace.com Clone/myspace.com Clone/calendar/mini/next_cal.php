<?
/*
           .ÜÜÜÜÜÜÜÜÜÜÜÜ,                                  .ÜÜÜÜÜÜÜÜÜ:     ,ÜÜÜÜÜÜÜÜ:
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                             .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ             D O N          ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                           ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ          ÜÜÜÜÜÜÜ;        .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜ;
         ,ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜ        ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜ;
          ÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜ      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜÜÜ
          ÜÜÜÜÜÜÜÜ: ÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜ;      :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ   ;ÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜ     .ÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ
        :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜ,,,ÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
       ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ, ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
     .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
    ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
   ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
  ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;     ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ,  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
 ,ÜÜÜÜLiquidIceÜÜÜÜÜÜ          ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ
    .ÜÜÜÜÜÜÜÜÜÜ;                 ÜÜÜÜÜÜÜÜÜ        .ÜÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜÜÜ,

*/

//if (isset($_GET['monthno_n'])) $monthno_n = $_GET['monthno_n'];
//if (isset($_GET['year_n'])) $year_n = $_GET['year_n'];
if (!isset($next_month))	$monthno = date(n);
else	$monthno=$next_month;
if (!isset($next_year))	$year = date(Y);
else	$year=$next_year;
$monthfulltext = date(F, mktime(0, 0, 0, $monthno, 1, $year));
$monthshorttext = date(M, mktime(0, 0, 0, $monthno, 1, $year));

$day_in_mth = date(t, mktime(0, 0, 0, $monthno, 1, $year)) ;
$day_text = date(D, mktime(0, 0, 0, $monthno, 1, $year));


?>
<table width=100% border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff" class=caltable>
  <tr align="center" valign="middle"> 
    <td height="25" colspan=7><font size="-1"><b><a href="calendar.php?mode=calendar&month=<?=$monthno?>&year=<?=$year?>"><? echo $monthfulltext." ".$year ?></a></b></font></td>
  </tr>
  <tr align="right"> 
    <td height="20" align="right"><strong><font size="-2">Sun</font></strong></td>
    <td height="20" align="right"><strong><font size="-2">Mon</font></strong></td>
    <td height="20" align="right"><strong><font size="-2">Tue</font></strong></td>
    <td height="20" align="right"><strong><font size="-2">Wed</font></strong></td>
    <td height="20" align="right"><strong><font size="-2">Thu</font></strong></td>
    <td height="20" align="right"><strong><font size="-2">Fri</font></strong></td>
    <td height="20" align="right"><strong><font size="-2">Sat</font></strong></td>
  </tr>
  <tr> 
    <?

$day_of_wk = date(w, mktime(0, 0, 0, $monthno, 1, $year));

if ($day_of_wk <> 0){
   for ($i=0; $i<$day_of_wk; $i++)
   { echo "<td height='15'>&nbsp;</td>"; }
}

for ($date_of_mth = 1; $date_of_mth <= $day_in_mth; $date_of_mth++) {

    if ($day_of_wk = 0){
   for ($i=0; $i<$day_of_wk; $i++);
   { echo "<tr align='right'>"; }
}
    $day_text = date(D, mktime(0, 0, 0, $monthno, $date_of_mth, $year));
    $date_no = date(j, mktime(0, 0, 0, $monthno, $date_of_mth, $year));
    $day_of_wk = date(w, mktime(0, 0, 0, $monthno, $date_of_mth, $year));
   if ( $date_no ==  date(j) &&  $monthno == date(n) )
     {  echo "<td height='15' align='right'><font size='-2'>".$date_no."</font></td>"; }
   else{
   echo "<td height='15' align='right'><font size='-2'>".$date_no."</font></td>";  }
   If ( $day_of_wk == 6 ) {  echo "</tr>"; }
   If ( $day_of_wk < 6 && $date_of_mth == $day_in_mth ) {
   for ( $i = $day_of_wk ; $i < 6; $i++ ) {
     echo "<td height='15'>&nbsp;</td>"; }
      echo "</tr>";
      }
 }
?>
</table>
