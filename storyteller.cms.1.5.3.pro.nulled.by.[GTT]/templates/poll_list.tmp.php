<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template poll_list -->
<li><a href="poll.php?id=$insert[poll_id]">$insert[poll_title]</a> ($insert[poll_votes] votes)<br />

TEMPLATE;
?>