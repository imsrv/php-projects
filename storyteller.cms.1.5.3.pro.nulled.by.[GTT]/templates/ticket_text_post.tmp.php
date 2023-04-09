<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<b>Posted by: $insert[ticket_user] on: $insert[ticket_date]</b>\n$insert[ticket_msg]

TEMPLATE;
?>