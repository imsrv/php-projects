function cimg(name,ov){
	if (document.images[name]){
		document.images[name].src = "<?=$urladdress?>/admin/images/interface/" + name + ((ov == 0)?"over":"") + ".gif";
	}
}