<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template pages_list -->
<li><a href="page.php?id=$insert[page_id]">$insert[page_title]</a><br />

TEMPLATE;
?>