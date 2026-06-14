<?php
/**
 * Template part for displaying posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <footer class="entry-footer">
        <?php almaz_theme_entry_footer(); ?>
    </footer><!-- .entry-footer -->

    <div class="page-content">
        <div class="site-featured-image">
            <?php almaz_theme_post_thumbnail(); ?>
        </div>

        <?php the_content(); ?>


    </div><!-- .entry-content -->



</article><!-- #post-${ID} -->
