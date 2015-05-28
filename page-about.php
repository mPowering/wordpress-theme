<?php
    /**
    * Template Name: About
    */
get_header(); ?>
  <?php
    $page = get_queried_object();

    $ID = $page->ID;

    $title = $page->post_title;
    $sub_title = get_post_meta($ID, 'page_subtitle', true);
    echo (isset($sub_title) ? '

    <section id="title" class="emerald-home">
    <div class="container">
    <div class="row">
    <div class="col-sm-12">
    <p>'.$sub_title.'</p>
    </div>
    </div>
    </div>
    </section>

    ' : '');

   ?>
<section id="page">
    <div class="container">
        <div id="content" class="site-content" role="main">
            <?php /* The loop */ ?>
            <?php while ( have_posts() ) { the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php edit_post_link( __( 'Edit', ZEETEXTDOMAIN ), '<small class="edit-link pull-right ">', '</small><div class="clearfix"></div>' ); ?>
                <div class="entry-content">
                    <?php the_content(); ?>
                    <?php zee_link_pages(); ?>
                </div>
            </article>
            <?php comments_page(); ?>
            <?php } ?>
        </div><!--/#content-->
    </div>
</section><!--/#page-->
    <!--<section id="task-content" class="blue-box">
    <div class="container">
    <div class="row">
    <div class="col-sm-12">
    <span class="circle-title">TASK <span class="small">FORCES</span></span>
                <?php
                $queryObject = new WP_Query( 'post_type=task&posts_per_page=4&orderby=date&order=ASC' );
                // The Loop!
                if ($queryObject->have_posts()) {
                    ?>
                    <?php
                    while ($queryObject->have_posts()) {
                        $queryObject->the_post();
                        ?>
                        <div class="col-sm-6">
                            <div class="col-sm-10 center task" style="margin: auto; float: none;">
                                <div class="icon"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.png"></div>
                                <h2><?php the_title(); ?></h2>
                                <p><?php the_content(); ?></p>
                                <a href="#">READ MORE</a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                }
                ?>
    </div>
    </div>
    </div>
    </section>-->
<?php get_footer();