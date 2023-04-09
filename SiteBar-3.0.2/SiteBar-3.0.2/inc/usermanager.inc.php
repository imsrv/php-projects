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

require_once('./inc/database.inc.php');
require_once('./inc/errorhandler.inc.php');

define ('ADMIN',  1);
define ('ANONYM', 2);

class UserManager extends ErrorHandler
{
    var $user;
    var $config;
    var $setupDone;
    var $db;
    var $pmode; // personal mode

    var $uid;
    var $name;
    var $email;
    var $comment;
    var $verified;
    var $demo;
    var $params = array('config'=>array(),'user'=>array());

    function UserManager()
    {
        $this->db =& Database::staticInstance();

        /* Read SiteBar configuration - must be the first step ! */
        if ($this->db->hasTable('sitebar_config'))
        {
            $rset = $this->db->select(null, 'sitebar_config');
            $this->config = $this->db->fetchRecord($rset);
        }
        else
        {
            $this->config['release'] = '';
        }

        if ($this->db->currentRelease() != $this->config['release'])
        {
            header('Location: config.php');
            exit;
        }

        $this->explodeParams($this->config['params'],'config');
        $this->pmode = $this->getParam('config','personal_mode');

        /* Check whether Admin has password if not we will run setup */
        $rset = $this->db->select(null, 'sitebar_user',
            array( 'uid'=> ADMIN, '^1'=> 'AND', 'pass'=>null));

        $this->setupDone = ($this->db->fetchRecord($rset)===false);


        if (!$this->isLogged())
        {
            $rec = $this->getUser(ANONYM);

            if (!$rec)
            {
                $this->error('Database corrupted - missing anonymous account!');
            }
            else
            {
                $this->initUser($rec);
                unset($this->user['pass']); // Security
            }
        }
    }

    function & staticInstance()
    {
        static $um;

        if (!$um)
        {
            $um = new UserManager();
        }

        return $um;
    }

    function initUser(&$rec)
    {
        $this->user = $rec;
        $this->uid = $rec['uid'];
        $this->email = $rec['email'];
        $this->name = $rec['name'];
        $this->comment = $rec['comment'];
        $this->verified = $rec['verified'];
        $this->demo = $rec['demo'];
        $this->explodeParams($rec['params'],'user');
    }

    function setCookie($name, $value='', $expires=null)
    {
        if ($expires===null)
        {
            // Default expiration 7 days
            $expires = time()+60*60*24*7;
        }

        if (!$value)
        {
            $expires = time()-60*60;
        }
        setcookie($name, $value, $expires);
    }

    function explodeParams(&$params, $prefix)
    {
        $default = array();

        switch ($prefix)
        {
            case 'config':
                $default['use_mail_features']=1;
                $default['allow_sign_up']=1;
                $default['allow_user_trees']=1;
                $default['allow_contact']=1;
                $default['skin']='Modern';
                $default['personal_mode']=0;
                $default['use_compression']=1;
                break;

            case 'user':
                $default['use_favicons']=1;
                $default['extern_commander']=0;
                $default['auto_close']=1;
                $default['skin']= $this->getParam('config','skin');
                $default['allow_given_membership']=1;
                $default['allow_info_mails']=1;
                $default['show_acl']=0;
                $default['paste_mode']='ask';
                $default['menu_icon']=0;
                break;
        }

        // Clear old values
        $this->params[$prefix] = $default;

        // If we have some params then explode them
        if ($params)
        {
            foreach (explode(';',$params) as $param)
            {
                list($key,$value) = explode('=',$param);
                $this->setParam($prefix,$key,$value);
            }
        }
    }

    function implodeParams($prefix)
    {
        $params = array();
        foreach ($this->params[$prefix] as $name => $value)
        {
            $params[] = $name.'='.$value;
        }
        return implode(';',$params);
    }

    function getParam($prefix, $name)
    {
        return isset($this->params[$prefix][$name])
            ?$this->params[$prefix][$name]:null;
    }

