/*global clearInterval: false, clearTimeout: false, document: false, event: false, frames: false, history: false, Image: false, location: false, name: false, navigator: false, Option: false, parent: false, screen: false, setInterval: false, setTimeout: false, window: false, XMLHttpRequest: false, $: false */
// The Douglas Crockfords prototype trim method: http://javascript.crockford.com/remedial.html
if (!String.prototype.trim) {
    String.prototype.trim = function () {
        return this.replace(/^\s*(\S*(?:\s+\S+)*)\s*$/, "$1");
    };
}

// function taken from phpjs.org
// This is messy. Look at using a prototype approach as used for the trim above
// mysql datetime regex: /^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/
function date(format, timestamp) {
    // http://kevin.vanzonneveld.net
    // +   original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
    // +      parts by: Peter-Paul Koch (http://www.quirksmode.org/js/beat.html)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: MeEtc (http://yass.meetcweb.com)
    // +   improved by: Brad Touesnard
    // +   improved by: Tim Wiel
    // +   improved by: Bryan Elliott
    //
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: David Randall
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Theriault
    // +  derived from: gettimeofday
    // +      input by: majak
    // +   bugfixed by: majak
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Alex
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Theriault
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Theriault
    // +   improved by: Thomas Beaucourt (http://www.webapp.fr)
    // +   improved by: JT
    // +   improved by: Theriault
    // +   improved by: Rafal Kukawski (http://blog.kukawski.pl)
    // +   bugfixed by: omid (http://phpjs.org/functions/380:380#comment_137122)
    // +      input by: Martin
    // +      input by: Alex Wilson
    // %        note 1: Uses global: php_js to store the default timezone
    // %        note 2: Although the function potentially allows timezone info (see notes), it currently does not set
    // %        note 2: per a timezone specified by date_default_timezone_set(). Implementers might use
    // %        note 2: this.php_js.currentTimezoneOffset and this.php_js.currentTimezoneDST set by that function
    // %        note 2: in order to adjust the dates in this function (or our other date functions!) accordingly
    // *     example 1: date('H:m:s \\m \\i\\s \\m\\o\\n\\t\\h', 1062402400);
    // *     returns 1: '09:09:40 m is month'
    // *     example 2: date('F j, Y, g:i a', 1062462400);
    // *     returns 2: 'September 2, 2003, 2:26 am'
    // *     example 3: date('Y W o', 1062462400);
    // *     returns 3: '2003 36 2003'
    // *     example 4: x = date('Y m d', (new Date()).getTime()/1000); 
    // *     example 4: (x+'').length == 10 // 2009 01 09
    // *     returns 4: true
    // *     example 5: date('W', 1104534000);
    // *     returns 5: '53'
    // *     example 6: date('B t', 1104534000);
    // *     returns 6: '999 31'
    // *     example 7: date('W U', 1293750000.82); // 2010-12-31
    // *     returns 7: '52 1293750000'
    // *     example 8: date('W', 1293836400); // 2011-01-01
    // *     returns 8: '52'
    // *     example 9: date('W Y-m-d', 1293974054); // 2011-01-02
    // *     returns 9: '52 2011-01-02'
    var that = this,
        jsdate, f, formatChr = /\\?([a-z])/gi,
        formatChrCb,
        // Keep this here (works, but for code commented-out
        // below for file size reasons)
        //, tal= [],
        _pad = function (n, c) {
            if ((n = n + '').length < c) {
                return new Array((++c) - n.length).join('0') + n;
            }
            return n;
        },
        txt_words = ["Sun", "Mon", "Tues", "Wednes", "Thurs", "Fri", "Satur", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    formatChrCb = function (t, s) {
        return f[t] ? f[t]() : s;
    };
    f = {
        // Day
        d: function () { // Day of month w/leading 0; 01..31
            return _pad(f.j(), 2);
        },
        D: function () { // Shorthand day name; Mon...Sun
            return f.l().slice(0, 3);
        },
        j: function () { // Day of month; 1..31
            return jsdate.getDate();
        },
        l: function () { // Full day name; Monday...Sunday
            return txt_words[f.w()] + 'day';
        },
        N: function () { // ISO-8601 day of week; 1[Mon]..7[Sun]
            return f.w() || 7;
        },
        S: function () { // Ordinal suffix for day of month; st, nd, rd, th
            var j = f.j();
            return j < 4 | j > 20 && ['st', 'nd', 'rd'][j % 10 - 1] || 'th';
        },
        w: function () { // Day of week; 0[Sun]..6[Sat]
            return jsdate.getDay();
        },
        z: function () { // Day of year; 0..365
            var a = new Date(f.Y(), f.n() - 1, f.j()),
                b = new Date(f.Y(), 0, 1);
            return Math.round((a - b) / 864e5) + 1;
        },

        // Week
        W: function () { // ISO-8601 week number
            var a = new Date(f.Y(), f.n() - 1, f.j() - f.N() + 3),
                b = new Date(a.getFullYear(), 0, 4);
            return _pad(1 + Math.round((a - b) / 864e5 / 7), 2);
        },

        // Month
        F: function () { // Full month name; January...December
            return txt_words[6 + f.n()];
        },
        m: function () { // Month w/leading 0; 01...12
            return _pad(f.n(), 2);
        },
        M: function () { // Shorthand month name; Jan...Dec
            return f.F().slice(0, 3);
        },
        n: function () { // Month; 1...12
            return jsdate.getMonth() + 1;
        },
        t: function () { // Days in month; 28...31
            return (new Date(f.Y(), f.n(), 0)).getDate();
        },

        // Year
        L: function () { // Is leap year?; 0 or 1
            var j = f.Y();
            return j % 4 == 0 & j % 100 != 0 | j % 400 == 0;
        },
        o: function () { // ISO-8601 year
            var n = f.n(),
                W = f.W(),
                Y = f.Y();
            return Y + (n === 12 && W < 9 ? -1 : n === 1 && W > 9);
        },
        Y: function () { // Full year; e.g. 1980...2010
            return jsdate.getFullYear();
        },
        y: function () { // Last two digits of year; 00...99
            return (f.Y() + "").slice(-2);
        },

        // Time
        a: function () { // am or pm
            return jsdate.getHours() > 11 ? "pm" : "am";
        },
        A: function () { // AM or PM
            return f.a().toUpperCase();
        },
        B: function () { // Swatch Internet time; 000..999
            var H = jsdate.getUTCHours() * 36e2,
                // Hours
                i = jsdate.getUTCMinutes() * 60,
                // Minutes
                s = jsdate.getUTCSeconds(); // Seconds
            return _pad(Math.floor((H + i + s + 36e2) / 86.4) % 1e3, 3);
        },
        g: function () { // 12-Hours; 1..12
            return f.G() % 12 || 12;
        },
        G: function () { // 24-Hours; 0..23
            return jsdate.getHours();
        },
        h: function () { // 12-Hours w/leading 0; 01..12
            return _pad(f.g(), 2);
        },
        H: function () { // 24-Hours w/leading 0; 00..23
            return _pad(f.G(), 2);
        },
        i: function () { // Minutes w/leading 0; 00..59
            return _pad(jsdate.getMinutes(), 2);
        },
        s: function () { // Seconds w/leading 0; 00..59
            return _pad(jsdate.getSeconds(), 2);
        },
        u: function () { // Microseconds; 000000-999000
            return _pad(jsdate.getMilliseconds() * 1000, 6);
        },

        // Timezone
        e: function () { // Timezone identifier; e.g. Atlantic/Azores, ...
            // The following works, but requires inclusion of the very large
            // timezone_abbreviations_list() function.
            /*              return this.date_default_timezone_get();
             */
            throw 'Not supported (see source code of date() for timezone on how to add support)';
        },
        I: function () { // DST observed?; 0 or 1
            // Compares Jan 1 minus Jan 1 UTC to Jul 1 minus Jul 1 UTC.
            // If they are not equal, then DST is observed.
            var a = new Date(f.Y(), 0),
                // Jan 1
                c = Date.UTC(f.Y(), 0),
                // Jan 1 UTC
                b = new Date(f.Y(), 6),
                // Jul 1
                d = Date.UTC(f.Y(), 6); // Jul 1 UTC
            return 0 + ((a - c) !== (b - d));
        },
        O: function () { // Difference to GMT in hour format; e.g. +0200
            var tzo = jsdate.getTimezoneOffset(),
                a = Math.abs(tzo);
            return (tzo > 0 ? "-" : "+") + _pad(Math.floor(a / 60) * 100 + a % 60, 4);
        },
        P: function () { // Difference to GMT w/colon; e.g. +02:00
            var O = f.O();
            return (O.substr(0, 3) + ":" + O.substr(3, 2));
        },
        T: function () {
            return 'UTC';
        },
        Z: function () { // Timezone offset in seconds (-43200...50400)
            return -jsdate.getTimezoneOffset() * 60;
        },

        // Full Date/Time
        c: function () { // ISO-8601 date.
            return 'Y-m-d\\Th:i:sP'.replace(formatChr, formatChrCb);
        },
        r: function () { // RFC 2822
            return 'D, d M Y H:i:s O'.replace(formatChr, formatChrCb);
        },
        U: function () { // Seconds since UNIX epoch
            return jsdate / 1000 | 0;
        }
    };
    this.date = function (format, timestamp) {
        that = this;
        jsdate = (timestamp == null ? new Date() : // Not provided
        (timestamp instanceof Date) ? new Date(timestamp) : // JS Date()
        new Date(timestamp * 1000) // UNIX timestamp (auto-convert to int)
        );
        return format.replace(formatChr, formatChrCb);
    };
    return this.date(format, timestamp);
}


// test to see whether browser supports the HTML5 FileAPI
var fileAPI = {
    test: function () {
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            return true;
        }
    }
};

