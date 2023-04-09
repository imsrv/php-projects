<?
/* nulled by [GTT] :) */ 
include("functions.php");
include ('header.php');
db_connect();
@session_start();
if(session_is_registered("admin"))
{
$path=db_result_to_array("select path, adminpath from admininfo");
$path=$path[0][0].$path[0][1]."storage/";

        //preedit
        if (!empty($edit))
        {
                $goedit = $edit;
        }
?>
<?
        //cancel edit
        if (!empty($cancel))
        {
                unset($goedit);
        }
?>
<?
        //edit
        if (!empty($editid)&& $edit)
        {
                $query_amember_products = "update programs set title = '$title',  description ='$description', price='$price' where id = $editid";
                if ($file)
                {
                                if ($_FILES['file']['size'] >0  && move_uploaded_file($_FILES['file']['tmp_name'], "$path".$_FILES['file']['name']))
                {
            echo "Uploaded successfully!";
                        mysql_query("update programs set filename='".$_FILES['file']['name']."' where id = $editid");
                } else
                {
                        echo "An error occured while uploading file";
                }
                }

                mysql_query($query_amember_products) or die(mysql_error());
                unset($goedit);

        }
?>
<?
        //delete
        if (!empty($delid))
        {
                $query_amember_products = "delete FROM programs where id = $delid";
                mysql_query($query_amember_products) or die(mysql_error());
        }
?>
<?
        //insert
        if (!empty($add)&& $add)
        {

                $query_amember_products = "insert into programs (title, description, filename, price) values ('$title', '$description', '".$_FILES['file']['name']."', '$price')";
                if ($_FILES['file']['size'] >0  && move_uploaded_file($_FILES['file']['tmp_name'], "$path".$_FILES['file']['name']))
                {
                        mysql_query($query_amember_products) or die(mysql_error());
                } else
                {
                        echo "An error occured while uploading file";
                }
                unset($goedit);
        }
?>
<?php
$query_amember_products = "SELECT * FROM programs";
$amember_products = mysql_query($query_amember_products) or die(mysql_error());
$row_amember_products = mysql_fetch_assoc($amember_products);
$totalRows_amember_products = mysql_num_rows($amember_products);

?>

<html>
<head>
<title>Manage soft</title>
<meta http-equiv="Content-Type" content="text/html;">
<style type="text/css">
<!--
.ver {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: x-small;
}
.btn {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: xx-small;
}
-->
</style>
</head>

<body>
<center>
<?admin_menu();
if (!$editid)
{
display_programs();
echo "<br><h2>Add another programm:</h2><br>";
display_product_form("");
}
else
{
 echo "<br><h2>Edit programm $editid:</h2><br>";
  display_product_form($editid);
  echo "<div align=left><a href=\"upload.php\" >Back</a></div>";
}
?>



<br> <form method="post" action="adminlogin.php"> <input type="submit" name="Submit" value="Click here to return to Main Menu">
</form>
</CENTER>


</body>
</html>
<?php
mysql_free_result($amember_products);

}
else
echo "Access denied";
?>