    function getParamCheck($prefix, $name)
    {
        return $this->getParam($prefix,$name)?null:'';
    }

    function setParam($prefix, $name, $value)
    {
        $this->params[$prefix][$name] = $value;
    }

    function isAnonymous()
    {
        return $this->uid == ANONYM;
    }

    function isAdmin()
    {
        if (!$this->user)        return false;
        if ($this->uid == ADMIN) return true;

        static $isAdmin = null;

        if ($isAdmin === null)
        {
            $rset = $this->db->select('g.gid',
                'sitebar_group g natural join sitebar_member m',
                array('uid'=>$this->uid, '^1'=> 'AND',
                    'g.gid'=> $this->config['gid_admins']));

            $rec = $this->db->fetchRecord($rset);
            $isAdmin = is_array($rec);
        }

        return $isAdmin;
    }

    function isModerator($gid = null)
    {
        $groups = $this->getModeratedGroups($this->uid);

        if (!count($groups))
        {
            return false;
        }

        return $gid?in_array($gid, array_keys($groups)):true;
    }

    function canUseMail()
    {
        return $this->verified && $this->getParam('config','use_mail_features');
    }

    function isAuthorized($command, $ignoreAnonymous=false,
        $gid=null, $nid=null, $lid=null)
    {
        $acl = null;

        if ($lid)
        {
            $tree =& Tree::staticInstance();
            $link = $tree->getLink($lid);
            $nid = $link->id_parent;

            if ($link->private && !$tree->inMyTree($nid))
            {
                return false;
            }
        }

        if ($nid)
        {
            $tree =& Tree::staticInstance();
            $node = $tree->getNode($nid);

            if (!$node)
            {
                return false;
            }

            $acl =& $node->getACL();

            if (!$acl)
            {
                return false;
            }

            if ($node && $node->deleted_by != null)
            {
                if ($command != 'Purge Folder' && $command != 'Undelete')
                {
                    return false;
                }
            }
        }

        // If !$acl then we just ask for command list.

        switch ($command)
        {
            case 'Verify Email':
                return  !$this->pmode &&
                        !$this->isAnonymous() &&
                        !$this->verified &&
                        !$this->demo &&
                        $this->getParam('config','use_mail_features');

            case 'Verify Email Code':
                return true;

            case 'Set Up':
                return !$this->setupDone;

            case 'Sign Up':
                return ($this->isAnonymous() || $ignoreAnonymous)
                    && $this->getParam('config','allow_sign_up');

            case 'Help':
            case 'Display Topic':
                return true;

            case 'Log In':
                return $this->isAnonymous();

            case 'Log Out':
                return !$this->isAnonymous();

            case 'Email Link':
                return true;

            case 'Contact Admin':
                return $this->getParam('config','use_mail_features') &&
                       ($this->getParam('config','allow_contact') || !$this->isAnonymous()) &&
                       !$this->isAdmin();

            case 'Contact Moderator':
                return !$this->pmode && !$this->isAnonymous();

            case 'Add Link':
            case 'Add Folder':
                return !$acl || $acl['allow_insert'];

            case 'Paste': // Paste does its own checking later
            case 'Import Bookmarks':
                return !$this->isAnonymous() && (!$acl || $acl['allow_insert']);

            case 'Copy':
            case 'Copy Link':
            case 'Export Bookmarks':
                return !$this->isAnonymous() && (!$acl || $acl['allow_select']);

            case 'Folder Properties':
            case 'Properties':
                return !$acl || $acl['allow_update'];

            case 'Delete Folder':
            case 'Delete Link':
                return !$acl || $acl['allow_delete'];

            case 'Purge Folder':
                return !$acl || $acl['allow_purge'];

            case 'Undelete':
                return !$acl || ($acl['allow_delete'] && $acl['allow_insert']);

            case 'User Settings':
                return !$this->isAnonymous();

            case 'Membership':
            case 'Security':
                return !$this->isAnonymous() && !$this->pmode;

            case 'Create Tree':
                return !$this->isAnonymous() &&
                       $this->verified &&
                       $this->getParam('config','allow_user_trees');

            case 'SiteBar Settings':
            case 'Maintain Users':
            case 'Create User':
            case 'Delete User':
            case 'Modify User':
                return $this->isAdmin();

            case 'Create Group':
            case 'Delete Group':
                return !$this->pmode && $this->isAdmin();

            case 'Maintain Groups':
                return !$this->pmode && ($this->isAdmin() || $this->isModerator());

            case 'Group Properties':
            case 'Group Members':
            case 'Group Moderators':
                return !$this->pmode && $this->isModerator($gid);

        }

        return false;
    }

