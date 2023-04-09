<?php



require("./DbSql.inc.php");

Class PicSQL extends DBSQL
{
   // the constructor
   function PicSQL($DBName = "")
   {
      $this->DBSQL($DBName);
   }
   
   function getallcatalog($page,$record)
   {
      $start = $page*$record;
      $sql = "select * from catalog order by catalogid DESC LIMIT $start,$record";
      $result = $this->select($sql);
      return $result;
   }   
   
   function getcatalognamebyid($catalogid)
   {      
      $sql = "select catalogname from catalog where catalogid='$catalogid'";
      $result = $this->select($sql);
      $parentname = $result[0]["catalogname"];
      return $parentname;
   }
   
   function getallcatalogname()
   {      
      $sql = "select catalogid,catalogname from catalog";
      $result = $this->select($sql);      
      return $result;
   }
   
   function getcatalogbyid($catalogid)
   {      
      $sql = "select * from catalog where catalogid='$catalogid'";
      $result = $this->select($sql);      
      return $result;
   }
   
   function addcatalog($catalogname,$description,$parentid)
   {      
      global $admin_catalogalreadyexist;
      $sql = "select * from catalog where catalogname='$catalogname' and parentid='$parentid'";
      $result = $this->select($sql); 
      if (!empty($result)){
      print "$admin_catalogalreadyexist";
      return;
      }     
      $sql = "insert into catalog (catalogname,description,parentid) values ('$catalogname','$description','$parentid')";      
      $results = $this->insert($sql);
      return $results;
   }
   
   function editcatalog($catalogname,$description,$parentid,$catid)
   {
      $sql = "update catalog set catalogname='$catalogname',description='$description',parentid='$parentid' where catalogid='$catid'";      
      $results = $this->update($sql);
      return $results;
   }
   
   function delcatalog($catid,$PicturePath)
   {
      $sql = "delete from catalog where catalogid=$catid";
      $result = $this->delete($sql);
      $sql = "select picid from picture where catalogid=$catid";
      $result = $this->select($sql);
      if (!empty($result)) {
      	while ( list($key,$val)=each($result) ) {
      		$picid = stripslashes($val["picid"]);
      		$this->delpic($picid,$PicturePath);
      	}
      }
   }

   function getpicsbycatid($page,$record,$catid)
   {
      $start = $page*$record;
      $sql = "select * from picture where catalogid='$catid' order by picid DESC LIMIT $start,$record";
      $result = $this->select($sql);
      return $result;
   }
   
   function getallpics($page,$record)
   {
      $start = $page*$record;
      $sql = "select * from picture order by picid DESC LIMIT $start,$record";
      $result = $this->select($sql);
      return $result;
   }     
   
   function addpic($title,$catalogid,$isdisplay)
   {      
      $now = date("Y-m-d");
      $sql = "insert into picture (catalogid,title,adddate,isdisplay) values ('$catalogid','$title','$now','$isdisplay')";      
      $results = $this->insert($sql);
      return $results;
   }
   
   function getpicbyid($picid)
   {      
      $sql = "select * from picture where picid='$picid'";
      $result = $this->select($sql);      
      return $result;
   }   
   
   function editpic($title,$catalogid,$isdisplay,$picid)
   {
      $sql = "update picture set title='$title',catalogid='$catalogid',isdisplay='$isdisplay' where picid='$picid'";      
      $results = $this->update($sql);
      return $results;
   } 
   
   function delpic($picid,$PicturePath)
   {
      $sql = "select picture from picture where picid='$picid'";
      $result = $this->select($sql);
      $picture = $result[0]["picture"];      
      if (!empty($picture)){
      $file = $PicturePath.$picture;
      unlink($file);
      }
      
      $sql = "delete from picture where picid=$picid";
      $result = $this->delete($sql);      
      return $result;
   }
   
   function add_Picture($picid,$userfile_name,$PicturePath)
   {
      $sql = "select picture from picture where picid='$picid'";
      $result = $this->select($sql);
      $picture = $result[0]["picture"];
      if (!empty($picture)){
      $file = $PicturePath.$picture;
      unlink($file);
      }
      $sql = "UPDATE picture SET picture=\"$userfile_name\" WHERE picid='$picid'";
      $result = $this->update($sql);
      return $result;
   }
   
   function del_Picture($picid,$PicturePath)
   {
      $sql = "select picture from picture where picid='$picid'";
      $result = $this->select($sql);
      $picture = $result[0]["picture"];      
      if (!empty($picture)){
      $file = $PicturePath.$picture;
      unlink($file);
      }
      $sql = "UPDATE picture SET picture=\"\" WHERE picid='$picid'";
      $result = $this->update($sql);
      return $result;
   }
   
}

?>