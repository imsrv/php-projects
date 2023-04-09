<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template review_overview_list -->
<li><a href="review.php?id=$insert[review_id]&page=$insert[review_pageid]">$insert[review_pagesubject]</a><br />

TEMPLATE;
?>