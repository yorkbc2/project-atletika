<?php
/**
 * The Search Loop
 * ===============
 */
?>

<div class="product_grid">
<?php if (have_posts()): while (have_posts()): the_post(); ?>
    <?php $product = wc_get_product(get_the_ID()); ?>
        <div class="product_item">
            <a href="<?php echo get_the_permalink(); ?>" class="product_item__link">
                <?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>      
                <h3><?php echo get_the_title(); ?></h3>
                <?php if ($product->is_on_sale()): ?>
                    <p class="product_item__price _sale">
                        <?php echo $product->get_regular_price() . ' грн.'; ?>
                    </p>
                <?php endif; ?>
                <p class="product_item__price">
                    <?php echo $product->get_price() . ' грн.'; ?>
                </p>
                <a href="<?php echo '?s='.$_GET['s'].'&add-to-cart=' . get_the_ID() ?>" 
                    class="button-medium product_type_simple add_to_cart_button ajax_add_to_cart" 
                    data-quantity={1}
                    data-product_id="<?php echo get_the_ID(); ?>"
                    data-product_sku
                    onclick="incrementBasketCount">
                    <?php _e("В корзину", "brainworks"); ?>
                </a>
            </a>
        </div>
<?php endwhile;    echo '</div>';
else: ?>
    <div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>
    <div class="alert alert-warning">
        <i class="fa fa-exclamation-triangle"></i> <?php _e('Sorry, your search yielded no results.', 'brainworks'); ?>
    </div>
<?php endif; ?>
