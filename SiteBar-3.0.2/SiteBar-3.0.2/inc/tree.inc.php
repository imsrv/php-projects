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

class Tree_Link
{
    var $id;
    var $id_parent;
    var $url;
    var $name;
    var $private;
    var $comment;
    var $favicon;

    function Tree_Link($rlink)
    {
        $this->id       = @$rlink['lid'];
        $this->id_parent= @$rlink['nid'];
        $this->url      = @$rlink['url'];
        $this->name     = @$rlink['name'];
        $this->private  = @$rlink['private'];
        $this->comment  = @$rlink['comment'];
        $this->favicon  = @$rlink['favicon'];
    }
}

class Tree_Node
{
    var $_nodes = array();
    var $_links = array();

    var $db;
    var $um;
    var $tree;

    var $id;
    var $id_parent;
    var $name;
    var $comment;
    var $deleted_by;

    var $parent = null;
    var $level = 0;
    var $myTree = false;
    var $acl = null;

    function Tree_Node($rnode=null)
    {
        $this->db =& Database::staticInstance();
        $this->um =& UserManager::staticInstance();
        $this->tree =& Tree::staticInstance();

        if ($rnode)
        {
            $this->id       = @$rnode['nid'];
            $this->id_parent= @$rnode['nid_parent'];
            $this->name     = @$rnode['name'];
            $this->comment  = @$rnode['comment'];
            $this->deleted_by = @$rnode['deleted_by'];
        }
    }

    function setParent(&$parent)
    {
        $this->parent =& $parent;
        $this->level = $parent->level+1;
        $this->myTree = $parent->myTree;
    }

    function addLink($link)
    {
        $this->_links[] = $link;
    }

    function addNode(&$node)
    {
        $this->_nodes[] = $node;
    }

    function getLinks()
    {
        return $this->_links;
    }

    function getNodes()
    {
        return $this->_nodes;
    }

    function nodeCount()
    {
        return count($this->_nodes);
    }

    function linkCount()
    {
        return count($this->_links);
    }

    function childrenCount()
    {
        return $this->linkCount() + $this->nodeCount();
    }

    function isVisible()
    {
        return in_array($this->id,$this->tree->getACLNodes());
    }

    function hasRight($right='select')
    {
        // Populate $acl
        $this->getACL();
        return $this->myTree || $this->acl['allow_'.$right];
    }

    function hasACL()
    {
        $has = null;

        if ($has === null)
        {
            $rset = $this->db->select('count(*) count', 'sitebar_acl',array('nid'=>$this->id));
            $rec = $this->db->fetchRecord($rset);
            $has = $rec['count'];
        }
        return $has;
    }

    function & getACL()
    {
        if ($this->acl !== null)
        {
            return $this->acl;
        }

        static $groups = null;

        // Top-down access, find parents and check whether it is our tree
        if (!$this->parent)
        {
            $node =& $this;

            while ($node->id_parent)
            {
                $parent = $this->tree->getNode($node->id_parent);
                $node->setParent($parent);
                $node =& $parent;
            }

            if ($this->tree->getRootOwner($node->id) == $this->um->uid)
            {
                $this->myTree = 1;
            }
        }

        // If we are the owner then we have all rights
        if ($this->myTree)
        {
            $rec = array();
            $this->_setit($rec, 1);
        }
        else // Otherwise check groups
        {
            // If we know parent's ACL then use it for initiaizalion
            $rec = ($this->parent?$this->parent->getACL():array());

            // Get user groups - valid for the whole execution.
            if ($groups===null)
            {
                $groups = array_keys($this->um->getUserGroups());
            }

            if (count($groups))
            {
                $where = array(
                        '^1'=>'gid in (' . implode(',',$groups). ')',
                        '^2'=>'AND',
                        'nid'=>$this->id);

                $rset = $this->db->select('count(*) count','sitebar_acl',$where);
                $countrec = $this->db->fetchRecord($rset);

                // We have ACL for this node
                if ($countrec['count'])
                {
                    $rset = $this->db->select(
                        array_values(array_map(array($this,'_maxit'), $this->tree->rights)),
                        'sitebar_acl', $where);
                    $rec = $this->db->fetchRecord($rset);
                }
                else
                {
                    if ($this->parent)
                    {
                        $rec = $this->parent->getACL();
                    }
                    else
                    {
                        // No parent no ACL -> noaccess
                        $this->_setit($rec, 0);;
                    }
                }
            }
            else
            {
                // No group - no rights
                $this->_setit($rec, 0);
            }
        }

        $this->acl = $rec;
        return $this->acl;
    }

