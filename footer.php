<?php if(!is_page()) { ?>
</div><!--/#primary-->
</div><!--/.col-lg-12-->
</div><!--/.row-->
</div><!--/.container.-->
</section><!--/#main-->
<?php } ?>

  <?php if(zee_option('zee_theme_layout')=='boxed'){ ?>
    </div><!--/#boxed-->
  <?php } ?>

    <section id="home-content" class="graystrong-box" style="border-top: 1px solid #033f62;padding: 15px 0;">
    <div class="container">
    <div class="row">
    <div class="col-sm-12">
    <span class="copyright" style="margin-top: 15px;"><?php show_footer();?></span>
    </div>
    </div>
    </div>
    </section>

<?php google_analytics();?>

<?php wp_footer(); ?>

</body>
</html>