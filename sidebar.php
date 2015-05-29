    <div id="sidebar" class="col-md-4" role="complementary">
        <div class="sidebar-inner">
            <aside class="widget-area">

    <p class="buble-title">Latest<br/>Posts</p>
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