<?PHP
/*
#
#	$Id: SPLIT.CLASS.PHP
#	Version 2.0.0
#
*/
require("../settings.php");
define("dbserver",$sqlhost);
define("dbuser",$sqluser);
define("dbpass",$sqlpass);
define("dbname",$sqldb);
class Split
{

        var $host=dbserver;
        var $dbuser=dbuser; //database username
        var $dbpasswd=dbpass; //database password
        var $db=dbname;      //name of database
	
	var $totalrows; //total no ofrows returned by the query
	var $maxrow;  //total no of rows displayed in a page
        var $sql;	//the main query
        var $error;
        var $totalpages;

	function Split($sql,$maxrow)
	{
		
		$this->cid= mysql_pconnect($this->host, $this->dbuser, $this->dbpasswd)
			  or   die("Error: " . mysql_error());
		
		mysql_select_db($this->db,$this->cid);

		$this->sql=$sql;
		$this->maxrow=$maxrow;
		if($this->maxrow <=0)
		{
			$this->error="Max results in a page is not valid";
			return;
		}	
		$out=mysql_query($sql);
		if (!$out)
		{
		         $this->error="ERROR" . mysql_error();
		         return;
		}

		$this->totalrows=mysql_num_rows($out);
                //total rows=0
		if ($this->totalrows==0)
		{
		         $this->error="<br><b>There are no NEW images to approve at this time.</b><br><br>";
		         return;
		}


		$this->totalpages=(int)(($this->totalrows-1)/$this->maxrow+1);
		// in the above line we initialize the total no of rows and the sql
	}	
        	



	function display($ppage)
	{

		//in this method only the present page to be displayed will be passed
		//if present page is null the first $maxrows will be printed
		if(($ppage=="")|| ($ppage <=0))
		{
			//if the ppage passed is null or zero or less than zero we
			//show the first page
			$min=0;
			//printf("ppage is null or 0 or less than 0<br>");
			
		}
		else
		{
			
			if($ppage > $this->totalpages)
			{
				//if the ppage passed is more than the total pages
				//we display the last page
				$min=$this->maxrow * ($this->totalpages-1);
				//printf("ppage is > total pages<br>");				
			}
			else
			{
			//if present page is passed the max and min limit is calculated
			//eg:-if ppage is 2 and maxrow=10 then records from 10 to 20 will be displayed.
			
//			    printf("ppage is is $ppage<br>"); // me
				$ppage=$ppage-1;
				$min=$ppage*$this->maxrow;
				$max=$this->maxrow;
												
			}
		}
		$sqlimit = $this->sql ." "."limit"." ". $min . "," . $this->maxrow;
		//printf("<br>sql is $sqlimit<br>");	
		
		$outputdisplay=mysql_query($sqlimit)or die("ERROR" . mysql_error());		
		if(mysql_num_rows($outputdisplay)==0)
		{
			$this->error="No results";
			exit;
		}
		else
		{
			return $outputdisplay;
			
		}	
			
	}
	function total()
	{
		//printf("total no of rows is %s<br>",$this->totalrows);
		
		return $this->totalpages;
	}	
	
}	

?>