    function getGroupACL($gid)
    {
        $rset = $this->db->select(null, 'sitebar_acl',
            array( 'gid'=> $gid, '^1'=>'AND', 'nid'=>$this->id));
        return $this->db->fetchRecord($rset);
    }

    function getParentACL($gid)
    {
        $acl = null;
        $parent = null;

        if ($this->id_parent)
        {
            $parent = $this->tree->getNode($this->id_parent);
            $acl = $parent->getGroupACL($gid);
        }

        return $acl||!$parent?$acl:$parent->getParentACL($gid);
    }

    function removeACL($gid=null)
    {
        $where = array('nid'=>$this->id);

        if ($gid!==null)
        {
            $where['^1'] = 'AND';
            $where['gid'] = $gid;
        }

        $rset = $this->db->delete('sitebar_acl', $where);
    }

    function updateACL($gid, $acl)
    {
        $this->removeACL($gid);

        $data = array( 'gid'=> $gid, 'nid'=>$this->id);
        foreach ($acl as $column => $value)
        {
            if (strstr($column, 'allow_'))
            {
                $data[$column] = $value;
            }
        }

        $this->db->insert('sitebar_acl', $data, array(1062));
    }

    function _maxit($right)
    {
        return "max(allow_$right) as allow_$right";
    }

    function _setit(&$rights, $flag, $exception=array())
    {
        foreach ($this->tree->rights as $right)
        {
            if (in_array($right, $exception)) continue;
            $rights['allow_'.$right] = $flag;
        }
    }

    function isPublishedByParent()
    {
        if ($this->id_parent)
        {
            $parent = $this->tree->getNode($this->id_parent);
            $acl = $parent->getGroupACL($this->um->config['gid_everyone']);

            // We have acl, is the folder published?
            if ($acl)
            {
                return $acl['allow_select'];
            }

            // Yep recursive, try to find first parent node with ACL
            return $parent->isPublishedByParent();
        }
        else
        {
            return false;
        }
    }

    function publishFolder($publish)
    {
        $gid = $this->um->config['gid_everyone'];
        $acl = $this->getGroupACL($gid);

        // Remove sharing
        if ($acl && !$publish)
        {
            // Shared directly, the user might be
            // surprised that the folder will be
            // still published via its parent.
            $this->removeACL($gid);
        }
        else if (!$acl && $publish) // Share it
        {
            $acl = array();
            $this->_setit($acl, 0);
            $acl['allow_select'] = 1;
            $this->updateACL($gid, $acl);
        }
    }

}

class Tree extends ErrorHandler
{
    var $db;
    var $um;
    var $aclNodes = null;
    var $rights = array('select','insert','update','delete','purge','grant');

    function Tree()
    {
        $this->db =& Database::staticInstance();
        $this->um =& UserManager::staticInstance();
    }

    function & staticInstance()
    {
        static $tree;

        if (!$tree)
        {
            $tree = new Tree();
        }

        return $tree;
    }

/* Load existing tree */

    function loadRoots()
    {
        $uid = $this->um->uid;

        $roots = array();
        $select = 'n.*';
        $from = 'sitebar_root t natural join sitebar_node n';

        $rset = $this->db->select( $select, $from,
            array('uid'=>$uid), 'nid');

        foreach ($this->db->fetchRecords($rset) as $root)
        {
            $root = new Tree_Node($root);
            $root->myTree = true;
            $roots[] = $root;
        }

        // Deleted root can see only his author
        $rset = $this->db->select( $select, $from,
            array('^1'=>'uid <> '.$uid, '^2'=>'AND', 'deleted_by'=>null), 'nid');

        foreach ($this->db->fetchRecords($rset) as $root)
        {
            $root = new Tree_Node($root);
            $root->myTree = false;

            if ($root->hasRight() || $root->isVisible())
            {
                $roots[] = $root;
            }
        }

        return $roots;
    }

