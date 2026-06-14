<?php
/**
 * Prints HTML with meta information about theme author.
 */
if (!function_exists('almaz_theme_posted_by')) :
    function almaz_theme_posted_by()
    {
        printf(
            '<span class="byline"><span class="screen-reader-text">%1$s</span><span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></span>',
            __('Posted by', 'almaz-theme'),
            esc_url(get_author_posts_url(get_the_author_meta('ID'))),
            esc_html(get_the_author())
        );
    }
endif;