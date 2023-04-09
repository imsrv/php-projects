// JavaScript Document

// ***********************************************************************************//
// Please leave this message alone, no one will be able to see it, except coders.**//
// This script is copyrighted by PHP scripts, a Marsal Design Company.***************//
// To get your own verison of this system, please do download it from our site*******//
// located at http://www.free-php-scripts.net****************************************//
// Script is free, no advertisement, no nothing....**********************************//
// **********************************************************************************//

//This function will empty out the status bar
function clearit(){
var statusmsg=""
window.status=statusmsg
return true
}

//This function will show the terms and agreement status message
function terms(){
var statusmsg="Please Read and Agree To Our Terms Of Use Before Using - Opens in New Window"
window.status=statusmsg
return true
}

//This function will show the index page status message
function indexme(){
var statusmsg="Index (Main) Page"
window.status=statusmsg
return true
}

//This function will show the Visit Page status message
function visit(){
var statusmsg="Click Here To Visit - Opens New Window"
window.status=statusmsg
return true
}

//These are the functions for the side menu status messages
function title1(){
var statusmsg="FAD® Banner Manager"
window.status=statusmsg
return true
}

function title2(){
var statusmsg="FAD® Group Banner Manager"
window.status=statusmsg
return true
}

function title3(){
var statusmsg="FAD® Counter Manager"
window.status=statusmsg
return true
}

function title4(){
var statusmsg="FAD® Referral Manager"
window.status=statusmsg
return true
}
function title5(){
var statusmsg="FAD® Security Manager"
window.status=statusmsg
return true
}

function title6(){
var statusmsg="FAD® Site Stats"
window.status=statusmsg
return true
}

function title7(){
var statusmsg="FAD® Recommened Links"
window.status=statusmsg
return true
}
//These are the functions for the Banner Sub-Menu status messages
function ban1(){
var statusmsg="Add A Banner"
window.status=statusmsg
return true
}
function ban2(){
var statusmsg="View Banner Stats Information"
window.status=statusmsg
return true
}
function ban3(){
var statusmsg="Edit A Banner"
window.status=statusmsg
return true
}
function ban4(){
var statusmsg="Remove A Banner"
window.status=statusmsg
return true
}

//These are the functions for the Group Banner Sub-Menu status messages
function gban1(){
var statusmsg="Add A Group"
window.status=statusmsg
return true
}

function gban2(){
var statusmsg="Remove A Group"
window.status=statusmsg
return true
}

//These are the functions for the counter manager Sub-Menu status messages
function count1(){
var statusmsg="Add A Counter"
window.status=statusmsg
return true
}

function count2(){
var statusmsg="View A Counter"
window.status=statusmsg
return true
}
function count3(){
var statusmsg="Edit A Counter"
window.status=statusmsg
return true
}

function count4(){
var statusmsg="Remove A Counter"
window.status=statusmsg
return true
}

//These are the functions for the counter manager Sub-Menu status messages
function ref1(){
var statusmsg="Add A Referral"
window.status=statusmsg
return true
}

function ref2(){
var statusmsg="Edit A Referral"
window.status=statusmsg
return true
}
function ref3(){
var statusmsg="View A Referral"
window.status=statusmsg
return true
}

function ref4(){
var statusmsg="Remove A Referral"
window.status=statusmsg
return true
}

//This function will check the login information eneterd
function checklogin(loginform){
	var isvalid = true;
	
	if(loginform.userloginid.value == 0){
		alert("Please Enter A Username");
		loginform.userloginid.style.background = "#FFCCFF";
		loginform.userloginid.focus();
		return false;
	}
	if(loginform.userloginpassword.value == 0){
		alert("Please Enter A Password");
		loginform.userloginpassword.style.background = "#FFCCFF";
		loginform.userloginpassword.focus();
		return false;
	}
	return isvalid;
}

