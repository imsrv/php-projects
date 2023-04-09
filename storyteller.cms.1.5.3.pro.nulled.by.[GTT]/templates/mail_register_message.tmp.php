<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

Welcome to $insert[site_name] !\n\nYour account ($insert[user_name]) is now in the registration queue. You need to activate the account within the next hour or you will need to register again.\n\nTo activate the account click on this link:\n$insert[activate_url]\n\nIf you did not request this account, someone else with the IP address: $insert[ipaddr] entered your email address ($insert[email]), probably by mistake. In this case, just ignore this email because this registration will be removed during the next hour.\n\nThanks,\n$insert[site_name]

TEMPLATE;
?>