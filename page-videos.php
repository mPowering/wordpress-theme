<?php
    /**
    * Template Name: Resources Videos
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
            <h2><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_video2.png" style="display: inline-block;">Videos</h2>
              <?php
              $queryObject = new WP_Query( 'post_type=videos&posts_per_page=-1&orderby=date&order=DESC' );
              // The Loop!
              if ($queryObject->have_posts()) {
                  ?>
                  <?php
                  while ($queryObject->have_posts()) {
                      $queryObject->the_post();
                      ?>
                        <div class="col-sm-12">
                            <h3><?php the_title(); ?></h3>
                            <?php echo '<p>' . wp_trim_words( get_the_content(), 40 ) . '</p>'; ?>
                            <span><?php echo get_the_date('d F y'); ?></span>
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 30px;">
                            <iframe width="620" height="350" src="<?php the_field('video_id'); ?>" frameborder="0" allowfullscreen></iframe>
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

        <ul class="latest-resources">
            <li><a href="<?php echo get_bloginfo('url') ?>/resources/reports" title="Reports and Documents"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_reports.png"><span>Reports and Documents</span></a></li>
            <li class="active"><a href="<?php echo get_bloginfo('url') ?>/resources/videos" title="Videos"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_video2.png"><span>Videos</span></a></li>
            <li><a href="<?php echo get_bloginfo('url') ?>/resources/links" title="External Links"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_external.png"><span>External Links</span></a></li>
            <li><a href="http://health-orb.org" title="ORB Platform"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ORB-for-website.png"><span>ORB Platform</span></a></li>
        </ul>
    <br> <?php dynamic_sidebar( 'sidebar' ); ?>
            </aside>
        </div>
    </div>
    </div>
    </div>
    </section>
<?php get_footer();