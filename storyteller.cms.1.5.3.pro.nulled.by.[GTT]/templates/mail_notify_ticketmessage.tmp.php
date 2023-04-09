<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE
$insert[email_subject]\nby $insert[email_author] Priority: $insert[email_priority]\n\n$insert[email_message]
TEMPLATE;
?>