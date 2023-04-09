<?php

/*
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
*  $Id: yorsh-variablevalidation-data.inc.php 196 2005-10-18 16:10:10Z jim $
*
*/

/**
* Yorsh Variable Validation (Data file)
*
* Yorsh Variable Validation class enables you to maintain
* a central list of variables with attached properties
* so that you can easily check if they're valid.
*
* Originally written for phpGraphy {@link http://phpgraphy.sourceforge.net}.
*
* @author JiM / aEGIS
* @version 0.1
* @copyright 2005 - jim [at] aegis [hyphen] corp [dot] org
*
*/

/**
* Array with all recognized/registered variables and associated properties
* Used by check_variable()
*
* @var var_name_ref
* @see $var_type_ref
*/

$var_name_ref=array(

// Sample of variables using basic types (bool, int, string)

// bool: value must be a single character (either 0 or 1), can not be empty (empty != zero)
    'bool' => array(
        'type' => 'bool',
        ),
// int: value must be integer number with a maximum length of 32 characters, can not be empty
    'int' => array(
        'type' => 'int',
        'empty' => '0',
        'maxlength' => '32'
        ),
// string: value can be anything with a maximum length of 255 characters, can not be empty
    'string' => array(
        'type' => 'string',
        'empty' => '0',
        'maxlength' => '255'
        ),

    /* COOKIE */ 

    'PHPSESSID' => array(
        'type' => 'alphanum',
        'empty' => 0,
        'maxlength' => 33
        ),
    'phpGraphyLoginValue' => array(
        type => 'int',
        'maxlength' => 150
        ),
    'phpGraphyVisitorName' => array(
        type => 'username',
        'maxlength' => 35
        ),

    /* GET/POST */ 

    'addcomment' => array(
        'type' => 'bool'
        ),
    'addingcomment' => array(
        'type' => 'bool'
        ),
    'comment' => array(
        'type' => 'multiline',
        'maxlength' => 1024
        ),
    'create' => array(
        'type' => 'bool'
        ),
    'createdirname' => array(
        'type' => 'path'
        ),
    'copyfromurl' => array(
        'type' => 'bool'
        ),
    'delcom' => array(
        'type' => 'int',
        'maxlenght' => 4
        ),
    'deldir' => array(
        'type' => 'bool'
        ),
    'dir' => array(
        'type' => 'path'
        ),
    'dircreate' => array(
        'type' => 'bool'
        ),
    'dirlevel' => array(
        'type' => 'int',
        'maxlength' => 4
        ),
    'dirlevelchange' => array(
        'type' => 'bool'
        ),
    'display' => array(
        'type' => 'path'
        ),
    'displaypic' => array(
        'type' => 'path'
        ),
    'dsc' => array(
        'type' => 'string',
        'maxlength' => 1024
        ),
    'editwelcome' => array(
        'type' => 'bool'
        ),
    'genall' => array(
        'type' => 'bool'
        ),
    'lastcommented' => array(
        'type' => 'path'
        ),
    'lev' => array(
        'type' => 'int',
        'maxlength' => 4
        ),
    'login' => array(
        'type' => 'bool'
        ),
    'logout' => array(
        'type' => 'bool'
        ),
    // Number of upload form fields
    'nb_ul_fields' => array(
        'type' => 'int',
        'maxlength' => 2
        ),
    'non_lr' => array(
        'type' => 'bool'
        ),
    'pass' => array(
        'type' => 'password',
        'empty' => 0,
        'maxlength' => 32
        ),
    'picupload' => array(
        'type' => 'bool'
        ),
    'picname' => array(
        'type' => 'path'
        ),
    'picuploadname' => array(
        'type' => 'filename',
        'empty' => 0,
        'maxlength' => 50
        ),
    'popup' => array(
        'type' => 'bool'
        ),
    'previewpic' => array(
        'type' => 'path'
        ),
    'random' => array(
        'type' => 'bool'
        ),
    'rating' => array(
        'type' => 'int',
        'maxlength' => 4
        ),
    'rememberme' => array(
        'type' => 'checkbox'
        ),
    'rotatepic' => array(
        'type' => 'int',
        'maxlength' => 1
        ),
    'startlogin' => array(
        'type' => 'bool'
        ),
    'startpic' => array(
        'type' => 'int',
        'maxlength' => 8
        ),
    'topratings' => array(
        'type' => 'bool'
        ),
    'updwelcome' => array(
        'type' => 'bool'
        ),
    'updpic' => array(
        'type' => 'updpic',
        'empty' => 0
        ),
    'upload' => array(
        'type' => 'bool'
        ),
    'user' => array(
        'type' => 'username',
        'empty' => 0,
        'maxlength' => 20
        ),
    'userurl' => array(
        'type' => 'url',
        'empty' => 0,
        'maxlength' => 512
        ),
    'welcomedata' => array(
        'type' => 'multiline',
        'empty' => 1,
        'maxlength' => 4096
        ),
    // User Management
    'um'=>array(
        'type'=>'bool',
        'empty'=>0
        ),
    'action'=>array(
        'type'=>'alpha',
        'empty'=>0,
        'maxlength' => 7
        ),
    'uid'=>array(
        'type'=>'int',
        'empty'=>0
        ),

    // Test purpose only
    'test' => array(
        'type' => 'text_wo_html',
        'empty' => '0',
        )
    );


