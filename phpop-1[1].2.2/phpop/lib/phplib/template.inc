<?php
/*
 * Session Management for PHP3
 *
 * (C) Copyright 1999 NetUSE GmbH
 *                    Kristian Koehntopp
 *
 * $Id: template.inc,v 1.1 2000/05/13 21:28:35 prenagha Exp $
 *
 */ 

class Template {
  var $classname = "Template";

  /* if set, echo assignments */
  /* 1 = debug set, 2 = debug get, 4 = debug internals */
  var $debug     = false;

  /* $file[varname] = "filename"; */
  var $file  = array();
  
  /* $block[varname]["parent"] = "parent";
   * $block[varname]["alias"]  = "alias";
   */
  var $block = array();

  /* Template searches for files in one of these directories */
  var $root   = array( "." );

  /* $varkeys[key] = "key"; $varvals[key] = "value"; */
  var $varkeys = array();
  var $varvals = array();

  /* "remove"  => remove undefined variables
   * "comment" => replace undefined variables with comments
   * "keep"    => keep undefined variables
   */
  var $unknowns = "remove";
  
  /* "yes" => halt, "report" => report error, continue, "no" => ignore error quietly */
  var $halt_on_error  = "yes";
  
  /* last error message is retained here */
  var $last_error     = "";

  /***************************************************************************/
  /* public: Constructor.
   * root:     template directory.
   * unknowns: how to handle unknown variables.
   */
  function Template($root = ".", $unknowns = "remove") {
    $this->set_root($root);
    $this->set_unknowns($unknowns);
  }

  /* public: setroot(pathname $root)
   * root:   array with template directories.
   */  
  function set_root($root) {
    if (!is_array($root)) {
      if (!is_dir($root)) {
        $this->halt("set_root (scalar): $root is not a directory.");
        return false;
      }
      
      $this->root[] = $root;

    } else {
      reset($root);
      while(list($k, $v) = each($root)) {
        if (!is_dir($v)) {
          $this->halt("set_root (array): $v (entry $k of root) is not a directory.");
          return false;
        }
        
        $this->root[] = $v;
      }
    }

    return true;
  }

  /* public: set_unknowns(enum $unknowns)
   * unknowns: "remove", "comment", "keep"
   */
  function set_unknowns($unknowns = "remove") {
    $this->unknowns = $unknowns;
  }

  /* public: set_file(array $filelist)
   * filelist: array of varname, filename pairs.
   *
   * public: set_file(string $varname, string $filename)
   * varname: varname for a filename,
   * filename: name of template file
   */
  function set_file($varname, $filename = "") {
    if (!is_array($varname)) {
    
      if ($filename == "") {
        $this->halt("set_file: For varname $varname filename is empty.");
        return false;
      }
      $this->file[$varname] = $this->filename($filename);

    } else {

      reset($varname);
      while(list($h, $f) = each($varname)) {
        if ($f == "") {
          $this->halt("set_file: For varname $h filename is empty.");
          return false;
        }
        $this->file[$h] = $this->filename($f);
      }
    }

    return true;
  }

  /* public: set_block(string $parent, string $varname, string $name = "")
   * mark a variable as a subblock
   */
  function set_block($parent, $varname, $name = "") {
    if ($name == "")
      $name = $varname;

    $this->block[$varname]["parent"] = $parent;
	//carmelo
	//wild fix to make the blocks work on php4
    //$this->block[$varname]["alias"]  = "{".$name."}";
	//end of wild fix
    $this->block[$varname]["alias"]  = $name;

    return true;
  }
  
