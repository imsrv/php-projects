<?php
/**
 *
 * Administration's settings section handler
 *
 * @date 2005-10-14
 * @file settings.php
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
 
$api['template']->set('page', 'settings.tpl');

/**
 *
 * Settings section
 */
$q = 'SELECT value FROM config WHERE variable = "title" OR variable = "description" OR variable = "slogan" OR variable = "price" OR variable = "business_email" OR variable = "site_url"';
$settings = $api['database']->getArray($api['database']->query($q));

if (!get_magic_quotes_gpc()) {
        
    foreach ($settings as $key => $value) {
    
        $settings[$key] = array_map('stripslashes', $value);
        
    }
        
}

$api['template']->set('w_title', $settings[0]['value']);
$api['template']->set('w_description', $settings[1]['value']);
$api['template']->set('w_slogan', $settings[2]['value']);
$api['template']->set('w_price', $settings[3]['value']);
$api['template']->set('w_business', $settings[4]['value']);
$api['template']->set('w_siteurl', $settings[5]['value']);

if ($form->wasSubmitted('submit_settings')) {
    
    $form->addRequired(array('w_title' => 'Website title', 'w_slogan' => 'Slogan', 'w_business' => 'Business email', 'w_siteurl' => 'Site URL'));
     
    $form->addFilter('w_siteurl', 'urlFilter', null, 'Site URL must be a valid URL.');
    $form->addFilter('w_price', 'numericFilter', null, 'Pixel price must be a numeric value');
     
    $form->performValidation();
        
    if ($form->isOk()) {
    
        if (!get_magic_quotes_gpc()) {
        
            $_POST = array_map('addslashes', $_POST);
        
        }
                
        $q = 'UPDATE config SET value = "'.$_POST['w_title'].'" WHERE variable = "title"';
        $api['database']->query($q);
        
        $q = 'UPDATE config SET value = "'.$_POST['w_description'].'" WHERE variable = "description"';
        $api['database']->query($q);
        
        $q = 'UPDATE config SET value = "'.$_POST['w_slogan'].'" WHERE variable = "slogan"';
        $api['database']->query($q);
        
        $q = 'UPDATE config SET value = "'.$_POST['w_price'].'" WHERE variable = "price"';
        $api['database']->query($q);
         
        $q = 'UPDATE config SET value = "'.$_POST['w_business'].'" WHERE variable = "business_email"';
        $api['database']->query($q); 
                
        $q = 'UPDATE config SET value = "'.$_POST['w_siteurl'].'" WHERE variable = "site_url"';
        $api['database']->query($q);                         
          
        header('location: index.php?page=settings');
    
    } else {
    
        $api['template']->set('w_title', $_POST['w_title']);
        $api['template']->set('w_siteurl', $_POST['w_siteurl']);
        $api['template']->set('w_description', $_POST['w_description']);        
        $api['template']->set('w_slogan', $_POST['w_slogan']);
        $api['template']->set('w_price', $_POST['w_price']);
        $api['template']->set('w_business', $_POST['w_business']);                        
    
        $api['template']->set('errors', $form->getHtmlErrors());
        $api['template']->set('error_js', $form->getJs());
         
    }
    
}

/**
 *
 * Navigation links addition section
 */
if ($form->wasSubmitted('submit_nav')) {

    $form->addRequired(array('url' => 'Link URL', 'title' => 'Link title'));
    
    $form->addFilter('title', 'stringLengthFilter', array(0, 250), 'Link title cannot be longer than 250 characters.');
    $form->addFilter('url', 'stringLengthFilter', array(0, 250), 'Link URL cannot be longer than 250 characters.');
             
    $form->performValidation();
        
    if ($form->isOk()) {
    
        if (!get_magic_quotes_gpc()) {
        
            $_POST = array_map('addslashes', $_POST);
        
        }
        
        $_POST['url'] = str_replace(' ', '_', $_POST['url']);
        
        $q = 'INSERT INTO navigation (id, url, title, weight, active) VALUES (null, "'.$_POST['url'].'", "'.$_POST['title'].'", "'.$_POST['weight'].'", 1)';
        $api['database']->query($q);
        
        header('location: index.php?page=settings');        
            
    } else {
    
        $api['template']->set('url', $_POST['url']);
        $api['template']->set('title', $_POST['title']);        
    
        $api['template']->set('errors2', $form->getHtmlErrors());
        $api['template']->set('error_js2', $form->getJs());
            
    }
    
}

