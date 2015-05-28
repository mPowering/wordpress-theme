<?php

//Defined Textdomain
define('ZEETEXTDOMAIN', wp_get_theme()->get( 'TextDomain' ));

define('ZEETHEMENAME', wp_get_theme()->get( 'Name' ));

// metaboxes directory constant
define( 'CUSTOM_METABOXES_DIR', get_template_directory_uri() . '/admin/metaboxes' );


// registaring menu
register_nav_menus( array(
    'primary'   => __('Primary', ZEETEXTDOMAIN),
    'footer'    => __('Footer', ZEETEXTDOMAIN)
    ));


// fontawesome icons list
require_once( get_template_directory()  . '/admin/fontawesome-icons.php');

// css classes
require_once( get_template_directory()  . '/admin/css-color-classes.php');

//Google Fonts
require_once( get_template_directory()  . '/admin/themeoptions/functions/googlefonts.php');

// MCE Buttons
require_once( get_template_directory()  . '/admin/shortcodes/tinymce.button.php');

// Meta boxes
require_once( get_template_directory()  . '/admin/metaboxes/meta_box.php');

// Theme Option Settings
require_once( get_template_directory()  . '/admin/themeoptions/index.php');

// Shortcodes
require_once( get_template_directory()  . '/lib/shortcodes.php');

//Theme Functions
require_once( get_template_directory()  . '/lib/theme-functions.php');

// nav walker
require_once( get_template_directory()  . '/lib/navwalker.php');

require_once( get_template_directory()  . '/lib/mobile-navwalker.php');

// widgets
require_once( get_template_directory()  . '/lib/widgets.php');

require_once( get_template_directory()  . '/admin/plugin-setup.php');

//
add_action('after_setup_theme', function(){

    // load textdomain
    load_theme_textdomain(ZEETEXTDOMAIN, get_template_directory() . '/languages');


    // post format support
    add_theme_support(
        'post-formats', array(
          'audio', 'gallery', 'image', 'video'
          )
        );


    // post thumbnail support
    add_theme_support('post-thumbnails');

    add_theme_support( 'automatic-feed-links' );

});

if ( is_singular() && get_option( 'thread_comments' ) ){
    wp_enqueue_script( 'comment-reply' );
}


if ( ! function_exists( 'zee_option' ) ) {

    /**
     * Getting theme option
     * @param  boolean $index  [first index of theme array]
     * @param  boolean $index2 [second index of first index array]
     * @return string          [return option data]
     */

    function zee_option($index=false, $index2=false ){

        global $data;

        if( $index2 ){
            return ( isset($data[$index]) and isset($data[$index][$index2]) ) ?  $data[$index][$index2] : '';
        } else {
            return isset( $data[$index] ) ?  $data[$index] : '';
        }
    }
}

// adding scripts at admin panel
add_action( 'admin_enqueue_scripts', function(){
    wp_enqueue_script( 'zee_admin_js', get_template_directory_uri() . '/admin/js/admin.js', false, '1.0.0' );
});

// decativate default gallery css
add_filter( 'use_default_gallery_style', '__return_false' );

// adding prettyPhoto each gallery item
add_filter( 'wp_get_attachment_link', function( $content, $id, $size, $permalink ){

    if( !$permalink ){
        $content = preg_replace("/<a/","<a rel=\"prettyPhoto[gallery]\"",$content,1); // >
        return $content;
    }
}, 10, 5);



// Content width

if ( ! isset( $content_width ) ) {
    $content_width = 600;
}

//  Set title
add_filter( 'wp_title', function( $title, $sep ) {

    global $paged, $page;

    if ( is_feed() ){
        return $title;
    }

    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );

    if ( $site_description and ( is_home() or is_front_page() ) ){
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 ){
        $title = "$title $sep " . sprintf( __( 'Page %s', ZEETEXTDOMAIN ), max( $paged, $page ) );
    }

    return $title;
}, 10, 2 );



// add shortcode tinymce button
add_filter('mce_buttons', function ($mce_buttons) {

    $pos = array_search('wp_more', $mce_buttons, true);

    if ($pos !== false) {
        $buttons = array_slice($mce_buttons, 0, $pos + 1);
        $buttons[] = 'wp_page';
        $mce_buttons = array_merge($buttons, array_slice($mce_buttons, $pos + 1));
    }
    return $mce_buttons;
});

