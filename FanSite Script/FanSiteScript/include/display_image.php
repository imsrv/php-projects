<?php

if($id) {

include ("../include/connect.txt");
	 //convert id from film number to image number
	 $imageresult = mysql_query("SELECT image FROM ds_movies WHERE seo_url = ('$id')",$db);
$imageid = mysql_result($imageresult,0,"image"); 
	 //end convert
	 
    @mysql_select_db("binary_data");


    $query = "select bin_data,filetype from ds_images where id=$imageid";
    $result = @MYSQL_QUERY($query);

    $data = @MYSQL_RESULT($result,0,"bin_data");
    $type = @MYSQL_RESULT($result,0,"filetype");
    Header( "Content-type: $type");
    echo $data;

};
?>

