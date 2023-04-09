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
require_once('./inc/usermanager.inc.php');
require_once('./inc/tree.inc.php');
require_once('./inc/errorhandler.inc.php');

/*** For backward compatibility with PHP 4.0 **********************************/

if (!isset($_POST) && isset($HTTP_POST_VARS)) $_POST = $HTTP_POST_VARS;
if (!isset($_GET)  && isset($HTTP_GET_VARS))  $_GET  = $HTTP_GET_VARS;

/******************************************************************************/

function reqVal($name, $mandatory=false)
{
    $is = reqChk($name);
    if ($mandatory && !reqChk($name))
    {
        die('Expected field "'. $name .'" was not filled!');
    }
    return $is?(isset($_POST[$name])?$_POST[$name]:$_GET[$name]):'';
}

function reqChk($name)
{
    return isset($_POST[$name]) || isset($_GET[$name]);
}

/******************************************************************************/

class CommandWindow extends ErrorHandler
{
    var $command;
    var $um;
    var $tree;
    var $reload;
    var $close;
    var $fields;
    var $message;
    var $nobuttons = false;
    var $bookmarklet = false;
    var $onLoad = 'initCommander()';
    var $again = false;
    var $skipBuild = false;

    function CommandWindow()
    {
        $this->command  = reqVal('command');

        if (!$this->command)
        {
            $this->error('Missing command!');
        }

        if (reqChk('weblinks'))
        {
            $this->bookmarklet = true;
        }

        $this->um =& UserManager::staticInstance();
        $this->tree =& Tree::staticInstance();

        if ($this->command != "Log In"
        &&  !$this->um->isAuthorized($this->command, false,
            reqVal('command_gid'), reqVal('nid_acl'), reqVal('lid_acl')))
        {
            $this->error('Access denied!');
            return;
        }

        $shortname = str_replace(' ','',$this->command);

        // For logout we do not build the form and just execute
        // Do is set on build forms (if not set another form is opened)
        if ($this->command=='Log Out'
        || $this->command=='Verify Email Code'
        || reqVal('do'))
        {
            $this->reload = !$this->um->getParam('user','extern_commander');
            $this->close = $this->um->getParam('user','auto_close');

            $execute = 'command' . $shortname;
            $this->$execute();
        }
        else
        {
            $execute = 'build' . $shortname;
            $fields = $this->$execute();

            if (!$this->skipBuild)
            {
                if (!count($fields))
                {
                    if (!$this->hasErrors())
                    {
                        $this->error('Unknown command.');
                    }
                }
                else
                {
                    $this->fields = $fields;
                }
            }
        }
    }

    function goBack()
    {
        // We cannot repair error in this case because we would
        // lost additional infomation.
        if (reqChk('bookmarklet') && $this->command="Log In")
        {
            $this->bookmarklet = true;
            return;
        }

        $this->again = true;
        $shortname = str_replace(' ','',$this->command);
        $execute = 'build' . $shortname;
        $fields = $this->$execute();

        foreach ($fields as $name => $params)
        {
            if (isset($fields[$name]['name']))
            {
                $fields[$name]['value'] = reqVal($fields[$name]['name']);
            }
        }

        $this->fields = $fields;
    }

    function inPlace()
    {
        return !$this->bookmarklet &&
            (in_array($this->command, $this->um->inPlaceCommands()) ||
             !$this->um->getParam('user','extern_commander'));
    }

    function getFieldParams($params)
    {
        static $tabindex = 1;

        if (!isset($params['maxlength']) && isset($params['name']))
        {
            if ($params['name'] == 'name' || $params['name'] == 'email')
            {
                $params['maxlength'] = 50;
            }
            elseif ($params['name'] != 'comment')
            {
                $params['maxlength'] = 255;
            }
        }

        $txt = '';

        if (!array_key_exists('disabled',$params)
        &&  !array_key_exists('hidden',$params))
        {
            if ($tabindex==1)
            {
                $txt .= 'id="focused" ';
            }
            $tabindex++;
        }

        foreach ($params as $param => $value)
        {
            if ($value!=='' && $param{0}!='_')
            {
                if ($param=='value')
                {
                    $value = Page::quoteValue($value);
                }
                $txt .= $param . ($value?'="' . $value . '" ':' ');
            }
        }
        return $txt;
    }

    function _buildSkinList($select=null)
    {
        if ($dir = @opendir("skins"))
        {
            while (($file = readdir($dir)) !== false)
            {
                if (!file_exists('skins/'.$file.'/sitebar.css')) continue;
                echo '<option '. ($select==$file?'selected':'') .
                     ' value="' . $file . '">' . $file . "</option>\n";
            }
            closedir($dir);
        }
    }

    function _buildUserList($select=null, $exclude=null)
    {
        foreach ($this->um->getUsers() as $uid => $rec)
        {
            if ($uid == $exclude) continue;
            echo '<option '. ($select==$uid?'selected':'') .
                ' value="' . $uid . '">' . $rec['email'] . "</option>\n";
        }
    }

    function _buildGroupList()
    {
        $groups = $this->um->getModeratedGroups($this->um->uid);

        foreach ($this->um->getGroups() as $gid => $rec)
        {
            if (!$this->um->isAdmin()
            && !in_array($gid, array_keys($groups))) continue;
            echo '<option  value="' . $gid . '">' .
                $rec['name'] . "</option>\n";
        }
    }

    function writeForm()
    {
        $customButton = false;
?>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="command" value="<?=$this->command?>">
<?
    $target = '';
    if (isset($_GET['target'])) $target = $_GET['target'];
    if (isset($_POST['target'])) $target = $_POST['target'];
    if ($target)
    {
?>
    <input type="hidden" name="target" value='<?=$target?>'>
<?
    }


        $enabled = false;
        foreach ($this->fields as $name => $params)
        {
            if (!is_array($params))
            {
                if (substr($name,'-raw'))
                {
                    echo $params;
                }
                else
                {
?>
    <div class="label" <?=($params?'title="'.$params.'"':'')?>><?=$name?><?=$params?'*':''?></div>
<?
                }
                continue;
            }

            if (!isset($params['type']))
            {
                $params['type'] = 'text';
            }

            $disabled = !$params || array_key_exists('disabled', $params);

            // Is at least one field enabled
            $enabled = ($name{0} != '-' && !$disabled) || $enabled;

            // If we have disabled field then keep the value that would
            // be otherwise lost. Needed to go back.
            if ($disabled && $params['type'] == 'text')
            {
?>
    <input type="hidden" name="<?=$params['name']?>" value="<?=$params['value']?>">
<?
                $params['name'] = ''; // Don't use name with disabled fields.
            }

            if ($name{0} == '-')
            {
?>
    <input type="hidden" name="<?=$params['name']?>" value="<?=$params['value']?>">
<?
            }
            elseif (isset($params['type']) &&  $params['type'] == 'checkbox')
            {
                $id = '_id'.$params['name'];
?>
    <div class="check">
        <input id="<?=$id?>" <?=$this->getFieldParams($params)?>>
        <label for="<?=$id?>"><?=$name?></label>
    </div>
<?
            }
            elseif (isset($params['type']) &&  $params['type'] == 'select')
            {
?>
    <div class="label"><?=$name?></div>
    <div class="data">
        <select <?=$this->getFieldParams($params)?>>
<?
            $this->$params['_options'](
                isset($params['_select'])?$params['_select']:null,
                isset($params['_exclude'])?$params['_exclude']:null
                );
?>
        </select>
    </div>
<?
            }
            elseif (isset($params['type']) &&  $params['type'] == 'callback')
            {
                $this->$params['function'](isset($params['params'])?$params['params']:null);
            }
            elseif (isset($params['type']) &&  $params['type'] == 'callbackextern')
            {
                $params['function'](isset($params['params'])?$params['params']:null);
            }
            elseif (isset($params['type']) &&  $params['type'] == 'button')
            {
                if (!$this->um->isAuthorized($name)) continue;
                $customButton = true;
?>
    <div>
        <input class="button customButton" type="submit" name="<?=$params['name']?>" value="<?=$name?>">
    </div>
<?
            }
            elseif (isset($params['type']) &&  $params['type'] == 'textarea')
            {
?>
    <div class="label"><?=$name?></div>
    <div class="data">
        <textarea <?=$this->getFieldParams($params)?>><?=isset($params['value'])?$params['value']:''?></textarea>
    </div>
<?
            }
            else
            {
?>
    <div class="label"><?=$name?></div>
    <div class="data">
        <input <?=$this->getFieldParams($params)?>>
        <input type="hidden" name="label_<?=$params['name']?>" value="<?=$name?>">
    </div>
<?
            }
        }

        if (!$customButton)
        {
?>
    <div class="buttons">
        <input class="button" type="submit" name="do" value="Submit">
<?
            if ($enabled) :
?>
        <input class="button" type="reset">
<?
            endif;
?>
    </div>
<?
        }
?>
</form>
<?
    }