/**
 * Getting post thumbnail url
 * @param  [int]                $pots_ID [Post ID]
 * @return [string]             [Return thumbail source url]
 */
function zee_get_thumb_url($pots_ID){
    return wp_get_attachment_url( get_post_thumbnail_id( $pots_ID ) );
}


if( ! function_exists('zee_scripts') ){

// adding scripts
    add_action('wp_enqueue_scripts', 'zee_scripts');

    function zee_scripts() {

    // Javascripts
        wp_enqueue_script('bootstrap-js',   get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'));
        wp_enqueue_script('prettyPhoto',    get_template_directory_uri() . '/assets/js/jquery.prettyPhoto.js');
        wp_enqueue_script('isotope',        get_template_directory_uri() . '/assets/js/jquery.isotope.min.js');
        wp_enqueue_script('main-js',        get_template_directory_uri() . '/assets/js/main.js');

    // Stylesheet
        wp_enqueue_style('bootstrap-min',   get_template_directory_uri() . '/assets/css/bootstrap.min.css');
        wp_enqueue_style('prettyPhoto',     get_template_directory_uri() . '/assets/css/prettyPhoto.css');
        wp_enqueue_style('animate',         get_template_directory_uri() . '/assets/css/animate.css');
        wp_enqueue_style('fontawesome',     get_template_directory_uri() . '/assets/css/font-awesome.min.css');
        wp_enqueue_style('style',           get_template_directory_uri() . '/style.css');
    // Inline css
        wp_add_inline_style( 'style',       zee_style_options() );
    }
}

/* Press Releases */
// Define the 'Portfolio' post type. This is used to represent galleries
// of photos. This will be our top-level custom post type menu
$args = array(
  'labels'	=>	array(
            'all_items'           => 	'Reports and Documents',
						'menu_name'	          =>	'Resources',
						'singular_name' =>	'Reports and Documents',
					 	'edit_item' =>	'Edit Reports and Documents',
					 	'new_item'  =>	'New Reports and Documents',
					 	'view_item' =>	'View Reports and Documents',
					 	'items_archive' =>	'Reports and Documents Archive',
					 	'search_items'  =>	'Search Reports and Documents',
					 	'not_found'	    =>	'No Reports and Documents found.',
					 	'not_found_in_trash'  => 'No Reports and Documents found in trash.'
					),
	'supports'		=>	array( 'title', 'editor' ),
	'menu_position' => 25,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
    'capability_type' => 'page',
	'public'		=>	true
);
register_post_type( 'reports', $args );

$args = array(
  'labels'	=>	array(
						'all_items' => 	'External Links',
						'menu_name'	=>	'External Links',
						'singular_name' =>	'External Links',
					 	'edit_item' =>	'Edit External Links',
					 	'new_item'  =>	'New External Links',
					 	'view_item' =>	'View External Links',
					 	'items_archive' =>	'External Links Archive',
					 	'search_items'  =>	'Search External Links',
					 	'not_found'	    =>	'No External Links found.',
					 	'not_found_in_trash'  => 'No External Links found in trash.'
					),
	'show_in_menu'  =>	'edit.php?post_type=reports', // This is where we tell WordPress to add 'Locations' as a submenu
    'supports' => array('title'),
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
    'capability_type' => 'page',
	'public'		    =>	true
);
register_post_type( 'links', $args );

$args = array(
  'labels'	=>	array(
						'all_items' => 	'Videos',
						'menu_name'	=>	'Videos',
						'singular_name' =>	'Videos',
					 	'edit_item' =>	'Edit Videos',
					 	'new_item'  =>	'New Videos',
					 	'view_item' =>	'View Videos',
					 	'items_archive' =>	'Videos Archive',
					 	'search_items'  =>	'Search Videos',
					 	'not_found'	    =>	'No Videos found.',
					 	'not_found_in_trash'  => 'No Videos found in trash.'
					),
	'supports'      =>	array( 'title', 'editor' ),
	'show_in_menu'  =>	'edit.php?post_type=reports', // This is where we tell WordPress to add 'Locations' as a submenu
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
    'capability_type' => 'page',
	'public'		    =>	true
);
register_post_type( 'videos', $args );

// hide "add new" on wp-admin menu
function hd_add_box() {
  global $submenu;
  unset($submenu['edit.php?post_type=reports'][10]);
}

add_action('admin_menu', 'hd_add_box');

// page subtitle

$prefix = 'page_';
$fields = array(

    array( 
        'label' => __('Subtitle', ZEETEXTDOMAIN), 
        'id'    => $prefix.'subtitle',
        'type'  => 'text'
        ) 
    );

new Custom_Add_Meta_Box( 'zee_page_box', __('Subtitle Options', ZEETEXTDOMAIN), $fields, 'page', true );
new Custom_Add_Meta_Box( 'zee_page_box', __('Subtitle Options', ZEETEXTDOMAIN), $fields, 'zee_resource', true );

/**
* Add common scripts and stylesheets
*/

if( ! function_exists('zee_pagination') ){

/**
 * Display pagination
 * @return [string] [pagination]
 */
function zee_pagination() {
    global $wp_query;
    if ($wp_query->max_num_pages > 1) {
            $big = 999999999; // need an unlikely integer
            $items =  paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'prev_next'    => true,
                'current' => max( 1, get_query_var('paged') ),
                'total' => $wp_query->max_num_pages,
                'type'=>'array'
                ) );

            $pagination ="<ul class='pagination'>\n\t<li>";
            $pagination .=join("</li>\n\t<li>", $items);
            $pagination ."</li>\n</ul>\n";
            
            return $pagination;
        }
        return;
    }   

}



