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

/*** For backward compatibility with PHP 4.0 **********************************/

if (!isset($_SERVER) && isset($HTTP_SERVER_VARS)) $_SERVER  = $HTTP_SERVER_VARS;

/******************************************************************************/

class Skin
{
    var $current = 'Modern';
    var $basedir = './';

    function & instance()
    {
        static $skin = null;
        if (!$skin)
        {
            $skin = new Skin();
        }

        return $skin;
    }

    function get()
    {
        $i =& Skin::instance();
        return $i->current;
    }

    function set($skin)
    {
        if ($skin)
        {
            $i =& Skin::instance();
            $i->current = $skin;
        }
    }

    function img($filename, $prefix='', $id='')
    {
        $imgid = '';

        if ($prefix)
        {
            $imgid = 'id="i' . $prefix . $id . '" ';
        }

        return '<img ' . $imgid . 'src="'. Skin::imgsrc($filename) .'">';
    }

    function imgsrc($filename)
    {
        return Skin::path() . '/' . $filename . '.png';
    }

    function path()
    {
        static $i = null;
        if (!$i) $i =& Skin::instance();
        return $i->basedir . 'skins/'. Skin::get();
    }

    function setBaseDir($dir)
    {
        $i =& Skin::instance();
        $i->basedir = $dir;
    }
}

class Page
{
    function title()
    {
        return 'SiteBar';
    }

    function url()
    {
        @list($uri,$qry) = explode('?',$_SERVER['REQUEST_URI']);
        $host = isset($_SERVER['SERVER_NAME'])
                ?$_SERVER['SERVER_NAME']
                :$_SERVER['HTTP_HOST'];

        @list($proto,$version) = explode('/',$_SERVER['SERVER_PROTOCOL']);

        return strtolower($proto).'://'.$host.$uri;
    }

    function baseurl()
    {
        $dirs = explode('/', Page::url());
        array_pop($dirs);
        return implode('/', $dirs);
    }

    function utf8RawUrlDecode ($source)
    {
        $decodedStr = '';
        $pos = 0;
        $len = strlen ($source);
        while ($pos < $len)
        {
            $charAt = substr ($source, $pos, 1);
            if ($charAt == '%')
            {
                $pos++;
                $charAt = substr ($source, $pos, 1);
                if ($charAt == 'u')
                {
                    // we got a unicode character
                    $pos++;
                    $unicodeHexVal = substr ($source, $pos, 4);
                    $unicode = hexdec ($unicodeHexVal);
                    $entity = "&#". $unicode . ';';
                    $decodedStr .= Page::utf8Encode($entity);
                    $pos += 4;
                }
                else
                {
                    // we have an escaped ascii character
                    $hexVal = substr ($source, $pos, 2);
                    $decodedStr .= chr (hexdec ($hexVal));
                    $pos += 2;
                }
            }
            else
            {
                $decodedStr .= $charAt;
                $pos++;
            }
        }
        return $decodedStr;
    }

    function utf8Encode ($source)
    {
        $utf8Str = '';
        $entityArray = explode ("&#", $source);
        $size = count ($entityArray);
        for ($i = 0; $i < $size; $i++)
        {
            $subStr = $entityArray[$i];
            $nonEntity = strstr ($subStr, ';');
            if ($nonEntity !== false)
            {
                $unicode = intval (substr ($subStr, 0, (strpos ($subStr, ';') + 1)));
                // determine how many chars are needed to reprsent this unicode char
                if ($unicode < 128)
                {
                    $utf8Substring = chr ($unicode);
                }
                else if ($unicode >= 128 && $unicode < 2048)
                {
                    $binVal = str_pad (decbin ($unicode), 11, "0", STR_PAD_LEFT);
                    $binPart1 = substr ($binVal, 0, 5);
                    $binPart2 = substr ($binVal, 5);

                    $char1 = chr (192 + bindec ($binPart1));
                    $char2 = chr (128 + bindec ($binPart2));
                    $utf8Substring = $char1 . $char2;
                }
                else if ($unicode >= 2048 && $unicode < 65536)
                {
                    $binVal = str_pad (decbin ($unicode), 16, "0", STR_PAD_LEFT);
                    $binPart1 = substr ($binVal, 0, 4);
                    $binPart2 = substr ($binVal, 4, 6);
                    $binPart3 = substr ($binVal, 10);

                    $char1 = chr (224 + bindec ($binPart1));
                    $char2 = chr (128 + bindec ($binPart2));
                    $char3 = chr (128 + bindec ($binPart3));
                    $utf8Substring = $char1 . $char2 . $char3;
                }
                else
                {
                    $binVal = str_pad (decbin ($unicode), 21, "0", STR_PAD_LEFT);
                    $binPart1 = substr ($binVal, 0, 3);
                    $binPart2 = substr ($binVal, 3, 6);
                    $binPart3 = substr ($binVal, 9, 6);
                    $binPart4 = substr ($binVal, 15);

                    $char1 = chr (240 + bindec ($binPart1));
                    $char2 = chr (128 + bindec ($binPart2));
                    $char3 = chr (128 + bindec ($binPart3));
                    $char4 = chr (128 + bindec ($binPart4));
                    $utf8Substring = $char1 . $char2 . $char3 . $char4;
                }

                if (strlen ($nonEntity) > 1)
                {
                    $nonEntity = substr ($nonEntity, 1); // chop the first char (';')
                }
                else
                {
                    $nonEntity = '';
                }
                $utf8Str .= $utf8Substring . $nonEntity;
            }
            else
            {
                $utf8Str .= $subStr;
            }
        }
        return $utf8Str;
    }

