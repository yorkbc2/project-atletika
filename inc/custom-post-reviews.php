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

			if (!function_exists('review_metabox'))
			{
				function review_metabox( $meta_boxes ) {
					$prefix = 'bw-';

					$meta_boxes[] = array(
						'id' => 'review_metabox',
						'title' => esc_html__( 'Мета-данные', 'brainworks' ),
						'post_types' => array('review' ),
						'context' => 'advanced',
						'priority' => 'default',
						'autosave' => 'false',
						'fields' => array(
							array(
								'id' => $prefix . 'socials',
								'type' => 'text',
								'name' => esc_html__( 'Соц. сети (Ссылка, ссылка, ссылка)', 'brainworks' ),
							),
							array(
								'id' => $prefix . 'position',
								'type' => 'text',
								'name' => esc_html__( 'Позиция на работе', 'brainworks' ),
							),
						),
					);

					return $meta_boxes;
				}
				add_filter( 'rwmb_meta_boxes', 'review_metabox' );
			}
		
?>