if ( ! function_exists( 'zee_post_nav' ) ) {


/**
 * Display post nav
 * @return [type] [description]
 */

function zee_post_nav() {
    global $post;

    // Don't print empty markup if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next and ! $previous ){
        return;
    } 
    ?>
    <nav class="navigation post-navigation" role="navigation">
        <div class="pager">
            <?php if ( $previous ) { ?>
            <li class="previous">
                <?php previous_post_link( '%link', _x( '<i class="icon-long-arrow-left"></i> %title', 'Previous post link', ZEETEXTDOMAIN ) ); ?>
            </li>
            <?php } ?>

            <?php if ( $next ) { ?>
            <li class="next"><?php next_post_link( '%link', _x( '%title <i class="icon-long-arrow-right"></i>', 'Next post link', ZEETEXTDOMAIN ) ); ?></li>
            <?php } ?>

        </div><!-- .nav-links -->
    </nav><!-- .navigation -->
    <?php
}
}


if( ! function_exists('zee_link_pages') ){

    function zee_link_pages($args = '') {
        $defaults = array(
            'before' => '' ,
            'after' => '',
            'link_before' => '', 
            'link_after' => '',
            'next_or_number' => 'number', 
            'nextpagelink' => __('Next page', ZEETEXTDOMAIN),
            'previouspagelink' => __('Previous page', ZEETEXTDOMAIN), 
            'pagelink' => '%',
            'echo' => 1
            );

        $r = wp_parse_args( $args, $defaults );
        $r = apply_filters( 'wp_link_pages_args', $r );
        extract( $r, EXTR_SKIP );

        global $page, $numpages, $multipage, $more, $pagenow;

        $output = '';
        if ( $multipage ) {
            if ( 'number' == $next_or_number ) {
                $output .= $before . '<ul class="pagination">';
                $laquo = $page == 1 ? 'class="disabled"' : '';
                $output .= '<li ' . $laquo .'>' . _wp_link_page($page -1) . '&laquo;</li>';
                for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
                    $j = str_replace('%',$i,$pagelink);

                    if ( ($i != $page) || ((!$more) && ($page==1)) ) {
                        $output .= '<li>';
                        $output .= _wp_link_page($i) ;
                    }
                    else{
                        $output .= '<li class="active">';
                        $output .= _wp_link_page($i) ;
                    }
                    $output .= $link_before . $j . $link_after ;

                    $output .= '</li>';
                }
                $raquo = $page == $numpages ? 'class="disabled"' : '';
                $output .= '<li ' . $raquo .'>' . _wp_link_page($page +1) . '&raquo;</li>';
                $output .= '</ul>' . $after;
            } else {
                if ( $more ) {
                    $output .= $before . '<ul class="pager">';
                    $i = $page - 1;
                    if ( $i && $more ) {
                        $output .= '<li class="previous">' . _wp_link_page($i);
                        $output .= $link_before. $previouspagelink . $link_after . '</li>';
                    }
                    $i = $page + 1;
                    if ( $i <= $numpages && $more ) {
                        $output .= '<li class="next">' .  _wp_link_page($i);
                        $output .= $link_before. $nextpagelink . $link_after . '</li>';
                    }
                    $output .= '</ul>' . $after;
                }
            }
        }

        if ( $echo ){
            echo $output;
        } else {
            return $output;
        } 
    }
}



