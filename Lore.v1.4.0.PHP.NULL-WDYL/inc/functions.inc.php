<?php
/*
+-------------------------------------------------------------------------
| Lore
| (c)2003-2004 Pineapple Technologies
| http://www.pineappletechnologies.com
| ------------------------------------------------------------------------
| This code is the proprietary product of Pineapple Technologies and is
| protected by international copyright and intellectual property laws.
| ------------------------------------------------------------------------
| Your usage of this software is bound by the agreement set forth in the
| software license that was packaged with this software as LICENSE.txt.
| A copy of this license agreement can be located at
| http://www.pineappletechnologies.com/products/lore/license.php
| By installing and/or using this software you agree to the terms
| stated in the license.
| ------------------------------------------------------------------------
| You may modify the code below at your own risk. However, the software
| cannot be redistributed, whether altered or not altered, in whole or in
| part, in any way, shape, or form.
+-------------------------------------------------------------------------
| Software Version: 1.4.0
+-------------------------------------------------------------------------
*/

//////////////////////////////////////////////////////////////
/**
* @package pt_common_lib
*/
//////////////////////////////////////////////////////////////
function alphanumeric( $string )
{
	return ereg_replace("[^A-Za-z������������������������0-9_]", '', str_replace(' ', '_', $string));
}


//////////////////////////////////////////////////////////////
/**
* Recursive version of array_walk()
* @package pt_common_lib
*/
//////////////////////////////////////////////////////////////
function my_array_walk(&$array, $func)
{
	@reset($array);
	while( @list($key,$value) = @each($array) )
	{
		if(is_array($array[$key]))
		{
			my_array_walk($array[$key], $func);
		}
		else
		{
			$array[$key] = $func($value);
		}
	}
}


if( !function_exists('file_get_contents') )
{
	function file_get_contents($filename)
	{
		$fd = fopen($filename, 'rb');
		$content = fread($fd, filesize($filename));
		fclose($fd);
		return $content;
	}
}

if( !function_exists('file_put_contents') )
{
	function file_put_contents($filename, $data)
	{
		$fd = fopen($filename, 'w');
		fwrite($fd, $data);
		fclose($fd);
	}
}

?>