//This function will check the add banner information
function validate_banner_input(objForm){
var bValid=true;

	if (objForm.name.value.length <3) {
		bValid=false;
		alert("Please enter a banner name, min. 3 characters!");
		objForm.name.style.background = "#FFCCFF";
		objForm.name.focus();		
	}
	
	if(bValid){
		if (objForm.locationtype[0].checked == true && objForm.httploc.value == 0 ) {
		bValid=false;
		objForm.httploc.style.background = "#FFCCFF";
		alert("Please enter a URL For the Image To Be Shown!");
		objForm.httploc.focus();		
		}	
	}
	
	if(bValid){
		if (objForm.locationtype[0].checked == true && objForm.filename.value != 0 ) {
		bValid=false;
		objForm.filename.style.background = "#FFCCFF";
		alert("Please leave the filename box blank, or select upload file option!");
		objForm.filename.focus();		
		}	
	}
	
	if(bValid){
		if (objForm.locationtype[1].checked == true && objForm.filename.value == 0 ) {
		bValid=false;
		objForm.filename.style.background = "#FFCCFF";
		alert("Please enter a filename to upload!");
		objForm.filename.focus();		
		}	
	}
	
	if(bValid){
		if (objForm.locationtype[1].checked == true && objForm.httploc.value != 0 ) {
		bValid=false;
		objForm.filename.style.background = "#FFCCFF";
		alert("Please leave the http location empty, or select the HTTP option instead!");
		objForm.filename.focus();		
		}	
	}
	
	if(bValid){
		if (objForm.urlto.value.length < 5 || objForm.urlto.value == 'http://' ) {
		bValid=false;
		objForm.urlto.style.background = "#FFCCFF";
		alert("Please Enter Direction URL or Write EMPTY To Disable it!");
		objForm.urlto.focus();		
		}	
	}
	
	if(bValid){
		if (objForm.stopit[1].checked == true && objForm.hits.value == 0 ) {
		bValid=false;
		objForm.hits.style.background = "#FFCCFF";
		alert("Please Enter the Number of Hits To Stop at or choose another selection");
		objForm.hits.focus();		
		}	
	}
	
	if(bValid){
		if (objForm.stopit[2].checked == true && objForm.views.value == 0 ) {
		bValid=false;
		objForm.views.style.background = "#FFCCFF";
		alert("Please Enter the Number of Views To Stop at or choose another selection");
		objForm.views.focus();		
		}	
	}
	
	
	if(bValid){
		if (objForm.stopit[3].checked == true && objForm.id1.value == 0 ) {
		bValid=false;
		objForm.id1.style.background = "#FFCCFF";
		alert("Please Enter the Date To Stop at or choose another selection");
		objForm.id1.focus();		
		}	
	}
	
	if(bValid){
		if (objForm.stopit[3].checked == true && objForm.id1.value != 0 ) {
			if (objForm.id1.value.indexOf("/") !=2 || objForm.id1.value.length != 10){
				bValid=false;
				objForm.id1.style.background = "#FFCCFF";
				alert("Please Enter Desired Date, Correct Date Format is: 00/00/0000");
				objForm.id1.focus();
			}		
		}	
	}
	
	if(bValid){
	
		if (objForm.size[1].checked == true && (objForm.height.value == 0 || objForm.width.value == 0 )) {
		bValid=false;
		objForm.width.style.background = "#FFCCFF";
		alert("Please Enter Desired Width and Heigth or Set To Default");
		objForm.width.focus();		
		}	
	}
	
	if(bValid){
		if(objForm.group.value == 0){
			bValid=false;
			objForm.group.style.background = "#FFCCFF";
			alert("Please Select A Group Name, or Add One From Banner Group Manager!");
			objForm.group.focus();
		}
	}
	if(bValid){
		if(objForm.urlto.value == 'EMPTY' || objForm.urlto.value == 'Empty' || objForm.urlto.value == 'empty'){
			objForm.urlto.value = 'EMPTY';
		}
	}
	
	if(bValid){
		if(objForm.mouseover.value == 0){
			objForm.mouseover.value = 'NONE';
		}
	}
return bValid;
}
//This function will check the Edit Banner Information
function edit_banner_validate(objForm){
var bValid=true;

	if (objForm.name.value.length <3) {
		bValid=false;
		objForm.name.style.background = "#FFCCFF";
		alert("Please enter a banner name, min. 3 characters!");
		objForm.name.focus();		
	}
	
	
	if(bValid){
		if (objForm.locationtype[0].checked == true && objForm.httploc.value == 0 ) {
		bValid=false;
		objForm.httploc.style.background = "#FFCCFF";
		alert("Please enter a URL For the Image To Be Shown!");
		objForm.httploc.focus();		
		}	
	}
	
		
	if(bValid){
		if (objForm.locationtype[1].checked == true && objForm.httploc.value != 0 ) {
		bValid=false;
		objForm.filename.style.background = "#FFCCFF";
		alert("Please leave the http location empty, or select the HTTP option instead!");
		objForm.filename.focus();		
		}	
	}
	
	if(bValid){
		if (objForm.urlto.value.length < 5 || objForm.urlto.value == 'http://' ) {
		bValid=false;
		objForm.urlto.style.background = "#FFCCFF";
		alert("Please Enter Direction URL or Write EMPTY To Disable it!");
		objForm.urlto.focus();		
		}	
	}
	
	if(bValid){
		if (objForm.stopit[1].checked == true && objForm.number.value == 0 ) {
		bValid=false;
		objForm.hits.style.background = "#FFCCFF";
		alert("Please Enter the Number of Hits To Stop at or choose another selection");
		objForm.hits.focus();		
		}	
	}
	
	if(bValid){
		if (objForm.stopit[2].checked == true && objForm.number.value == 0 ) {
		bValid=false;
		objForm.views.style.background = "#FFCCFF";
		alert("Please Enter the Number of Views To Stop at or choose another selection");
		objForm.views.focus();		
		}	
	}
	
	
	if(bValid){
		if (objForm.stopit[3].checked == true && objForm.id1.value == 0 ) {
		bValid=false;
		objForm.id1.style.background = "#FFCCFF";
		alert("Please Enter the Date To Stop at or choose another selection");
		objForm.id1.focus();		
		}	
	}
	
	if(bValid){
		if (objForm.stopit[3].checked == true && objForm.id1.value != 0 ) {
				if (objForm.id1.value.indexOf("/") !=2 || objForm.id1.value.length != 10){
			bValid=false;
			objForm.id1.style.background = "#FFCCFF";
			alert("Please Enter Desired Date, Correct Date Format is: 00/00/0000");
			objForm.id1.focus();
		}		
		}	
	}
	
	if(bValid){
	
		if (objForm.size[1].checked == true && (objForm.height.value == 0 || objForm.width.value == 0 )) {
		bValid=false;
		objForm.width.style.background = "#FFCCFF";
		alert("Please Enter Desired Width and Heigth or Set To Default");
		objForm.width.focus();		
		}	
	}
	
	if(bValid){
		if(objForm.group.value == 0){
			bValid=false;
			objForm.group.style.background = "#FFCCFF";
			alert("Please Select A Group Name, or Add One From Banner Group Manager!");
			objForm.group.focus();
		}
	}
	if(bValid){
		if(objForm.urlto.value == 'EMPTY' || objForm.urlto.value == 'Empty' || objForm.urlto.value == 'empty'){
			objForm.urlto.value = 'EMPTY';
		}
	}
	
	if(bValid){
		if(objForm.mouseover.value == 0){
			objForm.mouseover.value = 'NONE';
		}
	}
return bValid;
}