    function canMove($sid,$tid,$isnode=true)
    {
        if ($this->isAuthorized(($isnode?'Delete Folder':'Delete Link'), false, null, $sid))
        {
            $tree = Tree::staticInstance();
            $sroot = $tree->getRootNode($sid);
            $troot = $tree->getRootNode($tid);

            if ($sroot->id == $troot->id)
            {
                return true;
            }
            else // Another tree and the source tree does not have purge right
            {
                return $this->isAuthorized('Purge Folder', false, null, $sid);
            }
        }

        return false;
    }

    function & inPlaceCommands()
    {
        static $commands = array("Log In","Log Out","Sign Up", "Set Up", "User Settings");
        return $commands;
    }

    // expires as delta time in seconds
    function login($email, $pass, $expires=0)
    {
        $rset = $this->db->select(null, 'sitebar_user', array(
            'ucase(email)' => array('ucase' => $email),
            '^1' => 'AND',
            'pass' => array('md5' => $pass),
        ));

        $rec = $this->db->fetchRecord($rset);

        if (!is_array($rec))
        {
            $this->error('Unknown username or wrong password!');
            return false;
        }

        $this->initUser($rec);
        unset($this->user['pass']); // Security

        // Noone from outside can reconstruct the password, because
        // only half of its md5 is used to generate another md5 and
        // hence we use password noone from outside can guess the code.
        // Is it obscure or slow? Please tell me.
        $code = md5(substr(md5($pass),6,18).date('r').$email);

        $expires = ($expires?$expires+time():0);

        $this->db->insert('sitebar_session', array(
            'uid' => $this->uid,
            'code' => $code,
            'created' => array('now' => null),
            'expires' => $expires,
            'ip' => $_SERVER['REMOTE_ADDR']
        ));

        $this->setCookie('SB3AUTH', $code, $expires);
        return true;
    }

    function logout()
    {
        $this->user = null;
        $this->setCookie('SB3AUTH');
    }

    function isLogged()
    {
        if (!isset($_COOKIE['SB3AUTH']))
        {
            return false;
        }

        // Check if we have valid session
        $rset = $this->db->select('uid', 'sitebar_session',
            array('code' => $_COOKIE['SB3AUTH'],
                '^1' => 'AND (expires = 0 OR expires>=unix_timestamp())'));

        $rec = $this->db->fetchRecord($rset);

        // Delete invalid cookie
        if (!is_array($rec))
        {
            $this->setCookie('SB3AUTH');
            return false;
        }

        // If yes then let us go in.
        $rset = $this->db->select(null, 'sitebar_user', array('uid' => $rec['uid']));

        $rec = $this->db->fetchRecord($rset);

        // User deleted?
        if (!is_array($rec))
        {
            $this->setCookie('SB3AUTH');
            return false;
        }

        $this->initUser($rec);
        unset($this->user['pass']); // Security

        return true;
    }

    function setUp($email, $pass,$name)
    {
        $rset = $this->db->update('sitebar_user',
            array(
                'email' => $email,
                'pass' => array('md5' => $pass),
                'name' => $name,
                'verified' => 1,
            ),
            array('uid'=>ADMIN));

        return $this->login($email, $pass);
    }