    function checkMandatoryFields($fields)
    {
        $ok = true;

        foreach ($fields as $field)
        {
            if (!reqVal($field))
            {
                $this->error('Field "' . reqVal('label_'.$field) . '" must be filled!');
                $ok = false;
            }
        }

        return $ok;
    }

/******************************************************************************/

    function buildSiteBarSettings()
    {
        $fields = array();

        $fields['Default Skin'] = array('name'=>'skin','type'=>'select',
            '_options'=>'_buildSkinList', '_select'=>$this->um->getParam('config','skin'));
        $fields['Personal Mode'] = array('name'=>'personal_mode',
            'type'=>'checkbox','value'=>1,
            'checked'=>$this->um->getParamCheck('config','personal_mode'));
        $fields['Use Compression'] = array('name'=>'use_compression',
            'type'=>'checkbox','value'=>1,
            'checked'=>$this->um->getParamCheck('config','use_compression'));
        $fields['Allow Sign Up'] = array('name'=>'allow_sign_up','type'=>'checkbox','value'=>1,
            'checked'=>$this->um->getParamCheck('config','allow_sign_up'));
        $fields['Use E-mail Features'] = array('name'=>'use_mail_features','type'=>'checkbox','value'=>1,
            'checked'=>$this->um->getParamCheck('config','use_mail_features'));
        $fields['Users Can Create Trees'] = array('name'=>'allow_user_trees',
            'type'=>'checkbox','value'=>1,
            'checked'=>$this->um->getParamCheck('config','allow_user_trees'));
        $fields['Allow Anonymous Contact'] = array('name'=>'allow_contact',
            'type'=>'checkbox','value'=>1,
            'checked'=>$this->um->getParamCheck('config','allow_contact'));
        return $fields;
    }

    function commandSiteBarSettings()
    {
        $this->um->setParam('config','skin', reqVal('skin'));
        $this->um->setParam('config','allow_sign_up', reqVal('allow_sign_up')?1:0);
        $this->um->setParam('config','use_mail_features', reqVal('use_mail_features')?1:0);
        $this->um->setParam('config','allow_user_trees', reqVal('allow_user_trees')?1:0);
        $this->um->setParam('config','allow_contact', reqVal('allow_contact')?1:0);
        $this->um->setParam('config','personal_mode', reqVal('personal_mode')?1:0);
        $this->um->setParam('config','use_compression', reqVal('use_compression')?1:0);
        $this->um->saveConfiguration();
    }

/******************************************************************************/

    function buildCreateTree()
    {
        $fields = array();
        if ($this->um->isAdmin())
        {
            $fields['Owner'] = array('name'=>'uid','type'=>'select','_options'=>'_buildUserList');
        }
        $fields['Tree Name'] = array('name'=>'treename');
        $fields['Description'] = array('name'=>'comment');
        return $fields;
    }

    function commandCreateTree()
    {
        $this->checkMandatoryFields(array('treename'));
        if ($this->hasErrors())
        {
            $this->goBack();
            return;
        }

        $uid = reqVal('uid');

        if (!$this->um->isAdmin())
        {
            $uid = $this->um->uid;
        }

        $this->tree->addRoot($uid, reqVal('treename'), reqVal('comment'));
    }

/******************************************************************************/

    function buildSetUp()
    {
        $fields['E-mail'] = array('name'=>'email');
        $fields['Admin Password'] = array('name'=>'pass','type'=>'password');
        $fields['Repeat Admin Password'] = array('name'=>'pass_repeat','type'=>'password');
        $fields['Real Name'] = array('name'=>'realname');

        return array_merge($fields, $this->buildSiteBarSettings());
    }

    function commandSetUp()
    {
        if (reqVal('pass') != reqVal('pass_repeat'))
        {
            $this->error('The password was not repeated correctly!');
        }

        $this->checkMandatoryFields(array('pass','realname','email'));
        if ($this->hasErrors())
        {
            $this->goBack();
            return;
        }

        if ($this->um->setUp(reqVal('email'),reqVal('pass'),reqVal('realname')))
        {
            $this->reload = true;
            $this->close = false;
            $this->message = reqVal('realname') . ', welcome to the SiteBar!<p>' . "\n".
                'You have been already logged in.';
        }

        $this->um->setParam('config','allow_sign_up', reqVal('allow_sign_up')?1:0);
        $this->um->setParam('config','use_mail_features', reqVal('use_mail_features')?1:0);
        $this->um->saveConfiguration();
    }

/******************************************************************************/

    function buildLogIn()
    {
        $fields = array();
        $fields['E-mail'] = array('name'=>'email');
        $fields['Password'] = array('name'=>'pass','type'=>'password');
        $fields['Remember Me'] = array('name'=>'expires','type'=>'select',
            '_options'=>'_buildExpirationList');

        return $fields;
    }

    function _buildExpirationList()
    {
        $expiration = array
        (
            'Until I close browser' =>0,
            '12 hours' =>60*60*12,
            '6 days'   =>60*60*24*6,
            '1 month'  =>60*60*24*30,
        );

        foreach ($expiration as $label => $value)
        {
            echo '<option value="' . $value. '">' . $label. "</option>\n";
        }
    }

    function commandLogIn()
    {
        $this->checkMandatoryFields(array('email','pass'));
        if ($this->hasErrors())
        {
            $this->goBack();
            return;
        }

        if (!$this->um->login(reqVal('email'), reqVal('pass'), reqVal('expires')))
        {
            $this->goBack();
            return;
        }

        if (reqChk('bookmarklet'))
        {
            $this->command = 'Add Link';
            $this->fields = $this->buildAddLink();
        }
        else
        {
            $this->reload = true;
            $this->close = true;
        }
    }

    function commandLogOut()
    {
        $this->um->logout();
        $this->reload = true;
        $this->close = true;
    }

/******************************************************************************/

    function buildHelp()
    {
        require_once('./inc/helptopic.inc.php');

        $fields = array();
        $topics = getHelpTopics();

        if (reqChk('topic'))
        {
            $fields['-raw1-'] = '<h3>' . $topics[reqVal('topic')] . '</h3>';
            $fields['Topic'] = array('type'=>'callbackextern',
                'function'=>'getHelp', 'params'=>array('topic'=>reqVal('topic')));
        }

        $fields['Help Topic'] = array('class'=>'help', 'name'=>'topic','type'=>'select',
            'size'=> count($topics),
            '_options'=>'_buildHelpTopicList', '_select'=>reqVal('topic'));
        $fields['Display Topic'] = array('name'=>'command','type'=>'button','value'=>'Help');
        return $fields;
    }

    function buildDisplayTopic()
    {
        $this->command = 'Help';
        return $this->buildHelp();
    }

    function _buildHelpTopicList($select=null)
    {
        foreach (getHelpTopics() as $value => $label)
        {
            if (intval($value) % 100)
            {
                $label = '&nbsp;-&nbsp;' . $label;
            }

            echo '<option '.($select==$value?'selected':'').
                 ' value="' . $value. '">' . $label. "</option>\n";
        }
    }

/******************************************************************************/

    function buildContactAdmin()
    {
        $fields = array();
        if ($this->um->isAnonymous())
        {
            $fields['Your E-mail'] = array('name'=>'email');
        }
        $fields['Feedback or Other Comment'] = array('name'=>'comment',
            'type'=>'textarea', 'rows'=>5);
        return $fields;;
    }

    function commandContactAdmin()
    {
        $email = reqChk('email')
            ?"Guest:\t" . (reqVal('email')?reqVal('email'):'Anonymous Coward')
            :"Username:\t" . $this->um->name . "<" . $this->um->email . ">";

        $comment = reqVal('comment');

        if (!$comment)
        {
            return;
        }

        $url = Page::baseurl();
        $comment =
            $email . "\n" .
            "Comment:\n\n" . $comment . "\n\n" .
            "--\n" .
            "SiteBar installation at $url.";

        $subject = Page::title() . ": Contact Admin";
        $admins = $this->um->getMembers($this->um->config['gid_admins']);

        foreach ($admins as $uid => $admin)
        {
            $this->um->sendMail($admin['email'], $subject, $comment);
        }
    }

/******************************************************************************/

