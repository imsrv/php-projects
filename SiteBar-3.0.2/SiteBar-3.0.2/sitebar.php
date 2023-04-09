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

if (@!include_once('./inc/config.inc.php'))
{
    header('Location: config.php');
    exit;
}

require_once('./inc/page.inc.php');
require_once('./inc/tree.inc.php');
require_once('./inc/usermanager.inc.php');

class SiteBar
{
    var $linkMenu;
    var $nodeMenu;
    var $userMenu;
    var $um;
    var $tree;
    var $expandedNodes;
    var $treearr = array();

    var $iconnect;
    var $iempty;
    var $ijoin;
    var $ijoinl;
    var $ilink;
    var $ilinkp;
    var $nmenu;
    var $lmenu;

    function SiteBar()
    {
        $this->um = UserManager::staticInstance();
        $this->tree = new Tree();

        $this->expandedNodes = $this->getExpandedNodes('SB3NODES');

        $this->nodeMenu = array
        (
            'Add Link:*i',
            'Add Folder:*i',
            '',
            'Folder Properties:*u',
            'Delete Folder:*d',
            'Purge Folder:p',
            'Undelete:pi',
            '',
            'Copy:*:nodeCopy',
            'Paste:*i_c',
            '',
            'Import Bookmarks:*i',
            'Export Bookmarks:*',
            'Security:*',
        );

        $this->linkMenu = array
        (
            'Email Link',
            'Copy Link::linkCopy',
            'Delete Link:d',
            '',
            'Properties:u',
        );

        $this->userMenu = array
        (
            'Log In',
            'Sign Up',
            'User Settings',
            'Verify Email',
            'Membership',
            '',
            'SiteBar Settings',
            'Create Tree',
            'Maintain Users',
            'Maintain Groups',
            '',
            'Contact Admin',
            'Help',
            'Log Out',
        );

        Skin::set($this->um->getParam('user','skin'));

        $this->iconnect = Skin::img('connect');
        $this->iempty   = Skin::img('empty');
        $this->ijoin    = Skin::img('join');
        $this->ijoinl   = Skin::img('join_last');
        $this->ilink    = Skin::img('link');
        $this->ilinkp   = Skin::img('link_private');

        if ($this->um->getParam('user','menu_icon'))
        {
            $this->lmenu = "<span onclick='return menuOn(event,this.parentNode);'>" .
                Skin::img('menu') . "</span>";
            $this->nmenu = "<span onclick='return menuOn(event,this.parentNode.parentNode);'>" .
                Skin::img('menu') . "</span>";
        }
    }

    function run()
    {
        // If we want to use compression and it is not used yet
        if ($this->um->getParam('config','use_compression')
        &&  !@ini_get('zlib.output_compression'))
        {
            ob_start('ob_gzhandler');
        }

        Page::head(null, null,
            "initPage(".($this->um->getParam('user','extern_commander')?"0":"1").
            ", new Array('".implode("','", $this->um->inPlaceCommands())."'))");

        // Include skin hook file
        include_once(Skin::path().'/hook.php');

        Hook::head();
        $this->writeMenu('node', $this->nodeMenu);
        $this->writeMenu('link', $this->linkMenu);
?>
<div id='toolbar'>
    <div class='search'>
        <input id='fldSearch' type='text' onkeyup="if (event && event.keyCode==13) search();">
        <input id='btnSearch' type='image' src='<?=Skin::imgsrc('search')?>' title='Search' onclick='search(event)'>
        <input id='btnHighlight' type='image' src='<?=Skin::imgsrc('highlight')?>' title='Highlight' onclick='highlight(event)'>
    </div>
    <div class='buttons'>
        <input type='image' src='<?=Skin::imgsrc('collapse')?>' title='Collapse All' onclick='collapseAll(event)'>
        <input type='image' src='<?=Skin::imgsrc('reload')?>' title='Reload' onclick='reloadPage()'>
    </div>
</div>
<?
        if ($this->um->setupDone)
        {
            foreach ($this->tree->loadRoots() as $root)
            {
                echo '<div class="root tree">'."\n";
                // Late node loading
                $this->tree->loadNodes($root, false);
                $this->drawNode($root);
                echo "</div>\n";
            }
        }
        else
        {
            $this->userMenu = array('Set Up');
        }
?>
<div class='hidden'>
<div><a href='command.php?command=Log%20In'>Backup Log In</a></div>
<div><a href='command.php?command=Log%20Out'>Backup Log Out</a></div>
</div>
<?
        $this->writeMenu('user', $this->userMenu);
        Hook::foot($this->um->config['release']);
        Page::foot();
    }