if (isset($_GET['act']) && isset($_GET['id']) && is_numeric($_GET['id'])) {

    if ($_GET['act'] == 'edit') {
    
        $api['template']->set('page', 'settings_edit.tpl');
        
        $q = 'SELECT id, url, title FROM navigation WHERE id = "'.$_GET['id'].'"';
        $link = $api['database']->getRow($api['database']->query($q));
        
        if (!get_magic_quotes_gpc()) {
        
            $link = array_map('stripslashes', $link); 
        
        }
        
        $api['template']->set('id', $link['id']);
        $api['template']->set('url', $link['url']);
        $api['template']->set('title', $link['title']);
        
        if ($form->wasSubmitted('submit_edit')) {
        
            $form->addRequired(array('url' => 'Link URL', 'title' => 'Link title'));
            
            $form->addFilter('title', 'stringLengthFilter', array(0, 250), 'Link title cannot be longer than 250 characters.');
            $form->addFilter('url', 'stringLengthFilter', array(0, 250), 'Link URL cannot be longer than 250 characters.');            
            $form->performValidation();
            
            if ($form->isOk()) {
            
                if (!get_magic_quotes_gpc()) {
                
                    $_POST = array_map('addslashes', $_POST);
                
                }
                
                $_POST['url'] = str_replace(' ', '_', $_POST['url']);
                
                $q = 'UPDATE navigation SET url = "'.$_POST['url'].'", title = "'.$_POST['title'].'" WHERE id = "'.$_POST['id'].'"';
                $api['database']->query($q);
                
                header('location: index.php?page=settings');
            
            } else {
            
                $api['template']->set('url', $_POST['url']);
                $api['template']->set('title', $_POST['title']);        
        
                $api['template']->set('errors', $form->getHtmlErrors());
                $api['template']->set('error_js', $form->getJs());                
            
            }
        
        }
        
    } elseif ($_GET['act'] == 'delete') {
    
        $q = 'DELETE FROM navigation WHERE id = "'.$_GET['id'].'"';
        $api['database']->query($q);
        
        header('location: index.php?page=settings');
    
    } elseif ($_GET['act'] == 'toogle') {
    
        $q = 'SELECT active FROM navigation WHERE id = "'.$_GET['id'].'"';
        $link = $api['database']->getRow($api['database']->query($q));
        
        if ($link['active'] == 0) {
        
            $q = 'UPDATE navigation SET active = 1 WHERE id = "'.$_GET['id'].'"';
        
        } else {
        
            $q = 'UPDATE navigation SET active = 0 WHERE id = "'.$_GET['id'].'"';
        
        }
        
        $api['database']->query($q);
        
        header('location: index.php?page=settings');
    
    }

} else {
    
    /**
     *
     * Sort navigation links section
     */
    $q = 'SELECT * FROM navigation ORDER BY weight DESC';
    $links = $api['database']->getArray($api['database']->query($q));

    if (!empty($links)) {

        if (!get_magic_quotes_gpc()) {
    
            foreach ($links as $key => $value) {
        
                $links[$key] = array_map('stripslashes', $value);
        
            }
    
        }
    
        foreach ($links as $key => $value) {
    
            $links[$key]['activation'] = ($value['active'] == 0)?'Activate':'Deactivate';
            $links[$key]['color'] = ($value['active'] == 0)?'#efefef':'#ffffff'; 
    
        }
    
        $api['template']->set('subpage', 'settings_sort.tpl');
        $api['template']->set('links', $links);

    }
    
    /**
     *
     * Parse weight sorting form
     */
    if ($form->wasSubmitted('submit_sort')) {
         
        $form->performValidation();
        
        if ($form->isOk()) {
    
            $i = 0;
    
            foreach ($links as $value) {
                
                $q = 'UPDATE navigation SET weight = "'.$_POST['weight'][$i].'" WHERE id = "'.$value['id'].'"';
                $api['database']->query($q);
                $i++;
            }
            
            header('location: index.php?page=settings');
        
        } else {
    
            $api['template']->set('errors2', $form->getHtmlErrors());
            $api['template']->set('error_js2', $form->getJs());          
    
        }
    
    }    

}
?>