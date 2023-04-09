function jump(url) {
window.location.href = url;
}

function logout() {
var logout = confirm("Are you sure you want to log out?");
if (logout)
jump('logout.php');
}

function confirmDelete() {
c = confirm("Are you sure you want to delete the selected messages?");
if (c)
return true;
else
return false;
}

function showContacts(field) {
open('contactslist.php?f='+field,'contactslist','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=300,height=400');
}

function addAttachments(string) {
open('addattachment.php?t='+string,'attachment','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=420,height=150');
}

function bbcode(code) {
if (code == "url") {
var link_url = prompt("Enter the URL of the link:", "http://");
var link_name = prompt("Enter the name of the link:", "");
if ((link_name == "") || (link_name == null)) {
code = "[url]" + link_url + "[/url]";
}
else {
code = "[url=" + link_url + "]" + link_name + "[/url]";
}
}
document.compose.message.value = document.compose.message.value + code;
}

function hideDiv(divid) {
if (document.getElementById) { // DOM3 = IE5, NS6
document.getElementById(divid).style.visibility = 'hidden';
}
else {
if (document.layers) { // Netscape 4
document.divid.visibility = 'hidden';
}
else { // IE 4
document.all.divid.style.visibility = 'hidden';
}
}
}

function showDiv(divid) {
if (document.getElementById) { // DOM3 = IE5, NS6
document.getElementById(divid).style.visibility = 'visible';
}
else {
if (document.layers) { // Netscape 4
document.divid.visibility = 'visible';
}
else { // IE 4
document.all.divid.style.visibility = 'visible';
}
}
}

function disableButton(btn) {
btn.disabled = true;
}

function checkAll(form_obj) {
var args = arguments;
start_point:
for (var i=0;i<form_obj.length;i++) {
found = false;   
var elem = form_obj.elements[i];
if (elem.type=='checkbox') {
for (var j = 0; j < args.length; j++)
if (args[j] == elem.name)
continue start_point;
elem.checked = true;
}
}
}

function extractUsername() {
var first = document.add.first.value;
var first = first.toLowerCase();
var last = document.add.last.value;
var last = last.toLowerCase();
var username = first.substring(0,1) + last;
document.add.username.value = username;
}

function validateID(sText) { 
var ValidChars = "0123456789"; 
var Char;
for (i = 0; i < sText.length; i++) {
Char = sText.charAt(i);
if (ValidChars.indexOf(Char) == -1) {
alert('Please enter a number only to search for the user ID!');
return false;
}
}
return IsNumber;
}