<?
/******************************************************************************
 *  SiteBar 3 - The Bookmark Server for Personal and Team Use.                *
 *  Copyright (C) 2003  Ondrej Brablc <sitebar@brablc.com>                    *
 *                                                                            *
 *  This program is free software; you can redistribute it and/or modify      *
 *  it under the terms of the GNU General Public License as published by      *
 *  the Free Software Foundation; either version 2 of the License, or         *
 *  (at your option) any later version.                                       *
 *                                                                            *
 *  This program is distributed in the hope that it will be useful,           *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 *  GNU General Public License for more details.                              *
 *                                                                            *
 *  You should have received a copy of the GNU General Public License         *
 *  along with this program; if not, write to the Free Software               *
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA *
 ******************************************************************************/

require_once('./inc/tree.inc.php');
require_once('./inc/errorhandler.inc.php');

define ('BM_T_NETSCAPE',   'NETSCAPE-Bookmark-file-1');
define ('BM_T_MSSHORTCUT', '[DEFAULT]');
define ('BM_T_OPERA',      'Opera Hotlist version 2.0');

define('CHARSET_IGNORE',  -1);
define('CHARSET_NONE',     0);
define('CHARSET_ICONV',    1);
define('CHARSET_LIBICONV', 2);
define('CHARSET_RECODE',   3);

class BookmarkManager extends ErrorHandler
{
    var $tree;
    // Content of the whole file - memory should not be problem
    var $lines = array();
    // Were bookmarks loaded?
    var $success = false;

    var $importedLinks = 0;
    var $importedFolders = 0;

    // List of available languages
    var $languages;

    // Default charSet
    var $charSet;

    // Recode engine
    var $engine = CHARSET_IGNORE;

