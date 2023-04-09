<?
include_once "config.php";
?>
<?
if ( isset( $_REQUEST["cid"] ) && $_REQUEST["cid"]!="" )
{
$cid=$_REQUEST["cid"];
}
else
{
$cid=0;
}

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
//	echo "Select * from sbppc_categories where id=" . $category ;
	while ($rs=mysql_fetch_array($rs_query))
    {
    $catpath ="><a href=\"choosecategory.php?cid=" . $rs["id"] . "\">" .$rs["cat_name"]."</a>" . $catpath; 
  	$rs_query=mysql_query("Select * from sbwmd_categories where id=" . $rs["pid"] );
	 }
    
  ?>

<html>
<head>
<title>Choose Category</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<Script Language="JavaScript">
function closewin()
{
window.opener.document.frm1.<?php echo "cat" . $_REQUEST["box"];?>.value='<?php echo $cid; ?>';
window.opener.document.frm1.<?php echo "cat_name" . $_REQUEST["box"];?>.value='<?php echo $catname; ?>';

window.close()
}
</script>
<form action="choosecategory.php" method="post" name="frm123">
  <table width="400" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><strong>Choose Category</strong></font></td>
    </tr>
    <tr> 
      <td bgcolor="#CCCCCC"><a href="choosecategory.php"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">All Categories</a></font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  $catpath; ?></font></td>
    </tr>
  </table>
   
  <?
  	$rs_query=mysql_query("Select count(*) from sbwmd_categories where pid=" . $cid );
	$rs=mysql_fetch_array($rs_query);
	
$rs_query=mysql_query("Select * from sbwmd_categories where pid=" . $cid );
if ($rs=mysql_fetch_array($rs_query))
	{
	
  ?>
  <table width="400" border="0" cellspacing="0" cellpadding="0">
    <?php
					   $cnt=1;
					   $rs_query_t=mysql_query("Select * from sbwmd_categories where pid=" . $cid	);
					   while($rs_t=mysql_fetch_array($rs_query_t))
					   {
					   ?>
    <?php if ($cnt%2==1) { ?>
    <tr> 
      <?php } ?>
      <td> <a href="choosecategory.php?box=<?php echo $_REQUEST["box"] ;?>&cid=<?php echo $rs_t["id"] ;?>"><?php echo $rs_t["cat_name"] ;?></a> 
        </font></td>
      <?php if ($cnt%2==0) { ?>
    </tr>
    <?php } ?>
    <?php
						$cnt++;
					   }
					   ?>
  </table>
  </font> 
  <?
}
else
{
?>
   </font> 
  <input type="button" name="Button" value="Done" onClick="javascript:onclick=closewin()">

<?

}
?>
</form>
</body>
</html>
