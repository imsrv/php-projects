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

/*** Global variables *********************************************************/

// Skin directory
var gSkinDir = null;

// Tagret for links
var gTarget = null;

// Currently selected context menu
var gCtxMenu = null;

// Semaphore for ignoring bubbling of eventsusing timers
var gIgnore = 0;

// Timer for hiding context menu
var gHideTimer = null;

// Object reference of the right clicked object
var gTargetID = null;

// ID to be copied or moved
var gSourceID = null;

// ID of the dragged object
var gDraggedID = null;

// Saved color
var gDraggingStyleBG = null;
var gDraggingStyleFG = null;

// Is source node? If not it is link.
var gSourceTypeIsNode = null;

// Global variable to focus already opened window
var gCmdWin = null;

// Should external window be used?
var gAutoReload = true;

// In place commands
var gInPlaceCommands = new Array();

// Index of last found link
var gLastFound = -1;

// Previous opened parent - optimization
var gPrevParent = null;

// Last search term
var gLastSearch = null;

// Search type
var gSearchType = null;


// Saved state of nodes
var gState = null;

/*** Autoload *****************************************************************/

function getCookie(name, defaultValue)
{
    var index = document.cookie.indexOf(name + "=");
    if (index == -1)
    {
        return defaultValue;
    }
    index = document.cookie.indexOf("=", index) + 1; // first character
    var endstr = document.cookie.indexOf(";", index);

    if (endstr == -1)
    {
        endstr = document.cookie.length; // last character
    }
    return unescape(document.cookie.substring(index, endstr));
}

gState = getCookie('SB3NODES','!');

/*** Toolbar functions ********************************************************/

/**
 * Search for text
 */
function search(event, highlight)
{
    var fld  = document.getElementById('fldSearch');
    var text = fld.value;
    var type = "name";

    if (text.length==0)
    {
        return false;
    }

    // Check search pattern
    var reST = new RegExp("^(url|desc|name|all):(.*)$");
    if (text.match(reST))
    {
        type = RegExp.$1;

        // If we have pattern then use it
        if (type == 'url'
        ||  type == 'desc'
        ||  type == 'name'
        ||  type == 'all')
        {
            text = RegExp.$2;
        }
    }

    var className = 'highlight';

    if (text != gLastSearch)
    {
        gLastFound = -1;
        gLastSearch = text;
    }
    else
    {
        className = '';
    }

    var links = document.getElementsByTagName('a');
    var re = new RegExp(text,"i")

    var found = false;
    for (var i = gLastFound+1; i<links.length; i++)
    {
        var name = getLinkName(links[i]);
        var url = links[i].getAttribute('href');
        var desc = links[i].getAttribute('title');

        var isFolder = (url=='javascript:void(0)');

        var subject = '';

        if (type=='url'  || type=='all') subject += url;
        if (type=='name' || type=='all') subject += name;
        if (type=='desc' || type=='all') subject += desc;

        if (subject)
        {
            if (subject.match(re))
            {
                found = true;

                openParents(links[i].parentNode.parentNode.parentNode);

                links[i].focus();
                links[i].className = className;

                if (!highlight)
                {
                    if (!confirm(
                        (isFolder?"Folder":"Link") + " Found\n" +
                        (isOpera?'':"\n")+
                        "Name: " + name +"\n"+
                        (type=='desc' || isFolder
                        ? (desc?"Desc: " + desc +  "\n":'')
                        : "URL: " + url + "\n") +
                        (isOpera?'':"\n")+
                        "Find next?"))
                    {
                        gLastFound = i;
                        break;
                    }
                    else
                    {
                        found = false;
                    }
                }
            }
            else
            {
                links[i].className = '';
            }
        }
    }

    if (!found)
    {
        alert('Not found!');
        gLastFound = -1;
        gPrevParent = null;
    }
}

/**
 * Highlight links with matching name or URL
 */
function highlight(event)
{
    search(event, true);
}

/**
 * For search functions: opens all parent folders
 */
function openParents(parentNode)
{
    if (gPrevParent == parentNode)
    {
        return;
    }

    gPrevParent = parentNode;

    var obj = parentNode;
    while (obj && obj.getAttribute('x_level')!=null
        && obj.getAttribute('x_level')!='') // For Opera
    {
        node(false, obj, true);
        obj = obj.parentNode.parentNode;
    }
}

/**
 * For search functions: returns name of the link (ignores leading image)
 */
function getLinkName(linkTag)
{
    var html = linkTag.innerHTML.split('>',2);

    if (html.length==2)
    {
        return html[1];
    }

    return null;
}

