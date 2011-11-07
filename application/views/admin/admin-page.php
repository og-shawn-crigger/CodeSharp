<?php

/**
 * @author Andy Walpole
 * @date 29/9/2011
 * 
 */

?>

<div id="wrapper" class="admin">
<header class="clearfix">
  <h1><?php

echo SITENAME;

?> / admin</h1>
</header>
<!-- End header -->
<div id="content" class="clearfix">
  <header>  <?php echo top_admin_menu(); 
  // function to be found in admin_top_menu_helper
  ?></header>
  <div id="main-admin"> <a href="admin-config">
    <section>
      <header>Admin configuration</header>
      <article>Change the name of the site, slogan, main email, switch meta and keyword descriptions on and off and set the error reporting level</article>
    </section>
    </a> <a href="admin-content">
    <section>
      <header>Add content article</header>
      <article>Create a new content article</article>
    </section>
    </a> <a href="admin-edit-content">
    <section>
      <header>Edit content articles</header>
      <article>Edit a previously created article</article>
    </section>
    </a> <a href="admin-category">
    <section>
      <header>Add or edit existing categories</header>
      <article>It is possible to create or edit an existing category</article>
    </section>
    </a> <a href="admin-user">
    <section>
      <header>Add or edit existing users</header>
      <article>Add a new user or edit an existing user</article>
    </section>
    </a> <a href="admin-menu">
    <section>
      <header>Menu items</header>
      <article>Add or edit an existing menu item</article>
    </section>
    </a> </div>
  <!-- end main-admin -->
</div>
<!-- End content -->