    function loadNodes(&$parent, $loadLinks=true, $right='select')
    {
        $rset = $this->db->select( null, 'sitebar_node',
            array('nid_parent'=>$parent->id,
                '^1'=>'AND', 'deleted_by'=>null), 'name');

        foreach ($this->db->fetchRecords($rset) as $rnode)
        {
            $node = new Tree_Node($rnode);
            $node->setParent($parent);
            $this->loadNodes($node, $loadLinks, $right);

            // If we have direct right or visible children
            if (!$node->deleted_by && ($node->hasRight($right) || $node->childrenCount()))
            {
                $parent->addNode($node);
            }
        }

        if ($loadLinks)
        {
            $this->loadLinks($parent);
        }
    }

    function loadLinks(&$parent)
    {
        if (!$parent->hasRight())
        {
            return;
        }

        $where = array('nid'=>$parent->id, '^1'=>'AND', 'deleted_by'=>null);

        if (!$parent->myTree)
        {
            $where['^2'] = 'AND';
            $where['private'] = '0';
        }

        $rset = $this->db->select( null, 'sitebar_link', $where, 'name');
        foreach ($this->db->fetchRecords($rset) as $rlink)
        {
            $parent->addLink(new Tree_Link($rlink));
        }
    }

    function importTree($nid_parent, $node)
    {
        foreach ($node->getLinks() as $link)
        {
            $this->addLink($nid_parent, $link->name, $link->url, $link->favicon,
                false, $link->comment);
        }

        foreach ($node->getNodes() as $childnode)
        {
            $nid = $this->getNodeIDByName($nid_parent, $childnode->name);

            if (!$nid) // If we do not have the folder - create it!
            {
                $nid = $this->addNode($nid_parent, $childnode->name, $childnode->comment);
            }

            $this->importTree($nid, $childnode);
        }
    }

    function & getACLNodes()
    {
        if ($this->aclNodes !== null)
        {
            return $this->aclNodes;
        }

        $gids = array_keys($this->um->getUserGroups());

        if (!count($gids))
        {
            $this->aclNodes = array();
            return $this->aclNodes;
        }

        $rset = $this->db->select('nid', 'sitebar_acl',
                    array( '^1'=> 'gid in ('.implode(',',$gids).')'));

        $nodes = array();

        foreach ($this->db->fetchRecords($rset) as $rec)
        {
            $nid = $rec['nid'];
            $nodes[] = $nid;
            $parents = $this->getParentNodes($nid);

            if ($parents===null)
            {
                $this->fatal("Node number $nid has ACL record but does not exist!");
            }

            foreach ($parents as $nid)
            {
                $nodes[] = $nid;
            }
        }

        $this->aclNodes = array_unique($nodes);
        return $this->aclNodes;
    }

    function getNode($nid)
    {
        $rset = $this->db->select( null, 'sitebar_node', array('nid'=>$nid));
        $rnode = $this->db->fetchRecord($rset);

        if (!$rnode)
        {
            $this->error("Folder has already been deleted.");
            return null;
        }

        return new Tree_Node($rnode);
    }

    function getNodeIDByName($nid_parent, $name)
    {
        $rset = $this->db->select( 'nid', 'sitebar_node',
            array('nid_parent'=>$nid_parent, '^1'=>'AND', 'name'=>$name));
        $rnode = $this->db->fetchRecord($rset);

        return $rnode?$rnode['nid']:0;
    }

    function getRootOwner($nid)
    {
        $rset = $this->db->select( null, 'sitebar_root', array('nid'=>$nid));
        $rtree = $this->db->fetchRecord($rset);

        if (!$rtree)
        {
            $this->error("Tree has already been deleted.");
            return null;
        }

        return $rtree['uid'];
    }

