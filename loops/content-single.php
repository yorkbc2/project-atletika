<?php
/**
 * The Single Posts Loop
 * =====================
 */
?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article id="post_<?php the_ID() ?>" <?php post_class() ?>>
        <header>
            <h1 class="single-title"><?php the_title() ?></h1>
        </header>
        <div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>
        <section>
            <?php the_content() ?>
            <?php wp_link_pages(); ?>
        </section>
    </article>
    <div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>
    <hr>
    <div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>
    <?php comments_template('/loops/comments.php'); ?>
<?php endwhile; ?>

<?php else : ?>
    <?php get_template_part('loops/content', 'none'); ?>
<?php endif; ?>
