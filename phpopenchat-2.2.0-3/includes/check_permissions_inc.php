<?//-*-C++-*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Michael Oertel                                 **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.0              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */


/**
* Check of permissions
*
* @param string $nick
* @param string $pruef
* @author Michael Oertel <Michael@ortelius.de>
* @global $salt_nick;
* @return bool
*/
function check_permissions($nick,$pruef){

  if(@session_is_registered('pruef')){
    return TRUE;
  }

  if(!$nick){
    return FALSE;
  }

  global $salt_nick;
  if(Crypt($nick,$salt_nick)!=$pruef){
    return FALSE; 
  }
  
  return TRUE;
}//end func check_permissions
?>
