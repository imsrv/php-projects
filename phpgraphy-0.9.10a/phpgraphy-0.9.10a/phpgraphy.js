
function switch_display(id)
{
        document.getElementById(id).style.display = (document.getElementById(id).style.display=='none') ? 'block' : 'none';
}


function isEmpty(id)
{

    if (document.getElementById(id).value == "") {
        return true
    } else {
        return false
    }
}

function checkUploadField(warningTxt)
{

    if (isEmpty('firstpicturefield')) {

        document.uploadfields.submit()

    } else {

        if(confirm(warningTxt)) {
            document.uploadfields.submit()
        }
    }

}

