<?php
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
if (!function_exists('almaz_theme_entry_footer')) :
    function almaz_theme_entry_footer()
    {

        // Hide author, post date, category and tag text for pages.
        if ('post' === get_post_type()) {

            // Posted by
            almaz_theme_posted_by();

            // Posted on
            almaz_theme_posted_on();

            $categories_list = get_the_category_list(__(', ', 'almaz-theme'));
            if ($categories_list) {
                printf(
                    '<span class="cat-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
                    __('Posted in', 'almaz-theme'),
                    $categories_list
                );
            }

            $tags_list = get_the_tag_list('', __(', ', 'almaz-theme'));
            if ($tags_list) {
                printf(
                    '<span class="tags-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
                    __('Tags:', 'almaz-theme'),
                    $tags_list
                );
            }
        }

        // Comment count.
        if (!is_singular()) {
            almaz_theme_comment_count();
        }
    }
endif;