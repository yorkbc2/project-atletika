<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
		if (!function_exists('products_get_query'))
		{
			function products_get_query($cat=0)
			{
				$query = new WP_Query([
					'post_type' => 'product',
					'posts_per_page' => 300,
					'post_status' => 'publish',
					'orderby' => 'date',
					'order' => 'DESC',
					'tax_query' => array(
				        array(
				            'taxonomy'      => 'product_cat',
				            'field' => 'term_id',
				            'terms'         => array($cat),
				            'operator'      => 'IN'
				        ),
				        array(
				            'taxonomy'      => 'product_visibility',
				            'field'         => 'slug',
				            'terms'         => 'exclude-from-catalog',
				            'operator'      => 'NOT IN'
				        )
				    )
				]);

				if ($query->have_posts())
					return $query;
				else
					return false;
			}
		}

	if (!function_exists('products_get_filters')) {
		function products_get_filters($cat=0) {
			$result = [];

			if ($query = products_get_query($cat))
			{
				foreach ($query->posts as $post) {
					$product = wc_get_product($post);
					$attributes = $product->get_attributes();

					foreach ($attributes as $index=>$attribute)
					{

						$label = wc_attribute_label($index);

						if (!isset($result[$index]))
						{
							$result[$index] = [
								'name' => $attr_label,
								'slug' => $index,
								'items' => []
							];	
						}

						foreach ($attribute['options'] as $option)
						{
							$term = get_term($option)->name;
							if (isset($result[$index]['items'][$option]))
							{
								$result[$index]['items'][$option]['count'] += 1;
							}
							else
							{
								$result[$index]['items'][$option] = [
									'count' => 1,
									'value' => $term
								];
							}
						}

					}
					
				}
				foreach ($result as $key=>$filter) {
					$items = $filter['items'];
					usort($items, function($a, $b) {
						$_a = floatval(str_replace(',', '.', $a['value']));
						$_b = floatval(str_replace(',', '.', $b['value']));
						if ($_a == 0 && $_b == 0)
						{
							return strcmp($a['value'], $b['value']);
						}
					  return $_a > $_b? 1: 0;
					});
					$result[$key]['items'] = $items;
				}
				return $result;
			}
		}
	}

	if (!function_exists('route_filters'))
	{
		function route_filters (WP_REST_Request $req) {
			$cat = 0;

			if (isset($_GET['cat']))
			{
				$cat = $_GET['cat'];
			}

			return products_get_filters($cat);
		}
	}

	if (!function_exists('products_get_products'))
	{
		function products_get_products($cat=0)
		{
			$result = [
				'products' => []
			];
			if ($query = products_get_query($cat))
			{
				foreach ($query->posts as $index=>$post)
				{

					$product = wc_get_product($post);
					$attributes = $product->get_attributes();
					$thumbnail = get_the_post_thumbnail_url($product->get_id(), 'medium');

					$file_headers = @get_headers($thumbnail);
					if ($thumbnail != '' && $file_headers[0] != 'HTTP/1.0 404 Not Found')
					{
						list($width, $height) = getimagesize($thumbnail);
						if ($height > $width)
						{
							$thumbnail = get_the_post_thumbnail_url($product->get_id(), 'large');
						}	
					}
					
					$is_variable = $product->is_type('variable');
					if ($is_variable)
					{
						$variations = $product->get_available_variations();
						if (isset($variations[0]))
						{
							$product_price = intval($variations[0]['display_price']);
						}
						else
						{
							$product_price = 0;
						}
					}
					else
					{
						$product_price = get_current_product_price($product);
					}

					if (!$thumbnail)
						$thumbnail = '/wp-content/plugins/woocommerce/assets/images/placeholder.png';

					$date = $product->get_date_created();

					$result['products'][$index] = [
						'ID' => $product->get_id(),
						'name' => $product->get_name(),
						'price' => intval($product_price),
						'regular_price' => intval($product->get_regular_price()),
						'thumbnail' => $thumbnail,
						'link' => $product->get_permalink(),
						'type' => ($is_variable? 'variable': 'single'),
						'is_on_sale' => ($product->is_on_sale()? 'sale': 'regular'),
						'attributes' => [],
						'date_created' => $date->getTimestamp()
					];
					if (!isset($result['minPrice']))
					{
						$result['minPrice'] = $product_price;
					}
					else if ((isset($result['minPrice']) && $result['minPrice'] > $product_price) || $result['minPrice'] == '')
					{
						$result['minPrice'] = $product_price;
					}
					if (!isset($result['maxPrice']))
					{
						$result['maxPrice'] = $product_price;
					}
					else if (isset($result['maxPrice']) && $result['maxPrice'] < $product_price)
					{
						$result['maxPrice'] = $product_price;
					}	

					foreach ($attributes as $key=>$attribute)
					{
						$attr_label = wc_attribute_label($key);

						$result['products'][$index]['attributes'][$key] = [
							'name' => $attr_label,
							'slug' => $key,
							'values' => []
						];

						foreach ($attribute['options'] as $option)
						{
							$term = get_term($option)->name;
							$result['products'][$index]['attributes'][$key]['values'][] = $term;
						}
					}	

					// END FOREACH
				}
			}
			return $result;
		}
	}

	if (!function_exists('route_products'))
	{
		function route_products (WP_REST_Request $req) {
			$cat = 0;

			if (isset($_GET['cat']))
			{
				$cat = $_GET['cat'];
			}

			return products_get_products($cat);
		}
	}

	if (!function_exists('products_getter_rest'))
	{
		function products_getter_rest(WP_REST_Request $req)
		{
			if (isset($_GET['cat']))
			{
				$result = [
					'filters' => [],
					'products' => []
				];
				$cat = $_GET['cat'];
				if (isset($_GET['page']))
				{
					$page = $_GET['page'];
				}

				$category = get_term($cat, 'product_cat');

				$result['name'] = $category->name;

				$query = new WP_Query([
					'post_type' => 'product',
					'posts_per_page' => 300,
					'post_status' => 'publish',
					'orderby' => 'date',
					'order' => 'DESC',
					'tax_query' => array(
				        array(
				            'taxonomy'      => 'product_cat',
				            'field' => 'term_id',
				            'terms'         => array($cat),
				            'operator'      => 'IN'
				        ),
				        array(
				            'taxonomy'      => 'product_visibility',
				            'field'         => 'slug',
				            'terms'         => 'exclude-from-catalog',
				            'operator'      => 'NOT IN'
				        )
				    )
				]);

				foreach ($query->posts as $index=>$post)
				{
					$product = wc_get_product($post);
					$attributes = $product->get_attributes();
					$thumbnail = get_the_post_thumbnail_url($product->get_id(), 'medium');
					$file_headers = @get_headers($thumbnail);
					if ($thumbnail != '' && $file_headers[0] != 'HTTP/1.0 404 Not Found')
					{
						list($width, $height) = getimagesize($thumbnail);
						if ($height > $width)
						{
							$thumbnail = get_the_post_thumbnail_url($product->get_id(), 'large');
						}	
					}
					
					$is_variable = $product->is_type('variable');
					if ($is_variable)
					{
						$variations = $product->get_available_variations();
						if (isset($variations[0]))
						{
							$product_price = intval($variations[0]['display_price']);
						}
						else
						{
							$product_price = 0;
						}
					}
					else
					{
						$product_price = get_current_product_price($product);
					}

					if (!$thumbnail)
						$thumbnail = '/wp-content/plugins/woocommerce/assets/images/placeholder.png';

					$date = $product->get_date_created();

					$result['products'][$index] = [
						'ID' => $product->get_id(),
						'name' => $product->get_name(),
						'price' => intval($product_price),
						'regular_price' => intval($product->get_regular_price()),
						'thumbnail' => $thumbnail,
						'link' => $product->get_permalink(),
						'type' => ($is_variable? 'variable': 'single'),
						'is_on_sale' => ($product->is_on_sale()? 'sale': 'regular'),
						'attributes' => [],
						'date_created' => $date->getTimestamp()
					];
					if (!isset($result['minPrice']))
					{
						$result['minPrice'] = $product_price;
					}
					else if ((isset($result['minPrice']) && $result['minPrice'] > $product_price) || $result['minPrice'] == '')
					{
						$result['minPrice'] = $product_price;
					}
					if (!isset($result['maxPrice']))
					{
						$result['maxPrice'] = $product_price;
					}
					else if (isset($result['maxPrice']) && $result['maxPrice'] < $product_price)
					{
						$result['maxPrice'] = $product_price;
					}

					foreach ($attributes as $key=>$attribute)
					{

						$attr_label = wc_attribute_label($key);

						if (!isset($result['filters'][$key]))
						{
							$result['filters'][$key] = [
								'name' => $attr_label,
								'slug' => $key,
								'items' => []
							];
						}

						$result['products'][$index]['attributes'][$key] = [
							'name' => $attr_label,
							'slug' => $key,
							'values' => []
						];

						foreach ($attribute['options'] as $option)
						{
							$term = get_term($option)->name;
							if (isset($result['filters'][$key]['items'][$option]))
							{
								$result['filters'][$key]['items'][$option]['count'] += 1;
							}
							else
							{
								$result['filters'][$key]['items'][$option] = [
									'count' => 1,
									'value' => $term
								];
							}
							$result['products'][$index]['attributes'][$key]['values'][] = $term;
						}
					}	
				}
			}
			foreach ($result['filters'] as $key=>$filter) {
				$items = $filter['items'];
				usort($items, function($a, $b) {
					$_a = floatval(str_replace(',', '.', $a['value']));
					$_b = floatval(str_replace(',', '.', $b['value']));
					if ($_a == 0 && $_b == 0)
					{
						return strcmp($a['value'], $b['value']);
					}
				  return $_a > $_b? 1: 0;
				});
				$result['filters'][$key]['items'] = $items;
			}
			return $result;
		}
	}

	add_action('rest_api_init', function()
	{
		register_rest_route( 'brainworks', 'goods', array(
			'methods' => "GET",
			'callback' => 'route_products'
		));
		register_rest_route( 'brainworks', 'products', array(
			'methods' => "GET",
			'callback' => 'products_getter_rest'
		));
		register_rest_route( 'brainworks', 'filters', array(
			'methods' => "GET",
			'callback' => 'route_filters'
		));
	});

?>