    function buildSignUp()
    {
        $fields = array();
        $fields['E-mail'] = array('name'=>'email');
        $fields['Password'] = array('name'=>'pass','type'=>'password');
        $fields['Repeat Password'] = array('name'=>'pass_repeat','type'=>'password');
        $fields['Real Name'] = array('name'=>'realname');
        $fields['Comment'] = array('name'=>'comment');
        return $fields;
    }

    function commandSignUp($autoLogin = true)
    {
        if (reqVal('pass') != reqVal('pass_repeat'))
        {
            $this->error('The password was not repeated correctly!');
        }

        if (!$this->checkMandatoryFields(array('email','pass','realname')))
        {
            $this->goBack();
        }

        if ($this->hasErrors())
        {
            $this->goBack();
            return;
        }

        $uid = $this->um->signUp(reqVal('email'), reqVal('pass'),
            reqVal('realname'), reqVal('comment'),
            !$autoLogin, reqVal('verified'), reqVal('demo'));

        if ($uid)
        {
            $this->tree->addRoot($uid, reqVal('realname')."'s Bookmarks");

            if ($autoLogin)
            {
                $this->um->login(reqVal('email'), reqVal('pass'));
                $this->reload = true;
            }
        }

        if ($this->hasErrors())
        {
            $this->goBack();
            return;
        }
    }

/******************************************************************************/

    function buildVerifyEmail()
    {
        $url = $this->um->getVerificationUrl();
        $subject = Page::title() . ": Email Verification";
        $msg = <<<_MSG
You have requested e-mail validation that allows joining of
groups with auto join regular expressions and allows you to
make use of SiteBar's e-mail features.

Please click on the following link to verify your email:
    $url
_MSG;
        // Verify email
        $this->um->sendMail($this->um->email, $subject, $msg);
        $this->warn('Verification e-mail has been sent to your e-mail address!');
        return array();
    }

    function commandVerifyEmailCode()
    {
        $email = reqVal('email', true);
        $code = reqVal('code', true);

        $this->um->verifyEmail($email, $code);

        if (!$this->hasErrors())
        {
            $this->nobuttons = true;
            $this->reload = false;
            $this->close = false;
            $this->message = 'E-mail ' . $email . ' verified! '.
                'Any pending memberships were approved.';
        }
    }

/******************************************************************************/

    function buildMaintainUsers()
    {
        $fields = array();
        $fields['Select User'] = array('name'=>'uid','type'=>'select',
            '_options'=>'_buildUserList', '_exclude'=>$this->um->uid);
        $fields['Modify User'] = array('name'=>'command','type'=>'button');
        $fields['Delete User'] = array('name'=>'command','type'=>'button');
        $fields['Create User'] = array('name'=>'command','type'=>'button');
        return $fields;
    }

    function buildCreateUser()
    {
        $fields = $this->buildSignUp();
        $fields['E-mail Verified'] = array('name'=>'verified', 'type'=>'checkbox', 'value'=>1, 'checked'=>null);
        $fields['Demo Account'] = array('name'=>'demo', 'type'=>'checkbox', 'value'=>1);
        return $fields;
    }

    function commandCreateUser()
    {
        $this->commandSignUp(false);
    }

    function buildModifyUser()
    {
        if (!reqChk('uid'))
        {
            $this->error('No user was selected!');
            return null;
        }
        $fields = array();
        $user = $this->um->getUser(reqVal('uid'));
        $fields['E-mail'] = array('name'=>'email', 'value'=>$user['email'], 'disabled' => null);
        $fields['Real Name'] = array('name'=>'realname', 'value'=>$user['name']);
        $fields['Comment'] = array('name'=>'comment', 'value'=>$user['comment']);
        $fields['Password'] = array('name'=>'pass','type'=>'password');
        $fields['Repeat Password'] = array('name'=>'pass_repeat','type'=>'password');
        $fields['E-mail Verified'] = array('name'=>'verified', 'type'=>'checkbox', 'value'=>1);
        $fields['Demo Account'] = array('name'=>'demo', 'type'=>'checkbox', 'value'=>1);

        if ($user['verified'])
        {
            $fields['E-mail Verified']['checked'] = null;
        }

        if ($user['demo'])
        {
            $fields['Demo Account']['checked'] = null;
        }

        $fields['-hidden1-'] = array('name'=>'uid', 'value'=>reqVal('uid'));
        return $fields;
    }

    function commandModifyUser()
    {
        if (reqChk('pass') && reqVal('pass') != reqVal('pass_repeat'))
        {
            $this->error('The password was not repeated correctly!');
        }

        if ($this->hasErrors())
        {
            $this->goBack();
            return;
        }
        $this->um->modifyUser(reqVal('uid',true), reqVal('pass'),
            reqVal('realname'), reqVal('comment'),
            reqVal('verified'), reqVal('demo'));
    }

    function buildDeleteUser()
    {
        if (!reqChk('uid'))
        {
            $this->error('No user was selected!');
            return null;
        }
        $fields = array();
        $user = $this->um->getUser(reqVal('uid'));
        $fields['E-mail'] = array('name'=>'email', 'value'=>$user['email'], 'disabled' => null);
        $fields['Real Name'] = array('name'=>'realname', 'value'=>$user['name'], 'disabled' => null);
        $fields['-hidden1-'] = array('name'=>'uid', 'value'=>reqVal('uid'));

        if (count($this->tree->getUserRoots(reqVal('uid'))))
        {
            $fields['New Tree Owner'] = array('name'=>'owner','type'=>'select',
                '_options'=>'_buildUserList', '_exclude'=>reqVal('uid'));
        }
        return $fields;
    }

    function commandDeleteUser()
    {
        if (!$this->um->removeUser(reqVal('uid',true)))
        {
            return;
        }
        if (reqChk('owner'))
        {
            $this->tree->changeOwner(reqVal('uid'), reqVal('owner'));
        }
    }

    function buildUserSettings()
    {
        $fields = array();

        $fields['E-mail'] = array('name'=>'email', 'value'=>$this->um->email,
            'disabled'=>null);

        $fields['Old Password'] = array('name'=>'pass',
            'title'=>'Needed for password change only','type'=>'password');
        $fields['Password'] = array('name'=>'pass1','type'=>'password');
        $fields['Repeat Password'] = array('name'=>'pass2','type'=>'password');
        $fields['Real Name'] = array('name'=>'realname',
            'value'=>$this->um->name);
        $fields['Comment'] = array('name'=>'comment',
            'value'=>$this->um->comment);

        if ($this->um->demo)
        {
            foreach ($fields as $name => $field)
            {
                $fields[$name]['disabled'] = null;
            }
        }

        $fields['Skin'] = array('name'=>'skin','type'=>'select',
            '_options'=>'_buildSkinList', '_select'=>$this->um->getParam('user','skin'));
        $fields['Paste Mode'] = array('name'=>'paste_mode','type'=>'select',
            '_options'=>'_buildPasteModeSetting', '_select'=>$this->um->getParam('user','paste_mode'));

        $fields['Use Favicons'] = array('name'=>'use_favicons', 'type'=>'checkbox', 'value'=>1,
            'checked'=>$this->um->getParamCheck('user','use_favicons'));
        $fields['Show Menu Icon'] = array('name'=>'menu_icon', 'type'=>'checkbox', 'value'=>1,
            'checked'=>$this->um->getParamCheck('user','menu_icon'));
        $fields['Skip Execution Messages'] = array('name'=>'auto_close',
            'type'=>'checkbox', 'value'=>1,
            'checked'=>$this->um->getParamCheck('user','auto_close'),
            'title'=>'Do not display command execution status in case of success.');
        $fields['Extern Commander'] = array('name'=>'extern_commander',
            'type'=>'checkbox', 'value'=>1,
            'checked'=>$this->um->getParamCheck('user','extern_commander'),
            'title'=>'Execute commands using external window - without reloads after every command.');

        if (!$this->um->pmode)
        {
            $fields['Allow Given Membership'] = array('name'=>'allow_given_membership',
                'type'=>'checkbox', 'value'=>1,
                'checked'=>$this->um->getParamCheck('user','allow_given_membership'),
                'title'=>'Allow moderators to add me to their groups.');
            $fields['Allow Info Mail'] = array('name'=>'allow_info_mails',
                'type'=>'checkbox', 'value'=>1,
                'checked'=>$this->um->getParamCheck('user','allow_info_mails'),
                'title'=>'Allow admins and moderators of group that I belong to, to send me info emails.');
        }
        else
        {
            $fields['Show Public Bookmarks'] = array('name'=>'show_public',
                'type'=>'checkbox', 'value'=>1,
                'checked'=>($this->um->showPublic()?null:''),
                'title'=>'Shows bookmarks published by other users.');
        }

        $name = ($this->um->pmode?'Decorate Published Folders':'Decorate ACL Folders');

        $fields[$name] = array('name'=>'show_acl',
            'type'=>'checkbox', 'value'=>1,
            'checked'=>$this->um->getParamCheck('user','show_acl'),
            'title'=>'Decorate folders with security specification - performance penalty.');

        $fields['-hidden1-'] = array('name'=>'uid','value'=>$this->um->uid);

        return $fields;
    }

