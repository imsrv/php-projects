<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template review_list -->
<li><a href="review.php?id=$insert[review_id]">$insert[review_title]</a><br />

TEMPLATE;
?>