/**
 * Reload sitebar keeping images in cache
 */
function reloadPage(cancelled)
{
    location.href='sitebar.php?reload=yes' +
        (gTarget?'&target='+gTarget:'') +
        (!cancelled?'&uniq=' + (new Date()).valueOf():'');
}

/**
 * Collapse all nodes
 */
function collapseAll(event)
{
    if (event.ctrlKey)
    {
        expandAll(event);
        return;
    }

    divs = document.getElementsByTagName('div');
    for (var i=0; i<divs.length; i++)
    {
        div = divs[i];
        level = div.getAttribute('x_level');
        if (level!=null && level!='') // '' for Opera
        {
            node(null, div, false, true);
        }
    }

    gState = '!';
    saveCookie(gState);
}


/**
 * Collapse all nodes
 */
function expandAll(event)
{
    divs = document.getElementsByTagName('div');
    for (var i=0; i<divs.length; i++)
    {
        div = divs[i];
        level = div.getAttribute('x_level');
        if (level!=null && level!='') // '' for Opera
        {
            node(null, div, true);
        }
    }
}

/**
 * Change CSS style
 */
function changeCSS(myclass,element,value)
{
    var CSSRules;

    if (document.all)
    {
        CSSRules = 'rules'
    }
    else if (document.getElementById)
    {
        CSSRules = 'cssRules'
    }

    for (var i = 0; i < document.styleSheets[0][CSSRules].length; i++)
    {
        var rule = document.styleSheets[0][CSSRules][i];

        if (rule.selectorText.toUpperCase() == myclass.toUpperCase())
        {
            var oldValue = rule.style[element];
            if (value)
            {
                rule.style[element] = value;
            }
            return oldValue;
        }
    }
}

/*** Drag & Drop **************************************************************/

function changeStyleForDragging(dragging)
{
    var style = "div.tree a:hover";

    if (dragging)
    {
        bg = changeCSS(style + " .selected", 'background');
        fg = changeCSS(style + " .selected", 'color');
        gDraggingStyleBG = changeCSS("div.tree a:hover", 'background', bg);
        gDraggingStyleFG = changeCSS("div.tree a:hover", 'color', fg);
    }
    else
    {
        changeCSS(style, 'background', gDraggingStyleBG);
        changeCSS(style, 'color', gDraggingStyleFG);
    }
}

function nodeDrag(event, id)
{
    if (event.button == 2 || gDraggedID != null)
    {
        return false;
    }

    changeStyleForDragging(true);
    gDraggedID = id;
    gSourceTypeIsNode = true;
    return false;
}

function linkDrag(event, id)
{
    if (event.button == 2 || gDraggedID != null)
    {
        return false;
    }

    changeStyleForDragging(true);
    gDraggedID = id;
    gSourceTypeIsNode = false;
    return false;
}

function cancelDragging()
{
    if (gDraggedID!=null)
    {
        changeStyleForDragging(false);
        gDraggedID = null;
    }
}

function nodeDrop(event, id, linkID)
{
    if (id == gDraggedID || (!gSourceTypeIsNode && linkID && linkID == gDraggedID))
    {
        return true;
    }

    if (event.button == 2 || gDraggedID == null)
    {
        return false;
    }

    stopIt(event);
    gSourceID = gDraggedID;
    cancelDragging();
    commandWindow("Paste", id);
    return false;
}

/*** Image preloading *********************************************************/

/**
 * Preload images - necessary for Internet Explorer otherwise
 * some image is always somehow missing.
 * Does not harm any other browser. Function setImgDir is called
 * just after this script is included on the page.
 */

function setSkinDir(skindir)
{
    gSkinDir = skindir;

    var images = Array
    (
        'collapse',
        'connect',
        'empty',
        'highlight',
        'join',
        'join_last',
        'link',
        'link_private',
        'menu',
        'minus',
        'minus_last',
        'node',
        'node_open',
        'plus',
        'plus_last',
        'reload',
        'root',
        'root_deleted',
        'root_plus'
    );

    /**
     * This is called when the script is loaded automatically.
     */
    for (i=0; i<images.length; i++)
    {
        img = new Image();
        img.src = imgPath(images[i]);
    }
}

function imgPath(basename)
{
    return gSkinDir + '/' + basename + '.png';
}

/*** Commander functions ******************************************************/

function initCommander()
{
    var field = document.getElementById('focused');
    if (field)
    {
        field.focus();
    }
}

