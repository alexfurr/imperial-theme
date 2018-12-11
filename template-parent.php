<?php
get_header(); ?>
<div id="imperial_page_title">
<h1 class="entry-title"><?php the_title(); ?></h1>
</div>
<main id="content" tabindex="-1">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-content">



<?php


	// Get the location of the menu	
	$childrenLocation = get_post_meta( $post->ID, 'childrenLocation', true );
	
	$atts = array();
	$children = $imperialPageList->drawChildList($atts);
	
	if($childrenLocation=="")
	{
		echo $children;
	}

	the_content();
	
	
	if($childrenLocation=="bottom")
	{
		echo $children;
	}	
	
	?>
<div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
</article>
<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
<?php endwhile; endif; ?>
<?php edit_post_link($editPageIcon. 'Edit this page', '<br/><br/>', '',  '', 'editPageButton'); ?>
</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>