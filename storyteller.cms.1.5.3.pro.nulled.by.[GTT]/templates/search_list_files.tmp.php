<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template search_list_files -->
<li><a href="download.php?det=$insert[download_id]">$insert[download_title]</a> ($insert[download_time])<br />

TEMPLATE;
?>