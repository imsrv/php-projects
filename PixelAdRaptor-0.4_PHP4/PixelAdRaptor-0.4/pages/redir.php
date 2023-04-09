<?php
/**
 *
 * Banner redirection and hit counter
 *
 * @date 2005-11-01
 * @file redir.php
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
 
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $q = 'SELECT link FROM ads WHERE id = "'.$_GET['id'].'" AND active = 1';
    
    $link = $api['database']->getRow($api['database']->query($q));

    $q = 'UPDATE ads SET hits = hits + 1 WHERE id = "'.$_GET['id'].'" AND active = 1';
    
    $api['database']->query($q);

    header('location: '.$link['link']);

} else {

    header('location: Grid');

}
?>