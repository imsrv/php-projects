<?php

/* nulled by [GTT] :) */ 

@session_start();

if(session_is_registered("admin"))

{include("functions.php");

db_connect();

admin_menu();

$matrix_deep=db_result_to_array("select matrix_deep from admininfo");

if ($did) mysql_query ("delete from aff_payments where id='$did'");

if ($add)
if ( ($programid || $subscrid || ($name&&$price&&$description)) && !($programid && ($name&&$price&&$description)) && !($subscrid && ($name&&$price&&$description)) && !($subscrid && $programid) && $directaf)
 {
  $r=mysql_query ("insert into aff_payments(id,name, description, price,directaf,programid, subscrid) values('','$name','$description', '$price', '$directaf','$programid', '$subscrid')") or die(mysql_error());
  $affitem_id=mysql_insert_id();

  for ($i=1; $i<=$matrix_deep[0][0]; $i++)
   mysql_query("insert into levels_commisions (id, affitem_id, level_num, commission) values ('', $affitem_id, $i, '".$aff_comm[$i]."')");

 }
else echo "<br><center><B>Error: </B>You have to specify either subscribtion or programm, or add another single item and at least direct affiliates commision for it!<br><br></center>";

$result=db_result_to_array("select * from aff_payments");

?>





<center>
<H2>Affilate Items (listed in your products):</H2>
<TABLE width=810 border=0>

 <TBODY>
<tr>
<TD align=middle><B>Item ID</B></TD>

    <TD ><B>Name</B></TD>
    <TD align=middle ><B>Price ($)</B></TD>
        <TD align=middle ><B>Direct aff ($)</B></TD>
<?for ($l=1; $l<=$matrix_deep[0][0]; $l++){?>
    <TD align=middle ><B>level <?echo $l?> ($)</B></TD>
<?}?>
        <TD align=middle ><B>Progr. ID</B></TD>
        <TD align=middle ><B>Subscr. ID</B></TD>
        <td><B>Edit</B></td>
        <td><B>Delete</B></td>

        </TR>



<?for ($i=0; $i<count($result); $i++)

{

?>
<tr>
    <TD ><?echo $result[$i]['id'];?></TD>
        <TD ><?if (!$result[$i]['name']) echo "N/A"; else echo $result[$i]['name'];?></TD>
    <TD align=middle ><?if (!$result[$i]['price']) echo "N/A"; else echo number_format($result[$i]['price'],2);?></TD>
        <TD align=middle ><?echo number_format($result[$i]['directaf'],2);?></TD>
<?for ($l=1; $l<=$matrix_deep[0][0]; $l++){
          $current_commision=db_result_to_array("select commission from levels_commisions where affitem_id=".$result[$i]['id']." and level_num=$l");
?>
    <TD align=middle ><?echo number_format($current_commision[0][0],2);?></TD>
<?}?>
        <TD align=middle ><?echo $result[$i]['programid'];?></TD>
        <TD align=middle ><?echo $result[$i]['subscrid'];?></TD>
        <td><A

      href="admitemset-edit.php?pid=<?echo $result[$i][0];?>">Edit</A></td>
        <td><A

      href="admitemset.php?did=<?echo $result[$i][0];?>">Delete</A></td>
</tr>
<?}?>

</TABLE>


<HR width=700><br><br>
<h2>Available Programs:</h2><?display_programs();?><br><br>

<h2>Available Subscribtions:</h2><?display_subscribtions();?><br><br><br>

<h2>Add another Affiliate Item</h2><?display_item_form("");?><br><br><br>


<br>



  <form method="post" action="adminlogin.php">

  <input type="submit" name="Submit" value="Click here to return to Main Menu">

</form>

</center>

<?}

else echo "You are not logged in!";



?>