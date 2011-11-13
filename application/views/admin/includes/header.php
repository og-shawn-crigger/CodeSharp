<?php

ob_start();

?>
<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if lt IE 7 ]><html class="ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8" />
<title>
<?php

$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

if ($_SERVER["SERVER_PORT"] != "80") {

    $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];

} else {

    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

}

$page = $pageURL;

switch ($page) {

    case "/admin":
        echo "Administration section " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-config\/*/', $page) ? true : false):
        echo "Main admin configuration " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-content\/*/', $page) ? true : false):
        echo "Add a content page " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-edit-content$/', $page) ? true : false):
        echo "Edit a content page " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-edit-content\/edit-node\/\d/', $page) ? true : false):
        echo isset($_POST["title"]) ? $_POST["title"]:
        $edit[0]->title . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-category\/*/', $page) ? true : false):
        echo "Edit categories " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-user\/*/', $page) ? true : false):
        echo "Add and edit user details " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-menu\/*/', $page) ? true : false):
        echo "Add and edit menu details " . " / " . SITENAME;
        break;

    default:
        echo SITENAME . " / " . SLOGAN;
        break;

}

?>
</title>

<!-- CSS -->

<link type="text/css" rel="stylesheet" media="all" href="<?php

echo base_url("css/admin/styles.css");

?>" />
<link type="text/css" rel="stylesheet" media="all" href="<?php

echo base_url("css/admin/fonts.css");

?>" />
<link rel="stylesheet" type="text/css" href="<?php

echo base_url("css/admin/markitup/skins/simple/style.css");

?>" />
<link rel="stylesheet" type="text/css" href="<?php

echo base_url("css/admin/markitup/sets/textile/style.css");

?>" />


<!-- JavaScript -->

<script src="<?php

echo base_url("javascript/admin/jquery-1.7.min.js");

?>"></script>

<script src="<?php

echo base_url("javascript/admin/main-file.js");

?>"></script>


<script src="<?php

echo base_url("css/admin/markitup/jquery.markitup.js");

?>"></script>
<script src="<?php

echo base_url("css/admin/markitup/sets/textile/set.js");

?>"></script>

<script>
/* <![CDATA[ */

var CS = window.CS || {};

// submission of admin_new_content.php
// Needs further work on the File API

CS.AddNode = (function () {

    // private attributes if any here
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
        i: null,
        ext: null,
        image: null,
        len: null,
        imageError: null,
        publish: null,
        form: null,
        total: null,

        //public methods
        handleSubmit: function (e) {
        
            // set error attribute as an array
            CS.AddNode.error = [];
            CS.AddNode.form = document.forms.adminAddContent;
            // declare form values
            CS.AddNode.fileField = CS.AddNode.form.file_upload.value;
            CS.AddNode.titleField = trim(CS.AddNode.form.title.value);
            CS.AddNode.catField = trim(CS.AddNode.form.select.value);
            CS.AddNode.bodyField = trim(CS.AddNode.form.body.value);
            CS.AddNode.publishField = CS.AddNode.form.publish;
            if (CS.AddNode.form.metaDescription) {
                CS.AddNode.descField = trim(CS.AddNode.form.metaDescription.value);
            }
            if (CS.AddNode.form.metaKeywords) {
                CS.AddNode.keyField = trim(CS.AddNode.form.metaKeywords.value);
            }
            CS.AddNode.i = 0;
            var elems = CS.AddNode.form.elements;
            //loop through form elements to make sure text and textarea are not empty
            for (CS.AddNode.len = elems.length; CS.AddNode.i < CS.AddNode.len; CS.AddNode.i += 1) {
                if (elems[CS.AddNode.i].type === "text" || elems[CS.AddNode.i].type === "textarea") {
                    if (elems[CS.AddNode.i].value.length < 1) {
                        CS.AddNode.error.push("\nPlease make sure that no fields are left empty");
                        break;
                    } // if value < 1
                } // end if text or textarea
            } // end for statemetn
            CS.AddNode.i = 0;
            // loop through element fields values to make sure that they are not too long
            for (CS.AddNode.len = elems.length; CS.AddNode.i < CS.AddNode.len; CS.AddNode.i += 1) {
                if (elems[CS.AddNode.i].name === "title") {
                    if (elems[CS.AddNode.i].value.length >= 100) {
                        CS.AddNode.error.push("\nThe title field is too long please shorten it");
                    } // end if length > 10
                } // end if name === title
                if (elems[CS.AddNode.i].name === "metaKeywords") {
                    if (elems[CS.AddNode.i].value.length >= 255) {
                        CS.AddNode.error.push("\nThe meta keyfield is too long please shorten it");
                    } // end if length > 255
                } // end if name === metaKeywords
                if (elems[CS.AddNode.i].name === "metaDescription") {
                    if (elems[CS.AddNode.i].value.length >= 255) {
                        CS.AddNode.error.push("\nThe meta description is too long please shorten it");
                    } // end if length > 255
                } // end if name === metaDescription
            }
            // assign a value whether the article is to be published or not
            for (CS.AddNode.i = 0; CS.AddNode.i < CS.AddNode.publishField.length; CS.AddNode.i += 1) {
                if (CS.AddNode.publishField[CS.AddNode.i].checked == true && CS.AddNode.publishField[CS.AddNode.i].value === "1") {
                    // determines whether the item should be published
                    CS.AddNode.publish = "1"
                } else {
                    CS.AddNode.publish = "0"
                } // end if
            } // end for loop
            // the valueos of all the file fields
            // Below checks to make sure that uploaded file is an image
            CS.AddNode.image = [".jpeg", ".jpg", ".png", ".gif"];
            CS.AddNode.i = 0;
            // find extension of file
            CS.AddNode.ext = CS.AddNode.fileField.slice(CS.AddNode.fileField.indexOf(".")).toLowerCase();
            // loop through file extentiong above and then see if it fits what the user has updated
            for (CS.AddNode.len = CS.AddNode.image.length; CS.AddNode.i < CS.AddNode.len; CS.AddNode.i += 1) {
                if (CS.AddNode.ext === CS.AddNode.image[CS.AddNode.i]) {
                    CS.AddNode.imageError = null;
                    break;
                } else {
                    if (CS.AddNode.fileField !== "") {
                        CS.AddNode.imageError = 1;
                    }
                } // else
            } // end for loop
            // if the file is not an image then produce an error message and attached it to the error array
            if (CS.AddNode.imageError === 1) {
                CS.AddNode.error.push("\nPlease make sure you only upload an image");
            }
            // Add the form input values to the total array for use in form processing below
            CS.AddNode.total = [
            CS.AddNode.fileField, CS.AddNode.titleField, CS.AddNode.catField, CS.AddNode.bodyField, CS.AddNode.publish, CS.AddNode.keyField, CS.AddNode.descField];
            // add error messag end input values in the total array for use in validData
            // check whether HTML5 fileAPI is working on the browser
            if (window.File && window.FileReader && window.FileList && window.Blob) {
                // if yes go to fileAPI function
                CS.AddNode.fileAPI(CS.AddNode.error, CS.AddNode.total);
            } else {
                // if not go straight to validData function
                CS.AddNode.validData(CS.AddNode.error, CS.AddNode.total);
            }
            return false;
            

        },

        fileAPI: function (error, formArray) {
            
            if (document.getElementById("file_upload").files[0]
            //add below when all the system is working well
            //&& error.length !== 0
            ) {
                if (document.getElementById("file_upload").files[0].size > 1024000) {
                    error.push("\nSorry, the image you uploaded is too large");
                } // end if image size
            } // end of file_upload has file
            CS.AddNode.validData(error, formArray)
            return false;
            
        },

        validData: function (error, formArray) {
            // for the legacy browsers just run the php form if no errors are produced
            if (error.length === 0) {
            return CS.AddNode.Form.submit();
            } else {
                // If there are errors in the form then run alert message
                alert(error);
                return false;
            }

        },

        sendData: function (formArray) {

          



            //alert(formArray[0]);
/*
             THIS IS THE AJAX COMMAND
        
             */

/*

            // When form inputs are correct send them to the php form for processing
            var $data, $objX;

            $objX = new XMLHttpRequest();

            // to stop IE caching the request
            $random = Math.random();

            $data = 'category_id=' + catField + '&user_id=' + "1" + '&image_id=' + 'yeah' + '&date=' + "now()" + '&title=' + titleField + '&body=' + bodyField + '$meta_description=' + descField + '$meta_keywords=' + keyField + '$ajax=' + true + '&r=' + $random;

            // alert($data);
            $objX.open('POST', site_url('admin-content/admin-add-content'), true);

            $objX.setRequestHeader('User-Agent', 'XMLHTTP/1.0');

            $objX.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            $objX.onreadystatechange = function () {

                if ($objX.readyState !== 4) {

                    if ($objX.status !== 200 && $objX.status !== 304) {
                        alert('HTTP error ' + $objX.status);

                    }

                }

            };
            
            
            
*/


            //alert($objX.send($data));
/*
                 END OF JAVASCRIPT COMMEND
                 */


        },

        init: function () {

            if (document.forms.adminAddContent) {

                CS.AddNode.Form = document.forms.adminAddContent;
                // first step sets value for form name
                CS.AddNode.Form.onsubmit = CS.AddNode.handleSubmit;
                // on submit run handeSubmit method
            } // end undefined
        } // end init()
    }; // end return
})(); // end CS.AddNode


