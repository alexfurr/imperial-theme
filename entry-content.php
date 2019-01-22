<div class="entry-content">

<!-- Add the author and date for posts -->

<?php 
$thedate = get_the_date();
$fname = get_the_author_meta('first_name');
$lname = get_the_author_meta('last_name');
$thetitle=get_the_title(); 

echo '<h2 class="post-title">'.$thetitle.'</h2>';
echo '<span class="post-author">By '.$fname. ' ' .$lname.'</span>';
echo '<span class="post-date"> | '.$thedate.'</span>';


?>



<?php the_content(); ?>

<div class="entry-links"><?php wp_link_pages(); ?></div>

</div>