package web::conf; sub setting{my($default_per_page,$default_timeout,$Framed_Redirection_Url,$Translation_Redirect_Url,$Inter_promotion_step,$force_html_output,$bold_keywords,$Engine_Url_Type,$Engine_Url_Target,$link_html,$link_html_no_d,$link_html_no_s,$link_html_no_ds,$link_table_color1,$link_table_color2,$link_table_border,$link_table_cellspacing,$link_table_cellpadding,$linkbar_maxpages,$linkbar_tag_prev,$linkbar_tag_next,$linkbar_delim,$toolbox_delim,$show_summary_label,$hide_summary_label,$show_source_label,$hide_source_label,$sort_results_label,$group_results_label,$link_title_maxlength,$link_url_maxlength,$kwmatch_link_html,$kwmatch_show_max_columns,$kwmatch_show_max_rows,$no_keyword_message,$bad_keyword_message,$no_results_message,$ES_Report_html,$ES_Continue_html,$ES_Max_Engine_Try,$ES_Engine_Order,$ES_Javascript_Option,$ES_JS_Image_dir,$ES_Image_Start_Status,$ES_Image_Trying,$ES_Image_Tried,$ES_Image_Remain,$ES_Image_Partial,$ES_Image_Timeout,$ES_Image_Success_Tip,$ES_Image_Partial_Tip,$ES_Image_Timeout_Tip,$ES_Table_Max_Columns);
#
#
#____________________________________________________________________
#                                                                    |
#   W E B - S E A R C H    C U S T O M I Z A T I O N    S T A R T S  |
#____________________________________________________________________|


#___________________________ Section A ______________________________|


$default_timeout           = 3;
			    # -- Please read the following before changing this parameter.
                            # -- Default timeout is measured in seconds.
                            # -- If NO Timeout value is provided through Form Input 'timeout'
                            # -- this value is accepted as default. 
                            # -- In most cases there should not be any specific need to change this value.
                            # -- If you are on a very slow network and often no results are found 
                            # -- a higher '$default_timeout' value can improve the situation.
                            # -- You may also try setting lower value if this always works well on your server.
                            # -- Must be an unsigned Integer value beginning from 1 (or greater).

$default_per_page           = 8;
                            # -- Default value of how many results to show per page.
                            # -- Unless any other value is selected, the default value will be used. 
                            # -- Possible values can be any unsigned integer (8, 10, 12, 16, 20, 25 etc.) bigger than 1 
                            # -- or 'all' to show ALL results on the same page.

$force_html_output         = 'off';
                            # -- On some servers (including Apache earlier than 
                            # -- version 1.3 script output used to be buffered. 
                            # -- In such a case If you really want to force an 
                            # -- immediate, you can set the above parameter to 'on'. 
                            # -- In such a case setting the $NPH_Header to 'on' 
                            # -- and running as a nph- script may also help. You 
                            # -- can, however, set both 'on' you do not understand 
                            # -- how nph- scripts work.
                            # -- In most cases you would NOT need to modify this 
                            # -- parameter at all.


#___________________________ Section B ______________________________|
#_____________________________________________________________________________________
# -- the following 12 parameters control how individual result-links 
# -- will created and shown on result pages.

$link_html                = '<dl><font face="arial,helvetica" size=2><font color=808080>&nbsp; ##number##. &nbsp;</font><b><a href="##url##" target="_top">##title##</a></b>
			          <dd><!--nospider--> ##description##
				  <br><font color=808080><b>URL:</b> ##showurl## </font>
				  <br><font face="arial,helvetica" size=1 color=cc0000><b>View&nbsp;Site</b>&nbsp;&nbsp;&#91;&nbsp;<a href="##url##">same window</a>&nbsp;&nbsp;&nbsp;<a href="##url##" target="cgnewwin">new window</a>&nbsp;&#93;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=000000><b>Source:&nbsp;</b>&nbsp;##source##</font></font>
				  </font></dd></dl>';
                            # -- Result-Link HTML to be shown with Full Details (Title, URL, Descriptions)
                            # -- Write/modify the above HTML code for Result-Links as required.
                            # -- See how the dynamic parameters are used (##url##, ##title## and ##description##)
                            # -- You can optionally use:
                            # --            ##showurl##  -  URL suitable for displaying as text.
                            # --                            Note: the above ##showurl## can be trimmed 
                            # --                            and not a valid URL for creating HTML linking 
                            # --                            if it's length is higher than allowed maximum 
                            # --                            URL length set in the '$link_url_maxlength' parameter.
                            # --                            See the '$link_url_maxlength' parameter below (in this Section).
                            # --            ##source##   -  to show the link to Source (Major Engine).
                            # --            ##number##   -  to show the serial number of the result/link.
                            # -- Make sure the HTML code is quoted within ' ' as shown above. 
                            # -- You can also write the HTML code in multiple-lines.
                            # -- If you use any control or restricted character, you should escape them 
                            # -- with a backward slash. Example: \@  \' \$ \~ \|   etc.


$link_html_no_d            = '<dl><font face="arial,helvetica" size=2><b>&nbsp; ##number##.<a href="##url##" target="_top">##title##</a></b>
			          <dd><font color=808080><b>URL:</b> ##showurl## </font>
			          <br><font size=1 color=000000>Source: ##source## </font>
			          </font></dd></dl>';
                            # -- Result-Link HTML to be shown without Description.
                            # -- Write/modify the above HTML code for Result-Links as required.
                            # -- See how the dynamic parameters are used (##url## and ##title##)
                            # -- You can optionally use:
                            # --            ##showurl##  -  URL suitable for displaying as text.
                            # --                            Note: the above ##showurl## can be trimmed 
                            # --                            and not a valid URL for creating HTML linking 
                            # --                            if it's length is higher than allowed maximum 
                            # --                            URL length set in the '$link_url_maxlength' parameter.
                            # --                            See the '$link_url_maxlength' parameter below (in this Section).
                            # --            ##source##   -  to show the link to Source (Major Engine).
                            # --            ##number##   -  to show the serial number of the result/link.
                            # -- Make sure the HTML code is quoted within ' ' as shown above. 
                            # -- You can also write the HTML code in multiple-lines.
                            # -- If you use any control or restricted character, you should escape them 
                            # -- with a backward slash. Example: \@  \' \$ \~ \|   etc.


$link_html_no_s            = '<dl><font face="arial,helvetica" size=2><b>&nbsp; ##number##. <a href="##url##" target="_top">##title##</a></b>
			          <dd>##description##
				  </font></dd></dl>';
                            # -- Result-Link HTML to be shown without Source (Link to major engine/s).
                            # -- Write/modify the above HTML code for Result-Links as required.
                            # -- See how the dynamic parameters are used (##url## and ##title##)
                            # -- You can optionally use:
                            # --            ##showurl##  -  URL suitable for displaying as text.
                            # --                            Note: the above ##showurl## can be trimmed 
                            # --                            and not a valid URL for creating HTML linking 
                            # --                            if it's length is higher than allowed maximum 
                            # --                            URL length set in the '$link_url_maxlength' parameter.
                            # --                            See the '$link_url_maxlength' parameter below (in this Section).
                            # --            ##number##   -  to show the serial number of the result/link.
                            # -- Make sure the HTML code is quoted within ' ' as shown above. 
                            # -- You can also write the HTML code in multiple-lines.
                            # -- If you use any control or restricted character, you should escape them 
                            # -- with a backward slash. Example: \@  \' \$ \~ \|   etc.


$link_html_no_ds           = '<p><font face="arial,helvetica" size=2><b>&nbsp; ##number## <a href="##url##" target="_top">##title##</a><!--nospider--></b></font>';
                            # -- Result-Link HTML to be shown without Description and Source (Title only).
                            # -- Write/modify the above HTML code for Result-Links as required.
                            # -- See how the dynamic parameters are used (##url## and ##title##)
                            # -- You can optionally use:
                            # --            ##showurl##  -  URL suitable for displaying as text.
                            # --                            Note: the above ##showurl## can be trimmed 
                            # --                            and not a valid URL for creating HTML linking 
                            # --                            if it's length is higher than allowed maximum 
                            # --                            URL length set in the '$link_url_maxlength' parameter.
                            # --                            See the '$link_url_maxlength' parameter below (in this Section).
                            # --            ##number##   -  to show the serial number of the result/link.
                            # -- Make sure the HTML code is quoted within ' ' as shown above. 
                            # -- You can also write the HTML code in multiple-lines.
                            # -- If you use any control or restricted character, you should escape them 
                            # -- with a backward slash. Example: \@  \' \$ \~ \|   etc.


$link_table_color1        = 'ffffff';
$link_table_color2        = 'ffffff';
                            # -- If you want to show the matching links in a changing background 
                            # -- color (rows with different colors), set different HTML color 
                            # -- values (HEX code) for the above 2 parameters. 
                            # -- If both set to the same color code, 
                            # -- it will show them in a plain background.
                            # -- You can set them to the background color of your document 
                            # -- to create the effect of NO background.

$link_table_border        = 0;
$link_table_cellspacing   = 0;
$link_table_cellpadding   = 5;
                            # -- You optionally set your own Table 'border', cellspacing and 
                            # --'cellpadding' values for the links-table 
                            # -- using the above 3 parameters.
                            # -- Note: each result is printed with-in a 
                            # -  dynamically generated Table.


$bold_keywords            = 'on';
                            # -- Make BOLD Keywords. Possible values:
                            # --       on   - if any of the input Keywords are found in the Title, URL or Description, it will be shown in BOLD.
                            # --       off  - Keywords are NOT shown BOLD.

$link_title_maxlength     = 58;
                            # -- Maximum number of characters allowed in the Title.
                            # -- Must be an unsigned integer value. If the Title length 
                            # -- exceeds this value it will be trimmed at the end.
                            # -- Applies to ##title## parameter. (See 'Section B')

$link_url_maxlength       = 65;
                            # -- Maximum number of characters allowed in the ##showurl##.
                            # -- NOTE: this is NOT the same as ##url## parameter which 
                            # -- always contains the FULL VALID URL suitable for HTML linking.
                            # -- Applies to ##showurl## parameter only. (See Section B)
                            # -- Must be an unsigned integer value. If the Title length 
                            # -- exceeds this value it will be trimmed at the end.

#___________________________ Section C ______________________________|
#_____________________________________________________________________________________
# -- the following 4 parameters only applies to Link-Bar 
# -- (Links to other result pages). You can customize and control how your 
# -- Link-Bar should look like.

$linkbar_maxpages         = 29;
                            # -- How many links should appear on the search result Link-bar at a time.
                            # -- You can set any integer value more than 3.

$linkbar_tag_prev         = '[&#60;&#60;&nbsp;Prev]';

$linkbar_tag_next         = '[Next&nbsp;&#62;&#62;]';
                            # -- Text Labels of the 'Previous' and 'Next' buttons on 
                            # -- the Link-Bar. If you do not want any 'Previous' and 'Next'
                            # -- buttons, simply set these above 2 parameters to Empty values.

$linkbar_delim            = ' ';
                            # -- Link delimeter on the Results Link-Bar. 
                            # -- Character or HTML that separates links.


#___________________________ Section D ______________________________|
#_____________________________________________________________________________________
# -- the following 7 parameters are used to customize the ToolBox.
# -- (Show/Hide Summary/Source, Sort/Group results etc.). 
# -- You can customize and control how your ToolBox should look like.

$toolbox_delim             = " &nbsp; ";
                            # -- Link delimeter on the ToolBox. 
                            # -- Character/s or HTML that separates 
                            # -- ToolBox Option links.

$show_summary_label        = "Show Summary"; 

$hide_summary_label        = "Hide Summary";

$show_source_label         = "Show Source";

$hide_source_label         = "Hide Source";

$sort_results_label        = "Sort Results";

$group_results_label       = "Group Results";


#___________________________ Section E ______________________________|
#_____________________________________________________________________________________
# -- the following 2 parameters are used to control how the Source-Links 
# -- (link to Major Engine/s) are showed next to each result 
# -- (if added in '$link_html' and/or '$link_html_no_d' HTML using 
# -- the ##source## parameter. See above 'Section B').

$Engine_Url_Type	= "full";
			# -- Possible Values "full" or "short". Applies to Source-Link.
			# --      full   ->  search-ready link to Source (major engine) with current Keywords.
			# --      short  ->  link to Source (major engine) home page.

$Engine_Url_Target	= "";
			# -- Default target "_top" if no 'Target Window' provided. 
			# -- Possible values: any valid HTML link TARGET WINDOW value.
			# -- Applies to Source link.



#___________________________ Section F ______________________________|
#_____________________________________________________________________________________
# -- the following 3 parameters are used to display Keyword Matches 
# -- from previous searching. Note, that the '$Keyword_Tracking' parameter 
# -- in the Global Configuration file (global_config.pl) must be set to 'full'
# -- to enable Keyword Matching Search.

$kwmatch_link_html         = '<li>
                               <font face="arial,helvetica" size=2><a href="##kwmatchurl##" title="search for: ##kwmatch##">##kwmatch##</a>
                               </font></li>';
                           # -- Should be the Link HTML for Keyword links.
                           # -- Usable parameters:  
                           # --                    ##kwmatchurl##  - search URL using the matching Keyword/s.
                           # --                    ##kwmatch##     - The Keyword/s match as plain text.

$kwmatch_show_max_columns  = 4; 
                            # -- How many Keyword matches per-like (columns)
                            # -- NOTE: ALL Keyword match links are displayed in 
                            # -- a HTML Table format. The above value actually 
                            # -- controls the number of columns in the Table.

$kwmatch_show_max_rows     = 3; 
                            # -- How many lines of Keyword matches (rows)



#___________________________ Section G ______________________________|
#_____________________________________________________________________________________
# -- the following 3 parameters are used to display appropriate 
# -- Error-Messages (if any).


$no_keyword_message         = '<blockquote>
                               <p><font face="arial,helvetica" size=3 color=ff0000><b>
                               No Keywords ...
                               </font></b>
			       <br>&nbsp;
			       <br><font face="verdana,geneva" size=2>
			       Your search could not be completed as you did not input any keywords. Please type some Keywords and try again&nbsp;....
			       </font>
			       </p></blockquote>';
                            # -- The above message will be shown if someone tries to 
                            # -- search without any Keywords. 
                            # -- You can customize the HTML as needed. 
                            # -- Make sure the HTML code is quoted within ' ' as shown above. 
                            # -- You can write the HTML code in multiple-lines.
                            # -- If you use any control or restricted character, you should escape them 
                            # -- with a backward slash. \@  \' \$ \~ \|   etc.

$bad_keyword_message       = '<blockquote>
                               <p><font face="arial,helvetica" size=3 color=ff0000><b>
                               Poor Keyword/s Input: <font size=2 color=0000ff> ##keywords## </font>
                               </font></b>
			       <br>&nbsp;
			       <br><font face="verdana,geneva" size=2>
			       Your search could not be completed. It may be that 
			       you have input Keyword/s that covers a very wide area. 
			       Please type some meaningful Keywords and try again. 
			       You may also try adding more keywords to help 
			       search for more appropriate resources.
			       </font>
			       </p></blockquote>';
                            # -- The above message will be shown if someone tries to 
                            # -- search without any Keywords. 
                            # -- You can customize the HTML as needed. 
                            # -- Make sure the HTML code is quoted within ' ' as shown above. 
                            # -- You can write the HTML code in multiple-lines.
                            # -- If you use any control or restricted character, you should escape them 
                            # -- with a backward slash. \@  \' \$ \~ \|   etc.
                                                      



$no_results_message       = '<blockquote>
                              <p><font face="arial,helvetica" size=3 color=000099><b>
                               Your search for <font color=ff0000>##keywords##</font> could not find any suitable results.</font></b>
                              <br>&nbsp;
                              <br><font face="verdana,geneva" size=2>
                              Please check the spelling or refine your query and try again.
                              </font>
                              </p></blockquote>';
                            # -- The above message will be shown if search could 
                            # -- not find any matching results. You can customize 
                            # -- the HTML as needed. You can use dynamic parameter ##keywords## 
                            # -- to show the input Keywords in the no-result message.
                            # -- You can also use other Global Parameters like ##enckeywords## to
                            # -- create any other types of linking.
                            # -- Make sure the HTML code is quoted within ' ' as shown above. 
                            # -- You can write the HTML code in multiple-lines.
                            # -- If you use any control or restricted character, you should escape them 
                            # -- with a backward slash. Example: \@  \' \$ \~ \|   etc.
                                                      


#___________________________ Section H ______________________________|
#_____________________________________________________________________________________

# -- the following parameter is used to add support for 'Framed-Redirection'
# -- Addon. If you do not have this Addon, leave this as is.

$Framed_Redirection_Url   = "";


#___________________________ Section I ______________________________|
#_____________________________________________________________________________________

# -- the following parameter is used to add support for 'Intermediary-Promotion'
# -- Addon. If you do not have this Addon, leave this as is.

$Inter_promotion_step     = 'off'; 


#___________________________ Section J ______________________________|
#_____________________________________________________________________________________

# -- the following parameter is used to add support for 'Translation-Redirect'
# -- Addon. If you do not have this Addon, leave this as is.

$Translation_Redirect_Url = "";


#___________________________ Section K ______________________________|
#_____________________________________________________________________________________

# -- ALL the following 16 parameters are used to add support for 'Engine-Select'
# -- Addon. If you do not have this Addon, leave them as is.

## --- Engine-Select Starts ---## ES-2
##          NOT PRESENT        ##
## --- Engine-Select Starts ---## Starts

$ES_Report_html           = "";
$ES_Continue_html         = "";
$ES_Javascript_Option     = ""; 
$ES_JS_Image_dir          = ""; 
$ES_Max_Engine_Try        = "";
$ES_Engine_Order          = "";
$ES_Table_Max_Columns     = "";
$ES_Image_Start_Status    = "";
$ES_Image_Trying          = "";
$ES_Image_Tried           = "";
$ES_Image_Remain          = "";
$ES_Image_Partial         = "";
$ES_Image_Timeout         = "";
$ES_Image_Success_Tip     = "";
$ES_Image_Partial_Tip     = "";
$ES_Image_Timeout_Tip     = "";

## --- Engine-Select Starts ---## ES-2
##          NOT PRESENT        ##
## --- Engine-Select Starts ---## Ends


#____________________________________________________________________
#                                                                    |
#    W E B - S E A R C H    C U S T O M I Z A T I O N    E N D S     |
#____________________________________________________________________|
#                                                                    |
#_________  DO NOT CHANGE ANYTHING BELOW THIS LINE  _________________|
#____________________________________________________________________|
return($default_timeout,$default_per_page,$Framed_Redirection_Url,$Translation_Redirect_Url,$Inter_promotion_step,$force_html_output,$bold_keywords,$Engine_Url_Type,$Engine_Url_Target,$link_html,$link_html_no_d,$link_html_no_s,$link_html_no_ds,$link_table_color1,$link_table_color2,$link_table_border,$link_table_cellspacing,$link_table_cellpadding,$linkbar_maxpages,$linkbar_tag_prev,$linkbar_tag_next,$linkbar_delim,$toolbox_delim,$show_summary_label,$hide_summary_label,$show_source_label,$hide_source_label,$sort_results_label,$group_results_label,$link_title_maxlength,$link_url_maxlength,$kwmatch_link_html,$kwmatch_show_max_columns,$kwmatch_show_max_rows,$no_keyword_message,$bad_keyword_message,$no_results_message,$ES_Report_html,$ES_Continue_html,$ES_Max_Engine_Try,$ES_Engine_Order,$ES_Javascript_Option,$ES_JS_Image_dir,$ES_Image_Start_Status,$ES_Image_Trying,$ES_Image_Tried,$ES_Image_Remain,$ES_Image_Partial,$ES_Image_Timeout,$ES_Image_Success_Tip,$ES_Image_Partial_Tip,$ES_Image_Timeout_Tip,$ES_Table_Max_Columns);}
1;