    function drawNode($node, $last=false)
    {
        $nodename = 'n' . $node->id;
        $aclstr = '';
        $hasACL = false;

        foreach ($node->getACL() as $right => $value)
        {
            if (!$value) continue;
            list($pulp, $name) = explode('_',$right);
            $aclstr .= $name{0};
        }

        // For anonymous we do not show where are rights
        if ($this->um->isAnonymous() || !$this->um->getParam('user','show_acl'))
        {
            $hasACL=false;
        }
        else
        {
            // In personal mode
            if ($this->um->pmode)
            {
                $publicACL = $node->getGroupACL($this->um->config['gid_everyone']);
                $hasACL = $publicACL && $publicACL['allow_select'];
            }
            else // Otherwise any ACL is interesting
            {
                $hasACL = $node->hasACL();
            }
        }

        /* Init images */
        $inode      = Skin::img('node', 'n', $node->id);
        $inodeo     = Skin::img('node_open', 'n', $node->id);
        $iplus      = Skin::img('plus', 's', $node->id);
        $iplusl     = Skin::img('plus_last', 's', $node->id);
        $iminus     = Skin::img('minus', 's', $node->id);
        $iminusl    = Skin::img('minus_last', 's', $node->id);

        echo '<div id="' . $nodename . '"'.
             ' class="node"'.
             ($node->comment?' title="'. Page::quoteValue($node->comment) . '"':'') .
             ' x_acl="'. $aclstr . ($node->deleted_by?'':'*') .'"'.
             ' x_level="' . $node->level . '"'.
             '><span'.
             ' onclick="node(event,this.parentNode)"'.
             ' oncontextmenu="return menuOn(event,this.parentNode)">';

        $showChildren = isset($this->expandedNodes[$node->id]) &&
            $this->expandedNodes[$node->id]=='Y';

        $this->tree->loadLinks($node); // Now I really need links

        if ($node->level)
        {
            if ($node->childrenCount()==0)
            {
                $iplus   = $this->ijoin;
                $iplusl  = $this->ijoinl;
                $iminus  = $this->ijoin;
                $iminusl = $this->ijoinl;
            }
            echo implode('',$this->treearr) .
                ($last?($showChildren?$iminusl:$iplusl)
                      :($showChildren?$iminus :$iplus));

            array_push($this->treearr,($last?$this->iempty:$this->iconnect));
        }
        else
        {
            if ($node->deleted_by==null)
            {
                $inodeo = Skin::img('root', 'n' . $node->id);
                if ($node->childrenCount()==0)
                {
                    $inode  = $inodeo;
                }
                else
                {
                    $inode  = Skin::img('root_plus', 'n' . $node->id);
                }
            }
            else
            {
                $inode  = Skin::img('root_deleted', 'n' . $node->id);
                $inodeo = $inode;
            }
        }

        echo '<a id="'.$nodename.'l" href="javascript:void(0)"'.
             ($hasACL?' class="acl"':'') .
             Page::dragDropNode($node->id).
             '>'.
             ($showChildren?$inodeo:$inode) .
             $this->nmenu .
             Page::quoteValue($node->name) .
             "</a></span>\n".

             '<div id="c' . $node->id . '" '.
             ' class="children'. ($showChildren?'Expanded':'Collapsed') .'">'."\n";

        $count = $node->childrenCount();
        foreach ($node->getNodes() as $childNode)
        {
            $count--;
            $this->drawNode($childNode, $count==0);
        }

        $this->drawLinks($node, $aclstr);
        if ($node->level)
        {
            array_pop($this->treearr);
        }

        echo "</div>\n";
        echo "</div>\n";

        return true;
    }

