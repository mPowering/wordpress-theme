<?php
    /**
    * Template Name: Contact Form
    */
    get_header();?>
  <?php
    $page = get_queried_object();

    $ID = $page->ID;

    $title = $page->post_title;
    $sub_title = get_post_meta($ID, 'page_subtitle', true);
    if ($sub_title){
      echo'<section id="title" class="emerald-home"><div class="container"><div class="row"><div class="col-sm-12"><p>'.$sub_title.'</p></div></div></div></section>';
    }
   ?>
    <section id="contact-us">
        <div class="container">
            <div class="row">
                <div id="content" class="site-content col-md-12>" role="main">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <?php the_post(); ?>
                            <?php the_content(); ?>
                        </div>
                        <div class="col-md-6">
                            <h2><?php _e('Our Location', ZEETEXTDOMAIN); ?></h2>
                            <iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                         src="https://maps.google.com.au/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo zee_option('zee_contact_map_location');?>&amp;aq=0&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo zee_option('zee_contact_map_location');?>&amp;t=m&amp;output=embed"></iframe>
                        </div>
                    </div>
                </div><!--/#content-->
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#contact-us-->

    <?php get_footer(); ?>