    function saveConfiguration()
    {


        $rset = $this->db->update('sitebar_config',
            array('params' => $this->implodeParams('config')));

        return true;
    }

/*** User functions ***/

    function signUp($email, $pass, $name, $comment,
        $createdByAdmin=false, $verified=false, $demoAccount=false)
    {
        $rset = $this->db->select(null, 'sitebar_user', array(
            'ucase(email)' => array('ucase' => $email)));

        $user = $this->db->fetchRecord($rset);

        if (is_array($user))
        {
            $this->error('This email is already used. '.
                'Did you forget your password?');
            return false;
        }

        $this->db->insert('sitebar_user', array(
            'email' => $email,
            'pass' => array('md5' => $pass),
            'name' => $name,
            'comment' => $comment,
            'verified' => ($verified?1:0),
            'demo' => ($demoAccount?1:0),
        ));

        $uid = $this->db->getLastId();

        // Join groups where verification is not neccessary and
        // return list of groups when it is.
        $closedMatchingGroups = $this->autoJoinGroups($uid, $email,
            $createdByAdmin);

        if ($this->getParam('config','use_mail_features') && !$createdByAdmin)
        {
            if (count($closedMatchingGroups))
            {
                $groups = implode(', ', $closedMatchingGroups);
                $url = $this->getVerificationUrl($uid, $email);
                $subject = Page::title() . ": Email Verification";
                $msg = <<<_MSG
Your e-mail address matches rules for auto join to following
closed group(s):
    $groups.

In order to aprove your membership, your email address must
be verified. Please click on the following link to verify it:
    $url
_MSG;
                // Verify email
                $this->sendMail($email, $subject, $msg);
            }

            $url = Page::baseurl();
            $msg = <<<_SIGN_UP
User "$name" <$email> signed up
to your SiteBar installation at $url.
_SIGN_UP;

            $this->sendMail(null, 'SiteBar: New SiteBar user', $msg);
        }

        // Always greater then zero
        return $uid;
    }

    function getVerificationUrl($uid='', $email='')
    {
        if (!$uid)
        {
            $uid = $this->uid;
        }

        if (!$email)
        {
            $email = $this->email;
        }

        $code = rand(100000, 999999);

        // Update user with generated code
        $this->db->update('sitebar_user', array('code'=> $code),
            array('uid'=>$uid));

        return Page::url().
            '?command=Verify%20Email%20Code'.
            '&code='.$code.
            '&email='.$email;
    }

    function verifyEmail($email, $code)
    {
        $user = $this->getUserByEmail($email);

        if (!$user)
        {
            $this->error('Access denied!');
            return;
        }

        if (!$user['verified'])
        {
            // Code matching
            if ($user['code']==$code)
            {
                $this->autoJoinGroups($user['uid'], $user['email'], true);
                $this->db->update('sitebar_user', array('verified'=> 1),
                    array('uid'=>$user['uid']));
            }
            else
            {
                $this->error('Invalid code, verification disabled!');
                $this->db->update('sitebar_user', array('code'=> null),
                    array('uid'=>$user['uid']));
            }
        }
    }

    function sendMail($to,  $subject, $msg, $headers='')
    {
        $admin = $this->getUser(ADMIN);
        if (!$headers)
        {
            $headers  = "From: \"SiteBar Admin\" <".$admin['email'].">\r\n";
        }

        if (!$to)
        {
            $to = $admin['email'];
        }

        if (!@mail($to, $subject, $msg, $headers))
        {
            $this->warn('Cannot send email!');
            return false;
        }
    }

