<?php
include_once "config.php";
include_once "left_cats.php";
include_once "right_index.php";





function main()
{

			  $most_pop=mysql_query("select id,hits_dev_site,downloads,page_views from sbwmd_softwares ");
			  $cnt=1;
			  $popularity=0.0;
			  while($rst=mysql_fetch_array($most_pop))
			  {
			  	if($rst["page_views"]==0)
				$popularity=0;
				else
				$popularity=(($rst["hits_dev_site"]+$rst["downloads"])/$rst["page_views"]);
				$popularity*=50;
				if($popularity>50)
				$popularity=50;
				mysql_query("update sbwmd_softwares set popularity=".$popularity." where id=".$rst["id"]);			  
			  }


/////////////getting null char
	$null_char=mysql_fetch_array(mysql_query("select null_char from sbwmd_config"));

	if ( isset($_REQUEST["id"] ) && $_REQUEST["id"]!="")
	{
    
	$rst=mysql_fetch_array(mysql_query("Select * from sbwmd_softwares where id=" . $_REQUEST["id"] ));
    if ($rst)
	{
	$cid=$rst["cid"];
	}
	else
	{
	header("Location:"."index.php");
	}
	
	}
    else
	{
	header("Location:"."index.php");
	}
	
	mysql_query("update sbwmd_softwares set page_views=".($rst["page_views"]+1)." where id=" . $_REQUEST["id"] );
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
	
	if ( isset($_REQUEST["id"] ) && $_REQUEST["id"]!="")
	{
    $rst=mysql_fetch_array(mysql_query("Select * from sbwmd_softwares where id=" . $_REQUEST["id"] ));
	
    }

?>


<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#0066FF"> 
    <td height="25" colspan="2" bgcolor="#FFFFFF"> 
      <table width="376" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="99" height="22"> <font color="#000000"><a href="index.php"><font size="2">Home</font></a> 
           <? echo  $catpath; ?></font></font></td>
        </tr>
      </table>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td width="78%" colspan="2" valign="top"> <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td> 
            <?
if ( isset($_REQUEST["msg"])&&$_REQUEST['msg']<>"")
{
?>
            <br> <table align="center" bgcolor="#FEFCFC" bordercolor="#FFFFFF" border="0" cellpadding="5" >
              <tr> 
                <td><b><font face="verdana, arial" size="1" color="#666666"> 
                  <?
print($_REQUEST['msg']); 

?>
                  </font></b></td>
              </tr>
            </table>
            <br> 
            <?
}//end if
?>
          </td>
        </tr>
        <tr> 
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr bgcolor="#003366"> 
                <td height="25" colspan="2"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<? echo $rst["s_name"];?></font></strong></td>
              </tr>
              <tr> 
                <td width="54%" height="19" valign="top"><br> 
                  <table width="95%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td width="47%"><strong><font size="2" face="Arial, Helvetica, sans-serif">Rating</font></strong></td>
                            <td width="53%"><strong><font size="2" face="Arial, Helvetica, sans-serif">Popularity</font></strong></td>
                          </tr>
                          <tr> 
                            <td> 
                              <?
				$avgrat=0.0;
				$rating=mysql_fetch_array(mysql_query("select count(rating) as cnt,sum(rating) as sum from sbwmd_ratings where sid=".$rst["id"]));
				if($rating["cnt"]<>0)
				$avgrat=$rating["sum"]/$rating["cnt"];
				else
				$avgrat=0.0;
				$avgrat/=2;
				$no_stars=0;
				$no_stars=($avgrat+0.5);
				
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
				$pop=$rst["popularity"]+40;
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
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td width="23%"><strong><font size="2" face="Arial, Helvetica, sans-serif">Price</font></strong></td>
                      <td width="77%"><font size="2" face="Arial, Helvetica, sans-serif"> 
                        <?
					  if( ($rst["price"]==0) || ($rst["cur_id"]==0))
					  echo $null_char[0];
					  else
					  {
					  $cur=mysql_fetch_array(mysql_query("select * from sbwmd_currency where id=".$rst["cur_id"]));
					  echo $cur["cur_name"].$rst["price"];
					  }
					  ?>
                        </font></td>
                    </tr>
                    <tr> 
                      <td><strong><font size="2" face="Arial, Helvetica, sans-serif">License</font></strong></td>
                      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
                        <?
					  $lic=mysql_fetch_array(mysql_query("select * from sbwmd_licence_types where id=".$rst["lid"]));
					  echo $lic["licence_name"];
					  ?>
                        </font></td>
                    </tr>
                    <tr> 
                      <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $rst["eval_period"];?></font></td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td colspan="2"><strong><font size="2" face="Arial, Helvetica, sans-serif">Features</font></strong></td>
                    </tr>
                    <tr> 
                      <td colspan="2">
                        <?php
				   	
					$s=mysql_query("Select major_features  from sbwmd_soft_desc where sid=" .$_REQUEST['id']);
					if($s) $prog1 = mysql_fetch_row($s);
										
					echo ($prog1[0]);
					
					?>
                      </td>
                    </tr>
                    <tr> 
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Description</font></strong></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td colspan="2"><div align="justify"><font color="#333333" size="1" face="Arial, Helvetica, sans-serif"> 
                          <?php
				   	
					$r=mysql_query("Select prog_desc from sbwmd_soft_desc where sid=" .$_REQUEST['id']);
					if($r) $prog = mysql_fetch_row($r);
										
					echo ($prog[0]);
					
					?>
                          </font></div></td>
                    </tr>
                  </table>
				  <p> </p></td>
                <td width="46%"> <br> 
                  <table width="95%" align="right" cellpadding="2" cellspacing="0" class="onepxtable">
                    <tr> 
                      <td bgcolor="#003366"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">About 
                        The File</font></strong></td>
                    </tr>
                    <tr> 
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td width="41%"><strong><font color="#0066FF" size="2" face="Arial, Helvetica, sans-serif">Size</font></strong></td>
                            <td width="59%"><font size="2" face="Arial, Helvetica, sans-serif"> 
                              <? 
							if( ($rst["size"]==0))
					  		{		
							echo $null_char[0];?>
                              <?
							}// end if
							else
					  		{
							
							echo ( (int)($rst["size"]/1024) )."<strong> 
                              KB</strong>";
							}
							  ?>
                              </font></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td bgcolor="#EBEBEB"><div align="center"><a target=_BLANK href="clicks_inc.php?id=<? echo $rst["id"];?>&click=1&url=<? echo $rst["soft_url"];?>" class="sidelink"><font color="#FF0000" size="2"><strong>Download 
                          Now</strong></font></a></div></td>
                    </tr>
                    <tr> 
                      <td>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td bgcolor="#003366"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Rate 
                        This Software 
                        <script language=javascript> 
<!--
	function Validate(form) {
	if ( form.rating.value == "" ) {
       	   alert('insert rating value!');
	   return false;
	   }
	    return true;
  }
// -->
</script>
                        </font></strong></td>
                    </tr>
                    <tr> 
                      <td bgcolor="#EBEBEB"><form name="rating" onSubmit="return Validate(this);" action="insert_rating.php" method="post">
                          <input type="hidden" name="sid" value="<? echo $_REQUEST["id"];?>">
                          <table width="100%" cellpadding="0" cellspacing="0">
                            <tr> 
                              <td align="left"  bgcolor="#EBEBEB"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                                  <select name="rating"  class="keyword" >
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                  </select>
                                  <input type=submit class="keyword" value=Go name=submit>
                                  </font></div></td>
                            </tr>
                          </table>
                        </form></td>
                    </tr>
                    <tr> 
                      <td><a target=_BLANK href="clicks_inc.php?id=<? echo $rst["id"];?>&click=2&url=<? echo $rst["home_url"];?>" class="sidelink">Developers 
                        Home Page</a></td>
                    </tr>
                    <tr> 
                      <td><a href="emailafriend.php?sid=<? echo $rst["id"];?>" class="sidelink">Email 
                        A Friend</a></td>
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
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>
<?
}// end main
include "template.php";
?>