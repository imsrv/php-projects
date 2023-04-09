<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template comments_list -->
<li><a href="$insert[comment_url]">Re: $insert[comment_title]</a> by $insert[comment_author]<br />

TEMPLATE;
?>