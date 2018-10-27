<?php get_header(); ?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
        <?php if (!is_front_page() && function_exists('kama_breadcrumbs')) kama_breadcrumbs(' » '); ?>
        <?php get_template_part('loops/content', 'single'); ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
        <?php dynamic_sidebar('sidebar-widget-area2'); ?>
    </div>
</div><!-- /.row -->

<?php get_footer(); ?>