    function _buildPasteModeSetting($select=null)
    {
        $modes = array
        (
            'ask'  => 'Ask',
            'copy' => 'Copy',
            'move' => 'Move or Copy',
        );

        foreach ($modes as $mode => $label)
        {
            echo '<option '. ($select==$mode?'selected':'') .
                 ' value="' . $mode . '">' . $label . "</option>\n";
        }
    }

    function commandUserSettings()
    {
        if (reqVal('pass1') != reqVal('pass2'))
        {
            $this->error('The password was not repeated correctly!');
        }

        $mfields = array('realname');

        if (reqChk('pass') && reqVal('pass1'))
        {
            $mfields[] = 'pass';
            if (!$this->um->checkPassword($this->um->uid,reqVal('pass')))
            {
                $this->error('Old password is invalid.');
            }
        }

        $this->checkMandatoryFields($mfields);

        if ($this->hasErrors())
        {
            $this->goBack();
            return;
        }

        // Params are set directly and saved with userSettings
        $this->um->setParam('user','use_favicons', reqVal('use_favicons'));
        $this->um->setParam('user','menu_icon', reqVal('menu_icon'));
        $this->um->setParam('user','extern_commander', reqVal('extern_commander'));
        $this->um->setParam('user','auto_close', reqVal('auto_close'));
        $this->um->setParam('user','skin', reqVal('skin'));
        $this->um->setParam('user','paste_mode', reqVal('paste_mode'));
        if (!$this->um->pmode)
        {
            $this->um->setParam('user','allow_given_membership', reqVal('allow_given_membership'));
            $this->um->setParam('user','allow_info_mails', reqVal('allow_info_mails'));
        }
        else
        {
            $gid = $this->um->config['gid_everyone'];

            if (reqVal('show_public') && !$this->um->showPublic())
            {
                // Add to Everyone group
                $this->um->addMember($gid,$this->um->uid);
            }
            else if (!reqVal('show_public') && $this->um->showPublic())
            {
                // Remove from Everyone group
                $this->um->removeMember($gid,$this->um->uid);
            }
        }
        $this->um->setParam('user','show_acl', reqVal('show_acl'));

        // Have the behaviour immediately
        $this->reload = !$this->um->getParam('user','extern_commander');
        $this->close = $this->um->getParam('user','auto_close');

        $this->um->userSettings(($this->um->demo?null:reqVal('pass1')),
            reqVal('realname'), reqVal('comment'));
    }

/******************************************************************************/

    function buildMaintainGroups()
    {
        $fields = array();
        $fields['Select Group'] = array('name'=>'command_gid','type'=>'select','_options'=>'_buildGroupList');
        $fields['Group Properties'] = array('name'=>'command','type'=>'button');
        $fields['Group Members'] = array('name'=>'command','type'=>'button');
        $fields['Group Moderators'] = array('name'=>'command','type'=>'button');
        $fields['Delete Group'] = array('name'=>'command','type'=>'button');
        $fields['Create Group'] = array('name'=>'command','type'=>'button');
        return $fields;
    }

    function buildGroupProperties()
    {
        $fields = $this->buildCreateGroup();

        $group = $this->um->getGroup(reqVal('command_gid'));
        foreach ($fields as $name => $params)
        {
            if ($params['name']
            &&  $params['name']!='allow_addself'
            &&  $params['name']!='allow_contact'
            &&  isset($group[$params['name']]))
            {
                $fields[$name]['value'] = $group[$params['name']];
            }
        }
        if ($group['allow_addself'])
        {
            $fields['Allow Self Add']['checked'] = null;
        }
        if ($group['allow_contact'])
        {
            $fields['Allow Contact']['checked'] = null;
        }
        $fields['-hidden1-'] = array('name'=>'command_gid','value'=>$group['gid']);

        return $fields;
    }

    function commandGroupProperties()
    {
        $this->um->updateGroup(reqVal('command_gid'), reqVal('name'), reqVal('comment'),
            reqVal('allow_addself')?1:0, reqVal('allow_contact')?1:0, reqVal('auto_join'));
    }

    function buildGroupMembers()
    {
        $fields = array();
        $group = $this->um->getGroup(reqVal('command_gid'));
        $members    = $this->um->getMembers(reqVal('command_gid'));
        $moderators = $this->um->getMembers(reqVal('command_gid'), true);

        $fields['Group Name'] = array('name'=>'name','value'=>$group['name'],'disabled'=>null);
        $fields['-hidden1-'] = array('name'=>'command_gid','value'=>$group['gid']);

        foreach ($this->um->getUsers() as $uid => $rec)
        {
            $fields[$rec['email']] = array('name'=>$uid, 'type'=>'checkbox','value'=>1);

            if (in_array($uid, array_keys($members)))
            {
                $fields[$rec['email']]['checked'] = null;

                if (in_array($uid, array_keys($moderators)))
                {
                    $fields[$rec['email']]['disabled'] = null;
                }
            }
            else
            {
                // Member is not in the group and does not want to be added
                if (strstr($rec['params'],'allow_given_membership=;'))
                {
                    array_pop($fields); // Hidden value
                }
            }
        }
        return $fields;
    }

    function commandGroupMembers()
    {
        $group = $this->um->getGroup(reqVal('command_gid'));
        $members    = $this->um->getMembers(reqVal('command_gid'));
        $moderators = $this->um->getMembers(reqVal('command_gid'), true);

        foreach ($this->um->getUsers() as $uid => $rec)
        {
            if (!reqChk($uid))
            {
                // Skip moderators - they cannot be unchecked
                if (in_array($uid, array_keys($moderators)))
                {
                    continue;
                }

                if (in_array($uid, array_keys($members)))
                {
                    $this->um->removeMember(reqVal('command_gid'),$uid);
                }
            }
            else
            {
                // Member is not in the group and does not want to be added
                if (strstr($rec['params'],'allow_given_membership=;'))
                {
                    $this->error('Access denied!');
                    return;
                }

                $this->um->addMember(reqVal('command_gid'),$uid);
            }
        }
    }

    function buildGroupModerators()
    {
        $fields = array();
        $group = $this->um->getGroup(reqVal('command_gid'));
        $members    = $this->um->getMembers(reqVal('command_gid'));
        $moderators = $this->um->getMembers(reqVal('command_gid'),true);

        $fields['Group Name'] = array('name'=>'name','value'=>$group['name'],'disabled'=>null);
        $fields['-hidden1-'] = array('name'=>'command_gid','value'=>$group['gid']);

        foreach ($members as $uid => $rec)
        {
            $fields[$rec['email']] = array('name'=>$uid,'type'=>'checkbox','value'=>1);

            if (in_array($uid, array_keys($moderators)))
            {
                $fields[$rec['email']]['checked'] = null;
            }
        }
        return $fields;
    }

    function commandGroupModerators()
    {
        $group = $this->um->getGroup(reqVal('command_gid'));
        $members    = $this->um->getMembers(reqVal('command_gid'));
        $moderators = $this->um->getMembers(reqVal('command_gid'), true);

        foreach ($members as $uid => $rec)
        {
            if (!reqChk($uid) && in_array($uid, array_keys($moderators)))
            {
                $this->um->updateMember(reqVal('command_gid'),$uid,false);
            }
            else if (reqChk($uid))
            {
                $this->um->updateMember(reqVal('command_gid'),$uid,true);
            }
        }

        // We might have deleted all moderators what would be fatal and
        // require manual change in database, therefore we make this one
        // as the only moderator.
        $moderators = $this->um->getMembers(reqVal('command_gid'),true);
        if (!count($moderators))
        {
            $this->um->updateMember(reqVal('command_gid'),$this->um->uid,true);
            $this->error('Cannot remove all moderators from a group!');
            $this->error('You have been left as group moderator.');
        }
    }