// top page object class
// branching for window.pageYOffset / document.documentElement.scrollTop
var TopMeasure = (function () {

    var $ie = {
        test: function () {
            return document.documentElement.scrollTop;
        }
    };

    var $nonIE = {
        test: function () {
            return window.pageYOffset;
        }
    };


    if ($nonIE.test() != undefined) {
        return $nonIE;
    } else {
        return $ie;
    }

})();

// function for setting opacity for both IE and non IE
function setOpacity(obj, value) {
    obj.style.opacity = value / 10;
    obj.style.filter = 'alpha(opacity=' + value * 10 + ')';
}

// elegant alert script below (https://github.com/TCotton/Elegant-Alert)
var NewAlert = {
    // this class is to replace the standard javascript alert box
    // declare attributes at the top
    nodeAlert: null,
    stepCount: 0,
    time: 100,
    fade: null,
    data: null,
    run: null,

    alertCheck: function () {

        var bodyChildren, len, x, first, newData;
        bodyChildren = document.body.childNodes;

        x = 0;

        for (len = bodyChildren.length; x < len; x += 1) {

            // Checks to make sure that the alert is not run twice until after
            // it has finished
            if (bodyChildren[x].nodeType === 1 && bodyChildren[x].className === "elegant-alertxyz") {
                // loops through entire body nodes to make sure class 'elegant-alertxyz' is not already present
                NewAlert.run = 1;
                break;
            }
        } // end for loop
        // if animation is not already running then run method alertWrap
        if (NewAlert.run !== 1) {
            NewAlert.alertWrap();
        }
    },

    // Create error HTML with alertWrap
    alertWrap: function (value) {

        // create element with class name alert
        // add value of attribute and append to the body
        NewAlert.nodeAlert = document.createElement("div");
        NewAlert.nodeAlert.className = "elegant-alertxyz";
        NewAlert.nodeAlert.innerHTML = NewAlert.data;
        document.body.appendChild(NewAlert.nodeAlert);
        NewAlert.nodeAlert.style.top = TopMeasure.test() + "px";
        NewAlert.alertFade();
    },

    // use alertFade to create the fade out opacity effect
    alertFade: function (value2) {

        // alertWrap method;
        setOpacity(NewAlert.nodeAlert, 10);

        NewAlert.fade = setInterval(function () {

            // Set opacity for non-IE browsers
            NewAlert.nodeAlert.style.opacity = parseFloat(NewAlert.nodeAlert.style.opacity) - parseFloat(0.01);
            //Set opacity for IE browsers
            NewAlert.nodeAlert.style.filter = "alpha(opacity=" + (NewAlert.time - NewAlert.stepCount) + ")";
            NewAlert.stepCount += 1;

            if (NewAlert.stepCount >= NewAlert.time) {

                clearInterval(NewAlert.fade);
                // destroy node after it has finished fading into nothing
                document.body.removeChild(NewAlert.nodeAlert);
                // stepCount attribute needs to be reset back to 0
                NewAlert.stepCount = 0;
                // reset back to null
                NewAlert.run = null;
            }
        }, NewAlert.time);
    },

    init: function (data) {

        // Place data into data attribute
        if (data.constructor === Array) {

            x = 0;
            newData = [];
            for (len = data.length; x < len; x += 1) {
                newData.push("<br />" + data[x])
            }
            NewAlert.data = String(newData);

        } else {

            NewAlert.data = data;
        }

        // Run alertCheck method
        NewAlert.alertCheck();

    }
};

// function for reseting form values to zero after successful form submission
function reset_value(form) {

    var i, len;
    i = 0;

    //loop through form elements to make sure text and textarea are not empty
    for (len = form.length; i < len; i += 1) {
        if (form[i].type === "text" || form[i].type === "textarea") {
            form[i].value = "";
        } // end if text or textarea
    }
}


// fading form values after successful submission
function fade_value(form) {

    var i, len;
    i = 0;

    //loop through form elements to make sure text and textarea are not empty
    for (len = form.length; i < len; i += 1) {
        $(form[i]).css({
            opacity: 0.3
        });
    }
}


function addEvent(el, type, fn) {

    if (window.addEventListener) {
        el.addEventListener(type, fn, false);
    } else if (window.attachEvent) {
        el.attachEvent('on' + type, fn);
    } else {
        el['on' + type] = fn;
    }
}

// declare the global namespace
var CS = window.CS || {};

