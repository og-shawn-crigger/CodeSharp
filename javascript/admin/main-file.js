function strip_tags(input, allowed) {
    // http://kevin.vanzonneveld.net
    // + original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + improved by: Luke Godfrey
    // + input by: Pul
    // + bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + bugfixed by: Onno Marsman
    // + input by: Alex
    // + bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + input by: Marc Palau
    // + improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + input by: Brett Zamir (http://brett-zamir.me)
    // + bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + bugfixed by: Eric Nagel
    // + input by: Bobby Drake
    // + bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + bugfixed by: Tomasz Wesolowski
    // + input by: Evertjan Garretsen
    // + revised by: Rafal Kukawski (http://blog.kukawski.pl/)
    // * example 1: strip_tags('<p>Kevin</p> <br /><b>van</b> <i>Zonneveld</i>', '<i><b>');
    // * returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
    // * example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>');
    // * returns 2: '<p>Kevin van Zonneveld</p>'
    // * example 3: strip_tags("<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>", "<a>");
    // * returns 3: '<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>'
    // * example 4: strip_tags('1 < 5 5 > 1');
    // * returns 4: '1 < 5 5 > 1'
    // * example 5: strip_tags('1 <br/> 1');
    // * returns 5: '1 1'
    // * example 6: strip_tags('1 <br/> 1', '<br>');
    // * returns 6: '1 1'
    // * example 7: strip_tags('1 <br/> 1', '<br><br/>');
    // * returns 7: '1 <br/> 1'
    allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
        return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
    });
}

function trim(str, charlist) {
    // http://kevin.vanzonneveld.net
    // + original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + improved by: mdsjack (http://www.mdsjack.bo.it)
    // + improved by: Alexander Ermolaev (http://snippets.dzone.com/user/AlexanderErmolaev)
    // + input by: Erkekjetter
    // + improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + input by: DxGx
    // + improved by: Steven Levithan (http://blog.stevenlevithan.com)
    // + tweaked by: Jack
    // + bugfixed by: Onno Marsman
    // * example 1: trim(' Kevin van Zonneveld ');
    // * returns 1: 'Kevin van Zonneveld'
    // * example 2: trim('Hello World', 'Hdle');
    // * returns 2: 'o Wor'
    // * example 3: trim(16, 1);
    // * returns 3: 6
    var whitespace, l = 0,
        i = 0;
    str += '';

    if (!charlist) {
        // default list
        whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    } else {
        // preg_quote custom list
        charlist += '';
        whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
    }

    l = str.length;
    for (i = 0; i < l; i++) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(i);
            break;
        }
    }

    l = str.length;
    for (i = l - 1; i >= 0; i--) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(0, i + 1);
            break;
        }
    }

    return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}

