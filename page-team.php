<?php
    /**
    * Template Name: Team
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
    <section id="team-content" class="white-box">
    <div class="container">
    <div class="row">
    <div class="col-sm-12">
                <?php
                $queryObject = new WP_Query( 'post_type=team&posts_per_page=4&orderby=date&order=DESC' );
                // The Loop!
                if ($queryObject->have_posts()) {
                    ?>
                    <?php
                    while ($queryObject->have_posts()) {
                        $queryObject->the_post();
                        ?>
                        <div class="col-sm-12 nopadding">
                            <div class="team">
                                <div class="col-sm-3"><div class="member"><?php the_post_thumbnail('medium'); ?></div></div>
                                <div class="col-sm-9"><h2><?php the_title(); ?></h2>
                                <p><?php the_content(); ?></p>
                                
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
    </section>
<?php get_footer();