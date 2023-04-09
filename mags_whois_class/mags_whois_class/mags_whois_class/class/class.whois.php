<?php
/********************************************************    
+	[M]ag's [W]hois [C]lass Version 1.0
+       Email, graycheryal@qwest.net
+       Copyright (C) 2002 Marcus Gray
********************************************************/

@include("class/form.php");
@include("common/globals.php");

class Whois
{
	var $errors = array();      // holds the errors;
	var $domain;                // holds the domain name
	var $results;               // holds the ending results
	var $ext;
	var $extensions = array("NameCheap" => 
					array("com", "net", "org", "biz", "info", "bz", "ws", "nu", "us"),
				"Reg" =>
					array("co.uk"),
				"DomainPeople" =>
					array("ca")
				);
	
	
	/* does all the work */
	function Whois($domain, $extension)
	{
		// make sure it doesn't time out
		@set_time_limit(0);
		
		@flush();
		
		// global variables
		$this->domain = $domain;
		$this->ext    = $extension;
		
		$validate = $this->validate($domain, $extension);
		
		// are we validated?
		if( $validate === true )
		{
			$host = $this->FindHost();
			
			@eval("\$whois = new $host($domain, $extension);"); 	
			
			$results = $whois->GetResults();
			
			$this->results = $results;
		}
		
		else
		{
			$this->results = $validate;	
		}	
	}
	
	/* gets the extension */
	function GetExtension()
	{
		$name = $this->domain;
		
		$exten = strrpos($name, ".")+1;

		$name2 = substr($name, $exten);
		
		// checks if ending is uk
		if( $name2 == "uk" )
		{
			// search for co
			
			$name = substr($name, 0, $exten-1);
			$exten = strrpos($name, ".")+1;
		
			$name3 = substr($name, $exten);	
			
			if($name3 == "co" )
			{
				return "co.uk";
			}
		}
		
		else
		{
			return $name2;	
		}			
	}
	
	/* gets the site name */
	function GetSiteName()
	{
		$pos = strpos($this->domain, ".");
		
		return substr($this->domain, 0, $pos);	
	}
	
	/* finds which host to parse depending on the extension */
	function FindHost()
	{
		$exten = $this->ext;
		
		foreach( $this->extensions as $host => $names)
		{
			foreach($names as $value)
			{
				if( $exten == $value )
				{
					return $host;	
				}	
			}	
		}		
	}
	
	/* validates the domain */
	function validate($input, $extension)
	{
		$extension = strtolower($extension);
		
		if( @strpos($input, "-", 0) < 1 AND @strpos($input, "-", 0) > -1 )
		{
			return "Your Domain Cannot Start With A Dash.";	
		}
		
		if( @strlen($input) > 1 )
		{
			if( @strrpos($input, "-") == @strlen($input)-1 )
			{
				return "Your Domain Cannot End With A Dash.";
			}	
		}
		
		if( @eregi("[^a-z0-9\-]", $input) == true )
		{
			return "Use only letters, numbers, or hyphen (\"-\").";	
		}
		
		if( $extension == "com" || $extension == "net" || $extension == "org" AND strlen($input) > 63)
		{
			return "Please Enter Less Then 63 Characters, Not Including [.".$extension."].";	
		}
		
		if( $extension != "com" AND $extension != "net" AND $extension != "org" AND strlen($input) > 22)
		{
			return "Please Enter Less Then 22 Characters, Not Including [.".$extension."].";	
		}
			
		return true;			
	}
	
	function BuildMenu()
	{	
		foreach( $this->extensions as $host => $names)
		{
			foreach($names as $value)
			{
				$menu .= "\t<option name=\"".$value."\">".$value."</option>\n";			
			}	
		}	
		
		return $menu;
	}
	
	function PrintResults()
	{
		global $open_domain, $closed_domain;
		
		if( $this->results == 1 )
		{
			echo($open_domain);
			return;	
		}
		
		else if( $this->results == 2 )
		{
			echo($closed_domain);
			return;
		}
		
		else
		{
			echo($this->results);
			return;	
		}
	}
	
	/* handles errors */
	function Error($content)
	{
		array_push($this->errors, $content);
		
		return;	
	}	
}









/* class parses for .com, .net, .org, .biz, .info, .bz, .ws, .nu, .us */
class NameCheap extends Whois
{
	var $page;     // holds the page to parse
	var $sitename; // gets the domain
	var $ex;       // gets the extension
	
	function NameCheap($domain, $extension)
	{
		$this->page = "http://www.namecheap.com/search2.asp?txtSLD=".$domain."&cboTLD=".$extension;
		
		$this->sitename = $domain;
		$this->ex       = $extension;
	}
	

