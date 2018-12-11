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

	$currentPageID = get_the_ID();
	$parentPageID = wp_get_post_parent_id( $currentPageID ); 


	// Get the parent Page Name
	$parentName = get_the_title($parentPageID);
	$parentURL = get_the_permalink($parentPageID);
	
	
	// Get the siblings
	$args = array(
	'posts_per_page'   => -1,
	'sort_column'          => 'menu_order',
	'sort_order'            => 'ASC',								
	'parent'      => $parentPageID,
	'post_status'      => 'publish',
	);
	$siblings = get_pages( $args );
	
	$subMenu='<a href="'.$parentURL.'"><div class="submenuTitle">'.$parentName.'</div></a>';
	$subMenu.='<ul>';
	
	foreach ($siblings as $siblingInfo)
	{
	
		$pageName           = $siblingInfo->post_title;
		$pageID             = $siblingInfo->ID;
		$pageURL            = get_permalink($pageID);			
		
		$subMenu.='<a href="'.$pageURL.'">';
		$subMenu.='<li';
		if($currentPageID==$pageID)
		{
			$subMenu.= ' class="activeTab"';
		}
		
		
		$subMenu.='>'.$pageName.' <i class="fas fa-chevron-right submenuChevron"></i></li></a>';
	}
	$subMenu.='</ul>';
	
	// Show a sub menu on this page
	echo '<div class="subpage-content-wrap clearfix">';				
	echo '<div class="subpage-submenu">'.$subMenu.'</div>';
	echo '<div class="subpage-content">';

?>

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


	echo '</div>';				
	echo '</div>';
	
	// Custom CSS for this page
	echo '<style>
	#content
	{
		padding-left:0px;
	}
	.entry-content
	{
		padding-left:0px;
		padding-top:0px;
	}
	
	
	</style>';



?>
</div>
</article>
<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
<?php endwhile; endif; ?>
<?php edit_post_link($editPageIcon. 'Edit this page', '<br/><br/>', '',  '', 'editPageButton'); ?>
</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>