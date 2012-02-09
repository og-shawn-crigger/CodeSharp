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

echo title(isset($edit[0]->title)? $edit[0]->title: null,null,null);

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





$(document).ready(function () {
    
    var siteUrl, baseUrl;
    
    siteUrl = '<?php print site_url(); ?>';
    baseUrl = '<?php print base_url(); ?>';
    
    // for markItUp editor. Don't touch
    $("#body").markItUp(mySettings);
    
    init(siteUrl, baseUrl);

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