<?
include_once "config.php";
include_once "left_cats.php";
include_once "right_index.php";
function main()
{
if ( isset( $_REQUEST["cid"] ) && $_REQUEST["cid"]!="" )
{
$cid=$_REQUEST["cid"];
}
else
{
$cid=0;
}

$strpass="";
if ( isset($_REQUEST["keyword"] ) )
{
$strpass=$strpass . "&keyword=" . $_REQUEST["keyword"];
}
$strpass=$strpass . "&cid=" . $cid;






$rs_query=mysql_query("Select * from sbwmd_categories where id=" . $cid );
	if ($rs=mysql_fetch_array($rs_query))
	{
	$catname=$rs["cat_name"];
	$category=$rs["id"];
	$cid=$rs["id"];
	}
    else
	{
	$catname="";
	$category=0;
	$cid=0;
	}
    $catpath="";
  	$rs_query=mysql_query("Select * from sbwmd_categories where id=" . $category );

	while ($rs=mysql_fetch_array($rs_query))
    {
    $catpath ="<font size='2' color=#FFFFFF>>&nbsp;</font><a href=\"showcategory.php?cid=" . $rs["id"] . "\"><font size='2' color=#FFFFFF face='Verdana, Arial, Helvetica, sans-serif'>" .$rs["cat_name"]."</a>" . $catpath; 
  	$rs_query=mysql_query("Select * from sbwmd_categories where id=" . $rs["pid"] );
    }
  


$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));
$recperpage=$rs0["recperpage"];
$sql="select * from sbwmd_softwares where approved='yes'  ";

///////////////////////////////////////////////			  
	$rst1_query=mysql_query("Select * from sbwmd_categories where pid=" . $cid );
	$clist=$cid;
	while ( $rst1=mysql_fetch_array($rst1_query) )
	{
 	$clist.="," . $rst1["id"];
	while ( $rst1=mysql_fetch_array($rst1_query) )
	{ 
	$clist.="," . $rst1["id"];
	}
    
	$rst1_query=mysql_query("Select * from sbwmd_categories where pid IN (" . $clist . ") and id not in ( ". $clist . ")") ;
}
$sql.=" and cid in (" . $clist . ") "  ;
////////////////////////////////////////////




///////////////////////////



if ( isset($_REQUEST["keyword"] ) && $_REQUEST["keyword"]!="")
{
$sql=$sql." and ( s_name like '%".str_replace("'","''",$_REQUEST["keyword"])."%' or   admin_desc like '%".str_replace("'","''",$_REQUEST["keyword"])
. "%')";
}


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
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="25"> 
      <table cellpadding="0" cellspacing="0">
        <tr> 
          <td width="202" height="22"> <font color="#000000"><strong>&nbsp; <a href="index.php"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Home</font></a> 
            <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo  $catpath; ?></font></strong></font></td>
        </tr>
      </table>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td valign="top"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><form name="form2" method="post" action="showcategory.php">
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr> 
                  <td width="17%"><FONT color=#000000><strong>SEARCH</strong></font></FONT></td>
                  <td width="31%"><input type="text" name="keyword"></td>
                  <td width="24%"><select name="cid">
                      <?
			  $cats=mysql_query("select * from sbwmd_categories where pid=0");
			  while($rst=mysql_fetch_array($cats))
			  {
			  		  ?>
                      <option value="<? echo $rst["id"]; ?>"><? echo $rst["cat_name"]; ?></option>
                      <?
					}//end while
					 ?>
                    </select></td>
                  <td width="28%"><input type="submit" name="Submit2" value="Go" class="input"></td>
                </tr>
              </table>
            </form></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr bgcolor="#003366"> 
                <td height="25"><strong><font color="#FFFFFF" size="2" >&nbsp;&nbsp;Name</font></strong></td>
                <td height="25" bgcolor="#003366"><strong><font color="#FFFFFF" size="2" >Rating</font></strong></td>
                <td height="25"><strong><font color="#FFFFFF" size="2" >Popularity</font></strong></td>
                <td height="25"><strong><font color="#FFFFFF" size="2" >Licence</font></strong></td>
                <td height="25"><strong><font color="#FFFFFF" size="2" >Supported 
                  Platforms</font></strong></td>
              </tr>
              <?
				if ($pages==0)
					{
				?>
              <tr > 
                <td colspan=5> <div align="center"> <br>
                    <table width= 100% align="center" bgcolor="#C8C8C8" bordercolor="#ffffff" border="0" cellpadding="5" >
                      <tr> 
                        <td><div align="center"><b><font face="verdana, arial" size="1" color="#000000"> 
                            No listing entries satisfy the criteria you specified. 
                            </font></b></div></td>
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
              <tr> 
                <td height="19"><a href="software-description.php?id=<? echo $rs0["id"];?>" class="insidelink"><? echo $rs0["s_name"];?> 
                  </a></td>
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
				{ 
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
				$i++;
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
				echo "<img src=\"images/pop1.gif\" width=\"2\" height=\"3\">";
				   }
				   else
				   {
				   echo "<img src=\"images/pop2.gif\" width=\"2\" height=\"3\">";
				   	   
				   
				   					}
				}	
				?>
                </td>
                <td> 
                  <?
				$licence=mysql_fetch_array(mysql_query("select * from sbwmd_licence_types where id=".$rs0["lid"]));
				?>
                  <font color="#333333" size="2" ><? echo $licence["licence_name"];?></font></td>
                <td bgcolor="#FFFFFF"> 
                  <?
				