    function BookmarkManager($charSet='en-utf-8')
    {
        $this->languages = array(
            'af-utf-8'     => array('af|afrikaans', 'afrikaans-utf-8', 'af'),
            'af-iso-8859-1'=> array('af|afrikaans', 'afrikaans-iso-8859-1', 'af'),
            'ar-utf-8'     => array('ar([-_][[:alpha:]]{2})?|arabic', 'arabic-utf-8', 'ar'),
            'ar-win1256'   => array('ar([-_][[:alpha:]]{2})?|arabic', 'arabic-windows-1256', 'ar'),
            'bg-utf-8'     => array('bg|bulgarian', 'bulgarian-utf-8', 'bg'),
            'bg-win1251'   => array('bg|bulgarian', 'bulgarian-windows-1251', 'bg'),
            'bg-koi8-r'    => array('bg|bulgarian', 'bulgarian-koi8-r', 'bg'),
            'ca-utf-8'     => array('ca|catalan', 'catalan-utf-8', 'ca'),
            'ca-iso-8859-1'=> array('ca|catalan', 'catalan-iso-8859-1', 'ca'),
            'cs-utf-8'     => array('cs|czech', 'czech-utf-8', 'cs'),
            'cs-iso-8859-2'=> array('cs|czech', 'czech-iso-8859-2', 'cs'),
            'cs-win1250'   => array('cs|czech', 'czech-windows-1250', 'cs'),
            'da-utf-8'     => array('da|danish', 'danish-utf-8', 'da'),
            'da-iso-8859-1'=> array('da|danish', 'danish-iso-8859-1', 'da'),
            'de-utf-8'     => array('de([-_][[:alpha:]]{2})?|german', 'german-utf-8', 'de'),
            'de-iso-8859-1'=> array('de([-_][[:alpha:]]{2})?|german', 'german-iso-8859-1', 'de'),
            'el-utf-8'     => array('el|greek',  'greek-utf-8', 'el'),
            'el-iso-8859-7'=> array('el|greek',  'greek-iso-8859-7', 'el'),
            'en-utf-8'     => array('en([-_][[:alpha:]]{2})?|english',  'english-utf-8', 'en'),
            'en-iso-8859-1'=> array('en([-_][[:alpha:]]{2})?|english',  'english-iso-8859-1', 'en'),
            'es-utf-8'     => array('es([-_][[:alpha:]]{2})?|spanish', 'spanish-utf-8', 'es'),
            'es-iso-8859-1'=> array('es([-_][[:alpha:]]{2})?|spanish', 'spanish-iso-8859-1', 'es'),
            'et-utf-8'     => array('et|estonian', 'estonian-utf-8', 'et'),
            'et-iso-8859-1'=> array('et|estonian', 'estonian-iso-8859-1', 'et'),
            'fi-utf-8'     => array('fi|finnish', 'finnish-utf-8', 'fi'),
            'fi-iso-8859-1'=> array('fi|finnish', 'finnish-iso-8859-1', 'fi'),
            'fr-utf-8'     => array('fr([-_][[:alpha:]]{2})?|french', 'french-utf-8', 'fr'),
            'fr-iso-8859-1'=> array('fr([-_][[:alpha:]]{2})?|french', 'french-iso-8859-1', 'fr'),
            'gl-utf-8'     => array('gl|galician', 'galician-utf-8', 'gl'),
            'gl-iso-8859-1'=> array('gl|galician', 'galician-iso-8859-1', 'gl'),
            'he-iso-8859-8-i'=> array('he|hebrew', 'hebrew-iso-8859-8-i', 'he'),
            'hi-utf-8'     => array('hi|hindi', 'hindi-utf-8', 'hi'),
            'hr-utf-8'     => array('hr|croatian', 'croatian-utf-8', 'hr'),
            'hr-win1250'   => array('hr|croatian', 'croatian-windows-1250', 'hr'),
            'hr-iso-8859-2'=> array('hr|croatian', 'croatian-iso-8859-2', 'hr'),
            'hu-utf-8'     => array('hu|hungarian', 'hungarian-utf-8', 'hu'),
            'hu-iso-8859-2'=> array('hu|hungarian', 'hungarian-iso-8859-2', 'hu'),
            'id-utf-8'     => array('id|indonesian', 'indonesian-utf-8', 'id'),
            'id-iso-8859-1'=> array('id|indonesian', 'indonesian-iso-8859-1', 'id'),
            'it-utf-8'     => array('it|italian', 'italian-utf-8', 'it'),
            'it-iso-8859-1'=> array('it|italian', 'italian-iso-8859-1', 'it'),
            'ja-utf-8'     => array('ja|japanese', 'japanese-utf-8', 'ja'),
            'ja-euc'       => array('ja|japanese', 'japanese-euc', 'ja'),
            'ja-sjis'      => array('ja|japanese', 'japanese-sjis', 'ja'),
            'ko-ks_c_5601-1987'=> array('ko|korean', 'korean-ks_c_5601-1987', 'ko'),
            'ka-utf-8'     => array('ka|georgian', 'georgian-utf-8', 'ka'),
            'lt-utf-8'     => array('lt|lithuanian', 'lithuanian-utf-8', 'lt'),
            'lt-win1257'   => array('lt|lithuanian', 'lithuanian-windows-1257', 'lt'),
            'lv-utf-8'     => array('lv|latvian', 'latvian-utf-8', 'lv'),
            'lv-win1257'   => array('lv|latvian', 'latvian-windows-1257', 'lv'),
            'ms-utf-8'     => array('ms|malay', 'malay-utf-8', 'ms'),
            'ms-iso-8859-1'=> array('ms|malay', 'malay-iso-8859-1', 'ms'),
            'nl-utf-8'     => array('nl([-_][[:alpha:]]{2})?|dutch', 'dutch-utf-8', 'nl'),
            'nl-iso-8859-1'=> array('nl([-_][[:alpha:]]{2})?|dutch', 'dutch-iso-8859-1', 'nl'),
            'no-utf-8'     => array('no|norwegian', 'norwegian-utf-8', 'no'),
            'no-iso-8859-1'=> array('no|norwegian', 'norwegian-iso-8859-1', 'no'),
            'pl-utf-8'     => array('pl|polish', 'polish-utf-8', 'pl'),
            'pl-iso-8859-2'=> array('pl|polish', 'polish-iso-8859-2', 'pl'),
            'pt-br-utf-8'  => array('pt[-_]br|brazilian port.', 'brazilian_portuguese-utf-8', 'pt-BR'),
            'pt-br-iso-8859-1' => array('pt[-_]br|brazilian port.', 'brazilian_portuguese-iso-8859-1', 'pt-BR'),
            'pt-utf-8'     => array('pt([-_][[:alpha:]]{2})?|portuguese', 'portuguese-utf-8', 'pt'),
            'pt-iso-8859-1'=> array('pt([-_][[:alpha:]]{2})?|portuguese', 'portuguese-iso-8859-1', 'pt'),
            'ro-utf-8'     => array('ro|romanian', 'romanian-utf-8', 'ro'),
            'ro-iso-8859-1'=> array('ro|romanian', 'romanian-iso-8859-1', 'ro'),
            'ru-win1251'   => array('ru|russian', 'russian-windows-1251', 'ru'),
            'ru-utf-8'     => array('ru|russian', 'russian-utf-8', 'ru'),
            'ru-dos-866'   => array('ru|russian', 'russian-dos-866', 'ru'),
            'ru-koi8-r'    => array('ru|russian', 'russian-koi8-r', 'ru'),
            'sk-utf-8'     => array('sk|slovak', 'slovak-utf-8', 'sk'),
            'sk-iso-8859-2'=> array('sk|slovak', 'slovak-iso-8859-2', 'sk'),
            'sk-win1250'   => array('sk|slovak', 'slovak-windows-1250', 'sk'),
            'sl-utf-8'     => array('sl|slovenian', 'slovenian-utf-8', 'sl'),
            'sl-iso-8859-2'=> array('sl|slovenian', 'slovenian-iso-8859-2', 'sl'),
            'sl-win1250'   => array('sl|slovenian', 'slovenian-windows-1250', 'sl'),
            'sq-utf-8'     => array('sq|albanian', 'albanian-utf-8', 'sq'),
            'sq-iso-8859-1'=> array('sq|albanian', 'albanian-iso-8859-1', 'sq'),
            'sr-utf-8'     => array('sr|serbian', 'serbian-utf-8', 'sr'),
            'sr-win1250'   => array('sr|serbian', 'serbian-windows-1250', 'sr'),
            'sv-utf-8'     => array('sv|swedish', 'swedish-utf-8', 'sv'),
            'sv-iso-8859-1'=> array('sv|swedish', 'swedish-iso-8859-1', 'sv'),
            'th-utf-8'     => array('th|thai', 'thai-utf-8', 'th'),
            'th-tis-620'   => array('th|thai', 'thai-tis-620', 'th'),
            'tr-utf-8'     => array('tr|turkish', 'turkish-utf-8', 'tr'),
            'tr-iso-8859-9'=> array('tr|turkish', 'turkish-iso-8859-9', 'tr'),
            'uk-utf-8'     => array('uk|ukrainian', 'ukrainian-utf-8', 'uk'),
            'uk-win1251'   => array('uk|ukrainian', 'ukrainian-windows-1251', 'uk'),
            'zh-tw-utf-8'  => array('zh[-_]tw|chinese traditional', 'chinese_big5-utf-8', 'zh-TW'),
            'zh-tw'        => array('zh[-_]tw|chinese traditional', 'chinese_big5', 'zh-TW'),
            'zh-utf-8'     => array('zh|chinese simplified', 'chinese_gb-utf-8', 'zh'),
            'zh'           => array('zh|chinese simplified', 'chinese_gb', 'zh')
        );


        // If UTF8 then switch to en version for later detection
        if ($charSet=='en-utf-8')
        {
            $this->engine = CHARSET_NONE;
        }
        else
        {
            $this->engine = $this->getEngine();
        }

        list($country, $this->charSet) = explode('-', $this->languages[$charSet][1], 2);
    }

