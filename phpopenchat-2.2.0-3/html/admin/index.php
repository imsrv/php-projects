<?//-*- C++ -*-
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

include "defaults_inc.php";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
  <title><?php echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<frameset cols="200,*" border="0" frameborder="0">
   <?php
      echo "<frame name=\"navigation\" src=\"$ADMIN_DIR/navigation.$FILE_EXTENSION\">";
      echo "<frame name=\"module\" src=\"$ADMIN_DIR/admin_channels.$FILE_EXTENSION\">";
   ?>

</frameset>

</html>