<?php

///////////////////////////
// Extend WordPress search 
///////////////////////////
// include custom fields
function cf_search_join( $join ) {
    global $wpdb;
    if ( is_search() ) {    
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}
// Extend to where
function cf_search_where( $where ) {
    global $pagenow, $wpdb;
    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }
    return $where;
}
// Prevent duplicates
function cf_search_distinct( $where ) {
    global $wpdb;
    if ( is_search() ) {
        return "DISTINCT";
    }
    return $where;
}
// limit to 4 results
function my_limit_archives( $args ) {
    $args['limit'] = 4;
    return $args;
}
// Search pages, not just posts
function filter_search($query) {
    if ($query->is_search) {
    $query->set('post_type', array('post', 'page'));
    };
    return $query;
};
add_filter( 'posts_distinct', 'cf_search_distinct' );
add_filter('posts_join', 'cf_search_join' );
add_filter( 'posts_where', 'cf_search_where' );
add_filter('pre_get_posts', 'filter_search');
add_filter( 'widget_archives_args', 'my_limit_archives' );
add_filter( 'widget_archives_dropdown_args', 'my_limit_archives' );

?>