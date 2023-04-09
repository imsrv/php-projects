<?php
/**
 *
 * Administration's contacts section
 *
 * @date 2005-10-15
 * @file blog.php
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
 
$api['template']->set('page', 'contacts.tpl');

if (!isset($_GET['act'])) {

    $q = 'SELECT id, name, subject, wasread, wasreplied, date FROM contacts ORDER by date DESC';

    $contacts = $api['database']->getArray($api['database']->query($q));

    if (!empty($contacts)) {

        foreach ($contacts as $key => $value) {

            $contacts[$key]['wasread'] = ($value['wasread'] == 0)?'#ffffff':'#f1f1f1';
            $contacts[$key]['wasreplied'] = ($value['wasreplied'] == 0)?'No':'Yes';

        }

        $api['template']->set('contacts', $contacts);
    
        $api['template']->set('subpage', 'contacts_list.tpl');

    }

} else {

    if ($_GET['act'] == 'read' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    
        $q = 'UPDATE contacts SET wasread = 1 WHERE id = "'.$_GET['id'].'"';
        $api['database']->query($q);
    
        $q = 'SELECT * FROM contacts WHERE id = "'.$_GET['id'].'"';
        $message = $api['database']->getArray($api['database']->query($q));
        
        $api['template']->set('subpage', 'contacts_message.tpl');
        
        $api['template']->set('id', $message[0]['id']);        
        $api['template']->set('name', $message[0]['name']);
        $api['template']->set('email', $message[0]['email']);
        $api['template']->set('subject', $message[0]['subject']);
        $api['template']->set('message', $message[0]['message']);
        
        $email = $message[0]['email'];
        
        if (isset($_GET['reply']) && $_GET['reply'] == 'true') {
        
            $api['template']->set('reply', '');
            
            $message = wordwrap($message[0]['message'], 40, "\n");
            
            $message = explode("\n", $message);
            
            foreach ($message as $key => $value) {
            
                $message[$key] = '> '.$value;
            
            }
            
            $message = implode("\n", $message);
            
            $api['template']->set('reply_msg', $message);
            
            if ($form->wasSubmitted('submit')) {
                
                $form->addRequired(array('subject' => 'Subject', 'message' => 'Message'));
            
                $form->performValidation();
                
                if ($form->isOk()) {
                                    
                    $q = 'UPDATE contacts SET wasreplied = 1 WHERE id = "'.$_GET['id'].'"';
                    $api['database']->query($q);
                                    
                    $subject = $_POST['subject'];
                    $message = $_POST['message'];
                
                    mail($email, $subject, $message);
                    
                    header('location: index.php?page=contacts');
                
                } else {
                
                    $api['template']->set('errors', $form->getHtmlErrors());
                    $api['template']->set('error_js', $form->getJs());
                        
                }
            
            }
            
        
        } else {
        
            $api['template']->set('reply', 'display: none;');
        
        }
    
    } elseif ($_GET['act'] == 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    
        $q = 'DELETE FROM contacts WHERE id = "'.$_GET['id'].'"';
        $api['database']->query($q);
        
        header('location: index.php?page=contacts');
    
    }

}
?>