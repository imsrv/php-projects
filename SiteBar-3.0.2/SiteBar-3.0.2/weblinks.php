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

/*
    Error codes:

*/

define("WL_ERR_WRONG_LOGIN", "**05Wrong user name or password\n");
define("WL_ERR_FATAL_ERROR", "**06Fatal error\n");
define("WL_OK_SUCCESS",      "++00Sucess\n");

header("Content-Type: text/plain");

if (@!include_once('./inc/config.inc.php'))
{
    echo WL_ERR_FATAL_ERROR;
    exit;
}

require_once('./inc/page.inc.php');
require_once('./inc/tree.inc.php');
require_once('./inc/usermanager.inc.php');

class WebLinks
{
    var $um;
    var $tree;
    var $nodes = array();
    var $path = '';

    function WebLinks()
    {
        $this->um = UserManager::staticInstance();
        $this->tree = new Tree();
    }

    function run()
    {
        if (!$this->um->setupDone)
        {
            echo WL_ERR_FATAL_ERROR;
            exit;
        }

        echo WL_OK_SUCCESS;
        echo "0|flags|:: SiteBar Commander ::\n";
        echo "0/0|flags|Web Interface||".Page::baseurl()."/sitebar.php\n";

        if ($this->um->isAnonymous())
        {
            $this->drawSiteBarCommand("Log In");
            $this->drawSiteBarCommand("Sign Up");
        }
        else
        {
            $this->drawSiteBarCommand("Add Link", "+'&name='+escape(document.title)+'&url='+escape(location.href)");
            $this->drawSiteBarCommand("Log Out");
        }

        foreach ($this->tree->loadRoots() as $root)
        {
            // Just in case incremental display is possible
            // do delayed links loading.
            $this->tree->loadNodes($root, false);
            $this->drawNode($root);
        }
    }

    function drawSiteBarCommand($command, $add='')
    {
        static $count = 1;
        static $fmt = null;

        if (!$fmt)
        {
            $fmt = "0/%s|flags|%s||javascript:void(window.open('%s/command.php?command=%s&weblinks=yes'%s,'sitebar_gCmdWin', 'resizable=yes,dependent=yes,width=210,height=280,top=200,left=300,titlebar=yes,scrollbars=yes'))";
        }

        echo sprintf($fmt, $count++, $command, Page::baseurl(), $command, $add) . "\n";
    }

    function drawNode($node)
    {
        array_push($this->nodes, $node->id);
        $this->path = implode('/', $this->nodes);

        $this->write(array
        (
            $this->path,
            'flags',
            $node->name
        ));

        foreach ($node->getNodes() as $childNode)
        {
            $this->drawNode($childNode);
        }

        $this->path = implode('/', $this->nodes);
        $this->drawLinks($node);
        array_pop($this->nodes);
        return true;
    }

    function drawLinks($node)
    {
        $this->tree->loadLinks($node);
        foreach ($node->getLinks() as $link)
        {
            $this->write(array
            (
                $this->path.'/'.$link->id,
                'flags',
                $link->name,
                '',
                $link->url
            ));
        }
    }

    function write($arr)
    {
        $str = implode('|', $arr);
        echo utf8_decode($str) . "\n";
    }
}

/*** Run WebLinks Application **************************************************/

$wl = new WebLinks();
$wl->run();

/******************************************************************************/
