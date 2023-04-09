<?php



require("./DbSql.inc.php");

Class PicSQL extends DBSQL
{
   // the constructor
   function PicSQL($DBName = "")
   {
      $this->DBSQL($DBName);
   }

   function getchildcatalog($catid)
   {
      $start = $page*$record;
      $sql = "select catalogid,catalogname from catalog where parentid='$catid' order by catalogid";
      $result = $this->select($sql);
      return $result;
   }
   
   function getpicsbycatid($page,$record,$catid)
   {
      $start = $page*$record;
      $sql = "select picid,title,adddate from picture where catalogid='$catid' and isdisplay=1 order by picid DESC LIMIT $start,$record";
      $result = $this->select($sql);
      return $result;
   }
      
   function getlatestonhome($record)
   {      
      $sql = "select picid,title,adddate from picture where isdisplay=1 order by picid DESC LIMIT 0,$record";
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
   
   function getpicbykeyword($page,$record,$keyword)
   {
      $start = $page*$record;
      $sql = "select picid,title,adddate from picture where title like '%$keyword%' and isdisplay=1 order by picid DESC LIMIT $start,$record";
      $result = $this->select($sql);
      return $result;
   }   
   
   function getpicbyid($picid)
   {      
      $sql = "select * from picture where picid='$picid'";
      $result = $this->select($sql);      
      return $result;
   } 
   
   function getpicbycatidonpicphp($catalogid)
   {      
      $sql = "select picture from picture where catalogid='$catalogid' and isdisplay=1 order by picid DESC";
      $result = $this->select($sql);      
      return $result;
   }  
   
   function getname($picid)
   {
      $sql = "select title from picture where picid=$picid";
      $result = $this->select($sql);
      $title = $result[0]["title"];       
      return $title;
   }
   
}

?>