	/* gets the contents */	
	function GetContents()
	{
		$fp = @fopen($this->page, "r");
		
		if( !$fp )
		{
			$this->Error("Could Not Load Page".$this->page);				
		}
		
		else
		{
			$contents = @fread($fp, 1000000);
			
			if( $contents != "" )
			{
				return $contents;	
			}
			
			else
			{
				$this->Error("The Result's Returned Empty!");	
			}	
		}	
	}
	
	/* gets the results */
	function GetResults()
	{	
		$pattern  = "<select name=\"".$this->sitename.".".$this->ex."\">";
		$contents = $this->GetContents();
		
		if( @strpos($contents, $pattern) > -1 )
		{
			return "1";	
		}
		
		else
		{
			return "2";	
		}
	}
}












/* class parses for co.uk */
class Reg extends Whois
{
	var $page;     // holds the page to parse
	var $sitename; // gets the domain
	var $ex;       // gets the extension
	
	function Reg($domain, $extension)
	{
		$this->page = "http://www.123-reg.co.uk/whois.cgi?domain=".$domain."&root=co.uk&lookup=OK";
		
		$this->sitename = $domain;
		$this->ex       = $extension;
	}
	

	/* gets the contents */	
	function GetContents()
	{
		$fp = @fopen($this->page, "r");
		
		if( !$fp )
		{
			$this->Error("Could Not Load Page".$this->page);				
		}
		
		else
		{
			$contents = @fread($fp, 1000000);
			
			if( $contents != "" )
			{
				return $contents;	
			}
			
			else
			{
				$this->Error("The Result's Returned Empty!");	
			}	
		}	
	}
	
	/* gets the results */
	function GetResults()
	{	
		$pattern  = "Congratulations!";
		$contents = $this->GetContents();
			
		if( @strpos($contents, $pattern) > -1 )
		{
			return "1";	
		}
		
		else
		{
			return "2";	
		}
	}	
}






/* searches for .ca */
class DomainPeople extends Whois
{
	var $page;     // holds the page to parse
	var $sitename; // gets the domain
	var $ex;       // gets the extension
	
	function DomainPeople($domain, $extension)
	{
		$this->page = "http://www.canreg.com/dapster/domsearch.php?dom=".$domain;
		
		$this->sitename = $domain;
		$this->ex       = $extension;
	}
	

	/* gets the contents */	
	function GetContents()
	{
		$fp = @fopen($this->page, "r");
		
		if( !$fp )
		{
			$this->Error("Could Not Load Page".$this->page);				
		}
		
		else
		{
			$contents = @fread($fp, 1000000);
			
			if( $contents != "" )
			{
				return $contents;	
			}
			
			else
			{
				$this->Error("The Result's Returned Empty!");	
			}	
		}	
	}
	
	/* gets the results */
	function GetResults()
	{	
		$pattern  = "<B>Congratulations</B>";
		$contents = $this->GetContents();
			
		if( @strpos($contents, $pattern) > -1 )
		{
			return "1";	
		}
		
		else
		{
			return "2";	
		}
	}	
}

class WhoisStats
{
	var $servers = array("whois.nsiregistry.com" => 
					array("com", "net", "org"),
				"whois.nic.uk" =>
					array("co.uk"),
				"whois.cira.ca" =>
					array("ca"),
				"whois.nic.nu" =>
					array("nu"),
				"whois.afilias.info" =>
					array("info"),
				"whois.nic.us" =>
					array("us"),
				"whois.worldsite.ws" =>
					array("ws"),
				"whois.neulevel.biz" =>
					array("biz"),
				"whois.networksolutions.com" =>
					array("bz")
				);
	
	
	function WhoisStats($domain, $exten)
	{
		$this->GetStat($domain, $exten);	
	}
	
	/* finds which host to parse depending on the extension */
	function FindHost($exten)
	{
		foreach( $this->servers as $host => $names)
		{
			foreach($names as $value)
			{
				if( $exten == $value )
				{
					return $host;	
				}	
			}	
		}		
	}
	
	function GetStat($domain, $exten)
	{
		$server = $this->FindHost($exten);
		
		$fp = @fsockopen($server, 43, $errno, $errstr);
		
		if( !$fp )
		{
			echo($errstr);	
		}
		
		else
		{
			if( @strpos(PHP_OS, "WIN") )
				@fputs($fp, $domain.".".$exten."\r\n");
			else
				@fputs($fp, $domain.".".$exten."\n");
			
			while( !@feof($fp) )
			{
				$data .= @fgets($fp, 4096);	
			}
			
			@fclose($fp);
			
			echo("<pre>".$data."</pre>");	
		}	
	}
}
?>