    function getEngine()
    {
        $suffix = (defined('PHP_OS') && eregi('win', PHP_OS));

        if (!@function_exists('iconv') && @!extension_loaded('iconv'))
        {
            @dl('iconv' . $suffix);
        }

        if (@function_exists('iconv'))
        {
            return CHARSET_ICONV;
        }
        elseif (@function_exists('libiconv'))
        {
            return CHARSET_LIBICONV;
        }
        else
        {
            if (!@function_exists('recode_string') && @!extension_loaded('recode'))
            {
                @dl('recode' . $suffix);
            }

            if (@function_exists('recode_string'))
            {
                return CHARSET_RECODE;
            }
            else
            {
                return CHARSET_NONE;
            }
        }
    }

/******************************************************************************/

    function langDetect()
    {
        if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
        {
            $str = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            foreach ($this->languages as $key => $value)
            {
                if (preg_match('/^(' . $value[0] . ').*?(;q=[0-9]\\.[0-9])?$/', $str))
                {
                    return $key;
                }
            }
        }

        if (!empty($_SERVER['HTTP_USER_AGENT']))
        {
            $str = $_SERVER['HTTP_USER_AGENT'];
            foreach ($this->languages as $key => $value)
            {
                if (eregi('(\(|\[|;[[:space:]])(' . $value[0] . ')(;|\]|\))', $str))
                {
                    return $key;
                }
            }
        }

        return $this->charSet;
    }

