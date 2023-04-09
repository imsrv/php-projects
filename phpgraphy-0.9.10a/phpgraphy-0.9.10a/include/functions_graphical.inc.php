<?php

/*
*  Copyright (C) 2002-2005 JiM / aEGIS (jim@aegis-corp.org)
*
*  This program is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2, or (at your option)
*  any later version.
*
*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with this program; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
*
* $Id: functions_graphical.inc.php 135 2005-07-19 22:03:16Z jim $
*
*/


/**
* Rotate image function - rotate_image()
*
* This function take two arguments, a picture name and a rotation
* angle. Besides this it uses a global variable which specifies
* which method to call to handle the rotation. It is just a
* standard API to be called.
*
* @param: string $picname
* @param: int $rotate (1 for 90deg, 2 for 180 deg, 3 for 270)
* @return true|false
*/

function rotate_image($picname, $rotation_value)
{

    global $rotate_tool, $rotate_tool_path, $rotate_tool_args;

    $picname_tmp = $picname.".tmp";

    if (! is_file($picname)) {
        trigger_error("Can not open file $picname, please check that the file exists and is readable", E_USER_WARNING);
        return false;
    }

    if (! is_writable(dirname($picname))) {
        trigger_error("Can not write in ".dirname($picname).", aborting", E_USER_WARNING);
        return false;
    }

    if (! is_writable($picname)) {
        trigger_error("Not enough permissions on ".$picname.", aborting", E_USER_WARNING);
        return false;
    }

    if ($rotation_value < 1 || $rotation_value > 3) {
        trigger_error("Incorrect rotation_value, please select a number between 1 and 3", E_USER_WARNING);
        return false;
    }


    // All prior checks have been passed, now preparing the command line (tool dependent)

    switch($rotate_tool) 
    {
        case "exiftran":
            // Translate phpgraphy rotation code to the matching exiftran argument
            if ($rotation_value == 1) $rotation_arg = "-9";
            elseif ($rotation_value == 2) $rotation_arg = "-1";
            elseif ($rotation_value == 3) $rotation_arg = "-2";

            // Set defaults if not specified
            if (!$rotate_tool_path) $rotate_tool_path = "exiftran";
            if (!$rotate_tool_args) $rotate_tool_args = "-p";

            $cmd=$rotate_tool_path." ".$rotation_arg." -i ".$rotate_tool_args." ".escapeshellarg($picname)." -o ".escapeshellarg($picname_tmp);

            break;

        case "jpegtran":
            // Translate phpgraphy rotation code to the matching jpegtran argument
            if ($rotation_value == 1) $rotation_arg = "-rotate 90";
            elseif ($rotation_value == 2) $rotation_arg = "-rotate 180";
            elseif ($rotation_value == 3) $rotation_arg = "-rotate 270";

            // Set defaults if not specified
            if (!$rotate_tool_path) $rotate_tool_path = "jpegtran";
            if (!$rotate_tool_args) $rotate_tool_args = "-copy all";

            $cmd=$rotate_tool_path." ".$rotation_arg." ".$rotate_tool_args." ".escapeshellarg($picname)." > ".escapeshellarg($picname_tmp);

            break;

    }

    // Common part for both exiftran and jpegtran

    trigger_error("DEBUG: Rotating image by running: ".$cmd, E_USER_NOTICE);
    @exec($cmd);

    if (! is_file($picname_tmp)) {
        trigger_error("Failed to rotate picture ".$picname, E_USER_WARNING);
        return false;
    }

    if (! rename($picname_tmp, $picname)) {
        trigger_error("Failed to copy rotated file ".$picname_tmp, E_USER_WARNING);
        return false;
        }

    // If here, everything should has normally been fine
    return true;

}

?>