//Validation rules below
CS.Validation = {

    i: null,
    len: null,
    error: null,
    result: null,
    image: null,
    ext: null,
    imageError: null,

    Min: function (value, obj, msg) {

        //check to see if whole form has been entered as a value
        //or a single form value as string
        if (value.constructor === Object) {
            CS.Validation.i = 0;
            var elems = value;
            //loop through form elements to make sure text and textarea are not empty
            for (CS.Validation.len = elems.length; CS.Validation.i < CS.Validation.len; CS.Validation.i += 1) {
                if (elems[CS.Validation.i].type === "text" || elems[CS.Validation.i].type === "textarea") {
                    if (!elems[CS.Validation.i].value.length) {
                        obj.push("\nPlease make sure that no required fields are left empty");
                        break;
                    } // if value < 1
                } // end if text or textarea
            } // end for statement
        } else if (value.constructor === String) {
            if (value.length < 1) {
                obj.push("\n" + msg);
            }

        } else {
            // error message for webmasters only
            alert("Webmaster error: Please enter the right value for Validator.Min");
        } // end if value.constructor 
    },

    Max: function (value, obj, number, msg) {

        //number = number || null;
        if (value.constructor !== String || msg.constructor !== String || number.constructor !== Number) {
            // error message for webmasters only
            alert("Webmaster error: Please enter the right value for Validator.Max");
        } else {
            if (value.length > number) {
                obj.push("\n" + msg);
            } // end if
        } //end if constructor
    },

    Email: function (email, obj) {

        var re = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;

        if (!re.test(email)) {
            obj.push("\n" + "Please make sure you supply a valid email address");
        }
    },

    Image: function (value, obj) {

        // the valueos of all the file fields
        // Below checks to make sure that uploaded file is an image
        CS.Validation.image = [".jpeg", ".jpg", ".png", ".gif"];
        CS.Validation.i = 0;
        // find extension of file
        CS.Validation.ext = value.slice(value.indexOf(".")).toLowerCase();
        // loop through file extentiong above and then see if it fits what the user has updated
        for (CS.Validation.len = CS.Validation.image.length; CS.Validation.i < CS.Validation.len; CS.Validation.i += 1) {
            if (CS.Validation.ext === CS.Validation.image[CS.AddNode.i]) {
                CS.Validation.imageError = null;
                break;
            } else {
                if (CS.AddNode.fileField !== "") {
                    CS.AddNode.imageError = 1;
                }
            } // else
        } // end for loop
        // if the file is not an image then produce an error message and attached it to the error array
        if (CS.AddNode.imageError === 1) {
            obj.push("\nPlease make sure you only upload an image");
        }
    }

};


// used for ajax calls
CS.Json = (function () {

    // private attributes if any here
    var objX, formMethod;
    // private methods if any here
    // public attribute and methods below
    return {

        //public attributes
        objX: null,
        jsonData: null,

        //public methods
        getJson: function (url, callback) {

            objX = new XMLHttpRequest();

            if (objX !== null) {
                // use CodeIgniter function base_url to find absolute path to json file
                objX.open("GET", url, true);

                objX.onreadystatechange = function () {

                    //if readyState is not 4 or or status not 200 then there is a problem that needs attending
                    if (objX.readyState === 4) {
                        if (objX.status === 200) {

                            CS.Json.jsonData = eval("(" + objX.responseText + ")"); //take result as an JavaScript object
                            callback(CS.Json.jsonData);
                        } else {

                            alert('HTTP error ' + objX.status);
                        } // end if status === 200
                    } // end if readstate === 4
                };

                objX.send();

            } else {

                alert("You do not have AJAX implemented on your browser, sorry.");

            } //CS.Json.objX 
        },
        // end getJson
        sendJson: function (data, url) {

            //process form
            objX = new XMLHttpRequest();

            objX.open('POST', url, true);
            objX.setRequestHeader('User-Agent', 'XMLHTTP/1.0');
            objX.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            objX.onreadystatechange = function () {

                if (objX.readyState !== 4) {

                    if (objX.status !== 200 && objX.status !== 304) {
                        alert('HTTP error ' + objX.status);
                        return false;
                    }
                }
            };

            objX.send(data);

        }

    }; // end return
})(); // end
// submission for global settings
CS.GlobalSet = (function () {

    // private attributes if any here
    var i, metaD, metaK, errorLevel, errorReport, errorM, data;

    // private methods if any here
    // public attribute and methods below
    return {

        //public attributes
        nameForm: null,
        sloganForm: null,
        emailForm: null,
        metaDescription: null,
        metaKeywords: null,
        errorReporting: null,
        errorLevel: null,
        errorEmail: null,
        errors: null,
        form: null,
        siteUrl: null,

        //public methods
        handleSubmit: function () {


            // set error attribute as an array
            CS.GlobalSet.errors = [];
            // dCS.GlobalSeteclare form values
            CS.GlobalSet.nameForm = this.nameForm.value.trim();
            CS.GlobalSet.sloganForm = this.sloganForm.value.trim();
            CS.GlobalSet.emailForm = this.emailForm.value.trim();
            CS.GlobalSet.metaDescription = this.metaDescription;
            CS.GlobalSet.metaKeywords = this.metaKeywords;
            CS.GlobalSet.errorReporting = this.errorReporting;
            CS.GlobalSet.errorLevel = this.errorLevel.value;
            CS.GlobalSet.errorEmail = this.errorEmail;

            // metadescription value
            for (i = 0; i < CS.GlobalSet.metaDescription.length; i += 1) {
                if (CS.GlobalSet.metaDescription[i].checked == true && CS.GlobalSet.metaDescription[i].value === "1") {
                    // determines whether the item should be published
                    metaD = "1";
                } else {
                    metaD = "0";
                } // end if
            } // end for loop
            // metakeywords value
            for (i = 0; i < CS.GlobalSet.metaKeywords.length; i += 1) {
                if (CS.GlobalSet.metaKeywords[i].checked == true && CS.GlobalSet.metaKeywords[i].value === "1") {
                    // determines whether the item should be published
                    metaK = "1";
                } else {
                    metaK = "0";
                } // end if
            } // end for loop
            //errorreporting value
            for (i = 0; i < CS.GlobalSet.errorReporting.length; i += 1) {
                if (CS.GlobalSet.errorReporting[i].checked == true && CS.GlobalSet.errorReporting[i].value === "1") {
                    // determines whether the item should be published
                    errorReport = "1";
                } else {
                    errorReport = "0";
                } // end if
            } // end for loop
            //sent email error
            for (i = 0; i < CS.GlobalSet.errorEmail.length; i += 1) {
                if (CS.GlobalSet.errorEmail[i].checked == true && CS.GlobalSet.errorEmail[i].value === "1") {
                    // determines whether the item should be published
                    errorM = "1";
                } else {
                    errorM = "0";
                } // end if
            } // end for loop
            // validation
            CS.Validation.Min(this.elements, CS.GlobalSet.errors);
            CS.Validation.Max(CS.GlobalSet.nameForm, CS.GlobalSet.errors, 100, "Opps, the title field is too long");
            CS.Validation.Max(CS.GlobalSet.sloganForm, CS.GlobalSet.errors, 250, "Opps, the title field is too long");
            CS.Validation.Max(CS.GlobalSet.emailForm, CS.GlobalSet.errors, 50, "Opps, the title field is too long");
            CS.Validation.Email(CS.GlobalSet.emailForm, CS.GlobalSet.errors);

            CS.GlobalSet.validData(CS.GlobalSet.errors);

            // stop form from being processed
            return false;

        },

        validData: function (error) {
            // for the legacy browsers just run the php form if no errors are produced
            if (error.length === 0) {

                data = 'nameForm=' + encodeURIComponent(CS.GlobalSet.nameForm) + '&sloganForm=' + encodeURIComponent(CS.GlobalSet.sloganForm) + '&emailForm=' + encodeURIComponent(CS.GlobalSet.emailForm) + '&metaDescription=' + metaD + '&metaKeywords=' + metaK + '&errorReporting=' + errorReport + '&errorLevel=' + CS.GlobalSet.errorLevel + '&errorEmail=' + errorM + '&r=' + Math.random();
                CS.Json.sendJson(data, CS.GlobalSet.siteUrl + 'admin-config/submit-form');
                NewAlert.init("The settings have been updated");

                //process form
                //return this.submit();
                return false;
            } else {
                // If there are errors in the form then run alert message
                NewAlert.init(error);
                //stop form from being processed
                return false;
            }

        },

        init: function (siteUrl) {

            if (document.forms.submitVarious) {

                CS.GlobalSet.siteUrl = siteUrl;
                document.forms.submitVarious.onsubmit = CS.GlobalSet.handleSubmit;
                // on submit run handeSubmit method
            } // end undefined
        } // end init()
    }; // end return
})(); // end CS.AddNode

