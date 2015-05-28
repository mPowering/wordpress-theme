<?php
/**
 * The main template file.
 *
 * Template Name: SiriusXM
 * @package Real Life
 */
get_header(); ?>
		<div id="content" class="container">
			<div class="gutter clearfix">
			    <div class="load-ajax-image-top"><img src="<?php bloginfo( 'template_url' ); ?>/images/loadajax.gif" /></div>
			    <div id="productzone">
				<?php
                $special_offer = 'null';
				query_posts(array('post_type' => 'sirius-xm', 'orderby'=> 'date', 'order'=> 'DESC', 'posts_per_page' => 1));
				while (have_posts()) : the_post();
				$listen_share = get_post_meta($post->ID, 'listen_share', true);
				$listen_url = get_post_meta($post->ID, 'listen_url', true);
				$pdf_link = get_post_meta($post->ID, 'pdf_link', true);
				$products = get_post_meta($post->ID, 'products', true);
				$related_listen = get_post_meta($post->ID, 'related_listen', true);
				$c_listen_id = $post->ID;
				$special_offer = get_post_meta($post->ID, 'special_offer', true);
				$custom_fields = get_post_custom($special_offer);
				$thum = get_post_meta($special_offer, '_thumbnail_id', true);
				$scripture_reference = get_post_meta($post->ID, 'scripture_reference', true);
				$date_listen = get_post_meta($post->ID, 'date_listen', true);
				$dvd_purchase_url = get_post_meta($post->ID, 'dvd_purchase_url', true);
				$unique_code = get_post_meta($post->ID, 'unique_code', true);
				?>
				<div class="watchblock clearfix">
					<div class="leftside">
						<div class="videoblock gutter">
						     <div class="bglisten sirius">
							      <div class="block-text-listen" style="padding: 75px 0 0 20px;">
								       <h1><?php the_title(); ?> <?php if(strlen($scripture_reference)>0)  { echo '<br><span>'.$scripture_reference.'</span>'; }?></h1>
									   <p><?php echo strip_tags(get_post_field('post_content', $_POST['curentselect'])); ?>
									   <?php if(strlen($unique_code)>0) { ?>(<?php echo $unique_code; ?>)<?php } ?>
									   </p>
								  </div>
								  <div class="block-bottom-listen">
								      <div class="block-download-listen"><a href="http://originserver.calvarycch.org/realradio/<?php echo $listen_url; ?>.mp3">Download MP3</a></div>
									  <?php if(strlen($dvd_purchase_url)>0) {?>
									  <div class="block-addblockvpurchase-listen">
									 	  <a class="addtocart" href="<?php echo $dvd_purchase_url; ?>">PURCHASE</a>
									  </div>&nbsp;&nbsp;&nbsp;
                                      <?php } ?>
                                      <?php if(strlen($pdf_link)>0) {?>
                                      <div class="block-download-listen">
									 	  <a target="_blank" href="<?php echo $pdf_link; ?>">Notes</a>
									  </div>
                                      <?php } ?>
									  <div class="block-relevated-listen">
										<?php if(strlen($related_listen[0])>0){ ?>
										<form class="searchform" action="#" method="post" enctype="multipart/form-data">
											<select class="styled selectsiriuspart" name="relatedbroad">
													<option value="0">Related Audio</option>
												<?php
												$count_prod = sizeof($related_listen);
												foreach($related_listen as $v) {
												?>
													<option value="<?php echo $v; ?>"><?= get_the_title($v); ?></option>
												<?php } ?>
											</select> <!--  END styled  -->
										</form> <!--  END searchform  -->
										<?php } ?>
									  </div>
									  <div class="block-share-listen">
										<p class="share">Share
											<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><img src="<?php bloginfo( 'template_url' ); ?>/images/share/facebook.png" alt="facebook" /></a>
											<a href="mailto:?subject=Check this video!&body=<?php the_permalink(); ?>"><img src="<?php bloginfo( 'template_url' ); ?>/images/share/mail-01.png" alt="mail" /></a>
										</p>
							          </div>
									  <div class="clear"></div>
								  </div>
							      <div class="block-player-listen">
									<?php if(strlen($listen_url)>0) { ?>
										 <?php echo do_shortcode('[audio src="http://originserver.calvarycch.org/realradio/'.$listen_url.'.mp3"][/audio]'); ?>
									<?php }  ?>
								  </div>
							 </div>
						</div> <!--  END videoblock gutter  -->
					</div> <!--  END leftside  -->
					<?php
					if($special_offer=='') {
					?>
					<div class="rightside">
							<div class="gutterlisten">
								<?php if ( of_get_option('special_offer_images_sirius') ) { ?>
								   <a class="logo" href="<?php echo of_get_option('special_offer_link_sirius'); ?>"><img src="<?php echo of_get_option('special_offer_images_sirius'); ?>" /></a>
								<?php } ?>
							</div> <!--  END gutter  -->
					</div> <!--  END rightside  -->

					<?php
                    }else {?>
						<?php
						$i=0;
						$count_prod = sizeof($special_offer);
                        $current = time();
                        $current = date('Ymd',$current);;
						foreach($special_offer as $v) {
						$i++;
						//$thum = get_post_meta($v, '_thumbnail_id', true);
                        $url = wp_get_attachment_url( get_post_thumbnail_id($v, 'shop_catalog') );
						$custom_fields = get_post_custom($v);
                        if(get_field('use_range_date')){
                        $start = get_field('start_date');
                        $end = get_field('finish_date');
                        if(($current >= $start) && ($current <= $end)){ ?>
        					<div class="rightside">
        						<div class="gutterlisten">
        							<h1>SPECIAL OFFER</h1>
                                    <img style="max-height: 150px;" src="<?php echo $url; ?>" />
        							<h4><?php echo get_the_title($v); ?></h4>
        							<p><?php echo substr(strip_tags(get_post_field('post_content', $v)),0,140) ?></p>
        							<div class="addblock">
        									<!--<a href="<?php echo esc_url(home_url('/')); ?>product/donate-receive-world-going-dvd" class="addtocart">Donate Any Amount</a>-->
                                            <a href="http://reallifewithjackhibbs.org/product/special-offer?donate=<?php echo $v;?>" class="addtocart">Donate Any Amount</a>
        							</div>
        						</div> <!--  END gutter  -->
        					</div> <!--  END rightside  -->
                        <?php }else { ?>
					<div class="rightside">
							<div class="gutterlisten">
								<?php if ( of_get_option('special_offer_images_sirius') ) { ?>
								   <a class="logo" href="<?php echo of_get_option('special_offer_link_sirius'); ?>"><img src="<?php echo of_get_option('special_offer_images_sirius'); ?>" /></a>
								<?php } ?>
							</div> <!--  END gutter  -->
					</div> <!--  END rightside  -->
                        <?php }
                        }else { ?>
					<div class="rightside">
						<div class="gutterlisten">
							<h1>SPECIAL OFFER</h1>
                            <img style="max-height: 150px;" src="<?php echo $url; ?>" />
							<h4><?php echo get_the_title($v); ?></h4>
							<p><?php echo substr(strip_tags(get_post_field('post_content', $v)),0,140) ?></p>
							<div class="addblock">
									<!--<a href="<?php echo esc_url(home_url('/')); ?>product/donate-receive-world-going-dvd" class="addtocart">Donate Any Amount</a>-->
                                    <a href="http://reallifewithjackhibbs.org/product/special-offer?donate=<?php echo $v;?>" class="addtocart">Donate Any Amount</a>
							</div>
						</div> <!--  END gutter  -->
					</div> <!--  END rightside  -->
                        <?php }
						?>
						<?php } ?>
					<?php } ?>
				</div> <!--  END watchblock clearfix  -->
				<?php endwhile; wp_reset_query(); ?>
				<?php if(strlen($products[0])>0){ ?>
				<div class="gutter" style="width: 66%; float: left;">
					<div class="blueblock">
						<?php
						$i=0;
						$count_prod = sizeof($products);
						foreach($products as $v) {
						$i++;
						$thum = get_post_meta($v, '_thumbnail_id', true);
						$custom_fields = get_post_custom($v);
						?>
							<div class="bannerblock clearfix">
								<?php
								if($i==1 and $count_prod==1) { ?><p class="largetitle" style="width: 100%; margin-bottom: 15px;">Related Resource</p> <?php }
								else if($i==1 and $count_prod>1) { ?><p class="largetitle" style="width: 100%; margin-bottom: 15px;">Related Resources</p> <?php }
								else { ?><div class="addlineborder" style="width: 100%; margin-top: 10px;"></div>
								<?php } ?>
								<div class="bannericon">
									<img class="fullwidth" src="<?php echo get_option('home'); ?>/wp-content/uploads/<?php echo get_post_meta($thum, '_wp_attached_file', true); ?>" alt="" />
								</div> <!--  END bannericon  -->
								<div class="bannerdescr" style="width: 80%; margin-top: 0;">
									<h4><a href="<?php echo get_permalink($v); ?>"><?= get_the_title($v); ?></a></h4>
									<p><?php echo substr(strip_tags(get_post_field('post_content', $v)),0,200) ?></p>
								<div class="addblock" style="width: 100%; text-align: right;display: table; margin-bottom: 10px; margin-top: 10px;">
									<p class="price" style="display: inline;margin: 0 20px 0 0;vertical-align: bottom;">$<?php echo $custom_fields['_regular_price'][0]; ?></p>
									<?php/*<a class="addtocart" href="<?php echo esc_url(home_url('/')); ?>cart?add-to-cart=<?php echo $v; ?>">add to cart</a>*/?>
									<a style="display: inline-block;font-size: 16px;font-weight: bold;margin-top: 5px;padding: 7px 10px;vertical-align: top;"  href="/shop?add-to-cart=<?php echo $v; ?>" rel="nofollow" data-product_id="<?php echo $v; ?>"  data-quantity="1" class="addtocart button add_to_cart_button product_type_simple">Add to cart</a>
								</div> <!--  END addblock  -->
								</div> <!--  END bannerdescr  -->
							</div> <!--  END bannerblock clearfix  -->
						<?php } ?>
					</div> <!--  END blueblock  -->
				</div> <!--  END gutter  -->
				<?php } ?>
				</div>
                <div style="margin-right: 35px;"><?php get_sidebar(); ?></div>
				<div class="clearfix" style="float: left;width: 68%;">
					<section class="pagesection pslisten" style="width: 100%;">
						<div class="gutter">
							<h5>Real Radio Sirius</h5>
							<div class="categoryblock clearfix">
								<div class="leftside">
								    <div id="topcateg" class="category-list-watch">All Categories</div>
									<ul class="categories">
									    <li class="current-menu-item category-list-listen"><a href="javascript:void(0)">All Categories<input type="hidden" value="0"/></a></li>
										<?php
										query_posts(array('post_type' => 'category', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1));
										while (have_posts()) : the_post();
										?>
										<li class="category-list-listen"><a href="javascript:void(0)"><?php the_title(); ?><input type="hidden" value="<?php echo $post->ID; ?>"/></a></li>
										<?php endwhile; wp_reset_query(); ?>
									</ul> <!--  END categories  -->
								</div> <!--  END leftside  -->
								<div class="rightside">
								    <div class="load-ajax-image"><img src="<?php bloginfo( 'template_url' ); ?>/images/loadajax.gif" /></div>
									<div id="categzone">
										<ul class="postslist">
											<?php
											query_posts(array('post_type' => 'sirius-xm', 'orderby'=> 'date', 'order'=> 'DESC', 'posts_per_page' => 15, 'paged' => 1));
											while (have_posts()) : the_post();
											$scripture_reference = get_post_meta($post->ID, 'scripture_reference', true);
											?>
											<li>
											   <a href="javascript:void(0)" onclick="addsiriustop(<?php echo $post->ID; ?>)"><?php the_title(); ?></a>
											   <span class="postscripture" style="right: 100px;"><?php if(strlen($scripture_reference)>0)  { echo '<span>'.$scripture_reference.'</span>'; }?></span>
											   <span class="postdate" style="position: absolute; right: 5px;"><?php the_time( get_option( 'date_format' ) ); ?></span>
											</li>
											<?php
											endwhile;
											query_posts(array('post_type' => 'sirius-xm', 'orderby'=> 'date', 'order'=> 'DESC', 'posts_per_page' => -1));
											$o=0;
											while (have_posts()) : the_post();  $o++; endwhile;
											$number_page = ceil($o/15);
											?>
										</ul> <!--  END postslist  -->
										<?php if($o>15) {?>
										<p class="pagination">
											<a class="prev" onclick="siriuspaginate(1,0)" href="javascript:void(0)">First</a>
											<?php for($y=1; $y<=2; $y++) { ?>
												 <a <?php if(1==$y) :?> class="first" <?php endif;?>  href="javascript:void(0)" onclick="siriuspaginate(<?php echo $y; ?>,0)"><?php echo $y; ?></a>
											<?php } ?>
										    <?php if($number_page>3) { ?>
											<a href="javascript:void(0)" onclick="siriuspaginate(4,0)"> > </a>
											<?php } ?>
											<a class="next" onclick="siriuspaginate(<?php echo $number_page; ?>,0)" href="javascript:void(0)">Last</a>
										</p>
										<?php }?>
									</div>
								</div> <!--  END rightside  -->
							</div> <!--  END categoryblock clearfix  -->
						</div> <!--  END gutter  -->
					</section> <!--  END pagesection  -->
				</div> <!--  END clearfix  -->
			</div> <!--  END gutter clearfix  -->
		</div> <!--  END content container  -->
<?php get_footer(); ?>