    function getUserRoots($uid)
    {
        $rset = $this->db->select( null, 'sitebar_root', array('uid'=>$uid));
        $roots = array();

        foreach ($this->db->fetchRecords($rset) as $rtree)
        {
            $roots[] = $rtree['nid'];
        }

        return $roots;
    }

    function changeOwner($olduid, $newuid)
    {
        $rset = $this->db->update( 'sitebar_root',
            array( 'uid' => $newuid),
            array( 'uid' => $olduid));

        return $rset;
    }

    function getRootNode($nid)
    {
        $node = $this->getNode($nid);

        while ($node->id_parent)
        {
            $node = $this->getNode($node->id_parent);
        }

        return $node;
    }

    function getParentNodes($nid)
    {
        $parents = array();

        $node = $this->getNode($nid);

        if (!$node)
        {
            return null;
        }

        while ($node && $node->id_parent)
        {
            $parents[] = $node->id_parent;
            $node = $this->getNode($node->id_parent);
        }

        return $parents;
    }

    function getOwner($nid)
    {
        $node = $this->getRootNode($nid);

        if (!$node)
        {
            return;
        }

        $rset = $this->db->select('uid', 'sitebar_root',
            array( 'nid' => $node->id));

        $rec = $this->db->fetchRecord($rset);

        if (!$rec)
        {
            $this->error('Tree has been deleted!');
            return false;
        }

        // Always greater then zero
        return $rec['uid'];
    }

    function inMyTree($nid)
    {
        $root = $this->getRootNode($nid);
        $uid = $this->getRootOwner($root->id);
        return $uid == $this->um->uid;
    }

    function addNode($nid_parent, $name, $comment=null, $undelete=true)
    {
        $rset = $this->db->insert( 'sitebar_node',
            array( 'nid_parent' => $nid_parent,
                   'name'       => $name,
                   'comment'    => $comment
            ),
            array(1062));

        // If we have duplicate
        if (!$rset)
        {
            if ($undelete)
            {
                // Try to undelete
                $this->db->update( 'sitebar_node',
                    array('deleted_by'=>null),
                    array('nid_parent' => $nid_parent,
                          '^1'=>'AND deleted_by IS NOT NULL AND',
                          'name'=>$name));

                if ($this->db->getAffectedRows()==1)
                {
                    $this->warn("Previously deleted folder with the same ".
                        "name has been restored!");
                    $this->warn("To prevent deleted folder being restored, ".
                        "purge the target folder next time.");

                    // Return id
                    $rset = $this->db->select( 'nid', 'sitebar_node',
                        array('nid_parent' => $nid_parent,
                              '^1'=>'AND', 'name'=>$name));

                    $rec = $this->db->fetchRecord($rset);
                    return $rec?$rec['nid']:0;
                }
                else
                {
                    $this->error("Duplicate folder name.");
                }
            }
            else
            {
                $this->error("Duplicate folder name.");
            }
            return 0;
        }

        return $this->db->getLastId();
    }

    function addRoot($uid, $name, $comment=null)
    {
        $uniqName = $name;

        // Check wheter this name is not used for any other root
        for ($i=1; ;$i++)
        {
            $rset = $this->db->select( null, 'sitebar_node',
                array('name'=>$uniqName, '^1'=>'AND', 'nid_parent'=>0));
            $rnode = $this->db->fetchRecord($rset);

            // If not exists then we can use it
            if (!$rnode)
            {
                break;
            }

            $uniqName = $name . ' ' . $i;
        }

        $this->addNode(0, $uniqName, $comment, false);

        $rset = $this->db->insert( 'sitebar_root',
            array( 'uid' => $uid,
                   'nid' => $this->db->getLastId()));

        return $rset;
    }

