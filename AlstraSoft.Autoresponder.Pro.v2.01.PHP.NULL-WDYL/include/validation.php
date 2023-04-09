<?php
/* Nullified by WDYL-WTN */

	// check whether input is empty
	function AssumeIsNotEmpty($value, $msg)
	{
		if (!isset($value) || trim($value) == "")
		{
			error_page($msg);
			return false;
		}
		else
			return true;
	}

	// check whether input is a string
	function AssumeIsString($value, $msg)
	{
		if(!is_string($value))
		{
			error_page($msg);
			return false;
		}
		else
			return true;
	}

	// check whether input is a number
	function AssumeIsNumber($value, $msg)
	{
		if(!is_numeric($value))
		{
			error_page($msg);
			return false;
		}
		else
			return true;
	}

	// check whether input is an integer
	function AssumeIsInteger($value, $msg)
	{
		if(!is_integer($value))
		{
			error_page($msg);
			return false;
		}
		else
			return true;
	}

	// check whether input is a float
	function AssumeIsFloat($value, $msg)
	{
		if(!is_float($value))
		{
			error_page($msg);
			return false;
		}
		else
			return true;
	}
	
	// check whether input is alphabetic
	function AssumeIsAlpha($value, $msg)
	{
		$pattern = "/^[a-zA-Z]+$/";
		if(preg_match($pattern, $value))
			return true;
		else
		{
			error_page($msg);
			return false;
		}
	}

	// check whether input is within a valid numeric range
	function AssumeIsWithinRange($value, $msg, $min, $max)
	{
		if(!is_numeric($value) || $value < $min || $value > $max)
		{
			error_page($msg);
			return false;
		}
		else
			return true;
	}
	
	// check whether input is a valid email address
	function AssumeIsEmailAddress($value, $msg)
	{
		$pattern = "/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/";
		if(preg_match($pattern, $value))
			return true;
		else
		{
			error_page($msg);
			return false;
		}
	}
	
?>