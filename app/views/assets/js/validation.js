function ValidateEmail(inputText)
{
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (inputText.match(mailformat))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function alphanumeric(inputText)
{
    var letters = /^[0-9a-zA-Z]+$/;
    if (inputText.match(letters))
    {
        return true;
    }
    else
    {
        return false;
    }
}