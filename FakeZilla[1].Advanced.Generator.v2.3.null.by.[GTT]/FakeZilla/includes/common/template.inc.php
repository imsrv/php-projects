<?
class Template {
  var $FILES;
  // repository for the template files
  //
  //	name: assigned name to the template, all in
  //		upper-case in order to make the
  //		naming case-insensitive
  //	filename: template filename
  //
  //	source: source code of the template file in raw
  //		format, before initial template parsing

  var $TEMPLATES;
  // repository for the templates, extracted when
  // template files are pre-parsed (this means that
  // the dynamic templates are extracted from the
  // static ones); static template is the main template
  // for the template file, and dynamic templates are
  // all the templates declared in it
  //
  //	name: name of the template file, used in FILES, all in
  //		upper-case in order to make the
  //		naming case-insensitive
  //	template: name of the template; this field is
  //		empty if this is the main template
  //		(static) for the template file, identified
  //		by name in FILES
  //	main: source code of the template; when
  //		pre-parsed, sub-templates (dynamic
  //		templates) are replaced by special
  //		delimiters, like this
  //		&%NAME_OF_THE_TEMPLATES%&
  //	parsed: parsed template code of template
  //		default un-parsed template is stored in this->main
  //		while parsed templates are accumulated in this->parsed
  //	loops: how many times the template is parsed,
  //		when used in loops

  var $SUBS;
  // array with substitude items, that will be 
  // placed when templatea are parsed
  //
  //	key: name of the substitude item, all in
  //		upper-case in order to make the
  //		naming case-insensitive
  //	value: value of the substitude item


  var $MESSAGES;
  // array with text messages stored in template files
  //
  //	key: name of the text message, all in
  //		upper-case in order to make the
  //		naming case-insensitive
  //	value: value of the text message

 var $error;
 // text string contining the last error, occured
 // with the template object

  var $error_file;
  // filename for the error log, where the template
  // object errors are appended

 var $path;
 // this is the path to the templates, which is used
 // for reading them; must have trailing slash at the end


 // constructor Template(path, subs_array, msg_array)
 // paremeters:
 //	path - where the template files are stored
 //
 //	error_file - name of the file, where template
 //		object errors are appended
 //	default_file - name of the default messages and
 //		template file, used for storing "global"
 //		text messages and templates; must be
 //		in this->path folder
 //
 function Template() {

 	if (!$this->path = @func_get_arg(0)) {
 		unset($this->path);
 		$this->error (sprintf("Template path is empty"));
 		return;
 		}

 	if ($this->error_file = @func_get_arg(1)) {
 		if (!file_exists($this->error_file)) {
 			$this->error (sprintf("Template error log [%s] not found", $this->error_file));
 			}
 		} else {
 		unset($this->error_file);
 		}
 	
 	if ($default_file = @func_get_arg(2)) {
 		if (!file_exists($this->path . $default_file)) {
 			$this->error (sprintf("Default message template file [%s] not found",
 				$this->path . $default_file));
 			} else {
 			// load the file
 			$this->FILES[''][filename] = $default_file;
 			$this->FILES[''][source] = $this->load($this->FILES[''][filename]);

 			// extract messages
 			$this->extract();
 			}
 		}
 	}

 // checkes whether there is a template file,
 // and if it can be accessed for reading.
 // if successful, the template file is read
 // and stored in this->source
 function load($path) {

 	if (!file_exists($this->path . $path)) {
 		$this->error(sprintf("Template file [%s] not found ",$this->path . $path));
 		return;
 		}
 		
	if (!$file = @file($this->path . $path)) {
		$this->error(sprintf("Template file [%s] is empty or can not be read ",$this->path . $path));
		return;
		}
 	
 	$file = join('' , $file);
 	return $file;
  	}


  // applies html convesion to the value in order
  // to convert html sensible characters like &, ", <, >
  function htmlEncode ($value) {
  	return stripSlashes(htmlSpecialChars($value));
  	}