/**
* Array with all recognized/registered type and associated properties
* supported properties
* pregex: perl regular expression pattern
* function: user function's name (must return true if test passed (take $value as only argument))
*
* Used by check_variable()
*
* @var var_type_ref
* @see var_name_ref
*/

$var_type_ref=array(

    /* Basic types */

    'bool' => array(
        'pregex' => '/^(0|1)$/'
        ),
    'int' => array(
        'function' => 'is_numeric'
        ),
    'string' => array(
        'pregex' => '/^.+$/' // Match everything (but doesn't accept CR/LR and such must be used with caution)
        ),
    'alpha' => array(
        'pregex' => '/^[a-z]+$/i'
        ),
    'alphanum' => array(
        'pregex' => '/^[a-z0-9]+$/i'
        ),
    'word' => array(
        'pregex' => '/^\w+$/' // PCRE word (include the '_')
        ),
    'multiline' => array(
        'pregex' => '/^.+$/m' // Match everything (but doesn't accept CR/LR and such must be used with caution)
        ),

    /* Custom types */

    'checkbox' => array(
        'pregex' => '/^(on)?$/'        // checkbox forms are only set 'on' when checked else nothing
        ),
    'username' => array(
        'pregex' => '/^[\w@\.\ -]+$/' // alphanumeric, but also '-', '_', '@', '.'
        ),
    'password' => array(
        // Some special characters are allowed (no space)
        'pregex' => '/^[\w!?^&\*@#,:;\(\)\/\.+-]+$/'
        ),
    'path' => array(
        // alphanumeric and . , - _ [ ] / ' (Would be nice to discard '../')
        // Null allowed and 255 chars max as the mysql field is also limited to 255
        'pregex' => '/^[\w\.,\/\[\]\ \'\(\)-]{0,255}$/',
        'function' => 'validate_path'
        ),
    'filename' => array(
        // same as path without the /
        'pregex' => '/^[\w\.,\[\]\ \'\(\)-]+$/' 
        ),
    'url' => array(
       'pregex' => '/^(http|ftp):\/\/.+$/'
        ),
    'text_wo_html' => array(
        'function' => 'validate_no_html' 
        ),
    'updpic' => array(
        'pregex' => '/^(1|del|delthumb)$/'
        )

);


/**
* User function to validate path
*
* @var $input
* @return true | false
*/

function validate_path($input)
{
    $check_status = true;

    // trigger_error("DEBUG: ", E_USER_NOTICE);
    if (strstr($input, "..")) $check_status = false;

    return($check_status);

}

/**
* User function to validate that a string doesn't contain any HTML
* (This function is only here for test, you should not rely on it)
*
* @var $input
* @return true | false
*/

function validate_no_html($input)
{

    // This regexp deny any content between barkets
    if (preg_match('/<.+>/', $input)) return false;

    return true;

}

?>