//This function is used to reload a page when a different item is selected from the list menu
function reloader(objectthis) { 
	var url;
	
	loc = window.location.href;
	var i = 0;
	var temp = loc.split('/');
	while(temp[i] != null){
		theadd = temp[i];
		i = i+1;
	}
	//Check if it was already submitted
	if(theadd.length > 15){
		checkifsubmitin = theadd.split('?');
		theadd = checkifsubmitin[0];
	}
	url =  theadd + '?groupsort=' + objectthis.options[objectthis.selectedIndex].value;
	
	
	if ( objectthis.options[objectthis.selectedIndex].value != '00'){
		if( url != ''  ){
			window.location.href = url;
		}
		if( objectthis.options[objectthis.selectedIndex].value == ''  ){
			window.location.href = theadd;
		}
	}
return true;
}

//This function will check the add group banner information
function validate_new_group(objForm){
	var bValid=true;
	
	if(objForm.groupname.value == 0){
		alert("Please Enter A Group Name To Add!");
		objForm.groupname.style.background = "#FFCCFF";
		objForm.groupname.focus();
		bValid = false
	}

	return bValid;
}

//This function will check the remove banner page
function validate_remove_group(deleteg){
	var isvalid = true;
	
	if(deleteg.group.value == 0){
		alert("Please Select A Banner To Remove");
		deleteg.group.style.background = "#FFCCFF";
		deleteg.group.focus();
		isvalid = false;
	}
		
	return isvalid;
}
//This function will check the Add counter page
function validate_counter_add(addit){
	var isvalid = true;
	
	if(addit.name.value == 0){
		alert("Please Select A Name For The Counter");
		addit.name.style.background = "#FFCCFF";
		addit.name.focus();
		return false;
	}
	if(addit.start.value == 0){
		addit.start.value = '0';
	}
	
	return isvalid;
}
//This function will check the Edit counter page
function edit_counter_validate(addit){
	var isvalid = true;
	
	if(addit.name.value == 0){
		alert("Please Select A Name For The Counter");
		addit.name.style.background = "#FFCCFF";
		addit.name.focus();
		return false;
	}
	
	if(addit.u_hits.value == 0){
		addit.u_hits.value = '0';
	}
	
	if(addit.all_hits.value == 0){
		addit.all_hits.value = '0';
	}
	return isvalid;
}

