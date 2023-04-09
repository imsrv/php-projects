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

require_once('./inc/page.inc.php');

// If we have configuration and can load database class using it
if (file_exists('./inc/config.inc.php') && @include_once('./inc/database.inc.php'))
{
    $db = new Database(true);
    if ($db->connection)
    {
        require_once('./inc/usermanager.inc.php');
        $um = new UserManager();
        Skin::set($um->getParam('user','skin'));
    }
}

if (isset($_REQUEST['install']))
{
    $install = $_REQUEST['install'];

    $code     = '{3F218DFB-00FF-297C-4D54-57696C4A6F6F}';
    $title    = 'SiteBar';
    $url      = Page::baseurl().'/sitebar.php';
    $reg      = '';
    $filename = '';
    $ctxUrl   = Page::baseurl() . "/ctxmenu.php";

    if ($install)
    {
        $filename = "InstallSiteBar.reg";

        $reg = <<<__INSTALL
REGEDIT4

[HKEY_CLASSES_ROOT\\CLSID\\$code]
@="$title"

[HKEY_CLASSES_ROOT\\CLSID\\$code\\Implemented Categories]

[HKEY_CLASSES_ROOT\\CLSID\\$code\\Implemented Categories\\{00021493-0000-0000-C000-000000000046}]

[HKEY_CLASSES_ROOT\\CLSID\\$code\\InProcServer32]
@="Shdocvw.dll"
"ThreadingModel"="Apartment"

[HKEY_CLASSES_ROOT\\CLSID\\$code\\Instance]
"CLSID"="{4D5C8C2A-D075-11d0-B416-00C04FB90376}"

[HKEY_CLASSES_ROOT\\CLSID\\$code\\Instance\\InitPropertyBag]
"Url"="$url"

[-HKEY_CLASSES_ROOT\\Component Categories\\{00021493-0000-0000-C000-000000000046}\\Enum]

[-HKEY_CLASSES_ROOT\\Component Categories\\{00021494-0000-0000-C000-000000000046}\\Enum]

[HKEY_CURRENT_USER\\Software\\Microsoft\\Internet Explorer\\Explorer Bars\\$code]
"BarSize"=hex:B4
"Name"="$title"

[HKEY_CURRENT_USER\\Software\\Microsoft\\Internet Explorer\\MenuExt\\Add Link to SiteBar]
"Contexts"=dword:00000022
"Flags"=hex:01
@="$ctxUrl?add=link"

[HKEY_CURRENT_USER\\Software\\Microsoft\\Internet Explorer\\MenuExt\\Add Page to SiteBar]
"Contexts"=hex:01
"Flags"=hex:01
@="$ctxUrl?add=page"

[HKEY_LOCAL_MACHINE\\Software\\Microsoft\\Internet Explorer\\Extensions\\{23F5C49C-74DF-42BA-A194-FF92A3B59FED}]
"ButtonText" = "SiteBar"
"MenuText" = "SiteBar Panel"
"MenuStatusBar"="Display SiteBar Panel"
"Icon" = "%SystemRoot%\\\\system32\\\\SHELL32.dll,173"
"HotIcon" = "%SystemRoot%\\\\system32\\\\SHELL32.dll,173"
"CLSID" = "{E0DD6CAB-2D10-11D2-8F1A-0000F87ABD16}"
"BandCLSID" = "$code"
"Default Visible"="Yes"
__INSTALL;
    }
    else
    {
        $filename = "UnInstallSiteBar.reg";
        $reg = <<<__UNINSTALL
REGEDIT4

[-HKEY_CLASSES_ROOT\\CLSID\\$code]
[-HKEY_CURRENT_USER\\Software\\Microsoft\\Internet Explorer\\Explorer Bars\\$code]
[-HKEY_LOCAL_MACHINE\\Software\\Microsoft\\Internet Explorer\\Extensions\\{23F5C49C-74DF-42BA-A194-FF92A3B59FED}]
[-HKEY_CURRENT_USER\\Software\\Microsoft\\Internet Explorer\\MenuExt\\Add Link to SiteBar]
[-HKEY_CURRENT_USER\\Software\\Microsoft\\Internet Explorer\\MenuExt\\Add Page to SiteBar]
__UNINSTALL;
    }

    header("Content-type: application/octet-stream\n");
    header("Content-disposition: attachment; filename=\"$filename\"\n");
    header("Content-transfer-encoding: binary\n");
    header('Content-length: ' . strlen($reg));
    echo $reg;

    exit;
}

Page::head("The Bookmark Server for Personal and Team Use", "index");

// Include skin hook file
include_once(Skin::path().'/hook.php');

$bookmarklet = "void(window.open('" . Page::baseurl() . "/command.php" .
    "?command=Add%20Link".
    "&name='+escape(document.title)+'".
    "&url='+escape(location.href),'sitebar_gCmdWin', ".
    "'resizable=yes,dependent=yes,width=210,height=280,top=200,left=300,titlebar=yes,scrollbars=yes'))";

