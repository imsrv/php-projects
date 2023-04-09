function form_jump(targ,selObj,restore){
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
 if (restore) selObj.selectedIndex=0;
}

function smilie(emote) {
 document.reply.comments.value += emote;
 document.reply.comments.focus();
}