    function drawLinks($node, $aclstr)
    {
        $count = $node->linkCount();

        foreach ($node->getLinks() as $link)
        {
            $count--;
            $linkname = "l" . $link->id;

            echo '<div id="' . $linkname . '"'.
                 ' onclick="return lnk(event,this)"'.
                 ' oncontextmenu="return menuOn(event,this)"'.
                 ' x_acl="'.$aclstr.'"'.
                 '>'."\n";

            $icon = !($link->favicon&&$this->um->getParam('user','use_favicons'))
                 ?($link->private?$this->ilinkp:$this->ilink)
                 :'<img width="16" height="16" src="'.$link->favicon.'"'.
                  ' onerror="this.src=\''.Skin::imgsrc("link").'\'">';

            echo implode("",$this->treearr) . ($count==0?$this->ijoinl:$this->ijoin);

            $target = null;;
            // Allow bookmarklets
            if (!($link->url{0}=='j' && strpos($link->url,'javascript:')!==false))
            {
                $target = Page::target();
            }

            echo ($this->lmenu?$icon.$this->lmenu:'') .
                 '<a '. ($link->comment?' title="'. Page::quoteValue($link->comment) . '"':'').
                 ($link->private?' class="private"':'') .
                 ' href="' . Page::quoteValue($link->url) . '"'.
                 $target.
                 Page::dragDropLink($node->id,$link->id).
                 '>'.
                 ($this->lmenu?'':$icon) .
                 Page::quoteValue($link->name) . '</a></div>'."\n";
        }
    }

    function writeMenu($type, $items)
    {
        $prev = '';
        $allowedItems = array();
        $allowedACL = array();
        $functions = array();

        foreach ($items as $command)
        {
            @list($command, $acl, $function) = explode(':', $command);

            if (($command && !$this->um->isAuthorized($command))
            ||  (!$command && !$prev))
            {
                continue;
            }
            $allowedItems[]=$command;
            $allowedACL[]=$acl;
            $functions[]=$function;
            $prev = $command;
        }

?>
    <div id='<?=$type?>CtxMenu' class='menu'>
<?
        for ($i=0; $i<count($allowedItems); $i++)
        {
            $command = $allowedItems[$i];

            if (!$command && $i==count($allowedItems)-1)
            {
                continue;
            }

            $div = "\t<div id='${type}Item$i' class='".
                ($command?'off':'separator')."'".
                ' onmouseover="itemOn(this)"'.
                ' onmouseout="itemOff(this)"';

            if ($command)
            {
                $div .=
                    ' onclick="itemDo(this'.($functions[$i]?',\''.$functions[$i].'\'':''). ')"'.
                    ' x_acl="'.$allowedACL[$i].'" ';
            }

            echo $div . '>' . $command . "</div>\n";
            $prev = $command;
        }
?>
    </div>
<?
    }

    function getExpandedNodes($cookieName)
    {
        $states = null;
        $nodes = array();

        if (isset($_COOKIE[$cookieName]))
        {
            $states = explode(':', $_COOKIE[$cookieName]);

            // Remove last element that is either marker ! or possibly incomplete
            array_pop($states);

            while ($node = array_pop($states))
            {
                $nodes[substr($node,1)] = $node{0};
            }
        }
        else
        {
            // Expand the first tree if only one loaded
            $states = '';
            $roots = $this->tree->loadRoots($this->um->uid);
            $count = 0;

            foreach ($roots as $root)
            {
                if ($root->acl['allow_select'])
                {
                    $count++;
                }
            }

            if ($count==1)
            {
                foreach ( $roots as $root)
                {
                    if ($root->acl['allow_select'])
                    {
                        $nodes[$root->id] = 'Y';
                        break;
                    }
                }
            }
        }

        $states = '';
        foreach ($nodes as $node => $val)
        {
            if ($val == 'Y')
            {
                $states .= $val.$node.':';
            }
        }

        $this->um->setCookie($cookieName, $states.'!');

        return $nodes;
    }
}

/*** Run SiteBar Application **************************************************/

$sb = new Sitebar();
$sb->run();

/******************************************************************************/
