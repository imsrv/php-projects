<%
  '///////////////////////////////////////////////////////////////////////
  '//                                                                   //
  '//  Program Name    : EditWorks Professional                         //
  '//  Release Version : 2.0                                            //
  '//  Program Author  : SiteCubed Pty. Ltd.                            //
  '//  Supplied by     : CyKuH [WTN]                                    //
  '//  Packaged by     : WTN Team                                       //
  '//  Distribution    : via WebForum, ForumRU and associated file dumps//
  '//                                                                   //
  '//                      WTN Team `2000 - `2002                       //
  '///////////////////////////////////////////////////////////////////////
  ' English Language File for EditWorks

' Gobal
Const sTxtOk = "OK"
Const sTxtCancel = "Cancel"
Const sTxtCloseWin = "Click the &quot;Cancel&quot; Button to close this window."
Const sTxtReturn = "Click 'Cancel' to return to the previous screen."
Const sTxtName = "Name"
Const sTxtBorder = "Border"
Const sTxtBgColor = "Background Color"
Const sTxtAction = "Action"
Const sTxtRename = "Rename"
Const sTxtBytes = "Bytes"
Const sTxtFile = "File"

' Image
Const sTxtInsertImage = "Insert Image"
Const sTxtInsertImageInst = "Choose an image from those shown below and click on its insert link to add it to your content."
Const sTxtUploadImage = "Upload Image"
Const sTxtImageName = "File Name"
Const sTxtFileSize = "File Size"
Const sTxtImageView = "View"
Const sTxtImageInsert = "Insert"
Const sTxtImageDel = "Delete"
Const sTxtImageBackgd = "Backgd"
Const sTxtImageErr = "The file you uploaded was not a valid image"
Const sTxtImageSuccess = "uploaded successfully"
Const sTxtImageDelete = "Are you sure you wish to delete"
Const sTxtImageSetBackgd = "Are you sure you wish to set this image as the page background image"

' Link Manager
Const sTxtLinkManager = "Link Manager"
Const sTxtLinkManagerInst = "Enter the required information and click &quot;Insert Link&quot; to insert a link into your webpage."
Const sTxtLinkManagerInst2 = "Alternatively, locate  the file from the file manager below and select &quot;Get Link Location&quot;. Click &quot;Insert Link&quot; to insert the link."
Const sTxtLinkErr = "URL cannot be left blank"
Const sTxtLinkInfo = "Link Information"
Const sTxtUrl = "URL"
Const sTxtTargetWin = "Target Window"
Const sTxtAnch = "Anchor"
Const sTxtGetLinkInfo = "Get link information to"
Const sTxtGetLink = "Get Link Location"
Const sTxtInsertLink = "Insert Link"
Const sTxtRemoveLink = "Remove Link"

' Anchor Global
Const sTxtInsertAnchorErr = "Anchor name cannot be left blank"
Const sTxtInsertAnchorName = "Anchor Name"

' Anchor
Const sTxtInsertAnchor = "Insert Anchor"
Const sTxtInsertAnchorInst = "Enter the required information and click &quot;Insert Anchor&quot; to insert an anchor in your webpage."

' Modify Anchor
Const sTxtModifyAnchor = "Modify Anchor"
Const sTxtModifyAnchorInst = "Enter the required information and click &quot;Modify Anchor&quot; to modify the current Anchor."

' Insert Button
Const sTxtInsertButton = "Insert Button"
Const sTxtInsertButtonInst = "Enter the required information and click &quot;Insert Button&quot; to insert a Button into your webpage."

' Modify Button
Const sTxtModifyButton = "Modify Button"
Const sTxtModifyButtonInst = "Enter the required information and click &quot;Modify Button&quot; to modify the current Button."

' Insert Special Character
Const sTxtInsertChar = "Insert Special Character"
Const sTxtInsertCharInst = "Select the character you require  and click &quot;Insert Character&quot; to insert a special character into your webpage."
Const sTxtChar = "Character"
Const sTxtCharToInsert = "Character to Insert"

' Insert Checkbox
Const sTxtInsertCheckbox = "Insert CheckBox"
Const sTxtInsertCheckboxInst = "Enter the required information and click &quot;Insert CheckBox&quot; to insert a CheckBox into your webpage."

' Modify Checkbox
Const sTxtModifyCheckbox = "Modify CheckBox"
Const sTxtModifyCheckboxInst = "Enter the required information and click &quot;Modify CheckBox&quot; to modify the selected CheckBox."