if( ! function_exists('zee_get_avatar_url') ){
/**
 * Get avatar url
 * @param  [string] $get_avatar [Avater image link]
 * @return [string]             [image link]
 */
function zee_get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}
}




if( ! function_exists("zee_comments_list") ){

/**
 * Comments link
 * @param   $comment [comments]
 * @param   $args    [arguments]
 * @param   $depth   [depth]
 * @return void          
 */
function zee_comments_list($comment, $args, $depth) {

    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) {
        case 'pingback' :
        case 'trackback' :
        // Display trackbacks differently than normal comments.
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            <p><?php _e( 'Pingback:', ZEETEXTDOMAIN ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', ZEETEXTDOMAIN ), '<span class="edit-link">', '</span>' ); ?></p>
            <?php
            break;
            default :
            // Proceed with normal comments.
            global $post;
            ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>" class="comment media">
                    <div class="pull-left comment-author vcard">
                        <?php 
                        $get_avatar = get_avatar( $comment, 48 );
                        $avatar_img = zee_get_avatar_url($get_avatar);
                             //Comment author avatar 
                        ?>
                        <img class="avatar img-circle" src="<?php echo $avatar_img ?>" alt="">
                    </div>

                    <div class="media-body">

                        <div class="well">

                            <div class="comment-meta media-heading">
                                <span class="author-name">
                                    <?php _e('By', ZEETEXTDOMAIN); ?> <strong><?php echo get_comment_author(); ?></strong>
                                </span>
                                -
                                <time datetime="<?php echo get_comment_date(); ?>">
                                    <?php echo get_comment_date(); ?> <?php echo get_comment_time(); ?>
                                    <?php edit_comment_link( __( 'Edit', ZEETEXTDOMAIN ), '<small class="edit-link">', '</small>' ); //edit link ?>
                                </time>

                                <span class="reply pull-right">
                                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' =>  sprintf( __( '%s Reply', ZEETEXTDOMAIN ), '<i class="icon-repeat"></i> ' ) , 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                                </span><!-- .reply -->
                            </div>

                            <?php if ( '0' == $comment->comment_approved ) {  //Comment moderation ?>
                            <div class="alert alert-info"><?php _e( 'Your comment is awaiting moderation.', ZEETEXTDOMAIN ); ?></div>
                            <?php } ?>

                            <div class="comment-content comment">
                                <?php comment_text(); //Comment text ?>
                            </div><!-- .comment-content -->

                        </div><!-- .well -->


                    </div>
                </div><!-- #comment-## -->
                <?php
                break;
} // end comment_type check

}

}

// registering sidebar

register_sidebar(array(
  'name' => __( 'Sidebar', ZEETEXTDOMAIN ),
  'id' => 'sidebar',
  'description' => __( 'Widgets in this area will be shown on right side.', ZEETEXTDOMAIN ),
  'before_title' => '<h3>',
  'after_title' => '</h3>',
  'before_widget' => '<div>',
  'after_widget' => '</div>'
  )
);

register_sidebar(array(
  'name' => __( 'Bottom', ZEETEXTDOMAIN ),
  'id' => 'bottom',
  'description' => __( 'Widgets in this area will be shown before Footer.' , ZEETEXTDOMAIN),
  'before_title' => '<h3>',
  'after_title' => '</h3>',
  'before_widget' => '<div class="col-sm-3 col-xs-6">',
  'after_widget' => '</div>'
  )
);