// submission of admin_edit_content.php
// Needs further work on the File API
CS.EditNode = (function () {

    // private attributes if any here
    var form;
    // private methods if any here
    function _isValidDateTime(str) {
        // function tests to see whether inputed date is correctly formatted
        var regEx;
        regEx = /^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/;
        return regEx.test(str);
    }

    // public attribute and methods below
    return {

        //public attributes
        formText: null,
        titleField: null,
        catField: null,
        bodyField: null,
        descField: null,
        keyField: null,
        publishField: null,
        fileField: null,
        dateField: null,
        error: null,
        form: null,
        siteUrl: null,

        //public methods
        handleSubmit: function () {

            // set error attribute as an array
            CS.EditNode.error = [];

            form = document.forms['adminEditContent'];


            // declare form values
            CS.EditNode.fileField = form.file_upload.value;
            CS.EditNode.titleField = form.title.value.trim();
            CS.EditNode.catField = form.select.value.trim();
            CS.EditNode.bodyField = form.body.value.trim();
            CS.EditNode.publishField = form.publish;

            if (form.metaDescription) {
                CS.EditNode.descField = form.metaDescription.value.trim();
                CS.Validation.Max(CS.EditNode.descField, CS.EditNode.error, 255, "Opps, the meta description field is too long");
            }

            if (form.metaKeywords) {
                CS.EditNode.keyField = form.metaKeywords.value.trim();
                CS.Validation.Max(CS.EditNode.descField, CS.EditNode.error, 255, "Opps, the meta description field is too long");
            }

            CS.EditNode.dateField = form.date.value.trim();

            //make sure submitted date is correctly formatted
            if (!_isValidDateTime(CS.EditNode.dateField)) {
                CS.EditNode.error.push("\nThe date format is incorrent. Please makes sure it is exactly the same format as: " + date("Y-m-d H:i:s", Math.round(new Date().getTime() / 1000)));
            }

            CS.Validation.Min(form.elements, CS.EditNode.error);

            CS.Validation.Max(CS.EditNode.titleField, CS.EditNode.error, 100, "Opps, the title field is too long");

            if (CS.EditNode.fileField !== "") { // if statement needs to be placed into Image method
                CS.Validation.Image(CS.EditNode.fileField, CS.EditNode.error);
            }

            // add error messag end input values in the total array for use in validData
            // check whether HTML5 fileAPI is working on the browser
            if (fileAPI.test()) {
                // if yes go to fileAPI function
                CS.EditNode.fileAPI(CS.EditNode.error);
            } else {
                // if not go straight to validData function
                CS.EditNode.validData(CS.EditNode.error);
            }

            // stop form from being processed
            return false;

        },

        fileAPI: function (error) {

            if (document.getElementById("file_upload").files[0]
            //add below when all the system is working well
            //&& error.length !== 0
            ) {
                if (document.getElementById("file_upload").files[0].size > 1024000) {
                    error.push("\nSorry, the image you uploaded is too large");
                } // end if image size
            } // end of file_upload has file
            CS.EditNode.validData(error);
            //stop form from being processed
            return false;

        },

        validData: function (error) {
            // for the legacy browsers just run the php form if no errors are produced
            if (error.length === 0) {
                //process form
                CS.EditNode.Form.submit();
            } else {
                // If there are errors in the form then run alert message
                NewAlert.init(error);
                //stop form from being processed
                return false;
            }

        },

        deleteNode: function () {


            if (confirm("Delete this article?")) {

                // this nifty little piece of code finds the number in the third segment of the url
                data = "delete_this=" + window.location.href.substr(window.location.href.lastIndexOf('/') + 1) + "&r=" + Math.random();

                CS.Json.sendJson(data, CS.EditNode.siteUrl + 'admin-edit-content/delete-content');
                
                //After successful form submission then disable submit buttons and fade all form fields
                NewAlert.init("The article has been deleted");
                document.forms[0].submitNode.disabled = true;
                document.forms[0].deteteNode.disabled = true;
                fade_value(document.forms['adminEditContent'].elements)

            } // end if confirm
            return false;
        },

        init: function (siteUrl) {

            if (document.forms.adminEditContent) {

                CS.EditNode.siteUrl = siteUrl;

                $(document.forms['adminEditContent'].elements['submitNode']).click(function () {
                    CS.EditNode.handleSubmit();
                    return false;
                });

                $(document.forms['adminEditContent'].elements['deteteNode']).click(function () {
                    CS.EditNode.deleteNode();
                    return false;
                });

                // on submit run handeSubmit method
            } // end undefined
        } // end init()
    }; // end return
})(); // end CS.EditNode

// submission of admin_new_content.php
// Needs further work on the File API
CS.AddNode = (function () {

    // private attributes if any here
    var i;

    // private methods if any here
    // public attribute and methods below
    return {

        //public attributes
        formText: null,
        titleField: null,
        catField: null,
        bodyField: null,
        descField: null,
        keyField: null,
        publishField: null,
        fileField: null,
        error: null,
        form: null,

        //public methods
        handleSubmit: function () {

            // set error attribute as an array
            CS.AddNode.error = [];
            // declare form values
            CS.AddNode.fileField = this.file_upload.value;
            CS.AddNode.titleField = this.title.value.trim();
            CS.AddNode.catField = this.select.value.trim();
            CS.AddNode.bodyField = this.body.value.trim();
            CS.AddNode.publishField = this.publish;

            if (this.metaDescription) {
                CS.AddNode.descField = this.metaDescription.value.trim();
                CS.Validation.Max(CS.AddNode.descField, CS.AddNode.error, 255, "Opps, the meta description field is too long");
            }

            if (this.metaKeywords) {
                CS.AddNode.keyField = this.metaKeywords.value.trim();
                CS.Validation.Max(CS.AddNode.keyField, CS.AddNode.error, 255, "Opps, the meta keyword field is too long");
            }

            CS.Validation.Min(this.elements, CS.AddNode.error);
            CS.Validation.Max(CS.AddNode.titleField, CS.AddNode.error, 100, "Opps, the title field is too long");

/*

            // assign a value whether the article is to be published or not
            for (i = 0; i < CS.AddNode.publishField.length; i += 1) {
                if (CS.AddNode.publishField[i].checked == true && CS.AddNode.publishField[i].value === "1") {
                    // determines whether the item should be published
                    publish = "1";
                } else {
                    publish = "0";
                } // end if
            } // end for loop
            */

            CS.Validation.Image(CS.AddNode.fileField, CS.AddNode.error);

            // add error messag end input values in the total array for use in validData
            // check whether HTML5 fileAPI is working on the browser
            if (fileAPI.test()) {
                // if yes go to fileAPI function
                CS.AddNode.fileAPI(CS.AddNode.error);
            } else {
                // if not go straight to validData function
                CS.AddNode.validData(CS.AddNode.error);
            }
            // stop form from being processed
            return false;

        },

        fileAPI: function (error) {

            if (document.getElementById("file_upload").files[0]
            //add below when all the system is working well
            //&& error.length !== 0
            ) {
                if (document.getElementById("file_upload").files[0].size > 1024000) {
                    error.push("\nSorry, the image you uploaded is too large");
                } // end if image size
            } // end of file_upload has file
            CS.AddNode.validData(error);
            //stop form from being processed
            return false;

        },

        validData: function (error) {
            // for the legacy browsers just run the php form if no errors are produced
            if (error.length === 0) {
                //process form
                return this.submit();
            } else {
                // If there are errors in the form then run alert message
                NewAlert.init(error);
                //stop form from being processed
                return false;
            }

        },

        init: function () {

            if (document.forms.adminAddContent) {

                document.forms.adminAddContent.onsubmit = CS.AddNode.handleSubmit;
                // on submit run handeSubmit method
            } // end undefined
        } // end init()
    }; // end return
})(); // end CS.AddNode
/*
 JavaScript form submission for admin_category - adding a new category
 */
