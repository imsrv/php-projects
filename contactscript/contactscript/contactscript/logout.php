<?php

session_start();

// if the user is logged in, unset the session
if (isset($_SESSION['basic_is_logged_in'])) {
   unset($_SESSION['basic_is_logged_in']);
}

// now that the user is logged out,
// go to login page
header('Location: index.php');
?><!--//
*********************************************************************************   
*********************************************************************************   
**  a script that you enter your myspace url and ms user idit creates a code   **
**          so that users can place a contact box on there website             **
**      Copyright (C) 2005  <Mark Beard markbeardwebdesign@gmail.com>          **
**                                                                             **
**     This program is free software; you can redistribute it and/or modify    **  
**     it under the terms of the GNU General Public License as published by    **  
**       the Free Software Foundation; either version 2 of the License, or     **  
**                     (at your option) any later version.                     **  
**                                                                             **  
**         This program is distributed in the hope that it will be useful,     **  
**         but WITHOUT ANY WARRANTY; without even the implied warranty of      **  
**          MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      **  
**              GNU General Public License for more details.                   **  
**                                                                             **  
**        You should have received a copy of the GNU General Public License    **  
**        along with this program; if not, write to the Free Software          **  
**  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA  **   
*********************************************************************************
********************************************************************************* //-->