<?php 
		if (!function_exists('reviews_custom_post'))
		{
			/**
			 * Reviews are the custom type post
			 * Description:
			 * - Title is the author's name
			 * - Content is the review
			 * - Thumbnail is the author's image (avatar)
			 * - Postmeta position (TODO) is the job position of author
			 * @return void 
			 */
			function reviews_custom_post()
			{
				
				$labels = array(
					'name' => 'Отзывы',
					'singular_name' => 'Отзыв'
				);

				$args = array(
					'labels' => $labels,
					'public' => true,
					'hierarchical' => true,
					'has_archive' => true,
					'supports' => ['title', 'editor', 'custom-fields', 'thumbnail']
				);

				register_post_type('review', $args);

			}

			add_action( 'init', 'reviews_custom_post' );
		}
?>