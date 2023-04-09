// JavaScript Document

// Announcement BBCode
// Created: 05/30/2005
// Author: Ivan Cat
// Description:
// Handles the work of bb tags
	
	function RunBBCodeBold() {
	
		var b = '[B][/B]';
	
		document.replies.message.value += b;
		return true;
	
	}
	
	function RunBBCodeItalic() {
	
		var i = '[I][/I]';

		document.replies.message.value += i;
		return true;
	
	}
	
	function RunBBCodeUnderlined() {

		var u = '[U][/U]';

		document.replies.message.value += u;
		return true;
	
	}

	function RunBBCodeImage() {
	
		var imgopen = '[IMG]';
		var imgclose = '[/IMG]';
		
		var url = prompt('Please, enter the path to your image:', 'http://');
		
		var toAdd = imgopen + url + imgclose;
		
		document.replies.message.value += toAdd;
		document.replies.message.focus();
	
	}
	
	function RunBBCodeMessage(Stuff) {
	
		document.BBCodeStuff.BBCodeHelper.value += Stuff;
		return true;

	}
	
	function RunBBCodeMessageExit() {
	
	document.BBCodeStuff.BBCodeHelper.value = '';
	return true;
	
	}
