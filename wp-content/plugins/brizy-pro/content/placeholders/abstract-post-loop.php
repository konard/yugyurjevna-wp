<?php

abstract class BrizyPro_Content_Placeholders_AbstractPostLoop extends Brizy_Content_Placeholders_Abstract
{
    static protected $wpLoopQuery = null;

    /**
     * @return null
     */
    public static function createWpLoopQuery($attributes)
    {
        $wp_query = self::getWpQueryWithParams($attributes);

        return self::$wpLoopQuery = $wp_query;
    }

    protected function getWpPostInstance($id)
    {
        global $wpdb;
        $_post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d LIMIT 1", $id));

        if (!$_post) {
            return false;
        }

        $_post = sanitize_post($_post, 'raw');

        return new WP_Post($_post);
    }

    /**
     * @return mixed|string
     */
    protected function getOptionValue()
    {
        return $this->getReplacePlaceholder();
    }

    /**
     * @param $attributes
     *
     * @return array
     */
    protected function getPosts($attributes)
    {
        $query = self::createWpLoopQuery($attributes);
        return $query->posts;
    }

    /**
     * @param $attributes
     *
     * @return int
     */
    protected function getPostCount($attributes)
    {
        $query = self::createWpLoopQuery($attributes);
        return $query->found_posts;
    }

    public static function getPaginationKey()
    {
        return apply_filters('brizy_postloop_pagination_key', 'bpage');
    }

    protected static function pagedValue()
    {
        if ($paged = get_query_var(self::getPaginationKey())) {
            return (int)$paged;
        }

        return 1;
    }

    protected static function getWpQueryWithParams($attributes)
    {
        global $wp_query;

        $myQuery = null;

        $paged = self::pagedValue();
        $attributes = array_map(function ($value) {
            return html_entity_decode($value, ENT_QUOTES);
        }, $attributes);

        if (isset($attributes['query']) && !empty($attributes['query'])) {
            $params = array(
                'fields' => 'ids',
                'posts_per_page' => isset($attributes['count']) ? $attributes['count'] : 3,
                'post_type' => isset($attributes['post_type']) ? $attributes['post_type'] : array_keys(get_post_types(['public' => true])),
                'paged' => $paged,
            );
            $orderBy = isset($attributes['orderby']) ? $attributes['orderby'] : 'none';
            $order1 = isset($attributes['order']) ? $attributes['order'] : 'ASC';
            $wpParseArgs = wp_parse_args($attributes['query']);
            self::setOrderBy($params, $orderBy, $order1);
            $params = array_merge($params, $wpParseArgs);
            $myQuery = new WP_Query();
        } else {
            $params = $wp_query->query_vars;
            $orderby = isset($attributes['orderby']) ? $attributes['orderby'] : (isset($params['orderby']) ? $params['orderby'] : null);
            $order = isset($attributes['order']) ? $attributes['order'] : (isset($params['order']) ? $params['order'] : null);

            $params['fields'] = 'ids';
            $params['post__not_in'] = isset($params['post__not_in']) ? $params['post__not_in'] : [];
            $params['post__in'] = isset($params['post__in']) ? $params['post__in'] : [];
            $params['posts_per_page'] = isset($attributes['count']) ? (int)$attributes['count'] : (isset($params['posts_per_page']) ? $params['posts_per_page'] : null);
            $params['post__not_in'] = array_merge((array)$params['post__not_in'], isset($attributes['post__not_in']) ? explode(',', $attributes['post__not_in']) : []);
            $params['post__in'] = array_merge((array)$params['post__in'], isset($attributes['post__in']) ? explode(',', $attributes['post__in']) : []);
            $params['paged'] = (int)$paged;

            self::setOrderBy($params, $orderby, $order);

            $myQuery = $wp_query;
        }

        if (isset($attributes['offset']) && $attributes['offset'] > 0) {
            $ids = self::getOffsetPostIds($params, $attributes['offset']);
            $params['post__not_in'] = array_merge(isset($params['post__not_in']) ? $params['post__not_in'] : [], $ids);
        }

        $params = apply_filters('brizy_post_loop_args', $params);

        $closure = function ($query) use ($params) {
            $query->set('posts_per_page', intval($params['posts_per_page']));
        };

        add_action('parse_tax_query', $closure);
        $myQuery->query($params);
        remove_action('parse_tax_query', $closure);

        return $myQuery;
    }

    private static function getOffsetPostIds($params, $offset)
    {
        $params['posts_per_page'] = $offset;
        $params['paged'] = 1;

        $query = new WP_Query($params);
        $ids = $query->posts;
        unset($query);

        return $ids;
    }

    private static function setOrderBy(&$args, $orderBy, $order)
    {
        $args['orderby'] = $orderBy;
        $args['order'] = $order;

        // Check if orderBy is a meta key by checking if it's not a standard WordPress post field
        $standard_orderby_values = array(
            'none', 'ID', 'author', 'title', 'name', 'type', 'date', 'modified',
            'parent', 'rand', 'comment_count', 'relevance', 'menu_order',
            'meta_value', 'meta_value_num', 'post__in', 'post_parent__in', 'post_name__in'
        );

        // If orderBy is not a standard WordPress field, treat it as a meta key
        if (!in_array($orderBy, $standard_orderby_values)) {
            $args['meta_key'] = $orderBy;
            $args['orderby'] = 'meta_value';
        }
    }
}