    function impVal($text)
    {
        switch ($this->engine)
        {
            case CHARSET_ICONV:
                return iconv($this->charSet, 'UTF-8', $text);

            case CHARSET_LIBICONV:
                return libiconv($this->charSet, 'UTF-8', $text);

            case CHARSET_RECODE:
                return recode_string($this->charSet .'..'. 'UTF-8', $text);

            default:
                return $text;
        }
    }

    function expVal($text)
    {
        switch ($this->engine)
        {
            case CHARSET_ICONV:
                return iconv('UTF-8', $this->charSet."//TRANSLIT", $text);

            case CHARSET_LIBICONV:
                return libiconv('UTF-8', $this->charSet, $text);

            case CHARSET_RECODE:
                return recode_string('UTF-8' .'..'. $this->charSet, $text);

            default:
                return $text;
        }
    }

/******************************************************************************/

    function import($filename, $type=null)
    {
        if (!($fp = fopen($filename, 'r')))
        {
            $this->error( "Can't open file!");
            return;
        }

        while (!feof($fp))
        {
            $this->lines[] = rtrim(fgets($fp,4096));
        }
        fclose( $fp);

        if (!count($this->lines))
        {
            $this->error( "File is empty!");
            return;
        }

        $this->tree = new Tree_Node();

        if (!$type)
        {
            $type = $this->lines[0];
        }

        if (stristr($type, BM_T_NETSCAPE))
        {
            $this->success = $this->importNetscape($this->tree);
        }
        elseif (stristr($type, BM_T_OPERA))
        {
            $this->success = $this->importOpera($this->tree);
        }
        else
        {
            $this->error( "Unknown bookmark file format!");
        }
    }

    function importNetscape(&$parent)
    {
        while (($line = array_shift($this->lines))!==null)
        {
            if (preg_match('/<meta\s+http-equiv=["\']Content-Type["\']\s+'.
                'content=["\'].*?\bcharset=(.*?)["\']\s*>/i', $line, $reg))
            {
                if (strcasecmp($reg[1],$this->charSet))
                {
                    $this->charSet = $reg[1];
                    $this->warn('Character set overriden from document to '. $reg[1] .'!');
                }
            }

            $line = $this->impVal($line);

            // Open node
            if (preg_match('/<DT.*><H3.*>([^<]+)<\/H3>/i', $line, $reg ))
            {
                $rec = array();
                $rec['name'] = $reg[1];
                $this->_importNetscapeComment($rec);

                $node = new Tree_Node($rec);

                // Yes recursive!
                $this->importNetscape($node);
                $parent->addNode($node);
                $this->importedFolders++;
                continue;
            }

            // Add link to current node
            if (preg_match('/<DT.*><A HREF="([^"]+)"([^>]*)>([^<]+)<\/A>/i',$line, $reg ))
            {
                $rec = array();
                $rec['url'] = $reg[1];
                $rec['name'] = $reg[3];
                if (preg_match('/ICON="([^"]+)"/i',$reg[2], $iconReg))
                {
                    $rec['favicon'] = $iconReg[1];
                }
                $this->_importNetscapeComment($rec);
                $parent->addLink(new Tree_Link($rec));
                $this->importedLinks++;
                continue;
            }

            // Close node - break recursion
            if (stristr($line, "</DL>"))
            {
                return true;
            }
        }
        return true;
    }

    function _importNetscapeComment(&$rec)
    {
        $line = array_shift($this->lines);
        if (preg_match('/<DD>(.*)/i', $line, $reg ))
        {
            $rec['comment'] = $this->impVal($reg[1]);
        }
        else
        {
            // Put it back if it is not comment
            array_unshift($this->lines,$line);
        }
    }