    function isMSIE()
    {
        static $isMSIE = null;

        if ($isMSIE === null)
        {
            $isMSIE = strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE');
        }

        return $isMSIE;
    }

    // Exclude Opera
    function isOPERA()
    {
        static $isOPERA = null;

        if ($isOPERA === null)
        {
            $isOPERA = strstr($_SERVER['HTTP_USER_AGENT'], 'Opera');
        }

        return $isOPERA;
    }

    function dragDropNode($nid)
    {
        if (Page::isOPERA())
        {
            return '';
        }

        return ' '.
            (Page::isMSIE()?'ondragstart':'onmousedown').
            '="return nodeDrag(event,'. $nid .')"'.
            ' onmouseup="return nodeDrop(event,'. $nid .')"';
    }

    function dragDropLink($nid, $lid)
    {
        if (Page::isOPERA())
        {
            return '';
        }

        return ' '.
            (Page::isMSIE()?'ondragstart':'onmousedown').
            '="return linkDrag(event,'. $lid .')"'.
            ' onmouseup="return nodeDrop(event,'. $nid .','. $lid . ')"';
    }

    function target()
    {
        static $trg = null;

        if ($trg === null)
        {
            $target = (Page::isMSIE()||Page::isOPERA()?'_main':'_content');
            if (isset($_GET['target'])) $target = $_GET['target'];
            if (isset($_POST['target'])) $target = $_POST['target'];
            $trg = ' target="'.$target.'"';
        }
        return $trg;
    }

    function head($title, $bodyClass=null, $inHead=null, $onLoad=null)
    {
        // Do not change document type!
        // Any newer version would require changes of JavaScript library.
        // media="All" is used to hide the styles from Netscape 4.x

        $target = '';
        if (isset($_GET['target'])) $target = $_GET['target'];
        if (isset($_POST['target'])) $target = $_POST['target'];

        header("Content-Type: text/html; charset=UTF-8");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"
    "http://www.w3.org/TR/REC-html40/loose.dtd">

<html>
<head>
    <title>:: <?=Page::title()?> :: <?=$title?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="Shortcut Icon" href="<?=Skin::path()?>/root_transparent.png">
    <link rel="StyleSheet"    href="<?=Skin::path()?>/sitebar.css" type='text/css' media='all'>
    <link rel="Author"        href="http://brablc.com/">
    <script src="./inc/sitebar.js" type="text/javascript"></script>
    <script type="text/javascript">
        setSkinDir('<?=Skin::path()?>');
        setLinkTarget('<?=$target?>');
        <?=($inHead?$inHead:'')?>
    </script>
</head>
<body <?=($bodyClass?'class="'.$bodyClass.'"':'')?><?=($onLoad?' onLoad="'.$onLoad.'"':'')?> onmouseup="cancelDragging()">
<?
    }

    function foot()
    {
?>
</body>
</html>
<?
    }

    /* static */ function quoteValue($value)
    {
        $q = htmlspecialchars($value);
        return str_replace("\r\n",' ',str_replace("&amp;","&",$q));
    }
}
?>