 // returns parsed template
 // if array is provided, it is used as substitude storage
 // all substitudes are case insensitive
 //
 //	template: name of the sub, template that's about
 //		to be parsed; if none, main template is
 //		parsed instead
 //
 //	name: name of the template file, that carries
 //		the subtemplate you wanted parsed
 //		if empty, default template & messages
 //		file used instead
 //
 // substitude markers:
 //	#%name_of_substitude_value%#
 //	- plain text substitudes
 //
 //	%%name_of_substitude_value%%
 //	- html sensitive substitudes
 //
 //	NOTE: an array may be used for
 //	batch parse of templates; in this
 //	case parse() function takes
 //	only 1 paramter - the arrray
 function parse($key) {
	
	//check if array
	if (is_array($key)) {
		while (list($k, $v) = each($key)) {
			$this->parse($v);
			}
		return;
		}

 	$key = strToUpper($key);
 	if (!$this->TEMPLATES[$key]) {
 		$this->error(sprintf("Template [%s] not found", $key));
 		} else {
		$s_main = $this->TEMPLATES[$key][main];

		//check for sub-templates
 		while (preg_match('~&%(.*)%&~iUs', $s_main, $R)) {
 			$s_key = $R[1];
 			$s_main = str_replace($R[0], $this->TEMPLATES[$s_key][parsed], $s_main);
 			}

		// parse the plain text substitutes
		while (preg_match('/#%(.*)%#/iUs', $s_main, $R)) {
			$s_key = strToUpper($R[1]);
			$s_value = $this->SUBS[$s_key];
			$s_main = str_replace($R[0], $s_value, $s_main);
			}

		// parse the html sensitive substitutes
		while (preg_match('/%%(.*)%%/iUs', $s_main, $R)) {
			$s_key = strToUpper($R[1]);
			$s_value = $this->SUBS[$s_key];
			$s_value = $this->htmlEncode($s_value);
			$s_main = str_replace($R[0], $s_value, $s_main);
			}

		$this->TEMPLATES[$key][parsed] .= ereg_replace("[\n\r\t]+" , "\n", $s_main);
		$this->TEMPLATES[$key][loops]++;
 		}
 	}
  
  // saves the last error in this->error, and appends
  // the error message to the error log, if set
  function error($error) {
	$this->error = $error;
	
	if ($this->error_file) {
		if ($fp = @fopen($this->error_file, 'a')) {
			$error_msg = date("Y-M-d H:i:s\t") . $this->error . "\n";

			if (!@fwrite($fp, $error_msg)) {
				$this->error = sprintf("Unable to write to template error log [%s]",
					$this->error_file);
				}
			@fclose ($fp);
			} else {
			$this->error = sprintf("Unable to open template error log [%s]", $this->error_file);
			}
		}
  	}

  // pre-parses the template, identified by name
  // if name is empty, default messages template
  // is pre-parsed instead
  // parses this->FILES[name][source] to extract the
  // main template, dynamic templates, and
  // text messages stored in the template file
  // delimiters:
  //	<TEMPLATE name_of_the_template> ... </TEMPLATE>
  //	dynamic subtemplates
  //
  //	<MESSAGE> ... </MESSAGE>
  //	<MESSAGES> ... </MESSAGES>
  //	text messages
  //
  //	<!--# template_comments #-->
  //	comments
  //
  // message format
  //	message_name : message_text ;
  //
  // extracted subtemplates
  //	&%name_of_the_template%&
  //
  function extract() {

	//get source
  	$name = strToUpper(@func_get_arg(0));
	$source = $this->FILES[$name][source] = $this->load($this->FILES[$name][filename]);

	//strip comments
	while (preg_match('/<!--#.*#-->/iUs', $source, $R)) {
		$source = str_replace($R[0], '', $source);
		}

	//get messages
	while (preg_match('|<MESSAGES?(.*)>(.*)</MESSAGES?>|iUs' , $source, $R)) {
		$msg = trim($R[2]);

		while (preg_match('/^(([a-z0-9 _]+)\s*:(.*)?)(\n[^\s]+\s*:.*)?$/sUi',$msg, $M)) {
			$key = strToUpper(trim($M[2]));
  			
  			$message = trim($M[3]);
			if (isset($this->MESSAGES[$key])) {
				$this->error(sprintf("Duplicate MESSAGES entry for template [%s] with key [%s]",
					$this->FILES[$name][filename], $key));
				}
			$this->MESSAGES[$key] = $message;
			
			$msg = trim(substr($msg, strlen($M[1])));
			}
		
  		//strip parsed message block
  		$source = str_replace($R[0],'', $source);
		}

	//get subtemplates
  	$sourceU = strToUpper($source);	//to make the search case-insensitive
  	while ($s2 = strPos($sourceU, '</TEMPLATE')) {
  		$chunk = strRev(subStr($sourceU, 0, $s2));
  		if (!$s1 = strPos($chunk, 'ETALPMET<')) {
  			$this->error(sprintf("Syntax error in template [%s] with value [%s]",
  				$name, $source));
  			} else {

  			$len = $s1 + 20;
  			$where = strLen($chunk) -$s1 -9;
  			$sub = trim(subStr($source, $where, $len));
  			if (!preg_match('~<TEMPLATE(.*)>(.*)</TEMPLATE>~iUs', $sub, $R)) {
  				$this->error(sprintf("Syntax error in template [%s] with value [%s]",
  					$name, $sub));
  				} else {
  				$key = trim(strToUpper($R[1]));
  				$main = $R[2];

				if (isset($this->TEMPLATES[$key])) {
					$this->error(sprintf("Duplicate TEMPLATES entry for template [%s] with key [%s]",
						$this->FILES[$name][filename], $key));
					}
  				$this->TEMPLATES[$key] = array(main=>$main);
  				}
  			$source = str_replace($sub, "&%$key%&", $source);
  			$sourceU = strToUpper($source);
  			}
  		}
  	if (trim($source)) {
  		if (isset($this->TEMPLATES[$name])) {
			$this->error(sprintf("Duplicate TEMPLATES entry for template [%s] with key [%s]",
				$this->FILES[$name][filename], $name));
			}
  		$this->TEMPLATES[$name] = array(main=>$source);
  		}
	}

