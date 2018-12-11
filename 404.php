<?php get_header(); ?>
<div id="imperial_page_title">
<h1 class="entry-title">Page not found</h1>
</div>
<main id="content">
<div id="contentWrap">

Sorry, we can't find that particular page!
<br/><br/>
Try searching for the content below<br/>

<div class="imperial-form">
<?php get_search_form(); ?>
</div>

<?php
echo '<img src = "'.get_template_directory_uri().'/images/404.png">';
?>

</div>
</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>