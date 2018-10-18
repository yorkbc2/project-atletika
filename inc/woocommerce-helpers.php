<?php 

	if (!function_exists('get_current_product_price'))
	{
		function get_current_product_price(WC_Product $product)
		{
			$price = $product->get_sale_price();
			if (!$price)
			{
				return $product->get_regular_price();
			}
			return $price;
		}
	}

?>