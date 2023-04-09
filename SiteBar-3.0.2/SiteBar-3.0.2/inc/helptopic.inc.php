<?

function getHelpTopics()
{
    return array
    (
        100 => 'Usage Tips',
            101 => 'Drag &amp; Drop',
            102 => 'Adding Links',
            103 => 'Tool Bar Functions',

        200 => 'Commands',
            210 => 'Session Management',
            220 => 'Installation &amp; Maintenance',
            230 => 'Account Management',
            240 => 'User Management',
            250 => 'Group Management',
            260 => 'Folder Operations',
            270 => 'Link Operations',

        300 => 'Technical Info',
            301 => 'Compatibility',
            302 => 'Security Mechanism',
            303 => 'Skins',
    );
}

function getHelp($params)
{
    $topic = $params['topic'];

if ($topic==100) : ?>

SiteBar functions are accessible from the <strong>User menu</strong> and from
folder and link <strong>Context menus</strong>. The User menu is shown at the
bottom of the SiteBar, and context menus are accessible by right clicking on
folders or links (Opera/Macintosh users can use Ctrl-click instead).
<p>
Both context and user menus can show different subset of commands for  different
users based on their rights in the system. Some items might be disabled  in  the
context menu based user rights to nodes and on current program  state.  Commands
are executed via Command Window.

<? elseif ($topic==101) : ?>

Click on a folder or a link with mouse and move mouse cursor over another folder while holding
the button pressed. Dragging is signalled by highlighting the target folder. Release the mouse
button to drop the dragged link or folder to the currently highlighted folder.
<p>
Drag &amp; Drop is not implemented by SiteBar team for Opera browsers. Copy and Paste
should be used instead.

<? elseif ($topic==102) : ?>

The most convenient way to add links is to use so called bookmarklet. You can create
bookmarklet from the homepage of your SiteBar installation, which should be by default
available by clicking on the SiteBar logo. Internet Explorers can use context menu
if they use an installer described on the same page as the bookmarklet.

<? elseif ($topic==103) : ?>

<p><strong>Search</strong> - Allows searching in all displayed links. It is
possible to specify what should be searched using prefixes
<strong>url:</strong>, <strong>name:</strong>, <strong>desc:</strong>,
<strong>all:</strong>. Default prefix is <strong>name:</strong>. When matching
link or folder is found it is highlighted and a javascript confirm window is
shown with some details. User has possibility to continue with searching or to
stop it.

<p><strong>Highlight</strong> - The same as search but without javascript alert.

<p><strong>Collapse All</strong> - Collapses all nodes. When clicked while
holding Ctrl key then  expands all nodes.

<p><strong>Reload</strong> - Reloads all links from server, this function is
here because the  plugin is hosted in sidebar where the user might not have
(depending on the  browser) possibility to reload it.

<? elseif ($topic==200) : ?>

Commands are grouped into several logical groups. Please select one of the
groups to see help for the command.

<? elseif ($topic==210) : ?>

<p><strong>Log In</strong> - Logs user in the system, the user is always
remembered using cookies. User can specify when the cookie should expire.

<p><strong>Log Out</strong> - Logs out the user. This should be always used on
public terminals. An equivalent is to use login with session duration and to
close all browser windows.

<p><strong>Sign Up</strong> - Allows a visitor to sign up to the system. Based
on the email  address to user might qualify to join some groups. In this case
the email  must be verified. This is done automatically by sending a
verification email  to the user. Admin of the system can disable sign-up of
new users.

<? elseif ($topic==220) : ?>

<p><strong>Set Up</strong> - The first command an administrator will see when
installing SiteBar  and after setting up a database. An admin account will be
created and basic sitebar parameters will be set up. When "Personal Mode" option is
selected then only a subset of functions will be available.

<p><strong>SiteBar Settings</strong> - Admins can later change SiteBar
parameters. Admins are  members of Admins group and the user created using the
"Set Up" command. See  "Sign Up" for explanation of email features. There are
more email features  planned in future releases.

<p><strong>Create Tree</strong> - Depending on SiteBar settings only admins
and/or users with  verified email can create new trees. When a new tree is
created it must be  associated with an existing user (only admin can create tree
for someone  else). The standard way to create team bookmarks is to create a new
tree and  assign it to the user who moderates the group, created separately
using  "Create Group". This user can then grant rights on the newly created tree
to  the group members and can add members to the group.

<? elseif ($topic==230) : ?>

<p><strong>User Settings</strong> - Change user settings. When "External Commander"
is not checked, the Command Window will open in place of SiteBar rather then in an
external window. Some commands always open in place ("Log In", "Log Out",  "Sign Up",
"User Settings"). When "Skip Execution Messages" is checked no confirmation screen is
shown upon successful command execution. "Decorate ACL Folders" will mark those folders
that have security specification. This switch slows down SiteBar display.

<p><strong>Membership</strong> - Users can leave any group and join opened
groups. Users cannot  leave groups if the group would then lose the last
moderator. In this case  admin should be contacted to delete the group.

<p><strong>Verify Email</strong> - Allows user to verify his email address to
use other system  functions.

<? elseif ($topic==240) : ?>

<p><strong>Maintain Users</strong> - Shows a list box with users and allows the
following commands  to be executed.

<p><strong>Modify User</strong> - Currently the only way to recover a forgotten
password is to  set a temporary password, email it to the user and ask him/her
to change it. Administrator can mark account as demo, what disallows user to
change some properties, especially password.

<p><strong>Delete User</strong> - Deletes the user and all memberships.
Reassigns existing  trees to another user. It is not permitted to delete a user
who is the only  moderator of any group.

<p><strong>Create User</strong> - The same as "Sign Up" but is intended for the
administrator. The  emails of created users are treated as verified.

<? elseif ($topic==250) : ?>

<p><strong>Maintain Groups</strong> - Shows a list box with groups and allows
following commands  to be executed.

<p><strong>Group Properties</strong> - Accessible to moderators of the group.
Allows changing  group name comment and auto join email regular expression. When
the auto  join regexp is filled and matches the email address on sign-up of a
new user  the user is asked to verify the email and upon verification he becomes
 automatically group member. When "Allow Self Add" is checked, the email does
not need to be verified for auto join.

<p><strong>Group Members</strong> - Only moderators can select which users are
members. Another  moderator cannot be unselected, the moderator role must be
firstly removed  using following command.

<p><strong>Group Moderators</strong> - Accessible to moderators of the group.
There must be always  at least one moderator.

<p><strong>Delete Group</strong> - Accessible to admins only, deletes a group
and all memberships.

<p><strong>Create Group</strong> - Accessible to admins only, creates a group
and specifies the  first moderator of a group.

<? elseif ($topic==260) : ?>

<p><strong>Add Folder</strong> - Adds a new subfolder to the folder.

<p><strong>Add Link</strong> - Adds a link to the folder. When executed from the
bookmarklet it  allows the user to select a target folder, otherwise it is
created in the  folder from which the command has been called.

<p>

<p><strong>Folder Properties</strong> - Specify folder properties - name and
description.

<p><strong>Purge Folder</strong> - Purges previously deleted folders or links
inside the selected  folder. It is not possible for anyone to undelete anything
which was purged!

<p><strong>Delete Folder</strong> - Deletes folder. Deleted folder can be
undeleted using  "Undelete" command or by adding folder with the same name. User
can delete  even his own root folder, however this deletion is only valid after
purge is  called in that folder.

<p><strong>Undelete</strong> - Recover previously deleted folders or links,
unless purged. When a  root folder is deleted it is shown usually with greyscale
icon and is  visible to tree owner only. This removes granted rights from other
group  members what means another level of security that should prevent unwanted
 lost of bookmarks.

<p>

<p><strong>Copy</strong> - Copy folder and all its content to the internal
clipboard.

<p><strong>Paste</strong> - Available only when "Copy" or "Copy Link" command
has been executed.  The "Paste" command determines whether the user can move the
content or  only copy it and select proper default value. However the user can
still  select copying or moving.

<p>

<p><strong>Export Bookmarks</strong> - Exports the content of the folder to an
external bookmark  file. Netscape bookmark file format + Opera Hotlist are
supported. Mozilla  uses Netscape bookmark file format and Internet Explorer can
export and  import to and from this format.

<p><strong>Import Bookmarks</strong> - Imports bookmarks from an external file
to the folder. No  link validations are performed at this step in order to avoid
timeout on  the server side.

<p><strong>Security</strong> - Available only for root folder. Allows specifying
access rights to  entire tree. See "Security Management" section for more
information.

<? elseif ($topic==270) : ?>

<p><strong>Email Link</strong> - Allows a link to be sent via email to another
person. For users  with verified email, internal mail system can be utilized,
otherwise  external program must be started.

<p><strong>Copy Link</strong> - Copy link to the internal clipboard. Use "Paste"
command on folder  to copy/move link to the node.

<p><strong>Delete Link</strong> - Delete link from the node. Deleted link can be
undeleted using  the "Undelete" command on the parent folder or in case a link
with the same  name or URL is added.

<p><strong>Properties</strong> - Edit properties of a link. Allows to set link
as private.

<? elseif ($topic==300) : ?>

SiteBar 3 is a complete re-write from the 2.x series, representing the further
evolution of SiteBar.
<p>
SiteBar 3 no longer uses any JavaScript for rendering of the bookmark trees.
However JavaScript is used havily to display context menus and to
expand/collapse nodes including icon chages.
<a href="http://www.w3.org/TR/DOM-Level-2-Core/">Document Object Model Level 2</a>
must be supported by the browser. The advantage of this is very fast and incremental
bookmark loading. The drawback is that older browsers can only see the bookmark tree
expanded and have only read access to it (what is still an improvement to version
2.x which failed to display on older browsers at all).
<p>
On the server side the data is stored with the most simple recursive data
structure and is optimized for tree modifications. This gives very good
performance for selecting. Thanks to the database table indexes selecting should
not slow down with a very large number of links.

<? elseif ($topic==301) : ?>

SiteBar has been tested with following browsers

<ul>
    <li>Mozilla 1.4, 1.5a
    <li>Mozilla Firebird 0.61, 0.7
    <li>Galeon 1.3.7
    <li>Internet Explorer 6.0
    <li>Opera 7.11, 7.21
</ul>

Following browsers allow read only access:

<ul>
    <li>Pocket Internet Explorer 2002
    <li>Netscape Navigator 4.78
</ul>

<? elseif ($topic==302) : ?>

SiteBar 3 does double-checking when it comes to user rights. The user  is  shown
only a subset of commands for execution based on his  rights  and  every  issued
command is verified for the second time just before execution.
<p>
The system has three basic roles, users, moderators and admins.  Moderators  are
users that were marked as moderator upon group creation or by  other  moderator.
A moderator is a role bound to  a  particular  group  only.  Administrators  are
members of the Admins group plus the first user created by the "Set Up" command.
Administrators do not have right to act as moderators. They can, however, delete
complete groups.
<p>
SB3 was developed to suit needs of multiple teams. That means that  a  group  of
users can share bookmarks. In order to keep the team's bookmarks private  access
control mechanism has been developed.
<p>
The building stone of this mechanisms is that the owner of a root folder of any tree
has unlimited rights to the complete tree. Upon sign-up or user creation a  root
folder is created for each user. Additionally admins can create additional trees
for any users or allow other users to create their own new trees.
<p>
When the tree is created the user can specify rights to his tree to  other  user
groups. The following rights are available for any user group:

<p><strong>Read</strong> - Group user can use bookmarks, if he does not want to
see them, he must  leave the group.

<p><strong>Add</strong> - User can add folders and links. Usually allowed for
public trees.

<p><strong>Modify</strong> - Define properties of links or folders.

<p><strong>Delete</strong> - Delete link or folder.

<p><strong>Purge</strong> - Purge previously deleted link or folder, together
with 'Delete' allows  folder to be moved from one tree to another.

<p><strong>Grant</strong> - Group members have the same rights to the tree as
its owner.

<p>
The rights are always inherited from the parent folders. The root folder has  by
default no right for any group. User can specify more restrictive access to some
folder, what has influence on child folders. If the rights for a folder are  the
same as for the parent folder, the right specification for the current folder is
removed and inheritance is used instead.
<p>
Group moderators have always right to remove any right specified for their group
by any user.
<p>
Additionally to the folder security mechanism there is  a  solution  for  links,
that allows keeping certain links private in  otherwise  published  folder.  The
owner of a tree can mark any link as private what disables this link from  being
listed and from any other operation from other users. It  is  not  necessary  to
marks the links as private if there is no sharing on folder level  defined  (and
by default there is none).
<p>
The bigger the number of access control specifications on folder  level  is  the
longer it takes to load the bookmarks to all users. Specifications should not be
overused on deep nested trees.
<p>
When the admin of SiteBar checks "Personal Mode"  selection  that  the  security
command is not available, instead there is "Publish Folder"  option  in  "Folder
Properties". In this mode it is not possible to restrict  rights  from  a  child
folder when parent node is already published. It is possible  to  switch  freely
between personal and the default "enterprise" mode, however it is  not  possible
to remove any rights granted on other then Everyone group.
",

<? elseif ($topic==303) : ?>

SiteBar allows user skins to be created. Good knowledge of CSS is required for
skin design. In order to create new skins an existing skin should be taken as a
base. This means to take any of the existing skins in directory "skins" and
create a copy of it. Each skin consists of several pictures (PNG format is used
due to pending GIF related rights in Europe till 2004), one cascading
style-sheet "sitebar.css" and PHP file with hooks, "hook.php". In the hook file
it is possible to change the header or footer of sitebar installation.
<p>
Some administrators might want to create their own skin to match the design of their
site. In this case it is recommended to remove all other skins and to choose the
default skin in SiteBar Settings. If you would like to include your skin to
SiteBar distribution then you have to contact development team and test your
skin with the newest stable development version. As a rule SiteBar and
SourceForge logo must be on the page, however SiteBar logo can be freely
updated.

<? endif;
   echo "<p>";
}
?>