/*** Tree collapsing/expanding ************************************************/

function initPage(autoReload, inPlaceCommands)
{
    gAutoReload = autoReload;
    gInPlaceCommands = inPlaceCommands;
}

/**
 * When a div is clicked this event becomes all its parent, however, the
 * the innermost is the first. We increader ignore semaphore and schedule
 * its zeroing after 10 milliseconds. Any subsequent call of stopIt will
 * return false before it is zeroied.
 */
function stopIt(event)
{
    // If event not filled then user initiated action which should
    // not be stopped.
    if (!event) return false;

    gIgnore++;
    if (gIgnore>1) return true;

    setTimeout("gIgnore=0;",10);
    return false;
}

/**
 * Renew the event - for Opera Ctrl+click.
 */
function renewIt(event)
{
    gIgnore=0;
}

/**
 * If the base is not content is must be changed to main, what is most likely
 * Internet Explorer and works in Opera.
 */
function hasTargetWindow( name)
{
    return name=="_content" && window.sidebar && window.sidebar.addPanel;
}

/**
 * When a menu should be shown on link when using Ctrl click
 */
function isOpera()
{
    return window.opera && window.print;
}

/**
 * Save state of certain node
 */
function saveState(id, state)
{
    gState = (state?'Y':'N')+id+':'+gState;
    saveCookie(gState);
}

/**
 * Save global state cookie
 */
function saveCookie(value)
{
    expires = new Date(new Date().getTime()+1000*60*60*24*7).toGMTString();
    document.cookie = 'SB3NODES='+value+'; expires=' + expires;
}

/**
 * Toggle display of any div referenced as object
 */
function toggleDiv( div, show )
{
    if (show!=null)
    {
        div.style.display = (show?'block':'none');
        return show;
    }

    if (div.style.display=='')
    {
        if (div.className.indexOf('Expanded')>-1)
        {
            div.style.display = 'block';
        }
        if (div.className.indexOf('Collapsed')>-1)
        {
            div.style.display = 'none';
        }
    }

    div.style.display = (div.style.display=='block'?'none':'block');
    return (div.style.display=='block');
}

/**
 * Activated on click on node (folder). Changes + and - sign according to
 * current state.
 */
function node(event, obj, show, noSaveState)
{
    if (stopIt(event)) return false;

    menuOff();
    cancelDragging();

    if (event)
    {
        if (event.ctrlKey)
        {
            renewIt(event);
            menuOn(event, obj);
            return false;
        }
    }

    var id = obj.id.substr(1);
    var simg = document.getElementById('is' + id);
    var nimg = document.getElementById('in' + id);
    var children = document.getElementById('c' + id);

    var root = obj.getAttribute('x_level')=='0';
    var opened = toggleDiv(children, show);

    if (!noSaveState)
    {
        saveState(id, opened);
    }

    if (root)
    {
        var deleted = obj.getAttribute('x_acl').indexOf('*')==-1;
        var links = children.getElementsByTagName('a');
        nimg.src = imgPath( (opened||!links.length
            ?'root'+(deleted?'_deleted':''):'root_plus'));
    }
    else if (simg)
    {
        var last = (simg.src.indexOf("_last.png")>-1);
        simg.src = imgPath( (opened?'minus':'plus') + (last?'_last':""));
        nimg.src = imgPath( 'node' + (opened?'_open':""));
    }
}

/**
 * Ctrl link in Opera substitutes right click.
 */
function lnk(event,obj)
{
    cancelDragging();

    if (event.ctrlKey && isOpera())
    {
        menuOn(event, obj);
        return false;
    }
    else
    {
        stopIt(event);
        return true;
    }
}

/*** Context menu functionality ***********************************************/

/**
 * Called on right click on nodes or items
 */
