<?php
$digiAdsPath = '/path/to/digi-ads/ads.dat';
require '/path/to/digi-ads/ads.inc.php';

///////////////////////////////////////
// Don't Edit Anything Below This Line!
///////////////////////////////////////

if ($action == 'auth') {
    auth();
}
if (($HTTP_COOKIE_VARS['user'] != $digiAds['user']) && ($HTTP_COOKIE_VARS['pass'] != $digiAds['pass'])) {
    login();
    exit;
}
if ($action == 'config') {
    config();
} else if ($action == 'list') {
    view();
} else if ($action == 'edit') {
    edit();
} else if ($action == 'add') {
    add();
} else if ($action == 'logout') {
    logout();
} else {
    menu();
}
function dateselect($name, $date)
{
    global $digiAdsTime;
    $month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    if($date == '99999999') {
        $date = $digiAdsTime;
    }
    $m = date('n', $date);
    $d = date('j', $date);
    $y = date('Y', $date);
    $output = '<select name=' .$name. '_month>';
    for ($i = 0; $i < 12; $i++) {
        $j = $i + 1;
        $s = '';
        if ($j == $m) {
            $s = 'selected';
        }
        $output .= '<option ' .$s. ' value=' .$j. '>' .$month[$i];
    }
    $output .= '</select> <select name=' .$name. '_day>';
    for ($i = 1; $i < 32; $i++) {
        $s = '';
        if ($i == $d) {
            $s = 'selected';
        }
        $output .= '<option ' .$s. ' value=' .$i. '>' .$i;
    }
    $output .= '</select> <select name=' .$name. '_year>';
    for ($i = 2001; $i < 2021; $i++) {
        $s = '';
        if ($i == $y) {
            $s = 'selected';
        }
        $output .= '<option ' .$s. ' value=' .$i. '>' .$i;
    }
    $output .= '</select>';
    return $output;
}
function head($title)
{
    echo '<html><head><title>digi-ads - admin - ' .$title. '</title></head><body bgcolor=#ffffff><center><font face="Verdana, Helvetica" size=+3>digi-ads</font><br><font face="Verdana, Helvetica" size=2><b>' .$title. '</b></font><p><table width=550 border=0 cellspacing=2 cellpadding=2><tr><td>';
}
function foot()
{
    echo '</td></tr></table></center><p><center><hr width=550><font face="Verdana, Helvetica" size=1><a href=admin.php?action=config>Configuration</a> | <a href=admin.php?action=list>List Ads</a> | <a href=admin.php?action=add>Add Ad</a> | <a href=admin.php?action=logout>Logout</a><p>digi-ads 1.0 &copy; 2001 <a href=http://www.digi-fx.net>digi-FX</a></font></center></body></html>';
}
function auth()
{
    global $user, $pass, $digiAds;
    if (($user != $digiAds['user']) || ($pass != $digiAds['pass'])) {
        login('Invalid Login or Password');
        exit;
    }
    setcookie('user', $user);
    setcookie('pass', $pass);
    menu();
}
function login($msg = '')
{
    head('Authorization Required');
    if ($msg != '') {
        echo '<font face="Verdana, Helvetica" color=#ff000 size=2><b>' .$msg. '</b></font><p>';
    }
    echo '<font face="Verdana, Helvetica" size=2>You must login to access the control panel. Please provide your login name and password below. NOTE: Cookies must be enabled to use this control panel.</font><form method=post action=admin.php><input type=hidden name=action value=auth><font face="Verdana, Helvetica" size=2><b>Login Name:</b></font> <input type=text name=user><br><font face="Verdana, Helvetica" size=2><b>Password:</b></font> <input type=password name=pass><br><input type=submit value=Login></form>';
    foot();
}
function menu()
{
    head('Main Menu');
    echo '<font face="Verdana, Helvetica" size=2>If this is your first visit to the control panel, please choose configuration; otherwise, please choose from the following options:<ul><li><a href=admin.php?action=config>Configuration</a></li><li><a href=admin.php?action=list>List Ads</a></li><li><a href=admin.php?action=add>Add Ad</a></li><li><a href=admin.php?action=logout>Logout</a></li></ul>';
    foot();
    exit;
}
function config()
{
    global $save, $cancel, $newlogin, $newpass, $url, $target, $border, $digiAds;
    if ($save) {
        $digiAds['user'] = $newlogin;
        if ($newpass != '**********') {
            $digiAds['pass'] = $newpass;
        }
        $digiAds['url'] = $url;
        $digiAds['target'] = $target;
        $digiAds['border'] = $border;
        writeads();
        menu();
    } else if ($cancel) {
        menu();
    } else {
        head('Configuration');
        echo '<font face="Verdana, Helvetica" size=2>You can change any of the following properties. It\'s recommended that you don\'t edit ads.dat directly.</font><hr width=550><form method=post action=admin.php><input type=hidden name=action value=config><font face="Verdana, Helvetica" size=2><li><b>Login and Password</b></li><p>To change your login name and password, fill them in below; otherwise, leave the following alone.</font><p><font face="Verdana, Helvetica" size=2>Login Name:</font> <input type=text name=newlogin value="' .$digiAds['user']. '"><br><font face="Verdana, Helvetica" size=2>Password:</font> <input type=password name=newpass value="**********"><hr width=550><font face="Verdana, Helvetica" size=2><li><b>URL</b></li><p>This is the exact URL to the click.php script. This is where the user is taken to when they click on an ad. It then logs the click and forwards them to the appropriate web site.</font><p><font face="Verdana, Helvetica" size=2>URL:</font> <input type=text name=url value="' .$digiAds['url']. '"><hr width=550><font face="Verdana, Helvetica" size=2><li><b>Target</b></li><p>This lets you specify the target attribute of all links. To open ads in a new window set the target value to &quot;_blank&quot; (without the quotes). If you don\'t want or need a target, leave this field empty.</font><p><font face="Verdana, Helvetica" size=2>Target:</font> <input type=text name=target value="' .$digiAds['target']. '"><hr width=550><font face="Verdana, Helvetica" size=2><li><b>Border</b></li><p>This sets the amount of border, in pixels, around an ad. Set this to 0 for no border.</font><p><font face="Verdana, Helvetica" size=2>Border:</font> <select name=border>';
        for ($i = 0; $i <= 5; $i++) {
            if ($digiAds['border'] == $i) {
                $sel = ' selected';
            } else {
                $sel = '';
            }
            echo '<option value=' .$i.$sel. '>' .$i;
        }
        echo '</select><p><input type=submit name=save value=Save> <input type=submit name=cancel value=Cancel>';
        foot();
    }
}
function view()
{
    global $ads;
    head('All Ads');
    echo '<table border=1 cellspacing=0 cellpadding=1><tr><td nowrap><font face="Verdana, Helvetica" size=1><b>Name (ID):</b></font></td><td><font face="Verdana, Helvetica" size=1><b>Link URL:</b></font></td><td><font face="Verdana, Helvetica" size=1><b>Image URL:</b></font></td><td><font face="Verdana, Helvetica" size=1><b>Enabled:</b></font></td><td><font face="Verdana, Helvetica" size=1><b>Weight:</b></font></td><td><font face="Verdana, Helvetica" size=1><b>Expires:</b></font></td><td><font face="Verdana, Helvetica" size=1><b>Remaining:</b></font></td><td><font face="Verdana, Helvetica" size=1><b>Impressions:</b></font></td><td><font face="Verdana, Helvetica" size=1><b>C/T:</b></font></td></tr>';
    foreach ($ads as $ad) {
        $data = explode('||', $ad);
        $enabled = $data[1] ? 'Yes' : 'No';
        if($data[3] == '99999999') {
            $expires = 'Never';
        } else {
            $expires = date('m/d/y', $data[3]);
        }
        if ($data[4] == -1) {
            $remaining = 'Unlimited';
        } else {
            $remaining = $data[4];
        }
        echo "<tr><td><font face=\"Verdana, Helvetica\" size=1><a href=admin.php?action=edit&id=$data[0]>$data[11] ($data[0])</a></font></td><td><font face=\"Verdana, Helvetica\" size=1><a href=$data[9]>$data[9]</a></td><td><font face=\"Verdana, Helvetica\" size=1><a href=$data[10]>$data[10]</a></td><td><font face=\"Verdana, Helvetica\" size=1>$enabled</td><td><font face=\"Verdana, Helvetica\" size=1>$data[2]</font></td><td><font face=\"Verdana, Helvetica\" size=1>$expires</font></td><td><font face=\"Verdana, Helvetica\" size=1>$remaining</font></td><td><font face=\"Verdana, Helvetica\" size=1>$data[5] </font></td><td><font face=\"Verdana, Helvetica\" size=1>$data[6]</font></td></tr>";
    }
    echo '<table>';
    foot();
}
function edit()
{
    global $id, $save, $delete, $cancel, $ad_name, $ad_en, $ad_link, $ad_image, $ad_width, $ad_height, $ad_weight, $ad_reset, $ad_remain, $ad_noexpires, $ad_expires_month, $ad_expires_day, $ad_expires_year, $confirm_delete, $ads;
    if (!$id) {
        die('No Ad ID was Specified');
    }
    if ($save) {
        for ($i = 0; $i < count($ads); $i++) {
            if(ereg("^$id\|\|", $ads[$i])) {
                $data = explode('||', $ads[$i]);
                if ($ad_en == 1) {
                    $data[1] = 1;
                } else {
                    $data[1] = 0;
                }
                if ($ad_reset == 1) {
                    $data[5] = 0;
                    $data[6] = 0;
                }
                if ($ad_noexpires == 1) {
                    $data[3] = '99999999';
                } else {
                    $data[3] = mktime(0, 0, 0, $ad_expires_month, $ad_expires_day, $ad_expires_year);
                }
                $data[2] = $ad_weight;
                $data[4] = $ad_remain;
                $data[7] = $ad_width;
                $data[8] = $ad_height;
                $data[9] = $ad_link;
                $data[10] = $ad_image;
                $data[11] = $ad_name;
                $ads[$i] = join('||', $data);
                break;
            }
        }
        writeads();
        menu();
    } else if ($delete) {
        if(!$confirm_delete == 1) {
            die('You didn\'t confirm the delete.');
        }
        foreach ($ads as $ad) {
            if(!ereg("^$id\|\|", $ad)) {
                $nads[] = $ad;
            }
        }
        $ads = $nads;
        writeads();
        menu();
    } else if ($cancel) {
        menu();
    } else {
        foreach ($ads as $ad) {
            if(ereg("^$id\|\|", $ad)) {
                $data = explode('||', $ad);
                break;
            }
        }
        if (!$data) {
            die("Ad ID $id was not found");
        }
        if ($data[1] == 1) {
            $isen = 'checked';
        }
        $expires = dateselect('ad_expires', $data[3]);
        if ($data[3] == '99999999') {
            $noexpires = 'checked';
        }
        head('Edit Ad');
        echo '<font face="Verdana, Helvetica" size=2>You can edit any of the following properties for Ad ID ' .$id. ':</font><form method=post action=admin.php><input type=hidden name=action value=edit><input type=hidden name=id value=' .$id. '><table width=550 border=1 cellspacing=0 cellpadding=1><tr><td><font face="Verdana, Helvetica" size=2><b>Ad Name:</b></font></td><td><input type=text name=ad_name value="' .$data[11]. '" size=30></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Is Enabled?</b></font></td><td><input type=checkbox ' .$isen. ' name=ad_en value=1> <font face="Verdana, Helvetica" size=2>Ad is Enabled</font></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Link URL:</b></font></td><td><input type=text name=ad_link value="' .$data[9]. '" size=30></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Image URL:</b></font></td><td><input type=text name=ad_image value="' .$data[10]. '" size=30></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Image Width:</b></font></td><td><input type=text name=ad_width value="' .$data[7]. '" size=4></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Image Height:</b></font></td><td><input type=text name=ad_height value="' .$data[8]. '" size=4></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Weight:</b></font></td><td><input type=text name=ad_weight value="' .$data[2]. '" size=4></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Impressions:</b> ' .$data[5]. '&nbsp;<b>C/T:</b> ' .$data[6]. '</font></td><td><input type=checkbox name=ad_reset value=1> <font face="Verdana, Helvetica" size=2>Reset to Zero</font></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Impressions Remaining:</b></font><br><font face="Verdana, Helvetica" size=1>Set to <b>-1</b> for unlimited</font></td><td><input type=text name=ad_remain value="' .$data[4]. '" size=4></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Expires:</b></font></td><td>' .$expires. ' <input type=checkbox name=ad_noexpires ' .$noexpires. ' value=1> <font face="Verdana, Helvetica" size=2>Never Expires</font></td></tr></table><br><center><input type=submit name=save value=Save> <input type=submit name=cancel value=Cancel><p><input type=checkbox name=confirm_delete value=1> <font face="Verdana, Helvetica" size=2>Check to Confirm Delete</font><br><input type=submit name=delete value="Delete This Ad"><br><br><br><font face="Verdana, Helvetica" size=1>Ad Preview:</font><br><a href=' .$data[9]. ' target=_blank><img src=' .$data[10]. ' alt="' .$data[11]. '" width=' .$data[7]. ' height=' .$data[8]. ' border=0></a></center></form>';
        foot();
    }
}
function add()
{
    global $save, $cancel, $ad_name, $ad_en, $ad_link, $ad_image, $ad_width, $ad_height, $ad_weight, $ad_remain, $ad_noexpires, $ad_expires_month, $ad_expires_day, $ad_expires_year, $ads;
    if ($save) {
        $data[0] = 0;
        foreach ($ads as $ad) {
            ereg("^([0-9]+)\|\|", $ad, $j);
            $j[0] = str_replace('||', '', $j[0]);
            if ($j[0] > $data[0]) {
                $data[0] = $j[0];
            }
        }
        $data[0]++;
        if ($ad_en == 1) {
            $data[1] = 1;
        } else {
            $data[1] = 0;
        }
        $data[2] = $ad_weight;
        if ($ad_noexpires == 1) {
            $data[3] = '99999999';
        } else {
            $data[3] = mktime(0, 0, 0, $ad_expires_month, $ad_expires_day, $ad_expires_year);
        }
        $data[4] = $ad_remain;
        $data[5] = 0;
        $data[6] = 0;
        $data[7] = $ad_width;
        $data[8] = $ad_height;
        $data[9] = $ad_link;
        $data[10] = $ad_image;
        $data[11] = $ad_name;
        $ads[] = join('||', $data);
        writeads();
        menu();
    } else if ($cancel) {
        menu();
    } else {
        $expires = dateselect('ad_expires', '99999999');
        head('Add Ad');
        echo '<form method=post action=admin.php><input type=hidden name=action value=add><table width=550 border=1 cellspacing=0 cellpadding=1><tr><td><font face="Verdana, Helvetica" size=2><b>Ad Name:</b></font></td><td><input type=text name=ad_name value="New Ad" size=30></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Is Enabled?</b></font></td><td><input type=checkbox checked name=ad_en value=1> <font face="Verdana, Helvetica" size=2>Ad is Enabled</font></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Link URL:</b></font></td><td><input type=text name=ad_link value="http://" size=30></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Image URL:</b></font></td><td><input type=text name=ad_image value="http://" size=30></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Image Width:</b></font></td><td><input type=text name=ad_width value="468" size=4></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Image Height:</b></font></td><td><input type=text name=ad_height value="60" size=4></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Weight:</b></font></td><td><input type=text name=ad_weight value="1" size=4></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Impressions Remaining:</b></font><br><font face="Verdana, Helvetica" size=1>Set to <b>-1</b> for unlimited</font></td><td><input type=text name=ad_remain value="-1" size=4></td></tr><tr><td><font face="Verdana, Helvetica" size=2><b>Expires:</b></font></td><td>' .$expires. ' <input type=checkbox name=ad_noexpires checked value=1> <font face="Verdana, Helvetica" size=2>Never Expires</font></td></tr></table><br><center><input type=submit name=save value=Save> <input type=submit name=cancel value=Cancel></center></form>';
        foot();
    }
}
function logout()
{
    setcookie('user', '');
    setcookie('pass', '');
    head('Logged Out');
    echo '<font face="Verdana, Helvetica" size=2>You are now logged out of the control panel. Click <a href=admin.php>here</a> to login again.</font>';
    foot();
    exit;
}
?>