if( ! function_exists('zee_comment_form') ){

/**
 * Comment form
 */

function zee_comment_form($args = array(), $post_id = null ){


    if ( null === $post_id )
        $post_id = get_the_ID();
    else
        $id = $post_id;

    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    if ( ! isset( $args['format'] ) )
        $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';


    $req      = get_option( 'require_name_email' );

    $aria_req = ( $req ? " aria-required='true'" : '' );

    $html5    = 'html5' === $args['format'];

    $fields   =  array(
        'author' => '
        <div class="form-group">
        <div class="col-sm-6 comment-form-author">
        <input   class="form-control"  id="author" 
        placeholder="' . __( 'Name', ZEETEXTDOMAIN ) . '" name="author" type="text" 
        value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />
        </div>',


        'email'  => '<div class="col-sm-6 comment-form-email">
        <input id="email" class="form-control" name="email" 
        placeholder="' . __( 'Email', ZEETEXTDOMAIN ) . '" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' 
        value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' />
        </div>
        </div>',
        

        'url'    => '<div class="form-group">
        <div class=" col-sm-12 comment-form-url">' .
        '<input  class="form-control" placeholder="'. __( 'Website', ZEETEXTDOMAIN ) .'"  id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '"  />
        </div></div>',

        );

$required_text = sprintf( ' ' . __('Required fields are marked %s', ZEETEXTDOMAIN), '<span class="required">*</span>' );

$defaults = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields ),

    'comment_field'        => '
    <div class="form-group comment-form-comment">
    <div class="col-sm-12">
    <textarea class="form-control" id="comment" name="comment" placeholder="' . _x( 'Comment', 'noun', ZEETEXTDOMAIN ) . '" rows="8" aria-required="true"></textarea>
    </div>
    </div>
    ',

    'must_log_in'          => '


    <div class="alert alert-danger must-log-in">' 
    . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) 
    . '</div>',

    'logged_in_as'         => '<div class="alert alert-info logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', ZEETEXTDOMAIN ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</div>',

    'comment_notes_before' => '<div class="alert alert-info comment-notes">' . __( 'Your email address will not be published.', ZEETEXTDOMAIN ) . ( $req ? $required_text : '' ) . '</div>',

    'comment_notes_after'  => '<div class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', ZEETEXTDOMAIN ), ' <code>' . allowed_tags() . '</code>' ) . '</div>',

    'id_form'              => 'commentform',

    'id_submit'            => 'submit',

    'title_reply'          => __( 'Leave a Reply', ZEETEXTDOMAIN ),

    'title_reply_to'       => __( 'Leave a Reply to %s', ZEETEXTDOMAIN ),

    'cancel_reply_link'    => __( 'Cancel reply', ZEETEXTDOMAIN ),

    'label_submit'         => __( 'Post Comment', ZEETEXTDOMAIN ),

    'format'               => 'xhtml',
    );


$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

if ( comments_open( $post_id ) ) { ?>

<?php do_action( 'comment_form_before' ); ?>

<div id="respond" class="comment-respond">

    <h3 id="reply-title" class="comment-reply-title">
        <?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> 
        <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small>
    </h3>

    <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) { ?>

    <?php echo $args['must_log_in']; ?>

    <?php do_action( 'comment_form_must_log_in_after' ); ?>

    <?php } else { ?>

    <form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" 
        class="form-horizontal comment-form"<?php echo $html5 ? ' novalidate' : ''; ?> role="form">
        <?php do_action( 'comment_form_top' ); ?>

        <?php if ( is_user_logged_in() ) { ?>

        <?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>

        <?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>

        <?php } else { ?>

        <?php echo $args['comment_notes_before']; ?>

        <?php

        do_action( 'comment_form_before_fields' );

        foreach ( (array) $args['fields'] as $name => $field ) {
            echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
        }

        do_action( 'comment_form_after_fields' );

    } 

    echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); 

    echo $args['comment_notes_after']; ?>

    <div class="form-submit">
        <input class="btn btn-danger btn-lg" name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
        <?php comment_id_fields( $post_id ); ?>
    </div>

    <?php do_action( 'comment_form', $post_id ); ?>

</form>

<?php } ?>

</div><!-- #respond -->
<?php do_action( 'comment_form_after' ); ?>
<?php } else { ?>
<?php do_action( 'comment_form_comments_closed' ); ?>
<?php } ?>
<?php


}

}


