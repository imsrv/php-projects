<?php
@mkdir("$configarray[20]/search",octdec(777));
@chmod("$configarray[20]/search",octdec(777));

$searchmoduleconfig=getdata("$configarray[20]/search/config.php");
if(!$searchmoduleconfig[0]){$searchmoduleconfig[0]=20;}
?>