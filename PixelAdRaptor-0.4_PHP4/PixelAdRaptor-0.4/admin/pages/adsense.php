<?php
/**
 *
 * Administration's Adsense section
 *
 * @date 2005-10-15
 * @file adsense.php
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
 
$api['template']->set('page', 'adsense.tpl');

/**
 *
 * Fix the select box
 */
$q = 'SELECT value FROM config WHERE variable = "adsense_enabled"';
$enabled = $api['database']->getRow($api['database']->query($q));

$api['template']->set('selected_'.$enabled['value'], ' selected="selected"');

if ($form->wasSubmitted('submit')) {
    
    $form->addRequired(array('adsense_code' => 'Adsense code'));
     
    $form->performValidation();
        
    if ($form->isOk()) {
        
        if (!get_magic_quotes_gpc()) {
        
            $_POST = array_map('addslashes', $_POST);
        
        }
        
        $q = 'UPDATE config SET value = "'.$_POST['adsense_code'].'" WHERE variable = "adsense"';
        $api['database']->query($q);
        $q = 'UPDATE config SET value = "'.$_POST['enabled'].'" WHERE variable = "adsense_enabled"';
        $api['database']->query($q);      
          
        header('location: index.php?page=adsense');
        
    } else {
        
        $api['template']->set('errors', $form->getHtmlErrors());
        $api['template']->set('error_js', $form->getJs());             
        
    }
    
} else {

    /**
     *
     * Get adsense code from database
     */
    $q = 'SELECT value FROM config WHERE variable = "adsense"';
    $ads = $api['database']->getRow($api['database']->query($q));
    
    if (!get_magic_quotes_gpc()) {
    
        $ads['value'] = stripslashes($ads['value']);
    
    }
    
    $api['template']->set('adsense_code', $ads['value']);

}

?>