  /* public: set_var(array $values)
   * values: array of variable name, value pairs.
   *
   * public: set_var(string $varname, string $value)
   * varname: name of a variable that is to be defined
   * value:   value of that variable
   */
  function set_var($varname, $value = "") {
    if (!is_array($varname)) {
      if (!empty($varname))
        if ($this->debug & 1) 
          printf("<b>set_var:</b> (with scalar) <b>%s</b> = *%s*<br>\n", $varname, htmlentities($value));
        $this->varkeys[$varname] = "/".$this->varname($varname)."/";
        $this->varvals[$varname] = $value;
    } else {
      reset($varname);
      while(list($k, $v) = each($varname)) {
        if (!empty($k))
          if ($this->debug & 1) 
            printf("<b>set_var:</b> (with array) <b>%s</b> = *%s*<br>\n", $k, htmlentities($v));
          $this->varkeys[$k] = "/".$this->varname($k)."/";
          $this->varvals[$k] = $v;
      }
    }
  }

  /***************************************************************************/
  /* public: subst(string $varname)
   * varname: varname of template where variables are to be substituted.
   */
  function subst($varname) {
    $str = $this->get_var($varname);
    $str = @preg_replace($this->varkeys, $this->varvals, $str);
    return $str;
  }
  
  /* public: psubst(string $varname)
   * varname: varname of template where variables are to be substituted.
   */
  function psubst($varname) {
    print $this->subst($varname);
    
    return false;
  }

  /* public: parse(string $target, string $varname, boolean append)
   * public: parse(string $target, array  $varname, boolean append)
   * target: varname of variable to generate
   * varname: varname of template to substitute
   * append: append to target varname
   */
  function parse($target, $varname, $append = false) {
    if (!is_array($varname)) {
      $str = $this->subst($varname);
      if ($append) {
        $this->set_var($target, $this->get_var($target) . $str);
      } else {
        $this->set_var($target, $str);
      }
    } else {
      reset($varname);
      while(list($i, $h) = each($varname)) {
        $str = $this->subst($h);
        $this->set_var($target, $str);
      }
    }
    
    return $str;
  }
  
  function pparse($target, $varname, $append = false) {
    print $this->parse($target, $varname, $append);
    return false;
  }
  
  /* public: get_vars()
   * return all variables as an array (mostly for debugging)
   */
  function get_vars() {
    reset($this->varkeys);
    while(list($k, $v) = each($this->varkeys)) {
      $result[$k] = $this->get_var($k);
    }
    
    return $result;
  }
  
  /* public: get_var(string varname)
   * varname: name of variable.
   *
   * public: get_var(array varname)
   * varname: array of variable names
   */
  function get_var($varname) {
    if (!is_array($varname)) {
    
      /* check for empty variable */
      if (!isset($this->varkeys[$varname]) or empty($this->varvals[$varname])) {
        /* if so, check if it should be loaded */
        if (isset($this->file[$varname]))
          $this->loadfile($varname);
        /* if so, check if it is a subblock of another variable */
        if (isset($this->block[$varname]))
          $this->implode_block($varname);
      }
      if ($this->debug & 2)
        printf ("<b>get_var</b> (with scalar) <b>%s</b> = *%s*<br>\n", $varname, htmlentities($this->varvals[$varname]));
      return(isset($this->varvals[$varname]) ? $this->varvals[$varname] : "");

    } else {
    
      reset($varname);
      while(list($k, $v) = each($varname)) {
        /* check for empty variable */
        if (!isset($this->varkeys[$varname]) or empty($this->varvals[$varname])) {
          /* if so, check if it should be loaded */
          if ($this->file[$v])
            $this->loadfile($v);
          /* if so, check if it is a subblock of another variable */
          if ($this->block[$v])
            $this->implode_block($v);
        }
        if ($this->debug & 2)
          printf ("<b>get_var:</b> (with array) <b>%s</b> = *%s*<br>\n", $v, htmlentities($this->varvals[$v]));
        $result[$v] = $this->varvals[$v];
      }
      
      return $result;
    }
  }
  
  /* public: get_undefined($varname)
   * varname: varname of a template.
   */
  function get_undefined($varname) {
    $str = $this->get_var($varname);
    preg_match_all("/\\{([a-zA-Z0-9_]+)\\}/", $str, $m);
    $m = $m[1];
    if (!is_array($m))
      return false;

    reset($m);
    while(list($k, $v) = each($m)) {
      if (!isset($this->varkeys[$v]))
        $result[$v] = $v;
    }
    
    if (count($result))
      return $result;
    else
      return false;
  }

