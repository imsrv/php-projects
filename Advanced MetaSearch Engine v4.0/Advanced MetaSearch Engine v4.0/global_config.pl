##
##       Advanced MetaSearch Engine Version 4.0             #
##----------------------------------------------------------#
##                                                          #
##   ---  G L O B A L   C O N F I G U R A T I O N S  ---    #
##                                                          #
##----------------------------------------------------------#
sub cgxg {my($Script_Directory,$Default_Search_Option,$Search_Counter,$Keyword_Tracking,$Max_Keyword_Records,$Cache_Lifetime,$Flock_Support,$Http_NoCache_Header,$Http_Custom_Header,$NPH_Header,$Debug_Mode,$Allow_Request_Method,$Allow_Input_MaxLength,$Server_Protocol,$Server_Ctrlf,$Advanced_Directory_Url);
#-----------------------------------------------------------#
# Ref: AM4.00(std)-01-2001-LIB

$Script_Directory	 = ""; 
			 # -- If you get problem running your Advanced MetaSearch Engine 
			 # -- for the first time, please assign FULL PATH (not URL) to your 
			 # -- Main Script Directory
                  	 # -- NO Trailing Slash '/' (at the end)
                  	 # NOTE: It is always a good idea to set this parameter; although not required on most systems.

$Debug_Mode		= "off"; 
                         # -- If set to 'on' the script will try to report on possible errors/problems.
                         # -- Possible values:
                         # --                 on   -> Debug Mode is On.
                         # --                 off  -> Debug Mode is Off (deactivated)
                         # -- Make sure you set it to 'off' as soon as the problem is rectified.

$Flock_Support		= "off";             
                         # -- In case the system call flock() is not supported on your machine, set it to 'off'.
                         # -- Possible values: 
                         # --                   on   -> File Flocking is On.
                         # --                   off  -> File Flocking is Off.

$Search_Counter		= "on";
                         # -- Search Count Logging control. If set to 'on' the 
                         # -- script will log the total number of search requests 
                         # -- served by your Advanced MetaSearch Engine on a 
                         # -- monthly basis.
                         # -- Possible values:
                         # --                on    -> Search Counter is On (active).
                         # --                off   -> Search Counter is Off.
                         # -- Search Count Logs are stored in the 'log-count' sub-directory.


$Cache_Lifetime		= 7200;          
                         # -- Cache clean interval in seconds. 
                         # -- Must be an unsigned Integer value.


$Keyword_Tracking	= "full";
			# -- Keyword-Logger control; 
			# -- possible values: 
			# --              off   -> Keyword Logging is off,
			# --              on    -> Individual Log files for each speciality-search.
			# --              full  -> Will also generate Keyword Matching Search.

$Max_Keyword_Records	= 0;          
			# -- Maximum number of Keyword Records (lines) to keep in the Keyword-Log file/s.. 
			# -- Must be an unsigned integer value.


$Advanced_Directory_Url	= "http://your_server.com/cgi-bin/cgdir/cgdir.cgi?query=##enckeywords##";
			# -- If you are using 'Advanced Directory' put your 'Advanced Directory' main script URL. 
			# -- See the Example below. Modify as required and assign it to the above $Advanced_Directory_Url parameter.
			# -- Example: $Advanced_Directory_Url	= "http://your_server.com/cgi-bin/cgdir/cgdir.cgi?query=##enckeywords##";


my (%external_urls)	= (
			dir	=> $Advanced_Directory_Url,
			other1	=> "http://some-server.com/cgi-bin/script_url_1.cgi?query=##enckeywords##",
			other2	=> "http://some-server.com/cgi-bin/script_url_2.cgi?query=##enckeywords##",
			other3	=> "http://some-server.com/cgi-bin/script_url_3.cgi?query=##enckeywords##"
			);
			# -- If you want to add redirection to other search (or similar) scripts on the 
			# -- same Search-Box (Search-Form), simply add them in value fields
			# -- of 'other1' or 'other2' or 'other3'. You can then
			# -- add 'other1' ('other2', 'other3') as an option on your Search-Box
			# -- using the Form InputName 'target' or 'where'. If you not 
			# -- using any other Specialty-Search or Country-Search addon, 
			# -- you will need to add this as a new Form Input.


$Http_NoCache_Header	= "off";             
			# -- Possible values: 'on' or 'off'

$Http_Custom_Header	= "off";             
                        # -- Possible values: 'off' OR the EXACT FULL Custom Header

$NPH_Header		= "off";             
                        # Possible values: 'on'  or  'off'.  

$Server_Protocol	= "HTTP/1.0";
                        # -- Do NOT touch it if not sure.


$Allow_Request_Method	= "";		
                        # -- HTTP request methods allowed. 
                        # -- Possible values:	
                        # --          ""      ->  both 'GET' and 'POST' (default), 
                        # --          'POST'  -> POST only, 
                        # --          'GET'   -> GET only.


$Allow_Input_MaxLength	= 0;
                        # -- Maximum Allowed length (in characters) of Form Input. 
                        # -- Default should be OK. Do NOT change this unless 
                        # -- suggested by Technical Support.

$Default_Search_Option	= "";
                        # -- Do NOT change anything here unless suggested 
                        # -- by Technical Support.

$Server_Ctrlf		= "\015\012";
                        # -- Do NOT change anything here unless suggested 
                        # -- by Technical Support.


#________________________________________________________________________________________
#
#    STOP      STOP      STOP      STOP      STOP      STOP     STOP
#________________________________________________________________________________________
return($Script_Directory,$Server_Protocol,$Default_Search_Option,$Search_Counter,$Keyword_Tracking,$Max_Keyword_Records,$Cache_Lifetime,$Flock_Support,$Http_NoCache_Header,$Http_Custom_Header,$NPH_Header,$Debug_Mode,$Allow_Request_Method,$Allow_Input_MaxLength,$Server_Ctrlf,%external_urls);
}
#________________________________________________________________________________________
#________________________________________________________________________________________



## -------------- Intermediary-Promotion Addon ------------- ## Starts
## --------------         NOT PRESENT          ------------- ## IP-1
sub interad {return "";}
## --------------         NOT PRESENT          ------------- ## IP-1
## -------------- Intermediary-Promotion Addon ------------- ## Ends



## ----------- Safe-Search (Family Filter) Addon ----------- ## Starts
## --------------         NOT PRESENT          ------------- ## SS-1
## sub safe_kw {return ("",$_[0]||"");}
## --------------         NOT PRESENT          ------------- ## SS-1
## ----------- Safe-Search (Family Filter) Addon ----------- ## Ends


## --------------------------------------------------------- ##
## --------------      Engine-Select Addon     ------------- ## Starts
## --------------         NOT PRESENT          ------------- ## ES-1
## --------------------------------------------------------- ##
##                                                           ##
## --------------------------------------------------------- ## 
## --------------      Engine-Select Addon     ------------- ## Ends
## --------------         NOT PRESENT          ------------- ## ES-1
## --------------------------------------------------------- ##



#________________________________________________________________________________________
# Ref: AM4.00(std)-01-2001-LIB
1;