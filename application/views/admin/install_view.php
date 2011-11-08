<?php

/**
 * @author Andy Walpole
 * @date 6/11/2011
 * 
 */

?>

<div id="wrapper">

<div id="install">

<h1>Enter the required information below</h1>

<?php

if (isset($_POST['submit'])) {

    $_POST = array_map('trim', $_POST);

    // Make sure CMS only runs on PHP version 5.3 and higher

    if (floatval(phpversion()) <= 5.2) {

        $error[] = "Sorry, this CMS will only run on PHP versions 5.3 and above";

    }

    $input = array("databaseName", "server","databaseUsername","databasePassword",
    "websiteName", "websiteSlogan", "adminEmail", "adminPassword", "adminUsername");

    foreach ($input as $result) {

        if (empty($_POST[$result])) {

            $error[] = "Please make sure that no fields in the form are empty";
            break;

        }

    }


    /**
     * ADD VALIDATION HERE
     */

    function form_validation_maxlength(&$error, $value) {

        /* You need to add an array like below */

        /* $maximum_field_length = array('website-name' => 40, 'url' => 50, 'description' => 500, 'meta-keywords' => 70, 'meta-description' => 150, 'name-user' => 40, 'email-user' => 50);
        $vd->form_validation_maxlength($maximum_field_length); */

        foreach ($value as $result => $maxlength) {

            if (strlen($_POST[$result]) > $maxlength) {

                $error[] = "Opps, the {$result} field is too long. Please shorten it.";

            }
        }
        return $error;

    } // form_validation_maxlength() method empty


    // Validate to make sure that they do not exceed max length
    $maximum_field_length = array('websiteName' => 50, 'websiteSlogan' => 50,
        'adminEmail' => 50, 'adminPassword' => 40, 'adminUsername' => 30);

    form_validation_maxlength($error, $maximum_field_length);

    // check connection first before validating

    $input = array("databaseName", "server", "databaseUsername", "databasePassword");

    foreach ($input as $result) {

        if (!empty($_POST[$result])) {

            // If all database fields are full then run script to make sure that the details are correct

            @$mysqli = new mysqli($_POST['server'], $_POST['databaseUsername'], $_POST['databasePassword'],
                $_POST['databaseName']);

            if (mysqli_connect_errno()) {
                $error[] = "Connect failed: " . mysqli_connect_error() .
                    " Are you sure you entered the database details correctly?";
            }

            break;

        }

    }

    if (empty($error)) {

        // Takes sql data from insert.sql in order to create the tables.
        $sql = explode(";", file_get_contents('application/views/admin/insert.sql')); //

        $query_result = 0;

        foreach ($sql as $query) {

            /**
             * USES THE ABOVE DATABASE OBJECT CONNECTION
             */

            $mysqli->query($query);
            $query_result++;

        }

        /**
         * IF ALL SIX TABLES HAVE BEEN SUCCESSFULLY CREATED
         */

        if ($query_result >= 6) {

            /**
             * INSERT SOME DATA INTO THE NEARLY CREATED TABLES
             */

            $query = "INSERT INTO `category` (`id`, `menu_id`, `number`, `name`, `date`, `visible`) VALUES
(1, 'C', 0, 'First Category', now(), 1);";

            $query_two = "INSERT INTO `menu` (`id`, `menu_id`, `number`, `name`, `url`, `date`, `visible`) VALUES
(1, 'M', 10, 'Home', '/', now(), 1),
(2, 'M', 3, 'Admin Home', 'admin', now(), 1)";

            $unique = uniqid();

            $query_three = "INSERT INTO `user` (`id`, `created`, `username`, `password`, `email`, 
        `member`, `newpass`, `dbsalt`, `admin_rights`) VALUES
(1, now(), '" . $_POST['adminUsername'] . "', '" . hash_hmac('sha1', $_POST['adminPassword'],
                "7thes%*!%-" . $unique) . "', '" . $_POST['adminEmail'] . "', 561451, 1,'" . $unique .
                "',1)";

            $query_four = "INSERT INTO `admin` (`id`, `name`, `okay`, `value`) VALUES
(1, 'cat_menu', 1, ''),
(7, 'name_of_site', 0, '" . $_POST['websiteName'] . "'),
(8, 'slogan', 0, '" . $_POST['websiteSlogan'] . "'),
(9, 'email', 0, '" . $_POST['adminEmail'] . " '),
(10, 'meta_description', 0, ''),
(11, 'meta_keywords', 0, ''),
(12, 'error_reporting', 1, NULL),
(13, 'error_level', 2, NULL),
(14, 'error_email', 0, NULL)";

            $query_five = "INSERT INTO `menu` (`id`, `menu_id`, `number`, `name`, `url`, `date`, `visible`) VALUES
(1, 'M', 0, 'Admin Home', '?section=admin-home', now(), 1)";

            $query_six = "INSERT INTO `content` (`id`, `category_id`, `user_id`, `image_id`, `date`, `title`, `body`, `meta_description`, `meta_keywords`, `visible`) VALUES
(1, 1, 1, NULL, now(), 'Nam ultrices ante id urna dapibus mollis', 'nam-ultrices-ante-id-urna-dapibus-mollis', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vitae rutrum nisi. Aenean facilisis hendrerit posuere. Mauris placerat bibendum justo vitae congue. Mauris nisl nisl, hendrerit quis luctus at, sollicitudin eu sem. Proin eu nunc ut libero scelerisque aliquam cursus vitae erat. Praesent consectetur, ligula vel accumsan blandit, nunc tellus suscipit metus, sit amet aliquam nibh felis nec ligula. Mauris mauris nulla, dictum ac scelerisque et, auctor eu ligula. Curabitur ante tellus, molestie nec ultricies ac, tempus nec enim. Integer tempor diam sit amet felis consequat id scelerisque risus ultrices. In a tortor ac nunc pharetra gravida. Nullam tempus consectetur sem sed fermentum. Nam consectetur massa sed eros commodo molestie. Ut dictum sem id magna aliquet pellentesque. Fusce molestie tincidunt risus eu aliquam. Etiam massa tortor, dictum sit amet tempus auctor, blandit malesuada diam. Morbi non lacus ut sapien aliquam dapibus donec.rnrnQuisque id leo eget metus pretium porta. Donec vitae neque et odio aliquam facilisis semper luctus mauris. Sed commodo accumsan lacus feugiat sollicitudin. In luctus quam turpis. Maecenas lacinia interdum mi vel sagittis. Maecenas sed felis augue. In et enim diam. Curabitur at eros ut velit cursus varius sed eget mi. Maecenas tincidunt vulputate dui, vitae vestibulum odio posuere vitae. Mauris euismod placerat enim, eu fringilla lectus dapibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas ac turpis lectus, sed lacinia dui. Nam eget mauris metus.rnrnPraesent ac lacus sed ipsum scelerisque viverra sed non tellus. Sed dictum ipsum id lacus semper in hendrerit sem facilisis. Maecenas ultricies est sed ligula scelerisque euismod. Proin massa neque, malesuada nec mollis vel, varius non enim. Fusce vitae vestibulum est. Aliquam in urna sapien, eu feugiat augue. Nunc id leo ac odio scelerisque elementum. Etiam vitae libero non magna pretium sodales in vitae erat. Vestibulum eget vestibulum lectus. Maecenas ornare posuere mauris et vehicula. Ut enim magna, ullamcorper nec semper in, rutrum ullamcorper risus. Nunc id elit mauris, in tristique nibh. Quisque tempus elementum rhoncus. In hac habitasse platea dictumst. Vestibulum molestie magna ac elit vehicula tempor. Curabitur consectetur sapien nec nulla facilisis consequat. Sed convallis urna quis erat ultricies interdum vitae elementum nibh.rnrnNam ultrices ante id urna dapibus mollis. Phasellus nec dui ut lectus rutrum porttitor ac vitae risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Proin justo odio, bibendum a feugiat et, laoreet ut urna. Proin in eleifend nulla. Morbi neque ante, tincidunt eu condimentum vel, sollicitudin nec sem. Vestibulum luctus enim tellus. Nunc sed urna et magna facilisis dictum. Fusce eleifend ultricies dolor, pellentesque sodales tellus faucibus nec. In hac habitasse platea dictumst. In ligula tortor, luctus quis interdum sed, viverra a sapien. Maecenas eu eleifend libero. Sed lacus odio, viverra in consequat at, iaculis eget lacus. Mauris nec turpis et tortor pretium molestie. Pellentesque ornare velit nec est euismod ut pretium magna porta. Proin at eros in mauris gravida tempor. Donec erat dui, dictum eget auctor eu, posuere quis augue. In vitae augue elementum dolor tincidunt luctus eget ac sapien. Integer vulputate pharetra odio id mollis.',  '', 1),
(2, 1, 1, NULL, now(), 'Integer elementum leo eget diam eleifend in laoreet mi sodales', 'integer-elementum-leo-eget-diam-eleifend-in-laoreet-mi-sodales', 'Vivamus pulvinar risus dolor, condimentum ultricies sapien. Vivamus ornare lacus ut mi viverra cursus. Sed sollicitudin, eros in it scelerisque sodales, ligula nisl ullamcorper felis, ac imperdiet dolor metus vitae metus. Cras ac dolor aliquet mi fermentum mollis. Morbi varius tristique quam in accumsan. Maecenas enim eros, malesuada eu lacinia quis, suscipit id magna. Maecenas volutpat elit nibh, eget pulvinar magna. Mauris ut urna nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla facilisi. Mauris vehicula lobortis massa, eu volutpat tortor egestas interdum. Morbi sit amet sem leo. Sed dui massa, ornare eu fringilla vitae, eleifend nec sem. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas in eros non orci semper aliquet in nec sem. Morbi et tincidunt dolor.rnrnNunc accumsan egestas nibh eu dictum. Praesent tortor enim, dignissim eu viverra vel, laoreet nec leo. Suspendisse vel augue id lacus laoreet vestibulum non vel erat. Fusce vulputate rutrum ultricies. In aliquet risus sed nisl rutrum rutrum. Curabitur sit amet suscipit enim. Duis non diam eu nisi ornare lobortis. Sed non massa sit amet odio egestas lacinia quis in tellus. Aliquam erat volutpat. Morbi accumsan, sapien sit amet elementum viverra, justo sapien elementum velit, non aliquam velit tellus eget dui. Duis vitae ante lorem, a semper urna. In non metus metus. Nulla rhoncus elit eu odio faucibus sed pharetra lacus tempor. Curabitur leo risus, ultricies ut egestas non, gravida a purus. Aliquam vel sapien euismod mauris euismod mattis sed a velit. Suspendisse potenti. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec facilisis pellentesque sapien sed eleifend. Sed vitae augue quam.rnrnPraesent eleifend sodales faucibus. Curabitur eu tellus tellus. Donec pulvinar massa a eros feugiat in lobortis neque porttitor. Donec a elit in elit elementum consequat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec mollis congue massa, nec cursus sem sagittis vel. Nam pellentesque viverra molestie. Mauris tincidunt urna eu justo rhoncus eu sollicitudin massa vulputate. Sed quis mollis magna. Sed pulvinar sagittis pulvinar. Phasellus sagittis nibh quis justo hendrerit consectetur. Curabitur porttitor massa iaculis sem convallis volutpat. Fusce condimentum lobortis mauris et rutrum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus luctus dui ut nunc fermentum hendrerit. Suspendisse vitae blandit ligula. Nullam consectetur ultricies consequat.rnrnInteger elementum leo eget diam eleifend in laoreet mi sodales. Pellentesque egestas, elit non euismod ornare, elit ante ornare nisl, non varius tellus metus vel nisl. Maecenas elementum faucibus malesuada. In hac habitasse platea dictumst. Integer quis nisl augue, sit amet consequat ipsum. Ut fringilla mattis nisi vel blandit. Duis viverra quam risus. Quisque aliquam felis nec sem varius a bibendum eros volutpat. Mauris ac vehicula urna. Curabitur luctus sem ac turpis malesuada sit amet feugiat tellus fringilla. Nulla scelerisque tortor id ipsum suscipit mattis. Duis metus quam, fringilla a suscipit vitae, ultrices sit amet ligula. Aenean ullamcorper dictum mauris quis adipiscing. Nam neque dolor, scelerisque quis hendrerit id, rhoncus eget sem. In sodales eleifend ultricies.', '', 1),
(3, 1, 1, NULL, now(), 'Donec nec mollis magna', 'donec-nec-mollis-magna', 'Aenean arcu neque, mattis sed ultricies id, hendrerit et eros. Nullam aliquam ligula in dolor scelerisque vestibulum. Duis ultrices felis eget mauris fermentum et dapibus turpis dictum. Aenean auctor, risus sit amet tempus condimentum, odio risus elementum diam, at commodo nibh ipsum eu ante. Integer ac pharetra ligula. Nunc varius pulvinar mi, ac convallis massa posuere tempor. Nam ullamcorper risus ac sapien tristique consectetur. Donec eu est erat, ac dignissim enim. Mauris posuere metus vel mauris tincidunt sed porta eros mollis. Pellentesque venenatis blandit neque quis tempus. Maecenas sed neque nec purus dictum fringilla. In massa arcu, ullamcorper ut egestas varius, mattis auctor nunc. Phasellus felis risus, ullamcorper nec mollis in, luctus non neque. Vivamus at felis purus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae ultricies;rnrnCras nec ligula eu nulla ultricies dapibus. Aliquam mauris nisl, tempus nec fermentum in, congue ac risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas faucibus gravida augue quis congue. Sed blandit libero vel ante blandit posuere dapibus dui pellentesque. Donec ligula nulla, blandit non varius dictum, lacinia et magna. Aenean ligula tellus, iaculis a mollis ac, iaculis ac orci. Morbi diam ligula, tincidunt et convallis a, malesuada nec ipsum. Sed purus odio, pulvinar quis pharetra non, commodo sed risus. Aliquam ut dui et justo aliquam accumsan vitae vitae arcu. Quisque quis nunc eu enim viverra bibendum. Vivamus eget augue eu tortor dapibus mollis non eleifend felis.rnrnDonec nec mollis magna. Nam varius ligula vel justo mattis elementum. Duis lorem leo, malesuada quis euismod id, lacinia ut velit. Praesent sit amet enim mauris. Morbi porta lorem non neque faucibus ut posuere metus suscipit. Quisque nec magna nulla. Praesent scelerisque felis at libero viverra id eleifend nibh vestibulum. Nullam pretium felis at lorem condimentum non suscipit ante elementum. Nullam dignissim, magna ut vehicula condimentum, metus sem aliquam ante, eu luctus arcu tellus eu quam. Curabitur tincidunt interdum mi eget pulvinar. Proin ut gravida turpis. Sed tristique erat a libero tristique varius. Nullam porttitor felis eu tortor pulvinar eget placerat tortor egestas. Pellentesque eget massa nec ipsum vestibulum tincidunt.rnrnNunc quis est dui, non suscipit justo. Nullam mi enim, ultrices in semper vel, semper id metus. Curabitur luctus enim id neque hendrerit posuere ut vel sapien. Vestibulum in fringilla neque. Maecenas egestas dignissim luctus. Ut aliquam, metus id molestie consectetur, diam ligula adipiscing ipsum, eget venenatis neque velit a erat. Pellentesque feugiat, nibh id porttitor ultricies, quam diam tempus nulla, et egestas mi tellus eget magna. Sed sit amet ipsum purus, in vehicula mi. Nulla elit purus, porta ac eleifend id, scelerisque id mauris. Mauris dolor justo, feugiat vel pharetra vitae, viverra eu ante. Proin et nunc sem, eget interdum orci. Donec consectetur enim nec nisi consequat a elementum felis tincidunt.', '', 1)";

            $query_array = array($query, $query_two, $query_three, $query_four, $query_five,
                $query_six);

            $insert_result = 0;

            foreach ($query_array as $result) {

                $mysqli->query($result);
                $insert_result++;

            }

            // Create image directories if they don't exist

            if ($insert_result > 5) {

                // create image folders

                if (!is_dir("images")) {

                    mkdir("images");

                }

                if (!is_dir("images/thumbnail")) {

                    mkdir("images/thumbnail");

                }

                if (!is_dir("images/uploads")) {

                    mkdir("images/uploads");

                }

                // Finally destroy all install files

                unlink('application/views/admin/insert.sql');
                unlink('application/views/admin/install_view.php');
                redirect('/');
                exit;

            } else {

                echo '<p class="intall-warning">' .
                    "There has been a problem in inserting data into the tables" . '</p>';

            }


        } else {

            echo '<p class="install-warning">' .
                "There has been a problem in creating the database tables" . '</p>';

        }


    } else {

        foreach ($error as $result) {

            echo '<p class="install-warning">' . $result . "</p>";

        }

    }


} // end isset submit