  /* public: finish(string $str)
   * str: string to finish.
   */
  function finish($str) {
    switch ($this->unknowns) {
      case "keep":
      break;
      
      case "remove":
        $str = preg_replace('/{[^ \t\r\n}]+}/', "", $str);
      break;

      case "comment":
        $str = preg_replace('/{[^ \t\r\n}]+}/', "<!-- Template $varname: Variable \\1 undefined -->", $str);
      break;
    }
    
    return $str;
  }

  /* public: p(string $varname)
   * varname: name of variable to print.
   */
  function p($varname) {
    print $this->finish($this->get_var($varname));
  }

  function get($varname) {
    return $this->finish($this->get_var($varname));
  }
    
  /***************************************************************************/
  /* private: filename($filename)
   * filename: name to be completed.
   */
  function filename($filename) {
    /* short path for absolute filenames */
    if (file_exists($filename)) {
      return $filename;
    }
    if (substr($filename, 0, 1) == "/" || preg_match("/[a-z]{1}:/i",$filename) ) {
      $this->halt("filename (absolute): $filename does not exist.");
      return false;
    }

    /* search path for a matching file */      
    reset($this->root);
    while(list($k, $v) = each($this->root)) {
      $f = "$v/$filename";
      if (file_exists($f))
        return $f;
    }

    $this->halt("filename (relative): file $filename does not exist anywhere in " . implode(" ", $this->root));
    return false;
  }
  
  /* private: varname($varname)
   * varname: name of a replacement variable to be protected.
   */
  function varname($varname) {
    return preg_quote("{".$varname."}");
  }

  /* private: loadfile(string $varname)
   * varname:  load file defined by varname, if it is not loaded yet.
   */
  function loadfile($varname) {
    if (!isset($this->file[$varname])) {
      $this->halt("loadfile: $varname is not a valid varname.");
      return false;
    }
    $filename = $this->filename($this->file[$varname]);

    $str = implode("", @file($filename));
    if (empty($str)) {
      $this->halt("loadfile: While loading $varname, $filename does not exist or is empty.");
      return false;
    }

    if ($this->debug & 4)
      printf("<b>loadfile:</b> loaded $filename into $varname<br>\n");
    $this->set_var($varname, $str);
    return true;
  }

  /* private: implode_block($varname)
   * varname: name of variable to implode
   */
  function implode_block($varname) {
    $parent = $this->block[$varname]["parent"];
    $alias  = $this->block[$varname]["alias"];
    
    /* get parent variable */
    $str = $this->get_var($parent);
   
    /* find the subblock we are looking for and extract it */
    $reg = "/<!--\\s+BEGIN $varname\\s+-->(.*)<!--\\s+END $varname\\s+-->/sm";
    if (!preg_match_all($reg, $str, $m))
    {
        $this->halt("implode_block - no match for $varname variable");
    }
    else
    {
        /* implode the subblock to the requested alias */
        $str = preg_replace($reg, "{"."$alias}", $str);

        if ($this->debug & 4) 
        {
            printf("<b>implode_block:</b> extract <b>$varname</b> from <b>$parent</b>, leaving {"."$alias}<br>\n");
        }
        //end change
        
        /* update variables */
        $this->set_var($varname, $m[1][0]);
        $this->set_var($parent, $str);
    }
  }
  

  /***************************************************************************/
  /* public: halt(string $msg)
   * msg:    error message to show.
   */
  function halt($msg) {
    $this->last_error = $msg;
    
    if ($this->halt_on_error != "no")
      $this->haltmsg($msg);
    
    if ($this->halt_on_error == "yes")
      die("<b>Halted.</b>");
    
    return false;
  }
  
  /* public, override: haltmsg($msg)
   * msg: error message to show.
   */
  function haltmsg($msg) {
    printf("<b>Template Error:</b> %s<br>\n", $msg);
  }
}
?>
