<?
include "logincheck.php";
include_once "config.php";
include_once "left_mem.php";

function main()
{

$strpass="";

if ( isset($_REQUEST["id"] ) )
{
$strpass=$strpass . "&id=" . $_REQUEST["id"];
}
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));
$recperpage=$rs0["recperpage"];
$sql="select *,UNIX_TIMESTAMP(date_submitted) as ds,UNIX_TIMESTAMP(date_approved) as da from sbwmd_softwares where uid=".$_SESSION["userid"];
$sql.= " order by popularity desc" ;
$rs_query=mysql_query($sql);
///////////////////////////////////PAGINATION /////////
	if(!isset($_REQUEST["pg"]))
	{
			$pg=1;
	}
	else 
	{
	$pg=$_REQUEST["pg"];
	}
$rcount=mysql_num_rows($rs_query);
if ($rcount==0 )
{ 
	$pages=0;
}	
else
{
	$pages=floor($rcount / $recperpage);
	if  (($rcount%$recperpage) > 0 )
	{
		$pages=$pages+1;
	}
}
$jmpcnt=1;
while ( $jmpcnt<=($pg-1)*$recperpage  && $row = mysql_fetch_array($rs_query) )
    {	
		$jmpcnt = $jmpcnt + 1;
	}

////////////////////////////////////////////////////////////////////////
?>

<link href="../styles/style.css" rel="stylesheet" type="text/css">

