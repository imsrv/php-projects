<?
/*************************************************************
 Cedric email reader Webmail :
 - Ce programme est un webmail : il permet de consulter et de gérer une boîte aux lettre électronique en utilisant un navigateur web.
 - This program is a Web Mail : it's an application permitting access and manage an electronic mailbox using a Web browser.

Realisation : Cedric AUGUSTIN <cedric@isoca.com>
Web : www.isoca.com
Version : 0.4
Date : Septembre 2001

Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes de la Licence Publique Générale GNU publiée par la Free Software Foundation version 2 ou bien toute autre version ultérieure choisie par vous. Lorsque vous le copier ou le distribuer, toutes les copies doivent conserver ce copyright et la liste explicite des modifications que vous avez apporté à ce programme.

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version. As you copy or distribute this program, all the copies have to carry this copyright and prominent notices stating that you changed the files and the date of any change.

************************************************************/



// Value only for login page
$cer_default_server = 'pop.isoca.com';
$cer_default_user = 'pop8658';
$cer_default_pass = 'ijs9vntn9';

// Default user profil
$cer_server_type = 'imap'; // possible value is imap, pop or news. Not yet implemented in version 0.4.
$cer_adressbook = 'common/adressbook.opt';
$cer_fromoption = 'common/fromoption.opt';
$cer_can_modify_addressbook = FALSE; // Use not yet implemented in version 0.4.
$cer_can_modify_fromoption = FALSE; // Use not yet implemented in version 0.4.
$cer_signature = 'This message is sended with isoca webmail (http://www.isoca.com)';

$cer_default_lang = 'fr';

$cer_debug = FALSE;
?>