    function buildDeleteGroup()
    {
        $fields = array();
        if (reqVal('command_gid') == $this->um->config['gid_admins'])
        {
            $this->error("Cannot delete built in group!");
            return $fields;
        }

        $group = $this->um->getGroup(reqVal('command_gid'));
        $fields['Group Name'] = array('name'=>'name','value'=>$group['name'],"disabled"=>null);
        $fields['Comment'] = array('name'=>'comment','value'=>$group['comment'],"disabled"=>null);
        $fields['-hidden1-'] = array('name'=>'command_gid','value'=>$group['gid']);
        return $fields;
    }

    function commandDeleteGroup()
    {
        $this->um->removeGroup(reqVal('command_gid'));
    }

    function buildCreateGroup()
    {
        $fields = array();
        $fields['Group Name'] = array('name'=>'name');
        $fields['Comment'] = array('name'=>'comment');
        $fields['Auto Join E-Mail RegExp'] = array('name'=>'auto_join');
        if ($this->command == 'Create Group')
        {
            $fields['Moderator'] = array('name'=>'uid','type'=>'select',
                '_options'=>'_buildUserList');
        }
        $fields['Allow Self Add'] = array('name'=>'allow_addself','type'=>'checkbox','value'=>1);
        $fields['Allow Contact'] = array('name'=>'allow_contact','type'=>'checkbox','value'=>1);
        return $fields;
    }

    function commandCreateGroup()
    {
        $this->um->addGroup(reqVal('name'), reqVal('comment'), reqVal('uid'),
            reqVal('allow_addself')?1:0, reqVal('allow_contact')?1:0, reqVal('auto_join'));
    }

/******************************************************************************/

    function buildMembership()
    {
        $fields = array();
        $mygroups = $this->um->getUserGroups($this->um->uid);

        foreach ($this->um->getGroups() as $gid => $rec)
        {
            $isMyGroup = in_array($gid, array_keys($mygroups));
            $canJoin = $this->um->canJoinGroup($rec);

            if ($isMyGroup || $canJoin || $rec['allow_contact'])
            {
                $name = $rec['name'];

                if (!$isMyGroup && $rec['allow_contact'])
                {
                    $name .= ' [<a href="?command=Contact%20Moderator&gid=' . $gid . '">Contact</a>]';
                }

                $fields[$name] =  array('name'=>'gid_'.$gid,'type'=>'checkbox','value'=>1);

                if ($isMyGroup)
                {
                    $fields[$name]['checked'] = null;
                }

                $isModerator = isset($mygroups[$gid]) && $mygroups[$gid]['moderator'];
                if ((!$canJoin && !$isMyGroup) || $isModerator)
                {
                    $fields[$name]['disabled'] = null;
                }
            }
        }
        return $fields;
    }

    function commandMembership()
    {
        $mygroups = $this->um->getUserGroups($this->um->uid);

        foreach ($this->um->getGroups() as $gid => $rec)
        {
            $isMyGroup = in_array($gid, array_keys($mygroups));
            $canJoin = $this->um->canJoinGroup($rec);
            $checked = reqVal('gid_'.$gid)==1;
            $isModerator = isset($mygroups[$gid]) && $mygroups[$gid]['moderator'];

            if ($isMyGroup && !$checked && !$isModerator)
            {
                $this->um->removeMember($gid,$this->um->uid);
            }
            else if (!$isMyGroup && $checked)
            {
                if ($canJoin)
                {
                    $this->um->addMember($gid,$this->um->uid);
                }
                else
                {
                    $this->error('Access denied!'.$rec['name']);
                }
            }
        }
    }

    function buildContactModerator()
    {
        $fields = array();
        $fields['Request To Your Group'] = array('name'=>'comment',
            'type'=>'textarea', 'rows'=>5);
        return $fields;;
    }

    function commandContactModerator()
    {
        $group = $this->um->getGroup(reqVal('gid'));
        $comment = reqVal('comment');

        if (!$comment || !group)
        {
            return;
        }

        if (!$group['allow_contact'])
        {
            $this->error('Access denied!');
            return;
        }

        $url = Page::baseurl();
        $comment =
            "Username:\t" . $this->um->name . "<" . $this->um->email . ">\n" .
            "Group:\t\t" . $group['name'] . "\n" .
            "Comment:\n\n" . $comment . "\n\n" .
            "--\n" .
            "SiteBar installation at $url.";

        $moderators = $this->um->getMembers(reqVal('gid'), true);
        $subject = Page::title() . ": Contact Moderator";

        foreach ($moderators as $uid => $moderator)
        {
            $this->um->sendMail($moderator['email'], $subject, $comment);
        }
    }

/******************************************************************************/

    function buildAddFolder()
    {
        $fields = array();
        $node = $this->tree->getNode(reqVal('nid_acl',true));
        if (!$node) return null;

        if ($this->command == 'Add Folder')
        {
            $fields['Parent Folder'] = array('name'=>'parent','value'=>$node->name, 'disabled'=>null);
        }

        $fields['Folder Name'] = array('name'=>'name');
        $fields['Description'] = array('name'=>'comment', 'type'=>'textarea');
        $fields['-hidden1-'] = array('name'=>'nid_acl','value'=>$node->id);

        if ($this->command == 'Folder Properties'
        && $node->id_parent==0
        && $this->um->isAdmin()
        && !$this->um->pmode)
        {
            $uid = $this->tree->getRootOwner($node->id);
            $fields['Tree Owner'] = array('name'=>'uid','type'=>'select',
                '_options'=>'_buildUserList', '_select'=> $uid);
        }

        if ($this->command != 'Add Folder')
        {
            $fields['Folder Name']['value'] = $node->name;
            $fields['Description']['value'] = $node->comment;
        }

        if ($this->um->pmode)
        {
            $inherited = false;
            $acl = false;

            if ($this->command == 'Folder Properties')
            {
                $inherited = $node->isPublishedByParent();
                $acl = $node->getGroupACL($this->um->config['gid_everyone']);
            }

            $fields['Publish Folder'] = array
            (
                'name'=>'publish',
                'type'=>'checkbox',
                'value'=>1,
                'checked'=>((($acl&&$acl['allow_select'])||(!$acl&&$inherited))?null:''),
            );

            if ($inherited)
            {
                $fields['Publish Folder']['disabled'] = null;
            }
        }

        if ($this->command == 'Delete Folder'
        ||  $this->command == 'Purge Folder'
        ||  $this->command == 'Undelete' )
        {
            $fields['Folder Name']['disabled'] = null;
            $fields['Description']['disabled'] = null;

            if ($this->um->pmode)
            {
                $fields['Publish Folder']['disabled'] = null;
            }
        }

        return $fields;
    }

    function commandAddFolder()
    {
        $nid = $this->tree->addNode(reqVal('nid_acl'),reqVal('name'),
            reqVal('comment'));

        if ($this->um->pmode && !$this->hasErrors())
        {
            $node = $this->tree->getNode($nid);
            $node->publishFolder(reqVal('publish'));
        }
    }

/******************************************************************************/

    function buildFolderProperties()
    {
        return $this->buildAddFolder();
    }

    function commandFolderProperties()
    {
        $nid = reqVal('nid_acl');
        $this->tree->updateNode( $nid, reqVal('name'), reqVal('comment'), reqVal('uid'));

        if ($this->um->pmode && !$this->hasErrors())
        {
            $node = $this->tree->getNode($nid);
            $node->publishFolder(reqVal('publish'));
        }
    }

/******************************************************************************/

    function buildDeleteFolder()
    {
        $fields = $this->buildAddFolder();
        $fields['Delete Content Only'] = array('name'=>'content','type'=>'checkbox','value'=>1);
        return $fields;
    }

    function commandDeleteFolder()
    {
        $this->tree->removeNode(reqVal('nid_acl'), reqVal('content'));
    }

/******************************************************************************/

    function buildPurgeFolder()
    {
        return $this->buildAddFolder();
    }