?>

<form action="#" method="post" name="installScript" id="install-script" autocomplete="off">
<fieldset>
<legend><span>Database details</span></legend>

<label for="database-name">Database name: </label>
<input type="text" id="database-name" name="databaseName" value="<?php

isset($_POST['databaseName']) ? print $_POST['databaseName'] : null;

?>"/>

<label for="server">Server: </label>
<input type="text" id="server" name="server" value="<?php

isset($_POST['server']) ? print $_POST['server'] : print "localhost";

?>"/>

<label for="database-username">Database username: </label>
<input type="text" id="database-username" name="databaseUsername" value="<?php

isset($_POST['databaseUsername']) ? print $_POST['databaseUsername'] : null;

?>"/>

<label for="database-password">Database password: </label>
<input type="text" id="database-password" name="databasePassword" value="<?php

isset($_POST['databasePassword']) ? print $_POST['databasePassword'] : null;

?>"/>

</fieldset>

<fieldset>
<legend><span>Website details</span></legend>

<label for="website-name">Name of website: </label>
<input type="text" id="website-name" maxlength="50" name="websiteName" value="<?php

isset($_POST['websiteName']) ? print $_POST['websiteName'] : null;

?>"/>

<label for="website-slogan">Website slogan: </label>
<input type="text" id="website-slogan" maxlength="50" name="websiteSlogan" value="<?php

isset($_POST['websiteSlogan']) ? print $_POST['websiteSlogan'] : null;

?>"/>

<label for="admin-username">Admin username: </label>
<input type="text" id="admin-username" maxlength="30" name="adminUsername" value="<?php

isset($_POST['adminUsername']) ? print $_POST['adminUsername'] : null;

?>"/>

<label for="admin-password">Admin password: </label>
<input type="text" id="admin-password" maxlength="40" name="adminPassword" value="<?php

isset($_POST['adminPassword']) ? print $_POST['adminPassword'] : null;

?>"/>

<label for="admin-email">Admin email address: </label>
<input type="text" id="admin-email" maxlength="50" name="adminEmail" value="<?php

isset($_POST['adminEmail']) ? print $_POST['adminEmail'] : null;

?>"/>

<input type="submit" name="submit" value="submit" />

</fieldset>
</form>
</div>