' Insert Email Link
Const sTxtEmailErr = "Email address cannot be left blank"
Const sTxtInsertEmail = "Insert Email Link"
Const sTxtInsertEmailInst = "Enter the required information and click &quot;Insert Link&quot; to create a link to email address into your webpage."
Const sTxtEmailAddress = "Email Address"
Const sTxtSubject = "Subject"
Const sTxtInsertEmailLink = "Insert Email Link"

' Insert Hidden Field
Const sTxtInsertHidden = "Insert Hidden Field"
Const sTxtInsertHiddenInst = "Enter the required information and click &quot;Insert Hidden Field&quot; to insert a Hidden Field into your webpage."

' Modify Hidden Field
Const sTxtModifyField = "Modify Hidden Field"
Const sTxtModifyFieldInst = "Enter the required information and click &quot;Modify Hidden Field&quot; to modify  the selected Hidden Field."

' Insert Radio Button
Const sTxtInsertRadio = "Insert Radio Button"
Const sTxtInsertRadioInst = "Enter the required information and click &quot;Insert Radio Button&quot; to insert a Radio Button  into your webpage."

' Modify Radio Button
Const sTxtModifyRadio = "Modify Radio Button"
Const sTxtModifyRadioInst = "Enter the required information and click &quot;Modify Radio Button&quot; to modify the selected Radio Button."

' Table Global
Const sTxtTableRowErr = "Rows must contain a valid, positive number"
Const sTxtTableColErr = "Columns must contain a valid, positive number"
Const sTxtTableWidthErr = "Width must contain a valid, positive number"
Const sTxtTablePaddingErr = "Cell Padding must contain a valid, positive number"
Const sTxtTableSpacingErr = "Cell Spacing must contain a valid, positive number"
Const sTxtTableBorderErr = "Border must contain a valid, positive number"

Const sTxtRows = "Rows"
Const sTxtPadding = "Cell Padding"
Const sTxtSpacing = "Cell Spacing"
Const sTxtWidth = "Width"
Const sTxtCols = "Columns"

' Insert Table
Const sTxtInsertTable = "Insert Table"
Const sTxtInsertTableInst = "Enter the required information and click &quot;Insert Table&quot; to insert a table into your webpage."

' Modify Table
Const sTxtModifyTable = "Modify Table Properties"
Const sTxtModifyTableInst = "Enter the required information and click &quot;Modify Table&quot; to modify the table properties of your table."

' Modify Cell
Const sTxtCellWidthErr = "Cell Width must contain a valid, positive number"
Const sTxtModifyCell = "Modify Cell Properties"
Const sTxtModifyCellInst = "Enter the required information and click &quot;Modify Cell&quot; to modify the cell properties of your table cell."
Const sTxtCellWidth = "Cell Width"
Const sTxtHorizontalAlign = "Horizontal Align"
Const sTxtVerticalAlign = "Vertical Align"

' Form Global
Const sTxtCharWidthErr = "Character Width must contain a valid, positive number"
Const sTxtLinesErr = "Lines must contain a valid, positive number"
Const sTxtMaxCharsErr = "Maximum Characters must contain a valid, positive number"

Const sTxtInitialValue = "Initial Value"
Const sTxtInitialState = "Initial State"
Const sTxtCharWidth = "Character Width"
Const sTxtLines = "Lines"
Const sTxtType = "Type"
Const sTxtMaxChars = "Maximum Characters"

Const sTxtMethod = "Method"

' Insert Form
Const sTxtInsertForm = "Insert Form"
Const sTxtInsertFormInst = "Enter the required information and click &quot;Insert Form&quot; to insert a form into your webpage."

' Modify Form
Const sTxtModifyForm = "Modify Form Properties"
Const sTxtModifyFormInst = "Enter the required information and click &quot;Modify Form&quot; to modify the form properties of your form."

' Insert TextArea
Const sTxtInsertTextArea = "Insert Text Area"
Const sTxtInsertTextAreaInst = "Enter the required information and click &quot;Insert Text Area&quot; to insert a Text Area into your webpage."

' Modify TextArea
Const sTxtModifyTextArea = "Modify Text Area"
Const sTxtModifyTextAreaInst = "Enter the required information and click &quot;modify Text Area&quot; to modify the selected Text Area."

' Insert TextField
Const sTxtInsertTextField = "Insert Text Field"
Const sTxtInsertTextFieldInst = "Enter the required information and click &quot;Insert Text Field&quot; to insert a Text Field into your webpage."

' Modify TextField
Const sTxtModifyTextField = "Modify Text Field"
Const sTxtModifyTextFieldInst = "Enter the required information and click &quot;Modify Text Field&quot; to modify the selected Text Field."