    function commandPurgeFolder()
    {
        $this->tree->purgeNode(reqVal('nid_acl'));
    }

/******************************************************************************/

    function buildUndelete()
    {
        return $this->buildAddFolder();
    }

    function commandUndelete()
    {
        $this->tree->undeleteNode(reqVal('nid_acl'));
    }

/******************************************************************************/

    function _buildPasteMode($params)
    {
?>
    <div class='label'>Paste Mode</div>
    <input value='Copy' type='radio' name='mode' <?=$params['canMove']?'':'checked'?>>Copy (Keep Source)<br>
    <input value='Move' type='radio' name='mode' <?=$params['canMove']?'checked':'disabled'?>>Move (Delete Source)<br>
<?
    }


    function buildPaste()
    {
        $fields = array();
        $sourceId   = reqVal('sid',true);
        $sourceIsNode = reqVal('stype',true);
        $sourceObj  = null;
        $targetNode = $this->tree->getNode(reqVal('nid_acl',true));
        $sourceNodeId = $sourceId;

        if ($sourceIsNode)
        {
            $sourceObj = $this->tree->getNode($sourceId);
            if (!$this->um->isAuthorized('Copy', false, null, $sourceId))
            {
                $this->error('Access denied!');
                return;
            }
        }
        else
        {
            $sourceObj = $this->tree->getLink($sourceId);
            $sourceNodeId = $sourceObj->id_parent;

            if (!$this->um->isAuthorized('Copy Link', false, null, null, $sourceId))
            {
                $this->error('Access denied!');
                return;
            }

            if ($sourceObj->id_parent == $targetNode->id)
            {
                $this->warn('Link already is in the target folder!');
                return;
            }
        }

        $canMove = $this->um->canMove($sourceNodeId,$targetNode->id,$sourceIsNode);

        if ($this->um->getParam('user','paste_mode')!='ask')
        {
            $this->skipBuild = true;
            $this->reload = !$this->um->getParam('user','extern_commander');
            $this->close = $this->um->getParam('user','auto_close');

            $move = $canMove && $this->um->getParam('user','paste_mode')=='move';
            $this->executePaste($targetNode->id, $sourceId, $sourceIsNode, $move);
            return;
        }

        $fields[$sourceIsNode?'Source Folder Name':'Source Link Name'] =
            array('name'=>'sidname', 'value'=>$sourceObj->name, 'disabled' => null);
        $fields['Target Folder Name'] =
            array('name'=>'tidname', 'value'=>$targetNode->name, 'disabled' => null);

        $fields['Mode'] = array('type'=>'callback', 'function'=>'_buildPasteMode',
            'params'=>array('canMove'=>$canMove));

        $fields['-hidden1-'] = array('name'=>'nid_acl','value'=>$targetNode->id);
        $fields['-hidden2-'] = array('name'=>'sid','value'=>$sourceId);
        $fields['-hidden3-'] = array('name'=>'stype','value'=>$sourceIsNode);

        return $fields;
    }

    function commandPaste()
    {
        $targetID = reqVal('nid_acl');
        $sourceId   = reqVal('sid',true);
        $sourceIsNode = reqVal('stype',true);
        $move = reqVal('mode',true)=='Move';

        $this->executePaste($targetID, $sourceId, $sourceIsNode, $move);
    }

    function executePaste($targetID, $sourceId, $sourceIsNode, $move)
    {
        $targetNode = $this->tree->getNode($targetID);
        $sourceObj  = null;

        if ($sourceIsNode)
        {
            $sourceObj = $this->tree->getNode($sourceId);
            if (!$this->um->isAuthorized('Copy', false, null, $sourceId) ||
                ($move && !$this->um->canMove($sourceId, $targetNode->id, true)))
            {
                $this->error('Access denied!');
                return;
            }

            if ($move)
            {
                $this->tree->moveNode( $sourceId, $targetNode->id);
            }
            else
            {
                $this->tree->copyNode( $sourceId, $targetNode->id);
            }
        }
        else
        {
            $sourceObj = $this->tree->getLink($sourceId);
            if (!$this->um->isAuthorized('Copy Link', false, null, null, $sourceId) ||
                ($move && !$this->um->canMove($sourceObj->id_parent, $targetNode->id, false)))
            {
                $this->error('Access denied!');
                return;
            }

            if ($move)
            {
                $this->tree->moveLink( $sourceId, $targetNode->id);
            }
            else
            {
                $this->tree->copyLink( $sourceId, $targetNode->id);
            }
        }
    }


/******************************************************************************/

    function buildEmailLink()
    {
        $fields = array();
        $link = $this->tree->getLink(reqVal('lid_acl'));
        if (!$link) return null;

        if ($this->um->canUseMail())
        {
            $fields['From'] = array('name'=>'from',
                'value'=> $this->um->email, 'disabled' => null);
            $fields['To'] =
                array('name'=>'to');

            $fields['Link Name'] = array('name'=>'name','value'=>$link->name,'disabled'=>null);
            $fields['URL']       = array('name'=>'url','value'=>$link->url,'disabled'=>null);
            $fields['Description'] = array('name'=>'comment','value'=>$link->comment);
            $fields['-hidden1-'] = array('name'=>'lid_acl','value'=>$link->id);
        }

        $fields['-raw1-'] =
            "<p>Send e-mail via your default <a href='mailto:?subject=Web site: " . $link->name .
            "&body=I have found a web site you may be interested in. \n\n" .
            "Take a look at: \n\n\"" . $link->url . "\"\n" .
            "-- \nSent via SiteBar at " . Page::baseurl() . " \n".
            "Open Source Bookmark Server http://www.sitebar.org" .
            "'>e-mail client</a>";

        return $fields;
    }

    function commandEmailLink()
    {
        $link = $this->tree->getLink(reqVal('lid_acl'));
        if (!$link) return null;

        $this->checkMandatoryFields(array('to'));

        if ($this->hasErrors())
        {
            $this->goBack();
            return;
        }

        $url     = $link->url;
        $desc    = (reqChk('comment')?'"'. reqVal('comment'). '" ':'');
        $sbi     = Page::baseurl();
        $subject = 'Web site: ' . $link->name;
        $headers = "From: \"" . $this->um->name . "\" <". $this->um->email .">\r\n";

        $msg = <<<_MSG
I have found a web site you may be interested in.
Take a look at:

\t$desc $url

--
Sent via SiteBar at $sbi
Open Source Bookmark Server http://www.sitebar.org
_MSG;
        // Send link
        $this->um->sendMail(reqVal('to'), $subject, $msg, $headers);
    }

/******************************************************************************/

    function _buildAddLinkNode($node, $level)
    {
        foreach ($node->getNodes() as $childNode)
        {
            echo '<option '.(!$childNode->hasRight('insert')?'class="noinsert"':'').
                 ' value='.$childNode->id.'>'.
                 str_repeat('&nbsp;',$level*2) . $childNode->name,
                 '</option>';
            $this->_buildAddLinkNode($childNode, $level+1);
        }
    }

    function _buildAddLink($params)
    {
?>
        <select name='nid_acl'>
<?
        foreach ($this->tree->loadRoots($this->um->uid) as $root)
        {
            echo '<option '.(!$root->hasRight('insert')?'class="noinsert"':'').
                 ' value='.$root->id.'>['.$root->name.']</option>';

            // Load just folders
            $this->tree->loadNodes($root, false, 'insert');
            $this->_buildAddLinkNode($root, 1);
        }
?>
        </select>
<?
    }

    function buildAddLink()
    {
        $fields = array();
        $node = null;

        if (reqChk('nid_acl'))
        {
            $node = $this->tree->getNode(reqVal('nid_acl'));
            $fields['-hidden0-'] = array('name'=>'nid_acl','value'=>$node->id);
            $fields['Parent Folder'] = array('name'=>'parent',
                'value'=>$node->name,'disabled'=>null);
            if (!$node) return null;
        }
        else
        {
            $this->bookmarklet = true;

            if ($this->um->isAnonymous())
            {
                $this->command = 'Log In';
                $fields = $this->buildLogIn();
                $fields['-hidden0-'] = array('name'=>'bookmarklet','value'=>1);
                $fields['-hidden1-'] = array('name'=>'name','value'=>reqVal('name'));
                $fields['-hidden2-'] = array('name'=>'url','value'=>reqVal('url'));
                return $fields;
            }

            $fields['Parent Folder'] =
                array('type'=>'callback','function'=>'_buildAddLink');

            $fields['-hidden0-'] = array('name'=>'bookmarklet','value'=>1);
            $this->nobuttons = true;
        }

        $value = Page::utf8RawUrlDecode(reqChk('name')?reqVal('name'):'');

        $fields['Link Name'] =
            array('name'=>'name','value'=> $value);
        $fields['URL'] =
            array('name'=>'url','value'=>(reqChk('url')?reqVal('url'):'http://'));

        if ($this->um->getParam('user','use_favicons'))
        {
            $fields['Favicon'] = array('name'=>'favicon');
        }

        $fields['Description'] = array('name'=>'comment', 'type'=>'textarea');

        // It is allowed to create private item in others tree
        $fields['Private'] = array('name'=>'private','type'=>'checkbox');
        return $fields;
    }

