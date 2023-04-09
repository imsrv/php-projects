<?php

function template($data) {
$file = "./template.htm";
$opfile = fopen($file, "r");
$layout = fread($opfile, filesize($file));
fclose($opfile);
$layout = str_replace("<!--html -->", $data, $layout);
return $layout;
}

?>
