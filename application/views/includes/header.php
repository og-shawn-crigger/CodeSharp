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

/**
 * Do not remove below. This is needed for page titles
 */

$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

if ($_SERVER["SERVER_PORT"] != "80"){

    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	
} else {

    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	
}

$page = $pageURL;

switch ($page) {

    case (preg_match('/^.*\/article\/.*/', $page) ? true : false):
        echo $full_node[0]->title . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/category\/.*/', $page) ? true : false):
        echo $category_records[0]->name . " / " . SITENAME;
        break;

    default:
        echo SITENAME . " / " . SLOGAN;
        break;

}

?>
</title>

<!-- css here -->



<!-- meta description here -->
<?php

/**
 * Do not remove below. This is needed for description and keywords meta values
 */

if(isset($full_node)) {

if($full_node[0]->meta_description !== "") {
    
    $meta = '<meta name="description" content="';
    
    $meta .= $full_node[0]->meta_description;
    
    $meta .= '" />';
    
    echo $meta;
    
}

/**
 * NEED TO SORT OUT KEYWORDS BOX IN ADD AND EDIT NODE
 */

if($full_node[0]->meta_keywords !== "") {
    
    $meta = '<meta name="keywords" content="';
    
    $meta .= $full_node[0]->meta_keywords;
    
    $meta .= '" />';
    
    echo $meta;
    
}

}

?>
<link rel="canonical" href="<?php

echo site_url() . $this->uri->uri_string();

?>" />


<!-- JavaScript here -->


</head>
<?php flush(); ?>
<body>
<!--[if lt IE 7]>
          <div id="ie6-alert" style="width: 100%; text-align:center;">
          	<img src="http://beatie6.frontcube.com/images/ie6.jpg" alt="Upgrade IE 6" width="640" height="344" border="0" usemap="#Map" longdesc="http://die6.frontcube.com" />
              <map name="Map" id="Map"><area shape="rect" coords="496,201,604,329" href="http://www.microsoft.com/windows/internet-explorer/default.aspx" target="_blank" alt="Download Interent Explorer" /><area shape="rect" coords="380,201,488,329" href="http://www.apple.com/safari/download/" target="_blank" alt="Download Apple Safari" /><area shape="rect" coords="268,202,376,330" href="http://www.opera.com/download/" target="_blank" alt="Download Opera" /><area shape="rect" coords="155,202,263,330" href="http://www.mozilla.com/" target="_blank" alt="Download Firefox" />
                <area shape="rect" coords="35,201,143,329" href="http://www.google.com/chrome" target="_blank" alt="Download Google Chrome" />
              </map>
          </div>
          <![endif]-->