    function commandAddLink()
    {
        $node = $this->tree->getNode(reqVal('nid_acl',true));
        if (!$node) return;

        $this->tree->addLink(reqVal('nid_acl'), reqVal('name'), reqVal('url'),
            reqVal('favicon'), reqVal('private'), reqVal('comment'));

        if (reqChk('bookmarklet'))
        {
            $this->bookmarklet = true;
            $this->nobuttons = true;
            $this->message =
                "Link has been added.<p>".
                "You must reload your SiteBar in order to see added link!";
        }
    }

/******************************************************************************/

    function buildProperties()
    {
        $fields = array();
        $link = $this->tree->getLink(reqVal('lid_acl'));
        if (!$link) return null;

        $fields['Link Name'] = array('name'=>'name','value'=>$link->name);
        $fields['URL']       = array('name'=>'url','value'=>$link->url);
        $fields['Favicon']   = array('name'=>'favicon','value'=>$link->favicon);
        $fields['Description'] = array('name'=>'comment',
            'type'=>'textarea','value'=>$link->comment);
        $fields['-hidden1-'] = array('name'=>'lid_acl','value'=>$link->id);

        if ($this->tree->inMyTree($link->id_parent))
        {
            $fields['Private'] = array('name'=>'private','type'=>'checkbox','value'=>1);
            if ($link->private)
            {
                $fields['Private']['checked'] = null;
            }
        }

        return $fields;
    }

    function commandProperties()
    {
        if (reqVal('private'))
        {
            $link = $this->tree->getLink(reqVal('lid_acl'));
            if (!$link) return;
            if (!$this->um->isMyTree($link->id_parent))
            {
                $this->error('Access denied!');
                return;
            }
        }

        $this->tree->updateLink(reqVal('lid_acl'), reqVal('name'), reqVal('url'),
            reqVal('favicon'), reqVal('private'), reqVal('comment'));
    }

/******************************************************************************/

    function buildDeleteLink()
    {
        $fields = $this->buildProperties();

        $fields['Link Name']['disabled'] = null;
        $fields['URL']['disabled'] = null;
        $fields['Favicon']['disabled'] = null;
        $fields['Description']['disabled'] = null;

        if (isset($fields['Private']))
        {
            $fields['Private']['disabled'] = null;
        }

        return $fields;
    }

    function commandDeleteLink()
    {
        $this->tree->removeLink(reqVal('lid_acl'));
    }

/******************************************************************************/

    function buildSecurity()
    {
        $fields = array();
        $node = $this->tree->getNode(reqVal('nid_acl',true));

        $fields['Folder Name'] = array('value'=>$node->name,'disabled'=>null);
        $fields['Security'] = array('type'=>'callback',
            'function'=>'_buildSecurityList', 'params'=>array('node'=>$node));
        $fields['-hidden1-'] = array('name'=>'nid_acl','value'=>$node->id);
        return $fields;
    }

    function _buildSecurityList($params)
    {
        $groups = $this->um->getGroups();
        $myGroups = $this->um->getUserGroups();
        $node = $params['node'];
?>
    <table class='security' cellpadding='0'>
        <tr>
            <th class='group'>Group</th>
            <th class='right' title='Read'>R</th>
            <th class='right' title='Add'>A</th>
            <th class='right' title='Modify'>M</th>
            <th class='right' title='Delete'>D</th>
            <th class='right' title='Purge'>P</th>
            <th class='right' title='Grant'>G</th>
        </tr>
<?
        foreach ($groups as $gid => $rec)
        {
            $acl = $node->getGroupACL($gid);
            $parentACL = $node->getParentACL($gid);
            $isMyGroup = isset($myGroups[$gid]) || $this->um->canJoinGroup($rec);
            $isModerator = $isMyGroup && $myGroups[$gid]['moderator'];

            if (!$acl)
            {
                $acl = $parentACL;
            }

            $aclSum = 0;
            foreach ($this->tree->rights as $right)
            {
                $aclSum += $acl['allow_'.$right];
            }

            if (!$isMyGroup // It is not my group and I cannot join it freely
            &&  !($node->hasRight('grant') && $aclSum)) // I cannot modify it
            {
                continue;
            }

            $sumChange = 0;
            $sumDiff = 0;

            // Check whether we have direct right or right thanks to the
            // fact that some right is enabled and we are moderator of
            // the group.
            foreach ($this->tree->rights as $right)
            {
                $value = $acl && $acl['allow_'.$right];
                $canChange = $node->hasRight('grant') || ($value && $isModerator);

                if ($canChange)
                {
                    $sumChange++;
                }

                // Count differences between parent and this ACL.
                if (($parentACL && $parentACL['allow_'.$right] != $value)
                || ($acl && !$parentACL && $node->id_parent) || (!$acl && $parentACL))
                {
                    $sumDiff++;
                }
            }

            // We cannot change and there is no right set on this node for this group.
            // Therefore we do not show it.
            if (!$sumChange && !$sumDiff)
            {
                continue;
            }

/* Debugging:

            if ($parentACL || $acl)
            {
                echo $rec['name']." ".$sumChange.":".$sumDiff."<br>";
                dump($parentACL);
                dump($acl);
            }
*/

?>
        <tr class='group'>
            <td rowspan='2' class='group'><?=$rec['name']?></td>
<?
            foreach ($this->tree->rights as $right)
            {
?>
            <td class='right'>
                <input type='checkbox' disabled <?=$parentACL && $parentACL['allow_'.$right]?'checked':''?>>
            </td>
<?
            }
?>
        </tr><tr>
<?
            foreach ($this->tree->rights as $right)
            {
                $value = $acl && $acl['allow_'.$right];
                $canChange = ($node->hasRight('grant') && ($isMyGroup||$value))
                    || ($value && $isModerator);
?>
            <td class='right'>
                <input type='checkbox' value='1' <?=$canChange?'':'disabled'?>
                    name='<?=$right.'_'.$gid?>' <?=$value?'checked':''?>>
            </td>
<?
            }
?>
        </tr>
<?
        }
?>
    </table>
    <div class='legend'>
    Rights:
<strong>R</strong>ead,
<strong>A</strong>dd,
<strong>M</strong>odify,
<strong>D</strong>elete,
<strong>P</strong>urge,
<strong>G</strong>rant
    </div>
<?
    }

    function commandSecurity()
    {
        $groups = $this->um->getGroups();
        $myGroups = $this->um->getUserGroups();
        $node = $this->tree->getNode(reqVal('nid_acl',true));
        $sameACL = true;
        $updated = 0;

        foreach ($groups as $gid => $rec)
        {
            $isMyGroup = isset($myGroups[$gid]) || $this->um->canJoinGroup($rec);
            $isModerator = $isMyGroup && $myGroups[$gid]['moderator'];

            if (!$node->hasRight('grant')  // We have no grant right to node
            &&  !$isModerator)             // And we are not moderator
            {
                continue;
            }

            $parentACL = $node->getParentACL($gid);
            $oldacl = $node->getGroupACL($gid);
            $newacl = array();
            $newsum = 0;
            $same = true;

            foreach ($this->tree->rights as $right)
            {
                $name = $right.'_'.$gid;
                $value = reqVal($name)?1:0;
                $parentValue = $parentACL?$parentACL['allow_'.$right]:0;
                $same = $same && $value==$parentValue;
                $newacl['allow_'.$right] = $value?1:0;
                $newsum += $value;
            }

            // We had right on the node before and we do not have right
            // to grant right but have right to remove it then check
            // that we are not cheating.
            if ($oldacl && (!$node->hasRight('grant') || !$isMyGroup))
            {
                foreach ($this->tree->rights as $right)
                {
                    if ($newacl['allow_'.$right]>$oldacl['allow_'.$right])
                    {
                        $this->error('Access denied!');
                        return;
                    }
                }
            }

            // Remove empty acl
            if (!$newsum && $same)
            {
                $node->removeACL($gid);
            }
            else
            {
                $node->updateACL($gid, $newacl);
            }

            $updated++;
            $sameACL = $sameACL && $same;
        }

        // If complete group ACL is the same as parent then we can remove it
        if ($updated && $sameACL)
        {
            $node->removeACL();
        }
    }

/******************************************************************************/

