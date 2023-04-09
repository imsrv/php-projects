<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template download_list -->
<li><a href="download.php?id=$insert[download_category_id]">$insert[download_category_name]</a> ($insert[download_files] files)<br />

TEMPLATE;
?>