  // defines a combination of name & filename
  // to the FILES array in the template object
  //	NOTE: array(key=>value) may be used for
  //	batch define of templates; in this case
  //	define() function takes only 1 paramter: key-value
  //	pairs array
  function define($name) {

	//check for arrays
	if (is_array($name)) {
		while (list($k,$v) = each($name)) {
			$this->define($k,$v);
			}
		return;
		}
	
	$name = strToUpper($name);
	$filename = @func_get_arg(1);

  	if ($this->FILES[$name]) {
  		$this->error(sprintf("Duplicate FILES entry [%s] with file [%s]",
  			$name, $filename));
  		}
  	$this->FILES[$name] = array(filename=>$filename, source=>'');
  	}

  // assigns value to SUBS[key] variable to be
  // used when templates are parsed (interpolated)
  //
  //	key: name of the SUBS variable, all in
  //		upper-case in order to make the
  //		naming case-insensitive
  //
  //	value: value for the SUBS variable
  //
  //	NOTE: array(key=>value) may be used for
  //	batch assign of SUBS variables
  //
  function assign($key) {
  	
  	//check for arrays
  	if (is_array($key)) {
    		while (list($k, $v) = each($key)) {
  			$this->assign($k, $v);
  			}
  		return;
  		}
  	
  	$key = strToUpper($key);
  	$value = @func_get_arg(1);

  	$this->SUBS[$key] = $value;
  	}

  // returns the parsed data for a template
  //	name: name of the template file, empty
  //		string if you want to use default
  //		template & messages file instead
  //
  //	template: name of the sub-template you want
  //		returned; if none, main template will
  //		be returned instead
  function fetch($template) {
  	$template = strToUpper($template);
  	
  	if (!$r = $this->TEMPLATES[$template][parsed]) {
  		$this->error(sprintf("TEMPLATES entry [%s] not found", $template));
  		} else {
  		return $r;
  		}
  	}

 // returns text message from a template file
 //	subs: name of the SUBS variable, that
 //		will receive the value of the message
 //	key: name of the message which
 //		is about to be passed
 //
 //	NOTE: array(key=>value) may be used for
 //	batch assign messages
 //
 function message($subs) {
 	//check arrays
 	if (is_array($subs)) {
  		while (list($k, $v) = each($subs)) {
 			$this->message($k, $v);
 			}
 		return;
 		}
 	
 	$subs = strToUpper($subs);
 	$key = strToUpper(@func_get_arg(1));
  	
 	if (!$msg = $this->MESSAGES[$key]) {
		$this->error(sprintf("MESSAGES entry [%s] not found", $key ));
 		} else $this->assign($subs, $msg, $name);
 	}

 // returns an assigned variable
 // from SUBS array
 function get_subs($key) {
 	return $this->SUBS[strToUpper($key)];
 	}

 // returns a text message from
 // the MESSAGES array
 function get_message($key) {
 	return $this->MESSAGES[strToUpper($key)];
 	}

 // clears out a template
 function clear($key) {
 	$key = strToUpper($key);
 	unset($this->TEMPLATES[$key][parsed]);
 	unset($this->TEMPLATES[$key][loops]);
 	}

 }
?>