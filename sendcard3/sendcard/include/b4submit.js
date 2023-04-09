/*
  You can either cut and paste this right between script tags within HTML head tags
  or put it in a seperate file and use the script tag's src attribute.
  In either case you could call the function as follows:
  <form onSubmit='return RequiredFieldsFilled(this,"","")'>
  Or see b4submit.htm with which this script will be "packaged" for an example
  of using an intermediate function that defines forms not required and
  a more meaningful error message
*/

function RequiredFieldsFilled(thisForm,skipField,errorCaptions) {

  var formFields = thisForm.elements
  
  var unFilledElements = new Array()
  
  /*
     The following are 'associative' or 'hash' arrays that can be indexed by
	 something other than an integer, that are implemented in JavaScript 1.2
	 and higher (Versions 4 and higher of the major browsers), and should be
	 familiar to CGI/Perl programmers. 
  */	 
  var checkBoxRadioGroups = new Array() 
  var firstGroupElement = new Array()   
  
  /* 
    Javascript 1.2+ "Regular Expression" (also common to CGI/Perl scripts) 
	for matching a pattern of zero or more instances of blank or "white" space
	in text fields
  */
  var noText = /^\s*$/
  
  var selection
  var isCheckBoxOrRadio

  for (var fieldNum = 0; fieldNum < formFields.length; fieldNum++) {
    
    var formField = formFields[fieldNum]
    var fieldName = formField.name
    var fieldType = formField.type

    /*
       Skip fields specified by user as not requiring validation, as well as
	   other types of fields not ordinarily validated
    */
    if (skipField[fieldName] == true 
	    || fieldType == "hidden" 
		|| fieldType == "submit") 
    {
      continue
    }

    /*
      Trim the field type to the first four characters so that:
      "text" and "textarea"
      are handled identically by the following switch construct, as are:
      "select_one" and "select_many"
    */
    fieldType = fieldType.substr(0,4)

    switch(fieldType) {
      /*
        "Cases", in terms of HTML form fields:
        
        1) <input type="text"> or <textarea>
        2) <select>, regardless of "multiple" attribute (pull-down menus)
        3/4) <input type="checkbox"> <input type="radio">
        
        Assign the form's element number to the "unFilledElements" array, for 
		text fields and/or pull-down menus for which the user didn't specify 
		a value
      */
      
      case "text":
        if (noText.test(formField.value)) {
          unFilledElements[unFilledElements.length] = fieldNum
        }
        isCheckBoxOrRadio = false
        break
      
      case "sele":
        selection = formField.selectedIndex
        /*
           If no choice was made, selection will equal -1 if "multiple" was 
		   specified as an attribute of the select tag, 0 if "multiple" NOT
		   specified        
        */
        if (selection == -1 || (selection == 0 && !formField.options[0].value)) {
          unFilledElements[unFilledElements.length] = fieldNum
        }
        isCheckBoxOrRadio = false
        break		
		/*
           ADDITIONAL NOTES REGARDING PULL DOWN MENUS:
  
           To specify the top visible choice from a select menu as a LABEL for
		   the list below it, and not a valid choice, do NOT specify a value
		   attribute for that option; for instance:
    
           <SELECT name="firstChoiceLabel">
             <OPTION>Make Your Choice for President from the list below
             <OPTION value="tweedledum">Bush
             <OPTION value="tweedledee">Gore
           </SELECT>
    
           If, the first option IS a valid choice, a value attribute needs to be
		   specified for it.  If existing code has a value attribute specified, 
		   DON'T change it, as the server side process for the form may need it.
		   If a value isn't previously specified, you can safely do so by
		   making it identical to the human readable text; for instance:
    
           <SELECT name="firstChoiceNOTLabel">
             <OPTION value="Valid Choice 1">Valid Choice 1
             <OPTION value="Valid Choice 2">Valid Choice 2
           </SELECT>
    
           This will ensure compatability with any existing server-side process,
		   because before specifying a value attribute it was using the human
		   readable anyway.
      */
	  	
      case "chec":
        isCheckBoxOrRadio = true
        break
        
      case "radi":  
        isCheckBoxOrRadio = true
        break
                
      default:
        /*
          Skips <input type="file">; this might be handled in future versions
		  similar to text and textareas: by just checking for a visible value
        */
        isCheckBoxOrRadio = false
        continue                      
           
    } // switch(fieldType)
    
    if (isCheckBoxOrRadio) {
      /*
        Designates whether so-named checkbox or radio button was specified by 
		user, IF not already specified as true
      */
      if (checkBoxRadioGroups[fieldName] != true) {
        checkBoxRadioGroups[fieldName] = formField.checked
      }
      /*
        Designates the FIRST element of the so-named group of checkbox or 
		radio buttons
      */
      if (firstGroupElement[fieldName] == null) {
        firstGroupElement[fieldName] = fieldNum
      }    
    } 
    
  } // for var fieldNum = 0.....
  
  /*
    Check for selections from GROUPS of checkboxes/radio buttons AFTER all 
	individual fields have been processed
  */
  for (var groupName in checkBoxRadioGroups) {
    if (checkBoxRadioGroups[groupName] == false) {
      unFilledElements[unFilledElements.length] = firstGroupElement[groupName]
    }
  }
  
  /*
    At least one field left unfilled so the user receives an error message and 
	the form is NOT submitted
  */  
  if (unFilledElements.length > 0) {
    /*
       Numerically sort the element numbers contained in the unFilledElements
	   array (using an "anonymous" function), which is necessary because entries 
	   for groups of checkboxes and/or radio buttons were added AFTER all
	   individual field elements were processed, and so could be out of order
    */
    unFilledElements = unFilledElements.sort(function(a,b) {return a-b})
    
    /*
       To return the focus to the first unfilled field; the form must be named 
	   or the following code isn't evaluated
    */          
    if (thisForm.name) {
      eval("document." + thisForm.name + ".elements[" + unFilledElements[0] 
	       + "].focus()")
    }

    var errorAlert = "Please fill out the following " + unFilledElements.length 
	errorAlert += " required field(s) you left unfilled:\n\n"
    
    /*
       Build the list of fields for the error message either from 
	   author-specified captions, or from the field names themselves
    */              
    for (var elementNum = 0; elementNum < unFilledElements.length; elementNum++) 
	{
      var unFilledFieldName = formFields[unFilledElements[elementNum]].name
      if (errorCaptions[unFilledFieldName] != null) {
        errorAlert += (errorCaptions[unFilledFieldName] + "\n")
      } else {
        errorAlert += (unFilledFieldName + "\n")
      }
    } 

    alert(errorAlert)
    return false
    
  } // if (unFilledElements.length > 0)
  
  /*
     Otherwise the form was filled out properly
     The alert line is optional, and other functionality can be added here
     The "return true" line is NOT optional
  */
  // alert("Thanks for filling out all the required fields!")
  return true
  
}
