<?php
    /**
    * Template Name: Resources
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
        <div class="box-resource">
            <h2 style="color:#"><a href="<?php echo get_bloginfo('url') ?>/resources/reports" title="Reports and Documents"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_reports.png"><span>Reports and Documents</span></a></h2>
              <?php
              $queryObject = new WP_Query( 'post_type=reports&posts_per_page=4&orderby=date&order=DESC' );
              // The Loop!
              if ($queryObject->have_posts()) {
                  ?>
                  <?php
                  while ($queryObject->have_posts()) {
                      $queryObject->the_post();
                      ?>
                        <div class="col-sm-12 blog" style="margin-bottom: 25px; padding-bottom: 25px;">
                        <div class="col-sm-12 nopadding" style="margin-bottom: 15px;"><div class="col-sm-3 nopadding"><a href="<?php the_field('file'); ?>"><img alt="" src="<?php the_field('icon'); ?>"></a></div></div>
                        <h3 class="entry-title">
                            <div class="date-post">
                            <span class="day-post"><?php echo get_the_date('d'); ?></span>
                            <span class="month-post"><?php echo get_the_date('M'); ?></span>
                            </div>
                            <a href="<?php the_field('file'); ?>" rel="bookmark"><?php the_title(); ?></a>
                            <?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
                            <sup class="featured-post"><?php _e( 'Sticky', ZEETEXTDOMAIN ) ?></sup>



                            <?php } ?>
                            <?php edit_post_link( __( 'Edit', ZEETEXTDOMAIN ), '<small class="edit-link pull-right">', '</small>' ); ?>
                        </h3>
                        <?php echo '<p>' . wp_trim_words( get_the_content(), 40 ) . '</p>'; ?>
                        </div>
                  <?php
                  }
                  ?>
                  <?php
              }
              ?>
          </div>

          <div class="box-resource">
            <h2><a href="<?php echo get_bloginfo('url') ?>/resources/videos" title="Videos"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_video2.png"><span>Videos</span></a></h2>
              <?php
              $queryObject = new WP_Query( 'post_type=videos&posts_per_page=2&orderby=date&order=DESC' );
              // The Loop!
              if ($queryObject->have_posts()) {
                  ?>
                  <?php
                  while ($queryObject->have_posts()) {
                      $queryObject->the_post();
                      ?>

                        <div class="col-sm-12 blog" style="margin-bottom: 25px; padding-bottom: 25px;">
                        <h3 class="entry-title">
                            <div class="date-post">
                            <span class="day-post"><?php echo get_the_date('d'); ?></span>
                            <span class="month-post"><?php echo get_the_date('M'); ?></span>
                            </div>
                            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                            <?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
                            <sup class="featured-post"><?php _e( 'Sticky', ZEETEXTDOMAIN ) ?></sup>



                            <?php } ?>
                            <?php edit_post_link( __( 'Edit', ZEETEXTDOMAIN ), '<small class="edit-link pull-right">', '</small>' ); ?>
                        </h3>
                        <div class="entry-content" >
                        	<div class="entry-thumbnail">
                                	<?php the_post_thumbnail(); ?>
                            	</div>
                            <?php echo '<p>' . wp_trim_words( get_the_content(), 50 ); ?>
                            <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"></a>
                             <?php echo '</p>'; ?>
                        </div>
                            <iframe height="260" src="<?php the_field('video_id'); ?>" frameborder="0" allowfullscreen style="width: 100%;"></iframe>
                        </div>
                  <?php
                  }
                  ?>
                  <?php
              }
              ?>
          </div>

        <div class="box-resource">
            <h2><a href="<?php echo get_bloginfo('url') ?>/resources/links" title="External Links"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_external.png"><span>External Links</span></a></h2>
              <?php
              $queryObject = new WP_Query( 'post_type=links&posts_per_page=3&orderby=date&order=DESC' );
              // The Loop!
              if ($queryObject->have_posts()) {
                  ?>
                  <?php
                  while ($queryObject->have_posts()) {
                      $queryObject->the_post();
                      ?>
                        <div class="col-sm-12 blog" style="margin-bottom: 25px; padding-bottom: 25px;">
                        <h3 class="entry-title">
                            <div class="date-post">
                            <span class="day-post"><?php echo get_the_date('d'); ?></span>
                            <span class="month-post"><?php echo get_the_date('M'); ?></span>
                            </div>
                            <a href="<?php the_field('link'); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                            <?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
                            <sup class="featured-post"><?php _e( 'Sticky', ZEETEXTDOMAIN ) ?></sup>



                            <?php } ?>
                            <?php edit_post_link( __( 'Edit', ZEETEXTDOMAIN ), '<small class="edit-link pull-right">', '</small>' ); ?>
                        </h3>
                        <div class="entry-content" >
                        	<div class="entry-thumbnail">
                                	<?php the_post_thumbnail(); ?>
                            	</div>
                            <?php echo '<p>' . wp_trim_words( get_the_content(), 50 ); ?>
                            <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"></a>
                             <?php echo '</p>'; ?>
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
    <div id="sidebar" class="col-md-4" role="complementary">
        <div class="sidebar-inner">
            <aside class="widget-area">

        <ul class="latest-resources">
            <li><a href="<?php echo get_bloginfo('url') ?>/resources/reports" title="Reports and Documents"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_reports.png"><span>Reports and Documents</span></a></li>
            <li><a href="<?php echo get_bloginfo('url') ?>/resources/videos" title="Videos"><img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_video2.png"><span>Videos</span></a></li>
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