function menuOn(event, obj)
{
    if (stopIt(event)) return false;
    cancelDragging();

    // Store reference in the global variable
    gTargetID = obj;

    var menuDIV = (obj.id.charAt(0)=='n'?'node':'link');
    gCtxMenu = document.getElementById(menuDIV+'CtxMenu');

    // Hide the other contex menu
    hideMenus(gCtxMenu);

    var topOffset = document.documentElement.scrollTop;
    if (!topOffset)
    {
        topOffset = document.body.scrollTop;
    }

    gCtxMenu.style.top = event.clientY - 0 + topOffset;
    gCtxMenu.style.left = event.clientX - 0;

    gCtxMenu.style.display = 'block';

    // Get ACL for node
    var nodeACL = obj.getAttribute("x_acl");

    // Set initial state of all items in the context menu
    for (var i=0;;i++)
    {
        menuItem = document.getElementById(menuDIV+'Item'+i);
        if (!menuItem) break;

        // If not separator then set off or disable
        if (menuItem.className!='separator')
        {
            var commandACL = menuItem.getAttribute("x_acl");
            var commandSPEC = null;

            var arr = commandACL.split('_');
            var disabled = false;

            if (arr.length>1)
            {
                commandACL = arr[0];
                commandSPEC = arr[1];
            }

            // Each command might require some rights, for each letter
            // in the command ACL there must be a letter in the node
            // otherwise the command is disabled
            for (j=0; j<commandACL.length; j++)
            {
                if (nodeACL.indexOf(commandACL.charAt(j))==-1)
                {
                    disabled = true;
                    break;
                }
            }

            if (!disabled && commandSPEC)
            {
                switch (commandSPEC)
                {
                    case 'c':
                        disabled = !(gSourceID);
                        break;
                }
            }

            menuItem.className = 'off';
            if (disabled)
            {
                menuItem.className = 'disabled';
            }
        }
    }

    return false;
}

/**
 * When the item is left this is called to show parent menu.
 */
function menuOff()
{
    gHideTimer = null;
    hideMenus(null);
    gCtxMenu = null;
}

/**
 * Hide all context menus, ignore the one passed as object reference
 */
function hideMenus(ignore)
{
    menus = Array('node','link');
    for (var i=0; i<menus.length; i++)
    {
        menu = document.getElementById(menus[i]+'CtxMenu');
        if (menu != ignore)
        {
            menu.style.display = 'none';
        }
    }
}

/**
 * Activated on mouseover on the item in context menu
 */
function itemOn(item)
{
    // If we have popup menu
    if (gCtxMenu)
    {
        // And its hiding was scheduled
        if (gHideTimer)
        {
            // Stop it
            clearTimeout(gHideTimer);
            gHideTimer = null;
        }
        else
        {
            // Display menu
            gCtxMenu.style.display = 'block';
        }
    }

    toggleItem(item, true);
}

/**
 * Activated on mouse off
 */
function itemOff(item)
{
    gHideTimer = setTimeout('menuOff()', 1000);
    toggleItem(item, false);
}

/**
 * Toggles state of the context menu item
 */
function toggleItem(item, show)
{
    if (item.className.charAt(0) == 'o')
    {
        item.className = show?'on':'off';
        return true;
    }
    return false;
}

/**
 * Activated on click on the context menu item
 */
function itemDo(item, func)
{
    menuOff();
    var nid = null;
    var lid = null;
    var id  = null;

    if (gTargetID)
    {
        id = gTargetID.id.substr(1);
        if (gTargetID.id.charAt(0)=='n')
        {
            nid = id;
        }
        else
        {
            lid = id;
        }
    }

    if (func)
    {
        eval(func+'(id)');
    }
    else
    {
        commandWindow(item.innerHTML, nid, lid);
    }
}

/**
 * Called on node Copy command
 */
function nodeCopy(nid)
{
    gSourceID = nid;
    gSourceTypeIsNode = true;
}

/**
 * Called on node Copy command
 */
function linkCopy(lid)
{
    gSourceID = lid;
    gSourceTypeIsNode = false;
}

/**
 * Sets target for links
 */
function setLinkTarget(target)
{
    gTarget = (target.length>0?target:null);
}

/**
 * Open control window
 */
function commandWindow(command, nid, lid)
{
    uri = "command.php?command=" + command +
        (gTarget?"&target="+gTarget:"") +
        (nid?"&nid_acl="+nid:"") +
        (lid?"&lid_acl="+lid:"") +
        (gSourceID?"&sid="+gSourceID+"&stype="+(gSourceTypeIsNode?"1":"0"):"");

    inPlaceCommand = false;
    for (var i=0; i<gInPlaceCommands.length; i++)
    {
        if (command == gInPlaceCommands[i])
        {
            inPlaceCommand = true;
            break;
        }
    }

    if (!gAutoReload && !inPlaceCommand)
    {
        winPrefs = "resizable=yes,dependent=no,"+
            "width=210,height=280,top=200,left=300,titlebar=yes,scrollbars=yes";
        if (gCmdWin && !gCmdWin.closed) gCmdWin.focus();
        gCmdWin = window.open(uri, 'sitebar_gCmdWin', winPrefs);
        gCmdWin.focus();
        gSourceID = null;
    }
    else
    {
        location.href=uri;
    }
}
