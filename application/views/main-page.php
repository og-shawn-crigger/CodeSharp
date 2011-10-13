<?php

/**
 * @author Andy Walpole
 * @date 26/9/2011
 * 
 */

?>

<div id="wrapper">

<header class="clearfix">

<h1>Pinhead CMS (CodeIgniter version)</h1>

</header><!-- End header -->

<div id="content" class="clearfix">

<section id="column-one">

<?php

// Only display content list if "content" is in URI
// This is for the entire node list
if (isset($records)):

?>

<?php

    foreach ($records as $rows):

?>

<article class="summary">

<h2><?php

        echo $rows->title;

?></h2>

<time class="summary-date" datetime="<?php

        // Find a CodeIgnitor-friendly way of displaying date as below
        echo strftime("%Y-%m-%d", strtotime($rows->date));

?>"><?php

        // Find a CodeIgnitor friendly way of display date as below
        echo strftime("%B %d, %Y", strtotime($rows->date));

?></time>

<div class="summary-category">Category: <a href="
<?php echo base_url() . 'index.php/content/category/' . $rows->category_id;?>
"><?php
// the right category name from the node category id number
// relational database

// ouch, this is messy - needs attention

        foreach ($query_result as $result) {

            foreach ($result as $row) {
                
                if($row->id === $rows->category_id) {
                    
                    echo $row->name;
                    break;
                    
                }
                
            }

        }

?></a></div>

<div class="summary-teaser"><?php

        // Uses text helper for nice clean break in string near to 320 characters
        // Also uses typograhpy class to add HTML to the database text
        // This produces nicely formatted blocks to text

        echo $this->typography->auto_typography(character_limiter($rows->body, 320));

?></div>

<div class="read-more"><a href="<?php

        echo base_url() . 'index.php/content/node/' . $rows->id;

?>">Read more</a></div>

</article>

<?php

    endforeach;

?>

<?php

echo '<div id="pagination">';
echo $this->pagination->create_links();
echo '</div>';

endif;

?>


<?php

// This is for the full node
if (isset($full_node)):

?>

<article id="node">

<h1><?php

    echo $full_node[0]->title;

?></h1>

<time id="node-date" datetime="<?php

    echo strftime("%Y-%m-%d", strtotime($full_node[0]->date));

?>"><?php

    echo strftime("%B %d, %Y", strtotime($full_node[0]->date));

?></time>

<div id="node-author">Author: <?php

    echo $author_name[0]->username;

?></div>

<div id="node-category">Category: <a href="<?php

    echo base_url() . 'index.php/content/category/' . $full_node[0]->category_id;

?> "><?php

    echo $cat_name[0]->name;

?></a></div>

<div id="node-image"><?php

    echo $full_node[0]->image_id;

?></div>

<div id="node-body"><?php

    echo $this->typography->auto_typography($full_node[0]->body);

?></div></article>

<?php

endif;

?>

<?php
//This is for the category pages
if (!empty($category_records)):

?>

<h1><?php

    echo $category_records[0]->name;

?></h1>

<?php

    foreach ($category_details as $cat):

?>

<article class="category-summary">

<h2><?php

        echo $cat->title;

?></h2>

<div class="category-summary-date"><?php

        echo strftime("%B %d, %Y", strtotime($cat->date));

?></div>

<div class="category-summary-teaser">
<?php

        echo $this->typography->auto_typography(character_limiter($cat->body, 320));

?>
</div>

<div class="read-more"><a href="<?php

        echo base_url();

?>index.php/content/node/<?php

        echo $cat->id

?>">Read more</a></div>

</article>

<?php

    endforeach;

?>

<?php

endif;

?>

</section>
<!-- End column one -->

<section id="column-two">

<menu>
<ul>
<?php

foreach ($full_menu as $menu_item):

?>

<li><a href=""><?php

    echo $menu_item->name

?></a></li>

<?php

endforeach;

?>
</ul>
</menu>


</section><!-- End column two -->

<section id="column-three">

</section><!-- End column three -->

</div><!-- End content -->