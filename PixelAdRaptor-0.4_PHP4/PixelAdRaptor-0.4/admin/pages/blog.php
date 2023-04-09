<?php
/**
 *
 * Administration's blog section handler
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
 
$api['template']->set('page', 'blog.tpl');

/**
 *
 * Entry creation section
 */
if ($form->wasSubmitted('submit')) {

    $form->addRequired(array('title' => 'Entry subject', 'text' => 'Entry text'));
    
    $form->addFilter('title', 'stringLengthFilter', array(0, 250), 'Entry subject cannot be longer than 250 characters.');

    $form->performValidation();
    
    if ($form->isOk()) {
    
        if (!get_magic_quotes_gpc()) {
        
            $_POST = array_map('addslashes', $_POST);
        
        }        

        $q = 'INSERT INTO blog (id, title, text, date) VALUES (null, "'.$_POST['title'].'", "'.$_POST['text'].'", "'.date('F j, Y, g:i a').'")';
        $api['database']->query($q);
        
        header('location: index.php?page=blog');
            
    
    } else {
    
        $api['template']->set('title', $_POST['title']);
        $api['template']->set('text', $_POST['text']);
    
        $api['template']->set('errors', $form->getHtmlErrors());
        $api['template']->set('error_js', $form->getJs());
            
    }

}

if (isset($_GET['act']) && isset($_GET['id']) && is_numeric($_GET['id'])) {

    if ($_GET['act'] == 'edit') {
    
    
        $api['template']->set('page', 'blog_edit.tpl');
        
        $q = 'SELECT id, title, text FROM blog WHERE id = "'.$_GET['id'].'"';
        $entry = $api['database']->getRow($api['database']->query($q));
        
        if (!get_magic_quotes_gpc()) {
        
            $entry = array_map('stripslashes', $entry); 
        
        }
        
        $api['template']->set('id', $entry['id']);        
        $api['template']->set('title', $entry['title']);        
        $api['template']->set('text', $entry['text']);       
        
        if ($form->wasSubmitted('submit_edit')) {
    
            $form->addRequired(array('title' => 'Entry subject', 'text' => 'Entry text'));
                    
            $form->addFilter('title', 'stringLengthFilter', array(0, 250), 'Entry subject cannot be longer than 250 characters.');
                    
            $form->performValidation();
            
            if ($form->isOk()) {
            
                if (!get_magic_quotes_gpc()) {
                
                    $_POST = array_map('addslashes', $_POST);
                
                }

                $q = 'UPDATE blog SET title = "'.$_POST['title'].'", text = "'.$_POST['text'].'" WHERE id = "'.$_POST['id'].'"';
                $api['database']->query($q);
                
                header('location: index.php?page=blog');
                                                    
            } else {
                           
                $api['template']->set('id', $_POST['id']);    
                $api['template']->set('title', $_POST['title']);
                $api['template']->set('text', $_POST['text']);
        
                $api['template']->set('errors', $form->getHtmlErrors());
                $api['template']->set('error_js', $form->getJs());
                                   
            }
            
        }
                    
    } elseif ($_GET['act'] == 'delete') {
    
        $q = 'DELETE FROM blog WHERE id = "'.$_GET['id'].'"';
        $api['database']->query($q);
        
        header('location: index.php?page=blog');
    
    }

} else {

    /**
     *
     * Blog entry list
     */
    $q = 'SELECT * FROM blog ORDER BY date DESC';
    $entries = $api['database']->getArray($api['database']->query($q));    

    if (!empty($entries)) {
    
        if (!get_magic_quotes_gpc()) {
    
            foreach ($entries as $key => $value) {
        
                $entries[$key] = array_map('stripslashes', $value);
        
            }
            
            foreach ($entries as $key => $value) {
            
                if (strlen($value['title']) > 20) {
                
                    $entries[$key]['title'] = substr($value['title'], 0, 20).'...';
                    
                }
            
            }
        
        }
        
        $api['template']->set('subpage', 'blog_list.tpl');
        $api['template']->set('entries', $entries); 
           
    }

}
