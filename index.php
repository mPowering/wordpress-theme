<?php get_header();

$col= 'col-md-8';
if ( is_active_sidebar( 'sidebar' ) ) {
    $col = 'col-md-8';
}
?>
<div class="row">
    <div id="content" class="site-content <?php echo $col; ?>" role="main">
        <?php if ( have_posts() ) { ?>

        <?php /* The loop */ ?>
        <?php while ( have_posts() ) { the_post(); ?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">

        <div class="entry-thumbnail">
            <?php the_post_thumbnail(); ?>
        </div>

        <?php if ( is_single() ) { ?>
        <h1 class="entry-title">
            <?php the_title(); ?>
            <?php edit_post_link( __( 'Edit', ZEETEXTDOMAIN ), '<small class="edit-link pull-right">', '</small>' ); ?>
        </h1>
        <?php } else { ?>
        <h2 class="entry-title">
            <div class="date-post">
            <span class="day-post"><?php echo get_the_date('d'); ?></span>
            <span class="month-post"><?php echo get_the_date('M'); ?></span>
            </div>
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            <?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
            <sup class="featured-post"><?php _e( 'Sticky', ZEETEXTDOMAIN ) ?></sup>
            <?php } ?>
            <?php edit_post_link( __( 'Edit', ZEETEXTDOMAIN ), '<small class="edit-link pull-right">', '</small>' ); ?>
        </h2>
        <?php } //.entry-title ?>

    </header><!--/.entry-header -->

    <?php if ( is_search() ) { ?>
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
    <?php } else { ?>
    <div class="entry-content">
        <?php echo '<p>' . wp_trim_words( get_the_content(), 50 ) . '</p>'; ?>
        <a class="more" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">READ MORE</a>
    </div>
    <?php } //.entry-content ?>

    <footer>
        <?php zee_link_pages(); ?>
    </footer>

</article><!--/#post-->

<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) { ?>
<?php get_template_part( 'author-bio' ); ?>
<?php } ?>



        <?php } ?>

        <?php echo zee_pagination(); ?>

        <?php } else { ?>
        <?php get_template_part( 'post-templates/content', 'none' ); ?>
        <?php } ?>
    </div><!-- #content -->
    <div id="sidebar" class="col-md-4" role="complementary">
        <div class="sidebar-inner">
            <aside class="widget-area">

    <p class="buble-title">Latest <span>Blogs</span></p>
     <ul class="latest-blogs">
    <?php $the_query = new WP_Query( 'showposts=10' ); ?>

    <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
    <li>
        <p class="date-post">
          <span class="day-post"><?php echo get_the_date('d'); ?></span>
          <span class="month-post"><?php echo get_the_date('M'); ?></span>
        </p>
        <a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
    <?php endwhile;?>
    </ul>
    <br> <?php dynamic_sidebar( 'sidebar' ); ?>
            </aside>
        </div>
    </div>
</div>
<?php get_footer();