//////////////////////////////////
$cid_t=$rs0["cid"];
$rs_1=mysql_fetch_array(mysql_query("select * from sbwmd_categories where   id=" . $cid_t ));

while(  $rs_1["pid"] <>0)
{
 $cid_t=$rs_1["pid"];
 $rs_1=mysql_fetch_array(mysql_query("select * from sbwmd_categories where id=" . $cid_t ));
}

$cid_plat=$rs_1["id"];
//////////////////////////////////

		
				
				if($rs0["platforms"]<>'')
				$platforms=explode(",",$rs0["platforms"]);
				else
				$platforms='';
				
				$num=1;
				$plat=mysql_query("select * from sbwmd_platforms where cid=". $cid_plat);
				while($rs_plat=mysql_fetch_array($plat))
				{ $checked=0;$index=0;
				 
				?>
                  <font color="#<?
				   if ( strpos( ",," . $rs0["platforms"] . "," ,"," .$rs_plat["id"] . ",") )
				    echo "009933"; 
					else 
					echo "cccccc"; 
					?>" size="2" > 
                  <? if ($num==1){ echo $rs_plat["plat_name"]; $num=0;}else echo "<font color='#000000'> - </font>".$rs_plat["plat_name"];?>
                  </font> 
                  <?
				}//wend
				?>
                </td>
              </tr>
              <?
			$cnt=$cnt+1;
	 		
			}//while
			$cnt=0;
			?>
            </table></td>
        </tr>
        <tr> 
          <td> </td>
        </tr>
        <tr> 
          <td>&nbsp; </td>
        </tr>
        <tr> 
          <td>
            <?
			}// else
			?>
          </td>
        </tr>
        <?
	  if ($pages>1)
	  {
	  ?>
        <TR> 
          <TD> <DIV align=center> 
              <TABLE cellSpacing=0 cellPadding=0 border=0>
                <TBODY>
                  <TR> 
                    <TD width=42> 
                      <?



			if ($pg!=1)



			{



			?>
                      <a href="showcategory.php?pg=<?php echo ($pg-1); ?><?php echo "$strpass"; ?>" > 
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
                      <a href="showcategory.php?pg=<?php echo ($pg+1); ?><?php echo "$strpass"; ?>" > 
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
            </DIV></TD>
        </TR>
        <TR> 
          <TD><IMG height=3 alt="" 
                              src="images/pix.gif" width=1 
                            border=0></TD>
        </TR>
        <TR> 
          <TD> <DIV align=center> 
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
              <a href="showcategory.php?pg=<?php echo "$jmpcnt$strpass"; ?>" > 
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
              &nbsp;</font></DIV></TD>
        </TR>
        <?
		}
		?>
      </table></td>
  </tr>
</table>
<?
}// end main

?>
<?
include_once "template.php";
?>
