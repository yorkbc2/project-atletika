<?php get_header(); ?>

<?php 
	if ( is_singular( 'product' ) ) {
	     woocommerce_content();
	  }else{
	   //For ANY product archive.
	   //Product taxonomy, product search or /shop landing
	    if (!is_shop())
	    	woocommerce_get_template( 'archive-product.php' );
	  	else
	  		woocommerce_get_template( 'shop-page.php' );
	  }
?>

<?php get_footer(); ?>