//Use this code to add referral 
function validate_add_ref(form){
	var checker = true;
	
	if(form.name.value == 0){
		alert("Please Enter Referral Name");
		form.name.style.background = "#FFCCFF";
		form.name.focus();
		return false;
	}
	
	if(form.urlkind[1].checked == true && form.urlto.value == 0){
		alert("Please Enter  A Url To Redirect To, or Switch It To Main");
		form.urlto.style.background = "#FFCCFF";
		form.urlto.focus();
		return false;
	}
	
	if(form.urlkind[0].checked == true && form.urlto.value != 0){
		alert("Please Leave Url To Redirect To Empty, or Change Option");
		form.urlto.style.background = "#FFCCFF";
		form.urlto.focus();
		return false;
	}
	return checker;
}

//Use this code to add referral 
function edit_ref_validate(form){
	var checker = true;
	if(form.name.value == 0){
		alert("Please Enter Referral Name");
		form.name.style.background = "#FFCCFF";
		form.name.focus();
		return false;
	}
	if(form.urlto.value == 0){
		alert("Please Enter A Link To Direct To");
		form.urlto.style.background = "#FFCCFF";
		form.urlto.focus();
		return false;
	}
	if(form.hits.value.length == 0){
		alert("Please Enter A Number For Hits");
		form.hits.style.background = "#FFCCFF";
		form.hits.focus();
		return false;
	}
	if(form.credits.value.length == 0){
		alert("Please Enter A Number For Credit");
		form.credits.style.background = "#FFCCFF";
		form.credits.focus();
		return false;
	}
	if(form.make.value == 0){
		alert("Please Enter A Make Date");
		form.make.style.background = "#FFCCFF";
		form.make.focus();
		return false;
	}
	return checker;
}
//Function to check the security submit form
function check_security_man(object){
var valid=true;


	if(object.dest.value.length < 3 || object.dest.value == 'http://' ){
		alert("Please Enter Complete Destination URL!");
		object.dest.focus();
		object.dest.style.background = "#FFCCFF";
		valid=false;
	}
	
if(valid){
	if(object.time.value.length < 1 || object.time.value == '0' ){
		alert("Please Enter Session Length!");
		object.time.focus();
		object.time.style.background = "#FFCCFF";
		valid=false;
	}
}

if(valid){
	if(object.username.value != 0 || object.password.value != 0){
		if(object.hostname.value != 0 || object.dataname.value != 0 || object.dusername.value != 0 || object.dpassword.value != 0  || object.field1.value != 0  || object.field2.value != 0){
			alert("Please Leave Database information or Userlogin Information Blank!");
			object.username.style.background = "#FFCCFF";
			object.username.focus();
			valid=false;
		}
	}
}
if(valid){
	if(object.username.value == 0 || object.password.value == 0){
		if(object.hostname.value == 0 || object.dataname.value == 0 || object.dusername.value == 0 || object.field1.value == 0 || object.field2.value == 0){
			alert("Please Enter Either The Database information or Userlogin Information!");
			object.username.style.background = "#FFCCFF";
			object.username.focus();
			valid=false;
		}
	}
}


return valid;
}

//Use this code to copy referral code to system's clipboard
function ClipBoard(){
	textarea.innerText = copytext.innerText;
	Copied = textarea.createTextRange();
	Copied.execCommand("Copy");
	alert("The Code Has Been Copied To The Clipboard, Paste (control+v) or (right-click paste) On-To The Page Where the Payment Proceed or Registration Is Completed");
}
