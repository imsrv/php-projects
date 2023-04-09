<?php
@mkdir("$configarray[20]/members",octdec(777));
@chmod("$configarray[20]/members",octdec(777));

$membersmoduleconfig=getdata("$configarray[20]/members/config.php");
if(!$membersmoduleconfig[0]){$membersmoduleconfig[0]=20;}
?>