    function removeUser($uid)
    {
        $groups = $this->getModeratedGroups($uid);

        if (count($groups))
        {
            $names = array();
            foreach ($groups as $gid => $rec)
            {
                $names[] = $rec['name'];
            }
            $this->error('Cannot delete member because he is moderator of '.
                'the following group(s): '. implode(', ',$names) .'.');
            return false;
        }

        $rset = $this->db->delete('sitebar_user', array('uid' => $uid));
        $rset = $this->db->delete('sitebar_member', array('uid' => $uid));

        return true;
    }

    function userSettings($pass,$name,$comment)
    {
        if ($pass)
        {
            $this->changePassword($this->uid, $pass);
            $this->login($this->email, $pass);
        }

        $this->db->update('sitebar_user',
            array(
                'name' => $name,
                'comment' => $comment,
                'params' => $this->implodeParams('user'),
                ),
            array('uid'=>$this->uid));

        return true;
    }

    function modifyUser($uid, $pass, $name, $comment, $verified, $demo)
    {
        if ($pass)
        {
            $this->changePassword($uid, $pass);
        }

        $this->db->update('sitebar_user',
            array(
                'name' => $name,
                'comment' => $comment,
                'verified' => ($verified?1:0),
                'demo' => ($demo?1:0)
                ),
            array('uid'=>$uid));
    }

    function checkPassword($uid, $pass)
    {
        $rset = $this->db->select(null,'sitebar_user', array(
            'pass' => array('md5' => $pass),
            '^1' => 'AND',
            'uid'=>$uid));

        return is_array($this->db->fetchRecord($rset));
    }

    function changePassword($uid, $pass)
    {
        $this->db->update('sitebar_user',
            array('pass' => array('md5' => $pass)),
            array('uid'=>$uid));
    }

/*** Group functions ***/

    function addGroup($name, $comment, $uid, $allow_addself, $allow_contact, $auto_join)
    {
        $rset = $this->db->select(null, 'sitebar_group', array(
            'name' => $name));

        $group = $this->db->fetchRecord($rset);

        if (is_array($group))
        {
            $this->error('Group name "'. $group['name'] .'" is already used!');
            return false;
        }

        $this->db->insert('sitebar_group', array(
            'name' => $name,
            'comment' => $comment,
            'allow_addself' => $allow_addself,
            'allow_contact' => $allow_contact,
            'auto_join' => $auto_join,
        ));

        $gid = $this->db->getLastId();
        $this->addMember($gid, $uid, true);

        // Always greater then zero
        return $gid;
    }

    function removeGroup($gid)
    {
        $this->db->delete('sitebar_acl', array('gid'=>$gid));
        $this->db->delete('sitebar_member', array('gid'=>$gid));
        $this->db->delete('sitebar_group', array('gid'=>$gid));
    }

    function updateGroup($gid, $name, $comment, $allow_addself, $allow_contact, $auto_join)
    {
        $this->db->update('sitebar_group',
            array('name' => $name,
                'comment' => $comment,
                'allow_addself' => $allow_addself,
                'allow_contact' => $allow_contact,
                'auto_join' => $auto_join),
            array('gid'=>$gid));
    }

    function addMember($gid, $uid, $moderator=false)
    {
        $this->db->insert('sitebar_member', array(
            'gid' => $gid,
            'uid' => $uid,
            'moderator' => $moderator?1:0),
            array(1062)); // Ignore duplicate membership
    }

    function removeMember($gid, $uid)
    {
        $this->db->delete('sitebar_member',
            array('gid'=>$gid, '^1'=>'AND', 'uid'=>$uid));
    }

    function updateMember($gid, $uid, $moderator)
    {
        $this->db->update('sitebar_member',
            array('moderator' => ($moderator?1:0)),
            array('gid'=>$gid, '^1'=>'AND', 'uid'=>$uid));
    }

    function showPublic()
    {
        return in_array($this->config['gid_everyone'],
            array_keys($this->getUserGroups()));
    }

/*** Search functions ***/

    function getUser($uid)
    {
        $rset = $this->db->select(null, 'sitebar_user',
            array('uid' => $uid));
        return $this->db->fetchRecord($rset);
    }

