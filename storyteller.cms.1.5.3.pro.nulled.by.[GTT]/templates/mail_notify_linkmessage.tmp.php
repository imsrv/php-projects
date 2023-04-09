<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE
Submitted by $insert[email_author]\n\n$insert[email_subject] - $insert[email_text]
TEMPLATE;
?>