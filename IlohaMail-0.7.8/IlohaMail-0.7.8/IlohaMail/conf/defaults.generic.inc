<?

/*
	Default colors.  Used for login page, however,
	may be changed by user for customized looks.
*/
$default_colors=array(
	"tool_bg"=>"#333377",
	"tool_link"=>"#FFFFFF",
	"folder_bg"=>"#6666AA",
	"folder_link"=>"#FFFFFF",
	"main_bg"=>"#f0f0f0",
	"main_hilite"=>"#dedede",
	"main_text"=>"#000000",
	"main_link"=>"#000099",
	"quotes"=>"blue"
);
$init["my_colors"] = $default_colors;


/*
	Default prefernce values.  Note that
	these values may be changed by the user
	through the prefs panel
*/
$default_prefs=array(
	"colorize_quotes"=>1,
    "detect_links"=>1,
	"view_max"=>15,
	"show_size"=>1,
	"save_sent"=>0,
	"sent_box_name"=>"",
	"delete_trash"=>0,
	"trash_name"=>"",
	"rootdir"=>$rootdir,
	"user_name"=>"",
	"email_address"=>"",
	"signature1"=>"",
	"show_sig1"=>0,
	"lang"=>$lang,
	"charset"=>$lang_charset,
	"sort_field"=>"DATE",
	"sort_order"=>"DESC",
	"list_folders"=>1,
	"view_inside"=>1,
	"timezone"=>0,
	"html_in_frame"=>0,
	"show_images_inline"=>0
);
$init["my_prefs"] = $default_prefs;


/*
	init_from_address
	Used to generate "From" and/or "Sender" header addresses,
	if host is different from domain.  If host is mail.domain.com
	but mail should be addressed to @domain.com, set this value
	to "%u@domains.com".  Default is blank, which is the same as
	"%u@%h".
*/
$init_from_address = ""; //for "user@host"

?>