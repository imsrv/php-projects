############################################################
sub MailJs{
	return qq|
<script language="JavaScript">
function isChecked(ptr){
	len=ptr.elements.length;
	var i=0;
	for(i=0; i<len; i++){
		if (ptr.elements[i].name=='chkList'){
			if(ptr.elements[i].checked == 1){
				return 1;
			}
		}
	}
	return 0;
}
//----------------------------
function goFolder(fname){
	newFolder = fname.options[fname.selectedIndex].value;
	document.mojo.A.value="m_list";
	document.mojo.mbox.value=newFolder;
	document.mojo.submit();
}
//--------------------------------------------------------------------
function mMove(){
	ptr=document.mojo;
	len=ptr.elements.length;
	var i=0;
	var y=0;
	for(i=0; i<len; i++){
		if (ptr.elements[i].name=='chkList'){
			if(ptr.elements[i].checked == 1){
				y=1;
			}
		}
   }
  	if( y != 1){
     alert("You first need to select messages to move!");
     return false;
   }
	//--------
  sel=document.mojo.moveFolder;
  if(sel.options[sel.selectedIndex].value == "newfolder"){
		nn=prompt("Please enter the folder name.","");
      if(nn && nn!=null && nn!="null" && nn!=""){
			document.mojo.F.value=nn;
		}
		else{
			return false;
      }
	}
	if (sel.options[sel.selectedIndex].value == ""){
		alert("Please Select a Folder Name to move messages.\\nUse [create folder] selection to create a new folder.")
		sel.focus();
		return false;
	}
	document.mojo.A.value="m_move";
	document.mojo.submit();
}
//------------------------------------------------------------
function mDelete(){
	ptr=document.mojo;
  	len=ptr.elements.length;
  	var i=0;
  	var y=0;
  	for(i=0; i<len; i++){
		if (ptr.elements[i].name=='chkList'){
			if(ptr.elements[i].checked == 1){
				y=1;
         }
		}
   }
	if( y != 1){
		alert("You first need to select messages to delete!");
		return false;
	}
	ptr.A.value="m_delete";
	ptr.submit();
}                 
 
//------------------------------------------------------------
function SetChecked(val){
	ptr=document.frm1;
	len=ptr.elements.length;
	var i=0;
	for(i=0; i<len; i++){
		if (ptr.elements[i].name=='chkList'){
			ptr.elements[i].checked=val;
		}
	}
}
</script>

|;
}
############################################################
sub JsImage{
return qq|<script type="text/javascript">
function openwindow(myurl, mywidth, myheight)
{
window.open(myurl, "my_new_window","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width=mywidth,height=myheight")
}
</script>
|;
}
############################################################

1;
