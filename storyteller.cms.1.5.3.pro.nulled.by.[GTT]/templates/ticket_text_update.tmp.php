<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

$insert[ticket_text]\n\n<b>Added by: $insert[ticket_user] on: $insert[ticket_date]</b>\n$insert[ticket_msg]

TEMPLATE;
?>