<?php
/**
 *
 * ontacts page handler
 *
 * @author Karolis Tamutis karolis.t@NO_SPAM_TO_THIS_EMAIL.gmail.com
 * @date 2005-09-18
 * @file contacts.php
 *
 * Copyright (C) 2005  Karolis Tamutis
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA. 
 */
 
if (!defined('MAIN')) {

    die('No direct access.');

}

/**
 * 
 * Set the title of the page
 */
$api['template']->set('w_subtitle', 'Contacts');
 
$api['template']->set('page', 'templates/pages/contacts.tpl');

require_once('core/form-validator.php');

$form = & new FormValidator('POST');

$form->setFilterPath('core/form-filters/');
$form->setRequiredMsg('This field is required');

$form->addRequired(array('name' => 'Name', 'email' => 'Email', 'subject' => 'Subject', 'message' => 'Message'));

$form->addFilter('name', 'stringLengthFilter', array(0, 50), 'Name is too long. Maximum 50 characters.');
$form->addFilter('email', 'stringLengthFilter', array(0, 250), 'Email is too long. Maximum 250 characters.');
$form->addFilter('subject', 'stringLengthFilter', array(0, 250), 'Subject line is too long, maximum 250 characters.');

$form->addFilter('email', 'emailFilter', null, 'This is not a valid email address.');


if ($form->wasSubmitted('submit')) {
    
    $form->performValidation();

    if ($form->isOk()) {
    
        if (!get_magic_quotes_gpc()) {
        
            $_POST = array_map('addslashes', $_POST);
        
        }
    
        $q = 'INSERT INTO contacts (id, name, email, subject, message, date) 
              VALUES (null, "'.$_POST['name'].'", "'.$_POST['email'].'", "'.$_POST['subject'].'", "'.$_POST['message'].'", NOW())';
    
        $api['database']->query($q);
        
        header('location: Success');

    
    } else {

        $api['template']->set('name', $_POST['name']);
        $api['template']->set('email', $_POST['email']);
        $api['template']->set('subject', $_POST['subject']);
        $api['template']->set('message', $_POST['message']);

        $api['template']->set('errors', $form->getHtmlErrors());
        $api['template']->set('error_js', $form->getJs()); 
       
    }
    
}
 
?>