    function getUserByEmail($email)
    {
        $rset = $this->db->select(null, 'sitebar_user',
            array( 'email'=> $email));
        return $this->db->fetchRecord($rset);
    }

    function getUsers()
    {
        $rset = $this->db->select('uid, email, name, params', 'sitebar_user', null, 'uid');
        $users = array();

        foreach ($this->db->fetchRecords($rset) as $rec)
        {
            if ($rec['uid'] == ANONYM) continue;
            $users[$rec['uid']] = $rec;
        }

        return $users;
    }

    function getMembers($gid, $moderators=false)
    {
        $where = array('gid'=>$gid);
        if ($moderators)
        {
            $where['^1'] = 'AND';
            $where['moderator'] = 1;
        }
        $rset = $this->db->select('u.uid, email, moderator',
            'sitebar_member m natural join sitebar_user u', $where);
        $members = array();

        foreach ($this->db->fetchRecords($rset) as $rec)
        {
            $members[$rec['uid']] = $rec;
        }

        return $members;
    }

    function getModeratedGroups($uid)
    {
        $rset = $this->db->select('g.gid, g.name',
            'sitebar_group g natural join sitebar_member m',
            array('uid'=>$uid, '^1'=> 'AND', 'moderator'=>1 ), 'name');

        $groups = array();

        foreach ($this->db->fetchRecords($rset) as $rec)
        {
            $groups[$rec['gid']] = $rec;
        }

        return $groups;
    }

    function getUserGroups($uid=null)
    {
        if (!$uid)
        {
            $uid = $this->uid;
        }

        $rset = $this->db->select('g.gid, g.name, moderator',
            'sitebar_group g natural join sitebar_member m',
            array('uid'=>$uid), 'name');

        $groups = array();

        foreach ($this->db->fetchRecords($rset) as $rec)
        {
            $groups[$rec['gid']] = $rec;
        }

        return $groups;
    }

    function getGroup($gid)
    {
        $rset = $this->db->select(null, 'sitebar_group',
            array( 'gid'=> $gid), 'name');
        $group = $this->db->fetchRecord($rset);

        if (!$group)
        {
            $this->error("Group has already been deleted.");
            return null;
        }

        return $group;
    }

    function getGroups()
    {
        $rset = $this->db->select(null, 'sitebar_group', null, 'name');
        $groups = array();

        foreach ($this->db->fetchRecords($rset) as $rec)
        {
            $groups[$rec['gid']] = $rec;
        }

        return $groups;
    }

    function autoJoinGroups($uid, $email, $verified=false)
    {
        $groups = array();

        // Add member to all groups that have auto_join filled and matching
        foreach ($this->getGroups() as $gid => $rec)
        {
            $res = $this->canJoinGroup($rec, $uid, $email, $verified);

            if ($res === true)
            {
                $this->addMember($gid, $uid);
            }
            elseif ($res === null) // Verification missing, note group name
            {
                // Otherwise return
                $groups[] = $rec['name'];
            }
        }

        return $groups;
    }

    function canJoinGroup(&$groupRec, $uid=null, $email=null, $verified=null)
    {
        if ($uid===null) $uid = $this->uid;
        if ($email===null) $email = $this->email;
        if ($verified===null) $verified= $this->verified;

        if ($groupRec['auto_join'])
        {
            if ($groupRec['auto_join']{0} != '/')
            {
                $groupRec['auto_join'] = '/'.$groupRec['auto_join'].'/i';
            }

            // It can happen that the pattern cannot compile - ignore it then
            if (@preg_match($groupRec['auto_join'], $email))
            {
                // If open group or mail already verified or demo account
                // then allow direct add self
                if ($groupRec['allow_addself'] || $verified || $this->demo)
                {
                    return true;
                }
                else
                {
                    // Otherwise signal that verification required
                    return null;
                }
            }
        }

        return false;
    }
}
?>