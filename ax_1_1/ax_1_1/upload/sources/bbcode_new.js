// JavaScript Document
// AnnouncementX BBCode
// Author: Ivan Cat
// Created: 2005/09/12
// Updated: 2005/10/12

function SimpleTag(tag) {

	var $b = '[B]';
	var $b2 = '[/B]';
	var $i = '[I]';
	var $i2 = '[/I]';
	var $u = '[U]';
	var $u2 = '[/U]';

	if (tag != '') {
	
		switch (tag) {
		
			case "[B]":
			
				if (document.BBCodeStuff.bold.value == '[B]') {
				
					document.replies.message.value += $b;
					document.BBCodeStuff.bold.value = '[*B]';
					document.replies.message.focus();
					return true;
				
				} else {
			
					document.replies.message.value += $b2;
					document.BBCodeStuff.bold.value = '[B]';
					document.replies.message.focus();
					return true;

				}
			
			break;
						
			case "[I]":
			
				if (document.BBCodeStuff.italic.value == '[I]') {
			
					document.replies.message.value += $i;
					document.BBCodeStuff.italic.value = '[*I]';
					document.replies.message.focus();
					return true;
				
				} else {
				
					document.replies.message.value += $i2;
					document.BBCodeStuff.italic.value = '[I]';
					document.replies.message.focus();
					return true;

				}
						
			
			break;
			
			case "[U]":
			
				if (document.BBCodeStuff.underlined.value == '[U]') {
				
					document.replies.message.value += $u;
					document.BBCodeStuff.underlined.value = '[*U]';
					document.replies.message.focus();
					return true;
				
				} else {
	
					document.replies.message.value += $u2;
					document.BBCodeStuff.underlined.value = '[U]';
					document.replies.message.focus();
					return true;

				}
			
			break;
			
			case "[CODE]":
			
				if (document.BBCodeStuff.code.value == '[CODE]') {
		
					document.BBCodeStuff.code.value = '[*CODE]';
					document.replies.message.value += '[CODE]';
					document.replies.message.focus();
					return true;
				
				} else {
				
					document.BBCodeStuff.code.value = '[CODE]';
					document.replies.message.value += '[/CODE]';
					document.replies.message.focus();
					return true;
				
				}
		
			
			break;
			
			default:
				
				alert ("Critical Error! Tag is not defined!");
				return;
						
		}
	
	} else {
	
		alert ("Critical Error!");
		return;
	
	}

}
	
	function PutURL() {
	
		var url=prompt("Please, enter the URL: ", "http://");
		var title=prompt("Please, enter link title: ", "");
		
		if (url != '') {
		
			if (title == '') {
			
				document.replies.message.value += '[URL=' + url + '/]' + url + '[/URL]';
				document.replies.message.focus();
				return true;
			
			} else {
			
				document.replies.message.value += '[URL=' + url + '/]' + title + '[/URL]';
				document.replies.message.focus();
				return true;
			
			}
		
		} else {
		
			alert("Please, enter URL!");
			return;
		
		}
	
	}
	
	function PutImage() {
	
		var $imgopen = '[IMG]';
		var $imgclose = '[/IMG]';
		var ImgURL = prompt("Please, enter path to your image:", "http://");
	
		if (ImgURL == '') {
		
			alert("No URL for the image!");
			return;
		
		} else {
		
			var NewCode = $imgopen + ImgURL + $imgclose;
		
			document.replies.message.value += NewCode;
			document.replies.message.focus(NewCode);
			return true;
		
		}
		
	}
	
	function PutEmail() {
	
		var email=prompt("Please, enter e-mail: ", "");
		var text = prompt("Please, enter text for e-mail link: " ,"");
		
		if (email == '') {
			
			alert ("Please, enter e-mail!");
			return;
		
		} else {
		
			var emailopened = "[EMAIL=";
			var emailclosed = "[/EMAIL]";
			
			if (text == '') {
		
				document.replies.message.value += emailopened + email + "/]" + email + emailclosed;
				document.replies.message.focus();
				return true;
			
			} else {
			
				document.replies.message.value += emailopened + email + "/]" + text + emailclosed;
				document.replies.message.focus();
				return true;
			
			}
		
		}
	
	}
	
	function PutQuote() {
	
		var quote = prompt("Please, enter: ", "");
		
		if (quote == '') {
		
			alert ("Please, enter something next time!");
			return;
		
		} else {
		
			var quoteopened = "[QUOTE]";
			var quoteclosed = "[/QUOTE]";
			
			document.replies.message.value += quoteopened + quote + quoteclosed;
			document.replies.message.focus();
			return true;
		
		}
	
	}
		
	function RunBBCodeMessage(Stuff) {
	
		document.BBCodeStuff.BBCodeHelper.value += Stuff;
		return true;

	}
	
	function RunBBCodeMessageExit() {
	
		document.BBCodeStuff.BBCodeHelper.value = '';
		return true;
	
	}
	
	function BBReference() {
	
		window.open('./index.php?do=bbcode_help&','BBCode Reference','width=450,height=400,resizable=yes,scrollbars=yes,status=yes');
	
	}