' JSCommon
Const sTxtSetBackgd = "Are you sure you wish to set this image as the page background image?"

' JSFunctions
Const sTxtGuidelines = "Guidelines"
Const sTxtOn = "ON"
Const sTxtOff = "OFF"
Const sTxtClean = "Are you sure you want to clean HTML code?"

' Modify Image
Const sTxtImageWidthErr = "Image Width must contain a valid, positive number"
Const sTxtImageHeightErr = "Image Height must contain a valid, positive number"
Const sTxtImageBorderErr = "Image Border must contain a valid, positive number"
Const sTxtHorizontalSpacingErr = "Horizontal Spacing must contain a valid, positive number"
Const sTxtVerticalSpacingErr = "Vertical Spacing must contain a valid, positive number"

Const sTxtModifyImage = "Modify Image Properties"
Const sTxtModifyImageInst = "Enter the required information and click &quot;Modify Image&quot; to modify the properties of the selected Image."
Const sTxtAltText = "Alternate Text"
Const sTxtImageWidth = "Image Width"
Const sTxtImageHeight = "Image Height"
Const sTxtAlignment = "Alignment"
Const sTxtHorizontalSpacing = "Horizontal Spacing"
Const sTxtVerticalSpacing = "Vertical Spacing"

' Page Properties
Const sTxtPageProps = "Modify Page Properties"
Const sTxtPagePropsInst = "Enter the required information and click &quot;Modify Page&quot; to modify the  properties of your page."

Const sTxtPageTitle = "Page Title"
Const sTxtDescription = "Description"
Const sTxtKeywords = "Keywords"
Const sTxtBgImage = "Background Image"
Const sTxtTextColor = "Text Color"
Const sTxtLinkColor = "Link Color"

' Toolbar
Const sTxtCut = "Cut"
Const sTxtCopy = "Copy"
Const sTxtPaste = "Paste"
Const sTxtUndo = "Undo"
Const sTxtRedo = "Redo"
Const sTxtBold = "Bold"
Const sTxtUnderline = "Underline"
Const sTxtItalic = "Italic"
Const sTxtNumList = "Insert Numbered List"
Const sTxtBulletList = "Insert Bullet List"
Const sTxtDecreaseIndent = "Decrease Indent"
Const sTxtIncreaseIndent = "Increase Indent"
Const sTxtAlignLeft = "Align Left"
Const sTxtAlignCenter = "Align Center"
Const sTxtAlignRight = "Align Right"
Const sTxtAlignJustify = "Justify"
Const sTxtInsertHR = "Insert Horizontal Line"
Const sTxtHyperLink = "Create or Modify Link"
Const sTxtAnchor = "Insert / Modify Anchor"
Const sTxtEmail = "Create Email Link"
Const sTxtFormFunctions = "Form Functions"
Const sTxtForm = "Insert Form"
Const sTxtFormModify = "Modify Form Properties"
Const sTxtTextField = "Insert / Modify Text field"
Const sTxtTextArea = "Insert / Modify Text Area"
Const sTxtHidden = "Insert / Modify Hidden Field"
Const sTxtButton = "Insert / Modify Button"
Const sTxtCheckbox = "Insert / Modify Checkbox"
Const sTxtRadioButton = "Insert / Modify Radio Button"
Const sTxtFont = "Font"
Const sTxtSize = "Size"
Const sTxtColor = "Color"
Const sTxtFormat = "Format"
Const sTxtStyle = "Style"
Const sTxtColour = "Font Color"
Const sTxtBackColour = "Highlight"
Const sTxtTableFunctions = "Table Functions"
Const sTxtTable = "Insert Table"
Const sTxtTableModify = "Modify Table Properties"
Const sTxtCellModify = "Modify Cell Properties"
Const sTxtInsertRowA = "Insert Row Above"
Const sTxtInsertRowB = "Insert Row Below"
Const sTxtDeleteRow = "Delete Row"
Const sTxtInsertColA = "Insert Column to the Right"
Const sTxtInsertColB = "Insert Column to the Left"
Const sTxtDeleteCol = "Delete Column"
Const sTxtIncreaseColSpan = "Increase Column Span"
Const sTxtDecreaseColSpan = "Decrease Column Span"
Const sTxtImage = "Insert / Modify Image"
Const sTxtChars = "Insert Special Characters"
Const sTxtPageProperties = "Modify Page Properties"
Const sTxtCleanCode = "Clean HTML Code"
Const sTxtToggleGuidelines = "Show / Hide Guidelines"
Const sTxtTogglePosition = "Toggle Absolute Positioning"