if( ! function_exists('zee_post_password_form') ){

/**
 * post password form
 */

function zee_post_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );

    $o = '
    <div class="row">
    <form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    <div class="col-lg-6">
    ' . __( "To view this protected post, enter the password below:", ZEETEXTDOMAIN ) . '
    <div class="input-group">
    <input class="form-control" name="post_password" placeholder="' . __( "Password:", ZEETEXTDOMAIN ) . '" id="' . $label . '" type="password" /><span class="input-group-btn"><button class="btn btn-info" type="submit" name="Submit">' . esc_attr__( "Submit", ZEETEXTDOMAIN ) . '</button></span>
    </div><!-- /input-group -->
    </div><!-- /.col-lg-12 -->
    </form>
    </div>';
    return $o;
}

add_filter( 'the_password_form', 'zee_post_password_form' );
}



if ( ! function_exists( 'zee_the_attached_image' ) ) {
/**
 * Prints the attached image with a link to the next attached image.
 *
 *
 * @return void
 */
function zee_the_attached_image() {
    $post                = get_post();
    $attachment_size     = array( 724, 724 );
    $next_attachment_url = wp_get_attachment_url();

    /**
     * Grab the IDs of all the image attachments in a gallery so we can get the URL
     * of the next adjacent image in a gallery, or the first image (if we're
     * looking at the last image in a gallery), or, in a gallery of one, just the
     * link to that image file.
     */
    $attachment_ids = get_posts( array(
        'post_parent'    => $post->post_parent,
        'fields'         => 'ids',
        'numberposts'    => -1,
        'post_status'    => 'inherit',
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'order'          => 'ASC',
        'orderby'        => 'menu_order ID'
        ) );

    // If there is more than 1 attachment in a gallery...
    if ( count( $attachment_ids ) > 1 ) {
        foreach ( $attachment_ids as $attachment_id ) {
            if ( $attachment_id == $post->ID ) {
                $next_id = current( $attachment_ids );
                break;
            }
        }

        // get the URL of the next image attachment...
        if ( $next_id )
            $next_attachment_url = get_attachment_link( $next_id );

        // or get the URL of the first image attachment.
        else
            $next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
    }

    printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
        esc_url( $next_attachment_url ),
        the_title_attribute( array( 'echo' => false ) ),
        wp_get_attachment_image( $post->ID, $attachment_size )
        );
}
}