    function importOpera(&$parent)
    {
        while (($line = array_shift($this->lines))!==null)
        {
            $line = $this->impVal($line);
            // Open node
            if ($line == "#FOLDER")
            {
                $rec = array();
                while ($line != "")
                {
                    $line = trim(array_shift($this->lines));
                    $parts = explode('=',$line,2);

                    if (count($parts)>1)
                    {
                        list($name,$value) = $parts;
                        if ($name=='NAME')
                        {
                            $rec['name'] = $value;
                        }
                        if ($name=='DESCRIPTION')
                        {
                            $rec['comment'] = $value;
                        }
                    }
                    else
                    {
                        break;
                    }
                }
                $node = new Tree_Node($rec);

                // Yes recursive!
                $this->importOpera($node);
                $parent->addNode($node);
                $this->importedFolders++;
                continue;
            }

            // Add link to current node
            if ($line == "#URL")
            {
                $rec = array();
                while ($line != "")
                {
                    $line = trim(array_shift($this->lines));
                    $parts = explode('=',$line,2);

                    if (count($parts)>1)
                    {
                        list($name,$value) = $parts;

                        if ($name=='NAME')
                        {
                            $rec['name'] = $value;
                        }
                        if ($name=='URL')
                        {
                            $rec['url'] = $value;
                        }
                        if ($name=='DESCRIPTION')
                        {
                            $rec['comment'] = $value;
                        }
                    }
                    else
                    {
                        break;
                    }
                }
                $parent->addLink(new Tree_Link($rec));
                $this->importedLinks++;
                continue;
            }

            // Close node - break recursion
            if ($line == "-")
            {
                return true;
            }
        }
        return true;
    }

/******************************************************************************/

    function export($base, $type)
    {
        if (stristr($type, BM_T_NETSCAPE))
        {
            $this->success = $this->exportNetscape($base);
        }
        elseif (stristr($type, BM_T_OPERA))
        {
            $this->success = $this->exportOpera($base);
        }
        else
        {
            $this->error( "Unknown bookmark file format!");
        }
    }

    function exportNetscape($base)
    {
?>
<!DOCTYPE NETSCAPE-Bookmark-file-1>
<!-- This is an automatically generated file.
     It will be read and overwritten.
     DO NOT EDIT! -->
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?=$this->charSet?>">
<TITLE>Bookmarks</TITLE>
<H1>Bookmarks</H1>

<DL><p>
<?
        $this->_exportNetscapeNode($base, 1);
        $this->_exportNetscapeLinks($base, 1);
?>
</DL><p>
<?
    }

    function _exportNetscapeNode($base, $level)
    {
        foreach ($base->getNodes() as $node)
        {
            $filler = str_repeat("\t", $level);
            echo $filler . '<DT><H3 ADD_DATE="' . mktime() . '">' .
                $this->expVal($node->name) . "</H3>\n";
            if ($node->comment)
            {
                echo $filler. '<DD>' .
                    $this->expVal($node->comment) . "\n";
            }
            echo $filler . "<DL><p>\n";

            $this->_exportNetscapeNode($node, $level+1);
            $this->_exportNetscapeLinks($node, $level+1);

            echo $filler . "</DL><p>\n";
        }
    }

    function _exportNetscapeLinks($node, $level)
    {
         $filler = str_repeat("\t", $level);

         foreach ($node->getLinks() as $link)
         {
             echo $filler . '<DT><A HREF="' . $link->url . '" '.
                 ($link->favicon?' ICON="'. $link->favicon . '"':'') .
                 'ADD_DATE="' . mktime() . '"' .
                 '>' .  $this->expVal($link->name) . "</A>\n";
             if ($link->comment)
             {
                echo $filler.'<DD>'.$this->expVal($link->comment)."\n";
             }
         }
    }


    function exportOpera($base)
    {
?>
Opera Hotlist version 2.0
Options: encoding = utf8, version=3

<?
        $this->_exportOperaNode($base);
        $this->_exportOperaLinks($base);
    }

    function _exportOperaNode($base)
    {
        foreach ($base->getNodes() as $node)
        {
            echo "#FOLDER\n";
            echo "\tNAME=".$this->expVal($node->name)."\n";
            if ($node->comment)
            {
                echo "\tDESCRIPTION=".$this->expVal($node->comment)."\n";
            }
            echo "\n";

            $this->_exportOperaNode($node);
            $this->_exportOperaLinks($node);

            echo "-\n\n";
        }
    }

    function _exportOperaLinks($node)
    {
        foreach ($node->getLinks() as $link)
        {
            echo "#URL\n";
            echo "\tNAME=".$this->expVal($link->name)."\n";
            echo "\tURL=".$link->url."\n";
            if ($link->comment)
            {
                echo "\tDESCRIPTION=".$this->expVal($link->comment)."\n";
            }
            echo "\n";
        }
    }
}
?>
