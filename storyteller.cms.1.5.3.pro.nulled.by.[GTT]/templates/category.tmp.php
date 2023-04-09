<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template category -->
<li><a href="category.php?id=$insert[category_id]">$insert[category_name]</a> ($insert[category_news] news)<br />

TEMPLATE;
?>