CS.AddCategory = (function () {

    // private attributes if any here
    var objX, i, publish, random, data, form;
    // private methods if any here
    // public attribute and methods below
    return {

        //public attributes
        titleField: null,
        form: null,
        error: null,
        publishField: null,
        cJson: null,

        //public methods
        handleSubmit: function () {

            // set error attribute as an array
            CS.AddCategory.error = [];
            
            form = this;

            // declare form values
            CS.AddCategory.titleField = this.nameAdd.value.trim();
            CS.AddCategory.publishField = this.publishAdd;

            if (!CS.AddCategory.titleField) {

                CS.AddCategory.error.push("\nPlease don't leave any fields empty");

            }
            if (CS.AddCategory.titleField.length > 40) {

                CS.AddCategory.error.push("\nNo more than 40 characters");

            }

            // assign a value whether the article is to be published or not
            for (i = 0; i < CS.AddCategory.publishField.length; i += 1) {
                if (CS.AddCategory.publishField[i].checked == true && CS.AddCategory.publishField[i].value === "1") {
                    // determines whether the item should be published
                    publish = "1";
                } else {
                    publish = "0";
                } // end if
            } // end for loop
            CS.AddCategory.validData(CS.AddCategory.error);
            // stop form from being processed
            return false;

        },

        validData: function (error) {
            // for the legacy browsers just run the php form if no errors are produced
            if (error.length === 0) {

                data = 'nameAdd=' + encodeURIComponent(CS.AddCategory.titleField) + '&publishAdd=' + publish + '&r=' + Math.random();
                CS.Json.sendJson(data, CS.AddCategory.cJson + 'admin-category/add-category');

                NewAlert.init("New category created");
                reset_value(form.elements);
                location.reload(true);

            } else {
                // If there are errors in the form then run alert message
                NewAlert.init(error);
                //stop form from being processed
                return false;
            }

        },

        init: function (url) {

            if (document.forms.addCategory) {

                CS.AddCategory.cJson = url;
                document.forms.addCategory.onsubmit = CS.AddCategory.handleSubmit;
                // on submit run handeSubmit method
            } // end undefined
        } // end init()
    }; // end return
})(); // end CS.EditNode
CS.AddMenu = (function () {
    // private attributes if any here
    var objX, i, publish, random, data, key, duplicate, numStr;
    // private methods if any here
    function check_duplicate(callback) {

        CS.Json.getJson(CS.AddMenu.getJ + "json/" + "menu" + ".json", function (result) {
            CS.AddMenu.duplicate = [];
            for (key in result) {
                // loop through JSON object
                if (result.hasOwnProperty(key)) {
                    // check to make sure that the meny name is unique
                    if (CS.AddMenu.nameAdd.toLowerCase() === result[key].name.toLowerCase()) {
                        CS.AddMenu.duplicate.push(1);
                        break;
                    } else {
                        CS.AddMenu.duplicate.push(0);
                    }
                } // end if statment
            } // end for loop
            callback(CS.AddMenu.duplicate);
        });
    }

    // public attribute and methods below
    return {

        //public attributes
        nameAdd: null,
        urlAdd: null,
        publishAdd: null,
        error: null,
        duplicate: null,
        form: null,
        getJ: null,
        createJ: null,
        elements: null,

        handleSubmit: function () {

            CS.AddMenu.error = [];

            CS.AddMenu.elements = this.elements;

            // declare form values
            CS.AddMenu.nameAdd = this.nameAdd.value.trim();
            CS.AddMenu.urlAdd = this.urlAdd.value.trim();
            CS.AddMenu.publishAdd = this.publishAdd;

            CS.Validation.Max(CS.AddMenu.nameAdd, CS.AddMenu.error, 40, "Opps, the name field field is too long. A maximum of 40 characters only");
            CS.Validation.Max(CS.AddMenu.urlAdd, CS.AddMenu.error, 100, "Opps, the name url field is too long. A maximum of 100 characters only");
            CS.Validation.Min(this.elements, CS.AddMenu.error, "Please make sure you don't leave any fields empty");

            // assign a value whether the article is to be published or not
            for (i = 0; i < CS.AddMenu.publishAdd.length; i += 1) {
                if (CS.AddMenu.publishAdd[i].checked == true && CS.AddMenu.publishAdd[i].value === "1") {
                    // determines whether the item should be published
                    publish = "1";
                } else {
                    publish = "0";
                } // end if
            } // end for loop
            check_duplicate(function (result) {

                numStr = "1";

                if (result.toString().indexOf(numStr) != -1) {
                    CS.AddMenu.error.push("\nPlease make sure that the name field is unique");
                    CS.AddMenu.validData(CS.AddMenu.error);
                } else {
                    CS.AddMenu.validData(CS.AddMenu.error);
                }
            });

            return false;
        },

        validData: function (error) {

            if (error.length === 0) {

                data = 'nameAdd=' + encodeURIComponent(CS.AddMenu.nameAdd) + '&urlAdd=' + encodeURIComponent(CS.AddMenu.urlAdd) + '&publishAdd=' + publish + '&r=' + Math.random();
                CS.Json.sendJson(data, CS.AddMenu.createJ + 'admin-menu/menu-add');
                NewAlert.init("New menu item created");
                reset_value(CS.AddMenu.elements);
                location.reload(true);

            } else {
                // If there are errors in the form then run alert message
                NewAlert.init(error);
                //stop form from being processed
            }
            return false;
        },

        init: function (url1, url2) {

            if (document.forms.addMenu) {

                CS.AddMenu.getJ = url1;
                CS.AddMenu.createJ = url2;

                document.forms.addMenu.onsubmit = CS.AddMenu.handleSubmit;

                // on submit run handeSubmit method
            } // end undefined
        } // end init()
    }; // end return
})(); // end CS.EditNode
// form submission for menu order
CS.MenuOrder = (function () {
    // private attributes if any here
    var i;
    // private methods if any here
    // public attribute and methods below
    return {

        //public attributes
        error: null,
        handleSubmit: function () {

            CS.MenuOrder.error = [];

            for (i = 0; i < this.elements.length; i += 1) {
                if (this.elements[i].type === "text") {
                    if (!this.elements[i].value.length || this.elements[i].value.length > 2 || isNaN(parseFloat(this.elements[i].value))) {
                        CS.MenuOrder.error.push("\nPlease make sure that it is only a one or two digit number");
                        break;
                    }
                } // end if statement
            } // end for loop
            CS.MenuOrder.validData(CS.MenuOrder.error);
            return false;
        },

        validData: function (error) {

            if (error.length === 0) {
                return this.submit();
            } else {
                // If there are errors in the form then run alert message
                NewAlert.init(error);
                return false;
                //stop form from being processed
            }
        },

        init: function () {

            if (document.forms.menuOrder) {

                document.forms.menuOrder.onsubmit = CS.MenuOrder.handleSubmit;
                // on submit run handeSubmit method
            } // end undefined
        } // end init()
    }; // end return
})(); // end CS.menuOrder
CS.AddUser = (function () {
    // private attributes if any here
    var i, publish, data;
    // private methods if any here
    //process form
    function checkdup_email(callback) {

        //start the ajax to check for duplicate emails or usernames
        $.ajax({
            //this is the php file that processes the data and send mail
            url: CS.AddUser.createJ + "admin-user/email-ajax-check",
            //GET method is used
            type: "GET",
            //pass the data
            data: "emailAdd=" + CS.AddUser.emailAdd,
            dataType: "text",
            async: false,
            // data type
            // dataType: "text",
            //Do not cache the page
            cache: false,
            //success
            success: function (html) {

                callback(html);

            } // end success function
        }); // ajax requies
    }

    function checkdup_username(callback) {

        //start the ajax to check for duplicate emails or usernames
        $.ajax({
            //this is the php file that processes the data and send mail
            url: CS.AddUser.createJ + "admin-user/username-ajax-check",
            //GET method is used
            type: "GET",
            //pass the data
            data: "usernameAdd=" + CS.AddUser.usernameAdd,
            dataType: "text",
            async: false,
            // data type
            // dataType: "text",
            //Do not cache the page
            cache: false,
            //success
            success: function (html) {

                callback(html);

            } // end success function
        }); // ajax requies
    }

    // public attribute and methods below
    return {

        //public attributes
        usernameAdd: null,
        passwordAdd: null,
        passwordTwoAdd: null,
        emailAdd: null,
        emailTwoAdd: null,
        adminRightsAdd: null,
        error: null,
        message: null,
        createJ: null,
        formElements: null,

        handleSubmit: function () {

            CS.AddUser.error = [];

            CS.AddUser.formElements = this.elements;

            // declare form values
            CS.AddUser.usernameAdd = this.usernameAdd.value.trim();
            CS.AddUser.passwordAdd = this.passwordAdd.value.trim();
            CS.AddUser.passwordTwoAdd = this.passwordTwoAdd.value.trim();
            CS.AddUser.emailAdd = this.emailAdd.value.trim();
            CS.AddUser.emailTwoAdd = this.emailTwoAdd.value.trim();

            CS.AddUser.adminRightsAdd = this.adminRightsAdd;

            CS.Validation.Max(CS.AddUser.usernameAdd, CS.AddUser.error, 30, "Opps, the username field field is too long. A maximum of 30 characters only");
            CS.Validation.Max(CS.AddUser.passwordAdd, CS.AddUser.error, 40, "Opps, the passwordd field field is too long. A maximum of 40 characters only");
            CS.Validation.Max(CS.AddUser.emailAdd, CS.AddUser.error, 50, "Opps, the name url field is too long. A maximum of 50 characters only");
            CS.Validation.Min(this.elements, CS.AddUser.error, "Please make sure you don't leave any fields empty");

            if (CS.AddUser.passwordAdd && CS.AddUser.passwordTwoAdd) {
                if (CS.AddUser.passwordAdd !== CS.AddUser.passwordTwoAdd) {
                    CS.AddUser.error.push("\nPlease make sure that the passwords are exactly the same");
                }
            }

            if (CS.AddUser.emailAdd && CS.AddUser.emailTwoAdd) {
                if (CS.AddUser.emailAdd !== CS.AddUser.emailTwoAdd) {
                    CS.AddUser.error.push("\nPlease make sure that the email addresses are exactly the same");
                } else {
                    CS.Validation.Email(CS.AddUser.emailAdd, CS.AddUser.error);
                }
            }

            // assign a value whether the article is to be published or not
            for (i = 0; i < CS.AddUser.adminRightsAdd.length; i += 1) {
                if (CS.AddUser.adminRightsAdd[i].checked == true && CS.AddUser.adminRightsAdd[i].value === "1") {
                    // determines whether the item should be published
                    publish = "1";
                } else {
                    publish = "0";
                } // end if
            } // end for loop
            checkdup_email(function (result) {

                if (result == true) {
                    CS.AddUser.error.push("\nSorry, this email address has already been used by another user. Please use a different email addresss.");
                }
            });

            checkdup_username(function (result) {

                if (result == true) {
                    CS.AddUser.error.push("\nSorry, the username has already been used by another user. Please pick another one.");
                }
            });

            CS.AddUser.validData(CS.AddUser.error);

            return false;
        },

        validData: function (error) {

            if (error.length === 0) {

                data = 'usernameAdd=' + encodeURIComponent(CS.AddUser.usernameAdd) + '&passwordAdd=' + encodeURIComponent(CS.AddUser.passwordAdd) + '&passwordTwoAdd=' + encodeURIComponent(CS.AddUser.passwordTwoAdd) + '&emailAdd=' + encodeURIComponent(CS.AddUser.emailAdd) + '&emailTwoAdd=' + encodeURIComponent(CS.AddUser.emailTwoAdd) + '&adminRightsAdd=' + publish + '&r=' + Math.random();

                CS.Json.sendJson(data, CS.AddUser.createJ + 'admin-user/add-user');
                NewAlert.init("New user created");
                reset_value(CS.AddUser.formElements);
                location.reload(true);

            } else {
                // If there are errors in the form then run alert message
                NewAlert.init(error);
                return false;
                //stop form from being processed
            }
        },

        init: function (url) {

            if (document.forms.addUser) {

                CS.AddUser.createJ = url;
                document.forms.addUser.onsubmit = CS.AddUser.handleSubmit;

                // on submit run handeSubmit method
            } // end undefined
        } // end init()
    }; // end return
})(); // end CS.EditNode
CS.EditItem = (function () {

    // private attributes if any here
    var number, catPublish, i, textZone, textZoneValue, form, inputCollection, key, publish, answer;
    // private methods if any here
    function checkdup_email(callback) {

        //start the ajax to check for duplicate emails or usernames
        $.ajax({
            //this is the php file that processes the data and send mail
            url: CS.AddUser.createJ + "admin-user/email-ajax-check",
            //GET method is used
            type: "GET",
            //pass the data
            data: "emailAdd=" + encodeURIComponent(CS.EditItem.emailEditOne) + "&currentEmail=" + encodeURIComponent(CS.EditItem.currentEmail),
            dataType: "text",
            async: false,
            // data type
            // dataType: "text",
            //Do not cache the page
            cache: false,
            //success
            success: function (html) {

                callback(html);

            } // end success function
        }); // ajax requies
    }

    function checkdup_username(callback) {

        //start the ajax to check for duplicate emails or usernames
        $.ajax({
            //this is the php file that processes the data and send mail
            url: CS.AddUser.createJ + "admin-user/username-ajax-check",
            //GET method is used
            type: "GET",
            //pass the data
            data: "usernameAdd=" + encodeURIComponent(CS.EditItem.usernameOne) + "&currentUsername=" + encodeURIComponent(CS.EditItem.currentUsername),
            dataType: "text",
            async: false,
            // data type
            // dataType: "text",
            //Do not cache the page
            cache: false,
            //success
            success: function (html) {

                callback(html);

            } // end success function
        }); // ajax requies
    }

    // public attribute and methods below
    return {

        //public attributes
        objX: null,
        key: null,
        jsonData: null,
        catName: null,
        menuName: null,
        menuURL: null,
        usernameOne: null,
        emailEditOne: null,
        emailEditTwo: null,
        passwordOne: null,
        passwordTwo: null,
        adminRights: null,
        currentEmail: null,
        currentUsername: null,
        error: null,
        id: null,
        form: null,
        siteUrl: null,
        //public methods
        category: function (category, url) {

            CS.Json.getJson(url + "json/" + category + ".json", function (result) {

                // category edit submission here
                /**
                 * THIS SUDDENTLY JUMPS TO PROCEDURAL PROGRAMMING. THIS IS BECAUSE OF AN ISSUE IN THE PHP CODE THAT NEEDS ADDRESSING
                 */

                for (key in result) {
                    // loop through JSON object
                    if (result.hasOwnProperty(key)) {

                        form = document.forms['adminAddCategory' + result[key].id];

                        //use jQuery animation to hide the category forms
                        $('#category-block-' + result[key].id + ' fieldset').hide();
                        $('.category-title').css('cursor', 'pointer');
                        $('#category-block-' + result[key].id).click(function () {
                            $(this).find("fieldset").show(1000);
                            $('.category-title').css('cursor', 'default');
                        });

                        textZone = form.elements['name' + result[key].id];

/*
                     Change values of form text inline with changing the value of the name input element
                     */
                        textZone.onkeyup = function () {

                            textZoneValue = this.value.trim();

                            // changes form values - need to check in IE, lol
                            this.previousSibling.innerHTML = "Name: " + textZoneValue;
                            this.previousSibling.previousSibling.previousSibling.innerHTML = "<span>Edit: " + textZoneValue + "</span>";
                            this.parentNode.parentNode.previousSibling.innerHTML = textZoneValue;

                        }

                        $(document.forms['adminAddCategory' + result[key].id].elements['delete' + result[key].id]).click(function () {

                            number = this.name.match(/\d/g);
                            number = number.join("");

                            data = "id=" + number + '&r=' + Math.random();

                            if (confirm("Delete this category?")) {

                                CS.Json.sendJson(data, CS.EditItem.siteUrl + 'admin-category/delete-category');
                                NewAlert.init("The category has been deleted");
                                $("#category-block-" + number).fadeOut(2000);

                            } // end if confirm
                            return false;
                        });

                        $(document.forms['adminAddCategory' + result[key].id].elements['submit' + result[key].id]).click(function () {

                            CS.EditItem.error = [];

                            form = document.forms['adminAddCategory' + result[key].id];

                            for (i = 0; i < form.elements.length; i += 1) {

                                if (form.elements[i].type === "text") {

                                    // find the number  in the name value field
                                    number = form.elements[i].name.match(/\d/g);
                                    number = number.join("");

                                } // end if statement
                            } // end for loop
                            CS.EditItem.catName = form.elements['name' + number].value.trim();

                            // loop through the publish fields
                            // assign a value whether the article is to be published or not
                            for (i = 0; i < form.elements['publish' + number].length; i += 1) {

                                if (form.elements['publish' + number][i].checked == true && form.elements['publish' + number][i].value === "1") {
                                    // determines whether the item should be published
                                    catPublish = "1";
                                } else {
                                    catPublish = "0";
                                } // end if
                            } // end for loop
                            CS.Validation.Max(CS.EditItem.catName, CS.EditItem.error, 40, "Opps, the title field field is too long");

                            CS.Validation.Min(CS.EditItem.catName, CS.EditItem.error, "Please make sure you don't leave the title field empty");

                            if (CS.EditItem.error.length === 0) {
                                //process form
                                $('#category-block-' + number).find("fieldset").hide();
                                return true;

                            } else {
                                // If there are errors in the form then run alert message
                                NewAlert.init(CS.EditItem.error);
                                return false;
                                //stop form from being processed
                            }

                        }); // end document.forms onsubmit
                    } // end if
                } // end for
            });
        },

        menu: function (category, url) {

            // menu edit submission here
            CS.Json.getJson(url + "json/" + category + ".json", function (result) {

                for (key in result) {
                    // loop through JSON object
                    if (result.hasOwnProperty(key)) {

                        form = document.forms['adminAddMenu' + result[key].id];

                        // Hide fieldsets belonging to user entry forms - this can be opened on clicking .username
                        // This enables a number of entries to be show
                        $('#menu-block-result' + result[key].id + ' fieldset.fieldset-hidden').hide();
                        $('.menuname').css('cursor', 'pointer');
                        // on clicking title the fieldset is shown
                        $('#menu-block-result' + result[key].id).click(function () {
                            $(this).find("fieldset.fieldset-hidden").show(1000);
                            $('.menuname').css('cursor', 'default');
                        });

                        $(document.forms['adminAddMenu' + result[key].id].elements['delete' + result[key].id]).click(function () {

                            number = this.name.match(/\d/g);
                            number = number.join("");

                            data = "delete_this=" + number + '&r=' + Math.random();

                            if (confirm("Delete menu item?")) {

                                CS.Json.sendJson(data, CS.EditItem.siteUrl + 'admin-menu/delete-menu');
                                $("#menu-block-result" + number).fadeOut(2000);
                                NewAlert.init("The menu item has been deleted");

                            } // end if confirm
                            return false;

                        });

                        $(document.forms['adminAddMenu' + result[key].id].elements['submit' + result[key].id]).click(function () {

                            CS.EditItem.error = [];

                            form = document.forms['adminAddMenu' + result[key].id];

                            for (i = 0; i < form.elements.length; i += 1) {

                                if (form.elements[i].type === "text") {

                                    // find the number  in the name value field
                                    number = form.elements[i].name.match(/\d/g);
                                    number = number.join("");

                                } // end if statement
                            } // end for loop
                            CS.EditItem.menuName = form.elements['menuName' + number].value.trim();
                            CS.EditItem.menuURL = form.elements['menuUrl' + number].value.trim();
                            CS.Validation.Max(CS.EditItem.menuName, CS.EditItem.error, 40, "Opps, the title field field is too long. 40 characters maximum");
                            CS.Validation.Max(CS.EditItem.menuURL, CS.EditItem.error, 100, "Opps, the url field field is too long. 100 characters maximum");
                            CS.Validation.Min(CS.EditItem.menuName, CS.EditItem.error, "Please make sure that the menu name field is not left empty");

                            // loop through the publish fields
                            // assign a value whether the article is to be published or not
                            for (i = 0; i < form.elements['menuPublish' + number].length; i += 1) {

                                if (form.elements['menuPublish' + number][i].checked == true && form.elements['menuPublish' + number][i].value === "1") {
                                    // determines whether the item should be published
                                    catPublish = "1";
                                } else {
                                    catPublish = "0";
                                } // end if
                            } // end for loop
                            if (CS.EditItem.error.length === 0) {
                                //process form
                                $('#menu-block-result' + number).find("fieldset.fieldset-hidden").hide();
                                return true;

                            } else {
                                // If there are errors in the form then run alert message
                                NewAlert.init(CS.EditItem.error);
                                return false;
                                //stop form from being processed
                            } // end if statement
                        }); // end document.forms onsubmit
                    } // end if hasownproperty
                } // end key in result
            });

        },
        // end menu
        user: function (category, url) {

            CS.Json.getJson(url + "json/" + category + ".json", function (result) {

                for (key in result) {
                    // loop through JSON object
                    if (result.hasOwnProperty(key)) {

                        $('#user-block-' + result[key].id).find('fieldset').hide();
                        $('.username').css('cursor', 'pointer');

                        // on clicking title the fieldset is shown
                        $('#user-block-' + result[key].id).click(function () {

                            $(this).find("fieldset").show(1000);
                            $('.username').css('cursor', 'default');

                        });

                        form = document.forms['adminAddUser' + result[key].id].elements['usernameOne' + result[key].id];
/*
                     Change values of form text inline with changing the value of the name input element
                     */
                        form.onkeyup = function () {

                            textZoneValue = this.value.trim();
                            // changes form values - need to check in IE, lol
                            this.previousSibling.innerHTML = "Edit: " + textZoneValue;
                            this.previousSibling.previousSibling.previousSibling.innerHTML = "<span>Edit: " + textZoneValue + "</span>";
                            this.parentNode.parentNode.previousSibling.innerHTML = textZoneValue;
                        }

                        $(document.forms['adminAddUser' + result[key].id].elements['delete' + result[key].id]).click(function () {

                            number = this.name.match(/\d/g);
                            number = number.join("");

                            if (number === "1") {

                                NewAlert.init("You cannot delete your core administrator");

                            } else {

                                data = "delete_this=" + number + '&r=' + Math.random();

                                if (confirm("Delete user?")) {

                                    CS.Json.sendJson(data, CS.EditItem.siteUrl + 'admin-user/delete-user');
                                    NewAlert.init("The user has been deleted");
                                    $("#user-block-" + number).fadeOut(2000);
                                    return false;
                                } // end if confirm
                            } // end if number not 1
                            return false;
                        });

                        $(document.forms['adminAddUser' + result[key].id].elements['submit' + result[key].id]).click(function () {

                            CS.EditItem.error = [];
                            form = document.forms['adminAddUser' + result[key].id];

                            for (i = 0; i < CS.EditItem.form.elements.length; i += 1) {

                                if (CS.EditItem.form.elements[i].type === "text") {
                                    // find the number  in the name value field
                                    number = form.elements[i].name.match(/\d/g);
                                    number = number.join("");

                                } // end if statement
                            } // end for loop
                            CS.EditItem.usernameOne = form.elements['usernameOne' + number].value.trim();
                            CS.EditItem.emailEditOne = form.elements['emailEditOne' + number].value.trim();
                            CS.EditItem.emailEditTwo = form.elements['emailEditTwo' + number].value.trim();
                            CS.EditItem.passwordOne = form.elements['passwordOne' + number].value.trim();
                            CS.EditItem.passwordTwo = form.elements['passwordTwo' + number].value.trim();
                            CS.EditItem.currentEmail = form.elements['hiddenemail' + number].value;
                            CS.EditItem.currentUsername = form.elements['hidden00' + number].value;
                            CS.EditItem.adminRights = form.elements['adminRights' + number];

                            // assign a value whether the article is to be published or not
                            for (i = 0; i < CS.EditItem.adminRights.length; i += 1) {
                                if (CS.EditItem.adminRights[i].checked == true && CS.EditItem.adminRights[i].value === "1") {
                                    // determines whether the item should be published
                                    publish = "1";
                                } else {
                                    publish = "0";
                                } // end if
                            } // end for loop
                            CS.Validation.Min(CS.EditItem.usernameOne, CS.EditItem.error, "Please make sure that you don't leave the username blank");
                            CS.Validation.Min(CS.EditItem.emailEditOne, CS.EditItem.error, "Please make sure that you don't leave the email fields blank");
                            CS.Validation.Min(CS.EditItem.emailEditTwo, CS.EditItem.error, "Please make sure that you don't leave the email fields blank");
                            CS.Validation.Max(CS.EditItem.usernameOne, CS.EditItem.error, 30, "Opps, the username field is too long. 30 characters maximum");
                            CS.Validation.Max(CS.EditItem.emailEditOne, CS.EditItem.error, 50, "Opps, the email field is too long. 50 characters maximum");
                            CS.Validation.Max(CS.EditItem.passwordOne, CS.EditItem.error, 40, "Opps, the email field is too long. 40 characters maximum");

                            if (CS.EditItem.passwordOne && CS.EditItem.passwordTwo) {

                                if (CS.EditItem.passwordOne !== CS.EditItem.passwordTwo) {
                                    CS.EditItem.error.push("\nPlease make sure that the passwords are exactly the same");

                                }
                            } // end if passwords do not match
                            if (CS.EditItem.emailEditOne && CS.EditItem.emailEditTwo) {

                                if (CS.EditItem.emailEditOne !== CS.EditItem.emailEditTwo) {
                                    CS.EditItem.error.push("\nPlease make sure that the emails are exactly the same");

                                } else {

                                    checkdup_email(function (result) {
                                        if (result == true) {
                                            CS.EditItem.error.push("\nSorry, this email address has already been used by another user. Please use a different email addresss.");
                                        }
                                    });
                                }
                            } // end if emails do not match
                            if (CS.EditItem.usernameOne) {

                                checkdup_username(function (result) {
                                    if (result == true) {
                                        CS.EditItem.error.push("\nSorry, this username has already been used by another user. Please use a different email addresss.");
                                    }
                                });
                            } // end if CS.EditItem is positive
                            if (CS.EditItem.error.length === 0) {
                                //process form
                                $('#user-block-' + number).find("fieldset").hide();
                                return true;

                            } else {
                                // If there are errors in the form then run alert message
                                NewAlert.init(CS.EditItem.error);
                                return false;
                                //stop form from being processed
                            } // end if statement
                        }); // end document.forms onsubmit
                    } // end if result.hasOwnProperty(key)
                } // end for loop
            }); // end json cal
        },
        // end user
        init: function (formName, category, url, siteUrl) {

            CS.EditItem.siteUrl = siteUrl;

            if (document.getElementById("edit-menu") && formName == "edit-menu") {
                CS.EditItem.menu(category, url);
            }

            if (document.getElementById("edit-category") && formName == "edit-category") {
                CS.EditItem.category(category, url);
            }

            if (document.getElementById("edit-users") && formName == "edit-users") {
                CS.EditItem.user(category, url, siteUrl);
            }

        } // end init()
    }; // end return
})(); // end
function init(siteUrl, baseUrl) {

    NewAlert.time = 70;

    CS.EditNode.init(siteUrl);
    CS.AddNode.init();
    CS.AddCategory.init(siteUrl);
    CS.AddMenu.init(baseUrl, siteUrl);
    // Read and use category.json file
    CS.EditItem.init("edit-category", "category", baseUrl, siteUrl);
    CS.EditItem.init("edit-menu", "menu", baseUrl, siteUrl);
    CS.EditItem.init("edit-users", "user", baseUrl, siteUrl);
    CS.MenuOrder.init();
    CS.AddUser.init(siteUrl);

} // end function init