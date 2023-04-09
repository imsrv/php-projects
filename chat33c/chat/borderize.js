// JavaScript Document
function borderize(what,color)
{
	what.style.borderColor = color;
}

function borderize_on(e)
{
	if (document.all)
		source3=event.srcElement;
	else if (document.getElementById)
		source3=e.target;

	if (source3.className=="fundo_careta")
	{
		borderize(source3,"#000000");
	}
	else
	{
		while(source3.tagName!="TABLE")
		{
			source3 = document.getElementById? source3.parentNode : source3.parentElement;
			if (source3.className=="fundo_careta")
				borderize(source3,"000000");
		}
	}
}

function borderize_off(e)
{
	if (document.all)
		source4 = event.srcElement;
	else if (document.getElementById)
		source4 = e.target;
	if (source4.className=="fundo_careta")
		borderize(source4,"white");
	else
	{
		while(source4.tagName!="TABLE")
		{
			source4 = document.getElementById? source4.parentNode : source4.parentElement;
			if (source4.className=="fundo_careta")
				borderize(source4,"white");
		}
	}
}