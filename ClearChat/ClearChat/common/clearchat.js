
// Checks if the comment input-field is empty onSubmit & reloads
function checkComment() {
if ((document.inputform.comment.value == '') || (document.inputform.comment.value == ' ')) {
parent.outputframe.history.go(0);
return false;
} else {
return true;
}
}

// Inserts smiley to comment input-field
function smiley(thesmiley) {
document.inputform.comment.value += thesmiley;
document.inputform.comment.focus();
}

// Inserts smiley to comment input-field from Available smilies-page
function addSmiley(thesmiley) {
window.opener.document.inputform.comment.value += thesmiley;
window.opener.document.inputform.comment.focus();
}