function init() {

    CS.AddNode.init();

} // end function init


$(document).ready(function () {

    // for markItUp editor. Don't touch
    $("#body").markItUp(mySettings);

    init();

}); // End document ready
/* ]]> */
</script>
    

<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->

<!-- meta tags -->

<link rel="canonical" href="<?php

echo site_url() . $this->uri->uri_string();

?>" />

</head>
<?php

flush();

?>
<body>

<!--[if lt IE 7]>
          <div id="ie6-alert" style="width: 100%; text-align:center;">
          	<img src="http://beatie6.frontcube.com/images/ie6.jpg" alt="Upgrade IE 6" width="640" height="344" border="0" usemap="#Map" longdesc="http://die6.frontcube.com" />
              <map name="Map" id="Map"><area shape="rect" coords="496,201,604,329" href="http://www.microsoft.com/windows/internet-explorer/default.aspx" target="_blank" alt="Download Interent Explorer" /><area shape="rect" coords="380,201,488,329" href="http://www.apple.com/safari/download/" target="_blank" alt="Download Apple Safari" /><area shape="rect" coords="268,202,376,330" href="http://www.opera.com/download/" target="_blank" alt="Download Opera" /><area shape="rect" coords="155,202,263,330" href="http://www.mozilla.com/" target="_blank" alt="Download Firefox" />
                <area shape="rect" coords="35,201,143,329" href="http://www.google.com/chrome" target="_blank" alt="Download Google Chrome" />
              </map>
          </div>
          <![endif]-->