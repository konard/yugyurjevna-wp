<?php
/**
 * Prints HTML with the comment count for the current post.
 */
if (!function_exists('almaz_theme_comment_count')) :
    function almaz_theme_comment_count()
    {
        if (!post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';

            comments_popup_link(sprintf(__('Leave a comment<span class="screen-reader-text"> on %s</span>', 'almaz-theme'), get_the_title()));
            echo '</span>';
        }
    }
endif;