' Help
Const sTxtHelpTitle = "&nbsp;The WYSIWYG Editor and commands"
Const sTxtHelp = "Help"
Const sTxtHelpNote = "Note: If an option below is not visible or accessible in your editor, then your administrator may have disabled it."
Const sTxtHelpCloseWin = "Close Window"
Const sTxtHelpCutTitle = "Cut (Ctrl+X)"
Const sTxtHelpCut = "To cut a portion of the document, highlight the desired portion and click the 'Cut' icon (keyboard shortcut - CTRL+X)."
Const sTxtHelpCopyTitle = "Copy (Ctrl+C)"
Const sTxtHelpCopy = "To copy a portion of the document, highlight the desired portion and click the 'Copy' icon (keyboard shortcut - CTRL+C)."
Const sTxtHelpPasteTitle = "Paste (Ctrl+V)"
Const sTxtHelpPaste = "To paste a portion that has already been cut (or copied), click where you want to place the desired portion on the page and click the 'Paste' icon (keyboard shortcut - CTRL+V)."
Const sTxtHelpUndoTitle = "Undo (Ctrl+Z)"
Const sTxtHelpUndo = "To undo the last change, click the 'Undo' icon (keyboard shortcut - CTRL+Z). Each consecutive click will undo the previous change to the document."
Const sTxtHelpRedoTitle = "Redo (Ctrl+Y))"
Const sTxtHelpRedo = "To redo the last change, click the 'Redo' icon (keyboard shortcut - CTRL+Y). Each consecutive click will repeat the last change to the document."
Const sTxtHelpBoldTitle = "Bold (Ctrl+B)"
Const sTxtHelpBold = "To bold text, select the desired portion of text and click the 'Bold' icon (keyboard shortcut - CTRL+B). Each consecutive click will toggle this function on and off."
Const sTxtHelpUnderlineTitle = "Underline (Ctrl+U)"
Const sTxtHelpUnderline = "To underline text, select the desired portion of text and click the 'Underline' icon (keyboard shortcut - CTRL+U). Each consecutive click will toggle this function on and off."
Const sTxtHelpItalicTitle = "Italic (Ctrl+I)"
Const sTxtHelpItalic = "To convert text to italic, select the desired portion of text and click the 'Italic' icon (keyboard shortcut - CTRL+I). Each consecutive click will toggle this function on and off."
Const sTxtHelpINListTitle = "Insert Number List"
Const sTxtHelpINList = "To start a numbered text list, click the 'Insert Numbered List' icon. If text has already been selected, the selection will be converted to a numbered list. Each consecutive click will toggle this function on and off."
Const sTxtHelpIBListTitle = "Insert Bullet List"
Const sTxtHelpIBList = "To start a bullet text list, click the 'Insert Bullet List' icon. If text has already been selected, the selection will be converted to a bullet list. Each consecutive click will toggle this function on and off."
Const sTxtHelpDIndentTitle = "Decrease Indent"
Const sTxtHelpDIndent = "To decrease indent of a paragraph, click the 'Decrease Indent' icon. Each consecutive click will move text further to the left."
Const sTxtHelpIIndentTitle = "Increase Indent"
Const sTxtHelpIIndent = "To increase indent of a paragraph, click the 'Increase Indent' icon. Each consecutive click will move text further to the right."
Const sTxtHelpALeftTitle = "Align Left"
Const sTxtHelpALeft = "To align to the left, make a selection in the document and click the 'Align Left' icon."
Const sTxtHelpACenterTitle = "Align Center"
Const sTxtHelpACenter = "To align to the center, make a selection in the document and click the 'Align Center' icon."
Const sTxtHelpARightTitle = "Align Right"
Const sTxtHelpARight = "To align to the right, make a selection in the document and click the 'Align Right' icon."
Const sTxtHelpJustifyTitle = "Justify"
Const sTxtHelpJustify = " To justify a paragraph or text, make a selection in the document and click the 'Justify' icon. "
Const sTxtHelpIHLineTitle = "Insert Horizontal Line"
Const sTxtHelpIHLine = "To insert a horizontal line, select the location to insert the line and click the 'Insert Horizontal Line' icon."
Const sTxtHelpCMHyperLinkTitle = "Create or Modify Link"
Const sTxtHelpCMHyperLink = "To create a hyperlink, select the text or image to create the link on, then click the 'Create or Modify Link' icon. ('Link Information') will contain existing link information, if the object you selected already had a link. You can also type the full URL of the page you want to link to in the URL text box. You can also enter the target window information (optional) and an anchor name (if linking to an anchor - optional).<br><br>When finished, click the 'Insert Link' button to insert the HyperLink you just created, or click 'Remove Link' to remove an existing link. Clicking 'Cancel' will close the window and take you back to the editor.<br><br>To modify an existing hyperlink, select the link and click on the 'Create or Modify Link' icon. The HyperLink window will appear. Make your changes and select the 'Insert Link' button. Select the remove link to remove an existing link."
Const sTxtHelpIMAnchorTitle = "Insert / Modify Anchor"
Const sTxtHelpIMAnchor = "To insert an anchor, select a desired spot on the web page you are editing and click the 'Insert / Modify Anchor' icon. In the dialogue box, type the name for the anchor.<br><br>When finished, click the 'Insert Anchor' button to insert the anchor, or 'Cancel' to close the box.<br><br>To modify an anchor select the Anchor (displayed as small yellow box when Guidelines are switched on) and click the 'Insert / Modify Anchor' icon. Make your changes and hit the 'Modify Anchor' button or click 'Cancel' to close the window."
Const sTxtHelpCELinkTitle = "Create Email Link"
Const sTxtHelpCELink = "To create an email link, select text or an image on the web page you are editing where you would like the link to appear. Click the 'Create Email Link' icon. In the dialogue box, type the email address for the link and the subject of the email.<br><br>When finished, click the 'Insert Link' button to insert the email link, or 'Cancel' to close the box."
Const sTxtHelpFontTitle = "Font"
Const sTxtHelpFont = "To change the font of text, select the desired portion of text and click the 'Font' drop-down menu.<br><br>Select the desired font (choose from Default - Times New Roman, Arial, Verdana, Tahoma, Courier New or Georgia)."
Const sTxtHelpFSizeTitle = "Font Size"
Const sTxtHelpFSize = "To change the size of text, select the desired portion of text and click the 'Size' drop-down menu.<br><br>Select the desired size (text size 1-7)."
Const sTxtHelpFormatTitle = "Format"
Const sTxtHelpFormat = "To change the format of text, select the desired portion of text and click the 'Format' drop-down menu.<br><br>Select the desired format (choose from Normal, Superscript, Subscript and H1-H6)."
Const sTxtHelpStyleTitle = "Style"
Const sTxtHelpStyle = "To change the style of text, images, form objects, tables, table cells etc select the desired element and click the 'Style' drop-down menu, which will display all styles defined in the style-sheet.<br><br>Select the desired style from the menu.<br><br>Note: this function will not work if there is no style-sheet applied to the page."
Const sTxtHelpFColorTitle = "Font Color"
Const sTxtHelpFColor = "To change the colour of text, select the desired portion of text and click the 'Colour' drop-down menu.<br><br>Select the desired colour from the large selection in the drop-down menu."
Const sTxtHelpHColorTitle = "Highlight Color"
Const sTxtHelpHColor = "To change the highlighted colour of text, select the desired portion of text and click the 'Highlight' drop-down menu.<br><br>Select the desired colour from the large selection in the drop-down menu."
Const sTxtHelpTFunctionsTitle = "Table Functions"
Const sTxtHelpTFunctions = "To insert or modify a table or cell, select the 'Table Functions' icon to display a list of available Table Functions.<br><br>If a Table Function is NOT available, you will need to select, or place your cursor inside the table you wish to modify."
Const sTxtHelpITableTitle = "Insert Table"
Const sTxtHelpITable = "To insert a table, select the desired location, then click the 'Insert Table' icon.<br><br>A new window will pop-up with the following fields: Rows - number of rows in table; Columns - number of columns in table; Width - width of table; BgColour - background colour of table; Cell Padding - padding around cells; Cell Spacing - spacing between cells and Border - border around cells.<br><br>Fill in table details then click the 'Insert Table' button to insert table, or click 'Cancel' to go back to the editor."
Const sTxtHelpMTPropertiesTitle = "Modify Table Properties"
Const sTxtHelpMTProperties = "To modify table properties, select a table or click anywhere inside the table to modify, then click the 'Modify Table Properties' icon.<br><br>A pop-up window will appear with the table's properties. Click the 'Modify Table Properties' button to save your changes, or click 'Cancel' to go back to the editor.<br><br>Note: this function will not work if a table has not been selected."
Const sTxtHelpMCPropertiesTitle = "Modify Cell Properties"
Const sTxtHelpMCProperties = "To modify cell properties, click inside the cell to modify, then click the 'Modify Cell Properties' icon.<br><br>A pop-up window will appear with the cells' properties.<br><br>Click the 'Modify Form Properties' button to save your changes, or click 'Cancel' to go back to the editor.<br><br>Note: this function will not work if a cell has not been selected and does not work across multiple cells."
Const sTxtHelpICttRightTitle = "Insert Column to the Right"
Const sTxtHelpICttRight = "To insert a column to the right of your cursor, click inside cell after which to insert a column, then click the 'Insert Column to the Right' icon.<br><br>Each consecutive click will insert another column after the selected cell.<br><br>Note: this function will not work if a cell has not been selected."
Const sTxtHelpICttLeftTitle = "Insert Column to the Left"
Const sTxtHelpICttLeft = "To insert column to the left of your cursor, click inside cell before which to insert a column, then click the 'Insert Column to the Left' icon.<br><br>Each consecutive click will insert another column before the selected cell.<br><br>Note: this function will not work if a cell has not been selected."
Const sTxtHelpIRAboveTitle = "Insert Row Above"
Const sTxtHelpIRAbove = "To insert row above, click inside cell above which to insert a row, then click the 'Insert Row Above' icon.<br><br>Each consecutive click will insert another row above the selected cell.<br><br>Note: this function will not work if a cell has not been selected."
Const sTxtHelpIRBelowTitle = "Insert Row Below"
Const sTxtHelpIRBelow = "To insert row below, click inside cell below which to insert a row, then click the 'Insert Row Below' icon.<br><br>Each consecutive click will insert another row below the selected cell.<br><br>Note: this function will not work if a cell has not been selected."
Const sTxtHelpDRowTitle = " Delete Row"
Const sTxtHelpDRow = "To delete a row, click inside cell which is in the row to be deleted, then click the 'Delete Row' icon.<br><br>Note: this function will not work if a cell has not been selected."
Const sTxtHelpIColumnTitle = "Insert Column"
Const sTxtHelpIColumn = "To insert a column, click inside cell which is in the column to be inserted, then click the 'Insert Column' icon.<br><br>Note: this function will not work if a cell has not been selected."
Const sTxtHelpDColumnTitle = "Delete Column"
Const sTxtHelpDColumn = "To delete a column, click inside cell which is in the column to be deleted, then click the 'Delete Column' icon.<br><br>Note: this function will not work if a cell has not been selected."
Const sTxtHelpICSpanTitle = "Increase Column Span"
Const sTxtHelpICSpan = "To insert column span, click inside cell who's span is to be increased, then click the 'Increase Column Span' icon.<br><br>Each consecutive click will further increase the column span of the selected cell.<br><br>Note: this function will not work if a cell has not been selected."
Const sTxtHelpDCSpanTitle = "Decrease Column Span"
Const sTxtHelpDCSpan = "To decrease column span, click inside cell who's span is to be decreased, then click the 'Decrease Column Span' icon.<br><br>Each consecutive click will further decrease the column span of the selected cell. Note: this function will not work if a cell has not been selected."
Const sTxtHelpFFunctionsTitle = "Form Functions"
Const sTxtHelpFFunctions = "To insert or modify a Form, select the 'Form Functions' icon to display a list of available Form Functions.<br><br>If a Form Function is NOT available, you will need to place your cursor inside the Form you wish to modify."
Const sTxtHelpIFormTitle = "Insert Form"
Const sTxtHelpIForm = "To insert a form, select desired position then click the 'Insert Form' icon.<br><br>A new window will pop-up with the following fields: Name - name of form; Action - location of script that processes the form and Method - post, get or none.<br><br>Fill in form details or leave blank for a blank form.<br><br>When finished, click the 'Insert Form' button to insert form, or click 'Cancel' to go back to the editor."
Const sTxtHelpMFPropertiesTitle = "Modify Form Properties"
Const sTxtHelpMFProperties = "To modify form properties, click anywhere inside the form to modify, then click the 'Modify Form Properties' icon.<br><br>A pop-up window will appear with the form's properties.<br><Br>Click the 'Modify Form Properties' button to save your changes, or click 'Cancel' to go back to the editor. Note: this function will not work if a form has not been selected."
Const sTxtHelpIMTFieldTitle = "Insert / Modify Text Field"
Const sTxtHelpIMTField = "To insert a text field, select desired position then click the 'Insert/Modify Text Field' icon.<br><br>A pop-up window will appear with the following attributes: Name - name of text field; Character width - the width of the text field, in characters; Type - type of text field (Text or Password); Initial value - initial text in field and Maximum characters - maximum number of characters allowed.<br><br>Set the attributes then click the 'Insert Text Field' button to insert text field, or click 'Cancel' to go back to the editor.<br><br>To modify a text field's properties, select desired text field and click the 'Insert/Modify Text Field' icon.<br><Br>A pop-up window will appear with the text field's attributes.<br><br>Modify any attributes desired, then click the 'Modify Text Field' button to save changes, or click 'Cancel' to go back to the editor."
Const sTxtHelpIMTAreaTitle = "Insert / Modify Text Area"
Const sTxtHelpIMTArea = "To insert a text area, select desired position then click the 'Insert/Modify Text Area' icon<br><br>A pop-up window will appear with the following attributes: Name - name of text area; Character width - the width of the text area, in characters; Initial value - initial text in area and Lines - number of lines allowed in the text area.<br><br>Set the attributes then click the 'Insert Text Field' button to insert the text area, or click 'Cancel' to go back to the editor.<br><br>To modify a text area's properties, select desired text area and click the 'Insert/Modify Text Area' icon.<br><br>A pop-up window will appear with the text area's attributes.<br><br>Modify any attributes desired, then click 'Modify Text Area' button to save changes, or click 'Cancel' to go back to the editor. "
Const sTxtHelpIMHAreaTitle = "Insert / Modify Hidden Area"
Const sTxtHelpIMHArea = "To insert a hidden field, select desired position then click the 'Insert/Modify Hidden Field' icon.<br><br>A pop-up window will appear with the following attributes: Name - name of hidden field and Initial value - initial value of hidden field.<br><br>Set the attributes then click the 'Insert Hidden Field' button to insert the hidden field, or click 'Cancel' to go back to the editor.<br><br>To modify a hidden field's properties, select desired hidden field and click the 'Insert/Modify Hidden Field' icon.<br><br>A pop-up window will appear with the hidden field's attributes.<br><br>Modify any attributes desired, then click 'Modify Hidden Field' button to save changes or click 'Cancel' to go back to the editor. "
Const sTxtHelpIMButtonTitle = "Insert / Modify Button"
Const sTxtHelpIMButton = "To insert a button, select desired position then click the 'Insert/Modify Button' icon.<br><br>A pop-up window will appear with the following attributes: Name - name of text area; Type - type of button (Submit, Reset or Button) and Initial value - initial text on the button.<br><br>Set the attributes then click 'Insert Button' to insert button, or click 'Cancel' to go back to the editor.<br><br>To modify a button's properties, select desired button and click the 'Insert/Modify Button' icon.<br><br>A pop-up window will appear with the button's attributes.<br><br>Modify any attributes desired, then click 'Modify Hidden Field' button to save changes or click 'Cancel' to go back to the editor. "
Const sTxtHelpIMCheckboxTitle = "Insert / Modify Checkbox"
Const sTxtHelpIMCheckbox = "To insert a checkbox, select desired position then click the 'Insert/Modify Checkbox' icon.<br><br>A pop-up window will appear with the following attributes: Name - name of checkbox; Initial state - checked or unchecked and Initial value - value of checkbox.<br><br>Set the attributes then click the 'Insert Checkbox' button to insert the checkbox, or click 'Cancel' to go back to the editor.<br><br>To modify a checkbox' properties, select desired checkbox and click the 'Insert/Modify Checkbox' icon.<br><br>A pop-up window will appear with the checkbox' attributes.<br><br>Modify any attributes desired, then click 'Modify Checkbox' button to save changes or click 'Cancel' to go back to the editor. "
Const sTxtHelpIMRButtonTitle = "Insert / Modify Radio Button"
Const sTxtHelpIMRButton = "To insert a radio button, select desired position then click the 'Insert/Modify Radio Button' icon.<br><br>A pop-up window will appear with the following attributes: Name - name of radio button; Initial state - checked or unchecked and Initial value - value of radio button.<br><br>Set the attributes then click 'Insert Radio Button' to insert the radio button, or click 'Cancel' to go back to the editor.<br><br>To modify a checkbox' properties, select desired checkbox and click the 'Insert/Modify Radio Button' icon.<br><br>A pop-up window will appear with the checkbox' attributes.<br><br>Modify any attributes desired, then click 'Modify Radio Button' button to save changes or click 'Cancel' to go back to the editor. "
Const sTxtHelpIMImageTitle = "Insert / Modify Image"
Const sTxtHelpIMImage = "If an image is NOT selected, clicking this icon will open the Image Manager. <a href='class.editworks.php?ToDo=ShowHelp#image'>Click here for more help on the image manager</a>.<br><br>If an image IS selected, then clicking this icon will open the 'Modify Image Properties' popup window.<br><br>To modify the image properties of the selected image, set the required attributes and click the 'Modify Image Properties' button."
Const sTxtHelpISCharactersTitle = "Insert Special Characters"
Const sTxtHelpISCharacters = "To insert a special character, click the 'Insert Special Character' icon.<br><br>A pop-up window will appear with a list of special characters.<br><br>Click the icon of the character to insert into your webpage."
Const sTxtHelpMPPropertiesTitle = "Modify Page Properties"
Const sTxtHelpMPProperties = "To modify page properties, click the 'Modify Page Properties' icon.<br><br>A pop-up window will appear with page attributes: Page Title - title of page; Description - description of page; Background Image - The URL of the image curently set as the page background image; Keywords - keywords page is to be recognized by; Background Colour - the background colour of page; Text Colour - colour of text in page and Link Colour - the colour of links in page.<br><br>When finished modifying, click the 'Modify Page' button to save changes, or click 'Cancel' to go back to the editor."
Const sTxtHelpCUHTMLCodeTitle = " Clean Up HTML Code"
Const sTxtHelpCUHTMLCode = "To clean HTML code, click the 'Clean HTML Code' icon.<br><br>This will remove any empty span and paragraph tags, all xml tags, all tags that have a colon in the tag name (i.e. <tag:with:colon>) and remove style and class attributes.<br><br>This is useful when copying and pasting from Microsoft Word documents to remove unnecessary HTML code. "
Const sTxtHelpSHGuidelinesTitle = "Show / Hide Guidelines"
Const sTxtHelpSHGuidelines = "To show or hide guidelines, click the 'Show/Hide Guidelines' icon.<br><br>This will toggle between displaying table and form guidelines and not showing any guidelines at all.<br><br>Tables and cells will have a broken grey line around them, forms will have a broken red line around them, while hidden fields will be a pink square when showing guidelines.<br><br>Note that the status bar (at the bottom of the window) will reflect the guidelines mode currently in use."
Const sTxtHelpSModeTitle = "Source Mode"
Const sTxtHelpSMode = " To switch to source code editing mode, click the 'Source' button at the bottom of the editor.<br><br>This will switch to HTML code editng mode.<br><br>To switch back to WYSIWYG Editing, click the 'Edit' button at the bottom of the editor.<br><br>This is recommended for advanced users only "
Const sTxtHelpPModeTitle = "Preview Mode"
Const sTxtHelpPMode = "To show a preview of the page being edited, click the 'Preview' button at the bottom of the editor.<br><br>This is useful in previewing a file to see how it will look exactly in your browser, before changes are saved.<br><br>To switch back to editing mode, click the 'Edit' button at the bottom of the editor."
Const sTxtHelpImageManager = "Image Manager"
Const sTxtHelpBTTOP = "Back To Top"
Const sTxtHelpImageDescription = "The Image Manager is where you can preview, insert, delete and upload your image files.<br><br>You can perform general maintenance on your images from the Image Manager - insert, set as background, upload, view, and delete images."
Const sTxtHelpVaImageTitle = "Viewing an Image"
Const sTxtHelpVaImage = "To view an image, select the desired image and click on the 'View' link.<br><br>The image will be shown in a pop-up window in it's full size.<br>Close the window to return to the Image Manager."
Const sTxtHelpIaImageTitle = "Inserting an Image"
Const sTxtHelpIaImage = "To insert an image, click the 'Insert' link in the image browser next to the image to be inserted."
Const sTxtHelpSBImageTitle = "Set Background Image"
Const sTxtHelpSBImage = "To set an image as a background image, click the 'Background' link in the image browser next to the image to be set. <br><br>The image will be set as the current page background image."
Const sTxtHelpDaImageTitle = "Deleting an Image"
Const sTxtHelpDaImage = "To delete, select the desired image and click on the 'Delete' link.<br><br>You will be prompted for confirmation of the deletion.<br><br>If you are sure you wish to delete the selected image, click 'OK'.<br><br>Clicking on 'Cancel' will take you back to the Image Manager."
Const sTxtHelpUaImageTitle = "Uploading an Image"
Const sTxtHelpUaImage = "To upload an image, click the 'Browse' button to open a 'Choose File' box that allows you to select a local image to upload.<br><br>Once the file has been selected, click 'OK' to begin uploading the file, or click 'Cancel' to be taken back to the Image Manager<br><br>Upon sucessful upload of the image, it will appear in the Image Manager."

%>