<?
//$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_members where id=".$_SESSION["userid"]));
?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td height="25"><a href="index.php"  class="barlink"><font color="#000000"><strong>HOME</strong> 
      </font></a> <font color="#000000">&gt;<strong> SOFTWARE STATISTICS</font></font></strong></font>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td valign="top"> <table width="95%" border="0" cellpadding="0" cellspacing="0">
        <tr align="center" valign="middle" bgcolor="#003366"> 
          <td height="25"><strong><font color="#FFFFFF" size="1" >Name</font></strong></td>
          <td height="25"><strong><font color="#FFFFFF" size="1" >Rating</font></strong></td>
          <td height="25"><strong><font color="#FFFFFF" size="1" >Popularity</font></strong></td>
          <td height="25"><strong><font color="#FFFFFF" size="1" >Downloads</font></strong></td>
          <td height="25"><strong><font color="#FFFFFF" size="1" >Clicks</font></strong></td>
          <td height="25"><strong><font color="#FFFFFF" size="1" >Page 
            Views </font></strong></td>
          <td><strong><font color="#FFFFFF" size="1" >Rating 
            Code </font></strong></td>
        </tr>
        <?
				if ($pages==0)
					{
				?>
        <tr > 
          <td colspan=7> <div align="center"> <br>
              <table width= 100% align="center" bgcolor="#C8C8C8" bordercolor="#ffffff" border="0" cellpadding="5" >
                <tr> 
                  <td><div align="center"><b><font face="verdana, arial" size="1" color="#000000"> 
                      No listing entries satisfy the criteria you specified. </font></b></div></td>
                </tr>
              </table>
            </div></td>
        </tr>
        <?
				echo "</table>";
				}
				else
				{
				?>
        <?
  				$cnt=0;
				while (($rs0=mysql_fetch_array($rs_query)) && $cnt<$recperpage )
				{
			     ?>
        <tr align="center" valign="middle"> 
          <td height="19"><div align="left"><a target="other" href="software-description.php?id=<? echo $rs0["id"]; ?>" class="insidelink"><? echo $rs0["s_name"];?> 
              </a></div></td>
          <td> 
            <?
				$avgrat=0.0;
				$rating=mysql_fetch_array(mysql_query("select count(rating) as cnt,sum(rating) as sum from sbwmd_ratings where sid=".$rs0["id"]));
				if($rating["cnt"]<>0)
				$avgrat=$rating["sum"]/$rating["cnt"];
				else
				$avgrat=0.0;
				$avgrat/=2;
				$no_stars=0;
				$no_stars=abs($avgrat+0.5);
				//if($avgrat >=($no_stars+0.5))
				//$no_stars+=1;
				$i=1;
				while($i<6)
				{ $i++;
				  if($i<=$no_stars)
				  {
				?>
            <img src="images/star1.gif" width="8" height="7"> 
            <?
				   }
				   else
				   {
				   ?>
            <img src="images/star2.gif" width="8" height="7"> 
            <?
					}
				}	
				?>
          </td>
          <td> 
            <?
				$pop=$rs0["popularity"]+40;
				$no_green=$pop/3;	
				$i=1;
				while($i<30)
				{ $i++;
				  if($i<=$no_green)
				  {
				  echo "<img src='images/pop1.gif' width='2' height='3'>"; 
            	   }
				   else
				   { 
				   echo "<img src='images/pop2.gif' width='2' height='3'>"; 
            		}
				}	
				?>
          </td>
          <td><? echo $rs0["downloads"];?></td>
          <td><? echo $rs0["hits_dev_site"];?></td>
          <td><? echo $rs0["page_views"];?></td>
          <td><a href="rating_code.php?id=<? echo $rs0["id"]; ?>" class="insidelink">Get 
            Code</a></td>
        </tr>
        <?
			$cnt=$cnt+1;
	 		
			}//while
			$cnt=0;
			?>
      </table>
      <?
			}// else
			?>
    </td>
  </tr>
  <tr> 
    <TD> <DIV align=center>
        <?
	if ($pages>1) 
	{
	?>
        <TABLE cellSpacing=0 cellPadding=0 border=0>
          <TBODY>
            <TR> 
              <TD width=42> 
                <?



			if ($pg!=1)



			{



			?>
                <a href="viewstat.php?pg=<?php echo ($pg-1); ?><?php echo "$strpass"; ?>" > 
                <?



			 }



			?>
                <?



			if ($pg!=1)



			{



			?>
                </a> 
                <? 



			} 



			?>
              </TD>
              <TD>Page</TD>
              <TD><IMG height=1 alt="" 
                                src="images/pix.gif" width=4 
                                border=0></TD>
              <TD><B><FONT color=#191970><?php echo $pg ;?> </FONT></B></TD>
              <TD><IMG height=1 alt="" 
                                src="images/pix.gif" width=4 
                                border=0></TD>
              <TD>of</TD>
              <TD><IMG height=1 alt="" 
                                src="images/pix.gif" width=4 
                                border=0></TD>
              <TD><B><?php echo $pages; ?></B></TD>
              <TD width=42> 
                <?



			if ($pg!=$pages)



			{



			?>
                <a href="viewstat.php?pg=<?php echo ($pg+1); ?><?php echo "$strpass"; ?>" > 
                <?



			 }



			?>
                <?



			if ($pg!=$pages)



			{



			?>
                </a> 
                <?



			 }



			?>
              </TD>
            </TR>
          </TBODY>
        </TABLE>
        <?
		}
		?>
      </DIV></TD>
  </tr>
  <tr> 
    <TD> <DIV align=center> 
        <?
	if ($pages>1) 
	{
	?>
        <?php



			  


if ($pg<=5)
{
	$jmpcnt=1;
}
else
{
	$jmpcnt=$pg-5;
}

$cnt=0;

	while (  $jmpcnt<=$pages   && $cnt<10 )



    {	

$cnt++;

           

		   if ($jmpcnt!=$pg)

		   {

		   ?>
        <a href="viewstat.php?pg=<?php echo "$jmpcnt$strpass"; ?>" > 
        <?

			}

			else

			{

			echo "<b>";

			}

			echo $jmpcnt;

			if ($jmpcnt!=$pg)

		   {

		   ?>
        </a> 
        <?php

			}

          else

			{

			echo "</b>";

			}

			



if ($jmpcnt<$pages)



echo " | ";



?>
        <?php



		$jmpcnt = $jmpcnt + 1;



	}



			



			?>
        &nbsp;
        <?
		}
		?>
        </font></DIV></TD>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>

<p>&nbsp; </p>
<p><br>
 <?
}// end main
include "template1.php";
?> 

