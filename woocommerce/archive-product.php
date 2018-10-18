<?php $archive = get_queried_object();
	if (is_product_category($archive->name)): ?>

<?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(' » '); ?>


<div class="container" id="fp_root" data-cat="<?php echo $archive->term_id; ?>"></div>
<?php else: 
	woocommerce_content();
endif; ?>