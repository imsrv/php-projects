<?php
/**
 *
 * Minimal administration.
 *
 * @author Karolis Tamutis karolis.t@NO_SPAM_TO_THIS_EMAIL.gmail.com
 * @date 2005-10-02
 * @file index.php
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
    
session_start();

define('MAIN', true);

/**
 *
 * Config and library inclusions
 */
require_once('../config.php');
require_once('../core/database.php');
require_once('../core/template.php');
require_once('../core/form-validator.php');
   
/**
 *
 * Object initializations
 */
$api['database'] = & new Database($config);
$api['template'] = & new Template();

$form = & new FormValidator('POST');

$form->setFilterPath('../core/form-filters/');
$form->setRequiredMsg('This field is required'); 

if (!isset($_SESSION['ADM'])) {
    
    if ($form->wasSubmitted('submit')) {
    
        $form->addRequired(array('login' => 'Username', 'password' => 'Password'));
    
        $form->addFilter('login', 'assertEqualFilter', $config['ADM_UNAME'], 'Wrong username.');
        $form->addFilter('password', 'assertEqualFilter', $config['ADM_PASS'], 'Wrong password.');
     
        $form->performValidation();
        
        if ($form->isOk()) {
        
            $_SESSION['ADM'] = true;
            header('location: index.php');
        
        } else {
        
            $api['template']->set('errors', $form->getHtmlErrors());
            $api['template']->set('error_js', $form->getJs());             
        
        }
    
    }
    
    $api['template']->show('templates/login.tpl', 'file');    

} else {

    if (!isset($_GET['page']) || $_GET['page'] == 'orders') {
  
        $api['template']->set('section_1', ' class="active"');
        require_once('pages/orders.php');
    
    } else {
    
        if ($_GET['page'] == 'ads') {
            
            $api['template']->set('section_2', ' class="active"');
            require_once('pages/ads.php');            
        
        } elseif ($_GET['page'] == 'blog') {
            
            $api['template']->set('section_3', ' class="active"');
            require_once('pages/blog.php');          
        
        } elseif ($_GET['page'] == 'faq') {
            
            $api['template']->set('section_4', ' class="active"');
            require_once('pages/faq.php');         
        
        } elseif ($_GET['page'] == 'pages') {
            
            $api['template']->set('section_5', ' class="active"');
            require_once('pages/pages.php');         
        
        } elseif ($_GET['page'] == 'adsense') {
            
            $api['template']->set('section_6', ' class="active"');
            require_once('pages/adsense.php');         
        
        } elseif ($_GET['page'] == 'contacts') {
            
            $api['template']->set('section_7', ' class="active"');
            require_once('pages/contacts.php');         
        
        } elseif ($_GET['page'] == 'settings') {
            
            $api['template']->set('section_8', ' class="active"');
            require_once('pages/settings.php');         
        
        }
    
    }
    
    $api['template']->show('templates/index.tpl', 'file');

}

?>