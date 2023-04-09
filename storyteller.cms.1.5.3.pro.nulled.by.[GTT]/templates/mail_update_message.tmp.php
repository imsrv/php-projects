<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

Hello $insert[user_name],\n\nYour account is now in the update queue.\n\nTo confirm your profile update, click on the link below:\n$insert[activate_url]\n\nThanks

TEMPLATE;
?>