    function removeNode($nid, $contentOnly)
    {
        $node = $this->getNode($nid);
        $where = array();
        $affected = 0;

        // If root node then content must be explicitly deleted
        if ($contentOnly || !$node->id_parent)
        {
            $this->db->update( 'sitebar_link',
                array( 'deleted_by'=>$this->um->uid,
                       't_changed'=> array('now'=>'')),
                array( 'nid'=>$nid, '^1'=> 'AND deleted_by IS NULL'));

            $affected += $this->db->getAffectedRows();
        }

        if ($contentOnly)
        {
            $where['nid_parent'] = $nid;
        }
        else
        {
            $where['nid'] = $nid;
        }

        $where['^1'] = 'AND deleted_by IS NULL';

        $rset = $this->db->update( 'sitebar_node',
            array('deleted_by'=>$this->um->uid), $where);

        $affected += $this->db->getAffectedRows();

        if ($affected==0)
        {
            if ($contentOnly)
            {
                $this->warn("There is no content to be deleted!");
            }
            else
            {
                if (!$node->id_parent)
                {
                    $this->warn("Purge folder to remove it permanently!");
                }
                else
                {
                    $this->warn("Folder has already been deleted!");
                }
            }
        }
        return $rset;
    }

    function purgeNode($nid, $root_deleted_by=null)
    {
        $node = $this->getNode($nid);

        $onlydeleted = '';

        // If the folder is not deleted then purge only deleted links/folders
        if (!$root_deleted_by && !$node->deleted_by)
        {
            $onlydeleted = 'AND deleted_by IS NOT NULL';
        }

        $this->db->delete( 'sitebar_link',
            array('nid'=>$nid, '^1'=>$onlydeleted));

        // Select all deleted folders and purge them as well
        $rset = $this->db->select( 'nid, name', 'sitebar_node',
            array('nid_parent'=>$nid, '^1'=>$onlydeleted));

        foreach ($this->db->fetchRecords($rset) as $rnode)
        {
            $this->purgeNode($rnode['nid'],
                $root_deleted_by||$node->deleted_by);
        }

        // If we currently have deleted folder, them delete ACL and itself
        if ($root_deleted_by || $node->deleted_by)
        {
            $this->db->delete( 'sitebar_acl', array( 'nid' => $nid ));
            $this->db->delete( 'sitebar_node', array( 'nid' => $nid ));

            if ($node->id_parent==0)
            {
                $this->db->delete( 'sitebar_root', array( 'nid' => $nid ));
            }
        }
    }

    function undeleteNode($nid)
    {
        $node = $this->getNode($nid);
        $affected = 0;

        $this->db->update( 'sitebar_link',
            array( 'deleted_by'=>null,
                   't_changed'=> array('now'=>'')),
            array( 'nid'=>$nid));
        $affected += $this->db->getAffectedRows();

        // Undelete child folders
        $rset = $this->db->update( 'sitebar_node',
        array('deleted_by'=>null), array('nid_parent'=>$nid));
        $affected += $this->db->getAffectedRows();

        // Undelete current node - can happen to root only
        $rset = $this->db->update( 'sitebar_node',
        array('deleted_by'=>null), array('nid'=>$nid));
        $affected += $this->db->getAffectedRows();

        if ($affected==0)
        {
            $this->warn("There is nothing to be undeleted!");
        }
        return $rset;
    }

    function updateNode($nid, $name, $comment=null, $uid=null)
    {
        $rset = $this->db->update( 'sitebar_node',
            array( 'name' => $name,
                   'comment'=> $comment),
            array( 'nid'  => $nid),
            array(1062));

        if (!$rset)
        {
            $this->error("Duplicate folder name.");
        }
        else
        {
            if ($uid)
            {
                $rset = $this->db->update( 'sitebar_root',
                    array( 'uid' => $uid),
                    array( 'nid'  => $nid),
                    array(1062));
            }
        }

        return $rset;
    }

    function moveNode( $nid, $nid_parent)
    {
        $node = $this->getNode($nid);

        // Just switch parent name
        $rset = $this->db->update( 'sitebar_node',
            array( 'nid_parent' => $nid_parent),
            array( 'nid'  => $nid),
            array(1062));

        if (!$rset)
        {
            $this->error("Duplicate folder name.");
        }
        elseif ($this->db->getAffectedRows()==0)
        {
            $this->error("Folder has already been deleted.");
        }

        // If root node
        if (!$this->hasErrors() && !$node->id_parent)
        {
            $this->db->delete( 'sitebar_root', array('nid' => $nid));
        }

        return $rset;
    }

