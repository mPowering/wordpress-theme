<?php
    /**
    * Template Name: Resources Reports and Documents
    */
get_header(); ?>
  <?php
    $page = get_queried_object();

    $ID = $page->ID;

    $title = $page->post_title;
    $sub_title = get_post_meta($ID, 'page_subtitle', true);
    if ($sub_title){
      echo'<section id="title" class="emerald-home"><div class="container"><div class="row"><div class="col-sm-12"><p>'.$sub_title.'</p></div></div></div></section>';
    }
   ?>
    <section id="resources-content" class="white-box">
    <img class="left-circle" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/left-circle.png">
    <img class="right-circle" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/right-circle.png">
    <div class="container">
    <div class="row">
    <div class="col-sm-8">

        <div class="box-resource noline">
            <h2><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_reports.png" style="display: inline-block;">Reports and Documents</h2>
              <?php
              $queryObject = new WP_Query( 'post_type=reports&posts_per_page=-1&orderby=date&order=DESC' );
              // The Loop!
              if ($queryObject->have_posts()) {
                  ?>
                  <?php
                  while ($queryObject->have_posts()) {
                      $queryObject->the_post();
                      ?>
                        <div class="col-sm-12 external">
                            <div class="col-sm-12 nopadding" style="margin-bottom: 15px;float: left;"><div class="col-sm-3 nopadding"><a href="<?php the_field('file'); ?>"><img alt="" src="<?php the_field('icon'); ?>"></a></div></div>
                            <div class="col-sm-12 nopadding"><h3><a href="<?php the_field('file'); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                            <span><?php echo get_the_date('d F y'); ?></span></div>
                        </div>
                  <?php
                  }
                  ?>
                  <?php
              }
              ?>
          </div>
    </div>
    <div id="sidebar" class="col-md-4" role="complementary">
        <div class="sidebar-inner">
            <aside class="widget-area">

    <p class="buble-title-r">Resources</p>
        <ul class="latest-resources">
            <li class="active"><a href="<?php echo get_bloginfo('url') ?>/resources/reports" title="Reports and Documents"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_reports.png"><span>Reports and Documents</span></a></li>
            <li><a href="<?php echo get_bloginfo('url') ?>/resources/videos" title="Videos"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_video.png"><span>Videos</span></a></li>
            <li><a href="<?php echo get_bloginfo('url') ?>/resources/links" title="External Links"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_external.png"><span>External Links</span></a></li>
        </ul>
    <br> <?php dynamic_sidebar( 'sidebar' ); ?>
            </aside>
        </div>
    </div>
    </div>
    </div>
    </section>
<?php get_footer();