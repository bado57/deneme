//email validate
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

//numara ve karekter konrtolü
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

//dizi karşılaştırma
function farkArray(a, b) {
    if (a.length > b.length) {
        var gelen = [], fark = [];
        for (var i = 0; i < b.length; i++)
            gelen[b[i]] = true;
        for (var i = 0; i < a.length; i++)
            if (!gelen[a[i]])
                fark.push(a[i]);
        return fark;
    } else {
        var gelen = [], fark = [];
        var lengtha = a.length;
        for (var i = 0; i < lengtha; i++)
            gelen[a[i]] = true;
        var lengthb = b.length;
        for (var i = 0; i < lengthb; i++)
            if (!gelen[b[i]])
                fark.push(b[i]);
        return fark;
    }
}