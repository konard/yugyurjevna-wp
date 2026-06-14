<?php
/**
 * Template part for displaying a message that posts cannot be found
 */

?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php _e('Nothing Found', 'almaz-theme'); ?></h1>
    </header>

    <div class="page-content">
        <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'almaz-theme'); ?></p>
        <?php get_search_form(); ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->