function register_cpt_teams() {

    $labels = array(
        'name' => _x( 'Teams', 'team' ),
        'singular_name' => _x( 'Team', 'team' ),
        'edit_item' => _x( 'Editar Team', 'team' ),
        'view_item' => _x( 'Ver Team', 'team' ),
        'search_items' => _x( 'Buscar Teams', 'team' ),
        'not_found' => _x( 'No se encontraron Teams', 'team' ),
        'not_found_in_trash' => _x( 'No hay Teams en la papelera', 'team' ),
        'parent_item_colon' => _x( 'Padre Team:', 'team' ),
        'menu_name' => _x( 'Teams', 'team' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Gestionar Teams',
        'supports' => array( 'title', 'editor', 'thumbnail'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 25,
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'team', $args );
}

add_action( 'init', 'register_cpt_teams' );

    // Post type: Sliders
add_action('init', function(){

    $labels = array(
        'name'                  => __( 'Slider',                ZEETEXTDOMAIN ),
        'singular_name'         => __( 'Slider',                ZEETEXTDOMAIN ),
        'menu_name'             => __( 'Sliders',               ZEETEXTDOMAIN ),
        'all_items'             => __( 'All Sliders',           ZEETEXTDOMAIN ),
        'add_new'               => __( 'Add New',               ZEETEXTDOMAIN ),
        'add_new_item'          => __( 'Add New Slider',        ZEETEXTDOMAIN ),
        'edit_item'             => __( 'Edit Slider',           ZEETEXTDOMAIN ),
        'new_item'              => __( 'New Slider',            ZEETEXTDOMAIN ),
        'view_item'             => __( 'View Slider',           ZEETEXTDOMAIN ),
        'search_items'          => __( 'Search Portfolios',     ZEETEXTDOMAIN ),
        'not_found'             => __( 'No item found',         ZEETEXTDOMAIN ),
        'not_found_in_trash'    => __( 'No item found in Trash',ZEETEXTDOMAIN )
        );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'menu_icon'             => get_template_directory_uri() . '/admin/images/icon-slider.png',
        'rewrite'               => true,
        'capability_type'       => 'post',
        'supports'              => array('title', 'page-attributes', 'editor', 'thumbnail')
        );
    register_post_type('zee_slider', $args);
    flush_rewrite_rules();
});

    // slider metaboxes

$prefix = 'slider_';
$fields = array(
    array(
        'label'                     => __('Background Image',          ZEETEXTDOMAIN),
        'desc'                      => __('Show background image in slider', ZEETEXTDOMAIN),
        'id'                        => $prefix . 'background_image',
        'type'                      => 'image'
        ),



    array(
        'label'                     => __('Button Text',          ZEETEXTDOMAIN),
        'desc'                      => __('Show Slider Button and Button Text', ZEETEXTDOMAIN),
        'id'                        => $prefix . 'button_text',
        'type'                      => 'text'
        ),

    array(
        'label'                     => __('Button URL',       ZEETEXTDOMAIN),
        'desc'                      => __('Slider URL link.', ZEETEXTDOMAIN),
        'id'                        => $prefix . 'button_url',
        'type'                      => 'text'
        ),

    array(
        'label'                     => __('Boxed Style',       ZEETEXTDOMAIN),
        'desc'                      => __('Show boxed Style.', ZEETEXTDOMAIN),
        'id'                        => $prefix . 'boxed',
        'type'                      => 'select',
        'options'                   => array(

            array(
                'value'=>'no',
                'label'=>__('No', ZEETEXTDOMAIN)
                ),

            array(
                'value'=>'yes',
                'label'=>__('Yes', ZEETEXTDOMAIN)
                )
            )
        ),
    array(
        'label'                     => __('Position',       ZEETEXTDOMAIN),
        'desc'                      => __('Show slider Position.', ZEETEXTDOMAIN),
        'id'                        => $prefix . 'position',
        'type'                      => 'select',
        'options'                   => array(

            array(
                'value'=>'left',
                'label'=>__('Left', ZEETEXTDOMAIN)
                ),

            array(
                'value'=>'center',
                'label'=>__('Center', ZEETEXTDOMAIN)
                ),

            array(
                'value'=>'right',
                'label'=>__('Right', ZEETEXTDOMAIN)
                ),
            )
        )
    );



$fields_video = array(

    array(
        'label'                     => __('Video Type',       ZEETEXTDOMAIN),
        'desc'                      => __('Select video type.', ZEETEXTDOMAIN),
        'id'                        => $prefix . 'video_type',
        'type'                      => 'radio',
        'options'                   => array(

            array(
                'value'=>'',
                'label'=>__('None', ZEETEXTDOMAIN)
                ),

            array(
                'value'=>'youtube',
                'label'=>__('Youtube', ZEETEXTDOMAIN)
                ),

            array(
                'value'=>'vimeo',
                'label'=>__('Vimeo', ZEETEXTDOMAIN)
                )
            )
        ),

    array(
        'label'                     => __('Video Link',          ZEETEXTDOMAIN),
        'desc'                      => __('Video link', ZEETEXTDOMAIN),
        'id'                        => $prefix . 'video_link',
        'type'                      => 'text'
        ),
    );


new Custom_Add_Meta_Box( 'zee_slider_box', __('Slider Settings', ZEETEXTDOMAIN), $fields, 'zee_slider', true );
new Custom_Add_Meta_Box( 'zee_slider_box_video', __('Video Settings', ZEETEXTDOMAIN), $fields_video, 'zee_slider', true );

function register_cpt_partners() {

    $labels = array(
        'name' => _x( 'Partners', 'partner' ),
        'singular_name' => _x( 'Partner', 'partner' ),
        'edit_item' => _x( 'Editar Partner', 'partner' ),
        'view_item' => _x( 'Ver Partner', 'partner' ),
        'search_items' => _x( 'Buscar Partners', 'partner' ),
        'not_found' => _x( 'No se encontraron Partners', 'partner' ),
        'not_found_in_trash' => _x( 'No hay Partners en la papelera', 'partner' ),
        'parent_item_colon' => _x( 'Padre Partner:', 'partner' ),
        'menu_name' => _x( 'Partners', 'partner' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Gestionar Partners',
        'supports' => array( 'title', 'editor', 'thumbnail'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 25,
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'partner', $args );
}

add_action( 'init', 'register_cpt_partners' );