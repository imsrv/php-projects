<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template search_list_reviews -->
<li><a href="review.php?id=$insert[review_id]">$insert[review_title]</a><br />

TEMPLATE;
?>