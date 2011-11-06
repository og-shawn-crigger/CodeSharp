<?php ob_start(); ?>
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
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<title>
<?php

$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

if ($_SERVER["SERVER_PORT"] != "80"){

    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	
} else {

    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	
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
        echo isset($_POST["title"]) ? $_POST["title"] : $edit[0]->title . " / " . SITENAME;
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

echo base_url();

?>css/admin/styles.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php

echo base_url();

?>css/admin/fonts.css" />

<!-- JavaScript -->

<script src="<?php

echo base_url();

?>javascript/jquery-1.7.min"></script>

<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
</head>
<body>

<!--[if lt IE 7]>
          <div id="ie6-alert" style="width: 100%; text-align:center;">
          	<img src="http://beatie6.frontcube.com/images/ie6.jpg" alt="Upgrade IE 6" width="640" height="344" border="0" usemap="#Map" longdesc="http://die6.frontcube.com" />
              <map name="Map" id="Map"><area shape="rect" coords="496,201,604,329" href="http://www.microsoft.com/windows/internet-explorer/default.aspx" target="_blank" alt="Download Interent Explorer" /><area shape="rect" coords="380,201,488,329" href="http://www.apple.com/safari/download/" target="_blank" alt="Download Apple Safari" /><area shape="rect" coords="268,202,376,330" href="http://www.opera.com/download/" target="_blank" alt="Download Opera" /><area shape="rect" coords="155,202,263,330" href="http://www.mozilla.com/" target="_blank" alt="Download Firefox" />
                <area shape="rect" coords="35,201,143,329" href="http://www.google.com/chrome" target="_blank" alt="Download Google Chrome" />
              </map>
          </div>
          <![endif]-->