?>

<script type="text/javascript">
    function compatible(is, label)
    {
        document.write("<span class='compatible"+ (is?"Yes":"No") +"'>");
        document.write(label);
        document.write("</span>");
    }
</script>

<div id="launcher">

  <div>
    <div id="home">
      <a href="http://www.sitebar.org/"><img src="<?=Skin::imgsrc('logo')?>"></a>
      <br>
      [<a href="http://www.sitebar.org/">SiteBar Homepage</a>]
    </div>

    <div id="tip">
      This is the launching page for installation of SiteBar Bookmark Server.
      It is recommended to bookmark one of the links marked with "*" instead
      of bookmarking this page. This page can be opened from SiteBar window
      by clicking on the top logo.
    </div>
  </div>

  <div>

    <h2>SiteBar Installation & Launcher</h2>

    <table>
      <tr>
        <th><span class='compatibleYes'>Any Browser</span></th>
      </tr>
      <tr>
        <td>Use <a title="SiteBar" href="<?=Page::baseurl()?>/sitebar.php">SiteBar</a>*
            in this window - the most universal but least recommended option.
        </td>
      </tr>
      <tr>
        <td>Open in pop-up
            <a title="SiteBar"
            href="javascript:void(window.open('<?=Page::baseurl()?>/sitebar.php?target=_blank','_sb_pop_up','directories=no, height=600, width=220, left=0, top=0, scrollbars=yes, location=no, menubar=no, status=no, toolbar=no'))">
            SiteBar</a>-like* window.
        </td>
      </tr>
      <tr>
        <th>
            <script type="text/javascript">
                compatible(window.ActiveXObject && navigator.platform == 'Win32', "Internet Explorer 5+")
            </script>
        </th>
      </tr>
      <tr>
        <td><a href="?install=1">Install</a> / <a href="?install=0">Uninstall</a>
            to the Explorer Bar and context menu - requires Windows registry change
            and system restart for all features. Depending on your rights only
            some features might be installed.
            <p class='comment'>Open SiteBar Explorer Bar from menu View/Explorer Bar or
            use <b>Customize...</b> toolbars' function to get the SiteBar Panel toggle
            button shown on the toolbar. Right click anywhere on the page or over a link
            to add the page or link to the SiteBar.
            </p>
        </td>
      </tr>
      <tr>
        <td>
            Add
            <a title="SiteBar"
            href="javascript:void(_search=open('<?=Page::baseurl()?>/sitebar.php','_search'))">
            SiteBar</a>*
            temporarily to the Search Explorer Bar.
            <p class='comment'>Use when you do not have enough rights to use Installer above.</p>
        </td>
      </tr>
      <tr>
        <th>
            <script type="text/javascript">
                compatible(window.sidebar && window.sidebar.addPanel, "Mozilla 1+ / Netscape 6+")
            </script>
        </th>
      </tr>
      <tr>
        <td>Add to a Mozilla/Netscape compatible
            <a title="SiteBar"
            href="javascript:sidebar.addPanel('SiteBar','<?=Page::baseurl()?>/sitebar.php','')">
            sidebar</a> - toggle display using F9.
            <p class='comment'>Mozilla Firebird users should use the link above to create bookmark
            that opens in sidebar when clicked.
            </p>
        </td>
      </tr>
      <tr>
        <th>
            <script type="text/javascript">
                compatible(window.opera && window.print, "Opera 6+")
            </script>
        </th>
      </tr>
      <tr>
        <td>
            Add to Opera's <a title="SiteBar" rel="sidebar" href="<?=Page::baseurl()?>/sitebar.php">Hotlist</a>
            as sidebar.
            <p class='comment'>Use Ctrl+click instead of Right+click to display folder or link context menu.</p>
        </td>
      </tr>
    </table>

    <h2>Content Bookmarklets</h2>

    <table>
      <tr>
        <th>Bookmarklet</th>
      </tr>
      <tr>
        <td>
            <a href="javascript:<?=$bookmarklet?>">Add Page to SiteBar</a>* - add a link to the
            the current web page to any of folders the user has 'Add' rights to. MS IE users can
            use installer and context menu instead.
        </td>
      </tr>
    </table>

    <table class='sponsor'>
      <tr>
        <td><? Hook::sponsor() ?></td>
      </tr>
    </table>

  </div>
</div>

<div id="trailer">
Copyright (C) 2003 <a href='mailto:sitebar@brablc.com'>Ondrej Brablc</a>
&lt;<a href='http://brablc.com/'>http://brablc.com</a>&gt; and <a href='mailto:dszego@mindslip.com'>David Szego</a>
&lt;<a href='http://www.mindslip.com'>http://www.mindslip.com</a>&gt;.
</div>

<?
Page::foot();
?>
