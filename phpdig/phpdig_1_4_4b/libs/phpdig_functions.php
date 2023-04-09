<?
/*
--------------------------------------------------------------------------------
PhpDig 1.4.x
This program is provided under the GNU/GPL license.
See LICENSE file for more informations
All contributors are listed in the CREDITS file provided with this package

PhpDig Website : http://phpdig.toiletoine.net/
Contact email : phpdig@toiletoine.net
Author and main maintainer : Antoine Bajolet (fr) bajolet@toiletoine.net
--------------------------------------------------------------------------------
*/

//-------------STRING FUNCTIONS

//=================================================
//returns a localized string
function msg($string='')
{
global $phpdig_mess;
return nl2br($phpdig_mess[$string]);
}

//print a localized string
function pmsg($string='')
{
global $phpdig_mess;
print nl2br($phpdig_mess[$string]);
}

//=================================================
//load the common words in an array
function common_words($file='')
{
$lines = @file($file);
if (is_array($lines))
    {
    while (list($id,$word) = each($lines))
           $common[trim($word)] = 1;
    }
else
    $common['aaaa'] = 1;
return $common;
}

//=================================================
//highlight a string part
function highlight($word="",$string="")
{
if ($word)
    return @eregi_replace('('.preg_quote($word).')',"<B style='background-color:".HIGHLIGHT_BACKGROUND.";'>\\1</B>",$string);
else
    return $result;
}

//=================================================
//replace all characters with an accent
function stripaccents($chaine)
{
return( strtr( $chaine,
"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
"AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn" ) );
}

//=================================================
//epure a string from all non alnum words (words can contain &__&ßðþ character)
function epure_text($text,$min_word_length=2)
{
$text = stripaccents(strtolower ($text));
//no-latin upper to lowercase - now islandic
$text = strtr( $text,
'ÐÞ',
'ðþ');
$text = ereg_replace('[[:blank:]][0-9]+[[:blank:]]',' ',ereg_replace('[^[:alnum:]ðþ._&ß]+',' ',$text));
$text = ereg_replace('[[:blank:]][^ ]{1,'.$min_word_length.'}[[:blank:]]',' ',' '.$text.' ');
$text = ereg_replace('\.+[[:blank:]]|\.+$',' ',$text);
return trim(ereg_replace("[[:blank:]]+"," ",$text));
}
?>