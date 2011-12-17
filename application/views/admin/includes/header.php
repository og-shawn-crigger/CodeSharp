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

CS.ReadJson = (function () {

    // private attributes if any here
    var number, catPublish, i, textZone, textZoneValue, form, inputCollection, key, publish;
    // private methods if any here
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
        error: null,
        id: null,
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

                        document.forms['adminAddCategory' + result[key].id].onsubmit = function () {

                            CS.ReadJson.error = [];

                            for (i = 0; i < this.elements.length; i += 1) {

                                if (this.elements[i].type === "text") {

                                    // find the number  in the name value field
                                    number = this.elements[i].name.match(/\d/g);
                                    number = number.join("");

                                } // end if statement
                            } // end for loop
                            CS.ReadJson.catName = this.elements['name' + number].value.trim();

                            // loop through the publish fields
                            // assign a value whether the article is to be published or not
                            for (i = 0; i < this.elements['publish' + number].length; i += 1) {

                                if (this.elements['publish' + number][i].checked == true && this.elements['publish' + number][i].value === "1") {
                                    // determines whether the item should be published
                                    catPublish = "1";
                                } else {
                                    catPublish = "0";
                                } // end if
                            } // end for loop
                            CS.Validation.Max(CS.ReadJson.catName, CS.ReadJson.error, 40, "Opps, the title field field is too long");

                            CS.Validation.Min(CS.ReadJson.catName, CS.ReadJson.error, "Please make sure you don't leave the title field empty");

                            if (CS.ReadJson.error.length === 0) {
                                //process form
                                number = this.id.match(/\d/g);
                                number = number.join("");
                                $('#category-block-' + number + ' fieldset').hide();
                                return true;

                            } else {
                                // If there are errors in the form then run alert message
                                alert(CS.ReadJson.error);
                                return false;
                                //stop form from being processed
                            }

                        } // end onsubmit
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

                        document.forms['adminAddMenu' + result[key].id].onsubmit = function () {

                            CS.ReadJson.error = [];

                            for (i = 0; i < this.elements.length; i += 1) {

                                if (this.elements[i].type === "text") {

                                    // find the number  in the name value field
                                    number = this.elements[i].name.match(/\d/g);
                                    number = number.join("");

                                } // end if statement
                            } // end for loop
                            CS.ReadJson.menuName = this.elements['menuName' + number].value.trim();

                            CS.ReadJson.menuURL = this.elements['menuUrl' + number].value.trim();

                            CS.Validation.Max(CS.ReadJson.menuName, CS.ReadJson.error, 40, "Opps, the title field field is too long. 40 characters maximum");

                            CS.Validation.Max(CS.ReadJson.menuURL, CS.ReadJson.error, 40, "Opps, the url field field is too long. 40 characters maximum");

                            CS.Validation.Min(CS.ReadJson.menuName, CS.ReadJson.error, "Please make sure that the menu name field is not left empty");

                            // loop through the publish fields
                            // assign a value whether the article is to be published or not
                            for (i = 0; i < this.elements['menuPublish' + number].length; i += 1) {

                                if (this.elements['menuPublish' + number][i].checked == true && this.elements['menuPublish' + number][i].value === "1") {
                                    // determines whether the item should be published
                                    catPublish = "1";
                                } else {
                                    catPublish = "0";
                                } // end if
                            } // end for loop
                            if (CS.ReadJson.error.length === 0) {
                                //process form
                                number = this.id.match(/\d/g);
                                number = number.join("");
                                $('#menu-block-result' + number + ' fieldset.fieldset-hidden').hide();
                                return true;

                            } else {
                                // If there are errors in the form then run alert message
                                alert(CS.ReadJson.error);
                                return false;
                                //stop form from being processed
                            } // end if statement
                        }; // end onsubmit
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


                        document.forms['adminAddUser' + result[key].id].onsubmit = function () {

                            CS.ReadJson.error = [];

                            for (i = 0; i < this.elements.length; i += 1) {

                                if (this.elements[i].type === "text") {

                                    // find the number  in the name value field
                                    number = this.elements[i].name.match(/\d/g);
                                    number = number.join("");

                                } // end if statement
                            } // end for loop

                            CS.ReadJson.usernameOne = this.elements['usernameOne' + number].value.trim();
                            CS.ReadJson.emailEditOne = this.elements['emailEditOne' + number].value.trim();
                            CS.ReadJson.passwordOne = this.elements['passwordOne' + number].value.trim();
                            CS.ReadJson.passwordTwo = this.elements['passwordTwo' + number].value.trim();
                            CS.ReadJson.adminRights = this.elements['adminRights' + number];

                            // assign a value whether the article is to be published or not
                            for (i = 0; i < CS.ReadJson.adminRights.length; i += 1) {
                                if (CS.ReadJson.adminRights[i].checked == true && CS.ReadJson.adminRights[i].value === "1") {
                                    // determines whether the item should be published
                                    publish = "1";
                                } else {
                                    publish = "0";
                                } // end if
                            } // end for loop
                            
                            
                             if (CS.ReadJson.passwordOne && CS.ReadJson.passwordTwo) {
                                
                                if (CS.ReadJson.passwordOne !== CS.ReadJson.passwordTwo) {
                                    CS.ReadJson.error.push("\nPlease make sure that the passwords are exactly the same");
                                 
                                    }
                                    }
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            

                            return false;
                            
                            
                            

                        } // end document.forms onsubmit
                    } // end if result.hasOwnProperty(key)
                } // end for loop
            }); // end json cal



        },
        // end user

        init: function (formName, category, url) {

            if (document.getElementById("edit-menu") && formName == "edit-menu") {
                CS.ReadJson.menu(category, url);
            }

            if (document.getElementById("edit-category") && formName == "edit-category") {
                CS.ReadJson.category(category, url);
            }

            if (document.getElementById("edit-users") && formName == "edit-users") {
                CS.ReadJson.user(category, url);
            }

        } // end init()
    }; // end return
})(); // end

function init() {
    
    CS.EditNode.init();
    CS.AddNode.init();
    CS.AddCategory.init('<?php print site_url(); ?>');
    CS.AddMenu.init('<?php print base_url(); ?>', '<?php print site_url(); ?>');
    // Read and use category.json file
    CS.ReadJson.init("edit-category", "category", '<?php print base_url(); ?>');
    CS.ReadJson.init("edit-menu", "menu", '<?php print base_url(); ?>');
    CS.ReadJson.init("edit-users", "user", '<?php print base_url(); ?>');
    CS.MenuOrder.init();
    CS.AddUser.init('<?php print site_url(); ?>');

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