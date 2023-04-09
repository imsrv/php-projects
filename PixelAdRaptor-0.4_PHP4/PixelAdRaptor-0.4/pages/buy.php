<?php
/**
 *
 * Buy pixels page handler
 *
 * @date 2005-10-09
 * @file buy.php
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
$api['template']->set('w_subtitle', 'Buy');
 
$api['template']->set('page', 'templates/pages/buy.tpl');

if (isset($_POST['x']) && is_numeric($_POST['x']) && isset($_POST['y']) && is_numeric($_POST['y']) && $_POST['x'] <= 100 && $_POST['y'] <= 100) {

    $api['template']->set('x_1', $_POST['x']);
    $api['template']->set('y_1', $_POST['y']);
    
    $q = 'SELECT value FROM config WHERE variable = "price"';
    $price = $api['database']->getRow($api['database']->query($q));
    
    $api['template']->set('predefined_price', $price['value']);
    

    require_once('core/form-validator.php');
    
    $form = & new FormValidator('POST');
    
    $form->setFilterPath('core/form-filters/');
    $form->setRequiredMsg('This field is required');
    
    $form->addFilter('name', 'stringLengthFilter', array(0, 50), 'Name is too long. Maximum 50 characters.');
    $form->addFilter('email', 'emailFilter', null, 'This is not a valid email address.');
    $form->addFilter('x', 'numericFilter', null, 'X_1 must be a numeric value.'); 
    $form->addFilter('y', 'numericFilter', null, 'Y_1 must be a numeric value.');         
    $form->addFilter('width', 'numericFilter', null, 'Width must be a numeric value.'); 
    $form->addFilter('height', 'numericFilter', null, 'Height must be a numeric value.'); 
    $form->addFilter('link', 'urlFilter', null, 'Website link must be a valid URL address.'); 
    $form->addFilter('title', 'stringLengthFilter', array(0, 50), 'Message (link title) is too long. Maximum 50 characters.');
     
    $form->addRequired(array('name' => 'Name', 'email' => 'Email', 'width' => 'Width', 'height' => 'Height', 'link' => 'Website link', 'title' => 'Message (link title)', 'price' => 'Price (check if you have JS enabled.)'));
    
    $api['template']->set('price', 'Not calculated yet.');
    
    if ($form->wasSubmitted('submit_x')) {
    
        $form->performValidation();

        if ($form->isOk()) {
    
            if (!get_magic_quotes_gpc()) {
        
                $_POST = array_map('addslashes', $_POST);
        
            }
            
            if (!isset($_FILES['file']['name']) || empty($_FILES['file']['name'])) {
                
                $form->addError('Select a banner image to upload.');
            
                $api['template']->set('name', $_POST['name']);
                $api['template']->set('email', $_POST['email']);
                $api['template']->set('width', $_POST['width']);
                $api['template']->set('height', $_POST['height']);
                $api['template']->set('link', $_POST['link']);            
                $api['template']->set('title', $_POST['title']);
                $api['template']->set('price_', $_POST['price']);                     
                         
                $_POST['price'] = empty($_POST['price'])?'Not calculated yet.':'$'.$_POST['price'];
                         
                $api['template']->set('price', $_POST['price']); 
                $api['template']->set('errors', $form->getHtmlErrors());
                $api['template']->set('error_js', $form->getJs());
                            
            } elseif ($_FILES['file']['size'] > 1024 * 1024 * 2) {
            
                $form->addError('Image cannot be larger than 2 MB.');
            
            } else {
            
                $ext = strtolower(substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.') + 1));
                            
                $file = md5(time()).'.'.$ext;
            
                $size = getimagesize($_FILES['file']['tmp_name']);
                
                if (!in_array($ext, array('jpg', 'jpeg', 'gif', 'png', 'bmp'))) {
                    
                    $form->addError('Wrong file type. Only *.jpg, *jpeg, *.gif, *.png, *.bmp allowed.');
                
                    $api['template']->set('name', $_POST['name']);
                    $api['template']->set('email', $_POST['email']);
                    $api['template']->set('width', $_POST['width']);
                    $api['template']->set('height', $_POST['height']);
                    $api['template']->set('link', $_POST['link']);            
                    $api['template']->set('title', $_POST['title']);
                    $api['template']->set('price_', $_POST['price']);                                         
                          
                    $_POST['price'] = empty($_POST['price'])?'Not calculated yet.':'$'.$_POST['price'];
                   
                    $api['template']->set('price', $_POST['price']);                                   
                    $api['template']->set('errors', $form->getHtmlErrors());
                    $api['template']->set('error_js', $form->getJs());                
                
                
                } elseif (($size[0] / 10) != $_POST['width'] || ($size[1] / 10) != $_POST['height']) {
                
                    $form->addError('You need to scale your image to match the area you are about to purchase. Width to '.($_POST['width'] * 10).'px, height - '.($_POST['height'] * 10).'px');
                
                    $api['template']->set('name', $_POST['name']);
                    $api['template']->set('email', $_POST['email']);
                    $api['template']->set('width', $_POST['width']);
                    $api['template']->set('height', $_POST['height']);
                    $api['template']->set('link', $_POST['link']);            
                    $api['template']->set('title', $_POST['title']);                
                    $api['template']->set('price_', $_POST['price']);                                         
                         
                    $_POST['price'] = empty($_POST['price'])?'Not calculated yet.':'$'.$_POST['price'];
                    
                    $api['template']->set('price', $_POST['price']);   
                    $api['template']->set('errors', $form->getHtmlErrors());
                    $api['template']->set('error_js', $form->getJs());                    
                                    
                } else {
                
                    /**
                     * Check for overlapping banners
                     * Find coordinates of all 4 corners of an image.
                     * First - check if this new image fits our grid,
                     * then iterate all existing points to check for overlapping. 
                     * y - down, x - right
                     */
                     
                    /**
                     *
                     * Vertex coordinates of an image we are trying to add
                     */ 
                    $coord = array('y1' => $_POST['y'], 'x1' => $_POST['x'], 
                                   'y2' => ($_POST['height'] + $_POST['y'] - 1), 'x2' => $_POST['x'],
                                   'y3' => $_POST['y'], 'x3' => ($_POST['width'] + $_POST['x'] - 1));
                    
                    $q = 'SELECT FLOOR(x / 10) + 1 as x, FLOOR(y / 10) + 1 as y,  width, height FROM ads';
                    $ads = $api['database']->getArray($api['database']->query($q));
                    $fits = true;
                    
                    /**
                     * Resource hungry task, but after 2 hours of collaborative thinking,
                     * this was the best I'd come up with. No, there is no easier way, unless you
                     * have a PhD in Math Science.
                     */
                    if (!empty($ads)) {
                    
                        foreach ($ads as $ad) {
                    
                            /**
                            * Point is represented as ($i ; $i2)
                            */
                            for ($i = $ad['x']; $i < $ad['x'] + $ad['width']; $i++) {
            
                        
                                for ($i2 = $ad['y']; $i2 < $ad['y'] + $ad['height']; $i2++) {
                            
                                    if ((($i >= $coord['x1']) && ($i <= $coord['x3'])) && (($i2 >= $coord['y1']) && ($i2 <= $coord['y2']))) {
                                    
                                        /**
                                        * Overlap found!
                                        */
                                        $fits = false;
                                        break 3; 
                                    }
                                                               
                                }
                            
                            }
                            
                        }
                        
                    }
                                                        
                    if ($fits == false) {
                    
                        $form->addError('Your ad overlaps with other ads. First overlapping point found was ('.$i.' ; '.$i2.'). Adjust your settings according to it.');
                
                        $api['template']->set('name', $_POST['name']);
                        $api['template']->set('email', $_POST['email']);
                        $api['template']->set('width', $_POST['width']);
                        $api['template']->set('height', $_POST['height']);
                        $api['template']->set('link', $_POST['link']);            
                        $api['template']->set('title', $_POST['title']);
                        $api['template']->set('price_', $_POST['price']);                                                                 
                         
                        $_POST['price'] = empty($_POST['price'])?'Not calculated yet.':'$'.$_POST['price'];
                        
                        $api['template']->set('price', $_POST['price']);                                       
                        $api['template']->set('errors', $form->getHtmlErrors());
                        $api['template']->set('error_js', $form->getJs());
                                   
                    } else {
                    
                        /**
                         * Check if our banner fits in the grid
                         */
                        if ($coord['x3'] > 100 || $coord['y2'] > 100) {
                         
                            $form->addError('Your ad does not fit into ad grid. For this spot, maximum width can be '.(100 - $_POST['x']).' and height '.(100 - $_POST['y']).'. Keep that in mind or change your ad placement stop. P.S Ad overlappping also matters!');
                
                            $api['template']->set('name', $_POST['name']);
                            $api['template']->set('email', $_POST['email']);
                            $api['template']->set('width', $_POST['width']);
                            $api['template']->set('height', $_POST['height']);
                            $api['template']->set('link', $_POST['link']);            
                            $api['template']->set('title', $_POST['title']); 
                            $api['template']->set('price_', $_POST['price']);                                         
                         
                            $_POST['price'] = empty($_POST['price'])?'Not calculated yet.':'$'.$_POST['price'];
                            
                            $api['template']->set('price', $_POST['price']);                                          
                            $api['template']->set('errors', $form->getHtmlErrors());
                            $api['template']->set('error_js', $form->getJs());                             
                        
                        } elseif (!move_uploaded_file($_FILES['file']['tmp_name'], 'images/'.$file)) {
                
                            $form->addError('Sorry, but for some reason we were unable to upload your image to server. Try again later.');
                
                            $api['template']->set('name', $_POST['name']);
                            $api['template']->set('email', $_POST['email']);
                            $api['template']->set('width', $_POST['width']);
                            $api['template']->set('height', $_POST['height']);
                            $api['template']->set('link', $_POST['link']);            
                            $api['template']->set('title', $_POST['title']); 
                            $api['template']->set('price_', $_POST['price']);                                         
                         
                            $_POST['price'] = empty($_POST['price'])?'Not calculated yet.':'$'.$_POST['price'];
                            
                            $api['template']->set('price', $_POST['price']);                                          
                            $api['template']->set('errors', $form->getHtmlErrors());
                            $api['template']->set('error_js', $form->getJs());
                             
                        } else {
                                    
                            /** 
                             * Everything is ok
                             */
                            $q = 'INSERT INTO ads (id, x, y, width, height, name, email, title, link, size, file, date, price, hits, active) VALUES 
                            (null, "'.($_POST['x'] * 10).'", "'.($_POST['y'] * 10).'", "'.$_POST['width'].'", "'.$_POST['height'].'", "'.$_POST['name'].'", "'.$_POST['email'].'", "'.$_POST['title'].'", "'.$_POST['link'].'", "'.($_POST['width'] * $_POST['height'] * 10).'", "'.$file.'", "'.date('Y-m-d').'", "'.$_POST['price'].'", 0, 0)'; 
                
                            $api['database']->query($q); 
                                                   
                            $api['template']->set('page', 'templates/pages/pay.tpl');
                            
                            $config = $api['database']->getRow($api['database']->query('SELECT value FROM config WHERE variable = "business_email"'));
                            
                            $api['template']->set('business', $config['value']);
                            $api['template']->set('item', ($_POST['width'] * $_POST['height'] * 10).' Pixels (10x10 pixel block(s))');
                            $api['template']->set('amount', $_POST['price']);
                            
                            /**
                             *
                             * Submit the form
                             */
                            $api['template']->set('onload', 'return document.forms[0].submit();');
                        
                        }
                    
                    }
                                    
                }
            
            }
                
        } else {
            
            if (!isset($_FILES['file']['name'])) {
            
                $form->addError('Select a banner image to upload.');
            
            }
                    
            $api['template']->set('name', $_POST['name']);
            $api['template']->set('email', $_POST['email']);
            $api['template']->set('width', $_POST['width']);
            $api['template']->set('height', $_POST['height']);
            $api['template']->set('link', $_POST['link']);            
            $api['template']->set('title', $_POST['title']);
            $api['template']->set('price_', $_POST['price']);                                                     
                         
            $_POST['price'] = empty($_POST['price'])?'Not calculated yet.':'$'.$_POST['price'];
                            
            $api['template']->set('price', $_POST['price']); 
            $api['template']->set('errors', $form->getHtmlErrors());
            $api['template']->set('error_js', $form->getJs());            
        
        }
        
    }

} else {

    header('location: Grid');

}
     
?>