<?php
    /**
    * Template Name: Partners
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
    <section id="partner-content" class="white-box">
    <div class="container">
    <div class="row">
    <div class="col-sm-12">
                <?php
                $queryObject = new WP_Query( 'post_type=partner&posts_per_page=-1&orderby=date&order=DESC' );
                // The Loop!
                if ($queryObject->have_posts()) {
                    ?>
                    <?php
                    while ($queryObject->have_posts()) {
                        $queryObject->the_post();
                        ?>
                        <div class="col-sm-6">
                            <div class="col-sm-10 center partner" style="margin: auto; float: none;">
                                <div class="member"><?php the_post_thumbnail('medium'); ?></div>
                            <div class="more-less">
                            	<div class="more-block" style="height: 80px; overflow: hidden;">
                                  <?php the_content(); ?>
                            	</div>
                         	</div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                }
                ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(function(){

// The height of the content block when it's not expanded
var adjustheight = 95;
// The "more" link text
var moreText = "Read More";
// The "less" link text
var lessText = "See Less";

// Sets the .more-block div to the specified height and hides any content that overflows
$(".more-less .more-block").css('height', adjustheight).css('overflow', 'hidden');

// The section added to the bottom of the "more-less" div
$(".more-less").append('<p class="continued">[&hellip;]</p><span class="button-content"><a href="#" class="adjust more"></a></span>');

$("a.adjust").text(moreText);

$(".adjust").toggle(function() {
		$(this).parents("div:first").find(".more-block").css('height', 'auto').css('overflow', 'visible');
		// Hide the [...] when expanded
		$(this).parents("div:first").find("p.continued").css('display', 'none');
		$(this).text(lessText);
	}, function() {
		$(this).parents("div:first").find(".more-block").css('height', adjustheight).css('overflow', 'hidden');
		$(this).parents("div:first").find("p.continued").css('display', 'block');
		$(this).text(moreText);
});
});

</script>
    </div>
    </div>
    </div>
    </section>
<?php get_footer();