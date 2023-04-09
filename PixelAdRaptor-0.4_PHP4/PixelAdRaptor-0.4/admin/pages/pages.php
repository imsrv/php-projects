2<?php
/**
 *
 * Administration's static pages section handler
 *
 * @date 2005-10-14
 * @file pages.php
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
 
$api['template']->set('page', 'pages.tpl');

/**
 *
 * Page creation section
 */
if ($form->wasSubmitted('submit')) {

    $form->addRequired(array('title' => 'Page title', 'url' => 'Page URL string', 'content' => 'Page content'));
    
    $form->addFilter('title', 'stringLengthFilter', array(0, 250), 'Page title cannot be longer than 250 characters.');
    $form->addFilter('url', 'stringLengthFilter', array(0, 250), 'Page URL cannot be longer than 250 characters.');

    $form->performValidation();
    
    if ($form->isOk()) {
    
        if (!get_magic_quotes_gpc()) {
        
            $_POST = array_map('addslashes', $_POST);
        
        }
                
        $_POST['url'] = str_replace(' ', '_', $_POST['url']);

        $q = 'SELECT id FROM static WHERE url = "'.$_POST['url'].'"';
        
        if ($api['database']->countRows($api['database']->query($q)) != 0) {
        
            $form->addError('There is a page with such URL already, try something else for an URL');
            
            $api['template']->set('title', $_POST['title']);
            $api['template']->set('url', $_POST['url']);        
            $api['template']->set('content', $_POST['content']);
    
            $api['template']->set('errors', $form->getHtmlErrors());
            $api['template']->set('error_js', $form->getJs());            
        
        } else {
    
            $q = 'INSERT INTO static (id, title, url, content, date, active) VALUES (null, "'.$_POST['title'].'", "'.$_POST['url'].'", "'.$_POST['content'].'", "'.date('Y-m-d H:i:s').'", 1)';
            $api['database']->query($q);
        
            header('location: index.php?page=pages');
            
        }
    
    } else {
    
        $api['template']->set('title', $_POST['title']);
        $api['template']->set('url', $_POST['url']);        
        $api['template']->set('content', $_POST['content']);
    
        $api['template']->set('errors', $form->getHtmlErrors());
        $api['template']->set('error_js', $form->getJs());
            
    }

}

if (isset($_GET['act']) && isset($_GET['id']) && is_numeric($_GET['id'])) {

    if ($_GET['act'] == 'edit') {
    
    
        $api['template']->set('page', 'pages_edit.tpl');
        
        $q = 'SELECT id, url, title, content FROM static WHERE id = "'.$_GET['id'].'"';
        $page = $api['database']->getRow($api['database']->query($q));
        
        if (!get_magic_quotes_gpc()) {
        
            $page = array_map('stripslashes', $page); 
        
        }
        
        $api['template']->set('id', $page['id']);        
        $api['template']->set('title', $page['title']);        
        $api['template']->set('url', $page['url']);
        $api['template']->set('content', $page['content']);       
        
        if ($form->wasSubmitted('submit_edit')) {
        
            $form->addRequired(array('url' => 'Link URL', 'title' => 'Link title', 'content' => 'Content'));
            
            $form->addFilter('title', 'stringLengthFilter', array(0, 250), 'Page title cannot be longer than 250 characters.');
            $form->addFilter('url', 'stringLengthFilter', array(0, 250), 'Page URL cannot be longer than 250 characters.');            
            $form->performValidation();
            
            if ($form->isOk()) {
            
                if (!get_magic_quotes_gpc()) {
                
                    $_POST = array_map('addslashes', $_POST);
                
                }
                
                $_POST['url'] = str_replace(' ', '_', $_POST['url']);

                $q = 'UPDATE static SET url = "'.$_POST['url'].'", title = "'.$_POST['title'].'", content = "'.$_POST['content'].'" WHERE id = "'.$_POST['id'].'"';
                $api['database']->query($q);
                
                header('location: index.php?page=pages');
                                                    
            } else {
                           
                $api['template']->set('id', $_POST['id']);    
                $api['template']->set('title', $_POST['title']);
                $api['template']->set('url', $_POST['url']);        
                $api['template']->set('content', $_POST['content']);
        
                $api['template']->set('errors', $form->getHtmlErrors());
                $api['template']->set('error_js', $form->getJs());
                                   
            }
            
        }
                    
    } elseif ($_GET['act'] == 'delete') {
    
        $q = 'DELETE FROM static WHERE id = "'.$_GET['id'].'"';
        $api['database']->query($q);
        
        header('location: index.php?page=pages');
    
    } elseif ($_GET['act'] == 'toogle') {
    
        $q = 'SELECT active FROM static WHERE id = "'.$_GET['id'].'"';
        $link = $api['database']->getRow($api['database']->query($q));
        
        if ($link['active'] == 0) {
        
            $q = 'UPDATE static SET active = 1 WHERE id = "'.$_GET['id'].'"';
        
        } else {
        
            $q = 'UPDATE static SET active = 0 WHERE id = "'.$_GET['id'].'"';
        
        }
        
        $api['database']->query($q);
        
        header('location: index.php?page=pages');        
    
    }

} else {

    /**
     *
     * Page list
     */
    $q = 'SELECT * FROM static ORDER BY date DESC';
    $pages = $api['database']->getArray($api['database']->query($q));    

    if (!empty($pages)) {
    
        if (!get_magic_quotes_gpc()) {
    
            foreach ($pages as $key => $value) {
        
                $pages[$key] = array_map('stripslashes', $value);
        
            }
        
        }
        
        foreach ($pages as $key => $value) {
        
            $pages[$key]['activation'] = ($value['active'] == 0)?'Activate':'Deactivate';
            $pages[$key]['color'] = ($value['active'] == 0)?'#efefef':'#ffffff';             
        
        }
        
        $api['template']->set('subpage', 'pages_list.tpl');
        $api['template']->set('pages', $pages); 
           
    }

}
?>