    function buildImportBookmarks()
    {
        require_once('./inc/bookmarkmanager.inc.php');

        $fields = array();
        $node = $this->tree->getNode(reqVal('nid_acl',true));
        $fields['Target Folder Name'] = array('value'=>$node->name,'disabled'=>null);
        $fields['Bookmark File'] = array('type'=>'file','name'=>'file');
        $fields['CodepageType'] = array('type'=>'callback', 'function'=>'_buildCodepage');
        $fields['File Type'] = array('type'=>'callback', 'function'=>'_buildFileType',
            'params'=>array('auto'=>true));
        $fields['-hidden1-'] = array('name'=>'nid_acl','value'=>$node->id);

        if (Page::isMSIE())
        {
            $fields['-raw1-'] = <<<IMPORT
<br>
Local favorites can be exported to a local file using javascript
<a href='javascript:window.external.ImportExportFavorites(false,"")'>function</a>.
IMPORT;

        }
        return $fields;
    }

    function buildExportBookmarks()
    {
        require_once('./inc/bookmarkmanager.inc.php');

        $fields = array();
        $node = $this->tree->getNode(reqVal('nid_acl',true));
        $fields['Folder Name'] = array('value'=>$node->name,'disabled'=>null);
        $fields['CodepageType'] = array('type'=>'callback', 'function'=>'_buildCodepage');
        $fields['File Type'] = array('type'=>'callback', 'function'=>'_buildFileType');
        $fields['-hidden1-'] = array('name'=>'nid_acl','value'=>$node->id);

        if (Page::isMSIE())
        {
            $fields['-raw1-'] = <<<EXPORT
<br>
Exported bookmarks can be imported to local favorties using javascript
<a href='javascript:window.external.ImportExportFavorites(true,"")'>function</a>.
EXPORT;

        }
        return $fields;
    }

    function _buildCodepage()
    {
        $bm = new BookmarkManager();

        if ($bm->engine<0)
        {
?>
<br>
Codepage conversion not installed on this SiteBar server.
<br>
<?
            return;
        }

        $default = $bm->langDetect();

        function langCmp(&$a, $b)
        {
            return (strcmp($a[1], $b[1]));
        }

        uasort($bm->languages, 'langCmp');
        reset($bm->languages);
?>
    <div class='label'>Character Set</div>
    <select class="language" name="codepage">
<?
        foreach ($bm->languages as $key => $value)
        {
            $lang_name = ucfirst(substr(strstr($value[0], '|'), 1));
            echo "\t\t" . '<option value="' . $key . '" ' .
                ($key==$default?'selected':'') . '>' .
                $lang_name .' (' . $key . ')</option>' . "\n";
        }
?>
    </select>
<?
    }

    function _buildFileType($params)
    {
?>
    <div class='label'>File Type</div>
<?
        $checked = 'checked';

        if (isset($params['auto']) && $params['auto'])
        {
?>
    <input value='auto' type='radio' name='type' <?=$checked?>>Auto detection<br>
<?
            $checked = '';
        }
?>
    <input value='<?=BM_T_NETSCAPE?>' type='radio' name='type' <?=$checked?>>Netscape/Mozilla/MS IE*<br>
    <input value='<?=BM_T_OPERA?>' type='radio' name='type'>Opera Hotlist version 2.0<br>
<?
    }

    function commandImportBookmarks()
    {
        require_once('./inc/bookmarkmanager.inc.php');

        if (isset($_FILES['file']['name']) && !$_FILES['file']['name'])
        {
            // We cannot do this directly because it would be always missing
            $this->checkMandatoryFields(array('file'));
            $this->goBack();
            return;
        }

        if (!isset($_FILES['file']['tmp_name'])
        ||  !filesize($_FILES['file']['tmp_name']))
        {
            $this->error('Invalid filename or other upload related problem!');
            $this->goBack();
            return;
        }

        $filename = $_FILES['file']['tmp_name'];


        $bm = new BookmarkManager(reqVal('codepage'));
        $type = reqVal('type');
        $bm->import($filename, ($type=='auto'?null:$type));

        // If not loaded message will be recorded and we go out
        if (!$bm->success)
        {
            return;
        }

        $this->message = sprintf(
            'Imported %s link(s) into %s folder(s) from the bookmark file.',
            $bm->importedLinks, $bm->importedFolders);

        $this->tree->importTree(reqVal('nid_acl'), $bm->tree);
    }

    function commandExportBookmarks()
    {
        require_once('./inc/bookmarkmanager.inc.php');

        $base = $this->tree->getNode(reqVal('nid_acl',true));
        $this->tree->loadNodes($base);

        if ($this->hasErrors())
        {
            return;
        }

        $type = reqVal('type');

        if (reqVal('do')=='direct')
        {
            $type = BM_T_NETSCAPE;
        }

        $ext = $type==BM_T_OPERA?".adr":".html";

        header("Content-type: application/octet-stream\n");
        header("Content-disposition: attachment; filename=\"" . $base->name . $ext ."\"\n");
        header("Content-transfer-encoding: binary\n");

        $bm = new BookmarkManager(reqVal('codepage'));
        $bm->export($base, $type);
        exit; // Really break program here
    }
}

/******************************************************************************/
/******************************************************************************/
/******************************************************************************/

$cw = new CommandWindow();
Skin::set($cw->um->getParam('user','skin'));

// On error no reloading and no closing
if ($cw->hasErrors())
{
    $cw->reload = false;
    $cw->close = false;
}
// On command success when auto close is required
elseif (!$cw->fields && $cw->close)
{
    // When in place just reload
    if ($cw->inPlace())
    {
        $target = "";
        if (isset($_GET['target']))
            $target = '?target='.$_GET['target'];
        if (isset($_POST['target']))
            $target = '?target='.$_POST['target'];

        header("Location: sitebar.php".$target);
        exit;
    }
    // When not in place then close
    else
    {
        $cw->onLoad = 'window.close()';
    }
}

/**
 * I do not need instance, I just need to call static functions.
 * As of PHP 4.3.1 it will generate strange warning in case
 * bookmarkmanager issued an error() on import(). I cannot see
 * any relevance because Page does not inherit from ErrorHandler.
 * But it is indeed related to ErrorHandler (when removing & from
 * declaration of getErrors() it works, but errors cannot be
 * reported then. Too curious for reporting and PHP 5 adds
 * static members what should solve the problem in future.
 */
$page = new Page();
$page->head('Commander', 'cmdWin', null, $cw->onLoad);

$errId = ($cw->hasErrors() && $cw->hasErrors(E_ERROR))?'error':'warn';

?>

<div id="<?=($cw->hasErrors()?$errId:'command').'Head'?>"><?=$cw->command?></div>
<div id="<?=($cw->hasErrors()?$errId:'command').'Body'?>">
<?
    if ($cw->hasErrors())
    {
        $cw->writeErrors(false);
    }

    if ($cw->again || !$cw->hasErrors())
    {
        if ($cw->fields)
        {
            $cw->writeForm();
        }
        else
        {
            echo ($cw->message?$cw->message:"Successful execution!");
        }
    }

    if ($cw->inPlace()) : ?>
    <div class='buttons'>
        <input class='button' type='button' onclick="reloadPage(true)" value='Return'>
    </div>
<?  endif; ?>
</div>
<?  if (!$cw->nobuttons) : ?>
<div id='foot'>
<?     if (!$cw->inPlace()) : ?>
<?         if (!$cw->bookmarklet) : ?>
[<a href="javascript:window.opener.location.reload();window.close()">Reload SiteBar</a>]
<?         endif; ?>
[<a href="javascript:window.close()">Close</a>]
</div>
<div class='hidden'>
<div><a href='sitebar.php'>Backup Return to SiteBar</a></div>
</div>
<?     endif; ?>
<?  endif; ?>
<?
$page->foot();
?>
