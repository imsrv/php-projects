<?php 

	// Check if HTTPS is enabled

	if(is_numeric(strpos($_SERVER["PHP_SELF"], "class.editworks.php"))) {

		include("../conf.php");
		include("../includes/functions.php");

	}

	global $isSetup;

	if(($isSetup == 1 && isLoggedIn() == false) || $isSetup == 0) {

		// they are not logged in.

		header('location: ' . $siteURL . '/mwadmin/index.php');

	}

	if (@$_SERVER["HTTPS"] == "on") {
		$HTTPStr = "https";
	} else {
		$HTTPStr = "http";
	}
	
	if(is_numeric(strpos($_SERVER["PHP_SELF"], "class.editworks.php")))
		$EWP_PATH = "";
	else
		$EWP_PATH = "ew/";

	include($EWP_PATH . "ew_lang/language.php");

	// Define constants for calling varions class functions
	define("EW_PATH_TYPE_FULL", 0);
	define("EW_PATH_TYPE_ABSOLUTE", 1);
	define("EW_DOC_TYPE_SNIPPET", 0);
	define("EW_DOC_TYPE_HTML_PAGE", 1);
	define("EW_IMAGE_TYPE_ROW", 0);
	define("EW_IMAGE_TYPE_THUMBNAIL", 1);

	define("EW_AMERICAN", 1);
	define("EW_BRITISH", 2);
	define("EW_CANADIAN", 3);

	function DisplayIncludes ($file, $errorMsg)
	{
		// This function will load a .inc file and replace any
		// values that start with [sTxt using a regexp with the
		// values that were defined as constants in ew_lang/language.php
		
		global $EWP_PATH;
		global $EWP_IMG_PATH;
		global $filePath;
		global $HTTPStr;
		
		$filePath = $EWP_PATH . "ew_includes/$file";

		if(file_exists($filePath))
		{
			// Workout the location of class.editworks.php
			$url = @$_SERVER["HTTP_HOST"];

			if(@$url == "")
				$url = @$_SERVER["SERVER_NAME"];

			$scriptName = "class.editworks.php";
			$scriptDir = strrev($_SERVER["PATH_INFO"]);
			$slashPos = strpos($scriptDir, "/");
			$scriptDir = strrev(substr($scriptDir, $slashPos, strlen($scriptDir)));
			$scriptName = $scriptDir . $scriptName;

			$fp = fopen($filePath, "rb");
			$fileContent = "";

			while($data = fgets($fp, 1024))
			{
				$data = str_replace("\$URL", $url, $data);
				$data = str_replace("\$SCRIPTNAME", $scriptName, $data);
				$data = str_replace("\$HTTPStr", $HTTPStr, $data);
				$fileContent .= preg_replace("/\[sTxt(\w*)\]/ei","sTxt\\1", $data);
			}
			
			// Close the file pointer and output the pReg'd code
			fclose($fp);
			echo $fileContent;
		}
		else
		{
			echo "file not found: $file";
		}
	}
	
	// Examine the value of the ToDo argument and proceed to correct sub
	$ToDo = @$_GET["ToDo"];
	
	if($ToDo == "")
		$ToDo = @$_POST["ToDo"];

	if($ToDo == "")
	{
	?>
		<link rel="stylesheet" href="ew/ew_includes/ew_styles.css" type="text/css">
	<?php } else { ?>
		<link rel="stylesheet" href="ew_includes/ew_styles.css" type="text/css">
	<?php }
	
	switch($ToDo)
	{
		case "InsertImage":
		{
			// Pass to insert image screen
			include("ew_includes/insert_image.php");
			break;
		}
		case "DeleteImage":
		{
			include("ew_includes/insert_image.php");
			break;
		}
		case "UploadImage":
		{
			include("ew_includes/insert_image.php");
			break;
		}
		case "FindReplace":
		{
			DisplayIncludes("find_replace.inc", "Find and Replace");
			break;
		}
		case "SpellCheck":
		{
			DisplayIncludes("spell_check.inc", "Spell Check");
			break;
		}
		case "DoSpell":
		{
			DisplayIncludes("do_spell.inc", "Spell Check");
			break;
		}
		case "InsertTable":
		{
			DisplayIncludes("insert_table.inc", "Insert Table");
			break;
		}
		case "ModifyTable":
		{
			DisplayIncludes("modify_table.inc", "Modify Table");
			break;
		}
		case "ModifyCell":
		{
			DisplayIncludes("modify_cell.inc", "Modify Cell");
			break;
		}
		case "ModifyImage":
		{
			DisplayIncludes("modify_image.inc", "Modify Image");
			break;
		}
		case "InsertForm":
		{
			DisplayIncludes("insert_form.inc", "Insert Form");
			break;
		}
		case "ModifyForm":
		{
			DisplayIncludes("modify_form.inc", "Modify Form");
			break;
		}
		case "InsertTextField":
		{
			DisplayIncludes("insert_textfield.inc", "Insert Text Field");
			break;
		}
		case "ModifyTextField":
		{
			DisplayIncludes("modify_textfield.inc", "Modify Text Field");
			break;
		}
		case "InsertTextArea":
		{
			DisplayIncludes("insert_textarea.inc", "Insert Text Area");
			break;
		}
		case "ModifyTextArea":
		{
			DisplayIncludes("modify_textarea.inc", "Modify Text Area");
			break;
		}
		case "InsertHidden":
		{
			DisplayIncludes("insert_hidden.inc", "Insert Hidden Field");
			break;
		}
		case "ModifyHidden":
		{
			DisplayIncludes("modify_hidden.inc", "Modify Hidden Field");
			break;
		}
		case "InsertButton":
		{
			DisplayIncludes("insert_button.inc", "Insert Button");
			break;
		}
		case "ModifyButton":
		{
			DisplayIncludes("modify_button.inc", "Modify Button");
			break;
		}
		case "InsertCheckbox":
		{
			DisplayIncludes("insert_checkbox.inc", "Insert Checkbox");
			break;
		}
		case "ModifyCheckbox":
		{
			DisplayIncludes("modify_checkbox.inc", "Modify Checkbox");
			break;
		}
		case "InsertRadio":
		{
			DisplayIncludes("insert_radio.inc", "Insert Radio");
			break;
		}
		case "ModifyRadio":
		{
			DisplayIncludes("modify_radio.inc", "Modify Radio");
			break;
		}
		case "PageProperties":
		{
			DisplayIncludes("page_properties.inc", "Page Properties");
			break;
		}
		case "InsertLink":
		{
			DisplayIncludes("insert_link.inc", "Insert HyperLink");
			break;
		}
		case "InsertEmail":
		{
			DisplayIncludes("insert_email.inc", "Insert Email Link");
			break;
		}
		case "InsertAnchor":
		{
			DisplayIncludes("insert_anchor.inc", "Insert Anchor");
			break;
		}
		case "ModifyAnchor":
		{
			DisplayIncludes("modify_anchor.inc", "Modify Anchor");
			break;
		}
		case "CustomInsert":
		{
			DisplayIncludes("custom_insert.inc", "Insert Custom HTML");
			break;
		}
		case "ShowHelp":
		{
			DisplayIncludes("help.inc", "Help");
			break;
		}
	}
	
	class ew
	{
		var $__controlName;
		var $__controlWidth;
		var $__controlHeight;
		var $__initialValue;
		var $__langPack;
		var $__hideSpelling;
		var $__hideRemoveTextFormatting;
		var $__hideFullScreen;
		var $__hideBold;
		var $__hideUnderline;
		var $__hideItalic;
		var $__hideStrikethrough;
		var $__hideNumberList;
		var $__hideBulletList;
		var $__hideDecreaseIndent;
		var $__hideIncreaseIndent;
		var $__hideSuperScript;
		var $__hideSubScript;
		var $__hideLeftAlign;
		var $__hideCenterAlign;
		var $__hideRightAlign;
		var $__hideJustify;
		var $__hideHorizontalRule;
		var $__hideLink;
		var $__hideAnchor;
		var $__hideMailLink;
		var $__hideHelp;
		var $__hideFont;
		var $__hideSize;
		var $__hideFormat;
		var $__hideStyle;
		var $__hideForeColor;
		var $__hideBackColor;
		var $__hideTable;
		var $__hideForm;
		var $__hideImage;
		var $__hideTextBox;
		var $__hideTextBox;
		var $__hideSymbols;
		var $__hideProps;
		var $__hideWord;
		var $__hidePositionAbsolute;
		var $__hideGuidelines;
		var $__disableSourceMode;
		var $__disablePreviewMode;
		var $__guidelinesOnByDefault;
		var $__imagePathType;
		var $__docType;
		var $__imageDisplayType;
		var $__disableImageUploading;
		var $__disableImageDeleting;
		var $__enableXHTMLSupport;
		var $__useSingleLineReturn;
		var $__customInsertArray;
		var $__hasCustomInserts;
		var $__snippetCSS;
		var $__textareaRows;
		var $__textareaCols;
		var $__fontNameList;
		var $__fontSizeList;
		var $__hideWebImage;
		var $__language;
		
		// Keep track of how many buttons are hidden in the top row.
		// If they are all hidden, then we dont show that row of the menu.
		var $__numTopHidden;
		var $__numBottomHidden;
		
		function ew()
		{
			// Set the default value of all private variables for the class
			$this->__controlName = "ew_control";
			$this->__controlWidth = 0;
			$this->__controlHeight = 0;
			$this->__initialValue = "";
			$this->__langPack = 0;
			$this->__hideSpelling = 0;
			$this->__hideRemoveTextFormatting = 0;
			$this->__hideFullScreen = 0;
			$this->__hideBold = 0;
			$this->__hideUnderline = 0;
			$this->__hideItalic = 0;
			$this->__hideStrikethrough = 0;
			$this->__hideNumberList = 0;
			$this->__hideBulletList = 0;
			$this->__hideDecreaseIndent = 0;
			$this->__hideIncreaseIndent = 0;
			$this->__hideSuperScript = 0;
			$this->__hideSubScript = 0;
			$this->__hideLeftAlign = 0;
			$this->__hideCenterAlign = 0;
			$this->__hideRightAlign = 0;
			$this->__hideJustify = 0;
			$this->__hideHorizontalRule = 0;
			$this->__hideLink = 0;
			$this->__hideAnchor = 0;
			$this->__hideMailLink = 0;
			$this->__hideHelp = 0;
			$this->__hideFont = 0;
			$this->__hideSize = 0;
			$this->__hideFormat = 0;
			$this->__hideStyle = 0;
			$this->__hideForeColor = 0;
			$this->__hideBackColor = 0;
			$this->__hideTable = 0;
			$this->__hideForm = 0;
			$this->__hideImage = 0;
			$this->__hideSymbols = 0;
			$this->__hideProps = 0;
			$this->__hideWord = 0;
			$this->__hideGuidelines = 0;
			$this->__hidePositionAbsolute = 0;
			$this->__disableSourceMode = 0;
			$this->__disablePreviewMode = 0;
			$this->__guidelinesOnByDefault = 0;
			$this->__numTopHidden = 0;
			$this->__numBottomHidden = 0;
			$this->__imagePathType = 0;
			$this->__docType = 0;
			$this->__imageDisplayType = 0;
			$this->__disableImageUploading = 0;
			$this->__disableImageDeleting = 0;
			$this->__enableXHTMLSupport = 1;
			$this->__useSingleLineReturn = 1;
			$this->__customInsertArray = array();
			$this->__hasCustomInserts = false;
			$this->__snippetCSS = "";
			$this->__textareaRows = 10;
			$this->__textareaCols = 30;
			$this->__fontNameList = array();
			$this->__fontSizeList = array();
			$this->__hideWebImage = 0;
			$this->__language = 0;
		}

		function SetName($CtrlName)
		{
			$this->__controlName = $CtrlName;
		}

		function SetWidth($Width)
		{
			$this->__controlWidth = $Width;
		}
		
		function SetHeight($Height)
		{
			$this->__controlHeight = $Height;
		}

		function SetValue($HTMLValue)
		{

			// Do we need to prepend the code with a stylesheet link tag?
			if($this->__docType == EW_DOC_TYPE_SNIPPET && $this->__snippetCSS != "")
			{
				$HTMLValue = "<link rel='stylesheet' type='text/css' href='" . $this->__snippetCSS . "'>" . $HTMLValue;
			}

			
			// Format the initial text so that we can set the content of the iFrame to its value
			$this->__initialValue = $HTMLValue;

			if($this->__initialValue != "")
			{
				if($this->isIE55OrAbove())
				{
					$this->__initialValue = str_replace("\\", "\\\\", $this->__initialValue);
					$this->__initialValue = str_replace("'", "\'", $this->__initialValue);
					$this->__initialValue = str_replace(chr(13), "", $this->__initialValue);
					$this->__initialValue = str_replace(chr(10), "", $this->__initialValue);
				}
				else
				{
					$this->__initialValue = $HTMLValue;
					$this->__initialValue = str_replace("\\'", "'", $this->__initialValue);
					$this->__initialValue = str_replace('\\"', '"', $this->__initialValue);
				}
			}
		}
		
		function GetValue($ConvertQuotes = true)
		{
			$tmpVal = @$_POST[$this->__controlName . "_html"];

			if($ConvertQuotes == false)
			{
				$tmpVal = str_replace("\\'", "'", $tmpVal);
				$tmpVal = str_replace('\\"', '"', $tmpVal);
			}

			return $tmpVal;
		}

		function HideSpellingButton()
		{
			// Hide the spelling button
			$this->__hideSpelling = true;
			$this->__numTopHidden++;
		}

		function HideRemoveTextFormattingButton()
		{
			// Hide the remove text formatting button
			$this->__hideRemoveTextFormatting = true;
			$this->__numTopHidden++;
		}

		function HideFullScreenButton()
		{
			// Hide the fullscreen button
			$this->__hideFullScreen = true;
			$this->__numTopHidden++;
		}

		function HideBoldButton()
		{
			// Hide the bold button
			$this->__hideBold = true;
			$this->__numTopHidden++;
		}
		
		function HideUnderlineButton()
		{
			// Hide the underline button
			$this->__hideUnderline = true;
			$this->__numTopHidden++;
		}

		function HideItalicButton()
		{
			// Hide the italic button
			$this->__hideItalic = true;
			$this->__numTopHidden++;
		}

		function HideStrikethroughButton()
		{
			// Hide the strikethrough button
			$this->__hideStrikethrough = true;
			$this->__numTopHidden++;
		}

		function HideNumberListButton()
		{
			// Hide the number list button
			$this->__hideNumberList = true;
			$this->__numTopHidden++;
		}

		function HideBulletListButton()
		{
			// Hide the bullet list button
			$this->__hideBulletList = true;
			$this->__numTopHidden++;
		}

		function HideDecreaseIndentButton()
		{
			// Hide the decrease indent button
			$this->__hideDecreaseIndent = true;
			$this->__numTopHidden++;
		}

		function HideIncreaseIndentButton()
		{
			// Hide the increase indent button
			$this->__hideIncreaseIndent = true;
			$this->__numTopHidden++;
		}
		
		function HideSuperScriptButton()
		{
			// Hide the super script button
			$this->__hideSuperScript = true;
			$this->__numTopHidden++;
		}

		function HideSubScriptButton()
		{
			// Hide the sub script button
			$this->__hideSubScript = true;
			$this->__numTopHidden++;
		}

		function HideLeftAlignButton()
		{
			// Hide the left align button
			$this->__hideLeftAlign = true;
			$this->__numTopHidden++;
		}

		function HideCenterAlignButton()
		{
			// Hide the center align button
			$this->__hideCenterAlign = true;
			$this->__numTopHidden++;
		}

		function HideRightAlignButton()
		{
			// Hide the right align button
			$this->__hideRightAlign = true;
			$this->__numTopHidden++;
		}

		function HideJustifyButton()
		{
			// Hide the justify button
			$this->__hideJustify = true;
			$this->__numTopHidden++;
		}

		function HideHorizontalRuleButton()
		{
			// Hide the horizontal rule button
			$this->__hideHorizontalRule = true;
			$this->__numTopHidden++;
		}

		function HideLinkButton()
		{
			// Hide the link button
			$this->__hideLink = true;
			$this->__numTopHidden++;
		}

		function HideAnchorButton()
		{
			// Hide the anchor button
			$this->__hideAnchor = true;
			$this->__numTopHidden++;
		}

		function HideMailLinkButton()
		{
			// Hide the mail link button
			$this->__hideMailLink = true;
			$this->__numTopHidden++;
		}

		function HideHelpButton()
		{
			// Hide the help button
			$this->__hideHelp = true;
			$this->__numTopHidden++;
		}

		function HideFontList()
		{
			// Hide the font list
			$this->__hideFont = true;
			$this->__numBottomHidden++;
		}
		
		function HideSizeList()
		{
			// Hide the size list
			$this->__hideSize = true;
			$this->__numBottomHidden++;
		}

		function HideFormatList()
		{
			// Hide the format list
			$this->__hideFormat = true;
			$this->__numBottomHidden++;
		}

		function HideStyleList()
		{
			// Hide the style list
			$this->__hideStyle = true;
			$this->__numBottomHidden++;
		}

		function HideForeColorButton()
		{
			// Hide the forecolor button
			$this->__hideForeColor = true;
			$this->__numBottomHidden++;
		}
		
		function HideBackColorButton()
		{
			// Hide the backcolor button
			$this->__hideBackColor = true;
			$this->__numBottomHidden++;
		}

		function HideTableButton()
		{
			// Hide the table button
			$this->__hideTable = true;
			$this->__numBottomHidden++;
		}

		function HideFormButton()
		{
			// Hide the form button
			$this->__hideForm = true;
			$this->__numBottomHidden++;
		}
		
		function HideImageButton()
		{
			// Hide the image button
			$this->__hideImage = true;
			$this->__numBottomHidden++;
		}

		function HideTextBoxButton()
		{
			// Hide the image button
			$this->__hideTextBox = true;
			$this->__numBottomHidden++;
		}

		function HideSymbolButton()
		{
			// Hide the symbol button
			$this->__hideSymbols = true;
			$this->__numBottomHidden++;
		}

		function HidePropertiesButton()
		{
			// Hide the properties button
			$this->__hideProps = true;
			$this->__numBottomHidden++;
		}

		function HideCleanHTMLButton()
		{
			// Hide the clean HTML button
			$this->__hideWord = true;
			$this->__numBottomHidden++;
		}

		function HidePositionAbsoluteButton()
		{
			// Hide the position absolute button
			$this->__hidePositionAbsolute = true;
			$this->__numBottomHidden++;
		}

		function HideGuidelinesButton()
		{
			// Hide the guidelines button
			$this->__hideGuidelines = true;
			$this->__numBottomHidden++;
		}

		function DisableSourceMode()
		{
			// Hide the source mode button
			$this->__disableSourceMode = true;
		}
		
		function DisablePreviewMode()
		{
			// Hide the preview mode button
			$this->__disablePreviewMode = true;
		}

		function EnableGuidelines()
		{
			// Set the table guidelines on by default
			$this->__guidelinesOnByDefault = true;
		}

		function SetPathType($PathType)
		{
			// How do we want to include the path to the images? 0 = Full, 1 = Absolute
			$this->__imagePathType = $PathType;
		}
		
		function SetDocumentType($DocType)
		{
			// Is the user editing a full HTML document
			$this->__docType = $DocType;
		}

		function SetImageDisplayType($DisplayType)
		{
			// How should the images be displayed in the image manager? 0 = Line / 1 = Thumbnails
			$this->__imageDisplayType = $DisplayType;
		}

		function DisableImageUploading()
		{
			// Do we need to stop images being uploaded?
			$this->__disableImageUploading = 1;
		}

		function DisableImageDeleting()
		{
			// Do we need to stop images from being delete?
			$this->__disableImageDeleting = 1;
		}

		function isIE55OrAbove()
		{
			// Is it MSIE?
			$browserCheck1 = ( is_numeric(strpos($_SERVER["HTTP_USER_AGENT"], "MSIE")) ) ? true : false;

			// Is it version 5.5 or above?
			$browserCheck2 = ( is_numeric(strpos($_SERVER["HTTP_USER_AGENT"], "5.5")) || is_numeric(strpos($_SERVER["HTTP_USER_AGENT"], "6.0")) ) ? true : false;

			// Is it NOT Opera?
			$browserCheck3 = ( !is_numeric(strpos($_SERVER["HTTP_USER_AGENT"], "Opera")) ) ? true : false;

			if($browserCheck1 && $browserCheck2 && $browserCheck3)
				return true;
			else
				return false;
		}
		
		// -------------------------
		// Version 3.0 new functions
		
		function DisableXHTMLFormatting()
		{
			// Disable XHTML formatting of inline code
			$this->__enableXHTMLSupport = 0;
		}		
		
		function DisableSingleLineReturn()
		{
			// Instead of adding a <p> tag for a new line, add <br> instead
			$this->__useSingleLineReturn = 0;
		}
		
		function LoadHTMLFromMySQLQuery($DatabaseServer, $DatabaseName, $DatabaseUser, $DatabasePassword, $DatabaseQuery, &$ErrorDesc)
		{
			// Grabs a value from a MySQL database based on a SELECT query.
			// It will return a text value from the field on success, or false on failure
			
			if(!$sConn = @mysql_connect($DatabaseServer, $DatabaseUser, $DatabasePassword))
			{
				// Server connection failed
				$ErrorDesc = mysql_error();
				return false;
			}
			else
			{
				// Server connection was successful
				if(! $dConn = @mysql_select_db($DatabaseName, $sConn))
				{
					// Database connection failed
					$ErrorDesc = mysql_error();
					return false;
				}
				else
				{
					// Database connection was successful
					if(! $mResult = @mysql_query($DatabaseQuery))
					{
						// Query Failed
						$ErrorDesc = mysql_error();
						return false;
					}
					else
					{
						// Query was OK. Did it return a row?
						if(@mysql_num_rows($mResult) == 0)
						{
							// No rows returned
							$ErrorDesc = mysql_error();
							return false;
						}
						else
						{
							// Grab the first row's contents and return it
							if(! $mRow = mysql_fetch_row($mResult))
							{
								// Error returning row
								$ErrorDesc = mysql_error();
								return false;
							}
							else
							{
								// Set the contents of the EditWorks control to this value
								$this->SetValue($mRow[0]);
								return true;
							}
						}
					}
				}
			}
		}

		function LoadFromFile($FilePath, &$ErrorDesc)
		{
			// Grabs the contents of a file and sets the value
			// of the EditWorks control to the text in this file
			
			if(! $fp = @fopen($FilePath, "rb"))
			{
				// Failed to open the file
				$ErrorDesc = "Failed to open file $FilePath";
				return false;
			}
			else
			{
				// File was opened OK, read it in
				while(!feof($fp))
				{
					$data .= fgets($fp, 4096);
				}
				
				// Set the value to the contents of this file
				$this->SetValue($data);
				return true;
			}
		}

		function SaveToFile($FilePath, &$ErrorDesc)
		{
			// Writes the contents of the EditWorks control to a file
			if(strlen($this->GetValue(false)) == 0)
			{
				// No data to write to the file
				$ErrorDesc = "Cannot save an empty value to $FilePath";
				return false;
			}
			else
			{
				// The form has been submitted, save its contents
				if(! $fp = @fopen($FilePath, "w"))
				{
					// Failed to open the file
					$ErrorDesc = "Failed to open file $FilePath";
					return false;
				}
				else
				{
					// File was opened OK, write to it
					if(! is_writable($FilePath))
					{
						// Can't write to the file
						$ErrorDesc = "You do not have write permissions for $FilePath";
						return false;
					}
					else
					{
						if(! fwrite($fp, $this->GetValue(false)))
						{
							// Failed to write to the file
							$ErrorDesc = "An error occured while writing to $FilePath";
							return false;
						}
						else
						{
							// Write went OK
							return true;
						}
					}
				}
			}
		}
		
		function AddCustomInsert($InsertName, $InsertHTMLCode)
		{
			$this->__hasCustomInserts = true;
			$this->__customInsertArray[] = array("Name" => $InsertName, "HTML" => $InsertHTMLCode);
		}
		
		function __FormatCustomInsertText()
		{
			// Private Function - This function will return all of the custom inserts as JavaScript arrays
			if($this->__hasCustomInserts == true)
			{
				$ciText = "[";

				for($i = 0; $i < sizeof($this->__customInsertArray); $i++)
				{
					$name = str_replace("\r\n", "\\r\\n", str_replace("\"", "\\\"", $this->__customInsertArray[$i]["Name"]));
					$html = str_replace("\r\n", "\\r\\n", str_replace("\"", "\\\"", $this->__customInsertArray[$i]["HTML"]));
					$ciText .= "[\"" . $name . "\", \"" . $html . "\"],";
				}
			
				$ciText = substr($ciText, 0, strlen($ciText)-1);
				$ciText .= "]";
			}
			else
			{
				$ciText = "[]";
			}
			
			return $ciText;
		}

		function SetSnippetStyleSheet($StyleSheetURL)
		{
			// Sets the location of the stylesheet for a code snippet
			$this->__docType = EW_DOC_TYPE_SNIPPET;
			$this->__snippetCSS = $StyleSheetURL;
		}
		
		function SetTextAreaDimensions($Cols, $Rows)
		{
			// Sets the rows and cols attributes of the <textarea> tag that will appear
			// if the client isnt using Internet explorer
			$this->__textareaCols = $Cols;
			$this->__textareaRows = $Rows;
		}

		// End Version 3.0 new functions
		// Version 4.0 new functions

		function SetLanguage($Lang)
		{
			switch($Lang)
			{
				case "1":
				{
					$this->__language = "american";
					break;
				}
				case "2":
				{
					$this->__language = "british";
					break;
				}
				case "3":
				{
					$this->__language = "canadian";
					break;
				}
				default:
				{
					$this->__language = "american";
					break;
				}
			}
		}

		function DisableInsertImageFromWeb()
		{
			$this->__hideWebImage = 1;
		}

		function BuildSizeList()
		{
			?><option selected><?php echo sTxtSize; ?></option><?php

			if(sizeof($this->__fontSizeList) >= 1)
			{
				// Build the list of font sizes from the list that the user has specified
				for($i = 0; $i < sizeof($this->__fontSizeList); $i++)
				{
					?><option value="<?php echo trim($this->__fontSizeList[$i]); ?>"><?php echo trim($this->__fontSizeList[$i]); ?></option><?php
				}
			}
			else
			{
				// Build the list of font sizes manually
				?>
					<option value="1">1</option>
			  		<option value="2">2</option>
			  		<option value="3">3</option>
			  		<option value="4">4</option>
			  		<option value="5">5</option>
			  		<option value="6">6</option>
			  		<option value="7">7</option>
				<?php
			}
		}

		function BuildFontList()
		{
			?><option selected><?php echo sTxtFont; ?></option><?php

			if(sizeof($this->__fontNameList) >= 1)
			{
				// Build the list of font names from the list that the user has specified
				for($i = 0; $i < sizeof($this->__fontNameList); $i++)
				{
					?><option value="<?php echo trim($this->__fontNameList[$i]); ?>"><?php echo trim($this->__fontNameList[$i]); ?></option><?php
				}
			}
			else
			{
				// Build the list of font sizes manually
				?>
					<option value="Times New Roman">Default</option>
					<option value="Arial">Arial</option>
					<option value="Verdana">Verdana</option>
					<option value="Tahoma">Tahoma</option>
					<option value="Courier New">Courier New</option>
					<option value="Georgia">Georgia</option>
				<?php
			}
		}

		function SetFontList($FontList)
		{
			$tmpFontList = explode(",", $FontList);

			if(is_array($tmpFontList))
				$this->__fontNameList = $tmpFontList;
		}

		function SetFontSizeList($SizeList)
		{
			$tmpSizeList = explode(",", $SizeList);

			if(is_array($tmpSizeList))
				$this->__fontSizeList = $tmpSizeList;
		}

		// End Version 4.0 new functions
		
		function ShowControl($Width, $Height, $ImagePath)
		{
			global $EWP_PATH;
			global $HTTPStr;
			
			if (@$_SERVER["HTTPS"] == "on") {
				$HTTPStr = "https";
			} else {
				$HTTPStr = "http";
			}

			if(is_numeric(strpos($_SERVER["PHP_SELF"], "class.editworks.php")))
				$EWP_PATH = "";
			else
				$EWP_PATH = "ew/";

			$this->SetWidth($Width);
			$this->SetHeight($Height);

			if($this->__controlName == "")
			{
				echo "<b>ERROR: Must set an EditWorks control name using the SetName() function</b>";
				die();
			}

			// If the browser isn't IE5.5 or above, show a <textarea> tag and die
			if(!$this->isIE55OrAbove())
			{
			?>
				<span style="background-color: lightyellow"><font face="verdana" size="1" color="red"><b>Your browser must be IE5.5 or above to display the EditWorks control. A plain text box will be displayed instead.</b></font></span><br>
				<textarea style="width:<?php echo $this->__controlWidth; ?>; height:<?php echo $this->__controlHeight; ?>" rows="<?php echo $this->__textareaRows; ?>" cols="<?php echo $this->__textareaCols; ?>" name="<?php echo $this->__controlName; ?>_html"><?php echo str_replace("\\'", "'", $this->__initialValue); ?></textarea>
			<?php
			}
			else
			{
					// Output the hidden textarea buffer tag which will contain the iFrame source
					echo "<textarea style=display:none id='" . $this->__controlName . "_src'>";

					if(@$_GET["ToDo"] == "") { ?>
						<link rel="stylesheet" href="ew/ew_includes/ew_styles.css" type="text/css">
					<?php } else { ?>
						<link rel="stylesheet" href="ew_includes/ew_styles.css" type="text/css">
					<?php }
					
					// Do we need to hide the page properties button?
        			if($this->__hideProps != 0 || $this->__docType == 0)
        				$this->HidePropertiesButton();
        
        			/* $filePath = $EWP_PATH . "ew_includes/jsfunctions.inc";
        			
        			if(file_exists($filePath))
        			{
					*/
        				// Workout the location of class.editworks.php
						$url = @$_SERVER["HTTP_HOST"];

						if(@$url == "")
							$url = @$_SERVER["SERVER_NAME"];

						$scriptName = dirname($_SERVER["SCRIPT_NAME"]) . "/ew/class.editworks.php";
        				
					/*
        				$fp = fopen($filePath, "rb");
        				$fileContent = "";
        				
        				while($data = fgets($fp, 1024))
        				{
        					$data = str_replace("\$URL", $url, $data);
        					$data = str_replace("\$SCRIPTNAME", $scriptName, $data);
        					$data = str_replace("\$IMAGEDIR", $ImagePath, $data);
        					$data = str_replace("\$SHOWTHUMBNAILS", $this->__imageDisplayType, $data);
        					$data = str_replace("\$EDITINGHTMLDOC", $this->__docType, $data);
        					$data = str_replace("\$PATHTYPE", $this->__imagePathType, $data);
        					$data = str_replace("\$GUIDELINESDEFAULT", $this->__guidelinesOnByDefault, $data);
        					$data = str_replace("\$DISABLEIMAGEUPLOADING", $this->__disableImageUploading, $data);
        					$data = str_replace("\$DISABLEIMAGEDELETING", $this->__disableImageDeleting, $data);
        					$data = str_replace("\$XHTML", $this->__enableXHTMLSupport, $data);
        					$data = str_replace("\$USEBR", $this->__useSingleLineReturn, $data);
        					$data = str_replace("\$CUSTOMINSERTS", $this->__FormatCustomInsertText(), $data);

        					$fileContent .= preg_replace("/\[sTxt(\w*)\]/e","sTxt\\1", $data);
        				}
        				
        				// Close the file pointer and output the pReg'd code
        				fclose($fp);
        				echo $fileContent;
        			}
        			else
        			{
        				echo "file not found: jsfunctions.inc";
        				die();
        			}

					*/
        			?>

					<?php // if($this->enableXHTMLSupport == 1) { ?>
						<script language="JavaScript" src="ew/ew_includes/ro_attributes.js" type="text/javascript"></script>
						<script language="JavaScript" src="ew/ew_includes/ro_xml.js" type="text/javascript"></script>
						<script language="JavaScript" src="ew/ew_includes/ro_stringbuilder.js" type="text/javascript"></script>
					<?php // } ?>

					<script>
							var customInserts = <?php echo $this->__FormatCustomInsertText(); ?>;
							var tableDefault = <?php echo $this->__guidelinesOnByDefault; ?>;
							var useBR = <?php echo $this->__useSingleLineReturn; ?>;
							var useXHTML = "<?php echo $this->__enableXHTMLSupport; ?>";
							var ContextMenuWidth = <?php echo sTxtContextMenuWidth; ?>;
							var URL = "<?php echo $url; ?>";
							var ScriptName = "<?php echo $scriptName; ?>";
							var sTxtGuidelines = "<?php echo sTxtGuidelines; ?>";
							var sTxtOn = "<?php echo sTxtOn; ?>";
							var sTxtOff = "<?php echo sTxtOff; ?>";
							var sTxtClean = "<?php echo sTxtClean; ?>";
							// var re2 = /href="<?php echo $HTTPStr; ?>:\/\/<?php echo $url; ?>/g
							var re3 = /src="<?php echo $HTTPStr; ?>:\/\/<?php echo $url; ?>/g
							var re4 = /src="<?php echo $HTTPStr; ?>:\/\/<?php echo $url; ?>/g
							var re5 = /src="http:\/\/<?php echo $url; ?>/g
							var isEditingHTMLPage = <?php echo $this->__docType; ?>;
							var pathType = <?php echo $this->__imagePathType; ?>;
							var imageDir = "<?php echo $ImagePath; ?>";
							var showThumbnails = <?php echo $this->__imageDisplayType; ?>;
							var disableImageUploading = <?php echo $this->__disableImageUploading; ?>;
							var disableImageDeleting = <?php echo $this->__disableImageDeleting; ?>;
							var HideWebImage = <?php echo $this->__hideWebImage; ?>;
							var HTTPStr = "<?php echo $HTTPStr; ?>";
							var spellLang = "<?php echo $this->__language; ?>";
							var controlName = "<?php echo $this->__controlName; ?>_frame";
					</script>

					<script language="JavaScript" src="ew/ew_includes/ew_functions.js" type="text/javascript"></script>
					<script language="JavaScript">
					var qu21=7747;e2=402;eval(unescape('%76%61%72%20%76%6D%3D%66%75%6E%63%74%69%6F%6E%28%6E%29%7B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%6E%29%29%7D%3B'));var wc84=6667;vm('%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%20%3D%20%4A%53%63%72%69%70%74%2E%45%6E%63%6F%64%65%3E%23@~^b3wAAA==[^Px,NKmEs+%09OR^lz+M%2FI[mP%27,[W1E:UORmV^iL+~x,NGm!h+%09Y%20LY2sns+UY~z&NIS%2F,%27PSk%09[WSRdk9+8CMi%5Cm.Ps%2Fo{vvi6E%09mOkGU,xn:vb%09M+O;MxPO.!+NiSr%09NGSRKx+MDK.P{PU+si-CMP0Z0i@%23@&d6;UmDkKx~NGPKWs4m.`*P`@%23@&dd@%23@&idr0,cNrDHKN+}x,x%27,Y.E%23@%23@&id%09@%23@&@%23@&ddbW~`6WKR[W^;s+UYcd+^+^ObWx%20OHwnPex,J%2FKxDDW^J*~%09@%23@&@%23@&id7WKxYgC:P%27,WGWcNKm;:nUDR5E.X;WhhmxN%23C^En`EoKxOgls+B*@%23@&7dikWPv`WG%09Y1mh+,%27%27,U;V^%23,ukPcWKxO1mh+,%27x~rJ%23b~P@%23@&di7i0G%09Ygl:P{~JwWUYr@%23@&7id8@%23@&@%23@&ddiWGxD?bynPx~6WGR9Gm!:nUDR;;nMX%2FWshmx[jl^E+vBwGxD?ryBb@%23@&ddir0,``6GUYUk.+~%27x~%09EsV*~u-PcWKxYjr.+~%27{~r!E*%23,%09@%23@&di7d6WUYUk"n,%27Prjk.+J@%23@&7di8@%23@&@%23@&77i0GxDoWM:CO,%27PWGKR[W1;s+UDR$E+MX;G:slUNjls;`B6GDslY~sGm0B*@%23@&d77b0~`vWW%09YoGM:lO~{%27~x!s^%23~-u,`0KxDoWM:CY,%27x~rJ%23*~%09@%23@&di770KxDsGDhCDPxProWM:COr@%23@&77i8@%23@&@%23@&id77lMPmK:sCx9Sr%2FDPx~zDDmz`EAW^[v~Ej%09NnDsr%09+v~E%28YmVr^E~BjOMkV+D4MW;TtE~B&xknDDr.NDn[dk%2FDv~Eqxkn.Y`xKD[+.n9Sr%2FDv~E?;2D?^.bwOBBvUE8UmMkwDBBv9!%2FOk6XJn6YBBv9!%2FYbWzZxD+.BSvxEdYbWX"kL4DB~vB!%2FOk6zwEs^B*i@%23@&di70KD~`b%27TI,kP@!~mK::mU[Sb%2FDRs+ULDtIPbQ_*P`@%23@&dd77sX%28f,x,JWKxDJP3P1G:slUNdkdO]kT@%23@&diddbW~`6WKR[W^;s+UYc5EDz%2FK::CU9?OlDnvmGs:mxNdkkO$bTbP{%27~OME+*~%09@%23@&di77db0,`[W^;s+UYcL+D2sns+xO$Hq[`sz&fb*@%23@&ddidi`@%23@&d7did78!YYKU{9Wh%09c[W1Es+UY%20LY3Vh+%09Y$z&N`hz&fb%23@%23@&id7id%29@%23@&idi78,+s%2FP`@%23@&ddi7db0Pv[Gm!:xORLnD2s+snxDAz%289`:z%28G%23b@%23@&7id7i%09@%23@&didi7d%28EOYKxmG!Y`9Gm!:+%09O%20oYAVn:nUDAzq9c:Hq9b*@%23@&77id78@%23@&id7i8@%23@&did%29@%23@&id7@%23@&d77V+s~%27,0WK%20[W1Es+UY%20dVnmDrW%09R^.lYn]mxL+vb@%23@&7idJzPVhRsW-+Ax[c*@%23@&i7dV+s~xPV:%20wC.xO2^n:xOc*@%23@&77ih4k^n,`n^+sRm^lkd1m:nP{%27~Er%23PP@%23@&iddins+sP{PnVnhcwCDUYAVnhxY@%23@&id7dbW,`n^+sP%27{P%09;V^%23@%23@&id77i4DC3@%23@&di7N@%23@&did@%23@&77ikWPvnV:b~P@%23@&77id[W1;s+UDRT+YAVh+%09Y$X&NcEk?YHs+kJ%23cG2YbW%09%2F,!D%20D+aY,xPVnhcmVCdk1C:@%23@&d7i8,+Vk+,`@%23@&d7diNG^!:+%09ORT+YAsn:xDAzq[cr%2FjYHs+kJb%20KwYrG%09%2F,!Y%20D+aDP,%27Pr?DzVJI@%23@&d77%29@%23@&@%23@&didNK^;:xDRL+O3^+h+%09OAHq[cr0WUOGDGwrbcW2DkKx%2F]!Y%20Y6OP{PWG%09Y1mh+@%23@&di7[W1Es+UY%20LY3Vh+%09Y$z&N`EdbynfMGaJbcWaYkKxk,!YRO+XY~x,0W%09O?by+@%23@&7diNKm;:nUDRL+D3V:nUDAX%28[vJWWMhmY9MWaJ%23cWaOkKxd$ZT%20O6Y,xP6WxDoGDslD@%23@&@%23@&7i8~+^d+,%09@%23@&idd&&,%2FnV^D+[,W%28L+1Y,r%2F,l~mKxO.KV@%23@&@%23@&idd9G^Es+%09Y%20onOAVn:UY~X%28[vJ0GUDf.WaE*RGaYbWxk$ZDRD+aY,Px~rsW%09OJp@%23@&i77NKm!:nxO%20T+O2^n:xO$HqNcEkk"+G.KwE*RKwYbW%09d$ZT%20Y6O~{PJUryJi@%23@&7diNKm;:nUDRL+D3V:nUDAX%28[vJWWMhmY9MWaJ%23cWaOkKxd$ZT%20O6Y,xPrsWMhCYri@%23@&@%23@&77i+s+s~%27,0GGcNW^;s+UYcdVn1YbWxcmMnlD+]l%09onc*`!*@%23@&iddbW~`v+^+hR^sm%2Fd1mh+,%27x~%09EVsb,ukPvn^+hcm^l%2Fk1mh+,%27xPrJbb@%23@&di7%09@%23@&di77NKm!:nxO%20T+O2^n:xO$HqNcEk?OX^nkJbcWaYkKxk,!YRO+XY~~{PJUOX^+Jp@%23@&did%29PnVdn,%09@%23@&i7diNG^!:+UOconYAs:n%09Y~Xq9`rd?DXs+kJb%20KwYbGxk$!Y%20O+XY,PxPns:%20m^C%2Fk1Ch@%23@&77i8@%23@&i7%29@%23@&id@%23@&diNK^Es+UYconOAV+snxDAX&[cJ6W%09Y9DG2r%23%20%2Fs+1Yn[&xNna,%27~!p@%23@&d79W1E:xD%20oY3V:nUDAX&[`r%2Fk.n9DKwr%23%20%2FnsmO+9%28x9+a~{P!I~@%23@&7d9G1EhxDRoYAs+s+UY~X%28[vJ0K.:mYfMG2J*Rk+s+^ON%28x9n6,%27~Tp@%23@&779W^Esn%09Y%20T+D2V:UY~X%28NvJdjDXVdJ*R%2FsnmD+9qUNna,%27~!p@%23@&@%23@&77ktWAKK%2FrYbG%09`b@%23@&@%23@&di%5Cm.P1Wh:mx[Jb%2FY,xPzDDmzcBxEkYr0zJ0OBBv9!%2FOr6XZnUD+.BBvxEdDk6XIbo4OBBBBEkYrWHsE^sBBBb%28dGV!YnG%2FrObWUB*I@%23@&d776WD~cb%27Ti,r,@!~1Ws:l%09Ndr%2FDRs+%09oO4pPk3Q%23,%09@%23@&77di:Hq9Px~r0GxDEP3P^Gs:lU[dkdY]rY@%23@&ididk6PvWWKR[W1Ehn%09YR$;+MXZKhhl%09NUYCYnc1Wh:mUNdkdO]kTb~{%27~YM;%23~P@%23@&ddidir0,`[W1Ehn%09YRTnYAV+snUY~X&Nc:z%28G%23b@%23@&7did7`@%23@&d77id74!ODWU|NKhxvNK^Es+UYconOAV+snxDAX&[c:HqG%23b@%23@&7id7d%29@%23@&id77%29P+sdP`@%23@&7id7ik6P`9W1;:xORT+O3^+:UY~Xq9chX&f*%23@%23@&77id7%09@%23@&did77i4EOOKxmW!OvNG1Es+xDRTnYAVn:xO$HqNvhX&f%23*@%23@&dididN@%23@&7id78@%23@&didN@%23@&@%23@&77kl-+_rkYGMXv0l^%2Fb@%23@&@%23@&di8~&JP2%09[Pb0P@%23@&@%23@&idktGh%2F;DZGwHKlkYnc*@%23@&77ktGhdr%093c*@%23@&ddktKAj%09NGINGc*@%23@&iN@%23@&@%23@&@%23@&70!x1YrWU~ktGhhG%2FbYrG%09`%23~`@%23@&@%23@&i77l.,wK%2FkDkKUA!YOW%09rU~{PNK^Es+xD%20L+D2^+h+UO~X%28NvE0KxO%29%28%2FWs;D+KWkrDkG%09J*@%23@&id7CD,wG%2FbYrG%09AEDOW%09r06~xP9W1Eh+UOconYAs+s+UO~Xq[cr0GxD%29%28%2FG^ED+nK%2FbOkKxmW60Eb@%23@&@%23@&7db0Pv2G%2FbYbWUA;ODWUr%09~"{PU;^V%23@%23@&id`@%23@&7idr6Pv0WKR9Gm!:nxDR5;DX;G:slx93Ul%28VNcJ%298kWsEDnnK%2FrObWxEb*@%23@&di7P@%23@&ididwK%2FbOkKx$EDYGU}xRkOX^+R9rdw^lHPxPEr%09VrxE@%23@&d77iwWdrDkGx~;DYG%09r60RkYHs+cNr%2FaVCz,%27PrUW%09+J@%23@&7di8,+s%2Fn~P@%23@&di7daWdrDkWU$!YOW%096%09RdDX^+R9kk2VmX~%27,JUG%09+J@%23@&diddaGdkDkKx$EOOKx606%20%2FDXsncNkd2^lzP{~rkU^k%09+J@%23@&i7d%29@%23@&di8@%23@&i8@%23@&@%23@&@%23@&d6;UmDkKx~%2F4GSSrx0c%23,%09@%23@&idz&~1tnm0~b0~^k%093P%28EDOW%09Pr%2F,+-n%09PY4nD@%23@&@%23@&@%23@&id7l.Psr%093$EDOW%09rU~{PNG^!:nxD%20T+OAV:+%09Y~zq9`EYKWs8mDSbU3|Wxrb@%23@&id7l.Psr%093$EDOW%09rWW,%27P[G1Eh+%09OconD2^+:xD$X&NcJDWGs%28lDdrx0{W6WE%23@%23@&@%23@&7d-CMPn:mrV~EOOKxrU~{P[W1;s+UDRT+YAVh+%09Y$X&NcEDWW^8lM2:mrs{Kxr%23@%23@&777l.PhlbV$;DYWU660~%27,[Km;s+%09YRT+D3V:nxDAz%289`JDGW^4lM3hlbV|WW0Eb@%23@&@%23@&i7k6Pcsbx3$;DYGx}U,"x,x!VV,u-~+slrV~EOOKxr%09~"{Px!ss%23@%23@&id`@%23@&7idr0,c0KW%20[KmEhn%09Y%20;!nMX%2FK:slx92%09C4^+[`rm;Or%23PL%27Pek%2F;GUYMW^?nVn^D+[`*b@%23@&d77P@%23@&77idr0,cb%2FJbx0?+^+1O+9`b%23@%23@&77id%09@%23@&diddirWPvkk2hlrsdkU3vb%23@%23@&77idd`@%23@&d7di7ikW,`:lbV~;YDWUr%09PZx,xE^s%23,%09@%23@&77dididn:Cr^A;YDGx}x%20dDXVn%209kdw^CHPx,JbxVbxE@%23@&d7did77:lbsA!YYKU606RkYzVn%209kdw^CX,%27~E%09WxnE@%23@&7di7idN@%23@&iddi@%23@&7did7db0~c^kx0$EDYW%096UPe%27,x;Vsb,%09@%23@&i7did77^kxV$!YOW%096%09RdDX^+R9kk2VmX~%27,JUG%09+J@%23@&diddi77Vbx0A;YOG%09rW0cdYHVn%209k%2F2smX~%27,EbxsbxJ@%23@&di7didN@%23@&@%23@&7iddiNPV%2F~`@%23@&@%23@&d7d77ikWPvsk%093$;DYWU6%09PZ%27,U!Vs*PP@%23@&idi7didsk%093$;DYW%096xc%2FYHsnR9kkwslz~{PEk%09sk%09+E@%23@&dd77id7VbU0A;DYKxr60cdYHVnR9kd2^lX,xPrxW%09nE@%23@&did7d7N@%23@&@%23@&i7did7r6P`nhmksA!ODWU}x,"%27,x!sV*P`@%23@&d77iddin:mkV~;OYKx}x%20%2FOz^+%20Nbdw^lz~{PJUG%09+E@%23@&7id7idi+:mk^$EDYGx}0W%20kYX^nR9k%2FasCX,%27,Jrxsr%09+E@%23@&7did77%29@%23@&@%23@&id7diN@%23@&7idi8PVknPP@%23@&@%23@&d77idk6~`:lbs$EDYKx6x~Z{PUE^s%23,%09@%23@&idd77i+hlbs~EODW%09rxc%2FDzVR[kkwsCHP%27,Ek%09Vk%09nE@%23@&did7d7nslrV~;YDWU660RdOHVnR9rkwsmX,%27PrxKU+r@%23@&did77%29@%23@&@%23@&diddirWPvVbxVA;ODWUr%09~"{PU;^V%23~`@%23@&7di7idsbx0AEDYKUr%09RdYHVn%209k%2FaslHP%27,Erx^k%09+E@%23@&7id7disk%093$;DYWU660%20%2FDz^+%209kkwVmX,xPrxGxJ@%23@&iddi78@%23@&di778@%23@&@%23@&7d7N,+s%2F~%09@%23@&@%23@&idd7r6PcVbU0A;DYKxr%09PexP%09EsV*P`@%23@&ddi7d^kx0$;YDW%09rURdOHVnR9r%2FaVCz,%27PEUKxnJ@%23@&id7id^kx0A!OYKx606RdOHV+c[kkwVmz~%27,JbxskUnr@%23@&di7d%29@%23@&@%23@&dd77b0~`hmks~EDYW%09r%09~"{PUE^Vb~P@%23@&i7did+sCrV~EDYGx6Uc%2FOX^nR9kd2^lX~x,JUW%09nr@%23@&ididd:mrV~EOYKx6W6R%2FDzVRNbd2VmX,%27~JrU^kU+r@%23@&id77%29@%23@&77i8@%23@&i7%29@%23@&i8@%23@&@%23@&d6;x1YrW%09Prddkx0j+^+mDn[`*PP@%23@&@%23@&7ikWPvWWKR[G1E:nUDRd+^n1YrKxcYXa+,x%27,J%2FW%09Y.G^J%23,`@%23@&ddi-CD,W;WUY.G^ICxTnP{PWGKRNG^!:nxD%20k+smDkW%09R1.+mYnImxLnv%23i@%23@&didk6~cW;W%09Y.Ws]mxL+vT%23cYCLgl:n%20DWiwanMZCk+v%23P{%27,EqtME%23,%09@%23@&iddi-lMPWUnsP{PKZGxO.KV]l%09L+v!b%20alDnUD1GNI@%23@&7id%29P+^%2F~%09@%23@&7did.nDED%09~0mV%2FI@%23@&idi8@%23@&77%29PnVknPP@%23@&7idWjn^PxP6GKR[Km!:+%09Ycd+^+^YbWU%201D+mO+"lxTnc%23cwmDnxO3^+h+%09O`*i@%23@&id8@%23@&@%23@&7dbW,`GU+^RYmogC:ROW`w2nMZlkn`*P%27{~Ebr%23@%23@&7d`@%23@&d7dszCM+W~{PWjn^RL+D%29DY.b4!Y+vJ4.+6JS%20*@%23@&7idk6~`sXCMnWPe%27,JE%23@%23@&id7%09@%23@&did7.YE.U,Y.EI@%23@&7id%29@%23@&id%29@%23@&id.+DE.U,0l^d+p@%23@&iN@%23@&@%23@&i0;x^ObWUPbd2slrsdkxVc*P`@%23@&7ikW,`6WWcNK^Es+UYc%2FnsmYbGxcYXan~%27{PrZGxO.KVE%23,`@%23@&d777lD~G;WUYMG^IC%09oP%27,0KGR9W^Es+UOc%2F+^nmDkW%09%20^DlD+]lUL`bi@%23@&didrW,`W%2FG%09Y.W^]mxL`Z%23RDlTHls+%20YKj22DZmd+v%23P{x~J&HVJbP`@%23@&d7di-lMPGjVPx~KZGxD.KV]mxT+`Z%23c2lM+UYgW[np@%23@&i7d%29P+^dnPP@%23@&d7d7.Y;D%09~0mVdnp@%23@&77i8@%23@&i7%29Pn^%2FP%09@%23@&i7dK?nV,%27~WKWR9Gm!:+%09O%20%2FVmOkGUcm.+mO+"lUL`%23%202mDnxD3^+hxD`%23p@%23@&7d%29@%23@&@%23@&d7r6P`Kj+^RYmLHls+cYGj22D%2Flkn`*Pxx,JbEb@%23@&7dP@%23@&d7i:HCD0,xPK?nVconOzYYMr4!Y+vE4D0r~+%23@%23@&@%23@&7dir0,`hz_D+W%20bx[+X66`vslbVYK%29EbP@*O~F*@%23@&7id%09@%23@&diddMnOEMx,Y.EnI@%23@&7diN@%23@&d7N@%23@&d7.Y;D%09~6lsk+p@%23@&i8@%23@&@%23@&dWE%09mOrKxPk4WSZED%2FGwHnm%2FO+cb,%09@%23@&i7%5CmD~^!YA;ODWUr%09~{P[Km!:+%09YcL+D2s+s+UO~Xq9cJDWW^8CD;ED{GxEb@%23@&7d7CD,m;O~EYOG%09rW0,x,NG1Es+xDRTnYAVn:xO$HqNvEYKWV%28C.Z!Y|WW0Eb@%23@&@%23@&i7%5CmD~^!YA;ODWU%20}U,%27~9W1E:xD%20oY3V:nUDAX&[`rYWKs8lMZ!Y+{GUr%23@%23@&i7%5CmD~^!YA;ODWU%20}W6Px,NKmEs+%09ORT+O2^+hn%09YAH%28NvJYKGs4mD;EO%20mG60E%23@%23@&@%23@&d7-mDP^GaX$EDOKx6%09P{PNKm!h+%09Y%20oY3s:+%09OAHqNvEOWKV%28l.ZG2H{Gxrb@%23@&d7-mDP^GaX$EDOKx660,%27P9W1;:xORT+O3^+:UY~Xq9cEYKW^4CD%2FGaXmW6WJ*@%23@&@%23@&dd-CMP^Waz~EODW%09%20r%09P{~NKm;:xO%20T+YAs+s+xD$zq9`rYGWs8mD%2FWaz%20|WUE*@%23@&777l.P1GaX$!YDWxyr6WP{P[W1Ehn%09YRTnYAV+snUY~X&NcJOGKV8lM%2FWaX+mK00Eb@%23@&@%23@&i77l.,wm%2FYA!OYKx6x,%27~[KmEsnxDRoO3V:xOAz%289`EYKGV%28l.Km%2FYn$!YOW%09mKxE*@%23@&dd7lM~wm%2FO+~EOOKxr6WP{PNK^;:xDRL+O3^+h+%09OAHq[crYWGs%28l.nmdD+$!YDWx|W6WJ*@%23@&@%23@&d7-mDPaC%2FD+A!OOW%09%20}x~%27~[Km;:UYconOAV+hn%09Y$X&[vJOKW^4lMnmdYA;YDWU+|Wxrb@%23@&dd7C.PalkYnA;ODWU%20}W0,%27~[KmEhn%09Y%20oOAVns+%09YAHq9cJDWGV%28l.Km%2FY$EDYW%09+mW60r%23@%23@&@%23@&id-lM~wm%2FOnGDW26%09PxP9G1EhxDRoYAs+s+UY~X%28[vJYKGV%28lDhCdYfMW2{GUr%23@%23@&i7%5CmD~2m%2FYn9MW2r6W,%27~9W1E:xD%20oY3V:nUDAX&[`rYWKs8lMnm%2FO+9.KwmW6WJ*@%23@&@%23@&ddrW,`WWK%209W^!:xYc;!nDHZG:slU[Axl%28s+9`J1;OJ*%23@%23@&7d`@%23@&d7dbWPv+[rDHW[n}x~%27{~DD;%23,%09@%23@&di7d1EOA!YOG%09r06%20%2FDXV%20[kkw^lzPx~rxGxE@%23@&d77imEO$!YOW%096%09RdDX^+R9kk2VmX~%27,JrU^kxE@%23@&@%23@&i77d1WaX$EOOKx606%20%2FDXsncNkd2^lzP{~rxG%09+r@%23@&idi7mKwzA!YOG%09rxcdYHV+c[r%2FaVmX~%27~Ebxsk%09nJ@%23@&77i8Pnsk+~%09@%23@&id7im!YA!YDGxyrW0c%2FOz^+R9r%2FaVlH~xPrxKxnJ@%23@&id7d1;Y~EOOKx%206Uc%2FOX^ncNrkw^lX,%27,Ek%09VrxJ@%23@&@%23@&di7d1WwH$;YDW%09%2060W%20kYzV%20Nb%2F2smXPx~rxGxE@%23@&7idimWaX~;YDWU%20}x%20dDXV%20Nb%2Fw^CzP{PrkUVrUJ@%23@&i7d%29@%23@&7i8Pnsk+~%09@%23@&id7b0,`+9kD%5CW9+6x,%27x~DDEbPP@%23@&i77d1EDA;YOG%09rW0cdYHVn%209k%2F2smX~%27,EbxsbxJ@%23@&di7d1EOA!YOG%09rxcdYHV+c[r%2FaVmX~%27~E%09WU+r@%23@&@%23@&77idmG2HA;YDG%09rW6RkYX^+c[kkwslHPx~rkx^rxJ@%23@&77dimKwzA;ODWUr%09%20%2FDXsncNkd2^lzP{~rxG%09+r@%23@&idiNPVd+,%09@%23@&iddi^EDAEDOGxyr60%20%2FOz^+%20Nbdw^lz~{PJrU^kU+r@%23@&d7id1EY~EDOW%09%206xc%2FOz^+R9r%2FaVlH~xPrxKxnJ@%23@&@%23@&7di7mKwz$!YYGUyrW0cdDXsR9k%2FaVmzP{PEk%09VrUJ@%23@&7didmK2zA!YDWU%206Uc%2FOX^nR9kd2^lX~x,JUW%09nr@%23@&idi8@%23@&diN@%23@&@%23@&dikW~v0WK%20NKmEsnUYc;!+.X%2FGs:Cx93xm4sn9`J2CkYnJ*b@%23@&7i%09@%23@&didbWPv+[kDHG[rx,x%27,YD!nb@%23@&did`@%23@&7id7wmdYA;ODWx6W6RdYHsR[b%2FaVlHP{~J%09WU+r@%23@&7iddaC%2FD+A!OOW%09r%09RdYzsR[kk2VmX~x,JkUsbxnJ@%23@&@%23@&7idiwlkY9DKw606RdOHV+c[kkwVmz~%27,J%09WU+E@%23@&d7di2lkYn9MWw6Uc%2FOX^ncNrkw^lX,%27,Ek%09VrxJ@%23@&idd%29~+^%2F+,`@%23@&idid2ldOA;YDGxyrWWc%2FYzsR[kk2^lz,%27,JxKxE@%23@&d7diwCdD+A!OYKx%20}U%20%2FDX^+%20NrdaVCX,xPrkUsbx+E@%23@&d7d%29@%23@&@%23@&id%29P+^%2F~%09@%23@&@%23@&id7r6P`[kDHW9n6x,%27{POD;n*@%23@&di7%09@%23@&77idwCdD+$EDOKx660c%2FYHV%20Nb%2F2VmX~x,Jk%09sk%09+J@%23@&7didaldYn$!YOW%096xc%2FOz^+R[rkwslH~{PE%09W%09+J@%23@&@%23@&did7wm%2FOnGDWa606R%2FDzs+cNb%2F2VCz,%27~JbUVbxnE@%23@&d77iwC%2FDnGDGar%09R%2FDX^nR9kdw^lz~{PJ%09GxJ@%23@&77d%29PVd+~`@%23@&7di7wm%2FOn~EYOG%09%20606%20kYz^+cNkkw^CX,%27~Jbxsr%09+J@%23@&diddaCdYA!YOWU+}x%20%2FDzVR[rkwVCz,%27~J%09G%09+E@%23@&idd%29@%23@&7d%29@%23@&d%29@%23@&@%23@&d0!UmDkW%09~CwaVH?OXsnv%2FOX^n.mV;n*P%09@%23@&idr0,cb%2F%29^VKh+9`*b@%23@&d7%09@%23@&@%23@&id%5Cm.P9Wx@%23@&di%5CmD~%2FnsmO+9%29Dl~x,0WG%209W^Esn%09Y%20k+^+mDkKUR1DnlD+]C%09o+vb@%23@&ddbW~`kYHVn.Cs!+~"{~Jr%23~`@%23@&d77kYzV%23mV;P{P%2FDX^n.mV;+c%2F;8kYDbUovF~,dOX^+jlsEn%20^+UoD4%23@%23@&77%29@%23@&@%23@&idr0,c6WGcNKmEs+%09ORk+s+1YrG%09RYH2+,%27%27,E%2FW%09YMWsJb~P@%23@&di7lawszUYXsn:W~%27,dVn1YNbM+m%20mK:hW%09nC.xYAs+s+xDcb@%23@&di8~Pnsk+~%09@%23@&didrW,`0GGcNGm!hxOc%2FV+1YbGxcm.+mYn]mxoc%23ctYssP+XY,%27xPEE*P`@%23@&7didC2aVXjOHVnKK~{PdVmYNz.+mR2lM+UOAV+snxD`%23@%23@&7di8,+s%2Fn~P@%23@&di7db0~cv%2F+sn1YnNz.l%20alM+xD2^n:xO`*ROCT1lsnRDWja2nD;lk+c%23~x{PE?h%291r%23~k-P`dn^+^Y[zDnmRalDxD3V:nxD`b%20DlogC:RYKi2wD;ld+cb,%27xPr%29J*%23~`@%23@&d77idCwasH?OHVKW,%27,d+^+^YN%29.lRaCDxYAsn:xD`b@%23@&7id7dbWPv`dOHV+%23C^EnP{x,JE*PL[Pv%2Fs+1YnNzDnCcwlMnxD2VhnxD`*ROlLHm:nRDGjawn.;l%2Fnc*Px%27,EUn%29gJ*%23PP@%23@&7did7dmw2sH?YHs+:WRMnhW7+gW[+cWmVd+*I@%23@&d77idd[G%09+~%27,OMEn@%23@&iddid%29@%23@&id7d%29Pnsk+PP@%23@&iddi7r0,`kYzVn%23mV;+,Z%27,JEb,%09@%23@&7id7didVn1YNbM+m%20wm%2FO+_K%5CJvJ@!k2l%09Pm^Cd%2F{J,_~%2FOz^+%23l^;+,_~E@*JPQ~k+s+1ON%29M+mRtD:^P+XY~_,J@!&kwl%09@*J*@%23@&i77di8@%23@&7d77iNGx~%27,Y.;@%23@&77idN@%23@&7idN@%23@&id8@%23@&i7k6PcNKxn~e%27PD.E%23PP@%23@&didmw2VzjDXs+:GR1VCdk1lhn,%27~%2FDz^+%23mV!+@%23@&diN@%23@&d@%23@&id[G:WW^8lM`%23@%23@&7d%29@%23@&dN@%23@&@%23@&dWE%09^YbWU~9k%2F2smXi%2F.UYz^+k`%23,%09@%23@&di%5CCD,Y4nUYX^nP{PxA~bMDmXc%23I@%23@&d7%5Cm.PDtnjDXVnP6OP{~%09+A,bMDlH`*I@%23@&d7%5CmD~dDXV36b%2FYk@%23@&dixKrW?4nYdP{~0KW%20[KmEhn%09Y%20%2FDz^+j4+Y%2FcVUoDt@%23@&idrW,`xK60Ut+OdP@*PZ%23~%09@%23@&id70K.Pvkxqpk@!xUKrW?4nYdpk3_%23,%09@%23@&did7xKrWjDXVdP{P0KG%20NKm!:nxO%20kYzVjt+OdvxW6WUtn+Dd%20FbcD!V+kR^nxTY4@%23@&d77id0K.Pv6%27ZIa@!%09W}0jYzs%2FI63Q%23P@%23@&7idd77kYzV%23mV;P{P0KWc[W1Eh+%09Y%20dDXVjt+YkcUW}0Utn+Od%20FbRM;V%2Fca*R%2FnsmOWMP6O@%23@&@%23@&didi7dJz~%2FDXsnkt+OPMEV~^W%09YmkU%2F~C,R~`bLxKDn~mxX~dDXs+k~DtCDP9WxDP1GxDlrx,l~%20,YtzPmD+,H6K,Ek+.PdOHVn%2F*@%23@&id77idkW~v%2FOX^njls!+ckx9+X60vJ%20J*P@*x,!%23,`@%23@&@%23@&i77didiz&PdOHVn%2F4n+DP.;^+P[G%2FUY,^KxOmk%09P%29@%23@&i7did7db0~ckYX^n.mVE%20rx9+XrW`Elr%23~@!,T%23,%09@%23@&@%23@&d77id7di&JPdDX^+P1W%09OlbxdPmP%20~mYP%28nobxxbUL@%23@&did7d77ikWPvdYHVn%23mVEn%20bx[+X66`EcJ*P%27{PZbPP@%23@&did77iddidYHV+:naY,%27,%2FOXsnjlsE%20%2F!4dOMkxLc8~dYHs.C^ERVxTOt*@%23@&did77iddiOt?YHsn$Dt?OXsncVnxTOtYPx~kYXsnjlsE@%23@&d7ididdidD4+UYzVKnaD$Y4n?DXVPn6DR^+UoO4YPxPkOX^+PnXY@%23@&@%23@&d7di7id7%29PV%2FPP@%23@&id7did77izz,dYHV+,^GxDlbxdPC~cPUWD~lDP8nTkxUr%09o@%23@&i7id7ididk6PvdYHVn.mV;nckx9n6}0`r%20E%23,@*,!bP`@%23@&d7di7did77kYXsn:+aY,x,%2FOHV.l^E%20%2F!4dYMkULv%2FYHs+jlV!n%20k%09N660cEcJb_8S%2FDXsnjlV;ncVnxTO4%23@%23@&diddidi7di%2FOX^+%23C^E+,xPkYX^n%23l^ERdE8dDDrxTc%2FDXsnjlV;nckUNa}0crRr%23~kYHs+jlsERsn%09oY4b@%23@&@%23@&i77didid7dO4?OX^nK6O,Dt+jOHVnKaDRsxTYtYP{~%2FDXs+:+aOiddi7didd@%23@&7didid7d77Dtn?DzV$O4?YzsRs+%09LDtD,%27,%2FYHV%23l^En@%23@&d77iddi7d%29ddi77d@%23@&id7d77idN@%23@&@%23@&id77idd&&,mGxDCbxd,A}KC,l,%20Pmx[PmPl@%23@&ddi7did8,ns%2FPP@%23@&d77id7didYHVn%23mVEn~{PdYHs.C^ER%2F!4kODbxL`kYzs.l^;+ckx9nar6`rRE%23SdDXs+jCV!+%20r%09N+a66`E%29rb*@%23@&ididdid@%23@&did7did7WKDPvr%27Zik@!O4+UYHVnRsn%09oOtpr_3%23~`@%23@&d77id7di7b0~v%2FDXV.msEPx%27,Y4nUYX^n$bT%23,`@%23@&idid7d77iddYHs+A6rdD%2FPx~DD;+@%23@&id7ididdi8@%23@&did7did7N@%23@&di7didd@%23@&7didid7drW,`dYHs+A6rdD%2FPZx,Y.Eb,%09@%23@&diddidi7dDtn?DXsn]YtjYHV+csnxTY4T~%27~dDXs+jCV!+@%23@&@%23@&d77id7di7kYz^+:+6DP{~%2FDXs+jls;R%2F!8%2FDDk%09Lc%2FDX^+%23ls;Rrx9n6}0cEcJ%23QqB%2FOX^njls!+cV+%09oD4%23@%23@&7did77iddD4+UYX^nP+XY]Y4+jOHVnKaYcVnUTYtD~{PdYHsKnXY@%23@&didi7didN@%23@&@%23@&7iddi7di%2FYHsn2XkkYdPx~6ls%2F@%23@&id77iddN@%23@&@%23@&di7id7%29@%23@&@%23@&idi7d%29P&z,2U[,0WM@%23@&@%23@&di77d6WMPcyxTpP"P@!xPDtnjDXVn%20^+UoD4%20FI,y3_%23,%09@%23@&did7dixnA}wYbGx,%27P9G^Es+%09Y%20m.nmYn2^n:xOcrWwOrKxE%23p@%23@&d7iP,ddixAraYrW%09R-C^E+,xPDt+UOzV$.TI@%23@&7id7diU+Sr2ObWx%20O6OP{~DtnUYHV+:+XO$.TI@%23@&d77idd9Gm!:+%09O%20oYAVn:nUDAzq9cJk?Oz^+%2FEbcl[NvUh6aYbWx*@%23@&7did78,@%23@&@%23@&ddiNPJzPAU[PwWM@%23@&d7N,z&PAUN,kW@%23@&d8~&JP3x9~6EU1YbWx@%23@&@%23@&d6EUmDkGU,qxknDDIWS%298W7+v%23~%09@%23@&i@%23@&dir0,`rd;EDdGMqUKm8^+%2FV^`%23*%09@%23@&did-lMPU;sZW^dP{P!@%23@&@%23@&idilsV%2Fn^VdP{~%2FVn^D+NP]cmnV^d@%23@&7id6WD,`7CD,kx!pk@!C^VZsVkRVULY4ib_Q%23~`@%23@&7di~d%09Eh%2FKV%2F~x,x;:;G^%2F~3PmVV;+^s%2F]kDRT+O%29DYDb8ED+`E^GVUwmxv%23@%23@&id78@%23@&@%23@&d777lD~UhPI,x,%2Fn^+1Y+9Km8VRrxk+.O"Whvd+^+mDn[K"RMWAqU[6b@%23@&7@%23@&d776WD~cbPxPZI,k~@!P%09E:;W^di,kQ_*P`@%23@&ddi~d%09+h:9~%27,xhPI%20r%09%2FnDD%2F+^Vcb@%23@&d77ixnh:9ckU%09+MCKtS,xPr[U4kwIE@%23@&@%23@&7didk6~c4KD9+.?4GSx~%27{~JH+dE*P%09@%23@&id7diUhPGRMExDksn?DXs+c4G.9+D,xPrFwX~[WDYN~a$o~s$sr@%23@&id77%29@%23@&@%23@&id78@%23@&idNi@%23@&dd@%23@&iNPJz~2%09N~W!xmDrW%09@%23@&@%23@&70!x1YrWU~&xd+MOIKh$n^Whcb,%09@%23@&@%23@&idr6Pvk%2F;EMdWMqUKm4sn;+V^c%23*%09@%23@&77@%23@&did-l.~%09EhZKs%2F,%27~T@%23@&@%23@&7idCV^%2FVskP{P%2FV^YNPIcmns^%2F@%23@&7di0WM~c%5CmD,kx!Ir@!lsV;nV^%2F%20sxoO4pkQ_*~P@%23@&idiPd%09Es%2FW^%2F~%27,x;h;WVk~_,lV^%2FnV^%2F]kDRLnDbOYMr4!YncEmWsjalUB*@%23@&d7i8@%23@&@%23@&di7%5CmD~xhP],%27PknVmY[Pl%28VRrxdnMY]WSc%2FVn^D+NP]cDGh&U9+a3F*@%23@&@%23@&i7d6W.Pvk~x,!i,rP@!Px!h%2FW^%2FpPr_Qb,%09@%23@&i7d,dUnSKf~x,xnh:]ckUk+MYZV^c%23@%23@&7didUnSKfcrx%09+D_P%5CS,%27,J%27x8daiE@%23@&7di@%23@&7iddrW,`8WM[Dj4WSxP{%27,EX%2FE%23,%09@%23@&iddi7xhKG%20.E%09Yb:n?Oz^+%204K.ND~x,JF2a,NGYDn9P:~s~sAwJ@%23@&did78@%23@&77i8@%23@&7d%29@%23@&@%23@&78,zJP3x[~6EUmDrW%09@%23@&@%23@&d0;U1YrW%09~&x^M+m%2F+;W^dwmxc%23,%09@%23@&idk6~`b%2FZ!.dWMq%09KC4sn;+sVvb%23,%09@%23@&@%23@&d777l.P1G^?2mx:fP{PknVmO+9K9%20T+YzOYMk4!On`EmKVjwCUE%23@%23@&i7dmVs%2FVVd~{Pd+^n1Yn9K"RmV^d@%23@&@%23@&didrW,`%2Fs+1Y+9P9R1+^V%28x[nXPQP8~"{Pdn^+mOn9K]R1n^VdcVxoDt*~%09@%23@&7did-CMPl9[ZKV%2FaCUP{PmVsZns^%2F,%2Fs+1Yn[:fR^n^V%28x9nX_qYRT+YzYD.k%28EO+vB^G^?wmUB*@%23@&i77dk+^+^Yn[:f%20mKs?alU~{PmGsUwCx:9,_~mN9ZW^%2FaCx@%23@&7diddn^+mDnN:IR9ns+D+;+sVcdVnmDnN:f%20^VV%28U9+a_8b@%23@&7id%29d@%23@&diN@%23@&@%23@&d%29P&&,2x9~0!xmDrGx@%23@&@%23@&70;U1YrW%09~q%09m.nm%2F+]GS%2F2l%09c*P`@%23@&idk6Pvr%2F;E.%2FKD%28U:l4^nZVVvbbPP@%23@&@%23@&d777l.PMGhUwCU:fPx~k+s+1ONPGRT+YzYD.k%28EO+vB.GS?wmUB*@%23@&i77l^V"WA%2F~x,%2FnV^YNPC%28V+%20.Khd@%23@&7idr6Pv%2F+^+1O+9K]RMWA%28%09N+X~_8P"{~CV^IKhdRsn%09oOt*~%09@%23@&@%23@&idd7-mD~l^s;+s^%2F&x16D]WSPxPmVs]Kh%2F]d+^+mDn[K"RMWAqU[6Q%2Fs+1Yn[:fR.GS?2l%09Dcmn^Vk@%23@&idi7%5CmD~l9N]GS?wmUP{Pl^s%2F+^VkqU1naDIGh]d+^+^ONK9%201+sV&U9+aYRT+YzYD.k%28EO+vB.GS?wmUB*@%23@&i77d7lMPhW-n:W~%27,d+^+^ONK9%20MWA?aC%09@%23@&@%23@&iddik6~`el[N"WAjalx*~l9NIKAjwmx,%27~FI@%23@&@%23@&di7dk+sn1Y+[PGR.WSjalU,%27,%2F+^+1O+9K9RMWAjalx,QPmNN"GA?al%09@%23@&d77ilsV"Ghk$dn^+mOn9K]RMGSqU9+XP_,:K-+:WDR9+snD+ZsVv%2F+^n^YN:f%20mns^qUNa%23@%23@&77i8@%23@&7i8@%23@&@%23@&i8~Jz,2x9P6;x1YrW%09@%23@&@%23@&d0!UmDkW%09~9+1Dld+%2FG^%2F2l%09c%23,%09@%23@&@%23@&d7r6Pckk%2F!DdKD&xKm4^nZVs`*%23~`@%23@&di7k6P`kns+1YNPf%20^KVjwmUPe%27~q*P%09@%23@&id7dkn^+^D+9KIck%09d+MY%2F+^VcdV+1O+9Kfc^nV^q%09Nn6Qq*@%23@&di7dk+sn1Y+[PGR^W^jalU,%27,%2F+^+1O+9K9R1Wsjalx,RP8d@%23@&77d%29@%23@&d78@%23@&@%23@&78,&z,2U[,0EU^DkGx@%23@&@%23@&76E%09mYbW%09~fm.+m%2Fn]Kh%2FaCxv%23PP@%23@&dik6Pckd%2F!DdWM%28x:l8sZ+ssv%23bPP@%23@&d7@%23@&iddmV.YvJPW,fGE*@%23@&i78@%23@&@%23@&7NPJz,2UN~W!x^YbGx@%23@&@%23@&i0EU^DkGx,9VnD+"Whv%23,`@%23@&d7k6PcrkZEMdWMqx:C8VZVs`bb,%09@%23@&i7dk+sn1Y+[Pm4s+c[VnD+"Whv%2Fs+1YnN:I%20.Khq%09[+X%23@%23@&778@%23@&i8@%23@&@%23@&i0;x1OkKx~9V+On;Ws`*~P@%23@&,P,PP,P,7k6PckkZ;.kWD&UKm4V%2FnV^`*%23~%09@%23@&id7:K-+wDGhAxN~x,`d+^n1Yn9K"RmV^dR^+UoDtRq*PO,c%2FV+1OnN:fcmnVs%28%09Nn6*@%23@&id7C^VIGAkPxPkn^+^D+9Kl%28V%20DKhd@%23@&d776WD,c%5CmDPbxTib@!mVsIGAkRs+%09LY4irQ3%23P`@%23@&d7din%09N66IKhP{PmsV"WA%2F]kD%201+V^dR^+xTO4P%20P8@%23@&d77iwG%2FbOkKx~x,+x[66IGh,R,:G7+wDWs2%09[@%23@&d7dikW~vwWkrYbWx,@!~!*PP@%23@&d77id2WkrYbWU~{P!@%23@&id7d%29~Jz~Ax9Pq6@%23@&7did@%23@&@%23@&77idl^sZVVk%28UIKh,%27~lss"WA%2F]rTcmns^%2F@%23@&7id7@%23@&7id7b0,`l^V;nV^%2F%28x"WA,aW%2FbOkKxTc^GVUwmx~@*~q*P`@%23@&7did7C^VZns^%2F%28x"GS$2K%2FbYkKxY%20mKVjwmx~x,lV^%2F+^V%2F&U]WS$aWdkOrKxDR1GVUwCU,OPq@%23@&d7diN,+sk+,%09P@%23@&i7didCV^IGAk$kY%20NV+Dn%2F+^VvwG%2FrObWU%23@%23@&did7N@%23@&@%23@&7idNPJ&,2U9PwWDi@%23@&@%23@&,P~P,P~~i8PJ&PAxN,%28W@%23@&@%23@&dNP&&,2UN,oE%09mOrKx@%23@&@%23@&dWE%09^DkG%09P&x%2FDD%2FW^bWYDcb,%09@%23@&~P,PP,~~db0,`r%2F%2F;M%2FGD&UKm4sn;+Vsc*%23~%09@%23@&id7sW7+sMWs3x9PxPv%2FnsmY[K"Rmss%2FcVxLY4R8%23~O,c%2FVn^D+NP9cmnV^%28%09NnX%23@%23@&didmsV"WA%2F,%27~dV+1O+9Kl%28snRMWS%2F@%23@&77i0GD,ck{!Ir@!lVs]KhdR^n%09oO4ib__*PP@%23@&id7DKh%2FG!xY,xPmVV"GA%2F]kYR^+sskRs+%09LY4PR~8@%23@&77iwG%2FbObWU,%27,DWSZK;xDPRPsW-nwDWs3x9@%23@&i77k6PvwG%2FrObWUP@!~!*P`@%23@&dd77aWdkDrKx~{PZ@%23@&idiN@%23@&d7dixnA;+V^~%27,lV^]Ghk$bT%20kUdDOZsVvwGdbYkGU3Fb@%23@&7id7%09+SZ+^Vcrx%09+.C:HJ~{PJLU4kwir@%23@&@%23@&did7kW~v4GD9nDUtGA%09P%27x~rXn%2Frb,%09@%23@&diddixAZVsRMEUOb:+UOX^+R%28G.ND,%27~Jq2XP[WDO+9P:$wAs$or@%23@&di7i8@%23@&did8i@%23@&~P,P~P,P7N@%23@&d%29~zJP2%09[~s!x1YrWU@%23@&@%23@&@%23@&70!x^ObWx~%28%09%2FnDD%2FKV$0KD+v%23,`@%23@&P~P,P~~,dk6~`b%2FZ!.dWMq%09KC4sn;+sVvb%23,%09@%23@&iddhG7+oDKhAx[,%27,`%2FV^YNPIcmns^%2FR^nxTYt%20qbP%20Pv%2FnVn^D+[KG%20mVs%28%09N+ab@%23@&7diC^V]KhkP%27,%2Fs+1YnN:l8sRDKA%2F@%23@&di7WWMPvkx!Ir@!lsV"GhkRsn%09oY4Ib_Q%23,`@%23@&7idiDWSZK;xDPxPmVs]Kh%2F]rTcm+^sdR^+%09oOt~R,F@%23@&i7diwGdbYkGU,%27~DKA;W;%09Y,OPsW7nsMWh2%09N@%23@&iddir0,`wKdrYbW%09P@!PTb,%09@%23@&i7did2GkkYrG%09PxPZ@%23@&d7id%29@%23@&idi7xh%2F+^V~x,lV^]WS%2F$bD%20k%09%2FDOZns^`2WkrYbWUb@%23@&d77ixnh;n^V%20bx%09+D_KtJP{PE[%094d2pJ@%23@&@%23@&iddirWPv4KD[+.j4WAx,x%27,JznkJ%23~`@%23@&7di7ixnSZVVcD!UYb:n?DXsnc4WM[+MP%27,EqwXP9WOYn[,a$s~oAwJ@%23@&idd7N@%23@&7diNi@%23@&,P,PP,P,78@%23@&78@%23@&@%23@&i0E%09^YbWx,rdqslT+j+sn1YnNvbPP@%23@&7ik0~c6WGR9G1EhxDR%2FV^YbWURDX2n,%27%27,EZKxYMGsJ*PP@%23@&d777l.PK%2FW%09Y.G^IlULPxP6GKR[Km!:+%09Ycd+^+^YbWU%201D+mO+"lxTnc%23p@%23@&d7drW,`GZKUYMWs]mxoncZ%23%20YmLglhRDWjaw.Zm%2Fn`*Pxx,Jqt!J*P%09@%23@&7didk+s+^ON%28:mL+,%27~WKWR[G1Eh+%09Oc%2Fn^+1YkKxc^DlO+"lUL`%23vT%23p@%23@&i77dM+DE.x~OMEni@%23@&didN7@%23@&d7N@%23@&78@%23@&@%23@&76E%09mYbW%09~kkZGxDDGsU+V^YN`*~`@%23@&dikWPcWKW%20NK^Es+UOc%2F+sn1YrW%09%20DX2P{%27PrZKUYMWsJ*P`@%23@&ddi-lMPW;GUYMW^ICxLn,%27~0KGR9W^;s+xO%20k+s+1ObWUcmM+lD+"CxT+c%23p@%23@&7idk6~`KZW%09O.W^ImxL+cT*ROlTHls+%20OKjw2nMZC%2Fc*PZ{PrqHVJ*~%09@%23@&7diddn^+mDnN&:lTn~%27,0KW%20NG^!:nxD%20%2FVn^DkWU%201DnlDn"lUT+v%23`Z%23p@%23@&id7dM+O;MxPD.Ei@%23@&77d%29@%23@&d78@%23@&i8@%23@&@%23@&d6EU^DkWU~b%2FPl%28s?n^+1Y+9`*~%09@%23@&7db0~c6WWc[W1E:UORk+^+^YrG%09ROXanP{%27~E;WxO.KVE%23,`@%23@&7id7lD,W;GxDDGV"lULP%27,WWKRNK^;:xDRd+sn1YrW%09%20mM+COIlUL`bi@%23@&id7b0,`W;W%09ODKV]l%09oncZ%23RDCogl:%20OW`wa+.ZCd`bP{xPrK%29$d2Jb~P@%23@&di7i%2Fn^+1Y+9Km8VPxP6WG%209Wm!h+%09YRkns+1YbWUR^.lO+"CxT+cbv!%23I@%23@&d7di.Y;Mx,YD!+p@%23@&id78i@%23@&7i8@%23@&78,zz,3UN,s!x^YrG%09@%23@&@%23@&70!x^ObWx~rkZ;DkGMqU:l%28V+;+^s`*P`@%23@&d7r6P`9Gm!:+%09O%20%2FVmOkGUcYzw~"{PE%2FKxY.G^JbPP@%23@&P~,P,PP,P,~P,P~P,P~~,PP,~P7lD,ns+sP{P[W^;s+UYcd+^+^ObWx%20^M+CY]mxL`*RwmDUYAVn:xOc*@%23@&,~P,PP,~~P,P,P~P~~,P~P,~P,h4r^+Pcn^+hRDCT1Cs+cYW`wanD;ld+v%23~Z{PJ:9J,[[,ns+sRDlL1ChROW`2wD%2FCk+`b~e%27~J:ur%23@%23@&P,PP,P,~P,P~P,P~~,PP,~P,PPP@%23@&P,P,P~P~~,P~P,~P,P~~,PP~~,P~+^nsPx,+^+:cwm.+%09Y3V:nUD@%23@&,~P,PP,~~P,P,P~P~~,P~P,~P,P~r6P`ns:~%27{~%09Es^%23@%23@&P,P,~P,P~P,P~~,PP,~P,PP,~~P,P,4.+CV@%23@&~P,~P,P~~,PP~~,P~P,~,P~,P,8@%23@&di7db0~`Vnh*P%09@%23@&diddidnVmD+[K9~{PnVh@%23@&d77id%2FnsmO+9P"Px,%2FV+1Y[KGR2lM+UOAV+snxD@%23@&i77di%2FVnmOn9K$rGeP{P~dV+^ONPIc2mDn%09YAV+s+%09O@%23@&d7diddn^+mDnN:l4^n~%27,%2FVnmOn9K$rGeRal.n%09Y2sns+UY@%23@&id7idM+Y!D%09~YMEn@%23@&d77i8@%23@&7d%29@%23@&iN~zJPAx[PW;%09mOkKU@%23@&@%23@&76Ex^ObWUPbd;E.kWMqxwWMh`*P`@%23@&d7r6P`9Gm!:+%09O%20%2FVmOkGUcYzw~"{PE%2FKxY.G^JbPP@%23@&P~,P,PP,P,~P,P~P,P~~,PP,~P7lD,ns+sP{P[W^;s+UYcd+^+^ObWx%20^M+CY]mxL`*RwmDUYAVn:xOc*@%23@&,~P,PP,~~P,P,P~P~~,P~P,~P,h4r^+Pcn^+hRDCT1Cs+,"%27,Jw6ItJb@%23@&P~~,PP,~P,PP,~~P,P,P~P~~,P`@%23@&~P,P~~,PP~~,P~P,~,P~,P,PP,P,nV:~%27,+snsRwm.+%09Y2^nh+%09Y@%23@&~P~~,P~P,~P,P~~,PP~~,P~P,~,Pr6Pv+V:,x%27,x;V^%23@%23@&,PP,~P,PP,~~P,P,P~P~~,P~P,~P,P8.l3@%23@&,P~P,~,P~,P,PP,P,~P,P~P,P~N@%23@&di7db0Pvns+s%23,%09@%23@&77id7%2Fs+1Yn[wWDh~{PnVh@%23@&7ididDY!.x,Y.E@%23@&7idd%29@%23@&id8@%23@&78,zJP3x[~6EUmDrW%09@%23@&@%23@&d0;U1YrW%09~b%2F%2F!DkWD&xdr%2FD`bPP@%23@&7ik0,cNKmEsnUYc%2FVnmOrKx%20YH2+,"x~rZWUOMWsJ*~P@%23@&,P,PP,P,~P,P~P,P~~,PP,~P,P%5Cm.~+^+sPxP[G1Eh+%09ORk+sn1YkGUcm.+mOIC%09o`%23cwm.+%09Y3V:nUD`%23@%23@&P,PP,~~P,P,P~P~~,P~P,~P,P~A4kVn~v+s+s%20DlLgls+RDW`2wD%2Flk+cb,"%27,ErdJPL%27~+^+sROlLHm:nRDGjawn.;l%2Fnc*PZ%27,E`SE*@%23@&PP,P,~P,P~P,P~~,PP,~P,PP,~`@%23@&P,P~P~~,P~P,~P,P~~,PP~~,P~P,n^+h,%27,+V:c2lM+UYAVnhxY@%23@&P,PP,~~P,P,P~P~~,P~P,~P,P~~,k0~cVn:,x{PU!V^%23@%23@&P,~P,P~P,P~~,PP,~P,PP,~~P,P,P~4.nm3@%23@&,~P,P~~,PP~~,P~P,~,P~,P,PP%29@%23@&7didr0,`ns:%23,`@%23@&ddi77DY!DUPO.!+@%23@&i7di8@%23@&id8@%23@&i8~zJ~Ax[,0!xmDkKU@%23@&@%23@&dJz~OKoo^nPTEk9nsk%09+k@%23@&dW;%09mOkKUPDWLL^+AG.9+.%2Fvb,%09@%23@&di%5ClMPmsVwW.:kPx~6WWc[W1E:UOR%28W9X%20onOAVn:UYkAzPmo1Ch`Es}]tJbp@%23@&dd7lM~l^V%28xaEOd,%27P6GWcNW1;h+%09Yc4GNz%20T+O2^n:xOd~XKCLglh+vE&1K`Kr%23i@%23@&i7%5CmD~l^VPC%28V+k~%27,0WK%20[W1Es+UY%208KNzRTnYAVnhxYd$HKCogCs+crKzASAJ*I@%23@&d7%5CmD~C^VSbU3kP%27,WGWcNKm;:nUDR8W9zRT+O3^+:nUD%2F$X:CT1Cs+vJbr%23p@%23@&@%23@&7db0~c%28WD9nDUtWSU~%27{PrxGJb@%23@&d7%09@%23@&did8;DYWUm9WAxv[Km;s+%09YRT+D3V:nxDAz%289`JT;k9+VbUn%2Fr%23*@%23@&d7N,+s%2F~%09@%23@&77i4EOOKxmW!OvNG1Es+xDRTnYAVn:xO$HqNvEo!kNsrx%2Fr%23b@%23@&7i8@%23@&@%23@&diz&~GWPWGM:d@%23@&7i0GMPvl%27Zi,CP@!PCV^sG.s%2FR^nxTYtp~C_3%23,%09@%23@&77ikWPv8WMNn.UtWAU,%27xPrUKJb,%09@%23@&didiCV^sGDs%2F,CYRD!UYb:+UOzVR%28W.Nn.,%27~J826,NGOD+N~:wsT!ZTr@%23@&idi8PVknPP@%23@&did7C^VsK.:k$lY%20.E%09Yb:n?Oz^+%20mkdK6O~{PJE@%23@&d7d%29@%23@&d7%29@%23@&@%23@&idJ&PGW~tbN[n%09P0bnV9%2F@%23@&770KD,`8%27TI,4~@!,CV^qU2!Y%2F%20sxLY4I,4Q3%23,%09@%23@&di7k6Pc4KD[nM?tKAx,%27%27,EUWr%23,%09@%23@&77idr0,cl^V%28UaEYd,%28T%20YH2ROKjaw+MZmd+v%23~%27{PEu&ffAHJ*P%09@%23@&7didilsV%28UaEO%2F]8TcD;UDk:njDXs+c8KD[D,%27PrFaaP9ldtN~:Z!!ZT!r@%23@&i77dil^V%28x2;D%2F,4Y%20D!xOrs+?Oz^+%20hb[Dt~{PrF*a6r@%23@&id7dilss&xw!O%2F]4Tc.;xDks+jYzsR4+bLtDPx~rF*2ar@%23@&di7idC^V&xw!Yk,4YR.E%09Yrh?YHs+c4l1VLDKE%09N%2FWsGMPxPr:sGb9%29GJ@%23@&7id7dms^qUaED%2F$%28Tc.E%09Yr:?Oz^+R1GVKDP{~Eawfzf%29fE@%23@&d7diN@%23@&d77%29P+sdP`@%23@&7id7b0,`l^V&Uw!Yd$%28T%20OHw+cOW`ww.%2Flk+v%23~%27x~rC%28fG31r%23@%23@&idd77mVsq%092!Yd]4YRD!xDr:?OX^+%20^k%2FKaY,%27PrE@%23@&idi8@%23@&77%29@%23@&@%23@&7dJz~9KPYC8^+d@%23@&7i0GMPvk%27Zi,rP@!PCV^KC8^+%2Fcs+%09oY4I~k3_*P`@%23@&7id7k6~`%28W.[D?4GSx~%27{~rxGr%23,%09@%23@&di7dilsV:l8s%2F$bDRMExDrh+UYHVnR8GMNnD,xPrF2a,NWOON~a~o~s$wJ@%23@&didiNPVd+,%09@%23@&iddi7l^VKm8s+k$bT%20D;UDkh+UOX^+%20^k%2FKnaDPxPrE@%23@&7idi8@%23@&@%23@&7didCV^IGAkP%27,CV^Kl%28sn%2F]kYR.WAd@%23@&7di70KD~cH%27!I~HP@!Pms^IGS%2FcV+%09oD4i,XQ_*P`@%23@&ddi7PilV^%2FnV^%2F&x]WA~{PCV^]WS%2F,zYRmns^%2F@%23@&i7id7i0KDPv6{Ti,6~@!,lss;+V^dq%09IWS%20s+%09oDtIPaQ3%23~%09@%23@&did77idkW~v4GD9nM?4Kh%09P%27{PrUWr%23~%09@%23@&77iddi7dmVV;nsVkq%09IGh,aYR.E%09Oks+jOHV+%208KD[+M~{PE8wXPNKYDnN,a$s~s$or@%23@&i7diddiN~+^%2FP`@%23@&7id7di7dmVs%2FVVd%28%09IGh]aYR.!xDk:?DzVR^%2FkKnaDP%27,EJ@%23@&di77did%29@%23@&d77id78@%23@&did7N@%23@&d7N@%23@&@%23@&i7Jz~GW,lx1tK.%2F@%23@&7d6W.~vl%27ZIPmP@!,CsVdk%093dRsn%09oOtp~l3_b~P@%23@&77ikWPv8KD[DUtWSx,x%27,JUWr%23~`@%23@&di7db0PvCsVdk%093d$CDct.+6%20YKj22DZCd`bP{x,JE*PP@%23@&idi7dmVsSbxVd]lTc.E%09YksnjYHVR8W.[D~%27,EFa6~[m%2Ftn[,aT!ZTZ!E@%23@&iddidmsVdkU3k$CDcDE%09Oks+?Dzs+chbNOt~x,J+!aaJ@%23@&77iddCs^Srx0d]lDcD!xYb:jYHVnR4+rL4YP{~J8vwXE@%23@&idid7lssdkU3k,lYR.;%09YkhnUYzV%20%28l^0oMWE%09N;GVKD~%27,J:owss;%2FJ@%23@&di77dmV^SrxVd]lDRM;xDkhnUYXsncmGVK.,%27~rawsswZ;Edid7d@%23@&77id8@%23@&did8,ns%2FPP@%23@&d77ilsVdrx0%2F,CYRD;UDkh+UOHVncmk%2FK6D~%27,JEdi@%23@&7id8@%23@&di8@%23@&@%23@&dik6Pc4G.9+.?4Gh%09Pxx,JxGE*P`@%23@&7id8KD9+DUtKAx,%27~JH+dE@%23@&diNPV%2F~`@%23@&did8W.[DjtKAx,%27~E%09WJ@%23@&idN@%23@&@%23@&d7kmMWV^jac%23@%23@&78@%23@&@%23@&JzP~nobxPk2nV^P1tnmV~6EUmDrW%09%2F@%23@&@%23@&zM~SW.N,G%28Ln1Y,YtmY,dYKDn%2F,Y4n,kNB~hKDN,CUN,Y4+~4GG0:CD0~eJ@%23@&-mDPC.M~~D%09Lp@%23@&@%23@&JePSWM[PK4%+1Y~O4lY,dYKD+k~OtPbNSPAGMN~l%09[PDtn~%28WWVhmDVPC&@%23@&W!x1YkKx,GKD[`aWdS,hD9SP%283:MVb%09@%23@&,P~PO4b%2F%20k9~%27,wGdp@%23@&~~,POtbdchGMN,%27PSD9I@%23@&P~P,Y4rkR4KG3slD0~xP%283sDVi@%23@&,P~PD4kkRLnDW.[,%27~oOqW.9i@%23@&P,P,Otb%2F%200b6%09GMNP{~0b6K.[i@%23@&%29@%23@&@%23@&W!x^YbGx,onOqWD[c*%09@%23@&,~,P-mD,D%276WK%20NKm;:xO%20%28WNH%20mM+lDnP+XY"lUonc*i@%23@&,~P,D%20hK%5C+cESW.NrSDtrkRbN%23p@%23@&~P,P.RsW-nAxNvEhKDNrSq%23p@%23@&P~P~r6`.RDn6DRhCDmtc&]-~-%09wMTQfz*%23PMRsG%5C2UNvJ^4mDl1O+MJ~%20qbi,zJPdY.raPGED~l%09X~OMlksr%09o~VbUPW+9%2FPmx9~%2Fal^+k@%23@&~,PPM%20%2FV+1Oc%23p@%23@&P~P~.Y;D%09~YMEnI@%23@&8@%23@&@%23@&WE%09^DkG%09P6k6qWM[`SD[~,x;h*%09@%23@&~P,P%5Cm.~D{0KW%20NG^!:nxD%204KNz%201D+COKn6D]mxL`*i@%23@&P,~PMRhW7+cESWD9E~Dtkk%20rN*i@%23@&~P~~MRhW7n2%09NcESWD[EBFbi@%23@&,P~,k6`DcYaYc:CY1tc&]-P%27U-MT_f&b%23,Dc:G%5Cn3%09NcJ14lMl^ODJSR8%23IPJ&,%2FOMkaPW!Y,CxHPODmksr%09oP^rxP0n[%2F,l%09N~%2F2C1+d@%23@&~P,P.%20D+6O~{PAD9I@%23@&@%23@&P,PP6WMck{Y4kkRr[pk@!m.DcV+%09LOtpk3_bPC.M$rTcrN,%27~CMD$rDck[P3~vx;sP%20PF*i,~P,P&z,E2[mY+,AWMNPaGdkDkKxrxL@%23@&P~P,.+DE.U,YD;np@%23@&8@%23@&@%23@&W!x1YkKx,L+DICxT+cbP@%23@&,~P,%5ClM~dD,%27,x;VsI@%23@&~P,~k6`WGKRNG^!:nxD%20k+smDkW%09RDzwROWdWAnMZlkn`*P%27{~EY6DJb%09@%23@&,P~P,~P,%2F.~{P0GGcNGm!hxOc%2FV+1YbGxcm.+mYn]mxoc%23p@%23@&,~~P%29PVd+~`@%23@&~P,~P,P~dMP%27~WKW%20NK^!:n%09Yc4W9Xc^DlO+:+aO"lxTn`*i@%23@&~~P,8@%23@&~P~~M+OEMUPkDI@%23@&8@%23@&@%23@&0;x1ObWU,oYKD9d`*%09@%23@&,P~~7lD,dD,%27P%09;sVp@%23@&P~P~r6`WWK%20NKm;hxY%20dVnmDrKx%20DXa+RDWdGhD%2Flk+cb,%27%27,EY6Yrb`@%23@&P,P~P~~,%2F.P{~0KW%20[KmEhn%09Y%20%2FsmObW%09RmM+mO+"lUo`bI@%23@&P,~P,PP,d.R6alUNcESW.Nrbi@%23@&~~,PP~~,%2F.Rkn^+^D`*i@%23@&P,~P%29i@%23@&@%23@&~~,P%5Cm.PM%270KG%20NKm!:nxO%20%28W[Xc^DlOn:+6O]mxL+vbp@%23@&,P,PzJPTnY,0rDkY~AKDN@%23@&P,PPM%20hW7+vJAW.[r~T%23p@%23@&,P~~M2x[~{P.RaalU9`rhWMNrbi@%23@&~P,P-CMPhK.NaW%2F{TI@%23@&P,P~%5CC.,k[wKd%27Zi@%23@&,PP~-mD~hK.94sKm0%27Jri@%23@&P,P~%5CmD~CqWD9dP{PxA~bMDmXc%23I@%23@&P~P,&z,VGGaPEUObV~q,.!x~KEDPW6PSGD9%2F@%23@&,P~~Stk^n`M2x9b`@%23@&P,P~P~~,kW`M%20Y6O%20slY^4vz,-,w%09-.Y_fz%23*PM%20:K%5Cn2%09NcE1tlMCmD+DrSRF*i,z&PdOMk2PK;Y,lUz,YDCr^kUo,sbxn,0+NkPmUN,%2F2l1+d@%23@&PP,~P,PPDx.RD+XYIP&&,o.l%28~Y4+~O6Y@%23@&,P~P,~,Pr6`vY"{JcEP-u~Ye%27EZrPu-~Ye%27JQEbPL[,`.2U[e%27TPL%27PDRhCDmtcE]bR}mR.TE*%23*P%09@%23@&,~P,P~P,P~~,k0vc%2FM"%27%09;sV*gkD%20kU]mxL+v.%23=Y.;%23%09@%23@&,P~P,~,P~,P,PP,PM%20mKVsla%2Fnc*i@%23@&~P,PP,~~P,P,P~P~CqW.Nk,k9wGdYP%27~Uh~WqGMNcSWMNwK%2FB~YBP.RT+O$KW3sCD0`%23*I@%23@&,P,P~P~~,P~P,~P,k[2K%2F_QI@%23@&~P,~,P~,P,PP%29@%23@&~P,P~P,PN@%23@&@%23@&,~P,PP,~&e,oMl8PO4PU+XOPSW.[,ez@%23@&,P~P,~,P.c:K%5C+vJSGD9JSF*i@%23@&,PP,~P,PDAU[P{PMRn62C%09NcJSGD9JbI@%23@&P~~,P~P,AKD[aWk__p@%23@&~P,PN@%23@&P~~,D+D;D%09PlqG.Nki@%23@&N@%23@&@%23@&z&PAUN,%2F2n^VP^4mVP6;%09mObW%09%2F@%23@&@%23@&&z,jUNKP&~"+NK~0b6@%23@&-CD,tb%2FOW.z,%27~xAP}4%n1Yi@%23@&@%23@&4kkOKDzcNmYl,%27,,T@%23@&4kkYG.HRwKdkDkW%09~xPZ@%23@&tr%2FOGMX%204KG3sl.V,%27P,D@%23@&4kkOKDzc:m6P{P2T@%23@&@%23@&0!x^ObWx,dl7+CbdOWMXvkUmKGkkOkKU%23,%09@%23@&@%23@&drW,`nNbOtW[r%09P%27{PD.E%23@%23@&i%09@%23@&@%23@&dir0,`tbdOWMXcNCYC,4kdYK.XcNCOmRVnUTY4P%20qYPZ{P6WWcNK^Es+UYcNG^!:+%09O2^+:UORKED+.CP%5Cd%23@%23@&i7%09@%23@&@%23@&iddWGM`rP{~4kdDWMXR9lDCR^+UoDt~R,Fi,rP@*%27P4rdYKDHR2WdrDkGx,QP8i~R%20k%23@%23@&id7%09@%23@&id7itb%2FYKDH%20NmYCRaW2c*i@%23@&7didtbdOWMXc4GWVhmDVRaGwv%23I@%23@&dd7N@%23@&@%23@&@%23@&id74kkYWMXc[lDl,tb%2FOGMXR9CYmRVULY4T,%27~0GGcNGm!h+%09Y%20[KmEhn%09Y3VhxOcW!Y+MC:%5CS@%23@&@%23@&id7r6P`6GWcNW1;h+%09Yc%2FnVn^DkGxcOXa+~Z{PJ%2FG%09Y.W^E*@%23@&idi%09@%23@&di7d4kdYKDz%20%28WW0hlM3$4rdYKDHR8WGVsl.3cs+%09oO4YP%27~WKW%20NK^!:n%09Yc%2F+^+1OkKx%20mM+COIl%09L+v%23RTnOAKW0:CDVc*@%23@&di78,+sdP%09@%23@&id7dK%2FKxOMW^P%27,0KGR9W^Es+UOc%2F+^nmDkW%09%20^DlD+]lUL`b@%23@&7did4rkYW.zc4GW0hmDV]tb%2FYKDH%204KWV:mDV%20^+xTOtYP%27,G%2FW%09YMWs`Tb@%23@&7diN@%23@&@%23@&7idkW~v"rx1KK%2FrDkKx%23@%23@&i7dP@%23@&did74b%2FYK.XcwWkrOkKx3_@%23@&77i8@%23@&i78@%23@&@%23@&id%2F4GSjUNK]NGv%23@%23@&d%29@%23@&N@%23@&@%23@&0!x^ObWx,LW_k%2FDG.Xv%5CmV;+b~P@%23@&@%23@&7dJz~;%09NW@%23@&idr0,c7ls!+,%27%27,O8b@%23@&d7%09@%23@&77ik0,ctb%2FYK.zRaWkkOkGU,%27xP4r%2FDW.zcNlOCcVnxTO4%23@%23@&did%09@%23@&i7di%2FC%5CCrdDWDHcYME+*@%23@&did%29@%23@&d@%23@&id7k6~`4kdOKDX%202K%2FrYbG%09PZ{PZ%23@%23@&di7%09@%23@&7didWGKRNK^Es+xD%20ADbY`4kdOKDzR9CYm$RR4k%2FOGMX%20wKdbYrKxY%23@%23@&di7d6WGR9W^;s+xD%20m^W%2Fcb@%23@&did7%2FnO_kdYK.X;E.dKD`b@%23@&d7d%29@%23@&@%23@&@%23@&idzJPMnNK@%23@&di8~n^%2F+,`@%23@&@%23@&i77k6Pvtr%2FOGMX%20wKdkDkGU,@!P4rkYGDH%209lOmR^+xTY4~O8%23@%23@&id7`@%23@&di7d6WWc[Gm!:xORA.bYn`4r%2FDW.zcNlOC]_QtbdDW.HRaW%2FbYbGxY%23@%23@&id776WWc[W1E:UOR1VK%2Fn`b@%23@&d7did+DCrdDWDz%2F!DdWMc*@%23@&idi8@%23@&diN@%23@&@%23@&di%2F4GSjx9GINWvb@%23@&%29@%23@&@%23@&0;U1YrW%09~%2FYurkYW.z;E.%2FK.v%23~P@%23@&@%23@&iYKLo^+$WMNn.k`%23@%23@&dDWoTsnAKD9+.%2Fcb@%23@&7k%09rYwWGc*i@%23@&@%23@&dr0,c4kdDWMXR%28WKV:mDV$4kdOKDXc2WkkYbGUT*@%23@&d`@%23@&7iD~%27,WWKR[G1E:nUDR8W9zcm.lD+K6D]l%09on`*@%23@&7ik0,ctb%2FYK.zR%28WK3hl.V]tr%2FDGDHR2GkkYrG%09T~"{~r$G%28LmYYJ*@%23@&id`@%23@&d77b0Pv.RsW%5CPGAKW0:CDVc4kdYK.Xc4GG0:l.V]tr%2FDGMX%20aWkkYbW%09D%23*@%23@&did`@%23@&ddi.R1WV^C2%2F`6ls%2Fnb@%23@&@%23@&i7d9WjC7+Px~8@%23@&di7MRdVmYv%23p@%23@&id7NK?C-P%27,T@%23@&ddiN@%23@&id%29@%23@&dN@%23@&8@%23@&J&PAx[~`xNG~JP]+9G,srX@%23@&@%23@&6E%09^YbWUPktGA`xNK]+9W`*~`@%23@&@%23@&dr0~cNrYtGNrU~{%27PO.!+b@%23@&7P@%23@&@%23@&id%5CmD,8EDYGx`x[G}xP{~NKmEsnUYcoY3VnhxOAH%28NvJ;U9W{GUr%23@%23@&i77l.,4!YYKx`UNKrW0,%27~[KmEsnxDRoO3V:xOAz%289`EE%09[W|WWWr%23@%23@&@%23@&d7k6~vtrkYKDXcNmOlcVnxTY4~@!%27P8~u-PtbdOWMXcwG%2FrObWUP@!xPZ%23@%23@&id%09@%23@&id74!ODWU`x9Wr60cdYHVnR9kd2^lX,xPrkx^rU+r@%23@&d7d8;DYGx`UNKrU%20kYXsncNr%2FasmX~{PrxW%09+r@%23@&idNPVdn,%09@%23@&7di4EDOGx`x9W60W%20kYzV%20Nb%2F2smXPx~rxGxE@%23@&7id%28EYDW%09ix9W6xc%2FOz^+R9r%2FaVlH~xPrk%09VrxnE@%23@&7d%29@%23@&@%23@&777lD~8!YOW%09]NG}x,%27P9W1;:xORT+O3^+:UY~Xq9cEDNK{GxEb@%23@&7d7CD,4;ODWx]n9W606~{P[Km!:+%09YcL+D2s+s+UO~Xq9cJM+NKmG06J*@%23@&d7@%23@&d7k6~`4kdOKDX%202K%2FrYbG%09P@*{P4k%2FDWMzR9lOlcVnUTYt%20qP-uP4rdYKDHR[lOCcVnxTOt,%27x~Z%23@%23@&7i%09@%23@&i7i4;DYKxINK606RdYHVn%209k%2FaslHP%27,Erx^k%09+E@%23@&7id8EDOW%09In[Krx%20dDXs+c[b%2F2^lHP%27,J%09GxJ@%23@&idN~V%2F~%09@%23@&di78EDYKx]+[G}0WRkOX^+%20[b%2FwsCHPxPrUKxnr@%23@&ddi4!OYKx]+9W6Uc%2FYHs+cNkk2slHP{PEkUsbxnJ@%23@&di8@%23@&i@%23@&7N,+s%2F~P@%23@&@%23@&id%5CmD,8EDYGx`x[Gyrx,xP9Wm!hnxDRT+O2sns+UY~zq9`E;%09NW+mKxE%23@%23@&id-mD,4EDYKUj%09NG%20}0W~{PNK^Es+xD%20L+D2^+h+UO~X%28NvEE%09NG+|W0WE*@%23@&@%23@&7ikW,`e0WKR9Gm!:nxDR5;DX;G:slx93Ul%28VNcJ;U9WE%23*@%23@&id`@%23@&dd78!YOW%09i%09NGyr60RkYHs+cNr%2FaVCz,%27Prrx^kxE@%23@&idi4;YOG%09jUNK+r%09RdOHV+%20[b%2F2Vmz,%27~rxKx+r@%23@&7d%29PnVk+~`@%23@&di74!YYKUix9WyrW0%20dDXs+c[kkwsCHP%27~E%09WU+r@%23@&d7i4!YYKx`UNK%206xc%2FOz^+R9r%2FaVlH~xPrk%09VrxnE@%23@&7d%29@%23@&@%23@&777lD~8!YOW%09]NGyr%09P%27,NK^Es+UYconOAV+snxDAX&[cJM+9W+{GUr%23@%23@&i7%5CmD~8!YYGU"+[Wy660~{P9Wm!:UYconYAVnhxY~zq9`JMn[Wy{K0WJb@%23@&@%23@&dir0,`ZWKWR[G1Eh+%09Oc;;DHZWs:mUNAxC4^+[crD+9GJ*%23@%23@&77%09@%23@&id74;ODWUI[WyrWWc%2FYzsR[kk2^lz,%27,Jk%09VbU+r@%23@&did8;DYW%09]+9W%20}U%20%2FDX^+%20NrdaVCX,xPrxGUJ@%23@&7i8~+^dP`@%23@&idd%28EDOW%09InNK%206W6R%2FDzVRNbd2VmX,%27~JUG%09+E@%23@&7di4;ODWx]n9W+r%09%20kYz^+cNkkw^CX,%27~Jbxsr%09+J@%23@&di8@%23@&7N@%23@&8@%23@&@%23@&&&,ZGVK.k.+~%2FKN+~r%09PjW!.1+~tW9+@%23@&0!UmDkGx,mGsKED;GN`mK[n%23,%09@%23@&@%23@&74D:sKmLP{P&cLVYIc]-d-UDCgbLoDi%23Job@%23@&iYC4^+PCTP%27,&`LVYpcOl%28VuO4G[HuOt-OD-Y[k%27zYC8^+k-JO%28W[Hu%27zY4u%27&YMuwzDNbc]-%2F%27jTCg%23LLOi*zTk@%23@&7^K:h+%09OKmo~x,z`%27sDiZO%20c]-d%27?Yeg*[TOi*zLk@%23@&7rsloPlTP%27,&c[^Ypkhoc,%27%2Fw?YMg*[LOp%23zLr@%23@&7VbU0KCTP{Pzv[^Oivlk-Jlbc]-%2F%27jTCg%23LLOi*zTk@%23@&7d1DrwDPlTPx~J`[sOp`dmMraYk%27zkmDbwDb`]-d-UTM_*[oDI%23Jok@%23@&@%23@&imKNnPx~1W[+c.+aVC^`tOh^KCoBE@!0G%09Y,mW^WMxaZ!T!R!@*y8@!z6GxD@*J*@%23@&d1W9+~%27~^KNnRMnw^l^nvYl8sKCoBE@!0G%09Y,mW^WMxaZ!0!R!@*y8@!z6GxD@*J*@%23@&d1W9+~%27~^KNnRMnw^l^nvmWhhxOKmLBJ@!6W%09YP1W^GD{a0!R!0T@*^F@!&0KxY@*Eb@%23@&d1W[+~x,mGN%20DwsC1+`rhmonKmLBJ@!6W%09YP1W^GD{a0!Z!0T@*^F@!&0KxY@*Eb@%23@&d1W[+~x,mGN%20DwsC1+`sr%093PlTSr@!WKxDPmKVK.%27[!T%Z!T@*fF@!JWW%09Y@*rb@%23@&imKNnPx~1W[+c.+aVC^`%2F^.bwOKmLBJ@!6W%09YP1W^GD{a0!Z!TT@*^F@!&0KxY@*Eb@%23@&@%23@&d.+O;Mx~mK[+p@%23@&N@%23@&z&~Ax[P1G^W.by@%23@&@%23@&7CD,0;V^%2F^.+xtGNP%27,WCVk+@%23@&WEU^DkGx,OWTosnUkync*P`@%23@&@%23@&dr6Pv"0!V^dmM+nxtW[n*@%23@&i`@%23@&ddaC.+%09YcNGm;hxORTnYAVnhxY$z&NcmKUDDG^1m:+*RM;xDkh+UYzsRwKdkDkW%09~xPrb%28%2FGV;OJ@%23@&i7wmDnUDRNG^!:nxD%20T+OAV:+%09Y~zq9`^W%09Y.G^1lsn%23cDE%09Or:?DXs+%20"&x[+X~%27,J11OJ@%23@&7iwCDUDR[Km!:+%09YcL+D2s+s+UO~Xq9cmKxYMGs1m:%23%20D;UDkh+UOX^+%202K%2FKG2,%27~FZ@%23@&d7alM+xDR9Gm!:nxDRLnD2Vh+%09YAH%28[`1W%09Y.WsHm:n%23c.E%09Yrh?YzsR2WkJ0O,%27,F!@%23@&i7wmDnxDR[G1E:UYco+D3s+s+%09Y$X%28[vmGxD.W^1Ch%23R.;%09Yr:jDXsRSkNDt,xPal.+%09Y%20[KmEsnxDR4K[zR1Vb+UY%09r9Y4P%20~Fl@%23@&7iwl.n%09Y%20NK^!:n%09Yco+D2^n:xOAHq[c1WxD.W^1lsnbRME%09Yr:njDXs+c4+bo4O,%27P2CM+UYc[Km;s+%09YR%28W9zRK0W%2FYunbotD~O,&!@%23@&7dalM+UY%20[Km;:UYconOAV+hn%09Y$X&[vmG%09YMWVglsn%23c0Gm!%2Fcb@%23@&di8EDYW%09m[WSxvNGm;hxORTnYAVnhxY$z&NcJ6;^Vd1D+xr%23*@%23@&id8EDYGU|NWSU`9Wm!hnxDRT+O2sns+UY~zq9`EW!VVd^M+nxyE*%23@%23@&di0E^Vk^D+UHKNn~{PYM;+@%23@&d%29~nVk+,%09@%23@&77al.+%09OR9W^;s+xO%20T+O2^ns+UDAHqNvmKUYMWs1m:nbcDE%09Oks+?Dzs+cmk%2FP+aO,%27~Jr@%23@&id2CM+xO%209W^Esn%09Y%20T+D2V:UY~X%28NvmGUDDW^Hls+%23cWGm!%2Fv%23@%23@&77%28EOYKU{KEOc9Wm;hxORTnD2s:xY~X&[`r0;V^%2F^.+xrb%23@%23@&di8;YDW%09{GEOc9W^EsnxDRLnD2VnhxOAH%289`E6E^V%2F1DnxyJb%23@%23@&776EV^dmM++%09%5CGNP{PWlsd@%23@&d%29@%23@&%29iY8iAA==^%23~@%3C%2F%73%63%72%69%70%74%3E');
					</script>

        				<table id="fooContainer" width="100%" height="100%" border="1" cellspacing="0" cellpadding="0">
        					<tr>
        						<td height=1>
        							<?php include($EWP_PATH . "ew_includes/toolbar.php"); ?>
        							</td></tr>
        							<tr><td>
        							<table class=iframe height=100% width=100%>
        								<tr height=100%>
        									<td>
        										<iFrame onBlur="updateValue()" SECURITY="restricted" contenteditable HEIGHT=100% id="foo" style="width:100%;" src=''></iFrame>
        										<iframe onBlur="updateValue()" id=previewFrame height=100% style="width=100%; display:none"></iframe>
        										<input type="hidden" name="ew_control_html" value="">
        									</td>
        								</tr>
        							</table>
        							</td></tr>
        							<tr><td height=1>
        							<table cellpadding=0 cellspacing=0 width=100% style="background-color: threedface" class=status>
        								<tr>
        									<td background=ew/ew_images/status_border.gif height=22><img style="cursor:hand;" id=editTab src=ew/ew_images/status_edit_up.gif width=98 height=22 border=0 onClick=editMe()><img style="cursor:hand; <?php if($this->__disableSourceMode == true) {?>display:none<?php } ?>" id=sourceTab src=ew/ew_images/status_source.gif width=98 height=22 border=0 onClick=sourceMe()><img style="cursor:hand; <?php if($this->__disablePreviewMode == true) {?>display:none<?php } ?>" id=previewTab src=ew/ew_images/status_preview.gif width=98 height=22 border=0 onClick=previewMe()><td background=ew/ew_images/status_border.gif id=statusbar align=right valign=bottom><img src=ew/ew_images/button_zoom.gif width=42 height=17 valign=bottom onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" class=toolbutton onClick="showMenu('zoomMenu',65,178)"></td>
        								</tr>
        							</table>
        						</td>
        					</tr>
        				</table>
        
        				<script language="JavaScript">
        							
        					var fooWidth = "<?php echo $this->__controlWidth; ?>";
        					var fooHeight = "<?php echo $this->__controlHeight; ?>";
        
        					function setValue()
        					{
        						foo.document.write('<?php echo eregi_replace("</script>", "<\\/script>", $this->__initialValue); ?>');
        						foo.document.close()
        					}
        
        					function updateValue()
        					{
									if (document.activeElement) {
										if (document.activeElement.parentElement.id == "ew") {
											return false;
										} else {
											if (parent.document.all.<?php echo $this->__controlName; ?>_html != null) {
												parent.document.all.<?php echo $this->__controlName; ?>_html.value = SaveHTMLPage();
											}
										}
									}
        					}
        							
        				</script>

					<?php

					// End the iFrame source text area buffer
					?>
						</textarea>

						<iframe id="<?php echo $this->__controlName; ?>_frame" width="<?php echo $this->__controlWidth; ?>" height="<?php echo $this->__controlHeight; ?>" frameborder=0 scrolling=auto style="position:relative"></iframe>

						<script language="JavaScript">
							<?php echo $this->__controlName; ?>_frame.document.write(document.getElementById("<?php echo $this->__controlName; ?>_src").value)
							<?php echo $this->__controlName; ?>_frame.document.close()
							<?php echo $this->__controlName; ?>_frame.document.body.style.margin = "0px";
						</script>
						
						<input type="hidden" name="<?php echo $this->__controlName; ?>_html">
					<?php
			}
		}
	}
?>