    function copyNode( $nid, $nid_parent)
    {
        $node = $this->getNode($nid);
        $parent = $this->getNode($nid_parent);
        // Load source node to memory
        $this->loadNodes($node);
        // Create new parent folder with the same name as source
        $newid = $this->addNode($parent->id, $node->name, $node->comment);

        if (!$this->hasErrors())
        {
            // Import loaded tree to new parent
            $this->importTree($newid, $node);
        }
    }

/* Manage tree operations with links */

    function getLink($lid)
    {
        $rset = $this->db->select( null, 'sitebar_link', array('lid'=>$lid));
        $rlink = $this->db->fetchRecord($rset);

        if (!$rlink)
        {
            $this->error("URL has changed or the link has been deleted.");
            return null;
        }

        return new Tree_Link($rlink);
    }

    function addLink($nid, $name, $url, $favicon, $private=false, $comment=null, $undelete=true)
    {
        $rset = $this->db->insert( 'sitebar_link',
            array( 'nid' => $nid,
                   'name'=> $name,
                   'url' => $url,
                   'favicon' => $favicon,
                   'private' => $private?1:0,
                   'comment' => $comment,
                   't_changed' => array('now' => ''),
            ),
            array(1062));

        if (!$rset)
        {
            if ($undelete)
            {
                // Try to undelete
                $this->db->update( 'sitebar_link',
                    array('deleted_by'=>null,
                          't_changed' => array('now' => '')),
                    array('nid' => $nid,
                          '^1'=>'AND deleted_by IS NOT NULL AND (',
                          'name'=>$name,
                          '^2'=>'OR',
                          'url'=>$url,
                          '^3'=>')'));

                if ($this->db->getAffectedRows()>=1)
                {
                    $this->warn("Previously deleted link(s) with the same URL ".
                        "or name has been restored!");
                    $this->warn("To prevent deleted link(s) being restored ".
                        "purge the folder.");
                }
                else
                {
                    $this->warn("Duplicate name '$name' or URL '$url'.");
                }
            }
            else
            {
                $this->warn("Duplicate name '$name' or URL '$url'.");
            }
            return 0;
        }

        return $this->db->getLastId();
    }

    function updateLink($lid, $name, $url, $favicon, $private=false, $comment=null)
    {
        $rset = $this->db->update( 'sitebar_link',
            array( 'name'=> $name,
                   'url' => $url,
                   'favicon' => $favicon,
                   'private' => $private?1:0,
                   'comment' => $comment,
                   't_changed' => array('now' => '')),
            array( 'lid'  => $lid),
            array(1062));

        if (!$rset)
        {
            $this->error("Duplicate folder name.");
        }
        elseif ($this->db->getAffectedRows()==0)
        {
            $this->error("Link has already been deleted.");
        }

        return $rset;
    }

    function moveLink($lid, $nid)
    {
        $rset = $this->db->update( 'sitebar_link',
            array( 'nid'=> $nid),
            array( 'lid'  => $lid),
            array(1062));

        if (!$rset)
        {
            $this->error("Duplicate name or URL in the target folder!");
            $this->error("Purge the folder to prevent collision with deleted link!");
        }
        elseif ($this->db->getAffectedRows()==0)
        {
            $this->error("Link has already been deleted.");
        }

        return $rset;
    }

    function copyLink($lid, $nid)
    {
        $link = $this->getLink($lid);

        if (!$link)
        {
            return;
        }

        return $this->addLink($nid, $link->name, $link->url,
            $link->favicon, $link->private, $link->comment, true);
    }

    function removeLink($lid)
    {
        $rset = $this->db->update( 'sitebar_link',
            array( 'deleted_by'=>$this->um->uid,
                   't_changed'=> array('now'=>'')),
            array( 'lid'=>$lid));

        if ($this->db->getAffectedRows()==0)
        {
            $this->error("Link has already been deleted.");
        }
        return $rset;
    }
}

?>
