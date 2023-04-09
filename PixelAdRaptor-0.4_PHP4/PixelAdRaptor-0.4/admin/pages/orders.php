<?php
/**
 *
 * Administration's orders section handler
 *
 * @date 2005-10-15
 * @file orders.php
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
 
/**
 *
 * Get pending ads
 */
$q = 'SELECT * FROM ads WHERE active = 0 ORDER BY size DESC';
$ads = $api['database']->getArray($api['database']->query($q));

if (!empty($ads)) {

    if (!get_magic_quotes_gpc()) {
    
        foreach ($ads as $key => $value) {
        
            $ads[$key] = array_map('stripslashes', $value);
        
        }
    
    }
    
    $api['template']->set('page', 'orders.tpl');
    
    $api['template']->set('ads', $ads);

}

if (isset($_GET['act']) && $_GET['act'] == 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])) {

    $q = 'SELECT file FROM ads WHERE id = "'.$_GET['id'].'"';
    $file = $api['database']->getRow($api['database']->query($q));
    
    unlink('../images/'.$file['file']);
    
    $q = 'DELETE FROM ads WHERE id = "'.$_GET['id'].'"';
    $api['database']->query($q);
    
    header('location: index.php?page=orders');

}

if (isset($_GET['act']) && $_GET['act'] == 'approve' && isset($_GET['id']) && is_numeric($_GET['id'])) {

    $q = 'UPDATE ads SET active = 1 WHERE id = "'.$_GET['id'].'"';
    $api['database']->query($q);
    
    header('location: index.php?page=orders');

}

?>