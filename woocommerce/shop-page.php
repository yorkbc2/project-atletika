<div class="sp-xs-4 sp-sm-4 sp-md-4 sp-lg-4 sp-xl-4"></div>
<h2 class="text-center">
	<?php _e('Магазин', 'brainworks'); ?>
</h2>
<div class="sp-xs-4 sp-sm-4 sp-md-4 sp-lg-4 sp-xl-4"></div>

<?php
	$categories = get_woocommerce_categories();

	if (count($categories) > 0):
		echo '<div class="row">';
		$rowCount = 0;
		foreach ($categories as $cat)
		{
			if ($cat->parent != 0):
				$thm_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
				$thm = wp_get_attachment_url($thm_id);
				
				?>
				
					<div class="col-md-3">
						<a href="<?php echo get_term_link( $cat->slug, 'product_cat' ); ?>" class="shop_item">
						<?php if ($thm): ?>
							<img src="<?php echo $thm; ?>" alt="<?php _e("Картинка не найдена", "brainworks"); ?>"
								title="<?php echo $cat->name; ?>">
						<?php endif; ?>
						<h3><?php echo $cat->name; ?></h3>
						</a>
					</div>

				<?php
				$rowCount++;
				if ($rowCount % 4 === 0) echo '</div><div class="row">';
			endif;
		}
		echo '</div>';

	else: ?>

<?php endif; ?>