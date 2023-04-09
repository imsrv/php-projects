<?
/* Casespecial -casespecial.php-

	php's standard functions for uppper- and
	lowercasing don't work for special chars.
	This class uppercase, lowercase en capitalize
	strings with special chars too.

        functions: ucfirst(),ucwords(),strtolower(),strtoupper()
        capitalize(),capitalizewords().

        All functions can called by reference, use the get_ functions
        to get a string return and your original string unchanged.
        see: example.php


   Version 0.1a
   Last change: 2002/09/11
   copyrigth 2002 Email Communications, http://www.emailcommunications.nl/
   written by Bas Jobsen (bas@startpunt.cc)

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2, or (at your option)
   any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software Foundation,
   Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
*/



class casespecial
{

function ucfirst(&$word)
{
$ascii=ord($word[0]);
if (($ascii>223 && $ascii<254)||($ascii>96 && $ascii<123))$word[0]=chr($ascii-32);
}

function ucwords(&$word)
{
$temp=explode(' ',$word);
$word='';
for($a=0; $a<count($temp); $a++)
{

	if ($a>0) $word.=' ';
	$this->ucfirst($temp[$a]);
	$word.=$temp[$a];
}
}

function strtolower(&$word)
{
for($a=0; $a<strlen($word); $a++)
{
$ascii=ord($word[$a]);
if (($ascii>191 && $ascii<222)||($ascii>64 && $ascii<100))
$word[$a]=chr($ascii+32);
}
}

function strtoupper(&$word)
{
for($a=0; $a<strlen($word); $a++)
{
$ascii=ord($word[$a]);
if (($ascii>223 && $ascii<254)||($ascii>96 && $ascii<123))$word[$a]=chr($ascii-32);
}
}

function capitalize(&$word)
{
	$this->strtolower($word);
	$this->ucfirst($word);
}

function capitalizewords(&$word)
{
$temp=explode(' ',$word);
$word='';
for($a=0; $a<count($temp); $a++)
{

	if ($a>0) $word.=' ';
	$this->capitalize($temp[$a]);
	$word.=$temp[$a];
}
}

function get_ucfirst($word){$this->ucfirst($word); return $word;}
function get_ucwords($word){$this->ucwords($word); return $word;}
function get_strtolower($word){$this->strtolower($word); return $word;}
function get_strtoupper($word){$this->strtoupper($word); return $word;}
function get_capitalize($word){$this->capitalize($word); return $word;}
function get_capitalizewords($word){$this->capitalizewords($word); return $word;}
}
?>