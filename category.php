<?php get_header(); ?>
<div id="imperial_page_title">
<h1 class="entry-title"><?php esc_html_e( 'Category Archives: ', 'generic' ); ?><?php the_archive_title(); ?></h1>

<?php if ( '' != the_archive_description() ) echo esc_html( apply_filters( 'archive_meta', '<div class="archive-meta">' . the_archive_description() . '</div>' ) ); ?>

</h1>
</div>
<main id="content">
<div class="entry-content">


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php get_template_part( 'entry' ); ?>

<?php endwhile; endif; ?>

<?php get_template_part( 'nav', 'below' ); ?>
</div>
</main>


<?php get_sidebar(); ?>

<?php get_footer(); ?>